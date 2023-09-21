<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$id_my=$_POST['id_my'];
$tb_my_car_sql="SELECT
tb_stock_car.car_motor,
tb_stock_car.car_body,
tb_stock_car.car_regis_year,
tb_stock_car.car_price,
tb_stock_car.startdate_payment,
tb_stock_car.enddate_payment,
tb_stock_car.date_sale,
tb_stock_car.date_system,
tb_my_car.title,
tb_my_car.name,
tb_my_car.last,
tb_my_car.id_my,
tb_my_car.date_my_car,
tb_my_car.source,
tb_my_car.facebook,
tb_my_car.id_line,
tb_my_car.login,
tb_my_car.tel_home,
tb_my_car.tel_office,
tb_my_car.tel_mobile1,
tb_my_car.tel_mobile2,
tb_my_car.tel_mobile3,
tb_my_car.job,
tb_my_car.add,
tb_my_car.group,
tb_my_car.home,
tb_my_car.lane,
tb_my_car.road,
tb_my_car.id_tumbon,
tb_my_car.id_amphur,
tb_my_car.id_province,
tb_my_car.postal,
tb_my_car.date_my_car,
tb_my_car.id_card,
tb_my_car.seller,
tb_stock_car.startdate_payment,
tb_stock_car.enddate_payment,
tb_stock_car.date_sale,
tb_br_car.name As b_name,
tb_mo_car.name As m_name,
tb_mo_car_sub.name As s_name,
tb_tumbon.name As t_name,
tb_amphur.name As a_name,
tb_province.name As p_name,
tb_color.color_name
FROM tb_my_car
LEFT JOIN tb_stock_car ON (tb_my_car.id_stock = tb_stock_car.id_stock)
LEFT JOIN tb_tumbon ON (tb_my_car.id_tumbon = tb_tumbon.id)
LEFT JOIN tb_amphur ON (tb_my_car.id_amphur = tb_amphur.id)
LEFT JOIN tb_province ON (tb_my_car.id_province = tb_province.id)
LEFT JOIN tb_mo_car ON (tb_stock_car.id_mo_car = tb_mo_car.id) 
LEFT JOIN tb_br_car ON (tb_stock_car.id_br_car = tb_br_car.id) 
LEFT JOIN tb_mo_car_sub ON (tb_stock_car.id_mo_car_sub = tb_mo_car_sub.id) 
LEFT JOIN tb_color ON (tb_stock_car.id_car_color = tb_color.id_color) 
WHERE id_my = '".$id_my."'";
$tb_my_car_query=mysql_query($tb_my_car_sql,$cndb1);
$tb_my_car_array=mysql_fetch_array($tb_my_car_query);	 
    				$address_pdf .= $tb_my_car_array['add'];
    				if($tb_my_car_array['group'] != "-" && $tb_my_car_array['group'] != "")
    				{
    					$address_pdf .= " หมู่ ".$tb_my_car_array['group'];
    				}
    				if($tb_my_car_array['town'] != "-" && $tb_my_car_array['town'] !="")
    				{
    					$address_pdf .= " ".$tb_my_car_array['town'];
    				}
    				if($tb_my_car_array['lane'] !="-" && $tb_my_car_array['lane'] !="")
    				{
    					$address_pdf .= " ซอย".$tb_my_car_array['lane'];
    				}
    				if($tb_my_car_array['road'] !="-" && $tb_my_car_array['road'] !="")
    				{
    					$address_pdf .= " ถนน".$tb_my_car_array['road'];
    				}

    				if($tb_my_car_array['province'] != "102"){
    					$address_pdf .= ' ต.'.$tb_my_car_array['t_name'].' อ.'.$tb_my_car_array['a_name'].' จ.'.$tb_my_car_array['p_name'];
    				}
    				else{
    					$address_pdf .= ' แขวง'.$tb_my_car_array['t_name'].' เขต'.$tb_my_car_array['a_name'].' '.$tb_my_car_array['p_name'];
    				}
    				$address_pdf .= ' '.$tb_my_car_array['postal'];				

?>
<style>

.inline_detail_one{
    display: inline-block;
	width: 350px;
	padding-top:10px;
	padding-left:10px;
}
.inline_detail_two{
    display: inline-block;
	width: 800px;
	padding-top:10px;
	padding-left:10px;
}
.inline_detail_title{
    display: inline-block;
	width: 110px;
}
.button_title
{
background: #ffffff;
border-width:2px;
border-color:#eee;
border-style:solid;
}
.border_class
{
	margin:0; border-style:none none solid none;
	border-width:2px;border-color:#C0C0C0;
}

</style>
<table width='100%'>
<tr>
<td>
<div class='span12' style='margin:0; background-color:#eee; padding:10px;'>
<!--tab1-->
<div class='span12 button_title' style='margin:0; margin-top:7px;' onclick='slide_down("tab1");'>
<div style='font-size:15px; padding:8px; cursor:pointer;'>&nbsp;&nbsp;&nbsp;<i class="icon-file blue"></i> รายละเอียดรถยนต์ <i class="icon-chevron-down"></i></div>
</div>
<div class='span12 slide_tag'  id='tab1' style='margin:0; display:none;'>
<div class=' span12 border_class' style='margin:0;margin-top:7px;'>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>ยี่ห้อรถ</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['b_name']; ?>
</div>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>รุ่นรถ</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['m_name']; ?>
</div>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>รุ่นรถย่อย</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['s_name']; ?>
</div>
</div>
<div class=' span12 border_class' style='margin:0;margin-top:7px;'>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>เลขตัวเครื่อง</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['car_motor']; ?>
</div>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>เลขตัวถัง</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['car_body']; ?>
</div>
</div>
<div class=' span12 border_class' style='margin:0;margin-top:7px;'>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>สีรถยนต์</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['color_name']; ?>
</div>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>ปีรถยนต์</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['car_regis_year']; ?>
</div>
</div>
<div class=' span12 border_class' style='margin:0;margin-top:7px;'>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>วันที่ขายรถ</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['date_sale']; ?>
</div>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>วันที่เริ่มชำระ</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['startdate_payment']; ?>
</div>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>วันหมดเขตชำระ</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['enddate_payment']; ?>
</div>
</div>
<div class=' span12 border_class' style='margin:0;margin-top:7px;'>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>ราคารถยนต์</b></div>
<span>:&nbsp;</span><?php echo number_format($tb_my_car_array['car_price'],2,'.',','); ?>
</div>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>ผู้ที่ขาย</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['seller']; ?>
</div>
</div>
</div>
<!--tab2-->
<div class='span12 button_title' style='margin:0;' onclick='slide_down("tab2");'>
<div style='font-size:15px; padding:8px; cursor:pointer;'>&nbsp;&nbsp;&nbsp;<i class="icon-list-alt blue"></i> รายละเอียดลูกค้า <i class="icon-chevron-down"></i></div>
</div>
<div class='span12 slide_tag' style='margin:0; display:none;' id='tab2' onclick='slide_down("tab2");'>
<div class=' span12 border_class' style='margin:0;margin-top:7px;'>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>ชื่อลูกค้า</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['title'].$tb_my_car_array['name']." ".$tb_my_car_array['last']; ?>
</div>
<div class='inline_detail_two'>
<div class='inline_detail_title'><b>ที่อยู่ลูกค้า</b></div>
<span>:&nbsp;</span><?php echo $address_pdf; ?>
</div>
</div>
<div class=' span12 border_class' style='margin:0;margin-top:7px;'>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>เลขบัตรประชาชน</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['id_card']; ?>
</div>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>อาชีพ</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['job']; ?>
</div>
</div>
<div class=' span12 border_class' style='margin:0;margin-top:7px;'>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>เบอร์มือถือ1</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['tel_mobile1']; ?>
</div>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>เบอร์มือถือ2</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['tel_mobile2']; ?>
</div>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>เบอร์มือถือ3</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['tel_mobile3']; ?>
</div>
</div>
<div class=' span12 border_class' style='margin:0;margin-top:7px;'>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>เบอร์บ้าน</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['tel_home']; ?>
</div>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>เบอร์ที่ทำงาน</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['tel_office']; ?>
</div>
</div>
<div class=' span12 border_class' style='margin:0;margin-top:7px;'>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>facebook</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['facebook']; ?>
</div>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>id_line</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['id_line']; ?>
</div>
</div>
<div class=' span12 border_class' style='margin:0;margin-top:7px;'>
<div class='inline_detail_one'>
<div class='inline_detail_title'><b>แหล่งที่มา</b></div>
<span>:&nbsp;</span><?php echo $tb_my_car_array['source']; ?>
</div>

</div>
</div>
<!--tab1-->
<div class='span12 button_title' style='margin:0;' onclick='slide_down("tab3");'>
<div style='font-size:15px; padding:8px; cursor:pointer;'>&nbsp;&nbsp;&nbsp;<i class="icon-calendar blue"></i> ตารางการติดตาม <i class="icon-chevron-down"></i></div>
</div>
<div class='span12 slide_tag' style='margin:0;  display:none;' id='tab3'>
<div class=' span12' style='margin:0;margin-top:7px;'>
<div align='right'><a type='button' class='btn btn-primary btn-small' onclick='follow_up();' id='follow'><i class='icon-tags'></i>เพิ่มรายการติดตาม</a></div>
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
</div>
</div>
</div>
</td>
</tr>
</table>
<script type='text/javascript'>
var num=0;
var limit=0;
function follow_up()
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
      html += "<td class='td-mobile' data-label='วันที่ติดตาม'><input type='text' name='date_follow' id='date_follow' class='span8' value='<?php echo date('Y-m-d')?>' readonly placeholder='คลิกเลือกวัน'></td>";
	  html += "<td class='td-mobile' data-label='วันที่นัดชำระ'><input type='text' name='date_payment' id='date_payment' class='span8' readonly placeholder='คลิกเลือกวัน'></td>";
	  <?php
	  $select_status_sql='SELECT * FROM tb_status_work';
	  $select_status_query=mysql_query($select_status_sql,$cndb1);
	  $html_status="";
	  while($select_status_array=mysql_fetch_array($select_status_query))
	  {
		  $html_status.="<option value='".$select_status_array['status']."'>".$select_status_array['status_name']."</option>";
	  }
	  ?>
      html += "<td class='td-mobile' data-label='รายละเอียด'><span><select name='status' id='status' class='span3'><option value='' >--สถานะติดตาม--</option><?php echo $html_status; ?></select></span><span><input class='span7' type='text' id='detail' name='detail' value=''></span></td>";
      html += "<td class='td-mobile' data-label='ผู้ติดตาม'><a type='button' class='btn btn-small btn-success' onclick='save_follow(\"<?php echo $id_my; ?>\",\""+num+"\");'>บันทึก</a></td>";
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
function save_follow(id,row)
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
function slide_down(g)
{
	if($("#"+g).hasClass("slide_tag"))
	{
		$("#"+g).slideDown();
		$("#"+g).removeClass("slide_tag");
	}
	else
	{
		$("#"+g).slideUp();
		
		$("#"+g).addClass("slide_tag");
	}
}
slide_down("tab1");
</script>