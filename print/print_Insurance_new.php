<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
include "../services/Convert-Address.service.php";
include '../services/ActApiBack.service.php';
require('rotation.php');
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
function CMValue($data)
{
	return $data ? $data : 'ไม่ระบุ';
}

// mysql_select_db($db1,$cndb1);
$IDDATA = $_GET['IDDATA'];
$query = "SELECT ";
$query .= "data.id,";
$query .= "data.p_act,";
$query .= "data.doc_type,";
$query .= "data.login, "; // รหัสผู้แจ้ง
$query .= "data.com_data, "; // รหัสผู้แจ้ง
$query .= "tb_comp.name as comp_name, "; // บริษัทประกันภัย
$query .= "tb_comp.tel  as comp_tel, "; // เบอร์โทรศัพท์(แจ้งอุบัติเหตุ)
$query .= "tb_comp.picture, "; // picture
$query .= "tb_customer.sub as branch, "; // สาขา
$query .= "tb_customer.contact, "; // ชื่อผู้แจ้ง  contact
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

$query .= "detail.product, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product1, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product2, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product3, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product4, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product5, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product6, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product7, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product8, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product9, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product10, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product11, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product12, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product13, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product14, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.price_total, "; // ราคาทุนอุปกรณ์ตกแต่งเพิ่มเติม
$query .= "detail.add_price, "; // ราคาทุนอุปกรณ์ตกแต่งเพิ่มเติม

$query .= "detail.code_addon, "; // add on สุขใจ/โจรกรรม
$query .= "detail.code_addon_id, "; // add on สุขใจ/โจรกรรม
$query .= "detail.car_cat_acc_p_total, ";
$query .= "detail.car_cat_acc_b_total, ";
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
$query .= "req.EditCost, ";
$query .= "req.EditcostCost, ";
$query .= "req.EditProduct, ";
$query .= "req.Product as ReqProduct, ";
$query .= "req.TotalProduct, ";
$query .= "req.CostProduct, ";

$query .= "tb_customer.title_sub,";
$query .= "tb_customer.sub,";
$query .= "tb_customer.Email,";
$query .= "tb_customer.Email2,";
$query .= "tb_customer.Email3,";
$query .= "tb_customer.Email4,";
$query .= "tb_customer.Email5, ";
$query .= "tb_customer.Email6, ";
$query .= "tb_customer.Contact2 ";

$query .= "FROM data ";
$query .= "LEFT JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "LEFT JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "LEFT JOIN protect ON (data.id_data = protect.id_data) ";
$query .= "LEFT JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
$query .= "LEFT JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
$query .= "LEFT JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
$query .= "LEFT JOIN tb_cost ON (tb_cost.id = protect.costCost) ";
$query .= "LEFT JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query .= "LEFT JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
$query .= "LEFT JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
$query .= "LEFT JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
$query .= "LEFT JOIN tb_province ON (tb_province.id = insuree.province) ";
$query .= "LEFT JOIN tb_customer ON (tb_customer.user = data.login) ";
$query .= "LEFT JOIN req ON (req.id_data = data.id_data) ";
$query .= "WHERE data.id_data='$IDDATA'";

$row = PDO_CONNECTION::fourinsure_mitsu()->query($query)->fetch(PDO::FETCH_ASSOC);

$ExpAddress = new ConvertAddress(PDO_CONNECTION::fourinsure_mitsu());

if (!empty($row['car_cat_acc'])) {
	$carid_protect = $row['car_cat_acc'];
} else {
	$carid_protect = $row['car_id'];
}
if (!empty($row['car_cat_acc_p_total']) || !empty($row['car_cat_acc_b_total'])) {
	$car_cat_acc_text = "(กธ. " . number_format(str_replace(',', '', $row['car_cat_acc_p_total']), 2, '.', ',') . " + พรบ. " . number_format(str_replace(',', '', $row['car_cat_acc_b_total']), 2, '.', ',') . ")";
} else {
	$car_cat_acc_text = "";
}
if (!empty($carid_protect)) {
	$pass_car_sql = "SELECT * FROM tb_pass_car_type WHERE pass_car_id = '" . $carid_protect . "'";

	$pass_car_array = PDO_CONNECTION::fourinsure_insured()->query($pass_car_sql)->fetch(PDO::FETCH_ASSOC);

}

$protect_sql = "SELECT * FROM protect_09712 WHERE car_id='" . $carid_protect . "' AND DATE(exp_date) >= '" . $row['start_date'] . "'";
$protect_array = PDO_CONNECTION::fourinsure_mitsu()->query($protect_sql)->fetch(PDO::FETCH_ASSOC);


$car_id = $row['car_id'];
$arr_car_id = str_split($car_id);
$id_data_rec = $row['id_data'];
$nameCar = $row['mo_car_name'];
if (!empty($row['mo_sub'])) {
	$sqlQueMS = "SELECT * FROM tb_mo_car_sub where id = '" . $row['mo_sub'] . "'";
	$rowMS = PDO_CONNECTION::fourinsure_mitsu()->query($sqlQueMS)->fetch(PDO::FETCH_ASSOC);
	$nameCar = $rowMS['name'];
	$scw = $rowMS['desc'];
}

$query1 = "SELECT ";
$query1 .= "tb_tumbon.name as tumbon, ";
$query1 .= "tb_amphur.name as amphur, ";
$query1 .= "tb_province.name as province "; // จังหวัด
$query1 .= "FROM req ";
$query1 .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = req.Cus_tumbon) ";
$query1 .= "INNER JOIN tb_amphur ON (tb_amphur.id = req.Cus_amphur) ";
$query1 .= "INNER JOIN tb_province ON (tb_province.id = req.Cus_province) ";

$query1 .= "WHERE req.id_data='" . $row['id_data'] . "'";


$row1 = PDO_CONNECTION::fourinsure_mitsu()->query($query1)->fetch(PDO::FETCH_ASSOC);


$sqlMORE = "SELECT * FROM tb_acc";
$objQueryMORE = PDO_CONNECTION::fourinsure_mitsu()->query($sqlMORE)->fetchAll(PDO::FETCH_ASSOC);

$costOb = array();
foreach ($objQueryMORE as $rowCost) {
	$costOb['name'][$rowCost['id']] = $rowCost['name'];
	$costOb['price'][$rowCost['id']] = $rowCost['price'];
	$costOb['price2'][$rowCost['id']] = $rowCost['price2'];
}
$sqlMOREname = "SELECT * FROM tb_acc_new";
$objQueryMOREname = PDO_CONNECTION::fourinsure_mitsu()->query($sqlMOREname)->fetchAll(PDO::FETCH_ASSOC);

$costObname = array();
foreach ($objQueryMOREname as $rowCostname) {
	$costObname['name']['0' . $rowCostname['idcar']][$rowCostname['id']] = $rowCostname['name'];
}

$strfix = 500;

if ($row['EditProduct'] != 'Y') {
	if ($row['equit'] == 'Y' and $row['car_detail'] == '0') {
		$p = 0;
		$i = 0;
		$product = "product";
		$string = '';
		while ($i <= 14) {
			if ($i == 0) {
				if ($row[$product] != '0') {
					if ($p < 6) {
						$equit0 .= $row[$product] . " บาท,  ";
						$p++;
					} else if ($p < 12) {
						$equit1 .= $row[$product] . " บาท,  ";
						$p++;
					} else if ($p < 18) {
						$equit2 .= $row[$product] . " บาท,  ";
						$p++;
					}
				}
			} else {
				if ($row[$product . $i] != '0') {
					if ($p < 6) {
						$equit0 .= $row[$product . $i] . " บาท,  ";
						$p++;
					} else if ($p < 12) {
						$equit1 .= $row[$product . $i] . " บาท,  ";
						$p++;
					} else if ($p < 18) {
						$equit2 .= $row[$product . $i] . " บาท,  ";
						$p++;
					}
				}
			}
			$i++;
		}
	} else if ($row['equit'] == 'Y' and $row['car_detail'] != '0') {
		$p = 0;
		$i = 0;
		$exitNum = explode("|", $row['car_detail']);
		$string = '';
		$pre_add = 0;
		for ($i = 0; $i < count($exitNum); $i++) {
			$exitSplit = explode(",", $exitNum[$i]);
			if (number_format($costOb['name'][$exitSplit[1]], 0) == '1') {
				$priceAcc = 0;
			} else {
				$priceAcc = number_format($costOb['name'][$exitSplit[1]], 0);
			}
			if ($priceAcc == 0.00) {
				$string .= $costObname['name'][$row['cat_car']][$exitSplit[0]] . ' ';
				$p++;
			} else {
				$string .= $costObname['name'][$row['cat_car']][$exitSplit[0]] . ' ' . $priceAcc . ' บาท ';
				$p++;
			}
			//$pre_add+=$costOb['price'][$exitSplit[1]];
		}
		for ($s = 0; $s < strlen($string) / $strfix; $s++) {
			$eq[$s] = substr($string, $s * $strfix, $s * $strfix + $strfix);
		}
		$pre_add = $row['add_price'];
	} else {
		$pre_add = '0.00';
		$eq[0] .= "ไม่มี";
	}
}

if ($row['EditProduct'] == 'Y') {
	$p = 0;
	$i = 0;
	$pre_add = 0;
	$string = '';
	$exitNum = explode("|", $row['ReqProduct']);
	for ($i = 0; $i < count($exitNum); $i++) {
		$exitSplit = explode(",", $exitNum[$i]);
		if ($costOb['name'][$exitSplit[1]] == 0.00) {
			$string .= $costObname['name'][$row['cat_car']][$exitSplit[0]] . ' ';
			$p++;
		} else {
			$string .= $costObname['name'][$row['cat_car']][$exitSplit[0]] . ' ' . number_format($costOb['name'][$exitSplit[1]], 0) . ' บาท ';
			$p++;
		}

		
	}
	for ($s = 0; $s < strlen($string) / $strfix; $s++) {
		$eq[$s] = substr($string, $s * $strfix, $s * $strfix + $strfix);
	}
	$pre_add = $row['CostProduct'];
}

// add on
if ($row['code_addon'] != '') {
	$i = 0;
	$exitANum = explode(",", $row['code_addon']);
	$exitSelect = explode(",", $row['code_addon_id']);
	$costAD =  0;
	$addonView = '';
	for ($i = 0; $i < count($exitANum); $i++) {
		$exitADDON = explode(",", $exitANum[$i]);
		$sqlAddon = "select * from tb_addon where id = '" . $exitSelect[$i] . "'";
		$sqlArr = PDO_CONNECTION::fourinsure_mitsu()->query($sqlAddon)->fetch(PDO::FETCH_ASSOC);

		$addonView  =  $addonView . ' ' . $sqlArr['name_addon'] . ' ' . $sqlArr['id_add'] . '  เบี้ยเพิ่ม ' . $sqlArr['cost_insuran'] . '  บาท   ';
		$costAD = $costAD + $sqlArr['cost_insuran'];
	}
}

//-----------------สลักหลัง-------------------------------///
$ShowReqOld = '';
if ($row['send_req'] != '') {
	$ShowReqOld .= $row['send_req'];
}
if ($row['send_req2'] != '') {
	$ShowReqOld .= $row['send_req2'];
}
if ($row['send_cancel'] != '') {
	$ShowReqOld .= $row['send_cancel'];
}

$ShowReq = '';
if ($row['EditTime'] == 'Y') {
	$ShowReq .= "วันที่คุ้มครอง : " . date('d/m/Y', strtotime($row['EditTime_StartDate']));
}
if ($row['EditHr'] == 'Y') {
	$ShowReq .= "ผู้รับผลประโยชน์ : " . $row['EditHr_Detail'];
}
if ($row['EditAct'] == 'Y') {
	$ShowReq .= "เลขที่ พรบ. : " . $row['EditAct_id'];
}
if ($row['EditCar'] == 'Y') {
	$ShowReq .= "เลขตัวถัง : " . $row['Edit_CarBody'] . " / " . "เลขเครื่อง : " . $row['Edit_Nmotor'] . " / " . "สีรถ : " . $row['Edit_CarColor'];
}
if ($row['EditCancel'] == 'Y') {
	$ShowReq .= " ยกเลิก : " . $row['Cancel_Detail'] . " วันที่ : " . date('d/m/Y', strtotime($row['Req_Date']));
}
if ($row['EditCustomer'] == 'Y') {
	if ($row['EditPerson'] == 1) {
		$EDITPERSON = "บุคคลธรรมดา";
	} else if ($row['EditPerson'] == 2) {
		$EDITPERSON = "นิติบุคคล";
	}
	$ShowReq .= $EDITPERSON;
	$ShowReq .= " ชื่อผู้เอาประกันภัย : " . $row['Cus_title'] . " " . $row['Cus_name'] . " " . $row['Cus_last'];
	$ShowReq .= "ที่อยู่ :" . $row['Cus_add'];
	if ($row['Cus_group'] != "-" && $row['Cus_group'] != "") {
		$ShowReq .= " หมู่" . $row['Cus_group'];
	}
	if ($row['Cus_town'] != "-" && $row['Cus_town'] != "") {
		$ShowReq .= " " . $row['Cus_town'];
	}
	if ($row['Cus_lane'] != "-" && $row['Cus_lane'] != "") {
		$ShowReq .= " ซอย" . $row['Cus_lane'];
	}
	if ($row['Cus_road'] != "-") {
		$ShowReq .= " ถนน" . $row['Cus_road'];
	}
	if ($row1['Cus_province'] != "102") {
		$ShowReq .= "ต." . $row1['tumbon'] . " อ." . $row1['amphur'] . " จ." . $row1['province'] . " " . $row['Cus_postal'];
	} else {
		$ShowReq .= "แขวง" . $row1['tumbon'] . "  " . $row1['amphur'] . " " . $row1['province'] . " " . $row['Cus_postal'];
	}
}
if ($row['EditCost'] == 'Y') {
	$ShowReq .= "เปลี่ยนค่าเบี้ย : " . $row['EditcostCost'];
}

//------------------------------------------------------------------------------------------------
$address_pdf = "";
$address_pdf2 = "";
if ($row['add'] != "-" && $row['add'] != "") {
	$address_pdf .= $row['add'];
}
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
	$address_pdf2 .= 'ต.' . $row['tumbon_name'] . ' อ.' . $row['amphur_name'] . ' จ.' . $row['province_name'] . ' ' . $row['postal'];
} else {
	$address_pdf2 .= 'แขวง' . $row['tumbon_name'] . '  ' . $row['amphur_name'] . ' ' . $row['province_name'] . ' ' . $row['postal'];
}

$sendYear = date('Y', strtotime($row['send_date'])) + 543;
$startYear = date('Y', strtotime($row['start_date'])) + 543;
$endYear = date('Y', strtotime($row['end_date'])) + 543;
if (!empty($row['code_addon'])) {
	$addonarray = explode(",", $row['code_addon']);
	for ($xx = 0; $xx < count($addonarray); $xx++) {
		if ($addonarray[$xx] == "ADDON_PV") {
			$sqladdon_sql = "select * from tb_addon where code_addon = '" . $addonarray[$xx] . "'";

			$sqladdon_array = PDO_CONNECTION::fourinsure_mitsu()->query($sqlAddon)->fetch(PDO::FETCH_ASSOC);

			$premium_name = $sqladdon_array['name_addon'];
		}
	}
}

define('FPDF_FONTPATH', 'font/');

//หมก รุ่นรถเอา detail ไปดึงที่ four
$nameCar = LoadInformationCustomerFour::getModelCar($row['mo_car']);


$pdf = new PDF();
$pdf->AddPage();
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->AddFont('angsa', 'B', 'angsab.php');
$pdf->SetTextColor(255, 220, 203);
$pdf->SetFont('angsa', 'B', 30);
$pdf->RotatedText(110, 60, iconv('UTF-8', 'TIS-620', $premium_name), 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(false);

$pdf->Image('../images/ApplicationCarThEng_2.png', 0, 7.5, 210, 290);
$pdf->Image('../images/logo.gif', 6.5, 3, 80);
$pdf->Image('../i/dealer.png', 6.5, 27, 20);

$pdf->SetTextColor(255, 0, 0);
$pdf->Ln(0);
$pdf->SetFont('angsa', 'B', 16);
$pdf->SetX(10);
$pdf->Cell(160, 5, iconv('UTF-8', 'TIS-620', 'แจ้งอุบัติเหตุ 24 ชั่วโมง '), 0, 0, "R");
$pdf->SetFont('angsa', 'B', 30);
$pdf->Cell(15, 4, iconv('UTF-8', 'TIS-620', '1557'), 0, 0, "R");
$pdf->SetFont('angsa', 'B', 16);
$pdf->Cell(20, 5, iconv('UTF-8', 'TIS-620', ' ทั่วประเทศ'), 0, 0, "R");
$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('angsa', 'B', 12);

// if ($row['com_data'] == 'VIB_S') {
// 	$str_addressComp = 'ที่อยู่ 71 หมู่ 6 สะพานนนทบุรี-บางบัวทอง ต.คลองข่อย อ.ปากเกร็ด จ.นนทบุรี 11120';
// 	$str_NameComp = 'ปากเกร็ด 345';
// } else if ($row['com_data'] == 'VIB_C') {
// 	$str_addressComp = 'ที่อยู่ 71 หมู่ 6 สะพานนนทบุรี-บางบัวทอง ต.คลองข่อย อ.ปากเกร็ด จ.นนทบุรี 11120';
// 	$str_NameComp = 'ปากเกร็ด 345';
// }

$str_addressComp = '';
$str_NameComp = '';

$pdf->SetX(6.5);
$pdf->Cell(0, 10, iconv('UTF-8', 'TIS-620', $str_NameComp.$row['title_sub'] . ' ' . $row['sub'] . '(' . $row['login'] . ')'), 0, 1, "L");
$pdf->SetFont('angsa', '', 9);
$pdf->SetX(50);
$pdf->Cell(155, -10, iconv('UTF-8', 'TIS-620', 'เลขที่กรมธรรม์ พ.ร.บ.: ' . $row['p_act']), 0, 1, "R");
$pdf->Ln(10);
$pdf->SetFont('angsa', 'B', 12);
$pdf->SetX(6.5);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'เลขที่รับแจ้ง : ' . $row['id_data']), 0, 1, "L");
$pdf->Ln(3);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $str_addressComp), 0, 1, "C");
$pdf->SetFont('angsa', '', 9);
$pdf->SetX(50);
// $pdf->Cell(155, 0, iconv('UTF-8', 'TIS-620', 'เลขที่ประจำตัวผู้เสียภาษี 0105490000219'), 0, 1, "R");
$pdf->SetFont('angsa', '', 12);
$pdf->Ln(5);
// $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'Tel. 02-196-8234 Fax. 02-196-8235'), 0, 1, "C");
$pdf->SetFont('angsa', '', 9);
$pdf->SetX(50);
// $pdf->Cell(155, 0, iconv('UTF-8', 'TIS-620', 'ทะเบียนการค้าเลขที่ 0105490000219'), 0, 1, "R");
$pdf->SetFont('angsa', '', 12);
$pdf->Ln(5);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', '		     	                                VIB                                                                                                                                                                                                                   ประเทศไทย'));
$pdf->Ln();
// $pdf->Cell(0,5,iconv('UTF-8','TIS-620','ใบคำขอเลขที่'));
$pdf->SetX(40);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(0, 5.5, iconv('UTF-8', 'TIS-620', $row['id_data']));
$pdf->Ln();
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 16, '');
$pdf->Ln();
// $pdf->Cell(0,-25,iconv('UTF-8','TIS-620','ผู้เอาประกันภัย     ชื่อ    '));
$pdf->SetX(64);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(0, -24.8, iconv('UTF-8', 'TIS-620', $row['title'] . ' ' . $row['name'] . ' ' . $row['last']), 0);

if ($row['person'] == '1') {
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(0, -38, iconv('UTF-8', 'TIS-620', 'เลขที่บัตรประชาชน / ID Passport no : ' . $row['icard'] . "   "), 0, 0, "R");
}
if ($row['person'] == '2') {
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(0, -38, iconv('UTF-8', 'TIS-620', 'เลขทะเบียนนิติบุคคล / Tax Identification No. : ' . $row['icard'] . "   "), 0, 0, "R");
}

$pdf->SetFont('angsa', '', 12);
$pdf->SetY(40);
// $pdf->Cell(0,33,iconv('UTF-8','TIS-620','                             ที่อยู่  '),0);
$pdf->SetY(40.5);
$pdf->SetX(68);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(0, 33, iconv('UTF-8', 'TIS-620', $address_pdf), 0);
$pdf->SetY(73.2);
$pdf->SetX(68);
$pdf->Cell(0, -25, iconv('UTF-8', 'TIS-620', $address_pdf2), 0);
$pdf->Ln(-10);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 13, '');
$pdf->Ln();
$pdf->SetX(30);
$pdf->Cell(0, -20, iconv('UTF-8', 'TIS-620', $row['title_num1'] . $row['name_num1'] . ' ' . CMValue($row['last_num1'])), 0);
$pdf->SetX(144);
$pdf->Cell(0, -20, iconv('UTF-8', 'TIS-620', CMValue($row['birth_num1'])), 0);
$pdf->Ln();
$pdf->SetX(30);
$pdf->Cell(0, 30, iconv('UTF-8', 'TIS-620', $row['title_num2'] . $row['name_num2'] . ' ' . CMValue($row['last_num2'])), 0);
$pdf->SetX(144);
$pdf->Cell(0, 30, iconv('UTF-8', 'TIS-620', CMValue($row['birth_num2'])), 0);
$pdf->Ln(18);
$pdf->SetX(45);
$pdf->Cell(0, 5.5, iconv('UTF-8', 'TIS-620', CMValue($row['name_gain'])));
$pdf->Ln(6);
$pdf->SetX(52);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', date('d/m', strtotime($row['start_date'])) . '/' . $startYear), 0);
$pdf->SetX(115);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', date('d/m', strtotime($row['end_date'])) . '/' . $endYear), 0);
$pdf->SetX(157);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', '16.30 น.'), 0);


// $pdf->Ln(6);
// $pdf->Cell(0,5,iconv('UTF-8','TIS-620','รายการรถยนต์ที่เอาประกันภัย'));
// $pdf->Ln(6);
// $pdf->MultiCell(9,5,iconv('UTF-8','TIS-620','ลำดับ'),"C");
// $pdf->Ln(-6);
// $pdf->SetX(19);
// $pdf->Cell(12,5,iconv('UTF-8','TIS-620','รหัส'),0,"C");
// $pdf->SetX(31);
// $pdf->Cell(40,5,iconv('UTF-8','TIS-620','ชื่อรถยนต์/รุ่น/เกียร์'),0,"C");
// $pdf->SetX(71);
// $pdf->Cell(20,5,iconv('UTF-8','TIS-620','เลขทะเบียน'),0,"C");
// $pdf->SetX(91);
// $pdf->Cell(40,5,iconv('UTF-8','TIS-620','เลขตัวถัง'),0,"C");
// $pdf->SetX(131);
// $pdf->Cell(20,5,iconv('UTF-8','TIS-620','ปีรุ่น'),0,"C");
// $pdf->SetX(151);
// $pdf->Cell(30,5,iconv('UTF-8','TIS-620','เลขเครื่อง'),0,"C");
// $pdf->SetX(181);
// $pdf->Cell(19,5,iconv('UTF-8','TIS-620','ที่นั่ง/ขนาด/น.น.'),0,"C");
// $pdf->Ln(1);
$pdf->SetFont('angsa', 'B', 12);
$pdf->SetY(101);
// $pdf->MultiCell(9,12,iconv('UTF-8','TIS-620',''),"C");
// $pdf->Ln(-12);
$pdf->SetX(16);

if ($row['car_cat_acc'] != '') {
	$pdf->Cell(12, 5, iconv('UTF-8', 'TIS-620', $row['car_cat_acc']), 0, 0, "C");
} else {
	$pdf->Cell(12, 5, iconv('UTF-8', 'TIS-620', $row['car_id']), 0, 0, "C");
}
$pdf->SetX(30);
$pdf->Cell(40, 2, iconv('UTF-8', 'TIS-620', $row['car_brand']), 0, 0, "C");
$pdf->SetY(103);
$pdf->SetX(30);
$pdf->Cell(40, 5, iconv('UTF-8', 'TIS-620', $nameCar . ' (' . $row['gear'] . ')'), 0, 0, "C");
$pdf->SetY(101);
$pdf->SetX(75);
$pdf->Cell(20, 5, iconv('UTF-8', 'TIS-620', $row['car_regis']), 0, 0, "C");
$pdf->SetX(93);
$car_body_text = explode(" ", $row['car_body']);
$pdf->Cell(40, 5, iconv('UTF-8', 'TIS-620', $car_body_text[0]), 0, 0, "C");
$pdf->SetX(93);
$pdf->Cell(40, 12, iconv('UTF-8', 'TIS-620', $car_body_text[1]), 0, 0, "C");
$pdf->SetX(126.5);
$pdf->Cell(20, 5, iconv('UTF-8', 'TIS-620', $row['regis_date']), 0, 0, "C");
$pdf->SetX(142);
$pdf->Cell(30, 5, iconv('UTF-8', 'TIS-620', str_replace('-', '', $row['n_motor'])), 0, 0, "C");
$pdf->SetX(178);

function spit_text()
{
}
if (empty($scw)) {
	if ($row['mo_car'] == "759" || $row['mo_car'] == "747") {
		$scw = "7 / 1600 / 3";
	} else if ($row['mo_car'] == "1098") {
		if ($row['car_id'] == "320") {
			$scw = "3 / 1600 / 3";
		} else {
			$scw = "12 / 1600 / 3";
		}
	} else if ($row['mo_car'] == "1951") {
		$scw = "7 / 1200 / 3";
	} else if ($row['mo_car'] == "754") {
		$scw = "7 / 2000 / 3";
	}
}
$pdf->Cell(19, 5, iconv('UTF-8', 'TIS-620', $scw), 0, 0, "C");
// $pdf->Ln(12);
// $pdf->SetFont('angsa','',9);
// $pdf->Cell(0,5,iconv('UTF-8','TIS-620','จำนวนเงินเอาประกันภัย : กรมธรรม์ประกันภัยนี้ให้การคุ้มครองเฉพาะข้อตกลงคุ้มครองที่มีจำนวนเงินเอาประกันภัยระบุไว้เท่านั้น'));
// $pdf->Ln(5);
// $pdf->SetFont('angsa','',12);
// $pdf->Cell(60,5,iconv('UTF-8','TIS-620','ความรับผิดชอบต่อบุคคลภายนอก'),0,"C");
// $pdf->Cell(55,5,iconv('UTF-8','TIS-620','รถยนต์เสียหาย สูญหาย ไฟไหม้'),0,"C");
// $pdf->Cell(75,5,iconv('UTF-8','TIS-620','ความคุ้มครองตามเอกสารแนบท้าย'),0,"C");
// $pdf->Ln(6);
// $pdf->Cell(60,54,iconv('UTF-8','TIS-620',''),0,"C");
// $pdf->Ln(-24);
// $pdf->Cell(60,54,iconv('UTF-8','TIS-620','1) ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย'),0,"L");
// $pdf->Ln(6);
// $pdf->Cell(60,54,iconv('UTF-8','TIS-620','     เฉพาะส่วนเกินวงเงินสูงสุดตาม พ.ร.บ.'),0,"L");

if ($row['car_id'] == "110") {
	$payp = "1,000,000";
} else {
	$payp = "300,000";
}
$pdf->Ln(40);
$pdf->SetX(30);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(10, 5, iconv('UTF-8', 'TIS-620', $protect_array['damage_out1']), 0, 0, "R");
// $pdf->SetFont('angsa','',12);
// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,"L");
// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/คน'),0,"L");

$pdf->Ln(5);
$pdf->SetX(30);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(10, 3, iconv('UTF-8', 'TIS-620', $protect_array['damage_notover']), 0, 0, "R");
// $pdf->SetFont('angsa','',12);
// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,"L");
// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,"L");

// $pdf->Ln(6);
// $pdf->Cell(60,54,iconv('UTF-8','TIS-620','2) ความเสียหายต่อทรัพย์สิน'),0,"L");


if ($row['car_id'] == "110") {
	$payp = "5,000,000";
} else if ($row['car_id'] == "320") {
	$payp = "1,000,000";
} else {
	$payp = "600,000";
}
$pdf->Ln(13);
$pdf->SetFont('angsa', 'B', 12);
$pdf->SetX(30);
$pdf->Cell(10, 5, iconv('UTF-8', 'TIS-620', $protect_array['damage_cost']), 0, 0, "R");
// $pdf->SetFont('angsa','',12);
// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,"L");
// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,"L");

// $pdf->Ln(6);
// $pdf->Cell(60,54,iconv('UTF-8','TIS-620','     2.1 ความเสียหายส่วนแรก'),0,"L");
if ($row['car_cat_acc'] == '230') {
	$frist = "-";
	$frist_1_1 = "3,000";
} else if ($row['car_cat_acc'] == '120') {
	$frist = "-";
	$frist_1_1 = "3,000";
} else if ($row['car_id'] == "220" or $row['car_id'] == "230" or $row['car_cat_acc'] == '220') {
	$frist = "-";
	$frist_1_1 = "-";
} else {
	$frist = "-";
	$frist_1_1 = "1,500";
}
$pdf->SetFont('angsa', 'B', 12);
$pdf->Ln(12);
$pdf->SetX(30);
$pdf->Cell(10, 4, iconv('UTF-8', 'TIS-620', $frist), 0, 0, "R");
// $pdf->SetFont('angsa','',12);
// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,"L");
// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,"L");

// $pdf->Ln(-12);
// $pdf->SetX(70);
// $pdf->Cell(55,54,iconv('UTF-8','TIS-620',''),0,"C");
// $pdf->Ln(-24);
// $pdf->SetX(70);
// $pdf->Cell(55,54,iconv('UTF-8','TIS-620','1) ความเสียหายต่อรถยนต์'),0,0,"L");
$cost_exp = explode(' ', $row['cost']);
$cost = preg_replace("/[^0-9]/", "", $cost_exp[0]);

if ($row['insure_year'] == '2') {
	$cost_new = number_format($cost - 30000);
} else if ($row['insure_year'] == '3') {
	$cost_new = number_format($cost - 90000);
} else {
	$cost_new = number_format($cost);
}

$pdf->Ln(1);
$pdf->SetX(88);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(10, -68.5, iconv('UTF-8', 'TIS-620', $cost_new), 0, 0, "R");
// $pdf->SetFont('angsa','',12);
// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
// $pdf->Ln(6);
// $pdf->SetX(70);
// $pdf->Cell(55,54,iconv('UTF-8','TIS-620','     1.1 ความเสียหายส่วนแรก'),0,0,"L");
$pdf->Ln(14);
$pdf->SetX(88);
$pdf->SetFont('angsa', 'B', 12);
// $pdf->SetTextColor(255, 0, 0);
$pdf->Cell(10, -70, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");

$pdf->SetTextColor(0, 0, 0);
// $pdf->SetFont('angsa','',12);
// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','   บาท'),0,0,"L");
// $pdf->Ln(6);
// $pdf->SetX(70);
// $pdf->Cell(55,54,iconv('UTF-8','TIS-620','2) รถยนต์สูญหาย/ไฟไหม้'),0,0,"L");
$pdf->Ln(12);
$pdf->SetX(88);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(10, -65.5, iconv('UTF-8', 'TIS-620', $cost_new), 0, 0, "R");

// $pdf->SetFont('angsa','',12);
// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");

// $pdf->Ln(6);
// $pdf->SetX(70);
// $pdf->SetFont('angsa','B',12);
// $pdf->Cell(40,54,iconv('UTF-8','TIS-620','-'),0,0,"R");
// $pdf->SetFont('angsa','',12);
// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");

$pdf->SetFont('angsa', '', 31);
$pdf->SetY(155);
$pdf->SetX(75);
$pdf->Cell(55, 54, iconv('UTF-8', 'TIS-620', 'ซ่อมห้าง'), 0, 0, "C");
$pdf->SetY(165);
$pdf->SetX(75);
$pdf->Cell(55, 54, iconv('UTF-8', 'TIS-620', 'Dealer Garage'), 0, 0, "C");
// $pdf->Ln(-22);
// $pdf->SetX(125);
// $pdf->SetFont('angsa','',12);

// $pdf->Cell(75,54,iconv('UTF-8','TIS-620',''),1,0,"C");
// $pdf->Ln(-24);
// $pdf->SetX(125);
// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','1) อุบัติเหตุส่วนบุคคล'),0,0,"L");
// $pdf->Ln(6);
// $pdf->SetX(125);
// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','     1.1 เสียชีวิต สูญเสียอวัยวะ ทุพพลภาพถาวร'),0,0,"L");
// $pdf->Ln(6);
// $pdf->SetX(125);
// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','     ก) ผู้ขับขี่ 1 คน'),0,0,"L");
if ($row['car_id'] == "110") {
	$strOption1 = "200,000";
} else if ($row['car_id'] == "320") {
	$strOption1 = "50,000";
} else {
	$strOption1 = "50,000";
}
$pdf->SetY(118.5);
$pdf->SetX(110);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(60, 54, iconv('UTF-8', 'TIS-620', $protect_array['pa1']), 0, 0, "R");
// $pdf->SetFont('angsa','',12);
// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท'),0,0,"L");


if ($row['car_cat_acc'] == '220') {
	$strOption = "14";
} else if ($row['car_cat_acc'] != '') {
	$strOption = "11";
} else {
	if ($row['car_id'] == "110") {
		$strOption = "6";
	} else if ($row['car_id'] == "320") {
		$strOption = "2";
	} else {
		$strOption = "-";
	}
}

$pdf->Ln(4.3);
$pdf->SetX(150.2);
$pdf->Cell(75, 54, iconv('UTF-8', 'TIS-620', $protect_array['people']), 0, 0, "L");
$pdf->SetX(169.4);
$pdf->Cell(75, 54, iconv('UTF-8', 'TIS-620', $protect_array['people']), 0, 0, "L");
$pdf->Ln(5.3);
$pdf->SetX(110);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(60, 54, iconv('UTF-8', 'TIS-620', $protect_array['pa2']), 0, 0, "R");
// $pdf->SetFont('angsa','',12);
// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/คน'),0,0,"L");

// $pdf->Ln(6);
// $pdf->SetX(125);
// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','     1.2) ทุพพลภาพชั่วคราว'),0,0,"L");

// $pdf->SetX(125);
// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','     ก) ผู้ขับขี่ 1 คน'),0,0,"L");
$pdf->Ln(6);
$pdf->SetX(110);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(60, 69.5, iconv('UTF-8', 'TIS-620', $protect_array['pa5']), 0, 0, "R");

// $pdf->SetFont('angsa','',12);
// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
// $pdf->Cell(23,54,iconv('UTF-8','TIS-620','บาท/สัปดาห์'),0,0,"L");

// $pdf->Ln(6);
$pdf->SetX(151);
$pdf->Cell(75, 78, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "L");
$pdf->SetX(170.5);
$pdf->Cell(75, 78, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "L");

$pdf->SetX(107);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(50, 91, iconv('UTF-8', 'TIS-620', $protect_array['pa6']), 0, 0, "R");

// $pdf->SetFont('angsa','',12);
// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
// $pdf->Cell(23,54,iconv('UTF-8','TIS-620','บาท/คน/สัปดาห์'),0,0,"L");

if ($row['car_id'] == "110") {

	$strOption = "200,000";
	$strOption1 = "200,000";
} else if ($row['car_id'] == "320") {
	$strOption = "50,000";
	$strOption1 = "200,000";
} else {
	$strOption = "50,000";
	$strOption1 = "200,000";
}


// $pdf->Ln(6);
// $pdf->SetX(125);
// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','2) ค่ารักษาพยาบาล'),0,0,"L");
$pdf->SetX(110);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(60, 109, iconv('UTF-8', 'TIS-620', $protect_array['pa3']), 0, 0, "R");
// $pdf->SetFont('angsa','',12);
// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/คน'),0,0,"L");

// $pdf->Ln(6);
// $pdf->SetX(125);
// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','3) การประกันตัวผู้ขับขี่'),0,0,"L");
$pdf->SetX(110);
$pdf->SetFont('angsa', 'B', 12);
$pdf->Cell(60, 125.5, iconv('UTF-8', 'TIS-620', $protect_array['pa4']), 0, 0, "R");
// $pdf->SetFont('angsa','',12);
// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
// $pdf->Ln(30);
// $pdf->Cell(115,9,iconv('UTF-8','TIS-620',''),1,0,"C");
$pdf->SetX(100);
$pdf->SetFont('angsa', '', 9);
// $pdf->Cell(95,5,iconv('UTF-8','TIS-620','เบี้ยประกันตามความคุ้มครองหลัก'),0,0,"L");
$pdf->Cell(2, 135.5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "L");
// $pdf->Cell(18,5,iconv('UTF-8','TIS-620','บาท'),0,0,"L");

// $pdf->Ln(4);
// $pdf->SetX(10);
// $pdf->Cell(95,5,iconv('UTF-8','TIS-620','(เบี้ยประกันภัยได้หักส่วนลดกรณีระบุชื่อผู้ขับขี่'),0,0,"L");
$pdf->SetY(203);
$pdf->SetX(100);
$pdf->Cell(2, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "L");
// $pdf->Cell(18,5,iconv('UTF-8','TIS-620','บาทแล้ว)'),0,0,"L");

// $pdf->Ln(-4);
// $pdf->SetX(125);
// $pdf->Cell(75,9,iconv('UTF-8','TIS-620',''),1,0,"C");
$pdf->SetY(199.4);
$pdf->SetX(134.5);
// $pdf->Cell(60,5,iconv('UTF-8','TIS-620','เบี้ยประกันภัยตามเอกสารแนบท้าย'),0,0,"L");
$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");
// $pdf->Cell(13,5,iconv('UTF-8','TIS-620','บาท'),0,0,"L");
// $pdf->Ln(9);
// $pdf->Cell(10,9,iconv('UTF-8','TIS-620','ส่วนลด'),1,0,"C");
// $pdf->Cell(50,9,iconv('UTF-8','TIS-620',''),1,0,"L");
// $pdf->Ln(-2);
// $pdf->SetX(20);
// $pdf->Cell(50,9,iconv('UTF-8','TIS-620','ความเสียหายส่วนแรก'),0,0,"L");
$setY = 210.5;
$pdf->SetY($setY);
$pdf->SetX(18);
$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");
// $pdf->Ln(4);
// $pdf->SetX(20);
// $pdf->Cell(50,9,iconv('UTF-8','TIS-620','อื่นๆ'),0,0,"L");
$pdf->SetY(214.5);
$pdf->SetX(18);
$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");
// $pdf->Ln(-2);
// $pdf->SetX(70);
// $pdf->Cell(65,9,iconv('UTF-8','TIS-620',''),1,0,"L");
// $pdf->Ln(-2);
// $pdf->SetX(70);
// $pdf->Cell(65,9,iconv('UTF-8','TIS-620','ส่วนลดกลุ่ม'),0,0,"L");
$pdf->SetY($setY);
$pdf->SetX(80);
$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");
// $pdf->Ln(4);
// $pdf->SetX(70);
// $pdf->Cell(65,9,iconv('UTF-8','TIS-620','รวมส่วนลด'),0,0,"L");
$pdf->SetY(214.5);
$pdf->SetX(80);
$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");
// $pdf->Ln(-2);
// $pdf->SetX(135);
// $pdf->Cell(65,9,iconv('UTF-8','TIS-620',''),1,0,"L");
// $pdf->Ln(-2);
// $pdf->SetX(135);
// $pdf->Cell(65,9,iconv('UTF-8','TIS-620','ประวัติดี'),0,0,"L");
$pdf->SetY($setY);
$pdf->SetX(134.5);
$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");

// $pdf->Ln(11);
// $pdf->Cell(10,5,iconv('UTF-8','TIS-620','ส่วนเพิ่ม'),1,0,"C");
// $pdf->Cell(180,5,iconv('UTF-8','TIS-620',''),1,0,"L");
// $pdf->Ln(-3);
// $pdf->SetX(20);
// $pdf->Cell(180,12,iconv('UTF-8','TIS-620','ประวัติเพิ่ม'),0,0,"L");
$pdf->SetY(220);
$pdf->SetX(76.5);
$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "C");

$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('angsa', 'B', 14);
$pdf->SetY(220);
$pdf->SetX(152);
//$pdf->Cell(50,5,iconv('UTF-8','TIS-620','ชำระอากรแล้ว'),0,0,"R");
// $pdf->SetFont('angsa','',12);
$pdf->SetTextColor(0, 0, 0);

// $pdf->Ln(9);
// $pdf->SetFont('angsa','',10);
// $pdf->Cell(60,5,iconv('UTF-8','TIS-620','เบี้ยประกันสุทธิ'),1,0,"C");
// $pdf->SetX(70);
// $pdf->Cell(45,5,iconv('UTF-8','TIS-620','อากร'),1,0,"C");
// $pdf->SetX(115);
// $pdf->Cell(35,5,iconv('UTF-8','TIS-620','ภาษีมูลค่าเพิ่ม'),1,0,"C");
// $pdf->SetX(150);
// $pdf->Cell(50,5,iconv('UTF-8','TIS-620','รวม'),1,0,"C");
// $pdf->Ln(5);
$pdf->SetFont('angsa', '', 14);

$query_UCostRenew = "SELECT pre,stamp,tax,net FROM UCostRenew WHERE type = 'S_Rate' AND cost = '" . $cost . "' AND service = '2'";
$row_UCostRenew = PDO_CONNECTION::fourinsure_mitsu()->query($query_UCostRenew)->fetch(PDO::FETCH_ASSOC);


if ($row['insure_year'] == '2') {
	$pre = number_format($row_UCostRenew['pre'], 2);
	$stamp = number_format($row_UCostRenew['stamp'], 2);
	$tax = number_format($row_UCostRenew['tax'], 2);
	$net = number_format($row_UCostRenew['net'], 2);
} else if ($row['insure_year'] == '3') {
	$pre = number_format($row_UCostRenew['pre'], 2);
	$stamp = number_format($row_UCostRenew['stamp'], 2);
	$tax = number_format($row_UCostRenew['tax'], 2);
	$net = number_format($row_UCostRenew['net'], 2);
} else {
	$pre = number_format($row['pre'], 2);
	$stamp = number_format($row['stamp'], 2);
	$tax = number_format($row['tax'], 2);
	$net = number_format($row['net'], 2);
}
$pdf->SetY(232);
$pdf->SetX(10);
$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', $pre), 0, 0, "C");
$pdf->SetX(46);
$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', $stamp), 0, 0, "C");
$pdf->SetX(90);
$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', $tax), 0, 0, "C");
$pdf->SetX(150);
$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', $net), 0, 0, "C");

// $pdf->SetFont('angsa','',9);
// $pdf->Ln(6);
// $pdf->Cell(0,5,iconv('UTF-8','TIS-620','การใช้รถยนต์ '),0,0,"L");

$query_Passcar = "SELECT name FROM tb_pass_car_type WHERE id='$arr_car_id[1]$arr_car_id[2]' AND id_pass_car='$arr_car_id[0]'";


$row_Passcar = PDO_CONNECTION::fourinsure_mitsu()->query($query_Passcar)->fetch(PDO::FETCH_ASSOC);

$IDNAME = $row_Passcar['name'];
$rowcheck = 238.2;
$pdf->SetY($rowcheck);
$pdf->SetX(40);
$pdf->SetFont('angsa', 'B', 9);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $IDNAME), 0, 0, "L");
// $pdf->Ln(5);

//----------------------------------เงื่อนไขอุปกรณ์ตกแต่ง-------------------------------////

// $ShowReqOld = 'XXX';
if ($ShowReq == '' && $ShowReqOld == '') {
	// $pdf->Cell(0,35,iconv('UTF-8','TIS-620',''),0,0,"L");
	// $pdf->SetY(213);
	// $pdf->SetX(10);
	// $pdf->SetFont('angsa','',9);
	// $pdf->Cell(0,15,iconv('UTF-8','TIS-620','อุปกรณ์ตกแต่งเพิ่มเติม : '),0,0,"L");
	$rowcheck = 238.8;
	$pdf->SetY($rowcheck);
	$pdf->SetX(50);
	$pdf->SetFont('angsa', 'B', 9);
	for ($i = 0; $i < count($eq); $i++) {
		$pdf->Cell(0, 15, iconv('UTF-8', 'TIS-620', $eq[$i]), 0, 0, "L");
		$pdf->SetY($rowcheck);
		$rowcheck = $rowcheck + 4;
	}

	if ($row['car_cat_acc_total'] != '0.00' && $row['car_cat_acc'] != '') {
		if ($row['car_cat_acc'] == '220') {
			if ($row['EditProduct'] == 'Y') {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			} else {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			}
		} else if ($row['car_cat_acc'] == '230') {
			if ($row['EditProduct'] == 'Y') {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			} else {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			}
		} else if ($row['car_cat_acc'] == '120') {
			if ($row['EditProduct'] == 'Y') {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (120  รถยน์นั่งใช้เพื่อการพาณิชย์ ไม่ใช่รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			} else {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (120  รถยน์นั่งใช้เพื่อการพาณิชย์ ไม่ใช่รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			}
		} else {
			if ($row['EditProduct'] == 'Y') {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (' . $pass_car_array['pass_car_id'] . ' ' . $pass_car_array['name'] . ') เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			} else {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (' . $pass_car_array['pass_car_id'] . ' ' . $pass_car_array['name'] . ') เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			}
		}
		$pdf->SetY(260);
		$pdf->SetX(198);
		$pdf->SetFont('angsa', 'B', 10);
		$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', $type_acc), 0, 0, "R");
	} else {
		/// ราคาสลักหลัง ///////////////////////////////////////////////////////////////
		$pdf->SetY(246);
		$pdf->SetFont('angsa', 'B', 10);

		if ($row['EditProduct'] != 'Y') {
			$TotalProduct = number_format($row['price_total']);
			$TotalPrice = number_format($row['add_price'], 2);
			if ($pre_add == 0.00) {
				//$pdf->Cell(0,15,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.number_format($pre_add,2,'.',',')."  บาท"),0,0,"R");
			} else {
				$pdf->SetX(198);
				$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', 'เพิ่มทุนอุปกรณ์รวม ' . $TotalProduct . ' บาท ' . 'เพิ่มเบี้ยรวม  ' . number_format($pre_add, 2, '.', ',') . "  บาท"), 0, 0, "R");
			}
		}
		if ($row['EditProduct'] == 'Y') {
			$TotalProduct = number_format($row['TotalProduct']);
			$TotalPrice = number_format($row['CostProduct'], 2);
			if ($pre_add > 0.00) {
				$pdf->SetX(198);
				$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', 'เพิ่มทุนอุปกรณ์รวม ' . $TotalProduct . ' บาท ' . 'เพิ่มเบี้ยรวม  ' . number_format($pre_add, 2, '.', ',') . "  บาท"), 0, 0, "R");
			}
		}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}

	/////////////////ADD ON ///////////////
	// $pdf->Ln(10);
	// $pdf->Cell(0,35,iconv('UTF-8','TIS-620',''),1,0,"L");
	// $pdf->SetY(229);
	// $pdf->SetX(10);
	// $pdf->SetFont('angsa','',9);
	// $pdf->Cell(0,15,iconv('UTF-8','TIS-620','Add On : '),0,0,"L");

	$pdf->SetY(259);
	$pdf->SetFont('angsa', 'B', 9);
	if ($row['code_addon'] != '') {
		$pdf->SetX(20);
		$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $addonView), 0, 0, "L");
		$pdf->SetFont('angsa', 'B', 10);
		$pdf->SetX(198);
		$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', 'เพิ่มเบี้ยรวม ' . number_format($costAD, 2) . "  บาท"), 0, 0, "R");
	} else {
		$pdf->SetX(20);
		$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'ไม่มี'), 0, 0, "L");
		//$pdf->Cell(0,15,iconv('UTF-8','TIS-620','เพิ่มเบี้ยรวม '.number_format(0,2)."  บาท"),0,0,"R");
	}
	/////////////////END ADD ON ///////////////


	// $pdf->Ln(10);
	// $pdf->SetFont('angsa','',9);

	if ($row['career'] == 1) {
		$note = 'ออกใบเสร็จในนามบริษัท';
	} else {
		$note = 'ออกใบเสร็จในนามลูกค้า';
	}
	if ($row['SendAdd'] != '') {
		if ($row['status_SendAdd'] == 'Y') {
			//$address_pdf='';
			$textaddarray = $ExpAddress->ExpMapperAddress($row['SendAdd']);
			$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : ' . $textaddarray . ')';
		} else {
			$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : ' . $row['SendAdd'] . ')';
		}
	}
	$pdf->SetFont('angsa', 'B', 9);
	$pdf->SetY(269.5);
	$pdf->SetX(27);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $note . $SendAdd), 0, 0, "L");
	// $pdf->Ln(13);
	// $pdf->SetFont('angsa','',12);
	// $pdf->Image('../images/2.jpg',15,259,4);
	// $pdf->Cell(0,5,iconv('UTF-8','TIS-620',''),0,0,"L");
	// $pdf->SetX(20);
	// $pdf->Cell(50,5,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
	// $pdf->SetX(50);
	// $pdf->Image('../images/1.jpg',55,259,4);
	$pdf->SetX(56.5);
	$pdf->Cell(60, 14.7, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, "L");

	$pdf->SetY(274.5);
	$pdf->SetFont('angsa', '', 11);
	$pdf->SetX(103);
	$pdf->Cell(60, 5, iconv('UTF-8', 'TIS-620', 'ประกันภัยโดยตรง'), 0, 0, "L");
	$pdf->SetFont('angsa', '', 11);
	$pdf->SetX(143);
	$pdf->Cell(60, 5, iconv('UTF-8', 'TIS-620', ''), 0, 0, "R");//ว.00018/2551
	// $pdf->Ln(6);
	// $pdf->Cell(50,5,iconv('UTF-8','TIS-620','วันทำสัญญาประกันภัย'),0,0,"L");

	$pdf->SetY(282.3);
	$pdf->SetX(63);
	$pdf->SetFont('angsa', '', 12);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', date('d/m', strtotime($row['start_date'])) . '/' . $startYear), 0, 0, "L");
	// $pdf->SetX(100);
	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(50,5,iconv('UTF-8','TIS-620','วันทำกรมธรรม์'),0,0,"L");
	// $pdf->SetX(150);
	// $pdf->SetFont('angsa','B',12);
	// $pdf->Cell(50,0,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['send_date'])).'/'.$sendYear),0,0,"C");
} else if ($ShowReq != '' || $ShowReqOld != '') {
	// $pdf->SetTextColor(255,0,0);

	// $pdf->Cell(0,15,iconv('UTF-8','TIS-620',''),0,0,"L");
	// $pdf->SetY(213);
	// $pdf->SetX(10);
	// $pdf->SetFont('angsa','',9);
	// $pdf->Cell(0,15,iconv('UTF-8','TIS-620','อุปกรณ์ตกแต่งเพิ่มเติม : '),0,0,"L");
	$pdf->SetFont('angsa', 'B', 9);
	$rowcheck = 238.8;
	$pdf->SetY($rowcheck);
	for ($i = 0; $i < count($eq); $i++) {
		$pdf->SetX(50);
		$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', $eq[$i]), 0, 0, "L");
		$pdf->SetY($rowcheck);
		$rowcheck = $rowcheck + 4;
	}


	if ($row['car_cat_acc_total'] != '0.00' && $row['car_cat_acc'] != '') {
		if ($row['car_cat_acc'] == '220') {
			if ($row['EditProduct'] == 'Y') {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			} else {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			}
		} else if ($row['car_cat_acc'] == '230') {
			if ($row['EditProduct'] == 'Y') {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			} else {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			}
		} else if ($row['car_cat_acc'] == '120') {
			if ($row['EditProduct'] == 'Y') {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (120  รถยน์นั่งใช้เพื่อการพาณิชย์ ไม่ใช่รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			} else {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (120  รถยน์นั่งใช้เพื่อการพาณิชย์ ไม่ใช่รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			}
		} else {
			if ($row['EditProduct'] == 'Y') {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (' . $pass_car_array['pass_car_id'] . ' ' . $pass_car_array['name'] . ') เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			} else {
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (' . $pass_car_array['pass_car_id'] . ' ' . $pass_car_array['name'] . ') เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
			}
		}
		$pdf->SetY(260);
		$pdf->SetX(198);
		$pdf->SetFont('angsa', 'B', 10);
		$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', $type_acc . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") "), 0, 0, "R");
	} else {
		$pdf->SetY(246);
		$pdf->SetFont('angsa', 'B', 10);
		if ($row['EditProduct'] != 'Y') {
			$TotalProduct = number_format($row['price_total']);
			$TotalPrice = number_format($row['add_price'], 2);
		}
		if ($row['EditProduct'] == 'Y') {
			$TotalProduct = number_format($row['TotalProduct']);
			$TotalPrice = number_format($row['CostProduct'], 2);
		}
		if ($TotalPrice == 0.00) {
			//$pdf->Cell(0,15,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.$TotalPrice."  บาท"." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") "),0,0,"R");
		} else {
			$pdf->SetX(198);
			$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', 'เพิ่มทุนอุปกรณ์รวม ' . $TotalProduct . ' บาท ' . 'เพิ่มเบี้ยรวม ' . $TotalPrice . "  บาท" . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") "), 0, 0, "R");
		}
	}
	// $pdf->Ln(10);
	// $pdf->Cell(0,35,iconv('UTF-8','TIS-620',''),1,0,"L");
	// $pdf->SetY(230);
	// $pdf->SetX(10);
	// $pdf->SetFont('angsa','',9);
	// $pdf->Cell(0,15,iconv('UTF-8','TIS-620','Add On : '),0,0,"L");
	// $pdf->SetX(31);
	// $pdf->SetFont('angsa','B',9);

	$pdf->SetY(259);
	$pdf->SetFont('angsa', 'B', 9);
	if ($row['code_addon'] != '') {
		$pdf->SetX(20);
		$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $addonView), 0, 0, "L");
		$pdf->SetFont('angsa', 'B', 10);
		$pdf->SetX(198);
		$pdf->Cell(5, 16, iconv('UTF-8', 'TIS-620', 'เพิ่มเบี้ยรวม ' . number_format($costAD, 2) . "  บาท"), 0, 0, "R");
	} else {
		$pdf->SetY(251.3);
		$pdf->SetX(20);
		$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', 'ไม่มี'), 0, 0, "L");
		//$pdf->Cell(0,15,iconv('UTF-8','TIS-620','เพิ่มเบี้ยรวม '.number_format(0,2)."  บาท"),0,0,"R");
	}


	// $pdf->Ln(10);
	// $pdf->SetFont('angsa','',9);

	// $pdf->Cell(0,19,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetY(257);
	$pdf->SetX(8);
	$pdf->Cell(0, 15, iconv('UTF-8', 'TIS-620', 'สลักหลัง :'), 0, 0, "L");
	$pdf->SetX(20);
	$pdf->SetFont('angsa', 'B', 9);
	$P_req = 0;
	$PCut_req = 0;
	if ($row['send_req'] != '') {
		$line[$P_req] .= $row['send_req'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
		$PCut_req++;
		if ($PCut_req >= 3) {
			$P_req++;
		}
	}
	if ($row['send_req2'] != '') {
		$line[$P_req] .= $row['send_req2'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
		$PCut_req++;
		if ($PCut_req >= 3) {
			$P_req++;
		}
	}
	if ($row['send_cancel'] != '') {
		$line[$P_req] .= $row['send_cancel'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
		$PCut_req++;
		if ($PCut_req >= 3) {
			$P_req++;
		}
	}

	if ($row['EditTime'] == 'Y') {
		$line[$P_req] .= "วันที่คุ้มครอง : " . date('d/m/Y', strtotime($row['EditTime_StartDate'])) . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
		$PCut_req++;
		if ($PCut_req >= 3) {
			$P_req++;
		}
	}
	if ($row['EditHr'] == 'Y') {
		$line[$P_req] .= " ผู้รับผลประโยชน์ : " . $row['EditHr_Detail'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . "]" . ' |';
		$PCut_req++;
		if ($PCut_req >= 3) {
			$P_req++;
		}
	}
	if ($row['EditAct'] == 'Y') {
		$line[$P_req] .= "เลขที่ พรบ. : " . $row['EditAct_id'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
		$PCut_req++;
		if ($PCut_req >= 3) {
			$P_req++;
		}
	}
	if ($row['EditCar'] == 'Y') {
		$line[$P_req] .= " เลขตัวถัง : " . $row['Edit_CarBody'] . " / " . "เลขเครื่อง : " . $row['Edit_Nmotor'] . " / " . "สีรถ : " . $row['Edit_CarColor'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
		$PCut_req++;
		if ($PCut_req >= 3) {
			$P_req++;
		}
	}
	if ($row['EditCancel'] == 'Y') {
		$line[$P_req] .= " ยกเลิก : " . $row['Cancel_Detail'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
		$PCut_req++;
		if ($PCut_req >= 3) {
			$P_req++;
		}
	}
	if ($row['EditCustomer'] == 'Y') {
		$line[$P_req] .= " ชื่อผู้เอาประกันภัย : " . $row['Cus_title'] . " " . $row['Cus_name'] . " " . $row['Cus_last'];
		$line[$P_req] .= " ที่อยู่ : " . $row['Cus_add'];
		if ($row['Cus_group'] != "-" && $row['Cus_group'] != "") {
			$line[$P_req] .=  " หมู่" . $row['Cus_group'];
		}
		if ($row['Cus_town'] != "-" && $row['Cus_town'] != "") {
			$line[$P_req] .= " " . $row['Cus_town'];
		}
		if ($row['Cus_lane'] != "-" && $row['Cus_lane'] != "") {
			$line[$P_req] .= " ซอย" . $row['Cus_lane'];
		}
		if ($row['Cus_road'] != "-" && $row['Cus_road'] != "") {
			$line[$P_req] .= " ถนน" . $row['Cus_road'];
		}
		if ($row['Cus_province'] != "102") {
			$line[$P_req] .= "ต." . $row1['tumbon'] . " อ." . $row1['amphur'] . " จ." . $row1['province'] . " " . $row['Cus_postal'];
		} else {
			$line[$P_req] .= "แขวง" . $row1['tumbon'] . "  " . $row1['amphur'] . " " . $row1['province'] . " " . $row['Cus_postal'];
		}
		$line[$P_req] .= " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' | ';
		$PCut_req++;
		if ($PCut_req >= 3) {
			$P_req++;
		}
	}
	if ($row['EditCost'] == 'Y') {
		$line[$P_req] .= "ค่าเบี้ย : " . $row['EditcostCost'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") ";
		$PCut_req++;
		if ($PCut_req >= 3) {
			$P_req++;
		}
	}

	for ($r = 0; $r <= $P_req; $r++) {
		if ($r == 0) {
			$pdf->Cell(0, 15, iconv('UTF-8', 'TIS-620', $line[$r]), 0, 0, "L");
		} else {
			$y = 235;
			$li = 4;
			$step = $y + ($li * $r);
			$pdf->SetY($step);
			$pdf->Cell(0, 15, iconv('UTF-8', 'TIS-620', $line[$r]), 0, 0, "L");
		}
	}
	if ($row['career'] == 1) {
		$note = 'ออกใบเสร็จในนามบริษัท';
	} else {
		$note = 'ออกใบเสร็จในนามลูกค้า';
	}

	if ($row['SendAdd'] != '') {
		if ($row['status_SendAdd'] == 'Y') {
			//$address_pdf='';
			$textaddarray = $ExpAddress->ExpMapperAddress($row['SendAdd']);
			$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : ' . $textaddarray . ')';
		} else {
			$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : ' . $row['SendAdd'] . ')';
		}
	}

	$pdf->SetFont('angsa', 'B', 9);
	$pdf->SetY(269.5);
	$pdf->SetX(27);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $note . $SendAdd), 0, 0, "L");
	// $pdf->Ln(13);
	// $pdf->SetFont('angsa','',12);
	// $pdf->Image('../images/2.jpg',15,259,4);
	// $pdf->Cell(0,5,iconv('UTF-8','TIS-620',''),1,0,"L");
	// $pdf->SetX(20);
	// $pdf->Cell(50,5,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
	// $pdf->SetX(50);
	// $pdf->Image('../images/1.jpg',55,259,4);
	$pdf->SetX(56.5);
	$pdf->Cell(60, 14.7, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, "L");

	$pdf->SetY(274.5);
	$pdf->SetFont('angsa', '', 11);
	$pdf->SetX(103);
	$pdf->Cell(60, 5, iconv('UTF-8', 'TIS-620', 'ประกันภัยโดยตรง'), 0, 0, "L");
	$pdf->SetFont('angsa', '', 11);
	$pdf->SetX(143);
	$pdf->Cell(60, 5, iconv('UTF-8', 'TIS-620', ''), 0, 0, "R");//ว.00018/2551
	// $pdf->Ln(6);
	// $pdf->Cell(50,5,iconv('UTF-8','TIS-620','วันทำสัญญาประกันภัย'),0,0,"L");

	$pdf->SetY(282.3);
	$pdf->SetX(63);
	$pdf->SetFont('angsa', '', 12);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', date('d/m', strtotime($row['start_date'])) . '/' . $startYear), 0, 0, "L");
}
// if($page = 1){
// 	goto next_page;
// 	$page = 2;
// }
// }




/** page 2 */ {
	$pdf->AddPage();
	$pdf->AddFont('angsa', '', 'angsa.php');
	$pdf->AddFont('angsa', 'B', 'angsab.php');
	$pdf->SetTextColor(255, 220, 203);
	$pdf->SetFont('angsa', 'B', 30);
	$pdf->RotatedText(110, 60, iconv('UTF-8', 'TIS-620', $premium_name), 0);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetMargins(5, 5, 5);
	$pdf->SetAutoPageBreak(false);

	$pdf->Image('../images/ApplicationCarThEng_2.png', 0, 7.5, 210, 290);
	$pdf->Image('../images/logo.gif', 6.5, 3, 80);
	$pdf->Image('../i/customer.png', 6.5, 27, 20);

	$pdf->SetTextColor(255, 0, 0);
	$pdf->Ln(0);
	$pdf->SetX(10);
	$pdf->SetFont('angsa', 'B', 16);
	$pdf->SetY(10);
	$pdf->Cell(165, 5, iconv('UTF-8', 'TIS-620', 'แจ้งอุบัติเหตุ 24 ชั่วโมง '), 0, 0, "R");
	$pdf->SetFont('angsa', 'B', 30);
	$pdf->Cell(15, 4, iconv('UTF-8', 'TIS-620', '1557'), 0, 0, "R");
	$pdf->SetFont('angsa', 'B', 16);
	$pdf->Cell(20, 5, iconv('UTF-8', 'TIS-620', ' ทั่วประเทศ'), 0, 0, "R");
	$pdf->Ln(5);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFont('angsa', 'B', 12);

	// if ($row['com_data'] == 'VIB_S') {
	// 	$str_addressComp = 'ที่อยู่ 71 หมู่ 6 สะพานนนทบุรี-บางบัวทอง ต.คลองข่อย อ.ปากเกร็ด จ.นนทบุรี 11120';
	// 	$str_NameComp = 'ปากเกร็ด 345';
	// } else if ($row['com_data'] == 'VIB_C') {
	// 	$str_addressComp = 'ที่อยู่ 71 หมู่ 6 สะพานนนทบุรี-บางบัวทอง ต.คลองข่อย อ.ปากเกร็ด จ.นนทบุรี 11120';
	// 	$str_NameComp = 'ปากเกร็ด 345';
	// }
	$pdf->SetY(15);
	$pdf->SetX(6.5);
	$pdf->Cell(0, 10, iconv('UTF-8', 'TIS-620', $str_NameComp.$row['title_sub'] . ' ' . $row['sub'] . '(' . $row['login'] . ')'), 0, 1, "L");
	$pdf->SetFont('angsa', '', 9);
	$pdf->SetX(50);
	$pdf->Cell(155, -10, iconv('UTF-8', 'TIS-620', 'เลขที่กรมธรรม์ พ.ร.บ.: ' . $row['p_act']), 0, 1, "R");
	$pdf->Ln(10);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->SetX(6.5);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'เลขที่รับแจ้ง : ' . $row['id_data']), 0, 1, "L");
	$pdf->Ln(3);
	$pdf->SetFont('angsa', '', 12);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $str_addressComp), 0, 1, "C");
	$pdf->SetFont('angsa', '', 9);
	$pdf->SetX(50);
	// $pdf->Cell(155, 0, iconv('UTF-8', 'TIS-620', 'เลขที่ประจำตัวผู้เสียภาษี 0105490000219'), 0, 1, "R");
	$pdf->SetFont('angsa', '', 12);
	$pdf->Ln(5);
	// $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'Tel. 02-196-8234 Fax. 02-196-8235'), 0, 1, "C");
	$pdf->SetFont('angsa', '', 9);
	$pdf->SetX(50);
	// $pdf->Cell(155, 0, iconv('UTF-8', 'TIS-620', 'ทะเบียนการค้าเลขที่ 0105490000219'), 0, 1, "R");
	$pdf->SetFont('angsa', '', 12);
	$pdf->Ln(5);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', '		     	                                VIB                                                                                                                                                                                                                   ประเทศไทย'));
	$pdf->Ln();
	// $pdf->Cell(0,5,iconv('UTF-8','TIS-620','ใบคำขอเลขที่'));
	$pdf->SetX(40);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(0, 5.5, iconv('UTF-8', 'TIS-620', $row['id_data']));
	$pdf->Ln();
	$pdf->SetFont('angsa', '', 12);
	$pdf->Cell(0, 16, '');
	$pdf->Ln();
	// $pdf->Cell(0,-25,iconv('UTF-8','TIS-620','ผู้เอาประกันภัย     ชื่อ    '));
	$pdf->SetX(64);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(0, -24.8, iconv('UTF-8', 'TIS-620', $row['title'] . ' ' . $row['name'] . ' ' . $row['last']), 0);

	if ($row['person'] == '1') {
		$pdf->SetFont('angsa', 'B', 12);
		$pdf->Cell(0, -38, iconv('UTF-8', 'TIS-620', 'เลขที่บัตรประชาชน / ID Passport no : ' . $row['icard'] . "   "), 0, 0, "R");
	}
	if ($row['person'] == '2') {
		$pdf->SetFont('angsa', 'B', 12);
		$pdf->Cell(0, -38, iconv('UTF-8', 'TIS-620', 'เลขทะเบียนนิติบุคคล / Tax Identification No. : ' . $row['icard'] . "   "), 0, 0, "R");
	}

	$pdf->SetFont('angsa', '', 12);
	$pdf->SetY(40);
	// $pdf->Cell(0,33,iconv('UTF-8','TIS-620','                             ที่อยู่  '),0);
	$pdf->SetY(40.5);
	$pdf->SetX(68);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(0, 33, iconv('UTF-8', 'TIS-620', $address_pdf), 0);
	$pdf->SetY(73.2);
	$pdf->SetX(68);
	$pdf->Cell(0, -25, iconv('UTF-8', 'TIS-620', $address_pdf2), 0);
	$pdf->Ln(-10);
	$pdf->SetFont('angsa', '', 12);
	$pdf->Cell(0, 13, '');
	$pdf->Ln();
	$pdf->SetX(30);
	$pdf->Cell(0, -20, iconv('UTF-8', 'TIS-620', $row['title_num1'] . $row['name_num1'] . ' ' . CMValue($row['last_num1'])), 0);
	$pdf->SetX(144);
	$pdf->Cell(0, -20, iconv('UTF-8', 'TIS-620', CMValue($row['birth_num1'])), 0);
	$pdf->Ln();
	$pdf->SetX(30);
	$pdf->Cell(0, 30, iconv('UTF-8', 'TIS-620', $row['title_num2'] . $row['name_num2'] . ' ' . CMValue($row['last_num2'])), 0);
	$pdf->SetX(144);
	$pdf->Cell(0, 30, iconv('UTF-8', 'TIS-620', CMValue($row['birth_num2'])), 0);
	$pdf->Ln(18);
	$pdf->SetX(45);
	$pdf->Cell(0, 5.5, iconv('UTF-8', 'TIS-620', CMValue($row['name_gain'])));
	$pdf->Ln(6);
	$pdf->SetX(52);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', date('d/m', strtotime($row['start_date'])) . '/' . $startYear), 0);
	$pdf->SetX(115);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', date('d/m', strtotime($row['end_date'])) . '/' . $endYear), 0);
	$pdf->SetX(157);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', '16.30 น.'), 0);


	// $pdf->Ln(6);
	// $pdf->Cell(0,5,iconv('UTF-8','TIS-620','รายการรถยนต์ที่เอาประกันภัย'));
	// $pdf->Ln(6);
	// $pdf->MultiCell(9,5,iconv('UTF-8','TIS-620','ลำดับ'),"C");
	// $pdf->Ln(-6);
	// $pdf->SetX(19);
	// $pdf->Cell(12,5,iconv('UTF-8','TIS-620','รหัส'),0,"C");
	// $pdf->SetX(31);
	// $pdf->Cell(40,5,iconv('UTF-8','TIS-620','ชื่อรถยนต์/รุ่น/เกียร์'),0,"C");
	// $pdf->SetX(71);
	// $pdf->Cell(20,5,iconv('UTF-8','TIS-620','เลขทะเบียน'),0,"C");
	// $pdf->SetX(91);
	// $pdf->Cell(40,5,iconv('UTF-8','TIS-620','เลขตัวถัง'),0,"C");
	// $pdf->SetX(131);
	// $pdf->Cell(20,5,iconv('UTF-8','TIS-620','ปีรุ่น'),0,"C");
	// $pdf->SetX(151);
	// $pdf->Cell(30,5,iconv('UTF-8','TIS-620','เลขเครื่อง'),0,"C");
	// $pdf->SetX(181);
	// $pdf->Cell(19,5,iconv('UTF-8','TIS-620','ที่นั่ง/ขนาด/น.น.'),0,"C");
	// $pdf->Ln(1);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->SetY(101);
	// $pdf->MultiCell(9,12,iconv('UTF-8','TIS-620',''),"C");
	// $pdf->Ln(-12);
	$pdf->SetX(16);

	if ($row['car_cat_acc'] != '') {
		$pdf->Cell(12, 5, iconv('UTF-8', 'TIS-620', $row['car_cat_acc']), 0, 0, "C");
	} else {
		$pdf->Cell(12, 5, iconv('UTF-8', 'TIS-620', $row['car_id']), 0, 0, "C");
	}
	$pdf->SetX(30);
	$pdf->Cell(40, 2, iconv('UTF-8', 'TIS-620', $row['car_brand']), 0, 0, "C");
	$pdf->SetY(103);
	$pdf->SetX(30);
	$pdf->Cell(40, 5, iconv('UTF-8', 'TIS-620', $nameCar . ' (' . $row['gear'] . ')'), 0, 0, "C");
	$pdf->SetY(101);
	$pdf->SetX(75);
	$pdf->Cell(20, 5, iconv('UTF-8', 'TIS-620', $row['car_regis']), 0, 0, "C");
	$pdf->SetX(93);
	$car_body_text = explode(" ", $row['car_body']);
	$pdf->Cell(40, 5, iconv('UTF-8', 'TIS-620', $car_body_text[0]), 0, 0, "C");
	$pdf->SetX(93);
	$pdf->Cell(40, 12, iconv('UTF-8', 'TIS-620', $car_body_text[1]), 0, 0, "C");
	$pdf->SetX(126.5);
	$pdf->Cell(20, 5, iconv('UTF-8', 'TIS-620', $row['regis_date']), 0, 0, "C");
	$pdf->SetX(142);
	$pdf->Cell(30, 5, iconv('UTF-8', 'TIS-620', str_replace('-', '', $row['n_motor'])), 0, 0, "C");
	$pdf->SetX(178);
	if (empty($scw)) {
		if ($row['mo_car'] == "759" || $row['mo_car'] == "747") {
			$scw = "7 / 1600 / 3";
		} else if ($row['mo_car'] == "1098") {
			if ($row['car_id'] == "320") {
				$scw = "3 / 1600 / 3";
			} else {
				$scw = "12 / 1600 / 3";
			}
		} else if ($row['mo_car'] == "1951") {
			$scw = "7 / 1200 / 3";
		} else if ($row['mo_car'] == "754") {
			$scw = "7 / 2000 / 3";
		}
	}
	$pdf->Cell(19, 5, iconv('UTF-8', 'TIS-620', $scw), 0, 0, "C");
	// $pdf->Ln(12);
	// $pdf->SetFont('angsa','',9);
	// $pdf->Cell(0,5,iconv('UTF-8','TIS-620','จำนวนเงินเอาประกันภัย : กรมธรรม์ประกันภัยนี้ให้การคุ้มครองเฉพาะข้อตกลงคุ้มครองที่มีจำนวนเงินเอาประกันภัยระบุไว้เท่านั้น'));
	// $pdf->Ln(5);
	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(60,5,iconv('UTF-8','TIS-620','ความรับผิดชอบต่อบุคคลภายนอก'),0,"C");
	// $pdf->Cell(55,5,iconv('UTF-8','TIS-620','รถยนต์เสียหาย สูญหาย ไฟไหม้'),0,"C");
	// $pdf->Cell(75,5,iconv('UTF-8','TIS-620','ความคุ้มครองตามเอกสารแนบท้าย'),0,"C");
	// $pdf->Ln(6);
	// $pdf->Cell(60,54,iconv('UTF-8','TIS-620',''),0,"C");
	// $pdf->Ln(-24);
	// $pdf->Cell(60,54,iconv('UTF-8','TIS-620','1) ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย'),0,"L");
	// $pdf->Ln(6);
	// $pdf->Cell(60,54,iconv('UTF-8','TIS-620','     เฉพาะส่วนเกินวงเงินสูงสุดตาม พ.ร.บ.'),0,"L");

	if ($row['car_id'] == "110") {
		$payp = "1,000,000";
	} else {
		$payp = "300,000";
	}
	$pdf->Ln(40);
	$pdf->SetX(30);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(10, 5, iconv('UTF-8', 'TIS-620', $protect_array['damage_out1']), 0, 0, "R");
	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,"L");
	// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/คน'),0,"L");

	$pdf->Ln(5);
	$pdf->SetX(30);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(10, 3, iconv('UTF-8', 'TIS-620', $protect_array['damage_notover']), 0, 0, "R");
	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,"L");
	// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,"L");

	// $pdf->Ln(6);
	// $pdf->Cell(60,54,iconv('UTF-8','TIS-620','2) ความเสียหายต่อทรัพย์สิน'),0,"L");


	if ($row['car_id'] == "110") {
		$payp = "5,000,000";
	} else if ($row['car_id'] == "320") {
		$payp = "1,000,000";
	} else {
		$payp = "600,000";
	}
	$pdf->Ln(13);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->SetX(30);
	$pdf->Cell(10, 5, iconv('UTF-8', 'TIS-620', $protect_array['damage_cost']), 0, 0, "R");
	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,"L");
	// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,"L");

	// $pdf->Ln(6);
	// $pdf->Cell(60,54,iconv('UTF-8','TIS-620','     2.1 ความเสียหายส่วนแรก'),0,"L");
	if ($row['car_cat_acc'] == '230') {
		$frist = "-";
		$frist_1_1 = "3,000";
	} else if ($row['car_cat_acc'] == '120') {
		$frist = "-";
		$frist_1_1 = "3,000";
	} else if ($row['car_id'] == "220" or $row['car_id'] == "230" or $row['car_cat_acc'] == '220') {
		$frist = "-";
		$frist_1_1 = "-";
	} else {
		$frist = "-";
		$frist_1_1 = "1,500";
	}

	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Ln(12);
	$pdf->SetX(30);
	$pdf->Cell(10, 4, iconv('UTF-8', 'TIS-620', $frist), 0, 0, "R");

	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,"L");
	// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,"L");

	// $pdf->Ln(-12);
	// $pdf->SetX(70);
	// $pdf->Cell(55,54,iconv('UTF-8','TIS-620',''),0,"C");
	// $pdf->Ln(-24);
	// $pdf->SetX(70);
	// $pdf->Cell(55,54,iconv('UTF-8','TIS-620','1) ความเสียหายต่อรถยนต์'),0,0,"L");

	$cost_exp = explode(' ', $row['cost']);
	$cost = preg_replace("/[^0-9]/", "", $cost_exp[0]);

	if ($row['insure_year'] == '2') {
		$cost_new = number_format($cost - 30000);
	} else if ($row['insure_year'] == '3') {
		$cost_new = number_format($cost - 90000);
	} else {
		$cost_new = number_format($cost);
	}

	$pdf->Ln(1);
	$pdf->SetX(88);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(10, -68.5, iconv('UTF-8', 'TIS-620', $cost_new), 0, 0, "R");
	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	// $pdf->Ln(6);
	// $pdf->SetX(70);
	// $pdf->Cell(55,54,iconv('UTF-8','TIS-620','     1.1 ความเสียหายส่วนแรก'),0,0,"L");
	$pdf->Ln(14);
	$pdf->SetX(88);
	$pdf->SetFont('angsa', 'B', 12);
	// $pdf->SetTextColor(255, 0, 0);
	$pdf->Cell(10, -70, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");

	$pdf->SetTextColor(0, 0, 0);
	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','   บาท'),0,0,"L");
	// $pdf->Ln(6);
	// $pdf->SetX(70);
	// $pdf->Cell(55,54,iconv('UTF-8','TIS-620','2) รถยนต์สูญหาย/ไฟไหม้'),0,0,"L");
	$pdf->Ln(12);
	$pdf->SetX(88);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(10, -65.5, iconv('UTF-8', 'TIS-620', $cost_new), 0, 0, "R");

	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");

	// $pdf->Ln(6);
	// $pdf->SetX(70);
	// $pdf->SetFont('angsa','B',12);
	// $pdf->Cell(40,54,iconv('UTF-8','TIS-620','-'),0,0,"R");
	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");

	$pdf->SetFont('angsa', '', 31);
	$pdf->SetY(155);
	$pdf->SetX(75);
	$pdf->Cell(55, 54, iconv('UTF-8', 'TIS-620', 'ซ่อมห้าง'), 0, 0, "C");
	$pdf->SetY(165);
	$pdf->SetX(75);
	$pdf->Cell(55, 54, iconv('UTF-8', 'TIS-620', 'Dealer Garage'), 0, 0, "C");
	// $pdf->Ln(-22);
	// $pdf->SetX(125);
	// $pdf->SetFont('angsa','',12);

	// $pdf->Cell(75,54,iconv('UTF-8','TIS-620',''),1,0,"C");
	// $pdf->Ln(-24);
	// $pdf->SetX(125);
	// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','1) อุบัติเหตุส่วนบุคคล'),0,0,"L");
	// $pdf->Ln(6);
	// $pdf->SetX(125);
	// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','     1.1 เสียชีวิต สูญเสียอวัยวะ ทุพพลภาพถาวร'),0,0,"L");
	// $pdf->Ln(6);
	// $pdf->SetX(125);
	// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','     ก) ผู้ขับขี่ 1 คน'),0,0,"L");
	if ($row['car_id'] == "110") {
		$strOption1 = "200,000";
	} else if ($row['car_id'] == "320") {
		$strOption1 = "50,000";
	} else {
		$strOption1 = "50,000";
	}
	$pdf->SetY(118.5);
	$pdf->SetX(110);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(60, 54, iconv('UTF-8', 'TIS-620', $protect_array['pa1']), 0, 0, "R");
	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท'),0,0,"L");


	if ($row['car_cat_acc'] == '220') {
		$strOption = "14";
	} else if ($row['car_cat_acc'] != '') {
		$strOption = "11";
	} else {
		if ($row['car_id'] == "110") {
			$strOption = "6";
		} else if ($row['car_id'] == "320") {
			$strOption = "2";
		} else {
			$strOption = "-";
		}
	}

	$pdf->Ln(4.3);
	$pdf->SetX(150.2);
	$pdf->Cell(75, 54, iconv('UTF-8', 'TIS-620', $protect_array['people']), 0, 0, "L");
	$pdf->SetX(169.4);
	$pdf->Cell(75, 54, iconv('UTF-8', 'TIS-620', $protect_array['people']), 0, 0, "L");
	$pdf->Ln(5.3);
	$pdf->SetX(110);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(60, 54, iconv('UTF-8', 'TIS-620', $protect_array['pa2']), 0, 0, "R");
	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/คน'),0,0,"L");

	// $pdf->Ln(6);
	// $pdf->SetX(125);
	// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','     1.2) ทุพพลภาพชั่วคราว'),0,0,"L");

	// $pdf->SetX(125);
	// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','     ก) ผู้ขับขี่ 1 คน'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(110);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(60, 69.5, iconv('UTF-8', 'TIS-620', $protect_array['pa5']), 0, 0, "R");

	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	// $pdf->Cell(23,54,iconv('UTF-8','TIS-620','บาท/สัปดาห์'),0,0,"L");

	// $pdf->Ln(6);
	$pdf->SetX(151);
	$pdf->Cell(75, 78, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "L");
	$pdf->SetX(170.5);
	$pdf->Cell(75, 78, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "L");

	$pdf->SetX(107);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(50, 91, iconv('UTF-8', 'TIS-620', $protect_array['pa6']), 0, 0, "R");

	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	// $pdf->Cell(23,54,iconv('UTF-8','TIS-620','บาท/คน/สัปดาห์'),0,0,"L");

	if ($row['car_id'] == "110") {

		$strOption = "200,000";
		$strOption1 = "200,000";
	} else if ($row['car_id'] == "320") {
		$strOption = "50,000";
		$strOption1 = "200,000";
	} else {
		$strOption = "50,000";
		$strOption1 = "200,000";
	}


	// $pdf->Ln(6);
	// $pdf->SetX(125);
	// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','2) ค่ารักษาพยาบาล'),0,0,"L");
	$pdf->SetX(110);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(60, 109, iconv('UTF-8', 'TIS-620', $protect_array['pa3']), 0, 0, "R");
	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/คน'),0,0,"L");

	// $pdf->Ln(6);
	// $pdf->SetX(125);
	// $pdf->Cell(75,54,iconv('UTF-8','TIS-620','3) การประกันตัวผู้ขับขี่'),0,0,"L");
	$pdf->SetX(110);
	$pdf->SetFont('angsa', 'B', 12);
	$pdf->Cell(60, 125.5, iconv('UTF-8', 'TIS-620', $protect_array['pa4']), 0, 0, "R");
	// $pdf->SetFont('angsa','',12);
	// $pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	// $pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	// $pdf->Ln(30);
	// $pdf->Cell(115,9,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->SetX(100);
	$pdf->SetFont('angsa', '', 9);
	// $pdf->Cell(95,5,iconv('UTF-8','TIS-620','เบี้ยประกันตามความคุ้มครองหลัก'),0,0,"L");
	$pdf->Cell(2, 135.5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "L");
	// $pdf->Cell(18,5,iconv('UTF-8','TIS-620','บาท'),0,0,"L");

	// $pdf->Ln(4);
	// $pdf->SetX(10);
	// $pdf->Cell(95,5,iconv('UTF-8','TIS-620','(เบี้ยประกันภัยได้หักส่วนลดกรณีระบุชื่อผู้ขับขี่'),0,0,"L");
	$pdf->SetY(203);
	$pdf->SetX(100);
	$pdf->Cell(2, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "L");
	// $pdf->Cell(18,5,iconv('UTF-8','TIS-620','บาทแล้ว)'),0,0,"L");

	// $pdf->Ln(-4);
	// $pdf->SetX(125);
	// $pdf->Cell(75,9,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->SetY(199.4);
	$pdf->SetX(134.5);
	// $pdf->Cell(60,5,iconv('UTF-8','TIS-620','เบี้ยประกันภัยตามเอกสารแนบท้าย'),0,0,"L");
	$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");
	// $pdf->Cell(13,5,iconv('UTF-8','TIS-620','บาท'),0,0,"L");
	// $pdf->Ln(9);
	// $pdf->Cell(10,9,iconv('UTF-8','TIS-620','ส่วนลด'),1,0,"C");
	// $pdf->Cell(50,9,iconv('UTF-8','TIS-620',''),1,0,"L");
	// $pdf->Ln(-2);
	// $pdf->SetX(20);
	// $pdf->Cell(50,9,iconv('UTF-8','TIS-620','ความเสียหายส่วนแรก'),0,0,"L");
	$setY = 210.5;
	$pdf->SetY($setY);
	$pdf->SetX(18);
	$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");
	// $pdf->Ln(4);
	// $pdf->SetX(20);
	// $pdf->Cell(50,9,iconv('UTF-8','TIS-620','อื่นๆ'),0,0,"L");
	$pdf->SetY(214.5);
	$pdf->SetX(18);
	$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");
	// $pdf->Ln(-2);
	// $pdf->SetX(70);
	// $pdf->Cell(65,9,iconv('UTF-8','TIS-620',''),1,0,"L");
	// $pdf->Ln(-2);
	// $pdf->SetX(70);
	// $pdf->Cell(65,9,iconv('UTF-8','TIS-620','ส่วนลดกลุ่ม'),0,0,"L");
	$pdf->SetY($setY);
	$pdf->SetX(80);
	$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");
	// $pdf->Ln(4);
	// $pdf->SetX(70);
	// $pdf->Cell(65,9,iconv('UTF-8','TIS-620','รวมส่วนลด'),0,0,"L");
	$pdf->SetY(214.5);
	$pdf->SetX(80);
	$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");
	// $pdf->Ln(-2);
	// $pdf->SetX(135);
	// $pdf->Cell(65,9,iconv('UTF-8','TIS-620',''),1,0,"L");
	// $pdf->Ln(-2);
	// $pdf->SetX(135);
	// $pdf->Cell(65,9,iconv('UTF-8','TIS-620','ประวัติดี'),0,0,"L");
	$pdf->SetY($setY);
	$pdf->SetX(134.5);
	$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "R");

	// $pdf->Ln(11);
	// $pdf->Cell(10,5,iconv('UTF-8','TIS-620','ส่วนเพิ่ม'),1,0,"C");
	// $pdf->Cell(180,5,iconv('UTF-8','TIS-620',''),1,0,"L");
	// $pdf->Ln(-3);
	// $pdf->SetX(20);
	// $pdf->Cell(180,12,iconv('UTF-8','TIS-620','ประวัติเพิ่ม'),0,0,"L");
	$pdf->SetY(220);
	$pdf->SetX(76.5);
	$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', '-'), 0, 0, "C");

	$pdf->SetTextColor(255, 0, 0);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->SetY(220);
	$pdf->SetX(152);
	//$pdf->Cell(50,5,iconv('UTF-8','TIS-620','ชำระอากรแล้ว'),0,0,"R");
	// $pdf->SetFont('angsa','',12);
	$pdf->SetTextColor(0, 0, 0);

	// $pdf->Ln(9);
	// $pdf->SetFont('angsa','',10);
	// $pdf->Cell(60,5,iconv('UTF-8','TIS-620','เบี้ยประกันสุทธิ'),1,0,"C");
	// $pdf->SetX(70);
	// $pdf->Cell(45,5,iconv('UTF-8','TIS-620','อากร'),1,0,"C");
	// $pdf->SetX(115);
	// $pdf->Cell(35,5,iconv('UTF-8','TIS-620','ภาษีมูลค่าเพิ่ม'),1,0,"C");
	// $pdf->SetX(150);
	// $pdf->Cell(50,5,iconv('UTF-8','TIS-620','รวม'),1,0,"C");
	// $pdf->Ln(5);
	$pdf->SetFont('angsa', '', 14);

	$query_UCostRenew = "SELECT pre,stamp,tax,net FROM UCostRenew WHERE type = 'S_Rate' AND cost = '" . $cost . "' AND service = '2'";
	// $objQuery_UCostRenew = mysql_query($query_UCostRenew,$cndb1) or die ("Error query_UCostRenew [".$query_UCostRenew."]");
	// $row_UCostRenew = mysql_fetch_array($objQuery_UCostRenew);
	$row_UCostRenew = PDO_CONNECTION::fourinsure_mitsu()->query($query_UCostRenew)->fetch(PDO::FETCH_ASSOC);


	if ($row['insure_year'] == '2') {
		$pre = number_format($row_UCostRenew['pre'], 2);
		$stamp = number_format($row_UCostRenew['stamp'], 2);
		$tax = number_format($row_UCostRenew['tax'], 2);
		$net = number_format($row_UCostRenew['net'], 2);
	} else if ($row['insure_year'] == '3') {
		$pre = number_format($row_UCostRenew['pre'], 2);
		$stamp = number_format($row_UCostRenew['stamp'], 2);
		$tax = number_format($row_UCostRenew['tax'], 2);
		$net = number_format($row_UCostRenew['net'], 2);
	} else {
		$pre = number_format($row['pre'], 2);
		$stamp = number_format($row['stamp'], 2);
		$tax = number_format($row['tax'], 2);
		$net = number_format($row['net'], 2);
	}
	$pdf->SetY(232);
	$pdf->SetX(10);
	$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', $pre), 0, 0, "C");
	$pdf->SetX(46);
	$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', $stamp), 0, 0, "C");
	$pdf->SetX(90);
	$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', $tax), 0, 0, "C");
	$pdf->SetX(150);
	$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', $net), 0, 0, "C");

	// $pdf->SetFont('angsa','',9);
	// $pdf->Ln(6);
	// $pdf->Cell(0,5,iconv('UTF-8','TIS-620','การใช้รถยนต์ '),0,0,"L");


	$query_Passcar = "SELECT `name` FROM tb_pass_car_type WHERE id='$arr_car_id[1]$arr_car_id[2]' AND id_pass_car='$arr_car_id[0]'";

	// $objQuery_Passcar = mysql_query($query_Passcar,$cndb1) or die ("Error Query [".$query_Passcar."]");
	// $row_Passcar = mysql_fetch_array($objQuery_Passcar);
	$row_Passcar = PDO_CONNECTION::fourinsure_mitsu()->query($query_Passcar)->fetch(PDO::FETCH_ASSOC);

	$IDNAME = $row_Passcar['name'];
	$rowcheck = 238.2;
	$pdf->SetY($rowcheck);
	$pdf->SetX(40);
	$pdf->SetFont('angsa', 'B', 9);
	$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $IDNAME), 0, 0, "L");
	// $pdf->Ln(5);

	//----------------------------------เงื่อนไขอุปกรณ์ตกแต่ง-------------------------------////

	// $ShowReqOld = 'XXX';
	if ($ShowReq == '' && $ShowReqOld == '') {
		// $pdf->Cell(0,35,iconv('UTF-8','TIS-620',''),0,0,"L");
		// $pdf->SetY(213);
		// $pdf->SetX(10);
		// $pdf->SetFont('angsa','',9);
		// $pdf->Cell(0,15,iconv('UTF-8','TIS-620','อุปกรณ์ตกแต่งเพิ่มเติม : '),0,0,"L");
		$rowcheck = 238.8;
		$pdf->SetY($rowcheck);
		$pdf->SetX(50);
		$pdf->SetFont('angsa', 'B', 9);
		for ($i = 0; $i < count($eq); $i++) {
			$pdf->Cell(0, 15, iconv('UTF-8', 'TIS-620', $eq[$i]), 0, 0, "L");
			$pdf->SetY($rowcheck);
			$rowcheck = $rowcheck + 4;
		}

		if ($row['car_cat_acc_total'] != '0.00' && $row['car_cat_acc'] != '') {
			if ($row['car_cat_acc'] == '220') {
				if ($row['EditProduct'] == 'Y') {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				} else {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				}
			} else if ($row['car_cat_acc'] == '230') {
				if ($row['EditProduct'] == 'Y') {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				} else {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				}
			} else if ($row['car_cat_acc'] == '120') {
				if ($row['EditProduct'] == 'Y') {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (120  รถยน์นั่งใช้เพื่อการพาณิชย์ ไม่ใช่รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				} else {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (120  รถยน์นั่งใช้เพื่อการพาณิชย์ ไม่ใช่รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				}
			} else {
				if ($row['EditProduct'] == 'Y') {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (' . $pass_car_array['pass_car_id'] . ' ' . $pass_car_array['name'] . ') เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				} else {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (' . $pass_car_array['pass_car_id'] . ' ' . $pass_car_array['name'] . ') เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				}
			}
			$pdf->SetY(260);
			$pdf->SetX(198);
			$pdf->SetFont('angsa', 'B', 10);
			$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', $type_acc), 0, 0, "R");
		} else {
			/// ราคาสลักหลัง ///////////////////////////////////////////////////////////////
			$pdf->SetY(246);
			$pdf->SetFont('angsa', 'B', 10);

			if ($row['EditProduct'] != 'Y') {
				$TotalProduct = number_format($row['price_total']);
				$TotalPrice = number_format($row['add_price'], 2);
				if ($pre_add == 0.00) {
					//$pdf->Cell(0,15,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.number_format($pre_add,2,'.',',')."  บาท"),0,0,"R");
				} else {
					$pdf->SetX(198);
					$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', 'เพิ่มทุนอุปกรณ์รวม ' . $TotalProduct . ' บาท ' . 'เพิ่มเบี้ยรวม  ' . number_format($pre_add, 2, '.', ',') . "  บาท"), 0, 0, "R");
				}
			}
			if ($row['EditProduct'] == 'Y') {
				$TotalProduct = number_format($row['TotalProduct']);
				$TotalPrice = number_format($row['CostProduct'], 2);
				if ($pre_add > 0.00) {
					$pdf->SetX(198);
					$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', 'เพิ่มทุนอุปกรณ์รวม ' . $TotalProduct . ' บาท ' . 'เพิ่มเบี้ยรวม  ' . number_format($pre_add, 2, '.', ',') . "  บาท"), 0, 0, "R");
				}
			}
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}

		/////////////////ADD ON ///////////////
		// $pdf->Ln(10);
		// $pdf->Cell(0,35,iconv('UTF-8','TIS-620',''),1,0,"L");
		// $pdf->SetY(229);
		// $pdf->SetX(10);
		// $pdf->SetFont('angsa','',9);
		// $pdf->Cell(0,15,iconv('UTF-8','TIS-620','Add On : '),0,0,"L");

		$pdf->SetY(259);
		$pdf->SetFont('angsa', 'B', 9);
		if ($row['code_addon'] != '') {
			$pdf->SetX(20);
			$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $addonView), 0, 0, "L");
			$pdf->SetFont('angsa', 'B', 10);
			$pdf->SetX(198);
			$pdf->Cell(5, 16, iconv('UTF-8', 'TIS-620', 'เพิ่มเบี้ยรวม ' . number_format($costAD, 2) . "  บาท"), 0, 0, "R");
		} else {
			$pdf->SetX(20);
			$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'ไม่มี'), 0, 0, "L");
			//$pdf->Cell(0,15,iconv('UTF-8','TIS-620','เพิ่มเบี้ยรวม '.number_format(0,2)."  บาท"),0,0,"R");
		}
		/////////////////END ADD ON ///////////////


		// $pdf->Ln(10);
		// $pdf->SetFont('angsa','',9);

		if ($row['career'] == 1) {
			$note = 'ออกใบเสร็จในนามบริษัท';
		} else {
			$note = 'ออกใบเสร็จในนามลูกค้า';
		}
		if ($row['SendAdd'] != '') {
			if ($row['status_SendAdd'] == 'Y') {
				//$address_pdf='';
				$textaddarray = $ExpAddress->ExpMapperAddress($row['SendAdd']);
				$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : ' . $textaddarray . ')';
			} else {
				$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : ' . $row['SendAdd'] . ')';
			}
		}
		$pdf->SetFont('angsa', 'B', 9);
		$pdf->SetY(269.5);
		$pdf->SetX(27);
		$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $note . $SendAdd), 0, 0, "L");
		// $pdf->Ln(13);
		// $pdf->SetFont('angsa','',12);
		// $pdf->Image('../images/2.jpg',15,259,4);
		// $pdf->Cell(0,5,iconv('UTF-8','TIS-620',''),0,0,"L");
		// $pdf->SetX(20);
		// $pdf->Cell(50,5,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
		// $pdf->SetX(50);
		// $pdf->Image('../images/1.jpg',55,259,4);
		$pdf->SetX(56.5);
		$pdf->Cell(60, 14.7, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, "L");

		$pdf->SetY(274.5);
		$pdf->SetFont('angsa', '', 11);
		$pdf->SetX(103);
		$pdf->Cell(60, 5, iconv('UTF-8', 'TIS-620', 'ประกันภัยโดยตรง'), 0, 0, "L");
		$pdf->SetFont('angsa', '', 11);
		$pdf->SetX(143);
		$pdf->Cell(60, 5, iconv('UTF-8', 'TIS-620', ''), 0, 0, "R");//ว.00018/2551
		// $pdf->Ln(6);
		// $pdf->Cell(50,5,iconv('UTF-8','TIS-620','วันทำสัญญาประกันภัย'),0,0,"L");

		$pdf->SetY(282.3);
		$pdf->SetX(63);
		$pdf->SetFont('angsa', '', 12);
		$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', date('d/m', strtotime($row['start_date'])) . '/' . $startYear), 0, 0, "L");
		// $pdf->SetX(100);
		// $pdf->SetFont('angsa','',12);
		// $pdf->Cell(50,5,iconv('UTF-8','TIS-620','วันทำกรมธรรม์'),0,0,"L");
		// $pdf->SetX(150);
		// $pdf->SetFont('angsa','B',12);
		// $pdf->Cell(50,0,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['send_date'])).'/'.$sendYear),0,0,"C");
	} else if ($ShowReq != '' || $ShowReqOld != '') {
		// $pdf->SetTextColor(255,0,0);

		// $pdf->Cell(0,15,iconv('UTF-8','TIS-620',''),0,0,"L");
		// $pdf->SetY(213);
		// $pdf->SetX(10);
		// $pdf->SetFont('angsa','',9);
		// $pdf->Cell(0,15,iconv('UTF-8','TIS-620','อุปกรณ์ตกแต่งเพิ่มเติม : '),0,0,"L");
		$pdf->SetX(50);
		$pdf->SetFont('angsa', 'B', 9);
		$rowcheck = 238.8;
		for ($i = 0; $i < count($eq); $i++) {
			$pdf->Cell(0, 15, iconv('UTF-8', 'TIS-620', $eq[$i]), 0, 0, "L");
			$pdf->SetY($rowcheck);
			$rowcheck = $rowcheck + 4;
		}


		if ($row['car_cat_acc_total'] != '0.00' && $row['car_cat_acc'] != '') {
			if ($row['car_cat_acc'] == '220') {
				if ($row['EditProduct'] == 'Y') {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				} else {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				}
			} else if ($row['car_cat_acc'] == '230') {
				if ($row['EditProduct'] == 'Y') {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				} else {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				}
			} else if ($row['car_cat_acc'] == '120') {
				if ($row['EditProduct'] == 'Y') {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (120  รถยน์นั่งใช้เพื่อการพาณิชย์ ไม่ใช่รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				} else {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (120  รถยน์นั่งใช้เพื่อการพาณิชย์ ไม่ใช่รับจ้างสาธารณะ) เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				}
			} else {
				if ($row['EditProduct'] == 'Y') {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (' . $pass_car_array['pass_car_id'] . ' ' . $pass_car_array['name'] . ') เพิ่มทุน' . number_format($row['TotalProduct']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				} else {
					$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (' . $pass_car_array['pass_car_id'] . ' ' . $pass_car_array['name'] . ') เพิ่มทุน' . number_format($row['price_total']) . ' บาท เพิ่มเบี้ย ' . number_format($row['car_cat_acc_total'], 2) . ' บาท ' . $car_cat_acc_text;
				}
			}
			$pdf->SetY(260);
			$pdf->SetX(198);
			$pdf->SetFont('angsa', 'B', 10);
			$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', $type_acc . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") "), 0, 0, "R");
		} else {
			$pdf->SetY(246);
			$pdf->SetFont('angsa', 'B', 10);
			if ($row['EditProduct'] != 'Y') {
				$TotalProduct = number_format($row['price_total']);
				$TotalPrice = number_format($row['add_price'], 2);
			}
			if ($row['EditProduct'] == 'Y') {
				$TotalProduct = number_format($row['TotalProduct']);
				$TotalPrice = number_format($row['CostProduct'], 2);
			}
			if ($TotalPrice == 0.00) {
				//$pdf->Cell(0,15,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.$TotalPrice."  บาท"." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") "),0,0,"R");
			} else {
				$pdf->SetX(198);
				$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', 'เพิ่มทุนอุปกรณ์รวม ' . $TotalProduct . ' บาท ' . 'เพิ่มเบี้ยรวม ' . $TotalPrice . "  บาท" . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") "), 0, 0, "R");
			}
		}
		// $pdf->Ln(10);
		// $pdf->Cell(0,35,iconv('UTF-8','TIS-620',''),1,0,"L");
		// $pdf->SetY(230);
		// $pdf->SetX(10);
		// $pdf->SetFont('angsa','',9);
		// $pdf->Cell(0,15,iconv('UTF-8','TIS-620','Add On : '),0,0,"L");
		// $pdf->SetX(31);
		// $pdf->SetFont('angsa','B',9);

		$pdf->SetY(259);
		$pdf->SetFont('angsa', 'B', 9);
		if ($row['code_addon'] != '') {
			$pdf->SetX(20);
			$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $addonView), 0, 0, "L");
			$pdf->SetFont('angsa', 'B', 10);
			$pdf->SetX(198);
			$pdf->Cell(5, 16, iconv('UTF-8', 'TIS-620', 'เพิ่มเบี้ยรวม ' . number_format($costAD, 2) . "  บาท"), 0, 0, "R");
		} else {
			$pdf->SetY(251.3);
			$pdf->SetX(20);
			$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', 'ไม่มี'), 0, 0, "L");
			//$pdf->Cell(0,15,iconv('UTF-8','TIS-620','เพิ่มเบี้ยรวม '.number_format(0,2)."  บาท"),0,0,"R");
		}


		// $pdf->Ln(10);
		// $pdf->SetFont('angsa','',9);

		// $pdf->Cell(0,19,iconv('UTF-8','TIS-620',''),1,0,"L");
		$pdf->SetY(257);
		$pdf->SetX(8);
		$pdf->Cell(0, 15, iconv('UTF-8', 'TIS-620', 'สลักหลัง :'), 0, 0, "L");
		$pdf->SetX(20);
		$pdf->SetFont('angsa', 'B', 9);
		$P_req = 0;
		$PCut_req = 0;
		$line[$P_req] = '';
		if ($row['send_req'] != '') {
			$line[$P_req] .= $row['send_req'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
			$PCut_req++;
			if ($PCut_req >= 3) {
				$P_req++;
			}
		}
		if ($row['send_req2'] != '') {
			$line[$P_req] .= $row['send_req2'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
			$PCut_req++;
			if ($PCut_req >= 3) {
				$P_req++;
			}
		}
		if ($row['send_cancel'] != '') {
			$line[$P_req] .= $row['send_cancel'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
			$PCut_req++;
			if ($PCut_req >= 3) {
				$P_req++;
			}
		}

		if ($row['EditTime'] == 'Y') {
			$line[$P_req] .= "วันที่คุ้มครอง : " . date('d/m/Y', strtotime($row['EditTime_StartDate'])) . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
			$PCut_req++;
			if ($PCut_req >= 3) {
				$P_req++;
			}
		}
		if ($row['EditHr'] == 'Y') {
			$line[$P_req] .= " ผู้รับผลประโยชน์ : " . $row['EditHr_Detail'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . "]" . ' |';
			$PCut_req++;
			if ($PCut_req >= 3) {
				$P_req++;
			}
		}
		if ($row['EditAct'] == 'Y') {
			$line[$P_req] .= "เลขที่ พรบ. : " . $row['EditAct_id'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
			$PCut_req++;
			if ($PCut_req >= 3) {
				$P_req++;
			}
		}
		if ($row['EditCar'] == 'Y') {
			$line[$P_req] .= " เลขตัวถัง : " . $row['Edit_CarBody'] . " / " . "เลขเครื่อง : " . $row['Edit_Nmotor'] . " / " . "สีรถ : " . $row['Edit_CarColor'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
			$PCut_req++;
			if ($PCut_req >= 3) {
				$P_req++;
			}
		}
		if ($row['EditCancel'] == 'Y') {
			$line[$P_req] .= " ยกเลิก : " . $row['Cancel_Detail'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' |';
			$PCut_req++;
			if ($PCut_req >= 3) {
				$P_req++;
			}
		}
		if ($row['EditCustomer'] == 'Y') {
			$line[$P_req] .= " ชื่อผู้เอาประกันภัย : " . $row['Cus_title'] . " " . $row['Cus_name'] . " " . $row['Cus_last'];
			$line[$P_req] .= " ที่อยู่ : " . $row['Cus_add'];
			if ($row['Cus_group'] != "-" && $row['Cus_group'] != "") {
				$line[$P_req] .=  " หมู่" . $row['Cus_group'];
			}
			if ($row['Cus_town'] != "-" && $row['Cus_town'] != "") {
				$line[$P_req] .= " " . $row['Cus_town'];
			}
			if ($row['Cus_lane'] != "-" && $row['Cus_lane'] != "") {
				$line[$P_req] .= " ซอย" . $row['Cus_lane'];
			}
			if ($row['Cus_road'] != "-" && $row['Cus_road'] != "") {
				$line[$P_req] .= " ถนน" . $row['Cus_road'];
			}
			if ($row['Cus_province'] != "102") {
				$line[$P_req] .= "ต." . $row1['tumbon'] . " อ." . $row1['amphur'] . " จ." . $row1['province'] . " " . $row['Cus_postal'];
			} else {
				$line[$P_req] .= "แขวง" . $row1['tumbon'] . "  " . $row1['amphur'] . " " . $row1['province'] . " " . $row['Cus_postal'];
			}
			$line[$P_req] .= " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") " . ' | ';
			$PCut_req++;
			if ($PCut_req >= 3) {
				$P_req++;
			}
		}
		if ($row['EditCost'] == 'Y') {
			$line[$P_req] .= "ค่าเบี้ย : " . $row['EditcostCost'] . " (วันที่สลักหลัง : " . date('d/m/Y', strtotime($row['Req_Date'])) . ") ";
			$PCut_req++;
			if ($PCut_req >= 3) {
				$P_req++;
			}
		}

		for ($r = 0; $r <= $P_req; $r++) {
			if ($r == 0) {
				$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', $line[$r]), 0, 0, "L");
			} else {
				$y = 235;
				$li = 4;
				$step = $y + ($li * $r);
				$pdf->SetY($step);
				$pdf->Cell(5, 15, iconv('UTF-8', 'TIS-620', $line[$r]), 0, 0, "L");
			}
		}
		if ($row['career'] == 1) {
			$note = 'ออกใบเสร็จในนามบริษัท';
		} else {
			$note = 'ออกใบเสร็จในนามลูกค้า';
		}

		if ($row['SendAdd'] != '') {
			if ($row['status_SendAdd'] == 'Y') {
				//$address_pdf='';
				$textaddarray = $ExpAddress->ExpMapperAddress($row['SendAdd']);
				$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : ' . $textaddarray . ')';
			} else {
				$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : ' . $row['SendAdd'] . ')';
			}
		}

		$pdf->SetFont('angsa', 'B', 9);
		$pdf->SetY(269.5);
		$pdf->SetX(27);
		$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $note . $SendAdd), 0, 0, "L");

		$pdf->SetY(274.2);
		$pdf->SetX(56.5);
		$pdf->Cell(60, 5, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, "L");

		$pdf->SetY(274.5);
		$pdf->SetFont('angsa', '', 11);
		$pdf->SetX(103);
		$pdf->Cell(60, 5, iconv('UTF-8', 'TIS-620', 'ประกันภัยตรง'), 0, 0, "L");
		$pdf->SetFont('angsa', '', 11);
		$pdf->SetX(143);
		$pdf->Cell(60, 5, iconv('UTF-8', 'TIS-620', ''), 0, 0, "R");//'ว.00018/2551
		// $pdf->Ln(6);
		// $pdf->Cell(50,5,iconv('UTF-8','TIS-620','วันทำสัญญาประกันภัย'),0,0,"L");

		$pdf->SetY(282.3);
		$pdf->SetX(63);
		$pdf->SetFont('angsa', '', 12);
		$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', date('d/m', strtotime($row['start_date'])) . '/' . $startYear), 0, 0, "L");
	}
}
$pdf->Output();



/************************************************************************************************************************************* */
//ใบยืนยันรับฟรีประกันภัย
$pdf->AddPage();
$pdf->Image("../downloads/confirmation_car_new.jpg", 2, 0, 205, 0);
if ($row['car_id'] == '110') {
	//$pdf->Image("../downloads/confirmation_car110.jpg",0,0,210,0);
	$car_type_name = 'รถเก๋ง';
} else if ($row['car_id'] == '320') {
	//$pdf->Image("../downloads/confirmation_car320.jpg",0,0,210,0);
	$car_type_name = 'รถกระบะ';
}
$pdf->SetFont('angsa', 'B', 13);

if ($row['EditCustomer'] == 'Y') {
	$insure_name = $row['Cus_title'] . " " . $row['Cus_name'] . " " . $row['Cus_last'];
} else {
	$insure_name = $row['title'] . " " . $row['name'] . " " . $row['last'];
}
$y1 = 63.5;
$x1 = 52;
$x2 = 98;
$x1_plus = 6.7;
$pdf->SetY($y1);
$pdf->SetX($x1);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $insure_name), 0, 0, "L");
$address_pdf = "";
if ($row['add'] != "-" && $row['add'] != "") {
	$address_pdf .= $row['add'];
}
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
	$address_pdf .= ' ต.' . $row['tumbon_name'] . ' อ.' . $row['amphur_name'] . ' จ.' . $row['province_name'] . ' ' . $row['postal'];
} else {
	$address_pdf .= ' แขวง' . $row['tumbon_name'] . '  ' . $row['amphur_name'] . ' ' . $row['province_name'] . ' ' . $row['postal'];
}
$pdf->SetY($y1 += $x1_plus);
$pdf->SetX($x1);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $address_pdf), 0, 0, "L");
$pdf->SetY($y1 += $x1_plus);
$pdf->SetX($x1);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['car_brand']), 0, 0, "L");
$pdf->SetX($x2);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['mo_car_name']), 0, 0, "L");
$pdf->SetY($y1 += $x1_plus);
$pdf->SetX($x1);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['n_motor']), 0, 0, "L");
$pdf->SetX($x2 + 7.5);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['car_body']), 0, 0, "L");
$pdf->SetY($y1 += $x1_plus);
$pdf->SetX($x1);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'วิริยะประกันภัย'), 0, 0, "L");
$pdf->SetX($x2 + 7.5);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['id_data']), 0, 0, "L");
$pdf->SetY($y1 += $x1_plus);
$pdf->SetX($x1);
$change_start_date = explode('-', $row['start_date']);
$change_end_date = explode('-', $row['end_date']);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $change_start_date[2] . "/" . $change_start_date[1] . "/" . ($change_start_date[0] + 543)), 0, 0, "L");
$pdf->SetX($x1 + 15);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'สิ้นสุด'), 0, 0, "L");
$pdf->SetX($x1 + 24);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $change_end_date[2] . "/" . $change_end_date[1] . "/" . ($change_end_date[0] + 543)), 0, 0, "L");
$pdf->SetY($y1 += $x1_plus);
$pdf->SetX($x1);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'ซ่อมห้าง'), 0, 0, "L");

//ต่อด้วยความคุ้มครอง
$set_y = 118.5;
$y_plus += 7.15;
$pdf->SetY($set_y - 1);
$pdf->SetX(133);
$pdf->Cell(1, 1, iconv('UTF-8', 'TIS-620', $car_type_name), 0, 0, "C");
$pdf->SetY($set_y += $y_plus);
$pdf->SetX(139.7);
$pdf->Cell(1, 1, iconv('UTF-8', 'TIS-620', $cost_new . "  บาท"), 0, 0, "R");
$pdf->SetY($set_y += $y_plus);
$pdf->SetX(133);
$pdf->Cell(1, 1, iconv('UTF-8', 'TIS-620', $protect_array['damage_out1']), 0, 0, "R");

$pdf->SetY($set_y += $y_plus);
$pdf->SetX(133);
$pdf->Cell(1, 1, iconv('UTF-8', 'TIS-620', $protect_array['damage_notover']), 0, 0, "R");

$pdf->SetY($set_y += $y_plus);
$pdf->SetX(133);
$pdf->Cell(1, 1, iconv('UTF-8', 'TIS-620', $protect_array['damage_cost']), 0, 0, "R");
$pdf->SetY($set_y += $y_plus);
$pdf->SetX(133);
$pdf->Cell(1, 1, iconv('UTF-8', 'TIS-620', '1+' . $protect_array['people']), 0, 0, "R");
$pdf->SetY($set_y += $y_plus);
$pdf->SetX(133);
$pdf->Cell(1, 1, iconv('UTF-8', 'TIS-620', $protect_array['pa2']), 0, 0, "R");
$pdf->SetY($set_y += $y_plus);
$pdf->SetX(133);
$pdf->Cell(1, 1, iconv('UTF-8', 'TIS-620', $protect_array['pa3']), 0, 0, "R");
$pdf->SetY($set_y += $y_plus);
$pdf->SetX(133);
$pdf->Cell(1, 1, iconv('UTF-8', 'TIS-620', $protect_array['pa4']), 0, 0, "R");
$pdf->SetY($set_y += $y_plus + 0.5);
$pdf->SetX(100);
$pdf->SetTextColor(255, 0, 0);
if ($protect_array['dd'] == '-' || $protect_array['dd'] == '') {
	$dd = 'ไม่ระบุ';
} else {
	$dd = $protect_array['dd'];
}
$pdf->Cell(1, 1, iconv('UTF-8', 'TIS-620', $dd), 0, 0, "L");
$pdf->SetTextColor(0, 0, 0);
$pdf->SetY(256.5);
$pdf->SetX(35);
$pdf->Cell(1, 1, iconv('UTF-8', 'TIS-620', $row['title_sub'] . " " . $row['sub']), 0, 0, "L");

//End ใบยืนยันรับฟรีประกันภัย


$pdf->Output();
//echo $query;
mysql_close();
