<?php

require_once '../functions.php';

$firstname = val($_GET['firstname']);
$lastname = val($_GET['lastname']);
$email = val($_GET['email']);
$phone = val($_GET['phone']);
$password = val($_GET['password']);
$password = md5($password);

echo addUser($firstname, $lastname, $email, $phone, $password);

?>