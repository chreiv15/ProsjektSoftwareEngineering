<?php

require_once '../functions.php';

$userId = val($_GET['user']);
$code = val($_GET['code']);

if(checkResetCode($userId, $code) == true) {
    echo '<p>Godkjent</p>';
    echo '<input type="password" placeholder="Nytt passord">';
}

?>