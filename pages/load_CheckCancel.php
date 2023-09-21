<?php
include "check-ses.php";
// include "../../inc/connectdbs.pdo.php"; 
?>
<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/DT_bootstrap.js"></script>
<script type="text/javascript" src="js/js_Renew.js"></script>
<script src="assets/js/bootstrap-tooltip.js"></script>

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
    width: 1200px; /* SET THE WIDTH OF THE MODAL */
    margin: -30px 0 0 -300px;
    max-height: 500px;
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
                                <td width="100"><div align="center">พิมพ์ พ.ร.บ./<br>blank form</div></td>
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
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">ยกเลิกกรมธรรม์</h4>
			</div>
            <div class="modal-body">
            </div>
			<div class="modal-footer">
				<a href="#"  data-dismiss="modal" aria-hidden="true" class="btn">Close</a>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->

<script>
var table = $('#example1').DataTable({
    "processing": true,
    "serverSide": true,
    //"deferRender": true,
    //"ordering":false,
    "order": [[ 4, "desc" ]],
    "ajax": {
        "url":"ajax/Ajax_Check_Cancel.php",
        "type": "POST"
    },
	"language": {
	"emptyTable": "ไม่มีข้อมูลยกเลิก!"
			},
    "columns": [
    {"targets": 0,"bSortable" : false,"bSearchable": false,"data":"Status_Email","name":""},
    {"targets": 1,"bSortable" : false,"bSearchable": false,"data":"send_cancel","name":""},
    {"targets": 2,"bSortable" : false,"bSearchable": false,"data":"id_data_send","name":"data.id_data"},
    {"targets": 3,"bSortable" : false,"bSearchable": false,"data":"name","name":"insuree.name"},
    {"targets": 4,"bSortable" : true,"bSearchable": true,"data":"send_date","name":"data.send_date"},
    {"targets": 5,"bSortable" : false,"bSearchable": false,"data":"start_date","name":"data.start_date"},
    {"targets": 6,"bSortable" : false,"bSearchable": false,"data":"print_act"},
    {"targets": 7,"bSortable" : false,"bSearchable": false,"data":"mo_car","name":"tb_mo_car.name"},
    {"targets": 8,"bSortable" : false,"bSearchable": false,"data":"car_body","name":"detail.car_body"},
    {"targets": 9,"bSortable" : false,"bSearchable": false,"data":"cost","name":""},
    {"targets": 10,"bSortable" : false,"bSearchable": false,"data":"pre","name":""},
    {"targets": 11,"bSortable" : false,"bSearchable": false,"data":"product","name":""},
    {"targets": 12,"bSortable" : false,"bSearchable": false,"data":"CostProduct","name":""}
    ]
    
});

function print_Insurance(IDDATA) {
    window.open("print/print_Insurance.php?IDDATA="+IDDATA, "_blank", "toolbar=no, scrollbars=yes, resizable=yes, top=0, left=0,fullscreen=yes");   
};
</script>

<script type='text/javascript'>//<![CDATA[ 
   function open_add(href)
   {
	   $('#modal').find('.modal-body').load(href);
   }
</script>