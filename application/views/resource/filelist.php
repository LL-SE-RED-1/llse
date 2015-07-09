<?php
//requirement:
//文件列表(filename, uploaderid, uploader_name, time, filesize, fileid, download(用以下载和删除文件))
//userid, courseid(用以删除文件);

//other interfaces required
//						downloadcoursefile(fileid, courseid);
//						deletecoursefile(courseid, fileid);
//						uploadecoursefile(courseid)
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
        .glyphicon-arrow-up{
            color:#46b8da;
        }
	</style>
	<?php include "templates/nav.php" ?>
	<div class="m-thead m-sort">
    <div class="col-xs-3" data-order='filename'>文件名称</div>
    <div class="col-xs-2" data-order='uploader'>上传者</div>
    <div class="col-xs-2" data-order='uploadtime'>上传时间</div>
		<div class="col-xs-2" data-order='size'>上传文件大小</div>
		<div class="col-xs-1" data-order='download'>下载次数</div>
		<div class="col-xs-2"></div>
  </div><!-- .m-thead -->
  <div class="m-tmain">
    <div class="m-tbody table-striped">
  <?php foreach($data as $item):?>
      <div class="row" data-fileid="<?=$item["fileid"]?>">
        <div class="col-xs-3"><?=$item["filename"]?>
                <?php if($item["istop"]):?>
                    <span class="glyphicon glyphicon-arrow-up"></span>
                <?endif;?>
        </div>
		    <div class="col-xs-2"><?=$item["username"]?></div>
		    <div class="col-xs-2"><?=$item["time"]?></div>
				<div class="col-xs-2"><?=$item["filesize"]?></div>
				<div class="col-xs-1">
                <?=$item["download"]?>
                </div>
				<div class="col-xs-2"><button type="button" class="btn btn-success" 
					onclick="location.href='<?=site_url($urlprefix."/downloadcoursefile/".$item["fileid"]."/".$courseid)?>'">下载</button>
				<?php if ($role == "teacher" || $role == "student" && $userid == $item["uploaderid"]): ?>
					<button type="button" class="btn del-btn" data-courseid="<?=$courseid?>" data-fileid="<?=$item["fileid"]?>" 
						data-role = "<?=$role?>" >删除</button>
				<?php else: ?>
					<button type="button" class="btn disabled del-btn" data-courseid="<?=$courseid?>" data-fileid="<?=$item["fileid"]?>" 
						data-role = "<?=$role?>" >删除</button>
				<?php endif; ?>
				<?php if ($role == "teacher" && !$item["istop"]):?>
					<button type="button" class="btn btn-info" title="置顶七天" onclick="location.href='<?=site_url("$urlprefix/settop/$courseid/".$item["fileid"]);?>'">置顶</button>
				<?php elseif ($role == "teacher"): ?>
                    <button type="button" class="btn btn-info" onclick="location.href='<?=site_url("$urlprefix/canceltop/$courseid/".$item["fileid"]);?>'">取消置顶</button>
                <?php endif; ?>
				</div>
      </div><!-- .row -->
  <?php endforeach ?>
    </div><!-- .m-tmain -->
		
		<script>
			$(document).ready(function(){
				//initialize the upload components
				uploaderInit({
					desfunc:"<?=site_url($urlprefix."/uploadcoursefile/".$courseid);?>",
					onloaded:function(){
						location.reload();
					}
				});
				
				//declear two compare functions
				function gt(a, b){return a > b;}
				function lt(a, b){return a < b;}
				var sort_methods = [lt, gt];
				
				var sort_item = null, m_tbody = $(".m-tbody"), m_thead = $(".m-thead>div"), sort_method_ind,
					sort_mark = $('<span class="glyphicon glyphicon-triangle-top" id="sort-mark"></span>'),
					classes = ["glyphicon-triangle-top", "glyphicon-triangle-bottom"];;
				
				//bind the click event
				m_thead.on("click", function(evt){
					//when the current sort item is not the same as the one beform
					if (sort_item !== $(this).parent().children().index($(this))){
						//calculate the index of the clicked item
						sort_item = $(this).parent().children().index($(this));
						sort_mark.remove();
						sort_method_ind = 1;	
						$(this).append(sort_mark);
						sort_mark.removeClass(classes[1 - sort_method_ind]);
						sort_mark.addClass(classes[sort_method_ind]);
					} else {
						//if they are the same, just exchange the classes
						sort_method_ind = 1 - sort_method_ind;
						sort_mark.removeClass(classes[1 - sort_method_ind]);
						sort_mark.addClass(classes[sort_method_ind]);
					}
					
					var items = m_tbody.children();
					//sort the table items
					items.sort(function(v0, v1){
						v0 = $(v0);
						v1 = $(v1);
						if (sort_item > 2)
							return sort_methods[sort_method_ind](+v0.children().eq(sort_item).text(), +v1.children().eq(sort_item).text()); 
						return sort_methods[sort_method_ind](v0.children().eq(sort_item).text(), v1.children().eq(sort_item).text());
					});
					//remove the existed items
					m_tbody.children().remove();
					//add the sorted items;
					m_tbody.append(items);
				});
			});
		</script>
  </div>
	<div class="m-page">
		<?php include "templates/page.php" ?>
	</div>
</div>
<?php include "templates/footer.php"?>
