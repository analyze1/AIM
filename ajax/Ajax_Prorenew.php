<?php
include "check-ses.php"; 
//include "../inc/checksession.inc.php";
include "../inc/connectdbs.inc.php"; 
include "../inc/session_car.php";


mysql_select_db($db5,$cndb5);
	$call = $_POST['callajax'];
	$province = $_POST['province'];
	$amphur = $_POST['amphur'];
	$tumbon = $_POST['tumbon'];
	$cartype = $_POST['cartype'];
	$br = $_POST['br'];
	$mo = $_POST['mo'];
	

	mysql_query("SET NAMES 'utf8'");
	
	
if($call=="START1"){
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
	
	
if($call=="AMPHUR"){
	$sql = "SELECT id, name FROM tb_amphur where provinceID='$province' ORDER By name";
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
	
if($call=="TUMBON"){
	$sql = "SELECT id, name FROM tb_tumbon WHERE amphurID=$amphur ORDER By name";
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
	
if($call=="POST"){
	$sql = "SELECT id, id_post FROM tb_tumbon WHERE id=$tumbon";
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
	
if($call=="CARTYPE"){
	$sql = "SELECT id, name FROM tb_pass_car_type WHERE id_pass_car='$cartype' ORDER By id";
	$result = mysql_query( $sql );
	$i=0;
	while( $fetcharr = mysql_fetch_array( $result ) )
	{ 
		$returnedArray[$i]['Id'] = $cartype.$fetcharr[id];
		$returnedArray[$i]['Name'] = $fetcharr[id]." : ".$fetcharr[name];
		$i++;
	};
echo json_encode($returnedArray);
	}

if($call=="BR"){
	$sql = "SELECT id, name FROM tb_br_car WHERE cat_id='".number_format($br,0)."' ORDER BY name";
	$result = mysql_query( $sql );
	$i=0;
	while( $fetcharr = mysql_fetch_array( $result ) )
	{ 
		$returnedArray[$i]['Id'] = $cartype.$fetcharr[id];
		$returnedArray[$i]['Name'] = $fetcharr[name];
		$i++;
	};
echo json_encode($returnedArray);
	}

if($call=="MO"){
	$sql = "SELECT id, name FROM tb_mo_car WHERE br_id=$mo ORDER BY name";
	$result = mysql_query( $sql );
	$i=0;
	while( $fetcharr = mysql_fetch_array( $result ) )
	{ 
		$returnedArray[$i]['Id'] = $cartype.$fetcharr[id];
		$returnedArray[$i]['Name'] = $fetcharr[name];
		$i++;
	};
echo json_encode($returnedArray);
	}


mysql_close();
?>