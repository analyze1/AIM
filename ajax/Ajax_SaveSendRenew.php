<?php
include "../pages/check-ses.php";
//include "../inc/checksession.inc.php";
include "../inc/connectdbs.inc.php"; 
//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
require("../email/PHPMailer/PHPMailerAutoload.php");  // เรียกไฟล์ class.phpmailer.php
$sesslogin = $_SESSION["strUser"];
function thaiDateSAVE($datetime) {
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
return $Y.'-'.$m.'-'.$d;
} 

$iddata = $_POST['iddata'];
$act = $_POST['act'];

$dgood = $_POST['dgood'];
$dgroup = $_POST['dgroup'];
$disdriver = str_replace(",","",$_POST['disdriver']);
$driver = $_POST['driver'];
$extra = str_replace(",","",$_POST['extra']);
$main = $_POST['main'];
$preset = str_replace(",","",$_POST['pre-set']);
$showgood = str_replace(",","",$_POST['showgood']);
$showgroup = str_replace(",","",$_POST['showgroup']);
$snet = str_replace(",","",$_POST['temp_snet']);//sing แก้
$textdetail = $_POST['textdetail'];
$totaldis = str_replace(",","",$_POST['totaldis']);
$tun = str_replace(",","",$_POST['tun']);
$type = $_POST['type'];
$open = $_POST['opentime'];
$login = $_POST['4_login'];
$service = $_POST['service'];
$add_on = $_POST['robbery'];
$doc_type = $_POST['doctype'];

$datefol = thaiDateSAVE($_POST['datefol2']);
//if($main == 'N' || $main == 'E') {
//	$datefol = thaiDateSAVE($_POST['datefol2']);
//}
mysql_select_db($db1,$cndb1);

$queryE = "SELECT * FROM detail_renew  WHERE id_data='".$_POST['iddata']."' AND status = 'S' AND lastrenew = '1' Order by id_detail desc ";
$objQueryE = mysql_query($queryE,$cndb1) or die ("Error Query [".$queryE."]");
$arrE = mysql_fetch_array($objQueryE);
$tdetailcost = $arrE['detailcost'];
        $add_on = $arrE['add_on'];
        $add_on1 = $arrE['add_on1'];
        $doc_type = $arrE['doc_type'];

mysql_select_db($db1,$cndb1);
$query3 = "UPDATE detail_renew SET detail_renew.lastrenew='0' WHERE id_data='".$_POST['iddata']."' ";
$objQuery3 = mysql_query($query3,$cndb1) or die ("Error Query [".$query3."]");

mysql_select_db($db1,$cndb1);
$query2 = "UPDATE data SET renewuse='$login' WHERE id_data='".$_POST['iddata']."' ";
$objQuery2 = mysql_query($query2,$cndb1) or die ("Error Query [".$query2."]");

	$strSQL = "INSERT INTO  detail_renew (`id_detail`, `id_data`, `status`, `detailtext`, `detailcost`, `date_alert`, `date_detail`, `userdetail`, `timecall`, `lastrenew`,`add_on`,`doc_type`,`add_on1`) VALUES
	(NULL, '$iddata', '$main', '$textdetail', '$tdetailcost','$datefol','$open','DEALER',NOW(),'1','$add_on','$doc_type','$add_on1')"; 		
	mysql_select_db($db1,$cndb1);
	$result = mysql_query( $strSQL ,$cndb1);

	$smx = "SELECT MAX(id_detail) as max FROM detail_renew";
	mysql_select_db($db1,$cndb1);
	$rsmx = mysql_query($smx ,$cndb1);
	$fsmx = mysql_fetch_array($rsmx);
	$int_ref = $fsmx['max'];

mysql_select_db($db1,$cndb1);
$query = "SELECT data.id_data,data.login,insuree.*,detail.br_car,detail.mo_car,data.end_date,detail.car_regis,detail.car_regis_pro
 ,detail.car_body,detail.n_motor,protect.costCost,tb_cost.cost,detail.price_total,data.renewuse
 FROM data "; 
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
$query .= "INNER JOIN tb_cost ON (protect.costCost = tb_cost.id) ";
$query .= "INNER JOIN insuree ON (data.id_data = insuree.id_data) ";
$query .= "INNER JOIN req ON (data.id_data = req.id_data) ";
$query .= " WHERE data.id_data = '$iddata'";
$query .= "ORDER BY data.end_date ASC LIMIT 0 , 1";

$objQuery = mysql_query($query,$cndb1) or die ("Error Query [".$query."]");
$row = mysql_fetch_array($objQuery);

if($main=="E"){
$textemail = $_SESSION["textemail"];
	$mail = new PHPMailer();  // กำหนดตัวแปร  $mail
	$mail->CharSet = 'UTF-8';                                                                
    $mail->From = "system@my4ib.com";
    $mail->FromName = "แจ้งประกันภัยต่ออายุ"; // กำหนดชื่อผู้ส่ง
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = false;
	$mail->IsHTML(true); 
    $mail->Host = _MAIL_MY4IB; // SMTP server
   // $mail->Port = 25; // พอร์ท
    //$mail->Username = "prakunpai@my4ib.com"; // account SMTP
    //$mail->Password = "pra12641"; // รหัสผ่าน SMTP
    
    // $mail->Username = "system@my4ib.com"; // account SMTP system@my4ib.com
    // $mail->Password = "sys10820"; // รหัสผ่าน SMTP 12345
	//$mail->AddAddress('', "");
	$mail->AddAddress('underwrite@my4ib.com', "");
	// $mail->AddCC("wanvisa_k@my4ib.com", "");
	$mail->AddCC("renew@my4ib.com", "");
	//$mail->AddCC("pattamaporn@my4ib.com", "");
	$mail->AddCC($_SESSION["s_email"], "");
	$mail->Subject = "แจ้งประกันภัยต่ออายุ เลขรับแจ้งเดิม : $iddata"; // กำหนดหัวข้ออีเมล์
    $textbody = "<table width='100%' border='0' cellpadding='0' cellspacing='0>
	<tr>
	<td><div align='right'><strong>เลขที่ต่ออายุ :</strong></div></td><td>".$row['id_data']."</td>
	<td><div align='right'><strong>ดีลเลอร์ :</strong></div></td><td>".$row['login']."</td>
	</tr>
	<tr>
	<td><div align='right'><strong>ชื่อผู้เอาประกันภัย :</strong></div></td><td>".$row['title'].' '.$row['name']."</td>
	<td><div align='right'><strong>นามสกุล :</strong></div></td><td>".$row['last']."</td>
	</tr>
	<tr>
	<td><div align='right'><strong>ยี่ห้อ :</strong></div></td><td>".$_SESSION["BrC"]['name'][$row['br_car']]."</td>
	<td><div align='right'><strong>รุ่น :</strong></div></td><td>".$_SESSION["MoC"]['name'][$row['mo_car']]."</td>
	</tr>
		<tr>
	<td><div align='right'><strong>เลขตัวถัง :</strong></div></td><td>".$row['car_body']."</td>
	<td><div align='right'><strong>เลขเครื่องยนต์ :</strong></div></td><td>".$row['n_motor']."</td>
	</tr>
	<tr>
	<td><div align='right'><strong>ทุนปีที่แล้ว + เพิ่มทุน :</strong></div></td><td>".$row['cost']." + ".$row['price_total']."</td>
	<td><div align='right'><strong>ทุนต่ออายุ :</strong></div></td><td>".number_format($tun,0)."</td>
	</tr>
	<tr>
	<td><div align='right'><strong>ทะเบียน :</strong></div></td><td>".$row['car_regis']."</td>
	<td><div align='right'><strong>จังหวัดทะเบียน :</strong></div></td><td>".$_SESSION["Pro"][$row['car_regis_pro']]."</td>
	</tr>
	</table>
	<table> ";
	if($_POST['commentse1']==1){
	$textbody .= "
	<tr>
	<td><div align='right'><strong>นัดตรวจสภาพรถ :</strong></div></td><td>วันที่ : ".$_POST['checkcar_date'].' เวลา : '.$_POST['checkcar_time'].' ติดต่อ : '.$_POST['contact_name_list'].' เบอร์ : '.$_POST['contact_number']."</td>
	</tr>
	 ";
	}

	if($_POST['commentse2']==2){
	$textbody .= "
	<tr>
	<td><div align='right'><strong>ส่งกรมธรรม์ :</strong></div></td><td>".$_POST['check_1'].' วันที่ : '.$_POST['date_SP'].' ติดต่อ : '.$_POST['contact_name_rec'].' เบอร์ : '.$_POST['contact_numberrec']."</td>
	</tr> ";
	}

	if($_POST['commentse3']==3){
	$textbody .= "
	<tr>
	<td><div align='right'><strong>จ่ายแล้ว :</strong></div></td><td>".$_POST['payin'].' วิธีชำระ : '.$_POST['payment_1'].' แบ่งชำระ : '.$_POST['instance_1'].' วันที่ชำระ : '.$_POST['payment_date'].' ธนาคาร : '.$_POST['bankoperation_1'].' เบอร์ : '.$_POST['contact_number_pay']."</td>
	</tr> ";
	}

	if($_POST['commentse4']==4){
	$textbody .= "
	<tr>
	<td><div align='right'><strong>กำลังทำจ่ายเข้า :</strong></div></td><td>".$_POST['checkpen'].' วิธีชำระ : '.$_POST['payment_2'].' แบ่งชำระ : '.$_POST['instance_2'].' วันที่ชำระ : '.$_POST['payment_in'].' ธนาคาร : '.$_POST['bankoperation_2'].' เบอร์ : '.$_POST['contact_number_pen']."</td>
	</tr> ";
	}

	if($_POST['commentse5']==5){
	$textbody .= "
	<tr>
	<td><div align='right'><strong>ยังไม่จ่าย :</strong></div></td><td>".$_POST['checks'].' : '.$_POST['D_day'].' ติดต่อ : '.$_POST['contact_name_list_3'].' เบอร์โทรศัพท์ : '.$_POST['contact_number_3'].' ธนาคาร : '.$_POST['bankoperation_3'].' เบอร์ : '.$_POST['contact_number_s']."</td>
	</tr> ";
	}

	if($_POST['commentse6']==6){
	$textbody .= "
	<tr>
	<td><div align='right'><strong>อื่นๆ :</strong></div></td><td>".$_POST['other_s']."</td>
	</tr> ";
	}
	
	$textbody .= "
	</table>
	";

	    $mail->Body = $textbody;
   
if(!$mail->Send()) {
    echo $mail->Send();
}

mysql_select_db($db1,$cndb1);
$query3 = "UPDATE data SET renewstatus='$main' WHERE id_data='".$_POST['iddata']."' ";
$objQuery3 = mysql_query($query3,$cndb1) or die ("Error Query [".$query3."]");

}

if($result==true){
echo json_encode('บันทึกสำเร็จ');
}else{
	echo json_encode('บันทึกไม่สำเร็จ');
}

mysql_close();

?>