<?php
class EndorseCarInsuranceInformationService
{
	private $_context;
	public function __construct($con)
	{
		$this->_context = $con;
	}

	public function getCarInsurance($model)
	{
		$convertSearch = new ConvertDataSearchEndorseCarInsuranceInformationService();
		$rowCount = new RowCountEndorseCarInsuranceInformationService($this->_context);
		$mapper = new MapperEndorseCarInsuranceInformationService();
		$searchAll = $convertSearch->searchAll($model->RequestArr['search']['value']);
		$sqlOrderBy = $convertSearch->sqlOrderBy($model->RequestArr);
		$sqlLimit = $convertSearch->sqlLimit($model->RequestArr);
		$sqlUserLogin = $convertSearch->sqlUserLoginSearch($model->UserLogin);
		$sqlEndorse = $convertSearch->sqlEndorseSearch($model->StatusEndorse);
		$rowFull = $rowCount->countCarInsurance($searchAll,$sqlUserLogin,$sqlEndorse);
		$fetchInsurance = $this->_context
		->query("SELECT 
		act.p_act
		,act.tmp_act_id
		,act.PactOnline
		,act.ws_path_policy
		,`data`.id_data
		,`data`.Status_Email
		,`data`.Advance
		,`data`.send_date
		,`data`.`start_date`
		,`data`.end_date
		,insuree.title
		,insuree.name
		,insuree.last
		,insuree.ws_prb_status
		,insuree.person
		,detail.car_body
		,detail.n_motor
		,detail.br_car
		,detail.mo_car
		,detail.mo_sub
		,detail.add_price
		,detail.car_detail
		,tb_mo_car.name AS CarModelName
		,tb_mo_car_sub.name AS CarModelSubName
		,tb_cost.net
		,tb_cost.cost
		,req.Req_Status
		,req.Product
		,req.EditAct
		,req.EditAct_id
		,req.EditTime
		,req.EditTime_StartDate
		,req.EditTime_EndDate
		,req.EditCar
		,req.Edit_CarBody
		,req.Edit_Nmotor
		,req.Edit_CarColor
		,req.EditCustomer
		,req.Cus_title
		,req.Cus_name
		,req.Cus_last
		,req.EditProduct
		,req.CostProduct
		FROM `data` 
		INNER JOIN insuree ON (`data`.id_data = insuree.id_data)
		INNER JOIN detail ON (`data`.id_data = detail.id_data)
		INNER JOIN act ON (`data`.id_data = act.id_data)
		INNER JOIN req ON (`data`.id_data = req.id_data)
		INNER JOIN tb_br_car ON (detail.br_car = tb_br_car.id)
		INNER JOIN tb_mo_car ON (detail.mo_car = tb_mo_car.id)
		INNER JOIN tb_mo_car_sub ON (detail.mo_sub = tb_mo_car_sub.id)
		INNER JOIN tb_cost ON (`data`.costCost = tb_cost.id)
		WHERE $sqlEndorse 
		(
			data.id_data LIKE '%$searchAll%'
			OR insuree.name LIKE '%$searchAll%'
			OR insuree.last LIKE '%$searchAll%'
			OR insuree.title LIKE '%$searchAll%'
			OR detail.car_body LIKE '%$searchAll%'
			OR detail.n_motor LIKE '%$searchAll%'
			OR act.p_act LIKE '%$searchAll%'
			OR act.PactOnline LIKE '%$searchAll%'
			OR req.EditAct_id LIKE '%$searchAll%'
			OR req.Edit_CarBody LIKE '%$searchAll%'
			OR req.Edit_Nmotor LIKE '%$searchAll%'
			OR req.Cus_title LIKE '%$searchAll%'
			OR req.Cus_name LIKE '%$searchAll%'
			OR req.Cus_last LIKE '%$searchAll%'
		) $sqlUserLogin $sqlOrderBy $sqlLimit ")->fetchAll(2);

		$fetchMappered = $mapper->dataCarInsurance($fetchInsurance);
		$convert = new ConvertDataEndorseCarInsuranceService($this->_context,$fetchMappered);
		$datasArr = array();
		foreach($fetchMappered as $row => $mapObj)
		{
			$datasArr[$row]['CostProduct'] = $convert->equipmentPremiumAdd($mapObj);
			$datasArr[$row]['Status_Email'] = $convert->iconSendMail($mapObj);
			$datasArr[$row]['car_body'] = $convert->numberBodyAndMotor($mapObj);
			$datasArr[$row]['cost'] = $mapObj->Cost;
			$datasArr[$row]['id_data_send'] = $convert->buttonInformOnline($mapObj);
			$datasArr[$row]['mo_car'] = $convert->carModel($mapObj);
			$datasArr[$row]['name'] = $convert->customerName($mapObj);
			$datasArr[$row]['pre'] = $convert->numberMoney($mapObj->Net);
			$datasArr[$row]['print_act'] = $convert->printAct($mapObj,$model->StatusUseAct);
			$datasArr[$row]['product'] = $convert->equipmentName($mapObj);
			$datasArr[$row]['send_Attached'] = $convert->buttonInformEndorse($mapObj);
			$datasArr[$row]['send_date'] = "$mapObj->SendDate";
			$datasArr[$row]['start_date'] = $convert->protectionDate($mapObj);
		}
		$resArr = array();
		$resArr['draw'] = $model->RequestArr['draw'];
		$resArr['recordsTotal'] = $rowFull;
		$resArr['recordsFiltered'] = $rowFull;
		$resArr['data'] = $datasArr;
		$resArr['SESSION_CHECK'] = $model->StatusUseAct;
		$resArr['StatusEndorse'] = $model->StatusEndorse;
		return $resArr;
	}
}
?>