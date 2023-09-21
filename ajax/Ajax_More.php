<?php
include "../inc/connectdbs.pdo.php";

$_contextMitSu = PDO_CONNECTION::fourinsure_mitsu();
$_contextFour = PDO_CONNECTION::fourinsure_insured();

$call = $_POST['callajax'];
$cartype = $_POST['cartype'];
$typeID = $_POST['typeID'];
$mo_car = $_POST['mo_car'];
$ids = $_POST['ids'];

//รหัส 220 ให้เรียกอุปกรณ์ของ 320

$Fi_mo_car = $_POST['Fi_mo_car'];
$Fi_car_type = $_POST['Fi_car_type'];
$Fi_add_tun = $_POST['Fi_add_tun'];
$new_moretun = $_POST['new_moretun'];

if ($cartype == 2) 
{
    $cartype = 3;
}

if ($call == "COSTPRICE") {
    $sql = "SELECT * FROM tb_acc WHERE id = $ids AND cartype = $cartype AND price != '0.00' AND `status` = 'Y' ORDER BY price ASC";
    $result = $_contextMitSu->query($sql);
    $fetcharr = $result->fetch(2);
    $i = 0;
    if ($typeID == 14) {
        $returnedArray['price'] = $fetcharr['price2'];
    } else {
        $returnedArray['price'] = $fetcharr['price'];
    }
    echo json_encode($returnedArray);
}

if ($call == "TOTAL") {
    $check_mocarsub_sql = "SELECT * FROM tb_acc WHERE cartype='$cartype' AND mo_car = '$mo_car' AND `status` = 'Y' AND mo_car_sub = '$_POST[mo_car_sub]' ORDER BY price ASC";
    $check_mocarsub_query = $_contextMitSu->query($check_mocarsub_sql);
    $check_mocarsub_array = $check_mocarsub_query->fetch(2);
    if (!empty($check_mocarsub_array)) {
        $sql = "SELECT * FROM tb_acc WHERE cartype = '$cartype' AND mo_car = '$mo_car' AND `status` = 'Y' AND mo_car_sub = '$_POST[mo_car_sub]' ORDER BY price ASC";
    } else {
        $sql = "SELECT * FROM tb_acc WHERE cartype = '$cartype' AND mo_car = '$mo_car' AND `status` = 'Y' AND mo_car_sub = '' ORDER BY price ASC";
    }
    $result = $_contextMitSu->query($sql)->fetchAll(2);
    foreach ($result as $fetcharr) {
        $returnedArray[$fetcharr['id']]['name'] = $fetcharr['name'];
        $returnedArray[$fetcharr['id']]['price'] = $fetcharr['price'];
        $returnedArray[$fetcharr['id']]['price2'] = $fetcharr['price2'];
    }
    echo json_encode($returnedArray);
}

if ($call == "TotalWhere") {
    $sql = "SELECT price FROM tb_acc WHERE `name` = '$_POST[add_tun].00' LIMIT 1";
    $query = $_contextMitSu->query($sql )->fetch(2);

    echo json_encode($query);
}

if ($call == "MORE") {
    $sql = "SELECT * FROM tb_acc_new WHERE status_use != 'N' AND  idcar=$cartype AND id != '31' AND id != '32'  ORDER BY CHAR_LENGTH(name) ASC";
    $result = $_contextMitSu->query($sql);
    $i = 0;
    foreach ($result->fetchAll(2) as $fetcharr) {
        $returnedArray[$i]['id'] = $fetcharr['id'];
        $returnedArray[$i]['name'] = $fetcharr['name'];
        $i++;
    };
    echo json_encode($returnedArray);
}

if ($call == 'BodyModel') {
    $sql = "SELECT * FROM ModelCarMitsubishi WHERE carType = '$_POST[carCode]' AND idCarModelSub = '$_POST[carSub]'";
    $query = $_contextFour->query($sql)->fetch(2);

    echo json_encode($query);
}

if ($call == "MORE_NEW") {
    $sql_chacc = "SELECT * FROM tb_acc_new WHERE  idcar=$cartype AND id != '31' AND id != '32' AND id !='182' AND id_type = '$tb_acc_type_array[id_type]' AND status_use !='N' AND mo_sub = '$_POST[mo_car_sub]'";
    $query_chacc = $_contextMitSu->query($sql_chacc);
    $array_chacc = $query_chacc->rowCount();
    if ($array_chacc > 0) {
        $sql_mo = " AND mo_sub = '$_POST[mo_car_sub]' ";
    } else {
        $sql_mo = "";
    }
    $array_id_user = array();
    if ($_SESSION['strUser'] != 'admin') {
        $tb_acc_dealer_s = "SELECT * FROM tb_acc_dealer WHERE user_dealer = '$_SESSION[strUser]' ";
        $tb_acc_dealer_q = $_contextMitSu->query($tb_acc_dealer_s);
        $tb_acc_dealer_a = $tb_acc_dealer_q->fetch(2);
        $exp_acc = explode('|', $tb_acc_dealer_a['id_acc']);
        for ($n = 0;$n < count($exp_acc);$n++) {
            $array_id_user[$exp_acc[$n]] = 'Y';
        }
    }
    $html_acc = '<option value="0" selected="selected">--กรุณาเลือกอุปกรณ์--</option>';
    $tb_acc_type_sql = "SELECT * FROM tb_acc_type";
    $tb_acc_type_query = $_contextMitSu->query($tb_acc_type_sql);
    foreach ($tb_acc_type_query->fetchAll(2) as $tb_acc_type_array) {
        $n = 1;
        $html_acc.= "<optgroup label='" . $tb_acc_type_array['name'] . "'>";

        $sql = "SELECT * FROM tb_acc_new WHERE  idcar = $cartype AND id != '31' AND id != '32' AND id !='182' AND id_type = '$tb_acc_type_array[id_type]' AND status_use !='N' $sql_m  ORDER BY CHAR_LENGTH(name) ASC";
        
        $result = $_contextMitSu->query($sql);
        foreach ($result->fetchAll(2) as $fetcharr) {
            if ($fetcharr['status_use'] == 'Y' || $fetcharr['status_use'] == '' || $_SESSION['strUser'] == 'admin' || $array_id_user[$fetcharr['id']] == 'Y') {
                if ($fetcharr['status_free'] == 'Y') {
                    $style_color = '';
                    $text_free = '@ ';
                } else {
                    $style_color = '';
                    $text_free = '';
                }
                $html_acc.= "<option value='$fetcharr[id]' style='$style_color'>$n. $text_free $fetcharr[name]</option>";
                $n++;
            }
        }
        $html_acc.= "</optgroup>";
    }
    $returnedArray['html_acc'] = $html_acc;
    echo json_encode($returnedArray);
}

if ($call == "MORE_NEW_LOGIN") {
    $html_acc = '<option value="0" selected="selected">--กรุณาเลือกอุปกรณ์--</option>';
    $tb_acc_type_sql = "SELECT * FROM tb_acc_type";
    $tb_acc_type_query = $_contextMitSu->query($tb_acc_type_sql);
    foreach ($tb_acc_type_query->fetchAll(2) as $tb_acc_type_array) {
        $n = 1;
        $html_acc.= "<optgroup label='" . $tb_acc_type_array['name'] . "'>";
        $sql = "SELECT * FROM tb_acc_new WHERE status_use != 'N' AND  idcar=$cartype AND id != '31' AND id != '32' AND id !='182' AND id_type = '" . $tb_acc_type_array['id_type'] . "' " . $sql_mo . " ORDER BY CHAR_LENGTH(name) ASC";
        $result = $_contextMitSu->query($sql);
        foreach ($result->fetchAll(2) as $fetcharr) {
            if ($fetcharr['status_free'] == 'Y') {
                $style_color = '';
                $text_free = '@ ';
            } else {
                $style_color = '';
                $text_free = '';
            }
            $html_acc.= "<option value='" . $fetcharr['id'] . "' style='" . $style_color . "'>      " . $n . '. ' . $text_free . $fetcharr['name'] . "</option>";
            $n++;
        }
        $html_acc.= "</optgroup>";
    }
    $returnedArray['html_acc'] = $html_acc;
    // print_r($returnedArray) ;
    // exit();
    echo json_encode($returnedArray);
}
if ($call == "MOREMORE") {
    $sql = "SELECT * FROM tb_acc_new WHERE status_use != 'N' AND  idcar=$cartype AND id != '31' AND id != '32'  ORDER BY CHAR_LENGTH(name) ASC";
    //echo $sql;
    $result = $_contextMitSu->query($sql);
    $i = 0;
    foreach ($result->fetchAll(2) as $fetcharr) {
        if ($fetcharr['status_free'] == 'Y') {
            $status_free_text = '@ ';
        } else {
            $status_free_text = '';
        }
        $returnedArray[$i]['id'] = $fetcharr['id'];
        $returnedArray[$i]['name'] = $status_free_text . $fetcharr['name'];
        $i++;
    };
    $check_mocarsub_sql = "SELECT id FROM tb_acc WHERE cartype=$cartype AND mo_car='$mo_car' AND mo_car_sub = '" . $_POST['mo_car_sub'] . "' AND DATEDIFF(`dateexp`,NOW())>=0 AND status = 'Y' ORDER BY price ASC";
    $check_mocarsub_query = $_contextMitSu->query($check_mocarsub_sql);
    $check_mocarsub_array = $check_mocarsub_query->fetch(2);
    if (!empty($check_mocarsub_array)) {
        $sql = "SELECT * FROM tb_acc WHERE cartype=$cartype AND mo_car='$mo_car' AND mo_car_sub = '" . $_POST['mo_car_sub'] . "' AND DATEDIFF(`dateexp`,NOW())>=0 AND status = 'Y' ORDER BY price ASC";
    } else {
        $sql = "SELECT * FROM tb_acc WHERE cartype=$cartype AND mo_car='$mo_car' AND mo_car_sub = '' AND DATEDIFF(`dateexp`,NOW())>=0 AND status = 'Y' ORDER BY price ASC";
    }
    $result = $_contextMitSu->query($sql);
    $i = 0;
    foreach ($result->fetchAll(2) as $fetcharr) {
        if ($fetcharr['name'] == '0.00') {
            $returnedArray[$i]['idcost'] = $fetcharr['id'];
            $returnedArray[$i]['namecost'] = 'ต่ำกว่า 10,000';
        } else if ($fetcharr['name'] != '0.00') {
            $returnedArray[$i]['idcost'] = $fetcharr['id'];
            $returnedArray[$i]['namecost'] = number_format($fetcharr['name'], 0);
        }
        $i++;
    };
    echo json_encode($returnedArray);
}
if ($call == "COST") {
    $check_mocarsub_sql = "SELECT id FROM tb_acc WHERE cartype='$cartype' AND mo_car='$mo_car' AND mo_car_sub = '" . $_POST['mo_car_sub'] . "' AND DATEDIFF(`dateexp`,NOW())>=0  AND status = 'Y' ORDER BY price ASC";
    $check_mocarsub_query = $_contextMitSu->query($check_mocarsub_sql);
    $check_mocarsub_array = $check_mocarsub_query->fetch(2);
    if (!empty($check_mocarsub_array)) {
        $sql = "SELECT * FROM tb_acc WHERE cartype='$cartype' AND mo_car='$mo_car' AND mo_car_sub = '" . $_POST['mo_car_sub'] . "' AND DATEDIFF(`dateexp`,NOW())>=0  AND status = 'Y'  ORDER BY price ASC";
    } else {
        $sql = "SELECT * FROM tb_acc WHERE cartype='$cartype' AND mo_car='$mo_car' AND DATEDIFF(`dateexp`,NOW())>=0  AND status = 'Y' AND mo_car_sub = ''  ORDER BY price ASC";
    }
    $result = $_contextMitSu->query($sql);
    $i = 0;
    foreach ($result->fetchAll(2) as $fetcharr) {
        if ($fetcharr['name'] == '0.00') {
            $returnedArray[$i]['id'] = $fetcharr['id'];
            $returnedArray[$i]['name'] = 'ต่ำกว่า 10,000';
        } else if ($fetcharr['name'] != '0.00') {
            $returnedArray[$i]['id'] = $fetcharr['id'];
            $returnedArray[$i]['name'] = number_format($fetcharr['name'], 0);
        }
        $i++;
    };
    echo json_encode($returnedArray);
}

if ($call == "COST_NEW") {
    $tb_acc_new_sql = "SELECT status_free,start_cost FROM tb_acc_new WHERE id = '$_POST[id_acc]'";
    $tb_acc_new_query = $_contextMitSu->query($tb_acc_new_sql);
    $tb_acc_new_array = $tb_acc_new_query->fetch(2);
    if ($tb_acc_new_array['status_free'] == 'Y') {
        $check_mocarsub_sql = "SELECT id FROM tb_acc WHERE cartype='$cartype' AND mo_car='$mo_car' AND mo_car_sub = '$_POST[mo_car_sub]' AND DATEDIFF(`dateexp`,NOW())>=0  AND status = 'Y' ORDER BY price ASC";

        $check_mocarsub_query = $_contextMitSu->query($check_mocarsub_sql);
        $check_mocarsub_array = $check_mocarsub_query->fetch(2);
		
        if (!empty($check_mocarsub_array)) {
            $sql = "SELECT * FROM tb_acc WHERE name = '0.00' AND cartype='$cartype' AND mo_car='$mo_car' AND mo_car_sub = '$_POST[mo_car_sub]' AND DATEDIFF(`dateexp`,NOW())>=0  AND status = 'Y'  ORDER BY price ASC";
        } else {
            $sql = "SELECT * FROM tb_acc WHERE name = '0.00' AND  cartype='$cartype' AND mo_car='$mo_car' AND DATEDIFF(`dateexp`,NOW())>=0  AND status = 'Y' AND mo_car_sub = ''  ORDER BY price ASC";
        }
        $result = $_contextMitSu->query($sql);
        $i = 0;
        $fetcharr = $result->fetch(2);
        $returnedArray[$i]['id'] = $fetcharr['id'];
        $returnedArray[$i]['name'] = 'ฟรี(วงเงินไม่เกิน 20,000)';
        $returnedArray[$i]['price'] = empty($fetcharr['price']) ? '0' : $fetcharr['price'];
        $i++;
        $status_free = 'Y';
    } else {
        $check_mocarsub_sql = "SELECT id FROM tb_acc WHERE cartype='$cartype' AND mo_car='$mo_car' AND mo_car_sub = '$_POST[mo_car_sub]' AND DATEDIFF(`dateexp`,NOW())>=0  AND status = 'Y' ORDER BY price ASC";
        $check_mocarsub_query = $_contextMitSu->query($check_mocarsub_sql);
        $check_mocarsub_array = $check_mocarsub_query->fetch(2);
        if (!empty($check_mocarsub_array)) {
            $sql = "SELECT * FROM tb_acc WHERE name != '0.00' AND name <='$tb_acc_new_array[start_cost]' AND cartype='$cartype' AND mo_car='$mo_car' AND mo_car_sub = '$_POST[mo_car_sub]' AND DATEDIFF(`dateexp`,NOW())>=0  AND status = 'Y'  ORDER BY price ASC";
        } else {
            $sql = "SELECT * FROM tb_acc WHERE name != '0.00' AND name <='$tb_acc_new_array[start_cost]' AND cartype='$cartype' AND mo_car='$mo_car' AND DATEDIFF(`dateexp`,NOW())>=0  AND status = 'Y' AND mo_car_sub = ''  ORDER BY price ASC";
        }
        $result = $_contextMitSu->query($sql);
        $i = 0;
        foreach ($result->fetchAll(2) as $fetcharr) {
            if ($fetcharr['name'] == '0.00') {
                $returnedArray[$i]['id'] = $fetcharr['id'];
                $returnedArray[$i]['name'] = 'ต่ำกว่า 10,000';
                $returnedArray[$i]['price'] = $fetcharr['price'];
            } else if ($fetcharr['name'] != '0.00') {
                $returnedArray[$i]['id'] = $fetcharr['id'];
                $returnedArray[$i]['name'] = number_format($fetcharr['name'], 0);
                $returnedArray[$i]['price'] = $fetcharr['price'];
            }
            $i++;
        }
        $status_free = '';
    }
    $returnedArray[0]['status_free'] = $status_free;
    echo json_encode($returnedArray);
}

if ($call == "FI_MORE") {
    $check_mocarsub_sql = "SELECT * FROM tb_acc WHERE name='$Fi_add_tun' AND cartype='$Fi_car_type' AND mo_car='$Fi_mo_car'  AND status = 'Y' AND mo_car_sub = '" . $_POST['mo_car_sub'] . "' ";
    $check_mocarsub_array = $_contextMitSu->query($check_mocarsub_sql)->fetch(2);
    if (!empty($check_mocarsub_array)) {
        $sql = "SELECT * FROM tb_acc WHERE name='$Fi_add_tun' AND cartype='$Fi_car_type' AND mo_car='$Fi_mo_car'  AND status = 'Y' AND mo_car_sub = '" . $_POST['mo_car_sub'] . "' ";
    } else {
        $sql = "SELECT * FROM tb_acc WHERE name='$Fi_add_tun' AND cartype='$Fi_car_type' AND mo_car='$Fi_mo_car'  AND status = 'Y' AND mo_car_sub = '' ";
    }
    $result = $_contextMitSu->query($sql);
    foreach ($result->fetchAll(2) as $fetcharr) {
        $returnedArray['Fi_price'] = $fetcharr['price'];
    };
    echo json_encode($returnedArray);
}
if ($call == "MORE_TUN") {
    $check_mocarsub_sql = "SELECT * FROM tb_acc WHERE id ='$new_moretun' AND status = 'Y'  AND mo_car_sub = '" . $_POST['mo_car_sub'] . "' ";
    $check_mocarsub_query = $_contextMitSu->query($check_mocarsub_sql);
    $check_mocarsub_array = $check_mocarsub_query->fetch(2);
    if (!empty($check_mocarsub_array)) {
        $sql = "SELECT * FROM tb_acc WHERE id ='$new_moretun' AND status = 'Y'  AND mo_car_sub = '" . $_POST['mo_car_sub'] . "' ";
    } else {
        $sql = "SELECT * FROM tb_acc WHERE id ='$new_moretun' AND status = 'Y'  AND mo_car_sub = '' ";
    }
    $result = $_contextMitSu->query($sql);
    $fetcharr = $result->fetch(2);
    $returnedArray['idcost'] = $fetcharr['id'];
    $returnedArray['namecost'] = $fetcharr['name'];
    $returnedArray['price_cost'] = $fetcharr['price'];
    echo json_encode($returnedArray);
}
if ($call == "COST_NEW_LOGIN") {
    $tb_acc_new_sql = 'SELECT status_free FROM tb_acc_new WHERE id = "' . $_POST['id_acc'] . '"';
    $tb_acc_new_query = $_contextMitSu->query($tb_acc_new_sql);
    $tb_acc_new_array = $tb_acc_new_query->fetch(2);
    if ($tb_acc_new_array['status_free'] == 'Y') {
        $i = 0;
        $fetcharr = $result->fetch(2);
        $returnedArray[$i]['id'] = $fetcharr['id'];
        $returnedArray[$i]['name'] = 'ฟรีค่าเบี้ยอุปกรณ์ตกแต่ง';
        $returnedArray[$i]['price'] = 'ฟรีค่าเบี้ยอุปกรณ์ตกแต่ง';
        $i++;
        $status_free = 'Y';
    } else {
        $check_mocarsub_sql = "SELECT id FROM tb_acc WHERE cartype='$cartype' AND mo_car='$mo_car' AND mo_car_sub = '" . $_POST['mo_car_sub'] . "' AND DATEDIFF(`dateexp`,NOW())>=0  AND status = 'Y' ORDER BY price ASC";
        $check_mocarsub_query = $_contextMitSu->query($check_mocarsub_sql);
        $check_mocarsub_array = $check_mocarsub_query->fetch(2);
        if (!empty($check_mocarsub_array)) {
            $sql = "SELECT * FROM tb_acc WHERE name != '0.00' AND cartype='$cartype' AND mo_car='$mo_car' AND mo_car_sub = '" . $_POST['mo_car_sub'] . "' AND DATEDIFF(`dateexp`,NOW())>=0  AND status = 'Y'  ORDER BY price ASC";
        } else {
            $sql = "SELECT * FROM tb_acc WHERE name != '0.00' AND cartype='$cartype' AND mo_car='$mo_car' AND DATEDIFF(`dateexp`,NOW())>=0  AND status = 'Y' AND mo_car_sub = ''  ORDER BY price ASC";
        }
        $result = $_contextMitSu->query($sql);
        $i = 0;
        foreach ($result->fetchAll(2) as $fetcharr) {
            if ($fetcharr['name'] == '0.00') {
                $returnedArray[$i]['id'] = $fetcharr['id'];
                $returnedArray[$i]['name'] = 'ต่ำกว่า 10,000';
                $returnedArray[$i]['price'] = $fetcharr['price'];
            } else if ($fetcharr['name'] != '0.00') {
                $returnedArray[$i]['id'] = $fetcharr['id'];
                $returnedArray[$i]['name'] = number_format($fetcharr['name'], 0);
                $returnedArray[$i]['price'] = $fetcharr['price'];
            }
            $i++;
        }
        $status_free = '';
    }
    $returnedArray[0]['status_free'] = $status_free;
    echo json_encode($returnedArray);
}
