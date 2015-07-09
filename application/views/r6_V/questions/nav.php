  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="<?php echo site_url('llse_welcome');?>">教务管理系统</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="<?php site_url('ims/ims_welcome');?>"><?php $type=$this->session->userdata('user_type'); $tid = $this->session->userdata('tid'); echo $this->session->userdata('tid');?></a></li>
          <li><a href="<?php echo site_url('modify_pass');?>">修改密码</a></li>
          <?php if ($type == 1): ?>
            <li><a target="_blank" href="<?php echo base_url();?>metadata/student_help.html">帮助文档</a></li>
          <?php elseif ($type == 2): ?>
            <li><a target="_blank" href="<?php echo base_url();?>metadata/teacher_help.html">帮助文档</a></li>
          <?php elseif ($type == 3): ?>
            <li><a target="_blank" href="<?php echo base_url();?>metadata/manager_help.html">帮助文档</a></li>
          <?php elseif ($type == 4): ?>
            <li><a target="_blank" href="<?php echo base_url();?>metadata/admin_help.html">帮助文档</a></li>
          <?php elseif ($type == 5): ?>
            <li><a target="_blank" href="<?php echo base_url();?>metadata/colmanager_help.html">帮助文档</a></li>
          <?php else: ?>
            <li><a target="_blank" href="<?php echo base_url();?>metadata/assistant_help.html">帮助文档</a></li>
          <?php endif;?>
          <li><a href="<?php echo site_url('login');?>">注销</a></li>
        </ul>
      </div>
    </div>
  </nav>
  
  		<div class="container-fluid" >
		<div class="row">
		  <div class="col-sm-3 col-md-2 sidebar">
		   <ul class="nav nav-sidebar">
		   <li>
			  <a href="<?php echo site_url('ims/ims_welcome');?>">信息管理子系统</a>
		  </li>
		   <li>
			  <a href="<?php echo site_url('r2/admin_classroom_edit');?>">排课子系统</a>
		  </li>
		  <li>
			  <a href="<?php echo site_url('r3_student');?>">选课子系统</a>
		  </li>
		   <li>
			  <a href="<?php echo site_url('ims/ims_welcome');?>">课程资源子系统</a>
		  </li>
		  <li>
			  <a href="<?php echo site_url('r6_C/welcome/welc');?>">在线考试子系统</a>
		  </li>
		   <li>
			  <a href="<?php echo site_url('ims/ims_welcome');?>">成绩管理子系统</a>
		  </li>
		</ul>
		</div>