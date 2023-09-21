<?php
class ConvertDataCarInsuranceService
{
    private function checkActApiPrint($actHandle,$actApi)
    {
        if($actHandle != '-')
        {
            $_act = explode('-',$actHandle);
            if($_act[2]=='9999999' && $actApi!='')
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return true;
        }
    }
    private function useAct($obj)
    {
        $createText = "";
        if(!empty($obj->TmpActId))
        {
            $createText .= "<center><a style='padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-info' href='$obj->WsPathPolicyAct' target='_blank'>$obj->TmpActId</a></center>";
        }
        else if($obj->PolicyActNo != '')
        {
            $createText .= "<center><a style='padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-info'href='print/print_Act.php?IDDATA=$obj->IdData' target='_blank'>$obj->PolicyActNo</a></center>";
            if($obj->EndorseStatusAct == 'Y')
            {
                $createText .= "<center><a style='color:red !important;padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-info' href='print/print_Act.php?IDDATA=$obj->IdData' target='_blank'>$obj->EndorsePolicyActNo</a></center>";
            }
        }
        else
        {
            $createText .= "<center><a style='padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-info' onclick=\"load_page('ajax/ajax_realtime_webservice_prb.php?iddata=$obj->IdData','WEBSERVICE PRB');\" href='javascript:0'>ออก พ.ร.บ.</a></center>";
        }
        return $createText;
    }
    private function notUseAct($obj)
    {
        $createText = "";

        /*----เช็ค API ว่าเจนไม่ได้แน่ๆ----*/
        if($obj->WsActStatus == 'N')
        {
            $createText = "<center><button class='btn btn-small btn-danger'>$obj->PolicyActNo</button></center>";
            return $createText;
        }
        else if($this->checkActApiPrint($obj->PolicyActNo,$obj->PactOnline) == false)
        {
            $createText = "<center><a style='padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-info' href='print/print_Act.php?IDDATA=$obj->IdData' target='_blank'>$obj->PolicyActNo</a></center>";
            if($obj->EndorseStatusAct == 'Y')
            {
                $createText .= "<center><a style='color:red !important;padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-info' href='print/print_Act.php?IDDATA=$obj->IdData' target='_blank'>$obj->EndorsePolicyActNo</a></center>";
            }
            return $createText;
        }
        else
        {
            $createText = "<div class='btn-api-center'>-</div>";
            return $createText;
        }
        
        /*----PRB ONLINE API ตั้งป้อมแสดงปุ่ม----*/
        if($obj->WsPathPolicyAct == '')
        { 
            $createText = "<div class='btn-api-center'>-</div>";
            return $createText;
        }
        else
        {
            $createText = "<a style='padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-success' href='$obj->WsPathPolicyAct' target='_blank'>$obj->PactOnline</a>";
            return $createText;
        }
    }
    public function numberMoney($value)
    {
        $numberOnly = preg_replace('/[^0-9\.]/','',$value);
        return number_format($numberOnly,2,'.',',');
    }
    public function numberBodyAndMotor($obj)
    {
        $createText = $obj->CarBodyNo."<br>".$obj->CarMotorNo;
        if($obj->EndorseStatus == 'Y' && $obj->EndorseStatusCar == 'Y')
        {
            $createText .= "<br><font color='red'>".$obj->EndorseCarBodyNo."<br>".$obj->EndorseCarMotorNo."</font>";
        }
        return $createText;
    }
    public function carModel($obj)
    {
        return "$obj->CarModelName<br>$obj->CarModelSubName";
    }
    public function protectionDate($obj)
    {
        $createText = "$obj->StartDate";
        if($obj->EndorseStatus == 'Y' && $obj->EndorseStatusTime =='Y' && $obj->StartDate != $obj->EndorseTimeStartDate)
        {
            $createText .= "<br><font color='red'>$obj->EndorseTimeStartDate</font>";
        }
        return $createText;
    }
    public function customerName($obj)
    {
        $createText = "$obj->Title"."$obj->Name $obj->Last";
        if($obj->EndorseStatus == 'Y' && $obj->EndorseStatusCustomer == 'Y' && ($obj->Title != $obj->EndorseTitle || $obj->Name != $obj->EndorseName || $obj->Last != $obj->EndorseLast))
        {
            $createText .= "<br><font color='red'>$obj->EndorseTitle"."$obj->EndorseName $obj->EndorseLast</font>";
        }
        return $createText;
    }
    public function buttonInformOnline($obj)
    {
        $createText = "";
        if($obj->Advance == 'Y')
        {
            $createText .= "<a data-toggle='modal' class='btn btn-small btn-warning' onclick='open_check(\"pages/send_Check.php?IDDATA=$obj->IdData\");' aria-hidden='true' data-target='#modal'>$obj->IdData</a>";
        }
        else
        {
            $createText .= "<a data-toggle='modal' class='btn btn-small btn-info' onclick='open_check(\"pages/send_Check.php?IDDATA=$obj->IdData\");' aria-hidden='true' data-target='#modal'>$obj->IdData</a>";
        }
        return $createText;
    }
    public function iconSendMail($obj)
    {
        $createText = "";
        if($obj->StatusSendEmail == 'T')
        {
            $createText .= "<center><i class='icon-white icon-ok'></i></center>";
        }
        else
        {
            $createText .="<center><i class='icon-white icon-remove'></i></center>";
        }
        return $createText;
    }
    public function printInsuranceApplicationForm($obj,$valUserLogin)
    {
        $createText = "";
        if($obj->WsPathPolicyAct == '' && $obj->WsActStatus == 'N' && $valUserLogin == 'admin')
        {
            $createText .="<button class='btn btn-primary btn-small' title='ส่ง Smart พ.ร.บ. อีกครั้ง' onclick='ResolveAPIAct(\"$obj->IdData\");'>API</button>";
        }
        if($obj->StatusSendEmail == 'T')
        {
            $createText .= "<a class='btn btn-success btn-small' title='ใบคำขอประกันภัย' rel='tooltip' onclick='print_Insurance_new(\"$obj->IdData\");'><i class='icon-white icon-print'></i> </a>";
        }
        else
        {
            $createText .= "";
        }
        return $createText;
    }
    public function printWsApiAct($obj)
    {
        $createText = "";
        if($obj->WsPathPolicyAct == '')
		{ 
			$createText .= "<div class='btn-api-center'>-</div>";
		}
		else
		{
			$createText .= "<a style='padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-success' href='$obj->WsPathPolicyAct' target='_blank'>$obj->PactOnline</a>";
		}
        return $createText;
    }
    public function printAct($obj,$valUseAct)
    {
        $createText = "";
        if($valUseAct == 'Y')
	    {
            $createText .= $this->useAct($obj);
	    }
        else
        {
            $createText .= $this->notUseAct($obj);
        }
        return $createText;
    }
    public function equipmentPremiumAdd($obj)
    {
        $createText = number_format($obj->AddPrice,2,'.',',');
        if($obj->EndorseStatus == 'Y' && $obj->EndorseStatusProduct == 'Y' && $obj->AddPrice != $obj->EndorseCostProduct)
        {
            $createText .=  "<br><font color='red'>".number_format($obj->EndorseCostProduct,2,'.',',')."</font>";
        }
        return $createText;
    }
    public function equipmentName($obj,$objConvertEqu)
    {
        $createText = $objConvertEqu->getEquipmentTextCar($obj->IdData);
        if ($createText == '') 
        {
            return 'ไม่มี';
        }
        $createText = "<br><font data-tooltip='$createText' style='white-space: pre;'>เพิ่มเติม <i class='icon-white icon-search'></i></font>";
        if($obj->EndorseStatus == 'Y' && $obj->EndorseStatusProduct == 'Y' && $obj->CarDetail != $obj->EndorseProduct)
        {
            $createText .= "<br><font color='red' data-tooltip=''>".$objConvertEqu->getEndorseEquipmentTextCar($obj->IdData)."</font>";
        }
        return $createText != '' ? "$createText" : "ไม่มี";
    }
    public function searchCost($id) {
        $sql = "SELECT cost FROM tb_cost WHERE id = '$id'" ;
        $query = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetch(2); 

        return $query;
    }
    public function searchNet($id) {
        $sql = "SELECT net FROM tb_cost WHERE id = '$id'" ;
        $query = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetch(2); 

        return $query;
    }
    public function searchModel($id) {
        $sql = "SELECT `name` FROM tb_mo_car WHERE id = '$id'" ;
        $query = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetch(2); 

        return $query;
    }
}
?>