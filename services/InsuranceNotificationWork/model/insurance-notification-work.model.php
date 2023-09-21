<?php

class PassCarTypeModelRequest
{
    public $passCarID;
}

class TitleNameModelRequest
{
    public $personType;
}

class BrandCarModelRequest extends PassCarTypeModelRequest
{
    public $catCarID;
}

class ModelCarModelRequest extends PassCarTypeModelRequest
{
    public $brandCarID;
    public $modelCarID;
}


class BranchNameModelRequest
{
    public $userName;
}

class AddressModelRequest
{
    public $provinceID;
    public $amphurID;
    public $tumbonID;
}


class InformAfterQuotationModelRequest
{
    public $idData;
    public $idDetail;
    public $user;
    public $claim;
    public $agent;
    public $employee;
    public $qAuto;
    public $currentText;

    public $endDateOld;
    public $idDataOld;
    public $carBodyOld;
    public $statusVip;
    public $personID;

    public $icard;
    public $titleName;
    public $fireName;
    public $lastName;

    public $addressStatus;
    public $sendAdd;
    public $sendGroup;
    public $sendTown;
    public $sendLane;
    public $sendRoad;
    public $sendProvince;
    public $sendAmphur;
    public $sendTumbon;
    public $sendPost;

    public $inCareer;
}

class DataRenewArrayRequest
{
    public $id_data;
}
class TypeRequest
{
    public $type;
}

class FindInsurancePremiumrResponse
{
    public $sumAssured;
    
    public $insuredType;
    public $premiumNet;
    public $premium;
    public $repair;
    public $costStart;
    public $costEnd;
    public $carId;

    public $excess;
    public $asset;
    public $driver;
    public $driverticket;
    public $insuran;
    public $life;
    public $maxlife;
    public $nurse;
    public $passenger;
    public $tikets;
    public $idCost;
}