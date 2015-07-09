<?php
if (!defined('BASEPATH')) {
	exit('Access Denied');
}

class Ims_management extends CI_Controller {
	public function __construct() {
		parent::__construct('ims/management_model');
	}

	public function index() {
		if ($this->session->userdata('is_logged_in') == False) {
			redirect('login');
		} else {
			$data['navi'] = 2;

			$data['uid'] = $this->session->userdata('uid');
			$data['type'] = $this->session->userdata('user_type');

			if($data['type'] == 6){
				$this->load->model('ims/assistant_model');
				$assistant = $this->assistant_model->readInfo($data['uid']);
				$data['assistant'] = $assistant;
			}

			$this->load->view('template/header');
			$this->load->view('template/navigator2', $data);

			$this->load->view('template/side_navi');
			$this->load->view('ims/ims_management');
		}
	}
}
?>