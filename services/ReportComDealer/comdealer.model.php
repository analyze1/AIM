<?php
class CalculateDealerBenefitModel
{
    public $Prb;
    public $PrbTotal;
    public $Pre;
    public $PreTotal;
    public $Other;
    public $CustomerGrand;
    public $DateSend;
    public $DateReceive;
    public $priceComDelaer;
    public $StartDate;
    public $ComData;
    public $DataID;
    public $NameFull;
    public $CarRegis;

    protected function repl($x)
    {
        if (empty($x)) return 0;
        return str_replace(',', '', $x);
    }

    public function mapperReq($premium, $invoice, $com)
    {
        $this->StartDate = $premium['start_date'];
        $this->Prb = repl($premium['prb_net']);
        $this->PrbTotal = repl($premium['prb']);
        $this->Pre = repl($premium['total_pre']);
        $this->PreTotal = repl($premium['total_sum']);
        $this->Other = repl($premium['commition']) + repl($premium['other']);
        $this->CustomerGrand = repl($invoice['grand']);
        $this->DateSend = repl($invoice['certificate_datestamp']);
        $this->DateReceive = repl($invoice['certificate_date']);
        $this->ComData = $premium['com_data'];
        $this->DataID = $premium['id_data'];
        $this->CarRegis = $premium['car_regis'];
        $this->NameFull = "{$premium['title']} {$premium['name']} {$premium['last']}";
        $this->priceComDelaer = $com;
    }
}

class CalculateDealerBenefitModelResponse extends CalculateDealerBenefitModel
{
    public $Commition;
    public $SendTotal;
    public $CustomerPrice;
    public $ReceiveDealer;
}