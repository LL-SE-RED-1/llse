<?php

class r3_courseinfo{
		public $course_id;
		public $course_name;
	}

class R3_Student extends CI_controller{ 
	//学生下载课表



	public function sprint($sid = 0){
		/*
			获取全部课表
		*/
		$sid = $this->session->userdata('uid');

		$this->load->library('r3_excel');
		$this->r3_excel->filename = $sid.'课表';
		$this->load->model('r3/r3_Curriculum_model','Curriculum_model');
		$this->load->model('r3/r3_Course_model','coursem');
		//$tmp = $this->Curriculum_model->get_all_class($sid);//从课表模块中获取所有已选教学班
		$tmp = $this->Curriculum_model->get_curriculum_by_sid($sid);//从课表模块中获取所有已选教学班

		//classtime\classweek\courseid\coursename
		$n = count($tmp);//已选教学班数量
		$current_credit = 0; //当前选上的学分
		for($i=0;$i<$n;$i++){//读出了所有的教学班信息通知给前端
			$data['classtime'][$i+1] = $tmp[$i]->class_time;
			$data['classweek'][$i+1] = $tmp[$i]->day;
			$data['courseid'][$i+1] = $tmp[$i]->course_id;
			$tmp2 = $this->coursem->get_course_name($tmp[$i]->course_id);//因为课程信息没有存在教学班模块中，所以获取一下课程id以供获取更多信息
			$data['coursename'][$i+1] = $tmp2[0]->course_name;

			$tmp3 = $this->coursem->get_credit_by_Cid($tmp[$i]->course_id);
			$current_credit += $tmp3[0]->credit;
		}
		$data['classnum'] = $n;
		$data['currentcredit'] = $current_credit;

		$titles = array('学生课表');
		$string = '
		<thead>
                <tr>
                  <th colspan="2">课程时间</th>
                  <th style="width: 12%;">星期一</th>
                  <th style="width: 12%;">星期二</th>
                  <th style="width: 12%;">星期三</th>
                  <th style="width: 12%;">星期四</th>
                  <th style="width: 12%;">星期五</th>
                  <th style="width: 12%;">星期六</th>
                  <th style="width: 12%;">星期日</th>
                </tr>
              </thead>
              <tbody>
		';
		$i=1;
                    for($time=1;$time<=13;$time++){
                      $string = $string.'<tr>';
                      if($time==1){
                        $string = $string.'<td rowspan="5">上午</td>';
                      }
                      if($time==6){
                        $string = $string.'<td rowspan="5">下午</td>';
                      }
                      if($time==11){
                        $string = $string.'<td rowspan="3">晚上</td>';
                      }
                      $string = $string.'<td style="width: 8%;">第';
                      $string = $string.$time;
                      $string = $string.'节</td>';
                      for($week=1;$week<=7;$week++){
                        if($data['classnum']>0){
                          if(($data['classweek'][$i]==$week)&&($data['classtime'][$i]==$time)){
                            $string = $string.'<td>';
                            $string = $string.$data['coursename'][$i];
                            $string = $string.'</td>';
                            if($i<$data['classnum'])$i++;
                          }
                          else{
                            $string = $string.'<td>         </td>';
                          }
                        }
                        else{
                          $string = $string.'<td>         </td>';
                        }
                      }
                      $string = $string.'</tr>';
                    }
              $string = $string.'</tbody>';
		$this->r3_excel->make_from_string($string);

	}
	//查看老师简介
	public function teacherinfo($tid = ''){

		$this->load->model('r3/r3_Class_model', 'classm');
		$this->load->model('r3/r3_Teacher_model', 'teacherm');

		$res2 = $this->teacherm->get_all_by_tid($tid);
		$data['teacherinfo'] = $res2[0]->info; 	//获得老师自己写的简介
		$data['teachername'] = $res2[0]->teacher_name; 	//获得老师姓名

		//以下是老师所有教学班找出来，看学生的评分
		$res1 = $this->classm->get_class_by_tid($tid); 
		$n = count($res1);
		$data['scorenum'] = $n;
		for ($i = 0; $i < $n; $i++){
			$commend = $res1[$i]->class_name;  //获取教学班名称
			$commend .= '/';
			$commend .= $res1[$i]->year; 	//获取教学班学年
			$season = '';
			switch ($res1[$i]->season){ 	//获取教学班学期
				case 1:
				{
					$season = '春';
					break;
				}
				case 2:
				{
					$season = '夏';
					break;
				}
				case 3:
				{
					$season = '秋';
					break;
				}
				case 4:
				{
					$season = '冬';
					break;
				}
				case 5:
				{
					$season = '春夏';
					break;
				}
				case 6:
				{
					$season = '秋冬';
					break;
				}
				case 7:
				{
					$season = '短';
					break;
				}
				default:
					break;
			}
			$commend .= $season;
			$commend .= '/';
			$avg_score = 0.0;
			if ($res1[$i]->assess_num > 0){
				$avg_score = $res1[$i]->assess_score / $res1[$i]->assess_num;	
			}
			$commend .= $avg_score;
			$data['score'][$i+1] = $commend;

		}

		$this->load->view('r3/r3_s_teacherinfo', $data);
		
	}
	//学生评价课程
	public function assess($sid = 0){
		$sid = $this->session->userdata('uid');

		$this->load->model('r3/r3_Score_model', 'scorem');
		$this->load->model('r3/r3_Class_model', 'classm');

		//然后处理前端post上来的评价信息
		$tmp = 'null';
		if ($this->input->post('total')){
			$total = $this->input->post('total');
			for ($i = 0; $i < $total; $i++){
				$index = '0' + $i;
				if ($this->input->post($index)){
					$tmp = $this->input->post($index);
					$arr = explode("_", $tmp);
					$flag = 0;
					$cid = '';
					$assess_score = 0;
					foreach($arr as $u){
						$flag += 1;
						if ($flag == 1){
							$cid = $u;
						}
						else
						if ($flag == 3){
							$assess_score = $u;
						}
					}
					$this->classm->assess_class_by_cid($sid, $cid, $assess_score); //修改这门课的评分
				}
			}
		}
		
		//以下是获得学生所有考过试的课，需要7组接口
		$res = $this->scorem->get_all_by_sid($sid);
		$n = count($res);
		$data['coursenum'] = $n;
		//并且获得每一门课的信息，比如是否挂科，是否已经评价过了
		for ($i = 0; $i < $n; $i++){
			$data['classid'][$i+1] = $res[$i]->class_id;
			$data['assess'][$i+1] = $res[$i]->assessed;
			if ($res[$i]->score < 60){
				$data['pass'][$i+1] = 0;
			}
			else
				$data['pass'][$i+1] = 1;	
			$tmp = $this->classm->get_class_by_id($res[$i]->class_id);
			$data['coursename'][$i+1] = $tmp[0]->class_name;
			$data['teachername'][$i+1] = $tmp[0]->teacher_name;
			$data['teacherid'][$i+1] = $tmp[0]->teacher_id;
			$season = '';
			switch ($tmp[0]->season){
				case 1:
				{
					$season = '春';
					break;
				}
				case 2:
				{
					$season = '夏';
					break;
				}
				case 3:
				{
					$season = '秋';
					break;
				}
				case 4:
				{
					$season = '冬';
					break;
				}
				case 5:
				{
					$season = '春夏';
					break;
				}
				case 6:
				{
					$season = '秋冬';
					break;
				}
				case 7:
				{
					$season = '短';
					break;
				}
				default:
					break;
			}
			$data['semester'][$i+1] = ($tmp[0]->year).$season;
		}

		
		

		$this->load->view('r3/r3_s_assess', $data);
	}

	public function selectpage($sid = 0 ,$cid = 0){
		/*
		selectpage 是根据课程和学号进行选课的页面，会返回课程的所有教学班的时间、余量等信息。

		*/
		$sid = $this->session->userdata('uid');

 		if($cid == '0'){ // 当传入参数为零即没有传入参数时返回错误页面
			echo '404 这是什么鬼课？';
			return ;
		}
		$this->load->model('r3/r3_Class_model','classm');
		$this->load->model('r3/r3_Curriculum_model','currim');
		$tmp = $this->classm->get_class_all($cid); // 按照课程号获取所有的教学班级
		$selected = $this->currim->whether_select($sid , $cid); // 获取有关学号和课程的判断，以判定是否该学生选择过本课程，将教学班信息存入$selected变量。。
		//var_dump($tmp);
		$n = count($tmp);//$n存入教学班级数量

		//var_dump($selected);

		if(count($selected)>0)//如果有选过本课程
			$data["classselect"] = $selected[0]->class_id;//如果有，将班级号存入
		else
			$data["classselect"] = '0';//如果们没有选过本课程则存入标记符'0'
		
		for($i=1;$i<=$n;$i++){ //将所有课程的所有信息保存以传给前端
			$data["classid"][$i] = $tmp[$i-1]->class_id; //教学班号
			$data["coursename"][$i] = $tmp[$i-1]->class_name; //课程号
			$data["courseid"][$i] = $tmp[$i-1]->course_id; //课程号
			$data["major"][$i] = $tmp[$i-1]->type; //专业
			$data["teachername"][$i] = $tmp[$i-1]->teacher_name; //教师名
			$data["teacherid"][$i] = $tmp[$i-1]->teacher_id; //教师名
			$data["classroom"][$i] = $tmp[$i-1]->classroom; //上课教室
			$data["week"][$i] = $tmp[$i-1]->day; //周几上课
			$data["time"][$i] = $tmp[$i-1]->class_time; //第几节课
			$data['selectstu'][$i] = $tmp[$i-1]->margin; //余量
			$data['selectallow'][$i] = $tmp[$i-1]->capacity; //容量
		}
		$data["classnum"] = $n; //班级数
		/*
		$current_time = time();
		$year = date('y', $current_time);
		for ($i = 0; $i < 20; $i++)
			echo $year;
		$month = date('m', $current_time);
		for ($i = 0; $i < 20; $i++)
			echo $month;
		$day = date('d', $current_time);
		for ($i = 0; $i < 20; $i++)
			echo $day;
		$hour = date('H', $current_time);
		for ($i = 0; $i < 20; $i++)
			echo $hour;
		*/
		$this->load->view('r3/r3_s_selectpage',$data);
	}

	public function modifyclass($sid = 0 , $cid  = 0){
		/*
			
		*/
		echo 'getin!';
		$sid = $this->session->userdata('uid');

		$this->load->model('r3/r3_Score_model', 'scorem');
		$this->load->model('r3/r3_Class_model','classm');
		$this->load->model('r3/r3_Curriculum_model','currim');
		$this->load->model('r3/r3_Selecttime_model', 'systime');
		$clsid = $this->input->post('selectcid'); // 获取post方法来的选课号 

		$selected = $this->currim->whether_select($sid , $cid); //判断是否选了本课程
		var_dump($selected);

		//var_dump($tmp);

		/*
		if(count($selected)>0){
			$this->currim->delete_class($sid,$selected[0]->class_id);
		}
		*/

		$error_prompt = ''; //错误提示
		//下面获得系统当前时间
		$sys_month = date('m', time());
		$sys_day = date('d', time());
		$sys_hour = date('H', time());
		//获得管理员设置的选课时间
		$limit_time = $this->systime->get_original_time();
		$goodtime = 1;
		//以下判断当前的时间是否在管理员设置的选课时间里
		if ($sys_month < $limit_time[0]->start_month || ($sys_month == $limit_time[0]->start_month && $sys_day < $limit_time[0]->start_day)){
			$goodtime = 0;
			$error_prompt = '还没到选课时间！';
		}
		if ($sys_month == $limit_time[0]->start_month && $sys_day == $limit_time[0]->start_day && $sys_hour < $limit_time[0]->start_hour){
			$goodtime = 0;
			$error_prompt = '还没到选课时间！';	
		}
		if ($sys_month > $limit_time[0]->end_month || ($sys_month == $limit_time[0]->end_month && $sys_day > $limit_time[0]->end_day)){
			$goodtime = 0;
			$error_prompt = '现在不是选课时间！';
		}
		if ($sys_month == $limit_time[0]->end_month && $sys_day == $limit_time[0]->end_day && $sys_hour > $limit_time[0]->end_hour){
			$goodtime = 0;
			$error_prompt = '现在不是选课时间！';	
		}

		echo 'good after time';

		$this->load->model('r3/r3_Plan_model', 'planm');
		$this->load->model('r3/r3_Course_model', 'coursem');
		$this->load->model('r3/r3_Credit_model', 'creditm');
		$goodcredit = 1;
		$tmp = $this->planm->get_all_major($sid);//获取所有该学号下的培养方案课程
		$n_major = count($tmp);
		$currentcredit = 0;
		$optioncredit = 0;
		$commoncredit = 0;
		for ($i = 0; $i < $n_major; $i++){
			$infotmp = $this->coursem->get_course_all($tmp[$i]->course_id);
			$currentcredit += $infotmp[0]->credit;
			if ($infotmp[0]->course_type == '专业必修课'){
				$optioncredit += $infotmp[0]->credit;
			}
			else
			if ($infotmp[0]->course_type == '公共课'){
				$commoncredit += $infotmp[0]->credit;
			}
		}
		$this->load->model('r3/r3_Student_model','studentm');
		$department = $this->studentm->get_department_by_id($sid);
		$creditmin = $this->creditm->get_all_by_department($department[0]->department);
		if ($currentcredit < $creditmin[0]->credit_min || $optioncredit < $creditmin[0]->option_min || $commoncredit < $creditmin[0]->common_min)
			$goodcredit = 0;

		$score_state = $this->scorem->get_score_by_sidcid($sid, $cid);
		$n_score = count($score_state);
		echo 'good before judge';
		//若当前不是选课时间，给出相应的提示
		if ($goodtime == 0){
			echo 'badtime';
			$data['content'] = $error_prompt;
			$data['sid'] = $sid;
			$data['cid'] = $cid;
			$this->load->view('r3/r3_s_alert', $data);
		}
		else //若在选课时间内，根据学生不同的操作，做出相应的处理
		if ($goodcredit == 0){
			echo 'bad plan';
			$data['content'] = '培养方案不满足要求，请先制定好培养方案！';
			$data['sid'] = $sid;
			$data['cid'] = $cid;
			$this->load->view('r3/r3_s_alert', $data);
		}
		else
		if ($n_score > 0 && $score_state[0]->score >= 60){
			echo 'bad class';
			$data['content'] = '这门课已经修过了，不能重复修读！'.$score_state[0]->score;
			$data['sid'] = $sid;
			$data['cid'] = $cid;
			$this->load->view('r3/r3_s_alert', $data);
		}
		else
		if($clsid){
			echo 'good class';
			for ($d = 0; $d < 10; $d++)
				echo $clsid;
			if (count($selected)>0){
					$this->currim->delete_class($sid,$selected[0]->class_id);
			}

			/*  TODO
			$chosentime = $this->classm->get_time_by_cid($clsid);
			$existedtime = $this->currim->get_time_by_sid($sid);
			$n = count($existedtime);
			TODO   */
			$good = 1;

			//以下判断当前选的课是否与已选上的课有冲突
			/* TOD
			for ($i = 0; $i < $n; $i++){
				if ($chosentime[0]->day == $existedtime[$i]->day && $chosentime[0]->class_time == $existedtime[$i]->class_time){
					$good = 0;
					$error_prompt = '上课时间冲突';
					break;
				}
				if ($chosentime[0]->test_time == $existedtime[$i]->test_time){
					$good = 0;
					$error_prompt = '考试时间冲突';
					break;
				}
			}
			TODO */

			//以下判断当前选的课是否还有余量
			$margin = $this->classm->get_margin_by_cid($clsid);
			if ($margin[0]->margin <= 0){
				$good = 0;
				$error_prompt = '教学班余量不足';
			}

			if ($good == 1){//若一切都没问题，给学生选上这门课
				$this->currim->add_class($sid, $clsid);
				$data['content'] = '选课成功！';
				$data['sid'] = $sid;
				$data['cid'] = $cid;
				$this->load->view('r3/r3_s_alert', $data);
			}
			else//否则给出相应的提示
			{
				$data['content'] = $error_prompt;
				$data['sid'] = $sid;
				$data['cid'] = $cid;
				$this->load->view('r3/r3_s_alert', $data);
			}

			
				
		}
		else
		if(count($selected)>0){ //删除课程的操作
			if ($n_score > 0 && $score_state[0]->score < 60){
				$data['content'] = '这门课需要重修，不能退';
				$data['sid'] = $sid;
				$data['cid'] = $cid;
				$this->load->view('r3/r3_s_alert', $data);
			}
			else
			{
				$this->currim->delete_class($sid,$selected[0]->class_id); //直接为他删课
				$data['content'] = '删课成功！';
				$data['sid'] = $sid;
				$data['cid'] = $cid;
				$this->load->view('r3/r3_s_alert', $data);	
			}
		}
		else //若什么操作都没有，但是却点了保存，系统什么都不做
		{
			$data['content'] = 'nothing';
			$data['sid'] = $sid;
			$data['cid'] = $cid;
			$this->load->view('r3/r3_s_alert', $data);
		}
		
		//$this->selectpage($sid,$cid);
		
	}




	//学生的搜索引擎
	public function selectengine($sid = '0'){
		$sid = $this->session->userdata('uid');
		
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

		$margin = $this->input->post('onlyshow');
		$margin_require = 0;
		if ($margin)
			$margin_require = 1;

		$this->load->model('r3/r3_Curriculum_model', 'currim2'); //加载curriculum_model

		//根据条件搜索课程！
		$res1 = $this->coursem->get_course_by_condition($major, $CN, $Cid, $Ctime, $Cplace, $TN, $Tid, $margin_require);
		//再把该学生已经选上的所有教学班查出来
		$res2 = $this->currim2->get_all_course($sid);
		//var_dump($res1);
		$n = count($res1);
		$nj = count($res2);
		$data["coursenum"] = $n;

		$j = 0;
		//标记出所有已经选上的课
		for ($i = 1; $i <= $n; $i++){
			/*
			$data["courseid"][$i] = $res1[$i-1]->course_id;
			$data["coursename"][$i] = $res1[$i-1]->course_name;
			while ($j >= 0 && $j < $nj && $res2[$j]->course_id < $res1[$i-1]->course_id){
				$j++;
			}
			if ($j >= $nj)
				$j = $nj-1;
			if ($j>=0 && $res1[$i-1]->course_id == $res2[$j]->course_id)
				$data["courseselect"][$i] = 1;
			else
				$data["courseselect"][$i] = 0;
			*/
			$data["courseid"][$i] = $res1[$i-1]->course_id;
			$data["coursename"][$i] = $res1[$i-1]->course_name;
			$found = 0;
			for ($j = 0; $j < $nj; $j++){
				if ($res2[$j]->course_id == $res1[$i-1]->course_id){
					$found = 1;
					break;
				}
			}
			if ($found == 1){
				$data["courseselect"][$i] = 1;
			}
			else
				$data["courseselect"][$i] = 0;
		}
		$this->load->view('r3/r3_s_selectengine', $data); //加载搜索引擎的视图，并且把结果传过去
	}


	public function selectmajor($sid = '0'){
	/*
		按照专业课程选课，读取培养方案中的课程并提给供用户以供选课
	*/
		$sid = $this->session->userdata('uid');

		$this->load->model('r3/r3_Plan_model','planm');
		$tmp = $this->planm->get_all_major($sid);//获取所有专业课
		$this->load->model('r3/r3_Course_model','coursem');
		$this->load->model('r3/r3_Curriculum_model','Curriculum_model');

		$tmp1 = $this->Curriculum_model->get_all_course($sid); //获取所有已选课程
		//var_dump($tmp);
		//var_dump( $tmp[1] );
		//var_dump( $tmp[1]->course_id );
		$n = count($tmp);//专业课数
		$nj = count($tmp1);//已选课数
		$data["coursenum"] = $n;

		$j=0;
		for($i=1;$i<=$n;$i++){ //因为都是按照从小到大顺序的，所以可以进行O(n)的归并,以区分出已经选过的专业课和没选过的专业课
			$data["courseid"][$i] = $tmp[$i-1]->course_id; //
			$tmp2 = $this->coursem->get_course_name($tmp[$i-1]->course_id);
			$data["coursename"][$i] = $tmp2[0]->course_name;

			while($j >= 0 && $j<$nj && $tmp1[$j]->course_id < $tmp[$i-1]->course_id){//跳过已选的没有出现在专业课程列表里的课程
				$j++;
			}
			

			if($j >= $nj)
				$j = $nj - 1;
			//echo $j.' '.$tmp1[$j]->course_id.' '.$tmp[$i-1]->course_id.' <br>';
			if($j >= 0 && $tmp[$i-1]->course_id == $tmp1[$j]->course_id) //如果专业课是在已选课程内，则标记为1，否则记为0
				$data["courseselect"][$i] = 1;
			else 
				$data["courseselect"][$i] = 0;
		}

		$this->load->view('r3/r3_s_selectmajor',$data);
	}
	public function selectall($sid = 0){
		/*
		所有课程选课，提供所有课程给用户


		*/
		$sid = $this->session->userdata('uid');
		$this->load->model('r3/r3_Course_model','coursem');
		$this->load->model('r3/r3_Curriculum_model','Curriculum_model');

		
		$tmp = $this->coursem->get_all_course();
		$tmp1 = $this->Curriculum_model->get_all_course($sid);
		$n = count($tmp);
		//var_dump($tmp);
		$nj = count($tmp1);
		$j=0;
		//var_dump($tmp1);
		for($i=1;$i<=$n;$i++){// 与专业课程选课类似，进行归并以筛选出已选的课程
			$data["courseid"][$i] = $tmp[$i-1]->course_id;
			$data["coursename"][$i] = $tmp[$i-1]->course_name;

			while($j>=0 && $j<$nj && $tmp1[$j]->course_id < $tmp[$i-1]->course_id){ 
				$j++;
			}
			

			if($j >= $nj)
				$j = $nj - 1;
			//echo $j.' '.$tmp1[$j]->course_id.' '.$tmp[$i-1]->course_id.' <br>';
			if($j>=0 && $tmp[$i-1]->course_id == $tmp1[$j]->course_id) //对课程进行标记，1为已选，0为未选
				$data["courseselect"][$i] = 1;
			else 
				$data["courseselect"][$i] = 0;
		}
		$data["coursenum"] = $n;


		$this->load->view('r3/r3_s_selectall',$data);
	}

	public function courseinfo($cid = '0'){
		/*
		获取课程信息
		*/
		if($cid == '0'){
			echo '404 这是什么鬼课？';
			return ;
		}

		$this->load->model('r3/r3_Course_model','coursem');
		$tmp = $this->coursem->get_course_all($cid);//按照课程id获取所有有关的课程信息。
		//var_dump($tmp);
		$data["coursename"] = $tmp[0]->course_name;//课程名
		$data["courseid"] = $tmp[0]->course_id;//课程id
		$data["major"] = $tmp[0]->type;//课程所属专业
		$data["credit"] = $tmp[0]->credit;//学分
		$data["weight"] = $tmp[0]->weight;//权重
		$data["info"] = $tmp[0]->intro;//简介
		$this->load->view('r3/r3_s_courseinfo',$data);
	}

	public function plan($sid = '0'){
		/*
			根据学号，进行培养方案编排

		*/

		
		$user_type = $this->session->userdata('user_type');
 		$sid = $this->session->userdata('uid');


		$this->load->model('r3/r3_Plan_model','planm');
		$this->load->model('r3/r3_Student_model','studentm');
		
		$department = $this->studentm->get_department_by_id($sid);
		$major_added = $this->studentm->whether_major_added($sid);
		if ($major_added == 0){
			$this->planm->add_all_major($sid, $department[0]->department);
		}

		
		$tmp = $this->planm->get_all_major($sid);//获取所有该学号下的培养方案课程
		$this->load->model('r3/r3_Score_model', 'scorem');
		$this->load->model('r3/r3_Course_model','coursem');
		
		
//		echo $major;

		$major = '0';

		//echo $this->input->post('major');
		if($this->input->post('major')){ //获取读入参数“专业”，以按专业提供课程给前端以供用户选择
			$major = $this->input->post('major');
		}

		if($major!='0'&&$major!="所有课程"){ //如果是获取所有课程则读取所有课程，否则按专业获取课程
			$tmpnc = $this->coursem->get_course_by_type($major);
			$flag1 = 1;
		}
		else{
			$tmpnc = $this->coursem->get_all_course();
			$flag1 = 0;
		}



		
		$n = count($tmp);//已选课程
		$mn = count($tmpnc); //专业下的课程
		$tot = 0;
		for($i=1,$j=1;$i<=$n&&$j<=$mn;){ //对已选课程和专业课程进行归并，以区分课程是否已选入培养方案
			
			if($tmp[$i-1]->course_id == $tmpnc[$j-1]->course_id){ //专业课程中的已选课程
				$tmp4 = $this->coursem->get_coursetype_by_Cid($tmpnc[$j-1]->course_id);
				if ($tmp4[0]->course_type == '专业必修课' && $tmpnc[$j-1]->type == $department[0]->department){
					$i++;$j++;	
					continue;
				}

				$tot++;
				$op = $tmp[$i-1];
				$data["courseselect"][$tot] = 1;

				$whether_pass = $this->scorem->get_state_by_sidCid($sid, $tmpnc[$j-1]->course_id);
				if ($whether_pass == 1){
					$data['getcredit'][$tot] = 1;
				}
				else
					$data['getcredit'][$tot] = 0;	

				$i++;$j++;
			}else if($tmp[$i-1]->course_id < $tmpnc[$j-1]->course_id){//已选课程但非该专业课程
				//$op = $tmp[$i-1];
				//$data["courseselect"][$tot] = 1;
				$i++;
				continue;
			}else{ //专业课程中的未选课程
				$tmp4 = $this->coursem->get_coursetype_by_Cid($tmpnc[$j-1]->course_id);
				if ($tmp4[0]->course_type == '专业必修课' && $tmpnc[$j-1]->type == $department[0]->department){
					$j++;	
					continue;
				}				

				$tot++;
				$op = $tmpnc[$j-1];
				$data["courseselect"][$tot] = 0;

				$whether_pass = $this->scorem->get_state_by_sidCid($sid, $tmpnc[$j-1]->course_id);
				if ($whether_pass == 1){
					$data['getcredit'][$tot] = 1;
				}
				else
					$data['getcredit'][$tot] = 0;

				$j++;
			}

			$data["courseid"][$tot] = $op->course_id;
			$tmp2 = $this->coursem->get_course_name($op->course_id);
			$data["coursename"][$tot] = $tmp2[0]->course_name;

			$tmp3 = $this->coursem->get_coursetype_by_Cid($op->course_id);
			$data['coursetype'][$tot] = $tmp3[0]->course_type;
		}

		while($j<=$mn){
			$tmp4 = $this->coursem->get_coursetype_by_Cid($tmpnc[$j-1]->course_id);
			if ($tmp4[0]->course_type == '专业必修课' && $tmpnc[$j-1]->type == $department[0]->department){
				$j++;	
				continue;
			}


			$tot++;
			$data["courseselect"][$tot] = 0;

			$op = $tmpnc[$j-1];

			$data["courseid"][$tot] = $op->course_id;
			$tmp2 = $this->coursem->get_course_name($op->course_id);
			$data["coursename"][$tot] = $tmp2[0]->course_name;

			$tmp3 = $this->coursem->get_coursetype_by_Cid($op->course_id);
			$data['coursetype'][$tot] = $tmp3[0]->course_type;

			$whether_pass = $this->scorem->get_state_by_sidCid($sid, $tmpnc[$j-1]->course_id);
			if ($whether_pass == 1){
				$data['getcredit'][$tot] = 1;
			}
			else
				$data['getcredit'][$tot] = 0;

			$j++;
		}
		
		$data["coursenum"] = $tot;


		$tmpm = $this->coursem->get_all_type();//获取所有的专业
		$typen = count($tmpm); //专业数
		for($i=1;$i<=$typen;$i++){ //把专业信息传给前端
			$data["majors"][$i] = $tmpm[$i-1]->type;
		}
		
		$data["majornum"]=$typen;//专业数
		//$data["majors"] = array('','拜周神','拜红神','拜珉神');
		if($major != '0'&&$major != '所有课程') //储存一下现在正在获取的专业
			$data["nowmajor"] = $major;
		else 
			$data["nowmajor"] = '所有课程';

		//获取各种最低学分要求和当前各种学分
		$this->load->model('r3/r3_Credit_model','creditm');

		$creditmin = $this->creditm->get_all_by_department($department[0]->department);
		$data['mincredit'] = $creditmin[0]->credit_min;
		$data['optionmin'] = $creditmin[0]->option_min;
		$data['commonmin'] = $creditmin[0]->common_min;
		$currentcredit = 0;
		$optioncredit = 0;
		$commoncredit = 0;
		for ($i = 0; $i < $n; $i++){
			$infotmp = $this->coursem->get_course_all($tmp[$i]->course_id);
			$currentcredit += $infotmp[0]->credit;
			if ($infotmp[0]->course_type == '专业必修课'){
				$optioncredit += $infotmp[0]->credit;
			}
			else
			if ($infotmp[0]->course_type == '公共课'){
				$commoncredit += $infotmp[0]->credit;
			}
		}
		$data['currentcredit'] = $currentcredit;
		$data['optioncredit'] = $optioncredit;
		$data['commoncredit'] = $commoncredit;

		$this->load->view('r3/r3_s_plan',$data);

		


	}

	public function plan_droped($sid = '0'){
		/*
			根据学号，进行培养方案编排

		*/

		$user_type = $this->session->userdata('user_type');
 		$sid = $this->session->userdata('uid');

		$this->load->model('r3/r3_Plan_model','planm');
		$this->load->model('r3/r3_Student_model','studentm');
		$this->load->model('ims/Ims_interface_model','imsm');
		
		//$stu_info = $this->imsm->getStudent($uid);

		$department = $this->studentm->get_department_by_id($sid);
		//$department = $stu_info['college'];
		
		
		$major_added = $this->studentm->whether_major_added($sid);
		//$major_added = $stu_info['major_added'];
		
		if ($major_added == 0){
			$this->planm->add_all_major($sid, $department[0]->department);
			//TODO
		}

		
		$tmp = $this->planm->get_all_major($sid);//获取所有该学号下的培养方案课程
		
		$this->load->model('r3/r3_Score_model', 'scorem');
		//$this->load->model('r3_Course_model','coursem');
		
		
		$temp = array('college'=>'计算机学院');
		var_dump($temp);
		$temp2 = $this->imsm->search_course($temp);
		var_dump($temp2);
		for ($i = 0; $i < count($temp2); $i++)
			//echo $temp2[$i]->course_id;
			echo $temp2[$i]['course_id'];

		
		$major = '0';
		$tmpnc = array();

		//echo $this->input->post('major');
		if($this->input->post('major')){ //获取读入参数“专业”，以按专业提供课程给前端以供用户选择
			$major = $this->input->post('major');
		}

		if($major!='0'&&$major!="所有课程"){ //如果是获取所有课程则读取所有课程，否则按专业获取课程
			//$tmpnc = $this->coursem->get_course_by_type($major); //TODO
			$temp = array('college'=>'计算机学院');
			var_dump($temp);
			$temp2 = $this->imsm->search_course($temp);
			$mn = count($temp2);
			for ($i = 0; $i < $mn; $i++){
				$tmpnc[$i]->course_id = $temp2[$i]['course_id'];
				$tmpnc[$i]->type = $temp2[$i]['college'];
				echo $tmpnc[$i]->course_id.'  '.$tmpnc[$i]->type.' ';
			}

			$flag1 = 1;
		}
		else{
			//$tmpnc = $this->coursem->get_all_course();
			$temp = array();
			$temp2 = $this->imsm->search_course($temp);
			$mn = count($temp2);
			for ($i = 0; $i < $mn; $i++){
				$d = new r3_courseinfo();
				$d->course_id = $temp2[$i]['course_id'];
				$d->type = $temp2[$i]['college'];
				$tmpnc[] = $d;

			}
			$flag1 = 0;
		}

		var_dump($tmpnc);


		$n = count($tmp);//已选课程
		$mn = count($tmpnc); //专业下的课程
		$tot = 0;
		for($i=1,$j=1;$i<=$n&&$j<=$mn;){ //对已选课程和专业课程进行归并，以区分课程是否已选入培养方案
			
			if($tmp[$i-1]->course_id == $tmpnc[$j-1]->course_id){ //专业课程中的已选课程
				$tmp4 = $this->coursem->get_coursetype_by_Cid($tmpnc[$j-1]->course_id);
				if ($tmp4[0]->course_type == '专业必修课' && $tmpnc[$j-1]->type == $department[0]->department){
					$i++;$j++;	
					continue;
				}

				$tot++;
				$op = $tmp[$i-1];
				$data["courseselect"][$tot] = 1;

				$whether_pass = $this->scorem->get_state_by_sidCid($sid, $tmpnc[$j-1]->course_id);
				if ($whether_pass == 1){
					$data['getcredit'][$tot] = 1;
				}
				else
					$data['getcredit'][$tot] = 0;	

				$i++;$j++;
			}else if($tmp[$i-1]->course_id < $tmpnc[$j-1]->course_id){//已选课程但非该专业课程
				//$op = $tmp[$i-1];
				//$data["courseselect"][$tot] = 1;
				$i++;
				continue;
			}else{ //专业课程中的未选课程
				$tmp4 = $this->coursem->get_coursetype_by_Cid($tmpnc[$j-1]->course_id);
				if ($tmp4[0]->course_type == '专业必修课' && $tmpnc[$j-1]->type == $department[0]->department){
					$j++;	
					continue;
				}				

				$tot++;
				$op = $tmpnc[$j-1];
				$data["courseselect"][$tot] = 0;

				$whether_pass = $this->scorem->get_state_by_sidCid($sid, $tmpnc[$j-1]->course_id);
				if ($whether_pass == 1){
					$data['getcredit'][$tot] = 1;
				}
				else
					$data['getcredit'][$tot] = 0;

				$j++;
			}

			$data["courseid"][$tot] = $op->course_id;
			$tmp2 = $this->coursem->get_course_name($op->course_id);
			$data["coursename"][$tot] = $tmp2[0]->course_name;

			$tmp3 = $this->coursem->get_coursetype_by_Cid($op->course_id);
			$data['coursetype'][$tot] = $tmp3[0]->course_type;
		}
		/*
		while($i<=$n){
			$tot++;
			$data["courseselect"][$tot] = 1;

			$op = $tmp[$i-1];

			$data["courseid"][$tot] = $op->course_id;
			$tmp2 = $this->coursem->get_course_name($op->course_id);
			$data["coursename"][$tot] = $tmp2[0]->course_name;

			$i++;
		}*/
		while($j<=$mn){
			$tmp4 = $this->coursem->get_coursetype_by_Cid($tmpnc[$j-1]->course_id);
			if ($tmp4[0]->course_type == '专业必修课' && $tmpnc[$j-1]->type == $department[0]->department){
				$j++;	
				continue;
			}


			$tot++;
			$data["courseselect"][$tot] = 0;

			$op = $tmpnc[$j-1];

			$data["courseid"][$tot] = $op->course_id;
			$tmp2 = $this->coursem->get_course_name($op->course_id);
			$data["coursename"][$tot] = $tmp2[0]->course_name;

			$tmp3 = $this->coursem->get_coursetype_by_Cid($op->course_id);
			$data['coursetype'][$tot] = $tmp3[0]->course_type;

			$whether_pass = $this->scorem->get_state_by_sidCid($sid, $tmpnc[$j-1]->course_id);
			if ($whether_pass == 1){
				$data['getcredit'][$tot] = 1;
			}
			else
				$data['getcredit'][$tot] = 0;

			$j++;
		}
		
		$data["coursenum"] = $tot;


		$tmpm = $this->coursem->get_all_type();//获取所有的专业
		$typen = count($tmpm); //专业数
		for($i=1;$i<=$typen;$i++){ //把专业信息传给前端
			$data["majors"][$i] = $tmpm[$i-1]->type;
		}
		
		$data["majornum"]=$typen;//专业数
		//$data["majors"] = array('','拜周神','拜红神','拜珉神');
		if($major != '0'&&$major != '所有课程') //储存一下现在正在获取的专业
			$data["nowmajor"] = $major;
		else 
			$data["nowmajor"] = '所有课程';

		//获取各种最低学分要求和当前各种学分
		$this->load->model('r3/r3_Credit_model','creditm');

		$creditmin = $this->creditm->get_all_by_department($department[0]->department);
		$data['mincredit'] = $creditmin[0]->credit_min;
		$data['optionmin'] = $creditmin[0]->option_min;
		$data['commonmin'] = $creditmin[0]->common_min;
		$currentcredit = 0;
		$optioncredit = 0;
		$commoncredit = 0;
		for ($i = 0; $i < $n; $i++){
			$infotmp = $this->coursem->get_course_all($tmp[$i]->course_id);
			$currentcredit += $infotmp[0]->credit;
			if ($infotmp[0]->course_type == '专业必修课'){
				$optioncredit += $infotmp[0]->credit;
			}
			else
			if ($infotmp[0]->course_type == '公共课'){
				$commoncredit += $infotmp[0]->credit;
			}
		}
		$data['currentcredit'] = $currentcredit;
		$data['optioncredit'] = $optioncredit;
		$data['commoncredit'] = $commoncredit;

		$this->load->view('r3/r3_s_plan',$data);
		/*


		$n = count($tmp);//已选课程
		$mn = count($tmpnc); //专业下的课程
		$tot = 0;
		for($i=1,$j=1;$i<=$n&&$j<=$mn;){ //对已选课程和专业课程进行归并，以区分课程是否已选入培养方案
			
			//if($tmp[$i-1]->course_id == $tmpnc[$j-1]->course_id){ //专业课程中的已选课程
			if($tmp[$i-1]->course_id == $tmpnc[$j-1]['course_id']){ //专业课程中的已选课程
				//$tmp4 = $this->coursem->get_coursetype_by_Cid($tmpnc[$j-1]->course_id);
				if ($tmpnc[$j-1]['course_type'] == 1 && $tmpnc[$j-1]['college'] == $department){
					$i++;$j++;	
					continue;
				}

				$tot++;
				$op = $tmp[$i-1];
				$data["courseselect"][$tot] = 1;

				$whether_pass = $this->scorem->get_state_by_sidCid($uid, $tmpnc[$j-1]['course_id']); //TODO
				if ($whether_pass == 1){
					$data['getcredit'][$tot] = 1;
				}
				else
					$data['getcredit'][$tot] = 0;	

				$i++;$j++;
			}else if($tmp[$i-1]->course_id < $tmpnc[$j-1]->course_id){//已选课程但非该专业课程
				//$op = $tmp[$i-1];
				//$data["courseselect"][$tot] = 1;
				$i++;
				continue;
			}else{ //专业课程中的未选课程
				$tmp4 = $this->coursem->get_coursetype_by_Cid($tmpnc[$j-1]->course_id);
				if ($tmp4[0]->course_type == '专业必修课' && $tmpnc[$j-1]->type == $department[0]->department){
					$j++;	
					continue;
				}				

				$tot++;
				$op = $tmpnc[$j-1];
				$data["courseselect"][$tot] = 0;

				$whether_pass = $this->scorem->get_state_by_sidCid($sid, $tmpnc[$j-1]->course_id);
				if ($whether_pass == 1){
					$data['getcredit'][$tot] = 1;
				}
				else
					$data['getcredit'][$tot] = 0;

				$j++;
			}

			$data["courseid"][$tot] = $op->course_id;
			$tmp2 = $this->coursem->get_course_name($op->course_id);
			$data["coursename"][$tot] = $tmp2[0]->course_name;

			$tmp3 = $this->coursem->get_coursetype_by_Cid($op->course_id);
			$data['coursetype'][$tot] = $tmp3[0]->course_type;
		}
		
		while($j<=$mn){
			$tmp4 = $this->coursem->get_coursetype_by_Cid($tmpnc[$j-1]->course_id);
			if ($tmp4[0]->course_type == '专业必修课' && $tmpnc[$j-1]->type == $department[0]->department){
				$j++;	
				continue;
			}


			$tot++;
			$data["courseselect"][$tot] = 0;

			$op = $tmpnc[$j-1];

			$data["courseid"][$tot] = $op->course_id;
			$tmp2 = $this->coursem->get_course_name($op->course_id);
			$data["coursename"][$tot] = $tmp2[0]->course_name;

			$tmp3 = $this->coursem->get_coursetype_by_Cid($op->course_id);
			$data['coursetype'][$tot] = $tmp3[0]->course_type;

			$whether_pass = $this->scorem->get_state_by_sidCid($sid, $tmpnc[$j-1]->course_id);
			if ($whether_pass == 1){
				$data['getcredit'][$tot] = 1;
			}
			else
				$data['getcredit'][$tot] = 0;

			$j++;
		}
		
		$data["coursenum"] = $tot;


		$tmpm = $this->coursem->get_all_type();//获取所有的专业
		$typen = count($tmpm); //专业数
		for($i=1;$i<=$typen;$i++){ //把专业信息传给前端
			$data["majors"][$i] = $tmpm[$i-1]->type;
		}
		
		$data["majornum"]=$typen;//专业数
		//$data["majors"] = array('','拜周神','拜红神','拜珉神');
		if($major != '0'&&$major != '所有课程') //储存一下现在正在获取的专业
			$data["nowmajor"] = $major;
		else 
			$data["nowmajor"] = '所有课程';

		//获取各种最低学分要求和当前各种学分
		$this->load->model('r3_Credit_model','creditm');

		$creditmin = $this->creditm->get_all_by_department($department[0]->department);
		$data['mincredit'] = $creditmin[0]->credit_min;
		$data['optionmin'] = $creditmin[0]->option_min;
		$data['commonmin'] = $creditmin[0]->common_min;
		$currentcredit = 0;
		$optioncredit = 0;
		$commoncredit = 0;
		for ($i = 0; $i < $n; $i++){
			$infotmp = $this->coursem->get_course_all($tmp[$i]->course_id);
			$currentcredit += $infotmp[0]->credit;
			if ($infotmp[0]->course_type == '专业必修课'){
				$optioncredit += $infotmp[0]->credit;
			}
			else
			if ($infotmp[0]->course_type == '公共课'){
				$commoncredit += $infotmp[0]->credit;
			}
		}
		$data['currentcredit'] = $currentcredit;
		$data['optioncredit'] = $optioncredit;
		$data['commoncredit'] = $commoncredit;

		$this->load->view('r3_s_plan',$data);

		*/
	}




	public function logout(){
		/*********************************
			待更改，登出，等待一组给接口
		*********************************/
		for ($i = 0; $i < 100; $i++)
			echo "shit happens!";
	}
	public function curriculum($sid = 0){
		/*
			获取全部课表
		*/
		$sid = $this->session->userdata('uid');

		$this->load->model('r3/r3_Curriculum_model','Curriculum_model');
		$this->load->model('r3/r3_Course_model','coursem');
		//$tmp = $this->Curriculum_model->get_all_class($sid);//从课表模块中获取所有已选教学班
		$tmp = $this->Curriculum_model->get_curriculum_by_sid($sid);//从课表模块中获取所有已选教学班
		//var_dump($tmp);
		//classtime\classweek\courseid\coursename
		$n = count($tmp);//已选教学班数量
		$current_credit = 0; //当前选上的学分

		for($i=0;$i<$n;$i++){//读出了所有的教学班信息通知给前端
			$data['classtime'][$i+1] = $tmp[$i]->class_time;
			$data['classweek'][$i+1] = $tmp[$i]->day;
			$data['courseid'][$i+1] = $tmp[$i]->course_id;
			$tmp2 = $this->coursem->get_course_name($tmp[$i]->course_id);//因为课程信息没有存在教学班模块中，所以获取一下课程id以供获取更多信息
			$data['coursename'][$i+1] = $tmp2[0]->course_name;

			$tmp3 = $this->coursem->get_credit_by_Cid($tmp[$i]->course_id);
			$current_credit += $tmp3[0]->credit;
		}

		$data['classnum'] = $n;
		$data['currentcredit'] = $current_credit;


		$this->load->view('r3/r3_s_curriculum',$data);

	}
/*	public function setid(){
		$sid = $this->input->post('id');
//		echo $sid;
		$data['ssid'] = $sid;
		$this->load->view('t1', $data );
	}
*/	public function test(){//测试用方法，请无视
 		//$this->load->view('test');
		//$this->load->model('r3_Curriculum_model', 'curriculumm');
		//$id = '3120000666';
		//$res=$this->curriculumm->get_all_class($id);
		//var_dump($res);
		$data['content'] = '需要其他组接口';
		$this->load->view('r3/alert',$data);
	}
	public function homepage(){
		/*
		回到首页
		*/
 		$this->load->view('r3/r3_s_homepage');
	}
/*	public function getmajor($majorid = 0,$sid = '0'){
 		//$data['majorid'] = $majorid;

		plan($sid = '0',$major = $majorid);

	}
*/	
	public function getplan( $stu_id ){
		/*
			获取培养方案
		*/
 		$data['majorid'] = $majorid;
		$this->load->view('r3/test',$data);
	}
	public function modifymajorcourse($stu_id,$courseid){
		/*
			处理培养方案课程，用学号和课程号来直接与模块交互
			从前端只获取信息，不需要返回或重调前端页面

		*/
		$stu_id = $this->session->userdata('uid');

 		$this->load->model('r3/r3_Plan_model','planm');
 		$res = $this->planm->is_selected($stu_id,$courseid);//判断是否已经选择


		if(count($res) == 0)//如果没选，则加到培养方案里，如果已经选择了，则从培养方案中删除
			$tmp = $this->planm->add_major($stu_id,$courseid);
		else
			$tmp = $this->planm->delete_major($stu_id,$courseid);
		if($tmp)echo 'success';
		else echo 'failure';
		//$this->load->view('test',$data);
	}


	public function getmajorplan($majorid){
		/*
			获取专业培养方案
		*/
 		$data['majorid'] = $majorid;
		$this->load->view('r3/test',$data);
	}
	public function index(){
 		//$this->load->view('r3_s_homepage');
 		//for ($i = 0; $i < 100; $i++){
 			//echo 'something happen';
 		//}

		$user_type = $this->session->userdata('user_type');
 		$uid = $this->session->userdata('uid');
 		if ($user_type == 1){
 			$this->load->view('r3/r3_s_homepage');
 		}
 		else
 		if ($user_type == 2){
 			$this->load->view('r3/r3_t_homepage');
 		}
 		else
 		if ($user_type == 3 || $user_type == 4){
 			$this->load->view('r3/r3_a_homepage');
 		}
 		else
 		{
 			echo 'who are u!';
 		}

	}
} 



?>