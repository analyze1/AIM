<?php
require('../pages/check-ses.php');
require('../inc/connectdbs.pdo.php');
require('../phpqrcode/qrlib.php');
require('../Share/ConvertDataUserLogin/ConvertDataUserLogin.service.php');
require('../services/QuickFindDataArray/ModelCarFour.service.php');
require('../services/QuickFindDataArray/CompanyFour.service.php');
require('../services/Address/Address.service.php');

$_contextFour = PDO_CONNECTION::fourinsure_insured();
$_contextMitsubishi = PDO_CONNECTION::fourinsure_mitsu();

$IDDATA = $_GET['id'];
$STRENEW = $_GET['st'];
$idren = $_GET['id_key'];

$serviceAddress = new Address($_contextFour);
$convertLoginFullName = new ConvertDataUserLoginService($_contextMitsubishi);
$serviceModelCar = new ModelCarFour($_contextFour);
$arrModelCar = $serviceModelCar->getAll();

$serviceCompany = new CompanyFour($_contextFour);
$arrCompany = $serviceCompany->getAll();

$convertLoginFullName->createDataUserLogin($_SESSION['strUser']);
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
function thaiDate_new($datetime)
{
	list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
	list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที

	if ($m == '12') {
		$m = '1';
		$Y = $Y + 544; // เปลี่ยน ค.ศ. เป็น พ.ศ.
	} else {
		$m = $m + 1;
		$Y = $Y + 543;
	}

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
function thisYear($date){
	$thisYear = date("Y");
	$arrDate = explode("-",$date);
	return strval($thisYear.'-'.$arrDate[1].'-'.$arrDate[2]);
}
function convert($number)
{
	$txtnum1 = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ');
	$txtnum2 = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
	$number = str_replace(",", "", $number);
	$number = str_replace(" ", "", $number);
	$number = str_replace("บาท", "", $number);
	$number = explode(".", $number);
	if (sizeof($number) > 2) {
		return 'ทศนิยมหลายตัวนะจ๊ะ';
		exit;
	}
	$strlen = strlen($number[0]);
	$convert = '';
	for ($i = 0; $i < $strlen; $i++) {
		$n = substr($number[0], $i, 1);
		if ($n != 0) {
			if ($i == ($strlen - 1) and $n == 1) {
				$convert .= 'เอ็ด';
			} elseif ($i == ($strlen - 2) and $n == 2) {
				$convert .= 'ยี่';
			} elseif ($i == ($strlen - 2) and $n == 1) {
				$convert .= '';
			} else {
				$convert .= $txtnum1[$n];
			}
			$convert .= $txtnum2[$strlen - $i - 1];
		}
	}

	$convert .= 'บาท';
	if ($number[1] == '0' or $number[1] == '00' or $number[1] == '') {
		$convert .= 'ถ้วน';
	} else {
		$strlen = strlen($number[1]);
		for ($i = 0; $i < $strlen; $i++) {
			$n = substr($number[1], $i, 1);
			if ($n != 0) {
				if ($i == ($strlen - 1) and $n == 1) {
					$convert .= 'เอ็ด';
				} elseif ($i == ($strlen - 2) and $n == 2) {
					$convert .= 'ยี่';
				} elseif ($i == ($strlen - 2) and $n == 1) {
					$convert .= '';
				} else {
					$convert .= $txtnum1[$n];
				}
				$convert .= $txtnum2[$strlen - $i - 1];
			}
		}
		$convert .= 'สตางค์';
	}
	return $convert;
}

// $costOb = $_SESSION["Cost"]; // ทุนเพิ่ม
// $costObname = $_SESSION["CostName"]; // ชื่อ อุปกรณ์ตกแต่งเพิ่มเติม
$Cost_PRE = $_SESSION["CostPre"]; // อัตราเบี้ย
// $MoC = $_SESSION["MoC"]; // รุ่นรถ
$Pro3 = $_SESSION["Pro3"];

$dateYear = substr($_POST['txt_month'], 0, 4);
$dateMonth = substr($_POST['txt_month'], 5, 2);


$query = "SELECT * FROM `data` ";
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "INNER JOIN req ON (data.id_data  = req.id_data) ";
$query .= "WHERE  data.id_data = '" . $IDDATA . "'   ";

$objQuery = $_contextMitsubishi->query($query)->fetchAll(2);


require('../fpdf.php');
// define('FPDF_FONTPATH','font/');
require('../code128.php');
class PDFRotect extends PDF_Code128
	{
		var $angle=0;
	
		function Rotate($angle,$x=-1,$y=-1)
		{
			if($x==-1)
				$x=$this->x;
			if($y==-1)
				$y=$this->y;
			if($this->angle!=0)
				$this->_out('Q');
			$this->angle=$angle;
			if($angle!=0)
			{
				$angle*=M_PI/180;
				$c=cos($angle);
				$s=sin($angle);
				$cx=$x*$this->k;
				$cy=($this->h-$y)*$this->k;
				$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
			}
		}
	
		function _endpage()
		{
			if($this->angle!=0)
			{
				$this->angle=0;
				$this->_out('Q');
			}
			parent::_endpage();
		}
	
		function RotatedText($x,$y,$txt,$angle)
		{
			//Text rotated around its origin
			$this->Rotate($angle,$x,$y);
			$this->Text($x,$y,$txt);
			$this->Rotate(0);
		}
	
		function RotatedImage($file,$x,$y,$w,$h,$angle)
		{
			//Image rotated around its upper-left corner
			$this->Rotate($angle,$x,$y);
			$this->Image($file,$x,$y,$w,$h);
			$this->Rotate(0);
		}
	}
	class AlphaPDF extends PDFRotect {
		protected $extgstates = array();
		// alpha: real value from 0 (transparent) to 1 (opaque)
		// bm:    blend mode, one of the following:
		//          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn,
		//          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
		function SetAlpha($alpha, $bm = 'Normal') {
			// set alpha for stroking (CA) and non-stroking (ca) operations
			$gs = $this->AddExtGState(array('ca' => $alpha, 'CA' => $alpha, 'BM' => '/' . $bm));
			$this->SetExtGState($gs);
		}
		function AddExtGState($parms) {
			$n = count($this->extgstates) + 1;
			$this->extgstates[$n]['parms'] = $parms;
			return $n;
		}
		function SetExtGState($gs) {
			$this->_out(sprintf('/GS%d gs', $gs));
		}
		function _enddoc() {
			if (!empty($this->extgstates) && $this->PDFVersion < '1.4') $this->PDFVersion = '1.4';
			parent::_enddoc();
		}
		function _putextgstates() {
			for ($i = 1;$i <= count($this->extgstates);$i++) {
				$this->_newobj();
				$this->extgstates[$i]['n'] = $this->n;
				$this->_put('<</Type /ExtGState');
				$parms = $this->extgstates[$i]['parms'];
				$this->_put(sprintf('/ca %.3F', $parms['ca']));
				$this->_put(sprintf('/CA %.3F', $parms['CA']));
				$this->_put('/BM ' . $parms['BM']);
				$this->_put('>>');
				$this->_put('endobj');
			}
		}
		function _putresourcedict() {
			parent::_putresourcedict();
			$this->_put('/ExtGState <<');
			foreach ($this->extgstates as $k => $extgstate) $this->_put('/GS' . $k . ' ' . $extgstate['n'] . ' 0 R');
			$this->_put('>>');
		}
		function _putresources() {
			$this->_putextgstates();
			parent::_putresources();
		}
	}
$pdf = new AlphaPDF();
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(false);
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->AddFont('angsa', 'B', 'angsab.php');
$pdf->SetFont('angsa', 'B', 14);


foreach ($objQuery as $row) {
	$address_pdf = '';
	$address_pdf3 = '';
	$address_pdf2 = '';
	$address_pdf4 = '';
	if ($row['status_SendAdd'] == 'Y') {
		$textaddarray = explode('|', $row['SendAdd']);
		if ($textaddarray[0] != "-" && $textaddarray[0] != "") {
			$address_pdf .= $textaddarray[0];
		}
		if ($textaddarray[1] != "-" && $textaddarray[1] != "") {
			$address_pdf .= " หมู่ " . $textaddarray[1];
		}
		if ($textaddarray[2] != "-" && $textaddarray[2] != "") {
			$address_pdf .= " หมู่บ้าน/อาคาร " . $textaddarray[2];
		}
		if ($textaddarray[3] != "-" && $textaddarray[3] != "") {
			$address_pdf4 .= "ซอย " . $textaddarray[3] . " ";
		}
		if ($textaddarray[4] != "-" && $textaddarray[4] != "") {
			$address_pdf4 .= "ถนน " . $textaddarray[4];
		}
		if ($textaddarray[5] != "102") {
			$address_pdf2 .= 'ต.' . $serviceAddress->getTumbonID($textaddarray[7]). ' อ.' . $serviceAddress->getAmphurID($textaddarray[6]);
			$address_pdf3 .= 'จ.' . $serviceAddress->getProvinceID($textaddarray[5]) . ' ' . $textaddarray[8];
		} else {
			$address_pdf2 .= 'แขวง' . $serviceAddress->getTumbonID($textaddarray[7]) . ' เขต' . $serviceAddress->getAmphurID($textaddarray[6]);
			$address_pdf3 .= $serviceAddress->getProvinceID($textaddarray[5]) . ' ' . $textaddarray[8];
		}
	} else if ($row['EditCustomer'] == 'Y') {
		if ($row['Cus_add'] != "-" && $row['Cus_add'] != "") {
			$address_pdf .= $row['Cus_add'];
		}
		if ($row['Cus_group'] != "-" && $row['Cus_group'] != "") {
			$address_pdf .= " หมู่ " . $row['Cus_group'];
		}
		if ($row['Cus_town'] != "-" && $row['Cus_town'] != "") {
			$address_pdf .= " หมู่บ้าน/อาคาร " . $row['Cus_town'];
		}
		if ($row['Cus_lane'] != "-" && $row['Cus_lane'] != "") {
			$address_pdf4 .= "ซอย " . $row['Cus_lane'] . " ";
		}
		if ($row['Cus_road'] != "-" && $row['Cus_road'] != "") {
			$address_pdf4 .= "ถนน " . $row['Cus_road'];
		}
		if ($row['Cus_province'] != "102") {
			$address_pdf2 .= 'ต.' . $serviceAddress->getTumbonID($row['Cus_tumbon']) . ' อ.' . $serviceAddress->getAmphurID($row['Cus_amphur']);
			$address_pdf3 .= 'จ.' . $serviceAddress->getProvinceID($row['Cus_province']) . ' ' . $row['Cus_postal'];
		} else {
			$address_pdf2 .= 'แขวง' . $serviceAddress->getTumbonID($row['Cus_tumbon']) . ' เขต' . $serviceAddress->getAmphurID($row['Cus_amphur']);
			$address_pdf3 .= $serviceAddress->getProvinceID($row['Cus_province']) . ' ' . $row['Cus_postal'];
		}
	} else {
		if ($row['add'] != "-" && $row['add'] != "") {
			$address_pdf .= $row['add'];
		}
		if ($row['group'] != "-" && $row['group'] != "") {
			$address_pdf .= " หมู่ " . $row['group'];
		}
		if ($row['town'] != "-" && $row['town'] != "") {
			$address_pdf .= " หมู่บ้าน/อาคาร " . $row['town'];
		}
		if ($row['lane'] != "-" && $row['lane'] != "") {
			$address_pdf4 .= "ซอย " . $row['lane'] . " ";
		}
		if ($row['road'] != "-" && $row['road'] != "") {
			$address_pdf4 .= "ถนน " . $row['road'];
		}

		if ($row['province'] != "102") {
			$address_pdf2 .= 'ต.' . $serviceAddress->getTumbonID($row['tumbon']) . ' อ.' . $serviceAddress->getAmphurID($row['amphur']);
			$address_pdf3 .= 'จ.' . $serviceAddress->getProvinceID($row['province']) . ' ' . $row['postal'];
		} else {
			$address_pdf2 .= 'แขวง' . $serviceAddress->getTumbonID($row['tumbon']) . ' เขต' . $serviceAddress->getAmphurID($row['amphur']);
			$address_pdf3 .= $serviceAddress->getProvinceID($row['province']) . ' ' . $row['postal'];
		}
	}

	/////////////////////////////////////คำนวนทุนต่ออายุ new

	// ทุนต่ออายุ
	$costW = explode(",", substr($Cost_PRE['PreCost'][$row['costCost']], 0, 7));
	$CalculaCost = $costW[0] . $costW[1];

	if ($row['mo_car'] == '1964') {
		// บวก ตกแต่งเพิ่มเติม
		if ($row['EditProduct'] == 'Y') {
			//$ResultCost = ($CalculaCost+$row['TotalProduct'])-60000;  //เงื่อนไขเก่า เผื่อได้กลับมาใช้
			$ResultCost = round((($CalculaCost + $row['price_total']) * 0.90), -4);
		} else {
			//$ResultCost = ($CalculaCost+$row['price_total'])-60000;  //เงื่อนไขเก่า เผื่อได้กลับมาใช้
			$ResultCost = round((($CalculaCost + $row['price_total']) * 0.90), -4);
		}
	} else {
		// บวก ตกแต่งเพิ่มเติม
		if ($row['EditProduct'] == 'Y') {
			//$ResultCost = ($CalculaCost+$row['TotalProduct'])-30000;  //เงื่อนไขเก่า เผื่อได้กลับมาใช้
			$ResultCost = round((($CalculaCost + $row['price_total']) * 0.90), -4);
		} else {
			//$ResultCost = ($CalculaCost+$row['price_total'])-30000;  //เงื่อนไขเก่า เผื่อได้กลับมาใช้
			$ResultCost = round((($CalculaCost + $row['price_total']) * 0.90), -4);
		}
	}



	//  ERTIGA
	$dateY = substr($row['end_date'], 0, 4);
	$dateM = substr($row['end_date'], 5, 2);
	$changeCode = $dateY . $dateM;
	//exit();
	if ($changeCode <= 201704) {
		if ($row['mo_car'] == '1960') {
			$queryCostrenew = "SELECT * FROM UCostRenew  WHERE service = '2' AND type = 'S_Rate' AND mo_car = '1960' AND cost = '" . $ResultCost . "' ";
			$objQueryRenew = $_contextMitsubishi->query($queryCostrenew);
			$rowRenew = $objQueryRenew->fetch(2);
		}
		// SWIFT ECO CELERIO SWIFT RX SWIFT DUO
		else if ($row['mo_car'] == '1951' || $row['mo_car'] == '1964' || $row['mo_car'] == '1967' || $row['mo_car'] == '1968' || $row['mo_car'] == '1969') {
			$queryCostrenew = "SELECT * FROM UCostRenew  WHERE service = '2' AND type = 'S_Rate' AND mo_car = '' AND cost = '" . $ResultCost . "' ";
			$objQueryRenew = $_contextMitsubishi->query($queryCostrenew);
			$rowRenew = $objQueryRenew->fetch(2);
		}
		// carry
		else if ($row['mo_car'] == '1098') {
			$queryCostrenew = "SELECT * FROM UCostRenew  WHERE type = 'AS2' AND cost = '" . $ResultCost . "' ";
			$objQueryRenew = $_contextMitsubishi->query($queryCostrenew);
			$rowRenew = $objQueryRenew->fetch(2);
		}

		$Total_cost = $rowRenew['pre'];

		if ($row['mo_car'] == '1098') {
			$Net_NEW10 = round(($Total_cost * 10 / 100));
			$Net_NEW20 = round((($rowRenew['pre'] - $Net_NEW10) * 20 / 100));
		} else {
			$Net_NEW10 = round(($Total_cost * 10 / 100));
			$Net_NEW20 = round((($rowRenew['pre'] - $Net_NEW10) * 25 / 100));
		}
		$Net_NEW10 = '0.00';
		$Net_NEW20 = '0.00';
		$rservice = $rowRenew['service'];

		if ($row['car_id'] == 110) {
			$act_cost = '645.21';
			$pa1 = '1,000,000';
			$pa2 = '5,000,000';
			$pa3 = '200,000';
			$pa4 = '200,000';
			$pa5 = '200,000';
			$pa6 = '200,000';
			$seat = '6';
		} else if ($row['car_id'] == 320) {
			$act_cost = '967.28';
			$pa1 = '300,000';
			$pa2 = '1,000,000';
			$pa3 = '200,000';
			$pa4 = '200,000';
			$pa5 = '50,000';
			$pa6 = '200,000';
			$seat = '2';
		}
	} else {
		//ตั้งแต่เดือน 5 2017เป็นต้นไป
		$dateY = date('Y');
		if ($row['com_data'] == 'VIB_F') {
			$compDT = 'VIB_S';
		} else {
			$compDT = $row['com_data'];
		}
		$caroldO = $dateY - $row['regis_date'] + 1;
		$dateN = date("Y-m-d");  //วันที่ปัจจุบัน
		if ($caroldO == '1') {
			$carold = $caroldO + 1;
		} else {
			$carold = $caroldO;
		}

		if (!empty($STRENEW) && $STRENEW == 'F') {
			$sqlFix =  " AND  `status` ='F' ORDER BY id_detail DESC ";
		} else {
			$sqlFix =  "   AND `status` IN ('S','E') ";
		}
		if (!empty($idren)) {
			$sqlidren =  " AND  `id_detail` ='" . $idren . "'  ";
		} else {
			$sqlidren =  "  ";
		}

		$sqlQue = "SELECT * FROM detail_renew WHERE id_data='" . $row['id_data'] . "' " . $sqlidren . $sqlFix . " ";

		$quRenew = $_contextMitsubishi->query($sqlQue);
		$rowQue = $quRenew->rowCount();
		if ($rowQue > 0) {
			// echo "main";
			$exR = '';
			$arrResultCost = '';
			$arrRenew = $quRenew->fetch(2);
			$renew_id_cost = $arrRenew['renew_id_cost'];
			$exRe = explode('|', $arrRenew['detailcost']);
			$arrResultCost = $exRe[0];
			$arrcostcomp = $arrRenew['renew_comp'];
			$arrvat_pointer = $arrRenew['vat_pointer'];
			$arrvat_total = $arrRenew['vat_total'];
		}

		if (!empty($renew_id_cost) && $renew_id_cost != '99999') {
			// echo "test1";
			$sqlcost = '';
			$sqlcost = "SELECT * FROM tb_cost c ";
			$sqlcost .= " inner join tb_protection p  ON (c.protect_type = p.protect_type) ";
			$sqlcost .= "  WHERE id='" . $renew_id_cost . "' ";
			$rescost = $_contextFour->query($sqlcost);
			$arrcost = $rescost->fetch(2);
			$Total_cost = $arrcost['pre'];
			$insured_type = $arrcost['insured_type'];
			$rservice = $arrcost['repair'];
			$act_cost = $exRe[9];
			$sumextra =  $exRe[6];
			//echo $sqlcost;

		} else if ($renew_id_cost == '99999') {
			// echo "test2";
			$sqlcost = '';
			$sqlcost = " SELECT * FROM  tb_protection p  ";
			$sqlcost .= "  WHERE protect_type='" . $arrRenew['renew_ptype'] . "' ";
			$rescost = $_contextFour->query($sqlcost);
			$arrcost = $rescost->fetch(2);
			$Total_cost = $exRe[10];
			$act_cost = $exRe[9];
			$insured_type = '1';
			$rservice = '1';
			$sumextra = $exRe[6];
		} else {

			$topo = $_SESSION['topo'];
			$yearOld = $_SESSION['year_car'];
			$Cost_NEW = $_SESSION['Cost_NEW'];
			$mo_car = $row['mo_car'];
			$carid = $row['car_id'];
			$insured_type_t = $_SESSION['insured_type_t'];

			$claim_po = $_SESSION['claim_po'];
			$txt_loss = $_SESSION['txt_loss'];
			// exit();

			$strWhere = "";

			if ($claim_po >= 1) {
				if ($txt_loss != 0) {
					if ($txt_loss <= 60) {
						// echo "เคลมไม่เกิน 60% (ฝ่ายผิด)<br>";
						// L,<=,60
						$strWhere = "AND c.prod_condition = 'L,<=,60' ";
					} else if (($txt_loss > 60) && ($txt_loss <= 100)) {
						// echo "เคลม 60-100 %<br>";
						// L,>,60|L,<=,100
						$strWhere = "AND c.prod_condition = 'L,>,60|L,<=,100' ";
					} else if (($txt_loss > 100) && ($txt_loss <= 200)) {
						// echo "เคลมเกิน 100 %<br>";
						// L,>,100|L,<=,200
						$strWhere = "AND c.prod_condition = 'L,>,100|L,<=,200' ";
					} else if ($txt_loss > 200) {
						// echo "เคลมเกิน 200 %<br>";
						// L,>,200|C,>=,1
						$strWhere = "AND c.prod_condition = 'L,>,200|C,>=,1' ";
					}
				}
			} else {
				// echo "ไม่มีเคลม<br>";
				// L,<=,60|R,<,1
				$strWhere = "AND c.prod_condition = 'L,<=,60|R,<,1' ";
			}

			//SQL OLD Renew รอก่อน
			$sqlcost = '';
			$sqlcost = " SELECT cp.name ,cm.comp_sort,cm.namegroup,cm.ins_type,cm.cmocar,cm.cmocar_sz, c.*,p.* ";
			$sqlcost .= "FROM tb_cost c inner join tb_cost_mocar cm ON (c.mocargroup = cm.namegroup) ";
			$sqlcost .= " inner join tb_comp cp  ON (c.comp = cp.sort) ";
			$sqlcost .= " inner join tb_protection p  ON (c.protect_type = p.protect_type) ";
			$sqlcost .= "WHERE  car_old <= " . $carold . " AND car_old_end >= " . $carold . " AND cm.cmocar_sz IN ('" . $row['mo_car'] . "','ALL')  AND (cm.cstatus_sz = 'Y') ";
			$sqlcost .= " AND ((c.create_date <=  '" . $dateN . "' AND c.date_expired >= '" . $dateN . "' ))";
			// $sqlcost .= " OR c.create_date <=  '".$row['end_date']."' AND c.date_expired >= '".$row['end_date']."' )) "; // เบี้ยจากวันปปัจจุบันที่เสนอราคา
			$sqlcost .= " AND cost <= '" . $topo . "'  AND cost_end >='" . $topo . "' ";
			$sqlcost .= " AND c.car_id = '" . $row['car_id'] . "' ";

			$sqlcost .= " AND c.comp = 'VIB_S' AND c.`repair` = 1 ";
			//$sqlcost .= " AND c.comp = 'VIB_S103' ";
			$sqlcost .= " AND c.insured_type = '1' $strWhere ";
			$sqlcost .= " group by c.prod_name  ,pre , cm.cmocar_sz ORDER BY `repair` ";

			$rescost = $_contextFour->query($sqlcost);
			$arrcost = $rescost->fetch(2);
			$Total_cost = $arrcost['pre'];
			$arrcostcomp = $arrcost['comp'];
			$insured_type = $arrcost['insured_type'];
			$rservice = $arrcost['repair'];
			$sumextra = 0;
			if ($row['car_id'] == 110) {
				$act_cost = '645.21';
			} else if ($row['car_id'] == 320) {
				$act_cost = '967.28';
			}
		}


		$Net_NEW10 = '0.00';
		$Net_NEW20 = '0.00';

		$pa1 = number_format($arrcost['life'], 0); //'1,000,000';
		$pa2 = number_format($arrcost['asset'], 0); //'5,000,000';
		$pa3 = number_format($arrcost['driver'], 0); //'200,000';
		$pa4 = number_format($arrcost['passenger'], 0); //'200,000';
		$pa5 = number_format($arrcost['nurse'], 0); //'200,000';
		$pa6 = number_format($arrcost['insuran'], 0); //'200,000';
		$seat = $arrcost['tickets']; //'6';
	}

	if ($arrResultCost != '') {
		$costuse = $arrResultCost;
		if ($_SESSION['year_car'] >= 3) {
			$costuse = $_SESSION['topo'];
		}
	} else {
		$costuse = $ResultCost;
		// echo "costuse 2=>".$costuse;
		if ($_SESSION['year_car'] >= 3) {
			$costuse = $_SESSION['topo'];
		}
	}

	$servicename = '';
	if ($rservice == '1') {
		$servicename = '(ซ่อมห้าง)';
	} else if ($rservice == '2') {
		$servicename = '(ซ่อมอู่)';
	}

	$pre_new = $Total_cost - ($Net_NEW10 + $Net_NEW20);
	$stamp_new = ceil($pre_new * 0.004);
	$tax_new = round(($pre_new + $stamp_new) * 0.07, 2);
	$total_pre = $pre_new + $stamp_new + $tax_new;

	$pdf->AddPage();
	$pdf->Image('../images/policy_notice.png', 0, 1, 210);
	$ni = strlen($convertLoginFullName->getUserLoginFullName($_SESSION['strUser']));
	$xi = 85 - (0.5 * $ni);
	$yi = 120 + (0.8 * $ni);
	$pdf->SetFont('angsa', 'B', 50);
	$pdf->SetTextColor(255, 0, 0);
	$pdf->SetAlpha(0.1);
	$pdf->RotatedText($xi, $yi, iconv('UTF-8', 'TIS-620', $convertLoginFullName->getUserLoginFullName($_SESSION['strUser'])), 40);
	$pdf->SetAlpha(1);

	$pdf->SetFont('angsa', 'B', 14);
	$pdf->SetTextColor(0, 0, 0);

	$pdf->SetY(32); //35
	$pdf->SetX(20);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $convertLoginFullName->getUserLoginFullName($_SESSION['strUser'])), 0, 0, 'R');

	$pdf->SetY(35); //35
	$pdf->SetX(20);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $row['title'] . ' ' . $row['name'] . ' ' . $row['last']), 0, 0, 'L');

	$pdf->SetY(41);
	$pdf->SetX(20);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $address_pdf), 0, 0, 'L');

	if ($address_pdf4 != '') {
		$pdf->SetY(47);
		$pdf->SetX(20);
		$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $address_pdf4), 0, 0, 'L');

		$pdf->SetY(53);
		$pdf->SetX(20);
		$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $address_pdf2), 0, 0, 'L');

		$pdf->SetY(59);
		$pdf->SetX(20);
		$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $address_pdf3), 0, 0, 'L');
	} else {
		$pdf->SetY(47);
		$pdf->SetX(20);
		$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $address_pdf2), 0, 0, 'L');

		$pdf->SetY(53);
		$pdf->SetX(20);
		$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $address_pdf3), 0, 0, 'L');
	}

	$pdf->SetFont('angsa', 'B', 14);

	if ($row['n_insure'] != '') {
		$id_data = $row['n_insure'];
	} else {
		$id_data = $row['id_data'];
	}

	$pdf->SetY(98); //90
	$pdf->SetX(39);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $id_data), 0, 0, 'L');

	if ($arrRenew['end_date'] == '0000-00-00' || $arrRenew['end_date'] == '') {
		// $start_date = $row['start_date'];
		$end_date = thisYear($row['end_date']);
	} else {
		$end_date = thisYear($arrRenew['end_date']);
	}

	$pdf->SetY(108.5); //91
	$pdf->SetX(35);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', thaiDate($end_date)), 0, 0, 'L');

	$pdf->SetY(118.5); //100
	$pdf->SetX(28);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', 'MITSUBISHI'), 0, 0, 'L');

	$pdf->SetX(69); //64
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $arrModelCar['name'][$row['mo_car']]), 0, 0, 'L');

	$pdf->SetY(129); //105
	$pdf->SetX(43);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $insured_type . " " . $servicename), 0, 0, 'L');

	$pdf->SetX(83);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', number_format($costuse, 0)), 0, 0, 'L');

	$pdf->SetY(138.5); //112
	$pdf->SetX(55);
	$pdf->Cell(20, 6.5, iconv('UTF-8', 'TIS-620', number_format($total_pre, 2)), 0, 0, 'R');

	$net_renew = $total_pre + $act_cost - $sumextra;

	//ความเสียหาย ความรับผิดชอบ
	$pdf->SetFont('angsa', 'B', 13);
	$pdf->SetY(93);
	$pdf->SetX(63);
	$pdf->Cell(118, 5, iconv('UTF-8', 'TIS-620', $pa1), 0, 0, 'R');

	$pdf->SetY(98);
	$pdf->SetX(63);
	$pdf->Cell(118, 5, iconv('UTF-8', 'TIS-620', '10,000,000'), 0, 0, 'R');

	$pdf->SetY(93 + 10);
	$pdf->SetX(63);
	$pdf->Cell(118, 5, iconv('UTF-8', 'TIS-620', $pa2), 0, 0, 'R');

	$pdf->SetY(124.5);
	$pdf->SetX(63);
	$pdf->Cell(118, 5, iconv('UTF-8', 'TIS-620', $pa3), 0, 0, 'R');

	$pdf->SetY(130);
	$pdf->SetX(63);
	$pdf->Cell(118, 5, iconv('UTF-8', 'TIS-620', $pa4), 0, 0, 'R');

	$pdf->SetX(10);
	$pdf->Cell(118, 5, iconv('UTF-8', 'TIS-620', $seat), 0, 0, 'R');

	$pdf->SetY(135);
	$pdf->SetX(63);
	$pdf->Cell(118, 5, iconv('UTF-8', 'TIS-620', $pa5), 0, 0, 'R');

	$pdf->SetY(140.5);
	$pdf->SetX(63);
	$pdf->Cell(118, 5, iconv('UTF-8', 'TIS-620', $pa6), 0, 0, 'R');
	/////////////////////////////////////
	$setY = 208.3;
	$pdf->SetY(208.3); //238 ชื่อลูกค้า
	$pdf->SetX(160);
	$pdf->SetFont('angsa', 'B', 13);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $row['title'] . ' ' . $row['name'] . ' ' . $row['last']), 0, 0, 'L');



	if ($row['n_insure'] != '') {
		$id_data = $row['n_insure'];
	} else {
		$id_data = $row['id_data'];
	}

	$exid_data = explode('/', $row['id_data']);
	if ($row['EditCar'] == 'Y') {
		$carbodyuse = $row['Edit_CarBody'];
	} else {
		$carbodyuse = $row['car_body'];
	}

	$arr_carbodyuse = explode(" ", $carbodyuse);
	$carbodyuse = $arr_carbodyuse[0];
	$excarbody = substr($carbodyuse, -5);

	$pdf->SetY($setY+6.5); //257
	$pdf->SetX(167);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', '23' . $exid_data[0] . $exid_data[2]), 0);

	$pdf->SetY($setY +10.8); //263
	$pdf->SetX(167);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $excarbody), 0);

	$pdf->SetY(242); //263 จำนวนเงิน
	$pdf->SetX(129.5);
	$pdf->Cell(40, 6, iconv('UTF-8', 'TIS-620', number_format($total_pre, 2)), 0, 0, 'C');
	
	$num2dg = str_replace(',', '',number_format($total_pre, 2));
	$numcutdot = str_replace('.', '', $num2dg);
	$pdf->SetY(250); //263 จำนวนเงินตัวอักษร
	$pdf->SetX(39.5);
	$pdf->Cell(130, 6, iconv('UTF-8', 'TIS-620', convert(23500)), 0, 0, 'C');

	$pdf->SetY(285.5); //295
	$pdf->SetX(5);

	$codeN = "|012555100145701 23" . $exid_data[0] . '' . $exid_data[2] . " " . $excarbody . " " . $numcutdot . "";

	$code = "|012555100145701\n23" . $exid_data[0] . '' . $exid_data[2] . "\n" . $excarbody . "\n" . $numcutdot . "";

	$pdf->Code128(5, 274, $code, 94, 10);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $codeN), 0);
}
$pdf->Output();
unlink($idqrcode);