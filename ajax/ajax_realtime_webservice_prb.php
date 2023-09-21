<?php 
session_start();
include "../check-ses.php";
include "../inc/connectdbs.inc.php";

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
	return $Y.$m.$d;  //20181001
}

	require_once("../nusoap/lib/nusoap.php");

	mysql_select_db($db1,$cndb1);
	// $chkdata = $_POST['chkid'];
	// $chkcount = count($_POST['chkid']);
	$iddataall ='';
	echo "<table width='100%' class='table table-striped table-bordered' ><tr><td>ข้อมูล</td><td>ผลการส่ง</td><td>พิมพ์ กรมธรรม์ พรบ.</td></tr>";

	$arrtext = array();

    // $client1 = new nusoap_client("http://ws.viriyah.co.th/TcsPolicy/CmiService.asmx?wsdl",true);   // จริง
    $client1 = new nusoap_client("https://wsdev.viriyah.co.th/TcsPolicy_dev/CmiService.asmx?wsdl",true); // test
    //https://ws.viriyah.co.th/TcsPolicy/CmiService.asmx  //https://wsdev.viriyah.co.th/TcsPolicy/CmiService.asmx?wsdl
	$client1->soap_defencoding = 'UTF-8';
	$soapError = $client1->getError();
	$output = '';
	// $IDDATA = $chkdata[$i];


$IDDATA = $_GET['iddata'];

$query = "SELECT ";
$query .= "data.id,";
$query .= "data.p_act,";
$query .= "data.doc_type,";
$query .= "data.login, "; // รหัสผู้แจ้ง
$query .= "data.com_data, "; // รหัสผู้แจ้ง
$query .= "tb_comp.name as comp_name, "; // บริษัทประกันภัย
$query .= "tb_comp.tel  as comp_tel, "; // เบอร์โทรศัพท์(แจ้งอุบัติเหตุ)
$query .= "data.send_date,   "; // วันที่แจ้ง
$query .= "data.name_inform, "; // รหัสผู้แจ้ง
$query .= "data.id_data, "; // เลขที่รับแจ้ง
$query .= "tb_type_inform.name as type_inform_name, "; // ประเภทงาน
$query .= "data.start_date, "; // วันที่คุ้มครอง
$query .= "data.end_date, "; // วันที่สิ้นสุด
$query .= "data.name_gain, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.send_req, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.send_req2, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.send_cancel, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.my4ib_check, "; // วิริยะปากเกร็ด
$query .= "data.com_data, "; // วิริยะปากเกร็ด

$query .= "insuree.title, "; // คำนำหน้า ชื่อผู้เอาประกัน
$query .= "insuree.name,  "; // ชื่อผู้เอาประกัน
$query .= "insuree.last, "; // นามสกุลผู้เอาประกัน
$query .= "insuree.add, "; // บ้านเลขที่
$query .= "insuree.group, "; // หมู่
$query .= "insuree.town, "; //อาคาร/หมู่บ้าน
$query .= "insuree.lane, "; // ซอย
$query .= "insuree.road, "; // ถนน
$query .= "insuree.tumbon, "; // ตำบล คีย์
$query .= "insuree.amphur, "; // อำเภอ คีย์
$query .= "insuree.province, "; // จังหวัด คีย์
$query .= "insuree.postal, "; // รหัสไปรษณีย์
$query .= "insuree.career, "; // แยกใบเสร็จ
$query .= "insuree.SendAdd, "; // ที่อยู่จัดส่งเอกสาร
$query .= "insuree.status_SendAdd, ";
$query .= "insuree.email, ";
$query .= "insuree.tel_mobi, ";
$query .= "insuree.person, ";
$query .= "insuree.icard, ";

$query .= "tb_tumbon.name as tumbon_name, "; 
$query .= "tb_amphur.name as amphur_name, "; 
$query .= "tb_province.name as province_name, "; // จังหวัด

$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
$query .= "detail.mo_car, "; // ยี่ห้อรถ
$query .= "detail.mo_sub, "; // ยี่ห้อรถ
$query .= "tb_br_car.name as car_brand, "; // ยี่ห้อรถ
$query .= "tb_cat_car.name as cat_car_name, "; // ประเภทรถ
$query .= "tb_mo_car.name as mo_car_name, "; // รุ่นรถ

$query .= "detail.car_color, "; // สีรถ
$query .= "detail.car_regis, "; // ทะเบียนรถ
$query .= "detail.car_regis_text, "; // ทะเบียนรถ
$query .= "detail.car_regis_pro, "; // ทะเบียนรถ
$query .= "detail.car_body, "; // เลขตัวถัง
$query .= "detail.regis_date, "; // ปีที่จดทะเบียน
$query .= "detail.n_motor, "; // เลขเครื่อง
$query .= "detail.equit, ";
$query .= "detail.car_detail, ";
$query .= "detail.cat_car, ";
$query .= "detail.gear, ";
$query .= "detail.insure_year, ";

$query .= "detail.car_cat_acc, ";
$query .= "detail.car_cat_acc_total, ";

$query .= "data.updated, "; // สลักหลัง
$query .= "protect.costCost,"; // ทุนประกันภัย

$query .= "tb_cost.cost, ";
$query .= "tb_cost.pre, ";
$query .= "tb_cost.stamp, ";
$query .= "tb_cost.tax, ";
$query .= "tb_cost.net, ";

$query .= "req.Req_Status, ";
$query .= "req.Req_Date, ";
$query .= "req.EditCancel, ";
$query .= "req.Cancel_Detail, ";
$query .= "req.EditTime, ";
$query .= "req.EditTime_StartDate, ";
$query .= "req.EditTime_EndDate, ";
$query .= "req.EditHr, ";
$query .= "req.EditHr_Detail, ";
$query .= "req.EditAct, ";
$query .= "req.EditAct_id, ";
$query .= "req.EditCar, ";
$query .= "req.Edit_CarBody, ";
$query .= "req.Edit_Nmotor, ";
$query .= "req.Edit_CarColor, ";
$query .= "req.EditCustomer, ";
$query .= "req.EditPerson, ";
$query .= "req.Cus_title, ";
$query .= "req.Cus_name, ";
$query .= "req.Cus_last, ";
$query .= "req.Cus_add, ";
$query .= "req.Cus_group, ";
$query .= "req.Cus_town, ";
$query .= "req.Cus_lane, ";
$query .= "req.Cus_road, ";
$query .= "req.Cus_tumbon, ";
$query .= "req.Cus_amphur, ";
$query .= "req.Cus_postal, ";
$query .= "req.Cus_province, ";
$query .= "req.EditCost, ";
$query .= "req.EditcostCost, ";
$query .= "req.EditProduct, ";
$query .= "req.Product as ReqProduct, ";
$query .= "req.TotalProduct, ";
$query .= "req.CostProduct ";

$query .= "FROM data ";
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
$query .= "INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
$query .= "INNER JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
$query .= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
$query .= "INNER JOIN tb_cost ON (tb_cost.id = protect.costCost) ";
$query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
$query .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
$query .= "INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
$query .= "INNER JOIN tb_province ON (tb_province.id = insuree.province) ";
$query .= "INNER JOIN req ON (req.id_data = data.id_data) ";
$query .= "WHERE data.id_data='".$IDDATA."' ";
 
	mysql_select_db($db1,$cndb1);
	$objQuery = mysql_query($query,$cndb1) or die ("Error Query tb_data [".$query."]");
	$row = mysql_fetch_array($objQuery);

	$sqlprovcar = "SELECT  province_code_oic  FROM tb_province Where id= '".$row['car_regis_pro']."' ";
	$objProvcar = mysql_query($sqlprovcar,$cndb1) or die ("Error Query tb_data [".$sqlprovcar."]");
	$rowCar = mysql_fetch_array($objProvcar);

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$query1 = "SELECT ";
$query1 .= "tb_tumbon.name as tumbon, "; 
$query1 .= "tb_amphur.name as amphur, "; 
$query1 .= "tb_province.name as province "; // จังหวัด
$query1 .= "FROM req ";
$query1 .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = req.Cus_tumbon) ";
$query1 .= "INNER JOIN tb_amphur ON (tb_amphur.id = req.Cus_amphur) ";
$query1 .= "INNER JOIN tb_province ON (tb_province.id = req.Cus_province) ";
$query1 .= "WHERE req.id_data='".$IDDATA."'";
$objQuery1 = mysql_query($query1,$cndb1) or die ("Error Query [".$query1."]");
$row1 = mysql_fetch_array($objQuery1);


	
$SaleName = "สุวดี ศรีปรีเปรม";
$AppSignDate = ws_datetime($row['send_date']); //"20181001 08.30";
echo "AppSignDate".$AppSignDate.'<br>';
if($row['EditTime'] == 'Y'){
	$EffectiveDate = ws_date($row['EditTime_StartDate']);
	$ExpiredDate = ws_date($row['EditTime_EndDate']);
}else{
	$EffectiveDate = ws_date($row['start_date']); //"20181001";
	$ExpiredDate = ws_date($row['end_date']); //"20191001";
}

$PolicyNo = '99999-62101-9999999'; //$row['tmp_act_id'];  // policy prb
$Barcode  = '123456789'; //$row['barcode_id'];

$CardType  = ''; $InsuredType=''; $CardNo='';
$InsuredBranchCode = ""; //12รหัสสาขาของผู้เอาประกัน


if($row['EditCustomer'] == 'Y')
{
	if($row['EditPerson']=='1'||$row['EditPerson']=='3'){  
		$CardType  = "C"; $InsuredType = "P"; $CardNo = $row['icard'];
	}else if($row['EditPerson']==2){
		$CardType  = "L"; $InsuredType = "C"; $CardNo = $row['id_business'];  $InsuredBranchCode = "00000";
	}
	$InsuredTitleName = $row['Cus_title']; //"คุณ"; //13คำนำหน้าชื่อ 
	$InsuredName =  $row['Cus_name']; //"ทดสอบ"; //14ชื่อผู้เอาประกัน
	$InsuredLastName = $row['Cus_last']; //"เว็บเซอร์วิส"; //15นามสกุลผูเอาประกัน

	$HomeNo = trim($row['Cus_add']);  //20เบอร์บ้าน
	$Building = "";  //21ตึก
	if($row['Cus_group'] !="-" && $row['Cus_group'] !=""){
		$Moo = trim($row['Cus_group']); //22หมู่ที่
	}
	if($row['Cus_town'] !="-" && $row['Cus_town'] !=""){
		$Moobarn = trim($row['Cus_town']); //23หมู่บ้าน
	}
	$RoomNo = ""; //24เบอร์ห้อง
	$Trok = "";  //25ตรอก
	if($row['Cus_lane'] !="-" && $row['Cus_lane'] !=""){
		$Soi = trim($row['Cus_lane']);  //26ซอย
	}
	if($row['Cus_road'] !="-"){
		$Road = trim($row['Cus_road']);  //27ถนน
	}
	
	$Tambol = $row['tumbon'];  //28ตำบล
	$Amphur = $row['amphur'];  //29อำเภอ
	$Postcode = $row['Cus_postal']; //"12140";  //30รหัสไปรษณีย์

	$sqlprovins = "SELECT  province_code_oic  FROM tb_province Where id= '".$row['Cus_province']."' ";
	$objProvins = mysql_query($sqlprovins,$cndb1) or die ("Error Query tb_data [".$sqlprovins."]");
	$roProins = mysql_fetch_array($objProvins);
	$Province = $roProins['province_code_oic'];  //31จังหวัด
	
}else{
	if($row['person']=='1'||$row['person']=='3'){ 
		$CardType  = "C"; $InsuredType = "P"; $CardNo = $row['icard'];  
	}else if($row['person']=='2'){ 
		$CardType  = "L"; $InsuredType = "C"; $CardNo = $row['id_business'];  $InsuredBranchCode = "00000";
	}  //11 P บุคคล C นิติ

	$InsuredTitleName = $row['title']; //"คุณ"; //13คำนำหน้าชื่อ 
	$InsuredName =  $row['name']; //"ทดสอบ"; //14ชื่อผู้เอาประกัน
	$InsuredLastName = $row['last']; //"เว็บเซอร์วิส"; //15นามสกุลผูเอาประกัน

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
	
	$sqlprovins = "SELECT  province_code_oic  FROM tb_province Where id= '".$row['province']."' ";
	$objProvins = mysql_query($sqlprovins,$cndb1) or die ("Error Query tb_data [".$sqlprovins."]");
	$roProins = mysql_fetch_array($objProvins);
	$Province = $roProins['province_code_oic'];  //31จังหวัด
}


$Gender = "M"; //16เพศ M F

$BirthDate = ''; //"19841019"; //17วันเกิด 
$Telephone = '';  //18เบอร์โทร
$MobileNo = '';  //19มือถือ

$LicenseNo = trim($row['car_regis']); //"กม1234";  //32ทะเบียนรถ
$LicenseProvince = $rowCar['province_code_oic'];  //33จดทะเบียนจังหวัด
if($row['EditCar'] == 'Y'){
	$Chassis = $row['Edit_CarBody'];//"MTH09PU5M7107258";  //34เลขถัง
	$Engine =   $row['Edit_Nmotor']; // "B20B3WP11644";  //35เลขเครื่อง
}else{
	$Chassis = $row['car_body'];//"MTH09PU5M7107258";  //34เลขถัง
	$Engine =   $row['n_motor']; // "B20B3WP11644";  //35เลขเครื่อง
}


if($row['car_cat_acc'] != ''){
	$carid = $row['car_cat_acc'];
}else{
	$carid = $row['car_id'];
}

$tp_id = $carid ; //$row['p_id'];
$countp_id = strlen($tp_id);
$p_id1 = substr($tp_id, 0 ,1);
$p_id2 = substr($tp_id, 1 ,$countp_id);

$VehicleType =  $p_id1.'.'.$p_id2; //"1.10";//36ประเภทรถ1.30 car_brand  mo_car_name

$VehicleMake = $row['car_brand'];//$row['n_motor']; //"HONDA";  //37ยี่ห้อรถ
$nameCar=$row['mo_car_name'];
if(!empty($row['mo_sub'])){
  $sqlQueMS ="SELECT * FROM tb_mo_car_sub where id = '".$row['mo_sub']."'";
  $resMS = mysql_query($sqlQueMS,$cndb1);
  $rowMS = mysql_fetch_array($resMS);
  $nameCar = $rowMS['name'];
}

$VehicleModel = $nameCar; //"Accord";  //38รุ่นรถ
////////////////////////////////////////////////////////////

$VehicleRegYear = $row['regis_date']; //"2012"; //39ปีที่จดทะเบียน
$Seat =  '7'; //$row['car_seat'];  //40จำนวนที่นั่ง
$CC =  '1200'; //$row['cc'];  //41ซีซี

if($row['car_wg']==''|| $row['car_wg']=='-'){
	$VehicleWeight =  0;   //42น้ำหนัก
}else{
	$countwg = strlen($row['car_wg']);
	if($countwg==4){
		$VehicleWeight =   round($row['car_wg']/1000,0);   //42น้ำหนัก
	}else{
		$VehicleWeight =   $row['car_wg'];   //42น้ำหนัก
	}
}
$tcar_id = $row['car_id'];
$pcarid = substr($tcar_id, 0 ,1);
if($pcarid=='3'){ 
	$VehicleCarid = "C";  //43การใช้รถ P=บุคคล C = พาณิชย์
}else if($pcarid=='2'){ 
	$VehicleCarid = "C"; 
}else{ 
	$VehicleCarid = "P";	
}
$VehicleUseCode = $VehicleCarid;  //43การใช้รถ P=บุคคล C = พาณิชย์
$NetPremium ='600.00'; // str_replace(',','',$row['prb_net']);  //44สุทธิ
$Vat =  '42.21'; //str_replace(',','',$row['prb_tax']);  //45ภาษี
$Stamp = '3.00'; //str_replace(',','',$row['prb_stamp']);  //46อากร
$GrossPremium = '645.21'; //str_replace(',','',$row['prb']);  //47เบี้ยรวม

$OnlinePayment_amt = "0.00";  //48จำวนการจ่ายเงิน
$OnlinePayment_no = "";  //49เลขที่การจ่ายเงิน
$isOnline = "N";  //50Yonline N offline
$email_customer = "";  //51อีเมล์ลูกค้า
$email_agent = "";  //52อีเมล์ตัวแทน
$onlinemerchant_id = "" ;
$agcode = "99999";//"08829";
$nowYear =  date('Y')+543;
$agYear = substr($nowYear, 2);
$agsaka = "101";

$params = array(
                   'Username' => "Tuser1",  //WS08829  //Tuser1 
                   'Password' => "daif1928",  //9y;cmovib113  //daif1928
                   'tcspolicy' => array(
	                   'AgentCode' => "{$agcode}",//08829  //99999
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
					   'GrossPremium' => "{$GrossPremium}"
	        		)
              );

		 echo "<tr><td colspan='3'>".print_r($params)."</td></tr>";
		//exit();
		if ($client1->fault) {
		    $fault = "{$client1->faultcode}: {$client1->faultdetail} ";
		   	echo '<br>fault: '.$fault; 
		}

		if (! empty($soapError)) {
		    $errorMessage = 'SOAP method invocation (verifyT) failed: ' . $soapError;
		    throw new Exception($errorMessage);
		    echo "<tr><td colspan='3'><br>show error".$errorMessage."</td></tr>";
		    exit();
		}else{
			 $data1 = $client1->call("SendPolicyCTPRealTime",$params); 
		}
		


   //     		echo "<br>=====";
			// print_r($data1);
			// echo "<br>=====";
       
       		$returnPolicyNo =$data1['SendPolicyCTPRealTimeResult']['PolicyNo'];
       		$returnBarCode =$data1['SendPolicyCTPRealTimeResult']['BarCode'];
       		$returnPolicyURL =$data1['SendPolicyCTPRealTimeResult']['PolicyURL'];
       		$returnResult =$data1['SendPolicyCTPRealTimeResult']['Result'];
       		$returnErrorCode =$data1['SendPolicyCTPRealTimeResult']['ErrorCode'];
       		$returnErrorMsg =$data1['SendPolicyCTPRealTimeResult']['ErrorMsg'];

       		if(!empty($returnResult)){
       	 	$insPrb = "INSERT INTO `wsdl_vib_result`(ws_id,id_data,ws_result,ws_errcode,ws_errormsg,ws_policyno,ws_barcode,ws_policyurl,ws_entrydate,ws_emp,ws_system)VALUES('','".$IDDATA."','".$returnResult."','".$returnErrorCode."','','".$returnPolicyNo."','".$returnBarCode."','".$returnPolicyURL."','".date("Y-m-d H:s:i")."','".$_SESSION["idtb_login"]."','SZ') ";
       	 	mysql_select_db($db2,$cndb2);
       		$objUpfinish = mysql_query($insPrb,$cndb2);
       		}

       	if($returnResult=='Success'){		
       		$sqlupfin = "UPDATE `insuree` SET ws_prb_status = 'Y' WHERE id_data='".$IDDATA."' ";
       		mysql_select_db($db1,$cndb1);
       		$objUpfinish = mysql_query($sqlupfin,$cndb1);
       		
       		$codeact_id = $agcode.'-'.$agYear.$agsaka.'-'.$returnPolicyNo;
       		$sqlupfinid = "UPDATE `act` SET full_act_id = '".$codeact_id."' ,tmp_act_id = '".$returnPolicyNo."' ,barcode_id = '".$returnBarCode."',ws_send_date='".date("Y-m-d H:s:i")."',ws_path_policy='".$returnPolicyURL."'  WHERE id_data='".$IDDATA."' ";
       		$objUpfinishid = mysql_query($sqlupfinid,$cndb1);
       		
       	}

       $btnPrintprb ='';
       if(!empty($returnPolicyURL)){
       		$btnPrintprb = "<a class='btn btn-success' target='_blank' href='".$returnPolicyURL."'>".$returnBarCode."</a>";
       }
       echo "<tr><td>เลขรับแจ้ง : ".$IDDATA." <br></td><td>[".$returnResult."]".$returnErrorCode."</td><td>".$btnPrintprb."</td></tr>";

?>

<?php  
echo "</table>";
?>