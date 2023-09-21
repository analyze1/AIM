<?php
include "../../inc/connectdbs.pdo.php";
$Editcall = $_POST['Editcallajax'];
$EditcostCost = $_POST['EditcostCost'];
$Editmo_car = $_POST['Editmo_car'];
$id_mo_car = $_POST['id_mo_car'];
$id_gear = $_POST['id_gear'];
$com_data = $_POST['com_data'];

//$EditcostCost = $_POST['Edit_idcost'];

		mysql_query("SET NAMES 'utf8'");
	
	
	if($Editcall=="COST"){
	$sql = "SELECT id, cost FROM tb_cost WHERE comp='$com_data' and mo='$id_mo_car' and cost_gear='$id_gear'";
	$result = mysql_query( $sql );
	$i=0;
	while( $fetcharr = mysql_fetch_array( $result ) )
	{ 
		$returnedArray[$i]['id'] = $fetcharr['id'];
		$returnedArray[$i]['cost'] = $fetcharr['cost'];
		$i++;
	};
echo json_encode($returnedArray);
	}
	
if($Editcall=="PRICE"){
	$sql = "SELECT * FROM tb_cost WHERE id='$EditcostCost'";
	$result = mysql_query( $sql );
	while( $fetcharr = mysql_fetch_array( $result ) )
	{ 
		$returnedArray['pre'] = $fetcharr[pre];
		$returnedArray['stamp'] = $fetcharr[stamp];
		$returnedArray['tax'] = $fetcharr[tax];
		$returnedArray['net'] = $fetcharr[net];
	};
echo json_encode($returnedArray);
	}
	
	
	mysql_close();
?>