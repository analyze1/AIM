<?php
require('../../../../inc/connectdbs.pdo.php');
require('../model/Approve-Mitsubishi.model.php');
require('../services/Approve-Mitsubishi.control.php');
require '../../../../services/LineNoti.service.php';

header('Content-type: application/json; charset=utf-8');
if ($_REQUEST['controller'] == 'MitsubishiApprove' ) {
       $model = new CancelModelRequest();  
       $model->Key = $_REQUEST['key'];
       $model->DealerCode = $_REQUEST['dealercode'];
       $model->Controller = $_REQUEST['controller'];
       $model->Become = $_REQUEST['become'];
       $model->Confirm = $_REQUEST['confirm'];
       $model->Follow = $_REQUEST['follow'];
       $model->NameFull = $_REQUEST['namefull'];
       $model->Phone = $_REQUEST['phone'];
       $model->Receipt = $_REQUEST['receipt'];
       $service = new ApproveMitsubishirenew(
              PDO_CONNECTION::fourinsure_mitsu(),
              PDO_CONNECTION::fourinsure_insured());
       $res = $service->ApproveMitsubishi($model);
       echo json_encode(array('Status'=>200));
       exit;
}