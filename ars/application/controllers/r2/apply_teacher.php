<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class apply_teacher extends CI_Controller{
	public function index(){
	   $id = $_GET["class_id"];
	   $this->load->model('r2/apply_teacher_model');
	   $data = $this->apply_teacher_model->test($id);
	   $this->load->view('default/teacher',$data);
	   $this->load->helper('url');
	}
}