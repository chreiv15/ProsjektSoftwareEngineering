<?php

require_once '../../../functions.php';

$email = val($_GET['user']);
$password = val($_GET['password']);

getUser($email, $password);

?>