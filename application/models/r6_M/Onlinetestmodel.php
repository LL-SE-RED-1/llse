<?php
class Onlinetestmodel extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function create_exam($arr){
		$this->db->insert("R6_EXAM", $arr);
	}

	function insert_score($arr){
		$this->db->insert('R6_SCORE', $arr);
	}

	function get_ques($pid){
		$sql = 'SELECT QID_ARRAY FROM R6_PAPER WHERE PID='.$pid;
		$result=$this->db->query($sql);
		return $result->result();
	}

	function get_text($qid){
		$sql = 'SELECT QUESTION FROM R6_QUESTION WHERE QID='.$qid;
		$result=$this->db->query($sql);
		$result=$result->result()[0]->QUESTION;
		return $result;
	}

	function get_key($qid){
		$sql = 'SELECT `KEY` FROM R6_QUESTION WHERE QID='.$qid;
		$result = $this->db->query($sql);
		return $result->result()[0]->KEY;
	}
	
	function get_choice($qid){
		$sql = 'SELECT CHOICES FROM R6_QUESTION WHERE QID='.$qid;
		$result = $this->db->query($sql);
		return $result->result()[0]->CHOICES;
	}
	
	function get_time($eid){
		$sql = 'SELECT Last FROM R6_EXAM WHERE EID='.$eid;
		$result = $this->db->query($sql);
		return $result->result()[0]->Last;
	}
	
	function get_type($qid){
		$sql = 'SELECT TYPE FROM R6_QUESTION WHERE QID='.$qid;
		$result = $this->db->query($sql);
		return $result->result()[0]->TYPE;
	}
	
	function get_exam($sid){
		$sql = 'SELECT * FROM R6_EXAM';
		$result = $this->db->query($sql);
		return $result->result();
	}
	
	function get_paper($tid){
		$sql = 'SELECT PID FROM R6_PAPER WHERE TID ='.$tid;
		$result = $this->db->query($sql);
		return $result->result();
	}
	
	function get_pid($eid){
		$sql = 'SELECT PID FROM R6_EXAM WHERE EID ='.$eid;
		$result = $this->db->query($sql);
		return $result->result()[0]->PID;
	}

	function get_info($eid){
		$sql = 'SELECT INFO FROM R6_EXAM WHERE EID ='.$eid;
		$result = $this->db->query($sql);
		return $result->result()[0]->INFO;
	}
	
	function get_level($qid){
		$sql = 'SELECT LEVEL FROM R6_QUESTION WHERE QID ='.$qid;
		$result = $this->db->query($sql);
		return $result->result()[0]->LEVEL;
	}
	
	function check_eid_sid($eid, $sid){
		$sql = 'SELECT * FROM R6_SCORE WHERE EID='.$eid.' AND SID='.$sid;
		$result = $this->db->query($sql);
		$c = count($result->result());
		return ($c==0);
	}
}

?>
