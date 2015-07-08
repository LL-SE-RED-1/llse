<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_classroom_edit extends CI_Controller{
	function Admin_classroom_edit(){
		parent::__construct();
	}
	public function index(){
	   $this->load->model('r2/classroom_edit_model');
	   //如果并没有id值传进，则直接显示classroom表的内容
	   if (empty($_GET['clrid'])) $data['classroom'] = $this->classroom_edit_model->get_classroom();
	   //有id值则删除对应的id值
	   else {
	   	$this->classroom_edit_model->delete_classroom();
	   	$data['classroom'] = $this->classroom_edit_model->get_classroom();
	   }
	   $this->load->view('default/admin_classroom_edit',$data);
	   $this->load->helper('url');
	}
}