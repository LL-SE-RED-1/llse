<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class room_apply extends CI_Controller{
	public function index(){
	   $id = $_GET["classroom_id"];
	   $this->load->model('r2/room_apply_model');
	   $data = $this->room_apply_model->test($id);
	   $this->load->view('default/room_apply',$data);
	   $this->load->helper('url');
	}
}