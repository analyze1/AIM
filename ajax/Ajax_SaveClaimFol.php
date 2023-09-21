<?php

include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php"; 
session_start();
$sesslogin = $_SESSION["strUser"];

function thaiDateSAVE($datetime) 
{
	list($date,$time) = explode(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($d,$m,$Y) = explode('/',$date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.

	switch($m) {
	case "01": $m = "01"; break;
	case "02": $m = "02"; break;
	case "03": $m = "03"; break;
	case "04": $m = "04"; break;
	case "05": $m = "05"; break;
	case "06": $m = "06"; break;
	case "07": $m = "07"; break;
	case "08": $m = "08"; break;
	case "09": $m = "09"; break;
	case "10": $m = "10"; break;
	case "11": $m = "11"; break;
	case "12": $m = "12"; break;
	}	
	return $Y.'-'.$m.'-'.$d;
} 

$main = $_POST['main'];
$iddata = $_POST['iddata'];
$textdetail = $_POST['textdetail'];
$claimAction = $_POST['claimAction'];
$login = $_POST['4_login'];
$datefol = thaiDateSAVE($_POST['datefol']);
$daterepair = thaiDateSAVE($_POST['date_repair']);
$user = $_SESSION['strUser'];

// $txt_date_claim = $_POST['txt_date_claim'];

/*
if($txt_date_claim=='N' || $txt_date_claim=='')
{
	$txt_claim_no = 'ไม่ระบุ';
	$claim_number = '0';
}
else
{
	$se_claim_no_sql = "SELECT claim_no FROM tb_claim WHERE id = '$txt_date_claim'";
	$se_claim_no_query = PDO_CONNECTION::fourinsure_mitsu()->query($se_claim_no_sql);
	$txt_claim_no = $se_claim_no_query->fetch(7);
	$claim_number = $txt_date_claim;
	$tb_claim_sql = "UPDATE tb_claim SET claim_damage_list = '$_POST[damage]' WHERE id = '$txt_date_claim'";
	$tb_claim_query = PDO_CONNECTION::fourinsure_mitsu()->prepare($tb_claim_sql)->execute();
}*/

$dateT = date('Y-m-d H:i:s');
$strSQL = "INSERT INTO  tb_claimfollow (`id_data`, `claim_no`, `folstatus`, `detailtext`, `userdetail`, 
`timecall`,`datefollow`, `lastfollow`,`date_repair`,`informer`,`damage`,`cost_estimate`,`id_claim`) VALUES
	('$iddata', '".$txt_claim_no."', '$main', '$textdetail','$user','$dateT', '$datefol',
	'1','$daterepair','$_POST[informer]','$_POST[damage]','$_POST[cost_estimate]',
	'$claim_number')";

$result = PDO_CONNECTION::fourinsure_mitsu()->prepare($strSQL)->execute();

if($_POST['status_claim']=='Y')
{
	$sql = "INSERT INTO claim_done (`Status`,StatusDone,`DateTime`,id_data,DealerCode) VALUES ('Y','$_POST[status_claim_done]',NOW(),'$iddata','$user')";
	PDO_CONNECTION::fourinsure_mitsu()->prepare($sql)->execute();
}

if($result==true)
{
	echo json_encode('บันทึกสำเร็จ');
}
else
{
	echo json_encode('บันทึกไม่สำเร็จ');
}
