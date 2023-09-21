<?php include "../pages/check-ses.php";
include "../inc/connectdbs.inc.php";
mysql_select_db($db2,$cndb2);
$sort=$_POST['com_data'];
$car_id=$_POST['car_id'];
$car_old=$_POST['car_old'];
$repair=$_POST['repair'];
$mo=$_POST['mo'];
$end_date=$_POST['end_date'];
$cmocar_sz=$_POST['cmocar_sz'];
$doc_type=$_POST['doc_type'];
$comp_sql="SELECT Com_Prb,Com FROM tb_comp WHERE sort = '".$sort."'";
$comp_query=mysql_query($comp_sql,$cndb2);
$comp_array=mysql_fetch_array($comp_query);
$ucost_array['comp']=$comp_array['Com'];
$ucost_array['comp_prb']=$comp_array['Com_Prb'];
$check_date=date('Y-m-d');
			$tb_cost_mocar_sql="SELECT namegroup FROM tb_cost_mocar WHERE comp_sort = '".$sort."' AND cmocar_sz IN ('".$cmocar_sz."','ALL') AND cstatus_sz = 'Y' AND cm_datestart <=  '".$end_date."' AND cm_expire >= '".$end_date."' AND ins_type = '".$doc_type."'";
			//echo $tb_cost_mocar_sql;
			$tb_cost_mocar_query=mysql_query($tb_cost_mocar_sql,$cndb2);
			$tb_cost_mocar_array=mysql_fetch_array($tb_cost_mocar_query);
			//if(!empty($tb_cost_mocar_array))
			//{
			$tb_ucost_sql="SELECT cost,cost_end,cost_range FROM tb_cost WHERE used_suzuki IN('R','A') AND worktype IN ('R','A')  AND insured_type = '".$doc_type."' AND mocargroup = '".$tb_cost_mocar_array['namegroup']."' AND car_id = '".$car_id."' AND `car_old` <= '".$car_old."' AND `car_old_end` >= '".$car_old."' AND comp = '".$sort."' AND repair = '".$repair."' AND  create_date <= '".$end_date."' AND date_expired >= '".$end_date."' GROUP BY cost ORDER BY cost DESC";
			//}
			//else
			//{
			//$tb_ucost_sql="SELECT cost FROM tb_cost WHERE used_suzuki IN('R','A') AND insured_type = '".$doc_type."' AND mo = '".$mo."' AND car_id = '".$car_id."' AND `car_old` = '".$car_old."' AND comp = '".$sort."' AND repair = '".$repair."' AND date_expired >= '".$check_date."' GROUP BY cost ORDER BY cost DESC";
			//}
			$tb_ucost_query=mysql_query($tb_ucost_sql,$cndb2);
			//echo $tb_ucost_sql;
			// AND used_suzuki IN('R','A')
			$tb_ucost_array=mysql_fetch_array($tb_ucost_query);
			$to=0;
			$ucost_array['cost']="<option value=''>เลือกทุนประกัน</option>";
			if($tb_ucost_array['cost'] == $tb_ucost_array['cost_end'] || $tb_ucost_array['cost_range'] <= 0)
			{
				if(!empty($tb_ucost_array))
			{
				$tb_ucost_sql="SELECT cost,cost_end,cost_range FROM tb_cost WHERE used_suzuki IN('R','A') AND  worktype IN ('R','A')  AND insured_type = '".$doc_type."' AND mocargroup = '".$tb_cost_mocar_array['namegroup']."' AND car_id = '".$car_id."' AND `car_old` <= '".$car_old."' AND `car_old_end` >= '".$car_old."' AND comp = '".$sort."' AND repair = '".$repair."' AND  create_date <= '".$end_date."' AND date_expired >= '".$end_date."' GROUP BY cost ORDER BY cost ASC";
				$tb_ucost_query=mysql_query($tb_ucost_sql,$cndb2);
				while($tb_ucost_array=mysql_fetch_array($tb_ucost_query))
				{
				$ucost_array['cost'].="<option value='".$tb_ucost_array['cost']."'>".number_format($tb_ucost_array['cost'])."</option>";
				}
			}
			}
			else
			{
			if(!empty($tb_ucost_array))
			{
			for($n=$tb_ucost_array['cost'];$n<=$tb_ucost_array['cost_end'];$n+=$tb_ucost_array['cost_range'])
			{
			$ucost_array['cost'].="<option value='".$n."'>".number_format($n)."</option>";
			}
			}
			}
echo json_encode($ucost_array);
?>