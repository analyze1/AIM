<?php
include "check-ses.php";
include "../../inc/connectdbs.pdo.php"; 
?>
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/DT_bootstrap.js"></script>
<script type="text/javascript" src="js/js_Renew.js"></script>

<style>
.modal-body
{
    position: relative;
    background-color: #fff;
    max-height: 500px;
}
.modal-content
{
    position: relative;
    background-color: #fff;
    border: 1px solid #999;
   /* SET THE WIDTH OF THE MODAL */
 
    max-height: 500px;
}
@media screen and (min-width: 1250px) {
    .modal-content {
    margin: -30px 0 0 -300px;
    }
}
@media screen and (min-width: 1250px) {
    .width_attack {
        width: 60%;
		
    }
}


</style>

<script src="assets/js/bootstrap-tooltip.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("a[rel='tooltip']").tooltip({'placement': 'top', 'z-index': '3000'});
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

                       <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table table-striped table-bordered" id="example1">
                        <thead> 
                            <tr class="info" align="center">
                                <td width="40"><div align="center">แจ้ง</div></td>
                                <td width="40"><div align="center">-</div></td>
                                <td width="130"><div align="center">เลขที่รับแจ้ง</div></td>
                                <td width="200"><div align="center">ชื่อผู้เอาประกัน</div></td>
                                <td width="75"><div align="center">วันที่แจ้ง</div></td>
                                <td width="75"><div align="center">วันที่คุ้มครอง</div></td>
                                <td width="100"><div align="center">พิมพ์ พ.ร.บ.</div></td>
                                <td width="90"><div align="center">รุ่นรถ</div></td>
                                <td width="150"><div align="center">เลขตัวถัง/ตัวเครื่อง</div></td>
                                <td width="100"><div align="center">ทุนประกันภัย</div></td>
                                <td width="100"><div align="center">เบี้ย</div></td>
                                <td width="20"><div align="center">อุปกรณ์เพิ่มเติม</div></td>
                                <td width="100"><div align="center">เพิ่มเบี้ย</div></td>
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
<div class="modal fade width_attack " id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">กรุณาเลือกเมนูการแก้สลักหลัง</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <a href="#"  data-dismiss="modal" aria-hidden="true" class="btn">Close</a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
       <div class="modal-dialog" >
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
var table = $('#example1').DataTable({
    "processing": false,
    "serverSide": true,
    "deferRender": true,
    //"ordering":false,
    "order": [[ 3, "desc" ]],
    "ajax": {
        "url":"ajax/Ajax_Attached_Act.php",
        "type": "POST"
    },
    "columns": [
    {"data":"ACT"},
    {"data":"send_Attached"},
    {"data":"id_data"},
    {"data":"name"},
    {"data":"send_date"},
    {"data":"start_date"},
    {"data":"print_act"},
    {"data":"mo_car"},
    {"data":"car_body"},
    {"data":"cost"},
    {"data":"pre"},
    {"data":"product"},
    {"data":"CostProduct"}
    ]
    
});
</script>

<script type='text/javascript'>//<![CDATA[ 
$(document).on('click','a[data-toggle=modal]', function() {
       // event.preventDefault();
       var $modal=$($(this).data('target'));
       $('.modal-body',$modal).empty();
       $modal.show();
       $('.modal-body',$modal).load($(this).attr('href'));
   });
</script>