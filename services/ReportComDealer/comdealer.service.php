<?php

class CalculateDealerBenefitControl
{
    private $_context4;
    private $_contextSu;
    public function __construct($con4 = null, $consu = null)
    {
        $this->_context4 = $con4;
        $this->_contextSu = $consu;
    }

    public function calculateCustomer($premiumTable, $invoiceTable, $comdealer)
    {
        $modelRes = new CalculateDealerBenefitModelResponse();
        $model = new CalculateDealerBenefitModel();
        $model->mapperReq($premiumTable, $invoiceTable, $comdealer);

        $modelRes->NameFull = $model->NameFull;
        $modelRes->StartDate = $model->StartDate;
        $modelRes->ComData = $model->ComData;
        $modelRes->DataID = $model->DataID;
        $modelRes->CarRegis = $model->CarRegis;
        $modelRes->Pre = $model->Pre;
        $modelRes->PreTotal = $model->PreTotal;
        $modelRes->PrbTotal = $model->PrbTotal;
        $modelRes->Commition = $this->getCommition($model->Pre, $model->Prb, $comdealer);
        $modelRes->SendTotal = $this->calTotalSend($model->PreTotal, $model->PrbTotal, $modelRes->Commition);
        $modelRes->CustomerPrice = $model->CustomerGrand;
        $modelRes->ReceiveDealer = $this->calDealerReceive($model->CustomerGrand, $modelRes->SendTotal);
        $modelRes->DateSend = $model->DateSend;
        $modelRes->DateReceive = $model->DateReceive;

        // echo json_encode($modelRes);
        // exit;
        return $modelRes;
    }

    public function calDealerReceive($cus, $send)
    {
        return $cus - $send;
    }

    public function getCommition($pre, $prb, $compre)
    {
        $p = ($pre * $compre) / 100;
        $a = ($prb * 12) / 100;
        return $p + $a;
    }

    public function calTotalSend($pre, $prb, $com)
    {
        return ($pre + $prb) - $com;
    }
}