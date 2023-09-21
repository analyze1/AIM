<?php
	include "../inc/checksession.inc.php";
	include "../inc/connectdbs.inc.php";
?>
<html>
<head>
<title>TEST</title>
</head>
<body>
<?php
function ws_datetime($dt){
	list($date, $time) = split(' ', $dt); // แยกวันที่ กับ เวลาออกจากกัน
	list($H, $i, $s) = split(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($Y, $m, $d) = split('-', $date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.

	switch ($m) {
		case "01": $m = "01";
			break;
		case "02": $m = "02";
			break;
		case "03": $m = "03";
			break;
		case "04": $m = "04";
			break;
		case "05": $m = "05";
			break;
		case "06": $m = "06";
			break;
		case "07": $m = "07";
			break;
		case "08": $m = "08";
			break;
		case "09": $m = "09";
			break;
		case "10": $m = "10";
			break;
		case "11": $m = "11";
			break;
		case "12": $m = "12";
			break;
	}
	// return $Y . "-" . $m . "-" . $d;
	return $Y.$m.$d.' '.$H.'.'.$i;  //20181001 08.30
}
function ws_date($dt){
	list($date, $time) = split(' ', $dt); // แยกวันที่ กับ เวลาออกจากกัน
	list($H, $i, $s) = split(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($Y, $m, $d) = split('-', $date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.

	switch ($m) {
		case "01": $m = "01";
			break;
		case "02": $m = "02";
			break;
		case "03": $m = "03";
			break;
		case "04": $m = "04";
			break;
		case "05": $m = "05";
			break;
		case "06": $m = "06";
			break;
		case "07": $m = "07";
			break;
		case "08": $m = "08";
			break;
		case "09": $m = "09";
			break;
		case "10": $m = "10";
			break;
		case "11": $m = "11";
			break;
		case "12": $m = "12";
			break;
	}
	// return $Y . "-" . $m . "-" . $d;
	return $Y.$m.$d;  //20181001
}
$wps=1;
		require_once("lib/nusoap.php");
        $client = new nusoap_client("http://wsdev.viriyah.co.th/TcsPolicy/CmiService.asmx?wsdl",true); 
  //       $wsdlFile = "http://wsdev.viriyah.co.th/TcsPolicy/CmiService.asmx";
  //       $client = new nusoap_client($wsdlFile, 'wsdl', '', '', '', '');
		$client->soap_defencoding = 'UTF-8';
		// $client->debug_flag = false;
// if($wps=='1'){

	// $IDDATA = "61113/รย/096794";  //เต็มปี
		// $IDDATA = "61113/รย/053120";   //เกินปี
		$IDDATA = "61113/รย/107058";  //ไม่เต็มปี
	// echo $IDDATA;
	// exit();
	$query = "SELECT ";
	$query .= "data.id,";	
	$query .= "data.doc_type,";
	$query .= "data.login, "; // รหัสผู้แจ้ง
	$query .= "tb_comp.name as comp_name, "; // บริษัทประกันภัย
	$query .= "tb_comp.name_print, "; // บริษัทประกันภัย
	$query .= "tb_comp.tel  as comp_tel, "; // เบอร์โทรศัพท์(แจ้งอุบัติเหตุ)
	$query .= "tb_comp.picture, "; 
	$query .= "tb_comp.add_namecom, "; 
	$query .= "tb_comp.add_namecom2, "; 
	$query .= "data.service, "; // ประเภทการซ่อม
	$query .= "data.com_data, ";
	$query .= "data.list_customer1, ";
	$query .= "data.list_customer2, ";
	$query .= "data.list_customer3, ";
	$query .= "data.list_customer4, ";
	$query .= "data.list_customer5, ";
	$query .= "data.pay_date, ";
	$query .= "data.list_customer, ";
	
	$query .= "tb_user.sub as branch, "; // สาขา
	$query .= "tb_user.contact, "; // ชื่อผู้แจ้ง
	$query .= "tb_user.cus_add, "; // บ้านเลขที่
	$query .= "tb_user.cus_group, "; // หมู่
	$query .= "tb_user.cus_town, "; //อาคาร/หมู่บ้าน
	$query .= "tb_user.cus_lane, "; // ซอย
	$query .= "tb_user.cus_road, "; // ถนน
	$query .= "tb_user.cus_tumbon, "; // ตำบล คีย์
	$query .= "tb_user.cus_amphur, "; // อำเภอ คีย์
	$query .= "tb_user.cus_province, "; // จังหวัด คีย์
	$query .= "tb_user.cus_postal , "; // รหัสไปรษณีย์
	
	$query .= "data.send_date,   "; // วันที่แจ้ง
	$query .= "data.name_inform, "; // รหัสผู้แจ้ง
	$query .= "data.id_data, "; // เลขที่รับแจ้ง
	$query .= "data.o_insure, "; // เลขที่กรมธรรมเดิม
	$query .= "data.ty_inform, "; // ประเภทงาน
	$query .= "data.idagent, "; //รหัสตัวแทน
	$query .= "data.start_date, "; // วันที่คุ้มครอง	
	$query .= "data.end_date, "; // วันที่สิ้นสุด
	$query .= "data.name_gain, "; // ชื่อผู้รับผลประโยชน์
	$query .= "data.q_auto, ";
	$query .= "data.user_up1, ";

	//////////////////////////////////////////
	$query .= "insuree.person , ";
	$query .= "insuree.title, "; // คำนำหน้า ชื่อผู้เอาประกัน
	$query .= "insuree.name,  "; // ชื่อผู้เอาประกัน
	$query .= "insuree.last, "; // นามสกุลผู้เอาประกัน
	$query .= "insuree.career, "; // นามสกุลผู้เอาประกัน
	$query .= "insuree.add, "; // บ้านเลขที่
	$query .= "insuree.icard, ";
	$query .= "insuree.id_business, ";
	$query .= "insuree.SendAdd, ";
	$query .= "insuree.group, "; // หมู่
	$query .= "insuree.town, "; //อาคาร/หมู่บ้าน
	$query .= "insuree.lane, "; // ซอย
	$query .= "insuree.road, "; // ถนน
	$query .= "insuree.tumbon, "; // ตำบล คีย์
	$query .= "insuree.amphur, "; // อำเภอ คีย์
	$query .= "insuree.province, "; // จังหวัด คีย์
	$query .= "insuree.postal, "; // รหัสไปรษณีย์
	$query .= "insuree.tel_mobile, "; // เบอร์โทร
	$query .= "insuree.tel_mobile2, "; // เบอร์โทร	
	$query .= "insuree.tel_home, "; // เบอร์โทร
	$query .= "insuree.tel_fax, "; // เบอร์โทร
	$query .= "insuree.email, "; // Email
	$query .= "insuree.email_cc, "; // Email_cc
	$query .= "insuree.status_vip, ";
	$query .= "insuree.paytype, ";
	$query .= "insuree.status_insured_time, ";
	$query .= "insuree.status_company_time, ";
	$query .= "insuree.edit_insured_time, ";
	$query .= "insuree.edit_data_time, ";
	$query .= "insuree.edit_data_ch, ";
	$query .= "tb_tumbon.name as tumbon_name, "; 
	$query .= "tb_amphur.name as amphur_name, "; 
	$query .= "tb_province.name as province_name, "; // จังหวัด
	$query .= "tb_province.province_code_oic, ";
	$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
	$query .= "tb_br_car.name as car_brand, "; // ยี่ห้อรถ
	$query .= "tb_cat_car.name as cat_car_name, "; // ประเภทรถ
	$query .= "tb_mo_car.name as mo_car_name, "; // รุ่นรถ  
	
	$query .= "detail.car_color, "; // สีรถ
	$query .= "detail.cc, "; // ซี ซ
	$query .= "detail.car_wg, "; // น.น.
	$query .= "detail.car_regis, "; // ทะเบียนรถ
	$query .= "detail.car_regis_pro, "; // ทะเบียนรถ
	$query .= "detail.car_body, "; // เลขตัวถัง
	$query .= "detail.regis_date, "; // ปีที่จดทะเบียน
	$query .= "detail.car_seat, "; // 
	$query .= "detail.n_motor, "; // เลขเครื่อง
	$query .= "detail.Cancel_policy, ";
	$query .= "detail.Cancel_policy2, ";
	$query .= "detail.id_data_company, ";
	$query .= "detail.status_policy_time, ";
	
	$query .= "premium.id, ";
	$query .= "premium.id_data, ";
	$query .= "premium.pre, "; // เบี้ยสุทธิ
	$query .= "premium.one, "; // ส่วนแรก
	$query .= "premium.driver, "; // ส่วนลดระบุผู้ขับขี่
	$query .= "premium.dis1, "; // ส่วนลดระบุผู้ขับขี่
	$query .= "premium.good, "; // ส่วนลดประวัติดี
	$query .= "premium.dis2, "; // ส่วนลดระบุผู้ขับขี่
	$query .= "premium.group3, "; // ส่วนลดประวัติดี
	$query .= "premium.dis_group3, "; // ส่วนลดประวัติดี
	$query .= "premium.pro_dis, "; // ส่วนลดพิเศษ
	$query .= "premium.total_pro_dis, "; // ส่วนลดพิเศษ
	$query .= "premium.total_pre, "; // เบี้ยสิทธิ หักส่วนลด
	$query .= "premium.total_stamp, "; // รวม อากร
	$query .= "premium.total_vat, "; // รวม ภาษี
	$query .= "premium.prb_net, ";
	$query .= "premium.prb_stamp, ";
	$query .= "premium.prb_tax, ";
	$query .= "premium.prb, "; // เบี้ย พ.ร.บ.
	$query .= "premium.total_prb, "; // เบี้ยรวม พ.ร.บ.
	$query .= "premium.total_sum, "; // เบี้ยรวม
	$query .= "premium.other, "; // เบี้ยรวม
	$query .= "premium.vat_1, "; // หัก ณ ที่จ่าย
	$query .= "premium.tax1prb, ";
	$query .= "premium.commition, "; // ส่วนลดเป็นบาท
	$query .= "premium.total_commition, "; // ยอดชำระ
	
	$query .= "premium.pre_old, ";
	$query .= "premium.one_old, ";
	$query .= "premium.disone_old, ";
	$query .= "premium.driver_old, ";
	$query .= "premium.dis1_old, ";
	$query .= "premium.good_old, ";
	$query .= "premium.dis2_old, ";
	$query .= "premium.group3_old, ";
	$query .= "premium.dis_group3_old, ";
	$query .= "premium.pro_dis_old, ";
	$query .= "premium.total_pro_dis_old, ";
	$query .= "premium.dis3_old, ";
	$query .= "premium.dis_vip_old, ";
	$query .= "premium.total_vip_old, ";
	$query .= "premium.total_dis4_old, ";
	$query .= "premium.total_pre_old, ";
	$query .= "premium.total_stamp_old, ";
	$query .= "premium.total_vat_old, ";
	$query .= "premium.total_sum_old, ";
	$query .= "premium.prb_old, ";
	$query .= "premium.total_prb_old, ";
	$query .= "premium.commition_old, ";
	$query .= "premium.other_old, ";
	$query .= "premium.vat_1_old, ";
	$query .= "premium.tax1prb_old, ";
	$query .= "premium.total_commition_old, ";
	$query .= "premium.editing, ";
	
	$query .= "protect.id, "; 
	$query .= "protect.cost, "; // ยอดชำระ
	$query .= "protect.damage_out1, ";
	$query .= "protect.damage_cost, ";
	$query .= "protect.pa1, ";
	$query .= "protect.pa2, ";
	$query .= "protect.pa3, ";
	$query .= "protect.pa4, ";
	$query .= "protect.people, ";
	
	$query .= "protect.cost_old, "; // ยอดชำระ
	$query .= "protect.damage_out1_old, ";
	$query .= "protect.damage_cost_old, "; 
	$query .= "protect.pa1_old, ";
	$query .= "protect.pa2_old, ";  
	$query .= "protect.pa3_old, "; 
	$query .= "protect.pa4_old, "; 
	$query .= "protect.people_old, ";
	
	$query .= "tb_agent.id_agent, ";
	$query .= "tb_agent.full_name, ";
	$query .= "tb_agent.agent_dis, ";
	$query .= "tb_agent.agent_group, ";
	
	//กรณีระบุชื่อผู้ขับขี่
	$query .= "driver.title_num1, "; // ผู้ขับขี่ที่ 1
	$query .= "driver.name_num1, ";
	$query .= "driver.last_num1, ";
	$query .= "driver.birth_num1, "; // วัน/เดือน/ปี (วันเกิด)
	$query .= "driver.title_num2, "; // ผู้ขับขี่ที่ 2
	$query .= "driver.name_num2, ";
	$query .= "driver.last_num2, ";
	$query .= "driver.birth_num2, "; // วัน/เดือน/ปี (วันเกิด)
	
	$query .= "act.act_id, ";
	$query .= "act.p_id, ";
	$query .= "act.act_sort, ";
	
	$query .= "tb_user.title_sub,";
	$query .= "tb_user.sub,";
	$query .= "tb_user.Email,";
	$query .= "tb_user.Email2,";
	$query .= "tb_user.Email3,";
	$query .= "tb_user.Email4,";
	$query .= "tb_user.Email5 ";
	
	$query .= "FROM data ";
	$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
	$query .= "INNER JOIN driver ON (driver.id_data = data.id_data)  ";
	$query .= "INNER JOIN service ON (data.id_data = service.id_data) ";
	$query .= "INNER JOIN premium ON (data.id_data = premium.id_data) ";
	$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
	$query .= "INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
	$query .= "INNER JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
	$query .= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
	$query .= "INNER JOIN act ON (act.id_data = data.id_data)  ";
	$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";	
	$query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
	$query .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
	$query .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
	$query .= "INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
	$query .= "INNER JOIN tb_province ON (tb_province.id = insuree.province) ";
	$query .= "INNER JOIN tb_user ON (tb_user.user = data.name_inform) ";
	$query .= "INNER JOIN  tb_agent ON (tb_agent.id_agent = data.idagent) ";
	$query .= "WHERE data.id_data='".$IDDATA."' ";
 
	mysql_select_db($db2,$cndb2);
	$objQuery = mysql_query($query,$cndb2) or die ("Error Query tb_data [".$query."]");
	$row = mysql_fetch_array($objQuery);

		$sqlprovcar = "SELECT  province_code_oic  FROM tb_province Where id= '".$row['car_regis_pro']."' ";
		$objProvcar = mysql_query($sqlprovcar,$cndb2) or die ("Error Query tb_data [".$sqlprovcar."]");
		$rowCar = mysql_fetch_array($objProvcar);

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$SaleName = "สุวดี ศรีปรีเปรม";
$AppSignDate = ws_datetime($row['send_date']); //"20181001 08.30";
$EffectiveDate = ws_date($row['start_date']); //"20181001";
$ExpiredDate = ws_date($row['end_date']); //"20191001";

$PolicyNo= "99999-60100-9234568";  // policy prb
$Barcode  = "903456780";
$CardType  = ''; $InsuredType=''; $CardNo='';
$InsuredBranchCode = ""; //12รหัสสาขาของผู้เอาประกัน
if($row['person']=='1'){ 
	$CardType  = "C"; $InsuredType = "P"; $CardNo = $row['icard'];  
}else if($row['person']=='2'){ 
	$CardType  = "L"; $InsuredType = "C"; $CardNo = $row['id_business'];  $InsuredBranchCode = "00000";
}  //11 P บุคคล C นิติ


$InsuredTitleName = $row['title']; //"คุณ"; //13คำนำหน้าชื่อ 
$InsuredName =  $row['name']; //"ทดสอบ"; //14ชื่อผู้เอาประกัน
$InsuredLastName = $row['last']; //"เว็บเซอร์วิส"; //15นามสกุลผูเอาประกัน
$Gender = "F"; //16เพศ M F
$BirthDate = ''; //"19841019"; //17วันเกิด 
$Telephone = '';  //18เบอร์โทร
$MobileNo = '';  //19มือถือ
$HomeNo = trim($row['add']);  //20เบอร์บ้าน
$Building = "";  //21ตึก
$Moo = trim($row['group']); //22หมู่ที่
$Moobarn = trim($row['town']); //23หมู่บ้าน
$RoomNo = ""; //24เบอร์ห้อง
$Trok = "";  //25ตรอก
$Soi = trim($row['lane']);  //26ซอย
$Road = trim($row['road']);  //27ถนน
$Tambol = $row['tumbon_name'];  //28ตำบล
$Amphur = $row['amphur_name'];  //29อำเภอ
$Postcode = $row['postal']; //"12140";  //30รหัสไปรษณีย์
$Province = $row['province_code_oic'];  //31จังหวัด
$LicenseNo = $row['car_regis']; //"กม1234";  //32ทะเบียนรถ
$LicenseProvince = $rowCar['province_code_oic'];  //33จดทะเบียนจังหวัด
$Chassis = $row['car_body'];//"MTH09PU5M7107258";  //34เลขถัง
$Engine =   $row['n_motor']; // "B20B3WP11644";  //35เลขเครื่อง


////////////////////////////////////////////////////////////
$VehicleType =  substr($row['p_id'],0,1).'.'.substr($row['p_id'],1,2);//$row['n_motor']; //"1.10";//36ประเภทรถ1.30 car_brand  mo_car_name
$VehicleMake = $row['car_brand'];//$row['n_motor']; //"HONDA";  //37ยี่ห้อรถ
$VehicleModel = $row['mo_car_name'];//$row['n_motor']; //"Accord";  //38รุ่นรถ
////////////////////////////////////////////////////////////

$VehicleRegYear = $row['regis_date']; //"2012"; //39ปีที่จดทะเบียน
$Seat =  $row['car_seat'];  //40จำนวนที่นั่ง
$CC =  $row['cc'];  //41ซีซี

if($row['car_wg']==''|| $row['car_wg']=='-'){
	$VehicleWeight =  0;   //42น้ำหนัก
}else{
	$VehicleWeight =   $row['car_wg'];   //42น้ำหนัก
}

$VehicleUseCode = "P";  //43การใช้รถ
$NetPremium = $row['prb_net'];  //44สุทธิ
$Vat =  $row['prb_tax'];  //45ภาษี
$Stamp = $row['prb_stamp'];  //46อากร
$GrossPremium = $row['prb'];  //47เบี้ยรวม

$OnlinePayment_amt = "0.00";  //48จำวนการจ่ายเงิน
$OnlinePayment_no = "";  //49เลขที่การจ่ายเงิน
$isOnline = "N";  //50Yonline N offline
$email_customer = "";  //51อีเมล์ลูกค้า
$email_agent = "";  //52อีเมล์ตัวแทน
$onlinemerchant_id = "" ;

$params = array(
                   'Username' => "Tuser1",
                   'Password' => "daif1928",
                   'tcspolicy' => array(
	                   'AgentCode' => "99999",//08829
					   'ApplicationNo' => "", //2รหัสอ้างอิง
					   'SaleName' => "{$SaleName}", //3ผู้แจ้งงาน
					   'AppSignDate' => "{$AppSignDate}", //4วันที่แจ้งงาน
					   'EffectiveDate' => "{$EffectiveDate}",//5วันเริ่มคุ้มครอง
					   'ExpiredDate' => "{$ExpiredDate}", //6สิ้นสุดวันคุ้มครอง
					   'PolicyNo' => "{$PolicyNo}",  //7เลขที่ กธ
					   'Barcode' => "{$Barcode}", //8บาร์โค้ด
					   'CardType' => "{$CardType}", //9ประเภทบัตร P C L A Z
					   'CardNo' => "{$CardNo}", //10หมายเลขบัตร
					   'InsuredType' => "{$InsuredType}", //11P บุคคล C นิติ
					   'InsuredBranchCode' => "{$InsuredBranchCode}", //12รหัสสาขาของผู้เอาประกัน
					   'InsuredTitleName' => "{$InsuredTitleName}", //13คำนำหน้าชื่อ
					   'InsuredName' => "{$InsuredName}", //14ชื่อผู้เอาประกัน
					   'InsuredLastName' => "{$InsuredLastName}", //15นามสกุลผูเอาประกัน
					   'Gender' => "{$Gender}", //16เพศ M F
					   'BirthDate' => "{$BirthDate}", //17วันเกิด
					   'Telephone' => "{$Telephone}",  //18เบอร์โทร
					   'MobileNo' => "{$MobileNo}",  //19มือถือ
					   'HomeNo' => "{$HomeNo}",  //20เบอร์บ้าน
					   'Building' => "{$Building}",  //21ตึก
					   'Moo' => "{$Moo}", //22หมู่ที่
					   'Moobarn' => "{$Moobarn}", //23หมู่บ้าน
					   'RoomNo' => "{$RoomNo}", //24เบอร์ห้อง
					   'Trok' => "{$Trok}",  //25ตรอก
					   'Soi' => "{$Soi}",  //26ซอย
					   'Road' => "{$Road}",  //27ถนน
					   'Tambol' => "{$Tambol}",  //28ตำบล
					   'Amphur' => "{$Amphur}",  //29อำเภอ
					   'Postcode' => "{$Postcode}",  //30รหัสไปรษณีย์
					   'Province' => "{$Province}",  //31จังหวัด
					   'LicenseNo' => "{$LicenseNo}",  //32ทะเบียนรถ
					   'LicenseProvince' => "{$LicenseProvince}",  //33จดทะเบียนจังหวัด
					   'Chassis' => "{$Chassis}",  //34เลขถัง
					   'Engine' => "{$Engine}",  //35เลขเครื่อง
					   'VehicleType' => "{$VehicleType}",//36ประเภทรถ1.30
					   'VehicleMake' => "{$VehicleMake}",  //37ยี่ห้อรถ
					   'VehicleModel' => "{$VehicleModel}",  //38รุ่นรถ
					   'VehicleRegYear' => "{$VehicleRegYear}", //39ปีที่จดทะเบียน
					   'Seat' => "{$Seat}",  //40จำนวนที่นั่ง
					   'CC' => "{$CC}",  //41ซีซี
					   'VehicleWeight' => "{$VehicleWeight}",  //42น้ำหนัก
					   'VehicleUseCode' => "{$VehicleUseCode}",  //43การใช้รถ
					   'NetPremium' => "{$NetPremium}",  //44สุทธิ
					   'Vat' => "{$Vat}",  //45ภาษี
					   'Stamp' => "{$Stamp}",  //46อากร
					   'GrossPremium' => "{$GrossPremium}",  //47เบี้ยรวม
					   'OnlinePayment_amt' => "{$OnlinePayment_amt}",  //48จำวนการจ่ายเงิน
					   'OnlinePayment_no' => "{$OnlinePayment_no}",  //49เลขที่การจ่ายเงิน
					   'isOnline' => "{$isOnline}",  //50Yonline N offline  หากต้องการส่งแบบ epolicy ส่ง พรบ ให้กับลุกค้าทางเมล์
					   'email_customer' => "{$email_customer}",  //51อีเมล์ลูกค้า
					   'email_agent' => "{$email_agent}",  //52อีเมล์ตัวแทน
					   'onlinemerchant_id' => "{$onlinemerchant_id}" //53เลขที่การจ่าย
	        		)
              );

// $params = array(
//                    'Username' => "Tuser1",
//                    'Password' => "daif1928",
//                    'tcspolicy' => array(
// 	                   'AgentCode' => "99999",//08829
// 					   'ApplicationNo' => "", //2รหัสอ้างอิง
// 					   'SaleName' => "ทดสอบ ทดสอบ", //3ผู้แจ้งงาน
// 					   'AppSignDate' => "20181001 08.30", //4วันที่แจ้งงาน
// 					   'EffectiveDate' => "20181001",//5วันเริ่มคุ้มครอง
// 					   'ExpiredDate' => "20191001", //6สิ้นสุดวันคุ้มครอง
// 					   'PolicyNo' => "99999-60100-1234567",  //7เลขที่ กธ
// 					   'Barcode' => "123456789", //8บาร์โค้ด
// 					   'CardType' => "C", //9ประเภทบัตร P C L A Z
// 					   'CardNo' => "1234567890123", //10หมายเลขบัตร
// 					   'InsuredType' => "P", //11P บุคคล C นิติ
// 					   'InsuredBranchCode' => "", //12รหัสสาขาของผู้เอาประกัน
// 					   'InsuredTitleName' => "คุณ", //13คำนำหน้าชื่อ
// 					   'InsuredName' => "ทดสอบ", //14ชื่อผู้เอาประกัน
// 					   'InsuredLastName' => "เว็บเซอร์วิส", //15นามสกุลผูเอาประกัน
// 					   'Gender' => "F", //16เพศ M F
// 					   'BirthDate' => "19841019", //17วันเกิด
// 					   'Telephone' => "021964521",  //18เบอร์โทร
// 					   'MobileNo' => "0951212222",  //19มือถือ
// 					   'HomeNo' => "1234",  //20เบอร์บ้าน
// 					   'Building' => "",  //21ตึก
// 					   'Moo' => "2", //22หมู่ที่
// 					   'Moobarn' => "หน้าไม้", //23หมู่บ้าน
// 					   'RoomNo' => "78/24", //24เบอร์ห้อง
// 					   'Trok' => "",  //25ตรอก
// 					   'Soi' => "6",  //26ซอย
// 					   'Road' => "ตลิ่งชัน-สุพรรณบุรี",  //27ถนน
// 					   'Tambol' => "ลาดหลุมแก้ว",  //28ตำบล
// 					   'Amphur' => "ลาดหลุมแก้ว",  //29อำเภอ
// 					   'Postcode' => "12140",  //30รหัสไปรษณีย์
// 					   'Province' => "13",  //31จังหวัด
// 					   'LicenseNo' => "กม1234",  //32ทะเบียนรถ
// 					   'LicenseProvince' => "10",  //33จดทะเบียนจังหวัด
// 					   'Chassis' => "MTH09PU5M7107258",  //34เลขถัง
// 					   'Engine' => "B20B3WP11644",  //35เลขเครื่อง
// 					   'VehicleType' => "1.10",//36ประเภทรถ1.30
// 					   'VehicleMake' => "HONDA",  //37ยี่ห้อรถ
// 					   'VehicleModel' => "Accord",  //38รุ่นรถ
// 					   'VehicleRegYear' => "2012", //39ปีที่จดทะเบียน
// 					   'Seat' => "4",  //40จำนวนที่นั่ง
// 					   'CC' => "1500",  //41ซีซี
// 					   'VehicleWeight' => "1",  //42น้ำหนัก
// 					   'VehicleUseCode' => "P",  //43การใช้รถ
// 					   'NetPremium' => "600.00",  //44สุทธิ
// 					   'Vat' => "3.00",  //45ภาษี
// 					   'Stamp' => "42.21",  //46อากร
// 					   'GrossPremium' => "645.21",  //47เบี้ยรวม
// 					   'OnlinePayment_amt' => "0.00",  //48จำวนการจ่ายเงิน
// 					   'OnlinePayment_no' => "",  //49เลขที่การจ่ายเงิน
// 					   'isOnline' => "N",  //50Yonline N offline
// 					   'email_customer' => "tksecuerity@gmail.com",  //51อีเมล์ลูกค้า
// 					   'email_agent' => "supinya@my4ib.com",  //52อีเมล์ตัวแทน
// 					   'onlinemerchant_id' => "" //53เลขที่การจ่าย
// 	        		)
//                );
 	 
  print_r($params);    
		//////////////////////
       $data = $client->call("SendPolicyCTPRealTime",$params); 
       $soapError = $client->getError();

		if (! empty($soapError)) {
		    $errorMessage = 'SOAP method invocation (verifyT) failed: ' . $s6oapError;
		    throw new Exception($errorMessage);
		}
       echo "<br> <br>".print_r($data)."<br>";
       
 
	// }   //end while

// }     //    

       
?>
</body>
</html>