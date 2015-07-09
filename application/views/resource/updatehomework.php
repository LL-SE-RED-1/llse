<?php
//requirement
//courseid. homeworkid, name, starttime, endtime, files((name, id)), detail);
//接口要求: update_homework(courseid, homeworkid, name, starttime, endtime, fileids(array), detail);
//				 uploadFile(************) 返回文件id和名称

?>
<?php include "templates/cheader.php"?>
<div class="m-cont">
	<form action="post" class="input-group-sm">
	<table class="table table-striped">
	<tr><th>作业名称</th><td><input type="text" name="name"></td></tr>
	<tr><th>开始时间</th><td><input type="text" name="starttime"></td></tr>
	<tr><th>结束时间</th><td><input type="text" name="endtime"></td></tr>
	<tr><th>相关资料</th><td><label for="in-fileupload" class="btn btn-success">上传文件</label></td></tr>
	<tr><th>详细信息</th><td><textarea name="detail" id="" cols="30" rows="10"></textarea></td></tr>
	</table>
	<button type="submit" class="btn btn-warning">提交</button>
	<form action="post" class="input-group-sm">
</div>
<?php include "templates/footer.php"?>
