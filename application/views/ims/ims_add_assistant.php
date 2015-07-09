<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	

	<!-- TODO 是否保留批量？-->
	    <?php if ($func == 0): ?>
		<div class="ui secondary pointing menu">
			<div class="ui item">
				<h2 class="ui header">添加助管</h2>
			</div>
   
			<a class="right item">
				<i class="grid layout icon"></i>批量添加
			</a>
			<a class="active right item">
				<i class="add square icon"></i>单条添加
			</a>
		</div>
		<?php else: ?>
		<h2 class="sub-header">添加学生</h2>
		
        <?php endif;?>

		<div class="placeholder"></div>

		<!-- TODO 修改 action -->
        <form class="ui form segment transparent-seg" action="<?php echo (site_url('ims/ims_add_assistant/manage') . "/" . $func)?>" method="post">
        <!--new-->
            <div class="ui positive message" style="display: none;">
                <i class="close icon"></i>
                <div class="header">
                    Wow congratulations!
                </div>
                <p>操作成功！</p>
            </div>
            <div class="ui negative message" style="display: none;">
                     <i class="close icon"></i>
                    <div class="header">
                    Oops! 操作失败！
                </div>
                <p><?php echo $result_info;?></p>
            </div>
            <!--new-->

			<div id="not-batch">
            <div class="three fields">
                <div class="required field">
                    <label>助管号</label>
                    <?php if ($func == 0): ?>
                    <input name="uid" type="text" value="">
					<?php else: ?>
					<input name="uid" value="<?php echo ($info['uid'])?>" readonly type="text">
					<?php endif;?>

				</div>
<!--                 <div class="required field">
                    <label>密码</label>
                    <div class="ui icon input">
                        <input type="password" name="new_pass">
                        <i class="lock icon"></i>
                    </div>
                </div>
                <div class="required field">
                    <label>确认密码</label>
                    <div class="ui icon input">
                        <input type="password" name="conform_pass">
                        <i class="lock icon"></i>
                    </div>
                </div> -->

            </div>

			<br>

            <div class="six fields">
                <div class="field">
					<label>权限表</label>
					<div class="ui checkbox">
                    <label>搜索学生</label>
                    <?php if ($func == 0): ?>
                    <input type="checkbox" name="seaStu">
                    <?php else: ?>
                    <input type="checkbox" name="seaStu" 
                        <?php if ($info['seaStu']):?>
                            checked="on"
                        <?php endif;?> >
                    <?php endif;?>
					</div>
                </div>
				<div class="field">
					<label>&nbsp;</label>
					<div class="ui checkbox">
                    <label>搜索老师</label>
                    <?php if ($func == 0): ?>
                    <input type="checkbox" name="seaTea">
                    <?php else: ?>
                    <input type="checkbox" name="seaTea" 
                        <?php if ($info['seaTea']):?>
                            checked="on"
                        <?php endif;?> >
                    <?php endif;?>
					</div>
                </div>
                <div class="field">
					<label>&nbsp;</label>
					<div class="ui checkbox">
                    <label>搜索课程</label>
                    <?php if ($func == 0): ?>
                    <input type="checkbox" name="seaCour">
                    <?php else: ?>
                    <input type="checkbox" name="seaCour" 
                        <?php if ($info['seaCour']):?>
                            checked="on"
                        <?php endif;?> >
                    <?php endif;?>
					</div>
                </div>
                <div class="field">
					<label>&nbsp;</label>
					<div class="ui checkbox">
                    <label>添加学生</label>
                    <?php if ($func == 0): ?>
                    <input type="checkbox" name="addStu">
                    <?php else: ?>
                    <input type="checkbox" name="addStu" 
                        <?php if ($info['addStu']):?>
                            checked="on"
                        <?php endif;?> >
                    <?php endif;?>
					</div>
                </div>
                <div class="field">
					<label>&nbsp;</label>
					<div class="ui checkbox">
                    <label>添加老师</label>
                    <?php if ($func == 0): ?>
                    <input type="checkbox" name="addTea">
                    <?php else: ?>
                    <input type="checkbox" name="addTea" 
                        <?php if ($info['addTea']):?>
                            checked="on"
                        <?php endif;?> >
                    <?php endif;?>
					</div>
                </div>
                <div class="field">
					<label>&nbsp;</label>
					<div class="ui checkbox">
                    <label>添加课程</label>
                    <?php if ($func == 0): ?>
                    <input type="checkbox" name="addCour">
                    <?php else: ?>
                    <input type="checkbox" name="addCour" 
                        <?php if ($info['addCour']):?>
                            checked="on"
                        <?php endif;?> >
                    <?php endif;?>
					</div>
                </div>
            </div>

            <div class="ui grey right floated button" id="back">返回</div>
            <?php if ($func != 0): ?>
				<!-- TODO 修改提交动作  -->
            <button class="ui red right floated  button" type="submit" name="delete" value="delete">删除</button>
            <?php endif;?>
            <button class="ui green  right floated  button" type="submit" name="submit" value="submit">提交</button>
            </div>
        </form>

        <?php if ($func == 0): ?>
        <form class="ui form segment transparent-seg" action="<?php echo (site_url('ims/ims_add_assistant/batchInsert'))?>" method="post">

				<div id="is-batch">
              <div class="required field">
                <label>批量添加内容</label>
                    <textarea name="batch" value="batch"></textarea>
              </div>
               <div class="ui grey right floated button" id="back">返回</div>
            <button class="ui green  right floated  button" type="submit" name="submit" value="submit">提交</button>
			<br>
            </div>

            <!--<div class="ui error message" style="width:30%"></div>-->
        </form>
    <?php endif;?>


        </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--script src="./js/jquery.min.js"></script-->


    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>

    <script src="<?php echo base_url()?>js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="<?php echo base_url()?>js/holder.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url()?>js/ie10-viewport-bug-workaround.js"></script>

    <script src="<?php echo base_url()?>dist/semantic.js"></script>


     <script src="<?php echo base_url()?>js/form_feedack.js"></script>

    <script src="<?php echo base_url()?>js/form_behaviour.js"></script>

    <script type="text/javascript">

        $('.ui.form')
                .form({
                    学号: {
                        identifier: 'uid',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : '请输入助管号'
                            },
                            {
                                type   : 'length[10]',
                                prompt : '助管号需要是十位，请重新输入'
                            },
                            {
                                type   : 'maxLength[11]',
                                prompt : '助管号需要是十位，请重新输入'
                            }
                        ]
                    }//,
					// 密码: {
					// 	identifier: 'new_pass',
					// 	rules: [
					// 		{
					// 			type   : 'empty',
					// 			prompt : '请输入密码'
					// 		}
					// 	]
					// },
					// 确认密码: {
					// 	identifier: 'conform_pass',
					// 	rules: [
					// 		{
					// 			type   : 'empty',
					// 			prompt : '请确认密码'
					// 		},
					// 		{
					// 			type   : 'match[new_pass]',
					// 			prompt : '输入密码与之前不一致，请重新输入'
					// 		}
					// 	]
					// }
                },
                {
                    inline : true,
                    on     : 'blur'
                });



	/*
	var college_and_department;

        $.getJSON("<?php echo base_url()?>metadata/college_and_department.json", function( data ) {
            college_and_department = data;

            for (el in college_and_department['college']){
                console.log(el);
                $('#college-menu').append("<div class='item'>" + el + "</div>");
            }
        });

        $("input[name='college']").change(function(){
            var picked = $(this).attr('value');
            var department_list = college_and_department['college'][picked]['department'];
            $("#department-menu").empty();
            $("#department-text").empty();
            department_list.forEach(function(el, i) {
                $("#department-menu").append("<div class='item'>" + el + "</div>");
            });
        });
*/

        /*$(".dropdown[name='college-dropdown']")
                .dropdown({
                    onChange: function(value, text, $selectedItem) {
                       console.log(text + ", " + value);
                    }
        })
        ;*/

	$(document)
		.ready(function(){
			$("#is-batch").toggle();
			$('.ui.secondary.pointing.menu>.right.item')
				.on('click', function() {
				    if(!$(this).hasClass('active')) {
					    $(this)
					        .addClass('active')
					        .closest('.ui.menu')
					        .find('.item')
					        .not($(this))
					        .removeClass('active')
							;
						$("#not-batch").toggle();
						$("#is-batch").toggle();
					}
				})
				;
		})
		;
    $('.ui.checkbox')
            .checkbox()
    ;


    </script>

<?php if ($result_num == 1): ?>
    <script>
            $(document)
                    .ready(function() {
                        show_positive_message();
                    });
    </script>
<?php endif;?>

<?php if ($result_num == 2): ?>
    <script>
            $(document)
                    .ready(function() {
                        show_negative_message();
                    });
    </script>
<?php endif;?>

<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200"
preserveAspectRatio="none" style="visibility: hidden; position: absolute; top: -100%; left: -100%;"><defs></defs>
<text x="0" y="10" style="font-weight:bold;font-size:10pt;font-family:Arial, Helvetica, Open Sans, sans-serif;dominant-baseline:middle">200x200
</text></svg><div id="feedly-mini" title="feedly Mini tookit"></div></body>
<style type="text/css">

    .text-center {
        text-align: center;
    }

    .ui.small.circular.image.at-center {
        display: block;
        margin: 0 auto;
    }

    .ui.transparent-seg {
        background-color: rgba(255, 255, 255, 0);
        box-shadow: 0px 0px 0px 0px;
        padding: 0em 0em;
    }

    .ui.submit.button {
        float: right;
    }

h2.ui.header {
margin-bottom: -1em !important;  margin-top: -0.665em !important;
}


</style>
</html>
