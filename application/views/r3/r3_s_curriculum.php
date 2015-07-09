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

        <div class="col-sm-12 col-md-12 table-responsive">
          <?php
            echo'
            <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
               当前选定'.$currentcredit.'分。
            </div>';
          ?>
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th colspan="2">课程时间</th>
                  <th style="width: 12%;">星期一</th>
                  <th style="width: 12%;">星期二</th>
                  <th style="width: 12%;">星期三</th>
                  <th style="width: 12%;">星期四</th>
                  <th style="width: 12%;">星期五</th>
                  <th style="width: 12%;">星期六</th>
                  <th style="width: 12%;">星期日</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    $i=1;
                    for($time=1;$time<=13;$time++){
                      echo '<tr>';
                      if($time==1){
                        echo '<td rowspan="5">上午</td>';
                      }
                      if($time==6){
                        echo '<td rowspan="5">下午</td>';
                      }
                      if($time==11){
                        echo '<td rowspan="3">晚上</td>';
                      }
                      echo '<td style="width: 8%;">第';
                      echo $time;
                      echo '节</td>';
                      for($week=1;$week<=7;$week++){
                        if($classnum>0){
                          if(($classweek[$i]==$week)&&($classtime[$i]==$time)){
                            echo '<td><a href=';
                            echo site_url('r3/r3_student/courseinfo/'.$courseid[$i]);
                            echo '>';
                            echo $coursename[$i];
                            echo '</a>';
                            //echo '<br/>';
                            //echo $courseplace[$i];
                            echo '</td>';
                            if($i<$classnum)$i++;
                          }
                          else{
                            echo '<td>         </td>';
                          }
                        }
                        else{
                          echo '<td>         </td>';
                        }
                      }
                      echo '</tr>';
                    }
                ?>
              </tbody>
            </table>
            <?php
              echo '<form><button class="btn btn-default" formaction=';
              echo site_url('r3/r3_student/sprint/'.$sid);
              echo '>打印课表</button></form>';
            ?>
          </div>




  <?php include 'application/views/r3/r3_script.php';?> 
  </body>
</html>
