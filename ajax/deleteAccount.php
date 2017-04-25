<?php header('Access-Control-Allow-Origin: *');

require_once 'dbc.php';
require_once 'val.php';

$id = val($_POST['id']);

$sql = "DELETE FROM dnb_accounts WHERE id = $id;";

$response = @mysqli_query($dbc, $sql);
if($response){
	echo "OK";
}else{
    echo $sql;
}

mysqli_close($dbc);

?>