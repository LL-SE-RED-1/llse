<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<?php include 'application/views/r3/r3_header.php';?>
</head>




  <body>
	<?php include 'application/views/r3/r3_t_boarder.php';?>
	<?php include 'application/views/r3/r3_t_sidebar.php';?>


    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
	  <?php include 'application/views/r3/r3_t_circles.php'; ?>

      <h1>教学班学生名单</h1> 
          <div class="col-sm-4 col-md-4 table-responsive">
              <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>学生姓名</th>
                      <th>学生ID</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      for($i=1;$i<=$studentnum;$i++){
                        echo '<tr><td>';
                        echo $studentname[$i];
                        echo '</td><td>';
                        echo $studentid[$i];
                        echo '</td></tr>';
                      }
                    ?>
                  </tbody>
                </table>
            <?php
              echo '<form><button class="btn btn-default" formaction=';
              echo site_url('r3/r3_teacher/tprint/'.$cid);
              echo '>打印学生名单</button></form>';
            ?>
          </div>

    </div>

  <?php include 'application/views/r3/r3_script.php';?> 
  </body>
</html>
