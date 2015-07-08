<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class t_apply_model extends CI_Model{
	function t_apply_model(){
		parent::__construct();
	}
	public function get_info($classid)//»ñÈ¡¶ÔÓ¦½ÌÑ§°àµÄÐÅÏ¢
	{
		$DB_default=$this->load->database('default', TRUE);//loadÊý¾Ý¿â
		//Ö´ÐÐsqlÓï¾ä£¬²éÑ¯class_id=$classidµÄ½ÌÑ§°àµÄÏà¹ØÐÅÏ¢£¬½á¹û·µ»Ø¸ø$query
		$query=$DB_default->query("SELECT * FROM classes WHERE class_id=$classid");
		return $query->row_array();//·µ»Ø¼ÇÂ¼Êý×é
	}
		public function get_apply1(){//²éÑ¯´ýÅÅ¿ÎµÄËùÓÐ½ÌÑ§°àÐÅÏ¢
			$tid=$this->session->userdata['uid'];
		$DB_default=$this->load->database('default', TRUE);//loadÊý¾Ý¿â
		//Ö´ÐÐsqlÓï¾ä£¬²éÑ¯´ýÅÅ¿ÎµÄËùÓÐ½ÌÑ§°àÐÅÏ¢£¬½á¹û·µ»Ø¸ø$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN imsCourse USING (course_id) WHERE state=1 teacher_id=$tid');
		return $query->result_array();//·µ»Ø¼ÇÂ¼Êý×é
		
	}
	public function get_apply2(){//²éÑ¯ÅÅ¿Î³É¹¦µÄËùÓÐ½ÌÑ§°àÐÅÏ¢
		$tid=$this->session->userdata['uid'];
		$DB_default=$this->load->database('default', TRUE);//loadÊý¾Ý¿â
		//Ö´ÐÐsqlÓï¾ä£¬²éÑ¯ÅÅ¿Î³É¹¦µÄËùÓÐ½ÌÑ§°àÐÅÏ¢£¬½á¹û·µ»Ø¸ø$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN classes USING (class_id) WHERE state=2 teacher_id=$tid');
		return $query->result_array();//·µ»Ø¼ÇÂ¼Êý×é
		
	}
	public function get_apply5(){//²éÑ¯ÅÅ¿Î³É¹¦µÄËùÓÐ½ÌÑ§°àÐÅÏ¢
		$tid=$this->session->userdata['uid'];
		$DB_default=$this->load->database('default', TRUE);//loadÊý¾Ý¿â
		//Ö´ÐÐsqlÓï¾ä£¬²éÑ¯ÅÅ¿Î³É¹¦µÄËùÓÐ½ÌÑ§°àÐÅÏ¢£¬½á¹û·µ»Ø¸ø$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN classes USING (class_id) WHERE state=5 teacher_id=$tid');
		return $query->result_array();//·µ»Ø¼ÇÂ¼Êý×é
		
	}
	public function get_apply3(){//²éÑ¯´ýµ÷ÕûµÄËùÓÐ½ÌÑ§°àÐÅÏ¢
		$tid=$this->session->userdata['uid'];
		$DB_default=$this->load->database('default', TRUE);//loadÊý¾Ý¿â
		//Ö´ÐÐsqlÓï¾ä£¬²éÑ¯´ýµ÷ÕûµÄËùÓÐ½ÌÑ§°àÐÅÏ¢£¬½á¹û·µ»Ø¸ø$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN classes USING (class_id) WHERE state=3 teacher_id=$tid');
		return $query->result_array();//·µ»Ø¼ÇÂ¼Êý×é
	}
	public function get_apply4(){//²éÑ¯ÒÑ±»É¾³ýµÄËùÓÐ½ÌÑ§°àÐÅÏ¢
		$tid=$this->session->userdata['uid'];
		$DB_default=$this->load->database('default', TRUE);//loadÊý¾Ý¿â
		//Ö´ÐÐsqlÓï¾ä£¬²éÑ¯ÒÑ±»É¾³ýµÄËùÓÐ½ÌÑ§°àÐÅÏ¢£¬½á¹û·µ»Ø¸ø$query
		$query=$DB_default->query('SELECT * FROM apply INNER JOIN imsCourse USING (course_id) WHERE state=4 teacher_id=$tid');
		return $query->result_array();//·µ»Ø¼ÇÂ¼Êý×é
	}
	public function get_classroom()
	{
		$DB_default=$this->load->database('default', TRUE);
		$query=$DB_default->query('SELECT * FROM classroom');
		return $query->result_array();
	}
	public function add_manapply($classid){//Ìí¼Ó½ÌÑ§°à
		//echo $_POST["changeinfo"];
        //$result2=0;		
		$DB_default=$this->load->database('default', TRUE);//loadÊý¾Ý¿â
		$result1 = $DB_default->query("insert into man_apply (class_id,text,date) 
			values($classid,'$_POST[changeinfo]',now())");//²åÈëÐÂµÄµ÷ÕûÉêÇë
		if($result1)//Èç¹û²åÈë³É¹¦Ôò°Ñ¶ÔÓ¦µÄÉêÇë¼ÇÂ¼µÄ×´Ì¬¸Ä³É´ýµ÷Õû
		 $DB_default->query("update apply set state=3 where class_id=$classid");
		return $result1;
		
	}
	
}
//SELECT * FROM items INNER JOIN sales USING ( item_id );