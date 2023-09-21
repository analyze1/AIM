<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.pdo.php";
require('../fpdf.php');
$_contextMitsu = PDO_CONNECTION::fourinsure_mitsu();

function thaiDate($datetime) 
{
	list($date,$time) = explode(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($H,$i,$s) = explode(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($Y,$m,$d) = explode('-',$date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.

	switch($m) 
	{
		case "01": $m = "01"; break;
		case "02": $m = "02"; break;
		case "03": $m = "03"; break;
		case "04": $m = "04"; break;
		case "05": $m = "05"; break;
		case "06": $m = "06"; break;
		case "07": $m = "07"; break;
		case "08": $m = "08"; break;
		case "09": $m = "09"; break;
		case "10": $m = "10"; break;
		case "11": $m = "11"; break;
		case "12": $m = "12"; break;
	}
	return $d."/".$m."/".$Y;
} 

$IDDATA = $_GET['IDDATA'];
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
$query .= "act.p_pre, "; // 
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
$query .= "insuree.icard, ";

$query .= "tb_tumbon.name as tumbon_name, "; 
$query .= "tb_amphur.name as amphur_name, "; 
$query .= "tb_province.name as province_name, "; // จังหวัด

$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
$query .= "detail.mo_car, "; // ยี่ห้อรถ
$query .= "tb_br_car.name as car_brand, "; // ยี่ห้อรถ
$query .= "tb_cat_car.name as cat_car_name, "; // ประเภทรถ
$query .= "tb_mo_car.name as mo_car_name, "; // รุ่นรถ
$query .= "tb_mo_car_sub.desc As nnwgcc, "; // ที่นั่ง - นํ้าหนัก - cc
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

$query .= "data.updated, "; // สลักหลัง
$query .= "protect.costCost,"; // ทุนประกันภัย
$query .= "data.send_req, "; // สลักหลัง
$query .= "data.send_req2, "; // สลักหลัง

$query .= "tb_cost.cost, ";
$query .= "tb_cost.pre, ";
$query .= "tb_cost.stamp, ";
$query .= "tb_cost.tax, ";
$query .= "tb_cost.net, ";

$query .= "req.Req_Status, ";
$query .= "req.Req_Date, ";
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

$query .= "tb_customer.Dealer_code, ";
$query .= "tb_customer.Dealer_saka, ";
$query .= "tb_customer.saka, ";

$query .= "tb_customer.Contact2 ";

$query .= "FROM data ";
$query .= "LEFT JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "LEFT JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "LEFT JOIN protect ON (data.id_data = protect.id_data) ";
$query .= "LEFT JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
$query .= "LEFT JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
$query .= "LEFT JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
$query .= "LEFT JOIN act ON (act.id_data = data.id_data)  ";
$query .= "LEFT JOIN tb_cost ON (tb_cost.id = protect.costCost) ";
$query .= "LEFT JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query .= "LEFT JOIN tb_mo_car_sub ON (tb_mo_car_sub.id = detail.mo_sub) ";
$query .= "LEFT JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
$query .= "LEFT JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
$query .= "LEFT JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
$query .= "LEFT JOIN tb_province ON (tb_province.id = insuree.province) ";
$query .= "LEFT JOIN tb_customer ON (tb_customer.user = data.login) ";
$query .= "LEFT JOIN req ON (req.id_data = data.id_data) ";

$query .= "WHERE data.id_data='$IDDATA'";

$objQuery = $_contextMitsu->query($query);

$row = $objQuery->fetch();

$car_id = $row['car_id'];
$arr_car_id = str_split($car_id);
$id_data_rec = $row['id_data'];
	
	$address_pdf = $row['add'];
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
	
	//$pdf->Image('../images/act_2.jpg',0,0,210);
	
	if($row['EditAct'] == 'Y')
	{
		$act_id = $row['EditAct_id'];
	}
	else
	{
		$act_id = $row['p_act'];
	}
	
	if($row['saka'] != '302')
	{
		$pdf->SetFont('angsa','B',26);
		$pdf->SetY(45);
		$pdf->SetX(100);
		$pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',$act_id),0,0,'L');
	}
	else
	{
		$pdf->SetFont('angsa','B',26);
		$pdf->SetY(45);
		$pdf->SetX(100);
		$pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',''),0,0,'L');
	}
	
	
	$pdf->SetFont('angsa','B',14);
	$pdf->SetY(53);
	$pdf->SetX(70);
	$pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',$row['title'].' '.$row['name'].' '.$row['last']),0,0,'L');
	
	$pdf->SetFont('angsa','B',14);
	$pdf->SetY(57);
	$pdf->SetX(130);
	$pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',$row['icard']),0,0,'L');
	
	$pdf->SetY(62);
	$pdf->SetX(71);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,4,iconv( 'UTF-8','TIS-620',$address_pdf),0,1,'L');
	$pdf->SetX(71);
	$pdf->Cell(0,4,iconv( 'UTF-8','TIS-620',$address_pdf2.' '.$row['postal']),0,0,'L');
	if($row['Dealer_saka'] == "สำนักงานใหญ่")
	{
		$pdf->Image('../images/1.jpg',18,58,3);
	}
	if($row['Dealer_saka'] == "สาขาที่ 1")
	{
		$pdf->Image('../images/1.jpg',33,58,3);
		
		$pdf->SetY(60);
		$pdf->SetX(46);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(0,5,iconv( 'UTF-8','TIS-620','1'),0,0,'L');
	}
	if($row['Dealer_saka'] == "สาขาที่ 2")
	{
		$pdf->Image('../images/1.jpg',33,58,3);
		
		$pdf->SetY(60);
		$pdf->SetX(46);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(0,5,iconv( 'UTF-8','TIS-620','2'),0,0,'L');
	}
	if($row['Dealer_saka'] == "สาขาที่ 3")
	{
		$pdf->Image('../images/1.jpg',33,58,3);
		
		$pdf->SetY(60);
		$pdf->SetX(46);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(0,5,iconv( 'UTF-8','TIS-620','3'),0,0,'L');
	}
	
	
	
	$pdf->SetFont('angsa','B',16);
	$pdf->SetY(71);
	$pdf->SetX(83);
	$pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',thaiDate($row['start_date'])),0,0,'');
	
	$pdf->SetY(71);
	$pdf->SetX(137);
	$pdf->Cell(0,5,iconv( 'UTF-8','TIS-620',thaiDate($row['end_date'])),0,0,'');
	
	$pdf->SetFont('angsa','B',14);
	$pdf->SetY(93);
	$pdf->SetX(7);

	if($row['car_cat_acc'] != '')
	{
		if($row['car_cat_acc'] == '220')
		{
			$actcode = '2.20';
			$bodytype = 'รถยนต์โดยสาร';
		}
		else
		{
			$actcode = '2.30';
			$bodytype = 'รถยนต์โดยสาร';
		}
		if($row['car_cat_acc'] == '120')
		{
			$actcode = '1.20';
			$bodytype = 'รถยนต์โดยสาร';
		}
		
	}
	else
	{
		if($row['cat_car']=='01')
		{
			$actcode = '1.10';
			$bodytype = 'รถนั่งส่วนบุคคล';
		}
		else if($row['cat_car']=='03')
		{
			$actcode = '1.40';
			$bodytype = 'รถยนต์บรรทุก';
		}
	}
	$pdf->Cell(28,5,iconv( 'UTF-8','TIS-620',$actcode),0,0,'C');
	
	$pdf->SetY(93);
	$pdf->SetX(32);
	$pdf->Cell(37,5,iconv( 'UTF-8','TIS-620',$row['car_brand']),0,0,'C');
	
	$pdf->SetY(96);
	$pdf->SetX(32);
	$pdf->Cell(37,5,iconv( 'UTF-8','TIS-620',$row['mo_car_name']),0,0,'C');
	
	$pdf->SetY(95);
	$pdf->SetX(67);
	$pdf->Cell(34,5,iconv( 'UTF-8','TIS-620','ป้ายแดง'),0,0,'C');
	
	$pdf->SetY(95);
	$pdf->SetX(99);
	$pdf->Cell(39,5,iconv( 'UTF-8','TIS-620',$row['car_body']),0,0,'C');
	
	$pdf->SetY(95);
	$pdf->SetX(140);	
	$pdf->Cell(39,5,iconv( 'UTF-8','TIS-620',$bodytype),0,0,'C');
	
	$pdf->SetY(95);
	$pdf->SetX(173);
	if(!empty($row['nnwgcc']))
	{
		$scw = $row['nnwgcc'];
	}
	else if($row['mo_car'] == "759" || $row['mo_car'] == "747")
	{
		$scw = "7 / 3 / 1600";
	}
	else if($row['mo_car'] == "1098")
	{
		$scw = "3 / 3 / 1600";
	}
	else if($row['mo_car'] == "1960")
	{
		$scw = "7 / 3 / 1400";
	}
	else if($row['mo_car'] == "1951" || $row['mo_car'] == "754" || $row['mo_car'] == "1964" || $row['mo_car'] == "1967" || $row['mo_car'] == "1968" || $row['mo_car'] == "1969")
	{
		$scw = "7 / 3 / 1200";
	}
	
	$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620',$scw),0,0,'C');
	
	if($row['car_cat_acc'] != '')
	{
		if($row['car_cat_acc'] == '220')
		{
			$act_pre = '1580.00';
			$act_duty = '7.00';
			$act_vat = '111.09';
			$act_net = '1698.09';
		}
		else
		{
			$act_pre = '2320.00';
			$act_duty = '10.00';
			$act_vat = '163.10';
			$act_net = '2493.10';
		}
		if($row['car_cat_acc'] == '120')
		{
			$act_pre = '1900.00';
			$act_duty = '8.00';
			$act_vat = '133.56';
			$act_net = '2041.56';
		}
	}
	else
	{
		if($row['cat_car']== '01')
		{
			$act_pre = '600.00';
			$act_duty = '3.00';
			$act_vat = '42.21';
			$act_net = '645.21';
		}
		else if($row['cat_car']== '03')
		{
			$act_pre = '900.00';
			$act_duty = '4.00';
			$act_vat = '63.28';
			$act_net = '967.28';
		}
	}
	$pdf->SetFont('angsa','B',18);
	$pdf->SetY(154);
	$pdf->SetX(12);
	$pdf->Cell(28,5,iconv( 'UTF-8','TIS-620',$act_pre),0,0,'C');
	
	$pdf->SetY(154);
	$pdf->SetX(84);
	$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620',$act_pre),0,0,'C');
	
	$pdf->SetY(154);
	$pdf->SetX(113);
	$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620',$act_duty),0,0,'C');
	
	$pdf->SetY(154);
	$pdf->SetX(138);
	$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620',$act_vat),0,0,'C');
	
	$pdf->SetY(154);
	$pdf->SetX(171);
	$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620',$act_net),0,0,'C');
	
	$pdf->SetFont('angsa','B',14);
	$pdf->SetY(162);
	$pdf->SetX(70);
	
	if($row['car_cat_acc'] != '')
	{
		if($row['car_cat_acc'] == '220')
		{
			$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620','รถยนต์โดยสารใช้เพื่อการพาณิชย์'),0,0,'C');	
		}
		else
		{
			$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620','รถยนต์โดยสารใช้รับจ้างสาธารณะ'),0,0,'C');	
		}
	}
	else
	{
		$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620','ใช้เป็นรถส่วนบุคคล ไม่ใช้รับจ้างหรือให้เช่า'),0,0,'C');	
	}
	
	
	$pdf->Image('../images/1.jpg',111,173,3);
	
	$pdf->SetFont('angsa','B',11);
	$pdf->SetY(171);
	$pdf->SetX(135);
	$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620','บจ.โฟร์อินชัวร์โบรกเกอร์'),0,0,'C');
	
	$pdf->SetY(171);
	$pdf->SetX(175);
	$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620','ว00018/2551'),0,0,'C');
	
	$pdf->SetFont('angsa','B',14);
	$pdf->SetY(178);
	$pdf->SetX(45);
	$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620',thaiDate($row['start_date'])),0,0,'C');
	
	$pdf->SetY(178);
	$pdf->SetX(145);
	$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620',thaiDate($row['start_date'])),0,0,'C');
	
	$pdf->SetY(232);
	$pdf->SetX(90);
	$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620','ป้ายแดง'),0,0,'C');
	
	$pdf->SetY(232);
	$pdf->SetX(160);
	$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620',$row['car_body']),0,0,'C');
	
	$pdf->SetY(246);
	$pdf->SetX(50);
	$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620',thaiDate($row['start_date'])),0,0,'C');
	
	$pdf->SetY(246);
	$pdf->SetX(140);
	$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620',thaiDate($row['end_date'])),0,0,'C');
	
	if($row['saka'] != '302')
	{
		$pdf->SetFont('angsa','B',20);
		$pdf->SetY(252);
		$pdf->SetX(60);
		$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620',$act_id),0,0,'C');
	}
	else
	{
		$pdf->SetFont('angsa','B',20);
		$pdf->SetY(252);
		$pdf->SetX(60);
		$pdf->Cell(35,5,iconv( 'UTF-8','TIS-620',''),0,0,'C');
	}
	
	$pdf->Output();


?>
