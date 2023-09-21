<?php
require_once('../inc/connectdbs.pdo.php');
require_once('QuotationRenew.model.php');
require_once('QuotationRenew.service.php');

if($_REQUEST['Controller'] == 'getNewCostU'){
    $service = new QuotationRenew(PDO_CONNECTION::fourinsure_insured());
    $model = new QuotationRenewModelRequest();
    $model->mocarGroup = $_REQUEST['mocarGroup'];
    $model->protectType = $_REQUEST['protectType'];
    $model->prodName = $_REQUEST['prodName'];
    $res =  $service->getNewCostU($model);
    echo json_encode($res);
    exit();
}

if($_REQUEST['Controller'] == 'getPremiumU'){
    $service = new QuotationRenew(PDO_CONNECTION::fourinsure_insured());
    $model = new QuotationRenewModelRequest();
    $model->mocarGroup = $_REQUEST['mocarGroup'];
    $model->protectType = $_REQUEST['protectType'];
    $model->prodName = $_REQUEST['prodName'];
    $model->cost = $_REQUEST['cost'];
    $model->year = $_REQUEST['year'];
    $res =  $service->getPremiumU($model);
    echo json_encode($res);
    exit();
}