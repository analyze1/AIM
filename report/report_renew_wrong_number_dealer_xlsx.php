<?php
include("../ClassesExcel/PHPExcel-1.8.1/Classes/PHPExcel.php");
include "../inc/connectdbs.pdo.php";
require('../services/ReportRenew/service/report-renew.service.php');
// require('../services/QuickFindDataArray/ModelCarFour.service.php');

$_serviceMitSu = new ReportRenew(PDO_CONNECTION::fourinsure_mitsu(), PDO_CONNECTION::fourinsure_insured());
// $_gdetailSer = new GetdetailFollowControl(PDO_CONNECTION::fourinsure_mitsu());

$model = new stdClass();
$model->user = $_POST['dealerCode'];
$model->month = $_POST['genMonth'];
$model->year = $_POST['genYear'];
$model->typeOptions = $_POST['typeOptions'];
$model->startDate = $_POST['start_date'];
$model->endDate = $_POST['end_date'];

$dataAll = $_serviceMitSu->wrongCustomerNumber($model);
$_informDealer = $_serviceMitSu->dealerAllArrSearch();

if (!$dataAll) {
	echo "<center><h1><p style='color:red;'>ไม่พบข้อมูล</p></h1></center>";
	exit();
}

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

function getMonthTH($mm)
{
	$month = '';
	switch ($mm) {
		case 1:
			$month = "มกราคม";
			break;
		case 2:
			$month = "กุมภาพันธ์";
			break;
		case 3:
			$month = "มีนาคม";
			break;
		case 4:
			$month = "เมษายน";
			break;
		case 5:
			$month = "พฤษภาคม";
			break;
		case 6:
			$month = "มิถุนายน";
			break;
		case 7:
			$month = "กรกฎาคม";
			break;
		case 8:
			$month = "สิงหาคม";
			break;
		case 9:
			$month = "กันยายน";
			break;
		case 10:
			$month = "ตุลาคม";
			break;
		case 11:
			$month = "พฤศจิกายน";
			break;
		case 12:
			$month = "ธันวาคม";
			break;
	}
	return $month;
}

// สร้าง object ของ Class  PHPExcel  ขึ้นมาใหม่ 
$objPHPExcel = new PHPExcel();

// กำหนดค่าต่างๆ

// $objPHPExcel->createSheet(0);
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //ORIENTATION_PORTRAIT
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
$objPHPExcel->getDefaultStyle()->getFont()->setName('Cordia New')->setSize(14);

$BStyle = array(
	'borders' => array(
		'bottom' => array(
			'style' => PHPExcel_Style_Border::BORDER_DOUBLE
		)
	),
	'font'  => array(
		'bold'  => true,
		'color' => array('rgb' => 'FF0000')
	)
);

$styleborders = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	)
);

// ตั้งชื่อ Sheet
$objPHPExcel->createSheet(0);
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('รายงาน เบอร์ผิด ดีลเลอร์ '.$model->user);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->getStartColor()->setRGB('51a351');
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleborders);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ลำดับ')->getColumnDimensionByColumn(0)->setWidth(6);
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'วันที่แก้ไข')->getColumnDimensionByColumn(1)->setWidth(12);
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'เลขรับแจ้ง')->getColumnDimensionByColumn(2)->setWidth(20);
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'วันหมดอายุ')->getColumnDimensionByColumn(3)->setWidth(12);
$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'ชื่อผู้เอาประกัน')->getColumnDimensionByColumn(4)->setWidth(35);
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'สถานะ')->getColumnDimensionByColumn(5)->setWidth(20);
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'เบอร์ผิด')->getColumnDimensionByColumn(6)->setWidth(20);
$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'การครั้งโทรล่าสุด')->getColumnDimensionByColumn(7)->setWidth(20);
$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'รายละเอียด')->getColumnDimensionByColumn(8)->setWidth(30);

$num_1 = 1;
$rowNumber = 2;
foreach ($dataAll as $key => $value) {
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue('A' . $rowNumber, $num_1); //ลำดับ
	$timeSave = ($value['TimeStamp'] == '0000-00-00') ? $value['date_detail'] : $value['TimeStamp'];
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $rowNumber, thaiDate($timeSave));
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $rowNumber, $value['id_data']);
	$objPHPExcel->getActiveSheet()->setCellValue('D' . $rowNumber, thaiDate($value['end_date']));
	$objPHPExcel->getActiveSheet()->setCellValue('E' . $rowNumber, $value['nameFull']);
	$objPHPExcel->getActiveSheet()->setCellValue('F' . $rowNumber, $value['StatusFollow']);
	$objPHPExcel->getActiveSheet()->setCellValue('G' . $rowNumber, $_serviceMitSu->reTelephone($value['Telephone']));
	$res_last_call = $_serviceMitSu->loadLastCallById($value['id_data'], trim($value['Telephone']));
	$lastCall = (empty($res_last_call->log_date) ? 'ไม่มีการโทร' : $res_last_call->log_date);
	$objPHPExcel->getActiveSheet()->setCellValue('H' . $rowNumber, $lastCall);
	$objPHPExcel->getActiveSheet()->setCellValue('I' . $rowNumber, $value['Detail']);
	$num_1++;
	$rowNumber++;
}
$objPHPExcel->removeSheetByIndex(1);
$nameRand = rand();
$name_file = "report-renew-wrong-number-mv-$nameRand.xlsx";

// บันทึกไฟล์ Excel 2007
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=' . $name_file);
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>