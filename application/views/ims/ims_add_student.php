<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	

	    <?php if ($func == 0): ?>
		<div class="ui secondary pointing menu">
			<div class="ui item">
				<h2 class="ui header">添加学生</h2>
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

        <form class="ui form segment transparent-seg" action="<?php echo (site_url('ims/ims_add_student/manage') . "/" . $func)?>" method="post">
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
            <div class="four fields">
                <div class="required field">
                    <label>学号</label>
                    <?php if ($func == 0): ?>
                    <input name="uid" type="text" value="">
                <?php else: ?>
                <input name="uid" value="<?php echo ($info['uid'])?>" readonly type="text">
            <?php endif;?>
                </div>
              <div class="required field">
                <label>名字</label>
                <?php if ($func == 0): ?>
                <input name='name'  type="text" value="">
                <?php else: ?>
                <input name='name' value="<?php echo $info['name']?>" type="text">
            <?php endif;?>
              </div>
              <div class="field">
                <label>民族</label>
                  <div class="ui selection dropdown">
                      <div class="default text"></div>
                      <i class="dropdown icon"></i>
                      <?php if ($func == 0): ?>
                      <input name="nation" type="hidden" value="">
                    <?php else: ?>
                      <input name="nation" type="hidden" value="<?php echo $info['nation']?>">
                    <?php endif;?>
                      <div class="menu">
                          <div class="item">汉族</div>
                          <div class="item">其他族</div>
                      </div>
                  </div>
              </div>
                <div class="field">
                    <label>性别</label>
                    <div class="ui selection dropdown">
                        <div class="text"></div>
                        <i class="dropdown icon"></i>
                        <?php if ($func == 0): ?>
                        <input name="sex" type="hidden">
                    <?php else: ?>
                        <input name="sex" type="hidden" value="<?php echo $info['sex']?>">
                    <?php endif;?>
                        <div class="menu">
                            <div class="item" data-value="0">男</div>
                            <div class="item" data-value="1">女</div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="three fields">
                <div class="field">
                    <label>邮箱</label>
                    <?php if ($func == 0): ?>
                    <input name="email"  type="text">
                    <?php else: ?>
                    <input name="email" value="<?php echo $info['email']?>" type="text">
                    <?php endif;?>

                </div>
                <div class="field">
                    <label>生日</label>
                    <?php if ($func == 0): ?>
                    <input name="birthday" placeholder="" type="text">
                    <?php else: ?>
                    <input name="birthday" value="<?php echo $info['birthday']?>" type="text">
                    <?php endif;?>
                </div>
                <div class="field">
                    <label>手机号</label>
                    <?php if ($func == 0): ?>
                    <input name="phone"  type="text">
                    <?php else: ?>
                    <input name="phone" value="<?php echo $info['phone']?>" type="text">
                    <?php endif;?>
                </div>
            </div>

            <div class="four fields">
                <div class="required field">
                    <label>学院</label>
                    <div class="ui selection dropdown" name="college-dropdown">
                        <div class="text"><?php if ($func != 0) {
	echo $info['college'];
}
?></div>
                        <i class="dropdown icon"></i>
                        <?php if ($func == 0): ?>
                        <input name="college" type="hidden">
                    <?php else: ?>
                        <input name="college" type="hidden" value="<?php echo $info['college']?>">
                    <?php endif;?>
                        <div class="menu" id="college-menu">
                        </div>
                    </div>
                </div>
                <div class="required field">
                    <label>学系</label>
                    <div class="ui selection dropdown">
                        <div class="text" id="department-text"><?php if ($func != 0) {
	echo $info['department'];
}
?></div>
                        <i class="dropdown icon"></i>
                        <?php if ($func == 0): ?>
                        <input name="department" type="hidden">
                    <?php else: ?>
                        <input name="department" type="hidden" value="<?php echo $info['department']?>">
                    <?php endif;?>
                        <div class="menu" id="department-menu">
                        </div>
                    </div>
                </div>
                <div class="required field">
                    <label>年级</label>
                    <div class="ui selection dropdown">
                        <div class="default text"></div>
                        <i class="dropdown icon"></i>
                        <?php if ($func == 0): ?>
                        <input name="grade" type="hidden">
                    <?php else: ?>
                        <input name="grade" type="hidden" value="<?php echo $info['grade']?>">
                    <?php endif;?>
                        <div class="menu">
                            <div class="item" data-value="1">大一</div>
                            <div class="item" data-value="2">大二</div>
                            <div class="item" data-value="3">大三</div>
                            <div class="item" data-value="4">大四</div>
                        </div>
                    </div>
                </div>
                <div class="required field">
                    <label>班级</label>
                    <?php if ($func == 0): ?>
                    <input name="class"  type="text">
                    <?php else: ?>
                    <input name="class" value="<?php echo $info['class']?>" type="text">
                    <?php endif;?>
                </div>
			</div>
            <div class="ui grey right floated button" id="back">返回</div>
            <?php if ($func != 0): ?>
            <button class="ui red right floated  button" type="submit" name="delete" value="delete">删除</button>
            <?php endif;?>
            <button class="ui green  right floated  button" type="submit" name="submit" value="submit">提交</button>
            </div>
        </form>

        <?php if ($func == 0): ?>
        <form class="ui form segment transparent-seg" action="<?php echo (site_url('ims/ims_add_student/batchInsert'))?>" method="post">

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
                                prompt : '请输入学号'
                            },
                            {
                                type   : 'length[10]',
                                prompt : '学号需要是十位，请重新输入'
                            },
                            {
                                type   : 'maxLength[11]',
                                prompt : '学号需要是十位，请重新输入'
                            }
                        ]
                    },
                    名字: {
                        identifier: 'name',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : '请输入名字'
                            },
                            {
                                type   : 'not[徐雨虹]',
                                prompt : '您输入的涉嫌色情暴力，请重新输入'
                            }
                        ]
                    },
                    邮箱: {
                        identifier: 'email',
                        optional: true,
                        rules: [
                            {
                                type   : 'email',
                                prompt : '邮箱格式不正确，请重新输入'
                            }
                        ]
                    },
                    手机号: {
                        identifier: 'phone',
                        optional: true,
                        rules: [
                            {
                                type   : 'length[11]',
                                prompt : '手机号需要是十位，请重新输入'
                            },
                            {
                                type   : 'maxLength[11]',
                                prompt : '手机号需要是十位，请重新输入'
                            }
                        ]
                    },
                    学院: {
                        identifier: 'college',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : '请选择学院'
                            }
                        ]
                    },
                    学系: {
                        identifier: 'department',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : '请选择学系'
                            }
                        ]
                    },
                    年级: {
                        identifier: 'grade',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : '请选择年级'
                            }
                        ]
                    },
                    班级: {
                        identifier: 'class',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : '请选择班级'
                            },
                            {
                                type   : 'integer',
                                prompt : '班级需要是一个数字，请重新填写'
                            }
                        ]
                    }
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
