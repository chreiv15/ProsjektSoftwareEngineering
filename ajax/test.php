<?php header('Access-Control-Allow-Origin: *');

$end = date('Y-m-d', strtotime('+1 months'));
echo $end;