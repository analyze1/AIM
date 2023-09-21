<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$check_acc_sql="SELECT name FROM tb_acc_new WHERE id != '".$_POST['edit_id']."' AND name = '".$_POST['edit_name']."' AND idcar = '".$_POST['edit_idcar']."'";
$check_acc_query=mysql_query($check_acc_sql,$cndb1);
$check_acc_array=mysql_fetch_array($check_acc_query);
if(empty($check_acc_array['name']))
{
$edit_acc_sql="UPDATE tb_acc_new SET name = '".$_POST['edit_name']."',idcar = '".$_POST['edit_idcar']."',idbcar = '1',type = '1',orderlist = '1',id_type = '0',status_free = '".$_POST['edit_status_free']."',start_cost = '".$_POST['edit_start_cost']."',status_use = '".$_POST['edit_status_use']."' WHERE id = '".$_POST['edit_id']."'";
$edit_acc_query=mysql_query($edit_acc_sql,$cndb1);
$message['alert']='แก้ไข อป.'.$_POST['edit_name'].'เรียบร้อยแล้วครับ';
$message['status']='Y';
}
else
{
	$message['alert']='มี อป.'.$_POST['edit_name'].'อยู่ในระบบแล้วครับ';
	$message['status']='N';
}
echo json_encode($message);
?>