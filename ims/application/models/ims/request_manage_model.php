<?php

class Request_manage_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->helper('date');
		$this->load->database();
		date_default_timezone_set("Asia/Shanghai");
		$this->load->model('ims/ims_interface_model');
	}

	public function writeInfo($a) {
		// $datestring = "Year: %Y Month: %m Day: %d - %h:%i %a";
		// $time = mdate($datestring, time());
		$time = date("Y-m-d H:i:s", now());
		if (!$this->db->insert('imsCourseReq',
			array(
				'cid' => $a['cid'],
				'uid' => $this->session->userdata['uid'],
				'name' => $a['name'],
				'time' => $time,
				'reason' => ($a['reason'] == NULL) ? NULL : $a['reason'],
				'state' => 0,
				'ctype' => $a['ctype'],
				'college' => $a['college'],
				'department' => $a['department'],
				'credit' => $a['credit'],
				'semester' => $a['semester'],
				'info' => ($a['info'] == NULL) ? NULL : $a['info'],
			)
		)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}

		return 0;
	}
	//管理员管理课程申请
	public function updateInfo($a, $t, $rid) {
		$this->db->where('rid', $rid);
		if ($t == 1) {
			//不同意申请
			if (!$this->db->update('imsCourseReq', array('state' => 2))) {
				$data['class'] = 2;
				$data['description'] = $this->db->_error_message();
				$this->ims_interface_model->write_log($data);
				return $this->db->_error_message();
			}

		} else {
			//同意申请
			if (!$this->db->update('imsCourseReq', array('state' => 1))) {
				$data['class'] = 2;
				$data['description'] = $this->db->_error_message();
				$this->ims_interface_model->write_log($data);
				$this->db->_error_message();
			}

			if (!$this->db->insert('imsCourse', array(
				'cid' => $a['cid'],
				'name' => $a['name'],
				'ctype' => $a['ctype'],
				'college' => $a['college'],
				'department' => $a['department'],
				'credit' => $a['credit'],
				'semester' => $a['semester'],
				'info' => $a['info'],
			)
			)) {
				$data['class'] = 2;
				$data['description'] = $this->db->_error_message();
				$this->ims_interface_model->write_log($data);
				$this->db->_error_message();
			}

			//反馈
		}
		return 0;
	}

	public function readInfo($info) {
		$query = $this->db->get_where('imsCourseReq', array('rid' => $info));
		return $query->row_array();
	}

	public function readPerson($ID) {
		$query = $this->db->get_where('imsTeacher', array('uid' => $ID));
		$result = $query->row_array();
		var_dump($result);
		return $result['name'];
	}
}
?>