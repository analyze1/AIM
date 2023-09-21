<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
mysql_select_db($db1,$cndb1);
if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
	$sql="";

}
else
{
	$sql=" AND tb_my_car.login = '".$_SESSION["strUser"]."' ";

}
$data=$_POST['search_data'];
$key=$_POST['search_key'];
$tb_my_car_sql="SELECT
tb_my_car.title,
tb_my_car.name,
tb_my_car.last,
tb_stock_car.car_price,
tb_my_car.id_my,
tb_mo_car_sub.name As s_name,
tb_mo_car.name As m_name,
tb_my_car.date_my_car
FROM tb_my_car
LEFT JOIN tb_stock_car ON (tb_my_car.id_stock = tb_stock_car.id_stock)
LEFT JOIN tb_mo_car ON (tb_stock_car.id_mo_car = tb_mo_car.id) 
LEFT JOIN tb_mo_car_sub ON (tb_stock_car.id_mo_car_sub = tb_mo_car_sub.id) 
WHERE tb_my_car.id_stock !='0' ".$sql." ORDER BY date_my_car DESC LIMIT 0,10";
//echo $tb_my_car_sql;
$tb_my_car_query=mysql_query($tb_my_car_sql,$cndb1);

 ?>
 <style type='text/css'>
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
    margin: -40px 0 0 -40%;
    }
}
@media screen and (min-width: 1250px) {
    .width_attack {
        width: 60%;
		
    }
}
 </style>
 <table border='1' class='table-mobile table table-striped table-bordered' id='data_my_car' width='100%'>
  <!--<caption>Statement Summary</caption>-->
  <thead class='thead-mobile'>
    <tr class='tr-mobile' style="font-size:14px;text-align:center; color:#fff; background-color:#2E3275 !important;">
	<th class='th-mobile' scope="col" style='padding:12px;'>วันเวลาบันทึก</th>
	<th class='th-mobile' scope="col" style='padding:12px;'>รุ่นรถ</th>
      <th class='th-mobile' scope="col" style='padding:12px;'>รุ่นรถย่อย (modal)</th>
      <th class='th-mobile' scope="col" style='padding:12px;'>ชื่อผู้จอง</th>
      <th class='th-mobile' scope="col" style='padding:12px;'>ราคารถ</th>
	  <th class='th-mobile' scope="col" style='padding:12px;'>ดูรายละเอียด</th>
    </tr>
  </thead>
  <tbody>
  <?php 
  while($tb_my_car_array=mysql_fetch_array($tb_my_car_query))
  { ?>
    <tr class='tr-mobile'>
      <td class='td-mobile' data-label="วันเวลาบันทึก"><?php echo $tb_my_car_array['date_my_car'];?></td>
	  <td class='td-mobile' data-label="รุ่นรถ"><?php echo $tb_my_car_array['m_name'];?></td>
      <td class='td-mobile' data-label="รุ่นรถย่อย (modal)"><?php echo $tb_my_car_array['s_name'];?></td>
      <td class='td-mobile' data-label="ชื่อผู้จอง"><?php echo $name_customer=$tb_my_car_array['title'].$tb_my_car_array['name']." ".$tb_my_car_array['last'];?></td>
      <td class='td-mobile' data-label="ราคารถ"><?php echo number_format($tb_my_car_array['car_price'],2,'.',',');?></td>
	  <td class='td-mobile' data-label="ดูรายละเอียด"><button class='btn btn-small btn-success' data-toggle='modal' data-target='#detail_customer1' onclick='detail_my_car1("<?php echo $tb_my_car_array['id_my'];?>","<?php echo $name_customer;?>")'>ดูรายละเอียด</button></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
 <div class="modal fade width_attack" id="detail_customer1" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><font color='BLACK' id='name_customer'></font></h4>
        </div>
        <div class="modal-body">
		  <div class='span12' id='form_detail_customer_html'>
		  </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <script type='text/javascript'>
  $("#data_my_car").dataTable();
  function detail_my_car1(id,name)
  {
	  $("#name_customer").html("รายละเอียดลูกค้า "+name);
	  $.post("ajax/ajax_form_detail_customer.php",{id_my:id},function(data){$("#form_detail_customer_html").html(data);});
  }
  </script>