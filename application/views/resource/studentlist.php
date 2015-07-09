<?php
//requirement
//studentlist(name, studentid, student_number, finish_status);
//homeworkid
//domainname/teacher/studentlist/homeworkid/分页变量

?>
<?php include "templates/cheader.php"?>
<?php 
$mmap = array(
	STATUS_UNDONE => "bg-danger",
	STATUS_UNSCORED => "bg-warning",
	STATUS_SCORED => "bg-success"	
);
?>
<style>
	
.m-student{
	float: left;
	min-height: 50px;
	width: 14.2%;
}
.m-student-info{
	color:#333;
	text-align: center;
	margin: 5px;
	padding: 5px;
}
.m-student-info:hover{
	background-color: #aaa;
}
.m-student a{
	text-decoration: none;
}

</style>
<div class="m-cont">
	<div class="m-main">
<?php foreach ($data as $item):?>
	<div class="m-student">
		<a href="<?=site_url($urlprefix."/workinfo/".$item["stuid"]."/".$item["hwid"])?>">
			<div class="m-student-info <?=$mmap[$item["status"]]?>">
				<h4><?=$item["name"];?></h4>
				<p><?=$item["number"];?></p>
				<p><?=$item["score"];?></p>
			</div>
		</a>
	</div>
<?php endforeach; ?>
	</div>
  <div class="m-page">
    <?php include "templates/page.php"?>
  </div>
</div>
<?php include "templates/footer.php"?>
