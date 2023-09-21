<?php

class CheckActId
{
    private $_context;

    public function __construct($con)
    {
        $this->_context = $con;
    }

    public function getSql($idData)
    {
        return "SELECT act.p_act as actId FROM act WHERE act.p_act != '' AND act.id_data = '$idData'";
    }

    public function CheckAct($iddata)
    {
        $sql = "SELECT act.p_act FROM act WHERE act.p_act != '' AND act.id_data = '$iddata'"; 
        $res = $this->_context->query($sql);
        $info = $res->fetch();
        $rs = $info[0];

        if($rs=='')
        {
            return '0';//ทับได้
        }
        $onfiled = explode('-',$rs); 
        if($onfiled[2]=='000000000') 
        {
            return '0';//ทับได้
        }
        if($onfiled[2]=='999999999') 
        {
            return '0';//ทับได้
        }
        if($onfiled[2]=='')
        {
            return '0';//ทับได้
        }
        return '1';//ทับไม่ได้
    }
}
?>