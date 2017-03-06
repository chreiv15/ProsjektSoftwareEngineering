<?php

require_once 'dbc.php';
require_once 'val.php';

$userId = val($_POST['userId']);

$sql = "SELECT s.goal AS goalId, g.name as goalName, g.value AS goalValue, s.value AS sprintTarget, s.start AS sprintStart, s.end AS sprintEnd, g.date AS goalEnd, g.category AS goalCategory, c.icon AS goalIcon, SUM(DISTINCT t.value) AS sprintSpending FROM dnb_sprints AS s LEFT JOIN dnb_goals AS g ON s.goal = g.id LEFT JOIN dnb_accounts AS a ON a.owner = s.user LEFT JOIN dnb_transactions AS t ON t.account = a.id LEFT JOIN dnb_categories AS c ON c.id = g.category WHERE t.accounting_date > s.start AND a.type = 1 AND s.user = $userId ORDER BY s.id DESC;";

$response = @mysqli_query($dbc, $sql);

if($response){
    $row = mysqli_fetch_assoc($response);
    echo json_encode($row);
} else {
    echo "Epic fail!"."\n\r".$sql;
}

mysqli_close($dbc);

?>