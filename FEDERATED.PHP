<?php
// require($_SERVER['DOCUMENT_ROOT'].'/allCon.php');
// include "./inc/connectdbs.pdo.php"; 
function setACT($id_data,$hostname_conn,$username_conn,$password_conn,$database_conn){
	$host = "localhost";
	$user = _USERNAME_FOUR;//fourinsure_new
	$pass = _PASS_FOUR;//kalanchoe
	$db = _DB_FOUR_INSURED;
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($db,$link);
	mysql_set_charset('utf8');

	$sql = @file_get_contents('../FEDERATED.TXT');
	if($id_data != '')
	{
		$sql.=" AND data.id_data LIKE '".$id_data."'";
		$sql.=" ORDER BY fourinsure_insured.data.send_date DESC";
	} else {
		$sql.=" ORDER BY fourinsure_insured.data.send_date DESC";
	}
	$query = mysql_query($sql,$link);
	setTable(@file_get_contents('../__report_act.txt'),$hostname_conn,$username_conn,$password_conn,$database_conn);
	$rpt = "";
	while ($fetch = mysql_fetch_assoc($query)) {
		$mo_car = getMocar($fetch['__mo_car'],$hostname_conn,$username_conn,$password_conn,$database_conn);
		$fetch['mo_car'] = $mo_car;
		$rpt="
		INSERT INTO __report_act
		VALUES(
			'".$fetch['ACT']."',
			'".$fetch['send_Attached']."',
			'".$fetch['id_data']."',
			'".$fetch['name']."',
			'".$fetch['send_date']."',
			'".$fetch['start_date']."',
			'".str_replace("'", "''", $fetch['print_act'])."',
			'".$fetch['mo_car']."',
			'".$fetch['car_body']."',
			'".$fetch['cost']."',
			'".$fetch['pre']."',
			'".$fetch['product']."',
			'".$fetch['CostProduct']."',
			'".$fetch['__year']."',
			'".$fetch['__user']."',
			'".$fetch['__admin']."'
		);
		";
		setTable($rpt,$hostname_conn,$username_conn,$password_conn,$database_conn);
	}
}
function getMocar($prmMoCar,$host,$user,$pass,$db){
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($db,$link);
	mysql_set_charset('utf8');
	$sql = "SELECT
		fourinsure_mitsu.tb_mo_car.name as mo_car
	FROM fourinsure_mitsu.tb_mo_car
	WHERE
		fourinsure_mitsu.tb_mo_car.id = '".$prmMoCar."'
	";
	$query = mysql_query($sql,$link);
	$fetch = mysql_fetch_assoc($query);
	return $fetch['mo_car'];
}
function setTable($sql,$host,$user,$pass,$db){
	$link = mysql_connect($host,$user,$pass);
	mysql_select_db($db,$link);
	mysql_set_charset('utf8');
	$query = mysql_query($sql,$link)or die(mysql_error()."<br>".$sql);
}
?>