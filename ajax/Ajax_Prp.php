<?php
include "../inc/connectdbs.pdo.php";
$id = $_POST['idprp'];
$id_car = $_POST['id_car'];
	
	$sql = "SELECT * FROM tb_costprp WHERE id = '".$id."' AND code = '".$id_car."' ";
	$result = PDO_CONNECTION::fourinsure_mitsu()->query($sql);

	
	$i=0;
	foreach($result->fetchAll(2)  as $fetcharr )
	{ 
		$returnedArray[$i]['id'] = $fetcharr['id'];
		$returnedArray[$i]['prp'] = $fetcharr['prp'];
		$returnedArray[$i]['stamp'] = $fetcharr['stamp'];
		$returnedArray[$i]['tax'] = $fetcharr['tax'];
		$returnedArray[$i]['net'] = $fetcharr['net'];
		$i++;
	};
echo json_encode($returnedArray);

?>