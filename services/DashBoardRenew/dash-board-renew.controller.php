<?php
require '../../inc/connectdbs.pdo.php';
require '../ResponseBase.Api.php';
require './model/dash-board-renew.model.php';
require './service/dash-board-renew.service.php';

try {

    // $_serviceSu = new GeneralInformation(PDO_CONNECTION::fourinsure_mitsu());
    // $_serviceFour = new GeneralInformation(PDO_CONNECTION::fourinsure_insured());
    $_serviceMitSu = new DashBoardRenew(PDO_CONNECTION::fourinsure_mitsu(),PDO_CONNECTION::fourinsure_insured());
    // $_serviceSaveFour = new SaveInformation(PDO_CONNECTION::fourinsure_insured());

    if ($_POST['Controller'] == 'getCountAll') {
        $model = new DashBoardModelRequest();
        $model->dealerCode = $_POST['dealerCode'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter dealerCode !!') : $_POST['dealerCode'];
        $model->year = $_POST['year'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter year !!') : $_POST['year'];
        $res = $_serviceMitSu->getCountAll($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }

    if ($_POST['Controller'] == 'getDataModelCar') {
        $model = new DashBoardModelRequest();
        $model->dealerCode = $_POST['dealerCode'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter dealerCode !!') : $_POST['dealerCode'];
        $model->year = $_POST['year'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter year !!') : $_POST['year'];
        $res = $_serviceMitSu->getDataModelCar($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail('ไม่มีข้อมูล');
        }
    }

    if ($_POST['Controller'] == 'genDataExpirationDate') {
        $model = new DashBoardModelRequest();
        $model->dealerCode = $_POST['dealerCode'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter dealerCode !!') : $_POST['dealerCode'];
        $model->year = $_POST['year'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter year !!') : $_POST['year'];
        $res = $_serviceMitSu->genDataExpirationDate($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }

    if ($_POST['Controller'] == 'genTotalData') {
        $model = new DashBoardModelRequest();
        $model->dealerCode = $_POST['dealerCode'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter dealerCode !!') : $_POST['dealerCode'];
        $model->year = $_POST['year'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter year !!') : $_POST['year'];
        $model->month = date('m');
        $res = $_serviceMitSu->genTotalData($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }

    if ($_POST['Controller'] == 'genTotalDataByMonth') {
        $model = new DashBoardModelRequest();
        $model->dealerCode = $_POST['dealerCode'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter dealerCode !!') : $_POST['dealerCode'];
        $model->year = $_POST['year'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter year !!') : $_POST['year'];
        $res = $_serviceMitSu->genTotalDataByMonth($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }

    if ($_POST['Controller'] == 'genDataSpareParts') {       
        $model = new DashBoardModelRequest();
        $model->dealerCode = $_POST['dealerCode'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter dealerCode !!') : $_POST['dealerCode'];
        $model->year = date('Y');
        $res = $_serviceMitSu->genDataSpareParts($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusBadParams($res);
        }
    }
    if ($_POST['Controller'] == 'genDataRenew') {       
        $model = new DashBoardModelRequest();
        $model->dealerCode = $_POST['dealerCode'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter dealerCode !!') : $_POST['dealerCode'];
        $model->year = $_POST['year'];
        $model->month = $_POST['monthRenew'];
        $model->type = $_POST['typeData'];
        $res = $_serviceMitSu->genDataRenew($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusBadParams($res);
        }
    }

} catch (Exception $e) {
    ResponseJsonApi::statusFail($e->getMessage());
}