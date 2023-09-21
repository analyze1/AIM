<?php
	include "../inc/connectdbs.inc.php"; 
	include "../pages/check-ses.php"; 
	mysql_select_db($db1,$cndb1);
	$com_data = $_POST["com_data"];
	$send_add_Y = $_POST['status_send_add'];
	$SendAdd="";
	if($send_add_Y=='Y')
	{
		$SendAdd = $_POST['send_add']."|".$_POST['send_group']."|".$_POST['send_town']."|".$_POST['send_lane']."|".$_POST['send_road']."|".$_POST['send_province']."|".$_POST['send_amphur']."|".$_POST['send_tumbon']."|".$_POST['send_post'];
	}
	//----------------------------------------------------------------------------
	$id_user = $_POST["xuser"];
	if($id_user == 'admin')
	{
		$login = $_POST["Dxuser"];
		$user4 = $_POST["xuser"];
		$UserName = $_POST["xUserName"];
							
		$query_D ="SELECT * FROM `tb_customer` WHERE `nameuser` = 'mitsubishi' AND user = '$login'"; // id = '1' 
		$objQueryD = mysql_query($query_D,$cndb1) or die ("Error Query [".$query_D."]");
		$row = mysql_fetch_array($objQueryD);
		$_saka=$row['saka'];
		$name_inform = $row['title_sub']." ".$row['sub'];
	}
	else
	{
		$login = $_POST["xuser"];
							
		$query_D ="SELECT * FROM `tb_customer` WHERE `nameuser` = 'mitsubishi' AND user = '$login'"; // id = '1' 
		$objQueryD = mysql_query($query_D,$cndb1) or die ("Error Query [".$query_D."]");
		$row = mysql_fetch_array($objQueryD);
		$_saka=$row['saka'];
		$name_inform = $_POST["name_inform"];
	}

	if($_saka!="")
	{
		if($com_data=='VIB_C' AND $_saka=='113')
		{
			$sql = "SELECT * FROM detail WHERE car_regis_text LIKE 'ปดA%' ORDER BY id DESC LIMIT 0,1 ";
			$result = mysql_query( $sql,$cndb1 );
			$fetcharr = mysql_fetch_array( $result ) ;
			$spliTRegis = explode('A', $fetcharr['car_regis_text']);
			$idSum = ((int)$spliTRegis[1])+1;
			$sumstr = strlen($idSum);
			$zero = str_repeat("0", 5-$sumstr);
			$sPlit_RE = 'ปดA'.$zero.$idSum;
		}
		else
		{
			$sPlit_RE = '-';
		}

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
		$ch_start=$startDate_mm."-".$startDate_dd;
		$year_plus = $startDate_yy+1;
		if($ch_start == '02-29')
		{
			
			$end_date = $year_plus.'-02-28';
		}
		else
		{
			
			$end_date = $year_plus."-".$startDate_mm."-".$startDate_dd;
		}
		/*					
		$year_plus = $startDate_yy+1;
		$end_date = $year_plus."-".$startDate_mm."-".$startDate_dd;
		*/					
		$name_gain = $_POST["name_gain"];
		
		// ระบุผู้ขับขี่
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
		$name = str_replace("'",'\'',$_POST["name_name"]);
		$last = str_replace("'",'\'',$_POST["last"]);
		$person = $_POST["person"];
		$vocation = $_POST["vocation"];
		$icard = $_POST["icard"];
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
		$mo_sub=$_POST['mo_car_sub'];		
		$car_id = $_POST["cartype"].$_POST["car_id"];
		$br_car = $_POST["br_car"];
		$mo_car = $_POST["mo_car"];
		$car_body = $check_car;
		$n_motor = $_POST["new_motor"]."-".$_POST["n_motor"];
		$car_body = $_POST["new_carbody"].$_POST["car_body"];
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
		
		//addon
                if($_POST['checkAddon']=='Y'){
					$code_addon = "";
					$code_addon_id = "";
					for($n=0;$n<count($_POST['addon_buy']);$n++)
					{
						$addon_array=explode(",",$_POST['addon_buy'][$n]);
						if($n<=0)
						{
							$commas="";
						}
						else
						{
							$commas=",";
						}
                    $code_addon .= $commas.$addon_array[2]; // รหัส addon
                    $code_addon_id .= $commas.$addon_array[0]; // id addon
					}
                }else{
                    $code_addon = ""; // id addon
                    $code_addon_id = ""; // id addon 
                }
                

		/////////////////////////
		
		$replace_acc1=array(',','N');
		$replace_acc2=array('','0');
		//ไฟแนนซ์เพิ่มทุน
		$add_tun_total=str_replace($replace_acc1,$replace_acc2,$_POST['price_acc_tun'])+str_replace($replace_acc1,$replace_acc2,$_POST['finance_add_tun']);
		//$sql_tun = "SELECT * FROM tb_acc WHERE name = '".$_POST['finance_add_tun']."' and mo_car = '".$_POST["mo_car"]."' and cartype = '".$_POST["cartype"]."' ORDER BY id ";
		$check_mocarsub_sql="SELECT * FROM tb_acc WHERE cartype='".$_POST["cartype"]."' and mo_car='".$_POST["mo_car"]."' and status = 'Y' AND mo_car_sub = '".$_POST['mo_car_sub']."' ORDER BY price ASC";
		$check_mocarsub_query=mysql_query($check_mocarsub_sql,$cndb1);
		$check_mocarsub_array=mysql_fetch_array($check_mocarsub_query);
		if(!empty($check_mocarsub_array))
		{
		$sql_tun = "SELECT * FROM tb_acc WHERE name = '".$add_tun_total."' and mo_car = '".$_POST["mo_car"]."' and cartype = '".$_POST["cartype"]."' and  mo_car_sub = '".$_POST['mo_car_sub']."' and status = 'Y' ORDER BY id ";
		$sql_tun_check = "SELECT * FROM tb_acc WHERE name = '".str_replace($replace_acc1,$replace_acc2,$_POST['finance_add_tun'])."' and mo_car = '".$_POST["mo_car"]."' and cartype = '".$_POST["cartype"]."' and  mo_car_sub = '".$_POST['mo_car_sub']."' and status = 'Y' ORDER BY id ";
		}
		else
		{
		$sql_tun = "SELECT * FROM tb_acc WHERE name = '".$add_tun_total."' and mo_car = '".$_POST["mo_car"]."' and cartype = '".$_POST["cartype"]."' and status = 'Y' ORDER BY id ";
		$sql_tun_check = "SELECT * FROM tb_acc WHERE name = '".str_replace($replace_acc1,$replace_acc2,$_POST['finance_add_tun'])."' and mo_car = '".$_POST["mo_car"]."' and cartype = '".$_POST["cartype"]."' and status = 'Y' ORDER BY id ";
		}
		$result_tun = mysql_query($sql_tun,$cndb1 );
		$fetcharr_tun = mysql_fetch_array( $result_tun );
		
		$result_tun_check = mysql_query($sql_tun_check,$cndb1 );
		$fetcharr_tun_check = mysql_fetch_array( $result_tun_check );
		
		if($_POST["cartype"] == '1')
		{
			$id_text = '32';
		}
		else
		{
			$id_text = '31';
		}
		
		$sql_tun_text = "SELECT * FROM tb_acc_new WHERE id = '".$id_text."' and idcar = '".$_POST["cartype"]."' ORDER BY id ";					
		$result_tun_text = mysql_query($sql_tun_text,$cndb1 );
		$fetcharr_tun_text = mysql_fetch_array( $result_tun_text );
		
		if($_POST['finance_add_tun_price'] != '0.00')  // เช็ค เบี้ยเพิ่ม
		{
			if($_POST['acc'] != '') // มีรายการอุปกรณ์ตกแต่งเพิ่มเติมอื่นๆหรือไม่
			{
				$car_detail = $_POST['acc'].'|'.$fetcharr_tun_text['id'].','.$fetcharr_tun_check['id'];
				$price_total_s = explode(',', $_POST['price_acc_tun']);
				$price_total = ($price_total_s[0].$price_total_s[1])+$_POST['finance_add_tun'];
				//$add_price_s = explode(',', $_POST['price_acc_cost']);
				//$add_price = ($add_price_s[0].$add_price_s[1])+number_format($_POST['finance_add_tun_price'], 2, '.', '');
				$add_price = str_replace(',','',$fetcharr_tun['price']);
			}
			else
			{
				$car_detail = $fetcharr_tun_text['id'].','.$fetcharr_tun_check['id'];
				$price_total = $_POST['finance_add_tun'];
				//$add_price_s = explode(',', $_POST['finance_add_tun_price']);
				//$add_price = $add_price_s[0].$add_price_s[1];
				$add_price = str_replace(',','',$fetcharr_tun['price']);
				$equit = 'Y';
			}
		}
		else
		{
			//สลักหลังอุปกรณ์ตกแต่ง
			if ( $equit=="Y")
			{
				$car_detail = $_POST['acc'];
				$price_total_s = explode(',', $_POST['price_acc_tun']);
				$price_total = $price_total_s[0].$price_total_s[1];
				//$add_price_s = explode(',', $_POST['price_acc_cost']);
				//$add_price = $add_price_s[0].$add_price_s[1];
				$add_price = str_replace(',','',$fetcharr_tun['price']);
			}
			else
			{
				$car_detail ="ไม่มี";
			}
		}
		
		//ความคุ้มครอง
		$costCost = $_POST["costCost"];
							
		//พรบ
		if ($_POST["p_act2"]=="" || $_POST["p_act3"]=="")
		{
			$p_act = "N";
		}
		else
		{
			$p_act = $_POST["p_act1"]."-".$_POST["p_act2"]."-".$_POST["p_act3"];
			$p_pre = $_POST["id_prp"];
			$p_stamp = $_POST["txtstamp1"];
			$p_tax = $_POST["txttax1"];	
			$p_net = $_POST["txtnet1"];	
		}
		
		$career = $_POST["address_chk"];
		$doc_type = $_POST["doc_type"];
							
		//กรอกฐานข้อมูลแรก
		//08829 | VIB_C | code113 = 1
		//09712 | VIB_S | code113 = 0
		//10320 | VIB_C | code113 = 0
		//11678 | VIB_F | code113 = 0
		
		

		$sort = $com_data;
		$id_data = $_GET['id_data'];
		
		$insureYear = $_POST["insureYear"];
		$numsuy = '000001';
		for($i = 1;$i<=$insureYear; $i++)
		{
			$id_dataNew = explode("/",$id_data);
			if($i >1)
			{
				$id_data_SU = $id_dataNew[0].'/SUY'.$insureYear.'/';// ตัดเลขรับแจ้ง แรก
				
				$strSQL_SU = "SELECT id_data FROM data WHERE id_data LIKE '".$id_data_SU."%' ORDER BY id DESC LIMIT 0,1";
				$result_SU = mysql_query($strSQL_SU,$cndb1);							
				$fetcharr_SU = mysql_fetch_array( $result_SU ) ;
				
				$datasplit = $fetcharr_SU['id_data'];
				$iddatasu = str_replace($id_data_SU,"",$datasplit);							
				if($iddatasu=="")
				{
					$iddatasu="000000";
				}							
				$iddatasum = $iddatasu+1;
				$sumstrdata = strlen($iddatasum);
				$zerodata = str_repeat("0", 6-$sumstrdata);
				
				
				if($i == 2)
				{
					$year_plus1 = $startDate_yy+1;
					$start_date = $year_plus1."-".$startDate_mm."-".$startDate_dd;
					$year_plus2 = $startDate_yy+2;
					$end_date = $year_plus2."-".$startDate_mm."-".$startDate_dd;
					if($ch_start == '02-29')
						{
						$end_date = $year_plus.'-02-28';
						}
				}
				if($i == 3)
				{
					$year_plus1 = $startDate_yy+2;
					$start_date = $year_plus1."-".$startDate_mm."-".$startDate_dd;
					$year_plus2 = $startDate_yy+3;
					$end_date = $year_plus2."-".$startDate_mm."-".$startDate_dd;
					if($ch_start == '02-29')
						{
						$end_date = $year_plus.'-02-28';
						}
				}
			}
			$select_unit_sql="SELECT unit_edit FROM data WHERE id_data = '".$id_data."'";
			$select_unit_query=mysql_query($select_unit_sql,$cndb1);
			$select_unit_array=mysql_fetch_array($select_unit_query);
			$unit_edit = $select_unit_array['unit_edit']+1;
			if($i == 1)
			{
				$strSQL = "UPDATE detail  SET `car_id` = '".$car_id."', `br_car` = '".$br_car."', `mo_car` = '".$mo_car."', `car_body` = '".$car_body."', `n_motor` = '".$n_motor."', `car_regis` = '".$car_regis."', `car_regis_text` = '".$car_regis_text."', `car_regis_pro` = '".$car_regis_pro."', `car_color` = '".$car_color."', `car_cc` = '".$car_cc."', `car_seat` = '".$car_seat."', `car_wgt` = '".$car_wgt."', `gear` = '".$gear."', `regis_date` = '".$regis_date."', `insure_year` = '1', `equit` = '".$equit."', `cat_car` = '".$cat_car."', `car_detail` = '".$car_detail."', `price_total` = '".$price_total."', `add_price` = '".$add_price."', `code_addon` = '".$code_addon."', `code_addon_id` = '".$code_addon_id."',`mo_sub` = '".$mo_sub."' WHERE id_data = '".$id_data."'";									
				$objQuery = mysql_query($strSQL,$cndb1);
			}
			else if($i == 2)
			{
				$strSQL = "UPDATE detail SET `car_id` = '".$car_id."', `br_car` = '".$br_car."', `mo_car` = '".$mo_car."', `car_body` = '".$car_body."', `n_motor` = '".$n_motor."', `car_regis` = '".$car_regis."', `car_regis_text` = '".$car_regis_text."', `car_regis_pro` = '".$car_regis_pro."', `car_color` = '".$car_color."', `car_cc` = '".$car_cc."', `car_seat` = '".$car_seat."', `car_wgt` = '".$car_wgt."', `gear` = '".$gear."', `regis_date` = '".$regis_date."', `insure_year` = '2', `equit` = '".$equit."', `cat_car` = '".$cat_car."', `car_detail` = '".$car_detail."', `price_total` = '".$price_total."', `add_price` = '".$add_price."', `code_addon` = '".$code_addon."', `code_addon_id` = '".$code_addon_id."',`mo_sub` = '".$mo_sub."' WHERE id_data = '".$id_data."'";									
				$objQuery = mysql_query($strSQL,$cndb1);
			}
			else
			{
				$strSQL = "UPDATE detail SET `car_id` = '".$car_id."', `br_car` = '".$br_car."', `mo_car` = '".$mo_car."', `car_body` = '".$car_body."', `n_motor` = '".$n_motor."', `car_regis` = '".$car_regis."', `car_regis_text` = '".$car_regis_text."', `car_regis_pro` = '".$car_regis_pro."', `car_color` = '".$car_color."', `car_cc` = '".$car_cc."', `car_seat` = '".$car_seat."', `car_wgt` = '".$car_wgt."', `gear` = '".$gear."', `regis_date` = '".$regis_date."', `insure_year` = '".$insureYear."', `equit` = '".$equit."', `cat_car` = '".$cat_car."', `car_detail` = '".$car_detail."', `price_total` = '".$price_total."', `add_price` = '".$add_price."', `code_addon` = '".$code_addon."', `code_addon_id` = '".$code_addon_id."',`mo_sub` = '".$mo_sub."' WHERE id_data = '".$id_data."'";									
				$objQuery = mysql_query($strSQL,$cndb1);
			}
			
			$strSQL = "UPDATE data SET `login` = '".$login."', `com_data` = '".$com_data."', `send_date` = NOW(), `n_insure` = '".$n_insure."',`p_act` = '".$p_act."',`costCost` = '".$costCost."', `ty_inform` = '".$ty_inform."', `o_insure` = '".$o_insure."', `start_date` = '".$start_date."', `end_date` = '".$end_date."', `name_inform` = '".$name_inform."', `name_gain` = '".$name_gain."', `rdodriver` = '".$rdodriver."',`doc_type` = '".$doc_type."',`Status_Email` = 'F',`fourib` = '', `UserName` = '',`unit_edit` = '".$unit_edit."',`save_login` = '".$_POST["xuser"]."' WHERE id_data = '".$id_data."'";					
			$objQuery = mysql_query($strSQL,$cndb1);
							
			$strSQL = "UPDATE insuree SET `title` = '".$title."', `name` = '".$name."', `last` = '".$last."', `person` = '".$person."', `vocation` = '".$vocation."', `career` = '".$career."', `icard` = '".$icard."', `add` = '".$add."', `group` = '".$group."', `town` = '".$town."', `lane` = '".$lane."', `road` = '".$road."', `tumbon` = '".$tumbon."', `amphur` = '".$amphur."', `province` = '".$province."', `postal` = '".$postal."', `tel_home` = '".$tel_home."', `tel_mobi` = '".$tel_mobi."', `email` = '".$email."', `SendAdd` = '".$SendAdd."', `status_SendAdd` = '".$send_add_Y."' WHERE id_data = '".$id_data."'";					
			$objQuery = mysql_query($strSQL,$cndb1);			
		
			$strSQL = "UPDATE driver SET `title_num1` = '".$title_num1."', `name_num1` = '".$name_num1."', `last_num1` = '".$last_num1."', `birth_num1` = '".$birth_num1."', `licen_num1` = '".$licen_num1."', `iden_num1` = '".$iden_num1."', `title_num2` = '".$title_num2."', `name_num2` = '".$name_num2."', `last_num2` = '".$last_num2."', `birth_num2 = '".$birth_num2."'`, `licen_num2` = '".$licen_num2."', `iden_num2` = '".$iden_num2."' WHERE id_data = '".$id_data."'";									
			$objQuery = mysql_query($strSQL,$cndb1);			
							
			$strSQL = "UPDATE protect SET `costCost` = '".$costCost."', `first_cost` = '".$first_cost."', `car_cost` = '".$car_cost."' WHERE id_data = '".$id_data."'";								
			$objQuery = mysql_query($strSQL,$cndb1);	
		
			$strSQL = "UPDATE act SET `p_id` = '".$p_id."', `p_act` = '".$p_act."', `p_pre` = '".$p_pre."', `p_stamp` = '".$p_stamp."', `p_tax` = '".$p_tax."', `p_net` = '".$p_net."' WHERE id_data = '".$id_data."'";												
			$objQuery = mysql_query($strSQL,$cndb1);	
			if($equit=="Y")
			{	
			$strSQL = "UPDATE `req` SET `Req_Status` = 'Y',`Req_Date` = NOW(),`EditProduct` = 'Y',`Product` = '".$car_detail."',`TotalProduct` = '".$price_total."',`CostProduct` = '".$add_price."' WHERE `id_data` = '".$id_data."'";
			$objQuery = mysql_query($strSQL,$cndb1);
			}
			else
			{	
			$strSQL = "UPDATE `req` SET `Req_Status` = '',`Req_Date` = '0000-00-00 00:00:00',`EditProduct` = '',`Product` = '',`TotalProduct` = '',`CostProduct` = '' WHERE `id_data` = '".$id_data."'";												
			$objQuery = mysql_query($strSQL,$cndb1);
			}
			
		}
				
		$sql = "SELECT id_data FROM data WHERE id_data='$id_data'";
		$result = mysql_query($sql,$cndb1);
		$fetcharr = mysql_fetch_array( $result );
		$id = $fetcharr["id_data"];
							
		$returnedArray['idperson'] = $person;
		$returnedArray['msg'] = "แก้ไขข้อมูลเรียบร้อยแล้ว! เลขรับแจ้งที่ถูกแก้ไข : ".$id_data;
		$returnedArray['id'] = base64_encode($id);
		//begin sing
		@mysql_query("DELETE FROM __report_individuals WHERE id_data_send LIKE '%".$id_data."%';",$cndb1);
		@mysql_query("call prepare_individuals('".$id_data."')",$cndb1);
		
		//เช็คเบอร์ tb_mobile_all
		mysql_select_db($db2,$cndb2);
		$tel_data=$_POST['tel_home']."|".$_POST['tel_mobi'];
		$tel_array=explode("|",$tel_data);
		for($n=0;$n<count($tel_array);$n++)
		{
		$tel_preg=preg_replace('/[^0-9]/','',$tel_array[$n]);
		$ch_sql="SELECT id FROM tb_mobile_all WHERE data_tel = '".$tel_preg."'";
		$ch_query=mysql_query($ch_sql,$cndb2);
		$ch_array=mysql_fetch_array($ch_query);
		if(!empty($ch_array))
		{
			$update_sql = "UPDATE tb_mobile_all SET data_iddata = '".$id_data."',data_name = '".$title.$name."',data_lname = '".$last."',data_system = 'SZ',call_update = NOW(),updateby = '".$_SESSION['strUser']."' WHERE id = '".$ch_array['id']."' AND data_tel = '".$tel_preg."'";
			mysql_query($update_sql,$cndb2);
		}
		else
		{
			$insert_sql="INSERT INTO tb_mobile_all (data_tel,data_name,data_lname,data_iddata,data_system,data_remark,call_in,call_out,call_date,call_update,updateby) VALUES 
			('".$tel_preg."','".$title.$name."','".$last."','".$id_data."','SZ','','0','0',NOW(),NOW(),'".$_SESSION['strUser']."') ";
			mysql_query($insert_sql,$cndb2);
		}
		}
		//END เช็คเบอร์ tb_mobile_all
		
		//end sing
        echo json_encode($returnedArray);
		//------------------------------------------------------------------
	}
	else
	{
		$returnedArray['idperson'] = $person;
		$returnedArray['msg'] = "กรุณา Login แล้วแจ้งใหม่ ขอบคุณครับ/ค่ะ";
		$returnedArray['id'] = base64_encode($id);
    	echo json_encode($returnedArray);
	}
	
mysql_close();
?>