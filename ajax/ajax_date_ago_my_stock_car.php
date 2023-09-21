<?php 
$date_ago=date('Y-m-d',strtotime($_POST['text_date']." +30 day"));
echo $date_ago;
?>