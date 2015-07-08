<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class add_classroom_form extends CI_Controller{
	public function index(){
	   $this->load->model('r2/add_classroom_form_model');
	   //$this->add_classroom_form_model->test();
	   //对输入的类型格式判断
	   $typecheck = $this->add_classroom_form_model->typecheck();
	   if($typecheck){
	   		$this->load->view('r2/add_classroom');
	   		switch($typecheck){
	   			case 1:
	   				echo "<script>alert('教学楼输入不合要求')</script>";
	   				break;
	   			case 2:
	   				echo "<script>alert('房间号输入不合要求')</script>";
	   			case 3:
	   				echo "<script>alert('容量输入不合要求')</script>";
	   		}
	   }
	   else if(!$this->add_classroom_form_model->addtodatabase()){
	   //对数据库操作成功与否判断
	   		$this->load->view('default/add_classroom');
	   		echo "<script>alert('添加失败，请重新操作')</script>";
	   }
	   else{
	   //添加成功返回主界面
	   		$this->load->helper('url');
	   		echo "<script>alert('添加成功')</script>";
	   		//echo '<script>window.close();</script>';
	   		$urls = base_url();//
	   		$url = "{$url}admin_classroom_edit";
	   		//echo $url;
	   		Header("Location: $url");
	   }
	   $this->load->helper('url');
	}
}