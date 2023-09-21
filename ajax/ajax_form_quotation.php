<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$today_Y=date(y)+43;
$today_Y_cus=date(y);
$sql_insq = "SELECT q_auto FROM	 tb_quotation_car WHERE q_auto like 'QC".$today_Y."%' order by q_auto DESC";
$result_insq = mysql_query($sql_insq,$cndb1);
$result_array=mysql_fetch_array($result_insq);
$change_Y = "QC".$today_Y;
@$change = split($change_Y,$result_array['q_auto']);
@$number=$change[1]+1;
if($number<=9)
{
$code='000';
}
else if($number<=99)
{
$code='00';
}
else if($number<=999)
{
$code='0';
}
else if($number<=9999)
{
$code='';
}
$plus_code="QC".$today_Y.$code.$number;
?>
<style>
.q_box
{
	width:300px;
	display:inline-block;
}
.q_title
{
	width:100px;
	display:inline-block;
}
.q_input
{
	width:150px;
	display:inline-block;
}
</style>
<form name='data_quotation' id='data_quotation'>
<div class='span12'>
<div class='q_box'>
<div class='q_title'>เรียนคุณ</div><div class='q_input'><input type='text' style='width:100%' name='name' id='name'></div>
</div>
<div class='q_box'>
<div class='q_title'>เบอร์มือถือ</div><div class='q_input'><input type='text' style='width:100%' name='tel_mobile' id='tel_mobile'></div>
</div>
<div class='q_box'>
<div class='q_title'>เลขใบเสนอราคา</div><div class='q_input'><input type='text' style='width:100%' readonly value='<?php echo $plus_code; ?>' name='q_auto' id='q_auto'></div>
</div>
</div>
<div class='span12'>
<a type='button' class='btn btn-small btn-primary' onclick='add_row();'><i class='icon-plus'></i> เพิ่มรายการ</a>
</div>
<table width='100%' border='1' class='table-mobile'>
<thead class='thead-mobile'>
<tr class='tr-mobile'>
<th class='th-mobile'>ยี่ห้อรถ</th>
<th class='th-mobile'>รุ่นรถ</th>
<th class='th-mobile'>รุ่นรถย่อย (modal)</th>
<th class='th-mobile'>สีรถ</th>
<th class='th-mobile'>ปีรถ</th>
<th class='th-mobile'>เลขตัวเครื่อง</th>
<th class='th-mobile'>เลขตัวถัง</th>
<th class='th-mobile'>ราคารถ</th>
<th class='th-mobile'>ลบ</th>
</tr>
</thead>
<tbody id='html_quotation'>

</tbody>
</table>
<div class='span12'>
<br>
รายละเอียดเพิ่มเติม&nbsp;&nbsp;&nbsp;<textarea rows='3' style='width:80%'; name='detail' id='detail'></textarea>
</div>
</form>
<script>
var row=0;
var max=0;
function add_row()
{
	var html_code="";
html_code+="<tr class='tr-mobile' id='row"+row+"'>";
html_code+="<td class='td-mobile' data-label='ยี่ห้อรถ'><select style='width:70%;' name='id_br_car[]'  id='id_br_car"+row+"' onchange='data_br_car("+row+");'><option value=''>--กรุณาเลือกยี่ห้อรถ--</option>";

<?php
$select_br_car_sql="SELECT tb_br_car.id,tb_br_car.name,tb_cat_car.name As c_name FROM tb_br_car
INNER JOIN tb_mo_car ON (tb_br_car.id = tb_mo_car.br_id)
INNER JOIN tb_mo_car_sub ON (tb_mo_car.id = tb_mo_car_sub.mo_car)
INNER JOIN tb_cat_car ON (tb_br_car.cat_id = tb_cat_car.id)
WHERE tb_mo_car_sub.status_subcar = 'T' GROUP BY tb_br_car.id";
$select_br_car_query=mysql_query($select_br_car_sql,$cndb1);
while($select_br_car_array=mysql_fetch_array($select_br_car_query))
{ ?>
html_code+="<option value='<?php echo $select_br_car_array['id']; ?>'><?php echo $select_br_car_array['name']." (".$select_br_car_array['c_name'].")"; ?></option>";
<?php } ?>

html_code+="</select></td>";
html_code+="<td class='td-mobile' data-label='รุ่นรถ'><select style='width:70%;' name='id_mo_car[]' id='id_mo_car"+row+"' onchange='data_mo_car("+row+");'><option value=''>--กรุณาเลือกรุ่นรถ--</option></select></td>";
html_code+="<td class='td-mobile' data-label='รุ่นรถย่อย (modal)'><select style='width:70%;' name='id_mo_car_sub[]' id='id_mo_car_sub"+row+"' onchange='select_price_stock("+row+")'><option value=''>--กรุณาเลือกรุ่นรถย่อย--</option></select></td>";
html_code+="<td class='td-mobile' data-label='สีรถ'><select name='id_car_color[]' id='id_car_color"+row+"' style='width:70%;' onchange='select_price_stock("+row+");' >";
html_code+="<option value=''>--กรุณาเลือกสีรถ--</option>";
<?php
$select_color_sql='SELECT * FROM tb_color WHERE id_color NOT IN("99")';
$select_color_query=mysql_query($select_color_sql,$cndb1);
while($select_color_array=mysql_fetch_Array($select_color_query))
{ ?>
html_code+="<option value='<?php echo $select_color_array['id_color']; ?>'><?php echo $select_color_array['color_name']; ?></option>";
<?php } ?>
html_code+="</select></td>";
html_code+="<td class='td-mobile' data-label='ปีรถ' class='span10'><select name='car_regis_year[]' id='car_regis_year"+row+"' style='width:70%;'>";
html_code+="<option value=''>--กรุณาเลือกปีจดทะเบียน--</option>";
<?php
$year_now=date('Y');
$year_while=$year_now-100;
for($i=$year_now;$i>=$year_while;$i--)
{ ?>
html_code+="<option value='<?php echo $i; ?>'><?php echo $i; ?></option>";
<?php } ?>
html_code+="</select></td>";
html_code+="<td class='td-mobile' data-label='เลขตัวเครื่อง' class='span10'><input type='text' style='width:35%;' name='car_motor1[]' id='car_motor1"+row+"'>-<input type='text' style='width:35%;' name='car_motor2[]' id='car_motor2"+row+"'></td>";
html_code+="<td class='td-mobile' data-label='เลขตัวถัง' class='span10'><input type='text' style='width:40%;' name='car_body1[]' id='car_body1"+row+"'><input type='text' style='width:40%;' name='car_body2[]' id='car_body2"+row+"'></td>";
html_code+="<td class='td-mobile' data-label='ราคารถ'><input type='text' style='width:70%;' name='car_price[]' id='car_price"+row+"'></td>";
html_code+="<td class='td-mobile' data-label='ลบ'><a type='button' class='btn btn-small btn-danger' onclick='delete_row("+row+");'>ลบรายการ</a></td>";
html_code+="</tr>";
	$("#html_quotation").append(html_code);
	row++;
	max++;
}
function delete_row(num)
{
	$("#row"+num).remove();
	max--;
	if(max<=0)
	{
		add_row();
	}
}
add_row();
function data_br_car(row)
{
	$("#id_mo_car_sub"+row).html("<option value=''>--กรุณาเลือกรุ่นรถย่อย--</option>");
	$.post("ajax/ajax_my_stock_mo_car.php",{br_id:$("#id_br_car"+row).val()},function(data){$("#id_mo_car"+row).html(data);});
}
//รุ่นย่อย
function data_mo_car(row)
{
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
</script>