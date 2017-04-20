<?php header('Access-Control-Allow-Origin: *');

require_once 'dbc.php';
require_once 'val.php';

$id = val($_POST['id']);
$pin = val($_POST['pin']);

$sql = "UPDATE dnb_users SET pin = $pin WHERE id = $id";

$response = @mysqli_query($dbc, $sql);

if($response){
    $sql = "SELECT * FROM userLogin WHERE id = $id ORDER BY sprintId DESC LIMIT 1";

	$response = @mysqli_query($dbc, $sql);

	if(mysqli_num_rows($response)>0){
		$row = mysqli_fetch_assoc($response);
		$id = $row['id'];
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
		$email = $row['email'];
		$accountId = $row['accountId'];
		$accountValue = $row['accountValue'];
		$beforeSpending = $row['beforeSpending'];
		$goalValue = $row['goalValue'];
		$goalId = $row['goalId'];
		$sprintId = $row['sprintId'];
		$sprintStart = $row['sprintStart'];
		
		$json = array();
		$json['id'] = $id;
		$json['firstname'] = $firstname;
		$json['lastname'] = $lastname;
		$json['email'] = $email;
		$json['accountId'] = $accountId;
		$json['accountValue'] = $accountValue;
		$json['beforeSpending'] = $beforeSpending;
		$json['goalId'] = $goalId;
		$json['goalValue'] = $goalValue;
		$json['sprintStart'] = substr($sprintStart,0,10);
		$json['sprintId'] = $sprintId;
		$json = json_encode($json);
		//setcookie("login", $json, time()+3600, "/");
		echo $json;
	}
}else{
    echo mysqli_error($dbc);
    echo "\n\r";
    echo $sql;
}

mysqli_close($dbc);

?>