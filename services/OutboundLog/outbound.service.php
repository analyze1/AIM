<?php

class OutboundControl
{
    private $_context4;
    private $_context;
    public function __construct($con,$conmitsu)
    {
        $this->_context4 = $con;
        $this->_context = $conmitsu;
    }

    public function outboundSaveLog($req,$type)
    {    
        $_dealerCode  = self::getidlogin($req['DataID']);
        $sql = "INSERT INTO inbound_log (log_callerid,stinout,call_iddata,log_system,log_calldate,log_date,agent_user,sound_update,log_streson,log_remark) 
        VALUES (:log_callerid,:stinout,:call_iddata,:log_system,:log_calldate,:log_date,:agent_user,:sound_update,:log_streson,:log_remark)";
        $params = [
            'log_callerid' => $req['Number'],
            'stinout' => 'out',
            'call_iddata' => $req['DataID'],
            'log_system' => $type,
            'log_calldate' => date('Y-m-d H:i:s'),
            'log_date' => date('Y-m-d H:i:s'),
            'agent_user' => $_dealerCode,
            'sound_update' => "",
            'log_streson' => "",
            'log_remark' => ""
        ];

        $res = $this->_context4->prepare($sql)->execute($params);
        return $res == true ? 'true' : 'false';
    }
    public  function getidlogin($iddata){
        
     
        $sql = "SELECT `login` FROM `data` WHERE id_data = '$iddata'";
        $res =  $this->_context->query($sql)->fetch(2);
        return $res['login'];
    }
}