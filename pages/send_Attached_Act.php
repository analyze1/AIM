<?php 
	include "check-ses.php"; 
	require($_SERVER['DOCUMENT_ROOT'].'/allCon.php');
	$hostname_F = "localhost";
	$username_F = _USERNAME_FOUR; // fourinsured_new
	$password_F = _PASS_FOUR; // kalanchoe
	$database_F = _DB_FOUR_INSURED;
	$obj_connectF = mysql_connect( $hostname_F , $username_F , $password_F );
	mysql_select_db($database_F,$obj_connectF);
	mysql_set_charset('utf8');

	$CHECKCHANGE = $_POST['Edittype'];
?>
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
        <script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
        <script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script language="javascript">

$( document ).ready(function() {

$("#req_date").datepicker({ 
	dateFormat: "dd/mm/yy" ,
}).val();		
});

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

<script type="text/javascript" src="js/req_Act.js"></script>

<?php 
$query = "SELECT ";
$query .= "data.id,";
$query .= "data.login, "; // รหัสผู้แจ้ง
$query .= "data.send_date,   "; // วันที่แจ้ง
$query .= "data.id_data, "; // เลขที่รับแจ้ง
$query .= "data.start_date, "; // วันที่คุ้มครอง
$query .= "data.name_gain, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.com_data, "; // รหัสบริษัทประกันภัย

$query .= "act.act_id, ";

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

$query .= "tb_tumbon.name as tumbon_name, "; 
$query .= "tb_amphur.name as amphur_name, "; 
$query .= "tb_province.name as province_name, "; // จังหวัด

$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
$query .= "detail.mo_car, "; // รหัสรุ่นรถ
$query .= "detail.car_color, "; // สีรถ
$query .= "detail.car_body, "; // เลขตัวถัง
$query .= "detail.n_motor, "; // เลขเครื่อง
$query .= "detail.gear," ; //เกียร์
$query .= "detail.cat_car," ; //
$query .= "detail.car_detail " ; //

$query .= "FROM data ";
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "INNER JOIN act ON (data.id_data  = act.id_data) ";

$query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";

$query .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
$query .= "INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
$query .= "INNER JOIN tb_province ON (tb_province.id = insuree.province) ";

$query .= "WHERE data.id_data='".$_GET['IDDATA']."'";
$objQuery = mysql_query($query,$obj_connectF) or die ("Error Query [".$query."]");
$row = mysql_fetch_array($objQuery);

$car_id = $row['car_id'];
$id_data_rec = $arrdata[0]['id_data'];
$arr_car_id = str_split($car_id);
$row['id_data']
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
    <td align="left" valign="bottom" bgcolor="#FFFFFF" class="style11"><span>สาขา : (<?=$row['login']?>) <?=$_SESSION["strName"];?> </span></td>
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
	<input name="Editmo" type="hidden" id="Editmo" value="<?=$row['mo_car'];?>"/>
    <input name="Edituser" type="hidden" id="Edituser" value="<?=$row['login'];?>"/>
	</td>
    <td align="left" valign="bottom"><div align="right"><span class="style11">วันที่แจ้งประกัน : </span><? echo date('d/m/Y', strtotime($row['send_date'])); ?>
    <input name="req_SendDate" style="display:none;" type="text" id="req_SendDate"  value="<? echo date('d/m/Y', strtotime($row['send_date'])); ?>" size="8" />
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
                <input name="Edit_CarBody1" type="text" id="Edit_CarBody1" value="<?= substr($row['car_body'],0,9);?>" size="11" readonly="readonly" style="width:100px;" />
                <input name="Edit_CarBody2" type="text" id="Edit_CarBody2" value="<?= substr($row['car_body'],9,8);?>" size="10" maxlength="8" style="width:100px;" />
                </td>
              <td width="252"><div align="left"><span class="style10">สีรถ : </span>
                    <select name="Edit_CarColor" id="Edit_CarColor" style="width:auto;" >
                      <option value="<?= $row['car_color'];?>" selected="selected"><?=$row['car_color']?></option>
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
					  <option value="เหลืองดำ">เหลืองดำ</option>
                    </select>
                    </span></div></td>
            </tr>
            <tr>
              <td><span class="style10">เลขเครื่อง :</span>
              	<? if($row['mo_car'] == '1951'){?>
                <input name="Edit_Nmotor1" type="text" id="Edit_Nmotor1" value="<?= substr($row['n_motor'],0,5);?>" size="8" readonly="readonly" style="width:100px;" />-
                <? }else{ ?>
                <input name="Edit_Nmotor1" type="text" id="Edit_Nmotor1" value="<?= substr($row['n_motor'],0,6);?>" size="8" readonly="readonly" style="width:100px;" />-
                <? } ?>
                <input name="Edit_Nmotor2" type="text" id="Edit_Nmotor2" value="<?= substr($row['n_motor'],7,6);?>" size="8" maxlength="6" style="width:100px;" />                </td>
              <td>&nbsp;</td>
            </tr>
          </table>
        </span></div>      </td>
    </tr>
  <tr>
    <td colspan="2" align="left" bgcolor="#CCCCCC"><span style="color: #000000"><strong>
      <input name="EditAct" id="EditAct" style="margin-right:20px;" type="checkbox" value="Y" />
เปลี่ยนแปลงเลขที่ พ.ร.บ. </strong></span>
      <div align="left" id="ShowEditAct" class="style7" style="margin:10px 43px; display:none;">
        <table width="650" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="610" colspan="4"><span class="style10">
            <? if($_SESSION["saka"] == '113' || $_SESSION["strUser"] == 'admin'){?>
            <select id="status_text" name="status_text" class="span5">
            	<option value="R" >พ.ร.บ. ถูกขายไปแล้ว (ออกเลขใหม่)</option>
                <option value="C" >พ.ร.บ. ชำรุด/สูญหาย (ออกเลขใหม่)</option>
                <option value="D" >ยกเลิก พ.ร.บ./ลูกค้าไม่ซื้อแล้ว</option>
            </select>
            
				<input name="p_act1" type="hidden" id="p_act1" size="5" maxlength="5" value="09712" readonly="readonly" style="width:50px;" />
                <input name="p_act2" type="hidden" id="p_act2" size="5" maxlength="5" value="<?= substr($row['act_id'],6,5);?>" style="width:50px;"/>
                <input name="p_act3" type="hidden" id="p_act3" size="7" maxlength="7" value="<?= substr($row['act_id'],12,7);?>"  style="width:80px;"/>
                <? }else{ ?>
                	<input name="p_act1" type="text" id="p_act1" size="5" maxlength="5" value="09712" readonly="readonly" style="width:50px;" /> - 
                    <input name="p_act2" type="text" id="p_act2" size="5" maxlength="5" value="<?= substr($row['act_id'],6,5);?>" style="width:50px;"/> - 
                    <input name="p_act3" type="text" id="p_act3" size="7" maxlength="7" value="<?= substr($row['act_id'],12,7);?>"  style="width:80px;"/>
                <? } ?>
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
        <td><span class="style7"><span class="style10"><? $PerSo = $row['person']; ?>
		<input name="perSo" id="perSo" value="<?=$PerSo?>" type="hidden" size="20"/>
        <? if($row['person'] == 1){echo "เลขที่บัตรประชาชน";}else{echo "เลขที่จดทะเบียน";} ?>
        </span></span></td>
        <td colspan="3">
		<input name="person" id="EditPerson" type="radio" value="1" /> บุคคลธรรมดา
		<input name="person" id="EditPersons" type="radio" value="2" /> นิติบุคคล
		<input name="person" id="EditPersonss" type="radio" value="3" /> ชาวต่างชาติ&nbsp;&nbsp;
		<input name="EditCard" id="EditCard" type="text" value="<?=$row['icard']?>" size="20" maxlength="13" style="width:120px;" /></td>
      </tr>
      <tr>
        <td><span class="style7"><span class="style10">ชื่อผู้เอาประกันภัย :</span></span></td>
        <td colspan="3"><select id="Cus_title" name="Cus_title" style="width:auto;">
          <option value="<?= $row['title'];?>" selected="selected"><?= $row['title'];?></option>
          <option value="คุณ ">คุณ</option>
          <option value="นาย ">นาย</option>
          <option value="นาง ">นาง</option>
          <option value="นางสาว ">นางสาว</option>
          <option value="บจ. ">บจ.</option>
          <option value="หจก. ">หจก.</option>
          <option value="MR. ">MR.</option>
          <option value="MRS. ">MRS.</option>
          <option value="MISS ">MISS</option>
          <option value="สิบตำรวจเอก ">สิบตำรวจเอก</option>
          <option value="นายแพทย์ ">นายแพทย์</option>
          <option value="หสน. ">หสน.</option>
          <option value="ร้าน ">ร้าน</option>
          <option value="ดร. ">ดร.</option>
          <option value="นาวาโทนายแพทย์ ">นาวาโทนายแพทย์</option>
          <option value="ร้อยตรี ">ร้อยตรี</option>
          <option value="ร้อยตำรวจตรี ">ร้อยตำรวจตรี</option>
          <option value="DR. ">DR.</option>
          <option value="MS. ">MS.</option>
          <option value="พันโท ">พันโท</option>
          <option value="พันตำรวจเอก ">พันตำรวจเอก</option>
          <option value="ร้อยตำรวจเอก ">ร้อยตำรวจเอก</option>
          <option value="โรงสี ">โรงสี</option>
          <option value="จ่าสิบตำรวจ ">จ่าสิบตำรวจ</option>
          <option value="พันจ่าเอก ">พันจ่าเอก</option>
          <option value="สิบเอก ">สิบเอก</option>
          <option value="หม่อมราชวงศ์ ">หม่อมราชวงศ์</option>
          <option value="LT.CO., ">LT.CO.,</option>
          <option value="มิสเตอร์ ">มิสเตอร์</option>
          <option value="ห้าง ">ห้าง</option>
          <option value="พลเรือตรี ">พลเรือตรี</option>
          <option value="ดาบตำรวจ ">ดาบตำรวจ</option>
          <option value="บงล. ">บงล.</option>
          <option value="พลตำรวจโท">พลตำรวจโท</option>
          <option value="ร้อยเอก ">ร้อยเอก</option>
          <option value="เรืออากาศโท ">เรืออากาศโท</option>
          <option value="สมาคม ">สมาคม</option>
          <option value="พันตำรวจโท ">พันตำรวจโท</option>
          <option value="พันเอก ">พันเอก</option>
          <option value="พันตรี ">พันตรี</option>
          <option value="จ่าสิบเอก ">จ่าสิบเอก</option>
          <option value="ทันตแพทย์ ">ทันตแพทย์</option>
          <option value="พันอากาศเอก ">พันอากาศเอก</option>
          <option value="นาวาตรี ">นาวาตรี</option>
          <option value="หม่อมหลวง ">หม่อมหลวง</option>
          <option value="พลตำรวจตรี ">พลตำรวจตรี</option>
          <option value="พันตำรวจตรี ">พันตำรวจตรี</option>
          <option value="จ่าอากาศเอก ">จ่าอากาศเอก</option>
          <option value="จ่าสิบตรี ">จ่าสิบตรี</option>
          <option value="พันจ่าอากาศเอก ">พันจ่าอากาศเอก</option>
          <option value="นาวาอากาศโท ">นาวาอากาศโท</option>
          <option value="แพทย์หญิง ">แพทย์หญิง</option>
          <option value="เรืออากาศเอก ">เรืออากาศเอก</option>
          <option value="สิบตำรวจโท ">สิบตำรวจโท</option>
          <option value="พลตรี ">พลตรี</option>
          <option value="นาวาอากาศเอก ">นาวาอากาศเอก</option>
          <option value="ธนาคาร ">ธนาคาร</option>
          <option value="ร้อยโท ">ร้อยโท</option>
          <option value="ร้อยตำรวจโท ">ร้อยตำรวจโท</option>
          <option value="เรืออากาศตรี ">เรืออากาศตรี</option>
          <option value="นาวาอากาศตรี ">นาวาอากาศตรี</option>
          <option value="พลโท ">พลโท</option>
          <option value="จ่าเอก ">จ่าเอก</option>
          <option value="โรงเรียน ">โรงเรียน</option>
          <option value="อาจารย์ ">อาจารย์</option>
          <option value="พลเรือโท ">พลเรือโท</option>
          <option value="ว่าที่ร้อยตรี ">ว่าที่ร้อยตรี</option>
          <option value="จ่าโท ">จ่าโท</option>
          <option value="โรงแรม ">โรงแรม</option>
          <option value="พลอากาศโท ">พลอากาศโท</option>
          <option value="เรืออากาศเอกหญิง ">เรืออากาศเอกหญิง</option>
          <option value="โรงพยาบาล ">โรงพยาบาล</option>
          <option value="สหกรณ์ ">สหกรณ์</option>
          <option value="มหาวิทยาลัย ">มหาวิทยาลัย</option>
          <option value="วัด ">วัด</option>
          <option value="บาทหลวง ">บาทหลวง</option>
          <option value="พันอากาศโท ">พันอากาศโท</option>
          <option value="พันเอกหญิง ">พันเอกหญิง</option>
          <option value="นาวาโท ">นาวาโท</option>
          <option value="พันตำรวจตรีนายแพทย์ ">พันตำรวจตรีนายแพทย์</option>
          <option value="พลอากาศตรี ">พลอากาศตรี</option>
          <option value="รองศาสตราจารย์ ">รองศาสตราจารย์</option>
          <option value="ร้อยเอกหญิง ">ร้อยเอกหญิง</option>
          <option value="จ่าโทหญิง ">จ่าโทหญิง</option>
          <option value="นาวาเอก ">นาวาเอก</option>
          <option value="เรือเอก ">เรือเอก</option>
          <option value="ศาสตราจารย์ ">ศาสตราจารย์</option>
          <option value="จ่าสิบโท ">จ่าสิบโท</option>
          <option value="กรม ">กรม</option>
          <option value="ท่านผู้หญิง ">ท่านผู้หญิง</option>
          <option value="สิบตำรวจตรี ">สิบตำรวจตรี</option>
          <option value="โรงเลื่อยจักร ">โรงเลื่อยจักร</option>
          <option value="สิบโท ">สิบโท</option>
          <option value="สถาน ">สถาน</option>
          <option value="เรือโท ">เรือโท</option>
          <option value="สิบตรี ">สิบตรี</option>
          <option value="โครงการ ">โครงการ</option>
          <option value="สำนักพิมพ์ ">สำนักพิมพ์</option>
          <option value="บรรษัท ">บรรษัท</option>
          <option value="วิทยาลัย ">วิทยาลัย</option>
          <option value="ร้อยตรีหญิง ">ร้อยตรีหญิง</option>
          <option value="ร้อยตำรวจตรีหญิง ">ร้อยตำรวจตรีหญิง</option>
          <option value="พันโทหญิง ">พันโทหญิง</option>
          <option value="ร้อยตำรวจเอกหญิง ">ร้อยตำรวจเอกหญิง</option>
          <option value="จ่าสิบตำรวจตรีหญิง ">จ่าสิบตำรวจตรีหญิง</option>
          <option value="พันจ่าเอกหญิง ">พันจ่าเอกหญิง</option>
          <option value="จ่าสิบตำรวจหญิง ">จ่าสิบตำรวจหญิง</option>
          <option value="ร้อยเอกแพทย์หญิง ">ร้อยเอกแพทย์หญิง</option>
          <option value="เรืออากาศโทหญิง ">เรืออากาศโทหญิง</option>
          <option value="นาวาเอกหญิง ">นาวาเอกหญิง</option>
          <option value="พันตรีหญิง ">พันตรีหญิง</option>
          <option value="จ่าสิบเอกหญิง ">จ่าสิบเอกหญิง</option>
          <option value="ทันตแพทย์หญิง ">ทันตแพทย์หญิง</option>
          <option value="พันตำรวจตรีหญิง ">พันตำรวจตรีหญิง</option>
          <option value="จ่าสิบตรีหญิง ">จ่าสิบตรีหญิง</option>
          <option value="นาวาอากาศโทหญิง ">นาวาอากาศโทหญิง</option>
          <option value="ร้อยโทหญิง ">ร้อยโทหญิง</option>
          <option value="ร้อยตำรวจโทหญิง ">ร้อยตำรวจโทหญิง</option>
          <option value="เรืออากาศตรีหญิง ">เรืออากาศตรีหญิง</option>
          <option value="จ่าอากาศตรี ">จ่าอากาศตรี</option>
          <option value="หม่อมเจ้า ">หม่อมเจ้า</option>
          <option value="มูลนิธิ ">มูลนิธิ</option>
          <option value="ผ.ศ. ">ผ.ศ.</option>
          <option value="รศ. ดร. ">รศ. ดร.</option>
          <option value="โรงงาน ">โรงงาน</option>
          <option value="กองบังคับการอำนวยการ ">กองบังคับการอำนวยการ</option>
          <option value="ศ.นพ.ดร. ">ศ.นพ.ดร.</option>
          <option value="พระ ">พระ</option>
          <option value="เรือตรีหญิง ">เรือตรีหญิง</option>
          <option value="พลอากาศเอก ">พลอากาศเอก</option>
          <option value="พันตำรวจเอกหญิง ">พันตำรวจเอกหญิง</option>
          <option value="ดาบตำรวจหญิง ">ดาบตำรวจหญิง</option>
          <option value="พลเรือเอก ">พลเรือเอก</option>
          <option value="เรือตรี ">เรือตรี</option>
          <option value="นักเรียนเตรียมทหาร ">นักเรียนเตรียมทหาร</option>
          <option value="คณะแพทย์ศาสตร์ ">คณะแพทย์ศาสตร์</option>
          <option value="พลเอก ">พลเอก</option>
          <option value="ห้างทอง ">ห้างทอง</option>
          <option value="สิบตำรวจเอกหญิง ">สิบตำรวจเอกหญิง</option>
          <option value="พระองค์เจ้า ">พระองค์เจ้า</option>
          <option value="พันเอกพิเศษ ">พันเอกพิเศษ</option>
          <option value="สัตวแพทย์ ">สัตวแพทย์</option>
          <option value="จ่าสิบตำรวจตรี ">จ่าสิบตำรวจตรี</option>
          <option value="พลเอกหญิง ">พลเอกหญิง</option>
          <option value="ร้อยตำรวจเอกนายแพทย์ ">ร้อยตำรวจเอกนายแพทย์</option>
          <option value="นายดาบตำรวจ ">นายดาบตำรวจ</option>
          <option value="สิบเอกหญิง ">สิบเอกหญิง</option>
          <option value="พันจ่าตรี ">พันจ่าตรี</option>
          <option value="เรือโทหญิง ">เรือโทหญิง</option>
          <option value="นาวาตรีหญิง ">นาวาตรีหญิง</option>
          <option value="ร้อยเอกเภสัชกร ">ร้อยเอกเภสัชกร</option>
          <option value="นาวาโทหญิง ">นาวาโทหญิง</option>
          <option value="จ่าตรี ">จ่าตรี</option>
          <option value="นักเรียนนายร้อยตำรวจ ">นักเรียนนายร้อยตำรวจ</option>
          <option value="นนร.จุลจอมเกล้า ">นนร.จุลจอมเกล้า</option>
          <option value="นักเรียนนายร้อยสำรอง ">นักเรียนนายร้อยสำรอง</option>
          <option value="นักเรียนนายสิบ ">นักเรียนนายสิบ</option>
          <option value="จอมพลเรือ ">จอมพลเรือ</option>
          <option value="พันจ่าโท ">พันจ่าโท</option>
          <option value="จ่าเอกหญิง ">จ่าเอกหญิง</option>
          <option value="จ่าสำรอง ">จ่าสำรอง</option>
          <option value="จอมพลอากาศ ">จอมพลอากาศ</option>
          <option value="พันจ่าอากาศโท ">พันจ่าอากาศโท</option>
          <option value="พันจ่าอากาศตรี ">พันจ่าอากาศตรี</option>
          <option value="จ่าอากาศโท ">จ่าอากาศโท</option>
          <option value="พลทหาร ">พลทหาร</option>
          <option value="นายพลตำรวจเอก ">นายพลตำรวจเอก</option>
          <option value="นายพลตำรวจจัตวา ">นายพลตำรวจจัตวา</option>
          <option value="นาวาอากาศเอกหญิง ">นาวาอากาศเอกหญิง</option>
          <option value="หม่อมหลวงหญิง ">หม่อมหลวงหญิง</option>
          <option value="นาวาอากาศตรีหญิง ">นาวาอากาศตรีหญิง</option>
          <option value="เรือเอกหญิง ">เรือเอกหญิง</option>
          <option value="นายตำรวจ ">นายตำรวจ</option>
          <option value="พันตรีนายแพทย์ ">พันตรีนายแพทย์</option>
          <option value="พันตำรวจเอกนายแพทย์ ">พันตำรวจเอกนายแพทย์</option>
          <option value="ศาสตราจารย์ดอกเตอร์ ">ศาสตราจารย์ดอกเตอร์</option>
          <option value="พันจ่าอากาศเอกหญิง ">พันจ่าอากาศเอกหญิง</option>
          <option value="พันจ่าโทหญิง ">พันจ่าโทหญิง</option>
          <option value="นายดาบตำรวจหญิง ">นายดาบตำรวจหญิง</option>
          <option value="พระครู ">พระครู</option>
          <option value="นักเรียนนายเรือ ">นักเรียนนายเรือ</option>
          <option value="นายสัตวแพทย์ ">นายสัตวแพทย์</option>
          <option value="โรงเลื่อย ">โรงเลื่อย</option>
          <option value="นักเรียนนายเรืออากาศ ">นักเรียนนายเรืออากาศ</option>
          <option value="สิบตำรวจตรีหญิง ">สิบตำรวจตรีหญิง</option>
          <option value="พันเอกพิเศษหญิง ">พันเอกพิเศษหญิง</option>
          <option value="คุณหญิง ">คุณหญิง</option>
          <option value="นิติบุคคล ">นิติบุคคล</option>
          <option value="นายดาบ ">นายดาบ</option>
          <option value="ศาสตราจารย์นายแพทย์ ">ศาสตราจารย์นายแพทย์</option>
          <option value="พลตำรวจเอก ">พลตำรวจเอก</option>
          <option value="สำนักงาน ">สำนักงาน</option>
          <option value="นาวาอากาศเอกนายแพทย์ ">นาวาอากาศเอกนายแพทย์</option>
          <option value="ภิกษุ ">ภิกษุ</option>
          <option value="พระอธิการ ">พระอธิการ</option>
          <option value="การสื่อสารแห่งประเทศไทย ">การสื่อสารแห่งประเทศไทย</option>
          <option value="ว่าที่สิบตรี ">ว่าที่สิบตรี</option>
          <option value="ว่าที่ร้อยตรีหญิง ">ว่าที่ร้อยตรีหญิง</option>
          <option value="นาวาเอกนายแพทย์ ">นาวาเอกนายแพทย์</option>
          <option value="นาวาโทหม่อมหลวง ">นาวาโทหม่อมหลวง</option>
          <option value="ว่าที่เรือโท ">ว่าที่เรือโท</option>
          <option value="พันตำรวจโทหญิง ">พันตำรวจโทหญิง</option>
          <option value="ORG. ">ORG.</option>
          <option value="ว่าที่ร้อยตำรวจโท ">ว่าที่ร้อยตำรวจโท</option>
          <option value="คุณหญิงแพทย์หญิง ">คุณหญิงแพทย์หญิง</option>
          <option value="สิบโทหญิง ">สิบโทหญิง</option>
          <option value="ว่าที่ร้อยโท ">ว่าที่ร้อยโท</option>
          <option value="การไฟฟ้าส่วนภูมิภาค ">การไฟฟ้าส่วนภูมิภาค</option>
          <option value="พันอากาศตรี ">พันอากาศตรี</option>
          <option value="หอการค้า ">หอการค้า</option>
          <option value="ร้านสหกรณ์ ">ร้านสหกรณ์</option>
          <option value="จ่าสิบตำรวจโท ">จ่าสิบตำรวจโท</option>
          <option value="สิบตำรวจโทหญิง ">สิบตำรวจโทหญิง</option>
          <option value="หม่อม ">หม่อม</option>
          <option value="ว่าที่ร้อยโทหญิง ">ว่าที่ร้อยโทหญิง</option>
          <option value="พันเอกนายแพทย์ ">พันเอกนายแพทย์</option>
          <option value="พันตำรวจเอกหม่อมหลวง ">พันตำรวจเอกหม่อมหลวง</option>
          <option value="MDM. ">MDM.</option>
          <option value="ร้อยเอกนายแพทย์ ">ร้อยเอกนายแพทย์</option>
          <option value="จ่าสิบตำรวจเอก ">จ่าสิบตำรวจเอก</option>
          <option value="สัตวแพทย์หญิง ">สัตวแพทย์หญิง</option>
          <option value="นักเรียนพยาบาลทหารอากาศ ">นักเรียนพยาบาลทหารอากาศ</option>
          <option value="ว่าที่ร้อยตำรวจตรี ">ว่าที่ร้อยตำรวจตรี</option>
          <option value="ว่าที่เรืออากาศตรี ">ว่าที่เรืออากาศตรี</option>
          <option value="ว่าที่เรือตรี ">ว่าที่เรือตรี</option>
          <option value="พันตรีหม่อมราชวงศ์ ">พันตรีหม่อมราชวงศ์</option>
          <option value="ร้อยโทหญิงหม่อมหลวง ">ร้อยโทหญิงหม่อมหลวง</option>
          <option value="ว่าที่พลตำรวจโท ">ว่าที่พลตำรวจโท</option>
          <option value="ว่าที่พันตำรวจเอก ">ว่าที่พันตำรวจเอก</option>
          <option value="พระภิกษุ ">พระภิกษุ</option>
          <option value="พระอาจารย์ ">พระอาจารย์</option>
          <option value="พระมหา ">พระมหา</option>
          <option value="ร้อยเอกทันตแพทย์หญิง ">ร้อยเอกทันตแพทย์หญิง</option>
          <option value="อู่ ">อู่</option>
          <option value="การไฟฟ้า ">การไฟฟ้า</option>
          <option value="โรงฟอกหนัง ">โรงฟอกหนัง</option>
          <option value="ว่าที่พันตำรวจตรี ">ว่าที่พันตำรวจตรี</option>
          <option value="ห้างสรรพสินค้า ">ห้างสรรพสินค้า</option>
          <option value="ร้อยตำรวจ ">ร้อยตำรวจ</option>
          <option value="บมจ. ">บมจ.</option>
          <option value="พันโทนายแพทย์ ">พันโทนายแพทย์</option>
          <option value="พลโทหม่อมราชวงศ์ ">พลโทหม่อมราชวงศ์</option>
          <option value="พันเอกหม่อมราชวงศ์ ">พันเอกหม่อมราชวงศ์</option>
          <option value="รองศาสตราจารย์นายแพทย์ ">รองศาสตราจารย์นายแพทย์</option>
          <option value="สหกรณ์การเกษตร ">สหกรณ์การเกษตร</option>
          <option value="พลฯสำรองพิเศษหญิง ">พลฯสำรองพิเศษหญิง</option>
          <option value="พันตำรวจตรีหม่อมหลวง ">พันตำรวจตรีหม่อมหลวง</option>
          <option value="ว่าที่นาวาตรี ">ว่าที่นาวาตรี</option>
          <option value="บง. ">บง.</option>
          <option value="ว่าที่ร้อยเอก ">ว่าที่ร้อยเอก</option>
          <option value="พันจ่าตรีหญิง ">พันจ่าตรีหญิง</option>
          <option value="พันเอกพิเศษแพทย์หญิง ">พันเอกพิเศษแพทย์หญิง</option>
          <option value="กลุ่มบริษัท ">กลุ่มบริษัท</option>
          <option value="นาวาอากาศโทนายแพทย์ ">นาวาอากาศโทนายแพทย์</option>
          <option value="องค์การ ">องค์การ</option>
          <option value="พันตรีทันตแพทย์ ">พันตรีทันตแพทย์</option>
          <option value="พันจ่าอากาศโทหญิง ">พันจ่าอากาศโทหญิง</option>
          <option value="ว่าที่พันตำรวจตรีหญิง ">ว่าที่พันตำรวจตรีหญิง</option>
          <option value="พันตรีหม่อมหลวง ">พันตรีหม่อมหลวง</option>
          <option value="พันตำรวจเอกพิเศษ ">พันตำรวจเอกพิเศษ</option>
          <option value="นาวาอากาศเอกพิเศษ ">นาวาอากาศเอกพิเศษ</option>
          <option value="พลตำรวจ ">พลตำรวจ</option>
          <option value="คณะเภสัช ">คณะเภสัช</option>
          <option value="กระทรวง ">กระทรวง</option>
          <option value="พลตำรวจหญิง ">พลตำรวจหญิง</option>
          <option value="พันโทดอกเตอร์ ">พันโทดอกเตอร์</option>
          <option value="จ่านายสิบตำรวจ ">จ่านายสิบตำรวจ</option>
          <option value="จ่าอากาศเอกหญิง ">จ่าอากาศเอกหญิง</option>
          <option value="พันอากาศเอกหญิง ">พันอากาศเอกหญิง</option>
          <option value="ว่าที่พันตำรวจโท ">ว่าที่พันตำรวจโท</option>
          <option value="ศจ.เกียรติคุณนายแพทย์ ">ศจ.เกียรติคุณนายแพทย์</option>
          <option value="นาวาอากาศ ">นาวาอากาศ</option>
          <option value="ด.ญ. ">ด.ญ.</option>
          <option value="ด.ช. ">ด.ช.</option>
          <option value="กิจการร่วมค้า ">กิจการร่วมค้า</option>
          <option value="พลฯหญิง ">พลฯหญิง</option>
          <option value="พลอากาศตรีหญิง ">พลอากาศตรีหญิง</option>
          <option value="พลตรีนายแพทย์ ">พลตรีนายแพทย์</option>
          <option value="ศาสตราจารย์แพทย์หญิง ">ศาสตราจารย์แพทย์หญิง</option>
          <option value="ร้อยตำรวจหญิง ">ร้อยตำรวจหญิง</option>
          <option value="พลอากาศเอกหญิง ">พลอากาศเอกหญิง</option>
          <option value="พันเอกดอกเตอร์ ">พันเอกดอกเตอร์</option>
          <option value="บริษัทหลักทรัพย์ ">บริษัทหลักทรัพย์</option>
          <option value="สิบตรีหญิง ">สิบตรีหญิง</option>
          <option value="พันเอกหม่อมหลวง ">พันเอกหม่อมหลวง</option>
          <option value="ว่าที่ร้อยตำรวจตรีหญิง ">ว่าที่ร้อยตำรวจตรีหญิง</option>
          <option value="พลอาสาสมัคร ">พลอาสาสมัคร</option>
          <option value="การประปา ">การประปา</option>
          <option value="พลตำรวจสำรองพิเศษ ">พลตำรวจสำรองพิเศษ</option>
          <option value="พลเรือตรีหญิง ">พลเรือตรีหญิง</option>
          <option value="ว่าที่ร้อยตำรวจเอก ">ว่าที่ร้อยตำรวจเอก</option>
          <option value="องค์การสงเคราะห์ ">องค์การสงเคราะห์</option>
          <option value="หมู่บ้าน ">หมู่บ้าน</option>
          <option value="สิบตำรวจ ">สิบตำรวจ</option>
          <option value="ศูนย์ ">ศูนย์</option>
          <option value="ผศ. ดร. ">ผศ. ดร.</option>
          <option value="แม่ชี ">แม่ชี</option>
          <option value="นาวาอากาศตรีนายแพทย์ ">นาวาอากาศตรีนายแพทย์</option>
          <option value="รองอธิบดี ">รองอธิบดี</option>
          <option value="รศ.น.อ.ดร. ">รศ.น.อ.ดร.</option>
          <option value="จ่าสิบโทหญิง ">จ่าสิบโทหญิง</option>
          <option value="ว่าที่พันเอกหญิง ">ว่าที่พันเอกหญิง</option>
          <option value="ว่าที่พลตำรวจตรี ">ว่าที่พลตำรวจตรี</option>
          <option value="พันโทหม่อมหลวง ">พันโทหม่อมหลวง</option>
          <option value="สำนักงานผู้แทน ">สำนักงานผู้แทน</option>
          <option value="นาวาเอกพิเศษ ">นาวาเอกพิเศษ</option>
          <option value="เจ้าคุณพระ ">เจ้าคุณพระ</option>
          <option value="พลตรีหญิง ">พลตรีหญิง</option>
          <option value="หม่อมราชวงศ์หญิง ">หม่อมราชวงศ์หญิง</option>
          <option value="พันโทพิเศษ ">พันโทพิเศษ</option>
          <option value="ห้างหุ้นส่วน ">ห้างหุ้นส่วน</option>
          <option value="หม่อมเจ้าหญิง ">หม่อมเจ้าหญิง</option>
          <option value="พันอากาศตรีหญิง ">พันอากาศตรีหญิง</option>
          <option value="ห้างหุ้นส่วนสามัญ ">ห้างหุ้นส่วนสามัญ</option>
          <option value="พลตรี แพทย์หญิง ">พลตรี แพทย์หญิง</option>
          <option value="สายการบิน ">สายการบิน</option>
          <option value="สถาบัน ">สถาบัน</option>
          <option value="จ่าอากาศตรีหญิง ">จ่าอากาศตรีหญิง</option>
          <option value="บริษัท ">บริษัท</option>
          <option value="ร้อยโทนายแพทย์ ">ร้อยโทนายแพทย์</option>
          <option value="ว่าที่พันโท ">ว่าที่พันโท</option>
          <option value="จ่าอากาศโทหญิง ">จ่าอากาศโทหญิง</option>
          <option value="ห้างหุ้นส่วนจำกัด ">ห้างหุ้นส่วนจำกัด</option>
          <option value="กลุ่ม ">กลุ่ม</option>
        </select>
          <input type="text" name="Cus_name" id="Cus_name" value="<?=$row['name'];?>" size="20" maxlength="100" style="width:120px;" />
          <input type="text" name="Cus_last" id="Cus_last" value="<?= $row['last'];?>" size="20" maxlength="50" style="width:140px;"  /></td>
        </tr>
      <tr>
        <td width="178"><span class="style10">บ้านเลขที่ :</span></td>
        <td width="189"><input type="text" name="Cus_add" id="Cus_add" value="<?= $row['add'];?>" size="20" maxlength="50" /></td>
        <td width="50"><span class="style10">หมู่ที่ :</span></td>
        <td width="197"><input type="text" name="Cus_group" id="Cus_group" value="<?= $row['group'];?>" size="20" maxlength="50" /></td>
      </tr>
      <tr>
        <td><span class="style10">อาคาร/หมู่บ้าน :</span></td>
        <td><input type="text" name="Cus_town" id="Cus_town" value="<?= $row['town'];?>" size="20" maxlength="50" /></td>
        <td><span class="style10">ซอย :</span></td>
        <td><input type="text" name="Cus_lane" id="Cus_lane" value="<?= $row['lane'];?>" size="20" maxlength="50" /></td>
      </tr>
      <tr>
        <td><span class="style10">ถนน :</span></td>
        <td><input type="text" name="Cus_road" id="Cus_road" value="<?= $row['road'];?>" size="20" maxlength="50" /></td>
        <td><span class="style10">จังหวัด :</span></td>
        <td>
        	<span id="provinceDiv">
				<select name="Cus_province" id="Cus_province">
                </select>
         	</span>
       <input name="aa" id="aa" type="hidden" value="<?= $row['province'];?>" /></td>
      </tr>
      <tr>
        <td><span class="style10">อำเภอ :</span></td>
        <td><span id="amphurDiv">
	<select name="Cus_amphur" id="Cus_amphur" >
	<option value="<?= $row['amphur'];?>"><?=$row['amphur_name']?></option>
	</select></span></td>
        <td><span class="style10">ตำบล :</span></td>
        <td><span id="tumbonDiv">
	<select name="Cus_tumbon" id="Cus_tumbon">
	<option value="<?= $row['tumbon'];?>"><?=$row['tumbon_name']?></option>
	</select></span></td>
      </tr>
      <tr>
        <td><span class="style10">รหัสไปรษณีย์ :</span></td>
        <td>
        <span id="id_postDiv">
            <select name="Cus_postal" id="Cus_postal">
            <option value="<?= $row['postal'];?>"><?= $row['postal'];?></option>
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
    <td colspan="2" align="left" bgcolor="#CCCCCC"><span style="color: #000000"><strong>
      <input name="EditTime" id='EditTime' style="margin-right:20px;" type="checkbox" value="Y" />
      เปลี่ยนวันคุ้มครอง
      </strong></span>
      <div align="left" id="ShowEditTime" class="style7" style="margin:10px 43px; display:none;">
          <span class="style10">วันคุ้มครอง :</span>          <span class="style7">
          <input name="EditTimeStartDate" type="text" id="EditTimeStartDate" value="<?= date('d/m/Y', strtotime($row['start_date']));?>" size="8" readonly />
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
			$result = mysql_query( $sql,$obj_connectF );
			echo "<select name='EditHr_Detail' id='EditHr_Detail'>";

				echo "<option >".$row['name_gain']."</option>";

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
<? mysql_close(); ?>