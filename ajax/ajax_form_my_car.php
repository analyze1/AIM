<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$dealer_name=ทุกดิลเลอร์;
}
else
{
	$dealer_name="ดิลเลอร์ ".$_SESSION["strUser"];
}
mysql_select_db($db1,$cndb1);
?>
<style type='text/css'>
.inline_add_one{
    display: inline-block;
	width: 330px;
}
.inline_add_two{
    display: inline-block;
	width: 400px;
}
.inline_add_title{
    display: inline-block;
	width: 110px;
}
.border_row{
	border-style:none none solid none;
	border-color:#7A7A7A;
	border-width:2px;
	
}
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
<div class='span12' style='width:100%;'>
		<div class="widget-box">
            <div class="widget-header widget-header-flat"> <h4>ข้อมูลผู้จองรถยนต์/ลูกค้าคาดหวัง</h4></div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row-fluid">
                            <div class="span12">
    
<table class="table">
<tr>
<td>

<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<form id='save_my'>
<div class='span12' style='width:100%;'>
<div style='display: inline-block; width:100%; padding-bottom:5px;' class='border_row'>
<input type='hidden' name='id_my' id='id_my' class='span6'>
<div class='span12'>ค้นหาลูกค้า&nbsp;&nbsp;

		  <span><select name='type_customer' id='type_customer' class='span2' onchange='js_mask10();'>
		  <!--<option value=''>--เลือกข้อมูลค้นหา--</option>-->
		  <option value='tb_my_car.name'>ชื่อจริง</option>
		  <option value='tb_my_car.last'>นามสกุล</option>
		  <option value='tb_my_car.id_card'>บัครประชาชน</option>
		  <option value='tb_my_car.tel_mobile1'>เบอร์โทรศัพท์1</option>
		  <option value='tb_my_car.tel_mobile2'>เบอร์โทรศัพท์2</option>
		  <option value='tb_my_car.tel_mobile3'>เบอร์โทรศัพท์3</option>
		  <option value='tb_my_car.tel_home'>เบอร์บ้าน</option>
		  <option value='tb_my_car.tel_office'>เบอร์ที่ทำงาน</option>
		  <option value='tb_my_car.id_line'>ID Line</option>
		  <option value='tb_my_car.facebook'>facebook</option>
		  </select></span>&nbsp;&nbsp;
		 <span id='input_mask'><input name='key_customer' id='key_customer' type='text' class='span2'></span>
		  <span><a type='button' name='data_customer' id='data_customer' class='btn btn-small btn-primary' onclick='search_my_car();'  data-toggle='modal' data-target='#search_customer10'><i class='icon-search icon-white'></i> ค้นหา</a></span>
<!--<a type='button' class='btn btn-primary' data-toggle='modal' data-target='#search_customer10'><i class='icon-search icon-white'></i> ค้นหาข้อมูลลูกค้า</a></div>-->
<span id='data_search_customer' ><!--<font color='red' size='2'><b>&nbsp;&nbsp;เลือกข้อมูลลูกค้า (กรณีมีข้อมูลลูกค้าคาดหวัง)</b></font>--></span>
</div>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div  class='border_row' style='width:100%; padding-bottom:5px;padding-top:5px;'>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div style='width:100%'>
<div class='inline_add_title'>สาขาผู้สั่งซื้อ</div>

<select name="login" id="login" class='span3'>
<?php if($_SESSION['strUser']=='admin' || $_SESSION['claim']=='ADMIN'){ 
$u_sql='WHERE nameuser = "mitsubishi"';
?>
        <option value="" selected="selected">กรุณาเลือกชื่อผู้สั่งซื้อ</option>
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
<div class='inline_add_one'>
<input type='hidden' name='user' id='user' class='span6' value='<?php echo $_SESSION['strUser']; ?>'>
<div class='inline_add_title'>คำนำหน้า</div>
<select name='title' id='title' class='span6'>
<option value=''>--เลือกคำนำหน้า--</option>
<?php
$title_html="<option value=''>--เลือกคำนำหน้า--</option>";
$select_tb_title_sql="SELECT * FROM tb_titlename";
$select_tb_title_query=mysql_query($select_tb_title_sql,$cndb1);
while($select_tb_title_array=mysql_fetch_array($select_tb_title_query)){ ?>
<option value='<?php echo str_replace(' ','',$select_tb_title_array['prename']); ?>'><?php echo str_replace(' ','',$select_tb_title_array['prename']); ?></option>
<?php 
$title_html.="<option value='".str_replace(' ','',$select_tb_title_array['prename'])."'>".str_replace(' ','',$select_tb_title_array['prename'])."</option>";
} ?>
</select>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>ชื่อจริง</div>
<input type='text' class='span6' name='name' id='name'>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>นามสกุล</div>
<input type='text' class='span6' name='last' id='last'>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>ที่อยู่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บ้านเลขที่</div>
<input type='text' class='span4' name='add' id='add'>&nbsp;หมู่&nbsp;<input type='text' class='span2' name='group' id='group'>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>อาคาร/หมู่บ้าน</div>
<input type='text' class='span6' name='home' id='home'>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>ซอย</div>
<input type='text' class='span6' name='lane' id='lane'>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>ถนน</div>
<input type='text' class='span6' name='road' id='road'>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>จังหวัด</div>
<select name='id_province' id='id_province' class='span6' onchange='js_amphur();'>
<option value=''>--เลือกจังหวัด--</option>
<?php
$tb_province_sql="SELECT id,name FROM tb_province";
$tb_province_query=mysql_query($tb_province_sql,$cndb1);
$province_html="<option value=''>--เลือกจังหวัด--</option>";
while($tb_province_array=mysql_fetch_array($tb_province_query))
{ ?>
<option value='<?php echo $tb_province_array['id']; ?>'><?php echo $tb_province_array['name']; ?></option>
<?php 
$province_html.="<option value='".$tb_province_array['id']."'>".$tb_province_array['name']."</option>";
} ?>
</select>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>อำเภอ</div>
<select name='id_amphur' id='id_amphur' class='span6' onchange='js_tumbon();'>
<option value=''>--เลือกอำเภอ--</option>
</select>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>ตำบล</div>
<select name='id_tumbon' id='id_tumbon' class='span6' onchange='js_postal();'>
<option value=''>--เลือกตำบล--</option>
</select>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>รหัสไปรษณีย์</div>
<input type='text' class='span6' name='postal' id='postal'>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>อาชีพ</div>
<input type='text' class='span6' name='job' id='job' >
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>เลขบัตรประชาชน</div>
<input type='text' class='span6' name='id_card' id='id_card' onchange='check_idcard();'>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>เบอร์โทรมือถือ1</div>
<input type='text' class='span6' name='tel_mobile1' id='tel_mobile1' >
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>เบอร์โทรมือถือ2</div>
<input type='text' class='span6' name='tel_mobile2' id='tel_mobile2' >
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>เบอร์โทรมือถือ3</div>
<input type='text' class='span6' name='tel_mobile3' id='tel_mobile3' >
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>เบอร์ที่ทำงาน</div>
<input type='text' class='span6' name='tel_office' id='tel_office' >
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>เบอร์บ้าน</div>
<input type='text' class='span6' name='tel_home' id='tel_home' >
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>ID_line</div>
<input type='text' class='span6' name='id_line' id='id_line' >
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>Facebook</div>
<input type='text' class='span6' name='facebook' id='facebook'>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>แหล่งที่มา</div>
<select class='span6' name='source' id='source' >
<option value=''>--เลือกแหล่งที่มา--</option>
<?php
$select_source_sql="SELECT * FROM tb_source";
$select_source_query=mysql_query($select_source_sql,$cndb1);
$source_html="<option value=''>--เลือกแหล่งที่มา--</option>";
while($select_source_array=mysql_fetch_array($select_source_query))
{ ?>
<option value='<?php echo $select_source_array['name']; ?>'><?php echo $select_source_array['name']; ?></option>
<?php 
$source_html.="<option value='".$select_source_array['name']."'>".$select_source_array['name']."</option>";
} ?>
</select>
</div>
<div class='inline_add_one'>
<div class='inline_add_title'>ผู้ที่ขาย</div>
<input type='text' class='span6' name='seller' id='seller'>
</div>
<div style='display: inline-block; width:100%'>
<input type='hidden' name='id_stock' id='id_stock' class='span6'>
<div class='span2'><a type='button' class='btn btn-success' onclick='show_down();'><i class='icon-search icon-white'></i> ค้นหารถยนต์</a></div>
<div class='span9' id='data_search_html' ><font color='red' size='2'><b>&nbsp;&nbsp;กรุณาเลือกข้อมูลสต๊อกรถยนต์ (กรณีไม่เลือกรถ คือลูกค้าคาดหวัง)</b></font></div>
<div class='span12 span-margin' style='margin-left:0px; display:none;' id='slide_toggle'>

<div class="row-fluid">
    <!-- .inner -->
    <div class="span12 inner">
        <!--Begin Datatables-->
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">                                        

                    <div  class="body">
					<div class='span12'>
					<b class='tap_font'>รายการรถยนต์ <?php echo $dealer_name; ?></b>
					</div>
                       <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="table table-striped table-bordered" id="stock_car_data">
                        <thead> 
                            <tr class="info" align="center" style=' background: #40b3ff  !important; background-image: linear-gradient(to bottom, #40b3ff, #006db0)  !important; padding: 10px 20px 10px 20px; font-family: Arial; background-image: -o-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -ms-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -moz-linear-gradient(to bottom, #40b3ff, #006db0)  !important;  background-image: -wedkit-linear-gradient(to bottom, #40b3ff, #006db0)  !important; '>
								<th><span class='font_color'>เลือก</span></th>
								<th><span class='font_color'>ยี่ห้อรถ</span></th>
                                <th><span class='font_color'>รุ่นรถ</span></th> 
								<th><span class='font_color'>รุ่นรถย่อย</span></th> 
                                <th><span class='font_color'>เลขตัวเครื่อง</span></th>
								<th><span class='font_color'>เลขตัวถัง</span></th>
                                <th><span class='font_color'>ราคารถ</span></th>
							<!--	<th><span class='font_color'>คำนวนงวด</span></th>-->

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
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class='span12' style='padding-top:10px;'>
<a type='button' class='btn btn-info' onclick='save_my_car();'><i class='icon-save icon-white'></i> บันทึกข้อมูลจองรถ</a>
<a type='button' class='btn btn-warning' onclick='reset_my_car();'><i class='icon-refresh icon-white'></i> เคลียร์ข้อมูล</a>
</div>
</div>
</form>
</td>
</tr> 
</table>
</div></div></div></div></div></div>
<div class='span12' style='width:100%'>
  <div class="modal fade width_attack" id="search_car" role="dialog" style='display:none;'>
    <div class="modal-dialog modal-lg">
    

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><font color='BLACK'>คำนวนงวดรถยนต์</font></h4>
        </div>
        <div class="modal-body">
		<form id='calculate_car_form'>
		<div class='span12'>
		<div class='span12' style='margin-left:0px;'>
		<div class='span4' style='margin-left:0px;'>ราคารถ/บาท<br><input type='text' class='span3' id='car_price' style='text-align: right;'  onkeyup='down_price_cal();' readonly></div>
		<div class='span4' style='margin-left:0px;'>ดอกเบี้ยเพิ่มต่อปี<br><input type='text' class='span3'id='interest_price' value='0.00' style='text-align: right;' readonly></div>
		</div>
		<div class='span12' style='margin-left:0px;'>
		<div class='span4' style='margin-left:0px;'>จำนวนเงินจอง<br><input type='text' class='span3' style='text-align: right;' id='res_price'  value='0.00'></div>
		
		<div class='span4' style='margin-left:0px;'>ดอกเบี้ยเพิ่มรวม<br><input type='text' class='span3'id='interest_total' value='0.00' style='text-align: right;' readonly></div>
		</div>
		<div class='span12' style='margin-left:0px;'>
		<div class='span4' style='margin-left:0px;'>จำนวนเงินดาวน์<br><input type='text' class='span2' id='down_price' onkeyup='down_per_cal();' value='0.00' style='text-align: right;'><input type='number' class='span1' id='down_per' onkeyup='down_price_cal();' onclick='down_price_cal();' value='' style='text-align: right;'><font>%</font></div>
		
		<div class='span4' style='margin-left:0px;'>ยอดจัด<br><input type='text' class='span3'id='top_price' value='0.00' style='text-align: right;' readonly></div>
		</div>
		<div class='span12' style='margin-left:0px;'>
		<div class='span4' style='margin-left:0px;'>จำนวนงวด<br>
		<select class='span3' id='unit_year' style='text-align: right;'>
		<?php for($n=1;$n<=7;$n++) { ?>
		<option value='<?php echo $n; ?>'><?php echo ($n*12)." งวด (".$n." ปี)"; ?></option>
		<?php } ?>
		</select>
		</div>
		<div class='span4' style='margin-left:0px;'>ยอดจัดรวมดอกเบี้ย<br><input type='text' class='span3'id='total_price' value='0.00' style='text-align: right;' readonly></div>
		
		</div>
		<div class='span12' style='margin-left:0px;'>
		<div class='span4' style='margin-left:0px;'>ดอกเบี้ย%ต่อปี<br><input type='number' class='span3'id='interest_per' value='' style='text-align: right;'></div>
		
		<div class='span4' style='margin-left:0px;'>ค่างวดต่อเดือน<br><input type='text' class='span3' id='unit_price' style='text-align: right;' value='0.00' readonly></div>
		</div>
		</div>
		
		</div>
   
        <div class="modal-footer">
		</form>
		<button type="button" class="btn btn-success" onclick='calculate_car();'>คำนวน</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
 <!------------------------------------------------------------------------------------------------------------------------>
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<!--
<div class="modal fade width_attack" id="search_data10" role="dialog">
    <div class="modal-dialog modal-lg">
    

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><font color='BLACK'>ค้นหาข้อมูลรถยนต์</font></h4>
        </div>
        <div class="modal-body">
          <div class='span12'>
		  เลือกข้อมูลค้นหา&nbsp;&nbsp;
		  <span><select name='type_data' id='type_data' class='span2'>
		  <option value=''>--เลือกข้อมูลค้นหา--</option>
		  <option value='tb_stock_car.car_motor'>เลขตัวเครื่อง</option>
		  <option value='tb_stock_car.car_body'>เลขตัวถัง</option>
		  <option value='tb_br_car.name'>ยี่ห้อรถ</option>
		  <option value='tb_mo_car.name'>รุ่นรถ</option>
		  <option value='tb_mo_car_sub.name'>รุ่นรถย่อย (modal)</option>
		  </select></span>&nbsp;&nbsp;
		 <span><input name='key_data' id='key_data' type='text' class='span2'></span>
		  <span><a type='button' name='data_car' id='data_car' class='btn btn-small btn-primary' onclick='search_stock_car();'><i class='icon-search icon-white'></i> ค้นหา</a></span>
		  </div>
		  <div class='span12' id='search_html'>
		  </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  -->
   <!------------------------------------------------------------------------------------------------------------------------>


  <div class="modal fade width_attack" id="search_customer10" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><font color='BLACK'>ค้นหาข้อมูลลูกค้า</font></h4>
        </div>
        <div class="modal-body">
          <div class='span12'>

		  </div>
		  <div class='span12' id='search_customer_html'>
		  </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<div class='span12' style='width:100%' id='follow_customer'>

</div>


<script type='text/javascript'>
function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}
function show_down()
{
	$("#slide_toggle").slideToggle();
}
function save_my_car()
{
	if($("#user").val()=='')
	{
		alert("กรูณาเข้าสู่ระบบใหม่อีกครั้งครับ เนื่องจาก SESSION หมดอายุครับ");
		return false;
	}
	if($("#login").val()=='')
	{
		alert("กรุณาเลือกผู้ทำการจองด้วยครับ");
		$("#login").focus();
		return false;
	}
	if($("#title").val()=='' && $("#name").val()=='' && $("#last").val()=='' && $("#add").val()=='' && $("#group").val()=='' && $("#home").val()=='' && $("#lane").val()=='' && $("#road").val()=='' && $("#id_province").val()=='' && $("#id_amphur").val()=='' && $("#id_tumbon").val()=='' && $("#postal").val()=='' && $("#job").val()=='' && $("#id_card").val()=='' && $("#tel_mobile1").val()=='' && $("#tel_mobile2").val()=='' && $("#tel_mobile3").val()=='' && $("#tel_office").val()=='' && $("#tel_home").val()=='' && $("#source").val()=='' && $("#seller").val()=='')
	{
		alert("กรุณาเก็บข้อมูลอย่างใดอย่างหนึ่งครับ");
		return false;
	}
	/*if($("#title").val()=='')
	{
		alert("กรุณาเลือกคำนำหน้าด้วยครับ");
		$("#title").focus();
		return false;
	}
	if($("#name").val()=='')
	{
		alert("กรุณาป้อนชื่อจริงด้วยครับ");
		$("#name").focus();
		return false;
	}
	if($("#last").val()=='')
	{
		alert("กรุณาป้อนนามสกุลด้วยครับ");
		$("#last").focus();
		return false;
	}
	if($("#add").val()=='')
	{
		alert("กรุณาป้อนบ้านเลขที่ด้วยครับ");
		$("#add").focus();
		return false;
	}
	if($("#group").val()=='')
	{
		alert("กรุณาป้อนหมู่ด้วยครับ");
		$("#group").focus();
		return false;
	}
	if($("#home").val()=='')
	{
		alert("กรุณาป้อนชื่อบ้านด้วยครับ");
		$("#home").focus();
		return false;
	}
	if($("#lane").val()=='')
	{
		alert("กรุณาป้อนตรอก/ซอยด้วยครับ");
		$("#lane").focus();
		return false;
	}
	if($("#road").val()=='')
	{
		alert("กรุณาป้อนชื่อถนนด้วยครับ");
		$("#road").focus();
		return false;
	}
	if($("#id_province").val()=='')
	{
		alert("กรุณาเลือกอจังหวัดด้วยครับ");
		$("#id_province").focus();
		return false;
	}
	if($("#id_amphur").val()=='')
	{
		alert("กรุณาเลือกอำเภอด้วยครับ");
		$("#id_amphur").focus();
		return false;
	}
	if($("#id_tumbon").val()=='')
	{
		alert("กรุณาเลือกตำบลด้วยครับ");
		$("#id_tumbon").focus();
		return false;
	}
	if($("#postal").val()=='')
	{
		alert("กรุณาป้อนรหัสไปรษณีย์ด้วยครับ");
		$("#postal").focus();
		return false;
	}
	if($("#job").val()=='')
	{
		alert("กรุณาป้อนอาชีพด้วยครับ");
		$("#job").focus();
		return false;
	}
	if($("#id_card").val()=='')
	{
		alert("กรุณาป้อนเลขบัตรประชาชน 13 หลัก");
		$("#id_card").focus();
		return false;
	}
	if($("#tel_mobile1").val()=='' && $("#tel_mobile2").val()=='' && $("#tel_mobile3").val()=='' && $("#tel_office").val()=='' && $("#tel_home").val()=='')
	{
		alert("กรุณาป้อนเบอร์โทรศัพท์ด้วยครับ");
		$("#tel_mobile1").focus();
		return false;
	}
	if($("#source").val()=='')
	{
		alert("กรุณาเลือกแหล่งที่มาด้วยครับ");
		$("#source").focus();
		return false;
	}*/
	/*if($("#id_my").val()!='')
	{
		if($("#id_stock").val()=='')
	{
		alert("กรุณาเลือกข้อมูลรถยนต์ด้วยครับ");
		return false;
	}
	}*/
	var save_my = 
	{
		url:"ajax/ajax_save_my_car.php",
		dataType:"JSON",
		type:"POST",
		data:$("#save_my").serialize(),
		success:function(data)
		{
			if(data.status=='Y')
			{
				alert("บันทึกข้อมูลเรียบร้อยแล้วครับ");
				if($("#id_my").val()!="")
				{
				load_page('pages/form_customer_suzuki.php','ข้อมูลลูกค้าจองรถยนต์');
				}
				else
				{
				load_page('pages/form_my_suzuki.php','สต๊อกรถยนต์/จองรถยนต์');
				}
			}
			else
			{
				alert("บันทึกข้อมูลไม่สำเร็จ");
			}
		},
		error:function()
		{
			alert("บันทึกข้อมูลล้มเหลว");
		}
	};
	$.ajax(save_my);
}
function js_amphur()
{
	$("#id_tumbon").html('<option value="">--เลือกตำบล--</option>');
	$("#postal").val('');
	$("#postal").attr('readonly',false);
	$.post("ajax/ajax_amphur_my_car.php",{id:$("#id_province").val()},function(data){$("#id_amphur").html(data);});
}
function js_tumbon()
{
	$("#postal").val('');
	$("#postal").attr('readonly',false);
	$.post("ajax/ajax_tumbon_my_car.php",{id:$("#id_amphur").val()},function(data){$("#id_tumbon").html(data);});
}
function js_postal()
{
	$.post("ajax/ajax_postal_my_car.php",{id:$("#id_tumbon").val()},function(data){$("#postal").val(data);if(data==''){$("#postal").attr('readonly',false);}else{$("#postal").attr('readonly',true);}});
}
function search_stock_car()
{
	if($("#type_data").val()=='')
	{
		alert("กรุณาเลือกประเภทข้อมูลค้นหาครับ");
		$("#type_data").focus();
		return false;
	}
	if($("#key_data").val()=='')
	{
		alert("กรุณาคีย์ข้อมูลค้นหาครับ");
		$("#key_data").focus();
		return false;
	}
	$.post("ajax/ajax_search_data_car.php",{type_data:$("#type_data").val(),key_data:$("#key_data").val()},function(data){$("#search_html").html(data);});
}
function select_car_modal(id,data,num)
{
	//for(var i = 0;i<document.getElementsByName("number_car").length;i++)
	//{
	//document.getElementsByName("number_car")[i].checked=false;
	//}
	//document.getElementById("number_car"+num).checked=true;
	$("#slide_toggle").slideUp();
	if(id !="")
	{
	$("#id_stock").val(id);
	$("#data_search_html").html(data);
	}
	else
	{
		$("#id_stock").val("");
		$("#data_search_html").html("<font color='red' size='2'><b>&nbsp;&nbsp;กรุณาเลือกข้อมูลสต๊อกรถยนต์</b></font>");
	}
}
function search_my_car()
{
	if($("#type_customer").val()=='')
	{
	
		//alert("กรุณาเลือกประเภทข้อมูลค้นหาครับ");
		$("#search_customer_html").html("<center><font color='red' size='5'>ไม่พบข้อมูลลูกค้า!</font></center>");
		$("#type_data").focus();
		return false;
	}
	if($("#key_customer").val()=='')
	{
			
		//alert("กรุณาคีย์ข้อมูลค้นหาครับ");
		$("#search_customer_html").html("<center><font color='red' size='5'>ไม่พบข้อมูลลูกค้า!</font></center>");
		$("#search_customer_html").html(data);
		$("#key_data").focus();
		return false;
	}
	$.post("ajax/ajax_search_data_customer.php",
	{type_customer:$("#type_customer").val(),
	key_customer:$("#key_customer").val()},
	function(data){
		
		$("#search_customer_html").html(data);
		});
}
function select_customer_modal(id,data,data_all)
{
	var data_customer = data_all.split("|");
	if(id !="")
	{
	$("#id_my").val(id);
	//$("#data_search_customer").html("<font  size='3'>"+data+"</font>");
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	if(data_customer[0]=='')
	{
		$("#title").html("<?php echo $title_html; ?>");
	}
	else
	{
	$("#title").html("<option value='"+data_customer[0]+"'>"+data_customer[0]+"</option><?php echo $title_html; ?>");
	}
	//$("#name").attr('readonly',true);
	$("#name").val(data_customer[1]);
	//$("#last").attr('readonly',true);
	$("#last").val(data_customer[2]);
	//$("#add").attr('readonly',true);
	$("#add").val(data_customer[3]);
	//$("#group").attr('readonly',true);
	$("#group").val(data_customer[4]);
	//$("#home").attr('readonly',true);
	$("#home").val(data_customer[5]);
	//$("#lane").attr('readonly',true);
	$("#lane").val(data_customer[6]);
	//$("#road").attr('readonly',true);
	$("#road").val(data_customer[7]);
	if(data_customer[8]!="")
	{
	$("#id_province").html("<option value='"+data_customer[8]+"'>"+data_customer[9]+"</option><?php echo $province_html; ?>");
	}
	else
	{
	$("#id_province").html("<?php echo $province_html; ?>");
	}
	if(data_customer[10]!="")
	{
	$("#id_amphur").html("<option value='"+data_customer[10]+"'>"+data_customer[11]+"</option>");
	}
	else
	{
		js_amphur();
	}
	if(data_customer[12]!="")
	{
	$("#id_tumbon").html("<option value='"+data_customer[12]+"'>"+data_customer[13]+"</option>");
	}
	else
	{
		js_tumbon();
	}
	if(data_customer[14]=='')
	{
	$("#postal").attr('readonly',false);
	$("#postal").val(data_customer[14]);
	}
	else
	{
	$("#postal").attr('readonly',true);
	$("#postal").val(data_customer[14]);
	}
	//$("#job").attr('readonly',true);
	$("#job").val(data_customer[15]);
	//$("#id_card").attr('readonly',true);
	$("#id_card").val(data_customer[16]);
	//$("#tel_mobile1").attr('readonly',true);
	$("#tel_mobile1").val(data_customer[17]);
	//$("#tel_mobile2").attr('readonly',true);
	$("#tel_mobile2").val(data_customer[18]);
	//$("#tel_mobile3").attr('readonly',true);
	$("#tel_mobile3").val(data_customer[19]);
	//$("#tel_office").attr('readonly',true);
	$("#tel_office").val(data_customer[20]);
	//$("#tel_home").attr('readonly',true);
	$("#tel_home").val(data_customer[21]);
	//$("#id_line").attr('readonly',true);
	$("#id_line").val(data_customer[22]);
	//$("#facebook").attr('readonly',true);
	$("#facebook").val(data_customer[23]);
	$("#source").html("<option value='"+data_customer[24]+"'>"+data_customer[24]+"</option>");
	$("#seller").val(data_customer[25]);
	}
	else
	{
		$("#id_my").val("");
		document.getElementById("save_my").reset();
		//$("#data_search_customer").html("<font color='red' size='2'><b>&nbsp;&nbsp;เลือกข้อมูลลูกค้า (กรณีมีข้อมูลลูกค้าคาดหวัง)</b></font>");
		$("#follow_customer").html("");
	}
	$.post("ajax/ajax_form_detail_customer_my_car.php",{id_my:$("#id_my").val()},function(data){$("#follow_customer").html(data);});
}
function reset_my_car()
{
	$("#title").html("<?php echo $title_html; ?>");
	$("#name").attr('readonly',false);
	$("#last").attr('readonly',false);
	$("#add").attr('readonly',false);
	$("#group").attr('readonly',false);
	$("#home").attr('readonly',false);
	$("#lane").attr('readonly',false);
	$("#road").attr('readonly',false);
	$("#postal").attr('readonly',false);
	$("#job").attr('readonly',false);
	$("#id_card").attr('readonly',false);
	$("#tel_mobile1").attr('readonly',false);
	$("#tel_mobile2").attr('readonly',false);
	$("#tel_mobile3").attr('readonly',false);
	$("#tel_office").attr('readonly',false);
	$("#tel_home").attr('readonly',false);
	$("#id_line").attr('readonly',false);
	$("#facebook").attr('readonly',false);
	$("#id_province").html("<?php echo $province_html; ?>");
	$("#id_amphur").html("<option value=''>--เลือกอำเภอ--</option>");
	$("#id_tumbon").html("<option value=''>--เลือกตำบล--</option>");
	$("#source").html("<?php echo $source_html; ?>");
	$("#id_stock").val("");
	$("#id_my").val("");
	document.getElementById("save_my").reset();
	$("#data_search_html").html("<font color='red' size='2'><b>&nbsp;&nbsp;กรุณาเลือกข้อมูลสต๊อกรถยนต์ (กรณีไม่เลือกรถ คือลูกค้าคาดหวัง)</b></font>");
	//$("#data_search_customer").html("<font color='red' size='2'><b>&nbsp;&nbsp;เลือกข้อมูลลูกค้า (กรณีมีข้อมูลลูกค้าคาดหวัง)</b></font>");
	$("#follow_customer").html("");
}
function checkID(id) {
	if(id.length != 13) return false;
		for(i=0, sum=0; i < 12; i++)
sum += parseFloat(id.charAt(i))*(13-i);
	if((11-sum%11)%10!=parseFloat(id.charAt(12))) 
return false;
return true;
}
function check_idcard() {
if(!checkID(document.getElementById("id_card").value))
{
alert ("เลขบัตรประชาชนนี้ไม่ถูกต้อง");
document.getElementById("id_card").value = "";
}

}
function js_mask10()
{
	if($("#type_customer").val()=="tb_my_car.tel_mobile1" || $("#type_customer").val()=="tb_my_car.tel_mobile2" || $("#type_customer").val()=="tb_my_car.tel_mobile3")
	{
		$('#input_mask').html("<input name='key_customer' id='key_customer' type='text' class='span2'>");
		$("#key_customer").mask("999-9999999");
	}
	else if($("#type_customer").val()=="tb_my_car.tel_home")
	{
		$('#input_mask').html("<input name='key_customer' id='key_customer' type='text' class='span2'>");
		$("#key_customer").mask("99-9999999");
	}
	else if($("#type_customer").val()=="tb_my_car.id_card")
	{
		$('#input_mask').html("<input name='key_customer' id='key_customer' type='text' class='span2'>");
		$("#key_customer").mask("9999999999999");
	}
	else
	{
		$('#input_mask').html("<input name='key_customer' id='key_customer' type='text' class='span2'>");
	}
}
$("#stock_car_data").dataTable({
		'processing':true,
		"serverSide": false,
		"deferRender": true,
		"lengthMenu": [[3,10, 25, 50, -1], [3,10, 25, 50, "All"]],
		"ajax":{
			'url':'ajax/ajax_stock_car_data.php'
		},
		"columnDefs": [
		{
			"targets": 0,
			'bSortable' : true,
			"data": 'check',
			"defaultContent": ""
		},
		{
			"targets": 1,
			'bSortable' : true,
			"data": 'id_br_car',
			"defaultContent": "",
		},
		{
			"targets": 2,
			'bSortable' : true,
			"data": 'id_mo_car',
			"defaultContent": "",
		},
		{
			"targets": 3,
			'bSortable' : true,
			"data": 'id_mo_car_sub',
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
		}/*,
		{
			"targets": 7,
			'bSortable' : false,
			"data": 'button',
			"defaultContent": ""
		}*/
		], "order": [[ 0, "desc" ]]
	});
	function calculate_car()
	{
		if($("#down_price").val()=='')
		{
			alert("กรุณาป้อนข้อมูลจำนวนเงินดาวน์ (บาท) ด้วยครับ");
			$("#down_price").focus();
			return false;
		}
		if($("#down_per").val()=='')
		{
			alert("กรุณาป้อนข้อมูลจำนวนเงินดาวน์ (%) ด้วยครับ");
			$("#down_per").focus();
			return false;
		}
		if($("#interest_per").val()=='')
		{
			alert("กรุณาป้อนดอกเบี้ย%ต่อปี ด้วยครับ");
			$("#interest_per").focus();
			return false;
		}
		var down_price = (parseFloat($("#car_price").val().replace(/,/g,'')) * parseFloat($("#down_per").val().replace(/,/g,''))) / parseFloat(100);
		//$("#down_price").val(addCommas(parseFloat(down_price.toFixed(2))));
		var top_price = parseFloat($("#car_price").val().replace(/,/g,'')) - parseFloat($("#res_price").val().replace(/,/g,'')) - parseFloat(down_price);
		var unit_year = parseFloat($("#unit_year").val().replace(/,/g,'')) * parseFloat(12);
		$("#top_price").val(addCommas(parseFloat(top_price.toFixed(2))));
		var interest_price = (parseFloat(top_price) * parseFloat($("#interest_per").val().replace(/,/g,''))) / parseFloat(100);
		$("#interest_price").val(addCommas(parseFloat(interest_price.toFixed(2))));
		var interest_total = parseFloat(interest_price) * parseFloat($("#unit_year").val().replace(/,/g,''));
		$("#interest_total").val(addCommas(parseFloat(interest_total.toFixed(2))));
		var total_price = parseFloat(top_price) + parseFloat(interest_total);
		$("#total_price").val(addCommas(parseFloat(total_price.toFixed(2))));
		var unit_price = parseFloat(total_price) / parseFloat(unit_year);
		$("#unit_price").val(addCommas(parseFloat(unit_price.toFixed(2))));
	}
	function data_car_modal(car_price)
	{
		document.getElementById("calculate_car_form").reset();
		if(car_price=='' || car_price=='0.00' || car_price=='0')
		{
			$("#car_price").attr('readonly',false);
		}
		else
		{
			$("#car_price").attr('readonly',true);
		}
		$("#car_price").val(addCommas(car_price)); 
	}
	$('#res_price').iMask({type : 'number'});
	$('#car_price').iMask({type : 'number'});
	$('#down_price').iMask({type : 'number'});
function down_price_cal()
{
	if($("#down_per").val()!='')
	{
	var down_price = (parseFloat($("#car_price").val().replace(/,/g,'')) * parseFloat($("#down_per").val().replace(/,/g,''))) / parseFloat(100);
	$("#down_price").val(addCommas(parseFloat(down_price.toFixed(2))));
	}
else
{
	$("#down_price").val('0.00');
}	
}
function down_per_cal()
{
	var down_per = (parseFloat($("#down_price").val().replace(/,/g,'')) / parseFloat($("#car_price").val().replace(/,/g,''))) *  parseFloat(100);
	$("#down_per").val(parseFloat(down_per.toFixed(2))); 
}
$("#tel_mobile1").mask("999-9999999");
$("#tel_mobile2").mask("999-9999999");
$("#tel_mobile3").mask("999-9999999");
$("#tel_home").mask("99-9999999");
$("#id_card").mask("9999999999999");
</script>
