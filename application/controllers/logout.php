<?php

/*
* Logout Controller
* Implement welcome function
* author: lzx
*/

if( ! defined('BASEPATH')){
	exit('Access Denied');
}

class Logout extends CI_Controller
{
	public function index()
	{
		//unset sessions
		$this->session->unset_userdata('uid');
		$this->session->unset_userdata('userType');
		$this->session->unset_userdata('is_logged_in');

		//redirect to login page
		redirect('login');
	}
}
