<?php

if($_COOKIE['login']) {
    $userData = explode("|", $_COOKIE['login']);
}

$userId = $userData[0];
$userFirstName = $userData[1];
$userLastName = $userData[2];
$userEmail = $userData[3];
$userPhone = $userData[4];

?>