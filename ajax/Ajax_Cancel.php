<?php
// include "../check-ses.php";
include "../inc/connectdbs.pdo.php";
$dbmy4ib_new = PDO_CONNECTION::fourinsure_mitsu();
session_start();
if 
($_POST['order'][0]['column'] != '' && $_POST['order'][0]['column'] > 0 && $_POST['order'][0]['dir'] != '' && $_POST['columns'][$_POST['order'][0]['column']]['name'] != '') 
{
	$order_sql = " ORDER BY " . $_POST['columns'][$_POST['order'][0]['column']]['name'] . " " . $_POST['order'][0]['dir'];
}

if ($_POST['start'] != '' && $_POST['length'] != '') 
{
	$limit_sql = " LIMIT " . $_POST['start'] . "," . $_POST['length'] . " ";
}

if ($_SESSION["strUser"] == 'admin') 
{
	$user = "  ";
} 
else 
{
	$user = " AND data.login = '" . $_SESSION["strUser"] . "' ";
}
$search = $_POST['search']['value'];
$req = " WHERE req.EditCancel != 'Y' ";
$sql_full = "SELECT data.id_data FROM data
    INNER JOIN insuree ON (data.id_data = insuree.id_data)
	INNER JOIN act ON (data.id_data = act.id_data)
	INNER JOIN detail ON (data.id_data = detail.id_data)
	INNER JOIN req ON (data.id_data = req.id_data)

	" . $req . " " . $user . " 
	AND (
			data.id_data LIKE '%" . $search . "%'
			OR insuree.name LIKE '%" . $search . "%'
			OR insuree.last LIKE '%" . $search . "%'
			OR insuree.title LIKE '%" . $search . "%'
			OR detail.car_body LIKE '%" . $search . "%'
			OR detail.n_motor LIKE '%" . $search . "%'
			OR act.p_act LIKE '%" . $search . "%'
			OR req.EditAct_id LIKE '%" . $search . "%'
			OR req.Edit_CarBody LIKE '%" . $search . "%'
			OR req.Edit_Nmotor LIKE '%" . $search . "%'
			OR req.Cus_title LIKE '%" . $search . "%'
			OR req.Cus_name LIKE '%" . $search . "%'
			OR req.Cus_last LIKE '%" . $search . "%'
			)";
$sql_query_full = $dbmy4ib_new->query($sql_full);
$rowfull = $sql_query_full->rowCount();
$sql = "
	SELECT
		data.Status_Email,
		data.id_data,
		data.Advance,
		insuree.title,
		insuree.name,
		insuree.last,
		data.send_date,
		data.start_date,
		data.end_date,
		act.p_act,
		act.tmp_act_id,
		act.ws_path_policy,
		detail.mo_car,
		detail.car_body,
		detail.n_motor,
		detail.br_car,
		detail.mo_sub,
		detail.add_price,
		tb_mo_car.name As m_name,
		tb_mo_car_sub.name As s_name,
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
	left JOIN tb_mo_car_sub ON (detail.mo_sub = tb_mo_car_sub.id)

	
	" . $req . " " . $user . "
	AND (
			data.id_data LIKE '%" . $search . "%'
			OR insuree.name LIKE '%" . $search . "%'
			OR insuree.last LIKE '%" . $search . "%'
			OR insuree.title LIKE '%" . $search . "%'
			OR detail.car_body LIKE '%" . $search . "%'
			OR detail.n_motor LIKE '%" . $search . "%'
			OR act.p_act LIKE '%" . $search . "%'
			OR req.EditAct_id LIKE '%" . $search . "%'
			OR req.Edit_CarBody LIKE '%" . $search . "%'
			OR req.Edit_Nmotor LIKE '%" . $search . "%'
			OR req.Cus_title LIKE '%" . $search . "%'
			OR req.Cus_name LIKE '%" . $search . "%'
			OR req.Cus_last LIKE '%" . $search . "%'
			)
	" . $order_sql . " 
	" . $limit_sql . " ";
$sql_query = $dbmy4ib_new->query($sql);
// echo $sql;exit;
// print_r($sql_query);exit;
$i = 0;
$datas = array();
// print_r($sql_query->fetchAll(2));exit;
foreach ($sql_query->fetchAll(2) as $row) 
{

	if ($row['Status_Email'] == 'T') 
	{
		$datas[$i]['Status_Email'] = "<center><i class='icon-white icon-ok'></i></center>";
	} else 
	{
		$datas[$i]['Status_Email'] = "<center><i class='icon-white icon-remove'></i></center>";
	}

	$approve_sql = "SELECT id,status_approve FROM approve_cancel WHERE id_data = '" . $row['id_data'] . "' ORDER BY date_cancel DESC LIMIT 0,1";
	$approve_query = $dbmy4ib_new->query($approve_sql);
	$approve_array = $approve_query->fetch();
	if (!empty($approve_array) && $approve_array['status_approve'] != 'Y') {
		if ($approve_array['status_approve'] == 'R') {
			$datas[$i]['send_cancel'] = "<a class='btn btn-small btn-warning' type='button' data-toggle='modal' title='รออนุมัติ'  aria-hidden='true' data-target='#modal2'  onclick='js_show_approve(\"" . $approve_array['id'] . "\",\"" . $row['id_data'] . "\")' >รออนุมัติ</a>";
		} else if ($approve_array['status_approve'] == 'N') {
			$datas[$i]['send_cancel'] = "<a class='btn btn-small btn-danger' type='button' data-toggle='modal' title='ไม่อนุมัติ'  aria-hidden='true' data-target='#modal2'  onclick='js_show_approve(\"" . $approve_array['id'] . "\",\"" . $row['id_data'] . "\")' >ไม่อนุมัติ</a>";
		}
	} else {
		$datas[$i]['send_cancel'] = '<a onclick="open_cancel(\'pages/send_Cancel.php?IDDATA=' . $row['id_data'] . '\');" class="btn btn-success btn-small" data-toggle="modal" title="ยกเลิก"  aria-hidden="true" data-target="#modal1"><i class="icon-white icon-trash"></i></a>';
	}
	if($row['Advance'] == 'Y'){

        $datas[$i]['id_data_send'] =  '<a onclick="open_add(\'pages/send_Check.php?IDDATA=' . $row['id_data'] . '\');" class="btn btn-small btn-warning" data-toggle="modal" aria-hidden="true" data-target="#modal">' . $row['id_data'] . '</a>';
    }else{
        $datas[$i]['id_data_send'] =  '<a onclick="open_add(\'pages/send_Check.php?IDDATA=' . $row['id_data'] . '\');" class="btn btn-small btn-info" data-toggle="modal" aria-hidden="true" data-target="#modal">' . $row['id_data'] . '</a>';
    }
	$datas[$i]['name'] = $row['title'] . ' ' . $row['name'] . ' ' . $row['last'];
	$datas[$i]['send_date'] = $row['send_date'];
	$datas[$i]['start_date'] = $row['start_date'];
	$datas[$i]['print_act'] = "<center><a style='padding:0;' class='btn btn-small btn-info' href='print/print_Act.php?IDDATA=" . $row['id_data'] . "' target='_blank'>" . $row['p_act'] . "</a></center>";
	if ($row['EditAct'] == 'Y') 
	{
		$datas[$i]['print_act'] .= "<center><a style='padding:0;color:red !important;' class='btn btn-small btn-info' href='print/print_Act.php?IDDATA=" . $row['id_data'] . "' target='_blank'>" . $row['EditAct_id'] . "</a></center>";
	}
	$datas[$i]['mo_car'] = $row['m_name'] . '/' . $row['s_name'];
	$datas[$i]['car_body'] = $row['car_body'] . "<br>" . $row['n_motor'];
	if ($row['EditCar'] == 'Y') 
	{
		$datas[$i]['car_body'] .= "<br><font color='red'>" . $row['Edit_CarBody'] . "<br>" . $row['Edit_Nmotor'] . "</font>";
	}
	$datas[$i]['cost'] = $row['cost'];
	$datas[$i]['pre'] = $row['net'];
	if ($row['car_detail'] != 'ไม่มี' && $row['car_detail'] != '')
	 {
		$datas[$i]['product'] = 'มี';
	} else {
		$datas[$i]['product'] = 'ไม่มี';
	}


	$datas[$i]['CostProduct'] = $row['add_price'];
	if ($row['EditProduct'] == 'Y')
	 {
		if ($row['Product'] != 'ไม่มี' && $row['Product'] != '') 
		{
			$datas[$i]['product'] .= '<br><font color="red">มี</font>';
		} else 
		{
			$datas[$i]['product'] .= '<br><font color="red">ไม่มี</font>';
		}

		$datas[$i]['CostProduct'] .= '<br><font color="red">' . $row['CostProduct'] . '</font>';
	}
	$i++;
}
$data['draw'] = $_POST['draw'];
$data['recordsTotal'] = $rowfull;
$data['recordsFiltered'] = $rowfull;
$data['data'] = $datas;
echo json_encode($data);