<div class="m-message">
	<a class="btn btn-warning" type="button" href="<?=site_url("student/alertundonelist");?>">
	  未完成 <span class="badge u-undone"></span>
	</a>
	<a class="btn btn-primary" type="button" href="<?=site_url("student/alertunknownlist");?>">
  	新布置 <span class="badge u-unknown"></span>
	</a>
	<script>
	$.get(
		"<?=site_url("resource/student/gethomeworkstatus/");?>",
		null, 
		function(data){
			data = JSON.parse(data);
			console.log(data);
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
