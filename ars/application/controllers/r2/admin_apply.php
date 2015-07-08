<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_apply extends CI_Controller{
	function Admin_apply(){
		parent::__construct();
	}
	public function index(){
	   $this->load->model('r2/apply_model');
	   //处理一开始没有输入的情况
 	   if (empty($_GET['clid'])) $data['man_apply_tmp'] = $this->apply_model->get_application();
 	   //删除
	   else {
	   	$this->apply_model->delete_application();
	   	$data['man_apply_tmp'] = $this->apply_model->get_application();
	   }
	   $this->load->view('default/admin_apply',$data);
	   $this->load->helper('url');
	}
}