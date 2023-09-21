<?php
include "../../inc/connectdbs.pdo.php";
	$Editcall = $_POST['Editcallajax'];
	$Edittype = $_POST['Edittype'];
		//รหัส 220 ให้เรียกอุปกรณ์ของ 320
	if($Edittype==2)
	{
		$Edittype=3;
	}
	mysql_query("SET NAMES 'utf8'");
	
if($Editcall=="START1"){
	$sql = "SELECT price2,price, name FROM tb_acc WHERE cartype=$Edittype and price!='0.00'";
	$result = mysql_query( $sql );
	$i=0;
	while( $fetcharr = mysql_fetch_array( $result ) )
	{ 
		$returnedArray[$i]['price2'] = $fetcharr[price2]."|".$fetcharr[name];
		$returnedArray[$i]['price'] = $fetcharr[price]."|".$fetcharr[name];
		$returnedArray[$i]['name'] = number_format($fetcharr[name]);
		$i++;
	};
echo json_encode($returnedArray);
	}
	

mysql_close();
?>