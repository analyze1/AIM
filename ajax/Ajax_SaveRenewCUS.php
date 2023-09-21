<?php
include "../pages/check-ses.php";
include "../../inc/connectdbs.pdo.php";
//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
require("../email/PHPMailer/PHPMailerAutoload.php");  // เรียกไฟล์ class.phpmailer.php

$userrenew = $_SESSION["strUser"];
$namerenew = $_POST['nameRenew'];
$telrenew = $_POST['telRenew'];
$faxrenew = $_POST['faxRenew'];
$emailrenew = $_POST['emailRenew'];

$SqlUpdate = "UPDATE tb_customer SET emp_namerenew = '" . $namerenew . "', emp_telrenew    = '" . $telrenew . "', emp_faxrenew   = '" . $faxrenew . "', emp_emailrenew   = '" . $emailrenew . "'                    WHERE user = '" . $userrenew . "'";
$SqlUpdateQ = mysql_query($SqlUpdate) or die("Error Query " . $SqlUpdate . "");

if($SqlUpdateQ)
{
	// $mail = new PHPMailer();  // กำหนดตัวแปร  $mail
	// $mail->CharSet = 'UTF-8';                                                                
 //    $mail->From = "system@my4ib.com";
 //    $mail->FromName = "ควบคุมข้อมูลต่ออายุ"; // กำหนดชื่อผู้ส่ง
 //    $mail->IsSMTP();
 //    $mail->SMTPDebug = 0;
 //    $mail->SMTPAuth = false;
 //    $mail->Host = _MAIL_MY4IB; // SMTP server
 //    $mail->Port = 25; // พอร์ท
 //    // $mail->Username = "system@my4ib.com"; // account SMTP
 //    // $mail->Password = "sys10820"; // รหัสผ่าน SMTP
 //    $mail->Username = "prakunpai@my4ib.com"; // account SMTP
 //    $mail->Password = "pra12641"; // รหัสผ่าน SMTP
	//  $mail->Subject = "มีการแก้ไขชื่อผู้ติดต่องานต่ออายุ ".$_SESSION["strUser"]; // กำหนดหัวข้ออีเมล์
 //    $mail->Body = $_SESSION["strUser"]."  ได้แก้ไขข้อมูล ชื่อ $namerenew เบอร์โทร $telrenew เบอร์แฟกซ์ $faxrenew อีเมล์ $emailrenew";
	// $mail->AddAddress('supinya@my4ib.com', "");
 //    $mail->IsHTML(false); 
	
	// $mail->Send();
		
	$returnedArray['status'] = true;
	$returnedArray['msg'] = "บันทึกข้อมูลเรียบร้อยแล้ว! ";
}
else
{
	$returnedArray['status'] = false;
	$returnedArray['msg'] = "บันทึกข้อมูลผิดพลาด !!!!!!!";
}	
echo json_encode($returnedArray);


mysql_close();
?>
