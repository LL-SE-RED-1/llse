<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class teacher extends CI_Controller{
	public function index(){
	   $this->load->view('r2/teacher');
	   $this->load->helper('url');
	}
}