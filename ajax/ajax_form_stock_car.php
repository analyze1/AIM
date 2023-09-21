<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
?>
<style type='text/css'>
.inline_add_one{
    display: inline-block;
	width: 350px;
}
.inline_add_two{
    display: inline-block;
	width: 400px;
}
.inline_add_title{
    display: inline-block;
	width: 100px;
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
.img_color {
    width: 35px;
	
	
	position:absolute;
    -webkit-transition-property: width; /* Safari */
    -webkit-transition-duration: 0.5s; /* Safari */
    transition-property: width;
    transition-duration: 0.5s;
}

.img_color:hover {
    width: 130px;
}
</style>
<div class='span12' style='width:100%;'>
		<div class="widget-box">
            <div class="widget-header widget-header-flat"> <h4>ข้อมูลสต๊อกรถยนต์</h4></div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row-fluid">
                            <div class="span12">
    <form name='save_stock' id='save_stock'>
<table class="table">
<tr>
<td>

<div class='span12 border_row' style='width:100%; padding-bottom:10px;'>
<a type='button' class='btn btn-success' onclick='add_row();'><i class="icon-plus icon-white"></i>เพิ่มรายการ</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<div class='inline_add_one' style='width:500px;'>
<div class='inline_add_title'>สาขาผู้ทำสต๊อก</div>

<select name="login" id="login" class='span8'>
<?php if($_SESSION['strUser']=='admin' || $_SESSION['claim']=='ADMIN'){ 
$u_sql='WHERE nameuser = "mitsubishi"';
?>
        <option value="" selected="selected">กรุณาเลือกชื่อผู้ทำสต๊อก</option>
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
<span>
<div id='add_form' class='span12' style='width:100%;'>
<!--ช่วงเรียก html มาแสดง-->

<!--ช่วงเรียก html มาแสดง-->
</div>
<div class='span12' style='padding-top:10px;'>
<a type='button' class='btn btn-info' onclick='save_stock_car();'><i class='icon-save icon-white'></i> บันทึกสต๊อกรถ</a>
</div>
</span>
</td>
</tr> 
</table>
</form>
</div></div></div></div></div></div>

  
<script type='text/javascript'>
var row=0;
var limit_row=0;
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
function add_row()
{
	var add_html="";
add_html+="<div class='border_row' style='width:100%; padding-bottom:5px;padding-top:5px;' id='row_"+row+"'>";
add_html+="<div class='inline_add_one'>";
add_html+="<div class='inline_add_title'>ยี่ห้อรถ</div>";
add_html+="<select name='id_br_car[]' id='id_br_car"+row+"' onchange='data_br_car("+row+");' class='span6'>";
add_html+="<option value=''>--กรุณาเลือกยี่ห้อรถ--</option>";
<?php
$select_br_car_sql="SELECT tb_br_car.id,tb_br_car.name,tb_cat_car.name As c_name FROM tb_br_car
INNER JOIN tb_mo_car ON (tb_br_car.id = tb_mo_car.br_id)
INNER JOIN tb_mo_car_sub ON (tb_mo_car.id = tb_mo_car_sub.mo_car)
INNER JOIN tb_cat_car ON (tb_br_car.cat_id = tb_cat_car.id)
WHERE tb_mo_car_sub.status_subcar = 'T' GROUP BY tb_br_car.id";
$select_br_car_query=mysql_query($select_br_car_sql,$cndb1);
while($select_br_car_array=mysql_fetch_array($select_br_car_query))
{ ?>
add_html+="<option value='<?php echo $select_br_car_array['id']; ?>'><?php echo $select_br_car_array['name']." (".$select_br_car_array['c_name'].")"; ?></option>";
<?php } ?>
add_html+="</select>";
add_html+="</div>";
add_html+="<div class='inline_add_one'>";
add_html+="<div class='inline_add_title'>รุ่นรถ</div>";
add_html+="<select name='id_mo_car[]' id='id_mo_car"+row+"' onchange='data_mo_car("+row+");'  class='span6'>";
add_html+="<option value=''>--กรุณาเลือกรุ่นรถ--</option>";
add_html+="</select>";
add_html+="</div>";
add_html+="<div class='inline_add_one'>";
add_html+="<div class='inline_add_title'>รุ่นรถย่อย</div>";
add_html+="<select name='id_mo_car_sub[]' id='id_mo_car_sub"+row+"' class='span6' onchange='select_price_stock("+row+");select_color_car("+row+");' >";
add_html+="<option value=''>--กรุณาเลือกรุ่นรถย่อย--</option>";
add_html+="</select>";
add_html+="</div>";
add_html+="<div class='inline_add_one'>";
add_html+="<div class='inline_add_title'>สีรถ</div>";
add_html+="<select name='id_car_color[]' id='id_car_color"+row+"' class='span4' onchange='select_price_stock("+row+");select_img_color("+row+");' >";
add_html+="<option value=''>--กรุณาเลือกสีรถ--</option>";
<?php
//$select_color_sql='SELECT * FROM tb_color WHERE id_color NOT IN("99")';
//$select_color_query=mysql_query($select_color_sql,$cndb1);
//while($select_color_array=mysql_fetch_Array($select_color_query))
//{ ?>
//add_html+="<option value='<?php echo $select_color_array['id_color']; ?>'><?php echo $select_color_array['color_name']; ?></option>";
<?php //} ?>
add_html+="</select>";
add_html+="&nbsp;&nbsp;&nbsp;&nbsp;<span id='img_data"+row+"'></span>";
add_html+="</div>";
add_html+="<div class='inline_add_one'>";
add_html+="<div class='inline_add_title'>ปีรถยนต์</div>";
add_html+="<select name='car_regis_year[]' id='car_regis_year"+row+"' class='span6'>";
add_html+="<option value=''>--กรุณาเลือกปีรถยนต์--</option>";
<?php
$year_now=date('Y');
$year_while=$year_now-100;
for($i=$year_now;$i>=$year_while;$i--)
{ ?>
add_html+="<option value='<?php echo $i; ?>'><?php echo $i; ?></option>";
<?php } ?>
add_html+="</select>";
add_html+="</div>";
add_html+="<div class='inline_add_two'>";
add_html+="<div class='inline_add_title'>เลขตัวเครื่อง</div>";
add_html+="<input type='text' name='car_motor1[]' class='span4' id='car_motor1"+row+"' value='' >&nbsp;<font size='4'>-</font>&nbsp;<input type='text' name='car_motor2[]' class='span4' id='car_motor2"+row+"' value=''>";
add_html+="</div>";
add_html+="<div class='inline_add_two'>";
add_html+="<div class='inline_add_title'>เลขตัวถัง</div>";
add_html+="<input type='text' name='car_body1[]' class='span4' id='car_body1"+row+"' value='' ><input type='text' class='span4' name='car_body2[]' id='car_body2"+row+"' value=''>";
add_html+="</div>";
add_html+="<div class='inline_add_two'>";
add_html+="<div class='inline_add_title'>ราคารถ</div>";
add_html+="<input type='text' name='car_price[]' class='span6' id='car_price"+row+"' value='0.00'>";
//add_html+="<a type='button' class='btn btn-small btn-info'  data-toggle='modal' data-target='#search_car' onclick='data_car_modal(\""+row+"\");' >คำนวณงวด</a>";
add_html+="</div>";
add_html+="<div class='inline_add_one'>";
add_html+="<div class='inline_add_title'>วันที่บันทึก</div>";
//add_html+="<div class='input-append date' id='date_save_show"+row+"'>";
add_html+="<input type='text' name='date_save[]' class='span6' id='date_save"+row+"' value='<?php echo date('Y-m-d'); ?>' placeholder='คลิกเลือกวัน'   readonly >";
//add_html+="<span class='add-on'><i class='icon-th'></i></span></div></div>";
add_html+="</div>";
add_html+="<div class='inline_add_one'>";
add_html+="<div class='inline_add_title'>วันที่กำหนดชำระ</div>";
add_html+="<div class='input-append date' id='startdate_payment_show"+row+"'><input type='text' name='startdate_payment[]' id='startdate_payment"+row+"' class='span6'  value=''  placeholder='คลิกเลือกวัน'   onchange='date_end("+row+");' readonly ><span class='add-on'><i class='icon-th'></i></span></div>";
add_html+="</div>";
add_html+="<div class='inline_add_one'>";
add_html+="<div class='inline_add_title'>วันที่หมดเขตชำระ</div>";
add_html+="<input type='text' name='enddate_payment[]' class='span4' id='enddate_payment"+row+"' value='' readonly>";
add_html+="</div>";
add_html+="<div class='inline_add_one'>";
add_html+="<div class='inline_add_title'>วันที่ขายรถ</div>";
add_html+="<div class='input-append date' id='date_sale_show"+row+"'><input type='text' name='date_sale[]' id='date_sale"+row+"' class='span6' placeholder='คลิกเลือกวัน'   value='' readonly><span class='add-on'><i class='icon-th'></i></span></div>";
add_html+="</div>";
add_html+="<span>";
add_html+="<a type='button' class='btn btn-small btn-danger' onclick='delete_row(\""+row+"\");'><i class='icon-remove'></i>ลบรายการ</a>";
add_html+="</span>";
add_html+="</div>";
$("#add_form").append(add_html);
/*$('#date_save_show'+row).datepicker(
	{
		format: "yyyy-mm-dd",
		startDate: "today",
		language: "th",
		autoclose: true
	});*/
$('#startdate_payment_show'+row).datepicker(
	{
		format: "yyyy-mm-dd",
		startDate: "today",
		language: "th",
		autoclose: true
	});
$('#date_sale_show'+row).datepicker(
	{
		
		format: "yyyy-mm-dd",
		startDate: "today",
		language: "th",
		autoclose: true
	});
	$('#car_body2'+row).mask("99999999");
	$('#car_price'+row).iMask({type : 'number'});
row++;
limit_row++;
}
function delete_row(row)
{
limit_row--;
$("#row_"+row).remove();
if(limit_row==0)
{
	add_row();
}
}
add_row();
function save_stock_car()
{
	if($("#login").val()=="")
		{
			alert("กรุณาเลือกสาขาผู้ทำสต๊อกด้วยครับ");
			$("#login").focus();
			return false;
		}
	for(var i=0;i<document.getElementsByName("id_br_car[]").length;i++)
	{
		if(document.getElementsByName("id_br_car[]")[i].value=="")
		{
			alert("กรุณาเลือกยี่ห้อรถด้วยครับ");
			document.getElementsByName("id_br_car[]")[i].focus();
			return false;
		}
		if(document.getElementsByName("id_mo_car[]")[i].value=="")
		{
			alert("กรุณาเลือกรุ่นรถด้วยครับ");
			document.getElementsByName("id_mo_car[]")[i].focus();
			return false;
		}
		if(document.getElementsByName("id_mo_car_sub[]")[i].value=="")
		{
			alert("กรุณาเลือกรุ่นรถย่อยด้วยครับ");
			document.getElementsByName("id_mo_car_sub[]")[i].focus();
			return false;
		}
		if(document.getElementsByName("id_car_color[]")[i].value=="")
		{
			alert("กรุณาเลือกสีรถด้วยครับ");
			document.getElementsByName("id_car_color[]")[i].focus();
			return false;
		}
		if(document.getElementsByName("car_regis_year[]")[i].value=="")
		{
			alert("กรุณาเลือกปีรถยนต์ด้วยครับ");
			document.getElementsByName("car_regis_year[]")[i].focus();
			return false;
		}
		if(document.getElementsByName("car_motor1[]")[i].value=="")
		{
			alert("กรุณาป้อนเลขตัวเครื่องด้วยครับ");
			document.getElementsByName("car_motor1[]")[i].focus();
			return false;
		}
		if(document.getElementsByName("car_motor2[]")[i].value=="")
		{
			alert("กรุณาป้อนเลขตัวเครื่องด้วยครับ");
			document.getElementsByName("car_motor2[]")[i].focus();
			return false;
		}
		if(document.getElementsByName("car_body1[]")[i].value=="")
		{
			alert("กรุณาป้อนเลขตัวถังด้วยครับ");
			document.getElementsByName("car_body1[]")[i].focus();
			return false;
		}
		if(document.getElementsByName("car_body2[]")[i].value=="")
		{
			alert("กรุณาป้อนเลขตัวถังด้วยครับ");
			document.getElementsByName("car_body2[]")[i].focus();
			return false;
		}
		if(document.getElementsByName("car_price[]")[i].value=="" || document.getElementsByName("car_price[]")[i].value==0)
		{
			alert("กรุณาป้อนราคารถด้วยครับ");
			document.getElementsByName("car_price[]")[i].focus();
			return false;
		}
		if(document.getElementsByName("date_save[]")[i].value=="")
		{
			alert("กรุณาเลือกวันที่บันทึกด้วยครับ");
			document.getElementsByName("date_save[]")[i].focus();
			return false;
		}
		if(document.getElementsByName("startdate_payment[]")[i].value=="")
		{
			alert("กรุณาเลือกวันที่เริ่มชำระด้วยครับ");
			document.getElementsByName("startdate_payment[]")[i].focus();
			return false;
		}
		if(document.getElementsByName("enddate_payment[]")[i].value=="")
		{
			alert("กรุณาเลือกวันที่สิ้นสุดชำระด้วยครับ");
			document.getElementsByName("enddate_payment[]")[i].focus();
			return false;
		}
		if(document.getElementsByName("date_sale[]")[i].value=="")
		{
			alert("กรุณาเลือกวันที่ขายรถด้วยครับ");
			document.getElementsByName("date_sale[]")[i].focus();
			return false;
		}
	}
	var save_stock = 
	{
		url:"ajax/ajax_save_stock_car.php",
		dataType:"JSON",
		type:"POST",
		data:$("#save_stock").serialize(),
		success:function(data)
		{
			if(data.status_save=='Y')
			{
				alert(data.alert);
				load_page('pages/form_stock_suzuki.php','สต๊อกรถยนต์/จองรถยนต์');
			}
			else
			{
				alert(data.alert);
			}
		},
		error:function()
		{
			alert('บันทึกข้อมูลล้มเหลว');
		}
	};
	$.ajax(save_stock);
}
//วันสิ้นสุดชำระ
function date_end(row)
{
	var date_now = $("#startdate_payment"+row).val();
	$.post("ajax/ajax_date_ago_my_stock_car.php",{text_date:date_now},function(data){$("#enddate_payment"+row).val(data);});
}
//รุ่นรถ
function data_br_car(row)
{
		$("#id_car_color"+row).html("<option value=''>--กรุณาเลือกสีรถ--</option>");
	$("#img_data"+row).html("");
	$("#id_mo_car_sub"+row).html("<option value=''>--กรุณาเลือกรุ่นรถย่อย--</option>");
	$.post("ajax/ajax_my_stock_mo_car.php",{br_id:$("#id_br_car"+row).val()},function(data){$("#id_mo_car"+row).html(data);});
}
//รุ่นย่อย
function data_mo_car(row)
{
		$("#id_car_color"+row).html("<option value=''>--กรุณาเลือกสีรถ--</option>");
	$("#img_data"+row).html("");
	var id_mo_car =
	{
		url:"ajax/ajax_my_stock_mo_car_sub.php",
		dataType:"JSON",
		type:"POST",
		data:{mo_car:$("#id_mo_car"+row).val()},
		success:function(data)
		{
			$("#id_mo_car_sub"+row).html(data.select);
			var car_body_array=data.car_body.split("|");
			if(car_body_array[0]!='')
			{
			$("#car_body1"+row).val(car_body_array[0]);
			$("#car_body1"+row).attr("readonly",true);
			}
			else
			{
				$("#car_body1"+row).attr("readonly",false);
				$("#car_body1"+row).val(car_body_array[0]);
			}
			if(car_body_array[1]!='')
			{
			$("#car_motor1"+row).val(car_body_array[1]);
			$("#car_motor1"+row).attr("readonly",true);
			}
			else
			{
				$("#car_motor1"+row).attr("readonly",false);
				$("#car_motor1"+row).val(car_body_array[1]);
			}
		}
	};
	$.ajax(id_mo_car);
}
function select_price_stock(row)
{
	$.post("ajax/ajax_search_car_price.php",{id_mo_car_sub:$("#id_mo_car_sub"+row).val(),id_car_color:$("#id_car_color"+row).val()},function(data){$("#car_price"+row).val(data); if(data =='0' || data == '0.00' || data == ''){$("#car_price"+row).attr('readonly',false)}else{$("#car_price"+row).attr('readonly',true)}});
}
function select_color_car(row)
{

	$("#img_data"+row).html("");
	$.post("ajax/ajax_my_stock_car_color.php",{id_mo_car_sub:$("#id_mo_car_sub"+row).val()},function(data){$("#id_car_color"+row).html(data);});
}
function select_img_color(row)
{
	$.post("ajax/ajax_my_stock_img_color.php",{id_color:$("#id_car_color"+row).val()},function(data){$("#img_data"+row).html(data);});
}
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
	function data_car_modal(row)
	{
		document.getElementById("calculate_car_form").reset();
		if($("#car_price"+row).val()=='' || $("#car_price"+row).val()=='0.00' || $("#car_price"+row).val()=='0')
		{
			$("#car_price").attr('readonly',false);
		}
		else
		{
			$("#car_price").attr('readonly',true);
		}
		$("#car_price").val(addCommas($("#car_price"+row).val())); 
	}
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
	$('#res_price').iMask({type : 'number'});
	$('#car_price').iMask({type : 'number'});
	$('#down_price').iMask({type : 'number'});
</script>