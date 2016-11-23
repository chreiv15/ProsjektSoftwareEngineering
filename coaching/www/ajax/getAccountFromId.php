<?php

require_once '../../../functions.php';
$userId = val($_GET['user']);
echo getSpeningAccount($userId);

?>