<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$id_br_car=$_POST['id_br_car'];
$id_mo_car=$_POST['id_mo_car'];
$id_mo_car_sub=$_POST['id_mo_car_sub'];
$id_car_color=$_POST['id_car_color'];
$car_regis_year=$_POST['car_regis_year'];
$car_motor1='';//$_POST['car_motor1'];
$car_motor2='';//$_POST['car_motor2'];
$car_body1='';//$_POST['car_body1'];
$car_body2='';//$_POST['car_body2'];
$car_price=$_POST['car_price'];
$date_save='';//$_POST['date_save'];
$startdate_payment='';//$_POST['startdate_payment'];
$enddate_payment='';//$_POST['enddate_payment'];
$date_sale='';//$_POST['date_sale'];
$unit_car=$_POST['unit_car'];
$condition_car=$_POST['condition_car'];
$user=$_SESSION['strUser'];
$car_bsc=$_POST['car_bsc'];
$car_cost=$_POST['car_cost'];
$login=$_POST['login'];
$alert="";
$today_Y=date(y)+43;
$today_Y_cus=date(y);
$sql_insq = "SELECT q_auto FROM	tb_order_car WHERE q_auto like '".$today_Y."/%' order by q_auto DESC";
$result_insq = mysql_query($sql_insq,$cndb1);
$result_array=mysql_fetch_array($result_insq);
$change_Y = $today_Y."/";
@$change = split($change_Y,$result_array['q_auto']);
@$number=$change[1]+1;
if($number<=9)
{
$code='00';
}
else if($number<=99)
{
$code='0';
}
else
{
$code='';
}

$plus_code=$today_Y."/".$code.$number;
if(!empty($id_br_car))
{
$insert_order_sql="INSERT INTO tb_order_car (login,q_auto,date_save,login_save) VALUES ('".$login."','".$plus_code."',NOW(),'".$user."')";
$insert_order_query=mysql_query($insert_order_sql,$cndb1);
if($insert_order_query)
{
for($n=0;$n<count($id_br_car);$n++)
{

	$insert_order_detail_sql="INSERT INTO tb_order_detail_car (id_br_car,id_mo_car,id_mo_car_sub,id_car_color,car_regis_year,car_motor,car_body,car_price,startdate_payment,enddate_payment,date_sale,q_auto,unit_car,condition_car,car_bsc,car_cost) VALUE 
	('".$id_br_car[$n]."','".$id_mo_car[$n]."','".$id_mo_car_sub[$n]."','".$id_car_color[$n]."','".$car_regis_year[$n]."','','','".str_replace(',','',$car_price[$n])."','','','','".$plus_code."','".$unit_car[$n]."','".$condition_car[$n]."','".str_replace(',','',$car_bsc[$n])."','".str_replace(',','',$car_cost[$n])."')";
	$insert_order_detail_query=mysql_query($insert_order_detail_sql,$cndb1);
	
	$status_save='Y';
}
	
	$alert.='บันทึกข้อมูลเรียบร้อยแล้วครับ';
}
}
$message['alert']=$alert;
$message['status_save']=$status_save;
echo json_encode($message);
?>