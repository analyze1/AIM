<?php
include "../pages/check-ses.php"; 
include "../../inc/connectdbs.pdo.php";
//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
require("../email/PHPMailer/PHPMailerAutoload.php");  // เรียกไฟล์ class.phpmailer.php
require('../fpdf.php');
define('FPDF_FONTPATH','font/');
$IDDATA = $_POST['txtID'];
$txtCC = $_POST['txtCC'];
$sendm=0;
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
$query .= "data.unit_edit, "; // วิริยะปากเกร็ด
$query .= "data.n_insure, "; // วิริยะปากเกร็ด
$query .= "insuree.title, "; // คำนำหน้า ชื่อผู้เอาประกัน
$query .= "insuree.name,  "; // ชื่อผู้เอาประกัน
$query .= "insuree.name As namecus, "; // ชื่อผู้เอาประกัน namecus
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

$query .= "detail.code_addon As detail_code_addon, "; // add on สุขใจ/โจรกรรม
$query .= "detail.code_addon_id As detail_code_addon_id, "; // add on สุขใจ/โจรกรรม

$query .= "data.updated, "; // สลักหลัง
$query .= "data.unit_edit, "; 
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
$query .= "req.Product, ";
$query .= "req.Product as ReqProduct, ";
$query .= "req.TotalProduct, ";
$query .= "req.CostProduct, ";
$query .= "req.code_addon, "; // add on สุขใจ/โจรกรรม
$query .= "req.code_addon_id, "; // add on สุขใจ/โจรกรรม
$query .= "req.EditAddon, ";
$query .= "tb_customer.title_sub,";
$query .= "tb_customer.sub,";
$query .= "tb_customer.Email,";
$query .= "tb_customer.Email2,";
$query .= "tb_customer.Email3,";
$query .= "tb_customer.Email4,";
$query .= "tb_customer.Email5, ";
$query .= "tb_customer.Email6, ";
$query .= "tb_customer.Email8, ";
$query .= "tb_customer.Contact2, ";
$query .= "tb_customer.saka,";
$query .= "tb_customer.address ";
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
$query .= "INNER JOIN tb_customer ON (tb_customer.user = data.login) ";
$query .= "INNER JOIN req ON (req.id_data = data.id_data) ";

$query .= "WHERE data.id_data='$IDDATA'";

$objQuery = mysql_query($query) or die ("Error Query [".$query."]");

$row = mysql_fetch_array($objQuery);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$car_id = $row['car_id'];
$arr_car_id = str_split($car_id);
$id_data_rec = $row['id_data'];
$nameCar=$row['mo_car_name'];
if(!empty($row['mo_sub'])){
  $sqlQueMS ="SELECT * FROM tb_mo_car_sub where id = '".$row['mo_sub']."'";
  $resMS = mysql_query($sqlQueMS);
  $rowMS = mysql_fetch_array($resMS);
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

$query1 .= "WHERE req.id_data='".$row['id_data']."'";

$objQuery1 = mysql_query($query1) or die ("Error Query [".$query1."]");

$row1 = mysql_fetch_array($objQuery1);

$sqlMORE = "SELECT * FROM tb_acc";
$objQueryMORE = mysql_query($sqlMORE) or die ("Error Query [".$sqlMORE."]");
$costOb = array();
while($rowCost = mysql_fetch_array($objQueryMORE)){
	$costOb['name'][$rowCost['id']] = $rowCost['name'];
	$costOb['price'][$rowCost['id']] = $rowCost['price'];
	$costOb['price2'][$rowCost['id']] = $rowCost['price2'];
}
$sqlMOREname = "SELECT * FROM tb_acc_new";
$objQueryMOREname = mysql_query($sqlMOREname) or die ("Error Query [".$sqlMOREname."]");
$costObname = array();
while($rowCostname = mysql_fetch_array($objQueryMOREname)){
	$costObname['name']['0'.$rowCostname['idcar']][$rowCostname['id']] = $rowCostname['name'];
}

$strfix = 200;

if($row['EditProduct'] !='Y')
{
	if($row['equit']=='Y' and $row['car_detail']=='0')
	{
		$p=0;
		$i=0;
		$product = "product";
		while ($i<=14)
		{
			if($i==0)
			{
				if($row[$product]!='0')
				{
					if($p<6){$equit0 .= $row[$product]." บาท,  ";$p++;}else if($p<12){$equit1 .= $row[$product]." บาท,  ";$p++;}else if($p<18){$equit2 .= $row[$product]." บาท,  ";$p++;}
				}
			}
			else
			{
				if($row[$product.$i]!='0')
				{
					if($p<6){$equit0 .= $row[$product.$i]." บาท,  ";$p++;}else if($p<12){$equit1 .= $row[$product.$i]." บาท,  ";$p++;}else if($p<18){$equit2 .= $row[$product.$i]." บาท,  ";$p++;}
				}
			}
			$i++;
		}
	}
	else if($row['equit']=='Y' and $row['car_detail']!='0')
	{
		$p=0;
		$i=0;
		$string='';
		$pre_add=0;
		$exitNum = explode("|",$row['car_detail']);
		for($i=0;$i<count($exitNum);$i++)
		{
			$exitSplit = explode(",",$exitNum[$i]);
                        if(number_format($costOb['name'][$exitSplit[1]],0)=='1'){
                            $priceAcc = 0;
                        }else{
                            $priceAcc = number_format($costOb['name'][$exitSplit[1]],0);
                        }
			if($priceAcc==0.00)	
			{			
			$string .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' ';$p++;
			}
			else
			{
			$string .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' '.$priceAcc.' บาท ';$p++;
			}
			//$pre_add+=$costOb['price'][$exitSplit[1]];
		}
		for($s=0;$s<strlen($string)/$strfix;$s++)
		{
			$eq[$s] = substr($string,$s*$strfix,$s*$strfix+$strfix);
		}
		$pre_add=$row['add_price'];
	}
	else
	{
		$pre_add='0.00';
		$eq[0] .= "ไม่มี";
	}
}			
if($row['EditProduct'] =='Y')
{
	$p=0;
	$i=0;
	$pre_add=0;
	$string='';
	$exitNum = explode("|",$row['ReqProduct']);
	for($i=0;$i<count($exitNum);$i++)
	{
		$exitSplit = explode(",",$exitNum[$i]);
		if($costOb['name'][$exitSplit[1]]==0.00)
		{
		$string .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' ';$p++;
		}
		else
		{
		$string .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;
		}
		//$pre_add+=$costOb['price'][$exitSplit[1]];
	}
	for($s=0;$s<strlen($string)/$strfix;$s++)
	{
		$eq[$s] = substr($string,$s*$strfix,$s*$strfix+$strfix);
	}
	$pre_add=$row['CostProduct'];
}
	
// add on 
if($row['detail_code_addon'] !='')
{
$i=0;
$exitANum = explode(",",$row['detail_code_addon']);
$exitSelect = explode(",",$row['detail_code_addon_id']);
$costAD =  0;
$addonView = '';
    for($i=0;$i<count($exitANum);$i++){
            $exitADDON = explode(",",$exitANum[$i]);
            $sqlAddon = "select * from tb_addon where id = '".$exitSelect[$i]."'";
            $sqlRes = mysql_query($sqlAddon);
            $sqlArr = mysql_fetch_array($sqlRes);
            $addonView  =  $addonView.' '.$sqlArr['name_addon'].' '.$sqlArr['id_add'].'  เบี้ยเพิ่ม '.$sqlArr['cost_insuran'].'  บาท   ';
            $costAD=$costAD+$sqlArr['cost_insuran'];
    }
}

//-----------------สลักหลัง-------------------------------///
$ShowReqOld = '';
if($row['send_req'] != ''){
	$ShowReqOld .= $row['send_req'];
}
if($row['send_req2'] != ''){
	$ShowReqOld .= $row['send_req2'];
}
if($row['send_cancel'] != ''){
	$ShowReqOld .= $row['send_cancel'];
}

$ShowReq = '';
if($row['EditTime'] == 'Y'){
	$ShowReq .= "วันที่คุ้มครอง : ".date('d/m/Y',strtotime($row['EditTime_StartDate']));
}
if($row['EditHr'] == 'Y'){
	$ShowReq .= "ผู้รับผลประโยชน์ : ".$row['EditHr_Detail'];
}
if($row['EditAct'] == 'Y'){
	$ShowReq .= "เลขที่ พรบ. : ".$row['EditAct_id'];
}
if($row['EditCar'] == 'Y'){
	$ShowReq .= "เลขตัวถัง : ".$row['Edit_CarBody']." / "."เลขเครื่อง : ".$row['Edit_Nmotor']." / "."สีรถ : ".$row['Edit_CarColor'];
}
if($row['EditCancel'] == 'Y'){
	$ShowReq .= " ยกเลิก : ".$row['Cancel_Detail']." วันที่ : ".date('d/m/Y', strtotime($row['Req_Date']));
}
if($row['EditCustomer'] == 'Y')
{
	if($row['EditPerson']==1)
							{
								$EDITPERSON = "บุคคลธรรมดา";
							}
							else if($row['EditPerson']==2){
								$EDITPERSON = "นิติบุคคล";
							}
	$ShowReq .= $EDITPERSON;
	$ShowReq .= " ชื่อผู้เอาประกันภัย : ".$row['Cus_title']." ".$row['Cus_name']." ".$row['Cus_last'];
	$ShowReq .= "ที่อยู่ :".$row['Cus_add']; 
	if($row['Cus_group'] !="-" && $row['Cus_group'] !=""){
		$ShowReq .= " หมู่".$row['Cus_group'];
	}
	if($row['Cus_town'] !="-" && $row['Cus_town'] !=""){
		$ShowReq .= " ".$row['Cus_town'];
	}
	if($row['Cus_lane'] !="-" && $row['Cus_lane'] !=""){
		$ShowReq .= " ซอย".$row['Cus_lane'];
	}
	if($row['Cus_road'] !="-"){
		$ShowReq .= " ถนน".$row['Cus_road'];
	}
	if($row1['Cus_province'] != "102"){
		$ShowReq .= "ต.".$row1['tumbon']." อ.".$row1['amphur']." จ.".$row1['province']." ".$row['Cus_postal']; 
	}else{
		$ShowReq .= "แขวง".$row1['tumbon']."  ".$row1['amphur']." ".$row1['province']." ".$row['Cus_postal'];
	}
	
}
if($row['EditCost'] == 'Y'){
	$ShowReq .= "เปลี่ยนค่าเบี้ย : ".$row['EditcostCost'];
}

//------------------------------------------------------------------------------------------------


$address_pdf="";
$address_pdf2="";
if($row['add'] !="-" && $row['add'] !="")
{
	$address_pdf .=$row['add'];
}
if($row['group'] !="-" && $row['group'] !="")
{
	$address_pdf .= " หมู่".$row['group'];
}
if($row['town'] !="-" && $row['town'] !="")
{
	$address_pdf .= " ".$row['town'];
}
if($row['lane'] !="-" && $row['lane'] !="")
{
	$address_pdf .= " ซอย".$row['lane'];
}
if($row['road'] !="-" && $row['road'] !="")
{
	$address_pdf .= " ถนน".$row['road'];
}

if($row['province'] != "102"){
	$address_pdf2 .= 'ต.'.$row['tumbon_name'].' อ.'.$row['amphur_name'].' จ.'.$row['province_name'].' '.$row['postal'];
}
else{
	$address_pdf2 .= 'แขวง'.$row['tumbon_name'].'  '.$row['amphur_name'].' '.$row['province_name'].' '.$row['postal'];
}

$sendYear = date('Y',strtotime($row['send_date']))+543;	
$startYear = date('Y',strtotime($row['start_date']))+543;
$endYear = date('Y',strtotime($row['end_date']))+543;

	define('FPDF_FONTPATH','font/');
	
	$pdf=new FPDF();
	$pdf->AddPage();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');
	$pdf->Image('../images/logo.gif',10,3,80);
	$pdf->Image('../i/dealer.png',10,27,20);
	$pdf->SetTextColor(255,0,0);
	$pdf->Ln(0);
	$pdf->SetFont('angsa','B',16);
	$pdf->Cell(155,5,iconv( 'UTF-8','TIS-620','แจ้งอุบัติเหตุ 24 ชั่วโมง '),0,0,"R");
	$pdf->SetFont('angsa','B',30);
	$pdf->Cell(15,4,iconv( 'UTF-8','TIS-620','1557'),0,0,"R");
	$pdf->SetFont('angsa','B',16);
	$pdf->Cell(20,5,iconv( 'UTF-8','TIS-620',' ทั่วประเทศ'),0,0,"R");
	$pdf->Ln(5);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('angsa','B',12);
	
	if($row['com_data']=='VIB_S'){
		$str_addressComp = 'ที่อยู่ 71 หมู่ 6 สะพานนนทบุรี-บางบัวทอง ต.คลองข่อย อ.ปากเกร็ด จ.นนทบุรี 11120';
		$str_NameComp = 'ปากเกร็ด 345';
	}
	else if($row['com_data']=='VIB_C'){
		$str_addressComp = 'ที่อยู่ 71 หมู่ 6 สะพานนนทบุรี-บางบัวทอง ต.คลองข่อย อ.ปากเกร็ด จ.นนทบุรี 11120';
		$str_NameComp = 'ปากเกร็ด 345';
	}
	
	$pdf->Cell(0,10,iconv( 'UTF-8','TIS-620',$str_NameComp.'          '.$row['title_sub'].' '.$row['sub'].'('.$row['login'].')'),0,1,"L");
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,-10,iconv( 'UTF-8','TIS-620','เลขที่กรมธรรม์ พ.ร.บ.: '.$row['p_act']),0,1,"R");
	$pdf->Ln(10);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','เลขที่รับแจ้ง : '.$row['id_data']),0,1,"L");
	$pdf->Ln(3);
	$pdf->SetFont('angsa','',12);
	
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$str_addressComp),0,1,"C");
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','เลขที่ประจำตัวผู้เสียภาษี 0105490000219'),0,1,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Ln(5);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','Tel. 02-196-8234 Fax. 02-196-8235'),0,1,"C");
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ทะเบียนการค้าเลขที่ 0105490000219'),0,1,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Ln(5);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','รหัสบริษัท VIB                                                                                        ใบคำขอประกันภัยรถยนต์                     อาณาเขตคุ้มครอง ประเทศไทย'),1);
	$pdf->Ln();
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','ใบคำขอเลขที่'),1);
	$pdf->SetX(40);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['id_data']),0);
	$pdf->Ln();
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,16,'',1);
	$pdf->Ln();
	$pdf->Cell(0,-25,iconv('UTF-8','TIS-620','ผู้เอาประกันภัย     ชื่อ    '),0);
	$pdf->SetX(37);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,-25,iconv('UTF-8','TIS-620',$row['title'].' '.$row['name'].' '.$row['last']),0);
	
	if($row['person'] == '1')
	{
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(0,-25,iconv('UTF-8','TIS-620','เลขบัตรประชาชน '.$row['icard']."   "),0,0,"R");
	}
	if($row['person'] == '2')
	{
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(0,-25,iconv('UTF-8','TIS-620','เลขทะเบียนนิติบุคคล '.$row['icard']."   "),0,0,"R");
	}
	
	$pdf->SetFont('angsa','',12);
	$pdf->SetY(40);
	$pdf->Cell(0,33,iconv('UTF-8','TIS-620','                             ที่อยู่  '),0);
	$pdf->SetY(40);
	$pdf->SetX(37);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,33,iconv('UTF-8','TIS-620',$address_pdf),0);
	$pdf->SetY(74);
	$pdf->SetX(37);
	$pdf->Cell(0,-25,iconv('UTF-8','TIS-620',$address_pdf2),0);
	$pdf->Ln(-10);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,13,'',1);
	$pdf->Ln();
	$pdf->Cell(0,-19,iconv('UTF-8','TIS-620','ผู้ขับขี่ 1 '.$row['title_num1'].$row['name_num1'].$row['last_num1']),0);
	$pdf->SetX(110);
	$pdf->Cell(0,-19,iconv('UTF-8','TIS-620','วัน/เดือน/ปีเกิด'.$row['birth_num1']),0);
	$pdf->Ln();
	$pdf->Cell(0,31,iconv('UTF-8','TIS-620','ผู้ขับขี่ 2 '.$row['title_num2'].$row['name_num2'].$row['last_num2']),0);
	$pdf->SetX(110);
	$pdf->Cell(0,31,iconv('UTF-8','TIS-620','วัน/เดือน/ปีเกิด          '.$row['birth_num2']),0);
	$pdf->Ln(19);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','ผู้รับผลประโยชน์           '.$row['name_gain']),1);
	$pdf->Ln(6);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','ระยะเวลาประกันภัย : เริ่มต้นวันที่ '),1);
	$pdf->SetX(60);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['start_date'])).'/'.$startYear),0);
	$pdf->SetFont('angsa','',12);
	$pdf->SetX(85);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','สิ้นสุดวันที่ '),0);
	$pdf->SetFont('angsa','B',12);
	$pdf->SetX(110);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['end_date'])).'/'.$endYear),0);
	$pdf->SetFont('angsa','',12);
	$pdf->SetX(135);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','เวลา '),0);
	$pdf->SetFont('angsa','B',12);
	$pdf->SetX(155);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','16.30 น.'),0);
	$pdf->SetFont('angsa','',12);
	$pdf->Ln(6);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','รายการรถยนต์ที่เอาประกันภัย'),1);
	$pdf->Ln(6);
	$pdf->MultiCell(9,6,iconv('UTF-8','TIS-620','ลำดับ'),1,"C");
	$pdf->Ln(-6);
	$pdf->SetX(19);
	$pdf->Cell(12,6,iconv('UTF-8','TIS-620','รหัส'),1,0,"C");
	$pdf->SetX(31);
	$pdf->Cell(40,6,iconv('UTF-8','TIS-620','ชื่อรถยนต์/รุ่น/เกียร์'),1,0,"C");
	$pdf->SetX(71);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620','เลขทะเบียน'),1,0,"C");
	$pdf->SetX(91);
	$pdf->Cell(40,6,iconv('UTF-8','TIS-620','เลขตัวถัง'),1,0,"C");
	$pdf->SetX(131);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620','ปีรุ่น'),1,0,"C");
	$pdf->SetX(151);
	$pdf->Cell(30,6,iconv('UTF-8','TIS-620','เลขเครื่อง'),1,0,"C");
	$pdf->SetX(181);
	$pdf->Cell(19,6,iconv('UTF-8','TIS-620','ที่นั่ง/ขนาด/น.น.'),1,0,"C");
	$pdf->Ln(1);
	$pdf->SetFont('angsa','B',12);
	$pdf->SetY(101);
	$pdf->MultiCell(9,12,iconv('UTF-8','TIS-620',' '),1,"C");
	$pdf->Ln(-12);
	$pdf->SetX(19);
	
	if($row['car_cat_acc'] != '')
	{
		$pdf->Cell(12,12,iconv('UTF-8','TIS-620',$row['car_cat_acc']),1,0,"C");
	}
	else
	{
		$pdf->Cell(12,12,iconv('UTF-8','TIS-620',$row['car_id']),1,0,"C");
	}
	
	$pdf->SetX(31);
	$pdf->Cell(40,12,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->SetX(31);
	$pdf->Cell(40,6,iconv('UTF-8','TIS-620',$row['car_brand']),0,0,"C");
	$pdf->SetY(106);
	$pdf->SetX(31);
	$pdf->Cell(40,6,iconv('UTF-8','TIS-620',$nameCar.' ('.$row['gear'].')'),0,0,"C");
	$pdf->SetY(101);
	$pdf->SetX(71);
	$pdf->Cell(20,12,iconv('UTF-8','TIS-620',$row['car_regis']),1,0,"C");
	$pdf->SetX(91);
	$pdf->Cell(40,12,iconv('UTF-8','TIS-620',$row['car_body']),1,0,"C");
	$pdf->SetX(131);
	$pdf->Cell(20,12,iconv('UTF-8','TIS-620',$row['regis_date']),1,0,"C");
	$pdf->SetX(151);
	$pdf->Cell(30,12,iconv('UTF-8','TIS-620',str_replace('-','',$row['n_motor'])),1,0,"C");
	$pdf->SetX(181);
	if(empty($scw))
	{
	if($row['mo_car'] == "759" || $row['mo_car'] == "747")
			{
				$scw = "7 / 1600 / 3";
			}
			else if($row['mo_car'] == "1098")
			{
				if($row['car_id'] == "320")
							{
								$scw = "3 / 1600 / 3";
							}
				else
							{
								$scw = "12 / 1600 / 3";
			}
			}
			else if($row['mo_car'] == "1951")
			{
				$scw = "7 / 1200 / 3";
			}
			else if($row['mo_car'] == "754")
			{
				$scw = "7 / 2000 / 3";
			}
	}
	$pdf->Cell(19,12,iconv('UTF-8','TIS-620',$scw),1,0,"C");
	$pdf->Ln(12);
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','จำนวนเงินเอาประกันภัย : กรมธรรม์ประกันภัยนี้ให้การคุ้มครองเฉพาะข้อตกลงคุ้มครองที่มีจำนวนเงินเอาประกันภัยระบุไว้เท่านั้น'),1);
	$pdf->Ln(5);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','ความรับผิดชอบต่อบุคคลภายนอก'),1,0,"C");
	$pdf->Cell(55,6,iconv('UTF-8','TIS-620','รถยนต์เสียหาย สูญหาย ไฟไหม้'),1,0,"C");
	$pdf->Cell(75,6,iconv('UTF-8','TIS-620','ความคุ้มครองตามเอกสารแนบท้าย'),1,0,"C");
	$pdf->Ln(6);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->Ln(-24);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620','1) ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย'),0,0,"L");
	$pdf->Ln(6);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620','     เฉพาะส่วนเกินวงเงินสูงสุดตาม พ.ร.บ.'),0,0,"L");
	$pdf->Ln(6);
	if($row['car_id'] == "110")
			{
				$payp = "1,000,000";
			}
	else
			{
				$payp = "300,000";
			}
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(45,54,iconv('UTF-8','TIS-620',$payp),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/คน'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(45,54,iconv('UTF-8','TIS-620','10,000,000'),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620','2) ความเสียหายต่อทรัพย์สิน'),0,0,"L");
	
	
	if($row['car_id'] == "110")
			{
				$payp = "5,000,000";
			}
			else if($row['car_id'] == "320")
			{
				$payp = "1,000,000";
			}
			else
			{
				$payp = "600,000";
			}
	$pdf->Ln(6);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(45,54,iconv('UTF-8','TIS-620',$payp),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620','     2.1 ความเสียหายส่วนแรก'),0,0,"L");
	$pdf->SetFont('angsa','B',12);
	if($row['car_cat_acc']=='230')
	{
		$frist = "-";
		$frist_1_1 = " 3,000 บาท/ครั้ง";
	}
	else if($row['car_id'] == "220" OR $row['car_id'] == "230" OR $row['car_cat_acc']=='220')
	{
		$frist = "-";
		$frist_1_1 = "";
	}
	else
	{
		$frist = "-";
		$frist_1_1 = "";
	}
	$pdf->SetX(10);
	$pdf->Cell(45,54,iconv('UTF-8','TIS-620',$frist),0,0,"R");
	$pdf->SetFont('angsa','',12);
	
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->Ln(-12);
	$pdf->SetX(70);
	$pdf->Cell(55,54,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->Ln(-24);
	$pdf->SetX(70);
	$pdf->Cell(55,54,iconv('UTF-8','TIS-620','1) ความเสียหายต่อรถยนต์'),0,0,"L");
	
	$cost_exp=explode(' ',$row['cost']);
	$cost = preg_replace("/[^0-9]/", "",$cost_exp[0]);
	
	if($row['insure_year'] == '2')
	{
		$cost_new = number_format($cost-30000);
	}
	else if($row['insure_year'] == '3')
	{
		$cost_new = number_format($cost-90000);
	}
	else
	{
		$cost_new = number_format($cost);
	}
	
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(40,54,iconv('UTF-8','TIS-620',$cost_new),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->Cell(55,54,iconv('UTF-8','TIS-620','     1.1 ความเสียหายส่วนแรก'.$frist_1_1),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->Cell(55,54,iconv('UTF-8','TIS-620','2) รถยนต์สูญหาย/ไฟไหม้'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(40,54,iconv('UTF-8','TIS-620',$cost_new),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(40,54,iconv('UTF-8','TIS-620','-'),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->SetFont('angsa','',31);
	$pdf->Ln(16);
	$pdf->SetX(70);
	$pdf->Cell(55,54,iconv('UTF-8','TIS-620','ไม่รวม พ.ร.บ.'),0,0,"C");
	$pdf->Ln(-22);
	$pdf->SetX(125);
	$pdf->SetFont('angsa','',12);

	$pdf->Cell(75,54,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->Ln(-24);
	$pdf->SetX(125);
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','1) อุบัติเหตุส่วนบุคคล'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','     1.1 เสียชีวิต สูญเสียอวัยวะ ทุพพลภาพถาวร'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','     ก) ผู้ขับขี่ 1 คน'),0,0,"L");
	$pdf->SetX(125);
		if($row['car_id'] == "110")
			{
				$strOption1 = "200,000";
			}
			else if($row['car_id'] == "320")
			{
				$strOption1 = "200,000";
			}
			else
			{
				$strOption1 = "50,000";
			}
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620',$strOption1),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท'),0,0,"L");
		
	if($row['car_cat_acc'] != "")
	{
		$strOption = "11";
	}
	else
	{
		if($row['car_id'] == "110")
		{
			$strOption = "6";
		}
		else if($row['car_id'] == "320")
		{
			$strOption = "2";
		}
		else
		{
			$strOption = "-";
		}	
	}
	
	$pdf->Ln(6);
	$pdf->SetX(125);	
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','     ข) ผู้โดยสาร '.$strOption.' คน'),0,0,"L");
	$pdf->SetX(125);
	$pdf->SetFont('angsa','B',12);

	$pdf->Cell(60,54,iconv('UTF-8','TIS-620',$strOption1),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/คน'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(125);	
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','     1.2) ทุพพลภาพชั่วคราว'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','     ก) ผู้ขับขี่ 1 คน'),0,0,"L");
	$pdf->SetX(125);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(50,54,iconv('UTF-8','TIS-620','ไม่คุ้มครอง'),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(23,54,iconv('UTF-8','TIS-620','บาท/สัปดาห์'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(125);	
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','     ข) ผู้โดยสาร - คน'),0,0,"L");
	$pdf->SetX(125);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(50,54,iconv('UTF-8','TIS-620','ไม่คุ้มครอง'),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(23,54,iconv('UTF-8','TIS-620','บาท/คน/สัปดาห์'),0,0,"L");
	
	if($row['car_id'] == "110")
			{
				
				$strOption = "200,000";
				$strOption1 = "200,000";
			}
else if($row['car_id'] == "320")
			{
				$strOption = "50,000";
				$strOption1 = "50,000";
			}

			else
			{
				$strOption = "50,000";
				$strOption1 = "200,000";
			}

	
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','2) ค่ารักษาพยาบาล'),0,0,"L");
	$pdf->SetX(125);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620',$strOption),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/คน'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','3) การประกันตัวผู้ขับขี่'),0,0,"L");
	$pdf->SetX(125);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620',$strOption1),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	$pdf->Ln(30);
	$pdf->Cell(115,9,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(95,5,iconv('UTF-8','TIS-620','เบี้ยประกันตามความคุ้มครองหลัก'),0,0,"L");
	$pdf->Cell(2,5,iconv('UTF-8','TIS-620','-'),0,0,"L");
	$pdf->Cell(18,5,iconv('UTF-8','TIS-620','บาท'),0,0,"L");
	
	$pdf->Ln(4);
	$pdf->SetX(10);
	$pdf->Cell(95,5,iconv('UTF-8','TIS-620','(เบี้ยประกันภัยได้หักส่วนลดกรณีระบุชื่อผู้ขับขี่'),0,0,"L");
	$pdf->Cell(2,5,iconv('UTF-8','TIS-620','-'),0,0,"L");
	$pdf->Cell(18,5,iconv('UTF-8','TIS-620','บาทแล้ว)'),0,0,"L");
	
	$pdf->Ln(-4);
	$pdf->SetX(125);
	$pdf->Cell(75,9,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->SetX(125);
	$pdf->Cell(60,5,iconv('UTF-8','TIS-620','เบี้ยประกันภัยตามเอกสารแนบท้าย'),0,0,"L");
	$pdf->Cell(2,5,iconv('UTF-8','TIS-620','-'),0,0,"L");
	$pdf->Cell(13,5,iconv('UTF-8','TIS-620','บาท'),0,0,"L");
	$pdf->Ln(9);
	$pdf->Cell(10,9,iconv('UTF-8','TIS-620','ส่วนลด'),1,0,"C");
	$pdf->Cell(50,9,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->Ln(-2);
	$pdf->SetX(20);
	$pdf->Cell(50,9,iconv('UTF-8','TIS-620','ความเสียหายส่วนแรก'),0,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(50,9,iconv('UTF-8','TIS-620','- บาท'),0,0,"R");
	$pdf->Ln(4);
	$pdf->SetX(20);
	$pdf->Cell(50,9,iconv('UTF-8','TIS-620','อื่นๆ'),0,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(50,9,iconv('UTF-8','TIS-620','- บาท'),0,0,"R");
	$pdf->Ln(-2);
	$pdf->SetX(70);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->Ln(-2);
	$pdf->SetX(70);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620','ส่วนลดกลุ่ม'),0,0,"L");
	$pdf->SetX(70);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620','- บาท'),0,0,"R");
	$pdf->Ln(4);
	$pdf->SetX(70);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620','รวมส่วนลด'),0,0,"L");
	$pdf->SetX(70);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620','- บาท'),0,0,"R");
	$pdf->Ln(-2);
	$pdf->SetX(135);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->Ln(-2);
	$pdf->SetX(135);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620','ประวัติดี'),0,0,"L");
	$pdf->SetX(135);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620','- บาท'),0,0,"R");
	
	$pdf->Ln(11);
	$pdf->Cell(10,6,iconv('UTF-8','TIS-620','ส่วนเพิ่ม'),1,0,"C");
	$pdf->Cell(180,6,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->Ln(-3);
	$pdf->SetX(20);
	$pdf->Cell(180,12,iconv('UTF-8','TIS-620','ความเสียหายส่วนแรก'),0,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(180,12,iconv('UTF-8','TIS-620','- บาท'),0,0,"C");
	$pdf->SetTextColor(255,0,0);
	$pdf->SetFont('angsa','B',14);
	$pdf->SetX(20);
	$pdf->Cell(180,12,iconv('UTF-8','TIS-620','ชำระอากรแล้ว'),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->SetTextColor(0,0,0);
	
	$pdf->Ln(9);
	$pdf->SetFont('angsa','',10);
	$pdf->Cell(60,5,iconv('UTF-8','TIS-620','เบี้ยประกันสุทธิ'),1,0,"C");
	$pdf->SetX(70);
	$pdf->Cell(45,5,iconv('UTF-8','TIS-620','อากร'),1,0,"C");
	$pdf->SetX(115);
	$pdf->Cell(35,5,iconv('UTF-8','TIS-620','ภาษีมูลค่าเพิ่ม'),1,0,"C");
	$pdf->SetX(150);
	$pdf->Cell(50,5,iconv('UTF-8','TIS-620','รวม'),1,0,"C");
	$pdf->Ln(5);
	$pdf->SetFont('angsa','',14);
	
	$query_UCostRenew = "SELECT pre,stamp,tax,net FROM UCostRenew WHERE type = 'S_Rate' AND cost = '".$cost."' AND service = '2'";
	$objQuery_UCostRenew = mysql_query($query_UCostRenew) or die ("Error query_UCostRenew [".$query_UCostRenew."]");
	$row_UCostRenew = mysql_fetch_array($objQuery_UCostRenew);

	if($row['insure_year'] == '2')
	{
		$pre = number_format($row_UCostRenew['pre'],2);
		$stamp = number_format($row_UCostRenew['stamp'],2);
		$tax = number_format($row_UCostRenew['tax'],2);
		$net = number_format($row_UCostRenew['net'],2);
	}
	else if($row['insure_year'] == '3')
	{
		$pre = number_format($row_UCostRenew['pre'],2);
		$stamp = number_format($row_UCostRenew['stamp'],2);
		$tax = number_format($row_UCostRenew['tax'],2);
		$net = number_format($row_UCostRenew['net'],2);
	}
	else
	{
		$pre = number_format($row['pre'],2);
		$stamp = number_format($row['stamp'],2);
		$tax = number_format($row['tax'],2);
		$net = number_format($row['net'],2);
	}
	
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620',$pre),1,0,"C");
	$pdf->SetX(70);
	$pdf->Cell(45,6,iconv('UTF-8','TIS-620',$stamp),1,0,"C");
	$pdf->SetX(115);
	$pdf->Cell(35,6,iconv('UTF-8','TIS-620',$tax),1,0,"C");
	$pdf->SetX(150);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',$net),1,0,"C");
	
	$pdf->SetFont('angsa','',9);
	$pdf->Ln(6);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','การใช้รถยนต์ '),1,0,"L");
	
	$pdf->SetX(40);
	
	$query_Passcar="SELECT name FROM tb_pass_car_type WHERE id='$arr_car_id[1]$arr_car_id[2]' AND id_pass_car='$arr_car_id[0]'";
	
	$objQuery_Passcar = mysql_query($query_Passcar) or die ("Error Query [".$query_Passcar."]");

	$row_Passcar = mysql_fetch_array($objQuery_Passcar);
	$IDNAME = $row_Passcar['name'];
	
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$IDNAME),0,0,"L");
	$pdf->Ln(5);
	
	//----------------------------------เงื่อนไขอุปกรณ์ตกแต่ง-------------------------------////
				
	
if($ShowReq =='' && $ShowReqOld =='')
{
	$pdf->Cell(0,35,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetY(213);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620','อุปกรณ์ตกแต่งเพิ่มเติม : '),0,0,"L");
	$pdf->SetX(31);
	$pdf->SetFont('angsa','B',9);
	$rowcheck = 217;
	for($i=0;$i<count($eq);$i++)
	{
		$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$eq[$i]),0,0,"L");
		$pdf->SetY($rowcheck);
		$rowcheck = $rowcheck+4;
	}
	
	
	
	if($row['car_cat_acc_total'] != '0.00' && $row['car_cat_acc'] != '')
	{	
		if($row['car_cat_acc'] == '220')
		{
			if($row['EditProduct'] =='Y')
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน'.number_format($row['TotalProduct']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
			else
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน'.number_format($row['price_total']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
		}
		else if($row['car_cat_acc'] == '230')
		{
			if($row['EditProduct'] =='Y')
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน'.number_format($row['TotalProduct']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
			else
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน'.number_format($row['price_total']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
		}
		else
		{
			if($row['EditProduct'] =='Y')
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : ('.$row['car_cat_acc'].' รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน'.number_format($row['TotalProduct']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
			else
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : ('.$row['car_cat_acc'].' รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน'.number_format($row['price_total']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
		}
		$pdf->SetY(224);
		$pdf->SetFont('angsa','B',11);
		$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$type_acc),0,0,"L");
	}
	else
	{
		/// ราคาสลักหลัง ///////////////////////////////////////////////////////////////
		$pdf->SetY(224);
		$pdf->SetFont('angsa','B',11);
		
		if($row['EditProduct'] !='Y')
		{
			$TotalProduct = number_format($row['price_total']);
			$TotalPrice = number_format($row['add_price'],2);
			if($pre_add ==0.00)
			{
				//$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.number_format($pre_add,2,'.',',')."  บาท"),0,0,"R");
			}
			else
			{
				$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.number_format($pre_add,2,'.',',')."  บาท"),0,0,"R");
			}
		}
		if($row['EditProduct'] =='Y')
		{
			$TotalProduct = number_format($row['TotalProduct']);
			$TotalPrice = number_format($row['CostProduct'],2);
			
			$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.$TotalPrice."  บาท"),0,0,"R");
		}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}
        
        /////////////////ADD ON ///////////////
            $pdf->Ln(10);
            $pdf->Cell(0,35,iconv('UTF-8','TIS-620',''),1,0,"L");
            $pdf->SetY(229);
            $pdf->SetX(10);
            $pdf->SetFont('angsa','',9);
            $pdf->Cell(0,16,iconv('UTF-8','TIS-620','Add On : '),0,0,"L");
            $pdf->SetX(31);
            $pdf->SetFont('angsa','B',9);
           // $rowcheck = 229;
            $vpos = '229';
            $vposums = '240';
            
           if($row['detail_code_addon'] != ''){
                    $pdf->Cell(0,16,iconv('UTF-8','TIS-620',$addonView),0,0,"L");
                    $pdf->SetY($vpos);
                   // $rowcheck = $rowcheck+4;
           
            $pdf->SetY($vposums);
            $pdf->SetFont('angsa','B',11);
            $pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มเบี้ยรวม '.number_format($costAD,2)."  บาท"),0,0,"R");
        }else{
            $pdf->Cell(0,16,iconv('UTF-8','TIS-620','ไม่มี'),0,0,"L");
                    $pdf->SetY($vpos);
                   // $rowcheck = $rowcheck+4;
           
            $pdf->SetY($vposums);
            $pdf->SetFont('angsa','B',11);
            //$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มเบี้ยรวม '.number_format(0,2)."  บาท"),0,0,"R");
        }
	  /////////////////END ADD ON ///////////////
        
        
	$pdf->Ln(10);
	$pdf->SetFont('angsa','',9);
	
	if($row['career']==1)
	{
		$note = 'ออกใบเสร็จในนามบริษัท';
	}
	else
	{
		$note = 'ออกใบเสร็จในนามลูกค้า';
	}
if($row['SendAdd'] != ''){
if($row['status_SendAdd']=='Y')
{
	$address_pdf='';
	$textaddarray=explode('|',$row['SendAdd']);
		if($textaddarray[0] !="-" && $textaddarray[0] !="")
	{
		$address_pdf .= $textaddarray[0];
	}
	if($textaddarray[1] !="-" && $textaddarray[1] !="")
	{
		$address_pdf .= " หมู่ ".$textaddarray[1];
	}
	if($textaddarray[2] !="-" && $textaddarray[2] !="")
	{
		$address_pdf .= " หมู่บ้าน/อาคาร ".$textaddarray[2];
	}
	if($textaddarray[3] !="-" && $textaddarray[3] !="")
	{
		$address_pdf .= "ซอย ".$textaddarray[3]." ";
	}
	if($textaddarray[4] !="-" && $textaddarray[4] !="")
	{
		$address_pdf .= "ถนน ".$textaddarray[4];
	}
	if($textaddarray[5] != "102")
	{
		$address_pdf .= ' ต.'.$_SESSION["Tum"][$textaddarray[7]].' อ.'.$_SESSION["Amp"][$textaddarray[6]];
		$address_pdf .= ' จ.'.$_SESSION["Pro"][$textaddarray[5]].' '.$textaddarray[8];
	}
	else
	{
		$address_pdf .= ' แขวง'.$_SESSION["Tum"][$textaddarray[7]].'  '.$_SESSION["Amp"][$textaddarray[6]];
		$address_pdf .= ' '.$_SESSION["Pro"][$textaddarray[5]].' '.$textaddarray[8];
	}
	$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : '.$address_pdf.')';
}
else
{
	$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : '.$row['SendAdd'].')';
}
}
		$pdf->SetY(253);
		$pdf->Cell(0,5,iconv('UTF-8','TIS-620','หมายเหตุ : '.$note.$SendAdd),1,0,"L");
		$pdf->SetY(245);
		$pdf->Ln(13);
		$pdf->SetFont('angsa','',12);
		$pdf->Image('../images/2.jpg',15,259,4);
		$pdf->Cell(0,6,iconv('UTF-8','TIS-620',''),1,0,"L");
		$pdf->SetX(20);
		$pdf->Cell(50,6,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
		$pdf->SetX(50);
		$pdf->Image('../images/1.jpg',55,259,4);
		$pdf->SetX(60);
		$pdf->Cell(60,6,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
		$pdf->SetFont('angsa','B',12);
		$pdf->SetX(100);
		$pdf->Cell(60,6,iconv('UTF-8','TIS-620','บจ.โฟร์ อินชัวรันส์ โบรกเกอร์'),0,0,"L");
		$pdf->SetFont('angsa','',12);
		$pdf->SetX(120);
		$pdf->Cell(80,6,iconv('UTF-8','TIS-620','ใบอนุญาตเลขที่ ว00018/2551'),0,0,"R");
		$pdf->Ln(6);
		$pdf->Cell(50,6,iconv('UTF-8','TIS-620','วันทำสัญญาประกันภัย'),0,0,"L");
		$pdf->SetX(50);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(50,6,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['start_date'])).'/'.$startYear),0,0,"C");
		$pdf->SetX(100);
		$pdf->SetFont('angsa','',12);
		$pdf->Cell(50,6,iconv('UTF-8','TIS-620','วันทำกรมธรรม์'),0,0,"L");
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(50,6,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['send_date'])).'/'.$sendYear),0,0,"C");
}	
else if($ShowReq != '' || $ShowReqOld != '')
{
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetY(213);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620','อุปกรณ์ตกแต่งเพิ่มเติม : '),0,0,"L");
	$pdf->SetX(31);
	$pdf->SetFont('angsa','B',9);
	$rowcheck = 217;
	for($i=0;$i<count($eq);$i++){
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$eq[$i]),0,0,"L");
	$pdf->SetY($rowcheck);
	$rowcheck = $rowcheck+4;
	}

	
	if($row['car_cat_acc_total'] != '0.00' && $row['car_cat_acc'] != '')
	{
		if($row['car_cat_acc'] == '220')
		{
			if($row['EditProduct'] =='Y')
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน'.number_format($row['TotalProduct']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
			else
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน'.number_format($row['price_total']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
		}
		else if($row['car_cat_acc'] == '230')
		{
			if($row['EditProduct'] =='Y')
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน'.number_format($row['TotalProduct']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
			else
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน'.number_format($row['price_total']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
		}
		$pdf->SetY(224);
		$pdf->SetFont('angsa','B',11);
		$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$type_acc." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") "),0,0,"L");	
	}
	else
	{
		$pdf->SetY(224);
		$pdf->SetFont('angsa','B',11);
		if($row['EditProduct'] !='Y')
		{
			$TotalProduct = number_format($row['price_total']);
			$TotalPrice = number_format($row['add_price'],2);
		}
		if($row['EditProduct'] =='Y')
		{
			$TotalProduct = number_format($row['TotalProduct']);
			$TotalPrice = number_format($row['CostProduct'],2);
		}
		if($pre_add ==0.00)
		{
			//$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.number_format($pre_add,2,'.',',')."  บาท"." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") "),0,0,"R");
		}
		else
		{
			$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.number_format($pre_add,2,'.',',')."  บาท"." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") "),0,0,"R");
		}
	}
            $pdf->Ln(10);
            $pdf->Cell(0,35,iconv('UTF-8','TIS-620',''),1,0,"L");
            $pdf->SetY(230);
            $pdf->SetX(10);
            $pdf->SetFont('angsa','',9);
            $pdf->Cell(0,16,iconv('UTF-8','TIS-620','Add On : '),0,0,"L");
            $pdf->SetX(31);
            $pdf->SetFont('angsa','B',9);
            $postY = '230';
            $postSY = '230';
           // $rowcheck = 229;
         if($row['detail_code_addon'] != ''){   
                    $pdf->Cell(0,16,iconv('UTF-8','TIS-620',$addonView),0,0,"L");
                    $pdf->SetY($postY);
                    
                    $pdf->SetY($postSY);
                    $pdf->SetFont('angsa','B',11);
                    $pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มเบี้ยรวม '.number_format($costAD,2)."  บาท"),0,0,"R");
        }else{
                    $pdf->Cell(0,16,iconv('UTF-8','TIS-620','ไม่มี'),0,0,"L");
                    $pdf->SetY($postY);
                    $pdf->SetY($postSY);
                    $pdf->SetFont('angsa','B',11);
                    //$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มเบี้ยรวม '.number_format(0,2)."  บาท"),0,0,"R");
        }
	
	
	$pdf->Ln(10);
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,19,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetY(235);
	$pdf->SetX(10);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620','สลักหลัง :'),0,0,"L");
	$pdf->SetX(20);
	$pdf->SetFont('angsa','B',9);
	$P_req = 0;
	$PCut_req = 0;
						if($row['send_req'] != ''){
							$line[$P_req] .= $row['send_req']." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") ".' |';
							$PCut_req++;
							if($PCut_req>=3){
							$P_req++;
							}
						}
						if($row['send_req2'] != ''){
							$line[$P_req] .= $row['send_req2']." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") ".' |';
							$PCut_req++;
							if($PCut_req>=3){
							$P_req++;
							}
						}
						if($row['send_cancel'] != ''){
							$line[$P_req] .= $row['send_cancel']." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") ".' |';
							$PCut_req++;
							if($PCut_req>=3){
							$P_req++;
							}
						}
						
						if($row['EditTime'] == 'Y'){
							$line[$P_req] .= "วันที่คุ้มครอง : ".date('d/m/Y',strtotime($row['EditTime_StartDate']))." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") ".' |';
							$PCut_req++;
							if($PCut_req>=3){
							$P_req++;
							}
						}
						if($row['EditHr'] == 'Y'){
							$line[$P_req] .= " ผู้รับผลประโยชน์ : ".$row['EditHr_Detail']." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date']))."]".' |';
							$PCut_req++;
							if($PCut_req>=3){
							$P_req++;
							}
						}
						if($row['EditAct'] == 'Y'){
							$line[$P_req] .= "เลขที่ พรบ. : ".$row['EditAct_id']." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") ".' |';
							$PCut_req++;
							if($PCut_req>=3){
							$P_req++;
							}
						}
						if($row['EditCar'] == 'Y'){
							$line[$P_req] .= " เลขตัวถัง : ".$row['Edit_CarBody']." / "."เลขเครื่อง : ".$row['Edit_Nmotor']." / "."สีรถ : ".$row['Edit_CarColor']." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") ".' |';
							$PCut_req++;
							if($PCut_req>=3){
							$P_req++;
							}
						}
						if($row['EditCancel'] == 'Y'){
							$line[$P_req] .= " ยกเลิก : ".$row['Cancel_Detail']." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") ".' |';
							$PCut_req++;
							if($PCut_req>=3){
							$P_req++;
							}
						}
						if($row['EditCustomer'] == 'Y'){
							$line[$P_req] .= " ชื่อผู้เอาประกันภัย : ".$row['Cus_title']." ".$row['Cus_name']." ".$row['Cus_last'];
							$line[$P_req] .= " ที่อยู่ : ".$row['Cus_add']; 
							if($row['Cus_group'] !="-" && $row['Cus_group'] !="")
							{
								$line[$P_req] .=  " หมู่".$row['Cus_group'];
							}
							if($row['Cus_town'] !="-" && $row['Cus_town'] !="")
							{
								$line[$P_req] .= " ".$row['Cus_town'];
							}
							if($row['Cus_lane'] !="-" && $row['Cus_lane'] !="")
							{
								$line[$P_req] .= " ซอย".$row['Cus_lane'];
							}
							if($row['Cus_road'] !="-" && $row['Cus_road'] !="")
							{
								$line[$P_req] .= " ถนน".$row['Cus_road'];
							}
							if($row['Cus_province'] != "102")
							{
								$line[$P_req] .= "ต.".$row1['tumbon']." อ.".$row1['amphur']." จ.".$row1['province']." ".$row['Cus_postal']; 
							}else{
								$line[$P_req] .= "แขวง".$row1['tumbon']."  ".$row1['amphur']." ".$row1['province']." ".$row['Cus_postal'];
							}
							$line[$P_req] .= " (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") ".' | ';
							$PCut_req++;
							if($PCut_req>=3){
							$P_req++;
							}
						}
						if($row['EditCost'] == 'Y'){
							$line[$P_req] .= "ค่าเบี้ย : ".$row['EditcostCost']." (วันที่สลักหลัง : ".date('d/m/Y',strtotime($row['Req_Date'])).") ";
							$PCut_req++;
							if($PCut_req>=3){
							$P_req++;
							}
						}
	
	for($r=0;$r<=$P_req;$r++) {
		if($r==0){
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$line[$r]),0,0,"L");
	}
	else{
	$y=235;
	$li=4;
	$step=$y+($li*$r);
	$pdf->SetY($step);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$line[$r]),0,0,"L");
	}
}
	
	if($row['career']==1)
	{
		$note = 'ออกใบเสร็จในนามบริษัท';
	}
	else
	{
		$note = 'ออกใบเสร็จในนามลูกค้า';
	}
if($row['SendAdd'] != ''){
if($row['status_SendAdd']=='Y')
{
	$address_pdf='';
	$textaddarray=explode('|',$row['SendAdd']);
		if($textaddarray[0] !="-" && $textaddarray[0] !="")
	{
		$address_pdf .= $textaddarray[0];
	}
	if($textaddarray[1] !="-" && $textaddarray[1] !="")
	{
		$address_pdf .= " หมู่ ".$textaddarray[1];
	}
	if($textaddarray[2] !="-" && $textaddarray[2] !="")
	{
		$address_pdf .= " หมู่บ้าน/อาคาร ".$textaddarray[2];
	}
	if($textaddarray[3] !="-" && $textaddarray[3] !="")
	{
		$address_pdf .= "ซอย ".$textaddarray[3]." ";
	}
	if($textaddarray[4] !="-" && $textaddarray[4] !="")
	{
		$address_pdf .= "ถนน ".$textaddarray[4];
	}
	if($textaddarray[5] != "102")
	{
		$address_pdf .= ' ต.'.$_SESSION["Tum"][$textaddarray[7]].' อ.'.$_SESSION["Amp"][$textaddarray[6]];
		$address_pdf .= ' จ.'.$_SESSION["Pro"][$textaddarray[5]].' '.$textaddarray[8];
	}
	else
	{
		$address_pdf .= ' แขวง'.$_SESSION["Tum"][$textaddarray[7]].'  '.$_SESSION["Amp"][$textaddarray[6]];
		$address_pdf .= ' '.$_SESSION["Pro"][$textaddarray[5]].' '.$textaddarray[8];
	}
	$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : '.$address_pdf.')';
}
else
{
	$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : '.$row['SendAdd'].')';
}
}

	$pdf->SetY(253);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','หมายเหตุ : '.$note.$SendAdd),1,0,"L");
	$pdf->SetY(245);
	$pdf->Ln(13);
	$pdf->SetFont('angsa','',12);
	$pdf->Image('../images/2.jpg',15,259,4);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
	$pdf->SetX(50);
	$pdf->Image('../images/1.jpg',55,259,4);
	$pdf->SetX(60);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
	$pdf->SetFont('angsa','B',12);
	$pdf->SetX(100);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','บจ.โฟร์ อินชัวรันส์ โบรกเกอร์'),0,0,"L");
	$pdf->SetFont('angsa','',12);
	$pdf->SetX(120);
	$pdf->Cell(80,6,iconv('UTF-8','TIS-620','ใบอนุญาตเลขที่ ว00018/2551'),0,0,"R");
	$pdf->Ln(6);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','วันทำสัญญาประกันภัย'),0,0,"L");
	$pdf->SetX(50);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['start_date'])).'/'.$startYear),0,0,"C");
	$pdf->SetX(100);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','วันทำกรมธรรม์'),0,0,"L");
	$pdf->SetX(150);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['send_date'])).'/'.$sendYear),0,0,"C");
	}
	
	
	$pdf->Ln(6);
	$pdf->SetY(272);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,4,iconv('UTF-8','TIS-620','เอกสารฉบับนี้เป็นเพียงข้อเสนอประกันภัยรถยนต์เท่านั้นส่วนเงื่อนไขความคุ้มครอง ข้อยกเว้น ตามที่กำหนด ระบุอยู่ในกรมธรรม์ประกันภัยรถยนต์'),0,0,"L");

//////////////////////////////////////////////////สำหรับลูกค้า////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////

$address_pdf="";
$address_pdf2="";
if($row['add'] !="-" && $row['add'] !="")
{
	$address_pdf .=$row['add'];
}
if($row['group'] !="-" && $row['group'] !="")
{
	$address_pdf .= " หมู่".$row['group'];
}
if($row['town'] !="-" && $row['town'] !="")
{
	$address_pdf .= " ".$row['town'];
}
if($row['lane'] !="-" && $row['lane'] !="")
{
	$address_pdf .= " ซอย".$row['lane'];
}
if($row['road'] !="-" && $row['road'] !="")
{
	$address_pdf .= " ถนน".$row['road'];
}

if($row['province'] != "102"){
	$address_pdf2 .= 'ต.'.$row['tumbon_name'].' อ.'.$row['amphur_name'].' จ.'.$row['province_name'].' '.$row['postal'];
}
else{
	$address_pdf2 .= 'แขวง'.$row['tumbon_name'].'  '.$row['amphur_name'].' '.$row['province_name'].' '.$row['postal'];
}
	$pdf->AddPage();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');
	$pdf->Image('../images/logo.gif',10,3,80);
	$pdf->Image('../i/customer.png',10,27,20);
	$pdf->SetTextColor(255,0,0);
	$pdf->Ln(0);
	$pdf->SetFont('angsa','B',16);
	$pdf->Cell(155,5,iconv( 'UTF-8','TIS-620','แจ้งอุบัติเหตุ 24 ชั่วโมง '),0,0,"R");
	$pdf->SetFont('angsa','B',30);
	$pdf->Cell(15,4,iconv( 'UTF-8','TIS-620','1557'),0,0,"R");
	$pdf->SetFont('angsa','B',16);
	$pdf->Cell(20,5,iconv( 'UTF-8','TIS-620',' ทั่วประเทศ'),0,0,"R");
	$pdf->Ln(5);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('angsa','B',12);
	
	if($row['com_data']=='VIB_S'){
		$str_addressComp = 'ที่อยู่ 71 หมู่ 6 สะพานนนทบุรี-บางบัวทอง ต.คลองข่อย อ.ปากเกร็ด จ.นนทบุรี 11120';
		$str_NameComp = 'ปากเกร็ด 345';
	}
	else if($row['com_data']=='VIB_C'){
		$str_addressComp = 'ที่อยู่ 71 หมู่ 6 สะพานนนทบุรี-บางบัวทอง ต.คลองข่อย อ.ปากเกร็ด จ.นนทบุรี 11120';
		$str_NameComp = 'ปากเกร็ด 345';
	}
	
	$pdf->Cell(0,10,iconv( 'UTF-8','TIS-620',$str_NameComp.'          '.$row['title_sub'].' '.$row['sub'].'('.$row['login'].')'),0,1,"L");
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,-10,iconv( 'UTF-8','TIS-620','เลขที่กรมธรรม์ พ.ร.บ.: '.$row['p_act']),0,1,"R");
	$pdf->Ln(10);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','เลขที่รับแจ้ง : '.$row['id_data']),0,1,"L");
	$pdf->Ln(3);
	$pdf->SetFont('angsa','',12);
	
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$str_addressComp),0,1,"C");
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','เลขที่ประจำตัวผู้เสียภาษี 0105490000219'),0,1,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Ln(5);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','Tel. 02-196-8234 Fax. 02-196-8235'),0,1,"C");
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ทะเบียนการค้าเลขที่ 0105490000219'),0,1,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Ln(5);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','รหัสบริษัท VIB                                                                                        ใบคำขอประกันภัยรถยนต์                     อาณาเขตคุ้มครอง ประเทศไทย'),1);
	$pdf->Ln();
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','ใบคำขอเลขที่'),1);
	$pdf->SetX(40);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['id_data']),0);
	$pdf->Ln();
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,16,'',1);
	$pdf->Ln();
	$pdf->Cell(0,-25,iconv('UTF-8','TIS-620','ผู้เอาประกันภัย     ชื่อ    '),0);
	$pdf->SetX(37);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,-25,iconv('UTF-8','TIS-620',$row['title'].' '.$row['name'].' '.$row['last']),0);
	if($row['person'] == '1')
	{
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(0,-25,iconv('UTF-8','TIS-620','เลขบัตรประชาชน '.$row['icard']."   "),0,0,"R");
	}
	if($row['person'] == '2')
	{
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(0,-25,iconv('UTF-8','TIS-620','เลขทะเบียนนิติบุคคล '.$row['icard']."   "),0,0,"R");
	}
	$pdf->SetFont('angsa','',12);
	$pdf->SetY(40);
	$pdf->Cell(0,33,iconv('UTF-8','TIS-620','                             ที่อยู่  '),0);
	$pdf->SetY(40);
	$pdf->SetX(37);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,33,iconv('UTF-8','TIS-620',$address_pdf),0);
	$pdf->SetY(74);
	$pdf->SetX(37);
	$pdf->Cell(0,-25,iconv('UTF-8','TIS-620',$address_pdf2),0);
	$pdf->Ln(-10);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,13,'',1);
	$pdf->Ln();
	$pdf->Cell(0,-19,iconv('UTF-8','TIS-620','ผู้ขับขี่ 1 '.$row['title_num1'].$row['name_num1'].$row['last_num1']),0);
	$pdf->SetX(110);
	$pdf->Cell(0,-19,iconv('UTF-8','TIS-620','วัน/เดือน/ปีเกิด'.$row['birth_num1']),0);
	$pdf->Ln();
	$pdf->Cell(0,31,iconv('UTF-8','TIS-620','ผู้ขับขี่ 2 '.$row['title_num2'].$row['name_num2'].$row['last_num2']),0);
	$pdf->SetX(110);
	$pdf->Cell(0,31,iconv('UTF-8','TIS-620','วัน/เดือน/ปีเกิด          '.$row['birth_num2']),0);
	$pdf->Ln(19);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','ผู้รับผลประโยชน์           '.$row['name_gain']),1);
	$pdf->Ln(6);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','ระยะเวลาประกันภัย : เริ่มต้นวันที่ '),1);
	$pdf->SetX(60);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['start_date'])).'/'.$startYear),0);
	$pdf->SetFont('angsa','',12);
	$pdf->SetX(85);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','สิ้นสุดวันที่ '),0);
	$pdf->SetFont('angsa','B',12);
	$pdf->SetX(110);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['end_date'])).'/'.$endYear),0);
	$pdf->SetFont('angsa','',12);
	$pdf->SetX(135);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','เวลา '),0);
	$pdf->SetFont('angsa','B',12);
	$pdf->SetX(155);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','16.30 น.'),0);
	$pdf->SetFont('angsa','',12);
	$pdf->Ln(6);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','รายการรถยนต์ที่เอาประกันภัย'),1);
	$pdf->Ln(6);
	$pdf->MultiCell(9,6,iconv('UTF-8','TIS-620','ลำดับ'),1,"C");
	$pdf->Ln(-6);
	$pdf->SetX(19);
	$pdf->Cell(12,6,iconv('UTF-8','TIS-620','รหัส'),1,0,"C");
	$pdf->SetX(31);
	$pdf->Cell(40,6,iconv('UTF-8','TIS-620','ชื่อรถยนต์/รุ่น/เกียร์'),1,0,"C");
	$pdf->SetX(71);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620','เลขทะเบียน'),1,0,"C");
	$pdf->SetX(91);
	$pdf->Cell(40,6,iconv('UTF-8','TIS-620','เลขตัวถัง'),1,0,"C");
	$pdf->SetX(131);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620','ปีรุ่น'),1,0,"C");
	$pdf->SetX(151);
	$pdf->Cell(30,6,iconv('UTF-8','TIS-620','เลขเครื่อง'),1,0,"C");
	$pdf->SetX(181);
	$pdf->Cell(19,6,iconv('UTF-8','TIS-620','ที่นั่ง/ขนาด/น.น.'),1,0,"C");
	$pdf->Ln(1);
	$pdf->SetFont('angsa','B',12);
	$pdf->SetY(101);
	$pdf->MultiCell(9,12,iconv('UTF-8','TIS-620',' '),1,"C");
	$pdf->Ln(-12);
	$pdf->SetX(19);
	if($row['car_cat_acc'] != '')
	{
		$pdf->Cell(12,12,iconv('UTF-8','TIS-620',$row['car_cat_acc']),1,0,"C");
	}
	else
	{
		$pdf->Cell(12,12,iconv('UTF-8','TIS-620',$row['car_id']),1,0,"C");
	}
	$pdf->SetX(31);
	$pdf->Cell(40,12,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->SetX(31);
	$pdf->Cell(40,6,iconv('UTF-8','TIS-620',$row['car_brand']),0,0,"C");
	$pdf->SetY(106);
	$pdf->SetX(31);
	$pdf->Cell(40,6,iconv('UTF-8','TIS-620',$nameCar.' ('.$row['gear'].')'),0,0,"C");
	$pdf->SetY(101);
	$pdf->SetX(71);
	$pdf->Cell(20,12,iconv('UTF-8','TIS-620',$row['car_regis']),1,0,"C");
	$pdf->SetX(91);
	$pdf->Cell(40,12,iconv('UTF-8','TIS-620',$row['car_body']),1,0,"C");
	$pdf->SetX(131);
	$pdf->Cell(20,12,iconv('UTF-8','TIS-620',$row['regis_date']),1,0,"C");
	$pdf->SetX(151);
	$pdf->Cell(30,12,iconv('UTF-8','TIS-620',str_replace('-','',$row['n_motor'])),1,0,"C");
	$pdf->SetX(181);
	if(empty($scw))
	{
	if($row['mo_car'] == "759" || $row['mo_car'] == "747")
			{
				$scw = "7 / 1600 / 3";
			}
			else if($row['mo_car'] == "1098")
			{
				if($row['car_id'] == "320")
							{
								$scw = "3 / 1600 / 3";
							}
				else
							{
								$scw = "15 / 1600 / 3";
			}
			}
			else if($row['mo_car'] == "1951")
			{
				$scw = "7 / 1200 / 3";
			}
			else if($row['mo_car'] == "754")
			{
				$scw = "7 / 2000 / 3";
			}
	}
	$pdf->Cell(19,12,iconv('UTF-8','TIS-620',$scw),1,0,"C");
	$pdf->Ln(12);
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','จำนวนเงินเอาประกันภัย : กรมธรรม์ประกันภัยนี้ให้การคุ้มครองเฉพาะข้อตกลงคุ้มครองที่มีจำนวนเงินเอาประกันภัยระบุไว้เท่านั้น'),1);
	$pdf->Ln(5);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','ความรับผิดชอบต่อบุคคลภายนอก'),1,0,"C");
	$pdf->Cell(55,6,iconv('UTF-8','TIS-620','รถยนต์เสียหาย สูญหาย ไฟไหม้'),1,0,"C");
	$pdf->Cell(75,6,iconv('UTF-8','TIS-620','ความคุ้มครองตามเอกสารแนบท้าย'),1,0,"C");
	$pdf->Ln(6);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->Ln(-24);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620','1) ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย'),0,0,"L");
	$pdf->Ln(6);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620','     เฉพาะส่วนเกินวงเงินสูงสุดตาม พ.ร.บ.'),0,0,"L");
	$pdf->Ln(6);
	if($row['car_id'] == "110")
			{
				$payp = "1,000,000";
			}
			else
			{
				$payp = "300,000";
			}
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(45,54,iconv('UTF-8','TIS-620',$payp),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/คน'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(45,54,iconv('UTF-8','TIS-620','10,000,000'),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620','2) ความเสียหายต่อทรัพย์สิน'),0,0,"L");
	
	
if($row['car_id'] == "110")
			{
				$payp = "5,000,000";
			}
			else if($row['car_id'] == "320")
			{
				$payp = "1,000,000";
			}
			else
			{
				$payp = "600,000";
			}
	$pdf->Ln(6);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(45,54,iconv('UTF-8','TIS-620',$payp),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
		if($row['car_cat_acc']=='230')
	{
		$frist = "-";
		$frist_1_1 = " 3,000 บาท/ครั้ง";
	}
	else if($row['car_id'] == "220" OR $row['car_id'] == "230" OR $row['car_cat_acc']=='220')
	{
		$frist = "-";
		$frist_1_1="";
	}
	else
	{
		$frist = "-";
		$frist_1_1="";
	}
	$pdf->Ln(6);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620','     2.1 ความเสียหายส่วนแรก'),0,0,"L");
	$pdf->SetFont('angsa','B',12);
	$pdf->SetX(10);
	$pdf->Cell(45,54,iconv('UTF-8','TIS-620',$frist),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->Ln(-12);
	$pdf->SetX(70);
	$pdf->Cell(55,54,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->Ln(-24);
	$pdf->SetX(70);
	$pdf->Cell(55,54,iconv('UTF-8','TIS-620','1) ความเสียหายต่อรถยนต์'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(40,54,iconv('UTF-8','TIS-620',$cost_new),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->Cell(55,54,iconv('UTF-8','TIS-620','     1.1 ความเสียหายส่วนแรก'.$frist_1_1),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->Cell(55,54,iconv('UTF-8','TIS-620','2) รถยนต์สูญหาย/ไฟไหม้'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(40,54,iconv('UTF-8','TIS-620',$cost_new),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(40,54,iconv('UTF-8','TIS-620','-'),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->SetFont('angsa','',31);
	$pdf->Ln(16);
	$pdf->SetX(70);
	$pdf->Cell(55,54,iconv('UTF-8','TIS-620','ไม่รวม พ.ร.บ.'),0,0,"C");
	$pdf->Ln(-22);
	$pdf->SetX(125);
	$pdf->SetFont('angsa','',12);

	$pdf->Cell(75,54,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->Ln(-24);
	$pdf->SetX(125);
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','1) อุบัติเหตุส่วนบุคคล'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','     1.1 เสียชีวิต สูญเสียอวัยวะ ทุพพลภาพถาวร'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','     ก) ผู้ขับขี่ 1 คน'),0,0,"L");
	$pdf->SetX(125);
	$pdf->SetFont('angsa','B',12);
	if($row['car_id'] == "110")
			{
				$strOption1 = "200,000";
			}
			else if($row['car_id'] == "320")
			{
				$strOption1 = "200,000";
			}
			else
			{
				$strOption1 = "50,000";
			}
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620',$strOption1),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท'),0,0,"L");
	if($row['car_cat_acc'] != "")
	{
		$strOption = "11";
	}
	else
	{
		if($row['car_id'] == "110")
		{
			$strOption = "6";
		}
		else if($row['car_id'] == "320")
		{
			$strOption = "2";
		}
		else
		{
			$strOption = "-";
		}	
	}
	$pdf->Ln(6);
	$pdf->SetX(125);	
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','     ข) ผู้โดยสาร '.$strOption.' คน'),0,0,"L");
	$pdf->SetX(125);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620',$strOption1),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/คน'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(125);	
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','     1.2) ทุพพลภาพชั่วคราว'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','     ก) ผู้ขับขี่ 1 คน'),0,0,"L");
	$pdf->SetX(125);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(50,54,iconv('UTF-8','TIS-620','ไม่คุ้มครอง'),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(23,54,iconv('UTF-8','TIS-620','บาท/สัปดาห์'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(125);	
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','     ข) ผู้โดยสาร - คน'),0,0,"L");
	$pdf->SetX(125);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(50,54,iconv('UTF-8','TIS-620','ไม่คุ้มครอง'),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(23,54,iconv('UTF-8','TIS-620','บาท/คน/สัปดาห์'),0,0,"L");
	
	if($row['car_id'] == "110")
			{
				
				$strOption = "200,000";
				$strOption1 = "200,000";
			}
else if($row['car_id'] == "320")
			{
				$strOption = "50,000";
				$strOption1 = "50,000";
			}

			else
			{
				$strOption = "50,000";
				$strOption1 = "200,000";
			}
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','2) ค่ารักษาพยาบาล'),0,0,"L");
	$pdf->SetX(125);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620',$strOption),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/คน'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','3) การประกันตัวผู้ขับขี่'),0,0,"L");
	$pdf->SetX(125);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620',$strOption1),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	$pdf->Ln(30);
	$pdf->Cell(115,9,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(95,5,iconv('UTF-8','TIS-620','เบี้ยประกันตามความคุ้มครองหลัก'),0,0,"L");
	$pdf->Cell(2,5,iconv('UTF-8','TIS-620','-'),0,0,"L");
	$pdf->Cell(18,5,iconv('UTF-8','TIS-620','บาท'),0,0,"L");
	
	$pdf->Ln(4);
	$pdf->SetX(10);
	$pdf->Cell(95,5,iconv('UTF-8','TIS-620','(เบี้ยประกันภัยได้หักส่วนลดกรณีระบุชื่อผู้ขับขี่'),0,0,"L");
	$pdf->Cell(2,5,iconv('UTF-8','TIS-620','-'),0,0,"L");
	$pdf->Cell(18,5,iconv('UTF-8','TIS-620','บาทแล้ว)'),0,0,"L");
	
	$pdf->Ln(-4);
	$pdf->SetX(125);
	$pdf->Cell(75,9,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->SetX(125);
	$pdf->Cell(60,5,iconv('UTF-8','TIS-620','เบี้ยประกันภัยตามเอกสารแนบท้าย'),0,0,"L");
	$pdf->Cell(2,5,iconv('UTF-8','TIS-620','-'),0,0,"L");
	$pdf->Cell(13,5,iconv('UTF-8','TIS-620','บาท'),0,0,"L");
	$pdf->Ln(9);
	$pdf->Cell(10,9,iconv('UTF-8','TIS-620','ส่วนลด'),1,0,"C");
	$pdf->Cell(50,9,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->Ln(-2);
	$pdf->SetX(20);
	$pdf->Cell(50,9,iconv('UTF-8','TIS-620','ความเสียหายส่วนแรก'),0,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(50,9,iconv('UTF-8','TIS-620','- บาท'),0,0,"R");
	$pdf->Ln(4);
	$pdf->SetX(20);
	$pdf->Cell(50,9,iconv('UTF-8','TIS-620','อื่นๆ'),0,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(50,9,iconv('UTF-8','TIS-620','- บาท'),0,0,"R");
	$pdf->Ln(-2);
	$pdf->SetX(70);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->Ln(-2);
	$pdf->SetX(70);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620','ส่วนลดกลุ่ม'),0,0,"L");
	$pdf->SetX(70);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620','- บาท'),0,0,"R");
	$pdf->Ln(4);
	$pdf->SetX(70);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620','รวมส่วนลด'),0,0,"L");
	$pdf->SetX(70);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620','- บาท'),0,0,"R");
	$pdf->Ln(-2);
	$pdf->SetX(135);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->Ln(-2);
	$pdf->SetX(135);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620','ประวัติดี'),0,0,"L");
	$pdf->SetX(135);
	$pdf->Cell(65,9,iconv('UTF-8','TIS-620','- บาท'),0,0,"R");
	
	$pdf->Ln(11);
	$pdf->Cell(10,6,iconv('UTF-8','TIS-620','ส่วนเพิ่ม'),1,0,"C");
	$pdf->Cell(180,6,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->Ln(-3);
	$pdf->SetX(20);
	$pdf->Cell(180,12,iconv('UTF-8','TIS-620','ความเสียหายส่วนแรก'),0,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(180,12,iconv('UTF-8','TIS-620','- บาท'),0,0,"C");
	$pdf->SetTextColor(255,0,0);
	$pdf->SetFont('angsa','B',14);
	$pdf->SetX(20);
	$pdf->Cell(180,12,iconv('UTF-8','TIS-620','ชำระอากรแล้ว'),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->SetTextColor(0,0,0);
	
	$pdf->Ln(9);
	$pdf->SetFont('angsa','',10);
	$pdf->Cell(60,5,iconv('UTF-8','TIS-620','เบี้ยประกันสุทธิ'),1,0,"C");
	$pdf->SetX(70);
	$pdf->Cell(45,5,iconv('UTF-8','TIS-620','อากร'),1,0,"C");
	$pdf->SetX(115);
	$pdf->Cell(35,5,iconv('UTF-8','TIS-620','ภาษีมูลค่าเพิ่ม'),1,0,"C");
	$pdf->SetX(150);
	$pdf->Cell(50,5,iconv('UTF-8','TIS-620','รวม'),1,0,"C");
	$pdf->Ln(5);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620',$pre),1,0,"C");
	$pdf->SetX(70);
	$pdf->Cell(45,6,iconv('UTF-8','TIS-620',$stamp),1,0,"C");
	$pdf->SetX(115);
	$pdf->Cell(35,6,iconv('UTF-8','TIS-620',$tax),1,0,"C");
	$pdf->SetX(150);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',$net),1,0,"C");
	
	$pdf->SetFont('angsa','',9);
	$pdf->Ln(6);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','การใช้รถยนต์ '),1,0,"L");
	
	$pdf->SetX(40);
	
	$query_Passcar="SELECT name FROM tb_pass_car_type WHERE id='$arr_car_id[1]$arr_car_id[2]' AND id_pass_car='$arr_car_id[0]'";
	
	$objQuery_Passcar = mysql_query($query_Passcar) or die ("Error Query [".$query_Passcar."]");

	$row_Passcar = mysql_fetch_array($objQuery_Passcar);
	$IDNAME = $row_Passcar['name'];
	
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$IDNAME),0,0,"L");
	$pdf->Ln(5);
	
	//----------------------------------เงื่อนไขอุปกรณ์ตกแต่ง-------------------------------////
				
if($ShowReq =='' && $ShowReqOld ==''){

$pdf->Cell(0,35,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetY(213);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620','อุปกรณ์ตกแต่งเพิ่มเติม : '),0,0,"L");
	$pdf->SetX(31);
	$pdf->SetFont('angsa','B',9);
	$rowcheck = 217;
	for($i=0;$i<count($eq);$i++)
	{
		$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$eq[$i]),0,0,"L");
		$pdf->SetY($rowcheck);
		$rowcheck = $rowcheck+4;
	}
	
	
	
	if($row['car_cat_acc_total'] != '0.00' && $row['car_cat_acc'] != '')
	{	
		if($row['car_cat_acc'] == '220')
		{
			if($row['EditProduct'] =='Y')
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน'.number_format($row['TotalProduct']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
			else
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน'.number_format($row['price_total']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
		}
		else if($row['car_cat_acc'] == '230')
		{
			if($row['EditProduct'] =='Y')
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน'.number_format($row['TotalProduct']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
			else
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน'.number_format($row['price_total']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
		}
		$pdf->SetY(228);
		$pdf->SetFont('angsa','B',11);
		$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$type_acc),0,0,"L");
	}
	else
	{
		$pdf->SetY(228);
		$pdf->SetFont('angsa','B',11);
		if($row['EditProduct'] !='Y')
		{
			$TotalProduct = number_format($row['price_total']);
			$TotalPrice = number_format($row['add_price'],2);
		if($pre_add ==0.00)
		{
			//$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.number_format($pre_add,2,'.',',')."  บาท"),0,0,"R");
		}
		else
		{
			$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.number_format($pre_add,2,'.',',')."  บาท"),0,0,"R");
		}
		}
		if($row['EditProduct'] =='Y')
		{
			$TotalProduct = number_format($row['TotalProduct']);
			$TotalPrice = number_format($row['CostProduct'],2);	
	if($TotalPrice>0.00)
	{		
			$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.$TotalPrice."  บาท"),0,0,"R");
	}
		}
	}
       
            $pdf->Ln(10);
            $pdf->Cell(0,32,iconv('UTF-8','TIS-620',''),1,0,"L");
            $pdf->SetY(233);
            $pdf->SetX(10);
            $pdf->SetFont('angsa','',9);
            $pdf->Cell(0,16,iconv('UTF-8','TIS-620','Add On : '),0,0,"L");
            $pdf->SetX(31);
            $pdf->SetFont('angsa','B',9);
            $postY = '229';
            $postSY = '240';
           // $rowcheck = 229;
         if($row['detail_code_addon'] != ''){   
                    $pdf->Cell(0,16,iconv('UTF-8','TIS-620',$addonView),0,0,"L");
                    $pdf->SetY($postY);
                    
                    $pdf->SetY($postSY);
                    $pdf->SetFont('angsa','B',11);
                    $pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มเบี้ยรวม '.number_format($costAD,2)."  บาท"),0,0,"R");
        }else{
                    $pdf->Cell(0,16,iconv('UTF-8','TIS-620','ไม่มี'),0,0,"L");
                    $pdf->SetY($postY);
                    $pdf->SetY($postSY);
                    $pdf->SetFont('angsa','B',11);
                    //$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มเบี้ยรวม '.number_format(0,2)."  บาท"),0,0,"R");
        }
		
	$pdf->Ln(10);
	$pdf->SetFont('angsa','',9);
		
	if($row['career']==1)
	{
		$note = 'ออกใบเสร็จในนามบริษัท';
	}
	else
	{
		$note = 'ออกใบเสร็จในนามลูกค้า';
	}
if($row['SendAdd'] != ''){
if($row['status_SendAdd']=='Y')
{
	$address_pdf='';
	$textaddarray=explode('|',$row['SendAdd']);
		if($textaddarray[0] !="-" && $textaddarray[0] !="")
	{
		$address_pdf .= $textaddarray[0];
	}
	if($textaddarray[1] !="-" && $textaddarray[1] !="")
	{
		$address_pdf .= " หมู่ ".$textaddarray[1];
	}
	if($textaddarray[2] !="-" && $textaddarray[2] !="")
	{
		$address_pdf .= " หมู่บ้าน/อาคาร ".$textaddarray[2];
	}
	if($textaddarray[3] !="-" && $textaddarray[3] !="")
	{
		$address_pdf .= "ซอย ".$textaddarray[3]." ";
	}
	if($textaddarray[4] !="-" && $textaddarray[4] !="")
	{
		$address_pdf .= "ถนน ".$textaddarray[4];
	}
	if($textaddarray[5] != "102")
	{
		$address_pdf .= ' ต.'.$_SESSION["Tum"][$textaddarray[7]].' อ.'.$_SESSION["Amp"][$textaddarray[6]];
		$address_pdf .= ' จ.'.$_SESSION["Pro"][$textaddarray[5]].' '.$textaddarray[8];
	}
	else
	{
		$address_pdf .= ' แขวง'.$_SESSION["Tum"][$textaddarray[7]].'  '.$_SESSION["Amp"][$textaddarray[6]];
		$address_pdf .= ' '.$_SESSION["Pro"][$textaddarray[5]].' '.$textaddarray[8];
	}
	$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : '.$address_pdf.')';
}
else
{
	$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : '.$row['SendAdd'].')';
}
}
	$pdf->SetY(253);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','หมายเหตุ : '.$note.$SendAdd),1,0,"L");
	$pdf->SetY(245);
	$pdf->Ln(13);
	$pdf->SetFont('angsa','',12);
	$pdf->Image('../images/2.jpg',15,259,4);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
	$pdf->SetX(50);
	$pdf->Image('../images/1.jpg',55,259,4);
	$pdf->SetX(60);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
	$pdf->SetFont('angsa','B',12);
	$pdf->SetX(100);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','บจ.โฟร์ อินชัวรันส์ โบรกเกอร์'),0,0,"L");
	$pdf->SetFont('angsa','',12);
	$pdf->SetX(120);
	$pdf->Cell(80,6,iconv('UTF-8','TIS-620','ใบอนุญาตเลขที่ ว00018/2551'),0,0,"R");
	$pdf->Ln(6);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','วันทำสัญญาประกันภัย'),0,0,"L");
	$pdf->SetX(50);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['start_date'])).'/'.$startYear),0,0,"C");
	$pdf->SetX(100);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','วันทำกรมธรรม์'),0,0,"L");
	$pdf->SetX(150);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['send_date'])).'/'.$sendYear),0,0,"C");
	}
	
	
	else if($ShowReq != '' || $ShowReqOld != ''){
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetY(213);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620','อุปกรณ์ตกแต่งเพิ่มเติม : '),0,0,"L");
	$pdf->SetX(31);
	$pdf->SetFont('angsa','B',9);
	$rowcheck = 217;
	for($i=0;$i<count($eq);$i++)
	{
		$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$eq[$i]),0,0,"L");
		$pdf->SetY($rowcheck);
		$rowcheck = $rowcheck+4;
	}
	
	
	if($row['car_cat_acc_total'] != '0.00' && $row['car_cat_acc'] != '')
	{		
		if($row['car_cat_acc'] == '220')
		{
			if($row['EditProduct'] =='Y')
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน'.number_format($row['TotalProduct']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
			else
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน'.number_format($row['price_total']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
		}
		else if($row['car_cat_acc'] == '230')
		{
			if($row['EditProduct'] =='Y')
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน'.number_format($row['TotalProduct']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
			else
			{
				$type_acc = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน'.number_format($row['price_total']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
			}
		}
		$pdf->SetY(224);
		$pdf->SetFont('angsa','B',11);
		$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$type_acc),0,0,"L");
	}
	else
	{
		$pdf->SetY(224);
		$pdf->SetFont('angsa','B',11);
		if($row['EditProduct'] !='Y')
		{
			$TotalProduct = number_format($row['price_total']);
			$TotalPrice = number_format($row['add_price'],2);
		}
		if($row['EditProduct'] =='Y')
		{
			$TotalProduct = number_format($row['TotalProduct']);
			$TotalPrice = number_format($row['CostProduct'],2);
		}
		if($pre_add ==0.00)
		{
			//$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.number_format($pre_add,2,'.',',')."  บาท"),0,0,"R");
		}
		else
		{
			$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.$TotalProduct.' บาท'.'เพิ่มเบี้ยรวม '.number_format($pre_add,2,'.',',')."  บาท"),0,0,"R");
		}
	}
            $pdf->Ln(10);
            $pdf->Cell(0,35,iconv('UTF-8','TIS-620',''),1,0,"L");
            $pdf->SetY(230);
            $pdf->SetX(10);
            $pdf->SetFont('angsa','',9);
            $pdf->Cell(0,16,iconv('UTF-8','TIS-620','Add On : '),0,0,"L");
            $pdf->SetX(31);
            $pdf->SetFont('angsa','B',9);
            $postY = '230';
            $postSY = '230';
           // $rowcheck = 229;
         if($row['detail_code_addon'] != ''){   
                    $pdf->Cell(0,16,iconv('UTF-8','TIS-620',$addonView),0,0,"L");
                    $pdf->SetY($postY);
                    
                    $pdf->SetY($postSY);
                    $pdf->SetFont('angsa','B',11);
                    $pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มเบี้ยรวม '.number_format($costAD,2)."  บาท"),0,0,"R");
        }else{
                    $pdf->Cell(0,16,iconv('UTF-8','TIS-620','ไม่มี'),0,0,"L");
                    $pdf->SetY($postY);
                    $pdf->SetY($postSY);
                    $pdf->SetFont('angsa','B',11);
                    //$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มเบี้ยรวม '.number_format(0,2)."  บาท"),0,0,"R");
        }
	
	$pdf->Ln(10);
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,19,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetY(235);
	$pdf->SetX(10);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620','สลักหลัง :'),0,0,"L");
	$pdf->SetX(20);
	$pdf->SetFont('angsa','B',9);
	
	for($r=0;$r<=$P_req;$r++) {
		if($r==0){
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$line[$r]),0,0,"L");
	}
	else if($r!=0){
	$y=235;
	$li=4;
	$step=$y+($li*$r);
	$pdf->SetY($step);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$line[$r]),0,0,"L");
	}
}
	
	if($row['career']==1)
	{
		$note = 'ออกใบเสร็จในนามบริษัท';
	}
	else
	{
		$note = 'ออกใบเสร็จในนามลูกค้า';
	}
if($row['SendAdd'] != ''){
if($row['status_SendAdd']=='Y')
{
	$address_pdf='';
	$textaddarray=explode('|',$row['SendAdd']);
		if($textaddarray[0] !="-" && $textaddarray[0] !="")
	{
		$address_pdf .= $textaddarray[0];
	}
	if($textaddarray[1] !="-" && $textaddarray[1] !="")
	{
		$address_pdf .= " หมู่ ".$textaddarray[1];
	}
	if($textaddarray[2] !="-" && $textaddarray[2] !="")
	{
		$address_pdf .= " หมู่บ้าน/อาคาร ".$textaddarray[2];
	}
	if($textaddarray[3] !="-" && $textaddarray[3] !="")
	{
		$address_pdf .= "ซอย ".$textaddarray[3]." ";
	}
	if($textaddarray[4] !="-" && $textaddarray[4] !="")
	{
		$address_pdf .= "ถนน ".$textaddarray[4];
	}
	if($textaddarray[5] != "102")
	{
		$address_pdf .= ' ต.'.$_SESSION["Tum"][$textaddarray[7]].' อ.'.$_SESSION["Amp"][$textaddarray[6]];
		$address_pdf .= ' จ.'.$_SESSION["Pro"][$textaddarray[5]].' '.$textaddarray[8];
	}
	else
	{
		$address_pdf .= ' แขวง'.$_SESSION["Tum"][$textaddarray[7]].'  '.$_SESSION["Amp"][$textaddarray[6]];
		$address_pdf .= ' '.$_SESSION["Pro"][$textaddarray[5]].' '.$textaddarray[8];
	}
	$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : '.$address_pdf.')';
}
else
{
	$SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : '.$row['SendAdd'].')';
}
}

	$pdf->SetY(253);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','หมายเหตุ : '.$note.$SendAdd),1,0,"L");
	$pdf->SetY(245);
	$pdf->Ln(13);
	$pdf->SetFont('angsa','',12);
	$pdf->Image('../images/2.jpg',15,259,4);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
	$pdf->SetX(50);
	$pdf->Image('../images/1.jpg',55,259,4);
	$pdf->SetX(60);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
	$pdf->SetFont('angsa','B',12);
	$pdf->SetX(100);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','บจ.โฟร์ อินชัวรันส์ โบรกเกอร์'),0,0,"L");
	$pdf->SetFont('angsa','',12);
	$pdf->SetX(120);
	$pdf->Cell(80,6,iconv('UTF-8','TIS-620','ใบอนุญาตเลขที่ ว00018/2551'),0,0,"R");
	$pdf->Ln(6);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','วันทำสัญญาประกันภัย'),0,0,"L");
	$pdf->SetX(50);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['start_date'])).'/'.$startYear),0,0,"C");
	$pdf->SetX(100);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','วันทำกรมธรรม์'),0,0,"L");
	$pdf->SetX(150);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',date('d/m',strtotime($row['send_date'])).'/'.$sendYear),0,0,"C");
	}
	
	$pdf->Ln(6);
	$pdf->SetY(272);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,4,iconv('UTF-8','TIS-620','เอกสารฉบับนี้เป็นเพียงข้อเสนอประกันภัยรถยนต์เท่านั้น ส่วนเงื่อนไข ความคุ้มครอง ข้อยกเว้น เป็นไปตามที่กำหนดในกรมธรรม์ประกันภัยรถยนต์ และเอกสารแนบท้าย'),0,0,"C");

		$pdf->Output("../email/tmp/".$row['title']."".$row['namecus']." ".$row['last'].".pdf","F");

	$mail = new PHPMailer();  // กำหนดตัวแปร  $mail
	$mail->CharSet = 'UTF-8';                                                                
    $mail->From = "admin@my4ib.com";
    $mail->FromName = "แจ้งประกันภัยออนไลน์"; // กำหนดชื่อผู้ส่ง
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
   //เก่า
    //$mail->Host = _MAIL_MY4IB ; // "localhost"; // SMTP servermail.my4ib.com
    //$mail->Port = 25; // พอร์ท
    //$mail->Username = "prakunpai@my4ib.com"; // account SMTP
    //$mail->Password = "pra12641"; // รหัสผ่าน SMTP
	
	
	//ใหม่
	$mail->Host = _SMTP_MY4IB_TLS; // "localhost"; // SMTP servermail.my4ib.com
    $mail->Port = _SMTP_MY4IB_POST; // พอร์ท
    $mail->Username = _SMTP_MY4IB_USERNAME_ADMIN; // account SMTP
    $mail->Password = _SMTP_MY4IB_PASSWORD_ADMIN; // รหัสผ่าน SMTP
	//TT//////////TT/////////
	if($row['com_data'] == 'VIB_C')
	{
		if($row['Email1']!="" && $row['Email1']){ //Mail Four

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email1']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email2']!="" && $row['Email2']){ //Mail CEO

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email2']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email3']!="" && $row['Email3']){ //Mail วิริยะ

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email3']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email4']!="" && $row['Email4']){ //Mail Dealer

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email4']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email5']!="" && $row['Email5']){ //Mail Dealer

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email5']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
	}
	else if($row['com_data'] == 'VIB_S')
	{
		if($row['Email1']!="" && $row['Email1']){ //Mail Four

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email1']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email2']!="" && $row['Email2']){ //Mail CEO

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email2']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email3']!="" && $row['Email3']){ //Mail วิริยะ

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email3']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email4']!="" && $row['Email4']){ //Mail Dealer

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email4']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email5']!="" && $row['Email5']){ //Mail Dealer

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email5']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		
	}
	else if($row['com_data'] == 'VIB_F')
	{
		if($row['Email1']!="" && $row['Email1']){ //Mail Four

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email1']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email2']!="" && $row['Email2']){ //Mail CEO

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email2']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email3']!="" && $row['Email3']){ //Mail วิริยะ

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email3']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email4']!="" && $row['Email4']){ //Mail Dealer

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email4']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email5']!="" && $row['Email5']){ //Mail Dealer

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email5']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
	}
	//TT//////////TT/////////
if($row['unit_edit']>0)
{
	$text_edit = " (แก้ไขครั้งที่ ".$row['unit_edit'].") ";
}
else
{
	$text_edit = "";
}
	$mail->AddAddress('policy@my4ib.com', "");
	//$mail->AddAddress('wisaruth@my4ib.com', "");
	//$mail->AddAddress('atikarnp@viriyah.co.th', "");
	//$mail->AddAddress('piyanartb@viriyah.co.th', "");
	//$mail->AddAddress('info_support@my4ib.com', "");
	if(!empty($row['n_insure']))
	{
		//$mail->AddAddress('nongnutr@viriyah.co.th', "");
	}
	else
	{
		if($row['EditCancel']=='Y')
		{
			//$mail->AddAddress('nongnutr@viriyah.co.th', "");
		}
		else
		{
			//$mail->AddAddress('nongnutr@viriyah.co.th', "");
			//$mail->AddAddress('atikarnp@viriyah.co.th', "");
		}
	}
if(!empty($txtCC)){
			$pieces=''; $np=0;
            $pieces = explode(",", $txtCC);
            $np = count($pieces);
            for($j=0;$j<$np;$j++){
               $exccb='';
                $exccb = explode('@',$pieces[$j]);
                if($exccb[1]!='' && $pieces[$j] != 'atikarnp@viriyah.co.th'){
                    $mail->AddCC($pieces[$j], "");
                }
            }
}
	
    $mail->Subject = "แจ้งประกันภัย ".$row['car_brand']." ".$nameCar." เลขรับแจ้ง ".$row['id_data']." ".$text_edit; // กำหนดหัวข้ออีเมล์
    $mail->Body = "วิริยะประกันภัย เลขที่รับแจ้ง ".$row['id_data']." ".$row['title']."".$row['namecus']." ".$row['last']." คุ้มครอง : ". date('d/m',strtotime($row['start_date'])).'/'.$startYear."-".date('d/m',strtotime($row['end_date'])).'/'.$endYear." แจ้งอุบัติเหตุ 24 ชม. ทั่วประเทศ เบอร์สายด่วน 1557"; // กำหนดเนื้อหาอีเมล์
	$mail->AddAttachment("../email/tmp/".$row['title']."".$row['namecus']." ".$row['last'].".pdf");

    $mail->IsHTML(false); 
   
    // $mail->Send();

    if($mail->Send()){
    	$sendm=1;
    }
	
    unlink("../email/tmp/".$row['title']."".$row['namecus']." ".$row['last'].".pdf");
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($row['equit'] =='Y' || $row['Req_Status'] =='Y')
{
	$pdf=new FPDF();	
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();
	//df->SetFillColor(227,227,227);	//สีกรอบ fill
	//$pdf->SetTextColor(255,0,0); 		//สีตัวอักษร
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');	
	
	$pdf->Image("../images/BG_req.png",0,25,210,0);
	
	//
		$pdf->Image('../images/logo.gif',7,5,70,0);
	
		$pdf->SetY(23);
		$pdf->SetX(6);
		$pdf->SetFont('angsa','',11);
		//$pdf->Cell(100,0,iconv( 'UTF-8','TIS-620',$row['add_namecom']." ".$row['add_namecom2'].' Tel. 02-196-8234   Fax. 02-196-8235 (Auto)'),0,1,"L");
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	// HEAD
	$pdf->SetY(33);
	$pdf->SetX(17);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(50,7,iconv( 'UTF-8','TIS-620',$row['saka']),0,0,"C");
	
	$pdf->SetX(82);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(55,7,iconv( 'UTF-8','TIS-620',$row['saka']),0,0,"C");

	$pdf->SetX(153);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(47,7,iconv( 'UTF-8','TIS-620',date('d/m/Y', strtotime($row['Req_Date']))),0,0,"C");
	
	if($row['n_insure'] != '')
	{
		$id_data_company = $row['n_insure'];
	}
	else
	{
		$id_data_company = $row['id_data'];
	}
	
	$pdf->SetY(40);
	$pdf->SetX(26);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(41,7,iconv( 'UTF-8','TIS-620',$id_data_company),0,0,"C");
	
	$pdf->SetX(93);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(43,7,iconv( 'UTF-8','TIS-620','09712 / รหัสดีลเลอร์ '.$row['address']),0,0,"C");

	$status_company_time = date('d/m/Y', strtotime($row['Req_Date']));
	$new_SCT = split("[/]",$status_company_time);
	
	$pdf->SetX(155);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(11,7,iconv( 'UTF-8','TIS-620',$new_SCT[0]),0,0,"C");
	$pdf->Cell(19,7,iconv( 'UTF-8','TIS-620',$new_SCT[1]),0,0,"C");
	$pdf->Cell(15,7,iconv( 'UTF-8','TIS-620',$new_SCT[2]),0,0,"C");
	
	$pdf->SetY(46.5);
	$pdf->SetX(13);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(54,7,iconv( 'UTF-8','TIS-620',$row['title'].$row['name'].' '.$row['last']),0,0,"C");
	
	$pdf->SetX(82);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(54,7,iconv( 'UTF-8','TIS-620','-'),0,0,"C");

	$pdf->SetX(158);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(9,7,iconv( 'UTF-8','TIS-620',$new_EDR[0]),0,0,"C");
	$pdf->Cell(18.5,7,iconv( 'UTF-8','TIS-620',$new_EDR[1]),0,0,"C");
	$pdf->Cell(14.5,7,iconv( 'UTF-8','TIS-620',$new_EDR[2]),0,0,"C");
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if($row['EditProduct'] =='Y')
{
	if($row['equit']=='Y' and $row['Product']=='0'  and $row['Product']!='')
	{
		$p=0;
		$i=0;
		$product = "product";
			while ($i<=14)
			{
				if($i==0)
				{
					if($row[$product]!='0')
					{
						if($p<6){$equit0 .= $row[$product]." บาท,  ";$p++;}else if($p<12){$equit1 .= $row[$product]." บาท,  ";$p++;}else if($p<18){$equit2 .= $row[$product]." บาท,  ";$p++;}
					}
				}
				else
				{
					if($row[$product.$i]!='0')
					{
							if($p<6){$equit0 .= $row[$product.$i]." บาท,  ";$p++;}else if($p<12){$equit1 .= $row[$product.$i]." บาท,  ";$p++;}else if($p<18){$equit2 .= $row[$product.$i]." บาท,  ";$p++;}
					}
				}
				$i++;
			}
	}
	else if($row['equit']=='Y' and $row['Product']!='0'  and $row['Product']!='')
	{
		$p=0;
		$i=0;
		$exitNum = explode("|",$row['ReqProduct']);
		$TotalProduct=0;
		$TotalPrice=0;
		for($i=0;$i<count($exitNum);$i++)
		{
			$exitSplit = explode(",",$exitNum[$i]);
			if($costOb['name'][$exitSplit[1]]<=1)
			{
				if($p<6){$equit0 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' 0 บาท ';$p++;}
				else if($p<12){$equit1 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' 0 บาท ';$p++;}
				else if($p<18){$equit2 .=$costObname['name'][$row['cat_car']][$exitSplit[0]].' 0 บาท ';$p++;}
				$TotalProduct+=0;
				$TotalPrice+=$costOb['price'][$exitSplit[1]];
			}
			else
			{
				if($p<6){$equit0 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
				else if($p<12){$equit1 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
				else if($p<18){$equit2 .=$costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
				$TotalProduct+=$costOb['name'][$exitSplit[1]];
				$TotalPrice+=$costOb['price'][$exitSplit[1]];
			}
		}
	}else{
		$equit0 .= "ไม่มี";
		$TotalProduct='0';
		$TotalPrice='0.00';
	}

				
if($row['EditProduct'] =='Y'){
	$p=0;
	$i=0;
	$exitNum = explode("|",$row['ReqProduct']);
	$TotalProduct=0;
	$TotalPrice=0;
	for($i=0;$i<count($exitNum);$i++){
		$exitSplit = explode(",",$exitNum[$i]);
						if($costOb['name'][$exitSplit[1]]<=1)
			{
			if($p<6){$equit0 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' 0 บาท ';$p++;}
				else if($p<12){$equit1 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' 0 บาท ';$p++;}
				else if($p<18){$equit2 .=$costObname['name'][$row['cat_car']][$exitSplit[0]].' 0 บาท ';$p++;}
				$TotalProduct+=0;
				$TotalPrice+=$costOb['price'][$exitSplit[1]];
			}
			else
			{
				if($p<6){$equit0 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
				else if($p<12){$equit1 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
				else if($p<18){$equit2 .=$costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
				$TotalProduct+=$costOb['name'][$exitSplit[1]];
				$TotalPrice+=$costOb['price'][$exitSplit[1]];
			}
	}
}else{
		$equit0 .= "ไม่มี";
		$TotalProduct='0';
		$TotalPrice='0.00';
	}
}else{
	if($row['car_detail']!=0 && $row['car_detail']!='')
	{
	$p=0;
	$i=0;
	$exitNum = explode("|",$row['car_detail']);
	$TotalProduct=0;
	$TotalPrice=0;
	for($i=0;$i<count($exitNum);$i++){
		$exitSplit = explode(",",$exitNum[$i]);
						if($costOb['name'][$exitSplit[1]]<=1)
			{
			if($p<6){$equit0 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' 0 บาท ';$p++;}
				else if($p<12){$equit1 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' 0 บาท ';$p++;}
				else if($p<18){$equit2 .=$costObname['name'][$row['cat_car']][$exitSplit[0]].' 0 บาท ';$p++;}
				$TotalProduct+=0;
				$TotalPrice+=$costOb['price'][$exitSplit[1]];
			}
			else
			{
				if($p<6){$equit0 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
				else if($p<12){$equit1 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
				else if($p<18){$equit2 .=$costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
				$TotalProduct+=$costOb['name'][$exitSplit[1]];
				$TotalPrice+=$costOb['price'][$exitSplit[1]];
			}
	}
	
	$TotalPrice+='0.00';
	}else{
		$equit0 .= "ไม่มี";
		$TotalProduct='0';
		$TotalPrice='0.00';
	}
}
$edit_new = explode(" ",$row['Req_Date']);
$edit_date = explode("-",$edit_new[0]);
$date_new = $edit_new[2]."/".$edit_new[1]."/".$edit_new[0];
$title_n='';
		if($row['EditCancel'] =='Y')
		{
			$edit_req = $date_new;
			$new_EDR = split("[/]",$edit_req);
			$title_n = "ยกเลิกกรมธรรม์ ";
			$detail_1 = $row['Cancel_Detail'];
			$detail_2 = '';
			$detail_3 = '';
		}
		if($row['EditAct'] =='Y')
		{
			$edit_req = $date_new;
			$new_EDR = split("[/]",$edit_req);
			$title_n .= "เลขที่ พรบ. ".$row['EditAct_id'];
		}
		if($row['EditTime'] =='Y')
		{
			$edit_req = $date_new;
			$new_EDR = split("[/]",$edit_req);
			$detail_1 = "วันคุ้มครอง : ".date('d/m/Y', strtotime($row['EditTime_StartDate']));
		}
		if($row['EditHr'] =='Y')
		{
			$edit_req = $date_new;
			$new_EDR = split("[/]",$edit_req);
			$detail_2 = 'ผู้รับผลประโยชน์ : '.$row['EditHr_Detail'];
		}
		if($row['EditCar'] =='Y')
		{
			$edit_req = $date_new;
			$new_EDR = split("[/]",$edit_req);
			$detail_3 = 'เลขตัวถัง '.$row['Edit_CarBody'].' เลขเครื่อง '.$row['Edit_Nmotor'].' สี '.$row['Edit_CarColor'];
		}
		if($row['EditCustomer'] =='Y')
		{
			$edit_req = $date_new;
			$new_EDR = split("[/]",$edit_req);
			$line = "ชื่อผู้เอาประกันภัย : ".$row['Cus_title']." ".$row['Cus_name']." ".$row['Cus_last'];
			$line.= " ที่อยู่ : ".$row['Cus_add']; 
			if($row['Cus_group'] !="-" && $row['Cus_group'] !="")
				{
					$line .=  " หมู่".$row['Cus_group'];
				}
			if($row['Cus_town'] !="-" && $row['Cus_town'] !="")
				{
					$line .= " ".$row['Cus_town'];
				}
			if($row['Cus_lane'] !="-" && $row['Cus_lane'] !="")
				{
					$line .= " ซอย".$row['Cus_lane'];
				}
			if($row['Cus_road'] !="-" && $row['Cus_road'] !="")
				{
					$line .= " ถนน".$row['Cus_road'];
				}
			if($row['Cus_province'] != "102")
				{
					$line .= "ต.".$row1['tumbon']." อ.".$row1['amphur']." จ.".$row1['province']." ".$row['Cus_postal']; 
				}else{
					$line .= "แขวง".$row1['tumbon']."  ".$row1['amphur']." ".$row1['province']." ".$row['Cus_postal'];
				}
			$detail_4 = $line;
		}
		
		if($row['car_cat_acc_total'] != '0.00' && $row['car_cat_acc'] != '')
		{
			if($row['car_cat_acc'] == '220')
			{
				if($row['EditProduct'] =='Y')
				{
					$detail_5 = 'อุปกรณ์ตกแต่งเพิ่มเติม : '.$equit0.' '.$equit1.' '.$equit2;
					$detail_6 = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน '.number_format($row['TotalProduct']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
				}
				else
				{
					$detail_5 = 'อุปกรณ์ตกแต่งเพิ่มเติม : '.$equit0.' '.$equit1.' '.$equit2;
					$detail_6 = 'สลักหลังเปลี่ยนประเภทรถ : (220 รถยนต์โดยสารใช้เพื่อการพาณิชย์) เพิ่มทุน '.number_format($row['price_total']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
				}
			}
			else if($row['car_cat_acc'] == '230')
			{
				if($row['EditProduct'] =='Y')
				{
					$detail_5 = 'อุปกรณ์ตกแต่งเพิ่มเติม : '.$equit0.' '.$equit1.' '.$equit2;
					$detail_6 = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน '.number_format($row['TotalProduct']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
				}
				else
				{
					$detail_5 = 'อุปกรณ์ตกแต่งเพิ่มเติม : '.$equit0.' '.$equit1.' '.$equit2;
					$detail_6 = 'สลักหลังเปลี่ยนประเภทรถ : (230 รถยนต์โดยสารใช้รับจ้างสาธารณะ) เพิ่มทุน '.number_format($row['price_total']).' บาท เพิ่มเบี้ย '.number_format($row['car_cat_acc_total'],2).' บาท';
				}
			}
		}
		else
		{
			if($row['EditProduct'] =='Y')
			{
					$TotalProduct = number_format($row['TotalProduct']);
					$TotalPrice = number_format($row['CostProduct'],2);
					$detail_5 = 'อุปกรณ์ตกแต่งเพิ่มเติม : '.$equit0.' '.$equit1.' '.$equit2;
					$detail_6 = 'รวมทุน '.$TotalProduct.' เพิ่มเบี้ย '.$TotalPrice;				
			}
			else
			{
			//$TotalProduct = number_format($row['TotalProduct']);
			//$TotalPrice = number_format($row['CostProduct'],2);
			$TotalProduct = number_format($row['price_total']);
			$TotalPrice = number_format($row['add_price'],2);
				$detail_5 = 'อุปกรณ์ตกแต่งเพิ่มเติม : '.$equit0.' '.$equit1.' '.$equit2;
				$detail_6 = 'รวมทุน '.$TotalProduct.' เพิ่มเบี้ย '.$TotalPrice;	
			}
		}
		
		

	$pdf->SetY(158);
	$pdf->SetX(16);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(15,7,iconv( 'UTF-8','TIS-620','1'),0,0,"C");
	
	$pdf->SetX(55);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,7,iconv( 'UTF-8','TIS-620',$title_n),0,0,"L");
	
	// รายละเอียดบรรทัดที่ 1
	$pdf->SetY(165);
	$pdf->SetX(33);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,7,iconv( 'UTF-8','TIS-620',$detail_1),0,0,"L");
	
	// รายละเอียดบรรทัดที่ 2
	$pdf->SetY(171);
	$pdf->SetX(33);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,7,iconv( 'UTF-8','TIS-620',$detail_2),0,0,"L");
	
	// เหตุผล
	$pdf->SetY(177);
	$pdf->SetX(33);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,7,iconv( 'UTF-8','TIS-620',$detail_3),0,0,"L");
	
	// ถ้ามี การแก้ไขทั้งสองอย่าง  
	$pdf->SetY(191);
	$pdf->SetX(16);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(15,7,iconv( 'UTF-8','TIS-620',$num_req),0,0,"C");
	
	$pdf->SetX(55);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,7,iconv( 'UTF-8','TIS-620',$title_n2),0,0,"L");
	
	// รายละเอียดบรรทัดที่ 1
	$pdf->SetY(198);
	$pdf->SetX(33);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,7,iconv( 'UTF-8','TIS-620',$detail_4),0,0,"L");
	
	// รายละเอียดบรรทัดที่ 2
	$pdf->SetY(206);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',10);
	$pdf->MultiCell(150,3.2,iconv( 'UTF-8','TIS-620',$detail_5),0,"L");
	
	// เหตุผล
	$pdf->SetY(204);
	$pdf->SetX(33);
	$pdf->SetFont('angsa','',10);
	$pdf->Cell(0,7,iconv( 'UTF-8','TIS-620',$detail_6),0,0,"R");
	
	// รายละเอียดบรรทัดที่ 3 addon
	if($row['code_addon'] !='')
{
$i=0;
$exitANum = explode(",",$row['code_addon']);
$exitSelect = explode(",",$row['code_addon_id']);
$costAD =  0;
$addonView = '';
    for($i=0;$i<count($exitANum);$i++){
            $exitADDON = explode(",",$exitANum[$i]);
            $sqlAddon = "select * from tb_addon where id = '".$exitSelect[$i]."'";
            $sqlRes = mysql_query($sqlAddon);
            $sqlArr = mysql_fetch_array($sqlRes);
            $addonView  =  $addonView.' '.$sqlArr['name_addon'].' '.$sqlArr['id_add'].'  เบี้ยเพิ่ม '.$sqlArr['cost_insuran'].'  บาท ';
            $costAD=$costAD+$sqlArr['cost_insuran'];
    }
}
else
{
	if($row['EditAddon']=='Y')
			{
				$addonView = "ยกเลิกโจรกรรม";
				$costAD = 0;
			}
			else
			{
				$addonView = "ไม่มี";
				$costAD = 0;
			}
	
}
	$pdf->SetY(210);
	$pdf->SetX(18);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,7,iconv( 'UTF-8','TIS-620','Add On : '.$addonView),0,0,"L");
	// เหตุผล addon
	$pdf->SetY(210);
	$pdf->SetX(33);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,7,iconv( 'UTF-8','TIS-620','เพิ่มเบี้ย '.number_format($costAD,2)),0,0,"R");
	
	// เหตุผล
	$pdf->SetY(246);
	$pdf->SetX(35);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(45,7,iconv( 'UTF-8','TIS-620','บริษัท โฟร์ อินชัวรันส์ โบรกเกอร์ จำกัด'),0,0,"C");
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	////////สลักหลังพรบ/////////////////////////////////////
	
	$pdf->AddPage();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');	
	
	$pdf->Image("../images/act_req.png",0,0,210,0);
	
	// HEAD
	$pdf->SetY(35);
	$pdf->SetX(21);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(50,7,iconv( 'UTF-8','TIS-620',$row['saka']),0,0,"C");
	
	$pdf->SetX(86);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(33,7,iconv( 'UTF-8','TIS-620',$row['saka']),0,0,"C");

	$pdf->SetX(132);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(32,7,iconv( 'UTF-8','TIS-620',$date_new),0,0,"C");
	
	$pdf->SetY(41);
	$pdf->SetX(34);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(50,7,iconv( 'UTF-8','TIS-620',$row['p_act']),0,0,"C");
	
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',11);
	$pdf->Cell(20,7,iconv( 'UTF-8','TIS-620','09712 / '.$row['address']),0,0,"C");
	
	$pdf->SetX(145);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(50,7,iconv( 'UTF-8','TIS-620',$row['id_data']),0,0,"C");
	
	$pdf->SetY(47);
	$pdf->SetX(17);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(67,7,iconv( 'UTF-8','TIS-620',$row['title'].$row['name'].' '.$row['last']),0,0,"C");
	
	$pdf->SetX(97);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(31,7,iconv( 'UTF-8','TIS-620','-'),0,0,"C");
	$title_n='';
	if($row['EditCancel'] =='Y')
	{
		$pdf->Image("../images/1.jpg",109,66,4,0);
		$edit_req = $date_new;
		$new_EDR = split("[/]",$edit_req);
		$title_n = "ยกเลิกกรมธรรม์ ";
		$detail_1 = $row['Cancel_Detail'];
		$detail_2 = '';
		$detail_3 = '';
	}
	if($row['EditAct'] =='Y')
	{
		$edit_req = $date_new;
		$new_EDR = split("[/]",$edit_req);
		$title_n .= "เลขที่ พรบ. ".$row['EditAct_id'];
	}
	if($row['EditTime'] =='Y')
	{
		$pdf->Image("../images/1.jpg",13,86.5,4,0);
		$edit_req = $date_new;
		$new_EDR = split("[/]",$edit_req);
		$detail_1 = "วันคุ้มครอง : ".date('d/m/Y', strtotime($row['EditTime_StartDate']));
	}
	if($row['EditHr'] =='Y')
	{
		$edit_req = $date_new;
		$new_EDR = split("[/]",$edit_req);
		$detail_2 = 'ผู้รับผลประโยชน์ : '.$row['EditHr_Detail'];
	}
	if($row['EditCar'] =='Y')
	{
		$pdf->Image("../images/1.jpg",13,80,4,0);
		$edit_req = $date_new;
		$new_EDR = split("[/]",$edit_req);
		$detail_3 = 'เลขตัวถัง '.$row['Edit_CarBody'].' เลขเครื่อง '.$row['Edit_Nmotor'].' สี '.$row['Edit_CarColor'];
	}
	if($row['EditCustomer'] =='Y')
	{
		$pdf->Image("../images/1.jpg",13,66,4,0);
		$pdf->Image("../images/1.jpg",13,72.5,4,0);
		$edit_req = $date_new;
		$new_EDR = split("[/]",$edit_req);
		$line = "ชื่อผู้เอาประกันภัย : ".$row['Cus_title']." ".$row['Cus_name']." ".$row['Cus_last'];
		$line2= "ที่อยู่ : ".$row['Cus_add']; 
		if($row['Cus_group'] !="-" && $row['Cus_group'] !="")
		{
			$line2 .=  " หมู่".$row['Cus_group'];
		}
		if($row['Cus_town'] !="-" && $row['Cus_town'] !="")
		{
			$line2 .= " ".$row['Cus_town'];
		}
		if($row['Cus_lane'] !="-" && $row['Cus_lane'] !="")
		{
			$line2 .= " ซอย".$row['Cus_lane'];
		}
		if($row['Cus_road'] !="-" && $row['Cus_road'] !="")
		{
			$line2 .= " ถนน".$row['Cus_road'];
		}
		if($row['Cus_province'] != "102")
		{
			$line3 = "ต.".$row1['tumbon']." อ.".$row1['amphur']." จ.".$row1['province']." ".$row['Cus_postal']; 
		}
		else
		{
			$line3 .= "แขวง".$row1['tumbon']." ".$row1['amphur']." ".$row1['province']." ".$row['Cus_postal'];
		}
		$detail_4 = $line;
		$detail_5 = $line2;
		$detail_6 = $line3;
	}
	
	$pdf->SetY(115);
	$pdf->SetX(105);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(95,7,iconv( 'UTF-8','TIS-620',$title_n),0,0,"L");
	
	// รายละเอียดบรรทัดที่ 1
	$pdf->SetY(122);
	$pdf->SetX(105);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(95,7,iconv( 'UTF-8','TIS-620',$detail_1),0,0,"L");
	
	// รายละเอียดบรรทัดที่ 2
	$pdf->SetY(129);
	$pdf->SetX(105);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(95,7,iconv( 'UTF-8','TIS-620',$detail_2),0,0,"L");
	
	// เหตุผล
	$pdf->SetY(136);
	$pdf->SetX(105);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(95,7,iconv( 'UTF-8','TIS-620',$detail_3),0,0,"L");
	
	// รายละเอียดบรรทัดที่ 1
	$pdf->SetY(143);
	$pdf->SetX(105);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(95,7,iconv( 'UTF-8','TIS-620',$detail_4),0,0,"L");
	
	// รายละเอียดบรรทัดที่ 2
	$pdf->SetY(150);
	$pdf->SetX(105);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(95,7,iconv( 'UTF-8','TIS-620',$detail_5),0,0,"L");
	
	// เหตุผล
	$pdf->SetY(157);
	$pdf->SetX(105);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(95,7,iconv( 'UTF-8','TIS-620',$detail_6),0,0,"L");
	
	// เหตุผล
	$pdf->SetY(282);
	$pdf->SetX(25);
	$pdf->SetFont('angsa','',13);
	$pdf->Cell(57,7,iconv( 'UTF-8','TIS-620','บริษัท โฟร์ อินชัวรันส์ โบรกเกอร์ จำกัด'),0,0,"C");
	
	
	
	$pdf->Output("../email/tmp/".$row['title']."".$row['namecus']." ".$row['last'].".pdf","F");

	$mail2 = new PHPMailer();  // กำหนดตัวแปร  $mail
	$mail2->CharSet = 'UTF-8';                                                                
    $mail2->From = "admin@my4ib.com";
    $mail2->FromName = "แจ้งประกันภัยออนไลน์"; // กำหนดชื่อผู้ส่ง
    $mail2->IsSMTP();
    $mail2->SMTPDebug = 0;
    $mail2->SMTPAuth = true;
   //เก่า
    //$mail2->Host = _MAIL_MY4IB ; // "localhost"; // SMTP servermail.my4ib.com
    //$mail2->Port = 25; // พอร์ท
    //$mail2->Username = "prakunpai@my4ib.com"; // account SMTP
    //$mail2->Password = "pra12641"; // รหัสผ่าน SMTP
	
	
	//ใหม่
	$mail2->Host = _SMTP_MY4IB_TLS; // "localhost"; // SMTP servermail.my4ib.com
    $mail2->Port = _SMTP_MY4IB_POST; // พอร์ท
    $mail2->Username = _SMTP_MY4IB_USERNAME_ADMIN; // account SMTP
    $mail2->Password = _SMTP_MY4IB_PASSWORD_ADMIN; // รหัสผ่าน SMTP
	//TT//////////TT/////////
	if($row['saka'] == '113')
	{
		if($row['Email1']!="" && $row['Email1']){ //Mail Four

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email1']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail2->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email2']!="" && $row['Email2']){ //Mail CEO

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email2']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail2->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email4']!="" && $row['Email4']){ //Mail Dealer

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email4']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail2->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email5']!="" && $row['Email5']){ //Mail Dealer

			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email5']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail2->AddAddress($pieces[$j], "");
			 }
			//$mail->AddAddress($row['Email'], "");
		}
		if($row['Email8']!=""){ //Mail วิริยะ
			 $pieces=''; $np=0;
			 $pieces = explode(",", $row['Email8']);
			 $np = count($pieces);
			 for($j=0;$j<$np;$j++){
			 	$mail2->AddAddress($pieces[$j], "");
			 }			
			//$mail->AddAddress($row['Email8'], "");
			}
	//$mail2->AddAddress('tararatt@viriyah.co.th', "");
	//$mail2->AddAddress('suchonneeb@viriyah.co.th', "");
	}
		
	// $mail2->AddAddress('piyaphon@my4ib.com', "");
	// $mail2->AddAddress('wanvisa_k@my4ib.com', "");
	$mail2->AddAddress('policy@my4ib.com', "");
	//$mail2->AddAddress('tararatt@viriyah.co.th', "");
	//$mail2->AddAddress('suchonneeb@viriyah.co.th', "");
	//$mail2->AddAddress('wisaruth@my4ib.com', "");
	if($row['saka'] == '113')
	{
	$mail2->AddAddress('atikarnp@viriyah.co.th', "");
	$mail2->AddAddress('piyanartb@viriyah.co.th', "");
	}
	//$mail2->AddAddress('info_support@my4ib.com', "");

if(!empty($txtCC)){
			$pieces=''; $np=0;
            $pieces = explode(",", $txtCC);
            $np = count($pieces);
            for($j=0;$j<$np;$j++){
               $exccb='';
                $exccb = explode('@',$pieces[$j]);
                if($exccb[1]!=''){
                    $mail2->AddCC($pieces[$j], "");
                }
            }
}
//TT//////////TT/////////

    $mail2->Subject = "สลักหลังอุปกรณ์ตกแต่ง ".$row['car_brand']." ".$nameCar." เลขรับแจ้ง ".$row['id_data']; // กำหนดหัวข้ออีเมล์
    $mail2->Body = "วิริยะประกันภัย เลขที่รับแจ้ง ".$row['id_data']." ".$row['title']."".$row['namecus']." ".$row['last']." คุ้มครอง : ". date('d/m',strtotime($row['start_date'])).'/'.$startYear."-".date('d/m',strtotime($row['end_date'])).'/'.$endYear." แจ้งอุบัติเหตุ 24 ชม. ทั่วประเทศ เบอร์สายด่วน 1557"; // กำหนดเนื้อหาอีเมล์
    $mail2->AddAttachment("../email/tmp/".$row['title']."".$row['namecus']." ".$row['last'].".pdf");
    $mail2->IsHTML(false); 
    // $mail2->Send();
        if($mail2->Send()){
    		$sendm=$sendm+1;
    	}
	unlink("../email/tmp/".$row['title']."".$row['namecus']." ".$row['last'].".pdf");
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($row['Req_Status'] != 'Y')
	{
		if($row['unit_edit'] == '0')
		{
		//post@sicc และ password มีปัญหา
		//$ACCOUNT="post@sicc";
		//$PASSWORD="F22DF40C24B2EEE4F6BF029EEEA5EC382981F5558DA0E8EBEC27EE8F1A9E992B";
		$ACCOUNT="post@fourinsura";
		$PASSWORD="C699D09939D5BBF231EF67D073E3373C170F03D33C74FC1495F2B42744CE324E"; //"C699D09939D5BBF231EF67D073E3373C9C5A971CBEBCC45575CDB52CF9C3AEE4";
		$MOBILE= str_replace('-','',$row['tel_mobi']);
		$smstext = "วิริยะประกันภัย เลขที่รับแจ้ง ".$row['id_data']." ". $row['title']."".$row['namecus']." ".$row['last']." คุ้มครอง : ". date('d/m',strtotime($row['start_date'])).'/'.$startYear."-".date('d/m',strtotime($row['end_date'])).'/'.$endYear." แจ้งอุบัติเหตุ 24 ชม. ทั่วประเทศ เบอร์ 1557";
		$MESSAGE= iconv('UTF-8','TIS-620',$smstext);
		$LANGUAGE = "T";
		$ch = curl_init("https://sc4msg.com/bulksms/SendMessage");  //curl_init("https://203.146.102.26/smartcomm2/SendMessage");      
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,"ACCOUNT=$ACCOUNT&PASSWORD=$PASSWORD&MOBILE=$MOBILE&MESSAGE=$MESSAGE&LANGUAGE=T");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$data = curl_exec($ch);
		}
	}
	
	if($sendm>0)
	{ 
	// update status email
	$strSQL = "UPDATE data SET Status_Email = 'T'  WHERE id_data = '".$row['id_data']."'";
	$objQuery = mysql_query($strSQL);
	////////////////////////////////////////////////////////////
	
	//begin sing
	@mysql_query("SET SQL_SAFE_UPDATES = 0;");
	@mysql_query("DELETE FROM __report_individuals WHERE id_data_send LIKE '%".$row['id_data']."%';");
	@mysql_query("SET SQL_SAFE_UPDATES = 1;");
	@mysql_query("call created_individuals()");
	//end sing
	

		$returnedArray['idperson'] = $row['person'];
		$returnedArray['status'] = true;
		$returnedArray['msg'] = "ส่งอีเมล์สำเร็จ! : ".$row['id_data'];
	}
	else
	{
		$returnedArray['idperson'] = $row['person'];
		$returnedArray['status'] = false;
		$returnedArray['msg'] = "ส่งอีเมล์ผิดพลาด !!!!!!!"._MAIL_MY4IB;
	}	
	echo json_encode($returnedArray);

mysql_close();
?>