<?php 
session_start();
date_default_timezone_set("Asia/Bangkok");
require('../../inc/connectdbs.pdo.php');
require('../ResponseBase.Api.php');
require('./title.service.php');

try {
    $_renewService = new IsoInsuranceControl(PDO_CONNECTION::fourinsure_insured());
    if ($_POST['Controller'] == 'TitleOption') {        
        $res = $_renewService->titleOption($_POST['Type']);
        // print_r($res);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }
} catch (Exception $e) {
    ResponseJsonApi::statusFail($e->getMessage());
}
?>