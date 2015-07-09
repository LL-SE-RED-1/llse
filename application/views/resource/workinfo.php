<?php
//requirement:
//homeworkid, name, starttime, endtime, relavant([name fileid), uploadedfile(fileid, filename), uploadtime, score, comment;

//其他接口要求：downloadhomeworkfile(fileid, homeworkid);
//						 uploadstudenthomework(homeworkid)
?>
<?php include "templates/cheader.php"?>
<style>		
input[type="text"], textarea{
	width:250px;
}
</style>
<div class="m-cont">
	<h2><?=$work["name"]?></h2>
	<table class="table table-striped">
	<col width="25%"><col width="75%">
	<tbody>
	<tr><th>开始时间</th><td><?=$work["starttime"]?></td></tr>
	<tr><th>结束时间</th><td><?=$work["endtime"]?></td></tr>
	<tr><th>相关资料</th><td><?php foreach($work["relavant"] as $item):?> <div class="downloadable-file"><a href="<?=site_url($urlprefix."/downloadhomeworkfile/".$item[1]."/".$homeworkid);?>"><?=$item[0]?></a></div><?php endforeach; ?></td></tr>
	<tr><th>详细信息</th><td><?=$work["detail"]?></td></tr>
	<tr><th>上传时间</th><td>
	<?php if(isset($work["uploadedfile"]["fileid"])):?>
		<?=$work["uploadtime"]?>
	<?php else:?>
		未上传
	<?php endif;?>
	</td></tr>
	<tr><th>上传作业</th><td>
		<?php if(isset($work["uploadedfile"]["fileid"])):?>
		<div class="downloadable-file"><a href="<?=site_url($urlprefix."/downloadstudenthomework/".$studentid."/".$homeworkid)?>" title="<?=$work["uploadedfile"]["filename"]?>"><?=$work["uploadedfile"]["filename"]?></a></div>
		<?php endif;?>	
		<?php if (!$work["toolate"]):?>
		<label for="in-fileupload" class="btn btn-success">上传文件</label>
		<?php else: ?>
		<label for="in-fileupload" class="btn btn-danger disabled">上传文件</label>
		<?php endif;?>
	</td>
	<tr><th>作业得分</th><td><?=$work["score"]?></td></tr>
	<tr><th>老师评语</th><td><?=$work["comment"]?></td></tr>
	</tbody>
	</table>
	<script>
		$(document).ready(function(){
			uploaderInit({
				desfunc:"<?=site_url($urlprefix."/uploadstudenthomework");?>",
				onloaded:function(){
					location.reload();
				},
				appendData:function(data){
					data.append("homeworkid", '<?=$homeworkid?>');
				}
			})
		});
	</script>
</div>
<?php include "templates/footer.php"?>
