<?php 
	class r3_Score_model extends CI_Model{
		//根据学生id返回学生所有修读的课的成绩
		public function get_all_by_sid($sid){
			$this->db->select('*')
				->from('score_record')
				->where('student_id ', $sid);
			$res = $this->db->get();
			return $res->result();
		}
		//
		public function get_score_by_sidcid($sid, $Cid){
			$this->db->select('*')
				->from('score_record')
				->where('student_id ', $sid)
				->where('course_id ', $Cid);
			$res = $this->db->get();
			return $res->result();
		}
		public function get_state_by_sidCid($sid, $Cid){
			$this->db->select('*')
				->from('score_record')
				->where('student_id ', $sid)
				->where('course_id ', $Cid);
			$res = $this->db->get();
			$result = $res->result();
			if (count($result) <= 0)
				return 0;
			if ($result[0]->score < 60)
				return 0;
			else
				return 1;
		}
	}

?>

