<?php
class CheckFollowUpClaimService
{
    private $_context;
    public function __construct($con)
    {
        $this->_context = $con;
        $this->_context->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //สร้างข้อมูล DataTable Response
    public function createDataFollowUpClaim($modelRes)
    {
        $countClaim = $this->countFollowUpClaim($modelRes);
        $fetchClaim = $this->fetchFollowUpClaim($modelRes);
        $resMapper = $this->mapperDataFollowUpClaimResponse($fetchClaim);

        $res = new FollowUpClaimModelResponse();
        $res->Data->data = $resMapper;
        $res->Data->draw = $modelRes->RequestData['draw'];
        $res->Data->recordsFiltered = $countClaim;
        $res->Data->recordsTotal = $countClaim;
        $res->Status = 200;
        return $res;
    }

    //ดึงข้อมูล ติดตามงานเคลม
    private function fetchFollowUpClaim($modelRes)
    {
        try
        {
            $search = $modelRes->RequestData['search']['value'];
            $sqlDealerClaim = $this->sqlUserSelectClaim($modelRes->UserLogin);
            $sqlOrderBy = $this->sqlOrderBy($modelRes->RequestData);
            $sqlLimit = $this->sqlLimit($modelRes->RequestData);
            $sqlClaim = "SELECT 
            `data`.id_data,
            tb_claimfollow.claim_no,
            tb_claimfollow.informer,
            tb_claimfollow.date_repair,
            tb_claimfollow.cost_estimate,
            tb_claimfollow.detailtext,
            tb_claimfollow.damage,
            tb_claimfollow.timecall,
            tb_claimfollow.id_claim,
            tb_claimfollow.userdetail,
            tb_claimfollow.datefollow
            FROM tb_claimfollow 
            INNER JOIN `data` ON (tb_claimfollow.id_data = `data`.id_data) 
            INNER JOIN detail ON (tb_claimfollow.id_data = detail.id_data) 
            INNER JOIN insuree ON (tb_claimfollow.id_data = insuree.id_data)  
            WHERE (
                `data`.id_data LIKE '%$search%' OR
                tb_claimfollow.claim_no LIKE '%$search%' OR
                tb_claimfollow.informer LIKE '%$search%' OR
                tb_claimfollow.date_repair LIKE '%$search%' OR
                tb_claimfollow.cost_estimate LIKE '%$search%' OR
                tb_claimfollow.detailtext LIKE '%$search%' OR
                tb_claimfollow.damage LIKE '%$search%' OR
                tb_claimfollow.timecall LIKE '%$search%' OR
                tb_claimfollow.id_claim LIKE '%$search%' OR
                tb_claimfollow.userdetail LIKE '%$search%' OR
                tb_claimfollow.datefollow LIKE '%$search%'
            )
            AND `data`.id_data != '' $sqlDealerClaim $sqlOrderBy $sqlLimit";
   
            return $this->_context->query($sqlClaim)->fetchAll(5);
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

    //จำนวนข้อมูล ติดตามงานเคลม
    private function countFollowUpClaim($modelRes)
    {
        try
        {
            $search = $modelRes->RequestData['search']['value'];
            $sqlDealerClaim = $this->sqlUserSelectClaim($modelRes->UserLogin);
            $sqlClaim = "SELECT 
            tb_claimfollow.id
            FROM tb_claimfollow 
            INNER JOIN `data` ON (tb_claimfollow.id_data = `data`.id_data) 
            INNER JOIN detail ON (tb_claimfollow.id_data = detail.id_data) 
            INNER JOIN insuree ON (tb_claimfollow.id_data = insuree.id_data)  
            WHERE (
                `data`.id_data LIKE '%$search%' OR
                tb_claimfollow.claim_no LIKE '%$search%' OR
                tb_claimfollow.informer LIKE '%$search%' OR
                tb_claimfollow.date_repair LIKE '%$search%' OR
                tb_claimfollow.cost_estimate LIKE '%$search%' OR
                tb_claimfollow.detailtext LIKE '%$search%' OR
                tb_claimfollow.damage LIKE '%$search%' OR
                tb_claimfollow.timecall LIKE '%$search%' OR
                tb_claimfollow.id_claim LIKE '%$search%' OR
                tb_claimfollow.userdetail LIKE '%$search%' OR
                tb_claimfollow.datefollow LIKE '%$search%'
            ) AND `data`.id_data != '' $sqlDealerClaim LIMIT 0,1000";
            return $this->_context->query($sqlClaim)->rowCount();
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

    //sql สิทธ์การเรียกข้อมูล
    private function sqlUserSelectClaim($user)
    {
        if ($user == 'admin') 
        {
            return "";
        } else {
            return " AND `data`.`login` = '$user' ";
        }
    }

    //Mapper ติดตามงานเคลม
    private function mapperDataFollowUpClaimResponse($params)
    {
        $res = array();
        $claim_report = 'รายงานติดตามเคลม';
        
        foreach($params as $row => $obj)
        {
            $map = new FollowUpClaimModel();
            $link = '';
            $link = "pages/load_ClaimDetail.php?id=$obj->id_data"; 
            $map->FollowDateSave = $obj->timecall;
            $map->IdData = '<a class="btn btn-info btn-small" onclick="load_page(\'' . $link . '\', \'' . $claim_report . '\')">' . $obj->id_data . '</a>';
            $map->ClaimNo = $obj->claim_no != '' ? $obj->claim_no : 'ไม่ระบุ';
            $map->FollowDetail = $obj->detailtext;
            $map->AppraisalPrice = $obj->cost_estimate;
            $map->AppointmentDate = $obj->datefollow;
            $map->AppointmentDateRepair = $obj->date_repair;
            $map->Informant = $obj->informer;
            $map->Followers = $obj->userdetail;
            $res[$row] = $map;
        }
        return $res;
    }

    //DataTalble ตัวกรองข้อมูล
    private function sqlOrderBy($paramRequest)
	{
		return $paramRequest['order'][0]['column'] !='' && $paramRequest['order'][0]['column'] >= 0 && $paramRequest['order'][0]['dir'] !='' && $paramRequest['columns'][$paramRequest['order'][0]['column']]['name'] !='' ?
		" ORDER BY ".$paramRequest['columns'][$paramRequest['order'][0]['column']]['name']." ".$paramRequest['order'][0]['dir'] : "";
	}

    //DataTable ตัว Limit ข้อมูล
	private function sqlLimit($paramRequest)
	{
		return $paramRequest['start'] !='' && $paramRequest['length'] !='' ?
		" LIMIT ".$paramRequest['start'].",".$paramRequest['length']." " : "";
	}
}
?>