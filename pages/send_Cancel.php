<?php 
include "../../inc/connectdbs.pdo.php"; 
include "check-ses.php"; 
?>

<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery.imask.js"></script>
        <script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
        <script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/req.js"></script>
<script src="js/detail_product.js" type="text/javascript"></script>
<?php 
$query = "SELECT ";
$query .= "data.id,";
$query .= "data.login, "; // รหัสผู้แจ้ง
$query .= "tb_customer.sub as branch, "; // สาขา
$query .= "tb_customer.contact, "; // สาขา
$query .= "data.send_date,   "; // วันที่แจ้ง
$query .= "data.id_data, "; // เลขที่รับแจ้ง
$query .= "data.start_date, "; // วันที่คุ้มครอง
$query .= "data.name_gain, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.com_data, "; // รหัสบริษัทประกันภัย
$query .= "act.p_act, ";
//////////////////////////////////////////
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

$query .= "tb_tumbon.name as tumbon_name, "; 
$query .= "tb_amphur.name as amphur_name, "; 
$query .= "tb_province.name as province_name, "; // จังหวัด

$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้

$query .= "detail.mo_car, "; // รหัสรุ่นรถ
$query .= "detail.car_color, "; // สีรถ
$query .= "detail.car_body, "; // เลขตัวถัง
$query .= "detail.n_motor, "; // เลขเครื่อง
$query .= "detail.gear," ; //เกียร์

$query .= "req.EditTime, ";
$query .= "req.EditTime_StartDate, ";
$query .= "req.EditAct, ";
$query .= "req.EditAct_id, ";
$query .= "req.EditHr, ";
$query .= "req.EditHr_Detail, ";
$query .= "req.EditCar, ";
$query .= "req.Edit_CarBody, ";
$query .= "req.Edit_Nmotor, ";
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
$query .= "req.Cus_province, ";
$query .= "req.Cus_postal, ";
$query .= "req.EditCost, ";
$query .= "req.EditcostCost, ";

$query .= "protect.costCost,"; // ทุนประกันภัย
$query .= "tb_cost.pre, ";
$query .= "tb_cost.stamp, ";
$query .= "tb_cost.tax, ";
$query .= "tb_cost.net ";

$query .= "FROM data ";
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "INNER JOIN act ON (data.id_data  = act.id_data) ";
$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
$query .= "INNER JOIN tb_cost ON (tb_cost.id = protect.costCost) ";

$query .= "INNER JOIN req ON (req.id_data = data.id_data)  ";

$query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";

$query .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
$query .= "INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
$query .= "INNER JOIN tb_province ON (tb_province.id = insuree.province) ";
$query .= "INNER JOIN tb_customer ON (tb_customer.user = data.login) ";


$query .= "WHERE data.id_data='".$_GET['IDDATA']."';";
$objQuery = mysql_query($query) or die ("Error Query [".$query."]");
$row = mysql_fetch_array($objQuery);



$car_id = $row['car_id'];
$id_data_rec = $arrdata[0]['id_data'];
$arr_car_id = str_split($car_id);
?>
<form enctype="multipart/form-data" method="post" name="req" id="req">
<div align="center" id="req" style="margin-left:auto; margin-right:auto; width:100%">
  <img src="i/VIBM.gif" width="400" height="79" /> <br />
  <br />
 <div align="center" class="style1"><font color="#FF0000">ยกเลิกกรมธรรม์ และ พ.ร.บ.</font><br />
 </div> 
 <table width="700" border="0" cellpadding="5" cellspacing="1" style="font-size:14px;">
  <tr>
    <td width="63%" align="left" valign="bottom" class="style11">&nbsp;</td>
    <td width="39%" align="left" valign="bottom" >&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="bottom"class="style11"><span>สาขา : (<?=$row['login']?>)<?=$row['branch']?></span></td>
    <td align="left" valign="bottom" ><div align="right">
      <input name="req_dmy" type="hidden" id="req_dmy" value="<? echo date('Y-m-d H:i:s'); ?>"/>
      <input name="req_date" type="hidden" id="req_date" value="<? echo date('d/m/Y'); ?>"/>
    </div></td>
  </tr>
  <tr>
    <td align="left" valign="bottom" class="style11">
    เลขที่รับแจ้ง : <?=$row['id_data']?>
    <input name="Edituser_C" type="hidden" id="Edituser_C" value="<?=$row['login'];?>"/>    
    <input name="Editp_act3" type="hidden" id="Editp_act3" size="7" maxlength="7" value="<? if(substr($row['EditAct_id'],12,7) !=''){echo substr($row['EditAct_id'],12,7);}else{echo substr($row['p_act'],12,7);}?>"  style="width:80px;"/>
    <input name="EditId_data" type="hidden" id="EditId_data" value="<?=$row['id_data']?>" />
    <input name="Edittype" type="hidden" id="Edittype" value="<?=substr($row['car_id'],0,1);?>"/>      </td>
    <td align="left" >วันที่แจ้งประกัน : <input name="req_SendDate" id="req_SendDate" style="border:none; width:100px;"  value="<? echo date('d/m/Y', strtotime($row['send_date'])); ?>" size="8" /></td>
  </tr>
  
  <tr>
    <td colspan="2" align="left" ><strong>
      <input name="EditCancel" type="hidden" id="EditCancel" value="Y"/>
      <span class="style1"><font color="#FF0000">ยกเลิกกรมธรรม์ประกันภัย และ เลข พ.ร.บ.</font></br>
		</span></strong><span class="style1"></span>
        </span>
		<div align="left" class="style7" id="ShowCancel" style="margin-left:43px; margin-top:10px;">
      	 	<span class="style11">รายละเอียดการยกเลิก:</span><br />
       	  <textarea name="Cancel_Detail" id="Cancel_Detail" rows="5" style="width:600px;" ></textarea>
		  <font color='red'>*</font>
    	</div>	</td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    </tr>
	  <tr>
        <td align="center" colspan="4">
            <button class="btn btn-large btn-primary" type="button" id="Save_reqCancel" name="Save_reqCancel"><i class="icon-upload"></i>บันทึกข้อมูล</button>
            <!--<button class="btn btn-large btn-danger" type="button" id="Bclose" name="Bclose"><i class="icon-remove-circle"></i>ออกจากเมนูยกเลิก</button>-->
    </tr>
  </table>
     
  </td>
  </tr>
</table>


</div>
</form>
<? mysql_close(); ?>