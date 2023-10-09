<?php
include "check-ses.php";
$_userLogin = $_SESSION["strUser"];
$_userRights = $_SESSION['claim'];
$_log_type = $_SESSION['log_type'];
echo "
<script>
var _userLogin = '$_userLogin';
var _userRights = '$_userRights';
var _log_type = '$_log_type';
</script>
";
?>

<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>
<div id="pload" style="margin-left: 46%; margin-top: 10px;"></div>
<div id="top_head" style=" display: none;">
    <header>
        <div class="widget-header widget-header-flat" style="text-align:left;border:solid thin #5098c9;">&nbsp;&nbsp;
            <h4><i class="icon-search"></i> ข้อมูลต่ออายุใหม่ (Mitsubishi)</h4>
            <div style="float:right; display: none;" id="closepop" class="bg-close">X</div>
        </div>
    </header>
</div>
<div id="content_pop"></div>
<div id="content_table">
    <div class="container-fluid outer">
        <div class="row-fluid">
            <div class="span12 inner">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-box">
                            <header>
                                <div class="widget-header widget-header-flat" style="text-align:left;border:solid thin #5098c9;">&nbsp;&nbsp; <h4><i class="icon-star"></i> ตรวจสอบ/แจ้งต่ออายุ</h4>
                                </div>
                            </header>
                            <div id="collapse4" class="body" style="background-color:#f5f5f5;padding:10px;">

                                <div id="search">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="chkRenew" style="font-size:12px;">
                                        <thead>
                                            <tr>
                                                <th>อนุมัติ</th>
                                                <th>ใบประกัน</th>
                                                <th>ดูข้อมูล</th>
                                                <th>เลขรับแจ้ง</th>
                                                <th>ชื่อผู้เอาประกัน</th>
                                                <th>รุ่นรถ</th>
                                                <th>ทะเบียนรถ</th>
                                                <th>ทุนต่ออายุ</th>
                                                <th>วันที่แจ้งต่ออายุ</th>
                                                <th>ผู้ติดตาม</th>
                                                <th>ชำระเงิน</th>
                                                <th>เลขกรมธรรม์</th>
                                                <th>การจัดส่ง</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var tables = $('#chkRenew').DataTable({
        "processing": true,
        "serverSide": true,
        "aaSorting": [
            [8, 'desc']
        ],
        "ajax": {
            "url": 'services/CheckRenewInformation/CheckRenewInformation.controller.php',
            "type": 'POST',
            "data": {
                "UserLogin": _userLogin,
                "UserRights": _userRights,
                "Controller": 'NewInsurance',
                "LogType": _log_type
            }
        },
        "columnDefs": [{
                "targets": 0,
                "data": 'Approval',
                "name": 'detail_renew.id_detail',
                "defaultContent": ""
            },
            {
                "targets": 1,
                "data": 'ViewDocument',
                "name": 'detail_renew.id_data_four',
                "defaultContent": ""
            },
            {
                "targets": 2,
                "data": 'ViewInformation',
                "name": 'detail_renew.id_data',
                "defaultContent": ""
            },
            {
                "targets": 3,
                "data": 'IdDataNew',
                "bSortable": false,
                "bSearchable": false,
                "defaultContent": ""
            },
            {
                "targets": 4,
                "data": 'CustomerName',
                "name": 'insuree.name',
                "defaultContent": ""
            },
            {
                "targets": 5,
                "data": 'CarName',
                "name": 'tb_mo_car.name',
                "defaultContent": ""
            },
            {
                "targets": 6,
                "data": 'CarRegistName',
                "bSortable": false,
                "bSearchable": false,
                "defaultContent": ""
            },
            {
                "targets": 7,
                "data": 'RenewFund',
                "bSortable": false,
                "bSearchable": false,
                "defaultContent": ""
            },
            {
                "targets": 8,
                "data": 'RenewDate',
                "name": 'detail_renew.date_detail',
                "defaultContent": ""
            },
            {
                "targets": 9,
                "data": 'UserRenew',
                "name": 'detail_renew.userdetail',
                "defaultContent": ""
            },
            {
                "targets": 10,
                "data": 'DetailPayment'
            },
            {
                "targets": 11,
                "data": 'InsureNo'
            },
            {
                "targets": 12,
                "data": 'ThaiPostID'
            }
        ]
    });
    // "data": 'DetailRenew',
    // "name": 'detail_renew.detailcost',

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