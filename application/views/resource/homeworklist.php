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
		.m-thead>div, .trow>div{
			float:left;
		}
		.m-tmain{
			top:100px;
		}
		.glyphicon-ok-sign{
			color:#5cb85c;
		}
		.glyphicon-remove-sign{
			color:#d9534f;
		}
		.glyphicon-alert{
			color:#f0ad4e;
		}
		.m-thead>div:nth-child(1), .trow>div:nth-child(1){
			width:3%;
			font-size:18px;
		} 
		.m-thead>div:nth-child(2), .trow>div:nth-child(2){
			width:20%;
		} 
		.m-thead>div:nth-child(3), .trow>div:nth-child(3){
			width:10%;
		} 
		.m-thead>div:nth-child(4), .trow>div:nth-child(4){
			width:10%;
		} 
		.m-thead>div:nth-child(5), .trow>div:nth-child(5){
			width:15%;
		}
		.m-thead>div:nth-child(6), .trow>div:nth-child(6){
			width:25%;
		}
		.m-thead>div:nth-child(7), .trow>div:nth-child(7){
			width:10%;
		}
		.m-thead>div:nth-child(8), .trow>div:nth-child(8){
			width:7%;
		}
	</style>
	<!--<col width="3%"><col width="20%"><col width="10%"><col width="10%"><col width="15%"><col width="25%"><col width="10%"><col width="7%">-->
	<?php include "templates/nav.php" ?>
	<div class="m-thead">
		<div ></div>
    <div >作业名称</div>
    <div >开始时间</div>
    <div >截止时间</div>
		<div >相关资料</div>
    <div >上传文件</div>
    <div >上传时间</div>
		<div >作业得分</div>
  </div>
  <div class="m-tmain">
    <div class="m-tbody table-striped">
  	<?php $i = 0;foreach($work as $item): $i++;?>
			<div class="trow row" data-homeworkid="<?=$item["id"]?>">
				<div>
				<?php if (isset($item["uploadedfile"]["fileid"]) || $item["score"] != NULL):?>
					<span class="glyphicon glyphicon-ok-sign"></span>
				<?php elseif($item["toolate"]):?>
					<span class="glyphicon glyphicon-remove-sign"></span>
				<?php else: ?>
					<span class="glyphicon glyphicon-alert"></span>
				<?php endif;?>
				</div>
        <div >
					<a href="<?=site_url($urlprefix."/workinfo/".$item["id"])?>"><?=$item["name"]?></a>
				</div>
        <div ><?=$item["starttime"]?></div>
        <div ><?=$item["endtime"]?></div>
        <div >
				<?php foreach($item["related"] as $related):?>
					<div class="downloadable-file" title="<?=$related["filename"]?>">
						<a href="<?=site_url($urlprefix."/downloadhomeworkfile/".$related["fileid"]."/".$related["homeworkid"])?>"><?=$related["filename"]?></a>
					</div>
				<?php endforeach;?>
				</div>
				<div >
					<?php if (!$item["toolate"]):?>
					<label for="in-fileupload" class="btn btn-success" data-homeworkid="<?=$item["id"]?>">上传文件</label>
					<?php else:?>
					<label for="in-fileupload" class="btn btn-danger disabled" data-homeworkid="<?=$item["id"]?>">上传文件</label>
					<?php endif;?>
					<?php if (isset($item["uploadedfile"]["fileid"])):?>
					<div class="downloadable-file" title="<?=$item["uploadedfile"]["filename"]?>">
					<a href="<?=site_url($urlprefix."/downloadstudenthomework/".$studentid."/".$item["id"])?>"><?=$item["uploadedfile"]["filename"]?></a>
					</div>
					<?php endif;?>
				</div>
				<?php if (!isset($item["uploadtime"])):?>
					<div >未上传</div>
				<?php else:?>
					<div ><?=$item["uploadtime"]?></div>
				<?php endif?>
				<div ><?=$item["score"]?></div>
      </div>
	  <?php endforeach ?>
    </div>
		<script>
			var homeworkid;
			$("label[for='in-fileupload']").on('click',function(evt){
				homeworkid = +$(this).attr("data-homeworkid");
			});
			$(document).ready(function(){
				uploaderInit({
					desfunc:"<?=site_url($urlprefix."/uploadstudenthomework");?>",
					onloaded:function(){
						location.reload();
					},
					appendData:function(data){
						data.append("homeworkid", homeworkid);
					}
				})
			});
		</script>
  </div>
	<div class="m-page">
		<?php include "templates/page.php" ?>
	</div>
</div>
<?php include "templates/footer.php"?>
