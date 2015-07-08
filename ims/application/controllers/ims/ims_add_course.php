<?php
if (!defined('BASEPATH')) {
	exit('Access Denied');
}

class Ims_add_course extends CI_Controller {
	public function __construct() {
		//构造函数
		parent::__construct();
		if ($this->session->userdata('is_logged_in') == False) {
			//判断当前用户是否登陆
			redirect('login');
		}
		//装载对应的model
		$this->load->model('ims/add_course_model');
	}

	public function index($info = NULL, $func = 0, $ret_result = 0, $error_info = NULL) {
		$data['navi'] = 2;
		//当前访问的用户id和用户类型
		$data['uid'] = $this->session->userdata('uid');
		$data['type'] = $this->session->userdata('user_type');
		// die(var_dump($data['type']));
		if($data['type'] == 5){
			$data['college']=$this->add_course_model->getCollege($data['uid']);
		}
		//判断当前访问的类型
		$data['func'] = $func;
		if ($info != NULL) {
			$data['info'] = $this->add_course_model->readInfo($info);
		}
		// die(var_dump($data['info'],$data['college']));
		//操作的返回结果
		$data['result_num'] = $ret_result;
		$data['result_info'] = $error_info;
		$this->load->view('template/header');
		$this->load->view('template/navigator2', $data);
		$this->load->view('template/side_navi');
		$this->load->view('ims/ims_add_course');

	}

	public function manage($func) {
		$a = $this->input->post();
		// die(var_dump($a));
		if ($this->input->post('cancel')) {
			//删除操作
			$ret = $this->deleteInfo($a);
		} elseif ($this->input->post('submit')) {
			//修改或添加操作
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
		$info = array('cid' => $a['cid'],
			'name' => $a['name'],
			'semester' => $a['semester'],
			'credit' => $a['credit'],
			'ctype' => $a['ctype'],
			'college' => $a['college'],
			'department' => $a['department'],
			'classroom' => ($a['classroom'] == NULL) ? NULL : $a['classroom'],
			'etype' => ($a['etype'] == NULL) ? NULL : $a['etype'],
			'capacity' => ($a['capacity'] == NULL) ? NULL : $a['capacity'],
			'info' => ($a['info'] == NULL) ? NULL : $a['info'],
		);
		if ($func == 0) {
			//添加操作
			$ret = $this->add_course_model->writeInfo($info);
		} else {
			//修改操作
			$ret = $this->add_course_model->modifyInfo($info);
		}
		return $ret;
	}

	public function deleteInfo($a) {
		$info = array('cid' => $a['cid'],
		);
		$ret = $this->add_course_model->deleteInfo($info);
		return $ret;
	}

	public function batchInsert() {
		$a = $this->input->post();
		$info = json_decode($a['batch'], true);
		// die(var_dump($info));
		$ret = $this->add_course_model->batchInsert($info);
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