<?PHP
//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
require("../email/PHPMailer/PHPMailerAutoload.php");  // เรียกไฟล์ class.phpmailer.php

$mail = new PHPMailer();  // กำหนดตัวแปร  $mail
	$mail->CharSet = 'UTF-8';                                                                
    $mail->From = "montree_r@my4ib.com"; // กำหนดอีเมล์ที่ใช้ในการส่ง
    $mail->FromName = "ขอรหัสผ่าน"; // กำหนดชื่อผู้ส่ง
    $mail->Host = _MAIL_MY4IB; // กำหนดที่อยู่โฮส
  //$mail->Mailer = "smtp"; 
	$mail->SMTPDebug = 0;
	//$mail->Port = 25; // พอร์ท
    $mail->AddAddress('montree_r@my4ib.com'); // กำหนดอีเมล์ผู้รับ
    $mail->Subject = "ขอรหัสผ่าน"; // กำหนดหัวข้ออีเมล์
	
	if($_POST['mail']!=''){
    $mail->Body = "ขอทราบรหัสผ่าน ".$_POST['mail']." ".$_POST['admin_name']; // กำหนดเนื้อหาอีเมล์
	}
	else if($_POST['username']!=''){
    $mail->Body = "ขอเปลี่ยน E-mail ".$_POST['username']." ".$_POST['nameUSER']; // กำหนดเนื้อหาอีเมล์
	}

    $mail->IsHTML(false); 

    $mail->SMTPAuth = "false"; 
    //$mail->Host = _MAIL_MY4IB;
   // $mail->Username = "montree_r@my4ib.com"; // กำหนดusername ของโฮส
   // $mail->Password = "my4ib"; // กำหนด password ของโฮส

if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
mysql_close();
?>