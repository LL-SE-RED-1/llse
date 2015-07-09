<?php
class Adaptor extends CI_Model{
	static $currentYear = 2015;
	static $currentTerm = TERM_AUTUMN;
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
        $this->load->model('r3/r3_curriculum_model');
        
        $result = $this->r3_curriculum_model->get_student_by_cid($courseid);
        $ret = array();
        for ($i = 0; $i != count($result); ++$i){
            $ret[$i]["studentid"] = $result[$i]->student_id;
        }
        return $ret;
	}
	
	function get_course_info($courseid){
        $this->load->model("r2/search_model");
        $info = $this->search_model->classinfo(array("class_id" => $courseid));

        $ret = array();
        for ($i = 0; $i != count($info); ++$i)
        {
            $ret[$i]["courseid"] = $info[$i]->class_id;
            $ret[$i]["name"] = $info[$i]->course_name;
            $ret[$i]["teacherid"] = $info[$i]->teacher_id;
            switch ($info[$i]->season)
            {
            case 1:$ret[$i]["term"] = TERM_SPRING_SUMMER; break;
            case 2:$ret[$i]["term"] = TERM_AUTUMN_WINTER; break;
            }
            $ret[$i]["year"] = $info[$i]->year;
        }
        return $ret;
	}
	function _convert_year($year, $term){
        $cyear = $year;
        if ($term == TERM_WINTER_SHORT || $term == TERM_SPRING || $term == TERM_SUMMER || $term == TERM_SPRING_SUMMER)
            $cyear = $year + 1;
        return $cyear;
    }

	function get_course_list_by_year_and_term($userid, $year="", $term=""){
		if ($year == "")
				$year = self::$currentYear;
		if ($term == "")
				$term = self::$currentTerm;
        
        $cyear = $this->_convert_year($year, $term);
        $type = $this->_get_user_type($userid);
		if ($type == ROLE_STUDENT) {
            $this->load->model("r3/r3_curriculum_model");
            $info = $this->r3_curriculum_model->get_all_class($userid);

            $query= array(); $j = 0;
            for ($i = 0; $i != count($info); ++$i)
            {
                $ti = $this->get_course_info($info[$i]->class_id)[0];
                if ($ti["year"] == $cyear)
                    $query[$j++] = $ti;
            }
		} else {
            $this->load->model("r2/search_model");
            $info = $this->search_model->classinfo(array("teacher_id" => $userid, "year" => $cyear));
            $ret = array();
            for ($i = 0; $i != count($info); ++$i)
            {
                $ret[$i]["courseid"] = $info[$i]->class_id;
                $ret[$i]["name"] = $info[$i]->course_name;
                $ret[$i]["teacherid"] = $info[$i]->teacher_id;
                switch ($info[$i]->season)
                {
                case 1:$ret[$i]["term"] = TERM_SPRING_SUMMER; break;
                case 2:$ret[$i]["term"] = TERM_AUTUMN_WINTER; break;
                }
                $ret[$i]["year"] = $info[$i]->year;
            }

			$query = &$ret;
        }

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
        $type = $this->_get_user_type($userid);
		if ($type == ROLE_STUDENT) {
            $this->load->model("r3/r3_curriculum_model");
            $info = $this->r3_curriculum_model->get_all_class($userid);

            $query= array(); 
            for ($i = 0; $i != count($info); ++$i)
            {
                $query[$i] = $this->get_course_info($info[$i]->class_id)[0];
            }
		} else {
            $this->load->model("r2/search_model");
            $info = $this->search_model->classinfo(array("teacher_id" => $userid));
            $ret = array();
            for ($i = 0; $i != count($info); ++$i)
            {
                $ret[$i]["courseid"] = $info[$i]->class_id;
                $ret[$i]["name"] = $info[$i]->course_name;
                $ret[$i]["teacherid"] = $info[$i]->teacher_id;
                switch ($info[$i]->season)
                {
                case 1:$ret[$i]["term"] = TERM_SPRING_SUMMER; break;
                case 2:$ret[$i]["term"] = TERM_AUTUMN_WINTER; break;
                }
                $ret[$i]["year"] = $info[$i]->year;
            }

			$query = &$ret;
        }

		return $query;
	}
	
	function get_user_info($userid){
        $info = $this->_get_user_info($userid);
        $data[0]["type"] = $this->_get_user_type($userid);
        $data[0]["name"] = $info["name"];
        $data[0]["id"] = $data[0]["number"] = $info["uid"];
        $data[0]["firstyear"] = 2012;
        return $data;
	}

    function _get_user_type($userid){
        $this->load->model("ims/ims_interface_model");
        $type = $this->ims_interface_model->get_user($userid)["type"];
        switch ($type){
        case 1: return ROLE_STUDENT;
        case 2: return ROLE_TEACHER;
        }
        return -1;
    }

    function _get_user_info($userid){
        $this->load->model("ims/ims_interface_model");
        $type = $this->_get_user_type($userid);
        switch($type){
        case ROLE_STUDENT: 
            return $this->ims_interface_model->getStudent($userid);
        case ROLE_TEACHER: 
            return $this->ims_interface_model->getTeacher($userid);
        }
        return array();
    }
	
}

?>
