<?php

require_once 'dbc.php';
require_once 'val.php';

$email = val($_POST['user']);
$pin = val($_POST['pin']);

$sql = "SELECT * FROM dnb_users WHERE email = '$email' AND pin = $pin LIMIT 1";

$response = @mysqli_query($dbc, $sql);

if(mysqli_num_rows($response)>0){
    $row = mysqli_fetch_assoc($response);
    $id = $row['id'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $email = $row['email'];
    $json = array();
    $json['id'] = $id;
    $json['firstname'] = $firstname;
    $json['lastname'] = $lastname;
    $json['email'] = $email;
    $json = json_encode($json);
    setcookie("login", $json, time()+3600, "/");
    echo "OK";
} else {
    echo "Epic fail!$sql";
}

mysqli_close($dbc);

?>