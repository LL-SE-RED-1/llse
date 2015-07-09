
<?php
echo '请输入您要查询的考卷:';
echo '<br>';
//使用post方法,建立表单
echo "<body>";
echo validation_errors();
echo form_open('r6_C/form');
echo "<select name='teacher'". htmlspecialchars($_SERVER['PHP_SELF']).">";//本地接受表单
//$select_value = isset($_POST['teacher']) ? $_POST['teacher'] : '';

foreach($list as $list1)
{
	//$choose=($select_value==$list1['EID']? 'selected':'');//下拉选择提交后，保留选择项
	//下拉选择
	/*echo "<option value =".$list1['EID']." $choose>".$list1['EID'].':'.$list1['INFO']."</option>";*/
	echo "<option value=".$list1['EID'].">".$list1['EID'].':'.$list1['INFO']."</option>";
}

echo "</select>
	<input type='submit' value='提交'/>
	</form>
	</body>";
?>
