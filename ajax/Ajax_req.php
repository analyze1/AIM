<?php

include "../pages/check-ses.php";

include "../inc/connectdbs.pdo.php";

$dbmy4ib_new = PDO_CONNECTION::fourinsure_mitsu();

class start_function

{

	public function line_notify($Token, $message)

	{

		$lineapi = $Token; // ใส่ token key ที่ได้มา

		$mms =  trim($message); // ข้อความที่ต้องการส่ง

		date_default_timezone_set("Asia/Bangkok");

		$chOne = curl_init();

		curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");

		// SSL USE 

		curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);

		curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);

		//POST 

		curl_setopt($chOne, CURLOPT_POST, 1);

		curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=$mms");

		curl_setopt($chOne, CURLOPT_FOLLOWLOCATION, 1);

		$headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $lineapi . '',);

		curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);

		curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($chOne);

		//Check error 

		if (curl_error($chOne)) {

			echo 'error:' . curl_error($chOne);
		} else {

			$result_ = json_decode($result, true);

			// echo "status : ".$result_['status']; echo "message : ". $result_['message'];

		}

		curl_close($chOne);
	}
}

$start_fun = new start_function;



//----------------------การแก้ไขข้อมูลรถยนต์-----------------------------//

$EditCar = $_POST['EditCar']; //Checkbox การแก้ไขข้อมูลรถยนต์

$Edit_CarBody = $_POST['Edit_CarBody1'] . $_POST['Edit_CarBody2']; //แก้ไขเลขถัง

$Edit_Nmotor = $_POST['Edit_Nmotor1'] . '-' . $_POST['Edit_Nmotor2']; //แก้ไขเลขเครื่อง

$Edit_CarColor = $_POST['Edit_CarColor']; //แก้ไขสีรถ



//----------------------การแก้ไขเลขที่ พ.ร.บ.-----------------------------//

$EditAct = $_POST['EditAct']; //Checkbox แก้ไขเลขที่ พ.ร.บ

if ($_POST['Edittype'] == '1') {

	$Edittype = $_POST["Edittype"];

	$p_stamp = '3.00';

	$p_tax = '42.21';

	$p_net = '645.21';
}

if ($_POST['Edittype'] == '3') {

	$Edittype = $_POST["Edittype"];

	$p_stamp = '4.00';

	$p_tax = '63.28';

	$p_net = '967.28';
}

$EditAct_id = $_POST['p_act1'] . "-" . $_POST['p_act2'] . "-" . $_POST['p_act3']; //แก้ไขเลขที่ พ.ร.บ

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



$EditReceipt = $_POST['EditReceipt']; //แก้ไขใบเสร็จ

$EditCaree = $_POST['EditCaree']; //ลูกค้า-บริษัท



//----------------------ที่่อยู่ในการจัดส่งเอกสาร-----------------------------//

$EditSendAdd = $_POST['EditSendAdd'];

$NewAdd = $_POST['NewAdd'];

//$NewAdd2 = $_POST['NewAdd2'];

if ($NewAdd == '2') {

	$status_SendAdd = 'Y';

	$EditNewAdd = $_POST['send_add'] . "|" . $_POST['send_group'] . "|" . $_POST['send_town'] . "|" . $_POST['send_lane'] . "|" . $_POST['send_road'] . "|" . $_POST['send_province'] . "|" . $_POST['send_amphur'] . "|" . $_POST['send_tumbon'] . "|" . $_POST['send_post'];
} else {

	$status_SendAdd = 'N';

	$EditNewAdd = '';
}

//----------------------ที่่อยู่ในการจัดส่งเอกสาร-----------------------------//

$EditAddon = $_POST['EditAddon'];

$costIns = $_POST['costIns'];

//----------------------เปลี่ยนระยะเวลาประกันภัย -----------------------------//	

$EditTime = $_POST['EditTime']; //Checkbox เปลี่ยนระยะเวลาประกันภัย 

$NewStartDate = explode('/', $_POST['EditTimeStartDate']);

$NewEndDate = $NewStartDate[2] + 1;



$TimeStartDate = $NewStartDate[2] . "-" . $NewStartDate[1] . "-" . $NewStartDate[0];

$TimeEndDate = $NewEndDate . "-" . $NewStartDate[1] . "-" . $NewStartDate[0];

$ch_start = $NewStartDate[1] . "-" . $NewStartDate[0];

if ($ch_start == '02-29') {

	$TimeEndDate = $NewEndDate . "-02-28";
}



//----------------------เปลี่ยนแปลงผู้รับผลประโยชน์  -----------------------------//	

$EditHr = $_POST['EditHr']; //Checkbox เปลี่ยนแปลงผู้รับผลประโยชน์  

$EditHr_Detail = $_POST['EditHr_Detail']; //แก้ไขผู้รับผลประโยชน์



//----------------------เปลี่ยนแปลงอัตราเบี้ย-----------------------------//	

$EditCost = $_POST['EditCost']; //Checkbox เปลี่ยนแปลงอัตราเบี้ย   

$EditcostCost = $_POST['EditcostCost']; //แก้ไขทุน

/*$EditcostPre = $_POST['EditcostPre']; //เบี้ยสุทธิ

	$EditcostStamp = $_POST['EditcostStamp']; //อากร

	$EditcostTax = $_POST['EditcostTax']; //แสตมป์

	$EditcostNet = $_POST['EditcostNet']; //เบี้ยรวม*/



//----------------------ยกเลิกกรมธรรม์ประกันภัย  -----------------------------//	

$EditCancel = $_POST['EditCancel']; //Checkbox ยกเลิกกรมธรรม์ประกันภัย  

$Cancel_Detail = $_POST['Cancel_Detail']; //แก้ไขผู้รับผลประโยชน์

$Editp_act3 = $_POST['Editp_act3'];

$Edituser_C = $_POST['Edituser_C'];

/////////////////////-------------------------------///////////



/// อุปกรณ์ตกแต่ง ------ ไฟแนนซ์เพิมทุน ///////////////////

$EditProduct = $_POST['EditProduct']; //Checkbox อุปกรณ์ตกแต่ง  

$Edit_addTun = $_POST['Edit_addTun']; //Checkbox ไฟแนนซ์เพิ่มทุน  

$MOREAJAX = $_POST['MOREAJAX']; //อุปกรณ์ตกแต่งเดิม  

$MORETUN = $_POST['MORETUN']; //ไฟแนนซ์เพิืมทุนเดิม  







if ($_POST['Edit_addAT'] == 'Y') {

	/// อท 220/230 ///////////////////

	$Edit_addAT = $_POST['Edit_addAT']; //Checkbox อท  

	$car_cat_acc = $_POST['car_cat_acc'];

	$add_pre_at = str_replace(",", "", $_POST['add_pre_at']); //ราคา

	$car_cat_acc_p_total = str_replace(",", "", $_POST['p_pre_val']);

	$car_cat_acc_b_total = str_replace(",", "", $_POST['b_pre_val']);
} else {

	/// อท 220/230 ///////////////////

	$Edit_addAT = ''; //Checkbox อท  

	$car_cat_acc = '';

	$add_pre_at = '0.00'; //ราคา

	$car_cat_acc_p_total = '0.00';

	$car_cat_acc_b_total = '0.00';
}

$replace_acc1 = array(',', 'N');

$replace_acc2 = array('', '0');

$add_tun_total = 0;

$finace_tun = 0;

if ($_POST['Edit_addTun'] == 'Y') {

	$add_tun_total = str_replace($replace_acc1, $replace_acc2, $_POST['finance_add_tun']);

	$finace_tun = str_replace($replace_acc1, $replace_acc2, $_POST['finance_add_tun']);
}

if ($_POST['EditProduct'] == 'Y') {

	$add_tun_total = str_replace($replace_acc1, $replace_acc2, $_POST['price_acc_tun']);
}

if ($_POST['EditProduct'] == 'Y' && $_POST['Edit_addTun'] == 'Y') {

	$add_tun_total = str_replace($replace_acc1, $replace_acc2, $_POST['price_acc_tun']) + str_replace($replace_acc1, $replace_acc2, $_POST['finance_add_tun']);

	$finace_tun = str_replace($replace_acc1, $replace_acc2, $_POST['finance_add_tun']);
}

//$sql_tun = "SELECT * FROM tb_acc WHERE name = '".$_POST['finance_add_tun']."' and mo_car = '".$_POST["Editmo"]."' and cartype = '".$_POST["Edittype"]."' ORDER BY id ";	

$check_mocarsub_sql = "SELECT * FROM tb_acc WHERE cartype='" . $_POST["Edittype"] . "' and mo_car ='" . $_POST["Editmo"] . "' and status = 'Y' AND mo_car_sub = '" . $_POST['mo_car_sub'] . "' ORDER BY price ASC";

$check_mocarsub_query = $dbmy4ib_new->query($check_mocarsub_sql);

$check_mocarsub_array = $check_mocarsub_query->fetch();

if (!empty($check_mocarsub_array)) {

	$sql_tun = "SELECT * FROM tb_acc WHERE name = '" . $add_tun_total . "' and mo_car = '" . $_POST["Editmo"] . "' and cartype = '" . $_POST["Edittype"] . "' and  mo_car_sub = '" . $_POST['mo_car_sub'] . "' and status = 'Y' ORDER BY id ";

	$sql_tun_check = "SELECT * FROM tb_acc WHERE name = '" . $finace_tun . "' and mo_car = '" . $_POST["Editmo"] . "' and cartype = '" . $_POST["Edittype"] . "' and  mo_car_sub = '" . $_POST['mo_car_sub'] . "' and status = 'Y' ORDER BY id ";
} else {

	$sql_tun = "SELECT * FROM tb_acc WHERE name = '" . $add_tun_total . "' and mo_car = '" . $_POST["Editmo"] . "' and cartype = '" . $_POST["Edittype"] . "' and status = 'Y' ORDER BY id ";

	$sql_tun_check = "SELECT * FROM tb_acc WHERE name = '" . $finace_tun . "' and mo_car = '" . $_POST["Editmo"] . "' and cartype = '" . $_POST["Edittype"] . "' and status = 'Y' ORDER BY id ";
}

$result_tun = $dbmy4ib_new->query($sql_tun);

$fetcharr_tun = $result_tun->fetch();



$result_tun_check = $dbmy4ib_new->query($sql_tun_check);

$fetcharr_tun_check = $result_tun_check->fetch();



if ($_POST["Edittype"] == '1') {
	$id_text = '32';
} else {
	$id_text = '31';
}



$sql_tun_text = "SELECT * FROM tb_acc_new WHERE id = '" . $id_text . "' and idcar = '" . $_POST["Edittype"] . "' ORDER BY id ";

$result_tun_text = $dbmy4ib_new->query($sql_tun_text);

$fetcharr_tun_text = $result_tun_text->fetch();



if ($EditProduct == 'Y') // สลักหลัง อุปกรณ์ตกแต่งอย่างเดียว

{

	if ($_POST["finance_add_tun_price"] != '0.00') {

		$DetailProduct = $_POST['acc'] . '|' . $fetcharr_tun_text['id'] . ',' . $fetcharr_tun_check['id'];

		$TotalProduct_s = explode(',', $_POST['price_acc_tun']);

		$TotalProduct = ($TotalProduct_s[0] . $TotalProduct_s[1]) + $_POST['finance_add_tun'];

		//$PriceProduct_s = explode(',', $_POST['price_acc_cost']);

		//$PriceProduct = ($PriceProduct_s[0].$PriceProduct_s[1])+number_format($_POST['finance_add_tun_price'], 2, '.', '');

		$PriceProduct = str_replace(',', '', $fetcharr_tun['price']);
	} else {

		//----------------------อุปกรณ์ตกแต่ง-----------------------------//	

		$DetailProduct = $_POST['acc'];

		$TotalProduct_s = explode(',', $_POST['price_acc_tun']); //ราคาทุน

		$TotalProduct = $TotalProduct_s[0] . $TotalProduct_s[1];

		//$PriceProduct_s = explode(',', $_POST['price_acc_cost']); //ราคาเบี้ยรวม

		//$PriceProduct = $PriceProduct_s[0].$PriceProduct_s[1];

		$PriceProduct = str_replace(',', '', $fetcharr_tun['price']);
	}
} else if ($Edit_addTun == 'Y') // สลักหลัง ไฟแนนซ์เพิ่มทุนอย่างเดียว

{

	if ($_POST['finance_add_tun'] != 'N') {

		if ($_POST['acc'] != '') // มีรายการอุปกรณ์ตกแต่งเพิ่มเติมอื่นๆหรือไม่

		{

			$DetailProduct = $_POST['acc'] . '|' . $fetcharr_tun_text['id'] . ',' . $fetcharr_tun_check['id'];

			$TotalProduct_s = explode(',', $_POST['price_acc_tun']);

			$TotalProduct = ($TotalProduct_s[0] . $TotalProduct_s[1]) + $_POST['finance_add_tun'];

			//$PriceProduct_s = explode(',', $_POST['price_acc_cost']);

			//$PriceProduct = ($PriceProduct_s[0].$PriceProduct_s[1])+number_format($_POST['finance_add_tun_price'], 2, '.', '');

			$PriceProduct = str_replace(',', '', $fetcharr_tun['price']);
		} else {

			$DetailProduct = $fetcharr_tun_text['id'] . ',' . $fetcharr_tun_check['id'];

			$TotalProduct = $_POST['finance_add_tun'];

			//$PriceProduct_s = explode(',', $_POST['finance_add_tun_price']);

			//$PriceProduct = $PriceProduct_s[0].$PriceProduct_s[1];

			$PriceProduct = str_replace(',', '', $fetcharr_tun['price']);

			$equit = 'Y';
		}
	} else {

		$DetailProduct = $_POST['acc'];

		$TotalProduct_s = explode(',', $_POST['price_acc_tun']); //ราคาทุน

		$TotalProduct = $TotalProduct_s[0] . $TotalProduct_s[1];

		//$PriceProduct_s = explode(',', $_POST['price_acc_cost']); //ราคาเบี้ยรวม

		//$PriceProduct = $PriceProduct_s[0].$PriceProduct_s[1];

		$PriceProduct = str_replace(',', '', $fetcharr_tun['price']);
	}
} else if ($EditProduct == 'Y' && $Edit_addTun == 'Y') // สลักหลัง ทั้ง 2 อย่าง

{

	if ($_POST['finance_add_tun'] != 'N') {

		$DetailProduct = $_POST['acc'] . '|' . $fetcharr_tun_text['id'] . ',' . $fetcharr_tun_check['id'];

		$TotalProduct_s = explode(',', $_POST['price_acc_tun']);

		$TotalProduct = ($TotalProduct_s[0] . $TotalProduct_s[1]) + $_POST['finance_add_tun'];

		//$PriceProduct_s = explode(',', $_POST['price_acc_cost']);

		//$PriceProduct = ($PriceProduct_s[0].$PriceProduct_s[1])+number_format($_POST['finance_add_tun_price'], 2, '.', '');

		$PriceProduct = str_replace(',', '', $fetcharr_tun['price']);
	} else {

		$DetailProduct = $_POST['acc'];

		$TotalProduct_s = explode(',', $_POST['price_acc_tun']); //ราคาทุน

		$TotalProduct = $TotalProduct_s[0] . $TotalProduct_s[1];

		//$PriceProduct_s = explode(',', $_POST['price_acc_cost']); //ราคาเบี้ยรวม

		//$PriceProduct = $PriceProduct_s[0].$PriceProduct_s[1];

		$PriceProduct = str_replace(',', '', $fetcharr_tun['price']);
	}
}







//----------------------ไฟแนนซ์เพิ่มทุน-----------------------------//		



if ($_POST['finance_add_tun_price'] != '0.00') {

	if ($_POST['acc'] != '') // มีรายการอุปกรณ์ตกแต่งเพิ่มเติมอื่นๆหรือไม่

	{

		$car_detail = $_POST['acc'] . '|' . $fetcharr_tun_text['id'] . ',' . $fetcharr_tun_check['id'];

		$price_total_s = explode(',', $_POST['price_acc_tun']);

		$price_total = ($price_total_s[0] . $price_total_s[1]) + $_POST['finance_add_tun'];

		//$add_price_s = explode(',', $_POST['price_acc_cost']);

		//$add_price = ($add_price_s[0].$add_price_s[1])+number_format($_POST['finance_add_tun_price'], 2, '.', '');

		$add_price = str_replace(',', '', $fetcharr_tun['price']);
	} else {

		$car_detail = $fetcharr_tun_text['id'] . ',' . $fetcharr_tun_check['id'];

		$price_total = $_POST['finance_add_tun'];

		//$add_price_s = explode(',', $_POST['finance_add_tun_price']);

		//$add_price = $add_price_s[0].$add_price_s[1];

		$add_price = str_replace(',', '', $fetcharr_tun['price']);

		$equit = 'Y';
	}
} else {

	//สลักหลังอุปกรณ์ตกแต่ง

	if ($equit == "Y") {

		$car_detail = $_POST['acc'];

		$price_total_s = explode(',', $_POST['price_acc_tun']);

		$price_total = $price_total_s[0] . $price_total_s[1];

		//$add_price_s = explode(',', $_POST['price_acc_cost']);

		//$add_price = $add_price_s[0].$add_price_s[1];

		$add_price = str_replace(',', '', $fetcharr_tun['price']);
	} else {

		$car_detail = "ไม่มี";
	}
}



//----------------------การตั้งเงื่อนไขการสลักหลัง-----------------------------//

$EditId_data = $_POST['EditId_data']; //เลขที่รับแจ้ง

$req_SendDate = $_POST['req_SendDate']; //วันที่แจ้งงาน

$req_date = $_POST['req_date']; //วันที่สลักหลัง

$req_dmy = $_POST['req_dmy']; //

$Edituser = $_POST['Edituser']; //

$ip_address = $_SERVER['REMOTE_ADDR'];

$insert_sql = "id_data,login,ip_address";

$insert_value = "'" . $EditId_data . "','" . $_SESSION['strUser'] . "','" . $ip_address . "'";

//-------------------กรณีที่มีการสลักหลัง ณ วันเดียวกับ วันที่แจ้งงาน ให้ทำการเปลี่ยนแปลงข้อมูลทันที!! พร้อม Update Status การแจ้งสลักหลังที่ Table req-----------------///

if ($req_SendDate == $req_date) {

	//---------------update Status การส่ง Email----------------------////

	$strSQL = "UPDATE data SET Status_Email = 'F',  Update_Req = '$req_dmy' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);



	if ($EditCar == 'Y') {

		$strSQL = "UPDATE detail SET car_body = '$Edit_CarBody', n_motor = '$Edit_Nmotor', car_color = '$Edit_CarColor' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);
	}

	if ($EditCustomer == 'Y') {

		$strSQL = "UPDATE insuree SET person = '$EditPerson', icard = '$EditCard', title = '$Cus_title', name = '$Cus_name', last = '$Cus_last', insuree.add = '$Cus_add', insuree.group = '$Cus_group', town = '$Cus_town', lane = '$Cus_lane', road = '$Cus_road', tumbon = '$Cus_tumbon', amphur = '$Cus_amphur', province = '$Cus_province', postal = '$Cus_postal' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);
	}

	if ($EditReceipt == 'Y') {

		$strSQL = "UPDATE insuree SET career = '$EditCaree' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);



		$strSQL = "UPDATE req SET EditReceipt = 'Y' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);

		$insert_sql .= ",EditReceipt";

		$insert_value .= ",'Y'";
	}

	if ($EditAct == 'Y') {

		if ($_POST['p_act_data'] != $p_act3) {

			$strSQL = "UPDATE z_act SET act_status = 'C',act_use = '$Edituser' WHERE act_no = '" . $_POST['p_act_data'] . "'";

			$objQuery = $dbmy4ib_new->query($strSQL);





			//เช็ค พรบ

			$select_act3_sql = "SELECT act_no FROM z_act WHERE act_no = '" . $p_act3 . "' AND act_status IN ('2','C','R') ";

			$select_act3_query = $dbmy4ib_new->query($select_act3_sql);

			$select_act3_array = $select_act3_query->fetch();

			if (!empty($select_act3_array) && $_saka == '113') {

				$use_act3_sql = "SELECT act_no FROM z_act WHERE act_use = '$Edituser' AND act_status = '1'";

				$use_act3_query = $dbmy4ib_new->query($use_act3_sql);

				$use_act3_array = $use_act3_query->fetch();

				$p_act3 = $use_act3_array['act_no'];
			}

			//แก้ไขเมือวั้นที่ 19-07-2562 ปัญหาเลข พ.ร.บ. ไม่เปลียนสถานะ 

			//$strSQL = "UPDATE z_act SET act_status = '2'  WHERE act_use = '$Edituser'  and  act_no = '$p_act3'  ";

			$strSQL = "UPDATE z_act SET act_status = '2'  WHERE  act_no = '$p_act3'  ";

			$objQuery = $dbmy4ib_new->query($strSQL);

			//END เช็ค พรบ

		}

		if ($_SESSION["saka"] == '113' or $_SESSION["strUser"] == 'admin') {

			/*if($status_text == 'R')

				{

					$strSQL = "UPDATE z_act SET act_status = 'R' WHERE act_no = '$p_act3' and act_use = '$Edituser' ";

					$objQuery = mysql_query($strSQL);

				}

				else if($status_text == 'C')

				{

					$strSQL = "UPDATE z_act SET act_status = 'C' WHERE act_no = '$p_act3' and act_use = '$Edituser' ";

					$objQuery = mysql_query($strSQL);

				}*/



			if ($_SESSION["saka"] == '113') {

				/*$sql_act= "SELECT * FROM z_act WHERE act_use='$Edituser' and act_status = '1' and act_return = '' ORDER BY act_id";

					$result_act = mysql_query($sql_act);

					$fetcharr_act = mysql_fetch_array( $result_act );*/



				$EditAct_idNew = $_POST['p_act1'] . "-" . $_POST['p_act2'] . "-" . $p_act3; //แก้ไขเลขที่ พ.ร.บ



				/*$strSQL = "UPDATE act SET p_act = '$EditAct_idNew', p_pre = '$Edittype', p_stamp = '$p_stamp', p_tax = '$p_tax', p_net = '$p_net' WHERE id_data = '$EditId_data'";

					$objQuery = mysql_query($strSQL);

					

					$strSQL = "UPDATE data SET p_act = '$EditAct_idNew' WHERE id_data = '$EditId_data'";

					$objQuery = mysql_query($strSQL);*/



				/*$strSQL = "UPDATE z_act SET act_status = '2' WHERE act_no = '".$fetcharr_act['act_no']."' and act_use = '$Edituser' ";

					$objQuery = mysql_query($strSQL);*/
			} else {

				$EditAct_id = $_POST['p_act1'] . "-" . $_POST['p_act2'] . "-" . $p_act3;

				/*$strSQL = "UPDATE act SET p_act = '$EditAct_id', p_pre = '$Edittype', p_stamp = '$p_stamp', p_tax = '$p_tax', p_net = '$p_net' WHERE id_data = '$EditId_data'";

					$objQuery = mysql_query($strSQL);

					

					$strSQL = "UPDATE data SET p_act = '$EditAct_id' WHERE id_data = '$EditId_data'";

					$objQuery = mysql_query($strSQL);*/
			}
		} else {

			$EditAct_id = $_POST['p_act1'] . "-" . $_POST['p_act2'] . "-" . $p_act3;

			/*$strSQL = "UPDATE act SET p_act = '$EditAct_id', p_pre = '$Edittype', p_stamp = '$p_stamp', p_tax = '$p_tax', p_net = '$p_net' WHERE id_data = '$EditId_data'";

				$objQuery = mysql_query($strSQL);

				

				$strSQL = "UPDATE data SET p_act = '$EditAct_id' WHERE id_data = '$EditId_data'";

				$objQuery = mysql_query($strSQL);*/
		}
	}

	if ($EditTime == 'Y') {

		$strSQL = "UPDATE data SET start_date = '$TimeStartDate', end_date = '$TimeEndDate' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);
	}

	if ($EditHr == 'Y') {

		$strSQL = "UPDATE data SET name_gain = '$EditHr_Detail' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);
	}

	if ($EditSendAdd == 'Y') {

		$strSQL = "UPDATE insuree SET SendAdd = '$EditNewAdd',status_SendAdd = '$status_SendAdd' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);
	}

	if ($EditCost == 'Y') {

		$strSQL = "UPDATE req SET EditCost = 'Y', EditcostCost = '$EditcostCost' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);

		$insert_sql .= ",EditCost";

		$insert_value .= ",'" . $EditcostCost . "'";
	}

	//addon

	if ($EditAddon == 'Y') {

		$code_addon = "";

		$code_addon_id = "";



		for ($n = 0; $n < count($_POST['addon_buy']); $n++) {

			$addon_array = explode(",", $_POST['addon_buy'][$n]);

			if ($n <= 0) {

				$commas = "";
			} else {

				$commas = ",";
			}

			$code_addon .= $commas . $addon_array[2]; // รหัส addon

			$code_addon_id .= $commas . $addon_array[0]; // id addon

		}

		//$strSQL = "UPDATE req SET EditAddon = 'Y', code_addon = '$code_addon', code_addon_id = '$code_addon_id' WHERE id_data = '$EditId_data'";

		//$objQuery = mysql_query($strSQL);

		$strSQL = "UPDATE detail SET code_addon = '$code_addon', code_addon_id = '$code_addon_id' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);

		//$insert_sql.=",EditAddon,code_addon,code_addon_id";

		//$insert_value.=",'Y','".$code_addon."','".$code_addon_id."'";

	}



	if ($EditProduct == 'Y') {

		$strSQL = "UPDATE detail SET equit = 'Y', car_detail = '$DetailProduct', price_total = '$TotalProduct', add_price  = '$PriceProduct' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);
	}

	if ($Edit_addTun == 'Y') {

		$strSQL = "UPDATE detail SET equit = 'Y', car_detail = '$DetailProduct', price_total = '$TotalProduct', add_price  = '$PriceProduct' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);
	}

	if ($EditProduct == 'Y' && $Edit_addTun == 'Y') {

		$strSQL = "UPDATE detail SET equit = 'Y', car_detail = '$DetailProduct', price_total = '$TotalProduct', add_price  = '$PriceProduct' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);
	}

	// 220/230

	if ($Edit_addAT == 'Y') {

		$strSQL = "UPDATE detail SET car_cat_acc = '$car_cat_acc', car_cat_acc_total = '$add_pre_at',car_cat_acc_p_total = '$car_cat_acc_p_total',car_cat_acc_b_total = '$car_cat_acc_b_total' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);
	}

	//$insert_req_story_sql="INSERT INTO req_story (".$insert_sql.") VALUES (".$insert_value.")";

	//$insert_req_story_query=mysql_query($insert_req_story_sql);		

	$sql = "SELECT id_data FROM data WHERE id_data='$EditId_data'";

	$result = $dbmy4ib_new->query($sql);

	$fetcharr = $result->fetch();

	$id = $fetcharr["id_data"];



	$returnedArray['Re_req'] = 1;

	if ($EditCancel == "Y") {

		$returnedArray['msg'] = $EditCancel;
	}

	$returnedArray['id'] = base64_encode($id);

	//echo json_encode($returnedArray);

}



//----------------------------ถ้าสลักหลังไม่ตรงกับวันที่แจ้งงาน ให้ Update ข้อมูลการแจ้งสลักหลังที่ Table req เท่านั้น !!--------------------------------///

//else

//{

$insert_sql = "id_data,login,ip_address";

$insert_value = "'" . $EditId_data . "','" . $_SESSION['strUser'] . "','" . $ip_address . "'";

$strSQL = "UPDATE data SET Status_Email = 'F' WHERE id_data = '$EditId_data'";

$objQuery = $dbmy4ib_new->query($strSQL);



$strSQL = "UPDATE req SET Req_Status = 'Y', Req_Date = '$req_dmy' WHERE id_data = '$EditId_data'";

$objQuery = $dbmy4ib_new->query($strSQL);

$insert_sql .= ",Req_Status,Req_Date";

$insert_value .= ",'Y','" . $req_dmy . "'";



if ($EditCar == 'Y') {

	$strSQL = "SELECT car_body FROM detail WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);

	$objArray = $objQuery->fetch();

	$car_edit = explode(" ", $objArray['car_body']);

	$car_create = $car_edit[0];

	$strSQL = "UPDATE detail SET car_body = '" . $car_create . " (สลักหลัง)', n_motor = '$Edit_Nmotor', car_color = '$Edit_CarColor' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);

	$strSQL = "UPDATE req SET EditCar = '$EditCar', Edit_CarBody = '$Edit_CarBody', Edit_Nmotor ='$Edit_Nmotor', Edit_CarColor ='$Edit_CarColor' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);

	$insert_sql .= ",EditCar,Edit_CarBody,Edit_Nmotor,Edit_CarColor";

	$insert_value .= ",'" . $EditCar . "','" . $Edit_CarBody . "','" . $Edit_Nmotor . "','" . $Edit_CarColor . "'";
}

if ($EditAct == 'Y') {

	if ($_SESSION["saka"] == '113' or $_SESSION["strUser"] == 'admin') {

		/*if($status_text == 'R')

				{

					$strSQL = "UPDATE z_act SET act_status = 'R' WHERE act_no = '$p_act3' and act_use = '$Edituser' ";

					$objQuery = mysql_query($strSQL);

				}

				else if($status_text == 'C')

				{

					$strSQL = "UPDATE z_act SET act_status = 'C' WHERE act_no = '$p_act3' and act_use = '$Edituser' ";

					

					$objQuery = mysql_query($strSQL);

				}*/



		/*$sql_act= "SELECT * FROM z_act WHERE act_use='$Edituser' and act_status = '1' and act_return = '' ORDER BY act_id";

				$result_act = mysql_query($sql_act);

				$fetcharr_act = mysql_fetch_array( $result_act );*/



		$EditAct_idNew = $_POST['p_act1'] . "-" . $_POST['p_act2'] . "-" . $p_act3; //แก้ไขเลขที่ พ.ร.บ



		$strSQL = "UPDATE req SET EditAct = '$EditAct', EditAct_id = '$EditAct_idNew', ActType = '$Edittype' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);

		$insert_sql .= ",EditAct,EditAct_id,ActType";

		$insert_value .= ",'" . $EditAct . "','" . $EditAct_idNew . "','" . $Edittype . "'";

		/*$strSQL = "UPDATE z_act SET act_status = '2' WHERE act_no = '".$p_act3."' and act_use = '$Edituser' ";

				$objQuery = mysql_query($strSQL);*/
	} else {

		$strSQL = "UPDATE req SET EditAct = '$EditAct', EditAct_id = '$EditAct_id', ActType = '$Edittype' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);

		$insert_sql .= ",EditAct,EditAct_id,ActType";

		$insert_value .= ",'" . $EditAct . "','" . $EditAct_id . "','" . $Edittype . "'";
	}
}

if ($EditCustomer == 'Y') {

	$strSQL = "UPDATE req SET EditPerson = '$EditPerson', EditCustomer = '$EditCustomer', Cus_title = '$Cus_title', Cus_name = '$Cus_name', Cus_last = '$Cus_last', Cus_add = '$Cus_add', Cus_group = '$Cus_group', Cus_town = '$Cus_town', Cus_lane = '$Cus_lane', Cus_road = '$Cus_road', Cus_tumbon = '$Cus_tumbon', Cus_amphur = '$Cus_amphur', Cus_province = '$Cus_province', Cus_postal = '$Cus_postal' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);

	$insert_sql .= ",EditPerson,EditCustomer,Cus_title,Cus_name,Cus_last,Cus_add,Cus_group,Cus_town,Cus_lane,Cus_road,Cus_tumbon,Cus_amphur,Cus_province,Cus_postal";

	$insert_value .= ",'" . $EditPerson . "','" . $EditCustomer . "','" . $Cus_title . "','" . $Cus_name . "','" . $Cus_last . "','" . $Cus_add . "','" . $Cus_group . "','" . $Cus_town . "','" . $Cus_lane . "','" . $Cus_road . "','" . $Cus_tumbon . "','" . $Cus_amphur . "','" . $Cus_province . "','" . $Cus_postal . "'";

	$strSQL = "UPDATE insuree SET person = '$EditPerson', icard = '$EditCard' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);
}

if ($EditReceipt == 'Y') {

	$strSQL = "UPDATE insuree SET career = '$EditCaree' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);



	$strSQL = "UPDATE req SET EditReceipt = 'Y' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);

	$insert_sql .= ",EditReceipt";

	$insert_value .= ",'Y'";
}

if ($EditTime == 'Y') {

	$strSQL = "UPDATE req SET EditTime = '$EditTime', EditTime_StartDate = '$TimeStartDate', EditTime_EndDate = '$TimeEndDate' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);

	$insert_sql .= ",EditTime,EditTime_StartDate,EditTime_EndDate";

	$insert_value .= ",'" . $EditTime . "','" . $TimeStartDate . "','" . $TimeEndDate . "'";
}

if ($EditHr == 'Y') {

	$strSQL = "UPDATE req SET EditHr = '$EditHr', EditHr_Detail = '$EditHr_Detail' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);

	$insert_sql .= ",EditHr,EditHr_Detail";

	$insert_value .= ",'" . $EditHr . "','" . $EditHr_Detail . "'";
}

if ($EditSendAdd == 'Y') {

	$strSQL = "UPDATE insuree SET SendAdd = '$EditNewAdd',status_SendAdd = '$status_SendAdd' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);
}

if ($EditCost == 'Y') {

	$strSQL = "UPDATE req SET EditCost = '$EditCost', EditcostCost = '$EditcostCost' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);

	$insert_sql .= ",EditCost,EditcostCost";

	$insert_value .= ",'" . $EditCost . "','" . $EditcostCost . "'";
}

//addon

if ($EditAddon == 'Y') {

	$code_addon = "";

	$code_addon_id = "";

	for ($n = 0; $n < count($_POST['addon_buy']); $n++) {

		$addon_array = explode(",", $_POST['addon_buy'][$n]);

		if ($n <= 0) {

			$commas = "";
		} else {

			$commas = ",";
		}

		$code_addon .= $commas . $addon_array[2]; // รหัส addon

		$code_addon_id .= $commas . $addon_array[0]; // id addon

	}

	$strSQL = "UPDATE req SET EditAddon = 'Y', code_addon = '$code_addon', code_addon_id = '$code_addon_id' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);

	$insert_sql .= ",EditAddon,code_addon,code_addon_id";

	$insert_value .= ",'Y','" . $code_addon . "','" . $code_addon_id . "'";
}

//เฉพาะยกเลิกแจ้งงานป้ายแดงเท่านั้น

if ($EditCancel == 'Y') {
	$strSQL = "SELECT car_body,n_motor FROM detail WHERE id_data = '$EditId_data'";
	$objQuery = $dbmy4ib_new->query($strSQL);
	$row = $objQuery->fetch();
	// $strSQL = "UPDATE req SET EditCancel = '$EditCancel', Cancel_Detail = '$Cancel_Detail', empcancel='" . $_SESSION["idtb_login"] . "' WHERE id_data = '$EditId_data'";
	// $objQuery = $dbmy4ib_new->query($strSQL);
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$insert_sql .= ",EditCancel,Cancel_Detail";
	$insert_value .= ",'" . $EditCancel . "','" . $Cancel_Detail . "'";
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$open_system = 'ON'; //OFF = ปิดใช้งานอนุมัติทางไลน์ , ON = เปิดใช้งานอนุมัติทางไลน์
	if ($open_system == 'OFF') {
		//------------ปิดเงือนใขเมื่อมีการใช้อนุมัติทางไลน์------------>

		$strSQL = "DELETE FROM  insurance_id WHERE car_body = '" . $row['car_body'] . "' ";

		$objQuery = $dbmy4ib_new->query($strSQL);

		$strSQL = "UPDATE req SET EditCancel = '$EditCancel', Req_Date = '$req_dmy',  Cancel_Detail = '$Cancel_Detail' , empcancel='" . $_SESSION["idtb_login"] . "' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);

		$insert_sql .= ",EditCancel,Cancel_Detail";

		$insert_value .= ",'" . $EditCancel . "','" . $Cancel_Detail . "'";

		$strSQL = "SELECT car_body,n_motor FROM detail WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);

		$row = $objQuery->fetch();

		$car_body_c = str_replace(' (ยกเลิก)', '', $row['car_body']);

		$n_motor_c = str_replace(' (ยกเลิก)', '', $row['n_motor']);

		$strSQL = "UPDATE detail SET car_body = '" . $car_body_c . " (ยกเลิก)', n_motor = '" . $n_motor_c . " (ยกเลิก)' WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);

		$strSQL = "UPDATE z_act SET act_status = 'C' WHERE act_no = '$Editp_act3' ";

		$objQuery = $dbmy4ib_new->query($strSQL);



		$strSQL = "DELETE FROM payment WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);



		$strSQL = "DELETE FROM payment_act WHERE id_data = '$EditId_data'";

		$objQuery = $dbmy4ib_new->query($strSQL);

		//<------------END ปิดเงือนใขเมื่อมีการใช้อนุมัติทางไลน์------------>
	} else {

		//line อนุมัติยกเลิกกรมธรรม

		$approve_sql = "INSERT INTO approve_cancel (status_approve,date_cancel,id_data,user_cancel,emp_cancel,detail_cancel) VALUES (:status_approve,:date_cancel,:id_data,:user_cancel,:emp_cancel,:detail_cancel)";

		$approve_query = $dbmy4ib_new->prepare($approve_sql);

		$approve_query->execute(

			array(

				"status_approve" => "R", "date_cancel" => date('Y-m-d H:i:s'), "id_data" => "$EditId_data", "user_cancel" => "$_SESSION[strUser]", "emp_cancel" => "$_SESSION[idtb_login]", "detail_cancel" => "$Cancel_Detail"

			)

		);

		if ($approve_query && !empty($EditId_data)) {

			$title_name = "แจ้งยกเลิกกรมธรรม์ 09712";

			$detail_url = "https://www.fourinsured.com/policy/pageApprove_Cancel_09712.php?id=" . str_replace('/รย/', '-', $EditId_data);

			//$detail_url="http://203.146.170.92/~fourinsure/policy/pageApprove_Cancel_09712.php?id=" . str_replace('/รย/', '-', $EditId_data);


			//IT
			//$TokenIT = 'eB7v2xYfPWkOsVJqLLXQsQT9BdFJPrF8pwDIJjSyGs5';
			//PHO
			//$TokenIT = 'a4jKkH1CruisQgK3etc6H2MBuuCGI4JvTaJtUAMHdBm';
			$TokenIT = 'ol5KHy1JJHd1zlAEmUOU7vAKWnM1exo80AEib8HbLTR';
			$messageIT = 'เลขรับแจ้ง : ' . $EditId_data . '%0Aเรื่อง : ' . $title_name . '%0A' . 'รายละเอียดการยกเลิก : ' . $Cancel_Detail . '%0Aดูรายละเอียด : ' . $detail_url . '%0A' . 'ผู้แจ้งยกเลิก : ' . $_SESSION['strUser'];

			$start_fun->line_notify($TokenIT, $messageIT);
		}

		//END line อนุมัติยกเลิกกรมธรรม
	}
}

//END เฉพาะยกเลิกแจ้งงานป้ายแดงเท่านั้น

if ($EditProduct == 'Y' && $Edit_addTun == 'Y') {

	$strSQL = "UPDATE req SET EditProduct = '$EditProduct', Product = '$DetailProduct', TotalProduct = '$TotalProduct', CostProduct = '$PriceProduct' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);

	$insert_sql .= ",EditProduct,Product,TotalProduct,CostProduct";

	$insert_value .= ",'" . $EditProduct . "','" . $DetailProduct . "','" . $TotalProduct . "','" . $PriceProduct . "'";
} else if ($EditProduct == 'Y') {

	$strSQL = "UPDATE req SET EditProduct = '$EditProduct', Product = '$DetailProduct', TotalProduct = '$TotalProduct', CostProduct = '$PriceProduct' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);

	$insert_sql .= ",EditProduct,Product,TotalProduct,CostProduct";

	$insert_value .= ",'" . $EditProduct . "','" . $DetailProduct . "','" . $TotalProduct . "','" . $PriceProduct . "'";
} else if ($Edit_addTun == 'Y') {

	$strSQL = "UPDATE req SET EditProduct = '$Edit_addTun', Product = '$DetailProduct', TotalProduct = '$TotalProduct', CostProduct = '$PriceProduct' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);

	$insert_sql .= ",EditProduct,Product,TotalProduct,CostProduct";

	$insert_value .= ",'" . $Edit_addTun . "','" . $DetailProduct . "','" . $TotalProduct . "','" . $PriceProduct . "'";
}



// 220/230

if ($Edit_addAT == 'Y') {

	$strSQL = "UPDATE detail SET car_cat_acc = '$car_cat_acc', car_cat_acc_total = '$add_pre_at',car_cat_acc_p_total = '$car_cat_acc_p_total',car_cat_acc_b_total = '$car_cat_acc_b_total' WHERE id_data = '$EditId_data'";

	$objQuery = $dbmy4ib_new->query($strSQL);
}

$sql = "SELECT id_data FROM data WHERE id_data='$EditId_data'";

$result = $dbmy4ib_new->query($sql);

$fetcharr = $result->fetch();

$id = $fetcharr["id_data"];



$returnedArray['Re_req'] = 2;

if ($EditCancel == "Y") {

	$returnedArray['msg'] = $EditCancel;
}



$insert_req_story_sql = "INSERT INTO req_story (" . $insert_sql . ") VALUES (" . $insert_value . ")";

$insert_req_story_query = $dbmy4ib_new->query($insert_req_story_sql);

$returnedArray['id'] = base64_encode($id);

echo json_encode($returnedArray);

//}



// begin sing

@$dbmy4ib_new->query("SET SQL_SAFE_UPDATES = 0;");

$sql_rpt = "DELETE FROM __report_individuals WHERE id_data_send LIKE '%" . $EditId_data . "%';";

@$dbmy4ib_new->query($sql_rpt);

@$dbmy4ib_new->query("SET SQL_SAFE_UPDATES = 1;");

$sql_rpt = "CALL prepare_individuals('" . $EditId_data . "');";

@$dbmy4ib_new->query($sql_rpt);

				

				//echo $insert_req_story_sql;

				// end sing