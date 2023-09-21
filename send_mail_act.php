<style type="text/css">
.green_msg{ padding:30px; border:#75FFBA solid 1px; background-color:#E6FFF2; text-align:center; font-size:12px; width:350px; color:#666666; }
.red_msg{ padding:30px; border:#FF9191 solid 1px; background-color:#FFECEC; text-align:center; font-size:12px; width:350px; color:#666666; }
</style>
<div align="center" style="padding-top:30px;">
<?php
include "../inc/connectdbs.pdo.php";
//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
require("email/PHPMailer/PHPMailerAutoload.php");  // เรียกไฟล์ class.phpmailer.php
    $mail = new PHPMailer();
	$mail->CharSet = "utf-8";
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = false;
    $mail->Host = _MAIL_MY4IB; // SMTP server
    //$mail->Port = 25; // พอร์ท
   // $mail->Username = "prakunpai@my4ib.com"; // account SMTP
    //$mail->Password = "pra12641"; // รหัสผ่าน SMTP


//humen@my4ib
//12345

    $mail->SetFrom("prakunpai@my4ib.com", "prakunpai@my4ib.com");
	
    //$mail->AddReplyTo("stmp@localhost.com", "stmp");
    //header("Content-type: text/html; charset=utf-8");
	
	$txtForm = $_POST['txtForm'];
	$txtTo1 = $_POST['txtTo1'];
	$txtTo2 = $_POST['txtTo2'];
	$txtTo3 = $_POST['txtTo3'];
	$txtTo4 = $_POST['txtTo4'];
	$txtTo5 = $_POST['txtTo5'];
	$txtTo6 = $_POST['txtTo6'];
	$txtCC = $_POST['txtCC'];
	$sub1 =$_POST['txtSubject'];
	$txtSubject_show = $sub1;
	$txtdata_form = stripcslashes ($_POST['txtdata_form']);
		
	$mail->Subject = $txtSubject_show;

	$body = $txtdata_form;
	$mail->MsgHTML($body);
	
	// Email ผู้รับ
	if($txtTo1!=""){
		$mail->AddAddress($txtTo1, "");
	}
	if($txtTo2!=""){
		$mail->AddAddress($txtTo2, "");
	}
	if($txtTo3!=""){		
		$mail->AddAddress($txtTo3, "");
	}
	if($txtTo4!=""){		
		$mail->AddAddress($txtTo4, "");
	}
	if($txtTo5!=""){		
		$mail->AddAddress($txtTo5, "");
	}
		if($txtTo6!=""){		
		$mail->AddAddress($txtTo6, "");
	}
	if($txtCC!=""){		
		$mail->AddAddress($txtCC, "");
	}

	//สำหรับทดสอบ
	//$mail->AddAddress("test_suzuki@my4ib.com", $Name." ".$Lastname);
	if($mail->Send()){
		echo '<div class="green_msg" align="center">';
		echo "ส่งเมลเรียบร้อยแล้ว";
		echo "</div>";
	}	
//**************************************************************************************
    $mailc = new PHPMailer();
	$mailc->CharSet = "utf-8";
    $mailc->IsSMTP();
    $mailc->SMTPDebug = 0;
    $mailc->SMTPAuth = false;
    $mailc->Host = _MAIL_MY4IB; // SMTP server
   // $mailc->Port = 25; // พอร์ท
    //$mailc->Username = "prakunpai@my4ib.com"; // account SMTP
    //$mailc->Password = "pra12641"; // รหัสผ่าน SMTP


//humen@my4ib
//12345

    $mailc->SetFrom("prakunpai@my4ib.com", "prakunpai@my4ib.com");
	$txtdata_form_c = stripcslashes($_POST['txtdata_form_s']);
	$body_c = $txtdata_form_c;
	$mailc->MsgHTML($body_c);	
	$mailc->AddAddress($txtTo4, "");
	$mailc->AddAddress("montree_r@my4ib.com");
	
		if($mailc->Send()){
		echo '<div class="green_msg" align="center">';
		echo "ส่งเมลเรียบร้อยแล้ว";
		echo "</div>";
	}	
	
	?>
    
</div>