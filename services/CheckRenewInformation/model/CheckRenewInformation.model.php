<?php
class CheckRenewInformationRequestModel
{
    public $DataRequest;
    public $UserLogin;
    public $UserRights;
    public $LogType;
}

class DataRenewInsuranceModel
{
    public $IdData;
    public $IdDataFour;
    public $Status;
    public $FollowDate;
    public $Title;
    public $Name;
    public $Last;
    public $CarBrandName;
    public $CarModelName;
    public $Fund;
    public $Detail;
    public $User;
    public $EndorseStatus;
    public $EndorseCarStatus;
    public $CarBody;
    public $EndorseCarbody;
    public $CarRegistNo;
    public $CarRegistProvince;
}

class CheckRenewInformationResponseModel
{
    public $IdDataOld;
    public $IdDataNew;
    public $Approval;
    public $ViewDocument;
    public $ViewInformation;
    public $CarName;
    public $CustomerName;
    public $RenewFund;
    public $DetailRenew;
    public $UserRenew;
    public $RenewDate;
    public $CarRegistName;
    public $DetailPayment;
    public $InsureNo;
    public $ThaiPostID;
}

class DataTableCheckRenewInformationResponseModel
{
    public $draw;
    public $recordsTotal;
    public $recordsFiltered;
    public $data;
    public $Status;
    public $Text;
}
