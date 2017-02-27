<?php

require_once 'dbc.php';
require_once 'val.php';

$firstname = val($_POST['fname']);
$lastname = val($_POST['lname']);
$email = val($_POST['email']);

$sql = "INSERT INTO dnb_users (firstname, lastname, email) VALUES('$firstname', '$lastname', '$email');";
$sql .= "SELECT LAST_INSERT_ID();";

if(mysqli_multi_query($dbc,$sql)){
    do{
        if($result=mysqli_store_result($dbc)){
            $row = mysqli_fetch_row($result);
            $id = $row[0];
            echo "$id";
        }
    }
    while(mysqli_next_result($dbc));
}else{
    echo mysqli_error($dbc);
    echo "\n\r";
    echo $sql;
}

mysqli_close($dbc);

?>