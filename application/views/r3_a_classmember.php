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
          
            <h1>增加/删除学生</h1>
            <form role="form" action="<?php echo site_url('r3_admin/classmember/'.$classid);?>" method="post">
              <table class="table table-striped">
                <tr>
                <td style="width: 20%;"><div class="col-sm-12">课程名</div></td>
                <td style="width: 20%;"><div class="col-sm-12">任课教师</div></td>
                <td style="width: 20%;"><div class="col-sm-12">上课地点</div></td>
                <td style="width: 20%;"><div class="col-sm-12">上课时间</div></td>
                <td style="width: 20%;"></td>
                </tr>
                <tr>
                <td ><div class="col-sm-12"><?php echo $classname;?></div></td>
                <td ><div class="col-sm-12"><?php echo $classteacher;?></div></td>
                <td ><div class="col-sm-12"><?php echo $classroom;?></div></td>
                <td ><div class="col-sm-12"><?php 
                  switch ($classday){
                            case 1: echo "周一，第";echo $classtime;echo "节";break;
                            case 2: echo "周二，第";echo $classtime;echo "节";break;
                            case 3: echo "周三，第";echo $classtime;echo "节";break;
                            case 4: echo "周四，第";echo $classtime;echo "节";break;
                            case 5: echo "周五，第";echo $classtime;echo "节";break;
                            case 6: echo "周六，第";echo $classtime;echo "节";break;
                            case 7: echo "周日，第";echo $classtime;echo "节";break;
                            default: echo "具体时间另行通知";
                          }
                ;?></div></td>
                <td ></td>
                </tr>
                <tr>
                <td><div class="col-sm-12">搜索学生姓名</div></td>
                <td>
                  <div class="col-sm-12">
                    <input class="form-control" name="stunamesearch" type="text" value="">
                  </div>
                </td>
                <td><div class="col-sm-12">搜索学生id</div></td>
                <td>
                  <div class="col-sm-12">
                    <input class="form-control" name="stuidsearch" type="text" value="">
                  </div>
                </td>
                <td>
                  <div class="col-sm-12">
                    <button type="submit" class="btn btn-default">搜索</button>
                  </div>
                </td>
                </tr>
              </table>
            </form>

            <div class="col-sm-8 col-md-8 table-responsive">
            <h3>搜索结果</h3>
            <form>
            <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 30%;">学生姓名</th>
                      <th style="width: 50%;">学生ID</th>
                      <th style="width: 20%;">增加/删除</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      for($i=1;$i<=$searchnum;$i++){
                        echo '<tr><td>';
                        echo $searchname[$i];
                        echo '</td><td>';
                        echo $searchid[$i];
                        echo '</td><td>';
                        if($classselect[$i]==1){
                            echo '<button class="btn btn-default" formaction=';
                            echo site_url("r3_admin/modifyclass/".$searchid[$i].'/'.$classid.'/0');
                            echo '>删除</button></td>';
                        }
                        else{
                            echo '<button class="btn btn-default" formaction=';
                            echo site_url("r3_admin/modifyclass/".$searchid[$i].'/'.$classid.'/1');
                            echo '>添加</button></td>';
                        }
                        echo '</tr>';
                      }
                    ?>
                  </tbody>
                </table>
              </form>
          </div>  

          <div class="col-sm-4 col-md-4 table-responsive">
            <h3>教学班学生名单</h3>
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
          </div>
    </div>

  <?php include 'application/views/r3_script.php';?> 
  </body>
</html>
