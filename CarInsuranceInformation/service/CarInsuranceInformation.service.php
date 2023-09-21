<?php
class CarInsuranceInformationService
{
	private $_context;
	public function __construct($con)
	{
		$this->_context = $con;
	}

	public function getCarInsurance($model)
	{
		
		$convertSearch = new ConvertSearchDataCarInsuranceInformationService();
		$rowCount = new RowCountCarInsuranceInformationService($this->_context);
		$convert = new ConvertDataCarInsuranceService();
		$convertEquipment = new ConvertDataEquipmentCarTextService($this->_context);
		$mapper = new MapperCarInsuranceInformationService();
		$searchAll = $convertSearch->searchAll($model->RequestArr['search']['value']);
		$sqlOrderBy = $convertSearch->sqlOrderBy($model->RequestArr);
		$sqlLimit = $convertSearch->sqlLimit($model->RequestArr);
		$sqlStartDate = "AND `data`.start_date > '2021-01-01'";
		$sqlUserLogin = $convertSearch->sqlUserLoginSearch($model->UserLogin);
		$rowFull = $rowCount->countCarInsurance($searchAll,$sqlUserLogin,$model->PersonType);
		
		
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
		,`data`.costCost
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
		WHERE insuree.person = '$model->PersonType'AND 
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
		) $sqlUserLogin $sqlStartDate $sqlOrderBy $sqlLimit")->fetchAll(2);

		
		// -- ,tb_mo_car.name AS CarModelName
		// -- ,tb_cost.net
		// -- ,tb_cost.cost

		// -- INNER JOIN tb_mo_car ON (detail.mo_car = tb_mo_car.id)
		// -- INNER JOIN tb_cost ON (`data`.costCost = tb_cost.id)

		$fetchMappered = $mapper->dataCarInsurance($fetchInsurance);

		$convertEquipment->createDataDecorationEquipment($fetchMappered);
		$convertEquipment->createDataEndorseDecorationEquipment($fetchMappered);

		$datasArr = array();
		foreach($fetchMappered as $obj)
		{
			$_net = $convert->searchNet($obj->Cost);
			$_cost = $convert->searchCost($obj->Cost);
			$_mo = $convert->searchModel($obj->IdCarModel);

			$map = new DataInsuranceInformationModel();
			$map->StatusEmail = $convert->iconSendMail($obj);
			$map->PrintInsurance = $convert->printInsuranceApplicationForm($obj,$model->UserLogin);
			$map->IdDataSend = $convert->buttonInformOnline($obj);
			$map->Name = $convert->customerName($obj);
			$map->SendDate = "$obj->SendDate";
			$map->StartDate = $convert->protectionDate($obj);
			$map->PrintAct = $convert->printAct($obj,$model->StatusUseAct);
			$map->WSAPIONLINE = $convert->printWsApiAct($obj);
			$map->MoCar = $_mo['name'];
			$map->CarBody = $convert->numberBodyAndMotor($obj);
			$map->Cost = $_cost['cost'];
			$map->Pre = $convert->numberMoney($_net['net']);
			$map->Product = $convert->equipmentName($obj,$convertEquipment);
			$map->CostProduct = $convert->equipmentPremiumAdd($obj);
			array_push($datasArr,$map);

		}
		
		$res = new DataTableCarInsuranceInformationResponseModel();
		$res->Data->draw = $model->RequestArr['draw'];
		$res->Data->recordsTotal = $rowFull;
		$res->Data->recordsFiltered = $rowFull;
		$res->Data->data = $datasArr;
		$res->Data->SESSION_CHECK = $model->StatusUseAct;
		return $res;
	}
}
?>