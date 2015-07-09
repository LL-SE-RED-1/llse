<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Teacher controller model */
class Teacher extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	var $id = 50;

	/* construct function */
	function __construct()
	{
    	parent::__construct();
        $this->id = $this->session->userdata("uid");
        $type = $this->session->userdata("user_type");
        if ($type == 2)
            return;
        if ($type == 1)
            redirect("resource/student");
        else
            redirect("llse_welcome");
    }

	/********************* index page for teacher controller model **************************/
	///<summary>
	///fetch and show the list of involved courses
	///</summary>
	///<param name= $year> the selected year, default = current year </param>
	///<param name= $term> the selected term, default = current term </param>
	///<returns> pass the courselist data to view/index.php </returns>
	public function index($year = "", $term = "")
	{
        $data["search_str"] = "";
		$this->load->helper('url');
		$this->load->model('resource/adaptor');

		if($year == "")
			$year = $this->adaptor->get_current_year();
		if($term == "")
			$term = $this->adaptor->get_current_term();
		$userinfo = $this->adaptor->get_user_info($this->id)[0];
		$curyear = $this->adaptor->get_current_year();
		$data["years"] = [];
		for ($i = $userinfo["firstyear"]; $i <= $curyear; $i++)
		{
			array_push($data["years"], $i);
		}
		$data["year"] = $year;
		$data["term"] = $term;
		$courselist = $this->adaptor->get_course_list_by_year_and_term($this->id, $year, $term);
		$data["data"] = $courselist;
		$data["role"] = $userinfo["type"];
		$this->load->view('resource/index', $data);
	}
	
	/********************* list of all files for teacher controller model **************************/
	///<summary>
	///fetch and show the list of all files related to the selected course
	///</summary>
	///<param name= $courseid> id of the selected course </param>
	///<returns> pass the filelist data to view/filelist.php </returns>
	public function filelist_all($courseid)
	{
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_teacher_has_course($this->id, $courseid))
			show_404();
			
		$filelist = $this->datamodel->get_course_resource_list($courseid);
		$data["data"] = $filelist;
		for ($i = 0; $i < count($filelist); $i++)
		{
			$userid = $filelist[$i]["uploader"];
			$userinfo = $this->adaptor->get_user_info($userid);
			$data["data"][$i]["role"] = $userinfo[0]["type"];
			$data["data"][$i]["username"] = $userinfo[0]["name"];
			$data["data"][$i]["time"] = $filelist[$i]["uploadtime"];
			$fileid = $filelist[$i]["fileid"];
			$fileinfo = $this->datamodel->get_file_detail($fileid);
			$data["data"][$i]["filesize"] = $fileinfo[0]["filesize"];
			$data["data"][$i]["uploaderid"] = $filelist[0]["uploader"];
            $data["data"][$i]["istop"] = $filelist[$i]["expiration"] >  date('Y-m-d H:i:s', time());
		}
		usort($data['data'], function($a, $b){
            if ($a["istop"] != $b["istop"])
                return $b["istop"] - $a["istop"];
			return $b['download'] - $a['download'];
		});
		$userinfo = $this->adaptor->get_user_info($this->id);
		$data["role"] = $userinfo[0]["type"];
		$courseinfo = $this->adaptor->get_course_info($courseid);
		$data["year"] = $courseinfo[0]["year"];
		$data["term"] = $courseinfo[0]["term"];
		$data["course_name"] = $courseinfo[0]["name"];
		$data["courseid"] = $courseid;
		$this->load->view("resource/filelist", $data);
	}
	
	/********************* list of teacher resource files for teacher controller model **************************/
	///<summary>
	///fetch and show the list of all resource files(uploaded by teacher) related to the selected course
	///</summary>
	///<param name= $courseid> id of the selected course </param>
	///<returns> pass the filelist data to view/filelist.php </returns>
	public function filelist_teacher($courseid)
	{
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_teacher_has_course($this->id, $courseid))
			show_404();
			
		$filelist = $this->datamodel->get_course_resource_list($courseid);
		$teacnt = 0;
		$data["data"] = [];
		for($i = 0; $i < count($filelist); $i++)
		{
			$userid = $filelist[$i]["uploader"];
			$userinfo = $this->adaptor->get_user_info($userid);
			if($userinfo[0]["type"] == 0)
				continue;
			$data["data"][$teacnt] = $filelist[$i];
			$data["data"][$teacnt]["role"] = $userinfo[0]["type"];
			$data["data"][$teacnt]["username"] = $userinfo[0]["name"];
			$data["data"][$teacnt]["time"] = $filelist[$i]["uploadtime"];
			$fileid = $filelist[$i]["fileid"];
			$fileinfo = $this->datamodel->get_file_detail($fileid);
            $data["data"][$teacnt]["istop"] = $filelist[$i]["expiration"] >  date('Y-m-d H:i:s', time());
			$data["data"][$teacnt++]["filesize"] = $fileinfo[0]["filesize"];
		}
		usort($data['data'], function($a, $b){
            if ($a["istop"] != $b["istop"])
                return $b["istop"] - $a["istop"];
			return $b['download'] - $a['download'];
		});
		$userinfo = $this->adaptor->get_user_info($this->id);
		$data["role"] = $userinfo[0]["type"];
		$courseinfo = $this->adaptor->get_course_info($courseid);
		$data["year"] = $courseinfo[0]["year"];
		$data["term"] = $courseinfo[0]["term"];
		$data["course_name"] = $courseinfo[0]["name"];
		$data["courseid"] = $courseid;
		$this->load->view("resource/filelist", $data);
	}
	
	/********************* list of student resource files for teacher controller model **************************/
	///<summary>
	///fetch and show the list of all resource files(uploaded by student) related to the selected course
	///</summary>
	///<param name= $courseid> id of the selected course </param>
	///<returns> pass the filelist data to view/filelist.php </returns>
	public function filelist_student($courseid)
	{
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_teacher_has_course($this->id, $courseid))
			show_404();
			
		$filelist = $this->datamodel->get_course_resource_list($courseid);
		$stucnt = 0;
		$data["data"] = [];
		for($i = 0; $i < count($filelist); $i++)
		{
			$userid = $filelist[$i]["uploader"];
			$userinfo = $this->adaptor->get_user_info($userid);
			if($userinfo[0]["type"] == 1)
				continue;
			$data["data"][$stucnt] = $filelist[$i];
			$data["data"][$stucnt]["role"] = $userinfo[0]["type"];
			$data["data"][$stucnt]["username"] = $userinfo[0]["name"];
			$data["data"][$stucnt]["time"] = $filelist[$i]["uploadtime"];
			$fileid = $filelist[$i]["fileid"];
			$fileinfo = $this->datamodel->get_file_detail($fileid);
            $data["data"][$stucnt]["istop"] = $filelist[$i]["expiration"] >  date('Y-m-d H:i:s', time());
			$data["data"][$stucnt++]["filesize"] = $fileinfo[0]["filesize"];
		}
		usort($data['data'], function($a, $b){
            if ($a["istop"] != $b["istop"])
                return $b["istop"] - $a["istop"];
			return $b['download'] - $a['download'];
		});
		$userinfo = $this->adaptor->get_user_info($this->id);
		$data["role"] = $userinfo[0]["type"];
		$courseinfo = $this->adaptor->get_course_info($courseid);
		$data["year"] = $courseinfo[0]["year"];
		$data["term"] = $courseinfo[0]["term"];
		$data["course_name"] = $courseinfo[0]["name"];
		$data["courseid"] = $courseid;
		$this->load->view("resource/filelist", $data);
	}
	
	/********************* delete a certain course resource for teacher controller model **************************/
	///<summary>
	///delete a selected resource file of the selected course
	///</summary>
	///<param name= $courseid> id of the selected course </param>
	///<param name= $fileid> id of the selected file </param>
	///<returns> return the result(success/fail) to the front end </returns>
	public function deletecoursefile($courseid, $fileid)
	{
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_teacher_has_course($this->id, $courseid)){
			$this->output->set_output("error");
			return;	
		}
			
		$this->datamodel->delete_course_file($courseid, $fileid);
		$this->output->set_output("success");
	}
	
	/********************* list of homework for teacher controller model **************************/
	///<summary>
	///fetch and show the list of all homework related to the selected course
	///</summary>
	///<param name= $courseid> id of the selected course </param>
	///<returns> pass the homeworklist data to view/thomeworklist.php </returns>
	public function homeworklist($courseid)
	{
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		$this->load->model('resource/filemodel');
		//validation
		if (!$this->datamodel->is_teacher_has_course($this->id, $courseid))
			show_404();
			
		$hwlist = $this->datamodel->get_course_homework_list($courseid);
		$data["work"] = [];
		for ($i = 0; $i < count($hwlist); $i++)
		{
			$data["work"][$i]["name"] = $hwlist[$i]["name"];
			$data["work"][$i]["starttime"] = $hwlist[$i]["starttime"];
			$data["work"][$i]["endtime"] = $hwlist[$i]["endtime"];
			$data["work"][$i]["id"] = $hwlist[$i]["id"];
			$hwfiles = $this->datamodel->get_homework_file($hwlist[$i]["id"]);
			$data["work"][$i]["related"] = [];
			for ($j = 0; $j < count($hwfiles); $j++)
			{
				$data["work"][$i]["related"][$j]["filename"] = $hwfiles[$j]["filename"];
				$data["work"][$i]["related"][$j]["fileid"] = $hwfiles[$j]["fileid"];
			}
			$data["work"][$i]["toolate"] = ($hwlist[$i]["endtime"] < date('Y-m-d H:i:s'))?1:0;
		}
		usort($data["work"], function($a, $b){
			if ($a["toolate"] != $b["toolate"]) 
				return $a["toolate"] - $b["toolate"];
			return ($a["endtime"] < $b["endtime"])?-1: 1;
		});
		
		$userinfo = $this->adaptor->get_user_info($this->id);
		$data["role"] = $userinfo[0]["type"];
		$courseinfo = $this->adaptor->get_course_info($courseid);
		$data["year"] = $courseinfo[0]["year"];
		$data["term"] = $courseinfo[0]["term"];
		$data["course_name"] = $courseinfo[0]["name"];
		$data["courseid"] = $courseid;
		$this->load->view("resource/thomeworklist", $data);
	}
	
	/********************* add homework for teacher controller model **************************/
	///<summary>
	///add a piece of homework for the selected course
	///</summary>
	///<param name= $courseid> id of the selected course </param>
	///<returns> pass the course data to view/addhomework.php </returns>
	public function addhomework($courseid)
	{
		$this->load->helper('url');
		$this->load->model('resource/datamodel');
		$this->load->model('resource/adaptor');
		//validation
		if (!$this->datamodel->is_teacher_has_course($this->id, $courseid))
			show_404();
			
		$userinfo = $this->adaptor->get_user_info($this->id);
		$data["data"] = "";
		$courseinfo = $this->adaptor->get_course_info($courseid);
		$data["year"] = $courseinfo[0]["year"];
		$data["term"] = $courseinfo[0]["term"];
		$data["course_name"] = $courseinfo[0]["name"];
		$data["role"] = $userinfo[0]["type"];
		$data["courseid"] = $courseid;
		$this->load->view("resource/addhomework", $data);
	}
	
	/********************* adding homework for teacher controller model **************************/
	///<summary>
	///fetch the data of the homework being added from front end via AJAX and save into database via datamodel
	///</summary>
	///<param name= $courseid> id of the selected course </param>
	///<returns> return the result(success/fail) to the front end </returns>
	public function addinghomework($courseid)
	{
		$this->load->model('resource/datamodel');
		$this->load->model('resource/adaptor');
		//validation
		if (!$this->datamodel->is_teacher_has_course($this->id, $courseid)){
			$this->output->set_output("error");
			return;	
		}
			
		$fileids = $this->input->post("fileid")?$this->input->post("fileid"):array();
		$filenames = $this->input->post("filename");
		$name = $this->input->post("name");
		$starttime = $this->input->post("starttime");
		$endtime = $this->input->post("endtime");
		$detail = $this->input->post("detail");
		$homeworkid = $this->datamodel->add_homework($courseid, $name, $starttime, $endtime, $detail);
		for ($i = 0; $i < count($fileids); $i++)
		{
			$this->datamodel->add_homework_file($homeworkid, $fileids[$i], $filenames[$i]);
		}
		
		$students = $this->adaptor->get_student_list($courseid);
		for ($i = 0; $i < count($students); $i++)
		{
			$this->datamodel->add_homework_student($students[$i]["studentid"], $homeworkid, NULL, NULL, NULL, NULL, NULL);
		}
		$this->output->set_output("success");
	}
	
	/********************* change homework for teacher controller model **************************/
	///<summary>
	///change the detail of a certain piece of homework for the selected course
	///</summary>
	///<param name= $hwid> id of the selected homework </param>
	///<returns> pass the homework data to view/changehomework.php </returns>
	public function changehomework($hwid)
	{
		$this->load->helper('url');
		$this->load->model('resource/datamodel');
		$this->load->model('resource/adaptor');
		//validation
		if (!$this->datamodel->is_teacher_has_homework($this->id, $hwid))
			show_404();
			
		$userinfo = $this->adaptor->get_user_info($this->id);
		$data["data"] = "";
		$hwinfo = $this->datamodel->get_homework_detail($hwid);
		$courseinfo = $this->adaptor->get_course_info($hwinfo[0]["courseid"]);
		$data["year"] = $courseinfo[0]["year"];
		$data["term"] = $courseinfo[0]["term"];
		$data["course_name"] = $courseinfo[0]["name"];
		$data["role"] = $userinfo[0]["type"];
		$data["homeworkid"] = $hwid;
		$data["name"] = $hwinfo[0]["name"];
		$data["starttime"] = $hwinfo[0]["starttime"];
		$data["endtime"] = $hwinfo[0]["endtime"];
		$data["detail"] = $hwinfo[0]["detail"];
		$data["courseid"] = $hwinfo[0]["courseid"];
		$hwfiles = $this->datamodel->get_homework_file($hwid);
		$data["related"] = [];
		for ($i = 0; $i < count($hwfiles); $i++)
		{
			$data["related"][$i]["filename"] = $hwfiles[$i]["filename"];
			$data["related"][$i]["fileid"] = $hwfiles[$i]["fileid"];
		}
		$this->load->view("resource/changehomework", $data);
	}
	
	/********************* changing homework for teacher controller model **************************/
	///<summary>
	///fetch the data of the homework being changed from front end via AJAX and save into database via datamodel
	///</summary>
	///<param name= $hwid> id of the selected homework </param>
	///<returns> return the result(success/fail) to the front end </returns>
	public function changinghomework($hwid)
	{
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_teacher_has_homework($this->id, $hwid)){
			$this->output->set_output("error");
			return;	
		}
			
		$fileids = $this->input->post("fileid")?$this->input->post("fileid"):array();
		$filenames = $this->input->post("filename");
		$name = $this->input->post("name");
		$starttime = $this->input->post("starttime");
		$endtime = $this->input->post("endtime");
		$detail = $this->input->post("detail");
		$hwinfo = $this->datamodel->get_homework_detail($hwid);
		$homeworkid = $this->datamodel->update_homework($hwinfo[0]["id"], $hwinfo[0]["courseid"], $name, $starttime, $endtime, $detail);
		for ($i = 0; $i < count($fileids); $i++)
		{
			$this->datamodel->add_homework_file($homeworkid, $fileids[$i], $filenames[$i]);
		}
		$this->output->set_output("success");
	}
	
	/********************* delete homework for teacher controller model **************************/
	///<summary>
	///delete a certain piece of homework for the selected course
	///</summary>
	///<param name= $hwid> id of the selected homework </param>
	public function deletehomework($hwid)
	{
		$this->load->helper('url');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_teacher_has_homework($this->id, $hwid)){
			$this->output->set_output("error");
			return;	
		}
			
		$courseid = $this->datamodel->get_homework_detail($hwid)[0]["courseid"];
		$this->datamodel->delete_homework($hwid);
	}
	
	/********************* delete homework file for teacher controller model **************************/
	///<summary>
	///delete a related file of a certain piece of homework for the selected course
	///</summary>
	///<param name= $fileid> id of the file to be deleted </param>
	///<param name= $hwid> id of the selected homework </param>
	///<returns> return the result(success/fail) to the front end </returns>
	public function deletehomeworkfile($fileid, $hwid)
	{
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_teacher_has_homework($this->id, $hwid)){
			$this->output->set_output("error");
			return;	
		}
			
		$this->datamodel->delete_homework_file($hwid, $fileid);
		$this->output->set_output("success");
	}
	
	/********************* studentlist for teacher controller model **************************/
	///<summary>
	///fetch and show the list of all students related to the selected homework(of the corresponding course)
	///</summary>
	///<param name= $hwid> id of the selected homework </param>
	///<returns> pass the studentlist data to view/studentlist.php </returns>
	public function studentlist($hwid)
	{
		$this->load->helper("url");
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_teacher_has_homework($this->id, $hwid))
			show_404();
			
		$hwinfo = $this->datamodel->get_homework_detail($hwid);
		$courseid = $hwinfo[0]["courseid"];
		$userinfo = $this->adaptor->get_user_info($this->id);
		$data["role"] = $userinfo[0]["type"];
		$courseinfo = $this->adaptor->get_course_info($courseid);
		$data["year"] = $courseinfo[0]["year"];
		$data["term"] = $courseinfo[0]["term"];
		$data["course_name"] = $courseinfo[0]["name"];
		$data["courseid"] = $courseid;
		$stulist = $this->adaptor->get_student_list($courseid);
        $data["data"] = array();
		for ($i = 0; $i < count($stulist); $i++)
		{
			$data["data"][$i]["stuid"] = $stulist[$i]["studentid"];
			$data["data"][$i]["hwid"] = $hwid;
			$stuhwinfo = $this->datamodel->get_homework_student($stulist[$i]["studentid"], $hwid);
			$stuhwinfo = $stuhwinfo?$stuhwinfo:array();
			$stuinfo = $this->adaptor->get_user_info($stulist[$i]["studentid"]);
			$data["data"][$i]["name"] = $stuinfo[0]["name"];
			var_dump($data["data"][$i]["number"] = $stuinfo[0]["number"]);
			$data["data"][$i]["score"] = ($stuhwinfo[0]["score"] == NULL)?"0":$stuhwinfo[0]["score"];
			if ($stuhwinfo[0]["score"] != NULL)
				$data["data"][$i]["status"] = STATUS_SCORED;
			else if ($stuhwinfo[0]["fileid"] == NULL)
				$data["data"][$i]["status"] = STATUS_UNDONE;
			else	
				$data["data"][$i]["status"] = STATUS_UNSCORED;
		}
		$this->load->view("resource/studentlist", $data);
	}
	
	/********************* workinfo for teacher controller model **************************/
	///<summary>
	///fetch and show the homework details of the selected student and the selected homework
	///</summary>
	///<param name= $stuid> id of the selected student </param>
	///<param name= $hwid> id of the selected homework </param>
	///<returns> pass the studentlist data to view/tworkinfo.php </returns>
	public function workinfo($stuid, $hwid)
	{
		$this->load->helper('url');
		$this->load->model('resource/adaptor');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_teacher_has_homework($this->id, $hwid))
			show_404();
		if (!$this->datamodel->is_student_has_homework($stuid, $hwid))
			show_404();
			
		$userinfo = $this->adaptor->get_user_info($stuid);
		$hwinfo = $this->datamodel->get_homework_detail($hwid);
		$courseinfo = $this->adaptor->get_course_info($hwinfo[0]["courseid"]);
		$stuhwinfo = $this->datamodel->get_homework_student($stuid, $hwid);
		$data["role"] = $this->adaptor->get_user_info($this->id)[0]["type"];
		$data["year"] = $courseinfo[0]["year"];
		$data["term"] = $courseinfo[0]["term"];
		$data["course_name"] = $courseinfo[0]["name"];
		$data["work"]["name"] = $hwinfo[0]["name"];
		$data["work"]["stuname"] = $userinfo[0]["name"];
		$data["work"]["starttime"] = $hwinfo[0]["starttime"];
		$data["work"]["endtime"] = $hwinfo[0]["endtime"];
		$data["work"]["detail"] = $hwinfo[0]["detail"];
		$data["work"]["toolate"] = ($hwinfo[0]["endtime"] < date('Y-m-d H:i:s'))?1:0;
		if($stuhwinfo != NULL)
		{
			$data["work"]["comment"] = $stuhwinfo[0]["comment"];
			$data["work"]["score"] =  $stuhwinfo[0]["score"];
			$data["work"]["upload"]["time"] =  $stuhwinfo[0]["uploadtime"];
			$data["work"]["upload"]["file"] = $stuhwinfo[0]["filename"];
			//$data["work"]["upload"]["file"] = [$stuhwinfo[0]["filename"], "/file/SE01.ppt"];
		}
		else
		{
			$data["work"]["comment"] = NULL;
			$data["work"]["score"] = NULL;
			$data["work"]["upload"]["time"] = "未上传";
			$data["work"]["upload"]["file"] = NULL;
		}
		$data["homeworkid"] = $hwid;
		$data["studentid"] = $stuid;
		$hwfiles = $this->datamodel->get_homework_file($hwid);
		$data["work"]["related"] = [];
		for ($i = 0; $i < count($hwfiles); $i++)
		{
			$data["work"]["related"][$i][0] = $hwfiles[$i]["filename"];
			//download
			$data["work"]["related"][$i][1] = $hwfiles[$i]["fileid"];
		}
		$this->load->view("resource/tworkinfo", $data);
	}
	
	/********************* addingscore for teacher controller model **************************/
	///<summary>
	///add grading and commemt for a certain piece of submitted homework of a certain student
	///</summary>
	///<param name= $stuid> id of the selected student </param>
	///<param name= $hwid> id of the selected homework </param>
	///<returns>  return the result(success/fail) to the front end </returns>
	public function addingscore($stuid, $hwid)
	{
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_teacher_has_homework($this->id, $hwid)){
			$this->output->set_output("error");
			return;
		}
		if (!$this->datamodel->is_student_has_homework($stuid, $hwid)){
			$this->output->set_output("error");
			return;
		}
		
		$comment = $this->input->post("comment");
		$score = $this->input->post("score");
		$hwid = $this->input->post("homeworkid");
		$stuid = $this->input->post("studentid");
		$stuhwinfo = $this->datamodel->get_homework_student($stuid, $hwid);
		$res = $this->datamodel->update_homework_student($stuid, $hwid, $stuhwinfo[0]["fileid"], $stuhwinfo[0]["filename"], $stuhwinfo[0]["uploadtime"], $score, $comment, $stuhwinfo[0]["known"]);
		$this->output->set_output("success");
	}
	
	/********************* searching for teacher controller model **************************/
	///<summary>
	///search for resources with names containing a certain string(within the selected year and term)
	///</summary>
	///<param name= $year> the selected year, default = current year </param>
	///<param name= $term> the selected term, default = current term </param>
	///<param name= $string> key word string for searching </param>
	///<returns>  pass the searching result to view/search.php </returns>
	public function search($year="", $term="", $string="")
	{
		$string = urldecode($string);
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
	/********************* setting top for teacher controller model **************************/
	///<summary>
	///set the file to the top of the filelist of the course
	///</summary>
	///<param name= $courseid> id of the course</param>
	///<param name= $fileid> id of the file</param>
	///<returns> true </returns>
    public function settop($courseid, $fileid){
        $this->load->helper("url");
        $this->load->model("resource/datamodel");
        $this->datamodel->set_top_course_file($courseid, $fileid);
       
		if (!$this->datamodel->is_teacher_has_course($this->id, $courseid))
            show_404();
        
        redirect("teacher/filelist_all/$courseid");
    }
    
    /********************* canceling set top for teacher controller model **************************/
	///<summary>
	///set the file to the top of the filelist of the course
	///</summary>
	///<param name= $courseid> id of the course</param>
	///<param name= $fileid> id of the file</param>
	///<returns> true </returns>
    public function canceltop($courseid, $fileid){
        $this->load->helper("url");
        $this->load->model("resource/datamodel");
        $this->datamodel->cancel_top_course_file($courseid, $fileid);
       
		if (!$this->datamodel->is_teacher_has_course($this->id, $courseid))
            show_404();
        
        redirect("teacher/filelist_all/$courseid");
    }

	public function uploadcoursefile($courseid){
		$this->load->model("resource/datamodel");
		$this->load->model("resource/filemodel");
		//validation
		if (!$this->datamodel->is_teacher_has_course($this->id, $courseid)){
			$this->output->set_output("error");
			return;	
		}
			
		$fileid = $this->filemodel->upload_course_file($courseid, $this->id);
		$detail = $this->datamodel->get_course_file($courseid, $fileid);
		$this->output->set_output("success");
	}
	
	public function uploadhomeworkfile(){
		$homeworkid = $this->input->post("homeworkid");
		$this->load->model("resource/datamodel");
		$this->load->model("resource/filemodel");
		//validation
		if (!$this->datamodel->is_teacher_has_homework($this->id, $homeworkid)){
			$this->output->set_output("error");
			return;	
		}
			
		$fileid = $this->filemodel->upload_homework_file($homeworkid);
		$detail = $this->datamodel->get_homework_file($homeworkid);
		$this->output->set_output("success");
	}
	
	public function uploadfile(){
		$this->load->model("resource/filemodel");
		$this->load->model("resource/datamodel");
		$fileid = $this->filemodel->upload_file("file");
		$detail = $this->datamodel->get_file_detail($fileid);
		$this->output->set_output("success");
	}
	
	public function downloadcoursefile($fileid, $courseid)
	{
		$this->load->model('resource/filemodel');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_teacher_has_course($this->id, $courseid))
			show_404();
			
		$fileinfo = $this->datamodel->get_course_file($courseid, $fileid);
		if (count($fileinfo) == 0)
			show_404();
			
		$downloadinfo = $this->datamodel->get_course_file($courseid, $fileid);
		$this->datamodel->update_download_course_file($courseid, $fileid);
		$this->filemodel->download_file($fileid, $fileinfo[0]["filename"]);
		$this->output->set_output("success");
	}
	
	public function downloadhomeworkfile($fileid, $hwid)
	{
		$this->load->model('resource/filemodel');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_teacher_has_course($this->id, $hwid))
			show_404();
		
		//得到filename
		$fileinfo = $this->datamodel->get_homework_file($hwid);
		for ($i = 0; $i < count($fileinfo); ++$i)
			if ($fileinfo[$i]["fileid"] === $fileid) {
				$filename = $fileinfo[$i]["filename"];
				break;
			}
		if ($i == count($fileinfo))
			show_404();
		$this->filemodel->download_file($fileid, $fileinfo[0]["filename"]);
	}
	
	public function downloadstudenthomework($stuid, $hwid)
	{
		$this->load->model('resource/filemodel');
		$this->load->model('resource/datamodel');
		//validation
		if (!$this->datamodel->is_student_has_homework($stuid, $homeworkid))
			show_404();
		if (!$this->datamodel->is_teacher_has_homework($this->id, $homeworkid))
			show_404();
			
		$stuhwinfo = $this->datamodel->get_homework_student($stuid, $hwid);
		$this->filemodel->download_file($stuhwinfo[0]["fileid"], $stuhwinfo[0]["filename"]);
	}

    public function test(){
        $this->load->model("resource/adaptor");
        var_dump($this->adaptor->get_course_list_by_year_and_term(3120100001));
    }
}

/* End of file teacher.php */
/* Location: ./application/controllers/teacher.php */	
