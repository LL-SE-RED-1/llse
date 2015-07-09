<?php
	class r3_session_model extends CI_Model{
		public function get_online_user_num(){
			$res = $this->db->select('*')
				->from('ci_sessions')
				->get();
			$result = $res->result();
			return count($result);


		}
	}
?>