<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('r7/FakeData_model', 'fake');
        $this->load->model('r7/ScoreCommon_model', 'scoreCommon');
    }

    /**
     * 获取学生的基本信息
     * GET: studentId 学号
     * 返回一些基本信息
     */
    public function studentInfo() {
        $info = $this->fake->getStudentInfo($this->fake->currentStudent);
        $info['studentId'] = $this->fake->currentStudent;
        $this->scoreCommon->success($info);
    }
}

/* End of file student.php */
/* Location: ./application/controllers/student.php */