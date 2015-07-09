<html>

<h1>
满足条件的题目如下
</h1>

<p>


<form action='<?php echo site_url("r6_C/paper/generate")?>' method="post">
<?php
//$x=9;
for($i=0;$i<count($qid);$i++)
{
	echo "<input type='checkbox' name=".$i." value=".$qid[$i]." />".$content[$i]."<br /><br />";
}


?>

<input class="btn btn-default" type="submit" value="提交">
</form>

</p>
</html>