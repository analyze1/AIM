<?php
	include "../pages/check-ses.php"; 
	include "../inc/connectdbs.inc.php";
	include('../fpdf.php');
	mysql_select_db($db1,$cndb1);
	$q_auto=$_GET['q_auto'];
	$select_order_sql="SELECT
	tb_order_car.q_auto,
	tb_order_car.date_save,
	tb_customer.sub,
	tb_customer.title_sub,
	tb_customer.emp_faxrenew,
	tb_customer.emp_telrenew,
	tb_customer.location
	FROM tb_order_car
	LEFT JOIN tb_customer ON (tb_order_car.login = tb_customer.user)
	WHERE tb_order_car.q_auto = '".$q_auto."'";
	$select_order_query=mysql_query($select_order_sql,$cndb1);
	$select_order_array=mysql_fetch_array($select_order_query);
	
	
	$select_detail_sql="SELECT
	tb_mo_car.name As m_name,
	tb_mo_car_sub.name As s_name,
	tb_order_detail_car.unit_car,
	tb_order_detail_car.car_price,
	tb_color.color_name
	FROM tb_order_detail_car
	LEFT JOIN tb_mo_car ON (tb_order_detail_car.id_mo_car = tb_mo_car.id)
	LEFT JOIN tb_mo_car_sub ON (tb_order_detail_car.id_mo_car_sub = tb_mo_car_sub.id)
	LEFT JOIN tb_color ON (tb_order_detail_car.id_car_color = tb_color.id_color)
	WHERE tb_order_detail_car.q_auto = '".$select_order_array['q_auto']."'";
	$select_detail_query=mysql_query($select_detail_sql,$cndb1);
	define('FPDF_FONTPATH','font/');
	$pdf = new FPDF();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');
	$font=array('11','16','20','24','14','13','12');
	$y=array('30','45','95','115','220','240','10');
	$x=array('10','120','110','170');
	$pdf->addPage('P','A4');
	$pdf->setFont('angsa','B',$font[3]);
	$pdf->Image('../images/suzuki-logo.png',10,10,40,20);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ใบสั่งซื้อ'),0,1,'C');
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','Purchase Oder'),0,1,'C');
	
	$pdf->SetY($y[6]);
	$pdf->SetX($x[3]);
	$pdf->setFont('angsa','B',$font[1]);
	$pdf->Cell(30,8,iconv('UTF-8','TIS-620','ต้นฉบับ/Original'),1,1,'C');
	$pdf->SetY($y[0]);
	$pdf->SetX($x[0]);
	$pdf->setFont('angsa','',$font[0]);
	$pdf->Cell(1,4,iconv('UTF-8','TIS-620','บริษัท มิตซูบิชิ มอเตอร์ส (ประเทศไทย) จำกัด'),0,1,'L');
	$pdf->Setx($x[0]);
	$pdf->Cell(1,4,iconv('UTF-8','TIS-620','เลขที่ 500/121 หมู่ที่ 3 ตำบลตาสิทธิ์ อำเภอปลวกแดง จังหวัดระยอง 21140'),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(1,4,iconv('UTF-8','TIS-620','หมายเลขโทรศัพท์ 02-549-8227  หมายเลขโทรสาร 02-990-8955'),0,1,'L');

	
	
	$pdf->setFont('angsa','',$font[1]);
	$pdf->SetY($y[0]);
	$pdf->SetX($x[1]);
	$pdf->Cell(1,7,iconv('UTF-8','TIS-620','เลขที่ใบสั่งซื้อ / PO No  :  '.$select_order_array['q_auto']),0,1,'L');
	$pdf->SetX($x[1]);
	$date_array=explode(" ",$select_order_array['date_save']);
	$pdf->Cell(1,7,iconv('UTF-8','TIS-620','วันที่สั่งซื้อ / Order Date :  '.$date_array[0]),0,1,'L');
	
	$pdf->SetY($y[1]);
	$pdf->SetX($x[0]);
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620',''),1,0,'L');
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620',''),1,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(95,12,iconv('UTF-8','TIS-620',''),1,0,'L');
	$pdf->Cell(95,12,iconv('UTF-8','TIS-620',''),1,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(95,12,iconv('UTF-8','TIS-620',''),1,0,'L');
	$pdf->Cell(95,12,iconv('UTF-8','TIS-620',''),1,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(95,12,iconv('UTF-8','TIS-620',''),1,0,'L');
	$pdf->Cell(95,12,iconv('UTF-8','TIS-620',''),1,1,'L');
	//////////////////////////////////////////////////////////////////
	$pdf->SetY($y[1]);
	$pdf->Setx($x[0]);
	$pdf->setFont('angsa','',$font[1]);
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620','ชื่อดีลเลอร์ / Dealer name :'),0,0,'L');
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620','ผู้ติดต่อ / Contact Person :'),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->setFont('angsa','',$font[6]);
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620',"ที่อยู่ / Address : ".$select_order_array['title_sub']." ".$select_order_array['sub']),0,0,'L');
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620','โทรศัพท์ / Tel : '.$select_order_array['emp_telrenew']),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620',$select_order_array['location']),0,0,'L');
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620','โทรสาร / Fax : '.$select_order_array['emp_faxrenew']),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620','เงื่อนไขการชำระเงิน / Payment Term :'),0,0,'L');
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620','กำหนดวันส่งมอบรถ / Requested Delivery Date :'),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620',''),0,0,'L');
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620',''),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620','วิธีการส่งมอบ / Delivery via :'),0,0,'L');
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620','คำสั่งพิเศษ(ถ้ามี) / Special instructions, if any'),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620',''),0,0,'L');
	$pdf->Cell(95,6,iconv('UTF-8','TIS-620',''),0,1,'L');
	
	$pdf->SetY($y[2]);
	$pdf->SetX($x[0]);
	$pdf->setFont('angsa','',$font[1]);
	$pdf->Cell(1,5,iconv('UTF-8','TIS-620','บริษัทฯ มีความยินดีที่จะขอสั่งซื้อรถยนต์ซูซูกิ โดยมีรายละเอียดตามที่ปรากฎในใบสั่งซื้อนี้'),0,1,'L');
	$pdf->Cell(1,5,iconv('UTF-8','TIS-620','We would like to place order of Mitsubishi Motor (Thailand) Co., Ltd. as these following detail.'),0,1,'L');
	$pdf->SetY($y[3]);
	$pdf->SetX($x[0]);
	$pdf->Cell(15,7,iconv('UTF-8','TIS-620','ลำดับที่'),1,0,'C');
	$pdf->Cell(90,7,iconv('UTF-8','TIS-620','ข้อมูลรถยนต์ / Vehicle detail'),1,0,'C');
	$pdf->Cell(15,7,iconv('UTF-8','TIS-620','จำนวน'),1,0,'C');
	$pdf->Cell(40,7,iconv('UTF-8','TIS-620','ราคาต่อหน่วยรวม VAT'),1,0,'C');
	$pdf->Cell(30,7,iconv('UTF-8','TIS-620','ราคารวม'),1,1,'C');
	$pdf->SetX($x[0]);
	$pdf->setFont('angsa','',$font[1]);
	$pdf->Cell(15,7,iconv('UTF-8','TIS-620','N0.'),1,0,'C');
	$pdf->Cell(25,7,iconv('UTF-8','TIS-620','รุ่นรถ'),1,0,'C');
	$pdf->Cell(45,7,iconv('UTF-8','TIS-620','รุ่นรถย่อย'),1,0,'C');
	$pdf->Cell(20,7,iconv('UTF-8','TIS-620','สี / color'),1,0,'C');
	$pdf->Cell(15,7,iconv('UTF-8','TIS-620','Q\'TY'),1,0,'C');
	$pdf->Cell(40,7,iconv('UTF-8','TIS-620','Price / Unit'),1,0,'C');
	$pdf->Cell(30,7,iconv('UTF-8','TIS-620','Total'),1,1,'C');
	$n=1;
	$unit_sum=0;
	$price_sum=0;
	while($select_detail_array=mysql_fetch_array($select_detail_query))
	{
		$pdf->SetX($x[0]);
		$pdf->setFont('angsa','',$font[5]);
	$pdf->Cell(15,7,iconv('UTF-8','TIS-620',$n),1,0,'L');
	$pdf->Cell(25,7,iconv('UTF-8','TIS-620',$select_detail_array['m_name']),1,0,'L');
	$pdf->Cell(45,7,iconv('UTF-8','TIS-620',$select_detail_array['s_name']),1,0,'L');
	$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$select_detail_array['color_name']),1,0,'L');
	$pdf->Cell(15,7,iconv('UTF-8','TIS-620',$select_detail_array['unit_car']),1,0,'R');
	$pdf->Cell(40,7,iconv('UTF-8','TIS-620',number_format($select_detail_array['car_price'],2,'.',',')),1,0,'R');
	$pdf->Cell(30,7,iconv('UTF-8','TIS-620',number_format($select_detail_array['car_price']*$select_detail_array['unit_car'],2,'.',',')),1,1,'R');
	$unit_sum+=$select_detail_array['unit_car'];
	$price_sum+=$select_detail_array['car_price']*$select_detail_array['unit_car'];
		$n++;
	}
	$pdf->SetX($x[0]);
	$pdf->setFont('angsa','',$font[5]);
	$pdf->Cell(15,7,iconv('UTF-8','TIS-620',''),0,0,'C');
	$pdf->Cell(25,7,iconv('UTF-8','TIS-620',''),0,0,'C');
	$pdf->Cell(45,7,iconv('UTF-8','TIS-620',''),0,0,'C');
	$pdf->Cell(20,7,iconv('UTF-8','TIS-620','จำนวนรวม '),1,0,'C');
	$pdf->Cell(15,7,iconv('UTF-8','TIS-620',$unit_sum),1,0,'R');
	$pdf->Cell(40,7,iconv('UTF-8','TIS-620','ราคารวม'),1,0,'C');
	$pdf->Cell(30,7,iconv('UTF-8','TIS-620',number_format($price_sum,2,'.',',')),1,1,'R');
	$pdf->SetX($x[0]);
	$pdf->setFont('angsa','',$font[1]);
	
	$pdf->Cell(1,5,iconv('UTF-8','TIS-620',''),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(1,5,iconv('UTF-8','TIS-620','หมายเหตุ : กรุณาแจ้งการสั่งซื้อล่วงหน้าอย่างน้อย 3 วันทำการ'),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(1,5,iconv('UTF-8','TIS-620','Remark : Please place the order in advance at least 1 day operation.'),0,1,'L');
	$pdf->SetY($y[4]);
	$pdf->SetX($x[0]);
	
	$pdf->Cell(1,6,iconv('UTF-8','TIS-620','ผู้ขอสั่งซื้อ'),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(1,6,iconv('UTF-8','TIS-620','Requested by.........................................................................'),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(1,6,iconv('UTF-8','TIS-620','                     (                                                                       )'),0,1,'L');
	$pdf->SetY($y[4]);
	$pdf->SetX($x[2]);
	$pdf->Cell(1,6,iconv('UTF-8','TIS-620','ผู้อนุมัติ'),0,1,'L');
	$pdf->SetX($x[2]);
	$pdf->Cell(1,6,iconv('UTF-8','TIS-620','Approved by.........................................................................'),0,1,'L');
	$pdf->SetX($x[2]);
	$pdf->Cell(1,6,iconv('UTF-8','TIS-620','                     (                                                                       )'),0,1,'L');
	$pdf->SetY($y[5]);
	$pdf->SetX($x[0]);
	$pdf->Cell(1,6,iconv('UTF-8','TIS-620','ผู้ให้ความเห็นชอบ'),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(1,6,iconv('UTF-8','TIS-620','Acknowledged by .........................................................................'),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(1,6,iconv('UTF-8','TIS-620','                              (                                                                       )'),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(1,6,iconv('UTF-8','TIS-620','                                               ฝ่ายขาย / Sales Department'),0,1,'L');
	$pdf->SetX($x[0]);
	$pdf->Cell(1,6,iconv('UTF-8','TIS-620','                                   บริษัท มิตซูบิชิ มอเตอร์ส (ประเทศไทย) จำกัด'),0,1,'L');
	$pdf->Output();