<?php
include "../pages/check-ses.php"; 
//include "../inc/checksession.inc.php";
include "../inc/connectdbs.inc.php"; 

	$IDDATA = $_GET['id'];

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

$costOb = $_SESSION["Cost"]; // ทุนเพิ่ม
$costObname = $_SESSION["CostName"]; // ชื่อ อุปกรณ์ตกแต่งเพิ่มเติม
$Cost_PRE = $_SESSION["CostPre"]; // อัตราเบี้ย
$MoC = $_SESSION["MoC"]; // รุ่นรถ
$Pro3 = $_SESSION["Pro3"]; 

$dateYear=substr($_POST['txt_month'],0,4);
$dateMonth=substr($_POST['txt_month'],5,2);

$query = "SELECT * FROM data ";
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "INNER JOIN req ON (data.id_data  = req.id_data) ";
$query .= "WHERE  data.id_data = '".$IDDATA."'";
mysql_select_db($db1,$cndb1);
$objQuery = mysql_query($query,$cndb1) or die ("Error Query [".$query."]");

require('../fpdf.php');
define('FPDF_FONTPATH','font/');

	$pdf=new FPDF();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');
	$pdf->SetFont('angsa','B',14);
	
$date_end=date('Y');
while($row = mysql_fetch_array($objQuery))
{
	$address_pdf = '';
	$address_pdf3 = '';
	$address_pdf2 = '';
	$address_pdf4 = '';
	
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
		$address_pdf4 .= "ซอย ".$row['lane']." ";
	}
	if($row['road'] !="-" && $row['road'] !="")
	{
		$address_pdf4 .= "ถนน ".$row['road'];
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
		$act_cost = '645.21';
		$pa1='1,000,000';
		$pa2='5,000,000';
		$pa3='200,000';
		$pa4='200,000';
		$pa5='200,000';
		$pa6='200,000';
		$seat='6';
	}
	else if($row['car_id']==320)
	{
		$act_cost = '967.28';
		$pa1='300,000';
		$pa2='1,000,000';
		$pa3='50,000';
		$pa4='50,000';
		$pa5='50,000';
		$pa6='200,000';
		$seat='2';
	}
	/*
	/////////////////////////////////////คำนวนทุนต่ออายุ
	$costW = explode(",",substr($Cost_PRE['PreCost'][$row['costCost']],0,7));
	$CalculaCost = $costW[0].$costW[1];
	if($CalculaCost>370000)
	{
		$ResultCost = $CalculaCost*95/100-10000;
	}
	else if($CalculaCost<=370000)
	{
		$ResultCost = $CalculaCost*90/100;
	}
		
	$ResultCost = $ResultCost+$row['price_total'];
	$Cost_NEW = ceil($ResultCost/10000)*10000;
	
	if($Cost_NEW >= '550000' AND $row['mo_car'] == '1951')
	{
		$Cost_NEW = '550000';
		$Net_NEW = $Renew[$_SESSION["MoCd"][$row['mo_car']]][$Cost_NEW];
	}
	
	$Net_NEW = $Renew[$_SESSION["MoCd"][$row['mo_car']]][$Cost_NEW];
	$Net_NEW10 = $Net_NEW-($Net_NEW*10/100);
	$Net_NEW20 = $Net_NEW10-($Net_NEW10*20/100);
	//////////////////////////////////////////
	*/
	
	/////////////////////////////////////คำนวนทุนต่ออายุ new
	
	// ทุนต่ออายุ
	$costW = explode(",",substr($Cost_PRE['PreCost'][$row['costCost']],0,7));
	$CalculaCost = $costW[0].$costW[1];
	
	if($row['mo_car'] == '1964')
	{
		// บวก ตกแต่งเพิ่มเติม
		if($row['EditProduct'] == 'Y')
		{
			$ResultCost = ($CalculaCost+$row['TotalProduct'])-60000; 
		}
		else
		{
			$ResultCost = ($CalculaCost+$row['price_total'])-60000; 
		}
	}
	else
	{
		// บวก ตกแต่งเพิ่มเติม
		if($row['EditProduct'] == 'Y')
		{
			$ResultCost = ($CalculaCost+$row['TotalProduct'])-30000; 
		}
		else
		{
			$ResultCost = ($CalculaCost+$row['price_total'])-30000; 
		}
	}
	//  ERTIGA
	$dateY=substr($row['end_date'],0,4);
	$dateM=substr($row['end_date'],5,2);
	$changeCode = $dateY.$dateM;
    if($changeCode<=201704){
	if($row['mo_car'] == '1960')
	{
		$queryCostrenew = "SELECT * FROM UCostRenew  WHERE service = '2' AND type = 'S_Rate' AND mo_car = '1960' AND cost = '".$ResultCost."' ";
		mysql_select_db($db1,$cndb1);
		$objQueryRenew = mysql_query($queryCostrenew,$cndb1) or die ("Error Query [".$queryCostrenew."]");
		$rowRenew = mysql_fetch_array($objQueryRenew);
	}
	// SWIFT ECO CELERIO SWIFT RX SWIFT DUO
	else if($row['mo_car'] == '1951' || $row['mo_car'] == '1964' || $row['mo_car'] == '1967' || $row['mo_car'] == '1968' || $row['mo_car'] == '1969')
	{
		$queryCostrenew = "SELECT * FROM UCostRenew  WHERE service = '2' AND type = 'S_Rate' AND mo_car = '' AND cost = '".$ResultCost."' ";
		mysql_select_db($db1,$cndb1);
		$objQueryRenew = mysql_query($queryCostrenew,$cndb1) or die ("Error Query [".$queryCostrenew."]");
		$rowRenew = mysql_fetch_array($objQueryRenew);
	}
	// carry
	else if($row['mo_car'] == '1098')
	{
		$queryCostrenew = "SELECT * FROM UCostRenew  WHERE type = 'AS2' AND cost = '".$ResultCost."' ";
		mysql_select_db($db1,$cndb1);
		$objQueryRenew = mysql_query($queryCostrenew,$cndb1) or die ("Error Query [".$queryCostrenew."]");
		$rowRenew = mysql_fetch_array($objQueryRenew);
	}
	
	$Total_cost = $rowRenew['pre'];
	
	if($row['mo_car'] == '1098')
	{
		$Net_NEW10 = round(($Total_cost*10/100));
		$Net_NEW20 = round((($rowRenew['pre'] - $Net_NEW10)*20/100));
	}
	else
	{
		$Net_NEW10 = round(($Total_cost*10/100));
		$Net_NEW20 = round((($rowRenew['pre'] - $Net_NEW10)*25/100));
	}
		$Net_NEW10 = '0.00';
		$Net_NEW20 = '0.00';
	$rservice= $rowRenew['service'];
	}else{  //ตั้งแต่เดือน 5 2017เป็นต้นไป
	$dateY=date('Y');
	if($row['com_data']=='VIB_F'){
    			$compDT = 'VIB_S';
    	}else{
    			$compDT = $row['com_data'];
    	}
        $carold=$dateY-$row['regis_date']+1;
        $sqlcost="SELECT * FROM tb_cost WHERE car_id = '".$row['car_id']."' AND comp = '".$compDT."' AND car_old = '".$carold."' AND cost = '".$ResultCost."' AND  date_expired >= '".date('Y-m-d')."' AND used_suzuki IN ('R','A')";
        mysql_select_db($db2,$cndb2);
        $rescost=mysql_query($sqlcost,$cndb2);
        $arrcost=mysql_fetch_array($rescost);
        $Total_cost = $arrcost['pre'];

        $Net_NEW10 ='0.00';
        $Net_NEW20 ='0.00';
        $rservice = $arrcost[repair];
    }
	$servicename = '';
    if($rservice=='1'){
        $servicename = '(ซ่อมห้าง)';
    }else if($rservice=='2'){
        $servicename = '(ซ่อมอู่)';
    }
	$pre_new = $Total_cost-($Net_NEW10+$Net_NEW20);
	$stamp_new = ceil($pre_new*0.004);
	$tax_new = round(($pre_new + $stamp_new)*0.07,2);
	$total_pre = $pre_new + $stamp_new + $tax_new;
	//////////////////////////////////////////
	
	$pdf->AddPage();
	
	$pdf->Image('../images/remind_new_2559.jpg',0,0,210);
		
	$pdf->SetY(6);
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',25);
	$strname="";
	if($_SESSION['strName']=='admin' || $_SESSION['claim']=='ADMIN')
	{
		$strname="บริษัท โฟร์ อินชัวร์ โบรกเกอร์ จำกัด";
	}
	else
	{
		$strname=$_SESSION["strName"];
	}
	$pdf->Cell(66,6,iconv('UTF-8','TIS-620',$strname),0,1,'R');
	
	$pdf->SetFont('angsa','B',14);
		  
		  
		  $pdf->SetY(91);
	$pdf->SetX(66);
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(35,8,iconv('UTF-8','TIS-620','วันหมดอายุ '.thaiDate($row['end_date'])),1,0,'C',true);
	
	$pdf->SetTextColor(0,0,0);
		  
		  
	$pdf->SetY(35);
	$pdf->SetX(20);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['title'].' '.$row['name'].' '.$row['last']),0,0,'L');
	
	$pdf->SetY(41);
	$pdf->SetX(20);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['add'].' '.$address_pdf),0,0,'L');
	
	if($address_pdf4 !='')
	{
		$pdf->SetY(47);
		$pdf->SetX(20);
		$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$address_pdf4),0,0,'L');
		
		$pdf->SetY(53);
		$pdf->SetX(20);
		$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$address_pdf2),0,0,'L');
		
		$pdf->SetY(59);
		$pdf->SetX(20);
		$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$address_pdf3.' '.$row['postal']),0,0,'L');
	}
	else
	{
	$pdf->SetY(47);
	$pdf->SetX(20);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$address_pdf2),0,0,'L');
	
	$pdf->SetY(53);
	$pdf->SetX(20);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$address_pdf3.' '.$row['postal']),0,0,'L');
	}
	
	/*
	$pdf->SetFont('angsa','B',20);
	$pdf->SetY(79);
	$pdf->SetX(62);
	//$pdf->Cell(0,5,iconv('UTF-8','TIS-620',date('m',strtotime($row['end_date'])).substr($row['renew_id'],15,4)),0,0,'L');
	
	$pdf->SetFont('angsa','',13);
	$pdf->SetY(62);
	$pdf->SetX(120);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','แจ้งชำระเบี้ยประกันภัยและสอบถาม คุณ '.$rowcontact['emp_namerenew']),0,1,'C');
	$pdf->SetY(66);
	$pdf->SetX(120);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',' โทร. : 0891200869 แฟกซ์ : - E-mail : '.$rowcontact['emp_emailrenew']),0,1,'C');
	$pdf->SetY(72);
	$pdf->SetX(120);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','บริษัทขอสงวนสิทธิ์ ในการเสนออัตราเบี้ยประกันภัยและคุ้มครองดังกล่าว'),0,0,'C');
	
	
	list($date_up,$clock_up) = split(' ',$row['date_detail']); //แยกวันกับเวลาออกจากกัน
	$date_check = date('d/m/Y',strtotime($date_up."+30 day")); //เพิ่มวันไปอีก 30 วัน
	list($day,$month,$year) = split('/',$date_check); //แยกวันเดือนปีออกจากกัน
	$date_edit = $day.'/'.$month.'/'.($year+543); //บวกปี อีก 543
	
	$pdf->SetY(76);
	$pdf->SetX(120);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','จนถึงวันที่ '.$date_edit.' (นับจากวันเสนอ 30 วัน)'),0,0,'C');
	*/
	
	$pdf->SetFont('angsa','B',14);
	
	if($row['n_insure'] != ''){ $id_data = $row['n_insure']; }else{ $id_data = $row['id_data']; }
	
	$pdf->SetY(90);
	$pdf->SetX(30);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$id_data),0,0,'L');
	
	$pdf->SetY(91);
	$pdf->SetX(66);
	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(35,8,iconv('UTF-8','TIS-620','วันหมดอายุ '.thaiDate($row['end_date'])),1,0,'C',true);
	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetY(95);
	$pdf->SetX(26);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['car_regis'].' '.$Pro3["name_mini"][$row['car_regis_pro']]),0,0,'L');
	
	$pdf->SetY(100);
	$pdf->SetX(26);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','Mitsubishi'),0,0,'L');
	
	$pdf->SetX(64);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$MoC['name'][$row['mo_car']]),0,0,'L');

	$pdf->SetY(105);
	$pdf->SetX(26);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',number_format($ResultCost,0)."          ".$servicename),0,0,'L');
	
	$pdf->SetY(112);
	$pdf->SetX(67);
	$pdf->Cell(20,6.5,iconv('UTF-8','TIS-620',number_format($total_pre,2)),0,0,'R');
	
	$pdf->SetY(120.5);
	$pdf->SetX(67);	
	$pdf->Cell(20,6.5,iconv('UTF-8','TIS-620',number_format($act_cost,2)),0,0,'R');
	
	$pdf->SetY(129);
	$pdf->SetX(67);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620',number_format($total_pre+$act_cost,2)),0,0,'R');
	
	$installments = $total_pre+$act_cost;
	
	/*// ราคาผ่อน 3 งวด ///////////////////////////
	$pdf->SetFont('angsa','B',16);
	$pdf->SetY(148);
	$pdf->SetX(68);
	$pdf->Cell(25,6,iconv('UTF-8','TIS-620',number_format($installments/3,2)),0,0,'C');
	////////////////////////////////////////////
	*/
	//ความเสียหาย ความรับผิดชอบ
	$pdf->SetFont('angsa','B',14);
	$pdf->SetY(95.5);
	$pdf->SetX(170);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa1),0,0,'R');
	
	$pdf->SetY(100.5);
	$pdf->SetX(170);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa2),0,0,'R');
	
	$pdf->SetY(116);
	$pdf->SetX(170);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa3),0,0,'R');
	
	$pdf->SetY(121);
	$pdf->SetX(170);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa4),0,0,'R');
	
	$pdf->SetX(113);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$seat),0,0,'R');
	
	$pdf->SetY(126);
	$pdf->SetX(170);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa5),0,0,'R');
	
	$pdf->SetY(131);
	$pdf->SetX(170);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa6),0,0,'R');
	/////////////////////////////////////
	
	$pdf->SetY(230); //$pdf->SetY(234); 224 228
	$pdf->SetX(150.5);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['title'].' '.$row['name'].' '.$row['last']),0,0,'L');
	
	$pdf->SetFont('angsa','B',14);
	$pdf->SetY(236); //$pdf->SetY(240); 230 234
	$pdf->SetX(169);

	if($row['com_data']=='VIB_S')
	{
		$code = '113';
	}
	else if($row['com_data']=='VIB_C' || $row['com_data']=='VIB_F')
	{
		$code = '113';
	}
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','08829 '.substr(thaiDate($row['end_date']),9,10).' '.$code.' '.substr($row['id_data'],13,6)),0,0,'L');

	$pdf->SetY(241.5);//$pdf->SetY(245.5); 235.5 239.5
	$pdf->SetX(169); 
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['car_regis'].' '.$Pro3["name_mini"][$row['regis_pro']]),0,0,'L');
}
	$pdf->Output(iconv( 'UTF-8','TIS-620',$row['title'].' '.$row['name'].' '.$row['last'].'.pdf'),'I');

mysql_close(); 
?>

