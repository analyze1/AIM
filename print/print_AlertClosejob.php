<?php
	include "../pages/check-ses.php"; 
	//include "../inc/checksession.inc.php";
	include "../inc/connectdbs.inc.php"; 
	
	require('../fpdf.php');
	
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

	$IDDATA = $_GET['id'];
	
	$query = "SELECT *,detail_renew.id_data AS IdS FROM data ";
	$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
	$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
	$query .= "INNER JOIN insuree ON (data.id_data = insuree.id_data) ";
	$query .= "INNER JOIN detail_renew ON (data.id_data = detail_renew.id_data) ";
	$query .= " WHERE  data.id_data ='$IDDATA' AND lastrenew='1'  ";
	//echo $query;
	mysql_select_db($db1,$cndb1);
	$objQuery = mysql_query($query,$cndb1) or die ("Error Query [".$query."]");
	
	$row = mysql_fetch_array($objQuery);

	$query_detailrenew = "SELECT * FROM  detail_renew where  id_data='".$row["id_data"]."' order by id_detail desc limit 1";
	mysql_select_db($db1,$cndb1);
	$objQuery_detailrenew = mysql_query( $query_detailrenew ,$cndb1);
	$row_Drenew = mysql_fetch_array( $objQuery_detailrenew );
	
	$query_user = "SELECT * FROM  user where  user_user='".$row_Drenew["userdetail"]."' ";
	mysql_select_db($db2,$cndb2);
	$objQuery_user = mysql_query( $query_user ,$cndb2);
	$row_user = mysql_fetch_array( $objQuery_user );
	
	$query_userHR = "SELECT * FROM  employee where  ID_EMP='".$row_user["user_emp"]."' ";
	mysql_select_db($db_hr,$cndb_hr);
	$objQuery_userHR = mysql_query( $query_userHR ,$cndb_hr);
	$row_userHR = mysql_fetch_array( $objQuery_userHR);
	
	$query_regis_pro = "SELECT * FROM  tb_province where  id='".$row["car_regis_pro"]."' ";
	mysql_select_db($db1,$cndb1);
	$objQuery_regis_pro = mysql_query( $query_regis_pro ,$cndb1);
	$row_regisPro = mysql_fetch_array( $objQuery_regis_pro);
	
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
	
list($det_date,$detail_time) = split(' ',$row_Drenew['date_detail']); // แยกวันที่ กับ เวลาออกจากกัน

	
	define('FPDF_FONTPATH','font/');

	$pdf=new FPDF();
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');
	
	$pdf->Image('../images/remind_new_2559.jpg',0,0,210);
	
	$new_edate = explode("-",$row['end_date']);
	
	//แยก detailcost ออกจากกัน
	$type = split("\|",$row['detailcost']);
	$se_protection = "SELECT * FROM tb_protection WHERE type = '$type[1]'";
	$proQuery = mysql_query($se_protection,$cndb1) or die ("Error Query [".$se_protection."]");
	$pro_array = mysql_fetch_array($proQuery);
	// รายละเอียด detailcost
	$new_detailcost = split("\|",$row_Drenew['detailcost']);
	
	if($row['car_id']==110)
	{
		if($new_detailcost[12] == '2'){
			$act_cost = '645.21';
			$pa1=$pro_array['life'];
			$pa2=$pro_array['asset'];
			$pa3=$pro_array['driver'];
			$pa4=$pro_array['passenger'];
			$pa5=$pro_array['nurse'];
			$pa6=$pro_array['insuran'];
			$seat=$pro_array['tickets'];
			$service = 'ซ่อมอู่มาตราฐาน';
		}else if($new_detailcost[12] == '1'){
			$act_cost = '645.21';
			$pa1=$pro_array['life'];
			$pa2=$pro_array['asset'];
			$pa3=$pro_array['driver'];
			$pa4=$pro_array['passenger'];
			$pa5=$pro_array['nurse'];
			$pa6=$pro_array['insuran'];
			$seat=$pro_array['tickets'];
			$service = 'ซ่อมศูนย์ Mitsubishi';
		}
	}
	else if($row['car_id']==320)
	{
		$act_cost = '967.28';
		$pa1=$pro_array['life'];
			$pa2=$pro_array['asset'];
			$pa3=$pro_array['driver'];
			$pa4=$pro_array['passenger'];
			$pa5=$pro_array['nurse'];
			$pa6=$pro_array['insuran'];
			$seat=$pro_array['tickets'];
	}
	else if($row['car_id']==220)
	{
		$act_cost = '967.28';
		$pa1=$pro_array['life'];
			$pa2=$pro_array['asset'];
			$pa3=$pro_array['driver'];
			$pa4=$pro_array['passenger'];
			$pa5=$pro_array['nurse'];
			$pa6=$pro_array['insuran'];
			$seat=$pro_array['tickets'];
	}

	
	//print_r($new_detailcost);
	////////////////////////////////////////////////////////////////////////////////////////////
	// เบี้ยสุทธิ
	$sum_pre = $new_detailcost[10]-$new_detailcost[5]-$new_detailcost[7]-$new_detailcost[3];
	
	// อากร
	$sum_pre_duty = ceil(($sum_pre*0.004));
	//ภาษี
	$sum_pre_vat = round(($sum_pre+$sum_pre_duty)*0.07,2);
	
	if($row['userdetail'] == 'DEALER')
	{
		$sum_pretotal = $new_detailcost[10];
	}
	else
	{
		// รวม
		$sum_pretotal = $sum_pre + $sum_pre_duty + $sum_pre_vat;
	}

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
	
	if($row['userdetail'] == 'DEALER')
	{
	$pdf->SetY(6);
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',25);
	$pdf->Cell(66,6,iconv('UTF-8','TIS-620',$row['name_inform']),0,1,'R');
	}
	else
	{
	$pdf->SetY(6);
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',25);
	$pdf->Cell(66,6,iconv('UTF-8','TIS-620','บริษัท โฟร์ อินชัวร์ โบรกเกอร์ จำกัด'),0,1,'R');
	}
	
	$pdf->SetY(53);
	$pdf->SetX(120);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(66,6,iconv('UTF-8','TIS-620','แจ้งชำระเบี้ยประกันภัยและสอบถาม คุณ '.$row_userHR['Nick_Name']),0,1,'C');
	
	$pdf->SetX(120);
	$pdf->Cell(66,5,iconv('UTF-8','TIS-620','โทร. : 021968234 แฟกซ์. : 021968235 Email : '.$row_user['email']),0,1,'C');
	
	$pdf->SetY(68);
	$pdf->SetX(120);
	$pdf->Cell(66,5,iconv('UTF-8','TIS-620',"บริษัทขอสงวนสิทธ์ในการเสนออัตราเบี้ยประกันภัยยและคุ้มครองดังกล่าว"),0,1,'C');
	
	list($de_date,$de_time) = split(' ',$row_Drenew['date_detail']);
	$date_up = date("d/m/Y",strtotime($de_date."+30 day"));
	list($day,$month,$year) = split('/',$date_up);
	$date_thai=$day.'/'.$month.'/'.($year+543);
	
	
	
	$pdf->SetX(120);
	$pdf->Cell(66,5,iconv('UTF-8','TIS-620',"จนถึงวันที่ ".$date_thai." (นับจากวันเสนอ 30 วัน)"),0,0,'C');
	
	$pdf->SetY(90.5);
	$pdf->SetX(29);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['id_data']),0,0,'L');
	
	
	
	$pdf->SetY(95.5);
	$pdf->SetX(25);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['car_regis'].' '.$row_regisPro['name_mini']),0,0,'L');
	
	$pdf->SetY(100.5);
	$pdf->SetX(25);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','Mitsubishi'),0,0,'L');
	
	$pdf->SetY(105.5);
	$pdf->SetX(13);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',number_format($new_detailcost[0],0)),0,0,'L');
	
	$pdf->SetY(113);
	$pdf->SetX(73);
	$pdf->Cell(17,5,iconv('UTF-8','TIS-620',number_format($sum_pretotal,2)),0,0,'R');
	
	$pdf->SetY(121);
	$pdf->SetX(73);
	$pdf->Cell(17,5,iconv('UTF-8','TIS-620',number_format($new_detailcost[9],2)),0,0,'R');
	
	//add_on โจรกรรม
	
	$chip=0;
	if($row['add_on']=='Y')
	{
	$pdf->Image('../images/assasin.jpg',5,140,99,20);
	$chip=430;
	}
	else
	{
	$chip=0;
	}
	
	$pdf->SetY(129);
	$pdf->SetX(73);
	$pdf->Cell(17,5,iconv('UTF-8','TIS-620',number_format($new_detailcost[8]+=$chip,2)),0,0,'R');
	
	$pdf->SetY(100.5);
	$pdf->SetX(63);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$_SESSION["MoC"]['name'][$row['mo_car']]),0,0,'L');
	
	$pdf->SetY(95.5);
	$pdf->SetX(165);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa1),0,0,'R');
	
	$pdf->SetY(100.5);
	$pdf->SetX(165);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa2),0,0,'R');
	
	$pdf->SetY(115.5);
	$pdf->SetX(165);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa3),0,0,'R');
	
	$pdf->SetY(121);
	$pdf->SetX(165);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa4),0,0,'R');
	
	$pdf->SetY(121);
	$pdf->SetX(115);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$seat),0,0,'R');
	
	$pdf->SetY(126);
	$pdf->SetX(165);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa5),0,0,'R');
	
	$pdf->SetY(131);
	$pdf->SetX(165);
	$pdf->Cell(20,5,iconv('UTF-8','TIS-620',$pa6),0,0,'R');
	
	$pdf->SetY(230);
	$pdf->SetX(147);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['title'].' '.$row['name'].' '.$row['last']),0,0,'L');

	$pdf->SetY(236.5);
	$pdf->SetX(166);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620','08829 '.substr(thaiDate($row['end_date']),9,10).' 113 '.substr($row['id_data'],13,6)),0,0,'L');

	$pdf->SetY(242);
	$pdf->SetX(166);
	$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$row['car_regis'].' '.$_SESSION["Promn"][$row['car_regis_pro']]),0,0,'L');
	
	

	$pdf->Output();


	//echo $query;
mysql_close(); ?>
