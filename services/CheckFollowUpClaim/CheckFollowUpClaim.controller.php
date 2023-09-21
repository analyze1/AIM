<?php
require("../../inc/connectdbs.pdo.php");
require("model/CheckFollowUpClaim.model.php");
require("service/CheckFollowUpClaim.service.php");

$_context = PDO_CONNECTION::fourinsure_mitsu();
try
{
    if($_POST['Controller'] == 'FollowUp')
    {
        $model = new FollowUpClaimRequestModel();
        $model->RequestData = $_POST;
        $model->UserLogin = $_POST['UserLogin'];
        $model->UserRights = $_POST['UserRights'];
        $model->Search = $_POST['search']['value'];

        $service = new CheckFollowUpClaimService($_context);
        $res = $service->createDataFollowUpClaim($model);

        if($res->Status != 200) throw new Exception('Request Error');

        echo json_encode($res);
    }
}
catch(Exception $e)
{
    echo json_encode(array('Data' => array('data'=>array()),'Status' => 400,'text' => 'Fail'));
}

?>