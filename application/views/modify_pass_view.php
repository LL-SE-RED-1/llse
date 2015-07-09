<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header"><strong>修改密码</strong></h1>


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

                <form class="ui form" style="width:30%" action="<?php echo site_url('modify_pass/modify')?>" method="post">
                    <div class="field">
                        <lable>原密码</lable>
                        <div class="ui icon input">
                            <input type="password" name="old_pass">
                            <i class="lock icon"></i>
                        </div>
                    </div>
                    <div class="field">
                        <lable>新密码</lable>
                        <div class="ui icon input">
                            <input type="password" name="new_pass">
                            <i class="lock icon"></i>
                        </div>
                    </div>
                    <div class="field">
                        <lable>确认新密码</lable>
                        <div class="ui icon input">
                            <input type="password" name="conform_pass">
                            <i class="lock icon"></i>
                        </div>
                    </div>

                    <div class="ui grey right floated  button" id="back">取消</div>
                    <button class="ui green  right floated  button" type="submit">确认</button>
                </form>
            </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>js/form_feedack.js"></script>

<script type="text/javascript">

    $('.ui.form')
            .form({
                原始密码: {
                    identifier: 'old_pass',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请输入原始密码'
                        }
                    ]
                },
                新密码: {
                    identifier: 'new_pass',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请输入新密码'
                        }
                    ]
                },
                确认新密码: {
                    identifier: 'conform_pass',
                    rules: [
                        {
                            type   : 'empty',
                            prompt : '请确认新密码'
                        },
                        {
                            type   : 'match[new_pass]',
                            prompt : '输入新密码与之前不一致，请重新输入'
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

<?php if($result_num != 0): ?>
    <script>
            $(document)
                    .ready(function() {
                        <?php if($result_num == 1):?>
                        show_positive_message();
                        <?php else:?>
                        show_negative_message();
                        <?php endif;?>
 
                    });
    </script>
<?php endif; ?>

<style>

    .ui.transparent-seg {
        background-color: rgba(255, 255, 255, 0);
        box-shadow: 0px 0px 0px 0px;
        padding: 0em 0em;
    }
</style>

</body>
</html>
