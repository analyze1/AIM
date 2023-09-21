<?php
session_start();
require("../inc/connectdbs.pdo.php"); 
require("../FEDERATED.PHP");
require("../email/PHPMailer/PHPMailerAutoload.php");  // เรียกไฟล์ class.phpmailer.php

//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
// print_r($_REQUEST);exit;
$_contextSu = PDO_CONNECTION::fourinsure_mitsu();
$_context4 = PDO_CONNECTION::fourinsure_insured();

	$com_data = 'VIB_S';
	$id_user = $_POST["xuser"];
	
	/************************************** START แยก Admin กับ Dealer ******************************************* */
	if($id_user == 'admin')
	{
		$_login = $_POST["Dxuser"];//เลข user สาขา
	}
	else
	{
		$_login = $_POST["xuser"];//เลข user สาขา
	}
	/************************************** END แยก Admin กับ Dealer ******************************************* */

	//แก้ไขเฉพาะกิจ เอาสาขาจากเลข user 
	$sakaNumber = PDO_CONNECTION::fourinsure_mitsu()->query("SELECT saka FROM tb_customer WHERE user = '$_login'")->fetch(5)->saka;

	if($sakaNumber == '113')
	{
		$list_cusText = 'พ.ร.บ. กรุงเทพ วางบิลดีลเลอร์!!!';
	}
	else
	{
		$list_cusText = 'พ.ร.บ. ต่างจังหวัด ไม่ต้องวางบิล!!!';
	}
	
		// $newlogin = 'Z'.substr($_login, 0, 1).substr($_login, 4, 3);
		$newlogin = "";
		$edit_user = substr($_login,1,5);
		$newlogin = 'M' . $edit_user;
		
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
		$ch_start=$startDate_mm."-".$startDate_dd;
		if($ch_start=='02-29')
		{
			$end_date = $year_plus."-02-28";
		}						
		
		$start_datesms = $startDate_dd.'/'.$startDate_mm.'/'.$startDate_yy;	
		$end_datesms = $startDate_dd.'/'.$startDate_mm.'/'.$year_plus;	
						
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

		$icard_niti = '';
		$icard = '';
		if($person == '2')
		{
			$icard_niti = $_POST["icard"];
		}
		else if($person =='1')
		{
			$icard = $_POST["icard"];
		}
		else
		{
			$icard = $_POST["icard"];
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
		$car_seat = $_POST["car_seat"];
		$car_wgt = $_POST["car_wgt"];
		$gear = $_POST["gear"];
		$regis_date = $_POST["regis_date"];
		$equit = $_POST["equit"];
		$mo_car_product = $_POST["equit_car"]; //เลือกรุ่นรถ swift-carry
		$cat_car = $_POST["cat_car"];
							
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
		$career = $_POST["address_chk"];
		$doc_type = $_POST["doc_type"];
								
		$act3 = $_POST["p_act3"];	

		if($act3 == 'SmartOn')
		{
			$p_id = $_POST['ApiTypeCode'];
			$p_pre = $_POST['id_prp'];
			$p_stamp = $_POST['txtstamp1'];
			$p_tax = $_POST['txttax1'];	
			$p_net = $_POST['txtnet1'];	
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
		}

		if($act3 != 'SmartOn')
		{
			$strSQL = "UPDATE z_act SET act_status = '2'  WHERE act_use = '$login'  and  act_no = '$act3'  ";
			$_result = $_contextSu->prepare($strSQL)->execute();
		}
		
		#region Sql Old
		// $objQuery = mysql_query($strSQL);	

		/*********************************** ACCOUT SQL *********************************************************** */
		/*$hostname_F = "localhost";
		$username_F = _USERNAME_FOUR; // fourinsured_new
		$password_F = _PASS_FOUR; // kalanchoe
		$database_F = _DB_FOUR_INSURED;
		$obj_connectF = mysql_connect( $hostname_F , $username_F , $password_F );
		mysql_select_db($database_F,$obj_connectF);
		mysql_set_charset('utf8');*/

		/*********************************** ACCOUT SQL *********************************************************** */
		#endregion

		//id_data
		if($act3 == 'SmartOn')
		{
			$id_data_Act = date('y').'MMTS'.date('m');
		}
		else
		{
			$id_data_Act = date('y').'ACT'.date('m');
		}
		

		$strSQL = "SELECT id_data FROM `data` WHERE id_data LIKE '".$id_data_Act."%' ORDER BY id DESC LIMIT 0,1";

		$result_data  = $_context4->query($strSQL)->fetch();
	
		$datasplit = $result_data['id_data'];
		$iddatamblt = str_replace( $id_data_Act,"",$datasplit );
								
		if($iddatamblt == "")
		{
			$iddatamblt = "000";
		}
								
		$iddatasum = $iddatamblt+1;
		$sumstrdata = strlen($iddatasum);
		$zerodata = str_repeat("0", 3-$sumstrdata);
		$id_data = $id_data_Act.$zerodata.$iddatasum;
		
		// commition
		
		$query_agent = "SELECT agent_dis FROM tb_agent WHERE id_agent = '".$newlogin."' ORDER BY id_agent ASC LIMIT 0,1";

		$row_agent = $_context4->query($query_agent)->fetch();

		$prbCommit = explode('+',$row_agent['agent_dis']);
		$com_A1 = ($p_pre*$prbCommit[1]==''?'0':$prbCommit[1])/100;
		$com_dis = number_format($com_A1, 2, '.', '');
		$new_total_com = $p_net - $com_dis;
		
		$strSQL = "INSERT INTO act (`id`, `id_data`, `p_id`, `p_pre`, `p_stamp`, `p_tax`, `p_net`, `act_id`, `act_sort`) VALUES (NULL, '$id_data',  '$p_id', '$p_pre', '$p_stamp', '$p_tax', '$p_net', '$p_act', 'VIB_S')";												
		$objQuery = $_context4->prepare($strSQL)->execute();	
		
		$strSQL = "INSERT INTO `data` (`id`, `login`, `com_data`, `send_date`, `id_data`, `ty_inform`, `o_insure`,  `start_date`, `end_date`, `name_inform`, `name_gain`, `service`, `idagent`, `list_customer1`, `list_customer2`, `list_customer3`, `list_customer4`, `list_customer5`, `pay_date`, `list_customer`, `doc_type`,`CodeDealer`) VALUES (NULL, 'ADMIN', 'VIB_S', '$send_date', '$id_data', 'N', '-', '$start_date', '$end_date', 'ADMIN', '$name_gain', '2', '$newlogin', '', '', '', '', '', '', '$list_cusText', '$doc_type','$_login')";
		$objQuery = $_context4->prepare($strSQL)->execute();
		
		$strSQL = "INSERT INTO detail (`id`, `id_data`, `car_id`, `br_car`, `mo_car`, `car_body`, `n_motor`, `car_regis`, `car_regis_pro`, `car_color`, `cc`, `car_cc`, `car_seat`,`car_wg`, `gear`, `regis_date`, `cat_car`) VALUES (NULL, '$id_data', '$car_id', '$br_car', '$mo_car', '$car_body', '$n_motor', '$car_regis', '$car_regis_pro', '$car_color', '$car_cc', '$car_cc', '$car_seat','$car_wgt',  '$gear', '$regis_date', '$cat_car')";												
		$objQuery = $_context4->prepare($strSQL)->execute();
		
		$strSQL = "INSERT INTO driver (`id`, `id_data`, `title_num1`, `name_num1`, `last_num1`, `birth_num1`, `title_num2`, `name_num2`, `last_num2`, `birth_num2`) 
				   VALUES (NULL, '$id_data', '$title_num1', '$name_num1', '$last_num1', '$birth_num1', '$title_num2', '$name_num2', '$last_num2', '$birth_num2')";												
		$objQuery = $_context4->prepare($strSQL)->execute();
		
		$strSQL = "INSERT INTO insuree (`id`, `id_data`, `title`, `name`, `last`, `person`, `career`, `add`, `group`, `town`, `lane`, `road`, `tumbon`, `amphur`, `province`, `postal`, `tel_mobile`, `tel_mobile2`, `tel_home`, `tel_fax`, `email`,`email_cc`, `status`, `status_sms`, `status_insured`, `status_insured_time`, `status_company`, `status_company_time`, `st_email`, `st_sms`, `icard`, `cus_code`, `status_vip`,`id_business` ) VALUES (NULL, '$id_data', '$title', '$name', '$last', '$person', '-', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_mobi', '-', '$tel_home', '-', '$email',  '-','N', 'N', 'Y',NOW(), 'Y',NOW(), 'N', 'N', '$icard','N','N','$icard_niti')";												
		$objQuery = $_context4->prepare($strSQL)->execute();
		
		$strSQL = "INSERT INTO premium (`id`, `id_data`, `pre`, `one`, `disone`,`driver`, `dis1`, `good`, `dis2`, `group3`, `dis_group3`, `pro_dis`, `total_pro_dis`, `dis3`, `dis_vip`, `total_vip`, `total_dis4`, `total_pre`, `total_stamp`, `total_vat`, `total_sum`, `prb_net`, `prb_stamp`, `prb_tax`, `prb`, `total_prb`, `commition`, `other`, `vat_1`, `total_commition`,`tax1prb` ) 
				   VALUES (NULL, '$id_data', '0.00', '0.00','0.00', '0.00',  '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '$p_pre', '$p_stamp', '$p_tax', '$p_net', '$p_net','0.00', '$com_dis', '0.00', '$new_total_com', '0.00')";
		$objQuery = $_context4->prepare($strSQL)->execute();
										
		$strSQL = "INSERT INTO protect (`id`, `id_data`, `cost`, `damage_out1`, `damage_cost`, `pa1`, `pa2`, `pa3`, `pa4`, `people`) VALUES (NULL, '$id_data', '-', '-', '-', '-', '-', '-', '-', '-')";												
		$objQuery = $_context4->prepare($strSQL)->execute();
		
		$strSQL = "INSERT INTO `service` (`id`, `id_data`, `fac1`, `fac2`, `fac3`) VALUES (NULL, '$id_data', '-', '-', '-')";												
		$objQuery = $_context4->prepare($strSQL)->execute();

	/***************************************************** SMS START *********************************************************************************************** */	
		// comment ไว้ชั่วคราว เปิดใช้งานตอนแก้ไขเสร็จนะคร๊าาา
 
		//$ACCOUNT="post@sicc";
		//$PASSWORD="F22DF40C24B2EEE4F6BF029EEEA5EC382981F5558DA0E8EBEC27EE8F1A9E992B";
		$ACCOUNT ="post@fourinsura";
		$PASSWORD = "C699D09939D5BBF231EF67D073E3373C170F03D33C74FC1495F2B42744CE324E"; //"C699D09939D5BBF231EF67D073E3373C9C5A971CBEBCC45575CDB52CF9C3AEE4";
		$MOBILE = $tel_mobi;
		$smstext = "พ.ร.บ. ออนไลน์ เลขที่รับแจ้ง ".$id_data." ". $title."".$name." ".$last." คุ้มครอง : ".$start_datesms."-".$end_datesms." ";
		$MESSAGE = iconv('UTF-8','TIS-620',$smstext);
		$LANGUAGE = "T";
		$ch =  curl_init("https://sc4msg.com/bulksms/SendMessage");  //curl_init("https://203.146.102.26/smartcomm2/SendMessage");      
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_POST,1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,"ACCOUNT=$ACCOUNT&PASSWORD=$PASSWORD&MOBILE=$MOBILE&MESSAGE=$MESSAGE&LANGUAGE=T");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		//$data = curl_exec($ch);

	/***************************************************** SMS END *********************************************************************************************** */

	if($objQuery)
	{
		/************************************************** EMAIL START ****************************************************************************************** */
		if($act3 == 'SmartOn')
		{
			$returnedArray['idperson'] = $person;
			$returnedArray['msg'] = "บันทึกข้อมูลเรียบร้อยแล้ว! เลขรับแจ้ง : ".$id_data;
			$returnedArray['status'] = 200; 
			$returnedArray['DataID'] = $id_data;	
		}
		else
		{
			$returnedArray['idperson'] = $person;
			$returnedArray['msg'] = "บันทึกข้อมูลเรียบร้อยแล้ว! เลขรับแจ้ง : ".$id_data;
			$returnedArray['status'] = 400; 
			$returnedArray['DataID'] = $id_data;
		}
		
		//begin sing
		
		// setACT($id_data,$hostname_conn,$username_conn,$password_conn,$database_conn);

		//end sing
				
		$mail = new PHPMailer();  // กำหนดตัวแปร  $mail
		$mail->CharSet = 'UTF-8';                                                                
		$mail->From = "admin@my4ib.com";

		$mail->FromName = "ซื้อพรบ API "; // กำหนดชื่อผู้ส่ง
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = true;

		//เก่า
		//$mail->Host = _MAIL_MY4IB ; // "localhost"; // SMTP servermail.my4ib.com
		//$mail->Port = 25; // พอร์ท
		//$mail->Username = "prakunpai@my4ib.com"; // account SMTP
		//$mail->Password = "pra12641"; // รหัสผ่าน SMTP
		
		
		//ใหม่
		$mail->Host = _SMTP_MY4IB_TLS; // "localhost"; // SMTP servermail.my4ib.com
		$mail->Port = _SMTP_MY4IB_POST; // พอร์ท
		$mail->Username = _SMTP_MY4IB_USERNAME_ADMIN; // account SMTP
		$mail->Password = _SMTP_MY4IB_PASSWORD_ADMIN; // รหัสผ่าน SMTP
		$mail->IsHTML(false); 
		
		$mail->AddAddress('info_support2@my4ib.com','');

		//$mail->AddAddress("policy@my4ib.com", "");
		//$mail->AddAddress("underwrite_prb@my4ib.com", "");
		//$mail->AddAddress("marketing_support2@my4ib.com", "");
		//$mail->AddAddress("supinya@my4ib.com", "");
		//$mail->AddAddress("renew@my4ib.com", "");
		//$mail->AddAddress("marketing_support6@my4ib.com", "");
		
		$mail->Subject = 'Dealer '.$login.' ซื้อ พ.ร.บ. ออนไลน์ เลขที่รับแจ้ง '.$id_data.' '; // กำหนดหัวข้ออีเมล์
		$mail->Body = 'พ.ร.บ. ออนไลน์ เลขที่รับแจ้ง '.$id_data.' '. $title.''.$name.' '.$last.' คุ้มครอง : '. $start_datesms.'-'.$end_datesms.' ';
		
		//$mail->Send(); //Send Mail Method

		/************************************************** EMAIL END ****************************************************************************************** */
	
		echo json_encode($returnedArray);
	}
	else
	{
		$returnedArray['DataID'] = $id_data;
		$returnedArray['status'] = 500; 
		$returnedArray['idperson'] = $person;
		$returnedArray['msg'] = "กรุณา Login แล้วแจ้งใหม่ ขอบคุณครับ/ค่ะ";
		echo json_encode($returnedArray);
	}
	
	//mysql_close();
?>