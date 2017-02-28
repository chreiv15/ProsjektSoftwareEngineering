<?php

require_once 'dbc.php';
require_once 'val.php';

$userId = val($_POST['userId']);

$sql = "SELECT * FROM dnb_history WHERE user = $userId";

$response = @mysqli_query($dbc, $sql);
if($response){
    $data = array();
    while($row = mysqli_fetch_assoc($response)) {
        array_push($data,$row);
    }
    $json = json_encode($data);
    echo $json;
}else{
    echo $sql;
}

mysqli_close($dbc);

?>