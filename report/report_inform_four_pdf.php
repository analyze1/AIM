<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
include "../inc/function.php";
include '../print/rotation.php';
include '../services/ReportComDealer/comdealer.model.php';
include '../services/ReportComDealer/comdealer.service.php';

#region class function define
define('FPDF_FONTPATH', 'font/');
class PDF extends PDF_Rotate
{
	function RotatedText($x, $y, $txt, $angle)
	{
		//Text rotated around its origin
		$this->Rotate($angle, $x, $y);
		$this->Text($x, $y, $txt);
		$this->Rotate(0);
	}

	function RotatedImage($file, $x, $y, $w, $h, $angle)
	{
		//Image rotated around its upper-left corner
		$this->Rotate($angle, $x, $y);
		$this->Image($file, $x, $y, $w, $h);
		$this->Rotate(0);
	}
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

function thaiDate_y2($datetime)
{
	list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y + 543; // เปลี่ยน ค.ศ. เป็น พ.ศ.
	$Y  = substr($Y, 2);
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

function repl($x)
{
	if (empty($x)) return 0;
	return str_replace(',', '', $x);
}
#endregion

$dealer = '';
$_codeAgent = $_POST['idagent'];

if ($_POST['idagent'] != 'ALL') {
	// $code = substr($_POST['idagent'], 1, 5);
	// $userCode = PDO_CONNECTION::fourinsure_mitsu()
	// 	->query("SELECT `user` FROM tb_customer WHERE user LIKE '%$code%' ORDER BY `user` ASC LIMIT 1")->fetch(7);
	$dealer = "AND da.login = '$_POST[idagent]'";
}

$sqlMItSuToFour = "SELECT
		de1.id_data_four AS fourID
		FROM
		detail_renew AS de1
		JOIN (
		SELECT
			`data`.id_data ,
			`data`.login
		FROM
			`data`
			INNER JOIN req ON ( `data`.id_data = req.id_data ) 
		WHERE
			( `data`.end_date BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND req.EditCancel != 'Y' AND req.EditTime != 'Y') 
		OR ( req.EditTime_EndDate BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND req.EditCancel != 'Y' )) AS da ON ( da.id_data = de1.id_data ) 
		WHERE
		de1.`status` = 'E' 
		AND id_data_four != '' 
		$dealer";

$dealerCodeArr = PDO_CONNECTION::fourinsure_mitsu()->query($sqlMItSuToFour)->fetchAll(5);

$sql = "SELECT AgentDis FROM upload_admin_telephone WHERE DealerCode = '$userCode' AND Approve ='Y' ORDER BY Id DESC LIMIT 1";
$_dealerComPer = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetch(7);

if(empty($_dealerComPer))
{
	$_dealerComPer = 18;
}

if (empty($dealerCodeArr)) {
	echo '<div style="font-size:30px"><center>ไม่พบข้อมูลต่ออายุ</center></div>';
	exit;
}

$dataID = '';
foreach ($dealerCodeArr as $code) {
	$dataID .= $dataID == '' ? "'$code->fourID'" : ",'$code->fourID'";
}

$select_data_sql = "SELECT
`data`.id_data,
DATE(`data`.send_date) As send_date,
`data`.`start_date`,
`data`.end_date,
`data`.com_data,
detail.car_regis,
insuree.title,
insuree.name,
insuree.last,
premium.total_pre,
premium.total_sum,
premium.prb_net,
premium.prb,
premium.commition,
premium.total_commition,
premium.other
FROM `data`
LEFT JOIN detail ON (`data`.id_data = detail.id_data)
LEFT JOIN insuree ON (`data`.id_data = insuree.id_data)
LEFT JOIN premium ON (`data`.id_data = premium.id_data)
WHERE detail.cencel_check != 'Y' AND `data`.id_data IN ($dataID)";

$queryResult = PDO_CONNECTION::fourinsure_insured()->query($select_data_sql);
$numRow = $queryResult->rowCount();

//$pdf->RotatedText(110,60,iconv( 'UTF-8','TIS-620',$premium_name),0);
//$pdf->Image('../images/logo.gif',10,3,80);
//$pdf->Image('../i/dealer.png',10,27,20);

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->AddFont('angsa', 'B', 'angsab.php');
$pdf->SetAutoPageBreak(true);

/*********************** ตั้งค่า ***********************************/

//ตั้งค่า ตะแหน่ง x , y
$setY = array(40, 10, 3, 200);
$setX = array(3.5, 285);

//ตั้งค่า ความยาว และ สูงของ cell
$ar_width_cell = array(8, 17, 17, 27, 58, 17, 16, 16, 15, 16, 16, 17, 17, 17, 17);
$ar_height_cell = array(7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7);

//ตั้งค่า border
$border = 1;

//font size
$ar_font_size = array(14, 12, 11);
$ar_font_type = array('', 'B');
$pg = 0;
$ch = 0;
$n = 0;
$total_pre_sum = 0;
$total_sum_sum = 0;
$prb_sum = 0;
$commition_sum = 0;
$total_commition_sum = 0;
$total_customer_sum = 0;
$totalDifComSum = 0;

foreach ($queryResult->fetchAll(2) as $infoArr) {
	$ch++;
	$select_invoice_sql = "SELECT 
	invoice_detail.grand,
	invoice_detail.id ,
	invoice_detail.pre,
	invoice_detail.prb,
	invoice_detail.sta_pre,
	invoice_detail.sta_prb,
	`certificate`.certificate_datestamp,
	`certificate`.certificate_date
	FROM invoice_detail
	LEFT JOIN `certificate` ON (invoice_detail.inv_no = `certificate`.inv_no)
	WHERE invoice_detail.id_data = '{$infoArr['id_data']}' ORDER BY `certificate`.certificate_date DESC";

	$select_invoice_query = PDO_CONNECTION::fourinsure_account()->query($select_invoice_sql);
	$invoiceArr = $select_invoice_query->fetch(2);

	$service = new CalculateDealerBenefitControl();
	$infoObj = $service->calculateCustomer($infoArr, $invoiceArr, $_dealerComPer);

	#region header paper
	if ($ch == 1) {
		$pdf->AddPage();
		$pdf->SetFont('angsa', $ar_font_type[0], $ar_font_size[0]);
		$pg++;
		$pdf->SetY($setY[2]);
		$pdf->SetX($setX[1]);
		$pdf->Cell(7, 7, iconv('UTF-8', 'TIS-620', $pg), 0, 1, "R");
		$pdf->SetY($setY[1]);
		$pdf->SetX($setX[0]);
		if ($_SESSION["strUser"] != 'admin') {
			$company_name = $_SESSION["strName"];
			$company_name = $company_name." ($_codeAgent)";
		} else {
			$company_name = '';
		}
		$pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', $company_name), 0, 1, "L");
		$pdf->SetX($setX[0]);
		$pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ใบแจ้งค่าเบี้ยประกันภัยครบกำหนดชำระ'), 0, 1, "L");
		$pdf->SetX($setX[0]);
		$pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'ระหว่างวันที่ ' . thaiDate($_POST['start_date']) . ' ถึง ' . thaiDate($_POST['end_date'])), 0, 1, "L");
		$pdf->SetFillColor(228, 228, 228);
		$pdf->SetFont('angsa', $ar_font_type[0], $ar_font_size[0]);
		$x = 0;
		$pdf->SetY($setY[0]);
		$pdf->SetX($setX[0]);
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'ลำดับ'), $border, 0, "C", "T");
		/*	$x++;
		$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','วันที่แจ้ง'),$border,0,"C","T");*/
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'วันคุ้มครอง'), $border, 0, "C", "T");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'ประกันภัย'), $border, 0, "C", "T");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'เลขที่รับแจ้ง'), $border, 0, "C", "T");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'ชื่อผู้เอาประกัน'), $border, 0, "C", "T");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'ทะเบียน'), $border, 0, "C", "T");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'เบี้ยสุทธิ'), $border, 0, "C", "T");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'เบี้ยรวม'), $border, 0, "C", "T");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'พ.ร.บ.'), $border, 0, "C", "T");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'ตัวแทน'), $border, 0, "C", "T");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'ยอดนำส่ง'), $border, 0, "C", "T");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'ลูกค้า'), $border, 0, "C", "T");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'ยอดคืน'), $border, 0, "C", "T");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'จ่าย'), $border, 0, "C", "T");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'รับ'), $border, 1, "C", "T");
		$pdf->SetFont('angsa', $ar_font_type[0], $ar_font_size[0]);
	}

	#endregion

	$x = 0;
	$n++;
	$pdf->SetX($setX[0]);
	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $n), $border, 0, "C");

	/*$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$infoArr['send_date']),$border,0,"C");*/

	$x++;
	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', thaiDate_y2($infoObj->StartDate)), $border, 0, "C");
	$x++;
	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $infoObj->ComData), $border, 0, "C");
	$x++;
	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $infoObj->DataID), $border, 0, "C");
	$x++;
	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $infoObj->NameFull), $border, 0, "L");
	$x++;
	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $infoObj->CarRegis), $border, 0, "C");
	$x++;

	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($infoObj->Pre, 2)), $border, 0, "C");
	$x++;

	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($infoObj->PreTotal, 2)), $border, 0, "C");
	$x++;

	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($infoObj->PrbTotal, 2)), $border, 0, "C");
	$x++;

	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($infoObj->Commition, 2)), $border, 0, "C");
	$x++;

	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($infoObj->SendTotal, 2)), $border, 0, "C");
	$x++;
	//ยอดลูกค้าจ่าย
	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($infoObj->CustomerPrice, 2)), $border, 0, "C");
	$x++;
	//ยอดดิฟค่าคอม
	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($infoObj->ReceiveDealer, 2)), $border, 0, "C");
	$x++;

	if ($infoObj->DateSend != '' && $infoObj->DateSend != '0000-00-00') {
		$date_send = thaiDate_y2($infoObj->DateSend);
		$pdf->SetTextColor(43, 96, 0);
	} else {
		$date_send = 'ยังไม่ชำระ';
		$pdf->SetTextColor(255, 0, 0);
	}


	#region comment
	/*	$date_send='';
	if($invoiceArr['sta_pre']=='Y' && $invoiceArr['sta_prb']=='Y' && $invoiceArr['pre'] > 0 && $invoiceArr['prb'] > 0)
	{
		//$date_send = $invoiceArr['certificate_datestamp'];
		$date_send='ชำระแล้ว';
		$pdf->SetTextColor(43, 96, 0);
	}
	else if($invoiceArr['sta_pre']=='Y' && $invoiceArr['pre'] > 0 && $invoiceArr['prb'] <= 0)
	{
		$date_send='ชำระแล้ว';
		$pdf->SetTextColor(43, 96, 0);
	}
	else if($invoiceArr['sta_prb']=='Y' && $invoiceArr['prb'] > 0 && $invoiceArr['pre'] <= 0)
	{
		$date_send='ชำระแล้ว';
		$pdf->SetTextColor(43, 96, 0);
	}
	else
	{
		$date_send='ยังไม่ชำระ';
		$pdf->SetTextColor(255, 0, 0);
	}*/
	#endregion
	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $date_send), $border, 0, "C");
	$x++;

	if ($infoObj->DateReceive != '' && $infoObj->DateReceive != '0000-00-00') {
		$date_receive = thaiDate_y2($infoObj->DateReceive);
		$pdf->SetTextColor(43, 96, 0);
	} else {
		$date_receive = 'ยังไม่ชำระ';
		$pdf->SetTextColor(255, 0, 0);
	}
	$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $date_receive), $border, 1, "C");


	$pdf->SetTextColor(0, 0, 0);

	$total_pre_sum += $infoObj->Pre;
	$total_sum_sum += $infoObj->PreTotal;
	$prb_sum += $infoObj->PrbTotal;

	//รวมค่าคอม 18% / 10 %
	$commition_sum += $infoObj->Commition;

	//รวมยอดนำส่ง
	$total_commition_sum += $infoObj->SendTotal;

	//รวมยอดที่ลูกค้าจ่าย
	$total_customer_sum += $infoObj->CustomerPrice;

	//รวมยอดที่ดิฟ ส่วนลดแล้ว จากการจ่ายเงินของลูกค้า
	$totalDifComSum += $infoObj->ReceiveDealer;

	if ($n == $numRow) {
		$pdf->SetFont('angsa', $ar_font_type[1], $ar_font_size[2]);
		$x = 0;
		//$pdf->SetY($setY[2]);
		$pdf->SetX($setX[0]);
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', ''), 0, 0, "L");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', ''), 0, 0, "L");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', ''), 0, 0, "L");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', ''), 0, 0, "L");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', ''), 0, 0, "L");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'รวม'), 'B', 0, "L");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($total_pre_sum, 2, '.', ',')), 'B', 0, "R");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($total_sum_sum, 2, '.', ',')), 'B', 0, "R");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($prb_sum, 2, '.', ',')), 'B', 0, "R");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($commition_sum, 2, '.', ',')), 'B', 0, "R");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($total_commition_sum, 2, '.', ',')), 'B', 0, "R");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($total_customer_sum, 2, '.', ',')), 'B', 0, "R");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', number_format($totalDifComSum, 2, '.', ',')), 'B', 0, "R");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', ''), 'B', 0, "R");
		$x++;
		$pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', ''), 'B', 0, "R");
	}


	if ($ch == 20 || $n == $numRow) {
		$ch = 0;
		$pdf->SetFont('angsa', $ar_font_type[0], $ar_font_size[1]);
		$pdf->SetY($setY[3]);
		$pdf->SetX($setX[0]);
		$pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', ' พิมพ์โดย ' . $company_name . ' วันที่พิมพ์ ' . thaiDate(date('Y-m-d'))), 0, 0, "R");
	}
}
$pdf->Output();

#region old Code
	/*
		$pdf->SetTextColor(0, 0, 0);
	if(empty($invoiceArr))
	{
		$payment_num = 0.00;
		$payment_name = "(ไม่มีการวางบิล)";
		$pdf->SetTextColor(255, 128, 0);
	}
	else if(str_replace(',','',$invoiceArr['grand'])==str_replace(',','',$infoArr['total_commition']))
	{
		$payment_num = 0.00;
		$payment_name = "(ชำระครบ)";
		$pdf->SetTextColor(43, 96, 0);
	}
	else if(str_replace(',','',$infoArr['total_commition']) < str_replace(',','',$invoiceArr['grand']))
	{
		$payment_num = str_replace(',','',$invoiceArr['grand']) - str_replace(',','',$infoArr['total_commition']);
		$payment_name = "(ชำระเกิน ".number_format($payment_num,2,'.',',').")";
		$pdf->SetTextColor(43, 96, 0);
	}
	else if(str_replace(',','',$infoArr['total_commition']) > str_replace(',','',$invoiceArr['grand']))
	{
		$payment_num = str_replace(',','',$infoArr['total_commition']) - str_replace(',','',$invoiceArr['grand']);
		$payment_name = "(ชำระขาด ".number_format($payment_num,2,'.',',').")";
		$pdf->SetTextColor(255, 0, 0);
	}
	*/
	#endregion