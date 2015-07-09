<?php
/*
* Permission Model
* author: lzx
*/

class Permission_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('ims/ims_interface_model');
	}

	// get all permission records
	public function get_per()
	{
		// query data from database
		$query = $this->db->get('imsPermission');

		// return the query results
		return $query->result_array();	
	}

	// create a permission record
	public function create_per($post)
	{
		// construct a permission record
		$data = array(
					'stuPermi' => $post['stu_per'],
					'teaPermi' => $post['tea_per'],
					'description' => $post['per_name']
					);

		// insert the permission into database
		$result = $this->db->insert('imsPermission', $data); 

		return $result;
	}
	
	// update a permission record
	public function update_per($post)
	{
		// construct an update query
		$data = array(
               		'stuPermi' => $post['stu_per'],
               		'teaPermi' => $post['tea_per']
            	);

		// update data in database
		$result = $this->db->update('imsPermission', $data, array('pid' => $post['pid']));

		return $result;
	}

	// delete the permission record
	public function delete_per($post)
	{
		// delete data from database
		$result = $this->db->delete('imsPermission', array('pid' => $post['pid'])); 

		return $result;
	}
}