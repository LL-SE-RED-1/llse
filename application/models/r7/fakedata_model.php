<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fakedata_model extends CI_Model {
    public $currentStudent = '3120000000';
    public $currentClass = 'bianyiyuanli-2014-2015';
    public $currentTeacher = 't12300';

    public function getTeacherClazz($teacher = null) {
        return array(
                array(
                    'classId' => 'weijifen1-2014-2015',
                    'courseName' => '微积分1',
                    'classTerm' => '2014-2015春夏'
                ),
                array(
                    'classId' => 'lisan-2014-2015',
                    'courseName' => '离散数学',
                    'classTerm' => '2014-2015春夏'
                ),
                array(
                    'classId' => 'bianyiyuanli-2014-2015',
                    'courseName' => '编译原理',
                    'classTerm' => '2014-2015春'
                )
            );
    }

    public function getClassInfo($classID) {
        return array(
                'weijifen1-2014-2015' => array(
                    'courseID' => 'weijifen1',
                    'courseName' => '微积分1',
                    'teacher' => '苏德矿',
                    'credit' => 4
                ),
                'lisan-2014-2015' => array(
                    'courseID' => 'lisan',
                    'courseName' => '离散数学',
                    'teacher' => '楼学庆',
                    'credit' => 3,
                ),
                'bianyiyuanli-2014-2015' => array(
                    'courseID' => 'bianyiyuanli',
                    'courseName' => '编译原理',
                    'teacher' => '编译器',
                    'credit' => 2
                ),
                'weijifen1-2013-2014' => array(
                    'courseID' => 'weijifen1',
                    'courseName' => '微积分1',
                    'teacher' => '苏德矿',
                    'credit' => 4
                ),

            )[$classID];
    }

    public function isWithOnlineExam($classID) {
        return array(
                'weijifen1-2014-2015' => false,
                'lisan-2014-2015' => true,
                'bianyiyuanli-2014-2015' => false
            )[$classID];
    }

    public function getMajorCourseID($studentID) {
        return array(
            'weijifen1',
            'lisan',
            'bianyiyuanli'
        );
    }

    public function getStudentFromClass($classID) {
        return array(
                'weijifen1-2014-2015' => array(
                    array(
                        'studentID' => '3120000000',
                        'studentName' => 'xuchaoying'
                    ),
                    array(
                        'studentID' => '3120000001',
                        'studentName' => 'helinyue'
                    ),
                    array(
                        'studentID' => '3120000002',
                        'studentName' => 'sun4quan'
                    )
                ),
                'lisan-2014-2015' => array(
                    array(
                        'studentID' => '3120000003',
                        'studentName' => 'bitingyu'
                    ),
                    array(
                        'studentID' => '3120000004',
                        'studentName' => 'yangsibei'
                    )
                ),
                'bianyiyuanli-2014-2015' => array(
                    array(
                        'studentID' => '3120000003',
                        'studentName' => 'bitingyu'
                    ),
                    array(
                        'studentID' => '3120000004',
                        'studentName' => 'yangsibei'
                    ),
                    array(
                        'studentID' => '3120000000',
                        'studentName' => 'xuchaoying'
                    ),
                    array(
                        'studentID' => '3120000001',
                        'studentName' => 'helinyue'
                    ),
                    array(
                        'studentID' => '3120000002',
                        'studentName' => 'sun4quan'
                    )
                )
            )[$classID];
    }

    public function getStudentInfo($studentID) {
        return array(
            'studentName' => 'xuchaoying',
            'sCollege' => 'cs',
            'sClass' => '1201',
            'sGrade' => '2012'
        );
    }

    public function getTeachersForCourse($courseID) {
        return array(
            array(
                'teacherId' => 't12300',
                'teacherName' => 'louxueqing'
            ),
            array(
                'teacherId' => 't12301',
                'teacherName' => 'jinxiaogang'
            ),
            array(
                'teacherId' => 't12302',
                'teacherName' => 'sudekuang'
            )
        );
    }

    public function getTeacherName($teacherID) {
        return array(
            't12300' => 'louxueqing',
            't12301' => 'jinxiaogang',
            't12302' => 'sudekuang',
        )[$teacherID];
    }

    public function getPlanCourse($studentID){
    	return array(
            array(
                'courseID' => 'weijifen1',
                'courseName' => '微积分1',
                'credit' => 4
            ),
            array(
                'courseID' => 'lisan',
                'courseName' => '离散数学',
                'credit' => 3,
            ),
            array(
                'courseID' => 'bianyiyuanli',
                'courseName' => '编译原理',
                'credit' => 2
            ),
            array(
            	'courseID' => 'jisuanjiwangluo',
            	'courseName' => '计算机网络',
            	'credit' => 3
            )
        );
    }

    public function getLearningCourseID($studentID){
    	return array(
    		array(
    			'courseID' => 'jisuanjiwangluo',
    			'isRestudy' => false
    		),
    		array(
    			'courseID' => 'lisan',
    			'isRestudy' => true
    		)
    	);
    }

    public function result(){
    	return array(
            'courses' => array(
            	array(
            		'courseID' => 'bianyiyuanli-2014-2015',
                	'courseName' => '编译原理',
                	'credit' => 2,
                	'score' => 90,
                	'grade' => 4.5,
                	'isRestudy'=>false,
                	'state' => 2
                ),
                array(
                	'courseID' => 'weijifen1-2013-2014',
                	'courseName' => '微积分1',
                	'credit' => 4,
                	'score' => 59,
                	'grade' => 0,
                	'isRestudy'=>false,
                	'state' => 0
                ),
                array(
                	'courseID' => 'weijifen1-2014-2015',
                	'courseName' => '微积分1',
                	'credit' => 4,
                	'score' => 80,
                	'grade' => 3.5,
                	'isRestudy'=>true,
                	'state' => 2
                ),
                array(
                	'courseID' => 'jisuanjiwangluo',
                	'courseName' => '计算机网络',
                	'credit' => 3,
                	'score' => 0,
                	'grade' => 0,
                	'isRestudy'=>false,
                	'state' => 0
                )
            ),
            	
            'GPA' => array(
            		'GPA' => 2.3,
            		'MGPA'=> 2.3
            )
        );

    }

}

/* End of file fakeDataModel.php */
/* Location: ./application/models/fakeDataModel.php */