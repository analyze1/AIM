<?php
Class CustomerNameService
{
    private $_context;
    public function __construct($con)
    {
        $this->_context = $con;
    }
    public function getLastName($value)
    {
        $this->_context->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try
        {
            $fetchCus = $this->_context->query("SELECT SubTitleName,CenterTitleName,TitleLastName FROM TitleDetail WHERE SubTitleName = '$value' AND StatusUse = '0' ")->fetch(5);
            $res = array(
                'LastCompany' => "$fetchCus->TitleLastName",
                'ByCustomer' => "$fetchCus->CenterTitleName"
            );
        }
        catch(Exception $e)
        {
            $res = array(
                'MessageError' => $e->getMessage(),
                'Server' => 500
            );
        }
        echo json_encode($res);
    }
}
?>