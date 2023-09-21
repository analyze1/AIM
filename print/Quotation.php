<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
define('FPDF_FONTPATH', 'font/');
require('rotation.php');
include"../../inc/connectdbs.pdo.php";
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
		list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
		list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
		
		if($m == '12')
		{
			$m = '1';
			$Y = $Y+544; // เปลี่ยน ค.ศ. เป็น พ.ศ.
		}
		else
		{
			$m = $m+1;
			$Y = $Y+543;
		}
		
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
	
	function thaiDate2($datetime)
	{
		list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
		list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
		$Y = $Y+543;
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

$query4 = "
SELECT DISTINCT
quotation.id
,quotation.id_customer
,quotation.id_cat_car
,quotation.id_car_regis
,quotation.car_type
,quotation.car_id
,quotation.id_br_car
,quotation.car_regis_type
,quotation.id_mo_car
,quotation.cc
,quotation.car_color
,quotation.gear
,quotation.car_seat
,quotation.wg_name
,quotation.qty_car
,quotation.q_auto
,quotation.q_manual
,quotation.net_pre
,quotation.qty_driver
,quotation.dis_driver
,quotation.dis_damage1
,quotation.dis_group3_per
,quotation.dis_group3_amt
,quotation.hisgood_per
,quotation.hisgood_amt
,quotation.disextra_per
,quotation.disextra_amt
,quotation.net_pre_dis
,quotation.pre_stamp
,quotation.pre_vat
,quotation.year_old
,quotation.pre_total
,quotation.id_prb
,quotation.prb_amt
,quotation.tax1per
,quotation.hold_tax
,quotation.tax_prb
,quotation.sum_pre_prb
,quotation.com_dis_per
,quotation.com_dis_agent_per
,quotation.com_dis_amt
,quotation.com_total
,quotation.grand_total
,quotation.insu_amt
,quotation.human_amt
,quotation.asset_amt
,quotation.drive1_amt
,quotation.passenger
,quotation.passenger_amt
,quotation.medic_amt
,quotation.criminal_amt
,quotation.first_damage
,quotation.first_damage_amt
,quotation.car_regis_pro
,quotation.regis_date as regis_date
,quotation.send_date as send_date
,quotation.hidden_discount
,quotation.agent_group

,tb_acc_car.acc_name1
,tb_acc_car.acc_name2
,tb_acc_car.acc_name3
,tb_acc_car.acc_price1
,tb_acc_car.acc_price2
,tb_acc_car.acc_price3

,insuree_quotation.title
,insuree_quotation.name
,insuree_quotation.last
,insuree_quotation.person as ps

,tb_comp.name as comp_name
,tb_comp.sort
,tb_comp.picture
,tb_comp.name_print
,tb_comp.tel
,tb_comp.add_namecom
,tb_comp.add_namecom2
,tb_comp.tax_id
,tb_comp.sort as sort

,tb_cat_car.name as cat_car_name

,tb_pass_car_type.name as car_type_name

,tb_br_car.name as car_brand

,tb_mo_car.name as car_mo

,data_quotation.start_date as start_date
,data_quotation.end_date as end_date
,data_quotation.doc_type as doc_type
,data_quotation.service as service

,driver_quotation.title_num1
,driver_quotation.name_num1
,driver_quotation.last_num1
,driver_quotation.birth_num1
,driver_quotation.title_num2
,driver_quotation.name_num2
,driver_quotation.last_num2
,driver_quotation.birth_num2

FROM quotation
LEFT JOIN insuree_quotation ON quotation.q_auto = insuree_quotation.q_auto
LEFT JOIN tb_comp ON quotation.id_customer = tb_comp.sort
LEFT JOIN tb_acc_car ON quotation.q_auto = tb_acc_car.q_auto
LEFT JOIN tb_cat_car ON quotation.id_cat_car = tb_cat_car.id
LEFT JOIN tb_mo_car ON quotation.id_mo_car = tb_mo_car.id
LEFT JOIN tb_pass_car_type ON quotation.car_id =  tb_pass_car_type.pass_car_id
LEFT JOIN tb_br_car ON quotation.id_br_car =  tb_br_car.id 
LEFT JOIN data_quotation ON data_quotation.q_auto =  quotation.q_auto 
LEFT JOIN driver_quotation ON driver_quotation.q_auto =  quotation.q_auto 
";

$query4 .= "WHERE quotation.q_auto='".base64_decode($_GET["iddta"])."' ";
mysql_select_db($db2,$cndb2);
$objQuery4 = mysql_query($query4,$cndb2) or die ("Error Query [".$query4."]");
$row = mysql_fetch_array($objQuery4);

	$car_id = $row['car_id'];
	$id_data_rec = $row['id_data'];
	$arr_car_id = str_split($car_id);
	
	$sql = "SELECT name_mini FROM tb_province WHERE id='".$row['car_regis_pro']."'";
	$result = mysql_query( $sql,$cndb2);
	$fetcharr = mysql_fetch_array( $result ) ;
	$c_regis = $fetcharr['name_mini'];
	
	if($row['one']=="0")
	{
    	 $one_s = "-";
    }
	else
	{
    	 $one_s = $row['one'];
    }
	
	if($row['people']=="")
	{
    	 $people_s = "0";
    }
	else
	{
    	 $people_s = $row['people'];
    }
	
	if($row['name_num1']!="ไม่ระบุ")
	{
    	 $D_Name = $row['title_num1'].$row['name_num1']." ".$row['last_num1']." วัน/เดือน/ปีเกิด ".$row['birth_num1'];

		 $D_Name2 = ",  ".$row['title_num2'].$row['name_num2']." ".$row['last_num2']." วัน/เดือน/ปีเกิด ".$row['birth_num2'];
    }
	else
	{
    	 $D_Name = $row['name_num1'];
    }

mysql_select_db( $database_conn ) or die( "เลือกฐานข้อมูลไม่ได้" );
$tb_customer="SELECT title_sub,sub FROM tb_customer WHERE user = '".$row['agent_group']."'";
$tb_query=mysql_query($tb_customer);
$tb_array=mysql_fetch_array($tb_query);
	
$pdf=new PDF();
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
//$pdf->SetFont('Arial', '', 20);
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsa','B','angsab.php');
$pdf->Image('../images/logo4.png',8,3,55,23);
//$pdf->SetFont('angsa','B',16);
$pdf->SetFont('angsa','B',50);
$pdf->SetTextColor(255,192,203);
$ni=strlen($tb_array['sub']);
$xi=120-(0.8*$ni);
$yi=130+(0.9*$ni);

$pdf->RotatedText($xi,$yi,iconv( 'UTF-8','TIS-620',$tb_array['title_sub']." ".$tb_array['sub']),45);
	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetY(5);
	$pdf->SetFont('angsa','B',16);
	$pdf->Cell(0,15,iconv( 'UTF-8','TIS-620','เรียน '.$row['title'].$row['name']." ".$row['last']),0,1,"R");
	
	$pdf->SetY(15);
	$pdf->SetFont('angsa','B',18);
	$pdf->Cell(0,15,iconv( 'UTF-8','TIS-620',$row['name_print']),0,1,"R");
	
	$pdf->SetY(30);
	$pdf->SetX(8);
	$pdf->SetFont('angsa','B',16);
	//$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บริษัท โฟร์ อินชัวร์ โบรกเกอร์ จำกัด'),0,1,"L");
	
	$pdf->SetY(34);
	$pdf->SetX(8);
	$pdf->SetFont('angsa','',12);
	//$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','62/11-12 หมู่ 1 ถ.ราชพฤกษ์ ต.อ้อมเกร็ด อ.ปากเกร็ด จ.นนทบุรี 11120 โทร. 02-196-8234(อัตโนมัติ)'),0,1,"L");
	
	$pdf->SetY(38);
	$pdf->SetX(8);
	$pdf->SetFont('angsa','',12);
	//$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','085-9213636(24 ชม.), 085-921-5454(24 ชม.) โทรสาร 02-196-8235 E-mail : Assist@my4ib.com, www.fourinsured.com'),0,1,"L");
	
	$pdf->SetY(46);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','U',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','รายละเอียดอัตราเบี้ยประกันภัยภาคสมัครใจ'),0,1,"L");
	
	$pdf->SetY(46);
	$pdf->SetX(145);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','เลขที่ใบเสนอราคา: '),0,1,"L");
	
	if($row['ps'] == '1')
	{
		$person = 'บุคคล';
	}
	if($row['ps'] == '2')
	{
		$person = 'นิติบุคคล';
	}
	
	$pdf->SetY(46);
	$pdf->SetX(172);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$row['q_auto'].' ('.$person.')'),0,1,"L");
	
	$pdf->SetY(50);
	$pdf->Cell(0,40,'',1);
	
	$pdf->SetY(55);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','รถรหัส'),0);
	
	$pdf->SetY(55);
	$pdf->SetX(40);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',':'),0);
	
	$pdf->SetY(55);
	$pdf->SetX(42);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$row['car_id']),0);
	
	$pdf->SetY(55);
	$pdf->SetX(50);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',':'),0);
	
	$pdf->SetY(55);
	$pdf->SetX(52);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$row['car_type_name']),0);
	
	$pdf->SetY(55);
	$pdf->SetX(130);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','ประเภทกรมธรรม์ :'),0);
	
	$pdf->SetY(55);
	$pdf->SetX(157);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$row['doc_type']),0);
	
	$pdf->SetY(62);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','ชื่อรถยนต์/รุ่น'),0);
	
	$pdf->SetY(62);
	$pdf->SetX(40);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',':'),0);
	
	$pdf->SetY(62);
	$pdf->SetX(42);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$row['car_brand'].' / '.$row['car_mo']),0);
	
	if($row['id_car_regis'] != "")
	{
		$car_regis = $row['id_car_regis'];
	}
	else
	{
		$car_regis = "ป้ายแดง";
	}
	
	$pdf->SetY(62);
	$pdf->SetX(100);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','ทะเบียน : '.$car_regis." ".$c_regis),0);
	
	if( $row['car_seat'] == "ไม่เกิน 15 ที่นั่ง" or $row['car_seat'] == "ไม่เกิน 7 ที่นั่ง" or $row['car_seat'] == "ไม่เกิน 6 ที่นั่ง" or $row['car_seat'] == "ไม่เกิน 3 ที่นั่ง" or $row['car_seat'] == "ไม่ระบุ" or $row['car_seat'] == "")
	{
    	 $c_seat = $row['car_seat'];
    }
	else
	{
		 $c_seat = "ไม่เกิน ".$row['car_seat']." ที่นั่ง";
	}
	
	$pdf->SetY(62);
	$pdf->SetX(140);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$c_seat),0);
	
	if($row['service'] == "1")
	{
		$service = "ซ่อมห้าง";
	}
	else
	{
		$service = "ซ่อมอู่";
	}
	
	$pdf->SetY(62);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$service),0);
	
	$pdf->SetY(69);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','ปีจดทะเบียน'),0);
	
	$pdf->SetY(69);
	$pdf->SetX(40);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',':'),0);
	
	$pdf->SetY(69);
	$pdf->SetX(42);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$row['regis_date']),0);
	
	$pdf->SetY(69);
	$pdf->SetX(60);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','อายุรถ'),0);
	
	$pdf->SetY(69);
	$pdf->SetX(70);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',':'),0);
	
	$pdf->SetY(69);
	$pdf->SetX(72);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$row['year_old']),0);
	
	$pdf->SetY(69);
	$pdf->SetX(87);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','กลุ่มรถ'),0);
	
	$pdf->SetY(69);
	$pdf->SetX(98);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',':'),0);
	
	$pdf->SetY(69);
	$pdf->SetX(100);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$row['cat_car_name']),0);
	
	$pdf->SetY(69);
	$pdf->SetX(130);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',"จำนวน ".$row['cc']." ซี.ซี"),0);
	
	$pdf->SetY(76);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','ผู้ขับขี่'),0);
	
	$pdf->SetY(76);
	$pdf->SetX(40);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',':'),0);
	
	$pdf->SetY(76);
	$pdf->SetX(42);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$D_Name."".$D_Name2),0);
	
	$pdf->SetY(83);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','อุปกรณ์เพิ่มพิเศษ'),0);
	
	$pdf->SetY(83);
	$pdf->SetX(40);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',':'),0);
	
	$pdf->SetY(83);
	$pdf->SetX(42);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','-'),0);
	
	$pdf->SetY(83);
	$pdf->SetX(87);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','ระยะเวลาประกันภัย'),0);
	
	$pdf->SetY(83);
	$pdf->SetX(115);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',':'),0);
	if($row['start_date'] == '0000-00-00' )
	{
		 $start_date = "";
		 $end_date = "";
	}
	else
	{
		 $start_date =  thaidate2($row['start_date']);
		 $end_date =  thaidate2($row['end_date']);
	}
	
	
	
	$pdf->SetY(83);
	$pdf->SetX(117);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$start_date." - ".$end_date),0);
	
	$pdf->SetY(95);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','U',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','จำนวนเงินจำกัดความรับผิด'),0,1,"L");
	
	$pdf->SetY(100);
	$pdf->Cell(0,100,'',1);
	
	$pdf->SetY(105);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','1. ความเสียหายต่อชีวิต ร่างกายหรืออนามัย ต่อบุคคลภายนอก :'),0);
	
	$pdf->SetY(105);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['human_amt']),0,0,"R");
	
	$pdf->SetY(105);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท/คน'),0);
	
	$pdf->SetY(112);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620','10,000,000'),0,0,"R");
	
	$pdf->SetY(112);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท/ครั้ง'),0);
	
	$pdf->SetY(119);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','2. ความเสียหายต่อทรัพย์สิน :'),0);
	
	$pdf->SetY(119);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['asset_amt']),0,0,"R");
	
	$pdf->SetY(119);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท/ครั้ง'),0);
	
	$pdf->SetY(126);
	$pdf->SetX(17);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','2.1 ความเสียหายส่วนแรกโดยสมัครใจ :'),0);
	
	$pdf->SetY(126);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620','-'),0,0,"R");
	
	$pdf->SetY(126);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท/ครั้ง'),0);
	
	$pdf->SetY(133);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','3. ความเสียหายต่อรถยนต์ :'),0);
	
	if($row['doc_type'] == '3' OR $row['doc_type'] == '2')
	{
		$pdf->SetY(133);
		$pdf->SetX(150);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620','ไม่ระบุ'),0,0,"R");
	}
	else
	{
		$pdf->SetY(133);
		$pdf->SetX(150);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['insu_amt']),0,0,"R");
	}
	
	$pdf->SetY(133);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท/ครั้ง'),0);
	
	$pdf->SetY(140);
	$pdf->SetX(17);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','3.1 ความเสียหายส่วนแรกโดยสมัครใจ :'),0);
	
	$pdf->SetY(140);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['first_damage_amt']),0,0,"R");
	
	$pdf->SetY(140);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท/ครั้ง'),0);
	
	$pdf->SetY(147);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','4. รถยนต์สูญหาย/ไฟไหม้ :'),0);
	
	if($row['doc_type'] == '3+' OR $row['doc_type'] == '3')
	{
		$pdf->SetY(147);
		$pdf->SetX(150);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620','ไม่ระบุ'),0,0,"R");
	}
	else
	{	
		$pdf->SetY(147);
		$pdf->SetX(150);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['insu_amt']),0,0,"R");
	}
	
	$pdf->SetY(147);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
	
	$pdf->SetY(152);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','5. อุบัติเหตุส่วนบุคคล : ผู้ขับขี่ 1 คน'),0);
	
	$pdf->SetY(152);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['drive1_amt']),0,0,"R");
	
	$pdf->SetY(152);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
	
	$pdf->SetY(159);
	$pdf->SetX(35);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ผู้โดยสาร'),0);
	
	$pdf->SetY(159);
	$pdf->SetX(53);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$row['passenger']),0);
	
	$pdf->SetY(159);
	$pdf->SetX(60);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','คน'),0);
	
	$pdf->SetY(159);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['passenger_amt']),0,0,"R");
	
	$pdf->SetY(159);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท/คน'),0);
	
	$pdf->SetY(166);
	$pdf->SetX(15);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ชดเชยรายสัปดาห์ ไม่เกิน 52 สัปดาห์ : ผู้ขับขี่ 1 คน'),0);
	
	$pdf->SetY(166);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620','-'),0,0,"R");
	
	$pdf->SetY(166);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท/สัปดาห์'),0);
	
	$pdf->SetY(173);
	$pdf->SetX(35);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ผู้โดยสาร'),0);
	
	$pdf->SetY(173);
	$pdf->SetX(53);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','-'),0);
	
	$pdf->SetY(173);
	$pdf->SetX(60);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','คน'),0);
	
	$pdf->SetY(173);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620','-'),0,0,"R");
	
	$pdf->SetY(173);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท/คน/สัปดาห์'),0);
	
	$pdf->SetY(180);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','6. ค่ารักษาพยาบาล :'),0);
	
	$pdf->SetY(187);
	$pdf->SetX(25);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ผู้ขับขี่ + ผู้โดยสาร'),0);
	
	$pdf->SetY(187);
	$pdf->SetX(51);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',"1 + ".$row['passenger']),0);
	
	$pdf->SetY(187);
	$pdf->SetX(60);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','คน'),0);
	
	$pdf->SetY(187);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['medic_amt']),0,0,"R");
	
	$pdf->SetY(187);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
	
	$pdf->SetY(194);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','7. ประกันตัวผู้ขับขี่ :'),0);
	
	$pdf->SetY(194);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['criminal_amt']),0,0,"R");
	
	$pdf->SetY(194);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท/ครั้ง'),0);
	
	$pdf->SetY(205);
	$pdf->SetX(120);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','เบี้ยสุทธิ :'),0,0,"R");
	
	$pdf->SetY(205);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['net_pre_dis']),0,0,"R");
	
	$pdf->SetY(205);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
	
	$pdf->SetY(212);
	$pdf->SetX(120);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','เบี้ยรวม :'),0,0,"R");
	
	$pdf->SetY(212);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['pre_total']),0,0,"R");
	
	$pdf->SetY(212);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
	
	$pdf->SetY(219);
	$pdf->SetX(120);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','เบี้ยพรบ :'),0,0,"R");
	
	$pdf->SetY(219);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['prb_amt']),0,0,"R");
	
	$pdf->SetY(219);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
	
	$pdf->SetY(226);
	$pdf->SetX(120);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','เบี้ยรวมพรบ :'),0,0,"R");
	
	$pdf->SetY(226);
	$pdf->SetX(150);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',number_format(str_replace("," , "",$row['pre_total'])+str_replace("," , "",$row['prb_amt']),2)),0,0,"R");
	
	$pdf->SetY(226);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
	
	// ส่วนลด
	$dis = str_replace("," , "",$row['com_dis_amt'])+str_replace("," , "",$row['com_total']);
	
	// หัก 1 กธ.
	if($row['hold_tax'] == "0.00")
	{
		$hold_tax = "-";
	}
	else
	{
		$hold_tax = $row['hold_tax'];
	}
	/////////////////////////////////////////////////////////
	// หัก 1 พรบ.
	if($row['tax_prb'] == "0.00")
	{
		$tax_prb = "-";
	}
	else
	{
		$tax_prb = $row['tax_prb'];
	}
	//////////////////////////////////////////////////////////
	
	if($dis == '0')
	{
		$pdf->SetY(233);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','หัก 1% กธ. :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$hold_tax),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetY(240);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','หัก 1% พรบ. :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$tax_prb),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetX(140);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(30,7,iconv( 'UTF-8','TIS-620','_____________'),0,0,"R");
		
		$pdf->SetY(250);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','ยอดชำระ :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['grand_total']),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetY(248);
		$pdf->SetX(140);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(30,7,iconv( 'UTF-8','TIS-620','_____________'),0,0,"R");
		
		$pdf->SetY(248.5);
		$pdf->SetX(140);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(30,7,iconv( 'UTF-8','TIS-620','_____________'),0,0,"R");
	}
	else if($dis != '0' && $row['hidden_discount'] == 'Y')
	{
		$pdf->SetY(233);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','ส่วนลด :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',number_format(str_replace("," , "",$row['com_dis_amt'])+str_replace("," , "",$row['com_total']),2)),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetY(240);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','หัก 1% กธ. :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$hold_tax),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetY(247);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','หัก 1% พรบ. :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$tax_prb),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetX(140);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(30,7,iconv( 'UTF-8','TIS-620','_____________'),0,0,"R");
		
		$pdf->SetY(257);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','ยอดชำระ :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['grand_total']),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetY(255);
		$pdf->SetX(140);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(30,7,iconv( 'UTF-8','TIS-620','_____________'),0,0,"R");
		
		$pdf->SetY(255.5);
		$pdf->SetX(140);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(30,7,iconv( 'UTF-8','TIS-620','_____________'),0,0,"R");
	}
	else if($dis != '0' && $row['hidden_discount'] == 'N')
	{
		$pdf->SetY(233);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','หัก 1% กธ. :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$hold_tax),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetY(240);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','หัก 1% พรบ. :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$tax_prb),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetX(140);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(30,7,iconv( 'UTF-8','TIS-620','_____________'),0,0,"R");
		
		$pdf->SetY(250);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','ยอดชำระ :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['grand_total']),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetY(248);
		$pdf->SetX(140);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(30,7,iconv( 'UTF-8','TIS-620','_____________'),0,0,"R");
		
		$pdf->SetY(248.5);
		$pdf->SetX(140);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(30,7,iconv( 'UTF-8','TIS-620','_____________'),0,0,"R");
	}
	else if($dis != '0' && $row['hidden_discount'] == '')
	{
		$pdf->SetY(233);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','ส่วนลด :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',number_format(str_replace("," , "",$row['com_dis_amt'])+str_replace("," , "",$row['com_total']),2)),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetY(240);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','หัก 1% กธ. :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$hold_tax),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetY(247);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','หัก 1% พรบ. :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$tax_prb),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetX(140);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(30,7,iconv( 'UTF-8','TIS-620','_____________'),0,0,"R");
		
		$pdf->SetY(257);
		$pdf->SetX(120);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(18,0,iconv( 'UTF-8','TIS-620','ยอดชำระ :'),0,0,"R");
		
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(17,0,iconv( 'UTF-8','TIS-620',$row['grand_total']),0,0,"R");
		
		$pdf->SetX(170);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บาท'),0);
		
		$pdf->SetY(255);
		$pdf->SetX(140);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(30,7,iconv( 'UTF-8','TIS-620','_____________'),0,0,"R");
		
		$pdf->SetY(255.5);
		$pdf->SetX(140);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(30,7,iconv( 'UTF-8','TIS-620','_____________'),0,0,"R");
	}
	
	if($row['hold_tax'] != "0")
	{
		$pdf->SetY(202);
		$pdf->Cell(90,32,'',1);
		
		$pdf->SetFillColor(0,0,0);	//สีกรอบ fill
		$pdf->SetTextColor(255,0,0); 		//สีตัวอักษร
		
		$pdf->SetY(202);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(90,7,iconv( 'UTF-8','TIS-620','ออกหนังสือหัก ณ ที่จ่ายในนาม'),0,0,"C",true);
		
		$pdf->SetTextColor(0,0,0); 
		$pdf->SetY(209);
		$pdf->SetFont('angsa','',13);
		$pdf->Cell(90,7,iconv( 'UTF-8','TIS-620',$row['name_print']),0,0,"C");
		
		$pdf->SetY(214);
		$pdf->SetFont('angsa','',13);
		$pdf->Cell(90,7,iconv( 'UTF-8','TIS-620',$row['add_namecom']),0,0,"C");
		
		$pdf->SetY(219);
		$pdf->SetFont('angsa','',13);
		$pdf->Cell(90,7,iconv( 'UTF-8','TIS-620',$row['add_namecom2']),0,0,"C");
		
		$pdf->Line(10,226.5,100,226.5);
		
		$pdf->SetY(227);
		$pdf->SetFont('angsa','',13);
		$pdf->Cell(90,7,iconv( 'UTF-8','TIS-620','เลขประจำตัวผู้เสียภาษี : '.$row['tax_id']),0,0,"C");
		
		$pdf->Image("../images/arrow_D.png",50,234,10,0);
		
		$pdf->SetY(244);
		$pdf->Cell(90,30,'',1);
		
		$pdf->SetY(245);
		$pdf->SetFont('angsa','BU',16);
		$pdf->Cell(90,7,iconv( 'UTF-8','TIS-620','จัดส่ง'),0,0,"L");
		
		$pdf->SetY(248);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(90,7,iconv( 'UTF-8','TIS-620','บริษัท โฟร์ อินชัวร์ โบรกเกอร์ จำกัด'),0,0,"C");
		
		$pdf->SetY(254);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(90,7,iconv( 'UTF-8','TIS-620','62/11-12 ม.1 ถนนราชพฤกษ์ ต.อ้อมเกร็ด อ.ปากเกร็ด'),0,0,"C");
		
		$pdf->SetY(259);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(90,7,iconv( 'UTF-8','TIS-620','จ.นนทบุรี 11120'),0,0,"C");
		
		$pdf->Line(10,266,100,266);
		
		$pdf->SetY(267.5);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(90,7,iconv( 'UTF-8','TIS-620','เลขประจำตัวผู้เสียภาษี : 0125551001457'),0,0,"C");
	}


	$pdf->SetY(280);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','บริษัทขอสงวนสิทธิ์ ในการเสนออัตราเบี้ยประกันภัยและคุ้มครองดังกล่าว จนถึงวันที่ '.thaiDate($row['send_date']).' (นับจากวันเสนอ 30 วัน)'),0,1,"L");


	$pdf->SetY(289);
	$pdf->SetX(146);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(38,0,iconv( 'UTF-8','TIS-620',$row['title_sub']." ".$row['branch']),0,1,"C");
	
	$pdf->SetY(290);
	$pdf->SetX(120);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ยืนยันการทำกรมธรรม์ : ..............................................'),0);



$pdf->Output();

mysql_close(); 
?>

