<?php
require("CheckRenewInformation.vendor.php");

$_contextMitsu = PDO_CONNECTION::fourinsure_mitsu();
$_contextFour = PDO_CONNECTION::fourinsure_insured();

try {
    if ($_POST['Controller'] == 'NewInsurance') {
        $model = new CheckRenewInformationRequestModel();
        $model->DataRequest = $_POST;
        $model->UserLogin = $_POST['UserLogin'];
        $model->UserRights = $_POST['UserRights'];
        $model->LogType = $_POST['LogType'];

        $res = new CheckRenewInformationService($_contextMitsu, $_contextFour);
        echo json_encode($res->createDataRenewCarInsuranceNew($model));
    }
} catch (Exception $e) {
    echo json_encode(
        array(
            'ErrorMessage' => $e->getMessage(),
            'Status' => http_response_code(400),
            'Text' => 'Fail'
        )
    );
}
