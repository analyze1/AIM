<?php
class MapperCarInsuranceInformationService
{
    public function dataCarInsurance($param)
    {
        $resMapModel = array();
        foreach ($param as $row => $datas)
        {
            $map = new MapperCarInsuranceInformationModel();
            $map->PolicyActNo = "$datas[p_act]";
            $map->TmpActId = "$datas[tmp_act_id]";
            $map->PactOnline = "$datas[PactOnline]";
            $map->WsPathPolicyAct = "$datas[ws_path_policy]";
            $map->IdData = "$datas[id_data]";
            $map->StatusSendEmail = "$datas[Status_Email]";
            $map->Advance = "$datas[Advance]";
            $map->SendDate = "$datas[send_date]";
            $map->StartDate = "$datas[start_date]";
            $map->EndDate = "$datas[end_date]";
            $map->Title = "$datas[title]";
            $map->Name = "$datas[name]";
            $map->Last = "$datas[last]";
            $map->WsActStatus = "$datas[ws_prb_status]";
            $map->Person = "$datas[person]";
            $map->CarBodyNo = "$datas[car_body]";
            $map->CarMotorNo = "$datas[n_motor]";
            $map->IdCarBrand = "$datas[br_car]";
            $map->IdCarModel = "$datas[mo_car]";
            $map->IdCarModelSub = "$datas[mo_sub]";
            $map->AddPrice = "$datas[add_price]";
            $map->CarDetail = "$datas[car_detail]";
            $map->CarModelName = "$datas[CarModelName]";
            $map->CarModelSubName = ""; //$datas[CarModelSubName]
            $map->Net = "$datas[net]";
            $map->Cost = "$datas[costCost]";
            $map->EndorseStatus = "$datas[Req_Status]";
            $map->EndorseStatusAct = "$datas[EditAct]";
            $map->EndorsePolicyActNo = "$datas[EditAct_id]";
            $map->EndorseStatusTime = "$datas[EditTime]";
            $map->EndorseTimeStartDate = "$datas[EditTime_StartDate]";
            $map->EndorseTimeEndDate = "$datas[EditTime_EndDate]";
            $map->EndorseStatusCar = "$datas[EditCar]";
            $map->EndorseCarBodyNo = "$datas[Edit_CarBody]";
            $map->EndorseCarMotorNo = "$datas[Edit_Nmotor]";
            $map->EndorseCarColor = "$datas[Edit_CarColor]";
            $map->EndorseStatusCustomer = "$datas[EditCustomer]";
            $map->EndorseTitle = "$datas[Cus_title]";
            $map->EndorseName = "$datas[Cus_name]";
            $map->EndorseLast = "$datas[Cus_last]";
            $map->EndorseStatusProduct = "$datas[EditProduct]";
            $map->EndorseProduct = "$datas[Product]";
            $map->EndorseCostProduct = "$datas[CostProduct]";
            $resMapModel[$row] = $map;
        }
        return $resMapModel;
    }
}
?>