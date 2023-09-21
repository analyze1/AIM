<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$sql="WHERE tb_my_car.car_status = 'Y' ";
	$sql_num="";
}
else
{
	$sql=" WHERE tb_my_car.login = '".$_SESSION["strUser"]."' AND tb_my_car.car_status = 'Y'";
	$sql_num=" AND login = '".$_SESSION["strUser"]."'";
}
$data= array();
$select_my_sql="SELECT tb_mo_car.name,
tb_stock_car.id_mo_car,
tb_stock_car.id_stock
FROM tb_my_car
LEFT JOIN tb_stock_car ON (tb_my_car.id_stock = tb_stock_car.id_stock)
LEFT JOIN tb_mo_car ON (tb_stock_car.id_mo_car = tb_mo_car.id)
".$sql."
GROUP BY tb_stock_car.id_mo_car";
$select_my_query=mysql_query($select_my_sql,$cndb1);


	/*$num_car_no_sql="SELECT id_stock FROM tb_my_car WHERE id_stock = '0' ".$sql_num."
	AND car_status = 'Y'";
	$num_car_no_query=mysql_query($num_car_no_sql,$cndb1);
	$num_car_no_num=mysql_num_rows($num_car_no_query);
	if($num_car_no_num>0)
	{
	$data_row['name_mo_car']="<div align='center'><span class='font_si'><font color='red'>ลูกค้าคาดหวัง (เนื่องจากไม่ได้จองรถ)</font></span></div>";
	$data_row['num_car']="<div align='center'><span class='font_si'>".$num_car_no_num."</span></div>";
	$data_row['button']="<div align='center'><input type='button' class='btn btn-small btn-success' onclick='show_detail_my(\"0\",\"-\")' value='ดูข้อมูล'></div>";
	$data[] = $data_row;
	}*/
while($select_my_array=mysql_fetch_array($select_my_query))
{
	$select_color_sql="SELECT color_name_e,id_car_color,src FROM tb_my_car
LEFT JOIN tb_stock_car ON (tb_my_car.id_stock = tb_stock_car.id_stock)
LEFT JOIN tb_color ON (tb_stock_car.id_car_color = tb_color.id_color)
".$sql." AND tb_stock_car.id_mo_car = '".$select_my_array['id_mo_car']."' GROUP BY tb_stock_car.id_car_color";
$select_color_query=mysql_query($select_color_sql,$cndb1);
$color_name="";
while($select_color_array=mysql_fetch_array($select_color_query))
{
	$select_color_num_sql="SELECT tb_my_car.id_my FROM tb_my_car
LEFT JOIN tb_stock_car ON (tb_my_car.id_stock = tb_stock_car.id_stock)
".$sql."  AND tb_stock_car.id_mo_car = '".$select_my_array['id_mo_car']."'  AND tb_stock_car.id_car_color = '".$select_color_array['id_car_color']."'";
$select_color_num_query=mysql_query($select_color_num_sql,$cndb1);
$select_color_num=mysql_num_rows($select_color_num_query);
	$color_name.='<div style="width:40px;height:20px;display:inline-block;"><img src="color_name/'.$select_color_array['src'].'" class="img_table"></div><font style="font-size:10px;">'.$select_color_num.'</font>';
}
	$num_car_sql="SELECT id_mo_car FROM tb_my_car
	LEFT JOIN tb_stock_car ON (tb_my_car.id_stock = tb_stock_car.id_stock)
	LEFT JOIN tb_mo_car ON (tb_stock_car.id_mo_car = tb_mo_car.id)
	WHERE id_mo_car = '".$select_my_array['id_mo_car']."' ".$sql_num."";
	$num_car_query=mysql_query($num_car_sql,$cndb1);
	$num_car_num=mysql_num_rows($num_car_query);
	if($num_car_num>0)
	{
	$data_row['name_mo_car']="<div align='center'><span class='font_si'>".$select_my_array['name']."</span></div>";
	$data_row['num_car']="<div align='center'><span class='font_si'>".$num_car_num."</span></div>";
	$data_row['button']="<div align='center'><input type='button' class='btn btn-small btn-success' onclick='show_detail_my(\"".$select_my_array['id_mo_car']."\",\"".$select_my_array['name']."\")' value='ดูข้อมูล'></div>";
	$data_row['color_name']=$color_name;
	$data[] = $data_row;
	}
}
echo json_encode(array('data'=>$data));
?>