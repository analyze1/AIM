<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
$id_mo_car=$_POST['id'];
mysql_select_db($db1,$cndb1);
if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$sql="AND tb_my_car.car_status = 'Y' ";
	$sql_num="";
}
else
{
	$sql=" AND tb_my_car.login = '".$_SESSION["strUser"]."' AND  tb_my_car.car_status = 'Y' ";
	$sql_num=" AND login = '".$_SESSION["strUser"]."'";
}
if($id_mo_car>0)
{
$sql_select="
tb_my_car.id_my,
tb_stock_car.car_regis_year,
tb_stock_car.startdate_payment,
tb_stock_car.enddate_payment,
tb_stock_car.date_sale,
tb_color.color_name,
tb_color.color_name_e,
tb_color.src,
tb_stock_car.car_motor,
tb_stock_car.car_body,
tb_br_car.name As br_name,
tb_mo_car.name As mo_name,
tb_mo_car_sub.name As sub_name,
tb_stock_car.car_price,
tb_my_car.title,
tb_my_car.name,
tb_my_car.last,
tb_my_car.login
	";
	$sql_from="
	LEFT JOIN tb_stock_car ON (tb_my_car.id_stock = tb_stock_car.id_stock)
LEFT JOIN tb_color ON (tb_stock_car.id_car_color = tb_color.id_color)
LEFT JOIN tb_br_car ON (tb_stock_car.id_br_car = tb_br_car.id)
LEFT JOIN tb_mo_car ON (tb_stock_car.id_mo_car = tb_mo_car.id)
LEFT JOIN tb_mo_car_sub ON (tb_stock_car.id_mo_car_sub = tb_mo_car_sub.id)
	";
	$sql_where="tb_stock_car.id_mo_car = '".$id_mo_car."'";
}
else
{
	$sql_select=" * ";
	$sql_from="";
	$sql_where="tb_my_car.id_stock = '0'";
}
$data= array();
$select_my_sql="SELECT
".$sql_select."
FROM tb_my_car
".$sql_from."
WHERE ".$sql_where."
".$sql." ORDER BY tb_my_car.date_my_car DESC";
$select_my_query=mysql_query($select_my_sql,$cndb1);
while($select_my_array=mysql_fetch_array($select_my_query))
{
	$data_row['sub_name']=$select_my_array['sub_name'];
	$data_row['name']=$select_my_array['title']."".$select_my_array['name']." ".$select_my_array['last'];
	$data_row['car_regis']=$select_my_array['car_regis_year'];
	if(!empty($select_my_array['color_name_e']))
	{
		$color_css= "<img src='color_name/".$select_my_array['src']."' class='img_table'>";
	}
	$data_row['color_name']="<div style='padding:0px 0px 10px 0px;'>".$select_my_array['color_name']." ".$color_css."</div>";
	$data_row['car_motor']=$select_my_array['car_motor'];
	$data_row['car_body']=$select_my_array['car_body'];
	$data_row['car_price']=number_format($select_my_array['car_price'],2,'.',',');
	$data_row['login']=$select_my_array['login'];
	$data_row['button']="<center><button class='btn btn-small btn-success' onclick='detail_my_car(\"".$select_my_array['id_my']."\",\"".$select_my_array['title']."".$select_my_array['name']." ".$select_my_array['last']."\");' data-toggle='modal' data-target='#detail_my_car_modal'>ดูรายละเอียด</button></center>";
	$data[] = $data_row;
	
}
echo json_encode(array('data'=>$data));
?>