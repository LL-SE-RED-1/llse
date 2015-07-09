<?php
class Adaptor extends CI_Model{
	static $currentYear = 2014;
	static $currentTerm = TERM_SPRING;
	function __construct()
    {
        parent::__construct();
        $this->adaptor = $this->load->database('adaptor', true);
    }
	
	function get_current_year(){
        //$this->load->model('ims/ims_interface_model');
        //$info = $this->ims_interface_model->get_sys_info();
		return self::$currentYear;
	}
	
	function get_current_term(){
        $this->load->model('ims/ims_interface_model');
        $info = $this->ims_interface_model->get_sys_info();
        switch ($info["semester"]){
        case 1: return TERM_SPRING;
        case 2: return TERM_SUMMER;
        case 3: return TERM_SUMMER_SHORT;
        case 4: return TERM_AUTUMN;
        case 5: return TERM_WINTER;
        default: return TERM_WINTER_SHORT;
        }
	}
	
	function get_student_list($courseid){
		$query = $this->adaptor->select('studentid')->where('courseid', $courseid)->from('course_student')->get();
		return $query->result_array();
	}
	
	function get_course_info($courseid){
		$query = $this->adaptor->where('courseid', $courseid)->from('course')->get();
		return $query->result_array();
	}
	
	function get_course_list_by_year_and_term($userid, $year="", $term=""){
		if ($year == "")
				$year = self::$currentYear;
		if ($term == "")
				$term = self::$currentTerm;
		
		$type = $this->_get_user_type();
		if ($type == ROLE_STUDENT) {
			$query = $this->adaptor->join('course', 'course.courseid = course_student.courseid')->
				where('studentid', $userid)->where('year', $year)->from('course_student')->get()->result_array();
            /*
			$query = $this->adaptor->query(
			"select res_course.name, res_user.name as teacher, term, res_course.courseid
			from res_course, res_course_student, res_user
			where res_course.courseid = res_course_student.courseid
			and res_course_student.studentid = $userid
			and res_course.year = $year
			and res_user.id = res_course.teacherid");
            */
		} else
			$query = $this->adaptor->where('teacherid', $userid)->where('year', $year)->
				from('course')->get()->result_array();
				
		$result = []; $i = 0;
		foreach ($query as $row){
			if ($term == TERM_SPRING && ($row["term"] != TERM_SPRING && $row["term"] != TERM_SPRING_SUMMER))
				continue;
			if ($term == TERM_SUMMER && ($row["term"] != TERM_SUMMER && $row["term"] != TERM_SPRING_SUMMER))
				continue;
			if ($term == TERM_AUTUMN && ($row["term"] != TERM_AUTUMN && $row["term"] != TERM_AUTUMN_WINTER))
				continue;
			if ($term == TERM_WINTER && ($row["term"] != TERM_WINTER && $row["term"] != TERM_AUTUMN_WINTER))
				continue;
			if ($term == TERM_WINTER_SHORT && $row["term"] != TERM_WINTER_SHORT)
				continue;
			if ($term == TERM_SUMMER_SHORT && $row["term"] != TERM_SUMMER_SHORT)
				continue;
            if (isset($row["teacherid"])){
                $this->load->model("ims/ims_interface_model");
                $info = $this->ims_interface_model->getTeacher($row["teacherid"]);
                $row["teacher"] = $info["name"];
            }
			$result[$i++] = $row;
		}
		return $result;
	}
	
	function get_course_list($userid){
		$type = $this->_get_user_type();
		if ($type == 0)
			$query = $this->adaptor->select('courseid')->where('studentid', $userid)->from('course_student')->get();
		else
			$query = $this->adaptor->select('courseid')->where('teacherid', $userid)->from('course')->get();
		
		return $query->result_array();
	}
	
	function get_user_info($userid){
        $data[0]["type"] = $this->_get_user_type();
        $info = $this->_get_user_info($userid);
        $data[0]["name"] = $info["name"];
        $data[0]["id"] = $data[0]["number"] = $info["uid"];
        $data[0]["firstyear"] = 2012;
        return $data;
	}

    function _get_user_type(){
        $this->load->model("ims/ims_interface_model");
        switch($this->session->userdata("user_type")){
        case 1: 
            return ROLE_STUDENT;
            $info = $this->ims_interface_model->getStudent($userid);
        case 2: 
            return ROLE_TEACHER;
            $info = $this->ims_interface_model->getTeacher($userid);
        }
    }

    function _get_user_info($userid){
        $this->load->model("ims/ims_interface_model");
        switch($this->session->userdata("user_type")){
        case 1: 
            return $this->ims_interface_model->getStudent($userid);
        case 2: 
            return ROLE_TEACHER;
            return $this->ims_interface_model->getTeacher($userid);
        }
    }
	
}

?>
