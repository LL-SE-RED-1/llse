<div class="m-message">
    <style>
    .m-message{
        margin-top:5px;
    }
    </style>
	<a class="btn btn-warning" type="button" href="<?=site_url("resource/student/alertundonelist");?>">
	  未完成 <span class="badge u-undone"></span>
	</a>
	<a class="btn btn-primary" type="button" href="<?=site_url("resource/student/alertunknownlist");?>">
  	新布置 <span class="badge u-unknown"></span>
	</a>
	<script>
	$.get(
		"<?=site_url("resource/student/gethomeworkstatus/");?>",
		null, 
		function(data){
            try{
			    data = JSON.parse(data);
            }
            catch (e){
				$(".m-message .u-undone").parent().remove();
				$(".m-message .u-unknown").parent().remove();
                return;
            }
			$(".m-message .u-undone").text(data["undone"]);
			if (data["undone"] === 0)
				$(".m-message .u-undone").parent().remove();
			$(".m-message .u-unknown").text(data["unknown"]);
			if (data["undone"] === 0)
				$(".m-message .u-unknown").parent().remove();
		}
	);
	</script>
</div>
