<?php

require_once 'user.php';
require_once '../functions.php';

$name = val($_GET['name']);
$type = val($_GET['type']);

echo addAccounts($userId, $type, $name);

?>