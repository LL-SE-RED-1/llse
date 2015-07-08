
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class teacher_search extends CI_Controller{
	function teacher_search(){
		parent::__construct();
	}
	public function index(){
		$this->load->model('r2/t_search_model');
		//如果都为空是没有输入
	   	if ((empty($_POST["tc_name"]))&&(empty($_POST["campus"]))){$teacher_id=$_GET['teacher_id'];
	   		$data['search']=$this->t_search_model->initial_table($teacher_id);
	   		$this->load->view('r2/teacher_search',$data);//echo "<script>alert('请输入查询信息')</script>";
	   	}
	   	//有教师内容输入
	   	else if (!empty($_POST["tc_name"])){
			$data['search']=$this->t_search_model->get_teacher_table();
	   		$this->load->view('r2/teacher_search',$data);
	   	}
	   	//有教室内容输入
	   	else {
	   		$data['search']=$this->t_search_model->get_where_table();
	   		$this->load->view('r2/teacher_search',$data);
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