  <?php echo $library_src;?>
  <script type="text/javascript">
  	function deleteQuestion(id)
	{
		$("#"+id).attr("action", "/index.php/questions/delete");
		$("#"+id).submit();
	}

	function editQuestion($id)
	{
		$("#"+$id).attr("action", "/index.php/questions/edit_show");
		$("#"+$id).submit();
	}
  </script>
  <script type="text/javascript">
	function validate_form(type,key)
	{
		if ( type == 'ID' && parseInt(key) != key){
			alert("序号必须为正整数。");
			return false;
		}else if ( type == 'CONTENT' && key == '') {
			alert("请输入搜索关键字");
			return false;
		}else{
			return true;
		}

	}
  </script>
  
    <script type="text/javascript">
  	function deleteQuestion(id)
	{
		$("#"+id).attr("action", "/index.php/r6_C/questions/delete");
		$("#"+id).submit();
	}

	function editQuestion($id)
	{
		$("#"+$id).attr("action", "/index.php/r6_C/questions/edit_show");
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
