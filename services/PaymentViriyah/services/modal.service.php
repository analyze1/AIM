<?php

class InfomationModalControl
{
    public $_context;

    public function __construct($con)
    {
        $this->_context = $con;
    }

    public function getInformationModal($id)//:ModalModelResponse
    {
        $str = "SELECT
        de.id_data,
        i.title,
        i.`name`,
        i.last,
        br.`name` AS bran,
        mo.`name` AS mo_car,
        de.car_regis,
        pe.total_commition,
        i.person,
        i.tel_mobile,
        i.tel_mobile2,
        i.tel_mobile3,
        i.tel_main 
        FROM
            detail AS de
            LEFT JOIN insuree AS i ON ( i.id_data = de.id_data )
            LEFT JOIN tb_br_car AS br ON ( br.id = de.br_car )
            LEFT JOIN tb_mo_car AS mo ON ( mo.id = de.mo_car )
            LEFT JOIN premium AS pe ON ( pe.id_data = de.id_data ) 
        WHERE
        de.id_data = '$id'";

        $result = $this->_context->query($str)->fetch(PDO::FETCH_OBJ);
        $map = new ModalModelResponse();
        $map->DataID = $result->id_data;
        $map->FullName = $this->checkName($result);
        $map->CarBrand = $result->bran;
        $map->SubModel = $result->mo_car;
        $map->CarNumber = $result->car_regis;
        $map->Price = $result->total_commition;
        $map->PhoneNumber = $this->checkPhone($result,$result->tel_main);
        $map->PriceNumber = str_replace(',','',$result->total_commition);
        return $map;
    }

    private function checkPhone($value,$main)
    {
        if($main=='M||')
        {
            return $value->tel_mobile;
        }
        if($main=='|M|')
        {
            return $value->tel_mobile2;
        }
        if($main=='||M')
        {
            return $value->tel_mobile3;
        }
        return false;
    }

    private function checkName($value)//:string
    {
        if($value->person=='1'||$value->person=='3')
        {
            return trim($value->title).$value->name.' '.$value->last;
        }
        else
        {
            return trim($value->title).' '.$value->name.' '.$value->last;
        }
    }

    public function paymentFullManager($request)//:ModalModelResponse
    {
        try
        {
            $req = new PaymentFulModelRequest($request,'FullPayment');//map request class.

            $infos = $this->getInformationModal($req->DataID);//call back fn in class.
    
            if(str_replace(',','',$req->Price)!=str_replace(',','',$infos->Price)) return 400;
    
            if($infos->PhoneNumber==false)  return 401;
    
            $dataIDBase64 = base64_encode($req->DataID);
    
            $longUrl = _LinkPaymentViriyahCredit."/full-payment.php?Customer=$dataIDBase64";

            $bitly = _PointerDev==true? $longUrl :BitlyLink::getBitlyLink($longUrl,$this->_context);
    
            if($bitly==false) return 403;

            $result = $this->savelogPayment($req,$infos,$bitly);
            if(!$result) return 405;
            $text = 'แบบชำระผ่านบัตรเครดิต '.$infos->FullName.' '.$bitly;
            $this->saveDetailSms($req,$infos,$text);
            if(_PointerDev==false)
            {
                SendSmsService::SmsHandle($text,$infos->PhoneNumber);
            }

            // SendSmsService::SmsHandle($text,'0818165388');//$infos->PhoneNumber
            // SendSmsService::SmsHandle($text,'0830797279');
            return 200;

        }
        catch(EXception $e)
        {
            return $e;
        }
    }

    public function installmentPayment($request)
    {
        $req = new InstallmentPaymentModelRequest($request,'Installment');

        $infos = $this->getInformationModal($req->DataID);//call back fn in class.
    
            if(str_replace(',','',$req->Price)!=str_replace(',','',$infos->Price)) return 400;
    
            if($infos->PhoneNumber==false)  return 401;
    
            $dataIDBase64 = base64_encode($req->DataID);
            $onMBase64 = base64_encode($req->PriceOnMonth);
            $Monthbase64 = base64_encode($req->Month);
            $longUrl = _LinkPaymentViriyahCredit."/new-payment.php?Customer=$dataIDBase64&M=$Monthbase64&P=$onMBase64";

            $bitly = _PointerDev==true? $longUrl :BitlyLink::getBitlyLink($longUrl,$this->_context);

            if($bitly==false) return 403;

            $result = $this->savelogPayment($req,$infos,$bitly);
            if(!$result) return 405;
            $text = 'แบบผ่อนชำระผ่านบัตรเครดิต '.$infos->FullName.' '.$bitly;
            $this->saveDetailSms($req,$infos,$text);

            if(_PointerDev==false)
            {
                SendSmsService::SmsHandle($text,$infos->PhoneNumber);
            }
            else
            {
                echo $text; exit();
            }

            // SendSmsService::SmsHandle($text,'0818165388');//$infos->PhoneNumber
            // SendSmsService::SmsHandle($text,'0830797279');
            return 200;
    }

    private function savelogPayment($r,$i,$b)
    {
        $str = "INSERT INTO LogPaymentViriyahSms (id_data,Staff,`DateTimeStamp`,`Type`,Bitly,PayStatus) 
        VALUES(:id_data,:Staff,:DateTimeStamp,:Type,:Bitly,:PayStatus)";

        $params = array(
            'id_data'=>$i->DataID,
            'Staff'=>$r->Staff,
            'DateTimeStamp'=>date('Y-m-d H:i:s'),
            'Type'=>$r->Type,
            'Bitly'=>$b,
            'PayStatus'=>'N'
        );
        $res = $this->_context->prepare($str)->execute($params);
        return $res;
    }

    private function saveDetailSms($r,$i,$t)
    {
        $smsSql="INSERT INTO smsdetail (sms_user,sms_text,sms_tel,smsid_data,sms_inv,sms_time,type_work) 
        VALUES (:sms_user,:sms_text,:sms_tel,:smsid_data,:sms_inv,:sms_time,:type_work)";
		$arr = array(
            'sms_user'=>$r->Staff,
            'sms_text'=>$t,
            'sms_tel'=>$i->PhoneNumber,
            'smsid_data'=>$i->DataID,
            'sms_inv'=>'',
            'sms_time'=>date('Y-m-d H:i:s'),
            'type_work'=>"FOUR"
        );
        $result = $this->_context->prepare($smsSql)->execute($arr);
        return $result;
		
    }
}
?>