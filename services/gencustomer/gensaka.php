<?php 
require("../../inc/connectdbs.pdo.php");

$sql = "SELECT user FROM tb_customer WHERE region = 'ภาคกลาง'";
$cusArr = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetchAll(2);

$sqls = "SELECT code,saka FROM gensaka WHERE region = 'ภาคกลาง'";
$resSaka = PDO_CONNECTION::fourinsure_mitsu()->query($sqls)->fetchAll(2);


foreach ($cusArr as $cus)
{
    foreach ($resSaka as $saka)
    {
        if($saka['code'] == $cus['user'])
        {
            PDO_CONNECTION::fourinsure_mitsu()
            ->prepare("UPDATE tb_customer SET saka = '{$saka['saka']}' WHERE user = '{$cus['user']}'")
            ->execute();
            echo $cus['user'].' :: '. $saka['saka'].'<br>';
        }
    }
}
echo 'success';
