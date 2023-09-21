<?php
	header('Content-Type: text/html; charset=UTF-8');
	include "../check-ses.php";
	include "../../inc/connectdbs.pdo.php";
//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
require("../email/PHPMailer/PHPMailerAutoload.php");  // เรียกไฟล์ class.phpmailer.php
function DateSave($datetime) {
	list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($d,$m,$Y) = split('/',$date); // แยกวันเป็น ปี เดือน วัน
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
	return $Y."-".$m."-".$d;
}								
	$send_date = DateSave($_POST["send_date"]);
	
	if($_POST['xuser'] == 'admin')
	{
		$login = $_POST["Dxuser"];
		$query_D ="SELECT * FROM `tb_customer` WHERE `user` = '$login' and `nameuser` = 'Mitsubishi'"; // id = '1' 
		$objQueryD = mysql_query($query_D) or die ("Error Query [".$query_D."]");
		while($objResultD = mysql_fetch_array($objQueryD))
		{
			$name_inform = $objResultD['title_sub'].' '.$objResultD['sub'];
		}
	}
	else
	{
		$login = $_POST["xuser"];
		$name_inform = $_POST["name_inform"];
	}
	
	$query_userMK ="SELECT * FROM `tb_customer` WHERE `user` = '$login' and `nameuser` = 'Mitsubishi'"; // id = '1' 
	$objQuery_userMK = mysql_query($query_userMK) or die ("Error Query [".$query_userMK."]");
	$row_userMK = mysql_fetch_array($objQuery_userMK);
	
	$storetotal = $_POST['total'];
	$contact = $_POST['contact'];
	$tel_contact = $_POST['tel_contact'];
	$email_re	= $_POST['email_re'];
	$mrenew	= $_POST['mrenew'];
	$mnew	= $_POST['mnew'];

	$getCondition='';
	$getRe='';
	if($mrenew=='R'){ 
		$getRenew = $mrenew.'|'.$contact.'|'.$tel_contact.'|'.$email_re;
		$getCondition .= " ,myear_request ='".$getRenew."' , myear_date = '".$send_date."'  ";
		$getRe .= 'ต่ออายุ Mitsubishi (ปี2) ';
	}
	if($mnew=='N'){ 
		$getnew = $mrenew.'|'.$contact.'|'.$tel_contact.'|'.$email_re;
		$getCondition .= " , mnew_request = '".$getnew."' ,mnew_date = '".$send_date."' ";
		$getRe .= ' แจ้งประกันภัยใหม่';
	}

	$suj = "แจ้งขอสิทธิ์การใช้งานเมนู  ของ [".$login."]".$name_inform;
	
					
	$mail = new PHPMailer();  // กำหนดตัวแปร  $mail
	$mail->CharSet = 'UTF-8';                                                                
    $mail->From = $email_re; // กำหนดอีเมล์ที่ใช้ในการส่ง
    $mail->FromName = $name_inform; // กำหนดชื่อผู้ส่ง
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = false;
	$mail->Host = _MAIL_MY4IB; // SMTP server 
    $mail->Port = 25; // พอร์ท
    //$mail->Username = "system_info@my4ib.com"; // กำหนดusername ของโฮส underwrite_prb@my4ib.com
   // $mail->Password = "sys12345"; // กำหนด password ของโฮส 12345
	$mail->IsHTML(false); 

	$mail->AddAddress('pothai@my4ib.com'); // กำหนดอีเมล์ผู้รับ2
	$mail->AddAddress('marketing_support@my4ib.com', ""); // กำหนดอีเมล์ผู้รับ2
	$mail->AddAddress('theedanai@my4ib.com', "");
	$mail->AddAddress('supinya@my4ib.com', ""); // กำหนดอีเมล์ผู้รับ2
	$mail->AddCC('system_info@my4ib.com', "");

	
	
		
    $mail->Subject = "แจ้งขอสิทธิ์การใช้งานเมนู. ".$name_inform; // กำหนดหัวข้ออีเมล์
    $mail->Body = "แจ้งขอสิทธิ์การใช้งานเมนู. ของ ".$name_inform."[".$login."]"."\n"."  "."\n"." ขอสิทธิ์ เข้าใช้งานเมนู  ".$getRe."\n"."ผู้ติดต่อ : ".$contact."\n"."โทรศัพท์ : ".$tel_contact."\n"."E-Mail.".$email_re."\n"." หากอนุมัติเปิดใช้งานเมนูดังกล่าว กรุณาแจ้งทาง IT เปิดระบบค่ะ   \n"; // กำหนดเนื้อหาอีเมล์	
   
	$mail->Send();
	
	if(!empty($getCondition)){
		mysql_query("SET NAMES 'utf8'");						
		$strSQL = "update  tb_customer SET  menu_red='Y' ".$getCondition."  WHERE  `user` = '".$login."'   "; 					
		$objQuery = mysql_query($strSQL);
	}
	

	if($objQuery)
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

mysql_close();
?>