<?php
include "../pages/check-ses.php"; 
include('../fpdf.php');
include "../../inc/connectdbs.pdo.php";
//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php

function thaiDate($datetime)
{
	list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
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

function thaiDate2($datetime)
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

$querycontact = "SELECT emp_namerenew,emp_telrenew,emp_faxrenew,emp_emailrenew FROM tb_customer WHERE user = '".$_SESSION["strUser"]."'";
$objQuerycontact = mysql_query($querycontact) or die ("Error Query [".$querycontact."]");
$rowcontact = mysql_fetch_array($objQuerycontact);

$IDDATA = $_GET['IDDATA'];
$detail_id = $_GET['detail_id'];

$query = "SELECT * FROM detail_renew "; 
$query .= "INNER JOIN data ON (detail_renew.id_data = data.id_data) ";
$query .= "INNER JOIN detail ON (detail_renew.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (detail_renew.id_data = insuree.id_data) ";
$query .= "WHERE detail_renew.id_data = '".$IDDATA."' AND detail_renew.id_detail = '".$detail_id."' ";
$objQuery = mysql_query($query) or die ("Error Query [".$query."]");

$row = mysql_fetch_array($objQuery);

$new_detail = explode("|",$row['detailcost']);

$address_pdf = '';
if($row['group'] !="-" && $row['group'] !="")
{
	$address_pdf = " หมู่ ".$row['group'];
}
if($row['town'] !="-" && $row['town'] !="")
{
	$address_pdf .= " หมู่บ้าน/อาคาร ".$row['town'];
}
if($row['lane'] !="-" && $row['lane'] !="")
{
	$address_pdf .= " ซอย ".$row['lane'];
}
if($row['road'] !="-" && $row['road'] !="")
{
	$address_pdf .= " ถนน ".$row['road'];
}

if($row['province'] != "102")
{
	$address_pdf2 = 'ต.'.$_SESSION["Tum"][$row['tumbon']].' อ.'.$_SESSION["Amp"][$row['amphur']];
	$address_pdf3 = 'จ.'.$_SESSION["Pro"][$row['province']];
}
else
{
	$address_pdf2 = 'แขวง'.$_SESSION["Tum"][$row['tumbon']].' เขต'.$_SESSION["Amp"][$row['amphur']];
	$address_pdf3 = $_SESSION["Pro"][$row['province']];
}

if($row['car_id']==110)
{
	if($row['detail_doc_type'] == '' || $row['detail_doc_type'] == '1')
	{
		$act_cost = '645.21';
		$pa1='1,000,000';
		$pa2='5,000,000';
		
		if($new_detail[1] != 'S_Rate')
		{
			if($new_detail[12] == '1')
			{
				$pa3='500,000';
				$pa4='500,000';
				$pa5='500,000';
				$pa6='500,000';
			}
			else
			{
				$pa3='200,000';
				$pa4='200,000';
				$pa5='200,000';
				$pa6='200,000';
			}
		}
		else
		{
			$pa3='200,000';
			$pa4='200,000';
			$pa5='200,000';
			$pa6='200,000';
		}
		
		$seat='6';
	}
	else if($row['detail_doc_type'] == '2+')
	{
		$act_cost = '645.21';
		$pa1='300,000';
		$pa2='1,000,000';
		$pa3='50,000';
		$pa4='50,000';
		$pa5='20,000';
		$pa6='20,000';
		$seat='6';
	}
	else if($row['detail_doc_type'] == '2+')
	{
		$act_cost = '645.21';
		$pa1='300,000';
		$pa2='1,000,000';
		$pa3='50,000';
		$pa4='50,000';
		$pa5='20,000';
		$pa6='20,000';
		$seat='6';
	}
}
else if($row['car_id']==320)
{
	if($row['detail_doc_type'] == '' || $row['detail_doc_type'] == '1')
	{
		$act_cost = '967.28';
		$pa1='300,000';
		$pa2='1,000,000';
		$pa3='200,000';
		$pa4='200,000';
		$pa5='50,000';
		$pa6='200,000';
		$seat='2';
	}
	else if($row['detail_doc_type'] == '2+')
	{
		$act_cost = '645.21';
		$pa1='300,000';
		$pa2='1,000,000';
		$pa3='50,000';
		$pa4='50,000';
		$pa5='20,000';
		$pa6='20,000';
		$seat='6';
	}
	else if($row['detail_doc_type'] == '2+')
	{
		$act_cost = '645.21';
		$pa1='300,000';
		$pa2='1,000,000';
		$pa3='50,000';
		$pa4='50,000';
		$pa5='20,000';
		$pa6='20,000';
		$seat='6';
	}
}

if($new_detail[12] == '1')
{
	$service = 'ซ่อมห้าง';
}
else
{
	$service = 'ซ่อมอู่';
}

	define('FPDF_FONTPATH','font/');

	$pdf=new FPDF();
	$pdf->AddPage();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');
	
	$pdf->Image('../images/als_3.jpg',0,0,210);
	$pdf->Image('../images/suzuki_logo.png',4,0,50);
	
	$pdf->SetY(7);
	$pdf->SetX(123);
	$pdf->SetFont('angsa','B',28);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','ใบเสนอราคา'),0,0,'R');
	
	$pdf->SetFont('angsa','B',14);
	$pdf->SetY(30);
	$pdf->SetX(20);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['title'].' '.$row['name'].' '.$row['last']),0,0,'L');
	$pdf->SetY(36);
	$pdf->SetX(20);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['add'].' '.$address_pdf),0,0,'L');
	$pdf->SetY(42);
	$pdf->SetX(20);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$address_pdf2),0,0,'L');
	$pdf->SetY(48);
	$pdf->SetX(20);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$address_pdf3.' '.$row['postal']),0,0,'L');
	$pdf->SetFont('angsa','B',13);
	$pdf->SetY(79);
	$pdf->SetX(8);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','แจ้งชำระเบี้ยประกันภัยและสอบถาม คุณ '.$rowcontact['emp_namerenew'].' โทร. : '.$rowcontact['emp_telrenew'].' แฟกซ์ : '.$rowcontact['emp_faxrenew'].' E-mail : '.$rowcontact['emp_emailrenew']),0,1,'L');
	$pdf->SetX(8);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','บริษัทขอสงวนสิทธิ์ ในการเสนออัตราเบี้ยประกันภัยและคุ้มครองดังกล่าว จนถึงวันที่ '.thaiDate2($row['date_detail']).' (นับจากวันเสนอ 30 วัน)'),0,0,'L');
	$pdf->SetY(97);
	$pdf->SetX(8);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','ประเภทการซ่อม : '.$service),0,1,'L');
	$pdf->SetFont('angsa','B',14);
	$pdf->SetY(104);
	$pdf->SetX(75);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',"หมายเหตุ : ".$row['login']),0,0,'L');
	$pdf->SetY(104);
	$pdf->SetX(33);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['id_data']),0,0,'L');
	$pdf->SetY(110);
	$pdf->SetX(30);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',thaiDate($row['end_date'])),0,0,'L');
	$pdf->SetY(110);
	$pdf->SetX(80);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['car_regis']),0,0,'L');
	$pdf->SetY(116);
	$pdf->SetX(30);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','Mitsubishi'),0,0,'L');
	$pdf->SetY(122);
	$pdf->SetX(30);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['car_body'].'      ทุน '.number_format($new_detail[0],0)),0,0,'L');
	$pdf->SetY(131);
	$pdf->SetX(75);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',number_format($new_detail[10],2)),0,0,'L');
	$pdf->SetY(140);
	$pdf->SetX(75);
		$act_cost=$new_detail[9];
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','     '.number_format($act_cost,2)),0,0,'L');
	$pdf->SetY(149);
	$pdf->SetX(75);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',number_format($new_detail[8],2)),0,0,'L');
	$pdf->SetY(116);
	$pdf->SetX(70);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$_SESSION["MoC"][$row['mo_car']]),0,0,'L');
	$pdf->SetY(110);
	$pdf->SetX(165);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa1),0,0,'R');
	$pdf->SetY(116);
	$pdf->SetX(165);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa2),0,0,'R');
	$pdf->SetY(133);
	$pdf->SetX(165);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa3),0,0,'R');
	$pdf->SetY(139);
	$pdf->SetX(165);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa4),0,0,'R');
	$pdf->SetY(139);
	$pdf->SetX(115);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$seat),0,0,'R');
	$pdf->SetY(145);
	$pdf->SetX(165);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa5),0,0,'R');
	$pdf->SetY(151);
	$pdf->SetX(165);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa6),0,0,'R');
	
	$pdf->SetY(214);
	$pdf->SetX(147);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['title'].' '.$row['name'].' '.$row['last']),0,0,'L');

	

	$pdf->SetY(220);
	$pdf->SetX(166);

if($row['com_data']=='VIB_S')
{
	$code = '103';
}
else if($row['com_data']=='VIB_C'){
	$code = '113';
}
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','08829 '.substr(thaiDate($row['end_date']),9,10).' '.$code.' '.date('m',strtotime($row['renew_end'])).substr($row['renew_id'],15,4)),0,0,'L');

	$pdf->SetY(226);
	$pdf->SetX(166);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['car_regis']),0,0,'L');

	$pdf->Output();




	//echo $query;
mysql_close(); ?>
