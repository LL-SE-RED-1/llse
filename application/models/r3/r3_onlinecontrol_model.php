<?php
	class r3_onlinecontrol_model extends CI_Model{
		//设置选课时间
		public function set_online_control($num, $time){
			$this->db->empty_table('r3_online_control'); //先把原来的选课时间删掉
			//构造一条要插入的选课时间记录
			$data = array(
				'online_num' => $num,
				'online_control' => $time
			);
			$bool = $this->db->insert('r3_online_control', $data); //设置新的选课时间
			return $bool; //返回操作结果
		}
		/*
		public function get_time(){
			$res = $this->db->get('selecttime');
			return $res->result();
		}
		*/
		//返回系统中当前设置的选课时间
		public function get_online_control(){
			$res = $this->db->select('*') //直接返回所有东西，因为表中永远只有一条记录
				->from('r3_online_control')
				->get();
			return $res->result();
		}
	}
?>