<?php
	include "check-ses.php"; 
	include "../inc/connectdbs.pdo.php"; 
	header('Content-Type: text/html; charset=utf-8');
?>	
<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
<script src="js/jquery.imask.js"></script>
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>

<style>
</style>
</script>
<div class="widget-box">
<div class="widget-header widget-header-flat"> <h4>ข้อมูลอุปกรณ์ตกแต่งเพิ่มเติม</h4></div>
<div class="widget-body">
<div class="widget-main">
<div class="row-fluid">
<div class='span12' style='margin:0;'>
<div class='span6' style='margin:0;' align='left'>
<button class='btn btn-small btn-info' id='change_text_acc' onclick='$("#show_acc_data").slideToggle();'>เพิ่มข้อมูล</button>
</div>
<div class='span6' style='margin:0;' align='right'>
</div>
</div>
<div class="span12" style='margin:0; display:none;' id='show_acc_data'>
<form id='acc_data'>

<div class='span1' style='margin:0;'>
ประเภทรถ :
</div>
<div class='span2' style='margin:0;'>
<select class='span10'  name='idcar' id='idcar'>
<option value=''>เลือกประเภทรถ</option>
<option value='1'>รถเก๋ง</option>
<option value='3'>รถกระบะ</option>
</select>
</div>


<div class='span1' style='margin:0;'>
ชื่อ อป. :
</div>
<div class='span2' style='margin:0;'>
<input type='text' type='text' class='span10' name='name' id='name'>
</div>


<div class='span1' style='margin:0;'>
ทุนสิ้นสุด :
</div>
<div class='span2' style='margin:0;'>
<input type='text' type='text' class='span10'  name='start_cost' id='start_cost'>
</div>

<div class='span1' style='margin:0;'>
สถานะฟรี :
</div>
<div class='span2' style='margin:0;'>
<select name='status_free' class='span10'  id='status_free'>
<option value=''>เลือกสถานะ</option>
<option value='N'>ไม่ฟรี</option>
<option value='Y'>ฟรี</option>
</select>
</div>

<div class='span1' style='margin:0;'>
<a type='button' class='btn btn-small btn-info' onclick='save_acc();' id='save_button_acc'>บันทึกข้อมูล</a>
</div>

</form>
</div>
<div class='span12' style='margin:0;'>

<table width='100%' id='table_acc' class="table table-striped table-bordered">
<thead>
<tr>
<th style='background-color: #e6f9ff;'>เลือกแก้ไข</th>
<th style='background-color: #e6f9ff;'>รายการอุปกรณ์ตกแต่งเพิ่มเติม</th>
<th style='background-color: #e6f9ff;'>ประเภทรถ</th>
<th style='background-color: #e6f9ff;'>ทุนเริ่มต้น</th>
<th style='background-color: #e6f9ff;'>อป free</th>
<th style='background-color: #e6f9ff;'>ใช้งาน</th>
</tr>
</thead>
<tbody>

</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<!--Modal-->
<div class="modal" tabindex="-1" role="dialog" id='modal_edit_acc' style='display:none;'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">X</span>
        </button>
        <h5 class="modal-title" id='modal_acc'></h5>

      </div>
      <div class="modal-body">
	  <form  id='edit_acc_data'>
		<table width='100%' border='1'>
		<tr>
		<td>ไอดีหลัก :</td>
		<td><input type='text' name='edit_id' id='edit_id' class='' value='' readonly></td>
		</tr>
		<tr style='display:none;'>
		<td>ประเภทรถ :</td>
		<td>
		<select name='edit_idcar' class=''  id='edit_idcar'>
		<option value=''>เลือกประเภทรถ</option>
		<option value='1'>รถเก๋ง</option>
		<option value='3'>รถกระบะ</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>ชื่อ อุปกรณ์ตกแต่ง :</td>
		<td><input type='text' name='edit_name' id='edit_name' class='' value='' readonly></td>
		</tr>

		<tr>
		<td>ทุนสิ้นสุด :</td>
		<td><input type='text' name='edit_start_cost' id='edit_start_cost' class='' value=''></td>
		</tr>
		<tr>
		<td>อป free</td>
		<td>		<select name='edit_status_free' class=''  id='edit_status_free'>
		<option value=''>เลือกสถานะ</option>
		<option value='N'>ไม่ฟรี</option>
		<option value='Y'>ฟรี</option>
		</select></td>
		</tr>
		<tr>
		<td>ใช้งาน</td>
		<td>		<select name='edit_status_use' class=''  id='edit_status_use'>
		<option value=''>เลือกสถานะ</option>
		<option value='N'>ไม่ใช้งาน</option>
		<option value='Y'>ใช้งาน</option>
		</select></td>
		</tr>
		
		</table>
 
		</form>
      </div>
	  
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick='edit_save_acc();' id='edit_save_button_acc'>Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
//$("#table_acc").DataTable();
var table = $('#table_acc').DataTable({
    "processing": true,
    "serverSide": true,
    //"ordering":false,
    "order": [[ 0, "desc" ]],
    "ajax":"ajax/ajax_data_manage_acc_new.php",
   "columns": [
    {
		"targets": 0,
		"bSortable" : true,
		"bSearchable": true,
		"name":"id",
		"data":"id"
		},
    {
		"targets": 1,
		"bSortable" : true,
		"bSearchable": true,
		"name":"name",
		"data":"name"
		},
    {
		"targets": 2,
		"bSortable" : true,
		"bSearchable": true,
		"name":"idcar",
		"data":"idcar"
		},
    {
		"targets": 3,
		"bSortable" : true,
		"bSearchable": true,
		"name":"start_cost",
		"data":"start_cost"
		},
    {
		"targets": 4,
		"bSortable" : true,
		"bSearchable": true,
		"name":"status_free",
		"data":"status_free"
		},
    {
		"targets": 5,
		"bSortable" : true,
		"bSearchable": true,
		"name":"status_use",
		"data":"status_use"
		}
    ]
    
});
function save_acc()
{
	if($("#idcar").val()=='')
	{
		alert("กรุณาเลือกประเภทรถด้วยครับ");
		$("#idcar").focus();
		return false;
	}
	if($("#name").val()=='')
	{
		alert("กรุณาคีย์ชื่ออุปกรณ์ตกแต่งเพิ่มเติมด้วยครับ");
		$("#name").focus();
		return false;
	}
	if($("#start_cost").val()=='')
	{
		alert("กรุณาคีย์ข้อมูลทุนเริ่มต้นด้วยครับ");
		$("#start_cost").focus();
		return false;
	}
	if($("#status_free").val()=='')
	{
		alert("กรุณาเลือกสถานะฟรีด้วยครับ");
		$("#status_free").focus();
		return false;
	}
	$("#save_button_acc").attr('disabled',true);
	if(confirm('คุณต้องการบันทึกข้อมูลใช่หรือไม่')==false)
	{
		$("#save_button_acc").attr('disabled',false);
		return false;
	}
	var save =
	{
		url:"ajax/ajax_save_manage_acc.php",
		type:"POST",
		dataType:"JSON",
		data:$("#acc_data").serialize(),
		success:function(data)
		{
			alert(data.alert);
			if(data.status=='Y')
			{
			$("#acc_data")[0].reset();
			 table.ajax.reload();
			}
		$("#save_button_acc").attr('disabled',false);
		}
	};
	$.ajax(save);
}
function edit_data(id,name,idcar,start_cost,status_free,status_use)
{
	$("#modal_acc").html("แก้ไข "+name);
	$("#edit_id").val(id);
	$("#edit_name").val(name);
	$("#edit_idcar").val(idcar);
	$("#edit_start_cost").val(start_cost);
	$("#edit_status_free").val(status_free);
	$("#edit_status_use").val(status_use);
}
function edit_save_acc()
{
	if($("#edit_idcar").val()=='')
	{
		alert("กรุณาเลือกประเภทรถด้วยครับ");
		$("#edit_idcar").focus();
		return false;
	}
	if($("#edit_name").val()=='')
	{
		alert("กรุณาคีย์ชื่ออุปกรณ์ตกแต่งเพิ่มเติมด้วยครับ");
		$("#edit_name").focus();
		return false;
	}
	if($("#edit_start_cost").val()=='')
	{
		alert("กรุณาคีย์ข้อมูลทุนเริ่มต้นด้วยครับ");
		$("#edit_start_cost").focus();
		return false;
	}
	if($("#edit_status_free").val()=='')
	{
		alert("กรุณาเลือกสถานะฟรีด้วยครับ");
		$("#edit_status_free").focus();
		return false;
	}
	if($("#edit_status_use").val()=='')
	{
		alert("กรุณาเลือกสถานะการใช้ด้วยครับ");
		$("#edit_status_use").focus();
		return false;
	}
	$("#edit_save_button_acc").attr('disabled',true);
	if(confirm('คุณต้องการบันทึกข้อมูลใช่หรือไม่')==false)
	{
		$("#edit_save_button_acc").attr('disabled',false);
		return false;
	}
		var save =
	{
		url:"ajax/ajax_edit_manage_acc.php",
		type:"POST",
		dataType:"JSON",
		data:$("#edit_acc_data").serialize(),
		success:function(data)
		{
			alert(data.alert);
			if(data.status=='Y')
			{
			$("#edit_acc_data")[0].reset();
			$(".close").trigger('click');
			 table.ajax.reload();
			}
		$("#edit_save_button_acc").attr('disabled',false);
		}
	};
	$.ajax(save);
}
/*$('#start_cost').iMask({
		type : 'number'
		, decDigits : 0
		, decSymbol : ''
		});
$('#edit_start_cost').iMask({
		type : 'number'
		, decDigits : 0
		, decSymbol : ''
		});*/
</script>