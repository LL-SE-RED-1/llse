<?php
/************************************************
****Author: sunliver
****Date: 2015-06-15
****DataModel: directly get infomation from database
************************************************/
/* DataModel class */
class DataModel extends CI_Model
{
	/* construct function */
	function __construct()
	{
    	parent::__construct();
		$this->resource = $this->load->database('resource', true);
  	}

	/* opeartion of database resource*/

	/*********************operation for table course_file **************************/
	///<summary>
	///get course_resource from course_file
	///</summary>
	///<param name= $courseid> the course which you want search for </param>
	///<returns> return a list contains the info of specific course </returns>
	function get_course_resource_list($courseid)
	{
		//SELECT * FROM course_file WHERE courseid = $courseid
		return $this->resource->from("course_file")->where("courseid", $courseid)->get()->result_array();
	}

	///<summary>
	///delete specific course_resource from course_file
	///</summary>
	///<param name= $courseid> the course which you want search for </param>
	///<param name= $fileid> the file which you want search for </param>
	///<returns> return true if delete success </returns>
	function delete_course_file($courseid, $fileid)
	{
		//DELETE FROM course_file WHERE courseid = $courseid AND fileid = $fileid
		$this->resource->delete("course_file", array("courseid"=>$courseid, "fileid"=>$fileid));
		return true;
	}
	
	///<summary>
	///get specific course_resource from course_file by courseid and fileid
	///</summary>
	///<param name= $courseid> the course which you want search for </param>
	///<param name= $fileid> the file which you want search for </param>
	///<returns> return the specific coursefile info  </returns>
	function get_course_file($courseid, $fileid)
	{	
		//database query & return
		return $this->resource->where(array("courseid"=>$courseid, "fileid"=>$fileid))->get("course_file")->result_array();
		//SELECT * FROM course_file WHERE courseid = $courseid AND fileid = $fileid
	}

	///<summary>
	///add specific course_resource to course_file
	///</summary>
	///<param name= $courseid> courseid </param>
	///<param name= $fileid>  fileid  </param>
	///<param name= $uploader> uploader </param>
	///<param name= $uploadertime> uploadertime </param>
	///<param name= $filename>  filename </param>
	///<returns> return the specific coursefile info  </returns>
	function add_course_file($courseid, $fileid, $uploader, $uploadtime, $filename)
	{	
		//INSERT INTO course_file VALUES( $courseid, $fileid, 0, uploader, uploadtime, filename)
		$this->resource->insert("course_file", 
			array(
				"courseid" => $courseid,
				"fileid" => $fileid,
				"download" => 0,
				"uploader" => $uploader,
				"uploadtime" => $uploadtime,
				"filename" => $filename
			));	
		//return the primary key of the insert query
		return $this->resource->insert_id();
	}
    
    ///<summary>
	///cancel top of a file in the filelist
	///</summary>
	///<param name= $courseid> courseid </param>
	///<param name= $fileid>  fileid  </param>
    ///<returns> return true</returns>
    function cancel_top_course_file($courseid, $fileid)
    {
        $query = $this->resource->where(array("courseid"=>$courseid, "fileid"=>$fileid))->update("course_file", array("expiration" => NULL));
        return true;
    }

	///<summary>
	///add top of a file in the filelist
	///</summary>
	///<param name= $courseid> courseid </param>
	///<param name= $fileid>  fileid  </param>
    ///<returns> return true</returns>
    function set_top_course_file($courseid, $fileid)
    {
        $query = $this->resource->where(array("courseid"=>$courseid, "fileid"=>$fileid))->update("course_file", array("expiration" => (new DateTime('today + 7days'))->format('y-m-d h:i:s')));
        return true;
    }
      
	///<summary>
	///update specific course_resource(uploader , uploadetime, filename) from course_file by courseid and fileid
	///</summary>
	///<param name= $courseid> the course which you want search for </param>
	///<param name= $fileid> the file which you want search for </param>
	///<param name= $uploader> the new/old uploader </param>
	///<param name= $uploadertime> the new/old uploadertime </param>
	///<param name= $filename> the new/old filename </param>
	///<returns> return true if update success  </returns>	
	function update_course_file($courseid, $fileid, $uploader, $uploadtime, $filename)
	{
		//UPDATE course_file SET uploader = $uploader, uploadtime = $uploadtime, filename = $filename WHERE courseid = $courseid AND fileid = $fileid
		$this->resource->where(array("courseid" => $courseid, "fileid"=>$fileid))->update("course_file", 
			array("uploader" => $uploader, "uploadtime"=>$uploadtime, "filename"=>$filename));

		return true;
	}

	///<summary>
	///update download by courseid and fileid
	///</summary>
	///<param name= $courseid> courseid </param>
	///<param name= $fileid> fileid </param>
	///<returns> return true if update success </returns>
	function update_download_course_file($courseid, $fileid)
	{
		//get pre download time
		//SELECT download FROM course_file WHERE courseid = $courseid AND fileid = $fileid
		$download = $this->resource->where(array("courseid" => $courseid, "fileid"=>$fileid))->from("course_file")->select("download")->get()->row()->download;
		
		//UPDATE course_file SET download = $download + 1 WHERE courseid = $courseid AND fileid = $fileid
		$this->resource->where(array("courseid" => $courseid, "fileid"=>$fileid))->update("course_file", 
				array("download" => $download+1));	

		//return 
		return true;
	}

	/**********************operation for table homeworks **************************/
	///<summary>
	/// get course_homework info by courseid
	///</summary>
	///<param name= $courseid> courseid </param>
	///<returns> return homework list </returns>
	function get_course_homework_list($courseid)
	{
		//SELECT * FROM homeworks WHERE courseid = $couseid
		return $this->resource->from("homeworks")->where("courseid", $courseid)->get()->result_array();	
	}
	
	///<summary>
	/// add course_homework info
	///</summary>
	///<param name= $courseid> courseid </param>
	///<param name= $name> name </param>
	///<param name= $starttime> starttime </param>
	///<param name= $endtime> endtime </param>
	///<param name= $detail> homework detail </param>
	///<returns> return primary key if  insert success </returns>
	function add_homework($courseid, $name, $starttime, $endtime, $detail)
	{
		//INSERT INTO homeworks VALUES(null, $courseid, $name, $starttime, $endtime, $detail)
		$this->resource->insert( 'homeworks', 
			array(
			'id' => null,
			'courseid' => $courseid,
			'name' => $name,
			'starttime' => $starttime,
			'endtime' => $endtime,
			'detail' => $detail
		));
		//return $courseid
		return $this->resource->insert_id();
	}

	///<summary>
	/// get homework detail from homework by homeworkid
	///</summary>
	///<param name= $homeworkid> homeworkid </param>
	///<returns> return homework_detail array </returns>	
	function get_homework_detail($homeworkid)
	{
		//SELECT * FROM homeworks WHERE id = $homeworkid
		return $this->resource->from("homeworks")->where("id", $homeworkid)->get()->result_array();
	}

	///<summary>
	/// update course_homework info
	///</summary>
	///<param name= $id> homeworkid </param>	
	///<param name= $courseid> courseid </param>
	///<param name= $name> the new/old name </param>
	///<param name= $starttime> the new/old starttime </param>
	///<param name= $endtime> the new/old endtime </param>
	///<param name= $detail> the new/old homework detail </param>
	///<returns> return true if  update success </returns>	
	function update_homework($id, $courseid, $name, $starttime, $endtime, $detail)
	{
		//UPDATE homeworks SET courseid = $courseid, name = $name, starttime = $starttime, endtime = $endtime, detail = $detail WHERE id = $id
		$query = $this->resource->where("id", $id)->update( "homeworks", 
			array(	"courseid"=>$courseid, 
					"name" => $name, 
					"starttime" => $starttime, 
					"endtime" => $endtime, 
					"detail" => $detail));
		//return 
		return true;
	}
	
	///<summary>
	/// delete homework from homework by homeworkid
	///</summary>
	///<param name= $homeworkid> homeworkid </param>
	///<returns> if delete success return true</returns>
	function delete_homework($homeworkid)
	{
		//DELETE FROM homeworks WHERE id = $homeworkid
		$this->resource->delete("homeworks", array("id"=>$homeworkid) );
		return true;
	}


	/*********************operation for table student_homework **************************/
	///<summary>
	/// get info from student_homework by homeworkid and studentid
	///</summary>
	///<param name= $studentid> studentid </param>
	///<param name= $homeworkid> homeworkid </param>
	///<returns> return the info , if null, return array() </returns>
	function get_homework_student($studentid, $homeworkid)
	{
		//SELECT * FROM student_homework WHERE studentid = $studentid AND homeworkid = $homeworkid
		return $this->resource->from("student_homework")->where(array("homeworkid"=>$homeworkid, "studentid"=> $studentid))->get()->result_array();
	}
	
	///<summary>
	///insert into student_homework 
	///</summary>
	///<param name= $studentid> studentid </param>
	///<param name= $homeworkid> homeworkid </param>
	///<param name= $fileid> fileid </param>
	///<param name= $filename> filename </param>
	///<param name= $uploadtime> uploadtime </param>
	///<param name= $score> score </param>
	///<param name= $comment> comment </param>
	///<returns> return  the primary key if insert success </returns>	
	function add_homework_student($studentid, $homeworkid, $fileid, $filename, $uploadtime, $score, $comment)
	{
		//ISERT INTO student_homework VALUES($studentid, $homeworkid, $uploadtime, $score, $fileid, $filename, $comment)
		$this->resource->insert('student_homework', 
			array(
				'studentid' => $studentid,
				'homeworkid' => $homeworkid,
				'uploadtime' => $uploadtime,
				'score' => $score,
				'fileid' => $fileid,
				'filename' => $filename,
				'comment' => $comment
			));
		//return
		return $this->resource->insert_id();
	}
	
	///<summary>
	///update student_homework 
	///</summary>
	///<param name= $studentid> studentid </param>
	///<param name= $homeworkid> homeworkid </param>
	///<param name= $fileid> new/old fileid </param>
	///<param name= $filename> new/old filename </param>
	///<param name= $uploadtime> new/old uploadtime </param>
	///<param name= $score> new/old score </param>
	///<param name= $comment> new/old comment </param>
	///<returns> return true if update success </returns>	
	function update_homework_student($studentid, $homeworkid, $fileid, $filename, $uploadtime, $score, $comment, $known = 0)
	{
		//UPDATE student_homework SET uploadtime = $uploadtime, score = $score, comment = $comment, fileid = $fileid, filename = $filename WHERE homeworkid = $homeworkid, studentid = $studentid
		$this->resource->where(array('homeworkid'=>$homeworkid, 'studentid' => $studentid))->update('student_homework', 
			array(
				"uploadtime" => $uploadtime,
				"score" => $score,
				"comment" => $comment,
				"fileid" => $fileid,
				"filename" => $filename,
				"known" => $known
			));
		//return
		return true;
	}
	

	/*********************operation for table files **************************/
	///<summary>
	///add file detail in files
	///</summary>
	///<param name= $actualname> actualname </param>
	///<param name= $filesize> filesize </param>
	///<returns> return the primary key if insert success </returns>	
	function add_file_detail($actualname, $filesize)
	{
		//INSERT INTO files VALUES(null, $actualname, $filesize)
		$this->resource->insert('files', 
			array(
				"id" => null, 
				"actualname" => $actualname,
				"filesize" => $filesize
			));
		//return
		return $this->resource->insert_id();
	}

	///<summary>
	///get file detail from files
	///</summary>
	///<param name= $fileid> fileid </param>
	///<returns> return array() if null or the detail </returns>		
	function get_file_detail($fileid)
	{
		//SELECT * FROM files WHERE id = $fileid
		return $this->resource->from("files")->where("id", $fileid)->get()->result_array();
	}
	
	///<summary>
	///get fileid by name and size
	///</summary>
	///<param name= $actualname> actualname </param>
	///<param name= $filesize> filesize </param>
	///<returns> return the fileid or array() </returns>	
	function get_file_by_name_and_size($actualname, $filesize)
	{
		//SELECT * FROM files WHERE actualname = $actualname AND filesize = $filesize
		return $this->resource->where(array("actualname" => $actualname, "filesize" => $filesize))->get("files")->result_array();
	}

	
	/*********************operation for table homework_file**************************/
	///<summary>
	///insert homeworkfile 
	///</summary>
	///<param name= $homeworkid> homeworkid </param>	
	///<param name= $fileid> fileid </param>
	///<param name= $filename> filename </param>
	///<returns> return true if insert success </returns>	
	function add_homework_file($homeworkid, $fileid, $filename)
	{
		//INSERT INTO homework_file VALUES( $homeworkid, $fileid, $filaname )
		$this->resource->insert("homework_file", 
			array(
				"homeworkid" => $homeworkid,
				"fileid" => $fileid,
				"filename" => $filename
			));
		//return
		return true;
	}

	///<summary>
	///get homework file
	///</summary>
	///<param name= $homeworkid> homeworkid </param>
	///<returns> return array or  array() if null </returns>	
	function get_homework_file($homeworkid)
	{
		//SELECT * FROM homework_file WHERE homeworkid = $homeworkid
		return $this->resource->where("homeworkid", $homeworkid)->get("homework_file")->result_array();
	}

	///<summary>
	///delete homework file
	///</summary>
	///<param name= $homeworkid> homeworkid </param>
	///<param name= $fileid> fileid </param>
	///<returns> return true if delete success </returns>	
	function delete_homework_file($homeworkid, $fileid)
	{
		//DELETE FROM homework_file WHERE homeworkid = $homeworkid AND fileid = $fileid
		$this->resource->delete("homework_file", array("homeworkid"=>$homeworkid, "fileid"=>$fileid));
		return true;
	}
	
	///<summary>
	///get undone homeworks
	///</summary>
	///<param name= $student> $student </param>
	///<returns> return array or array() if there is no undone homeworks	
	function get_undone_homework($studentid)
	{
		$query = $this->resource->where("studentid", $studentid)->where("fileid", NULL)->where("score", NULL)->get("student_homework");
		return $query->result_array();
	}
	
	///<summary>
	///get unknown homeworks
	///</summary>
	///<param name= $student> $student </param>
	///<returns> return array or array() if there is no undone homeworks	
	function get_unknown_homework($studentid)
	{
		$query = $this->resource->where("studentid", $studentid)->where("known", false)->get("student_homework");
		return $query->result_array();
	}
	
	///<summary>
	///check whether the student have this homework
	///</summary>
	///<param name= $student> $studentid</param>
	///<param name= $homeworkid> $homeworkid</param>
	///<returns> return true or false
	function is_student_has_homework($studentid, $homeworkid)
	{
		$query = $this->resource->where("studentid", $studentid)->where("homeworkid", $homeworkid)->get("student_homework")->result_array();
		return count($query) > 0;
	}
	
	///<summary>
	///check whether the teacher have this homework
	///</summary>
	///<param name= $teacher> $teacherid</param>
	///<param name= $homeworkid> $homeworkid</param>
	///<returns> return true or false
	function is_teacher_has_homework($teacherid, $homeworkid)
	{
		$this->load->model("resource/adaptor");
		$courses = $this->adaptor->get_course_list($teacherid);
		for ($i = 0; $i != count($courses); ++$i)
		{
			$homeworks = $this->get_course_homework_list($courses[$i]["courseid"]);
			for ($j = 0; $j != count($homeworks); ++$j)
			{
				if ($homeworks[$j]["id"] == $homeworkid)
					return true;
			}
		}
		return false;
	}
	
	///<summary>
	///check whether the teacher have this course
	///</summary>
	///<param name= $teacher> $teacherid</param>
	///<param name= $courseid> $courseid</param>
	///<returns> return true or false
	function is_teacher_has_course($teacherid, $courseid)
	{
		$this->load->model("resource/adaptor");
		$courses = $this->adaptor->get_course_list($teacherid);
		for ($i = 0; $i != count($courses); ++$i)
		{
			if ($courses[$i]["courseid"] == $courseid)
				return true;
		}
		return false;
	}
	
	///<summary>
	///check whether the student have this course
	///</summary>
	///<param name= $studentid> $studentid</param>
	///<param name= $courseid> $courseid</param>
	///<returns> return true or false
	function is_student_has_course($studentid, $courseid)
	{
		$this->load->model("resource/adaptor");
		$courses = $this->adaptor->get_course_list($studentid);
		for ($i = 0; $i != count($courses); ++$i)
		{
			if ($courses[$i]["courseid"] == $courseid)
				return true;
		}
		return false;
	}
}
?>
