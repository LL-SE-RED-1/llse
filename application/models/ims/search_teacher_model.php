<?php
class Search_teacher_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('ims/ims_interface_model');
	}

	public function search($info) {
		//根据条件select信息
		$query = $this->db->get_where('imsTeacher', $info);
		return $query->result_array();
	}

	public function searchAll() {
		//返回所有信息
		$query = $this->db->get('imsTeacher');
		return $query->result_array();
	}
}
?>