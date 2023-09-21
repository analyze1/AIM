<?php
include "../inc/connectdbs.pdo.php";
	$call = $_POST['callajax'];
	$Dxuser = $_POST['saka'];

	

if($call=="SAKA")
{
	$sql = "SELECT * FROM tb_customer WHERE user='$Dxuser'";
	$result =  PDO_CONNECTION::fourinsure_mitsu()->query($sql);
	$fetcharr = $result->fetch(2);
	$returnedArray['saka'] = substr(date("Y")+543,2,2).$fetcharr['saka'];

	echo json_encode($returnedArray);
}	

if($call=="ACTNO")
{
	$query_act ="SELECT *  FROM z_act WHERE act_use = '".$Dxuser."' AND act_status = '1' ORDER BY act_id limit 5";
	$objQuery_act =PDO_CONNECTION::fourinsure_mitsu()->query($query_act);
	$i=0;
	foreach(  $objQuery_act->fetchAll(2) as $row_act )
	{ 
		$returnedArray[$i]['act_no'] = $row_act['act_no'];
		$i++;
	};

	echo json_encode($returnedArray);
}	


?>