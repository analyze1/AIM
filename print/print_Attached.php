<?php
include "../pages/check-ses.php"; 
include('../fpdf.php');
include "../../inc/connectdbs.pdo.php";
$IDDATA = base64_decode($_GET['IDDATA']);
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
	$address_pdf2 = 'แขวง'.$row['tumbon_name'].' เขต'.$row['amphur_name'].' จ.'.$row['province_name'];
}

	define('FPDF_FONTPATH','font/');

	$pdf=new FPDF();
	$pdf->AddPage();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');
	$pdf->Image('../images/logo.gif',65,3,80);
	$pdf->SetTextColor(255,0,0);
	$pdf->Ln(13);
	$pdf->SetFont('angsa','B',16);
	$pdf->Cell(150,5,iconv( 'UTF-8','TIS-620','แจ้งอุบัติเหตุ 24 ชั่วโมง '),0,0,"R");
	$pdf->SetFont('angsa','B',30);
	$pdf->Cell(15,4,iconv( 'UTF-8','TIS-620','1557'),0,0,"R");
	$pdf->SetFont('angsa','B',16);
	$pdf->Cell(20,5,iconv( 'UTF-8','TIS-620',' ทั่วประเทศ'),0,0,"R");
	$pdf->Ln(5);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,10,iconv( 'UTF-8','TIS-620','สุขาภิบาล 3          '.$row['title_sub'].$row['sub'].'('.$row['login'].')'),0,1,"L");
	$pdf->SetFont('angsa','',9);
	$pdf->Cell(0,-10,iconv( 'UTF-8','TIS-620','เลขที่กรมธรรม์ พ.ร.บ.: '.$row['p_act']),0,1,"R");
	$pdf->Ln(10);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','เลขที่รับแจ้ง : '.$row['id_data']),0,1,"L");
	$pdf->Ln(3);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ที่อยู่ 357,359,361 ถ.รามคำแหง แขวงสะพานสูง เขตสะพานสูง กทม. 10240'),0,1,"C");
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','เลขที่ประจำตัวผู้เสียภาษี 0105490000219'),0,1,"R");
	$pdf->Ln(5);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','Tel. 02-1968234 Fax. 02-196-8235'),0,1,"C");
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ทะเบียนการค้าเลขที่ 0105490000219'),0,1,"R");
	$pdf->Ln(5);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','รหัสบริษัท VIB                                                                                        ใบคำขอประกันภัยรถยนต์                     อาณาเขตคุ้มครอง ประเทศไทย'),1);
	$pdf->Ln();
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','ใบคำขอเลขที่'),1);
	$pdf->SetX(40);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['id_data']),0);
	$pdf->Ln();
	$pdf->Cell(0,16,'',1);
	$pdf->Ln();
	$pdf->Cell(0,-25,iconv('UTF-8','TIS-620','ผู้เอาประกันภัย     ชื่อ    '.$row['title'].' '.$row['name'].' '.$row['last']),0);
	$pdf->Ln();
	$pdf->Cell(0,33,iconv('UTF-8','TIS-620','                             ที่อยู่  '.$row['add'].' '.$address_pdf),0);
	$pdf->Ln();
	$pdf->Cell(0,-25,iconv('UTF-8','TIS-620','                                      '.$address_pdf2.' '.$row['postal']),0);
	$pdf->Ln(-8);
	$pdf->Cell(0,13,'',1);
	$pdf->Ln();
	$pdf->Cell(0,-19,iconv('UTF-8','TIS-620','ผู้ขับขี่ 1 '.$row['title_num1'].$row['name_num1'].$row['last_num1'].' วัน/เดือน/ปีเกิด'.$row['birth_num1']),0);
	$pdf->Ln();
	$pdf->Cell(0,31,iconv('UTF-8','TIS-620','ผู้ขับขี่ 2 '.$row['title_num2'].$row['name_num2'].$row['last_num2'].' วัน/เดือน/ปีเกิด'.$row['birth_num2']),0);
	$pdf->Ln(19);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','ผู้รับผลประโยชน์           '.$row['name_gain']),1);
	$pdf->Ln(6);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','ระยะเวลาประกันภัย : เริ่มต้นวันที่ '.date("d/m/Y",strtotime($row['start_date'])).'     สิ้นสุดวันที่ '.date("d/m/Y",strtotime($row['end_date'])).'          เวลา 16.30 น.'),1);
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
	$pdf->SetY(114);
	$pdf->MultiCell(9,12,iconv('UTF-8','TIS-620',' '),1,"C");
	$pdf->Ln(-12);
	$pdf->SetX(19);
	$pdf->Cell(12,12,iconv('UTF-8','TIS-620',$row['car_id']),1,0,"C");
	$pdf->SetX(31);
	$pdf->Cell(40,12,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->SetX(31);
	$pdf->Cell(40,6,iconv('UTF-8','TIS-620',$row['car_brand']),0,0,"C");
	$pdf->SetY(119);
	$pdf->SetX(31);
	$pdf->Cell(40,6,iconv('UTF-8','TIS-620',$row['mo_car_name'].' ('.$row['gear'].')'),0,0,"C");
	$pdf->SetY(114);
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
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','จำนวนเงินเอาประกันภัย : กรมธรรม์ประกันภัยนี้ให้การคุ้มครองเฉพาะข้อตกลงคุ้มครองที่มีจำนวนเงินเอาประกันภัยระบุไว้เท่านั้น'),1);
	$pdf->Ln(6);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','ความรับผิดชอบต่อบุคคลภายนอก'),1,0,"C");
	$pdf->Cell(55,6,iconv('UTF-8','TIS-620','รถยนต์เสียหาย สูญหาย ไฟไหม้'),1,0,"C");
	$pdf->Cell(75,6,iconv('UTF-8','TIS-620','ความคุ้มครองตามเอกสารแนบท้าย'),1,0,"C");
	$pdf->Ln(6);
	$pdf->Cell(60,66,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->Ln(-29);
	$pdf->Cell(60,66,iconv('UTF-8','TIS-620','1) ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย'),0,0,"L");
	$pdf->Ln(6);

	$pdf->Cell(60,66,iconv('UTF-8','TIS-620','     เฉพาะส่วนเกินวงเงินสูงสุดตาม พ.ร.บ.'),0,0,"L");
	$pdf->Ln(6);
	if($row['car_id'] == "110")
			{
				$payp = "1,000,000";
			}
			else
			{
				$payp = "300,000";
			}
	$pdf->Cell(45,66,iconv('UTF-8','TIS-620',$payp),0,0,"R");
	$pdf->Cell(2,66,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,66,iconv('UTF-8','TIS-620','บาท/คน'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->Cell(45,66,iconv('UTF-8','TIS-620','10,000,000'),0,0,"R");
	$pdf->Cell(2,66,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,66,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->Cell(60,66,iconv('UTF-8','TIS-620','2) ความเสียหายต่อทรัพย์สิน'),0,0,"L");
	
	
	if($row['car_id'] == "110")
			{
				$payp = "5,000,000";
			}
			else
			{
				$payp = "1,000,000";
			}
	$pdf->Ln(6);
	$pdf->Cell(45,66,iconv('UTF-8','TIS-620',$payp),0,0,"R");
	$pdf->Cell(2,66,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,66,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->Cell(60,66,iconv('UTF-8','TIS-620','     2.1 ความเสียหายส่วนแรก'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->Cell(45,66,iconv('UTF-8','TIS-620','-'),0,0,"R");
	$pdf->Cell(2,66,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,66,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->Ln(-13);
	$pdf->SetX(70);
	$pdf->Cell(55,66,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->Ln(-29);
	$pdf->SetX(70);
	$pdf->Cell(55,66,iconv('UTF-8','TIS-620','1) ความเสียหายต่อรถยนต์'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->Cell(40,66,iconv('UTF-8','TIS-620',substr($row['cost'],0,7)),0,0,"R");
	$pdf->Cell(2,66,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,66,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->Cell(55,66,iconv('UTF-8','TIS-620','     1.1 ความเสียหายส่วนแรก'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->Cell(55,66,iconv('UTF-8','TIS-620','2) รถยนต์สูญหาย/ไฟไหม้'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->Cell(40,66,iconv('UTF-8','TIS-620','-'),0,0,"R");
	$pdf->Cell(2,66,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,66,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->Cell(40,66,iconv('UTF-8','TIS-620',substr($row['cost'],0,7)),0,0,"R");
	$pdf->Cell(2,66,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,66,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	
	$pdf->SetFont('angsa','',31);
	$pdf->Ln(18);
	$pdf->SetX(70);
	$pdf->Cell(55,66,iconv('UTF-8','TIS-620','ไม่รวม พ.ร.บ.'),0,0,"C");
	$pdf->Ln(-19);
	$pdf->SetX(125);
	$pdf->SetFont('angsa','',12);

	$pdf->Cell(75,66,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->Ln(-29);
	$pdf->SetX(125);
	$pdf->Cell(75,66,iconv('UTF-8','TIS-620','1) อุบัติเหตุส่วนบุคคล'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,66,iconv('UTF-8','TIS-620','     1.1 เสียชิวิต สูญเสียอวัยวะ ทุพพลภาพถาวร'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,66,iconv('UTF-8','TIS-620','     ก) ผู้ขับขี่ 1 คน'),0,0,"L");
	$pdf->SetX(125);
	$pdf->Cell(60,66,iconv('UTF-8','TIS-620','200,000'),0,0,"R");
	$pdf->Cell(2,66,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,66,iconv('UTF-8','TIS-620','บาท'),0,0,"L");
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
	$pdf->Cell(75,66,iconv('UTF-8','TIS-620','     ข) ผู้โดยสาร '.$strOption.' คน'),0,0,"L");
	$pdf->SetX(125);
	$pdf->Cell(60,66,iconv('UTF-8','TIS-620','200,000'),0,0,"R");
	$pdf->Cell(2,66,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,66,iconv('UTF-8','TIS-620','บาท/คน'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(125);	
	$pdf->Cell(75,66,iconv('UTF-8','TIS-620','     1.2) ทุพพลภาพชั่วคราว'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,66,iconv('UTF-8','TIS-620','     ก) ผู้ขับขี่ 1 คน'),0,0,"L");
	$pdf->SetX(125);
	$pdf->Cell(50,66,iconv('UTF-8','TIS-620','ไม่คุ้มครอง'),0,0,"R");
	$pdf->Cell(2,66,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(23,66,iconv('UTF-8','TIS-620','บาท/สัปดาห์'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(125);	
	$pdf->Cell(75,66,iconv('UTF-8','TIS-620','     ข) ผู้โดยสาร - คน'),0,0,"L");
	$pdf->SetX(125);
	$pdf->Cell(50,66,iconv('UTF-8','TIS-620','ไม่คุ้มครอง'),0,0,"R");
	$pdf->Cell(2,66,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(23,66,iconv('UTF-8','TIS-620','บาท/คน/สัปดาห์'),0,0,"L");
	
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
	$pdf->Cell(75,66,iconv('UTF-8','TIS-620','2) ค่ารักษาพยาบาล'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(60,66,iconv('UTF-8','TIS-620',$strOption),0,0,"R");
	$pdf->Cell(2,66,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,66,iconv('UTF-8','TIS-620','บาท/คน'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(75,66,iconv('UTF-8','TIS-620','3) การประกันตัวผู้ขับขี่'),0,0,"L");
	$pdf->Ln(6);
	$pdf->SetX(125);
	$pdf->Cell(60,66,iconv('UTF-8','TIS-620',$strOption),0,0,"R");
	$pdf->Cell(2,66,iconv('UTF-8','TIS-620',''),0,0,"L");
	$pdf->Cell(13,66,iconv('UTF-8','TIS-620','บาท/ครั้ง'),0,0,"L");
	$pdf->Ln(35);
	$pdf->Cell(115,12,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->SetX(10);
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620','เบี้ยประกันตามความคุ้มครองหลัก'),0,0,"L");
	$pdf->Cell(2,6,iconv('UTF-8','TIS-620','-'),0,0,"L");
	$pdf->Cell(18,6,iconv('UTF-8','TIS-620','บาท'),0,0,"L");
	
	$pdf->Ln(6);
	$pdf->SetX(10);
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620','(เบี้ยประกันภัยได้หักส่วนลดกรณีระบุชื่อผู้ขับขี่'),0,0,"L");
	$pdf->Cell(2,6,iconv('UTF-8','TIS-620','-'),0,0,"L");
	$pdf->Cell(18,6,iconv('UTF-8','TIS-620','บาทแล้ว)'),0,0,"L");
	
	$pdf->Ln(-6);
	$pdf->SetX(125);
	$pdf->Cell(75,12,iconv('UTF-8','TIS-620',''),1,0,"C");
	$pdf->SetX(125);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','เบี้ยประกันภัยตามเอกสารแนบท้าย'),0,0,"L");
	$pdf->Cell(2,6,iconv('UTF-8','TIS-620','-'),0,0,"L");
	$pdf->Cell(13,6,iconv('UTF-8','TIS-620','บาท'),0,0,"L");
	$pdf->Ln(12);
	$pdf->Cell(10,12,iconv('UTF-8','TIS-620','ส่วนลด'),1,0,"C");
	$pdf->Cell(50,12,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->Ln(-3);
	$pdf->SetX(20);
	$pdf->Cell(50,12,iconv('UTF-8','TIS-620','ความเสียหายส่วนแรก'),0,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(50,12,iconv('UTF-8','TIS-620','- บาท'),0,0,"R");
	$pdf->Ln(6);
	$pdf->SetX(20);
	$pdf->Cell(50,12,iconv('UTF-8','TIS-620','อื่นๆ'),0,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(50,12,iconv('UTF-8','TIS-620','- บาท'),0,0,"R");
	$pdf->Ln(-3);
	$pdf->SetX(70);
	$pdf->Cell(65,12,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->Ln(-3);
	$pdf->SetX(70);
	$pdf->Cell(65,12,iconv('UTF-8','TIS-620','ส่วนลดกลุ่ม'),0,0,"L");
	$pdf->SetX(70);
	$pdf->Cell(65,12,iconv('UTF-8','TIS-620','- บาท'),0,0,"R");
	$pdf->Ln(6);
	$pdf->SetX(70);
	$pdf->Cell(65,12,iconv('UTF-8','TIS-620','รวมส่วนลด'),0,0,"L");
	$pdf->SetX(70);
	$pdf->Cell(65,12,iconv('UTF-8','TIS-620','X,XXX บาท'),0,0,"R");
	$pdf->Ln(-3);
	$pdf->SetX(135);
	$pdf->Cell(65,12,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->Ln(-3);
	$pdf->SetX(135);
	$pdf->Cell(65,12,iconv('UTF-8','TIS-620','ประวัติดี'),0,0,"L");
	$pdf->SetX(135);
	$pdf->Cell(65,12,iconv('UTF-8','TIS-620','X,XXX บาท'),0,0,"R");
	
	$pdf->Ln(15);
	$pdf->Cell(10,6,iconv('UTF-8','TIS-620','ส่วนเพิ่ม'),1,0,"C");
	$pdf->Cell(180,6,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->Ln(-3);
	$pdf->SetX(20);
	$pdf->Cell(180,12,iconv('UTF-8','TIS-620','ความเสียหายส่วนแรก'),0,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(180,12,iconv('UTF-8','TIS-620','- บาท'),0,0,"C");
	$pdf->SetTextColor(255,0,0);
	$pdf->SetFont('angsa','',14);
	$pdf->SetX(20);
	$pdf->Cell(180,12,iconv('UTF-8','TIS-620','ชำระอากรแล้ว'),0,0,"R");
	$pdf->SetFont('angsa','',12);
	$pdf->SetTextColor(0,0,0);
	
	$pdf->Ln(9);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','เบี้ยประกันสุทธิ'),1,0,"C");
	$pdf->SetX(70);
	$pdf->Cell(45,6,iconv('UTF-8','TIS-620','อากร'),1,0,"C");
	$pdf->SetX(115);
	$pdf->Cell(35,6,iconv('UTF-8','TIS-620','ภาษีมูลค่าเพิ่ม'),1,0,"C");
	$pdf->SetX(150);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','รวม'),1,0,"C");
	$pdf->Ln(6);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620',$row['pre']),1,0,"C");
	$pdf->SetX(70);
	$pdf->Cell(45,6,iconv('UTF-8','TIS-620',$row['stamp']),1,0,"C");
	$pdf->SetX(115);
	$pdf->Cell(35,6,iconv('UTF-8','TIS-620',$row['tax']),1,0,"C");
	$pdf->SetX(150);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',$row['net']),1,0,"C");
	
	$pdf->SetFont('angsa','',12);
	$pdf->Ln(6);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','การใช้รถยนต์ '.'กำลังแก้ไข'),1,0,"L");
	$pdf->Ln(6);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','อุปกรณ์ตกแต่งเพิ่มเติม '.'กำลังแก้ไข'),1,0,"L");
	$pdf->Ln(6);
	$pdf->Image('../images/2.jpg',15,259,4);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620',''),1,0,"L");
	$pdf->SetX(20);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,0,"L");
	$pdf->SetX(50);
	$pdf->Image('../images/1.jpg',55,259,4);
	$pdf->SetX(60);
	$pdf->Cell(60,6,iconv('UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้                     บจ.โฟร์ อินชัวร์ โบรกเกอร์'),0,0,"L");
	$pdf->SetX(120);
	$pdf->Cell(80,6,iconv('UTF-8','TIS-620','ใบอนุญาตเลขที่ ว00018/2551'),0,0,"R");
	$pdf->Ln(6);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','วันทำสัญญาประกันภัย'),0,0,"L");
	$pdf->SetX(50);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',date("d/m/Y",strtotime($row['start_date']))),0,0,"C");
	$pdf->SetX(100);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620','วันทำกรมธรรม์'),0,0,"L");
	$pdf->SetX(150);
	$pdf->Cell(50,6,iconv('UTF-8','TIS-620',date("d/m/Y",strtotime($row['end_date']))),0,0,"C");
	$pdf->Ln(6);
	$pdf->Cell(0,6,iconv('UTF-8','TIS-620','เอกสารฉบับนี้เป็นเพียงข้อเสนอประกันภัยรถยนต์เท่านั้นส่วนเงื่อนไขความคุ้มครอง ข้อยกเว้น ตามที่กำหนด ระบุอยู่ในกรมธรรม์ประกันภัยรถยนต์'),0,0,"L");
	
	$pdf->Output();
	//echo $query;
mysql_close(); ?>