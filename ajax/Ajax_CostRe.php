<?php
include "../inc/connectdbs.pdo.php";
$cost = $_POST['cost'];
$type = $_POST['type'];
$service = $_POST['service'];

if ($_POST['mo_car_re'] == 'ERTIGA') {
	$mo_car_re = '1960';
} else {
	$mo_car_re = '';
}

$sql = "SELECT pre,net FROM UCostRenew WHERE cost='$cost' AND type='$type' AND service = '$service' AND mo_car= '$mo_car_re' ";
$result = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetch(2);
$returnedArray['Cost'] = $result['pre'];
$returnedArray['Cost_net'] = $result['net'];

echo json_encode($returnedArray);
