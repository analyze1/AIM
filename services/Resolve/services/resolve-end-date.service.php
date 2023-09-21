<?php 

class ResolveEndDate
{
    protected $_contextMitsu;
    public function __construct($contextMitsu)
    {
        $this->_contextMitsu = $contextMitsu;
    }
    public function findEndDateByDealerCode($dealerCode){
        $sql = "SELECT login AS dealerCode,id_data AS idData,send_date AS sendDate,start_date AS startDate,end_date AS endDate FROM data WHERE data.login = '$dealerCode'";
        $res = $this->_contextMitsu->query($sql)->fetchAll(5);
        return $res;
    }
    public function changeEndDate($model){
        $dataEndDate = $this->findEndDateByDealerCode($model->dealerCode);
        $arr = array();
        foreach($dataEndDate as $row){
            $res = $this->genNewDate($row->sendDate,$row->startDate,$row->endDate,$row->idData);
            $sql = "UPDATE `data` SET send_date = '{$res->newSendDate}', start_date = '{$res->newStartDate}', end_date = '{$res->newEndDate}' WHERE `data`.id_data = '$row->idData' ";
            $res = $this->_contextMitsu->prepare($sql)->execute();
            $arr[$row->idData] = $res;
        }
        return $arr;
    }
    public function genNewDate($oldSendDate,$OldStartDate,$OldendDate,$idData){
        $thisYear = intval(date("Y"));
        $arrDate = explode("-",$OldendDate);
        $changYear = $thisYear.'-'.$arrDate[1].'-'.$arrDate[2];
        if($arrDate[0] == $thisYear){
            $model = new stdClass();
            $model->newStartDate = $OldStartDate;
            $model->newSendDate = $oldSendDate;
            $model->newEndDate = $OldendDate;
        }else {
            $model = new stdClass();
            $model->newStartDate = $OldStartDate;
            $model->newSendDate = $oldSendDate;
            $model->newEndDate = $changYear;

            $modelLog = new stdClass();
            $modelLog->oldSND = $oldSendDate;
            $modelLog->OldSTD = $OldStartDate;
            $modelLog->OldED = $OldendDate;
            $modelLog->idData = $idData;           
            $this->logChangsEndDate($modelLog);
        }
        return $model;        
    }
    public function logChangsEndDate($model){
        $dateNow = date('Y-m-d H:i:s');
        $sql = "INSERT INTO log_change_end_date (idData,OldSendDate,OldStartDate,OldEndDate,`TimeStamps`) VALUES('$model->idData', '$model->oldSND', '$model->OldSTD', '$model->OldED', '$dateNow')";
        $this->_contextMitsu->prepare($sql)->execute();
    }
    public function updateChangeCost($idData,$status){
        $dateNow = date('Y-m-d H:i:s');
        $sql = "UPDATE `log_change_end_date` SET ChangeCostStatus = {$status}, TimeStampsChangeCost = '{$dateNow}' WHERE idData = '$idData' ";
        $this->_contextMitsu->prepare($sql)->execute();        
    }
}