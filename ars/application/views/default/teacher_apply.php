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
    <meta charset="utf-8"><!--编码使用utf-8-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>自动排课子系统</title><!--页面标题-->
    
    <!-- Bootstrap core CSS -->
    <link href="<?php echo  base_url() ;?>application/views/static/css/bootstrap.min.css" rel="stylesheet"><!--css路径-->

    <!-- Custom styles for this template -->
    <link href="<?php echo  base_url() ;?>application/views/static/css/dashboard.css" rel="stylesheet"><!--css路径-->

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?php echo  base_url() ;?>application/views/static/assets/js/ie-emulation-modes-warning.js"></script><!--js路径-->

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
          <a class="navbar-brand" href="#">浙江大学教务管理系统</a><!--标头-->
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right"><!--导航按钮-->
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search..."><!--搜索输入框-->
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar"><!--侧栏-->
          <ul class="nav nav-sidebar">
            <li><a href="teacher_menu">首页<span class="sr-only">(current)</span></a></li><!--连接回teacher_menu页-->
            <li class="active"><a href="teacher_apply?classid=<?php echo $info['class_id'] ?>">调整申请</a></li><!--被选中，连接回当前页-->
            <li><a href="teacher_search?teacher_id=<?php echo 12345?>">查询打印</a></li><!--连接到查询打印页-->
          </ul>
        </div>
        
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">陈越姥姥，您好！欢迎进入自动排课子系统</h1><!--欢迎标语-->
			<ul class="nav nav-tabs"><!--选项卡-->
				<li role="presentation"><a href="teacher_menu">创建教学班/返回</a></li><!--返回首页-->
  				<li role="presentation" class="active"><a href="teacher_apply?classid=<?php echo $info['class_id'] ?>">调整申请</a></li><!--被选中，连接回当前页-->
			</ul> 
			<br>

          <div class="table-responsive">
			   <form class="form-horizontal" action="teacher_apply?classid=<?php echo $info['class_id'] ?>" method="post"><!--当按钮按下刷新当前页，方法使用post-->
					<div class="form-group">
						<label for="classid" class="col-sm-2 control-label">教学班ID</label>
						<label for="classid" class="col-sm-2 control-label"><?php echo $info['class_id'] ?></label><!--要递交申请的教学班ID-->
						<label for="classname" class="col-sm-4 control-label">课程ID</label>
						<label for="classname" class="col-sm-2 control-label"><?php echo $info['course_id'] ?></label><!--对应的课程ID-->
					</div>
					<div class="form-group">
						<label for="classname" class="col-sm-2 control-label">课程名</label>
						<label for="classname" class="col-sm-2 control-label"><?php echo $info['course_name'] ?></label><!--对应的课程名-->
						<label for="classname" class="col-sm-4 control-label">上课校区</label>
						<label for="classname" class="col-sm-2 control-label"><?php 
						$classrooms=explode(';',$info['classroom']);
						foreach ($classroom as $classroom_item):
							if($classrooms[1]==$classroom_item['classroom_id'])
							{
								switch( $classroom_item['campus']){
								case 1:echo "紫金港";break;
								case 2:echo "玉泉";break;
								case 3:echo "西溪";break;
								case 4:echo "华家池";break;
								case 5:echo "之江";break;
								}
							}
						endforeach;
							
				  ?></label><!--对应的上课校区-->
					</div>
					<div class="form-group">
						<label for="classname" class="col-sm-2 control-label">学年</label>
						<label for="classname" class="col-sm-2 control-label"><?php echo $info['year'] ?></label><!--对应的学年-->
						<label for="classname" class="col-sm-4 control-label">学期</label>
						<label for="classname" class="col-sm-2 control-label"><?php 
							switch($info['season'])
							{
								case 1: echo "秋冬";break;
								case 2: echo "春夏";break;
							}
						?></label><!--对应的学期-->
					</div>
					<div class="form-group">
						<label for="classname" class="col-sm-2 control-label">上课时间</label>
						<label for="classname" class="col-sm-2 control-label"><?php 
							$times=explode(';',$info['sche']);
						//	echo  $times[1];echo ";";
							//echo $times[1]/10000000000000;
						//	echo floor($times[1]/10000000000000);echo ";";
						//	echo $times[1]-floor($times[1]/10000000000000)*10000000000000;
							for($i=1;$i<count($times);$i++){
								switch(floor($times[$i]/10000000000000)){
									case 1: echo "周一"; break;
									case 2: echo "周二"; break;
									case 3: echo "周三"; break;
									case 4: echo "周四"; break;
									case 5: echo "周五"; break;
									case 6: echo "周六"; break;
									case 7: echo "周日"; break;
								}
								switch($times[$i]-floor($times[$i]/10000000000000)*10000000000000){
									case 1100000000000: echo "1、2节"; break;
									case 11000000000: echo "3、4节"; break;
									case 11100000000: echo "3、4、5节"; break;
									case 11100000: echo "6、7、8节"; break;
									case 1100000: echo "7、8节"; break;
									case 11000: echo "9、10节"; break;
									case 110: echo "11、12节"; break;
									case 111: echo "11、12、13节"; break;
								}
								echo "<br>";
							}
				  ?></label><!--对应的星期天数、第几节课-->
						<label for="classname" class="col-sm-4 control-label">上课教室</label>
						<label for="classname" class="col-sm-2 control-label"><?php 
						$classrooms=explode(';',$info['classroom']);
						for($i=1;$i<count($classrooms);$i++){
							foreach ($classroom as $classroom_item):
								if($classrooms[$i]==$classroom_item['classroom_id'])
								{
									echo $classroom_item['building']."-";
									echo $classroom_item['room'];
								}
							endforeach;
							echo "<br>";
						}	
				  ?></label><!--对应的教学楼、教室房间号-->
					</div>

					<br><hr>
					<div class="form-group">
						<label for="stuid" class="col-sm-2 control-label">调整意见</label><!--提示输入调整意见-->
					</div>
					
					<div class="form-group">
						<label for="stuid" class="col-sm-2 control-label"></label>
						<div class="col-sm-5">
							<textarea class="form-control" rows="10" cols="30" id="changeinfo" name="changeinfo" required="" autofocus=""></textarea><!--输入框-->
							<label for="stuid" class="col-sm-12 control-label"><center>请输入不超过100个字,超过部分不会被保存</center></label><!--提示输入应少于100字-->
						</div>
					</div>
					<div class="form-group">
						<label for="stuid" class="col-sm-6 control-label"></label>
						<div class="col-sm-6">
							<button type="submit" class="btn btn-info">提交</button><!--提交按钮-->
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
