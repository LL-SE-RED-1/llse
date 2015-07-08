<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class t_menu_model extends CI_Model{
	function t_menu_model(){
		parent::__construct();
	}
	public function get_apply1(){//查询待排课的所有教学班信息
		$DB_default=$this->load->database('default', TRUE);//load数据库
		//执行sql语句，查询待排课的所有教学班信息，结果返回给$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN imsCourse USING (course_id) WHERE state=1');
		return $query->result_array();//返回记录数组
		
	}
	public function get_apply2(){//查询排课成功的所有教学班信息
		$DB_default=$this->load->database('default', TRUE);//load数据库
		//执行sql语句，查询排课成功的所有教学班信息，结果返回给$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN classes USING (class_id) WHERE state=2');
		return $query->result_array();//返回记录数组
		
	}
	public function get_apply5(){//查询排课成功的所有教学班信息
		$DB_default=$this->load->database('default', TRUE);//load数据库
		//执行sql语句，查询排课成功的所有教学班信息，结果返回给$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN classes USING (class_id) WHERE state=5');
		return $query->result_array();//返回记录数组
		
	}
	public function get_apply3(){//查询待调整的所有教学班信息
		$DB_default=$this->load->database('default', TRUE);//load数据库
		//执行sql语句，查询待调整的所有教学班信息，结果返回给$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN classes USING (class_id) WHERE state=3');
		return $query->result_array();//返回记录数组
	}
	public function get_apply4(){//查询已被删除的所有教学班信息
		$DB_default=$this->load->database('default', TRUE);//load数据库
		//执行sql语句，查询已被删除的所有教学班信息，结果返回给$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN imsCourse USING (course_id) WHERE state=4');
		return $query->result_array();//返回记录数组
	}
	public function get_classroom()
	{
		$DB_default=$this->load->database('default', TRUE);
		$query=$DB_default->query('SELECT * FROM classroom');
		return $query->result_array();
	}
	public function check(){//检查能否添加course_id=$courseid的教学班
	
		$result = 0;
		$DB_default=$this->load->database('default', TRUE);//load数据库
		//搜索是否有这门课程
		$query=$DB_default->query("SELECT * FROM imsCourse WHERE course_id=$_POST[courseid]");
		if ($query->num_rows() > 0);//如果有result=0
		else return $result=1;//没有result=1
		/*$query=$DB_default->query("SELECT * FROM apply WHERE course_id=$_POST[courseid] and teacher_id=12345");
		if ($query->num_rows() > 0)
		return	$result=2;*/
		return $result;//返回result
	}
	function addapply(){//添加教学班
		$DB_default=$this->load->database('default', TRUE);//load数据库
		$result = $DB_default->query("insert into apply (course_id,teacher_id,date,state) 
			values('$_POST[courseid]',12345,now(),1)");//向apply表插入一条申请记录，结果返回给result
		return $result;//返回插入语句执行结果
	}
}
//SELECT * FROM items INNER JOIN sales USING ( item_id );
