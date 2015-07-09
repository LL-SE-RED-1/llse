<?php
//require 项目列表(name, course, courseid, id(作业则是homeworkid, 文件则是fileid),(type(作业还是文件))
//domain/controller/func/year/semester/search_str/分页变量
?>
<?php include "templates/header.php"?>
<div class="m-cont">
  <div class="m-thead">
    <div class="col-xs-5">名称</div>
    <div class="col-xs-4">课程名称</div>
    <div class="col-xs-3">类型</div>
  </div>
  <div class="m-tmain">
    <div class="m-tbody">
  <?php foreach($data as $item):?>
      <div class="row">
        <?php if($item["type"] === SEARCH_TYPE_FILE): ?>
        <div class="col-xs-5"><a href="<?=site_url($urlprefix."/filelist_all/".$item["courseid"])."#".$item["fileid"]?>"><?=$item["name"]?></a></div>
        <div class="col-xs-4"><?=$item["course"]?></div>
        <div class="col-xs-3"><?=$item["type"]?></div>
        <?php elseif($item["type"] === SEARCH_TYPE_HOMEWORK): ?>
        <div class="col-xs-5"><a href="<?=site_url($urlprefix."/homeworklist/".$item["courseid"])."#".$item["homeworkid"]?>"><?=$item["name"]?></a></div>
        <div class="col-xs-4"><?=$item["course"]?></div>
        <div class="col-xs-3"><?=$item["type"]?></div>
        <?php endif; ?>
      </div>
  <?php endforeach ?>
    </div>
  </div>
  <div class="m-page">
    <?php include "templates/page.php"?>
  </div>
</div>
<?php include "templates/footer.php"?>
