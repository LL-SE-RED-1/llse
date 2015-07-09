<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<?php include 'application/views/r3/r3_header.php';?>
</head>
  <body>
  <script>
  function change(id) {  
    if (document.getElementById(id).innerHTML=="添加") {
     document.getElementById(id).innerHTML="删除"; 
    } 
    else {
     document.getElementById(id).innerHTML="添加";
    }
   }
  </script>
	<?php include 'application/views/r3/r3_s_boarder.php';?>
	<?php include 'application/views/r3/r3_s_sidebar.php';?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
	  <?php include 'application/views/r3/r3_s_circles.php'; ?>




          <h1 class="page-header">制定培养方案</h1>
          <div class="col-sm-12 col-md-12  table-responsive">
          <?php
            if($currentcredit < $mincredit || $optioncredit < $optionmin || $commoncredit < $commonmin){
              echo'<div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                 培养方案不符合要求！<br>
                 当前选定总学分'.$currentcredit.'，最低总学分要求'.$mincredit.'；<br>
                 当前选定专业选修课学分'.$optioncredit.'，最低学分要求'.$optionmin.'；<br>
                 当前选定公共课学分'.$commoncredit.'，最低公共课学分要求'.$commonmin.'。
              </div>';
            }
            else{
              echo'<div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                 培养方案符合要求！<br>
                 当前选定总学分'.$currentcredit.'；<br>
                 当前选定专业选修课学分'.$optioncredit.'；<br>
                 当前选定公共课学分'.$commoncredit.'。
              </div>';
            }
          ?>
          <form role="form" action="<?php echo site_url('r3/r3_student/plan/'.$sid.'/');?>" method="post">
            <table>
              <td>
                <select name="major" class="form-control">
                  <?php
                    echo '<option ';
                    echo 'value="';
                    echo '所有课程';
                    echo '"';
                    echo '>';
                    echo '所有课程';
                    echo '</option>';
                    for($i=1;$i<=$majornum;$i++){
                      echo '<option ';
                      echo 'value="';
                      echo $majors[$i];
                      echo '" ';
                      if($majors[$i]==$nowmajor){
                        echo 'selected="selected"';
                      }
                      echo '>';
                      echo $majors[$i];
                      echo '</option>';
                    }
                  ?>
                </select>
              </td>
              <td>
                <button type="submit" class="btn btn-default">确认</button>
              </td>
            </table>
            <?php 
              echo '<input type="hidden" name="sid" value=';
              echo $sid;
              echo '>';
            ?>
          </form>
          </div>

          <div class="col-sm-12 col-md-12 table-responsive">
            <form>
              <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>课程名称</th>
                      <th>课程ID</th>
                      <th>课程类型</th>
                      <th>添加/删除</th>
                      <th>课程名称</th>
                      <th>课程ID</th>
                      <th>课程类型</th>
                      <th>添加/删除</th>
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
                          if($coursetype[$i]=='专业必修课'){
                            echo '其他专业课';
                          }
                          else{
                            echo $coursetype[$i];
                          }
                          echo '</td><td>';
                          if($courseselect[$i]==0){
                            echo '<button class="btn btn-default" id="';
                            echo $i;
                            echo '" onClick=change(';
                            echo $i;
                            echo ') formaction=';
                            echo site_url("r3/r3_student/modifymajorcourse/".$sid.'/'.$courseid[$i]);
                            echo ' formtarget="i">添加</button></td>';
                          }
                          else{
                            echo '<button class="btn btn-default" id="';
                            echo $i;
                            echo '" onClick=change(';
                            echo $i;
                            echo ') formaction=';
                            echo site_url("r3/r3_student/modifymajorcourse/".$sid.'/'.$courseid[$i]);
                            echo ' formtarget="i" ';
                            if($getcredit[$i]==1){
                              echo 'disabled="disabled"';
                            }
                            echo '>删除</button></td>';
                          }
                        }
                        else{
                          echo '<td><a href=';
                          echo site_url('r3/r3_student/courseinfo/'.$courseid[$i]);
                          echo '>';
                          echo $coursename[$i];
                          echo '</a></td><td>';
                          echo $courseid[$i];
                          echo '</td><td>';
                          if($coursetype[$i]=='专业必修课'){
                            echo '其他专业课';
                          }
                          else{
                            echo $coursetype[$i];
                          }
                          echo '</td><td>';
                          if($courseselect[$i]==0){
                            echo '<button class="btn btn-default" id="';
                            echo $i;
                            echo '" onClick=change(';
                            echo $i;
                            echo ') formaction=';
                            echo site_url("r3/r3_student/modifymajorcourse/".$sid.'/'.$courseid[$i]);
                            echo ' formtarget="i">添加</button></td></tr>';
                          }
                          else{
                            echo '<button class="btn btn-default" id="';
                            echo $i;
                            echo '" onClick=change(';
                            echo $i;
                            echo ') formaction=';
                            echo site_url("r3/r3_student/modifymajorcourse/".$sid.'/'.$courseid[$i]);
                            echo ' formtarget="i" ';
                            if($getcredit[$i]==1){
                              echo 'disabled="disabled"';
                            }
                            echo '>删除</button></td></tr>';
                          }
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
              <iframe id="iframe" name="i" width = 0 height = 0 frameborder=0></iframe>
          </div>
        </div>
      </div>
    </div>

  <?php include 'application/views/r3/r3_script.php';?> 
  </body>
</html>
