<link href="<?php echo base_url();?>css/signin.css" rel="stylesheet">
<link href="<?php echo base_url();?>css/cover.css" rel="stylesheet">

<body>

    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand">教务管理系统</h3>
                        <nav>
                            <ul class="nav masthead-nav">
                                <li class="active"><a href="#">主页</a></li>
								<li><a href='<?php echo site_url('reset_pswd')?>'>重置密码</a></li>
								<li><a href="mailto:zjullse@163.com">联系我们</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="inner cover">
                    <div class="ui positive message" style="display: none;">
                        <i class="close icon"></i>
                        <div class="header">
                            Wow congratulations!
                        </div>
                        <p><?php echo $result_info; ?></p>
                    </div>

                    <div class="ui negative message" style="display: none;">
                        <i class="close icon"></i>
                        <div class="header">
                            Oops!
                        </div>
                        <p><?php echo $result_info;?></p>
                    </div>

                    <form action="<?php echo site_url('login/verify');?>" method="post">
                        <h1 class="form-signin form-signin-heading"><strong>登录</strong></h1>

                        <label for="uid" class="form-signin sr-only">User ID</label>
                        <input type="text" id="uid" name="uid" class="form-signin form-control" placeholder="学号/教工号" required autofocus>
                        <label for="password" class="form-signin sr-only">Password</label>
                        <input type="password" id="password" name="password" class="form-signin form-control" placeholder="密码" required>

                        <label for="userType" class="sr-only"></label>
                        <select id="userType" name="userType" class="form-signin form-control" style="padding: 0 15px">
                            <option value="1">学生</option>
                            <option value="2">教师</option>
                            <option value="3">管理员</option>
                            <option value="4">系统管理员</option>
                            <option value="5">院系管理员</option>
                            <option value="6">助管</option>
                        </select>

                        <!-- 临时使用 -->
                        <!-- a href="<?php echo site_url('login/reset_pswd');?>">忘记密码</a -->

                        <div class="form-signin checkbox">
                            <!-- <label>
                                <input type="checkbox" value="remember-me"> 记住密码
                            </label> -->
                        </div>
                        <button class="form-signin btn btn-lg btn-primary btn-block" type="submit">登录</button>
                    </form>
                </div>


                <div class=" mastfoot">
                    <div class=" inner">
                        <p>教务管理系统 <Strong>登录页面</Strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="<?php echo base_url();?>js/form_feedack.js"></script>

<!-- <script type="text/javascript">

    $('.ui.form')
            .form({
                uid: {
                    identifier: 'uid',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请输入学号/教工号'
                        },
                        {
                            type   : 'maxLength[10]',
                            prompt : '学号/教工号长度为10位'
                        },
                        {
                            type   : 'length[10]',
                            prompt : '学号/教工号长度为10位'
                        }

                    ]
                },
                password: {
                    identifier: 'new_pass',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请输入密码'
                        },
                        {
                            type   : 'maxLength[30]',
                            prompt : '密码长度超限'
                        },
                        {
                            type   : 'length[6]',
                            prompt : '密码长度不足'
                        }
                    ]
                }
            },
            {
                inline : true,
                on     : 'blur'
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
                $('.demo .ui.checkbox')
                        .checkbox()
                ;
            })
    ;


    $("#back").click(function() {
        history.go(-1);
    });

</script>
-->

<?php if ($result_num == 2 || $result_num == 3): ?>
    <script>
            $(document)
                    .ready(function() {
                        show_negative_message();
                    });
    </script>
<?php endif;?>

</body>

</html>
