<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
$id_mo_car=$_POST['id'];
mysql_select_db($db1,$cndb1);
if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$sql="AND tb_stock_car.car_status != 'Y' ";
	$sql_num="";
}
else
{
	$sql=" AND tb_stock_car.login = '".$_SESSION["strUser"]."' AND  tb_stock_car.car_status != 'Y' ";
	$sql_num=" AND login = '".$_SESSION["strUser"]."'";
}
$data= array();
$select_stock_sql="SELECT
tb_stock_car.car_regis_year,
tb_stock_car.startdate_payment,
tb_stock_car.enddate_payment,
tb_stock_car.date_sale,
tb_stock_car.date_save,
tb_color.color_name,
tb_color.color_name_e,
tb_stock_car.car_motor,
tb_stock_car.car_body,
tb_br_car.name As br_name,
tb_mo_car.name As mo_name,
tb_mo_car_sub.name As sub_name,
tb_stock_car.car_price,
tb_color.src,
tb_stock_car.id_stock
FROM tb_stock_car
LEFT JOIN tb_color ON (tb_stock_car.id_car_color = tb_color.id_color)
LEFT JOIN tb_br_car ON (tb_stock_car.id_br_car = tb_br_car.id)
LEFT JOIN tb_mo_car ON (tb_stock_car.id_mo_car = tb_mo_car.id)
LEFT JOIN tb_mo_car_sub ON (tb_stock_car.id_mo_car_sub = tb_mo_car_sub.id)
WHERE tb_stock_car.id_mo_car = '".$id_mo_car."'
".$sql." ORDER BY tb_stock_car.date_system DESC";
$select_stock_query=mysql_query($select_stock_sql,$cndb1);
while($select_stock_array=mysql_fetch_array($select_stock_query))
{
	$data_row['sub_name']=$select_stock_array['sub_name'];
	$data_row['car_regis_year']=$select_stock_array['car_regis_year'];
	$color_css="";
	if(!empty($select_stock_array['src']))
	{
		$color_css= "<img src='color_name/".$select_stock_array['src']."' class='img_table'>";
	}
	$data_row['color_name']=$select_stock_array['color_name']." ".$color_css;
	$data_row['car_motor']=$select_stock_array['car_motor'];
	$data_row['car_body']=$select_stock_array['car_body'];
	$data_row['car_price']=number_format($select_stock_array['car_price'],2,'.',',');
	$data_row['startdate_payment']=$select_stock_array['startdate_payment'];
	//$data_row['enddate_payment']=$select_stock_array['enddate_payment'];
	
	$data_row['enddate_payment']=(strtotime(date('Y-m-d'))/86400)-(strtotime($select_stock_array['date_save'])/86400)." วัน";
	$data_row['date_sale']=$select_stock_array['date_sale'];
	$data_row['button']="<center><a type='button' class='btn btn-small btn-success' onclick='form_quotation(\"".$select_stock_array['id_stock']."\")'>ทำใบเสนอราคา</a></center>";
	$data[] = $data_row;
}
echo json_encode(array('data'=>$data));
?>