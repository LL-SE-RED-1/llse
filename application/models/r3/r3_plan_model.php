<?php
	class r3_planInfo{
		public $student_id;
		public $course_id;
	}

	class r3_Plan_model extends CI_Model{
		//根据学生id返回培养方案中所有的课
		public function get_all_major($id){
			$res = $this->db->select('course_id ')
				->from('plan') //从plan表中找
				->where('student_id ', $id) //比较符前要有空格
				->order_by('course_id', 'asc')
				->get();
			return $res->result(); //返回他当前培养方案中的所有课
		}
		//为学生的培养方案中添加一门课
		public function add_major($id,$Cid){
			//先构造一条要插入的记录
			$data = array(
				'student_id' => $id,
				'course_id' => $Cid
			);
			$bool = $this->db->insert('plan', $data); //把记录插到plan表中
			return $bool; //返回操作结果
		}
		public function add_all_major($sid, $major){
			$this->load->model('r3/r3_Course_model', 'coursem');
			$result = $this->coursem->get_course_by_type($major);

			/*
			$res = $this->db->select('course_id')
				->from('course') //从plan表中找
				->where('type ', $major) //比较符前要有空格
				->where('course_type ', '专业必修课')
				->order_by('course_id', 'asc')
				->get();
			$result = $res->result();
			*/
			$n = count($result);
			for ($i = 0; $i < $n; $i++){
				if ($result[$i]->course_type != '专业必修课')
					continue;
				$tmp = $this->db->select('*')
					->from('plan') //从plan表中找
					->where('student_id ', $sid) //比较符前要有空格
					->where('course_id ', $result[$i]->course_id)
					->get();
				$tmpresult = $tmp->result();
				if (count($tmpresult) == 0){
					//先构造一条要插入的记录
					$data = array(
						'student_id' => $sid,
						'course_id' => $result[$i]->course_id
					);
					$bool = $this->db->insert('plan', $data); //把记录插到plan表中
				}
			}

			$update = array(
					'major_added' => 1
				);

			//$this->db->where('student_id ', $sid);  //TODO
			//$this->db->update('student', $update); //TODO
		}
		//为学生的培养方案中删除一门课
		public function delete_major($id,$Cid){
			//县构造一条要删除的记录
			$data = array(
				'student_id' => $id,
				'course_id' => $Cid,
			);
			$bool = $this->db->delete('plan', $data); //把记录删除掉
			return $bool; //返回操作结果
		}
		//判断学生的培养方案中是否有这门课
		public function is_selected($id,$Cid){
			$res = $this->db->select('course_id ')
				->from('plan') //在plan表中找
				->where('student_id ', $id) //先匹配学生id
				->where('course_id', $Cid) //再匹配课程id
				->get();
			return $res->result(); //返回结果
		}
	}
?>