<?php

require('../pages/check-ses.php');
require('../inc/connectdbs.pdo.php');
require('../services/Log/service/call-phone.service.php');

#region class
class LoadDetailRenewControl
{
	private $_context;
	private $_contextMitsu;
	private $_staff;
	private $_claim;

	public function __construct($con, $s, $c, $mitsu)
	{
		$this->_context = $con;
		$this->_staff = $s;
		$this->_claim = $c;
		$this->_contextMitsu = $mitsu;
	}

	public function getDetailsms($id)
	{
		$sql = "SELECT sms_user,sms_text,sms_time,sms_tel FROM smsdetail WHERE smsid_data = '$id' AND type_work = 'MITSUBISHI' ";
		$adminQuery = $this->_staff != 'admin' ? "AND sms_user = '{$this->_staff}'" : "";
		$sql = $sql . $adminQuery;
		$result = $this->_context->query($sql);
		return $result;
	}

	function renew($renew)
	{
		switch ($renew) {
			case "R":
				$renew = "ติดตาม";
				break;
			case "S":
				$renew = "เสนอราคา";
				break;
			case "C":
				$renew = "แจ้งงาน";
				break;
			case "A":
				$renew = "ติดต่อได้ไม่ได้";
				break;
			case "E":
				$renew = "ปิดงาน";
				break;
			case "O":
				$renew = "ที่อื่นถูกกว่า";
				break;
			case "N":
				$renew = "ไม่สนใจ";
				break;
			case "W":
				$renew = "ข้อมูลผิด";
				break;
			case "P":
				$renew = "ต่อแล้ว";
				break;
		}
		return $renew;
	}

	function thaiDate($datetime)
	{
		list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
		list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
		$Y = $Y + 543; // เปลี่ยน ค.ศ. เป็น พ.ศ.

		switch ($m) {
			case "01":
				$m = "01";
				break;
			case "02":
				$m = "02";
				break;
			case "03":
				$m = "03";
				break;
			case "04":
				$m = "04";
				break;
			case "05":
				$m = "05";
				break;
			case "06":
				$m = "06";
				break;
			case "07":
				$m = "07";
				break;
			case "08":
				$m = "08";
				break;
			case "09":
				$m = "09";
				break;
			case "10":
				$m = "10";
				break;
			case "11":
				$m = "11";
				break;
			case "12":
				$m = "12";
				break;
		}
		return $d . "/" . $m . "/" . $Y . " " . $H . ":" . $i;
	}

	function thaiDate2($datetime)
	{
		list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
		list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
		$Y = $Y + 543; // เปลี่ยน ค.ศ. เป็น พ.ศ.

		switch ($m) {
			case "01":
				$m = "01";
				break;
			case "02":
				$m = "02";
				break;
			case "03":
				$m = "03";
				break;
			case "04":
				$m = "04";
				break;
			case "05":
				$m = "05";
				break;
			case "06":
				$m = "06";
				break;
			case "07":
				$m = "07";
				break;
			case "08":
				$m = "08";
				break;
			case "09":
				$m = "09";
				break;
			case "10":
				$m = "10";
				break;
			case "11":
				$m = "11";
				break;
			case "12":
				$m = "12";
				break;
		}
		return $d . "/" . $m . "/" . $Y;
	}

	function dateForSort($datetime)
	{
		list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
		list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
		// $Y = $Y + 543; // เปลี่ยน ค.ศ. เป็น พ.ศ.

		switch ($m) {
			case "01":
				$m = "01";
				break;
			case "02":
				$m = "02";
				break;
			case "03":
				$m = "03";
				break;
			case "04":
				$m = "04";
				break;
			case "05":
				$m = "05";
				break;
			case "06":
				$m = "06";
				break;
			case "07":
				$m = "07";
				break;
			case "08":
				$m = "08";
				break;
			case "09":
				$m = "09";
				break;
			case "10":
				$m = "10";
				break;
			case "11":
				$m = "11";
				break;
			case "12":
				$m = "12";
				break;
		}
		return $Y . $m . $d . $H .$i;
	}

	function getDetailRenew($id)
	{
		$sql_login = $this->_staff != 'admin' && $this->_claim != 'ADMIN' ? " AND  dtr.userdetail = '{$this->_staff}' " : '';
		$txtsql = "SELECT dtr.*, dtr.status AS status_renew, dtf.name AS de_follow
		FROM detail_renew dtr
		INNER JOIN `data` ON (dtr.id_data = `data`.id_data) 
		LEFT JOIN tb_data_follow dtf ON (dtr.detail_follow = dtf.id)
		WHERE dtr.id_data = '$id' " . $sql_login . " ORDER BY dtr.timecall DESC  ";
		// echo $txtsql; exit;
		$res = $this->_contextMitsu->query($txtsql)->fetchAll(2);
		return $res;
	}

	function getCloseWorkRenew($id)
	{
		$sql_login = $this->_staff != 'admin' && $this->_claim != 'ADMIN' ? " AND  dtr.userdetail = '{$this->_staff}' " : '';
		$txtsql_e = "SELECT * FROM detail_renew dtr
		INNER JOIN `data` ON (dtr.id_data = `data`.id_data) 
		WHERE dtr.id_data = '$id' " . $sql_login . " AND dtr.status = 'E' ORDER BY dtr.timecall DESC";
		// echo $txtsql; exit;
		$result_e = $this->_contextMitsu->query($txtsql_e)->fetch(2);
		return $result_e;
	}
	public function copylink($value) {
    
		$x = $value;

		$number = 0;
		$y = explode(' ',$x);

		$r = 'bit.ly';

		$main = '';

		foreach($y as $n)
		{
			if(similar_text($n,$r)==6)
			{
				
				if(similar_text(trim($n),'ผ่อนสบาย0%')==26)
				{
					$word = str_replace('ผ่อนสบาย0%','',$n);
					$number  = "<a href='javascript:(0)' class='text-decation underline-none' onclick='coppyBoard(`$word`)'>$word</a>";
					$main .= $number .'ผ่อนสบาย0%' ;
				}
				else if(similar_text(trim($n),'ติดต่อฝ่ายต่ออายุโทร')==60)
				{
					$word = str_replace('ติดต่อฝ่ายต่ออายุโทร','',$n);
					$number  = "<a href='javascript:(0)' class='text-decation underline-none' onclick='coppyBoard(`$word`)'>$word</a>";
					$main .= $number .'ติดต่อฝ่ายต่ออายุโทร' ;
				}
				 else 
				{
					$number  = "<a href='javascript:(0)' class='text-decation underline-none' onclick='coppyBoard(`".str_replace (array('ดูรายละเอียดคลิก','ผ่อนสบาย0%'),'',$n)."`)'>$n</a>";
					$main .= $number;
				}
				
		}
			else
		{
				$main .= $n;
		}

		}
	//  echo $main;exit;

          return  $main;
 	}
}
$_serviceCallPhone = new CallPhone(PDO_CONNECTION::fourinsure_insured());
$_service = new LoadDetailRenewControl(
	PDO_CONNECTION::fourinsure_insured(),
	$_SESSION["strUser"],
	$_SESSION['claim'],
	PDO_CONNECTION::fourinsure_mitsu()
);
$result = $_service->getDetailRenew($_GET['iddata']);
$array_e = $_service->getCloseWorkRenew($_GET['iddata']);
$resultSms = $_service->getDetailsms($_GET['iddata']);
$resultCall = $_serviceCallPhone->getLogByIdData($_GET['iddata']);

$i = 0;
$datas = array();

#endregion
// $start = $_GET['start'];
// $end = $_GET['length'];

foreach ($result as $row) {

	$cost_renew = explode('|', $row['detailcost']);
	if ($row['add_on'] == 'Y') {
		$add_on = "เอา";
	} else if ($row['add_on'] == 'N') {
		$add_on = "ไม่เอา";
	} else {
		$add_on = "ยังไม่ได้เลือก";
	}

	// เบี้ยสุทธิ
	$sum_pre = $cost_renew[10] - $cost_renew[5] - $cost_renew[7];
	// อากร
	$sum_pre_duty = ceil(($sum_pre * 0.004));
	//ภาษี
	$sum_pre_vat = round(($sum_pre + $sum_pre_duty) * 0.07, 2);
	// รวม
	$sum_pretotal = $sum_pre + $sum_pre_duty + $sum_pre_vat;
	//ส่วนลด
	$sum_dis = $cost_renew[5] + $cost_renew[7];

	$datas[$i]['date_detail'] = $_service->thaiDate($row['date_detail']);
	$datas[$i]['timecall'] = $_service->thaiDate($row['timecall']);
	$datas[$i]['pretotal'] = number_format($sum_pretotal, 2);
	$datas[$i]['prb'] = number_format($cost_renew[9], 2);
	$datas[$i]['sum_pretotal'] = number_format($cost_renew[8], 2);

	if ($row['status_renew'] != 'N') {
		if (!empty($row['de_follow'])) {
			$detail_follow = "<br><font color='red'>(" . $row['de_follow'] . " : " . $row['other_detail_follow'] . ")</font>";
		} else {
			$detail_follow = "";
		}
	} else {
		if ($row['open_detail'] == 'Y') {
			$detail_follow = "<br><font color='red'>(" . $row['other_detail_follow'] . ")</font>";
		} else if (!empty($row['de_follow'])) {
			$detail_follow = "<br><font color='red'>(" . $row['de_follow'] . ")</font>";
		} else {
			$detail_follow = "";
		}
	}

	$datas[$i]['status'] = $_service->renew($row['status_renew']) . $detail_follow;
	$datas[$i]['add_on1'] = $add_on;
	$datas[$i]['detailtext'] = $row['detailtext'];
	$datas[$i]['date_alert'] =  date('d/m/Y', strtotime($row['date_alert']));
	$datas[$i]['id_detail2'] =  $row['id_detail'];
	$datas[$i]['userdetail'] =  $row['userdetail'];
	$datas[$i]['detail_doc_type'] =  $row['detail_doc_type'];
	$datas[$i]['renew_comp'] =  $row['renew_comp'];

	$r = $row['status_renew'];

	//TODO เปลี่ยนคำหน้าปุ่ม
	if ($r == 'S' || $r == 'F') {
		$datas[$i]['print'] =  "
				<div class='test-x'>
					<a href='print/print_quotation_renew_vib.php?id=" . $row['id_data'] . "&id_key=" . $row['id_detail'] . "&st=" . $row['status_renew'] . "' target='_BLANK' class='txtp text-white bg-yellow-500 cursor-pointer'>ดูใบเสนอราคา</a>
				</div>
			";

		if($r == 'F')
		{
			$datas[$i]['sms'] = "
			<div class='test-x'>
				<button class='btn-sms' data-toggle='modal' data-target='#sendSmsQuotation' onclick='sendSMSQuotationDealer(`$row[id_data]`,`$row[id_detail]`,`F`)'>ส่ง SMS</button>
			</div>
			";
		}else
		{
			$datas[$i]['sms'] = "
			<div class='test-x'>
				<button class='btn-sms' data-toggle='modal' data-target='#sendSmsQuotation' onclick='sendSMSQuotationDealer(`$row[id_data]`,`$row[id_detail]`)'>ส่ง SMS</button>
			</div>
			";
		}
	} else {
		$datas[$i]['print'] =  "<center>-</center>";
		$datas[$i]['sms'] =  "<center>-</center>";
	}

	if (empty($array_e)) {
		$datas[$i]['inform'] = "<div class='test-z'><a class='test-z1' onclick='open_inform(`$row[id_detail]`,`$row[id_data]`);' data-toggle='modal' data-target='#myinform' >แจ้งงาน</a></div>";
	} else {
		$datas[$i]['inform'] =  "<center>-</center>";
	}
	$datas[$i]['dateSort'] =  $_service->dateForSort($row['timecall']);

	$i++;
}

/******************** หากมีการส่ง sms จะเอาบันทึกมาแสดงด้วย ********************************************/
if ($resultSms->rowCount() > 0) {
	foreach ($resultSms->fetchAll() as $val) {
		$datas[$i]['date_detail'] = '<center>-</center>';
		$datas[$i]['timecall'] = $_service->thaiDate($val['sms_time']);
		$datas[$i]['pretotal'] = '<center>-</center>';
		$datas[$i]['prb'] = '<center>-</center>';
		$datas[$i]['sum_pretotal'] = '<center>-</center>';
		$datas[$i]['status'] = 'ส่ง SMS';
		$datas[$i]['inform'] = '<center>-</center>';
		$datas[$i]['add_on1'] = '<center>-</center>';
		$datas[$i]['detailtext'] = '<center>-</center>';
		$datas[$i]['date_alert'] =  '<center>-</center>';
		$datas[$i]['id_detail2'] =  '<center>-</center>';
		$datas[$i]['print'] = '<center>-</center>';
		$datas[$i]['detail_doc_type'] =  '<center>-</center>';
		$datas[$i]['renew_comp'] =  '<center>-</center>';
		$datas[$i]['detailtext'] = $_service->copylink($val['sms_text']);
		$datas[$i]['userdetail'] = $_SESSION['strUser'] != 'admin' ? 'DEALER' : $val['sms_user'];
		$datas[$i]['dateSort'] =  $_service->dateForSort($val['sms_time']);

		$i++;
	}
}

/******************** หากมีการโทร จะเอาบันทึกมาแสดงด้วย ********************************************/
if ($resultCall) {
	foreach ($resultCall as $val) {
		$datas[$i]['date_detail'] = "<center>-</center>";
		$datas[$i]['timecall'] = $_service->thaiDate($val->log_calldate);
		$datas[$i]['pretotal'] = '<center>-</center>';
		$datas[$i]['prb'] = '<center>-</center>';
		$datas[$i]['sum_pretotal'] = '<center>-</center>';
		$datas[$i]['status'] = ($val->stinout == 'out') ? 'โทรออก' : 'โทรเข้า';
		$datas[$i]['inform'] = '<center>-</center>';
		$datas[$i]['add_on1'] = '<center>-</center>';
		$datas[$i]['detailtext'] = '<center>-</center>';
		$datas[$i]['date_alert'] =  '<center>-</center>';
		$datas[$i]['id_detail2'] =  '<center>-</center>';
		$datas[$i]['print'] = '<center>-</center>';
		$datas[$i]['detail_doc_type'] =  '<center>-</center>';
		$datas[$i]['renew_comp'] =  '<center>-</center>';
		$datas[$i]['detailtext'] = "ติดต่อลูกค้าหมายเลข " . $_serviceCallPhone->hidenNumberPhone($val->log_callerid) . ' ผ่านทางโทรศัพท์';
		$datas[$i]['userdetail'] = ($val->agent_user == 'admin') ? 'ADMIN' : 'DEALER';
		$datas[$i]['dateSort'] =  $_service->dateForSort($val->log_calldate);

		$i++;
	}
}

$data['draw'] = $_GET['draw'];
$data['recordsTotal'] = $rowfull['full'];
$data['recordsFiltered'] = $rowfull['full'];
$data['data'] = $datas;
$data['textSQL'] = $txtsql;
$data['textSQLE'] = $txtsql_e;
echo json_encode($data);