<?php
set_time_limit(36000);

class ImportData
{
    protected $_contextMitsu;
    protected $_contextFour;
    protected $_idDataDefault = '64401/MMT/000001';
    protected $_user;
    protected $_position;
    protected $_comData = 'VIB_S';
    protected $_nameInform;
    protected $_docType = 1;
    protected $_brCar = '046';
    protected $_genCarTypeId;
    protected $_genAct;
    protected $_tumbonArr;
    protected $_ampharArr;
    protected $_provinceArr;
    protected $_arrModelSubAll;
    protected $_reSolveEndDateService;
    protected $_setYearCar;
    protected $_costQueryArr;

    public function __construct($contextMitsu, $contextFour, $user, $position)
    {
        $this->_contextMitsu = $contextMitsu;
        $this->_contextFour = $contextFour;
        $this->_user = $user;
        $this->_position = $position;
        $this->_reSolveEndDateService = new ResolveEndDate($contextMitsu);
        $this->loadAddressArr();
    }

    public function loadAddressArr()
    {
        $this->_tumbonArr = $this->_contextFour->query("SELECT * FROM tb_tumbon")->fetchAll();
        $this->_ampharArr = $this->_contextFour->query("SELECT * FROM tb_amphur")->fetchAll();
        $this->_provinceArr = $this->_contextFour->query("SELECT * FROM tb_province")->fetchAll();
        return false;
    }

    private function generatIdData()
    {
        $sql = "SELECT id_data FROM `data` WHERE id_data REGEXP 'MMT' ORDER BY id DESC LIMIT 1";
        $res = $this->_contextMitsu->query($sql)->fetch(7);
        $idData = $this->_idDataDefault;
        if ($res) {
            $arrIdData = explode('/', $res);
            $generated = ((int)$arrIdData[2] + 1);
            $generatedToString = sprintf("%06d", $generated);
            $idData = (string)($arrIdData[0] . '/' . $arrIdData[1] . '/' . $generatedToString);
        }
        return $idData;
    }
    private function generatIdDataBySaka($id)
    {
        if (!$id) {
            return $this->generatIdData();
        }

        $arrIdData = explode('/', $this->_idDataDefault);
        $genIDYearSaka = substr($arrIdData[0], 0, 2);
        $YearTh = date('Y') + 543;
        if (substr("$YearTh", 2, 3) != $genIDYearSaka) {
            $genIDYearSaka = substr("$YearTh", 2, 3);
        }
        $whereIdData = (string)($genIDYearSaka . $id . '/' . $arrIdData[1] . '/');
        $sql = "SELECT id_data FROM `data` WHERE id_data REGEXP '$whereIdData' ORDER BY id DESC LIMIT 1";
        $res = $this->_contextMitsu->query($sql)->fetch(7);
        $idData = (string)($genIDYearSaka . $id . '/' . $arrIdData[1] . '/' . $arrIdData[2]);

        if ($res) {
            $arrIdData = explode('/', $res);
            $generated = ((int)$arrIdData[2] + 1);
            $generatedToString = sprintf("%06d", $generated);
            $genIDYearSaka = substr($arrIdData[0], 0, 2);
            $YearTh = date('Y') + 543;
            if (substr("$YearTh", 2, 3) != $genIDYearSaka) {
                $genIDYearSaka = substr("$YearTh", 2, 3);
            }
            $idData = (string)($genIDYearSaka . $id . '/' . $arrIdData[1] . '/' . $generatedToString);
        }
        return $idData;
    }

    private function generatIdModelCar($name, $sub)
    {
        $sql = "SELECT `id` AS Id, `name` AS `Name`,CONVERT(mocar_price,UNSIGNED) AS Price, 
        MakeTyte1, MakeTyte2, MakeTyte3, '' AS beInexact FROM tb_mo_car 
        WHERE `name` REGEXP '{$name}' AND mocar_price > 0 LIMIT 1";

        $res = $this->_contextFour->query($sql)->fetch(5);

        $newPrice = $this->genPriceModelCarSub($res->Id, $sub);
        $check = $this->findFullNameModelCar($name . ' ' . $sub);

        if ($check) {
            $res->Id = $check;
        }
        if ($newPrice) {
            $res->beInexact = $newPrice->id;
            $res->Price = (int)$newPrice->price_car;
        }
        return $res;
    }
    private function findFullNameModelCar($name)
    {
        $sql = "SELECT `id` AS Id FROM tb_mo_car WHERE `name` REGEXP '{$name}' LIMIT 1";
        return $this->_contextFour->query($sql)->fetch(7);
    }

    private function genPriceModelCarSub($id, $name)
    {
        $arrName = explode(' ', $name);
        $math = $this->get_numerics($arrName[0]);
        $lenghtName = count($arrName);
        $num1 = trim($arrName[1]);
        $and = "AND `name` REGEXP '{$num1}' ";
        /*$and = '';
        if($lenghtName == 2 && $math == false){
            $num0 = trim($arrName[0]);
            $num1 = trim($arrName[1]);
            $and = "AND `name` REGEXP '{$num0}|{$num1}' ";
        }
        if($lenghtName == 2 && $math == true){
            $num1 = trim($arrName[1]);
            $and = "AND `name` REGEXP '{$num1}' ";
        }
        if($lenghtName > 2){
            $num1 = trim($arrName[1]);
            $num2 = trim($arrName[2]);
            $and = "AND `name` REGEXP '{$num1}|{$num2}' ";
        }*/
        $sql = "SELECT id,price_car FROM tb_car_model_sub WHERE id_mo_car = '$id' $and ";
        $res = $this->_contextFour->query($sql)->fetch(5);
        return $res;
    }

    private function generatIdModelCarByID($id)
    {

        $sql = "SELECT `id` as Id, `name` as `Name`,CONVERT(mocar_price,UNSIGNED) as Price, 
        MakeTyte1, MakeTyte2, MakeTyte3 FROM tb_mo_car WHERE id = '{$id}' AND mocar_price > 0 LIMIT 1";

        $res = $this->_contextFour->query($sql)->fetch(5);
        return $res;
    }

    //TODO ReadData excel DMS
    public function readData($arr)
    {
        if (!$arr) {
            return 'ไม่พบข้อมูล !';
        }

        $this->_genAct = $this->genQuickFindDataArrayAct(); //get act all
        $branchInfoArr = $this->checkBranchUpload($arr);
        $lenghtBranch = count($branchInfoArr);
        $result = [];
        $resArr = [];
        $totalNotFoundModelCar = 0;
        $totaNotfoundCost = 0;
        $totalSuccess = 0;
        $totalDuplicateChassis = 0;

        for ($p = 0; $p < $lenghtBranch; $p++) {

            $this->_user = (string)($branchInfoArr[$p][0])->C;
            $this->_position = $this->_user;
            $this->_nameInform = $this->genNameInForm($this->_user);
            $chassisNumberArr = $this->chassisNumberAllByDealer(); //ดึงเลขตัวถังที่เคยอัพไปแล้วออกมาเช็ค
            $round = count($branchInfoArr[$p]);
            $pointer = 0;


            for ($x = 0; $x < $round; $x++) {

                $res = $this->mappingToModel($branchInfoArr[$p][$pointer++]);
                if (!$res) {
                    continue;
                }

                //$this->generatIdModelCar($res->modelCar, $res->modelCarSub);
                // $checkModelCar = new stdClass();
                // $checkModelCar->Id = $res->ModelCar;            
                // $checkModelCar->Price = $res->carPrice;
                // $checkModelCar->beInexact = $res->modelCarSub;

                //เช็คว่ามีเลขถังเข้าไปซ้ำแล้วหรือไม่
                if ($chassisNumberArr[$res->carBody]) {
                    $resArr[$res->carBody]['duplicateChassis'] = true;
                    $totalDuplicateChassis++;
                    continue;
                }

                if (!$res->modelCar) {
                    $resArr[$res->carBody]['notfoundModelCar'] = true;
                    $totalNotFoundModelCar++;
                    continue;
                }

                $carOld = $this->genYearCar($res->yearCar);

                //set ปีจดทะเบียนรถใหม่ทุกครั้งหลังจากคำนวณหาปีรถแล้ว
                $res->yearCar = $this->_setYearCar;

                $res->sumAssured = $this->calculateCostYearByNing($carOld, $res->carPrice);
                // $res->sumAssured = $this->genSumAssured($res->modelCar, $carOld, $res->carPrice);

                if (!$res->sumAssured) {
                    $resArr[$res->carBody]['notfoundCost'] = true;
                    $totaNotfoundCost++;
                    continue;
                }

                // $catCar = $this->genCarTypeId($checkModelCar);

                $this->_genCarTypeId = $res->carTypeId;


                //($res->carTypeId) ? $res->carTypeId : $catCar;

                $cost = $this->genCostFormFour($res->modelCar, $res->sumAssured, $carOld);

                // self::chkAll($cost);
                // if (gettype($cost) == 'string') {
                //     $resArr[$res->carBody]['notfoundCost2'] = true;
                //     $totaNotfoundCost++;
                //     continue;
                // }

                $totalSuccess++;

                if ($cost->action) {
                    $cost->sumAssured = (string)$res->sumAssured;
                }

                $result[$this->_user][$x]['cost'] = $cost;
                $result[$this->_user][$x]['res'] = $res;

                $resArr[$res->carBody]['saveToTableData'] = $this->saveToTableData($res);
                $resArr[$res->carBody]['saveToTableDetail'] = $this->saveToTableDetail($res);
                if ($cost->action) {
                    $this->updateIdCost($res->idData, $cost->id_cost);
                }
                $resArr[$res->carBody]['saveToTableInsuree'] = $this->saveToTableInsuree($res);
                $resArr[$res->carBody]['saveToTableAct'] = $this->saveToTableAct($res);
                $resArr[$res->carBody]['saveToTableReq'] = $this->saveToTableReq($res);
                $resArr[$res->carBody]['saveToTableDriver'] = $this->saveToTableDriver($res);
                $resArr[$res->carBody]['saveToTableDetailRenew'] = $this->saveToTableDetailRenew($res, $cost);
                $resArr[$res->carBody]['idData'] = $res->idData;
                $resArr[$res->carBody]['beInexact'] = $res->modelCarSub;
                $this->saveLogImportData($res->idData, $res->text, $res->modelCarSub, $res->modelCarSub);
            }
        }
        $resArr['totalNotfoundModelCar'] = $totalNotFoundModelCar;
        $resArr['totalNotfoundCost'] = $totaNotfoundCost;
        $resArr['totalSuccess'] = $totalSuccess;
        $resArr['totalDuplicateChassis'] = $totalDuplicateChassis;
        return $resArr;
    }

    //TODO ReadData excel Other
    public function readOtherData($arr)
    {

        if (!$arr) {
            return 'ไม่พบข้อมูล !';
        }

        $this->_genAct = $this->genQuickFindDataArrayAct(); //get act all
        $branchInfoArr[0] = $arr;

        // $this->checkBranchUpload($arr);
        $this->_nameInform = $this->genNameInForm($this->_user);

        $lenghtBranch = count($branchInfoArr);

        $result = array();
        $resArr = [];
        $totalNotFoundModelCar = 0;
        $totaNotfoundCost = 0;
        $totalSuccess = 0;
        $totalDuplicateChassis = 0;

        for ($p = 0; $p < $lenghtBranch; $p++) {
            // $this->_user = (string)($branchInfoArr[$p][0])->C;
            $this->_position = $this->_user;
            $chassisNumberArr = $this->chassisNumberAllByDealer(); //ดึงเลขตัวถังที่เคยอัพไปแล้วออกมาเช็ค
            $round = count($branchInfoArr[$p]);

            $pointer = 2;

            for ($x = 0; $x < $round; $x++) {
                $res = $this->mappingOtherToModel($branchInfoArr[$p][$pointer++]);

                if (!$res) {
                    continue;
                }

                //turn off
                //$this->generatIdModelCar($res->modelCar, $res->modelCarSub);
                // $checkModelCar = new stdClass();
                // $checkModelCar->Id = $res->ModelCar;            
                // $checkModelCar->Price = $res->carPrice;
                // $checkModelCar->beInexact = $res->modelCarSub;

                //เช็คว่ามีเลขถังเข้าไปซ้ำแล้วหรือไม่
                if ($chassisNumberArr[$res->carBody]) {
                    $resArr[$res->carBody]['duplicateChassis'] = true;
                    $totalDuplicateChassis++;
                    continue;
                }

                if (!$res->modelCar) {
                    $resArr[$res->carBody]['notfoundModelCar'] = true;
                    $totalNotFoundModelCar++;
                    continue;
                }

                $carOld = $this->genYearCar($res->yearCar);

                //set ปีจดทะเบียนรถใหม่ทุกครั้งหลังจากคำนวณหาปีรถแล้ว
                $res->yearCar = $this->_setYearCar;

                $res->sumAssured = $this->calculateCostYearByNing($carOld, $res->carPrice);
                // $res->sumAssured = $this->genSumAssured($res->modelCar, $carOld, $res->carPrice);    
                if (!$res->sumAssured) {
                    $resArr[$res->carBody]['notfoundCost'] = true;
                    $totaNotfoundCost++;
                    continue;
                }

                // $catCar = $this->genCarTypeId($checkModelCar); turn off

                $this->_genCarTypeId = $res->carTypeId;


                //($res->carTypeId) ? $res->carTypeId : $catCar; turn off

                $cost = $this->genCostFormFour($res->modelCar, $res->sumAssured, $carOld);

                //turn off
                // self::chkAll($cost);
                // if (gettype($cost) == 'string') {
                //     $resArr[$res->carBody]['notfoundCost2'] = true;
                //     $totaNotfoundCost++;
                //     continue;
                // }

                $totalSuccess++;

                if ($cost->action) {
                    $cost->sumAssured = (string)$res->sumAssured;
                }

                $result[$this->_user][$x]['cost'] = $cost;
                $result[$this->_user][$x]['res'] = $res;


                $resArr[$res->carBody]['saveToTableData'] = $this->saveToTableData($res);
                $resArr[$res->carBody]['saveToTableDetail'] = $this->saveToTableDetail($res);
                if ($cost->action) {
                    $this->updateIdCost($res->idData, $cost->id_cost);
                }
                $resArr[$res->carBody]['saveToTableInsuree'] = $this->saveToTableInsuree($res);
                $resArr[$res->carBody]['saveToTableAct'] = $this->saveToTableAct($res);
                $resArr[$res->carBody]['saveToTableReq'] = $this->saveToTableReq($res);
                $resArr[$res->carBody]['saveToTableDriver'] = $this->saveToTableDriver($res);
                $resArr[$res->carBody]['saveToTableDetailRenew'] = $this->saveToTableDetailRenew($res, $cost);
                $resArr[$res->carBody]['idData'] = $res->idData;
                $resArr[$res->carBody]['beInexact'] = $res->modelCarSub;
                $this->saveLogImportData($res->idData, $res->text, $res->modelCarSub, $res->modelCarSub);
            }
        }
        $resArr['totalNotfoundModelCar'] = $totalNotFoundModelCar;
        $resArr['totalNotfoundCost'] = $totaNotfoundCost;
        $resArr['totalSuccess'] = $totalSuccess;
        $resArr['totalDuplicateChassis'] = $totalDuplicateChassis;
        return $resArr;
    }

    public static function chkAll($data)
    {
        var_dump($data);
        exit();
    }

    public function importInformSingleRenew($arr)
    {
        if (!$arr) {
            return 'ไม่พบข้อมูล !';
        }
        $resArr = [];
        $this->_genAct = $this->genQuickFindDataArrayAct();
        $this->_nameInform = $this->genNameInForm($this->_user);
        $this->_user = $arr->agentCode;

        $round = count($arr);
        $pointer = 2;
        $totalNotFoundModelCar = 0;
        $totaNotfoundCost = 0;
        $totalSuccess = 0;

        $res = $this->mappingToModelSingle($arr);

        $checkModelCar = $this->findCarPriceByID($res->modelCarSub);

        if (!$checkModelCar) {
            $resArr['notfoundModelCar'] = true;
            $totalNotFoundModelCar++;
            return $resArr;
        }

        $carOld = $this->genYearCar($res->yearCar);
        $res->sumAssured = $this->calculateCostYearByNing($carOld, $checkModelCar->price_car);
        // $res->sumAssured = $this->genSumAssured($res->modelCar, $carOld, $checkModelCar->price_car);

        if (!$res->sumAssured) {
            $resArr['notfoundCost'] = true;
            $totaNotfoundCost++;
            return $resArr;
        }
        $catCar = $this->genCatCarId($res->catCar);
        $this->_genCarTypeId = $catCar;
        $cost = $this->genCostFormFour($res->modelCar, $res->sumAssured, $carOld, $catCar);

        if (gettype($cost) == 'string') {
            $resArr['notfoundCost'] = true;
            $totaNotfoundCost++;
            return $resArr;
        }

        $totalSuccess++;
        $cost->sumAssured = (string)$res->sumAssured;
        $resArr['saveToTableData'] = $this->saveToTableData($res);
        $resArr['saveToTableDetail'] = $this->saveToTableDetail($res);
        $this->updateIdCost($res->idData, $cost->id_cost);
        $resArr['saveToTableInsuree'] = $this->saveToTableInsuree($res);
        $resArr['saveToTableAct'] = $this->saveToTableAct($res);
        $resArr['saveToTableReq'] = $this->saveToTableReq($res);
        $resArr['saveToTableDriver'] = $this->saveToTableDriver($res);
        $resArr['saveToTableDetailRenew'] = $this->saveToTableDetailRenew($res, $cost);
        $resArr['idData'] = $res->idData;
        $this->saveLogImportData($res->idData, $res->text, $res->modelCarSub, $res->modelCarSub);
        return $resArr;
    }

    private function updateIdCost($idData, $idCost)
    {
        $sql = "UPDATE `data` SET costCost=? WHERE id_data=?";
        $res = $this->_contextMitsu->prepare($sql)->execute([$idCost, $idData]);
        return $res;
    }

    private function saveToTableData($model)
    {
        if ($_SESSION['log_type'] == 'TIP') {
            $work_type = "TIP";
        } else {
            $work_type = NULL;
        }
        $data = [
            'login' => "$this->_user",
            'com_data' => empty($model->sort) ? 'TMSTH' : "$model->sort",
            'send_date' => "$model->sendDate",
            'id_data' => "$model->idData",
            'p_act' => '-',
            'costCost' => 1187,
            'ty_inform' => 'L',
            'Status_Email' => 'F',
            'start_date' => "$model->startDate",
            'end_date' => "$model->endDate",
            'name_inform' => "$this->_nameInform",
            'name_gain' => "$model->beneficiary",
            'doc_type' => "ประกันภัยรถยนต์ประเภท $this->_docType",
            'OrderAct' => 0.00,
            'uptun' => '0',
            'renewuse' => "$this->_position",
            'save_login' => "$this->_user",
            'work_type' => "$work_type"
        ];
        $sql = "INSERT INTO `data` (`login`, com_data, send_date, id_data, p_act, costCost, ty_inform, Status_Email, `start_date`, end_date, name_inform, name_gain, doc_type, OrderAct, uptun, renewuse, save_login, work_type) VALUES (:login, :com_data, :send_date, :id_data, :p_act, :costCost, :ty_inform, :Status_Email, :start_date, :end_date, :name_inform, :name_gain, :doc_type, :OrderAct, :uptun, :renewuse, :save_login, :work_type)";
        $res = $this->_contextMitsu->prepare($sql)->execute($data);
        return $res;
    }

    private function saveToTableDetail($model, $x = '', $y = '')
    {
        $data = [
            'id_data' => $model->idData,
            'car_id' => $this->_genCarTypeId,
            'br_car' => $this->_brCar,
            'mo_car' => $model->modelCar,
            'car_body' => $model->carBody,
            'n_motor' => $model->carMotor,
            'car_regis' => $model->carRegis,
            'car_regis_text' => '-',
            'car_regis_pro' => $model->carRegisPro,
            'car_color' => $model->carColor,
            'car_cc' => $model->carCC,
            'car_seat' => $model->carSeat,
            'car_wgt' => $model->carweight,
            'gear' => $model->gear,
            'regis_date' => $model->yearCar,
            'insure_year' => $this->_docType,
            'equit' => 'Y',
            'cat_car' => $model->catCar,
        ];
        // $this->_genCarTypeId = $data['car_id'];
        $sql = "INSERT INTO `detail` (id_data, car_id, br_car, mo_car, car_body, n_motor, car_regis, car_regis_text, car_regis_pro, car_color, car_cc, car_seat, car_wgt, gear, regis_date, insure_year, equit, cat_car) VALUES (:id_data, :car_id, :br_car, :mo_car, :car_body, :n_motor, :car_regis, :car_regis_text, :car_regis_pro, :car_color, :car_cc, :car_seat, :car_wgt, :gear, :regis_date, :insure_year, :equit, :cat_car)";
        $res = $this->_contextMitsu->prepare($sql)->execute($data);
        return $res;
    }

    private function concatPhone($num = '', $num2 = '', $num3 = '')
    {
        $txPhone = '';
        if (!empty($num)) {
            $txPhone = str_replace('-', '', $num);
        }

        if (!empty($num2)) {
            $txPhone .= 'เบอร์มือถือ/' . str_replace('-', '', $num2) . '|';
        }

        if (!empty($num3)) {
            $txPhone .= 'เบอร์มือถือ/' . str_replace('-', '', $num3) . '|';
        }
        return $txPhone;
    }

    private function getAmphurByNameAndProID($name, $id)
    {
        // $nameFix = preg_replace('/[^ก-ฮ]+/iu', '', $name);
        // $nameFix = str_replace(' ', '', $name);
        // $arrName = explode('.',$nameFix,2);
        // $newName = empty($arrName[1]) ? $arrName[0] : $arrName[1];
        foreach ($this->_ampharArr as $amp) {
            // $pos = strrpos(trim($amp['name']), trim($name));
            if ($amp['provinceID'] == $id && trim($amp['name']) == trim($name)) {
                return $amp['id'];
            }
        }
        return $name;
    }

    private function getTumBonByNameAndAmpID($name, $id)
    {
        // $nameFix = preg_replace('/[^ก-ฮ]+/iu', '', $name);
        $nameFix = str_replace(' ', '', $name);
        $arrName = explode('.', $nameFix, 2);
        $newName = empty($arrName[1]) ? $arrName[0] : $arrName[1];
        foreach ($this->_tumbonArr as $tum) {
            if ($tum['amphurID'] == $id && $tum['name'] == $newName) {
                return $tum['id'];
            }
        }
        return $name;
    }

    function getProvinceByName($name)
    {
        // $nameFix = preg_replace('/[^ก-ฮ]+/iu', '', $name);
        $nameFix = str_replace(' ', '', $name);
        $arrName = explode('.', $nameFix, 2);
        $newName = empty($arrName[1]) ? $arrName[0] : $arrName[1];
        foreach ($this->_provinceArr as $proOne) {
            if ($proOne['name'] == $newName) {
                return $proOne['id'];
            }
        }
        return $name;
    }


    private function getAddressCus($proN, $tumN, $ampN)
    {
        $result = new stdClass();
        $result->province = $this->getProvinceByName($proN);
        $result->amphur = $this->getAmphurByNameAndProID($ampN, $result->province);
        $result->tumbon = $this->getTumBonByNameAndAmpID($tumN, $result->amphur);
        return $result;
    }

    private function saveToTableInsuree($model)
    {
        $addressCus = $this->getAddressCus($model->province, $model->tumbon, $model->amphur);
        $idCard = '';
        $iCardNiti = '';
        if ($this->checkPerson($model->person)) {
            $person = 1;
            $idCard = $model->idCard;
        } else {
            $person = 2;
            $iCardNiti = $model->idCard;
        }
        $data = [
            'id_data' => "$model->idData",
            'title' => "$model->titleName",
            'name' => "$model->firstName",
            'last' => "$model->lastName",
            'person' => "$person",
            'vocation' => 'ธุรกิจส่วนตัว',
            'career' => 2,
            'icard' => "$idCard",
            'icard_niti' => "$iCardNiti",
            'add' => "$model->houseNumber",
            'lane' => "$model->alley",
            'road' => "$model->road",
            'tumbon' => "$addressCus->tumbon",
            'amphur' => "$addressCus->amphur",
            'province' => "$addressCus->province",
            'postal' => "$model->postalCode",
            'tel_home' => $this->concatPhone($model->phoneNumber1),
            'tel_mobi' => $this->concatPhone($model->phoneNumber1),
            'tel_mobi_2' => $this->concatPhone('', $model->phoneNumber2, $model->phoneNumber3),
            'tel_mobi_3' => "$model->phoneNumber3",
            'status_SendAdd' => 'N'
        ];
        $sql = "INSERT INTO `insuree` (id_data, title, `name`, `last`, person, vocation, career, icard, icard_niti, `add`, `lane`, road, tumbon, amphur, province, postal, tel_home, tel_mobi, tel_mobi_2, tel_mobi_3, status_SendAdd) VALUES (:id_data, :title, :name, :last, :person, :vocation, :career, :icard, :icard_niti, :add, :lane, :road, :tumbon, :amphur, :province, :postal, :tel_home, :tel_mobi, :tel_mobi_2, :tel_mobi_3, :status_SendAdd)";
        $res = $this->_contextMitsu->prepare($sql)->execute($data);
        return $res;
    }

    private function saveToTableAct($model)
    {
        $dataAct = $this->_genAct[$this->_genCarTypeId];
        $data = [
            'id_data' => $model->idData,
            'p_id' => $dataAct->ActApiTypeCode,
            'p_pre' => $dataAct->pre_act,
            'p_stamp' => $dataAct->stamp_act,
            'p_tax' => $dataAct->tax_act,
            'p_net' => $dataAct->net_act,
        ];
        $sql = "INSERT INTO `act` (id_data,p_id,p_pre,p_stamp,p_tax,p_net) VALUES (:id_data, :p_id, :p_pre, :p_stamp, :p_tax, :p_net)";
        $res = $this->_contextMitsu->prepare($sql)->execute($data);
        return $res;
    }

    private function saveToTableReq($model)
    {
        $data = [
            'id_data' => $model->idData
        ];
        $sql = "INSERT INTO `req` (id_data) VALUES (:id_data)";
        $res = $this->_contextMitsu->prepare($sql)->execute($data);
        return $res;
    }

    private function saveToTableDriver($model)
    {
        $data = [
            'id_data' => $model->idData
        ];
        $sql = "INSERT INTO `driver` (id_data) VALUES (:id_data)";
        $res = $this->_contextMitsu->prepare($sql)->execute($data);
        return $res;
    }

    private function saveToTableDetailRenew($model, $cost)
    {

        $dataAct = $this->_genAct[$this->_genCarTypeId];
        $detailCost = "{$cost->sumAssured}|1|ไม่ระบุผู้ขับขี่|0|0|0|0|0|{$cost->total}|{$dataAct->net_act}|{$cost->pre}|0|1|{$cost->total}";
        $toDay = date('Y-m-d H:i:s');
        $data = [
            'id_data' => $model->idData,
            'status' => 'F',
            'detailtext' => 'ใบเตือนต่ออายุ',
            'detail_doc_type' => $this->_docType,
            'userdetail' => $this->_position,
            'renew_comp' => 'VIB_S',
            'detailcost' => $detailCost,
            'renew_ptype' => $cost->protect_type,
            'renew_product' => $cost->prod_name,
            'renew_id_cost' => $cost->id_cost,
            'doc_type' => $this->_docType,
            'date_alert' => $toDay,
            'time_call' => $toDay,
            'lastrenew' => 1,
            'end_date' => $model->endDate
        ];
        $sql = "INSERT INTO `detail_renew` (id_data, `status`, detailtext, detail_doc_type, userdetail, renew_comp, 
        detailcost, renew_ptype, renew_product, renew_id_cost, doc_type, date_alert, timecall, lastrenew, end_date) 
        VALUES (:id_data, :status, :detailtext, :detail_doc_type, :userdetail, :renew_comp, :detailcost, :renew_ptype, 
        :renew_product, :renew_id_cost, :doc_type, :date_alert, :time_call, :lastrenew, :end_date)";
        $res = $this->_contextMitsu->prepare($sql)->execute($data);
        return $res;
    }

    private function mappingToModel($data) //excel upload muti
    {
        $model = new ImportExcelFileRenewModelRequest();
        $saka = $this->findSaka($this->_user); //ค้นสาขา
        $dataObj = (object)$data; // convert data to object
        //ตัดหา เลขตัวถัง
        // $arrCarModel = $this->separateCarModel(trim($dataObj->B));//edit wait
        $objCarModel = $this->findModelCar($dataObj->AM, $dataObj->AA);
        $model->modelCar = $objCarModel->id_mo_car;
        $model->modelCarSub = $objCarModel->id;
        $model->carPrice = $objCarModel->price_car;
        $model->carTypeId = $objCarModel->carType;

        // $model->CarSubID = $objCarModel->id;

        $model->idData = ($saka) ? $this->generatIdDataBySaka($saka) : $this->generatIdData();
        // $model->carTypeId = trim($dataObj->A);//ไม่มี id ประเภทรถส่งมา
        $model->carMotor = trim($dataObj->AB);
        $model->carBody = trim($dataObj->AA);
        $model->yearCar = $this->getYear($dataObj->AC); //($dataObj->E == '') ? $this->genFullYearCar($dataObj->G) : $dataObj->E;//ปีรถ
        $model->cc = ''; //$dataObj->F;

        $model->startDate = $this->genStartDate($dataObj->AC);
        $model->endDate = $this->genDateYMD($model->startDate);
        $model->sendDate = $this->genSendDate($model->startDate);

        $model->beneficiary = !empty($dataObj->AP) ? trim($dataObj->AP) : 'ไม่ระบุ';

        $modelFullName = $this->genFullName($dataObj->E, $dataObj->F, $dataObj->G); //รวมชื่อออกมาพร้อมใช้งาน
        $model->titleName = $modelFullName->title;
        $model->firstName = $modelFullName->name;
        $model->lastName = $modelFullName->lastName;

        $model->houseNumber = (string)str_replace(array(' ', "'"), '', $dataObj->P);
        $model->alley = (string)trim($dataObj->U);
        $model->road = (string)trim($dataObj->V);
        $model->tumbon = (string)trim($dataObj->W);
        $model->amphur = (string)trim($dataObj->X);
        $model->province = (string)trim($dataObj->Y);
        $model->postalCode = (string)trim($dataObj->Z);
        $model->phoneNumber1 = (string)str_replace(array(' ', "'", '-'), '', $dataObj->N);
        $model->phoneNumber2 = ''; //(string)$dataObj->S;
        $model->phoneNumber3 = ''; //(string)$dataObj->T;
        $model->carRegis = $this->genCarRegis('');
        $model->carColor = 'ไม่ระบุ';
        $model->carRegisPro = 102;
        $model->carCC = 1;
        $model->carSeat = 7;
        $model->carweight = 3;
        $model->gear = 'A';
        $model->catCar = $this->genCatCar($model->carTypeId);
        $model->sort = $this->genInsuranceCode($dataObj->AV);
        $model->text = $model->concatmodel();
        $model->Branch = (string)$dataObj->C;
        $model->idCard = (string)str_replace(array(' ', "'", '-'), '', $dataObj->I);
        $model->person = trim($dataObj->DB);
        return $model;
    }

    private function mappingOtherToModel($data) //excel upload muti
    {

        $model = new ImportExcelFileRenewModelRequest();

        $saka = $this->findSaka($this->_user); //ค้นสาขา

        $dataObj = (object)$data; // convert data to object

        //ตัดหา เลขตัวถัง
        // $arrCarModel = $this->separateCarModel(trim($dataObj->B));//edit wait
        $objCarModel = $this->findModelCar($dataObj->AJ, $dataObj->Z); //หารุ่นรถหา  ID รถ ราคารถและชนิดรถเลย

        $model->modelCar = $objCarModel->id_mo_car;
        $model->modelCarSub = $objCarModel->id;
        $model->carPrice = $objCarModel->price_car;
        $model->carTypeId = $objCarModel->carType;

        // $model->CarSubID = $objCarModel->id;

        $model->idData = ($saka) ? $this->generatIdDataBySaka($saka) : $this->generatIdData();

        // $model->carTypeId = trim($dataObj->A);//ไม่มี id ประเภทรถส่งมา

        $model->carMotor = trim($dataObj->AA);
        $model->carBody = trim($dataObj->Z);
        $model->yearCar = empty($dataObj->AH) ? date('Y') - 1 : $dataObj->AH; //ปีรถ

        $model->cc = ''; //$dataObj->F;

        $model->startDate = $this->genOtherStartDate($dataObj->AB); //วันเริ่มคุ้มครอง
        $model->endDate = $this->genDateYMD($model->startDate); //วันสิ้นสุดวันคุ้มครอง
        $model->sendDate = $this->genSendDate($model->startDate); //วันที่แจ้งงาน

        $model->beneficiary = 'ไม่ระบุ';

        $modelFullName = $this->genFullName($dataObj->D, $dataObj->E, $dataObj->F); //รวมชื่อออกมาพร้อมใช้งาน
        $model->titleName = $modelFullName->title;
        $model->firstName = $modelFullName->name;
        $model->lastName = $modelFullName->lastName;

        $model->houseNumber = (string)str_replace(array(' ', "'"), '', $dataObj->N);
        $model->alley = (string)trim($dataObj->S);
        $model->road = (string)trim($dataObj->T);
        $model->tumbon = (string)trim($dataObj->U);
        $model->amphur = (string)trim($dataObj->V);
        $model->province = (string)trim($dataObj->W);
        $model->postalCode = (string)trim($dataObj->X);
        $model->phoneNumber1 = (string)str_replace(array(' ', "'", '-'), '', $dataObj->L);
        $model->phoneNumber2 = '';
        $model->phoneNumber3 = '';
        $model->carRegis = $dataObj->AH;
        $model->carColor = 'ไม่ระบุ';
        $model->carRegisPro = 102;
        $model->carCC = 1;
        $model->carSeat = 7;
        $model->carweight = 3;
        $model->gear = 'A';
        $model->catCar = $this->genCatCar($model->carTypeId);
        $model->sort = 'VIB_S';
        $model->text = $model->concatmodel();
        $model->Branch = (string)$this->_user;
        $model->idCard = empty($dataObj->G) ? '' : (string)str_replace(['-', '', '/'], '', $dataObj->G);
        return $model;
    }

    private function mappingToModelSingle($dataObj)
    {
        $model = new ImportExcelFileRenewModelRequest();
        $model->idData = $this->generatIdData();
        $saka = $this->findSaka($this->_user); //ค้นสาขา
        $model->idData = ($saka) ? $this->generatIdDataBySaka($saka) : $this->generatIdData();
        $model->modelCar = trim($dataObj->moCar);
        $model->modelCarSub = trim($dataObj->subMoCar);
        $model->carBody = trim($dataObj->chassisNumber);
        $model->carMotor = trim($dataObj->serialNumber);
        $model->yearCar = $dataObj->regisDate;
        $model->cc = $dataObj->CC;
        $model->startDate = $this->genStartDate($dataObj->endDate);
        $model->endDate = $this->genNewEndDateYMD($model->startDate);
        $model->sendDate = $this->genSendDate($model->startDate);
        $model->beneficiary = $dataObj->beneficiary;
        $model->titleName = $dataObj->title;
        $model->firstName = $dataObj->name;
        $model->lastName = $dataObj->last;
        $model->houseNumber = $dataObj->add;
        $model->alley = $dataObj->lane;
        $model->road = $dataObj->road;
        $model->tumbon = $dataObj->tumbon;
        $model->amphur = $dataObj->amphur;
        $model->province = $dataObj->province;
        $model->postalCode = $dataObj->postal;
        $model->phoneNumber1 = $dataObj->telMobile;
        $model->phoneNumber2 = $dataObj->telMobile2;
        $model->phoneNumber3 = $dataObj->telMobile3;
        $model->carRegis = $dataObj->regisCard;
        $model->carColor = 'ไม่ระบุ';
        $model->carRegisPro = $dataObj->carRegisProvince;
        $model->carCC =  $dataObj->CC;
        $model->carSeat =  $dataObj->seat;
        $model->carweight =  $dataObj->weight;
        $model->gear = 'A';
        $model->catCar = sprintf("%02d", $dataObj->carType);
        $model->idCard = trim($dataObj->cardID);
        $model->person = trim($dataObj->personID);
        $model->text = $model->concatmodel();
        return $model;
    }
    private function genStartDate($endDate)
    {
        $dateCls = str_replace(array('-', ' '), '', $endDate);
        $dateNew = date('Y-m-d', strtotime($dateCls));
        // $newFormat = date('Y-m-d', strtotime($dateNew . '-1 years'));
        return $dateNew;
    }

    private function genOtherStartDate($endDate)
    {
        $dateCls = str_replace(array('-', ' '), '', $endDate);
        $dateNew = date('Y-m-d', strtotime($dateCls));
        $newFormat = date('Y-m-d', strtotime($dateNew . '-1 years'));
        return $newFormat;
    }

    private function genDateYMD($endDate)
    {
        $newFormat = date('Y') . '-' . date('m-d', strtotime($endDate));
        return $newFormat;
    }

    private function genNewEndDateYMD($endDate)
    {
        $newFormat = $newFormat = date('Y-m-d', strtotime($endDate . '+1 years'));
        //date('Y') . '-' . date('m-d', strtotime($endDate));
        return $newFormat;
    }

    private function genSendDate($startDate)
    {
        // $dt = new DateTime($startDate);
        $genDate = date('Y-m-d', strtotime($startDate . '-1 day'));
        return $genDate;
    }

    private function genCarTypeId($model)
    {
        $result = '';
        if ($model->MakeTyte1 == 1) {
            $result = '110';
        }

        if ($model->MakeTyte2 == 2) {
            $result = '210';
        }

        if ($model->MakeTyte3 == 3) {
            $result = '320';
        }
        return $result;
    }

    private function genCatCarId($catCar)
    {
        $result = '';
        if ($catCar == '01') {
            $result = '110';
        }

        if ($catCar == '02') {
            $result = '210';
        }

        if ($catCar == '03') {
            $result = '320';
        }
        return $result;
    }

    private function genCatCar($carType)
    {
        $result = '';
        $check = substr(strval($carType), 0, 1);
        switch ($check) {
            case '1':
                $result = '01';
                break;
            case '2':
                $result = '12';
                break;
            case '3':
                $result = '03';
                break;
            default:
                $result = '01';
                break;
        }
        return $result;
    }

    private function genQuickFindDataArrayAct()
    {
        $sql = "SELECT * FROM tb_act";
        $res = $this->_contextFour->query($sql)->fetchAll(5);
        $arr = [];
        foreach ($res as $x) {
            $arr[$x->id_act] = $x;
        }
        return $arr;
    }

    private function genNameInForm($user)
    {
        $sql = "SELECT CONCAT(title_sub,' ',sub) as fullName FROM tb_customer WHERE `user` = '$user' LIMIT 1";
        $res = $this->_contextMitsu->query($sql)->fetch(7);
        return $res;
    }

    private function genCostFormFour($modelCar, $sumAssured, $carOld)
    {
        $dateNow = date('Y-m-d');
        $sql = "SELECT
                    tb_cost.id AS id_cost ,
                    tb_cost.car_id ,
                    tb_cost.cost ,
                    tb_cost.cost_end ,
                    tb_cost.pre ,
                    tb_cost.total ,
                    tb_cost.`repair` ,
                    tb_cost.mocargroup ,
                    tb_cost.prod_name,
                    tb_cost.protect_type ,
                    MIN(tb_cost.pre) AS preMin,
                    '' AS sumAssured
                FROM
                    tb_cost
                    LEFT JOIN tb_cost_mocar ON ( tb_cost.mocargroup = tb_cost_mocar.namegroup )
                    LEFT JOIN tb_comp ON ( tb_cost.comp = tb_comp.sort ) 
                WHERE
                    $carOld BETWEEN tb_cost.car_old 
                    AND tb_cost.car_old_end 
                    AND tb_cost.create_date <= '$dateNow' AND tb_cost.date_expired >= '$dateNow' 
                    AND tb_cost.worktype IN ( 'N', 'A' ) 
                    AND tb_cost_mocar.cmocar IN ( '$modelCar', 'ALL' ) 
                    AND ( $sumAssured BETWEEN cost AND cost_end ) 
                    AND tb_cost.car_id = '$this->_genCarTypeId' 
                    AND tb_cost.`repair` = 1
                    AND tb_cost.insured_type = '$this->_docType' 
                    AND tb_cost.sumAssuredStatus <> 2 
                    AND comp = 'VIB_S'
                GROUP BY
                    tb_cost.`repair`,
                    tb_cost_mocar.namegroup,
                    tb_cost.pre,
                    tb_cost_mocar.cmocar 
                ORDER BY
                    tb_cost.id DESC,
                    tb_cost.`total` DESC";
        $this->_costQueryArr[] = $sql;
        $res = $this->_contextFour->query($sql)->fetch(5);
        if ($res) {
            $res->action = true;
            return $res;
        } else {
            return new CostModelDefault();
        }
    }

    private function genSumAssured($modelCar, $carOld, $price)
    {
        $sql = "SELECT
                    gc.fixcost,
                    gc.fixcostend
                FROM
                    tb_mocar_group g
                    INNER JOIN tb_mocar_group_cost gc ON ( g.mggroup = gc.mggroup ) 
                WHERE
                    g.brcar = '$this->_brCar' 
                    AND gc.carold = $carOld 
                    AND g.mocar IN ( '$modelCar', 'ALL' ) 
                    AND (	g.mgstatus = 'Y')";
        $res = $this->_contextFour->query($sql)->fetch(5);

        $fixCostPercent = ceil(($price * (int)$res->fixcost) / 100);
        $fixCostEndPercent = ceil(($price * (int)$res->fixcostend) / 100);
        $startCost = round($fixCostPercent, -4);
        $endCost = round($fixCostEndPercent, -4);
        $totalCostPercent = round((($startCost + $endCost) / 2), -4); //ทุนประกันภัย
        return $totalCostPercent;
    }

    private function genYearCar($year)
    {
        $yearNow = (int)date('Y');
        if ($year >= $yearNow) //ถ้าปีรถมากกว่าหรือเท่ากับ ปีปัจจุบัน ปัดลงมา
        {
            $year = $year - 1;
        }
        //set ปีจดทะเบียนรถใหม่ทุกครั้งหลังจากคำนวณหาปีรถแล้ว
        $this->_setYearCar = $year;

        $yearNumber = ($yearNow - (int)$year) + 1;
        return $yearNumber;
    }

    private function separateCarModel($name)
    {
        $str = str_replace('_', ' ', $name);
        return explode(' ', $str, 2);
    }

    private function genFullYearCar($endDate)
    {
        $newFormat = date('Y', strtotime($endDate));
        return $newFormat - 1;
    }

    private function genFullName($title, $name, $last)
    {
        $model = new stdClass();

        $model->title = empty($title) ? 'คุณ' : trim($title);
        $model->name = $name;
        $model->lastName = $last;

        #region concat old
        /*
        $fullName = explode(' ', $name, 3);
        $model = new stdClass();
        if (count($fullName) < 2) {
            $model->title = 'คุณ';
            $model->name = $fullName[0];
            $model->lastName = '';
        }

        if (count($fullName) == 2) {
            $model->title = $fullName[0];
            $model->name = $fullName[1];
            $model->lastName = '';
        }

        if (count($fullName) > 2) {
            $model->title = $fullName[0];
            $model->name = $fullName[1];
            $model->lastName = $fullName[2];
        }*/
        #endregion

        return $model;
    }

    private function genCarRegis($regis)
    {
        $newFormat = (empty($regis)) ? 'ป้ายดำ' : str_replace('ล็อกเลข', '', $regis);
        return trim($newFormat);
    }

    private function genInsuranceCode($name)
    {
        $nameval = trim($name);
        $sql = "SELECT sort FROM tb_comp WHERE name_print LIKE '%$nameval%' AND use_comp = 1 LIMIT 1";
        $res = $this->_contextFour->query($sql)->fetch(5);
        $done = (empty($res->sort)) ? 'VIB_S' : $res->sort;
        return $done;
    }

    private function saveLogImportData($idData, $text, $modelSub, $idModelSub_four)
    {
        $data = [
            'Text' => $text,
            'IdData' => $idData,
            'DateTimeStamp' => date("Y-m-d H:i:s"),
            'ModelSub' => $modelSub,
            'IdModelSub_four' => $idModelSub_four
        ];
        $sql = "INSERT INTO log_imported_data (`Text`, IdData, DateTimeStamp, ModelSub, IdModelSub_four) VALUES (:Text, :IdData, :DateTimeStamp, :ModelSub, :IdModelSub_four)";
        $this->_contextMitsu->prepare($sql)->execute($data);
    }

    private function get_numerics($str)
    {
        preg_match_all('/\d+/', $str, $matches);
        return $matches[0];
    }

    public function getTempText($model)
    {
        $sql = "SELECT `Text` FROM log_imported_data WHERE IdData = '$model->idData'";
        $res = $this->_contextMitsu->query($sql)->fetch(7);
        return $res;
    }

    public function checkSumAssured($brCar, $modelCar, $carOld, $price)
    {
        $sql = "SELECT
                    gc.fixcost,
                    gc.fixcostend
                FROM
                    tb_mocar_group g
                    INNER JOIN tb_mocar_group_cost gc ON ( g.mggroup = gc.mggroup ) 
                WHERE
                    g.brcar = '$brCar' 
                    AND gc.carold = $carOld 
                    AND g.mocar IN ( '$modelCar', 'ALL' ) 
                    AND g.mgstatus = 'Y'";
        $res = $this->_contextFour->query($sql)->fetch(5);

        $fixCostPercent = ceil(($price * (int)$res->fixcost) / 100);
        $fixCostEndPercent = ceil(($price * (int)$res->fixcostend) / 100);
        $startCost = round($fixCostPercent, -4);
        $endCost = round($fixCostEndPercent, -4);
        $totalCostPercent = round((($startCost + $endCost) / 2), -4); //ทุนประกันภัย
        return $totalCostPercent;
    }

    public function fixBugCost($carType, $brID, $carId, $price, $json)
    {
        $resDetail = $this->getDetailCar($json);
        $arr = array();
        $this->_genAct = $this->genQuickFindDataArrayAct();
        foreach ($resDetail as $x) {
            $genYear = $this->genYearCar($x->regis_date);
            $sumAssured = $this->checkSumAssured($brID, $carId, $genYear, $price);
            $costNew = $this->fixBugCostFormFour($carId, $sumAssured, $genYear, $carType);
            $arr[$x->id_data] = $this->updateToTableDetailRenew($x->id_data, $costNew, $sumAssured, $carType);
        }
        return $arr;
    }
    public function fixBugCostEndDateRegisCar($carType, $brID, $carId, $json, $changeYear)
    {
        $this->_arrModelSubAll = $this->getModelSubAll();
        $resDetail = $this->getDetailCar($json);
        if (!$resDetail) {
            return 'ไม่พบข้อมูลใน log';
        }
        $arr = array();
        $this->_genAct = $this->genQuickFindDataArrayAct();

        foreach ($resDetail as $x) {
            // $resWrongYearCheck = $this->wrongYearCheck($x->startDate,"$x->regis_date",$x->id_data);
            // if(!$resWrongYearCheck){
            //     $arr['resWrongYearCheck'][$x->id_data] = $resWrongYearCheck;
            //     continue;
            // }
            // $x->regis_date = $resWrongYearCheck;
            $price = intval($this->_arrModelSubAll['priceCar'][trim($x->IdModelSub_four)]);
            $changeRegisDate = (int)$x->regis_date - $changeYear;
            $genYear = $this->genYearCar($changeRegisDate);
            $updateEndDate = $this->_reSolveEndDateService->genNewDate($x->sendDate, $x->startDate, $x->endDate, $x->id_data);
            $sumAssured = $this->calculateCostYearByNing($genYear, $price);

            if (!$sumAssured) {
                $arr['sumAssured-no'][$x->id_data] = $sumAssured;
                $arr['genYear-no'][$x->id_data] = $genYear;
                $arr['price-no'][$x->id_data] = $price;
                $arr['IdModelSub_four-no'][$x->id_data] = $x->IdModelSub_four;
                continue;
            }

            $costNew = $this->fixBugCostFormFour($carId, $sumAssured, $genYear, $carType);
            // $arr['updateRegisDateToDetail'][$x->id_data] = $this->updateRegisDateToDetail($x->id_data, $changeRegisDate);

            if (!$costNew) {
                // $this->_reSolveEndDateService->updateChangeCost($x->id_data,1);
                $arr['updateToTableDetailRenew-no'][$x->id_data] = $this->updateToTableDetailRenew($x->id_data, false, $sumAssured, $carType, $updateEndDate->newEndDate);
                continue;
            }
            /*$arr['costNew'][$x->id_data] = $costNew;
            $arr['sumAssured'][$x->id_data] = $sumAssured;
            $arr['updateEndDateToTableData'][$x->id_data] = $updateEndDate;*/

            // $arr['updateRegisDateToDetail'][$x->id_data] = $this->updateRegisDateToDetail($x->id_data, $changeRegisDate);
            $this->_reSolveEndDateService->updateChangeCost($x->id_data, 2);
            $arr['updateToTableDetailRenew'][$x->id_data] = $this->updateToTableDetailRenew($x->id_data, $costNew, $sumAssured, $carType, $updateEndDate->newEndDate);
            $arr['updateEndDateToTableData'][$x->id_data] = $this->updateEndDateToTableData($updateEndDate, $x->id_data, $costNew->id_cost);
        }
        return $arr;
    }

    public function getDetailCar($json)
    {
        $sql = "SELECT detail.car_id,DATE(data.send_date) as sendDate,data.start_date AS startDate,data.end_date AS endDate,log_imported_data.IdModelSub_four,detail.mo_car,detail.regis_date,detail_renew.* 
        FROM detail 
        INNER JOIN data ON ( data.id_data = detail.id_data )
        INNER JOIN detail_renew ON(detail.id_data = detail_renew.id_data) 
        INNER JOIN log_imported_data ON ( detail.id_data = log_imported_data.idData ) 
        WHERE detail.id_data REGEXP '$json'";

        $res = $this->_contextMitsu->query($sql)->fetchAll(5);
        return $res;
    }

    private function fixBugCostFormFour($modelCar, $sumAssured, $carOld, $catCar)
    {
        $dateNow = date('Y-m-d');
        $sql = "SELECT
                    tb_cost.id AS id_cost ,
                    tb_cost.car_id ,
                    tb_cost.cost ,
                    tb_cost.cost_end ,
                    tb_cost.pre ,
                    tb_cost.total ,
                    tb_cost.repair ,
                    tb_cost.mocargroup ,
                    tb_cost.prod_name,
                    tb_cost.protect_type ,
                    MIN(tb_cost.pre) AS preMin,
                    '' AS sumAssured
                FROM
                    tb_cost
                    LEFT JOIN tb_cost_mocar ON ( tb_cost.mocargroup = tb_cost_mocar.namegroup )
                    LEFT JOIN tb_comp ON ( tb_cost.comp = tb_comp.sort ) 
                WHERE
                    $carOld BETWEEN tb_cost.car_old 
                    AND tb_cost.car_old_end 
                    AND tb_cost.create_date <= '$dateNow' AND tb_cost.date_expired >= '$dateNow' 
                    AND tb_cost.worktype IN ( 'N', 'A' ) 
                    AND tb_cost_mocar.cmocar IN ( '$modelCar', 'ALL' ) 
                    AND ( $sumAssured BETWEEN cost AND cost_end ) 
                    AND tb_cost.car_id = '$catCar' 
                    AND tb_cost.`repair` = 1
                    AND tb_cost.insured_type = '1' 
                    AND tb_cost.sumAssuredStatus <> 2 
                    AND comp = 'VIB_S'
                GROUP BY
                    tb_cost.`repair`,
                    tb_cost_mocar.namegroup,
                    tb_cost.pre,
                    tb_cost_mocar.cmocar 
                ORDER BY
                    tb_comp.`name` DESC,
                    tb_cost.`total` DESC";
        $res = $this->_contextFour->query($sql)->fetch(5);
        return $res;
    }

    private function updateToTableDetailRenew($idData, $cost, $sumAssured, $carType, $newEndDate)
    {
        $dataAct = $this->_genAct[$carType];
        $detailCost = "{$sumAssured}|1|ไม่ระบุผู้ขับขี่|0|0|0|0|0|0|{$dataAct->net_act}|0|0|1|0";
        if ($cost) {
            $totalPrePrb = ($cost->total + $dataAct->net_act);
            $detailCost = "{$sumAssured}|1|ไม่ระบุผู้ขับขี่|0|0|0|0|0|{$totalPrePrb}|{$dataAct->net_act}|{$cost->pre}|0|1|{$cost->total}";
        }
        $toDay = date('Y-m-d H:i:s');
        /*$data = [
            'id_data' => $idData,
            'status' => 'F',
            'detailcost' => $detailCost,
            'renew_ptype' => $cost->protect_type,
            'renew_product' => $cost->prod_name,
            'renew_id_cost' => $cost->id_cost,
            'time_call' => date("Y-m-d H:i:s")
        ];
        $sql = "UPDATE `detail_renew` SET detailcost:detailcost, renew_ptype:renew_ptype, renew_product:renew_product, renew_id_cost:renew_id_cost, timecall:time_call WHERE id_data:id_data AND status:status";*/
        $sql = "UPDATE `detail_renew` SET detailcost = '{$detailCost}', renew_ptype = '{$cost->protect_type}', renew_product = '{$cost->prod_name}', renew_id_cost = '{$cost->id_cost}', date_detail = '{$toDay}', timecall = '{$toDay}', end_date = '{$newEndDate}' WHERE id_data = '{$idData}' AND status = 'F'";
        $res = $this->_contextMitsu->prepare($sql)->execute();
        return $res;
    }

    private function updateEndDateToTableData($model, $idData, $idCost)
    {
        $sql = "UPDATE `data` SET send_date = '{$model->newSendDate}', start_date = '{$model->newStartDate}', end_date = '{$model->newEndDate}', costCost = '{$idCost}' WHERE `data`.id_data = '$idData' ";

        $res = $this->_contextMitsu->prepare($sql)->execute();
        return $res;
    }
    private function updateRegisDateToDetail($idData, $regis)
    {
        $sql = "UPDATE `detail` SET regis_date = '{$regis}' WHERE `detail`.id_data = '$idData' ";
        $res = $this->_contextMitsu->prepare($sql)->execute();
        return $res;
    }

    private function findSaka($user)
    {
        $sql = "SELECT saka FROM tb_customer WHERE user LIKE '%$user'";
        return $this->_contextMitsu->query($sql)->fetch(7);
    }
    private function getModelSubAll()
    {
        $sql = "SELECT * FROM tb_car_model_sub";
        $result = $this->_contextFour->query($sql)->fetchAll(2);
        foreach ($result as $r) {
            $arr['name'][$r['id']] = $r['name'];
            $arr['priceCar'][$r['id']] = $r['price_car'];
        }
        return $arr;
    }

    public function findModelCar($prdCode, $carBody)
    {
        $prdCodeN = trim($prdCode);
        $carBodyN = substr(trim($carBody), 0, 9);
        $res = $this->findModelCarByPRN($prdCodeN);
        return !$res ? $this->findModelCarByCBF($carBodyN) : $res;
    }

    public function findModelCarByPRN($prdCodeN)
    {
        $sql = "SELECT
            ModelCarMitsubishi.idCarModelSub,
            ModelCarMitsubishi.carType,
            tb_car_model_sub.id_mo_car,
            tb_car_model_sub.price_car,
            tb_car_model_sub.id
        FROM
            ModelCarMitsubishi
            INNER JOIN tb_car_model_sub ON ( tb_car_model_sub.id = ModelCarMitsubishi.idCarModelSub ) 
        WHERE
            ModelCarMitsubishi.prdCode LIKE '%$prdCodeN%' ";
        $res = $this->_contextFour->query($sql)->fetch(5);
        return $res;
    }

    public function findModelCarByCBF($carBody)
    {
        $sql = "SELECT
                    ModelCarMitsubishi.idCarModelSub,
                    ModelCarMitsubishi.carType,
                    tb_car_model_sub.id_mo_car,
                    tb_car_model_sub.price_car,
                    tb_car_model_sub.id 
                FROM
                    ModelCarMitsubishi
                    INNER JOIN tb_car_model_sub ON ( tb_car_model_sub.id = ModelCarMitsubishi.idCarModelSub ) 
                WHERE
                    ModelCarMitsubishi.carBodyFormat LIKE '%$carBody%'";
        $res = $this->_contextFour->query($sql)->fetch(5);
        return $res;
    }

    public function chassisNumberAllByDealer()
    {
        $sql = "SELECT detail.car_body FROM `data` INNER JOIN detail ON(detail.id_data = `data`.id_data) 
            WHERE `data`.`login` = '{$this->_user}'";

        $res = $this->_contextMitsu->query($sql)->fetchAll(5);
        $arr = array();
        foreach ($res as $x) {
            $arr[trim($x->car_body)]  = true;
        }
        return $arr;
    }

    public function checkBranchUpload($valueArr)
    {

        //TODO นับ branch/แยก
        $branchinfos = [];
        $readExcBranchs = [];
        //นับ branch ใน master
        foreach ($valueArr as $val) {
            $v = (object)$val;
            $branchinfos[$v->C] = $v->C;
        }

        $y = 0;
        //แยก branch และ child ออกมาก่อน
        foreach ($branchinfos as $b) {
            $i = 0;
            foreach ($valueArr as $val) {
                $v = (object)$val;
                if ($b == $v->C) {
                    $readExcBranchs[$y][$i] = $v;
                    $i++;
                }
            }
            $y++;
        }
        return $readExcBranchs;
    }

    private function findCarPriceByID($id)
    {
        //TODO หาราคารถ จากรหัสรุ่นย่อย
        $sql = "SELECT price_car,gear FROM tb_car_model_sub WHERE id = '$id'";
        $res = $this->_contextFour->query($sql)->fetch(5);
        return $res;
    }
    private function checkPerson($type)
    {
        $x = true;
        switch ($type) {
            case '1':
                $x = true;
                break;
            case '2':
                $x = false;
                break;
            case 'บุคคลธรรมดา':
                $x = true;
                break;
            case 'นิติบุคคล':
                $x = false;
                break;
        }
        return $x;
    }

    public function calculateCostYearByNing($yaer, $fund)
    {
        for ($i = 1; $i <= $yaer; $i++) {
            $fund = $this->roundNing(($fund * 0.90), -4);
        }
        return $fund;
    }

    public function roundNing($cost, $index = 1)
    {
        // สูตรคำนวณกรณีหลักล้านขึ้นไป
        $numlength = strlen($cost);
        if ($numlength >= 7) {
            $x = ($numlength * -1) + 2;
            return round($cost, $x);
        }
        $newstring = substr($cost, $index);
        if (intval($newstring) != 0) {
            $newstring = intval($cost) + (10000 - $newstring);
        } else {
            $newstring = $cost;
        }
        return $newstring;
    }

    public function genYearCarForCost($year)
    {
        $yearNow = (int)date('Y');
        $yearNumber = ($yearNow - (int)$year) + 1;
        return $yearNumber;
    }

    public function wrongYearCheck($startDate, $regisCarOld, $idData)
    {
        $arrDate = explode("-", $startDate);
        if ("$arrDate[0]" != $regisCarOld) {
            $sql = "UPDATE `detail` SET regis_date = '2021' WHERE `detail`.id_data = '$idData' ";
            $res = $this->_contextMitsu->prepare($sql)->execute();
            return "2021";
        }
        return false;
    }

    public function getYear($date)
    {
        $year = substr("$date", 0, 4);
        return intval($year);
    }
}
