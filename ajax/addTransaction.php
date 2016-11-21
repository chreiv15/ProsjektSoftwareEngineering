<?php

//require_once 'user.php';
require_once '../functions.php';

$description = val($_GET['description']);
$value = val($_GET['value']);
$category = val($_GET['category']);
//$type = val($_GET['type']);
$account = val($_GET['account']);

echo addTransaction($description, $value, $category, $account);

?>