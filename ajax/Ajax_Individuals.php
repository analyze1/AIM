<?php
//header('Content-Type: text/html; charset=UTF-8');
//header('Content-Type: text/html; charset=TIS-620');
include "../check-ses.php";

include "../inc/connectdbs.pdo.php";


if($_GET['order'][0]['column']!='' && $_GET['order'][0]['column'] > 0 && $_GET['order'][0]['dir']!='' && $_GET['columns'][$_GET['order'][0]['column']]['name']!='')
{
	$order_sql=" ORDER BY ".$_GET['columns'][$_GET['order'][0]['column']]['name']." ".$_GET['order'][0]['dir'];
}
if($_GET['start']!='' && $_GET['length']!='')
{
	$limit_sql=" LIMIT ".$_GET['start'].",".$_GET['length']." ";
}
$search = $_GET['search']['value'];

$tb_acc_new_sql = "SELECT id, `name` FROM tb_acc_new";
$tb_acc_new_query = PDO_CONNECTION::fourinsure_mitsu()->query($tb_acc_new_sql)->fetchAll();
$array_acc_new = array();

foreach($tb_acc_new_query as $tb_acc_new_array)
{
	$array_acc_new[$tb_acc_new_array['id']] = $tb_acc_new_array['name'];
}

$tb_acc_sql = "SELECT id,name,price FROM tb_acc";
$tb_acc_query = PDO_CONNECTION::fourinsure_mitsu()->query($tb_acc_sql)->fetchAll();
$array_acc_tung = array();
$array_acc_pre = array();

foreach( $tb_acc_query as $tb_acc_array)
{

	$array_acc_tung[$tb_acc_array['id']] = $tb_acc_array['name'];
	$array_acc_pre[$tb_acc_array['id']] = $tb_acc_array['price'];
}

if($_GET['req']==1){
	$req = " WHERE req.Req_Status = 'Y' ";
} else {
	$req=" WHERE req.Req_Status IN('Y','') " ;
}
if($_SESSION["strUser"]=='admin'){
	$user = " AND insuree.person = '".$_GET['person']."'";
} else {
	$user = " AND data.login = '".$_SESSION["strUser"]."' AND insuree.person = '".$_GET['person']."' ";
}
$sql_full = "SELECT data.id_data FROM data
INNER JOIN insuree ON (data.id_data = insuree.id_data)
	INNER JOIN act ON (data.id_data = act.id_data)
	INNER JOIN detail ON (data.id_data = detail.id_data)
	INNER JOIN req ON (data.id_data = req.id_data)
	INNER JOIN tb_br_car ON (detail.br_car = tb_br_car.id)
	INNER JOIN tb_mo_car ON (detail.mo_car = tb_mo_car.id)
	INNER JOIN tb_mo_car_sub ON (detail.mo_sub = tb_mo_car_sub.id)
	INNER JOIN protect ON (data.id_data = protect.id_data)
	INNER JOIN tb_cost ON (protect.costCost = tb_cost.id)
".$req." ".$user." 
AND (
			data.id_data LIKE '%".$search."%'
			OR insuree.name LIKE '%".$search."%'
			OR insuree.last LIKE '%".$search."%'
			OR insuree.title LIKE '%".$search."%'
			OR detail.car_body LIKE '%".$search."%'
			OR detail.n_motor LIKE '%".$search."%'
			OR act.p_act LIKE '%".$search."%'
			OR req.EditAct_id LIKE '%".$search."%'
			OR req.Edit_CarBody LIKE '%".$search."%'
			OR req.Edit_Nmotor LIKE '%".$search."%'
			OR req.Cus_title LIKE '%".$search."%'
			OR req.Cus_name LIKE '%".$search."%'
			OR req.Cus_last LIKE '%".$search."%'
			)";
$sql_query_full = PDO_CONNECTION::fourinsure_mitsu()->query($sql_full)->fetchAll();
$rowfull = count($sql_query_full);
$sql = "
	SELECT
		data.Status_Email,
		data.id_data,
		data.Advance,
		insuree.title,
		insuree.name,
		insuree.last,
		insuree.ws_prb_status, 
		data.send_date,
		data.start_date,
		data.end_date,
		act.PactOnline, 
		act.p_act,
		act.tmp_act_id,
		act.ws_path_policy,
		detail.mo_car,
		detail.car_body,
		detail.n_motor,
		detail.br_car,
		detail.mo_car,
		detail.mo_sub,
		detail.add_price,
		tb_mo_car.name As m_name,
		tb_mo_car_sub.name As s_name,
		tb_cost.net,
		tb_cost.cost,
		detail.car_detail,
		req.Product,
		req.EditAct,
		req.EditAct_id,
		req.EditTime,
		req.EditTime_StartDate,
		req.EditTime_EndDate,
		req.EditCar,
		req.Edit_CarBody,
		req.Edit_Nmotor,
		req.Edit_CarColor,
		req.EditCustomer,
		req.Cus_title,
		req.Cus_name,
		req.Cus_last,
		req.EditProduct,
		req.CostProduct,
		insuree.person

	FROM data
	INNER JOIN insuree ON (data.id_data = insuree.id_data)
	INNER JOIN act ON (data.id_data = act.id_data)
	INNER JOIN detail ON (data.id_data = detail.id_data)
	INNER JOIN req ON (data.id_data = req.id_data)
	INNER JOIN tb_br_car ON (detail.br_car = tb_br_car.id)
	INNER JOIN tb_mo_car ON (detail.mo_car = tb_mo_car.id)
	INNER JOIN tb_mo_car_sub ON (detail.mo_sub = tb_mo_car_sub.id)
	INNER JOIN protect ON (data.id_data = protect.id_data)
	INNER JOIN tb_cost ON (protect.costCost = tb_cost.id)
	
	".$req." ".$user."
	AND (
			data.id_data LIKE '%".$search."%'
			OR insuree.name LIKE '%".$search."%'
			OR insuree.last LIKE '%".$search."%'
			OR insuree.title LIKE '%".$search."%'
			OR detail.car_body LIKE '%".$search."%'
			OR detail.n_motor LIKE '%".$search."%'
			OR act.p_act LIKE '%".$search."%'
			OR req.EditAct_id LIKE '%".$search."%'
			OR req.Edit_CarBody LIKE '%".$search."%'
			OR req.Edit_Nmotor LIKE '%".$search."%'
			OR req.Cus_title LIKE '%".$search."%'
			OR req.Cus_name LIKE '%".$search."%'
			OR req.Cus_last LIKE '%".$search."%'
			)
	ORDER BY data.send_date DESC
	".$limit_sql." ";
$sql_query = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetchAll();
$i=0;

function checkActApiPrint($actHandle,$actApi)
{
	if($actHandle != '-')
	{
		$_act = explode('-',$actHandle);
		if($_act[2]=='9999999' && $actApi!='')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return true;
	}
	
}

foreach($sql_query as $row)
{
	if($row['Status_Email'] == 'T')
	{
		$status_Email = "<center><i class='icon-white icon-ok'></i></center>";
		$array_date = explode(" ",$row['send_date']);
		if(date('Y-m-d',strtotime($array_date[0])) >= date('Y-m-d',strtotime('2019-05-15')))
		{
			$print_Insurance = "<a class='btn btn-success btn-small' title='ใบคำขอประกันภัย' rel='tooltip' onclick='print_Insurance_new(\"".$row['id_data']."\");'><i class='icon-white icon-print'></i> </a>";
		}
		else
		{
			$print_Insurance = "<a class='btn btn-success btn-small' title='ใบคำขอประกันภัย' rel='tooltip' onclick='print_Insurance(\"".$row['id_data']."\");'><i class='icon-white icon-print'></i> </a>";
		}
	}
	else
	{
		$status_Email ="<center><i class='icon-white icon-remove'></i></center>";
		$print_Insurance="";
	}

	if( $row['ws_path_policy'] == '' && $row['ws_prb_status'] == 'N' && $_SESSION['strUser']=='admin' )
	{
		$print_Insurance .="<button class='btn btn-primary btn-small' title='ส่ง Smart พ.ร.บ. อีกครั้ง' onclick='ResolveAPIAct(\"$row[id_data]\");'>API</button>";
	}

	$datas[$i]['Status_Email']=$status_Email;
	$datas[$i]['print_Insurance']=$print_Insurance;
	if($row['Advance']=='Y')
	{
		$datas[$i]['id_data_send']="<a data-toggle='modal' class='btn btn-small btn-warning' onclick='open_check(\"pages/send_Check.php?IDDATA=".$row['id_data']."\");' aria-hidden='true' data-target='#modal'>".$row['id_data']."</a>";
	}
	else
	{
		$datas[$i]['id_data_send']="<a data-toggle='modal' class='btn btn-small btn-info' onclick='open_check(\"pages/send_Check.php?IDDATA=".$row['id_data']."\");' aria-hidden='true' data-target='#modal'>".$row['id_data']."</a>";
	}	
	
	$datas[$i]['name']=$row['title'].$row['name']." ".$row['last'];
	if($row['EditCustomer']=='Y')
	{
	$datas[$i]['name'].="<br><font color='red'>".$row['Cus_title'].$row['Cus_name']." ".$row['Cus_last']."</font>";
	}
	$datas[$i]['send_date']=$row['send_date'];
	$datas[$i]['start_date']=$row['start_date'];
	if($row['EditTime']=='Y')
	{
	$datas[$i]['start_date'].="<br><font color='red'>".$row['EditTime_StartDate']."</font>";
	}

	//SESSION START CHECK Y
	if($_SESSION["use_prb"]=='Y')
	{
		if(!empty($row['tmp_act_id']))
		{
			$datas[$i]['print_act']="<center><a style='padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-info' href='".$row['ws_path_policy']."' target='_blank'>".$row['tmp_act_id']."</a></center>";
		}
		else if($row['p_act']!='')
		{
			$datas[$i]['print_act']="<center><a style='padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-info'href='print/print_Act.php?IDDATA=".$row['id_data']."' target='_blank'>".$row['p_act']."</a></center>";
			if($row['EditAct']=='Y')
			{
				$datas[$i]['print_act'].="<center><a style='color:red !important;padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-info' href='print/print_Act.php?IDDATA=".$row['id_data']."' target='_blank'>".$row['EditAct_id']."</a></center>";
			}
		}
		else
		{
			$datas[$i]['print_act']="<center><a style='padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-info' onclick=\"load_page('ajax/ajax_realtime_webservice_prb.php?iddata=".$row['id_data']."','WEBSERVICE PRB');\" href='javascript:0'>ออก พ.ร.บ.</a></center>";
		}
	}
	//SESSION END CHECK Y
	else
	{
		
		if($row['ws_prb_status'] == 'N')//เช็ค API ว่าเจนไม่ได้แน่ๆ
		{
			$datas[$i]['print_act']="<center><button class='btn btn-small btn-danger'>".$row['p_act']."</button></center>";
		}
		else if(checkActApiPrint($row['p_act'],$row['PactOnline']) == false)
		{
			$datas[$i]['print_act']="<center><a style='padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-info' href='print/print_Act.php?IDDATA=".$row['id_data']."' target='_blank'>".$row['p_act']."</a></center>";
			if($row['EditAct']=='Y')
			{
				$datas[$i]['print_act'].="<center><a style='color:red !important;padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-info' href='print/print_Act.php?IDDATA=".$row['id_data']."' target='_blank'>".$row['EditAct_id']."</a></center>";
			}
		}
		else
		{
			$datas[$i]['print_act'] = "<div class='btn-api-center'>-</div>";
		}

		//PRB ONLINE API ตั้งป้อมแสดงปุ่ม 
		if($row['ws_path_policy']=='')
		{ 
			$datas[$i]['WSAPIONLINE'] = "<div class='btn-api-center'>-</div>";
		}
		else
		{
			$datas[$i]['WSAPIONLINE'] = "<a style='padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-success' href='$row[ws_path_policy]' target='_blank'>".$row['PactOnline']."</a>";
		}
	}
	$datas[$i]['mo_car']=$row['m_name']."<br>".$row['s_name'];
	$datas[$i]['car_body']=$row['car_body']."<br>".$row['n_motor'];
	if($row['EditCar']=='Y')
	{
		$datas[$i]['car_body'].="<br><font color='red'>".$row['Edit_CarBody']."<br>".$row['Edit_Nmotor']."</font>";
	}
	$datas[$i]['cost']=$row['cost'];
	$datas[$i]['pre']=$row['net'];
	$acc_new="";
	$acc_pre=0;
	$num=0;
	if($row['car_detail']!='ไม่มี' && $row['car_detail']!='')
	{
		$acc_1 = explode("|",$row['car_detail']);
		for($n=0;$n<count($acc_1);$n++)
		{
			$num++;
			$acc_2 = explode(",",$acc_1[$n]);
			$acc_new.=$num.".".$array_acc_new[$acc_2[0]]."<br>";
			//$acc_pre+=str_replace(',','',$array_acc_pre[$acc_2[1]]);
		}
		$acc_pre=$row['add_price'];
	}
	else
	{
		$acc_new='ไม่มี';
		$acc_pre=0;
	}
	$datas[$i]['product']=$acc_new;
	$datas[$i]['CostProduct']=number_format($acc_pre,2,'.',',');
	$acc_new="";
	$acc_pre=0;
	$num=0;
		if($row['EditProduct']=='Y')
	{
	if($row['Product']!='ไม่มี' && $row['Product']!='')
	{
	$acc_1 = explode("|",$row['Product']);
	for($n=0;$n<count($acc_1);$n++)
	{
	$num++;
	$acc_2 = explode(",",$acc_1[$n]);
	$acc_new.=$num.".".$array_acc_new[$acc_2[0]]."<br>";
	//$acc_pre+=str_replace(',','',$array_acc_pre[$acc_2[1]]);
	}
	$acc_pre=$row['CostProduct'];
	}
	else
	{
		$acc_new='ไม่มี';
		$acc_pre=0;
	}
	$datas[$i]['product'].="<br><font color='red'>".$acc_new."</font>";
	$datas[$i]['CostProduct'].="<br><font color='red'>".number_format($acc_pre,2,'.',',')."</font>";
	}
	$i++;
}
	if($i==0)//ถ้า Array เป็น 0 หรือไม่มีข้อมูลการ Query ให้ ขึ้น NoDATA
	{
		$datas[$i]['WSAPIONLINE'] = '<div style="text-align: center">No_Data</div>';
		$datas[$i]['Status_Email']='<div style="text-align: center">No_Data</div>';
		$datas[$i]['print_Insurance']='<div style="text-align: center">No_Data</div>';
		$datas[$i]['id_data_send']='<div style="text-align: center">No_Data</div>';
		$datas[$i]['name']='<div style="text-align: center">No_Data</div>';
		$datas[$i]['send_date']='<div style="text-align: center">No_Data</div>';
		$datas[$i]['start_date']='<div style="text-align: center">No_Data</div>';
		$datas[$i]['print_act']='<div style="text-align: center">No_Data</div>';
		$datas[$i]['mo_car']='<div style="text-align: center">No_Data</div>';
		$datas[$i]['car_body']='<div style="text-align: center">No_Data</div>';
		$datas[$i]['cost']='<div style="text-align: center">No_Data</div>';
		$datas[$i]['pre']='<div style="text-align: center">No_Data</div>';
		$datas[$i]['product']='<div style="text-align: center">No_Data</div>';
		$datas[$i]['CostProduct']='<div style="text-align: center">No_Data</div>';
	}
$data['draw']=$_GET['draw'];
$data['recordsTotal']=$rowfull;
$data['recordsFiltered']=$rowfull;
$data['data']=$datas;
$data['SESSION_CHECK'] = $_SESSION["use_prb"];
// $data['sql'] = $sql;
echo json_encode($data);
?>
