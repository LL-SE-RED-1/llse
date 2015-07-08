    <script> 
      function show(){ 
        var date = new Date(); //日期对象 
        var now = ""; 
        now = date.getFullYear()+"/"; //读英文就行了 
        now = now + (date.getMonth()+1)+"/"; //取月的时候取的是当前月-1如果想取当前月+1就可以了 
        now = now + date.getDate()+"    "; 
        now = now + date.getHours()+":"; 
        now = now + date.getMinutes()+":"; 
        now = now + date.getSeconds()+""; 
        document.getElementById("nowDiv").innerHTML = now; //div的html是now这个字符串 
        setTimeout("show()",1000); //设置过1000毫秒就是1秒，调用show方法 
      } 
    </script> 


    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" >
            <body onload="show()"> <!-- 网页加载时调用一次 以后就自动调用了--> 
            <div id="nowDiv"></div> 
            </body>
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href=<?php echo site_url('r3_teacher/curriculum/'.$tid);?>>我的课表</a></li>
            <li><a href=<?php echo site_url('r3_teacher/index');?>>选课首页</a></li>
            <li><a href=<?php echo site_url('r3_teacher/test');?>>安全登出</a></li>
          </ul>
        </div>
      </div>
    </nav>