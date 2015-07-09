<?php 
class R3_Teacher extends CI_controller{ 
	public function tprint($cid){
		$this->load->library('r3_excel');
		$this->r3_excel->filename = $cid.'学生名单';
		$this->load->model('r3/r3_Curriculum_model','currim'); //加载curriculum_model
		$this->load->model('r3/r3_student_model','studem'); //加载student_model
		$this->load->model('r3/r3_class_model','classm'); //加载class_model
		$info = $this->currim->get_student_by_cid($cid); //调用curriculum_model的方法，返回某教学班的学生列表
		$n = count($info);
		//把所有的结果都放到$data中
		$data['studentnum'] = $n; //有多少学生
		for($i=0;$i<$n;$i++){
			$data['studentid'][$i+1] = $info[$i]->student_id; //学生的id列表
			$tmp = $this->studem->get_name_by_id($info[$i]->student_id);
			$data['studentname'][$i+1] = $tmp[0]->student_name;//学生的姓名列表
		}
		$classinfo = $this->classm->get_class_by_id($cid);
		$data['classname']=$classinfo[0]->class_name;
		$data['courseid']=$classinfo[0]->course_id;
		$data['teachername']=$classinfo[0]->teacher_name;
		$data['classroom']=$classinfo[0]->classroom;
		$data['day']=$classinfo[0]->day;
		$data['time']=$classinfo[0]->class_time;
		$titles = array('教学班学生名单');
		$array[0] = array('课程名称', $data['classname']);
		$array[1] = array('课程ID', $data['courseid']);
		$array[2] = array('任课教师', $data['teachername']);
		$array[3] = array('上课教室', $data['classroom']);
		$array[4] = array('上课时间', '周'.$data['day'].'第'.$data['time'].'节');
		$array[5] = array('学生ID', '学生姓名');
		for($i=0;$i<$n;$i++){
			$array[$i+6]=array($data['studentid'][$i+1],$data['studentname'][$i+1]);
		}
		$this->r3_excel->make_from_array($titles, $array);

	}
	//返回老师的课表
	public function curriculum($tid){
		$tid = $this->session->userdata('uid');

		$this->load->model('r3/r3_Class_model','classm'); //加载class_model
		$this->load->model('r3/r3_Course_model','coursem'); //加载course_model

		$tmp = $this->classm->get_class_by_tid($tid); //调用class_model的方法，返回他所有的教学班
		//把所有的结果都放到$data中
		$n = count($tmp);
		for($i=0;$i<$n;$i++){
			$data['classtime'][$i+1] = $tmp[$i]->class_time; //哪节课
			$data['classweek'][$i+1] = $tmp[$i]->day; //哪一天
			$data['courseid'][$i+1] = $tmp[$i]->course_id; //课程id
			$data['classid'][$i+1] = $tmp[$i]->class_id; //教学班id
			$tmp2 = $this->coursem->get_course_name($tmp[$i]->course_id);

			$data['coursename'][$i+1] = $tmp2[0]->course_name; //课程名称
		}
		$data['classnum'] = $n;
		$this->load->view('r3/r3_t_curriculum',$data); //加载新的视图，并且把结果传过去
	}

	//返回某门教学班的学生列表
	public function classmember($cid){
		for ($i = 0; $i < 10; $i++)
			echo $cid;
		$this->load->model('r3/r3_Curriculum_model','currim'); //加载curriculum_model
		$this->load->model('r3/r3_student_model','studem'); //加载student_model
		$info = $this->currim->get_student_by_cid($cid); //调用curriculum_model的方法，返回某教学班的学生列表
		$n = count($info);
		//把所有的结果都放到$data中
		$data['studentnum'] = $n; //有多少学生
		$data['cid'] = $cid; //有多少学生
		for($i=0;$i<$n;$i++){
			$data['studentid'][$i+1] = $info[$i]->student_id; //学生的id列表
			$tmp = $this->studem->get_name_by_id($info[$i]->student_id);
			$data['studentname'][$i+1] = $tmp[0]->student_name;//学生的姓名列表
		}
		$this->load->view('r3/r3_t_classmember',$data); //加载新的视图，并且把结果传过去


	}
	//显示课程简介
	public function courseinfo($cid = '0'){
		//特殊情况处理
		if($cid == '0'){
			echo '404 这是什么鬼课？';
			return ;
		}

		$this->load->model('r3/r3_Course_model','coursem'); //加载course_model
		$tmp = $this->coursem->get_course_all($cid); //调用course_model的方法，返回课程所有信息
		//以下是把课程的所有信息赋给$data变量
		$data["coursename"] = $tmp[0]->course_name;
		$data["courseid"] = $tmp[0]->course_id;
		$data["major"] = $tmp[0]->type;
		$data["credit"] = $tmp[0]->credit;
		$data["weight"] = $tmp[0]->weight;
		$data["info"] = $tmp[0]->intro;
		$this->load->view('r3/r3_t_courseinfo',$data); //加载课程简介的视图，并且把结果传过去
	}

	//老师的搜索引擎，和学生的一样
	public function selectengine($tid = '0'){
		$tid = $this->session->userdata('uid');

		//$this->load->view('r3_selectengine');
		$this->load->model('r3/r3_Course_model','coursem'); //加载course_model

		$major = '0';
		//把post上来的专业类型放到$major中
		if($this->input->post('major')){
			$major = $this->input->post('major');
		}
		$tmpm = $this->coursem->get_all_type(); //返回数据库里所有课程的专业类型
		//结果存在$data变量中
		$typen = count($tmpm);
		for($i=1;$i<=$typen;$i++){
			$data["majors"][$i] = $tmpm[$i-1]->type;
		}
		$data["majornum"]=$typen;
		//这里主要处理，专业的下拉框中显示什么
		if($major != '0'&&$major != '所有课程')
			$data["nowmajor"] = $major;
		else 
			$data["nowmajor"] = '所有课程';
		//以下先把所有的搜索条件初始化
		$CN ='';
		$major = '';
		$Cid = '';
		$Ctime = '';
		$Cplace = '';
		$TN = '';
		$Tid = '';
		//下面把搜索界面post上来的所有信息存在上面的变量中
		if ($this->input->post('major')){
			$major = $this->input->post('major');	
		}
			
		if ($this->input->post('coursename')){
			$CN = $this->input->post('coursename');	
		}
		if ($this->input->post('courseid')){
			$Cid = $this->input->post('courseid');	
		}
		if ($this->input->post('coursetime')){
			$Ctime = $this->input->post('coursetime');	
		}
		if ($this->input->post('courseplace')){
			$Cplace = $this->input->post('courseplace');	
		}
		if ($this->input->post('teachername')){
			$TN = $this->input->post('teachername');	
		}
		if ($this->input->post('teacherid')){
			$Tid = $this->input->post('teacherid');	
		}
		
		$this->load->model('r3/r3_Course_model', 'coursem'); //加载course_model
		$this->load->model('r3/r3_Curriculum_model','Curriculum_model'); //加载curriculum_model
		$margin = 0; //老师没有按照课程余量搜索这一选项，老师没必要有这一选项
		//根据条件搜索课程！
		$res1 = $this->coursem->get_course_by_condition($major, $CN, $Cid, $Ctime, $Cplace, $TN, $Tid, $margin);

		//以下是把搜索结果放到$data中
		$n = count($res1);
		$data["coursenum"] = $n;
		$j = 0;
		for ($i = 1; $i <= $n; $i++){
			$data["courseid"][$i] = $res1[$i-1]->course_id;
			$data["coursename"][$i] = $res1[$i-1]->course_name;
			
		}
		$this->load->view('r3/r3_t_selectengine', $data); //加载搜索引擎的视图，并且把结果传过去
	}
	//教师用户进入系统时，先调用index，显示教师的首页
	public function index(){
 		$this->load->view('r3/r3_t_homepage'); //加载教师的首页
	}

}


?>