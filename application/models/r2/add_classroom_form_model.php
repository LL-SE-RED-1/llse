<?php
class add_classroom_form_model extends CI_Model{
	function test(){	//显示信息：调试使用
		echo $_POST["type"];
		echo $_POST["campus"];
		echo $_POST["building"];
		echo $_POST["room"];
		echo $_POST["capacity"];
	}
	function typecheck(){	//类型判断
		$result = 0;
		if(strlen($_POST["building"]) > 15 || !(strlen($_POST["building"]) > 0)){
			$result = 1;
		}
		//教学楼长度在15之内
		else if(!is_int($_POST["room"] + 0)){
			$result = 2;
		}
		//房间号位整数
		else if(!(strlen($_POST["room"]) > 0)){
			$result = 2;
		}
		else if(!(strlen($_POST["capacity"]) > 0) ||!is_int($_POST["capacity"] + 0)){
			$result = 3;
		}
		//容量为整数
		return $result;
	}
	function addtodatabase(){	//添加新教室信息
		$result = $this->db->query("insert into classroom (campus,building,room,capacity,type) 
			values('$_POST[campus]','$_POST[building]','$_POST[room]','$_POST[capacity]','$_POST[type]')");
		$data = $this->db->query("select * from classroom where campus = '$_POST[campus]' and building = '$_POST[building]' and room = '$_POST[room]'");
		$data = $data->row_array();
		$id = $data["classroom_id"];
		$result = $this->db->query("insert into room_sche(classroom_id,M,T,W,TH,F) values('$id',255,255,255,255,255)");
		return $result;
	}
	function applydatabase(){	//修改教室信息
		$result = $this->db->query("delete from classroom where classroom_id = $_POST[classroom_id]");
		$result = $this->db->query("insert into classroom (classroom_id,campus,building,room,capacity,type) 
			values('$_POST[classroom_id]','$_POST[campus]','$_POST[building]','$_POST[room]','$_POST[capacity]','$_POST[type]')");
		
		return $result;
	}
}
?>