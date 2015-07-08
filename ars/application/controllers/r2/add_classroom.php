<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class add_classroom extends CI_Controller{
	public function index(){
	   $this->load->view('default/add_classroom');
	  // $this->load->model('r2/createdatabase');
	   //$this->createdatabase->test();
	   $this->load->helper('url');
	}
}