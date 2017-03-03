<?php

require_once 'dbc.php';
require_once 'val.php';

$email = val($_POST['user']);
$pin = val($_POST['pin']);

$sql = "SELECT * FROM userLogin WHERE email = '$email' AND pin = $pin ORDER BY sprintId DESC LIMIT 1";

$response = @mysqli_query($dbc, $sql);

if(mysqli_num_rows($response)>0){
    $row = mysqli_fetch_assoc($response);
    $id = $row['id'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $email = $row['email'];
    $accountId = $row['accountId'];
    $accountValue = $row['accountValue'];
    $beforeSpending = $row['beforeSpending'];
    $goalValue = $row['goalValue'];
    $goalId = $row['goalId'];
    $sprintId = $row['sprintId'];
    $sprintStart = $row['sprintStart'];
    
    $json = array();
    $json['id'] = $id;
    $json['firstname'] = $firstname;
    $json['lastname'] = $lastname;
    $json['email'] = $email;
    $json['accountId'] = $accountId;
    $json['accountValue'] = $accountValue;
    $json['beforeSpending'] = $beforeSpending;
    $json['goalId'] = $goalId;
    $json['goalValue'] = $goalValue;
    $json['sprintStart'] = substr($sprintStart,0,10);
    $json['sprintId'] = $sprintId;
    $json = json_encode($json);
    setcookie("login", $json, time()+3600, "/");
    echo "OK";
} else {
    echo "Epic fail!$sql";
}

mysqli_close($dbc);

?>