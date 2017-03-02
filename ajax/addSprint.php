<?php

    require_once 'dbc.php';
    require_once 'val.php';

    $userId = val($_POST['userId']);
    $sprintGoal = val($_POST['sprintGoal']);
    $beforeSpending = val($_POST['sprintGoal']);
    $goalName = val($_POST['goalName']);
    $goalValue = val($_POST['goalValue']);
    $goalCategory = val($_POST['goalCategory']);
    $goalTargetDate = val($_POST['goalTargetDate']);

    $sql = "INSERT INTO dnb_goals (name, value, date, category, owner) VALUES('$goalName', $goalValue, '$goalTargetDate', $goalCategory, $userId);";
    $sql .= "UPDATE dnb_users SET before = '$beforeSpending' WHERE id = $userId";
    $sql .= "SELECT LAST_INSERT_ID();";

    if(mysqli_multi_query($dbc,$sql)){
        do{
            if($result=mysqli_store_result($dbc)){
                $row = mysqli_fetch_row($result);
                if(!empty($row[0])){
                    $goalId = $row[0];
                    $sql = "INSERT INTO dnb_sprints (value, goal) VALUES($sprintGoal, $goalId);";
                    $response = @mysqli_query($dbc, $sql);
                    if($response){
                        echo "OK $goalId";
                    }
                }
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