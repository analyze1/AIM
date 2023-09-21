<?php
include "check-ses.php";
include "../inc/connectdbs.inc.php";
if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$dealer_name=ทุกดิลเลอร์;
}
else
{
	$dealer_name="ดิลเลอร์ ".$_SESSION["strUser"];
}
?>
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<script src="js/jquery.imask.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/DT_bootstrap.js"></script>

<script src="assets/js/bootstrap-tooltip.js"></script>
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />
<style>
.tap_font
{
	padding-left:30px;
	 font-family: "Times New Roman", Times, serif;
}
.font_si
{
	font-size:12px;
	 font-family: "Times New Roman", Times, serif;
}
.font_color
{
	font-size:13px;
	color:WHITE;
	font-family: "Times New Roman", Times, serif;
}
.btn_click_on{
  background: #6ec5ff;
  background-image: -webkit-linear-gradient(top, #6ec5ff, #007ec7);
  background-image: -moz-linear-gradient(top, #6ec5ff, #007ec7);
  background-image: -ms-linear-gradient(top, #6ec5ff, #007ec7);
  background-image: -o-linear-gradient(top, #6ec5ff, #007ec7);
  background-image: linear-gradient(to bottom, #6ec5ff, #007ec7);
  -webkit-border-radius: 10;
  -moz-border-radius: 10;
  border-radius: 10px;
  font-family: Arial;
  color: #ffffff;
  font-size: 13px;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
  border: none;
}

.btn_click_on:hover {
  background: #0097f5;
  background-image: -webkit-linear-gradient(top, #0097f5, #7accff);
  background-image: -moz-linear-gradient(top, #0097f5, #7accff);
  background-image: -ms-linear-gradient(top, #0097f5, #7accff);
  background-image: -o-linear-gradient(top, #0097f5, #7accff);
  background-image: linear-gradient(to bottom, #0097f5, #7accff);
  text-decoration: none;
}
.img_table {
    width: 35px;
	
	
	position:absolute;
    -webkit-transition-property: width; /* Safari */
    -webkit-transition-duration: 0.5s; /* Safari */
    transition-property: width;
    transition-duration: 0.5s;
}

.img_table:hover {
	
    width: 130px;
	z-index:1;
}
</style>
<div class='span12'>
<button class='btn btn-success' onclick='slide_stock_form();'>ทำสต๊อกรถยนต์</button>&nbsp;&nbsp;
<button class='btn btn-success' onclick='slide_order_form();'>สั่งซื้อรถยนต์</button>
</div>
<div class='span12'>
<!--เริ่มบรรทัดไหม่-->
</div>
<div style='width:97%; display:none;' id='show_form_car'>

</div>
<div class='span12'>
<!--เริ่มบรรทัดไหม่-->
</div>
<div id='show_data_car' style='width:97%'>

            <div class="span12" id="show_table" style='width:100%'>
                
            <!-- /.row-fluid -->
        </div>
        <!-- /.outer -->


</div>
<div class='span12'>
<!--เริ่มบรรทัดไหม่-->
</div>
<div style='width:97%;'>
<div class='span6 span-margin'>
<div class="row-fluid">
    <!-- .inner -->
    <div class="span12 inner">
        <!--Begin Datatables-->
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">                                        

                    <div id="collapse4" class="body">
					<div class='span12'>
					<b class='tap_font'>รายการสต๊อกรถยนต์ <?php echo $dealer_name; ?></b>
					</div>
                       <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table table-striped table-bordered" id="stock_car">
                        <thead> 
                            <tr class="info" align="center" style=' background: #40b3ff  !important; background-image: linear-gradient(to bottom, #40b3ff, #006db0)  !important; padding: 10px 20px 10px 20px; font-family: Arial; background-image: -o-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -ms-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -moz-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -wedkit-linear-gradient(to bottom, #40b3ff, #006db0)  !important; '>
                                <th><span class='font_color'>รุ่นรถ</span></th> 
                                <th><span class='font_color'>จำนวนรถ</span></th>
								<th><span class='font_color'>จำนวนสีรถ</span></th>
                                <th><span class='font_color'>ดูข้อมูล</span></th>

                            </tr>
                        </thead> 
                    </table>
   

                    <!-- /.row-fluid -->
                </div>


                <!-- /.inner -->
            </div>
            <!-- /.row-fluid -->
        </div>
        <!-- /.outer -->
</div>
</div>
</div>
</div>
<!--กราฟ-->
<div class='span5' style='margin-left:0px;'  id='stock_pie'>

</div>
</div>
<div class='span12'>
<!--เริ่มบรรทัดไหม่-->
</div>
<!--<div style='width:97%;'>
<div class='span12' >
<input type='button' class='btn_click_on' onclick='show_form("stock");' value='ทำสต๊อกรถยนต์'>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' class='btn_click_on' onclick='show_form("my");' value='จองรถยนต์'>
</div>
</div>-->

<div class='span12'>
<!--เริ่มบรรทัดไหม่-->
</div>


<script type="text/javascript">
//กระบวนการทำสต๊อกรถยนต์
$("#stock_car").dataTable(
{
		'processing':true,
		"serverSide": false,
		"deferRender": true,
		"lengthMenu": [[4,10, 25, 50, -1], [4,10, 25, 50, "All"]],
		"ajax":{
			'url':'ajax/ajax_select_stock_car.php'
		},
		"columnDefs": [
		{
			"targets": 0,
			'bSortable' : true,
			"data": 'name_mo_car',
			"defaultContent": ""
		},
		{
			"targets": 1,
			'bSortable' : true,
			"data": 'num_car',
			"defaultContent": "",
		},
		{
			"targets": 2,
			'bSortable' : true,
			"data": 'color_name',
			"defaultContent": "",
		},
		{
			"targets": 3,
			'bSortable' : false,
			"data": 'button',
			"defaultContent": ""
		}
		]
	});

	function show_detail_car(id_mo_car,name_mo_car)
	{
		$("#show_data_car").hide();
		$.post("ajax/ajax_datatable_select_detail_stock_car.php",
		{id:id_mo_car},
		function(data){
			$("#show_table").html(data);
		if(name_mo_car!='')
		{
		$("#title_car").html("รายการสต๊อก รุ่นรถ "+name_mo_car);
		}
		else
		{
			$("#title_car").html("");
		}
		$("#show_data_car").slideDown();
		});
		}
		function show_detail_my(id_mo_car,name_mo_car)
		{
		$("#show_data_car").hide();
		$.post("ajax/ajax_datatable_select_detail_my_car.php",
		{id:id_mo_car},
		function(data){
			$("#show_table").html(data);
		if(name_mo_car!='')
		{
		$("#title_car").html("รายการจอง รุ่นรถ "+name_mo_car);
		}
		else
		{
			$("#title_car").html("");
		}
		$("#show_data_car").slideDown();
		});
		}



	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//general
function cross_datatable()
{
	$("#show_data_car").slideUp();
}
function slide_stock_form()
{
			$("#show_form_car").hide();

			$("#show_form_car").load("ajax/ajax_form_stock_car.php");
			
			$("#show_form_car").slideDown();
}
function slide_order_form()
{
			$("#show_form_car").hide();

			$("#show_form_car").load("ajax/ajax_form_order_car.php");
			
			$("#show_form_car").slideDown();
}
function form_quotation(id)
{
	$("#show_form_car").hide();
	$("#show_form_car").load("ajax/ajax_form_quotation_car.php?id_stock="+id);
	$("#show_form_car").slideDown();
}
$('#stock_pie').html('<center><br><br><br><br><img src="img4/loadingIcon.gif"  >&nbsp;<img src="img4/loadingIcon.gif"  ></center>').load("ajax/ajax_stock_highcharts.php");

	</script>
