<?php
class Question_model extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function get_questions($slug = FALSE){
  if ($slug === FALSE)
  {
    $query = $this->db->get('R6_QUESTION');
    return $query->result_array();
  }
  
  $query = $this->db->get_where('R6_QUESTION', array('QID' => $slug));
  return $query->row_array();
  }

  public function delete_questions(){
    $this->load->helper('url');

    $data = array(
      'QID' => $this->input->post('QID'),
    );
    return $this->db->delete('R6_QUESTION', array('QID' => $data['QID'])); 
  }

  public function set_questions(){
  $this->load->helper('url');

  $sum = 0;
  $weeks = $this->input->post('KEY');
  for($i=0;$i<count($weeks);$i++)   
    $sum += $weeks[$i]; 
  //echo $weeks[$i]."<br>";  

  $data = array(
    'TID' => $this->input->post('TID'),
    'CID' => $this->input->post('CID'),
    'QUESTION' => $this->input->post('QUESTION'),
    'TYPE' => $this->input->post('TYPE'),
    'CHOICES' => $this->input->post('SELECT_A')."\\%%".$this->input->post('SELECT_B')."\\%%".$this->input->post('SELECT_C')."\\%%".$this->input->post('SELECT_D')."\\%%",
    //'KEY' => $this->input->post('KEY'),
    'KEY' => $sum,
    'EXAM_POINT' => $this->input->post('EXAM_POINT'),
     'LEVEL' => $this->input->post('LEVEL'),
  );

    if (count($weeks)>1) {
      $data["TYPE"] = 'MULTICHOICE';
    }
	echo $data['QUESTION'];
  return $this->db->insert('R6_QUESTION', $data);
  }

  public function edit_questions(){
    $this->load->helper('url');

  $sum = 0;
  $weeks = $this->input->post('KEY');
  for($i=0;$i<count($weeks);$i++)   
    $sum += $weeks[$i]; 

    $data = array(
      'TID' => $this->input->post('TID'),
      'CID' => $this->input->post('CID'),
      'QUESTION' => $this->input->post('QUESTION'),
      'TYPE' => $this->input->post('TYPE'),
      'CHOICES' => $this->input->post('SELECT_A')."\\%%".$this->input->post('SELECT_B')."\\%%".$this->input->post('SELECT_C')."\\%%".$this->input->post('SELECT_D')."\\%%",
      'KEY' => $sum,/*$this->input->post('KEY')*/
      'EXAM_POINT' => $this->input->post('EXAM_POINT'),
      'LEVEL' => $this->input->post('LEVEL'),
    );
    if (count($weeks)>1) {
      $data["TYPE"] = 'MULTICHOICE';
    }
    
    //return $this->db->insert('QUESTION', $data);
    $this->db->where('QID', $this->input->post('QID'));
    $this->db->update('R6_QUESTION', $data); 
  }

  public function search(){

    if($this->input->post('SEARCH') == 'ID'){
        $query = $this->db->get_where('R6_QUESTION', array('QID' => $this->input->post('KEYWORD')));
        return $query->row_array();
    }else{
        $sql = "SELECT * FROM `R6_QUESTION` WHERE QUESTION like '%".$this->input->post('KEYWORD')."%' or CHOICES like '%".$this->input->post('KEYWORD')."%'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

  
 
  }

}
