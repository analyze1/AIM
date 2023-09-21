<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resolve</title>
</head>
<body>
    <?php
    
    echo 'ปิดระบบ'; exit();
    set_time_limit(15000);

    include '../inc/connectdbs.pdo.php';

    $delarCode = $_GET['delearCode'];

    class ResolveControl
    {

        private $_context;

        public function __construct($con)
        {
            $this->_context = $con;
        }


        public function LoadProvince($province) {
            $sql = "SELECT province_code_oic FROM tb_province WHERE `name` = '$province' LIMIT 1";
            $_province = $this->_context->query($sql)->fetch(2);
            return $_province['province_code_oic'];
        }
        public function SearchTitle($title) {
            $sql = "SELECT id_prename FROM tb_titlename WHERE prename = '$title' LIMIT 1";
            $_title = $this->_context->query($sql)->fetch(2);
            return $_title['id_prename'];
        }
        public function SearchTumbon($tumbon) {
            $sql = "SELECT amphurID,id as tumID,id_post FROM tb_tumbon WHERE `name` = '$tumbon' LIMIT 1";
            $_tumbon = $this->_context->query($sql)->fetch(2);
            $res = array(); 
            $res['tumID'] = $_tumbon['tumID'];
            $res['post'] = $_tumbon['id_post'];

            $sql = "SELECT provinceID, id as amID  FROM tb_amphur WHERE id = '$_tumbon[amphurID]' LIMIT 1";
            $_amphur = $this->_context->query($sql)->fetch(2);
            
            $res['amID'] = $_amphur['amID'];
            $res['proID'] = $_amphur['provinceID'];


            return $res;
        }
        public function SearchAmphur($amphur) {
            $sql = "SELECT `name`  FROM tb_amphur WHERE id = '$amphur' LIMIT 1";
            $_amphur = $this->_context->query($sql)->fetch(2);
            return $_amphur['name'];
        }
        public function SearchCompanyById($id) {
            $sql = "SELECT com_data FROM data WHERE id_data = '$id' LIMIT 1";
            $_idcom = $this->_context->query($sql)->fetch(2);
            $sqls = "SELECT saka FROM  tb_comp WHERE sort = '$_idcom[com_data]' LIMIT 1 ";
            $_idcomnew = $this->_context->query($sqls)->fetch(2);
            return $_idcomnew['saka'];
        }

        public function save($delarCode)
        {
            $_tblogin = $this->_context->query('SELECT id_log,user FROM tb_login')->fetchAll();
            $tblogin = array();
            foreach ($_tblogin as $b)
            {
                $tblogin[$b['user']] = $b['id_log'];
            }
            
            $requests = $this->_context->query("SELECT * FROM Advance_2021_07 WHERE `Login` = '$delarCode'");
            
            // if($requests->rowCount()<0)
            // {
            //     return 'false';
            // }
            $dataID = null;

            foreach($requests->fetchAll() as $request)
            {

                $tbcustomer  = $this->_context->query("SELECT * FROM tb_customer WHERE user = '$delarCode'")->fetch();

                $com_data = 'VIB_S';
                $send_add_Y = 'N';
                
                $SendAdd="";

                    $login = $delarCode;
                                        
                    // $query_D ="SELECT * FROM `tb_customer` WHERE `nameuser` = 'Suzuki' AND user = '$login'"; // id = '1' 
                    // $row = $this->_context->query($query_D)->fetch();
                    
                    $_saka = $tbcustomer['saka'];
                    $name_inform = $request['Name_Login'];

                $idtb_login = $tblogin[$delarCode];
                
                if($_saka != "") // ดักรอ สาขา ห้าม empty
                {
                    if($com_data=='VIB_C' AND $_saka=='113')
                    {
                        $sql = "SELECT * FROM detail WHERE car_regis_text LIKE 'ปดA%' ORDER BY id DESC LIMIT 0,1 ";
                        $result = $this->_context->query($sql);
                        $fetcharr = $result->fetch();
                        $spliTRegis = explode('A', $fetcharr['car_regis_text']);
                        $idSum = ((int)$spliTRegis[1])+1;
                        $sumstr = strlen($idSum);
                        $zero = str_repeat("0", 5-$sumstr);
                        $sPlit_RE = 'ปดA'.$zero.$idSum;
                    }
                    else
                    {
                        $sPlit_RE = '-';
                    }

                    //$send_date = date();
                    
                    $n_insure = "";
                    $ty_inform = 'L';
                    $o_insure = '';
                    // $ty_prot = $_POST["ty_prot"];
                        
                    $start_date = date('Y-m-d');
                    $end_date = date('Y-m-d', strtotime('+1 year'));

                    // $startDate = date('Y-m-d');
                    // $startDate_dd = substr($startDate,0,2);
                    // $startDate_mm = substr($startDate,3,2);
                    // $startDate_yy = substr($startDate,6,4);
                    // $start_date = $startDate_yy."-".$startDate_mm."-".$startDate_dd;
                    // $ch_start=$startDate_mm."-".$startDate_dd;
                    // $year_plus = $startDate_yy+1;
                    // if($ch_start == '02-29')
                    // {
                        
                    //     $end_date = $year_plus.'-02-28';
                    // }
                    // else
                    // {
                        
                    //     $end_date = $year_plus."-".$startDate_mm."-".$startDate_dd;
                    // }
                    /*					
                    $year_plus = $startDate_yy+1;
                    $end_date = $year_plus."-".$startDate_mm."-".$startDate_dd;
                    */					
                    $name_gain = $request['Name_gaim'];
                    
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
                    $title = $request['Title'];
                    // $name = str_replace("'",'\'',$_POST["name_name"]);
                    // $last = str_replace("'",'\'',$_POST["last"]);
                    
                    $name = trim($request['Name']);
                    $last = trim($request['Last']);

                    $person = $request['Person'];
                    
                    $vocation = '';
                    $icard = $tbcustomer["icard"];
                    $add = $tbcustomer["cus_add"];
                    $group = $tbcustomer["cus_group"];
                    $town = $tbcustomer["cus_town"];
                    $lane = $tbcustomer["cus_lane"];
                    $road = $tbcustomer["cus_road"];

                    $_res = $this->SearchTumbon($tbcustomer["cus_tumbon"]);

                    $tumbon = $_res['tumID'];
                    $amphur = $_res['amID'];
                    $province = $_res['proID'];
                    
                    $postal = $_res['post'];
                    $tel_home = '-';
                    // $TelM = substr($_POST['tel_mobi'],0,3);
                    // $TelM2 = substr($_POST['tel_mobi'],4,3);
                    // $TelM3 = substr($_POST['tel_mobi'],8,4);
                    $tel_mobi = '';
                    $email = $tbcustomer['Email4'];

                    //ฐานข้อมูล detail เกี่ยวกับรถ
                

                    $mo_sub = $request['Mo_sub'];
                    // $car_id = $_POST["cartype"].$_POST["car_id"];

                    $car_id = $request['Car_id'];
                    
                    $br_car = $request['Br_car'];
                    $mo_car = $request['Mo_car'];
                    
                    $n_motor = $request['N_motor'];
                    $car_body = $request['Car_body'];
                    $car_regis = 'ป้ายแดง';
                    $car_regis_text = '-';
                    $car_regis_pro = $_res['proID'];
                    $car_color = 'ไม่ระบุ';
                    
                    $seat = $this->_context->query("SELECT `desc`,gear FROM tb_mo_car_sub WHERE id = '$request[Mo_sub]'")->fetch();

                    $s = explode('/',$seat['desc']);
                    $car_cc = $s[1];
                    $car_seat = "ไม่เกิน ".$s[0]." ที่นั่ง";
                    $car_wgt = $s[2];
                    
                    $gear = $seat["gear"];
                    
                    $regis_date = '2020';
                    
                    $equit = 'N';
                    
                    //$mo_car_product = $_POST["equit_car"]; //เลือกรุ่นรถ swift-carry
                    
                    $cat_car = $request['Car_id'] =='110'?'01':'03';
                    
                    //addon
                    // if($_POST['checkAddon']=='Y'){
                    // 	$code_addon = "";
                    // 	$code_addon_id = "";
                    // 	for($n=0;$n<count($_POST['addon_buy']);$n++)
                    // 	{
                    // 		$addon_array=explode(",",$_POST['addon_buy'][$n]);
                    // 		if($n<=0)
                    // 		{
                    // 			$commas="";
                    // 		}
                    // 		else
                    // 		{
                    // 			$commas=",";
                    // 		}
                    // 	$code_addon .= $commas.$addon_array[2]; // รหัส addon
                    // 	$code_addon_id .= $commas.$addon_array[0]; // id addon
                    // 	}
                    // }else{
                    // 	$code_addon = ""; // id addon
                    // 	$code_addon_id = ""; // id addon 
                    // }

                    /***************************************************************** */    
                        
                    $replace_acc1 = array(',','N');
                    $replace_acc2 = array('','0');

                    //ไฟแนนซ์เพิ่มทุน
                    // $add_tun_total = str_replace($replace_acc1,$replace_acc2,$_POST['price_acc_tun'])+str_replace($replace_acc1,$replace_acc2,$_POST['finance_add_tun']);

                    //$sql_tun = "SELECT * FROM tb_acc WHERE name = '".$_POST['finance_add_tun']."' and mo_car = '".$_POST["mo_car"]."' and cartype = '".$_POST["cartype"]."' ORDER BY id ";

                    // $check_mocarsub_sql="SELECT * FROM tb_acc WHERE cartype='".$_POST["cartype"]."' and mo_car='".$_POST["mo_car"]."' and status = 'Y' 
                    // 	AND mo_car_sub = '".$_POST['mo_car_sub']."' ORDER BY price ASC";

                    // $check_mocarsub_query = $this->_context->query($check_mocarsub_sql);
                    // $check_mocarsub_array = $check_mocarsub_query->fetch();

                    // if($check_mocarsub_array != null)
                    // {
                    // 	$sql_tun = "SELECT * FROM tb_acc WHERE name = '".$add_tun_total."' and mo_car = '".$_POST["mo_car"]."' and cartype = '".$_POST["cartype"]."' 
                    // 		and  mo_car_sub = '".$_POST['mo_car_sub']."' and status = 'Y' ORDER BY id ";

                    // 	$sql_tun_check = "SELECT * FROM tb_acc WHERE name = '".str_replace($replace_acc1,$replace_acc2,$_POST['finance_add_tun'])."' 
                    // 		and mo_car = '".$_POST["mo_car"]."' and cartype = '".$_POST["cartype"]."' and  mo_car_sub = '".$_POST['mo_car_sub']."' and status = 'Y' ORDER BY id ";
                    // }
                    // else
                    // {
                    // 	$sql_tun = "SELECT * FROM tb_acc WHERE name = '".$add_tun_total."' and mo_car = '".$_POST["mo_car"]."' and cartype = '".$_POST["cartype"]."' 
                    // 		and status = 'Y' ORDER BY id ";

                    // 	$sql_tun_check = "SELECT * FROM tb_acc WHERE name = '".str_replace($replace_acc1,$replace_acc2,$_POST['finance_add_tun'])."' 
                    // 		and mo_car = '".$_POST["mo_car"]."' and cartype = '".$_POST["cartype"]."' and status = 'Y' ORDER BY id ";
                    // }

                    // $result_tun = $this->_context->query($sql_tun);
                    // $fetcharr_tun = $result_tun->fetch();
                    
                    // $result_tun_check = $this->_context->query($sql_tun_check);
                    // $fetcharr_tun_check = $result_tun_check->fetch();
                    
                    // if($_POST["cartype"] == '1')
                    // {
                    // 	$id_text = '32';
                    // }
                    // else
                    // {
                    // 	$id_text = '31';
                    // }
                    
                    // $sql_tun_text = "SELECT * FROM tb_acc_new WHERE id = '".$id_text."' and idcar = '".$_POST["cartype"]."' ORDER BY id ";				
                    // $result_tun_text = $this->_context->query($sql_tun_text);
                    // $fetcharr_tun_text = $result_tun_text->fetch();
                    
                    // if($_POST['finance_add_tun_price'] != '0.00')  // เช็ค เบี้ยเพิ่ม
                    // {
                    // 	// if($_POST['acc'] != '') // มีรายการอุปกรณ์ตกแต่งเพิ่มเติมอื่นๆหรือไม่
                    // 	// {
                    // 	// 	$car_detail = $_POST['acc'].'|'.$fetcharr_tun_text['id'].','.$fetcharr_tun_check['id'];
                    // 	// 	$price_total_s = explode(',', $_POST['price_acc_tun']);
                    // 	// 	$price_total = ($price_total_s[0].$price_total_s[1])+$_POST['finance_add_tun'];

                    // 	// 	//$add_price_s = explode(',', $_POST['price_acc_cost']);
                    // 	// 	//$add_price = ($add_price_s[0].$add_price_s[1])+number_format($_POST['finance_add_tun_price'], 2, '.', '');

                    // 	// 	$add_price = str_replace(',','',$fetcharr_tun['price']);
                    // 	// }
                    // 	// else
                    // 	// {
                    // 	// 	$car_detail = $fetcharr_tun_text['id'].','.$fetcharr_tun_check['id'];
                    // 	// 	$price_total = $_POST['finance_add_tun'];

                    // 	// 	//$add_price_s = explode(',', $_POST['finance_add_tun_price']);
                    // 	// 	//$add_price = $add_price_s[0].$add_price_s[1];

                    // 	// 	$add_price = str_replace(',','',$fetcharr_tun['price']);
                    // 	// 	$equit = 'Y';

                    // 	// }
                    // }
                    // else
                    // {
                    // 	//สลักหลังอุปกรณ์ตกแต่ง
                    // 	if ( $equit=="Y")
                    // 	{
                    // 		$car_detail = $_POST['acc'];
                    // 		$price_total_s = explode(',', $_POST['price_acc_tun']);
                    // 		$price_total = $price_total_s[0].$price_total_s[1];

                    // 		//$add_price_s = explode(',', $_POST['price_acc_cost']);
                    // 		//$add_price = $add_price_s[0].$add_price_s[1];

                    // 		$add_price = '0'; //str_replace(',','',$fetcharr_tun['price']);
                    // 	}
                    // 	else
                    // 	{
                    // 		$car_detail ="ไม่มี";
                    // 	}
                    // }
                    $car_detail ="ไม่มี";
                    $sqlCost = "SELECT id as idCost FROM tb_cost WHERE mo = '$request[Mo_car]' AND mo_sub = '$request[Mo_sub]' AND comp ='VIB_S'";
                    $fetchCost = $this->_context->query($sqlCost)->fetch(2);
                    //ความคุ้มครอง
                    $costCost = $fetchCost["idCost"];
                            
                    //พรบ
                    $act3 = '9999999';

                    #region ACT
                    // if($act3 == 'SmartOn') //SmartOn คือ KeyWord ว่าจะใช้ระบบ ออนไลน์ เท่านั้น Service jump การเช็คเลข พ.ร.บ ไปเลย
                    // {
                    // 	goto Online;
                    // }

                    // //เช็ค พรบ
                    // $select_act3_sql = "SELECT act_no FROM z_act WHERE act_no = '".$act3."' AND act_status IN ('2','C','R') ";
                    // $select_act3_query = $this->_context->query($select_act3_sql);
                    // $select_act3_array = $select_act3_query->fetch();

                    // if($select_act3_array != null && $_saka =='113' && $act3!='9999999')
                    // {
                    // 	$use_act3_sql = "SELECT act_no FROM z_act WHERE act_use = '$login' AND act_status = '1'";
                    // 	$use_act3_query = $this->_context->query($use_act3_sql);
                    // 	$use_act3_array = $use_act3_query->fetch();
                    // 	$act3=$use_act3_array['act_no'];
                    // }

                    // //END เช็ค พรบ

                    // //start update act is use.
                    // $strSQL = "UPDATE z_act SET act_status = '2'  WHERE act_use = '$login'  and  act_no = '$act3'";
                    // $objQuery = $this->_context->prepare($strSQL)->execute();
                    // //end update act is use.
                    
                    // Online: //jump from online check.
                    // if ($act3 == 'SmartOn')
                    // {
                    // 	$p_act = '-';
                    // 	$p_pre = $_POST["id_prp"];
                    // 	$p_stamp = $_POST["txtstamp1"];
                    // 	$p_tax = $_POST["txttax1"];	
                    // 	$p_net = $_POST["txtnet1"];
                    // }
                    // else
                    // {
            #endregion
                        $p_act = "09712-64".$_saka."-".$act3;
                        
                        if($request['Car_id']=='110')
                        {
                            $p_id = '1.10';

                            $p_pre = '600.00';
                            $p_stamp = '3.00';
                            $p_tax = '42.21';
                            $p_net = '645.21';
                        }
                        else
                        {
                            $p_id = '1.40A';

                            $p_pre = '900.00';
                            $p_stamp = '4.00';
                            $p_tax = '63.28';	
                            $p_net = '967.28';
                        }
                
                    // }

                    
                    $career = '2';
                    $doc_type = 'ประกันภัยรถยนต์ประเภท 1';
                                        
                    //กรอกฐานข้อมูลแรก
                    //08829 | VIB_C | code113 = 1
                    //09712 | VIB_S | code113 = 0
                    //10320 | VIB_C | code113 = 0
                    //11678 | VIB_F | code113 = 0
                    
                    
                    if($com_data=='VIB_S') //09712
                    {
                        //ของเดิม
                        //$sql = "SELECT * FROM tb_inform WHERE sort = '$com_data' and saka = '$_saka' and status = '1' ORDER BY id ";
                        //ของใหม่ เนื่องจาก ให้ใช้ 09712 ทั้งหมด
                        $sql = "SELECT * FROM tb_inform WHERE sort = 'VIB_S' and saka = '$_saka' and `status` = '3' ORDER BY id ";
                    }
                    else if ($com_data=='VIB_C' AND $_saka=='113') //08829
                    {
                        //ของเดิม
                        //$sql = "SELECT * FROM tb_inform WHERE sort = '$com_data' and status = '1' and code113 = '1' ORDER BY id ";
                        //ของใหม่ เนื่องจาก ให้ใช้ 09712 ทั้งหมด
                        $sql = "SELECT * FROM tb_inform WHERE sort = 'VIB_S' and saka = '$_saka' and `status` = '3' ORDER BY id ";
                    }
                    else if ($com_data=='VIB_C' AND $_saka!='113') //10320
                    {
                        //ของเดิม
                        //$sql = "SELECT * FROM tb_inform WHERE sort = '$com_data' and status = '1' and code113 = '0' ORDER BY id ";
                        //ของใหม่ เนื่องจาก ให้ใช้ 09712 ทั้งหมด
                        $sql = "SELECT * FROM tb_inform WHERE sort = 'VIB_S' and saka = '$_saka' and `status` = '3' ORDER BY id ";
                    }
                    else if($com_data=='VIB_F') //11678
                    {
                        //ของเดิม
                        //$sql = "SELECT * FROM tb_inform WHERE sort = '$com_data' and status='1' ORDER BY id ";
                        //ของใหม่ เนื่องจาก ให้ใช้ 09712 ทั้งหมด
                        $sql = "SELECT * FROM tb_inform WHERE sort = 'VIB_S' and saka = '$_saka' and `status` = '3' ORDER BY id ";
                    }
                    
                    $result = $this->_context->query($sql);
                    $fetcharr = $result->fetch();

                    $sort = $fetcharr["sort"];
                    $id_data = $fetcharr["num_inform"];
                    $strSQL = "UPDATE tb_inform SET `status` = '4'  WHERE num_inform = '$id_data'  and  `status` = '3'  ";
                    $objQuery = $this->_context->prepare($strSQL)->execute();
                    
                    $objQuery = array();

                    $insureYear = '1';
                    $numsuy = '000001';
                    for($i = 1;$i<=(int)$insureYear; $i++)
                    {
                        $id_dataNew = explode("/",$id_data);

                        // if($i >1)
                        // {
                        //     $id_data_SU = $id_dataNew[0].'/SUY'.$insureYear.'/';// ตัดเลขรับแจ้ง แรก
                            
                        //     $strSQL_SU = "SELECT id_data FROM data WHERE id_data LIKE '".$id_data_SU."%' ORDER BY id DESC LIMIT 0,1";
                        //     $result_SU = $this->_context->query($strSQL_SU);							
                        //     $fetcharr_SU = $result_SU->fetch();
                            
                        //     $datasplit = $fetcharr_SU['id_data'];
                        //     $iddatasu = str_replace($id_data_SU,"",$datasplit);							
                        //     if($iddatasu=="")
                        //     {
                        //         $iddatasu="000000";
                        //     }							
                        //     $iddatasum = $iddatasu+1;
                        //     $sumstrdata = strlen($iddatasum);
                        //     $zerodata = str_repeat("0", 6-$sumstrdata);
                        //     $id_data = $id_data_SU.$zerodata.$iddatasum;
                            
                        //     if($i == 2)
                        //     {
                        //         $year_plus1 = $startDate_yy+1;
                        //         $start_date = $year_plus1."-".$startDate_mm."-".$startDate_dd;
                        //         $year_plus2 = $startDate_yy+2;
                        //         $end_date = $year_plus2."-".$startDate_mm."-".$startDate_dd;
                        //         if($ch_start == '02-29')
                        //             {
                        //             $end_date = $year_plus.'-02-28';
                        //             }
                        //     }
                        //     if($i == 3)
                        //     {
                        //         $year_plus1 = $startDate_yy+2;
                        //         $start_date = $year_plus1."-".$startDate_mm."-".$startDate_dd;
                        //         $year_plus2 = $startDate_yy+3;
                        //         $end_date = $year_plus2."-".$startDate_mm."-".$startDate_dd;
                        //         if($ch_start == '02-29')
                        //             {
                        //             $end_date = $year_plus.'-02-28';
                        //             }
                        //     }
                        // }
                        
                        if($i == 1)
                        {
                            $strSQL = "INSERT INTO detail (`id`, `id_data`, `car_id`, `br_car`, `mo_car`, `car_body`, `n_motor`, `car_regis`, `car_regis_text`, `car_regis_pro`, 
                                `car_color`, `car_cc`, `car_seat`, `car_wgt`, `gear`, `regis_date`, `insure_year`, `equit`, `cat_car`, `car_detail`, `price_total`, 
                                `add_price`, `code_addon`, `code_addon_id`,`mo_sub`) VALUES (NULL, '$id_data', '$car_id', '$br_car', '$mo_car', '$car_body', 
                                '$n_motor', '$car_regis', '$car_regis_text', '$car_regis_pro', '$car_color', '$car_cc', '$car_seat', '$car_wgt', '$gear', 
                                '$regis_date', '1', '$equit', '$cat_car', '$car_detail', '0','0','','','$mo_sub')";

                            $objQuery['detail'] = $this->_context->prepare($strSQL)->execute();
                        }
                        else if($i == 2)
                        {
                            $strSQL = "INSERT INTO detail (`id`, `id_data`, `car_id`, `br_car`, `mo_car`, `car_body`, `n_motor`, `car_regis`, `car_regis_text`, 
                                `car_regis_pro`, `car_color`, `car_cc`, `car_seat`, `car_wgt`, `gear`, `regis_date`, `insure_year`, `equit`, `cat_car`, `car_detail`, 
                                `price_total`, `add_price`, `code_addon`, `code_addon_id`,`mo_sub`) VALUES (NULL, '$id_data', '$car_id', '$br_car', '$mo_car', '$car_body', 
                                '$n_motor', '$car_regis', '$car_regis_text', '$car_regis_pro', '$car_color', '$car_cc', '$car_seat', '$car_wgt', '$gear', '$regis_date', '2', 
                                '$equit', '$cat_car', '$car_detail', '0','0','','','$mo_sub')";	

                            $objQuery['detail'] = $this->_context->prepare($strSQL)->execute();
                        }
                        else
                        {
                            $strSQL = "INSERT INTO detail (`id`, `id_data`, `car_id`, `br_car`, `mo_car`, `car_body`, `n_motor`, `car_regis`, `car_regis_text`, `car_regis_pro`, 
                                `car_color`, `car_cc`, `car_seat`, `car_wgt`, `gear`, `regis_date`, `insure_year`, `equit`, `cat_car`, `car_detail`, `price_total`, `add_price`, 
                                `code_addon`, `code_addon_id`,`mo_sub`) VALUES (NULL, '$id_data', '$car_id', '$br_car', '$mo_car', '$car_body', '$n_motor', '$car_regis', '$car_regis_text', 
                                '$car_regis_pro', '$car_color', '$car_cc', '$car_seat', '$car_wgt', '$gear', '$regis_date', '$insureYear', '$equit', '$cat_car', '$car_detail', 
                                '0','0','','','$mo_sub')";	

                            $objQuery['detail'] = $this->_context->prepare($strSQL)->execute();
                        }

                        
                        $rdodriver ='';
                        $strSQL = "INSERT INTO `data` (`id`,`Advance`, `login`, `com_data`, `send_date`, `id_data`, `n_insure`,`p_act`,`costCost`, `ty_inform`, `o_insure`, `start_date`, 
                            `end_date`, `name_inform`, `name_gain`, `rdodriver`,`doc_type`,`Status_Email`,`fourib`, `UserName`, `save_login`, `idtb_login`) VALUES (NULL,'Y', '$login', 
                            '$com_data', NOW(), '$id_data', '$n_insure','$p_act', '$costCost', '$ty_inform', '$o_insure', '$start_date', '$end_date', '$name_inform', '$name_gain', 
                            '$rdodriver','$doc_type','T','', '','".$login."','".$idtb_login."')";

                        $objQuery['data'] = $this->_context->prepare($strSQL)->execute();
                                        
                        $strSQL = "INSERT INTO insuree (`id`, `id_data`, `title`, `name`, `last`, `person`, `vocation`, `career`, `icard`, `add`, `group`, `town`, `lane`, `road`, 
                            `tumbon`, `amphur`, `province`, `postal`, `tel_home`, `tel_mobi`, `email`, `SendAdd`, `status_SendAdd`) VALUES (NULL, '$id_data', '$title', '$name', '$last', 
                            '$person', '$vocation', '$career', '$icard', '$add', '$group', '$town', '$lane', '$road', '$tumbon', '$amphur', '$province', '$postal', '$tel_home', '$tel_mobi', 
                            '$email','$SendAdd','$send_add_Y')";

                        $objQuery['insuree'] = $this->_context->prepare($strSQL)->execute();		

                        /*
                        $strSQL = "INSERT INTO detail (`id`, `id_data`, `car_id`, `br_car`, `mo_car`, `car_body`, `n_motor`, `car_regis`, `car_regis_text`, `car_regis_pro`, `car_color`, `car_cc`, `car_seat`, `car_wgt`, `gear`, `regis_date`, `insure_year`, `equit`, `cat_car`, `car_detail`, `price_total`, `add_price`) VALUES (NULL, '$id_data', '$car_id', '$br_car', '$mo_car', '$car_body', '$n_motor', '$car_regis', '$car_regis_text', '$car_regis_pro', '$car_color', '$car_cc', '$car_seat', '$car_wgt', '$gear', '$regis_date', '$insureYear', '$equit', '$cat_car', '$car_detail', '$price_total','$add_price')";									
                        $objQuery = mysql_query($strSQL,$cndb1);
                        */			

                        $strSQL = "INSERT INTO driver (`id`, `id_data`, `title_num1`, `name_num1`, `last_num1`, `birth_num1`, `licen_num1`, `iden_num1`, `title_num2`, `name_num2`, 
                            `last_num2`, `birth_num2`, `licen_num2`, `iden_num2`) VALUES (NULL, '$id_data', '$title_num1', '$name_num1', '$last_num1', '$birth_num1', '$licen_num1', 
                            '$iden_num1', '$title_num2', '$name_num2', '$last_num2', '$birth_num2', '$licen_num2', '$iden_num2')";		

                        $objQuery['driver'] = $this->_context->prepare($strSQL)->execute();			
                                        
                        $strSQL = "INSERT INTO protect (`id`, `id_data`, `costCost`, `first_cost`, `car_cost`) VALUES (NULL, '$id_data', '$costCost', '', '')";								
                        
                        $objQuery['protect'] = $this->_context->prepare($strSQL)->execute();	
                    
                        $strSQL = "INSERT INTO act (`id`, `id_data`, `p_id`, `p_act`, `p_pre`, `p_stamp`, `p_tax`, `p_net`) VALUES (NULL, '$id_data', '$p_id', '$p_act', '$p_pre', 
                            '$p_stamp', '$p_tax', '$p_net')";	

                        $objQuery['act'] = $this->_context->prepare($strSQL)->execute();	

                        if($equit=="Y")
                        {	
                        $strSQL = "INSERT INTO req (`id`,`id_data`,`Req_Status`,`Req_Date`,`EditProduct`,`Product`,`TotalProduct`,`CostProduct`)
                                            VALUES (NULL,'".$id_data."','Y',NOW(),'Y','".$car_detail."','0','0')";												
                        
                        $objQuery['req'] = $this->_context->prepare($strSQL)->execute();
                        }
                        else
                        {	
                        $strSQL = "INSERT INTO req (`id`, `id_data`) VALUES (NULL, '$id_data')";	

                        $objQuery['req'] = $this->_context->prepare($strSQL)->execute();
                        }
                    }
                            
                    $sql = "SELECT id_data FROM `data` WHERE id_data='$id_data'";
                    $result = $this->_context->query($sql);
                    $fetcharr = $result->fetch();
                    $id = $fetcharr["id_data"];


                    $dataID .= "$id<br>";


                    // $returnedArray = array();
                    
                    // // Start Topfy present
                    // $returnedArray['idperson'] = $person;
                    // $returnedArray['msg'] = "ระบบดำเนินการบันทึกสมบูรณ์แล้ว! \r\nเลขรับแจ้ง : ".$id_data;
                    // $returnedArray['id'] = base64_encode($id);
                    // $returnedArray['DataApiId'] = $id;
                    // $returnedArray['ResponseDataBases'] = $objQuery;
                    // END Topfy present




                    //begin sing
                    //@mysql_query("call prepare_individuals('".$id_data."')",$cndb1);
                    
                    //เช็คเบอร์ tb_mobile_all
                    
                    // $_contextFour = $this->_context;

                    // $tel_data=$_POST['tel_home']."|".$_POST['tel_mobi'];
                    // $tel_array=explode("|",$tel_data);

                    // for( $n=0; $n<count($tel_array); $n++ )
                    // {
                    //     $tel_preg=preg_replace('/[^0-9]/','',$tel_array[$n]);
                    //     $ch_sql="SELECT id FROM tb_mobile_all WHERE data_tel = '".$tel_preg."'";
                    //     $ch_query = $_contextFour->query($ch_sql);
                    //     $ch_array = $ch_query->fetch();

                    //     if($ch_array != null)
                    //     {
                    //         $update_sql = "UPDATE tb_mobile_all SET data_iddata = '".$id_data."',data_name = '".$title.$name."',data_lname = '".$last."',data_system = 'SZ',call_update = NOW(),updateby = '".$_SESSION['strUser']."' WHERE id = '".$ch_array['id']."' AND data_tel = '".$tel_preg."'";
                    //         $_contextFour->prepare($update_sql)->execute();
                    //     }
                    //     else
                    //     {
                    //         $insert_sql="INSERT INTO tb_mobile_all (data_tel,data_name,data_lname,data_iddata,data_system,data_remark,call_in,call_out,call_date,call_update,updateby) VALUES 
                    //         ('".$tel_preg."','".$title.$name."','".$last."','".$id_data."','SZ','','0','0',NOW(),NOW(),'".$_SESSION['strUser']."') ";
                    //         $_contextFour->prepare($insert_sql)->execute();
                    //     }
            }
        }
        return $dataID;
    }
}


$value = array('3000018');

$service = new ResolveControl(PDO_CONNECTION::fourinsure_mitsu());

foreach($value as $v)
{
    $res = $service->save($v);
    echo $res;
}

echo 'FUCK!!';

?>
</body>
</html>