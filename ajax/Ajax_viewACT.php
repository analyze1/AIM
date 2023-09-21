<?php
include "../check-ses.php";
include "../inc/connectdbs.inc.php"; 


$today_date = date('Y-m-d');

function thaiDate($datetime)
{
    list($date, $time) = split(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
    list($Y, $m, $d) = split('-', $date); // แยกวันเป็น ปี เดือน วัน
    list($H, $i, $s) = split(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
    $Y = $Y + 543;
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

function DateDiff($strDate1, $strDate2)
{
    return (strtotime($strDate2) - strtotime($strDate1)) / (60 * 60 * 24);  // 1 day = 60*60*24
}


 $query2 = "SELECT ";
    $query2 .= " insuree.name As cus_name,data.id_data,data.id as chkid,detail.id_data,insuree.id_data,insuree.icard,insuree.edit_insured_time,insuree.edit_data_time,data.ty_inform,tb_type_inform.code,data.com_data,tb_comp.sort,tb_comp.name_print as cmn,tb_br_car.id,tb_br_car.name as brn,detail.br_car,tb_mo_car.id,tb_mo_car.name as mon,detail.mo_car,tb_cat_car.id,detail.cat_car,tb_user.user,data.login,detail.car_regis,insuree.title,insuree.last,data.send_date,data.start_date,data.end_date,detail.car_body,detail.n_motor,premium.id_data,premium.total_sum,premium.total_commition,protect.cost,premium.prb,detail.Cancel_policy2,detail.status_policy_time,data.doc_type,detail.id_data_company,insuree.status_sendmail_recheck ";
    $query2 .= "
    ,IF(insuree.tel_mobile3 IS NULL or insuree.tel_mobile3 = '',
        IF(insuree.tel_mobile2 IS NULL or insuree.tel_mobile2 = '',
            insuree.tel_mobile
        , insuree.tel_mobile2)
    , insuree.tel_mobile3) as xtel
    ";
    $query2 .= " FROM data ";
    $query2 .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
    $query2 .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
    $query2 .= "INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
    $query2 .= "INNER JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
    $query2 .= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
    $query2 .= "INNER JOIN premium ON (premium.id_data = data.id_data) ";
    $query2 .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
    $query2 .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
    $query2 .= "INNER JOIN  protect ON (data.id_data  =  protect.id_data) ";
    $query2 .= "INNER JOIN act ON (data.id_data  = act.id_data)";
//$query2 .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
//$query2 .= "INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
//$query2 .= "INNER JOIN tb_province ON (tb_province.id = insuree.province) ";
    $query2 .= "INNER JOIN tb_user ON (tb_user.user = data.login) ";
    //$query2 .= "WHERE YEAR(data.send_date) BETWEEN $StartYear AND $EndYear $search order by data.send_date DESC limit 0,50";
    $query2 .= " order by data.send_date DESC limit 0,5";
    mysql_select_db($db2, $cndb2);
    $objQuery = mysql_query($query2, $cndb2) or die ("Error Query tb_data2 [" . $query2 . "]");
    $countQue = mysql_num_rows($objQuery);
    $i=0;
?>

        <?php

        $totalRows = $n;
        //$totalRows = COUNT($dataall)-1;

        //for($iall=0;$iall<$totalRows;$iall++) {
        while ($row = mysql_fetch_array($objQuery)) {
            if ($row['car_id'] == "110") {
                $p_net = "645.21";
            } else if ($row['car_id'] == "320") {
                $p_net = "976.28";
            }


            $cus_title = str_replace(" ", "", $row['title']);
            $cus_cus_name = str_replace(" ", "", $row['cus_name']);
            $cus_last = str_replace(" ", "", $row['last']);
            $car_regis = str_replace(" ", "", $row['car_regis']);

            //$txt_form = "" . $row['id_data'] . "|" . $cus_title . "|" . $cus_cus_name . "|" . $cus_last . "|" . $row['br_car'] . "|" . $row['mo_car'] . "|" . $car_regis . "|" . $row['total_commition'] . "|" . $row['com_data'] . "|" . $row['doc_type'] . "";
            /////////////////////////////////////////////////////////////////////////
            $txt_form = "id=" . rawurlencode($row['id_data']);
            $txt_form .= "&title=" . rawurlencode($row['title']);
            $txt_form .= "&name=" . rawurlencode($row['cus_name']);
            $txt_form .= "&last=" . rawurlencode($row['last']);
            $txt_form .= "&brc=" . rawurlencode($row['brn']);
            $txt_form .= "&moc=" . rawurlencode($row['mon']);
            $txt_form .= "&br_car=" . rawurlencode($row['br_car']);
            $txt_form .= "&mo_car=" . rawurlencode($row['mo_car']);
            $txt_form .= "&total=" . rawurlencode($row['total_commition']);
            $txt_form .= "&com=" . rawurlencode($row['com_data']);
            $txt_form .= "&cmn=" . rawurlencode($row['cmn']);
            $txt_form .= "&doc=" . rawurlencode($row['doc_type']);
            $txt_form .= "&dcn=" . rawurlencode('ประกันภัยชั้น '.$row['doc_type']);
            $txt_form .= "&regis=" . rawurlencode($row['car_regis']);
            $txt_form .= "&chkid=" . rawurlencode($row['chkid']);
            $txt_form .= "&xtel=" . rawurlencode($row['xtel']);
            /////////////////////////////////////////////////////////////////////////
            $query_ponl = "SELECT *,date(pay_date_expire) AS date_expire From payment_online where id_data='" . $row['id_data'] . "'  ORDER BY pay_date_expire DESC LIMIT 1";
            mysql_select_db($db3, $cndb3);
            $objQuery_ponl = mysql_query($query_ponl, $cndb3) or die ("Error query_ponl cndb3 [" . $query_ponl . "]");
            $row_ponl = mysql_fetch_array($objQuery_ponl);
            $count_ponl = mysql_num_rows($objQuery_ponl);


            $df = DateDiff($today_date, $row_ponl['date_expire']);

            $str_price = str_replace(',', '', $row['total_commition']);


// บวกเดือนวันหมดอายุกรมธรรม์ 

            $Date_BeforeExpiry = date("Y-m-d", strtotime("-1 month", strtotime($row['end_date'])));

            $Date_Expiry = date("Y-m-d", strtotime("+1 month", strtotime($date)));
            ?>

  

           <?php
            $datas[$i]['print'] = "<a title='พิมพ์ใบคำขอประกันภัย' href='javascript:void(0)' onclick=\"window.open('print/Reprint_Order.php?IDDATA=".$row[id_data]."','welcome','menubar=no,status=no,scrollbars=yes')\" class=\"btn btn-success btn-small\" style=\"width:80px;\"><i class=\"icon-white icon-print\"></i>ใบรับประกัน</a>";
            $datas[$i]['send_date'] =  DateThai($row['send_date']) ; 
            $datas[$i]['car_regis'] =  $row['car_regis']; 
            $datas[$i]['id_data_comp'] =  'showcomment1';
            $datas[$i]['cus_name'] =  $row['title'] . " " . $row['cus_name'] . " " . $row['last'];
            $datas[$i]['start_date'] = $row['start_date'];
            $datas[$i]['br_car'] = $BrC['name'][$row['br_car']].'/'.$MoC['name'][$row['mo_car']];
            $datas[$i]['cost'] = $row['cost'];
            $datas[$i]['prb'] = $row['prb'];
            $datas[$i]['total_sum'] = $row['total_sum'];
            $datas[$i]['total_commition'] = $row['total_commition'];
            $datas[$i]['queryDATA'] = $query2;
            $i++;
            ?>
        <?php } ?>
        
<?php

$data['draw']=$_GET['draw'];
$data['recordsTotal']=$countQue;
$data['recordsFiltered']=$countQue;
$data['data']=$datas;
echo json_encode($data);