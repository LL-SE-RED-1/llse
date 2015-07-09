<?php

class Ta_control extends CI_Controller {
	public function __construct()//构造函数，初始化
	{
		parent::__construct();
		$this->load->model('r6_M/Ta_model');
		$this->load->library('javascript');
		$this->load->library('session');//调入session
		//echo APPPATH;
	}
	
	public function view($page='Teacher_analysis')
	{
		$this->load->helper('url');
		$this->load->library('session');
		//判断页面是否存在
		if ( ! file_exists(APPPATH.'/views/r6_V/analysis/'.$page.'.php'))
		{
			//echo APPPATH;
			show_404();
		}
		//获取当前id
		$id=$this->session->userdata('tid');
		$data['list']=$this->Ta_model->get_data($id);//教师出过的有成绩试卷
		$this->load->library('form_validation');
		$this->load->view('r6_V/analysis/my_head');
		$this->load->view('r6_V/analysis/'.$page,$data);
	
	}
}
?>