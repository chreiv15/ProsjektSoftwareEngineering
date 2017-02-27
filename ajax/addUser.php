<?php

require_once 'dbc.php';
require_once 'val.php';

$firstname = val($_POST['firstname']);
$lastname = val($_POST['lastname']);
$email = val($_POST['email']);

$sql = "INSERT INTO dnb_users (firstname, lastname, email) VALUES('$firstname', '$lastname', '$email')";

$response = @mysqli_query($dbc, $sql);

if($response){
    echo "OK";
}

mysqli_close($dbc);

?>