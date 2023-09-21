<?php

class CheckAmountResolveRenewFour
{
    private $_contextFour = null;
    private $_contextAccount = null;

    public function __construct($four,$account)
    {
        $this->_contextFour = $four;
        $this->_contextAccount = $account;
    }

    public function checkPriceInsuranceRenewByDataOld($req)//:CheckPaymentRenewFourModelRequest
    {
        if($req->TypeInsurance!='VIB_S') return false;//เช็คว่าประกันเป็นของ วิริยะหรือเปล่า
        $logInTable = $this->getLogPaymentViriyah($req);
        if(!$logInTable) return false;
        //อัพเดทฝั่งการเงิน
        $res = $this->updateAccountTbCredit($req->DataNewID,$logInTable->CreditNoAccount);
        if(!$res) return false;
        //อัพเดท ตารางเก็บบัตร วิริยะ
        $res = $this->updateLogPaymentViriyah($req->DataNewID,$req->DataOldID,$logInTable->Id);
        if(!$res) return false;
        //เอาข้อมูลบัตรที่อยู่ใน insuree ไปอัพเดทให้งานใหม่
        $res = $this->updateCreditCardInfoOnInsuree($req->DataNewID,$req->DataOldID);
        if(!$res) return false;
        return true;
    }

    private function getLogPaymentViriyah($req)//:CheckPaymentRenewFourModelRequest
    {
        //ดูว่ายอดเงินที่จ่ายมา นั้น ตรงกับยอดเงินที่เสนอราคาหรือเปล่า
        //ตอนนี้มีประเด็นการแจ้งงานที่เมื่อ มีการแจ้งพรบ ร่วมด้วย แต่ใบเตือนเก็บเงินมาแค่ประกันภัย ระบบจะไม่สามารถจับยอกเงินได้เนื่องจากไม่ตรงกัน
        $str = "SELECT CreditNoAccount,Id FROM LogPaymentCreditViriyah WHERE id_data='$req->DataOldID' AND Amount='$req->Price'";
        $result = $this->_contextFour->query($str)->fetch(5);
        if($result==null) return false;
        return $result;
    }

    private function updateLogPaymentViriyah($new,$old,$id)//:boolean
    {
        //อัพเดท เอาเลขรับแจ้งใหม่เข้าไปแทน แล้วเอาเลขเดิมไปลงอีกที่นึง
        $strLog = "UPDATE LogPaymentCreditViriyah SET id_data='$new', id_data_old = '$old' WHERE Id = '$id'";
        $r = $this->_contextFour->prepare($strLog)->execute();
        return $r;

    }

    private function updateAccountTbCredit($new,$creditID)//:boolean
    {
        //อัพเดท ฝ่ายการเงินเอาเลขรับแจ้งงานใหม่เข้าไปอัพเดทแทนงานเดิม 
        $strDetail = "UPDATE tb_credit_detail SET crd_refer = '$new' WHERE cr_no = '$creditID'";
        $r = $this->_contextAccount->prepare($strDetail)->execute();
        return $r;
    }

    private function updateCreditCardInfoOnInsuree($new,$old)//:boolean
    {
        //อัพเดทจาก insuree เก่าไปที่ใหม่ ข้อมูลบัตรลูกค้า

        $strOldIn = "SELECT creditno,creditowner,creditownname,creditbank,creditexpire FROM insuree WHERE id_data = '$old'";
        $cardCus = $this->_contextFour->query($strOldIn)->fetch(5);

        $insureUp = "UPDATE insuree SET creditno = :creditno, creditowner = :creditowner, creditownname = :creditownname, 
        creditbank = :creditbank, creditexpire = :creditexpire WHERE id_data = :id_data";

        $params = array(
            'creditno'=> $cardCus->creditno,
            'creditowner'=> $cardCus->creditowner,
            'creditownname'=> $cardCus->creditownname,
            'creditbank'=> $cardCus->creditbank,
            'creditexpire'=> $cardCus->creditexpire,
            'id_data'=> $new
        );

        $r = $this->_contextFour->prepare($insureUp)->execute($params);

        return $r;
    }
}



?>