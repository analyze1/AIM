<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";

function calculateCostYearByNing($price){    
    $x = (intval($price) * 80)/100;
    $fund = roundNing(($x), -4);
    return $fund;
}
function roundNing($cost,$index=1){
    $newstring = substr($cost, $index);
    if(intval($newstring)!=0){								
        $newstring = intval($cost)+(10000-$newstring);
    }else{
        $newstring = $cost;
    }
    return $newstring;
}
function genInsuranceCapital($price){
    $x = (intval($price) * 80)/100;
    return $x;
}

$start_date = date("Y-m-d");
$mo_id = $_POST['mo_sub'];
$USER = $_SESSION["strUser"];

if ($USER == "admin") {
    $type_vib = "WHERE sort IN ('VIB_S','VIB_F','VIB_C')";
    $type_sort = " AND comp = '$_POST[com_data]'";
} else {
    $type_vib = "WHERE sort = 'VIB_S'";
    $type_sort = " AND comp = 'VIB_S'";
}

$comp_sql = "SELECT name, sort FROM tb_comp $type_vib";
$comp_num = PDO_CONNECTION::fourinsure_mitsu()->query($comp_sql);
$_count = $comp_num->rowCount();
if ($_count == 1) {
    $comp_array = $comp_num->fetch(2);
    $comp_select = "<option value='$comp_array[sort]'>$comp_array[name]</option>";
} else {
    $comp_select = "<option value='0'>--กรุณาเลือกบริษัท--</option>";
    foreach ($comp_num->fetchAll(2) as $comp_array) {
        if ($comp_array['sort'] == 'VIB_S') {
            $select_comp_data = 'selected';
            $type_sort = " AND comp = 'VIB_S'";
        } else {
            $select_comp_data = '';
        }
        $comp_select.= "<option value='$comp_array[sort]' $select_comp_data>$comp_array[name]</option>";
    }
}


$mo_sub_sql = "SELECT gear, id_mo_car,name,price_car FROM tb_car_model_sub WHERE  id = '$mo_id'";
$mo_sub_array = PDO_CONNECTION::fourinsure_insured()->query($mo_sub_sql)->fetch(2);
$mo_mini = explode(" ", $mo_sub_array['name']);
$insurance_capital = calculateCostYearByNing($mo_sub_array['price_car']);
$insurance_capital_format = number_format($insurance_capital);

if ($mo_id > 0) {
    $tb_sub_sql = "SELECT id FROM tb_cost WHERE mo_sub = '$mo_id'";
    $tb_sub_array = PDO_CONNECTION::fourinsure_mitsu()->query($tb_sub_sql)->fetch(2);
    if (!empty($tb_sub_array)) {
        // cost like '%$mo_mini[1]%' AND ยังไม่มี
        $tb_cost_sql = "SELECT cost_gear,cost,pre,stamp,tax,net,id FROM tb_cost WHERE cost = '$insurance_capital_format' AND mo = '$mo_sub_array[id_mo_car]' $type_sort AND cost_gear = '$mo_sub_array[gear]' AND cost_end_date >= '$start_date' AND mo_sub = '$mo_id' ORDER BY cost ASC";
        $tb_cost_query = PDO_CONNECTION::fourinsure_mitsu()->query($tb_cost_sql);
    } else {
        $tb_cost_sql = "SELECT cost_gear,cost,pre,stamp,tax,net,id FROM tb_cost WHERE cost = '$insurance_capital_format' AND mo = '$mo_sub_array[id_mo_car]' $type_sort AND cost_gear = '$mo_sub_array[gear]' AND cost_end_date >= '$start_date' ORDER BY cost ASC";
        $tb_cost_query = PDO_CONNECTION::fourinsure_mitsu()->query($tb_cost_sql);
    }
    $mo_cost_array = $tb_cost_query->fetch(2);
}

if (!empty($mo_cost_array)) {
    $cost_show['cost_array'] = "<option value='$mo_cost_array[id]'>$mo_cost_array[cost]</option>";
    $mo_array = $mo_cost_array['cost'];
    $cost_show['cost_first_id']= $mo_cost_array['id'];

    foreach ($tb_cost_query->fetchAll(2) as $arr) {
        $cost_show['cost_array'].= "<option value='$arr[id]'>$arr[cost]</option>";
    }
} else {
    $cost_show['cost_array'] = '<option value="0">--------------</option>';
    $mo_array = "กรุณาเลือกรุ่นย่อย";
}

if (!empty($mo_sub_array)) {
    if ($mo_sub_array['gear'] == 'A') {
        $cost_show['cost_gear'] = '<option value="A">อัตโนมัติ</option>';
    } else {
        $cost_show['cost_gear'] = '<option value="M">ธรรมดา</option>';
    }
} else {
    $cost_show['cost_gear'] = '<option value="0">--กรุณาเลือก--</option>';
}

$cost_show['cost_text'] = $mo_array;
$cost_show['com_data'] = $comp_select;
$cost_show['costpre'] = number_format($mo_cost_array['pre'], 2, '.', ',');
$cost_show['coststamp'] = number_format($mo_cost_array['stamp'], 2, '.', ',');
$cost_show['costtax'] = number_format($mo_cost_array['tax'], 2, '.', ',');
$cost_show['costnet'] = number_format($mo_cost_array['net'], 2, '.', ',');
$cost_show['insurance_capital'] = number_format($insurance_capital, 2, '.', ',');
echo json_encode($cost_show);
?>