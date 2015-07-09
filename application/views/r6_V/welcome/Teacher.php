<html>

<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>在线考试系统</title>


    <!--link href="/css/bootstrap.min.css" rel="stylesheet"-->

    <link href="<?php echo base_url();?>css/r3/bootstrap.min.css" rel="stylesheet">

    <link href="<?php echo base_url();?>css/dashboard.css" rel="stylesheet">
    <?php $sid=3120000666;
          $tid='t00456';?> 

    <script> 
      function show(){ 
        var date = new Date(); //日期对象 
        var now = ""; 
        now = date.getFullYear()+"/"; //读英文就行了 
        now = now + (date.getMonth()+1)+"/"; //取月的时候取的是当前月-1如果想取当前月+1就可以了 
        now = now + date.getDate()+"    "; 
        now = now + date.getHours()+":"; 
        now = now + date.getMinutes()+":"; 
        now = now + date.getSeconds()+""; 
        document.getElementById("nowDiv").innerHTML = now; //div的html是now这个字符串 
        setTimeout("show()",1000); //设置过1000毫秒就是1秒，调用show方法 
      } 
    </script> 
    
    <script src="<?php echo base_url();?>js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap.min.js"></script> 
    <script src="<?php echo base_url();?>js/r3/holder.js"></script>
    
</head>
<body>
<?php
	$type = $this->session->userdata['user_type'];
	if ($type == 1){$uid = $this->session->userdata['sid'];}
	if ($type == 2){$uid = $this->session->userdata['tid'];}
?>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo site_url('llse_welcome');?>">教务管理系统</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="<?php site_url('ims/ims_welcome');?>"><?php echo $uid;?></a></li>
          <li><a href="<?php echo site_url('modify_pass');?>">修改密码</a></li>
          <?php if ($type == 1): ?>
            <li><a target="_blank" href="<?php echo base_url();?>metadata/student_help.html">帮助文档</a></li>
          <?php elseif ($type == 2): ?>
            <li><a target="_blank" href="<?php echo base_url();?>metadata/teacher_help.html">帮助文档</a></li>
          <?php elseif ($type == 3): ?>
            <li><a target="_blank" href="<?php echo base_url();?>metadata/manager_help.html">帮助文档</a></li>
          <?php elseif ($type == 4): ?>
            <li><a target="_blank" href="<?php echo base_url();?>metadata/admin_help.html">帮助文档</a></li>
          <?php elseif ($type == 5): ?>
            <li><a target="_blank" href="<?php echo base_url();?>metadata/colmanager_help.html">帮助文档</a></li>
          <?php else: ?>
            <li><a target="_blank" href="<?php echo base_url();?>metadata/assistant_help.html">帮助文档</a></li>
          <?php endif;?>
          <li><a href="<?php echo site_url('login');?>">注销</a></li>
        </ul>
      </div>
    </div>
  </nav>
	
		<div class="container-fluid">
		<div class="row">
		  <div class="col-sm-3 col-md-2 sidebar">
		   <ul class="nav nav-sidebar">
		   <li>
			  <a href="<?php echo site_url('ims/ims_welcome');?>">信息管理子系统</a>
		  </li>
		   <li>
			  <a href="<?php echo site_url('r2/admin_classroom_edit');?>">排课子系统</a>
		  </li>
		  <li>
			  <a href="<?php echo site_url('r3_student');?>">选课子系统</a>
		  </li>
		   <li>
			  <a href="<?php echo site_url('ims/ims_welcome');?>">课程资源子系统</a>
		  </li>
		  <li>
			  <a href="<?php echo site_url('r6_C/welcome/welc');?>">在线考试子系统</a>
		  </li>
		   <li>
			  <a href="<?php echo site_url('ims/ims_welcome');?>">成绩管理子系统</a>
		  </li>
		</ul>
		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="table-responsive">

<h1>在线测试-教师界面</h1>
<h3>题库管理</h3>
<form action='<?php echo site_url('r6_C/questions/create');?>' method='post'>
<input class="btn btn-default" type='submit' value='创建测试题'>
<br></form>
<form action='<?php echo site_url('r6_C/questions/index');?>' method='post'>
<input class="btn btn-default" type='submit' value='全部测试题'>
<br></form>
<form action='<?php echo site_url('r6_C/questions/view');?>' method='post'>
<input class="btn btn-default" type='submit' value='搜索测试题'>
<br></form><br>
<hr/>
<h3>试卷生成</h3>
<form action='<?php echo site_url('r6_C/paper/login');?>' method='post'>
<input class="btn btn-default" type='submit' value='试卷生成页'>
</form><br>
<hr/>
<h3>在线测试</h3>
<form action='<?php echo site_url('r6_C/onlinetesting/uptype');?>' method='post'>
<input class="btn btn-default" type='submit' value='考试管理页'>
</form><br>
<hr/>
<h3>成绩分析</h3>
<form action='<?php echo site_url('r6_C/ta_control/view');?>' method='post'>
<input class="btn btn-default" type='submit' value='教师成绩分析'>
</form><br>
<hr/>
&copy; 红六组-在线测试组
</body>

</html>
