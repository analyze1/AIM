<?php
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$id_color=$_POST['id_color'];
$select_mo_car_sql="SELECT src FROM tb_color 
WHERE id_color = '".$id_color."' AND status= 'Y'";
$select_mo_car_query=mysql_query($select_mo_car_sql,$cndb1); 
$select_mo_car_array=mysql_fetch_array($select_mo_car_query);
if(!empty($select_mo_car_array))
{ 
echo "<img src='color_name/".$select_mo_car_array['src']."' class='img_color'>";
} ?>
