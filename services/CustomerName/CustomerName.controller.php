<?php
include "../../inc/connectdbs.pdo.php";
include "CustomerName.service.php";
if($_REQUEST['Control'] == 'LastComp')
{
    $response = new CustomerNameService(PDO_CONNECTION::fourinsure_insured());
    $response->getLastName($_REQUEST['DataTitle']);
}

?>