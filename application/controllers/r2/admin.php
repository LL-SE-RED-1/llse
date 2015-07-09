<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{
	public function index(){
	   $this->load->view('r2/admin');
	   $this->load->helper('url');
	   //$this->load->model('createdatabase');
	   //$this->createdatabase->test();
	}
}