<?php

require_once '../../../functions.php';
$userId = val($_GET['user']);
//$goal = getCurrentGoal($userId);
$sprint = getSprintResult($userId);

echo '<h4 class="card-title">Ditt sparemål er: <span class="text-success">'.$sprint['goal'][1].'</span></h4>'."\n\r";
echo '<hr>'."\n\r";
echo '<i class="fa category-icon" aria-hidden="true"><img src="../../../images/'.$sprint['goal'][4].'.svg"></i>'."\n\r";
echo '<p class="current-days">Du har spart <span class="text-success">'.$sprint['saved'].'</span> kroner denne økten</p>'."\n\r";

?>