<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>

<style>
/* .modal-content {
    width: 970px;
} */

.widget-header-flat-yellow {
    border-style: none !important;
    color: #FFFFFF !important;
    background: linear-gradient(to left, #fddf7b, #FAC411) !important;
}

.dataTables_empty {
    color: red;
    font-size: large;
}
</style>

<div id="top_head" style=" display: none;">
    <header>
        <div class="widget-header widget-header-flat" style="text-align:left;border:solid thin #5098c9; z-index:999;">&nbsp;&nbsp;
            <h4><i class="icon-search"></i> ข้อมูลต่ออายุ (MITSUBISHI)</h4>
            <div style="float:right; display: none;" id="closepop" class="bg-close">X</div>
        </div>
    </header>
</div>
<div id="pload" style="margin-left: 46%; margin-top: 10px;"></div>
<div id="content_pop"></div>
<div id="content_table" class="container-fluid outer">
    <div class="row-fluid">
        <!-- .inner -->
        <div class="span12 inner">
            <!--Begin Datatables-->
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <header>
                            <div class="widget-header widget-header-flat"
                                style="text-align:left;border:solid thin #5098c9;">&nbsp;&nbsp;
                                <h4><i class="icon-list"></i> ติดตามต่ออายุวันนี้ : <font id="followToDay"></font>
                                </h4>
                            </div>
                        </header>
                        <div id="collapse4" class="body" style="background-color:#f5f5f5;padding:10px;">
                            <div id="search">
                                <table id="TableFollowToDay" class="display" style="width:100%; font-size:12px;">
                                    <thead>
                                        <tr style="height: 30px;">
                                            <th style='width: 200px;'></th>
                                            <th>วันสิ้นสุด</th>
                                            <th>เลขที่รับแจ้ง/กธ.</th>
                                            <th>ชื่อผู้เอาประกัน</th>
                                            <th>ยี่ห้อ/รุ่น</th>
                                            <th>ทะเบียน</th>
                                            <th>อายุรถ</th>
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

<hr>
<!-- ติดตามทั้งหมด -->

<div id="content_table_day" class="container-fluid outer">
    <div class="row-fluid">
        <!-- .inner -->
        <div class="span12 inner">
            <!--Begin Datatables-->
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <header>
                            <div class="widget-header widget-header-flat-yellow"
                                style="text-align:left;border:solid thin #5098c9;">&nbsp;&nbsp;
                                <h4><i class="icon-list"></i> ติดตามต่ออายุทั้งหมด </h4>
                            </div>
                        </header>
                        <div id="collapse4" class="body" style="background-color:#f5f5f5;padding:10px;">
                            <div id="search">
                                <table id="TableFollowAll" class="display" style="width:100%; font-size:12px;">
                                    <thead>
                                        <tr style="height: 30px;">
                                            <th style='width: 200px;'></th>
                                            <th>วันสิ้นสุด</th>
                                            <th>เลขที่รับแจ้ง/กธ.</th>
                                            <th>ชื่อผู้เอาประกัน</th>
                                            <th>ยี่ห้อ/รุ่น</th>
                                            <th>ทะเบียน</th>
                                            <th>อายุรถ</th>
                                            <th>นัดครั้งถัดไป</th>
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

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title">แจ้งต่ออายุประกันภัย <span
                        style="font-size:23px;color:#ff3939">ทันที!</span><span
                        style="font-size:14px;padding-left:20px;font-color:#dedede"> ( โปรดระบุ! ความต้องการเพิ่มเติม
                        )</span></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>

            </div>
        </div>
    </div>
</div>

<script type='text/javascript'>
$(document).on('click', 'a[data-toggle=modal]', function() {
    // event.preventDefault();
    var $modal = $($(this).data('target'));
    $('.modal-body', $modal).empty();
    $modal.show();
    $('.modal-body', $modal).load($(this).attr('href'));
});

$(document).ready(function() {
    $('#TableFollowAll').DataTable({
        "language": {
            "emptyTable": "ไม่พบข้อมูล"
        },
        "ajax": "ajax/ajax_load_follow.php",
        "columns": [{
                "targets": 0,
                "data": "showData",
                "className": "my_class",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            },
            {
                "targets": 1,
                "data": "endDate",
                "className": "text-center",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            },
            {
                "targets": 2,
                "data": "idData",
                "className": "text-center",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            },
            {
                "targets": 3,
                "data": "name",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            },
            {
                "targets": 4,
                "data": "mocar",
                "className": "text-center",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            },
            {
                "targets": 5,
                "data": "carbody",
                "className": "text-center",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            },
            {
                "targets": 6,
                "data": "yearCar",
                "className": "text-center",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            },
            {
                "targets": 7,
                "data": "date_alert",
                "className": "text-center",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            }
        ]
    });

    $('#TableFollowToDay').DataTable({
        "language": {
            "emptyTable": "ไม่พบข้อมูล"
        },
        "ajax": "ajax/ajax_load_follow.php?dateStatus=toDay",
        "columns": [{
                "targets": 0,
                "data": "showData",
                "className": "my_class",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            },
            {
                "targets": 1,
                "data": "endDate",
                "className": "text-center",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            },
            {
                "targets": 2,
                "data": "idData",
                "className": "text-center",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            },
            {
                "targets": 3,
                "data": "name",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            },
            {
                "targets": 4,
                "data": "mocar",
                "className": "text-center",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            },
            {
                "targets": 5,
                "data": "carbody",
                "className": "text-center",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            },
            {
                "targets": 6,
                "data": "yearCar",
                "className": "text-center",
                "bSortable": true,
                "bSearchable": true,
                "defaultContent": ""
            }
        ]
    });

    let followToDay = new Date();
    $('#followToDay').text(followToDay.toLocaleDateString('th-TH'));
});

async function renew(a) {
    // $('#content_table').
    $("#content_pop").css('display', 'block');
    $("#content_table").css('display', 'none');
    $("#content_table_day").css('display', 'none');
    // $("#content_table").hide();
    // document.getElementById('content_table').style.display = 'none';
    $("#top_head").css('display', 'block');
    //$('#collapse4').css('display', 'none');
    await $("#pload").html("<img src='img4/loadingIcon.gif' style='text-align:center;'>");
    $('#content_pop').load('pages/renew_suzuki_select.php?id=' + a);
}

function openPrint(e) {
    window.open(`print/print_Quotation.php?id=${e}", "", "width=1000, height=900`);
}

$('#closepop').click(function() {
    $("#top_head").css('display', 'none');
    $('#content_table').css('display', 'block');
    $('#content_table_day').css('display', 'block');
    $('#content_pop').empty();
    $('#closepop').css('display', 'none');
});
</script>