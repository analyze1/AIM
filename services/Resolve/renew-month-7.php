
    <?php
    echo json_encode(array('text'=>'turn off system'));
    exit();
    set_time_limit(36000);
    require('../../inc/connectdbs.pdo.php');

    // $test = PDO_CONNECTION::my4ibRenew()->query("SELECT `data`.n_insure AS insure,SUBSTRING(insure,0,14) AS sub FROM `data` WHERE `data`.n_insure != '' LIMIT 10 ")->fetchAll();

    // echo json_encode($test); exit();

    $str = "SELECT d.id_data AS ID, r.PolicyNuber AS insureID FROM RenewPremiumFinal09712 AS r 
    LEFT JOIN `data` AS d ON (SUBSTRING(d.n_insure,1,15) = r.PolicyNuber) ORDER BY r.PolicyNuber ASC";

    $info = PDO_CONNECTION::my4ibRenew()->query($str)->fetchAll(5);

    foreach ($info as $val)
    {
        if(!empty($val->ID))
        {
            $str = "UPDATE RenewPremiumFinal09712 SET IdData = :ID WHERE PolicyNuber = :numb";
            PDO_CONNECTION::my4ibRenew()->prepare($str)->execute(array(
                'ID'=> $val->ID,
                'numb'=> $val->insureID
            ));
        }
    }
    echo json_encode(array('Status'=>200,'Data'=>array('Text'=>'SUCCESS')));
    ?>
