</div>
</div>
</div>
</div>

<script>
	
$(document).ready(function(){
	$(".del-btn").on("click", function(){
		if (!confirm("确定要删除该共享文件吗?"))
			return;
		var fileid = +$(this).attr("data-fileid"),
			courseid = +$(this).attr("data-courseid"),
			role = $(this).attr("data-role"),
			p = $(this).parents(".trow");
		$.post("<?=site_url()?>/resource" + role + "/deletecoursefile/" + courseid + "/" + fileid,
			function(data){
				p.hide(500);
				setTimeout(function(){p.remove();}, 500);
			}
		);
	});
	
	$(".deletable-file .glyphicon-remove").on("click", function(){
		if (!confirm("确定要删除该相关资料吗?"))
			return;
		var fileid = +$(this).attr("data-fileid"),
			homeworkid = +$(this).attr("data-homeworkid"),
			p = $(this).parent();
		$.post("<?=site_url()?>/resource/teacher/deletehomeworkfile/" + fileid + "/" + homeworkid,
			function(data){
				p.hide(500);
				setTimeout(function(){p.remove();}, 500);
			}
		);
	});
	$(".del-hw-btn").on("click", function(){
		if (!confirm("确定要删除该作业吗?"))
			return;
		var homeworkid = +$(this).attr("data-homeworkid"),
			p = $(this).parents(".row");
		$.post("<?=site_url()?>/resource/teacher/deletehomework/" + homeworkid,
			function(data){
				p.hide(500);
				setTimeout(function(){p.remove();}, 500);
			}
		);
	});
});
</script>
<div class="overlay">
	<style>
		.overlay{
			font-family: "Helvetica Neue", 'Microsoft YaHei', Helvetica, Arial, sans-serif;
			display:none;
			position: fixed;
            z-index:10000;
			top: 0px;
			bottom: 0px;
			right: 0px;
			left: 0px;
			background: rgba(100, 100, 100, 0.4);
		}
		
		.overlay .upload-div{
			position: absolute;
			top: 50%;
			left: 50%;
			width: 300px;
			height: 140px;
			margin-top: -70px;
			margin-left: -150px;
			background: white;
			box-shadow: 3px 3px 5px gray;
			border-radius: 4px;
		}
		#form-upload{
			width:100%;
			margin: 15px 10px 10px;
		}
		#filename{
			display:inline-block;
			width:130px;
			height:24px;
			vertical-align:middle;
			text-overflow:ellipsis;
			white-space: nowrap;
			overflow:hidden;
		}
		.progress-wrap{
			width:100%;
			padding:10px;
			height:40px;
		}
		.progress{
			margin-bottom : 0px;
		}
		#cancel-btn{
			float:right;
			margin-right:15px;
		}
		#success-info{
			width:100%;
			font-size:20px;
			text-align:center;
			display:none;
		}
	</style>
	<div  class="upload-div">
		<form id="form-upload" action="<?=site_url($urlprefix."/test")?>" method="post">
			<label for="in-fileupload" class="btn btn-success">更改文件</label>
			<input type="file" id="in-fileupload">
			<span id="filename"></span>
			<input type="submit" class="btn btn-primary" value="上传">
		</form>
		<div class="progress-wrap">
			<div class="progress">
			  <div class="progress-bar progress-bar-info progress-bar-striped" id="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
			    <span class="sr-only">60% Complete</span>
			  </div>
			</div>
		</div>
		<input type="button" class="btn" id="cancel-btn" value="取消">
		<div id="success-info">
			<span >上传成功</span>
		</div>
	</div>
</div>
</body>
</html>
