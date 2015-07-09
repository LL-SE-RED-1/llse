<html>

<h1>
欢迎来到试卷生成模块！
</h1>
<p>

<form oninput="ll.value=parseInt(level.value)" action='<?php echo site_url("r6_C/paper/auto_generate")?>' method="post">
选择题题数: <br><input type="text" name="c_number"><br>
判断题题数：<br><input type="text" name="j_number"><br>
考查点选择：<br>
<?php 
for($i=0;$i<10;$i++)
{
	
	echo "<input type='checkbox' name=".$i." value=".($i+1)." />单元".($i+1)."<br /><br />";
}

?>
难度系数：

<div class="form-group" >
	
    <div class="col-xs-3 col-xs-pull-0.5">
        <input type="range" name="level" min="1" max="5" value="3"><output name="ll" for="level"></output>
	</div>
	
		
    
  </div>



<br>
<br>
<input class="btn btn-default" type="submit" value="自动生成试卷">

</form>
</p>
<?php echo validation_errors(); ?>
<p>
<form action='<?php echo site_url("r6_C/paper/manual_generate")?>' method="post">

<input class="btn btn-default" type="submit" value="手动生成试卷">
</form>

</p>
<p>
<form action='<?php echo site_url("r6_C/paper/check_paper")?>' method="post">

<input class="btn btn-default" type="submit" value="查看或修改历史试卷">
</form>

</p>
</html>