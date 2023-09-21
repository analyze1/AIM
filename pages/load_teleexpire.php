<?php
include "check-ses.php";
if ($_SESSION["strUser"] != 'admin' && $_SESSION['claim'] != 'ADMIN') {
    $sqltext = " AND userdetail='DEALER' ";
}
?>

<style type="text/css">
.table th,
.table td {
    text-align: center !important;
    line-height: 20px !important;
    vertical-align: middle;
}

table.dataTable thead th,
table.dataTable thead td {
    padding: 10px 0px !important;
    border-bottom: 1px solid #111111;
}

.btn-10-em {
    width: 10em;
}
</style>

<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="assets/css/modalbank.css">
<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">

<script type="text/javascript" src="js/jquery.number.js"></script>
<script type="text/javascript" src="js/jquery.imask.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/locales/bootstrap-datepicker.th.js"></script>
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>
<div id="pload" style="margin-left: 46%; margin-top: 10px;"></div>
<div id="top_head" style=" display: none;">
    <header>
        <div class="widget-header widget-header-flat" style="text-align:left;border:solid thin #5098c9;">&nbsp;&nbsp;
            <h4><i class="icon-search"></i> ข้อมูลต่ออายุ (Mitsubishi )</h4>
            <!-- new view content sarch -->
            <div style="float:right; display: none;" id="closepop" class="bg-close">X</div>
            <!-- <div id="content_pop"></div> -->
        </div>
    </header>
</div>
<div id="content_pop"></div>

<!-- <h2> ปิดปรับปรุง ขออภัยในความไม่สะดวก</h2> -->

<div id="content_table">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered"
        id="TableQuotationRenew" style="font-size:12px;">
        <thead>
            <tr>
            <tr>
                <th style="width:10%"></th>
                <th style="width:10%">วันสิ้นสุด</th>
                <th style="width:15%">เลขที่รับแจ้ง/กธ.</th>
                <th style="width:20%">ชื่อผู้เอาประกัน</th>
                <th style="width:15%">ยี่ห้อ/รุ่น</th>
                <th style="width:15%">ทะเบียน</th>
                <th style="width:5%">อายุรถ (ปี)</th>
                <th style="width:10%">วันที่เสนอราคา</th>
            </tr>
        </thead>

    </table>
</div>

<script type="text/javascript">
$(document).ready(function() {
    let tables = $('#TableQuotationRenew').DataTable({
        "processing": true,
        "serverSide": true,
        "aaSorting": [
            [3, 'desc']
        ],
        "ajax": 'ajax/ajax_telxprice3.php',
        "language": {
            "emptyTable": "ไม่พบข้อมูล"
        },
        "columnDefs": [{
            "targets": 0,
            "data": 'alertBTN',
            'bSortable': true,
            "bSearchable": true,
            "defaultContent": ""
        }, {
            "targets": 1,
            "data": 'alertdis',
            'bSortable': true,
            "bSearchable": true,
            "defaultContent": ""
        }, {

            "targets": 2,
            "data": 'name',
            "bSortable": true,
            "bSearchable": true,
            "defaultContent": ""
        }, {
            "targets": 3,
            "data": 'fullName',
            "bSortable": true,
            "bSearchable": true,
            "defaultContent": ""
        }, {
            "targets": 4,
            "data": 'detailMocar',
            "bSortable": true,
            "bSearchable": true,
            "defaultContent": ""
        }, {
            "targets": 5,
            "data": 'detailtext',
            "bSortable": true,
            "bSearchable": true,
            "defaultContent": ""
        }, {
            "targets": 6,
            "data": 'userdetail',
            "bSortable": true,
            "bSearchable": true,
            "defaultContent": ""
        }, {
            "targets": 7,
            "data": 'dateQuotation',
            "bSortable": true,
            "bSearchable": true,
            "defaultContent": ""
        }]
    });
});


function funcrenew(a) {
    $("#content_pop").css('display', 'block');
    $("#content_table").css('display', 'none');
    $("#top_head").css('display', 'block');
    $("#pload").html("<img src='img4/loadingIcon.gif'/ style='text-align:center;'>");
    $('#content_pop').load('pages/renew_suzuki_select.php?id=' + a);
}

$('#closepop').click(function() {
    $("#top_head").css('display', 'none');
    $('#content_table').css('display', 'block');
    $('#content_pop').empty();
    $('#closepop').css('display', 'none');
});
</script>