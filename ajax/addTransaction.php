<?php header('Access-Control-Allow-Origin: *');

require_once '../functions.php';

$description = val($_GET['description']);
$value = val($_GET['value']);
$category = val($_GET['category']);
$account = val($_GET['account']);

echo addTransaction($description, $value, $category, $account);

?>