  <title><?php echo $title ?></title>
  <?php echo $library_src;?>
  <script type="text/javascript">
  	function deleteQuestion(id)
	{
		$("#"+id).attr("action", "<?php echo site_url('r6_C/questions/delete');?>");
		$("#"+id).submit();
	}

	function editQuestion($id)
	{
		$("#"+$id).attr("action", "<?php echo site_url('r6_C/questions/edit_show');?>");
		$("#"+$id).submit();
	}
  </script>
  <style id="style-1-cropbar-clipper">/* Copyright 2014 Evernote Corporation. All rights reserved. */
.en-markup-crop-options {
    top: 18px !important;
    left: 50% !important;
    margin-left: -100px !important;
    width: 200px !important;
    border: 2px rgba(255,255,255,.38) solid !important;
    border-radius: 4px !important;
}

.en-markup-crop-options div div:first-of-type {
    margin-left: 0px !important;
}
</style>

</head>
<body>

  
