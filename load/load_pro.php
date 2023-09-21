<?php 
include "../../inc/connectdbs.pdo.php"; 
header('Content-Type: text/html; charset=utf-8');
$strRecive = stripslashes($_POST["findwith"]);
$arrData = json_decode($strRecive,true);
mysql_set_charset('utf-8');
$query  = "SELECT ";
$query .= "name ";
$query .= "FROM tb_province WHERE name LIKE '%".$arrData["textfix"]."%' LIMIT 0,6";
$result = mysql_query($query);
$i = 0;
while($array = mysql_fetch_array($result)){
$data['pro'][$i]['name'] = $array[0];

$i++;
}
echo json_encode($data);
?>