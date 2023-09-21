<?php

require_once('EndorseCarInsuranceInformation.vendor.php');
$_database = PDO_CONNECTION::fourinsure_mitsu();
if($_REQUEST['GetWork'] == 'EndorseInsurance')
{
	$model = new EndorseCarInsuranceInformationModel();
	$model->RequestArr = $_REQUEST;
	$model->UserLogin = $_REQUEST['UserLogin'];
	$model->StatusUseAct = $_REQUEST['StatusUseAct'];
	$model->StatusEndorse = $_REQUEST['StatusEndorse'];
	$res = new EndorseCarInsuranceInformationService($_database);
	echo json_encode($res->getCarInsurance($model)); 
	exit();
}
?>