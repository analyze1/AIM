<?php

Class BitlyLink
{
    public static function reloadToken($conn,$tokenOld)
    {
        $sql = "UPDATE BitlyToken SET BitlyToken.Active = 0 WHERE BitlyToken.BitlyToken = '$tokenOld'";
        $conn->prepare($sql)->execute();
        $sql = "SELECT BitlyToken.BitlyToken FROM BitlyToken WHERE BitlyToken.Active = 1 ORDER BY id ASC LIMIT 1";
        $info = $conn->query($sql)->fetch();
        return $info['BitlyToken'];
    }

//getBitlyLink ตัวเรียกใช้งาน
    public static function getBitlyLink($longUrl,$conn)
    {
        $sql = "SELECT * FROM BitlyToken WHERE BitlyToken.Active = 1 ORDER BY id ASC LIMIT 1";
        $info = $conn->query($sql)->fetch();
        $apiv4 = 'https://api-ssl.bitly.com/v4/bitlinks';
        $genericAccessToken = $info['BitlyToken'];

        $data = array(
            'long_url' => $longUrl
        );

        $payload = json_encode($data);
        reload:
        $header = array(
            'Authorization: Bearer ' . $genericAccessToken,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        );

        $ch = curl_init($apiv4);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);

        $response = @json_decode($result);
        $linkID = $response->id;
        if($linkID=='')
        {
            $genericAccessToken = self::reloadToken($conn,$genericAccessToken);
            if($genericAccessToken!='')
            {
                goto reload;
            }
            else
            {
                $linkID=false;
            }
        }
        return $linkID;

    }

    #region function gen bily on knowledge
    public static function getBitlyLinkByToken($longUrl,$conn,$token)
    {
        
        $apiv4 = 'https://api-ssl.bitly.com/v4/bitlinks';
        $genericAccessToken = $token;

        $data = array(
            'long_url' => $longUrl
        );

        $payload = json_encode($data);
        reload:
        $header = array(
            'Authorization: Bearer ' . $genericAccessToken,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        );

        $ch = curl_init($apiv4);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);

        $response = @json_decode($result);
        $linkID = $response->id;
        if($linkID=='')
        {
            $genericAccessToken = self::reloadToken($conn,$genericAccessToken);
            if($genericAccessToken!='')
            {
                goto reload;
            }
            else
            {
                $linkID=false;
            }
            // return 'fall';
        }
        return $linkID;

    }
    #endregion
}
class Logger
{
    public static function log($request)
    {
        $texts = '';
        foreach($request as $key=>$val)
        {
            if(empty($texts))
            {
                $texts .= $val;
            }
            else
            {
                $texts .= '|'.$val;
            }
        }
        // $texts .= "\r\n";

        // $textput = iconv('UTF-8', 'tis-620', $texts);
        // $namefile = iconv('UTF-8', 'tis-620', './LoggerSMS/log_sms'.date('Y-m-d').'.txt');
        // $handle = fopen($namefile,'a');
        // fwrite($handle,$textput);
        // fclose($handle);
        // return true;
        $dateTT = date('Y-m-d H:i:s');
        $sql = "INSERT INTO log_send_sms (Remark,StampDate) VALUES ('$texts','$dateTT')";
        PDO_CONNECTION::fourinsure_insured()->prepare($sql)->execute();
        return true;
    }
}

class SendMessageService
{
    // version 1.0
    public static function sendMessage($account, $password, $mobile_no, $message, $schedule = '', $category = '', $sender_name = '', $proxy = '', $proxy_userpwd = '')
    {
        $option = '';
        if ($category == '')
        {
            $category = 'General';
        }
        $option = "SEND_TYPE={$category}";
        if ($sender_name != '') {
            $option .= ",SENDER={$sender_name}";
        }

        $params = array(
            'ACCOUNT' => $account,
            'PASSWORD' => $password,
            'MOBILE' => $mobile_no,
            'MESSAGE' => $message
        );
        if ($schedule) {
            $params['SCHEDULE'] = $schedule;
        }
        if ($option) {
            $params['OPTION'] = $option;
        }

        $curl_options = array(
            CURLOPT_URL => 'https://u8-2.sc4msg.com/SendMessage',
            CURLOPT_PORT => 443,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSLVERSION => 6,
            CURLOPT_RETURNTRANSFER => true,
        );
        if ($proxy != '') {
            $curl_options[CURLOPT_PROXY] = $proxy;
            if ($proxy_userpwd != '') {
                $curl_options[CURLOPT_PROXYUSERPWD] = $proxy_userpwd;
            }
        }

        $ch = curl_init();
        curl_setopt_array($ch, $curl_options);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            
             $er = array('result' => false, 'error' => $error);
             Logger::log($er);
             return $er;
        } else {
            // STATUS=0
            // TASK_ID=109692
            // END=OK
            //echo $response;
            $results = explode("\n", trim($response));
            $index = count($results) - 1;
            if (trim($results[$index]) == 'END=OK') {
                $results[0] = trim($results[0]);
                if ($results[0] == 'STATUS=0') {
                    $task_id = '';
                    $message_id = '';
                    foreach ($results as $result) {
                        $datas = explode("=", $result);
                        if ($datas[0] == 'TASK_ID') {
                            $task_id = $datas[1];
                        } elseif ($datas[0] == 'MESSAGE_ID') {
                            $message_id = $datas[1];
                        }
                    }
                     $res = array(
                        'result'     => true,
                        'task_id'    => $task_id,
                        'message_id' => $message_id
                    );
                    Logger::log($res);
                    return $res;
                } else {
                    $res= array(
                        'result' => false,
                        'error'  => $results[0]
                    );
                    Logger::log($res);
                    return $res;
                }
            } else {
                $res= array(
                    'result' => false,
                    'error'  => "Incorrect Response: {$response}"
                );
                Logger::log($res);
                    return $res;
            }
        }
    }
}
class SendSmsService
{
    public static function SmsHandle($smsText,$tel)
    {
        // $ACCOUNT="post@fourinsura";
		// $PASSWORD="C699D09939D5BBF231EF67D073E3373C170F03D33C74FC1495F2B42744CE324E";

        // $ACCOUNT="postmvi@fourinsura";
		// $PASSWORD="B544BD194EFB029A66344EA3135C9571230B006F0E566C52B6371AF2CDB7BCC09047D02264DE22E0";
		// $MOBILE = $tel;
        // $MESSAGE= iconv('UTF-8','TIS-620',$smsText);
		// $LANGUAGE = "T";
        // $ch = curl_init("https://sc4msg.com/bulksms/SendMessage");
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch,CURLOPT_POST,1);
        // curl_setopt($ch,CURLOPT_POSTFIELDS,"ACCOUNT=$ACCOUNT&PASSWORD=$PASSWORD&MOBILE=$MOBILE&MESSAGE=$MESSAGE&LANGUAGE=T");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        // curl_exec($ch);
        // return false;

        $account = 'postmvi@fourinsura';
        $password = 'B544BD194EFB029A66344EA3135C95716900B08DAB44AB0E2FE496224DB902EAA45F9511F80B612F';
        $mobile_no = $tel;
        $message = $smsText;
        $category = 'General';
        $sender_name = ''; // use default sender name if not defined

        SendMessageService::sendMessage($account, $password, $mobile_no, $message, '', $category, $sender_name);
        return true;
    }
}