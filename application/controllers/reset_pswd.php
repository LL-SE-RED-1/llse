<?php

/*
* Modify Password Controller
* Implement modifing password function
* author: lzx
*/

if( ! defined('BASEPATH')){
	exit('Access Denied');
}

class Reset_pswd extends CI_Controller
{

	public function __construct(){
		parent::__construct();
 
		//load user model
		$this->load->model('ims/user_model');

	}

	//reset界面的控制器
	public function index($result_num = 0){
		$this->session->unset_userdata('is_logged_in');

		$data['result_num'] = $result_num;
		if($result_num == 1){
			$data['result_info'] = "已发送重置密码邮件，请查收你的校网邮箱";
		}
		else if($result_num == 2){
			$data['result_info'] = "该用户不存在";
		}

		$this->load->view('template/header');
		$this->load->view('reset_pswd_view',$data);
	}

	//检测用户是否存在并发送重置密码的邮件
	public function send_email(){
		// $this->load->model('ims/user_model');

		$uid = $this->input->post('uid');
		$user = $this->user_model->get_user($uid);

		if($user){
			$token = md5($uid.$user['password']);
			$url = site_url('reset_pswd/modify_pswd')."?uid=".$uid."&token=".$token;

			$this->load->library('email');
			$this->email->mailtype='html';
			$this->email->from('no-reply@llseims.com','IMS子系统');
			$this->email->to($uid."@zju.edu.cn");

			$this->email->subject('重置密码');
			$message = "
			<html>
			<head>
			<title>教务管理系统-重置密码</title>
			</head>
			<body>
				<p>请点击下面的链接以重置密码</p><br/>
				<a href='".$url."'target='_blank'>".$url."</a>
			</body>
			</html>
			";
			$this->email->message($message);
			$this->email->send();
			// die(var_dump($this->email->print_debugger()));

			redirect('reset_pswd/index/1');
		}
		else{
			redirect('reset_pswd/index/2');
		}
	}

	//从邮件中跳转到这个控制器
	public function modify_pswd(){
		$uid = $this->input->get('uid');
		$token = $this->input->get('token');
		$user = $this->user_model->get_user($uid);

		if ($user) {
			//防止用户通过改动链接的方式来欺骗系统
			$mt = md5($user['uid'].$user['password']);
			if($mt == $token){ 	//通过验证
				$data = array('uid' => $user['uid'],
					'user_type' => $user['type'],
					'is_logged_in' => TRUE
				);
				$this->session->set_userdata($data);
				redirect('reset_pswd/new_pswd');
			}
			else{
				redirect('login/index/3');
			}
			
		} else {
			//if login failed
			//redirect to login page and echo error message
			redirect('login/index/3');
		}
	}

	//重置密码的主页面
	public function new_pswd($result_num = 0){
		//data uesd in view 
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
		}

		//load views
		$this->load->view('template/header');
		$this->load->view('new_pass_view',$data);
	}

	//处理提交的新密码
	public function reset(){
		//store post data
		$post['uid'] = $this->session->userdata('uid');
		$post['userType'] = $this->session->userdata('user_type');
		$post['new_pass'] = $this->input->post('new_pass');
		
		if($this->user_model->modify_pass($post))
		{
			//if update succeed
			redirect('reset_pswd/new_pswd/1');
		}
		else
		{
			//if update failed
			redirect('reset_pswd/new_pswd/2');
		}
		
	}

}