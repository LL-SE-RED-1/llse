<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class teacher_menu extends CI_Controller{
	function menu_classroom(){//构造函数
		parent::__construct();
		$this->load->model('r2/t_menu_model');//load对应的model文件
	}
	public function index(){
		$this->load->model('r2/t_menu_model');//load对应的model文件
		$data['apply1']=$this->t_menu_model->get_apply1();//调用get_apply1函数获取待排课的所有教学班信息
		$data['apply2']=$this->t_menu_model->get_apply2();//调用get_apply2函数获取排课成功的所有教学班信息
		$data['apply3']=$this->t_menu_model->get_apply3();//调用get_apply3函数获取待调整的所有教学班信息
		$data['apply4']=$this->t_menu_model->get_apply4();//调用get_apply4函数获取已被删除的所有教学班信息
		$data['apply5']=$this->t_menu_model->get_apply5();
		$data['classroom']=$this->t_menu_model->get_classroom();
		if(empty($_POST['courseid']))//如果没有输入添加信息
			$this->load->view('default/teacher_menu',$data);//调取teacher_menu页面，将$data传递给它
		else if($check=$this->t_menu_model->check()==1)//如果有输入添加信息，则检查对应的课程是否存在
		{
			$this->load->view('default/teacher_menu',$data);//调取teacher_menu页面，将$data传递给它
	   		echo "<script>alert('此课程不存在！')</script>";//弹出课程不存在的提示框
		}
		/*else if($check==2)//
		{
			$this->load->view('default/teacher_menu',$data);
	   		echo "<script>alert('您已开设此课！')</script>";
		}*/
		else if(!$this->t_menu_model->addapply()){//添加失败
	   		$this->load->view('default/teacher_menu',$data);//调取teacher_menu页面，将$data传递给它
	   		echo "<script>alert('添加不成功，请重新操作！')</script>";//弹出添加失败的提示框
	   }
	   else{
	   		echo "<script>alert('添加成功')</script>";//弹出添加成功的提示框
			//重新获取数据
			$data['apply1']=$this->t_menu_model->get_apply1();
		$data['apply2']=$this->t_menu_model->get_apply2();
		$data['apply3']=$this->t_menu_model->get_apply3();
		$data['apply4']=$this->t_menu_model->get_apply4();
		$data['apply5']=$this->t_menu_model->get_apply5();
		$data['classroom']=$this->t_menu_model->get_classroom();
		$this->load->view('default/teacher_menu',$data);//调取teacher_menu页面，将新的数据$data传递给它
	   		
	   }
		$this->load->helper('url');
	}
}
