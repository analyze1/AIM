<?php
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$today_Y=date('y')+43;
$today_Y_cus=date('y');
$sql_insq = "SELECT q_auto FROM	 tb_quotation_car WHERE q_auto like 'QC".$today_Y."%' order by q_auto DESC";
$result_insq = mysql_query($sql_insq,$cndb1);
$result_array=mysql_fetch_array($result_insq);
$change_Y = "QC".$today_Y;
@$change = split($change_Y,$result_array['q_auto']);
@$number=$change[1]+1;
if($number<=9)
{
$code='000';
}
else if($number<=99)
{
$code='00';
}
else if($number<=999)
{
$code='0';
}
else if($number<=9999)
{
$code='';
}
$plus_code="QC".$today_Y.$code.$number;
$status_save='';
if(!empty($_POST['id_br_car']) && !empty($_GET['user']))
{
	$car_total=0;
	$id_br_car=$_POST['id_br_car'];
	$id_mo_car=$_POST['id_mo_car'];
	$id_mo_car_sub=$_POST['id_mo_car_sub'];
	$id_car_color=$_POST['id_car_color'];
	$car_motor1=$_POST['car_motor1'];
	$car_motor2=$_POST['car_motor2'];
	$car_body1=$_POST['car_body1'];
	$car_body2=$_POST['car_body2'];
	$car_price=$_POST['car_price'];
	$car_regis_year=$_POST['car_regis_year'];
	
	$res_price=$_POST['res_price'];
	$down_per=$_POST['down_per'];
	$down_price=$_POST['down_price'];
	$unit_year=$_POST['unit_year'];
	$interest_per=$_POST['interest_per'];
	$interest_price=$_POST['interest_price'];
	$interest_total=$_POST['interest_total'];
	$top_price=$_POST['top_price'];
	$total_price=$_POST['total_price'];
	$unit_price=$_POST['unit_price'];
	$login=$_POST['login'];
	$finance=$_POST['finance'];
	for($n=0;$n<count($id_br_car);$n++)
	{
	$tb_quotation_car_detail_sql="INSERT INTO tb_quotation_detail_car (id_br_car,id_mo_car,id_mo_car_sub,id_car_color,car_motor,car_body,car_price,car_regis_year,res_price,down_per,down_price,unit_year,interest_per,interest_price,interest_total,top_price,total_price,unit_price,q_auto)
	VALUES ('".$id_br_car[$n]."','".$id_mo_car[$n]."','".$id_mo_car_sub[$n]."','".$id_car_color[$n]."','".$car_motor1[$n].'-'.$car_motor2[$n]."','".$car_body1[$n].$car_body2[$n]."','".str_replace(',','',$car_price[$n])."','".$car_regis_year[$n]."','".str_replace(',','',$res_price[$n])."','".str_replace(',','',$down_per[$n])."','".str_replace(',','',$down_price[$n])."','".str_replace(',','',$unit_year[$n])."','".str_replace(',','',$interest_per[$n])."','".str_replace(',','',$interest_price[$n])."','".str_replace(',','',$interest_total[$n])."','".str_replace(',','',$top_price[$n])."','".str_replace(',','',$total_price[$n])."','".str_replace(',','',$unit_price[$n])."','".$plus_code."')";
	//echo $tb_quotation_car_detail_sql;
	$tb_quotation_car_detail_query=mysql_query($tb_quotation_car_detail_sql,$cndb1);
	$car_total+=str_replace(',','',$car_price[$n]);
	}
	//////////////////////////////////////////////////////////////////////////////////////////////	//////////////////////////////////////////////////////////////////////////////////////////////
	/*$name=$_POST['name'];
	$tel_mobile=$_POST['tel_mobile'];
	$detail=$_POST['detail'];*/
	$name='';
	$tel_mobile='';
	$detail='';
	$q_auto=$plus_code;
	$login_save=$_GET['user'];
	$tb_quotation_car_sql="INSERT INTO tb_quotation_car (name,tel_mobile,login,date_save,q_auto,car_total,detail,login_save,finance)
	VALUES ('".$name."','".$tel_mobile."','".$login."',NOW(),'".$q_auto."','".number_format($car_total,2,'.','')."','".$detail."','".$login_save."','".$finance."')";
	$tb_quotation_car_query=mysql_query($tb_quotation_car_sql,$cndb1);
	$status_save='Y';
}
$message['status']=$status_save;
echo json_encode($message);
?>