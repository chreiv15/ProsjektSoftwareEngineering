<?php

require_once '../../../functions.php';
$userId = val($_GET['user']);
$sprint = getSprintResult($userId);

echo '<h4 class="card-title">'.norDate($sprint['date']['start']).'</h4>'."\n\r";
echo '<hr>'."\n\r";
echo '<p class="current-text">Gjenstående beløp <span class="text-success"><br>'.$sprint['spending'].'/'.$sprint['currentSprintGoal'].'</span></p>'."\n\r";
echo '<i class="fa fa-cutlery category-icon" aria-hidden="true"></i>';
echo '<p class="current-days">'.$sprint['date']['diff'].' dager gjenstår</p>';
echo '<div class="progress-days"><progress max="30" value="'.(30-$sprint['date']['diff']).'"></progress></div>';

?>