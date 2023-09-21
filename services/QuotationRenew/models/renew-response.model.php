<?php

class RenewCusmodel
{
    public $Number;
    public $StatusMain;
    public $HidenNumber;
}

class RenewTelCustomer extends RenewCusmodel
{
    public $Detail;
}

class RenewDealerModelResponse
{
    public $Data;
    public $Status;

    public function __construct()
    {
        $this->Data = array();//RenewCusmodel List
    }
}

class RelationshipModel
{
    public $Name;
}

?>