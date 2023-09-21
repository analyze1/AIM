<?php
//header('Content-Type: text/html; charset=UTF-8');
//header('Content-Type: text/html; charset=TIS-620');
include "../check-ses.php";
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
if($_GET['order'][0]['column']!='' && $_GET['order'][0]['column'] > 0 && $_GET['order'][0]['dir']!='' && $_GET['columns'][$_GET['order'][0]['column']]['name']!='')
{
	$order_sql=" ORDER BY ".$_GET['columns'][$_GET['order'][0]['column']]['name']." ".$_GET['order'][0]['dir'];
}
if($_GET['start']!='' && $_GET['length']!='')
{
	$limit_sql=" LIMIT ".$_GET['start'].",".$_GET['length']." ";
}
$search = $_GET['search']['value'];

$tb_acc_new_sql="SELECT id,name FROM tb_acc_new";
$tb_acc_new_query=mysql_query($tb_acc_new_sql,$cndb1);
$array_acc_new = array();
while($tb_acc_new_array = mysql_fetch_array($tb_acc_new_query))
{
	$array_acc_new[$tb_acc_new_array['id']] = $tb_acc_new_array['name'];
}
$tb_acc_sql="SELECT id,name,price FROM tb_acc";
$tb_acc_query=mysql_query($tb_acc_sql,$cndb1);
$array_acc_tung = array();
$array_acc_pre = array();
while($tb_acc_array = mysql_fetch_array($tb_acc_query))
{

	$array_acc_tung[$tb_acc_array['id']] = $tb_acc_array['name'];
	$array_acc_pre[$tb_acc_array['id']] = $tb_acc_array['price'];
}
if($_GET['req']==1){
	$req = "WHERE req.Req_Status = 'Y' ";
} else {
	$req=" WHERE req.Req_Status IN('Y','','N') " ;
}
if($_SESSION["strUser"]=='admin'){
	$user = '';
} else {
	$user = " AND data.login = '".$_SESSION["strUser"]."' ";
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
			) ";
			//echo $sql_full;
$sql_query_full = mysql_query($sql_full,$cndb1);
$rowfull = mysql_num_rows($sql_query_full);
$sql = "
	SELECT
		data.Status_Email,
		data.id_data,
		insuree.title,
		insuree.name,
		insuree.last,
		data.send_date,
		data.start_date,
		data.end_date,
		act.p_act,
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
		req.Product

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
	//echo $sql;
$sql_query = mysql_query($sql,$cndb1);

$i=0;

while($row=mysql_fetch_array($sql_query))
{
	if($row['Status_Email']=='T')
	{
		$status_Email = "<center><i class='icon-white icon-ok'></i></center>";
	}
	else
	{
		$status_Email ="<center><i class='icon-white icon-remove'></i></center>";
	}
	$datas[$i]['Status_Email']=$status_Email;
	$datas[$i]['send_Attached']="<a type='button' class='btn btn-success btn-small' data-toggle='modal' title='สลักหลัง'  aria-hidden='true' data-target='#modal1' onclick='modal_show(\"#modal1\",\"pages/send_Attached.php?IDDATA=".$row['id_data']."\");'><i class='icon-white icon-pencil'></i></a>";
	$datas[$i]['id_data_send']="<a type='button' data-toggle='modal' aria-hidden='true' data-target='#modal' onclick='modal_show(\"#modal\",\"pages/send_Check.php?IDDATA=".$row['id_data']."\");'>".$row['id_data']."</a>";
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
	$datas[$i]['print_act']="<center><a href='print/print_Act.php?IDDATA=".$row['id_data']."' target='_blank'>".$row['p_act']."</a></center>";
	if($row['EditAct']=='Y')
	{
	$datas[$i]['print_act'].="<center><a href='print/print_Act.php?IDDATA=".$row['id_data']."' target='_blank' style='color:red !important;'>".$row['EditAct_id']."</a></center>";
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
	if($i==0)
	{
	$datas[$i]['Status_Email']="No_Data";
	$datas[$i]['send_Attached']="No_Data";
	$datas[$i]['id_data_send']="No_Data";
	$datas[$i]['name']="No_Data";
	$datas[$i]['send_date']="No_Data";
	$datas[$i]['start_date']="No_Data";
	$datas[$i]['print_act']="No_Data";
	$datas[$i]['mo_car']="No_Data";
	$datas[$i]['car_body']="No_Data";
	$datas[$i]['cost']="No_Data";
	$datas[$i]['pre']="No_Data";
	$datas[$i]['product']="No_Data";
	$datas[$i]['CostProduct']="No_Data";
	}
	
$data['draw']=$_GET['draw'];
$data['recordsTotal']=$rowfull;
$data['recordsFiltered']=$rowfull;
$data['data']=$datas;
echo json_encode($data);