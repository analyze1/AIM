<?php
// include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
$sql = "";
if ($_POST['id_dealer'] != 'กรุณาเลือก...') {
    $id_dealer = $_POST['id_dealer'];
    $sql .= " AND data.login = $id_dealer  ";
}

if (!empty($_POST['date_year'])) {
    $date_year = $_POST['date_year'];
    $sql .= " AND YEAR(data.send_date) = $date_year ";
}

$_context_suzuki = PDO_CONNECTION::fourinsure_mitsu();
$data_chart = array();
$query_count_suzuki = "SELECT data.name_gain,COUNT(data.id_data) as num 
FROM data
INNER JOIN detail ON (data.id_data = detail.id_data)
INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car) 
INNER JOIN req ON (data.id_data  = req.id_data)
where req.EditCancel = '' AND detail.car_id!='' 
AND detail.car_id!='0' AND detail.br_car IN('065','105','132','201','217') $sql
GROUP BY data.name_gain ORDER BY num DESC";

$data_sales = $_context_suzuki->query($query_count_suzuki)->fetchAll(PDO::FETCH_ASSOC);

foreach ($data_sales as $r) {
    array_push($data_chart, array('name' => $r['name_gain'], 'count' => $r['num']));
}

echo json_encode($data_chart);
