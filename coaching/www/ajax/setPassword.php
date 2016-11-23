<?php

include 'user.php';
require_once '../functions.php';

$userId = val($_GET['userId']);
$password = val($_GET['password']);

echo setPassword($userId, $password);

?>