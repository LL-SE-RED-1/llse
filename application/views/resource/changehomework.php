<?php
//requirement
//courseid
//接口要求: add_homework(courseid, name, starttime, endtime, fileids(array), comment);
//				 uploadFile(************) 返回文件id和名称
?>
<?php include "templates/cheader.php"?>
<style>		
input[type="text"], textarea{
	width:250px;
}
.alert{
	display:inline-block;
	padding:2px;
	margin-left:1em;
	margin-bottom:0;
}
</style>
<div class="m-cont">
	<form id="addhomework" action="post" class="input-group-sm">
	<table class="table table-striped">
	<col width="25%"><col width="75%">
	<tr><th>作业名称</th><td><input type="text" name="name" value="<?=$name?>" placeholder="YYYY-MM-DD HH:mm:ss"></td></tr>
	<tr><th>开始时间</th><td>
        <input type='text' id='datetimepicker4' name="starttime" value="<?=$starttime?>/>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker4').datetimepicker({
                format:"YYYY-MM-DD HH:mm:ss"
                });
            });
        </script>
        </td></th>
	<tr><th>结束时间</th><td>
        <input type='text' id='datetimepicker5' name="endtime" value="<?=$endtime?>/>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker5').datetimepicker({
                    format:"YYYY-MM-DD HH:mm:ss"
                });
            });
        </script>
	<tr><th>相关资料</th>
		<td>
		<?php foreach($related as $item): ?>
			<div class="deletable-file" >
				<input type="type" name="fileid[]" style="display:none" value = "<?=$item["fileid"]?>">
				<input type="type" name="filename[]" style="display:none" value = "<?=$item["filename"]?>">
				<a href="<?=$item["fileid"]?>" title="<?=$item["filename"]?>"><?=$item["filename"]?></a><span class="glyphicon glyphicon-remove" title="删除"
					data-fileid="<?=$item["fileid"];?>" data-homeworkid="<?=$homeworkid?>"></span>
			</div>
		<?php endforeach;?>
			<label for="in-fileupload" class="btn btn-success">上传文件</label>
		</td>
	</tr>
	<tr><th>详细信息</th><td><textarea name="detail" id="" rows="10"><?=$detail?></textarea></td></tr>
	</table>
	<button type="submit" id="submit-btn" class="btn btn-warning">提交</button>
	</form>
</div>
<script>
	//$("input[name='startyear']").datetimepicker();
	//$("input[name='endyear']").datetimepicker();
	$("#submit-btn").on("click", function(evt){
		var flag = true, startflag = isValidTime($("input[name='starttime']").val()), 
			endflag = isValidTime($("input[name='endtime']").val(), true);
		$(".alert").remove();
		evt.preventDefault();
		if ($("input[name='name']").val() == ""){
			$("input[name='name']").after(alertMessage("请输入作业名称"));
			flag = false;
		}
		if (!endflag){
			$("input[name='starttime']").after(alertMessage("请按格式(YYYY-MM-dd HH:mm:ss)输入时间"));
			flag = false;
		}
		if (!isValidTime($("input[name='endtime']").val(), true)){
			$("input[name='endtime']").after(alertMessage("请按格式(YYYY-MM-dd HH:mm:ss)输入时间"));
			flag = false;
		}
		if (startflag && endflag && startflag > endflag){
			flag = false;
			$("input[name='endtime']").after(alertMessage("结束时间应该晚于开始时间"));
		}
		if (!flag)
			return;
		makeToast();
		evt.preventDefault();
		$.post("<?=site_url($urlprefix."/changinghomework/".$homeworkid);?>",
			$("form").serialize(),
			function(data, textStatus, jqXHR){
				if (data === "success")
				showToast("提交成功", function(){
					location.href = "<?=site_url($urlprefix."/homeworklist/".$courseid);?>";
				});
				else
					showToast("提交失败");
			});
		$(document).ajaxError(function(evt, jqXHR){
			showToast("提交失败");
		});
	});
	
	$(document).ready(function(){
		uploaderInit({
			desfunc:"<?=site_url($urlprefix."/uploadfile");?>",
			onloaded:function(data){
				data = eval(data)[0];
				var filename = $("#in-fileupload")[0].files[0].name;
				$("table tr:nth-child(4) td").prepend(
					'<div class="deletable-file">\
						<input type="type" name="fileid[]" style="display:none" value = "'+ data.id + '">\
						<input type="type" name="filename[]" style="display:none" value = "' + filename + '">\
						<a href="<?=site_url($urlprefix."/downloadfile");?>/'+ data.id +'/' + filename + '">\
						' + filename + '\
						</a><span class="glyphicon glyphicon-remove" title="删除" data-fileid="' + data.id + '"\
						data-homeworkid="' + data.homeworkid + '"></span>\
					</div>'
				);
			}
		})
	});
</script>
<?php include "templates/footer.php"?>
