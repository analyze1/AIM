<?php
session_start();

$_SESSION['color']='red';

class utilities {
	//public static $color = $_SESSION['color']; //see here

 function display($usr)   
 {      
     echo $usr;  
 }
}

echo utilities::display($_SESSION['color']); 

?>