<?php
include "../check-ses.php";
//include "../inc/checksession.inc.php";
include "../inc/connectdbs.pdo.php";

//include "../inc/session_renew.php";
include "../inc/session_car.php";

$costOb = $_SESSION["Cost"];
$costObname = $_SESSION["CostName"];
$TbCost = $_SESSION["TbCost"];
$MoC = $_SESSION["MoC"];
$BrC = $_SESSION["BrC"];
$user_id = $_SESSION["strUser"];

if($user_id =='admin')
{
$query = "SELECT 
	quotation.q_auto,
	quotation.id_car_regis,
	quotation.id_br_car,
	quotation.id_mo_car,
	quotation.remark_action ,
	data_quotation.send_date,
	data_quotation.login,
	insuree_quotation.title,
	insuree_quotation.name,
	insuree_quotation.last,
	insuree_quotation.status_sms,
	user.user_name,
	tb_mo_car.name As mo_name,
	tb_br_car.name As br_name
	FROM quotation 
	LEFT JOIN data_quotation ON data_quotation.q_auto = quotation.q_auto
	LEFT JOIN insuree_quotation ON insuree_quotation.q_auto = quotation.q_auto  
	LEFT JOIN user ON user.user_user = data_quotation.login
	LEFT JOIN tb_mo_car ON tb_mo_car.id = quotation.id_mo_car
	LEFT JOIN tb_br_car ON tb_br_car.id = quotation.id_br_car
	where quotation.qstatus='QF' AND date(data_quotation.send_date) >= date_add(curdate(),interval -2 month) AND date(data_quotation.send_date) <= curdate() order by quotation.q_auto desc";
}
else
{
$query = "SELECT 
	quotation.q_auto,
	quotation.id_car_regis,
	quotation.id_br_car,
	quotation.id_mo_car,
	quotation.remark_action ,
	data_quotation.send_date,
	data_quotation.login,
	insuree_quotation.title,
	insuree_quotation.name,
	insuree_quotation.last,
	insuree_quotation.status_sms,
	user.user_name,
	tb_mo_car.name As mo_name,
	tb_br_car.name As br_name
	FROM quotation 
	LEFT JOIN data_quotation ON data_quotation.q_auto = quotation.q_auto
	LEFT JOIN insuree_quotation ON insuree_quotation.q_auto = quotation.q_auto  
	LEFT JOIN user ON user.user_user = data_quotation.login
	LEFT JOIN tb_mo_car ON tb_mo_car.id = quotation.id_mo_car
	LEFT JOIN tb_br_car ON tb_br_car.id = quotation.id_br_car
	where  quotation.agent_group = '".$user_id."' AND quotation.qstatus='QF' AND date(data_quotation.send_date) >= date_add(curdate(),interval -2 month) AND date(data_quotation.send_date) <= curdate() order by quotation.q_auto desc";
}
$objQuery = PDO_CONNECTION::fourinsure_insured()->query($query);
$datas = array();
$i=0;
foreach ($objQuery->fetchAll(2) as $row) 
{	
		if($row['status_sms'] == "N")
		{
			$datas[$i]['button'] = '<div align="center">
			<a class="btn btn-small btn-success" title="พิมพ์ใบเสนอราคา" rel="tooltip" target="_blank" href="print/Quotation.php?iddta='.base64_encode($row['q_auto']).'"><i class="icon-white icon-print"></i> พิมพ์ใบเสนอราคา</a>
			<a class="btn btn-small btn-warning" title="แจ้งประกันภัย" rel="tooltip" href="#" onclick="edit_new(\''.base64_encode($row['q_auto']).'\')"><i class="icon-copy"></i> แจ้งประกันภัย</a>
			</div>';
		}
		else
		{
			$datas[$i]['button'] = '';
		}
		
		$datas[$i]['q_auto'] = '<div align="center">'.$row['q_auto'].'</div>';
		$datas[$i]['car_regis'] = '<div align="center">'.$row['id_car_regis'].'</div>';
		$datas[$i]['name_customer'] = '<div align="left">'.$row['title'].$row['name']." ".$row['last'].'</div>';
		//$datas[$i]['brand'] = '<div align="center">'.$BrC['name'][$row['id_br_car']].'<br/>'.$MoC['name'][$row['id_mo_car']].'</div>';
		if($row['id_br_car']==0 || $row['id_br_car']=='')
		{
		$br='-';
		}
		else
		{
		$br=$row['br_name'];
		}
		if($row['id_mo_car']==0 || $row['id_mo_car']=='')
		{
		$mo='-';
		}
		else
		{
		$mo=$row['mo_name'];
		}
		$datas[$i]['brand'] = '<div align="center">'.$br.' / '.$mo.'</div>';
		$datas[$i]['login'] = $row['user_name'];
		//$datas[$i]['remark'] = $row['remark_action'];
		
		$i++;
} // close quotation

$data['data']=$datas;

echo json_encode($data);

?>