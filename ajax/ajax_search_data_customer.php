<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$type=$_POST['type_customer'];
$key=$_POST['key_customer'];
if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$sql="";

}
else
{
	$sql=" AND tb_my_car.login = '".$_SESSION["strUser"]."' ";

}
$select_data_sql="SELECT *,tb_my_car.id_my,tb_my_car.name,tb_my_car.last,tb_tumbon.name As t_name,tb_amphur.name As a_name,tb_province.name As p_name,tb_tumbon.id As t_id,tb_amphur.id As a_id,tb_province.id As p_id,seller
FROM tb_my_car
LEFT JOIN tb_tumbon ON (tb_my_car.id_tumbon = tb_tumbon.id)
LEFT JOIN tb_amphur ON (tb_my_car.id_amphur = tb_amphur.id)
LEFT JOIN tb_province ON (tb_my_car.id_province = tb_province.id)
WHERE tb_my_car.id_stock = '0' ".$sql." AND ".$type." LIKE '%".$key."%'";
//echo $select_data_sql;
$select_data_query=mysql_query($select_data_sql,$cndb1);
?>
<style>
.width_search1
{
	 display: inline-block;
	width: 120px;
}
.width_search2
{
	 display: inline-block;
	width: 120px;
}
.title_hide1 {
        display:block;
    }
.title_hide2 {
        display:none;
    }
@media screen and (max-width: 970px) {
    .title_hide1 {
        display:none;
    }
	.title_hide2 {
        display:block;
    }
}
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
<table border='0' style='position:relative; width:70%;' class="table-mobile table table-striped table-bordered" >
  <thead class='thead-mobile'>
<tr align="center"  class='tr-mobile' style='background-color:#87CBFF !important;font-size:14px;text-align:center; color:#fff; '>
<th class='th-mobile' scope="col" style='padding:12px;'>ชื่อลูกค้า</th>
<th class='th-mobile' scope="col" style='padding:12px;'>เบอร์มือถือ</th>
<th class='th-mobile' scope="col" style='padding:12px;'>เบอร์บ้าน</th>
<th class='th-mobile' scope="col" style='padding:12px;'>เบอร์ที่ทำงาน</th>
<th class='th-mobile' scope="col" style='padding:12px;'>ID_Line</th>
<th class='th-mobile' scope="col" style='padding:12px;'>Facebook</th>
<th class='th-mobile' scope="col" style='padding:12px;'>แหล่งที่มา</th>
<th class='th-mobile' scope="col" style='padding:12px;'>เลือกข้อมูล</th>
</tr>
</thead>
<?php
$n=0;
while($select_data_array=mysql_fetch_array($select_data_query))
{ $n++; $data_text=""; ?>
<tr class='tr-mobile'>
<td class='td-mobile' data-label="วันเวลาบันทึก"><?php echo $select_data_array['title'].$select_data_array['name']." ".$select_data_array['last']; ?></td>
<td class='td-mobile' data-label="เบอร์มือถือ"><?php if(!empty($select_data_array['tel_mobile1'])){echo $select_data_array['tel_mobile1'];}else{echo "-";} ?></td>
<td class='td-mobile' data-label="เบอร์บ้าน"><?php if(!empty($select_data_array['tel_home'])){echo $select_data_array['tel_home'];}else{echo "-";} ?></td>
<td class='td-mobile' data-label="เบอร์ที่ทำงาน"><?php if(!empty($select_data_array['tel_office'])){echo $select_data_array['tel_office']; }else{echo "-";}?></td>
<td class='td-mobile' data-label="ID Line"><?php if(!empty($select_data_array['id_line'])){echo $select_data_array['id_line']; }else{echo "-";}?></td>
<td class='td-mobile' data-label="Facebook"><?php if(!empty($select_data_array['facebook'])){echo $select_data_array['facebook']; }else{echo "-";}?></td>
<td class='td-mobile' data-label="แหล่งที่มา"><?php if(!empty($select_data_array['source'])){echo $select_data_array['source']; }else{echo "-";}?></td>

<?php
if($select_data_array['name']!='')
{
	$data_text="ข้อมูลลูกค้าของ ".$select_data_array['title'].$select_data_array['name']." ".$select_data_array['last'];
}
else
{
	$data_text="";
}
$data_value="";
$data_value.=$select_data_array['title']."|";
$data_value.=$select_data_array['name']."|";
$data_value.=$select_data_array['last']."|";
$data_value.=$select_data_array['add']."|";
$data_value.=$select_data_array['group']."|";
$data_value.=$select_data_array['home']."|";
$data_value.=$select_data_array['lane']."|";
$data_value.=$select_data_array['road']."|";
$data_value.=$select_data_array['p_id']."|".$select_data_array['p_name']."|";
$data_value.=$select_data_array['a_id']."|".$select_data_array['a_name']."|";
$data_value.=$select_data_array['t_id']."|".$select_data_array['t_name']."|";
$data_value.=$select_data_array['postal']."|";
$data_value.=$select_data_array['job']."|";
$data_value.=$select_data_array['id_card']."|";
$data_value.=$select_data_array['tel_mobile1']."|";
$data_value.=$select_data_array['tel_mobile2']."|";
$data_value.=$select_data_array['tel_mobile3']."|";
$data_value.=$select_data_array['tel_office']."|";
$data_value.=$select_data_array['tel_home']."|";
$data_value.=$select_data_array['id_line']."|";
$data_value.=$select_data_array['facebook']."|";
$data_value.=$select_data_array['source']."|";
$data_value.=$select_data_array['seller'];
?>
<td class='td-mobile' data-label="คลิกเพื่อเลือกดู"><a type='button' class='btn btn-small btn-info' data-dismiss="modal" onclick='select_customer_modal("<?php echo $select_data_array['id_my']; ?>","<?php echo $data_text; ?>","<?php echo $data_value; ?>")'>เลือก</a></td>

</tr>
<?php } ?>
</table>
