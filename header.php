<?php

header('Content-Type: text/html; charset=utf-8');
require_once 'functions.php';
require_once 'ajax/user.php';

?>

<style>
    body {
        background-color: #111;
        color: white;
        font-family: monospace;
        margin: 35px;
    }
    a {
        color: white;
    }
    table, th, td {
        border: 1px dashed #434242;
    } 
    table {
        border-collapse: collapse;
        margin-top: 10px;
        margin-left: -5px;    }
    td {
        padding: 5px 10px;
        background-color: #FFF;
        background-color: #000;
    }
    input[type="email"] {
        width: 200px;
    }
    .box {
        border: 2px solid red;
        padding: 0 15px;
        background-color: #FFF;
        background-color: #000;
        width: 50%;
        margin-bottom: 10px;
        margin-left: -15px;
    }
</style>

<?php

echo "User: $userFirstName $userLastName ($userId)<br>";

$accounts = getAccounts($userId);
echo '<p>Accounts: </p><pre>';
print_r($accounts);
echo '</pre>';

echo '<p>Goals: ';
$goals = getGoals($userId);
print_r($goals);
echo '</p>';

echo '<p>Transactions: ';
echo getTransactions(getSpeningAccount($userId));
echo '</p>';

echo '<p>Spending (30 days): ';
echo getSprintSpending($userId);
echo '</p>';

echo '<p>Spending (before): ';
echo getBeforeSpending($userId);
echo ' kr</p>';

echo '<p>Password: ';
echo getPassword($userId);
echo '</p>';

echo '<p>Password reset code: ';
echo getPasswordResetCode($userId);
echo '</p>';

echo '<p>Current streak: ';
echo getStreakCount($userId);
echo '</p>';

echo '<p>Badges: <pre>';
print_r(getBadges($userId));
echo '</pre>';

?>

<div class='box'>
    <h2>Sprint result</h2>
    <pre>
        <?php print_r(getSprintResult($userId));?>
    </pre>
</div>

<a href="ajax/getUser.php?user=ola.nordmann@gmail.com&password=1234">Logg inn som Ola Nordmann</a>
<br>
<a href="ajax/getUser.php?user=kari.nordmann@gmail.com&password=1234">Logg inn som Kari Nordmann</a>

<form method="post">
    <p>Nullstill passord</p>
    <input name="email" id="email" type="email" placeholder="Din e-post">
    <input type="submit">
</form>
<?php
    if(isset($_POST['email'])) {
        resetPassword($_POST['email']);
    }
?>