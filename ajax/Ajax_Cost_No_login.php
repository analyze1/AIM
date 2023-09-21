<?php
// include "../pages/check-ses.php";
include "../../inc/connectdbs.pdo.php";
$start_date=date("Y-m-d");
$USER = $_SESSION["strUser"];
$call = $_POST['callajax'];
$costCost = $_POST['costCost'];
$com_data = $_POST['comdata'];
$cat_car = "0".$_POST['cat_car'];
$mo_car = $_POST['mo_car'];
$mo_car_sub = $_POST['mo_car_sub'];
$status_sub = $_POST['status_sub'];

$gear = $_POST['gear'];
$car_cc = $_POST['car_cc'];
$costCost = $_POST['idcost'];
$idCar = $_POST['idcar'];

if($mo_car_sub == '1')
{
	$id_mcs = "and id = '1046' ";
}
else if($mo_car_sub == '2')
{
	$id_mcs = "and id = '1079' ";
}
else if($mo_car_sub == '3')
{
	$id_mcs = "and id = '1047' ";
}
else if($mo_car_sub == '4')
{
	$id_mcs = "and id = '1080' ";
}
else if($mo_car_sub == '5')
{
	$id_mcs = "and id = '1048' ";
}
else if($mo_car_sub == '6')
{
	$id_mcs = "and id = '1081' ";
}
else if($mo_car_sub == '7')
{
	$id_mcs = "and id = '1049' ";
}
else if($mo_car_sub == '8')
{
	$id_mcs = "and id = '1082' ";
}
else if($mo_car_sub == '9')
{
	$id_mcs = "and id = '1083' ";
}
else
{
	$id_mcs = "";
}

if($_POST['cartype']=='2' AND $call=='START')
{
	$mo_car = '1952';
}

$modellist = explode(',',$_SESSION["MoList"][$mo_car]);
$listLock='';
for($imodel=0;$imodel<count($modellist);$imodel++)
{
	if($imodel==0)
	{
		$listLock .= "id='".$modellist[$imodel]."'";
	}
	else
	{
		$listLock .= "OR id='".$modellist[$imodel]."'";
	}
}
	mysql_query("SET NAMES 'utf8'");
	if($call=="START")
	{	
		if($USER=="admin")
		{
			$sql = "SELECT * FROM tb_comp where id > '110' ";
		}
		else if($_SESSION["strUser"]!="admin")
		{
			$sql = "SELECT * FROM tb_comp where $listLock ";
		}
		$result = mysql_query( $sql );
		$i=0;
		while( $fetcharr = mysql_fetch_array( $result ) )
		{ 
			$returnedArray[$i]['sort'] = $fetcharr[sort];
			$returnedArray[$i]['name'] = $fetcharr[name];
			$i++;
		};
			if($status_sub=='1')
	{
	$returnedArray['mo_sub_show']="<option value='0'>กรุณาเลือกรุ่นรถย่อย</option>";
	if($USER=="admin")
		{
	$mo_sub_sql="SELECT * FROM tb_mo_car_sub WHERE status_subcar ='T' and  mo_car = '".$mo_car."'";
		}
	else
		{
	$mo_sub_sql="SELECT * FROM tb_mo_car_sub WHERE status_dealer ='T' and  mo_car = '".$mo_car."'";		
		}
	$mo_sub_query=mysql_query($mo_sub_sql);
	while($mo_sub_array=mysql_fetch_array($mo_sub_query))
	{
	$returnedArray['mo_sub_show'].="<option value='".$mo_sub_array['id']."'>".$mo_sub_array['name']."</option>";
	}
	}
		echo json_encode($returnedArray);
	}
	if($call=="COST")
	{
		if($USER=='admin')
		{
			$sql = "SELECT * FROM tb_cost WHERE comp='$com_data' and cost_gear='$gear' and cc='$car_cc' and type='$cat_car' and mo='$mo_car' and idnew='$idCar' $id_mcs and cost_end_date >= '".$start_date."' order by cost ASC";
		}
		else
		{
			$sql = "SELECT * FROM tb_cost WHERE comp='$com_data' and cost_gear='$gear' and cc='$car_cc' and type='$cat_car' and mo='$mo_car' and fourib='0' and idnew='$idCar' $id_mcs and cost_end_date >= '".$start_date."' order by cost ASC";
		}
		$result = mysql_query( $sql );
		$i=0;
		while( $fetcharr = mysql_fetch_array( $result ) )
		{ 
			$returnedArray[$i]['id'] = $fetcharr[id];
			$returnedArray[$i]['cost'] = $fetcharr[cost];
			$i++;
		};
		echo json_encode($returnedArray);
	}
	
if($call=="PRICE"){
	$sql = "SELECT * FROM tb_cost WHERE id='$costCost'";
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