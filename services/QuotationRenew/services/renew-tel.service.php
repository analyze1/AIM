<?php

class RenewDealerControl extends RenewDealerSmsControl
{
    public function __construct($four,$suzuki)
    {
        $this->_contextFour = $four;
        $this->_contextSuzuki = $suzuki;
    }

    protected function checkCusMainTel($model,$modelMain)
    {
        foreach($modelMain as $mo)
        {
            if($mo->Number == $model)
            {
                return (int) $mo->StatusMain;
            }
        }
        return 0;
    }

    public function getTelTableInsure($req)
    {
        try
        {
            $rModelArr = array();
            $telMain = $this->getMainTelNumberCusById($req);
            $str = "SELECT tel_mobi,tel_mobi_2 FROM insuree WHERE id_data = '$req->DataID'";

            $info = $this->_contextSuzuki->query($str)->fetch(5);

            if(count($telMain)>0)
            {
                $a = new RenewTelCustomer();
                $number = preg_replace('/[^0-9]+/iu', '', $info->tel_mobi);
                $a->Number = $number;
                $a->HidenNumber = $this->hidenNumber($number);
                $a->StatusMain = $this->checkCusMainTel($info->tel_mobi,$telMain);
                $a->Detail = 'เบอร์แจ้งงาน';
                
            }
            else
            {
                $a = new RenewTelCustomer();
                $number = preg_replace('/[^0-9]+/iu', '', $info->tel_mobi);
                $a->Number = $number;
                $a->HidenNumber = $this->hidenNumber($number);
                $a->StatusMain = 1;
                $a->Detail = 'เบอร์แจ้งงาน';
            }
            
            $rModelArr[] = $a;

            if($info->tel_mobi_2!='')
            {
                foreach (explode('|',$info->tel_mobi_2) as $val)
                {
                    if($val!=null)
                    {
                        $arr = explode('/',$val);
                        $number = preg_replace('/[^0-9]+/iu', '', $arr[1]);
                        $b = new RenewTelCustomer();
                        $b->Number = $number;
                        $b->HidenNumber = $this->hidenNumber($number);
                        $b->Detail = $arr[0];
                        $b->StatusMain = $this->checkCusMainTel($number,$telMain);
                        $rModelArr[] = $b;
                    }
                }
            }
            return $rModelArr;
        }
        catch(Exception $e)
        {
            return $e;
        }

    }

    public function getTelTableInsurePayment($req)
    {
        try
        {
            $rModelArr = array();
            $telMain = $this->getMainTelNumberCusById($req);
            $str = "SELECT tel_mobile,tel_mobile2 FROM insuree WHERE id_data = '$req->DataID'";
            
            $info = $this->_contextFour->query($str)->fetch(5);

            if(count($telMain)>0)
            {
                $a = new RenewTelCustomer();
                $number = preg_replace('/[^0-9]+/iu', '', $info->tel_mobile);
                $a->Number = $number;
                $a->HidenNumber = $this->hidenNumber($number);
                $a->StatusMain = $this->checkCusMainTel($info->tel_mobile,$telMain);
                $a->Detail = 'เบอร์แจ้งงาน';
                
            }
            else
            {
                $a = new RenewTelCustomer();
                $number = preg_replace('/[^0-9]+/iu', '', $info->tel_mobile);
                $a->Number = $number;
                $a->HidenNumber = $this->hidenNumber($number);
                $a->StatusMain = 1;
                $a->Detail = 'เบอร์แจ้งงาน';
            }
            
            $rModelArr[] = $a;

            if($info->tel_mobile2!='' && $info->tel_mobile2!='-')
            {
                foreach (explode('|',$info->tel_mobile2) as $val)
                {
                    if($val!=null)
                    {
                        $arr = explode('/',$val);
                        $number = preg_replace('/[^0-9]+/iu', '', $arr[1]);
                        $b = new RenewTelCustomer();
                        $b->Number = $number;
                        $b->HidenNumber = $this->hidenNumber($number);
                        $b->Detail = $arr[0];
                        $b->StatusMain = $this->checkCusMainTel($number,$telMain);
                        $rModelArr[] = $b;
                    }
                }
            }
            return $rModelArr;
        }
        catch(Exception $e)
        {
            return $e;
        }

    }
}




?>