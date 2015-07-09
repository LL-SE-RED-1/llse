<?php
class Class_info_model extends CI_Model {

  function Class_info_model()
  {
    parent::__construct();
  }

  public function edit_score($class_id,$score){
    $this->load->database();
    //返回classroom表的内容
    $query = $this->db->query("SELECT * FROM classes WHERE class_id = $class_id")->row();
    $query->assess_score = $query->assess_score + $score;
    $query->assess_num = $query->assess_num+1;
    $this->db->update('classes',$query, array('class_id'=>$class_id));
  }
  public function add_margin($class_id){
    $this->load->database();
    //返回classroom表的内容
    $query = $this->db->query("SELECT * FROM classes WHERE class_id = $class_id")->row();
    $query->margin = $query->margin+1;
    $this->db->update('classes',$query, array('class_id'=>$class_id));
  }
   public function reduce_margin($class_id){
    $this->load->database();
    //返回classroom表的内容
    $query = $this->db->query("SELECT * FROM classes WHERE class_id = $class_id")->row();
    $query->margin = $query->margin-1;
    $this->db->update('classes',$query, array('class_id'=>$class_id));
  }
}