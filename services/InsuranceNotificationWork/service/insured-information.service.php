<?php

class InsuredInformation
{
    protected $_context;
    protected $_setYearCar;
    protected $_genCarTypeId;
    public function __construct($context)
    {
        $this->_context = $context;
    }
    
    public function getTitleName($model) {
        // $sql = "SELECT prename FROM tb_titlename WHERE title_person_map_suzuki = '$model->personType' ORDER BY title_order ASC";
        // $res = $this->_context->query($sql)->fetchAll(7);
        // return $res;
        $title_name = array();
        $title_name['Data'] = '<option value="0">กรุณาเลือก</option>';
        if ($model->personType == '1' || $model->personType == '3') {
            $sql = "SELECT * FROM tb_titlename WHERE title_person_map_suzuki = '$model->personType'  ORDER BY title_order ASC ";
            $query = $this->_context->query($sql)->fetchAll(2);
            foreach ($query As $array) $title_name['Data'] .= "<option value='$array[prename]'>$array[prename]</option>";
        }
        if ($model->personType == '2') {
            $sqlSub = $this->_context->query("SELECT MainTitleName,SubTitleName FROM TitleDetail WHERE TypePersonSuzuki LIKE '%$model->personType%' AND StatusUseShowVal = '0' ")->fetchAll(2);
            foreach ($sqlSub as $datas) $title_name['Data'] .= "<option value=' $datas[MainTitleName]'>$datas[SubTitleName]</option>";

            $sql = "SELECT * FROM tb_titlename WHERE title_person_map_suzuki = '$model->personType' ORDER BY title_order ASC ";
            $query = $this->_context->query($sql)->fetchAll(2);
            foreach ($query As $array) $title_name['Data'] .= "<option value=' $array[prename]'>$array[prename]</option>";
        }

        return $title_name['Data'];
    }

    public function findInsurancePremiums($model){
        $genYear = $this->genYearCarForCost($model->carYear);
        $resCarPrice = $this->findCarPriceByID($model->carSubModelID);        
        // $sumAssured = $this->calculateCostYearByNing($genYear, $resCarPrice->price_car);
        $sumAssuredRaw = $this->checkSumAssured($model->carBrandID,$model->carModelID,$genYear,$resCarPrice->price_car);
        $sumAssured = $this->roundNing($sumAssuredRaw->totalCostPercent, -4);

        $this->_genCarTypeId = $this->genCarTypeId($model->passCarID);
        $cost = $this->genCostFormFour($model->carModelID, $sumAssured, $genYear, $model->serviceCar, $sumAssuredRaw->endCost);

        $protection = $this->findProtection($cost->protect_type);
        $res = new FindInsurancePremiumrResponse();
        $res->carId = empty($cost->car_id) ? '0' : $cost->car_id;
        $res->costStart = empty($cost->cost) ? '0' : $cost->cost;
        $res->costEnd = empty($cost->cost_end) ? '0' : $cost->cost_end;
        $res->premiumNet = empty($cost->preMin) ? '0' : $cost->preMin;
        $res->premium = empty($cost->total) ? '0' : $cost->total;
        $res->insuredType = empty($cost->insured_type) ? '0' : $cost->insured_type;        

        $res->sumAssured = empty($sumAssured) ? '0' : number_format($sumAssured);
        $res->asset = empty($protection->asset) ? '0' : number_format($protection->asset);
        $res->excess = empty($protection->Excess) ? '0' : $protection->Excess;
        $res->driver = empty($protection->driver) ? '0' : number_format($protection->driver);
        $res->driverticket = empty($protection->driverticket) ? '0' : $protection->driverticket;
        $res->insuran = empty($protection->insuran) ? '0' : number_format($protection->insuran);
        $res->life = empty($protection->life) ? '0' : number_format($protection->life);
        $res->maxlife = empty($protection->maxlife) ? '0' : number_format($protection->maxlife);
        $res->nurse = empty($protection->nurse) ? '0' : number_format($protection->nurse);
        $res->passenger = empty($protection->passenger) ? '0' : number_format($protection->passenger);
        $res->repair = empty($cost->repair) ? '0' : $cost->repair;
        $res->tikets = empty($protection->tickets) ? '0' : $protection->tickets;
        $res->idCost = empty($cost->id_cost) ? '0' : $cost->id_cost;
        return $res;
    }

    public function checkSumAssured($brCar, $modelCar, $carOld, $price)
    {
        $sql = "SELECT
                    gc.fixcost,
                    gc.fixcostend
                FROM
                    tb_mocar_group g
                    INNER JOIN tb_mocar_group_cost gc ON ( g.mggroup = gc.mggroup ) 
                WHERE
                    g.brcar = '$brCar' 
                    AND gc.carold = $carOld 
                    AND g.mocar IN ( '$modelCar', 'ALL' ) 
                    AND (g.mgstatus = 'Y')";
        $res = $this->_context->query($sql)->fetch(5);

        $fixCostPercent = ceil(($price * (int)$res->fixcost) / 100);
        $fixCostEndPercent = ceil(($price * (int)$res->fixcostend) / 100);
        $startCost = round($fixCostPercent, -4);
        $endCost = round($fixCostEndPercent, -4);
        $totalCostPercent = round((($startCost + $endCost) / 2), -4); //ทุนประกันภัย
        $model = new stdClass();
        $model->startCost = $startCost;
        $model->endCost = $endCost;
        $model->totalCostPercent = $totalCostPercent;
        return $model;
    }

    public function genYearCar($year)
    {
        $yearNow = (int)date('Y');
        if ($year >= $yearNow) //ถ้าปีรถมากกว่าหรือเท่ากับ ปีปัจจุบัน ปัดลงมา
        {
            $year = $year - 1;
        }
        //set ปีจดทะเบียนรถใหม่ทุกครั้งหลังจากคำนวณหาปีรถแล้ว
        $this->_setYearCar = $year;

        $yearNumber = ($yearNow - (int)$year) + 1;
        return $yearNumber;
    }

    private function findCarPriceByID($id)
    {
        //TODO หาราคารถ จากรหัสรุ่นย่อย
        $sql = "SELECT price_car,gear FROM tb_car_model_sub WHERE id = '$id'";
        $res = $this->_context->query($sql)->fetch(5);
        return $res;
    }

    private function genCostFormFour($modelCar, $sumAssured, $carOld, $serviceCar = 1, $endCost = '')
    {
        $dateNow = date('Y-m-d');
        $sql = "SELECT
                    tb_cost.id AS id_cost ,
                    tb_cost.car_id ,
                    tb_cost.cost ,
                    tb_cost.cost_end ,
                    tb_cost.pre ,
                    tb_cost.total ,
                    tb_cost.`repair` ,
                    tb_cost.mocargroup ,
                    tb_cost.prod_name,
                    tb_cost.protect_type ,
                    tb_cost.insured_type ,
                    MIN(tb_cost.pre) AS preMin,
                    '' AS sumAssured
                FROM
                    tb_cost
                    LEFT JOIN tb_cost_mocar ON ( tb_cost.mocargroup = tb_cost_mocar.namegroup )
                    LEFT JOIN tb_comp ON ( tb_cost.comp = tb_comp.sort ) 
                WHERE
                    $carOld BETWEEN tb_cost.car_old 
                    AND tb_cost.car_old_end 
                    AND tb_cost.create_date <= '$dateNow' AND tb_cost.date_expired >= '$dateNow' 
                    AND tb_cost.worktype IN ( 'N', 'A' ) 
                    AND tb_cost_mocar.cmocar IN ( '$modelCar', 'ALL' ) 
                    AND ( cost_end >= $sumAssured AND cost <= $endCost ) 
                    AND tb_cost.car_id = '$this->_genCarTypeId' 
                    AND tb_cost.`repair` = $serviceCar
                    AND tb_cost.insured_type = '1' 
                    AND tb_cost.sumAssuredStatus <> 2 
                    AND comp = 'VIB_S'
                GROUP BY
                    tb_cost.`repair`,
                    tb_cost_mocar.namegroup,
                    tb_cost.pre,
                    tb_cost_mocar.cmocar 
                ORDER BY
                    tb_cost.id DESC,
                    tb_cost.`total` DESC";
        $res = $this->_context->query($sql)->fetchAll(5);
        if ($res) {
            // return $res;
            $PreMin = array();
            $pointer = array();
            foreach ($res as $key => $x){
                $pointer[$key] = $x->preMin;
                if($pointer[0] >= $x->preMin){
                    $PreMin = $x;
                }
            }
            return $PreMin;
        } else {
            $model = new stdClass();
            $model->id_cost = '';
            $model->car_id = '';
            $model->cost = '';
            $model->cost_end = '';
            $model->pre = '0.00';
            $model->total = '0.00';
            $model->repair = '';
            $model->mocargroup = '';
            $model->prod_name = '';
            $model->protect_type = '';
            $model->sumAssured = 0;
            return $model;
        }
    }

    private function genCarTypeId($passCarID)
    {
        $result = '';
        if ($passCarID == '1') {
            $result = '110';
        }

        if ($passCarID == '2') {
            $result = '210';
        }

        if ($passCarID == '3') {
            $result = '320';
        }
        return $result;
    }

    private function findProtection($protectType)
    {
        $sql = "SELECT * FROM tb_protection WHERE protect_type = '$protectType'";
        $res = $this->_context->query($sql)->fetch(5);
        if ($res) {
            return $res;
        } else {
            $model = new stdClass();
            $model->life = '0';
            $model->maxlife = '0';
            $model->asset = '0';
            $model->driver = '0';
            $model->passenger = '0';
            $model->nurse = '0';
            $model->insuran = '0';
            $model->tickets = '0';
            $model->Excess = '0';
            $model->driverticket = '0';
            $model->pro_type = '0';
            return $model;
        }

    }
    
    public function genCost($cost)
    {
        $x = explode(" ", $cost);
        return filter_var($x[0], FILTER_SANITIZE_NUMBER_INT);
    }

    public function calculateCostYearByNing($yaer, $fund)
    {
        for ($i = 1; $i <= $yaer; $i++) {
            $fund = $this->roundNing(($fund * 0.90), -4);
        }
        return $fund;
    }

    public function roundNing($cost, $index = 1)
    {
        // สูตรคำนวณกรณีหลักล้านขึ้นไป
		$numlength = strlen($cost);
		if($numlength >=7){
			$x = ($numlength*-1)+2;
			return round($cost,$x);
		}
        $newstring = substr($cost, $index);
        if (intval($newstring) != 0) {
            $newstring = intval($cost) + (10000 - $newstring);
        } else {
            $newstring = $cost;
        }
        return $newstring;
    }    

    public function genYearCarForCost($year)
    {
        $yearNow = (int)date('Y');
        $yearNumber = ($yearNow - (int)$year) + 1;
        return $yearNumber;
    }
}

