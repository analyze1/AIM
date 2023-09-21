<?php
class RowCountEndorseCarInsuranceInformationService
{
	private $_context;
	public function __construct($con)
	{
		$this->_context = $con;
	}
	function countCarInsurance($valSearchAll,$valSqlUserLogin,$valSqlEndorse)
	{
		return $this->_context->
		query("SELECT `data`.id FROM `data`
		INNER JOIN insuree ON (`data`.id_data = insuree.id_data)
		INNER JOIN detail ON (`data`.id_data = detail.id_data)
		INNER JOIN act ON (`data`.id_data = act.id_data)
		INNER JOIN req ON (`data`.id_data = req.id_data)
		INNER JOIN tb_br_car ON (detail.br_car = tb_br_car.id)
		INNER JOIN tb_mo_car ON (detail.mo_car = tb_mo_car.id)
		INNER JOIN tb_mo_car_sub ON (detail.mo_sub = tb_mo_car_sub.id)
		INNER JOIN tb_cost ON (`data`.costCost = tb_cost.id)
		WHERE $valSqlEndorse (
			`data`.id_data LIKE '%$valSearchAll%'
			OR insuree.name LIKE '%$valSearchAll%'
			OR insuree.last LIKE '%$valSearchAll%'
			OR insuree.title LIKE '%$valSearchAll%'
			OR detail.car_body LIKE '%$valSearchAll%'
			OR detail.n_motor LIKE '%$valSearchAll%'
			OR act.p_act LIKE '%$valSearchAll%'
			OR act.PactOnline LIKE '%$valSearchAll%'
			OR req.EditAct_id LIKE '%$valSearchAll%'
			OR req.Edit_CarBody LIKE '%$valSearchAll%'
			OR req.Edit_Nmotor LIKE '%$valSearchAll%'
			OR req.Cus_title LIKE '%$valSearchAll%'
			OR req.Cus_name LIKE '%$valSearchAll%'
			OR req.Cus_last LIKE '%$valSearchAll%'
		) $valSqlUserLogin ORDER BY `data`.id DESC LIMIT 0,1000")->rowCount();
	}
}
?>