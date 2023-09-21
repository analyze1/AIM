<?php
include "IConvertDataEquipmentCarText.service.php";
class ConvertDataEquipmentCarTextService implements IConvertDataEquipmentCarTextService
{
    private $_context;
    private $arrDataDecorationEquipment;
    private $arrDataEndorseDecorationEquipment;
    public function __construct($con)
    {
        $this->_context = $con;
        $this->_context->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }
    
    private function convertDataRequest($params)
    {
        $createSqlSearch = "";
        /*รับข้อมูลแบบ fetch mapper obj filter Name IdData*/
        if(gettype($params) == 'object')
        {
            return "'$params->IdData'";
        }
        /*รับข้อมูลแบบ fetchAll mapper List Object Name IdData*/
        else if(gettype($params[0]) == 'object')
        {
            foreach($params as $datas)
            {
                $createSqlSearch .= $createSqlSearch != '' ? ",'$datas->IdData'" : "'$datas->IdData'";
            }
            return $createSqlSearch;
        }
        /*รับข้อมูลแบบ fetchAll mapper filter List Array Name IdData*/
        else if(gettype($params[0]) == 'array')
        {
            foreach($params as $datas)
            {
                $createSqlSearch .= $createSqlSearch != '' ? ",'$datas[IdData]'" : "'$datas[IdData]'";
            }
            return $createSqlSearch;
        }
        /*รับข้อมูลแบบ fetch mapper array filter Name IdData*/
        else if(gettype($params) == 'array')
        {
            return "'$params[IdData]'";
        }
        /*รับข้อมูลแบบ value*/
        else
        {
            $createSqlSearch = "'$params'";
            return $createSqlSearch;
        }
        
    }

    private function convertDecorationEquipmentDataOut($reqParam)
    {
        
        $SearchNameEqu = "";
        $SearchCostEqu = "";
        foreach($reqParam as $datas)
        {
            $separateStep = explode('|',$datas);
            foreach($separateStep as $dataSubs)
            {
                $separateCommas = explode(',',$dataSubs);
                $SearchNameEqu .= $SearchNameEqu != '' ? ",'$separateCommas[0]'" : "'$separateCommas[0]'";
                $SearchCostEqu .= $SearchCostEqu != '' ? ",'$separateCommas[1]'" : "'$separateCommas[1]'";
            }
        }
        $resParam['NameEqu'] = "$SearchNameEqu";
        $resParam['CostEqu'] = "$SearchCostEqu";
        return $resParam;
    }

    private function convertDecorationEquipmentDataIn($reqParam,$param)
    {
        try
        {
            $getParamReq = $param;
            $arrSearchNameEqu = array();
            $arrSearchCostEqu = array(); 
            //หาจำนวนชื่ออุปกรณ์ทั้งหมด ตามจำนวนข้อมูลทีรับมา
            $fetchNameEqu = $this->_context->query("SELECT id,`name` FROM tb_acc_new WHERE id IN ($reqParam[NameEqu]) ")->fetchAll(2);
            foreach($fetchNameEqu as $datas)
            {
                $arrSearchNameEqu[$datas['id']] = "$datas[name]";
            }
            //หาจำนวนทุนอุปกรณ์ทั้งหมด ตามจำนวนข้อมูลทีรับมา
            $fetchCostEqu = $this->_context->query("SELECT id,`name` FROM tb_acc WHERE id IN ($reqParam[CostEqu]) ")->fetchAll(2);
            foreach($fetchCostEqu as $datas)
            {
                $arrSearchCostEqu[$datas['id']] = "$datas[name]";
            }
            //แปลงข้อมูลอุปกรณ์ตกแต่งดิบเป็นข้อความ
            foreach($getParamReq as $DataId => $datas)
            {
                $objparam[$DataId] = "";
                $separateStep = explode('|',$datas);
                foreach($separateStep as $dataSubs)
                {
                    $separateCommas = explode(',',$dataSubs);
                    $objparam[$DataId] .= $arrSearchNameEqu[$separateCommas[0]]." ".number_format($arrSearchCostEqu[$separateCommas[1]],0,'',',')." บาท ";
                }
            }
            return $objparam;
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function createDataDecorationEquipment($params)
    {
        // $this->_context->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try
        {
            $this->arrDataDecorationEquipment = array();
            $dataSearch = "";
            $dataSearch = $this->convertDataRequest($params);
            $sqlEqu = "SELECT id_data,car_detail FROM detail WHERE id_data IN ($dataSearch) AND car_detail != '' AND car_detail != 'ไม่มี' ";
            // echo $sqlEqu;
            // exit();
            $fetchEqu = $this->_context->query($sqlEqu)->fetchAll(2);
            
            foreach($fetchEqu as $datas)
            {
                $this->arrDataDecorationEquipment[$datas['id_data']] = $datas['car_detail'];
            }
            $ConverDataOut = $this->convertDecorationEquipmentDataOut($this->arrDataDecorationEquipment);
            $resEqu = $this->convertDecorationEquipmentDataIn($ConverDataOut,$this->arrDataDecorationEquipment);
            $this->arrDataDecorationEquipment = $resEqu;
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function createDataEndorseDecorationEquipment($params)
    {
        // $this->_context->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try
        {
            $this->arrDataEndorseDecorationEquipment = array();
            $dataSearch = "";
            $dataSearch = $this->convertDataRequest($params);
            $fetchEqu = $this->_context->query("SELECT id_data,Product FROM req WHERE id_data IN ($dataSearch) AND Req_Status = 'Y' AND EditProduct = 'Y' ")->fetchAll(2);
            foreach($fetchEqu as $datas)
            {
                $this->arrDataEndorseDecorationEquipment[$datas['id_data']] = $datas['Product'];
            }
            
            $ConverDataOut = $this->convertDecorationEquipmentDataOut($this->arrDataEndorseDecorationEquipment);
            $resEqu = $this->convertDecorationEquipmentDataIn($ConverDataOut,$this->arrDataEndorseDecorationEquipment);
            $this->arrDataEndorseDecorationEquipment = $resEqu;
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

    public function getEquipmentTextCar($value)
    {
        return $this->arrDataDecorationEquipment[$value];
    }

    public function getEndorseEquipmentTextCar($value)
    {
        return $this->arrDataEndorseDecorationEquipment[$value];
    }
}
?>