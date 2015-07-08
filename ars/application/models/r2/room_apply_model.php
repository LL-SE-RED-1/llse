<?php
class room_apply_model extends CI_Model{
	//获取对应教室的信息
	function test($classroom_id){
		$data = $this->db->query("select * from classroom where classroom_id = '$classroom_id'");
		//$row = mysqli_fetch_array($data);
		$row = $data->row_array();
		return $row;
	}
}
?>