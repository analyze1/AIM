<?php
require '../../inc/connectdbs.pdo.php';
require './Address.model.php';
require './Address.service.php';
try {
    $serv = new Address(PDO_CONNECTION::fourinsure_insured());
   
    if($_REQUEST['controller'] == 'getAllProvince'){        
        $response = $serv->getAllProvince();
        echo json_encode($response);
        exit();
    }
    if($_REQUEST['controller'] == 'getAmPhur'){
        $model = new AddressModel();
        $model->province = $_REQUEST['province'];
        $response = $serv->getAmPhur($model);
        echo json_encode($response);
        exit();
    }
    if($_REQUEST['controller'] == 'getTumBon'){
        $model = new AddressModel();
        $model->amphur = $_REQUEST['amphur'];
        $response = $serv->getTumBon($model);
        echo json_encode($response);
        exit();
    }
    
    if($_REQUEST['controller'] == 'getPostOffice'){
        $model = new AddressModel();
        $model->tumbon = $_REQUEST['tumbon'];
        $response = $serv->getPostOffice($model);
        echo json_encode($response);
        exit();
    }
} catch (Exception $e) {
    echo $e->getMessage();    
}