<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<?php include 'application/views/r3/r3_header.php';?>
</head>




  <body>
	<?php include 'application/views/r3/r3_a_boarder.php';?>
	<?php include 'application/views/r3/r3_a_sidebar.php';?>


        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          
	  <?php include 'application/views/r3/r3_a_circles.php'; ?>
    <h1>系统设置</h1> 
    <form role="form" action="<?php echo site_url('r3/r3_admin/modifysystem');?>" method="post">
    <table class="table table-striped">
      <tbody>
        <tr><td colspan=4><h3>系统时间设置</h3></td></tr>
        <tr>
          <td style="width:10%">选课开始时间</td>
          <td style="width:40%">
          <?php echo $startmonth.'月'.$startdate.'日'.$startclock.'时'; ?>
          </td>
          <td style="width:10%">选课结束时间</td>
          <td style="width:40%">
          <?php echo $endmonth.'月'.$enddate.'日'.$endclock.'时'; ?>
          </td>
        </tr>
        <tr>
          <td>修改开始时间</td>
          <td>
          <div class="col-sm-4">
            <div class="col-sm-10">
              <?php echo '
              <input class="form-control" name="startmonth2" type="int" value="'.$startmonth.'">';?>
            </div>月
          </div>
          <div class="col-sm-4">
            <div class="col-sm-10">
              <?php echo'
              <input class="form-control" name="startdate2" type="int" value="'.$startdate.'">';?>
            </div>日
          </div>
          <div class="col-sm-4">
            <div class="col-sm-10">
              <?php echo'
              <input class="form-control" name="startclock2" type="int" value="'.$startclock.'">';?>
            </div>时
          </div>
          </td>
          <td>修改结束时间</td>
          <td>
          <div class="col-sm-4">
            <div class="col-sm-10">
              <?php echo '
              <input class="form-control" name="endmonth2" type="int" value="'.$endmonth.'">';?>
            </div>月
          </div>
          <div class="col-sm-4">
            <div class="col-sm-10">
              <?php echo'
              <input class="form-control" name="enddate2" type="int" value="'.$enddate.'">';?>
            </div>日
          </div>
          <div class="col-sm-4">
            <div class="col-sm-10">
              <?php echo'
              <input class="form-control" name="endclock2" type="int" value="'.$endclock.'">';?>
            </div>时
          </div>
          </td>
        </tr>
        <tr><td colspan=4><h3>系统最低学分设置</h3></td></tr>
        <tr>
          <td>专业选择</td>
          <td>
            <div class="col-sm-12">
              <select name="major" class="form-control">
              <?php
                    for($i=1;$i<=$majornum;$i++){
                      echo '<option ';
                      echo 'value="';
                      echo $majors[$i];
                      echo '" ';
                      echo '>';
                      echo $majors[$i];
                      echo '</option>';
                    }
              ?>
            </select>
            </div>
          </td>
          <td> 总学分</td>
          <td>
            <div class="col-sm-12">
              <input class="form-control" name="mincredit" type="int" value="">
            </div>
          </td>
        </tr>
        <tr>
          <td> 专业选修课</td>
          <td>
            <div class="col-sm-12">
              <input class="form-control" name="minoption" type="int" value="">
            </div>
          </td>
          <td> 公共课学分</td>
          <td>
            <div class="col-sm-12">
              <input class="form-control" name="mincommon" type="int" value="">
            </div>
          </td>
        </tr>
        <tr>
          <td colspan=4>
            <button type="submit" class="btn btn-default">保存</button>
          <td>
        <tr>
      </tbody>
    </table>
  </form>
        </div>
      </div>
    </div>
  <?php include 'application/views/r3/r3_script.php';?> 
  </body>
</html>
