<?php
require '../../inc/connectdbs.pdo.php';
require '../ResponseBase.Api.php';
require './service/file-upload-doc.service.php';
require '../LineNoti.service.php';

$control = $_REQUEST['Controller'];
$DB = PDO_CONNECTION::fourinsure_mitsu();
try {
    if ($control == 'load-data-insuranes') {
        $service = new DownloadDocService($DB);
        // $response = $service->loadInsureList();
        // if ($response) {
        //     ResponseBase::OkResult($response);
        // }
        // exit();
    }

    if ($control == 'save-doc-file') {
        $service = new DownloadDocService($DB);
        $model = new stdClass();
        $model->dealerCode = $_POST['dealerCode'];
        $model->file = ($_FILES['document']) ? $_FILES['document'] : ResponseJsonApi::statusBadParams('กรุณาเลือกไฟล์');
        $response = $service->handleSaveDocument($model,'DocAdmin');
        if($response['status'] == 200){
            ResponseJsonApi::statusCreated($response['message']);
        }else{
            ResponseJsonApi::statusFail($response['message']);
        }
    }   
    
    if($control == 'save-bank-file')
    {
        echo json_encode(array('status'=>200,'data'=>'save-bank-file controller'));
        exit;
    }
} catch (\Exception $e) {
    ResponseJsonApi::statusFail($e);
}
