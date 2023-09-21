<?php
include "check-ses.php"; 
include "../inc/connectdbs.inc.php"; 
include "../inc/function.php";
include "../inc/session_car.php";
$costOb = $_SESSION["Cost"];
$costObname = $_SESSION["CostName"];
$TbCost = $_SESSION["TbCost"];
$MoC = $_SESSION["MoC"];
$BrC = $_SESSION["BrC"]; 
?>
<?php
        
        function dateChkdiff($str_start, $str_end) {
            $str_start = strtotime($str_start); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
            $str_end = strtotime($str_end); // ทำวันที่ให้อยู่ในรูปแบบ timestamp
            $nseconds = $str_end - $str_start; // วันที่ระหว่างเริ่มและสิ้นสุดมาลบกัน
            $ndays = round($nseconds / 86400); // หนึ่งวันมี 86400 วินาที
            return $ndays;
        }
?>
<?php
$EndYear = date('Y');
$StartYear = $EndYear-3;
$dateN = date('Y-m-d');  
$date60 =  date('Y-m-d', strtotime('+60 day', strtotime( date('Y-m-d') )));
$query = "SELECT ";
$query .= " insuree.name As cus_name,data.id_data,detail.id_data,insuree.id_data,data.com_data,data.n_insure,detail.br_car,detail.mo_car,detail.add_price,detail.cat_car,data.login,detail.car_regis,insuree.title,insuree.last,data.send_date,data.start_date,data.end_date,detail.car_body,detail.n_motor,data.costCost,detail.car_id,data.p_act, req.CostProduct, req.Cus_title, req.Cus_name, req.Cus_last, req.EditAct_id, req.Edit_CarBody, req.CostProduct, tb_customer.saka ";
$query .= " FROM data ";
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "INNER JOIN tb_customer ON (data.login  = tb_customer.user) ";
$query .= "INNER JOIN req ON (data.id_data  = req.id_data) ";
$query .= "WHERE insuree.name!='' ";
if($_SESSION["strUser"]!='admin'){
$query .= "AND data.login='".$_SESSION["strUser"]."' ";
}
$query .= " AND data.end_date between  '".$dateN."'  and '".$date60."' ";
$query .= " order by data.end_date ASC ";
//$objQuery = mysql_query($query) or die ("Error Query [".$query."]");
//echo $query;
//exit();
mysql_select_db($db1,$cndb1);
$objQuery = mysql_query($query,$cndb1) or die ("Error Query tb_data [".$query."]");
?>

<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="assets/css/modalbank.css">
<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">

<script type="text/javascript" src="js/jquery.number.js"></script>
<!--<script type="text/javascript" src="js/jquery.imask.js"></script>-->
<!--	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="js/locales/bootstrap-datepicker.th.js"></script>-->
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>

<div class="container-fluid outer">

    <div class="row-fluid">
        <!-- .inner -->
        <div class="span12 inner">
            <!--Begin Datatables-->
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <header>
                            <div class="widget-header widget-header-flat"
                                style="text-align:left;border:solid thin #5098c9;">&nbsp;&nbsp; <h4><i
                                        class="icon-list"></i> ใบเสนอราคา/แจ้งต่ออายุ : </h4>
                            </div>

                        </header>


                        <div id="collapse4" class="body" style="background-color:#f5f5f5;padding:10px;">

                            <div id="search">


                                <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr height="50">
                                            <th width="8%"></th>
                                            <th width="6%">หมดอายุภายใน</th>
                                            <th width="8%">เลขที่รับแจ้ง/กธ.</th>
                                            <th width="11%">ชื่อผู้เอาประกัน</th>

                                            <th width="6%">วันสิ้นสุด</th>
                                            <!--<th width="6%">วันที่หมดอายุ</th>-->
                                            <th width="7%">ยี่ห้อ/รุ่น</th>
                                            <th width="9%">เลขตัวถัง</th>
                                            <th width="12%">ทุนประกันภัย</th>
                                            <th width="6%">พ.ร.บ</th>

                                        </tr>
                                    </thead>
                                    <?php
                                                $totalRows = $n;
//$totalRows = COUNT($dataall)-1;
//for($iall=0;$iall<$totalRows;$iall++) { 
                                                while ($row = mysql_fetch_array($objQuery)) {
                                                    $dfcount = '';
                                                    $dfcount = dateChkdiff($dateN, $row['end_date']);
                                                    if ($row['com_data'] == "VIB_S") {
                                                        $idcom_data = "09712";
                                                    } else if ($row['com_data'] == "VIB_F") {
                                                        $idcom_data = "11678";
                                                    } else if ($row['com_data'] == "VIB_C" && $row['saka'] == '113') {
                                                        $idcom_data = "08829";
                                                    } else if ($row['com_data'] == "VIB_C" && $row['saka'] != '113') {
                                                        $idcom_data = "10320";
                                                    }


                                                    $query_detailRenew = "SELECT * FROM detail_renew WHERE detail_renew.id_data ='" . $row['id_data'] . "' order by id_detail desc limit 1 ";
                                                    mysql_select_db($db1, $cndb1);
                                                    $objQuery_detailRenew = mysql_query($query_detailRenew, $cndb1);
                                                    $row_detailRenew = mysql_fetch_array($objQuery_detailRenew);
                                                    if ($row_detailRenew['status'] != 'E') {
                                                        ?>
                                    <tr align="center">
                                        <td valign="top">
                                            <input id="OQ" type="hidden" readonly="" name="OQ"
                                                value="<?= $row['id_data'] ?>">
                                            <div class="span12" style="width:350px;">
                                                <a class="span4 btn btn-success btn-small" title="" rel="tooltip"
                                                    onclick="$('#page-content').load('pages/renew_suzuki_select.php?id=<?= $row['id_data'] ?>');"
                                                    data-original-title="ดูข้อมูล"><i class="icon-white icon-list"></i>
                                                    ดูข้อมูล</a>
                                                <?php if ($row_detailRenew['status'] == 'S') { ?>
                                                <a class="span4 btn btn-danger btn-small"
                                                    onclick='window.open("print/print_Quotation.php?id=<?= $row['id_data'] ?>", "", "width=1000, height=900");'
                                                    id="printDeal" type="button"><i
                                                        class="icon-print icon-white"></i>ใบเสนอราคา</a>
                                                <?php } ?>
                                                <?php if(!empty($row_detailRenew['status'])){ ?>
                                                <a class="span4 btn btn-info btn-small" data-toggle="modal"
                                                    href="pages/viewSendRenew.php?IDDATA=<?= $row['id_data']; ?>"
                                                    aria-hidden="true" data-target="#modal"><i
                                                        class="icon-check icon-white"></i>แจ้งต่ออายุ</a>
                                                <?php } ?>
                                            </div>
                                        </td>
                                        <td height="36" valign="top" style="color:red;"><?= $dfcount; ?></td>
                                        <td height="36" align="center" valign="top">
                                            <!--<a data-toggle="modal" href="pages/viewSuzuki.php?IDDATA=<?= $row['id_data']; ?>" aria-hidden="true"   data-target="#modal"><?= $row['id_data']; ?></a>--><?= $row['id_data']; ?></br>
                                            <? echo '<font color="#FF0000">'.$row['n_insure'].'</font>';?>
                                        </td>
                                        <td height="36" align="left" valign="top">
                                            <?= $row['title'] . " " . $row['cus_name'] . " " . $row['last'] ?></br>
                                            <? if($row['Cus_name'] != '') {
                                                                echo "( ".$row['Cus_title'].$row['Cus_name']." ".$row['Cus_last']." )";}?>
                                        </td>

                                        <!--<td height="36" valign="top"><?= DateThai($row['start_date']) ?></td>-->
                                        <td height="36" valign="top"><?= DateThai($row['end_date']) ?></td>
                                        <td height="36" valign="top"><?= $MoC['name'][$row['mo_car']]; ?></td>
                                        <td height="36" valign="top"><?= $row['car_body']; ?></br>
                                            <? if($row['Edit_CarBody'] != '' ){ echo '<font color="#FF0000">'.$row['Edit_CarBody'].'</font>'; } ?>
                                        </td>
                                        <td valign="top">
                                            <? echo $TbCost['cost'][$row['costCost']]; ?>
                                            <? echo $row['cost']; ?>
                                        </td>
                                        <td valign="top"><?= substr($row['p_act'], 12, 7); ?></br>
                                            <? if($row['EditAct_id'] != '' ){ echo '<font color="#FF0000">'.substr($row['EditAct_id'],12,7).'</font>'; } ?>
                                        </td>


                                    </tr>
                                    <?php } ?>
                                    <?php } ?>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>
                <!--End Datatables-->
                <hr>
                <!-- /.row-fluid -->
            </div>
            <!-- /.inner -->
        </div>
        <!-- /.row-fluid -->
    </div>
    <!-- /.outer -->
</div>
</div>



<link type="text/css" rel="stylesheet" href="assets/css/modal.css" />
<!-- <style>
    .modal-content {
        width: 970px;
    }
 </style> -->

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title">แจ้งต่ออายุประกันภัย</h4>
            </div>
            <div class="modal-body">

                Load Data...

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Modal -->
<script type='text/javascript'>
$(document).on('click', 'a[data-toggle=modal]', function() {
    // event.preventDefault();
    var $modal = $($(this).data('target'));
    $('.modal-body', $modal).empty();
    $modal.show();
    $('.modal-body', $modal).load($(this).attr('href'));
});
</script>
<script>
$(document).ready(function() {

    var tables = $('#example').DataTable({
        "order": [
            [1, "asc"]
        ]
    });
    //เมื่อคลิกพิมพ์ใบเสนอราคา
    //    $("#printDeal").click(function (event) {
    //        var _selected = $("#OQ").val();
    //        window.open("print/print_Quotation.php?id=" + _selected, "", "width=1000, height=900");
    //    });

});
</script>