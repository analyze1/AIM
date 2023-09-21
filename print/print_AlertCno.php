<?php
include "../pages/check-ses.php";
include('../fpdf.php');
include "../../inc/connectdbs.pdo.php";

function thaiDate($datetime) {
list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
$Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.

switch($m) {
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

$queryCostrenew = "SELECT * FROM UCostRenew";
$objQueryRenew = mysql_query($queryCostrenew) or die ("Error Query [".$queryCostrenew."]");
while($rowRenew = mysql_fetch_array($objQueryRenew)) {
	$Renew[$rowRenew['type']][$rowRenew['cost']] = $rowRenew['pre'];
	$RenewCost[$rowRenew['type']][$rowRenew['cost']] = $rowRenew['id'];
}

$query = "SELECT * ";


$query .= "FROM data ";
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN URenew ON (data.id_data = URenew.renew_id) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
//data.login='3000003' AND
$query .= "WHERE  YEAR(data.end_date) = '".intval(date('Y'),0)."' AND data.login = '3000003' AND MONTH(data.end_date) = '11'  ORDER BY data.end_date ASC ";
$objQuery = mysql_query($query) or die ("Error Query [".$query."]");


	define('FPDF_FONTPATH','font/');

	$pdf=new FPDF();
while($row = mysql_fetch_array($objQuery)) {
	$address_pdf='';
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

if($row['province'] != "102"){
	$address_pdf2 = 'ต.'.$_SESSION["Tum"][$row['tumbon']].' อ.'.$_SESSION["Amp"][$row['amphur']];
	$address_pdf3 = 'จ.'.$_SESSION["Pro"][$row['province']];
}
else{
	$address_pdf2 = 'แขวง'.$_SESSION["Tum"][$row['tumbon']].' เขต'.$_SESSION["Amp"][$row['amphur']];
	$address_pdf3 = $_SESSION["Pro"][$row['province']];
}


$address_add = $row['add']."|".$row['group']."|".$row['town']."|".$row['lane']."|".$row['road']."|".$row['tumbon']."|".$row['amphur']."|".$row['province']."|".$row['postal'];


if(number_format($row['cat_car'],0)==1){
	$act_cost = '645.21';
	$pa1='1,000,000';
	$pa2='5,000,000';
	$pa3='200,000';
	$pa4='200,000';
	$pa5='200,000';
	$pa6='200,000';
	$seat='6';
}
else if(number_format($row['cat_car'],0)==3){
	$act_cost = '967.28';
	$pa1='300,000';
	$pa2='1,000,000';
	$pa3='200,000';
	$pa4='200,000';
	$pa5='50,000';
	$pa6='200,000';
	$seat='2';
}
$yearF =  date('Y')-date('Y',strtotime($row['start_date']))+1;

$Pre='';

	$pdf->AddPage();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');
	$pdf->SetFont('angsa','B',14);
	$pdf->Image('../images/al.jpg',0,0,210);
	$Pre = $Renew[$_SESSION["MoCd"][$row['mo_car']]][$row['renew_cost']];
	$Pre = $Pre-round($Pre*10/100);
	$Pre = $Pre-round($Pre*20/100);
	$Pre = $Pre+ceil($Pre*0.4/100);
	$Pre = $Pre+($Pre*7/100);
	
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
	$pdf->SetFont('angsa','B',20);
	$pdf->SetY(79);
	$pdf->SetX(62);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',date('m',strtotime($row['start_date'])).substr($row['renew_id'],15,4)),0,0,'L');
	$pdf->SetFont('angsa','B',14);
	$pdf->SetY(104);
	$pdf->SetX(33);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','R'.$row['renew_id']),0,0,'L');
	$pdf->SetY(110);
	$pdf->SetX(30);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',thaiDate($row['end_date'])),0,0,'L');
	$pdf->SetY(110);
	$pdf->SetX(80);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['car_regis']),0,0,'L');
	$pdf->SetY(116);
	$pdf->SetX(30);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','SUZUKI'),0,0,'L');
		$pdf->SetY(122);
	$pdf->SetX(30);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['car_body'].'      ทุน '.number_format($row['renew_cost'],0)),0,0,'L');
	$pdf->SetY(131);
	$pdf->SetX(75);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',number_format($Pre,2)),0,0,'L');
	$pdf->SetY(140);
	$pdf->SetX(75);
	$act_cost=$row['renew_act'];
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','     '.number_format($act_cost,2)),0,0,'L');
	$pdf->SetY(149);
	$pdf->SetX(75);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',number_format($Pre+$act_cost-$row['renew_discountExtra'],2)),0,0,'L');
	$pdf->SetY(116);
	$pdf->SetX(70);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$_SESSION["MoC"][$row['renew_mo_car']]),0,0,'L');
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
if($row['renew_vib']=='VIB_S'){
	$code = '103';
}
else if($row['renew_vib']=='VIB_C'){
	$code = '113';
}
	$pdf->SetY(220);
	$pdf->SetX(166);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','08829 '.substr(thaiDate($row['start_date']),9,10).' '.$code.' '.date('m',strtotime($row['start_date'])).substr($row['renew_id'],15,4)),0,0,'L');

	$pdf->SetY(226);
	$pdf->SetX(166);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['car_regis']),0,0,'L');



}
	$pdf->Output(iconv( 'UTF-8','TIS-620',$row['title'].' '.$row['name'].' '.$row['last'].'.pdf'),'I');

	
	//echo $query;
mysql_close(); ?>
