<?php
include "constant.php";
//require
//$year 学年
//$term 学期
//$course_detail 课程详情(名称)

$role = $roles[$role];
$urlprefix = "resource/$role";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>资源共享</title>
	<link rel="stylesheet" href="<?=base_url()?>css/resource/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>css/dashboard.css">
    <link rel="stylesheet" href="<?=base_url()?>dist/semantic.css">
	<link rel="stylesheet" href="<?=base_url()?>css/resource/global.css">
    <script src="<?=base_url()?>dist/semantic.js"></script>
	<script src="<?=base_url()?>js/resource/jquery-2.1.4.min.js"></script>
	<script src="<?=base_url()?>js/resource/bootstrap.min.js"></script>
	<script src="<?=base_url()?>js/resource/share.js"></script>
</head>
<body>
<?php include "application/views/template/navigator.php"; ?>
<?php include "application/views/llse_template/side_navi.php"; ?>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
<div class="m-wrap">
	<div class="m-head">
		<div><h1><a href="<?=site_url($urlprefix."/index/".$year."/".$term);?>">资源共享</a></h1></div>
		<div class="m-head-wrap">
			<div class="m-search">
				<div class="input-group">
          <span class="input-group-btn">
            <button id="search-btn" class="btn btn-primary btn-search" type="button"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
          </span>
          <input type="text" id="search-str" class="form-control" placeholder="Search">
        </div>
			</div>
			<div class="m-term">
				<h4><?=$course_name?></h4>
			</div>
			<div class="m-term">
				<h4><?=$terms[$term]."学期"?></h4>
			</div>
			<div class="m-term">
				<h4><?=year_format($year)."学年"?></h4>
			</div>
			
			<script>
			$("#search-btn").click(function(){
				location.href="<?=site_url($urlprefix."/search/".$year."/".$term)?>/" + $("#search-str").val();
			});
			$("#search-str").on("keydown", function(evt){
				if (evt.keyCode === 13){
					location.href="<?=site_url($urlprefix."/search/".$year."/".$term)?>/" + $("#search-str").val();
				}
			});
			</script>
		</div>
	</div>
