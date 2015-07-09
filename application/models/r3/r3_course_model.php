<?php 
	//这是替一组实现的接口，最后以一组的代码为准
	//classInfo类在构成关于课程的数组时会用到
	class r3_classInfo{
		public $course_id;
		public $course_name;
		public $credit;
		public $type;
		public $course_type;
		public $intro;
	}

	class r3_Course_model extends CI_Model{
		//根据课程id返回课程的类型（必修，选修or公共课）
		public function get_coursetype_by_Cid($Cid){
			$this->load->model('ims/Ims_interface_model','imsm');
			$temp = array('course_id'=>$Cid);
			$temp2 = $this->imsm->search_course($temp);

			$res = array();
			$nn = count($temp2);
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_classInfo();
				if ($temp2[$i]['course_type'] == 0){
					$d->course_type = '专业选修课';
				}
				else
				if ($temp2[$i]['course_type'] == 1){
					$d->course_type = '专业必修课';
				}
				else
				if ($temp2[$i]['course_type'] == 2){
					$d->course_type = '公共课';
				}
				$res[] = $d;
			}

			return $res;
			/*
			$res = $this->db->select('course_type')
				->from('course')
				->where('course_id ', $Cid)
				->get();
			return $res->result();
			*/
		}
		//根据课程id返回课程的学分
		public function get_credit_by_Cid($Cid){
			$this->load->model('ims/Ims_interface_model','imsm');
			$temp = array('course_id'=>$Cid);
			$temp2 = $this->imsm->search_course($temp);

			$res = array();
			$nn = count($temp2);
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_classInfo();
				$d->credit = $temp2[$i]['credit'];
				$res[] = $d;
			}
			return $res;

			/*
			$res = $this->db->select('credit')
				->from('course')
				->where('course_id ', $Cid)
				->get();
			return $res->result();
			*/
		}
		//根据课程id返回课程名字
		public function get_course_name($Cid){
			$this->load->model('ims/Ims_interface_model','imsm');
			$temp = array('course_id'=>$Cid);
			$temp2 = $this->imsm->search_course($temp);

			$res = array();
			$nn = count($temp2);
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_classInfo();
				$d->course_name = $temp2[$i]['name'];
				$res[] = $d;
			}
			return $res;


			/*
			$res = $this->db->select('course_name')
				->from('course')
				->where('course_id ', $Cid) //比较符前要有空格
				->get();
			return $res->result();
			*/
		}
		//根据课程id返回它的所有信息
		public function get_course_all($Cid){
			$this->load->model('ims/Ims_interface_model','imsm');
			$temp = array('course_id'=>$Cid);
			$temp2 = $this->imsm->search_course($temp);

			$res = array();
			$nn = count($temp2);
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_classInfo();
				$d->course_name = $temp2[$i]['name'];
				$d->course_id = $temp2[$i]['course_id'];
				$d->type = $temp2[$i]['college'];
				if ($temp2[$i]['course_type'] == 0){
					$d->course_type = '专业选修课';
				}
				else
				if ($temp2[$i]['course_type'] == 1){
					$d->course_type = '专业必修课';
				}
				else
				if ($temp2[$i]['course_type'] == 2){
					$d->course_type = '公共课';
				}
				$d->credit = $temp2[$i]['credit'];
				$d->intro = $temp2[$i]['info'];
				$res[] = $d;
			}
			return $res;

			/*
			$res = $this->db->select('*')
				->from('course')
				->where('course_id ', $Cid) //比较符前要有空格
				->get();
			return $res->result();
			*/
		}
		//返回数据库中所有课程的所有信息
		public function get_all_course(){
			//$res = $this->db->get('course');
			$this->load->model('ims/Ims_interface_model','imsm');
			$temp = array();
			$temp2 = $this->imsm->search_course($temp);

			$res = array();
			$nn = count($temp2);
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_classInfo();
				$d->course_name = $temp2[$i]['name'];
				$d->course_id = $temp2[$i]['course_id'];
				$d->type = $temp2[$i]['college'];
				if ($temp2[$i]['course_type'] == 0){
					$d->course_type = '专业选修课';
				}
				else
				if ($temp2[$i]['course_type'] == 1){
					$d->course_type = '专业必修课';
				}
				else
				if ($temp2[$i]['course_type'] == 2){
					$d->course_type = '公共课';
				}
				$d->credit = $temp2[$i]['credit'];
				$d->intro = $temp2[$i]['info'];
				$res[] = $d;
			}
			return $res;

			/*
			$res = $this->db->select('*')
				->from('course')
				->order_by('course_id', 'asc')
				->get();
			return $res->result();
			*/
		}
		//根据课程的专业类型返回所有课程
		public function get_course_by_type($t){
			$this->load->model('ims/Ims_interface_model','imsm');
			$temp = array('college'=>$t);
			$temp2 = $this->imsm->search_course($temp);

			$res = array();
			$nn = count($temp2);
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_classInfo();
				$d->course_name = $temp2[$i]['name'];
				$d->course_id = $temp2[$i]['course_id'];
				$d->type = $temp2[$i]['college'];
				if ($temp2[$i]['course_type'] == 0){
					$d->course_type = '专业选修课';
				}
				else
				if ($temp2[$i]['course_type'] == 1){
					$d->course_type = '专业必修课';
				}
				else
				if ($temp2[$i]['course_type'] == 2){
					$d->course_type = '公共课';
				}
				$d->credit = $temp2[$i]['credit'];
				$d->intro = $temp2[$i]['info'];
				$res[] = $d;
			}
			return $res;

			/*
			$res = $this->db->select('course_id, course_name, type')
				->from('course')
				->where('type =', $t) //比较符前要有空格
				->order_by('course_id', 'asc')
				->get();
			return $res->result();
			*/
		}
		//根据一定的条件返回符合条件的课程
		public function get_course_by_condition($major, $CN, $Cid, $Ctime, $Cplace, $TN, $Tid, $margin_require){
		//public function get_course_by_condition($CN){
			
			$this->load->model('r3/r3_Class_model', 'classm'); //加载class model，后面会用到它的方法

			//下面根据输入的条件一条条匹配
			$this->load->model('ims/Ims_interface_model', 'imsm');
			$temp = array();
			if ($Cid != ''){
				$temp['course_id'] = $Cid;
			}
			if ($CN != ''){
				$temp['name'] = $CN;
			}
			if ($major != ''){
				$temp['college'] = $major;
			}
			$temp2 = $this->imsm->search_course($temp);

			$result1 = array();
			$nn = count($temp2);
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_classInfo();
				$d->course_name = $temp2[$i]['name'];
				$d->course_id = $temp2[$i]['course_id'];
				$d->type = $temp2[$i]['college'];
				if ($temp2[$i]['course_type'] == 0){
					$d->course_type = '专业选修课';
				}
				else
				if ($temp2[$i]['course_type'] == 1){
					$d->course_type = '专业必修课';
				}
				else
				if ($temp2[$i]['course_type'] == 2){
					$d->course_type = '公共课';
				}
				$d->credit = $temp2[$i]['credit'];
				$d->intro = $temp2[$i]['info'];
				$result1[] = $d;
			}

			/*
			$this->db->select('course_id, course_name')
				->from('course');
			if ($CN != '')
				$this->db->like('course_name', $CN);
			if ($Cid != '')
				$this->db->like('course_id', $Cid);
			if ($major != '')
				$this->db->like('type', $major);
			$this->db->order_by('course_id', 'asc');
			$res = $this->db->get();
			*/

			//再找出所有符合上课时间，上课地点，余量等条件的教学班，因为课程的表中没有这些信息
			$this->load->model('r2/Search_model', 'classmm');
			$temp_2 = array();
			if ($Tid != ''){
				$temp_2['teacher_id'] = $Tid;
			}
			if ($TN != ''){
				$temp_2['teacher_name'] = $TN;
			}
			$temp2 = $this->classmm->classinfo($temp_2);
			$nn = count($temp2);
			$result2 = array();
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
				$d->class_time = 1;

				$d->test_time = $temp2[$i]->testtime;
				$d->margin = $temp2[$i]->margin;
				$d->capacity = $temp2[$i]->capacity;
				$d->assess_score = $temp2[$i]->assess_score;
				$d->assess_num = $temp2[$i]->assess_num;
				
				$result2[] = $d;
			}

			/*
			$this->db->select('course_id')
				->from('class');
			if ($Cplace != '')
				$this->db->like('classroom', $Cplace);
			if ($Ctime != '')
				$this->db->where('day ', $Ctime);
			if ($TN != '')
				$this->db->like('teacher_name', $TN);
			if ($Tid != '')
				$this->db->like('teacher_id', $Tid);
			$res2 = $this->db->get();
			*/
			
			//把两次匹配的结果放到result1和result2中
			//$result1 = $res->result();
			//$result2 = $res2->result();
			
			$n = count($result1);
			$m = count($result2);
			
			//下面把两边匹配的结果合并起来，结果存到$ans中
			$ans = array();
			

			$total = 0;
			$i = 0;
			$j = 0;
			for ($i = 0; $i < $m; $i++){
				for ($j = 0; $j < $n; $j++){
					if ($result2[$i]->course_id == $result1[$j]->course_id){ //若课程id相同，就是关于同一个教学班的
						//构造一条结果
						$d = new r3_classInfo();
						$d->course_id = $result1[$j]->course_id;
						$d->course_name = $result1[$j]->course_name;
						
						$good = 1;
						if ($margin_require == 1){ //若对余量有要求，那么假如所有教学班余量都不大于0，则$good = 0
							$margin_result = $this->classm->get_class_all($d->course_id);
							$num = count($margin_result);
							$good = 0;
							for ($k = 0; $k < $num; $k++){
								if ($margin_result[$k]->margin > 0){
									$good = 1;
									break;
								}
							}
						}
						if ($good == 1){ //假如这门课程已经在结果列表里的话，就不要重复加入了
							$num = count($ans);
							for ($k = 0; $k < $num; $k++){
								if ($ans[$k]->course_id == $d->course_id){
									$good = 0;
									break;
								}
							}
						}

						if ($good == 1) //没问题的话就加到结果中
							$ans[] = $d;
						//array_push($ans, $d);
						break;
					}
					
				}

			}
			
			return $ans;
		}

		//返回所有的专业类型
		public function get_all_type(){
			$this->load->model('ims/Ims_interface_model','imsm');
			$temp = array();
			$temp2 = $this->imsm->search_course($temp);

			$res = array();
			$nn = count($temp2);
			for ($i = 0; $i < $nn; $i++){
				$good = 1;
				$n_tmp = count($res);
				for ($j = 0; $j < $n_tmp; $j++){
					if ($res[$j]->type == $temp2[$i]['college']){
						$good = 0;
						break;
					}
				}
				if ($good == 1){
					$d = new r3_classInfo();
					$d->type = $temp2[$i]['college'];
					$res[] = $d;
			    }
			}

			return $res;

			/*
			$res = $this->db->select('type')
				->distinct()
				->from('course')
				->get();
			return $res->result();	
			*/
		}
	}

