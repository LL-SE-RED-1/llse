<?php

class Basic_info_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('ims/ims_interface_model');
	}

	public function readInfo($userID) {
		//根据条件读取用户基本信息
		$result = $this->db->get_where('imsStudent', array('uid' => $userID));
		return $result->row_array();
	}

	public function writeInfo($info, $userID) {
		//根据条件，更新用户基本信息
		$this->db->update('imsStudent', $info, array('uid' => $userID));
	}
}
?>
