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
	$dealer_login=" WHERE tb_order_car.login = '".$_SESSION["strUser"]."'";
}
$select_quotation_sql="SELECT
tb_order_car.q_auto,
tb_customer.user,
tb_customer.sub,
tb_customer.title_sub,
COUNT(tb_order_detail_car.car_price) As total_count,
SUM(tb_order_detail_car.car_price) As total_sum
FROM tb_order_car 
LEFT JOIN tb_order_detail_car ON (tb_order_car.q_auto = tb_order_detail_car.q_auto)
LEFT JOIN tb_customer ON (tb_order_car.login = tb_customer.user)
".$dealer_login." GROUP BY tb_order_detail_car.q_auto ORDER BY tb_order_car.date_save DESC";
$select_quotation_query=mysql_query($select_quotation_sql,$cndb1);
//echo $select_quotation_sql;
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
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class='span12' style='width:100%;'>
<button class='btn btn-primary' onclick='show_form_report();'>รายงานยอดสั่งซื้อ</button>
</div>
<div class='span12' id='show_report' style='display:none;'>
<form action='report/report_order_car_xls.php' method='POST' target='_BLANK' onsubmit='return down_report();'>
<div class='span12'>
<div style='display:inline-block; width:600px;'>
<div style='display:inline-block; width:120px;'>สาขาดิลเลอร์</div>
<select name="login" id="login" class='span5'>
<?php if($_SESSION['strUser']=='admin' || $_SESSION['claim']=='ADMIN'){ 
$u_sql='WHERE nameuser = "Mitsubishi"';
?>
        <option value="ALL" selected="selected">ALL</option>
<?php } else {$u_sql="WHERE tb_customer.user = '".$_SESSION['strUser']."'"; }
				
			  	$query_D ="SELECT * FROM tb_customer   ".$u_sql." ORDER BY tb_customer.user ASC"; // id = '1' 
				$objQueryD = mysql_query($query_D,$cndb1) or die ("Error Query [".$query_D."]");
				while($objResultD = mysql_fetch_array($objQueryD))
				{
					echo '<option value="'.$objResultD['user'].'">'.'['.$objResultD['user'].'] '.$objResultD['sub'].'</option>';
				}
            ?>
      </select>
	  </div>
</div>
<div class='span12'>
<div style='display:inline-block; width:400px;'>
<div style='display:inline-block; width:120px;'>วันสั่งซื้อ</div>
<input type='text' class='span3' name='start_date' id='start_date'  readonly placeholder='คลิกเพื่อเลือกวัน'>
</div>
<div style='display:inline-block; width:400px;'>
<div style='display:inline-block; width:120px;'>สิ้นสุดวันสั่งซื้อ</div>
<input type='text' class='span3' name='end_date' id='end_date' readonly placeholder='คลิกเพื่อเลือกวัน'>
</div>
<div class='span12'>
<input type='submit' class='btn btn-success' value='ดาวโหลด Excel'>
</div>
</form>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class='span12'  style='width:97%;'>

  <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table table-striped table-bordered table-mobile" id="order_car">
                        <thead class='thead-mobile'> 
                            <tr class="info tr-mobile" align="center" style=' background: #40b3ff  !important; background-image: linear-gradient(to bottom, #40b3ff, #006db0)  !important; padding: 10px 20px 10px 20px; font-family: Arial; background-image: -o-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -ms-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -moz-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -wedkit-linear-gradient(to bottom, #40b3ff, #006db0)  !important; '>
								
								<th class='th-mobile'><span class='font_color'>เลขที่ใบสั่ง</span></th>
								<th class='th-mobile'><span class='font_color'>ชื่อบริษัทสั่งซื้อ</span></th>
								
                                <th class='th-mobile'><span class='font_color'>จำนวนรายการ</span></th>
								<th class='th-mobile'><span class='font_color'>ราคารวมรถทั้งหมด</span></th>
								<th class='th-mobile'><span class='font_color'>ดูใบสั่งซื้อ</span></th>
								

                            </tr>
                        </thead> 
						<tbody>
						<?php while($select_quotation_array=mysql_fetch_array($select_quotation_query)){ ?>
						<tr class='tr-mobile'>
						<td class='td-mobile' data-label="เลขที่ใบสั่ง"><?php echo $select_quotation_array['q_auto']; ?></td>
								<td class='td-mobile' data-label="ชื่อบริษัทสั่งซื้อ"><?php echo '['.$select_quotation_array['user'].'] '.$select_quotation_array['title_sub'].' '.$select_quotation_array['sub']; ?></td>
								<td class='td-mobile' data-label="จำนวนรายการ"><?php echo $select_quotation_array['total_count']; ?></td>
								<?php
								$total_car=0;
								$total_sql="SELECT car_price,unit_car FROM tb_order_detail_car WHERE q_auto = '".$select_quotation_array['q_auto']."'";
								$total_query=mysql_query($total_sql,$cndb1);
								while($total_array=mysql_fetch_array($total_query))
								{
									$total_car+=$total_array['car_price'] * $total_array['unit_car'];
								}
								?>
                                <td class='td-mobile' data-label="ราคารวมรถทั้งหมด"><?php echo number_format($total_car,2,'.',','); ?></td>
								<td class='td-mobile' data-label="ดูใบสั่งซื้อ">
								<a type='button' class='btn btn-small btn-success' href='print/print_order_car.php?q_auto=<?php echo $select_quotation_array['q_auto']; ?>' target='_BLANK'>ใบสั่งซื้อ</a>
								<a type='button' class='btn btn-small btn-primary' href='print/print_order_car_xls.php?q_auto=<?php echo $select_quotation_array['q_auto']; ?>' target='_BLANK'>รายการสั่งซื้อ</a>
								</td>
								
								</tr>
						<?php } ?>
						</tbody>
                    </table>
					</div>
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
$("#order_car").dataTable({"order": [[ 0, "desc" ]]});
function show_form_report()
{
	$("#show_report").slideToggle();
}
function down_report()
{
	if($("#login").val()=="")
	{
		alert("กรุณาเลือกสาขาดิลเลอร์ด้วยครับ");
		$("#login").focus();
		return false;
	}
	if($("#start_date").val()=="")
	{
		alert("กรุณาเลือกวันสั่งซื้อด้วยครับ");
		$("#start_date").focus();
		return false;
	}
	if($("#end_date").val()=="")
	{
		alert("กรุณาเลือกสิ้นสุดวันสั่งซื้อด้วยครับ");
		$("#end_date").focus();
		return false;
	}
}
$('#start_date').datepicker(
	{
		format: "yyyy-mm-dd",
		language: "th",
		autoclose: true
	});
	$('#end_date').datepicker(
	{
		format: "yyyy-mm-dd",
		language: "th",
		autoclose: true
	});
</script>