<?php

    $config = parse_ini_file('../../../dbc.ini'); 

    $dbc = mysqli_connect($config['server'],$config['username'],$config['password'],$config['dbname']) OR die('Could not connect to MySQL: ' . mysqli_connect_error());
    $dbc->set_charset("utf8");

?>
