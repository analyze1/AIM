<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
if(!empty($_POST['id_data']) && !empty($_POST['type_sql']) && !empty($_POST['type_value']))
{
$id_data = $_POST['id_data'];
$type_sql=$_POST['type_sql'];
$type_value=$_POST['type_value'];
$renew_sql="UPDATE insuree SET ".$type_sql." = '".$type_value."' WHERE id_data = '".$id_data."'";
$renew_query=mysql_query($renew_sql,$cndb1);
$arraymessage['message']="บันทึกข้อมูลเรียบร้อยแล้วครับ";
}
else
{
	$arraymessage['message']="บันทึกข้อมูลไม่สำเร็จครับ!";
}
echo json_encode($arraymessage);
?>