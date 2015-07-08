<?php

/*
 * Ims_permission Controller
 * Management permission
 * author: lzx
 */

if (!defined('BASEPATH')) {
	exit('Access Denied');
}

class Ims_permission extends CI_Controller {
	public function __construct() {
		parent::__construct();
		#if not logged in
		if ($this->session->userdata('is_logged_in') == FALSE) {
			redirect('login');
		}

		$this->load->model('ims/permission_model');

	}

	public function index($result_num = 0) {
		//data used in view
		$data['navi'] = 3;
		$data['uid'] = $this->session->userdata('uid');
		$data['type'] = $this->session->userdata('user_type');
		$data['permission'] = $this->permission_model->get_per();
		$data['result_num'] = $result_num;
		switch ($result_num) {
			// if create succeed
			case 1:
				$data['result_info'] = "创建成功！";
				break;
			//if create failed
			case 2:
				$data['result_info'] = "创建失败，请重试。";
				break;
			//if update succceed
			case 3:
				$data['result_info'] = "更新成功！";
				break;
			//if update failed
			case 4:
				$data['result_info'] = "更新失败，请重试。";
				break;
			//if delete succeed
			case 5:
				$data['result_info'] = "删除成功！";
				break;
			//if delete failed
			case 6:
				$data['result_info'] = "删除失败，请重试。";
				break;
		}

		//load views
		$this->load->view('template/header');
		$this->load->view('template/navigator', $data);
		$this->load->view('template/side_navi', $data);
		$this->load->view('ims/ims_permission_view', $data);
	}

	public function create() {
		//store post data
		$post['per_name'] = $this->input->post('per_name');
		$post['stu_per'] = ($this->input->post('stu_per') == 'on');
		$post['tea_per'] = ($this->input->post('tea_per') == 'on');

		$result = $this->permission_model->create_per($post);

		if ($result) {
			//if create succeed,redirect,echo right info
			redirect('ims/ims_permission/index/1');
		} else {
			//if create failed, redirect,echo error info
			redirect('ims/ims_permission/index/2');
		}
	}

	public function modify($pid) {
		//if user click update
		if ($this->input->post('update')) {
			$this->update($pid);
		}

		//if user click delete
		else {
			$this->delete($pid);
		}

	}

	public function update($pid) {
		$post['pid'] = $pid;
		$post['stu_per'] = ($this->input->post('stu_per') == 'on');
		$post['tea_per'] = ($this->input->post('tea_per') == 'on');
		die(var_dump($post));

		$result = $this->permission_model->update_per($post);

		if ($result) {
			//if update succeed
			redirect('ims/ims_permission/index/3');
		} else {
			//if update failed
			redirect('ims/ims_permission/index/4');
		}
	}

	public function delete($pid) {
		$post['pid'] = $pid;
		$post['stu_per'] = ($this->input->post('stu_per') == 'on');
		$post['tea_per'] = ($this->input->post('tea_per') == 'on');

		$result = $this->permission_model->delete_per($post);

		if ($result) {
			//if delete succeed
			redirect('ims/ims_permission/index/5');
		} else {
			//if delete failed
			redirect('ims/ims_permission/index/6');

		}
	}

}
