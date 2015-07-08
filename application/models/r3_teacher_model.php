<?php 
	class r3_Teacher_model extends CI_Model{
		//根据老师id返回老师的所有信息
		public function get_all_by_tid($tid){
			$this->db->select('*')
				->from('teacher')
				->where('teacher_id ', $tid);
			$res = $this->db->get();
			return $res->result();
		}
	}

?>

