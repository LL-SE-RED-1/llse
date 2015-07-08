<?php
/*
* System Information Model
* author: lzx
*/

class Sys_info_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('ims/ims_interface_model');
	}

	// get system information
	public function get_sys_info() {
		// search the database
		$sys_info = $this->db->get_where('imsSysInfo', array('active' => TRUE));

		if ($sys_info->num_rows() == 1) {
			// if there is only one row, then return the row
			return $sys_info->row_array();
		} else {
			// else there are some trouble in datbase
			// construct a row to return 
			$sys_info = array('semester' => 0,
				'begin_time' => '0000-00-00',
				'end_time' => '0000-00-00',
				'active' => FALSE);
			return $sys_info;
		}
	}

	// get log records
	public function get_log($limit = 10, $offset = 0) {
		//get $limit records from $offset
		$query = $this->db->get('imsLog', $limit, $offset);

		//return result
		return $query->result_array();
	}

	// get statistic of log records
	public function get_statistic() {
		// get numbers of log records of different class
		$info_query = $this->db->get_where('imsLog', array('class' => 0));
		$warning_query = $this->db->get_where('imsLog', array('class' => 1));
		$error_query = $this->db->get_where('imsLog', array('class' => 2));

		// store the statistic numbers
		$stati['info'] = $info_query->num_rows();
		$stati['warning'] = $warning_query->num_rows();
		$stati['error'] = $error_query->num_rows();

		return $stati;
	}

	// write log record
	public function write_log($post)
	{
		// construct log record
		$data = array(
				'class' => $post['class'],
               	'uid' => $post['uid'],
               	'ip' => $post['ip'],
               	'time' => $post['time'],
               	'description' => $post['description']
            );

		// insert this record
		$result = $this->db->insert('imsLog', $data); 

		// return result of insert
		return $result;
	}
}