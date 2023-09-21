<?php 
include "../inc/connectdbs.inc.php"; 
include "check-ses.php"; 
mysql_select_db($db1,$cndb1);
$CHECKCHANGE = $_POST['Edittype'];
?>
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery.imask.js"></script>
        <script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
        <script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />
<script language="javascript">
/*
$( document ).ready(function() {

$("#req_date").datepicker({ 
	dateFormat: "dd/mm/yy" ,
}).val();		
});
*/
</script>
<style type="text/css">
<!--
.specify-other {display: none;}
.tbl_send_req { background-color:#999999; }
.tbl_send_req td.title {
	font-size: 24px;
	color: #000000;
	text-align:center;
	color:#000000

}
.tbl_send_req td.sub_title {
	font-size: 12px;
	background-color:#CCC;
	color: #000000;
}
.tbl_send_req td { font-size:12px; height:25px; padding:3px; background-color:#FFFFFF; }
.valid_send_req { color:#F00; padding-top:3px; padding-bottom:3px; }
.re tr{
	height:40px
}
#req table td{
	padding-left:5px;
}
#req table tr{
	height:30px;
}
.style1 {
	color: #000000;

}
.style7 {color: #000000; }
.style10 {
	font-size: 13px;
	color: #000000;
}
.style11 {
	font-size: 13px;
	color: #000000;
}
.style14 {font-size: 14px}
.style15 {font-size: 13px}
-->
</style>

<script type="text/javascript" src="js/req.js"></script>

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
$query .= "insuree.icard, "; // บัตรประชาชน
$query .= "insuree.person, "; 
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
$query .= "insuree.career, "; // ใบเสร็จ
$query .= "insuree.SendAdd," ; //
$query .= "insuree.status_SendAdd," ; //
$query .= "tb_tumbon.name as tumbon_name, "; 
$query .= "tb_amphur.name as amphur_name, "; 
$query .= "tb_province.name as province_name, "; // จังหวัด

$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้

$query .= "detail.mo_car, "; // รหัสรุ่นรถ
$query .= "detail.mo_sub, "; // รหัสรุ่นรถย่อย
$query .= "detail.car_color, "; // สีรถ
$query .= "detail.car_body, "; // เลขตัวถัง
$query .= "detail.n_motor, "; // เลขเครื่อง
$query .= "detail.gear," ; //เกียร์
$query .= "detail.cat_car," ; //
$query .= "detail.car_detail," ; //
$query .= "detail.car_cat_acc," ; //
$query .= "detail.car_cat_acc_total," ; //
$query .= "detail.code_addon," ; //
$query .= "detail.code_addon_id," ; //
$query .= "detail.price_total," ; //
$query .= "req.code_addon As req_code_addon," ; //
$query .= "req.code_addon_id As req_code_addon_id," ; //
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
$query .= "req.EditPerson, ";
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
$query .= "req.EditProduct, ";
$query .= "req.Product, ";
$query .= "req.EditAddon, ";
$query .= "smt.pre AS smtPre, ";
$query .= "smt.net AS smtNet, ";

$query .= "tb_mo_car.name AS mo_name, ";

$query .= "protect.costCost,"; // ทุนประกันภัย
$query .= "tb_cost.pre, ";
$query .= "tb_cost.stamp, ";
$query .= "tb_cost.tax, ";
$query .= "tb_cost.net, ";
$query .= "tb_cost.cost ";

$query .= "FROM data ";
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "INNER JOIN act ON (data.id_data  = act.id_data) ";
$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
$query .= "INNER JOIN tb_cost ON (tb_cost.id = protect.costCost) ";
$query .= "INNER JOIN smt ON (smt.id_cost = data.costCost) ";

$query .= "INNER JOIN req ON (req.id_data = data.id_data)  ";

$query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";

$query .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
$query .= "INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
$query .= "INNER JOIN tb_province ON (tb_province.id = insuree.province) ";
$query .= "INNER JOIN tb_customer ON (tb_customer.user = data.login) ";

$query .= "WHERE data.id_data='".$_GET['IDDATA']."';";
$objQuery = mysql_query($query,$cndb1) or die ("Error Query [".$query."]");
$row = mysql_fetch_array($objQuery);
//echo $query;
$sqlMORE = "SELECT * FROM tb_acc";
$objQueryMORE = mysql_query($sqlMORE,$cndb1) or die ("Error Query [".$sqlMORE."]");
$costOb = array();
while($rowCost = mysql_fetch_array($objQueryMORE))
{
	$costOb['name'][$rowCost['id']] = $rowCost['name'];
	$costOb['price'][$rowCost['id']] = $rowCost['price'];
	$costOb['price2'][$rowCost['id']] = $rowCost['price2'];
}

$sqlMOREname = "SELECT * FROM tb_acc_new";
$objQueryMOREname = mysql_query($sqlMOREname,$cndb1) or die ("Error Query [".$sqlMOREname."]");
$costObname = array();
while($rowCostname = mysql_fetch_array($objQueryMOREname))
{
	$costObname['name']['0'.$rowCostname['idcar']][$rowCostname['id']] = $rowCostname['name'];
}

$car_id = $row['car_id'];
$id_data_rec = $arrdata[0]['id_data'];
$arr_car_id = str_split($car_id);
?>
<form enctype="multipart/form-data" method="post" name="req" id="req">
<div align="center" id="req" style="margin-left:auto; margin-right:auto; width:100%">
  <img src="i/VIBM.gif" width="400" height="79" />
   </div> 
 <div align="center">
 <table width="80%" border="0" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" style="font-size:14px;">
  <tr>
    <td width="63%" align="left" valign="bottom" bgcolor="#FFFFFF" class="style11">&nbsp;</td>
    <td width="39%" align="left" valign="bottom" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="bottom" bgcolor="#FFFFFF" class="style11"><span>สาขา : (
        <?=$row['login']?>
		<input type='hidden' name='mo_car_sub' id='mo_car_sub' value='<?=$row['mo_sub']?>'>
)
<?=$row['branch']?>
    </span></td>
    <td align="left" valign="bottom" bgcolor="#FFFFFF"><div align="right">
      <input name="req_dmy" type="hidden" id="req_dmy" value="<? echo date('Y-m-d H:i:s'); ?>"/>
      <input name="req_date" type="hidden" id="req_date" value="<? echo date('d/m/Y'); ?>"/>
    </div></td>
  </tr>
  <tr>
    <td align="left" valign="bottom" bgcolor="#FFFFFF" class="style11">
    เลขที่รับแจ้ง : <?=$row['id_data']?>    
    <input name="EditId_data" type="hidden" id="EditId_data" value="<?=$row['id_data']?>" />
    <input name="Edittype" type="hidden" id="Edittype" value="<?=substr($row['car_id'],0,1);?>"/>
	<input name="Editcar_id" type="hidden" id="Editcar_id" value="<?=$row['car_id'];?>"/>
	<input name="Editmo" type="hidden" id="Editmo" value="<?=$row['mo_car'];?>"/>
    <input name="Edituser" type="hidden" id="Edituser" value="<?=$row['login'];?>"/>
	</td>
    <td align="left" valign="bottom"><div align="right"><span class="style11">วันที่แจ้งประกัน : </span><? echo date('d/m/Y', strtotime($row['send_date'])); ?>
    <input name="req_SendDate" type="hidden" id="req_SendDate"  value="<? echo date('d/m/Y', strtotime($row['send_date'])); ?>" size="8" />
    </div></td>
  </tr>
  
  <tr>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><span style="color: #000000"><strong>
      <input name="EditCar" style="margin-right:20px;" type="checkbox" value="Y" id="EditCar" />
แก้ไขข้อมูลรถยนต์
    </strong></span>
    	
    	<div align="left" class="style7" id="ShowEditCar" style="margin:10px 43px; display:none;">
    	  <table width="80%" border="0" cellspacing="0" cellpadding="5">
            <tr>
              <td width="60%"><span class="style10">เลขตัวถัง : </span>
                <input name="Edit_CarBody1" type="text" id="Edit_CarBody1" value="<? if(substr($row['Edit_CarBody'],0,9) != ''){ echo substr($row['Edit_CarBody'],0,9);}else{echo substr($row['car_body'],0,9); }?>" size="11" readonly="readonly" style="width:100px;" />
                <input name="Edit_CarBody2" type="text" id="Edit_CarBody2" value="<? if(substr($row['Edit_CarBody'],9,9) != ''){ echo substr($row['Edit_CarBody'],9,8);}else{echo substr($row['car_body'],9,8); }?>" size="10" maxlength="8" style="width:100px;" />
                </td>
              <td width="252"><div align="left"><span class="style10">สีรถ : </span>
                    <select name="Edit_CarColor" id="Edit_CarColor" style="width:auto;" >
                      <option value="<? if($row['Edit_CarColor'] !=''){echo $row['Edit_CarColor'];}else{echo $row['car_color'];}?>" selected="selected">
                      <?=$row['car_color']?>
                      </option>
                      <option value="เทา"> เทา </option>
        <option value="เขียว"> เขียว </option>
        <option value="น้ำเงิน"> น้ำเงิน </option>
        <option value="แดง"> แดง </option>
        <option value="ขาว">ขาว </option>
        <option value="น้ำตาล"> น้ำตาล </option>
        <option value="ดำ"> ดำ </option>
        <option value="ฟ้า"> ฟ้า </option>
        <option value="ส้ม">ส้ม</option>
        <option value="บรอนซ์">บรอนซ์</option>
        <option value="บรอนซ์เงิน">บรอนซ์เงิน</option>
        <option value="บรอนซ์ทอง">บรอนซ์ทอง</option>
        <option value="ส้มดำ">ส้มดำ</option>
		    <option value="เหลือง">เหลือง</option>
            <option value="ชมพู">ชมพู</option>
            <option value="ม่วง">ม่วง</option>
            <option value="ขาวมุก">ขาวมุก</option>
            <option value="เทาดำ">เทาดำ</option>
            <option value="ครีม">ครีม</option>
            <option value="ดำแดง">ดำแดง</option>
            <option value="ดำเหลือง">ดำเหลือง</option>
            <option value="แดงขาว">แดงขาว</option>
            <option value="เขียวดำ">เขียวดำ</option>
			<option value="นํ้าเงิน-ส้ม">นํ้าเงิน-ส้ม</option>
                    </select>
                    </span></div></td>
            </tr>
            <tr>
              <td><span class="style10">เลขเครื่อง :</span>
              	<? 
			  		if($row['mo_car'] == '1951' || $row['mo_car'] == '1964' || $row['mo_car'] == '1967' || $row['mo_car'] == '1968' || $row['mo_car'] == '1969' || $row['mo_car'] == '1960'){
				?>
                <input name="Edit_Nmotor1" type="text" id="Edit_Nmotor1" value="<? if(substr($row['Edit_Nmotor'],0,5) != '') { echo substr($row['Edit_Nmotor'],0,5); }else{ echo substr($row['n_motor'],0,5); }?>" size="8" readonly="readonly" style="width:100px;" />-
                <? }else{ ?>
                <input name="Edit_Nmotor1" type="text" id="Edit_Nmotor1" value="<? if(substr($row['Edit_Nmotor'],0,6) != '') { echo substr($row['Edit_Nmotor'],0,6); }else{ echo substr($row['n_motor'],0,6); }?>" size="8" readonly="readonly" style="width:100px;" />-
                <? } ?>
                <? 
			  		if($row['mo_car'] == '1098'){
				?>
                <input name="Edit_Nmotor2" type="text" id="Edit_Nmotor2" value="<? if(substr($row['Edit_Nmotor'],7,7) != '') { echo substr($row['Edit_Nmotor'],7,7); }else{ echo substr($row['n_motor'],7,7); }?>" size="8" maxlength="7" style="width:100px;" />                </td>
              	<? }else{ ?>
                <input name="Edit_Nmotor2" type="text" id="Edit_Nmotor2" value="<? if(substr($row['Edit_Nmotor'],7,7) != '') { echo substr($row['Edit_Nmotor'],6,7); }else{ echo substr($row['n_motor'],6,7); }?>" size="8" maxlength="7" style="width:100px;" />                </td>
                <? } ?>
              <td>&nbsp;</td>
            </tr>
          </table>
        </span></div>      </td>
    </tr>
  <tr>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><span style="color: #000000"><strong>
      <input name="EditProduct" id="EditProduct" style="margin-right:20px;" type="checkbox" value="Y" />
เพิ่มอุปกรณ์ตกแต่ง<? if($_SESSION["strUser"] == 'admin' && $row['mo_name'] == 'CARRY'){ ?> / <font color="#FF0000">สลักหลัง เปลี่ยนประเภทรถ อท.220/230</font><? } ?></strong></span>
	<div align="left" class="style7" id="ShowEditProduct" style="margin:10px 43px; display:none;">
  <table class="bg-in"  width="100%" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td colspan="4" width="100%">
            <?
            	// เช็คว่ามีไฟแนนซืเพิ่มทุนหรือไม่
				$num_check = 0;
				if($row['car_detail'] != '' && $row['car_detail'] != 'ไม่มี')
				{
					$car_detailCheck = explode("|",$row['car_detail']);
				}
				if($row['EditProduct'] == 'Y')
				{
					$car_detailCheck = explode("|",$row['Product']);
				}
				
				
				foreach ($car_detailCheck as $value)
				{
					$car_detailCheck_2 = explode(",",$value);
					if($car_detailCheck_2[0] != '31' && $car_detailCheck_2[0] != '32')
					{
						if($num_check == '0')
						{
							$new_detail = $car_detailCheck_2[0].','.$car_detailCheck_2[1];
						}
						else
						{
							$new_detail = $new_detail.'|'.$car_detailCheck_2[0].','.$car_detailCheck_2[1];
						}
						$num_check++;
					}
					else
					{
						$new_detail_2 = $car_detailCheck_2[0].','.$car_detailCheck_2[1];
					}
				}
			?>
            <input type="hidden" name="MOREAJAX" id="MOREAJAX" value="<?=$new_detail?>" />
            <input type="hidden" name="COUNTMORE" id="COUNTMORE" value="0" />
            <button class="btn btn btn-info" type="button" name="ADDTABLE" id="ADDTABLE" ><i class="icon-upload"></i>เพิ่มอุปกรณ์</button>
			<button class="btn btn btn-danger" type="button" name="moreclose" id="moreclose" ><i class="icon-download"></i>ลบอุปกรณ์</button>
             </td>
            </tr>
            <tbody id="MORE_ADD">
           </tbody>
        </table>
        <table height="50" width="100%" cellpadding="0" cellspacing="0">
        <tr  valign="middle" style="font-size:18px; color:red;" >
            <td width="1%">&nbsp;</td>
            <td width="30%" align="center">
            <textarea style="display:none;" name="acc" id="acc" cols="45" rows="5"></textarea>            </td>
            <td  align="center" width="20%"><span class="style14">ทุนรวม
			
                <input style="font-size:16px; width:100px;" name="price_acc_tun" value="0" id="price_acc_tun" type="text" class="warn"  readonly="readonly" />
              บาท
            </span></td>
            <td align="center" width="20%">
              <div align="right"><span class="style14">เบี้ยรวม
                <input style="font-size:16px; width:100px;"  name="price_acc_cost" value="0" id="price_acc_cost" type="text" class="warn" readonly="readonly"/>
              บาท              </span></div></td>
            </tr>
        </table>
        
	<? if($_SESSION["strUser"] == 'admin' && $row['mo_name'] == 'CARRY'){ ?>
    <table class="bg-in"  width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
    <td colspan="4" align="left" bgcolor="#CCCCCC"><span style="color: #000000"><strong>
      <input name="Edit_addAT" id="Edit_addAT" style="margin-right:20px;" type="checkbox" value="Y" /><font color="#FF0000">เปลี่ยนประเภทรถ อท. 220/230</font></strong></span>
        <div align="left" class="style7" id="ShowEdit_addAT" style="margin:10px 43px; display:none;">
  			<table class="bg-in"  width="100%" border="0" cellspacing="0" cellpadding="5">
          		<tr style='display:none;'>
                	<td width="10%">เบี้ยสุทธิ</td>
                	<td><input type="text" class="span2" style="text-align:right; color:#FF0000" value="<?=number_format($row['smtPre'],2);?>" readonly="readonly" /> บาท</td>
                </tr>
                <tr style='display:none;'>
                	<td>เบี้ยรวม</td>
                	<td><input type="text" class="span2" style="text-align:right; color:#FF0000" value="<?=number_format($row['smtNet'],2);?>" readonly="readonly" /> บาท</td>
                </tr>
				<tr>
				<td colspan="2">
				<?php
				$cost_tun=explode(' ',$row['cost']);
				$cost_total=str_replace(',','',$cost_tun['0'])+str_replace(',','',$row['price_total']);
				?>
				<input name="cost_addpre" id="cost_addpre"  type="hidden" value="<?=str_replace(',','',$cost_total);?>" >
				<input name="p_pre" id="p_pre" style="margin-left:20px;" type="checkbox" value="Y" onclick='cal_car_cat_acc();'> เบี้ยรวม
				<input name="b_pre" id="b_pre" style="margin-left:20px;" type="checkbox" value="Y" onclick='cal_car_cat_acc();'> เบี้ย พรบ.
				</td>
				</tr>
                <tr>
                	<td colspan="2">
						<div style='display:inline-block;width:100px;'>ประเภทรถ</div><select name="car_cat_acc" id="car_cat_acc" onchange='cal_car_cat_acc();'>
                        	<option value="" selected="selected">กรุณาเลือก</option>
                            <option value="220">220 (ป้ายฟ้า)</option>
                            <option value="230">230 (ป้ายเหลือง)</option>
                        </select><br>
						<div style='display:inline-block;width:100px;'>เบี้ยรวม</div><input type="text" name="p_pre_val" id="p_pre_val" style="text-align:right; color:#FF0000" value="<?=$row['car_cat_acc_pre'];?>" onkeyup='cal_acc_total();' > บาท<br>
						<div style='display:inline-block;width:100px;'>เบี้ย พรบ.</div><input type="text" name="b_pre_val" id="b_pre_val" style="text-align:right; color:#FF0000" value="<?=$row['car_cat_acc_prb'];?>" onkeyup='cal_acc_total();'> บาท<br>
                    	<div style='display:inline-block;width:100px;'>เพิ่มเบี้ย</div><input type="text" name="add_pre_at" id="add_pre_at" style="text-align:right;" value="<?=$row['car_cat_acc_total'];?>" readonly> บาท
                    </td>
                </tr>
        	</table>
        </div>
  	</td>
  </tr>
  </table>
  <? } ?>
    <? if($_SESSION["strUser"] == 'admin' && $row['car_id'] == '110'){ ?>
    <table class="bg-in"  width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
    <td colspan="4" align="left" bgcolor="#CCCCCC"><span style="color: #000000"><strong>
      <input name="Edit_addAT" id="Edit_addAT" style="margin-right:20px;" type="checkbox" value="Y" /><font color="#FF0000">เปลี่ยนประเภทรถ อท. 120</font></strong></span>
        <div align="left" class="style7" id="ShowEdit_addAT" style="margin:10px 43px; display:none;">
        <table class="bg-in"  width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr style='display:none;'>
                  <td width="10%">เบี้ยสุทธิ</td>
                  <td><input type="text" class="span2" style="text-align:right; color:#FF0000" value="<?=number_format($row['smtPre'],2);?>" readonly="readonly" /> บาท</td>
                </tr>
                <tr style='display:none;'>
                  <td>เบี้ยรวม</td>
                  <td><input type="text" class="span2" style="text-align:right; color:#FF0000" value="<?=number_format($row['smtNet'],2);?>" readonly="readonly" /> บาท</td>
                </tr>
				<tr>
				<td colspan="2">
				<?php
				$cost_tun=explode(' ',$row['cost']);
				$cost_total=str_replace(',','',$cost_tun['0']);
				?>
				<input name="cost_addpre" id="cost_addpre"  type="hidden" value="<?=str_replace(',','',$cost_total);?>" >
				<input name="p_pre" id="p_pre" style="margin-left:20px;" type="checkbox" value="Y" onclick='cal_car_cat_acc();'> เบี้ยรวม
				<input name="b_pre" id="b_pre" style="margin-left:20px;" type="checkbox" value="Y" onclick='cal_car_cat_acc();'> เบี้ย พรบ.
				</td>
				</tr>
                <tr>
                  <td colspan="2">
                      <div style='display:inline-block;width:100px;'>ประเภทรถ</div><select name="car_cat_acc" id="car_cat_acc" onchange='cal_car_cat_acc();'>
                      <option value="" selected="selected">กรุณาเลือก</option>
                      <option value="120">120 (รถเช่า)</option>

                        </select><br>
						<div style='display:inline-block;width:100px;'>เบี้ยรวม</div><input type="text" name="p_pre_val" id="p_pre_val" style="text-align:right; color:#FF0000" value="<?=$row['car_cat_acc_pre'];?>" onkeyup='cal_acc_total();'> บาท<br>
						<div style='display:inline-block;width:100px;'>เบี้ย พรบ.</div><input type="text" name="b_pre_val" id="b_pre_val" style="text-align:right; color:#FF0000" value="<?=$row['car_cat_acc_prb'];?>" onkeyup='cal_acc_total();'> บาท<br>
						<div style='display:inline-block;width:100px;'>เพิ่มเบี้ย</div><input type="text" name="add_pre_at" id="add_pre_at" style="text-align:right;" value="<?=$row['car_cat_acc_total'];?>" readonly > บาท
                    </td>
                </tr>
          </table>
        </div>
    </td>
  </tr>
  </table>
  <? } ?>
          </div></td>
  </tr>
  <tr>
  	<td colspan="2" align="left" bgcolor="#CCCCCC"><span style="color: #000000"><strong>
      <input name="Edit_addTun" id="Edit_addTun" style="margin-right:20px;" type="checkbox" value="Y" />เพิ่มทุนประกันภัย</strong></span>
      <div align="left" id="ShowEdit_addTun" class="style7" style="margin:10px 43px; display:none;">
        <table width="650" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td colspan="4">
            <input type="hidden" name="MORETUN" id="MORETUN" value="<?=$new_detail_2?>" />
			<select id="finance_add_tun" name="finance_add_tun">
            	<option value="0">กรุณาเลือก</option>
                <option value="N">ไม่ระบุ</option>
                <option value="10000">10,000</option>
                <option value="20000">20,000</option>
                <option value="30000">30,000</option>
                <option value="40000">40,000</option>
                <option value="50000">50,000</option>
				<option value="60000">60,000</option>
				<option value="70000">70,000</option>
				<option value="80000">80,000</option>
				<option value="90000">90,000</option>
				<option value="100000">100,000</option>
				<option value="110000">110,000</option>
            </select>
			&nbsp;&nbsp; เบี้ยเพิ่ม : <input style="font-size:16px;"  name="finance_add_tun_price" value="0.00" id="finance_add_tun_price" type="text" readonly="readonly"/> บาท
    </td>
            </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><span style="color: #000000"><strong>
      <input name="EditAct" id="EditAct" style="margin-right:20px;" type="checkbox" value="Y" />
เปลี่ยนแปลงเลขที่ พ.ร.บ. </strong></span>
      <div align="left" id="ShowEditAct" class="style7" style="margin:10px 43px; display:none;">
        <table width="650" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="610" colspan="4"><span class="style10">
            <? if($_SESSION["strUser"] != '3000032'){ ?>
				<? if($_SESSION["saka"] == '113'){?>
                    <input name="p_act1" type="hidden" id="p_act1" size="5" maxlength="5" value="09712" readonly="readonly" style="width:50px;" />
                    <input name="p_act2" type="hidden" id="p_act2" size="5" maxlength="5" value="<? if(substr($row['EditAct_id'],6,5) !=''){echo substr($row['EditAct_id'],6,5);}else{echo substr($row['p_act'],6,5);}?>" style="width:50px;"/>
                    <input name="p_act3" type="hidden" id="p_act3" size="7" maxlength="7" value="<? if(substr($row['EditAct_id'],12,7) !=''){echo substr($row['EditAct_id'],12,7);}else{echo substr($row['p_act'],12,7);}?>"  style="width:80px;"/>
    
                    <select id="status_text" name="status_text" class="span5">
                    <option value="R" >พ.ร.บ. ถูกขายไปแล้ว (ออกเลขใหม่)</option>
                    <option value="C" >พ.ร.บ. ชำรุด/สูญหาย (ออกเลขใหม่)</option>
                </select>
                <? }else{ ?>
                    <input name="p_act1" type="text" id="p_act1" size="5" maxlength="5" value="09712" readonly="readonly" style="width:50px;" /> -
                    <input name="p_act2" type="text" id="p_act2" size="5" maxlength="5" value="<? if(substr($row['EditAct_id'],6,5) !=''){echo substr($row['EditAct_id'],6,5);}else{echo substr($row['p_act'],6,5);}?>" style="width:50px;"/> -
                    <input name="p_act3" type="text" id="p_act3" size="7" maxlength="7" value="<? if(substr($row['EditAct_id'],12,7) !=''){echo substr($row['EditAct_id'],12,7);}else{echo substr($row['p_act'],12,7);}?>"  style="width:80px;"/>
                <? } ?>
            <? }else{ ?>
            	<input name="p_act1" type="text" id="p_act1" size="5" maxlength="5" value="09712" readonly="readonly" style="width:50px;" /> -
                <input name="p_act2" type="text" id="p_act2" size="5" maxlength="5" value="<? if(substr($row['EditAct_id'],6,5) !=''){echo substr($row['EditAct_id'],6,5);}else{echo substr($row['p_act'],6,5);}?>" style="width:50px;"/> -
                <input name="p_act3" type="text" id="p_act3" size="7" maxlength="7" value="<? if(substr($row['EditAct_id'],12,7) !=''){echo substr($row['EditAct_id'],12,7);}else{echo substr($row['p_act'],12,7);}?>"  style="width:80px;"/>
            <? } ?>
			<input name='p_act_data' id='p_act_data' type='hidden' value="<? if(substr($row['EditAct_id'],12,7) !=''){echo substr($row['EditAct_id'],12,7);}else{echo substr($row['p_act'],12,7);}?>">
            </span></td>
            </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><span style="color: #000000"><strong>
      <input name="EditCustomer" id="EditCustomer" style="margin-right:20px;" type="checkbox" value="Y" />
เปลี่ยนแปลงข้อมูลผู้เอาประกันภัย
    </strong></span>
    <div align="left" id="ShowEditCustomer" class="style7" style="margin:10px 43px; display:none;">
      <table width="650" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td>
		
		<span class="style7"><span class="style10">
		<? if($row['EditPerson']!=''){
			$PerSo = $row['EditPerson'];
		}
		else{
			$PerSo = $row['person'];
		}
		?>
		<input name="perSo" id="perSo" value="<?=$PerSo?>" type="hidden" size="20"/>
        <?
			if($row['person'] == 1){
        		echo "เลขที่บัตรประชาชน";
			}else{
				echo "เลขที่จดทะเบียน";
			}
		?>
        </span></span></td>
        <td colspan="3">
		<input name="person" id="EditPerson" type="radio" value="1" <?php if($row['person'] == 1){echo "chacked";} ?> /> บุคคลธรรมดา
		<input name="person" id="EditPersons" type="radio" value="2"  <?php if($row['person'] == 2){echo "chacked";} ?> /> นิติบุคคล
		<input name="person" id="EditPersonss" type="radio" value="3"  <?php if($row['person'] == 3){echo "chacked";} ?> /> ชาวต่างชาติ&nbsp;&nbsp;
		<input name="EditCard" id="EditCard" type="text" value="<?=$row['icard']?>" size="20" maxlength="13" style="width:120px;" /></td>
      </tr>
      <tr>
        <td><span class="style7"><span class="style10">ชื่อผู้เอาประกันภัย :</span></span></td>
        <td colspan="3"><select id="Cus_title" name="Cus_title" style="width:auto;">
          <option value="<? if($row['Cus_title'] !=''){echo $row['Cus_title'];}else{echo $row['title'];}?>" selected="selected">
          <? if($row['Cus_title'] !=''){echo $row['Cus_title'];}else{echo $row['title'];}?>
          </option>
        	<?php
			mysql_select_db($db2,$cndb2);
			$select_titlename_sql="SELECT * FROM tb_titlename";
			$select_titlename_query=mysql_query($select_titlename_sql, $cndb2);
			while($select_titlename_array=mysql_fetch_array($select_titlename_query))
			{ ?>
			<option value='<?php echo $select_titlename_array['prename']?>' <?php if($select_array['title']==$select_titlename_array['prename']){echo "selected";}?> ><?php echo $select_titlename_array['prename']?></option>
			<?php }
			mysql_select_db($db1,$cndb1);						
			?>
        </select>
          <input type="text" name="Cus_name" id="Cus_name" value="<? if($row['Cus_name'] !=''){echo $row['Cus_name'];}else{echo $row['name'];}?>" size="20" maxlength="100" style="width:120px;" />
          <input type="text" name="Cus_last" id="Cus_last" value="<? if($row['Cus_last'] !=''){echo $row['Cus_last'];}else{echo $row['last'];}?>" size="20" maxlength="50" style="width:140px;"  /></td>
        </tr>
      <tr>
        <td width="178"><span class="style10">บ้านเลขที่ :</span></td>
        <td width="189"><input type="text" name="Cus_add" id="Cus_add" value="<? if($row['Cus_add'] !=''){echo $row['Cus_add'];}else{echo $row['add'];}?>" size="20" maxlength="50" /></td>
        <td width="50"><span class="style10">หมู่ที่ :</span></td>
        <td width="197"><input type="text" name="Cus_group" id="Cus_group" value="<? if($row['Cus_group'] !=''){echo $row['Cus_group'];}else{echo $row['group'];}?>" size="20" maxlength="50" /></td>
      </tr>
      <tr>
        <td><span class="style10">อาคาร/หมู่บ้าน :</span></td>
        <td><input type="text" name="Cus_town" id="Cus_town" value="<? if($row['Cus_town'] !=''){echo $row['Cus_town'];}else{echo $row['town'];}?>" size="20" maxlength="50" /></td>
        <td><span class="style10">ซอย :</span></td>
        <td><input type="text" name="Cus_lane" id="Cus_lane" value="<? if($row['Cus_lane'] !=''){echo $row['Cus_lane'];}else{echo $row['lane'];}?>" size="20" maxlength="50" /></td>
      </tr>
      <tr>
        <td><span class="style10">ถนน :</span></td>
        <td><input type="text" name="Cus_road" id="Cus_road" value="<? if($row['Cus_road'] !=''){echo $row['Cus_road'];}else{echo $row['road'];}?>" size="20" maxlength="50" /></td>
        <td><span class="style10">จังหวัด :</span></td>
        <td>
        	<span id="provinceDiv">
				<select name="Cus_province" id="Cus_province">
                </select>
         	</span>
       <input name="aa" id="aa" type="hidden" value="<? if($row['Cus_province'] !=''){echo $row['Cus_province'];}else{echo $row['province'];}?>" /></td>
      </tr>
      <tr>
        <td><span class="style10">อำเภอ :</span></td>
        <td><span id="amphurDiv">
	<select name="Cus_amphur" id="Cus_amphur" >
	<option value="<? if($row['Cus_amphur'] !=''){echo $row['Cus_amphur'];}else{echo $row['amphur'];}?>"><?=$row['amphur_name']?></option>
	</select></span></td>
        <td><span class="style10">ตำบล :</span></td>
        <td><span id="tumbonDiv">
	<select name="Cus_tumbon" id="Cus_tumbon">
	<option value="<? if($row['Cus_tumbon'] !=''){echo $row['Cus_tumbon'];}else{echo $row['tumbon'];}?>"><?=$row['tumbon_name']?></option>
	</select></span></td>
      </tr>
      <tr>
        <td><span class="style10">รหัสไปรษณีย์ :</span></td>
        <td>
        <span id="id_postDiv">
            <select name="Cus_postal" id="Cus_postal">
            <option value="<? if($row['Cus_postal'] !=''){echo $row['Cus_postal'];}else{echo $row['postal'];}?>"><? if($row['Cus_postal'] !=''){echo $row['Cus_postal'];}else{echo $row['postal'];}?></option>
            </select>
         </span>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <br />
    </div></td>
    </tr>
  <tr>
    <td colspan="2" align="left" bgcolor="#CCCCCC">
    <span style="color: #000000"><strong>
      <input name="EditReceipt" id='EditReceipt' style="margin-right:20px;" type="checkbox" value="Y" />
      เปลี่ยนการออกใบเสร็จ
      </strong></span>
      <div align="left" id="ShowEditReceipt" class="style7" style="margin:10px 43px; display:none;">
          <span class="style10">ออกใบเสร็จในนาม : </span><span class="style7">
          <select name="EditCaree" id="EditCaree">
          <option value="<?=$row['career']?>" selected="selected">
          <? if($row['career'] =='1'){echo "บริษัท";}else{echo "ลูกค้า";}?>
          </option>
          <? if($row['career'] =='1'){ ?>
		  		<option value="2">ลูกค้า</option>
		  <? } if($row['career'] =='2'){ ?>
            <option value="1">บริษัท</option>
          <? } ?>
          </select>
      </span>      </div>    </td>
  </tr>
  <tr>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><span style="color: #000000"><strong>
      <input name="EditTime" id='EditTime' style="margin-right:20px;" type="checkbox" value="Y" />
      เปลี่ยนวันคุ้มครอง
      </strong></span>
      <div align="left" id="ShowEditTime" class="style7" style="margin:10px 43px; display:none;">
          <span class="style10">วันคุ้มครอง :</span>          <span class="style7">
          <input name="EditTimeStartDate" type="text" id="EditTimeStartDate" value="<? if($row['EditTime_StartDate'] !='0000-00-00'){ echo date('d/m/Y', strtotime($row['EditTime_StartDate']));}else{ echo date('d/m/Y', strtotime($row['start_date']));}?>" size="8" readonly />
      </span>      </div></td>
    </tr>
  <tr>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><span style="color: #000000"><strong>
      <input name="EditHr" id="EditHr" style="margin-right:20px;" type="checkbox" value="Y" />
เปลี่ยนแปลงผู้รับผลประโยชน์ </strong></span>
      <div align="left" id="ShowEditHr" class="style7" style="margin:10px 43px; display:none;">
      <span class="style10">ผู้รับผลประโยชน์ :</span>
      <?
		  	$sql = "SELECT name FROM tb_heiress order by id ASC";
			$result = mysql_query( $sql,$cndb1 );
			echo "<select name='EditHr_Detail' id='EditHr_Detail'>";
			if($row['EditHr_Detail'] !='')
			{
				echo "<option >".$row['EditHr_Detail']."</option>";
			}else{
				echo "<option >".$row['name_gain']."</option>";
			}
			while( $fetcharr = mysql_fetch_array( $result ) )
			{ 
				$name_heiress = $fetcharr[name];
				echo "<option value='$name_heiress'";
				echo ">$name_heiress</option>";
			}
			echo "<option value='ไม่ระบุ'>ไม่ระบุ</option>";
			echo "</select>";
	  ?>
      </div></td>
    </tr>
  <tr>
    <td colspan="2" align="left" bgcolor="#CCCCCC">
    <span style="color: #000000"><strong>
      <input name="EditSendAdd" id="EditSendAdd" style="margin-right:20px;" type="checkbox" value="Y" />
แจ้งที่อยู่ในการจัดส่งเอกสาร</strong></span>
   	<div align="left" id="ShowEditSendAdd" class="style7" style="margin:10px 43px; display:none;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <!--<td width="28%"><span class="style10">กรุณาจัดส่งเอกสารมาที่ :</span> </td>-->
          <td width=""><span class="style11">
            <input type="radio" name="NewAdd" id="NewAdd1" value="1" <?php if($row['status_SendAdd']=='N' || $row['status_SendAdd']==''){echo "checked"; $disdisshow='display:none;';} ?> />
ที่อยู่ตามผู้เอาประกันภัย
            <input type="radio" name="NewAdd" id="NewAdd2" value="2" <?php if($row['status_SendAdd']=='Y'){echo "checked"; $disdisshow='';} ?>/>
ที่อยู่จัดส่งเอกสาร</span></td>
        </tr>
        <tr>
          <td valign="top" colspan='3'><div align="left" id="ShowNewAdd" class="style7" style="<?=$disdisshow?>">
		  <?php $array_send = explode('|',$row['SendAdd']); ?>
        	<!--<span class="style15">กรอกที่อยู่ :<br /></span>-->
<div class='span12' style='padding-bottom:8px; margin:0;'><div style='background-color: #ffffffba;width:300px;padding:5px;border-radius:8px;' align='center'><font color='RED'>กรุณาคีย์ข้อมูลให้ถูกต้อง เพื่อเอกสารได้ถึงที่หมาย***</font></div></div>
<div class='span12' style='padding-bottom:8px; margin:0;'>
	<div class='span4'>
	<div class='span4'>บ้านเลขที่</div>
	<div class='span8'>
	<div class='span5'><input type="text" name="send_add" id="send_add" class='span12' value='<?=$array_send[0]?>' ></div>
	<div class='span2'>หมู่</div>
	<div class='span5'><input type="text"  name="send_group" id="send_group" class='span12' value='<?=$array_send[1]?>' ></div>
	</div>
	</div>
	<div class='span4'>
	<div class='span4'>อาคาร/หมู่บ้าน</div>
	<div class='span8'><input type="text"  name="send_town" id="send_town" class='span12' value='<?=$array_send[2]?>' ></div>
	</div>
	<div class='span4'>
	<div class='span4'>ซอย</div>
	<div class='span8'><input type="text"  name="send_lane" id="send_lane" class='span12' value='<?=$array_send[3]?>' ></div>
	</div>
	</div>

	<div class='span12'  style='padding-bottom:8px; margin:0;'>
	<div class='span4'>
	<div class='span4'>ถนน</div>
	<div class='span8'><input type="text"  name="send_road" id="send_road" class='span12'  value='<?=$array_send[4]?>' ></div>
	</div>
	<div class='span4'>
	<div class='span4'>จังหวัด</div>
	<div class='span8'>
	<select  name="send_province" id="send_province" class='span12' onchange='js_proshow("AMPHUR","province","send_province","send_amphur");'>
	<option value=''>--กรุณาเลือก--</option>
	<?php
	$send_province_sql="SELECT * FROM tb_province";
	$send_province_query=mysql_query($send_province_sql,$cndb1);
	while($send_province_array=mysql_fetch_array($send_province_query))
	{ ?>
		<option value='<?=$send_province_array['id']?>' <?php if($send_province_array['id']==$array_send[5]){echo "selected";}?> ><?=$send_province_array['name']?></option>
	<?php } ?>
	</select>
	</div>
	</div>
	<div class='span4'>
	<div class='span4'>อำเภอ</div>
	<div class='span8'><select  name="send_amphur" id="send_amphur" class='span12' onchange='js_proshow("TUMBON","amphur","send_amphur","send_tumbon");'>
	<option value=''>--กรุณาเลือก--</option>
	<?php if(!empty($array_send[6])){ 
	$send_sql="SELECT * FROM tb_amphur WHERE id = '".$array_send[6]."'";
	$send_query=mysql_query($send_sql,$cndb1);
	$send_array=mysql_fetch_array($send_query);
	?>
	<option value='<?=$array_send[6]?>' selected><?=$send_array['name']?></option>
	<?php } ?>
	</select></div>
	</div>
	</div>

	<div class='span12'  style='padding-bottom:8px; margin:0;'>
	<div class='span4'>
	<div class='span4'>ตำบล</div>
	<div class='span8'><select  name="send_tumbon" id="send_tumbon" class='span12' onchange='js_proshow("POST","tumbon","send_tumbon","send_post")';>
	<option value=''>--กรุณาเลือก--</option>
	<?php if(!empty($array_send[7])){ 
	$send_sql="SELECT * FROM tb_tumbon WHERE id = '".$array_send[7]."'";
	$send_query=mysql_query($send_sql,$cndb1);
	$send_array=mysql_fetch_array($send_query);
	?>
	<option value='<?=$array_send[7]?>' selected><?=$send_array['name']?></option>
	<?php } ?>
	</select></div>
	</div>
	<div class='span4'>
	<div class='span4'>รหัสไปรษณีย์</div>
	<div class='span8'><select  name="send_post" id="send_post" class='span12'>
	<option value=''>--กรุณาเลือก--</option>
	<?php if(!empty($array_send[8])){ ?>
	<option value='<?=$array_send[8]?>' selected><?=$array_send[8]?></option>
	<?php } ?>
	</select></div>
	</div>
	</div>
        	<!--<textarea name="EditNewAdd" id="EditNewAdd" cols="45" rows="3"></textarea>-->
        </div></td>
        </tr>
      </table>
      </div>
    </td>
  </tr>
    <tr>
    <td colspan="2" align="left" bgcolor="#CCCCCC">
    <span style="color: #000000"><strong>
      <input name="EditAddon" id="EditAddon" onclick="addon_start();" style="margin-right:20px;" type="checkbox" value="Y" <?php if($row['EditAddon']=='Y' || !empty($row['code_addon_id'])){echo "checked"; $display_addon="";}else{$display_addon="display:none;";}?>>
เปลี่ยนแปลง Add On</strong></span>
   	<div align="left" id="ShowEditAddon" class="style7" style="margin:10px 43px; <?=$display_addon;?>">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
		 <?php
		 if($row['EditAddon']=='Y')
		 {
			$check_array_addon=explode(",",$row['req_code_addon_id']);
		 }
		 else
		 {
			 $check_array_addon=explode(",",$row['code_addon_id']);
		 }
			  $select_addon_sql="SELECT * FROM tb_addon WHERE  star_date <= '".date('Y-m-d')."' AND end_date >= '".date('Y-m-d')."'";
			  $select_addon_query=mysql_query($select_addon_sql,$cndb1);
			  $numch=0;
			  while($select_addon_array=mysql_fetch_array($select_addon_query))
			  {  
			$check_is="";
			for($x=0;$x<count($check_array_addon);$x++)
			{
				if($check_array_addon[$x]==$select_addon_array['id'])
				{
					$check_is="Y";
				}
			}
		  ?>
				<div class='span12' style='border-style:none none solid none; border-width:3px; margin-left:0px;'>
				<div class='span2'><input type='checkbox' name='addon_buy[]' value='<?php echo $select_addon_array['id']; ?>,<?php echo $select_addon_array['cost_insuran'];?>,<?php echo $select_addon_array['code_addon'];?>' <?php if($check_is=="Y"){echo "checked"; } ?> onclick='addon_start("<?php echo $numch; ?>");'> ซื้อ</div>
				<div class='span5'><?php echo $select_addon_array['name_addon']." ".$select_addon_array['id_add'];?></div>
				<div class='span2'><?php echo $select_addon_array['cost_insuran']." บาท";?></div>
				<div class='span3'>
				<?php if(!empty($select_addon_array['link_addon'])){ ?>
				<a class="btn btn-small btn-info" target="_blank" href="<?php echo $select_addon_array['link_addon']; ?>"><i class="icon-download"></i>Download ใบปลิว</a>
				<?php } ?>
				</div>
				</div>
			  <?php $numch++; } ?>
			  <div class='span12'>
			  <label style="width:100px;float:left;font-size:20px;">เพิ่มเบี้ยรวม</label><input type="text" name="costIns" id="costIns" class="btn btn-danger" value="0" onkeyup='addon_start();'> บาท
			  </div>
		  </td>
        </tr>
      </table>
      </div>
    </td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="80%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="4%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    </tr>
	  <tr>
        <td align="right" colspan="2">
            <button class="btn btn-large btn-primary" type="button" id="Save_req" name="Save_req"><i class="icon-upload"></i>บันทึกข้อมูล</button>
    </tr>
  </table>
      <br />
     
  </td>
  </tr>
</table>


</div>
</form>

<script>
	$('#car_cat_acc').val('<?=$row['car_cat_acc'];?>');
	$('#car_cat_acc').change();
	function addon_start(ch)
{
	var array_addon;
	var total_addon=0;
	var ch_addon=0;
	var n;
	<?php
	$select_add_sql="SELECT * FROM tb_addon WHERE star_date <= '".date('Y-m-d')."' AND end_date >= '".date('Y-m-d')."'";
	$select_add_query=mysql_query($select_add_sql,$cndb1);
	while($select_add_array=mysql_fetch_array($select_add_query))
	{ ?>
	for(n=0;n<document.getElementsByName("addon_buy[]").length;n++)
	{
		if(array_addon=document.getElementsByName("addon_buy[]")[n].checked==true)
		{
		array_addon=document.getElementsByName("addon_buy[]")[n].value.split(",");
		if(array_addon[2]=='<?php echo $select_add_array['code_addon']; ?>')
		{
			ch_addon++;
		}
		}
	}
	if(ch_addon>1)
	{
		alert('<?php echo $select_add_array['name_addon']; ?> คุณเลือกซื้อได้อย่างใดอย่างหนึ่งเท่านั้นครับ');
		array_addon=document.getElementsByName("addon_buy[]")[ch].checked=false;
		return false;
	}
	ch_addon=0;
	<?php } ?>
	
	for(n=0;n<document.getElementsByName("addon_buy[]").length;n++)
	{
		if(document.getElementsByName("addon_buy[]")[n].checked==true)
		{
		array_addon=document.getElementsByName("addon_buy[]")[n].value.split(",");
		total_addon+=parseFloat(array_addon[1]);
		}
	}
	$("#costIns").val(total_addon);
}
function js_proshow(level,datapost,go,come)
{
	var retu="";
	if(datapost=='province')
		{
			$("#send_amphur").html('<option value="">--กรุณาเลือก--</option>');
			$("#send_tumbon").html('<option value="">--กรุณาเลือก--</option>');
			$("#send_post").html('<option value="">--กรุณาเลือก--</option>');
	retu =
	{
		
		url:"ajax/Ajax_Pro.php",
		type:"POST",
		dataType:"JSON",
		data:{province:$("#"+go).val(),
		callajax:level
		},
		success:function(data)
		{
			var datahtml='<option value="">--กรุณาเลือก--</option>';
			for(var n=0;n < data.length;n++)
			{
				datahtml+='<option value="'+data[n].Id+'">'+data[n].Name+'</option>';
			}
			$("#"+come).html(datahtml);
		}
	};
		}else if(datapost=='amphur'){
			$("#send_tumbon").html('<option value="">--กรุณาเลือก--</option>');
			$("#send_post").html('<option value="">--กรุณาเลือก--</option>');
			retu =
	{
		
		url:"ajax/Ajax_Pro.php",
		type:"POST",
		dataType:"JSON",
		data:{amphur:$("#"+go).val(),
		callajax:level
		},
		success:function(data)
		{
			var datahtml='<option value="">--กรุณาเลือก--</option>';
			for(var n=0;n < data.length;n++)
			{
				datahtml+='<option value="'+data[n].Id+'">'+data[n].Name+'</option>';
			}
			$("#"+come).html(datahtml);
		}
	};
		}else if(datapost=='tumbon'){
			$("#send_post").html('<option value="">--กรุณาเลือก--</option>');
						retu =
	{
		
		url:"ajax/Ajax_Pro.php",
		type:"POST",
		dataType:"JSON",
		data:{tumbon:$("#"+go).val(),
		callajax:level
		},
		success:function(data)
		{
			var datahtml='<option value="">--กรุณาเลือก--</option>';
			for(var n=0;n < data.length;n++)
			{
				datahtml+='<option value="'+data[n].Id+'"  selected >'+data[n].Name+'</option>';
			}
			$("#"+come).html(datahtml);
		}
	};
		}
	$.ajax(retu);
}

function cal_car_cat_acc()
{
	var save =
	{
		url:"ajax/ajax_car_cat_acc.php",
		type:"POST",
		dataType:"JSON",
		data:
		{
			p_pre:$("#p_pre:checked").val(),
			b_pre:$("#b_pre:checked").val(),
			car_id:$("#Editcar_id").val(),
			cost:$("#cost_addpre").val(),
			id_mo_car:$("#Editmo").val(),
			id_mo_car_sub:$("#mo_car_sub").val(),
			car_id_change:$("#car_cat_acc").val()
		},
		success:function(data)
		{
			$("#add_pre_at").val(data.add_pre_at);
			$("#p_pre_val").val(data.p_pre);
			$("#b_pre_val").val(data.b_pre);
		},
		error:function()
		{
			alert('การอ่านข้อมูลผิดพลาด');
		}
	}
	$.ajax(save);
}
$('#p_pre_val').iMask({type : 'number'});
$('#b_pre_val').iMask({type : 'number'});
function cal_acc_total()
{
	var total_acc = (parseFloat($('#p_pre_val').val().replace(/,/g,'')) + parseFloat($('#b_pre_val').val().replace(/,/g,''))).toFixed(2);
	$("#add_pre_at").val(addCommas(total_acc));
}
</script>

<? mysql_close(); ?>