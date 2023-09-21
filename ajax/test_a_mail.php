<?php
require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
$mail = new PHPMailer();  // กำหนดตัวแปร  $mail

	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';                  
	$mail->SMTPAuth = true;
    $mail->SMTPSecure = 'ssl';
    $mail->Host = "ssl://smtp.gmail.com"; // SMTP server
	$mail->Port = 465; // พอร์ท
    $mail->SMTPDebug = 0;
	$mail->SMTPSecure = "";
    $mail->Username = "tonsmall073@gmail.com"; // account SMTP
    $mail->Password = "xxxxxxxxx"; // รหัสผ่าน SMTP
	$mail->From = 'wisaruth@my4ib.com';
	$mail->FromName ='test ja';
	$mail->Subject = "gmail.com test email "; // กำหนดหัวข้ออีเมล์
	$mail->Body = "Test email by gmail.com";
	$mail->AddAddress('wisaruth@my4ib.com', "my4ib");
	$mail->AddAddress('nooser_12@hotmail.com', "hotmail");
	//$mail->set('X-Priority','1');
	
    


	if($mail->Send())
	{
		echo "Success Mail";
	}
	else
	{
		echo "false Mail";
	}
?>