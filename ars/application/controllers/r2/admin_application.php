<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_application extends CI_Controller{
	function Admin_application(){
		parent::__construct();
	}
	public function index(){
	   $this->load->model('r2/application_model');
	   $data['application'] = $this->application_model->get_man_application();
	   $this->load->view('default/admin_application',$data);
	   $this->load->helper('url');
	}
}