<?php
include "../pages/check-ses.php";
include "../../inc/connectdbs.pdo.php";
//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
require("../email/PHPMailer/PHPMailerAutoload.php");  // เรียกไฟล์ class.phpmailer.php

$IDDATA = $_POST['OQ'];
$email = $_POST['email'];
$email2 = $_POST['email2'];
$mobile = $_POST['mobile'];
$mobile2 = $_POST['mobile2'];
$home = $_POST['home'];
$home2 = $_POST['home2'];
$fax = $_POST['fax'];
$send_add = $_POST['send_add'];

if($_POST['car_regis_select'] == 'T')
{
	$car_regis = 'ป้ายแดง';
}
else
{
	$car_regis = $_POST['renew_car_regis'];
}

//$car_regis = $_POST['renew_car_regis'];
$regis_pro = $_POST['car_regis_pro'];
$comment = $_POST['comment'];
$add = $_POST['add'];
$group = $_POST['group'];
$town = $_POST['town'];
$lane = $_POST['lane'];
$road = $_POST['road'];
$province = $_POST['province'];
$amphur = $_POST['amphur'];
$tumbon = $_POST['tumbon'];
$postal = $_POST['postal'];
$readd = $_POST['Aadd'] . "|" . $_POST['Agroup'] . "|" . $_POST['Atown'] . "|" . $_POST['Alane'] . "|" . $_POST['Aroad'] . "|" . $_POST['Aprovince'] . "|" . $_POST['Aamphur'] . "|" . $_POST['Atumbon'] . "|" . $_POST['Apostal'];
$groupS = $_POST['dgroup'];
$goodS = $_POST['dgood'];
$showgood = $_POST['showgood'];
$showgroup = $_POST['showgroup'];

$start_date_renew = $_POST["start_date_renew"]; // วันที่คุ้มครอง												
$start_date_renew_dd = substr($start_date_renew,0,2);
$start_date_renew_mm = substr($start_date_renew,3,2);
$start_date_renew_yy = substr($start_date_renew,6,4);
$start_date_renew = $start_date_renew_yy."-".$start_date_renew_mm."-".$start_date_renew_dd;

if($_POST['SRate_ReCheck'] != '')
{
	$type = $_POST['SRate_ReCheck'];
}
else
{
	$type = $_POST['type'];
}



$bill_pay = $_POST['bill_pay']; // ประเภทการชำระ
$pay_amount = $_POST['pay_amount']; // งวดชำระ

if($pay_amount != ' A1' && $pay_amount != ' A2')
{
	$text_pay = $_POST['text_payAA']; // รายละเอียดการผ่อน
}

$doc_type_select = $_POST['doc_type_select'];

$head_follow = $_POST['head_follow'];
$service = $_POST['service'];
$costS = $_POST['tun']; // ทุน
$com = str_replace( ',', '',$_POST['com']); // คอมมิชชั่น
$service_change = str_replace( ',', '',$_POST['dis_sv']); // service change
$actS = str_replace( ',', '',$_POST['act']); // พรบ
$netactS = str_replace( ',', '',$_POST['netact']); // ลูกค้าชำระ
$netS = str_replace( ',', '',$_POST['net']); // เบี้ยรวม
$snet = str_replace( ',', '',$_POST['snet']); // เบี้ยนำส่ง

if($_POST['dis_count_add'] == '' || $_POST['dis_count_add'] == '0' || $_POST['dis_count_add'] == 'NAN')
{
	$renew_discount_amt = '0.00'; // ส่วนลดเพิ่มเติม
}
else
{
	$renew_discount_amt = str_replace( ',', '',$_POST['dis_count_add']); // ส่วนลดเพิ่มเติม
}


$detailcost = $costS.'|'.$type.'|ไม่ระบุผู้ขับขี่|'.'0'.'|'.$goodS.'|'.$showgood.'|'.$renew_discount_amt.'|'.$showgroup.'|'.$netactS.'|'.$actS.'|'.$netS.'|'.$goodS.'|'.$service.'|'.$com.'|'.$snet.'|'.$service_change;
$new_dateAlert = date("Y-m-d H:i:s", mktime(date("H")+0, date("i")+0, date("s")+0, date("m")+0  , date("d")+7, date("Y")+0));

$SqlUpdate = "UPDATE insuree SET 
									shippingaddress = '" . $readd . "',
                                    insuree.add     = '" . $add . "',
                                    insuree.group   = '" . $group . "',
                                    town            = '" . $town . "',
                                    lane            = '" . $lane . "',
                                    road            = '" . $road . "',
                                    tumbon          = '" . $tumbon . "',
                                    amphur          = '" . $amphur . "',
                                    province        = '" . $province . "',
                                    postal          = '" . $postal . "',
									SendAdd        = '" . $send_add . "',
                                    tel_mobi        = '" . $mobile . "',
									tel_mobi_2        = '" . $mobile2 . "',
                                    tel_home        = '" . $home . "',
									tel_home2        = '" . $home2 . "',
                                    email           = '" . $email . "',
									email2           = '" . $email2 . "',
                                    title           = '" . $_POST['title'] . "',
                                    name           = '" . $_POST['name'] . "',
                                    last           = '" . $_POST['last'] . "',
                                    fax             = '" . $fax . "'                                  
                 WHERE id_data = '" . $IDDATA . "'";
$SqlUpdateQ = mysql_query($SqlUpdate) or die("Error Query " . $SqlUpdate . "");

$sql = "UPDATE URenew SET 
						renew_doc_type = '$doc_type_select',
						renew_cost = '$costS',
						renew_com = '$com',
						renew_Service = '$service',
						renew_Service_change = '$service_change',
						renew_discount_amt = '$renew_discount_amt',
						renew_sendpre = '$snet',
						renew_act = '$actS',
						renew_cuspay = '$netactS',
						renew_net='$netS',
						renew_pay_type='$bill_pay',
						renew_pay_amount='$pay_amount',
						renew_text_pay='$text_pay',
                        renew_car_regis      = '" . $car_regis . "',
                        renew_regis_pro      = '" . $regis_pro . "',
                        renew_discount ='" . $groupS . "|" . $goodS . "',
                        renew_dateUpDealer='" . date('Y-m-d H:m:i') . "'
               WHERE renew_id = '$IDDATA'";
$sqlQ = mysql_query($sql) or die("Error Query " . $sql . "");

$sqlData = "UPDATE detail SET car_regis = '{$car_regis}' WHERE id_data = '{$IDDATA}'";
$queData = mysql_query($sqlData) or die("Error Query " . $sqlData . "");

$sql_INS = "INSERT INTO detail_renew (
									`id_detail`, 
									`id_data`, 
									`start_date_renew`, 
									`status`, 
									`detailtext`, 
									`detailcost`, 
									`detail_doc_type`, 
									`detailpaytype`, 
									`detailpayamount`, 
									`date_alert`, 
									`date_detail`, 
									`userdetail`, 
									`timecall`, 
									`lastrenew`
								) VALUES (
									NULL,
									'$IDDATA',
									'$start_date_renew',
									'$head_follow',
									'dealer mitsubishi เสนอราคา',
									'$detailcost',
									'$doc_type_select',
									'$bill_pay',
									'$pay_amount',
									'$new_dateAlert',
									NOW(),
									'DEALER',
									NOW(),
									'1') ";
$sql_INSA = mysql_query($sql_INS) or die("Error Query " . $sql_INS . "");

if($head_follow == 'E')
{
	$mail = new PHPMailer();  // กำหนดตัวแปร  $mail
	$mail->CharSet = 'UTF-8';                                                                
	$mail->From = "system@my4ib.com";
	$mail->FromName = "แจ้งต่ออายุประกันภัย (ปิดงาน)"; // กำหนดชื่อผู้ส่ง
	$mail->IsSMTP();
	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = true;
	$mail->Host = _MAIL_MY4IB; // SMTP server
	$mail->Port = 25; // พอร์ท
	// $mail->Username = "system@my4ib.com"; // account SMTP
	// $mail->Password = "12345"; // รหัสผ่าน SMTP
	$mail->Username = "prakunpai@my4ib.com"; // account SMTP
    $mail->Password = "pra12641"; // รหัสผ่าน SMTP
	 $mail->Subject = "มีการแจ้งต่ออายุประกันภัย (ปิดงาน) ".$_SESSION["strUser"]." เลขรับแจ้ง ".$IDDATA; // กำหนดหัวข้ออีเมล์
	$mail->Body = "แจ้งต่ออายุ เลขรับแจ้ง ".$IDDATA;
	// $mail->AddAddress('wanvisa_k@my4ib.com', "");
	// $mail->AddAddress('piyaphon@my4ib.com', "");
	$mail->AddAddress('supinya@my4ib.com', "");
	$mail->IsHTML(false); 
	
	$mail->Send();
}

$smx = "SELECT MAX(id_detail) as max FROM detail_renew";
$rsmx = mysql_query($smx );
$fsmx = mysql_fetch_array($rsmx);
$int_ref = $fsmx['max'];

/////////// ACCOUNT ///////////////////////////////////	
$hostname_conn = "localhost";
$username_conn = _USERNAME_FOUR; // fourinsured_new
$password_conn = _PASS_FOUR; // kalanchoe
$database_conn = _DB_FOUR_ACCOUNT;
$obj_connect = mysql_connect( $hostname_conn , $username_conn , $password_conn );
mysql_select_db($database_conn,$obj_connect);
mysql_set_charset('utf8');

$sql_int="INSERT INTO payment_installment (int_iddata,int_term,int_date,int_amount,int_status,int_user,int_ref) 
VALUES ('".$IDDATA."','1','$new_dateAlert','$netactS','N','DEALER','RENEW|".$int_ref."')";
$query_int=mysql_query($sql_int,$obj_connect);

if($sqlQ)
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
