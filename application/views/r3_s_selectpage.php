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

        <h1 class="page-header">教学班选课</h1>
          <div class="col-sm-12 col-md-12 table-responsive">
            <?php 
            if($classnum == 0){
              echo '非常抱歉，该课程尚未开设教学班。';
            }
            if($classnum > 0){
            echo '
            <form role="form" action="';
            echo site_url('r3_student/modifyclass/'.$sid.'/'.$courseid[1]);
            echo '" method="post">
              <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>课程名称</th>
                      <th>课程ID</th>
                      <th>开课专业</th>
                      <th>任课教师</th>
                      <th>上课地点</th>
                      <th>上课时间</th>
                      <th>课程余量</th>
                      <th>选课与退课</th>
                    </tr>
                  </thead>
                  <tbody>';
                        for($i=1;$i<=$classnum;$i++){
                          echo '<tr><td><a href=';
                          echo site_url('r3_student/courseinfo/'.$courseid[$i]);
                          echo '>';
                          echo $coursename[$i];
                          echo '</a></td><td>';
                          echo $courseid[$i];
                          echo '</td><td>';
                          echo $major[$i];
                          echo '</td><td><a href=';
                          echo site_url('r3_student/teacherinfo/'.$teacherid[$i]);
                          echo '>';
                          echo $teachername[$i];
                          echo '</a></td><td>';
                          echo $classroom[$i];
                          echo '</td><td>';
                          switch ($week[$i]){
                            case 1: echo "周一，第";echo $time[$i];echo "节";break;
                            case 2: echo "周二，第";echo $time[$i];echo "节";break;
                            case 3: echo "周三，第";echo $time[$i];echo "节";break;
                            case 4: echo "周四，第";echo $time[$i];echo "节";break;
                            case 5: echo "周五，第";echo $time[$i];echo "节";break;
                            case 6: echo "周六，第";echo $time[$i];echo "节";break;
                            case 7: echo "周日，第";echo $time[$i];echo "节";break;
                            default: echo "具体时间另行通知";
                          }
                          echo '</td><td>';
                          echo $selectstu[$i].'/'.$selectallow[$i];
                          echo '</td>';
                          if($classselect!=$classid[$i]){
                            echo '<td><input type="checkbox" name="selectcid" value="';
                            echo $classid[$i];
                            echo '"></td>';
                          }
                          else{
                            echo '<td><input type="checkbox" name="selectcid" value="';
                            echo $classid[$i];
                            echo '" checked="checked"></td>';
                          }
                          echo '</tr>';
                        }
                      
                  echo '
                    <tr style="background-color:white">
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td><button type="submit" class="btn btn-default">保存</button></td></tr>
                  </tbody>
                </table>
              </form>';}
              ?>
              <!--<iframe id="iframe" name="fff" width = 0 height = 0 frameborder=0></iframe>-->
          </div>
        </div>
      </div>
    </div>

  <script>
  function setCheckBoxLikeRadio(sListName)
  {
    var cCbx = document.getElementsByName(sListName);
    var selectedItem = null;
    
    for (var i=0; i<cCbx.length; i++)
    {
        if(cCbx[i].checked)selectedItem = cCbx[i];
    }

    for (i=0; i<cCbx.length; i++)
    {
        cCbx[i].onclick = function()
        {
            if (this.checked)
            {
                if (selectedItem != null)
                    selectedItem.checked = false;

                selectedItem = this;
            }
            else
            {
                selectedItem = null;
            }
        };
    }
  }
  setCheckBoxLikeRadio("selectcid");
  </script>
  <?php include 'application/views/r3_script.php';?> 
  </body>
</html>