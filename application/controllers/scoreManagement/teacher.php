<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('r7/FakeData_model', 'fake');
        $this->load->model('r7/ScoreClazz_model', 'scoreClazz');
        $this->load->model('r7/ScoreCommon_model', 'scoreCommon');
    }

    /**
     * get all classes of this teacher
     * teacher is the user who loged into system now.
     * @return return a json of all classes(with or without final scores)
     */
    public function clazz() {
        $clazz = $this->fake->getTeacherClazz();
        $withScores = array();
        $withoutScores = array();
        foreach ($clazz as &$c) {
            if ($this->scoreClazz->isSubmitted($c['classId']))
                $withScores[] = $c;
            else
                $withoutScores[] = $c;
        }
        $this->scoreCommon->success(array(
            'withScores' => $withScores,
            'withoutScores' => $withoutScores
            ));
    }

    public function index() {
        $data['navi'] = 0;
        $data['uid'] = $this->session->userdata('uid');
        $data['type'] = $this->session->userdata('user_type');

        $this->load->view('template/header');
        $this->load->view('template/navigator', $data);
        $this->load->view('template/side_navi', $data);
        $this->load->view('r7/teacher');
    }

    public function getTeacherCourses() {
        $this->scoreCommon->success($this->fake->getTeachersForCourse($this->input->get('courseId')));
    }
}

/* End of file teacher.php */
/* Location: ./application/controllers/teacher.php */