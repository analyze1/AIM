<?php

class PaymentFulModelRequest
{
    public $DataID;
    public $Staff;
    public $Price;
    public $Type;   
    public $Bitly;

    public function __construct($req,$type)
    {
        $this->DataID = $req['DataID'];
        $this->Staff = $req['Staff'];
        $this->Price = $req['Price'];
        $this->Type = $type;
        $this->Bitly = null;
    }
}

class InstallmentPaymentModelRequest
{
    public $DataID;
    public $Staff;
    public $Price;
    public $Type;   
    public $Bitly;
    public $Month;
    public $PriceOnMonth;

    public function __construct($req,$type)
    {
        $this->DataID = $req['DataID'];
        $this->Staff = $req['Staff'];
        $this->Price = $req['Price'];
        $this->Type = $type;
        $this->Bitly = null;
        $this->Month = $req['Month'];
        $this->PriceOnMonth = $req['OnMonth'];
    }
}
?>