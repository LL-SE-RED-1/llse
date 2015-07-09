

 <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


  <div class="col-xs-6 col-sm-6 huge-placeholder">

    <h2 class="sub-header">信息管理</h2>

  </div>

  <div class="col-xs-6 col-sm-6 huge-placeholder">

    <!--h2 class="ui header">Search</h2-->

    <!--div class="ui action left icon input placeholder transparent-seg right floated segment" style="margin-right: 2rem;">
    <i class="search icon" style="
    left: auto;
    "></i>
    <input type="text" placeholder="_(:з」∠)_">
    <div class="ui teal button">搜索</div>
  </di3-->

  <div class="ui hidden divider"></div>
  <div class="ui hidden divider"></div>

  <div class="ui form transparent-seg right floated segment" style="visibility:hidden">
    <div class="inline fields">

      <div class="field">
        <div class="ui radio checkbox checked">
          <input type="radio" name="fruit" checked="checked">
          <label>搜索课程</label>
        </div>
      </div>

      <div class="field">
        <div class="ui radio checkbox">
          <input type="radio" name="fruit">
          <label>搜索学生</label>
        </div>
      </div>


      <div class="field">
        <div class="ui radio checkbox">
          <input type="radio" name="fruit">
          <label>搜索老师</label>
        </div>
      </div>

	  
    </div>
  </div>

</div>

<div class="row placeholder">

  <?php if ($type == 3 || $type == 4 || (($type == 6) && $assistant['addStu'])): ?>
  <div class="col-xs-4 col-sm-3 placeholder">

    <a href="<?php echo site_url('ims/')?>/ims_add_student">
      <div class="text-center at-center">
        <img class="ui small circular image at-center" src="<?php echo base_url()?>/images/student.png">
        <p></p>
        <p>添加学生</p>
      </div>
    </a>
  </div>
  <?php endif;?>

  <?php if ($type == 3 || $type == 4 || (($type == 6) && $assistant['addTea'])): ?>
  <div class="col-xs-4 col-sm-3 placeholder">
    <a href="<?php echo site_url('ims/')?>/ims_add_teacher">
      <div class="text-center at-center">
        <img class="ui small circular image at-center" src="<?php echo base_url()?>/images/teacher.png">
        <p></p>
        <p>添加老师</p>

      </div>
    </a>
  </div>
<?php endif;?>

<?php if ($type == 5 || $type == 4 || $type == 3 || (($type == 6) && $assistant['addCour'])): ?>
  <div class="col-xs-4 col-sm-3 placeholder">

    <div class="text-center at-center">
      <a href="<?php echo site_url('ims/')?>/ims_add_course">
        <img class="ui small circular image at-center" src="<?php echo base_url()?>/images/book.jpg">
        <p></p>
        <p>添加课程</p>
      </a>
    </div>

  </div>
<?php endif;?>

<?php if ($type == 4 || $type == 3): ?>
  <div class="col-xs-4 col-sm-3 placeholder">
    <a href="<?php echo site_url('ims/')?>/ims_add_assistant">
      <div class="text-center">
        <img class="ui small image at-center-2" src="<?php echo base_url()?>images/assistant.png">
        <p></p>
        <p>添加助管</p>
      </div>
    </a>
  </div>
<?php endif;?>

<!--
  <div class="col-xs-4 col-sm-3 placeholder">
    <a href="<?php echo site_url('ims/')?>/ims_check_course">
      <div class="text-center at-center">
        <img class="ui small circular image at-center" src="<?php echo base_url()?>/images/validate.jpg">
        <p></p>
        <p>审核课程</p>
      </div>
    </a>
  </div>
 -->

</div>


<div class="row placeholder">

<?php if ($type == 4 || $type == 3 || (($type == 6) && $assistant['seaStu'])): ?>
  <div class="col-xs-4 col-sm-3 placeholder">

    <a href="<?php echo site_url('ims/')?>/ims_search_student">
      <div class="text-center at-center-2">
        <img class="ui small image at-center-2" src="<?php echo base_url()?>images/student_search.png">
        <p></p>
        <p>搜索学生</p>
      </div>
    </a>
  </div>
<?php endif;?>

<?php if ($type == 4 || $type == 3 || (($type == 6) && $assistant['seaTea'])): ?>
  <div class="col-xs-4 col-sm-3 placeholder">
    <a href="<?php echo site_url('ims/')?>/ims_search_teacher">
      <div class="text-center">
        <img class="ui small image at-center-2" src="<?php echo base_url()?>images/teacher_search.png">
        <p></p>
        <p>搜索老师</p>

      </div>
    </a>
  </div>
  
<?php endif;?>


<?php if ($type == 2 || $type == 5 || $type == 4 || $type == 3 || (($type == 6) && $assistant['seaCour'])): ?>
  <div class="col-xs-4 col-sm-3 placeholder">
    <a href="<?php echo site_url('ims/')?>/ims_search_course">
      <div class="text-center">
        <img class="ui small image at-center-2" src="<?php echo base_url()?>images/book_search.png">
        <p></p>
        <p>搜索课程</p>
      </div>
    </a>
  </div>
<?php endif;?>


<?php if ($type == 4 || $type == 3): ?>
  <div class="col-xs-4 col-sm-3 placeholder">
    <a href="<?php echo site_url('ims/')?>/ims_search_assistant">
      <div class="text-center">
        <img class="ui small image at-center-2" src="<?php echo base_url()?>images/assistant_search.png">
        <p></p>
        <p>搜索助管</p>
      </div>
    </a>
  </div>
<?php endif;?>



<!--   <div class="col-xs-4 col-sm-3 placeholder">

    <div class="text-center">
      <a href="<?php echo site_url('ims/')?>/ims_request_manage">
        <img class="ui small image at-center-2" src="<?php echo base_url()?>images/book-pen.png">
        <p></p>
        <p>添加课程申请</p>
      </a>
    </div>

  </div> -->


</div>
</div>
</div>
</div>



<script type="text/javascript">
$(document)
.ready(function(){
  $('.ui.dropdown')
  .dropdown()
  ;
  $('.ui.menu .dropdown')
  .dropdown({
    on: 'hover'
  })
  ;
})
;
</script>



    <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200" preserveAspectRatio="none" style="visibility: hidden; position: absolute; top: -100%; left: -100%;"><defs></defs><text x="0" y="10" style="font-weight:bold;font-size:10pt;font-family:Arial, Helvetica, Open Sans, sans-serif;dominant-baseline:middle">200x200</text></svg><div id="feedly-mini" title="feedly Mini tookit"></div>
  </body>

<style type="text/css">

  .text-center {
    text-align: center;
  }

  .ui.small.circular.image.at-center {
    display: block;
    margin: 0 auto;
  }

  .ui.small.image.at-center-2 {
      margin: 0 auto;
      border-radius: 0;
      display: inline-block;
  }

  .ui.transparent-seg {
    background-color: rgba(255, 255, 255, 0);
    box-shadow: 0px 0px 0px 0px;
    padding: 0em 0em;
  }

</style>
  </html>
