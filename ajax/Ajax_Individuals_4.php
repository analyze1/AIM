<?php
ini_set("memory_limit","512M");
ob_start('ob_gzhandler');
include "../check-ses.php";
include "../../inc/connectdbs.pdo.php";
function thaiDate($datetime) {
	list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.

	switch($m) 
	{
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
$costOb = $_SESSION["Cost"];
$costObname = $_SESSION["CostName"];
$Pre = $_SESSION["CostPre"];
$MoC = $_SESSION["MoC"];
$EndYear = date('Y');
$StartYear = $EndYear-1;
$sql_data = "SELECT
	send_date,
	id_data,
	start_date,
	end_date,
	login,
	Status_Email,
	p_act,
	costCost
	FROM data
";
if($_SESSION["strUser"] == 'admin')
{
	$sql_data .= "WHERE fourib ='".$_SESSION["strUser"]."' AND YEAR(send_date) BETWEEN $StartYear AND $EndYear ORDER BY send_date DESC";
}
else
{
	$quesql_datary .= "WHERE login ='".$_SESSION["strUser"]."' AND YEAR(send_date) BETWEEN $StartYear AND $EndYear ORDER BY send_date DESC";
}
$que_data = mysql_query($sql_data);
$sql_detail= "SELECT
	id_data,
	mo_car,
	car_body,
	add_price,
	equit,
	n_motor
	FROM detail
";
$que_detail = mysql_query($sql_detail);
$sql_insuree= "SELECT
	id_data,
	CONCAT(title,' ',name,' ', last) AS name
	FROM insuree
	WHERE person = '1'
";
$que_insuree = mysql_query($sql_insuree);
$sql_req= "SELECT
	id_data,
	EditCancel,
	EditAct_id,
	EditProduct,
	CostProduct
	FROM req
	WHERE EditCancel != 'Y'
";
$que_req = mysql_query($sql_req);

$arr_detail = array();
while ($fet_detail = mysql_fetch_array($que_detail)) {
	$arr_detail[$fet_detail['id_data']] = $fet_detail;
}
$arr_insuree = array();
while ($fet_insuree = mysql_fetch_assoc($que_insuree)) {
	$arr_insuree[$fet_insuree['id_data']] = $fet_insuree;
}
$arr_req = array();
while ($fet_req = mysql_fetch_assoc($que_req)) {
	$arr_req[$fet_req['id_data']] = $fet_req;
}
$arr_data = array();
while ($fet_data= mysql_fetch_assoc($que_data)) {
	$Status_Email = null;
	$print_Insurance = null;
	if($fet_data['Status_Email'] == 'T')
	{
		$Status_Email = 'icon-ok';
		$print_Insurance = $fet_data['id_data'];
	}
	else
	{
		$Status_Email = 'icon-remove';
		$print_Insurance = null;
	}

	$print_act = null;
	if($arr_req[$fet_data['id_data']]['EditAct_id'] != '')
	{
		$print_act  = array($fet_data['id_data'],substr($arr_req[$fet_data['id_data']]['EditAct_id'],12,19));
	}
	else
	{
		$print_act  = array($fet_data['id_data'],substr($fet_data['p_act'],12,19));
	}

	$product = null;
	if($arr_detail[$fet_data['id_data']]['equit'] == 'Y')
	{
		$product = 'มี';
	}
	else if($arr_req[$fet_data['id_data']]['EditProduct'] == 'Y')
	{
		$product = 'มี';
	}
	else
	{
		$product = 'ไม่มี';
	}

	$CostProduct = null;
	if($arr_req[$fet_data['id_data']]['EditProduct'] == 'Y')
	{
		$CostProduct = number_format($arr_req[$fet_data['id_data']]['CostProduct'],2);
	}
	else
	{
		$CostProduct = number_format($arr_detail[$fet_data['id_data']]['add_price'],2);
	}
	array_push($arr_data, array(
		'Status_Email'=>$Status_Email,
		'print_Insurance'=>$print_Insurance,
		'id_data_send'=>$fet_data['id_data'],
		'name'=>$arr_insuree[$fet_data['id_data']]['name'],
		'send_date'=>thaiDate($fet_data['send_date']),
		'start_date'=>thaiDate($fet_data['start_date']),
		'print_act'=>$print_act,
		'mo_car'=>$MoC[$arr_detail[$fet_data['id_data']]['mo_car']],
		'car_body'=>array(
			$arr_detail[$fet_data['id_data']]['car_body'],
			$arr_detail[$fet_data['id_data']]['n_motor']
		),
		'cost'=>substr($Pre['PreCost'][$fet_data['costCost']],0,7),
		'pre'=>number_format($Pre['net'][$fet_data['costCost']],2),
		'product'=>$product,
		'CostProduct'=>$CostProduct
	));
}
$response = array(
	'data'=>$arr_data
);
echo json_encode($response);
ob_end_flush();
?>