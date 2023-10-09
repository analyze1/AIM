<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
if ($_SESSION["strUser"] != 'admin' && $_SESSION['claim'] != 'ADMIN') {
    $sqltext = " AND userdetail='$_SESSION[strUser]' ";
}

if ($_SESSION['log_type'] == 'TIP') {
    $condition = "data.work_type = 'TIP' AND";
} elseif ($_SESSION['log_type'] == 'AIM') {
    $condition = '';
} else {
    $condition = "data.work_type IS NULL OR data.work_type = '' AND";
}

set_time_limit(3000);

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
    return $d . "/" . $m . "/" . $Y;
}

if ($_SESSION["strUser"] != 'admin' && $_SESSION['claim'] != 'ADMIN') {
    $sqltext = " AND userdetail='$_SESSION[strUser]' ";
    $date60 = date('Y-m-d', strtotime('-180 day', strtotime(date('Y-m-d'))));
} else {
    $date60 = date('Y-m-d', strtotime('-180 day', strtotime(date('Y-m-d'))));
}

if ($_SESSION["strUser"] == "admin" || $_SESSION['claim'] == 'ADMIN') {
    $whereemp = '';
    $whereemp1 = '';
} else {
    $whereemp1 = " AND data.login='" . $_SESSION["strUser"] . "'  AND detail_renew.userdetail = '$_SESSION[strUser]' ";
}

$sqlCom = "SELECT sort,`name` FROM tb_comp  ";
$QueryCom = PDO_CONNECTION::fourinsure_insured()->query($sqlCom)->fetchAll(2);

foreach ($QueryCom as $rowCom) {
    $ResultCom[$rowCom['sort']] = $rowCom['name'];
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
            $renew = "ไม่สามารถติดต่อได้";
            break;
        case "W":
            $renew = "ขอคิดดูก่อน/ไม่สะดวก";
            break;
        case "E":
            $renew = "แจ้งงาน";
            break;
        case "O":
            $renew = "ที่อื่นถูกกว่า";
            break;
        case "N":
            $renew = "ไม่สนใจ/เบอร์ผิด";
            break;
    }
    return $renew;
}

$datas = array();
$start = $_GET['start'];
$end = $_GET['length'];

$EndYear = date('Y');
$StartYear = $EndYear - 3;
$dateN = date('Y-m-d', strtotime("+1 day"));

if ($_GET['order'][0]['column'] == 0) {
} else {
    $str = ", " . $_GET['order'][0]['column'] . " " . $_GET['order'][0]['dir'];
}

$textSQL = "SELECT
data.end_date,
detail_renew.id_data,
insuree.title,
insuree.name AS cus_name,
insuree.last,
data.n_insure,
detail_renew.status,
DATE(detail_renew.date_detail) AS date_detail
FROM
	data 
	INNER JOIN insuree ON(`data`.id_data = insuree.id_data)
	INNER JOIN detail_renew ON(`data`.id_data = detail_renew.id_data)
WHERE
$condition
detail_renew.`status` = 'S' 
AND insuree.name != ''  ";
if ($_SESSION["strUser"] != 'admin' && $_SESSION['claim'] != 'ADMIN') {
    $textSQL .= "AND data.login='" . $_SESSION["strUser"] . "' ";
}

$textSQL .= " AND detail_renew.date_detail BETWEEN  '" . $date60 . "'  and '" . $dateN . "' ";


if (!empty($_GET['search']['value'])) {
    $textSQL .= " AND (insuree.name LIKE '%" . $_GET['search']['value'] . "%'  
                OR  insuree.last LIKE '%" . $_GET['search']['value'] . "%' )  ";
}


$textSQL .= "GROUP BY detail_renew.id_data ORDER BY data.id_data DESC " . $str . " LIMIT $start,$end";
/* count num & page  */

$sqlFull = "SELECT `data`.id ";
$sqlFull .= " FROM data,insuree ";
$sqlFull .= "WHERE data.id_data  = insuree.id_data AND insuree.name!='' ";

if ($_SESSION["strUser"] != 'admin' && $_SESSION['claim'] != 'ADMIN') {
    $sqlFull .= "AND data.login='" . $_SESSION["strUser"] . "' ";
}

$sqlFull .= " AND data.end_date BETWEEN  '" . $date60 . "'  and '" . $dateN . "' ";

if (!empty($_GET['search']['value'])) {
    $sqlFull .= " AND (data.id_data LIKE '%" . $_GET['search']['value'] . "%'
OR  insuree.name LIKE '%" . $_GET['search']['value'] . "%'  
OR  insuree.last LIKE '%" . $_GET['search']['value'] . "%' )  ";
}

$sqlFull .= " ORDER BY data.end_date ASC";


/*$queryFull = PDO_CONNECTION::fourinsure_mitsu()->query($sqlFull);
$rowCount = $queryFull->rowCount();*/

/* count num & page */
$queryFulltextSQL = PDO_CONNECTION::fourinsure_mitsu()->query($textSQL);
$result = $queryFulltextSQL->fetchAll(2);
$rowCount = $queryFulltextSQL->rowCount();
$i = 0;

$_moCarArr = [];
$_moCarSubArr = [];

$moCarArr = PDO_CONNECTION::fourinsure_insured()->query("SELECT id,`name` FROM tb_mo_car")->fetchAll(5);
foreach ($moCarArr as $subCar) {
    $_moCarArr[$subCar->id] = $subCar->name;
}

foreach ($result as $row) {

    $renew_mdetail = "SELECT detail.mo_car ,detail.mo_sub,detail.car_regis,detail.car_body,detail.regis_date  
    FROM detail  WHERE id_data='" . $row['id_data'] . "' ";

    $renewDetail = PDO_CONNECTION::fourinsure_mitsu()->query($renew_mdetail)->fetch(2);

    $yearOld = number_format($EndYear - $renewDetail['regis_date']) + 1;

    if ($row_detailRenew['status'] != 'E') {
        $datas[$i]['alertBTN'] .= '<button class="btn btn-success btn-10-em" title="" rel="tooltip"   onclick="funcrenew(\'' . $row['id_data'] . '\')" data-original-title="ดูข้อมูล"><i class="icon-white icon-list"></i> ดูข้อมูล</button>';

        if ($row['status'] == 'S') {
            $datas[$i]['alertBTN'] .= "<a class='btn btn-danger ' style='width: 116px;' href='print/print_quotation_renew_vib.php?id=" . $row['id_data'] . "&st=S' target='_BLANK' id='printDeal' type='button' ><i class='icon-print icon-white' ></i>ใบเสนอราคา</a>";
        }

        $datas[$i]['alertdis'] = $row['end_date'];

        $datas[$i]['name'] = $row['id_data'] . "<br>" . '<span style="color:red;">' . $row['n_insure'] . '</span>';



        if ($row['Cus_name'] != '') {
            $poname = "( " . $row['Cus_title'] . $row['Cus_name'] . " " . $row['Cus_last'] . " )";
        } else {
            $poname = $row['title'] . " " . $row['cus_name'] . " " . $row['last'];
        }

        $datas[$i]['fullName'] = '<span style="float:left;  text-indent: 35px;">' . $poname . '</span>';

        $renew_amo_car = $_moCarArr[$renewDetail['mo_car']];

        $datas[$i]['detailMocar'] = '<span style="">' . $renew_amo_car . '</span>';
        $datas[$i]['detailtext'] = '<span style="">' . $renewDetail['car_regis'] . "<br>" . $renewDetail['car_body'] . '</span>';
        $datas[$i]['userdetail'] = $yearOld;
        $datas[$i]['dateQuotation'] = $row['date_detail'];
        $i++;
    }
}


$data['draw'] = $_GET['draw'];
$data['recordsTotal'] = $rowCount;
$data['recordsFiltered'] = $rowCount;
$data['data'] = $datas;
// $data['sql'] = $textSQL; 
echo json_encode($data);
