<?php
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$mo_car=$_POST['mo_car'];
$mo_car_body="|";
$data['select']="<option value=''>--กรุณาเลือกรุ่นรถย่อย--</option>";
$select_mo_car_sub_sql="SELECT tb_mo_car_sub.id,tb_mo_car_sub.name,tb_mo_car.mo_car_body FROM tb_mo_car_sub
INNER JOIN tb_mo_car ON (tb_mo_car_sub.mo_car = tb_mo_car.id)
WHERE tb_mo_car_sub.mo_car = '".$mo_car."' AND tb_mo_car_sub.status_subcar = 'T'";
$select_mo_car_sub_query=mysql_query($select_mo_car_sub_sql,$cndb1);

 while($select_mo_car_sub_array=mysql_fetch_array($select_mo_car_sub_query))
{
$mo_car_body=$select_mo_car_sub_array['mo_car_body']; 
$data['select'].="<option value='".$select_mo_car_sub_array['id']."'>".$select_mo_car_sub_array['name']."</option>";
} 
$data['car_body']=$mo_car_body;
echo json_encode($data);
?>
