<?php
include "../pages/check-ses.php";
include "../../inc/connectdbs.pdo.php";
//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
require("../email/PHPMailer/PHPMailerAutoload.php");  // เรียกไฟล์ class.phpmailer.php

$data_id = $_POST['data_id'];

$sql_detailRenew = "SELECT id_data,detailcost FROM detail_renew where id_detail = '{$data_id}'";
$qbj_detailRenew = mysql_query($sql_detailRenew );
$row_detailRenew = mysql_fetch_array($qbj_detailRenew);
$IDDATA = $row_detailRenew['id_data'];
$detailcost_EX = explode("|",$row_detailRenew['detailcost']);

$new_dateAlert = date("Y-m-d H:i:s", mktime(date("H")+0, date("i")+0, date("s")+0, date("m")+0  , date("d")+7, date("Y")+0));
$netactS = $detailcost_EX[8];


// if($IDDATA != '')
// {
// 	$mail = new PHPMailer();  // กำหนดตัวแปร  $mail
// 	$mail->CharSet = 'UTF-8';                                                                
// 	$mail->From = "system@my4ib.com";
// 	$mail->FromName = "แจ้งต่ออายุประกันภัย (ปิดงาน)"; // กำหนดชื่อผู้ส่ง
// 	$mail->IsSMTP();
// 	$mail->SMTPDebug = 0;
// 	$mail->SMTPAuth = false;
// 	$mail->Host = _MAIL_MY4IB; // SMTP server
// 	$mail->Port = 25; // พอร์ท
// 	$mail->Username = "prakunpai@my4ib.com"; // account SMTP
//     $mail->Password = "pra12641"; // รหัสผ่าน SMTP
    
// 	// $mail->Username = "system@my4ib.com"; // account SMTP system@my4ib.com
// 	// $mail->Password = "sys10820"; // รหัสผ่าน SMTP 12345
// 	$mail->Subject = "Suzuki มีการแจ้งต่ออายุประกันภัย (ปิดงาน) ".$_SESSION["strUser"]." เลขรับแจ้ง ".$IDDATA; // กำหนดหัวข้ออีเมล์
// 	$mail->Body = "Suzuki AJ_UE  แจ้งต่ออายุ เลขรับแจ้ง ".$IDDATA;
// 	// $mail->AddAddress('wanvisa_k@my4ib.com', "");
// 	// $mail->AddAddress('piyaphon@my4ib.com', "");
// 	$mail->AddAddress('supinya@my4ib.com', "");
// 	$mail->IsHTML(false); 
		
// 	$mail->Send();
// }

$sql_insDetailRenew = "INSERT INTO detail_renew(
													id_data,
													start_date_renew,
													status,
													detailtext,
													detailcost,
													detail_doc_type,
													detailpaytype,
													detailpayamount,
													date_alert,
													date_detail,
													userdetail,
													timecall,
													lastrenew
												)
												SELECT 
													id_data,
													start_date_renew,
													status,
													detailtext,
													detailcost,
													detail_doc_type,
													detailpaytype,
													detailpayamount,
													date_alert,
													date_detail,
													userdetail,
													timecall,
													lastrenew 
												from detail_renew  
												where id_detail = '".$data_id."'";
$sqlQ = mysql_query($sql_insDetailRenew);

$smx = "SELECT MAX(id_detail) as max FROM detail_renew";
$rsmx = mysql_query($smx );
$fsmx = mysql_fetch_array($rsmx);
$int_ref = $fsmx['max'];

$sql_upDetailRenew = "UPDATE detail_renew SET status = 'E', date_alert = '{$new_dateAlert}', date_detail = NOW() , timecall = NOW() WHERE id_detail = '{$int_ref}'";
$Obj_upDetailRenew= mysql_query($sql_upDetailRenew);

/////////// ACCOUNT ///////////////////////////////////	
$hostname_conn = "localhost";
$username_conn = _USERNAME_FOUR; // fourinsured_new
$password_conn = _PASS_FOUR; // kalanchoe
$database_conn = _DB_FOUR_ACCOUNT; //fourinsure_account
$obj_connect = mysql_connect( $hostname_conn , $username_conn , $password_conn );
mysql_select_db($database_conn,$obj_connect);
mysql_set_charset('utf8');

$sql_int="INSERT INTO payment_installment (int_iddata,int_term,int_date,int_amount,int_status,int_user,int_ref) 
VALUES ('".$IDDATA."','1','$new_dateAlert','$netactS','N','DEALER','RENEW|".$int_ref."')";
$query_int=mysql_query($sql_int,$obj_connect);

if($sqlQ)
{
	$returnedArray['status'] = true;
	$returnedArray['msg'] = "บันทึกข้อมูลเรียบร้อยแล้ว!";
}
else
{
	$returnedArray['status'] = false;
	$returnedArray['msg'] = "บันทึกข้อมูลผิดพลาด !!!!!!!";
}	

echo json_encode($returnedArray);

mysql_close();
?>
