<?php

class GetVehicleTypeForApi
{
    public function __construct()
    {
        
    }

    public function loadActDefaultPrice($carType)
    {
        if($carType == 1)
        {
            $sql = "SELECT * FROM tb_act WHERE id_act IN ('110')";
        }
        else
        {
            $sql = "SELECT * FROM tb_act WHERE id_act IN ('140A')";
        }

        $_context4 = PDO_CONNECTION::fourinsure_insured();

        $info = $_context4->query($sql)->fetch();
        $res = array();
        $res['Pre'] = $info['pre_act'];
        $res['Stamp'] = $info['stamp_act'];
        $res['Vat'] = $info['tax_act'];
        $res['Net'] = $info['net_act'];
        $res['ApiTypeCode'] = $info['ActApiTypeCode'];
        $_context4 = null;
        return $res;
    }

    public function loadIdActApi($carType)
    {
        $_context4 = PDO_CONNECTION::fourinsure_insured();
        if($carType == 1)
        {
            $sql = "SELECT * FROM tb_act WHERE id_act IN ('110','310') ORDER BY id_act ASC ";
        }
        else
        {
            $sql = "SELECT * FROM tb_act WHERE id_act IN ('140A','320A','320E') ORDER BY id_act ASC ";
        }

        $infoArr = $_context4->query($sql)->fetchAll();
        $response = array(); $i=0;
        foreach($infoArr as $info )
        {
            $response[$i]['Name'] = $info['name_act'];
            $response[$i]['IdAct'] = $info['id_act'];
            $response[$i]['Id'] = $info['id'];
            $i++;
            
        }
        $_context4 = null;
        return $response;
    }

    public function loadActPrice($actTypeId)
    {
        $_context4 = PDO_CONNECTION::fourinsure_insured();
        $sql = "SELECT * FROM tb_act WHERE id = $actTypeId";
        $info = $_context4->query($sql)->fetch();
        
        $res = array();
        $res['Pre']=$info['pre_act'];
        $res['Stamp']=$info['stamp_act'];
        $res['Vat']=$info['tax_act'];
        $res['Net']=$info['net_act'];
        $res['ApiTypeCode'] = $info['ActApiTypeCode'];

        $_context4 = null;
        return $res;
    }
    
}

?>