<?php
include "../check-ses.php";
include "../inc/connectdbs.inc.php";
include "../inc/session_car.php";
mysql_select_db($db1,$cndb1);
$id_data=$_GET['id_data'];
$com_data=$_POST['com_data'];
$doc_type=$_POST['doc_type'];
$service=$_POST['service'];
$prb_total=$_POST['prb_total'];
$pre=$_POST['pre'];
$pre_total=$_POST['pre_total'];
$pre_prb_total=$_POST['pre_prb_total'];
$vat_1=$_POST['vat_1'];
$dis=$_POST['dis'];
$pre_deliver=$_POST['pre_deliver'];
$comp=$_POST['comp'];
$comp_prb=$_POST['comp_prb'];
$renew_follow=$_POST['renew_follow'];
$renew_wantevent=$_POST['renew_wantevent'];
$renew_next=$_POST['renew_next'];
$car_regis=$_GET['car_regis'];
$car_id=$_GET['car_id'];
$cost=$_POST['cost'];
$check_date=date('Y-m-d');


$pages_sql="SELECT pages FROM detail_renew WHERE id_data = '".$id_data."' AND pages !='' ORDER BY pages DESC LIMIT 0,1";
$pages_query=mysql_query($pages_sql,$cndb1);
$pages_array=mysql_fetch_array($pages_query);
if(!empty($pages_array['pages']))
{
	$pages=$pages_array['pages']+1;
}
else
{
	$pages=1;
}
//$delete_sql="DELETE FROM quotation_renew WHERE id_data = '".$id_data."'";
//$delete_query=mysql_query($delete_sql,$cndb1);
		


if(!empty($id_data))
{
	for($n=0;$n < count($com_data);$n++)
	{
		mysql_select_db($db2,$cndb2);
		$tb_cost_sql="SELECT protect_type FROM tb_cost WHERE used_suzuki IN ('R','A') AND car_id = '".$car_id."' AND repair = '".$service[$n]."' AND insured_type = '".$doc_type[$n]."' AND comp = '".$com_data[$n]."' AND cost = '".$cost[$n]."' AND  date_expired >='".$check_date."'";
//echo $tb_cost_sql;
		$tb_cost_query=mysql_query($tb_cost_sql,$cndb2);
$tb_cost_array=mysql_fetch_array($tb_cost_query);

$protection_sql="SELECT * FROM tb_protection WHERE protect_type = '".$tb_cost_array['protect_type']."' AND end_date >= '".$check_date."'";
//echo $protection_sql;
$protection_query=mysql_query($protection_sql,$cndb2);
$protection_array=mysql_fetch_array($protection_query);
		mysql_select_db($db1,$cndb1);
		$quotation_sql="INSERT INTO quotation_renew (id_data,com_data,doc_type,service,prb_total,pre,pre_total,pre_prb_total,vat_1,dis,pre_deliver,comp,comp_prb,car_regis,id_protec,cost,pages)
		VALUES ('".$id_data."','".$com_data[$n]."','".$doc_type[$n]."','".$service[$n]."','".$prb_total[$n]."','".$pre[$n]."','".$pre_total[$n]."','".$pre_prb_total[$n]."','".$vat_1[$n]."','".$dis[$n]."','".$pre_deliver[$n]."','".$comp[$n]."','".$comp_prb[$n]."','".$car_regis."','".$protection_array['id_protec']."','".number_format($cost[$n])."','".$pages."')";
		mysql_query($quotation_sql,$cndb1);
	}
	mysql_select_db($db1,$cndb1);
	//$claim_sql="SELECT user FROM tb_customer WHERE user LIKE '%admin%' AND user = '".$_SESSION["strUser"]."'";
	//$claim_query=mysql_query($claim_sql,$cndb1);
	//$claim_array=mysql_fetch_array($claim_query);
	if($_SESSION["strUser"]!='admin' && $_SESSION['claim']!='ADMIN')
	{
		$userdetail='DEALER';
	}
	else
	{
		$userdetail=$_SESSION["strUser"];
	}
if($renew_follow<=date('Y-m-d'))
{
	$date_follow='NOW()';
}
else
{
	 $date_follow="'".$renew_follow." ".date('H:i:s')."'";
}
	$renew_insert="INSERT INTO detail_renew (id_data,userdetail,status,detailtext,pages,date_alert,timecall,date_detail,detailcost,`lastrenew`) VALUES 
	('".$id_data."','".$userdetail."','R','".$renew_wantevent."','".$pages."','".$renew_next." 00:00:00',".$date_follow.",NOW(),
	'0|ไม่ระบุ|ไม่ระบุ|0.00|0|0|0|0|0|0|0|0|ไม่ระบุ','1')";
	$renew_query=mysql_query($renew_insert,$cndb1);
	//echo $renew_insert;
	
	//$renew_update="UPDATE data SET renew_follow='".$renew_follow."',renew_wantevent='".$renew_wantevent."',renew_next='".$renew_next."' WHERE id_data = '".$id_data."'";
	//mysql_query($renew_update,$cndb1);
	$array_renew['num_renew']=1;
	$array_renew['alert_renew']="บันทึกข้อมูลเรียบร้อยแล้วครับ";
}
else
{
	$array_renew['num_renew']=2;
	$array_renew['alert_renew']="บันทึกข้อมูลผิดพลาด";
}
echo json_encode($array_renew);
?>