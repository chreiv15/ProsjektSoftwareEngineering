<?php

define("dbname", "hagfre15_dnb"); //Navn på database
define("salt", "13j45h13huih3u5h"); //Salt

/*
 * Valdidering av data til databasen gjøres med funksjonen val().
*/

function val($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

/*
** Calc methods
*/


function suggestSprintGoal($result, $goal) {
    
    $diff = $goal - $result;
    $q = abs($diff/$goal);
    if($diff<0) {
        return $goal*($q*2+1);
    } else {
        return $goal;
    }
}

/*
** Get methods
*/

function getSprintResult($userId) {
    
    $userId = val($userId);
    
    $before = getSpending($userId);
    $spending = getSprintSpending($userId);
    $goal = getCurrentGoal($userId);
    $currentSprintGoal = getCurrentSprintGoal($userId);
    $saved = $before - $spending;
    $nextSprintGoal = suggestSprintGoal($saved, $currentSprintGoal);
    echo "<div class='box'>";
    echo "<p>Goal value: $goal kr</p>";
    echo "<p>Current sprint goal: $currentSprintGoal kr</p>";
    echo "<p>Spending before: $before kr</p>";
    echo "<p>Spending now: $spending kr</p>";
    echo "<p>Saved this sprint: $saved kr</p>";
    echo "<p>Goal suggestion: $nextSprintGoal kr</p>";
    echo "</div>";
        
}

function getSprintSpending($userId) {
    
    require 'dbc.php';
    
    $sql = "SELECT SUM(t.value) FROM hagfre15_dnb.dnb_transactions AS t JOIN dnb_accounts AS a ON t.account = a.id JOIN dnb_users AS u ON a.owner = u.id WHERE u.id = $userId AND a.type = 1 AND accounting_date > DATE_SUB(curdate(), INTERVAL 1 MONTH)";
    
    $response = @mysqli_query($dbc, $sql);
    
    if($response) {
        return @mysqli_fetch_row($response)[0];
    }
    
}

function getAccounts($userId) {
    
    require 'dbc.php';
    
    $sql = 'SELECT * FROM '.dbname.'.dnb_accounts WHERE owner = '.$userId.' ORDER BY name DESC;';
    
    $response = @mysqli_query($dbc, $sql);
    
    if($response) {
        $string = '';
        $string .= '<table>';
        while($row = mysqli_fetch_array($response)) {
            $string .= '<tr><td>'.$row['id'].'</td><td>'.$row['name'].'</td><td>'.number_format($row['value'],2,",",".").' kr</td></tr>';
        }
        $string .= '</table>';
    } else {
        $string = 'No response (accounts)';
    }
    return $string;
    mysqli_close($dbc);
}

function getCurrentGoal($userId) {
    
    require 'dbc.php';
    
    $sql = 'SELECT value FROM '.dbname.'.dnb_goals WHERE owner = '.$userId.' ORDER BY ID DESC LIMIT 1;';

    $response = @mysqli_query($dbc, $sql);
    
    if($response) {
        return @mysqli_fetch_row($response)[0];
    }
    mysqli_close($dbc);
    
}

function getCurrentSprintGoal($userId) {
    
    require 'dbc.php';
    
    $sql = 'SELECT value, start, date, value/(ABS(DATEDIFF(start,date)))*30 AS goal FROM '.dbname.'.dnb_goals WHERE owner = '.$userId.' ORDER BY ID DESC LIMIT 1';

    $response = @mysqli_query($dbc, $sql);
    
    if($response) {
        $val = number_format(@mysqli_fetch_row($response)[3],0,"","");
        return $val;
    }
    mysqli_close($dbc);
    
}

function getGoals($id) {
    
    require 'dbc.php';
    
    $sql = 'SELECT * FROM '.dbname.'.dnb_goals WHERE owner = '.val($id).' ORDER BY name DESC';

    $response = @mysqli_query($dbc, $sql);
    
    if($response) {
        $string = '';
        $string .= '<table>';
        while($row = mysqli_fetch_array($response)) {
            $string .= '<tr><td>'.$row['id'].'</td><td>'.$row['name'].'</td><td>'.number_format($row['value'],2,",",".").' kr</td><td>'.$row['date'].'</td></tr>';
        }
        $string .= '</table>';
    } else {
        $string = 'No response (goals)';
    }
    return $string;
    mysqli_close($dbc);
}

function getSpending($id) {
    
    require 'dbc.php';
    
    $sql = 'SELECT spending FROM '.dbname.'.dnb_users WHERE id = '.val($id);
    
    $response = @mysqli_query($dbc, $sql);
    
    if($response) {
        return @mysqli_fetch_row($response)[0];
    }
    mysqli_close($dbc);
}

function getPassword($id) {
    
    require 'dbc.php';
    
    $sql = 'SELECT password FROM '.dbname.'.dnb_users WHERE id = '.val($id);
    
    $response = @mysqli_query($dbc, $sql);
    
    if($response) {
        return @mysqli_fetch_row($response)[0];
    }
    mysqli_close($dbc);
}

function getSpeningAccount($userId) {
    
    require 'dbc.php';
    
    $sql = 'SELECT id FROM '.dbname.'.dnb_accounts WHERE owner = '.$userId.' AND type = 1';
    
    $response = @mysqli_query($dbc, $sql);
    
    if($response) {
        return @mysqli_fetch_row($response)[0];
    }
    mysqli_close($dbc);
}

function getTransactions($account) {
    
    require 'dbc.php';

    $sql = 'SELECT * FROM '.dbname.'.dnb_transactions WHERE account = '.$account;
    
    $response = @mysqli_query($dbc, $sql);

    if($response){
        $string = '';
        $string .= '<table id="transactionTable">';
        while($row = mysqli_fetch_array($response)) {
            $string .= '<tr><td>'.$row['description'].'</td><td>'.number_format($row['value'],2,",",".").' kr</td></tr>';
        }
        $string .= '</table>';
    }
    return $string;
    mysqli_close($dbc);
}

function getCategories() {
    
    require 'dbc.php';
    
    $sql = 'SELECT * FROM '.dbname.'.dnb_categories;';

    $response = @mysqli_query($dbc, $sql);

    if($response){
        $string = '';
        while($row = mysqli_fetch_array($response)) {
            $string .= '<div id="'.$row['id'].'" class="categoryBox"><img src="../images/'.$row['id'].'.svg"><p>'.$row['name'].'</p></div>';
        }
        return $string;
    }
    mysqli_close($dbc);
}

function getUser($email, $password) {
    
    require 'dbc.php';

    //$password = 1234;
    $password = $password.salt;
    $password = md5($password);
    
    //echo $password;
    //echo $email;

    $sql = "SELECT * FROM ".dbname.".dnb_users WHERE email = '$email' AND password = '$password' LIMIT 1";
    
    //echo $sql;
    
    $response = @mysqli_query($dbc, $sql);

    if($response){
        $row = @mysqli_fetch_row($response);
        $id = $row[0];
        $firstname = $row[1];
        $lastname = $row[2];
        $email = $row[3];
        $content = "$id|$firstname|$lastname|$email|$phone";
        setcookie("login", $content, time()+3600, "/");
        return '<p>Velkommen, '.$firstname.'</p>';
    } else {
        return '<p class="error">No response</p>';
    }
    mysqli_close($dbc);
    
}


function getPasswordResetCode($userId) {
    
    $code = md5($userId.salt);
    return $code;

}

/*
** Check methods
*/

function checkResetCode($userId, $code) {
    
    $check = md5($userId.salt);
    
    if($check == $code) {
        return true;
    } else {
        return false;
    }

}

function resetPassword($email) {
    
    require 'dbc.php';

    $sql = "SELECT * FROM ".dbname.".dnb_users WHERE email = '$email' LIMIT 1";
    
    $response = @mysqli_query($dbc, $sql);

    if($response){
        //echo "<div>Passord sendt.<br>$sql</div>";
        $row = @mysqli_fetch_row($response);
        $id = $row[0];
        $firstname = $row[1];
        $lastname = $row[2];
        $email = $row[3];
    
        $code = getPasswordResetCode($id);
        $date =  date('d/m-Y');

        $to = $email;
        $subject = 'ØKT support';
        $message = "Hei, $firstname $lastname.<br><br>På anmodning fra vår nettside $date sender vi deg herved innloggingsopplysninger. Klikk <a href='http://westerdals.fredrikhagen.no/reset.php?c=$code&u=$id'>her</a> for å nullstille ditt passord.";
        $headers = 'From: support@okt.no' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        mail($to, $subject, $message, $headers);
        
    }
}

/*
** Add methods
*/

function addAccounts($userId, $type, $name) {
    
    require 'dbc.php';
    
    $sql = "INSERT INTO dnb_accounts (name, type, owner) VALUES ('$name',$type, $userId)";

    $response = @mysqli_query($dbc, $sql);

    if($response){
        $sql = "SELECT id, name FROM ".dbname.".dnb_accounts WHERE owner = $userId ORDER BY id DESC LIMIT 1";
        $response = @mysqli_query($dbc, $sql);
        $row = @mysqli_fetch_row($response);
        $accountId = $row[0];
        $accountName = $row[1];
        $string = '<p>Ny konto opprettet.</p>';
        $string .= '<p>Navn: '.$accountName.'</p>';
        $string .= '<p>Kontonummer: '.$accountId.'</p>';
    }
    return $string;
    mysqli_close($dbc);
}

function addGoal($name, $value, $date, $category, $userId) {
    
    require 'dbc.php';

    $sql = "INSERT INTO dnb_goals (name, value, date, category, owner) VALUES ('$name', $value, '$date',$category, $userId)";
    
    $response = @mysqli_query($dbc, $sql);

    if($response){
        return '<p>Sparemålet er lagt til</p>';
    }
    mysqli_close($dbc);
}

function addTransaction($description, $value, $category, $account) {
    
    require 'dbc.php';

    $sql = "INSERT INTO ".dbname.".dnb_transactions (description, value, category, account) VALUES ('$description', $value, $category, $account)";

    $response = @mysqli_query($dbc, $sql);

    if($response){
        return '<p>Transaksjon lagt til.</p>';
    }
    mysqli_close($dbc);
}

function addUser($firstname, $lastname, $email, $phone, $password) {

    require 'dbc.php';
    
    $sql = "INSERT INTO dnb_users (firstname, lastname, email, phone, password) VALUES('$firstname', '$lastname', '$email', '$phone', '$password')";

    $response = @mysqli_query($dbc, $sql);

    if($response){
        setcookie("login", "$id|$firstname|$lastname|$email|$phone", time() + 86400, "/");
        return '<p>Velkommen, '.$firstname.'</p>';
    }
    mysqli_close($dbc);
}

/*
** Set methods
*/

function setSpending($userId, $value) {

    require 'dbc.php';
    
    $sql = "UPDATE ".dbname.".dnb_users SET spending = $value WHERE id = $userId";

    $response = @mysqli_query($dbc, $sql);
    
    if($response){
        return 'Normalforbruk registrert.';
    }
}

function setPassword($userId, $password) {

    require 'dbc.php';
    
    $password = val($password);
    $password = $password.salt;
    $password = md5($password);
    
    $sql = "UPDATE ".dbname.".dnb_users SET password = '$password' WHERE id = $userId";

    $response = @mysqli_query($dbc, $sql);
    
    if($response){
        return 'Nytt passord registrert.';
    }
}

?>