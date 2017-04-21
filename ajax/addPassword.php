<?php header('Access-Control-Allow-Origin: *');

require_once 'dbc.php';
require_once 'val.php';

$id = val($_POST['id']);
$pin = val($_POST['pin']);

$sql = "UPDATE dnb_users SET pin = $pin WHERE id = $id";

$response = @mysqli_query($dbc, $sql);

if($response){
    $sql = "SELECT * FROM userLogin WHERE id = $id";

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
		
		$json = array();
		$json['id'] = $id;
		$json['firstname'] = $firstname;
		$json['lastname'] = $lastname;
		$json['email'] = $email;
		$json['accountId'] = $accountId;
		$json['accountValue'] = $accountValue;
		$json['beforeSpending'] = $beforeSpending;
		$json = json_encode($json);
		echo $json;
	}else{
		echo $sql;
	}
}else{
    echo mysqli_error($dbc);
    echo "\n\r";
    echo $sql;
}

mysqli_close($dbc);

?>