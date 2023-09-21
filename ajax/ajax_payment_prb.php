<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";

$q_auto=$_POST['q_auto'];
if($_SESSION["strUser"] == "admin")
{
$sql_quotation = "SELECT * FROM quotation WHERE customer = '2' AND q_auto LIKE '%QF%' AND q_auto = '".$q_auto."'";
}
else
{
$sql_quotation = "SELECT * FROM quotation WHERE customer = '2' AND agent_group = '".$_SESSION['strUser']."' AND q_auto LIKE '%QF%' AND q_auto = '".$q_auto."'";
}
$query_quotation = PDO_CONNECTION::fourinsure_insured()->query($sql_quotation);
$array_quotation = $query_quotation->fetch(2);

$date_new = explode(" ",$array_quotation['send_date']);
$date_create=date("Y-m-d",strtotime("+30 day".$date_new[0]));
$date_end=date("Y-m-d");
if(!empty($array_quotation))
{ 
	if($date_create >= $date_end)
	{ 
$grand_prb = '<font size="5"><span>เบี้ยสุทธิ : <b>'.$array_quotation['net_pre_dis'].'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
<span>เบี้ยรวม : <b>'.$array_quotation['pre_total'].'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
<span>เบี้ยพ.ร.บ. : <b>'.$array_quotation['prb_amt'].'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
<span>เบี้ยรวมพ.ร.บ. : <b>'.$array_quotation['grand_total'].'</b></span></font>
<input type="hidden" class="span2" id="js_q_auto" value="'.$q_auto.'" readonly>';
$grand = "<span><font color='green'>มีข้อมูลเลขที่ใบเสนอราคา ".$q_auto."</font></span>";
$check =  $q_auto;
if($array_quotation['cc']<=2000)
{
$car_cc="<option value='".$array_quotation['cc']."' selected='selected'>น้อยกว่า 2000 cc</option>";
}
else
{
$car_cc="<option value='".$array_quotation['cc']."' selected='selected'>มากกว่า 2000 cc</option>";
}
if($array_quotation['wg_name']<=3000 || $array_quotation['wg_name']=="")
{
$car_wgt="<option value='".$array_quotation['wg_name']."' selected='selected'>น้อยกว่า 3 ตัน</option>";
}
else
{
$car_wgt="<option value='".$array_quotation['wg_name']." selected='selected'>มากกว่า 3 ตัน</option>";
}
}
	else
	{
$grand_prb = '<font size="5"><span>เบี้ยสุทธิ : <b>'.$array_quotation['net_pre_dis'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
<span>เบี้ยรวม : <b>'.$array_quotation['pre_total'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
<span>เบี้ยพ.ร.บ. : <b>'.$array_quotation['prb_amt'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
<span>เบี้ยรวมพ.ร.บ. : <b>'.$array_quotation['grand_total'].'</b></span></font>
<input type="hidden" class="span2" id="js_q_auto" value="'.$q_auto.'" readonly>';
$grand = "<span><font color='red'>เลขที่ใบเสนอราคา ".$q_auto." หมดอายุแล้ว!</font></span><input type='hidden' id='js_q_auto' value='".$q_auto."' readonly>";
$check =  $q_auto;
if($array_quotation['cc']<=2000 || $array_quotation['cc']=="")
{
$car_cc="<option value='".$array_quotation['cc']."' selected='selected'>น้อยกว่า 2000 cc</option>";
}
else
{
$car_cc="<option value='".$array_quotation['cc']."' selected='selected'>มากกว่า 2000 cc</option>";
}
if($array_quotation['wg_name']<=3000 || $array_quotation['wg_name']=="")
{
$car_wgt="<option value='".$array_quotation['wg_name']."' selected='selected'>น้อยกว่า 3 ตัน</option>";
}
else
{
$car_wgt="<option value='".$array_quotation['wg_name']." selected='selected'>มากกว่า 3 ตัน</option>";
}
	}
} 
else
{
$grand = "";
if(strlen($q_auto)==8)
{
$grand .=  "<span><font color='red'>ไม่มีเลขที่ใบเสนอราคา ".$q_auto." !</font></span>";
$car_cc="<option value='0' selected='selected'>กรุณาเลือก</option>";
$car_wgt="<option value='0' selected='selected'>กรุณาเลือก</option>";
}
$grand .=  "<input type='hidden' id='js_q_auto' value='' readonly>";
$check = "";
$car_cc="<option value='0' selected='selected'>กรุณาเลือก</option>";
$car_wgt="<option value='0' selected='selected'>กรุณาเลือก</option>";
} 

$arraypayment['human_amt'] = $array_quotation['human_amt'];
$arraypayment['asset_amt'] = $array_quotation['asset_amt'];
$arraypayment['drive1_amt'] = $array_quotation['drive1_amt'];
$arraypayment['passenger'] = $array_quotation['passenger'];
$arraypayment['passenger_amt'] = $array_quotation['passenger_amt'];
$arraypayment['medic_amt'] = $array_quotation['medic_amt'];
$arraypayment['criminal_amt'] = $array_quotation['criminal_amt'];
$arraypayment['first_damage'] = $array_quotation['first_damage'];
$arraypayment['id_customer'] = $array_quotation['id_customer'];
$arraypayment['grand'] = $grand;
$arraypayment['grand_prb'] = $grand_prb;
$arraypayment['check'] = $check;
$sql_comp="SELECT name_print FROM tb_comp WHERE sort = '".$array_quotation['id_customer']."'";
$query_comp=PDO_CONNECTION::fourinsure_insured()->query($sql_comp);
$array_comp=$query_comp->fetch(2);
$arraypayment['name_print']=$array_comp['name_print'];
$sql_data_quotation = "SELECT doc_type FROM data_quotation WHERE  q_auto = '".$q_auto."'";
$query_data_quotation = PDO_CONNECTION::fourinsure_insured()->query($sql_data_quotation);
$array_data_quotation = $query_data_quotation->fetch(2);

if($array_data_quotation['doc_type']=='1' || $array_data_quotation['doc_type']=='2+' || $array_data_quotation['doc_type']=='3+')
{
$arraypayment['insu_amt'] = $array_quotation['insu_amt'];
}
else
{
$arraypayment['insu_amt'] = "ไม่ระบุ";
}

if($array_data_quotation['doc_type']=='1' || $array_data_quotation['doc_type']=='2+' || $array_data_quotation['doc_type']=='2')
{
$arraypayment['asset_dmg']=$array_quotation['insu_amt'];
}
else
{
$arraypayment['asset_dmg']="ไม่ระบุ";
}


if($array_quotation['first_damage']=='มี')
{
if($array_quotation['first_damage_amt']!="" || $array_quotation['first_damage_amt'] != null)
{
$arraypayment['first_damage_amt'] = $array_quotation['first_damage_amt'];
}
else
{
$arraypayment['first_damage_amt'] = "ไม่มี";
}
}
else if($array_quotation['first_damage']=='ไม่มี')
{
$arraypayment['first_damage_amt'] = "ไม่มี";
}
$arraypayment['car_cc'] = $car_cc;
$arraypayment['car_wgt'] = $car_wgt;

echo json_encode($arraypayment);
?>

