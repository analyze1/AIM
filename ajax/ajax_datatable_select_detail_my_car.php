<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
$id_mo_car=$_POST['id'];
?>
<style>
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
body {
  font-family: "Open Sans", sans-serif;
  line-height: 1.25;
}
.table-mobile {
  border: 1px solid #ccc;
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
}
.table-mobile caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}
.table-mobile .tr-mobile {
  background: #f8f8f8;
  border: 1px solid #ddd;
  padding: .35em;
}
.table-mobile th,
.table-mobile .td-mobile {
  padding: .625em;
  text-align: center;
}
.table-mobile th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
}
@media screen and (max-width: 600px) {
  .table-mobile {
    border: 0;
  }
  .table-mobile caption {
    font-size: 1.3em;
  }
  .table-mobile .thead-mobile {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }
  .table-mobile .tr-mobile {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }
  .table-mobile .td-mobile {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }
  .table-mobile .td-mobile:before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  .table-mobile .td-mobile:last-child {
    border-bottom: 0;
  }
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
    margin: -40px 0 0 -30%;
    }
}
@media screen and (min-width: 1250px) {
    .width_attack {
        width: 50%;
		
    }
}
</style>
<div class="widget-box">                                        

                    <div id="collapse4" class="body">
					<div class='span12'>
					<b class='tap_font' id='title_car'></b>
					</div>
                       <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table table-striped table-bordered " id="detail_my_car">
                        <thead> 
                            <tr class="info" align="center" style=' background: #40b3ff  !important; background-image: linear-gradient(to bottom, #40b3ff, #006db0)  !important; padding: 10px 20px 10px 20px; font-family: Arial; background-image: -o-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -ms-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -moz-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -wedkit-linear-gradient(to bottom, #40b3ff, #006db0)  !important; '>
                               <th><span class='font_color'>รุ่นย่อย</span></th> 
                                <th><span class='font_color'>ผู้จอง</span></th>
								<th><span class='font_color'>ปีรถ</span></th>
								<th><span class='font_color'>สีรถ</span></th>
								<th><span class='font_color'>เลขตัวเครื่อง</span></th>
								<th><span class='font_color'>เลขตัวถัง</span></th>
                                <th><span class='font_color'>ราคารถ</span></th>
								<th><span class='font_color'>ผู้บันทึก</span></th>
								<!--<th><span class='font_color'>ดูรายละเอียด</span></th>-->

                            </tr>
                        </thead> 
                    </table>
					<div class='span12' style='width:100%'>
					<span style='float:right;'><button class='btn btn-small btn-block' onclick='cross_datatable();'>ปิด</button></span>
					</div>

                    <!-- /.row-fluid -->
                </div>


                <!-- /.inner -->
            </div>
			<div class="modal fade width_attack" id="detail_my_car_modal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><font color='BLACK' id='name_customer1' >รายละเอียกลูกค้า</font></h4>
        </div>
        <div class="modal-body" id='form_detail_customer_html1'>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
			<script type='text/javascript'>
					$("#detail_my_car").dataTable(
{
		'processing':true,
		"serverSide": false,
		"deferRender": true,
		"lengthMenu": [[3,10, 25, 50, -1], [3,10, 25, 50, "All"]],
		"ajax":{
			'url':'ajax/ajax_select_detail_my_car.php',
			type:"POST",
			data:{id:'<?php echo $id_mo_car;?>'}
		},
		"columnDefs": [
		{
			"targets": 0,
			'bSortable' : true,
			"data": 'sub_name',
			"defaultContent": ""
		},
		{
			"targets": 1,
			'bSortable' : true,
			"data": 'name',
			"defaultContent": "",
		},
		{
			"targets": 2,
			'bSortable' : true,
			"data": 'car_regis',
			"defaultContent": ""
		},

		{
			"targets": 3,
			'bSortable' : true,
			"data": 'color_name',
			"defaultContent": "",
		},
		{
			"targets": 4,
			'bSortable' : true,
			"data": 'car_motor',
			"defaultContent": "",
		},
		{
			"targets": 5,
			'bSortable' : true,
			"data": 'car_body',
			"defaultContent": "",
		},
		{
			"targets": 6,
			'bSortable' : true,
			"data": 'car_price',
			"defaultContent": "",
		},
		{
			"targets": 7,
			'bSortable' : true,
			"data": 'login',
			"defaultContent": "",
		}/*,
		{
			"targets": 8,
			'bSortable' : true,
			"data": 'button',
			"defaultContent": "",
		}*/
		]
	});
	function detail_my_car(id,name)
	{
	$("#name_customer1").html("รายละเอียดลูกค้า "+name);
	  $.post("ajax/ajax_form_detail_customer.php",{id_my:id},function(data){$("#form_detail_customer_html1").html(data);});
	}
			</script>