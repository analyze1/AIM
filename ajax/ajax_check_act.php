<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
$user = $_SESSION["strUser"];
$act_no = $_POST['act_no'];
if ($act_no == 'SmartOn') //SmartOn คือ KeyWord ว่าจะใช้ระบบ ออนไลน์ เท่านั้น Service jump การเช็คเลข พ.ร.บ ไปเลย
{
    goto SendOnline;
}

$message = array();

$_contextMitsu = PDO_CONNECTION::fourinsure_mitsu();
$_dateY = date('Y');

$query_act = "SELECT * FROM z_act WHERE act_status = '2' AND act_return = '' AND act_no = '$act_no' AND act_year = '$_dateY'";
$objQuery_act = $_contextMitsu->query($query_act);
$row_act = $objQuery_act->fetch();

$message['debug'] = 'passquery' . $row_act;

if ($row_act['act_no'] != null && $row_act['act_no'] != '9999999') {
    $query_useact = "SELECT * FROM z_act WHERE act_use = '$user' AND act_status = '1' AND act_return = '' ORDER BY act_id ASC limit 1";
    $row_useact = $_contextMitsu->query($query_useact)->fetch();

    if ($user != 'admin' && !empty($row_useact['act_no'])) {

        $status = 'Y';
        $alert_act = "เลขที่ พ.ร.บ. " . $row_act['act_no'] . " นี้ถูกใช้แล้วครับ เลขที่ พ.ร.บ.ใหม่คือ " . $row_useact['act_no'] . "\nรบกวนกดแจ้งประกันภัยใหม่ด้วยครับ";
        $act_no_ja = $row_useact['act_no'];
    } else {

        $status = 'Y';
        $alert_act = "เลขที่ พ.ร.บ. " . $row_act['act_no'] . " นี้ถูกใช้แล้วครับ รบกวนคีย์เลขใหม่ด้วยครับ";
        $act_no_ja = '';
    }
} else {

    SendOnline:
    $status = 'N';
    $alert_act = "";
    $act_no_ja = $act_no;
}

$message['status'] = $status;
$message['alert_act'] = $alert_act;
$message['act_no_ja'] = $act_no_ja;
echo json_encode($message);
