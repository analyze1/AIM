<?php
include "../inc/connectdbs.pdo.php"; 
// include "../FEDERATED.PHP";
$_contextMitSu = PDO_CONNECTION::fourinsure_mitsu();
$_contextAccount = PDO_CONNECTION::fourinsure_account();
$_contextFour = PDO_CONNECTION::fourinsure_insured();


	$com_data = 'VIB_S';

				//----------------------------------------------------------------------------
	$id_user = $_POST["xuser"];
	
	if($id_user == 'admin')
	{
		$login = $_POST["Dxuser"];
		$user4 = $_POST["xuser"];
		$UserName = $_POST["xUserName"];
							
		$query_D ="SELECT * FROM `tb_customer` WHERE `nameuser` = 'Mitsubishi' AND user = '$login'"; // id = '1' 
		$objQueryD = $_contextMitSu->query($query_D);
		$row = $objQueryD->fetch(2);
		$_saka=$row['saka'];
		$name_inform = $row['title_sub']." ".$row['sub'];
		$idUser=$_POST["idUser"];
	}
	else
	{
		$login = $_POST["xuser"];
		$query_D ="SELECT * FROM `tb_customer` WHERE `nameuser` = 'Mitsubishi' AND user = '$login'"; // id = '1' 
		$objQueryD = $_contextMitSu->query($query_D);
		$row =$objQueryD->fetch(2);
		$_saka=$row['saka'];
		$name_inform = $_POST["name_inform"];
		$idUser=$_POST["idUser"];
	}
		$sql_comp="SELECT title_sub,sub FROM tb_customer WHERE id = '".$idUser."'";
		$query_comp= $_contextMitSu->query($sql_comp);
		$array_comp= $query_comp->fetch(2);
		$list_cusText = "แจ้งงานระบบ online วางบิล ".$array_comp['title_sub']." ".$array_comp['sub'];
		$q_auto = $_POST['q_auto'];

		
		$strUser_1 = substr($login,0,1);
		$strUser_2 = substr($login,4,3);
		$newlogin = 'Z'.$strUser_1.$strUser_2;
		
		$sPlit_RE = '-';
	
		$send_date = $_POST["send_date"];
		$n_insure = "";
		$ty_inform = $_POST["ty_inform"];
		$o_insure = $_POST["o_insure"];
		$ty_prot = $_POST["ty_prot"];
							
		$startDate = $_POST["start_date"];
		$startDate_dd = substr($startDate,0,2);
		$startDate_mm = substr($startDate,3,2);
		$startDate_yy = substr($startDate,6,4);
		$start_date = $startDate_yy."-".$startDate_mm."-".$startDate_dd;
							
		$year_plus = $startDate_yy+1;
		$end_date = $year_plus."-".$startDate_mm."-".$startDate_dd;
							
		$name_gain = "-- ไม่ระบุ --";

		$title_num1 = "ไม่ระบุ";
		$name_num1 = "ไม่ระบุ";
		$last_num1 = "ไม่ระบุ";
		$birth_num1 = "ไม่ระบุ";
		$licen_num1 = "ไม่ระบุ";
		$iden_num1 = "ไม่ระบุ";
		$title_num2 = "ไม่ระบุ";
		$name_num2 = "ไม่ระบุ";
		$last_num2 = "ไม่ระบุ";
		$birth_num2 = "ไม่ระบุ";
		$licen_num2 = "ไม่ระบุ";
		$iden_num2 = "ไม่ระบุ";									

		//ฐานข้อมูล insuree ส่วนผู้เอาประกัน	
		$title = $_POST["title"];
		$name = $_POST["name_name"];
		$last = $_POST["last"];
		$person = $_POST["person"];
		if($person == 1)
		{
		$icard = $_POST["icard"];
		$id_business = "";
		}
		else
		{
		$icard = "";
		$id_business = $_POST["icard"];
		}
		
		$add = $_POST["add"];
		$group = $_POST["group"];
		$town = $_POST["town"];
		$lane = $_POST["lane"];
		$road = $_POST["road"];
		$tumbon = $_POST["tumbon"];
		$amphur = $_POST["amphur"];
		$province = $_POST["province"];
		$postal = $_POST["id_post"];
		$tel_home = $_POST["tel_home"];
		$TelM = substr($_POST['tel_mobi'],0,3);
		$TelM2 = substr($_POST['tel_mobi'],4,3);
		$TelM3 = substr($_POST['tel_mobi'],8,4);
		$tel_mobi = $TelM.$TelM2.$TelM3;
		$email = $_POST['email'];

		//ฐานข้อมูล detail เกี่ยวกับรถ
		$car_id = $_POST["cartype"].$_POST["car_id"];
		$br_car = $_POST["br_car"];
		$mo_car = $_POST["mo_car"];
		$car_body = $check_car;
		$n_motor = strtoupper($_POST["n_motor"]);
		$car_body = strtoupper($_POST["car_body"]);
		$car_regis = $_POST["car_regis"];
		$car_regis_text = $sPlit_RE;
		$car_regis_pro = $_POST["car_regis_pro"];
		$car_color = $_POST["car_color"];
		$car_cc = $_POST["car_cc"];
		$car_seat = "ไม่เกิน ".$_POST["car_seat"]." ที่นั่ง";
		$car_wgt = $_POST["car_wgt"];
		$gear = $_POST["gear"];
		$regis_date = $_POST["regis_date"];
		$equit = $_POST["equit"];
		$mo_car_product = $_POST["equit_car"]; //เลือกรุ่นรถ swift-carry
		$cat_car = '0'.$_POST["cat_car"];
							
		//------------------------------------------------------------------------------------
		if ( $equit=="Y")
		{
			$car_detail = $_POST['acc'];
			$price_total_s = explode(',', $_POST['price_acc_tun']);
			$price_total = $price_total_s[0].$price_total_s[1];
			$add_price_s = explode(',', $_POST['price_acc_cost']);
			$add_price = $add_price_s[0].$add_price_s[1];
		}
		else
		{
			$car_detail ="ไม่มี";
		}

		//ความคุ้มครอง
		$costCost = $_POST["costCost"];
								
							
		//พรบ
		/*if($_POST["p_act2"]=="" || $_POST["p_act3"]=="")
		{
			$p_act = "N";
		}
		else
		{
			$p_act = $_POST["p_act1"]."-".$_POST["p_act2"]."-".$_POST["p_act3"];
			if($car_id == '110')
			{
				$p_id = '110';
				$p_pre = '600.00';
			}
			else if($car_id == '220')
			{
				$p_id = '220';
				$p_pre = '1580.00';
			}
			else if($car_id == '230')
			{
				$p_id = '230';
				$p_pre = '2320.00';
			}
			else if($car_id == '320')
			{
				$p_id = '140A';
				$p_pre = '900.00';
			}
			
			$p_stamp = $_POST["txtstamp1"];
			$p_tax = $_POST["txttax1"];	
			$p_net = $_POST["txtnet1"];	
		}*/
		
		$career = $_POST["address_chk"];
		$doc_type = $_POST["doc_type"];
		
		//$act3 = $_POST["p_act3"];
		//$strSQL = "UPDATE z_act SET act_status = '2'  WHERE act_use = '$login'  and  act_no = '$act3'  ";
		//$objQuery = mysql_query($strSQL);	

		
		/*$sql_data = "SELECT id_data FROM data WHERE login = '".$login."'";
								$result_data = mysql_query($sql_data);
								$fetcharr_data = mysql_fetch_array($result_data);
								$id_data = $fetcharr_data["id_data"];*/
								
								

		
		/////////// ACCOUNT ///////////////////////////////////	
		//เชื่อมแบบขึ้นเซิฟ ตัวจริง
		// $hostname_F = "localhost";
		// $username_F = _USERNAME_FOUR; // fourinsured_new
		// $password_F = _PASS_FOUR; // kalanchoe
		// $database_F = _DB_FOUR_INSURED;
		//เชื่อมแบบขึ้นเซิฟ ตัวของเล่น
	//	$hostname_F = "localhost";
	//	$username_F = "root"; // fourinsure_new
	//	$password_F = "root"; // kalanchoe
	//	$database_F = "fourinsure_insured";
		
		
		
		// $obj_connectF = mysql_connect( $hostname_F , $username_F , $password_F );
		// mysql_select_db($database_F,$obj_connectF);
		// mysql_set_charset('utf8');
	
		//id_data
		/*$id_data_Act = date('y').'ACT'.date('m');
		$strSQL = "SELECT id_data FROM data WHERE id_data LIKE '".$id_data_Act."%' ORDER BY id DESC LIMIT 0,1";
		$result22 = mysql_query($strSQL,$obj_connectF);
		$result_data = mysql_fetch_array( $result22 ) ;
		
		$datasplit = $result_data['id_data'];
		$iddatamblt = str_replace($id_data_Act,"",$datasplit);
								
		if($iddatamblt=="")
		{
			$iddatamblt="000";
		}
								
		$iddatasum = $iddatamblt+1;
		$sumstrdata = strlen($iddatasum);
		$zerodata = str_repeat("0", 3-$sumstrdata);
		$id_data = $id_data_Act.$zerodata.$iddatasum;
		
		// commition
		
		$query_agent = "SELECT agent_dis FROM tb_agent WHERE id_agent = '".$newlogin."' ORDER BY id_agent ASC LIMIT 0,1";
		$Objquery_agent = mysql_query($query_agent,$obj_connectF);
		$row_agent = mysql_fetch_array( $Objquery_agent ) ;
		
		$com_A1 = ($p_pre*$row_agent['agent_dis'])/100;
		$com_dis = number_format($com_A1, 2, '.', '');	
		$new_total_com = $p_net - $com_dis;*/
		///////////////////////////////////////////////////////
		
		//$strSQL = "INSERT INTO act (`id`, `id_data`, `p_id`, `p_pre`, `p_stamp`, `p_tax`, `p_net`, `act_id`, `act_sort`) VALUES (NULL, '$id_data',  '$p_id', '$p_pre', '$p_stamp', '$p_tax', '$p_net', '$p_act', 'VIB_S09712')";												
		//$objQuery = mysql_query($strSQL,$obj_connectF);
		
								//เปลียนสถานะเลขรับแจ้ง
								

								
								
								
								$quotation_sql="SELECT * FROM quotation,act_quotation WHERE quotation.q_auto = act_quotation.q_auto AND quotation.q_auto = '".$q_auto."'";
								$quotation_query= $_contextFour->query($quotation_sql);
								print_r($quotation_query) ;
								exit;
								$quotation_array=$quotation_query->fetch(2);
								$act_sort=$quotation_array['act_sort'];
								
								
								
								//update สถานะ เลขรับแจ้ง SUZUKI
								//$tb_inform_up="UPDATE tb_inform  SET status='1'";
								//$tb_query_up = mysql_query($tb_inform_up);
								if($quotation_array['id_customer']=="VIB_S103" || $quotation_array['id_customer']=="VIB_S")
								{
								$tb_inform_f="SELECT * FROM tb_inform WHERE sort = '".$quotation_array['id_customer']."' AND status = '1' ORDER BY id ASC";
								$tb_query_f = $_contextFour->query($tb_inform_f);
								$tb_array_f = $tb_query_f->fetch(2);
								$id_data=$tb_array_f['num_inform'];
								}
								else
								{
								$tb_inform="SELECT * FROM tb_inform WHERE sort = 'MY4IB' AND status = '1' ORDER BY id ASC";
								$tb_query = $_contextFour->query($tb_inform);	
								$tb_array = $tb_query->fetch(2);
								$id_data=$tb_array['num_inform'];
								}
								if(!empty($id_data))
								{
								
								$tb_update_f="UPDATE tb_inform SET status='2' WHERE num_inform = '".$id_data."' AND  status = '1'";
								$tb_uquery_f = $_contextFour->query($tb_update_f);	

								
								
								$act_sql="SELECT * FROM tb_act WHERE id_act='".$quotation_array['id_prb']."'";
								$act_query = $_contextFour->query($act_sql);	
								$act_array = $act_query->fetch(2);
								
								$data_qu = "SELECT doc_type,service FROM data_quotation WHERE q_auto = '".$q_auto."'";
								$data_query = $_contextFour->query($data_qu);
								$data_array = $data_query->fetch(2);
								
								
		//่เข้า
		$strSQL = "INSERT INTO act (id, id_data,p_id, p_pre,p_stamp,p_tax, p_net, act_id,act_sort,vat_car) VALUES (NULL,'".$id_data."','".$quotation_array['id_prb']."','".number_format($act_array['pre_act'],2,'.',',')."','".number_format($act_array['stamp_act'],2,'.',',')."','".number_format($act_array['tax_act'],2,'.',',')."','".number_format($act_array['net_act'],2,'.',',')."','','".$act_sort."','".$start_date."')";												
		$objQuery = $_contextFour->query($strSQL);
        //echo	$strSQL;
		//เข้า
		$strSQL = "INSERT INTO data (`id`, `login`, `com_data`, `send_date`, `id_data`, `ty_inform`, `o_insure`,  `start_date`, `end_date`, `name_inform`, `name_gain`, `service`, `idagent`, `list_customer1`, `list_customer2`, `list_customer3`, `list_customer4`, `list_customer5`, `pay_date`, `list_customer`, `doc_type`, `q_auto`) VALUES (NULL, 'ADMIN', '".$quotation_array['id_customer']."', '$send_date', '$id_data', 'N', '-', '$start_date', '$end_date', 'ADMIN', '$name_gain', '".$data_array['service']."', '$newlogin', '', '', '', '', '', '', '$list_cusText', '".$data_array['doc_type']."','$q_auto')"; 							
		$objQuery = $_contextFour->query($strSQL);
		//echo	$strSQL;
		//เข้า
		$strSQL = "INSERT INTO detail (`id`, `id_data`, `car_id`, `br_car`, `mo_car`, `car_body`, `n_motor`, `car_regis`, `car_regis_pro`, `car_color`, `cc`, `car_cc`, `car_seat`,`car_wg`, `gear`, `regis_date`,`cat_car`,`q_auto`) VALUES (NULL, '".$id_data."', '$car_id', '$br_car', '$mo_car', '$car_body', '$n_motor', '$car_regis', '$car_regis_pro', '$car_color', '-', '$car_cc', '$car_seat','$car_wgt',  '$gear', '$regis_date', '$cat_car','".$q_auto."')";												
		$objQuery = $_contextFour->query($strSQL);
		//echo	$strSQL;
		//เข้า
		$strSQL = "INSERT INTO driver (`id`, `id_data`, `title_num1`, `name_num1`, `last_num1`, `birth_num1`, `title_num2`, `name_num2`, `last_num2`, `birth_num2`) VALUES (NULL, '".$id_data."', '$title_num1', '$name_num1', '$last_num1', '$birth_num1', '$title_num2', '$name_num2', '$last_num2', '$birth_num2')";												
		$objQuery = $_contextFour->query($strSQL);
		//echo	$strSQL;
		//เข้า
		$strSQL = "INSERT INTO insuree (`id`, `id_data`, `title`, `name`, `last`, `person`, `career`, `add`, `group`, `town`, `lane`, `road`, `tumbon`, `amphur`, `province`, `postal`, `tel_mobile`, `tel_mobile2`, `tel_home`, `tel_fax`, `email`,`email_cc`, `status`, `status_sms`, `status_insured`, `status_insured_time`, `status_company`, `status_company_time`, `st_email`, `st_sms`, `icard`, `cus_code`, `status_vip`, `id_business`) VALUES (NULL, '".$id_data."', '$title', '$name', '$last', '$person', '-', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_mobi', '-', '$tel_home', '-', '$email',  '-','N', 'N', 'Y',NOW(), 'Y',NOW(), 'N', 'N', '$icard','N','N','$id_business')";												
		$objQuery = $_contextFour->query($strSQL);
		//echo	$strSQL;
		//เข้า
		$strSQL = "INSERT INTO premium (id,id_data,pre,total_pre,total_stamp,total_vat,total_sum,prb_net,prb_stamp,prb_tax,prb,total_prb,vat_1,tax1prb,service_charge,total_commition,one,disone,driver,dis1,good,dis2,group3,dis_group3,pro_dis,total_pro_dis,dis3,dis_vip,total_vip,total_dis4,commition,other,vehicle_tax) VALUES (NULL,'".$id_data."', '".$quotation_array['net_pre_dis']."','".$quotation_array['net_pre_dis']."','".$quotation_array['pre_stamp']."','".$quotation_array['pre_vat']."', '".$quotation_array['pre_total']."', '".number_format($act_array['pre_act'],2,'.',',')."', '".number_format($act_array['stamp_act'],2,'.',',')."', '".number_format($act_array['tax_act'],2,'.',',')."', '".number_format($act_array['pre_act'],2,'.',',')."', '".$quotation_array['sum_pre_prb']."','".$quotation_array['hold_tax']."','".$quotation_array['tax_prb']."','".$quotation_array['service_charge']."','".$quotation_array['grand_total']."','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00','0.00')";
		$objQuery = $_contextFour->query($strSQL);
		//echo	$strSQL;							
		
		//เข้า
		$strSQL = "INSERT INTO protect (`id`, `id_data`, `cost`, `damage_out1`, `damage_cost`, `pa1`, `pa2`, `pa3`, `pa4`, `people`) VALUES (NULL,'".$id_data."', '".$quotation_array['insu_amt']."', '".$quotation_array['human_amt']."', '".$quotation_array['asset_amt']."', '".$quotation_array['drive1_amt']."', '".$quotation_array['passenger_amt']."', '".$quotation_array['medic_amt']."', '".$quotation_array['criminal_amt']."', '".$quotation_array['passenger']."')";												
		$objQuery = $_contextFour->query($strSQL);
		//echo	$strSQL;
		
		//เข้า
		$strSQL = "INSERT INTO service (`id`, `id_data`, `fac1`, `fac2`, `fac3`) VALUES (NULL,'".$id_data."', '-', '-', '-')";												
		$objQuery = $_contextFour->query($strSQL);

//SMS
		/*$ACCOUNT="post@sicc";
		$PASSWORD="F22DF40C24B2EEE4F6BF029EEEA5EC382981F5558DA0E8EBEC27EE8F1A9E992B";
		$MOBILE= $tel_mobi;
		$smstext = "พ.ร.บ. ออนไลน์ เลขที่รับแจ้ง ".$id_data." ". $title."".$name." ".$last." คุ้มครอง : ". strtotime('d/m/y',$start_date)."-".strtotime('d/m/y',$end_date)." ";
		$MESSAGE= iconv('UTF-8','TIS-620',$smstext);
		$LANGUAGE = "T";
		$ch = curl_init("https://203.146.102.26/smartcomm2/SendMessage");      
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,"ACCOUNT=$ACCOUNT&PASSWORD=$PASSWORD&MOBILE=$MOBILE&MESSAGE=$MESSAGE&LANGUAGE=T");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$data = curl_exec($ch);*/
                
		//////////////////////////////
							
	//------------------------------------------------------------------
	if($objQuery)
	{
		$returnedArray['idperson'] = $person;
		$returnedArray['msg'] = "บันทึกข้อมูลเรียบร้อยแล้ว! เลขรับแจ้ง ".$id_data;
		//begin sing
		//setACT($id_data,$hostname_conn,$username_conn,$password_conn,$database_conn);
		//end sing
	$returnedArray['check']="T";
		echo json_encode($returnedArray);
		
	}
	else
	{
		$returnedArray['idperson'] = $person;
		$returnedArray['msg'] = "กรุณา Login แล้วแจ้งใหม่ ขอบคุณครับ/ค่ะ";
		$returnedArray['check']="F";
		echo json_encode($returnedArray);
		
	}
	}
	else
	{
		
		$returnedArray['msg'] = "เลขที่รับแจ้งหมดไม่สามารถบันทึกได้!!";
		$returnedArray['check']="F";
		echo json_encode($returnedArray);
	}
