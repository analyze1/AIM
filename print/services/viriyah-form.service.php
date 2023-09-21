<?php

class ViriyahFormControl
{
    private $_context;
    private $_contextAcc;
    private $_convertService;

    public function __construct($conn, $acc)
    {
        $this->_context = $conn;
        $this->_contextAcc = $acc;
        $this->_convertService = new ConvertAddress($conn);
    }

    public function installment($id, $type, $creditNo)
    {
        try {


            $type = $type == '' ? 'Payment' : $type;
            $info = $this->getInfoInstallment($id, $type, $creditNo);
            if ($info == null) return false;
            $res = $this->mapperMotorInstallment($info);
            // print_r($res); exit();
            return $res;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function paymentFull($id, $type, $creditNo)
    {
        $type = $type == '' ? 'Payment' : $type;
        $info = null;
        $value = $this->getInfoById($id, $type, $creditNo);
        $eArr = explode('/', $value->id_data);
        if ($eArr[1] == 'NON') {
            $info = $this->mapperNonMotor($value);
        } else {
            $info = $this->mapperMotor($value);
        }
        return $info;
    }

    public function mapperNonMotor($row) //งาน non
    {
        $model = new ViriyahPaymentNonFullModel();
        $model->Type = strlen($row->o_insure) > 3 ? false : true;
        $model->TypeMotor = 'NON';
        $model->TypeMotorDetail = $row->name_print;
        $model->NameFull = $this->concatName($row);
        $ads = $this->_convertService->mapperPDFViriyah((array)$row);

        $model->Address1 = $ads['pdf1'];
        $model->Address2 = $ads['pdf2'];
        $ads = null;

        $model->Post = $row->postal;
        $model->Telephone = $this->selectTelephone($row);
        $model->DetailOhter = '';
        $model->SignaturePath = $row->ImgFileName;
        $dateEx = explode('-', $row->ApprovalDate);
        $model->Day = $dateEx[2];
        $model->Month = $this->convertMonth($dateEx[1]);
        $model->Year = $dateEx[0];
        $model->BankName = $this->getNameBankByCode($row->BankName);
        $model->TypeCard = $this->typeCard($row);
        $model->NumberCard = $row->CardNo;
        $model->ExpCard = $row->ExpCard;
        $model->PayTotal = number_format($row->Amount, 2);
        $model->PayDoc = $row->AmountWords;
        $model->NameCustomerCard = $row->NameOnCard;
        $model->RelationShip = $row->Relation;
        $model->TelephoneOwnerCardNumber = $row->PhoneOwnerCard;
        $model->InfoArr = (array)$row;
        $model->PicturePatch = $row->PicFileName;
        return $model;
    }

    public function mapperMotorInstallment($row)
    {
        $map = new ViriyahInstallmentModel();
        $map->Type = strlen($row->o_insure) > 3 ? false : true;
        $map->TypeDetail = $row->o_insure;
        $map->FullName = $this->concatName($row);
        $map->Address = $this->_convertService->mapperPDFViriyahInstallment((array)$row);
        $map->Post = $row->postal;
        $map->Telephone = $this->selectTelephone($row);
        $map->OtherInfo = ''; //$row->;
        $map->OtherInfoDetail = ''; //$row->;
        $map->RoundMonth = $row->InstallmentRound;
        $map->TotalRound = number_format($row->MoneyMonthPayment, 2);
        $map->TypeCard = $row->TypeCredit;
        $map->TypeCardDetail = ''; //$row->;
        $map->TypeCredit = $row->TypeCard;
        $map->Total = number_format($row->Amount, 2);
        $map->TotalString = $row->AmountWords;
        $map->CardNumber = $row->CardNo;
        $map->ExpCard = $row->ExpCard;
        $map->Signature = $row->ImgFileName;
        $map->RelationShip = $row->Relation;
        $map->NameOnCard = $row->NameOnCard;
        $map->BranCarModel = $row->br_name . '/' . $row->mo_name;
        $map->RegisCar = $row->car_regis;
        $map->RegisYear = $row->regis_date;
        $map->Body = $row->car_body;
        $map->CCSeat = $row->car_seat . '/' . $row->cc . '/' . $row->car_wg;
        $map->OwnerApprove = $this->rotexDate($row->ApprovalDate);
        $map->PicturePatch = $row->PicFileName;

        $getCredit = $this->getDataCredit($row->CreditNoAccount);

        $dateEx = explode('-', $row->ApprovalDate);
        $map->NumberCard = $row->CardNo;
        $map->Day = $dateEx[2];
        $map->Month = $this->convertMonth($dateEx[1]);
        $map->Year = $dateEx[0];
        $map->BankName = $this->getNameBankByCode($row->BankName);
        $map->NameFull = $this->concatName($row);
        $map->TypeMotorDetail = $row->name_print;
        $map->BranCar = $row->br_name;
        $map->MoCarName = $row->mo_name;
        $map->Engnumber = $row->n_motor;
        $map->Gear = $row->gear == 'A' ? 'อัตโนมัติ' : 'ธรรมดา';
        $map->CC = $row->cc;
        $map->TotalPremium = number_format($getCredit->totalPre, 2);
        $map->TotalPremiumRound = $this->calInstallment($getCredit->totalPre, $row->InstallmentRound);
        $map->TotalPremiumText = $this->letters($getCredit->totalPre);
        $map->TotalPremiumAct = number_format($getCredit->totalPreAct, 2);
        $map->TotalPremiumActText = $this->letters($getCredit->totalPreAct);
        return $map;
    }

    public function mapperMotor($row) //งาน motor
    {
        $model = new ViriyahPaymentFullModel();
        $model->Type = strlen($row->o_insure) > 3 ? false : true;
        $model->TypeMotor = 'MOTOR';
        $model->TypeMotorDetail = $row->name_print;
        $model->NameFull = $this->concatName($row);
        $ads = $this->_convertService->mapperPDFViriyah((array)$row);

        $model->Address1 = $ads['pdf1'];
        $model->Address2 = $ads['pdf2'];
        $ads = null;

        $model->Post = $row->postal;
        $model->Telephone = $this->selectTelephone($row);
        $model->DetailOhter = '';
        $model->SignaturePath = $row->ImgFileName;
        $dateEx = explode('-', $row->ApprovalDate);
        $model->Day = $dateEx[2];
        $model->Month = $this->convertMonth($dateEx[1]);
        $model->Year = $dateEx[0];
        $model->BankName = $this->getNameBankByCode($row->BankName);
        $model->TypeCard = $this->typeCard($row);
        $model->NumberCard = $row->CardNo;
        $model->ExpCard = $row->ExpCard;
        $model->PayTotal = number_format($row->Amount, 2);
        $model->PayDoc = $row->AmountWords;
        $model->NameCustomerCard = $row->NameOnCard;
        $model->RelationShip = $row->Relation;
        $model->TelephoneOwnerCardNumber = $row->PhoneOwnerCard;
        $model->InfoArr = (array)$row;
        $model->BranCar = $row->br_name;
        $model->MoCarName = $row->mo_name;
        $model->RegisCar = $row->car_regis;
        $model->RegisYear = $row->regis_date;
        $model->Body = $row->car_body;
        $model->CC = $row->cc;
        $model->Engnumber = $row->n_motor;
        $model->Gear = $row->gear == 'A' ? 'อัตโนมัติ' : 'ธรรมดา';
        $model->PicturePatch = $row->PicFileName;

        return $model;
    }

    private function concatName($row)
    {
        if ($row->person == '1' || $row->person == '3') {
            return $row->title . $row->name . ' ' . $row->last;
        } else {
            return $row->title . ' ' . $row->name . ' ' . $row->last;
        }
    }

    private function selectTelephone($row)
    {
        if ($row->tel_mobile != '') {
            return $row->tel_mobile;
        }

        if ($row->tel_mobile2 != '') {
            return $row->tel_mobile2;
        }

        if ($row->tel_mobile3 != '') {
            return $row->tel_mobile3;
        }
    }

    private function typeCard($row)
    {
        if ($row->TypeCard != null || $row->TypeCard != '') return strtolower($row->TypeCard);
        if (substr($row->CardNo, 0, 2) == '42') {
            return 'visa';
        }
        return 'master';
    }

    private function getNameBankByCode($code)
    {
        $str = "SELECT name_bank FROM tb_bank WHERE code_bank ='$code'";
        $r = $this->_contextAcc->query($str)->fetch(PDO::FETCH_OBJ)->name_bank;
        return $r;
    }

    private function getInfoById($id, $type, $no)
    {
        $credit = $no == '' ? '' : "AND CreditNoAccount = '$no'";
        $str = "SELECT
        da.id_data,
        da.o_insure,
        i.title,
        i.`name`,
        i.last,
        i.person,
        i.career,
        i.`add`,
        i.`group`,
        i.town,
        i.lane,
        i.road,
        i.tumbon,
        i.amphur,
        i.province,
        i.postal,
        i.tel_mobile,
        i.tel_mobile2,
        i.tel_mobile3,
        cnon.name_print,
        `log`.BankName,
        `log`.NameOnCard,
        `log`.CardNo,
        `log`.Amount,
        `log`.AmountWords,
        `log`.Relation,
        `log`.ImgFileName,
        `log`.PhoneOwnerCard,
        `log`.ApprovalDate,
        `log`.ExpCard,
        `log`.PicFileName,
        `log`.TypeCard,
        `log`.CreditNoAccount,
        de.car_body,
        de.car_regis,
        de.car_regis_pro,
        de.n_motor,
        de.gear,
        mo.`name` AS mo_name,
        br.`name` AS br_name,
        de.regis_date,
        de.cc,
        de.car_seat,
        de.car_wg
        FROM
            insuree AS i
            LEFT JOIN `data` AS da ON ( da.id_data = i.id_data ) 
            LEFT JOIN detail AS de ON ( de.id_data = da.id_data ) 
            LEFT JOIN tb_br_car AS br ON ( br.id = de.br_car ) 
            LEFT JOIN tb_mo_car AS mo ON ( mo.id = de.mo_car ) 
            LEFT JOIN LogPaymentCreditViriyahMitsubishiRenew AS `log` ON ( `log`.id_data_old = da.id_data ) 
            LEFT JOIN tb_comp_nonmotor AS cnon ON ( cnon.id_nonmotor = da.id_nonmotor ) 
        WHERE
            `log`.id_data = '$id' AND `log`.TypeWork = '$type' $credit";

        $tableResult = $this->_context->query($str)->fetch(PDO::FETCH_OBJ);

        // echo json_encode($tableResult); exit();

        if ($tableResult == null) return false;
        return $tableResult;
    }

    public function getInfoInstallment($id, $type, $no)
    {
        $credit = $no == '' ? '' : "AND `log`.CreditNoAccount = '$no'";

        /*$str = "SELECT
            da.id_data,
            da.o_insure,
            i.title,
            i.`name`,
            i.last,
            i.person,
            i.career,
            i.`add`,
            i.`group`,
            i.town,
            i.lane,
            i.road,
            i.tumbon,
            i.amphur,
            i.province,
            i.postal,
            i.tel_mobile,
            i.tel_mobile2,
            i.tel_mobile3,
            `log`.Id,
            `log`.id_data,
            `log`.ReturnSMS,
            `log`.BankName,
            `log`.NameOnCard,
            `log`.CardNo,
            `log`.Amount,
            `log`.AmountWords,
            `log`.Relation,
            `log`.ApprovalDate,
            `log`.ApprovalTime,
            `log`.ImgFileName,
            `log`.OptionCredit,
            `log`.TypeCredit,
            `log`.InstallmentRound,
            `log`.TypeCard,
            `log`.PhoneOwnerCard,
            `log`.MoneyMonthPayment,
            `log`.PicFileName,
            `log`.ExpCard,
            `log`.CreditNoAccount,
            de.car_body,
            de.n_motor,
            de.car_regis,
            de.car_regis_pro,
            mo.`name` AS mo_name,
            br.`name` AS br_name,
            de.regis_date,
            de.cc,
            de.car_seat,
            de.car_wg 
            FROM
            `data` AS da
            LEFT JOIN insuree AS i ON ( i.id_data = da.id_data )
            LEFT JOIN LogPaymentCreditViriyahMitsubishiRenew AS `log` ON ( `log`.id_data_old = da.id_data )
            LEFT JOIN detail AS de ON ( de.id_data = da.id_data )
            LEFT JOIN tb_br_car AS br ON ( br.id = de.br_car )
            LEFT JOIN tb_mo_car AS mo ON ( mo.id = de.mo_car ) 
            WHERE `log`.id_data_old = '$id' AND `log`.TypeWork='$type' $credit";*/

        $str = "SELECT
            da.id_data,
            da.o_insure,
            i.title,
            i.`name`,
            i.last,
            i.person,
            i.career,
            i.`add`,
            i.`group`,
            i.town,
            i.lane,
            i.road,
            i.tumbon,
            i.amphur,
            i.province,
            i.postal,
            i.tel_mobi AS tel_mobile,
            i.tel_mobi_2 AS tel_mobile2,
            i.tel_mobi_3 AS tel_mobile3,
            `log`.Id,
            `log`.id_data_old,
            `log`.ReturnSMS,
            `log`.BankName,
            `log`.NameOnCard,
            `log`.CardNo,
            `log`.Amount,
            `log`.AmountWords,
            `log`.Relation,
            `log`.ApprovalDate,
            `log`.ApprovalTime,
            `log`.ImgFileName,
            `log`.OptionCredit,
            `log`.TypeCredit,
            `log`.InstallmentRound,
            `log`.TypeCard,
            `log`.PhoneOwnerCard,
            `log`.MoneyMonthPayment,
            `log`.PicFileName,
            `log`.ExpCard,
            `log`.CreditNoAccount,
            de.car_body,
            de.n_motor,
            de.car_regis,
            de.car_regis_pro,
            mo.`name` AS mo_name,
            br.`name` AS br_name,
            de.regis_date,
            de.cc,
            de.car_seat,
            de.car_wgt AS car_wg 
        FROM
            fourinsure_mitsu.`data` AS da
            LEFT JOIN fourinsure_mitsu.insuree AS i ON ( i.id_data = da.id_data )
            LEFT JOIN fourinsure_insured.LogPaymentCreditViriyahMitsubishiRenew AS `log` ON ( `log`.id_data_old = da.id_data )
            LEFT JOIN fourinsure_mitsu.detail AS de ON ( de.id_data = da.id_data )
            LEFT JOIN fourinsure_insured.tb_br_car AS br ON ( br.id = de.br_car )
            LEFT JOIN fourinsure_insured.tb_mo_car AS mo ON ( mo.id = de.mo_car ) 
        WHERE
            `log`.id_data_old = '$id' 
            AND `log`.TypeWork = '$type' $credit";
        // echo $str;
        // exit;
        $r = $this->_context->query($str)->fetch(PDO::FETCH_OBJ);
        return $r;
    }

    public function utf8_strlen($s)
    {
        $c = strlen($s);
        $l = 0;
        for ($i = 0; $i < $c; ++$i)
            if ((ord($s[$i]) & 0xC0) != 0x80) ++$l;
        return $l;
    }

    private function convertMonth($val)
    {
        $thai = array(
            '01' => "มกราคม",
            '02' => "กุมภาพันธ์",
            '03' => "มีนาคม",
            '04' => "เมษายน",
            '05' => "พฤษภาคม",
            '06' => "มิถุนายน",
            '07' => "กรกฎาคม",
            '08' => "สิงหาคม",
            '09' => "กันยายน",
            '10' => "ตุลาคม",
            '11' => "พฤศจิกายน",
            '12' => "ธันวาคม"
        );

        return $thai[$val];
    }

    private function rotexDate($d)
    {
        $arr = explode('-', $d);
        $a = array();
        $a['day'] = $arr[2];
        $a['month'] = $arr[1];
        $a['year'] = $arr[0];
        return $a;
    }

    private function calInstallment($valMoney, $valIns = 0)
    {
        $money = (float) preg_replace('/[^0-9\.]/', '', $valMoney);

        $ins = (int) preg_replace('/[^0-9\.]/', '', $valIns);

        $moneyToIns = number_format(($money / $ins), 2, '.', ',');

        return $moneyToIns;
    }

    private function letters($number)
    {
        $txtnum1 = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ');
        $txtnum2 = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
        $number = str_replace(",", "", $number);
        $number = str_replace(" ", "", $number);
        $number = str_replace("บาท", "", $number);
        $number = explode(".", $number);
        if (sizeof($number) > 2) {
            return 'ทศนิยมหลายตัวครับ';
            exit();
        }
        $strlen = strlen($number[0]);
        $convert = '';
        for ($i = 0; $i < $strlen; $i++) {
            $n = substr($number[0], $i, 1);
            if ($n != 0) {
                if ($i == ($strlen - 1) and $n == 1) {
                    $convert .= 'เอ็ด';
                } elseif ($i == ($strlen - 2) and $n == 2) {
                    $convert .= 'ยี่';
                } elseif ($i == ($strlen - 2) and $n == 1) {
                    $convert .= '';
                } else {
                    $convert .= $txtnum1[$n];
                }
                $convert .= $txtnum2[$strlen - $i - 1];
            }
        }

        $convert .= 'บาท';
        if ($number[1] == '0' or $number[1] == '00' or $number[1] == '') {
            $convert .= 'ถ้วน';
        } else {
            $strlen = strlen($number[1]);
            for ($i = 0; $i < $strlen; $i++) {
                $n = substr($number[1], $i, 1);
                if ($n != 0) {
                    if ($i == ($strlen - 1) and $n == 1) {
                        $convert .= 'เอ็ด';
                    } elseif ($i == ($strlen - 2) and $n == 2) {
                        $convert .= 'ยี่';
                    } elseif ($i == ($strlen - 2) and $n == 1) {
                        $convert .= '';
                    } else {
                        $convert .= $txtnum1[$n];
                    }
                    $convert .= $txtnum2[$strlen - $i - 1];
                }
            }
            $convert .= 'สตางค์';
        }
        return $convert;
    }

    private function getDataCredit($creditNo)
    {
        $sqlCredit = "SELECT cr_amount,crd_value,crd_refer FROM tb_credit_detail WHERE cr_no = '$creditNo' ";
        $fetchCredit = $this->_contextAcc->query($sqlCredit)->fetchAll(2);
        $pre = 0;
        $preAct = 0;
        foreach ($fetchCredit as $datas) {
            if ($datas['cr_amount'] == 0) {
                $preAct = $datas['crd_value'];
            } else {
                $pre = $datas['crd_value'];
            }
        }
        return (object) array('totalPre' => $pre, 'totalPreAct' => $preAct);
    }
}