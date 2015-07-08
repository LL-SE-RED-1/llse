<?php

if (!defined('BASEPATH')) {
	exit('Access Denied');
}

class Ims_basic_info extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if ($this->session->userdata('is_logged_in') == False) {
			redirect('login');
		}
		$this->load->helper('form');
		$this->load->model('ims/basic_info_model');
	}

	public function index($file_info = '') {
		//echo ("<script>alert('我是弹窗')</script>");

		//echo ("<script> console.log('lala3') </script>");
		$data['basicInfo'] = $this->basic_info_model->readInfo($this->session->userdata('uid'));
		$data['navi'] = 1;

		$data['uid'] = $this->session->userdata('uid');
		$data['type'] = $this->session->userdata('user_type');
		if ($file_info == "success") {
			$data['file_info'] = "文件上传成功！";
		} else if ($file_info == "size") {
			$data['file_info'] = "文件大小超过限制！";
		} else if ($file_info == "type") {
			$data['file_info'] = "文件类型错误！";
		} else if ($file_info == "fail") {
			$data['file_info'] = "上传失败！";
		} else {
			$data['file_info'] = $file_info;
		}

		$this->load->view('template/header');
		$this->load->view('template/navigator', $data);

		$this->load->view('template/side_navi');
		$this->load->view('ims/ims_basic_info', $data);

	}

	public function update() {
		if ($this->input->post("save")) {
			$info = array('sex' => $this->input->post('sex'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'birthday' => $this->input->post("birthday"),
				'nation' => $this->input->post('nation'),
			);
			$this->basic_info_model->writeInfo($info, $this->session->userdata('uid'));
			redirect('ims/ims_basic_info');
		} else {
			redirect('ims/ims_basic_info');
		}
	}

	public function do_upload() {
		$this->load->helper('file');

		// die(var_dump($_FILES));
		if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/png")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/jpeg"))
			&& ($_FILES["file"]["size"] < 2000000)) {
			if ($_FILES["file"]["error"] > 0) {
				$file_info = "Error:" . $_FILES["file"]["error"];
			} else {
				if (file_exists("uploads/" . $this->session->userdata('uid'))) {
					delete_files('uploads/' . $this->session->userdata('uid'));
				}

				if (move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $this->session->userdata('uid'))) {
					$file_info = "success";
				} else {
					$file_info = "fail";
				}

			}
		} else {
			if ($_FILES["file"]["size"] > 2000000) {
				$file_info = "size";
			} else {
				$file_info = "type";
			}

		}
		//do not use refresh
		redirect('ims/ims_basic_info/index/' . $file_info);

	}
}

?>
