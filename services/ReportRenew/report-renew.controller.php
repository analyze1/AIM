<?php
error_reporting(1);
session_start();
date_default_timezone_set("Asia/Bangkok");
require('../../inc/connectdbs.pdo.php');
require('../ResponseBase.Api.php');
require('./service/report-renew.service.php');

try {
    
    $_serviceMitSu = new ReportRenew(PDO_CONNECTION::fourinsure_mitsu(),PDO_CONNECTION::fourinsure_insured());
    if ($_POST['Controller'] == 'genYearByEnddate') {
        $dealerCode = $_POST['dealerCode'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter dealerCode !!') : $_POST['dealerCode'];
        $res = $_serviceMitSu->genYearByEnddate($dealerCode);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }
    if ($_POST['Controller'] == 'loadDataDealer') {
        $res = $_serviceMitSu->loadDataDealer();
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }

    if ($_POST['Controller'] == 'getDealerAll') {
        $res = $_serviceMitSu->getDealerAll();
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }
} catch (Exception $e) {
    ResponseJsonApi::statusFail($e->getMessage());
}
