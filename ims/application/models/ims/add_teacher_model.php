<?php
class Add_teacher_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('ims/ims_interface_model');
	}

	public function batchInsert($info) {
		if (!$this->db->insert_batch('imsTeacher', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}
		$user_info = array();
		foreach ($info as $ele) {
			$user_info[] = array('uid' => $ele['uid'],
				'password' => md5($ele['uid']),
				'type' => 2,
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

	//创建新的老师，返回操作结果
	public function writeInfo($info) {
		if (!$this->db->insert('imsTeacher', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}

		if (!$this->db->insert('imsUser',
			array('uid' => $info['uid'],
				'password' => md5($info['uid']),
				'type' => 2,
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
	//删除教师
	public function deleteInfo($info) {
		if (!$this->db->delete('imsUser', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}

		if (!$this->db->delete('imsTeacher', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}

		return 0;
	}

	//根据传入信息，修改教师基本信息
	public function modifyInfo($info) {
		if (!$this->db->where('uid', $info['uid'])) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}

		if (!$this->db->update('imsTeacher', $info)) {
			$data['class'] = 2;
			$data['description'] = $this->db->_error_message();
			$this->ims_interface_model->write_log($data);
			return $this->db->_error_message();
		}

		return 0;
	}

	//根据用户ID，读取教师基本信息
	public function readInfo($info) {
		$query = $this->db->get_where('imsTeacher', array('uid' => $info));
		return $query->row_array();
	}
}
?>