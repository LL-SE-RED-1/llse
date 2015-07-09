<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


    <div class="col-xs-6 col-sm-6 huge-placeholder">

        <h2 class="sub-header">课程查询</h2>

    </div>


    <div class="col-xs-6 col-sm-6 huge-placeholder">
        <div class="ui right floated transparent-seg segment">
            <form class="ui form" action="<?php echo site_url('ims/ims_search_course/search')?>" method="post">
                <div class="ui left labeled icon input">
                    <div class="ui teal dropdown label">
                        <div class="text">编号</div>
                        <i class="dropdown icon"></i>
                        <input name="var" type="hidden" value="cid">
                        <div class="menu">
                            <div class="item" data-value="cid">编号</div>
                            <div class="item" data-value="name">课名</div>
                            <div class="item" data-value="college">学院</div>
                        </div>
                    </div>
                    <input name="text" type="text" placeholder="_(:з」∠)_">
                    <i class="search icon"></i>
                </div>
            </form>
        </div>



        <div class="ui hidden divider"></div>
        <div class="ui hidden divider"></div>

        <div class="ui form transparent-seg right floated segment">
            <div class="inline fields">
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-12">
        <table class="ui striped table">
            <thead>
                <tr>
                    <th class="center aligned">课程名称</th>
                    <th class="center aligned">课程编号</th>
                    <th class="center aligned">开课学院</th>
                    <th  class="center aligned">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($info)): ?>
                <?php foreach ($info as $item): ?>
                <tr>
                    <form class="ui form" action="<?php echo site_url('ims/ims_add_course') . "/" . "index/" . $item['cid'] . '/1'?>" method="post">
                        <td  class="center aligned"><?php echo $item['name']?></td>
                        <td  class="center aligned"><?php echo $item['cid']?></td>
                        <td  class="center aligned"><?php echo $item['college']?></td>
                        <td class="center aligned">
                            <button class="ui  button modify labeled icon button" type="submit">
                                <i class="info  icon"></i> 查看详情
                            </button>

                        </td>
                    </form>

                </tr>
            <?php endforeach;?>
        <?php endif;?>
    </tbody>
</table>
<br>
<?php if ($type == 3): ?>
<form action="<?php echo site_url('ims/ims_add_course')?>" method="post">
    <button class="ui right floated primary labeled icon button" id="add-course" type="submit">
        <i class="user icon"></i> 添加课程
    </button>
</form>
<!-- <form action="<?php echo site_url('ims/ims_request_manage')?>" method="post">
    <button class="ui right floated primary labeled icon button" id="id-course-req" type="submit">
        <i class="user icon"></i> 添加课程申请
    </button>
</form> -->
<?php endif;?>
</div>
</div>
</div>



<script type="text/javascript">

$(".ui.green.button.modify.student").click(function() {
    console.log($(this).closest("tr").children(':first-child').next().text());
});

$(".ui.red.button.delete.student").click(function() {
    console.log($(this).closest("tr").children(':first-child').next().text());
    $(this).closest("tr").remove();
});

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

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--script src="./js/jquery.min.js"></script-->




    <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200" preserveAspectRatio="none" style="visibility: hidden; position: absolute; top: -100%; left: -100%;"><defs></defs><text x="0" y="10" style="font-weight:bold;font-size:10pt;font-family:Arial, Helvetica, Open Sans, sans-serif;dominant-baseline:middle">200x200</text></svg><div id="feedly-mini" title="feedly Mini tookit"></div></body>
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
