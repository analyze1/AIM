<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$check_acc_sql="SELECT name FROM tb_acc_new WHERE name = '".$_POST['name']."' AND idcar = '".$_POST['idcar']."' ";
$check_acc_query=mysql_query($check_acc_sql,$cndb1);
$check_acc_array=mysql_fetch_array($check_acc_query);
if(empty($check_acc_array['name']))
{
$insert_acc_sql="INSERT INTO tb_acc_new (name,idcar,idbcar,type,orderlist,id_type,status_free,start_cost) VALUES ('".$_POST['name']."','".$_POST['idcar']."','1','1','1','0','".$_POST['status_free']."','".$_POST['start_cost']."')";
$insert_acc_query=mysql_query($insert_acc_sql,$cndb1);
$message['alert']='บันทึก อป.'.$_POST['name'].' เรียบร้อยแล้วครับ';
$message['status']='Y';
}
else
{
	$message['alert']='มี อป.'.$_POST['name'].' อยู่ในระบบแล้วครับ';
	$message['status']='N';
}
echo json_encode($message);
?>