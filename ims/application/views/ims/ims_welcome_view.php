        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header"><strong>Hello!</strong></h1>

            <div class="row">

                <div class="col-xs-6 col-sm-2 placeholder">
                    <?php if($type == 1):?>
                        <img src="<?php echo base_url();?>images/student.png" class="ui small circular image" style="margin:0 auto;">
                    <?php elseif($type == 2):?>
                        <img src="<?php echo base_url();?>images/teacher.png" class="ui small circular image" style="margin:0 auto;">
                    <?php else:?>
                        <img src="<?php echo base_url();?>images/manager.png" class="ui small circular image" style="margin:0 auto;"> 
                    <?php endif;?>
                </div>

                <div class="col-xs-6 col-sm-10 placeholder">

                    <div style="margin-top: 40px;">
                        <h3>现在是 <span style="font-weight: 300" id="now_time"></span> ,</h3>
                    <h2>欢迎来到信息管理子系统。</h2>
                    </div>
                </div>

        </div>

    </div>
</div>

<style>

    .ui.transparent-seg {
        background-color: rgba(255, 255, 255, 0);
        box-shadow: 0px 0px 0px 0px;
        padding: 0em 0em;
    }
</style>

<!-- <script src="./js/form_feedack.js"></script> -->

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
                $('.demo .ui.checkbox')
                        .checkbox()
                ;
                $('#now_time').text(new Date($.now()));
            })
    ;


    $("#back").click(function() {
        history.go(-1);
    });

</script>


</body>
</html>
