<?php header('Access-Control-Allow-Origin: *');

require_once 'dbc.php';
require_once 'val.php';

$id = val($_POST['id']);

$sql = "SELECT id FROM dnb_sprints WHERE user = $id AND end > CURDATE();";

$response = @mysqli_query($dbc, $sql);
if($response){
    $row = mysqli_fetch_row($response);
	$num = $row[0];
	if($num!=NULL){
		echo $num;
	}else{
		echo 'false';
	}
}else{
    echo $sql;
}

mysqli_close($dbc);

?>