<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$sql="";

}
else
{
	$sql=" AND tb_follow_car.login = '".$_SESSION["strUser"]."' ";

}
$id_my=$_POST['id_my'];
$date_payment=$_POST['date_payment'];
$status=$_POST['status'];
$detail=$_POST['detail'];
$login_s=$_SESSION['strUser'];
$insert_follow_sql="INSERT INTO tb_follow_car (id_my,date_follow,date_payment,status,detail,login) VALUES ('".$id_my."',NOW(),'".$date_payment."','".$status."','".$detail."','".$login_s."')";
$insert_follow_query=mysql_query($insert_follow_sql,$cndb1);
if($insert_follow_query)
{
	$select_follow_sql="SELECT * FROM tb_follow_car
  LEFT JOIN tb_status_work ON (tb_follow_car.status = tb_status_work.status)
  WHERE id_my = '".$id_my."' ".$sql." ORDER BY date_follow DESC LIMIT 0,1";
  $select_follow_query=mysql_query($select_follow_sql,$cndb1);
  $select_follow_array=mysql_fetch_array($select_follow_query);
$date_follow=$select_follow_array['date_follow'];
$date_payment=$select_follow_array['date_payment'];
$detail=$select_follow_array['detail'];
$status_name=$select_follow_array['status_name'];
$login=$select_follow_array['login'];
	$save_data='Y';
}
else
{
	$save_data='N';
}
$message['save_data']=$save_data;
$message['login']=$login;
$message['date_follow']=$date_follow;
$message['date_payment']=$date_payment;
$message['detail']=$detail;
$message['status_name']=$status_name;
echo json_encode($message);
?>