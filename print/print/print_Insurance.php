<?php
include('../fpdf.php');
include "../../inc/connectdbs.pdo.php";
$IDDATA = '11449';
$query = "SELECT ";
$query .= "data.id,";
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
$query .= "act.p_act, "; // เลขที่กรมธรรม์ พ.ร.บ.
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
$query .= "insuree.email, "; // แยกใบเสร็จ
$query .= "insuree.tel_mobi, "; // แยกใบเสร็จ

$query .= "tb_tumbon.name as tumbon_name, "; 
$query .= "tb_amphur.name as amphur_name, "; 
$query .= "tb_province.name as province_name, "; // จังหวัด

$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
$query .= "detail.mo_car, "; // ยี่ห้อรถ
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

$query .= "data.updated, "; // สลักหลัง
$query .= "protect.costCost,"; // ทุนประกันภัย
$query .= "data.send_req, "; // สลักหลัง
$query .= "data.send_req2, "; // สลักหลัง

$query .= "tb_cost.cost, ";
$query .= "tb_cost.pre, ";
$query .= "tb_cost.stamp, ";
$query .= "tb_cost.tax, ";
$query .= "tb_cost.net, ";


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
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
$query .= "INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
$query .= "INNER JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
$query .= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
$query .= "INNER JOIN act ON (act.id_data = data.id_data)  ";
$query .= "INNER JOIN tb_cost ON (tb_cost.id = protect.costCost) ";
$query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
$query .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
$query .= "INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
$query .= "INNER JOIN tb_province ON (tb_province.id = insuree.province) ";
$query .= "INNER JOIN tb_customer ON (tb_customer.user = data.login) ";

$query .= "WHERE data.id='$IDDATA'";

$objQuery = mysql_query($query) or die ("Error Query [".$query."]");

$row = mysql_fetch_array($objQuery);

$car_id = $row['car_id'];
$arr_car_id = str_split($car_id);
$id_data_rec = $row['id_data'];

if($row['group'] !="-" && $row['group'] !="")
{
	$address_pdf = " หมู่".$row['group'];
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
	$address_pdf2 = 'ต.'.$row['tumbon_name'].' อ.'.$row['amphur_name'].' จ.'.$row['province_name'];
}
else{
	$address_pdf2 = 'แขวง'.$row['tumbon_name'].' เขต'.$row['amphur_name'].' '.$row['province_name'];
}

	define('FPDF_FONTPATH','font/');

	$pdf=new FPDF();
	$pdf->AddPage();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');
	$pdf->Image('../images/logo.gif',10,3,80);
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
		$str_addressComp = 'ที่อยู่ 357,359,361 ถ.รามคำแหง แขวงสะพานสูง เขตสะพานสูง กทม. 10240';
		$str_NameComp = 'สุขาภิบาล 3';
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
	$pdf->SetFont('angsa','',12);
	$pdf->SetY(40);
	$pdf->Cell(0,33,iconv('UTF-8','TIS-620','                             ที่อยู่  '),0);
	$pdf->SetY(40);
	$pdf->SetX(37);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,33,iconv('UTF-8','TIS-620',$row['add'].' '.$address_pdf),0);
	$pdf->SetY(74);
	$pdf->SetX(37);
	$pdf->Cell(0,-25,iconv('UTF-8','TIS-620',$address_pdf2.' '.$row['postal']),0);
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
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620',date("d/m/Y",strtotime($row['start_date']))),0);
	$pdf->SetFont('angsa','',12);
	$pdf->SetX(85);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','สิ้นสุดวันที่ '),0);
	$pdf->SetFont('angsa','B',12);
	$pdf->SetX(110);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620',date("d/m/Y",strtotime($row['end_date']))),0);
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
	$pdf->Cell(12,12,iconv('UTF-8','TIS-620',$row['car_id']),1,0,"C");
	$pdf->SetX(31);
	$pdf->Cell(40,12,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->SetX(31);
	$pdf->Cell(40,6,iconv('UTF-8','TIS-620',$row['car_brand']),0,0,"C");
	$pdf->SetY(106);
	$pdf->SetX(31);
	$pdf->Cell(40,6,iconv('UTF-8','TIS-620',$row['mo_car_name'].' ('.$row['gear'].')'),0,0,"C");
	$pdf->SetY(101);
	$pdf->SetX(71);
	$pdf->Cell(20,12,iconv('UTF-8','TIS-620',$row['car_regis']),1,0,"C");
	$pdf->SetX(91);
	$pdf->Cell(40,12,iconv('UTF-8','TIS-620',$row['car_body']),1,0,"C");
	$pdf->SetX(131);
	$pdf->Cell(20,12,iconv('UTF-8','TIS-620',$row['regis_date']),1,0,"C");
	$pdf->SetX(151);
	$pdf->Cell(30,12,iconv('UTF-8','TIS-620',$row['n_motor']),1,0,"C");
	$pdf->SetX(181);
	if($row['mo_car'] == "759" || $row['mo_car'] == "747")
			{
				$scw = "7 / 1600 / 3";
			}
			else if($row['mo_car'] == "1098")
			{
				$scw = "3 / 1600 / 3";
			}
			else if($row['mo_car'] == "1951")
			{
				$scw = "7 / 1200 / 3";
			}
			else if($row['mo_car'] == "754")
			{
				$scw = "7 / 2000 / 3";
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
			else
			{
				$payp = "1,000,000";
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
	$pdf->SetX(10);
	$pdf->Cell(45,54,iconv('UTF-8','TIS-620','-'),0,0,"R");
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
	$pdf->Cell(40,54,iconv('UTF-8','TIS-620',substr($row['cost'],0,7)),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->Cell(55,54,iconv('UTF-8','TIS-620','     1.1 ความเสียหายส่วนแรก'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->Cell(55,54,iconv('UTF-8','TIS-620','2) รถยนต์สูญหาย/ไฟไหม้'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(40,54,iconv('UTF-8','TIS-620','-'),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(40,54,iconv('UTF-8','TIS-620',substr($row['cost'],0,7)),0,0,"R");
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
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620','200,000'),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(2,54,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,54,iconv('UTF-8','TIS-620','บาท'),0,0,"L");
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
				$strOption = "14";
			}
	$pdf->Ln(6);
	$pdf->SetX(125);	
	$pdf->Cell(75,54,iconv('UTF-8','TIS-620','     ข) ผู้โดยสาร '.$strOption.' คน'),0,0,"L");
	$pdf->SetX(125);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620','200,000'),0,0,"R");
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
			}
			else
			{
				$strOption = "50,000";
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
	$pdf->Cell(60,54,iconv('UTF-8','TIS-620',$strOption),0,0,"R");
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
	$pdf->SetFont('angsa','B',18);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620',$row['pre']),1,0,"C");
	$pdf->SetX(70);
	$pdf->Cell(45,6,iconv('UTF-8','TIS-620',$row['stamp']),1,0,"C");
	$pdf->SetX(115);
	$pdf->Cell(35,6,iconv('UTF-8','TIS-620',number_format($row['tax'])),1,0,"C");
	$pdf->SetX(150);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',$row['net']),1,0,"C");
	
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
	
	$i = 0;
	$p = 0;
	$equit = '';
	 if($row['equit'] =="Y")
			  	{ 
	while($i<14){
		if($i==0){
			$codePRODUCT = "product";
		}
		else{
			$codePRODUCT = "product".$i;
		}
		
		if($row[$codePRODUCT] !='0')
		
				{
					if($p<6){$equit0 .= $row[$codePRODUCT]."  บาท,  ";$p++;}else if($p<12){$equit1.= $row[$codePRODUCT]."  บาท,  ";$p++;}else if($p<18){$equit2.= $row[$codePRODUCT]."  บาท,  ";$p++;}
					
				}
				
				$i++;
		}
				}
	
			
	
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetY(213);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620','อุปกรณ์ตกแต่งเพิ่มเติม : '),0,0,"L");
	$pdf->SetX(31);
	$pdf->SetFont('angsa','B',9);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$equit0),0,0,"L");
	$pdf->SetY(217);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$equit1),0,0,"L");
	$pdf->SetY(221);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$equit2),0,0,"L");
	$pdf->SetY(224);
	$pdf->SetFont('angsa','B',11);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620','เพิ่มทุนอุปกรณ์รวม '.number_format($row['price_total']).' บาท'.'เพิ่มเบี้ยรวม '.number_format($row['add_price'],2)."  บาท"),0,0,"R");
	$pdf->Ln(10);
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetY(229);
	$pdf->SetX(10);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620','สลักหลัง :'),0,0,"L");
	$pdf->SetX(20);
	$pdf->SetFont('angsa','B',9);
	$P_req = 0;
	if($row['send_req']!=''){
		$line1 = $row['send_req'];
		$P_req++;
	}
	if($row['send_req2']!=''){
		if($P_req==1){
		$line2 = $row['send_req2'];
		$P_req++;
		}
		else{
			$line1 = $row['send_req2'];
			$P_req++;
		}
	}
	if($row['send_cancel']!=''){
		if($P_req==1){
		$line2 = $row['send_cancel'];
		$P_req++;
		}
		else if($P_req==2){
			$line3 = $row['send_cancel'];
			$P_req++;
		}
		else{
		$line1 = $row['send_cancel'];
		}
	}
	
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$line1),0,0,"L");
	$pdf->SetY(233);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$line2),0,0,"L");
	$pdf->SetY(237);
	$pdf->Cell(0,16,iconv('UTF-8','TIS-620',$line3),0,0,"L");
	
	$pdf->Ln(13);
	$pdf->SetFont('angsa','',12);
	$pdf->Image('../images/2.jpg',15,251,4);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
	$pdf->SetX(50);
	$pdf->Image('../images/1.jpg',55,251,4);
	$pdf->SetX(60);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
	$pdf->SetFont('angsa','B',12);
	$pdf->SetX(100);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','บจ.โฟร์ อินชัวร์ โบรกเกอร์'),0,0,"L");
	$pdf->SetFont('angsa','',12);
	$pdf->SetX(120);
	$pdf->Cell(80,6,iconv('UTF-8','TIS-620','ใบอนุญาตเลขที่ ว00018/2551'),0,0,"R");
	$pdf->Ln(6);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','วันทำสัญญาประกันภัย'),0,0,"L");
	$pdf->SetX(50);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',date("d/m/Y",strtotime($row['start_date']))),0,0,"C");
	$pdf->SetX(100);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','วันทำกรมธรรม์'),0,0,"L");
	$pdf->SetX(150);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',date("d/m/Y",strtotime($row['start_date']))),0,0,"C");
	$pdf->Ln(6);
	
	$pdf->SetY(272);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,4,iconv('UTF-8','TIS-620','เอกสารฉบับนี้เป็นเพียงข้อเสนอประกันภัยรถยนต์เท่านั้นส่วนเงื่อนไขความคุ้มครอง ข้อยกเว้น ตามที่กำหนด ระบุอยู่ในกรมธรรม์ประกันภัยรถยนต์'),0,0,"L");
	$pdf->Output();
	//echo $query;
	mysql_close(); 
?>