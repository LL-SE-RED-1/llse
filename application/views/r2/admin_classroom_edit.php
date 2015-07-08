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

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>教师资源管理</title>
    
   
    <link href="<?php echo  base_url() ;?>application/views/static/css/bootstrap.min.css" rel="stylesheet">

   
    <link href="<?php echo  base_url() ;?>application/views/static/css/dashboard.css" rel="stylesheet">

    <script src="<?php echo  base_url() ;?>application/views/static/assets/js/ie-emulation-modes-warning.js"></script>

  
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
            <li class="active"><a href="admin_classroom_edit">自动排课 <span class="sr-only">(current)</span></a></li>
            <li><a href="Search">查询与打印</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Welcome, 管理员</h1>

          <div class="row placeholders">
            <!--选择操作-->
            <div class="col-xs-6 col-sm-3 placeholder">
              <!--连接到当前页-->
              <a href="admin_classroom_edit"><img data-src="holder.js/200x200/auto/sky" class="img-responsive"></a>
              <h4>教学资源管理</h4>
              <span class="text-muted">添加删除教室资源</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <!--连接到自动排课页-->
              <a href="admin_auto_arrange"><img data-src="holder.js/200x200/auto/vine" class="img-responsive" alt="Generic placeholder thumbnail"></a>
              <h4>自动排课</h4>
              <span class="text-muted">处理教师开班申请</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <!--连接到手动排课页-->
              <a href="admin_apply"><img data-src="holder.js/200x200/auto/sky" class="img-responsive" alt="Generic placeholder thumbnail"></a>
              <h4>手动排课</h4>
              <span class="text-muted">手动调整教师排课申请</span>
            </div>
          </div>
         <h2 class="sub-header">教室资源管理</h2>
         <!--需要传递参数，设置method为post-->
         <form action="classroom_edit_model" method="post" id="fo">
         <button class='btn btn-success' type='button' ><a href = "<?php echo  base_url() ;?>index.php/r2/add_classroom">添加一个教室</a></button>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <!--显示列表-->
                  <th>教室id</th>
                  <th>校区</th>
                  <th>教学楼</th>
                  <th>房间号</th>
                  <th>容量</th>
                  <th>类型</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                <!--遍历每一个查询结果-->
                <?php foreach ((array)$classroom as $classroom_item): ?>
                <tr>
                  <td><?php echo $classroom_item['classroom_id']?></td>
                 

                  <td><?php 
                      if ($classroom_item['campus']==1) echo "紫金港"?>
                      <?php if ($classroom_item['campus']==2) echo "玉泉"?>
                      <?php if ($classroom_item['campus']==3) echo "西溪"?>
                      <?php if ($classroom_item['campus']==4) echo "华家池"?>
                      <?php if ($classroom_item['campus']==5) echo "之江"
                      ?></td>

                  <td><?php echo $classroom_item['building']?></td>
                  <td><?php echo $classroom_item['room']?></td>
                  <td><?php echo $classroom_item['capacity']?></td>
                  <td><?php echo $classroom_item['type']?></td>
                  <td>
                  <!--跳转页面，传递参数教室id-->
                  <a href="room_apply?classroom_id=<?php echo $classroom_item['classroom_id']?>">修改</a>
                  <a href="admin_classroom_edit?clrid=<?php echo $classroom_item['classroom_id']?>">删除</a>
                  </td>
                </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
         </form>
         <!-- <div class="pager">
            <ul>
               <li><a href="#">Prev</a></li>
               <li><a href="#">1</a></li>
               <li><a href="#">2</a></li>
               <li><a href="#">3</a></li>
               <li><a href="#">4</a></li>
               <li><a href="#">5</a></li>
               <li><a href="#">Next</a></li>
            </ul>
          </div>-->
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
