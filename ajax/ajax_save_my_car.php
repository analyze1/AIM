<?php
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$status_save='';
$user=$_POST['user'];
$login=$_POST['login'];
$id_my=$_POST['id_my'];
$id_stock=$_POST['id_stock'];
$title=$_POST['title'];
$name=$_POST['name'];
$last=$_POST['last'];
$add=$_POST['add'];
$group=$_POST['group'];
$home=$_POST['home'];
$lane=$_POST['lane'];
$road=$_POST['road'];
$id_province=$_POST['id_province'];
$id_amphur=$_POST['id_amphur'];
$id_tumbon=$_POST['id_tumbon'];
$postal=$_POST['postal'];
$job=$_POST['job'];
$tel_mobile1=$_POST['tel_mobile1'];
$tel_mobile2=$_POST['tel_mobile2'];
$tel_mobile3=$_POST['tel_mobile3'];
$tel_office=$_POST['tel_office'];
$tel_home=$_POST['tel_home'];
$id_line=$_POST['id_line'];
$facebook=$_POST['facebook'];
$source=$_POST['source'];
$id_card=$_POST['id_card'];
$seller=$_POST['seller'];
if(empty($id_my) || $id_my == '')
{
$insert_my_car_sql="INSERT INTO tb_my_car (`id_stock`,`title`,`name`,`last`,`add`,`group`,`home`,`lane`,`road`,`id_province`,`id_amphur`,`id_tumbon`,`postal`,`job`,`tel_mobile1`,`tel_mobile2`,`tel_mobile3`,`tel_office`,`tel_home`,`id_line`,`facebook`,`source`,`date_my_car`,`car_status`,`login`,`id_card`,`seller`,`login_save`) VALUES
('".$id_stock."','".$title."','".$name."','".$last."','".$add."','".$group."','".$home."','".$lane."','".$road."','".$id_province."','".$id_amphur."','".$id_tumbon."','".$postal."','".$job."','".$tel_mobile1."','".$tel_mobile2."','".$tel_mobile3."','".$tel_office."','".$tel_home."','".$id_line."','".$facebook."','".$source."',NOW(),'Y','".$login."','".$id_card."','".$seller."','".$user."')";
}
else
{
	
	$insert_my_car_sql="UPDATE tb_my_car SET 
	`id_stock` = '".$id_stock."',
	`title` = '".$title."',
	`name` = '".$name."',
	`last` = '".$last."',
	`add` = '".$add."',
	`group` = '".$group."',
	`home` = '".$home."',
	`lane` = '".$lane."',
	`road` = '".$road."',
	`id_province` = '".$id_province."',
	`id_amphur` = '".$id_amphur."',
	`id_tumbon` = '".$id_tumbon."',
	`postal` = '".$postal."',
	`job` = '".$job."',
	`tel_mobile1` = '".$tel_mobile1."',
	`tel_mobile2` = '".$tel_mobile2."',
	`tel_mobile3` = '".$tel_mobile3."',
	`tel_office` = '".$tel_office."',
	`tel_home` = '".$tel_home."',
	`id_line` = '".$id_line."',
	`facebook` = '".$facebook."',
	`source` = '".$source."',
	`date_my_car` = NOW(),
	`car_status` = 'Y',
	`login` = '".$login."',
	`login_save` = '".$user."',
	`id_card` = '".$id_card."',
	`seller` = '".$seller."'
	WHERE id_my = '".$id_my."'";
}
//echo $insert_my_car_sql;
$insert_my_car_query=mysql_query($insert_my_car_sql,$cndb1);
if($insert_my_car_query)
{
	$update_status_sql="UPDATE tb_stock_car SET car_status = 'Y' WHERE id_stock = '".$id_stock."'";
	$update_status_query=mysql_query($update_status_sql,$cndb1);
	$status_save='Y';
}
$massage['status'] = $status_save;
echo json_encode($massage);
?>