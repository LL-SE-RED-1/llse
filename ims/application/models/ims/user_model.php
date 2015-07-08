<?php

class User_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		//load database
		$this->load->database();
		$this->load->model('ims/ims_interface_model');
	}

	//verify whether the user exists
	public function verify_user($post) {
		$where_array = array('uid' => $post['uid'],
			'password' => md5($post['password']),
			'type' => $post['userType']);
		//search in database
		$query = $this->db->get_where('imsUser', $where_array);

		if ($query->num_rows == 1) {
			//if exists
			return TRUE;
		} else {
			//if not exists
			return FALSE;
		}

	}

	//modify user's password in database
	public function modify_pass($post) {
		$data = array(
       		'password' => md5($post['new_pass'])
    	);

		//update data in database
		$result = $this->db->update('imsUser', $data, array('uid' => $post['uid'],
															'type' => $post['userType']));

		//return the result of update
		return $result;
	}

	public function get_user($uid){
		$data = array(
				'uid' => $uid
			);

		$result = $this->db->get_where('imsUser',$data);

		if($result->num_rows == 1){
			return $result->row_array();
		}
		else{
			return false;
		}
	}

}