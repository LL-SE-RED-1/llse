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

    <title>自动排课申请处理</title>
    
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
          <a class="navbar-brand" href="<?php echo site_url('llse_welcome');?>">浙江大学教务管理系统</a>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
        <!--
           侧边栏，链接到不同模块
        -->
          <ul class="nav nav-sidebar">
            <li class="active"><a href="admin_classroom_edit">自动排课 <span class="sr-only">(current)</span></a></li>
            <li><a href="Search">查找与打印</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Welcome, 管理员</h1>
        <!-- 三个子模块 -->
          <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder">
              <a href="<?php echo  base_url() ;?>/index.php/r2/admin_classroom_edit"><img data-src="holder.js/200x200/auto/sky" class="img-responsive"></a>
              <h4>教学资源管理</h4>
              <span class="text-muted">添加删除教室资源</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <a href="<?php echo  base_url() ;?>/index.php/r2/admin_auto_arrange"><img data-src="holder.js/200x200/auto/vine" class="img-responsive" alt="Generic placeholder thumbnail"></a>
              <h4>自动排课</h4>
              <span class="text-muted">处理教师开班申请</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <a href="<?php echo  base_url() ;?>/index.php/r2/admin_apply"><img data-src="holder.js/200x200/auto/sky" class="img-responsive" alt="Generic placeholder thumbnail"></a>
              <h4>手动排课</h4>
              <span class="text-muted">手动调整教师排课申请</span>
            </div>
          </div>
        <!--  显示老师提交的未处理的申请 -->
         <h2 class="sub-header">开班申请</h2>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>课程id</th>
                  <th>申请教师</th>
                  <th>申请日期</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($apply as $item): ?>
                <tr>
                  <td><?php echo $item['course_id']?></td>
                  <td><?php echo $item['teacher_id']?></td>
                  <td><?php echo $item['date']?></td>
                  <td><!--<button class='btn' type='button'>删除</button>-->
                    <a href="?crid=<?php echo $item['class_id']?>">删除</a>
                  </td>
                </tr>
                <?php endforeach ?>
              </tbody>
              <tbody><tr><th></th>
               <td>
                  <ul class="pager">
                     <li><a href="?pid=<?php echo $page-1?>">Previous</a></li>
                     <li><a href="?pid=<?php echo $page+1?>">Next</a></li>
                  </ul>
               </td></tr>
            </tbody>
            </table>
          </div>
        
          <form name="arr" id="arran" method="POST" Action="<?php echo base_url();?>index.php/r2/admin_auto_arrange/arrange">
             <button class='btn btn-success' type='submit'>开始排课</button>
          </form>
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
