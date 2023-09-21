<?php
//require_once ("db.class.sqlsrv.php");

$params = array();
$cursor = array("Scrollable" => SQLSRV_CURSOR_KEYSET);

/* Get UID and PWD from application-specific files.  */
$uid ="sa";//"sa"; //file_get_contents("C:\AppData\uid.txt");
$pwd = "456456";//"3^*bethel2013";//file_get_contents("C:\AppData\pwd.txt");

$dbnm ="chat_thingy"; 
$serverName = ".\SQL";
$connectionInfo = array("UID"=>$uid,"PWD"=>$pwd,"Database"=>$dbnm, "ReturnDatesAsStrings"=> true, "CharacterSet" => 'utf-8');

$db2 = new DB ($serverName,$connectionInfo);

?>