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
}

if (!empty($_POST['date_year'])) {
    $date_year = $_POST['date_year'];
    $sql .= " AND YEAR(data.send_date) = $date_year ";
}

$_context_suzuki = PDO_CONNECTION::fourinsure_mitsu();
$data_chart = array();
$query_count_suzuki = "SELECT MONTH(data.send_date) as month,tb_mo_car.name,COUNT(data.id_data) as num 
FROM data
INNER JOIN detail ON (data.id_data = detail.id_data)
INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car) 
INNER JOIN req ON (data.id_data  = req.id_data)
INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car)
where req.EditCancel = '' AND detail.car_id!='' 
AND detail.car_id!='0' AND detail.br_car IN('065','105','132','201','217') $sql
GROUP BY tb_mo_car.id,MONTH(data.send_date) ORDER BY tb_mo_car.name,MONTH(data.send_date) ASC ";

$data_sales = $_context_suzuki->query($query_count_suzuki)->fetchAll(PDO::FETCH_ASSOC);
$x = '';
$array_str = '';
$length = array();
foreach ($data_sales as $r) {
    $array_all[$r['month']]['year'] = get_month($r['month']);
    $array_all[$r['month']][strtolower($r['name'])] = (int) $r['num'];
    $x .= strtolower($r['name']) . '|';
    //$array_str .= '{}';
}
foreach ($array_all as $y => $r) {
    array_push($length, $y);
}
$array_all['length'] = $length;
$array_all['allRegion'] = $x;


echo json_encode($array_all);
