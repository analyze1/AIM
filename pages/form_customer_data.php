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
<div class='span12' style='width:97%;'>
		<div class="widget-box">
            <div class="widget-header widget-header-flat"> <h4>เก็บข้อมูลลูกค้า</h4></div>
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
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div  class='border_row' style='width:100%; padding-bottom:5px;padding-top:5px;'>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

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

<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
</div>
<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
<div class='span12' style='padding-top:10px;'>
<a type='button' class='btn btn-info' onclick='save_my_car1();'><i class='icon-save icon-white'></i> บันทึกข้อมูลลูกค้า</a>
</div>
</div>
</form>
</td>
</tr> 
</table>
</div></div></div></div></div></div>
<script type='text/javascript'>
function save_my_car1()
{
	if($("#user").val()=='')
	{
		alert("กรูณาเข้าสู่ระบบใหม่อีกครั้งครับ เนื่องจาก SESSION หมดอายุครับ");
		return false;
	}
	if($("#title").val()=='' && $("#name").val()=='' && $("#last").val()=='' && $("#add").val()=='' && $("#group").val()=='' && $("#home").val()=='' && $("#lane").val()=='' && $("#road").val()=='' && $("#id_province").val()=='' && $("#id_amphur").val()=='' && $("#id_tumbon").val()=='' && $("#postal").val()=='' && $("#job").val()=='' && $("#id_card").val()=='' && $("#tel_mobile1").val()=='' && $("#tel_mobile2").val()=='' && $("#tel_mobile3").val()=='' && $("#tel_office").val()=='' && $("#tel_home").val()=='' && $("#source").val()=='')
	{
		alert("กรุณาเก็บข้อมูลอย่างใดอย่างหนึ่งครับ");
		return false;
	}
	var save_my = 
	{
		url:"ajax/ajax_save_my_car",
		dataType:"JSON",
		type:"POST",
		data:$("#save_my").serialize(),
		success:function(data)
		{
			if(data.status=='Y')
			{
				alert("บันทึกข้อมูลเรียบร้อยแล้วครับ");
				load_page('pages/form_customer_data.php','สต๊อกรถยนต์/จองรถยนต์');
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

$("#tel_mobile1").mask("999-9999999");
$("#tel_mobile2").mask("999-9999999");
$("#tel_mobile3").mask("999-9999999");
$("#tel_home").mask("99-9999999");
$("#id_card").mask("9999999999999");
</script>
