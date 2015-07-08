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
	    <title>教师调整教学班信息处理</title>
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
		<h1 class="page-header">教师调整教学班信息处理</h1>
		<form action="apply_class" method="post" id = "fo" class="col-xs-10 col-sm-6 placeholder">
			教学班id: 
				<input type="text" name="class_id" value = "<?php echo $class_id;?>" class="form-control" readonly/>
			课程id: 
				<input type="text" name="course_id" value = "<?php echo $course_id;?>" class="form-control" readonly/>
			课程名:
				<input type="text" name="course_name" value = "<?php echo $course_name;?>" class="form-control" readonly/>
			教师id: 
				<input type="text" name="teacher_id" value = "<?php echo $teacher_id;?>" class="form-control" readonly/>
			教师名: 
				<input type="text" name="teacher_name" value = "<?php echo $teacher_name;?>" class="form-control" readonly/>
			学年: 
				<input type="text" name="year" value = "<?php echo $year;?>" class="form-control" readonly/>
			学期:
				<select class="form-control" name="season" value = "<?php echo $season;?>" onchange="__doPostBack('DropDownList1','')" language="javascript" id="DropDownList1" class="HideOnPrint" disabled>
					<option selected="selected" value="1">秋冬学期</option>
					<option selected="selected" value="2">春夏学期</option></select>
			
  			<p>
				校区: <select class="form-control" name="campus" value = "<?php echo $campus;?>" onchange="__doPostBack('DropDownList1','')" language="javascript" id="DropDownList1" class="HideOnPrint" disabled>
					<option value="4" <?php if($campus == 4) echo "selected = selected"?> >华家池校区</option>
					<option value="2" <?php if($campus == 2) echo "selected = selected"?>>玉泉校区</option>
					<option value="3" <?php if($campus == 3) echo "selected = selected"?>>西溪校区</option>
					<option value="5" <?php if($campus == 5) echo "selected = selected"?>>之江校区</option>
					<option value="1" <?php if($campus == 1) echo "selected = selected"?>>紫金港校区</option></select></p>
					<?php for($i = 1; $i < count($sche); $i ++){ ?>
				第<?php echo $i ?>节课<br>
				教室id: 
				<input type="text" name="classroom_id_<?php echo $i ?>" value = "<?php $c_room = $classroom[$i]; echo $c_room['classroom_id'];?>" class="form-control" readonly/>
				容量: 
				<input type="int" name="capacity_<?php echo $i ?>" value = "<?php echo $c_room['capacity'];?>" class="form-control" readonly/>
				教学楼:
					<input type="text" name="building_<?php echo $i ?>" value = "<?php  echo $c_room['building'];?>" class="form-control"/>
				房间号: 
					<input type="int" name="room_<?php echo $i ?>" value = "<?php echo $c_room['room'];?>" class="form-control"/>
				时间: <select class="form-control" name="weekday_<?php echo $i ?>" value = "<?php echo $sche[$i][0]; ?>" onchange="__doPostBack('DropDownList1','')" language="javascript" id="DropDownList1" class="HideOnPrint">
					<option value="2" <?php if($sche[$i][0] == 2) echo "selected = selected"?>>周二</option>
					<option value="3" <?php if($sche[$i][0] == 3) echo "selected = selected"?>>周三</option>
					<option value="4" <?php if($sche[$i][0] == 4) echo "selected = selected"?>>周四</option>
					<option value="5" <?php if($sche[$i][0] == 5) echo "selected = selected"?>>周五</option>
					<option value="1" <?php if($sche[$i][0] == 1) echo "selected = selected"?>>周一</option></select>
					<select class="form-control" name="classnum_<?php echo $i ?>" value = "<?php echo substr($sche[$i], 1);?>" onchange="__doPostBack('DropDownList1','')" language="javascript" id="DropDownList1" class="HideOnPrint">
					<option value="0011000000000" <?php if(substr($sche[$i], 1) == "0011000000000") echo "selected = selected"?>>3/4</option>
					<option value="0011100000000" <?php if(substr($sche[$i], 1) == "0011100000000") echo "selected = selected"?>>3/4/5</option>
					<option value="0000011100000" <?php if(substr($sche[$i], 1) == "0000011100000") echo "selected = selected"?>>6/7/8</option>
					<option value="0000001100000" <?php if(substr($sche[$i], 1) == "0000001100000") echo "selected = selected"?>>7/8</option>
					<option value="0000000011000" <?php if(substr($sche[$i], 1) == "0000000011000") echo "selected = selected"?>>9/10</option>
					<option value="0000000000110" <?php if(substr($sche[$i], 1) == "0000000000110") echo "selected = selected"?>>11/12</option>
					<option value="0000000000111" <?php if(substr($sche[$i], 1) == "0000000000111") echo "selected = selected"?>>11/12/13</option>
					<option value="1100000000000" <?php if(substr($sche[$i], 1) == "1100000000000") echo "selected = selected"?>>1/2</option></select>
  					<?php }?>
  		请求内容：
  			<input type="text" name="text" value = "<?php echo $text;?>" class="form-control"/>
  			<input type="submit" value="添加" class="btn btn-info"/>
  			<input type="reset" value="取消" class="btn btn-default"/>
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