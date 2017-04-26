<?php header('Access-Control-Allow-Origin: *');
      
        require_once 'dbc.php';
        require_once 'val.php';

        $firstname = val($_POST['fname']);
        $lastname = val($_POST['lname']);
        $email = val($_POST['email']);
        $spending = val($_POST['spending']);
        
        $sql = "INSERT INTO dnb_users (firstname, lastname, email, `before`) VALUES('$firstname', '$lastname', '$email', '$spending');";
        $sql .= "SELECT LAST_INSERT_ID();";
        //echo $sql;

        if(mysqli_multi_query($dbc,$sql)){
            do{
                if($result=mysqli_store_result($dbc)){
                    $row = mysqli_fetch_row($result);
                    $id = $row[0];
                    echo "$id";
                    
                    break;
                }
            }
            while(mysqli_next_result($dbc));
        } else{
            echo mysqli_error($dbc);
            echo "\n\r";
            echo $sql;
        }

        mysqli_close($dbc);

?>