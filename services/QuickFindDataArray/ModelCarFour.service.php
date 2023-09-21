<?php

class ModelCarFour
{
    protected $_conn;
    protected $_modelArr;

    public function __construct($conn = null)
    {
        $this->_conn = $conn;

    }
    public function getAll()
    {
        $arr = array();
        $sql = "SELECT * FROM tb_mo_car WHERE mo_used = 'Y'";
        $result = $this->_conn->query($sql)->fetchAll(2);
        foreach ($result as $r) {
            $arr['name'][$r['id']] = $r['name'];
        }
        return $arr;
    }
    public function getBrandAll()
    {
        $arr = array();
        $sql = "SELECT * FROM tb_br_car";
        $result = $this->_conn->query($sql)->fetchAll(2);
        foreach ($result as $r) {
            $arr['name'][$r['id']] = $r['name'];
        }
        return $arr;
    }
    public function getModelSubAll()
    {
        $arr = array();
        $sql = "SELECT * FROM tb_car_model_sub";
        $result = $this->_conn->query($sql)->fetchAll(2);
        foreach ($result as $r) {
            $arr['name'][$r['id']] = $r['name'];
            $arr['priceCar'][$r['id']] = $r['price_car'];
        }
        return $arr;
    }

    public function getMoCarMitsuAll()
    {
        $sql = "SELECT id,`name` FROM tb_mo_car";
        $infos = $this->_conn->query($sql)->fetchAll(5);
        foreach($infos as $row)
        {
            $this->_modelArr[$row->id] = $row->name;
        }
        return false;
    }

    public function getMocar($id)
    {
        return $this->_modelArr[$id];
    }
}

class GetdetailFollowControl
{
    private $_context;
    public function __construct($con)
    {
        $this->_context = $con;
    }

    public function getdetailByID($id)
    {
        $sql = "SELECT
        de.id_data,de.`status`,de.detailtext,de.detail_follow,t.`name` AS toppicName
        FROM
            detail_renew AS de
            LEFT JOIN tb_data_follow AS t ON ( de.detail_follow = t.id ) 
        WHERE de.id_data = '$id' ORDER BY id_detail DESC LIMIT 1";
        return $this->_context->query($sql)->fetch(5);
    }
}
