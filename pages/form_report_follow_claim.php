<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
$_context = PDO_CONNECTION::fourinsure_mitsu();
$_userLogin = $_SESSION["strUser"];
$_userRights = $_SESSION['claim'];
echo "
<script>
var _userLogin = '$_userLogin';
var _userRights = '$_userRights';
</script>
";
?>
<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />
<link type="text/css" rel="stylesheet" type="text/css" href="assets/dataTable/1.10.24/css/jquery.dataTables.css">
<script type="text/javascript" src="assets/dataTable/1.10.24/js/jquery.dataTables.js"></script>
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<style>
.ftc {
    text-align: center !important;
}

.ftr {
    text-align: right !important;
}

.ftl {
    text-align: left !important;
}

#followClaim tr td {
    height: 30px;
}

.btn-primary {
    background-color: #233f85 !important;
    border-color: #233f85;
}

.table thead:first-child tr {
    background: #233f85 !important;
    color: #fff !important;
}

.dataTable th[class*=sorting_] {
    color: #fff;
}
</style>
<div class="row-fluid">
    <div class="span12 inner">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="body">
                        <br>
                        <form action='report/report_follow_claim_xls.php' method='POST' target='_BLANK'
                            onsubmit='return js_report_xls();'>
                            <div class='span12' style='margin:0;padding-top:7px;'>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>รายงานติดตามเคลม</b>
                            </div>
                            <div class='span12' style='margin:0;padding-top:7px;'>
                                <div class='span2' style='margin:0;'>
                                    <center>ชื่อตัวแทน</center>
                                </div>
                                <div class='span10' style='margin:0;'>
                                    <select class='span7' name='dealer' id='dealer'>

                                        <?php
										if ($_userLogin == 'admin') {
											echo "<option value='ALL'>ALL</option>";
											$sql_dealer = "";
											$_dealerClaim = "";
										} else {
											$sql_dealer = " AND user = '$_userLogin' ";
											$_dealerClaim = " AND `data`.`login` = '$_userLogin' ";
										}
										$sqlDealer = "SELECT user,title_sub,sub FROM tb_customer WHERE nameuser = 'Mitsubishi' " . $sql_dealer . " ";
										$fetchDealer = $_context->query($sqlDealer)->fetchAll(2);
										foreach ($fetchDealer as $dealer_array) { ?>
                                        <option value='<?= $dealer_array['user']; ?>'>
                                            <?= "[" . $dealer_array['user'] . "] " . $dealer_array['title_sub'] . $dealer_array['sub']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class='span12' style='margin:0;padding-top:7px;'>
                                <div class='span2' style='margin:0;'>
                                    <center>การค้นหา</center>
                                </div>
                                <div class='span2' style='margin:0;'>
                                    <select name='type_name' id='type_name' class='span12'>
                                        <option value='1'>วันบันทึกติดตาม</option>
                                    </select>
                                </div>
                                <div class='span2' style='margin:0;'>
                                    <center>วันที่ค้นหา</center>
                                </div>
                                <div class='span3' style='margin:0;'>
                                    <div class='span12' style='margin:0;'>
                                        <div class='span5' style='margin:0;'>
                                            <input type='text' name='start_date' id='start_date' class='span12'
                                                style='background-color:#FFFFFF !important;'
                                                placeholder='คลิกเลือกวันที่' readonly>
                                        </div>
                                        <div class='span2' style='margin:0;'>
                                            <center>ถึง</center>
                                        </div>
                                        <div class='span5' style='margin:0;'>
                                            <input type='text' name='end_date' id='end_date' class='span12'
                                                style='background-color:#FFFFFF !important;'
                                                placeholder='คลิกเลือกวันที่' readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class='span2' style='margin:0;'>
                                    <button type='submit' class='btn btn-small btn-primary'>ดาวน์โหลด Excel</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <br>
                        <br>
                        <br>
                        <hr>

                    </div>
                    <div class="body">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0"
                            class="table table-striped table-bordered" id="followClaim" style="font-size:12px">
                            <thead>
                                <tr>
                                    <th>เวลาติดตาม</th>
                                    <th>เลขรับแจ้ง</th>
                                    <th>เลขที่เคลม</th>
                                    <th style='width:30%;'>รายละเอียดติดตาม</th>
                                    <th>ราคาประเมิน</th>
                                    <th>วันที่นัด</th>
                                    <th>วันที่นัดซ่อม</th>
                                    <th>ผู้แจ้ง</th>
                                    <th>ผู้ติดตาม</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
<script>
function js_report_xls() {
    if ($("#type_name").val() == '') {
        alert('เลือกการค้นหาดัวยครับ');
        $("#type_name").focus();
        return false;
    }
    if ($("#start_date").val() == '') {
        alert('เลือกวันเริ่มต้น');
        $("#start_date").focus();
        return false;
    }
    if ($("#end_date").val() == '') {
        alert('เลือกวันสิ้นสุด');
        $("#end_date").focus();
        return false;
    }
}
$('#start_date').datepicker({
    format: "yyyy-mm-dd",
    language: "th",
    autoclose: true
});
$('#end_date').datepicker({
    format: "yyyy-mm-dd",
    language: "th",
    autoclose: true
});

var tables = $('#followClaim').DataTable({
    "processing": true,
    "serverSide": true,
    "aaSorting": [
        [0, 'desc']
    ],
    "ajax": {
        "url": 'services/CheckFollowUpClaim/CheckFollowUpClaim.controller.php',
        "type": 'POST',
        "dataSrc": function(response) {
            response.data = response.Data.data;
            response.recordsTotal = response.Data.recordsTotal;
            response.recordsFiltered = response.Data.recordsFiltered;
            response.draw = response.Data.draw;
            console.log(response);
            return response.data;
        },

        "data": {
            "UserLogin": _userLogin,
            "UserRights": _userRights,
            "Controller": 'FollowUp'
        }
    },
    "columnDefs": [{
            "targets": 0,
            "data": 'FollowDateSave',
            "name": 'tb_claimfollow.timecall',
        },
        {
            "targets": 1,
            "data": 'IdData',
            "name": 'data.id_data',
        },
        {
            "targets": 2,
            "data": 'ClaimNo',
            "name": 'tb_claimfollow.claim_no',

        },
        {
            "targets": 3,
            "data": 'FollowDetail',
            "name": 'tb_claimfollow.detailtext',

        },
        {
            "targets": 4,
            "data": 'AppraisalPrice',
            "name": 'tb_claimfollow.cost_estimate',

        },
        {
            "targets": 5,
            "data": 'AppointmentDate',
            "name": 'tb_claimfollow.datefollow',

        },
        {
            "targets": 6,
            "data": 'AppointmentDateRepair',
            "name": 'tb_claimfollow.date_repair'

        },
        {
            "targets": 7,
            "data": 'Informant',
            "name": 'tb_claimfollow.informer'

        },
        {
            "targets": 8,
            "data": 'Followers',
            "name": 'tb_claimfollow.userdetail',

        }
    ]
});
</script>