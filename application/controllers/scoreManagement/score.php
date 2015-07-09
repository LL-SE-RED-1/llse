<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Score extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('r7/FakeData_model', 'fake');
        $this->load->model('r7/ScoreClazz_model', 'scoreClazz');
        $this->load->model('r7/ScoreCommon_model', 'scoreCommon');
    }

    /**
     * get a certain class information
     * GET: classId 
     * @return some information about this class, 
     */
    public function classInfo() {
        $classID = $this->input->get('classId');
        if (empty($classID)) {
            $this->scoreCommon->error('参数不全');
            return;
        }
        $info = $this->fake->getClassInfo($classID);
        $info['isWithOnlineExam'] = $this->fake->isWithOnlineExam($classID);
        $this->scoreCommon->success($info);
    }

    /**
     * import scores from online exam subsystem.
     * only a class with online final exam can import
     * GET: classId
     */
    public function import() {
        $classID = $this->input->get('classId');
        if (empty($classID)) {
            $this->scoreCommon->error('参数不全');
            return;
        }
        if (!$this->fake->isWithOnlineExam($classID)) {
            $this->scoreCommon->error('本班级没有在线考试成绩');
            return;
        }
        //TODO: get data from online exam subsystem.
        $this->scoreCommon->success();
    }

    /**
     * 根据当前教学班的所有学生信息下载需要教师填写的成绩表格
     * 表格已经被程序进行了一定排版要求，具体填写方式在页面上提示
     * GET: classId
     * @return 下载一个xlsx 文件
     */
    public function downloadExcel() {
        $classID = $this->input->get('classId');
        if (empty($classID)) {
            $this->scoreCommon->error('参数不全');
            return;
        }
        $students = $this->fake->getStudentFromClass($classID);

        require_once 'PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex();

        $title = array('学号', '姓名', '成绩（百分制）', '是否缺考（填写y表示缺考）');
        for ($i = 0; $i != 4; ++$i)
            $objPHPExcel->getActiveSheet()->setCellValue(chr(ord('A') + $i) . '1', $title[$i]);
        for ($i = 0; $i != count($students); ++$i) {
            $objPHPExcel->getActiveSheet()->setCellValue(
                'A' . (2 + $i), $students[$i]['studentID']
            );
            $objPHPExcel->getActiveSheet()->setCellValue(
                'B' . (2 + $i), $students[$i]['studentName']
            );
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"{$classID}.xlsx\"");
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    /**
     * 提交excel表格，里面有成绩，格式已经在前面生成好
     * POST: classID, excel file
     * 返回解析好的excel表格
     */
    public function uploadExcel() {
        $classID = $this->input->post('classId');
        if (empty($classID)) {
            $this->scoreCommon->error('参数不全');
            return;
        }
        if (!isset($_FILES['excel'])) {
            $this->scoreCommon->error('请选择excel文件');
            return;
        }
        require_once 'PHPExcel/IOFactory.php';
        if (!file_exists($_FILES['excel']['tmp_name'])) {
            $this->scoreCommon->error('文件上传失败，请重试');
            return;
        }

        // change students to key(studentID) => name, covered
        $students = array();
        foreach ($this->fake->getStudentFromClass($classID) as $s)
            $students[$s['studentID']] = array(
                'studentName' => $s['studentName'],
                'covered' => 0
            );

        //read excel and load into array
        $arr = array();
        $objPHPExcel = PHPExcel_IOFactory::load($_FILES['excel']['tmp_name']);
        $objPHPExcel->setActiveSheetIndex(0);
        $keys = array('studentId', 'studentName', 'score', 'isAbsent');
        foreach ($objPHPExcel->getActiveSheet()->getRowIterator() as $row) {
            $tmp = array();
            $index = 0;
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            foreach($cellIterator as $cell)
                $tmp[$keys[$index++]] = $cell->getCalculatedValue();
            $tmp['studentId'] = strval($tmp['studentId']);
            // is absnet?
            $tmp['isAbsent'] = strtolower($tmp['isAbsent']) === 'y' ? 'true' : 'false';
            $tmp['grade'] = $this->scoreCommon->calculateGrade($tmp['score'], $tmp['isAbsent']);
            $arr[] = $tmp;
        }
        //remove the first row:title
        unset($arr[0]);
        $arr = array_values($arr);

        if (count($arr) != count($students)) {
            $this->scoreCommon->error('有学生成绩重复或未提交，请重新下载excel填写');
            return;
        }

        foreach ($arr as $score)
            if (isset($students[$score['studentId']]))
                $students[$score['studentId']]['covered']++;
        foreach ($students as $s)
            if ($s['covered'] != 1) {
                $this->scoreCommon->error('有学生成绩重复或未提交，请重新下载excel填写');
                return;
            }
        $this->scoreCommon->success($arr);
    }

    /**
     * 确认提交本班的最终成绩
     * POST: classId, scores json encoded
     * 成功则没有返回数据，失败会返回原因
     */
    public function commit() {
        $classID = $this->input->post('classId');
        $scores = json_decode($this->input->post('score'), true);
        if (empty($classID) || empty($scores)) {
            $this->scoreCommon->error('参数不全');
            return;
        }
        //检查有没有已经提交过了
        if ($this->scoreClazz->isSubmitted($classID)) {
            $this->scoreCommon->error('本班成绩已经提交过，无法重复提交');
            return;
        }
        // 检查有没有漏掉学生
        $students = array();
        foreach ($this->fake->getStudentFromClass($classID) as $s)
            $students[$s['studentID']] = array(
                'studentName' => $s['studentName'],
                'covered'     => 0
            );
        if (count($students) != count($scores)) {
            $this->scoreCommon->error('有学生成绩重复或未提交');
            return;
        }
        foreach ($scores as $index => $s) {
            $scores[$index]['isAbsent'] = ($s['isAbsent'] === 'true' || $s['isAbsent'] === true);
            if (isset($students[$s['studentId']]))
                $students[$s['studentId']]['covered']++;
        }
        foreach ($students as $s)
            if ($s['covered'] != 1) {
                $this->scoreCommon->error('有学生成绩重复或未提交');
                return;
            }
        if (!$this->scoreClazz->commitClassScore($classID, $scores)) {
            $this->scoreCommon->error();
        } else {
            $this->scoreCommon->success();
        }
    }

    public function courseScore() {
        $query = $this->input->get('query');
        $startTermYear = $this->input->get('startTermYear');
        $startTermSemester = $this->input->get('startTermSemester');
        $endTermYear = $this->input->get('endTermYear');
        $endTermSemester = $this->input->get('endTermSemester');
        $scores = $this->scoreClazz->queryStudentCourses(
            $this->fake->currentStudent, 
            $query,
            array('year' => (int) $startTermYear, 'semester' => (int) $startTermSemester),
            array('year' => (int) $endTermYear, 'semester' => (int) $endTermSemester)
        );
        $gpa = $this->scoreClazz->calculateGpa($this->fake->currentStudent, $scores);
        $this->scoreCommon->success(array(
            'courses' => $this->scoreClazz->formatScoresForOutput($scores),
            'GPA' => $gpa
        ));
    }

    public function classScore() {
        $classID = $this->input->get('classId');
        //$classID = $this->fake->currentClass;
        if (($scores = $this->scoreClazz->getClassScores($classID)) === FALSE) {
            $this->scoreCommon->error();
            return;;
        }
        $this->scoreCommon->success(array_map(function($item) use ($classID) {
            $pendingRequest = $this->scoreClazz->getStudentPendingModifingRequest($classID, $item['student_id']);
            $info = $this->fake->getStudentInfo($item['student_id']);
            return array(
                'studentId' => $item['student_id'],
                'studentName' => $info['studentName'],
                'score' => $item['score_score'],
                'isAbsent' => $item['score_state'] === 1,
                'grade' => $this->scoreCommon->calculateGrade($item['score_score'], $item['score_state'] === 1),
                'mScore' => $pendingRequest != NULL ? $pendingRequest['score_score'] : 0,
                'mIsAbsent' => $pendingRequest != NULL ? $pendingRequest['score_state'] === 1 : false,
                'mGrade' => $pendingRequest != NULL ? $this->scoreCommon->calculateGrade($pendingRequest['score_score'], $pendingRequest['score_state'] === 1) : 0,
                'isPending' => $pendingRequest != NULL
            );
        }, $scores));
    }

    public function modifyScores() {
        $requests = json_decode($this->input->post('request'), true);
        if (empty($requests)) {
            $this->scoreCommon->error('参数不全');
            return;
        }
        if ($this->scoreClazz->uploadModifyRequests($requests))
            $this->scoreCommon->success();
        else
            $this->scoreCommon->error();
    }

    public function getModifyScores() {
        $teacherID = $this->fake->currentTeacher;
        $requests = $this->scoreClazz->getModifyScores($teacherID);
        $this->scoreCommon->success(array_map(function($index) {
            unset($index['createTime']);
            return $index;
        }, $requests));
    }

    public function getAllModifyScores() {
        $requests = $this->scoreClazz->getModifyScores();
        $this->scoreCommon->success(array_map(function ($index) {
            $index['teacherState1'] = (int) $index['teacherState1'];
            $index['teacherState2'] = (int) $index['teacherState2'];
            $index['teacherName1'] = $this->fake->getTeacherName($index['teacher_id_1']);
            $index['teacherName2'] = $this->fake->getTeacherName($index['teacher_id_2']);

            unset($index['teacher_id_1']);
            unset($index['teacher_id_2']);
            return $index;
        }, $requests));
    }

    public function approvalRequests() {
        $requests = json_decode($this->input->post('requests'), true);
        if (empty($requests)) {
            $this->scoreCommon->error('参数不全');
            return;
        }
        $info = $this->scoreClazz->approvalRequests($this->fake->currentTeacher, $requests);
        if ($info === FALSE)
            $this->scoreCommon->error();
        else
            $this->scoreCommon->success();
    }
/*
    public formatCourseForOutput($planCoursesID){
        return array_map(function($item)){
            return array(
                'courseID' => $item['courseID'],
                'courseName' => $item['courseName'],
                'credit' => $item['credit'],
                'score' => 0,
                'grade' => 0,
                'isRestudy'=>false,
                'state' => 0
            );
        },
        array(
            'GPA' => 0,
            'MGPA' => 0
        )
    }
*/
    public function coursePlan(){
        $studentId = $this->fake->currentStudent;
        $planCourses = $this->fake->getPlanCourse($studentId);
        $learnedCourses = $this->scoreClazz->queryLearnedCourse($studentId);
        $learningCoursesID = $this->fake->getLearningCourseID($studentId);
        //$courses = formatCourseForOutput($planCoursesID);
        $courses = $this->scoreClazz->combineCourse($courses,$learnedCourses,$learningCoursesID);
        $this->scoreCommon->success($courses);
    }

}

/* End of file score.php */
/* Location: ./application/controllers/score.php */
