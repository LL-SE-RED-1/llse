<?php
class apply_teacher_model extends CI_Model{
	function test($id){	//获取对应教学班信息
		$data = $this->db->query("select * from man_apply natural join classes where class_id = '$id'");
		//$row = mysqli_fetch_array($data);
		$row = $data->row_array();
		$classroom = $row['classroom'];
		$sche = $row['sche'];
		$classrooms = explode(';', $classroom);
		$count = count($classrooms);
		//echo "<script>alert('$count')</script>";
		for($i=1;$i<$count;$i ++){
			$id = $classrooms[$i];
			//echo "<script>alert('$id')</script>";
			$data = $this->db->query("select * from classroom where classroom_id = $id");
			$classrooms[$i] = $data->row_array();
			//$classroom_rooms[$i] = $data['classroom_name'];
			//$classroom_buildings[$i] = $data['building'];
		}
				
		$sches = explode(';', $sche);
		$row['sche'] = $sches;
		$row['classroom'] = $classrooms;
		//$classroom = $row['classroom'];
		//$classroom = $classroom[1];
		//echo "<script>alert('$classroom[classnum]')</script>";
		return $row;
	}
	function check($data){
		$sche = $data['sche'];
		$count = count($sche);
		$result = 0;
		for($i = 1; $i < $count; $i ++){
			$building = "building_" . $i;
			
			$building = $_POST[$building];
			$room = "room_" . $i;
			$room = $_POST[$room];
			$classroom_id = $this->db->query("select classroom_id from classroom where campus = $data[campus] and building = '$building' and room = $room");
			$classroom_id = $classroom_id->row_array();	//获取新修改教室内容的教室id
			$time = 0;
			//echo "<script>alert('$classroom_id[classroom_id]')</script>";
			//echo "<script>alert('$data[classroom_id]')</script>";
			$classnum = $_POST["classnum_" . $i];
			switch ($classnum) { //对应表格时间的时间类型转换
			      case "1100000000000":
			        $time = 128;
			        break;

			      case "0011000000000":
			        $time = 64;
			        break;

			      case "0011100000000":
			        $time = 32;
			        break;   

			      case "0000011100000":
			        $time = 16;
			        break; 

			      case "0000001100000":
			        $time = 8;
			        break;  

			      case "0000000011000":
			        $time = 4;
			        break;

			      case "0000000000110":
			        $time = 2;
			        break;

			      case "0000000000111":
			        $time = 1;
			        break;

			      default:
			        # code...
			        break;
					}
			$sss = "M";
			$weekday = $_POST["weekday_" . $i];
			switch($weekday){
				case 1:
					$sss = "M";
					break;
				case 2:
					$sss = "T";
					break;
				case 3:
					$sss = "W";
					break;
				case 4:
					$sss = "TH";
					break;
				case 5:
					$sss = "F";
					break;
			}
			$classroom = $data['classroom'];
			$classroom = $classroom[$i];
			//echo "<script>alert('id : $classroom[classroom_id]')</script>";
			//echo "<script>alert('classnum : $classroom[classnum]')</script>";
			//echo "<script>alert('weekday: $classroom[weekday]')</script>";
			$sche = $data['sche'];
			$sche = $sche[$i];
			if(!$classroom_id)	//教室是否存在
				$result = 1;	//错误
			else if(($classroom_id['classroom_id'] !=  $classroom['classroom_id'])|| ($classnum != substr($sche,1)) || ($weekday != $sche[0])){
					//教室是否变更，该教室这个时间段是否有时间
	   				$time_check2 = $this->db->query("select * from room_sche where classroom_id = $classroom_id[classroom_id]");
	   				$time_check2 = $time_check2->row_array();
	   				$time2 = $time_check2[$sss];
	   				if(!($time2 & 64) && ($time2 & 32))
	   						$time2 = $time2 - 32;
	   				else if(($time2 & 64) && !($time2 & 32))
	   						$time2 = $time2 - 64;
	   				if(!($time2 & 16) && ($time2 & 8))
	   						$time2 = $time2 - 8;
	   				else if(($time2 & 16) && !($time2 & 8))
	   						$time2 = $time2 - 16;
	   				if(!($time2 & 2) && ($time2 & 1))
	   						$time2 = $time2 - 1;
	   				else if(($time2 & 2) && !($time2 & 1))
	   						$time2 = $time2 - 2;
	   				if(($time & $time2) == 0)
	   					$result = 3;
				}
			if(($classnum != substr($sche,1)) || ($weekday != $sche[0])){
				//老师这个时间段是否有时间
				$time_check1 = $this->db->query("select * from teach_sche where teacher_id = $_POST[teacher_id]");
				$time_check1 = $time_check1->row_array();
				$time2 = $time_check1[$sss];
				if(!($time2 & 64) && ($time2 & 32))
						$time2 = $time2 - 32;
				else if(($time2 & 64) && !($time2 & 32))
						$time2 = $time2 - 64;
				if(!($time2 & 16) && ($time2 & 8))
						$time2 = $time2 - 8;
				else if(($time2 & 16) && !($time2 & 8))
						$time2 = $time2 - 16;
				if(!($time2 & 2) && ($time2 & 1))
						$time2 = $time2 - 1;
				else if(($time2 & 2) && !($time2 & 1))
						$time2 = $time2 - 2;
				if(($time & $time2) == 0)
	   					$result = 2;
			}
		}
		
		return $result;
	}
	function change($data){
			$sche = $data['sche'];
			$count = count($sche);
			$position = "";
			$times = "";
			for($i=1;$i<$count;$i ++){
				$class_time1 = 0;
				$building = "building_" . $i;
			
				$building = $_POST[$building];
				$room = "room_" . $i;
				$room = $_POST[$room];
				$classroom_id = $this->db->query("select classroom_id from classroom where campus = $data[campus] and building = '$building' and room = $room");
				$classroom_id = $classroom_id->row_array();	//获取新修改教室内容的教室id
				$classroom_id = $classroom_id['classroom_id'];
				$classroom = $data['classroom'];
				$classroom = $classroom[$i];
				$sche = $data['sche'];
				$sche = $sche[$i];
				switch ($_POST["classnum_" . $i]) {	//对应表格时间的时间类型转换
					      case "1100000000000":
					        $class_time1 = 128;
					        break;

					      case "0011000000000":
					        $class_time1 = 64;
					        break;

					      case "0011100000000":
					        $class_time1 = 32;
					        break;   

					      case "0000011100000":
					        $class_time1 = 16;
					        break; 

					      case "0000001100000":
					        $class_time1 = 8;
					        break;  

					      case "0000000011000":
					        $class_time1 = 4;
					        break;

					      case "0000000000110":
					        $class_time1 = 2;
					        break;

					      case "0000000000111":
					        $class_time1 = 1;
					        break;

					      default:
					        # code...
					        break;
	   					}
	   			$class_time2 = 0;
	   			switch (substr($sche,1)) {	//对应表格时间的时间类型转换
					      case "1100000000000":
					        $class_time2 = 128;
					        break;

					      case "0011000000000":
					        $class_time2 = 64;
					        break;

					      case "0011100000000":
					        $class_time2 = 32;
					        break;   

					      case "0000011100000":
					        $class_time2 = 16;
					        break; 

					      case "0000001100000":
					        $class_time2 = 8;
					        break;  

					      case "0000000011000":
					        $class_time2 = 4;
					        break;

					      case "0000000000110":
					        $class_time2 = 2;
					        break;

					      case "0000000000111":
					        $class_time2 = 1;
					        break;

					      default:
					        # code...
					        break;
	   					}
	   			switch($sche[0]){ //对教师时间安排表的更新
	   				case 1:
	   					$result = $this->db->query("update teach_sche set M = M + $class_time2 where teacher_id = $data[teacher_id]");
	   					$result = $this->db->query("update room_sche set M = M + $class_time2 where classroom_id = $classroom[classroom_id]");
	   					break;
	   				case 2:
	   					$result = $this->db->query("update teach_sche set T = T + $class_time2 where teacher_id = $data[teacher_id]");
	   					$result = $this->db->query("update room_sche set T = T + $class_time2 where classroom_id = $classroom[classroom_id]");
	   					break;
	   				case 3:
	   					$result = $this->db->query("update teach_sche set W = W + $class_time2 where teacher_id = $data[teacher_id]");
	   					$result = $this->db->query("update room_sche set W = W + $class_time2 where classroom_id = $classroom[classroom_id]");
	   					break;
	   				case 4:
	   					$result = $this->db->query("update teach_sche set TH = TH + $class_time2 where teacher_id = $data[teacher_id]");
	   					$result = $this->db->query("update room_sche set TH = TH + $class_time2 where classroom_id = $classroom[classroom_id]");
	   					break;
	   				case 5:
	   					$result = $this->db->query("update teach_sche set F = F + $class_time2 where teacher_id = $data[teacher_id]");
	   					$result = $this->db->query("update room_sche set F = F + $class_time2 where classroom_id = $classroom[classroom_id]");
	   					break;
	   			}
	   			switch($_POST["weekday_" . $i]){ //对教室时间安排表的更新
	   				case 1:
	   					$result = $this->db->query("update teach_sche set M = M - $class_time1 where teacher_id = $data[teacher_id]");
	   					$result = $this->db->query("update room_sche set M = M - $class_time1 where classroom_id = $classroom_id");
	   					break;
	   				case 2:
	   					$result = $this->db->query("update teach_sche set T = T - $class_time1 where teacher_id = $data[teacher_id]");
	   					$result = $this->db->query("update room_sche set T = T - $class_time1 where classroom_id = $classroom_id");
	   					break;
	   				case 3:
	   					$result = $this->db->query("update teach_sche set W = W - $class_time1 where teacher_id = $data[teacher_id]");
	   					$result = $this->db->query("update room_sche set W = W - $class_time1 where classroom_id = $classroom_id");
	   					break;
	   				case 4:
	   					$result = $this->db->query("update teach_sche set TH = TH - $class_time1 where teacher_id = $data[teacher_id]");
	   					$result = $this->db->query("update room_sche set TH = TH - $class_time1 where classroom_id = $classroom_id");
	   					break;
	   				case 5:
	   					$result = $this->db->query("update teach_sche set F = F - $class_time1 where teacher_id = $data[teacher_id]");
	   					$result = $this->db->query("update room_sche set F = F - $class_time1 where classroom_id = $classroom_id");
	   					break;
	   			}
	   			$position = $position . ";" . $classroom_id;
	   			$times = $times . ";" . $_POST["weekday_" . $i] . $_POST["classnum_" . $i]; 
	   			//对教学班内容更新
	   			
			}
				//$classroom_id = $this->db->query("select * from classroom where campus = $_POST[campus] and building = '$_POST[building]' and room = $_POST[room]");
	   			//$classroom_id = $classroom_id->row_array();
	   			$result = $this->db->query("update classes set classroom = '$position',sche = '$times' where class_id = $data[class_id]"); 
	   			$result = $this->db->query("update apply set state = 2 where class_id = $data[class_id]");
	   			//去除修改操作
	   			$result = $this->db->query("delete from man_apply where class_id = $data[class_id]");
   			return $result;
	}
}
?>