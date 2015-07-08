<?php

class Assistant_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		//load database
		$this->load->database();
		$this->load->model('ims/ims_interface_model');
	}

	public function search($info) {
		//根据条件select信息
		$query = $this->db->get_where('imsAssistant', $info);
		return $query->result_array();
	}

	public function searchAll() {
		//返回所有信息
		$query = $this->db->get('imsAssistant');
		return $query->result_array();
	}

	public function batchInsert($info) {
		// die(var_dump($info[0]));
		if (!$this->db->insert_batch('imsAssistant', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}
		$user_info = array();
		foreach ($info as $ele) {
			$user_info[] = array(
				'uid' => $ele['uid'],
				'password' => md5($ele['uid']),
				'type' => 6,
				'active' => 1,
			);
		}
		if (!$this->db->insert_batch('imsUser', $user_info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}
		return 0;
	}

	//创建新的助管，返回操作结果
	public function writeInfo($info) {
		if (!$this->db->insert('imsAssistant', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}

		if (!$this->db->insert('imsUser', array(
			'uid' => $info['uid'],
			'password' => md5($info['uid']),
			'type' => 6,
			'active' => 1,
		)
		)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}
		return 0;
	}

	//根据信息，删除指定助管
	public function deleteInfo($info) {
		if (!$this->db->delete('imsUser', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}
		if (!$this->db->delete('imsAssistant', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}
		return 0;
	}

	//修改助管信息
	public function modifyInfo($info) {
		if (!$this->db->where('uid', $info['uid'])) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}

		if (!$this->db->update('imsAssistant', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}

		return 0;
	}

	//根据助管UID，读取助管基本信息
	public function readInfo($info) {
		$result = $this->db->get_where('imsAssistant', array('uid' => $info));
		return $result->row_array();
	}

}