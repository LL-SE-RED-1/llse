
  <title><?php echo $title ?></title>
  <?php echo $library_src;?>
  <script type="text/javascript">
  window.onload=function()
	{
		$("#TYPE").val("<?php if (set_value('TYPE')!="") echo set_value('TYPE'); else echo $questions_item['TYPE']; ?>");
		if ("<?php if (set_value('TYPE')!="") echo set_value('TYPE'); else echo $questions_item['TYPE']; ?>"== 'JUDGE') {
			$("#CHOICES").hide();
			$("#A").hide();
			$("#B").hide();
			$("#C").hide();
			$("#D").hide();
			$("#T").show();
			$("#F").show();
		}
		else{
			$("#CHOICES").show();
			$("#A").show();
			$("#B").show();
			$("#C").show();
			$("#D").show();
			$("#T").hide();
			$("#F").hide();
		}

		$("#KEY").val("<?php if (set_value('KEY')!="") echo set_value('KEY'); else echo $questions_item['KEY']; ?>");

	/*$("#QUESTION").val("<?php echo $questions_item['QUESTION']; ?>");
	$("#SELECT_A").val("<?php echo $questions_item['SELECT_A']; ?>");
	$("#SELECT_B").val("<?php echo $questions_item['SELECT_B']; ?>");
	$("#SELECT_C").val("<?php echo $questions_item['SELECT_C']; ?>");
	$("#SELECT_D").val("<?php echo $questions_item['SELECT_D']; ?>");*/
	
	}

  </script>
  <script type="text/javascript">
  	function type_select()
	{
		if ($("#TYPE").val() == 'JUDGE') {
			$("#CHOICES").hide();
			$("#A").hide();
			$("#B").hide();
			$("#C").hide();
			$("#D").hide();
			$("#T").show();
			$("#F").show();
			$("#KEY").val("T");
			document.getElementById("SA").checked=false;
			document.getElementById("SB").checked=false;
			document.getElementById("SC").checked=false;
			document.getElementById("SD").checked=false;
		}
		else{
			$("#CHOICES").show();
			$("#A").show();
			$("#B").show();
			$("#C").show();
			$("#D").show();
			$("#T").hide();
			$("#F").hide();
			$("#KEY").val("A");
			document.getElementById("ST").checked=false;
			document.getElementById("SF").checked=false;
		}
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


