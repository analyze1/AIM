<?php
include "IConvertDataUserLogin.service.php";
class ConvertDataUserLoginService implements IConvertDataUserLoginService
{
    private $_context;
    private $arrDataFullName;
    public function __construct($con)
    {
        $this->_context = $con;
        $this->_context->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    private function convertDataRequest($params)
    {
        $createSqlSearch = "";
        /*รับข้อมูลแบบ fetch mapper obj filter Name IdUserLogin*/
        if(gettype($params) == 'object')
        {
            return "'$params->IdUserLogin'";
        }
        /*รับข้อมูลแบบ fetchAll mapper List Object Name IdUserLogin*/
        else if(gettype($params[0]) == 'object')
        {
            foreach($params as $datas)
            {
                $createSqlSearch .= $createSqlSearch != '' ? ",'$datas->IdUserLogin'" : "'$datas->IdUserLogin'";
            }
            return $createSqlSearch;
        }
        /*รับข้อมูลแบบ fetchAll mapper filter List Array Name IdUserLogin*/
        else if(gettype($params[0]) == 'array')
        {
            foreach($params as $datas)
            {
                $createSqlSearch .= $createSqlSearch != '' ? ",'$datas[IdUserLogin]'" : "'$datas[IdUserLogin]'";
            }
            return $createSqlSearch;
        }
        /*รับข้อมูลแบบ fetch mapper array filter Name IdUserLogin*/
        else if(gettype($params) == 'array')
        {
            return "'$params[IdUserLogin]'";
        }
        /*รับข้อมูลแบบ value*/
        else
        {
            $createSqlSearch = "'$params'";
            return $createSqlSearch;
        }
    }
    public function createDataUserLogin($params)
    {
        $this->arrDataFullName = array();
        try
        {
            $reqSqlSearch = $this->convertDataRequest($params);
            $fetchUser = $this->_context->query("SELECT `user`,`title_sub`,`sub` FROM tb_customer WHERE `user` IN ($reqSqlSearch) ")->fetchAll(2);
            foreach($fetchUser as $datas)
            {
                $this->arrDataFullName["$datas[user]"] = "$datas[title_sub] $datas[sub]";
            }
        }
        catch(Exception $e)
        {
            $this->arrDataFullName['Object createDataUserLogin Error Message'] = $e->getMessage();
        }
    }
    public function getUserLoginFullName($valIdLogin)
    {
        return $this->arrDataFullName[$valIdLogin] != '' && $valIdLogin != 'admin' ? $this->arrDataFullName[$valIdLogin] : "บริษัท โฟร์ อินชัวรันส์ โบรกเกอร์ จำกัด";
    }
}