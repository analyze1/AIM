<?php

include "../pages/check-ses.php";
//include "../inc/checksession.inc.php";
include "../inc/connectdbs.inc.php";
if ($_SESSION["strUser"] != 'admin' && $_SESSION['claim'] != 'ADMIN') {
    $sqltext = " AND userdetail='DEALER' ";
}

function thaiDate($datetime) {
    list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
    list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
    list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
    $Y = $Y + 543; // เปลี่ยน ค.ศ. เป็น พ.ศ.

    switch ($m) {
        case "01": $m = "01";
            break;
        case "02": $m = "02";
            break;
        case "03": $m = "03";
            break;
        case "04": $m = "04";
            break;
        case "05": $m = "05";
            break;
        case "06": $m = "06";
            break;
        case "07": $m = "07";
            break;
        case "08": $m = "08";
            break;
        case "09": $m = "09";
            break;
        case "10": $m = "10";
            break;
        case "11": $m = "11";
            break;
        case "12": $m = "12";
            break;
    }
    return $d . "/" . $m . "/" . $Y;
}

if ($_SESSION["strUser"] == "admin" || $_SESSION['claim'] == 'ADMIN') {
    $whereemp = '';
    $whereemp1 = '';
} else {
//	$whereemp = " detail_renew.userdetail='".$_SESSION["4User"]."' AND ";
//	$whereemp1 = " AND detail_renew.userdetail='".$_SESSION["4User"]."'  ";
    //$whereemp = " data.login='".$_SESSION["strName"]."' AND ";
    $whereemp1 = " AND data.login='" . $_SESSION["strUser"] . "' AND detail_renew.userdetail = 'DEALER' ";
}

mysql_select_db($db2, $cndb2);
$sqlCom = "SELECT sort,name FROM tb_comp  ";
$QueryCom = mysql_query($sqlCom, $cndb2) or die("Error Query cndb2 [Error QUERY!!!!]");
while ($rowCom = mysql_fetch_array($QueryCom)) {
    $ResultCom[$rowCom['sort']] = $rowCom['name'];
}

mysql_select_db($db1, $cndb1);

$sqlfull = "SELECT detail_renew.id_data FROM data  INNER JOIN detail_renew  on (data.id_data = detail_renew.id_data) WHERE detail_renew.status='E' $whereemp1 GROUP BY detail_renew.id_data ";
$Queryfull = mysql_query($sqlfull, $cndb1) or die("Error Query cndb2 [Error QUERY!!!!]");
$rowfull = mysql_num_rows($Queryfull);

function renew($renew) {
    switch ($renew) {
        case "R": $renew = "ติดตาม";
            break;
        case "S": $renew = "เสนอราคา";
            break;
        case "C": $renew = "แจ้งงาน";
            break;
        case "A": $renew = "ไม่สามารถติดต่อได้";
            break;
        case "W": $renew = "ขอคิดดูก่อน/ไม่สะดวก";
            break;
        case "E": $renew = "แจ้งงาน";
            break;
        case "O": $renew = "ที่อื่นถูกกว่า";
            break;
        case "N": $renew = "ไม่สนใจ/เบอร์ผิด";
            break;
    }
    return $renew;
}

$datas = array();
$start = $_GET['start'];
$end = $_GET['length'];

if ($_GET['order'][0]['column'] == 0) {

//echo $txtsql;
} else if ($_GET['order'][0]['column'] == 1) {
    
} else {
    $str = " ORDER BY ".$_GET['order'][0]['column'] . " " . $_GET['order'][0]['dir'];
}

mysql_select_db($db1, $cndb1);

$txtsql = "SELECT data.id_data,data.login,insuree.id_data,insuree.title,insuree.name,insuree.last,data.costCost,data.end_date, detail_renew.id_data,detail_renew.status,detail_renew.userdetail,detail_renew.detailtext,detail_renew.date_alert,detail_renew.detailcost ";
$txtsql .= " FROM data,insuree,detail_renew ";
$txtsql .= " WHERE data.id_data = insuree.id_data AND data.id_data = detail_renew.id_data AND  detail_renew.status='E'  ";
$txtsql .= " $whereemp1    ";

if (!empty($_GET['search']['value'])) {
    $txtsql .= " AND (data.id_data LIKE '%" . $_GET['search']['value'] . "%' OR  insuree.name LIKE '%" . $_GET['search']['value'] . "%'  OR  insuree.last LIKE '%" . $_GET['search']['value'] . "%' )  ";
}
$txtsql .= " GROUP BY data.id_data " . $str . "  LIMIT  $start,$end ";
//echo $txtsql;
//insuree.".$_GET['columns'][$_GET['order'][0]['column']]['data']." ".$_GET['order'][0]['dir']."
$result = mysql_query($txtsql, $cndb1) or die("Error Query cndb1 [ $txtsql ]");

$i = 0;

while ($row = mysql_fetch_array($result)) {
    
     mysql_select_db($db1, $cndb1);
    $renew_smocar = "SELECT id,id_data,mo_car,mo_sub,price_total,car_body FROM detail  WHERE id_data='" . $row['id_data'] . "' ";
    $renew_qmocar = mysql_query($renew_smocar, $cndb1);
    $renew_amocar = mysql_fetch_array($renew_qmocar);

    mysql_select_db($db2, $cndb2);
    //$sqlc = "SELECT id_data FROM detail WHERE car_body = '".$row['car_body']."'";

    $carBodySub = str_replace('(ยกเลิก)','',str_replace(' ','',$renew_amocar['car_body']));
    
    $sqlc = "SELECT detail.id,detail.id_data,detail.car_body,mo_car FROM detail,insuree WHERE  insuree.id_data = detail.id_data AND detail.car_body = '$carBodySub' AND insuree.status_company = 'Y' order by detail.id desc limit 1";
    $x[] = $sqlc;
    $qc = mysql_query($sqlc, $cndb2) or die("Error Query cndb2 [Error QUERY!!!!]");
    $rowc = mysql_fetch_array($qc);

    $cost_renew = explode('|', $row['detailcost']);

    //  check ค่า เลขรับแจ้งของฝั่ง policy กับ suzuki
    $id_data_my4ib = explode("/", $row['id_data']);
    $id_data_four = explode("/", $rowc['id_data']);

    mysql_select_db($db1, $cndb1);
    $renew_ctm = "SELECT id,user FROM tb_customer  WHERE user='" . $row['login'] . "' ";
    $renew_qctm = mysql_query($renew_ctm, $cndb1);
    $renew_actm = mysql_fetch_array($renew_qctm);
    //echo $renew_ctm;
    $renew_req = "SELECT id,id_data,EditProduct,TotalProduct FROM req  WHERE id_data='" . $row['id_data'] . "' ";
    $renew_qreq = mysql_query($renew_req, $cndb1);
    $renew_areq = mysql_fetch_array($renew_qreq);
//    echo "req : ".$renew_req;
    $renew_protect = "SELECT id,id_data FROM protect  WHERE id_data='" . $row['id_data'] . "' ";
    $renew_qprotect = mysql_query($renew_protect, $cndb1);
    $renew_aprotect = mysql_fetch_array($renew_qprotect);

//    echo $renew_protect;
//    $renew_detren = "SELECT detail_renew.id_data,detail_renew.status,detail_renew.userdetail,detail_renew.detailtext,detail_renew.date_alert FROM detail_renew  WHERE detail_renew.id_data='" . $row['id_data'] . "' ";
//    $renew_qdetren = mysql_query($renew_detren, $cndb1);
//    $renew_adetren = mysql_fetch_array($renew_qdetren);
//    echo $renew_detren;    
    //echo $rst_dtv; 


    if ($rowc['id_data'] != '') 
    {

        if ($id_data_my4ib[0] < $id_data_four[0]) 
        {

            $datas[$i]['alertdis'] = "<a title='พิมพ์ใบคำขอประกันภัย' href='javascript:void(0)' onclick=\"window.open('print/Reprint_Order.php?IDDATA=" . $rowc['id_data'] . "','welcome','menubar=no,status=no,scrollbars=yes')\" class=\"btn btn-success btn-small\" style=\"width:100px; margin:10px 0px;\"><i class=\"icon-white icon-print\"></i>ใบรับประกัน</a>";
        } 
        else 
        {
            $datas[$i]['alertdis'] = "<div class='btn-success btn-small'  title='ใบรับประกัน' rel='tooltip' id='printsd'><i class='icon-white icon-print'></i> ใบรับประกัน</div>";
            $datas[$i]['alertdis'] = "<a title='ใบเสนอราคา' href='javascript:void(0)' onclick=\"window.open('print/print_AlertClosejob.php?id=" . $row['id_data'] . "','welcome','menubar=no,status=no,scrollbars=yes')\" style=\"border:none;\" class=\"btn btn-success \" ><i class=\"icon-white icon-print\"></i>เสนอราคา</a>";
        }

        $datas[$i]['alertBTN'] = "<div class='btn-success btn-small' style='width:100px;float:left;heigth:32px;margin:10px;padding:5px 10px;' title='ยืนยันรับประกัน' rel='tooltip' id='prints' ><i class='icon-white icon-check'></i>ยืนยันรับประกัน</div>";
    } 
    else 
    {
        $datas[$i]['alertBTN'] = "<div class='btn-warning btn-small' style='width:100px;float:left;heigth:32px;margin:10px;padding:5px 10px;' title='รออนุมัติ' rel='tooltip' id='prints' ><i class='icon-white icon-time'></i>รออนุมัติ...</div>";
        //$datas[$i]['alertdis'] = 'แจ้งแล้ว';
        $datas[$i]['alertdis'] = "<a title='ใบคำขอ' href='javascript:void(0)' onclick=\"window.open('print/print_waitConfirm.php?IDDATA=" . $row['id_data'] . "','welcome','menubar=no,status=no,scrollbars=yes')\" class=\"btn  btn-small\"  style=\"background-color:#222 !important;color:#fff;border:none !important;width:114px;float:left; margin:10px 0px;padding:5px 5px;\"><i class=\"icon-white icon-print\"></i>ใบคำขอ</a>";
    }


    mysql_select_db($db1, $cndb1);
    $renew_sql = "SELECT id_data,pages FROM detail_renew WHERE id_data = '" . $row['id_data'] . "' AND pages != '' " . $sqltext . " ORDER BY pages DESC LIMIT 0,1";
    $renew_query = mysql_query($renew_sql, $cndb1);
    $renew_array = mysql_fetch_array($renew_query);
    if (!empty($renew_array)) {
        $datas[$i]['alertdis'] .= "<a class='btn btn-info btn-small' href='print/quotation_renew.php?id_data=" . $row['id_data'] . "&pages=" . $renew_array['pages'] . "' target='_blank' title='ดูใบเสนอราคา' style=' padding: 1px;  margin:10px 0px;    width: 100px;'  rel='tooltip' ><i class='icon-white icon-print'></i> ดูข้อมูลเสนอราคา</a>";
    }
    $datas[$i]['alertdis'] .= '<a class="btn btn-success btn-small" title="" rel="tooltip"   onclick="funcrenew(\''.$row['id_data'].'\')" data-original-title="ดูข้อมูล" style=" padding: 1px;  margin:10px 10px;    width: 100px;"><i class="icon-white icon-list"></i> ดูข้อมูล</a>';


    $datas[$i]['date_alert'] = '<div style="text-indent: 10px; vertical-align: middle;">'.thaiDate($row['date_alert']).'</div>';
    $datas[$i]['name'] = '<div style="text-indent: 10px; vertical-align: middle;">'.$row['title'] . ' ' . $row['name'] . ' ' . $row['last'].'</div>';

    mysql_select_db($db1, $cndb1);
    if ($renew_amocar['mo_sub'] != '') {
        //echo $rowc['mo_sub'];
        $renew_mo_car = "SELECT id,name FROM tb_mo_car_sub  WHERE id='" . $renew_amocar['mo_sub'] . "' ";
        $renew_qmo_car = mysql_query($renew_mo_car, $cndb1);
        $renew_amo_car = mysql_fetch_array($renew_qmo_car);
    } else {
        //echo "no mocar";
        $renew_mo_car = "SELECT id,name FROM tb_mo_car  WHERE  id='" . $renew_amocar['mo_car'] . "' ";
        $renew_qmo_car = mysql_query($renew_mo_car, $cndb1);
        $renew_amo_car = mysql_fetch_array($renew_qmo_car);
    }
    //echo $renew_mo_car;
    $datas[$i]['mo_car'] = '<div style="text-indent: 10px; vertical-align: middle;">'.$renew_amo_car['name'].'</div>';


    mysql_select_db($db1, $cndb1);
    $renew_tcost = "SELECT tb_cost.id,tb_cost.cost,data.costCost,id_data FROM tb_cost,data  WHERE  tb_cost.id=data.costCost   AND  tb_cost.id='" . $row['costCost'] . "' AND data.id_data = '" . $row['id_data'] . "'   ";
    $renew_qcost = mysql_query($renew_tcost, $cndb1);
    $renew_acost = mysql_fetch_array($renew_qcost);


    $costW = explode(",", substr($renew_acost['cost'], 0, 7));
    $CalculaCost = $costW[0] . $costW[1];
    /*
      if($CalculaCost>370000)
      {
      $ResultCost = $CalculaCost*95/100-10000;
      }
      else if($CalculaCost<=370000)
      {
      $ResultCost = $CalculaCost*90/100;
      }

      $Cost_NEW = ceil($ResultCost/10000)*10000+$row['price_total'];
      //////////////////////////////////////////
      $costselect = explode("|",$row['detailcost']);
     */



// เธ�เธงเธ� เธ•เธ�เน�เธ•เน�เธ�เน€เธ�เธดเน�เธกเน€เธ•เธดเธก
    if ($renew_areq['EditProduct'] == 'Y') {
        //echo "Y";
        $Cost_NEW = ($CalculaCost + $renew_areq['TotalProduct']) - 30000;
        $add_price_old = $renew_areq['TotalProduct'];
    } else {
        //echo "no data";
        $Cost_NEW = ($CalculaCost + $renew_amocar['price_total']) - 30000;
        $add_price_old = $renew_amocar['price_total'];
    }
    $datas[$i]['detailcost'] = '<div style="text-indent: 10px; vertical-align: middle;">'.number_format($Cost_NEW).'</div>';

    if ($row['detailtext'] == "") {
        $detailtexts = "-";
    } else {
        $detailtexts = $row['detailtext'];
    }
    
    
    $datas[$i]['detailtext'] = '<div style="color:red; text-indent: 10px; vertical-align: middle;">' . $detailtexts . '</div>';
    $datas[$i]['userdetail'] = '<div style="text-indent: 10px; vertical-align: middle;">'.$row['userdetail'].'</div>';
    $i++;
}
$data['draw'] = $_GET['draw'];
$data['recordsTotal'] = $rowfull;
$data['recordsFiltered'] = $rowfull;
$data['data'] = $datas;
$data['rowc'] = $x;

echo json_encode($data);
mysql_close();
?>