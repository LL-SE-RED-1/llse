<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>资源共享</title>
	<link rel="stylesheet" href="<?=base_url()?>css/resource/bootstrap.min.css">
	<link rel="stylesheet" href="<?=base_url()?>css/resource/global.css">
	<script src="<?=base_url()?>js/resource/jquery-2.1.4.min.js"></script>
	<script src="<?=base_url()?>js/resource/bootstrap.min.js"></script>
</head>
<body>	
<div class="m-message">
	<style>
		.m-message{
			position:absolute;
			left:0;
			top:0;
			z-index:1000;
		}
	</style>
	<a class="btn btn-warning" type="button" href="<?=site_url("student/alertundonelist");?>">
	  未完成 <span class="badge u-undone"></span>
	</a>
	<a class="btn btn-primary" type="button" href="<?=site_url("student/alertunknownlist");?>">
  	新布置 <span class="badge u-unknown"></span>
	</a>
	<script>
	$.get(
		"<?=site_url("resource/student/gethomeworkstatus/");?>",
		null, 
		function(data){
			data = JSON.parse(data);
			console.log(data);
			$(".m-message .u-undone").text(data["undone"]);
			if (data["undone"] === 0)
				$(".m-message .u-undone").parent().remove();
			$(".m-message .u-unknown").text(data["unknown"]);
			if (data["undone"] === 0)
				$(".m-message .u-unknown").parent().remove();
		}
	);
	</script>
</div>
</body>
</html>
