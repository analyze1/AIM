<?php
include("../ClassesExcel/PHPExcel.php");
include "../inc/connectdbs.pdo.php";
include "../inc/function.php";
$_context_suzuki = PDO_CONNECTION::fourinsure_mitsu();
//ถ้า ต้องการโหลด 1 ปี ให้เปิดตัวนี้
set_time_limit(15000);
// set_time_limit(1500);
ini_set('memory_limit', '2048M');
function claim_name($cl_name)
{
	switch ($cl_name) {
		case "R":
			$name_claim = "ฝ่ายถูก";
			break;
		case "W":
			$name_claim = "ฝ่ายผิด";
			break;
		case "N":
			$name_claim = "ประมาทร่วมกัน";
			break;
		case "C":
			$name_claim = "รอผลคดี";
			break;
		case "":
			$name_claim = "-";
			break;
	}
	return $name_claim;
}
function comp_C($compChange)
{
	switch ($compChange) {
		case "NVI":
			$compChange = "นวกิจ";
			break;
		case "MSIG":
			$compChange = "เอ็มเอสไอจี";
			break;
		case "NSI":
			$compChange = "นำสิน";
			break;
		case "BKI":
			$compChange = "กรุงเทพ";
			break;
		case "DEV":
			$compChange = "เทเวศ";
			break;
		case "TSI":
			$compChange = "ไทยศรี";
			break;
		case "STY":
			$compChange = "ประกันคุ้มภัย [สำนักงานใหญ่]";
			break;
		case "SCSMG":
			$compChange = "สามัคคี";
			break;
		case "VIB":
			$compChange = "วิริยะประกันภัย [สำนักงานใหญ่]";
			break;
		case "VIB_S":
			$compChange = "วิริยะประกันภัย [ปากเกร็ด]";
			break;
		case "VIB_Y":
			$compChange = "วิริยะประกันภัย [สุขาภิบาล 3]";
			break;
		case "AI1":
			$compChange = "เอเชียประกันภัย 1950";
			break;
		case "LMG":
			$compChange = "แอลเอ็มจี";
			break;
		case "KUI":
			$compChange = "เคเอสเค";
			break;
		case "BUI":
			$compChange = "บางกอกสหประกันภัย";
			break;
		case "AXA":
			$compChange = "แอกซ่า";
			break;
		case "SEI":
			$compChange = "อาคเนย์";
			break;
		case "SIP":
			$compChange = "สินมั่นคง";
			break;
		case "VIB_S103":
			$compChange = " วิริยะประกันภัย [ปากเกร็ด 10320] ";
			break;
		case "BKI[MBLT]":
			$compChange = "กรุงเทพ [MBLT]";
			break;
		case "TIP":
			$compChange = "ทิพยประกันภัย";
			break;
		case "STY_S":
			$compChange = "คุ้มภัย";
			break;
		case "KPI":
			$compChange = "กรุงไทยพานิช";
			break;
		case "CPI":
			$compChange = "เจ้าพระยา";
			break;
		case "VIB_S09712":
			$compChange = "วิริยะประกันภัย [ปากเกร็ด 09712]";
			break;
		case "SCSMG_O":
			$compChange = "ไทยพาณิชย์สามัคคี";
			break;
		case "TPB":
			$compChange = "ไทยไพบูลย์";
			break;
		case "ASSETS":
			$compChange = "สินทรัพย์";
			break;
		default:
			$compChange = $compChange;
	}
	return $compChange;
}


if ($_POST['chk_iddata'] == 'chk_iddata') {
	$search_senddate = " AND DATE(data.send_date) BETWEEN '" . $_POST['dpd_iddata'] . "' AND '" . $_POST['dpd_iddata2'] . "' ";
}
if ($_POST['chk_datestart'] == 'chk_datestart') {
	$search_startdate = " AND DATE(data.start_date) BETWEEN '" . $_POST['dpd_datestart'] . "' AND '" . $_POST['dpd_datestart2'] . "' ";
}
if ($_POST['chk_enddate'] == 'chk_enddate') {
	$search_enddate = "AND DATE(data.end_date) BETWEEN '" . $_POST['dpd_enddate'] . "' AND '" . $_POST['dpd_enddate2'] . "' ";
}
if ($_POST['chk_iduser'] == 'chk_iduser') {
	$search_dealer = " AND data.login  = '" . $_POST['txt_iduser'] . "' ";
}


// สร้าง object ของ Class  PHPExcel  ขึ้นมาใหม่ 
$objPHPExcel = new PHPExcel();

// กำหนดค่าต่างๆ
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //ORIENTATION_PORTRAIT
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);

$objPHPExcel->getDefaultStyle()->getFont()->setName('Cordia New')->setSize(14);

// HEAD Cell
$array_ceil = 0;
$ceil_eng = 'A';
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'บริษัทประกันภัย')->getColumnDimensionByColumn($array_ceil)->setWidth(25);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'วันที่แจ้ง')->getColumnDimensionByColumn($array_ceil)->setWidth(15);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'ตัวแทน')->getColumnDimensionByColumn($array_ceil)->setWidth(10);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'เลขที่รับแจ้ง')->getColumnDimensionByColumn($array_ceil)->setWidth(20);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'เลขที กธ')->getColumnDimensionByColumn($array_ceil)->setWidth(20);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'เลขตัวถัง')->getColumnDimensionByColumn($array_ceil)->setWidth(25);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'วันที่ค้มครอง')->getColumnDimensionByColumn($array_ceil)->setWidth(20);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'ชื่อผู้เอาประกัน')->getColumnDimensionByColumn($array_ceil)->setWidth(30);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'ประเภทรถ')->getColumnDimensionByColumn($array_ceil)->setWidth(15);
$array_ceil++;
$ceil_eng++;

$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'ยี่ห้อ')->getColumnDimensionByColumn($array_ceil)->setWidth(15);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'รุ่นรถ')->getColumnDimensionByColumn($array_ceil)->setWidth(15);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'ทะเบียน')->getColumnDimensionByColumn($array_ceil)->setWidth(15);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'ปีรถ')->getColumnDimensionByColumn($array_ceil)->setWidth(15);
$array_ceil++;
$ceil_color1 = $ceil_eng;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'ทุน')->getColumnDimensionByColumn($array_ceil)->setWidth(20);
$ceil_color2 = $ceil_eng;
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'อุปกรณ์ตกแต่งเพิ่มเติม')->getColumnDimensionByColumn($array_ceil)->setWidth(40);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng . '1', 'รวมทุนและเบี้ย')->getColumnDimensionByColumn($array_ceil)->setWidth(30);

// $array_ceil++;
// $ceil_eng++;
// $objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'สุทธิ')->getColumnDimensionByColumn($array_ceil)->setWidth(15);
// $array_ceil++;
// $ceil_eng++;
// $objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'เบี้ยรวม')->getColumnDimensionByColumn($array_ceil)->setWidth(15);


$objPHPExcel->getActiveSheet()->getStyle('A1:' . $ceil_color1 . '1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:' . $ceil_color1 . '1')->getFill()->getStartColor()->setRGB('BBD9EE');
$objPHPExcel->getActiveSheet()->getStyle('A1:' . $ceil_color1 . '1')->getFont()->getColor()->setRGB('000000');

$objPHPExcel->getActiveSheet()->getStyle($ceil_color2 . '1:P1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle($ceil_color2 . '1:P1')->getFill()->getStartColor()->setRGB('533419');
$objPHPExcel->getActiveSheet()->getStyle($ceil_color2 . '1:P1')->getFont()->getColor()->setRGB('FFCC33');

$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$query_suzuki = "SELECT 
					data.send_date
				   ,data.login
				   ,data.id_data
				   ,data.n_insure
				   ,data.start_date
				   ,insuree.title
				   ,insuree.name
				   ,insuree.last
				   ,detail.br_car
				   ,detail.mo_car
				   ,detail.car_regis
				   ,detail.car_detail
				   ,detail.car_body
				   ,detail.regis_date
				   ,detail.car_id
				   ,data.com_data
				   ,tb_cost.cost
				   ,tb_cost.pre
				   ,tb_cost.net
				   ,act.p_net 
				   ,tb_br_car.name as car_brand 
				   ,tb_mo_car.name as mo_name
				   ,insuree.tel_home
				   ,insuree.tel_home2
				   ,insuree.tel_mobi
				   ,insuree.tel_mobi_2
			FROM data 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			INNER JOIN insuree ON (data.id_data  = insuree.id_data) 
			INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car) 
			INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) 
			INNER JOIN tb_cost ON (data.costCost  = tb_cost.id) 
			INNER JOIN act ON (data.id_data  = act.id_data) 
			INNER JOIN req ON (data.id_data  = req.id_data)
			WHERE data.id_data != '' $search_senddate $search_startdate $search_enddate $search_dealer AND req.EditCancel = '' 
			order by data.send_date ASC ";


// mysql_select_db($db1, $cndb1);
// $objQuery = mysql_query($query_suzuki, $cndb1) or die("Error [" . $query_suzuki . "]");

$objQuery = $_context_suzuki->query($query_suzuki)->fetchAll(PDO::FETCH_ASSOC);

// เพิ่มข้อมูลเข้าใน Cell
$rowNumber = 2;
$rows = 0;
$pre_total = 0;
$net_total = 0;
foreach ($objQuery as $row) {

	//Excel       
	$col = 'A';

	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, comp_C($row['com_data']));
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, DateThai($row['send_date']));
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row['login']);
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row['id_data']);
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row['n_insure']);
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row['car_body']);
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, DateThai($row['start_date']));
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row['title'] . " " . $row['name'] . " " . $row['last']);
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row['car_id']);
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row['car_brand']);
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row['mo_name']);
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row['car_regis']);
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row['regis_date']);
	$col++;
	//ทุน
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $row['cost']);
	$col++;
	// $col++;
	// //สุทธิ
	// $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$row['pre']);
	// $col++;
	// // เบี้ยรวม
	// $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$row['net']);
	$acc_name = 0;
	$acc_price = 0;
	$text_array = "";
	if ($row['car_detail'] == "ไม่มี" || $row['car_detail'] == "" || empty($row['car_detail'])) {
		$text_array .= "ไม่มี";
	} else {
		$detail_array = explode("|", $row['car_detail']);
		for ($k = 0; $k < count($detail_array); $k++) {
			$com_array = explode(",", $detail_array[$k]);
			$id_acc_new = $com_array[0];
			$id_acc = $com_array[1];
			$acc_new_sql = "SELECT name FROM tb_acc_new WHERE id = '" . $id_acc_new . "'";
			$acc_new_array = $_context_suzuki->query($acc_new_sql)->fetch(PDO::FETCH_ASSOC);
			$acc_sql = "SELECT name,price FROM tb_acc WHERE id = '" . $id_acc . "'";
			$acc_array = $_context_suzuki->query($acc_sql)->fetch(PDO::FETCH_ASSOC);
			if ($acc_array['name'] <= 1) {
				$acc_name += 0;
				$acc_price += $acc_array['price'];
				$text_array .= $acc_new_array['name'] . " 0 ";
			} else {
				$acc_name += $acc_array['name'];
				$acc_price += $acc_array['price'];
				$text_array .= $acc_new_array['name'] . " " . number_format($acc_array['name']) . " ";
			}
		}
	}

	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, $text_array);
	$col++;
	$objPHPExcel->getActiveSheet()->setCellValue($col . $rowNumber, "เพิ่มทุน " . number_format($acc_name) . " เบี้ยเพิ่ม " . number_format($acc_price, 2, '.', ','));
	$col++;



	$rowNumber++;
	$rows++;
	// $pre_total+=$row['pre'];
	// $net_total+=$row['net'];
}
$objPHPExcel->getActiveSheet()->getStyle('A' . $rowNumber . ':P' . $rowNumber)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A' . $rowNumber . ':P' . $rowNumber)->getFont()->setUnderline(true);
$objPHPExcel->getActiveSheet()->setCellValue('A' . $rowNumber, "รายการทั้งหมด " . $rows . " รายการ");
// $objPHPExcel->getActiveSheet()->setCellValue('O'.$rowNumber,"รวม ".number_format($pre_total,2,'.',','));
// $objPHPExcel->getActiveSheet()->setCellValue('P'.$rowNumber,"รวม ".number_format($net_total,2,'.',','));
// ตั้งชื่อ Sheet
$objPHPExcel->getActiveSheet()->setTitle('รายงานยอดขาย suzuki');

// Footer
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R Report Suzuki/ผู้บริหาร/รายงานยอดขาย วันที่พิมพ์ &D &T  Page &P / &N  ผู้พิมพ์ : ' . $_SESSION["4NameSMS"]);

// บันทึกไฟล์ Excel 2007
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Report_sales_com.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
