<?php
session_start();
include "../inc/connectdbs.pdo.php";
$strUser = $_SESSION["strUser"];

?>

<?php
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
if (strtoupper($strUser) != 'ADMIN') {
  $condiUser = " AND user='" . $strUser . "' ";
} else {
  $condiUser = "  ";
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
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>

<style type="text/css">
  tr.ftc th {
    text-align: center !important;
  }

  .ftr {
    text-align: right !important;
  }

  .ftl {
    text-align: left !important;
  }

  .bgHead {
    background: #d6d6d6 !important;
    text-align: center;
  }

  .btn-primary {
    background-color: #233f85!important;
    border-color: #233f85
  }
</style>
<div class="container-fluid outer">
  <div class="row-fluid">
    <!-- .inner -->
    <div class="span12 inner">
      <!--Begin Datatables-->
      <div class="row-fluid">
        <div class="span12">
          <div class="box">
            <header>
              <h5><i class="icon-pencil"></i> รายงานค่าแรง + ค่าอะไหล่</h5>
            </header>
            <div id="collapse4" class="body">
              <div class="control-group">
              <iframe id="myIframeClaim" style="width: 100%;height: 44vh;" src="./charts/dash-board-claim.php"frameborder="0"></iframe>
              </div>
            </div>
            <hr>
            <div id="collapse4" class="body">
              <form method="post" name="form_search">
                <div class="control-group">
                  <div style="display:flex">
                  <div>
                  ประจำปี
                        <select name="txt_year" class="form-control" id="txt_year" style='height: 100%;width: 95px;'>
                          <?php for ($i = 0; $i <= 5; $i++) {
                            $txtY_EN = date("Y") - $i;
                            $txtY_TH = date("Y") + 543 - $i;
                          ?>
                            <option value="<?= $txtY_EN; ?>"><?= $txtY_TH; ?></option>
                          <?php } ?>
                        </select>
                  </div>
                  <div>
                  <?php if (strtoupper($strUser) == 'ADMIN') { ?>
                    ตัวแทนจำหน่าย
                          <select name="txt_iduser" class="form-control" id="txt_iduser" style='height: 100%;'>
                            <?php if (strtoupper($strUser) == 'ADMIN') { ?>
                              <option value="">- ดูทั้งหมด -</option>
                            <?php } else { ?>
                              <option value="<?php echo $strUser; ?>"><?php echo $strUser; ?></option>
                            <?php } ?>
                            <?php 
                            $query = "SELECT * FROM tb_customer WHERE nameuser = 'Mitsubishi' ORDER BY user ASC";
                            $objQuery = PDO_CONNECTION::fourinsure_mitsu()->query($query)->fetchAll(2);
                            foreach ($objQuery AS $row) {
                              echo "<option value='" . $row['user'] . "'>" . '[' . $row['user'] . ']' . ' ' . $row['title_sub'] . ' ' . $row['sub'] . "</option>";
                            }
                            ?>
                          </select>
                      <?php } else { ?>
                        <input type="hidden" name="txt_iduser" id="txt_iduser" value="<?= $strUser; ?>">
                      <?php } ?>                  
                  </div>
                  <div>
                      <a id="viewsubmit" class="btn btn-primary "><i class="icon-search icon-white"></i> View</a>
                  </div>                
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="viewSP">
</div>
<script>
  function viewSpart() {

    var tyear = $('#txt_year').val();
    var tiduser = $('#txt_iduser').val();

    var options = {
      type: "POST",
      dataType: "html",
      url: "ajax/Ajax_sparepart.php",
      data: {
        "txt_year": tyear,
        "txt_iduser": tiduser
      },
      success: function(msg) {
        $('#viewSP').html(msg);
      }
    };
    $.ajax(options);

  }

  $(document).ready(function() {
    viewSpart();
    $('#viewsubmit').click(function(event) {
      viewSpart();
    });
  });
</script>