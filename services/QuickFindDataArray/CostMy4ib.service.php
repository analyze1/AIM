<?php

class CostMy4ib
{
    protected $_conn;

    public function __construct($conn = null)
    {
        $this->_conn = $conn;
    }
    public function getAll(){
        $pre = array();
		$sql = "SELECT id,pre,stamp,tax,cost,net,mo FROM tb_cost";
        $result = $this->_conn->query($sql)->fetchAll(2);
		foreach ($result as $rowPre)
		{
			$pre['PreCost'][$rowPre['id']]= $rowPre['cost'];
			$pre['pre'][$rowPre['id']]= $rowPre['pre'];
			$pre['stamp'][$rowPre['id']]= $rowPre['stamp'];
			$pre['tax'][$rowPre['id']]= $rowPre['tax'];
			$pre['net'][$rowPre['id']]= $rowPre['net'];
			$pre['modelCar'][$rowPre['id']]= $rowPre['mo'];
		}
        return $pre;
    }    
}
