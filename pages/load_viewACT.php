<?php
include "check-ses.php";
include "../inc/connectdbs.pdo.php";

$id_user = $_SESSION["strUser"];
if($id_user == 'admin'){
    $searchSQL  = '';
}else{
    
//    หาค่า idAgent ของ Dealer
    $strUser_1 = substr($id_user,0,1);
    $strUser_2 = substr($id_user,4,3);
    $newlogin = 'Z'.$strUser_1.$strUser_2;
    
     $searchSQL  = " AND data.idagent ='".$newlogin."' ";
}
	function thaiDate($datetime)
	{
		list($date,$time) = explode(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($H,$i,$s) = explode(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
		list($Y,$m,$d) = explode('-',$date); // แยกวันเป็น ปี เดือน วัน
		$Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.
		switch($m) 
		{
			case "01": $m = "01"; break;
			case "02": $m = "02"; break;
			case "03": $m = "03"; break;
			case "04": $m = "04"; break;
			case "05": $m = "05"; break;
			case "06": $m = "06"; break;
			case "07": $m = "07"; break;
			case "08": $m = "08"; break;
			case "09": $m = "09"; break;
			case "10": $m = "10"; break;
			case "11": $m = "11"; break;
			case "12": $m = "12"; break;
		}
		return $d."/".$m."/".$Y;
	}

$today_date = date('Y-m-d');
$StartYear = date('Y');
$EndYear = date('Y');

function DateDiff($strDate1, $strDate2) {
    return (strtotime($strDate2) - strtotime($strDate1)) / (60 * 60 * 24);  // 1 day = 60*60*24
}

$query2 = "SELECT ";
$query2 .= " insuree.name As cus_name,data.id_data,data.id as chkid,detail.id_data,insuree.id_data,insuree.icard,insuree.edit_insured_time,insuree.edit_data_time,";
$query2 .= " data.ty_inform,data.com_data, ";
$query2 .= " detail.br_car,detail.mo_car, ";
$query2 .= " detail.cat_car,tb_user.user,data.login,detail.car_regis,insuree.title,insuree.last,data.send_date,data.start_date,data.end_date,detail.car_body,detail.n_motor,detail.car_id, ";
$query2 .= " premium.id_data,premium.total_sum,premium.total_commition,protect.cost,premium.prb, ";
$query2 .= " detail.Cancel_policy2,detail.status_policy_time,data.doc_type,detail.id_data_company,insuree.status_sendmail_recheck , ";
$query2 .= " tb_type_inform.code,tb_comp.sort,tb_comp.name_print as cmn,tb_br_car.id,tb_br_car.name as brn,tb_mo_car.id,tb_mo_car.name as mon,tb_cat_car.id";
$query2 .= "
    ,IF(insuree.tel_mobile3 IS NULL or insuree.tel_mobile3 = '',
        IF(insuree.tel_mobile2 IS NULL or insuree.tel_mobile2 = '',
            insuree.tel_mobile
        , insuree.tel_mobile2)
    , insuree.tel_mobile3) as xtel
    ";
$query2 .= " FROM data ";
$query2 .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query2 .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query2 .= "INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
$query2 .= "INNER JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
$query2 .= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
$query2 .= "INNER JOIN premium ON (premium.id_data = data.id_data) ";
$query2 .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query2 .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
$query2 .= "INNER JOIN  protect ON (data.id_data  =  protect.id_data) ";
$query2 .= "INNER JOIN act ON (data.id_data  = act.id_data)";
$query2 .= "INNER JOIN tb_user ON (tb_user.user = data.login) ";
$query2 .= "WHERE YEAR(data.send_date) BETWEEN $StartYear AND $EndYear   ";
$query2 .= " AND detail.Cancel_policy2 ='' ";
$query2 .= " AND data.id_data not like '%ACT%' ";
$query2 .= " $searchSQL ";
$query2 .= " order by data.send_date DESC limit 0,50";
//echo $query2;
//exit();
// mysql_select_db($db2, $cndb2);

$objQuery = PDO_CONNECTION::fourinsure_insured()->query($query2);
$countQue = $objQuery->rowCount();

$i = 0;
?>
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/DT_bootstrap.js"></script>
<!--<script type="text/javascript" src="js/js_Renew.js"></script>-->

<style>
.modal-body {
    position: relative;
    background-color: #fff;
    max-height: 500px;
}

.modal-content {
    position: relative;
    background-color: #fff;
    border: 1px solid #999;
    width: 1200px;
    /* SET THE WIDTH OF THE MODAL */
    margin: -30px 0 0 -300px;
    max-height: 500px;
}
</style>

<script src="assets/js/bootstrap-tooltip.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("a[rel='tooltip']").tooltip({
        'placement': 'top',
        'z-index': '3000'
    });
});
</script>


<div class="row-fluid">
    <!-- .inner -->
    <div class="span12 inner">
        <!--Begin Datatables-->
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">

                    <div id="collapse4" class="body">

                        <table width="100%" border="0" cellpadding="0" cellspacing="0"
                            class="table table-striped table-bordered" id="example1">
                            <thead>
                                <tr height="30">
                                    <th width="6%"></th>
                                    <!--<th width="5%">วันที่แจ้ง</th>-->
                                    <th width="5%">ทะเบียน</th>
                                    <th width="8%">รย/กธ</th>
                                    <th width="11%">ชื่อผู้เอาประกัน</th>
                                    <th width="5%">วันที่คุ้มครอง</th>
                                    <th width="5%">ยี่ห้อ/รุ่น</th>
                                    <th width="6%">ทุนประกันภัย</th>
                                    <th width="4.5%">พ.ร.บ</th>
                                    <th width="6%">เบี้ยรวม</th>
                                    <th width="6%">ยอดชำระ</th>
                                    <!--<th width="6%"></th>-->

                                </tr>
                            </thead>
                            <tbody>
                                <?php
$totalRows = $n;
//$totalRows = COUNT($dataall)-1;
//for($iall=0;$iall<$totalRows;$iall++) {
foreach ($objQuery->fetchAll(2) as $row ) {
    if ($row['car_id'] == "110") {
        $p_net = "645.21";
    } else if ($row['car_id'] == "320") {
        $p_net = "976.28";
    }


    $cus_title = str_replace(" ", "", $row['title']);
    $cus_cus_name = str_replace(" ", "", $row['cus_name']);
    $cus_last = str_replace(" ", "", $row['last']);
    $car_regis = str_replace(" ", "", $row['car_regis']);



    $str_price = str_replace(',', '', $row['total_commition']);


// บวกเดือนวันหมดอายุกรมธรรม์ 

    $Date_BeforeExpiry = date("Y-m-d", strtotime("-1 month", strtotime($row['end_date'])));

    $Date_Expiry = date("Y-m-d", strtotime("+1 month", strtotime($date)));
    ?>

                                <?php if ($row['end_date'] >= $today_date && $today_date > $Date_BeforeExpiry && $row['Cancel_policy2'] != 'ยกเลิกกรมธรรม์') {
                                    echo "<tr align='center' class='bg_tr_nexpire'>";
                                    } else if ($row['end_date'] < $today_date && $row['Cancel_policy2'] != 'ยกเลิกกรมธรรม์') {
                                    echo "<tr align='center' class='bg_tr_expire'>";
                                    } else if ($row['Cancel_policy2'] == 'ยกเลิกกรมธรรม์') {
                                    echo "<tr align='center' class='bg_tr_cancel'>";
                                    } else {
                                    echo "<tr align='center'>";
                                    }?>

                                <td style='vertical-align:top'>

                                    <a class="btn btn-info btn-small" title="" rel="tooltip" target="_blank"
                                        style="width:100px;"
                                        href="print/reprint_OrderF.php?IDDATA=<?= $row['id_data']; ?> "
                                        data-original-title="พิมพ์ใบคำขอ"><i class="icon-print"></i> ใบคำขอ</a>
                                </td>

                                <!--<td align="center"><?= $row['send_date']; ?></td>-->
                                <td align="center"><?= $row['car_regis']; ?></td>
                                <!--<td ><?= $row['login']; ?></td>-->
                                <td align="center">
                                    <?php if ($row['id_data_company'] == '') { echo  $row['id_data']; }else { echo  $row['id_data_company'] ;  } ?>
                                    <?php
                                    if($row['status_sendmail_recheck'] == 'Y')
                                    {
                                    if($row['id_data_company'] == '')
                                    {
                                    echo '<br>มีการแจ้งงานแล้ว';
                                    }
                                    }
                                    if($row['status_sendmail_recheck'] == '')
                                    {
                                    echo '<br>ยังไม่แจ้งงาน';
                                    }
                                    ?>
                                </td>
                                <td align="left"><?= $row['title'] . " " . $row['cus_name'] . " " . $row['last'] ?></td>

                                <td><?php echo thaiDate($row['start_date']); ?></td>
                                <!--<td height="36"><?= $BrC['name'][$row['br_car']]; ?> / <?= $MoC['name'][$row['mo_car']]; ?> -->
                                <td height="36"><?= $row['brn']; ?>/<?= $row['mon']; ?>
                                </td>
                                <td><?= $row['cost']; ?></td>
                                <td><?= $row['prb'] ?></td>
                                <td><?= $row['total_sum']; ?></td>
                                <td><?= $row['total_commition']; ?></td>
                                <!--<td style="width:80px; align:center; "></td>-->
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <hr>

                        <!-- /.row-fluid -->
                    </div>


                    <!-- /.inner -->
                </div>
                <!-- /.row-fluid -->
            </div>
            <!-- /.outer -->
        </div>

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">ใบคำขอประกันภัยรถยนต์</h4>
                    </div>
                    <div class="modal-body">Load Data...</div>
                    <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal">Close</a></div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- Modal -->

        <script>
        var table = $('#example1').DataTable();

        //var table = $('#example1').DataTable({
        //    "processing": false,
        //    "serverSide": true,
        //    "deferRender": true,
        //    //"ordering":false,
        //    "order": [[ 3, "desc" ]],
        //    "ajax": {
        //        "url":"ajax/Ajax_viewACT.php",
        //        "type": "POST"
        //    },
        //    "columns": [
        //    {"data":"print"},
        //    {"data":"send_date"},
        //    {"data":"car_regis"},
        //    {"data":"id_data_comp"},
        //    {"data":"cus_name"},
        //    {"data":"start_date"},
        //    {"data":"br_car"},
        //    {"data":"car_body"},
        //    {"data":"cost"},
        //    {"data":"prb"},
        //    {"data":"total_sum"},
        //    {"data":"total_commition"}
        //    ]
        //    
        //});
        </script>

        <script type='text/javascript'>
        //<![CDATA[ 
        $(document).on('click', 'a[data-toggle=modal]', function() {
            // event.preventDefault();
            var $modal = $($(this).data('target'));
            $('.modal-body', $modal).empty();
            $modal.show();
            $('.modal-body', $modal).load($(this).attr('href'));
        });
        </script>