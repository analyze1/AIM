<?php

class RenewDealerSmsControl
{
    protected $_contextFour;
    protected $_contextSuzuki;

    public function __construct($four,$suzuki)
    {
        $this->_contextFour = $four;
        $this->_contextSuzuki = $suzuki;
    }

    protected function hidenNumber($number)
    {
        return substr($number,0,3).'XXXX'.substr($number,7,3);
    }

    public function checkMainTel($numb)
    {
        $str = "SELECT * FROM MainTelephoneCustomer WHERE DataID = '$numb'";
        $x = $this->_contextSuzuki->query($str);
        if($x->rowCount()==0) return false;
        return $x->fetchAll(5);
    }

    public function addNumberMain($id,$tel)
    {
        $str = "INSERT INTO MainTelephoneCustomer (Telephone,DataID,Main) VALUES (:Telephone, :DataID, :Main)";
        return $this->_contextSuzuki->prepare($str)->execute(array(
            'Telephone'=> $tel,
            'DataID'=> $id,
            'Main'=> 1,
        ));

    }

    public function getMainTelNumberCusById($req)
    {
        $chkNumb = $this->checkMainTel($req->DataID);
        if($chkNumb == false)
        {
            $str = "SELECT tel_mobi,tel_mobi_2 FROM insuree WHERE id_data = '$req->DataID'";
            $info = $this->_contextSuzuki->query($str)->fetch(5);
            $tel = preg_replace('/[^0-9]+/iu', '', $info->tel_mobi);
            if(strlen($tel) ==10)
            {
                $this->addNumberMain($req->DataID,$tel);
            }
            $mRes = new RenewCusmodel();
            $mRes->Number = $tel;
            $mRes->StatusMain = 1;
            return array($mRes);
        }
        else
        {
            $a = array();
            foreach($chkNumb as $c)
            {
                $mRes = new RenewCusmodel();
                $mRes->Number = $c->Telephone;
                $mRes->StatusMain = (int) $c->Main;
                $a[] = $mRes;
            }

            return $a;
        }
    }
}















?>