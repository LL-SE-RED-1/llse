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
    $query=$this->db->query("delete from search");//选择出给定的教师名
    $tc_name=$_POST["tc_name"];
   // $query=$this->db->get_where('classes',array('teacher_id' =>$_POST["teacher_id"]));
    $query=$this->db->query("select course_name,sche from classes where teacher_name='$tc_name'");//选择出给定的教师名

    return $query->result_array();
  }
  public function get_where_table(){
    $this->load->database();
    $query=$this->db->query("delete from search");//选择出给定的教师名
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
    $query=$this->db->query("select * from classroom where campus=$campus_a and building='$building_a' and room=$room_a")->row();//选出给定的教室
    $data=$query->classroom_id;
    $classes=$this->db->query("select * from classes")->result_array();
   // foreach ($data as $data_item){
      foreach ($classes as $classes_item){ 
        $cl_team=$classes_item['classroom'];
        $cl_id=explode(';',$cl_team);
        $length=count($cl_id);
        for ($i=1;$i<$length;$i++){
         // echo $data."   ".$cl_id[$i];
          if ($data==$cl_id[$i]){
            $cou_name=$classes_item['course_name'];
            $cou_sche=$classes_item['sche'];
           // echo "sche:".$cou_sche."\n";
            $this->db->query("insert into search(course_name,sche) values('$cou_name','$cou_sche')");
          }
        }
      }
   // }


   return $this->db->query("select * from search")->result_array();
   // foreach ($data as $data_item){
  }
 /* public function get_classroom_table(){
    $this->load->database();
    $query=$this->db->query('select * from classes where ');
  }*/
}