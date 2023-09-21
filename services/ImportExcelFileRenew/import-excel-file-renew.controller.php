<?php

session_start();
date_default_timezone_set("Asia/Bangkok");
require('../../inc/connectdbs.pdo.php'); 
require('../ResponseBase.Api.php');
require('./model/import-excel-file-renew.model.php');
require('./service/save-file.service.php');
require('./service/import-data.service.php');
require('../QuickFindDataArray/ModelCarFour.service.php');
require('../Resolve/services/resolve-end-date.service.php');

try {
    if ($_POST['Controller'] == 'importExcelFileRenew') {
        $service = new SaveFile(PDO_CONNECTION::fourinsure_mitsu());
        $res = $service->save('../../excel-upload-file/file',$_FILES['fileExcel'],$_SESSION['lguser'],$_SESSION['strUser']);

        if ($res) {
            ResponseJsonApi::statusCreated($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }
    if ($_POST['Controller'] == 'importInformSingleRenew') {      

        $service = new ImportData(
            PDO_CONNECTION::fourinsure_mitsu(),
            PDO_CONNECTION::fourinsure_insured(),
            $_SESSION['lguser'],
            $_SESSION['strUser']
        );
        $model = (object)$_POST;
        $res = $service->importInformSingleRenew($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }
    if ($_POST['Controller'] == 'getTempText') {
        $service = new ImportData(
            PDO_CONNECTION::fourinsure_mitsu(),
            PDO_CONNECTION::fourinsure_insured(),
            $_SESSION['lguser'],
            $_SESSION['strUser']
        );
        $model = new stdclass();
        $model->idData = $_POST['idData'];
        $res = $service->getTempText($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }
    if ($_POST['Controller'] == 'genSumAssured') {
        // print_r(var_dump(array($_POST['json'])));
        // exit;
        $service = new ImportData(
            PDO_CONNECTION::fourinsure_mitsu(),
            PDO_CONNECTION::fourinsure_insured(),
            'admin',
            'admin'
        );
        // var_dump($_POST['regexp']);exit;
        // $arr = json_decode($_POST['json']);
        $res = $service->fixBugCost($_POST['carType'],$_POST['brID'],$_POST['carId'], $_POST['price'],$_POST['regexp']);

        // $res = $service->checkSumAssured($_POST['brID'],$_POST['carId'], $_POST['year'], $_POST['price']);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }

    if ($_POST['Controller'] == 'genSumAssured-newEndDate-newRegisCar') {
       
        $service = new ImportData(
            PDO_CONNECTION::fourinsure_mitsu(),
            PDO_CONNECTION::fourinsure_insured(),
            'admin',
            'admin'
        );        
        $res = $service->fixBugCostEndDateRegisCar($_POST['carType'],$_POST['brID'],$_POST['carId'],$_POST['regexp'],$_POST['changeYear']);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }

    if ($_POST['Controller'] == 'findSumAssured') {
        $service = new ImportData(
            PDO_CONNECTION::fourinsure_mitsu(),
            PDO_CONNECTION::fourinsure_insured(),
            'admin',
            'admin'
        );
        // $res = $service->checkSumAssured($_POST['carType'],$_POST['brID'],$_POST['carId'], $_POST['price'],$_POST['regexp']);

        $res = $service->checkSumAssured($_POST['brID'],$_POST['carId'], $_POST['year'], $_POST['price']);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }
} catch (Exception $e) {
    ResponseJsonApi::statusFail($e->getMessage());
}
