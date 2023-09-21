<?php

class RenewDealerModelRequest
{
    public $DataID;
    public $DetailRenewID;
}

class RenewSmsDealerModelRequest extends RenewDealerModelRequest
{
    public $NumberList;
    public $TypeDocRenew;
}

class RenewGetTelCusModelRequest
{
    public $DataID;
}

class RenewUpdateTelMainModelRequest
{
    public $DataID;
    public $Number;
    public $Pointer;
    public $StatusFollow;
    public $Details;
}

class RenewSaveTelephoneModelRequest
{
    public $Number;
    public $Status;
    public $Detail;
    public $Name;
    public $Relation;
    public $DataID;
}

class PaymentViriyahSMSRequest
{
    public $DataID;
    public $Link;
    public $Telophone;
}
