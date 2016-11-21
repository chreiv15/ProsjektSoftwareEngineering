<script>

function getPoints() {
	var val = document.getElementById("input").value;
    console.log(val);
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("box").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","getPoints.php?value="+val,true);
	xmlhttp.send();
}
    
</script>

<form method="get">
    <input type="number" id="input" max="4000" step="10" name="value" onchange="getPoints()">
    <input type="submit">
</form>
<div id="box"></div>