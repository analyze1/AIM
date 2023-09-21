<?php

class CallPhone
{
    protected $_context;

    public function __construct($context)
    {
        $this->_context = $context;
    }

    public function getLogByIdData($id){
        $sql = "SELECT log_callerid,log_calldate,log_status,stinout,agent_user FROM inbound_log WHERE call_iddata = '$id' ORDER BY log_calldate DESC";
        $res = $this->_context->query($sql)->fetchAll(5);
        return $res;
    }

    public function hidenNumberPhone($number)
    {
        return substr($number,0,3).'XXXX'.substr($number,7,3);
    }

}