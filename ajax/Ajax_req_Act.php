<?
	include "../pages/check-ses.php"; 
	require($_SERVER['DOCUMENT_ROOT'].'/allCon.php');
	$hostname_F = "localhost";
	$username_F = _USERNAME_FOUR; // fourinsured_new
	$password_F = _PASS_FOUR; // kalanchoe
	$database_F = _DB_FOUR_INSURED;
	$obj_connectF = mysql_connect( $hostname_F , $username_F , $password_F );
	mysql_select_db($database_F,$obj_connectF);
	mysql_set_charset('utf8');


//----------------------การแก้ไขข้อมูลรถยนต์-----------------------------//
	$EditCar = $_POST['EditCar']; //Checkbox การแก้ไขข้อมูลรถยนต์
	$Edit_CarBody = $_POST['Edit_CarBody1'].$_POST['Edit_CarBody2']; //แก้ไขเลขถัง
	$Edit_Nmotor = $_POST['Edit_Nmotor1'].'-'.$_POST['Edit_Nmotor2']; //แก้ไขเลขเครื่อง
	$Edit_CarColor = $_POST['Edit_CarColor']; //แก้ไขสีรถ

//----------------------การแก้ไขเลขที่ พ.ร.บ.-----------------------------//
	$EditAct = $_POST['EditAct']; //Checkbox แก้ไขเลขที่ พ.ร.บ
	if($_POST['Edittype'] == '1')
	{
		$Edittype = $_POST["Edittype"];
		$p_stamp = '3.00';
		$p_tax = '42.21';	
		$p_net = '645.21';
	}
	if($_POST['Edittype'] == '3')
	{
		$Edittype = $_POST["Edittype"];
		$p_stamp = '4.00';
		$p_tax = '63.28';	
		$p_net = '967.28';
	}
		
		$p_act2 = $_POST['p_act2'];
		$p_act3 = $_POST['p_act3']; // พรบเดิม
		$status_text = $_POST['status_text'];
	
//----------------------เปลี่ยนแปลงข้อมูลผู้เอาประกันภัย-----------------------------//	
	$EditCustomer = $_POST['EditCustomer']; //Checkbox เปลี่ยนแปลงข้อมูลผู้เอาประกันภัย
	$EditPerson = $_GET['valPerson']; //Checkbox เปลี่ยนแปลงข้อมูลผู้เอาประกันภัย
	$EditCard = $_POST['EditCard']; //บัตรประชาชน
	$Cus_title = $_POST['Cus_title']; //แก้ไขคำนำหน้า
	$Cus_name = $_POST['Cus_name']; //แก้ไขชื่อ
	$Cus_last = $_POST['Cus_last']; //แก้ไขนามสกุล
	$Cus_add = $_POST['Cus_add']; //แก้ไขเลขที่บ้าน
	$Cus_group = $_POST['Cus_group']; //แก้ไขหมู่
	$Cus_town = $_POST['Cus_town']; //แก้ไขหมู่บ้าน-อาคาร
	$Cus_lane = $_POST['Cus_lane']; //แก้ไขซอย
	$Cus_road = $_POST['Cus_road']; //แก้ไขถนน
	$Cus_province = $_POST['Cus_province']; //แก้ไขจังหวัด
	$Cus_amphur = $_POST['Cus_amphur']; //แก้ไขอำเภอ
	$Cus_tumbon = $_POST['Cus_tumbon']; //แก้ไขตำบล
	$Cus_postal = $_POST['Cus_postal']; //แก้ไขรหัสไปรษณีย์

//----------------------เปลี่ยนระยะเวลาประกันภัย -----------------------------//	
	$EditTime = $_POST['EditTime']; //Checkbox เปลี่ยนระยะเวลาประกันภัย 
	$NewStartDate = explode('/', $_POST['EditTimeStartDate']);
	$NewEndDate = $NewStartDate[2]+1;
	
	$TimeStartDate = $NewStartDate[2]."-".$NewStartDate[1]."-".$NewStartDate[0];
	$TimeEndDate = $NewEndDate."-".$NewStartDate[1]."-".$NewStartDate[0];
	$ch_start=$NewStartDate[1]."-".$NewStartDate[0];
	if($ch_start=='02-29')
	{
	$TimeEndDate = $NewEndDate."-02-28";
	}						
//----------------------เปลี่ยนแปลงผู้รับผลประโยชน์  -----------------------------//	
	$EditHr = $_POST['EditHr']; //Checkbox เปลี่ยนแปลงผู้รับผลประโยชน์  
	$EditHr_Detail = $_POST['EditHr_Detail']; //แก้ไขผู้รับผลประโยชน์

//----------------------การตั้งเงื่อนไขการสลักหลัง-----------------------------//
	$EditId_data = $_POST['EditId_data']; //เลขที่รับแจ้ง
	$req_SendDate = $_POST['req_SendDate']; //วันที่แจ้งงาน
	$req_date = $_POST['req_date']; //วันที่สลักหลัง
	$req_dmy = $_POST['req_dmy']; //
	
	$Edituser = $_POST['Edituser']; //

			
	if($EditCar == 'Y')
	{
		$strSQL = "UPDATE detail SET car_body = '$Edit_CarBody', n_motor = '$Edit_Nmotor', car_color = '$Edit_CarColor' WHERE id_data = '$EditId_data'";
		$objQuery = mysql_query($strSQL,$obj_connectF);
	}
	if($EditCustomer == 'Y')
	{
		$strSQL = "UPDATE insuree SET person = '$EditPerson', icard = '$EditCard', title = '$Cus_title', name = '$Cus_name', last = '$Cus_last', insuree.add = '$Cus_add', insuree.group = '$Cus_group', town = '$Cus_town', lane = '$Cus_lane', road = '$Cus_road', tumbon = '$Cus_tumbon', amphur = '$Cus_amphur', province = '$Cus_province', postal = '$Cus_postal' WHERE id_data = '$EditId_data'";
		$objQuery = mysql_query($strSQL,$obj_connectF);
	}
	if($EditAct == 'Y')
	{
		if($status_text == 'R')
		{
			// update act เดิม เป็น R เพื่อ key เข้า ระบบ พรบ.
			$hostname_S = "localhost";
			$username_S = _USERNAME_MY4IB; // fourinsure_mitsu
			$password_S = _PASS_MY4IB; // kalanchoe
			$database_S = _DB_MY4IB_NEW;
			$obj_connectS = mysql_connect( $hostname_S , $username_S , $password_S );
			mysql_select_db($database_S,$obj_connectS);
			mysql_set_charset('utf8');
				
			$strSQL = "UPDATE z_act SET act_status = 'R' WHERE act_no = '$p_act3' and act_use = '$Edituser' ";
			$objQuery = mysql_query($strSQL,$obj_connectS);
			
			$sql_act= "SELECT * FROM z_act WHERE act_use='$Edituser' and act_status = '1' and act_return = '' ORDER BY act_id";
			$result_act = mysql_query($sql_act,$obj_connectS);
			$fetcharr_act = mysql_fetch_array( $result_act );
			
			$EditAct_id = $_POST['p_act1']."-".$_POST['p_act2']."-".$fetcharr_act['act_no']; //แก้ไขเลขที่ พ.ร.บ
			
			$hostname_F = "localhost";
			$username_F = _USERNAME_FOUR; // fourinsure_new
			$password_F = _PASS_FOUR; // kalanchoe
			$database_F = _DB_FOUR_INSURED;
			$obj_connectF = mysql_connect( $hostname_F , $username_F , $password_F );
			mysql_select_db($database_F,$obj_connectF);
			mysql_set_charset('utf8');
			
			$strSQL = "UPDATE act SET act_id = '$EditAct_id' WHERE id_data = '$EditId_data'";
			$objQuery = mysql_query($strSQL,$obj_connectF);
			
			// update act เดิม เป็น R เพื่อ key เข้า ระบบ พรบ.
			$hostname_S = "localhost";
			$username_S = _USERNAME_MY4IB; // fourinsure_mitsu
			$password_S = _PASS_MY4IB; // kalanchoe
			$database_S = _DB_MY4IB_NEW;
			$obj_connectS = mysql_connect( $hostname_S , $username_S , $password_S );
			mysql_select_db($database_S,$obj_connectS);
			mysql_set_charset('utf8');
				
			$strSQL = "UPDATE z_act SET act_status = '2' WHERE act_no = '".$fetcharr_act['act_no']."' and act_use = '$Edituser' ";
			$objQuery = mysql_query($strSQL,$obj_connectS);
		}
		if($status_text == 'C')
		{
			// update act เดิม เป็น R เพื่อ key เข้า ระบบ พรบ.
			$hostname_S = "localhost";
			$username_S = _USERNAME_MY4IB; // fourinsure_mitsu
			$password_S = _PASS_MY4IB; // kalanchoe
			$database_S = _DB_MY4IB_NEW;
			$obj_connectS = mysql_connect( $hostname_S , $username_S , $password_S );
			mysql_select_db($database_S,$obj_connectS);
			mysql_set_charset('utf8');
				
			$strSQL = "UPDATE z_act SET act_status = 'C' WHERE act_no = '$p_act3' and act_use = '$Edituser' ";
			$objQuery = mysql_query($strSQL,$obj_connectS);
			
			$sql_act= "SELECT * FROM z_act WHERE act_use='$Edituser' and act_status = '1' and act_return = '' ORDER BY act_id";
			$result_act = mysql_query($sql_act,$obj_connectS);
			$fetcharr_act = mysql_fetch_array( $result_act );
			
			$EditAct_id = $_POST['p_act1']."-".$_POST['p_act2']."-".$fetcharr_act['act_no']; //แก้ไขเลขที่ พ.ร.บ
			
			$hostname_F = "localhost";
			$username_F = _USERNAME_FOUR; // fourinsure_new
			$password_F = _PASS_FOUR; // kalanchoe
			$database_F = _DB_FOUR_INSURED;
			$obj_connectF = mysql_connect( $hostname_F , $username_F , $password_F );
			mysql_select_db($database_F,$obj_connectF);
			mysql_set_charset('utf8');
			
			$strSQL = "UPDATE act SET act_id = '$EditAct_id' WHERE id_data = '$EditId_data'";
			$objQuery = mysql_query($strSQL,$obj_connectF);
			
			// update act เดิม เป็น R เพื่อ key เข้า ระบบ พรบ.
			$hostname_S = "localhost";
			$username_S = _USERNAME_MY4IB; // fourinsure_mitsu
			$password_S = _PASS_MY4IB; // kalanchoe
			$database_S = _DB_MY4IB_NEW;
			$obj_connectS = mysql_connect( $hostname_S , $username_S , $password_S );
			mysql_select_db($database_S,$obj_connectS);
			mysql_set_charset('utf8');
				
			$strSQL = "UPDATE z_act SET act_status = '2' WHERE act_no = '".$fetcharr_act['act_no']."' and act_use = '$Edituser' ";
			$objQuery = mysql_query($strSQL,$obj_connectS);
		}
		if($status_text == 'D')
		{
			$hostname_F = "localhost";
			$username_F = _USERNAME_FOUR; // fourinsure_new
			$password_F = _PASS_FOUR; // kalanchoe
			$database_F = _DB_FOUR_INSURED;
			$obj_connectF = mysql_connect( $hostname_F , $username_F , $password_F );
			mysql_select_db($database_F,$obj_connectF);
			mysql_set_charset('utf8');
			
			$strSQL = "UPDATE detail SET Cancel_policy = 'ยกเลิกซื้อ พ.ร.บ. Mitsubishi', Cancel_policy2 = 'ยกเลิกกรมธรรม์', status_policy_time = NOW() WHERE id_data = '$EditId_data'";
			$objQuery = mysql_query($strSQL,$obj_connectF);
			
			$hostname_S = "localhost";
			$username_S = _USERNAME_MY4IB; // fourinsure_mitsu
			$password_S = _PASS_MY4IB; // kalanchoe
			$database_S = _DB_MY4IB_NEW;
			$obj_connectS = mysql_connect( $hostname_S , $username_S , $password_S );
			mysql_select_db($database_S,$obj_connectS);
			mysql_set_charset('utf8');
				
			$strSQL = "UPDATE z_act SET act_status = 'D' WHERE act_no = '$p_act3' and act_use = '$Edituser' ";
			$objQuery = mysql_query($strSQL,$obj_connectS);
		}
		
		$hostname_F = "localhost";
		$username_F = _USERNAME_FOUR; // fourinsure_new
		$password_F = _PASS_FOUR; // kalanchoe
		$database_F = _DB_FOUR_INSURED;
		$obj_connectF = mysql_connect( $hostname_F , $username_F , $password_F );
		mysql_select_db($database_F,$obj_connectF);
		mysql_set_charset('utf8');
	}
	if($EditTime == 'Y')
	{
		$strSQL = "UPDATE data SET start_date = '$TimeStartDate', end_date = '$TimeEndDate' WHERE id_data = '$EditId_data'";
		$objQuery = mysql_query($strSQL,$obj_connectF);
	}
	if($EditHr == 'Y')
	{
		$strSQL = "UPDATE data SET name_gain = '$EditHr_Detail' WHERE id_data = '$EditId_data'";
		$objQuery = mysql_query($strSQL,$obj_connectF);
	}
		
	$sql = "SELECT id_data FROM data WHERE id_data='$EditId_data'";
	$result = mysql_query($sql,$obj_connectF);
	$fetcharr = mysql_fetch_array( $result );
	$id = $fetcharr["id_data"];
		
	$returnedArray['Re_req'] = 1;
	if($EditCancel =="Y")
	{
		$returnedArray['msg'] = $EditCancel;
	}
	
	$returnedArray['id'] = base64_encode($id);
	echo json_encode($returnedArray);
	// begin sing
	
	include "../../inc/connectdbs.pdo.php";
	include "../FEDERATED.PHP";

	@mysql_query("SET SQL_SAFE_UPDATES = 0;",$obj_connect);
	@mysql_query("DELETE FROM __report_act WHERE id_data LIKE '%".$EditId_data."%';",$obj_connect);
	@mysql_query("SET SQL_SAFE_UPDATES = 1;",$obj_connect);
	setACT($EditId_data,$hostname_conn,$username_conn,$password_conn,$database_conn);
	// end sing
mysql_close();
?>