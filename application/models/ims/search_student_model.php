<?php
class Search_student_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('ims/ims_interface_model');
	}

	public function search($info) {
		//根据条件select信息
		$query = $this->db->get_where('imsStudent', $info);
		return $query->result_array();
	}
	public function searchAll() {
		//返回所有信息
		$query = $this->db->get('imsStudent');
		return $query->result_array();
	}
}
?>