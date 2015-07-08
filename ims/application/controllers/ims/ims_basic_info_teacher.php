<?php
if (!defined('BASEPATH')) {
	exit('Access Denied');
}

class Ims_basic_info_teacher extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if ($this->session->userdata('is_logged_in') == False) {
			redirect('login');
		}
		$this->load->model('ims/basic_info_teacher_model');

	}

	public function index($file_info = '') {

		$data['navi'] = 1;
		$data['uid'] = $this->session->userdata('uid');
		$data['type'] = $this->session->userdata('user_type');
		$data['basicInfo'] = $this->basic_info_teacher_model->readInfo($data['uid']);
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

		$this->load->view('template/header', $data);
		$this->load->view('template/navigator');
		$this->load->view('template/side_navi');
		$this->load->view('ims/ims_basic_info_teacher', $data);

	}

	public function update() {
		if ($this->session->userdata('is_logged_in') == False) {
			redirect('login');
		} else {
			if ($this->input->post("save")) {
				// echo ("<script> console.log('lala') </script>");
				$info = array('sex' => $this->input->post('sex'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'birthday' => $this->input->post("birthday"),
					'nation' => $this->input->post('nation'),
					'info' => $this->input->post('info'),
				);
				$this->basic_info_teacher_model->writeInfo($info, $this->session->userdata('uid'));
				redirect('ims/ims_basic_info_teacher');
			} else {
				redirect('ims/ims_basic_info_teacher');
			}
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
		redirect("ims/ims_basic_info_teacher/index/" . $file_info);

	}
}
?>