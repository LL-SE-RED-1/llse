<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_auto_arrange extends CI_Controller{
/*构造函数*/
	function Admin_auto_arrange(){
		parent::__construct();
	}	

/*初始化界面*/
	public function index(){
	   $this->load->model('r2/auto_arrange_model');
     if (empty($_GET['crid'])){
        if(empty($_GET['pid']))
           $data['apply'] = $this->auto_arrange_model->get_application(1);
         else
           $data['apply'] = $this->auto_arrange_model->get_application($_GET['pid']);
    } 
     else {
     /*处理对申请的删除表单*/
      $this->auto_arrange_model->delete_application();
      if(empty($_GET['pid']))
           $data['apply'] = $this->auto_arrange_model->get_application(1);
      else
           $data['apply'] = $this->auto_arrange_model->get_application($_GET['pid']);
     }

     if(empty($_GET['pid']))
        $data['page']=1;
      else
        $data['page']=$_GET['pid'];
      if($data['page']<1)
        $data['page']=1;
     /*传递参数*/
     $this->load->view('r2/admin_auto_arrange',$data);
     $this->load->helper('url');
	}

/*自动排课*/
	public function arrange(){
	   $this->load->model('r2/auto_arrange_model');

     /*依次处理教师的申请*/
	   $application = $this->auto_arrange_model->get_application();
	   foreach($application as $value){
       $id = $value['class_id'];   //获取教学班id
	   	 $date = $value['date'];     //获取提交申请时间
	   	 $course_id = $value['course_id'];   //获取课程ID
       
       /*判断课程是否存在*/
	   	 $course = $this->auto_arrange_model->get_course($course_id);
	   	 if($course == FALSE)
	   	 	break;

       /*从course和teacher获取课程信息，教师信息*/ 
       $course_name = $course->name;
       $campus = $course->campus;
       $college = $course->college;
       $hour = $course->credit;
       $type = $course->ctype;
       $capacity = $course->capacity;
       $teacher_id = $value['teacher_id'];
       $teacher = $this->auto_arrange_model->get_teacher($teacher_id);
       $teacher_name = $teacher->name;
      /*获取系统信息*/
       //$tmp = now();
       $tmpdate = explode("-",date('Y-m-d H:i:s'));
       $year=$tmpdate[0];
       $season=floor($tmpdate[1]/6)+1;  //1:代表秋冬，2：代表春夏
      /*寻找符合条件的教室*/
       $sche="";
       $room="";
       $old_tsche = $this->auto_arrange_model->get_teacher_sche($teacher_id);
       $tmp = $course_id%8;
       $testtime = ($tmp/4+1)*$hour*10 + $tmp/2+1;
       for($i=0;$i<$hour;$i++){
           $rooms = $this->auto_arrange_model->get_rooms($campus,$type,$capacity);
           $time = "";
           foreach($rooms as $classroom){
             $room_id = $classroom['classroom_id'];
             $room_sche[$room_id] = $this->auto_arrange_model->get_room_sche($room_id);
           }
           foreach($rooms as $classroom){
                $room_id = $classroom['classroom_id'];
                $time = $this->auto_arrange_model->get_sche($room_id, $teacher_id);
                if($time != False){
                   $tmptime = $time['sche']%1000;
                   $tmpweek = floor($time['sche']/1000);
                  
                   switch ($tmptime) {
                     case 128:
                       $tmptime = $tmpweek*10000000000000+1100000000000;
                       break;
                     case 64:
                       $tmptime = $tmpweek*10000000000000+11000000000;
                       break;
                     case 8:
                       $tmptime = $tmpweek*10000000000000+1100000;
                       break;
                    case 4:
                       $tmptime = $tmpweek*10000000000000+11000;
                       break;
                    case 2:
                       $tmptime = $tmpweek*10000000000000+110;
                       break;
                   }
                   
                   $sche = $sche.";".$tmptime;
                   $room = $room.";".$room_id;
                   $this->auto_arrange_model->update_tmp_room($time['r_sche'],$room_id);
                  
                   break;
                }
            }
        if($time == False){        
          $sche = "";
          break;
        }
      }
      if($sche == ""){
         
         $this->auto_arrange_model->update_teacher($old_tsche,$teacher_id);
         $this->auto_arrange_model->delete_tmp();
      }
      else{
           
           $room_sche = $this->auto_arrange_model->get_tmp_rooms();
           foreach ($room_sche as $key) {
               $key_id = $key['classroom_id'];
               $this->auto_arrange_model->update_room($key, $key_id);
               $this->auto_arrange_model->delete_tmp();
           }
           $apply =  array('class_id' => $id ,
                           'course_id'=>$course_id,
                           'teacher_id'=>$teacher_id,
                           'date'=>$date,
                           'state'=>2 );
          // echo "****".$id."****".$course_id."****".$teacher_id."****".$room."****".$capacity."****".$year."****".$campus."****".$season."****".$sche."****".$type."****".$testtime."*************";
           //$sq = "insert into classes (class_id, course_id,teacher_id,classroom,capacity,margin,access_score,access_num,year,campus,season,course_name,teacher_name,sche,ctype,testtime) 
      //values($id,'$course_id','$teacher_id','$room',$capacity,$capacity,0,0,$year,$campus,$season,'$course_name','$teacher_name','$sche',$type,$testtime)";
           $class = array('class_id'=>$id,
                          'course_id'=>$course_id,
                          'teacher_id'=>$teacher_id,
                          'classroom'=>$room,
                          'capacity'=>$capacity,
                          'margin'=>$capacity,
                          'assess_score' => 0,
                          'assess_num' => 0,
                          'year'=>$year,
                          'campus'=>$campus,
                          'season'=>$season,
                          'college'=>$college,
                          'course_name'=>$course_name,
                          'teacher_name'=>$teacher_name,
                          'sche'=>$sche,
                          'ctype'=>$type,
                          'testtime'=>$testtime);
           $this->auto_arrange_model->insert_class($class);
     
           $this->auto_arrange_model->update_apply($apply,$id);
  //update apply
  //update classes
       }
         
	   }
     if (empty($_GET['crid'])){
        if(empty($_GET['pid']))
           $data['apply'] = $this->auto_arrange_model->get_application(1);
         else
           $data['apply'] = $this->auto_arrange_model->get_application($_GET['pid']);
    } 
     else {
     /*处理对申请的删除表单*/
      $this->auto_arrange_model->delete_application();
      if(empty($_GET['pid']))
           $data['apply'] = $this->auto_arrange_model->get_application(1);
      else
           $data['apply'] = $this->auto_arrange_model->get_application($_GET['pid']);
     }

     if(empty($_GET['pid']))
        $data['page']=1;
      else
        $data['page']=$_GET['pid'];
    if($data['page']<1)
        $data['page']=1;
     $this->load->view('r2/admin_auto_arrange',$data);
     $this->load->helper('url');
	}
}
