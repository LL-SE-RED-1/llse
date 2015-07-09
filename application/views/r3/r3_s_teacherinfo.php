<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<?php include 'application/views/r3/r3_header.php';?>
</head>




  <body>
	<?php include 'application/views/r3/r3_s_boarder.php';?>
	<?php include 'application/views/r3/r3_s_sidebar.php';?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
	       <?php include 'application/views/r3/r3_s_circles.php'; ?>
    	     <h1 class="page-header">教师介绍</h1>
        <div class="col-sm-12 col-md-12 table-responsive">
            <form>
              <table class="table table-striped">
                  <thead>
                    <tr>
                      <th colspan = 2><h3><?php echo $teachername;?></h3></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="width: 15%;">教师简介</td>
                      <td style="width: 85%;"></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><?php echo $teacherinfo;?></td>
                    </tr>
                    <tr>
                      <td>教学质量评价</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><?php 
                        for($i=1;$i<=$scorenum;$i++){
                          echo $score[$i];
                          if($i!=$scorenum){
                            echo '<br>';
                          }
                        }
                      ;?></td>
                    </tr>
                  </tbody>
                </table>
              </form>
          </div>
        </div>
      </div>
    </div>
  <?php include 'application/views/r3/r3_script.php';?> 
  </body>
</html>