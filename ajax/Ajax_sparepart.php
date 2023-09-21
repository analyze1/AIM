<?php
session_start();
include "../inc/connectdbs.pdo.php";
$strUser = $_SESSION["strUser"];

$EndYear = date('Y');
$dateN = date('Y-m-d');
$StartYear = $EndYear - 3;

if (!empty($_POST['txt_year'])) {
  $postM = $_POST['txt_year'];
  $today_y_th = $_POST['txt_year'] + 543;
} else {
  $postM = date("Y");
  $today_y_th = date("Y") + 543;
}
$condiUser = '';
if (strtoupper($strUser) != 'ADMIN') {
  $condiUser = " AND user='" . $strUser . "' ";
} else {
  if (!empty($_POST['txt_iduser'])) {
    $condiUser = " AND user='" . $_POST['txt_iduser'] . "' ";
  } else {
    $condiUser = "  ";
  }
}

function thaiDate($datetime)
{

  $exd = explode('-', $datetime);
  $Y = $exd['0'] + 543;
  $m = $exd['1'];
  $d = $exd['2'];


  return $d . "/" . $m . "/" . $Y;
}
function monththai($mm)
{
  switch ($mm) {
    case '01':
      $month = "มกราคม";
      break;
    case '02':
      $month = "กุมภาพันธ์";
      break;
    case '03':
      $month = "มีนาคม";
      break;
    case '04':
      $month = "เมษายน";
      break;
    case '05':
      $month = "พฤษภาคม";
      break;
    case '06':
      $month = "มิถุนายน";
      break;
    case '07':
      $month = "กรกฎาคม";
      break;
    case '08':
      $month = "สิงหาคม";
      break;
    case '09':
      $month = "กันยายน";
      break;
    case '10':
      $month = "ตุลาคม";
      break;
    case '11':
      $month = "พฤศจิกายน";
      break;
    case '12':
      $month = "ธันวาคม";
      break;
  }
  return $month;
}
?>

<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">
<link rel="stylesheet" href="./css/spare-part.css">
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>

<style type="text/css">
  tr.ftc th {
    text-align: center !important;
    padding-left: 10px;
    padding-right: 10px;
  }

  .ftc {
    text-align: center !important;
    padding-left: 10px;
    padding-right: 10px;
  }

  td.ftc {
    text-align: center !important;
    padding: 10px !important;
    color: black;
  }

  .ftr {
    text-align: right !important;
    padding-left: 10px;
    padding-right: 10px;
    color: black;
  }

  td.ftr {
    text-align: right !important;
    padding: 10px !important;
  }

  .ftl {
    text-align: left !important;
    padding: 10px !important;
    color: black;
  }

  .bgHead {
    background: #233f85 !important;
    text-align: center;
  }
  .table tr:nth-child(odd) {
    background: #233f85 !important;
    color: #fff !important;
}
.colgroup-b{
  background: #233f85 !important;
  color: #fff !important;
}
  /* table, th, td {
  border: 1px solid black;
} */
</style>
<hr>
<div class="row-fluid">
  <div class="span12">
    <div class="box">
      <header>
        <h3 class="ftc">รายงานค่าแรง + ค่าอะไหล่ ประจำปี <?= $today_y_th; ?></h3>
      </header>
    </div>
  </div>
</div>
<table border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered w85-per" id="example" style="font-size:12px">
  <thead>

    <tr class="ftc bgHead">
      <?php if (strtoupper($strUser) == 'ADMIN') { ?>
        <th rowspan="2">ภาค</th>
        <th rowspan="2">รหัสดีลเลอร์</th>
        <th rowspan="2" class="w450-px">ดีลเลอร์</th>
      <?php } ?>
      <th rowspan="2" class="w4-per">เดือน</th>
      <th colspan="2" class="w14-per" scope="colgroup">ค่าอะไหล่</th>
      <th colspan="2" class="w14-per" scope="colgroup">ค่าแรง</th>
      <th colspan="2" class="w14-per" scope="colgroup">อะไหล่ Supply</th>
      <th colspan="2" class="w14-per" scope="colgroup">รวมสินไหมจ่าย</th>
    </tr>
    <tr class="ftc bgHead">

      <th class="w5-per colgroup-b">หน่วย</th>
      <th class="w5-per colgroup-b">จำนวนเงิน</th>
      <th class="w5-per colgroup-b">หน่วย</th>
      <th class="w5-per colgroup-b">จำนวนเงิน</th>
      <th class="w5-per colgroup-b">หน่วย</th>
      <th class="w5-per colgroup-b">จำนวนเงิน</th>
      <th class="w5-per colgroup-b">หน่วย</th>
      <th class="w5-per colgroup-b">จำนวนเงิน</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $strSQL_D = "SELECT * FROM  tb_customer WHERE nameuser='Mitsubishi' " . $condiUser . " ";
    // mysql_select_db($db1, $cndb1);
    $query_D = PDO_CONNECTION::fourinsure_mitsu()->query($strSQL_D)->fetchAll(2);
    foreach ($query_D AS $result_name_supply) {

      for ($i = 1; $i <= 12; $i++) {
        if ($i < 10) {
          $numM = '0' . $i;
        } else {
          $numM = $i;
        }

        $strSQL_data_01 =  "SELECT sum(spare_po) as spare_po, sum(spare_cost) as spare_cost ,sum(labor_po) as labor_po,sum(labor_cost) as labor_cost , sum(suppli_po) as suppli_po, sum(suppli_cost) as suppli_cost , sum(sum_po) as sum_po,sum(sum_cost) as sum_cost FROM tb_mk_spares WHERE spare_date ='" . $postM . "-" . $numM . "' AND supplier = '" . $result_name_supply["user"] . "' group by supplier,spare_date order by spare_id DESC ";
        $query_data_01 = PDO_CONNECTION::fourinsure_mitsu()->query($strSQL_data_01);
        $row_01 = $query_data_01->rowCount();
        $result_data_01 = $query_data_01->fetch(2);
        if ($row_01 > 0) {
          if (!empty($result_data_01['spare_po']) || $result_data_01['spare_po'] != '0') {
            $spare_po =  $result_data_01['spare_po'];
          } else {
            $spare_po =   '-';
          }
          if (!empty($result_data_01['spare_cost']) || $result_data_01['spare_cost'] != '0' || $result_data_01['spare_cost'] != '0.00') {
            $spare_cost =   number_format($result_data_01['spare_cost'], 2);
          } else {
            $spare_cost =   '-';
          }
          if (!empty($result_data_01['labor_po']) || $result_data_01['labor_po'] != '0') {
            $labor_po =   $result_data_01['labor_po'];
          } else {
            $labor_po =   '-';
          }
          if (!empty($result_data_01['labor_cost']) || $result_data_01['labor_cost'] != '0' || $result_data_01['labor_cost'] != '0.00') {
            $labor_cost =   number_format($result_data_01['labor_cost'], 2);
          } else {
            $labor_cost =   '-';
          }
          if (!empty($result_data_01['suppli_po']) || $result_data_01['suppli_po'] != '0') {
            $suppli_po =   $result_data_01['suppli_po'];
          } else {
            $suppli_po =   '-';
          }
          if (!empty($result_data_01['suppli_cost']) || $result_data_01['suppli_cost'] != '0' || $result_data_01['suppli_cost'] != '0.00') {
            $suppli_cost =   number_format($result_data_01['suppli_cost'], 2);
          } else {
            $suppli_cost =   '-';
          }
          if (!empty($result_data_01['sum_po']) || $result_data_01['sum_po'] != '0') {
            $sum_po =   $result_data_01['sum_po'];
          } else {
            $sum_po =   '-';
          }
          if (!empty($result_data_01['sum_cost']) || $result_data_01['sum_cost'] != '0') {
            $sum_cost =   number_format($result_data_01['sum_cost'], 2);
          } else {
            $sum_cost =   '-';
          }
        } else {
          $spare_po =   '-';
          $spare_cost =   '-';
          $labor_po =   '-';
          $labor_cost =   '-';
          $suppli_po =   '-';
          $suppli_cost =   '-';
          $sum_po =   '-';
          $sum_cost =   '-';
        }


    ?>
        <tr align="center">
          <?php if (strtoupper($strUser) == 'ADMIN') {
            if ($i == 1) {
          ?>
              <td rowspan='12' class="ftc f-bold"><?= $result_name_supply["group_pv"]; ?> </td>
              <td rowspan='12' class="ftc f-bold"><?= $result_name_supply["user"]; ?> </td>
              <td rowspan='12' class="ftc f-bold"><?= $result_name_supply["sub"]; ?> </td>
          <?php }
          } ?>
          <td class="ftc"><?= monththai($numM); ?></td>

          <td class="ftr"><?= $spare_po; ?></td>
          <td class="ftr"><?= $spare_cost; ?></td>
          <td class="ftr"><?= $labor_po; ?></td>
          <td class="ftr"><?= $labor_cost; ?></td>
          <td class="ftr"><?= $suppli_po; ?></td>
          <td class="ftr"><?= $suppli_cost; ?></td>
          <td class="ftr"><?= $sum_po; ?></td>
          <td class="ftr"><?= $sum_cost; ?></td>
        </tr>

    <?php
        $sum_spare_po = $sum_spare_po + $result_data_01['spare_po'];
        $sum_spare_cost = $sum_spare_cost + $result_data_01['spare_cost'];
        $sum_labor_po = $sum_labor_po + $result_data_01['labor_po'];
        $sum_labor_cost = $sum_labor_cost + $result_data_01['labor_cost'];
        $sum_suppli_po = $sum_suppli_po + $result_data_01['suppli_po'];
        $sum_suppli_cost = $sum_suppli_cost + $result_data_01['suppli_cost'];
        $sum_pototal = $sum_pototal + $result_data_01['sum_po'];
        $sum_costtotal = $sum_costtotal + $result_data_01['sum_cost'];
      }
    }
    ?>
  <tfoot>
    <tr align="center" bgcolor="#d6d6d6 ">
      <?php if (strtoupper($strUser) == 'ADMIN') {
      ?>
        <td></td>
        <td></td>
        <td></td>
      <?php } ?>
      <td class="ftc f-bold">รวม</td>
      <td class="ftr f-bold"><?= $sum_spare_po; ?> </td>
      <td class="ftr f-bold"><?= number_format($sum_spare_cost, 2) ?></td>
      <td class="ftr f-bold"><?= $sum_labor_po; ?></td>
      <td class="ftr f-bold"><?= number_format($sum_labor_cost, 2); ?> </td>
      <td class="ftr f-bold"><?= $sum_suppli_po; ?></td>
      <td class="ftr f-bold"><?= number_format($sum_suppli_cost, 2); ?></td>
      <td class="ftr f-bold"><?= $sum_pototal; ?></td>
      <td class="ftr f-bold"><?= number_format($sum_costtotal, 2); ?></td>
    </tr>
  </tfoot>
  </tbody>
</table>