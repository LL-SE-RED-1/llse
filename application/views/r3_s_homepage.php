<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<?php include 'application/views/r3_header.php';?>
</head>




  <body>
	<?php include 'application/views/r3_s_boarder.php';?>
	<?php include 'application/views/r3_s_sidebar.php';?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
	  <?php include 'application/views/r3_s_circles.php'; ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th colspan=2>以下是测试用的功能</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>切换身份</td>
          <td>
          <?php include 'application/views/entry.php'; ?>
          </td>
        </tr>
      </tbody>
    </table>
        </div>
      </div>
    </div>
  <?php include 'application/views/r3_script.php';?> 
  </body>
</html>
