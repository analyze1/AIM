<?php
require ("../pages/check-ses.php");
require ("../inc/connectdbs.pdo.php");

/********************************************************* Start Service Calculate ************************************************************************************ */
class Service {
    public static function apiResolve($row) {
        if ($row['ws_prb_status'] == 'N' && $row['ws_path_policy'] == '') {
            return "<div style='text-align:center'>
						<button type='button'  style='border: 0; border-radius: 5px;' class='btn btn-small btn-info' onclick='resolveApi(`$row[id_data]`);'>API</button>
					</div>";
        } else {
            return '<div style="text-align:center">-</div>';
        }
    }
    public static function buttonPrint($row) {
        $sP_act = explode('-', $row['act_id']);
        if ($row['ws_prb_status'] == 'N') {
            return '<div style="text-align:center;">
						<a style="border: 0; border-radius: 5px;" href="#" class="btn btn-small btn-danger" >' . $row['act_id'] . '</a>
					</div>';
        } else if ($row['ws_path_policy'] != '') {  //ถ้า link api ไม่ว่างก็เอา api ไปโชว์
            return '<div style="text-align:center;">
						<a style="border: 0; border-radius: 5px;" href="' . $row['ws_path_policy'] . '" class="btn btn-small btn-info" title="พิมพ์ พ.ร.บ." target="_blank">' . $sP_act[2] . '</a>
					</div>';
        } else { //ถ้าว่างก็แสดงแบบเก่า
            return '<div style="text-align:center;">
						<a style="border: 0; border-radius: 5px;" href="javascript:void(0)" class="btn btn-small btn-info" title="พิมพ์ พ.ร.บ." onclick="window.open(\'print/print_Act_online.php?IDDATA=' . $row['id_data'] . '\',\'welcome\',\'menubar=no,status=no,scrollbars=yes\')">' . $sP_act[2] . '</a>
					</div>';
        }
    }
	public static function handleLink($payment, $dataID, $tel) {
		foreach ($payment as $data) {
            if ($data['id_data_old'] == $dataID) {
                return "<div style='text-align:center;'>-</div>";
            }
        }
		
		$_encode = base64_encode($dataID);
		$_link = _LinkPaymentViriyahCreditProd."?Customer=$_encode";
		$_function = 'handleCheckTelephone("'.$dataID.'", "'.$_link.'")';

		return "<div style='text-align:center;'>
					<button style='border: 0; border-radius: 5px;color: #000 !important;' data-toggle='modal' data-target='#paymentModal' onclick='$_function' class='btn btn-small btn-warning'><i class='fas fa-sms'></i> sms</button>
				</div>";
	}

    public static function handleCopyLink($payment, $dataID) {
		foreach ($payment as $data) {
            if ($data['id_data_old'] == $dataID) {
                return "<div style='text-align:center;'>-</div>";
            }
        }
		
		$_encode = base64_encode($dataID);
		$longBase = _LinkPaymentViriyahCreditProd."?Customer=$_encode";
        $_link = _LinkViriyahCreditOnly."?Link=".base64_encode($longBase);
        $_copyLink = 'handleCopyLink("'.$_link.'")';

		return "<div style='text-align:center;'>
                    <button style='border: 0; border-radius: 5px;color: #000 !important;' onclick='$_copyLink' class='btn btn-small btn-success'><i class='fas fa-paperclip'></i> คัดลอก</button>
				</div>";
	}

	public static function getPaymentRenewCreditViriyah() {
        $sql = "SELECT * FROM LogPaymentCreditViriyahMitsubishiRenew";
        $infoArr = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetchAll(2);
        return $infoArr;
    }

	public static function checkPayment($datas, $dataID) {
        foreach ($datas as $data) {
            if ($data['id_data_old'] == $dataID) {
                return "<div class='btn-success btn-small' style='width:20px;'><i class='fas fa-check'></i></div>";
            }
        }
        return "<div class='btn-danger btn-small' style='width:20px;'><i class='fas fa-times'></i></div>";
    }

    public static function mobileBankingBill($datas, $dataID) {
        $_function = 'window.open("print/Print_Act_Notice.php?IDDATA='.$dataID.'")';

        foreach ($datas as $data) {
            if ($data['id_data_old'] == $dataID) {
                return "<div style='text-align:center;'>-</div>";
            }
        }

        return "<div style='text-align:center'>
                    <a style='border: 0; border-radius: 5px;' href='javascript:void(0)' class='btn btn-small btn-primary' 
                        onclick='$_function'><i class='fas fa-file-pdf'></i> ใบจ่ายเงิน</a>
                </div>";
    }
}
/********************************************************* End Service Calculate *************************************************************************************** */

$id_user = $_SESSION["strUser"];
if ($id_user == 'admin') {
    $searchSQL = '';
} else {
    $newlogin = 'M' . substr($id_user,1,5);
    $searchSQL = " AND data.idagent ='$newlogin'";
}

function thaiDate($datetime) {
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

$today_date = date('Y-m-d');
$search = $_POST['search']['value'];
$search = str_replace(' ', '%', $search);
$order_by = 'order by data.send_date DESC ';

if (!empty($_POST['length'])) {
    $start = $_POST['start'];
    $length = $_POST['length'];
} else {
    $start = 0;
    $length = 60;
}

function DateDiff($strDate1, $strDate2) {
    return (strtotime($strDate2) - strtotime($strDate1)) / (60 * 60 * 24); // 1 day = 60*60*24
}

$query2 = "SELECT ";
$query2.= " insuree.name As cus_name,data.id_data,data.id as chkid,detail.id_data,insuree.id_data,insuree.icard,insuree.tel_mobile,insuree.edit_insured_time,insuree.edit_data_time,insuree.ws_prb_status, ";
$query2.= " data.ty_inform,data.com_data, act.act_id, act.ws_path_policy, act.p_net, ";
$query2.= " detail.br_car,detail.mo_car, ";
$query2.= " detail.cat_car,tb_user.user,data.login,detail.car_regis,insuree.title,insuree.last,data.send_date,data.start_date,data.end_date,detail.car_body,detail.n_motor,detail.car_id, ";
$query2.= " premium.id_data,premium.total_sum,premium.total_commition,protect.cost,premium.prb, ";
$query2.= " detail.Cancel_policy2,detail.status_policy_time,data.doc_type,detail.id_data_company,insuree.status_sendmail_recheck , ";
$query2.= " tb_type_inform.code,tb_comp.sort,tb_comp.name_print as cmn,tb_br_car.id,tb_br_car.name as brn,tb_mo_car.id,tb_mo_car.name as mon,tb_cat_car.id";
// $query2.= "
// 		,IF(insuree.tel_mobile3 IS NULL or insuree.tel_mobile3 = '',
// 			IF(insuree.tel_mobile2 IS NULL or insuree.tel_mobile2 = '',
// 				insuree.tel_mobile
// 			, insuree.tel_mobile2)
// 		, insuree.tel_mobile3) as xtel
// 		";
$query2.= " FROM data ";
$query2.= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query2.= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query2.= "INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
$query2.= "INNER JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
$query2.= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
$query2.= "INNER JOIN premium ON (premium.id_data = data.id_data) ";
$query2.= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query2.= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
$query2.= "INNER JOIN  protect ON (data.id_data  =  protect.id_data) ";
$query2.= "INNER JOIN act ON (data.id_data  = act.id_data)";
$query2.= "INNER JOIN tb_user ON (tb_user.user = data.login) ";
$query2.= "WHERE data.id_data like '%MMTS%' AND tb_mo_car.br_id = '046'";
$query2.= " AND detail.Cancel_policy2 ='' ";
$query2.= " $searchSQL ";
if (!empty($_POST['search']['value'])) {
    $query2.= " AND (data.id_data LIKE '%" . $_POST['search']['value'] . "%'
		OR  insuree.name LIKE '%" . $_POST['search']['value'] . "%'  
		OR  insuree.last LIKE '%" . $_POST['search']['value'] . "%' )  ";
}
$query2.= $order_by;
$query3 = $query2 . " LIMIT $start,$length ";
$objQuery = PDO_CONNECTION::fourinsure_insured()->query($query3);

$i = 0;
$p_net = 0;
$totalRows = $n;
$paymentViriyahArr = Service::getPaymentRenewCreditViriyah();

foreach ($objQuery as $row) {
    $datas[$i]['ACT'] = 'MMTS';
    $datas[$i]['API'] = Service::apiResolve($row);
    $datas[$i]['id_data'] = $row['id_data'];
    $datas[$i]['name'] = $row['title'] . " " . $row['cus_name'] . " " . $row['last']; //ชื่อผู้เอาประกัน
    $datas[$i]['send_date'] = thaiDate($row['send_date']); //วันแจ้งงาน
    $datas[$i]['start_date'] = thaiDate($row['start_date']);
    $datas[$i]['print_act'] = Service::buttonPrint($row);
    $datas[$i]['mo_car'] = $row['mon'];
    $datas[$i]['car_body'] = $row['car_body'];
    $datas[$i]['pre'] = "<div style='text-align:center'>$row[p_net]</div>";
    $datas[$i]['PaymentDetail'] = Service::checkPayment($paymentViriyahArr, $row['id_data']);
    $datas[$i]['pdf'] = Service::mobileBankingBill($paymentViriyahArr, $row['id_data']);
	$datas[$i]['LinkCopy'] = Service::handleCopyLink($paymentViriyahArr, $row['id_data']);
	$datas[$i]['LinkPayment'] = Service::handleLink($paymentViriyahArr, $row['id_data'], $row['tel_mobile']);
    $i++;
}

$obj2 = PDO_CONNECTION::fourinsure_insured()->query($query2);
$countQue2 = ($obj2)->rowCount();
$data['draw'] = $_POST['draw'];
$data['recordsTotal'] = $countQue2;
$data['recordsFiltered'] = $countQue2;
$data['data'] = $datas;

echo json_encode($data);
?>