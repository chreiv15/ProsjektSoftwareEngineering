<?php

header('Content-Type: text/html; charset=utf-8');
require_once 'functions.php';

$userId = $_GET['u'];
$code = $_GET['c'];

if(checkResetCode($userId, $code)) {
    echo '<p>Ditt nye passord</p>';
    echo '<input name="p" id="p" type="password">';
    echo '<input name="u" id="u" type="hidden" value="'.$userId.'">';
    echo '<input type="submit" onclick="setNewPassword()">';
} else {
    echo '<p>Feil kode.</p>';
    echo "<p>$userId</p>";
    echo "<p>$code</p>";
}

?>
<div id="result"></div>
<script>
    function setNewPassword() {
	var p = document.getElementById("p").value;
	var u = document.getElementById("u").value;
	document.getElementById("p").value = "";
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("result").innerHTML=xmlhttp.responseText;
		}
	}
    var url = "ajax/setPassword.php?password="+p+"&userId="+u;
    console.log(url);
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
}
</script>