<?php
class ConvertDataEndorseCarInsuranceService
{
	private $_context;
	private $_objEquipment;
	public function __construct($con,$paramsObjMappered)
	{
		$this->_context = $con;
		$this->_objEquipment = new ConvertDataEquipmentCarTextService($this->_context);
		$this->_objEquipment->createDataDecorationEquipment($paramsObjMappered);
		$this->_objEquipment->createDataEndorseDecorationEquipment($paramsObjMappered);
	}
	
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
	private function useWsApiAct($obj)
	{
		return "<a style='padding-left: 0px;padding-right: 0px;padding-left: 0px;padding-right: 0px;border-left-width: 0px;border-right-width: 0px;' class='btn btn-small btn-success' href='$obj->WsPathPolicyAct' target='_blank'>$obj->PactOnline</a>";
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
        if($obj->EndorseStatus == 'Y' && $obj->EndorseStatusTime =='Y')
        {
            $createText .= "<br><font color='red'>$obj->EndorseTimeStartDate</font>";
        }
        return $createText;
    }
    public function customerName($obj)
    {
        $createText = "$obj->Title"."$obj->Name $obj->Last";
        if($obj->EndorseStatus == 'Y' && $obj->EndorseStatusCustomer == 'Y')
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
    public function printAct($obj,$valUseAct)
    {
        $createText = "";
		if($obj->WsPathPolicyAct != '')
		{
			$createText .= $this->useWsApiAct($obj);
		}
        else if($valUseAct == 'Y')
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
        if($obj->EndorseStatus == 'Y' && $obj->EndorseStatusProduct == 'Y')
        {
            $createText .=  "<br><font color='red'>".number_format($obj->EndorseCostProduct,2,'.',',')."</font>";
        }
        return $createText;
    }
    public function equipmentName($obj)
    {
        $createText = $this->_objEquipment->getEquipmentTextCar($obj->IdData);
        
        if($obj->EndorseStatus == 'Y' && $obj->EndorseStatusProduct == 'Y')
        {
            $createText .= "<br><font color='red'>".$this->_objEquipment->getEndorseEquipmentTextCar($obj->IdData)."</font>";
        }
        return $createText != '' ? "$createText" : "ไม่มี";
    }
	public function buttonInformEndorse($obj)
	{
		return "<a type='button' class='btn btn-success btn-small' data-toggle='modal' title='สลักหลัง'  aria-hidden='true' data-target='#modal1' onclick='modal_show(\"#modal1\",\"pages/send_Attached.php?IDDATA=$obj->IdData\");'><i class='icon-white icon-pencil'></i></a>";
	}
}
?>