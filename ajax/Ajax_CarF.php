<?php
include "../inc/connectdbs.pdo.php";
$_contextFour = PDO_CONNECTION::fourinsure_insured();

	$call = $_POST['callajax'];
	$cartype = $_POST['id_pass_car'];
	$cat_car = $_POST['cat_car'];
	$br_car = $_POST['br_car'];
	$mo_car = $_POST['mo_car'];
	$br_carNew = $_POST['br_car'];
	$mo_car_id = $_POST['mo_car_id'];
	
	// mysql_query("SET NAMES 'utf8'");
	
if($call=="START1"){
	$sql = "SELECT id, name FROM tb_pass_car where id != '2'";
	$result = $_contextFour->query($sql);
	$i=0;
	foreach($result->fetchAll(2) as $fetcharr )
	{ 
		$returnedArray[$i]['Id'] = $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['id']." : ".$fetcharr['name'];
		$i++;
	};
echo json_encode($returnedArray);
	}
	
if($call=="START2"){
	if($cartype!='01'){$cartype='03';}
	$sql = "SELECT idcartype, name FROM tb_cat_car WHERE idcartype ='$cartype' ORDER BY id";
	$result =  $_contextFour->query($sql);
	$i=0;
	foreach($result->fetchAll(2) as $fetcharr  )
	{
		$returnedArray[$i]['Id'] = $fetcharr['idcartype'];
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
echo json_encode($returnedArray);
	}


else if($call=="ID_CAR"){
	$sql = "SELECT id, name FROM tb_pass_car_type WHERE id_pass_car='$cartype'";
        
	$result = $_contextFour->query($sql);
	$i=0;
	foreach( $result->fetchAll(2) as $fetcharr )
	{ 
		$returnedArray[$i]['Id'] = $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['id']." : ".$fetcharr['name'];
		$i++;
	};
echo json_encode($returnedArray);
	}
	
else if($call=="BRAND")
{
	if($cat_car=='01')
	{
		$id='065';
	}
	else
	{
		$id='105';
	}
	
	$sql = "SELECT id, name FROM tb_br_car WHERE id=$id ORDER BY name";
	$result = $_contextFour->query($sql);
	$i=0;
	foreach( $result->fetchAll(2) as $fetcharr )
	{ 
		$returnedArray[$i]['Id'] = $id;
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}
else if($call=="BRAND2")
{	
	$sql = "SELECT id as Id, name as Name FROM tb_br_car WHERE cat_car_id REGEXP '$cat_car' AND `name` REGEXP 'MITSUBISHI' ";
        
	$result = $_contextFour->query($sql)->fetch(2);

	echo json_encode($result);
}

else if($call=="TYPE")
{
	if($br_car=='01')
	{
		$id='065';
		$selectcar = "id='759' OR id='1951' OR id='1960' OR id='1964' OR id='1967' OR id='1968' OR id='1969' OR id='1970' OR id='1971' ";
	}
	else
	{
		$id='105';$selectcar = " id='1098' ";
	}
	
	$sql = "SELECT id, name FROM tb_mo_car WHERE br_id=$id and $selectcar ORDER BY name";
	$result = $_contextFour->query($sql);
	$i=0;
	foreach( $result->fetchAll(2) as $fetcharr )
	{ 
		$returnedArray[$i]['Id'] = $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}
else if($call=="TYPE2")
{	
	$sql = "SELECT id as Id, name as `Name` FROM tb_mo_car WHERE br_id = $br_carNew AND `name` <> '' AND `name` <> '-' ORDER BY name";
	$result = $_contextFour->query($sql)->fetchAll(2);
	echo json_encode($result);
}

if($call=="getPieceCar")
{	
	$sql = "SELECT mocar_price FROM tb_mo_car WHERE id = $mo_car_id ";
	$result = $_contextFour->query($sql)->fetch(7);
	echo json_encode($result);
	exit();
}


?>