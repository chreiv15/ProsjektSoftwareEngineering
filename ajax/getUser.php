<?php

require_once 'dbc.php';
require_once 'val.php';

$email = val($_POST['user']);
pin = val($_POST['pin']);

$sql = "SELECT * FROM dnb_users WHERE email = '$email' AND pin = $pin LIMIT 1";

$response = @mysqli_query($dbc, $sql);

if(mysqli_num_rows($response)>0){
    $row = mysqli_fetch_assoc($response);
    $id = $row['id'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $email = $row['email'];
    $content = "$id|$firstname|$lastname|$email";
    setcookie("login", $content, time()+3600, "/");
    echo "OK";
} else {
    echo "Epic fail!";
}

mysqli_close($dbc);

?>