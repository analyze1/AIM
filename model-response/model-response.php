<?php

class InfoProvince
{
    public $id;
    public $oic;
}

class CarProvince
{
    private $rowCarProvince;

    public function __construct()
    {
        $this->rowCarProvince[] = array();
        $this->loadinfo();
    }

    public function calculate()
    {
        return count($this->rowCarProvince);
    }

    private function loadinfo()
    {
        $_contextMitsu = PDO_CONNECTION::fourinsure_mitsu();

        $sqlprovcar = "SELECT * FROM tb_province order by id desc";
        $objProvcar = $_contextMitsu->query($sqlprovcar)->fetchAll();

        foreach ($objProvcar as $row) {
            $add = new InfoProvince();
            $add->id = $row["id"];
            $add->oic = $row["province_code_oic"];
            array_push($this->rowCarProvince, $add);
        }

        $_contextMitsu = null;
    }

    public function getOicCarprovinceById($id)
    {
        $_round = count($this->rowCarProvince);
        for ($top = 0; $top < $_round; $top++) {
            if ($this->rowCarProvince[$top]->id == $id) {
                return $this->rowCarProvince[$top]->oic;
            }
        }
    }
}

class ResponseApiModel
{
    public $Result;
    public $ErrorCode;
    public $ErrorMsg;
    public $PolicyNo;
    public $BarcodeNo;
    public $PolicyUrl;
    public function __construct()
    {
    }

    public function mapResult($value)
    {
        $_str = json_encode($value->body);
        $file = fopen('../model-response/Text_log_API/text' . date('Y-m-d') . '.txt', 'a+');
        $str =  iconv('UTF-8', 'tis-620', $_str);
        fwrite($file, $str);
        fclose($file);

        $this->Result = $value->body->result;
        $this->ErrorCode = $value->body->errorCode;
        $this->ErrorMsg = $value->body->errorMsg;
        $this->PolicyNo = $value->body->policyNo;
        $this->PolicyUrl = $value->body->policyUrl;
        $this->BarcodeNo = $value->body->barcodeNo;
    }

    public function apiresponse()
    {
        $response = array(
            'Result' => "{$this->Result}",
            'ErrorCode' => "{$this->ErrorCode}",
            'ErrorMsg' => "{$this->ErrorMsg}",
            'PolicyNo' => "{$this->PolicyNo}",
            'BarcodeNo' => "{$this->BarcodeNo}",
            'PolicyUrl' => "{$this->PolicyUrl}"
        );
        return $response;
    }
}

class CalculatePremium
{
    private $stamp;
    private $vat;
    private $result;
    private $pre;

    public function __construct()
    {
    }

    public function getActByBase4($vTypeCode)
    {
        $_context4 = PDO_CONNECTION::fourinsure_insured();
        $_sql = "SELECT * FROM tb_act WHERE tb_act.ActApiTypeCode = '$vTypeCode'";
        $_infoAct = $_context4->query($_sql)->fetch();
        return $_infoAct;
    }

    public function calculate($day, $preorigin)
    {
        $sumDays = $day / 365;
        $total = number_format($preorigin * $sumDays);
        $this->pre = $total;
        $stampcal = ($total * 0.4) / 100;
        $stamps = round($stampcal);
        $this->stamp = $stamps;
        $sum = $total + $stamps;
        $vatcal = ($sum * 7) / 100;
        $this->vat = $vatcal;
        $sumtotal = $sum + $vatcal;
        $this->result = $sumtotal;
    }

    public function loadPremium()
    {
        return array(
            'stamp' => $this->stamp,
            'vat' => number_format($this->vat, 2),
            'result' => number_format($this->result, 2),
            'pre' => $this->pre //number_format($this->pre,2)
        );
    }
}

class MitsubishiApiRequestMapModel
{
    public $TransactionId;
    public $Status;
    public $SaleName;
    public $AppSignDate;
    public $EffectiveDate;
    public $ExpiredDate;
    public $PolicyNo;
    public $Barcode;
    public $CardType;
    public $InsuredType;
    public $CardNo;
    public $InsuredBranchCode;
    public $InsuredTitleName;
    public $InsuredName;
    public $InsuredLastName;
    public $InsuredHeadOffice;
    public $Gender;
    public $BirthDate;
    public $Telephone;
    public $MobileNo;
    public $HomeNo;
    public $Building;
    public $Group;
    public $Town;
    public $RoomNo;
    public $Trok;
    public $Soi;
    public $Road;
    public $Tambol;
    public $Amphur;
    public $Postcode;
    public $Province;
    public $LicenseNo;
    public $LicenseProvince;
    public $Chassis;
    public $Engine;
    public $tp_id;
    public $VehicleType;
    public $VehicleMake;
    public $VehicleModel;
    public $VehicleRegYear;
    public $Seat;
    public $CC;
    public $VehicleWeight;
    public $tcar_id;
    public $VehicleCarid;
    public $VehicleUseCode;
    public $NetPremium;
    public $Vat;
    public $Stamp;
    public $GrossPremium;
    public $OnlinePayment_amt;
    public $OnlinePayment_no;
    public $isOnline;
    public $email_customer;
    public $email_agent;
    public $onlinemerchant_id;
    public $agcode;
    public $nowYear;
    public $agYear;
    public $agsaka;
    public $FlagOnline;
    public $Discount;
    public $LicensePlateNo;
    public $DelarCode;

    public function getSuzukiRequestModel()
    {
        $response = array(
            'SaleName' => "{$this->SaleName}",
            'AppSignDate' => "{$this->AppSignDate}",
            'EffectiveDate' => "{$this->EffectiveDate}",
            'ExpiredDate' => "{$this->ExpiredDate}",
            'PolicyNo' => "{$this->PolicyNo}",
            'Barcode' => "{$this->Barcode}",
            'CardType' => "{$this->CardType}",
            'InsuredType' => "{$this->InsuredType}",
            'CardNo' => "{$this->CardNo}",
            'InsuredBranchCode' => "{$this->InsuredBranchCode}",
            'InsuredTitleName' => "{$this->InsuredTitleName}",
            'InsuredName' => "{$this->InsuredName}",
            'InsuredLastName' => "{$this->InsuredLastName}",
            'Gender' => "{$this->Gender}",
            'BirthDate' => "{$this->BirthDate}",
            'Telephone' => "{$this->Telephone}",
            'MobileNo' => "{$this->MobileNo}",
            'HomeNo' => "{$this->HomeNo}",
            'Building' => "{$this->Building}",
            'Group' => "{$this->Group}",
            'Town' => "{$this->Town}",
            'RoomNo' => "{$this->RoomNo}",
            'Trok' => "{$this->Trok}",
            'Soi' => "{$this->Soi}",
            'Road' => "{$this->Road}",
            'Tambol' => "{$this->Tambol}",
            'Amphur' => "{$this->Amphur}",
            'Postcode' => "{$this->Postcode}",
            'Province' => "{$this->Province}",
            'LicenseNo' => "{$this->LicenseNo}",
            'LicenseProvince' => "{$this->LicenseProvince}",
            'Chassis' => "{$this->Chassis}",
            'Engine' => "{$this->Engine}",
            'tp_id' => "{$this->tp_id}",
            'VehicleType' => "{$this->VehicleType}",
            'VehicleMake' => "{$this->VehicleMake}",
            'VehicleModel' => "{$this->VehicleModel}",
            'VehicleRegYear' => "{$this->VehicleRegYear}",
            'Seat' => "{$this->Seat}",
            'CC' => "{$this->CC}",
            'VehicleWeight' => "{$this->VehicleWeight}",
            'tcar_id' => "{$this->tcar_id}",
            'VehicleCarid' => "{$this->VehicleCarid}",
            'VehicleUseCode' => "{$this->VehicleUseCode}",
            'NetPremium' => "{$this->NetPremium}",
            'Vat' => "{$this->Vat}",
            'Stamp' => "{$this->Stamp}",
            'GrossPremium' => "{$this->GrossPremium}",
            'OnlinePayment_amt' => "{$this->OnlinePayment_amt}",
            'OnlinePayment_no' => "{$this->OnlinePayment_no}",
            'isOnline' => "{$this->isOnline}",
            'email_customer' => "{$this->email_customer}",
            'email_agent' => "{$this->email_agent}",
            'onlinemerchant_id' => "{$this->onlinemerchant_id}",
            'agcode' => "{$this->agcode}",
            'nowYear' => "{$this->nowYear}",
            'agYear' => "{$this->agYear}",
            'FlagOnline' => "{$this->FlagOnline}",
            'Discount' => "{$this->Discount}",
            'LicensePlateNo' => "{$this->LicensePlateNo}",
            'TransactionId' => "{$this->TransactionId}",
            'InsuredHeadOffice' => "{$this->InsuredHeadOffice}",
            'agsaka' => "{$this->agsaka}",
            'DelarCode' => "{$this->DelarCode}"
        );
        return $response;
    }

    public function __construct($value, $carProvincevalue, $idData)
    {
        $this->TransactionId = $idData;
        $this->Status = 'POR';
        $this->SaleName = 'สาริตา นิยมไทย';
        $this->AppSignDate = $this->ws_datetime($value['send_date']);
        $this->EffectiveDate = $this->ws_date($value['start_date']);
        $this->ExpiredDate = $this->ws_date($value['end_date']);
        $this->PolicyNo = $value['tmp_act_id'];
        $this->Barcode = $value['barcode_id'];
        $this->checkPerson($value);
        $this->InsuredTitleName = $value['idtitlename'];
        $this->InsuredName = $value['name'];
        $this->InsuredLastName = $value['last'];
        $this->Gender = 'M'; //$value['gender'];
        $this->BirthDate = '';
        $this->InsuredHeadOffice = "Y";
        $this->phoneDumy();
        $this->HomeNo = trim($value['add']);
        $this->Building = $value['town']; //trim($value['add']);
        $this->Group = $value['group'];
        $this->Town = $value['town'];
        $this->RoomNo = "";
        $this->Trok = "";
        $this->Soi = $value['lane'];
        $this->Road = $value['road'];
        $this->Tambol = $value['tumbon_name'];
        $this->Amphur = $value['amphur_name'];
        $this->Postcode = $value['postal'];
        $this->Province = $value['province_code_oic'];
        $this->LicenseNo = $this->checkCarPlate($value['car_regis']);
        $this->LicenseProvince = $carProvincevalue;
        $this->Chassis = $value['car_body'];
        $this->Engine = $value['n_motor'];
        $this->VehicleType = $value['p_id']; //36ประเภทรถ1.30 car_brand  mo_car_name vehicle_type
        $this->VehicleMake = $value['car_brand']; //37ยี่ห้อรถ
        $this->VehicleModel = $value['mo_car_name']; //38รุ่นรถ
        $this->expolCCSeatWg($value['full_mocar']); // หาน้ำหนัก ซีซี และ ที่นั่ง
        $this->VehicleRegYear = $value['regis_date']; //"2012"; //39ปีที่จดทะเบียน
        $this->checkCarId($value['car_id']);
        $this->VehicleUseCode = $this->VehicleCarid;

        /*$date_diff = $this->dateDiff($value['start_date'],$value['end_date']);
        
        if($date_diff < 365)
        {   
            //อาจจะไม่ได้ใช้
            //คุ้มครองไม่ถึงปี
            $objpremium = new CalculatePremium();
            $objpremium->calculate($date_diff,$value['pre']);
            $sumpremium = $objpremium->loadPremium();
            $this->NetPremium = $sumpremium['pre'];
            $this->Vat = $sumpremium['vat'];
            $this->Stamp = $sumpremium['stamp'];
            $this->GrossPremium = $sumpremium['result'];
        }
        else
        {
            //ใช้ข้อมูลที่ดึงจาก P_act Table 
            //คุ้มครองถึงปี
            $this->NetPremium =  (int)$value['p_pre'];
            $this->Vat = str_replace(',','',number_format($value['p_stamp'],2));
            $this->Stamp = (int)$value['p_tax'];
            $this->GrossPremium = str_replace(',','',number_format($value['p_net'],2));
        }*/

        $objpremium = new CalculatePremium();
        $_actRes = $objpremium->getActByBase4($value['p_id']);
        $this->NetPremium = $_actRes['pre_act'];
        $this->Stamp = $_actRes['stamp_act'];
        $this->Vat = $_actRes['tax_act'];
        $this->GrossPremium = $_actRes['net_act'];

        $this->Discount = '0';
        $this->OnlinePayment_amt = "0.00";
        $this->OnlinePayment_no = "";
        $this->isOnline = "N";
        $this->FlagOnline = '1';
        $this->email_customer = "Test@gmail.com";
        $this->email_agent = "Broker@gmail.com";
        $this->onlinemerchant_id = "";
        $this->agcode = "09712"; //"09712";
        $this->nowYear = date('Y') + 543;
        $this->agYear = substr($this->nowYear, 2);
        $this->agsaka = $value['saka'];
        $this->DelarCode = $value['Dealer_code'];
    }

    private function dateDiff($strDate1, $strDate2)
    {
        $dif_Date = (strtotime($strDate2) - strtotime($strDate1)) / (60 * 60 * 24);  // 1 day = 60*60*24
        return round($dif_Date);
    }

    private function checkCarPlate($plate)
    {
        if ($plate == 'ป้ายดำ') {
            return 'B';
        } else {
            return 'R';
        }
    }

    private function expolCCSeatWg($fullMocar)
    {
        $infoArr =  explode('/', $fullMocar);
        $this->Seat = $infoArr[0];
        $this->CC = $infoArr[1];
        $this->VehicleWeight = $infoArr[2];
    }

    private function phoneDumy()
    {
        $ran = rand() . rand() . rand();
        $this->MobileNo = '08' . substr($ran, 1, 8);
        $this->Telephone = '02-' . substr($ran, 1, 7);
    }

    private function checkCarId($reqCarId)
    {
        $tcar_id = $reqCarId;
        $pcarid = substr($tcar_id, 0, 1);
        if ($pcarid == '3' || $pcarid == '2') {
            $this->VehicleCarid = "C";
        } else {
            $this->VehicleCarid = "P";
        }
    }

    private function checkSex($valueSex)
    {
        if ($valueSex != '') {
            $this->Gender = $valueSex;
        } else {
            $this->Gender = "M";
        }
    }

    private function checkPerson($req)
    {
        if ($req['person'] == '1') {
            $this->CardType = "C";
            $this->InsuredType = "P";
        } else if ($req['person'] == '2') {
            $this->CardType = "L";
            $this->InsuredType = "C";
            $this->InsuredBranchCode = "00000"; // รหัสสาขาของผู้เอาประกัน
        } else if ($req['person'] == '3') {
            $this->CardType = "P";
            $this->InsuredType = "P";
        }

        if (!empty($req['icard'])) {
            $this->CardNo = $req['icard']; //P บุคคล C นิติ
        } else {
            $this->CardNo = $req['icard_niti'];
        }
    }

    private function ws_datetime($dt)
    {
        list($date, $time) = explode(' ', $dt); // แยกวันที่ กับ เวลาออกจากกัน
        list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
        list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
        $Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.

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

        //return $Y . "-" . $m . "-" . $d;
        //return $Y.$m.$d.' '.$H.'.'.$i;  //20181001 08.30
        return $Y . $m . $d;
    }

    private function ws_date($dt)
    {
        list($date, $time) = explode(' ', $dt); // แยกวันที่ กับ เวลาออกจากกัน
        list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
        list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
        $Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.

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
        // return $Y . "-" . $m . "-" . $d;
        return $Y . $m . $d;  //20181001
    }
}

class QueryStorePdo
{
    public $SqlCode;
    public function CommandQuery($idData)
    {
        $conn = PDO_CONNECTION::fourinsure_mitsu();
        $sqlCommand = "SELECT detail.car_cat_acc FROM detail WHERE detail.id_data = '$idData'";
        $result = $conn->query($sqlCommand)->fetch(2);
        $rs = $result['car_cat_acc'];

        if ($rs != "") {
            $sqlCommand = "SELECT tb_customer.Dealer_code, tb_customer.saka, data.id,data.doc_type,data.login, data.send_date, data.name_inform, data.id_data, 
            data.o_insure, data.ty_inform, data.start_date, data.end_date, data.name_gain, insuree.icard_niti, insuree.person , insuree.title, insuree.name, insuree.last, 
            insuree.career, insuree.add, insuree.icard, insuree.SendAdd, insuree.group, insuree.town, insuree.lane, insuree.road, insuree.tumbon, insuree.amphur, 
            insuree.province, insuree.postal, insuree.tel_home, insuree.email, tb_tumbon.name as tumbon_name, tb_amphur.name as amphur_name, tb_province.name as province_name, 
            tb_province.province_code_oic, tb_br_car.name as car_brand, tb_cat_car.name as cat_car_name, tb_mo_car.name as mo_car_name, detail.car_cat_acc as car_id, 
            detail.car_color, detail.cc, detail.car_regis, detail.car_regis_pro, detail.car_body, detail.regis_date, detail.car_seat, detail.n_motor, tb_car_prb.pre,
            tb_car_prb.duty,tb_car_prb.vat,tb_car_prb.net,tb_car_prb.vehicle_type, protect.*, tb_mo_car_sub.desc as full_mocar, driver.title_num1, driver.name_num1, 
            driver.last_num1, driver.birth_num1, driver.title_num2, driver.name_num2, driver.last_num2, driver.birth_num2, act.p_id, act.act_sort, act.tmp_act_id,
            act.p_pre, act.p_stamp, act.p_tax, act.p_net,  
            act.barcode_id, tb_type_inform.name as type_inform_name, tb_titlename.id_prename as idtitlename 
            FROM data INNER JOIN detail ON (data.id_data = detail.id_data) INNER JOIN driver ON (driver.id_data = data.id_data) 
            INNER JOIN tb_car_prb ON (detail.car_cat_acc = tb_car_prb.pre_id) INNER JOIN protect ON (data.id_data = protect.id_data) 
            INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car) 
            INNER JOIN act ON (act.id_data = data.id_data) INNER JOIN insuree ON (data.id_data = insuree.id_data) 
            INNER JOIN tb_titlename ON(tb_titlename.prename = insuree.title) 
            INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) 
            INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) 
            INNER JOIN tb_province ON (tb_province.id = insuree.province) INNER JOIN tb_mo_car_sub ON (detail.mo_sub = tb_mo_car_sub.id) 
            LEFT JOIN tb_customer ON (data.login = tb_customer.user) 
            WHERE data.id_data= '$idData'";
            $result = $conn->prepare($sqlCommand);
            $result->execute();
            $this->SqlCode = $sqlCommand;
            $rs = $result->fetch();
            if(empty($rs)) return false; 
            return $rs;
        } else {
            $sqlCommand = "SELECT
                tb_customer.Dealer_code,
                tb_customer.saka,
                `data`.id,
                `data`.doc_type,
                `data`.`login`,
                `data`.send_date,
                `data`.name_inform,
                `data`.id_data,
                `data`.o_insure,
                `data`.ty_inform,
                `data`.`start_date`,
                `data`.end_date,
                `data`.name_gain,
                insuree.icard_niti,
                insuree.person,
                insuree.title,
                insuree.`name`,
                insuree.last,
                insuree.career,
                insuree.`add`,
                insuree.icard,
                insuree.SendAdd,
                insuree.`group`,
                insuree.town,
                insuree.lane,
                insuree.road,
                insuree.tumbon,
                insuree.amphur,
                insuree.province,
                insuree.postal,
                insuree.tel_home,
                insuree.email,
                detail.car_id,
                detail.car_color,
                detail.cc,
                detail.car_cc,
                detail.car_regis,
                detail.car_regis_pro,
                detail.car_body,
                detail.regis_date,
                detail.car_seat,
                detail.car_wgt,
                detail.n_motor,
                detail.br_car,
                detail.mo_car,
                detail.gear,
                tb_car_prb.pre,
                tb_car_prb.duty,
                tb_car_prb.vat,
                tb_car_prb.net,
                tb_car_prb.vehicle_type,
                protect.*,
                driver.title_num1,
                driver.name_num1,
                driver.last_num1,
                driver.birth_num1,
                driver.title_num2,
                driver.name_num2,
                driver.last_num2,
                driver.birth_num2,
                act.p_id,
                act.act_sort,
                act.p_pre,
                act.p_stamp,
                act.p_tax,
                act.p_net,
                act.tmp_act_id,
                act.barcode_id,
                tb_type_inform.`name` AS type_inform_name
            FROM
                `data`
                INNER JOIN detail ON ( `data`.id_data = detail.id_data )
                INNER JOIN driver ON ( driver.id_data = `data`.id_data )
                INNER JOIN tb_car_prb ON ( detail.car_id = tb_car_prb.pre_id )
                INNER JOIN protect ON ( `data`.id_data = protect.id_data )
                INNER JOIN tb_type_inform ON ( `data`.ty_inform = tb_type_inform.`code` )
                INNER JOIN act ON ( act.id_data = `data`.id_data )
                INNER JOIN insuree ON ( `data`.id_data = insuree.id_data )
                INNER JOIN tb_customer ON ( `data`.`login` = tb_customer.`user` ) 
            WHERE
                `data`.id_data = '$idData'";
            $result = $conn->query($sqlCommand);
            $this->SqlCode = $sqlCommand;
            $rs = $result->fetch();
            return $rs;
        }
    }

    public function getNameDeler($codeDelar)
    {
        $conn = PDO_CONNECTION::fourinsure_mitsu();
        $sql = "SELECT * FROM tb_customer WHERE Dealer_code = '$codeDelar'";
    }
}
