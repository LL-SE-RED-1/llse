<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class teacher_apply extends CI_Controller{
	function teacher_apply(){
		parent::__construct();
		$this->load->model('r2/t_apply_model');//load对应的model文件
	}
	public function index(){
		$this->load->model('r2/t_apply_model');//load对应的model文件
		$classid=$_GET['classid'];//获取要递交申请的教学班的classid
		if(empty($_POST['changeinfo']))//如果输入框中没有信息
		{
			$data['info']=$this->t_apply_model->get_info($classid);//通过classid获取该教学班信息保存在$data['info']
			$data['classroom']=$this->t_apply_model->get_classroom();
			$this->load->view('r2/teacher_apply',$data);//调取teacher_apply页面，把$data传递给它
		}
		else if(!$this->t_apply_model->add_manapply($classid)){//输入框中有信息则调用add_manapply函数添加调课申请，如果添加失败
		echo "<script>alert('申请调整失败，请重新操作')</script>";//弹出失败的提示框
			$data['info']=$this->t_apply_model->get_info($classid);//通过classid获取该教学班信息保存在$data['info']
	   		$this->load->view('r2/teacher_apply',$data);//调取teacher_apply页面，把$data传递给它
	   }
	   else{//添加成功
	   		echo "<script>alert('申请成功')</script>";//弹出成功的提示框
	   		$data['tid']=$this->session->userdata['uid'];
			$data['apply1']=$this->t_apply_model->get_apply1();//调用get_apply1函数获取待排课的所有教学班信息
		$data['apply2']=$this->t_apply_model->get_apply2();//调用get_apply2函数获取排课成功的所有教学班信息
		$data['apply3']=$this->t_apply_model->get_apply3();//调用get_apply3函数获取待调整的所有教学班信息
		$data['apply4']=$this->t_apply_model->get_apply4();//调用get_apply4函数获取已被删除的所有教学班信息
		$data['apply5']=$this->t_apply_model->get_apply5();
		$data['classroom']=$this->t_apply_model->get_classroom();
		$this->load->view('r2/teacher_menu',$data);//调取teacher_menu页面，把$data传递给它
			}
		$this->load->helper('url');
	}
	
}


