<?php
if (!defined('BASEPATH')) {
	exit('Access Denied');
}
class Ims_request_manage extends CI_Controller {
	public function __construct() {
		parent::__construct();
		if ($this->session->userdata('is_logged_in') == False) {
			redirect('login');
		}
		//装载后端model
		$this->load->model('ims/request_manage_model');
	}

	public function index($info = NULL, $func = 0, $ret_result = 0, $error_info = NULL) {
		$data['navi'] = 2;
		$data['uid'] = $this->session->userdata('uid');
		$data['type'] = $this->session->userdata('user_type');
		if ($info != NULL) {
			//根据申请id获得课程申请的详细信息
			$data['info'] = $this->request_manage_model->readInfo($info);
			$data['person'] = $this->request_manage_model->readPerson($data['info']['uid']);
		}

		$data['func'] = $func;
		//显示操作结果
		$data['result_num'] = $ret_result;
		$data['result_info'] = $error_info;
		$this->load->view('template/header');
		$this->load->view('template/navigator2', $data);
		$this->load->view('template/side_navi');
		$this->load->view('ims/ims_request_manage');
	}

	public function manage($func, $rid = 0) {
		$a = $this->input->post();
		if ($func == 1) {
			if ($this->input->post('delete')) {
				$ret = $this->updateInfo($a, 1, $rid);
			} else {
				$ret = $this->updateInfo($a, 0, $rid);
			}
		} else {
			$ret = $this->writeInfo($a);
		}
		if ($ret === 0) {
			//操作成功
			$this->index(NULL, 0, 1, NULL);
		} else {
			//操作失败
			$this->index(NULL, 0, 2, $ret);
		}
	}

	//同意或不同意申请
	public function updateInfo($a, $t, $rid) {
		$ret = $this->request_manage_model->updateInfo($a, $t, $rid);
		return $ret;
	}
	//教师提交申请
	public function writeInfo($a) {
		$ret = $this->request_manage_model->writeInfo($a);
		return $ret;
	}

}
?>