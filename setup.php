<html>
<title>kaloviy counter</title>
<head>
<style>
@font-face {
	font-family: 'Roboto';
	src: url('fnt/Roboto.woff2') format('woff2');
	font-weight: normal;
	font-style: normal;
}
html, form, input, .btn {
	 text-align: center;
	 font-family: Roboto;
	 font-size: 19px;
}
form select, form input {
	margin-top: 8px;
	margin-bottom: 10px;
}
#thicc, #line {
	width: auto;
}
</style>
<link rel="stylesheet" href="css/bootstrap.min.css">
<script type="text/javascript">
window.onload = function() {
	thicc.value = 3
	line.value = 6
	fontsize.value = 79
	align.checked = true
	stream.value = ""
	font.value = "0"
	color.value = "#ffffff"
	tcolor.value = "#000000"
	bgcolor.value = "#00FF00"
}
</script>
<script src="js/jquery-3.4.0.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>
<body>
<form action="" method="get">
	<h6>stream id:</h6>
    <input type="text" name="id" id="stream" minlength="11" maxlength="11" placeholder="e.g hHW1oY26kxQ" required="required">
	<h6>font:</h6>
    <select name="font" id="font">
		<option value="0">Roboto</option>
		<option value="1">Noto Serif</option>
		<option value="2">Ubuntu Mono</option>
		<option value="3">VT323</option>
		<option value="4">SH Pinscher</option>
		<option value="5">Gill Sans MT</option>
	</select>
	<h6>size:</h6>
	<input type="number" name="fontsize" id="fontsize" value="79" min="1" max="480">
	<h6>thicc:</h6>
	<input type="range" class="custom-range" name="thicc" id="thicc" value="3" min="0" max="6" oninput="thicc_value.value=this.value">
	<output id="thicc_value">3</output><h6>smooth:</h6>
	<input type="range" class="custom-range" name="line" id="line" value="6" min="0" max="6" oninput="line_value.value=this.value">
	<output id="line_value">6</output>
	<h6>align text (disable for obs):</h6>
	<input type="checkbox" checked="true" name="align" id="align" value="center">
	<h6>color:</h6>
    <input type="color" name="color" id="color" value="#ffffff">
	<h6>thickness color:</h6>
    <input type="color" name="tcolor" id="tcolor" value="#000000">
	<h6>bgcolor:</h6>
    <input type="color" name="bgcolor" id="bgcolor" value="#00FF00">
	<p><input type="submit" class="btn btn-primary" value="OK"></p>
</form>
</body>
</html>