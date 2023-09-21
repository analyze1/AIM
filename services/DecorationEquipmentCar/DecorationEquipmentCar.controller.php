<?php

// $_sArr = explode('/', $_SERVER['REQUEST_URI']);
// print_r($_sArr);
// exit;
require("../../inc/connectdbs.pdo.php");
require("model/DecorationEquipmentCar.model.php");
require("service/DecorationEquipmentCar.service.php");

$_context = PDO_CONNECTION::fourinsure_mitsu();

try {
    if ($_POST['Controller'] == 'CheckChangeTypeEquipment') {
        $service = new DecorationEquipmentCarService($_context);
        $res = $service->createChangeTypeCarStatus();

        if ($res->Status != 200) throw new Exception('Request Error');
        echo json_encode($res);
    }
} catch (Exception $e) {
    echo json_encode(array('Status' => 400, 'Text' => $e->getMessage()));
}