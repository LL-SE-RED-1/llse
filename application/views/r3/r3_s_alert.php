<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
	if($content!='nothing'){
		echo '<body onload="javascript:alert(\''.$content.'\');location=\''.site_url('r3/r3_student/selectpage/'.$sid.'/'.$cid).'\'"></body>';
	}
	else{
		echo '<body onload="location=\''.site_url('r3/r3_student/selectpage/'.$sid.'/'.$cid).'\'"></body>';
	}
?>