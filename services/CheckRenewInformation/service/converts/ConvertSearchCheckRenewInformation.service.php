<?php
class ConvertSearchCheckRenewInformationService
{
    public function searchAll($paramRequest)
	{
		return $paramRequest['search']['value'];
	}
    public function sqlOrderBy($paramRequest)
	{
		return $paramRequest['order'][0]['column'] !='' && $paramRequest['order'][0]['column'] >= 0 && $paramRequest['order'][0]['dir'] !='' && $paramRequest['columns'][$paramRequest['order'][0]['column']]['name'] !='' ?
		" ORDER BY ".$paramRequest['columns'][$paramRequest['order'][0]['column']]['name']." ".$paramRequest['order'][0]['dir'] : "";
	}
	public function sqlLimit($paramRequest)
	{
		return $paramRequest['start'] !='' && $paramRequest['length'] !='' ?
		" LIMIT ".$paramRequest['start'].",".$paramRequest['length']." " : " LIMIT 0,10 ";
	}

    public function sqlUserFollow($valUser)
    {
        return $valUser != "admin" ? " AND `data`.`login` = '$valUser'" : "";//AND detail_renew.userdetail = '$valUser'
    }
}
?>