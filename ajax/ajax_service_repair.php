<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.inc.php";
mysql_select_db($db2,$cndb2);
$check_date=date('Y-m-d');
$car_old=$_POST['car_old'];
$comp=$_POST['com_data'];
$car_id=$_POST['car_id'];
$end_date=$_POST['end_date'];
$cmocar_sz=$_POST['cmocar_sz'];
$mo=$_POST['mo'];
$array_message['repair']="<option value=''>กรุณาเลือก</option>";
$array_message['insured_type']="<option value=''>กรุณาเลือก</option>";
$tb_cost_mocar_sql="SELECT namegroup FROM tb_cost_mocar WHERE comp_sort = '".$comp."' AND cmocar_sz IN ('".$cmocar_sz."','ALL') AND cstatus_sz = 'Y' AND cm_datestart <= '".$end_date."' AND cm_expire >= '".$end_date."'";
			//echo $tb_cost_mocar_sql;
			$tb_cost_mocar_query=mysql_query($tb_cost_mocar_sql,$cndb2);
			$tb_cost_mocar_array=mysql_fetch_array($tb_cost_mocar_query);
			//if(!empty($tb_cost_mocar_array))
		//	{
$repair_sql="SELECT repair FROM tb_cost WHERE used_suzuki IN('R','A') AND car_id = '".$car_id."' AND comp = '".$comp."' AND car_old <= '".$car_old."' AND  car_old_end >= '".$car_old."' AND create_date <= '".$end_date."' AND date_expired >= '".$end_date."' GROUP BY repair ORDER BY repair ASC";
			//}
			//else
			//{
				//$repair_sql="SELECT repair FROM tb_cost WHERE used_suzuki IN('R','A') AND mo = '".$mo."' AND car_id = '".$car_id."' AND comp = '".$comp."' AND car_old = '".$car_old."' AND date_expired >= '".$check_date."' GROUP BY repair ORDER BY repair ASC";

			//}
$repair_query=mysql_query($repair_sql,$cndb2);

	//echo $repair_sql;
while($repair_array=mysql_fetch_array($repair_query))
{
	if($repair_array['repair']==1)
	{
		$text_repair='ซ่อมห้าง';
	}
	else
	{
		$text_repair='ซ่อมอู่';
	}
	$array_message['repair'].="<option value='".$repair_array['repair']."'>".$text_repair."</option>";
}
//if(!empty($tb_cost_mocar_array))
//{
$insured_type_sql="SELECT insured_type FROM tb_cost WHERE used_suzuki IN('R','A') AND car_id = '".$car_id."'  AND comp = '".$comp."' AND car_old = '".$car_old."' AND date_expired >= '".$check_date."' GROUP BY insured_type ORDER BY insured_type ASC";
//echo $insured_type_sql;
//}
//else
//{
//	$insured_type_sql="SELECT insured_type FROM tb_cost WHERE used_suzuki IN('R','A') AND mo = '".$mo."' AND car_id = '".$car_id."'  AND comp = '".$comp."' AND car_old = '".$car_old."' AND date_expired >= '".$check_date."' GROUP BY insured_type ORDER BY insured_type ASC";

//}
$insured_type_query=mysql_query($insured_type_sql,$cndb2);

while($insured_type_array=mysql_fetch_array($insured_type_query))
{
		if($insured_type_array['insured_type']==1)
	{
		$text_repair='ป'.$insured_type_array['insured_type'];
	}
	else
	{
		$text_repair=$insured_type_array['insured_type'];
	}
	$array_message['insured_type'].="<option value='".$insured_type_array['insured_type']."'>".$text_repair."</option>";
}
echo json_encode($array_message);
?>