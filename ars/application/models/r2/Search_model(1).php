<?php
class Search_model extends CI_Model {

  /* public function typecheck(){
    $result=0;
    $this->load->database();
    if (strlen($_POST["teacher_id"])>0) $result=1;
   // else if ((strlen($_POST["campus"])>0) && (strlen($_POST["building"])>0) && (strlen($_POST["room"])>0)) $result=2;
    else $result=0;
  }*/
  public function initial_table(){
    $this->load->database();
    $query=$this->db->query("select * from classes where class_id=0");//一开始设定不显示
    return $query->result_array();

  }
  public function get_teacher_table(){
    $this->load->database();
    $tc_id=$_POST["tc_id"];
   // $query=$this->db->get_where('classes',array('teacher_id' =>$_POST["teacher_id"]));
    $query=$this->db->query("select * from classes where teacher_name='$tc_id'");//选择出给定的教师名
    return $query->result_array();
  }
  public function get_where_table(){
    $this->load->database();
    $campus=$_POST["campus"];
    switch($campus){//校区与数字的转化
      case "紫金港":$campus_a=1; break;
      case "玉泉":$campus_a=2;break;
      case "西溪":$campus_a=3;break;
      case "华家池":$campus_a=4;break;
      case "之江":$campus_a=5;break;
    }
    $building_a=$_POST["building"];
    $room_a=$_POST["room"];
    $query=$this->db->query("select * from classes where campus=$campus_a and building='$building_a' and room=$room_a");//选出给定的教室
    return $query->result_array();
  }
 /* public function get_classroom_table(){
    $this->load->database();
    $query=$this->db->query('select * from classes where ');
  }*/
}