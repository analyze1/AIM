<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
require('../fpdf.php');
$_contextFour = PDO_CONNECTION::fourinsure_insured();
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

$IDDATA = $_GET['IDDATA'];

$query = "SELECT ";
$query .= "data.login, "; // รหัสผู้แจ้ง
$query .= "data.com_data, "; // รหัสผู้แจ้ง
$query .= "data.id_data, "; // เลขที่รับแจ้ง
$query .= "data.start_date, "; // วันที่คุ้มครอง
$query .= "data.end_date, "; // วันที่สิ้นสุด

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
$query .= "insuree.icard, ";

$query .= "act.act_id, ";

$query .= "tb_tumbon.name as tumbon_name, ";
$query .= "tb_amphur.name as amphur_name, ";
$query .= "tb_province.name as province_name, "; // จังหวัด

$query .= "tb_mo_car.name as mo_car_name, "; // รุ่นรถ

$query .= "tb_br_car.name as car_brand, "; // ยี่ห้อรถ

$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
$query .= "detail.mo_car, "; // ยี่ห้อรถ
$query .= "detail.car_body, "; // เลขตัวถัง
$query .= "detail.n_motor, "; // เลขเครื่อง
$query .= "detail.car_regis, "; // เลขเครื่อง
$query .= "detail.cat_car, ";
$query .= "detail.car_regis_pro ";
$query .= "FROM data ";
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
$query .= "INNER JOIN act ON (act.id_data = data.id_data)  ";
$query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
$query .= "INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
$query .= "INNER JOIN tb_province ON (tb_province.id = insuree.province) ";

$query .= "WHERE data.id_data='$IDDATA'";

$row = $_contextFour->query($query)->fetch(2);

$car_id = $row['car_id'];
$arr_car_id = str_split($car_id);
$id_data_rec = $row['id_data'];
// ชื่อจังหวัด ทะเบียนรถ
$sql = "SELECT name_mini FROM tb_province WHERE id='" . $row['car_regis_pro'] . "'";
$fetcharr = $_contextFour->query($sql)->fetch(2);
$name_mini = $fetcharr['name_mini'];
$address_pdf = $row['add'];
if ($row['group'] != "-" && $row['group'] != "") {
	$address_pdf .= " หมู่" . $row['group'];
}
if ($row['town'] != "-" && $row['town'] != "") {
	$address_pdf .= " " . $row['town'];
}
if ($row['lane'] != "-" && $row['lane'] != "") {
	$address_pdf .= " ซอย" . $row['lane'];
}
if ($row['road'] != "-" && $row['road'] != "") {
	$address_pdf .= " ถนน" . $row['road'];
}

if ($row['province'] != "102") {
	$address_pdf2 = 'ต.' . $row['tumbon_name'] . ' อ.' . $row['amphur_name'] . ' จ.' . $row['province_name'];
} else {
	$address_pdf2 = 'แขวง' . $row['tumbon_name'] . ' เขต' . $row['amphur_name'] . ' ' . $row['province_name'];
}

define('FPDF_FONTPATH', 'font/');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->AddFont('angsa', 'B', 'angsab.php');

$pdf->SetFont('angsa', 'B', 26);
$pdf->SetY(45);
$pdf->SetX(100);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $row['act_id']), 0, 0, 'L');

$pdf->SetFont('angsa', 'B', 14);
$pdf->SetY(53);
$pdf->SetX(70);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $row['title'] . ' ' . $row['name'] . ' ' . $row['last']), 0, 0, 'L');

$pdf->SetFont('angsa', 'B', 14);
$pdf->SetY(57);
$pdf->SetX(130);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $row['icard']), 0, 0, 'L');

$pdf->SetY(62);
$pdf->SetX(71);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $address_pdf . ' ' . $address_pdf2 . ' ' . $row['postal']), 0, 0, 'L');

if ($row['Dealer_saka'] == "สำนักงานใหญ่") {
	$pdf->Image('../images/1.jpg', 18, 58, 3);
}
if ($row['Dealer_saka'] == "สาขาที่ 1") {
	$pdf->Image('../images/1.jpg', 33, 58, 3);

	$pdf->SetY(60);
	$pdf->SetX(46);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', '1'), 0, 0, 'L');
}
if ($row['Dealer_saka'] == "สาขาที่ 2") {
	$pdf->Image('../images/1.jpg', 33, 58, 3);

	$pdf->SetY(60);
	$pdf->SetX(46);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', '2'), 0, 0, 'L');
}
if ($row['Dealer_saka'] == "สาขาที่ 3") {
	$pdf->Image('../images/1.jpg', 33, 58, 3);

	$pdf->SetY(60);
	$pdf->SetX(46);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', '3'), 0, 0, 'L');
}

$pdf->SetFont('angsa', 'B', 16);
$pdf->SetY(71);
$pdf->SetX(83);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', thaiDate($row['start_date'])), 0, 0, '');

$pdf->SetY(71);
$pdf->SetX(137);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', thaiDate($row['end_date'])), 0, 0, '');

if ($row['cat_car'] == '01') {
	$actcode = '1.10';
	$bodytype = 'รถนั่งส่วนบุคคล';
} else if ($row['cat_car'] == '03') {
	$actcode = '1.40';
	$bodytype = 'รถยนต์บรรทุก';
}

$pdf->SetFont('angsa', 'B', 14);
$pdf->SetY(93);
$pdf->SetX(7);
$pdf->Cell(28, 5, iconv('UTF-8', 'TIS-620', $actcode), 0, 0, 'C');

$pdf->SetY(93);
$pdf->SetX(32);
$pdf->Cell(37, 5, iconv('UTF-8', 'TIS-620', $row['car_brand']), 0, 0, 'C');

$pdf->SetY(96);
$pdf->SetX(32);
$pdf->Cell(37, 5, iconv('UTF-8', 'TIS-620', $row['mo_car_name']), 0, 0, 'C');

$pdf->SetY(95);
$pdf->SetX(67);
$pdf->Cell(34, 5, iconv('UTF-8', 'TIS-620', $row['car_regis'] . ' ' . $name_mini), 0, 0, 'C');

$pdf->SetY(95);
$pdf->SetX(99);
$pdf->Cell(39, 5, iconv('UTF-8', 'TIS-620', $row['car_body']), 0, 0, 'C');

$pdf->SetY(95);
$pdf->SetX(140);
$pdf->Cell(39, 5, iconv('UTF-8', 'TIS-620', $bodytype), 0, 0, 'C');

$pdf->SetY(95);
$pdf->SetX(173);

if ($row['mo_car'] == "759" || $row['mo_car'] == "747") {
	$scw = "7 / 3 / 1600";
} else if ($row['mo_car'] == "1098") {
	$scw = "3 / 3 / 1600";
} else if ($row['mo_car'] == "1960") {
	$scw = "7 / 3 / 1400";
} else if ($row['mo_car'] == "1951" || $row['mo_car'] == "754" || $row['mo_car'] == "1964" || $row['mo_car'] == "1967" || $row['mo_car'] == "1968" || $row['mo_car'] == "1969") {
	$scw = "7 / 3 / 1200";
}

$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', $scw), 0, 0, 'C');

if ($row['cat_car'] == '01') {
	$act_pre = '600.00';
	$act_duty = '3.00';
	$act_vat = '42.21';
	$act_net = '645.21';
} else if ($row['cat_car'] == '03') {
	$act_pre = '900.00';
	$act_duty = '4.00';
	$act_vat = '63.28';
	$act_net = '967.28';
}

$pdf->SetFont('angsa', 'B', 18);
$pdf->SetY(154);
$pdf->SetX(12);
$pdf->Cell(28, 5, iconv('UTF-8', 'TIS-620', $act_pre), 0, 0, 'C');

$pdf->SetY(154);
$pdf->SetX(84);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', $act_pre), 0, 0, 'C');

$pdf->SetY(154);
$pdf->SetX(113);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', $act_duty), 0, 0, 'C');

$pdf->SetY(154);
$pdf->SetX(138);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', $act_vat), 0, 0, 'C');

$pdf->SetY(154);
$pdf->SetX(171);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', $act_net), 0, 0, 'C');

$pdf->SetFont('angsa', 'B', 14);
$pdf->SetY(162);
$pdf->SetX(70);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', 'ใช้เป็นรถส่วนบุคคล ไม่ใช้รับจ้างหรือให้เช่า'), 0, 0, 'C');

$pdf->Image('../images/1.jpg', 111, 173, 3);

$pdf->SetFont('angsa', 'B', 11);
$pdf->SetY(171);
$pdf->SetX(135);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', 'บจ.โฟร์อินชัวรันส์โบรกเกอร์'), 0, 0, 'C');

$pdf->SetY(171);
$pdf->SetX(175);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', 'ว00018/2551'), 0, 0, 'C');

$pdf->SetFont('angsa', 'B', 14);
$pdf->SetY(178);
$pdf->SetX(45);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', thaiDate($row['start_date'])), 0, 0, 'C');

$pdf->SetY(178);
$pdf->SetX(145);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', thaiDate($row['start_date'])), 0, 0, 'C');

$pdf->SetY(232);
$pdf->SetX(90);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', $row['car_regis'] . ' ' . $name_mini), 0, 0, 'C');

$pdf->SetY(232);
$pdf->SetX(160);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', $row['car_body']), 0, 0, 'C');

$pdf->SetY(246);
$pdf->SetX(50);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', thaiDate($row['start_date'])), 0, 0, 'C');

$pdf->SetY(246);
$pdf->SetX(140);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', thaiDate($row['end_date'])), 0, 0, 'C');

$pdf->SetFont('angsa', 'B', 20);
$pdf->SetY(252);
$pdf->SetX(60);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', $row['act_id']), 0, 0, 'C');

$pdf->Output();
?>