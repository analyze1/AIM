<?php
include "check-ses.php"; 
include "../../inc/connectdbs.pdo.php";
include "../inc/connectdbs.inc.php";
header('Content-Type: text/html; charset=utf-8');
?>
<script src="js/js_Insurance_NewAct_edit.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
        <script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
        <script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

<script type="text/javascript">
	function checkText()
	{
		var elem = document.getElementById('car_body').value;
		if(!elem.match(/^([a-z0-9\_])+$/i))
		{
			alert("กรอกได้เฉพาะ A-Z, 0-9 ");
			document.getElementById('car_body').value = "";
		}
	}
		function checkText2()
	{
		var elem = document.getElementById('n_motor').value;
		if(!elem.match(/^([a-z0-9\_])+$/i))
		{
			alert("กรอกได้เฉพาะ A-Z, 0-9 ");
			document.getElementById('n_motor').value = "";
		}
		
	}
</script>
<style>
table {background:#eee !important;}
.color_eee{background:#eee !important;}
</style>
<form name="Insurance" id="Insurance">
<div class="row-fluid">
	<div class="span12">
		<div class="alert alert-block alert-danger" align="center"><strong><font color="#FF0000">แจ้งประกันภัย</u>!!!</font></strong></div>
		<div class="widget-box">
            <div class="widget-header widget-header-flat"> <h4>ข้อมูลทั่วไป</h4></div>
                <div class="widget-body  color_eee">
                    <div class="widget-main">
                        <div class="row-fluid">
                            <div class="span12">
	 <input name="ty_prot" type="hidden" id="ty_prot" value="<?php print $ty_prot; ?>" />
     <input name="send_date" type="hidden" id="send_date" size="40"  maxlength="10" readonly="true" value="<?=date("Y-m-d H:i"); ?>" />
     <input name="xuser" type="hidden" id="xuser" value="<?=$_SESSION["strUser"];?>" />
     <input name="xUserName" type="hidden" id="xUserName" value="<?=$_SESSION["strPass"];?>" />
     <input name="name_inform" type="hidden" id="name_inform" size="40"  maxlength="40" readonly="true" value="<?=$_SESSION["strName"];?>" />
	 <input name="idUser" type="hidden" id="idUser" size="40"  maxlength="40" readonly="true" value="<?=$_SESSION["idUser"];?>" />
     <input type="hidden" name="doc_type" id="doc_type" value="1" />
<table class="table">
<?php
$q_auto=base64_decode($_GET['q_auto']);
mysql_select_db($db2,$cndb2);
$q_sql="SELECT
quotation.agent_group,
quotation.customer,
data_quotation.start_date,
data_quotation.end_date,
quotation.car_type,
tb_pass_car.name As car_name,
quotation.id_cat_car,
tb_pass_car_type.name As cat_name,
quotation.id_br_car,
tb_br_car.name As br_name,
quotation.id_mo_car As id_mo,
quotation.car_id,
quotation.car_body,
quotation.n_motor,
quotation.car_regis_pro,
quotation.id_car_regis,
quotation.car_color,
quotation.regis_date,
quotation.cc,
quotation.gear,
quotation.wg_name,
quotation.car_seat,
insuree_quotation.title As c_title,
insuree_quotation.name As c_name,
insuree_quotation.last As c_last,
insuree_quotation.person As c_person,
insuree_quotation.icard As c_icard,
insuree_quotation.add,
insuree_quotation.group,
insuree_quotation.town,
insuree_quotation.lane,
insuree_quotation.road,
insuree_quotation.tel_mobile,
insuree_quotation.tel_mobile2,
insuree_quotation.email,
insuree_quotation.tumbon,
insuree_quotation.amphur,
insuree_quotation.province,
insuree_quotation.postal,
insuree_quotation.tel_home

FROM quotation
LEFT JOIN data_quotation ON data_quotation.q_auto = quotation.q_auto
LEFT JOIN driver_quotation ON driver_quotation.q_auto = quotation.q_auto
LEFT JOIN insuree_quotation ON insuree_quotation.q_auto = quotation.q_auto
LEFT JOIN tb_acc_car ON tb_acc_car.q_auto = quotation.q_auto
LEFT JOIN tb_pass_car ON tb_pass_car.id = quotation.car_type
LEFT JOIN tb_pass_car_type ON tb_pass_car_type.id = quotation.id_cat_car
LEFT JOIN tb_br_car ON tb_br_car.id = quotation.id_br_car

WHERE quotation.q_auto = '".$q_auto."'";
$q_query=mysql_query($q_sql,$cndb2);
$q_array=mysql_fetch_array($q_query);



mysql_select_db( $database_conn ) or die( "เลือกฐานข้อมูลไม่ได้" );
$c_sql="SELECT user,sub FROM tb_customer WHERE user = '".$q_array['agent_group']."'";
$c_query=mysql_query($c_sql);
$c_array=mysql_fetch_array($c_query);
?>
<tr>
      <td width='120'>เลขที่ใบเสนอราคา</td>
      <td> : <input type='text' name="q_auto" id="q_auto" size='4' value='<?=$q_auto;?>' onkeyup='prb_total()' readonly ><font color="#FF0000"><b> * </b></font></td>
	  <td colspan='4' id='prb_grand'></td>
</tr>
<?php
		if($_SESSION["strUser"] == "admin"){
?>

<tr class="error">
<td>สาขาแจ้งงาน</td><td> : 
<?php 
if($q_array['customer']<=1 || $q_array['customer'] ==""|| $q_array['agent_group'] =="")
{
?>
<select name="Dxuser" id="Dxuser">
        <option value="0" selected="selected">กรุณาเลือกชื่อผู้แจ้ง</option>
        <?php
			  	$query_D ="SELECT * FROM `tb_customer` WHERE `nameuser` = 'Mitsubishi' ORDER BY `tb_customer`.`user` ASC"; // id = '1' 
				$objQueryD = mysql_query($query_D) or die ("Error Query [".$query_D."]");
				while($objResultD = mysql_fetch_array($objQueryD))
				{
					echo '<option value="'.$objResultD['user'].'">'.'['.$objResultD['user'].'] '.$objResultD['sub'].'</option>';
				}
				}
				else
				{ ?>
				<select name="Dxuser" id="Dxuser">
				<option value="<?php echo $c_array['user'];?>"><?php echo '['.$c_array['user'].'] '.$c_array['sub']; ?></option>
				</select>
			<?php	}   ?>
      </select>
           </td>
		<td></td><td></td>
		<td></td><td></td>
</tr><? } ?>
<tr>

<td>วันที่คุ้มครอง</td><td> : 
<?php 
list($year,$month,$day) = explode("-",$q_array['start_date']);
$edit_date=$day.'/'.$month.'/'.$year;
if($q_array['start_date']=="0000-00-00")
{ ?>
<input name="end_date" type="hidden" id="end_date" class="span6" value="<?php echo date("d/m/Y");?>">
<input name="start_date" type="text" id="start_date" class="span6" value="" readonly /><font color="#FF0000"><b> * (วัน/เดือน/ปี)</b></font>
<?php }
else 
{ ?>
<input name="end_date" type="hidden" id="end_date" class="span6" value="<?php echo $edit_date;?>">
<input name="start_date" type="text" id="start_date"  class="span6" value="<?php echo $edit_date;?>" readonly /><font color="#FF0000"><b> * (วัน/เดือน/ปี)</b></font>
<?php } ?>
</td>
<td>ประเภทการใช้</td><td> : 
		  <?php
	  $car_slot = str_split($q_array['car_id']);
	  if(strlen($q_array['car_id'])==3)
	  {
	  $car_id = $car_slot[0];
	  $car_id1 = $car_slot[1]."".$car_slot[2];
	  }
	  else
	  {
	  $car_id = $car_slot[0]."".$car_slot[1];
	  $car_id1 = $car_slot[2]."".$car_slot[3];
	  }
	  mysql_select_db($db2,$cndb2);
	  $tb_pass_car_sql="SELECT * FROM tb_pass_car WHERE id = '".$car_id."'";
	  $tb_pass_car_query=mysql_query($tb_pass_car_sql,$cndb2);
	  $tb_pass_car_array=mysql_fetch_array($tb_pass_car_query);
	  $tb_pass_car_type_sql="SELECT * FROM tb_pass_car_type WHERE id = '".$car_id1."'";
	  $tb_pass_car_type_query=mysql_query($tb_pass_car_type_sql,$cndb2);
	  $tb_pass_car_type_array=mysql_fetch_array($tb_pass_car_type_query);
	  ?>
	  <?php if($q_array['car_id']=="") { ?>
	  <span id="cartypeDiv"><select name="cartype" id="cartype"  class="span7"><option value="0">กรุณาเลือก</option></select></span>
	  <?php } else { ?>
	  <span id="cartypeDiv"><select name="cartype" id=""  class="span7"><option value="<?php echo $tb_pass_car_array['id'];?>"><?php echo $tb_pass_car_array['id'].' : '.$tb_pass_car_array['name'] ;?></option></select></span>
	  <?php } ?>
     <font color="#FF0000"><b> * </b></font></td>
	  <td>ลักษณะใช้งาน</td>
      <td> : 
	  <?php if($q_array['car_id']=="") { ?>
	  <span id="car_idDiv"><select name="car_id" id="car_id" class="span7" ><option value="0">กรุณาเลือก</option></select></span>
      <?php } else { ?>
	  <span id="car_idDiv"><select name="car_id" id="car_id" class="span7" ><option value="<?php echo $tb_pass_car_type_array['id'] ;?>"><?php echo $tb_pass_car_type_array['id'].' : '.$tb_pass_car_type_array['name'] ;?></option></select></span>
	  <?php } ?>
	  <font color="#FF0000"><b> * </b></font></td>
		</tr>
   <tr class="warning">
      <td>ประเภทรถ</td>
	  
      <td> : <span id="cat_carDiv">
	  <select name="cat_car" id="cat_car" class="span7" >
	  <?php  
	  $cat_sql="SELECT id,name FROM tb_cat_car WHERE  id = '".$q_array['id_cat_car']."'";
	  $cat_query=mysql_query($cat_sql,$cndb2);
	  $cat_array=mysql_fetch_array($cat_query);
	  if($q_array['id_cat_car']=="")
		{	  
		 $catcar_sql="SELECT id,name FROM tb_cat_car WHERE id = '01' OR id = '02' OR id = '03' OR id = '04' OR id = '05'";
	  $catcar_query=mysql_query($catcar_sql,$cndb2);
		?>
		<option value="0">กรุณาเลือก</option>
		<?php 
		while($catcar_array=mysql_fetch_array($catcar_query))
		{ if($catcar_array['id']<=9){$catcar_n=str_split($catcar_array['id']);$id_ncat=$catcar_n[1];}else{$id_ncat=$catcar_array['id'];} ?>
		<option value="<?php echo $id_ncat; ?>"><?php echo $catcar_array['name']; ?></option>
		<?php } 
		 } else { ?>
	  <option value="<?php if($cat_array['id']<=9){$catcar_n=str_split($cat_array['id']);$id_ncat=$catcar_n[1];}else{$id_ncat=$cat_array['id'];} echo $id_ncat; ?>"><?php echo $cat_array['name']; ?></option>
	  <?php } ?>
	  </select>
	  </span><font color="#FF0000"><b> * </b></font>
	  </td>
      <td>ยี่ห้อรถ</td>
      <td> : <span id="br_carDiv"><select name="br_car" id="br_car" class="span7" ><option value="<?php echo $q_array['id_br_car'] ;?>"><?php echo $q_array['br_name'] ;?></option></select></span><font color="#FF0000"><b> * </b></font></td>
      <td>รุ่นรถ</td>
      <td> : 	  
	  <?php 
	  $m_sql="SELECT name As mo_name,id As mo_id FROM tb_mo_car WHERE id = '".$q_array['id_mo']."'";
	  $m_query = mysql_query($m_sql,$cndb2);
	  $m_array = mysql_fetch_array($m_query);
	  if($q_array['id_mo'] == 0 || $q_array['id_mo'] =='')
				{ 
		$mo_sql="SELECT name As mo_name,id As mo_id FROM tb_mo_car WHERE id = '".$q_array['id_br_car']."'";
	  $mo_query = mysql_query($mo_sql,$cndb2);
	  ?>	
		<span id="mo_carDiv">
		<select name="mo_car" id="mo_car" class="span7">
		<option value="0">กรุณาเลือก</option>
		<?php while($mo_array = mysql_fetch_array($mo_query)) 
		 { ?>
		 <option value="<?php echo $mo_array['mo_id']; ?>"><?php echo $mo_array['mo_name']; ?></option>
		 <?php } ?>
		</select>
		</span><font color="#FF0000"><b> * </b></font></td>
	 <?php  }
	 else 
				{ ?>
	  <span id="mo_carDiv"><select name="mo_car" id="mo_car" class="span7"><option value="<?php echo $m_array['mo_id'];?>"><?php echo $m_array['mo_name'];?></option></select></span><font color="#FF0000"><b> * </b></font></td>
	<?php	} ?>
   </tr>
	 <tr>
      <td>จำนวน ซี.ซี.</td>
      <td> : 
	  <select name="car_cc" id="car_cc" class="span7">
		  <option value="0" selected="selected">กรุณาเลือก</option>
        </select>
		<font color="#FF0000"><b> * </b></font></td>
      <td>น้ำหนัก</td>
      <td> : 
	  <select name="car_wgt" id="car_wgt" class="span7">
  <option value="0" selected="selected">กรุณาเลือก</option>
	</select>


<font color="#FF0000"><b> * </b></font></td>
      <td>จำนวนที่นั่ง</td>
      <td> : 
	  	  <?php if($q_array['car_seat']=="") 
	  { ?>
	  <select name="car_seat" id="car_seat" class="span7">
        <option value="0" selected="selected">กรุณาเลือก</option>
        <option value="3">ไม่เกิน 3 ที่นั่ง</option>
        <option value="7">ไม่เกิน 7 ที่นั่ง</option>
      </select> 
	  		<?php } else { ?>
		<input type="text" value="<?php echo $q_array['car_seat'];?>" name="car_seat" id="car_seat1" readonly class="span7">
		<?php } ?>
        <font color="#FF0000"><b> * </b></font></td>
    </tr>
	<tr class="warning">
<td>ปีจดทะเบียน</td>
      <td> :
      <input type="hidden" name="Dyy" id="Dyy" value="<?=date('Y') ?>" readonly />
	  <?php if($q_array['regis_date']=="")
	  { ?>
	   <select name="regis_date" id="regis_date" class="span7"></select>
	   <?php } else { ?>
	   <select name="regis_date" id="" class="span7"><option value="<?php echo $q_array['regis_date']; ?>"><?php echo $q_array['regis_date']; ?></option></select>
	   <?php } ?>
	   </td>
      <td>ทะเบียนรถ</td>
      <td> : 
	  <?php if($q_array['id_car_regis']=="") 
	   { ?>
	 <input  name="car_regis" type="text" id="car_regis" value="" size="10" maxlength="8" class="span7" />
    <input name="car_regis_text" type="hidden" id="car_regis_text" value="-" size="10" maxlength="8" class="span7" />
	   <?php } else { ?>
	<input  name="car_regis" type="text" id="car_regis" value="<?php echo $q_array['id_car_regis']; ?>"  size="10" maxlength="8" class="span7" />
    <input name="car_regis_text" type="hidden" id="car_regis_text" value="-" size="10" maxlength="8" class="span7" />
	   <?php } ?>

	</td>
      <td>จังหวัดทะเบียนรถ</td>
      <td>: 
	  <select class="span7" name='car_regis_pro' id='car_regis_pro'>
	  <option value='0'>กรุณาเลือก</option>
	    <?php 
	  $tb_pro_sql="SELECT * FROM tb_province";
	  $tb_pro_query=mysql_query($tb_pro_sql,$cndb2);
	  while($tb_pro_array=mysql_fetch_array($tb_pro_query))
	  { ?>
	  <option value="<?php echo $tb_pro_array['id']; ?>" <?php if($tb_pro_array['id']==$q_array['car_regis_pro']){echo "selected";}?>><?php echo $tb_pro_array['name']; ?></option>
	  <?php } ?>
	  </select>
<font color="#FF0000"><b> * </b></font></td>
    </tr>
	<tr>
      <td>เลขตัวถัง</td>
      <td> : 
      		<?php if($q_array['car_body']=="") 
			{ ?>
			<input class="span7" name="car_body" type="text" id="car_body" style="text-transform:uppercase;" onblur="checkText();" />
			<?php } else { ?>
			<input class="span7" name="car_body" type="text" id="car_body" value="<?php echo $q_array['car_body'];?>"  style="text-transform:uppercase;" onblur="checkText();" />
			<?php } ?>
			<font color="#FF0000"><b> * ระบุเลขตัวถัง</b></font>
      </td>
      <td >เลขเครื่อง</td>
      <td colspan='3'>: 
	  <?php if($q_array['n_motor']=="") 
			{ ?>
		<input class="span3" name="n_motor" type="text" id="n_motor" style="text-transform:uppercase;" onblur="checkText2();" />
			<?php } else {?>
	  <input class="span3" name="n_motor" type="text" id="n_motor" value="<?php echo $q_array['n_motor'];?>"  style="text-transform:uppercase;" onblur="checkText2();" />
	  <?php } ?>
	  <font color="#FF0000"><b> * ระบุเลขเครื่องยนต์</b></font></td></tr> 
	  <tr  class="warning">
<td>เกียร์</td>
      <td> : 

	  <select name="gear" size="1" id="gear" class="span7">
        <option value="0">กรุณาเลือก</option>
		<option value="N" <?php if($q_array['gear']=='N'){echo "selected";}?>>ไม่ระบุ</option>
        <option value="A" <?php if($q_array['gear']=='A'){echo "selected";}?>>อัตโนมัติ</option>
        <option value="M" <?php if($q_array['gear']=='M'){echo "selected";}?>>ธรรมดา</option>
      </select>
      <font color="#FF0000"><b> * </b></font></td>
      <td>สีรถ</td>
      <td>: <select name="car_color" id="car_color" style="width:auto;" class="span7" >

	  <option value="0" <?php if($q_array['car_color']==""){echo "selected";} ?>>กรุณาเลือก</option>
		<option value="-" <?php if($q_array['car_color']=="-" || $q_array['car_color']=="ไม่ระบุ"){echo "selected";} ?>>ไม่ระบุ</option>
        <option value="เทา" <?php if($q_array['car_color']=="เทา"){echo "selected";} ?>> เทา </option>
        <option value="เขียว" <?php if($q_array['car_color']=="เขียว"){echo "selected";} ?>> เขียว </option>
        <option value="น้ำเงิน"  <?php if($q_array['car_color']=="น้ำเงิน" || $q_array['car_color']=="นํ้าเงิน"){echo "selected";} ?>> น้ำเงิน </option>
        <option value="แดง" <?php if($q_array['car_color']=="แดง"){echo "selected";} ?>> แดง </option>
        <option value="ขาว" <?php if($q_array['car_color']=="ขาว"){echo "selected";} ?>>ขาว </option>
        <option value="น้ำตาล" <?php if($q_array['car_color']=="น้ำตาล" || $q_array['car_color']=="นํ้าตาล"){echo "selected";} ?>> น้ำตาล </option>
        <option value="ดำ" <?php if($q_array['car_color']=="ดำ" || $q_array['car_color']=="ดํา"){echo "selected";} ?>> ดำ </option>
        <option value="ฟ้า"  <?php if($q_array['car_color']=="ฟ้า"){echo "selected";} ?>> ฟ้า </option>
        <option value="ส้ม" <?php if($q_array['car_color']=="ส้ม"){echo "selected";} ?>>ส้ม</option>
        <option value="บรอนซ์" <?php if($q_array['car_color']=="บรอนซ์"){echo "selected";} ?>>บรอนซ์</option>
        <option value="บรอนซ์เงิน" <?php if($q_array['car_color']=="บรอนซ์เงิน"){echo "selected";} ?>>บรอนซ์เงิน</option>
        <option value="บรอนซ์ทอง" <?php if($q_array['car_color']=="บรอนซ์ทอง"){echo "selected";} ?>>บรอนซ์ทอง</option>
		 <option value="เหลืองดำ" <?php if($q_array['car_color']=="เหลืองดำ" || $q_array['car_color']=="เหลืองดํา"){echo "selected";} ?>>เหลืองดำ</option>
         <option value="ส้มดำ" <?php if($q_array['car_color']=="ส้มดำ" || $q_array['car_color']=="ส้มดํา"){echo "selected";} ?>>ส้มดำ</option>
		 <option value="เหลือง" <?php if($q_array['car_color']=="เหลือง"){echo "selected";} ?>>เหลือง</option>
         <option value="ขาวแดง" <?php if($q_array['car_color']=="ขาวแดง"){echo "selected";} ?>>ขาวแดง</option>
		 <option value="ขาวน้ำเงิน" <?php if($q_array['car_color']=="ขาวนํ้าเงิน" || $q_array['car_color']=="ขาวนํ้าเงิน"){echo "selected";} ?>>ขาวน้ำเงิน</option>

        
        <?php echo $q_array['car_color']; ?>
      

	  </select>
       <font color="#FF0000"><b> * </b></font></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

        </table>
      </div>      </td>
      </tr>
</table>    </td>
    <td class="bg-in">&nbsp;</td>
  </tr>
</table>


</div></div></div></div></div></div></div>
	
	
	
	
	
<!--<div class="widget-box" id='prb_total'>
	<div class="widget-header widget-header-flat"><h4>ข้อมูลประกันภัย (พ.ร.บ.)</h4></div>
		<div class="widget-body">
			<div class="widget-main">
				<div class="row-fluid">
					<div class="span12">
<table class="table">
<tr class="warning">
      <td>เลขที่กรมธรรม์ (พ.ร.บ.) :</td>
      <td colspan="7">
      	<input name="p_act1" type="text" id="p_act1"  style="width:60px;" maxlength="5" value="09712" readonly="readonly" />
        <input name="p_act2" type="text" id="p_act2"style="width:60px;" maxlength="5" value="<?= substr(date("Y")+543,2,2).$_SESSION["saka"]?>" readonly="readonly" />
        
        <!--<select name="p_act3" id="p_act3">
        <option value="0">กรุณาเลือก</option>
		<?
			  	$user = $_SESSION["strUser"];
				mysql_select_db( $database_conn ) or die( "เลือกฐานข้อมูลไม่ได้" );
				$query_act ="SELECT *  FROM z_act WHERE act_use = '".$user."' AND act_status = '1' ORDER BY act_id limit 5";
				$objQuery_act = mysql_query($query_act) or die ("Error Query [".$query_act."]");
				while($row_act = mysql_fetch_array($objQuery_act))
				{
					echo '<option value="'.$row_act['act_no'].'">'.$row_act['act_no'].'</option>';
				}
            ?>
      </select>
        
        <? if($_SESSION["saka"] == '113' || $_SESSION["strUser"] == 'ADMIN'){?>
		<?
			$user = $_SESSION["strUser"];
			mysql_select_db( $database_conn ) or die( "เลือกฐานข้อมูลไม่ได้" );
			$query_act ="SELECT *  FROM z_act WHERE act_use = '".$user."' AND act_status = 'R' AND 	act_return = '' ORDER BY act_id";
			$objQuery_act = mysql_query($query_act) or die ("Error Query [".$query_act."]");
			$row_act = mysql_fetch_array($objQuery_act);
			
			if($row_act['act_no'] == '')
			{
			mysql_select_db( $database_conn ) or die( "เลือกฐานข้อมูลไม่ได้" );
				$query_act ="SELECT *  FROM z_act WHERE act_use = '".$user."' AND act_status = '1' AND act_return = '' ORDER BY act_id";
				$objQuery_act = mysql_query($query_act) or die ("Error Query [".$query_act."]");
				$row_act = mysql_fetch_array($objQuery_act);
			}

		?>
        <input name="p_act3" type="text" id="p_act3" style="width:70px;"  maxlength="7" value="<?=$row_act['act_no'];?>" readonly="readonly" />
        <font color="#FF0000">** ในกรณีที่เลขพรบเป็นค่าว่าง กรุณาติดต่อเจ้าหน้าที่ โทร 085-921-3636, 085-921-5454 **<b></b></font>
        <? }else{ ?>
        	<input name="p_act3" type="text" id="p_act3" style="width:70px;"  maxlength="7" value="" />
            <font color="#FF0000"><b> * เลขที่ พ.ร.บ. อยู่ที่สี่เหลี่ยมสีแดง</b></font> <img src="i/act.jpg" />
        <? } ?>
        
        </td>
      </tr>
   <tr>
      <td>เบี้ยสุทธิ :</td>
      <td>
      	<select class="comment" name="id_prp" id="id_prp" style="width:auto;">
              <option value="0" selected="selected">กรุณาเลือกเบี้ย</option>
            </select>
        <input type="hidden" class="comment" name="txtprp1" id="txtprp1" /></td>
      <td >อากร :</td>
      <td><input type="text" class="comment" name="txtstamp1" id="txtstamp1" style="width:50px;" value="0.00" readonly="readonly" /></td>
      <td >ภาษี :</td>
      <td ><input type="text" class="comment" name="txttax1" id="txttax1" style="width:50px;" value="0.00" readonly="readonly"  /></td>
      <td >เบี้ยรวม :</td>
      <td ><input type="text" class="comment" name="txtnet1" id="txtnet1" style="width:50px;" value="0.00" readonly="readonly"  /></td>
    </tr>
    <tr class="error">
    	<td colspan="8"><font color="#FF0000"><b>กรณี จดทะเบียนเป็นรถรับจ้าง หรือ รถขนส่งผู้โดยสาร กรุณาติดต่อเจ้าหน้าที่ hotline: 085-921-3636, 085-921-5454</b></font></td>
    </tr>
</table>


</div></div></div></div></div>-->

<!-- ยังไม่ใช้
<input type='hidden' name='insu_amt' id='insu_amt_input'>
<input type='hidden' name='human_amt' id='human_amt_input'>
<input type='hidden' name='asset_amt' id='asset_amt_input'>
<input type='hidden' name='drive1_amt' id='drive1_amt_input'>
<input type='hidden' name='passenger' id='passenger_input'>
<input type='hidden' name='passenger_amt' id='passenger_amt_input'>
<input type='hidden' name='medic_amt' id='medic_amt_input'>
<input type='hidden' name='criminal_amt' id='criminal_amt_input'>
<input type='hidden' name='first_damage' id='first_damage_input'>
<input type='hidden' name='first_damage_amt' id='first_damage_amt_input'>
<input type='hidden' name='id_customer' id='id_customer'>-->

<style>
.tab{text-align:left;
padding-left:20px;}

.h6{margin-top:-10px;}
.left{text-align:left;}

.right{margin:0;
text-align:right;
padding-right:30px;}
.inline{display: inline;}
.margin{margin-top:-20px;}
.center{text-align:center;}
.backbg{

background:#3bb9ce;

font-family:Tahoma, Geneva, sans-serif;

font-size:14px;  


color: #fff;

font-weight: bold;

-moz-border-radius: 0px 0px 10px 10px;

-webkit-border-radius: 0px 0px 10px 10px;

-moz-box-shadow: 0 1px 3px rgba(0,0,0,0.5);

-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5);

text-shadow: 0 -1px 1px rgba(0,0,0,0.25);

border-bottom: 1px solid rgba(0,0,0,0.25);


border-left:none;

border-top:none;


}
.shadowbox
{
-webkit-box-shadow: 0px 7px 18px -9px rgba(0,0,0,0.44);
-moz-box-shadow: 0px 7px 18px -9px rgba(0,0,0,0.44);
box-shadow: 0px 7px 18px -9px rgba(0,0,0,0.44);
}


</style>
		<div class="widget-box" id='payment'>
            <div class="widget-header widget-header-flat"> <h4>ข้อมูลความคุ้มครอง&nbsp;<span id='name_print' class='fit'></span></h4></div>
                <div class="widget-body color_eee" align='center'>
                    <div class="widget-main">
                        <div class="row-fluid">
							
							<div class="span12">
							<div class="span4" style='border:solid thin #ccc;'>
								<div class="span12 backbg" ><h5><b>ความรับผิดชอบต่อบุคคลภายนอก</b></h5></div>
									<div class="span12">
									<br>
									<div class='left'>1) ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย</div>
									<div class='tab'>เฉพาะส่วนเกินวงเงินสูงสุดตาม พ.ร.บ.</div>
									<div class="right"><span id='human_amt' class='fit'></span> บาท/คน&nbsp;</div>
									<div class="right"><span class='fit'><b>10,000,000</b></span> บาท/ครั้ง</div>
									<div class="left"><span>2) ความเสียหายต่อทรัพย์สิน</span></div>
									<div class="right"><span id='asset_amt' class='fit'></span> บาท/ครั้ง</div>
									<div class="tab"><span>2.1 ความเสียหายส่วนแรก </span></div>
									<div class="right margin"><span id='' class='fit'>-</span> บาท/ครั้ง</div>
									<br><br><br>
							</div>
							</div>
							
							
							
							<div class="span4" style='border:solid thin #ccc;'>
								<div class="span12 backbg"><h5><b>รถยนต์เสียหาย สูญหาย ไฟไหม้</b></h5></div>
								<div class="span12">
								<br>
								<div class='left'>1) ความเสียหายต่อรถยนต์</div>
								<div class="right"><span id='insu_amt' class='fit'></span> บาท/ครั้ง</div>
								<div class="tab"><span>1.1 ความเสียหายส่วนแรก </span></div>
								<div class="right margin"><span id='first_damage_amt' class='fit'></span> บาท&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
								<div class="left"><span>2) รถยนต์สูญหาย/ไฟไหม้ </span></div>
								
								<div class="right"><span id='asset_dmg' class='fit'></span> บาท/ครั้ง</div>
								<div class="right"><span class='fit'><b>-</b></span> บาท/ครั้ง</div>
								<div class="center"><span><h1>ไม่รวม พ.ร.บ.</h1></span></div>
								<br>
								
							</div>
							</div>
							
							
							<div class="span4" style='border:solid thin #ccc;'>
								<div class="span12 backbg" ><h5><b>ความคุ้มครองตามเอกสารแนบท้าย</b></h5></div>
								<div class="span12">
								<br>
								<div class='left'>1) อุบัติเหตุส่วนบุคคล</div>
								<div class='tab'>1.1 เสียชีวิต สูญเสียอวัยวะ ทุพพลภาพถาวร</div>
								
								<div class='tab'>ก) ผู้ขับขี่ 1 คน</div>
								<div class="right margin"><span id='' class='fit drive1_amt'></span> บาท&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
								<div class='tab'>ข) ผู้โดยสาร <span id='passenger' class='fit'></span> คน</div>
								<div class="right margin"><span id='' class='fit passenger_amt'></span> บาท/คน</div>
								<div class='tab'>1.2) ทุพพลภาพชั่วคราว</div>
								
								<div class='tab'>ก) ผู้โดยสาร 1 คน</div>
								<div class="right margin"><span class='fit'><b>ไม่คุ้มครอง</b></span> บาท/สัปดาห์&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>					
								<div class='tab'>ก) ผู้โดยสาร - คน</div>
								<div class="right margin"><span class='fit'><b>ไม่คุ้มครอง</b></span> บาท/คน/สัปดาห์&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
								<div class='left'>2) ค่ารักษาพยาบาล </div>
								<div class="right margin"><span class='fit'  id='medic_amt'></span> บาท/คน&nbsp;</div>
								<div class='left'>3) การประกันตัวผู้ขับขี่</div>
								<div class="right margin"><span class='fit'  id='criminal_amt'></span> บาท/ครั้ง</div>		
								<br>								
							</div>
							</div>
	
<div class="span12 shadowbox" style="background-color:#FFFFFF; margin-left:0px; padding:20px 30px 20px 30px">
							<span  id='prb_grand_pre'></span></div>
</div></div></div></div></div>

<div class="widget-box">
	<div class="widget-header widget-header-flat"><h4>ข้อมูลผู้เอาประกันภัย</h4></div>
		<div class="widget-body color_eee">
				<div class="widget-main">
						<div class="row-fluid">
							<div class="span12">
<table class="table">

    <tr>
      <td class="comment" colspan="6">ตามกฎหมาย สำนักงานป้องกันและปราบปรามการฟอกเงิน (ปปง.) จำเป็นต้องแสดง เลขบัตรประชาชน / เลขหมายทะเบียนการค้า <img src="images/New_icon.gif" width="25" height="9" /></td>
      </tr>
	  <tr  class="warning">
      <td>
	  <?php if($q_array['c_person']==1) 
	    { ?>
		 <label class="radio-inline"><input name="person" id="person" type="radio" value="1" checked="checked"/> บุคคลธรรมดา</label>
		 <label class="radio-inline"><input name="person" id="persons" type="radio" value="2" /> นิติบุคคล</label>
		<?php } else if($q_array['c_person']==2) { ?>
		 <label class="radio-inline"><input name="person" id="person" type="radio" value="1"/> บุคคลธรรมดา</label>
		<label class="radio-inline"><input name="person" id="persons" type="radio" value="2" checked="checked"/> นิติบุคคล</label>
		<?php } else { ?>
		   <label class="radio-inline"><input name="person" id="person" type="radio" value="1" checked="checked"/> บุคคลธรรมดา</label>
          <label class="radio-inline"><input name="person" id="persons" type="radio" value="2" /> นิติบุคคล</label>
		<?php } ?>

		 </td>
		 <td colspan="5">
		 <?php if($q_array['c_icard']=="" || strlen($q_array['c_icard'])<13) 
		  { ?>
		  <input name="icard" type="text" id="icard" value="<?php echo $q_array['c_icard'];?>" maxlength="13" />
		  <?php } 
		  else 
		  { ?>
		  <input name="icard" type="text" id="icard" value="<?php echo $q_array['c_icard'];?>"  maxlength="13" />
		  <?php } ?>
		<font color="#FF0000"><b> * (กรุณากรอกเฉพาะตัวเลข 13 หลัก)</b></font>
        </td>
      </tr>
		<tr>
      <td>คำนำหน้าชื่อ :</td>
      <td>
        <select id="title" name="title">
		<?php if($q_array['c_title']==""){ ?>
		<option value="0">กรุณาเลือก</option>
		<?php } else { ?>
		<option value="<?php echo $q_array['c_title']; ?>"><?php echo $q_array['c_title']; ?></option>
		<?php } ?>
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
		  
        </select><font color="#FF0000"><b> * </b></font></td>
      <td>ชื่อ :</td>
      <td>
	  <?php if($q_array['c_name']=="") { ?>
	  <input type="text" name="name_name" id="name_name" size="25" maxlength="100" />
	  <?php  } else { ?>
	  <input type="text" name="name_name" id="name_name" value="<?php echo $q_array['c_name']; ?>"  size="25" maxlength="100" />
	  <?php } ?>
	  <font color="#FF0000"><b> * </b></font></td>
      <td>นามสกุล :</td>
      <td>
	  <?php if($q_array['c_last']=="") { ?>
	  <input type="text" name="last" id="last" size="25" maxlength="50" />
	  <?php } else { ?>
	  <input type="text" name="last" id="last" value="<?php echo $q_array['c_last']; ?>"  size="25" maxlength="50" />
	  <?php } ?>
	  
	  <font color="#FF0000"><b> * </b></font></td>
    </tr>
	  <tr class="warning">
      <td>บ้านเลขที่ :</td>  
      <td>
	  <?php if($q_array['add']=="") 
	   { ?>
	   <input type="text" id="add" maxlength="30" class="span5" name="add" />
	   <?php } else { ?>
	   <input type="text" id="add" maxlength="30" value="<?php echo $q_array['add'];?>" class="span5" name="add"  />
	   <?php } ?>
	  
	  <font color="#FF0000"><b> * </b></font>
	  &nbsp;&nbsp; หมู่&nbsp; 
	  <?php if($q_array['group']=="") 
	   { ?>
	  <input type="text" name="group" id="group" size="3" class="span2" maxlength="4" />
	  <?php } else { ?>
	  <input type="text" name="group" id="group" size="3" class="span2" value="<?php echo $q_array['group'];?>"  maxlength="4" />
	  <?php } ?>
	  </td>
      <td>อาคาร/หมู่บ้าน</td>
      <td> 
	  <?php if($q_array['town']=="") 
	  { ?>
	  <input type="text" name="town" id="town" size="25" maxlength="50" autocomplete="OFF" />
	  <?php } else { ?>
	  <input type="text" name="town" id="town" size="25" value="<?php echo  $q_array['town'];?>" maxlength="50" autocomplete="OFF" />
	  <?php } ?>
	  </td>
      <td>ซอย :</td>
      <td> 
	  <?php if($q_array['lane']=="") 
	  { ?>
	  	  <input type="text" name="lane" id="lane" size="25" maxlength="50" /></td>
	  <?php } else { ?>
	  	  <input type="text" name="lane" id="lane" size="25" value="<?php echo $q_array['lane'];?>" maxlength="50" /></td>
	  <?php } ?>

    </tr>
    <tr>
      <td>ถนน :</td>
      <td>
	  <?php if($q_array['road']=="") { ?>
	  <input type="text" id="road" maxlength="50" size="20" name="road" />
	  <?php } else { ?>
	  <input type="text" id="road" maxlength="50" size="20" value="<?php echo $q_array['road'];?>"  name="road" />
	  <?php } ?>
	  </td>
      <td>เบอร์โทรศัพท์บ้าน :</td>
      <td>
	  <?php if($q_array['tel_home']=="") { ?>
	  <input type="text" name="tel_home" id="tel_home" size="25" maxlength="20" />
	  <?php } else { ?>
	  <input type="text" name="tel_home" id="tel_home" value="<?php echo  $q_array['tel_home'];?>"  size="25" maxlength="20" />
	  <?php } ?>
	  </td>
      <td>เบอร์มือถือลูกค้า :</td>
      <td>
	  <?php if($q_array['tel_mobile']!="") { ?>
	  
	  <?php if($q_array['tel_mobile']=="") { ?>
	  <input placeholder="กรอกเบอร์มือถือ" id="tel_mobi" type="text" maxlength="13" class="span5" name="tel_mobi"/>
	  <?php }  else {?>
	  <input placeholder="กรอกเบอร์มือถือ" id="tel_mobi" type="text" maxlength="13" value="<?php echo  $q_array['tel_mobile']; ?>"  class="span5" name="tel_mobi"/>
	  <?php } ?>
	  
	  <?php }  else if ($q_array['tel_mobile2']!="") { ?>
	  
	  <?php if($q_array['tel_mobile2']=="") { ?>
	  <input placeholder="กรอกเบอร์มือถือ" id="tel_mobi" type="text" maxlength="13"  class="span5" name="tel_mobi"/>
	  <?php  } else { ?>
	  <input placeholder="กรอกเบอร์มือถือ" id="tel_mobi" type="text" maxlength="13" value="<?php echo  $q_array['tel_mobile2']; ?>" class="span5" name="tel_mobi"/>
	  <?php }  } else { ?>
	  <input placeholder="กรอกเบอร์มือถือ" id="tel_mobi" type="text" maxlength="13"  class="span5" name="tel_mobi"/>
	  <?php } ?>
	  
	  <font color="#FF0000"><b> * </b></font></td>
    </tr>
	 <tr class="warning">
     <td>E - mail ลูกค้า :</td>
      <td>
	  <?php if($q_array['email']=="") 
	   { ?>
	   <input placeholder="กรอกอีเมล์" name="email" class="span6" type="text" id="email" size="20" />
	   <?php } else {?>
	   <input placeholder="กรอกอีเมล์" name="email" class="span6" type="text" value="<?php echo $q_array['email'];?>" id="email" size="20" />
	   <?php } ?>
	  <font color="#FF0000"><b> * </b></font></td>
	  
	  
      <td>จังหวัด :</td>
      <td> 
	  <?php 
	  mysql_select_db($db2,$cndb2);
	  
	  $tum_sql="SELECT * FROM tb_tumbon WHERE id = '".$q_array['tumbon']."'";
	  $tum_query=mysql_query($tum_sql,$cndb2);
	  $tum_array=mysql_fetch_array($tum_query);
	  
	  $am_sql="SELECT * FROM tb_amphur WHERE id = '".$q_array['amphur']."'";
	   $am_query=mysql_query($am_sql,$cndb2);
	   $am_array=mysql_fetch_array($am_query);
	   
	  $pro_sql="SELECT * FROM tb_province WHERE id = '".$q_array['province']."'";
	   $pro_query=mysql_query($pro_sql,$cndb2);
	   $pro_array=mysql_fetch_array($pro_query);
	  ?>
	  <span id="provinceDiv">
	  <select name="province" id="province">
	  <option value="0">กรุณาเลือก</option>
	  <?php 
	  	  $spr_sql="SELECT * FROM tb_province";
	   $spr_query=mysql_query($spr_sql,$cndb2);
	  while($spr_array=mysql_fetch_array($spr_query))
	  { ?>
	  <option value="<?php echo $spr_array['id']; ?>" <?php if($spr_array['id']==$q_array['province']){echo "selected";} ?>><?php echo $spr_array['name']; ?></option>
	  <?php } ?>
	  </select></span>
<font color="#FF0000"><b> * </b></font></td>
      <td>อำเภอ :</td>
      <td>

	  <span id="amphurDiv"><select name="amphur" id="amphur" >
	  <option value="0">กรุณาเลือก</option>
	  <?php 
	  	  $sam_sql="SELECT * FROM tb_amphur WHERE provinceID = '".$q_array['province']."'";
	   $sam_query=mysql_query($sam_sql,$cndb2);
	  while($sam_array=mysql_fetch_array($sam_query))
	  { ?>
	  <option value="<?php echo $sam_array['id'];?>" <?php if($sam_array['id']==$q_array['amphur']){echo "selected";} ?>><?php echo $sam_array['name'];?></option>
	  <?php } ?>
	  </select></span>

	  <font color="#FF0000"><b> * </b></font></td>
    </tr>
    <tr>
      <td>ตำบล :</td>
      <td>
	  <span id="tumbonDiv"><select name="tumbon" id="tumbon">
	  <option value="0">กรุณาเลือก</option>
	  <?php 
	  $stum_sql="SELECT * FROM tb_tumbon WHERE id > '0' AND amphurID = '".$q_array['amphur']."'";
	  $stum_query=mysql_query($stum_sql,$cndb2);
	  while($stum_array=mysql_fetch_array($stum_query))
	  { ?>
	  <option value="<?php echo $stum_array['id'];?>" <?php if($stum_array['id']==$q_array['tumbon']){echo "selected";} ?>><?php echo $stum_array['name'];?></option>
	  <?php } ?>
	  </select></span>

	<font color="#FF0000"><b> * </b></font></td>
      <td>รหัสไปรษณีย์ :</td>
      <td>
	  
	  
	  <?php if($q_array['postal']=="" || $q_array['postal']==0) { ?>
	  <span id="id_postDiv"><select name="id_post" id="id_post">
		<?php if(!empty($tum_array['id'])) 
		{ ?>
		<option value="<?php echo $tum_array['id_post'];?>"><?php echo $tum_array['id_post'];?></option>
		<?php } else { ?>
	  <option value="0">กรุณาเลือก</option>
	  <?php } ?>
	  
	  </select></span>
	  <?php } else { ?>
	  <span id="id_postDiv"><select name="id_post" id="id_post"><option value="<?php echo $q_array['postal']; ?>"><?php echo $q_array['postal']; ?></option></select></span>
	  <?php } ?>
	  
	  
	  <font color="#FF0000"><b> * </b></font></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

		<tr class="error" ><td colspan="10" style="color:red;">*    กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนทำการบันทึก มิฉะนั้นข้อมูลจะไม่สมบูรณ์</td></tr>

</table>

</div></div></div></div></div>

<button class="btn btn-large btn-primary" type="button" id="SaveInsurance" name="SaveInsurance"><i class="icon-upload"></i>แจ้งประกันภัยรถยนต์</button>
<button class="btn btn-large btn-warning" type="reset" name="BcloseIn" id="BcloseIn"><i class="icon-refresh"></i>เริ่มใหม่</button>
</form>
</div>

<? mysql_close(); ?>

<script language="javascript">

$( document ).ready(function() {

	$('#icard').mask("9999999999999");
	$('#tel_mobi').mask("999-999-9999");

    $('#start_date').datepicker(
	{
		format: "dd/mm/yyyy",
		startDate: "today",
		language: "th",
		autoclose: true,

	});

	
	var Dyy = $('#Dyy').val();
	regis_date = $("#regis_date");
	$("#regis_date").empty();
	regis_date.append("<option value='N'>--- กรุณาเลือกปีรถ ---</option>");
	for (i = Dyy-14; i <=Dyy; i++){ regis_date.append("<option value='"+i+"'>"+i+"</option>"); }

});
/*function prb_total()
{
$.post("ajax/ajax_payment_prb.php",{q_auto:$('#q_auto').val()},function(data){$('#prb_grand').html(data)}) ;
}*/
prb_total();
function prb_total()
{
var payment = {
url:"ajax/ajax_payment_prb.php",
type:"post",
dataType:"json",
data:{
q_auto:$('#q_auto').val()
},
success:function(data)
{
var arraypayment = data;
if(arraypayment.check!="")
{
$("#payment").slideDown();
$(".fit").show();
}
else
{
$("#payment").slideUp();
$(".fit").hide();
}
if(arraypayment.first_damage == "" || arraypayment.first_damage == "ไม่มี" || arraypayment.first_damage == null)
{
$('#first_damage_amt').hide();

}
else
{
$('#first_damage_amt').show();

}
$('#prb_grand').html(arraypayment.grand);
$('#prb_grand_pre').html(arraypayment.grand_prb);
//value
/*$('#insu_amt_input').val(arraypayment.insu_amt);
$('#human_amt_input').val(arraypayment.human_amt);
$('#asset_amt_input').val(arraypayment.asset_amt);
$('#drive1_amt_input').val(arraypayment.drive1_amt);
$('#passenger_input').val(arraypayment.passenger);
$('#passenger_amt_input').val(arraypayment.passenger_amt);
$('#medic_amt_input').val(arraypayment.medic_amt);
$('#criminal_amt_input').val(arraypayment.criminal_amt);
$('#first_damage_input').val(arraypayment.first_damage);
$('#first_damage_amt_input').val(arraypayment.first_damage_amt);
$('#id_customer').val(arraypayment.id_customer);*/
//html
$('#insu_amt').html("<b>"+arraypayment.insu_amt+"</b>");
$('#human_amt').html("<b>"+arraypayment.human_amt+"</b>");
$('#asset_amt').html("<b>"+arraypayment.asset_amt+"</b>");
$('.drive1_amt').html("<b>"+arraypayment.drive1_amt+"</b>");
$('#passenger').html(arraypayment.passenger);
$('.passenger_amt').html("<b>"+arraypayment.passenger_amt+"</b>");
$('#medic_amt').html("<b>"+arraypayment.medic_amt+"</b>");
$('#criminal_amt').html("<b>"+arraypayment.criminal_amt+"</b>");
$('#first_damage').html("<b>"+arraypayment.first_damage+"</b>");
$('#first_damage_amt').html("<b>"+arraypayment.first_damage_amt+"</b>");
$('#name_print').html("<b>("+arraypayment.name_print+")</b>");
$('#asset_dmg').html("<b>"+arraypayment.asset_dmg+"</b>");
$('#car_cc').html(arraypayment.car_cc);
$('#car_wgt').html(arraypayment.car_wgt);
}
};
$.ajax(payment);
}
$('.fit').hide();
$("#payment").hide();
$('#prb_total').hide();
</script>