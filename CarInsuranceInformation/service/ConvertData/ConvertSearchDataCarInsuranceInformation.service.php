<?php
class ConvertSearchDataCarInsuranceInformationService
{
    public function searchAll($value)
	{
		return $value;
	}
    public function sqlOrderBy($paramRequest)
	{
		return $paramRequest['order'][0]['column'] !='' && $paramRequest['order'][0]['column'] >= 0 && $paramRequest['order'][0]['dir'] !='' && $paramRequest['columns'][$paramRequest['order'][0]['column']]['name'] !='' ?
		" ORDER BY ".$paramRequest['columns'][$paramRequest['order'][0]['column']]['name']." ".$paramRequest['order'][0]['dir'] : "";
	}
	public function sqlLimit($paramRequest)
	{
		return $paramRequest['start'] !='' && $paramRequest['length'] !='' ?
		" LIMIT ".$paramRequest['start'].",".$paramRequest['length']." " : "";
	}
    public function sqlUserLoginSearch($valUserLogin)
    {
        return $valUserLogin != 'admin' ? " AND `data`.`login` = '$valUserLogin' " : "";
    }
}
?>