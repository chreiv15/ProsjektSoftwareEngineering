<?php

require_once 'user.php';
require_once '../functions.php';

//http://westerdals.fredrikhagen.no/ajax/addTransaction.php?description=Pizza&value=79.9&category=1&account=97348898359

$description = val($_GET['description']);
$value = val($_GET['value']);
$category = val($_GET['category']);
$type = val($_GET['type']);
$account = val($_GET['account']);

echo addTransaction($description, $value, $category, $account);

?>