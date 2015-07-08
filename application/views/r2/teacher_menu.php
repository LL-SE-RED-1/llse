<?php 
if (! defined('BASEPATH')) {
  exit('Access Denied');
}
?>
<?php
$this->load->helper('url');
$_SESSION['course_id']=null;//useless
$_SESSION['teacher_id']=null;
$_SESSION['user_id']=null;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"><!--使用utf-8编码-->
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
          <a class="navbar-brand" href="<?php echo site_url('llse_welcome');?>">浙江大学教务管理系统</a><!--标头-->
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
            <li class="active"><a href="teacher_menu">首页<span class="sr-only">(current)</span></a></li><!--被选中，连接回当前页-->
            <li><a href="teacher_search?teacher_id=<?php echo $uid?>">查询打印</a></li><!--连接进入查询打印界面-->
           
          </ul>
          
        </div> 
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">陈越姥姥，您好！欢迎进入自动排课子系统</h1><!--欢迎标语-->
		
          
        <!-- /.row --> <form action="teacher_menu" method="post" id = "fo"><!--当有按钮点击进入teacher_menu页面，方法是post-->
		<div class="form-group">
		
			<label for="classname" class="col-sm-1 control-label">课程ID</label><!--提示输入课程ID-->
			<div class="col-sm-2">
				<input type="int" class="form-control" id="courseid" name="courseid" required="" autofocus=""placeholder="课程ID"><!--输入框-->
			</div> 
			<div class="col-sm-6">
			</div>
			<input class="btn btn-info" type="submit" name="add" value="创建教学班"><!--创建教学班按钮-->
		
		</div>
		</form>
		 <hr>
          <h2 class="sub-header">教学班列表</h2><!--副标题：教学班列表-->
		 
          <div class="table-responsive"><!--表格-->
            <table class="table table-striped">
              <thead><!--标头-->
                <tr>
				  <th>教学班ID</th><!--属性名-->
                  <th>课程ID</th>
                  <th>课程名称</th>
                  <th>上课时间</th>
                  <th>上课地点</th>
                  <th>审核状态</th>
				  <th>调整申请</th>
                </tr>
              </thead>
              <tbody><!--表格内容-->
			  <?php foreach ($apply2 as $apply2_item): ?>
                <tr>
				  <td><?php echo $apply2_item['class_id'] ?></td>
                  <td><?php echo $apply2_item['course_id'] ?></td>
                  <td><?php echo $apply2_item['course_name'] ?></td>
                  <td><?php 
							$times=explode(';',$apply2_item['sche']);
							//echo  $times[1];echo ";";
							//echo $times[1]/10000000000000;
							//echo floor($times[1]/10000000000000);echo ";";
							//echo $times[1]-floor($times[1]/10000000000000)*10000000000000;
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
				  ?></td>
                  <td><?php 
						$classrooms=explode(';',$apply2_item['classroom']);
						for($i=1;$i<count($classrooms);$i++){
							foreach ($classroom as $classroom_item):
								if($classrooms[$i]==$classroom_item['classroom_id'])
								{
									switch( $classroom_item['campus']){
									case 1:echo "紫金港";break;
									case 2:echo "玉泉";break;
									case 3:echo "西溪";break;
									case 4:echo "华家池";break;
									case 5:echo "之江";break;
									}
									echo $classroom_item['building']."-";
									echo $classroom_item['room'];
								}
							endforeach;
							echo "<br>";
						}	
				  ?></td>
                  <td>排课成功</td><!---->
				  <th><a href="teacher_apply?classid=<?php echo $apply2_item['class_id'] ?>">调整申请</th>
                </tr>
			<?php endforeach ?>
			<?php foreach ($apply3 as $apply3_item): ?>
                <tr>
				  <td><?php echo $apply3_item['class_id'] ?></td>
                  <td><?php echo $apply3_item['course_id'] ?></td>
                  <td><?php echo $apply3_item['course_name'] ?></td>
                  <td><?php 
							$times=explode(';',$apply3_item['sche']);
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
				  ?></td>
                  <td><?php 
						$classrooms=explode(';',$apply3_item['classroom']);
						for($i=1;$i<count($classrooms);$i++){
							foreach ($classroom as $classroom_item):
								if($classrooms[$i]==$classroom_item['classroom_id'])
								{
									switch( $classroom_item['campus']){
									case 1:echo "紫金港";break;
									case 2:echo "玉泉";break;
									case 3:echo "西溪";break;
									case 4:echo "华家池";break;
									case 5:echo "之江";break;
									}
									echo $classroom_item['building']."-";
									echo $classroom_item['room'];
								}
							endforeach;
							echo "<br>";
						}	
				  ?></td>
                  <td>待调整</td>
				  <th>调整申请</th>
                </tr>
			<?php endforeach ?>
			<?php foreach ($apply5 as $apply5_item): ?><!--该老师待调整的所有教学班-->
                <tr>
				<td><?php echo $apply5_item['class_id'] ?></td>
                  <td><?php echo $apply5_item['course_id'] ?></td>
                  <td><?php echo $apply5_item['course_name'] ?></td>
                  <td><?php 
							$times=explode(';',$apply5_item['sche']);
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
				  ?></td>
                  <td><?php 
						$classrooms=explode(';',$apply5_item['classroom']);
						for($i=1;$i<count($classrooms);$i++){
							foreach ($classroom as $classroom_item):
								if($classrooms[$i]==$classroom_item['classroom_id'])
								{
									switch( $classroom_item['campus']){
									case 1:echo "紫金港";break;
									case 2:echo "玉泉";break;
									case 3:echo "西溪";break;
									case 4:echo "华家池";break;
									case 5:echo "之江";break;
									}
									echo $classroom_item['building']."-";
									echo $classroom_item['room'];
								}
							endforeach;
							echo "<br>";
						}	
				  ?></td>
                  <td>拒绝调整</td>
				<th><a href="teacher_apply?classid=<?php echo $apply5_item['class_id'] ?>">调整申请</th><!--链接到调整申请页面传递教学班ID参数-->
                </tr>
			<?php endforeach ?>
			  <?php foreach ($apply1 as $apply1_item): ?>
                <tr>
				  <td><?php echo $apply1_item['class_id'] ?></td>
                  <td><?php echo $apply1_item['course_id'] ?></td>
                  <td><?php echo $apply1_item['name'] ?></td>
                  <td></td>
                  <td></td>
                  <td>待审核</td>
				  <th>调整申请</th>
                </tr>
			<?php endforeach ?>
			
			<?php foreach ($apply4 as $apply4_item): ?>
                <tr>
				  <td><?php echo $apply4_item['class_id'] ?></td>
                  <td><?php echo $apply4_item['course_id'] ?></td>
                  <td><?php echo $apply4_item['name'] ?></td>
                  <td></td>
                  <td></td>
                  <td>已被删除</td>
				  <th>调整申请</th>
                </tr>
			<?php endforeach ?>
			
			
			
		
            </tbody>
            </table>
          </div>
		<!--     <div class="pager"><!--页码>
            <ul>
               <li><a href="#">Prev</a></li><!--前一页>
               <li><a href="#">1</a></li><!--第一页>
               <li><a href="#">2</a></li><!--第二页>
               <li><a href="#">3</a></li>
               <li><a href="#">4</a></li>
               <li><a href="#">5</a></li>
               <li><a href="#">Next</a></li><!--后一页>
            </ul>
          </div>-->

        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo  base_url() ;?>application/views/static/assets/js/jquery-2.0.0.min.js"></script><!--js文件路径-->
    <script src="<?php echo  base_url() ;?>application/views/static/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="<?php echo  base_url() ;?>application/views/static/assets/js/vendor/holder.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo  base_url() ;?>application/views/static/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
