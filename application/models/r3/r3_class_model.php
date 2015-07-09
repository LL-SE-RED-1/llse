<?php 
	//这是替第二组实现的接口，以后以二组的代码为准
	class r3_class{
		public $class_id;
		public $class_name;
		public $course_id;
		public $type;
		public $teacher_id;
		public $teacher_name;
		public $classroom;
		public $department;
		public $year;
		public $season;

		public $test_time;
		public $margin;
		public $capacity;
		public $assess_score;
		public $assess_num;
	}

	class r3_curriculum_teacher{
		public $class_id;
		public $class_name;
		public $day;
		public $class_time;
		public $course_id;
	}

	class r3_Class_model extends CI_Model{
		//根据一门课的教学班id给它评分
		public function assess_class_by_cid($sid, $cid, $score){
			//先得到这门教学班的所有信息
			/*
			$res = $this->db->select('*')
				->from('class')
				->where('class_id ', $cid)
				->get();
			$result = $res->result(); //该教学班所有信息存在$result中
			*/

			//构造一条update记录，改变这门课的评分
			$this->load->model('r2/Class_info_model', 'classscorem');
			$this->classscorem->edit_score($cid, $score);
			/*
			$update = array(
				'assess_score' => $result[0]->assess_score + $score,
				'assess_num' => $result[0]->assess_num + 1
				);
			$this->db->where('class_id ', $cid); //先找出class表中的这门教学班
			$this->db->update('class', $update); //修改其评分
			*/

			//下面是 TODO
			$update2 = array(
				'assessed' => 1
				);
			$this->db->where('class_id ', $cid);
			$this->db->where('student_id ', $sid);
			$this->db->update('score_record', $update2);
		}
		//返回教学班的所有专业类型
		public function get_all_type(){
			$this->load->model('r2/Search_model', 'classmm');
			$temp = array();
			$temp2 = $this->classmm->classinfo($temp);
			$nn = count($temp2);
			$res = array();
			for ($i = 0; $i < $nn; $i++){
				$n_tmp = count($res);
				$good = 1;
				for ($j = 0; $j < $n_tmp; $j++){
					if ($res[$j]->type == $temp2[$i]->college){
						$good = 0;
						break;
					}
				}
				if ($good == 1){
					$d = new r3_class();
					$d->type = $temp2[$i]->college;
					$res[] = $d;
				}

			}
			
			return $res;

			/*
			$res = $this->db->select('type')
				->distinct()
				->from('class')
				->get();
			return $res->result();	
			*/
		}
		//根据课程id，返回他的教学班的所有信息，可能不止一个教学班
		public function get_class_all($Cid){
			$this->load->model('r2/Search_model', 'classmm');
			$temp = array('course_id'=>$Cid);
			$temp2 = $this->classmm->classinfo($temp);
			$nn = count($temp2);
			$res = array();
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_class();
				
				$d->class_id = $temp2[$i]->class_id;
				$d->class_name = $temp2[$i]->course_name;
				$d->course_id = $temp2[$i]->course_id;
				$d->type = $temp2[$i]->college;
				$d->teacher_id = $temp2[$i]->teacher_id;
				$d->teacher_name = $temp2[$i]->teacher_name;
				
				$d->department = $temp2[$i]->college;
				$d->year = $temp2[$i]->year;
				$d->season = $temp2[$i]->season;

				$d->day = 1; //TODO
				$d->class_time = $temp2[$i]->sche;

				$d->test_time = $temp2[$i]->testtime;
				$d->margin = $temp2[$i]->margin;
				$d->capacity = $temp2[$i]->capacity;
				$d->assess_score = $temp2[$i]->assess_score;
				$d->assess_num = $temp2[$i]->assess_num;
				
				$res[] = $d;
			}
			
			return $res;


			/*
			$res = $this->db->select('*')
				->from('class')
				->where('course_id ', $Cid) //比较符前要有空格
				->get();
			return $res->result();
			*/
		}
		//根据教学班id返回它的所有信息
		public function get_class_by_id($cid){
			$this->load->model('r2/Search_model', 'classmm');
			$temp = array('class_id'=>$cid);
			$temp2 = $this->classmm->classinfo($temp);
			$nn = count($temp2);
			$res = array();
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_class();
				
				$d->class_id = $temp2[$i]->class_id;
				$d->class_name = $temp2[$i]->course_name;
				$d->course_id = $temp2[$i]->course_id;
				$d->type = $temp2[$i]->college;
				$d->teacher_id = $temp2[$i]->teacher_id;
				$d->teacher_name = $temp2[$i]->teacher_name;
				
				$d->department = $temp2[$i]->college;
				$d->year = $temp2[$i]->year;
				$d->season = $temp2[$i]->season;

				$d->day = 1; //TODO
				$d->class_time = $temp2[$i]->sche;

				$d->test_time = $temp2[$i]->testtime;
				$d->margin = $temp2[$i]->margin;
				$d->capacity = $temp2[$i]->capacity;
				$d->assess_score = $temp2[$i]->assess_score;
				$d->assess_num = $temp2[$i]->assess_num;
				
				$res[] = $d;
			}
			
			return $res;

			/*
			$res = $this->db->select('*')
				->from('class')
				->where('class_id ', $cid)
				->get();
			return $res->result();
			*/
		}
		//根据老师id，返回他自己开设的所有教学班
		public function get_class_by_tid($tid){

			$this->load->model('r2/Search_model', 'classmm');
			$temp = array('teacher_id'=>$tid);
			$result = $this->classmm->classinfo($temp);

			$result2 = array();
			$nn = count($result);
			for ($i = 0; $i < $nn; $i++){
				$now_time = $result[$i]->sche;
				$length = strlen($now_time);
				$x = $length/15;
				for ($j = 0; $j < $x; $j++){
					for ($k = 1; $k <= 13; $k++){
						if ($now_time[$j*15+1+$k] == 1){
							$d = new r3_curriculum_teacher();
							$d->class_id = $result[$i]->class_id;
							$d->course_id = $result[$i]->course_id;
							$d->class_name = $result[$i]->course_name;
							$d->day = $now_time[$j*15+1];
							$d->class_time = $k;
							$result2[] = $d;
						}
					}
				}
			}


			$nn = count($result2);
			
			for ($i = 1; $i < $nn; $i++){
				$d = $result2[$i];
				$j = $i;
				while ($j>0 && ($d->class_time < $result2[$j-1]->class_time || ($d->class_time == $result2[$j-1]->class_time && $d->day < $result2[$j-1]->day ) )){
					$result2[$j] = $result2[$j-1];
					$j -= 1;
				}
				$result2[$j] = $d;
			}

			
			return $result2;



			/*
			$this->load->model('r2/Search_model', 'classmm');
			$temp = array('teacher_id'=>$tid);
			$temp2 = $this->classmm->classinfo($temp);

			echo 'teacher class before handle: ';
			var_dump($temp2);

			$nn = count($temp2);
			$res = array();
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_class();
				
				$d->class_id = $temp2[$i]->class_id;
				$d->class_name = $temp2[$i]->course_name;
				$d->course_id = $temp2[$i]->course_id;
				$d->type = $temp2[$i]->college;
				$d->teacher_id = $temp2[$i]->teacher_id;
				$d->teacher_name = $temp2[$i]->teacher_name;
				
				$d->department = $temp2[$i]->college;
				$d->year = $temp2[$i]->year;
				$d->season = $temp2[$i]->season;

				$d->day = 1; //TODO
				$d->class_time = $temp2[$i]->sche;

				$d->test_time = $temp2[$i]->testtime;
				$d->margin = $temp2[$i]->margin;
				$d->capacity = $temp2[$i]->capacity;
				$d->assess_score = $temp2[$i]->assess_score;
				$d->assess_num = $temp2[$i]->assess_num;
				
				$res[] = $d;
			}
			
			return $res;
			*/

			/*
			$res = $this->db->select('class_id, course_id, class_name, year, season, day, class_time, assess_score, assess_num')
				->from('class')
				->where('teacher_id ', $tid)
				->order_by('class_time', 'asc')
				->order_by('day', 'asc')
				->get();
			return $res->result();	
			*/
		}
		//根据教学班id返回他的上课时间和考试时间
		public function get_time_by_cid($cid){
			$this->load->model('r2/Search_model', 'classmm');
			$temp = array('class_id'=>$cid);
			$temp2 = $this->classmm->classinfo($temp);
			$nn = count($temp2);
			$res = array();
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_class();
				
				$d->class_id = $temp2[$i]->class_id;
				$d->class_name = $temp2[$i]->course_name;
				$d->course_id = $temp2[$i]->course_id;
				$d->type = $temp2[$i]->college;
				$d->teacher_id = $temp2[$i]->teacher_id;
				$d->teacher_name = $temp2[$i]->teacher_name;
				
				$d->department = $temp2[$i]->college;
				$d->year = $temp2[$i]->year;
				$d->season = $temp2[$i]->season;

				$d->day = 1; //TODO
				$d->class_time = $temp2[$i]->sche;

				$d->test_time = $temp2[$i]->testtime;
				$d->margin = $temp2[$i]->margin;
				$d->capacity = $temp2[$i]->capacity;
				$d->assess_score = $temp2[$i]->assess_score;
				$d->assess_num = $temp2[$i]->assess_num;
				
				$res[] = $d;
			}
			
			return $res;


			/*
			$res = $this->db->select('day, class_time, test_time')
				->from('class')
				->where('class_id', $cid)
				->get();
			return $res->result();
			*/
		}
		//根据教学班id返回它的余量
		public function get_margin_by_cid($cid){
			$this->load->model('r2/Search_model', 'classmm');
			$temp = array('class_id'=>$cid);
			$temp2 = $this->classmm->classinfo($temp);
			$nn = count($temp2);
			$res = array();
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_class();
				
				$d->class_id = $temp2[$i]->class_id;
				$d->class_name = $temp2[$i]->course_name;
				$d->course_id = $temp2[$i]->course_id;
				$d->type = $temp2[$i]->college;
				$d->teacher_id = $temp2[$i]->teacher_id;
				$d->teacher_name = $temp2[$i]->teacher_name;
				
				$d->department = $temp2[$i]->college;
				$d->year = $temp2[$i]->year;
				$d->season = $temp2[$i]->season;

				$d->day = 1; //TODO
				$d->class_time = $temp2[$i]->sche;

				$d->test_time = $temp2[$i]->testtime;
				$d->margin = $temp2[$i]->margin;
				$d->capacity = $temp2[$i]->capacity;
				$d->assess_score = $temp2[$i]->assess_score;
				$d->assess_num = $temp2[$i]->assess_num;
				
				$res[] = $d;
			}
			
			return $res;

			/*
			$res = $this->db->select('margin, capacity')
				->from('class')
				->where('class_id', $cid)
				->get();
			return $res->result();
			*/
		}
	}