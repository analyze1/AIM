<?php
include "../inc/connectdbs.inc.php"; 
mysql_select_db($db1,$cndb1);
$se_acc_sql="SELECT * FROM tb_car_cat_acc WHERE cost = '".$_POST['cost']."' AND car_id = '".$_POST['car_id']."' AND id_mo_car = '".$_POST['id_mo_car']."' AND id_mo_car_sub = '".$_POST['id_mo_car_sub']."' AND car_id_change = '".$_POST['car_id_change']."'";
$se_acc_query=mysql_query($se_acc_sql,$cndb1);
$se_acc_array=mysql_fetch_array($se_acc_query);
if($_POST['p_pre']=='Y' && !empty($se_acc_array)){$p_pre=$se_acc_array['p_total'];}else{$p_pre=0;}
if($_POST['b_pre']=='Y' && !empty($se_acc_array)){$b_pre=$se_acc_array['b_total'];}else{$b_pre=0;}
$total=$p_pre+$b_pre;
$messages['p_pre']=number_format($p_pre,2,'.',',');
$messages['b_pre']=number_format($b_pre,2,'.',',');
$messages['add_pre_at']=number_format($total,2,'.',',');
echo json_encode($messages);
?>
