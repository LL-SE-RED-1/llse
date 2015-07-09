<?php 
if (! defined('BASEPATH')) {
  exit('Access Denied');
}
?>
<?php
$this->load->helper('url');
?>


<!doctype html>
<html>
	
	
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <title>添加教室</title>
	    <link rel="icon" href="../../favicon.ico">
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
          <a class="navbar-brand">Project name</a></nav>
		<h1 class="page-header">添加教室</h1>
		<form action="add_classroom_form" method="post" id = "fo" class="col-xs-10 col-sm-6 placeholder">
			<!--教室类型-->
  			<p>教室类型: 
				<select class="form-control" name="type" onchange="__doPostBack('DropDownList1','')" language="javascript" id="DropDownList1" >
					<option value="0">多媒体</option>
					<option value="2">实验室</option>
					<option selected="selected" value="1">普通教室</option></select>
			<!--校区-->
				校区: <select class="form-control" name="campus" onchange="__doPostBack('DropDownList2','')" language="javascript" id="DropDownList2">
					<option value="4">华家池校区</option>
					<option value="2">玉泉校区</option>
					<option value="3">西溪校区</option>
					<option value="5">之江校区</option>
					<option selected="selected" value="1">紫金港校区</option></select></p>
			<!--教学楼-->
			<p>教学楼: <input type="text" name="building" class="form-control"/>
			<!--房间号-->
			房间号: <input type="int" name="room" class="form-control"/>
			<!--容量-->
  				容量: <input type="int" name="capacity" class="form-control"/></p>
  			<input type="submit" value="添加" class="btn btn-info"/>
  			<input type="reset" value="重置" class="btn btn-default"/>
		</form>
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo  base_url() ;?>application/views/static/js/jquery-2.0.0.min.js"></script>
    <script src="<?php echo  base_url() ;?>application/views/static/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="<?php echo  base_url() ;?>application/views/static/assets/js/vendor/holder.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo  base_url() ;?>application/views/static/assets/js/ie10-viewport-bug-workaround.js"></script>
	</body>
</html>