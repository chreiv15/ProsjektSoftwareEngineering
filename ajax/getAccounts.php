<?php header('Access-Control-Allow-Origin: *');

require_once 'user.php';
require_once '../functions.php';

echo getAccounts($userId);

?>