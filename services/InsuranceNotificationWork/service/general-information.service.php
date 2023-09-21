<?php

class GeneralInformation
{
    protected $_context;
    protected $_ccMockUp = [
        '1' => ['0' => 1200, '1' => 1500, '2' => 2000, '3' => 2500, '4' => 3000],
        '2' => ['0' => 2000, '1' => 2500, '2' => 2600, '3' => 3000, '4' => 3500, '5' => 4000],
        '3' => ['0' => 3000, '1' => 3500, '2' => 3800, '3' => 4000, '4' => 4500, '5' => 5000, '6' => 6000],
        '4' => ['0' => 0],
        '5' => ['0' => 0],
        '6' => ['0' => 110, '1' => 125, '2' => 150, '3' => 160, '4' => 180, '5' => 200],
        '7' => ['0' => 2500, '1' => 3000, '2' => 3500, '3' => 4000, '4' => 5000, '5' => 6000],
        '8' => ['0' => 1200, '1' => 1500, '2' => 2000, '3' => 2500, '4' => 3000],
        '9' => ['0' => 3000, '1' => 3200, '2' => 3500, '3' => 3800, '4' => 4000, '5' => 4500],
    ];
    protected $_weightMockUp = [
        '1' => ['0' => 0, '1' => 3, '2' => 6],
        '2' => ['0' => 0, '1' => 3, '2' => 6],
        '3' => ['0' => 0, '1' => 3, '2' => 6, '3' => 12],
        '4' => ['0' => 0, '1' => 3, '2' => 6],
        '5' => ['0' => 0, '1' => 3, '2' => 6],
        '6' => ['0' => 0],
        '7' => ['0' => 0, '1' => 3, '2' => 6, '3' => 12],
        '8' => ['0' => 0, '1' => 3, '2' => 6],
        '9' => ['0' => 0, '1' => 3, '2' => 6],
    ];
    protected $_seatMockUp = [
        '1' => ['0' => 3, '1' => 7],
        '2' => ['0' => 3, '1' => 7, '2' => 20, '3' => 40],
        '3' => ['0' => 3, '1' => 7],
        '4' => ['0' => 3, '1' => 7],
        '5' => ['0' => 3, '1' => 7],
        '6' => ['0' => 3],
        '7' => ['0' => 3],
        '8' => ['0' => 3, '1' => 7],
        '9' => ['0' => 3, '1' => 7],
    ];

    public function __construct($context)
    {
        $this->_context = $context;
    }

    public function getTypeOfUse()
    {
        $sql = 'SELECT id as Id ,`name` as `Name` FROM tb_pass_car WHERE id != "2"';
        $res = $this->_context->query($sql)->fetchAll(2);
        return $res;
    }
    public function getCustomer()
    {
        $query_D = "SELECT * FROM `tb_customer` WHERE `nameuser` = 'Mitsubishi' ORDER BY `tb_customer`.`user` ASC"; // id = '1'
        $res = $this->_context->query($query_D)->fetchAll(2);

        return $res;
    }

    public function getPassCarType($model)
    {
        $resObj = array();
        $sql = "SELECT id as Id ,`name` as `Name` FROM tb_pass_car_type WHERE id_pass_car='$model->passCarID'";
        $res = $this->_context->query($sql)->fetchAll(2);
        $resObj['TypeCar'] = $res;
        $resObj['CC'] = $this->_ccMockUp[$model->passCarID];
        $resObj['Weight'] = $this->_weightMockUp[$model->passCarID];
        $resObj['Seat'] = $this->_seatMockUp[$model->passCarID];
        return $resObj;
    }

    public function getCatCar($model)
    {
        $sql = "SELECT id as Id, `name` as `Name` FROM tb_cat_car WHERE id_pass_car ='$model->passCarID' AND id = '01' ORDER BY id";
        $res = $this->_context->query($sql)->fetchAll(2);
        return $res;
    }

    public function getCatCarAct($model)
    {
        $sql = "SELECT id as Id, `name` as `Name` FROM tb_cat_car WHERE id_pass_car ='$model->passCarID' ORDER BY id";
        $res = $this->_context->query($sql)->fetchAll(2);
        return $res;
    }

    public function getBrandCar($model)
    {
        $sql = "SELECT id as Id, `name` as `Name` FROM tb_br_car WHERE MakeTyte$model->passCarID = $model->passCarID AND cat_car_id REGEXP '$model->catCarID' AND `status` = 1 "; // AND name = 'MITSUBISHI' 
        $res = $this->_context->query($sql)->fetchAll(2);
        return $res;
    }

    public function getBrandCarAct($model)
    {
        $sql = "SELECT id as Id, `name` as `Name` FROM tb_br_car WHERE MakeTyte$model->passCarID = $model->passCarID AND cat_car_id REGEXP '$model->catCarID' AND name = 'MITSUBISHI' AND `status` = 1 ";
        $res = $this->_context->query($sql)->fetch(2);
        return $res;
    }

    public function getModelCarAct($model)
    {
        $sql = "SELECT
                    tb_mo_car.id AS Id,
                    tb_mo_car.`name` AS Name 
                FROM
                    ModelCarMitsubishi
                    INNER JOIN tb_car_model_sub ON ( tb_car_model_sub.id = ModelCarMitsubishi.idCarModelSub )
                    INNER JOIN tb_mo_car ON ( tb_mo_car.id = tb_car_model_sub.id_mo_car ) 
                WHERE
                    ModelCarMitsubishi.carType LIKE '$model->passCarID%' 
                GROUP BY
                    tb_car_model_sub.id_mo_car 
                ORDER BY
                    id_mo_car ASC";
        $res = $this->_context->query($sql)->fetchAll(2);
        
        return $res;
    }

    public function getModelCar($model)
    {
        $_where = $model->passCarID == '1' ? "AND tb_mo_car.Id NOT IN('2396', '2397', '2586')" : "";

        $sql = "SELECT
                    tb_mo_car.id AS Id,
                    tb_mo_car.`name` AS Name 
                FROM
                    ModelCarMitsubishi
                    INNER JOIN tb_car_model_sub ON ( tb_car_model_sub.id = ModelCarMitsubishi.idCarModelSub )
                    INNER JOIN tb_mo_car ON ( tb_mo_car.id = tb_car_model_sub.id_mo_car ) 
                WHERE
                    ModelCarMitsubishi.carType LIKE '$model->passCarID%' 
                    $_where
                GROUP BY
                    tb_car_model_sub.id_mo_car 
                ORDER BY
                    id_mo_car ASC";
        $res = $this->_context->query($sql)->fetchAll(2);
        
        return $res;
    }

    public function getBranchName($model)
    {
        $sql = "SELECT user as Id, sub as `Name` FROM `tb_customer` WHERE `nameuser` = '$model->userName' GROUP BY `tb_customer`.`user` ORDER BY `tb_customer`.`user` ASC";
        $res = $this->_context->query($sql)->fetchAll(2);
        return $res;
    }

    public function getBeneficiary()
    {
        $sql = 'SELECT `name` as `Name` FROM `tb_heiress` WHERE `OpenClose` != 0 ORDER BY `tb_heiress`.`No` ASC';
        $res = $this->_context->query($sql)->fetchAll(7);
        return $res;
    }

    public function getCarColor()
    {
        return  [
            "ไม่ระบุ","เทา", "เขียว", "เขียว", "น้ำเงิน", "แดง", "ขาว", "น้ำตาล", "ดำ", "ฟ้า", "ส้ม", "บรอนซ์", "บรอนซ์เงิน", "บรอนซ์ทอง", "เหลืองดำ", "ส้มดำ", "เหลือง", "ขาวแดง", "ขาวน้ำเงิน", "ขาวมุก"
        ];
    }
    public function getProvince()
    {
        $sql = 'SELECT id as Id, `name` as `Name` FROM tb_province ORDER BY id ASC';
        $res = $this->_context->query($sql)->fetchAll(2);
        return $res;
    }
    public function getAmphur($model)
    {
        $sql = "SELECT id as Id, `name` as `Name` FROM tb_amphur WHERE provinceID = $model->provinceID ORDER BY id ASC";
        $res = $this->_context->query($sql)->fetchAll(2);
        return $res;
    }
    public function getTumbon($model)
    {
        $sql = "SELECT id as Id, `name` as `Name` FROM tb_tumbon WHERE amphurID = $model->amphurID ORDER BY id ASC";
        $res = $this->_context->query($sql)->fetchAll(2);
        return $res;
    }
    public function getPost($model)
    {
        $sql = "SELECT id_post FROM tb_tumbon WHERE id = $model->tumbonID ORDER BY id ASC";
        $res = $this->_context->query($sql)->fetch(7);
        return $res;
    }

    public function getDetailFollowData($type)
    {
        $sql = "SELECT id AS Id,`name` AS `Name` FROM tb_data_follow WHERE `status` = 'Y' 
        AND type_main = '$type' ORDER BY open_detail ASC";
        return $this->_context->query($sql)->fetchAll(5);
    }
    public function getDetailDataRenewArray($model)
    {
        $sql = "SELECT *,
		insuree.name As n_name,
		data.name_gain As g_name,
		act.p_net,
		detail.car_regis_pro
		FROM insuree INNER JOIN detail ON detail.id_data = insuree.id_data
		INNER JOIN data ON data.id_data = insuree.id_data
		INNER JOIN act ON act.id_data = insuree.id_data
		INNER JOIN req ON req.id_data = insuree.id_data

		WHERE insuree.id_data = '$model->id_data'";

        return $this->_context->query($sql)->fetch(2);
    }
    public function getModelCarSub($req){
        $sql = "SELECT
        tb_car_model_sub.id as Id,
        tb_car_model_sub.name as Name
        FROM
        ModelCarMitsubishi
        INNER JOIN tb_car_model_sub ON ( tb_car_model_sub.id = ModelCarMitsubishi.idCarModelSub ) 
        WHERE
        ModelCarMitsubishi.carType LIKE '$req->passCarID%'
        AND tb_car_model_sub.id_mo_car = '$req->modelCarID'
        GROUP BY tb_car_model_sub.id ORDER BY tb_car_model_sub.id ASC";
        $res = $this->_context->query($sql)->fetchAll(2);
        return $res;
    }

    public function genOptionInsuranceCapital($req){
        $sql = "SELECT id,cost FROM tb_cost WHERE  mo_sub = '$req->carSubID' AND comp = 'VIB_S'";
        $res = $this->_context->query($sql)->fetchAll(2);
        return $res;
    }

}