<?php header('Access-Control-Allow-Origin: *');

require_once 'dbc.php';
require_once 'val.php';

$userId = val($_POST['userId']);

$sql = "SELECT g.id, value, c.name AS category FROM dnb_goals AS g JOIN dnb_categories AS c ON g.category = c.id WHERE owner = $userId ORDER BY id DESC;";

$response = @mysqli_query($dbc, $sql);

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