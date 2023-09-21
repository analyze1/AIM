<?php

class CompanyFour
{
    protected $_conn;

    public function __construct($conn = null)
    {
        $this->_conn = $conn;
    }
    public function getAll()
    {
        $data_company = [];
        $sql =  "SELECT * FROM tb_comp";
        $res = $this->_conn->query($sql)->fetchAll(2);
        foreach ($res as $x) {
            $data_company[$x['sort']] = $x['name_print'];
        }
        return $data_company;
    }
}
