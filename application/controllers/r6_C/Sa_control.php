<?php

class Sa_control extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('r6_M/Ta_model');
		$this->load->library('javascript');
		$this->load->library('session');//调入session
	}
	
	public function view($page='Student_analysis')
	{
		//判断页面是否存在
		if ( ! file_exists(APPPATH.'/views/r6_V/analysis/'.$page.'.php'))
		{
			//echo APPPATH;
			show_404();
		}
		//获取当前id
		$id=$this->session->userdata('sid');
		$data['slist']=$this->Ta_model->get_sdata($id);
		$this->load->helper('url');
		$this->load->view('r6_V/analysis/my_head');
		$this->load->view('r6_V/analysis/'.$page,$data);
	}
	
}
?>