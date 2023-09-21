<?php
require('./renew.vendor.php');

#region cross origin
//START API ใช้ร่วมระหว่างตัวงาน mitsubishi เอง และระบบ bos mitsubishi ต่ออายุ
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
header("Content-type: application/json; charset=utf-8");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') die();
$_SESSION['strUser'] = empty($_SESSION['strUser'])?$_POST['Staff']:$_SESSION['strUser'];
// if (empty($_POST)) {
//     $request = json_decode(file_get_contents("php://input"));
//     $_POST = (array)$request;
//     session_start();
//     $_SESSION['strUser'] = $_POST['Staff'];
//     echo $_SESSION['strUser'];exit;
// }
//END Register API endpoint
#endregion

$_renewService = new RenewDealerControl(
    PDO_CONNECTION::fourinsure_insured(),
    PDO_CONNECTION::my4ibRenew()
);

$_renewTelService = new RenewUpdateTelMainControl(
    PDO_CONNECTION::fourinsure_insured(),
    PDO_CONNECTION::my4ibRenew()
);

$_renewSmsService = new RenewSendSMSControl(
    PDO_CONNECTION::fourinsure_insured(),
    PDO_CONNECTION::my4ibRenew()
);

switch ($_POST['Controller']) {
    case 'CheckSmsRenew': {
            $body = (object) $_POST;
            $model = new RenewDealerModelRequest();
            $model->DataID = $body->DataID;
            $model->DetailRenewID = $body->DetailRenewID;
            $res = $_renewService->getMainTelNumberCusById($model);

            if (!$res) {
                $x = new RenewDealerModelResponse();
            } else {
                $x = new RenewDealerModelResponse();
                $x->Data = $res;
                $x->Status = 200;
                echo json_encode($x);
            }
            break;
        }

    case 'GetTelNumberCus': {
            $body = (object) $_POST;
            $model = new RenewGetTelCusModelRequest();
            $model->DataID = $body->DataID;
            $res = $_renewService->getTelTableInsure($model);
            if (!$res) {
                $x = new RenewDealerModelResponse();
            } else {
                $x = new RenewDealerModelResponse();
                $x->Data = $res;
                $x->Status = 200;
                echo json_encode($x);
            }
            break;
        }

        case 'GetTelNumberCusPayment': {
            $body = (object) $_POST;
            $model = new RenewGetTelCusModelRequest();
            $model->DataID = $body->DataID;
            $res = $_renewService->getTelTableInsurePayment($model);
            if (!$res) {
                $x = new RenewDealerModelResponse();
            } else {
                $x = new RenewDealerModelResponse();
                $x->Data = $res;
                $x->Status = 200;
                echo json_encode($x);
            }
            break;
        }

    case 'UpdateStatusTel': {
            $body = (object) $_POST;
            $model = new RenewUpdateTelMainModelRequest();
            $model->DataID = $body->DataID;
            $model->Number = $body->Number;
            $model->Pointer = $body->Pointer;
            $model->StatusFollow = $body->StatusFollow;
            $model->Details = $body->Details;
            $res = $_renewTelService->updateTelMainByNumberDataID($model);
            if (!$res) {
                $x = new RenewDealerModelResponse();
            } else {
                $x = new RenewDealerModelResponse();
                $x->Data = $res;
                $x->Status = 200;
                echo json_encode($x);
            }
            break;
        }

    case 'GetRelationshipRenew': {
            $res = $_renewTelService->getRelationshipRenewSuzuki($model);
            if (!$res) {
                $x = new RenewDealerModelResponse();
            } else {
                $x = new RenewDealerModelResponse();
                $x->Data = $res;
                $x->Status = 200;
                echo json_encode($x);
            }
            break;
        }

    case 'SaveTelCustomerRenew': {
            $body = (object) $_POST;
            $model = new RenewSaveTelephoneModelRequest();
            $model->Number = $body->Number;
            $model->Status = $body->Status;
            $model->Detail = $body->Detail;
            $model->Name = $body->Name;
            $model->Relation = $body->Relation;
            $model->DataID = $body->DataID;

            $res = $_renewTelService->saveTelephoneRenew($model);
            if (!$res) {
                $x = new RenewDealerModelResponse();
            } else {
                $x = new RenewDealerModelResponse();
                $x->Data = $res;
                $x->Status = 200;
                echo json_encode($x);
            }
            break;
        }

    case 'SendSmsQuotationRenew': {
            $body = (object) $_POST;
            $model = new RenewSmsDealerModelRequest();
            $model->DataID = $body->DataID;
            $model->DetailRenewID = $body->DetailID;
            $model->NumberList = $body->NumberList;
            $model->TypeDocRenew = $body->TypeDoc;
            $res = $_renewSmsService->sendQuotationBitlySms($model);
            if (!$res) {
                $x = new RenewDealerModelResponse();
            } else {
                $x = new RenewDealerModelResponse();
                $x->Data = $res;
                $x->Status = 200;
                echo json_encode($x);
            }
            break;
        }
    case 'SendSmsWarning':{

        $body = (object) $_POST;
        $model = new RenewSmsDealerModelRequest();
        $model->DataID = $body->DataID;
        $model->DetailRenewID = $body->DetailID;
        $model->NumberList = $body->NumberList;
        $model->TypeDocRenew = $body->TypeDoc;
        $res = $_renewSmsService->sendSmsWarning($model);
        if (!$res) {
            $x = new RenewDealerModelResponse();
        } else {
            $x = new RenewDealerModelResponse();
            $x->Data = $res;
            $x->Status = 200;
            echo json_encode($x);
        }
        break;
    }

    case 'SendSmsPaymentViriyah':{

        $body = (object) $_POST;
        $model = new PaymentViriyahSMSRequest();
        $model->DataID = $body->DataID;
        $model->Link = $body->Link;
        $model->Telophone = $body->Telophone;
        $res = $_renewSmsService->sendSmsPaymentViriyah($model);
        if (!$res) {
            $x = new RenewDealerModelResponse();
        } else {
            $x = new RenewDealerModelResponse();
            $x->Data = $res;
            $x->Status = 200;
            echo json_encode($x);
        }
        break;
    }
}