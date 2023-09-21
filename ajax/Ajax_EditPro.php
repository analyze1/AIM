<?php
include "../../inc/connectdbs.pdo.php";
	$Cus_call = $_POST['Cus_callajax'];
	$Cus_province = $_POST['Cus_province'];
	$Cus_amphur = $_POST['Cus_amphur'];
	$Cus_tumbon = $_POST['Cus_tumbon'];

	mysql_query("SET NAMES 'utf8'");
	
	
if($Cus_call=="START1"){
	$sql = "SELECT id, name FROM tb_province ORDER By name";
	$result = mysql_query( $sql );
	$i=0;
	while( $fetcharr = mysql_fetch_array( $result ) )
	{ 
		$returnedArray[$i]['Id'] = $fetcharr[id];
		$returnedArray[$i]['Name'] = $fetcharr[name];
		$i++;
	};
echo json_encode($returnedArray);
	}
	
	
if($Cus_call=="AMPHUR"){
	$sql = "SELECT id, name FROM tb_amphur where provinceID='$Cus_province' ORDER By name";
	$result = mysql_query( $sql );
	$i=0;
	while( $fetcharr = mysql_fetch_array( $result ) )
	{ 
		$returnedArray[$i]['Id'] = $fetcharr[id];
		$returnedArray[$i]['Name'] = $fetcharr[name];
		$i++;
	};
echo json_encode($returnedArray);
	}
	
if($Cus_call=="TUMBON"){
	$sql = "SELECT id, name FROM tb_tumbon WHERE amphurID=$Cus_amphur ORDER By name";
	$result = mysql_query( $sql );
	$i=0;
	while( $fetcharr = mysql_fetch_array( $result ) )
	{ 
		$returnedArray[$i]['Id'] = $fetcharr[id];
		$returnedArray[$i]['Name'] = $fetcharr[name];
		$i++;
	};
echo json_encode($returnedArray);
	}
	
if($Cus_call=="POST"){
	$sql = "SELECT id, id_post FROM tb_tumbon WHERE id=$Cus_tumbon";
	$result = mysql_query( $sql );
	$i=0;
	while( $fetcharr = mysql_fetch_array( $result ) )
	{ 
		$returnedArray[$i]['Id'] = $fetcharr[id_post];
		$returnedArray[$i]['Name'] = $fetcharr[id_post];
		$i++;
	};
echo json_encode($returnedArray);
	}
	

mysql_close();
?>