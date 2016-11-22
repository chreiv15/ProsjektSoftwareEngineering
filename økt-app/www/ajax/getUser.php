<?php

require_once '../functions.php';

$email = val($_GET['user']);
$password = val($_GET['password']);

echo getUser($email, $password);

?>

<a href="../index.php">Fortsett</a>