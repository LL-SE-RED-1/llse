<?php

class Form extends CI_Controller {
	public function __construct()//构造函数，初始化
	{
		parent::__construct();
		$this->load->model('r6_M/Ta_model');
		$this->load->library('session');
	}
 function index()
 {
	//获得post得到EID
	$EID=$this->input->post('teacher');
	if(!empty($EID))
	{	$data['ans']=$this->Ta_model->get_ans($EID);//获得出错的题目统计
		$data['sc']=$this->Ta_model->get_sc($EID);//获得得分统计
		$this->load->helper('url');
		$this->load->view('r6_V/analysis/my_head');
		$this->load->view('r6_V/analysis/Teacher_result',$data);//调用view
		}
 }
}
?>