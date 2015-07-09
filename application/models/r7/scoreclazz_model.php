<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author Richard
 * 
 * 一个关于教学班的model模块
 * 提供了查询当前教学班是否已经提交了期末成绩
 * 以及设置当前班级有期末成绩的功能
 */ 
class Scoreclazz_model extends CI_Model {
    
    /**
     * A prefix key in meta table
     */ 
    private $CLAZZ_SUBMIT_PREFIX = "IS_CLAZZ_SUBMITTED_";

    /**
     * check whether a class has its final score
     * @param any[$classID] class ID
     */
    public function isSubmitted($classID) {
        $row = $this->db->where('key', $this->__buildClazzKey($classID))->limit(1)->get('score_meta')->row();
        return $row != NULL && $row->value == 'true';
    }

    /**
     * set the current class's final score has submitted
     * @param any[$classID] class ID
     */ 
    public function setSubmitted($classID) {
        if ($this->db->where('key', $this->__buildClazzKey($classID))->limit(1)->get('score_meta')->num_rows() == 0)
            $this->db->insert('score_meta', array(
                    'key' => $this->__buildClazzKey($classID),
                    'value' => 'true'
                ));
        else
            $this->db->where('key', $this->__buildClazzKey($classID))->set('value', 'true')->limit(1)->update('score_meta');
        return TRUE;
    }

    /**
     * build class key name in the meta table
     * @internal
     * @param any[$classID] class ID
     */ 
    private function __buildClazzKey($classID) {
        return $this->CLAZZ_SUBMIT_PREFIX . (string) $classID;
    }

    /**
     * 提交本班的最终成绩
     * @param string[$classID]
     * @param array[$scores] 成绩
     * @return true or false, 原因会填写在scoreCommon这个模块
     */
    public function commitClassScore($classID, $scores) {
        // 如果有错误就回滚
        $this->db->trans_start();
        $this->setSubmitted($classID);
        //先插入到single score表，并拿到这一段ID
        $this->db->insert_batch('score_single', array_map(function ($item) {
                return array(
                    'score_score' => $item['score'],
                    'score_state' => $item['isAbsent'] ? 1 : 0
                );
            }, $scores));
        $id = $this->db->insert_id();
        //如果插入的数量跟提交的不一致（应该不会发生）
        if ($this->db->affected_rows() != count($scores)) {
            $this->db->trans_rollback();
            $this->scoreCommon->set_error('发生内部错误，请重新填写');
            return FALSE;
        }
        //插入到学生成绩表
        $this->db->insert_batch('score_record', array_map(function ($item, $index) use ($id, $classID) {
                return array(
                    'class_id' => $classID,
                    'student_id' => $item['studentId'],
                    'score_single_id' => $id + $index
                );
            }, $scores, range(0, count($scores) - 1)));
        $this->db->trans_complete();
        return true;
    }

    /**
     * 根据当前学生ID，搜索关键词，学期开始和结束来过滤课程列表并计算这一段的GAP等信息
     * @param string[$studentID] 学生ID
     * @param string[$query] 搜索关键词
     * @param stdObject[$termStart] 开始的学期
     * @param stdObject[$termEnd] 结束的学期
     * @return 查询出来的所有课程列表
     */
    public function queryStudentCourses($studentID, $query = NULL, $termStart = NULL, $termEnd = NULL) {
        $sql = $this->db->where('student_id', $studentID);
        $sql = $this->db->join('score_single', 'score_single.score_id=score_record.score_single_id');
        $scores = $this->db->get('score_record')->result_array();
        if (empty($scores)) $scores = array();
        foreach ($scores AS $index => &$value) {
            $info = $this->fake->getClassInfo($value['class_id']);
            $value['info'] = $info;
            if (!empty($query) && strpos($info['courseName'], $query) === FALSE)
                unset($scores[$index]);
        }
        $scores = array_values($scores);
        $scores = $this->filterCoursesWithTerm($scores, $termStart, $termEnd);
        return $scores;
    }

    /**
     * 根据开始和结束学期来过滤课程列表，仅返回范围内的
     */
    private function filterCoursesWithTerm($courses, $termStart, $termEnd) {
        if (empty($termStart) || empty($termEnd)) return $courses;
        if ($termStart['year'] == 0 || $termStart['semester'] == 0 || $termEnd['year'] == 0 || $termStart['semester'] == 0) return $courses;
        //TODO
        return $courses;
    }

    /**
     * 计算列表内课程的GPA和主修GPA
     */
    public function calculateGpa($studentID, &$courses) {
        $majors = $this->fake->getMajorCourseID($studentID);
        $GPASum = 0;
        $GPACount = 0;
        $majorSum = 0;
        $majorCount = 0;
        foreach ($courses as &$c) {
            $info = $c['info'];
            $c['grade'] = $this->scoreCommon->calculateGrade($c['score_score'], $c['score_state'] === 1);
            $GPASum += $c['grade'] * $info['credit'];
            $GPACount += $info['credit'];
            if (in_array($info['courseID'], $majors)) {
                $majorSum += $c['grade'] * $info['credit'];
                $majorCount += $info['credit'];
            }
        }
        return array(
            "GPA" => $GPACount != 0 ? $GPASum / (float) $GPACount : 0,
            'MGPA' => $majorCount != 0 ? $majorSum / (float) $majorCount : 0
        );
    }

    /**
     * 根据API要求格式化从数据库中取出的成绩列表
     */
    public function formatScoresForOutput(&$scores) {
        return array_map(function($item) {
            return array(
                'classId' => $item['class_id'],
                'courseName' => $item['info']['courseName'],
                'score' => (int) $item['score_score'],
                'grade' => $item['grade'],
                'credit' => $item['info']['credit'],
                'isAbsent' => $item['score_state'] === 1,
                'termYear' => 2015,
                'termSemester' => 1
            );
        }, $scores);
    }

    /**
     * 获取某个班级的全部成绩列表
     * @return mixed: false 如果本班成绩还没有提交
     * @return 本班成绩数组
     */
    public function getClassScores($classID) {
        if (!$this->isSubmitted($classID)) {
            $this->scoreCommon->set_error('本班成绩还未提交，请提交后再查询');
            return FALSE;
        }
        return $this->db->where('class_id', $classID)->join('score_single', 'score_single.score_id=score_record.score_single_id')->get('score_record')->result_array();
    }

    public function getStudentPendingModifingRequest($classID, $studentID) {
        return $this->db->where('class_id', $classID)->where('student_id', $studentID)->where('is_finished', 0)->join('score_single', 'score_single.score_id=score_modifing_request.score_to')->limit(1)->get('score_modifing_request')->row_array();
    }

    /**
     * 提交申请请求们
     * @param array[$requests] 请求的具体内容
     * @return boolean
     */
    public function uploadModifyRequests($requests) {
        $classID = $requests['classId'];
        $teacherId1 = $requests['mTeacherId1'];
        $teacherId2 = $requests['mTeacherId2'];

        if (!$this->isSubmitted($classID)) {
            $this->scoreCommon->set_error('本班成绩还未提交');
            return FALSE;
        }

        if (!isset($requests['records']) || empty($requests['records'])) {
            $this->scoreCommon->set_error('请修改至少一个成绩');
            return FALSE;
        }

        $teachers = array();
        foreach ($this->fake->getTeachersForCourse($this->fake->getClassInfo($classID)['courseID']) as $t) {
            $teachers[] = $t['teacherId'];
        }
        // 检查这两个教师有没有开这个课
        if (!in_array($teacherId1, $teachers) || !in_array($teacherId2, $teachers)) {
            $this->scoreCommon->set_error('教师不在开课教师列表中');
            return FALSE;
        }
        if ($teacherId1 === $teacherId2) {
            $this->scoreCommon->set_error('请选择两个不同的教师');
            return FALSE;
        }

        $this->db->trans_start();
        foreach($requests['records'] as $r) {
            // 看看这个是不是已经申请过了
            if ($this->getStudentPendingModifingRequest($classID, $r['studentId']) != NULL) {
                $this->scoreCommon->set_error("学生{$r['studentId']}有未处理的请求，请等待处理完成");
                $this->db->trans_rollback();
                return FALSE;
            }
            $fromID = $this->db->where('class_id', $classID)->where('student_id', $r['studentId'])->get('score_record')->row()->score_single_id;
            $this->db->insert('score_single', array(
                'score_score' => (int) $r['mScore'],
                'score_state' => ($r['mIsAbsent'] === TRUE || $r['mIsAbsent'] === 'true') ? 1 : 0
            ));
            $this->db->insert('score_modifing_request', array(
                'class_id' => $classID,
                'student_id' => $r['studentId'],
                'teacher_id' => $this->fake->currentTeacher,
                'reason' => $r['mInfo'],
                'teacher_id_1' => $teacherId1,
                'teacher_id_2' => $teacherId2,
                'score_from' => $fromID,
                'score_to' => $this->db->insert_id(),
            ));
        }
        $this->db->trans_complete();
        return TRUE;
    }

    public function combineCourse($courses,$learnedCourses,$learningCoursesID){
        return $this->feak->result();
    }

    /**
     * 获取成绩修改申请
     * 如果$teacherId不为NULL，则返回本教师需要审批的请求
     * 如果$teacherId为NULL，返回所有已经完成的请求
     * @param string[$teacherId] optional
     * @return array formated for output
     */
    public function getModifyScores($teacherId = NULL) {
        $this->db->from('score_modifing_request as m');
        if ($teacherId !== NULL) {
            $this->db->where('teacher_id_1', $teacherId)->or_where('teacher_id_2', $teacherId);
            $this->db->where('is_finished', 0);
        }
        else {
            $this->db->where('is_finished !=', 0);
        }
        //按创建时间倒序排序
        $this->db->order_by('time_create', 'desc');
        // 把两个具体的成绩查询出来
        $this->db->join('score_single as f', 'f.score_id = m.score_from', 'left');
        $this->db->join('score_single as t', 't.score_id = m.score_to', 'left');
        $this->db->select('f.score_score as score, f.score_state as state, t.score_score as mScore, t.score_state as mState, class_id as classId, student_id as studentId, reason as mInfo, time_create as createTime, teacher_id, request_id as requestId, teacher_id_1, teacher_id_2, teacher_state_1 as teacherState1, teacher_state_2 as teacherState2');
        if ($teacherId === NULL) {
            $this->db->select('teacher_reason_1 teacherReason1, teacher_reason_2 teacherReason2, time_finish as finishTime');
        }
        $result = $this->db->get()->result_array();
        if ($teacherId !== NULL) {
            foreach ($result as $index => $value) {
                if ($value['teacher_id_1'] === $teacherId && $value['teacherState1'] != 0) unset($result[$index]);
                if ($value['teacher_id_2'] === $teacherId && $value['teacherState2'] != 0) unset($result[$index]);
            }
            $result = array_values($result);
        }
        return array_map(function($index) {
            $index['grade'] = $this->scoreCommon->calculateGrade($index['score'], $index['state'] == 1);
            $index['mGrade'] = $this->scoreCommon->calculateGrade($index['mScore'], $index['mState'] == 1);
            $index['isAbsent'] = $index['state'] == 1;
            $index['mIsAbsent'] = $index['mState'] == 1;
            $index['studentName'] = $this->fake->getStudentInfo($index['studentId'])['studentName'];
            $index['teacherName'] = $this->fake->getTeacherName($index['teacher_id']);
            $index['courseName'] = $this->fake->getClassInfo($index['classId'])['courseName'];
            unset($index['teacher_id']);
            unset($index['state']);
            unset($index['mState']);
            return $index;
        }, $result);
    }

    /**
     * 教师进行审批
     * @param string[$teacherID] 当前教师的ID
     * @param array[$requests] 审批申请们
     * @return boolean
     */
    public function approvalRequests($teacherID, $requests) {
        $this->db->trans_start();
        foreach ($requests as $r) {
            // 将approval 保证为boolean
            $r['approval'] = $r['approval'] === true || $r['approval'] === 'true';
            // 拒绝却没有写原因
            if (!$r['approval'] && empty($r['info'])) {
                $this->db->trans_rollback();
                $this->scoreCommon->set_error('拒绝请填写具体原因');
                return FALSE;
            }

            // 找出那条申请
            $req = $this->db->where('request_id', $r['requestId'])->limit(1)->get('score_modifing_request')->row_array();
            // 当前登录教师不在两个教师名字里
            if (empty($req) || ($req['teacher_id_1'] !== $teacherID && $req['teacher_id_2'] !== $teacherID)) {
                $this->db->trans_rollback();
                $this->scoreCommon->set_error("请求{$r['requestId']}无权审批");
                return FALSE;
            }
            // 已经审批完了
            if ($req['is_finished'] != 0) {
                $this->db->trans_rollback();
                $this->scoreCommon->set_error("请求{$r['requestId']}已经审批完成");
                return FALSE;
            }

            // 当前是教师1还是2
            $tIndex = 0;
            if ($req['teacher_id_1'] === $teacherID)
                $tIndex = 1;
            else 
                $tIndex = 2;

            // 这个教师已经审批过了
            if ($req["teacher_state_$tIndex"] != 0) {
                $this->db->trans_rollback();
                $this->scoreCommon->set_error("请求{$r['requestId']}你已经审批过");
                return FALSE;
            }
            // 更新了当前教师的审批结果
            $this->db->where('request_id', $r['requestId'])->update('score_modifing_request', array(
                "teacher_state_$tIndex" => $r['approval'] ? 1 : 2,
                "teacher_reason_$tIndex" => $r['approval'] ? NULL : $r['info']
            ));

            //这是第二个教师，应该处理一下.
            if ($req['teacher_state_' . (3 - $tIndex)] != 0) {
                if ($r['approval'] && $req['teacher_state_' . (3 - $tIndex)] == 1) {
                    // approval!
                    $this->db->where('request_id',$r['requestId'])->set('is_finished', 1)->set('time_finish', 'now()', false)->update('score_modifing_request');
                    $this->db->where('class_id', $req['class_id'])->where('student_id', $req['student_id'])->set('score_single_id', $req['score_to'])->update('score_record');
                } else {
                    // 有一个教师拒绝了，于是失败!
                    $this->db->where('request_id',$r['requestId'])->set('is_finished', 2)->set('time_finish', 'now()', false)->update('score_modifing_request');
                }
            }
        }
        $this->db->trans_complete();
        return TRUE;
    }

    public function queryLearnedCourse($studentID){
        $sql = $this->db->where('student_id', $studentID);
        $sql = $this->db->join('score_single', 'score_single.score_id=score_record.score_single_id');
        $scores = $this->db->get('score_record')->result_array();
        if (empty($scores)) $scores = array();
        foreach ($scores AS $index => &$value) {
            $info = $this->fake->getClassInfo($value['class_id']);
            $value['info'] = $info;
        }
        $scores = array_values($scores);
        return $scores;
    }



}

/* End of file scoreClazzModel.php */
/* Location: ./application/models/scoreClazzModel.php */