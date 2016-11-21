<?php

require_once '../functions.php';
$account = val($_GET['account']);
echo getTransactions($account);

?>