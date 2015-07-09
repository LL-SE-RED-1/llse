<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class apply_classroom_form extends CI_Controller{
	public function index(){
	   $this->load->model('r2/add_classroom_form_model');
	   //$this->add_classroom_form_model->test();
	   //对修改教室的各种信息做类型判断
	   $typecheck = $this->add_classroom_form_model->typecheck();
	   //echo $typecheck;
	   $this->load->model('r2/room_apply_model');
	   $data = $this->room_apply_model->test($_POST["classroom_id"]);	//获取修改教室的原有信息
	   if($typecheck){	//类型判断
	   		$this->load->view('default/room_apply',$data);
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
	   else if(!$this->add_classroom_form_model->applydatabase()){//数据库操作是否成功判断
	   		$this->load->view('default/room_apply',$data);
	   		echo "<script>alert('修改失败，请重新操作')</script>";
	   }
	   else{//修改成功返回主界面
	   		echo "<script>alert('修改成功')</script>";
	   		echo '<script>window.close();</script>';
	   		$this->load->helper('url');
	   		$urls = base_url();//
	   		$url = "{$url}admin_classroom_edit";
	   		echo $url;
	   		Header("Location: $url");
	   		
	   }
	   $this->load->helper('url');
	}
}
?>