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
<?php echo $library_src;?>
  <script type="text/javascript">
  window.onload=function()
	{
/*		$("#CHOICES").show();
		$("#A").show();
		$("#B").show();
		$("#C").show();
		$("#D").show();
		$("#T").hide();
		$("#F").hide();*/
		if ($("#TYPE").val() == 'JUDGE') {
			$("#CHOICES").hide();
			$("#MULTICHOICE").hide();
			$("#A").hide();
			$("#B").hide();
			$("#C").hide();
			$("#D").hide();
			$("#T").show();
			$("#F").show();
		}else{
			$("#T").hide();
			$("#F").hide();
		}
	}

  </script>
  <script type="text/javascript">
  	function type_select()
	{
		if ($("#TYPE").val() == 'JUDGE') {
			$("#CHOICES").hide();
			$("#MULTICHOICE").hide();
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
			$("#MULTICHOICE").show();
			$("#A").show();
			$("#B").show();
			$("#C").show();
			$("#D").show();
			$("#T").hide();
			$("#F").hide();
			document.getElementById("ST").checked=false;
			document.getElementById("SF").checked=false;
			$("#KEY").val("A");
		}
	}
  </script>
</head>
<body>

  
  
