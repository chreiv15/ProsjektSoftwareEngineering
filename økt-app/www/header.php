<?php

header('Content-Type: text/html; charset=utf-8');
require_once 'functions.php';
require_once 'ajax/user.php';

?>

<style>
    body {
        background-color: #EEE;
    }
    table, th, td {
        border: 1px solid black;
    } 
    table {
        border-collapse: collapse;
        margin-top: 10px;
    }
    td {
        padding: 5px 10px;
        background-color: #FFF;
    }
    input[type="email"] {
        width: 200px;
    }
    .box {
        border: 2px solid red;
        padding: 0 15px;
    }
</style>

<?php

echo "User: $userFirstName $userLastName ($userId)<br>";

$accounts = getAccounts($userId);
echo '<p>Accounts: ';
print_r($accounts);

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
echo getSpending($userId);
echo ' kr</p>';

echo '<p>Password: ';
echo getPassword($userId);
echo '</p>';

echo '<p>Password reset code: ';
echo getPasswordResetCode($userId);
echo '</p>';

echo '<p>New goal suggestion: ';
echo suggestSprintGoal(2200, 2000);
echo '</p>';

getSprintResult($userId);

?>
<a href="ajax/getUser.php?user=5201000">Logg inn som Ola Nordmann</a>
<br>
<a href="ajax/getUser.php?user=5201001">Logg inn som Kari Nordmann</a>

<form method="post">
    <p>Nullstill passord</p>
    <input name="email" id="email" type="email" placeholder="Din e-post">
    <input type="submit">
</form>
<?php
    if($_POST['email']) {
        resetPassword($_POST['email']);
    }
?>