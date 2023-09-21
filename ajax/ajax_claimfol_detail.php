<?php

// include "../check-ses.php"; 
include "../inc/connectdbs.pdo.php";
session_start();
// print_r($resultCall);exit;
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
		case "W":
			$renew = "ขอคิดดูก่อน/ไม่สะดวก";
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
		default: $renew = 'ไม่ระบุ';
	}
	return $renew;
}

if ($_GET['Controller'] == 'Getinfo') {
	$datas = array();
	$start = $_GET['start'];
	$end = $_GET['length'];
	$user = $_SESSION['strUser'];
	$txtsql = "SELECT * FROM `data`  INNER JOIN tb_claimfollow ON (tb_claimfollow.id_data = `data`.id_data) ";
	$txtsql .= "  WHERE tb_claimfollow.id_data='" . $_GET['DataID'] . "'";
	if ($_SESSION["strUser"] != 'admin') {
		$txtsql .= " AND tb_claimfollow.userdetail = '$user' ";
	}
	$txtsql .= " ORDER BY tb_claimfollow.timecall DESC ";

	$result = PDO_CONNECTION::fourinsure_mitsu()->query($txtsql)->fetchAll(2);
	$i = 0;
	foreach ($result as $row) {
		if ($row['datefollow'] == '') {
			$datefol = $row['datefollow'];
		} else {
			$datefol = thaiDate($row['datefollow']);
		}

		$datas[$i]['timecall'] = thaiDate($row['timecall']);
		$datas[$i]['folstatus'] = renew($row['folstatus']);
		$datas[$i]['claim_no'] = $row['claim_no']==''? 'ไม่ระบุ' :$row['claim_no'];
		$datas[$i]['detailtext'] = $row['detailtext'];
		$datas[$i]['datefollow'] =  $datefol;
		$datas[$i]['userdetail'] =  $row['userdetail'];
		$datas[$i]['date_repair'] = thaiDate2($row['date_repair']);
		$datas[$i]['informer'] = $row['informer'];
		$datas[$i]['damage'] =  $row['damage'];
		$datas[$i]['cost_estimate'] =  $row['cost_estimate'];

		$i++;
	}
	$data['draw'] = $_GET['draw'];
	$data['recordsTotal'] = $rowfull['full'];
	$data['recordsFiltered'] = $rowfull['full'];
	$data['data'] = $datas;

	echo json_encode($data);
	exit;
}

if ($_GET['Controller'] == 'GetCall') {
	$datas = array();
	$start = $_GET['start'];
	$end = $_GET['length'];

	$txtsql = "SELECT * FROM inbound_log WHERE log_system = 'MITSUBISHICLAIM' 
	AND call_iddata = '$_GET[DataID]' ORDER BY log_calldate DESC";

	$result = PDO_CONNECTION::fourinsure_insured()->query($txtsql)->fetchAll(2);
	$i = 0;
	foreach ($result as $row) {
		$datas[$i]['TimeCalll'] = thaiDate($row['log_calldate']);
		$datas[$i]['Status'] = 'โทรออก';
		$datas[$i]['TelNumber'] = substr($row['log_callerid'], 0, 3) . 'XXXX' . substr($row['log_callerid'], 7, 3);
		$datas[$i]['Detail'] = 'ติดตามอ้างอิงจากด้านบน';
		$datas[$i]['Staff'] = $row['agent_user'];
		$i++;
	}
	$data['draw'] = $_GET['draw'];
	$data['recordsTotal'] = $rowfull['full'];
	$data['recordsFiltered'] = $rowfull['full'];
	$data['data'] = $datas;

	echo json_encode($data);
	exit();
}
