<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_classroom_edit extends CI_Controller{
	function Admin_classroom_edit(){
		parent::__construct();
	}
	public function index(){
		echo $this->session->userdata['user_type'];
	   if($this->session->userdata['user_type']==2){
	   	    echo "hah";
		   	$this->load->model('r2/t_menu_model');
		   	$data['tid']=$this->session->userdata['uid'];
			$data['apply1']=$this->t_menu_model->get_apply1();
			$data['apply2']=$this->t_menu_model->get_apply2();
			$data['apply3']=$this->t_menu_model->get_apply3();
			$data['apply4']=$this->t_menu_model->get_apply4();
			$data['apply5']=$this->t_menu_model->get_apply5();
			$data['classroom']=$this->t_menu_model->get_classroom();
		   $this->load->view('r2/teacher_menu',$data);
		   $this->load->helper('url');
	   }
	   else if($this->session->userdata['user_type']==3){
		   $this->load->model('r2/classroom_edit_model');
		   //如果并没有id值传进，则直接显示classroom表的内容
		   if (empty($_GET['clrid'])) $data['classroom'] = $this->classroom_edit_model->get_classroom();
		   //有id值则删除对应的id值
		   else {
		   	$this->classroom_edit_model->delete_classroom();
		   	$data['classroom'] = $this->classroom_edit_model->get_classroom();
		   }
		   $this->load->view('r2/admin_classroom_edit',$data);
		   $this->load->helper('url');

	   }
	   else{
	   	  redirect('llse_welcome');
	   }
	}
}