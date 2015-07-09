<?php
//require
//$role 用户的身份， "teacher" or "student"
?>

<style>
	.m-nav-wrap{
		margin-top:10px;
		border-bottom: 1px solid #ddd;
		position:absolute;
		top:0px;
		height:42px;
		left:0px;
		right:0px;
	}
	.m-nav-wrap::after{
		content:".";
		visibility:hidden;
		height:0;
		clear:both;
		display:block;
	}
	.m-nav{
		float:left;
	}
	.input-div{
		margin-top:5px;
		float:right;
	}
	.nav-tabs{
		  border-bottom: 0;
	}
	
</style>
<div class="m-nav-wrap">
	<div class="m-nav">
		<ul class="nav nav-tabs">
		  <li role="presentation" id="all" <?php if ($this->uri->segment(3) == 'filelist_all'):?>class="active" <?php endif;?>><a href="<?=site_url($urlprefix."/filelist_all/".$courseid)?>">全部</a></li>
		  <li role="presentation" id="tch" <?php if ($this->uri->segment(3) == 'filelist_teacher'):?>class="active" <?php endif;?>><a href="<?=site_url($urlprefix."/filelist_teacher/".$courseid)?>">课件</a></li>
		  <li role="presentation" id="stu" <?php if ($this->uri->segment(3) == 'filelist_student'):?>class="active" <?php endif;?>><a href="<?=site_url($urlprefix."/filelist_student/".$courseid)?>">学生分享</a></li>
		  <li role="presentation" id="hwk" <?php if ($this->uri->segment(3) == 'homeworklist'):?>class="active" <?php endif;?>><a href="<?=site_url($urlprefix."/homeworklist/".$courseid)?>">作业</a></li>
		</ul>
	</div>
	<?php if ($this->uri->segment(3) == "filelist_all" || $this->uri->segment(3) == "filelist_student"
		&& $role == "student" || $this->uri->segment(3) == "filelist_teacher" && $role == "teacher"):?>
	<div id="input-file" class="input-div">
	<label for="in-fileupload" class="btn btn-success">上传文件</label>
  </div>
	<?php endif; ?>
	<?php if ($this->uri->segment(3) == "homeworklist" && $role == "teacher"): ?>
	<div id="add-work" class="input-div">
		<form>
	    <button type="button" class="btn btn-success" onclick="location.href='<?=site_url($urlprefix."/addhomework/".$courseid)?>'">添加作业</button>
		</form>
     </div>
	<?php endif; ?>
</div>
