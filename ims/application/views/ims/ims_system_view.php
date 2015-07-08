 
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

          <div class="row">

            <div class="col-xs-6 col-sm-2 placeholder">

              <div class="ui statistic at-center">
                <div class="label at-center">
                  日期
                </div>

                <div class="text value">
                  <?php echo $sys_info['date'];?> 
                </div>
              </div>
            </div>


            <div class="col-xs-6 col-sm-2 placeholder">

              <div class="ui statistic at-center">
                <div class="label at-center">
                  时间
                </div>
                <div class="text value">
                  <?php echo $sys_info['time']; ?>
                </div>
              </div>

            </div>

            <div class="col-xs-6 col-sm-2 placeholder">

              <div class="ui statistic at-center">
                <div class="label at-center">
                  当前学期
                </div>
                <div class="text value">
                  <?php echo $sys_info['semester']; ?>
                </div>
              </div>


            </div>


            <div class="col-xs-6 col-sm-2 placeholder">

              <div class="ui statistic at-center">
                <div class="label at-center">
                  Error
                </div>
                <div class="text value">
                  <i class="remove circle icon"></i>
                  <?php echo $log_stati['error']; ?>
                </div>
              </div>

            </div>

            <div class="col-xs-6 col-sm-2 placeholder">

              <div class="ui statistic at-center">
                <div class="label at-center">
                  Warning
                </div>
                <div class="text value">
                  <i class="warning circle icon"></i>
                  <?php echo $log_stati['warning']; ?>
                </div>
              </div>

            </div>


            <div class="col-xs-6 col-sm-2 placeholder at-center">

              <div class="ui statistic at-center">
                <div class="label at-center">
                  Info
                </div>
                <div class="text value">
                  <i class="info circle icon"></i>
                  <?php echo $log_stati['info']; ?>
                </div>
              </div>

            </div>

          </div>

          <div class="col-xs-6 col-sm-6 placeholder">

            <h2 class="sub-header">日志纪录</h2>

          </div>

         <div class="col-xs-6 col-sm-6 placeholder">

            <!-- <div class="ui searchable floating dropdown labeled icon button" tabindex="0" style="float: right;">
              <i class="filter icon"></i>
              <span class="text">过滤</span>
              <div class="menu" tabindex="-1">
                <div class="header">
                  Filter
                </div>
                <div class="item condition">
                  <div class="ui red empty circular label"></div>
                  Error
                </div>
                <div class="item condition">
                  <div class="ui yellow empty circular label"></div>
                  Warning
                </div>
                <div class="item condition">
                  <div class="ui white empty circular label"></div>
                  Info
                </div>
                <div class="item condition">
                  <div class="ui green empty circular label"></div>
                  All
                </div>

              </div>

            </div> -->

          </div> 

          <table class="ui celled table">
            <thead>
            <tr>
              <th>Type</th>
              <th>Time</th>
              <th>User ID</th>
              <th>IP</th>
              <th>Description</th>
            </tr>
            </thead>
            <tbody>
            
            <?php foreach ($log as $item): ?>
              <?php if($item['class'] == 0): ?>  
                <tr>
                <td>
                  <i class="info icon"></i>
                  Info
                </td>        
              <?php elseif($item['class'] == 1): ?>
                <tr class="warning">
                <td class="warning">
                  <i class="attention icon"></i>
                  Warning
                </td>
              <?php else: ?>
                <tr class="negative">
                <td class="error">
                  <i class="remove icon"></i>
                  Error
                </td>
              <?php endif; ?>
                  <td><?=$item['time']?></td>
                  <td><?=$item['uid']?></td>
                  <td><?=$item['ip']?></td>
                  <td><?=$item['description']?></td>
                </tr>
            <?php endforeach; ?>
            
            </tbody>
          </table>
          
          <!-- 分页 -->
          <p>&nbsp;
            <?php

              for($num=1;$num <= $pagination['page_num'];$num++)
              {
                if($pagination['page'] == $num)
                  echo "<strong>".$num."</strong>&nbsp;&nbsp;";
                else
                  echo "<a href='".$pagination['base_url']."/".$num."'>".$num."</a>&nbsp;&nbsp;";
              }
              if($pagination['page'] == $pagination['page_num'])
                echo "<strong>&gt;</strong>&nbsp;&nbsp;";
              else
                echo "<a href='".$pagination['base_url']."/".($pagination['page']+1)."'>&gt;</a>&nbsp;&nbsp;";
            ?>
          </p>

        </div>
      </div>
    </div>


  <style type="text/css">
    .ui.statistic.at-center {
      display: block;
      margin: 0 auto;
    }
    .label.at-center {
      display: block;
      margin: 0 auto;
    }

  </style>

  <script type="text/javascript">
  
  /*  $('span.text').change(function(){
	  console.log($(this));
  });*/

  $('.item.condition').click(function(){
	  var label = $(this).text().trim();
	  $('tr').each(function(idx, el){
		  if (idx != 0) {
			  //console.log(el);
			  if (label == 'All') $(el).show();
			  else {
				  if (label == $(el).children(":first").text().trim()) $(el).show();
				  else $(el).hide();
			  }
		  }
	  });
  });

  
      $(document)
              .ready(function(){
                $('.ui.dropdown')
                        .dropdown()
                ;
                $('.ui.menu .dropdown')
                        .dropdown({
                          on: 'hover'
                        })
                ;
              })
      ;
    </script>
  </body></html>
