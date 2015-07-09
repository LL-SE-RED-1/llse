<?php
if (!defined('BASEPATH')) {
	exit('Access Denied');
}

class Ims_add_assistant extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if ($this->session->userdata('is_logged_in') == False) {
			//判断是否登陆
			redirect('login');
		}
		//装在对应的model
		$this->load->model('ims/user_model');
		$this->load->model('ims/assistant_model');
	}

	public function index($info = NULL, $func = 0, $ret_result = 0, $error_info = NULL) {
		if ($this->session->userdata('user_type') != 3 and $this->session->userdata('user_type') != 4) {
		} else {
			$data['navi'] = 2;
			$data['uid'] = $this->session->userdata('uid');
			//用户类型和访问类型
			$data['type'] = $this->session->userdata('user_type');
			$data['func'] = $func;
			if ($info != NULL) {
				$data['info'] = $this->assistant_model->readInfo($info);
			}
			//操作结果
			$data['result_num'] = $ret_result;
			$data['result_info'] = $error_info;
			$this->load->view('template/header');
			$this->load->view('template/navigator2', $data);
			$this->load->view('template/side_navi');
			$this->load->view('ims/Ims_add_assistant');
		}
	}

	public function manage($func) {
		$a = $this->input->post();
		if ($this->input->post('delete')) {
			//删除
			$ret = $this->deleteInfo($a);
		} elseif ($this->input->post('submit')) {
			//添加或修改
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

	public function batchInsert() {
		$a = $this->input->post();
		$obj = json_decode($a['batch'], true);
		$ret = $this->assistant_model->batchInsert($obj);
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
			'addStu' => isset($a['addStu']),
			'addTea' => isset($a['addTea']),
			'addCour' => isset($a['addCour']),
			'seaStu' => isset($a['seaStu']),
			'seaTea' => isset($a['seaTea']),
			'seaCour' => isset($a['seaCour'])
		);
		if ($func == 0) {
			//添加操作
			$ret = $this->assistant_model->writeInfo($info);
		} else {
			//修改操作
			$ret = $this->assistant_model->modifyInfo($info);
		}
		// die(var_dump($ret));
		return $ret;
	}

	public function deleteInfo($a) {
		//删除操作
		$info = array('uid' => $a['uid'],
		);
		$ret = $this->assistant_model->deleteInfo($info);
		return $ret;
	}



}
?>