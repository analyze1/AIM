<?php

header('Content-Type: application/json; charset=utf-8;');
include '../inc/connectdbs.pdo.php';

if($_POST['Controller']=='GetCostID')
{
    $sql = "SELECT * FROM detail_renew WHERE id_data = '$_POST[DataID]' AND `status` = 'F'";
    //renew_id_cost
    $res = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetch(5);

    $querycost = "SELECT * FROM tb_cost WHERE id = '$res->renew_id_cost'";
    $costResult  = PDO_CONNECTION::fourinsure_insured()->query($querycost)->fetch(5);
    $res->mocargroup = $costResult->mocargroup;

    echo json_encode(array('Status'=>200,'Data'=>$res));
    exit;
}

if($_POST['Controller']=='GetCostFix')
{
    
    $querycostrenew = " SELECT * FROM tb_cost WHERE ($_POST[Caroldfix] BETWEEN car_old AND car_old_end) AND mocargroup = '$_POST[Mocargroup]' ORDER BY cost ASC";
    $res = PDO_CONNECTION::fourinsure_insured()->query($querycostrenew)->fetchAll(5);
    echo json_encode(array('Status'=>200,'Data'=>$res));
    exit;
}

if($_POST['Controller']=='GetCostFixVVT') 
{

    $sql = "SELECT mo_car,br_car,car_body,car_id FROM detail WHERE id_data = '$_POST[DataID]'";
    $detailRes = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetch(2);

    //TODO หารหัสรุ่นย่อย
    $sql_model_sub = "SELECT IdModelSub_four FROM log_imported_data WHERE IdData = '$_POST[DataID]'";
    $res_model_sub = PDO_CONNECTION::fourinsure_mitsu()->query($sql_model_sub)->fetch(7);

    if (!$res_model_sub) {
        //TODO หารหัสรุ่นย่อย จากเลขตัวถัง
        $car_body_code = substr($detailRes['car_body'], 0, 9);
        $sql_model_sub = "SELECT idCarModelSub FROM ModelCarMitsubishi WHERE carBodyFormat LIKE '%$car_body_code%'";
        $res_model_sub = PDO_CONNECTION::fourinsure_insured()->query($sql_model_sub)->fetch(7);
    }

    //TODO หาราคารถ จากรหัสรุ่นย่อย
    $sql_car_model_sub = "SELECT price_car FROM tb_car_model_sub WHERE id = '$res_model_sub'";
    $price_car = PDO_CONNECTION::fourinsure_insured()->query($sql_car_model_sub)->fetch(7);

    
    $sql_xxx = "SELECT
				gc.fixcost,
				gc.fixcostend
			FROM
				tb_mocar_group g
				INNER JOIN tb_mocar_group_cost gc ON ( g.mggroup = gc.mggroup ) 
			WHERE
				g.brcar = '$detailRes[br_car]' 
				AND gc.carold = $_POST[Caroldfix] 
				AND g.mocar IN ( '$detailRes[mo_car]', 'ALL' ) 
				AND (	g.mgstatus = 'Y')";


    $res_xxx = PDO_CONNECTION::fourinsure_insured()->query($sql_xxx)->fetch(5);

    
    $price = $price_car * 1;
    $fixCostPercent = ceil(($price * (int)$res_xxx->fixcost) / 100);
    $fixCostEndPercent = ceil(($price * (int)$res_xxx->fixcostend) / 100);
    $startCost = round($fixCostPercent, -4);
    $endCost = round($fixCostEndPercent, -4);
    $totalCostPercent = round((($startCost + $endCost) / 2), -4); //ทุนประกันภัย

    $toDay = date('Y-m-d');

    $sqlFindeCost = "SELECT
        tb_cost.car_old,
        tb_cost.car_old_end,
        tb_cost.id AS id_cost,
        tb_cost.car_id,
        tb_cost.cost,
        tb_cost.cost_end,
        tb_cost.pre,
        tb_cost.total,
        tb_cost.`repair`,
        tb_cost.mocargroup,
        tb_cost.protect_type,
        MIN( tb_cost.pre ) AS preMin,
        tb_cost.create_date,
        tb_cost.date_expired
        FROM
        tb_cost
        LEFT JOIN tb_cost_mocar ON ( tb_cost.mocargroup = tb_cost_mocar.namegroup )
        LEFT JOIN tb_comp ON ( tb_cost.comp = tb_comp.sort ) 
        WHERE
        $_POST[Caroldfix] BETWEEN tb_cost.car_old AND tb_cost.car_old_end 
        AND tb_cost.create_date <= '$toDay' AND tb_cost.date_expired >= '$toDay' 
        AND tb_cost.worktype IN ( 'N', 'A' ) 
        AND tb_cost_mocar.cmocar IN ( '$detailRes[mo_car]', 'ALL' ) 
        AND (cost_end >= $startCost AND cost <= $endCost)
        AND tb_cost.car_id = '$detailRes[car_id]' 
        AND tb_cost.insured_type = '1' 
        AND tb_cost.`repair` = '1' 
        AND tb_cost.sumAssuredStatus <> 2 
        AND comp = 'VIB_S' 
        GROUP BY
        tb_cost.`repair`,
        tb_cost_mocar.namegroup,
        tb_cost.pre,
        tb_cost_mocar.cmocar 
        ORDER BY
        tb_comp.`name` DESC,
        tb_cost.`total` DESC";


    $resFindeCost = PDO_CONNECTION::fourinsure_insured()->query($sqlFindeCost)->fetchAll(5);

    if($resFindeCost==null)
    {
        echo json_encode(array('Status'=>400,'Data'=>null));
    }
    else
    {
        echo json_encode(array('Status'=>200,'Data'=>$resFindeCost));
    }
    
    exit;
}

if($_POST['Controller']=='GetCostFixEndCost') 
{

    $sql = "SELECT mo_car,br_car,car_body,car_id FROM detail WHERE id_data = '$_POST[DataID]'";
    $detailRes = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetch(2);

    //TODO หารหัสรุ่นย่อย
    $sql_model_sub = "SELECT IdModelSub_four FROM log_imported_data WHERE IdData = '$_POST[DataID]'";
    $res_model_sub = PDO_CONNECTION::fourinsure_mitsu()->query($sql_model_sub)->fetch(7);

    if (!$res_model_sub) {
        //TODO หารหัสรุ่นย่อย จากเลขตัวถัง
        $car_body_code = substr($detailRes['car_body'], 0, 9);
        $sql_model_sub = "SELECT idCarModelSub FROM ModelCarMitsubishi WHERE carBodyFormat LIKE '%$car_body_code%'";
        $res_model_sub = PDO_CONNECTION::fourinsure_insured()->query($sql_model_sub)->fetch(7);
    }

    //TODO หาราคารถ จากรหัสรุ่นย่อย
    $sql_car_model_sub = "SELECT price_car FROM tb_car_model_sub WHERE id = '$res_model_sub'";
    $price_car = PDO_CONNECTION::fourinsure_insured()->query($sql_car_model_sub)->fetch(7);

    
    $sql_xxx = "SELECT
				gc.fixcost,
				gc.fixcostend
			FROM
				tb_mocar_group g
				INNER JOIN tb_mocar_group_cost gc ON ( g.mggroup = gc.mggroup ) 
			WHERE
				g.brcar = '$detailRes[br_car]' 
				AND gc.carold = $_POST[Caroldfix] 
				AND g.mocar IN ( '$detailRes[mo_car]', 'ALL' ) 
				AND (	g.mgstatus = 'Y')";


    $res_xxx = PDO_CONNECTION::fourinsure_insured()->query($sql_xxx)->fetch(5);

    
    $price = $price_car * 1;
    $fixCostPercent = ceil(($price * (int)$res_xxx->fixcost) / 100);
    $fixCostEndPercent = ceil(($price * (int)$res_xxx->fixcostend) / 100);
    $startCost = round($fixCostPercent, -4);
    $endCost = round($fixCostEndPercent, -4);
    $totalCostPercent = round((($startCost + $endCost) / 2), -4); //ทุนประกันภัย

    echo json_encode(array('Status'=>200,'Data'=>array('StartCost'=>$startCost,'EndCost'=>$endCost)));
    exit;
}
