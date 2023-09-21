<?php

require('../inc/connectdbs.pdo.php');

/****************** ตัวรับ POST ของ Controller ************************************ */
	$call = $_POST['callajax'];
	$cartype = $_POST['id_pass_car'];
	$_cartype = $_POST['Cartype'];
	$cat_car = $_POST['cat_car'];
	$br_car = $_POST['br_car'];
	$mo_car = $_POST['mo_car'];
	$br_carNew = $_POST['br_car'];
	$returnedArray = array();

if($call=="START1")
{
	$sql = "SELECT id, `name` FROM tb_pass_car where id != '2'";
	$_conMy4 = PDO_CONNECTION::fourinsure_mitsu();
	$result = $_conMy4->query($sql)->fetchAll();
	$i=0;
	foreach( $result as $fetcharr)
	{ 
		$returnedArray[$i]['Id'] = $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['id'].' : '.$fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
	
}	

if($call=="START2")
{
	if($cartype!='01')
	{
		$cartype='03';
	}

	$sql = "SELECT idcartype, name FROM tb_cat_car WHERE idcartype ='$cartype' ORDER BY id";
	$_conMy4 = PDO_CONNECTION::fourinsure_mitsu();
	$result = $_conMy4->query($sql)->fetchAll();
	$i=0;

	foreach( $result as $fetcharr)
	{
		$returnedArray[$i]['Id'] = $fetcharr['idcartype'];
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}
else if( $call == "ID_CAR" ) //รับ cartype มาหารถ
{
	$_cartype = $_POST['id_pass_car'];

	$sql = "SELECT id ,`name` FROM tb_pass_car_type WHERE id_pass_car='$_cartype'";
	$_conMy4 = PDO_CONNECTION::fourinsure_mitsu();
	$infoArr = $_conMy4->query($sql)->fetchAll();
	$i=0;

	foreach( $infoArr as $fetcharr )
	{ 
		$returnedArray[$i]['Id'] = $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['id'].' : '.$fetcharr['name'];
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
	$_conMy4 = PDO_CONNECTION::fourinsure_mitsu();
	$result = $_conMy4->query($sql)->fetchAll();
	$i=0;

	foreach( $result as $fetcharr)
	{ 
		$returnedArray[$i]['Id'] = $id;
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}
else if($call=="BRAND2")
{	
	$sql = "SELECT id, name FROM tb_br_car where cat_id = $cat_car ORDER BY name";
	$_conMy4 = PDO_CONNECTION::fourinsure_mitsu();
	$result = $_conMy4->query($sql)->fetchAll();
	$i=0;

	foreach($result as $fetcharr)
	{ 
		$returnedArray[$i]['Id'] = $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}

else if($call=="TYPE")
{
	if($br_car=='01')
	{
		$id='065';
		$selectcar = "status='T'";
	}
	else
	{
		$id='105';$selectcar = " id='1098' ";
	}
	
	$sql = "SELECT id, name FROM tb_mo_car WHERE br_id=$id and $selectcar ORDER BY name";
	$_conMy4 = PDO_CONNECTION::fourinsure_mitsu();
	$result = $_conMy4->query($sql)->fetchAll();
	$i=0;

	foreach( $result as $fetcharr)
	{ 
		$returnedArray[$i]['Id'] = $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}
else if($call=="TYPE2")
{	
	$sql = "SELECT id, name FROM tb_mo_car WHERE br_id = $br_carNew ORDER BY name";
	$_conMy4 = PDO_CONNECTION::fourinsure_mitsu();
	$result = $_conMy4->query($sql)->fetchAll();
	$i=0;

	foreach($result as $fetcharr)
	{ 
		$returnedArray[$i]['Id'] = $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}
else if($call=="BRAND2_FOUR")
{	

	$sql = "SELECT id, name FROM tb_br_car where cat_id = $cat_car ORDER BY name";
	$_conFour = PDO_CONNECTION::fourinsure_insured();

	$result = $_conFour->query($sql)->fetchAll();
	$i=0;

	foreach( $result as $fetcharr)
	{ 
		$returnedArray[$i]['Id'] = $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}
else if($call == "TYPE2_FOUR")
{	
	if ($_cartype == '1') $sqlAnd = "AND MakeTyte1 = '$_cartype'";
	if ($_cartype == '3') $sqlAnd = "AND MakeTyte3 = '$_cartype'";
	$sql = "SELECT id, name FROM tb_mo_car WHERE br_id = '$br_carNew' $sqlAnd AND name NOT IN(' ', '-') ORDER BY name";
	$_conFour = PDO_CONNECTION::fourinsure_insured();
	$result = $_conFour->query($sql)->fetchAll();
	$i=0;
	
	foreach( $result as $fetcharr)
	{ 
		$returnedArray[$i]['Id'] = $fetcharr['id'];
		$returnedArray[$i]['Name'] = $fetcharr['name'];
		$i++;
	};
	echo json_encode($returnedArray);
}

?>