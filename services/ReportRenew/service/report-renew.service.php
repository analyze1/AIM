<?php
class ReportRenew
{
    private $_contextFour;
    private $_contextMMT;
    public function __construct($contextMMT, $contextFour)
    {
        $this->_contextFour = $contextFour;
        $this->_contextMMT = $contextMMT;
    }
    public function genYearByEnddate($dealerCode)
    {
        $strWhere = ($dealerCode == 'admin') ? '' : "data.login = '$dealerCode' AND";
        $sql = "SELECT YEAR(end_date) as endYear FROM `data` WHERE $strWhere YEAR(end_date) != 0 GROUP BY YEAR(end_date) DESC";
        $res = $this->_contextMMT->query($sql)->fetchAll(2);
        if ($res) {
            return $res;
        }
        return date("Y");
    }
    public function customerExpired($model)
    {
        $strWhere = ($model->user == 'ALL') ? '' : "AND data.login = '$model->user'";
        $sql = "SELECT
                    data.id_data,
                    data.end_date,
                    insuree.title,
                    insuree.name,
                    insuree.last,
                    detail.br_car,
                    detail.mo_car,
                    detail.car_body,
                    detail.regis_date,
                    CONCAT(title,`name`,' ',`last`) AS nameFull 
                FROM
                    data 
                    INNER JOIN detail ON ( data.id_data = detail.id_data ) 
                    INNER JOIN insuree ON ( data.id_data = insuree.id_data ) 
                WHERE
                    YEAR(data.end_date) = $model->year AND MONTH(data.end_date) = $model->month $strWhere ";
        $res = $this->_contextMMT->query($sql)->fetchAll(2);
        return $res;
    }
    public function loadDataDealer()
    {
        $sql = "SELECT user AS dealerCode, title_sub AS titleSub,sub AS name FROM tb_customer WHERE claim = 'DEALER' ORDER BY user ASC";
        $res = $this->_contextMMT->query($sql)->fetchAll(2);
        return $res;
    }
    public function getDealerAll()
    {
        $x = array();
        $sql = "SELECT title_sub,sub,user FROM tb_customer ORDER BY `user` ASC";
        $query = $this->_contextMMT->query($sql)->fetchAll(5);
        if (empty($query)) return false;
        foreach ($query as $row) {
            if ($row->user == 'admin') continue;
            $y = new stdClass();
            $y->nameFull = $row->titleSub . ' ' . $row->sub;
            $y->userCode = $row->user;
            $x[] = $y;
        }
        return $x;
    }
    public function dealerAllArrSearch()
    {
        $x = array();
        $sql = "SELECT title_sub,sub,user FROM tb_customer ORDER BY `user` ASC";
        $query = $this->_contextMMT->query($sql)->fetchAll(5);
        if (empty($query)) return false;
        foreach ($query as $row) {
            $nameFull = $row->titleSub . ' ' . $row->sub;
            $x[$row->user]['nameFull'] = "[$row->user] " . trim($nameFull);
        }
        return $x;
    }
    public function loadDataDealerById($dealerCode)
    {
        $sql = "SELECT user AS dealerCode, title_sub AS titleSub,sub AS name FROM tb_customer WHERE user = '$dealerCode' ORDER BY user ASC";
        $res = $this->_contextMMT->query($sql)->fetch(5);
        return $res;
    }
    public function wrongCustomerNumber($model)
    {
        $strWhere = ($model->user == 'ALL') ? '' : "AND data.login = '$model->user'";
        $strWhereTime = '';
        $strWhereTimeRenew = '';
        $strWhereTimeMaintel = '';
        if ($model->typeOptions == 'option2') {
            $strWhereTime = "YEAR(`data`.end_date) = $model->year AND MONTH(`data`.end_date) = $model->month";
        } else {
            $strWhereTimeRenew = "(DATE(detail_renew.date_detail) BETWEEN '$model->startDate' AND '$model->endDate')";
            $strWhereTimeMaintel = "(DATE(MainTelephoneCustomer.TimeStamp) BETWEEN '$model->startDate' AND '$model->endDate')";
        }
        $arrAll = array();
        $sqlMainTel = "SELECT
            `data`.id_data,
            `data`.`login`,
            `data`.end_date,
            insuree.title,
            insuree.name,
            insuree.last,
            detail.br_car,
            detail.mo_car,
            detail.car_body,
            CONCAT( title, `name`, ' ', `last` ) AS nameFull,
            MainTelephoneCustomer.Telephone,
            DATE( MainTelephoneCustomer.TimeStamp ) AS TimeStamp,
            MainTelephoneCustomer.UserSave AS userdetail,
            MainTelephoneCustomer.StatusFollow,
            MainTelephoneCustomer.Detail
        FROM
            `data`
            INNER JOIN detail ON ( `data`.id_data = detail.id_data )
            INNER JOIN insuree ON ( `data`.id_data = insuree.id_data )
            INNER JOIN MainTelephoneCustomer ON ( `data`.id_data = MainTelephoneCustomer.DataID )
        WHERE
            $strWhereTime $strWhereTimeMaintel $strWhere
            AND MainTelephoneCustomer.Main = 5
            AND MainTelephoneCustomer.Telephone != ''
        GROUP BY
            MainTelephoneCustomer.Telephone,
            MainTelephoneCustomer.DataID 
        ORDER BY
            MainTelephoneCustomer.Id DESC";
        $resMainTel = $this->_contextMMT->query($sqlMainTel)->fetchAll(2);
        $arrAll = $resMainTel;

        return $arrAll;
    }
    public function loadLastCallById($idData, $numberPhone)
    {
        //AND log_system LIKE 'MITSU%' เอาออกเพราะมีบางเคสที่ถูกบันทึกมาเป็น sz
        $sql = "SELECT MAX(log_date) as log_date FROM inbound_log WHERE call_iddata = '$idData' AND log_callerid = '$numberPhone' ";
        $res = $this->_contextFour->query($sql)->fetch(5);
        return $res;
    }
    public function reTelephone($text)
    {
        if (strlen($text) >= 10) {
            $rename = substr($text, 0, 3) . 'XXX' . substr($text, 6);
            return $rename;
        } else if (strlen($text) >= 9) {
            $rename = substr($text, 0, 2) . 'XXX' . substr($text, 5);
            return $rename;
        } else {
            return $text;
        }
    }
    
    public function findDetail($id) {
        $sql = "SELECT name FROM tb_data_follow WHERE id = '$id'";
        return $this->_contextMMT->query($sql)->fetch(7);
    }
}
