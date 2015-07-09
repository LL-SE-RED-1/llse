<html>

<h1>
所查试卷内容如下
</h1>

<p>


<?php

$i=1;

foreach ($v_arr as $value)
{
	echo $i.". ".$value."<br>"."<br>";
	echo "<a href='".site_url("r6_C/paper/del_paper_question")."?qid=".$v_qid[$i-1]."&&pid=".$v_pid."'>删除</a><br><br>";
	$i++;
}


?>


</p>
<p>
<a href="<?php echo site_url('r6_C/paper/add_paper_question')?>?pid=<?php echo $v_pid;?>">加题</a>
</p>
</html>