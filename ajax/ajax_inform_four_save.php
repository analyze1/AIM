<?php
require("../inc/connectdbs.pdo.php");
require("../services/LineNoti.service.php");
$_contextMitsu = PDO_CONNECTION::fourinsure_mitsu();
$_contextFour = PDO_CONNECTION::fourinsure_insured();

if (!empty($_GET["user"]) && !empty($_GET["id_detail"])) {
	if ($_GET["user"] != 'admin' && $_GET["claim"] != 'ADMIN') {
		$c_user = $_GET["user"];
	} else {
		$c_user = $_GET["user"];
	}
	if ($_POST['SendAdd_inform'] == '2') {
		$SendAdd1 = $_POST['send_add'] . "|" . $_POST['send_group'] . "|" . $_POST['send_town'] . "|" . $_POST['send_lane'] . "|" . $_POST['send_road'] . "|" . $_POST['send_province'] . "|" . $_POST['send_amphur'] . "|" . $_POST['send_tumbon'] . "|" . $_POST['send_post'];
		$status_SendAdd = 'Y';
	} else {
		$SendAdd1 = '';
		$status_SendAdd = 'N';
	}

	$login = 'DEALER'; // ผู้แจ้ง
	$useraction = $_GET["user"]; // ผู้แจ้งในนาม
	$name_inform = $_POST["emp_inform"];

	$status_pass1 = $_POST['status_pass1_inform'];
	$status_pass2 = $_POST['status_pass2_inform'];
	$status_pass3 = $_POST['status_pass3_inform'];
	$status_pass4 = $_POST['status_pass4_inform'];
	$act_sort = $_POST["act_sort_inform"];
	$com_data = $_POST["com_data_inform"]; // บริษัทประกัน
	$send_date = date('Y-m-d H:i:s'); // วันที่แจ้ง
	$id_data = $_POST["id_data_inform"]; // เลขที่รับแจ้ง
	$ty_inform = $_POST["ty_inform"]; // ประเภทการแจ้ง (ต่ออายุ ใหม่)
	$o_insure = $_POST["o_insure_inform"]; // กธ. เก่า
	$idagent = $_POST["currentText_inform"]; //รหัสตัวแทน
	$doc_type = $_POST["doc_type_inform"]; // ประเภท 1 2 3
	$icard = $_POST["icard_inform"]; // icard
	$niti = $_POST["niti_inform"]; // id_niti

	// ดึงจากลูกค้าเก่า
	$end_date_old =  $_POST["end_date_old_inform"];
	$id_data_old =  $_POST["id_data_old_inform"];
	$car_body_old =  $_POST["car_body_old_inform"];

	if ($car_body_old != '') {
		$sql = "SELECT * FROM `data`,detail WHERE `data`.id_data = detail.id_data AND detail.car_body = '$car_body' GROUP BY detail.car_body ORDER BY `data`.end_date ";
		$result = $_contextFour->query($sql);
		$fetcharr = $result->fetch(2);
		$check_end_date = $fetcharr["end_date"];
		$check_id_data = $fetcharr["id_data"];
		$check_car_body = $fetcharr["car_body"];

		$strsql = "UPDATE `data` SET `status`='SS' WHERE end_date = '$check_end_date' AND id_data = '$check_id_data' ";
		$objQuery = $_contextFour->prepare($strsql)->execute();
	}

	$startDate = $_POST["start_date_inform"]; // วันที่คุ้มครอง						

	$startDate_dd = substr($startDate, 0, 2);
	$startDate_mm = substr($startDate, 3, 2);
	$startDate_yy = substr($startDate, 6, 4);
	$start_date = $startDate_yy . "-" . $startDate_mm . "-" . $startDate_dd;

	$year_plus = $startDate_yy + 1;
	$end_date = $year_plus . "-" . $startDate_mm . "-" . $startDate_dd;;

	$vatcar = $_POST["vat_car_inform"];
	$vatcar_dd = substr($vatcar, 0, 2);
	$vatcar_mm = substr($vatcar, 3, 2);
	$vatcar_yy = substr($vatcar, 6, 4);
	$vat_car = $vatcar_yy . "-" . $vatcar_mm . "-" . $vatcar_dd;

	$actCheck = $_POST["actCheck_inform"]; // ดึงเลขพรบหร้อไม
	$service = $_POST["service_inform"];
	$code = $_POST['code_inform'];  // อ้างอิงจากลูกค้าเก่า
	$code2 = $_POST['code2_inform'];  // อ้างอิงจาก ใบเสนอราคา
	$code_new = $_POST["code_new_inform"];
	$show_q_auto = $_POST["show_q_auto_inform"];


	$name_gain = $_POST["name_gain_inform"];
	$single_rate = $_POST["single_rate_inform"];
	$product = $_POST["product_inform"];


	// ระบุผู้ขับขี่

	$rdodriver = $_POST["rdodriver_inform"];
	if ($rdodriver == "N" or $rdodriver == "0") {
		$title_num1 = "ไม่ระบุ";
		$name_num1 = "ไม่ระบุ";
		$last_num1 = "ไม่ระบุ";
		$birth_num1 = "ไม่ระบุ";
		$title_num2 = "ไม่ระบุ";
		$name_num2 = "ไม่ระบุ";
		$last_num2 = "ไม่ระบุ";
		$birth_num2 = "ไม่ระบุ";
	} else if ($rdodriver == "1") {
		$title_num1 = $_POST["title_num1_inform"];
		$name_num1 = $_POST["name_num1_inform"];
		$last_num1 = $_POST["last_num1_inform"];
		$birth_num1 = $_POST["birth_num1_inform"];

		$title_num2 = "ไม่ระบุ";
		$name_num2 = "ไม่ระบุ";
		$last_num2 = "ไม่ระบุ";
		$birth_num2 = "ไม่ระบุ";
	} else if ($rdodriver == "2") {
		$title_num1 = $_POST["title_num1_inform"];
		$name_num1 = $_POST["name_num1_inform"];
		$last_num1 = $_POST["last_num1_inform"];
		$birth_num1 = $_POST["birth_num1_inform"];

		$title_num2 = $_POST["title_num2_inform"];
		$name_num2 = $_POST["name_num2_inform"];
		$last_num2 = $_POST["last_num2_inform"];
		$birth_num2 = $_POST["birth_num2_inform"];
	}

	//ฐานข้อมูล insuree ส่วนผู้เอาประกัน
	$title = $_POST["title_inform"];
	$name = $_POST["name_inform"];
	$last = $_POST["last_inform"];
	$person = $_POST["person_inform"];
	$vocation = $_POST["id_vocation_inform"];
	$career = $_POST["in_career_inform"];
	$SendAdd = $SendAdd1;
	//$SendAdd = $_POST["SendAdd_2"];
	$add = $_POST["add_inform"];
	$group = $_POST["group_inform"];
	$town = $_POST["town_inform"];
	$lane = $_POST["lane_inform"];
	$road = $_POST["road_inform"];
	$tumbon = $_POST["tumbon_inform"];
	$amphur = $_POST["amphur_inform"];
	$postal = $_POST["postal_inform"];
	$province = $_POST["province_inform"];
	$arr_tel_mobile = explode("-", $_POST["tel_mobile_inform"]);
	$tel_mobile = $arr_tel_mobile[0] . $arr_tel_mobile[1] . $arr_tel_mobile[2];
	$arr_tel_mobile2 = explode("-", $_POST["tel_mobile2_inform"]);
	$tel_mobile2 = $arr_tel_mobile2[0] . $arr_tel_mobile2[1] . $arr_tel_mobile2[2];

	/*$arr_tel_home = explode("-",$_POST["tel_home"]);
	$tel_home = $arr_tel_home[0].$arr_tel_home[1].$arr_tel_home[2].$_POST["tel_home2"];
	*/
	$tel_home = $_POST["tel_home_inform"];

	/*
	$arr_tel_fax = explode("-",$_POST["tel_fax"]);
	$tel_fax = $arr_tel_fax[0].$arr_tel_fax[1].$arr_tel_fax[2];
	*/
	$tel_fax = $_POST["tel_fax_inform"];

	$email = $_POST["email_inform"];
	$email_cc = $_POST["email2_inform"];
	$id_line = $_POST["id_line_inform"];
	$status  = "N";
	$status_sms = "N";
	$status_insured = "N";
	$status_company = "N";
	$st_email = "N";
	$st_sms = "N";


	//ฐานข้อมูล detail เกี่ยวกับรถ
	$car_id = $_POST["car_id_inform"];
	$br_car = $_POST["br_car_inform"];
	$mo_car = $_POST["mo_car_inform"];
	$car_body =  $_POST["car_body_inform"];
	$n_motor = $_POST["n_motor_inform"];

	if ($_POST["chose_carregis_inform"] != 1) {
		$car_regis = $_POST["car_regis_inform"];
	} else {
		$strSQL = "SELECT car_regis FROM detail WHERE car_regis LIKE '%ปดF%' ORDER BY car_regis DESC LIMIT 0,1";
		$result = $_contextFour->query($strSQL);
		$result_carregis = $result->fetch(2);
		$resplit = $result_carregis['car_regis'];
		list($re, $carpd) = explode('F', $resplit);

		if ($carpd == "") {
			$carpd = "0049";
		}

		$idSum = $carpd + 1;
		$sumstr = strlen($idSum);
		$zero = str_repeat("0", 4 - $sumstr);
		$car_regis = 'ปดF' . $zero . $idSum;
	}

	$car_regis_pro = $_POST["car_regis_pro_inform"];
	$car_color = $_POST["car_color_inform"];
	$car_cc = $_POST["car_cc_inform"];
	$cc = $_POST["cc_inform"];
	$car_seat = $_POST["car_seat_inform"];
	$car_wg = $_POST["wg_inform"];
	$gear = $_POST["gear_inform"];
	$regis_date = $_POST["regis_date_inform"];
	$cat_car = $_POST["cat_car_inform"];

	$car_detail1 = $_POST["acc1_inform"];
	$car_detail2 = $_POST["acc2_inform"];
	$car_detail3 = $_POST["acc3_inform"];
	$car_detail4 = $_POST["acc4_inform"];
	$car_detail_p1 = $_POST["acccost1_inform"];
	$car_detail_p2 = $_POST["acccost2_inform"];
	$car_detail_p3 = $_POST["acccost3_inform"];
	$car_detail_p4 = $_POST["acccost4_inform"];

	//ความคุ้มครอง
	$damage_out1 = $_POST["damage_out1_inform"];
	$damage_cost = $_POST["damage_cost_inform"];
	$pa1 = $_POST["pa1_inform"];
	$pa2 = $_POST["pa2_inform"];
	$pa3 = $_POST["pa3_inform"];
	$pa4 = $_POST["pa4_inform"];
	$people = $_POST["people_inform"];
	$cost = $_POST["cost_inform"];

	//เบี้ยประกัน
	$pre = $_POST["pre_inform"];
	$one = $_POST["one_inform"]; //ความเสียหายส่วนแรก
	$disone = $_POST["disone_inform"];
	$dis_driver = $_POST["driver_inform"]; // ส่วนลด % ระบุผู้ขับขี่							
	$total_dis1 = 0.00; // ส่วนลด
	$good = $_POST["good_inform"];
	if ($_POST['goodb_inform'] == '0') {
		$total_dis2 = $_POST["total_dis2_inform"]; // ส่วนลด
	} else if ($_POST['goodb_inform'] != '0') {
		$total_dis2 = $_POST['goodb_inform'];
	}
	$group3 = $_POST["group3_inform"]; // 10%
	$dis_group3 = $_POST["dis_group3_inform"]; // รวมส่วนลดกลุ่ม
	$total_dis3 = $_POST["total_dis3_inform"]; // ส่วนลดตัวแทน
	$dis_vip = $_POST["dis_vip_inform"]; // ส่วนลดเป็น %
	$total_vip = $_POST["total_vip_inform"]; // -ส่วนลด
	$pro_dis = $_POST["pro_dis_inform"]; // -ส่วนลดพิเศษ
	$total_pro_dis = $_POST["total_pro_dis_inform"]; // -ส่วนลดพิเศษ
	$total_dis4 = $_POST["total_dis4_inform"]; // รวมส่วนลดเป้น %
	$total_pre = $_POST["total_pre_inform"];
	$total_stamp = $_POST["total_stamp_inform"];
	$total_vat = $_POST["total_vat_inform"];
	$total_sum = $_POST["total_sum_inform"];

	// พรบ 
	$sql_prb = " SELECT * FROM tb_costprp WHERE id_prb = '" . $_POST["currentText_prb_inform"] . "' ";
	$result_prb = $_contextFour->query($sql_prb);
	$fetcharr_prb = $result_prb->fetch(2);

	$prb_net = $fetcharr_prb["prp"];
	$prb_stamp = $fetcharr_prb["stamp"];
	$prb_tax = $fetcharr_prb["tax"];
	$prb = $fetcharr_prb["net"];

	//$prb = $_POST["currentValue_prb"];


	$p_id = $_POST["currentText_prb_inform"]; //พรบ.
	$p_pre = "";
	$p_stamp = "";
	$p_tax = "";
	if ($_POST["currentValue_prb_inform"] == '0.00' || $_POST["currentValue_prb_inform"] <= 0 || empty($_POST["currentValue_prb_inform"])) {
		$p_net = '0'; //พรบ.
	} else {
		$p_net = $_POST["currentValue_prb_inform"]; //พรบ.
	}

	$total_prb = $_POST["total_prb_inform"];
	$commition = $_POST["commition_inform"];
	$other = $_POST["other_inform"];
	$vat_1 = $_POST["vat_1_inform"];
	$vat_2 = $_POST["vat_2_inform"];
	$vehicle_tax = $_POST["vehicle_tax_inform"];
	$service_charge = $_POST["service_charge_inform"];
	$total_commition = $_POST["total_commition_inform"];
	$status_vip = $_POST["status_vip_inform"];

	// นัดตรวจสภาพรถ
	$checkcar_time = $_POST["checkcar_time_inform"];
	if ($checkcar_time == 1) {
		$checkcar_time_con = "เช้า (08:00 - 12:00)";
	}
	if ($checkcar_time == 2) {
		$checkcar_time_con = "บ่าย (12:00 - 15:00)";
	}
	if ($checkcar_time == 3) {
		$checkcar_time_con = "เย็น (15:00 - 18:00)";
	}

	if ($_POST["commentse1_inform"] == "1") {
		$list_customer1 = "ตรวจสภาพรถวันที่ " . $_POST["checkcar_date_inform"] . " " . $checkcar_time_con . " ติดต่อ " . $_POST["contact_name_list_inform"] . " โทร " . $_POST["contact_number_inform"];
	}

	// ส่งกรมธรรม์
	if ($_POST["check_R1_inform"] == 1) {
		$status_1 = "พร้อมเก็บเงิน วันที่ ";
	} else if ($_POST["check_R1_inform"] == 2) {
		$status_1 = "พร้อมวางบิล วันที่ ";
	}

	if ($_POST["commentse2_inform"] == "2") {
		$list_customer2 = "ส่งกรมธรรม์ " . $status_1 . $_POST["date_SP_inform"] . " ติดต่อ " . $_POST["contact_name_list_1_inform"] . " โทร " . $_POST["contact_number_1_inform"];
	}

	// จ่ายแล้ว
	if ($_POST["check_R2_inform"] == 3) {
		$status_2 = "เข้าบริษัท";
	} else if ($_POST["check_R2_inform"] == 4) {
		$status_2 = "เข้าบริษัทประกัน";
	}

	$instance_1 = $_POST["instance_1_inform"];
	if ($instance_1 == '1') {
		$instance_1_txt = "1 งวด";
	}
	if ($instance_1 == '2') {
		$instance_1_txt = "2 งวด";
	}
	if ($instance_1 == '3') {
		$instance_1_txt = "3 งวด";
	}
	if ($instance_1 == '4') {
		$instance_1_txt = "4 งวด";
	}
	if ($instance_1 == '5') {
		$instance_1_txt = "5 งวด";
	}
	if ($instance_1 == '6') {
		$instance_1_txt = "6 งวด";
	}

	$instance_1_cut = $_POST["instance_1_cut_inform"];
	if ($instance_1_cut == '1') {
		$instance_1_cut_txt = "1 งวด";
	}
	if ($instance_1_cut == '2') {
		$instance_1_cut_txt = "2 งวด";
	}
	if ($instance_1_cut == '3') {
		$instance_1_cut_txt = "3 งวด";
	}
	if ($instance_1_cut == '4') {
		$instance_1_cut_txt = "4 งวด";
	}

	$bankoperation_1 = $_POST["bankoperation_1_inform"];
	if ($bankoperation_1 == 'NON') {
		$bankoperation_1_txt = "ผ่าน ธ.ไม่ระบุ";
	}
	if ($bankoperation_1 == 'SCB') {
		$bankoperation_1_txt = "ผ่าน ธ.ไทยพาณิชย์";
	}
	if ($bankoperation_1 == 'KBANK') {
		$bankoperation_1_txt = "ผ่าน ธ.กสิกรไทย";
	}
	if ($bankoperation_1 == 'BBL') {
		$bankoperation_1_txt = "ผ่าน ธ.กรุงเทพ";
	}
	if ($bankoperation_1 == 'BAY') {
		$bankoperation_1_txt = "ผ่าน ธ.กรุงศรี";
	}
	if ($bankoperation_1 == 'KTB') {
		$bankoperation_1_txt = "ผ่าน ธ.กรุงไทย";
	}
	if ($bankoperation_1 == 'CEN') {
		$bankoperation_1_txt = "ผ่าน เซ็นทรัล การ์ด";
	}
	if ($bankoperation_1 == 'ROB') {
		$bankoperation_1_txt = "ผ่าน โรบันสัน การ์ด";
	}

	$payment_1 = $_POST["payment_1_inform"];
	if ($payment_1 == 1) {
		$payment_1_txt = "เงินสด";
	}
	if ($payment_1 == 2) {
		$payment_1_txt = "เช็ค " . $bankoperation_1_txt;
	}
	if ($payment_1 == 3) {
		$payment_1_txt = "ตัดบัตรเครดิตเต็มจำนวน";
	}
	if ($payment_1 == 4) {
		$payment_1_txt = "Bill Payment " . $bankoperation_1_txt;
	}
	if ($payment_1 == 5) {
		$payment_1_txt = "ผ่อนชำระ " . $instance_1_txt . " " . $bankoperation_1_txt;
	}
	if ($payment_1 == 6) {
		$payment_1_txt = "ผ่อนชำระ 0% " . $instance_1_txt . " " . $bankoperation_1_txt;
	}
	if ($payment_1 == 7) {
		$payment_1_txt = "counter service";
	}
	if ($payment_1 == 8) {
		$payment_1_txt = "ผ่อนชำระเงินสด " . $instance_1_cut_txt;
	}

	if ($_POST["commentse3_inform"] == "3") {
		$list_customer3 = "ชำระเงิน " . $status_2 . " วันที่ " . $_POST["payment_date_inform"] . " โดย " . $payment_1_txt;
	}

	// กำลังทำจ่าย
	if ($_POST["check_R3_inform"] == 5) {
		$status_3 = "เข้าบริษัท";
	} else if ($_POST["check_R3_inform"] == 6) {
		$status_3 = "เข้าบริษัทประกัน";
	}

	$instance_2 = $_POST["instance_2_inform"];
	if ($instance_2 == '1') {
		$instance_2_txt = "1 งวด";
	}
	if ($instance_2 == '2') {
		$instance_2_txt = "2 งวด";
	}
	if ($instance_2 == '3') {
		$instance_2_txt = "3 งวด";
	}
	if ($instance_2 == '4') {
		$instance_2_txt = "4 งวด";
	}
	if ($instance_2 == '5') {
		$instance_2_txt = "5 งวด";
	}
	if ($instance_2 == '6') {
		$instance_2_txt = "6 งวด";
	}

	$instance_2_cut = $_POST["instance_2_cut_inform"];
	if ($instance_2_cut == '1') {
		$instance_2_cut_txt = "1 งวด";
	}
	if ($instance_2_cut == '2') {
		$instance_2_cut_txt = "2 งวด";
	}
	if ($instance_2_cut == '3') {
		$instance_2_cut_txt = "3 งวด";
	}
	if ($instance_2_cut == '4') {
		$instance_2_cut_txt = "4 งวด";
	}

	$bankoperation_2 = $_POST["bankoperation_2_inform"];
	if ($bankoperation_2 == 'NON') {
		$bankoperation_2_txt = "ผ่าน ธ.ไม่ระบุ";
	}
	if ($bankoperation_2 == 'SCB') {
		$bankoperation_2_txt = "ผ่าน ธ.ไทยพาณิชย์";
	}
	if ($bankoperation_2 == 'KBANK') {
		$bankoperation_2_txt = "ผ่าน ธ.กสิกรไทย";
	}
	if ($bankoperation_2 == 'BBL') {
		$bankoperation_2_txt = "ผ่าน ธ.กรุงเทพ";
	}
	if ($bankoperation_2 == 'BAY') {
		$bankoperation_2_txt = "ผ่าน ธ.กรุงศรี";
	}
	if ($bankoperation_2 == 'KTB') {
		$bankoperation_2_txt = "ผ่าน ธ.กรุงไทย";
	}
	if ($bankoperation_2 == 'CEN') {
		$bankoperation_2_txt = "ผ่าน เซ็นทรัล การ์ด";
	}
	if ($bankoperation_2 == 'ROB') {
		$bankoperation_2_txt = "ผ่าน โรบันสัน การ์ด";
	}

	$payment_2 = $_POST["payment_2_inform"];
	if ($payment_2 == 1) {
		$payment_2_txt = "เงินสด";
	}
	if ($payment_2 == 2) {
		$payment_2_txt = "เช็ค " . $bankoperation_2_txt;
	}
	if ($payment_2 == 3) {
		$payment_2_txt = "ตัดบัตรเครดิตเต็มจำนวน";
	}
	if ($payment_2 == 4) {
		$payment_2_txt = "Bill Payment " . $bankoperation_2_txt;
	}
	if ($payment_2 == 5) {
		$payment_2_txt = "ผ่อนชำระ " . $instance_2_txt . " " . $bankoperation_2_txt;
	}
	if ($payment_2 == 6) {
		$payment_2_txt = "ผ่อนชำระ 0% " . $instance_2_txt . " " . $bankoperation_2_txt;
	}
	if ($payment_2 == 7) {
		$payment_2_txt = "counter service";
	}
	if ($payment_2 == 8) {
		$payment_2_txt = "ผ่อนชำระเงินสด " . $instance_2_cut_txt;
	}

	if ($_POST["commentse4_inform"] == "4") {
		$list_customer4 = "กำลังทำจ่าย " . $status_3 . " วันที่ " . $_POST["payment_in_inform"] . " โดย " . $payment_2_txt . " โทร " . $_POST["contact_number_2_inform"];
	}
	// ยังไม่จ่าย
	$D_day = $_POST["D_day_inform"];
	if ($D_day == '1') {
		$D_day_txt = "15 วัน";
	}
	if ($D_day == '2') {
		$D_day_txt = "30 วัน";
	}
	if ($D_day == '3') {
		$D_day_txt = "45 วัน";
	}
	if ($D_day == '4') {
		$D_day_txt = "60 วัน";
	}

	if ($_POST["check_R4_inform"] == 7) {
		$status_4 = "นัดอีกครั้ง";
	} else if ($_POST["check_R4_inform"] == 8) {
		$status_4 = "วางบิลบริษัท";
	} else if ($_POST["check_R4_inform"] == 9) {
		$status_4 = "วางบิลคู่ค้า/ดิลเลอร์";
	} else if ($_POST["check_R4_inform"] == 10) {
		$status_4 = "วางบิลตัวแทน";
	} else if ($_POST["check_R4_inform"] == 11) {
		$status_4 = "เครดิต " . $D_day_txt;
	} else if ($_POST["check_R4_inform"] == 12) {
		$status_4 = "ออก กธ. แล้ว ";
	}

	if ($_POST["commentse5_inform"] == "5") {
		$list_customer = "ยังไม่จ่าย " . $status_4 . " ติดต่อ " . $_POST["contact_name_list_3_inform"] . " โทร " . $_POST["contact_number_3_inform"];
	}

	// ของแถม 
	if ($_POST["commentse6_inform"] == "6") {
		$list_customer5 = $_POST["other_s_inform"];
	}

	if ($_POST["commentse7_inform"] == "7") {
		if ($_POST["commentse6_inform"] == "6") {
			$list_customer5 = 'แมสวิ่งพร้อมเก็บเงิน ' . $_POST["other_s_inform"];
		} else {
			$list_customer5 = 'แมสวิ่งพร้อมเก็บเงิน';
		}
	}

	//อู่รถ
	$fac1 = $_POST["facsave1_inform"];
	$fac2 = $_POST["facsave2_inform"];
	$fac3 = $_POST["facsave3_inform"];

	// ประเภทการจ่าย
	if ($payment_1 != '0') {
		$detail_pay = $payment_1;
	} else if ($payment_2 != '0') {
		$detail_pay = $payment_2;
	} else {
		$detail_pay = '-';
	}
	if ((similar_text($com_data, 'VIB_S') == 5) && ($doc_type == '2+' || $doc_type == '3+')) {
		$typeofdata = '5';
	} else {
		$typeofdata = '';
	}

	function chksaka($comdata, $_contextFour ,$typeofdata)
	{
		$comdatanew = substr($comdata, 5, 3);
		$sql = "SELECT * FROM tb_inform WHERE sort = 'MV' AND `status`='1' AND saka = '$comdatanew' AND typeofdata = '$typeofdata' ORDER BY num_inform ASC LIMIT 1";
		$result = $_contextFour->query($sql);
		$fetcharr = $result->fetch();
		if (empty($fetcharr)) return false;
		$sort = $fetcharr["sort"];
		$id_data = $fetcharr["num_inform"];
		return  array($sort, $id_data);
	}
	//กรอกฐานข้อมูลแรก

	if ($com_data == 'VIB_S') {
		$sql = "SELECT * FROM tb_inform WHERE sort='VIB_S' AND `status`='1' AND typeofdata = '$typeofdata' ORDER BY num_inform ASC LIMIT 1";
		$result = $_contextFour->query($sql);
		$fetcharr = $result->fetch(2);
		$sort = $fetcharr["sort"];
		$id_data = $fetcharr["num_inform"];
	} else if ($com_data == 'VIB_S103') {
		$sql = "SELECT * FROM tb_inform WHERE sort='VIB_S103' AND `status`='1' AND typeofdata = '$typeofdata'  ORDER BY num_inform ASC LIMIT 1";
		$result = $_contextFour->query($sql);
		$fetcharr = $result->fetch(2);
		$sort = $fetcharr["sort"];
		$id_data = $fetcharr["num_inform"];
	} else if ($com_data == 'VIB_S09712') {
		$sql = "SELECT * FROM tb_inform WHERE sort='VIB_S' AND `status`='1' AND typeofdata = '$typeofdata'  ORDER BY num_inform ASC LIMIT 1";
		$result = $_contextFour->query($sql);
		$fetcharr = $result->fetch(2);
		$sort = $fetcharr["sort"];
		$id_data = $fetcharr["num_inform"];
	} else if ($com_data == 'BKI[MBLT]' && $doc_type == '1' && $ty_inform == 'L') {
		$id_data_mblt = date('y') . 'FOUR' . date('m');
		$strSQL = "SELECT id_data FROM `data` WHERE com_data = 'BKI[MBLT]' AND id_data LIKE '$id_data_mblt%' ORDER BY id DESC LIMIT 0,1";
		$result22 = $_contextFour->query($strSQL);
		$result_data = $result22->fetch(2);
		$datasplit = $result_data['id_data'];
		$iddatamblt = str_replace($id_data_mblt, "", $datasplit);
		if ($iddatamblt == "") {
			$iddatamblt = "000";
		}
		$iddatasum = $iddatamblt + 1;
		$sumstrdata = strlen($iddatasum);
		$zerodata = str_repeat("0", 3 - $sumstrdata);
		$id_data = $id_data_mblt . $zerodata . $iddatasum;
	} else {

		$res = chksaka($com_data, $_contextFour ,$typeofdata);

		if (!$res) {
			if (similar_text($com_data, 'VIB_S') == 5) {
				$id_data = '';
			} else {
				$sql = "SELECT * FROM tb_inform WHERE sort='MY4IB' AND `status`='1' AND typeofdata = '$typeofdata' ORDER BY num_inform ASC LIMIT 1";
				$result = $_contextFour->query($sql);
				$fetcharr = $result->fetch();
				$sort = $fetcharr["sort"];
				$id_data = $fetcharr["num_inform"];
			}
		} else {
			$sort = $res[0];
			$id_data = $res[1];
		}
	}

	if ($id_data == '') {
		$returnedArray['msg'] = "Error : เลขรับแจ้งหมด/ไม่มีเลขรับแจ้งตามสาขา กรุณาติดต่อผู้ดูแลระบบ!";
		$returnedArray['id'] = 'false';
		echo json_encode($returnedArray);
		exit();
	}

	// Uploadfile
	/*
	if (is_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name']))
	{
		$file_name = $HTTP_POST_FILES['userfile']['name'];
		$arraypic = explode(".",$file_name);
		$lastname = strtolower($arraypic);
		$filename = $arraypic[0];
		$filetype = $arraypic[1];
		
		$file_up=time().".".$filetype;  
				
		copy($HTTP_POST_FILES['userfile']['tmp_name'], "../Myfile/$file_up");	 
	}
	
	
	global $HTTP_POST_FILES;
	$timestamp = time();
	$iddtastamp = split("/",$id_data);
	$fileTypes = array('jpg','jpeg','gif','png'.'pdf'); // File extensions
	$fileParts = pathinfo($HTTP_POST_FILES['userfile']['name']);
	$tempFile = $HTTP_POST_FILES['userfile']['tmp_name'];
	$realname =$login."_".$timestamp."(".substr($iddtastamp[0],0,2).$iddtastamp[2].").".$fileParts['extension']; // สำหรับบันทึกลง  // Myfile ไม่มีชืื่อภาพ
	$realname_DB =$_POST['name_pay']."_".$login."_".$timestamp."(".substr($iddtastamp[0],0,2).$iddtastamp[2].").".$fileParts['extension']; // ลง database ไม่ต้องแปลง iconv มีชื่อภาพ
	
	if (is_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name']))
	{
		copy($HTTP_POST_FILES['userfile']['tmp_name'], "Myfile/$realname");

		if($_POST['name_pay'] !='')
		{
			if($_POST['payfile'] =='')
			{
				$strSQL = "UPDATE `data` SET `pay_file`='".$realname_DB."', `user_file`='".$_POST['name_inform']."' WHERE `data`.`id_data` ='".$id_data."' LIMIT 1 ;";
				$objQuery = mysql_query($strSQL);	
			}
			else
			{
				$strSQL = "UPDATE `data` SET `pay_file`='".$_POST['payfile']."|".$realname_DB."' , `user_file`='".$_POST['name_inform']."' WHERE `data`.`id_data` ='".$id_data."' LIMIT 1 ;";
				$objQuery = mysql_query($strSQL);	
			}
		}
	
	}
	*/

	if ($actCheck == '1') {
		$sqlq = "SELECT * FROM tb_inform WHERE sort='ACT' AND status='1' AND typeofdata = '$typeofdata'  ORDER BY id ";
		$resultq = $_contextFour->query($sqlq);
		$fetcharrq = $resultq->fetch(2);
		$sort = $fetcharrq["sort"];
		$act = $fetcharrq["num_inform"];
		$strSQLqq = "UPDATE tb_inform SET `status` = '2'  WHERE num_inform = '$act'  AND  `status` = '1'  ";
		$objQueryqq = $_contextFour->prepare($strSQLqq)->execute();
	} else if ($actCheck == '2') {
		$sqlq = "SELECT * FROM tb_inform WHERE sort='ACTBKI' AND `status`='1' AND typeofdata = '$typeofdata' ORDER BY id ";
		$resultq = $_contextFour->query($sqlq);
		$fetcharrq = $resultq->fetch(2);
		$sort = $fetcharrq["sort"];
		$act = $fetcharrq["num_inform"];
		$strSQLqq = "UPDATE tb_inform SET `status` = '2'  WHERE num_inform = '$act'  AND  `status` = '1'  ";
		$objQueryqq = $_contextFour->prepare($strSQLqq)->execute();
	}
	
	$strSQL = "UPDATE tb_inform SET `status` = '2'  WHERE num_inform = '$id_data'  AND (`status` = '1' OR `status` = '3')";
	$objQuery = $_contextFour->prepare($strSQL)->execute();
	if ($code == '' && $code2 == '') {
		$strSQL = "SELECT code FROM  tb_customer WHERE code ORDER BY code DESC LIMIT 0,1";
		$result_c = $_contextFour->query($strSQL);
		$result_cu = $result_c->fetch(2);
		$resplit_c = $result_cu['code'];
		$year = date('y');
		if ($resplit_c == "") {

			$code_new = $year . '0000' + 1;
		} else {

			$code_new = $resplit_c + 1;
		}

		if ($person == '1') {
			$strsql = "INSERT INTO tb_customer ( code , person, icard , title, `name`, `last`, `add`,  `group`,  `town` ,lane, road, province, amphur, tumbon, postal , email, tel_mobile,  tel_home, tel_fax, status_vip)
values ('$code_new', '$person', '$icard','$title', '$name','$last','$add', '$group', '$town', '$lane', '$road', '$province', '$amphur' , '$tumbon', '$postal', '$email' , '$tel_mobile' ,'$tel_home','$tel_fax','$status_vip')";
			$objQuery = $_contextFour->prepare($strsql)->execute();

			$strSQL = "INSERT INTO insuree (`id`, `id_data`, `title`, `name`, `last`, `person`, `vocation`, `career`, `add`, `group`, `town`, `lane`, `road`, `tumbon`, `amphur`, `province`, `postal`, `tel_mobile`, `tel_mobile2`, `tel_home`, `tel_fax`, `email`,`email_cc`,`id_line`, `status`, `status_sms`, `status_insured`, `status_company`, `st_email`, `st_sms`, `icard`, `cus_code`, `status_vip`, `SendAdd`, `status_SendAdd`) VALUES (NULL, '$id_data', '$title', '$name', '$last', '$person', '$vocation', '$career', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_mobile', '$tel_mobile2', '$tel_home', '$tel_fax', '$email',  '$email_cc','$id_line','$status', '$status_sms', '$status_insured', '$status_company', '$st_email', '$st_sms', '$icard','$code_new','$status_vip','$SendAdd','$status_SendAdd')";
			$objQuery = $_contextFour->prepare($strSQL)->execute();
		}
		if ($person == '2') {
			$strsql = "INSERT INTO tb_customer ( code , person, id_business , title, `name`, `last`, `add`,  `group`,  `town` ,lane, road, province, amphur, tumbon, postal , email, tel_mobile,  tel_home, tel_fax, status_vip)
values ('$code_new', '$person', '$icard','$title', '$name','$last','$add', '$group', '$town', '$lane', '$road', '$province', '$amphur' , '$tumbon', '$postal', '$email' , '$tel_mobile' ,'$tel_home','$tel_fax','$status_vip')";
			$objQuery = $_contextFour->prepare($strsql)->execute();

			$strSQL = "INSERT INTO insuree (`id`, `id_data`, `title`, `name`, `last`, `person`, `vocation`, `career`, `add`, `group`, `town`, `lane`, `road`, `tumbon`, `amphur`, `province`, `postal`, `tel_mobile`, `tel_mobile2`, `tel_home`, `tel_fax`, `email`,`email_cc`,`id_line`, `status`, `status_sms`, `status_insured`, `status_company`, `st_email`, `st_sms`, `id_business`, `cus_code`, `status_vip`, `SendAdd`, `status_SendAdd`  ) VALUES (NULL, '$id_data', '$title', '$name', '$last', '$person', '$vocation', '$career', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_mobile', '$tel_mobile2', '$tel_home', '$tel_fax', '$email',  '$email_cc','$id_line','$status', '$status_sms', '$status_insured', '$status_company', '$st_email', '$st_sms', '$icard','$code_new','$status_vip','$SendAdd','$status_SendAdd')";
			$objQuery = $_contextFour->prepare($strSQL)->execute();
		}
		if ($person == '3') {
			$strsql = "INSERT INTO tb_customer ( code , person, icard, id_business, title, `name`, `last`, `add`,  `group`,  `town` ,lane, road, province, amphur, tumbon, postal , email, tel_mobile,  tel_home, tel_fax, status_vip)
values ('$code_new', '$person', '$icard', '$niti','$title', '$name','$last','$add', '$group', '$town', '$lane', '$road', '$province', '$amphur' , '$tumbon', '$postal', '$email' , '$tel_mobile' ,'$tel_home','$tel_fax','$status_vip')";
			$objQuery = $_contextFour->prepare($strsql)->execute();

			$strSQL = "INSERT INTO insuree (`id`, `id_data`, `title`, `name`, `last`, `person`, `vocation`, `career`, `add`, `group`, `town`, `lane`, `road`, `tumbon`, `amphur`, `province`, `postal`, `tel_mobile`, `tel_mobile2`, `tel_home`, `tel_fax`, `email`,`email_cc`,`id_line`, `status`, `status_sms`, `status_insured`, `status_company`, `st_email`, `st_sms`, `icard`, `cus_code`, `status_vip`, `id_business`, `SendAdd` , `status_SendAdd`  ) VALUES (NULL, '$id_data', '$title', '$name', '$last', '$person', '$vocation', '$career', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_mobile', '$tel_mobile2', '$tel_home', '$tel_fax', '$email',  '$email_cc','$id_line','$status', '$status_sms', '$status_insured', '$status_company', '$st_email', '$st_sms', '$icard','$code_new','$status_vip','$niti','$SendAdd','$status_SendAdd')";
			$objQuery = $_contextFour->prepare($strSQL)->execute();
		}
	} else if ($code != '' && $code2 == '') {
		if ($person == '1') {
			$strsql = "UPDATE tb_customer SET person='$person', icard='$icard' , title='$title', name='$name', last='$last',  `add`='$add',  `group`='$group',  `town`='$town', lane='$lane', road='$road', province='$province', amphur='$amphur', tumbon='$tumbon', postal='$postal', email='$email', tel_mobile='$tel_mobile',  tel_home='$tel_home', tel_fax='$tel_fax', status_vip='$status_vip' where code='$code' ";
			$objQuery = $_contextFour->prepare($strsql)->execute();

			$strSQL = "INSERT INTO insuree (`id`, `id_data`, `title`, `name`, `last`, `person`, `vocation`, `career`, `add`, `group`, `town`, `lane`, `road`, `tumbon`, `amphur`, `province`, `postal`, `tel_mobile`, `tel_mobile2`, `tel_home`, `tel_fax`, `email`,`email_cc`,`id_line`, `status`, `status_sms`, `status_insured`, `status_company`, `st_email`, `st_sms`, `icard`, `cus_code`, `status_vip`, `SendAdd`, `status_SendAdd` ) VALUES (NULL, '$id_data', '$title', '$name', '$last', '$person', '$vocation', '$career', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_mobile', '$tel_mobile2', '$tel_home', '$tel_fax', '$email',  '$email_cc','$id_line','$status', '$status_sms', '$status_insured', '$status_company', '$st_email', '$st_sms', '$icard','$code','$status_vip','$SendAdd','$status_SendAdd')";
			$objQuery = $_contextFour->prepare($strSQL)->execute();
		}
		if ($person == '2') {
			$strsql = "UPDATE tb_customer SET person='$person', id_business='$icard' , title='$title', name='$name', last='$last',  `add`='$add',  `group`='$group',  `town`='$town', lane='$lane', road='$road', province='$province', amphur='$amphur', tumbon='$tumbon', postal='$postal', email='$email', tel_mobile='$tel_mobile',  tel_home='$tel_home', tel_fax='$tel_fax', status_vip='$status_vip' where code='$code' ";
			$objQuery = $_contextFour->prepare($strsql)->execute();

			$strSQL = "INSERT INTO insuree (`id`, `id_data`, `title`, `name`, `last`, `person`, `vocation`, `career`, `add`, `group`, `town`, `lane`, `road`, `tumbon`, `amphur`, `province`, `postal`, `tel_mobile`, `tel_mobile2`, `tel_home`, `tel_fax`, `email`,`email_cc`,`id_line`, `status`, `status_sms`, `status_insured`, `status_company`, `st_email`, `st_sms`, `id_business`, `cus_code`, `status_vip`, `SendAdd`, `status_SendAdd` ) VALUES (NULL, '$id_data', '$title', '$name', '$last', '$person', '$vocation', '$career', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_mobile', '$tel_mobile2', '$tel_home', '$tel_fax', '$email',  '$email_cc','$id_line','$status', '$status_sms', '$status_insured', '$status_company', '$st_email', '$st_sms', '$icard','$code','$status_vip','$SendAdd','$status_SendAdd')";
			$objQuery = $_contextFour->prepare($strSQL)->execute();
		}
		if ($person == '3') {
			$strsql = "UPDATE tb_customer SET person='$person', icard='$icard' , id_business='$initi' , title='$title', name='$name', last='$last',  `add`='$add',  `group`='$group',  `town`='$town', lane='$lane', road='$road', province='$province', amphur='$amphur', tumbon='$tumbon', postal='$postal', email='$email', tel_mobile='$tel_mobile',  tel_home='$tel_home', tel_fax='$tel_fax', status_vip='$status_vip' where code='$code' ";
			$objQuery = $_contextFour->prepare($strsql)->execute();

			$strSQL = "INSERT INTO insuree (`id`, `id_data`, `title`, `name`, `last`, `person`, `vocation`, `career`, `add`, `group`, `town`, `lane`, `road`, `tumbon`, `amphur`, `province`, `postal`, `tel_mobile`, `tel_mobile2`, `tel_home`, `tel_fax`, `email`,`email_cc`,`id_line`, `status`, `status_sms`, `status_insured`, `status_company`, `st_email`, `st_sms`, `icard`, `id_business`, `cus_code`, `status_vip`, `SendAdd`, `status_SendAdd`  ) VALUES (NULL, '$id_data', '$title', '$name', '$last', '$person', '$vocation', '$career', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_mobile', '$tel_mobile2', '$tel_home', '$tel_fax', '$email',  '$email_cc','$id_line','$status', '$status_sms', '$status_insured', '$status_company', '$st_email', '$st_sms', '$icard', '$niti','$code','$status_vip','$SendAdd','$status_SendAdd')";
			$objQuery = $_contextFour->prepare($strSQL)->execute();
		}
	} else if ($code == '' && $code2 != '') {
		if ($person == '1') {
			$strsql = "UPDATE tb_customer SET person='$person', icard='$icard' , title='$title', name='$name', last='$last',  `add`='$add',  `group`='$group',  `town`='$town', lane='$lane', road='$road', province='$province', amphur='$amphur', tumbon='$tumbon', postal='$postal', email='$email', tel_mobile='$tel_mobile',  tel_home='$tel_home', tel_fax='$tel_fax', status_vip='$status_vip' where code='$code2' ";
			$objQuery = $_contextFour->prepare($strsql)->execute();

			$strSQL = "INSERT INTO insuree (`id`, `id_data`, `title`, `name`, `last`, `person`, `vocation`, `career`, `add`, `group`, `town`, `lane`, `road`, `tumbon`, `amphur`, `province`, `postal`, `tel_mobile`, `tel_mobile2`, `tel_home`, `tel_fax`, `email`,`email_cc`,`id_line`, `status`, `status_sms`, `status_insured`, `status_company`, `st_email`, `st_sms`, `icard`, `cus_code` , `status_vip`, `SendAdd`, `status_SendAdd`) VALUES (NULL, '$id_data', '$title', '$name', '$last', '$person', '$vocation', '$career', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_mobile', '$tel_mobile2', '$tel_home', '$tel_fax', '$email',  '$email_cc','$id_line','$status', '$status_sms', '$status_insured', '$status_company', '$st_email', '$st_sms', '$icard','$code2','$status_vip','$SendAdd','$status_SendAdd')";
			$objQuery = $_contextFour->prepare($strSQL)->execute();
		}
		if ($person == '2') {
			$strsql = "UPDATE tb_customer SET person='$person', `id_business`='$icard' , title='$title', `name`='$name', `last`='$last',  `add`='$add',  `group`='$group',  `town`='$town', lane='$lane', road='$road', province='$province', amphur='$amphur', tumbon='$tumbon', postal='$postal', email='$email', tel_mobile='$tel_mobile',  tel_home='$tel_home', tel_fax='$tel_fax', status_vip='$status_vip' where code='$code2' ";
			$objQuery = $_contextFour->prepare($strsql)->execute();

			$strSQL = "INSERT INTO insuree (`id`, `id_data`, `title`, `name`, `last`, `person`, `vocation`, `career`, `add`, `group`, `town`, `lane`, `road`, `tumbon`, `amphur`, `province`, `postal`, `tel_mobile`, `tel_mobile2`, `tel_home`, `tel_fax`, `email`,`email_cc`,`id_line`, `status`, `status_sms`, `status_insured`, `status_company`, `st_email`, `st_sms`, `id_business`, `cus_code` , `status_vip`, `SendAdd`,`status_SendAdd`) VALUES (NULL, '$id_data', '$title', '$name', '$last', '$person', '$vocation', '$career', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_mobile', '$tel_mobile2', '$tel_home', '$tel_fax', '$email',  '$email_cc','$id_line','$status', '$status_sms', '$status_insured', '$status_company', '$st_email', '$st_sms', '$icard','$code2','$status_vip','$SendAdd','$status_SendAdd')";
			$objQuery = $_contextFour->prepare($strSQL)->execute();
		}
		if ($person == '3') {
			$strsql = "UPDATE tb_customer SET person='$person', icard='$icard',id_business='$niti'  , title='$title', `name`='$name', `last`='$last',  `add`='$add',  `group`='$group',  `town`='$town', lane='$lane', road='$road', province='$province', amphur='$amphur', tumbon='$tumbon', postal='$postal', email='$email', tel_mobile='$tel_mobile',  tel_home='$tel_home', tel_fax='$tel_fax', status_vip='$status_vip' WHERE code='$code2' ";
			$objQuery = $_contextFour->prepare($strsql)->execute();

			$strSQL = "INSERT INTO insuree (`id`, `id_data`, `title`, `name`, `last`, `person`, `vocation`, `career`, `add`, `group`, `town`, `lane`, `road`, `tumbon`, `amphur`, `province`, `postal`, `tel_mobile`, `tel_mobile2`, `tel_home`, `tel_fax`, `email`,`email_cc`,`id_line`, `status`, `status_sms`, `status_insured`, `status_company`, `st_email`, `st_sms`, `icard`, `id_business`, `cus_code` , `status_vip`, `SendAdd`,`status_SendAdd`) VALUES (NULL, '$id_data', '$title', '$name', '$last', '$person', '$vocation', '$career', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_mobile', '$tel_mobile2', '$tel_home', '$tel_fax', '$email',  '$email_cc','$id_line','$status', '$status_sms', '$status_insured', '$status_company', '$st_email', '$st_sms', '$icard', '$niti','$code2','$status_vip','$SendAdd','$status_SendAdd')";
			$objQuery = $_contextFour->prepare($strSQL)->execute();
		}
	}

	$strSQL = "INSERT INTO act (`id`, `id_data`, `p_id`, `p_pre`, `p_stamp`, `p_tax`, `p_net`, `act_id`, `act_sort`, `vat_car`) VALUES (NULL, '$id_data',  '$p_id', '$p_pre', '$p_stamp', '$p_tax', '$p_net', '$act', '$act_sort', '$vat_car')";
	$objQuery = $_contextFour->prepare($strSQL)->execute();

	$strSQL = "INSERT INTO `data` (`id`, `login`, `com_data`, `send_date`, `id_data`, `ty_inform`, `o_insure`,  `start_date`, `end_date`, `name_inform`, `name_gain`, `service`, `idagent`, `list_customer1`, `list_customer2`, `list_customer3`, `list_customer4`, `list_customer5`, `pay_date`, `list_customer`, `doc_type`,`q_auto`,`detail_pay`,`id_data_old`,`status_pass1`,`status_pass2`,`status_pass3`,`status_pass4`) VALUES (NULL, '$login', '$com_data', NOW(), '$id_data', '$ty_inform', '$o_insure', '$start_date', '$end_date', '$name_inform', '$name_gain', '$service', '$idagent', '$list_customer1', '$list_customer2', '$list_customer3', '$list_customer4', '$list_customer5', '$pay_date', '$list_customer', '$doc_type', '$show_q_auto', '$detail_pay','$id_data_old','$status_pass1','$status_pass2','$status_pass3','$status_pass4')";
	$objQuery = $_contextFour->prepare($strSQL)->execute();

	$strSQL = "INSERT INTO detail (`id`, `id_data`, `car_id`, `br_car`, `mo_car`, `car_body`, `n_motor`, `car_regis`, `car_regis_pro`, `car_color`, `cc`, `car_cc`, `car_seat`,`car_wg`, `gear`, `regis_date`, `cat_car`, `car_detail`, `car_detail1`,`car_detail2`,`car_detail3`,`car_detail4`,`car_detail_p1`,`car_detail_p2`,`car_detail_p3`,`car_detail_p4`,`q_auto`,`single_rate`,`product`) VALUES (NULL, '$id_data', '$car_id', '$br_car', '$mo_car', '$car_body', '$n_motor', '$car_regis', '$car_regis_pro', '$car_color', '$cc', '$car_cc', '$car_seat','$car_wg',  '$gear', '$regis_date', '$cat_car', '$car_detail','$car_detail1','$car_detail2','$car_detail3','$car_detail4','$car_detail_p1','$car_detail_p2','$car_detail_p3','$car_detail_p4', '$show_q_auto','$single_rate','$product')";
	$objQuery = $_contextFour->prepare($strSQL)->execute();

	$strSQL = "INSERT INTO protect (`id`, `id_data`, `cost`, `damage_out1`, `damage_cost`, `pa1`, `pa2`, `pa3`, `pa4`, `people`) VALUES (NULL, '$id_data', '$cost', '$damage_out1', '$damage_cost', '$pa1', '$pa2', '$pa3', '$pa4', '$people')";
	$objQuery = $_contextFour->prepare($strSQL)->execute();

	$strSQL = "INSERT INTO driver (`id`, `id_data`, `title_num1`, `name_num1`, `last_num1`, `birth_num1`, `title_num2`, `name_num2`, `last_num2`, `birth_num2`) VALUES (NULL, '$id_data', '$title_num1', '$name_num1', '$last_num1', '$birth_num1', '$title_num2', '$name_num2', '$last_num2', '$birth_num2')";
	$objQuery = $_contextFour->prepare($strSQL)->execute();

	$strSQL = "INSERT INTO premium (`id`, `id_data`, `pre`, `one`, `disone`,`driver`, `dis1`, `good`, `dis2`, `group3`, `dis_group3`, `pro_dis`, `total_pro_dis`, `dis3`, `dis_vip`, `total_vip`, `total_dis4`, `total_pre`, `total_stamp`, `total_vat`, `total_sum`, `prb_net`, `prb_stamp`, `prb_tax`, `prb`, `total_prb`, `commition`, `other`, `vat_1`,`tax1prb`,`vehicle_tax`,`service_charge`, `total_commition`) VALUES (NULL, '$id_data', '$pre', '$one','$disone', '$dis_driver',  '$total_dis1', '$good', '$total_dis2', '$group3', '$dis_group3', '$pro_dis', '$total_pro_dis', '$total_dis3', '$dis_vip', '$total_vip', '$total_dis4', '$total_pre', '$total_stamp', '$total_vat', '$total_sum', '$prb_net', '$prb_stamp', '$prb_tax', '$prb', '$total_prb', '$commition', '$other', '$vat_1', '$vat_2', '$vehicle_tax', '$service_charge', '$total_commition')";
	$objQuery = $_contextFour->prepare($strSQL)->execute();

	$strSQL = "INSERT INTO `service` (`id`, `id_data`, `fac1`, `fac2`, `fac3`) VALUES (NULL, '$id_data', '$fac1', '$fac2', '$fac3')";
	$objQuery = $_contextFour->prepare($strSQL)->execute();

	if ($show_q_auto != '') {
		$strsql = "UPDATE quotation SET count_job='1' WHERE q_auto='$show_q_auto' ";
		$objQuery = $_contextFour->prepare($strsql)->execute();
	}
	$select_sql = "SELECT * FROM detail_renew WHERE id_detail = '" . $_GET['id_detail'] . "' AND id_data = '" . $_GET['id_data'] . "'";
	$select_query = $_contextMitsu->query($select_sql);
	$select_array = $select_query->fetch(2);
	$date_details = date('Y-m-d H:i:s'); // วันที่แจ้ง
	$updatesql = "UPDATE detail_renew SET lastrenew = '0' WHERE id_data = '" . $select_array['id_data'] . "'";
	$updatequery = $_contextMitsu->prepare($updatesql)->execute();
	$strsql = "INSERT INTO detail_renew (id_data,`status`,detailtext,detailcost,detail_doc_type,detailpayamount,date_alert,date_detail,userdetail,timecall,lastrenew,add_on,doc_type,add_on1,renew_ptype,renew_comp,renew_product,renew_id_cost,id_data_four) 
				VALUES ('$select_array[id_data]','E','$select_array[detailtext] (ปิดงาน)','$select_array[detailcost]','$select_array[detail_doc_type]','$select_array[detailpayamount]','$select_array[date_alert]','$date_details','$c_user',NOW(),'1','$select_array[add_on]','$select_array[doc_type]','$select_array[add_on1]','$select_array[renew_ptype]','$select_array[renew_comp]','$select_array[renew_product]','$select_array[renew_id_cost]','$id_data')";
	$objQuery = $_contextMitsu->prepare($strsql)->execute();

	if ($objQuery) {
		$Message = 'เเจ้งงานสำเร็จ';
		$Status = '200';
		$_tokenDevelop = 'vmYKjYPkgKgddOJwjhcc59nGKpkNunEVQQWvnkUkgbv'; // payment noti  
		$_tokenCancel = 'ol5KHy1JJHd1zlAEmUOU7vAKWnM1exo80AEib8HbLTR'; // cancel insurance 09712  
		$textContentLineNoti = 'ระบบดิลเลอร์เเจ้งงาน Mitsubishi' . "\r\n";
		$textContentLineNoti .= 'เลขรับแจ้ง : ' . $id_data . "\r\n";
		$textContentLineNoti .= 'Userlogin : ' . $useraction . "\r\n";
		$textContentLineNoti .= 'Message : ' . $Message . "\r\n";
		$textContentLineNoti .= 'Status : ' . $Status;
		LineNotificationControl::linenotify($_tokenDevelop, $textContentLineNoti);
		// LineNotificationControl::linenotify($_tokenCancel,$textContentLineNoti);
		$returnedArray['idperson'] = $person;
		$returnedArray['msg'] = "บันทึกข้อมูลเรียบร้อยแล้ว! เลขรับแจ้ง : " . $id_data;
		$returnedArray['id'] = base64_encode($id);
		echo json_encode($returnedArray);
	}
} else {
	$Message = 'เเจ้งงานไม่สำเร็จ';
	$Status = '500';
	$_tokenDevelop = 'vmYKjYPkgKgddOJwjhcc59nGKpkNunEVQQWvnkUkgbv'; // payment noti 
	$_tokenCancel = 'ol5KHy1JJHd1zlAEmUOU7vAKWnM1exo80AEib8HbLTR'; // cancel insurance 09712  
	$textContentLineNoti = 'ระบบดิลเลอร์เเจ้งงาน Mitsubishi' . "\r\n";
	$textContentLineNoti .= 'Userlogin : ' . $useraction . "\r\n";
	$textContentLineNoti .= 'Message : ' . $Message . "\r\n";
	$textContentLineNoti .= 'Status : ' . $Status;
	LineNotificationControl::linenotify($_tokenDevelop, $textContentLineNoti);
	// LineNotificationControl::linenotify($_tokenCancel,$textContentLineNoti);
	$returnedArray['msg'] = "กรุณาลงชื่อเข้าใช้ใหม่ !!!!!";
	echo json_encode($returnedArray);
}
