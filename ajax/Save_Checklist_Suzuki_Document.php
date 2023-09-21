<?php
        include "../check-ses.php"; 
	//include "../inc/checksession.inc.php";
	include "../inc/connectdbs.inc.php"; 
	
	$login = $_SESSION["strUser"];
	$today_date = date('Y-m-d H:i:s');
	
	function DateSave($datetime)
	{
		list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
		list($d,$m,$Y) = split('/',$date); // แยกวันเป็น ปี เดือน วัน
		$Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.
	
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
		return $Y."-".$m."-".$d;
	}
						 			
	// Insert tb_send_document	
	if($_POST["txt_status"]=='pre')
	{
		$strSQL_send = "INSERT INTO tb_send_document(send_no,id_data,date_send,detail,address,login_emp,status_pre,status_prb,status_loc) 
		VALUES ('".$_POST["txt_sendno"]."','".$_POST["txt_iddata"]."',NOW(),'".$_POST["txt_detail"]."','".$_POST["txt_address"]."','".strtoupper($login)."','Y','','')";
	}
	else if($_POST["txt_status"]=='loc') 
	{
		$strSQL_send = "INSERT INTO tb_send_document(send_no,id_data,date_send,detail,address,rece_doc,login_emp,status_pre,status_prb,status_loc) 
		VALUES ('".$_POST["txt_sendno"]."','".$_POST["txt_iddata"]."',NOW(),'".$_POST["txt_detail"]."','".$_POST["txt_address"]."','".$_POST["txt_employee"]."','".strtoupper($login)."','','','Y')";
	}
	else if($_POST["txt_status"]=='prb')
	{
		$strSQL_send = "INSERT INTO tb_send_document(send_no,id_data,date_send,detail,address,login_emp,status_pre,status_prb,status_loc) 
		VALUES ('".$_POST["txt_sendno"]."','".$_POST["txt_iddata"]."',NOW(),'".$_POST["txt_detail"]."','".$_POST["txt_address"]."','".strtoupper($login)."','','Y','')";	
	}
	else
	{
		$strSQL_send = "INSERT INTO tb_send_document(send_no,id_data,date_send,detail,address,login_emp,status_pre,status_prb,status_loc) 
		VALUES ('".$_POST["txt_sendno"]."','".$_POST["txt_iddata"]."',NOW(),'".$_POST["txt_detail"]."','".$_POST["txt_address"]."','".strtoupper($login)."','','','')";		
	}
	mysql_select_db($db1,$cndb1);
	$objQuery_send = mysql_query( $strSQL_send ,$cndb1);
		
	if($objQuery_send)
	{
		$returnedArray['status'] = true;
		$returnedArray['msg'] = "บันทึกข้อมูลเรียบร้อยแล้ว! ";
	}							
	else
	{
		$returnedArray['status'] = false;
		$returnedArray['msg'] = "บันทึกข้อมูลผิดพลาด !!!!!!!";
	}
	echo json_encode($returnedArray);

mysql_close();
?>