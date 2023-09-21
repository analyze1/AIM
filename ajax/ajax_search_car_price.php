<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$id_car_color=$_POST['id_car_color'];
$id_mo_car_sub=$_POST['id_mo_car_sub'];
$select_car_price_sql="SELECT car_price,color_price FROM tb_mo_car_sub WHERE id = '".$id_mo_car_sub."'";
$select_car_price_query=mysql_query($select_car_price_sql,$cndb1);
$select_car_price_array=mysql_fetch_array($select_car_price_query);

if(!empty($id_car_color) && !empty($select_car_price_array))
{
	$car_price=explode("|",$select_car_price_array['car_price']);
	if($select_car_price_array['color_price']==$id_car_color)
	{
		echo number_format($car_price[0],2,'.',',');
	}
	else
	{
		echo number_format($car_price[1],2,'.',',');
	}
}
else
{
	echo "0.00";
}
?>