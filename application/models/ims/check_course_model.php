<?php

class Check_course_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('ims/ims_interface_model');
	}

	public function search($info) {
		$query = $this->db->get_where('imsCourseReq', $info);
		return $query->result_array();
	}

	public function searchAll() {
		$query = $this->db->get('imsCourseReq');
		return $query->result_array();
	}

}
?>