        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">权限管理</h1>

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


            <form class="ui form segment transparent-seg" action="<?php echo site_url('ims/ims_permission/create');?>" method="post">
                <div class="table-responsive" style="text-align:center">
                    <table class="table table-striped" style="display: inline-table;">
                        <thead>
                        <tr>
                            <th style="width: 20%;">权限</th>
                            <th style="width: 20%;">学生</th>
                            <th style="width: 20%;">教师</th>
                            <th style="width: 40%;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="ui input" style="width:100%">
                                    <input type="text" name="per_name">
                                </div>
                            </td>
                            <td>
                                <div class="ui checkbox">
                                    <input type="checkbox" name="stu_per">
                                    <label></label>
                                </div>
                            </td>
                            <td>
                                <div class="ui checkbox">
                                    <input type="checkbox" name="tea_per">
                                    <label></label>
                                </div>
                            </td>
                            <td>
                                <button class="ui blue button" id="create" type="submit">创建权限</button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </form>

            <div class="table-responsive" style="text-align:center">
                <table class="table table-striped" style="display: inline-table;">
                    <thead>
                    <tr>
                        <th style="width: 20%;">权限</th>
                        <th style="width: 20%;">学生</th>
                        <th style="width: 20%;">教师</th>
                        <th style="width: 40%;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ( $permission as $pitem ):?>
                        <form class="ui form segment transparent-seg" action="<?php echo site_url('ims/ims_permission/modify').'/'.$pitem['pid'];?>" method="post">
                            <tr>
                                <td>
                                    <?=$pitem['description']?>
                                </td>
                                <td>
                                    <div class="ui checkbox">
                                        <input type="checkbox" name="stu_per" 
                                        <?php if($pitem['stuPermi']==TRUE):?>
                                            checked="on"
                                        <?php endif;?>
                                        >
                                        <label></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="ui checkbox">
                                        <input type="checkbox" name="tea_per"
                                        <?php if($pitem['teaPermi']==TRUE):?>
                                            checked="on"
                                        <?php endif;?>
                                        >
                                        <label></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="ui buttons">
                                        <button name="update" value="update" class="ui green button modify" >更新</button>
                                        <div class="or"></div>
                                        <button name="delete" value="delete" class="ui red button delete">删除</button>
                                    </div>
                                </td>
                            </tr>
                        </form>
                    <?php endforeach;?>

                    </tbody>
                </table>
            </div>
            <!-- </form> -->

        </div>
      </div>
    </div>

    <style>


        .text-center0 {
            display: inline-block;
            vertical-align: middle;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .ui.transparent-seg.mg {
            background-color: rgba(255, 255, 255, 0);
            box-shadow: 0px 0px 0px 0px;
            padding: 0em 0em;
            width: 50%;
            margin: 0 auto;
        }

        th {
            text-align:center;
        }

        .table>tbody>tr>td {
            vertical-align: middle;
        }

        .field.right {
            float: right;
            margin-right: 105px;
        }

        .ui.transparent-seg {
            background-color: rgba(255, 255, 255, 0);
            box-shadow: 0px 0px 0px 0px;
            padding: 0em 0em;
        }

        .ui.form .ui.input {
            width: 50%;
        }

    </style>

  </body>
</html>

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
                        <?php if($result_num == 1 || $result_num == 3 || $result_num == 5):?>
                        show_positive_message();
                        <?php else:?>
                        show_negative_message();
                        <?php endif;?>
 
                    });
    </script>
<?php endif; ?>

<script>
    $('.ui.checkbox')
            .checkbox()
    ;
</script>

