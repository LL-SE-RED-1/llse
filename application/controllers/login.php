<?php

/*
 * Login Controller
 * Implement login function
 * author: lzx
 */

if (!defined('BASEPATH')) {
	exit('Access Denied');
}

class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();

		//装载后端model
		$this->load->model('ims/user_model');
	}

	public function index($result_num = 0) {
		//if($this->session->userdata('is_logged_in') != FALSE){
		//	redirect('ims/ims_permission');
		//}

		//unset seesion to relogin
		$this->session->unset_userdata('is_logged_in');

		$data['result_num'] = $result_num;
		//if login failed, echo error information
		if ($result_num == 2) {
			$data['result_info'] = "用户名或密码错误！";
		}
		else if($result_num == 3){
			$data['result_info'] = "无效链接";
		}

		//load views
		$this->output->enable_profiler(FALSE);
		$this->load->view('template/header');
		$this->load->view('login_view', $data);
	}

	//verify user who want to login
	public function verify() {
		//load user model

		// $this->load->model('ims/user_model');

		$post = $this->input->post();
		// use post data to search database and get result
		$result = $this->user_model->verify_user($post);

		if ($result) {
			//if login succeed
			//save user's information in session
			$data = array('uid' => $this->input->post('uid'),
				'user_type' => $this->input->post('userType'),
				'is_logged_in' => TRUE
			);
			$this->session->set_userdata($data);

			redirect('ims/ims_welcome');
		} else {
			//if login failed
			//redirect to login page and echo error message
			redirect('login/index/2');

		}

	}

}
