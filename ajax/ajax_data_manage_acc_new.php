<?php
include "../check-ses.php";
include "../inc/connectdbs.pdo.php";

// mysql_select_db($db1,$cndb1);
if($_GET['order'][0]['column']!='' && $_GET['order'][0]['column'] >= 0 && $_GET['order'][0]['dir']!='' && $_GET['columns'][$_GET['order'][0]['column']]['name']!='')
{
	$order_sql=" ORDER BY ".$_GET['columns'][$_GET['order'][0]['column']]['name']." ".$_GET['order'][0]['dir'];
}
if($_GET['start']!='' && $_GET['length']!='')
{
	$limit_sql=" LIMIT ".$_GET['start'].",".$_GET['length']." ";
}
$search = $_GET['search']['value'];
$sql_full="SELECT * FROM tb_acc_new WHERE
(
			id LIKE '%".$search."%'
			OR name LIKE '%".$search."%'
			OR idcar LIKE '%".$search."%'
			OR status_free LIKE '%".$search."%'
			OR start_cost LIKE '%".$search."%'
			OR status_use LIKE '%".$search."%'
			) 
";
//echo $sql_full;
$query_full=  PDO_CONNECTION::fourinsure_mitsu()->query($sql_full);
$rowfull= $query_full->rowCount();
$sql_tbacc_sql="SELECT * FROM tb_acc_new WHERE
 (
			id LIKE '%".$search."%'
			OR name LIKE '%".$search."%'
			OR idcar LIKE '%".$search."%'
			OR status_free LIKE '%".$search."%'
			OR start_cost LIKE '%".$search."%'
			OR status_use LIKE '%".$search."%'
			) 
".$order_sql." ".$limit_sql." ";
$sql_tbacc_query=  PDO_CONNECTION::fourinsure_mitsu()->query($sql_tbacc_sql);

$i=0;
$data = array();
foreach($sql_tbacc_query->fetchAll(2)  as $sql_tbacc_array)
{
	$data[$i]['id']="<button class='btn btn-small btn-warning' onclick='edit_data(\"".$sql_tbacc_array['id']."\",\"".$sql_tbacc_array['name']."\",\"".$sql_tbacc_array['idcar']."\",\"".$sql_tbacc_array['start_cost']."\",\"".$sql_tbacc_array['status_free']."\",\"".$sql_tbacc_array['status_use']."\");' data-toggle='modal' data-target='#modal_edit_acc'>แก้ไข</button>";
	if($sql_tbacc_array['status_free']=='Y')
	{
		$e_ass='@ ';
	}
	else
	{
		$e_ass='';
	}
	$data[$i]['name']=$e_ass.$sql_tbacc_array['name'];
	$data[$i]['idcar']=$sql_tbacc_array['idcar'];
	$data[$i]['start_cost']=$sql_tbacc_array['start_cost'];
	$data[$i]['status_free']=$sql_tbacc_array['status_free'];
	$data[$i]['status_use']=$sql_tbacc_array['status_use'];
$i++;
}


$datas['draw']=$_GET['draw'];
$datas['recordsTotal']=$rowfull;
$datas['recordsFiltered']=$rowfull;
$datas['data']=$data;
echo json_encode($datas);
?>