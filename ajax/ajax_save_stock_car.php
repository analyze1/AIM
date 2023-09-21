<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$id_br_car=$_POST['id_br_car'];
$id_mo_car=$_POST['id_mo_car'];
$id_mo_car_sub=$_POST['id_mo_car_sub'];
$id_car_color=$_POST['id_car_color'];
$car_regis_year=$_POST['car_regis_year'];
$car_motor1=$_POST['car_motor1'];
$car_motor2=$_POST['car_motor2'];
$car_body1=$_POST['car_body1'];
$car_body2=$_POST['car_body2'];
$car_price=$_POST['car_price'];
$date_save=$_POST['date_save'];
$startdate_payment=$_POST['startdate_payment'];
$enddate_payment=$_POST['enddate_payment'];
$date_sale=$_POST['date_sale'];
$user=$_SESSION['strUser'];
$login=$_POST['login'];
$alert="";
for($n=0;$n<count($id_br_car);$n++)
{
	$check_body_sql="SELECT car_body FROM tb_stock_car WHERE car_body = '".$car_body1[$n].$car_body2[$n]."'";
	$check_body_query=mysql_query($check_body_sql,$cndb1);
	$check_body_array=mysql_fetch_array($check_body_query);
	$check_motor_sql="SELECT car_motor FROM tb_stock_car WHERE car_motor = '".$car_motor1[$n]."-".$car_motor2[$n]."'";
	$check_motor_query=mysql_query($check_motor_sql,$cndb1);
	$check_motor_array=mysql_fetch_array($check_motor_query);
	if(!empty($check_body_array))
	{
		$alert.="เลขตัวถัง ".$check_body_array['car_body']." มีอยู่ในระบบแล้ว ไม่สามาถบันทึกได้! \n";
	}
	if(!empty($check_motor_array))
	{
		$alert.="เลขตัวเครื่อง ".$check_motor_array['car_motor']." มีอยู่ในระบบแล้ว ไม่สามาถบันทึกได้! \n";
	}
	if(empty($check_body_array) && empty($check_motor_array))
	{
	$insert_stock_sql="INSERT INTO tb_stock_car (id_br_car,id_mo_car,id_mo_car_sub,id_car_color,car_regis_year,car_motor,car_body,car_price,date_save,startdate_payment,enddate_payment,date_sale,date_system,login,login_save) VALUE 
	('".$id_br_car[$n]."','".$id_mo_car[$n]."','".$id_mo_car_sub[$n]."','".$id_car_color[$n]."','".$car_regis_year[$n]."','".$car_motor1[$n]."-".$car_motor2[$n]."','".$car_body1[$n].$car_body2[$n]."','".str_replace(',','',$car_price[$n])."','".$date_save[$n]."','".$startdate_payment[$n]."','".$enddate_payment[$n]."','".$date_sale[$n]."',NOW(),'".$login."','".$user."')";
	$insert_stock_query=mysql_query($insert_stock_sql,$cndb1);
	}
	$status_save='Y';
}
	
	$alert.='บันทึกข้อมูลเรียบร้อยแล้วครับ';

$message['alert']=$alert;
$message['status_save']=$status_save;
echo json_encode($message);
?>