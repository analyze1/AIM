<?php  
session_start();
header('Content-Type: text/html; charset=utf-8');
header("Content-Disposition: attachment;filename=".date("d-m-Y").".xls");
header("Content-Type = application/download");
header("Content-Transfer-Encoding: binary");
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header("Expires: 0");  

include "check-ses.php";
include "../../inc/connectdbs.pdo.php"; 

$query = "SELECT ";
$query .= "data.id,";
$query .= "data.doc_type,";
$query .= "data.login, "; // รหัสผู้แจ้ง
$query .= "data.com_data, "; // รหัสผู้แจ้ง
$query .= "tb_customer.sub as branch, "; // สาขา
$query .= "tb_customer.contact, "; // ชื่อผู้แจ้ง  contact
$query .= "data.send_date,   "; // วันที่แจ้ง
$query .= "data.name_inform, "; // รหัสผู้แจ้ง
$query .= "data.id_data, "; // เลขที่รับแจ้ง

$query .= "data.start_date, "; // วันที่คุ้มครอง
$query .= "data.end_date, "; // วันที่สิ้นสุด
$query .= "data.name_gain, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.send_req, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.send_req2, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.send_cancel, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.my4ib_check, "; // วิริยะปากเกร็ด
$query .= "data.com_data, "; // วิริยะปากเกร็ด
$query .= "insuree.title, "; // คำนำหน้า ชื่อผู้เอาประกัน
$query .= "insuree.name,  "; // ชื่อผู้เอาประกัน
$query .= "insuree.last, "; // นามสกุลผู้เอาประกัน
$query .= "insuree.add, "; // บ้านเลขที่
$query .= "insuree.group, "; // หมู่
$query .= "insuree.town, "; //อาคาร/หมู่บ้าน
$query .= "insuree.lane, "; // ซอย
$query .= "insuree.road, "; // ถนน
$query .= "insuree.tumbon, "; // ตำบล คีย์
$query .= "insuree.amphur, "; // อำเภอ คีย์
$query .= "insuree.province, "; // จังหวัด คีย์
$query .= "insuree.postal, "; // รหัสไปรษณีย์
$query .= "insuree.career, "; // แยกใบเสร็จ
$query .= "insuree.email, "; // แยกใบเสร็จ
$query .= "insuree.tel_mobi, "; // แยกใบเสร็จ

$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
$query .= "detail.mo_car, "; // ยี่ห้อรถ
$query .= "tb_mo_car.name as mo_name, ";

$query .= "detail.car_color, "; // สีรถ
$query .= "detail.car_regis, "; // ทะเบียนรถ
$query .= "detail.car_regis_text, "; // ทะเบียนรถ
$query .= "detail.car_body, "; // เลขตัวถัง
$query .= "detail.regis_date, "; // ปีที่จดทะเบียน
$query .= "detail.n_motor, "; // เลขเครื่อง
$query .= "detail.equit, ";
$query .= "detail.car_detail, ";
$query .= "detail.cat_car, ";

$query .= "detail.product, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product1, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product2, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด  
$query .= "detail.product3, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product4, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product5, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product6, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product7, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product8, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product9, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด  
$query .= "detail.product10, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product11, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product12, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product13, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product14, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.price_total, "; // ราคาทุนอุปกรณ์ตกแต่งเพิ่มเติม
$query .= "detail.add_price, "; // ราคาทุนอุปกรณ์ตกแต่งเพิ่มเติม

$query .= "req.Req_Status, "; //สถานะการสลักหลัง
$query .= "req.Req_Date, ";
$query .= "req.EditTime, ";
$query .= "req.EditTime_StartDate, ";
$query .= "req.EditTime_EndDate, ";
$query .= "req.EditHr, ";
$query .= "req.EditHr_Detail, ";
$query .= "req.EditAct, ";
$query .= "req.EditAct_id, ";
$query .= "req.EditCar, ";
$query .= "req.Edit_CarBody, ";
$query .= "req.Edit_Nmotor, ";
$query .= "req.Edit_CarColor, ";
$query .= "req.EditCustomer, ";
$query .= "req.Cus_title, ";
$query .= "req.Cus_name, ";
$query .= "req.Cus_last, ";
$query .= "req.Cus_add, ";
$query .= "req.Cus_group, ";
$query .= "req.Cus_town, ";
$query .= "req.Cus_lane, ";
$query .= "req.Cus_road, ";
$query .= "req.Cus_tumbon, ";
$query .= "req.Cus_amphur, ";
$query .= "req.Cus_postal, ";
$query .= "req.EditCost, ";
$query .= "req.EditcostCost, ";
$query .= "req.EditProduct, ";
$query .= "req.Product as ReqProduct, ";
$query .= "req.TotalProduct, ";
$query .= "req.CostProduct, ";

$query .= "data.updated, "; // สลักหลัง
$query .= "protect.costCost,"; // ทุนประกันภัย
$query .= "data.send_req, "; // สลักหลัง
$query .= "data.send_req2, "; // สลักหลัง

$query .= "tb_cost.cost, ";
$query .= "tb_cost.pre, ";
$query .= "tb_cost.net ";

$query .= "FROM data ";
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
$query .= "INNER JOIN req ON (data.id_data = req.id_data) ";
$query .= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
$query .= "INNER JOIN tb_cost ON (tb_cost.id = protect.costCost) ";
$query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
$query .= "INNER JOIN tb_customer ON (tb_customer.user = data.login) ";

$query .= "WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y'";  // data.login = $xuser

$D = date('d');
$M = date('m');
$Y = date('Y');
$query .= "AND YEAR(data.send_date) = '$Y' AND MONTH(data.send_date) = '$M' AND DAY(data.send_date) = '$D'";
$query .= "ORDER BY data.send_date DESC  ";  //ASC
$objQuery = mysql_query($query) or die ("Error Query [".$query."]");
//$row = mysql_fetch_array($objQuery);

$sqlMORE = "SELECT * FROM tb_acc";
$objQueryMORE = mysql_query($sqlMORE) or die ("Error Query [".$sqlMORE."]");
$costOb = array();
while($rowCost = mysql_fetch_array($objQueryMORE)){
	$costOb['name'][$rowCost['id']] = $rowCost['name'];
	$costOb['price'][$rowCost['id']] = $rowCost['price'];
	$costOb['price2'][$rowCost['id']] = $rowCost['price2'];
}
$sqlMOREname = "SELECT * FROM tb_acc_new";
$objQueryMOREname = mysql_query($sqlMOREname) or die ("Error Query [".$sqlMOREname."]");
$costObname = array();
while($rowCostname = mysql_fetch_array($objQueryMOREname)){
	$costObname['name']['0'.$rowCostname['idcar']][$rowCostname['id']] = $rowCostname['name'];
}


?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>

<div><table width="99%" border="1" cellspacing="0" cellpadding="0" class="tblpreview">
  <tr>
    <th width="75" bgcolor="#000066"><span class="style1">วันที่แจ้ง</span></th>
   <th width="150" height="30" bgcolor="#000066"><span class="style1">เลขที่รับแจ้ง</span></th>
	 <th width="200" bgcolor="#000066"><span class="style1">ชื่อผู้เอาประกัน</span></th>
    <th width="100" bgcolor="#000066"><span class="style1">วันที่คุ้มครอง</span></th>
    <th width="90" bgcolor="#000066"><span class="style1">รุ่นรถ</span></th>
    <th width="150" bgcolor="#000066"><span class="style1">เลขตัวถัง</span></th>
    <th width="100" bgcolor="#000066"><span class="style1">ทุนประกันภัย</span></th>
    <th width="100" bgcolor="#000066"><span class="style1">เบี้ยสุทธิ</span></th>
    <th width="100" bgcolor="#000066"><span class="style1">เบี้ยรวม</span></th>
    <th width="200" bgcolor="#000066"><span class="style1">อุปกรณ์เพิ่มเติม</span></th>
    <th width="100" bgcolor="#000066"><span class="style1">เพิ่มเบี้ย</span></th>
  </tr>
   <? 
  $color = "";
  while($row = mysql_fetch_array($objQuery)) { 
  ?>
	  <tr style="width:auto;" height="30" align="center">
       <td align="left"><div align="center"><?=date("d/m/Y",strtotime($row['send_date']))?></div></td>
        <td><?=$row['id_data']?></td>		
		<td><div align="left">
		  <?=$row['title']." ".$row['name']." ".$row['last']?>
		</div>	    </td>
		<td><?=date("d/m/Y",strtotime($row['start_date']))?></td>
        <td><?=$row['mo_name']?></td>
        <td><?=$row['car_body']?></td>
        <td>
          <div align="left">
            <?=$row['cost']?>
          </div></td>
        <td><div align="right">
          <?=$row['pre']?>
        </div></td>
        <td><div align="right">
          <?=$row['net']?>
        </div>        </td>
        <td><div align="left">
          <? 
			if($row['EditProduct'] == 'Y'){
				$i=0;
				$product = "product";
				$exitNum = explode("|",$row['ReqProduct']);
				for($i=0;$i<count($exitNum);$i++){
					$exitSplit = explode(",",$exitNum[$i]);
					echo $costObname['name'][$row['cat_car']][$exitSplit[0]].' ';
					echo number_format($costOb['name'][$exitSplit[1]],0).' ';
				}
			}else if($row['equit']=='Y' and $row['car_detail']=='0')
				{
				$i=0;
				$product = "product";
					while ($i<=14){
						if($i==0)
						{
						if($row[$product]!='0'){
						echo $row[$product]." ";
						}
						}
						else{
						if($row[$product.$i]!='0'){
						echo $row[$product.$i]." ";
						}
						}
						$i++;
					}
				}
				else if($row['equit']=='Y' and $row['car_detail']!='0')
				{
				$i=0;
				$product = "product";
				$exitNum = explode("|",$row['car_detail']);
				for($i=0;$i<count($exitNum);$i++)
				{
					$exitSplit = explode(",",$exitNum[$i]);
					echo $costObname['name'][$row['cat_car']][$exitSplit[0]].' ';
					echo number_format($costOb['name'][$exitSplit[1]],0).' ';
				}
		}else{
			echo "ไม่มี";
		}
		?>
        </div></td>
        <td>
		  <div align="right">
		    <?
			if($row['EditProduct'] == 'Y'){
				echo number_format($row['CostProduct'],2);
			}else{
				echo number_format($row['add_price'],2);
			}
		
		?>        
        </div></td>
    </tr>
      <? } ?>
</table>
<?
mysql_close();
exit(); 	
?>
</div>