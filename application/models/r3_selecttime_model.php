<?php
	class r3_Selecttime_model extends CI_Model{
		//设置选课时间
		public function set_time($sm, $sd, $sh, $em, $ed, $eh){
			$this->db->empty_table('selecttime'); //先把原来的选课时间删掉
			//构造一条要插入的选课时间记录
			$data = array(
				'start_month' => $sm,
				'start_day' => $sd,
				'start_hour' => $sh,
				'end_month' => $em,
				'end_day' => $ed,
				'end_hour' => $eh
			);
			$bool = $this->db->insert('selecttime', $data); //设置新的选课时间
			return $bool; //返回操作结果
		}
		/*
		public function get_time(){
			$res = $this->db->get('selecttime');
			return $res->result();
		}
		*/
		//返回系统中当前设置的选课时间
		public function get_original_time(){
			$res = $this->db->select('*') //直接返回所有东西，因为表中永远只有一条记录
				->from('selecttime')
				->get();
			return $res->result();
		}
	}
?>