<?php

/*
* Modify Password Controller
* Implement modifing password function
* author: lzx
*/

if( ! defined('BASEPATH')){
	exit('Access Denied');
}

class Modify_pass extends CI_Controller
{

	public function __construct(){
		parent::__construct();
 
		//if not logged in, redirect to login page
		if($this->session->userdata('is_logged_in') == FALSE)
		 	redirect('login');

		//load user model
		$this->load->model('ims/user_model');

	}

	public function index($result_num = 0)
	{
		//data uesd in view 
		$data['navi'] = 0;
		$data['uid'] = $this->session->userdata('uid');
		$data['type'] = $this->session->userdata('user_type');
		$data['result_num'] = $result_num;

		//choose result info
		switch($result_num){
			//if update succeed
			case 1: 
				$data['result_info'] = "修改成功！";
				break;
			//if update failed
			case 2:
				$data['result_info'] = "修改失败，请重试。";
				break;
			//if old password error
			case 3:
				$data['result_info'] = "原密码错误";
		}

		//load views
		$this->load->view('template/header');
		$this->load->view('template/navigator',$data);		
		$this->load->view('template/side_navi');
		$this->load->view('modify_pass_view',$data);	
	}

	public function modify()
	{
		//store post data
		$post['uid'] = $this->session->userdata('uid');
		$post['userType'] = $this->session->userdata('user_type');
		$post['password'] = $this->input->post('old_pass');
		$post['new_pass'] = $this->input->post('new_pass');
		
		if($this->user_model->verify_user($post))
		{
			//if old password is right
			if($this->user_model->modify_pass($post))
			{
				//if update succeed
				redirect('modify_pass/index/1');
			}
			else
			{
				//if update failed
				redirect('modify_pass/index/2');
			}
		}
		else
		{
			//if old password is wrong
			redirect('modify_pass/index/3');
		}
	}

}