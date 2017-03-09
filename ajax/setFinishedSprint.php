<?php

require_once 'dbc.php';
require_once 'val.php';

$sprintId = val($_POST['sprintId']);
$saved = val($_POST['saved']);

$sql = "UPDATE dnb_sprints SET result = '$saved' WHERE id = $sprintId";

$response = @mysqli_query($dbc, $sql);

if($response){
    echo 'OK';
} else {
    echo "Epic fail!"."\n\r".$sql;
}

mysqli_close($dbc);

?>