<?php
echo '历史成绩:<br>';
echo '<table border=1>
<tr>
<th>考试号</th>
<th>考试信息</th>
<th>成绩</th>
</tr>';
foreach($slist as $list)//输出学生历史成绩
{
	echo '<tr> <td>'.$list['EID'].'</td>';
	echo '<td>'.$list['INFO'].'</td>';
	echo '<td>'.$list['SCORE'].'</td></tr>';
}
?>