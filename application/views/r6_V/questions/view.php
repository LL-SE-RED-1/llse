        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1 class="page-header"><?php echo $title ?></h1>
          
          <div class="table-responsive">
  <form action='<?php echo site_url('r6_C/welcome/welc');?>' method='post'>
<input type='submit' class="btn btn-default" value='返回'>
<br></form>
  

<?php echo validation_errors(); ?>

<?php //echo form_open('questions/view') ?>
<form action="<?php echo site_url('r6_C/questions/view');?>" method="get" onsubmit="return validate_form(this.SEARCH.value,this.KEYWORD.value)" accept-charset="utf-8">

  	<label for="title">搜索</label>
  	<input type="input" name="KEYWORD" /><br /><br />

	<label for="SEARCH_I"><input type="radio" name="SEARCH" id="SEARCH_I" value="ID" checked="checked">&nbsp;按序号</label>
	<label for="SEARCH_C"><input type="radio" name="SEARCH" id="SEARCH_C" value="CONTENT">&nbsp;按内容</label>

	<br /><br />
  	<input type="submit" class="btn btn-default" name="submit" value="SEARCH" /> 

</form><hr>
<h3><?php echo $res ?></h3>
<h3><?php echo $search_res ?></h3>


