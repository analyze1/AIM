<?php
include "../inc/connectdbs.pdo.php";
include "../pages/check-ses.php";
//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
require("../email/PHPMailer/PHPMailerAutoload.php");  // เรียกไฟล์ class.phpmailer.php

$iddata = $_POST['idD'];
$iduser = $_SESSION["iduser"];
$time = $_POST['times'];
$times = date('Y-m-d',strtotime($_POST['times']));

$strSQL = "SELECT renew_id FROM URenew WHERE renew_id = '$iddata' ORDER BY renew_id DESC LIMIT 0,1";
$result22 = PDO_CONNECTION::fourinsure_mitsu()->query($strSQL);
$result_data = $result22->rowCount();

$queryNameem = "SELECT * FROM  tb_customer WHERE address = 'SALE4ib' ";
$objQueryEmp = PDO_CONNECTION::fourinsure_mitsu()->query($queryNameem);
foreach($objQueryEmp->fetchAll(2) as  $rowEmp) 
{
	$EMP[$rowEmp['pw']] = $rowEmp['sub'];
}

if($result_data==0)
{
	$strSQL = "INSERT INTO URenew (renew_id) VALUES  ('$iddata')";
	$result22 = PDO_CONNECTION::fourinsure_mitsu()->query($strSQL);
}

$sql1 = "SELECT  renew_logopen,renew_date_open  FROM URenew WHERE renew_id='$iddata'";
$result1 = PDO_CONNECTION::fourinsure_mitsu()->query($sql1);
$row1 = $result1->fetch(2);

if($row1['renew_date_open']=='')
{
	$opentime =" ,renew_date_open='$time' ";
}
if($row1['renew_logopen']=='')
{
	$checkbox = array($iduser=>array($times=>1));
	$dataUpdate  = str_replace('"','\"',serialize($checkbox)) ; 
}
else
{
	$checkbox = unserialize(  str_replace('\"','"', $row1['renew_logopen'] ));
	$checkbox[$iduser][$times]=intval($checkbox[$iduser][$times]+1);
	$dataUpdate  = str_replace('"','\"',serialize($checkbox)) ; 
}

	$sql = "UPDATE  URenew SET renew_logopen='$dataUpdate' $opentime WHERE renew_id='$iddata'";
	$result = PDO_CONNECTION::fourinsure_mitsu()->query($sql);	
	// if($sql)
	// {
	// 		$mail = new PHPMailer();  // กำหนดตัวแปร  $mail
	// 		$mail->CharSet = 'UTF-8';                                                                
	// 		$mail->From = "system@my4ib.com";
	// 		$mail->FromName = "ควบคุมข้อมูลต่ออายุ"; // กำหนดชื่อผู้ส่ง
	// 		$mail->IsSMTP();
	// 		$mail->SMTPDebug = 0;
	// 		$mail->SMTPAuth = false;
	// 		$mail->Host = _MAIL_MY4IB // SMTP server
	// 		$mail->Port = 25; // พอร์ท
	// 		// $mail->Username = "system@my4ib.com"; // account SMTP
	// 		// $mail->Password = "sys10820"; // รหัสผ่าน SMTP
	// 		$mail->Username = "prakunpai@my4ib.com"; // account SMTP
 //    		$mail->Password = "pra12641"; // รหัสผ่าน SMTP
	// 		$mail->Subject = "มีการเปิดดูข้อมูลต่ออายุ ".$_SESSION["strUser"]; // กำหนดหัวข้ออีเมล์
	// 		$mail->Body = $_SESSION["strUser"]."  ได้เปิดดูข้อมูล ".$iddata;
	// 		// $mail->AddAddress('piyaphon@my4ib.com', "");
	// 		$mail->IsHTML(false); 
	
	// 		echo $mail->Send();
	// }
// mysql_close();

?>