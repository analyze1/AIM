<?php

class ActRedControl
{
    public static function makeActDocument($dataID)
    {
        $_res = array();
        $objCarProvince = new CarProvince(); //Get Car province All to model
        $_context = new QueryStorePdo();
        $row = $_context->CommandQuery($dataID);
        $_infomationMap = ApiMapper::reqMitsuMapApi($row, $dataID);

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
            $_res['PerSonID'] = LoadInformationCustomerFour::loadPersonMitsu($dataID);
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
            $agsaka = "113";//substr($dataID,2,3);

            if (!empty($returnResult)) {

                //ไม่ว่าจะผ่านหรือไม่ response api ถ้าไม่ว่างต้องเก็บเสมอ
                $thaiText = iconv("UTF-8", "tis-620", $returnErrorMsg);
                $insPrb = "INSERT INTO `wsdl_vib_result` (id_data,ws_result,ws_errcode,ws_errormsg,ws_policyno,ws_barcode,ws_policyurl,ws_entrydate,ws_emp,ws_system) 
                VALUES ('$dataID','$returnResult','$returnErrorCode','$thaiText','$returnPolicyNo','$returnBarCode','$returnPolicyURL','$_nowDay','$_user','MITSUBISHI')";
                PDO_CONNECTION::fourinsure_insured()->prepare($insPrb)->execute();
            };

            if ($returnResult == 'Success') {

                //ถ้าผ่านจะทำการอัพเดทข้อมูล และทำการ create file ไปเก็บไว้ใน pages img_view4
                $sqlupfin = "UPDATE `insuree` SET ws_prb_status = 'Y' WHERE id_data = '$dataID'";
                PDO_CONNECTION::fourinsure_mitsu()->prepare($sqlupfin)->execute();

                $codeact_id = $agcode . '-' . $agYear . $agsaka . '-' . $returnPolicyNo;

                $sqlupfinid = "UPDATE `act` SET PactOnline = '$codeact_id' ,tmp_act_id = '$returnPolicyNo' ,
                barcode_id = '$returnBarCode',ws_send_date = '$_nowDay', 
                ws_path_policy = '$returnPolicyURL' WHERE id_data = '$dataID'";

                PDO_CONNECTION::fourinsure_mitsu()->prepare($sqlupfinid)->execute();

                $updateData = "UPDATE `data` SET PactOnline = '$codeact_id',p_act = '-' WHERE id_data = '$dataID'";

                PDO_CONNECTION::fourinsure_mitsu()->prepare($updateData)->execute();

                $fileName = 'img_prb' . $agcode . $agYear . $agsaka . $returnPolicyNo . '.pdf';
                $patch = '../pages/img_view4/' . $fileName;

                //get php อีกที่นึงเพื่อนทำการ create file pdf and save
                // if (_PointerDev == false) {
                //     file_get_contents(_MainFourinsuredWeb . "/policy/print/print_Act_copy_webservice_download.php?DataID=$dataID&FullPart=$patch");
                // }
                // $sql = "UPDATE `data` SET img_prb = '$fileName' WHERE id_data = '$dataID'";
                // PDO_CONNECTION::fourinsure_mitsu()->prepare($sql)->execute();

                #region sms and download 
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
                #endregion

                //response to controller
                $_res['Status'] = 200;
                $_res['DataId'] = $dataID;
                $_res['PerSonID'] = LoadInformationCustomerFour::loadPersonMitsu($dataID);
                $_res['msg'] = "ระบบดำเนินการบันทึกสมบูรณ์แล้ว! ใบแจ้งเลขที่ :$dataID";
                $_res['paramiter'] = $_infomationMap;
                return $_res;
            } else {

                //ถ้าไม่ผ่านต้องเคลียร์ให้ดีลเลอร์รู้เรื่อง และแจ้งเตือนไลน์
                $sqlCommandHis = "UPDATE insuree SET ws_prb_status ='N' WHERE id_data = ?";
                $dataPayLoad = array("$dataID");
                $command = PDO_CONNECTION::fourinsure_mitsu()->prepare($sqlCommandHis);
                $command->execute($dataPayLoad);

                $_paramPact = array('P_act' => 'ติดต่อเจ้าหน้าที่', 'dataID' => "$dataID");

                // $sql = "UPDATE `data` SET p_act = :P_act WHERE id_data = :dataID";
                // $contextInform->prepare($sql)->execute($_paramPact);

                $sql = "UPDATE act SET p_act = :P_act WHERE id_data = :dataID";
                PDO_CONNECTION::fourinsure_mitsu()->prepare($sql)->execute($_paramPact);

                $sql = "SELECT `login` FROM `data` WHERE `data`.id_data = '$dataID'";
                $dearler = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetch();

                $infoDearler = LoadInformationCustomerFour::getDealerCodeAndSaka($dearler['login']);

                $_messLine = "ดีลเลอร์สาขา $infoDearler[saka] ชื่อ $infoDearler[sub] ไม่สามารถออก Smart พ.ร.บ. ได้ \r\n";
                $thaiText = iconv("UTF-8", "tis-620", $returnErrorMsg);
                $_messLine .= "ApiErrorMsg: $thaiText \r\n";
                $_messLine .= "เลขที่รับแจ้ง $dataID \r\nวัน-เวลา: " . date('Y-m-d H:i:s');

                //$_tokenLine = 'vzxHheVlyquXKllC5RjsnyfXxs6TKSNu6V8IFPXUFxe';//Token LINE ป้ายแดง SUZUKI

                //$_tokenLine = 'mEz09LQIE3XoyCT4G7LUP9HNtJQxRv4y8vsExIhGPAg';//Token LINE ป้ายดำ ออนไลน์  

                $_tokenLine = 'gWkOoNBB5qpnDkD9S5N9TQrwH4NY5aINUqbANknak84'; //Token กลุ่มใหม่ แจ้งเหตุ ป้ายดำ

                //linenotification เข้ากลุ่มแอดมิน
                LineNotificationControl::linenotify($_tokenLine, $_messLine);

                //response to controller
                $_res['Status'] = 200;
                $_res['DataId'] = $dataID;
                $_res['PerSonID'] = LoadInformationCustomerFour::loadPersonMitsu($dataID);
                // $_res['msg'] = "ใบแจ้งเลขที่ :$IDDATA ไม่สามารถบันทึกได้ ทางระบบได้คืน เลข เรียบร้อยแล้ว กรุณา ติดต่อ Admin และเปิดหน้านี้ค้างไว้ ห้ามปิด ขอบคุณครับ";
                $_res['msg'] = "ระบบดำเนินการบันทึกสมบูรณ์แล้ว! ใบแจ้งเลขที่ :$dataID";
                $_res['paramiter'] = $_infomationMap;
                return $_res;
            }
        }
    }
}
