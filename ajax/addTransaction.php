<?php header('Access-Control-Allow-Origin: *');

require_once '../functions.php';

$description = val($_POST['description']);
$value = val($_POST['value']);
$category = val($_POST['category']);
$account = val($_POST['account']);

echo addTransaction($description, $value, $category, $account);

?>