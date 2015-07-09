<?php
if (!defined('BASEPATH')) {
	exit('Access Denied');
}

class Ims_add_teacher extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if ($this->session->userdata('is_logged_in') == False) {
			redirect('login');
		}
		//装载后端model
		$this->load->model('ims/add_teacher_model');
	}

	public function index($info = NULL, $func = 0, $ret_result = 0, $error_info = NULL) {
		$data['navi'] = 2;
		$data['uid'] = $this->session->userdata('uid');
		$data['type'] = $this->session->userdata('user_type');
		$data['func'] = $func;
		if ($info != NULL) {
			//根据用户ID显示用户的详细信息
			$data['info'] = $this->add_teacher_model->readInfo($info);
		}
		//返回操作结果的信息
		$data['result_num'] = $ret_result;
		$data['result_info'] = $error_info;
		$this->load->view('template/header');
		$this->load->view('template/navigator2', $data);
		$this->load->view('template/side_navi');
		$this->load->view('ims/ims_add_teacher');
	}

	public function manage($func) {
		$a = $this->input->post();
		if ($this->input->post('delete')) {
			//删除用户
			$ret = $this->deleteInfo($a);
		} elseif ($this->input->post('submit')) {
			//添加或修改用户信息
			$ret = $this->writeInfo($a, $func);
		}
		if ($ret === 0) {
			//操作成功
			$this->index(NULL, 0, 1, NULL);
		} else {
			//操作失败
			$this->index(NULL, 0, 2, $ret);
		}
	}

	public function writeInfo($a, $func) {
		$info = array('uid' => $a['uid'],
			'name' => $a['name'],
			'sex' => ($a['sex'] == NULL) ? NULL : $a['sex'],
			'email' => ($a['email'] == NULL) ? NULL : $a['email'],
			'phone' => ($a['phone'] == NULL) ? NULL : $a['phone'],
			'nation' => ($a['nation'] == NULL) ? NULL : $a['nation'],
			'birthday' => ($a['birthday'] == NULL) ? NULL : $a['birthday'],
			'college' => ($a['college'] == NULL) ? NULL : $a['college'],
			'department' => ($a['department'] == NULL) ? NULL : $a['department'],
			'education' => ($a['education'] == NULL) ? NULL : $a['education'],
			'position' => ($a['position'] == NULL) ? NULL : $a['position'],
			'info' => ($a['info'] == NULL) ? NULL : $a['info'],
		);
		if ($func == 0) {
			//添加用户
			$ret = $this->add_teacher_model->writeInfo($info);
		} else {
			//修改用户
			$ret = $this->add_teacher_model->modifyInfo($info);
		}
		return $ret;
	}

	public function deleteInfo($a) {
		//删除用户
		$info = array('uid' => $a['uid']);
		$ret = $this->add_teacher_model->deleteInfo($info);
		return $ret;
	}

	public function batchInsert() {
		$a = $this->input->post();
		$obj = json_decode($a['batch'], true);
		// die(var_dump($obj));
		$ret = $this->add_teacher_model->batchInsert($obj);
		if ($ret === 0) {
			//操作成功
			$this->index(NULL, 0, 1, NULL);
		} else {
			//操作失败
			$this->index(NULL, 0, 2, $ret);
		}
	}
}
?>