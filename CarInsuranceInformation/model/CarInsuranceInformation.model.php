<?php
class CarInsuranceInformationRequestModel
{
	public $RequestArr;
	public $UserLogin;
	public $PersonType;
	public $StatusUseAct;
	public $UserType;
}

class DataTableCarInsuranceInformationListModel
{
	public $draw;
	public $recordsTotal;
	public $recordsFiltered;
	public $data;
	public $SESSION_CHECK;
}

class DataTableCarInsuranceInformationResponseModel
{
	public $Data;

	public function __construct()
	{
		$this->Data = new DataTableCarInsuranceInformationListModel();
	}
}

class DataInsuranceInformationModel
{
	public $StatusEmail;
	public $PrintInsurance;
	public $IdDataSend;
	public $Name;
	public $SendDate;
	public $StartDate;
	public $PrintAct;
	public $WSAPIONLINE;
	public $MoCar;
	public $CarBody;
	public $Cost;
	public $Pre;
	public $Product;
	public $CostProduct;
}
