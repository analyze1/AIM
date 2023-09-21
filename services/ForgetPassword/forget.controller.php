<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
include '../../inc/connectdbs.pdo.php';
include '../ResponseBase.Api.php';
include './models/forget.model.php';
include './services/forget.service.php';
include '../Link-Bitly.service.php';

//TODO ส่งรหัสผ่านให้ดีลเลอร์ ผ่านหัวข้อลืมรหัสผ่าน
$_forgetServ = new ForgetPassSendControl(PDO_CONNECTION::fourinsure_mitsu());
$Controller = empty($_POST['Controller'])?$_GET['Controller']:$_POST['Controller'];
switch ($Controller) {
    case 'CheckUser': {
            $model = new ForgetModelReq($_POST['UserCode']);
            $res = $_forgetServ->checkTelCustomer($model->user);
            if ($res == 400) {
                ResponseJsonApi::statusBad('ไม่พบเบอร์โทรศัพท์/ข้อมูลไม่ครบ');
            } else if ($res) {
                ResponseJsonApi::statusOk($res);
            } else {
                ResponseJsonApi::statusBad('ตรวจไม่พบ รหัสดีลเลอร์นี้');
            }
            break;
        }
    case 'SendPassSMS': {
            $model = new ForgetModelReq($_POST['DealerCode'], $_POST['Number']);
            $res = $_forgetServ->sendPassTosmsByUser($model);
            if ($res) {
                ResponseJsonApi::statusOk($res);
            } else {
                ResponseJsonApi::statusBad('ตรวจไม่พบ รหัสดีลเลอร์นี้');
            }
            break;
        }
    case 'CheckTel': {
            $res = $_forgetServ->checkTel();
            if ($res) {
                ResponseJsonApi::statusOk($res);
            } else {
                ResponseJsonApi::statusBad('ตรวจไม่พบ รหัสดีลเลอร์นี้');
            }

            break;
        }
    default: {
            ResponseJsonApi::statusFail('Not find controller.');
            break;
        }
}
