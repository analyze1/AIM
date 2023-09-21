<?php
class DecorationEquipmentCarService
{
    private $_context;
    public function __construct($con)
    {
        $this->_context = $con;
        $this->_context->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //เรียกข้อมูลสถานะเปลียนแปลงประเภทรถอุปกรณ์ตกแต่งเพิ่มเติมไปใช้งาน หน้าแจ้งประกันภัย
    public function createChangeTypeCarStatus()
    {
        $dataEqu = $this->fetchDataDecorationEquipment();
        $convertDataEqu = $this->convertDataEquipmentForChangeType($dataEqu);

        $res = new EquipmentChangeTypeCarResponseModel();
        $res->ChangeTypeStatus = $convertDataEqu;
        $res->Status = 200;
        return $res;
    }

    /*
    ดึงข้อมูลสถานะเปลียนแปลงประเภทรถอุปกรณ์ตกแต่งเพิ่มเติม params 
    $typeCar คือ ประเภทรถ เช่น ค่า เป็น 1 ของเก๋ง 2 กระบะ
    $useStatus คือ ถ้า เป็น Y กรองที่ใช้งาน ถ้าเป็น N กรองไม่ใช้งาน
    */
    private function fetchDataDecorationEquipment($typeCar = null,$useStatus = null)
    {
        try
        {
            $sqlTypeCar = $typeCar != null ? " AND idcar = '$typeCar' " : "";
            $sqlUseStatus = $useStatus != null ? ($useStatus == 'Y' ? " AND status_use != 'N' " : " AND status_use = 'N' ") : "";
            
            $sqlEqu = "SELECT id,ChangeTypeCarStatus,`name` FROM tb_acc_new 
            WHERE id != '' $sqlTypeCar $sqlUseStatus";

            $fetchEqu = $this->_context->query($sqlEqu)->fetchAll(5);
            $res = array();
            foreach($fetchEqu as $obj)
            {
                $map = new DataDecorationEquipmentCarModel();
                $map->Id = $obj->id;
                $map->ChangeTypeCarStatus = $obj->ChangeTypeCarStatus;
                $map->EquipmentName = $obj->name;
                array_push($res,$map);
            }
            return $res;
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

    //แปลงข้อมูลสำหรับใช้ดูสถานะอุปกรณ์ที่เปลียนแปลงประเภทรถ
    private function convertDataEquipmentForChangeType($params)
    {
        $res = array();
        foreach($params as $obj)
        {
            $res[$obj->Id] = $obj->ChangeTypeCarStatus;
        }
        return $res;
    }
}
?>