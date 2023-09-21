<?php
class Address
{

    protected $_con;
    public function __construct($con)
    {
        $this->_con = $con;
    }
    public function  getAllProvince()
    {
        $sql = "SELECT id AS Id, `name` AS Name FROM tb_province ORDER BY `id`";
        $result = $this->_con->query($sql)->fetchAll(2);
        return $result;
    }
    public function  getAmPhur($model)
    {
        $sql = "SELECT id AS Id, `name` AS Name FROM tb_amphur WHERE provinceID = '$model->province' ORDER BY `name`";
        $result = $this->_con->query($sql)->fetchAll(2);
        return $result;
    }
    public function getTumBon($model)
    {
        $sql = "SELECT id AS Id, `name` AS Name FROM tb_tumbon WHERE amphurID = '$model->amphur' ORDER By `name`";
        $result = $this->_con->query($sql)->fetchAll(2);
        return $result;
    }
    public function getPostOffice($model)
    {
        $sql = "SELECT id AS Id, id_post AS Name FROM tb_tumbon WHERE id='$model->tumbon'";
        $result = $this->_con->query($sql)->fetch(2);
        return $result;
    }


    public  function getTumbonID($id)
    {
        $sql = "SELECT  `name` FROM tb_tumbon WHERE id = '$id'";
        $res = $this->_con->query($sql)->fetch(7);

        return $res;
    }
    public  function getAmphurID($id)
    {
        $sql = "SELECT  `name` FROM tb_amphur WHERE id = '$id'";
        $res = $this->_con->query($sql)->fetch(7);
        return $res;
    }
    public  function getProvinceID($id)
    {
        $sql = "SELECT  `name` FROM tb_province WHERE id = '$id'";
        $res = $this->_con->query($sql)->fetch(7);
        return $res;
    }
}
