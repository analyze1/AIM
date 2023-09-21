<?php
include "check-ses.php";
include "../inc/connectdbs.pdo.php";

$EndYear = date('Y');
$dateN = date('Y-m-d');
$StartYear = $EndYear - 3;

function thaiDate($datetime)
{
  $exd = explode('-', $datetime);
  $Y = $exd['0'] + 543;
  $m = $exd['1'];
  $d = $exd['2'];
  return $d . "/" . $m . "/" . $Y;
}

$qDealer = '';
if ($_SESSION["strUser"] != 'admin') {
  $qDealer = " `data`.`login`= '$_SESSION[strUser]'";
}

$sqlSumClaim = "SELECT COUNT(`data`.id) AS TotalClaim FROM `data` 
INNER JOIN tb_claim ON (tb_claim.id_data = `data`.id_data)  
WHERE `data`.`login` = '$_SESSION[strUser]'";
$_totalClaim = PDO_CONNECTION::fourinsure_mitsu()->query($sqlSumClaim)->fetch(7);


$sqlSumClaim = "SELECT COUNT(Id) AS DoneClaim FROM claim_done WHERE DealerCode = '$_SESSION[strUser]'";
$_doneClaim = PDO_CONNECTION::fourinsure_mitsu()->query($sqlSumClaim)->fetch(7);

$qOrder = " ORDER BY tb_claim.claim_date DESC LIMIT 1000";
$query = "SELECT
      tb_claim.claim_date,
      tb_claim.claim_amount,
      tb_claim.claim_status,
      tb_claim.claim_no,
      tb_claim.claim_location,
      tb_claim.claim_des,
      tb_claim.estimate,
      insuree.`name` AS cus_name,
      `data`.id_data,
      detail.id_data,
      insuree.id_data,
      `data`.com_data,
      `data`.n_insure,
      detail.br_car,
      detail.mo_car,
      detail.add_price,
      detail.cat_car,
      `data`.`login`,
      detail.car_regis,
      detail.regis_date,
      insuree.title,
      insuree.last,
      `data`.send_date,
      `data`.`start_date`,
      `data`.end_date,
      detail.car_body,
      detail.n_motor,
      `data`.costCost,
      detail.car_id,
      `data`.p_act,
      req.CostProduct,
      req.Cus_title,
      req.Cus_name,
      req.Cus_last,
      req.EditAct_id,
      req.Edit_CarBody,
      req.CostProduct,
      tb_customer.saka 
      FROM
      `data`
      INNER JOIN detail ON ( `data`.id_data = detail.id_data )
      INNER JOIN insuree ON ( `data`.id_data = insuree.id_data )
      INNER JOIN tb_customer ON ( `data`.`login` = tb_customer.`user` )
      INNER JOIN req ON ( `data`.id_data = req.id_data )
      INNER JOIN tb_claim ON ( `data`.id_data = tb_claim.id_data ) 
      WHERE $qDealer $qOrder";

$objQuery = PDO_CONNECTION::fourinsure_mitsu()->query($query);

$sqlGetmoCar = 'SELECT id,`name` FROM tb_mo_car';
$_moCarArr = array();
foreach (PDO_CONNECTION::fourinsure_insured()->query($sqlGetmoCar)->fetchAll(5) as $val) {
  $_moCarArr[$val->id] = $val->name;
}

function dateChkdiff($str_start, $str_end)
{
  $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
  $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
  $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
  $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที

  return $ndays;
}
?>
<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>
<style type="text/css">
  .ftc {
    text-align: center !important;
  }

  .ftr {
    text-align: right !important;
  }

  .ftl {
    text-align: left !important;
  }

  .pd-r-55 {
    padding-right: 55px !important;
  }

  .box-100 {
    width: 100%;
    box-sizing: border-box;
  }

  .pd-l-14 {
    padding-left: 14px;
    /* white-space: pre; */
  }

  #example th:last-child {
    width: 100px !important;
  }

  .table thead:first-child tr {
    background: #233f85 !important;
    color: #fff !important;
  }
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="example" style="font-size:12px">
  <thead>
    <tr height="50">
      <th width="10% !important;"></th>
      <th width="10% !important;">เลขกรมธรรม์</th>
      <th width="8% !important;">เลขที่รับแจ้ง</th>
      <th width="20% !important;">ชื่อผู้เอาประกัน</th>
      <th width="8% !important;">ยี่ห้อ/รุ่น</th>
      <th width="12% !important;">เลขตัวถัง</th>
      <th width="7% !important;" class="ftc">วันที่เคลม</th>
      <th width="7% !important;" class="ftc">ถูก/ผิด</th>
      <th class="ftc">ประเมิน</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $totalRows = $n;
    foreach ($objQuery->fetchAll(2) as $row) {
      if ($row['claim_status'] == 'R') {
        $claimStatus = 'ถูก';
      } else if ($row['claim_status'] == 'W') {
        $claimStatus = '<span style="color:#d15b47;">ผิด</span>';
      } else if ($row['claim_status'] == 'N') {
        $claimStatus = 'ประมาทร่วม';
      } else if ($row['claim_status'] == 'C') {
        $claimStatus = 'รอผล';
      }
      $fullName = '';
      if ($row['Cus_name'] != '') {
        $fullName = "( " . $row['Cus_title'] . $row['Cus_name'] . " " . $row['Cus_last'] . " )";
      }
    ?>

      <tr align="center">
        <td height="36" valign="top"><a href="#" class="btn btn-success btn-small box-100" title="" rel="tooltip" onclick="load_page('pages/load_ClaimDetail.php?id=<?php echo  $row['id_data']; ?>','รายงานเคลม');">ติดตามเคลม</a></td>
        <td height="36" valign="top">
          <p class="pd-l-14"><?php echo  $row['n_insure']; ?></p>
        </td>
        <td height="36" align="center" valign="top">
          <p class="pd-l-14"><?php echo  $row['id_data']; ?></p>
        </td>
        <td height="36" align="left" valign="top">
          <p class="pd-l-14"><?php echo  $row['title'].$row['cus_name'] . " " . $row['last'] . '   ' ?><?php echo $fullName ?></p>
        </td>
        <td height="36" valign="top">
          <p class="pd-l-14"><?php echo  $_moCarArr[$row['mo_car']]; ?></p>
        </td>
        <td height="36" valign="top">
          <p class="pd-l-14"><?php echo  $row['car_body']; ?></p>
        </td>
        <td height="36" valign="top" class="ftc"><?php echo  $row['claim_date']; ?></td>
        <td height="36" valign="top" class="ftc"><?php echo  $claimStatus ?></td>
        <td height="36" valign="top" class="ftc"><?php echo  number_format($row['claim_amount']); ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
<script type="text/javascript">
  $(document).ready(function() {
    let tables = $('#example').DataTable();
  });

  Swal.fire({
    text: 'Do you want to continue',
    html: `
            <div>
                <label class="hdtextL" style="color: #233f85;font-size: 26px !important;">ยอดเคลมที่ติดตาม</label>
                <span class="dttext" style="font-size: 25px !important;">
                    จำนวน&nbsp;<?php echo  ($_totalClaim-$_doneClaim); ?> &nbsp;คัน
                </span>
            </div>
        `,
    icon: 'error',
    confirmButtonText: 'OK'
})
</script>