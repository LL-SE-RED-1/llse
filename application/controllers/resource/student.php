<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends CI_Controller {
	var $id = 4;

    
	/* construct function */
	function __construct()
	{
    	parent::__construct();
        $this->id = $this->session->userdata("uid");
        $type = $this->session->userdata("user_type");
        if ($type == 1)
            return;
        if ($type == 2)
            redirect("resource/teacher");
        else
            redirect("llse_welcome");
    }
	/**
	*学生模块索引页 根据年份学期 选择一门所修课程
	*@param 学年 学期
	*@return null
	*/
	public function index($year = "", $term = "") {
		//载入model
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		//取当前学年 学期
		if ($year == "") $year = $this->adaptor->get_current_year();
		if ($term == "") $term = $this->adaptor->get_current_term();

		$userinfo = $this->adaptor->get_user_info($this->id)[0];
		$curyear = $this->adaptor->get_current_year();
		//所有学年列表
		$data["years"] = [];
        $data["search_str"] = "";
		for ($i = $userinfo["firstyear"]; $i <= $curyear; ++$i) {
			array_push($data["years"], $i);
		}
		//基本信息
		$data["year"] = $year;
		$data["term"] = $term;
		$courselist = $this->adaptor->get_course_list_by_year_and_term($this->id, $year, $term);
		$data["data"] = $courselist;
		$data["role"] = $userinfo["type"];

		$this->load->view('resource/index', $data);
	}
	
	/**
	*学生模块显示全部资源
	*@param 所选课程ID
	*@return null
	*/
	public function filelist_all($courseid) {
		//载入model
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_student_has_course($this->id, $courseid))
			show_404();
			
		//基本信息
		$userinfo = $this->adaptor->get_user_info($this->id);
		$data["role"] = $userinfo[0]["type"];
		$courseinfo = $this->adaptor->get_course_info($courseid);
		$data["year"] = $courseinfo[0]["year"];
		$data["term"] = $courseinfo[0]["term"];
		$data["course_name"] = $courseinfo[0]["name"];

		$data["userid"] = $this->id;
		$data["courseid"] = $courseid;
		//资源列表
		$data["data"] = [];
		$filelist = $this->datamodel->get_course_resource_list($courseid);
		for ($i = 0; $i < count($filelist); ++$i) {
			$data["data"][$i]["uploaderid"] = $filelist[$i]["uploader"];
			$uploaderinfo = $this->adaptor->get_user_info($filelist[$i]["uploader"]);
			
			$data["data"][$i]["filename"] = $filelist[$i]["filename"];
			$data["data"][$i]["username"] = $uploaderinfo[0]["name"];
			$data["data"][$i]["time"] = $filelist[$i]["uploadtime"];
			$data["data"][$i]["fileid"] = $filelist[$i]["fileid"];
			$fileinfo = $this->datamodel->get_file_detail($filelist[$i]["fileid"]);
			$data["data"][$i]["filesize"] = $fileinfo[0]["filesize"];
			$data["data"][$i]["download"] = $filelist[$i]["download"];
            $data["data"][$i]["istop"] = $filelist[$i]["expiration"] >  date('Y-m-d H:i:s', time());
		}
		usort($data['data'], function($a, $b){
            if ($a["istop"] != $b["istop"])
                return $b["istop"] - $a["istop"];
			return $b['download'] - $a['download'];
		});
		$this->load->view("resource/filelist", $data);
	}
	
	/**
	*学生模块显示教师所传资源
	*@param 所选课程ID
	*@return null
	*/
	public function filelist_teacher($courseid) {
		//载入model
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_student_has_course($this->id, $courseid))
			show_404();
			
		//基本信息
		$userinfo = $this->adaptor->get_user_info($this->id);
		$data["role"] = $userinfo[0]["type"];
		$courseinfo = $this->adaptor->get_course_info($courseid);
		$data["year"] = $courseinfo[0]["year"];
		$data["term"] = $courseinfo[0]["term"];
		$data["course_name"] = $courseinfo[0]["name"];

		$data["userid"] = $this->id;
		$data["courseid"] = $courseid;
		//教师资源列表
		$teacher_count = 0;
		$data["data"] = [];
		$filelist = $this->datamodel->get_course_resource_list($courseid);
		for ($i = 0; $i < count($filelist); ++$i) {
			$uploaderinfo = $this->adaptor->get_user_info($filelist[$i]["uploader"]);
			if ($uploaderinfo[0]["type"] == 0) continue;
			
			$data["data"][$teacher_count]["uploaderid"] = $filelist[$i]["uploader"];			
			$data["data"][$teacher_count]["filename"] = $filelist[$i]["filename"];
			$data["data"][$teacher_count]["username"] = $uploaderinfo[0]["name"];
			$data["data"][$teacher_count]["time"] = $filelist[$i]["uploadtime"];
			$data["data"][$teacher_count]["fileid"] = $filelist[$i]["fileid"];
			$fileinfo = $this->datamodel->get_file_detail($filelist[$i]["fileid"]);
			$data["data"][$teacher_count]["filesize"] = $fileinfo[0]["filesize"];
			$data["data"][$teacher_count]["download"] = $filelist[$i]["download"];
            $data["data"][$teacher_count]["istop"] = $filelist[$i]["expiration"] >  date('Y-m-d H:i:s', time());
			++$teacher_count;
		}
		usort($data['data'], function($a, $b){
            if ($a["istop"] != $b["istop"])
                return $b["istop"] - $a["istop"];
			return $b['download'] - $a['download'];
		});
		
		$this->load->view("resource/filelist", $data);
	}
	
	/**
	*学生模块显示学生所传资源
	*@param 所选课程ID
	*@return null
	*/
	public function filelist_student($courseid) {
		//载入model
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_student_has_course($this->id, $courseid))
			show_404();
			
		//基本信息
		$userinfo = $this->adaptor->get_user_info($this->id);
		$data["role"] = $userinfo[0]["type"];
		$courseinfo = $this->adaptor->get_course_info($courseid);
		$data["year"] = $courseinfo[0]["year"];
		$data["term"] = $courseinfo[0]["term"];
		$data["course_name"] = $courseinfo[0]["name"];

		$data["userid"] = $this->id;
		$data["courseid"] = $courseid;
		//学生资源列表
		$student_count = 0;
		$data["data"] = [];
		$filelist = $this->datamodel->get_course_resource_list($courseid);
		for ($i = 0; $i < count($filelist); ++$i) {
			$uploaderinfo = $this->adaptor->get_user_info($filelist[$i]["uploader"]);
			if ($uploaderinfo[0]["type"] == 1) continue;
			
			$data["data"][$student_count]["uploaderid"] = $filelist[$i]["uploader"];			
			$data["data"][$student_count]["filename"] = $filelist[$i]["filename"];
			$data["data"][$student_count]["username"] = $uploaderinfo[0]["name"];
			$data["data"][$student_count]["time"] = $filelist[$i]["uploadtime"];
			$data["data"][$student_count]["fileid"] = $filelist[$i]["fileid"];
			$fileinfo = $this->datamodel->get_file_detail($filelist[$i]["fileid"]);
			$data["data"][$student_count]["filesize"] = $fileinfo[0]["filesize"];
			$data["data"][$student_count]["download"] = $filelist[$i]["download"];
            $data["data"][$teacher_count]["istop"] = $filelist[$i]["expiration"] >  date('Y-m-d H:i:s', time());
			++$student_count;			
		}
		usort($data['data'], function($a, $b){
            if ($a["istop"] != $b["istop"])
                return $b["istop"] - $a["istop"];
			return $b['download'] - $a['download'];
		});

		$this->load->view("resource/filelist", $data);
	}

	/**
	*学生模块显示作业
	*@param 所选课程ID
	*@return null
	*/
	public function homeworklist($courseid) {
		//载入model
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_student_has_course($this->id, $courseid))
			show_404();
			
		//基本信息
		$userinfo = $this->adaptor->get_user_info($this->id);
		$data["role"] = $userinfo[0]["type"];
		$courseinfo = $this->adaptor->get_course_info($courseid);
		$data["year"] = $courseinfo[0]["year"];
		$data["term"] = $courseinfo[0]["term"];
		$data["course_name"] = $courseinfo[0]["name"];
		$data["studentid"] = $this->id;
		$data["courseid"] = $courseid;
		//作业列表
		$hwlist = $this->datamodel->get_course_homework_list($courseid);
		$data["work"] = array();
		for ($i = 0; $i < count($hwlist); ++$i) {
			//作业基本信息
			$data["work"][$i]["name"] = $hwlist[$i]["name"];
			$data["work"][$i]["starttime"] = $hwlist[$i]["starttime"];
			$data["work"][$i]["endtime"] = $hwlist[$i]["endtime"];
			$data["work"][$i]["id"] = $hwlist[$i]["id"];
			$data["work"][$i]["toolate"] = ($hwlist[$i]["endtime"] < date('Y-m-d H:i:s', time()));
			$data["work"][$i]["related"] = [];
			//作业相关文件
			$hwfiles = $this->datamodel->get_homework_file($hwlist[$i]["id"]);
			for ($j = 0; $j < count($hwfiles); ++$j) {
				$data["work"][$i]["related"][$j]["filename"] = $hwfiles[$j]["filename"];
				$data["work"][$i]["related"][$j]["fileid"] = $hwfiles[$j]["fileid"];
				$data["work"][$i]["related"][$j]["homeworkid"] = $hwlist[$i]["id"];
			}
			//已上传的作业
			$myhw = $this->datamodel->get_homework_student($this->id, $hwlist[$i]["id"]);
			if (count($myhw) > 0) {
				$data["work"][$i]["score"] = $myhw[0]["score"];
				$data["work"][$i]["uploadtime"] = $myhw[0]["uploadtime"];
				$data["work"][$i]["uploadedfile"]["fileid"] = $myhw[0]["fileid"];
				$data["work"][$i]["uploadedfile"]["filename"] = $myhw[0]["filename"];
				$data["work"][$i]["uploadedfile"]["studentid"] = $myhw[0]["studentid"];
				$data["work"][$i]["uploadedfile"]["homeworkid"] = $myhw[0]["homeworkid"];
			} else {
				$data["work"][$i]["score"] = NULL;
				$data["work"][$i]["uploadtime"] = NULL;
				$data["work"][$i]["uploadedfile"]["fileid"] = NULL;
				$data["work"][$i]["uploadedfile"]["filename"] = NULL;
				$data["work"][$i]["uploadedfile"]["studentid"] = NULL;
				$data["work"][$i]["uploadedfile"]["homeworkid"] = NULL;
			}
		}
		
		usort($data["work"], function($a, $b){
			if ($a["toolate"] != $b["toolate"]) 
				return $a["toolate"] - $b["toolate"];
			if ((!is_null($a["uploadtime"]) || !is_null($a["score"])) != (!is_null($b["uploadtime"]) || !is_null($b["score"])))
				return (!is_null($a["uploadtime"]) || !is_null($a["score"])) == NULL ? -1: 1;
			return ($a["endtime"] < $b["endtime"])?-1: 1;
		});
		
		$this->load->view("resource/homeworklist", $data);
	}

	/**
	*学生模块显示作业详细信息
	*@param 作业ID
	*@return null
	*/
	public function workinfo($hwid) {
		//载入model
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_student_has_homework($this->id, $hwid))
			show_404();
			
		//基本信息
		$userinfo = $this->adaptor->get_user_info($this->id);
		$data["role"] = $userinfo[0]["type"];
		$hwinfo = $this->datamodel->get_homework_detail($hwid);
		$courseinfo = $this->adaptor->get_course_info($hwinfo[0]["courseid"]);
		$data["year"] = $courseinfo[0]["year"];
		$data["term"] = $courseinfo[0]["term"];
		$data["course_name"] = $courseinfo[0]["name"];
		$data["homeworkid"] = $hwid;
		$data["studentid"] = $this->id;
		
		$data["work"]["name"] = $hwinfo[0]["name"];
		$data["work"]["starttime"] = $hwinfo[0]["starttime"];
		$data["work"]["endtime"] = $hwinfo[0]["endtime"];
		$data["work"]["detail"] = $hwinfo[0]["detail"];
		$data["work"]["toolate"] = ($hwinfo[0]["endtime"] < date('Y-m-d H:i:s', time()));
		//作业相关文件
		$hwfiles = $this->datamodel->get_homework_file($hwid);
		for ($i = 0; $i < count($hwfiles); $i++) {
			$data["work"]["relavant"][$i][0] = $hwfiles[$i]["filename"];
			$data["work"]["relavant"][$i][1] = $hwfiles[$i]["fileid"];
		}
		if (count($hwfiles) == 0) $data["work"]["relavant"] = [];
		//已上传的文件
		$stuhwinfo = $this->datamodel->get_homework_student($this->id, $hwid);
		if (count($stuhwinfo) > 0) {
			$data["work"]["comment"] = $stuhwinfo[0]["comment"];
			$data["work"]["score"] = $stuhwinfo[0]["score"];
			$data["work"]["uploadedfile"]["fileid"] = $stuhwinfo[0]["fileid"];
			$data["work"]["uploadedfile"]["filename"] = $stuhwinfo[0]["filename"];
			$data["work"]["uploadtime"] = $stuhwinfo[0]["uploadtime"];
		} else {
			$data["work"]["comment"] = NULL;
			$data["work"]["score"] = NULL;
			$data["work"]["uploadedfile"]["fileid"] = NULL;
			$data["work"]["uploadedfile"]["filename"] = NULL;
			$data["work"]["uploadtime"] = NULL;
		} 

		$this->load->view("resource/workinfo", $data);
	}

	/**
	*学生模块搜索资源和作业
	*@param 学年 学期 搜索字符串
	*@return null
	*/
	public function search($year="", $term="", $string="")
	{
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		if($year == "")
			$year = $this->adaptor->get_current_year();
		if($term == "")
			$term = $this->adaptor->get_current_term();
		$userinfo = $this->adaptor->get_user_info($this->id)[0];
		$curyear = $this->adaptor->get_current_year();
		$data["years"] = [];
        $data["search_str"] = $string;
		for ($i = $userinfo["firstyear"]; $i <= $curyear; $i++)
		{
			array_push($data["years"], $i);
		}
		$data["year"] = $year;
		$data["term"] = $term;
		$data["role"] = $userinfo["type"];
		$courselist = $this->adaptor->get_course_list_by_year_and_term($this->id, $year, $term);
		$data["data"] = [];
		if($string != "")
		{
			$k = 0;
			for ($i = 0; $i < count($courselist); $i++)
			{
				$filelist = $this->datamodel->get_course_resource_list($courselist[$i]["courseid"]);
				for($j = 0; $j < count($filelist); $j++)
				{
					if(stripos($filelist[$j]["filename"], $string) !== FALSE)
					{
						$data["data"][$k]["name"] = $filelist[$j]["filename"];
						//$data["data"][$k]["link"] = site_url(($data["role"]?"teacher":"student")."/filelist_all/".$courselist[$i]["courseid"]);
						$data["data"][$k]["type"] = SEARCH_TYPE_FILE;
						$data["data"][$k]["course"] = $courselist[$i]["name"];
						$data["data"][$k]["courseid"] = $courselist[$i]["courseid"];
						$data["data"][$k++]["fileid"] = $filelist[$j]["fileid"];
					}
				}
				$hwlist = $this->datamodel->get_course_homework_list($courselist[$i]["courseid"]);
				for($j = 0; $j < count($hwlist); $j++)
				{
					if(stripos($hwlist[$j]["name"], $string) !== FALSE)
					{
						$data["data"][$k]["name"] = $hwlist[$j]["name"];
						//$data["data"][$k]["link"] = site_url(($data["role"]?"teacher":"student")."/filelist_all/".$courselist[$i]["courseid"]);
						$data["data"][$k]["type"] = SEARCH_TYPE_HOMEWORK;
						$data["data"][$k]["course"] = $courselist[$i]["name"];
						$data["data"][$k]["courseid"] = $courselist[$i]["courseid"];
						$data["data"][$k++]["homeworkid"] = $hwlist[$j]["id"];
					}
				}
			}
		}
		$this->load->view("resource/search", $data);
	}

	/**
	*学生模块上传资源
	*@param 课程ID
	*@return null
	*/
	public function uploadcoursefile($courseid) {
		$this->load->model("resource/datamodel");
		$this->load->model("resource/filemodel");
		//validation
		if (!$this->datamodel->is_student_has_course($this->id, $courseid)){
			$this->output->set_output("error");
			return;	
		}
		$fileid = $this->filemodel->upload_course_file($courseid, $this->id);
		$detail = $this->datamodel->get_course_file($courseid, $fileid);
		$this->output->set_output("success");
	}

	/**
	*学生模块上传作业
	*@param null
	*@return null
	*/
	public function uploadstudenthomework() {
		$homeworkid = $this->input->post("homeworkid");
		$this->load->model("resource/datamodel");
		
		//validation
		if (!$this->datamodel->is_student_has_homework($this->id, $homeworkid)){
			$this->output->set_output("error");
			return;	
		}
			
		$this->load->model("resource/filemodel");
		$fileid = $this->filemodel->upload_homework_student($this->id, $homeworkid);
		$detail = $this->datamodel->get_homework_student($this->id, $homeworkid);
		$this->output->set_output("success");
	}

	/**
	*学生模块下载资源
	*@param 文件ID 课程ID
	*@return null
	*/
	public function downloadcoursefile($fileid, $courseid) {
		$this->load->helper("download");
		$this->load->model("resource/datamodel");
		$this->load->model("resource/filemodel");
		//validation
		if (!$this->datamodel->is_student_has_course($this->id, $courseid))
			show_404();
			
		//得到fileinfo
		$fileinfo = $this->datamodel->get_course_file($courseid, $fileid);
		if (count($fileinfo) == 0)
			show_404();
		$filename = $fileinfo[0]["filename"];
		//下载数+1
		$this->datamodel->update_download_course_file($courseid, $fileid);
		//下载
		$actualpath = $this->filemodel->download_file($fileid, $filename);
		//$data = file_get_contents($actualpath);
		//force_download($filename, $data);
	}

	/**
	*学生模块下载作业相关文件
	*@param 文件ID 作业ID
	*@return null
	*/
	public function downloadhomeworkfile($fileid, $homeworkid) {
		$this->load->helper("download");
		$this->load->model("resource/datamodel");
		$this->load->model("resource/filemodel");
		//得到filename
		$fileinfo = $this->datamodel->get_homework_file($homeworkid);
		for ($i = 0; $i < count($fileinfo); ++$i)
			if ($fileinfo[$i]["fileid"] === $fileid) {
				$filename = $fileinfo[$i]["filename"];
				break;
			}
		if ($i == count($fileinfo))
			show_404();
		//下载
		$actualpath = $this->filemodel->download_file($fileid, $filename);
		//$data = file_get_contents($actualpath);
		//force_download($filename, $data);
	}

	/**
	*学生模块下载自己已上传过的作业
	*@param 学生ID 作业ID
	*@return null
	*/
	public function downloadstudenthomework($studentid, $homeworkid) {
		$this->load->helper("download");
		$this->load->model("resource/datamodel");
		$this->load->model("resource/filemodel");
		//validation
		if (!$this->datamodel->is_student_has_homework($this->id, $homeworkid))
			show_404();
		if ($this->id != $studentid)
			show_404();
			
		//得到fileid filename
		$hwinfo = $this->datamodel->get_homework_student($studentid, $homeworkid);
		$fileid = $hwinfo[0]["fileid"];
		$filename = $hwinfo[0]["filename"];
		//下载
		$actualpath = $this->filemodel->download_file($fileid, $filename);
		//$data = file_get_contents($actualpath);
		//force_download($filename, $data);
	}
	
	/**
	*学生模块删除学生上传的资源
	*@param 课程ID 文件ID
	*@return null
	*/
	public function deletecoursefile($courseid, $fileid) {
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_student_has_course($this->id, $courseid)){
			$this->output->set_output("error");
			return;	
		}
		$this->datamodel->delete_course_file($courseid, $fileid);
		$this->output->set_output("success");
	}
	
	/**
	*得到当前学生作业情况
	*@param null
	*@return {"undone": , "unknown": }
	*/
	public function gethomeworkstatus(){
		$this->load->model('resource/datamodel');
		$data["undone"] = count($this->datamodel->get_undone_homework($this->id));
		$data["unknown"] = count($this->datamodel->get_unknown_homework($this->id));
		$this->output->set_output(json_encode($data));
	}
	
	/**
	*学生查看自己所有未完成的作业
	*@param null
	*@return null
	*/
	public function alertundonelist()
	{
		//载入model
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		
		//取当前学年 学期
		$year = $this->adaptor->get_current_year();
		$term = $this->adaptor->get_current_term();

		$userinfo = $this->adaptor->get_user_info($this->id)[0];
		$curyear = $this->adaptor->get_current_year();
		//所有学年列表
		$data["years"] = [];
		for ($i = $userinfo["firstyear"]; $i <= $curyear; ++$i) {
			array_push($data["years"], $i);
		}
		//基本信息
		$data["year"] = $year;
		$data["term"] = $term;
		$data["role"] = $userinfo["type"];

		$data["work"] = $this->datamodel->get_undone_homework($this->id);
		for ($i = 0; $i != count($data["work"]); ++$i)
		{
			$homework = &$data["work"][$i];
			//得到课程名称
			$homework_detail = $this->datamodel->get_homework_detail($homework["homeworkid"])[0];
			$homework["coursename"] = $this->adaptor->get_course_info($homework_detail["courseid"])[0]["name"];
			
			//得到作业名称
			$homework["homeworkname"] = $homework_detail["name"];
			
			//得到课程id号
			$homework["courseid"] = $homework_detail["courseid"];
			
			//得到作业开始时间
			$homework["starttime"] = $homework_detail["starttime"];
			
			//得到作业结束时间
			$homework["endtime"] = $homework_detail["endtime"];
			
			//相关文件
			$hwfiles = $this->datamodel->get_homework_file($homework["homeworkid"]);
			$homework["relavant"] = array();
			for ($j = 0; $j < count($hwfiles); $j++) {
				$homework["relavant"][$j]["filename"] = $hwfiles[$j]["filename"];
				$homework["relavant"][$j]["fileid"] = $hwfiles[$j]["fileid"];
			}
		}
		usort($data["work"], function($a, $b){
			return $a["endtime"] < $b["endtime"] ? -1: 1;
		});
		$this->load->view("resource/alertlist", $data);
	}
	
	/**
	*学生查看自己所有未知的作业
	*@param null
	*@return null
	*/
	public function alertunknownlist()
	{
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		
		//取当前学年 学期
		$year = $this->adaptor->get_current_year();
		$term = $this->adaptor->get_current_term();

		$userinfo = $this->adaptor->get_user_info($this->id)[0];
		$curyear = $this->adaptor->get_current_year();
		//所有学年列表
		$data["years"] = [];
		for ($i = $userinfo["firstyear"]; $i <= $curyear; ++$i) {
			array_push($data["years"], $i);
		}
		//基本信息
		$data["year"] = $year;
		$data["term"] = $term;
		$data["role"] = $userinfo["type"];

		$data["work"] = $this->datamodel->get_unknown_homework($this->id);
		for ($i = 0; $i != count($data["work"]); ++$i)
		{
			$homework = &$data["work"][$i];
			//得到课程名称
			$homework_detail = $this->datamodel->get_homework_detail($homework["homeworkid"])[0];
			$homework["coursename"] = $this->adaptor->get_course_info($homework_detail["courseid"])[0]["name"];
			
			//得到作业名称
			$homework["homeworkname"] = $homework_detail["name"];
			
			//得到课程id号
			$homework["courseid"] = $homework_detail["courseid"];
			
			//得到作业开始时间
			$homework["starttime"] = $homework_detail["starttime"];
			
			//得到作业结束时间
			$homework["endtime"] = $homework_detail["endtime"];
			
			//相关文件
			$hwfiles = $this->datamodel->get_homework_file($homework["homeworkid"]);
			$homework["relavant"] = array();
			for ($j = 0; $j < count($hwfiles); $j++) {
				$homework["relavant"][$j]["filename"] = $hwfiles[$j]["filename"];
				$homework["relavant"][$j]["fileid"] = $hwfiles[$j]["fileid"];
			}
			$stuhwinfo = $this->datamodel->get_homework_student($this->id, $homework["homeworkid"]);
			$this->datamodel->update_homework_student($this->id, $homework["homeworkid"],
				 $stuhwinfo[0]["fileid"], $stuhwinfo[0]["filename"], $stuhwinfo[0]["uploadtime"], 
				 $stuhwinfo[0]["score"], $stuhwinfo[0]["comment"], true);
		}
		usort($data["work"], function($a, $b){
			return $a["endtime"] < $b["endtime"] ? -1: 1;
		});
		$this->load->view("resource/alertlist", $data);
	}
	
	public function test()
	{
		$this->load->helper('url');
		$this->load->view("resource/message_test");
	}
	
}
/* End of file student.php */
/* Location: ./application/controllers/student.php */
