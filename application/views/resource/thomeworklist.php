<?php
//requirement:
//作业列表(homeworkid, homeworkname, starttime, endtime, relavant files(array of name and fileid), uploadedfile(fileid, filename), uploadtime, s core);
//courseid

//其他接口要求：downloadFile(fileid);
//						 uploadFIle(homeworkid, studentid, **************************)
//domainname/controller/func/courseid/分页变量;
?>

<?php include "templates/cheader.php"?>
<div class="m-cont">
	<style>
		.m-thead{
			top:60px;
		}
		.m-tmain{
			top:100px;
		}
	</style>
	<?php include "templates/nav.php" ?>
	<div class="m-thead">
    <div class="col-xs-2">作业名称</div>
    <div class="col-xs-2">开始时间</div>
    <div class="col-xs-2">截止时间</div>
		<div class="col-xs-2">相关资料</div>
		<div class="col-xs-3"></div>
  </div>
  <div class="m-tmain">
    <div class="m-tbody table-striped">
  	<?php $i = 0;foreach($work as $item): $i++;?>
			<div class="row" data-homeworkid="<?=$item["id"]?>">
				<form>
	        <div class="col-xs-2"><a href="<?=site_url($urlprefix."/studentlist/".$item["id"])?>"><?=$item["name"]?></a></div>
	        <div class="col-xs-2"><?=$item["starttime"]?></div>
	        <div class="col-xs-2"><?=$item["endtime"]?></div>
	        <div class="col-xs-2">
						<?php foreach($item["related"] as $related):?>
						<div class="deletable-file">
							<a href="<?=site_url($urlprefix."/downloadfile/".$related["fileid"]."/".$related["filename"])?>">
							<?=$related["filename"]?>
							</a>
							<span class="glyphicon glyphicon-remove" title="删除" data-fileid="<?=$related["fileid"]?>" data-homeworkid="<?=$item["id"]?>"></span>
						</div>
						<?php endforeach;?>
					</div>
					<div class="col-xs-3">
						<label for="in-fileupload" class="btn btn-primary" data-homeworkid="<?=$item["id"]?>">上传相关资料</label>
						<button type="button" class="btn btn-success" onclick="location.href='<?=site_url($urlprefix."/changehomework/".$item["id"]);?>'">修改</button>
						<button type="button" class="btn del-hw-btn" data-homeworkid="<?=$item["id"]?>" data-courseid="<?=$courseid?>">删除</button>
					</div>
					<?php if($item["toolate"]): ?>
					<div class="col-xs-1"><label class="label-danger label">已截止</label></div>
					<?php endif;?>
				</form>
      </div>
	  <?php endforeach ?>
    </div>
  </div>
	<script>
			var homeworkid;
			$("label[for='in-fileupload']").on('click',function(evt){
				homeworkid = +$(this).attr("data-homeworkid");
			});
			$(document).ready(function(){
				uploaderInit({
					desfunc:"<?=site_url($urlprefix."/uploadhomeworkfile");?>",
					onloaded:function(){
						location.reload();
					},
					appendData:function(data){
						data.append("homeworkid", homeworkid);
					}
				});
			});
	</script>
	<div class="m-page">
		<?php include "templates/page.php" ?>
	</div>
</div>
<?php include "templates/footer.php"?>
