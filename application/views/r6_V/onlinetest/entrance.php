<html>
<head>

<script>

var tim = 5;
var msg;



</script>

</head>
<body>

<input type = 'text' id='timr' />

<script>

alert('Here you come!');

timer = self.setInterval(cold, 1000);
function cold(){
	if (tim>0){
		msg = "" . tim . "sec left";
		document.getElementById('timr').value = msg;
	} else {
		clearInterval(timer);
		document.aa.submit();
	}
	tim--;
	
}

</script>
<form name='aa' action='/index.php/welcome/welcome' method = 'post'>
Type:<select name='type' value=''>
<option value = 'Teacher'>Teacher</option>
<option value = 'Student'>Student</option> 
</select><br>
ID:<input name='id' type='text'><br>
<input type='submit'>
</form>

</body>
</html>
