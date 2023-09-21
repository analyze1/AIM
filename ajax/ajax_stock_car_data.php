<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$type=$_POST['type_data'];
$key=$_POST['key_data'];
if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$sql="";

}
else
{
	$sql=" AND tb_stock_car.login = '".$_SESSION["strUser"]."' ";

}
$select_data_sql="SELECT
tb_stock_car.id_stock
,tb_stock_car.car_body
,tb_stock_car.car_motor
,tb_br_car.name As br_name
,tb_mo_car.name As mo_name
,tb_mo_car_sub.name As sub_name
,tb_stock_car.startdate_payment
,tb_stock_car.enddate_payment
,tb_stock_car.date_sale
,tb_stock_car.car_price
FROM tb_stock_car 
LEFT JOIN tb_br_car ON tb_stock_car.id_br_car = tb_br_car.id
LEFT JOIN tb_mo_car ON tb_stock_car.id_mo_car = tb_mo_car.id
LEFT JOIN tb_mo_car_sub ON tb_stock_car.id_mo_car_sub = tb_mo_car_sub.id
WHERE tb_stock_car.car_status != 'Y' ".$sql." ORDER BY date_system DESC";
//echo $select_data_sql;
$select_data_query=mysql_query($select_data_sql,$cndb1);
$x=0;
$n=0;
while($select_data_array=mysql_fetch_array($select_data_query))
{ $n++; $data_text="";
$data_row['id_br_car']=$select_data_array['br_name']; 
$data_text.="<b>&nbsp;&nbsp;&nbsp;ยี่ห้อ : ".$select_data_array['br_name']."</b>";
$data_row['id_mo_car']=$select_data_array['mo_name'];  
$data_text.="<b>&nbsp;&nbsp;&nbsp;รุ่นรถ : ".$select_data_array['mo_name']."</b>";
$data_row['id_mo_car_sub']=$select_data_array['sub_name'];  
$data_text.="<b>&nbsp;&nbsp;&nbsp;รุ่นรถย่อย : ".$select_data_array['sub_name']."</b>";
$data_row['car_body']=$select_data_array['car_body'];  
$data_text.="<b>&nbsp;&nbsp;&nbsp;เลขตัวถัง : ".$select_data_array['car_body']."</b>";
$data_row['car_motor']=$select_data_array['car_motor'];  
$data_text.="<b>&nbsp;&nbsp;&nbsp;เลขตัวเครื่อง : ".$select_data_array['car_motor']."</b>";
$data_row['car_price']=number_format($select_data_array['car_price'],2,'.',','); 
$data_text.="<b>&nbsp;&nbsp;&nbsp;วันเริ่มชำระ : ".$select_data_array['startdate_payment']."</b>&nbsp;&nbsp;&nbsp;<b>วันสิ้นสุดชำระ : ".$select_data_array['enddate_payment']."</b>&nbsp;&nbsp;&nbsp;<b>วันขายรถ : ".$select_data_array['date_sale']."</b>&nbsp;&nbsp;&nbsp;<b>ราคารถ : ".number_format($select_data_array['car_price'],2,'.',',');
$data_row['check']="<center><input name='number_car' id='number_car".$x."' type='radio' onclick='select_car_modal(\"".$select_data_array['id_stock']."\",\"".$data_text."\",\"".$x."\")'></center>";
$data_row['button']="<center><a type='button' class='btn btn-small btn-info'  data-toggle='modal' data-target='#search_car' onclick='data_car_modal(\"".$select_data_array['car_price']."\");' >คำนวณงวด</a></center>";
$data[] = $data_row;
$x++;
}
echo json_encode(array('data'=>$data));
?>
