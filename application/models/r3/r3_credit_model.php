<?php 
	class r3_Credit_model extends CI_Model{
		//根据专业学院返回专业的学分要求
		public function get_all_by_department($d){
			$this->db->select('*')
				->from('credit_requirement');
			$this->db->like('department', $d);
			$res = $this->db->get();
			return $res->result();
		}
		//设置某专业的学分要求
		public function set_credit_requirement($major, $mincredit, $minoption, $mincommon){
			$this->db->select('*')
				->from('credit_requirement');
			$this->db->where('department', $major);
			$tmp = $this->db->get();
			$n = count($tmp);
			if ($n > 0){
				$data = array(
               		'department' => $major,
               		'credit_min' => $mincredit,
               		'option_min' => $minoption,
               		'common_min' => $mincommon
            	);
            	$this->db->where('department ', $major);
            	$this->db->update('credit_requirement', $data);
			}
			else
			{
				$data = array(
               		'department' => $major,
               		'credit_min' => $mincredit,
               		'option_min' => $minoption,
               		'common_min' => $mincommon
            	);
				$this->db->insert('credit_requirement', $data);
			}
		}
	}

?>

