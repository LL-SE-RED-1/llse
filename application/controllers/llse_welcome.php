<?php

/*
* Ims_welcome Controller
* Welcome Page
* author: lzx
*/

if( ! defined('BASEPATH')){
	exit('Access Denied');
}

class Llse_welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// if not logged in, redirect
		if($this->session->userdata('is_logged_in') == FALSE)
		 	redirect('login');
	}

	public function index()
	{
		// store data for views
		$data['navi'] = 0;
		$data['uid'] = $this->session->userdata('uid');
		$data['type'] = $this->session->userdata('user_type');

		// load views
		$this->load->view('template/header');
		$this->load->view('template/navigator',$data);
		$this->load->view('llse_template/side_navi',$data);
		$this->load->view('llse_welcome_view');
	}
}