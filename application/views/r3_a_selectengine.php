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

      <h1>选课搜索引擎</h1> 
      <div class="col-sm-12 col-md-12  table-responsive">
        <form role="form" action="<?php echo site_url('r3_admin/selectengine');?>" method="post">
          <table class="table">
           <tr>
           <td><div class="col-sm-12">专业</div></td>
           <td><div class="col-sm-12">课程名称</div></td>
           <td><div class="col-sm-12">课程ID</div></td>
           <td><div class="col-sm-12">上课时间</div></td>
           <td><div class="col-sm-12">上课地点</div></td>
           </tr>
           <tr>
           <td>
            <div class="col-sm-10">
              <select name="major" class="form-control">
                <?php
                    echo '<option value=""></option>';
                    for($i=1;$i<=$majornum;$i++){
                      echo '<option ';
                      echo 'value="';
                      echo $majors[$i];
                      echo '">';
                      echo $majors[$i];
                      echo '</option>';
                    }
                  ?>
              </select>
            </div>
           </td>
           <td>
            <div class="col-sm-12">
               <input class="form-control" name="coursename" type="text" value="">
            </div>
           </td>
           <td>
            <div class="col-sm-12">
               <input class="form-control" name="courseid" type="text" value="">
            </div>
           </td>
           <td>
            <div class="col-sm-12">
               <input class="form-control" name="coursetime" type="text" value="">
            </div>
           </td>
           <td>
            <div class="col-sm-12">
               <input class="form-control" name="courseplace" type="text" value="">
            </div>
           </td>
           </tr>
           <tr>
           <td><div class="col-sm-12">教师姓名</div></td>
           <td><div class="col-sm-12">教师ID</div></td>
           <td></td>
           <td></td>
           <td></td>
           </tr>
           <tr>
           <td>
            <div class="col-sm-12">
               <input class="form-control" name="teachername" type="text" value="">
            </div>
           </td>
           <td>
            <div class="col-sm-12">
               <input class="form-control" name="teacherid" type="text" value="">
            </div>
           </td>
           <td></td>
           <td></td>
           <td>
            <div class="col-sm-12">
               <button type="submit" class="btn btn-default">搜索</button>
            </div>
           </td>
           </tr>
          </table>
        </form>
      </div>

          <div class="col-sm-12 col-md-12 table-responsive">
            <form>
              <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>课程名称</th>
                      <th>课程ID</th>
                      <th>转入选课</th>
                      <th>课程名称</th>
                      <th>课程ID</th>
                      <th>转入选课</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      for($i=1;$i<=$coursenum;$i++){
                        if($i%2==1){
                          echo '<tr><td><a href=';
                          echo site_url('r3_admin/courseinfo/'.$courseid[$i]);
                          echo '>';
                          echo $coursename[$i];
                          echo '</a></td><td>';
                          echo $courseid[$i];
                          echo '</td><td><button class="btn btn-default" formaction=';
                          echo site_url("r3_admin/selectpage/".$courseid[$i]);
                          echo '>转入选课页面</button></td>';
                        }
                        else{
                          echo '<td><a href=';
                          echo site_url('r3_admin/courseinfo/'.$courseid[$i]);
                          echo '>';
                          echo $coursename[$i];
                          echo '</a></td><td>';
                          echo $courseid[$i];
                          echo '</td><td><button class="btn btn-default" formaction=';
                          echo site_url("r3_admin/selectpage/".$courseid[$i]);
                          echo '>转入选课页面</button></td>';
                          echo '</tr>';
                        }
                      }
                      if($coursenum%2==1){
                        echo '</tr>';
                      }
                    ?>
                  </tbody>
                </table>
              </form>
          </div>

    </div>

  <?php include 'application/views/r3_script.php';?> 
  </body>
</html>
