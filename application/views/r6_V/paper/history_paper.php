<html>

<h1>
选择需要查看的试卷
</h1>

<p>


<form action='<?php echo site_url("r6_C/paper/change_paper")?>' method="post">
<?php
//$x=9;
for($i=0;$i<count($pid);$i++)
{
	echo "<input type='radio' name='paper_id' value=".$pid[$i]." />试卷".$pid[$i]."<br /><br />";
}


?>

<input class="btn btn-default" type="submit" value="提交">
</form>

</p>
</html>