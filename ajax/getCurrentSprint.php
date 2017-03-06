<?php

require_once 'dbc.php';
require_once 'val.php';

$userId = val($_POST['userId']);

$sql = "SELECT s.id AS id, s.goal, s.value, DATE_FORMAT(s.start,'%Y-%m-%d') AS start, g.name, g.value, g.date AS end, g.category, SUM(DISTINCT t.value) AS spending FROM dnb_sprints AS s LEFT JOIN dnb_goals AS g ON s.goal = g.id LEFT JOIN dnb_accounts AS a ON a.owner = s.user LEFT JOIN dnb_transactions AS t ON t.account = a.id WHERE t.accounting_date > s.start AND a.type = 1 AND s.user = $userId ORDER BY s.id DESC;";

$response = @mysqli_query($dbc, $sql);

if(mysqli_num_rows($response)>0){
    $row = mysqli_fetch_assoc($response);
    echo json_encode($row);
} else {
    echo "Epic fail!"."\n\r".$sql;
}

mysqli_close($dbc);

?>