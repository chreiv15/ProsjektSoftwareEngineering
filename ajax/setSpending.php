<?php

require_once 'user.php';
require_once '../functions.php';

$value = val($_GET['value']);

echo setSpending($userId, $value);

?>