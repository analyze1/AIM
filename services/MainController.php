<?php

/************************************************ Controller of Service Mitsubishi Work ********************************************* */
session_start();
//select dependency injection
header("Content-type: application/json; charset=utf-8");
error_reporting(1);

if (empty($_POST)) {
    $request = json_decode(file_get_contents("php://input"));
    $_POST = (array)$request;
}

if ($_POST['Controller'] == 'ActBlackApi') {
    require('../inc/connectdbs.pdo.php');
    require('../rest_api_lib/httpful.phar');
    require('../model-response/ActBlackApi.model.php');
    require('./LineNoti.service.php');
    require("../nusoap/lib/nusoap.php");
    require('./ActApiBack.service.php');
} else if ($_POST['Controller'] == 'ActBlackApiRed') {
    require('../inc/connectdbs.pdo.php');
    require('../rest_api_lib/httpful.phar');
    require("../nusoap/lib/nusoap.php");
    require('../model-response/model-response.php');
    require('../model-response/check-act-id-model.php');
    require('./LineNoti.service.php');
    require('./ActApiRed.service.php');
    require('./ActApiBack.service.php');
}

/******* รายการ post body ******/
//post : DATAID
//post : Controller

switch ($_POST['Controller']) {
    case 'ActBlackApi': {
            $_res = loadInformationControl::postApiControl($_POST['DATAID']);
            echo json_encode($_res);
            break;
        }
    case 'ActBlackApiRed': {
            $_res = ActRedControl::makeActDocument($_POST['DATAID']);
            echo json_encode($_res);
            break;
        }
    default: {
            echo json_encode(array('status' => 405, 'content' => 'Fail')); //http_response_code(405);
        }
}
