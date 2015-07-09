<?php
//require 文件列表(id, name, semester(字串), [teacher_name]如果用户是老师则不用)
?>
<?php include "templates/header.php"?>
<div class="m-cont">
  <style>
    .m-course{
    	float: left;

      <?php if($role != "teacher"):?>
    	min-height: 100px;
      <?php else: ?>
        min-height: 80px;
      <?php endif;?>
    	width: 25%;
    }
    .m-course-info{
    	color:#fff;
    	text-align: center;
      <?php if($role != "teacher"):?>
    	height: 143px;
      <?php else: ?>
        height: 123px;
      <?php endif;?>
    	margin: 10px;
    	padding: 10px;
    	background-color: #666;
    }
    .m-course a{
    	text-decoration: none;
    }
    
    .m-course-info:hover{
    	background-color: #aaa;
    }
    .m-course-info>h2{
        margin-top:10px;
    }
  </style>
  <div class="m-main">
  <?php if (count($data)):?>
  <?php foreach ($data as $item):?>
  	<div class="m-course">
  		<a href="<?=site_url($urlprefix."/filelist_all/".$item["courseid"])?>">
  			<div class="m-course-info">
  				<h2><?=$item["name"];?></h2>
  				<p><?=$terms[$item["term"]];?></p>
          <?php if($role != "teacher"):?>
  				<p><?=$item["teacher"]?></p>
          <?php endif?>
  			</div>
  		</a>
  	</div>
  <?php endforeach; ?>
  <?php else:?>
    <h2 style="text-align:center;position:absolute;top:40%;left:40%">当前学期没有课程</h2>
  <?php endif?>
  </div>
  <div class="m-page">
  <?php include "templates/page.php"?>
  </div>
</div>
<?php include "templates/footer.php"?>
