<?php
include "../check-ses.php";
include "../../inc/connectdbs.pdo.php";
function _pdo($sql, $object, $hostname_conn, $database_conn, $username_conn, $password_conn){
	try {
		$options = array(
		    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		); 
		$handler = new PDO('mysql:host='.$hostname_conn.';dbname='.$database_conn,$username_conn,$password_conn,$options);
		$handler->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$query = $handler->query($sql);
		$query->setFetchMode(PDO::FETCH_CLASS, $object);
		return  $query->fetchAll();
	} catch(PDOException $e) {
		echo $e->getMessage();
		die();
	}
}
class ACTCh {
	public
		$ACT,
		$send_Attached,
		$id_data,
		$name,
		$send_date,
		$start_date,
		$print_act,
		$mo_car,
		$car_body,
		$cost,
		$pre,
		$product,
		$CostProduct;
}
class ACTChCount {
	public $total;
}
$year_end = date('Y');
$year_start = $year_end-2;
$user = '';
//
$temp_user[0] = substr($_SESSION["strUser"],0,1);
$temp_user[1] = substr($_SESSION["strUser"],4,3);
//
if($_SESSION["strUser"]=='admin'){
	$user = "__admin = '".$_SESSION["strUser"]."' AND ";
} else {
	$user = "__user = '".'Z'.$temp_user[0].$temp_user[1]."' AND ";
}
$search = $_POST['search']['value'];
$search = str_replace(' ', '%', $search);
$order_by = '';
if(isset($_POST['order'])) {
	switch($_POST['columns'][$_POST['order'][0]['column']]['data']) {
		case 'send_date':
			$order_by = ' ORDER BY STR_TO_DATE(send_date,\'%d/%m/%Y %T\') '.$_POST['order'][0]['dir'];
			break;
		case 'start_date':
			$order_by = ' ORDER BY STR_TO_DATE(start_date,\'%d/%m/%Y\') '.$_POST['order'][0]['dir'];
			break;
		default:
			$order_by = ' ORDER BY '.$_POST['columns'][$_POST['order'][0]['column']]['data'].' '.$_POST['order'][0]['dir'];
			break;
	}
	
} else {
	$order_by = ' ORDER BY STR_TO_DATE(send_date,%d/%m/%Y %T) desc';
}
$limit_start = $_POST['start'];
$limit_end = $_POST['length'];
$sql = "
	SELECT
		ACT,
		send_Attached,
		id_data,
		name,
		send_date,
		start_date,
		print_act,
		mo_car,
		car_body,
		cost,
		pre,
		product,
		CostProduct
	FROM __report_act
	WHERE
		$user
		(__year >= $year_start AND __year <= $year_end)
		AND (
			ACT LIKE '%$search%'
			OR id_data LIKE '%$search%'
			OR name LIKE '%$search%'
			OR send_date LIKE '%$search%'
			OR start_date LIKE '%$search%'
			OR print_act LIKE '%$search%'
			OR mo_car LIKE '%$search%'
			OR car_body LIKE '%$search%'
			OR cost LIKE '%$search%'
			OR pre LIKE '%$search%'
			OR product LIKE '%$search%'
			OR CostProduct LIKE '%$search%'
		)
	$order_by
	LIMIT $limit_start,$limit_end;
";
$recordsTotal = _pdo("
	SELECT COUNT(*) as total FROM __report_act
	WHERE $user (__year >= $year_start AND __year <= $year_end)
	", "ACTChCount", $hostname_conn, $database_conn, $username_conn, $password_conn);
$data = _pdo($sql, "ACTCh", $hostname_conn, $database_conn, $username_conn, $password_conn);
$recordsFiltered = 0;
if($search == ''){
	$recordsFiltered = $recordsTotal[0]->total;
} else {
	$recordsFiltered = count($data);
}
$response = array(
	'recordsTotal'=>$recordsTotal[0]->total,
	'recordsFiltered'=>$recordsFiltered,
	'data'=>$data,
);
echo json_encode($response);