<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller{
	function Search(){
		parent::__construct();
	}
	public function index(){
		$this->load->model('r2/Search_model');
		//如果都为空是没有输入
	   	if ((empty($_POST["tc_name"]))&&(empty($_POST["campus"]))){//$teacher_id=$_GET['teacher_id'];
	   		$data['search']=$this->Search_model->initial_table();//$teacher_id);
	   		$this->load->view('r2/Search',$data);//echo "<script>alert('请输入查询信息')</script>";
	   	}
	   	//有教师内容输入
	   	else if (!empty($_POST["tc_name"])){
	   		$check=$this->Search_model->get_teacher_table()->result_array();
	   		$data = array();
	   		//echo $check;
	   		if(!$check){
	   			echo "<script>alert('该老师不存在')</script>";
	   			$data['search'] = array();
	   		}
	   		else
				$data['search']=$this->Search_model->get_teacher_table()->result_array();
	   		$this->load->view('r2/Search',$data);
	   	}
	   	//有教室内容输入
	   	else {
	   		$check=$this->Search_model->get_where_table();
	   		if(!$check){
	   			echo "<script>alert('该教室不存在')</script>";
	   			$data['search'] = array();
	   		}
	   		else
				$data['search']=$check;
	   		$this->load->view('r2/Search',$data);
	   	}
	  // $typecheck=$this->Search_model->typecheck();
	  // switch ($typecheck){
	  //  case 0:$this->load->view('default/Search');
	  // 		echo "<script>alert('请输入查询信息')</script>";
	  // 	 	break;
	   //	case 1:

	        
	   		//break;
	   	/*case 2:$data['schedule']=$this->Search_model->get_classroom_table();
	   	 	$this->load->view('default/Search',$data);
	   	 	break;*/
	      
	   $this->load->helper('url');
	}
}