<?php

class QuotationRenew
{
    protected $_context;
    protected $_contextMy4;

    public function __construct($context = null,$contextMy4 = null)
    {
        $this->_context = $context;
        $this->_contextMy4 = $contextMy4;
    }
    public function calculateCostCurrentYear($regisYear,$cost,$additional)
	{
		$currentYear = intval(date('Y'));	
		$regisYear = intval($regisYear);	
		$round = $currentYear - $regisYear;
		$res = $this->roundNing((($cost + $additional) * 0.90), -4);
		for ($i=1; $i < $round; $i++) { 
			$res = $this->roundNing(($res * 0.90), -4);
		}
		return $res;
	}
	public function calculateCostYearByNing($yaer,$fund){
		for ($i=1; $i < $yaer; $i++) {
			$fund = $this->roundNing(($fund * 0.90), -4);
		}
		return $fund;
	}

	private function roundNing($cost,$index=1){
		$newstring = substr($cost, $index);
		if(intval($newstring)!=0){								
			$newstring = intval($cost)+(10000-$newstring);
		}else{
			$newstring = $cost;
		}
		return $newstring;
	}
	public function getNewCostU($model){
		$sql = "SELECT MIN(cost) as costMin,MAX(cost_end) as costMax FROM tb_cost WHERE mocargroup = '$model->mocarGroup' AND protect_type = '$model->protectType' AND prod_name = '$model->prodName'";
		$query =  $this->_context->query($sql)->fetch(2);
		return $query;
	}
	public function getPremiumU($model){
		$sql = "SELECT pre,net FROM tb_cost WHERE ($model->year BETWEEN car_old AND car_old_end) AND mocargroup = '$model->mocarGroup' AND protect_type = '$model->protectType' AND prod_name = '$model->prodName' AND ($model->cost BETWEEN cost AND cost_end)";
		$query =  $this->_context->query($sql)->fetch(2);
		return $query;
	}
	public function getInsuranceSumNew($idData){
		$sql = "SELECT InsuranceSumNew FROM RenewPremiumFinal09712 WHERE IdData = '$idData'";
		$query =  $this->_contextMy4->query($sql)->fetch(7);
		return $query;
	}
}
