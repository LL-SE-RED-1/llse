<?php
//作业列表(homeworkid, homeworkname, coursename, courseid, starttime, endtime, related(filename, fileid, homeworkid))
?>
<?php include "templates/header.php"?>
<div class="m-cont">
	<style>
		.m-thead{
			top:0px;
		}
		.m-tmain{
			top:40px;
		}
	</style>
	<div class="m-thead">
    <div class="col-xs-2">作业名称</div>
		<div class="col-xs-2">布置课程</div>
    <div class="col-xs-2">开始时间</div>
    <div class="col-xs-2">截止时间</div>
		<div class="col-xs-4">相关资料</div>
  </div>
  <div class="m-tmain">
    <div class="m-tbody table-striped">
  	<?php $i = 0;foreach($work as $item): $i++;?>
			<div class="row" data-homeworkid="<?=$item["homeworkid"]?>">
        <div class="col-xs-2">
					<a href="<?=site_url($urlprefix."/homeworklist/".$item["courseid"])."#".$item["homeworkid"]?>"><?=$item["homeworkname"]?></a>
				</div>
				<div class="col-xs-2">
					<?=$item["coursename"]?>
				</div>
        <div class="col-xs-2"><?=$item["starttime"]?></div>
        <div class="col-xs-2"><?=$item["endtime"]?></div>
        <div class="col-xs-4">
				<?php foreach($item["relavant"] as $related):?>
					<div class="downloadable-file" title="<?=$related["filename"]?>">
						<a href="<?=site_url($urlprefix."/downloadhomeworkfile/".$related["fileid"]."/".$item["homeworkid"])?>"><?=$related["filename"]?></a>
					</div>
				<?php endforeach;?>
				</div>
      </div>
	  <?php endforeach ?>
    </div>
	</div>
</div>
	
<div class="m-message">
	<style>
		.m-message{
			position:fixed;
			left:0;
			top:0;
			z-index:1000;
		}
	</style>
	<a class="btn btn-warning" style="display:none" type="button" href="<?=site_url("student/alertundonelist");?>">
	  未完成 <span class="badge u-undone"></span>
	</a>
	<a class="btn btn-primary" style="display:none" type="button" href="<?=site_url("student/alertunknownlist");?>">
  	新布置 <span class="badge u-unknown" ></span>
	</a>
	<script>
	$.get(
		"<?=site_url("student/gethomeworkstatus/");?>",
		null, 
		function(data){
			data = JSON.parse(data);
			console.log(data);
			$(".m-message .u-undone").text(data["undone"]);
			if (data["undone"] === 0)
				$(".m-message .u-undone").parent().remove();
			else 
				$(".m-message .u-undone").parent().css("display", "block");
			$(".m-message .u-unknown").text(data["unknown"]);
			if (data["unknown"] === 0)
				$(".m-message .u-unknown").parent().remove();
			else
				$(".m-message .u-unknown").parent().css("display", "block");
		}
	);
	</script>
</div>
<body>
