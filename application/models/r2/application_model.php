<?php
class Application_model extends CI_Model {

  function Application_model()
  {
    parent::__construct();
  }

  public function get_man_application($id = FALSE){
    $this->load->database();
    if ($id === FALSE){
    $query = $this->db->get('man_apply');
    return $query->result_array();
    }
  
    $query = $this->db->get_where('man_apply', array('id' => $id));
    return $query->row_array();
  }
}