<?php
class Apply_model extends CI_Model {

  function Apply_model()
  {
    parent::__construct();
  }

  public function get_application(){
    $this->load->database();
   // echo"enenen";
    $query = $this->db->query("select * from man_apply natural join classes"); //显示man_apply和classes自然连接的结果
    return $query->result_array();
  }
  public function delete_application(){
    $this->load->database();
    $clid=$_GET['clid'];
    //$query=$this->db->query("delete from classroom where id=$clrid");
    //return $query;
    $this->db->query("delete from man_apply where class_id=$clid");
    $this->db->query("update apply set state=5 where class_id=$clid");
  }
}