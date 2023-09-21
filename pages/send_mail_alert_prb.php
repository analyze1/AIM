<?php


require("email/PHPMailer/PHPMailerAutoload.php");  // เรียกไฟล์ class.phpmailer.php
if($_SESSION['strUser']!='admin')
{

$customer_sql="SELECT * FROM tb_customer WHERE user = '".$_SESSION['strUser']."'";
$customer_query=PDO_CONNECTION::fourinsure_mitsu()->query($customer_sql);
$customer_array=$customer_query->fetch(2);
$z_act_sql="SELECT act_no FROM z_act WHERE act_status = '1' AND act_use = '".$_SESSION['strUser']."'";
$z_act_query=PDO_CONNECTION::fourinsure_mitsu()->query($z_act_sql);
$z_act_num=$z_act_query->rowCount();
$datetime=date('Y-m-d H:i:s');
$datearray=explode(' ',$datetime);
$date=$datearray[0];
$check_act_sql="SELECT * FROM z_act_check_mail WHERE DATE(send_date) = '".$date."' AND dealer = '".$_SESSION['strUser']."' AND stock_clearance = '".$z_act_num."'";
$check_act_query=PDO_CONNECTION::fourinsure_mitsu()->query($check_act_sql);
$check_act_array=$check_act_query->fetch(2);
if($z_act_num<=10 && empty($check_act_array) && $customer_array['saka']=='113')
{
	$mail = new PHPMailer();  // กำหนดตัวแปร  $mail
	$mail->CharSet = 'UTF-8';                                                                
    $mail->From = "admin@my4ib.com";
    $mail->FromName = "เตือนพรบSUZUKIป้ายแดงใกล้หมดแล้ว!!"; // กำหนดชื่อผู้ส่ง
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = false;
    $mail->Host = _MAIL_MY4IB ; // "localhost"; // SMTP servermail.my4ib.com
    $mail->Port = 25; // พอร์ท
	$mail->Subject = "แจ้งเตือนพรบใกล้หมดสต๊อก ให้เบิกพรบดิลเลอร์ ".$customer_array['user'] ." ".$customer_array['title_sub'].$customer_array['sub']." โดยด่วน!!"; // กำหนดหัวข้ออีเมล์
	$mail->AddAddress('marketing_support6@my4ib.com', "");
	$mail->AddAddress('marketing_support2@my4ib.com', "");
	$mail->AddAddress('wisaruth@my4ib.com', "");
	$bodymail="";
	$bodymail.="รหัสดิลเลอร์ ".$_SESSION['strUser']."<br>";
	$bodymail.="ตรวจเช็คล่าสุดวันที่".date('d/m/Y')." เวลา".date('h:i:s')."<br>";
	$bodymail.="สต็อกพรบเหลือ ".$z_act_num." ฉบับ";
    $mail->Body = $bodymail; // กำหนดเนื้อหาอีเมล์
    $mail->IsHTML(true); 
    // if($mail->Send())
	// {
	// 	$insert_sql="INSERT INTO z_act_check_mail (send_date,dealer,stock_clearance) VALUES ('".$datetime."','".$_SESSION['strUser']."','".$z_act_num."')";
	// 	$insert_query=PDO_CONNECTION::fourinsure_mitsu()->prepare($insert_sql)->execute();
	// }
}
}
?>
