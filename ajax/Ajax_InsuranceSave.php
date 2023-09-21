<?php
/*********************************************  System Save Insurance Edit By Ekkachai Siangtes 11-05-2020  ******************************************************** */
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";

// print_r($_POST); exit;

$_contextMitsu = PDO_CONNECTION::fourinsure_mitsu();
$com_data = $_POST["com_data"];
$send_add_Y = $_POST['status_send_add'];
$SendAdd = "";
if ($send_add_Y == 'Y') {
    $SendAdd = $_POST['send_add'] . "|" . $_POST['send_group'] . "|" . $_POST['send_town'] . "|" . $_POST['send_lane'] . "|" . $_POST['send_road'] . "|" . $_POST['send_province'] . "|" . $_POST['send_amphur'] . "|" . $_POST['send_tumbon'] . "|" . $_POST['send_post'];
}
if ($_POST["xuser"] == 'admin') {
    $login = $_POST["Dxuser"];
    $user4 = $_POST["xuser"];
    $UserName = $_POST["xUserName"];
    $query_D = "SELECT * FROM `tb_customer` WHERE `nameuser` = 'Mitsubishi' AND user = '$login'"; // id = '1'
    $row = $_contextMitsu->query($query_D)->fetch();
    $_saka = $row['saka'];
    $name_inform = $row['title_sub'] . " " . $row['sub'];
} else {
    $login = $_POST["xuser"];
    $query_D = "SELECT * FROM `tb_customer` WHERE `nameuser` = 'Mitsubishi' AND user = '$login'"; // id = '1'
    $row = $_contextMitsu->query($query_D)->fetch();
    $_saka = $row['saka'];
    $name_inform = $_POST["name_inform"];
}
$idtb_login = $_POST["idtb_login"];
$usertb_login = $_POST["usertb_login"]; // ยังไม่ได้ใช้งานจ๊ะ
if ($_saka != "") // ดักรอ สาขา ห้าม empty
{
    if ($com_data == 'VIB_C' AND $_saka == '113') {
        $sql = "SELECT * FROM detail WHERE car_regis_text LIKE 'ปดA%' ORDER BY id DESC LIMIT 0,1 ";
        $result = $_contextMitsu->query($sql);
        $fetcharr = $result->fetch();
        $spliTRegis = explode('A', $fetcharr['car_regis_text']);
        $idSum = ((int)$spliTRegis[1]) + 1;
        $sumstr = strlen($idSum);
        $zero = str_repeat("0", 5 - $sumstr);
        $sPlit_RE = 'ปดA' . $zero . $idSum;
    } else {
        $sPlit_RE = '-';
    }
    $send_date = $_POST["send_date"];
    $n_insure = "";
    $ty_inform = $_POST["ty_inform"];
    $o_insure = $_POST["o_insure"];
    $ty_prot = $_POST["ty_prot"];
    $startDate = $_POST["start_date"];
    $startDate_dd = substr($startDate, 0, 2);
    $startDate_mm = substr($startDate, 3, 2);
    $startDate_yy = substr($startDate, 6, 4);
    $start_date = $startDate_yy . "-" . $startDate_mm . "-" . $startDate_dd;
    $ch_start = $startDate_mm . "-" . $startDate_dd;
    $year_plus = $startDate_yy + 1;
    if ($ch_start == '02-29') {
        $end_date = $year_plus . '-02-28';
    } else {
        $end_date = $year_plus . "-" . $startDate_mm . "-" . $startDate_dd;
    }
    /*
    $year_plus = $startDate_yy+1;
    $end_date = $year_plus."-".$startDate_mm."-".$startDate_dd;
    */
    $name_gain = $_POST["name_gain"];
    // ระบุผู้ขับขี่
    $title_num1 = "ไม่ระบุ";
    $name_num1 = "ไม่ระบุ";
    $last_num1 = "ไม่ระบุ";
    $birth_num1 = "ไม่ระบุ";
    $licen_num1 = "ไม่ระบุ";
    $iden_num1 = "ไม่ระบุ";
    $title_num2 = "ไม่ระบุ";
    $name_num2 = "ไม่ระบุ";
    $last_num2 = "ไม่ระบุ";
    $birth_num2 = "ไม่ระบุ";
    $licen_num2 = "ไม่ระบุ";
    $iden_num2 = "ไม่ระบุ";
    //ฐานข้อมูล insuree ส่วนผู้เอาประกัน
    $title = $_POST["title"];
	$name = str_replace("'", '\'', $_POST["name_name"]);
	$last = $_POST['ByCustomer'] . str_replace("'", '\'', $_POST["last"]);
    $person = $_POST["person"];
    $vocation = $_POST["vocation"];
    $icard = $_POST["icard"];
    $add = $_POST["add"];
    $group = $_POST["group"];
    $town = $_POST["town"];
    $lane = $_POST["lane"];
    $road = $_POST["road"];
    $tumbon = $_POST["tumbon"];
    $amphur = $_POST["amphur"];
    $province = $_POST["province"];
    $postal = $_POST["id_post"];
    $tel_home = $_POST["tel_home"];
    $TelM = substr($_POST['tel_mobi'], 0, 3);
    $TelM2 = substr($_POST['tel_mobi'], 4, 3);
    $TelM3 = substr($_POST['tel_mobi'], 8, 4);
    $tel_mobi = $_POST['tel_mobi']; //$TelM.$TelM2.$TelM3;
    $email = $_POST['email'];
    //ฐานข้อมูล detail เกี่ยวกับรถ
    $mo_sub = $_POST['mo_car_sub'];
    $car_id = $_POST["cartype"] . $_POST["car_id"];
    $br_car = $_POST["br_car"];
    $mo_car = $_POST["mo_car"];
    $car_body = $check_car;
    $n_motor = $_POST["new_motor"] . $_POST["n_motor"];
	$car_body = $_POST["new_carbody"] . $_POST["car_body"];
    $car_regis = $_POST["car_regis"];
    $car_regis_text = $sPlit_RE;
    $car_regis_pro = $_POST["car_regis_pro"];
    $car_color = $_POST["car_color"];
    $car_cc = $_POST["car_cc"];
    $car_seat = $_POST["car_seat"];
    $car_wgt = $_POST["car_wgt"];
    $gear = $_POST["gear"];
    $regis_date = $_POST["regis_date"];
    $equit = $_POST["equit"];
    $mo_car_product = $_POST["equit_car"]; //เลือกรุ่นรถ swift-carry
    $cat_car = '0' . $_POST["cat_car"];
    //addon
    if ($_POST['checkAddon'] == 'Y') {
        $code_addon = "";
        $code_addon_id = "";
        for ($n = 0;$n < count($_POST['addon_buy']);$n++) {
            $addon_array = explode(",", $_POST['addon_buy'][$n]);
            if ($n <= 0) {
                $commas = "";
            } else {
                $commas = ",";
            }
            $code_addon.= $commas . $addon_array[2]; // รหัส addon
            $code_addon_id.= $commas . $addon_array[0]; // id addon
            
        }
    } else {
        $code_addon = ""; // id addon
        $code_addon_id = ""; // id addon
        
    }
    /***************************************************************** */
    $replace_acc1 = array(',', 'N');
    $replace_acc2 = array('', '0');
    $_tun = $_POST['finance_add_tun'] == 'add' ? $_POST['finance_custom_tun'] : $_POST['finance_add_tun'];
    //ไฟแนนซ์เพิ่มทุน
    $add_tun_total = str_replace($replace_acc1, $replace_acc2, $_POST['price_acc_tun']) + str_replace($replace_acc1, $replace_acc2, $_tun);
    //$sql_tun = "SELECT * FROM tb_acc WHERE name = '".$_tun."' and mo_car = '".$_POST["mo_car"]."' and cartype = '".$_POST["cartype"]."' ORDER BY id ";
    $check_mocarsub_sql = "SELECT * FROM tb_acc WHERE cartype='" . $_POST["cartype"] . "' and mo_car='" . $_POST["mo_car"] . "' and status = 'Y' 
			AND mo_car_sub = '" . $_POST['mo_car_sub'] . "' ORDER BY price ASC";
    $check_mocarsub_query = $_contextMitsu->query($check_mocarsub_sql);
    $check_mocarsub_array = $check_mocarsub_query->fetch();
    if ($check_mocarsub_array != null) {
        $sql_tun = "SELECT * FROM tb_acc WHERE name = '" . $add_tun_total . "' and mo_car = '" . $_POST["mo_car"] . "' and cartype = '" . $_POST["cartype"] . "' 
				and  mo_car_sub = '" . $_POST['mo_car_sub'] . "' and status = 'Y' ORDER BY id ";
        $sql_tun_check = "SELECT * FROM tb_acc WHERE name = '" . str_replace($replace_acc1, $replace_acc2, $_tun) . "' 
				and mo_car = '" . $_POST["mo_car"] . "' and cartype = '" . $_POST["cartype"] . "' and  mo_car_sub = '" . $_POST['mo_car_sub'] . "' and status = 'Y' ORDER BY id ";
    } else {
        $sql_tun = "SELECT * FROM tb_acc WHERE name = '" . $add_tun_total . "' and mo_car = '" . $_POST["mo_car"] . "' and cartype = '" . $_POST["cartype"] . "' 
				and status = 'Y' ORDER BY id ";
        $sql_tun_check = "SELECT * FROM tb_acc WHERE name = '" . str_replace($replace_acc1, $replace_acc2, $_tun) . "' 
				and mo_car = '" . $_POST["mo_car"] . "' and cartype = '" . $_POST["cartype"] . "' and status = 'Y' ORDER BY id ";
    }
    $result_tun = $_contextMitsu->query($sql_tun);
    $fetcharr_tun = $result_tun->fetch();
    $result_tun_check = $_contextMitsu->query($sql_tun_check);
    $fetcharr_tun_check = $result_tun_check->fetch();
    if ($_POST["cartype"] == '1') {
        $id_text = '32';
    } else {
        $id_text = '31';
    }
    $sql_tun_text = "SELECT * FROM tb_acc_new WHERE id = '" . $id_text . "' and idcar = '" . $_POST["cartype"] . "' ORDER BY id ";
    $result_tun_text = $_contextMitsu->query($sql_tun_text);
    $fetcharr_tun_text = $result_tun_text->fetch();
    if ($_POST['finance_add_tun_price'] != '0.00') // เช็ค เบี้ยเพิ่ม
    {
        if ($_POST['acc'] != '') // มีรายการอุปกรณ์ตกแต่งเพิ่มเติมอื่นๆหรือไม่
        {
            $car_detail = $_POST['acc'] . '|' . $fetcharr_tun_text['id'] . ',' . $fetcharr_tun_check['id'];
            $price_total_s = explode(',', $_POST['price_acc_tun']);
            $price_total = ($price_total_s[0] . $price_total_s[1]) + $_tun;
            //$add_price_s = explode(',', $_POST['price_acc_cost']);
            //$add_price = ($add_price_s[0].$add_price_s[1])+number_format($_POST['finance_add_tun_price'], 2, '.', '');
            $add_price = str_replace(',', '', $fetcharr_tun['price']);
        } else {
            $car_detail = $fetcharr_tun_text['id'] . ',' . $fetcharr_tun_check['id'];
            $price_total = $_tun;
            //$add_price_s = explode(',', $_POST['finance_add_tun_price']);
            //$add_price = $add_price_s[0].$add_price_s[1];
            $add_price = str_replace(',', '', $fetcharr_tun['price']);
            $equit = 'Y';
        }
    } else {
        //สลักหลังอุปกรณ์ตกแต่ง
        if ($equit == "Y") {
            $car_detail = $_POST['acc'];
            $price_total_s = explode(',', $_POST['price_acc_tun']);
            $price_total = $price_total_s[0] . $price_total_s[1];
            //$add_price_s = explode(',', $_POST['price_acc_cost']);
            //$add_price = $add_price_s[0].$add_price_s[1];
            $add_price = str_replace(',', '', $fetcharr_tun['price']);
        } else {
            $car_detail = "ไม่มี";
        }
    }
    /*ชุดเชิญ อุปกรณ์จากโรงงาน*/
    // echo $_POST['accesForce'];
    if ($_POST['accesForce'] != '') {
        $id_sub = $_POST['mo_car_sub'];
        $fetchAccNew = $_contextMitsu->query("SELECT id FROM tb_acc_new WHERE mo_sub = '$id_sub' AND AccesForce = '1' ")->fetch(2);
        $fetchAcc = $_contextMitsu->query("SELECT id FROM tb_acc WHERE mo_car_sub = '$id_sub' AND `name` = '0.00' ")->fetch(2);
        $ConvertAcc = $fetchAccNew['id'] != '' && $fetchAcc['id'] != '' ? "$fetchAccNew[id],$fetchAcc[id]" : "";
        $car_detail = ($car_detail == 'ไม่มี' || $car_detail == '') ? ($ConvertAcc == '' ? 'ไม่มี' : $ConvertAcc) : ($ConvertAcc == '' ? $car_detail : "$ConvertAcc|$car_detail");
        /*เช้คว่ามี อุปกรณ์ตกแต่งรึเปล่า*/
        // $car_detail == 'ไม่มี' || $car_detail == '' ? $car_detail = 'ไม่มี' : "";
        $equit = $car_detail == 'ไม่มี' ? 'N' : 'Y';
        // echo $equit."<br>";
        // echo $car_detail;
        
    }
    /*จบ ชุดเชิญ อุปกรณ์จากโรงงาน*/
    // echo "end";
    // exit();
    //ความคุ้มครอง
    $costCost = $_POST["costCost"];
    //พรบ
    $act3 = $_POST["p_act3"];
    if ($act3 == 'SmartOn') //SmartOn คือ KeyWord ว่าจะใช้ระบบ ออนไลน์ เท่านั้น Service jump การเช็คเลข พ.ร.บ ไปเลย
    {
        goto Online;
    }
    //เช็ค พรบ
    $select_act3_sql = "SELECT act_no FROM z_act WHERE act_no = '" . $act3 . "' AND act_status IN ('2','C','R') ";
    $select_act3_query = $_contextMitsu->query($select_act3_sql);
    $select_act3_array = $select_act3_query->fetch();
    if ($select_act3_array != null && $_saka == '113' && $act3 != '9999999') {
        $use_act3_sql = "SELECT act_no FROM z_act WHERE act_use = '$login' AND act_status = '1'";
        $use_act3_query = $_contextMitsu->query($use_act3_sql);
        $use_act3_array = $use_act3_query->fetch();
        $act3 = $use_act3_array['act_no'];
    }
    //END เช็ค พรบ
    //start update act is use.
    $strSQL = "UPDATE z_act SET act_status = '2'  WHERE act_use = '$login'  and  act_no = '$act3'";
    $objQuery = $_contextMitsu->prepare($strSQL)->execute();
    //end update act is use.
    Online: //jump from online check.
        if ($act3 == 'SmartOn') {
            $p_act = '-';
            $p_pre = $_POST["id_prp"];
            $p_stamp = $_POST["txtstamp1"];
            $p_tax = $_POST["txttax1"];
            $p_net = $_POST["txtnet1"];
        } else {
            $p_act = $_POST["p_act1"] . "-" . $_POST["p_act2"] . "-" . $act3;
            $p_pre = $_POST["id_prp"];
            $p_stamp = $_POST["txtstamp1"];
            $p_tax = $_POST["txttax1"];
            $p_net = $_POST["txtnet1"];
        }
        $p_id = $_POST['ApiTypeCode']; //API Code พ.ร.บ.
        $career = $_POST["address_chk"];
        $doc_type = $_POST["doc_type"];
        //กรอกฐานข้อมูลแรก
        //08829 | VIB_C | code113 = 1
        //09712 | VIB_S | code113 = 0
        //10320 | VIB_C | code113 = 0
        //11678 | VIB_F | code113 = 0
        if ($com_data == 'VIB_S') //09712
        {
            //ของเดิม
            //$sql = "SELECT * FROM tb_inform WHERE sort = '$com_data' and saka = '$_saka' and status = '1' ORDER BY id ";
            //ของใหม่ เนื่องจาก ให้ใช้ 09712 ทั้งหมด
            $sql = "SELECT * FROM tb_inform WHERE sort = 'VIB_S' and saka = '$_saka' and status = '1' ORDER BY id ";
        } else if ($com_data == 'VIB_C' AND $_saka == '113') //08829
        {
            //ของเดิม
            //$sql = "SELECT * FROM tb_inform WHERE sort = '$com_data' and status = '1' and code113 = '1' ORDER BY id ";
            //ของใหม่ เนื่องจาก ให้ใช้ 09712 ทั้งหมด
            $sql = "SELECT * FROM tb_inform WHERE sort = 'VIB_S' and saka = '$_saka' and status = '1' ORDER BY id ";
        } else if ($com_data == 'VIB_C' AND $_saka != '113') //10320
        {
            //ของเดิม
            //$sql = "SELECT * FROM tb_inform WHERE sort = '$com_data' and status = '1' and code113 = '0' ORDER BY id ";
            //ของใหม่ เนื่องจาก ให้ใช้ 09712 ทั้งหมด
            $sql = "SELECT * FROM tb_inform WHERE sort = 'VIB_S' and saka = '$_saka' and status = '1' ORDER BY id ";
        } else if ($com_data == 'VIB_F') //11678
        {
            //ของเดิม
            //$sql = "SELECT * FROM tb_inform WHERE sort = '$com_data' and status='1' ORDER BY id ";
            //ของใหม่ เนื่องจาก ให้ใช้ 09712 ทั้งหมด
            $sql = "SELECT * FROM tb_inform WHERE sort = 'VIB_S' and saka = '$_saka' and status = '1' ORDER BY id ";
        }
        $result = $_contextMitsu->query($sql);
        $fetcharr = $result->fetch();
        $sort = $fetcharr["sort"];
        $id_data = $fetcharr["num_inform"];
        $strSQL = "UPDATE tb_inform SET status = '2'  WHERE num_inform = '$id_data'  and  status = '1'  ";
        $objQuery = $_contextMitsu->prepare($strSQL)->execute();
        $objQuery = array();
        $insureYear = $_POST["insureYear"];
        $numsuy = '000001';
        for ($i = 1;$i <= (int)$insureYear;$i++) {
            $id_dataNew = explode("/", $id_data);
            if ($i > 1) {
                $id_data_SU = $id_dataNew[0] . '/SUY' . $insureYear . '/'; // ตัดเลขรับแจ้ง แรก
                $strSQL_SU = "SELECT id_data FROM data WHERE id_data LIKE '" . $id_data_SU . "%' ORDER BY id DESC LIMIT 0,1";
                $result_SU = $_contextMitsu->query($strSQL_SU);
                $fetcharr_SU = $result_SU->fetch();
                
                $datasplit = $fetcharr_SU['id_data'];
                $iddatasu = str_replace($id_data_SU, "", $datasplit);
                if ($iddatasu == "") {
                    $iddatasu = "000000";
                }
                $iddatasum = $iddatasu + 1;
                $sumstrdata = strlen($iddatasum);
                $zerodata = str_repeat("0", 6 - $sumstrdata);
                $id_data = $id_data_SU . $zerodata . $iddatasum;
                if ($i == 2) {
                    $year_plus1 = $startDate_yy + 1;
                    $start_date = $year_plus1 . "-" . $startDate_mm . "-" . $startDate_dd;
                    $year_plus2 = $startDate_yy + 2;
                    $end_date = $year_plus2 . "-" . $startDate_mm . "-" . $startDate_dd;
                    if ($ch_start == '02-29') {
                        $end_date = $year_plus . '-02-28';
                    }
                }
                if ($i == 3) {
                    $year_plus1 = $startDate_yy + 2;
                    $start_date = $year_plus1 . "-" . $startDate_mm . "-" . $startDate_dd;
                    $year_plus2 = $startDate_yy + 3;
                    $end_date = $year_plus2 . "-" . $startDate_mm . "-" . $startDate_dd;
                    if ($ch_start == '02-29') {
                        $end_date = $year_plus . '-02-28';
                    }
                }
            }
            
            if ($i == 1) {
                $strSQL = "INSERT INTO detail (`id`, `id_data`, `car_id`, `br_car`, `mo_car`, `car_body`, `n_motor`, `car_regis`, `car_regis_text`, `car_regis_pro`, 
					`car_color`, `car_cc`, `car_seat`, `car_wgt`, `gear`, `regis_date`, `insure_year`, `equit`, `cat_car`, `car_detail`, `price_total`, 
					`add_price`, `code_addon`, `code_addon_id`,`mo_sub`) VALUES (NULL, '$id_data', '$car_id', '$br_car', '$mo_car', '$car_body', 
					'$n_motor', '$car_regis', '$car_regis_text', '$car_regis_pro', '$car_color', '$car_cc', '$car_seat', '$car_wgt', '$gear', 
					'$regis_date', '1', '$equit', '$cat_car', '$car_detail', '$price_total','$add_price','$code_addon','$code_addon_id','$mo_sub')";
                $objQuery['detail'] = $_contextMitsu->prepare($strSQL)->execute();
            } else if ($i == 2) {
                $strSQL = "INSERT INTO detail (`id`, `id_data`, `car_id`, `br_car`, `mo_car`, `car_body`, `n_motor`, `car_regis`, `car_regis_text`, 
					`car_regis_pro`, `car_color`, `car_cc`, `car_seat`, `car_wgt`, `gear`, `regis_date`, `insure_year`, `equit`, `cat_car`, `car_detail`, 
					`price_total`, `add_price`, `code_addon`, `code_addon_id`,`mo_sub`) VALUES (NULL, '$id_data', '$car_id', '$br_car', '$mo_car', '$car_body', 
					'$n_motor', '$car_regis', '$car_regis_text', '$car_regis_pro', '$car_color', '$car_cc', '$car_seat', '$car_wgt', '$gear', '$regis_date', '2', 
					'$equit', '$cat_car', '$car_detail', '$price_total','$add_price','$code_addon','$code_addon_id','$mo_sub')";
                $objQuery['detail'] = $_contextMitsu->prepare($strSQL)->execute();
            } else {
                $strSQL = "INSERT INTO detail (`id`, `id_data`, `car_id`, `br_car`, `mo_car`, `car_body`, `n_motor`, `car_regis`, `car_regis_text`, `car_regis_pro`, 
					`car_color`, `car_cc`, `car_seat`, `car_wgt`, `gear`, `regis_date`, `insure_year`, `equit`, `cat_car`, `car_detail`, `price_total`, `add_price`, 
					`code_addon`, `code_addon_id`,`mo_sub`) VALUES (NULL, '$id_data', '$car_id', '$br_car', '$mo_car', '$car_body', '$n_motor', '$car_regis', '$car_regis_text', 
					'$car_regis_pro', '$car_color', '$car_cc', '$car_seat', '$car_wgt', '$gear', '$regis_date', '$insureYear', '$equit', '$cat_car', '$car_detail', 
					'$price_total','$add_price','$code_addon','$code_addon_id','$mo_sub')";
                $objQuery['detail'] = $_contextMitsu->prepare($strSQL)->execute();
            }

            $strSQL = "INSERT INTO `data` (`id`, `login`, `com_data`, `send_date`, `id_data`, `n_insure`,`p_act`,`costCost`, `ty_inform`, `o_insure`, `start_date`, 
				`end_date`, `name_inform`, `name_gain`, `rdodriver`,`doc_type`,`Status_Email`,`fourib`, `UserName`, `save_login`, `idtb_login`) VALUES (NULL, '$login', 
				'$com_data', NOW(), '$id_data', '$n_insure','$p_act', '$costCost', '$ty_inform', '$o_insure', '$start_date', '$end_date', '$name_inform', '$name_gain', 
				'$rdodriver','$doc_type','F','', '','" . $_POST["xuser"] . "','" . $idtb_login . "')";
            $objQuery['data'] = $_contextMitsu->prepare($strSQL)->execute();

            $strSQL = "INSERT INTO insuree (`id`, `id_data`, `title`, `name`, `last`, `person`, `vocation`, `career`, `icard`, `add`, `group`, `town`, `lane`, `road`, 
				`tumbon`, `amphur`, `province`, `postal`, `tel_home`, `tel_mobi`, `email`, `SendAdd`, `status_SendAdd`) VALUES (NULL, '$id_data', '$title', '$name', '$last', 
				'$person', '$vocation', '$career', '$icard', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_home', '$tel_mobi', 
				'$email','$SendAdd','$send_add_Y')";
            $objQuery['insuree'] = $_contextMitsu->prepare($strSQL)->execute();
            /*
            $strSQL = "INSERT INTO detail (`id`, `id_data`, `car_id`, `br_car`, `mo_car`, `car_body`, `n_motor`, `car_regis`, `car_regis_text`, `car_regis_pro`, `car_color`, `car_cc`, `car_seat`, `car_wgt`, `gear`, `regis_date`, `insure_year`, `equit`, `cat_car`, `car_detail`, `price_total`, `add_price`) VALUES (NULL, '$id_data', '$car_id', '$br_car', '$mo_car', '$car_body', '$n_motor', '$car_regis', '$car_regis_text', '$car_regis_pro', '$car_color', '$car_cc', '$car_seat', '$car_wgt', '$gear', '$regis_date', '$insureYear', '$equit', '$cat_car', '$car_detail', '$price_total','$add_price')";
            $objQuery = mysql_query($strSQL,$cndb1);
            */
            $strSQL = "INSERT INTO driver (`id`, `id_data`, `title_num1`, `name_num1`, `last_num1`, `birth_num1`, `licen_num1`, `iden_num1`, `title_num2`, `name_num2`, 
				`last_num2`, `birth_num2`, `licen_num2`, `iden_num2`) VALUES (NULL, '$id_data', '$title_num1', '$name_num1', '$last_num1', '$birth_num1', '$licen_num1', 
				'$iden_num1', '$title_num2', '$name_num2', '$last_num2', '$birth_num2', '$licen_num2', '$iden_num2')";
            $objQuery['driver'] = $_contextMitsu->prepare($strSQL)->execute();

            $strSQL = "INSERT INTO protect (`id`, `id_data`, `costCost`, `first_cost`, `car_cost`) VALUES (NULL, '$id_data', '$costCost', '$first_cost', '$car_cost')";
            $objQuery['protect'] = $_contextMitsu->prepare($strSQL)->execute();

            $strSQL = "INSERT INTO act (`id`, `id_data`, `p_id`, `p_act`, `p_pre`, `p_stamp`, `p_tax`, `p_net`) VALUES (NULL, '$id_data', '$p_id', '$p_act', '$p_pre', 
				'$p_stamp', '$p_tax', '$p_net')";
            $objQuery['act'] = $_contextMitsu->prepare($strSQL)->execute();

            if ($equit == "Y") {
                $strSQL = "INSERT INTO req (`id`,`id_data`,`Req_Status`,`Req_Date`,`EditProduct`,`Product`,`TotalProduct`,`CostProduct`)
								VALUES (NULL,'" . $id_data . "','Y',NOW(),'Y','" . $car_detail . "','" . $price_total . "','" . $add_price . "')";
                $objQuery['req'] = $_contextMitsu->prepare($strSQL)->execute();
            } else {
                $strSQL = "INSERT INTO req (`id`, `id_data`) VALUES (NULL, '$id_data')";
                $objQuery['req'] = $_contextMitsu->prepare($strSQL)->execute();
            }
        }
		
        $sql = "SELECT id_data FROM `data` WHERE id_data='$id_data'";
        $result = $_contextMitsu->query($sql);
        $fetcharr = $result->fetch();
        $id = $fetcharr["id_data"];
        $returnedArray = array();
        // Start Topfy present
        $returnedArray['idperson'] = $person;
        $returnedArray['msg'] = "ระบบดำเนินการบันทึกสมบูรณ์แล้ว! \r\nเลขรับแจ้ง : " . $id_data;
        $returnedArray['id'] = base64_encode($id);
        $returnedArray['DataApiId'] = $id;
        $returnedArray['ResponseDataBases'] = $objQuery;
        // END Topfy present
        //begin sing
        //@mysql_query("call prepare_individuals('".$id_data."')",$cndb1);
        //เช็คเบอร์ tb_mobile_all
        $_contextFour = PDO_CONNECTION::fourinsure_insured();
        $tel_data = $_POST['tel_home'] . "|" . $_POST['tel_mobi'];
        $tel_array = explode("|", $tel_data);
        for ($n = 0;$n < count($tel_array);$n++) {
            $tel_preg = preg_replace('/[^0-9]/', '', $tel_array[$n]);
            $ch_sql = "SELECT id FROM tb_mobile_all WHERE data_tel = '" . $tel_preg . "'";
            $ch_query = $_contextFour->query($ch_sql);
            $ch_array = $ch_query->fetch();
            if ($ch_array != null) {
                $update_sql = "UPDATE tb_mobile_all SET data_iddata = '" . $id_data . "',data_name = '" . $title . $name . "',data_lname = '" . $last . "',data_system = 'SZ',call_update = NOW(),updateby = '" . $_SESSION['strUser'] . "' WHERE id = '" . $ch_array['id'] . "' AND data_tel = '" . $tel_preg . "'";
                $_contextFour->prepare($update_sql)->execute();
            } else {
                $insert_sql = "INSERT INTO tb_mobile_all (data_tel,data_name,data_lname,data_iddata,data_system,data_remark,call_in,call_out,call_date,call_update,updateby) VALUES 
				('" . $tel_preg . "','" . $title . $name . "','" . $last . "','" . $id_data . "','SZ','','0','0',NOW(),NOW(),'" . $_SESSION['strUser'] . "') ";
                $_contextFour->prepare($insert_sql)->execute();
            }
        }
        //END เช็คเบอร์ tb_mobile_all
        //end sing
        echo json_encode($returnedArray);
    } else {
        $returnedArray = array();
        // Start Topfy present
        $returnedArray['idperson'] = $person;
        $returnedArray['msg'] = "กรุณา Login แล้วแจ้งใหม่ ขอบคุณครับ/ค่ะ";
        $returnedArray['id'] = base64_encode($id);
        $returnedArray['DataApiId'] = $id;
        // END Topfy present
        echo json_encode($returnedArray);
    }
?>