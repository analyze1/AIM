<?php
	include "../pages/check-ses.php"; 
	include "../inc/connectdbs.inc.php";
	
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
	
	$IDDATA = $_GET["IDDATA"];
	
	$query = "SELECT ";
	$query .= "data.id,";	
	$query .= "data.doc_type,";
	$query .= "data.login, "; // รหัสผู้แจ้ง
	
	$query .= "tb_comp.name as comp_name, "; // บริษัทประกันภัย
	$query .= "tb_comp.sort, "; // รหัสบริษัท
	$query .= "tb_comp.picture, "; // รูปบริษัทประกัน
	$query .= "tb_comp.name_print, "; // บริษัทประกันภัย
	$query .= "tb_comp.tel, "; // เบอร์โทรศัพท์ บริษัทประกันภัย
	$query .= "tb_comp.add_namecom, "; // ที่อยู่
	$query .= "tb_comp.add_namecom2, "; // ที่อยู่
	
	$query .= "protect.cost, "; // ยอดชำระ
	$query .= "protect.damage_out1, ";
	$query .= "protect.damage_cost, "; 
	$query .= "protect.id, "; 
	$query .= "protect.pa1, ";
	$query .= "protect.pa2, ";  
	$query .= "protect.pa3, "; 
	$query .= "protect.pa4, "; 
	$query .= "protect.pa5, "; 
	$query .= "protect.pa6, "; 
	$query .= "protect.people, "; 
	
	$query .= "data.send_date,   "; // วันที่แจ้ง
	$query .= "data.id_data, "; // เลขที่รับแจ้ง
	$query .= "data.o_insure, "; // เลขที่กรมธรรมเดิม
	$query .= "data.start_date, ";
	$query .= "data.end_date, ";
	$query .= "data.name_gain, ";
	
	$query .= "premium.pre, "; // เบี้ยสุทธิ
	$query .= "premium.one, "; // ส่วนแรก
	$query .= "premium.driver, "; // ส่วนลดระบุผู้ขับขี่
	$query .= "premium.dis1, "; // ส่วนลดระบุผู้ขับขี่
	$query .= "premium.good, "; // ส่วนลดประวัติดี
	$query .= "premium.dis2, "; // ส่วนลดระบุผู้ขับขี่
	$query .= "premium.group3, "; // ส่วนลดประวัติดี
	$query .= "premium.dis_group3, "; // ส่วนลดประวัติดี
	$query .= "premium.pro_dis, "; // ส่วนลดพิเศษ
	$query .= "premium.total_pro_dis, "; // ส่วนลดพิเศษ
	$query .= "premium.total_pre, "; // เบี้ยสิทธิ หักส่วนลด
	$query .= "premium.total_stamp, "; // รวม อากร
	$query .= "premium.total_vat, "; // รวม ภาษี
	$query .= "premium.prb, "; // เบี้ย พ.ร.บ.
	$query .= "premium.total_prb, "; // เบี้ยรวม พ.ร.บ.
	$query .= "premium.total_sum, "; // เบี้ยรวม
	$query .= "premium.other, "; // เบี้ยรวม
	$query .= "premium.vat_1, "; // หัก ณ ที่จ่าย
	$query .= "premium.commition, "; // ส่วนลดเป็นบาท
	$query .= "premium.total_commition, "; // ยอดชำระ
	$query .= "premium.disone, ";

	//////////////////////////////////////////
	$query .= "insuree.title, "; // คำนำหน้า ชื่อผู้เอาประกัน
	$query .= "insuree.name,  "; // ชื่อผู้เอาประกัน
	$query .= "insuree.last, "; // นามสกุลผู้เอาประกัน
	$query .= "insuree.person, ";
	$query .= "insuree.icard, ";
	$query .= "insuree.id_business, ";
	$query .= "insuree.career, "; // นามสกุลผู้เอาประกัน
	$query .= "insuree.add, "; // บ้านเลขที่
	$query .= "insuree.group, "; // หมู่
	$query .= "insuree.town, "; //อาคาร/หมู่บ้าน
	$query .= "insuree.lane, "; // ซอย
	$query .= "insuree.road, "; // ถนน
	$query .= "insuree.tumbon, "; // ตำบล คีย์
	$query .= "insuree.amphur, "; // อำเภอ คีย์
	$query .= "insuree.province, "; // จังหวัด คีย์
	$query .= "insuree.postal, "; // รหัสไปรษณีย์
	$query .= "insuree.tel_mobile, "; // เบอร์โทร
	$query .= "insuree.tel_mobile2, "; // เบอร์โทร	
	$query .= "insuree.tel_home, "; // เบอร์โทร
	$query .= "insuree.tel_fax, "; // เบอร์โทร
	$query .= "insuree.email, "; // Email
	$query .= "insuree.email_cc, "; // Email_cc
	$query .= "tb_tumbon.name as tumbon_name, "; 
	$query .= "tb_amphur.name as amphur_name, "; 
	$query .= "tb_province.name as province_name, "; // จังหวัด
	$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
	$query .= "tb_br_car.name as car_brand, "; // ยี่ห้อรถ
	$query .= "tb_mo_car.name as mo_car_name, "; // รุ่นรถ
	
	$query .= "detail.car_id, ";
	$query .= "detail.car_regis, "; // ทะเบียนรถ
	$query .= "detail.car_regis_pro, "; // ทะเบียนรถ
	$query .= "detail.car_body, "; // เลขตัวถัง
	$query .= "detail.regis_date, "; // ปีที่จดทะเบียน
	$query .= "detail.n_motor, "; // เลขเครื่อง
	$query .= "detail.car_seat, ";
	$query .= "detail.cc, ";
	$query .= "detail.car_wg, ";
	$query .= "detail.Cancel_policy, ";
	$query .= "detail.Cancel_policy2, ";
	$query .= "detail.single_rate, ";
	
	//กรณีระบุชื่อผู้ขับขี่
	$query .= "driver.title_num1, "; // ผู้ขับขี่ที่ 1
	$query .= "driver.name_num1, ";
	$query .= "driver.last_num1, ";
	$query .= "driver.birth_num1, "; // วัน/เดือน/ปี (วันเกิด)
	$query .= "driver.title_num2, "; // ผู้ขับขี่ที่ 2
	$query .= "driver.name_num2, ";
	$query .= "driver.last_num2, ";
	$query .= "driver.birth_num2, "; // วัน/เดือน/ปี (วันเกิด)
	$query .= "service.fac1, "; // 
	$query .= "service.fac2, "; // 
	$query .= "service.fac3, "; // 
	
	$query .= "tb_agent.id_agent, ";
	$query .= "tb_agent.full_name, ";
	$query .= "tb_agent.agent_dis, ";
	
	$query .= "tb_pass_car_type.name as pass_car_name, ";
	
	$query .= "act.act_id, ";
	$query .= "tb_user.Email,";
	$query .= "tb_user.Email2,";
	$query .= "tb_user.Email3,";
	$query .= "tb_user.Email4,";
	$query .= "tb_user.Email5 ";
	
	$query .= "FROM data ";
	
	$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
	$query .= "INNER JOIN service ON (data.id_data = service.id_data) ";
	$query .= "INNER JOIN premium ON (data.id_data = premium.id_data) ";
	$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
	$query .= "INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
	$query .= "INNER JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
	$query .= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
	$query .= "INNER JOIN act ON (act.id_data = data.id_data)  ";
	$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
	$query .= "INNER JOIN driver ON (driver.id_data = data.id_data)  ";
	$query .= "INNER JOIN tb_agent ON (tb_agent.id_agent = data.idagent)  ";
	$query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
	$query .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
	$query .= "left JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
	$query .= "left JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
	$query .= "left JOIN tb_province ON (tb_province.id = insuree.province) ";
	$query .= "INNER JOIN tb_user ON (tb_user.user = data.name_inform) ";
	$query .= "INNER JOIN tb_pass_car_type ON (tb_pass_car_type.pass_car_id = detail.car_id) ";

	$query .= "WHERE data.id_data='".$IDDATA."' ";
        //echo $query;
	mysql_select_db($db2,$cndb2);
	$objQuery = mysql_query($query,$cndb2) or die ("Error Query tb_data [".$query."]");
	
	$row = mysql_fetch_array($objQuery);

	$car_id = $row['car_id'];
	$id_data_rec = $row['id_data'];
	$arr_car_id = str_split($car_id);
	
	$career = trim($row['career']); // สถานที่
	$add = trim($row['add']); // บ้านเลขที่
	$group = trim($row['group']); // หมู่
	$town = trim($row['town']); // หมู่บ้าน
	$lane = trim($row['lane']); // ซอย
	$road = trim($row['road']); // ถนน
	
	// ที่อยู่
	if($career !="" && $career !="-" )
	{
		$address_1 = "".$career." ";
	}
	if($group !="" && $group !="-" )
	{
		$address_1 = " หมู่".$group;
	}
	if($town !="" && $town !="-")
	{
		$address_1 .= " ".$town;
	}
	if($lane !="" && $lane !="-")
	{
		$address_1 .= " ซอย".$lane;
	}
	if($road !="" && $road !="-")
	{
		$address_1 .= " ถนน".$road;
	}

	if($row['province'] != "102")
	{
		$address_2 = 'ต.'.$row['tumbon_name'].' อ.'.$row['amphur_name'].' จ.'.$row['province_name'];
	}
	else
	{
		$address_2 = 'แขวง'.$row['tumbon_name'].' '.$row['amphur_name'].' '.$row['province_name'];
	}
	/////////////////////////////////////////////////////////////////////
	
	// ความเสียหายส่วนแรก
	if($row['one']=="0" or $row['one']=="")
	{
    	 $one_s = "-"; 
    }
	else
	{
    	 $one_s = $row['one'];
    }
	////////////////////////////////////////////////////////////////
	
	// ความเสียหายต่อรถยนต์
	if($row['doc_type']=="2")
	{
		$cost_car = "-"; 
	}
	else
	{
		$cost_car = $row['cost']; 
	}
	////////////////////////////////////////////////////////////////
	
	// สูญหายไฟใหม้
	if($row['doc_type']=="3" or $row['doc_type']=="3+")
	{
    	 $cost_3 = "-"; 
    }
	else
	{
    	 $cost_3 = $row['cost'];
    }
	////////////////////////////////////////////////////////////////
	
	// ผู้ขับขี่คนที่ 1
	if($row['name_num1']!="ไม่ระบุ")
	{
    	 $D_Name = $row['title_num1'].' '.$row['name_num1'].' '.$row['last_num1'];
    }
	else
	{
    	 $D_Name = "ไม่ระบุ";
    }
	///////////////////////////////////////////////////////////
	
	// ผู้ขับขี่คนที่ 2
	if($row['name_num2']!="ไม่ระบุ")
	{
    	 $D_Name2 = $row['title_num2'].' '.$row['name_num2'].' '.$row['last_num2'];
    }
	else
	{
    	 $D_Name2 = "ไม่ระบุ";
    }
	///////////////////////////////////////////////////////////
	
	// รหัสบัตรประชาชน - เลขนิติบุคคล
	if ($row['person']=="1" )
	{
		 $I_card = $row['icard'];
		 $I_card2 = "-";
	}	
	if ($row['person']=="2" )
	{
		 $I_card =  "-";
		 $I_card2 =$row['id_business'];
	}	
	if ($row['person']=="3" )
	{
		 $I_card = $row['icard'];
		 $I_card2 =$row['id_business'];
	}
	if($row['icard']=="0000000000000" OR $row['icard']=="")
	{
    	 $I_card = "-";
    }
	if($row['id_business']=="0000000000000" OR $row['id_business']=="")
	{
    	 $I_card2 = "-";
    }
	////////////////////////////////////////////////////////////////////////////////////////
	
	// เลข พรบ.
	if($row['act_id'] == "" )
	{
    	 $act_id = "-";
    }
	else
	{
    	 $act_id = $row['act_id'];
    }
	/////////////////////////////////////////////////
	
	// จังหวัดทะเบียนรถ
	$sql = "SELECT name_mini FROM tb_province WHERE id='".$row['car_regis_pro']."'";
	mysql_query("set NAMES utf8");
	$result = mysql_query( $sql );
	$fetcharr = mysql_fetch_array( $result ) ;
	$c_regis = $fetcharr['name_mini'];
	///////////////////////////////////////////////////
	
	require('../fpdf.php');

	define('FPDF_FONTPATH','font/');

	$pdf=new FPDF();
	$pdf->AddPage();
	//df->SetFillColor(227,227,227);	//สีกรอบ fill
	//$pdf->SetTextColor(255,0,0); 		//สีตัวอักษร
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');	
	
	if($row['name_print'] == "บริษัท วิริยะประกันภัย จำกัด (มหาชน)")
	{
		$pdf->Image("../images/".$row['picture'],10,7,70,0);
		
		
		$pdf->SetY(10);
		$pdf->SetX(85);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(100,0,iconv( 'UTF-8','TIS-620',$row['name_print']),0,1,"L");
	
		$pdf->SetY(15);
		$pdf->SetX(85);
		$pdf->SetFont('angsa','',12);
		$pdf->Cell(100,0,iconv( 'UTF-8','TIS-620',$row['add_namecom']." ".$row['add_namecom2']),0,1,"L");
	
		$pdf->SetY(19);
		$pdf->SetX(85);
		$pdf->SetFont('angsa','',12);
		$pdf->Cell(100,0,iconv( 'UTF-8','TIS-620','Tel. 02-196-8234   Fax. 02-196-8235 (Auto)'),0,1,"L");
	}
	else
	{
		$pdf->Image("../images/".$row['picture'],10,5,50,0);
		
		
		$pdf->SetY(10);
		$pdf->SetX(62);
		$pdf->SetFont('angsa','B',16);
		$pdf->Cell(100,0,iconv( 'UTF-8','TIS-620',$row['name_print']),0,1,"L");
	
		$pdf->SetY(15);
		$pdf->SetX(62);
		$pdf->SetFont('angsa','',12);
		$pdf->Cell(100,0,iconv( 'UTF-8','TIS-620',$row['add_namecom']." ".$row['add_namecom2']),0,1,"L");
	
		$pdf->SetY(19);
		$pdf->SetX(62);
		$pdf->SetFont('angsa','',12);
		$pdf->Cell(100,0,iconv( 'UTF-8','TIS-620','Tel. 02-196-8234   Fax. 02-196-8235 (Auto)'),0,1,"L");
	}
	
	$pdf->SetY(25);
	$pdf->SetX(115);
	$pdf->SetFont('angsa','B',18);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','แจ้งอุบัติเหตุ โทร. '.$row['tel']),0,1,"R");
	
	$pdf->SetY(30);
	$pdf->SetX(10);
	$pdf->Cell(190,6,'',1);
	
	$pdf->SetY(33);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','รหัสบริษัท :'),0,1,"L");
	
	$pdf->SetY(33);
	$pdf->SetX(37);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$row['sort']),0,1,"L");
	
	$pdf->SetY(33);
	$pdf->SetX(80);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ใบคำขอประกันภัยรถยนต์'),0,1,"L");
	
	$pdf->SetY(33);
	$pdf->SetX(135);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','อาณาเขตคุ้มครอง :'),0,1,"L");
	
	$pdf->SetY(33);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ประเทศไทย'),0,1,"L");
	
	$pdf->SetY(36);
	$pdf->SetX(10);
	$pdf->Cell(190,6,'',1);
	
	$pdf->SetY(39);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ใบคำขอเลขที่ :'),0,1,"L");
	
	$pdf->SetY(39);
	$pdf->SetX(37);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$row['id_data']),0,1,"L");
	
	$pdf->SetY(39);
	$pdf->SetX(80);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','เลขกรมธรรม์เดิม:'),0,1,"L");
	
	$pdf->SetY(39);
	$pdf->SetX(107);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$row['o_insure']),0,1,"L");
	
	$pdf->SetY(42);
	$pdf->SetX(10);
	$pdf->Cell(190,20,'',1);
	
	$pdf->SetY(48);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ผู้เอาประกันภัย'),0,1,"L");
	
	$pdf->SetY(48);
	$pdf->SetX(37);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ชื่อ'),0,1,"L");
	
	$pdf->SetY(48);
	$pdf->SetX(52);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$row['title']."".$row['name']."  ".$row['last']),0,1,"L");
	
	if($row['person'] == '1')
	{
		$pdf->SetY(45);
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620','เลขบัตรประชาชน'),0);
		
		$pdf->SetY(45);
		$pdf->SetX(175);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$row['icard']),0);
	}
	if($row['person'] == '2')
	{
		$pdf->SetY(45);
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620','เลขทะเบียนนิติบุคคล'),0);
		
		$pdf->SetY(45);
		$pdf->SetX(175);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$row['id_business']),0);
	}
	if($row['person'] == '3')
	{
		$pdf->SetY(45);
		$pdf->SetX(150);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620','เลขบัตรประชาชน'),0);
		
		$pdf->SetY(45);
		$pdf->SetX(175);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$row['icard']),0);
		
		$pdf->SetY(49);
		$pdf->SetX(130);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620','เลขทะเบียนนิติบุคคลในนามบริษัท'),0);
		
		$pdf->SetY(49);
		$pdf->SetX(175);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$row['id_business']),0);
	}
	
	$pdf->SetY(53);
	$pdf->SetX(37);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ที่อยู่'),0,1,"L");

	$pdf->SetY(53);
	$pdf->SetX(52);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$add.' '.$address_1.' '.$address_2.' '.$row['postal']),0,1,"L");
	
	$pdf->SetY(62);
	$pdf->SetX(10);
	$pdf->Cell(190,15,'',1);
	
	$pdf->SetY(67);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ผู้ขับขี่ 1'),0,1,"L");
	
	$pdf->SetY(67);
	$pdf->SetX(32);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$D_Name),0,1,"L");
	
	$pdf->SetY(67);
	$pdf->SetX(95);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','วัน/เดือน/ปีเกิด'),0,1,"L");

	$pdf->SetY(67);
	$pdf->SetX(115);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$row['birth_num1']),0,1,"L");
	
	$pdf->SetY(67);
	$pdf->SetX(140);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','อาชีพ'),0,1,"L");
	
	$pdf->SetY(72);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ผู้ขับขี่ 2'),0,1,"L");
	
	$pdf->SetY(72);
	$pdf->SetX(32);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$D_Name2),0,1,"L");
	
	$pdf->SetY(72);
	$pdf->SetX(95);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','วัน/เดือน/ปีเกิด'),0,1,"L");

	$pdf->SetY(72);
	$pdf->SetX(115);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$row['birth_num2']),0,1,"L");
	
	$pdf->SetY(72);
	$pdf->SetX(140);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','อาชีพ'),0,1,"L");
	
	$pdf->SetY(77);
	$pdf->SetX(10);
	$pdf->Cell(190,6,'',1);
	
	$pdf->SetY(80);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ผู้รับประโยชน์'),0,1,"L");
	
	$pdf->SetY(80);
	$pdf->SetX(37);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$row['name_gain']),0,1,"L");
	
	$pdf->SetY(83);
	$pdf->SetX(10);
	$pdf->Cell(190,6,'',1);
	
	$pdf->SetY(86);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','ระยะเวลาประกันภัย : เริ่มต้นวันที่'),0,1,"L");
	
	$pdf->SetY(86);
	$pdf->SetX(58);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',thaiDate($row['start_date'])),0,1,"L");
	
	$pdf->SetY(86);
	$pdf->SetX(95);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','สิ้นสุดวันที่'),0,1,"L");
	
	$pdf->SetY(86);
	$pdf->SetX(115);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',thaiDate($row['end_date'])),0,1,"L");
	
	$pdf->SetY(86);
	$pdf->SetX(155);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','เวลา'),0,1,"L");
	
	$pdf->SetY(86);
	$pdf->SetX(165);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','16.30 น.'),0,1,"L");
	
	$pdf->SetY(89);
	$pdf->SetX(10);
	$pdf->Cell(190,6,'',1);
	
	$pdf->SetY(92);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','รายการรถยนต์ที่เอาประกันภัย'),0,1,"L");
	
	$pdf->SetY(95);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(10,6,iconv( 'UTF-8','TIS-620','ลำดับ'),1,1,"C");
	
	$pdf->SetY(101);
	$pdf->SetX(10);
	$pdf->Cell(10,12,'',1);
	
	$pdf->SetY(101);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(10,12,iconv( 'UTF-8','TIS-620',''),0,1,"C");
	
	$pdf->SetY(95);
	$pdf->SetX(20);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(10,6,iconv( 'UTF-8','TIS-620','รหัส'),1,1,"C");
	
	$pdf->SetY(101);
	$pdf->SetX(20);
	$pdf->Cell(10,12,'',1);
	
	$pdf->SetY(101);
	$pdf->SetX(20);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(10,12,iconv( 'UTF-8','TIS-620',$row['car_id']),0,1,"C");
	
	$pdf->SetY(95);
	$pdf->SetX(30);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(45,6,iconv( 'UTF-8','TIS-620','ชื่อรถยนต์/รหัส'),1,1,"C");
	
	$pdf->SetY(101);
	$pdf->SetX(30);
	$pdf->Cell(45,12,'',1);
	
	$pdf->SetY(99);
	$pdf->SetX(30);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(45,12,iconv( 'UTF-8','TIS-620',$row['car_brand']),0,1,"C");
	
	$pdf->SetY(102);
	$pdf->SetX(30);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(45,12,iconv( 'UTF-8','TIS-620',$row['mo_car_name']),0,1,"C");
	
	$pdf->SetY(95);
	$pdf->SetX(75);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(20,6,iconv( 'UTF-8','TIS-620','เลขทะเบียน'),1,1,"C");
	
	$pdf->SetY(101);
	$pdf->SetX(75);
	$pdf->Cell(20,12,'',1);
	
	$pdf->SetY(101);
	$pdf->SetX(75);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(20,12,iconv( 'UTF-8','TIS-620',$row['car_regis']." ".$c_regis),0,1,"C");
	
	$pdf->SetY(95);
	$pdf->SetX(95);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(35,6,iconv( 'UTF-8','TIS-620','เลขตัวถัง'),1,1,"C");
	
	$pdf->SetY(101);
	$pdf->SetX(95);
	$pdf->Cell(35,12,'',1);
	
	if($row['Cancel_policy2']!="ยกเลิกกรมธรรม์")
	{
		$pdf->SetTextColor(0,0,0); 		//สีตัวอักษร
		$pdf->SetY(101);
		$pdf->SetX(95);
		$pdf->SetFont('angsa','',12);
		$pdf->Cell(35,12,iconv( 'UTF-8','TIS-620',$row['car_body']),1,1,"C");
	}
	else
	{
		$pdf->SetTextColor(0,0,0); 		//สีตัวอักษร
		$pdf->SetY(99);
		$pdf->SetX(95);
		$pdf->SetFont('angsa','',12);
		$pdf->Cell(35,12,iconv( 'UTF-8','TIS-620',$row['car_body']),0,0,"C");
		
		$pdf->SetTextColor(255,0,0); 		//สีตัวอักษร
		$pdf->SetY(103);
		$pdf->SetX(95);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(35,12,iconv( 'UTF-8','TIS-620','ยกเลิกกรมธรรม์'),0,0,"C");
	}
	
	$pdf->SetTextColor(0,0,0); 		//สีตัวอักษร
	$pdf->SetY(95);
	$pdf->SetX(130);	
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(10,6,iconv( 'UTF-8','TIS-620','ปีรุ่น'),1,1,"C");
	
	$pdf->SetY(101);
	$pdf->SetX(130);
	$pdf->Cell(10,12,'',1);
	
	$pdf->SetY(101);
	$pdf->SetX(130);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(10,12,iconv( 'UTF-8','TIS-620',$row['regis_date']),1,1,"C");
	
	$pdf->SetY(95);
	$pdf->SetX(140);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(30,6,iconv( 'UTF-8','TIS-620','เลขเครื่อง'),1,1,"C");
	
	$pdf->SetY(101);
	$pdf->SetX(140);
	$pdf->Cell(30,12,'',1);
	
	if($row['Cancel_policy2']!="ยกเลิกกรมธรรม์")
	{
		$pdf->SetTextColor(0,0,0); 		//สีตัวอักษร
		$pdf->SetY(101);
		$pdf->SetX(140);
		$pdf->SetFont('angsa','',12);
		$pdf->Cell(30,12,iconv( 'UTF-8','TIS-620',$row['n_motor']),0,0,"C");
	}
	else
	{
		$pdf->SetTextColor(0,0,0); 		//สีตัวอักษร
		$pdf->SetY(99);
		$pdf->SetX(140);
		$pdf->SetFont('angsa','',12);
		$pdf->Cell(30,12,iconv( 'UTF-8','TIS-620',$row['n_motor']),0,0,"C");
		
		$pdf->SetTextColor(255,0,0); 		//สีตัวอักษร
		$pdf->SetY(103);
		$pdf->SetX(140);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(30,12,iconv( 'UTF-8','TIS-620','ยกเลิกกรมธรรม์'),0,0,"C");
	}
	
	$pdf->SetTextColor(0,0,0); 		//สีตัวอักษร
	$pdf->SetY(95);
	$pdf->SetX(170);	
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(30,6,iconv( 'UTF-8','TIS-620','ที่นั่ง/ขนาด/น.น.'),1,1,"C");
	
	$pdf->SetY(101);
	$pdf->SetX(170);
	$pdf->Cell(30,12,'',1);
	
	$pdf->SetY(101);
	$pdf->SetX(170);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(30,12,iconv( 'UTF-8','TIS-620',$row['car_seat']." / ".$row['cc']." / ".$row['wg']),1,1,"C");
	
	$pdf->SetY(113);
	$pdf->SetX(10);
	$pdf->Cell(190,6,'',1);
	
	$pdf->SetY(116);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','จำนวนเงินเอาประกันภัย :'),0,1,"L");
	
	$pdf->SetY(116);
	$pdf->SetX(42);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','กรมธรรม์ประกันภัยนี้ให้การคุ้มครองเฉพาะข้อตกลงคุ้มครองที่มีจำนวนเงินเอาประกันภัยระบุไว้เท่านั้น'),0,1,"L");
	
	$pdf->SetY(119);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(65,6,iconv( 'UTF-8','TIS-620','ความรับผิดต่อบุคคลภายนอก'),1,1,"C");
	
	$pdf->SetY(119);
	$pdf->SetX(75);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(55,6,iconv( 'UTF-8','TIS-620','รถยนต์เสียหาย สูญหาย ไฟไหม้'),1,1,"C");
	
	$pdf->SetY(119);
	$pdf->SetX(130);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(70,6,iconv( 'UTF-8','TIS-620','ความคุ้มครองตามเอกสารแนบท้าย'),1,1,"C");
	
	$pdf->SetY(125);
	$pdf->SetX(10);
	$pdf->Cell(65,57,'',1);
	
	$pdf->SetY(126);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','1) ความเสียหายต่อชีวิต ร่างกาย หรือ'),0,1,"L");
	
	$pdf->SetY(131);
	$pdf->SetX(15);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','อนามัยเฉพาะส่วนเกินวงเงินสูงสุดตาม พรบ'),0,1,"L");
	
	$pdf->SetY(137);
	$pdf->SetX(25);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(35,6,iconv( 'UTF-8','TIS-620',$row['damage_out1']),0,1,"R");
	
	$pdf->SetY(137);
	$pdf->SetX(60);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท/คน'),0,1,"L");
	
	$pdf->SetY(142);
	$pdf->SetX(25);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(35,6,iconv( 'UTF-8','TIS-620','10,000,000'),0,1,"R");
	
	$pdf->SetY(142);
	$pdf->SetX(60);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท/ครั้ง'),0,1,"L");
	
	$pdf->SetY(147);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','2) ความเสียหายต่อทรัพย์สิน'),0,1,"L");
	
	$pdf->SetY(153);
	$pdf->SetX(25);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(35,6,iconv( 'UTF-8','TIS-620',$row['damage_cost']),0,1,"R");
	
	$pdf->SetY(153);
	$pdf->SetX(60);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท/ครั้ง'),0,1,"L");
	
	$pdf->SetY(159);
	$pdf->SetX(15);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','2.1 ความเสียหายส่วนแรก'),0,1,"L");
	
	$pdf->SetY(165);
	$pdf->SetX(25);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(35,6,iconv( 'UTF-8','TIS-620',$one_s),0,1,"R");
	
	$pdf->SetY(165);
	$pdf->SetX(60);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท/ครั้ง'),0,1,"L");
	
	$pdf->SetY(125);
	$pdf->SetX(75);
	$pdf->Cell(55,57,'',1);
	
	$pdf->SetY(126);
	$pdf->SetX(77);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','1) ความเสียหายต่อรถยนต์'),0,1,"L");
	
	$pdf->SetY(131);
	$pdf->SetX(82);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(30,6,iconv( 'UTF-8','TIS-620',$cost_car),0,1,"R");
	
	$pdf->SetY(131);
	$pdf->SetX(115);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท/ครั้ง'),0,1,"L");
	
	$pdf->SetY(136);
	$pdf->SetX(80);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','1.1 ความเสียหายส่วนแรก'),0,1,"L");
	
	$pdf->SetY(141);
	$pdf->SetX(82);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(30,6,iconv( 'UTF-8','TIS-620',$one_s),0,1,"R");
	
	$pdf->SetY(141);
	$pdf->SetX(115);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท/ครั้ง'),0,1,"L");
	
	$pdf->SetY(146);
	$pdf->SetX(77);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','2) รถยนต์สูญหาย/ไฟไหม้'),0,1,"L");
	
	$pdf->SetY(151);
	$pdf->SetX(82);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(30,6,iconv( 'UTF-8','TIS-620',$cost_3),0,1,"R");
	
	$pdf->SetY(151);
	$pdf->SetX(69);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท'),0,1,"R");
	
	$pdf->SetY(165);
	$pdf->SetX(76);
	$pdf->SetFont('angsa','B',22);
	$pdf->Cell(50,0,iconv( 'UTF-8','TIS-620','ไม่รวม พ.ร.บ.'),0,1,"C");
	
	$pdf->SetY(125);
	$pdf->SetX(130);
	$pdf->Cell(70,57,'',1);
	
	$pdf->SetY(126);
	$pdf->SetX(132);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','1) อุบัติเหตุส่วนบุคคล'),0,1,"L");
	
	$pdf->SetY(131);
	$pdf->SetX(135);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','1.1 เสียชีวิต สูญเสียอวัยวะ ทุพพลภาพถาวร'),0,1,"L");
	
	$pdf->SetY(136);
	$pdf->SetX(135);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','ก) ผู้ขับขี่'." ".'1'." ".'คน'),0,1,"L");
	
	$pdf->SetY(136);
	$pdf->SetX(145);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(30,6,iconv( 'UTF-8','TIS-620',$row['pa1']),0,1,"R");
	
	$pdf->SetY(136);
	$pdf->SetX(143);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท/ครั้ง'),0,1,"R");
	
	$pdf->SetY(141);
	$pdf->SetX(135);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','ข) ผู้โดยสาร'." ".$row['people']." ".'คน'),0,1,"L");
	
	$pdf->SetY(141);
	$pdf->SetX(145);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(30,6,iconv( 'UTF-8','TIS-620',$row['pa2']),0,1,"R");
	
	$pdf->SetY(141);
	$pdf->SetX(143);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท/คน'),0,1,"R");
	
	$pdf->SetY(146);
	$pdf->SetX(135);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','1.2 ทุพพลภาพชั่วคราว'),0,1,"L");
	
	$pdf->SetY(151);
	$pdf->SetX(135);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','ก) ผู้ขับขี่'." ".'1'." ".'คน'),0,1,"L");
	
	$pdf->SetY(151);
	$pdf->SetX(145);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(30,6,iconv( 'UTF-8','TIS-620',number_format($row['pa5'],0)),0,1,"R");
	
	$pdf->SetY(151);
	$pdf->SetX(143);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท/สัปดาห์'),0,1,"R");
	
	$pdf->SetY(156);
	$pdf->SetX(135);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','ข) ผู้โดยสาร'." ".$row['people']." ".'คน'),0,1,"L");
	
	$pdf->SetY(156);
	$pdf->SetX(145);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(30,6,iconv( 'UTF-8','TIS-620',number_format($row['pa6'],0)),0,1,"R");
	
	$pdf->SetY(156);
	$pdf->SetX(143);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท/คน/สัปดาห์'),0,1,"R");
	
	$pdf->SetY(161);
	$pdf->SetX(132);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','2) ค่ารักษาพยาบาล'),0,1,"L");
	
	$pdf->SetY(166);
	$pdf->SetX(145);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(30,6,iconv( 'UTF-8','TIS-620',$row['pa3']),0,1,"R");
	
	$pdf->SetY(166);
	$pdf->SetX(143);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท/คน'),0,1,"R");
	
	$pdf->SetY(171);
	$pdf->SetX(132);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','3) การประกันตัวผู้ขับขี่'),0,1,"L");
	
	$pdf->SetY(176);
	$pdf->SetX(145);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(30,6,iconv( 'UTF-8','TIS-620',$row['pa4']),0,1,"R");
	
	$pdf->SetY(176);
	$pdf->SetX(143);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท/ครั้ง'),0,1,"R");
	
	$pdf->SetY(182);
	$pdf->SetX(10);
	$pdf->Cell(120,12,'',1);
	
	$pdf->SetY(183);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','เบี้ยประกันตามความคุ้มครองหลัก'),0,1,"L");
	
	$pdf->SetY(183);
	$pdf->SetX(50);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','-'),0,1,"R");
	
	$pdf->SetY(183);
	$pdf->SetX(75);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท'),0,1,"R");
	
	$pdf->SetY(188);
	$pdf->SetX(12);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','(เบี้ยประกันภัยได้หักส่วนลดกรณีระบุชื่อผู้ขับขี่'),0,1,"L");
	
	$pdf->SetY(188);
	$pdf->SetX(50);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','0.00'),0,1,"R");
	
	$pdf->SetY(188);
	$pdf->SetX(75);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาทแล้ว)'),0,1,"R");
	
	$pdf->SetY(182);
	$pdf->SetX(130);
	$pdf->Cell(70,12,'',1);
	
	$pdf->SetY(183);
	$pdf->SetX(132);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','เบี้ยประกันภัยตามเอกสารแนบท้าย'),0,1,"L");
	
	$pdf->SetY(183);
	$pdf->SetX(133);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','-'),0,1,"R");
	
	$pdf->SetY(183);
	$pdf->SetX(143);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(53,6,iconv( 'UTF-8','TIS-620','บาท'),0,1,"R");
	
	$pdf->SetY(194);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(20,12,iconv( 'UTF-8','TIS-620','ส่วนลด'),1,1,"C");
	
	$pdf->SetY(194);
	$pdf->SetX(30);
	$pdf->Cell(55,12,'',1);
	
	$pdf->SetY(195);
	$pdf->SetX(30);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(55,6,iconv( 'UTF-8','TIS-620','ความเสียหายส่วนแรก'),0,1,"L");
	
	$pdf->SetY(195);
	$pdf->SetX(46);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(25,6,iconv( 'UTF-8','TIS-620',$row['disone']),0,1,"R");
	
	$pdf->SetY(195);
	$pdf->SetX(76);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(5,6,iconv( 'UTF-8','TIS-620','บาท'),0,1,"R");
	
	$pdf->SetY(200);
	$pdf->SetX(30);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(55,6,iconv( 'UTF-8','TIS-620','อื่นๆ'),0,1,"L");
	
	$pdf->SetY(200);
	$pdf->SetX(46);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(25,6,iconv( 'UTF-8','TIS-620','0.00'),0,1,"R");
	
	$pdf->SetY(200);
	$pdf->SetX(76);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(5,6,iconv( 'UTF-8','TIS-620','บาท'),0,1,"R");
	
	$pdf->SetY(194);
	$pdf->SetX(85);
	$pdf->Cell(60,12,'',1);
	
	$pdf->SetY(195);
	$pdf->SetX(85);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(60,6,iconv( 'UTF-8','TIS-620','ส่วนลดกลุ่ม'),0,1,"L");
	
	$pdf->SetY(195);
	$pdf->SetX(105);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(25,6,iconv( 'UTF-8','TIS-620',$row['dis_group3']),0,1,"R");
	
	$pdf->SetY(195);
	$pdf->SetX(135);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(5,6,iconv( 'UTF-8','TIS-620','บาท'),0,1,"R");
	
	$pdf->SetY(200);
	$pdf->SetX(85);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(60,6,iconv( 'UTF-8','TIS-620','ประวัติดี'),0,1,"L");
	
	$pdf->SetY(200);
	$pdf->SetX(105);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(25,6,iconv( 'UTF-8','TIS-620',$row['dis2']),0,1,"R");
	
	$pdf->SetY(200);
	$pdf->SetX(135);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(5,6,iconv( 'UTF-8','TIS-620','บาท'),0,1,"R");
	
	$pdf->SetY(194);
	$pdf->SetX(145);
	$pdf->Cell(55,12,'',1);
	
	$pdf->SetY(194);
	$pdf->SetX(145);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(55,12,iconv( 'UTF-8','TIS-620','รวมส่วนลด'),0,1,"L");
	
	$pdf->SetY(194);
	$pdf->SetX(131);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(55,12,iconv( 'UTF-8','TIS-620','0.00'),0,1,"R");
	
	$pdf->SetY(194);
	$pdf->SetX(141);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(55,12,iconv( 'UTF-8','TIS-620','บาท'),0,1,"R");
	
	$pdf->SetY(206);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(20,6,iconv( 'UTF-8','TIS-620','ส่วนลดเพิ่ม'),1,1,"C");
	
	$pdf->SetY(206);
	$pdf->SetX(30);
	$pdf->Cell(170,6,'',1);
	
	$pdf->SetY(206);
	$pdf->SetX(32);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,6,iconv( 'UTF-8','TIS-620','ประวัติเพิ่ม'),0,1,"L");
	
	$pdf->SetY(206);
	$pdf->SetX(90);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,6,iconv( 'UTF-8','TIS-620','-'),0,1,"L");
	
	$pdf->SetY(206);
	$pdf->SetX(130);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,6,iconv( 'UTF-8','TIS-620','บาท'),0,1,"L");
	
	$pdf->SetY(212);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(50,6,iconv( 'UTF-8','TIS-620','เบี้ยประกันสุทธิ'),1,1,"C");
	
	$pdf->SetY(218);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(50,10,iconv( 'UTF-8','TIS-620',$row['total_pre']),1,1,"C");
	
	$pdf->SetY(212);
	$pdf->SetX(60);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(25,6,iconv( 'UTF-8','TIS-620','อากร'),1,1,"C");
	
	$pdf->SetY(218);
	$pdf->SetX(60);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(25,10,iconv( 'UTF-8','TIS-620',number_format($row['total_stamp'],2)),1,1,"C");
	
	$pdf->SetY(212);
	$pdf->SetX(85);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(60,6,iconv( 'UTF-8','TIS-620','ภาษีมูลค่าเพิ่ม'),1,1,"C");
	
	$pdf->SetY(218);
	$pdf->SetX(85);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(60,10,iconv( 'UTF-8','TIS-620',$row['total_vat']),1,1,"C");
	
	$pdf->SetY(212);
	$pdf->SetX(145);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(55,6,iconv( 'UTF-8','TIS-620','รวม'),1,1,"C");
	
	$pdf->SetY(218);
	$pdf->SetX(145);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(55,10,iconv( 'UTF-8','TIS-620',$row['total_sum']),1,1,"C");
	
	$pdf->SetY(228);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(190,6,iconv( 'UTF-8','TIS-620','การใช้รถยนต์ :'),1,1,"L");
	
	$pdf->SetY(228);
	$pdf->SetX(30);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(190,6,iconv( 'UTF-8','TIS-620',$row['pass_car_name']),0,1,"L");
	
	$pdf->SetY(234);
	$pdf->SetX(10);
	$pdf->Cell(190,6,'',1);
	
	$pdf->Image('../images/Cyrillic.png',15,236,2,0);
	
	$pdf->SetY(234);
	$pdf->SetX(20);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(175,6,iconv( 'UTF-8','TIS-620','ตัวแทนประกันภัยรายนี้'),0,1,"L");
	
	$pdf->Image('../images/Logo_X.png',65,236,2,0);
	
	$pdf->SetY(234);
	$pdf->SetX(68);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(175,6,iconv( 'UTF-8','TIS-620','นายหน้าประกันภัยรายนี้'),0,1,"L");
	
	$pdf->SetY(234);
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(175,6,iconv( 'UTF-8','TIS-620','บจ. โฟร์ อินชัวร์ โบรกเกอร์'),0,1,"L");
	
	$pdf->SetY(234);
	$pdf->SetX(160);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(175,6,iconv( 'UTF-8','TIS-620','ใบอนุญาตเลขที่'),0,1,"L");
	
	$pdf->SetY(234);
	$pdf->SetX(180);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(175,6,iconv( 'UTF-8','TIS-620','ว00018/2551'),0,1,"L");
	
	$pdf->SetY(243);
	$pdf->SetX(15);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','วันทำสัญญาประกันภัย'),0);
	
	$pdf->SetY(243);
	$pdf->SetX(45);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',thaiDate2($row['send_date'])),0);
	
	$pdf->SetY(243);
	$pdf->SetX(140);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620','วันทำกรมธรรม์'),0);
	
	$pdf->SetY(243);
	$pdf->SetX(165);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',thaiDate($row['start_date'])),0);
	
	$pdf->SetY(250);
	$pdf->SetX(15);
	$pdf->SetFont('angsa','',10);
	$pdf->Cell(0,4,iconv('UTF-8','TIS-620','เอกสารฉบับนี้เป็นเพียงข้อเสนอประกันภัยรถยนต์เท่านั้น ส่วนเงื่อนไข ความคุ้มครอง ข้อยกเว้น เป็นไปตามที่กำหนดในกรมธรรม์ประกันภัยรถยนต์ และเอกสารแนบท้าย'),0,0,"C");
	
	//if($row['sort'] == 'VIB' || $row['sort'] == 'VIB_S' || $row['sort'] == 'VIB_Y' || $row['sort'] == 'VIB_S103') // วิริยะ
	if($row['sort'] == 'VIB_S103' && $row['single_rate'] != 'Y') // วิริยะ
	{		
		if($row['car_brand'] == 'Mitsubishi') // Mitsubishi
		{
			$newDate_regis = (date("Y")-$row['regis_date'])+1;
			//if($row['regis_date'] == '2015' && $row['doc_type'] == '1')
			if($newDate_regis == '2' && $row['doc_type'] == '1')
			{
				$pdf->SetY(260);
				$pdf->SetFont('angsa','',22);
				$pdf->Cell(0,4,iconv('UTF-8','TIS-620','การประกันภัยโจรกรรมสำหรับทรัพย์สินส่วนบุคคลที่อยู่ภายในรถยนต์ 20,000 บาท'),0,0,"C");
				
				$pdf->AddPage();
				$pdf->AddFont('angsa','','angsa.php');
				$pdf->AddFont('angsa','B','angsab.php');	
				
				$pdf->Image("../images/ex_1.jpg",0,0,210,0);
				
				$code_vib = '10320';
				
				$pdf->SetY(66);
				$pdf->SetX(31);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(15,0,iconv( 'UTF-8','TIS-620',$code_vib),0,0,"C");
				
				$pdf->SetY(73);
				$pdf->SetX(43);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',$row['title']."".$row['name']."  ".$row['last']),0,0,"L");
				
				$pdf->SetY(80);
				$pdf->SetX(68);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',thaiDate($row['start_date'])),0,1,"L");
				
				$pdf->SetX(120);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(0,0,iconv( 'UTF-8','TIS-620',thaiDate($row['end_date'])),0,1,"L");
				
				$pdf->SetY(86.5);
				$pdf->SetX(46);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(35,0,iconv( 'UTF-8','TIS-620','20,000'),0,0,"C");
				
				$pdf->SetY(93);
				$pdf->SetX(42);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(35,0,iconv( 'UTF-8','TIS-620','-'),0,0,"C");

				$pdf->SetY(99.5);
				$pdf->SetX(59);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(15,0,iconv( 'UTF-8','TIS-620','400.00'),0,0,"C");

				$pdf->SetX(99);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(15,0,iconv( 'UTF-8','TIS-620','2.00'),0,0,"C");

				$pdf->SetX(138);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(15,0,iconv( 'UTF-8','TIS-620','28.14'),0,0,"C");

				$pdf->SetX(166);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(15,0,iconv( 'UTF-8','TIS-620','430.14'),0,0,"C");
				
				/*
				$pdf->AddPage();
				$pdf->AddFont('angsa','','angsa.php');
				$pdf->AddFont('angsa','B','angsab.php');	
				
				$pdf->Image("../images/ex_2.jpg",0,0,210,0);
				
				$pdf->AddPage();
				$pdf->AddFont('angsa','','angsa.php');
				$pdf->AddFont('angsa','B','angsab.php');	
				
				$pdf->Image("../images/ex_3.jpg",0,0,210,0);
				*/
			}
		}
	}
	
	
	
	$pdf->Output();
	

	
?>

<? mysql_close(); ?>
