<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html>
<title>添加教室</title>
<h1>lsl</h1>
<a href = "javascript:GouMai();">nihao</a>
<script> 
	function GouMai(){ 
		window.open("lsl", "newwindows", "dialogWidth:200px; dialogHeight:200px; status:no; scroll:yes;help:no;resiable:no"); 
		} 
</script>
<h1>teacher</h1>
<a href = "javascript:GouMa();">nihao</a>
<script> 
	function GouMa(){ 
		window.open("teacher", "newwindows", "dialogWidth:200px; dialogHeight:200px; status:no; scroll:yes;help:no;resiable:no"); 
		} 
</script>
<h1>修改教室</h1>
<form action="room_apply" target="a" method="post">
class_id: <input type="int" name="classroom_id" class="form-control"/>
<input type="submit" value="添加" class="btn btn-info"/>
</form>

<script> 
	function GouM(){ 
		window.open("room_apply", "newwindows", "dialogWidth:200px; dialogHeight:200px; status:no; scroll:yes;help:no;resiable:no").focus(); 
		}
</script>
<h1>修改课程</h1>
<form action="apply_teacher" target="a" method="get">
class_id: <input type="int" name="class_id" class="form-control"/>
<input type="submit" value="添加" class="btn btn-info"/>
</form>
</html>
