<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
require('../../inc/connectdbs.pdo.php');
require('../ResponseBase.Api.php');
require('./services/resolve-end-date.service.php');


try {
    if ($_POST['Controller'] == 'reSolveEndDate') {
        
        $service = new ResolveEndDate(PDO_CONNECTION::fourinsure_mitsu());
        $model = new stdClass();
        $model->dealerCode = ($_POST['dealerCode']) ? $_POST['dealerCode'] : ResponseJsonApi::statusBadParams('กรุณาระบุรหัส dealer');        
        $res = $service->changeEndDate($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusBadParams($res);
        }
    }
} catch (Exception $e) {
    ResponseJsonApi::statusFail($e->getMessage());
}