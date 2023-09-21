<?php

class CheckAmountResolveRenewSuzuki
{
    private $_contextFour = null;
    private $_contextAccount = null;
    private $_lastInsertLogViriyah;

    public function __construct($four,$account)
    {
        $this->_contextFour = $four;
        $this->_contextAccount = $account;
    }

    private function convertCharToInt($x)
    {
        return str_replace(',','',$x);
    }

    private function getTempViriyah($value)
    {
        $ch = $this->_contextFour->query("SELECT Id,id_data_old FROM LogPaymentCreditViriyahSuzukiRenew 
        WHERE
            id_data_old = '$value->DataOldID'")
            ->fetch(2);
        if($ch == null) return false;
        
        $this->_contextFour->prepare("UPDATE LogPaymentCreditViriyahSuzukiRenew 
            SET id_data_new = :New WHERE id_data_old = :Id")
            ->execute(array(
                'New'=> $value->DataNewID,
                'Id'=> $value->DataOldID
            ));

        $str = "SELECT
                Id,
                id_data_old,
                id_data_new,
                ReturnSMS,
                BankName,
                NameOnCard,
                CardNo,
                Amount,
                AmountWords,
                Relation,
                ApprovalDate,
                ApprovalTime,
                ImgFileName,
                EmiPhone,
                OptionCredit,
                DateReturn,
                TypeCredit,
                InstallmentRound,
                TypeCard,
                PhoneOwnerCard,
                MoneyMonthPayment,
                PicFileName,
                ExpCard,
                TypeWork,
                CreditNoAccount,
                IdRenew 
            FROM
                LogPaymentCreditViriyahSuzukiRenew 
            WHERE
                id_data_old = '$value->DataOldID'";
        $n = $this->_contextFour->query($str)->fetch(5);
        if($n == null) return false;
        return $n;

    }

    private function insesrtToLogViriyahPaymentFour($v)
    {
        $sql = "INSERT INTO LogPaymentCreditViriyah (id_data,ReturnSMS,BankName,NameOnCard,CardNo,Amount,AmountWords,Relation,
        ApprovalDate,ApprovalTime,ImgFileName,OptionCredit,TypeCredit,InstallmentRound,
        TypeCard,PhoneOwnerCard,MoneyMonthPayment,PicFileName,Expcard,TypeWork) VALUES (:id_data,:ReturnSMS,
        :BankName,:NameOnCard,:CardNo,:Amount,:AmountWords,:Relation,:ApprovalDate,:ApprovalTime,:ImgFileName,
        :OptionCredit,:TypeCredit,:InstallmentRound,:TypeCard,:PhoneOwnerCard,:MoneyMonthPayment,:PicFileName,
        :Expcard,:TypeWork)";

        $param = array(
            'id_data'=> $v->id_data_new,
            'ReturnSMS'=> $v->ReturnSMS,
            'BankName'=> $v->BankName,
            'NameOnCard'=> $v->NameOnCard,
            'CardNo'=> $v->CardNo,
            'Amount'=> $v->Amount,
            'AmountWords'=> $v->AmountWords,
            'Relation'=> $v->Relation,
            'ApprovalDate'=> $v->ApprovalDate,
            'ApprovalTime'=> $v->ApprovalTime,
            'ImgFileName'=> $v->ImgFileName,
            'OptionCredit'=> $v->OptionCredit,
            'TypeCredit'=> $v->TypeCredit,
            'InstallmentRound'=> $v->InstallmentRound,
            'TypeCard'=> $v->TypeCard,
            'PhoneOwnerCard'=> $v->PhoneOwnerCard,
            'MoneyMonthPayment'=> $v->MoneyMonthPayment,
            'PicFileName'=> $v->PicFileName,
            'Expcard'=> $v->ExpCard,
            'TypeWork'=> $v->TypeWork
            );

        $r = $this->_contextFour->prepare($sql)->execute($param);
        $this->_lastInsertLogViriyah = $this->_contextFour->lastInsertId();
        return $r;
    }

    private function checkActAndInsure($id)
    {
        $str = "SELECT pre,prb_net,total_prb,total_commition,prb FROM premium WHERE id_data = '$id'";
        $x = $this->_contextFour->query($str);
        return $x->fetch(5);
    }

    private function updateCrNoTableLogViriyah($crNumber)
    {
        $str = "UPDATE LogPaymentCreditViriyah SET CreditNoAccount = '$crNumber' WHERE Id = '{$this->_lastInsertLogViriyah}'";
        return $this->_contextFour->prepare($str)->execute();
    }
    
    private function createKeyRun()
    {
        // เอกสารนำส่งใหม่ ทำการเจนเลขใหม่เข้าตาราง
        $typecredit = 'CR';
        $dateSub = substr(intval(date('Y')), 2, 2) . date('m');

        $str = " SELECT cr_no FROM tb_credit WHERE cr_no LIKE '$typecredit%$dateSub%' ORDER BY cr_no DESC LIMIT 1";

        $que_gn = $this->_contextAccount->query($str);
        $res_gn = $que_gn->fetch();
        $rescreid = $res_gn['cr_no'];
        $creid_split = substr($rescreid, 6, 3);

        if ($creid_split == "") 
        {
            $cred_no = 1;
        } 
        else 
        {
            $cred_no = $creid_split + 1;
        }

        $creditNo = $typecredit . substr(intval(date('Y')), 2, 2) . date('m') . sprintf('%03d', $cred_no);

        //เจนเลขเสร็จ รีเทรินออกไปใช้
        return $creditNo;
    }
    
    private function saveTbCredit($keyRun,$i,$comData)
    {
        $strCreditMain = "INSERT INTO tb_credit (`cr_no`,`cr_comp`,`cr_date`,`cr_value`,`cr_status`,`cr_empsave`,`cr_dateupdate` ) 
        VALUES (:cr_no, :cr_comp, :cr_date, :cr_value, :cr_status, :cr_empsave, :cr_dateupdate)"; 

        $params = array(
            'cr_no'=> "$keyRun", 
            'cr_comp'=> "$comData", 
            'cr_date'=> "$i->ApprovalDate", 
            'cr_value'=> "$i->Amount", 
            'cr_status'=> "N", 
            'cr_empsave'=> "AONG", 
            'cr_dateupdate'=> date('Y-m-d H:i:s'));
            $result = $this->_contextAccount->prepare($strCreditMain)->execute($params);
    }

    private function concatYear($d)
    {
        //กลับด้านวันเดือนปี ทำการแปลง 2564 เป็น 2021 และจัดฟอร์มลง table
        $e = explode('/',$d);
        return substr(date('Y'),0,2).$e[1].'-'.$e[0].'-01';
    }

    //เก็บลง table insuree ดูรายละเอียดลูกค้าชำระผ่านบัตรเครดิต
    private function saveInfoCreditToInsuree($valArr)
    {
        $v = (object) $valArr;
        $sql = "UPDATE insuree SET creditno = '$v->number' , 
        creditowner = '$v->type', 
        creditownname = '$v->relaytion', 
        creditbank = '$v->bank', 
        creditexpire = '$v->exp' WHERE id_data = '$v->dataID'";
        return $this->_contextFour->prepare($sql)->execute();
    }

    private function saveTbCreditDetailInstallment($keyRun,$v,$money,$monthPrice)
    {
        $acOwner = $v->PicFileName != ''?2:1;

        $strIn = " INSERT INTO tb_credit_detail (`cr_no`,`crd_st_refer`,`crd_refer`,`crd_action`,`crd_value`,`crd_bank`,`crd_cardno`,
        `crd_owner`,`crd_expired`,`crd_approve`,`crd_status`,`cr_percent`,`cr_month`,`cr_amount`,`cr_branch`,
        `CreditWorker`) VALUES (:cr_no, :crd_st_refer, :crd_refer, :crd_action, :crd_value, :crd_bank, :crd_cardno, :crd_owner, 
        :crd_expired, :crd_approve, :crd_status, :cr_percent, :cr_month, :cr_amount, :cr_branch, :CreditWorker)";

        $params = array(
        'cr_no'=>"$keyRun",
        'crd_st_refer'=>"1",
        'crd_refer'=>"$v->id_data_new",
        'crd_action'=>"$acOwner",
        'crd_value'=>"$money",
        'crd_bank'=>"$v->BankName",
        'crd_cardno'=>"$v->CardNo",
        'crd_owner'=>"$v->Relation",
        'crd_expired' => $this->concatYear($v->ExpCard),
        'crd_approve'=>"",
        'crd_status'=>"N",
        'cr_percent'=>"0",
        'cr_month'=>"$v->InstallmentRound",
        'cr_amount'=>$monthPrice,
        'cr_branch'=>"",
        'CreditWorker'=>"FOUR");

        $resDe = $this->_contextAccount->prepare($strIn)->execute($params);//save to table

        //map arr ข้อมูลบัตรไปเก็บที่ insuree เพื่อแสดงบน check list view 4
        $crIn = array();
        $crIn['number'] = "$v->CardNo";
        $crIn['type'] = "$acOwner";
        $crIn['relaytion'] = "$v->Relation";
        $crIn['bank'] = "$v->BankName";
        $crIn['exp'] = $this->concatYear($v->ExpCard);
        $crIn['dataID'] = "$v->id_data_new";
        $this->saveInfoCreditToInsuree($crIn);

        return $resDe;
    }

    private function saveTbCreditDetail($keyRun,$v,$money)
    {
        $acOwner = $v->PicFileName != ''?2:1;

        $strIn = "INSERT INTO tb_credit_detail (`cr_no`,`crd_st_refer`,`crd_refer`,`crd_action`,`crd_value`,`crd_bank`,`crd_cardno`,
        `crd_owner`,`crd_expired`,`crd_status`,`CreditWorker`) VALUES (:cr_no, :crd_st_refer, :crd_refer, :crd_action, :crd_value, 
        :crd_bank, :crd_cardno, :crd_owner, :crd_expired, :crd_status, :CreditWorker)";
            
        $params = array('cr_no'=>"$keyRun",
        'crd_st_refer'=>"1",
        'crd_refer'=>"$v->id_data_new",
        'crd_action'=>"$acOwner",
        'crd_value'=>"$money",
        'crd_bank'=>"$v->BankName",
        'crd_cardno'=>"$v->CardNo",
        'crd_owner'=>"",
        'crd_expired'=> $this->concatYear($v->ExpCard),
        'crd_status'=>"N",
        'CreditWorker'=>"FOUR");

        $resDe = $this->_contextAccount->prepare($strIn)->execute($params);
        return $resDe;
    }

    public function checkAndInsertInstallmentSuToFour($req)//เข้า main หลัก
    {
        try
        {
            if($req->TypeInsurance!='VIB_S') return false;//เช็คว่าประกันเป็นของ วิริยะหรือเปล่า
        
            $infoTemp = $this->getTempViriyah($req);//ดึงข้อมูล temp บัตรเครดิตลูกค้าที่เก็บไว้

            if($infoTemp == false) return $infoTemp;//ถ้าว่าง ออก

            $this->insesrtToLogViriyahPaymentFour($infoTemp);//บันทึกลง ตารางงาน four

            $checkResult = $this->checkActAndInsure($infoTemp->id_data_new);//เช็คว่ามีการซื้ออะไรบ้าง

            $keyRun = $this->createKeyRun();//เช็คตัวเลข ไฟแนนซ์ แล้วเจนใหม่

            $this->saveTbCredit($keyRun,$infoTemp,$req->TypeInsurance);//บึกทึกลง เครดิตรวม base account 

            $this->updateCrNoTableLogViriyah($keyRun);//อัพเดท แล cr ของไฟแนนซ์ให้กับข้อมูลเก็บบัตรเครดิต

            if($this->convertCharToInt($checkResult->prb_net)>1)//ถ้ามีการซื้อ พ.ร.บ. บันทึก list tb_credit detail
            {
                $priceAct = $this->convertCharToInt($checkResult->prb);//แปลงราคา พ.ร.บ. เต็มจำนวน
                $this->saveTbCreditDetail($keyRun,$infoTemp,$priceAct);//บันทึก tb_credit_detail แบบเต็มไม่ผ่อน
            }

            if($this->convertCharToInt($checkResult->pre)>1)//ถ้ามีการซื้อประกัน บันทึก list tb_credit detail
            {
                $p = $this->convertCharToInt($checkResult->total_commition) - $this->convertCharToInt($checkResult->prb);//ยอดเต็มลบพ.ร.บ.
                $m = $p / $infoTemp->InstallmentRound;//ยอดหักพ.ร.บ.หารเดือน
                $this->saveTbCreditDetailInstallment($keyRun,$infoTemp,$p,$m);//$keyRun,$v,$money,$monthPrice
            }

            return true;
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

    
}







?>