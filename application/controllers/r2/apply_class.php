<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class apply_class extends CI_Controller{
	public function index(){
	   $this->load->model("r2/apply_teacher_model");
	   $data = $this->apply_teacher_model->test($_POST["class_id"]);
	   //教学班各种信息类型判断
	   $typecheck = $this->apply_teacher_model->check($data);
	   if($typecheck){
	   		$this->load->view("r2/teacher",$data);
	   		switch($typecheck){
	   			case 1:
	   				echo "<script>alert('该教室不存在')</script>";
	   				break;
	   			case 2:
	   				echo "<script>alert('该老师这个时间段没空')</script>";
	   				break;
	   			case 3:
	   				echo "<script>alert('该教室这个时间段没空')</script>";
	   				break;
	   		}
	   }
	   else if(!$this->apply_teacher_model->change($data)){	//检查数据库是否操作成功
	   			$this->load->view('r2/teacher',$data);
	   			echo "<script>alert('修改失败，请重新操作')</script>";
	   }
	   else{	//操作成功返回原界面
	   		//$this->load->helper('url');
	   		//echo "<script>alert('修改成功')</script>";
	   		/*echo '<script>window.close();</script>';	//关闭该界面*/
	   		//$urls = base_url();
	   		//$url = "{$url}admin_apply";
	   		//echo $url;
	   		//Header("Location: $url");
	   		redirect("r2/admin_apply");
	   }
	   $this->load->helper('url');
	}
}
?>