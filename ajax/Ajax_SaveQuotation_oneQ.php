<?
include "../inc/checksession.inc.php";
include "../inc/connectdbs.inc.php";

if(!empty($_SESSION["4User"]))
{					
	$login = $_SESSION["4User"]; // ผู้แจ้ง
	$name_inform = $login;

	$hidden_discount= $_POST["hidden_discount"];
		
	$car_type= $_POST["cartype"];
	$id_emp= $_POST["id_emp"]; 
	$com_data = $_POST["com_data"]; // บริษัทประกัน
	$send_date = date('Y-m-d H:i:s'); // วันที่แจ้ง
	$id_data = $_POST["id_data"]; // เลขที่รับแจ้ง
	$ty_inform = $_POST["ty_inform"]; // ประเภทการแจ้ง (ต่ออายุ ใหม่)
	$o_insure = $_POST["o_insure"]; // กธ. เก่า
							
	//$idagent = $_POST["currentText"]; //รหัสตัวแทน
	$idagent = "C0001"; //รหัสตัวแทน
							
	$doc_type = $_POST["doc_type"]; // ประเภท 1 2 3
	$icard = $_POST["icard"]; // icard
	$niti = $_POST["niti"]; // id_niti
	$startDate = $_POST["start_date"]; // วันที่คุ้มครอง
	$code = $_POST['code'];
	$car_regis_type = $_POST['car_regis_type'];
	$contact =  $_POST['contact'];
	$q_manual =  $_POST['q_manual'];
	$year_old =  $_POST['year_old'];
	$id_data_old =  $_POST['id_data_old'];
							
	$startDate_dd = substr($startDate,0,2);
	$startDate_mm = substr($startDate,3,2);
	$startDate_yy = substr($startDate,6,4);
	$start_date = $startDate_yy."-".$startDate_mm."-".$startDate_dd;
							
	$year_plus = $startDate_yy+1;
	$end_date = $year_plus."-".$startDate_mm."-".$startDate_dd;;

	$actCheck = $_POST["actCheck"]; // ดึงเลขพรบหร้อไม
	$service = $_POST["service"];
	$tax_prb = $_POST["vat_2"];
													
	//// สาขาการแจ้งงาน
	$name_gain = $_POST["name_gain"];
							
	// ระบุผู้ขับขี่-----------------------------------------------------------------------------

	$rdodriver = $_POST["rdodriver"];
	if ($rdodriver == "N" OR $rdodriver == "0" OR $rdodriver == "")
	{
		$title_num1 = "ไม่ระบุ";
		$name_num1 = "ไม่ระบุ";
		$last_num1 = "ไม่ระบุ";
		$birth_num1 = "ไม่ระบุ";
		$title_num2 = "ไม่ระบุ";
		$name_num2 = "ไม่ระบุ";
		$last_num2 = "ไม่ระบุ";
		$birth_num2 = "ไม่ระบุ";
	}
	else
	{
		$title_num1 = $_POST["title_num1"];
		$name_num1 = $_POST["name_num1"];
		$last_num1 = $_POST["last_num1"];
		$birth_num1 = $_POST["birth_num1"];
		$title_num2 = $_POST["title_num2"];
		$name_num2 = $_POST["name_num2"];
		$last_num2 = $_POST["last_num2"];
		$birth_num2 = $_POST["birth_num2"];
	}
												
	//ฐานข้อมูล insuree ส่วนผู้เอาประกัน--------------------------------------------------
	$title = $_POST["title"];
	$name = $_POST["name"];
	$last = $_POST["last"];
	$person = $_POST["person"];
	$career = $_POST["paytype"];
	$add = $_POST["add"];
	$group = $_POST["group"];
	$town = $_POST["town"];
	$lane = $_POST["lane"];
	$road = $_POST["road"];
	
	/*
	$tumbon = $_POST["tumbon"];
	$amphur = $_POST["amphur"];
	$province = $_POST["province"];
	$postal = $_POST["postal"];	
	*/
	
	$tumbon = "0";
	$amphur = "0";
	$province = "0";
	$postal = "0";
							
	$arr_tel_mobile = explode("-",$_POST["tel_mobile"]);
	$tel_mobile = $arr_tel_mobile[0].$arr_tel_mobile[1].$arr_tel_mobile[2];
	$arr_tel_mobile2 = explode("-",$_POST["tel_mobile2"]);
	$tel_mobile2 = $arr_tel_mobile2[0].$arr_tel_mobile2[1].$arr_tel_mobile2[2];
	$arr_tel_home = explode("-",$_POST["tel_home"]);
	$tel_home = $arr_tel_home[0].$arr_tel_home[1].$arr_tel_home[2];
	$arr_tel_fax = explode("-",$_POST["tel_fax"]);
	$tel_fax = $arr_tel_fax[0].$arr_tel_fax[1].$arr_tel_fax[2];
	$email = $_POST["email"];
	$email_cc = $_POST["email2"];
	$status  = "N";
	$status_sms = "N";
	$status_insured = "N";
	$status_company = "N";
	$st_email = "N";
	$st_sms = "N";
	
	//ฐานข้อมูล detail เกี่ยวกับรถ
	$car_id = $_POST["car_id"];
	$br_car = $_POST["br_car"];
	$mo_car = $_POST["mo_car"];
	$car_body =  $_POST["car_body"];
	$n_motor = $_POST["n_motor"];
	if($_POST["chose_carregis"]!=1)
	{
		$car_regis = $_POST["car_regis"];
	}
	else
	{
		/*	
		$strSQL = "SELECT car_regis FROM detail WHERE car_regis LIKE '%ปดF%' ORDER BY car_regis DESC LIMIT 0,1";
		mysql_query("SET NAMES 'utf8'");
		$result = mysql_query( $strSQL );
		$result_carregis = mysql_fetch_array( $result ) ;
		$resplit = $result_carregis['car_regis'];
		list($re, $carpd) = split('[ F-]', $resplit);
		if($carpd=="")
		{
			$carpd="0049";
		}
		$idSum = $carpd+1;
		$sumstr = strlen($idSum);
		$zero = str_repeat("0", 4-$sumstr);
		$car_regis = 'ปดF'.$zero.$idSum;  									
		*/
	}
	
	$chose_carregis =  $_POST["chose_carregis"];
	
	if ($_POST["chose_carregis"]=1)
	{
		$regis = "ป้ายแดง";
	}
	
	$car_regis_pro = $_POST["car_regis_pro"];
	$car_color = $_POST["car_color"];
	$car_cc = $_POST["car_cc"];
	$cc = $_POST["cc"];
	$car_seat = $_POST["car_seat"];
	$qty_car = $_POST["qty_car"];
	$car_wg = $_POST["wg"];
	$gear = $_POST["gear"];
	$regis_date = $_POST["regis_date"];
	$cat_car = $_POST["cat_car"];
	$car_detail1 = $_POST["acc1"];
	$car_detail2 = $_POST["acc2"];
	$car_detail3 = $_POST["acc3"];
	$car_detail4 = $_POST["acc4"];
	$car_detail_p1 = $_POST["acccost1"];
	$car_detail_p2 = $_POST["acccost2"];
	$car_detail_p3 = $_POST["acccost3"];
	$car_detail_p4 = $_POST["acccost4"];
	$wg_id = $_POST["wg_id"];
	$wg_m = $_POST["wg_m"];
							
	$q_auto = $_POST["q_no"];
	$code_new = $_POST["code_new"];
	$none_disone = $_POST["none_disone"];
	$one = $_POST["one"];
	$vat1 = $_POST["vat1"];
							
	if($_POST["wg_id"]=="ตั้งแต่ 4-12")
	{
		$wg_m = $_POST["wg_id"];
	}
	else
	{
		$wg_m = $wg_m;
	}
							
	/////////////////////////////-------Qoatation Auto------
	
	$year = date('y')+43;
	$Qoutation = 'QF'.$year;
	
	$strSQL_q = "SELECT q_auto FROM quotation WHERE q_auto like '%QF%' ORDER BY id DESC LIMIT 0,1";
	mysql_select_db($db2,$cndb2);
	$result_q = mysql_query( $strSQL_q,$cndb2 );
	$result_qu = mysql_fetch_array( $result_q ) ;
	$resplit_q = $result_qu['q_auto'];
	
	$Qoutation_aa = str_replace($Qoutation,"",$resplit_q);
	if($Qoutation_aa=="")
	{
		$Qoutation_aa="0000";
	}
								
	$Qoutationsum = $Qoutation_aa+1;
	$sumstrdata = strlen($Qoutationsum);
	$zerodata = str_repeat("0", 4-$sumstrdata);
	$q_no = $Qoutation.$zerodata.$Qoutationsum;		
							
							
	//list($re, $carpd) = split('[ F-]', $resplit);
	/*$year = date('y')+43;
	if($resplit_q=="")
	{										
		$q_no = 'QF'.$year.'0001';
	}
	else
	{
		$qq =  substr($resplit_q,2,6);
		$idSum_q = $qq+1;
		$sumstr_q = strlen($idSum_q);
		echo $zero_q = str_repeat("0", 3-$sumstr);
		$q_no = 'QF'.$idSum_q;
	}*/
	
	//----------------ความคุ้มครอง-----------------------------
	$damage_out1 = $_POST["damage_out1"];
	$damage_cost = $_POST["damage_cost"];
	$pa1 = $_POST["pa1"];
	$pa2 = $_POST["pa2"];
	$pa3 = $_POST["pa3"];
	$pa4 = $_POST["pa4"];
	$people = $_POST["people"];
	$cost = $_POST["cost"];
						 
	//เบี้ยประกัน----------------------------------------------
	$pre = $_POST["pre"];
	$one = $_POST["one"]; //ความเสียหายส่วนแรก
	$disone = $_POST["disone"];
	$driver = $_POST["driver"]; 
	$dis_driver = $_POST["driver"]; // ส่วนลด % ระบุผู้ขับขี่							
	$total_dis1 = 0.00; // ส่วนลด
	$good = $_POST["good"];
		
	if($_POST['goodb'] == '0')
	{
		$total_dis2 = $_POST["total_dis2"]; // ส่วนลด
	}
	else if($_POST['goodb'] != '0')
	{
		$total_dis2 = $_POST['goodb'];
	}
		
	$group3 = $_POST["group3"]; // 10%
	$dis_group3 = $_POST["dis_group3"]; // รวมส่วนลดกลุ่ม
	$total_dis3 = $_POST["total_dis3"]; // ส่วนลดตัวแทน
	$dis_vip = $_POST["dis_vip"]; // ส่วนลดเป็น %
	$total_vip = $_POST["total_vip"]; // -ส่วนลด
	$pro_dis = $_POST["pro_dis"]; // -ส่วนลดพิเศษ
	$pro_dis2 = $_POST["pro_dis2"]; // -ส่วนลดพิเศษ
	$total_pro_dis = $_POST["total_pro_dis"]; // -ส่วนลดพิเศษ
	$total_dis4 = $_POST["total_dis4"]; // รวมส่วนลดเป้น %
	$total_pre = $_POST["total_pre"];
	$total_stamp = $_POST["total_stamp"];
	$total_vat = $_POST["total_vat"];
	$total_sum = $_POST["total_sum"];
	$currentValue = $_POST["currentValue"];
	$p_id = $_POST["currentText_prb"]; //พรบ.
	$p_pre = "";
	$p_stamp = "";
	$p_tax = "";
	if($_POST["currentValue_prb"] == '0.00')
	{
		$prb = '0'; //พรบ.
	}
	else
	{
		$prb = $_POST["currentValue_prb"]; //พรบ.
	}
	
	$total_prb = $_POST["total_prb"];
	$commition = $_POST["commition"];
	$other = $_POST["other"];
	$vat_1 = $_POST["vat_1"];
	$vehicle_tax = $_POST["vehicle_tax"];
	$service_charge = $_POST["service_charge"];
	$total_commition = $_POST["total_commition"];
	$act_sort = $_POST["act_sort"];

	
	//// อู่รถ
	$fac1 = $_POST["facsave1"];
	$fac2 = $_POST["facsave2"];
	$fac3 = $_POST["facsave3"];
		
	$strSQL = "INSERT INTO act_quotation (`id`, `q_auto`, `p_id`, `p_pre`, `p_stamp`, `p_tax`, `p_net`, `act_id`, `act_sort`) VALUES (NULL, '$q_no',  '$p_id', '$p_pre', '$p_stamp', '$p_tax', '$prb', '$act', '$act_sort')";												
	mysql_select_db($db2,$cndb2);
	$objQuery = mysql_query($strSQL,$cndb2);	

							
							
	$strSQL = "INSERT INTO data_quotation (`id`, `login`,`q_auto`, `com_data`, `send_date`, `ty_inform`, `o_insure`,  `start_date`, `end_date`, `name_inform`, `name_gain`, `service`, `idagent`, `list_customer1`, `list_customer2`, `list_customer3`, `list_customer4`, `pay_date`, `list_customer`, `doc_type`,qstatus) VALUES (NULL, '".$login."', '$q_no', '$com_data', '$send_date', '$ty_inform', '$o_insure', '$start_date', '$end_date', '$name_inform', '$name_gain', '$service', '$idagent', '$list_customer1', '$list_customer2', '$list_customer3', '$list_customer4', '$pay_date', '$list_customer', '$doc_type','QF')";								
	mysql_select_db($db2,$cndb2);
	$objQuery = mysql_query($strSQL,$cndb2);
									
	$strSQL = "INSERT INTO driver_quotation (`id`, `q_auto`, `title_num1`, `name_num1`, `last_num1`, `birth_num1`, `title_num2`, `name_num2`, `last_num2`, `birth_num2`, `qstatus`) VALUES (NULL, '$q_no', '$title_num1', '$name_num1', '$last_num1', '$birth_num1', '$title_num2', '$name_num2', '$last_num2', '$birth_num2','QF')";												
	mysql_select_db($db2,$cndb2);
	$objQuery = mysql_query($strSQL,$cndb2);		
		/*echo $strSQL."<BR>";*/			
	$car_price = $_POST["pricecar"];
	$acc_name1 = $_POST["acc_name1"];
	$acc_name2 = $_POST["acc_name2"];
	$acc_name3 = $_POST["acc_name3"];
	$accprice1 = $_POST["accprice1"];
	$accprice2 = $_POST["accprice2"];
	$accprice3 = $_POST["accprice3"];
							
	$access1 = $_POST["access1"];
	$access2 = $_POST["access2"];
	$access3 = $_POST["access3"];
							
	$strSQL = "INSERT INTO tb_acc_car (`id`, `q_auto`, `qty_car`, `car_price`, `acc_name1`, `acc_name2`, `acc_name3`, `acc_price1`, `acc_price2`, `acc_price3`) VALUES (NULL, '$q_no', '$qty_car','$car_price', '$acc_name1', '$acc_name2', '$acc_name3', '$accprice1', '$accprice2', '$accprice3')";												
	mysql_select_db($db2,$cndb2);
	$objQuery = mysql_query($strSQL,$cndb2);	
												
	/////// Insert qoutation //////////
	$pretotal = $fetcharr_vatper['total_pre'];
	$sumstamp = $fetcharr_vatper['total_stamp'];
	$total_vat1 = ($pretotal+$sumstamp)*0.01 ;   
						$customer=$_POST['customer'];
						$agent_group=$_POST['agent1'];
						$product=$_POST['product'];
	//$grand = $arrdata[0]['total_sum'] - $total_vat1;  /// เบี้ยหลังหัก ณ ที่จ่าย												
	$strsql = "INSERT INTO quotation (id   , id_customer  , id_cat_car, car_regis_type, id_car_regis, car_type   , car_id  , id_br_car  , id_mo_car, cc   ,car_color   , gear         ,car_seat    ,wg_name     ,qty_car  ,regis_date     ,car_regis_pro      , q_auto   , `q_manual` , net_pre   ,qty_driver     , dis_driver    , dis_damage1   , dis_group3_per, dis_group3_amt, hisgood_per, hisgood_amt   , disextra_per, disextra_amt  , net_pre_dis , pre_stamp     , pre_vat      , pre_total    , id_prb  , prb_amt ,tax1per , hold_tax, sum_pre_prb  , com_dis_per, com_dis_agent_per ,com_dis_amt    , com_total  , vehicle_tax   , service_charge   , grand_total       , insu_amt  , human_amt    , asset_amt      , drive1_amt, passenger   , passenger_amt  , medic_amt, criminal_amt, first_damage   , first_damage_amt, send_date, qstatus, tax_prb   , contact   ,year_old    ,car_body   ,n_motor   ,create_date,id_data       ,hidden_discount   ,customer   , agent_group  ,product) values 
									('NULL','$com_data'   ,'$cat_car' ,'$regis'       , '$car_regis','$car_type' ,'$car_id','$br_car'   ,'$mo_car' ,'$cc' ,'$car_color', '$gear'      , '$car_seat', '$wg_m'    , '1'     , '$regis_date' ,'$car_regis_pro'   , '$q_no'  ,'$q_manual' ,'$pre'     , '$rdodriver'  ,'$driver'      , '$disone'     , '$group3'     , '$dis_group3' ,'$good'     ,'$total_dis2'  ,'$pro_dis'   , '$pro_dis2'   , '$total_pre','$total_stamp' , '$total_vat' , '$total_sum' , '$p_id' , '$prb'  ,'$vat1' , '$vat_1', '$total_prb' ,'$dis_vip'  , '$currentValue'   ,'$commition'   , '$other'   , '$vehicle_tax', '$service_charge', '$total_commition','$cost'    ,'$damage_out1', '$damage_cost' , '$pa1'    , '$people'   ,'$pa2'          , '$pa3'   , '$pa4'      , '$none_disone' , '$one'          , now()    ,'QF'    , '$tax_prb', '$contact', '$year_old','$car_body','$n_motor', now()     ,'$id_data_old','$hidden_discount','$customer','$agent_group','$product')";
	mysql_select_db($db2,$cndb2);
	$objQuery = mysql_query($strsql,$cndb2);

	///////////////////////    New Customer     //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
						
	if ($code =='')
	{
		$strSQL = "SELECT code FROM  tb_customer WHERE id ORDER BY id DESC LIMIT 0,1";
		mysql_select_db($db2,$cndb2);
		mysql_query("SET NAMES 'utf8'");
		$result_c = mysql_query( $strSQL ,$cndb2);
		$result_cu = mysql_fetch_array( $result_c ) ;
		$resplit_c = $result_cu['code'];
		$year = date('y');
								
		if($resplit_c=="")
		{
			$code_new = $year.'0000'+1;
		}
		else
		{
			$code_new = $resplit_c+1;
		}												
			$product=$_POST['product'];
			
		$strsql = "INSERT INTO tb_customer ( code , person, icard , title, name, last, `add`,  `group`,  `town` ,lane, road, province, amphur, tumbon, postal , email, tel_mobile,  tel_home, tel_fax) values ('$code_new', '$person', '$icard','$title', '$name','$last','$add', '$group', '$town', '$lane', '$road', '$province', '$amphur' , '$tumbon', '$postal', '$email' , '$tel_mobile' ,'$tel_home','$tel_fax')";
		mysql_select_db($db2,$cndb2);
		$objQuery = mysql_query($strsql,$cndb2);
										
		$strSQL = "INSERT INTO insuree_quotation (`id`, `title`, `name`, `last`, `person`, `career`, `add`, `group`, `town`, `lane`, `road`, `tumbon`, `amphur`, `province`, `postal`, `tel_mobile`, `tel_mobile2`, `tel_home`, `tel_fax`, `email`,`email_cc`, `status`, `status_sms`, `status_insured`, `status_company`, `st_email`, `st_sms`, `icard`, `cus_code`,q_auto,qstatus ) VALUES (NULL, '$title', '$name', '$last', '$person', '$career', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_mobile', '$tel_mobile2', '$tel_home', '$tel_fax', '$email',  '$email_cc','$status', '$status_sms', '$status_insured', '$status_company', '$st_email', '$st_sms', '$icard','$code_new','$q_no','QF')";												
		mysql_select_db($db2,$cndb2);
		$objQuery = mysql_query($strSQL,$cndb2);		
	}
	else
	{
		$strSQL = "INSERT INTO insuree_quotation (`id`, `title`, `name`, `last`, `person`, `career`, `add`, `group`, `town`, `lane`, `road`, `tumbon`, `amphur`, `province`, `postal`, `tel_mobile`, `tel_mobile2`, `tel_home`, `tel_fax`, `email`,`email_cc`, `status`, `status_sms`, `status_insured`, `status_company`, `st_email`, `st_sms`, `icard`, `cus_code`,q_auto,qstatus ) VALUES (NULL, '$title', '$name', '$last', '$person', '$career', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_mobile', '$tel_mobile2', '$tel_home', '$tel_fax', '$email',  '$email_cc','$status', '$status_sms', '$status_insured', '$status_company', '$st_email', '$st_sms', '$icard','$code','$q_no','QF')";												
		mysql_select_db($db2,$cndb2);
		$objQuery = mysql_query($strSQL,$cndb2);
	}		
						
	if($objQuery)
	{
		/*if($_GET['renew']=='view4')
		{
			$insert_follow_sql="INSERT INTO followup (id_data,meet_date,save_date,status,create_by,detail,q_auto) VALUES ('".$_GET['id_data']."',NOW(),NOW(),'FL','".$_SESSION["4User"]."','ใบเสนอราคา เลขที่ ".$q_no."','".$q_no."')";
			$insert_follow_query=mysql_query($insert_follow_sql,$cndb2);
			$update_sql="UPDATE data SET status = 'FL' WHERE id_data = '".$_GET['id_data']."' ";
			mysql_query($update_sql,$cndb2);
		}*/
		$returnedArray['idperson'] = $person;
		$returnedArray['msg'] = "บันทึกข้อมูลเรียบร้อยแล้ว! เลขที่ใบเสนอราคา : ".$q_no;
		$returnedArray['id'] = base64_encode($id);

	}
}
else
{
	//$returnedArray['msg'] = $strsql;
	$returnedArray['msg'] = "กรุณาลงชื่อเข้าใช้ใหม่ !!!!!";

}
        echo json_encode($returnedArray);
?>