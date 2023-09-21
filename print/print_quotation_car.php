<?php
	include "../pages/check-ses.php"; 
	include "../inc/connectdbs.inc.php";
	include('../fpdf.php');
	mysql_select_db($db1,$cndb1);
	$select_quotation_sql="SELECT tb_quotation_car.name,
	tb_quotation_car.tel_mobile,
	tb_quotation_car.login,
	tb_quotation_car.date_save,
	tb_quotation_car.q_auto,
	tb_quotation_car.car_total,
	tb_quotation_car.detail,
	tb_quotation_car.finance,
	tb_customer.address,
	tb_customer.title_sub,
	tb_customer.location,
	tb_customer.sub,
	tb_customer.emp_telrenew,
	tb_customer.emp_faxrenew,
	tb_customer.pay_tel,
	tb_customer.icard
	FROM tb_quotation_car
	LEFT JOIN tb_customer ON (tb_quotation_car.login = tb_customer.user)
	WHERE tb_quotation_car.q_auto = '".$_GET['q_auto']."' GROUP BY tb_customer.user ORDER BY tb_customer.id ASC";
	$select_quotation_query=mysql_query($select_quotation_sql,$cndb1);
	$select_quotation_array=mysql_fetch_array($select_quotation_query);
	$select_quotation_detail_sql="SELECT
	tb_quotation_detail_car.q_auto,
	tb_quotation_detail_car.id_br_car,
	tb_quotation_detail_car.id_mo_car,
	tb_quotation_detail_car.id_mo_car_sub,
	tb_quotation_detail_car.car_price,
	tb_quotation_detail_car.car_body,
	tb_quotation_detail_car.car_motor,
	tb_quotation_detail_car.car_regis_year,
	tb_quotation_detail_car.res_price,
	tb_quotation_detail_car.down_per,
	tb_quotation_detail_car.down_price,
	tb_quotation_detail_car.unit_year,
	tb_quotation_detail_car.interest_price,
	tb_quotation_detail_car.interest_total,
	tb_quotation_detail_car.top_price,
	tb_quotation_detail_car.total_price,
	tb_quotation_detail_car.unit_price,
	tb_quotation_detail_car.id_car_color,
	tb_quotation_detail_car.interest_per,
	tb_br_car.name As b_name,
	tb_mo_car.name As m_name,
	tb_mo_car_sub.name As s_name,
	tb_color.color_name
	FROM tb_quotation_detail_car
	LEFT JOIN tb_br_car ON (tb_quotation_detail_car.id_br_car = tb_br_car.id)
	LEFT JOIN tb_mo_car ON (tb_quotation_detail_car.id_mo_car = tb_mo_car.id)
	LEFT JOIN tb_mo_car_sub ON (tb_quotation_detail_car.id_mo_car_sub = tb_mo_car_sub.id)
	LEFT JOIN tb_color ON (tb_quotation_detail_car.id_car_color = tb_color.id_color)
	WHERE tb_quotation_detail_car.q_auto = '".$select_quotation_array['q_auto']."'";
	//echo $select_quotation_detail_sql;
	$select_quotation_detail_query=mysql_query($select_quotation_detail_sql,$cndb1);
	define('FPDF_FONTPATH','font/');
	$pdf = new FPDF();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');
	while($select_quotation_detail_array=mysql_fetch_array($select_quotation_detail_query))
	{
		$x = array(120,10,160);
		$y = array(10,50,100,122);
		$w = array(40,70);
		$font = array("","B");
		$font_size = array("16","20");
	$pdf->addPage('L','A4');
	$pdf->Image('../images/suzuki-logo.png',10,10,65,30);
	
	$pdf->SetFont('angsa',$font[1],$font_size[1]);
	$pdf->setY($y[0]);
	$pdf->setX($x[0]);
	$pdf->Cell(1,10,iconv('UTF-8','TIS-620',$select_quotation_array['title_sub']." ".$select_quotation_array['sub']),0,1,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->setX($x[0]);
	$pdf->Cell(1,6,iconv('UTF-8','TIS-620',$select_quotation_array['location']),0,1,'L');
	//$pdf->setX($x0);
	//$pdf->Cell(1,6,iconv('UTF-8','TIS-620',"เบอร์โทร ".$select_quotation_array['emp_telrenew']." โทรสาร ".$select_quotation_array['pay_tel']),0,1,'L');
	$pdf->setX($x[0]);
	$pdf->Cell(1,6,iconv('UTF-8','TIS-620',"เลขประจำตัวผู้เสียภาษี ".$select_quotation_array['icard']),0,1,'L');
	$pdf->setY($y[1]);
	$pdf->setX($x[1]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"สาขาที่เสนอราคา"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(30,9,iconv('UTF-8','TIS-620',$select_quotation_array['title_sub']." ".$select_quotation_array['sub']),0,1,'L');
	$pdf->setX($x[1]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"ชื่อ-สกุลลูกค้า"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(30,9,iconv('UTF-8','TIS-620',"-"),0,1,'L');
	$pdf->setX($x[1]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"ที่อยู่"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(30,9,iconv('UTF-8','TIS-620',"-"),0,1,'L');
	$pdf->setX($x[1]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',""),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(30,9,iconv('UTF-8','TIS-620',""),0,1,'L');
	$pdf->setX($x[1]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"โทรศัพท์"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(30,9,iconv('UTF-8','TIS-620',"-"),0,1,'L');
	//ช่วงที่2
	$pdf->setY($y[1]);
	$pdf->setX($x[2]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"เลขที่เอกสาร"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(30,9,iconv('UTF-8','TIS-620',$select_quotation_array['q_auto']),0,1,'L');
	$pdf->setX($x[1]);
	$pdf->setX($x[2]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"วันที่เอกสาร"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(30,9,iconv('UTF-8','TIS-620',$select_quotation_array['date_save']),0,1,'L');
	$pdf->setX($x[1]);
	$pdf->setX($x[2]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"ชื่อบริษัทไฟแนนซ์"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(30,9,iconv('UTF-8','TIS-620',$select_quotation_array['finance']),0,1,'L');
	$pdf->setX($x[1]);
	$pdf->setX($x[2]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"พนักงานขาย"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(30,9,iconv('UTF-8','TIS-620',"-"),0,1,'L');

	//ส่วนยี่ห้อรุ่น
	$pdf->setY($y[2]);
	$pdf->setX($x[1]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"ยี่ห้อรถ"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(60,9,iconv('UTF-8','TIS-620',$select_quotation_detail_array['b_name']),0,0,'L');
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"สี"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(60,9,iconv('UTF-8','TIS-620',$select_quotation_detail_array['color_name']),0,0,'L');
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"รุ่นรถ"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(60,9,iconv('UTF-8','TIS-620',$select_quotation_detail_array['m_name']),0,1,'L');
	$pdf->setX($x[1]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"แบบ"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(60,9,iconv('UTF-8','TIS-620',$select_quotation_detail_array['s_name']),0,0,'L');
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"ขนาด"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(60,9,iconv('UTF-8','TIS-620',"-"),0,0,'L');
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"สถานะ"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell(60,9,iconv('UTF-8','TIS-620',"-"),0,1,'L');
	//เงื่อนไขไฟแนน
	$pdf->setY($y[3]);
	$pdf->setX($x[1]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"ราคารถ/บาท"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell($w[1],9,iconv('UTF-8','TIS-620',number_format($select_quotation_detail_array['car_price'],2,'.',',')." บาท"),0,1,'R');
	$pdf->setX($x[1]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"จำนวนเงินจอง"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell($w[1],9,iconv('UTF-8','TIS-620',number_format($select_quotation_detail_array['res_price'],2,'.',',')." บาท"),0,1,'R');
	$pdf->setX($x[1]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"จำนวนเงินดาวน์"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell($w[1],9,iconv('UTF-8','TIS-620',number_format($select_quotation_detail_array['down_price'],2,'.',',')." บาท (".$select_quotation_detail_array['down_per']."%)"),0,1,'R');
	$pdf->setX($x[1]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"จำนวนงวด"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell($w[1],9,iconv('UTF-8','TIS-620',($select_quotation_detail_array['unit_year'] * 12)." งวด (".$select_quotation_detail_array['unit_year']." ปี)"),0,1,'R');
	$pdf->setX($x[1]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"ดอกเบี้ย%ต่อปี"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell($w[1],9,iconv('UTF-8','TIS-620',$select_quotation_detail_array['interest_per']." %"),0,1,'R');
	//ช่วงที่2
	$pdf->setY($y[3]);
	$pdf->setX($x[2]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"ดอกเบี้ยเพิ่มต่อปี"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell($w[1],9,iconv('UTF-8','TIS-620',number_format($select_quotation_detail_array['interest_price'],2,'.',',')." บาท"),0,1,'R');
	$pdf->setX($x[2]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"ดอกเบี้ยเพิ่มรวม"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell($w[1],9,iconv('UTF-8','TIS-620',number_format($select_quotation_detail_array['interest_total'],2,'.',',')." บาท"),0,1,'R');
	$pdf->setX($x[2]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"ยอดจัด"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell($w[1],9,iconv('UTF-8','TIS-620',number_format($select_quotation_detail_array['top_price'],2,'.',',')." บาท"),0,1,'R');
	$pdf->setX($x[2]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"ยอดจัดรวมดอกเบี้ย"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell($w[1],9,iconv('UTF-8','TIS-620',number_format($select_quotation_detail_array['total_price'],2,'.',',')." บาท"),0,1,'R');
	$pdf->setX($x[2]);
	$pdf->SetFont('angsa',$font[1],$font_size[0]);
	$pdf->Cell($w[0],9,iconv('UTF-8','TIS-620',"ค่างวดต่อเดือน"),0,0,'L');
	$pdf->SetFont('angsa',$font[0],$font_size[0]);
	$pdf->Cell($w[1],9,iconv('UTF-8','TIS-620',number_format($select_quotation_detail_array['unit_price'],2,'.',',')." บาท"),0,1,'R');
	}
	$pdf->Output();