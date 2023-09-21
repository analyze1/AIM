<?php

include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";

function thaiDate($datetime)
{
  $exd = explode('-', $datetime);
  $Y = $exd['0'] + 543;
  $m = $exd['1'];
  $d = $exd['2'];
  return $d . "/" . $m . "/" . $Y;
}

$sqlClaim = "SELECT * FROM tb_claim WHERE id_data = '$_GET[id]' ORDER BY claim_date DESC";
$resClaim = PDO_CONNECTION::fourinsure_mitsu()->query($sqlClaim);
$count = $resClaim->rowCount();

$i = 1;
foreach ($resClaim->fetchAll(2) as $rowClaim) {
  if ($i == 1) 
  {
    $claimAction = $rowClaim['claim_no'];
  }
  if ($rowClaim['claim_status'] == 'R') {
    $claimStatus = 'ถูก';
  } else if ($rowClaim['claim_status'] == 'W') {
    $claimStatus = '<span style="color:#d15b47;">ผิด</span>';
  } else if ($rowClaim['claim_status'] == 'N') {
    $claimStatus = 'ประมาทร่วม';
  } else if ($rowClaim['claim_status'] == 'C') {
    $claimStatus = 'รอผลคดี';
  }
  $claimAmt =  (int)$claimAmt + (int)$rowClaim['claim_amount'];
  if (!empty($rowClaim['claim_damage_list'])) {
    $claimlist = "<br><font color='red'>(" . $rowClaim['claim_damage_list'] . ")</font>";
  } else {
    $claimlist = '';
  }
?>
  <tr class="btline">
    <!--ที่-->
    <td class="ftc"><?php echo  $i; ?></td>
    <!--เลขที่เคลม-->
    <td class="ftc"><?php echo  $rowClaim['claim_no']; ?></td>
    <!--วันที่เคลม-->
    <td><?php echo  thaiDate($rowClaim['claim_date']); ?></td>
    <!--สถานที่เกิดเหตุ (รายการความเสียหาย)-->
    <td class="ftl">
      <?php echo  $rowClaim['claim_location'] . $claimlist; ?>
    </td>
    <!--รายละเอียด-->
    <!--<td class="ftl"><?php echo  $rowClaim['claim_des']; ?></td>-->

    <!--                                    <td class="ftc"><?php echo  $rowClaim['estimate']; ?></td>-->
    <!--ถูก/ผิด-->
    <td class="ftc"><?php echo  $claimStatus; ?></td>
    <!--ประเมิน-->
    <td class="ftl"><?php echo  number_format($rowClaim['claim_amount']); ?></td>
  </tr>
<?php
  $i++;
} ?>

<!--<tr>
<td class="ftc">&nbsp;</td>
<td class="ftc">&nbsp;</td>
<td class="ftc">&nbsp;</td>
<td class="ftc">&nbsp;</td>
<td class="ftc">&nbsp;</td>

<td class="ftc">&nbsp;</td>
</tr>-->
<tr>
  <td colspan="4">มีประวัติความเสียหายจำนวน <span class="tfred f18"><?php echo  $count; ?> </span>ครั้ง </td>
  <td colspan="2" class="ftr">รวมเป็นเงิน <span class="tfred f18"> <?php echo  number_format($claimAmt); ?></span> บาท</td>
</tr>
<?php if ($i <= 1) { ?>
  <tr>
    <td colspan="6" class="hstc">ไม่มีประวัติการเคลม</td>
  </tr>
<?php } ?>