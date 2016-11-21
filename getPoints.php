<?php

$before = 4000;
$spending = $_GET['value'];
$saved = $before-$spending;
$percent = (1-$spending/$before)*100;
$level = round($percent/2.5,0,PHP_ROUND_HALF_DOWN);

echo "Before: $before<br>";
echo "Spending: $spending<br>";
echo "Saved: $saved<br>";
echo "Percent: $percent<br>";
echo "Level: $level<br>";

?>