<?php

//TODO forgetservice.
class ForgetPassSendControl
{
    private $_contextMit;

    public function __construct($con)
    {
        $this->_contextMit = $con;
    }

    private function getinfoDealer($id)
    {
        if(empty($id))return false;
        $sql = "SELECT CONCAT(title_sub,sub) AS nameFull,user,pw FROM tb_customer WHERE `user` = '$id'";
        return $this->_contextMit->query($sql)->fetch(5);
        
    }

    private function savelogForget($user,$tel)
    {
        $datenow = date('Y-m-d H:i:s');
        $sql = "INSERT INTO forget_password_log (DealerCode,`Type`,`DateTime`,Phone) VALUES (:DealerCode,:Type,:DateTime,:Phone)";
        $param = array(
            'DealerCode'=> $user,
            'Type'=>'ForgetPassword',
            'DateTime'=> $datenow,
            'Phone'=>$tel,
        );
        return $this->_contextMit->prepare($sql)->execute($param);
    }
    public function sendPassTosmsByUser($req)
    {
        try
        {
            if(strlen($req->numberphone)!=10) return false;
            $info = $this->getinfoDealer($req->user);
            if(!$info) return false;
            $this->savelogForget($req->user,$req->numberphone);
            $text = "รหัสผ่านระบบ MV insurance ของท่าน \r\n";
            $text .= "User : $info->user\r\n";
            $text .= "Pass: $info->pw\r\n";
            SendSmsService::SmsHandle($text,$req->numberphone);
            return true;
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }

    }

    public function checkTelCustomer($req)
    {
        try
        {
            $xx = array();
            $numberArr = array();
            $resArr = array();
            $sql = "SELECT pay_tel,`user` FROM tb_customer WHERE `user` = '$req'";
            $infos = $this->_contextMit->query($sql)->fetch(5);
            if(empty($infos)) return false;
            $telArr = explode(',',$infos->pay_tel);
            foreach ($telArr as $x)
            {
                $tel = preg_replace('/[^0-9]/', '', $x);
                if(strlen($tel)==10)
                {
                    $y = new ForgetModelRes();
                    $y->userCode = $req;
                    $y->numberFull = $tel;
                    $y->numberX = substr($tel,0,3).'XXXX'.substr($tel,7,3);
                    $resArr[] = $y;
                    break;
                }
            }
            if(empty($resArr)) return 400;
            return $resArr;
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function checkTel()
    {
        $result = array();
        $sql = "SELECT `user`,CONCAT(title_sub,sub) AS nameFull,pay_tel FROM tb_customer";
        $infoArr = $this->_contextMit->query($sql)->fetchAll(5);
        foreach ($infoArr as $value)
        {
            $x = $this->checkTelCustomer($value->user);
            if($x==400)
            {
                $result[] = $value;
            }
        }
        return $result;
    }
}
