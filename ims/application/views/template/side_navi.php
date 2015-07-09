<!--
1 for 个人信息
2 for 信息管理
3 for 权限管理
4 for 系统信息
-->

<div class="container-fluid" style="
padding-top: 5%;
">
<div class="row">
  <div class="col-sm-3 col-md-2 sidebar">
   <ul class="nav nav-sidebar">
    <?php if ($type == 1 || $type == 2): ?>
    <?php if ($navi == 1): ?>
    <li class="active">
    <?php else: ?>
    <li>
    <?php endif;?>
    <a href="<?php if ($type == 1) {
	echo site_url('ims/ims_basic_info');
} else {
	echo site_url('ims/ims_basic_info_teacher');
}
?>">个人信息</a></li>
  <?php endif;?>

  <?php if ($type == 2 || $type == 3 || $type == 4 || $type == 5 || $type == 6): ?>
  <?php if ($navi == 2): ?>
  <li class="active">
  <?php else: ?>
  <li>
  <?php endif;?>
  <a href="<?php echo site_url('ims/ims_management');?>">信息管理</a></li>
<?php endif;?>

  <?php if ($type == 3 || $type == 4): ?>
  <?php if ($navi == 3): ?>
  <li class="active">
  <?php else: ?>
  <li>
  <?php endif;?>
  <a href="<?php echo site_url('ims/ims_permission');?>">权限管理</a></li>
<?php endif;?>


<?php if ($type == 4): ?>
  <?php if ($navi == 4): ?>
  <li class="active">
  <?php else: ?>
  <li>
  <?php endif;?>
  <a href="<?php echo site_url('ims/ims_system');?>">系统信息</a></li>
<?php endif;?>
</ul>
</div>