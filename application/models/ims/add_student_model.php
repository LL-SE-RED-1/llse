<?php
class Add_student_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('ims/ims_interface_model');
	}

	public function batchInsert($info) {
		// die(var_dump($info[0]));
		if (!$this->db->insert_batch('imsStudent', $info)) {
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
				'type' => 1,
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

	//创建新的学生，返回操作结果
	public function writeInfo($info) {
		// die(var_dump($info));
		if (!$this->db->insert('imsStudent', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}

		if (!$this->db->insert('imsUser', array(
			'uid' => $info['uid'],
			'password' => md5($info['uid']),
			'type' => 1,
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

	//根据信息，删除指定学生
	public function deleteInfo($info) {
		if (!$this->db->delete('imsUser', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}
		if (!$this->db->delete('imsStudent', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}
		return 0;
	}

	//修改学生信息
	public function modifyInfo($info) {
		if (!$this->db->where('uid', $info['uid'])) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}

		if (!$this->db->update('imsStudent', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}

		return 0;
	}

	//根据学生UID，读取学生基本信息
	public function readInfo($info) {
		$result = $this->db->get_where('imsStudent', array('uid' => $info));
		return $result->row_array();
	}
}
?>