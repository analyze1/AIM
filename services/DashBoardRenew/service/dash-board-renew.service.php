<?php

use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Round;

class DashBoardRenew
{
    protected $_context;
    protected $_contextFour;
    protected $_brCarId = '046';

    public function __construct($context, $contextFour = null)
    {
        $this->_context = $context;
        $this->_contextFour = $contextFour;
    }

    public function getCountAll($model)
    {
        return 'test';
    }

    private function getNameModelCar()
    {
        $arr = array();
        $queryCount = "SELECT id,name FROM tb_mo_car WHERE br_id REGEXP '$this->_brCarId'";
        $res = $this->_contextFour->query($queryCount)->fetchAll(5);
        foreach ($res as $x) {
            $arr[$x->id] = $x->name;
        }
        return $arr;
    }

    public function getDataModelCar($model)
    {
        $arr = array();
        $arrModelCar = $this->getNameModelCar();
        $strWhere = ($model->dealerCode == 'admin') ? '' : " AND data.login = '$model->dealerCode'  ";
        $queryCount = "SELECT detail.mo_car,
                                COUNT( `data`.id_data ) AS num 
                            FROM
                                `data`
                                INNER JOIN detail ON ( `data`.id_data = detail.id_data ) 
                                INNER JOIN req ON (`data`.id_data  = req.id_data)
                                WHERE req.EditCancel <> 'Y' $strWhere
                            GROUP BY
                                detail.mo_car
                            ORDER BY
                                detail.mo_car ASC";
        $res = $this->_context->query($queryCount)->fetchAll(5);
        foreach ($res as $x) {
            array_push($arr, array('category' => $arrModelCar[$x->mo_car], 'litres' => $x->num));
        }
        return $arr;
    }

    public function genDataExpirationDate($model)
    {
        $arrayAll = array();
        $arrayGroupYear = array();
        $arrayGroupNextYear = array();
        $arrayMonthAll = array();
        $checkinfo = array();
        $arrayList = array();

        $strWhere = ($model->dealerCode == 'admin') ? '' : " AND data.login = '$model->dealerCode'  ";

        $queryCount = "SELECT 
                        MONTH( `data`.end_date ) AS mm,
                        COUNT( `data`.id_data ) AS num	
                    FROM
                    `data` INNER JOIN detail ON ( `data`.id_data = detail.id_data )
                    INNER JOIN req ON (`data`.id_data  = req.id_data)
                    WHERE
                        YEAR ( `data`.end_date ) = $model->year AND req.EditCancel <> 'Y' $strWhere
                    GROUP BY
                        MONTH ( `data`.end_date ) 
                    ORDER BY
                        MONTH ( `data`.end_date ) ASC";
        // $arrayAll['queryYear'] = $queryCount;
        $dataYear = $this->_context->query($queryCount)->fetchAll(5);
        $nextYear = ((int)$model->year - 1);

        $queryCountNextYear = "SELECT 
                        MONTH( `data`.end_date ) AS mm,
                        COUNT( `data`.id_data ) AS num	
                    FROM
                    `data` INNER JOIN detail ON ( `data`.id_data = detail.id_data ) 
                    INNER JOIN req ON (`data`.id_data  = req.id_data)
                    WHERE
                        YEAR ( `data`.end_date ) = $nextYear AND req.EditCancel <> 'Y' $strWhere
                    GROUP BY
                        MONTH ( `data`.end_date ) 
                    ORDER BY
                        MONTH ( `data`.end_date ) ASC";

        // $arrayAll['queryLastYear'] = $queryCountNextYear;
        $dataNextyear = $this->_context->query($queryCountNextYear)->fetchAll(5);

        foreach ($dataYear as $r) {
            // $arrayGroupYear[$r->mm]['category'] = $this->getMonthName($r->mm);
            $arrayGroupYear[$r->mm]['year'] = $r->num;
            $arrayMonthAll[$r->mm]['length'] = $r->mm;
        }


        foreach ($dataNextyear as $r) {
            // $arrayGroupNextYear[$r->mm]['category'] = $this->getMonthName($r->mm);
            $arrayGroupNextYear[$r->mm]['lastYear'] = $r->num;
            $arrayMonthAll[$r->mm]['length'] = $r->mm;
        }


        foreach ($arrayMonthAll as $key => $val) {
            array_push($arrayList, array(
                'category' => $this->getMonthName($key),
                'year' => (int)$arrayGroupYear[$key]['year'],
                'lastYear' => (int)$arrayGroupNextYear[$key]['lastYear']
            ));
        }

        //เช็คว่ามีข้อมูลจะ render ไหม
        $checkinfo['dataYear'] = false;
        $checkinfo['dataLastyear'] = false;
        $arrayAll['oninfo'] = 400; //ปัดว่าไม่มีข้อมูลไว้ก่อน api ไม่ได้พังนะ
        if (count($dataYear) > 0) {
            $checkinfo['dataYear'] = true;
            $arrayAll['oninfo'] = 200;
        }
        if (count($dataNextyear) > 0) {
            $checkinfo['dataLastyear'] = true;
            $arrayAll['oninfo'] = 200;
        }
        $arrayAll['dataRender'] = $arrayList;
        $arrayAll['dataYear'] = $checkinfo['dataYear'];
        $arrayAll['dataLastyear'] = $checkinfo['dataLastyear'];


        return $arrayAll;
    }

    public function getMonthName($id)
    {
        switch ($id):
            case '1':
                return 'มกราคม';
            case '2':
                return 'กุมภาพันธ์';
            case '3':
                return 'มีนาคม';
            case '4':
                return 'เมษายน';
            case '5':
                return 'พฤษภาคม';
            case '6':
                return 'มิถุนายน';
            case '7':
                return 'กรกฎาคม';
            case '8':
                return 'สิงหาคม';
            case '9':
                return 'กันยายน';
            case '10':
                return 'ตุลาคม';
            case '11':
                return 'พฤศจิกายน';
            case '12':
                return 'ธันวาคม';
        endswitch;
    }

    public function sumInsureTotal($Arr)
    {
        if (empty($Arr)) return 0;
        $search = null;
        foreach ($Arr as $x) {
            $search .= $search == null ? "'$x->fourID'" : ",'$x->fourID'";
        }
        $sql = "SELECT ROUND(SUM(REPLACE(total_sum,',','')),2) AS totalSum, Count(*) AS num FROM premium INNER JOIN detail ON(detail.id_data = premium.id_data) WHERE detail.cencel_check <> 'Y' AND premium.id_data IN ($search)";
        $result = $this->_contextFour->query($sql)->fetch(5);
        return $result;
    }

    public function genTotalData($model)
    {
        $strSmsWhere = ($model->dealerCode == 'admin') ? '' : "AND s.sms_user = '$model->dealerCode'";
        $strWhere = ($model->dealerCode == 'admin') ? '' : "AND `data`.`login` = '$model->dealerCode'  ";
        $queryRenewCount = "SELECT
                COUNT( `data`.id_data ) AS num 
                FROM
                    `data` INNER JOIN req ON (`data`.id_data  = req.id_data)
                WHERE
                    req.EditCancel <> 'Y' $strWhere";
        $resRenewCount = $this->_context->query($queryRenewCount)->fetch(7);

        if($resRenewCount == 0) return false;
        
        $queryFollowCount = "SELECT
                COUNT( `data`.id_data ) AS num 
                FROM
                    `data` INNER JOIN req ON (`data`.id_data  = req.id_data)
                    INNER JOIN detail_renew ON ( `data`.id_data = detail_renew.id_data ) 
                WHERE
                    req.EditCancel <> 'Y' $strWhere AND detail_renew.`status` = 'R'";
        $resFollowCount = $this->_context->query($queryFollowCount)->fetch(7);

        $queryQuotationCount = "SELECT
                COUNT( `data`.id_data ) AS num 
                FROM
                    `data` INNER JOIN req ON (`data`.id_data  = req.id_data)
                    INNER JOIN detail_renew ON ( `data`.id_data = detail_renew.id_data ) 
                WHERE
                    req.EditCancel <> 'Y' $strWhere AND detail_renew.`status` = 'S'";
        $resQuotationCount = $this->_context->query($queryQuotationCount)->fetch(7);

        $queryNoticeCount = "SELECT
                COUNT( `data`.id_data ) AS num 
                FROM
                    `data` INNER JOIN req ON (`data`.id_data  = req.id_data)
                    INNER JOIN detail_renew ON ( `data`.id_data = detail_renew.id_data ) 
                WHERE
                    req.EditCancel <> 'Y' $strWhere AND detail_renew.`status` = 'E'";
        $resNoticeCount = $this->_context->query($queryNoticeCount)->fetch(7);

        $queryRenewCountInMonth = "SELECT
        COUNT( `data`.id_data ) AS num 
        FROM
            `data` INNER JOIN req ON (`data`.id_data  = req.id_data)
        WHERE
            YEAR(`data`.end_date) = '$model->year' AND MONTH(`data`.end_date) = '$model->month' AND req.EditCancel <> 'Y' $strWhere";
        $resRenewCountInMonth = $this->_context->query($queryRenewCountInMonth)->fetch(7);

        $queryFollowCountInMonth = "SELECT
        COUNT( `data`.id_data ) AS num 
        FROM
            `data` 
            INNER JOIN req ON (`data`.id_data  = req.id_data)
            INNER JOIN detail_renew ON ( `data`.id_data = detail_renew.id_data ) 
        WHERE
            detail_renew.`status` = 'R' AND YEAR(detail_renew.timecall) = '$model->year' AND MONTH(detail_renew.timecall) = '$model->month' AND req.EditCancel <> 'Y' $strWhere";
        $resFollowCountInMonth = $this->_context->query($queryFollowCountInMonth)->fetch(7);

        $queryQuotationCountInMonth = "SELECT
        COUNT( `data`.id_data ) AS num 
        FROM
            `data` 
            INNER JOIN req ON (`data`.id_data  = req.id_data)
            INNER JOIN detail_renew ON ( `data`.id_data = detail_renew.id_data ) 
        WHERE
            detail_renew.`status` = 'S' AND YEAR(detail_renew.timecall) = '$model->year' AND MONTH(detail_renew.timecall) = '$model->month' AND req.EditCancel <> 'Y' $strWhere";
        $resQuotationCountInMonth = $this->_context->query($queryQuotationCountInMonth)->fetch(7);

        $queryNoticeCountInMonth = "SELECT detail_renew.id_data_four AS fourID
        FROM
            `data`
            INNER JOIN req ON (`data`.id_data  = req.id_data)
            INNER JOIN detail_renew ON ( `data`.id_data = detail_renew.id_data ) 
        WHERE
            detail_renew.`status` = 'E' AND YEAR(detail_renew.timecall) = '$model->year' AND MONTH(detail_renew.timecall) = '$model->month' AND req.EditCancel <> 'Y' $strWhere";

        //หาจำนวน เบี้ยสุทธิแจ้งงานในเดือน ปัจจุบัน
        $resPremiunCountInMonth = $this->sumInsureTotal($this->_context->query($queryNoticeCountInMonth)->fetchAll(5));

        $queryPremiumSum = "SELECT detail_renew.id_data_four AS fourID
        FROM
            `data`
            INNER JOIN req ON (`data`.id_data  = req.id_data)
            INNER JOIN detail_renew ON ( `data`.id_data = detail_renew.id_data ) 
        WHERE
            detail_renew.`status` = 'E' AND YEAR(detail_renew.timecall) = '$model->year' AND req.EditCancel <> 'Y' $strWhere";

            // echo $queryPremiumSum;
            // exit();
        //หาจำนวน เบี้ยสุทธิแจ้งงานในปี ปัจจุบัน
        $resPremiunSum = $this->sumInsureTotal($this->_context->query($queryPremiumSum)->fetchAll(5));

        //หาจำนวนการส่ง sms ทั้งหมด

        // $smsSql = "SELECT COUNT(s.sms_text) FROM smsdetail AS s WHERE s.type_work = 'MITSUBISHI' $strSmsWhere";
        // $resSmsTotal = $this->_contextFour->query($smsSql)->fetch(7);
        $strWhereS = ($model->dealerCode == 'admin') ? '' : " WHERE `data`.`login` = '$model->dealerCode'";

        $sqlSms = "SELECT id_data FROM `data` $strWhereS";
        $resultList = $this->_context->query($sqlSms)->fetchAll(5);

        $dataList = '';
        foreach($resultList as $id)
        {
            $dataList .= empty($dataList) ? "'$id->id_data'" : ",'$id->id_data'";
        }

        $smsSql = "SELECT COUNT(s.smsid_data) AS rouns FROM smsdetail AS s WHERE s.smsid_data IN ($dataList) 
        AND s.type_work = 'MITSUBISHI' AND YEAR(s.sms_time) = '$model->year'";
        $resSmsTotal = $this->_contextFour->query($smsSql)->fetch(7);

        //หาจำนวนการส่ง sms ในเดือนนี้ทั้งหมด
        $monthNow = date('m');
        $smsSql = "SELECT COUNT(s.sms_text) FROM smsdetail AS s WHERE s.type_work = 'MITSUBISHI' AND YEAR(s.sms_time) = '$model->year'
        AND MONTH(s.sms_time) = '$monthNow' AND s.smsid_data IN ($dataList)";
        $resSmsMonth = $this->_contextFour->query($smsSql)->fetch(7);

        $modelRes = new stdClass();
        $modelRes->resRenewCount = (int)$resRenewCount;
        $modelRes->resFollowCount = (int)$resFollowCount;
        $modelRes->resQuotationCount = (int)$resQuotationCount;
        $modelRes->resNoticeCount = (int)$resPremiunSum->num;
        $modelRes->resPremiumSum = (float)$resPremiunSum->totalSum;
        $modelRes->resSmsSum = (int)$resSmsTotal;

        $modelRes->resRenewCountInMonth = (int)$resRenewCountInMonth;
        $modelRes->resFollowCountInMonth = (int)$resFollowCountInMonth;
        $modelRes->resQuotationCountInMonth = (int)$resQuotationCountInMonth;
        $modelRes->resNoticeCountInMonth = (int)$resPremiunCountInMonth->num;
        $modelRes->resPremiunCountInMonth = (float) $resPremiunCountInMonth->totalSum;
        $modelRes->resSmsCountInMonth = (float) $resSmsMonth;

        return $modelRes;
    }

    public function genDataSMS($model)
    {
        $arr = array();
        $strWhere = ($model->dealerCode == 'admin') ? "AND smsid_data LIKE '%/MMT/%'" : " AND sms_user = '$model->dealerCode' ";
        $sql = "SELECT MONTH(sms_time) AS mm,COUNT(smsid_data) AS num 
                FROM
                    smsdetail
                WHERE
                    YEAR (sms_time) = '$model->year'
                    $strWhere
                GROUP BY
                    MONTH (sms_time) 
                ORDER BY
                    MONTH (sms_time) ASC";
        
        $res = $this->_contextFour->query($sql)->fetchAll(5);
        foreach ($res as $x) {
            $arr[$x->mm] = $x->num;
        }
        
        return $arr == '' || $arr == null ? false : $arr;
    }

    public function genDataFollow($model)
    {
        $arr = array();
        $strWhere = ($model->dealerCode == 'admin') ? '' : " AND data.login = '$model->dealerCode'  ";
        $queryFollowCount = "SELECT
                MONTH(detail_renew.timecall) AS mm,
                COUNT(`data`.id_data) AS num 
                FROM
                    `data`
                    INNER JOIN req ON (`data`.id_data  = req.id_data)
                    INNER JOIN detail_renew ON ( `data`.id_data = detail_renew.id_data ) 
                WHERE
                    YEAR ( detail_renew.timecall ) = $model->year $strWhere AND detail_renew.`status` = 'R' AND req.EditCancel <> 'Y'";
        $resFollowCount = $this->_context->query($queryFollowCount)->fetchAll(5);
        foreach ($resFollowCount as $x) {
            $arr[$x->mm] = $x->num;
        }
        return $arr;
    }

    public function genDataQuotation($model)
    {
        $arr = array();
        $strWhere = ($model->dealerCode == 'admin') ? '' : " AND data.login = '$model->dealerCode'  ";
        $queryQuotationCount = "SELECT
                MONTH(detail_renew.timecall) AS mm,
                COUNT(`data`.id_data) AS num 
                FROM
                    `data`
                    INNER JOIN req ON (`data`.id_data  = req.id_data)
                    INNER JOIN detail_renew ON ( `data`.id_data = detail_renew.id_data ) 
                WHERE
                    YEAR ( detail_renew.timecall ) = $model->year $strWhere AND detail_renew.`status` = 'E' AND req.EditCancel <> 'Y'";
        $resQuotationCount = $this->_context->query($queryQuotationCount)->fetchAll(5);
        foreach ($resQuotationCount as $x) {
            $arr[$x->mm] = $x->num;
        }
        return $arr;
    }

    public function genDataNotice($model)
    {
        $arr = array();
        $strWhere = ($model->dealerCode == 'admin') ? '' : " AND data.login = '$model->dealerCode'  ";
        $queryNoticeCount = "SELECT
                MONTH(detail_renew.timecall) AS mm,
                `detail_renew`.id_data_four
                FROM
                    `data`
                    INNER JOIN req ON (`data`.id_data  = req.id_data)
                    INNER JOIN detail_renew ON ( `data`.id_data = detail_renew.id_data ) 
                WHERE
                    YEAR ( detail_renew.timecall ) = '$model->year' $strWhere AND detail_renew.`status` = 'E' AND req.EditCancel <> 'Y'";
        $resNoticeCount = $this->_context->query($queryNoticeCount)->fetchAll(5);
        $i = 1;
        $idData = $this->genIdData($resNoticeCount);
        $resNoCancel = $this->sumInsureTotalByIdData($idData);
        foreach ($resNoticeCount as $x) {
            if($resNoCancel[$x->id_data_four]){
                $arr[$x->mm] += $i;
            }
        }
        return $arr == '' || $arr == null ? false : $arr;
    }

    public function genDataCallAverage($model)
    {
        $arr = array();
        $arrAll = array();
        $done = array();
        $strWhere = ($model->dealerCode == 'admin') ? '' : " AND agent_user = '$model->dealerCode'  ";
        $queryCount = "SELECT 	
                            MONTH(log_calldate) AS mm,
                            call_iddata AS id_data
                        FROM
                            inbound_log 
                        WHERE
                            log_system = 'MITSUBISHI' AND
                            YEAR ( log_calldate ) = $model->year $strWhere
                        GROUP BY call_iddata ";
        $resCount = $this->_contextFour->query($queryCount)->fetchAll(5);
        $queryAll = "SELECT 	
                            MONTH(log_calldate) AS mm,
                            call_iddata AS id_data
                        FROM
                            inbound_log 
                        WHERE
                            log_system = 'MITSUBISHI' AND
                            YEAR ( log_calldate ) = $model->year $strWhere ";
        $resAll = $this->_contextFour->query($queryAll)->fetchAll(5);
        foreach ($resCount as $x) {
            $arr[$x->mm] += 1;
        }

        foreach ($resAll as $x) {
            $arrAll[$x->mm] += 1;
        }

        foreach ($resCount as $x) {
            $done[$x->mm] = Round($arrAll[$x->mm] / ($arr[$x->mm] * 3), 2);
        }

        return $done == '' || $done == null ? false : $done;
    }

    public function getDataPerMount($model) {
        $arr = array();
        $strWhere = ($model->dealerCode == 'admin') ? '' : "AND data.login = '$model->dealerCode'  ";
        $sql = "SELECT
                MONTH(`data`.end_date) AS `end`,
                COUNT(`data`.id_data) AS num 
                FROM
                    `data`
                    INNER JOIN req ON (`data`.id_data  = req.id_data)
                WHERE req.EditCancel <> 'Y' $strWhere GROUP BY MONTH(`data`.end_date) ASC";
                
        $res = $this->_context->query($sql)->fetchAll(5);
        foreach ($res as $x) {
            $arr[$x->end] = $x->num;
        }
        
        return $arr;
    }

    public function genTotalDataByMonth($model)
    {
        $arr = array();
        $resEndDate = $this->getDataPerMount($model);
        $resSMS = $this->genDataSMS($model);
        $resFollow = $this->genDataFollow($model);
        $resQuotation = $this->genDataQuotation($model);
        $resNotice = $this->genDataNotice($model);
        $totalCallAverage = $this->genDataCallAverage($model);
        $arrYear = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
        foreach ($arrYear as $x) {
            array_push($arr, array('year' => $this->getMonthName($x), 'totalSMS' => (int)$resSMS[$x], 'totalFollow' => (int)$resFollow[$x], 'totalQuotation' => (int)$resQuotation[$x], 'totalNotice' => (int)$resNotice[$x], 'totalCallAverage' => (float)$totalCallAverage[$x], 'totalEndDate' => (int)$resEndDate[$x]));
        }

        return $arr;
    }

    public function genDataSpareParts($model){
        $strYear = $this->genTenYear($model->year);
        $sql = "SELECT
                    spare_date,
                    SUM( spare_po ) AS spare_po,
                    SUM( spare_cost ) AS spare_cost,
                    SUM( labor_po ) AS labor_po,
                    SUM( labor_cost ) AS labor_cost,
                    SUM( suppli_po ) AS suppli_po,
                    SUM( suppli_cost ) AS suppli_cost,
                    SUM( sum_po ) AS sum_po,
                    SUM( sum_cost ) AS sum_cost 
                FROM
                    tb_mk_spares 
                WHERE
                    spare_date REGEXP '$strYear' 
                    AND supplier = '$model->dealerCode' 
                GROUP BY
                    spare_date 
                ORDER BY
                    spare_id DESC";
        $res = $this->_context->query($sql)->fetchAll(5);    
        $arr = array();    
        foreach ($res as $row) {
            $year = explode('-',$row->spare_date)[0];
            $arr[$year]['spare_po'] += $row->spare_po;
            $arr[$year]['spare_cost'] += $row->spare_cost;
            $arr[$year]['labor_po'] += $row->labor_po;
            $arr[$year]['labor_cost'] += $row->labor_cost;
            $arr[$year]['suppli_po'] += $row->suppli_po;
            $arr[$year]['suppli_cost'] += $row->suppli_cost;
            $arr[$year]['sum_po'] += $row->sum_po;
            $arr[$year]['sum_cost'] += $row->sum_cost;
        }
        $resModel = array();
        foreach($arr as $key => $row){
            $model = new stdClass();
            $model->year = strval($key);
            $model->totalSpareParts = Round($row['spare_cost'],2);
            $model->countSpareParts = $row['spare_po'];
            $model->totalWages = Round($row['labor_cost'],2);
            $model->countWages = $row['labor_po'];
            $model->totalSupply = Round($row['suppli_cost'],2);
            $model->countSupply = $row['suppli_po'];
            $model->totalClaims = Round($row['sum_cost'],2);
            $model->countClaims = $row['sum_po'];
            $model->none = 0;
            array_push($resModel,$model);
        }
        return $resModel;
    }
    private function genTenYear($thisYear){
        $str = strval($thisYear);
        $genYear = (int)$thisYear;
        for ($i=1; $i < 11; $i++) {
            $genYear = $genYear -1;
            $str .= '|'.$genYear;
        }
        return $str;
    }
    public function  genDataRenew($model) {
        $dateYear = $model->year;
        $dealerCode = $model->dealerCode;
        $month = $model->month;
        $type = $model->type;

        if ($dealerCode == 'ALL') {
            $sql_where = '';
        } else {
            $sql_where = " AND data.login = '$dealerCode'";
        }
        $query = "SELECT data.id_data, data.start_date, data.login, data.com_data, detail.car_body, tb_customer.user, tb_customer.title_sub, tb_customer.sub, MONTH(data.end_date) as dMonth 
            FROM data
            INNER JOIN detail ON (data.id_data = detail.id_data)
            INNER JOIN req ON (data.id_data = req.id_data)
            INNER JOIN tb_customer ON (data.login = tb_customer.user)
            WHERE  data.id_data != '' AND DATE(data.end_date) like '$dateYear%' AND MONTH(data.end_date) = '$month' AND req.EditCancel = '' $sql_where GROUP BY data.id_data ORDER BY data.end_date ASC ";
        $objQuery = $this->_context->query($query)->fetchAll(2);

        if (!$objQuery) return false;
        
        $str = '';
        $check = true;
        $arrNotFollow = array();
        foreach ($objQuery as $row){
            $str .= ($check) ? "'".$row['id_data']."'" : ",'".$row['id_data']."'";
            $check = false;
            $arrNotFollow[trim($row['id_data'])] = 1;
        }
        // AND MONTH(end_date) = '$month'
        // $sql = "SELECT id_data as Id, status as totalStatus FROM  detail_renew WHERE id_data IN($str) AND lastrenew = '1' AND status IN('E','N','S','R','W','P') GROUP BY id_data ORDER BY id_detail DESC";
        $sql = "SELECT
                    detail_renew.id_data AS Id,
                    detail_renew.`status` AS totalStatus,
                    data.end_date AS EndDate 
                FROM
                    detail_renew 
                INNER JOIN data on (detail_renew.id_data = data.id_data)
                WHERE
                    detail_renew.id_data IN($str)
                    AND detail_renew.lastrenew = '1' 
                    AND detail_renew.`status` IN ( 'E', 'N', 'S', 'R', 'W', 'P' ) 
                GROUP BY
                    detail_renew.id_data 
                ORDER BY
                    detail_renew.id_detail DESC";
      
        $query = $this->_context->query($sql)->fetchAll(5);
        
        $arrCount = array();
        $arrResult = array();
        $total = 0;
        $arrHave = array();
        foreach ($query as $res ) {
            $arrHave[$res->id_data] = 1;
            if ($res->totalStatus === 'E'){
                $arrCount['ต่ออายุ'] += 1; // closeJob
                $total += 1;
            }
            if($res->totalStatus === 'N'){
                $arrCount['ไม่สนใจ'] += 1; // dontCare
                $total += 1;
            }
            if($res->totalStatus === 'S'){
                $arrCount['เสนอราคา'] += 1; // quotation
                $total += 1;
            }
            if($res->totalStatus === 'R'){
                $arrCount['ติดตาม'] += 1; // follow
                $total += 1;
            }
            if($res->totalStatus === 'W'){
                $arrCount['ข้อมูลผิด'] += 1; // wrongData
                $total += 1;
            }
            if($res->totalStatus === 'P'){
                $arrCount['ต่อที่อื่น'] += 1; // connected
                $total += 1;
            }
        }

        krsort($arrCount);
        
        foreach($arrCount as $keys => $arr) {
            array_push($arrResult, array('key' => $keys, 'value' => $arr));
        }
        
        return $arrResult;
    }
    public function genIdData($res){
        $search = null;
        foreach ($res as $x) {
            $search .= $search == null ? "'$x->id_data_four'" : ",'$x->id_data_four'";
        }
        
        return $search == '' || $search == null ? 0 : $search;
    }

    public function sumInsureTotalByIdData($str)
    {
        $sql = "SELECT premium.id_data FROM premium INNER JOIN detail ON(detail.id_data = premium.id_data) WHERE premium.id_data IN ($str) AND detail.cencel_check = ''";
        $result = $this->_contextFour->query($sql)->fetchAll(5);
        $arr = array();
        foreach ($result as $value) {
            $arr[$value->id_data] = true;
        }
        return  $arr == '' || $arr == null ? 0 : $arr;
    }
}
