<?php
class FollowUpClaimRequestModel
{
    public $RequestData;
    public $UserLogin;
    public $UserRights;
    public $Search;
}

class FollowUpClaimModel
{
    public $FollowDateSave;
    public $IdData;
    public $ClaimNo;
    public $FollowDetail;
    public $AppraisalPrice;
    public $AppointmentDate;
    public $AppointmentDateRepair;
    public $Informant;
    public $Followers;
}

class DataTableFollowUpClaimList
{
    public $data;
    public $draw;
    public $recordsFiltered;
    public $recordsTotal;
}

class FollowUpClaimModelResponse
{
    public $Data;
    public $Status;

    public function __construct()
    {
        $this->Data = new DataTableFollowUpClaimList();
    }
}


?>