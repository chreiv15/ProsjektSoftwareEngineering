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

function norDate($date) {
    $date = date("d.m.y", strtotime($date));
    return $date;
}

function getDaysUntil($date) {
/*
    $today = strtotime(date('Y-m-d'));
    $date = strtotime($date);
    $diff = date_diff($today,$date);
*/
    
    $today = date_create(date('Y-m-d'));
    $end = date_create($date);
    $diff = date_diff($today,$end);
    $diff = (array)$diff;
    $diff = $diff['days'];
    return $diff;
}

/*
** Calc methods
*/

/*
 * Metoden suggestSprintGoal kalkulerer et forslag til nytt
 * sparemål basert på hva du har spart tidligere.
*/
function suggestSprintGoal($result, $goal) {
    
    if(isset($goal)){
        $diff = $goal - $result;
        $q = abs($diff/$goal);
        if($diff<0) {
            return round($goal*($q*2+1)/10)*10;
        } else {
            return $goal;
        }
    } else {
        return 0;
    }
}

/*
** Get methods
*/
/*
** Metoden getStreakCount sjekker hvor mange økter der sparemålet er oppnådd på rad.
*/
function getStreakCount($userId) {

    require 'dbc.php';
    
    $userId = val($userId);
    
    $sql = "SELECT * FROM dnb_history WHERE user = $userId ORDER BY id DESC";
    
    $response = @mysqli_query($dbc, $sql);
    if($response) {
        $streak = 0;
        $lastSprint = 0;
        while($row = mysqli_fetch_array($response)) {
            if($row['result']>$row['target']) {
                $streak++;
            } else {
                break;
            }
        }
    }
    return $streak;
}

/*
** Metoden getLevel returnerer nivået brukeren er på. 
*/
function getLevel($userId, $spending) {
    
    $before = getBeforeSpending($userId);
    $percent = (1-$spending/$before)*100;
    $level = round($percent/2.5,0,PHP_ROUND_HALF_DOWN);
    if($level>0){
        return $level;
    }else{
        return 0;
    }

}


// Metoden getSpringResult henter ut øktens nøkkeltall og returnerer det som et array.
function getSprintResult($userId) {
    
    $userId = val($userId);
    $resultValues = array();
    
    $resultValues['before'] = getBeforeSpending($userId);
    $resultValues['spending'] = getSprintSpending($userId);
    $resultValues['goal'] = getCurrentGoal($userId);
    $resultValues['currentSprintGoal'] = getCurrentSprintGoal($userId);
    $resultValues['saved'] = $resultValues['before'] - $resultValues['spending'];
    $resultValues['nextSprintGoal'] = suggestSprintGoal($resultValues['saved'], $resultValues['currentSprintGoal']);
    $resultValues['level'] = getLevel($userId, $resultValues['spending']);
    $resultValues['streak'] = getStreakCount($userId);
    $resultValues['sprint'] = getCurrentSprint($userId);
    $resultValues['date']['start'] = getCurrentSprintStart($userId);
    $resultValues['date']['end'] = getCurrentSprintEnd($resultValues['date']['start']);
    $resultValues['date']['diff'] = getDaysUntil($resultValues['date']['end']);
    //echo addSprintResut($userId, $resultValues['sprint'], $resultValues['currentSprintGoal'], $resultValues['saved'], $resultValues['date']['start']);
    $resultValues['badges'] = checkBadgeResult($userId, $resultValues['level'],$resultValues['streak']);
    return $resultValues;        
}

//
function getCurrentSprint($userId) {
    
    require 'dbc.php';
    $sql = "SELECT MAX(sprint)+1 FROM hagfre15_dnb.dnb_history WHERE user = $userId";
    $response = @mysqli_query($dbc, $sql);
    if($response) {
        return @mysqli_fetch_row($response)[0];
    }
}

function getCurrentSprintStart($userId) {
    
    require 'dbc.php';
    $userId = val($userId);
    $sql = "SELECT MAX(startdate) FROM hagfre15_dnb.dnb_history WHERE user = $userId";
    $response = @mysqli_query($dbc, $sql);
    if($response) {
        $date = @mysqli_fetch_row($response)[0];
        return $date;
    }
}

function getCurrentSprintEnd($start) {
    $start = strtotime($start);
    $date = date("Y-m-d", strtotime("+1 month", $start));
    
    return $date;
}

function getSprintSpending($userId) {
    
    require 'dbc.php';
    
    $start = getCurrentSprintStart($userId);
    $end = getCurrentSprintEnd($start);
    
    $sql = "SELECT SUM(t.value) FROM hagfre15_dnb.dnb_transactions AS t JOIN dnb_accounts AS a ON t.account = a.id JOIN dnb_users AS u ON a.owner = u.id WHERE u.id = $userId AND a.type = 1 AND accounting_date BETWEEN '$start' AND '$end'";
    
    //echo $sql;
    
    $response = @mysqli_query($dbc, $sql);
    $val = 0;
    if($response) {
        $val += @mysqli_fetch_row($response)[0];
        return $val;
    }
    mysqli_close($dbc);
}

function getSprints($userId) {
    
    require 'dbc.php';
    $userId = val($userId);
    
    $sql = "SELECT * FROM hagfre15_dnb.dnb_history WHERE user = $userId ORDER BY sprint DESC;";
    
    $response = @mysqli_query($dbc, $sql);
    if($response) {
        $sprints = array();
        while($row = mysqli_fetch_assoc($response)) {
            array_push($sprints,array($row['sprint'],$row['startdate'],getCurrentSprintEnd($row['startdate'])));
        }
        return $sprints;
    }
    mysqli_close($dbc);
}

function getAccounts($userId) {
    
    require 'dbc.php';
    
    $sql = 'SELECT * FROM '.dbname.'.dnb_accounts WHERE owner = '.$userId.' ORDER BY name DESC;';
    
    $response = @mysqli_query($dbc, $sql);
    
    if($response) {
        $array = array();
        while($row = mysqli_fetch_assoc($response)) {
            array_push($array,$row);
        }
        return $array;
    }
    mysqli_close($dbc);
}

function getCurrentGoal($userId) {
    
    require 'dbc.php';
    
    $sql = 'SELECT * FROM '.dbname.'.dnb_goals WHERE owner = '.$userId.' AND date > "'.date('Y-m-d').'" ORDER BY date ASC LIMIT 1;';

    $response = @mysqli_query($dbc, $sql);
    
    if($response) {
        return (array)@mysqli_fetch_row($response);
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

function getBeforeSpending($id) {
    
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

    if(mysqli_num_rows($response)>0){
        $row = @mysqli_fetch_row($response);
        $id = $row[0];
        $firstname = $row[1];
        $lastname = $row[2];
        $email = $row[3];
        $phone = $row[4];
        $content = "$id|$firstname|$lastname|$email|$phone";
        setcookie("login", $content, time()+3600, "/");
        return 'true';
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

function checkBadgeResult($userId, $level, $streak) {
    $badges = array();
    switch($streak) {
        case 3:
            $badges['streak'] = 11;
            break;
        case 5:
            $badges['streak'] = 12;
            break;
        case 10:
            $badges['streak'] = 13;
            break;
        case 12:
            $badges['streak'] = 14;
            break;
        case 15:
            $badges['streak'] = 15;
            break;
        case 20:
            $badges['streak'] = 16;
            break;
        case 20:
            $badges['streak'] = 17;
            break;
        case 24:
            $badges['streak'] = 18;
            break;
        default:
            break;
    }
    $badges['level'] = 100+$level;
    
    return $badges;
    
}

function getBadges($userId) {
 
    require 'dbc.php';
    
    $userId = val($userId);
    
    $sql = "SELECT * FROM dnb_badges WHERE user = $userId ORDER BY badgeId DESC";
    
    $response = @mysqli_query($dbc, $sql);
    if($response) {
        $badges = array();
        while($row = mysqli_fetch_assoc($response)) {
            array_push($badges,array('id'=>$row['badgeId'],'amount'=>$row['amount']));
        }
        return $badges;
    }
    
}

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
        $row = @mysqli_fetch_row($response);
        $id = $row[0];
        $firstname = $row[1];
        $lastname = $row[2];
        $email = $row[3];
    
        $code = getPasswordResetCode($id);
        $date =  date('d/m-Y');

        $to = $email;
        $subject = 'ØKT support';
        if(mysqli_num_rows($response)>0){
            $message = "Hei, $firstname $lastname.<br><br>På anmodning fra vår nettside $date sender vi deg herved innloggingsopplysninger. Klikk <a href='http://westerdals.fredrikhagen.no/reset.php?c=$code&u=$id'>her</a> for å nullstille ditt passord.";
        }else{
            $message = "Hei,<br><br>Vi finner ingen bruker med e-postadressen du oppgir.";
        }
        $headers = 'From: ØKT Support <support@okt.no>' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        mail($to, $subject, $message, $headers);
        
    }
}

/*
** Add methods
*/

function addSprintResut($userId, $sprintId, $target, $result, $date) {
    
    require 'dbc.php';

    $sql = "INSERT INTO hagfre15_dnb.dnb_history (user, sprint, target, result, startdate) VALUES ($userId, $sprintId, $target, $result, '$date')";

    $response = @mysqli_query($dbc, $sql);

    if($response){
        return 'Resultater registrert';
    }
    mysqli_close($dbc);
}

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
    mysqli_close($dbc);
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
    mysqli_close($dbc);
}

?>