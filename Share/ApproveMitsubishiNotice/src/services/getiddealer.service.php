<?php
class getiddealer
{
    function getkey($GetDealercode,$key,$_context)
    {
    
        $res = "SELECT * FROM upload_admin_telephone WHERE  DealerCode = '$GetDealercode' AND keyran = '$key'";
        $result = $_context->query($res)->fetch(2);
        return $result;
    }
    function getdatacustomber($GetDealercode,$_context){
        $res = "SELECT sub,title_sub FROM tb_customer WHERE user = '$GetDealercode'";
        $result = $_context->query($res)->fetch(2);
        return $result;
    }
    public function recheckid($key,$_context)
    {
        $res = "SELECT keyran,Approve FROM upload_admin_telephone WHERE keyran = '$key' AND Approve ='Y'";
        $result = $_context->query($res)->fetch(2);
        return $result;
    }
}
    
?>