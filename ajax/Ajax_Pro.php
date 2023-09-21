<?php

require('../inc/connectdbs.pdo.php');

$call = $_POST['callajax'];
$province = $_POST['province'];
$amphur = $_POST['amphur'];
$tumbon = $_POST['tumbon'];

if ($call == "START1") {
	$sql = "SELECT id, `name` FROM tb_province ORDER By `name`";
	$result = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetchAll();
	$i = 0;
	foreach ($result as $fetcharr) {
		$returnedArray[$i]['Id'] = $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}


if ($call == "AMPHUR") {
	$sql = "SELECT id, `name` FROM tb_amphur where provinceID = '$province' ORDER By `name`";
	$result = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetchAll();
	$i = 0;
	foreach ($result as $fetcharr) {
		$returnedArray[$i]['Id'] = $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}

if ($call == "TUMBON") {
	$sql = "SELECT id, name FROM tb_tumbon WHERE amphurID = $amphur ORDER By name";
	$result = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetchAll();
	$i = 0;
	foreach ($result as $fetcharr) {
		$returnedArray[$i]['Id'] = $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}

if ($call == "POST") {
	$sql = "SELECT id, id_post FROM tb_tumbon WHERE id = $tumbon";
	$result = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetchAll();
	$i = 0;
	foreach ($result as $fetcharr) {
		$returnedArray[$i]['Id'] = $fetcharr['id_post'];
		$returnedArray[$i]['Name'] = $fetcharr['id_post'];
		$i++;
	};
	echo json_encode($returnedArray);
}
if ($call == "CARTYPE") {
	$sql = "SELECT id, name FROM tb_pass_car_type WHERE id_pass_car = '$_POST[cartype]' ORDER By id";
	$result = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetchAll();
	$i = 0;
	foreach ($result as $fetcharr) {
		$returnedArray[$i]['Id'] = $cartype . $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['id'] . ' : ' . $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}

if ($call == "BR") {
	$sql = "SELECT id, name FROM tb_br_car WHERE cat_id = '" . $br . "' ORDER BY name";
	$result = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetchAll();
	$i = 0;
	foreach ($result as $fetcharr) {
		$returnedArray[$i]['Id'] = $cartype . $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}

if ($call == "MO") {
	$sql = "SELECT id, name FROM tb_mo_car WHERE br_id = $mo ORDER BY name";
	$result = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetchAll();
	$i = 0;
	foreach ($result as $fetcharr) {
		$returnedArray[$i]['Id'] = $cartype . $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}

if ($call == "COM_NON") {
	$nontype = $_POST['noncom'];
	$sql = "SELECT id_nonmotor, name_print FROM tb_comp_nonmotor WHERE com_name = '" . $nontype . "'  AND non_status='1'  ORDER BY name_print";
	$result = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetchAll();
	$i = 0;
	foreach ($result as $fetcharr) {
		$returnedArray[$i]['Id'] = $fetcharr['id_nonmotor'];
		$returnedArray[$i]['Name'] = " [$fetcharr[id_nonmotor]] $fetcharr[name_print]";
		$i++;
	};
	echo json_encode($returnedArray);
}