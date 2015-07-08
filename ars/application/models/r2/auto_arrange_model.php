<?php
class Auto_arrange_model extends CI_Model {
/*构造函数*/
  function Auto_arrange_model()
  {
    parent::__construct();
  }

/*获取未处理申请*/
  public function get_application($page=1){
    $this->load->database();
    if($page<1)
      $page=1;
    $begin = 10*$page-10;
    $end = 10 *  $page;
    $query = $this->db->query("SELECT * FROM apply where state = 1 limit $begin, $end ");
    return $query->result_array();
  }

/*删除申请，即将申请状态改为4*/
  public function delete_application(){
    $this ->load->database();
    $crid=$_GET['crid'];
    //$query=$this->db->query("delete from classroom where id=$clrid");
    //return $query;
    $this->db->query("update apply set state = 4 where class_id=$crid");
  }

  public function delete_tmp(){
    $this ->load->database();
    $this->db->query("delete from tmp_room_sche");    
  }
 
/*获取这门课程考试时间*/ 
  public function gettest($course_id, $year, $season){
     $this->load->database();
     $query = $this->db->query("SELECT * FROM classes WHERE course_id = $course_id and year = $year and season = $season");
     if($query->num_rows() == 0)
       return FALSE;
     return $query->row()->testtime;   
  }

/*获取满足条件的教室*/ 
  public function get_rooms($campus,$type){
    $this->load->database();
    $query = $this->db->query("SELECT * FROM classroom where campus = $campus and type = $type and capacity >= $capacity");
    return $query->result_array();
  }

/*根据id获取教室信息*/ 
  public function get_course($course_id){
     $this->load->database();
     $query = $this->db->query("SELECT * FROM imsCourse WHERE course_id = $course_id");
     if($query->num_rows() == 0)
       return FALSE;
     return $query->row();
  }

/*根据id获取教室安排*/ 
  public function get_room_sche($room_id){
     $this->load->database();
     $query = $this->db->query("SELECT * FROM room_sche where classroom_id = $room_id");
     return $query->row();
  }

/*根据id获取教师信息*/ 
  public function get_teacher($teacher_id){
     $this->load->database();
     $query = $this->db->query("SELECT * FROM imsTeacher WHERE teacher_id = $teacher_id");
     if($query->num_rows() == 0)
       return FALSE;
     return $query->row();
  }

  /*根据id获取教师信息*/ 
  public function get_teacher_sche($teacher_id){
     $this->load->database();
     $query = $this->db->query("SELECT * FROM teach_sche WHERE teacher_id = $teacher_id");
     return $query->row();
  }

  public function getid(){
    $this->load->database();
    $num_query = $this->db->query("SELECT * FROM classes");
    $id = $num_query->num_rows() + 1;    
    return $id;
  }

  public function get_tmp_rooms(){
    $this->load->database();
    $query = $this->db->query("SELECT * FROM tmp_room_sche");
    return $query->result_array();    
  }


/*更新教室安排*/
  public function update_room($data,$id){
    $this->load->database();
    $this->db->update('room_sche',$data, array('classroom_id'=>$id));
  }

  public function update_tmp_room($time,$id){
    $this->load->database();
    $query = $this->db->query("SELECT * FROM tmp_room_sche WHERE classroom_id = $id");
    if($query->num_rows() == 0){
      $data = $this->db->query("SELECT * FROM room_sche WHERE classroom_id = $id")->row();
      $this->db->insert('tmp_room_sche',$data);
    }
    else
      $data = $query->row();
    
    $data->M = ($data->M - $time['M']);    
    $data->T = ($data->T - $time['T']);
    $data->W = ($data->W - $time['W']);
    $data->TH = ($data->TH - $time['TH']);
    $data->F = ($data->F - $time['F']);
    $this->db->update('tmp_room_sche',$data, array('classroom_id'=>$id));    
  }

    public function update_teacher($data,$id){
    $this->load->database();
    $this->db->update('teach_sche',$data, array('teacher_id'=>$id));
  }


/*更新申请状态*/
  public function update_apply($data,$class_id){
    $this->load->database();
    $this->db->update('apply', $data, array('class_id' => $class_id));
  }


/*加入一个教学班*/
  public function insert_class($data){
    $this->load->database();
    $this->db->insert('classes',$data);
  }
  


  public function get_sche($room_id, $teacher_id){
    $this->load->database();
    $rquery = $this->db->query("SELECT * FROM room_sche where classroom_id = $room_id")->row();
    $tquery =  $this->db->query("SELECT * FROM teach_sche where teacher_id = $teacher_id")->row();
    
    if((($rquery->M & 206)!=0) && (($tquery->M & 206)!=0) ){
      $time = $rquery->M & 206;
      if(($time & $tquery->M)!=0){
        $old = $tquery->M;
        $rold = $rquery->M;
        $new = $time & $tquery->M;
        if($new >= 128)
          $new = 128;
        else if($new >= 64)
          $new = 64;
        else if($new >= 32)
          $new = 32;
        else if($new >= 16)
          $new = 16;
        else if($new >= 8)
          $new = 8;
        else if($new >= 4)
          $new = 4;
        else if($new >= 2)
          $new = 2;
        else 
          $new = 1;
        $ttime = $old - $new;
        //$rtime = $rold - $new;
       
        $result['sche'] = $new + 1000;
        $result['t_sche'] = array('teacher_id' => $teacher_id,
                                  'M'=>$ttime,
                                  'T'=>$tquery->T,
                                  'W'=>$tquery->W,
                                  'TH'=>$tquery->TH,
                                  'F'=>$tquery->F );
        $this->db->update('teach_sche',$result['t_sche'], array('teacher_id'=>$teacher_id));
        $result['r_sche'] = array('classroom_id' => $room_id,
                                  'M'=>$new,
                                  'T'=>0,
                                  'W'=>0,
                                  'TH'=>0,
                                  'F'=>0 );
            return $result;
      }
    }
    if(($rquery->T & 206)!=0 && ($tquery->T & 206)!=0 ){
      $time = $rquery->T & 206;
      if(($time & $tquery->T)!=0){
        $old = $tquery->T;
        $rold = $rquery->T;
        $new = $time & $tquery->T;
        if($new >= 128)
          $new = 128;
        else if($new >= 64)
          $new = 64;
        else if($new >= 32)
          $new = 32;
        else if($new >= 16)
          $new = 16;
        else if($new >= 8)
          $new = 8;
        else if($new >= 4)
          $new = 4;
        else if($new >= 2)
          $new = 2;
        else 
          $new = 1;
        $ttime = $old - $new;
        $rtime = $rold - $new;
        
        $result['sche'] = $new + 2000;
        $result['t_sche'] = array('teacher_id' => $teacher_id,
                                  'M'=>$tquery->M,
                                  'T'=>$ttime,
                                  'W'=>$tquery->W,
                                  'TH'=>$tquery->TH,
                                  'F'=>$tquery->F );
        $this->db->update('teach_sche',$result['t_sche'], array('teacher_id'=>$teacher_id));
        $result['r_sche'] = array('classroom_id' => $room_id,
                                  'M'=>0,
                                  'T'=>$new,
                                  'W'=>0,
                                  'TH'=>0,
                                  'F'=>0 );
            return $result;
      }
    }
    if(($rquery->W & 206)!=0 && ($tquery->W & 206)!=0 ){
      $time = $rquery->W & 206;
      if(($time & $tquery->W)!=0){
        $old = $tquery->W;
        $rold = $rquery->W;
        $new = $time & $tquery->W;
        if($new >= 128)
          $new = 128;
        else if($new >= 64)
          $new = 64;
        else if($new >= 32)
          $new = 32;
        else if($new >= 16)
          $new = 16;
        else if($new >= 8)
          $new = 8;
        else if($new >= 4)
          $new = 4;
        else if($new >= 2)
          $new = 2;
        else 
          $new = 1;
        $ttime = $old - $new;
        $rtime = $rold - $new;
        
        $result['sche'] = $new + 3000;
        $result['t_sche'] = array('teacher_id' => $teacher_id,
                                  'M'=>$tquery->M,
                                  'T'=>$tquery->T,
                                  'W'=>$ttime,
                                  'TH'=>$tquery->TH,
                                  'F'=>$tquery->F );
        $this->db->update('teach_sche',$result['t_sche'], array('teacher_id'=>$teacher_id));
        $result['r_sche'] = array('classroom_id' => $room_id,
                                  'M'=>0,
                                  'T'=>0,
                                  'W'=>$new,
                                  'TH'=>0,
                                  'F'=>0 );
            return $result;
      }
    }
    if(($rquery->TH & 206)!=0 && ($tquery->TH & 206)!=0 ){
      $time = $rquery->TH & 206;
      if(($time & $tquery->TH)!=0){
        $old = $tquery->TH;
        $rold = $rquery->TH;
        $new = $time & $tquery->TH;
        if($new >= 128)
          $new = 128;
        else if($new >= 64)
          $new = 64;
        else if($new >= 32)
          $new = 32;
        else if($new >= 16)
          $new = 16;
        else if($new >= 8)
          $new = 8;
        else if($new >= 4)
          $new = 4;
        else if($new >= 2)
          $new = 2;
        else 
          $new = 1;
        $ttime = $old - $new;
        $rtime = $rold - $new;
        
        $result['sche'] = $new + 4000;
        $result['t_sche'] = array('teacher_id' => $teacher_id,
                                  'M'=>$tquery->M,
                                  'T'=>$tquery->T,
                                  'W'=>$tquery->W,
                                  'TH'=>$ttime,
                                  'F'=>$tquery->F );
        $this->db->update('teach_sche',$result['t_sche'], array('teacher_id'=>$teacher_id));
        $result['r_sche'] = array('classroom_id' => $room_id,
                                  'M'=>0,
                                  'T'=>0,
                                  'W'=>0,
                                  'TH'=>$new,
                                  'F'=>0 );
            return $result;
      }
    }
    if(($rquery->F & 206)!=0 && ($tquery->F & 206)!=0 ){
      $time = $rquery->F & 206;
      if(($time & $tquery->F)!=0){
        $old = $tquery->F;
        $rold = $rquery->F;
        $new = $time & $tquery->F;
        if($new >= 128)
          $new = 128;
        else if($new >= 64)
          $new = 64;
        else if($new >= 32)
          $new = 32;
        else if($new >= 16)
          $new = 16;
        else if($new >= 8)
          $new = 8;
        else if($new >= 4)
          $new = 4;
        else if($new >= 2)
          $new = 2;
        else 
          $new = 1;
        $ttime = $old - $new;
        $rtime = $rold - $new;
        $result['sche'] = $new + 5000;
        $result['t_sche'] = array('teacher_id' => $teacher_id,
                                  'M'=>$tquery->M,
                                  'T'=>$tquery->T,
                                  'W'=>$tquery->W,
                                  'TH'=>$tquery->TH,
                                  'F'=>$ttime );
        $this->db->update('teach_sche',$result['t_sche'], array('teacher_id'=>$teacher_id));
        $result['r_sche'] = array('classroom_id' => $room_id,
                                  'M'=>0,
                                  'T'=>0,
                                  'W'=>0,
                                  'TH'=>0,
                                  'F'=>$new );
            return $result;
      }
    }
    return False;
  }  
}