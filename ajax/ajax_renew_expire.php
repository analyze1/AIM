<?php 
include "../check-ses.php"; 
//include "../inc/checksession.inc.php";
include "../inc/connectdbs.inc.php"; 
include "../inc/function.php";
include "../inc/session_car.php";

$costOb = $_SESSION["Cost"];
$costObname = $_SESSION["CostName"];
$TbCost = $_SESSION["TbCost"];
$MoC = $_SESSION["MoC"];
$BrC = $_SESSION["BrC"]; 
        
function dateChkdiff($str_start, $str_end) {
    $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
    $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
    $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
    $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที
    return $ndays;
}

function fncRenewDetail($db1,$cndb1,$iddata) {
    $query_detailRenew = "SELECT status FROM detail_renew WHERE detail_renew.id_data ='" . $iddata . "' order by id_detail desc limit 1 ";
    mysql_select_db($db1, $cndb1);
    $objQuery_detailRenew = mysql_query($query_detailRenew, $cndb1);
    $row_detailRenew = mysql_fetch_array($objQuery_detailRenew);
    return $row_detailRenew['status'];
}

function renewExpire($db1,$cndb1){
    $EndYear = date('Y');
    $StartYear = $EndYear-3;
    $dateN = date('Y-m-d');  
    $date60 =  date('Y-m-d', strtotime('+60 day', strtotime( date('Y-m-d') )));
    $query = "SELECT ";
    $query .= " insuree.name As cus_name,data.id_data,detail.id_data,insuree.id_data,data.com_data,data.n_insure,detail.br_car,detail.mo_car,detail.add_price,detail.cat_car,data.login,detail.car_regis,insuree.title,insuree.last,data.send_date,data.start_date,data.end_date,detail.car_body,detail.n_motor,data.costCost,detail.car_id,data.p_act, req.CostProduct, req.Cus_title, req.Cus_name, req.Cus_last, req.EditAct_id, req.Edit_CarBody, req.CostProduct, tb_customer.saka ";
    $query .= " FROM data ";
    $query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
    $query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
    $query .= "INNER JOIN tb_customer ON (data.login  = tb_customer.user) ";
    $query .= "INNER JOIN req ON (data.id_data  = req.id_data) ";
    $query .= "WHERE insuree.name!='' ";
    if($_SESSION["strUser"]!='admin'){
    $query .= "AND data.login='".$_SESSION["strUser"]."' ";
    }
    $query .= " AND data.end_date between  '".$dateN."'  and '".$date60."' ";
    $query .= " order by data.end_date ASC ";
    mysql_select_db($db1,$cndb1);
    $objQuery = mysql_query($query,$cndb1) or die ("Error Query tb_data [".$query."]");
    $arrExp = array();
    while ($row = mysql_fetch_array($objQuery)) {
        $dfcount = '';
        $dfcount = dateChkdiff($dateN, $row['end_date']);
        $valStatus = fncRenewDetail($db1,$cndb1,$row['id_data']);
        $arrExp[] = array(
            'id_data'=>$row['id_data'],
            'com_data'=>$row['com_data'],
            'end_date'=>$row['end_date'],
            'n_insure'=>$row['n_insure'],
            'saka'=>$row['saka'],
            'title'=>$row['title'],
            'cus_name'=>$row['cus_name'],
            'last'=>$row['last'],
            'cus_title'=>$row['cus_title'],
            'cus_last'=>$row['cus_last'],
            'start_date'=>$row['start_date'],
            'end_date'=>$row['end_date'],
            'mo_car'=>$row['mo_car'],
            'car_body'=>$row['car_body'],
            'Edit_CarBody'=>$row['Edit_CarBody'],
            'costCost'=>$row['costCost'],
            'cost'=>$row['cost'],
            'p_act'=>$row['p_act'],
            'EditAct_id'=>$row['EditAct_id'],
            'status'=>$valStatus,
            'dfcount'=>$dfcount
            
        );
    }
    
    return array('arrData'=>$arrExp);
}

$expireDT = renewExpire($db1,$cndb1);
$arrData = $expireDT['arrData'];


foreach ($arrData as $row) {

        $datas[$i]['data1'] = '<input id="OQ"  type="hidden" readonly="" name="OQ" value="' . $row[id_data] . '"><div class="span12" style="width:350px;"><a class="span4 btn btn-success btn-small" title="" rel="tooltip" onclick="$(\'#page-content\').load(\'pages/renew_suzuki_select.php?id=' . $row[id_data] . '\');" data-original-title="ดูข้อมูล"><i class="icon-white icon-list"></i> ดูข้อมูล</a>';
    if ($row[status] == "S") {
        $datas[$i]['data1'] = '<a class="span4 btn btn-danger btn-small" onclick=\'window.open("print/print_Quotation.php?id=' . $row[id_data] . '", "", "width=1000, height=900");\' id="printDeal" type="button" ><i class="icon-print icon-white" ></i>ใบเสนอราคา</a>';
    }
    if (!empty($row['status'])) {
        $datas[$i]['data1'] = '<a class="span4 btn btn-info btn-small"  data-toggle="modal" href="pages/viewSendRenew.php?IDDATA=' . $row[id_data] . '" aria-hidden="true"   data-target="#modal"><i class="icon-check icon-white" ></i>แจ้งต่ออายุ</a>';
    }
    $datas[$i]['data1'] = '</div>';
    $datas[$i]['data2'] = $row['dfcount'];
    $datas[$i]['data3'] = $row['id_data'] . "</br><font color=\"#FF0000\">" . $row['n_insure'] . "</font>";

    $datas[$i]['data4'] = $row['title'] . " " . $row['cus_name'] . " " . $row['last'] . "</br>";
    if ($row['cus_name'] != '') {
        $datas[$i]['data4'] = "( " . $row['cus_title'] . $row['cus_name'] . " " . $row['cus_last'] . " )";
    }
    $datas[$i]['data5'] = DateThai($row['end_date']);
    $datas[$i]['data6'] = $MoC['name'][$row['mo_car']];
    $datas[$i]['data7'] = $row['car_body'];
    if ($row['Edit_CarBody'] != '') {
        $datas[$i]['data7'] = '<font color="#FF0000">' . $row['Edit_CarBody'] . '</font>';
    }
    $datas[$i]['data8'] = $TbCost['cost'][$row['costCost']] . $row['cost'];
    $datas[$i]['data9'] = substr($row['p_act'], 12, 7) . "</br>";
    if ($row['EditAct_id'] != '') {
        $datas[$i]['data9'] = '<font color="#FF0000">' . substr($row['EditAct_id'], 12, 7) . '</font>';
    }

    $i++;
}
$data['draw']=$_GET['draw'];
$data['recordsTotal']=$rowfull;
$data['recordsFiltered']=$rowfull;
$data['data']=$datas;

echo json_encode($data);
mysql_close();
?>