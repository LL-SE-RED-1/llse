<?php 
	//这是替第二组实现的接口，以后以二组的代码为准
	class r3_Class_model extends CI_Model{
		//根据一门课的教学班id给它评分
		public function assess_class_by_cid($sid, $cid, $score){
			//先得到这门教学班的所有信息
			$res = $this->db->select('*')
				->from('class')
				->where('class_id ', $cid)
				->get();
			$result = $res->result(); //该教学班所有信息存在$result中

			//构造一条update记录，改变这门课的评分
			$update = array(
				'assess_score' => $result[0]->assess_score + $score,
				'assess_num' => $result[0]->assess_num + 1
				);
			$this->db->where('class_id ', $cid); //先找出class表中的这门教学班
			$this->db->update('class', $update); //修改其评分

			$update2 = array(
				'assessed' => 1
				);
			$this->db->where('class_id ', $cid);
			$this->db->where('student_id ', $sid);
			$this->db->update('score_record', $update2);
		}
		//返回教学班的所有专业类型
		public function get_all_type(){
			$res = $this->db->select('type')
				->distinct()
				->from('class')
				->get();
			return $res->result();	
		}
		//根据课程id，返回他的教学班的所有信息，可能不止一个教学班
		public function get_class_all($Cid){
			$res = $this->db->select('*')
				->from('class')
				->where('course_id ', $Cid) //比较符前要有空格
				->get();
			return $res->result();
		}
		//根据教学班id返回它的所有信息
		public function get_class_by_id($cid){
			$res = $this->db->select('*')
				->from('class')
				->where('class_id ', $cid)
				->get();
			return $res->result();
		}
		//根据老师id，返回他自己开设的所有教学班
		public function get_class_by_tid($tid){
			$res = $this->db->select('class_id, course_id, class_name, year, season, day, class_time, assess_score, assess_num')
				->from('class')
				->where('teacher_id ', $tid)
				->order_by('class_time', 'asc')
				->order_by('day', 'asc')
				->get();
			return $res->result();	
		}
		//根据教学班id返回他的上课时间和考试时间
		public function get_time_by_cid($cid){
			$res = $this->db->select('day, class_time, test_time')
				->from('class')
				->where('class_id', $cid)
				->get();
			return $res->result();
		}
		//根据教学班id返回它的余量
		public function get_margin_by_cid($cid){
			$res = $this->db->select('margin, capacity')
				->from('class')
				->where('class_id', $cid)
				->get();
			return $res->result();
		}
	}