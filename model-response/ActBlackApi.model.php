<?php
/**************************************************************************** Black Act Api 09712 ************************************************************************** */

class ActBlackApiModel
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
}

class ActApiResponseModel
{
    public $Result;
    public $ErrorCode;
    public $ErrorMsg;
    public $PolicyNo;
    public $BarcodeNo;
    public $PolicyUrl;
}
?>