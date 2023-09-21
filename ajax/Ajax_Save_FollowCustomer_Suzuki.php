<?php
	header('Content-Type: text/html; charset=UTF-8');
	include "../check-ses.php"; 
	//include "../inc/checksession.inc.php";
	include "../inc/connectdbs.inc.php"; 
	
	//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
require("../email/PHPMailer/PHPMailerAutoload.php");  // เรียกไฟล์ class.phpmailer.php
	
	$login = $_SESSION["strUser"];
	$today_date = date('H:i:s');

	function DateSave($datetime)
	{
		list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
		list($d,$m,$Y) = split('/',$date); // แยกวันเป็น ปี เดือน วัน
		$Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.
		
		switch($m) 
		{
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
		return $Y."-".$m."-".$d;
	}
	
	$txt_date_fol=DateSave($_POST["txt_date_fol"]).' '.$today_date;	// ติดตาม
	$txt_date_appointment=DateSave($_POST["txt_date_appointment"]).' '.$today_date;	 // นัดชำระ

	$query_fol= "SELECT id_fol,status_fol From tb_follow_customer where id_data='".$_POST["txt_iddata"]."' AND  status_fol='Y' ORDER BY id_fol DESC limit 1";
	mysql_select_db($db1,$cndb1);
	$objQuery_fol= mysql_query($query_fol,$cndb1) or die ("Error _fol [".$query_fol."]");
	$row_fol= mysql_fetch_array($objQuery_fol);

	if($row_fol["status_fol"]=='')
	{
		$status_fol='';
	}
	else
	{
		$status_fol='Y';
	}

	$query_comp= "SELECT id_fol,status_fol,status_completed,status_other From tb_follow_customer where id_data='".$_POST["txt_iddata"]."' AND  status_completed='Y' ORDER BY id_fol DESC limit 1";
	mysql_select_db($db1,$cndb1);
	$objQuery_comp= mysql_query($query_comp,$cndb1) or die ("Error _comp [".$query_comp."]");
	$row_comp= mysql_fetch_array($objQuery_comp);

	if($row_comp["status_completed"]=='')
	{
		$status_completed='';
	}
	else
	{
		$status_completed='Y';
	}
	
	if($row_comp["status_fol"] == 'Y' && $row_comp["status_completed"] == 'Y')
	{
		// Insert tb_follow_customer
		$strSQL_fol = "INSERT INTO tb_follow_customer(id_data,detail_fol,date_fol,date_appointment,login_emp,status_fol,status_completed,status_other) VALUES ('".$_POST["txt_iddata"]."','".$_POST["txt_detail"]."','$txt_date_fol','$txt_date_appointment','".strtoupper($login)."','$status_fol','$status_completed','Y')";
		mysql_select_db($db1,$cndb1);
		$objQuery_fol = mysql_query( $strSQL_fol ,$cndb1);
	}
	else
	{
		// Insert tb_follow_customer
		$strSQL_fol = "INSERT INTO tb_follow_customer(id_data,detail_fol,date_fol,date_appointment,login_emp,status_fol,status_completed) VALUES ('".$_POST["txt_iddata"]."','".$_POST["txt_detail"]."','$txt_date_fol','$txt_date_appointment','".strtoupper($login)."','$status_fol','$status_completed')";
		mysql_select_db($db1,$cndb1);
		$objQuery_fol = mysql_query( $strSQL_fol ,$cndb1);
	}
			 				
	

	if($objQuery_fol)
	{	
		$returnedArray['status'] = true;
		$returnedArray['msg'] = "บันทึกข้อมูลเรียบร้อยแล้ว! ";
	}						
	else
	{
		$returnedArray['status'] = false;
		$returnedArray['msg'] = "บันทึกข้อมูลผิดพลาด !!!!!!!";
	}
	echo json_encode($returnedArray);



//	$query_user = "SELECT user_name,email From user where user_user='".strtoupper($login)."' ";	  
//	mysql_select_db($db2,$cndb2);
//	$objQuery_user = mysql_query($query_user,$cndb2) or die ("Error query_user [".$query_user."]");
//	$row_user = mysql_fetch_array($objQuery_user);

	$mail = new PHPMailer();  // กำหนดตัวแปร  $mail
	$mail->CharSet = 'UTF-8';                                                                
    $mail->From = "admin@my4ib.com";
    $mail->FromName = "ติดตามงาน"; // กำหนดชื่อผู้ส่ง
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = false;
    $mail->Host = _MAIL_MY4IB; // SMTP server
    //$mail->Port = 25; // พอร์ท
   // $mail->Username = "underwrite@my4ib.com"; // account SMTP
    //$mail->Password = "yaya"; // รหัสผ่าน SMTP
	$mail->IsHTML(false); 
	
	//$mail->AddAddress("", "");
	$mail->AddAddress("underwrite@my4ib.com", "");
	$mail->AddAddress("finance@my4ib.com", "");
	$mail->AddAddress("finance_1@my4ib.com", "");
	$mail->AddAddress("marketing_support5@my4ib.com", "");
	
	$mail->AddAddress("account_2@my4ib.com", "");
	$mail->AddAddress("account_5@my4ib.com", "");
	
	$mail->Subject = "รายละเอียดการติดตามงาน เลขที่ใบคำขอ : ".$_POST["txt_iddata"]; // กำหนดหัวข้ออีเมล์
	$mail->Body = "     วันที่ติดตาม            ".$txt_date_fol."\n"."     วันที่นัดชำระ           ".$txt_date_appointment."\n"."     รายละเอียดการติดตาม            ".$_POST["txt_detail"]."\n"."     ผู้ติดตาม                 "."(".$_SESSION["strName"].")";
	
	$mail->Send();

	
mysql_close();
?>