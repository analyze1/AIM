<?php
include "check-ses.php";
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$dealer_name=ทุกดิลเลอร์;
	$dealer_login="";
}
else
{
	$dealer_name="ดิลเลอร์ ".$_SESSION["strUser"];
	$dealer_login=" WHERE login = '".$_SESSION["strUser"]."'";
}
$select_quotation_sql="SELECT * FROM tb_quotation_car ".$dealer_login." ORDER BY date_save DESC";
$select_quotation_query=mysql_query($select_quotation_sql,$cndb1);
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
//////////////////////////////////////////////////////////////////////////////////////////////////////////
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
.table-mobile .th-mobile,
.table-mobile .td-mobile {
  padding: .625em;
  text-align: center;
}
.table-mobile .th-mobile {
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
/////////////////////////////////////////////////////////////////////////////////////////////////
.modal-dialog {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}

.modal-content {
  height: auto;
  min-height: 100%;
  border-radius: 0;
}
.font_color
{
	color:#fff;
}
body.modal-open .datepicker {
		z-index: 100000 !important;
	}
	body.modal-open {
		overflow: hidden;
	}
	.quote.modal {
		position: fixed;
		top: 0px !important;
		left: 0px !important;
		right: 0px !important;
		bottom: 0px !important;
		width: 100% !important;
		height: 100% !important;
		margin: 0px !important;
		padding: 0px !important;
		display: none;
		border-radius: 0px !important;
		border:none;
		overflow: hidden;
	}

	.quote .modal-dialog {
		position: fixed;
		width: 100% !important;
		height: 100% !important;
		margin: 0px !important;
		padding: 0px !important;
		border-radius: 0px !important;
	}

	.quote .modal-content {
		position: absolute !important;
		margin: 0px !important;
		width: 100% !important;
		height: 100% !important;
		max-width: none;
		max-height: none;
		top: 0px !important;
		left: 0px !important;
		right: 0px !important;
		bottom: 0px !important;
	}

	.quote .modal-header {

	}

	.quote .modal-title {

	}

	.quote .modal-body {
		max-height: 85% !important;
		
	}

	.quote .modal-footer {
		position: absolute !important;
		margin: 0px !important;
		left: 0px !important;
		right: 0px !important;
		bottom: 0px !important;
	left: 0;
	}
	.quote .btn-disable {
		display: none;
	}
	.quote.modal table {
		font-size: 90%;
	}
	.quote.modal table tr th, .quote.modal table tr td {
		padding: 4px 6px;
		vertical-align: middle;
	}
	.quote .modal tr.info th {
		color: #fff;
		text-shadow: 0 -1px 0 rgba(0,0,0,0.25) !important;
		background-color: #006dcc !important;
		background-image: -moz-linear-gradient(top,#08c,#04c) !important;
		background-image: -webkit-gradient(linear,0 0,0 100%,from(#08c),to(#04c)) !important;
		background-image: -webkit-linear-gradient(top,#08c,#04c) !important;
		background-image: -o-linear-gradient(top,#08c,#04c) !important;
		background-image: linear-gradient(to bottom,#08c,#04c) !important;
		background-repeat: repeat-x !important;
		border-color: #04c #04c #002a80 !important;
		border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25) !important;
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc',endColorstr='#ff0044cc',GradientType=0) !important;
		filter: progid:DXImageTransform.Microsoft.gradient(enabled=false) !important;
	}
	.quote.modal table tr td input[type="text"], .quote.modal table tr th input[type="text"] {
		display: inline-block;
		height: 20px;
		padding: 4px 6px;
		margin-bottom: 0px;
		font-size: 90%;
		line-height: 20px;
		color: #555;
		vertical-align: middle;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
	}
	.quote.modal table tr td select {
		display: inline-block;
		height: 30px;
		padding: 4px 6px;
		margin-bottom: 0px;
		font-size: 90%;
		line-height: 20px;
		color: #555;
		vertical-align: middle;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
	}
	.quote.modal table tr th input[type="checkbox"] {
		display: inline-block;
		width: 14px;
		height: 14px;
		margin: 0px;
		margin-top: -4px;
		font-size: 90%;
		line-height: 20px;
		color: #555;
		vertical-align: middle;
		-webkit-border-radius: 0px;
		-moz-border-radius: 0px;
		border-radius: 0px;
	}
</style>
<!--<button class='btn btn-small btn-primary'  data-toggle='modal' data-target='#do_quotation' onclick='js_do_quotation();'><i class='icon-plus'></i> ทำใบเสนอราคา</button>-->
  <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table table-striped table-bordered table-mobile" id="quotation_car">
                        <thead class='thead-mobile'> 
                            <tr class="info tr-mobile" align="center" style=' background: #40b3ff  !important; background-image: linear-gradient(to bottom, #40b3ff, #006db0)  !important; padding: 10px 20px 10px 20px; font-family: Arial; background-image: -o-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -ms-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -moz-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -wedkit-linear-gradient(to bottom, #40b3ff, #006db0)  !important; '>
								
								<th class='th-mobile'><span class='font_color'>เลขที่เสนอราคา</span></th>
								<th class='th-mobile'><span class='font_color'>ชื่อลูกค้า</span></th>
								<th class='th-mobile'><span class='font_color'>รายละเอียด</span></th>
                                <th class='th-mobile'><span class='font_color'>ราคารถ</span></th>
								<th class='th-mobile'><span class='font_color'>ใบเสนอราคา</span></th>
								<th class='th-mobile'><span class='font_color'>ผู้บันทึก</span></th>

                            </tr>
                        </thead> 
						<tbody>
						<?php while($select_quotation_array=mysql_fetch_array($select_quotation_query)){ ?>
						<tr class='tr-mobile'>
						<td class='td-mobile' data-label="เลขที่เสนอราคา"><?php echo $select_quotation_array['q_auto']; ?></td>
								<td class='td-mobile' data-label="ชื่อลูกค้า"><?php echo $select_quotation_array['name']; ?></td>
								<td class='td-mobile' data-label="รายละเอียด"><?php echo $select_quotation_array['detail']; ?></td>
                                <td class='td-mobile' data-label="ราคารถ"><?php echo number_format($select_quotation_array['car_total'],2,'.',','); ?></td>
								<td class='td-mobile' data-label="ใบเสนอราคา"><a type='button' class='btn btn-small btn-success' href='print/print_quotation_car.php?q_auto=<?php echo $select_quotation_array['q_auto']; ?>' target='_BLANK'>ใบเสนอราคา</a></td>
								<td class='td-mobile' data-label="ผู้บันทึก"><?php echo $select_quotation_array['login']; ?></td>
								</tr>
						<?php } ?>
						</tbody>
                    </table>
					  <div class="quote modal fade" id="do_quotation" role="dialog">
    <div class="modal-dialog modal-lg">
    

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><font size='10'>&times;</font></button>
          <h4 class="modal-title"><font color='BLACK'>ทำใบเสนอราคารถยนต์</font></h4>
        </div>
 <div class="modal-body" id='html_do_quotation'>
        <p>Some text in the modal.</p>
      </div>
        <div class="modal-footer">
		<button type="button" class="btn btn-success" onclick='save_quotation();'>บันทึก</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
					<script>
					  $("#quotation_car").dataTable({"order": [[ 0, "desc" ]]});
					  function js_do_quotation()
					  {
						  $("#html_do_quotation").load("ajax/ajax_form_quotation.php");
					  }
					  function save_quotation()
					  {
						  $('#do_quotation').modal('hide');
						  if($("#name").val()=="")
						  {
							  alert("กรุณาป้อนชื่อคนที่เรียน");
							  $("#name").focus();
							  return false;
						  }
						  if($("#tel_mobile").val()=="")
						  {
							  alert("กรุณาป้อนเบอร์โทรศัพท์");
							  $("#tel_mobile").focus();
							  return false;
						  }
						  for(var n=0;n<document.getElementsByName("id_br_car[]").length;n++)
						  {
								if(document.getElementsByName("id_br_car[]")[n].value=="")
								{
									alert("กรุณาเลือกยี่ห้อรถยนต์");
									document.getElementsByName("id_br_car[]")[n].focus();
								return false;
								}
								if(document.getElementsByName("id_mo_car[]")[n].value=="")
								{
									alert("กรุณาเลือกรุ่นรถรถยนต์");
									document.getElementsByName("id_mo_car[]")[n].focus();
								return false;
								}
								if(document.getElementsByName("id_mo_car_sub[]")[n].value=="")
								{
									alert("กรุณาเลือกรุ่นรถย่อยรถยนต์");
									document.getElementsByName("id_mo_car_sub[]")[n].focus();
								return false;
								}
								if(document.getElementsByName("id_car_color[]")[n].value=="")
								{
									alert("กรุณาเลือกสีรถยนต์");
									document.getElementsByName("id_car_color[]")[n].focus();
								return false;
								}
								if(document.getElementsByName("car_regis_year[]")[n].value=="")
								{
									alert("กรุณาเลือกปีรถยนต์");
									document.getElementsByName("car_regis_year[]")[n].focus();
								return false;
								}
								if(document.getElementsByName("car_motor1[]")[n].value=="")
								{
									alert("กรุณาป้อนข้อมูลลงในช่องเลขตัวเคริ่อง");
									document.getElementsByName("car_motor1[]")[n].focus();
								return false;
								}
								if(document.getElementsByName("car_motor2[]")[n].value=="")
								{
									alert("กรุณาป้อนข้อมูลลงในช่องเลขตัวเครื่อง");
									document.getElementsByName("car_motor2[]")[n].focus();
								return false;
								}
								if(document.getElementsByName("car_body1[]")[n].value=="")
								{
									alert("กรุณาป้อนข้อมูลลงในช่องเลขตัวถัง");
									document.getElementsByName("car_body1[]")[n].focus();
								return false;
								}
								if(document.getElementsByName("car_body2[]")[n].value=="")
								{
									alert("กรุณาป้อนข้อมูลลงในช่องเลขตัวถัง");
									document.getElementsByName("car_body2[]")[n].focus();
								return false;
								}
								if(document.getElementsByName("car_price[]")[n].value=="")
								{
									alert("กรุณาป้อนข้อมูลลงในช่องราคารถ");
									document.getElementsByName("car_price[]")[n].focus();
								return false;
								}
								var quotation = {
									url:"ajax/ajax_save_quotation.php",
									type:"POST",
									dataType:'JSON',
									data:$("#data_quotation").serialize(),
									success:function(data)
									{
										if(data.status=='Y')
										{
											
											alert("บันทึกข้อมูลเรียบร้อยแล้วครับ");
											$(".modal").hide();
											$(".modal-backdrop").hide();		
											load_page('pages/select_quotation_car.php','ใบเสนอราคารถยนต์');
										}
										else
										{
											
											alert("บันทึกข้อมูลไม่สำเร็จ");
										}
									},
									error:function()
									{
										alert("บันทึกล้มเหลว!!!!");
									}
								};
						  }
					  }
					</script>