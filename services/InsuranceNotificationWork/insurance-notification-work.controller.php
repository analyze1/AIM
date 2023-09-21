<?php
require '../../inc/connectdbs.pdo.php';
require '../ResponseBase.Api.php';
require './model/insurance-notification-work.model.php';
require './service/general-information.service.php';
require '../ImportExcelFileRenew/service/import-data.service.php';
require './service/insured-information.service.php';
require './service/save-information.service.php';


try {

    $_serviceFour = new GeneralInformation(PDO_CONNECTION::fourinsure_insured());
    $_serviceMitSu = new GeneralInformation(PDO_CONNECTION::fourinsure_mitsu());

    $_serviceSaveFour = new SaveInformation(PDO_CONNECTION::fourinsure_insured());
    $_serviceInsurdFour = new InsuredInformation(PDO_CONNECTION::fourinsure_insured());


    if ($_POST['Controller'] == 'getTypeOfUse') {
        $service = $_serviceFour;
        $res = $service->getTypeOfUse();
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'getPassCarType') {
        $model = new PassCarTypeModelRequest();
        $model->passCarID = $_POST['passCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter passCarID !!') : $_POST['passCarID'];
        $service = $_serviceFour;
        $res = $service->getPassCarType($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'getCatCar') {
        $model = new PassCarTypeModelRequest();
        $model->passCarID = $_POST['passCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter passCarID !!') : $_POST['passCarID'];
        $service = $_serviceFour;
        $res = $service->getCatCar($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'getCatCarAct') {
        $model = new PassCarTypeModelRequest();
        $model->passCarID = $_POST['passCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter passCarID !!') : $_POST['passCarID'];
        $service = $_serviceFour;
        $res = $service->getCatCarAct($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'getBrandCar') {
        $model = new BrandCarModelRequest();
        $model->passCarID = $_POST['passCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter passCarID !!') : $_POST['passCarID'];
        $model->catCarID = $_POST['catCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter catCarID !!') : $_POST['catCarID'];
        $service = $_serviceFour;
        $res = $service->getBrandCar($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'getBrandCarAct') {
        $model = new BrandCarModelRequest();
        $model->passCarID = $_POST['passCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter passCarID !!') : $_POST['passCarID'];
        $model->catCarID = $_POST['catCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter catCarID !!') : $_POST['catCarID'];
        $service = $_serviceFour;
        $res = $service->getBrandCarAct($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'getModelCar') {
        $model = new ModelCarModelRequest();
        $model->brandCarID = $_POST['brandCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter brandCarID !!') : $_POST['brandCarID'];
        $model->passCarID = $_POST['passCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter passCarID !!') : $_POST['passCarID'];
        $service = $_serviceFour;
        $res = $service->getModelCar($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'getModelCarAct') {
        $model = new ModelCarModelRequest();
        $model->brandCarID = $_POST['brandCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter brandCarID !!') : $_POST['brandCarID'];
        $model->passCarID = $_POST['passCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter passCarID !!') : $_POST['passCarID'];
        $service = $_serviceFour;
        $res = $service->getModelCarAct($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'getTitleName') {
        $model = new TitleNameModelRequest();
        $model->personType = $_POST['personType'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter personType !!') : $_POST['personType'];
        $service = new InsuredInformation(PDO_CONNECTION::fourinsure_insured());
        $res = $service->getTitleName($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'getBranchName') {
        $model = new BranchNameModelRequest();
        $model->userName = $_POST['userName'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter userName !!') : $_POST['userName'];
        $service = $_serviceMitSu;
        $res = $service->getBranchName($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }
    if ($_POST['Controller'] == 'getCarColor') {
        $model = new BranchNameModelRequest();
        $model->userName = $_POST['color'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter color !!') : $_POST['color'];
        $service = new GeneralInformation(PDO_CONNECTION::fourinsure_mitsu());
        $res = $service->getCarColor($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }


    if ($_POST['Controller'] == 'getBeneficiary') {
        $service = $_serviceMitSu;
        $res = $service->getBeneficiary();
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'getProvince') {
        $service = $_serviceMitSu;
        $res = $service->getProvince();
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }




    if ($_POST['Controller'] == 'getAmphur') {
        $service = $_serviceMitSu;
        $model = new AddressModelRequest();
        $model->provinceID = $_POST['provinceID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter provinceID !!') : $_POST['provinceID'];
        $res = $service->getAmphur($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'getTumbon') {
        $service = $_serviceMitSu;
        $model = new AddressModelRequest();
        $model->amphurID = $_POST['amphurID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter amphurID !!') : $_POST['amphurID'];
        $res = $service->getTumbon($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'getPost') {
        $service = $_serviceMitSu;
        $model = new AddressModelRequest();
        $model->tumbonID = $_POST['tumbonID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter tumbonID !!') : $_POST['tumbonID'];
        $res = $service->getPost($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'DetailFollowKey') {
        $service =$_serviceMitSu;
        $model = new TypeRequest();
        $model->Type = $_POST['type'];
        $res = $service->getDetailFollowData($model->Type);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'SaveInformAfterQuotation') {

        $model = new AddressModelRequest();
        $res = $_serviceSaveFour->SaveInformAfterQuotation($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusNoContent($res);
        }
    }

    if ($_POST['Controller'] == 'DataRenewArray') {
        $service = $_serviceMitSu;
        $model = new DataRenewArrayRequest();
        $model->id_data = $_POST['iddata'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter iddata !!') : $_POST['iddata'];

        $res = $service->getDetailDataRenewArray($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }

    if ($_POST['Controller'] == 'getModelCarSub') {
        $model = new ModelCarModelRequest();
        $model->modelCarID = $_POST['modelCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter modelCarID !!') : $_POST['modelCarID'];
        $model->passCarID = $_POST['passCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter passCarID !!') : $_POST['passCarID'];
        $service = $_serviceFour;
        $res = $service->getModelCarSub($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }

    if($_POST['Controller'] == 'findInsurancePremiums'){
        $model = new stdClass();
        $model->carModelID = $_POST['carModelID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter carModelID !!') : $_POST['carModelID'];
        $model->carSubModelID = $_POST['carSubModelID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter carSubModelID !!') : $_POST['carSubModelID'];
        $model->passCarID = $_POST['passCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter passCarID !!') : $_POST['passCarID'];
        $model->carYear = $_POST['carYear'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter carYear !!') : $_POST['carYear'];
        $model->carBrandID = $_POST['carBrandID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter carBrandID !!') : $_POST['carBrandID'];
        $model->serviceCar = 1;
        //TODO เหลือทำ service เช็คเบี้ย
        $service = $_serviceInsurdFour;
        $res = $service->findInsurancePremiums($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }

    if($_POST['Controller'] == 'genOption-InsuranceCapital'){
        $model = new stdClass();
        $model->carSubID = $_POST['carSub'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter carSub !!') : $_POST['carSub'];
        //TODO เหลือทำ service เช็คเบี้ย
        $service = $_serviceMitSu;
        $res = $service->genOptionInsuranceCapital($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }
    
    if($_POST['Controller'] == 'findInsurancePremiumsByService'){
        $model = new stdClass();
        $model->carModelID = $_POST['carModelID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter carModelID !!') : $_POST['carModelID'];
        $model->carSubModelID = $_POST['carSubModelID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter carSubModelID !!') : $_POST['carSubModelID'];
        $model->passCarID = $_POST['passCarID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter passCarID !!') : $_POST['passCarID'];
        $model->carYear = $_POST['carYear'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter carYear !!') : $_POST['carYear'];
        $model->carBrandID = $_POST['carBrandID'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter carBrandID !!') : $_POST['carBrandID'];
        $model->serviceCar = $_POST['serviceCar'] == '' ? ResponseJsonApi::statusBadParams('ไม่พบข้อมูล parameter serviceCar !!') : $_POST['serviceCar'];
        //TODO เหลือทำ service เช็คเบี้ย
        $service = $_serviceInsurdFour;
        $res = $service->findInsurancePremiums($model);
        if ($res) {
            ResponseJsonApi::statusOk($res);
        } else {
            ResponseJsonApi::statusFail($res);
        }
    }

} catch (Exception $e) {
    ResponseJsonApi::statusFail($e->getMessage());
}