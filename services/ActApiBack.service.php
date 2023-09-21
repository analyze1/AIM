<?php

/*************************************************** Black Act Api 09712 AND 08829 ***************************************** */

class loadInformationControl
{
    public static function postApiControl($dataID)
    {
        // $url='https://wsdev.viriyah.co.th/ViriyahWSPolicyDev/SendEPolicyCMIRealTime';
        // $username ="WS09712";
        // $password ="N6n8R7yb2x";

        // $url = 'https://ws.viriyah.co.th/ViriyahWSPolicy/SendEPolicyCMIRealTime';
        // $username = "WS09712";
        // $password = "tZXpYj46s2";

        $customerInfo = LoadInformationCustomerFour::getInfoCustomerFourById($dataID);

        $_infomationMap = ApiMapper::requestMapperApi08829($customerInfo, $dataID);

        // $_requestApi = ApiMapper::requestApiModel($_infomationMap);

        $client1 = new nusoap_client(_ActLink, true);
        $client1->soap_defencoding = 'UTF-8';
        $soapError = $client1->getError();

        if ($client1->fault) {
            $fault = "{$client1->faultcode}: {$client1->faultdetail} ";
            // handle fault situation
        }

        if (!empty($soapError)) {
            $errorMessage = 'SOAP method invocation (verifyT) failed: ' . $soapError;
            $_res['Status'] = 200;
            $_res['DataId'] = $dataID;
            $_res['PerSonID'] = LoadInformationCustomerFour::loadPerson($dataID);
            // $_res['msg'] = "ใบแจ้งเลขที่ :$IDDATA ไม่สามารถบันทึกได้ ทางระบบได้คืน เลข เรียบร้อยแล้ว กรุณา ติดต่อ Admin และเปิดหน้านี้ค้างไว้ ห้ามปิด ขอบคุณครับ";
            $_res['msg'] = "ระบบ API ไม่สามารถเชื่อมต่อได้ กรุณาติดต่อเจ้าหน้าที่ : $errorMessage";
            $_res['paramiter'] = $_infomationMap;
            return $_res;
        } else {

            $dataRes = $client1->call("SendPolicyCTPRealTime", $_infomationMap);
            $returnPolicyNo = $dataRes['SendPolicyCTPRealTimeResult']['PolicyNo'];
            $returnBarCode = $dataRes['SendPolicyCTPRealTimeResult']['BarCode'];
            $returnPolicyURL = $dataRes['SendPolicyCTPRealTimeResult']['PolicyURL'];
            $returnResult = $dataRes['SendPolicyCTPRealTimeResult']['Result'];
            $returnErrorCode = $dataRes['SendPolicyCTPRealTimeResult']['ErrorCode'];
            $returnErrorMsg = $dataRes['SendPolicyCTPRealTimeResult']['ErrorMsg'];

            /************* Default variable ****************/
            $_nowDay = date('Y-m-d H:i:s');
            $_user = $_SESSION["strUser"];
            $agcode = "08829";
            $nowYear =  date('Y') + 543;
            $agYear = substr($nowYear, 2);
            $agsaka = '113';//substr($dataID,2,3);

            if (!empty($returnResult)) {

                //ไม่ว่าจะผ่านหรือไม่ response api ถ้าไม่ว่างต้องเก็บเสมอ
                $insPrb = "INSERT INTO `wsdl_vib_result` (id_data,ws_result,ws_errcode,ws_errormsg,ws_policyno,ws_barcode,ws_policyurl,ws_entrydate,ws_emp,ws_system) 
                VALUES ('$dataID','$returnResult','$returnErrorCode','$returnErrorMsg','$returnPolicyNo','$returnBarCode','$returnPolicyURL','$_nowDay','$_user','MITSUBISHI')";
                $objUpfinish = PDO_CONNECTION::fourinsure_insured()->prepare($insPrb)->execute();
            };

            if ($returnResult == 'Success') {

                //ถ้าผ่านจะทำการอัพเดทข้อมูล และทำการ create file ไปเก็บไว้ใน pages img_view4
                $sqlupfin = "UPDATE `insuree` SET ws_prb_status = 'Y' WHERE id_data = '$dataID'";
                $objUpfinish = PDO_CONNECTION::fourinsure_insured()->prepare($sqlupfin)->execute();

                $codeact_id = $agcode . '-' . $agYear . $agsaka . '-' . $returnPolicyNo;

                $sqlupfinid = "UPDATE `act` SET act_id = '$codeact_id' ,tmp_act_id = '$returnPolicyNo' ,barcode_id = '$returnBarCode',ws_send_date = '$_nowDay', ws_path_policy = '$returnPolicyURL' WHERE id_data = '$dataID'";

                $objUpfinishid = PDO_CONNECTION::fourinsure_insured()->prepare($sqlupfinid)->execute();

                $fileName = 'img_prb' . $agcode . $agYear . $agsaka . $returnPolicyNo . '.pdf';
                $patch = '../pages/img_view4/' . $fileName;

                //get php อีกที่นึงเพื่อนทำการ create file pdf and save
                if (_PointerDev == false) {
                    file_get_contents(_MainFourinsuredWeb . "/policy/print/print_Act_copy_webservice_download.php?DataID=$dataID&FullPart=$patch");
                }

                $sql = "UPDATE `data` SET img_prb = '$fileName' WHERE id_data = '$dataID'";
                PDO_CONNECTION::fourinsure_insured()->prepare($sql)->execute();

                //ระบบส่ง sms หาลูกค้าทันทีที่มีการออก พ.ร.บ.
                /*$smstext = "พ.ร.บ. ของท่านดำเนินการออกเรียบร้อยแล้ว ดูรายละเอียดคลิก ";

                $linkACT = "https://www.fourinsured.com/pm/o_insuree.php?" . base64_encode(base64_encode("paramsms=../policy/pages/img_view4/" . $fileName));

                $bitlyURL = _PointerDev == true ? false : BitlyLink::getBitlyLink($linkACT, PDO_CONNECTION::fourinsure_insured());

                if ($bitlyURL != false) {
                    $smsText = $smstext . $bitlyURL;

                    $telMain = compareTel((object)$row);

                    if (strlen($telMain) == 10 && $telMain != false) {
                        $blackList = PDO_CONNECTION::my4ib_new()
                            ->query("SELECT bl_data FROM tb_blacklist")
                            ->fetchAll(2);
                        $check = false;
                        foreach ($blackList as $b) {
                            if ($b['bl_data'] == $telMain) {
                                $check = true;
                            }
                        }

                        if ($check) {
                            SendSmsService::SmsHandle($smsText, $telMain);
                            SendSmsService::SmsHandle($smsText, '0830797279');

                            $detail_sms_sql = "INSERT INTO smsdetail (sms_user,sms_text,sms_tel,smsid_data,sms_inv,sms_time,type_work,id_detail_renew) 
					VALUES (:sms_user,:sms_text,:sms_tel,:smsid_data,:sms_inv,:sms_time,:type_work)";

                            $detail_sms_query = $_context4->prepare($detail_sms_sql);
                            $detail_sms_query->execute(
                                array(
                                    'sms_user' => $_SESSION['4User'],
                                    'sms_text' => $smsText,
                                    'sms_tel' => $telMain,
                                    'smsid_data' => $IDDATA,
                                    'sms_inv' => '',
                                    'sms_time' => date('Y-m-d H:i:s'),
                                    'type_work' => 'FOUR'
                                )
                            );
                        }
                    }
                }*/

                //response to controller
                $_res['Status'] = 200;
                $_res['DataId'] = $dataID;
                $_res['PerSonID'] = LoadInformationCustomerFour::loadPerson($dataID);
                $_res['msg'] = "ระบบดำเนินการบันทึกสมบูรณ์แล้ว! ใบแจ้งเลขที่ :$dataID";
                $_res['paramiter'] = $_infomationMap;
                return $_res;
            } else {

                //ถ้าไม่ผ่านต้องเคลียร์ให้ดีลเลอร์รู้เรื่อง และแจ้งเตือนไลน์
                $sqlCommandHis = "UPDATE insuree SET ws_prb_status ='N' WHERE id_data = ?";
                $dataPayLoad = array("$dataID");
                $command = PDO_CONNECTION::fourinsure_insured()->prepare($sqlCommandHis);
                $command->execute($dataPayLoad);

                $_paramPact = array('P_act' => 'ติดต่อเจ้าหน้าที่', 'dataID' => "$dataID");

                // $sql = "UPDATE `data` SET p_act = :P_act WHERE id_data = :dataID";
                // $contextInform->prepare($sql)->execute($_paramPact);

                $sql = "UPDATE act SET act_id = :P_act WHERE id_data = :dataID";
                PDO_CONNECTION::fourinsure_insured()->prepare($sql)->execute($_paramPact);

                $sql = "SELECT CodeDealer FROM `data` WHERE `data`.id_data = '$dataID'";
                $dearler = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetch();

                $infoDearler = LoadInformationCustomerFour::getDealerCodeAndSaka($dearler['CodeDealer']);

                $_messLine = "ดีลเลอร์สาขา $infoDearler[saka] ชื่อ $infoDearler[sub] ไม่สามารถออก Smart พ.ร.บ. ได้ \r\n";
                $_messLine .= "ApiErrorMsg: $returnErrorMsg \r\n";
                $_messLine .= "เลขที่รับแจ้ง $dataID \r\nวัน-เวลา: " . date('Y-m-d H:i:s');

                //$_tokenLine = 'vzxHheVlyquXKllC5RjsnyfXxs6TKSNu6V8IFPXUFxe';//Token LINE ป้ายแดง SUZUKI

                //$_tokenLine = 'mEz09LQIE3XoyCT4G7LUP9HNtJQxRv4y8vsExIhGPAg';//Token LINE ป้ายดำ ออนไลน์  

                $_tokenLine = 'gWkOoNBB5qpnDkD9S5N9TQrwH4NY5aINUqbANknak84'; //Token กลุ่มใหม่ แจ้งเหตุ ป้ายดำ

                //linenotification เข้ากลุ่มแอดมิน
                LineNotificationControl::linenotify($_tokenLine, $_messLine);

                //response to controller
                $_res['Status'] = 200;
                $_res['DataId'] = $dataID;
                $_res['PerSonID'] = LoadInformationCustomerFour::loadPerson($dataID);
                // $_res['msg'] = "ใบแจ้งเลขที่ :$IDDATA ไม่สามารถบันทึกได้ ทางระบบได้คืน เลข เรียบร้อยแล้ว กรุณา ติดต่อ Admin และเปิดหน้านี้ค้างไว้ ห้ามปิด ขอบคุณครับ";
                $_res['msg'] = "ระบบดำเนินการบันทึกสมบูรณ์แล้ว! ใบแจ้งเลขที่ :$dataID";
                $_res['paramiter'] = $_infomationMap;
                return $_res;
            }
        }

        // $responsePostApi = \Httpful\Request::post($url)
        //     ->sendsJson()
        //     ->authenticateWith($username, $password)
        //     ->body(json_encode($_requestApi))
        //     ->send();

        // $_resinfo = ApiMapper::responseApiMapper($responsePostApi);

        //$_responseInfo = SaveResponseApi::saveResponseApiservice($_resinfo, $dataID, $_infomationMap, $_requestApi);
    }
}

class SaveResponseApi
{
    public static function saveResponseApiservice($res, $IDDATA, $apiRequestModel, $params)
    {
        $resultResponse = $res->Result == true ? 'Success' : 'Fail';

        if ($res->Result == true) {
            $sqlCommandHis = "INSERT INTO wsdl_vib_result (id_data, ws_result, ws_errcode, ws_errormsg, ws_policyno, ws_barcode, ws_policyurl, ws_entrydate, ws_emp, ws_system) 
			VALUES (?,?,?,?,?,?,?,?,?,?);";

            date_default_timezone_set("Asia/Bangkok");
            $dateNow = date("Y-m-d H:i:s");
            $numberPrb = explode('-', $res->PolicyNo);

            $dataPayLoad = array(
                "$IDDATA",
                "$resultResponse",
                "$res->ErrorCode",
                "$res->ErrorMsg",
                "$numberPrb[1]",
                "$res->BarcodeNo",
                "$res->PolicyUrl",
                "$dateNow", 'PACK', 'Mitsubishi'
            );

            $command = PDO_CONNECTION::fourinsure_insured()->prepare($sqlCommandHis);
            $command->execute($dataPayLoad);
        } else {
            $sqlCommandHis = "INSERT INTO wsdl_vib_result (id_data, ws_result, ws_errcode, ws_errormsg, ws_policyno, ws_barcode, ws_policyurl, ws_entrydate, ws_emp, ws_system) 
			VALUES (?,?,?,?,?,?,?,?,?,?);";

            date_default_timezone_set("Asia/Bangkok");
            $dateNow = date("Y-m-d H:i:s");
            $numberPrb = explode('/', $res->PolicyNo);

            $dataPayLoad = array(
                "$IDDATA",
                "$resultResponse",
                "$res->ErrorCode",
                "$res->ErrorMsg",
                "$numberPrb[1]",
                "$res->BarcodeNo",
                "$res->PolicyUrl",
                "$dateNow", 'PACK', 'Mitsubishi'
            );

            $command = PDO_CONNECTION::fourinsure_insured()->prepare($sqlCommandHis);
            $command->execute($dataPayLoad);
        }

        if ($res->Result == true) {

            $sqlCommandHis = "UPDATE insuree SET ws_prb_status ='Y' WHERE id_data = ?";
            $dataPayLoad = array("$IDDATA");
            $command = PDO_CONNECTION::fourinsure_insured()->prepare($sqlCommandHis);
            $command->execute($dataPayLoad);

            $sqlCommandHis = "UPDATE act SET act_id = :pAct , tmp_act_id = :policyno, barcode_id = :barcode, ws_path_policy = :policyurl, full_act_id = :full 
            WHERE id_data = :id_data";

            $fullActId = "$apiRequestModel->agcode-$apiRequestModel->agYear$apiRequestModel->agsaka-$numberPrb[1]";
            $dataPayLoad = array(
                'policyno' => "$numberPrb[1]",
                'barcode' => "$res->BarcodeNo",
                'policyurl' => "$res->PolicyUrl",
                'full' => "$fullActId",
                'pAct' => "$fullActId",
                'id_data' => "$IDDATA"
            );
            $command = PDO_CONNECTION::fourinsure_insured()->prepare($sqlCommandHis);
            $command->execute($dataPayLoad);

            // $sqlCommandHis = "UPDATE `data` SET PactOnline = :PACT, p_act = :P_ACT WHERE id_data = :id_data";
            // $dataPayLoad = array('PACT'=>"$fullActId",'id_data'=>"$IDDATA",'P_ACT'=>"-");
            // $command = $contextmy4->prepare($sqlCommandHis);
            // $command->execute($dataPayLoad);

            $_res['Status'] = 200;
            $_res['DataId'] = $IDDATA;
            $_res['PerSonID'] = LoadInformationCustomerFour::loadPerson($IDDATA);
            $_res['msg'] = "ระบบดำเนินการบันทึกสมบูรณ์แล้ว! ใบแจ้งเลขที่ :$IDDATA";
            $_res['paramiter'] = $params;
            return $_res;
        } else {
            $sqlCommandHis = "UPDATE insuree SET ws_prb_status ='N' WHERE id_data = ?";
            $dataPayLoad = array("$IDDATA");
            $command = PDO_CONNECTION::fourinsure_insured()->prepare($sqlCommandHis);
            $command->execute($dataPayLoad);

            $_paramPact = array('P_act' => 'ติดต่อเจ้าหน้าที่', 'dataID' => "$IDDATA");

            // $sql = "UPDATE `data` SET p_act = :P_act WHERE id_data = :dataID";
            // $contextInform->prepare($sql)->execute($_paramPact);

            $sql = "UPDATE act SET act_id = :P_act WHERE id_data = :dataID";
            PDO_CONNECTION::fourinsure_insured()->prepare($sql)->execute($_paramPact);

            $sql = "SELECT CodeDealer FROM `data` WHERE `data`.id_data = '$IDDATA'";
            $dearler = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetch();

            $infoDearler = LoadInformationCustomerFour::getDealerCodeAndSaka($dearler['CodeDealer']);

            $_messLine = "ดีลเลอร์สาขา $infoDearler[saka] ชื่อ $infoDearler[sub] ไม่สามารถออก Smart พ.ร.บ. ได้ \r\n";
            $_messLine .= "ApiErrorMsg: $res->ErrorMsg \r\n";
            $_messLine .= "เลขที่รับแจ้ง $IDDATA \r\nวัน-เวลา: " . date('Y-m-d H:i:s');

            //$_tokenLine = 'vzxHheVlyquXKllC5RjsnyfXxs6TKSNu6V8IFPXUFxe';//Token LINE ป้ายแดง SUZUKI

            //$_tokenLine = 'mEz09LQIE3XoyCT4G7LUP9HNtJQxRv4y8vsExIhGPAg';//Token LINE ป้ายดำ ออนไลน์  

            $_tokenLine = 'gWkOoNBB5qpnDkD9S5N9TQrwH4NY5aINUqbANknak84'; //Token กลุ่มใหม่ แจ้งเหตุ ป้ายดำ

            LineNotificationControl::linenotify($_tokenLine, $_messLine);

            $_res['Status'] = 200;
            $_res['DataId'] = $IDDATA;
            $_res['PerSonID'] = LoadInformationCustomerFour::loadPerson($IDDATA);
            // $_res['msg'] = "ใบแจ้งเลขที่ :$IDDATA ไม่สามารถบันทึกได้ ทางระบบได้คืน เลข เรียบร้อยแล้ว กรุณา ติดต่อ Admin และเปิดหน้านี้ค้างไว้ ห้ามปิด ขอบคุณครับ";
            $_res['msg'] = "ระบบดำเนินการบันทึกสมบูรณ์แล้ว! ใบแจ้งเลขที่ :$IDDATA";
            $_res['paramiter'] = $params;
            return $_res;
        }
    }
}

class LoadInformationCustomerFour
{
    public static function loadPerson($dataID)
    {
        $sql = "SELECT person FROM insuree WHERE id_data = '$dataID'";
        $_perInfo = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetch();
        return $_perInfo['person'];
    }

    public static function loadPersonMitsu($dataID)
    {
        $sql = "SELECT person FROM insuree WHERE id_data = '$dataID'";
        return PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetch(7);
    }

    public static function loadinfo($dataID)
    {
        $sql = "SELECT act.*,
        `data`.id_data as dataID, 
        `data`.send_date,
        `data`.`start_date`,
        `data`.end_date,
        `data`.CodeDealer,
        insuree.person,
        insuree.icard, 
        insuree.id_business, 
        insuree.name,
        insuree.last,
        insuree.sex,
        insuree.add,
        insuree.group,
        insuree.town,
        insuree.lane,
        insuree.road,
        insuree.tumbon,
        insuree.amphur,
        insuree.province,
        insuree.postal, 
        detail.car_regis,
        detail.car_regis_pro, 
        detail.car_body,
        detail.n_motor,
        detail.car_seat,
        detail.car_wg,
        detail.cc,
        detail.regis_date,
        detail.car_id, 
        tb_br_car.name as car_brand,
        tb_mo_car.name as mo_car_name,
        tb_titlename.id_prename 
        FROM act LEFT JOIN `data` ON (`data`.id_data = act.id_data) 
        LEFT JOIN detail ON (detail.id_data = `data`.id_data) 
        LEFT JOIN insuree ON (insuree.id_data = detail.id_data) 
        LEFT JOIN tb_br_car ON (tb_br_car.id = detail.br_car) 
        LEFT JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) 
        LEFT JOIN tb_titlename ON (tb_titlename.prename = insuree.title)   
        WHERE act.id_data = '$dataID'";
        $info = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetch();
        return $info;
    }

    public static function getInfoCustomerFourById($id)
    {
        $query = "SELECT ";
        $query .= "data.id,";
        $query .= "data.doc_type,";
        $query .= "data.login, "; // รหัสผู้แจ้ง
        $query .= "data.service, "; // ประเภทการซ่อม
        $query .= "data.list_customer1, ";
        $query .= "data.list_customer2, ";
        $query .= "data.list_customer3, ";
        $query .= "data.list_customer4, ";
        $query .= "data.list_customer5, ";
        $query .= "data.pay_date, ";
        $query .= "data.list_customer, ";

        $query .= "tb_user.sub as branch, "; // สาขา
        $query .= "tb_user.contact, "; // ชื่อผู้แจ้ง
        $query .= "tb_user.cus_add, "; // บ้านเลขที่
        $query .= "tb_user.cus_group, "; // หมู่
        $query .= "tb_user.cus_town, "; //อาคาร/หมู่บ้าน
        $query .= "tb_user.cus_lane, "; // ซอย
        $query .= "tb_user.cus_road, "; // ถนน
        $query .= "tb_user.cus_tumbon, "; // ตำบล คีย์
        $query .= "tb_user.cus_amphur, "; // อำเภอ คีย์
        $query .= "tb_user.cus_province, "; // จังหวัด คีย์
        $query .= "tb_user.cus_postal , "; // รหัสไปรษณีย์

        $query .= "data.send_date,   "; // วันที่แจ้ง
        $query .= "data.name_inform, "; // รหัสผู้แจ้ง
        $query .= "data.id_data, "; // เลขที่รับแจ้ง
        $query .= "data.o_insure, "; // เลขที่กรมธรรมเดิม
        $query .= "data.ty_inform, "; // ประเภทงาน
        $query .= "data.idagent, "; //รหัสตัวแทน
        $query .= "data.start_date, "; // วันที่คุ้มครอง	
        $query .= "data.end_date, "; // วันที่สิ้นสุด
        $query .= "data.name_gain, "; // ชื่อผู้รับผลประโยชน์
        $query .= "data.q_auto, ";
        $query .= "data.user_up1, ";

        $query .= "insuree.person , ";
        $query .= "insuree.title, "; // คำนำหน้า ชื่อผู้เอาประกัน
        $query .= "insuree.name,  "; // ชื่อผู้เอาประกัน
        $query .= "insuree.last, "; // นามสกุลผู้เอาประกัน
        $query .= "insuree.career, "; // นามสกุลผู้เอาประกัน
        $query .= "insuree.add, "; // บ้านเลขที่
        $query .= "insuree.icard, ";
        $query .= "insuree.id_business, ";
        $query .= "insuree.SendAdd, ";
        $query .= "insuree.group, "; // หมู่
        $query .= "insuree.town, "; //อาคาร/หมู่บ้าน
        $query .= "insuree.lane, "; // ซอย
        $query .= "insuree.road, "; // ถนน
        $query .= "insuree.tumbon, "; // ตำบล คีย์
        $query .= "insuree.amphur, "; // อำเภอ คีย์
        $query .= "insuree.province, "; // จังหวัด คีย์
        $query .= "insuree.tel_main, ";
        $query .= "insuree.postal, "; // รหัสไปรษณีย์
        $query .= "insuree.tel_mobile, "; // เบอร์โทร
        $query .= "insuree.tel_mobile2, "; // เบอร์โทร	
        $query .= "insuree.tel_home, "; // เบอร์โทร
        $query .= "insuree.tel_fax, "; // เบอร์โทร
        $query .= "insuree.email, "; // Email
        $query .= "insuree.email_cc, "; // Email_cc
        $query .= "insuree.status_vip, ";
        $query .= "insuree.paytype, ";
        $query .= "insuree.status_insured_time, ";
        $query .= "insuree.status_company_time, ";
        $query .= "insuree.edit_insured_time, ";
        $query .= "insuree.edit_data_time, ";
        $query .= "insuree.edit_data_ch, ";
        $query .= "insuree.sex as inssex , ";
        $query .= "tb_tumbon.name as tumbon_name, ";
        $query .= "tb_amphur.name as amphur_name, ";
        $query .= "tb_province.name as province_name, "; // จังหวัด
        $query .= "tb_province.province_code_oic, ";

        $query .= "tb_br_car.name as car_brand, "; // ยี่ห้อรถ
        $query .= "tb_cat_car.name as cat_car_name, "; // ประเภทรถ
        $query .= "tb_mo_car.name as mo_car_name, "; // รุ่นรถ  
        $query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
        $query .= "detail.car_color, "; // สีรถ
        $query .= "detail.cc, "; // ซี ซ
        $query .= "detail.car_wg, "; // น.น.
        $query .= "detail.car_regis, "; // ทะเบียนรถ
        $query .= "detail.car_regis_pro, "; // ทะเบียนรถ
        $query .= "detail.car_body, "; // เลขตัวถัง
        $query .= "detail.regis_date, "; // ปีที่จดทะเบียน
        $query .= "detail.car_seat, "; // 
        $query .= "detail.n_motor, "; // เลขเครื่อง
        $query .= "detail.Cancel_policy, ";
        $query .= "detail.Cancel_policy2, ";
        $query .= "detail.id_data_company, ";
        $query .= "detail.status_policy_time, ";

        $query .= "premium.id, ";
        $query .= "premium.id_data, ";
        $query .= "premium.pre, "; // เบี้ยสุทธิ
        $query .= "premium.one, "; // ส่วนแรก
        $query .= "premium.driver, "; // ส่วนลดระบุผู้ขับขี่
        $query .= "premium.dis1, "; // ส่วนลดระบุผู้ขับขี่
        $query .= "premium.good, "; // ส่วนลดประวัติดี
        $query .= "premium.dis2, "; // ส่วนลดระบุผู้ขับขี่
        $query .= "premium.group3, "; // ส่วนลดประวัติดี
        $query .= "premium.dis_group3, "; // ส่วนลดประวัติดี
        $query .= "premium.pro_dis, "; // ส่วนลดพิเศษ
        $query .= "premium.total_pro_dis, "; // ส่วนลดพิเศษ
        $query .= "premium.total_pre, "; // เบี้ยสิทธิ หักส่วนลด
        $query .= "premium.total_stamp, "; // รวม อากร
        $query .= "premium.total_vat, "; // รวม ภาษี
        $query .= "premium.prb_net, ";
        $query .= "premium.prb_stamp, ";
        $query .= "premium.prb_tax, ";
        $query .= "premium.prb, "; // เบี้ย พ.ร.บ.
        $query .= "premium.total_prb, "; // เบี้ยรวม พ.ร.บ.
        $query .= "premium.total_sum, "; // เบี้ยรวม
        $query .= "premium.other, "; // เบี้ยรวม
        $query .= "premium.vat_1, "; // หัก ณ ที่จ่าย
        $query .= "premium.tax1prb, ";
        $query .= "premium.commition, "; // ส่วนลดเป็นบาท
        $query .= "premium.total_commition, "; // ยอดชำระ

        $query .= "premium.pre_old, ";
        $query .= "premium.one_old, ";
        $query .= "premium.disone_old, ";
        $query .= "premium.driver_old, ";
        $query .= "premium.dis1_old, ";
        $query .= "premium.good_old, ";
        $query .= "premium.dis2_old, ";
        $query .= "premium.group3_old, ";
        $query .= "premium.dis_group3_old, ";
        $query .= "premium.pro_dis_old, ";
        $query .= "premium.total_pro_dis_old, ";
        $query .= "premium.dis3_old, ";
        $query .= "premium.dis_vip_old, ";
        $query .= "premium.total_vip_old, ";
        $query .= "premium.total_dis4_old, ";
        $query .= "premium.total_pre_old, ";
        $query .= "premium.total_stamp_old, ";
        $query .= "premium.total_vat_old, ";
        $query .= "premium.total_sum_old, ";
        $query .= "premium.prb_old, ";
        $query .= "premium.total_prb_old, ";
        $query .= "premium.commition_old, ";
        $query .= "premium.other_old, ";
        $query .= "premium.vat_1_old, ";
        $query .= "premium.tax1prb_old, ";
        $query .= "premium.total_commition_old, ";
        $query .= "premium.editing, ";

        $query .= "protect.id, ";
        $query .= "protect.cost, "; // ยอดชำระ
        $query .= "protect.damage_out1, ";
        $query .= "protect.damage_cost, ";
        $query .= "protect.pa1, ";
        $query .= "protect.pa2, ";
        $query .= "protect.pa3, ";
        $query .= "protect.pa4, ";
        $query .= "protect.people, ";

        $query .= "protect.cost_old, "; // ยอดชำระ
        $query .= "protect.damage_out1_old, ";
        $query .= "protect.damage_cost_old, ";
        $query .= "protect.pa1_old, ";
        $query .= "protect.pa2_old, ";
        $query .= "protect.pa3_old, ";
        $query .= "protect.pa4_old, ";
        $query .= "protect.people_old, ";

        $query .= "tb_agent.id_agent, ";
        $query .= "tb_agent.full_name, ";
        $query .= "tb_agent.agent_dis, ";
        $query .= "tb_agent.agent_group, ";

        //กรณีระบุชื่อผู้ขับขี่
        $query .= "driver.title_num1, "; // ผู้ขับขี่ที่ 1
        $query .= "driver.name_num1, ";
        $query .= "driver.last_num1, ";
        $query .= "driver.birth_num1, "; // วัน/เดือน/ปี (วันเกิด)
        $query .= "driver.title_num2, "; // ผู้ขับขี่ที่ 2
        $query .= "driver.name_num2, ";
        $query .= "driver.last_num2, ";
        $query .= "driver.birth_num2, "; // วัน/เดือน/ปี (วันเกิด)

        $query .= "act.act_id, ";
        $query .= "act.p_id, ";
        $query .= "act.act_sort, ";
        $query .= "act.tmp_act_id, ";
        $query .= "act.barcode_id, ";
        $query .= "act.prb_start_date, ";
        $query .= "act.prb_end_date, ";

        $query .= "tb_user.title_sub,";
        $query .= "tb_user.sub,";
        $query .= "tb_user.Email,";
        $query .= "tb_user.Email2,";
        $query .= "tb_user.Email3,";
        $query .= "tb_user.Email4,";
        $query .= "tb_user.Email5 ";

        $query .= "FROM data ";
        $query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
        $query .= "INNER JOIN driver ON (driver.id_data = data.id_data)  ";
        $query .= "INNER JOIN service ON (data.id_data = service.id_data) ";
        $query .= "INNER JOIN premium ON (data.id_data = premium.id_data) ";
        $query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
        $query .= "INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
        $query .= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
        $query .= "INNER JOIN act ON (act.id_data = data.id_data)  ";
        $query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
        $query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
        $query .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
        $query .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
        $query .= "INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
        $query .= "INNER JOIN tb_province ON (tb_province.id = insuree.province) ";
        $query .= "INNER JOIN tb_user ON (tb_user.user = data.name_inform) ";
        $query .= "INNER JOIN  tb_agent ON (tb_agent.id_agent = data.idagent) ";
        $query .= "WHERE data.id_data = '$id'";

        $result = PDO_CONNECTION::fourinsure_insured()
            ->query($query)
            ->fetch(2);
        return $result;
    }

    public static function getActByBase4($vTypeCode)
    {
        $_sql = "SELECT * FROM tb_act WHERE tb_act.ActApiTypeCode = '$vTypeCode'";
        $_infoAct = PDO_CONNECTION::fourinsure_insured()->query($_sql)->fetch();
        return $_infoAct;
    }

    public static function getDealerCodeAndSaka($delerCode)
    {
        $info = PDO_CONNECTION::fourinsure_mitsu()->query("SELECT Dealer_code , saka , sub FROM tb_customer WHERE user = '$delerCode'")->fetch();
        return $info;
    }

    public static function getProvince($province)
    {
        $_info = PDO_CONNECTION::fourinsure_insured()->query("SELECT province_code_oic FROM tb_province WHERE id = $province")->fetch(2);
        return $_info['province_code_oic'];
    }

    public static function getTumbon($idTumbon)
    {
        $_info = PDO_CONNECTION::fourinsure_insured()->query("SELECT `name` FROM tb_tumbon WHERE id = $idTumbon")->fetch(2);
        return $_info['name'];
    }

    public static function getAmPhur($idAmphur)
    {
        $_info = PDO_CONNECTION::fourinsure_insured()->query("SELECT `name` FROM tb_amphur WHERE id = $idAmphur")->fetch(2);
        return $_info['name'];
    }

    public static function getBranCar($id)
    {
        $sql = "SELECT `name` FROM tb_br_car WHERE id = '$id'";
        return PDO_CONNECTION::fourinsure_insured()->query($sql)->fetch(7);
    }

    public static function getModelCar($id)
    {
        $sql = "SELECT `name` FROM tb_mo_car WHERE id = '$id'";
        return PDO_CONNECTION::fourinsure_insured()->query($sql)->fetch(7);
    }
}


class ApiMapper
{
    public static function responseApiMapper($resValue)
    {
        $_value = new ActApiResponseModel();
        $_value->Result = $resValue->body->result;
        $_value->ErrorCode = $resValue->body->errorCode;
        $_value->ErrorMsg = $resValue->body->errorMsg;
        $_value->PolicyNo = $resValue->body->policyNo;
        $_value->PolicyUrl = $resValue->body->policyUrl;
        $_value->BarcodeNo = $resValue->body->barcodeNo;

        return $_value;
    }

    public static function requestApiModel($apiRequestModel)
    {
        $params = array(
            'status' => "{$apiRequestModel->Status}",
            'agentCode' => "{$apiRequestModel->agcode}",
            'transactionID' => "{$apiRequestModel->TransactionId}",
            'saleName' => "{$apiRequestModel->SaleName}",
            'appSignDate' => "{$apiRequestModel->AppSignDate}",
            'effectiveDate' => "{$apiRequestModel->EffectiveDate}",
            'expiredDate' => "{$apiRequestModel->ExpiredDate}",
            'insuredcardType' => "{$apiRequestModel->CardType}",
            'insuredcardNo' => "{$apiRequestModel->CardNo}",
            'insuredType' => "{$apiRequestModel->InsuredType}",
            'insuredTitleName' => "{$apiRequestModel->InsuredTitleName}",
            'insuredName' => "{$apiRequestModel->InsuredName}",
            'insuredLastName' => "{$apiRequestModel->InsuredLastName}",
            'insuredCorporateName' => "{$apiRequestModel->InsuredCorporateName}",
            'insuredHeadOffice' => "{$apiRequestModel->InsuredHeadOffice}",
            'insuredBranchCode' => "{$apiRequestModel->InsuredBranchCode}",
            'insuredGender' => "{$apiRequestModel->Gender}",
            'insuredBirthDate' => "{$apiRequestModel->BirthDate}",
            'insuredTelephone' => "{$apiRequestModel->Telephone}",
            'insuredMobileNo' => "{$apiRequestModel->MobileNo}",
            'insuredHomeNo' => "{$apiRequestModel->HomeNo}",
            'insuredBuilding' => "{$apiRequestModel->Building}",
            'insuredMoo' => "{$apiRequestModel->Group}",
            'insuredTrok' => "{$apiRequestModel->Trok}",
            'insuredSoi' => "{$apiRequestModel->Soi}",
            'insuredRoad' => "{$apiRequestModel->Road}",
            'insuredTambol' => "{$apiRequestModel->Tambol}",
            'insuredAmphur' => "{$apiRequestModel->Amphur}",
            'insuredProvince' => "{$apiRequestModel->Province}",
            'insuredPostcode' => "{$apiRequestModel->Postcode}",
            'licensePlateType' => "{$apiRequestModel->LicenseNo}",
            'licensePlateNo' => "{$apiRequestModel->LicensePlateNo}",
            'licenseProvince' => "{$apiRequestModel->LicenseProvince}",
            'chassisNo' => "{$apiRequestModel->Chassis}",
            'engineNo' => "{$apiRequestModel->Engine}",
            'vehicleType' => "{$apiRequestModel->VehicleType}",
            'carBrand' => "{$apiRequestModel->VehicleMake}",
            'carModel' => "{$apiRequestModel->VehicleModel}",
            'vehicleRegYear' => "{$apiRequestModel->VehicleRegYear}",
            'seat' => "{$apiRequestModel->Seat}",
            'cc' => "{$apiRequestModel->CC}",
            'weight' => "{$apiRequestModel->VehicleWeight}",
            'premium' => "{$apiRequestModel->NetPremium}",
            'discount' => "{$apiRequestModel->Discount}",
            'netPremium' => "{$apiRequestModel->NetPremium}",
            'vat' => "{$apiRequestModel->Vat}",
            'stamp' => "{$apiRequestModel->Stamp}",
            'grossPremium' => "{$apiRequestModel->GrossPremium}",
            'flagOnline' => "{$apiRequestModel->FlagOnline}",
            'emailCustomer' => "{$apiRequestModel->email_customer}",
            'emailAgent' => "{$apiRequestModel->email_agent}",
            'onlinePaymentNo' => "{$apiRequestModel->OnlinePayment_no}",
            'onlinePaymentAmout' => "{$apiRequestModel->OnlinePayment_amt}",
            'onlinemerchantID' => "{$apiRequestModel->onlinemerchant_id}",
            'dealerCode' => "{$apiRequestModel->DelarCode}"
        );
        return $params;
    }

    public static function loadProvinceCar($carRegPro)
    {
        $sqlprovcar = "SELECT  province_code_oic  FROM tb_province Where id = '$carRegPro'";

        return PDO_CONNECTION::fourinsure_insured()->query($sqlprovcar)->fetch();
    }

    public static function ws_datetime($dt)
    {
        list($date, $time) = explode(' ', $dt); // แยกวันที่ กับ เวลาออกจากกัน
        list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
        list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
        $Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.

        switch ($m) {
            case "01":
                $m = "01";
                break;
            case "02":
                $m = "02";
                break;
            case "03":
                $m = "03";
                break;
            case "04":
                $m = "04";
                break;
            case "05":
                $m = "05";
                break;
            case "06":
                $m = "06";
                break;
            case "07":
                $m = "07";
                break;
            case "08":
                $m = "08";
                break;
            case "09":
                $m = "09";
                break;
            case "10":
                $m = "10";
                break;
            case "11":
                $m = "11";
                break;
            case "12":
                $m = "12";
                break;
        }
        // return $Y . "-" . $m . "-" . $d;
        return $Y . $m . $d . ' ' . $H . '.' . $i;  //20181001 08.30
    }

    public static function ws_date($dt)
    {
        list($date, $time) = explode(' ', $dt); // แยกวันที่ กับ เวลาออกจากกัน
        list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
        list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
        $Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.

        switch ($m) {
            case "01":
                $m = "01";
                break;
            case "02":
                $m = "02";
                break;
            case "03":
                $m = "03";
                break;
            case "04":
                $m = "04";
                break;
            case "05":
                $m = "05";
                break;
            case "06":
                $m = "06";
                break;
            case "07":
                $m = "07";
                break;
            case "08":
                $m = "08";
                break;
            case "09":
                $m = "09";
                break;
            case "10":
                $m = "10";
                break;
            case "11":
                $m = "11";
                break;
            case "12":
                $m = "12";
                break;
        }
        // return $Y . "-" . $m . "-" . $d;
        return $Y . $m . $d;  //20181001
    }

    public static function requestMapperApi08829($row, $dataID)
    {
        $SaleName = "สาริตา นิยมไทย";
        $AppSignDate = self::ws_datetime($row['send_date']); //"20181001 08.30";

        if ($row['prb_start_date'] == '' || $row['prb_start_date'] == '0000-00-00') 
        {
            $EffectiveDate = self::ws_date($row['start_date']); //"20181001";
            $ExpiredDate = self::ws_date($row['end_date']); //"20191001";

        } else {
            $EffectiveDate = self::ws_date($row['prb_start_date']); //"20181001";
            $ExpiredDate = self::ws_date($row['prb_end_date']); //"20191001";
        }

        $PolicyNo = $row['tmp_act_id'];  // policy prb
        $Barcode  = $row['barcode_id'];
        $CardType  = '';
        $InsuredType = '';
        $CardNo = '';
        $InsuredBranchCode = ""; //12รหัสสาขาของผู้เอาประกัน

        if ($row['person'] == '1') {
            $CardType  = "C";
            $InsuredType = "P";
            $CardNo = $row['icard'];
        
        } else if ($row['person'] == '2' || $row['person'] == '3') {
            $CardType  = "L";
            $InsuredType = "C";
            $CardNo = $row['id_business'];
            $InsuredBranchCode = "00000";
        }  //11 P บุคคล C นิติ

        $InsuredTitleName = $row['title']; //"คุณ"; //13คำนำหน้าชื่อ 
        $InsuredName =  $row['name']; //"ทดสอบ"; //14ชื่อผู้เอาประกัน
        $InsuredLastName = $row['last']; //"เว็บเซอร์วิส"; //15นามสกุลผูเอาประกัน
        if ($row['inssex'] != '') {
            $Gender = $row['inssex'];     //16เพศ M F

        }
        else 
        {
            $Gender = "M"; //16เพศ M F
        }

        $BirthDate = ''; //"19841019"; //17วันเกิด 
        $Telephone = '';  //18เบอร์โทร
        $MobileNo = '';  //19มือถือ
        $HomeNo = trim($row['add']);  //20เบอร์บ้าน
        $Building = "";  //21ตึก
        $Moo = trim($row['group']); //22หมู่ที่
        $Moobarn = trim($row['town']); //23หมู่บ้าน
        $RoomNo = ""; //24เบอร์ห้อง
        $Trok = "";  //25ตรอก
        $Soi = trim($row['lane']);  //26ซอย
        $Road = trim($row['road']);  //27ถนน
        $Tambol = $row['tumbon_name'];  //28ตำบล
        $Amphur = $row['amphur_name'];  //29อำเภอ
        $Postcode = $row['postal']; //"12140";  //30รหัสไปรษณีย์
        $Province = $row['province_code_oic'];  //31จังหวัด
        $LicenseNo = trim($row['car_regis']); //"กม1234";  //32ทะเบียนรถ

        $rowCar = self::loadProvinceCar($row['car_regis_pro']);
        $LicenseProvince = $rowCar['province_code_oic'];  //33จดทะเบียนจังหวัด

        $Chassis = $row['car_body']; //"MTH09PU5M7107258";  //34เลขถัง
        $Engine =   $row['n_motor']; // "B20B3WP11644";  //35เลขเครื่อง


        /****************************************************************************************************************** */
        //ตัดประเภทรถให้เข้ากับโค๊ด API ในงาน backoffice ต้องใช้
        // $tp_id = $row['p_id'];
        // $countp_id = strlen($tp_id);
        // $p_id1 = substr($tp_id, 0, 1);
        // $p_id2 = substr($tp_id, 1, $countp_id);

        //$VehicleType =  $p_id1 . '.' . $p_id2; //$row['n_motor']; //"1.10";//36ประเภทรถ1.30 car_brand  mo_car_name
        /****************************************************************************************************************** */

        $VehicleType = $row['p_id'];
        $VehicleMake = $row['car_brand']; //$row['n_motor']; //"HONDA";  //37ยี่ห้อรถ
        $VehicleModel = $row['mo_car_name']; //$row['n_motor']; //"Accord";  //38รุ่นรถ
        /********************************************************* */

        $VehicleRegYear = $row['regis_date']; //"2012"; //39ปีที่จดทะเบียน
        $Seat =  $row['car_seat'];  //40จำนวนที่นั่ง
        $CC =  $row['cc'];  //41ซีซี

        if ($row['car_wg'] == '' || $row['car_wg'] == '-') {
            $VehicleWeight =  0;   //42น้ำหนัก
        } else {
            $countwg = strlen($row['car_wg']);
            if ($countwg == 4) {
                $VehicleWeight =   round($row['car_wg'] / 1000, 0);   //42น้ำหนัก
            } else {
                $VehicleWeight =   $row['car_wg'];   //42น้ำหนัก
            }
        }

        $tcar_id = $row['car_id'];
        $pcarid = substr($tcar_id, 0, 1);

        if ($pcarid == '3') {
            $VehicleCarid = "C";  //43การใช้รถ P=บุคคล C = พาณิชย์
        } else if ($pcarid == '2') {
            $VehicleCarid = "C";
        } else {
            $VehicleCarid = "P";
        }

        $VehicleUseCode = $VehicleCarid;  //43การใช้รถ P=บุคคล C = พาณิชย์
        $NetPremium = str_replace(',', '', $row['prb_net']);  //44สุทธิ
        $Vat =  str_replace(',', '', $row['prb_tax']);  //45ภาษี
        $Stamp = str_replace(',', '', $row['prb_stamp']);  //46อากร
        $GrossPremium = str_replace(',', '', $row['prb']);  //47เบี้ยรวม

        $OnlinePayment_amt = "0.00";  //48จำวนการจ่ายเงิน
        $OnlinePayment_no = "";  //49เลขที่การจ่ายเงิน
        $isOnline = "N";  //50Yonline N offline
        $email_customer = "";  //51อีเมล์ลูกค้า
        $email_agent = "";  //52อีเมล์ตัวแทน
        $onlinemerchant_id = "";
        $agcode = "08829";
        $nowYear =  date('Y') + 543;
        $agYear = substr($nowYear, 2);
        $agsaka = "113";

        $params = array(
            'Username' => _ActUser,  //WS08829  //Tuser1 
            'Password' => _ActPass,  //9y;cmovib113  //daif1928
            'tcspolicy' => array(
                'AgentCode' => "{$agcode}", //08829  //99999
                'ApplicationNo' => "$dataID", //2รหัสอ้างอิง
                'SaleName' => "{$SaleName}", //3ผู้แจ้งงาน
                'AppSignDate' => "{$AppSignDate}", //4วันที่แจ้งงาน
                'EffectiveDate' => "{$EffectiveDate}", //5วันเริ่มคุ้มครอง
                'ExpiredDate' => "{$ExpiredDate}", //6สิ้นสุดวันคุ้มครอง
                'PolicyNo' => "{$PolicyNo}",  //7เลขที่ กธ
                'Barcode' => "{$Barcode}", //8บาร์โค้ด
                'CardType' => "{$CardType}", //9ประเภทบัตร P C L A Z
                'CardNo' => "{$CardNo}", //10หมายเลขบัตร
                'InsuredType' => "{$InsuredType}", //11P บุคคล C นิติ
                'InsuredBranchCode' => "{$InsuredBranchCode}", //12รหัสสาขาของผู้เอาประกัน
                'InsuredTitleName' => "{$InsuredTitleName}", //13คำนำหน้าชื่อ
                'InsuredName' => "{$InsuredName}", //14ชื่อผู้เอาประกัน
                'InsuredLastName' => "{$InsuredLastName}", //15นามสกุลผูเอาประกัน
                'Gender' => "{$Gender}", //16เพศ M F
                'BirthDate' => "{$BirthDate}", //17วันเกิด
                'Telephone' => "{$Telephone}",  //18เบอร์โทร
                'MobileNo' => "{$MobileNo}",  //19มือถือ
                'HomeNo' => "{$HomeNo}",  //20เบอร์บ้าน
                'Building' => "{$Building}",  //21ตึก
                'Moo' => "{$Moo}", //22หมู่ที่
                'Moobarn' => "{$Moobarn}", //23หมู่บ้าน
                'RoomNo' => "{$RoomNo}", //24เบอร์ห้อง
                'Trok' => "{$Trok}",  //25ตรอก
                'Soi' => "{$Soi}",  //26ซอย
                'Road' => "{$Road}",  //27ถนน
                'Tambol' => "{$Tambol}",  //28ตำบล
                'Amphur' => "{$Amphur}",  //29อำเภอ
                'Postcode' => "{$Postcode}",  //30รหัสไปรษณีย์
                'Province' => "{$Province}",  //31จังหวัด
                'LicenseNo' => "{$LicenseNo}",  //32ทะเบียนรถ
                'LicenseProvince' => "{$LicenseProvince}",  //33จดทะเบียนจังหวัด
                'Chassis' => "{$Chassis}",  //34เลขถัง
                'Engine' => "{$Engine}",  //35เลขเครื่อง
                'VehicleType' => "{$VehicleType}", //36ประเภทรถ1.30
                'VehicleMake' => "{$VehicleMake}",  //37ยี่ห้อรถ
                'VehicleModel' => "{$VehicleModel}",  //38รุ่นรถ
                'VehicleRegYear' => "{$VehicleRegYear}", //39ปีที่จดทะเบียน
                'Seat' => "{$Seat}",  //40จำนวนที่นั่ง
                'CC' => "{$CC}",  //41ซีซี
                'VehicleWeight' => "{$VehicleWeight}",  //42น้ำหนัก
                'VehicleUseCode' => "{$VehicleUseCode}",  //43การใช้รถ
                'NetPremium' => "{$NetPremium}",  //44สุทธิ
                'Vat' => "{$Vat}",  //45ภาษี
                'Stamp' => "{$Stamp}",  //46อากร
                'GrossPremium' => "{$GrossPremium}"
            )
        );
        return $params;
    }

    public static function reqMitsuMapApi($row, $dataID)
    {
        $SaleName = "สาริตา นิยมไทย";
        $AppSignDate = self::ws_datetime($row['send_date']); //"20181001 08.30";

        if ($row['prb_start_date'] == '' || $row['prb_start_date'] == '0000-00-00') {
            $EffectiveDate = self::ws_date($row['start_date']); //"20181001";
            $ExpiredDate = self::ws_date($row['end_date']); //"20191001";
        } else {
            $EffectiveDate = self::ws_date($row['prb_start_date']); //"20181001";
            $ExpiredDate = self::ws_date($row['prb_end_date']); //"20191001";
        }

        $PolicyNo = $row['tmp_act_id'];  // policy prb
        $Barcode  = $row['barcode_id'];
        $CardType  = '';
        $InsuredType = '';
        $CardNo = '';
        $InsuredBranchCode = ""; //12รหัสสาขาของผู้เอาประกัน

        if ($row['person'] == '1') {
            $CardType  = "C";
            $InsuredType = "P";
            $CardNo = $row['icard'];
        } else if ($row['person'] == '2' || $row['person'] == '3') {
            $CardType  = "L";
            $InsuredType = "C";
            $CardNo = $row['id_business'];
            $InsuredBranchCode = "00000";
        }  //11 P บุคคล C นิติ

        $InsuredTitleName = trim($row['title']); //"คุณ"; //13คำนำหน้าชื่อ 
        $InsuredName =  trim($row['name']); //"ทดสอบ"; //14ชื่อผู้เอาประกัน
        $InsuredLastName = trim($row['last']); //"เว็บเซอร์วิส"; //15นามสกุลผูเอาประกัน

        $Gender = $row['inssex']!=''?$row['inssex']:'M';//16 เพศ M F
        
        $BirthDate = ''; //"19841019"; //17วันเกิด /* ไม่ใส่ไป *
        $Telephone = '';  //18เบอร์โทร             *        *
        $MobileNo = '';  //19มือถือ                **********
        $HomeNo = trim($row['add']);  //20บ้านเลขที่
        $Building = "";  //21ตึก
        $Moo = trim($row['group']); //22หมู่ที่
        $Moobarn = trim($row['town']); //23หมู่บ้าน
        $RoomNo = ""; //24เบอร์ห้อง
        $Trok = "";  //25ตรอก
        $Soi = trim($row['lane']);  //26ซอย
        $Road = trim($row['road']);  //27ถนน

        $Tambol = LoadInformationCustomerFour::getTumbon($row['tumbon']);  //28ตำบล
        $Amphur = LoadInformationCustomerFour::getAmPhur($row['amphur']);  //29อำเภอ
        $Postcode = $row['postal']; //"12140";  //30รหัสไปรษณีย์
        $Province = LoadInformationCustomerFour::getProvince($row['province']); //31จังหวัด

        $LicenseNo = trim($row['car_regis']); //"กม1234";  //32ทะเบียนรถ

        $rowCar = self::loadProvinceCar($row['car_regis_pro']);

        $LicenseProvince = $rowCar['province_code_oic'];  //33จดทะเบียนจังหวัด

        $Chassis = $row['car_body']; //34เลขถัง
        $Engine =   $row['n_motor']; //35เลขเครื่อง

        /****************************************************************************************************************** */
        //ตัดประเภทรถให้เข้ากับโค๊ด API ในงาน backoffice ต้องใช้
        // $tp_id = $row['p_id'];
        // $countp_id = strlen($tp_id);
        // $p_id1 = substr($tp_id, 0, 1);
        // $p_id2 = substr($tp_id, 1, $countp_id);

        //$VehicleType =  $p_id1 . '.' . $p_id2; //$row['n_motor']; //"1.10";//36ประเภทรถ1.30 car_brand  mo_car_name
        /****************************************************************************************************************** */

        $VehicleType = $row['p_id'];
        $VehicleMake = LoadInformationCustomerFour::getBranCar($row['br_car']); //37ยี่ห้อรถ
        $VehicleModel = LoadInformationCustomerFour::getModelCar($row['mo_car']);//38รุ่นรถ

        /********************************************************* */

        $VehicleRegYear = $row['regis_date']; //39ปีที่จดทะเบียน
        $Seat =  $row['car_seat'];  //40จำนวนที่นั่ง
        $CC =  $row['car_cc'];  //41ซีซี

        if ($row['car_wgt'] == '' || $row['car_wgt'] == '-') 
        {
            $VehicleWeight =  0;    //42น้ำหนัก
        } 
        else 
        {
            $VehicleWeight = $row['car_wgt'];
        }

        $tcar_id = $row['car_id'];
        $pcarid = substr($tcar_id, 0, 1);

        if ($pcarid == '3') {
            $VehicleCarid = "C";  //43การใช้รถ P=บุคคล C = พาณิชย์
        } else if ($pcarid == '2') {
            $VehicleCarid = "C";
        } else {
            $VehicleCarid = "P";
        }

        $VehicleUseCode = $VehicleCarid;  //43การใช้รถ P=บุคคล C = พาณิชย์
        $NetPremium = str_replace(',', '', $row['p_pre']);  //44สุทธิ
        $Vat =  str_replace(',', '', $row['p_stamp']);  //45ภาษี
        $Stamp = str_replace(',', '', $row['p_tax']);  //46อากร
        $GrossPremium = str_replace(',', '', $row['p_net']);  //47เบี้ยรวม

        $OnlinePayment_amt = "0.00";  //48จำวนการจ่ายเงิน
        $OnlinePayment_no = "";  //49เลขที่การจ่ายเงิน
        $isOnline = "N";  //50Yonline N offline
        $email_customer = "";  //51อีเมล์ลูกค้า
        $email_agent = "";  //52อีเมล์ตัวแทน
        $onlinemerchant_id = "";
        $agcode = "08829";
        $nowYear =  date('Y') + 543;
        $agYear = substr($nowYear, 2);
        $agsaka = "113";

        $params = array(
            'Username' => _ActUser,  //WS08829  //Tuser1 
            'Password' => _ActPass,  //9y;cmovib113  //daif1928
            'tcspolicy' => array(
                'AgentCode' => "{$agcode}", //08829  //99999
                'ApplicationNo' => "$dataID", //2รหัสอ้างอิง
                'SaleName' => "{$SaleName}", //3ผู้แจ้งงาน
                'AppSignDate' => "{$AppSignDate}", //4วันที่แจ้งงาน
                'EffectiveDate' => "{$EffectiveDate}", //5วันเริ่มคุ้มครอง
                'ExpiredDate' => "{$ExpiredDate}", //6สิ้นสุดวันคุ้มครอง
                'PolicyNo' => "{$PolicyNo}",  //7เลขที่ กธ
                'Barcode' => "{$Barcode}", //8บาร์โค้ด
                'CardType' => "{$CardType}", //9ประเภทบัตร P C L A Z
                'CardNo' => "{$CardNo}", //10หมายเลขบัตร
                'InsuredType' => "{$InsuredType}", //11P บุคคล C นิติ
                'InsuredBranchCode' => "{$InsuredBranchCode}", //12รหัสสาขาของผู้เอาประกัน
                'InsuredTitleName' => "{$InsuredTitleName}", //13คำนำหน้าชื่อ
                'InsuredName' => "{$InsuredName}", //14ชื่อผู้เอาประกัน
                'InsuredLastName' => "{$InsuredLastName}", //15นามสกุลผูเอาประกัน
                'Gender' => "{$Gender}", //16เพศ M F
                'BirthDate' => "{$BirthDate}", //17วันเกิด
                'Telephone' => "{$Telephone}",  //18เบอร์โทร
                'MobileNo' => "{$MobileNo}",  //19มือถือ
                'HomeNo' => "{$HomeNo}",  //20เบอร์บ้าน
                'Building' => "{$Building}",  //21ตึก
                'Moo' => "{$Moo}", //22หมู่ที่
                'Moobarn' => "{$Moobarn}", //23หมู่บ้าน
                'RoomNo' => "{$RoomNo}", //24เบอร์ห้อง
                'Trok' => "{$Trok}",  //25ตรอก
                'Soi' => "{$Soi}",  //26ซอย
                'Road' => "{$Road}",  //27ถนน
                'Tambol' => "{$Tambol}",  //28ตำบล
                'Amphur' => "{$Amphur}",  //29อำเภอ
                'Postcode' => "{$Postcode}",  //30รหัสไปรษณีย์
                'Province' => "{$Province}",  //31จังหวัด
                'LicenseNo' => "{$LicenseNo}",  //32ทะเบียนรถ
                'LicenseProvince' => "{$LicenseProvince}",  //33จดทะเบียนจังหวัด
                'Chassis' => "{$Chassis}",  //34เลขถัง
                'Engine' => "{$Engine}",  //35เลขเครื่อง
                'VehicleType' => "{$VehicleType}", //36ประเภทรถ1.30
                'VehicleMake' => "{$VehicleMake}",  //37ยี่ห้อรถ
                'VehicleModel' => "{$VehicleModel}",  //38รุ่นรถ
                'VehicleRegYear' => "{$VehicleRegYear}", //39ปีที่จดทะเบียน
                'Seat' => "{$Seat}",  //40จำนวนที่นั่ง
                'CC' => "{$CC}",  //41ซีซี
                'VehicleWeight' => "{$VehicleWeight}",  //42น้ำหนัก
                'VehicleUseCode' => "{$VehicleUseCode}",  //43การใช้รถ
                'NetPremium' => "{$NetPremium}",  //44สุทธิ
                'Vat' => "{$Vat}",  //45ภาษี
                'Stamp' => "{$Stamp}",  //46อากร
                'GrossPremium' => "{$GrossPremium}"
            )
        );
        return $params;
    }

    public static function requestMapper($value)
    {
        $_req = new ActBlackApiModel();
        $_req->TransactionId = $value['dataID'];
        $_req->Status = 'POR';
        $_req->SaleName = 'สาริตา นิยมไทย';
        $_req->AppSignDate = OtherService::ws_datetime($value['send_date']);
        $_req->EffectiveDate = OtherService::ws_date($value['start_date']);
        $_req->ExpiredDate = OtherService::ws_date($value['end_date']);
        $_req->PolicyNo = $value['tmp_act_id'];
        $_req->Barcode = $value['barcode_id'];
        $_req->CardType = OtherService::checkPersonCardType($value);
        $_req->InsuredType = OtherService::checkPersonInsuredType($value);
        $_req->CardNo = OtherService::checkCardNo($value);
        $_req->InsuredTitleName = $value['id_prename'];
        $_req->InsuredName = $value['name'];
        $_req->InsuredLastName = $value['last'];
        $_req->Gender = $value['sex'] != '' ? $value['sex'] : 'M';
        $_req->BirthDate = '';
        $_req->InsuredHeadOffice = "Y";
        $_req->MobileNo = OtherService::telephoneDumy();
        $_req->Telephone = OtherService::moblieDumy();
        $_req->HomeNo = trim($value['add']);
        $_req->Building = "";
        $_req->Group = $value['group'];
        $_req->Town = $value['town'];
        $_req->RoomNo = "";
        $_req->Trok = "";
        $_req->Soi = $value['lane'];
        $_req->Road = $value['road'];
        $_req->Tambol = LoadInformationCustomerFour::getTumbon($value['tumbon']);
        $_req->Amphur = LoadInformationCustomerFour::getAmPhur($value['amphur']);
        $_req->Postcode = $value['postal'];
        $_req->Province = LoadInformationCustomerFour::getProvince($value['province']);
        $_req->LicenseNo = OtherService::checkCarPlate($value['car_regis']);
        $_req->Chassis = $value['car_body'];
        $_req->Engine = $value['n_motor'];
        $_req->VehicleType = $value['p_id']; //36ประเภทรถ1.30 car_brand  mo_car_name vehicle_type
        $_req->VehicleMake = $value['car_brand']; //37ยี่ห้อรถ
        $_req->VehicleModel = $value['mo_car_name']; //38รุ่นรถ
        $_req->VehicleRegYear = $value['regis_date']; //"2012"; //39ปีที่จดทะเบียน
        $_req->Seat = $value['car_seat'];
        $_req->CC = $value['cc'];
        $_req->VehicleWeight = $value['car_wg'];

        $_actRes = LoadInformationCustomerFour::getActByBase4($value['p_id']);
        $_req->NetPremium = $_actRes['pre_act'];
        $_req->Stamp = $_actRes['stamp_act'];
        $_req->Vat = $_actRes['tax_act'];
        $_req->GrossPremium = $_actRes['net_act'];

        $_req->LicensePlateNo = OtherService::checkLicensePlateNo($_req->LicenseNo, $value);
        $_req->LicenseProvince = LoadInformationCustomerFour::getProvince($value['car_regis_pro']);
        $_req->Discount = '0';
        $_req->OnlinePayment_amt = "0.00";
        $_req->OnlinePayment_no = "";
        $_req->isOnline = "N";
        $_req->FlagOnline = '1';
        $_req->email_customer = "Test@gmail.com";
        $_req->email_agent = "Broker@gmail.com";
        $_req->onlinemerchant_id = "";
        $_req->agcode = "09712";
        $_req->nowYear = date('Y') + 543;
        $_req->agYear = substr($_req->nowYear, 2);

        $_codeDealerAndSaka = LoadInformationCustomerFour::getDealerCodeAndSaka($value['CodeDealer']);
        $_req->agsaka = $_codeDealerAndSaka['saka'];
        $_req->DelarCode = $_codeDealerAndSaka['Dealer_code'];

        return $_req;
    }
}

class OtherService
{
    public static function checkLicensePlateNo($value, $req)
    {
        if ($value == 'B') {
            return $req['car_regis'];
        }
        return '';
    }

    public static function checkCarPlate($req)
    {
        if ($req == 'ป้ายแดง' || $req == 'ปดF0050') {
            return 'R';
        } else {
            return 'B';
        }
    }

    public static function telephoneDumy()
    {
        $ran = rand() . rand() . rand();
        return '02-' . substr($ran, 1, 7);
    }

    public static function moblieDumy()
    {
        $ran = rand() . rand() . rand();
        return '08' . substr($ran, 1, 8);
    }

    public static function checkCardNo($req)
    {
        if (!empty($req['icard'])) {
            return $req['icard'];
        } else {
            return $req['id_business'];
        }
    }

    public static function checkPersonInsuredType($req)
    {
        if ($req['person'] == '1') {

            return "P";
        } else if ($req['person'] == '2') {

            return "C";
            // $_req->InsuredBranchCode = "00000"; // รหัสสาขาของผู้เอาประกัน
        } else if ($req['person'] == '3') {

            return "P";
        }
    }

    public static function checkPersonCardType($req)
    {
        if ($req['person'] == '1') {
            return "C";
        } else if ($req['person'] == '2') {
            return "L";
        } else if ($req['person'] == '3') {
            return "P";
        }
    }

    public static function ws_datetime($dt)
    {
        list($date, $time) = explode(' ', $dt); // แยกวันที่ กับ เวลาออกจากกัน
        list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
        list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
        $Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.

        switch ($m) {
            case "01":
                $m = "01";
                break;
            case "02":
                $m = "02";
                break;
            case "03":
                $m = "03";
                break;
            case "04":
                $m = "04";
                break;
            case "05":
                $m = "05";
                break;
            case "06":
                $m = "06";
                break;
            case "07":
                $m = "07";
                break;
            case "08":
                $m = "08";
                break;
            case "09":
                $m = "09";
                break;
            case "10":
                $m = "10";
                break;
            case "11":
                $m = "11";
                break;
            case "12":
                $m = "12";
                break;
        }

        return $Y . $m . $d;
    }

    public static function ws_date($dt)
    {
        list($date, $time) = explode(' ', $dt); // แยกวันที่ กับ เวลาออกจากกัน
        list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
        list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
        $Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.

        switch ($m) {
            case "01":
                $m = "01";
                break;
            case "02":
                $m = "02";
                break;
            case "03":
                $m = "03";
                break;
            case "04":
                $m = "04";
                break;
            case "05":
                $m = "05";
                break;
            case "06":
                $m = "06";
                break;
            case "07":
                $m = "07";
                break;
            case "08":
                $m = "08";
                break;
            case "09":
                $m = "09";
                break;
            case "10":
                $m = "10";
                break;
            case "11":
                $m = "11";
                break;
            case "12":
                $m = "12";
                break;
        }

        return $Y . $m . $d;  //20181001
    }
}