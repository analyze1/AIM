<?php include "../pages/check-ses.php";
include "../inc/connectdbs.inc.php";
mysql_select_db($db2,$cndb2);
$sort=$_POST['com_data'];
$car_id=$_POST['car_id'];
$car_old=$_POST['car_old'];
$cost=$_POST['cost'];
$end_date=$_POST['end_date'];
$repair=$_POST['repair'];
$mo=$_POST['mo'];
$cmocar_sz=$_POST['cmocar_sz'];
$doc_type=$_POST['doc_type'];
$check_date=date('Y-m-d');
$tb_cost_sql="SELECT namegroup FROM tb_cost_mocar WHERE comp_sort = '".$sort."' AND cmocar_sz IN ('".$cmocar_sz."','ALL') AND cstatus_sz = 'Y' AND  cm_datestart <=  '".$end_date."' AND cm_expire >= '".$end_date."' AND ins_type = '".$doc_type."'";
//echo $tb_cost_sql;
$tb_cost_query=mysql_query($tb_cost_sql,$cndb2);
$tb_cost_array=mysql_fetch_array($tb_cost_query);
			//if(!empty($tb_cost_mocar_array))
			//{
			
			$tb_ucost_sql="SELECT pre FROM tb_cost WHERE used_suzuki IN('R','A') AND repair = '".$repair."' AND  insured_type = '".$doc_type."' AND  car_id = '".$car_id."' AND mocargroup = '".$tb_cost_array['namegroup']."' AND car_old <= '".$car_old."' AND car_old_end >= '".$car_old."' AND cost <= '".$cost."' AND cost_end >= '".$cost."'  AND comp = '".$sort."'  AND create_date <= '".$end_date."' AND date_expired >= '".$end_date."'";
			//echo $tb_ucost_sql;
			//}
			//else
			//{
			//$tb_ucost_sql="SELECT pre FROM tb_cost WHERE used_suzuki = 'R' AND insured_type = '".$doc_type."' AND mo = '".$mo."' AND cost = '".$cost."' AND car_id = '".$car_id."' AND car_old = '".$car_old."' AND comp = '".$sort."' AND repair = '".$repair."' AND date_expired >= '".$check_date."'";
			//}
//echo $tb_ucost_sql;
// AND used_suzuki IN('R','A')
			$tb_ucost_query=mysql_query($tb_ucost_sql,$cndb2);
			$tb_ucost_array=mysql_fetch_array($tb_ucost_query);
$costarray['pre']=number_format($tb_ucost_array['pre'],2,'.',',');
echo json_encode($costarray);

?>