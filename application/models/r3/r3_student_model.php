<?php 
	class r3_stuInfo{
		public $student_id;
		public $student_name;
		public $department;
		public $major_added;
	}

	//这是替一组实现的接口，最后以一组的代码为准
	class r3_Student_model extends CI_Model{
		//根据学生的id返回他的姓名
		public function get_name_by_id($sid){
			$this->load->model('ims/Ims_interface_model','imsm');
			$temp = array('uid'=>$sid);
			$temp2 = $this->imsm->search_student($temp);

			$res = array();
			$nn = count($temp2);
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_stuInfo();
				$d->student_id = $temp2[$i]['uid'];
				$d->student_name = $temp2[$i]['name'];
				$d->department = $temp2[$i]['college'];
				$d->major_added = $temp2[$i]['major_added'];
				$res[] = $d;
			}
			return $res;

			/*
			$res = $this->db->select('student_name')
				->from('student')
				->where('student_id ', $sid)
				->get();
			return $res->result();	
			*/
		}
		//根据一定的条件搜索学生
		public function get_student_by_condition($sid, $sname){
			$this->load->model('ims/Ims_interface_model','imsm');
			$temp = array();
			if ($sid != '' && $sname != ''){
				$temp = array('uid'=>$sid, 'name'=>$sname);
			}
			else
			if ($sid != ''){
				$temp = array('uid'=>$sid);
			}
			else
			if ($sname != ''){
				$temp = array('name'=>$sname);
			}
			$temp2 = $this->imsm->search_student($temp);

			$res = array();
			$nn = count($temp2);
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_stuInfo();
				$d->student_id = $temp2[$i]['uid'];
				$d->student_name = $temp2[$i]['name'];
				$d->department = $temp2[$i]['college'];
				$d->major_added = $temp2[$i]['major_added'];
				$res[] = $d;
			}
			return $res;

			/*
			$this->db->select('student_id, student_name')
				->from('student');
			if ($sid != '')
				$this->db->like('student_id', $sid); //先匹配id
			if ($sname != '')
				$this->db->like('student_name', $sname); //再匹配名字
			$this->db->order_by('student_id', 'asc'); //返回结果以学生id升序排序
			$res = $this->db->get();
			return $res->result();
			*/
		}
		//根据学生id返回他的专业
		public function get_department_by_id($sid){
			$this->load->model('ims/Ims_interface_model','imsm');
			$temp = array('uid'=>$sid);
			$temp2 = $this->imsm->search_student($temp);

			$res = array();
			$nn = count($temp2);
			for ($i = 0; $i < $nn; $i++){
				$d = new r3_stuInfo();
				$d->student_id = $temp2[$i]['uid'];
				$d->student_name = $temp2[$i]['name'];
				$d->department = $temp2[$i]['college'];
				$d->major_added = $temp2[$i]['major_added'];
				$res[] = $d;
			}
			return $res;


			/*
			$res = $this->db->select('department')
				->from('student')
				->where('student_id ', $sid)
				->get();
			return $res->result();
			*/
		}
		public function whether_major_added($sid){
			$this->load->model('ims/Ims_interface_model','imsm');
			$temp = array('uid'=>$sid);
			$temp2 = $this->imsm->search_student($temp);

			$nn = count($temp2);
			if ($nn <= 0)
				return 0;
			return $temp2[0]['major_added'];

			/*
			$res = $this->db->select('major_added')
				->from('student')
				->where('student_id ', $sid)
				->get();
			$result = $res->result();
			if ($result[0]->major_added == 0)
				return 0;
			else
				return 1;
			*/
		}
	}



