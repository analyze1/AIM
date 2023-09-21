<?php
	include "../pages/check-ses.php"; 
	//include "../inc/checksession.inc.php";
	include "../inc/connectdbs.inc.php";
	include "../inc/Barcode39.php";
	
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
	return $d."/".$m."/".$Y."  ".$H.":".$i.":".$s;
	}
	$IDDATA = $_GET["IDDATA"];
	
	$sql_cerf = 
	"SELECT certificate_datestamp,invoice_detail.id_data
	FROM certificate
	INNER JOIN invoice_detail ON certificate.inv_no=invoice_detail.inv_no
	WHERE invoice_detail.id_data='".$IDDATA."' Group By invoice_detail.id_data ORDER BY idC ASC LIMIT 1 ";
	mysql_select_db($db3,$cndb3);
	$obj_cerf = mysql_query($sql_cerf,$cndb3) or die ("Error sql_cerf [".$sql_cerf."]");
	$row_cerf = mysql_fetch_array($obj_cerf);
	
	$sql_ins = 
	"SELECT insuree.tel_mobile,insuree.tel_mobile2,insuree.tel_mobile3,insuree.tel_home,insuree.email,insuree.id_line,insuree.cus_code,insuree.claim_amount,insuree.policy_amount,insuree.tel_fax,insuree.SendAdd,insuree.vocation,
			premium.total_pre,premium.total_commition,premium.commition,premium.other,count(insuree.id_data) AS num_pre,
			data.start_date
	FROM insuree
	INNER JOIN premium ON (insuree.id_data=premium.id_data)
	INNER JOIN data ON (data.id_data=premium.id_data)
	WHERE insuree.id_data='".$IDDATA."' AND insuree.status_company!='C' GROUP BY insuree.id_data  ";
	mysql_select_db($db2,$cndb2);
	$obj_ins = mysql_query($sql_ins,$cndb2) or die ("Error sql_ins [".$sql_ins."]");
	$row_ins = mysql_fetch_array($obj_ins);

	$sql_year = 
	"SELECT count(data.start_date) AS count_year
	FROM insuree
	INNER JOIN data ON (data.id_data=insuree.id_data)
	WHERE cus_code='".$row_ins["cus_code"]."' AND insuree.status_company!='C'  Group By  DATE(data.id_data) ";
	mysql_select_db($db2,$cndb2);
	$obj_year = mysql_query($sql_year,$cndb2) or die ("Error sql_year [".$sql_year."]");
	$row_year = mysql_fetch_array($obj_year);

	//----------------- Condition ----------------------//
	
	if(trim($row_ins["tel_mobile"])!='' && trim($row_ins["tel_mobile"])!='-')
	{
		$tel_mobile='10';
	}
	if(trim($row_ins["tel_mobile2"])!=''  && trim($row_ins["tel_mobile2"])!='-')
	{
		$tel_mobile2='20';
	}
	if(trim($row_ins["tel_mobile3"])!=''  && trim($row_ins["tel_mobile3"])!='-' )
	{
		$tel_mobile3='20';
	}
	if(trim($row_ins["tel_home"])!=''  && trim($row_ins["tel_home"])!='-')
	{
		$tel_home='25';
	}
	if(trim($row_ins["tel_fax"])!=''  && trim($row_ins["tel_fax"])!='-')
	{
		$tel_office='25';
	}
	if(trim($row_ins["email"])!=''  && trim($row_ins["email"])!='-')
	{
		$email='25';
	}
	if(trim($row_ins["id_line"])!=''  && trim($row_ins["id_line"])!='-')
	{
		$id_line='25';
	}
	if(trim($row_ins["vocation"])!=''  && trim($row_ins["vocation"])!='-'){
	$vocation='10';
	}
	if(trim($row_ins["SendAdd"])!=''  && trim($row_ins["SendAdd"])!='-'){
		$SendAdd='10';
	}
	
	$grand=$tel_mobile+$tel_mobile2+$tel_mobile3+$tel_home+$email+$id_line+$tel_office+$vocation+$SendAdd;
	
	// ข้อมูลประกันภัย	
	$commition = floatval(preg_replace("/[^-0-9\.]/","",$row_ins["commition"]));
	$other = floatval(preg_replace("/[^-0-9\.]/","",$row_ins["other"]));
	$total_commition = floatval(preg_replace("/[^-0-9\.]/","",$row_ins["total_commition"]));
	
	if($total_commition != '')
	{
		$Discount=number_format((($commition+$other)/$total_commition)*100);
	}
	//------- ส่วนลด ------------//
	if($Discount<=1)
	{
		$txt_Discount='5';
	}
	else if($Discount>1 && $Discount<=5)
	{
		$txt_Discount='4';
	}
	else if($Discount>5 && $Discount<=10) 
	{
		$txt_Discount='3';
	}
	else if($Discount>10 && $Discount<=15) 
	{
		$txt_Discount='2';
	}
	else if($Discount>15) 
	{
		$txt_Discount='1';
	}
	
	// ------------- ระดับ เบี้ยชำระ -------------//
	
	$date7=date ("Y-m-d", strtotime("+7 day", strtotime($row_cerf["certificate_datestamp"])));
	$date15=date ("Y-m-d", strtotime("+15 day", strtotime($row_cerf["certificate_datestamp"])));
	$date30=date ("Y-m-d", strtotime("+10 day", strtotime($row_cerf["certificate_datestamp"])));
	
	if($row_cerf["certificate_datestamp"]<=$row_ins["start_date"])
	{
		$Payment_Pre='A';
	}
	else if($row_cerf["certificate_datestamp"]>$row_ins["start_date"] && $row_cerf["certificate_datestamp"]<=$date7) 
	{
		$Payment_Pre='B';
	}
	else if($row_cerf["certificate_datestamp"]>$date7 && $row_cerf["certificate_datestamp"]<=$date15) 
	{
		$Payment_Pre='C';
	}
	else if($row_cerf["certificate_datestamp"]>$date15 && $row_cerf["certificate_datestamp"]<=$date30) 
	{
		$Payment_Pre='D';
	}
	else if($row_cerf["certificate_datestamp"]>$date30) 
	{
		$Payment_Pre='E';
	}
	
	// ------------- ระดับ เบี้ยชำระ -------------//
	
	if($row_year["count_year"]==5)
	{
		$Num_year='K';
	}
	else if($row_year["count_year"]==4) 
	{
		$Num_year='L';
	}
	else if($row_year["count_year"]==3) 
	{
		$Num_year='M';
	}
	else if($row_year["count_year"]==2) 
	{
		$Num_year='N';
	}
	else if($row_year["count_year"]==1) 
	{
		$Num_year='O';
	}
	
	// ------------- ระดับ เคลม -------------//
	$total_pre=0.00;
	$cal_claim=0.00;
	
	$total_pre=str_replace(",","",$row_ins["total_pre"]);

	if($total_pre != '' and $total_pre != '0.00')
	{
		$cal_claim=number_format(($row_ins["claim_amount"]*100)/$total_pre);
	}
	
	if($cal_claim<1)
	{
		$claim='* * * * *';
	}
	else if($cal_claim>=1 && $cal_claim<=20) 
	{
		$claim='* * * *';
	}
	else if($cal_claim>20 && $cal_claim<=40) 
	{
		$claim='* * *';
	}
	else if($cal_claim>40 && $cal_claim<=60) 
	{
		$claim='* *';
	}
	else if($cal_claim>60) 
	{
		$claim='*';
	}
	
	// ------------- ระดับ จำนวนกรมธรรม์ -------------//
	
	$policy_amount=$row_ins["policy_amount"];
	$grand_statistic=$txt_Discount.''.$Payment_Pre.''.$claim.''.$Num_year.''.$policy_amount;
	
	$query = "SELECT ";
	$query .= "data.id,";	
	$query .= "data.doc_type,";
	$query .= "data.login, "; // รหัสผู้แจ้ง
	$query .= "tb_comp.name as comp_name, "; // บริษัทประกันภัย
	$query .= "tb_comp.name_print, "; // บริษัทประกันภัย
	$query .= "tb_comp.tel  as comp_tel, "; // เบอร์โทรศัพท์(แจ้งอุบัติเหตุ)
	$query .= "data.service, "; // ประเภทการซ่อม
	
	$query .= "data.com_data, ";
	$query .= "data.list_customer1, ";
	$query .= "data.list_customer2, ";
	$query .= "data.list_customer3, ";
	$query .= "data.list_customer4, ";
	$query .= "data.list_customer5, ";
	$query .= "data.pay_date, ";
	$query .= "data.list_customer, ";
	
	$query .= "tb_user.sub as branch, "; // สาขา
	$query .= "tb_user.contact, "; // ชื่อผู้แจ้ง
	$query .= "tb_user.cus_add, "; // บ้านเลขที่
	$query .= "tb_user.cus_group, "; // หมู่
	$query .= "tb_user.cus_town, "; //อาคาร/หมู่บ้าน
	$query .= "tb_user.cus_lane, "; // ซอย
	$query .= "tb_user.cus_road, "; // ถนน
	$query .= "tb_user.cus_tumbon, "; // ตำบล คีย์
	$query .= "tb_user.cus_amphur, "; // อำเภอ คีย์
	$query .= "tb_user.cus_province, "; // จังหวัด คีย์
	$query .= "tb_user.cus_postal , "; // รหัสไปรษณีย์
	
	$query .= "data.send_date,   "; // วันที่แจ้ง
	$query .= "data.name_inform, "; // รหัสผู้แจ้ง
	$query .= "data.id_data, "; // เลขที่รับแจ้ง
	$query .= "data.o_insure, "; // เลขที่กรมธรรมเดิม
	$query .= "data.ty_inform, "; // ประเภทงาน
	$query .= "data.idagent, "; //รหัสตัวแทน
	$query .= "data.start_date, "; // วันที่คุ้มครอง	
	$query .= "data.end_date, "; // วันที่สิ้นสุด
	$query .= "data.name_gain, "; // ชื่อผู้รับผลประโยชน์
	$query .= "data.q_auto, ";

	//////////////////////////////////////////
	$query .= "insuree.title, "; // คำนำหน้า ชื่อผู้เอาประกัน
	$query .= "insuree.name,  "; // ชื่อผู้เอาประกัน
	$query .= "insuree.last, "; // นามสกุลผู้เอาประกัน
	$query .= "insuree.career, "; // 
	$query .= "insuree.person, "; // 
	$query .= "insuree.vocation, "; // 
	$query .= "insuree.add, "; // บ้านเลขที่
	$query .= "insuree.icard, ";
	$query .= "insuree.id_business, ";
	$query .= "insuree.SendAdd, ";
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
	$query .= "insuree.tel_mobile3, "; // เบอร์โทร	
	$query .= "insuree.tel_home, "; // เบอร์โทร
	$query .= "insuree.tel_home2, "; // เบอร์โทร
	$query .= "insuree.tel_fax, "; // เบอร์โทร
	$query .= "insuree.tel_fax2, "; // เบอร์โทร
	$query .= "insuree.email, "; // Email
	$query .= "insuree.email2, "; // Email
	$query .= "insuree.email_cc, "; // Email_cc
	$query .= "insuree.id_line, ";
	$query .= "insuree.id_line2, ";
	$query .= "insuree.status_vip, ";
	$query .= "insuree.paytype, ";
	$query .= "tb_tumbon.name as tumbon_name, "; 
	$query .= "tb_amphur.name as amphur_name, "; 
	$query .= "tb_province.name as province_name, "; // จังหวัด
	$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
	$query .= "tb_br_car.name as car_brand, "; // ยี่ห้อรถ
	$query .= "tb_cat_car.name as cat_car_name, "; // ประเภทรถ
	$query .= "tb_mo_car.name as mo_car_name, "; // รุ่นรถ
	
	$query .= "insuree.status_company, ";
	$query .= "insuree.status_company_time, ";
	
	$query .= "detail.car_color, "; // สีรถ
	$query .= "detail.cc, "; // ซี ซ
	$query .= "detail.car_wg, "; // น.น.
	$query .= "detail.car_regis, "; // ทะเบียนรถ
	$query .= "detail.car_regis_pro, "; // ทะเบียนรถ
	$query .= "detail.car_body, "; // เลขตัวถัง
	$query .= "detail.regis_date, "; // ปีที่จดทะเบียน
	$query .= "detail.n_motor, "; // เลขเครื่อง
	$query .= "detail.Cancel_policy, ";
	$query .= "detail.Cancel_policy2, ";
	$query .= "detail.status_policy_time, ";
	
	$query .= "premium.id, ";
	$query .= "premium.id_data, ";
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
	$query .= "premium.tax1prb, ";
	$query .= "premium.vehicle_tax,";
	$query .= "premium.service_charge,";
	$query .= "premium.commition, "; // ส่วนลดเป็นบาท
	$query .= "premium.total_commition, "; // ยอดชำระ
	
	$query .= "premium.pre_old, ";
	$query .= "premium.one_old, ";
	$query .= "premium.disone_old, ";
	$query .= "premium.driver_old, ";
	$query .= "premium.dis1_old, ";
	$query .= "premium.good_old, ";
	$query .= "premium.dis2_old, ";
	$query .= "premium.group3_old, ";
	$query .= "premium.dis_group3_old, ";
	$query .= "premium.pro_dis_old, ";
	$query .= "premium.total_pro_dis_old, ";
	$query .= "premium.dis3_old, ";
	$query .= "premium.dis_vip_old, ";
	$query .= "premium.total_vip_old, ";
	$query .= "premium.total_dis4_old, ";
	$query .= "premium.total_pre_old, ";
	$query .= "premium.total_stamp_old, ";
	$query .= "premium.total_vat_old, ";
	$query .= "premium.total_sum_old, ";
	$query .= "premium.prb_old, ";
	$query .= "premium.total_prb_old, ";
	$query .= "premium.commition_old, ";
	$query .= "premium.other_old, ";
	$query .= "premium.vat_1_old, ";
	$query .= "premium.tax1prb_old,";
	$query .= "premium.vehicle_tax_old,";
	$query .= "premium.service_charge_old,";
	$query .= "premium.total_commition_old, ";
	$query .= "premium.editing, ";
	
	$query .= "protect.id, "; 
	$query .= "protect.cost, "; // ยอดชำระ
	$query .= "protect.damage_out1, ";
	$query .= "protect.damage_cost, ";
	$query .= "protect.pa1, ";
	$query .= "protect.pa2, ";
	$query .= "protect.pa3, ";
	$query .= "protect.pa4, ";
	$query .= "protect.people, ";
	
	$query .= "protect.cost_old, "; // ยอดชำระ
	$query .= "protect.damage_out1_old, ";
	$query .= "protect.damage_cost_old, "; 
	$query .= "protect.pa1_old, ";
	$query .= "protect.pa2_old, ";  
	$query .= "protect.pa3_old, "; 
	$query .= "protect.pa4_old, "; 
	$query .= "protect.people_old, ";
	
	$query .= "tb_agent.id_agent, ";
	$query .= "tb_agent.full_name, ";
	$query .= "tb_agent.agent_dis, ";
	$query .= "tb_agent.agent_group, ";
	
	//กรณีระบุชื่อผู้ขับขี่
	$query .= "driver.title_num1, "; // ผู้ขับขี่ที่ 1
	$query .= "driver.name_num1, ";
	$query .= "driver.last_num1, ";
	$query .= "driver.birth_num1, "; // วัน/เดือน/ปี (วันเกิด)
	$query .= "driver.title_num2, "; // ผู้ขับขี่ที่ 2
	$query .= "driver.name_num2, ";
	$query .= "driver.last_num2, ";
	$query .= "driver.birth_num2, "; // วัน/เดือน/ปี (วันเกิด)
	
	$query .= "act.act_id, ";
	$query .= "act.act_sort, ";
	$query .= "act.vat_car, ";
	
	$query .= "tb_user.Email,";
	$query .= "tb_user.Email2,";
	$query .= "tb_user.Email3,";
	$query .= "tb_user.Email4,";
	$query .= "tb_user.Email5, ";
	
	$query .= "tb_costprp.prp, ";
	$query .= "tb_comp.name_print ";
	
	$query .= "FROM data ";
	
	$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
	$query .= "INNER JOIN driver ON (driver.id_data = data.id_data)  ";
	$query .= "INNER JOIN service ON (data.id_data = service.id_data) ";
	$query .= "INNER JOIN premium ON (data.id_data = premium.id_data) ";
	$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
	$query .= "INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
	$query .= "INNER JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
	$query .= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
	$query .= "INNER JOIN act ON (act.id_data = data.id_data)  ";
	$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";	
	$query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
	$query .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
	$query .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
	$query .= "INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
	$query .= "INNER JOIN tb_province ON (tb_province.id = insuree.province) ";
	$query .= "INNER JOIN tb_user ON (tb_user.user = data.login) ";
	$query .= "INNER JOIN tb_costprp ON (tb_costprp.net = act.p_net) ";
	
	$query .= "INNER JOIN  tb_agent ON (tb_agent.id_agent = data.idagent) ";
	
	$query .= "WHERE data.id_data='".$IDDATA."' ";
	//echo $query;
	mysql_select_db($db2,$cndb2);
	$objQuery = mysql_query($query,$cndb2) or die ("Error Query tb_data [".$query."]");
	
	$row = mysql_fetch_array($objQuery);
	
	$query_name = "SELECT * FROM tb_user WHERE tb_user.user='".$row['name_inform']."' ";	
	$objQuery_name = mysql_query($query_name);
	$row_name = mysql_fetch_array($objQuery_name);
	
	// ส่วนลด คอมมิชชั่น
	$commition2 = $row['commition'];	
	$commition = str_replace("," , "" ,$commition2);	
	
	$other2 = $row['other'];	
	$other = str_replace("," , "" ,$other2);
	
	$com_and_other = $other +$commition;
	/////////////////////////////////////////////////
	
	// ส่วนลดคอมมิชชั่น เก่า 
	$commition2_old = $row['commition_old'];	
	$commition_old = str_replace("," , "" ,$commition2_old);
	
	$other2_old = $row['other_old'];	
	$other_old = str_replace("," , "" ,$other2_old);	
	
	$com_and_other_old = $other_old +$commition_old;
	//////////////////////////////////////////////////////////
	
	$new_iddata = split("/",$IDDATA);
	$inv =$new_iddata[0].'-'.$new_iddata[2];
	$bc = new Barcode39($inv);
	$bc->draw($inv.".gif");
	
?>
<?php
	require('../fpdf.php');

	define('FPDF_FONTPATH','font/');

	$pdf=new FPDF();
	
	$pdf->SetAutoPageBreak(false);
	
	$pdf->AddPage();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');

	// barcode
	$pdf->Image($inv.'.gif',60,12,40,0);
	//////////////////////////////////////////////////////////
	
	$pdf->SetY(8);
	$pdf->SetFont('angsa','B',18);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$row['name_print']),0,0,"L");
	
	// ลูกค้า VIP
	if($row['status_vip'] == 'Y')
	{
		$status_vip = 'ลูกค้า VIP';
	}
	//////////////////////////////////////////////////
	
	$pdf->SetY(19);
	$pdf->SetFont('angsa','B',30);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$status_vip),0,0,"L");

	$new_start_date = split("/", thaiDate($row['start_date']));
	
	$pdf->SetY(10);
	$pdf->SetX(174.5);
	$pdf->SetFont('angsa','B',25);
	$pdf->Cell(25,0,iconv('UTF-8','TIS-620',$new_start_date[0].$new_start_date[1].substr($new_start_date[2],2,2)),0,0,"C");
	
	$pdf->SetY(18);
	$pdf->SetX(174.5);
	$pdf->SetFont('angsa','B',25);
	$pdf->Cell(25,0,iconv('UTF-8','TIS-620',$row['com_data']),0,0,"C");
	
	// เลข ใบเสนอราคา
	if($row['q_auto'] != '')
	{ $q_auto = $row['q_auto']; }
	else
	{ $q_auto = '-'; }
	///////////////////////////////////////////////////
	
	$pdf->SetY(28);
	$pdf->SetX(10);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','ใบเสนอราคาเลขที่ : '.$q_auto),0,0,"L");
	
	$pdf->SetY(7);
	$pdf->SetX(110);
	$pdf->SetFont('angsa','B',16);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','วันที่คุ้มครอง'),0,0,"L");
	
	$pdf->SetY(7);
	$pdf->SetX(132);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',': '.thaiDate($row['start_date'])." - ".thaiDate($row['end_date'])),0,0,"L");
	
	$pdf->SetY(14);
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','เลขที่รับแจ้ง'),0,0,"L");
	
	if($row['com_data'] == 'VIB_S')
	{ $Company = '08829-'; }
	else if($row['com_data'] == 'VIB_S103')
	{ $Company = '10320-'; }
	else
	{ $Company = ' '; }
	
	$pdf->SetY(14);
	$pdf->SetX(132);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',': '.$Company.$row['id_data']),0,0,"L");
	
	$pdf->SetY(21);
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','พ.ร.บ.'),0,0,"L");
	
	// เลข พรบ
	if($row['act_id'] != '')
	{ $act_id = $row['act_id']; }
	else
	{ $act_id = "-"; }
	/////////////////////////////////////////////////////
	
	$pdf->SetY(21);
	$pdf->SetX(132);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',': '.$act_id),0,0,"L");
	
	$pdf->SetY(28);
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620','วันที่รับแจ้ง'),0,0,"L");
	
	$pdf->SetY(28);
	$pdf->SetX(132);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,0,iconv('UTF-8','TIS-620',': '.thaiDate2($row['send_date']).' น. - '.$row_name['sub']),0,0,"L");
	
	$pdf->SetY(32);
	$pdf->Cell(0,10,'',1,0,"C");
	
	$pdf->SetY(32);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,10,iconv('UTF-8','TIS-620','ประเภทการรับแจ้ง'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,10,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// ตัวแทนย่อย //////////////////////////////////////////////////////////////////
	$idat = $row['agent_group'];
	if($idat)
	{
		$sql = "SELECT * FROM `tb_agent` WHERE `id_agent`='$idat'";
		$result = mysql_query( $sql );
		mysql_query("set NAMES utf8");
		while( $fetcharr = mysql_fetch_array( $result ) )
		{
			$idagent_name = $fetcharr[id_agent];
		}
	}
	//////////////////////////////////////////////////////////////////////////////
	
	$pdf->SetX(48);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,10,iconv('UTF-8','TIS-620',$row['ty_inform'].' | ประกันภัยประเภท '.$row['doc_type'].' | '.$idagent_name),0,0,"L");	
	
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,10,iconv('UTF-8','TIS-620','เลขกรมธรรม์เดิม'),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,10,iconv('UTF-8','TIS-620',': '),0,0,"L");		
	
	$pdf->SetX(143);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,10,iconv('UTF-8','TIS-620',$row['o_insure']),0,0,"L");	
		
	$pdf->SetY(43);
	$pdf->Cell(0,42,'',1,0,"C");
	
	$pdf->SetY(43);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ผู้เอาประกันภัย'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	if($row['vocation'] != '')
	{ 
		$vocations = ' (อาชีพ : '.$row['vocation'].')';
	}
	
	$pdf->SetX(48);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$row['title'].' '.$row['name'].' '.$row['last'].$vocations),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','รหัสบัตรประชาชน'),0,0,"L");
	
	$pdf->SetX(170);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// เลขบัตรประชาชน
	if($row['icard'] != '')
	{
		$icard = $row['icard'];
	}
	else
	{
		$icard = "-";
	}
	//////////////////////////////////////////
	
	$pdf->SetX(173);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$icard),0,0,"L");
	
	$pdf->SetY(50);
	$pdf->SetX(140);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เลขนิติบุคคล'),0,0,"L");
	
	$pdf->SetX(170);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");
	
	// เลขนิติบุคคล
	if($row['id_business'] != '')
	{
		$id_business = $row['id_business'];
	}
	else
	{
		$id_business = "-";
	}
	////////////////////////////////////////////////////////
	
	$pdf->SetX(173);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$id_business),0,0,"L");
	
	$pdf->SetY(50);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ที่อยู่ปัจจุบัน'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");	
	
	$pdf->SetY(57);
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");	
	
	$career = trim($row['career']); // สถานที่
	$add = trim($row['add']); // บ้านเลขที่
	$group = trim($row['group']); // หมู่
	$town = trim($row['town']); // หมู่บ้าน
	$lane = trim($row['lane']); // ซอย
	$road = trim($row['road']); // ถนน
		
	// ที่อยู่
	if($career !="-" && $career !="")
	{
		$address_pdf = $career." "; //สถานที่
	}
	$address_pdf .= $add; // บ้านเลขที่
	if($group !="-" && $group !="")
	{
		$address_pdf .= " หมู่ ".$group;
	}
	if($town !="-" && $town !="")
	{
		$address_pdf .= " ".$town;
	}
	if($lane !="-" && $lane !="")
	{
		$address_pdf .= " ซอย ".$lane;
	}
	if($road !="-" && $road !="")
	{
		$address_pdf2 = " ถนน ".$road;
	}
	
	if($row['province'] != "102")
	{
		$address_pdf2 .= ' ต.'.$row['tumbon_name'].' อ.'.$row['amphur_name'].' จ.'.$row['province_name'];
	}
	else
	{
		$address_pdf2 .= ' แขวง'.$row['tumbon_name'].' '.$row['amphur_name'].' '.$row['province_name'];
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$pdf->SetY(50);
	$pdf->SetX(48);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$address_pdf),0,0,"L");
	
	$pdf->SetY(57);
	$pdf->SetX(48);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$address_pdf2." ".$row['postal']),0,0,"L");
	
	$pdf->SetY(64);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ที่อยู่จัดส่ง'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");	
	
	// ที่อยู่จัดส่ง
	if($row['SendAdd'] != '')
	{
		$SendAdd = $row['SendAdd'];
	}
	else
	{
		$SendAdd = "-";
	}
	//////////////////////////////////////////
	
	$pdf->SetX(48);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$SendAdd),0,0,"L");
	
	$pdf->SetY(71);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เบอร์มือถือ'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// เบอร์มือถือ
	if($row['tel_mobile']!='')
	{
		$tel_mobile = $row['tel_mobile'];
	}
	else
	{
		$tel_mobile = "-";
	}
	if($row['tel_mobile2']!='' && $row['tel_mobile2']!=' ')
	{
		$tel_mobile2 = ', '.$row['tel_mobile2'];
	}
	if($row['tel_mobile3']!='' && $row['tel_mobile3']!=' ')
	{
		$tel_mobile3 = ', '.$row['tel_mobile3'];
	}
	/////////////////////////////////////////////////////////////
	
	$pdf->SetX(48);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$tel_mobile.$tel_mobile2.$tel_mobile3),0,0,"L");
	
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เบอร์บ้าน'),0,0,"L");
	
	$pdf->SetX(127);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// เบอร์บ้าน
	if($row['tel_home'] !="")
	{
		$tel_home = $row['tel_home'];
	}
	else
	{
		$tel_home = "-";
	}
	if($row['tel_home2']!='' && $row['tel_home2']!=' ')
	{
		$tel_home2 = ', '.$row['tel_home2'];
	}
	///////////////////////////////////////////////
	
	$pdf->SetX(130);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$tel_home.$tel_home2),0,0,"L");
	
	if($row['id_line2'] !="")
	{
		$id_line = $row['id_line2'];
	}
	else if($row['id_line'] !="")
	{
		$id_line = $row['id_line'];
	}
	else
	{
		$id_line = '-';
	}
	
	$pdf->SetX(165);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','id line : '.$id_line),0,0,"L");
	
	$pdf->SetY(78);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','Email'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
		// Email
	if($row['email2'] !="")
	{
		$email = $row['email2'];
	}
	else if($row['email'] !="")
	{
		$email = $row['email'];
	}
	else
	{
		$email = '-';
	}
	/////////////////////////////////////////////////////////////
	
	$pdf->SetX(48);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$email),0,0,"L");	
	
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เบอร์แฟกซ์'),0,0,"L");
	
	$pdf->SetX(127);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// เบอร์แฟกซ์
	if($row['tel_fax'] !="" && $row['tel_fax'] !=" ")
	{
		$tel_fax = $row['tel_fax'];
	}
	else
	{
		$tel_fax = "-";
	}
	if($row['tel_fax2']!='' && $row['tel_fax2']!=' ')
	{
		$tel_fax2 = ', '.$row['tel_fax2'];
	}
	//////////////////////////////////////////////
	
	$pdf->SetX(130);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$tel_fax.$tel_fax2),0,0,"L");	
		
	$pdf->SetX(165);
	$pdf->SetFont('angsa','B',18);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$grand.' - '.$grand_statistic),0,0,"L");
		
	$pdf->SetY(86);
	$pdf->Cell(0,28,'',1,0,"C");
	
	$pdf->SetY(86);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ทะเบียนรถ'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// ชื่อจังหวัด ทะเบียนรถ
	$sql = "SELECT name_mini FROM tb_province WHERE id='".$row['car_regis_pro']."'";
	mysql_query("set NAMES utf8");
	$result = mysql_query( $sql );
	$fetcharr = mysql_fetch_array( $result ) ;
	$name_mini = $fetcharr['name_mini'];
	
	$sqlCar = "SELECT name as nameCar FROM tb_pass_car_type WHERE pass_car_id='".$row['car_id']."'";
	mysql_query("set NAMES utf8");
	$resultCar = mysql_query( $sqlCar );
	$rowCar = mysql_fetch_array( $resultCar ) ;
	////////////////////////////////////////////////////////////////////////////////////////////////

	$pdf->SetX(48);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$row['car_regis'].' '.$name_mini),0,0,"L");

	$pdf->SetFillColor(0,0,0);
	$pdf->SetTextColor(255,255,255);
	
	if($row['vat_car'] != '0000-00-00')
	{
		$vat_car = '(ภาษีรถ '.thaiDate($row['vat_car']).')';
		$pdf->SetX(70);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(30,7,iconv('UTF-8','TIS-620',$vat_car),0,0,"C",true);
	}

	$pdf->SetTextColor(0,0,0);
	
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ยี่ห้อ/รุ่นรถ'),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	$pdf->SetX(143);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$row['car_brand']." / ".$row['mo_car_name']),0,0,"L");
	
	$pdf->SetY(93);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เลขตัวถัง'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// ยกเลิกกรมธรรม์ เลขตัวถัง
	if($row['Cancel_policy2'] == "ยกเลิกกรมธรรม์")
	{
		$pdf->SetX(48);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ยกเลิกกรมธรรม์ วันที่ '.thaiDate($row['status_policy_time'])),0,0,"L");
	}
	else
	{
		$pdf->SetX(48);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$row['car_body']),0,0,"L");
    }	
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	$pdf->SetTextColor(0,0,0);
	
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ประเภทรถ'),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// CC
	if($row['cc'] !='')
	{
		$cc = $row['cc'];
	}
	else
	{
		$cc = "-";
	}
	//////////////////////////////////////////////////
	
	// WG
	if($row['car_wg'] !='')
	{
		$car_wg = $row['car_wg'];
	}
	else
	{
		$car_wg = "-";
	}
	/////////////////////////////////////////////////////
	
	$pdf->SetX(143);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','('.$row['car_id'].') '.$rowCar['nameCar']),0,0,"L");
	
	$pdf->SetY(100);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เลขเครื่อง'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// ยกเลิกกรมธรรม์ เลขเครื่อง
	if($row['Cancel_policy2'] == "ยกเลิกกรมธรรม์")
	{
		$pdf->SetX(48);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ยกเลิกกรมธรรม์ วันที่ '.thaiDate($row['status_policy_time'])),0,0,"L");
	}
	else
	{
		$pdf->SetX(48);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$row['n_motor']),0,0,"L");
    }
	////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$pdf->SetTextColor(0,0,0);

	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ซีซี/น.น./ปีรถ/สี'),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	$pdf->SetX(143);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$cc."/".$car_wg."/".$row['regis_date']."/".$row['car_color']),0,0,"L");
	
	$pdf->SetY(107);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ผู้รับผลประโยชน์'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	$pdf->SetX(48);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$row['name_gain']),0,0,"L");
	
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ประเภทการซ่อม'),0,0,"L");

	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// ประเภทการซ่อม
	if($row['service'] == "1")
	{
		$service = "ซ่อมห้าง";
	}
	if($row['service'] == "2")
	{
		$service = "ซ่อมอู่";
	}	
	//////////////////////////////////////////

	$pdf->SetX(143);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$service),0,0,"L");
	
	$pdf->SetY(115);
	$pdf->Cell(0,63,'',1,0,"C");	
	
	$pdf->SetY(115);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ผู้ขับขี่คนที่ 1'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// ผู้ขับขี่คนที่ 1
	if($row['name_num1']!="ไม่ระบุ")
	{
		$name_1 = $row['title_num1']." ".$row['name_num1']." ".$row['last_num1']." วันเกิด ".$row['birth_num1'];
	}
	else
	{
		$name_1 = "ไม่ระบุ";
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$pdf->SetX(48);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$name_1),0,0,"L");
	
	$pdf->SetY(122);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ผู้ขับขี่คนที่ 2'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// ผู้ขับขี่คนที่ 2
	if($row['name_num2']!="ไม่ระบุ")
	{
		$name_2 = $row['title_num2']." ".$row['name_num2']." ".$row['last_num2']." วันเกิด ".$row['birth_num2'];
	}
	else
	{
		$name_2 = "ไม่ระบุ";
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	$pdf->SetX(48);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$name_2),0,0,"L");
	
	$pdf->SetY(115);
	$pdf->SetX(110);
	$pdf->SetTextColor(255,0,0);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ค่าภาษีรถยนต์รายปี'),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");
	
	$pdf->SetX(143);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['vehicle_tax']),0,0,"L");
	
	$pdf->SetY(122);
	$pdf->SetX(110);
	$pdf->SetTextColor(255,0,0);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ค่าบริการ'),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");
	
	$pdf->SetX(143);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['service_charge']),0,0,"L");
	
	$pdf->SetY(129);
	$pdf->SetX(110);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ความเสียหายส่วนแรก'),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");
 	
	// ความเสียหายส่วนแรก
	if($row['one_old'] != "")
	{	
		$pdf->SetX(143);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['one_old']),0,0,"L");
		
		// เส้นขีีดฆ่า * ของความยาว ตัวอักษร
		$new_one_old = strlen($row['one_old']);
		$pdf->Line(143,133,143+$new_one_old*1.9,133);
		
		$pdf->SetX(163);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',": ".$row['one']),0,0,"L");
	}
	else
	{	
		$pdf->SetX(143);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['one']),0,0,"L");
	}
	/////////////////////////////////////////////////
	
	$pdf->SetY(129);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','%ส่วนลดพิเศษ'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");

	// ส่วนลดพิเศษ
	if($row['pro_dis_old'] != "" && $row['total_pro_dis_old'] != "")
	{	
		$pdf->SetX(48);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['pro_dis_old'].' ('.$row['total_pro_dis_old'].')'),0,0,"L");
		
		// เส้นขีีดฆ่า * ของความยาว ตัวอักษร
		$new_pro_dis_old = strlen($row['pro_dis_old'].'('.$row['total_pro_dis_old'].')');
		$pdf->Line(48,133,48+$new_pro_dis_old*1.8,133);
		

		$pdf->SetX(78);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',": ".$row['pro_dis'].' ('.$row['total_pro_dis'].')'),0,0,"L");
	}
	else
	{	
		$pdf->SetX(48);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['pro_dis'].' ('.$row['total_pro_dis'].')'),0,0,"L");
	}
	/////////////////////////////////////////////////
	
	$pdf->SetY(136);
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ทุนประกันภัย'),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");
	
	// ทุนประกันภัย
	if($row['cost_old'] != "")
	{	
		$pdf->SetX(143);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['cost_old']),0,0,"L");
		
		// เส้นขีีดฆ่า * ของความยาว ตัวอักษร
		$new_cost_old = strlen($row['cost_old']);
		$pdf->Line(143,140,143+$new_cost_old*1.8,140);
		
		$pdf->SetX(163);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',": ".$row['cost']),0,0,"L");
	}
	else
	{	
		$pdf->SetX(143);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['cost']),0,0,"L");
	}	
	/////////////////////////////////////////////////
	
	$pdf->SetY(136);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','%ส่วนลดกลุ่ม'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");
	
	// ส่วนลดกลุ่ม
	if($row['group3_old'] != "" && $row['dis_group3_old'] != "")
	{	
		$pdf->SetX(48);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['group3_old'].' ('.$row['dis_group3_old'].')'),0,0,"L");
		
		// เส้นขีีดฆ่า * ของความยาว ตัวอักษร
		$new_group3_old = strlen($row['group3_old'].'('.$row['dis_group3_old'].')');
		$pdf->Line(48,140,48+$new_group3_old*2,140);
		
		$pdf->SetX(78);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',": ".$row['group3'].' ('.$row['dis_group3'].')'),0,0,"L");
	}
	else
	{	
		$pdf->SetX(48);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['group3'].' ('.$row['dis_group3'].')'),0,0,"L");
	}
	/////////////////////////////////////////////////
	
	$pdf->SetY(143);
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เบี้ยสุทธิ'),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");
	
	// เบี้ยสุทธิ
	if($row['total_pre_old'] != "")
	{	
		$pdf->SetX(143);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['total_pre_old']),0,0,"L");
		
		// เส้นขีีดฆ่า * ของความยาว ตัวอักษร
		$new_total_pre_old = strlen($row['total_pre_old']);
		$pdf->Line(143,147,143+$new_total_pre_old*1.7,147);
		
		$pdf->SetX(163);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',": ".$row['total_pre']),0,0,"L");
	}
	else
	{	
		$pdf->SetX(143);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['total_pre']),0,0,"L");
	}
	/////////////////////////////////////////////////
	
	$pdf->SetY(143);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','%ส่วนลดผู้ขับขี่'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// ส่วนลดผู้ขับขี่
	if($row['driver_old'] != "")
	{	
		$pdf->SetX(48);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['driver_old']),0,0,"L");
		
		// เส้นขีีดฆ่า * ของความยาว ตัวอักษร
		$new_driver_old = strlen($row['driver_old']);
		$pdf->Line(48,147,48+$new_driver_old*2,147);
		
		$pdf->SetX(78);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',": ".$row['driver']),0,0,"L");
	}
	else
	{	
		$pdf->SetX(48);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['driver']),0,0,"L");
	}
	/////////////////////////////////////////////////
	
	$pdf->SetY(150);
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เบี้ยรวม'),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");	
	
	// เบี้ยรวม
	if($row['total_sum_old'] != "")
	{	
		$pdf->SetX(143);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['total_sum_old']),0,0,"L");
		
		// เส้นขีีดฆ่า * ของความยาว ตัวอักษร
		$new_total_sum_old = strlen($row['total_sum_old']);
		$pdf->Line(143,154,143+$new_total_sum_old*1.7,154);
		
		$pdf->SetX(163);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',": ".$row['total_sum']),0,0,"L");
	}
	else
	{	
		$pdf->SetX(143);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['total_sum']),0,0,"L");
	}
	/////////////////////////////////////////////////
	
	$pdf->SetY(150);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','%ส่วนลดประวัติดี'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");	
	
	// ส่วนลดประวัติดี
	if($row['good_old'] != "" && $row['dis2_old'] != "")
	{	
		$pdf->SetX(48);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['good_old'].' ('.$row['dis2_old'].')'),0,0,"L");
		
		// เส้นขีีดฆ่า * ของความยาว ตัวอักษร
		$new_group3_old = strlen($row['good_old'].'('.$row['dis2_old'].')');
		$pdf->Line(48,154,48+$new_group3_old*1.75,154);
		
		$pdf->SetX(78);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',": ".$row['good'].' ('.$row['dis2'].')'),0,0,"L");
	}
	else
	{	
		$pdf->SetX(48);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['good'].' ('.$row['dis2'].')'),0,0,"L");
	}
	/////////////////////////////////////////////////
	
	$pdf->SetY(157);
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เบี้ยรวม พ.ร.บ.'),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	if($row['act_sort'] == "1")
	{
		$sort = " [ไม่ระบุ]";
	}
	else
	{
		$sort = "  [".$row['act_sort']."]";
	}
	
	// เบี้ยรวม พ.ร.บ.
	if($row['prb_old'] != "")
	{	
		$pdf->SetX(143);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['prb_old']),0,0,"L");
		
		// เส้นขีีดฆ่า * ของความยาว ตัวอักษร
		$new_prb_old = strlen($row['prb_old']);
		$pdf->Line(143,161,143+$new_prb_old*1.7,161);
		
		$pdf->SetX(163);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',": ".$row['prb'].$sort),0,0,"L");
	}
	else
	{	
		$pdf->SetX(143);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['prb'].$sort),0,0,"L");
	}
	/////////////////////////////////////////////////
	
	$pdf->SetY(157);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','1% กรมธรรม์'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");
	
	// กรมธรรม์
	if($row['vat_1_old'] != "")
	{	
		$pdf->SetX(48);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['vat_1_old']),0,0,"L");
		
		// เส้นขีีดฆ่า * ของความยาว ตัวอักษร
		$new_vat_1_old = strlen($row['vat_1_old']);
		$pdf->Line(48,161,48+$new_vat_1_old*2+2,161);
		
		$pdf->SetX(78);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',": ".$row['vat_1']),0,0,"L");
	}
	else
	{	
		$pdf->SetX(48);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['vat_1']),0,0,"L");
	}
	/////////////////////////////////////////////////
	
	$pdf->SetY(164);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','1% พ.ร.บ.'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");
	
	// พ.ร.บ.
	if($row['tax1prb_old'] != "")
	{	
		$pdf->SetX(48);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['tax1prb_old']),0,0,"L");
		
		// เส้นขีีดฆ่า * ของความยาว ตัวอักษร
		$new_tax1prb_old = strlen($row['tax1prb_old']);
		$pdf->Line(48,168,48+$new_tax1prb_old*2+2,168);
		
		$pdf->SetX(78);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',": ".$row['tax1prb']),0,0,"L");
	}
	else
	{	
		$pdf->SetX(48);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',$row['tax1prb']),0,0,"L");
	}
	/////////////////////////////////////////////////
	
	$pdf->SetY(164);
	$pdf->SetX(110);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ยอดเต็ม'),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	$pdf->SetX(143);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$row['total_prb']),0,0,"L");
	
	$pdf->SetY(171);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ส่วนลดคอมมิชชั่น'),0,0,"L");
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	// % ส่วนลดคอมมิชชั่น ////////////////////////////////////////// กรณีซื้อ พรบ. อย่างเดียว
	if($row['total_pre'] =='0.00' && $com_and_other != '0.00')
	{
		$dis_c = round(($com_and_other *100)/str_replace(",","",$row['prp']),2);
	}
	// % ส่วนลดคอมมิชชั่น ////////////////////////////////////////// กรณีปกติ
	else if($row['total_pre'] !='0.00' && $com_and_other != '0.00')
	{
		$dis_c = round(($com_and_other *100)/str_replace(",","",$row['total_pre']),2);
	}
	else
	{
		$dis_c = "0";
	}
	///////////////////////////////////////////////////////////////////
	
	// % ส่วนลดคอมมิชชั่น ////////////////////////////////////////// กรณีซื้อ พรบ. อย่างเดียว และ มีการแก้ไขเบี้ย
	if($row['total_pre_old'] =='0.00' && $com_and_other_old != '0.00')
	{
		$dis_c_old = round(($com_and_other_old *100)/str_replace(",","",$row['prp']),2);
	}
	// % ส่วนลดคอมมิชชั่น ////////////////////////////////////////// กรณีปกติ
	else if($row['total_pre_old'] !='' && $com_and_other_old != '0.00')
	{
		$dis_c_old = round(($com_and_other_old *100)/str_replace(",","",$row['total_pre_old']),2);
	}
	else if($row['total_pre_old'] !='0.00' && $com_and_other_old != '0.00')
	{
		$dis_c_old = "0";
	}
	else
	{
		$dis_c_old = "0";
	}
	///////////////////////////////////////////////////////////////////
	
	// ส่วนลดคอมมิชชั่น
	if($com_and_other_old != "")
	{	
		$pdf->SetX(48);
		$pdf->SetTextColor(255,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',number_format($com_and_other_old,2)." (".$dis_c_old." %)"),0,0,"L");
		
		// เส้นขีีดฆ่า * ของความยาว ตัวอักษร
		$new_other_old = strlen($com_and_other_old);
		$pdf->Line(48,175,48+$new_other_old*3.5,175);
		
		$pdf->SetX(78);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',": ".number_format($com_and_other,2)." (".$dis_c." %)"),0,0,"L");
	}
	else
	{	
		$pdf->SetX(48);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',number_format($com_and_other,2)." (".$dis_c." %)"),0,0,"L");
	}
	/////////////////////////////////////////////////
	
	$pdf->SetY(171);
	$pdf->SetX(110);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ยอดชำระ'),0,0,"L");
	
	$pdf->SetX(140);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',':'),0,0,"L");		
	
	$new_total_commition = str_replace(",","",$row['total_commition']) + str_replace(",","",$row['vehicle_tax']) + str_replace(",","",$row['service_charge']);
	
	$pdf->SetX(143);
	$pdf->SetFont('angsa','B',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620',$row['total_commition']),0,0,"L");

	$pdf->SetY(179);
	$pdf->Cell(0,34,'',1,0,"C");
	
	// การชำระเงิน
	if($row['paytype'] == '1' && $row['ty_inform'] == 'L' && $row['doc_type'] == '1'  && $row['idagent'] == 'MBLT' || $row['idagent'] == 'NMBLT')
	{
		$paytype = "ชำระเงินโดย ลูกค้า";
	}
	else if($row['paytype'] == '2' && $row['ty_inform'] == 'L' && $row['doc_type'] == '1'  && $row['idagent'] == 'MBLT' || $row['idagent'] == 'NMBLT')
	{
		$paytype = "ชำระเงินโดย MBLT";
	}
	////////////////////////////////////
	
	// ส่งกรมธรรม์
	if($row['list_customer2'] != '')
	{
		$detail_1 = substr(" - ".$row['list_customer2']." ".$paytype,0,400);
	}
	// จ่ายแล้ว
	if($row['list_customer3'] != '')
	{
		$detail_2 = substr(" - ".$row['list_customer3']." ".$paytype,0,400);
	}
	// กำลังทำจ่าย
	if($row['list_customer4'] != '')
	{
		$detail_3 = substr(" - ".$row['list_customer4']." ".$paytype,0,400);
	}
	// ยังไม่จ่าย
	if($row['list_customer'] != '')
	{
		$detail_4 = substr(" - ".$row['list_customer']." ".$paytype,0,400);
	}
	// นัดตรวจสภาพรถ
	if($row['list_customer1'] != '')
	{
		$detail_5 = substr(" - ".$row['list_customer1'],0,400);
	}
	// ของแถม
	if($row['list_customer5'] != '')
	{
		$detail_6 = substr(" - ".$row['list_customer5'],0,400);
	}
	
	// เฉพาะ subaru เท่านั้น
	if($row['com_data'] == 'VIB_S122')
	{
		if($detail_4 == '')
		{
			$detail_4 = ' - ที่อยู่ '.$row['address'].' (เลขนิติบุคคล '.$row['id_card'].')';
		}
		else
		{
			$detail_4 = $detail_4;
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	
	if($detail_1 != '')
	{
		$pdf->SetY(179);
		$pdf->SetX(10);
		$pdf->SetFont('angsa','B',16);
		$pdf->SetFillColor(0,0,0);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(175,7,iconv('UTF-8','TIS-620','ด่วน!!!'),0,0,"L",true);
			
		$pdf->SetY(179);
		$pdf->SetX(25);
		$pdf->SetFont('angsa','B',12);
		$pdf->SetFillColor(0,0,0);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(175,7,iconv('UTF-8','TIS-620',$detail_1),0,0,"L",true);
		
		if($detail_2 != '')
		{
			$pdf->SetY(186);
			$pdf->SetX(10);
			$pdf->SetFont('angsa','B',16);
			$pdf->SetFillColor(0,0,0);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(175,7,iconv('UTF-8','TIS-620','ด่วน!!!'),0,0,"L",true);
			
			$pdf->SetY(186);
			$pdf->SetX(25);
			$pdf->SetFont('angsa','B',12);
			$pdf->SetFillColor(0,0,0);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(175,7,iconv('UTF-8','TIS-620',$detail_2),0,0,"L",true);
			
			if($detail_3 != '')
			{
				$pdf->SetTextColor(0,0,0);
				$pdf->SetY(193);
				$pdf->SetX(15);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_3),0,0,"L");
				
				if($detail_4 != '')
				{
					$pdf->SetTextColor(0,0,0);
					$pdf->SetY(200);
					$pdf->SetX(15);
					$pdf->SetFont('angsa','',12);
					$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_4),0,0,"L");
					
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(207);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(207);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}
				else
				{
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(200);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(200);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				} 
			}
			else
			{	
				if($detail_4 != '')
				{
					$pdf->SetTextColor(0,0,0);
					$pdf->SetY(193);
					$pdf->SetX(15);
					$pdf->SetFont('angsa','',12);
					$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_4),0,0,"L");
					
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(200);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(200);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}
				else
				{
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(193);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(193);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}
			}
		}
		else
		{	
			if($detail_3 != '')
			{
				$pdf->SetTextColor(0,0,0);
				$pdf->SetY(186);
				$pdf->SetX(15);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_3),0,0,"L");
				
				if($detail_4 != '')
				{
					$pdf->SetTextColor(0,0,0);
					$pdf->SetY(193);
					$pdf->SetX(15);
					$pdf->SetFont('angsa','',12);
					$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_4),0,0,"L");
					
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(200);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(200);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}
				else
				{
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(193);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(193);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}	
			}
			else
			{	
				if($detail_4 != '')
				{
					$pdf->SetTextColor(0,0,0);
					$pdf->SetY(186);
					$pdf->SetX(15);
					$pdf->SetFont('angsa','',12);
					$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_4),0,0,"L");
					
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(193);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(193);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}
				else
				{
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(186);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(186);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}
			}
		}
	}
	else
	{	
		if($detail_2 != '')
		{
			$pdf->SetY(179);
			$pdf->SetX(10);
			$pdf->SetFont('angsa','B',16);
			$pdf->SetFillColor(0,0,0);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(175,7,iconv('UTF-8','TIS-620','ด่วน!!!'),0,0,"L",true);
			
			$pdf->SetY(179);
			$pdf->SetX(25);
			$pdf->SetFont('angsa','B',12);
			$pdf->SetFillColor(0,0,0);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(175,7,iconv('UTF-8','TIS-620',$detail_2),0,0,"L",true);
			
			if($detail_3 != '')
			{
				$pdf->SetTextColor(0,0,0);
				$pdf->SetY(186);
				$pdf->SetX(15);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_3),0,0,"L");
				
				if($detail_4 != '')
				{
					$pdf->SetTextColor(0,0,0);
					$pdf->SetY(193);
					$pdf->SetX(15);
					$pdf->SetFont('angsa','',12);
					$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_4),0,0,"L");
					
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(200);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(200);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}
				else
				{
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(193);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(193);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}	
			}
			else
			{	
				if($detail_4 != '')
				{
					$pdf->SetTextColor(0,0,0);
					$pdf->SetY(186);
					$pdf->SetX(15);
					$pdf->SetFont('angsa','',12);
					$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_4),0,0,"L");
					
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(193);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(193);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}
				else
				{
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(186);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(186);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}
			}
		}
		else
		{	
			if($detail_3 != '')
			{
				$pdf->SetTextColor(0,0,0);
				$pdf->SetY(179);
				$pdf->SetX(15);
				$pdf->SetFont('angsa','',12);
				$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_3),0,0,"L");
				
				if($detail_4 != '')
				{
					$pdf->SetTextColor(0,0,0);
					$pdf->SetY(186);
					$pdf->SetX(15);
					$pdf->SetFont('angsa','',12);
					$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_4),0,0,"L");
					
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(193);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(193);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}
				else
				{
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(186);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(186);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}	
			}
			else
			{	
				if($detail_4 != '')
				{
					$pdf->SetTextColor(0,0,0);
					$pdf->SetY(179);
					$pdf->SetX(15);
					$pdf->SetFont('angsa','',12);
					$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_4),0,0,"L");
					
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(186);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(186);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}
				else
				{
					if($detail_5 != '')
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(179);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_5),0,0,"L");
					}
					else
					{
						$pdf->SetTextColor(0,0,0);
						$pdf->SetY(179);
						$pdf->SetX(15);
						$pdf->SetFont('angsa','',12);
						$pdf->MultiCell(180,7,iconv('UTF-8','TIS-620',$detail_6),0,2);
						//$pdf->Cell(120,7,iconv('UTF-8','TIS-620',$detail_6),0,0,"L");
					}
				}
			}
		}
	}
	
	$pdf->SetY(207);
	$pdf->SetFont('angsa','B',12);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','วันที่คุ้มครอง : '.thaiDate($row['start_date'])." - ".thaiDate($row['end_date'])),0,0,"R");
	
	$pdf->SetTextColor(0,0,0);
	$pdf->SetDrawColor(0,0,0);
	
	// การติดตาม //////////////////////////////////////////////////////
		$pdf->SetY(214);
		$pdf->SetX(10);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(20,6,iconv('UTF-8','TIS-620','วันที่นัดหมาย'),1,0,"C");
				
		$pdf->SetX(30);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(74.5,6,iconv('UTF-8','TIS-620','รายละเอียดการติดตาม'),1,0,"C");
		
		$pdf->SetX(105.5);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(20,6,iconv('UTF-8','TIS-620','วันที่นัดหมาย'),1,0,"C");
		
		$pdf->SetX(125.5);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(74.5,6,iconv('UTF-8','TIS-620','รายละเอียดการติดตาม'),1,0,"C");
		
		$pdf->SetY(220);
		$pdf->SetX(10);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',''),1,0,"C");
				
		$pdf->SetX(30);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(74.5,7,iconv('UTF-8','TIS-620',''),1,0,"C");
		
		$pdf->SetX(105.5);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',''),1,0,"C");
		
		$pdf->SetX(125.5);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(74.5,7,iconv('UTF-8','TIS-620',''),1,0,"C");
		
		$pdf->SetY(227);
		$pdf->SetX(10);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',''),1,0,"C");
				
		$pdf->SetX(30);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(74.5,7,iconv('UTF-8','TIS-620',''),1,0,"C");
		
		$pdf->SetX(105.5);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(20,7,iconv('UTF-8','TIS-620',''),1,0,"C");
		
		$pdf->SetX(125.5);
		$pdf->SetFont('angsa','B',12);
		$pdf->Cell(74.5,7,iconv('UTF-8','TIS-620',''),1,0,"C");
	/////////////////////////////////////////////////////////////////////
	
	/////////////////////////////////////////////////
	
	$pdf->SetY(235);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(25,7,iconv('UTF-8','TIS-620','ชำระโดย'),1,0,"L");
	
	$pdf->SetX(35);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(165,7,iconv('UTF-8','TIS-620',''),1,0,"L");
	
	$pdf->Image('../images/2.jpg',38,236.5,4,0);
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เข้าโฟร์'),0,0,"L");
	
	$pdf->Image('../images/2.jpg',60,236.5,4,0);
	
	$pdf->SetX(67);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เข้าบริษัทประกันภัย'),0,0,"L");
	
	$pdf->SetX(110);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(20,7,iconv('UTF-8','TIS-620','ยอดชำระ'),1,0,"L");
	
	$pdf->SetX(165);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(10,7,iconv('UTF-8','TIS-620','วันที่'),1,0,"C");
	
	$pdf->SetY(242);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(25,14,iconv('UTF-8','TIS-620',''),1,0,"L");
	
	$pdf->SetY(242);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(25,7,iconv('UTF-8','TIS-620','ประเภทการชำระ'),0,0,"L");
	
	$pdf->SetX(35);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(165,14,iconv('UTF-8','TIS-620',''),1,0,"L");
	
	$pdf->Image('../images/2.jpg',38,243.5,4,0);
	
	$pdf->SetX(45);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เงินสด'),0,0,"L");
	
	$pdf->Image('../images/2.jpg',60,243.5,4,0);
	
	$pdf->SetX(67);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เงินโอน'),0,0,"L");
	
	$pdf->Image('../images/2.jpg',83,243.5,4,0);
	
	$pdf->SetX(90);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','เช็ค'),0,0,"L");
	
	$pdf->Image('../images/2.jpg',100,243.5,4,0);
	
	$pdf->SetX(107);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','บัตรเครดิต'),0,0,"L");
	
	$pdf->Image('../images/2.jpg',127,243.5,4,0);
	
	$pdf->SetX(134);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ผ่อนชำระ 0% 3 เดือน'),0,0,"L");
	
	$pdf->Image('../images/2.jpg',168,243.5,4,0);
	
	$pdf->SetX(175);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','VAD'),0,0,"L");
	
	$pdf->SetY(249);
	$pdf->SetX(37);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ธนาคาร _______________________________ เลขที่อ้างอิง _________________________ วันที่ ____________________'),0,0,"L");
	
	$pdf->SetY(256);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(25,7,iconv('UTF-8','TIS-620','ส่ง กธ./พรบ.'),1,0,"L");
	
	$pdf->SetX(35);
	$pdf->SetFont('angsa','',14);
	$pdf->Cell(165,7,iconv('UTF-8','TIS-620',''),1,0,"L");
	///////////////////////////////////////////////////////////////////////
	
	// ฝ่ายงาน /////////////////////////////////////////////////////////
	$pdf->SetY(264);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620','ฝ่ายงาน'),1,0,"L");
	
	$pdf->SetX(30);
	$pdf->Cell(25,6,iconv('UTF-8','TIS-620','รับประกัน'),1,0,"C");
	
	$pdf->SetX(55);
	$pdf->Cell(25,6,iconv('UTF-8','TIS-620','กรมธรรม์'),1,0,"C");
	
	$pdf->SetX(80);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620','เร่งรัด'),1,0,"C");
	
	$pdf->SetX(100);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620','ออก พรบ.'),1,0,"C");
	
	$pdf->SetX(120);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620','ส่งกรม'),1,0,"C");
	
	$pdf->SetX(140);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620','รับเงิน'),1,0,"C");
	
	$pdf->SetX(160);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620','ตัดรับ'),1,0,"C");
	
	$pdf->SetX(180);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620','ตัดจ่าย'),1,0,"C");
	
	$pdf->SetY(270);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620','ลงนาม'),1,0,"L");
	
	$pdf->SetX(30);
	$pdf->Cell(25,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(55);
	$pdf->Cell(25,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(80);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(100);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(120);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(140);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(160);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(180);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetY(276);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620','วันที่'),1,0,"L");
	
	$pdf->SetX(30);
	$pdf->Cell(25,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(55);
	$pdf->Cell(25,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(80);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(100);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(120);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(140);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(160);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	
	$pdf->SetX(180);
	$pdf->Cell(20,6,iconv('UTF-8','TIS-620',''),1,0,"C");
	///////////////////////////////////////////////////////////////////////
	
	if($row['agent_dis'] =='0')
	{
		$agent_dis = "-";
	}
	else
	{
		$agent_dis = $row['agent_dis'];
	}
	
	$pdf->SetY(279.5);
	$pdf->SetFont('angsa','',12);
	$pdf->Cell(0,10,iconv('UTF-8','TIS-620',$row['full_name']." ค่าคอมมิชชั่น : ".$agent_dis." % (".$row['other'].")"),0,0,"L");	
	
	$pdf->SetY(285);
	$pdf->SetFont('angsa','B',18);
	$pdf->Cell(25,8,iconv('UTF-8','TIS-620','หมายเหตุ : '),0,0,"L");
	
	$pdf->SetTextColor(0,0,0);
	
	$pdf->SetX(35);
	$pdf->SetFont('angsa','',16);
	$pdf->Cell(0,8,iconv('UTF-8','TIS-620',$row['Cancel_policy'].' '.$row['editing']),0,0,"L");
	
	if($row['status_company'] == 'Y')
	{
		$status_company = ' วันที่ส่ง E-mail : '.thaiDate2($row['status_company_time']);
	}
	else
	{
		$status_company = '';
	}
	
	$pdf->SetY(-7);
	$pdf->SetX(105);
	$pdf->SetFont('angsa','',10);
	$pdf->Cell(0,7,iconv('UTF-8','TIS-620','ผู้คีย์งาน : '.$row['title_sub'].' '.$row['sub_user']."   ".'วันที่พิมพ์ '.thaiDate2(date("Y-m-d H:i:s"))."   ผู้พิมพ์ : ".$_SESSION["4NameSMS"].$status_company),0,0,"R");
	
	$pdf->Output();
	unlink($inv.'.gif');
mysql_close(); 
?>
