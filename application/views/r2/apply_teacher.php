<?php 
if (! defined('BASEPATH')) {
  exit('Access Denied');
}
?>
<?php
$this->load->helper('url');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Dashboard Template for Bootstrap</title>
    
    <!-- Bootstrap core CSS -->
    <link href="<?php echo  base_url() ;?>application/views/static/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo  base_url() ;?>application/views/static/css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?php echo  base_url() ;?>application/views/static/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo site_url('llse_welcome');?>">教务管理系统</a>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Reports</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Export</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item</a></li>
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
            <li><a href="">More navigation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul>
        </div>
        
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">陈越姥姥，您好！欢迎进入自动排课子系统</h1>
			<ul class="nav nav-tabs">
				<li role="presentation"><a href="add_teacher">创建教学班</a></li>
  				<li role="presentation" class="active"><a href="apply_teacher">调整申请</a></li>
			</ul> 
			<br>

          <div class="table-responsive">
			   <form class="form-horizontal" action="menu_teacher" method="post">
					<div class="form-group">
						<label for="classid" class="col-sm-2 control-label">教学班ID</label>
						<label for="classid" class="col-sm-1 control-label">123</label>
						<label for="classname" class="col-sm-3 control-label">课程ID</label>
						<label for="classname" class="col-sm-1 control-label">10086</label>
					</div>
					<div class="form-group">
						<label for="classname" class="col-sm-2 control-label">课程名</label>
						<label for="classname" class="col-sm-1 control-label">微积分</label>
						<label for="classname" class="col-sm-3 control-label">上课校区</label>
						<label for="classname" class="col-sm-1 control-label">玉泉</label>
					</div>
					<div class="form-group">
						<label for="classname" class="col-sm-2 control-label">学年</label>
						<label for="classname" class="col-sm-1 control-label">2015-2016</label>
						<label for="classname" class="col-sm-3 control-label">学期</label>
						<label for="classname" class="col-sm-1 control-label">春夏</label>
					</div>
					<div class="form-group">
						<label for="classname" class="col-sm-2 control-label">上课时间</label>
						<label for="classname" class="col-sm-1 control-label">周二 9、10</label>
						<label for="classname" class="col-sm-3 control-label">上课地点</label>
						<label for="classname" class="col-sm-1 control-label">曹西101</label>
					</div>

					<br><hr>
					<div class="form-group">
						<label for="stuid" class="col-sm-2 control-label">调整意见</label>
					</div>
					<div class="form-group">
						<label for="stuid" class="col-sm-2 control-label"></label>
						<div class="col-sm-5">
							<textarea class="form-control" rows="10" cols="30" id="stuid" name="stuid" required="" autofocus=""></textarea>
							<label for="stuid" class="col-sm-12 control-label"><center>请输入不超过100个字</center></label>
						</div>
					</div>
					<div class="form-group">
						<label for="stuid" class="col-sm-6 control-label"></label>
						<div class="col-sm-6">
							<button type="submit" class="btn btn-default">提交</button>
						</div>
					</div>
					<div class="form-group">
						<label for="stuid" class="col-sm-6 control-label"></label>
					</div>
					<div class="form-group">
						<label for="stuid" class="col-sm-6 control-label"></label>
					</div>
					<div class="form-group">
						<label for="stuid" class="col-sm-6 control-label"></label>
					</div>
					<div class="form-group">
						<label for="stuid" class="col-sm-6 control-label"></label>
					</div>
					<div class="form-group">
						<label for="stuid" class="col-sm-6 control-label"></label>
					</div>
				</form>
          </div>
        </div>
				
				
				

      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo  base_url() ;?>application/views/static/assets/js/jquery-2.0.0.min.js"></script>
    <script src="<?php echo  base_url() ;?>application/views/static/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="<?php echo  base_url() ;?>application/views/static/assets/js/vendor/holder.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo  base_url() ;?>application/views/static/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
