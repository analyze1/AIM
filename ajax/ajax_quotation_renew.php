<?php
    include "../pages/check-ses.php";
	include "../inc/connectdbs.inc.php";
	mysql_select_db($db1,$cndb1);
	$id = $_POST['id'];
	$quotaion_renew_sql="SELECT * FROM quotation_renew WHERE id = '".$id."'";
	$quotation_renew_query=mysql_query($quotaion_renew_sql,$cndb1);
	$quotation_renew_array=mysql_fetch_array($quotation_renew_query);
	mysql_select_db($db2,$cndb2);
	$protection_sql="SELECT * FROM tb_protection WHERE id_protec='".$quotation_renew_array['id_protec']."'";
	$protection_query=mysql_query($protection_sql,$cndb2);
	$protection_array=mysql_fetch_array($protection_query);
if(!empty($protection_array['life']) || $protection_array['life']!=0)
	{
	$damage_out1="<option value='".number_format($protection_array['life'])."'>".number_format($protection_array['life'])."</option>";
	}
	else
	{
	$damage_out1="<option value='0'>ไม่ระบุ</option>";
	}
	if(!empty($protection_array['asset']) || $protection_array['asset']!=0)
	{
	$damage_cost="<option value='".number_format($protection_array['asset'])."'>".number_format($protection_array['asset'])."</option>";
	}
	else
	{
	$damage_cost="<option value='0'>ไม่ระบุ</option>";
	}
	if(!empty($protection_array['driver']) || $protection_array['driver']!=0)
	{
	$pa1="<option value='".number_format($protection_array['driver'])."'>".number_format($protection_array['driver'])."</option>";
	}
	else
	{
	$pa1="<option value='0'>ไม่ระบุ</option>";
	}
	if(!empty($protection_array['passenger']) || $protection_array['passenger']!=0)
	{
	$pa2="<option value='".number_format($protection_array['passenger'])."'>".number_format($protection_array['passenger'])."</option>";
	}
	else
	{
	$pa2="<option value='0'>ไม่ระบุ</option>";
	}
	if(!empty($protection_array['nurse']) || $protection_array['nurse']!=0)
	{
	$pa3="<option value='".number_format($protection_array['nurse'])."'>".number_format($protection_array['nurse'])."</option>";
	}
	else
	{
	$pa3="<option value='0'>ไม่ระบุ</option>";
	}
	if(!empty($protection_array['insuran']) || $protection_array['insuran']!=0)
	{
	$pa4="<option value='".number_format($protection_array['insuran'])."'>".number_format($protection_array['insuran'])."</option>";
	}
	else
	{
	$pa4="<option value='0'>ไม่ระบุ</option>";
	}
	if(!empty($protection_array['tickets']) || $protection_array['tickets']!=0)
	{
		$people=number_format($protection_array['tickets']);
	}
	else
	{
	$people="";
	}
	/*for($n=100000;$n<=20000000;$n+=100000)
	{
	$damage_out1.="<option value='".number_format($n)."'>".number_format($n)."</option>";
	}*/
	/*	for($n=100000;$n<=10000000;$n+=100000)
	{
	$damage_cost.="<option value='".number_format($n)."'>".number_format($n)."</option>";
	}*/
	/*for($n=50000;$n<=500000;$n+=10000)
	{
	$pa1.="<option value='".number_format($n)."'>".number_format($n)."</option>";
	}*/
	/*for($n=50000;$n<=500000;$n+=10000)
	{
	$pa2.="<option value='".number_format($n)."'>".number_format($n)."</option>";
	}*/
	/*for($n=50000;$n<=500000;$n+=10000)
	{
	$pa3.="<option value='".number_format($n)."'>".number_format($n)."</option>";
	}*/
	/*for($n=50000;$n<=5000000;$n+=50000)
	{
	$pa4.="<option value='".number_format($n)."'>".number_format($n)."</option>";
	}*/
	$prb_sql="SELECT id_act,net_act FROM tb_act WHERE net_act = '".str_replace(',','',$quotation_renew_array['prb_total'])."' AND id_act NOT IN ('110E','170E','310E','320E','170A','170B','170E','171','320F','320G','320H') AND id BETWEEN 1 AND 36";
	$prb_query=mysql_query($prb_sql,$cndb2);
	$prb_array=mysql_fetch_array($prb_query);
	if(!empty($prb_array))
	{
	$select_prb="<option value='".number_format($prb_array['net_act'],2,'.',',')."'>".$prb_array['id_act']."</option>";
	}
	else
	{
		$select_prb="<option value='0'>ไม่รวม</option>";
	}
	$prb_sql="SELECT id_act,net_act FROM tb_act WHERE id_act NOT IN ('110E','170E','310E','320E','170A','170B','170E','171','320F','320G','320H') AND id BETWEEN 1 AND 36";
	$prb_query=mysql_query($prb_sql,$cndb2);
	
	while($prb_array=mysql_fetch_array($prb_query))
	{
		$select_prb.="<option value='".number_format($prb_array['net_act'],2,'.',',')."'>".$prb_array['id_act']."</option>";
	}
	$quotation_message['damage_out1']=$damage_out1;
	$quotation_message['damage_cost']=$damage_cost;
	$quotation_message['pa1']=$pa1;
	$quotation_message['pa2']=$pa2;
	$quotation_message['pa3']=$pa3;
	$quotation_message['pa4']=$pa4;
	$quotation_message['people']=$people;
	$quotation_message['cost']=$quotation_renew_array['cost'];
	$quotation_message['pre']=$quotation_renew_array['pre'];
	$quotation_message['select_prb']=$select_prb;
	$quotation_message['currentValue_prb']=$quotation_renew_array['prb_total'];
	$quotation_message['commition']=$quotation_renew_array['dis'];
	if($quotation_renew_array['vat_1']=="0.00")
	{
	$quotation_message['vat1']="<option value='0' selected>ไม่รวม</option><option value='1'>1%</option>";
	$quotation_message['vat_1']=$quotation_renew_array['vat_1'];
	}
	else
	{
	$quotation_message['vat1']="<option value='0'>ไม่รวม</option><option value='1' selected>1%</option>";
	$quotation_message['vat_1']=$quotation_renew_array['vat_1'];
	}
	if(!empty($quotation_renew_array['doc_type']))
	{
		$quotation_message['doc_type']="<option value='".$quotation_renew_array['doc_type']."'>".$quotation_renew_array['doc_type']."</option>";
	}
	else
	{
	$quotation_message['doc_type']="<option value='0'>-- เลือกประเภท --</option>";
	}
        $quotation_message['doc_type'].="<option value='1'>1</option>";
                  $quotation_message['doc_type'].="<option value='2+'>2+</option>";
                  $quotation_message['doc_type'].="<option value='2'>2</option>";
                  $quotation_message['doc_type'].="<option value='3+'>3+</option>";
                  $quotation_message['doc_type'].="<option value='3'>3</option>";
                  $quotation_message['doc_type'].="<option value='3P'>3P</option>";
				  
				  if(!empty($quotation_renew_array['service']))
	{
		if($quotation_renew_array['service']=='1')
		{
			$service_name="ซ่อมห้าง";
		}
		else
		{
			$service_name="ซ่อมอู่";
		}
		
		$quotation_message['service']="<option value='".$quotation_renew_array['service']."'>".$service_name."</option>";
	}
	else
		{
	$quotation_message['service']="<option value='0'>--เลือกการซ่อม--</option>";
	}
$quotation_message['service'].="<option value='1'>ซ่อมห้าง</option>";	
$quotation_message['service'].="<option value='2'>ซ่อมอู่</option>";
mysql_select_db($db2,$cndb2);
$tb_comp_sql = "SELECT * FROM tb_comp where sort != 'VIB_Y' && sort != 'VIB' && sort != 'SCSMG_O' && sort != 'BKI[MBLT]' && sort != 'VIB_S042' ORDER BY name ASC ";
$tb_comp_query=mysql_query($tb_comp_sql,$cndb2);
$quotation_message['com_data']="<option value='0'>--เลือกบริษัท--</option>";
while($tb_comp_array=mysql_fetch_array($tb_comp_query))
{
	if($tb_comp_array['sort']==$quotation_renew_array['com_data'])
	{
	$quotation_message['com_data'].="<option value='".$tb_comp_array['sort']."' selected>".$tb_comp_array['name']."</option>";
	}
	else
	{
	$quotation_message['com_data'].="<option value='".$tb_comp_array['sort']."'>".$tb_comp_array['name']."</option>";
	}
	}
	echo json_encode($quotation_message);
	?>