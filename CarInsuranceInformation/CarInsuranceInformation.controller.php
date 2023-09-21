<?php

require_once('CarInsuranceInformation.vendor.php');
$_database = PDO_CONNECTION::fourinsure_mitsu();
if($_REQUEST['GetWork'] == 'Insurance')
{
	$model = new CarInsuranceInformationRequestModel();
	$model->RequestArr = $_REQUEST;
	$model->UserLogin = $_REQUEST['UserLogin'];
	$model->PersonType = $_REQUEST['PersonType'];
	$model->StatusUseAct = $_REQUEST['StatusUseAct'];
	$res = new CarInsuranceInformationService($_database);
	echo json_encode($res->getCarInsurance($model)); 
	exit();
}
?>