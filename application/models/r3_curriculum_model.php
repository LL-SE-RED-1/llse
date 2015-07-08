<?php 
	class r3_Curriculum_model extends CI_Model{
		//通过学生id返回他选上的所有教学班
		public function get_all_class($id){
			$res = $this->db->select('course_id, class_name, day, class_time')
				->from('curriculum') //从curriculum表中取数据
				->where('student_id ', $id) //匹配学生id
				->order_by('class_time', 'asc') //结果以上课时间排序
				->order_by('day', 'asc')
				->get();
			return $res->result();	//返回结果
		}
		//通过学生id返回他选上的所有教学班的课程id
		public function get_all_course($id){
			$res = $this->db->select('course_id') //只返回课程id
				->from('curriculum') //从curriculum表中取数据
				->where('student_id ', $id)
				->order_by('course_id', 'asc') //以课程id排序
				->get();
			return $res->result();
		}
		//通过学生id和课程id，判断该学生是否选了这门课
		public function whether_select($Uid, $Cid){
			$this->db->select('class_id')
					->from('curriculum');
			$this->db->where('course_id ', $Cid); //先匹配课程id
			$this->db->where('student_id ', $Uid); //再匹配学生id
			$res = $this->db->get();
			return $res->result();
		}
		//通过学生id和教学班id，判断该学生是否选了这门课
		public function whether_select_class($Uid, $cid){
			$this->db->select('class_id')
					->from('curriculum');
			$this->db->where('class_id ', $cid); //先匹配教学班id
			$this->db->where('student_id ', $Uid); //在匹配学生id
			$res = $this->db->get();
			return $res->result();
		}
		//为学生增加一门课
		public function add_class($Uid, $cid){
			//先得到这门教学班的所有信息
			$res = $this->db->select('*')
				->from('class')
				->where('class_id ', $cid)
				->get();
			$result = $res->result(); //该教学班所有信息存在$result中

			//根据$result和学生id构造出一条要插入curriculum表中的一条记录
			$data = array(
               'student_id' => $Uid,
               'class_id' => $result[0]->class_id,
               'class_name' => $result[0]->class_name,
               'day' => $result[0]->day,
               'class_time' => $result[0]->class_time,
               'course_id' => $result[0]->course_id
            );
			$this->db->insert('curriculum', $data); //为学生加上这门课

			//加上这门课后，教学班余量会改变，构造一条update记录，改变class表
			$update = array(
				'class_id' => $result[0]->class_id,
				'class_name' => $result[0]->class_name,
				'course_id' => $result[0]->course_id,
				'type' => $result[0]->type,
				'teacher_id' => $result[0]->teacher_id,
				'teacher_name' => $result[0]->teacher_name,
				'classroom' => $result[0]->classroom,
				'day' => $result[0]->day,
				'class_time' => $result[0]->class_time,
				'margin' => $result[0]->margin-1,   //这里是关键，原来的余量margin减1了
				'capacity' => $result[0]->capacity
				);
			$this->db->where('class_id ', $cid); //先找出class表中的这门教学班
			$this->db->update('class', $update); //修改其余量
		}
		//为学生删除一门课
		public function delete_class($Uid, $cid){
			//先直接在curriculum中删除这条记录
			$this->db->delete('curriculum', array('student_id' => $Uid, 'class_id' => $cid)); 

			//以下是去class表中修改相应教学班的余量
			//找出这门教学班的所有信息
			$res = $this->db->select('*')
				->from('class')
				->where('class_id ', $cid)
				->get();
			$result = $res->result();
			//构造一条update记录，修改class表
			$update = array(
				'class_id' => $result[0]->class_id,
				'class_name' => $result[0]->class_name,
				'course_id' => $result[0]->course_id,
				'type' => $result[0]->type,
				'teacher_id' => $result[0]->teacher_id,
				'teacher_name' => $result[0]->teacher_name,
				'classroom' => $result[0]->classroom,
				'day' => $result[0]->day,
				'class_time' => $result[0]->class_time,
				'margin' => $result[0]->margin+1, //这里是关键，原来的余量margin加1了
				'capacity' => $result[0]->capacity
				);
			$this->db->where('class_id ', $cid); //先找出class表中的这门教学班
			$this->db->update('class', $update); //修改其余量

		}
		//教学班id，找出所有学生的id
		public function get_student_by_cid($cid){
			$res = $this->db->select('student_id')
				->from('curriculum') //从curriculum表中找
				->where('class_id ', $cid)
				->get();
			return $res->result(); //返回这门教学班的学生列表
		}
		public function get_all_by_cid($cid){
			$res = $this->db->select('*')
				->from('curriculum') //从curriculum表中找
				->where('class_id ', $cid)
				->get();
			return $res->result(); //返回这门教学班的所有列表
		}
		//根据学生id，找到他上的所有课的上课时间
		public function get_time_by_sid($sid){
			$res = $this->db->select('day, class_time, test_time')
				->from('curriculum') //从curriculum表中找
				->where('student_id ', $sid)
				->order_by('day', 'asc')
				->get();
			return $res->result(); //返回他所有课的上课时间
		}
	}



/*



<?php
	class Curriculum_model extends CI_Model{
		public function get_all_class($id){
			
			$res = $this->db->select('class_id, class_name')
				->from('curriculum')
				->where('student_id ', $id) //比较符前要有空格
				//->order_by('class_time', 'asc')
				//->order_by('day', 'asc')
				->get();
			return $res->result();
		}
		public function add_class($id,Cid,$name){
			$data = array(
				'student_id' => $id,
				'class_id' => $cid,
				'class_name' => $name,
			);
			$bool = $this->db->insert('curriculum', $data);
			return $bool;
		}
		public function delete_class($id,$Cid){
			$data = array(
				'student_id' => $id,
				'class_id' => $cid,
			);
			$bool = $this->db->delete('curriculum', $data);
			return $bool;
		}
	}
?>


*/