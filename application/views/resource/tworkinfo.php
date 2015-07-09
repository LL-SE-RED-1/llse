<?php
//requirement:
//homeworkid, homeworkname, starttime, endtime, relavant files(array of name and fileid), uploadedfile(fileid, filename), uploadtime, score, comment;
//studentid, studentname
//其他接口要求：downloadFile(fileid);
//						 uploadFIle(homeworkid, teacherid, **************************)
//						 updatehomework_student(homeworkid, studentid, score, comment);
//domainname/controller/func/homeworkid/studentid;
?>

<?php include "templates/cheader.php"?>
<style>		
input[type="text"], textarea{
	width:250px;
}
.alert{
	display:inline-block;
	padding:2px;
	margin-left:1em;
	margin-bottom:0;
}
</style>
<div class="m-cont">
	<h2><?=$work["name"]?></h2>
	<form action="get">
	<table class="table table-striped">
	<col width="25%"><col width="75%">
	<tr><th>学生姓名</th><td><?=$work["stuname"]?></td></tr>
	<tr><th>开始时间</th><td><?=$work["starttime"]?></td></tr>
	<tr><th>结束时间</th><td><?=$work["endtime"]?></td></tr>
	<tr><th>相关资料</th>
	<td>
		<?php foreach($work["related"] as $item):?>
		<div class="deletable-file">
			<a href="<?=site_url($urlprefix."/downloadfile/".$item[1]."/".$item[0]);?>"><?=$item[0]?></a>
			<span class="glyphicon glyphicon-remove" title="删除"></span>
		</div>
		<?php endforeach; ?></td>
			</tr>
	<tr><th>详细信息</th><td><?=$work["detail"]?></td></tr>
	<tr><th>上传时间</th><td><?=$work["upload"]["time"]?></td></tr>
	<tr><th>上传作业</th><td>
		<?php if($work["upload"]["file"]):?>
		<div class="downloadable-file" title="<?=$work["upload"]["file"]?>">
			<a href="<?=site_url($urlprefix."/downloadstudenthomework/".$studentid."/".$homeworkid);?>">
			<?=$work["upload"]["file"]?></a>
		</div></td></tr>
		<?php endif;?>
	<tr><th>作业得分</th><td><input type="text" value="<?=$work["score"]?>" name="score"></td></tr>
	<tr><th>老师评语</th><td><textarea name="comment" id="" cols="30" rows="5"><?=$work["comment"]?></textarea></td></tr>
	</table><button type="submit" id="submit-btn" class="btn btn-warning">提交</button>
	</form>
</div>
<script>
	$("#submit-btn").on("click", function(evt){
		$(".alert").remove();
		if (!isValidScore($("input[name='score']").val())){
			$("input[name='score']").after(alertMessage("得分应该在0-100之间"));
			return false;
		}
		makeToast();
		evt.preventDefault();
		$.post("<?=site_url($urlprefix."/addingscore/".$studentid."/".$homeworkid);?>",
			$("form").serialize() + "&studentid=<?=$studentid?>"
				+ "&homeworkid=<?=$homeworkid?>",
			function(data, textStatus, jqXHR){
				if (data === "success")
				showToast("提交成功", function(){
					location.href = "<?=site_url($urlprefix."/studentlist/".$homeworkid);?>";
				});
				else
					showToast("提交失败");
			});
		$(document).ajaxError(function(evt, jqXHR){
			showToast("提交失败");
		});
		
	});
</script>
<?php include "templates/footer.php"?>
