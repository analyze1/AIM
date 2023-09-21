<?php
include "../check-ses.php";
include "../inc/connectdbs.inc.php";

if(isset($_POST['cancel'])){
	$sql_pay = "SELECT * FROM payment_installment WHERE int_iddata = '{$_POST[id_data]}' AND int_status = 'R' AND int_ref = 'RENEW|{$_POST[int_ref]}'";
	mysql_select_db($db3,$cndb3);
	$query_pay = mysql_query($sql_pay,$cndb3) or die (mysql_error()."<br>Error sql [".$sql_pay."]");
	$obj_pay = mysql_num_rows($query_pay);
	$res_pay = false;
	if($obj_pay > 0) {
		$res_pay = true;
	} else {
		$res_pay = false;
	}
	echo json_encode(array(
		'status'=>$res_pay
	));
} else if(isset($_POST['update'])){
	$sql_pay = "UPDATE payment_installment SET int_status = 'C', int_user='DEALER' WHERE int_iddata = '{$_POST[id_data]}' AND int_ref = 'RENEW|{$_POST[int_ref]}'";
	mysql_select_db($db3,$cndb3);
	$query_pay = mysql_query($sql_pay,$cndb3) or die (mysql_error()."<br>Error sql [".$sql_pay."]");
	$res_pay = false;
	if($query_pay) 
	{
		$res_pay = true;
	} 
	else
	 {
		$res_pay = false;
	}
	echo json_encode(array
	(
		'status'=>$res_pay
	));
} else if(isset($_POST['msg'])){
	$sql_pay = "SELECT * FROM payment_installment WHERE int_iddata = '{$_POST[id_data]}' AND int_status = 'R' AND int_ref = 'RENEW|{$_POST[int_ref]}'";
	mysql_select_db($db3,$cndb3);
	$query_pay = mysql_query($sql_pay,$cndb3) or die (mysql_error()."<br>Error sql [".$sql_pay."]");
	$obj_pay = mysql_fetch_array($query_pay);
	echo json_encode($obj_pay);
} else {
	$sql_pay = "SELECT * FROM payment_installment WHERE int_iddata = '{$_POST[id_data]}' AND int_status <> 'C' AND int_ref = 'RENEW|{$_POST[int_ref]}'";
	mysql_select_db($db3,$cndb3);
	$query_pay = mysql_query($sql_pay,$cndb3) or die (mysql_error()."<br>Error sql [".$sql_pay."]");
	$obj_pay = mysql_num_rows($query_pay);
	$res_pay = false;
	if($obj_pay > 0) {
		$res_pay = true;
	} else {
		$res_pay = false;
	}
	echo json_encode(array(
		'status'=>$res_pay
	));
}
?>