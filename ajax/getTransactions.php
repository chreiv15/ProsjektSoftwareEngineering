<?php header('Access-Control-Allow-Origin: *');

require_once 'dbc.php';
require_once 'val.php';

$account = val($_POST['account']);

$sql = "SELECT * FROM dnb_transactions WHERE account = $account ORDER BY id DESC";

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