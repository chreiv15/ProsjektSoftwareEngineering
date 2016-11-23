<?php

require_once '../../../functions.php';
$userId = val($_GET['user']);
$sprint = getSprintResult($userId);

echo '<a class="item item-icon-left" href="#">'."\n\r";
echo '<i class="fa fa-check-circle-o text-success" aria-hidden="true"></i>'."\n\r";
echo 'ØKT '.$sprints[$i][0]."\n\r";
echo '<span class="item-note">'.norDate($sprints[$i][1]).' - '.norDate($sprints[$i][2]).'</span>'."\n\r";
echo '</a>'."\n\r";

?>