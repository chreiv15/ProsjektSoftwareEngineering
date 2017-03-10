<?php header('Access-Control-Allow-Origin: *');

// BRUKES IKKE LENGER

require_once 'user.php';
require_once '../functions.php';

$name = val($_GET['name']);
$value = val($_GET['value']);
$date = val($_GET['date']);
$category = val($_GET['category']);

echo addGoal($name, $value, $date, $category, $userId);

?>