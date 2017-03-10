<?php header('Access-Control-Allow-Origin: *');

require_once 'dbc.php';
require_once 'val.php';

$name = val($_POST['name']);
$type = val($_POST['type']);
$userId = val($_POST['userId']);

$sql = "INSERT INTO dnb_accounts (name, type, owner) VALUES ('$name',$type, $userId)";

$response = @mysqli_query($dbc, $sql);

if($response){
    $sql = "SELECT id, name FROM ".dbname.".dnb_accounts WHERE owner = $userId ORDER BY id DESC LIMIT 1";
    $response = @mysqli_query($dbc, $sql);
    $row = @mysqli_fetch_assoc($response);
    $accountId = $row['id'];
    $accountName = $row['name'];
    echo $accountId;
}

mysqli_close($dbc);

?>