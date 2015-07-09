<?php
class Schedual_model extends CI_Model {

  function Schedual_model()
  {
    parent::__construct();
  }

  public function add_sche($tid){
    $this->load->database();
    $this->db->query("insert into teach_sche (teacher_id,M,T,W,TH,F) values($tid,255.255,255,255,255)");

  }

   public function delete_sche($tid){
    $this->load->database();
    $this->db->query("delete from teach_sche where teacher_id = $tid");

  }
}