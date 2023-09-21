<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
$_context = PDO_CONNECTION::fourinsure_insured();
function thaiDate($datetime)
{
	list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y + 543; // เปลี่ยน ค.ศ. เป็น พ.ศ.
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
	return $d . "/" . $m . "/" . $Y;
}

function thaiDate2($datetime)
{
	list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y + 543; // เปลี่ยน ค.ศ. เป็น พ.ศ.

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
	return $d . "/" . $m . "/" . $Y;
}

$IDDATA = $_GET["IDDATA"];

$query = "SELECT ";
$query .= "data.id,";
$query .= "data.doc_type,";
$query .= "data.login, "; // รหัสผู้แจ้ง

$query .= "tb_comp.name as comp_name, "; // บริษัทประกันภัย
$query .= "tb_comp.sort, "; // รหัสบริษัท
$query .= "tb_comp.picture, "; // รูปบริษัทประกัน
$query .= "tb_comp.name_print, "; // บริษัทประกันภัย
$query .= "tb_comp.tel, "; // เบอร์โทรศัพท์ บริษัทประกันภัย
$query .= "tb_comp.add_namecom, "; // ที่อยู่
$query .= "tb_comp.add_namecom2, "; // ที่อยู่
$query .= "tb_comp.name_print_en, "; // บริษัทประกันภัย
$query .= "tb_comp.add_namecom_en, "; // ที่อยู่
$query .= "tb_comp.add_namecom2_en, "; // ที่อยู่

$query .= "protect.cost, "; // ยอดชำระ
$query .= "protect.damage_out1, ";
$query .= "protect.damage_cost, ";
$query .= "protect.id, ";
$query .= "protect.pa1, ";
$query .= "protect.pa2, ";
$query .= "protect.pa3, ";
$query .= "protect.pa4, ";
$query .= "protect.pa5, ";
$query .= "protect.pa6, ";
$query .= "protect.people, ";
$query .= "protect.damage_notover, ";

$query .= "data.send_date,   "; // วันที่แจ้ง
$query .= "data.id_data, "; // เลขที่รับแจ้ง
$query .= "data.o_insure, "; // เลขที่กรมธรรมเดิม
$query .= "data.start_date, ";
$query .= "data.end_date, ";
$query .= "data.name_gain, ";

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
$query .= "premium.prb, "; // เบี้ย พ.ร.บ.
$query .= "premium.total_prb, "; // เบี้ยรวม พ.ร.บ.
$query .= "premium.total_sum, "; // เบี้ยรวม
$query .= "premium.other, "; // เบี้ยรวม
$query .= "premium.vat_1, "; // หัก ณ ที่จ่าย
$query .= "premium.commition, "; // ส่วนลดเป็นบาท
$query .= "premium.total_commition, "; // ยอดชำระ
$query .= "premium.disone, ";

$query .= "insuree.title, "; // คำนำหน้า ชื่อผู้เอาประกัน
$query .= "insuree.name,  "; // ชื่อผู้เอาประกัน
$query .= "insuree.last, "; // นามสกุลผู้เอาประกัน
$query .= "insuree.person, ";
$query .= "insuree.icard, ";
$query .= "insuree.id_business, ";
$query .= "insuree.SendAdd, "; // หมู่
$query .= "insuree.ins_lang, "; // หมู่
$query .= "insuree.career, "; // นามสกุลผู้เอาประกัน
$query .= "insuree.add, "; // บ้านเลขที่
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
$query .= "tb_tumbon.name as tumbon_name, ";
$query .= "tb_amphur.name as amphur_name, ";
$query .= "tb_province.name as province_name, "; // จังหวัด
$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
$query .= "tb_br_car.name as car_brand, "; // ยี่ห้อรถ
$query .= "tb_mo_car.name as mo_car_name, "; // รุ่นรถ

$query .= "detail.car_id, ";
$query .= "detail.car_regis, "; // ทะเบียนรถ
$query .= "detail.car_regis_pro, "; // ทะเบียนรถ
$query .= "detail.car_body, "; // เลขตัวถัง
$query .= "detail.regis_date, "; // ปีที่จดทะเบียน
$query .= "detail.n_motor, "; // เลขเครื่อง
$query .= "detail.car_seat, ";
$query .= "detail.cc, ";
$query .= "detail.car_wg, ";
$query .= "detail.Cancel_policy, ";
$query .= "detail.Cancel_policy2, ";
$query .= "detail.single_rate, ";

//กรณีระบุชื่อผู้ขับขี่
$query .= "driver.title_num1, "; // ผู้ขับขี่ที่ 1
$query .= "driver.name_num1, ";
$query .= "driver.last_num1, ";
$query .= "driver.birth_num1, "; // วัน/เดือน/ปี (วันเกิด)
$query .= "driver.title_num2, "; // ผู้ขับขี่ที่ 2
$query .= "driver.name_num2, ";
$query .= "driver.last_num2, ";
$query .= "driver.birth_num2, "; // วัน/เดือน/ปี (วันเกิด)
$query .= "service.fac1, "; //
$query .= "service.fac2, "; //
$query .= "service.fac3, "; //
$query .= "data.service, "; //
$query .= "tb_agent.id_agent, ";
$query .= "tb_agent.full_name, ";
$query .= "tb_agent.agent_dis, ";

$query .= "tb_pass_car_type.name as pass_car_name, ";
$query .= "tb_pass_car_type.english_name as e_pass_car_name, ";
$query .= "act.act_id, ";
$query .= "tb_user.Email,";
$query .= "tb_user.Email2,";
$query .= "tb_user.Email3,";
$query .= "tb_user.Email4,";
$query .= "tb_user.Email5 ";

$query .= "FROM data ";

$query .= "LEFT JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "LEFT JOIN service ON (data.id_data = service.id_data) ";
$query .= "LEFT JOIN premium ON (data.id_data = premium.id_data) ";
$query .= "LEFT JOIN protect ON (data.id_data = protect.id_data) ";
$query .= "LEFT JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
$query .= "LEFT JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
$query .= "LEFT JOIN tb_br_car ON (detail.br_car = tb_br_car.id)  ";
$query .= "LEFT JOIN act ON (data.id_data = act.id_data)  ";
$query .= "LEFT JOIN insuree ON (insuree.id_data = data.id_data) ";
$query .= "LEFT JOIN driver ON (data.id_data = driver.id_data)  ";
$query .= "LEFT JOIN tb_agent ON (data.idagent = tb_agent.id_agent)  ";
$query .= "LEFT JOIN tb_mo_car ON (detail.mo_car = tb_mo_car.id) ";
$query .= "LEFT JOIN tb_cat_car ON (detail.cat_car = tb_cat_car.id) ";
$query .= "LEFT JOIN tb_tumbon ON (insuree.tumbon = tb_tumbon.id) ";
$query .= "LEFT JOIN tb_amphur ON (insuree.amphur = tb_amphur.id) ";
$query .= "LEFT JOIN tb_province ON (insuree.province = tb_province.id) ";
$query .= "LEFT JOIN tb_user ON (data.name_inform = tb_user.user) ";
$query .= "LEFT JOIN tb_pass_car_type ON (detail.car_id = tb_pass_car_type.pass_car_id) ";

$query .= "WHERE data.id_data='" . $IDDATA . "' ";

$objQuery = $_context->query($query);

$row = $objQuery->fetch();

if ($row['ins_lang'] == '' || $row['ins_lang'] == 'T') {
	$arrLang = array(
		'txtlang1' => 'แจ้งอุบัติเหตุ โทร. ', 'txtlang2' => $row['name_print'], 'txtlang3' => $row['add_namecom'], 'txtlang4' => $row['add_namecom2'], 'txtlang5' => 'อาชีพ', 'txtlang6' => '', 'txtlang7' => 'รหัสบริษัท :', 'txtlang8' => 'ใบคำขอประกันภัยรถยนต์', 'txtlang9' => 'อาณาเขตคุ้มครอง :', 'txtlang10' => 'ใบคำขอเลขที่ :',
		'txtlang11' => 'ผู้เอาประกันภัย', 'txtlang12' => 'ชื่อ :    ', 'txtlang13' => 'ที่อยู่ :    ', 'txtlang14' => 'เลขบัตรประชาชน', 'txtlang15' => 'ผู้ขับขี่ 1', 'txtlang16' => 'วัน/เดือน/ปีเกิด', 'txtlang17' => 'ผู้ขับขี่ 2', 'txtlang18' => 'วัน/เดือน/ปีเกิด', 'txtlang19' => 'ผู้รับประโยชน์', 'txtlang20' => 'ระยะเวลาประกันภัย : เริ่มต้นวันที่',
		'txtlang21' => 'สิ้นสุดวันที่', 'txtlang22' => 'เวลา', 'txtlang23' => 'รายการรถยนต์ที่เอาประกันภัย', 'txtlang24' => 'ลำดับ', 'txtlang25' => 'รหัส', 'txtlang26' => 'ชื่อรถยนต์/รหัส', 'txtlang27' => 'เลขทะเบียน', 'txtlang28' => 'เลขตัวถัง', 'txtlang29' => 'ปีรุ่น', 'txtlang30' => 'เลขเครื่อง',
		'txtlang31' => 'ที่นั่ง/ขนาด/น.น.', 'txtlang32' => 'จำนวนเงินเอาประกันภัย :', 'txtlang33' => 'ความรับผิดต่อบุคคลภายนอก', 'txtlang34' => 'รถยนต์เสียหาย สูญหาย ไฟไหม้', 'txtlang35' => 'ความคุ้มครองตามเอกสารแนบท้าย', 'txtlang36' => '1) ความเสียหายต่อชีวิต ร่างกาย หรือ', 'txtlang37' => 'อนามัยเฉพาะส่วนเกินวงเงินสูงสุดตาม พรบ', 'txtlang38' => 'บาท/คน', 'txtlang39' => 'บาท/ครั้ง', 'txtlang40' => '2) ความเสียหายต่อทรัพย์สิน',
		'txtlang41' => '2.1 ความเสียหายส่วนแรก', 'txtlang42' => '1) ความเสียหายต่อรถยนต์', 'txtlang43' => '1.1 ความเสียหายส่วนแรก', 'txtlang44' => '2) รถยนต์สูญหาย/ไฟไหม้', 'txtlang45' => '1) อุบัติเหตุส่วนบุคคล', 'txtlang46' => '1.1 เสียชีวิต สูญเสียอวัยวะ ทุพพลภาพถาวร', 'txtlang47' => 'ก) ผู้ขับขี่ 1 คน', 'txtlang48' => 'ข) ผู้โดยสาร', 'txtlang49' => '1.2 ทุพพลภาพชั่วคราว', 'txtlang50' => 'บาทแล้ว)',
		'txtlang51' => 'ประเทศไทย', 'txtlang52' => '2) ค่ารักษาพยาบาล', 'txtlang53' => '3) การประกันตัวผู้ขับขี่', 'txtlang54' => 'เบี้ยประกันตามความคุ้มครองหลัก', 'txtlang55' => '(เบี้ยประกันภัยได้หักส่วนลดกรณีระบุชื่อผู้ขับขี่', 'txtlang56' => 'เบี้ยประกันภัยตามเอกสารแนบท้าย', 'txtlang57' => 'ส่วนลด', 'txtlang58' => 'ความเสียหายส่วนแรก', 'txtlang59' => 'อื่นๆ', 'txtlang60' => 'ส่วนลดกลุ่ม',
		'txtlang61' => 'รวมส่วนลด', 'txtlang62' => 'ประวัติดี', 'txtlang63' => 'ส่วนลดเพิ่ม', 'txtlang64' => 'ประวัติเพิ่ม', 'txtlang65' => 'เบี้ยประกันสุทธิ', 'txtlang66' => 'อากร', 'txtlang67' => 'ภาษีมูลค่าเพิ่ม', 'txtlang68' => 'รวม', 'txtlang69' => 'การใช้รถยนต์ :', 'txtlang70' => '',
		'txtlang71' => '', 'txtlang72' => 'ตัวแทนประกันภัยรายนี้', 'txtlang73' => 'นายหน้าประกันภัยรายนี้', 'txtlang74' => 'ใบอนุญาตเลขที่', 'txtlang75' => 'วันทำสัญญาประกันภัย', 'txtlang76' => 'วันทำกรมธรรม์', 'txtlang77' => 'เอกสารฉบับนี้เป็นเพียงข้อเสนอประกันภัยรถยนต์เท่านั้น ส่วนเงื่อนไข ความคุ้มครอง ข้อยกเว้น เป็นไปตามที่กำหนดในกรมธรรม์ประกันภัยรถยนต์ และเอกสารแนบท้าย', 'txtlang78' => 'เลขกรมธรรม์เดิม: ', 'txtlang79' => 'เลขทะเบียนนิติบุคคล', 'txtlang80' => 'เลขทะเบียนนิติบุคคลในนามบริษัท', 'txtlang81' => '16.30 น.', 'txtlang82' => 'กรมธรรม์ประกันภัยนี้ให้การคุ้มครองเฉพาะข้อตกลงคุ้มครองที่มีจำนวนเงินเอาประกันภัยระบุไว้เท่านั้น', 'txtlang83' => 'บาท', 'txtlang84' => 'บาท/สัปดาห์', 'txtlang85' => 'บาท/คน/สัปดาห์', 'txtlang86' => 'คน', 'txtlang87' => 'ประกันภัยโดยตรง'
	);
} else if ($row['ins_lang'] == 'Y') {
	$arrLang = array(
		'txtlang1' => '24/7 Claim Call Center : ', 'txtlang2' => $row['name_print_en'], 'txtlang3' => $row['add_namecom_en'], 'txtlang4' => $row['add_namecom2_en'], 'txtlang5' => 'Occupation', 'txtlang6' => '', 'txtlang7' => 'Code :', 'txtlang8' => 'Confirmation Note', 'txtlang9' => 'Territorial Limit Cover', 'txtlang10' => 'Ref No. :',
		'txtlang11' => '', 'txtlang12' => 'The Insured Name :', 'txtlang13' => 'Address :', 'txtlang14' => 'ID/Passport no', 'txtlang15' => 'Driver1', 'txtlang16' => 'Date of Birth', 'txtlang17' => 'Driver2', 'txtlang18' => 'Date of Birth', 'txtlang19' => '', 'txtlang20' => 'Effective Date',
		'txtlang21' => 'Expired Date', 'txtlang22' => 'Time', 'txtlang23' => 'Particulars of the Insured Vehicle', 'txtlang24' => 'No', 'txtlang25' => 'Code', 'txtlang26' => 'Make/Model', 'txtlang27' => 'License No', 'txtlang28' => 'Chassis No', 'txtlang29' => 'Year', 'txtlang30' => 'Body Type',
		'txtlang31' => 'No of Seats/CC./Gvw', 'txtlang32' => 'SUM INSURED : This note is covered only by the agreed sum insured is indicated', 'txtlang33' => 'Third Party Liability', 'txtlang34' => 'Loss/Damage of the Insured Vehicle', 'txtlang35' => 'Coverage of Endorsement', 'txtlang36' => '1) Limit Liability for Bodily Injury or Death over ', 'txtlang37' => 'Compulsory Insurance Limit to', 'txtlang38' => 'Baht/Person', 'txtlang39' => 'Baht/Accident', 'txtlang40' => '2) Property Damage',
		'txtlang41' => 'Deductible', 'txtlang42' => '1) Damage of the insured Vehicle', 'txtlang43' => '1.1 Deductible', 'txtlang44' => '2) Loss of Vehicle for Fire/Theft', 'txtlang45' => '1) Personal Accident', 'txtlang46' => '1.1Loss of life , Total Permanent Disability', 'txtlang47' => 'Driver 1 person', 'txtlang48' => 'Passenger', 'txtlang49' => '1.2 Temporary Disability', 'txtlang50' => 'Baht)', 'txtlang51' => 'Thailand', 'txtlang52' => '2) Medical Payment', 'txtlang53' => '3) Bail Bond', 'txtlang54' => 'Net Base Premium', 'txtlang55' => '(Baes premium after deducting discount premium for "Named Drivers"  ', 'txtlang56' => 'Endorsement Premium', 'txtlang57' => 'Discount', 'txtlang58' => 'Deductible', 'txtlang59' => 'Others', 'txtlang60' => 'Fleet',
		'txtlang61' => 'Total Discount', 'txtlang62' => 'No Claim Bonus', 'txtlang63' => 'Add.', 'txtlang64' => '', 'txtlang65' => 'Net Premium/Baht', 'txtlang66' => 'Stamps/Baht', 'txtlang67' => 'Vat/Baht', 'txtlang68' => 'Grand Total/Baht', 'txtlang69' => 'Purpose of use :', 'txtlang70' => 'Car Seat',
		'txtlang71' => 'Purpose of user', 'txtlang72' => 'Agent', 'txtlang73' => 'Broker', 'txtlang74' => 'License No.', 'txtlang75' => 'Agreement made on', 'txtlang76' => 'Confirmation Note', 'txtlang77' => 'As evident This note is to confirm only,for the terms,conditions and exclusion as in the insurance policy and the endorsement attachment', 'txtlang78' => 'Original Policy no.', 'txtlang79' => 'Tax Identification No. ', 'txtlang80' => 'เลขทะเบียนนิติบุคคลในนามบริษัท', 'txtlang81' => '4:30 PM.', 'txtlang82' => '', 'txtlang83' => 'Baht', 'txtlang84' => 'Baht/Week', 'txtlang85' => 'Baht/Person/Week', 'txtlang86' => 'Persons', 'txtlang87' => 'Direct Insurance'
	);
}

$car_id = $row['car_id'];
$id_data_rec = $row['id_data'];
$arr_car_id = str_split($car_id);

$career = $row['career']; // สถานที่
$add = $row['add']; // บ้านเลขที่
$group = $row['group']; // หมู่
$town = $row['town']; // หมู่บ้าน
$lane = $row['lane']; // ซอย
$road = $row['road']; // ถนน

// ที่อยู่
$address_1 = '';
if ($career != "" && $career != "-") {
	$address_1 = $career;
}
if ($group != "" && $group != "-") {
	$address_1 .= " ม." . $group;
}
if ($town != "" && $town != "-") {
	$address_1 .= " " . $town;
}
if ($lane != "" && $lane != "-") {
	$address_1 .= " ซ." . $lane;
}
if ($road != "" && $road != "-") {
	$address_1 .= " ถ." . $road;
}

if ($row['province'] != "102") {
	$address_2 = 'ต.' . $row['tumbon_name'] . ' อ.' . $row['amphur_name'] . ' จ.' . $row['province_name'];
} else {
	$address_2 = 'แขวง' . $row['tumbon_name'] . ' ' . $row['amphur_name'] . ' ' . $row['province_name'];
}

// ความเสียหายส่วนแรก
if ($row['one'] == "0" or $row['one'] == "") {
	$one_s = "-";
} else {
	$one_s = $row['one'];
}

// ความเสียหายต่อรถยนต์
if ($row['doc_type'] == "2") {
	$cost_car = "-";
} else {
	$cost_car = $row['cost'];
}

// สูญหายไฟใหม้
if ($row['doc_type'] == "3" or $row['doc_type'] == "3+") {
	$cost_3 = "-";
} else {
	$cost_3 = $row['cost'];
}

// ผู้ขับขี่คนที่ 1
if ($row['name_num1'] != "ไม่ระบุ") {
	$D_Name = $row['title_num1'] . ' ' . $row['name_num1'] . ' ' . $row['last_num1'];
} else {
	if ($row['ins_lang'] == 'Y') {
		$D_Name = "-";
	} else {
		$D_Name = "ไม่ระบุ";
	}
}

// ผู้ขับขี่คนที่ 2
if ($row['name_num2'] != "ไม่ระบุ") {
	$D_Name2 = $row['title_num2'] . ' ' . $row['name_num2'] . ' ' . $row['last_num2'];
} else {
	if ($row['ins_lang'] == 'Y') {
		$D_Name2 = "-";
	} else {
		$D_Name2 = "ไม่ระบุ";
	}
}

// รหัสบัตรประชาชน - เลขนิติบุคคล
if ($row['person'] == "1") {
	$I_card = $row['icard'];
	$I_card2 = "";
}
if ($row['person'] == "2") {
	$I_card =  "";
	$I_card2 = $row['id_business'];
}
if ($row['person'] == "3") {
	$I_card = $row['icard'];
	$I_card2 = $row['id_business'];
}
if ($row['icard'] == "0000000000000" or $row['icard'] == "") {
	$I_card = "-";
}
if ($row['id_business'] == "0000000000000" or $row['id_business'] == "") {
	$I_card2 = "";
}

// เลข พรบ.
if ($row['act_id'] == "") {
	$act_id = "-";
} else {
	$act_id = $row['act_id'];
}


// จังหวัดทะเบียนรถ
$sql = "SELECT name_mini FROM tb_province WHERE id='" . $row['car_regis_pro'] . "'";
$result = $_context->query($sql);
$fetcharr = $result->fetch();
$c_regis = $fetcharr['name_mini'];


require('../fpdf.php');

define('FPDF_FONTPATH', 'font/');


$pdf = new FPDF();

$pdf->AddPage('P', 'A4');
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->AddFont('angsa', 'B', 'angsab.php');
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(false);
$pdf->AddFont('CordiaNew', '', 'cordia.php');

$pdf->Image("./images/img_confirm/ConfirmationNote_EN_2020_6.png", 0, 2, 210, 297);

if ($row['name_print'] == "บริษัท วิริยะประกันภัย จำกัด (มหาชน)") {


	$pdf->Image("../images/" . $row['picture'], 7, 6, 60, 0);

	$pdf->SetY(8);
	$pdf->SetX(75);
	$pdf->SetFont('angsa', 'B', 16);
	$pdf->Cell(100, 0, iconv('UTF-8', 'TIS-620', $arrLang['txtlang2']), 0, 1, "L");

	$pdf->SetY(13);
	$pdf->SetX(75);
	$pdf->SetFont('angsa', '', 12);
	$pdf->Cell(100, 0, iconv('UTF-8', 'TIS-620', $arrLang['txtlang3'] . " " . $arrLang['txtlang4']), 0, 1, "L");

	$pdf->SetY(17);
	$pdf->SetX(75);
	$pdf->SetFont('angsa', '', 12);
	$pdf->Cell(100, 0, iconv('UTF-8', 'TIS-620', 'Tel. 02-196-8234 (Auto) Fax. 02-196-8235 '), 0, 1, "L");
} else {
	if (trim($row['sort']) == 'BKI') {
		$pdf->Image("../images/pic_insured/BK-2020.jpg", 7, 6, 50, 0);
	} else 
			if ($row['sort'] == 'TSID1' || $row['sort'] == 'TMSTH') {
		$pdf->Image("../images/" . $row['picture'], 10, 5, 45, 0);
	} else if ($row['sort'] == 'TSK') {
		$pdf->Image("../images/" . $row['picture'], 10, 4, 18, 0);
	} else {
		$pdf->Image("../images/" . $row['picture'], 10, 5, 45, 0);
	}


	$pdf->SetY(8);
	$pdf->SetX(62);
	$pdf->SetFont('angsa', 'B', 16);
	$pdf->Cell(100, 0, iconv('UTF-8', 'TIS-620', $arrLang['txtlang2']), 0, 1, "L");
	//******************************************* แก้ไขชั่วครว กรณีที่อยู่ยาว ******************************************************************** */
	if ($row['sort'] == 'TSK') {
		$pdf->SetY(13.5);
		$pdf->SetX(62);
		$pdf->SetFont('angsa', '', 12);
		$pdf->Cell(100, 0, iconv('UTF-8', 'TIS-620', $arrLang['txtlang3']), 0, 1, "L");

		$pdf->SetY(18);
		$pdf->SetX(62);
		$pdf->SetFont('angsa', '', 12);
		$pdf->Cell(100, 0, iconv('UTF-8', 'TIS-620', $arrLang['txtlang4'] . '  Tel. 02-196-8234 (Auto) Fax. 02-196-8235 '), 0, 1, "L");
	} else {
		$pdf->SetY(13.5);
		$pdf->SetX(62);
		$pdf->SetFont('angsa', '', 12);
		$pdf->Cell(100, 0, iconv('UTF-8', 'TIS-620', $arrLang['txtlang3'] . " " . $arrLang['txtlang4']), 0, 1, "L");

		$pdf->SetY(18);
		$pdf->SetX(62);
		$pdf->SetFont('angsa', '', 12);
		$pdf->Cell(100, 0, iconv('UTF-8', 'TIS-620', 'Tel. 02-196-8234 (Auto) Fax. 02-196-8235 '), 0, 1, "L");
	}
}

$pdf->SetY(19);
$pdf->SetX(115);
$pdf->SetFont('angsa', 'B', 18);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $arrLang['txtlang1'] . $row['tel']), 0, 1, "R"); //แจ้งอุบัติเหตุ

$pdf->SetY(25.7);
if ($row['ins_lang'] == 'Y') {
	$pdf->SetX(31);
} else {
	$pdf->SetX(31);
}

$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['sort']), 0, 1, "L"); //รหัสบริษัท

$pdf->SetY(25.7);
$pdf->SetX(185);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $arrLang['txtlang51']), 0, 1, "L");

$pdf->SetY(32);
if ($row['ins_lang'] == 'Y') {
	$pdf->SetX(38);
} else {
	$pdf->SetX(38);
}
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['id_data']), 0, 1, "L"); //เลขรับแจ้ง

$pdf->SetY(31.5);
$pdf->SetX(116);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['o_insure']), 0, 1, "L");


$pdf->SetY(39.5);
$pdf->SetX(43);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['title'] . "" . $row['name'] . "  " . $row['last']), 0, 1, "L");

if ($row['person'] == '1') {

	$pdf->SetY(39.5);
	$pdf->SetX(139);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', "เลขที่บัตรประชาชน / ID Passport no :"), 0);

	$pdf->SetY(39.5);
	$pdf->SetX(184);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $I_card), 0);
}
if ($row['person'] == '2') {

	$pdf->SetY(39.5);
	$pdf->SetX(129);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', "เลขทะเบียนนิติบุคคล / Tax Identification No. :"), 0);

	$pdf->SetY(39.5);
	$pdf->SetX(184);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $I_card2), 0);
}
if ($row['person'] == '3') {

	$pdf->SetY(39.5);
	$pdf->SetX(139);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', "เลขที่บัตรประชาชน / ID Passport no :"), 0);

	$pdf->SetY(39.5);
	$pdf->SetX(184);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $I_card), 0);

	$pdf->SetY(47);
	$pdf->SetX(129);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', "เลขทะเบียนนิติบุคคล / Tax Identification No. :"), 0);

	$pdf->SetY(47);
	$pdf->SetX(184);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $I_card2), 0);
}

if ($row['ins_lang'] == 'Y') {
	$pdf->SetY(47);
	$pdf->SetX(24);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['SendAdd']), 0, 1, "L");
} else {
	$address = trim($add . ' ' . $address_1 . ' ' . $address_2 . ' ' . $row['postal'], " ");
	$pdf->SetY(47);
	$pdf->SetX(24);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $address), 0, 1, 'L'); //ที่อยู่
}

$pdf->SetY(55);
$pdf->SetX(30);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $D_Name), 0, 1, "L");

$pdf->SetY(55);
$pdf->SetX(118);
$pdf->SetFont('angsa', '', 12);
if ($row['ins_lang'] == 'Y') {
	if ($row['birth_num1'] == '' || $row['birth_num1'] == 'ไม่ระบุ') {
		$birth_num1 = '-';
	} else {
		$birth_num1 = $row['birth_num1'];
	}
} else {
	$birth_num1 = $row['birth_num1'];
}
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $birth_num1), 0, 1, "L");

$pdf->SetY(61);
$pdf->SetX(30);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $D_Name2), 0, 1, "L");

$pdf->SetY(61);
$pdf->SetX(118);
$pdf->SetFont('angsa', '', 12);
if ($row['ins_lang'] == 'Y') {
	if ($row['birth_num2'] == '' || $row['birth_num2'] == 'ไม่ระบุ') {
		$birth_num2 = '-';
	} else {
		$birth_num2 = $row['birth_num2'];
	}
} else {
	$birth_num2 = $row['birth_num2'];
}
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $birth_num2), 0, 1, "L");

$name_gain = $row['name_gain'];

$pdf->SetY(67.5);
$pdf->SetX(45);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $name_gain), 0, 1, "L");

$pdf->SetY(74);
$pdf->SetX(52);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', thaiDate($row['start_date'])), 0, 1, "L");

$pdf->SetY(74);
$pdf->SetX(112);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', ":"), 0, 1, "L");

$pdf->SetY(74);
$pdf->SetX(115);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', thaiDate($row['end_date'])), 0, 1, "L");

$pdf->SetY(74);
$pdf->SetX(156);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', ":"), 0, 1, "L");

$pdf->SetY(74);
$pdf->SetX(158);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $arrLang['txtlang81']), 0, 1, "L");

$pdf->SetY(101);
$pdf->SetX(10);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(10, 12, iconv('UTF-8', 'TIS-620', ''), 0, 1, "C");

$pdf->SetY(92);
$pdf->SetX(15);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(10, 12, iconv('UTF-8', 'TIS-620', $row['car_id']), 0, 1, "C");

$pdf->SetY(89);
$pdf->SetX(28);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(45, 12, iconv('UTF-8', 'TIS-620', $row['car_brand']), 0, 1, "C");

$pdf->SetY(92);
$pdf->SetX(28);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(45, 12, iconv('UTF-8', 'TIS-620', $row['mo_car_name']), 0, 1, "C");

$pdf->SetY(92);
$pdf->SetX(75);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(20, 12, iconv('UTF-8', 'TIS-620', $row['car_regis'] . " " . $c_regis), 0, 1, "C");

if ($row['Cancel_policy2'] != "ยกเลิกกรมธรรม์") {
	$pdf->SetTextColor(0, 0, 0); 		//สีตัวอักษร
	$pdf->SetY(92);
	$pdf->SetX(96);
	$pdf->SetFont('angsa', '', 12);
	$pdf->Cell(35, 12, iconv('UTF-8', 'TIS-620', $row['car_body']), 0, 0, "C");
} else {
	$pdf->SetTextColor(0, 0, 0); 		//สีตัวอักษร
	$pdf->SetY(92);
	$pdf->SetX(95);
	$pdf->SetFont('angsa', '', 12);
	$pdf->Cell(35, 12, iconv('UTF-8', 'TIS-620', $row['car_body']), 0, 0, "C");

	$pdf->SetTextColor(255, 0, 0); 		//สีตัวอักษร
	$pdf->SetY(95);
	$pdf->SetX(95);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(35, 12, iconv('UTF-8', 'TIS-620', 'ยกเลิกกรมธรรม์'), 0, 0, "C");
}

$pdf->SetTextColor(0, 0, 0); 		//สีตัวอักษร

$pdf->SetY(92);
$pdf->SetX(132);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(10, 12, iconv('UTF-8', 'TIS-620', $row['regis_date']), 0, 0, "C"); //ปีจดทะเบียน

if ($row['Cancel_policy2'] != "ยกเลิกกรมธรรม์") {
	$pdf->SetTextColor(0, 0, 0); 		//สีตัวอักษร
	$pdf->SetY(92);
	$pdf->SetX(143);
	$pdf->SetFont('angsa', '', 12);
	$pdf->Cell(30, 12, iconv('UTF-8', 'TIS-620', $row['n_motor']), 0, 0, "C"); ////เลขเครื่องไม่ยกเลิก
} else {
	$pdf->SetTextColor(0, 0, 0); 		//สีตัวอักษร
	$pdf->SetY(92);
	$pdf->SetX(143);
	$pdf->SetFont('angsa', '', 12);
	$pdf->Cell(30, 12, iconv('UTF-8', 'TIS-620', $row['n_motor']), 0, 0, "C"); //เลขเครื่องยกเลิก

	$pdf->SetTextColor(255, 0, 0); 		//สีตัวอักษร
	$pdf->SetY(95);
	$pdf->SetX(142);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(30, 12, iconv('UTF-8', 'TIS-620', 'ยกเลิกกรมธรรม์'), 0, 0, "C"); //เลขเครื่องยกเลิก
}

$pdf->SetTextColor(0, 0, 0); 		//สีตัวอักษร

$pdf->SetY(92);
$pdf->SetX(173);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(30, 12, iconv('UTF-8', 'TIS-620', $row['car_seat'] . " / " . $row['cc'] . " / " . $row['car_wg']), 0, 0, "C");

$pdf->SetY(142);
$pdf->SetX(6);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(35, 6, iconv('UTF-8', 'TIS-620', $row['damage_out1']), 0, 1, "R"); //ความเสียหายต่อร่างกายคน

$pdf->SetY(146.8);
$pdf->SetX(6);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(35, 6, iconv('UTF-8', 'TIS-620', $row['damage_notover']), 0, 1, "R"); //ความเสียหายต่อร่างกายครั้ง

$pdf->SetY(162.8);
$pdf->SetX(6);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(35, 6, iconv('UTF-8', 'TIS-620', $row['damage_cost']), 0, 1, "R");

$pdf->SetY(176);
$pdf->SetX(6);
$pdf->SetFont('angsa', '', 12);
$useDamageFirst = $row['doc_type'] != '1' ? "$one_s" : "-";
$pdf->Cell(35, 6, iconv('UTF-8', 'TIS-620', $useDamageFirst), 0, 1, "R");

$pdf->SetY(135.5);
$pdf->SetX(68);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(30, 6, iconv('UTF-8', 'TIS-620', $cost_car), 0, 1, "R");

$pdf->SetY(150.5);
$pdf->SetX(68);
$useDamageFirst = $row['doc_type'] == '1' ? "$one_s" : "-";
$pdf->Cell(30, 6, iconv('UTF-8', 'TIS-620', $useDamageFirst), 0, 1, "R");

$pdf->SetY(167.2);
$pdf->SetX(68);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(30, 6, iconv('UTF-8', 'TIS-620', $cost_3), 0, 1, "R");

$pdf->SetY(185);
$pdf->SetX(76);
$pdf->SetFont('angsa', 'B', 25);

if ($row['service'] == '1') {
	$service_name = 'ซ่อมห้าง';
	$pdf->Cell(50, 0, iconv('UTF-8', 'TIS-620', $service_name), 0, 1, "C");
	$service_En_name = 'Dealer Garage';
	$pdf->SetY(190);
	$pdf->SetX(92);
} else if ($row['service'] == '2') {
	$service_name = 'ซ่อมอู่';
	$pdf->Cell(50, 0, iconv('UTF-8', 'TIS-620', $service_name), 0, 1, "C");
	$service_En_name = 'Garage';
	$pdf->SetY(190);
	$pdf->SetX(82);
}

$pdf->SetFont('angsa', 'B', 25);
$pdf->Cell(30, 6, iconv('UTF-8', 'TIS-620', $service_En_name), 0, 1, "R");

$pdf->SetY(144.5);
$pdf->SetX(141);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(30, 6, iconv('UTF-8', 'TIS-620', $row['pa1']), 0, 1, "R");

$pdf->SetY(149.5);
$pdf->SetX(151.5);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(53, 6, iconv('UTF-8', 'TIS-620', $row['people']), 0, 1, "L");

$pdf->SetY(149.5);
$pdf->SetX(171);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(53, 6, iconv('UTF-8', 'TIS-620', $row['people']), 0, 1, "L");

$pdf->SetY(155.5);
$pdf->SetX(141);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(30, 6, iconv('UTF-8', 'TIS-620', $row['pa2']), 0, 1, "R");


$pdf->SetY(176.4);
$pdf->SetX(151.9);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(53, 6, iconv('UTF-8', 'TIS-620', $row['people']), 0, 1, "L");

$pdf->SetY(176.4);
$pdf->SetX(172);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(53, 6, iconv('UTF-8', 'TIS-620', $row['people']), 0, 1, "L");

$pdf->SetY(171);
$pdf->SetX(141.5);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(30, 6, iconv('UTF-8', 'TIS-620', number_format($row['pa5'], 0)), 0, 1, "R");

$pdf->SetY(183.5);
$pdf->SetX(129);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(30, 6, iconv('UTF-8', 'TIS-620', number_format($row['pa6'], 0)), 0, 1, "R"); //เลข0ที่ต้องปรับ

$pdf->SetY(193.5);
$pdf->SetX(141);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(30, 6, iconv('UTF-8', 'TIS-620', $row['pa3']), 0, 1, "R");

$pdf->SetY(203.5);
$pdf->SetX(141);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(30, 6, iconv('UTF-8', 'TIS-620', $row['pa4']), 0, 1, "R");

$pdf->SetY(210);
$pdf->SetX(50);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(53, 6, iconv('UTF-8', 'TIS-620', '-'), 0, 1, "R"); //เบีเยประกันตามความคุ้มครองหลัก

$pdf->SetY(215);
$pdf->SetX(50);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(53, 6, iconv('UTF-8', 'TIS-620', '0.00'), 0, 1, "R"); //เบี้ยประกันภัยหักส่วนลดกรณีระบุชื่อ

$pdf->SetY(211);
$pdf->SetX(133);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(53, 6, iconv('UTF-8', 'TIS-620', '-'), 0, 1, "R"); //เบี้ยประกันตามเอกสารเเนบท้าย

$pdf->SetY(225.8);
$pdf->SetX(44);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(25, 6, iconv('UTF-8', 'TIS-620', $row['disone']), 0, 1, "R"); //ความเสียหายส่วนเเรก

$pdf->SetY(234);
$pdf->SetX(44);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(25, 6, iconv('UTF-8', 'TIS-620', '0.00'), 0, 1, "R"); //อื่นๆ

$pdf->SetY(226);
$pdf->SetX(105);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(25, 6, iconv('UTF-8', 'TIS-620', $row['dis_group3']), 0, 1, "R"); //ส่วนลดกลุ่ม

$pdf->SetY(234);
$pdf->SetX(105);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(25, 6, iconv('UTF-8', 'TIS-620', $row['dis2']), 0, 1, "R"); //ประวัติดี

$pdf->SetY(226);
$pdf->SetX(133);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(55, 12, iconv('UTF-8', 'TIS-620', '0.00'), 0, 1, "R"); //รวมส่วนลด

$pdf->SetY(245);
$pdf->SetX(90);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 6, iconv('UTF-8', 'TIS-620', '-'), 0, 1, "L"); //ประวัติเพิ่ม

$pdf->SetY(256);
$pdf->SetX(7);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(50, 10, iconv('UTF-8', 'TIS-620', $row['total_pre']), 0, 0, "C"); //เบี้ยสุทธิ

$pdf->SetY(256);
$pdf->SetX(59);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(25, 10, iconv('UTF-8', 'TIS-620', number_format($row['total_stamp'], 2)), 0, 0, "C"); //อากร

$pdf->SetY(256);
$pdf->SetX(85);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(60, 10, iconv('UTF-8', 'TIS-620', $row['total_vat']), 0, 0, "C"); //ภาษีมูลค่าเพิ่ม

$pdf->SetY(256);
$pdf->SetX(149);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(55, 10, iconv('UTF-8', 'TIS-620', $row['total_sum']), 0, 0, "C"); //เบี้ยรวม

$pdf->SetY(266.5);
$pdf->SetX(45);
$pdf->SetFont('angsa', '', 12);
if ($row['ins_lang'] == 'Y') {
	$pass_car_name = $row['e_pass_car_name'];
} else {
	$pass_car_name = $row['pass_car_name'];
}
$pdf->Cell(190, 6, iconv('UTF-8', 'TIS-620', $pass_car_name), 0, 1, "L");

$pdf->SetY(275.1);
$pdf->SetX(62.5);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', "X"), 0, 0, "L");


$pdf->SetY(272.8);
if ($row['ins_lang'] == 'Y') {
	$pdf->SetX(270.6);
} else {
	$pdf->SetX(105);
}

$pdf->SetFont('angsa', '', 11);
$pdf->Cell(175, 6, iconv('UTF-8', 'TIS-620', $arrLang['txtlang87']), 0, 1, "L");

$pdf->SetY(272.8);
$pdf->SetX(188);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(175, 6, iconv('UTF-8', 'TIS-620', 'ว.00018/2551'), 0, 1, "L"); //เลขที่ใบอนุญาติ

$pdf->SetY(281.5);
$pdf->SetX(64);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', thaiDate2($row['send_date'])), 0); //วันทำสัญญา

if ($row['sort'] == 'VIB_S103' && $row['single_rate'] != 'Y') // วิริยะ
{
	if ($row['car_brand'] == 'SUZUKI') // suzuki
	{
		$newDate_regis = (date("Y") - $row['regis_date']) + 1;

		if ($newDate_regis == '2' && $row['doc_type'] == '1') {

			$pdf->AddPage();
			$pdf->AddFont('angsa', '', 'angsa.php');
			$pdf->AddFont('angsa', 'B', 'angsab.php');

			$pdf->Image("../images/ex_1.jpg", 0, 0, 210, 0);

			$code_vib = '10320';

			$pdf->SetY(66);
			$pdf->SetX(31);
			$pdf->SetFont('angsa', '', 12);
			$pdf->Cell(15, 0, iconv('UTF-8', 'TIS-620', $code_vib), 0, 0, "C");

			$pdf->SetY(73);
			$pdf->SetX(43);
			$pdf->SetFont('angsa', '', 12);
			$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['title'] . "" . $row['name'] . "  " . $row['last']), 0, 0, "L");

			$pdf->SetY(80);
			$pdf->SetX(68);
			$pdf->SetFont('angsa', '', 12);
			$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', thaiDate($row['start_date'])), 0, 1, "L");

			$pdf->SetX(120);
			$pdf->SetFont('angsa', '', 12);
			$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', thaiDate($row['end_date'])), 0, 1, "L");

			$pdf->SetY(86.5);
			$pdf->SetX(46);
			$pdf->SetFont('angsa', '', 12);
			$pdf->Cell(35, 0, iconv('UTF-8', 'TIS-620', '20,000'), 0, 0, "C");

			$pdf->SetY(93);
			$pdf->SetX(42);
			$pdf->SetFont('angsa', '', 12);
			$pdf->Cell(35, 0, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "C");

			$pdf->SetY(99.5);
			$pdf->SetX(59);
			$pdf->SetFont('angsa', '', 12);
			$pdf->Cell(15, 0, iconv('UTF-8', 'TIS-620', '400.00'), 0, 0, "C");

			$pdf->SetX(99);
			$pdf->SetFont('angsa', '', 12);
			$pdf->Cell(15, 0, iconv('UTF-8', 'TIS-620', '2.00'), 0, 0, "C");

			$pdf->SetX(138);
			$pdf->SetFont('angsa', '', 12);
			$pdf->Cell(15, 0, iconv('UTF-8', 'TIS-620', '28.14'), 0, 0, "C");

			$pdf->SetX(166);
			$pdf->SetFont('angsa', '', 12);
			$pdf->Cell(15, 0, iconv('UTF-8', 'TIS-620', '430.14'), 0, 0, "C");

		}
	}
}

$pdf->Output();