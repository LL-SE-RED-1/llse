<?php
class Classroom_edit_model extends CI_Model {

  function Classroom_edit_model()
  {
    parent::__construct();
  }

  public function get_classroom(){
    $this->load->database();
    //返回classroom表的内容
    $query = $this->db->get('classroom');
    return $query->result_array();
  }
  public function delete_classroom(){
    $this ->load->database();
    //得到传进的id值，执行删除命令
    $clrid=$_GET['clrid'];
    $this->db->query("delete from classroom where classroom_id=$clrid");
  }
}