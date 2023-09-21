
<?php
// header('Content-Type: application/json');
// http_response_code(501);
// echo json_encode(['Text'=>'turn off service']);
// exit;
require('../inc/connectdbs.pdo.php');

$sql = "SELECT tel,code FROM number_tel_delaer";

$resultList = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetchAll(5);

$sqlC = "SELECT user FROM tb_customer";

$resultCList = PDO_CONNECTION::fourinsure_mitsu()->query($sqlC)->fetchAll(5);

$arr = array();
$i=1;

foreach ($resultCList as $value)
{
    foreach ($resultList as $x)
    {
        if($x->code == $value->user)
        {
            $sqlU = "UPDATE tb_customer SET Telephone = '$x->tel' WHERE user = '$x->code'";
            PDO_CONNECTION::fourinsure_mitsu()->prepare($sqlU)->execute();
            $i++;
        }
    }
}
echo 'success'. $i;
// echo json_encode($arr);



?>