<?php
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$id=$_POST['id_mo_car_sub'];
$select_mo_car_sql="SELECT color_use FROM tb_mo_car_sub
WHERE id = '".$id."' AND status_subcar = 'T'";
$select_mo_car_query=mysql_query($select_mo_car_sql,$cndb1); 
$select_mo_car_array=mysql_fetch_array($select_mo_car_query);
if(!empty($select_mo_car_array))
{
	$select_color_sql="SELECT id_color,color_name FROM tb_color WHERE id_color IN (".$select_mo_car_array['color_use'].") AND status = 'Y'";
	//echo $select_color_sql;
	$select_color_query=mysql_query($select_color_sql,$cndb1); 
	echo "<option value=''>--กรุณาเลือกสี--</option>";
	while($select_color_array=mysql_fetch_array($select_color_query))
	{ ?>
	<option value='<?php echo $select_color_array['id_color']; ?>'><?php echo $select_color_array['color_name']; ?></option>
<?php }
}
else
{
	echo "<option value=''>--กรุณาเลือกสี--</option>";
}

?>
