<?php

class ImportExcelFileRenewModelRequest
{
    public $idData;
    public $modelCar;
    public $modelCarSub;
    public $carBody;
    public $carMotor;
    public $carTypeId;
    public $yearCar;
    public $cc;
    public $startDate;
    public $endDate;
    public $sendDate;
    public $beneficiary;
    public $titleName;
    public $firstName;
    public $lastName;
    public $houseNumber;
    public $villageNo;
    public $road;
    public $tumbon;
    public $amphur;
    public $province;
    public $postalCode;
    public $phoneNumber1;
    public $phoneNumber2;
    public $phoneNumber3;
    public $sumAssured;
    public $actId;
    public $sort;
    public $text;
    public $Branch;
    public $Email;
    public $carPrice;
    public $idCard;
    public $person;
    public $alley;

    public function concatmodel()
    {
        return $this->modelCar.'|'.$this->modelCarSub.'|'.$this->carBody.'|'.$this->carMotor.'|'.$this->carTypeId.'|'
        .$this->yearCar.'|'.$this->cc.'|'.$this->startDate.'|'.$this->endDate.'|'.$this->sendDate.'|'.$this->beneficiary
        .'|'.$this->titleName.'|'.$this->firstName.'|'.$this->lastName.'|'.$this->houseNumber.'|'.$this->villageNo.'|'
        .$this->road.'|'.$this->tumbon.'|'.$this->amphur.'|'.$this->province.'|'.$this->postalCode.'|'.$this->phoneNumber1.'|'
        .$this->phoneNumber2.'|'.$this->phoneNumber3.'|'.$this->sumAssured.'|'.$this->actId.'|'.$this->sort.'|'.$this->text.'|'
        .$this->Branch.'|'.$this->Email.'|'.$this->carPrice;
    }
}

class CostModelDefault
{
    public $action = false;
    public $id_cost = 0;
    public $car_id = 0;
    public $cost = 0;
    public $cost_end = 0;
    public $pre = 0;
    public $total = 0;
    public $repair = 0;
    public $mocargroup = 0;
    public $prod_name = 0;
    public $protect_type = 0;
    public $preMin = 0;
    public $sumAssured = 0;
}

?>