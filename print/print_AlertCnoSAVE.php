<?php
include "../pages/check-ses.php";
include('../fpdf.php');
include "../../inc/connectdbs.pdo.php";

function thaiDate($datetime) {
list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
$Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.


switch($m) {
case "01": $m = "01"; break;
case "02": $m = "02"; break;
case "03": $m = "03"; break;
case "04": $m = "04"; break;
case "05": $m = "05"; break;
case "06": $m = "06"; break;
case "07": $m = "07"; break;
case "08": $m = "08"; break;
case "09": $m = "09"; break;
case "10": $m = "10"; break;
case "11": $m = "11"; break;
case "12": $m = "12"; break;
}
return $d."/".$m."/".$Y;
} 

$ProName = $_SESSION["Pro"];
$AmpName = $_SESSION["Amp"];
$TumName = $_SESSION["Tum"];
$Cost_PRE = $_SESSION["CostPre"];
$MoC = $_SESSION["MoC"];

$queryCostrenew = "SELECT * FROM UCostRenew";
$objQueryRenew = mysql_query($queryCostrenew) or die ("Error Query [".$queryCostrenew."]");
while($rowRenew = mysql_fetch_array($objQueryRenew)) {
	$Renew[$rowRenew['type']][$rowRenew['cost']] = $rowRenew['pre'];
	$RenewCost[$rowRenew['type']][$rowRenew['cost']] = $rowRenew['id'];
}

$query = "SELECT *";

$query .= "FROM data ";
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";

//$query .= "WHERE data.com_data='VIB_C' AND YEAR(data.end_date) = '".intval(date('Y'),0)."'  AND send_cancel=''  ORDER BY data.end_date ASC ";
$query .= "WHERE data.id_data='55103/รย/064836' ";

$objQuery = mysql_query($query) or die ("Error Query [".$query."]");


while($row = mysql_fetch_array($objQuery)) {
$address_pdf  = '';
if($row['group'] !="-" && $row['group'] !="")
{
	$address_pdf = " หมู่ ".$row['group'];
}
if($row['town'] !="-" && $row['town'] !="")
{
	$address_pdf .= " หมู่บ้าน/อาคาร ".$row['town'];
}
if($row['lane'] !="-" && $row['lane'] !="")
{
	$address_pdf .= " ซอย ".$row['lane'];
}
if($row['road'] !="-" && $row['road'] !="")
{
	$address_pdf .= " ถนน ".$row['road'];
}


if($row['province'] != "102"){
	$address_pdf2 = 'ต.'.$TumName[$row['tumbon']].' อ.'.$AmpName[$row['amphur']];
	$address_pdf3 = 'จ.'.$ProName[$row['province']];
}
else{
	$address_pdf2 = 'แขวง'.$TumName[$row['tumbon']].' เขต'.$AmpName[$row['amphur']];
	$address_pdf3 = $ProName[$row['province']];
}

if(number_format($row['cat_car'],0)==1){
	$act_cost = '645.21';
	$pa1='1,000,000';
	$pa2='5,000,000';
	$pa3='200,000';
	$pa4='200,000';
	$pa5='200,000';
	$pa6='200,000';
	$seat='6';
}
else if(number_format($row['cat_car'],0)==3){
	$act_cost = '967.28';
	$pa1='300,000';
	$pa2='1,000,000';
	$pa3='200,000';
	$pa4='200,000';
	$pa5='50,000';
	$pa6='200,000';
	$seat='2';
}
/////////////////////////////////////คำนวนทุนต่ออายุ
$costW = explode(",",substr($Cost_PRE['PreCost'][$row['costCost']],0,7));
$CalculaCost = $costW[0].$costW[1];
if($CalculaCost>370000){
$ResultCost = $CalculaCost*95/100-10000;
}
else if($CalculaCost<=370000){
$ResultCost = $CalculaCost*90/100;
}
$Cost_NEW = ceil($ResultCost/10000)*10000+$row['price_total'];
//////////////////////////////////////////

echo $Renew[$_SESSION["MoCd"][$row['mo_car']]][$Cost_NEW]."  ".$row['id_data']." : ";
echo $Cost_NEW." ".$_SESSION["MoC"][$row['mo_car']];
echo "<BR>";
//$sqlM= "UPDATE URenew SET renew_vib = 'C' WHERE renew_id ='".$row['id_data']."'";


$sqlM= "INSERT INTO URenew (renew_id,renew_person,renew_title,renew_name,renew_last,renew_address,renew_address_shipping,renew_tel,renew_mobile,renew_telhome,renew_telwork,renew_cost,renew_costfix,renew_discount,renew_act,renew_login,renew_end,renew_car_id,renew_br_car,renew_mo_car,renew_car_body,renew_n_motor,renew_car_regis,renew_regis_pro,renew_color,renew_cc,renew_seat,renew_gear,renew_regisdate,renew_price_total,renew_vib) VALUES ('".$row['id_data']."','".$row['person']."','".$row['title']."','".$row['name']."','".$row['last']."','".$row['address']."','".$row['address2']."','".$row['tel_mobi']."','','','','$Cost_NEW','$Cost_NEW','10|20','$act_cost','".$row['login']."','".$row['end_date']."','".$row['car_id']."','".$row['br_id']."','".$row['mo_car']."','".$row['car_body']."','".$row['n_motor']."','".$row['car_regis']."','".$row['car_regis_pro']."','".$row['color']."','".$row['cc']."','".$row['seat']."','".$row['gear']."','".$row['regis_date']."','".$row['price_total']."','".$row['com_data']."')";

mysql_query($sqlM);
}
	echo $sqlM;
	//echo $query;
mysql_close();





?>