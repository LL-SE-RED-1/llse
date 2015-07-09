<?php 
	class r3_teacherInfo{
		public $teacher_id;
		public $teacher_name;
		public $info;
	}

	class r3_Teacher_model extends CI_Model{
		//根据老师id返回老师的所有信息
		public function get_all_by_tid($tid){
			$this->load->model('ims/Ims_interface_model','imsm');
			$temp = array('uid'=>$tid);
			$temp2 = $this->imsm->search_teacher($temp);

			$nn = count($temp2);
			$res = array();
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_teacherInfo();
				$d->teacher_id = $temp2[$i]['uid'];
				$d->teacher_name = $temp2[$i]['name'];
				$d->info = $temp2[$i]['info'];
				$res[] = $d;
			}
			return $res;

			/*
			$this->db->select('*')
				->from('teacher')
				->where('teacher_id ', $tid);
			$res = $this->db->get();
			return $res->result();
			*/
		}
	}

?>

