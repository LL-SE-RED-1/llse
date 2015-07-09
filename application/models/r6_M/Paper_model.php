<?php
class Paper_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function user_select($tid,$cid,$level)
	{
		$sql="SELECT QID,TYPE,LEVEL,EXAM_POINT FROM R6_QUESTION WHERE TID=$tid AND CID=$cid AND LEVEL=$level";
		$result=$this->db->query($sql);
		return $result->result();
	}
	function user_sel($tid,$cid)
	{
		$sql="SELECT QID,TYPE,LEVEL,EXAM_POINT FROM R6_QUESTION WHERE TID=$tid AND CID=$cid";
		$result=$this->db->query($sql);
		return $result->result();
	}
	function user_sel_cid($tid)
	{
		$sql="SELECT CID FROM R6_QUESTION WHERE TID=$tid";
		$result = $this->db->query($sql);
		return $result->result();
	}
	
	function user_sel_paper($tid,$cid)
	{
		$sql="SELECT* FROM R6_PAPER WHERE TID=$tid AND CID=$cid";
		$result=$this->db->query($sql);
		return $result->result();
	}
	function get_paper($pid)
	{
		$sql="SELECT* FROM R6_PAPER WHERE PID=$pid";
		$result=$this->db->query($sql);
		return $result->result();
	}
	function update_paper($pid,$q_array)
	{
		//$sql="UPDATE R6_PAPER SET QID_ARRAY=".$q_array." WHERE PID=$pid";
		//$this->db->query($sql);
		$this->db->where('PID', $pid);
		$data=array("QID_ARRAY"=>$q_array);
		$this->db->update('R6_PAPER', $data);
	}
	
	function exam_point_flag($exam_point,$exam_point_array)
	{
		$flag=0;
		for($i=0;$i<count($exam_point_array);$i++)
		{
			if($exam_point == $exam_point_array[$i])
				$flag=1;
		}
		return $flag;
		
	}
	
	function unique_rand($min, $max, $num) 
	{
		$count = 0;
		$return = array();
		while ($count < $num) {
			$return[] = mt_rand($min, $max);
			$return = array_flip(array_flip($return));
			$count = count($return);
		}
    
		shuffle($return);
		sort($return);
		return $return;
	}
	
	function user_insert($arr)
	{
		$this->db->insert("R6_PAPER",$arr);
	}
	function user_select_question($id)
	{
		$sql="SELECT QID,QUESTION,CHOICES,TYPE FROM R6_QUESTION WHERE QID=$id";
		$result=$this->db->query($sql);
		return $result->result();
	}
	/*
	function user_update($id,$arr)
	{
		$this->db->where("uid",$id);
		$this->db->update("r6_question",$arr);
	}
	function user_del($id)
	{
		$this->db->where("uid",$id);
		$this->db->delete("r6_question");
	}
	function user_select($id)
	{
		$this->db->where("uid",$id);
		$this->db->select("*");
		$query=$this->db->get("r6_question");
		return $query->result();
	}*/
}

?>