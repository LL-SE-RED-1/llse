<?php 
if (! defined('BASEPATH')) {
  exit('Access Denied');
}
?>
<?php
$this->load->helper('url');
$_SESSION['course_id']=null;
$_SESSION['teacher_id']=null;
$_SESSION['user_id']=null;
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

    <title>自动排课子系统</title>
    
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
          <a class="navbar-brand" href="#">浙江大学教务管理系统</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
              <li class="active"><a href="admin_classroom_edit">首页<span class="sr-only">(current)</span></a></li>
              <li><a href="Search">查询打印</a></li>
          </ul>
          
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-2 main">
        
          <h1 class="page-header">查询打印</h1>
    
          <form action="Search" method="post" id = "fo">
    
            <div class="form-group">
    
              <div class="col-sm-3">
                <!--教师姓名查询-->
                <input type="text" class="form-control" id="courseid" name="tc_name" required="" autofocus=""placeholder="请输入教师姓名...">
              </div> 
              <div class="col-sm-0">
              </div>
              <input class="btn btn-info" type="submit" name="add" value="查询">
              </div>
          </form>
          <form action="Search" method="post" id = "fo">
            <div class="form-group">
              <div class="col-sm-2">
                <!--输入校区，紫金港校区则输入紫金港-->
                <input type="text" class="form-control" id="courseid" name="campus" required="" autofocus=""placeholder="请输入校区...">

              </div> 
              <div class="col-sm-2">
                <!--输入教学楼-->
                <input type="text" class="form-control" id="courseid" name="building" required="" autofocus=""placeholder="请输入教学楼...">

              </div> 
              <div class="col-sm-2">
                <!--输入教师号-->
                <input type="int" class="form-control" id="courseid" name="room" required="" autofocus=""placeholder="请输入教室号..."> 

              </div> 
              <div class="col-sm-0">
              </div>
                <input class="btn btn-info" type="submit" name="add" value="查询">
            </div>
          </form>
          <hr>
            <h2 class="sub-header">课表</h2>
     
            <div class="table-responsive">
         <!--   <table class="table table-striped">
              <thead>
                <tr>
                      <th>课程名称</th>
                      <th>上课时间</th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th>上课地点</th>
                      <th></th>
                      <th></th>

                </tr>
              </thead>
              <tbody>
         <?php /*foreach ($search as $schedule_item): ?>
                    <tr>
                      <td><?php echo $schedule_item['course_name']?></td>
                      <td><?php if ($schedule_item['weekday']==1) echo "星期一"?>
                        <?php if ($schedule_item['weekday']==2) echo "星期二"?>
                        <?php if ($schedule_item['weekday']==3) echo "星期三"?>
                        <?php if ($schedule_item['weekday']==4) echo "星期四"?>
                        <?php if ($schedule_item['weekday']==5) echo "星期五"?>
                        <?php if ($schedule_item['weekday']==6) echo "星期六"?>
                        <?php if ($schedule_item['weekday']==7) echo "星期日"
                        
                      ?></td>
                      <td><?php 
                        if ($schedule_item['classnum'][0]==1) echo "一"?>
                        <?php if ($schedule_item['classnum'][1]==1) echo "二"?>
                        <?php if ($schedule_item['classnum'][2]==1) echo "三"?>
                        <?php if ($schedule_item['classnum'][3]==1) echo "四"?>
                        <?php if ($schedule_item['classnum'][4]==1) echo "五"?>
                        <?php if ($schedule_item['classnum'][5]==1) echo "六"?>
                        <?php if ($schedule_item['classnum'][6]==1) echo "七"?>
                        <?php if ($schedule_item['classnum'][7]==1) echo "八"?>
                        <?php if ($schedule_item['classnum'][8]==1) echo "九"?>
                        <?php if ($schedule_item['classnum'][9]==1) echo "十"?>
                        <?php if ($schedule_item['classnum'][10]==1) echo "十一"?> 
                        <?php if ($schedule_item['classnum'][11]==1) echo "十二"?>
                        <?php if ($schedule_item['classnum'][12]==1) echo "十三"


                        
                        ?></td>
                      <td><?php 
                        if ($schedule_item['season']==1) echo"春"?>
                        <?php if ($schedule_item['season']==2) echo"夏"?>
                        <?php if ($schedule_item['season']==3) echo"秋"?>
                        <?php if ($schedule_item['season']==4) echo"冬"?>
                        <?php echo "学期"
                          ?></td>
                      <td><?php echo $schedule_item['year']?></td>
                      <td><?php 
                      if ($schedule_item['campus']==1) echo "紫金港"?>
                      <?php if ($schedule_item['campus']==2) echo "玉泉"?>
                      <?php if ($schedule_item['campus']==3) echo "西溪"?>
                      <?php if ($schedule_item['campus']==4) echo "华家池"?>
                      <?php if ($schedule_item['campus']==5) echo "之江"
                      ?></td>
                      <td><?php echo $schedule_item['building']?></td>
                      <td><?php echo $schedule_item['room']?></td>
                    </tr> 
        <?php endforeach*/ ?>
            </tbody>
            </table>-->
			        <table class="table table-bordered">
                <thead>
                  <tr>  
                    <!--右上角空，横排第一行-->
                    <th></th>
                    <th>星期一</th>
                    <th>星期二</th>
                    <th>星期三</th>
                    <th>星期四</th>
                    <th>星期五</th>
                    <th>星期六</th>
                    <th>星期日</th>

                  </tr>
                </thead>
                <tbody>
                  <?php for($i = 0;$i < 13;$i++){
                  echo "<tr>";
                  echo "<td>";
                  //第一竖排
                  if ($i == 0) echo "第一节";
                  if ($i == 1) echo "第二节";
                  if ($i == 2) echo "第三节";
                  if ($i == 3) echo "第四节";
                  if ($i == 4) echo "第五节";
                  if ($i == 5) echo "第六节";
                  if ($i == 6) echo "第七节";
                  if ($i == 7) echo "第八节";
                  if ($i == 8) echo "第九节";
                  if ($i == 9) echo "第十节";
                  if ($i == 10) echo "第十一节";
                  if ($i == 11) echo "第十二节";
                  if ($i == 12) echo "第十三节";
                           
                  echo "</td>";
                  for($j = 1;$j <= 7;$j++){
                    echo "<td>";
                    //判断是不是在该格显示
                    foreach ((array)$search as $schedule_item) {
                    //  echo 1;
                      $f=0;
                      $length=strlen($schedule_item['sche']);
                     // echo $length." ** ";
                      $x=$length / 15;
                     // echo $x;
                      for ($k=0;$k<$x;$k++){
                     //   echo $schedule_item['sche'][$k*15+1]."==".$j ."************".$schedule_item['sche'][$k*15+1+1+$i]."\n";
                        if ($schedule_item['sche'][$k*15+1]==$j && $schedule_item['sche'][$k*15+1+1+$i]==1){
                         echo $schedule_item['course_name'];
                         $f=1;
                         break;
                        }
                      }
                      if ($f==1) break;
                    }
                    echo "</td>";
                  }
                  echo "</tr>";
                  }?>

                </tbody>
              </table>
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
