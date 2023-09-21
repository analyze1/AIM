<?php
include "../inc/connectdbs.pdo.php";
session_start();
class RenewViewInstance
{
    private $_context4;
    private $_contextMitsu;

    public function __construct($con4, $consu)
    {
        $this->_context4 = $con4;
        $this->_contextMitsu = $consu;
    }

    public function getInformationMitsu($id)
    {
        $query = "SELECT
            detail.car_color,
            `data`.n_insure,
            `data`.com_data,
            `data`.doc_type,
            `data`.id_data AS idselect,
            `data`.`login`,
            `data`.start_date,
            `data`.end_date,
            insuree.*,
            detail_renew.*,
            detail.br_car,
            detail.mo_car,
            detail.mo_sub,
            `data`.end_date,
            detail.car_regis,
            detail.car_regis_pro,
            detail.regis_date,
            detail.car_id,
            detail.car_body,
            detail.n_motor,
            detail.price_total,
            req.EditTime,
            req.EditTime_StartDate,
            req.EditTime_EndDate,
            req.EditProduct,
            req.TotalProduct,
            `data`.name_inform,
            req.CostProduct,
            detail.add_price,
            detail_renew.detailcost 
        FROM
        `data` 
            INNER JOIN detail ON(`data`.id_data = detail.id_data)
            INNER JOIN insuree ON(`data`.id_data = insuree.id_data)
            INNER JOIN req ON(`data`.id_data = req.id_data)
            INNER JOIN detail_renew ON(`data`.id_data = detail_renew.id_data)
        WHERE
            `data`.id_data = '$id' 
        ORDER BY
            `data`.id_data DESC 
            LIMIT 0,1";
        // return $query;
        return $this->_contextMitsu->query($query)->fetch(2);
    }

    public function getInformationFourinsure($row) //array
    {
        $sql = "SELECT
                insuree.id_data AS InsureeID,
                insuree.`title`,
                insuree.`name`,
                insuree.last,
                insuree.tel_mobile,
                `data`.com_data,
                `data`.id_data AS DataID,
                `data`.send_date,
                `data`.`start_date`,
                `data`.end_date,
                `data`.name_gain,
                `data`.`service`,
                `data`.idagent,
                `data`.namegroup,
                detail.id_data_company,
                detail.company_date,
                detail.br_car,
                detail.mo_car,
                detail.car_body,
                detail.n_motor,
                detail.car_regis,
                detail.car_regis_pro,
                detail.car_color,
                detail.regis_date,
                protect.cost
            FROM
                insuree
                INNER JOIN `data` ON ( insuree.id_data = `data`.id_data )
                INNER JOIN detail ON ( insuree.id_data = detail.id_data ) 
                INNER JOIN protect ON ( insuree.id_data = protect.id_data ) 
            WHERE
                insuree.`name` = '$row[name]' 
                AND insuree.last = '$row[last]'
                AND detail.car_body = '$row[car_body]'
                AND detail.n_motor = '$row[n_motor]'
                AND detail.cencel_check != 'Y'
            ";
        return $this->_context4->query($sql)->fetch(2);
    }

    public function thaiDate($datetime)
    {
        list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
        list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
        //list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที

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

        return "$d/$m/$Y";
    }

    public function getProvince($id)
    {
        $sql = "SELECT `name` FROM tb_province WHERE id = '$id'";
        $result = $this->_context4->query($sql)->fetch(5)->name;
        return !empty($result) ? $result : '-';
    }

    public function getTumbon($id)
    {
        $sql = "SELECT `name` FROM tb_tumbon WHERE id = '$id'";
        $result = $this->_context4->query($sql)->fetch(5)->name;
        return !empty($result) ? $result : '-';
    }

    public function getAmphar($id)
    {
        $sql = "SELECT `name` FROM tb_amphur WHERE id = '$id'";
        $result = $this->_context4->query($sql)->fetch(5)->name;
        return !empty($result) ? $result : '-';
    }

    public function convertAddress($row)
    {

        if ($row['group'] != "-" && $row['group'] != "") {
            $address_pdf = " หมู่" . $row['group'];
        }
        if ($row['town'] != "-" && $row['town'] != "") {
            $address_pdf .= " " . $row['town'];
        }
        if ($row['lane'] != "-" && $row['lane'] != "") {
            $address_pdf .= " ซอย" . $row['lane'];
        }
        if ($row['road'] != "-" && $row['road'] != "") {
            $address_pdf .= " ถนน" . $row['road'];
        }

        if ($row['province'] != "102") {
            $address_pdf2 = 'ต.' . $this->getTumbon($row['tumbon']) .
                ' อ.' . $this->getAmphar($row['amphur']) .
                ' จ.' . $this->getProvince($row['province']) .
                ' ' . $row['postal'];
        } else {
            $address_pdf2 = 'แขวง' .
                $this->getTumbon($row['tumbon']) .
                ' เขต' . $this->getAmphar($row['amphur']) .
                ' ' .
                $this->getProvince($row['province']) .
                ' ' . $row['postal'];
        }
        return [$address_pdf, $address_pdf2];
    }

    public function getnameBran($id)
    {
        $str = "SELECT `name` FROM tb_br_car WHERE id = '$id'";
        return $this->_context4->query($str)->fetch(5)->name;
    }

    public function getnameMocar($id)
    {
        $str = "SELECT `name` FROM tb_mo_car WHERE id = '$id'";
        return $this->_context4->query($str)->fetch(5)->name;
    }

    public function getnameProvinceCar($id)
    {
        $str = "SELECT `name` FROM tb_province  WHERE  id = '$id'";
        return $this->_context4->query($str)->fetch(5)->name;
    }

    public function concatName($t, $n, $l, $p)
    {
        if ($p == 2) {
            return "$t $n $l";
        } else {
            return "$t$n $l";
        }
    }
}

$_instanceSer = new RenewViewInstance(
    PDO_CONNECTION::fourinsure_insured(),
    PDO_CONNECTION::fourinsure_mitsu()
);

$row = $_instanceSer->getInformationMitsu($_GET['id']);

if ($row == null) {
    echo 'ไม่พบข้อมูลลูกค้าท่านนี้ กรุณาติดต่อฝ่ายเทคนิค';
    exit;
}
/******* Renew Work ถ้ามีการต่ออายุข้อมูลบางส่วนจะใช้งานส่วนนี้ *********************************/

$result = $_instanceSer->getInformationFourinsure($row);

if (!empty($result)) //result main
{
    $_resultDatas = new stdClass();
    $_resultDatas->login = $row['login'];
    $_resultDatas->nameInform = $row['name_inform'];
    $adr = $_instanceSer->convertAddress($row);
    $_resultDatas->address = "{$row['add']} {$adr[0]} {$adr[1]}";
    $_resultDatas->insureID = $result['InsureeID'];
    $_resultDatas->insuranceNumber = $result['id_data_company'] != '' ? $result['id_data_company'] : '-';
    $_resultDatas->bran = $_instanceSer->getnameBran($result['br_car']);
    $_resultDatas->mocar = $_instanceSer->getnameMocar($result['mo_car']);
    $_resultDatas->color = $result['color'] != '' ? $result['color'] : '-';
    $_resultDatas->nameFull = $_instanceSer->concatName($result['title'], $result['name'], $result['last'], $result['person']);
    $_resultDatas->carBody = $result['car_body'];
    $_resultDatas->nMotor = $result['n_motor'];
    $_resultDatas->regis = $result['car_regis'];
    $_resultDatas->startDate = $_instanceSer->thaiDate($row['start_date']);
    $_resultDatas->endDate = $_instanceSer->thaiDate($row['end_date']);
    $_resultDatas->provinceName = $_instanceSer->getnameProvinceCar($result['car_regis_pro']);
    $_resultDatas->YearCar = $result['regis_date'];
    $_resultDatas->carOld = date('Y') - $result['regis_date'] + 1;
    $_resultDatas->userType = $_SESSION['strUser'];
    $_resultDatas->mocarID = $result['mo_car'];
} else //row main
{
    $_resultDatas = new stdClass();
    $_resultDatas->login = $row['login'];
    $_resultDatas->nameInform = $row['name_inform'];
    $adr = $_instanceSer->convertAddress($row);
    $_resultDatas->address = "{$row['add']} {$adr[0]} {$adr[1]}";
    $_resultDatas->insureID = $row['idselect'];
    $_resultDatas->insuranceNumber = $row['n_insure'] != '' ? $row['n_insure'] : '-';
    $_resultDatas->bran = $_instanceSer->getnameBran($row['br_car']);
    $_resultDatas->mocar = $_instanceSer->getnameMocar($row['mo_car']);
    $_resultDatas->color = $row['color'] != '' ? $row['color'] : '-';
    $_resultDatas->nameFull = $_instanceSer->concatName($row['title'], $row['name'], $row['last'], $row['person']);
    $_resultDatas->carBody = $row['car_body'];
    $_resultDatas->nMotor = $row['n_motor'];
    $_resultDatas->regis = $row['car_regis'];
    $_resultDatas->startDate = $_instanceSer->thaiDate($row['start_date']);
    $_resultDatas->endDate = $_instanceSer->thaiDate($row['end_date']);
    $_resultDatas->provinceName = $_instanceSer->getnameProvinceCar($row['car_regis_pro']);
    $_resultDatas->YearCar = $row['regis_date'];
    $_resultDatas->carOld = date('Y') - $row['regis_date'] + 1;
    $_resultDatas->userType = $_SESSION['strUser'];
    $_resultDatas->mocarID = $row['mo_car'];
}

$txt_form = '' . $row['idselect'] . "|" . $row['title'] . "|" . $row['name'] . "|" . $row['last'] . "|" . $row['br_car'] . "|" . $row['mo_car'] . "|" . $row['car_regis'] . "|" . $row['com_data'] . "|" . str_replace('ประกันภัยรถยนต์ประเภท ', '', $row['doc_type']) . "|" . $row['tel_mobi'];

// $cus_title = str_replace(" ", "", $row['title']);
// $cus_cus_name = str_replace(" ", "", $row['cus_name']);
// $cus_last = str_replace(" ", "", $row['last']);
// $car_regis = str_replace(" ", "", $row['car_regis']);



// เช็ค Loss Claim
$claim_amount = $row['claim_amount'] == '' ? 0 : $row['claim_amount']; // ยอดเคลมผิด
$prechk_loss = $row['prechk_loss'] == '' ? 0 : $row['prechk_loss']; //สุทธิสำหรับคิด Loss

if ($prechk_loss != '0.00') {
    $chkpre = $prechk_loss;
} else {
    $chkpre = $total_pre;
}

$useLoss = $chkpre == '' ? 0 : $claim_amount * 100 / $chkpre;
$claim_po = $row['policy_amount'] == '' ? 0 : $row['policy_amount']; // จำนวนครั้งเคลม
$session = session_id();
$time = time();
$time_check = $time - 600;

$queryOnline = "SELECT * FROM tb_renew_online Where onl_session='$session' ";

$resultOnline = PDO_CONNECTION::fourinsure_mitsu()->query($queryOnline);
$rowc = $resultOnline->fetch();

$strSQL1 = "UPDATE `data` SET renewuse = '' WHERE renewuse = '1' AND `data`.id_data = '$rowc[onl_emp]'";
PDO_CONNECTION::fourinsure_mitsu()->prepare($strSQL1)->execute();

$strSQL1 = "UPDATE `data` SET renewuse = '1' WHERE renewuse = '' AND `data`.id_data = '$row[idselect]'";
PDO_CONNECTION::fourinsure_mitsu()->prepare($strSQL1)->execute();

if ($rowc == null) {
    $strSQL1 = "INSERT INTO tb_renew_online (onl_emp, onl_session, onl_time) VALUES ('$row[idselect]','$session', '$time')";
    PDO_CONNECTION::fourinsure_mitsu()->prepare($strSQL1)->execute();
} else {
    $strSQL2 = "UPDATE tb_renew_online SET onl_emp = '$row[idselect]', onl_time = '$time' WHERE onl_session = '$session'";
    PDO_CONNECTION::fourinsure_mitsu()->prepare($strSQL2)->execute();
}

$strSQL_del = "DELETE FROM tb_renew_online WHERE onl_time < $time_check";
PDO_CONNECTION::fourinsure_mitsu()->prepare($strSQL_del)->execute();

/********************************* คำนวนทุนต่ออายุ ********************************************************************************/
$costW = explode(",", substr($row['cost'], 0, 7));
$CalculaCost = (int)($costW[0] . $costW[1]);

/****************************************** + ตกแต่งเพิ่ม ***************************************************************************/
$priceTotal = (int)$row['price_total'];

if ($row['EditProduct'] == 'Y') {

    $Cost_NEW = round((($CalculaCost + $priceTotal) * 0.90), -4);
    $add_price_old = $row['TotalProduct'];
} else {

    $Cost_NEW = round((($CalculaCost + $priceTotal) * 0.90), -4);
    $add_price_old = $priceTotal;
}

$CalculaCost = $Cost_NEW;

$costselect = explode("|", $row['detailcost']);

// 03/06/2021 กรณีไม่มี อุปกรณตกแต่ง ให้ใช้ทุนจากใบเตือน ตาราง detail_renew ฟิลด์ status F

//   หาทุนใหม่

//TODO หารหัสรุ่นย่อย

$sql_model_sub = "SELECT IdModelSub_four FROM log_imported_data WHERE IdData = '{$_GET['id']}'";

$res_model_sub = PDO_CONNECTION::fourinsure_mitsu()->query($sql_model_sub)->fetch(7);

if(!$res_model_sub)
{
	//TODO หารหัสรุ่นย่อย จากเลขตัวถัง
	$car_body_code = substr($row['car_body'],0,9);
	$sql_model_sub = "SELECT idCarModelSub FROM ModelCarMitsubishi WHERE carBodyFormat LIKE '%$car_body_code%'";
    
	$res_model_sub = PDO_CONNECTION::fourinsure_insured()->query($sql_model_sub)->fetch(7);
}

if(empty($res_model_sub))//$row['mo_car']
{
    $sql = "SELECT mocar_price FROM tb_mo_car WHERE id='$row[mo_car]'";
    $price_car = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetch(7);
}
else
{
    //TODO หาราคารถ จากรหัสรุ่นย่อย
    $sql_car_model_sub = "SELECT price_car FROM tb_car_model_sub WHERE id = '$res_model_sub'";

    $price_car = PDO_CONNECTION::fourinsure_insured()->query($sql_car_model_sub)->fetch(7);
}

$sql_xxx = "SELECT
				gc.fixcost,
				gc.fixcostend
			FROM
				tb_mocar_group g
				INNER JOIN tb_mocar_group_cost gc ON ( g.mggroup = gc.mggroup ) 
			WHERE
				g.brcar = '$row[br_car]' 
				AND gc.carold = $_resultDatas->carOld 
				AND g.mocar IN ('$row[mo_car]', 'ALL') 
				AND (g.mgstatus = 'Y')";

$res_xxx = PDO_CONNECTION::fourinsure_insured()->query($sql_xxx)->fetch(5);

$price = $price_car * 1;
$fixCostPercent = ceil(($price * (int)$res_xxx->fixcost) / 100);
$fixCostEndPercent = ceil(($price * (int)$res_xxx->fixcostend) / 100);
$startCost = round($fixCostPercent, -4);
$endCost = round($fixCostEndPercent, -4);
$totalCostPercent = round((($startCost + $endCost) / 2), -4); //ทุนประกันภัย

if (empty($Cost_NEW)) {
    $Cost_NEW = $totalCostPercent;
}
else
{
    $Cost_NEW = $totalCostPercent;
}

#region update tun quotation F
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://www.fourinsured.com/policy/service/QuotationRenew/Quotation-main.controller.php',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{
    "mo_car":"'.$row['mo_car'].'",
    "car_id":"'.$row['car_id'].'",
    "id":"'.$_GET['id'].'",
    "detailcost":"'.$row['detailcost'].'",
    "renew_ptype":"'.$row['renew_ptype'].'",
    "renew_product":"'.$row['renew_product'].'",
    "renew_id_cost":"'.$row['renew_id_cost'].'",
    "carold":"'.$_resultDatas->carOld.'",
    "totalCostPercent":"'.$totalCostPercent.'",
    "endCost":"'.$endCost.'",
    "costselect":"'.$costselect[9].'"
}',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Cookie: PHPSESSID=fht0p56dse94gn4lvebc3qd41g'
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
echo "<script>console.log('resAPI',$response);console.log('ErrAPI',`$err`);</script>";
#endregion

if ($row['EditTime'] == 'Y') {
    $new_end_date = $_instanceSer->thaiDate($row['EditTime_EndDate']);
} else {
    $new_end_date = $_instanceSer->thaiDate($row['end_date']);
}
//----------------- Condition Statistic Customer----------------------//

$sql_ins = "SELECT * FROM insuree, `data` WHERE insuree.id_data = `data`.id_data
            AND insuree.id_data = '$row[idselect]' GROUP BY insuree.id_data";

$obj_ins = PDO_CONNECTION::fourinsure_mitsu()->query($sql_ins);
$row_ins = $obj_ins->fetch();

$sql_cerf = "SELECT certificate_datestamp,invoice_detail.id_data FROM `certificate`,invoice_detail 
                WHERE `certificate`.inv_no = invoice_detail.inv_no 
                AND invoice_detail.id_data = '$row[idselect]' 
                GROUP BY invoice_detail.id_data ORDER BY idC ASC LIMIT 1 ";

$obj_cerf = PDO_CONNECTION::fourinsure_account()->query($sql_cerf);
$row_cerf = $obj_cerf->fetch();

$sql_year = "SELECT count(id_data) AS count_year FROM insuree WHERE id_data = '$row[idselect]' GROUP BY id_data";

$obj_year = PDO_CONNECTION::fourinsure_mitsu()->query($sql_year);
$row_year = $obj_year->fetch();

// -----------check Blacklist Tel and Email-----------//
$chk_BL_Data = "";
$bltel_home = '';
$bltel_home2 = '';
$bltel_mobi = '';
$bltel_mobi2 = '';
$bltel_moli3 = '';
$blemail = '';

if ($row_ins['tel_home'] != '') {
    $chk_BL_Data .= "'$row_ins[tel_home]',";
}
if ($row_ins['tel_home2'] != '') {
    $chk_BL_Data .= "'$row_ins[tel_home2]',";
}
if ($row_ins['tel_mobi'] != '') {
    $chk_BL_Data .= "'$row_ins[tel_mobi]'";
}
if ($row_ins['tel_mobi_2'] != '') {
    $chk_BL_Data .= ",'$row_ins[tel_mobi_2]'";
}

// if ($row_ins['tel_mobi_3'] != '') {
//     $chk_BL_Data .= "'$row_ins[tel_mobi_3]'";
// }
// if ($row_ins['email'] != '') {
//     $chk_BL_Data .= "'$row_ins[email]'";
// }

$queBlist = "SELECT * FROM tb_blacklist WHERE bl_status = '1' AND bl_data IN($chk_BL_Data)";
$resBlist = PDO_CONNECTION::fourinsure_mitsu()->query($queBlist);
$rowBlist = $resBlist->fetch();
if ($rowBlist != null) {
    foreach ($resBlist as $arrBlist) {
        if (trim($arrBlist['bl_data']) == $row_ins['tel_home']) {
            $bltel_home = "<span style='color:red'>* Blacklist " . $arrBlist['bl_remark'] . " </span>";
        }
        if (trim($arrBlist['bl_data']) == $row_ins['tel_home2']) {
            $bltel_home2 = "<span style='color:red'>* Blacklist " . $arrBlist['bl_remark'] . " </span>";
        }
        if (trim($arrBlist['bl_data']) == $row_ins['tel_mobi']) {
            $bltel_mobi = "<span style='color:red'>* Blacklist " . $arrBlist['bl_remark'] . " </span>";
        }
        if (trim($arrBlist['bl_data']) == $row_ins['tel_mobi2']) {
            $bltel_mobi2 = "<span style='color:red'>* Blacklist " . $arrBlist['bl_remark'] . " </span>";
        }
        if (trim($arrBlist['bl_data']) == $row_ins['tel_mobi3']) {
            $bltel_moli3 = "<span style='color:red'>* Blacklist " . $arrBlist['bl_remark'] . " </span>";
        }
        if (trim($arrBlist['bl_data']) == $row_ins['email']) {
            $blemail = "<span style='color:red'>* Blacklist " . $arrBlist['bl_remark'] . " </span>";
        }
    }
}
//----------------- Condition ----------------------//
if (trim($row_ins["tel_mobi"]) != '' && trim($row_ins["tel_mobi"]) != '-') {
    $tel_mobile = '10';
}
if (trim($row_ins["tel_mobi2"]) != '' && trim($row_ins["tel_mobi2"]) != '-') {
    $tel_mobile2 = '20';
}
if (trim($row_ins["tel_mobi3"]) != '' && trim($row_ins["tel_mobi3"]) != '-') {
    $tel_mobile3 = '20';
}
if (trim($row_ins["tel_home"]) != '' && trim($row_ins["tel_home"]) != '-') {
    $tel_home = '25';
}
if (trim($row_ins["fax"]) != '' && trim($row_ins["fax"]) != '-') {
    $tel_office = '25';
}
if (trim($row_ins["email"]) != '' && trim($row_ins["email"]) != '-') {
    $email = '25';
}
if (trim($row_ins["id_line"]) != '' && trim($row_ins["id_line"]) != '-') {
    $id_line = '25';
}
if (trim($row_ins["vocation"]) != '' && trim($row_ins["vocation"]) != '-') {
    $vocation = '10';
}
if (trim($row_ins["SendAdd"]) != '' && trim($row_ins["SendAdd"]) != '-') {
    $SendAdd = '10';
}
$grand = $tel_mobile + $tel_mobile2 + $tel_mobile3 + $tel_home + $email + $id_line + $tel_office + $vocation + $SendAdd;

// ข้อมูลประกันภัย

$commition = floatval(preg_replace("/[^-0-9\.]/", "", $row_ins["commition"] == '' ? 0 : $row_ins["commition"]));
$other = floatval(preg_replace("/[^-0-9\.]/", "", $row_ins["other"] == '' ? 0 : $row_ins["other"]));
$total_commition = floatval(preg_replace("/[^-0-9\.]/", "", $row_ins["total_commition"] == '' ? 0 : $row_ins["total_commition"]));
$Discount = $total_commition == 0 ? 0 : number_format((($commition + $other) / $total_commition) * 100);
//------- ส่วนลด ------------//
if ($Discount <= 1) {
    $txt_Discount = '<div style="float: left;">5</div>';
} else if ($Discount > 1 && $Discount <= 5) {
    $txt_Discount = '<div style="float: left;">4</div>';
} else if ($Discount > 5 && $Discount <= 10) {
    $txt_Discount = '<div style="float: left;">3</div>';
} else if ($Discount > 10 && $Discount <= 15) {
    $txt_Discount = '<div style="float: left;">2</div>';
} else if ($Discount > 15) {
    $txt_Discount = '<div style="float: left;">1</div>';
}
// ------------- ระดับ เบี้ยชำระ -------------//
//$row_cerf["certificate_datestamp"]='2015-09-31';
$date7 = date("Y-m-d", strtotime("+7 day", strtotime($row_cerf["certificate_datestamp"]))); //$row_ins["start_date"]
$date15 = date("Y-m-d", strtotime("+15 day", strtotime($row_cerf["certificate_datestamp"])));
$date30 = date("Y-m-d", strtotime("+10 day", strtotime($row_cerf["certificate_datestamp"])));
if ($row_cerf["certificate_datestamp"] <= $row_ins["start_date"]) {
    $Payment_Pre = '<div style="float: left;">A</div>';
} else if ($row_cerf["certificate_datestamp"] > $row_ins["start_date"] && $row_cerf["certificate_datestamp"] <= $date7) {
    $Payment_Pre = '<div style="float: left;">B</div>';
} else if ($row_cerf["certificate_datestamp"] > $date7 && $row_cerf["certificate_datestamp"] <= $date15) {
    $Payment_Pre = '<div style="float: left;">C</div>';
} else if ($row_cerf["certificate_datestamp"] > $date15 && $row_cerf["certificate_datestamp"] <= $date30) {
    $Payment_Pre = '<div style="float: left;">D</div>';
} else if ($row_cerf["certificate_datestamp"] > $date30) {
    $Payment_Pre = '<div style="float: left;">E</div>';
}
// ------------- ระดับ เบี้ยชำระ -------------//
if ($row_year["count_year"] == 5) {
    $Num_year = 'O';
} else if ($row_year["count_year"] == 4) {
    $Num_year = 'L';
} else if ($row_year["count_year"] == 3) {
    $Num_year = 'M';
} else if ($row_year["count_year"] == 2) {
    $Num_year = 'N';
} else if ($row_year["count_year"] == 1) {
    $Num_year = 'K';
}
// ------------- ระดับ เคลม -------------//
$cal_claim = 0.00;
$total_pre = $row_ins["total_pre"] == '' ? 0 : str_replace(",", "", $row_ins["total_pre"]);
$cal_claim = $total_pre == 0 ? 0 : number_format(($row_ins["claim_amount"] * 100) / $total_pre);
if ($cal_claim < 1) {
    $claim_html = '<div style="margin-top: -1.5px;float: left; "><i class="icon-star icon-white " ></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i></div>';
} else if ($cal_claim >= 1 && $cal_claim <= 20) {
    $claim_html = '<div style="margin-top: -1.5px;float: left;"><i class="icon-star icon-white" ></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i></div>';
} else if ($cal_claim > 20 && $cal_claim <= 40) {
    $claim_html = '<div style="margin-top: -1.5px;float: left;"><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i></div>';
} else if ($cal_claim > 40 && $cal_claim <= 60) {
    $claim_html = '<div style="margin-top: -1.5px;float: left;"><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i></div>';
} else if ($cal_claim > 60) {
    $claim_html = '<div style="margin-top: -1.5px;float: left;"><i class="icon-star icon-white"></i></div>';
}
// ------------- ระดับ จำนวนกรมธรรม์ -------------//
$policy_amount = $row_ins["policy_amount"];
$grand_statistic = $txt_Discount . '' . $Payment_Pre . '' . $claim_html . '' . $Num_year . '' . $policy_amount;
//******************* Condition Statistic ************************************//
// ข้อมูลประกันภัย
$commition = $row_ins["commition"] == '' ? 0 : floatval(preg_replace("/[^-0-9\.]/", "", $row_ins["commition"]));
$other = $row_ins["other"] == '' ? 0 : floatval(preg_replace("/[^-0-9\.]/", "", $row_ins["other"]));
$total_commition = $row_ins["total_commition"] == '' ? 0 : floatval(preg_replace("/[^-0-9\.]/", "", $row_ins["total_commition"]));
$Discount = $total_commition == 0 ? 0 : number_format((($commition + $other) / $total_commition) * 100);
//------- ส่วนลด ------------//
if ($Discount <= 1) {
    $txt_Discount = '5';
} else if ($Discount > 1 && $Discount <= 5) {
    $txt_Discount = '4';
} else if ($Discount > 5 && $Discount <= 10) {
    $txt_Discount = '3';
} else if ($Discount > 10 && $Discount <= 15) {
    $txt_Discount = '2';
} else if ($Discount > 15) {
    $txt_Discount = '1';
}
// ------------- ระดับ เบี้ยชำระ -------------//
//$row_cerf["certificate_datestamp"]='2015-09-31';
$date7 = date("Y-m-d", strtotime("+7 day", strtotime($row_cerf["certificate_datestamp"]))); //$row_ins["start_date"]
$date15 = date("Y-m-d", strtotime("+15 day", strtotime($row_cerf["certificate_datestamp"])));
$date30 = date("Y-m-d", strtotime("+10 day", strtotime($row_cerf["certificate_datestamp"])));
if ($row_cerf["certificate_datestamp"] <= $row_ins["start_date"]) {
    $Payment_Pre = 'A';
} else if ($row_cerf["certificate_datestamp"] > $row_ins["start_date"] && $row_cerf["certificate_datestamp"] <= $date7) {
    $Payment_Pre = 'B';
} else if ($row_cerf["certificate_datestamp"] > $date7 && $row_cerf["certificate_datestamp"] <= $date15) {
    $Payment_Pre = 'C';
} else if ($row_cerf["certificate_datestamp"] > $date15 && $row_cerf["certificate_datestamp"] <= $date30) {
    $Payment_Pre = 'D';
} else if ($row_cerf["certificate_datestamp"] > $date30) {
    $Payment_Pre = 'E';
}
// ------------- ระดับ เบี้ยชำระ -------------//
if ($row_year["count_year"] == 5) {
    $Num_year = 'O';
} else if ($row_year["count_year"] == 4) {
    $Num_year = 'L';
} else if ($row_year["count_year"] == 3) {
    $Num_year = 'M';
} else if ($row_year["count_year"] == 2) {
    $Num_year = 'N';
} else if ($row_year["count_year"] == 1) {
    $Num_year = 'K';
}
// ------------- ระดับ เคลม -------------//
$cal_claim = 0.00;
$total_pre = $row_ins["total_pre"] == '' ? 0 : str_replace(",", "", $row_ins["total_pre"]);
$cal_claim = $total_pre == 0 ? 0 : number_format(($row_ins["claim_amount"] * 100) / $total_pre);
if ($cal_claim < 1) {
    $claim_html = '<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>';
} else if ($cal_claim >= 1 && $cal_claim <= 20) {
    $claim_html = '<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>';
} else if ($cal_claim > 20 && $cal_claim <= 40) {
    $claim_html = '<i class="icon-star"></i><i class="icon-star"></i><i class="icon-star"></i>';
} else if ($cal_claim > 40 && $cal_claim <= 60) {
    $claim_html = '<i class="icon-star"></i><i class="icon-star"></i>';
} else if ($cal_claim > 60) {
    $claim_html = '<i class="icon-star"></i>';
}
// ------------- ระดับ จำนวนกรมธรรม์ -------------//
$sqlClaim = " SELECT * FROM tb_claim WHERE id_data = '$_GET[id]' ORDER BY dateupdate ASC , claim_date ASC ";

$resClaim = PDO_CONNECTION::fourinsure_mitsu()->query($sqlClaim);
$clnumB = $resClaim->rowCount();
$setNumVal = 0;
$sumClaim = 0;
if ($clnumB > 0) {
    $claimall = $clnumB;
} else {
    $claimall = 0;
}

//หาเบี้ยสุทธิในระบบ
$sqlSMT = " SELECT * FROM smt WHERE id_cost = '$row[costCost]'";

$resSMT = PDO_CONNECTION::fourinsure_mitsu()->query($sqlSMT);
$qeuSMT = $resSMT->fetch();

if ($row['prechk_vib'] != '0.00') {
    $ins_pre = $row['prechk_vib'];
    $ttax = ceil(($ins_pre * 0.4) / 100);
    $sumprevat = round(($ins_pre + $ttax) * 7 / 100, 2);
    $ins_net = round($ins_pre + $ttax + $sumprevat, 2);
    $costdataOld = $ins_pre . '|' . $ttax . '|' . $sumprevat . '|' . $ins_net;
} else {
    $costdataOld = $qeuSMT['pre'] . '|' . $qeuSMT['stamp'] . '|' . $qeuSMT['tax'] . '|' . $qeuSMT['net'];
}

$dateN = date("Y-m-d"); //วันที่ปัจจุบัน
$checkvib_sql = "SELECT tb_comp.name,tb_comp.sort,c.cost,c.cost_end FROM tb_cost c ,tb_cost_mocar cm,tb_comp WHERE  c.mocargroup = cm.namegroup AND c.comp = tb_comp.sort AND cmocar_sz IN ('" . $row['mo_car'] . "','ALL') 
AND cstatus_sz = 'Y' AND create_date <=  '" . $dateN . "' AND date_expired >= '" . $dateN . "' AND c.mocargroup != ''  GROUP BY c.comp ORDER BY c.comp DESC";

$checkvib_query = PDO_CONNECTION::fourinsure_insured()->query($checkvib_sql)->fetchAll();
$checkvib_rows = count($checkvib_query);
$arrIns = array();

foreach ($checkvib_query as $dataIns) {
    $arrIns[] = $dataIns;
}

$_deitalFirstID = PDO_CONNECTION::fourinsure_mitsu()
    ->query("SELECT id_detail FROM detail_renew WHERE id_data = '$_GET[id]' AND `status` = 'F'")
    ->fetch(5)->id_detail;


    