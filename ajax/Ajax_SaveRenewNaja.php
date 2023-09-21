<?php
require("../pages/check-ses.php");
require("../inc/connectdbs.pdo.php");
require("../services/InsuranceRenewal/InsuranceRenewal.model.php");
require("../services/InsuranceRenewal/InsuranceRenewal.service.php");
require("../services/LineNoti.service.php");

$_contextMitsu = PDO_CONNECTION::fourinsure_mitsu();
$_contextFour = PDO_CONNECTION::fourinsure_insured();
$_contextAccount = PDO_CONNECTION::fourinsure_account();

$_tokenDevelop = 'i2rADrAk83bWBcO9YawX1bW7JReAbi5dEdSyxc7lU60';// devnoti 
$_serviceRenew = new InsuranceRenewalService($_contextMitsu,$_contextFour);

$_userLogin = $_SESSION['strUser'];										//ชื่อผู้ใช้งานเข้าระบบ ไม่ใช่ $_loginType ที่เป็น user รหัส ดิลเลอร์ ก็ชื่อ DEALER และ user admin ก็ admin
$_iddata = $_POST['iddata'];											//เลขรับแจ้ง
$_act = $_POST['act'];													//พรบ เบี้ยรวม
$_dgood = $_POST['dgood'];												//ส่วนลดประวัติดี
$_dgroup = $_POST['dgroup'];											//ส่วนลดกลุ่ม เปอร์เซ็น
$_disdriver = str_replace(",", "", $_POST['disdriver']);				//จำนวนคน เปอร์เซ็น
$_driver = $_POST['driver'];											//จำนวนผู้ขับขี่ ตัวอย่าง value = ผู้ขับขี่ 1 คน อายุ 18 ถึง 24 ปี
$_extra = str_replace(",", "", $_POST['extra']);						//ส่วนลดพิเศษ
$_main = $_POST['main'];												//สถานะติดตามงาน
$_preset = str_replace(",", "", $_POST['pre-set']);						//กรมธนนม์เบี้ยสุทธิ์
$_showgood = str_replace(",", "", $_POST['showgood']);					//ส่วนลดประวัติดี จำนวนเงิน
$_showgroup = str_replace(",", "", $_POST['showgroup']);				//ส่วนลดกลุ่ม จำนวนเงิน
$_snet = str_replace(",", "", $_POST['temp_snet']);						//เบี้ยชำระ (sing แก้)
$_textdetail = $_POST['textdetail'];									//รายละเอียดติดตามงาน
$_totaldis = str_replace(",", "", $_POST['totaldis']);					//รวมส่วนลด
$_tun = str_replace(",", "", $_POST['tun']);							//ทุนประกันภัย
$_type = $_POST['type'];												//ไม่มีรับค่า POST มา ไม่รู้ว่ามันคือตัวอะไรกันแน่
$_open = $_POST['opentime'];											//วันเวลา เข้าไปดูตัวงานต่ออายุ ปี 2 ที่จะทำการติดตาม
$_service = $_POST['service'];											//บริการ 1 = ซ่อม ห้าง 2 = ซ่อมอู่
$_compid = $_POST['compid'];											//ชื่อย่อบริษัทประกัน
$_doctype = $_POST['doctype'];											//ประเภทประกันภัย 1 2 2+ 3 เป็นต้น
$_sprodgroup = $_POST['sprodgroup'];									//กลุ่มผลิตภัณฑ์ จำพวก U07 U11 U12 อื่นๆ
$_protect_type = $_POST['protect_type'];								//รหัส package ความคุ้มครอง		
$_qidcost = $_POST['qidcost'];											//รหัส package เบี้ย
$_detail_follow = $_POST['detail_follow'];								//สถานะติดตามย่อย
$_other_detail_follow = $_POST['other_detail_follow'];					//สถานะติดตามย่อย เลือกแบบอื่นๆ จะมี เหตุผลไม่สนใจ
$_datefol = thaiDateSAVE($_POST['datefol']);							//วันที่ติดตามงาน
$_premiumTotal = str_replace(",", "", $_POST['pre-all']);				//กรมธรรม์ เบี้ยรวม
$_payNumIns = $_POST['stype'];											//จำนวนงวดผ่อนชำระ 1 งวด 2 3 4 เป็นต้น
$_userLoginDetail = $_SESSION['idtb_login'];							//มาจาก Session tb_login ผู้ใช้งานย่อย มาจาก tb_customer
$_chkFirstIns = isset($_POST['chkcall']) ? true : false;				//งวดแรกที่เริ่ม 3000 บ.
$_vatPointer = 1;														//หัก ณ ที่จ่าย 1 %
$_vatTotal = $_POST['showOnepercent'];									//ยอดหัก ณ ที่จ่าย 1 %
if ($_main == 'N' || $_main == 'E') {
	$_datefol = thaiDateSAVE($_POST['datefol2']);
}

//ล็อกอิน ที่ไม่ใช่ admin ฟิต เป็น DEALER
$_loginType = $_userLogin;

function thaiDateSAVE($datetime)
{
	list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($d, $m, $Y) = explode('/', $date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.

	switch ($m) {
		case "01":
			$m = "01";
			break;
		case "02":
			$m = "02";
			break;
		case "03":
			$m = "03";
			break;
		case "04":
			$m = "04";
			break;
		case "05":
			$m = "05";
			break;
		case "06":
			$m = "06";
			break;
		case "07":
			$m = "07";
			break;
		case "08":
			$m = "08";
			break;
		case "09":
			$m = "09";
			break;
		case "10":
			$m = "10";
			break;
		case "11":
			$m = "11";
			break;
		case "12":
			$m = "12";
			break;
	}
	return $Y . '-' . $m . '-' . $d;
}

$response = array();

//ไม่ใช่เสนอราคา  เป็น สถานะติดตาม อื่นๆ ดึงข้อมูลเสนอก่อนหน้านี้มาใส่
if ($_main != 'S') {
	$res = $_serviceRenew->getFollowUpPrevious($_iddata, $_userLogin);
	if ($res->Status != 200) 
	{
		$response['MessageDesc'] = "$res->MessageDesc\nStatus : $res->Status";
		$response['Status'] = $res->Status;

		$textContentLineNoti = 'ระบบดิลเลอร์ติดตามต่ออายุ Mitsubishi'."\r\n";
		$textContentLineNoti .= 'เลขรับแจ้ง : '.$_iddata."\r\n";
		$textContentLineNoti .= 'Userlogin : '.$_userLogin."\r\n";
		$textContentLineNoti .= 'Message : '.$res->MessageDesc."\r\n";
		$textContentLineNoti .= 'Status : '.$res->Status;
		LineNotificationControl::linenotify($_tokenDevelop,$textContentLineNoti);
		echo json_encode($response);
		exit();
	}

	$query3 = "UPDATE detail_renew SET detail_renew.lastrenew = :LastRenew WHERE id_data = :IdData ";
	$objQuery3 = $_contextMitsu->prepare($query3)->execute(
		array(
			"LastRenew" => 0,
			"IdData" => $_iddata
		)
	);

	$query2 = "UPDATE `data` SET renewuse = :RenewUse WHERE id_data = :IdData ";
	$objQuery2 = $_contextMitsu->prepare($query2)->execute(
		array(
			"RenewUse" => $_loginType,
			"IdData" => $_iddata
		)
	);

	$strSQL = "INSERT INTO  detail_renew (`id_data`, `status`, `detailtext`, `detailcost`, `date_alert`, `date_detail`, `userdetail`, `timecall`, `lastrenew`, `doc_type`, `detail_doc_type`, `renew_comp`, `renew_product`, `renew_ptype`,`renew_id_cost`, `detail_follow`,`other_detail_follow`,`save_user`) 
	VALUES (:IdData, :FollowStatus, :TextDetail, :CostDetail, :DateAlert, :DateDetail, :UserFollow, :TimeCall, :LastRenew, :DocType, :DetailDocType, :RenewComp, :RenewProduct, :RenewProductType, :RenewIdCost, :DetailFollow, :OtherDetailFollow, :UserSave)";
	$result = $_contextMitsu->prepare($strSQL)->execute(
		array(
			"IdData" => $_iddata,
			"FollowStatus" => $_main,
			"TextDetail" => $_textdetail,
			"CostDetail" => $res->ProductDetail,
			"DateAlert" => $_datefol,
			"DateDetail" => $_open,
			"UserFollow" => $_loginType,
			"TimeCall" => date('Y-m-d H:i:s'),
			"LastRenew" => 1,
			"DocType" => $res->InsuranceType,
			"DetailDocType" => $res->InsuranceType,
			"RenewComp" => $res->InsuranceComp,
			"RenewProduct" => $res->ProductGroup,
			"RenewProductType" => $res->IdProductType,
			"RenewIdCost" => $res->IdProduct,
			"DetailFollow" => $_detail_follow,
			"OtherDetailFollow" => $_other_detail_follow,
			"UserSave" => $_userLoginDetail
		)
	);

	$textContentLineNoti = 'ระบบดิลเลอร์ติดตามต่ออายุ Mitsubishi'."\r\n";
	$textContentLineNoti .= 'เลขรับแจ้ง : '.$_iddata."\r\n";
	$textContentLineNoti .= 'สถานะติดตาม : '.$_main."\r\n";
	$textContentLineNoti .= 'detailcost : '.$res->ProductDetail."\r\n";
	$textContentLineNoti .= 'renew_ptype : '.$res->IdProductType."\r\n";
	$textContentLineNoti .= 'renew_id_cost : '.$res->IdProduct."\r\n";
	$textContentLineNoti .= 'UserLogin : '.$_userLogin;

}
//ถ้าเป็นเสนอราคา จะใช้ข้อมูลที่เสนอราคาที่เลือกมาใส่
else 
{
	$query3 = "UPDATE detail_renew SET detail_renew.lastrenew = :LastRenew WHERE id_data = :IdData ";
	$objQuery3 = $_contextMitsu->prepare($query3)->execute(
		array(
			"LastRenew" => 0,
			"IdData" => $_iddata
		)
	);

	$query2 = "UPDATE `data` SET renewuse = :RenewUse WHERE id_data = :IdData ";
	$objQuery2 = $_contextMitsu->prepare($query2)->execute(
		array(
			"RenewUse" => $_loginType,
			"IdData" => $_iddata
		)
	);

	$detailCost = $_tun . '|' . $_type . '|' . $_driver . '|' . $_disdriver . '|' . $_dgood . '|' . $_showgood . '|' . $_extra . '|' . $_showgroup . '|' . $_snet . '|' . $_act . '|' . $_preset . '|' . $_dgroup . '|' . $_service . '|' . $_premiumTotal;

	$strSQL = "INSERT INTO  detail_renew (`id_data`, `status`, `detailtext`, `detailcost`, `date_alert`, `date_detail`, `userdetail`, `timecall`, `lastrenew`, `doc_type`, `detail_doc_type`, `renew_comp`, `renew_product`, `renew_ptype`,`renew_id_cost`, `detail_follow`,`other_detail_follow`,`save_user`,`vat_pointer`,`vat_total` ) 
	VALUES (:IdData, :FollowStatus, :TextDetail, :CostDetail, :DateAlert, :DateDetail, :UserFollow, :TimeCall, :LastRenew, :DocType, :DetailDocType, :RenewComp, :RenewProduct, :RenewProductType, :RenewIdCost, :DetailFollow, :OtherDetailFollow, :UserSave, :VatPointer, :VatTotal)";
	$result = $_contextMitsu->prepare($strSQL)->execute(
		array(
			"IdData" => $_iddata,
			"FollowStatus" => $_main,
			"TextDetail" => $_textdetail,
			"CostDetail" => $detailCost,
			"DateAlert" => $_datefol,
			"DateDetail" => $_open,
			"UserFollow" => $_loginType,
			"TimeCall" => date('Y-m-d H:i:s'),
			"LastRenew" => 1,
			"DocType" => $_doctype,
			"DetailDocType" => $_doctype,
			"RenewComp" => $_compid,
			"RenewProduct" => $_sprodgroup,
			"RenewProductType" => $_protect_type,
			"RenewIdCost" => $_qidcost,
			"DetailFollow" => $_detail_follow,
			"OtherDetailFollow" => $_other_detail_follow,
			"UserSave" => $_userLoginDetail,
			"VatPointer" => $_vatPointer,
			"VatTotal" => $_vatTotal
		)
	);

	$textContentLineNoti = 'ระบบดิลเลอร์ติดตามต่ออายุ Mitsubishi'."\r\n";
	$textContentLineNoti .= 'เลขรับแจ้ง : '.$_iddata."\r\n";
	$textContentLineNoti .= 'สถานะติดตาม : '.$_main."\r\n";
	$textContentLineNoti .= 'detailcost : '.$detailCost."\r\n";
	$textContentLineNoti .= 'renew_ptype : '.$_protect_type."\r\n";
	$textContentLineNoti .= 'renew_id_cost : '.$_qidcost."\r\n";
	$textContentLineNoti .= 'UserLogin : '.$_userLogin;

}

//สร้างใบผ่อน ชำระเงิน กรณี ทำเสนอราคา
if ($_main == 'S') {
	$smx = "SELECT id_detail AS `max` FROM detail_renew WHERE id_data = '$_iddata' ORDER BY id_detail DESC LIMIT 0,1 ";
	$rsmx = $_contextMitsu->query($smx);
	$fsmx = $rsmx->fetch(2);
	$int_ref = $fsmx['max'];
	
	$a = 1; //นับงวด
	$b = 0;	//นับเดือน
	while ($a <= $_payNumIns)
	{
		$todaymonth = date('Y-m-d', strtotime('+' . $b . ' month'));
		$amount_pay = 0;
		if($_chkFirstIns == true)
		{
			if($a == 1)
			{
				$amount_pay = 3000;
			}
			else
			{
				$amount_pay = ($_snet - 3000) / ($_payNumIns - 1);
			}
		}
		else
		{
			$amount_pay = $_snet / $_payNumIns;
		}

		$sql_int = "INSERT INTO payment_installment (int_iddata,int_term,int_date,int_amount,int_status,int_user,int_ref) 
		VALUES (?,?,?,?,?,?,?)";
		$query_int = $_contextAccount->prepare($sql_int)->execute(
			array(
				$_iddata,
				$a,
				$todaymonth,
				$amount_pay,
				'N',
				$_userLogin,
				"RENEW|$int_ref"
			)
		);
		$a++;
		$b++;
	}
}

if ($result == true) {
	$response['MessageDesc'] = 'บันทึกสำเร็จ';
	$response['Status'] = 200;
	LineNotificationControl::linenotify($_tokenDevelop,$textContentLineNoti);
	echo json_encode($response);
	exit();
} else {
	$response['MessageDesc'] = 'บันทึกไม่สำเร็จ';
	$response['Status'] = 500;

	$textContentLineNoti = 'ระบบดิลเลอร์ติดตามต่ออายุ Mitsubishi'."\r\n";
	$textContentLineNoti .= 'เลขรับแจ้ง : '.$_iddata."\r\n";
	$textContentLineNoti .= 'Userlogin : '.$_userLogin."\r\n";
	$textContentLineNoti .= 'Message : บันทึกไม่สำเร็จ'."\r\n";
	$textContentLineNoti .= 'Status : 500';
	LineNotificationControl::linenotify($_tokenDevelop,$textContentLineNoti);
	echo json_encode($response);
	exit();
}