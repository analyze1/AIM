<?php
include "check-ses.php";
$_userLogin = $_SESSION["strUser"];
$_statusUseAct = $_SESSION["use_prb"];
echo "<script>
var _userLogin = '$_userLogin';
var _statusUseAct = '$_statusUseAct';
</script>";
?>
<link type="text/css" rel="stylesheet" type="text/css" href="assets/dataTable/1.10.24/css/jquery.dataTables.css">
<!-- <script src="js/jquery-1.10.1.min.js"></script> -->
<script src="js/jquery-ui-1.10.3.custom.js"></script>
<!-- <script type="text/javascript" src="js/jquery-1.8.3.js"></script> -->
<script type="text/javascript" src="assets/dataTable/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/DT_bootstrap.js"></script>
<script type="text/javascript" src="js/js_Renew.js"></script>
<link rel="stylesheet" href="assets/css/tooltip.css">


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
                    <div id="collapse4_edit" class="body" style='display:none;'>
                    </div>
                    <div id="collapse4" class="body">

                        <table width="100%" style="border: 0;" cellpadding="0" cellspacing="0"
                            class="table table-striped table-bordered" id="example1">
                            <thead>
                                <tr class="info" style="text-align: center">
                                    <td width="40">
                                        <div style="text-align: center">แจ้ง</div>
                                    </td>
                                    <td width="40">
                                        <div style="text-align: center">-</div>
                                    </td>
                                    <td width="130">
                                        <div style="text-align: center">เลขที่รับแจ้ง</div>
                                    </td>
                                    <td width="200">
                                        <div style="text-align: center">ชื่อผู้เอาประกัน</div>
                                    </td>
                                    <td width="75">
                                        <div style="text-align: center">วันที่แจ้ง</div>
                                    </td>
                                    <td width="75">
                                        <div style="text-align: center">วันที่คุ้มครอง</div>
                                    </td>
                                    <td width="100">
                                        <div style="text-align: center">พิมพ์ พ.ร.บ.</div>
                                    </td>
                                    <td width="100">
                                        <div style="text-align: center">พิมพ์ พ.ร.บ. BlankForm</div>
                                    </td>
                                    <td width="90">
                                        <div style="text-align: center">รุ่นรถ</div>
                                    </td>
                                    <td width="150">
                                        <div style="text-align: center">เลขตัวถัง/ตัวเครื่อง</div>
                                    </td>
                                    <td width="100">
                                        <div style="text-align: center">ทุนประกันภัย</div>
                                    </td>
                                    <td width="100">
                                        <div style="text-align: center">เบี้ย</div>
                                    </td>
                                    <td width="20">
                                        <div style="text-align: center">อุปกรณ์เพิ่มเติม</div>
                                    </td>
                                    <td width="100">
                                        <div style="text-align: center">เพิ่มเบี้ย</div>
                                    </td>
                                </tr>
                            </thead>
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
                    <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal">
                            <font color='BLACK'>Close</font>
                        </a></div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- Modal -->

        <script>
        var table = $('#example1').DataTable({
            "processing": true,
            "serverSide": true,
            //"ordering":false,
            "order": [
                [4, "desc"]
            ],
            //"ajax" : 'ajax/Ajax_Individuals.php?person=3',
            "ajax": {
                "url": 'CarInsuranceInformation/CarInsuranceInformation.controller.php',
                "type": 'POST',
                "dataSrc": function(response){
                    response.data = response.Data.data;
                    response.recordsTotal = response.Data.recordsTotal;
                    response.recordsFiltered = response.Data.recordsFiltered;
                    response.draw = response.Data.draw;
                    console.log(response);
                    return response.data;
                },
                "data": {
                    "UserLogin": _userLogin,
                    "StatusUseAct": _statusUseAct,
                    "GetWork": 'Insurance',
                    "PersonType": '3'
                }
            },
            "columns": [{
                    "targets": 0,
                    //"name":"",
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "StatusEmail"
                },
                {
                    "targets": 1,
                    //"name":"",
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "PrintInsurance"
                },
                {
                    "targets": 2,
                    //"name":"",
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "IdDataSend"
                },
                {
                    "targets": 3,
                    //"name":"",
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "Name"
                },
                {
                    "targets": 4,
                    "name": "data.send_date",
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "SendDate"
                },
                {
                    "targets": 5,
                    //"name":"",
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "StartDate"
                },
                {
                    "targets": 6,
                    //"name":"",
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "PrintAct"
                },
                {
                    "targets": 7,
                    //"name":"",WSAPIONLINE
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "WSAPIONLINE"
                },
                {
                    "targets": 8,
                    //"name":"",
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "MoCar"
                },
                {
                    "targets": 9,
                    //"name":"",
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "CarBody"
                },
                {
                    "targets": 10,
                    //"name":"",
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "Cost"
                },
                {
                    "targets": 11,
                    //"name":"",
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "Pre"
                },
                {
                    "targets": 12,
                    //"name":"",
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "Product"
                },
                {
                    "targets": 13,
                    //"name":"",
                    "bSortable": false,
                    "bSearchable": false,
                    "data": "CostProduct"
                }
            ]

        });

        function print_Insurance(IDDATA) {
            window.open("print/print_Insurance.php?IDDATA=" + IDDATA, "_blank",
                "toolbar=no, scrollbars=yes, resizable=yes, top=0, left=0,fullscreen=yes");
        }

        function print_Insurance_new(IDDATA) {
            window.open("print/print_Insurance_new.php?IDDATA=" + IDDATA, "_blank",
                "toolbar=no, scrollbars=yes, resizable=yes, top=0, left=0,fullscreen=yes");
        }
        </script>

        <script type='text/javascript'>
        function open_check(href) {

            $("#modal").find(".modal-body").load(href);
            $("#modal").show();
        }

        function open_inform(id) {
            $(".close").trigger("click");
            $("#collapse4").hide();
            $("#collapse4_edit").show();
            $("#collapse4_edit").html(
                '<p><br><br><center><img src="img4/loadingIcon.gif"  > <img src="img4/loadingIcon.gif"  > <img src="img4/loadingIcon.gif"  ><center></p>'
            );
            $.post("pages/load_Insurance_edit.php", {
                    id_data: id
                },
                function(data) {
                    $("#collapse4_edit").html(data);
                });
        }

        function cross_inform() {
            $("#collapse4_edit").hide();
            $("#collapse4").show();
        }

        function ResolveAPIAct(dataID) {
            Swal.fire({
                title: 'ต้องการออก Smart พ.ร.บ. หรือไม่',
                text: `เลขที่รับแจ้ง : ${dataID}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {

                if (result.value) {

                    $.ajax({
                        type: "POST",
                        url: "./ajax/ajax_post_api_prb_suzuki.php",
                        data: {
                            DataId: dataID
                        },
                        dataType: "JSON",
                        success: function(response) {
                            const _res = response;
                            //alert(_res.msg);
                            Swal.fire(
                                '',
                                _res.msg,
                                'success'
                            );
                            table.ajax.reload();
                        },
                        error: (err) => {
                            alert(err);
                        }
                    });
                }
            });
        }
        </script>