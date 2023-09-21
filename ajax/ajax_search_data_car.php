<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
$type=$_POST['type_data'];
$key=$_POST['key_data'];
if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$sql="";

}
else
{
	$sql=" AND tb_stock_car.login = '".$_SESSION["strUser"]."' ";

}
$select_data_sql="SELECT
tb_stock_car.id_stock
,tb_stock_car.car_body
,tb_stock_car.car_motor
,tb_br_car.name As br_name
,tb_mo_car.name As mo_name
,tb_mo_car_sub.name As sub_name
,tb_stock_car.startdate_payment
,tb_stock_car.enddate_payment
,tb_stock_car.date_sale
,tb_stock_car.car_price
FROM tb_stock_car 
LEFT JOIN tb_br_car ON tb_stock_car.id_br_car = tb_br_car.id
LEFT JOIN tb_mo_car ON tb_stock_car.id_mo_car = tb_mo_car.id
LEFT JOIN tb_mo_car_sub ON tb_stock_car.id_mo_car_sub = tb_mo_car_sub.id
WHERE tb_stock_car.car_status != 'Y' AND ".$type." LIKE '%".$key."%' ".$sql." ORDER BY date_system DESC";
//echo $select_data_sql;
$select_data_query=mysql_query($select_data_sql,$cndb1);
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
.title_hide1 {
        display:block;
    }
.title_hide2 {
        display:none;
    }
.width_search_car1
{
	 display: inline-block;
	width: 130px;
}
.width_search_car2
{
	 display: inline-block;
	width: 150px;
}
@media screen and (max-width: 970px) {
    .title_hide1 {
        display:none;
    }
	.title_hide2 {
        display:block;
    }
}
</style>
<table  border='0' style='position:relative; width:75%;' class="table-mobile table table-striped table-bordered" >
<thead class='thead-mobile'>
<tr align="center"  class='tr-mobile' style='background-color:#87CBFF !important;font-size:14px;text-align:center; color:#fff; '>

<th class='th-mobile'>ยี่ห้อรถ</th>
<th class='th-mobile'>รุ่นรถ</th>
<th class='th-mobile'>รุ่นรถย่อย</th>
<th class='th-mobile'>เลขตัวถัง</th>
<th class='th-mobile'>เลขตัวเครื่อง</th>
<th class='th-mobile'>ราคารถ</th>
<th class='th-mobile'>เลือกข้อมูล</th>
</thead>
</tr>
<?php
$n=0;
while($select_data_array=mysql_fetch_array($select_data_query))
{ $n++; $data_text=""; ?>
<tr class='tr-mobile'>
<td class='td-mobile' data-label="ยี่ห้อรถ"><?php echo $select_data_array['br_name']; $data_text.="<b>ยี่ห้อ : ".$select_data_array['br_name']."</b>&nbsp;&nbsp;&nbsp;"; ?></td>
<td class='td-mobile' data-label="รุ่นรถ"><?php echo $select_data_array['mo_name'];  $data_text.="<b>รุ่นรถ : ".$select_data_array['mo_name']."</b>&nbsp;&nbsp;&nbsp;"; ?></td>
<td class='td-mobile' data-label="รุ่นรถย่อย"><?php echo $select_data_array['sub_name'];  $data_text.="<b>รุ่นรถย่อย : ".$select_data_array['sub_name']."</b>&nbsp;&nbsp;&nbsp;"; ?></td>
<td class='td-mobile' data-label="เลขตัวถัง"><?php echo $select_data_array['car_body'];  $data_text.="<b>เลขตัวถัง : ".$select_data_array['car_body']."</b>&nbsp;&nbsp;&nbsp;"; ?></td>
<td class='td-mobile' data-label="เลขตัวเครื่อง"><?php echo $select_data_array['car_motor'];  $data_text.="<b>เลขตัวเครื่อง : ".$select_data_array['car_motor']."</b>&nbsp;&nbsp;&nbsp;"; ?></td>
<td class='td-mobile' data-label="ราคารถ"><?php echo number_format($select_data_array['car_price'],2,'.',','); $data_text.="<b>วันเริ่มชำระ : ".$select_data_array['startdate_payment']."</b>&nbsp;&nbsp;&nbsp;<b>วันสิ้นสุดชำระ : ".$select_data_array['enddate_payment']."</b>&nbsp;&nbsp;&nbsp;<b>วันขายรถ : ".$select_data_array['date_sale']."</b>&nbsp;&nbsp;&nbsp;<b>ราคารถ : ".number_format($select_data_array['car_price'],2,'.',',')."</b>"; ?></td>
<td class='td-mobile' data-label="วันเวลาบันทึก"><a type='button' class='btn btn-small btn-info' data-dismiss="modal" onclick='select_car_modal("<?php echo $select_data_array['id_stock'];?>","<?php echo $data_text; ?>")'>เลือก</a></td>
</tr>
<?php } ?>
</table>
