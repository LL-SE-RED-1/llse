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
          
          <h1 class="page-header">已获得学分课程评价</h1>
          

          <div class="col-sm-12 col-md-12 table-responsive">
            <form role="form" action="<?php site_url('r3_student/assess/'.$sid);?>" method="post">
              <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 20%;">课程名称</th>
                      <th style="width: 20%;">任课教师</th>
                      <th style="width: 20%;">开课学期</th>
                      <th style="width: 40%;">评价情况</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $j = 0;
                      for($i=1;$i<=$coursenum;$i++){
                          echo '<tr><td>';
                          echo $coursename[$i];
                          echo '</td><td><a href=';
                          echo site_url('r3_student/teacherinfo/'.$teacherid[$i]);
                          echo '>';
                          echo $teachername[$i];
                          echo '</a></td><td>';
                          echo $semester[$i];
                          echo '</td><td>';
                          if($pass[$i] == 0){
                            echo '不及格，需要重修';
                          }
                          else if($assess[$i] == 1){
                            echo '已评价过该课程';
                          }
                          else{
                            echo '<input type="radio" name="';
                            echo $j;
                            echo '" value="';
                            echo $classid[$i].'_'.$semester[$i].'_5';
                            echo '"> 非常满意&nbsp;&nbsp;&nbsp;';
                            echo '<input type="radio" name="';
                            echo $j;
                            echo '" value="';
                            echo $classid[$i].'_'.$semester[$i].'_4';
                            echo '"> 满意&nbsp;&nbsp;&nbsp;';
                            echo '<input type="radio" name="';
                            echo $j;
                            echo '" value="';
                            echo $classid[$i].'_'.$semester[$i].'_3';
                            echo '"> 比较满意&nbsp;&nbsp;&nbsp;';
                            echo '<input type="radio" name="';
                            echo $j;
                            echo '" value="';
                            echo $classid[$i].'_'.$semester[$i].'_2';
                            echo '"> 一般&nbsp;&nbsp;&nbsp;';
                            echo '<input type="radio" name="';
                            echo $j;
                            echo '" value="';
                            echo $classid[$i].'_'.$semester[$i].'_1';
                            echo '"> 不满意&nbsp;&nbsp;&nbsp;';
                            $j = $j + 1;
                          }
                          echo '</td></tr>';
                      }
                      echo '<tr><td>
                      <input type="hidden" name="total" value="'.$j.'">
                      </td><td>
                      </td><td>
                      </td><td>
                      <button type="submit" class="btn btn-default">提交</button>
                      </td></tr>';
                    ?>
<!--                    
                    <tr>
                      <td>软件工程</td>
                      <td>1234567</td>
                      <td><button type="submit" class="btn btn-default">添加</button></td>
                      <td>软件工程</td>
                      <td>1234567</td>
                      <td><button type="submit" class="btn btn-default">添加</button></td>
                    </tr>
-->
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
