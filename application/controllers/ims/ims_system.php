<?php

/*
* Ims_system Controller
* System Information Management
* author: lzx
*/

if (!defined('BASEPATH')) {
	exit('Access Denied');
}

class Ims_system extends CI_Controller {
	public function __construct() {
		parent::__construct();
		// set default timezong 
		date_default_timezone_set("Asia/Shanghai");
		// if not logged in,redirect
		if($this->session->userdata('is_logged_in') == FALSE)
		 	redirect('login');
	}

	public function index($page = 1) {

		$this->load->model('ims/sys_info_model');
		$this->load->helper('date');
		$this->load->database();

		// store data for view
		$data['navi'] = 4;
		$data['sys_info'] = $this->sys_info_model->get_sys_info();
		$data['log_stati'] = $this->sys_info_model->get_statistic();
		$data['uid'] = $this->session->userdata('uid');
		$data['type'] = $this->session->userdata('user_type');

		// fill in right semester info according to data in database
		switch($data['sys_info']['semester'])
		{
			case 0: 
				$data['sys_info']['semester']='系统信息错误';
				break;
			case 1:
				$data['sys_info']['semester'] = '春学期';
				break;
			case 2:
				$data['sys_info']['semester'] = '夏学期';
				break;
			case 3:
				$data['sys_info']['semester'] = '短学期';
				break;
			case 4:
				$data['sys_info']['semester'] = '秋学期';
				break;
			case 5:
				$data['sys_info']['semester'] = '冬学期';
				break;
			case 6:
				$data['sys_info']['semester'] = '暑假';
				break;
		}

		//get current time
		$datestring = "%Y-%m-%d";

		$data['sys_info']['date'] = substr(mdate($datestring), 2);

		$timestring = "%H:%i";
		$data['sys_info']['time'] = mdate($timestring);

		// pagination for log records
	    $this->load->library('pagination');

	    // number of all log records
	    $pagination['total_rows'] = $this->db->count_all('imsLog');
	    // 10 records per page
        $pagination['per_page'] = 10;
	    $data['pagination']['base_url'] = site_url('ims/ims_system')."/index";
	    $data['pagination']['page'] = $page;
        $data['pagination']['page_num'] = ceil($pagination['total_rows'] / $pagination['per_page']);

        //get log records
        $data['log'] = $this->sys_info_model->get_log($pagination['per_page'],($page-1)*$pagination['per_page']);


        //load views
		$this->load->view('template/header');

		$this->load->view('template/navigator', $data);
		$this->load->view('template/side_navi');
		$this->load->view('ims/ims_system_view');
	}

}