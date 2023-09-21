<?php
class CheckRenewInformationService implements ICheckRenewInformationService
{
    private $_contextMitsu;
    private $_contextFour;
    private $_convertSearch;
    private $datasBrCar;
    private $datasMoCar;
    private $dataCarRegist;
    private $_convertService;

    public function __construct($conMy4ib, $conFour)
    {
        $this->_contextMitsu = $conMy4ib;
        $this->_contextFour = $conFour;
        $this->_contextMitsu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_contextFour->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_convertSearch = new ConvertSearchCheckRenewInformationService();
        $this->_convertService = new ConvertDataRenewCarInsuranceNewService($this->_contextFour);
        $this->createCarBrand();
        $this->createCarModel();
    }

    public function createDataRenewCarInsuranceNew($req)
    {
        $getRowFull = $this->rowFullDataRenewCarInsuranceNew($req);
        $fetchRenew = $this->fetchDataRenewCarInsuranceNew($req);
        $modelMapper = $this->mapperDataRenewInsurance($fetchRenew);
        $resMapper = $this->mapperDataRenewInsuranceResponse($modelMapper);

        $res = new DataTableCheckRenewInformationResponseModel();
        $res->draw = $req->DataRequest['draw'];
        $res->recordsTotal = $getRowFull;
        $res->recordsFiltered = $getRowFull;
        $res->data = $resMapper;
        $res->Status = 200;
        $res->Text = 'Success';

        return $res;
    }

    private function fetchDataRenewCarInsuranceNew($modelRes)
    {
        try {
            $searchAll = $this->_convertSearch->searchAll($modelRes->DataRequest);
            $sqlOrderBy = $this->_convertSearch->sqlOrderBy($modelRes->DataRequest);
            $sqlLimit = $this->_convertSearch->sqlLimit($modelRes->DataRequest);
            $sqlUserFollow = $this->_convertSearch->sqlUserFollow($modelRes->UserLogin);

            $sqlRenew = "SELECT 
            `data`.id_data,
            `data`.`login`,
            `data`.costCost,
            `data`.end_date,
            insuree.id_data,
            insuree.title,
            insuree.name,
            insuree.last,
            detail.car_body,
            detail.car_regis,
            detail.car_regis_pro,
            detail.br_car,
            detail.mo_car,
            detail_renew.id_data,
            detail_renew.status,
            detail_renew.userdetail,
            detail_renew.detailtext,
            detail_renew.date_alert,
            detail_renew.detailcost,
            detail_renew.id_data_four,
            detail_renew.date_detail,
            req.Req_Status,
            req.EditCar,
            req.Edit_CarBody
            FROM detail_renew
            INNER JOIN `data` ON (detail_renew.id_data = `data`.id_data)
            INNER JOIN insuree ON (detail_renew.id_data = insuree.id_data)
            INNER JOIN detail ON (detail_renew.id_data = detail.id_data)
            INNER JOIN req ON (detail_renew.id_data = req.id_data)
            WHERE detail_renew.status = 'E' AND detail_renew.id_data_four != '' AND 
            (
                `data`.id_data LIKE '%$searchAll%' OR 
                insuree.title LIKE '%$searchAll%' OR
                insuree.name LIKE '%$searchAll%' OR
                insuree.last LIKE '%$searchAll%' OR
                detail.car_body LIKE '%$searchAll%' OR
                detail.n_motor LIKE '%$searchAll%' OR
                detail_renew.userdetail LIKE '%$searchAll%' OR
                detail_renew.detailtext LIKE '%$searchAll%' OR
                detail_renew.id_data_four LIKE '%$searchAll%'
            ) $sqlUserFollow $sqlOrderBy $sqlLimit ";
            
            return $this->_contextMitsu->query($sqlRenew)->fetchAll(2);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    private function rowFullDataRenewCarInsuranceNew($modelRes)
    {
        try {
            $searchAll = $this->_convertSearch->searchAll($modelRes->DataRequest);
            $sqlUserFollow = $this->_convertSearch->sqlUserFollow($modelRes->UserLogin);

            $sqlRenew = "SELECT `data`.id 
            FROM detail_renew
            INNER JOIN `data` ON (detail_renew.id_data = `data`.id_data)
            INNER JOIN insuree ON (detail_renew.id_data = insuree.id_data)
            INNER JOIN detail ON (detail_renew.id_data = detail.id_data)
            INNER JOIN req ON (detail_renew.id_data = req.id_data)
            WHERE detail_renew.status = 'E' AND detail_renew.id_data_four != '' AND 
            (
                `data`.id_data LIKE '%$searchAll%' OR 
                insuree.title LIKE '%$searchAll%' OR
                insuree.name LIKE '%$searchAll%' OR
                insuree.last LIKE '%$searchAll%' OR
                detail.car_body LIKE '%$searchAll%' OR
                detail.n_motor LIKE '%$searchAll%' OR
                detail_renew.userdetail LIKE '%$searchAll%' OR
                detail_renew.detailtext LIKE '%$searchAll%' OR
                detail_renew.id_data_four LIKE '%$searchAll%'
            ) $sqlUserFollow LIMIT 0,1000";
            return $this->_contextMitsu->query($sqlRenew)->rowCount();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    private function mapperDataRenewInsurance($params)
    {
        $res = array();
        $dataRenew = null;
        foreach ($params as $datas) {
            $getRegistPro = $this->getCarRegistProvince($datas['car_regis_pro']);
            $dataRenew = explode('|', $datas['detailcost']);
            $map = new DataRenewInsuranceModel();
            $map->IdData = $datas['id_data'];
            $map->IdDataFour = $datas['id_data_four'];
            $map->Status = $datas['status'];
            $map->FollowDate = $datas['date_detail'];
            $map->Title = $datas['title'];
            $map->Name = $datas['name'];
            $map->Last = $datas['last'];
            $map->CarBrandName = $this->getCarBrand($datas['br_car']);
            $map->CarModelName = $this->getCarModel($datas['mo_car']);
            $map->Fund = $dataRenew[0];
            $map->Detail = $datas['detailtext'];
            $map->User = $datas['userdetail'];
            $map->EndorseStatus = $datas['Req_Status'];
            $map->EndorseCarStatus = $datas['EditCar'];
            $map->CarBody = $datas['car_body'];
            $map->EndorseCarbody = $datas['Edit_CarBody'];
            $map->CarRegistNo = $datas['car_regis'];
            $map->CarRegistProvince = $getRegistPro->NameMini;
            array_push($res, $map);
        }
        return $res;
    }
    private function getPaymentRenewCreditViriyah()
    {
        $sql = "SELECT * FROM LogPaymentCreditViriyahMitsubishiRenew";
        $infoArr = $this->_contextFour->query($sql)->fetchAll(2);
        return $infoArr;
    }

    private function checkPayment($datas, $dataID)
    {
        foreach ($datas as $data) {
            if ($data['id_data_old'] == $dataID) {
                return "<div class='btn-success btn-small' style='width:100px;float:left;heigth:32px;padding:5px 10px;' title='จ่ายเงินแล้ว' rel='tooltip' id='prints' >ชำระเงินแล้ว</div>";
            }
        }
        return "<div class='btn-danger btn-small' style='width:100px;float:left;heigth:32px;padding:5px 10px;' title='จ่ายเงินแล้ว' rel='tooltip' id='prints' >ยังไม่ชำระเงิน</div>"; //<i class='icon-white icon-check'>
    }

    private function mapperDataRenewInsuranceResponse($params)
    {
        $res = array();
        if (count($params) > 0) {
            $this->_convertService->createDataCarInsuranceNew($params);
        }

        $paymentViriyahArr = $this->getPaymentRenewCreditViriyah();
        foreach ($params as $row => $obj) {
            $map = new CheckRenewInformationResponseModel();
            $map->IdDataOld = $obj->IdData;
            $map->IdDataNew = $obj->IdDataFour;
            $map->Approval = $this->_convertService->approvalButton($obj);
            $map->ViewDocument = $this->_convertService->viewDocumentButton($obj);
            $map->ViewInformation = $this->_convertService->viewInformationButton($obj);
            $map->CarName = $this->_convertService->carFullName($obj);
            $map->CustomerName = $this->_convertService->customerFullName($obj);
            $map->RenewFund = $this->_convertService->renewFund($obj);
            $map->DetailRenew = $obj->Detail;
            $map->UserRenew = $obj->User;
            $map->RenewDate = $obj->FollowDate;
            $map->CarRegistName = $this->_convertService->carRegistFullName($obj);
            $map->DetailPayment = $this->checkPayment($paymentViriyahArr, $obj->IdData);
            $map->InsureNo = '<center>-</center>';
            $map->ThaiPostID = '<center>-</center>';
            $res[$row] = $map;
        }
        return $res;
    }

    private function createCarBrand()
    {
        $this->datasBrCar = array();
        $fetch = $this->_contextMitsu->query("SELECT id AS Id, `name` As `Name` FROM tb_br_car")->fetchAll(2);
        foreach ($fetch as $datas) {
            $this->datasBrCar[$datas['Id']] = $datas['Name'];
        }
    }

    private function createCarModel()
    {
        $this->datasMoCar = array();
        $fetch = $this->_contextMitsu->query("SELECT id AS Id, `name` As `Name` FROM tb_mo_car")->fetchAll(2);
        foreach ($fetch as $datas) {
            $this->datasMoCar[$datas['Id']] = $datas['Name'];
        }
    }

    public function createRegistProvince()
    {
        $this->datasMoCar = array();
        $fetch = $this->_contextMitsu->query("SELECT id AS Id, `name` As `Name`, name_mini AS NameMini FROM tb_province")->fetchAll(2);
        foreach ($fetch as $datas) {
            $newObj = (object) array('Name' => $datas['NameMini'], 'NameMini' => $datas['NameMini']);
            $this->dataCarRegist[$datas['Id']] = $newObj;
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

    public function getCarRegistProvince($id)
    {
        return $this->dataCarRegist[$id];
    }
}