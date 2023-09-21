<?php
// include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
function get_month($id)
{
    switch ($id):
        case '1':
            return 'January';
        case '2':
            return 'February';
        case '3':
            return 'March';
        case '4':
            return 'April';
        case '5':
            return 'May';
        case '6':
            return 'June';
        case '7':
            return 'July';
        case '8':
            return 'August';
        case '9':
            return 'September';
        case '10':
            return 'October';
        case '11':
            return 'November';
        case '12':
            return 'December';
    endswitch;
}
$sql = "";
if ($_POST['id_dealer'] != 'กรุณาเลือก...') {
    $id_dealer = $_POST['id_dealer'];
    $sql .= " AND data.login = $id_dealer  ";
    $sql2 .= " AND data.login = $id_dealer  ";
}

if (!empty($_POST['date_year'])) {
    $date_year = $_POST['date_year'];
    $date_year2 = $_POST['date_year'] - 1;
    $sql .= " AND YEAR(data.send_date) = $date_year ";
    $sql2 .= " AND YEAR(data.send_date) = $date_year2 ";
}

$_context_suzuki = PDO_CONNECTION::fourinsure_mitsu();
$query_count_suzuki = "SELECT MONTH(data.send_date) as month,COUNT(data.id_data) as num 
FROM data
INNER JOIN detail ON (data.id_data = detail.id_data)
INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car) 
INNER JOIN req ON (data.id_data  = req.id_data)
INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car)
where req.EditCancel = '' AND detail.car_id!='' 
AND detail.car_id!='0' AND detail.br_car IN('065','105','132','201','217') $sql
GROUP BY MONTH(data.send_date) ORDER BY MONTH(data.send_date) ASC";

$data_year = $_context_suzuki->query($query_count_suzuki)->fetchAll(PDO::FETCH_ASSOC);

foreach ($data_year as $r) {
    $array_all[$r['month']]['category'] = get_month($r['month']);
    $array_all[$r['month']]['year'] = $r['num'];
}
$query_count_suzuki2 = "SELECT MONTH(data.send_date) as month,COUNT(data.id_data) as num 
FROM data
INNER JOIN detail ON (data.id_data = detail.id_data)
INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car) 
INNER JOIN req ON (data.id_data  = req.id_data)
INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car)
where req.EditCancel = '' AND detail.car_id!='' 
AND detail.car_id!='0' AND detail.br_car IN('065','105','132','201','217') $sql2
GROUP BY MONTH(data.send_date) ORDER BY MONTH(data.send_date) ASC";

$data_lastYear = $_context_suzuki->query($query_count_suzuki2)->fetchAll(PDO::FETCH_ASSOC);
foreach ($data_lastYear as $r) {
    $array_all[$r['month']]['category'] = get_month($r['month']);
    $array_all[$r['month']]['lastYear'] = $r['num'];
}
$length = array();
foreach ($array_all as $y => $r) {
    array_push($length, $y);
}

$array_all['length'] = $length;
echo json_encode($array_all);
