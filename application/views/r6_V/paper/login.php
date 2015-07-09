
            <h1>
			欢迎教师<?php echo $tid?>
			</h1>
			<br>
			<p>
			下面请输入课程号
			</p>
			<br>
			<p>
			<form action='<?php echo site_url("r6_C/paper/welcome")?>' method="post">
			课程号：
			<select name="cid">
			<?php 
			foreach ($cid as $x)
			{
			echo "<option value=".$x.">".$x."</option>";
			}


?>

</select>
<br><br>
<input class="btn btn-default" type="submit" value="提交">
</form>


</p>

</body>
</html>