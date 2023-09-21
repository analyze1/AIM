<?php

require_once('CarInsuranceInformation.vendor.php');
$_database = PDO_CONNECTION::fourinsure_mitsu();
echo"Before iF";
if($_REQUEST['GetWork'] == 'Insurance')
{
	echo"In if";
	$model = new CarInsuranceInformationRequestModel();
	$model->RequestArr = $_REQUEST;
	$model->UserLogin = "admin";
	$model->PersonType = "1";
	$model->StatusUseAct = "N";
	$res = new CarInsuranceInformationService($_database);
	echo json_encode($res->getCarInsurance($model)); 
	exit();
}
?>