<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<?php include 'application/views/r3_header.php';?>
</head>




  <body>
	<?php include 'application/views/r3_a_boarder.php';?>
	<?php include 'application/views/r3_a_sidebar.php';?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
	       <?php include 'application/views/r3_a_circles.php'; ?>
    	     <h1 class="page-header">课程信息</h1>
        <div class="col-sm-12 col-md-12 table-responsive">
            <form>
              <table class="table table-striped">
                  <thead>
                    <tr>
                      <th colspan=4><h3><?php echo $coursename;?></h3></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="width: 25%;">课程ID</td>
                      <td style="width: 25%;">学分</td>
                      <td style="width: 25%;">开课专业</td>
                      <td style="width: 25%;">权重系数</td>
                    </tr>
                    <tr>
                      <td><?php echo $courseid;?></td>
                      <td><?php echo $credit;?></td>
                      <td><?php echo $major;?></td>
                      <td><?php echo $weight;?></td>
                    </tr>
                    <tr>
                      <td colspan=4>课程简介</td>
                    </tr>
                    <tr>
                      <td colspan=4><?php echo $info;?></td>
                    </tr>
                  </tbody>
                </table>
              </form>
          </div>
        </div>
      </div>
    </div>
  <?php include 'application/views/r3_script.php';?> 
  </body>
</html>