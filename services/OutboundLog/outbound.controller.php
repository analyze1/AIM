<?php

require('../../inc/connectdbs.pdo.php');
require('./outbound.service.php');
require('../ResponseBase.Api.php');
// print_r($_REQUEST);
$_service = new OutboundControl(PDO_CONNECTION::fourinsure_insured(),PDO_CONNECTION::fourinsure_mitsu());

if ($_POST['Controller'] == 'SaveInboundLog') {

    $res = $_service->outboundSaveLog($_POST,'MITSUBISHI');
    ResponseJsonApi::statusCreated($res);
    exit;
}
if ($_POST['Controller'] == 'SaveInboundLogclaim') {

    $res = $_service->outboundSaveLog($_POST,'MITSUBISHICLAIM');
    ResponseJsonApi::statusCreated($res);
    exit;
}