<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
include "../inc/function.php";

$_contextMitsu = PDO_CONNECTION::fourinsure_mitsu();
$_contextFour = PDO_CONNECTION::fourinsure_insured();

$_userLogin = $_SESSION["strUser"];
$_userRights = $_SESSION['claim'];
$_dateStatus = $_GET['dateStatus'];


class CarService
{
    private $_context;
    private $datasBrCar;
    private $datasMoCar;

    public function __construct($con)
    {
        $this->_context = $con;
        $this->createCarBrand();
        $this->createCarModel();
    }

    private function createCarBrand()
    {
        $this->datasBrCar = array();
        $fetch = $this->_context->query("SELECT id AS Id, `name` As `Name` FROM tb_br_car")->fetchAll(2);
        foreach ($fetch as $datas) {
            $this->datasBrCar[$datas['Id']] = $datas['Name'];
        }
    }

    private function createCarModel()
    {
        $this->datasMoCar = array();
        $fetch = $this->_context->query("SELECT id AS Id, `name` As `Name` FROM tb_mo_car")->fetchAll(2);
        foreach ($fetch as $datas) {
            $this->datasMoCar[$datas['Id']] = $datas['Name'];
        }
    }

    public function getCarBrand($Id)
    {
        return $this->datasBrCar[$Id];
    }

    public function getCarModel($Id)
    {
        return $this->datasMoCar[$Id];
    }
}

class WorkRenewService
{
    private $_context;

    public function __construct($con)
    {
        $this->_context = $con;
    }

    public function getDataFollow($user, $rights, $dateStatus)
    {
        $toDayStatus = ($dateStatus == 'toDay') ? 'AND detail_renew.date_alert = DATE(NOW())' : '';
        $getSqlStr = $this->sqlStrUser($user, $rights);
        $sqlStr = "SELECT
        insuree.name AS cus_name,
        `data`.id_data,
        detail.id_data,
        insuree.id_data,
        `data`.com_data,
        `data`.n_insure,
        detail.br_car,
        detail.mo_car,
        detail.add_price,
        detail.cat_car,
        `data`.`login`,
        detail.car_regis,
        detail.regis_date,
        insuree.title,
        insuree.last,
        `data`.send_date,
        `data`.`start_date`,
        `data`.end_date,
        detail.car_body,
        detail.n_motor,
        `data`.costCost,
        detail.car_id,
        `data`.p_act,
        req.CostProduct,
        req.Cus_title,
        req.Cus_name,
        req.Cus_last,
        req.EditAct_id,
        req.Edit_CarBody,
        req.CostProduct,
        tb_customer.saka,
        DATE(detail_renew.date_alert) AS date_alert
        FROM data
        INNER JOIN detail ON (`data`.id_data = detail.id_data)
        INNER JOIN insuree ON (`data`.id_data  = insuree.id_data)
        INNER JOIN tb_customer ON (`data`.`login`  = tb_customer.user)
        INNER JOIN req ON (`data`.id_data  = req.id_data)
        INNER JOIN detail_renew ON (`data`.id_data = detail_renew.id_data)
        WHERE 
        -- detail_renew.detail_follow = '1'
        detail_renew.status = 'R'
        $getSqlStr
        $toDayStatus
        GROUP BY detail_renew.id_data 
        ORDER BY `data`.end_date DESC,
        detail_renew.id_detail DESC";

        $query = $this->_context->query($sqlStr);
        $res['Datas'] = $query->fetchAll(2);
        $res['Count'] = $query->rowCount();
        $res['Sql'] = $sqlStr;

        return (object) $res;
    }

    private function sqlStrUser($user, $rights)
    {

        if ($user != 'admin' && $rights != 'ADMIN') {
            return " AND `data`.`login` = '$user' AND detail_renew.userdetail = 'DEALER' ";
        } else {
            return "";
        }
    }
}

class CloseWorkService
{
    private $_context;

    public function __construct($con)
    {
        $this->_context = $con;
    }

    public function getIDData($user, $rights)
    {
        $sqltext = $this->sqlStrUser($user, $rights);
        $resIDData = $this->_context->query("SELECT id_data,pages FROM detail_renew WHERE `status` = 'E' $sqltext ")->fetchAll(2);
        foreach ($resIDData as $rowID) {
            $arrayIDData[$rowID['id_data']]['id_data'] = $rowID['id_data'];
        }
        return $arrayIDData;
    }

    public function getPages($user, $rights)
    {
        $sqltext = $this->sqlStrUser($user, $rights);
        $resPages = $this->_context->query("SELECT id_data,pages FROM detail_renew WHERE `status` = 'E'  AND pages != '' $sqltext ")->fetchAll(2);
        foreach ($resPages as $rowIDs) {
            $arrayGetIDData[$rowIDs['id_data']]['pages'] = $rowIDs['pages'];
        }
        return $arrayGetIDData;
    }

    private function sqlStrUser($user, $rights)
    {

        if ($user != 'admin' && $rights != 'ADMIN') {
            return " AND userdetail='DEALER' ";
        } else {
            return "";
        }
    }
}

$serviceRenew = new WorkRenewService($_contextMitsu);
$dataRenew = $serviceRenew->getDataFollow($_userLogin, $_userRights, $_dateStatus);

$serviceCar = new CarService($_contextFour);

$serviceCloseWork = new CloseWorkService($_contextMitsu);
$arrayGetIDData = $serviceCloseWork->getIDData($_userLogin, $_userRights);
$arrayGetPages = $serviceCloseWork->getPages($_userLogin, $_userRights);

$i = 0;
$datas = array();

foreach ($dataRenew->Datas as $row) {
    $resIDData = $arrayGetIDData[$row['id_data']]['id_data'];
    $resPages = $arrayGetPages[$row['id_data']]['pages'];

    $datas[$i]['showData'] = '<input id="OQ" type="hidden" readonly="" name="OQ" value="' . $row['id_data'] . '">';

    if ($_userLogin == 'admin') {
        $datas[$i]['showData'] .= '<a class="btn btn-success btn-small w-50" title="" rel="tooltip" onclick="renew(\'' . $row['id_data'] . '\')" data-original-title="ดูข้อมูล"><i class="icon-white icon-list"></i> ดูข้อมูล</a>';
        if (!empty($resIDData)) {
            $datas[$i]['showData'] .= '<a class="span4 btn btn-inverse btn-small w-50" data-original-title="ปิดงานแล้ว!!" type="button">ปิดงานแล้ว!!</a><br>';
        }
    } else {
        if (!empty($resIDData) && $_userLogin == 'admin') {
            $datas[$i]['showData'] .= '<a class="span4 btn btn-inverse btn-small w-50" data-original-title="ปิดงานแล้ว!!" type="button">ปิดงานแล้ว!!</a><br>';
        } else {
            $datas[$i]['showData'] .= '<a class="btn btn-success btn-small w-50" title="" rel="tooltip"   onclick="renew(\'' . $row['id_data'] . '\')" data-original-title="ดูข้อมูล"><i class="icon-white icon-list"></i> ดูข้อมูล</a>';
        }
    }
    if ($row['status'] == 'S') {
        $datas[$i]['print'] = '<a class="span4 btn btn-danger btn-small" onclick="openPrint("' . $row['id_data'] . '")" id="printDeal" type="button"><i class="icon-print icon-white"></i>ใบเสนอราคา</a>';
    }
    if (!empty($row['status'])) {
        $datas[$i]['view'] = '<a class="span4 btn btn-info btn-small" data-toggle="modal" href="pages/viewSendRenew.php?IDDATA=' . $row['id_data'] . '" aria-hidden="true" data-target="#modal"><i class="icon-check icon-white"></i>แจ้งต่ออายุ</a>';
    }
    if (!empty($resPages)) {
        $datas[$i]['showData'] .= '<a class="span4 btn btn-info btn-small" href="print/quotation_renew.php?id_data=' . $row['id_data'] . '&pages=' . $arrayGetPages[$row['id_data']]['pages'] . '" target="_blank" title="ดูใบเสนอราคา" rel="tooltip"><i class="icon-white icon-print"></i> ดูข้อมูลเสนอราคา</a>';
    }
    $datas[$i]['idData'] = $row['id_data'] . "</br> <span class='red'>" . $row['n_insure'] . "</span>";
    $datas[$i]['endDate'] = $row['end_date'];
    $datas[$i]['name'] = $row['title'] . " " . $row['cus_name'] . " " . $row['last'];
    if ($row['Cus_name'] != '') {
        $datas[$i]['nameCus'] = "( " . $row['Cus_title'] . $row['Cus_name'] . " " . $row['Cus_last'] . " )";
    }
    $datas[$i]['mocar'] = $serviceCar->getCarBrand($row['br_car']) . '/' . $serviceCar->getCarModel($row['mo_car']);
    $datas[$i]['carbody'] = $row['car_regis'] . "</br>" . $row['car_body'];
    $yearCar = ((int) date('Y') - (int) $row['regis_date']) + (int) 1;
    $datas[$i]['yearCar'] = $yearCar . ' ปี';
    $datas[$i]['date_alert'] = $row['date_alert'];
    $i++;
}

$res['draw'] = $_GET['draw'];
$res['recordsTotal'] = $dataRenew->Count;
$res['recordsFiltered'] = $dataRenew->Count;
$res['data'] = $datas;
echo json_encode($res);