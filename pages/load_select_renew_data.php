<?php
include "check-ses.php";
include "../inc/connectdbs.pdo.php";
include "../inc/function.php";

?>

<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="assets/css/modalbank.css">
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>
<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">

<script type="text/javascript" src="js/jquery.number.js"></script>
<style>
   .table tr:nth-child(odd) {
    background: white !important;
} 
    </style>
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
                                        class="icon-list"></i> ตารางเอกสารแจ้งเปลียนผู้ดูแลต่ออายุ : </h4>
                            </div>
                            <br>
                        </header>
                        <div class="body">
                            <div id="search">
                                <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered"
                                    id="data_renew">
                                    <thead>
                                        <tr>
                                            <th class="" style="text-align:center;">สถานะ</th>
                                            <th class="" style="text-align:center;">เอกสาร</th>
                                            <th class="" style="text-align:center;">รหัสดิลเลอร์</th>
                                            <th class="" style="text-align:center;">ชื่อบริษัท</th>
                                            <th class="" style="text-align:center;">ผู้รับผิดชอบ</th>
                                            <th class="" style="text-align:center;">เบอร์ติดต่อ</th>
                                            <th class="" style="text-align:center;">ผลประโยชน์</th>
                                        </tr>
                                    </thead>
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
    <div class="row-fluid">
   <div class="span12" style="">
      <div class="widget-box">
         <div class="widget-header widget-header-flat">
            <h4>คำถามที่ผมบ่อย</h4>
         </div>
         <div class='span12' style="background:#fff;margin: 0;">
         <div class="tab-pane fade active in">
           
               <li style='width:50%; display:none;' align='center'><a data-toggle="tab" onclick="open_faq('ti_tab1');" id='ti_tab1' href="#">ปัญหา product knowledge ที่พบบ่อย</a></li>
          
            <div id="myfaq" >
            </div>
         </div>
      </div>
      </div>
   </div>
</div>
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
                <h4 class="modal-title">แจ้งต่ออายุประกันภัย <span
                        style="font-size:23px;color:#ff3939">ทันที!</span><span
                        style="font-size:14px;padding-left:20px;font-color:#dedede"> ( โปรดระบุ! ความต้องการเพิ่มเติม
                        )</span></h4>
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
    let $modal = $($(this).data('target'));
    $('.modal-body', $modal).empty();
    $modal.show();
    $('.modal-body', $modal).load($(this).attr('href'));
});
</script>
<script>


function edit_form_renew(dealer_user) {
    load_page("pages/load_form_renew_data.php?user=" + dealer_user, "แก้ไขข้อมูลผู้ดูแลต่ออายุ");
}
function open_faq(id)
{

	$("#myfaq").load("ajax/ajax_faq_"+id+".php");

}
function open_faq1(){
    document.getElementById('loadingIcon').style.display = 'flex';

    $("#ti_tab1").trigger("click");
    document.getElementById('loadingIcon').style.display = 'none';
}
open_faq1();
function load_renew(p_dealer, n_dealer) {
    $("#data_comp").html(" (" + p_dealer + ") " + n_dealer)
    $.post("ajax/ajax_load_form_renew_data.php", {
        user: p_dealer,
        name: n_dealer
    }, function(data) {
        $('#modal_edit_renew_label').find('.modal-body').html(data);
    });

}


var tables = $('#data_renew').DataTable({
    "processing": false,
    "serverSide": false,
    "ajax": 'ajax/ajax_load_select_renew_data.php',
    "columnDefs": [{
            "targets": 0,
            "data": 'Status',
            'bSortable': false,
            "bSearchable": false,
            "defaultContent": ""
        },
        {
            "targets": 1,
            "data": 'Doc',
            'bSortable': true,
            "bSearchable": true,
            "defaultContent": ""
        },
        {
            "targets": 2,
            "data": 'DealerID',
            "bSortable": false,
            "bSearchable": true,
            "defaultContent": ""
        },
        {
            "targets": 3,
            "data": 'NameDealer',
            "bSortable": false,
            "bSearchable": true,
            "defaultContent": ""
        },
        {
            "targets": 4,
            "data": 'NameAp',
            "bSortable": true,
            "bSearchable": true,
            "defaultContent": ""
        },
        {
            "targets": 5,
            "data": 'TelAp',
            "bSortable": false,
            "bSearchable": true,
            "defaultContent": ""
        },
        {
            "targets": 6,
            "data": 'Benefit',
            "bSortable": false,
            "bSearchable": true,
            "defaultContent": ""
        }
    ],
    "order": [
        [1, 'desc']
    ]
});
</script>