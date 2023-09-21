<?php
include "../inc/connectdbs.inc.php";
mysql_select_db($db2,$cndb2);
$select_sql="SELECT * FROM tb_cost WHERE year = '2014'";
$select_query=mysql_query($select_sql,$cndb2);
while($select_array=mysql_fetch_array($select_query))
{
	$insert_sql="INSERT INTO tb_cost (car_id,year,mo,cost,pre,stamp,tax,net,prb,total,cc,repair,comp,sub_id,solution,status_cost,protect_type,used_four)
	VALUES ('".$select_array['car_id']."','2016','".$select_array['mo']."','".$select_array['cost']."','".$select_array['pre']."',
	'".$select_array['stamp']."','".$select_array['tax']."','".$select_array['net']."','".$select_array['prb']."','".$select_array['total']."',
	'".$select_array['cc']."','".$select_array['repair']."','".$select_array['comp']."','".$select_array['sub_id']."','".$select_array['solution']."','".$select_array['status_cost']."','".$select_array['protect_type']."','".$select_array['used_four']."')";
	$query=mysql_query($insert_sql,$cndb2);
	if($query)
	{
		echo "สำเร็จ<br>";
	}
	else
	{
		echo "ไม่สำเร็จ<br>";
	}
}
?>