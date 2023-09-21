<?php session_start();

include "../inc/connectdbs.pdo.php";
require('../rest_api_lib/httpful.phar');
require('../model-response/model-response.php');
require('../model-response/check-act-id-model.php');
require('../services/LineNoti.service.php');

function loadPerson($dataID)
{
	$sql = "SELECT person FROM insuree WHERE id_data = '$dataID'";
	$_perInfo = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetch();
	return $_perInfo['person'];
}

//Link Api and Basic Authentication
// $url = 'https://wsdev.viriyah.co.th/ViriyahWSPolicy/SendEPolicyCMIRealTime';

// $url='https://wsdev.viriyah.co.th/ViriyahWSPolicyDev/SendEPolicyCMIRealTime';
// $username ="WS09712";
// $password ="N6n8R7yb2x";

$url = 'https://ws.viriyah.co.th/ViriyahWSPolicy/SendEPolicyCMIRealTime';
$username = "WS09712";
$password = "tZXpYj46s2";

$objCarProvince = new CarProvince(); //Get Car province All to model
$chkdata = $_POST['DataId'];

$iddataall = '';



$IDDATA = $chkdata;

$_context = new QueryStorePdo();
$row = $_context->CommandQuery($IDDATA);
$_res['SqlQuery'] = $_context->SqlCode;
$carProvince = $objCarProvince->getOicCarprovinceById($row['car_regis_pro']);
$apiRequestModel = new SuzukiApiRequestMapModel($row, $carProvince, $IDDATA);

#region Mapper Array request api viriya
$params = array(
	'status' => "{$apiRequestModel->Status}",
	'agentCode' => "{$apiRequestModel->agcode}",
	'transactionID' => "{$apiRequestModel->TransactionId}",
	'saleName' => "{$apiRequestModel->SaleName}",
	'appSignDate' => "{$apiRequestModel->AppSignDate}",
	'effectiveDate' => "{$apiRequestModel->EffectiveDate}",
	'expiredDate' => "{$apiRequestModel->ExpiredDate}",
	'insuredcardType' => "{$apiRequestModel->CardType}",
	'insuredcardNo' => "{$apiRequestModel->CardNo}",
	'insuredType' => "{$apiRequestModel->InsuredType}",
	'insuredTitleName' => "{$apiRequestModel->InsuredTitleName}",
	'insuredName' => "{$apiRequestModel->InsuredName}",
	'insuredLastName' => "{$apiRequestModel->InsuredLastName}",
	'insuredCorporateName' => "{$apiRequestModel->InsuredCorporateName}",
	'insuredHeadOffice' => "{$apiRequestModel->InsuredHeadOffice}",
	'insuredBranchCode' => "{$apiRequestModel->InsuredBranchCode}",
	'insuredGender' => "{$apiRequestModel->Gender}",
	'insuredBirthDate' => "{$apiRequestModel->BirthDate}",
	'insuredTelephone' => "{$apiRequestModel->Telephone}",
	'insuredMobileNo' => "{$apiRequestModel->MobileNo}",
	'insuredHomeNo' => "{$apiRequestModel->HomeNo}",
	'insuredBuilding' => "{$apiRequestModel->Building}",
	'insuredMoo' => "{$apiRequestModel->Group}",
	'insuredTrok' => "{$apiRequestModel->Trok}",
	'insuredSoi' => "{$apiRequestModel->Soi}",
	'insuredRoad' => "{$apiRequestModel->Road}",
	'insuredTambol' => "{$apiRequestModel->Tambol}",
	'insuredAmphur' => "{$apiRequestModel->Amphur}",
	'insuredProvince' => "{$apiRequestModel->Province}",
	'insuredPostcode' => "{$apiRequestModel->Postcode}",
	'licensePlateType' => "{$apiRequestModel->LicenseNo}",
	'licensePlateNo' => "{$apiRequestModel->LicensePlateNo}",
	'licenseProvince' => "{$apiRequestModel->LicenseProvince}",
	'chassisNo' => "{$apiRequestModel->Chassis}",
	'engineNo' => "{$apiRequestModel->Engine}",
	'vehicleType' => "{$apiRequestModel->VehicleType}",
	'carBrand' => "{$apiRequestModel->VehicleMake}",
	'carModel' => "{$apiRequestModel->VehicleModel}",
	'vehicleRegYear' => "{$apiRequestModel->VehicleRegYear}",
	'seat' => "{$apiRequestModel->Seat}",
	'cc' => "{$apiRequestModel->CC}",
	'weight' => "{$apiRequestModel->VehicleWeight}",
	'premium' => "{$apiRequestModel->NetPremium}",
	'discount' => "{$apiRequestModel->Discount}",
	'netPremium' => "{$apiRequestModel->NetPremium}",
	'vat' => "{$apiRequestModel->Vat}",
	'stamp' => "{$apiRequestModel->Stamp}",
	'grossPremium' => "{$apiRequestModel->GrossPremium}",
	'flagOnline' => "{$apiRequestModel->FlagOnline}",
	'emailCustomer' => "{$apiRequestModel->email_customer}",
	'emailAgent' => "{$apiRequestModel->email_agent}",
	'onlinePaymentNo' => "{$apiRequestModel->OnlinePayment_no}",
	'onlinePaymentAmout' => "{$apiRequestModel->OnlinePayment_amt}",
	'onlinemerchantID' => "{$apiRequestModel->onlinemerchant_id}",
	'dealerCode' => "{$apiRequestModel->DelarCode}"
);

#endregion

/*********************************************************************************************************************************************************************** */
//  echo json_encode($params); //ปิดตอน production เปิด ตอน test เท่านั้น
//  goto top;

//post to api viriya
$response = \Httpful\Request::post($url)
	->sendsJson()
	->authenticateWith($username, $password)
	->body(json_encode($params))
	->send();

//map response api to model
$res = new ResponseApiModel();
$_res['ResponseAPI'] = $response;

$res->mapResult($response);
$resinfo = $res->apiresponse();

$contextFour = PDO_CONNECTION::fourinsure_insured();

$resultResponse = $res->Result == true ? 'Success' : 'Fail';
//insert history

if ($res->Result == true) {
	$sqlCommandHis = "INSERT INTO wsdl_vib_result (id_data, ws_result, ws_errcode, ws_errormsg, ws_policyno, ws_barcode, ws_policyurl, ws_entrydate, ws_emp, ws_system) 
			VALUES (?,?,?,?,?,?,?,?,?,?);";

	date_default_timezone_set("Asia/Bangkok");
	$dateNow = date("Y-m-d H:i:s");
	$numberPrb = explode('-', $res->PolicyNo);

	$dataPayLoad = array(
		"$IDDATA",
		"$resultResponse",
		"$res->ErrorCode",
		"$res->ErrorMsg",
		"$numberPrb[1]",
		"$res->BarcodeNo",
		"$res->PolicyUrl",
		"$dateNow", 'PACK', 'Mitsubishi'
	);

	$command = $contextFour->prepare($sqlCommandHis);
	$command->execute($dataPayLoad);

	$contextFour = null;
} else {
	$sqlCommandHis = "INSERT INTO wsdl_vib_result (id_data, ws_result, ws_errcode, ws_errormsg, ws_policyno, ws_barcode, ws_policyurl, ws_entrydate, ws_emp, ws_system) 
			VALUES (?,?,?,?,?,?,?,?,?,?);";

	date_default_timezone_set("Asia/Bangkok");
	$dateNow = date("Y-m-d H:i:s");
	$numberPrb = explode('-', $res->PolicyNo);

	$dataPayLoad = array(
		"$IDDATA",
		"$resultResponse",
		"$res->ErrorCode",
		"$res->ErrorMsg",
		"$numberPrb[1]",
		"$res->BarcodeNo",
		"$res->PolicyUrl",
		"$dateNow", 'PACK', 'Mitsubishi'
	);

	$command = $contextFour->prepare($sqlCommandHis);
	$command->execute($dataPayLoad);

	$contextFour = null;
}

if ($res->Result == true) {

	$contextmy4 = PDO_CONNECTION::fourinsure_mitsu();

	$sqlCommandHis = "UPDATE insuree SET ws_prb_status ='Y' WHERE id_data = ?";
	$dataPayLoad = array("$IDDATA");
	$command = $contextmy4->prepare($sqlCommandHis);
	$command->execute($dataPayLoad);

	/*
			if($command->rowCount()){echo "<script>
				console.log('UPDATE INSUREE TRUE OK!');
			</script>";}

			$actck = new CheckActId($contextmy4);//เช็คว่ามีการใช้ เลข พ.ร.บ. แบบเก่าอยู่รึเปล่า
			$option = $actck->CheckAct($IDDATA);

			if($option == 1)//ถ้าไม่มีช่องว่างจะเข้า loop แล้วจะไม่เขียน ทับ p_act ใน act,data
			{
				$sqlCommandHis = "UPDATE act SET tmp_act_id = :policyno,barcode_id = :barcode,ws_path_policy = :policyurl,full_act_id = :full 
				WHERE id_data = :id_data";

				$fullActId = "$apiRequestModel->agcode-$apiRequestModel->agYear$apiRequestModel->agsaka-$numberPrb[2]";
				$dataPayLoad = array(
				'policyno'=>"$numberPrb[2]",
				'barcode'=>"$res->BarcodeNo",
				'policyurl'=>"$res->PolicyUrl",
				'full'=>"$fullActId",
				'id_data'=>"$IDDATA");
				$command = $contextmy4->prepare($sqlCommandHis);
				$command->execute($dataPayLoad);
                // if($command->rowCount()){echo "<script>console.log('UPDATE ACT OK!');</script>";}
                
                goto top;

			}
			else
			{*/

	$sqlCommandHis = "UPDATE act SET p_act = :P_ACT ,PactOnline = :pAct, tmp_act_id = :policyno, barcode_id = :barcode, ws_path_policy = :policyurl, full_act_id = :full 
				WHERE id_data = :id_data";

	$fullActId = "$apiRequestModel->agcode-$apiRequestModel->agYear$apiRequestModel->agsaka-$numberPrb[1]";
	$dataPayLoad = array(
		'P_ACT' => "-",
		'policyno' => "$numberPrb[1]",
		'barcode' => "$res->BarcodeNo",
		'policyurl' => "$res->PolicyUrl",
		'full' => "$fullActId",
		'pAct' => "$fullActId",
		'id_data' => "$IDDATA"
	);
	$command = $contextmy4->prepare($sqlCommandHis);
	$command->execute($dataPayLoad);

	$sqlCommandHis = "UPDATE `data` SET PactOnline = :PACT, p_act = :P_ACT WHERE id_data = :id_data";
	$dataPayLoad = array('PACT' => "$fullActId", 'id_data' => "$IDDATA", 'P_ACT' => "-");
	$command = $contextmy4->prepare($sqlCommandHis);
	$command->execute($dataPayLoad);

	// }

	$contextmy4 = null;

	$_res['Status'] = 200;
	$_res['DataId'] = $IDDATA;
	$_res['PerSonID'] = loadPerson($IDDATA);
	$_res['msg'] = "ระบบดำเนินการบันทึกสมบูรณ์แล้ว! ใบแจ้งเลขที่ :$IDDATA";
	$_res['paramiter'] = $params;
	echo json_encode($_res);
} else {
	$contextInform = PDO_CONNECTION::fourinsure_mitsu();

	$sqlCommandHis = "UPDATE insuree SET ws_prb_status ='N' WHERE id_data = ?";
	$dataPayLoad = array("$IDDATA");
	$command = $contextInform->prepare($sqlCommandHis);
	$command->execute($dataPayLoad);

	$_paramPact = array('P_act' => 'ติดต่อเจ้าหน้าที่', 'dataID' => "$IDDATA");

	$sql = "UPDATE `data` SET p_act = :P_act WHERE id_data = :dataID";
	$contextInform->prepare($sql)->execute($_paramPact);

	$sql = "UPDATE act SET p_act = :P_act WHERE id_data = :dataID";
	$contextInform->prepare($sql)->execute($_paramPact);

	$sql = "SELECT tb_customer.saka,tb_customer.sub FROM `data` LEFT JOIN tb_customer ON(tb_customer.user = `data`.login) 
			WHERE `data`.id_data = '$IDDATA'";
	$infoDearler = $contextInform->query($sql)->fetch();

	$_messLine = "ดีลเลอร์สาขา $infoDearler[saka] ชื่อ $infoDearler[sub] ไม่สามารถออก Smart พ.ร.บ. ได้ \r\n";
	$_messLine .= "ApiErrorMsg: $res->ErrorMsg \r\n";
	$_messLine .= "เลขที่รับแจ้ง $IDDATA \r\nวัน-เวลา: " . date('Y-m-d H:i:s');

	$_tokenLine = 'vzxHheVlyquXKllC5RjsnyfXxs6TKSNu6V8IFPXUFxe'; //Token LINE

	LineNotificationControl::linenotify($_tokenLine, $_messLine);


	#region
	/*$sqlCommand = "UPDATE tb_inform SET status = '1' WHERE tb_inform.num_inform = :inform";
            $payload = array('inform'=>"$IDDATA");
            $comMand = $contextInform->prepare($sqlCommand);
            $comMand->execute($payload);
            

            $sqlCommand = "DELETE FROM detail WHERE detail.id_data = :inform";
            $comMand = $contextInform->prepare($sqlCommand);
            $comMand->execute($payload);
            

            $sqlCommand = "DELETE FROM `data` WHERE data.id_data = :inform";
            $comMand = $contextInform->prepare($sqlCommand);
            $comMand->execute($payload);
            

            $sqlCommand = "DELETE FROM insuree WHERE insuree.id_data = :inform";
            $comMand = $contextInform->prepare($sqlCommand);
            $comMand->execute($payload);
            

            $sqlCommand = "DELETE FROM driver WHERE driver.id_data = :inform";
            $comMand = $contextInform->prepare($sqlCommand);
            $comMand->execute($payload);
            

            $sqlCommand = "DELETE FROM protect WHERE protect.id_data = :inform";
            $comMand = $contextInform->prepare($sqlCommand);
			$comMand->execute($payload);
			
			$sqlCommand = "DELETE FROM req WHERE req.id_data = :inform";
            $comMand = $contextInform->prepare($sqlCommand);
			$comMand->execute($payload);
			
			$sqlCommand = "DELETE FROM act WHERE act.id_data = :inform";
            $comMand = $contextInform->prepare($sqlCommand);
            $comMand->execute($payload);
            

			$contextInform = null;*/
	#endregion

	$_res['Status'] = 200;
	$_res['DataId'] = $IDDATA;
	$_res['PerSonID'] = loadPerson($IDDATA);
	// $_res['msg'] = "ใบแจ้งเลขที่ :$IDDATA ไม่สามารถบันทึกได้ ทางระบบได้คืน เลข เรียบร้อยแล้ว กรุณา ติดต่อ Admin และเปิดหน้านี้ค้างไว้ ห้ามปิด ขอบคุณครับ";
	$_res['msg'] = "ระบบดำเนินการบันทึกสมบูรณ์แล้ว! ใบแจ้งเลขที่ :$IDDATA";
	$_res['paramiter'] = $params;
	echo json_encode($_res);
}