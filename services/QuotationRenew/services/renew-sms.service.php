<?php

session_start();
class SMSBitlyControl
{
	private $_context;
	public function __construct($con)
	{
		$this->_context = $con;
	}
	public function shorten_url($smsUrl)
	{
		$_bitly = BitlyLink::getBitlyLink($smsUrl, $this->_context);  //sent long url to convert a bitly.
		return $_bitly;
	}
}


class RenewSendSMSControl
{

	private $_contextFour;
	private $_contextMitsu;
	private $_cviriyahService;
	private $_bitlyService;

	public function __construct($four, $mitsubishi)
	{
		$this->_contextFour = $four;
		$this->_contextMitsu = $mitsubishi;
		$this->_bitlyService = new SMSBitlyControl($four);
		$this->_cviriyahService = new RenewCreditFormViriyah($four, $mitsubishi, $_SESSION['strUser'], $this->_bitlyService);
	}

	public function sendQuotationBitlySms($req)
	{
		$cReg = $this->_contextMitsu
			->query("SELECT detail.car_regis, detail.br_car, detail.mo_car, `data`.`login` FROM detail LEFT JOIN `data` 
			ON(`data`.id_data = detail.id_data) WHERE `data`.id_data = '$req->DataID'")
			->fetch(5);

		$carName = $this->_contextFour
			->query("SELECT `name` FROM tb_br_car WHERE id = '$cReg->br_car'")->fetch(5)->name;

		$carModel = $this->_contextFour
			->query("SELECT `name` FROM tb_mo_car WHERE id = '$cReg->mo_car'")->fetch(5)->name;


		//หารายชื่อ ผู้รับผิดชอบ และเบอร์โทรหากได้รับการอนุมัติ
		$sql = "SELECT
			t.emp_namerenew AS empname,
			t.emp_telrenew,
			t.short_name AS shortName 
		FROM
			tb_customer AS t
			INNER JOIN upload_admin_telephone AS a ON ( a.DealerCode = t.user ) 
		WHERE
			a.DealerCode = '$cReg->login' 
			AND a.Approve = 'Y' AND a.Follow = 'D' 
		ORDER BY
			a.Id DESC 
			LIMIT 1";

		$empRenew = $this->_contextMitsu->query($sql)->fetch(5);

		if ($req->TypeDocRenew == 'F') { //ถ้าเป็นใบแรกเตือนต่ออายุ
			$smstext = "ใบเตือนต่ออายุ กรมธรรม์รถยนต์ $carName/$carModel ความคุ้มครองของท่านใกล้จะหมดอายุ ดูรายละเอียดคลิก ";
			$longUrl = _MainViriyahNet .
				"/outside/print/print_renewal_note_vib.php?id=$req->DataID&st=$req->TypeDocRenew";
		} else { //ถ้าเป็นใบที่มาจากการเสนอราคาอีกครั้ง
			$smstext = "แจ้งยอดชำระต่ออายุประกันภัยรถยนต์ $carName/$carModel \r\nดูรายละเอียดคลิก ";
			$longUrl = _MainViriyahNet .
				"/outside/print/print_quotation_renew_vib.php?id=$req->DataID&id_key=$req->DetailRenewID&st=$req->TypeDocRenew";
		}

		$data_bitly = _PointerDev == true ? $longUrl : $this->_bitlyService->shorten_url($longUrl); //ย่อลิ๊งใบเตือน

		if ($data_bitly == false) {
			return false;
		}

		// $viriCF = false;

		//ออกลิ๊งผ่อนชำระต่ออายุ mitsubishi พร้อมย่อlink

		//response :array[textApi ,textString]
		$viriCF = $this->_cviriyahService->getLinkForRenewSuzukiVIB($req->DataID, $req->DetailRenewID, $req->TypeDocRenew);

		$dataSix = explode('/', $req->DataID); //เอาเลขรับแจ้งมาหั่นใช้เฉพาะเลข6หลัก

		$textWorming = '';//'เตือนภัยมิจฉาชีพหลอกขายประกันภัยรถยนต์ ฟังเสียง https://bit.ly/3ix0OeN';

		if ($viriCF == false) {
			if (empty($empRenew)) //ถ้าไม่มีผู้รับผิดชอบ เข้าโฟร์ทั้งหมด
			{
				$smstext .= $data_bitly . " ติดต่อฝ่ายต่ออายุโทร 021968234 อ้างอิง $dataSix[2] ".$textWorming;

			} else {

				$smstext .= $data_bitly . " ติดต่อฝ่ายต่ออายุ โทร ".
					str_replace(array('-', ' '), '', $empRenew->emp_telrenew) ." ดีลเลอร์ $empRenew->shortName ". $empRenew->empname.' '.$textWorming;
			}
		} else {

			if (empty($empRenew)) //ถ้าไม่มีผู้รับผิดชอบ เข้าโฟร์ทั้งหมด
			{
				$smstext .= $data_bitly . $viriCF['textApi'] . " ติดต่อฝ่ายต่ออายุโทร 021968234 อ้างอิง $dataSix[2] ".$textWorming;

			} else {

				$smstext .= $data_bitly . $viriCF['textApi']  . " ติดต่อฝ่ายต่ออายุ โทร ".
					str_replace(array('-', ' '), '', $empRenew->emp_telrenew) ." ดีลเลอร์ $empRenew->shortName ". 
					$empRenew->empname . ' อ้างอิง ' . $dataSix[2].' '.$textWorming;
			}
		}

		if (
			$data_bitly != 'MISSING_ARG_ACCESS_TOKEN' && $data_bitly != 'INVALID_APIKEY'
			&& $data_bitly != 'MONTHLY_RATE_LIMIT_EXCEEDED' && $data_bitly != '' && $data_bitly != 'Method Not Allowed'
			&& $data_bitly != 'bitlinks'
		) {

			if (_PointerDev) {
				foreach ($req->NumberList as $number) {
					if (strlen($number) == 10) {
						$this->saveSmsDetail($_SESSION['strUser'], str_replace('0%25','0%',$smstext), $number, $req->DataID, $req->DetailRenewID);
					}
				}
				return $smstext;
			} else {
				foreach ($req->NumberList as $number) {
					if (strlen($number) == 10) {
						$this->saveSmsDetail($_SESSION['strUser'], str_replace('0%25','0%',$smstext), $number, $req->DataID, $req->DetailRenewID);
						SendSmsService::SmsHandle($smstext, $number);
					}
				}
				return $smstext;
			}
		} else {
			return false;
		}
	}
	public function sendSmsWarning($req)
	{
		$textWorming = 'เตือนภัยมิจฉาชีพหลอกขายประกันภัยรถยนต์ ฟังเสียง https://bit.ly/3ix0OeN';

		foreach ($req->NumberList as $number) {
			if (strlen($number) == 10) {
				$this->saveSmsDetail($_SESSION['strUser'], $textWorming, $number, $req->DataID, $req->DetailRenewID);
				SendSmsService::SmsHandle($textWorming, $number);
			}
		}
		return $textWorming;
	}

	public function sendSmsPaymentViriyah($req)
	{
		$_mlink = "https://viriyah.net/mitsubishi/print/Print_Act_Notice.php?IDDATA=$req->DataID";

		$longBase = base64_encode($req->Link);
        $_link = _LinkViriyahCreditOnly."?Link=".$longBase;
		$_shortLink = $this->_bitlyService->shorten_url($_link);
		$_mbank = $this->_bitlyService->shorten_url($_mlink);
		
		$textPayment = "โปรดชำระค่าเบี้ย พ.ร.บ. ออนไลน์ ผ่านช่องทางบัตรเครดิต $_shortLink หรือโมบายแบงค์กิ้ง $_mbank";

		foreach ($req->Telophone as $number) {
			if (strlen($number) == 10) {
				$this->saveSmsDetail($_SESSION['strUser'], $textPayment, $number, $req->DataID, '0');
				SendSmsService::SmsHandle($textPayment, $number);
			}
		}

		return $textPayment;
	}

	private function saveSmsDetail($staff, $text, $tel, $dataID, $renewID)
	{
		$sql = "INSERT INTO smsdetail (sms_user,sms_text,sms_tel,smsid_data,sms_time,type_work,id_detail_renew) 
		VALUES (:sms_user, :sms_text, :sms_tel, :smsid_data, :sms_time, :type_work, :id_detail_renew)";
		$params = [
			'sms_user' => $staff,
			'sms_text' => $text,
			'sms_tel' => (string)$tel,
			'smsid_data' => $dataID,
			'sms_time' => date('Y-m-d H:i:s'),
			'type_work' => 'MITSUBISHI',
			'id_detail_renew' => $renewID
		];

		$result = $this->_contextFour->prepare($sql)->execute($params);
		return $result;
	}
}