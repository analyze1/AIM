<?php
include "../../inc/connectdbs.pdo.php";

	$CHECKCARBODY = $_POST['CHECKCARBODY'];
	
	$sql = "SELECT COUNT(car_body) FROM tb_listcar WHERE car_body='$CHECKCARBODY'";
	$result = mysql_query( $sql );
	$total = mysql_fetch_array($result);
	$returnedArray['STATUS']=$total[0];
		
echo json_encode($returnedArray);

?>