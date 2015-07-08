<?php
/*
* Ims Interface Model
* author: lzx
*/

class Ims_interface_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		date_default_timezone_set("Asia/Shanghai");
		$this->load->database();
	}

	public function get_sys_info()
	{
		$this->load->model('ims/sys_info_model');
		$sys_info = $this->sys_info_mode->get_sys_info();
		return $sys_info;
	}

	//write_log 格式	
	//uid:string,ip:string,time:datatime,description:string
	public function write_log($info)
	{
		$this->load->model('ims/sys_info_model');
		$data['class'] = $info['class'];
		$data['ip'] = $this->input->ip_address();
		$data['uid'] = $this->session->userdata('uid');
		$data['description'] = $info['description'];
		$data['time'] = date("Y-m-d H:i:s", now());
		$result = $this->sys_info_model->write_log($data);
		return $result;
	}

	public function verify_user($post)
	{
		$this->load->model('ims/user_model');
		$result = $this->user_model->verify_user($post);
		return $result;
	}

	public function getStudent($userID)
	{	
		$this->load->model('ims/basic_info_model');
		$student = $this->basic_info_model->readInfo($userID);
		return $student;
	}

	public function getTeacher($userID)
	{
		$this->load->model('ims/basic_info_teacher_model');
		$teacher = $this->basic_info_teacher_model->readInfo($userID);
		return $teacher;
	}

	public function getCourse($courseID)
	{
		$this->load->model('ims/add_course_model');
		$course = $this->add_course_model->readInfo($courseID);
		return $course;
	}

}