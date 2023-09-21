<?php
require('../inc/connectdbs.pdo.php');
require('./VehicleType.service.php');

if($_POST['Controller'] == 'LoadActNameKey')
{
    $_ser = new GetVehicleTypeForApi();
    $_res = $_ser->loadIdActApi($_POST['CarType']);
    echo json_encode($_res);
}

if($_POST['Controller'] == 'ActPriceController')
{
    $_ser = new GetVehicleTypeForApi();
    $_res = $_ser->loadActPrice($_POST['ActTypeId']);
    echo json_encode($_res);
}

if($_POST['Controller']=='LoadDefaultAct')
{   
    $_ser = new GetVehicleTypeForApi();
    $_res = $_ser->loadActDefaultPrice($_POST['CarTypeID']);
    echo json_encode($_res);
}

?>