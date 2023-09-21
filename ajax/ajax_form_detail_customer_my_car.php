<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$id_my=$_POST['id_my'];
?>
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
</style>
<div align='right'><a type='button' class='btn btn-primary btn-small' onclick='follow_up1();' id='follow'><i class='icon-tags'></i>เพิ่มรายการติดตาม</a></div>
 <table border='1' class='table-mobile'  width='100%'>
  <!--<caption>Statement Summary</caption>-->
  <thead class='thead-mobile'>
    <tr style="font-size:14px;text-align:center; color:#fff; background-color:#4B7CEC !important;">
	<th scope="col" style='padding:10px;'>วันที่ติดตาม</th>
	<th scope="col" style='padding:10px;'>วันที่นัดชำระ</th>
      <th scope="col" style='padding:10px;' class='span6'>รายละเอียด</th>
      <th scope="col" style='padding:10px;'>ผู้ติดตาม</th>
      <th scope="col" style='padding:10px;'>สถานะ</th>
    </tr>
  </thead>
  <tbody id='html_table'>
  <?php 
  $select_follow_sql="SELECT * FROM tb_follow_car
  LEFT JOIN tb_status_work ON (tb_follow_car.status = tb_status_work.status)
  WHERE id_my = '".$id_my."' ORDER BY date_follow DESC";
  $select_follow_quert=mysql_query($select_follow_sql,$cndb1);
  while($select_follow_array=mysql_fetch_array($select_follow_quert))
  {
  ?>
    <tr class='tr-mobile'>
      <td class='td-mobile' data-label="วันที่ติดตาม"><?php echo $select_follow_array['date_follow']; ?></td>
	  <td class='td-mobile' data-label="วันที่นัดชำระ"><?php echo $select_follow_array['date_payment']; ?></td>
      <td class='td-mobile' data-label="รายละเอียด"><?php echo $select_follow_array['detail']; ?></td>
      <td class='td-mobile' data-label="ผู้ติดตาม"><?php echo $select_follow_array['login']; ?></td>
      <td class='td-mobile' data-label="สถานะ"><?php echo $select_follow_array['status_name']; ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
<script type='text/javascript'>
var num=0;
var limit=0;
function follow_up1()
{
	limit++;
	if(limit>1)
	{
		limit--;
		alert('กรุณาทำรายการติดตามให้เสร็จด้วยครับ');
		return false;
		
	}
	num++;
	var html = "";
	   html += "<tr class='tr-mobile' id='row"+num+"'>";
      html += "<td class='td-mobile' data-label='วันที่ติดตาม'><input type='text' name='date_follow' id='date_follow' style='width:70%' value='<?php echo date('Y-m-d')?>' readonly placeholder='คลิกเลือกวัน'></td>";
	  html += "<td class='td-mobile' data-label='วันที่นัดชำระ'><input type='text' name='date_payment' id='date_payment' style='width:70%' class='span1' readonly placeholder='คลิกเลือกวัน'></td>";
	  <?php
	  $select_status_sql='SELECT * FROM tb_status_work';
	  $select_status_query=mysql_query($select_status_sql,$cndb1);
	  $html_status="";
	  while($select_status_array=mysql_fetch_array($select_status_query))
	  {
		  $html_status.="<option value='".$select_status_array['status']."'>".$select_status_array['status_name']."</option>";
	  }
	  ?>
      html += "<td class='td-mobile' data-label='รายละเอียด'><span><select name='status' id='status' class='span2'><option value='' >--สถานะติดตาม--</option><?php echo $html_status; ?></select></span><span><input class='span4' type='text' id='detail' name='detail' value=''></span></td>";
      html += "<td class='td-mobile' data-label='ผู้ติดตาม'><a type='button' class='btn btn-small btn-success' onclick='save_follow1(\"<?php echo $id_my; ?>\",\""+num+"\");'>บันทึก</a></td>";
      html += "<td class='td-mobile' data-label='สถานะ'><br></td>";
    html +="</tr>";
	$("#html_table").prepend(html);
	$("#detail").focus();
	$('#date_payment').datepicker(
	{
		format: "yyyy-mm-dd",
		startDate: "today",
		language: "th",
		autoclose: true
	});
	$/*('#date_follow').datepicker(
	{
		format: "yyyy-mm-dd",
		startDate: "today",
		language: "th",
		autoclose: true
	});*/
}
function save_follow1(id,row)
{
	if($("#date_payment").val()=='')
	{
		alert("กรุณาเลือกวันนัดหมายด้วยครับ");
		$("#date_payment").focus();
		return false;
	}
	if($("#status").val()=='')
	{
		alert("กรุณาเลือกสถานะติดตามด้วยครับ");
		$("#status").focus();
		return false;
	}
	if($("#detail").val()=='')
	{
		alert("กรุณาป้อนข้อมูลรายละเอียดติดตาม");
		$("#detail").focus();
		return false;
	}
	var save_fo = 
	{
		url:"ajax/ajax_save_follow_customer.php",
		type:"POST",
		dataType:"JSON",
		data:{
			date_payment:$("#date_payment").val(),
			status:$("#status").val(),
			detail:$("#detail").val(),
			id_my:id
		},
		success:function(data)
		{
			if(data.save_data=='Y')
			{
			var html_data="";
		html_data+="<td class='td-mobile' data-label='วันที่ติดตาม'>"+data.date_follow+"</td>";
		html_data+="<td class='td-mobile' data-label='วันที่นัดชำระ'>"+data.date_payment+"</td>";
		html_data+="<td class='td-mobile' data-label='รายละเอียด'>"+data.detail+"</td>";
		html_data+="<td class='td-mobile' data-label='ผู้ติดตาม'>"+data.login+"</td>";
		html_data+="<td class='td-mobile' data-label='สถานะ'>"+data.status_name+"</td>";
		$("#row"+row).html(html_data);
		alert('บันทึกการติดตามเรียบร้อยแล้วครับ');
		limit--;
		
			}
			else
			{
				alert('บันทึกการติดตามไม่สำเร็จครับ');
			}
		},
		error:function()
		{
			alert("บันทึกข้อมูลล้มเหลว กรูณาล็อกอินใหม่");
		}
	};
	$.ajax(save_fo);

}

</script>