<?php 

class R3_Admin extends CI_controller{
	//管理员用户进入系统时，先调用index，显示管理员的首页
	public function index(){
		$this->load->view('r3_a_homepage'); //加载管理员的首页
	}
	//管理员修改选课时间
	public function modifysystem(){
		$this->load->model('r3_Selecttime_model', 'timem'); //加载selecttime_model
		//以下先把所有前端可能post过来的信息初始化
		$startmonth2 = 0;
		$startday2 = 0;
		$starthour2 = 0;
		$endmonth2 = 0;
		$endday2 = 0;
		$endhour2 = 0;
		//下面把设置选课时间界面post上来的所有信息存在上面的变量中
		if ($this->input->post('startmonth2')){
			$startmonth2 = $this->input->post('startmonth2');
		}
		if ($this->input->post('startdate2')){
			$startday2 = $this->input->post('startdate2');	
		}
		if ($this->input->post('startclock2')){
			$starthour2 = $this->input->post('startclock2');	
		}
		if ($this->input->post('endmonth2')){
			$endmonth2 = $this->input->post('endmonth2');	
		}
		if ($this->input->post('enddate2')){
			$endday2 = $this->input->post('enddate2');	
		}
		if ($this->input->post('endclock2')){
			$endhour2 = $this->input->post('endclock2');	
		}

		$good = 1; //若设置的时间没错，则$good = 1; 否则 $good = 0
		$error_prompt = ''; //错误提示
		//以下判断设置的时间中，每个月的天数是否超出那个月的上限
		if ($startmonth2 == 1 || $startmonth2 == 3 || $startmonth2 == 5 || $startmonth2 == 7 || $startmonth2 == 8 || $startmonth2 == 10 || $startmonth2 == 12){
			if ($startday2 > 31){
				$good = 0;
				$error_prompt = '日期出错！这个月没那么多天！';
			}
		}
		if ($endmonth2 == 1 || $endmonth2 == 3 || $endmonth2 == 5 || $endmonth2 == 7 || $endmonth2 == 8 || $endmonth2 == 10 || $endmonth2 == 12){
			if ($endday2 > 31){
				$good = 0;
				$error_prompt = '日期出错！这个月没那么多天！';
			}
		}
		if ($startmonth2 == 4 || $startmonth2 == 6 || $startmonth2 == 9 || $startmonth2 == 11){
			if ($startday2 > 30){
				$good = 0;
				$error_prompt = '日期出错！这个月没那么多天！';
			}
		}
		if ($endmonth2 == 4 || $endmonth2 == 6 || $endmonth2 == 9 || $endmonth2 == 11){
			if ($endday2 > 30){
				$good = 0;
				$error_prompt = '日期出错！这个月没那么多天！';
			}
		}
		//以下判断，选课结束时间是不是比选课开始时间还早
		if($startmonth2 > $endmonth2 || ($startmonth2 == $endmonth2 && $startday2 > $endday2)){
			$good = 0;
			$error_prompt = '选课结束时间比开始时间早！';
		}
		if ($startmonth2 == $endmonth2 && $startday2 == $endday2 && $starthour2 > $endhour2){
			$good = 0;
			$error_prompt = '选课结束时间比开始时间早！';	
		}
		//若设置的时间没问题，则设置并且显示设置成功
		if ($good == 1){
			$this->timem->set_time($startmonth2, $startday2, $starthour2, $endmonth2, $endday2, $endhour2);

			$this->load->model('r3_r3_r3_Credit_model', 'creditm');
			$major = '';
			$mincredit = 0;
			$minoption = 0;
			$mincommon = 0;
			if ($this->input->post('major')){
				$major = $this->input->post('major');
			}
			if ($this->input->post('mincredit')){
				$mincredit = $this->input->post('mincredit');
			}
			if ($this->input->post('minoption')){
				$minoption = $this->input->post('minoption');
			}
			if ($this->input->post('mincommon')){
				$mincommon = $this->input->post('mincommon');
			}
			if ($major != ''){
				$this->creditm->set_credit_requirement($major, $mincredit, $minoption, $mincommon);
			}


			$data['content'] = '设置成功';
		}
		else
			$data['content'] = $error_prompt; //否则不设置，并且显示相应的错误提示

		$this->load->view('r3_a_alert', $data); //加载提示框，显示相应的提示

		

	}
	//管理员点击保存前看到的显示设置时间的页面
	public function setpage(){
		$this->load->model('r3_Selecttime_model', 'timem'); //加载selecttime_model
		$result = $this->timem->get_original_time(); //调用selecttime_model的方法，获得原来系统里设置的时间
		//先初始化所有要传出去的值
		$data['startmonth'] = 0;
		$data['startdate'] = 0;
		$data['startclock'] = 0;
		$data['endmonth'] = 0;
		$data['enddate'] = 0;
		$data['endclock'] = 0;
		if (count($result) == 0){ //如果原来并没有设置选课时间，则传出值全为0
			$data['startmonth'] = 0;
			$data['startdate'] = 0;
			$data['startclock'] = 0;
			$data['endmonth'] = 0;
			$data['enddate'] = 0;
			$data['endclock'] = 0;
		}
		else //否则，返回原来设置的选课时间
		{
			$data['startmonth'] = $result[0]->start_month;
			$data['startdate'] = $result[0]->start_day;
			$data['startclock'] = $result[0]->start_hour;
			$data['endmonth'] = $result[0]->end_month;
			$data['enddate'] = $result[0]->end_day;
			$data['endclock'] = $result[0]->end_hour;
		}

		$this->load->model('r3_Course_model', 'coursem');
		$res1 = $this->coursem->get_all_type();
		$n = count($res1);
		$data['majornum'] = $n;
		for ($i = 0; $i < $n; $i++){
			$data['majors'][$i+1] = $res1[$i]->type;
		}

		$this->load->view('r3_a_setpage', $data); //加载设置时间的视图，并返回结果

	}
	//显示课程简介
	public function courseinfo($cid = '0'){
		//特殊情况处理
		if($cid == '0'){
			echo '404 这是什么鬼课？';
			return ;
		}

		$this->load->model('r3_Course_model','coursem'); //加载course_model
		$tmp = $this->coursem->get_course_all($cid); //调用course_model的方法，返回课程所有信息
		//以下是把课程的所有信息赋给$data变量
		$data["coursename"] = $tmp[0]->course_name;
		$data["courseid"] = $tmp[0]->course_id;
		$data["major"] = $tmp[0]->type;
		$data["credit"] = $tmp[0]->credit;
		$data["weight"] = $tmp[0]->weight;
		$data["info"] = $tmp[0]->intro;
		$this->load->view('r3_a_courseinfo',$data); //加载课程简介的视图，并且把结果传过去
	}
	//强行为某门课添加学生或删除学生
	public function modifyclass($sid = 0 , $cid  = 0, $flag){
		$this->load->model('r3_r3_r3_Class_model','classm');
		$this->load->model('r3_r3_r3_Curriculum_model','currim');

		if($flag==0){
			$this->currim->delete_class($sid,$cid); //若是删学生，则调用接口在相应教学班中把他删掉
		}else{
			$this->currim->add_class($sid,$cid); //若是加学生，则调用接口在相应教学班中把他加入
		}
		$this->classmember($cid); 
	}
	//管理员的搜索引擎，和学生的一样
	public function selectengine($tid = '0'){
		$this->load->model('r3_Course_model','coursem'); //加载course_model
		$major = '0';
		//把post上来的专业类型放到$major中
		if($this->input->post('major')){
			$major = $this->input->post('major');
		}
		$tmpm = $this->coursem->get_all_type();
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

		$this->load->model('r3_Course_model', 'coursem'); //加载course_model
		$this->load->model('r3_Curriculum_model'); //加载curriculum_model
		$margin = 0; //管理员没有按照课程余量搜索这一选项，管理员没必要有这一选项
		$res1 = $this->coursem->get_course_by_condition($major, $CN, $Cid, $Ctime, $Cplace, $TN, $Tid, $margin);
		//以下是把搜索结果放到$data中
		$n = count($res1);
		$data["coursenum"] = $n;
		$j = 0;
		for ($i = 1; $i <= $n; $i++){
			$data["courseid"][$i] = $res1[$i-1]->course_id;
			$data["coursename"][$i] = $res1[$i-1]->course_name;
			
		}
		$this->load->view('r3_a_selectengine', $data); //加载搜索引擎的视图，并且把结果传过去
	}

	//显示选课的页面，管理员在这一页面找到教学班后，点击增删学生
	public function selectpage($cid = 0){
 		if($cid == '0'){
			echo '404 这是什么鬼课？';
			return ;
		}
		$this->load->model('r3_r3_Class_model','classm');
		$tmp = $this->classm->get_class_all($cid); //返回所有教学班
		$n = count($tmp);
		//把所有返回的教学班的信息写到$data中
		for($i=1;$i<=$n;$i++){
			$data["classid"][$i] = $tmp[$i-1]->class_id;
			$data["coursename"][$i] = $tmp[$i-1]->class_name;
			$data["courseid"][$i] = $tmp[$i-1]->course_id;
			$data["major"][$i] = $tmp[$i-1]->type;
			$data["teachername"][$i] = $tmp[$i-1]->teacher_name;
			$data["classroom"][$i] = $tmp[$i-1]->classroom;
			$data["week"][$i] = $tmp[$i-1]->day;
			$data["time"][$i] = $tmp[$i-1]->class_time;
		}
		$data["classnum"] = $n;

		$this->load->view('r3_a_selectpage',$data); //加载选课页面视图，并且把结果传过去
	}

	//管理员为某门教学班增删学生
	public function classmember($cid){
		$this->load->model('r3_r3_Curriculum_model','currim');
		$this->load->model('r3_r3_student_model','studem');
		$this->load->model('r3_r3_class_model','classm');
		//以下先拿到该教学班当前的学生列表
		$info = $this->currim->get_student_by_cid($cid);
		$n = count($info);
		$data['studentnum'] = $n;
		for($i=0;$i<$n;$i++){
			$data['studentid'][$i+1] = $info[$i]->student_id;
			$tmp = $this->studem->get_name_by_id($info[$i]->student_id);
			$data['studentname'][$i+1] = $tmp[0]->student_name;
		}
		//把post上来的搜索条件存到变量中
		$searchstuname = '';
		$searchstuid = '';
		if ($this->input->post('stunamesearch')){
			$searchstuname = $this->input->post('stunamesearch');	
		}
		if ($this->input->post('stuidsearch')){
			$searchstuid = $this->input->post('stuidsearch');	
		}
		//根据条件搜索学生
		$searchresult = $this->studem->get_student_by_condition($searchstuid, $searchstuname);
		$m = count($searchresult);
		//把搜出来的学生存到$data中
		$data['searchnum'] = $m;
		for ($i = 0; $i < $m; $i++){
			$data['searchid'][$i+1] = $searchresult[$i]->student_id;
			$data['searchname'][$i+1] = $searchresult[$i]->student_name;
			$whether = $this->currim->whether_select_class($searchresult[$i]->student_id, $cid);
			if (count($whether) > 0)
				$data['classselect'][$i+1] = 1;
			else
				$data['classselect'][$i+1] = 0;
		}
		//以下把当前这门课的信息存到$data中
		$classinfo = $this->classm->get_class_by_id($cid);
		$data['classname'] = $classinfo[0]->class_name;
		$data['classteacher'] = $classinfo[0]->teacher_name;
		$data['classroom'] = $classinfo[0]->classroom;
		$data['classday'] = $classinfo[0]->day;
		$data['classtime'] = $classinfo[0]->class_time;
		$data['classid'] = $cid;


		$this->load->view('r3_a_classmember',$data); //加载增删学生的视图，并且把结果传过去


	}

}