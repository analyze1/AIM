<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
$id_mo_car=$_POST['id'];
?>
<div class="widget-box">                                        

                    <div id="collapse4" class="body">
					<div class='span12'>
					<b class='tap_font' id='title_car'></b>
					</div>
                       <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table table-striped table-bordered " id="detail_stock_car">
                        <thead> 
                            <tr class="info" align="center" style=' background: #40b3ff  !important; background-image: linear-gradient(to bottom, #40b3ff, #006db0)  !important; padding: 10px 20px 10px 20px; font-family: Arial; background-image: -o-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -ms-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -moz-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -wedkit-linear-gradient(to bottom, #40b3ff, #006db0)  !important; '>
                                <th><span class='font_color'>รุ่นย่อย (modal)</span></th> 
                                <th><span class='font_color'>ปีรถยนต์</span></th>
                                <th><span class='font_color'>สีรถยนต์</span></th>
								<th><span class='font_color'>เลขตัวเครื่อง</span></th>
								<th><span class='font_color'>เลขตัวถัง</span></th>
								<th><span class='font_color'>วันเริ่มชำระ</span></th>
								<th><span class='font_color'>จำนวนวันบันทึก</span></th>
								<th><span class='font_color'>วันที่ขาย</span></th>
								<th><span class='font_color'>ราคารถ</span></th>
								<th><span class='font_color'>ทำใบเสนอราคา</span></th>

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
			<script type='text/javascript'>
					$("#detail_stock_car").dataTable(
{
		'processing':true,
		"serverSide": false,
		"deferRender": true,
		"lengthMenu": [[3,10, 25, 50, -1], [3,10, 25, 50, "All"]],
		"ajax":{
			'url':'ajax/ajax_select_detail_stock_car.php',
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
			"data": 'car_regis_year',
			"defaultContent": "",
		},
		{
			"targets": 2,
			'bSortable' : true,
			"data": 'color_name',
			"defaultContent": ""
		},
		{
			"targets": 3,
			'bSortable' : true,
			"data": 'car_motor',
			"defaultContent": "",
		},
		{
			"targets": 4,
			'bSortable' : true,
			"data": 'car_body',
			"defaultContent": "",
		},
		{
			"targets": 5,
			'bSortable' : true,
			"data": 'startdate_payment',
			"defaultContent": "",
		},
		{
			"targets": 6,
			'bSortable' : true,
			"data": 'enddate_payment',
			"defaultContent": "",
		},
		{
			"targets": 7,
			'bSortable' : true,
			"data": 'date_sale',
			"defaultContent": "",
		},
		{
			"targets": 8,
			'bSortable' : true,
			"data": 'car_price',
			"defaultContent": "",
		},
		{
			"targets": 9,
			'bSortable' : true,
			"data": 'button',
			"defaultContent": "",
		}
		]
	});
			</script>