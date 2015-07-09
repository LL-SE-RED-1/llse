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

        <h1 class="page-header">所有课程选课</h1>
          <div class="col-sm-12 col-md-12 table-responsive">
            <form>
              <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>课程名称</th>
                      <th>课程ID</th>
                      <th>是否已选</th>
                      <th>转入选课</th>
                      <th>课程名称</th>
                      <th>课程ID</th>
                      <th>是否已选</th>
                      <th>转入选课</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      for($i=1;$i<=$coursenum;$i++){
                        if($i%2==1){
                          echo '<tr><td><a href=';
                          echo site_url('r3/r3_student/courseinfo/'.$courseid[$i]);
                          echo '>';
                          echo $coursename[$i];
                          echo '</a></td><td>';
                          echo $courseid[$i];
                          echo '</td><td>';
                          if($courseselect[$i]==1){
                            echo "已选";
                          }
                          echo '</td><td><button class="btn btn-default" formaction=';
                          echo site_url("r3/r3_student/selectpage/".$sid.'/'.$courseid[$i]);
                          echo '>转入选课页面</button></td>';
                        }
                        else{
                          echo '<td><a href=';
                          echo site_url('r3/r3_student/courseinfo/'.$courseid[$i]);
                          echo '>';
                          echo $coursename[$i];
                          echo '</a></td><td>';
                          echo $courseid[$i];
                          echo '</td><td>';
                          if($courseselect[$i]==1){
                            echo "已选";
                          }
                          echo '</td><td><button class="btn btn-default" formaction=';
                          echo site_url("r3/r3_student/selectpage/".$sid.'/'.$courseid[$i]);
                          echo '>转入选课页面</button></td></tr>';
                        }
                      }
                      if($coursenum%2==1){
                        echo '</tr>';
                      }
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

  <?php include 'application/views/r3/r3_script.php';?> 
  </body>
</html>
