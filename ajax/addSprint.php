<?php header('Access-Control-Allow-Origin: *');

    require_once 'dbc.php';
    require_once 'val.php';

    $userId = val($_POST['userId']);
    $sprintGoal = val($_POST['sprintGoal']);
    $beforeSpending = val($_POST['beforeSpending']);
    $goalName = val($_POST['goalName']);
    $goalValue = val($_POST['goalValue']);
    $goalCategory = val($_POST['goalCategory']);
    $goalTargetDate = val($_POST['goalTargetDate']);

    $sql = "INSERT INTO dnb_goals (name, value, date, category, owner) VALUES('$goalName', $goalValue, '$goalTargetDate', $goalCategory, $userId); ";
    //echo $sql."\n\r";
    $sql .= "UPDATE dnb_users SET `before` = '$beforeSpending' WHERE id = $userId; ";
    //echo $sql."\n\r";
    $sql .= "SELECT LAST_INSERT_ID(); ";

    if(mysqli_multi_query($dbc,$sql)){
        do{
            if($result=mysqli_store_result($dbc)){
                $row = mysqli_fetch_row($result);
                if(!empty($row[0])){
                    $goalId = $row[0];
                    echo "$goalId";
                    $start = date('Y-m-d');
                    $end = date('Y-m-d', strtotime('+1 months'));
                    $query = "INSERT INTO dnb_sprints (value, goal, user, start, end) VALUES($sprintGoal, $goalId, $userId, '$start', '$end');";
                    $response = @mysqli_query($dbc, $query);
                    break;
                }
            }else{
				echo $sql;
			}
        }
        while(mysqli_next_result($dbc));
    }

    mysqli_close($dbc);

?>