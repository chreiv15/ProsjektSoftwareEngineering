<?php header('Access-Control-Allow-Origin: *');

require_once 'dbc.php';
require_once 'val.php';

$id = val($_POST['id']);
$pin = val($_POST['pin']);

$sql = "UPDATE dnb_users SET pin = $pin WHERE id = $id";

$response = @mysqli_query($dbc, $sql);

if($response){
    echo "OK";
}else{
    echo mysqli_error($dbc);
    echo "\n\r";
    echo $sql;
}

mysqli_close($dbc);

?>