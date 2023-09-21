<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.inc.php";
mysql_select_db($db2,$cndb2);
$sort=$_POST['com_data'];
$doc_type=$_POST['doc_type'];
$service=$_POST['service'];
$car_id=$_POST['car_id'];
$end_date=$_POST['end_date'];
$check_date=date('Y-m-d');
$cost=$_POST['cost'];
$tb_cost_sql="SELECT protect_type FROM tb_cost WHERE used_suzuki IN ('R','A') AND car_id = '".$car_id."' AND repair = '".$service."' AND insured_type = '".$doc_type."' AND comp = '".$sort."' AND cost <= '".$cost."'  AND cost_end >= '".$cost."' AND create_date <= '".$end_date."' AND date_expired >='".$end_date."'";
$tb_cost_query=mysql_query($tb_cost_sql,$cndb2);
$tb_cost_array=mysql_fetch_array($tb_cost_query);
$protection_sql="SELECT life,asset,driver,passenger,nurse,insuran,tickets FROM tb_protection WHERE comp_insure = '".$sort."' AND pro_type = '".$doc_type."' AND end_date >= '".date('Y-m-d')."'";
//echo $protection_sql;
//protect_type = '".$tb_cost_array['protect_type']."'
$protection_query=mysql_query($protection_sql,$cndb2);
$protection_array=mysql_fetch_array($protection_query);
if(!empty($protection_array))
{
$protection_array['life']=number_format($protection_array['life']);
$protection_array['asset']=number_format($protection_array['asset']);
$protection_array['driver']=number_format($protection_array['driver']);
$protection_array['passenger']=number_format($protection_array['passenger']);
$protection_array['nurse']=number_format($protection_array['nurse']);
$protection_array['insuran']=number_format($protection_array['insuran']);
$protection_array['tickets']=number_format($protection_array['tickets'])." คน";
}
else
{
	$protection_array['life']="-";
$protection_array['asset']="-";
$protection_array['driver']="-";
$protection_array['passenger']="-";
$protection_array['nurse']="-";
$protection_array['insuran']="-";
$protection_array['tickets']="-";
}
echo json_encode($protection_array);
?>