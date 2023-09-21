<?php
	include "check-ses.php"; 
	include "../inc/connectdbs.inc.php"; 
	mysql_select_db($db1,$cndb1);
	header('Content-Type: text/html; charset=utf-8');
	$select_sql="SELECT 
	act.p_act,
	act.p_pre,
	act.p_stamp,
	act.p_tax,
	act.p_net,
	data.login,
	data.start_date,
	data.name_gain,
	data.com_data,
	detail.car_id,
	detail.cat_car,
	tb_cat_car.name As cat_car_name,
	detail.mo_car As mo_car_id,
	detail.car_cc,
	detail.car_seat,
	detail.car_wgt,
	detail.gear,
	detail.regis_date,
	detail.car_regis_pro,
	detail.car_color,
	detail.car_body,
	detail.n_motor,
	detail.car_color,
	detail.mo_sub,
	detail.code_addon,
	detail.code_addon_id,
	detail.car_detail,
	data.costCost,
	insuree.title,
	insuree.name,
	insuree.last,
	insuree.person,
	insuree.career,
	insuree.add,
	insuree.group,
	insuree.town,
	insuree.lane,
	insuree.road,
	insuree.tumbon,
	insuree.amphur,
	insuree.province,
	insuree.postal,
	insuree.icard_niti,
	insuree.icard,
	insuree.vocation,
	insuree.SendAdd,
	insuree.status_SendAdd,
	insuree.tel_home,
	insuree.tel_mobi,
	insuree.email,
	tb_cost.cost,
	tb_cost.pre,
	tb_cost.stamp,
	tb_cost.tax,
	tb_cost.net
	FROM data
	LEFT JOIN act ON (data.id_data = act.id_data)
	LEFT JOIN detail ON (data.id_data = detail.id_data)
	LEFT JOIN driver ON (data.id_data = driver.id_data)
	LEFT JOIN insuree ON (data.id_data = insuree.id_data)
	LEFT JOIN protect ON (data.id_data = protect.id_data)
	LEFT JOIN tb_cat_car ON (detail.cat_car = tb_cat_car.id)
	LEFT JOIN tb_cost ON (data.costCost = tb_cost.id)
	WHERE data.id_data = '".$_POST['id_data']."'";
	$select_query=mysql_query($select_sql,$cndb1);
	$select_array=mysql_fetch_array($select_query);
?>	

<script src="js/js_Insurance.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/cupertino/jquery-ui-1.9.2.custom.min.css" />
<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />

<script type="text/javascript" language="javascript">
(function($)
{
	$.fn.blink = function(options)
	{
		var defaults = { delay:500 };
		var options = $.extend(defaults, options);
		
		return this.each(function()	
		{
			var obj = $(this);
			setInterval(function()
			{
				if($(obj).css("visibility") == "visible")
				{
					$(obj).css('visibility','hidden');
				}
				else
				{
					$(obj).css('visibility','visible');
				}
			}, options.delay);
		});
	}
}(jQuery))

$(document).ready(function()
{
	$('.blink').blink();	
});

</script>

<script language="javascript">

$( document ).ready(function() {

	$('#icard').mask("9999999999999");
	$('#tel_mobi').mask("999-999-9999");
	$('#car_body').mask("99999999");

    $('#start_date').datepicker(
	{
		format: "dd/mm/yyyy",
		startDate: "today",
		language: "th",
		autoclose: true
	});
  $('#page-content').css({
    'background-color':'#eee'
  });
  
});

</script>


<div style="margin-left:auto;margin-right:auto;" class="row-fluid">

	<?
		$paymentDate = date("Y-m-d H:i:s"); // เวลาปัจจุบัน
		$contractDateBegin = "2016-04-1 00:00:00"; // เริ่ม
		$contractDateEnd = "2016-04-17 23:59:59"; // สิ้นสุด
		
	 	if ($paymentDate > $contractDateBegin && $paymentDate < $contractDateEnd)
		{
	 ?>
     		<script>
				$(function() 
				{
					$( "#dialog" ).dialog({
					resizable: false,
					width:800,
					height:625,
					modal: true
					});
				});
			</script>
     		<div id="dialog" title="สวัสดีปีใหม่ไทย ๒๕๕๙">
              <img src="images/songkran_2016.png" width="800" />
            </div>
    <?
     	}
	?>
    
<form name="Insurance" id="Insurance">
    <div id="showSQL"></div>
<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
		
            <div class="widget-header widget-header-flat"> <h4>ข้อมูลทั่วไป</h4><a type='button' class='btn btn-small btn-inverse' onclick='cross_inform();' style='float:right;'>X</a></div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row-fluid">
                            <div class="span12">
     <input name="insureYear" type="hidden" id="insureYear" value="1" readonly = 'true' />                    
	 <input name="ty_prot" type="hidden" id="ty_prot" value="<?php print $ty_prot; ?>" />
     <input name="send_date" type="hidden" id="send_date" size="40"  maxlength="10" readonly="true" value="<?=date("Y-m-d H:i"); ?>" />
     <input name="xuser" type="hidden" id="xuser" value="<?=$_SESSION["strUser"];?>" />
     <input name="xUserName" type="hidden" id="xUserName" value="<?=$_SESSION["strPass"];?>" />
     <input name="name_inform" type="hidden" id="name_inform" size="40"  maxlength="40" readonly="true" value="<?=$_SESSION["strName"];?>" />
     <input type="hidden" name="doc_type" id="doc_type" value="1" />
<table class="table">
<tr>
	<td><font color = 'red'>ประเภทประกันภัย</font></td>
	<td colspan = '5'> : 
    <input id = 'insureYear1' name = 'insureYear_select' type = 'radio' value = '1' checked="checked" /> ประกันภัย 1 ปี &nbsp; 
    <input id = 'insureYear2' name = 'insureYear_select' type = 'radio' value = '2' /> ประกันภัยระยะยาว 2 ปี &nbsp; 
<!--    <input id = 'insureYear4' onclick="load_page('pages/load_NewAct.php','แจ้งประกันภัยอื่นๆ');" name = 'insureYear_select' type = 'radio' value = '4' /> ประกันภัย อื่น ๆ-->
    <a class="btn btn-small btn-info" href="#" onclick="load_page('pages/load_NewAct.php','แจ้งประกันภัยอื่นๆ');"><i class="icon-download"></i> ประกันภัย อื่น ๆ</a>
    <!--<input id = 'insureYear3' name = 'insureYear_select' type = 'radio' value = '3' /> ประกันภัยระยะยาว 3 ปี-->
  </td>
</tr>
<?
		if($_SESSION["strUser"] == "admin"){
?>
<tr>
<td>สาขาแจ้งงาน</td>
<td colspan = '5'> : 
	<select name="Dxuser" id="Dxuser">
        <option value="0" selected="selected">กรุณาเลือกชื่อผู้แจ้ง</option>
        <?php
			  	$query_D ="SELECT * FROM `tb_customer` WHERE `nameuser` = 'Mitsubishi' GROUP BY `tb_customer`.`user` ORDER BY `tb_customer`.`user` ASC"; // id = '1' 
				$objQueryD = mysql_query($query_D,$cndb1) or die ("Error Query [".$query_D."]");
				while($objResultD = mysql_fetch_array($objQueryD))
				{
					if($objResultD['user']==$select_array['login'])
					{
						$selected="selected";
					}
					else
					{
						$selected="";
					}
					echo '<option value="'.$objResultD['user'].'" '.$selected.'>'.'['.$objResultD['user'].'] '.$objResultD['sub'].'</option>';
				}
            ?>
      </select>
</td>
</tr><? } ?>
<tr>
<td>วันที่คุ้มครอง</td>
<td> : 
<?php
list($yy,$mm,$dd) = explode('-',$select_array['start_date']);
$start_date=$dd.'/'.$mm.'/'.$yy;
if(strlen($select_array['car_id'])==4)
	{
	$pass_car_id=substr($select_array['car_id'],0,2);
	$pass_car_type_id=substr($select_array['car_id'],2,2);
	}
	else
	{
		$pass_car_id=substr($select_array['car_id'],0,1);
		$pass_car_type_id=substr($select_array['car_id'],1,2);
	}
?>
<input name="start_date" type="text" id="start_date" class="span6" value="<?=$start_date?>" readonly="readonly" /><font color="#FF0000"><b> * (วัน/เดือน/ปี)</b></font></td>
<td>ประเภทการใช้</td>
<td> : <span id="cartypeDiv">
	<select name="cartype" id="cartype"  class="span7">
	<?php 
	$tb_pass_car_sql="SELECT * FROM `tb_pass_car` WHERE `id` = '".$pass_car_id."'";
	$tb_pass_car_query=mysql_query($tb_pass_car_sql,$cndb1);
	$tb_pass_car_array=mysql_fetch_array($tb_pass_car_query);
	
	if(!empty($tb_pass_car_array))
	{ ?>
	<option value="<?=$tb_pass_car_array['id']?>"><?=$tb_pass_car_array['id']." : ".$tb_pass_car_array['name']?></option>
	<?php } else { ?>
	<option value="0">กรุณาเลือก</option>
	<?php } ?>
	</select></span>
     <font color="#FF0000"><b> * </b></font></td>
	  <td>ลักษณะใช้งาน</td>
      <td> : 
	  <span id="car_idDiv">
	  <select name="car_id" id="car_id" class="span10" >
	  <?php
		$tb_pass_car_type_sql="SELECT * FROM `tb_pass_car_type` WHERE `id` = '".$pass_car_type_id."'";
		$tb_pass_car_type_query=mysql_query($tb_pass_car_type_sql,$cndb1);
		$tb_pass_car_type_array=mysql_fetch_array($tb_pass_car_type_query);
	 if(!empty($tb_pass_car_type_array))
	{ ?>
	<option value="<?=$tb_pass_car_type_array['id']?>"><?=$tb_pass_car_type_array['id']." : ".$tb_pass_car_type_array['name']?></option>
	<?php } else { ?>
	<option value="0">กรุณาเลือก</option>
	<?php } ?>
	  </select>
	  </span>
      <font color="#FF0000"><b> * </b></font></td>
</tr>
   <tr>
      <td>ประเภทรถ</td>
      <td> : <span id="cat_carDiv">
	  <select name="cat_car" id="cat_car" class="span7" >
	  <?php
		$tb_cat_car_sql="SELECT * FROM tb_cat_car WHERE idcartype = '".$pass_car_id."'";
		$tb_cat_car_query=mysql_query($tb_cat_car_sql,$cndb1);
		$tb_cat_car_array=mysql_fetch_array($tb_cat_car_query);
		if(!empty($tb_cat_car_array))
		{ ?>
			<option value="<?=$tb_cat_car_array['idcartype']?>"><?=$tb_cat_car_array['name']?></option>
		<?php }
		else
		{ ?>
	  <option value="0">กรุณาเลือก</option>
		<?php } ?>
	  </select>
	  </span><font color="#FF0000"><b> * </b></font></td>
      <td>ยี่ห้อรถ</td>
      <td> : <span id="br_carDiv">
	  <select name="br_car" id="br_car" class="span7" >
	  <?php
		$select_br_car_sql="SELECT * FROM tb_br_car WHERE name = 'Mitsubishi' AND cat_id = '".$tb_cat_car_array['id']."'";
		$select_br_car_query=mysql_query($select_br_car_sql,$cndb1);
		$select_br_car_array=mysql_fetch_array($select_br_car_query);
		if(!empty($select_br_car_array))
		{ ?>
		<option value="<?=$select_br_car_array['id']?>"><?=$select_br_car_array['name']?></option>
	<?php } else { ?>
		<option value="0">กรุณาเลือก</option>
		<?php } ?>
	  </select>
	  </span>
	  <font color="#FF0000"><b> * </b></font></td>
      <td>รุ่นรถ</td>
      <td> : <span id="mo_carDiv">
	  <select name="mo_car" id="mo_car" class="span5">
	   <?php
		$select_mo_sub_sql="SELECT * FROM tb_mo_car WHERE br_id = '".$select_br_car_array['id']."' AND status = 'T'";
		$select_mo_sub_query=mysql_query($select_mo_sub_sql,$cndb1);
		?>		
	<option value="0">กรุณาเลือก</option>
	<?php while($select_mo_sub_array=mysql_fetch_array($select_mo_sub_query))
	{ ?>
	<option value="<?=$select_mo_sub_array['id']?>" <?php if($select_mo_sub_array['id']==$select_array['mo_car_id']){echo "selected";}?>><?=$select_mo_sub_array['name']?></option>
	<?php } ?>
	  </select>
	  </span>
	  <?php
	  if(!empty($select_array['mo_sub']))
	  {
		  $mo_devshow='';
	  }
	  else
	  {
		    $mo_devshow='display:none;';
	  }
	  ?>
	  <span id='mo_dev' style="<?=$mo_devshow?>">
	  <select name="mo_car_sub" id="mo_car_sub" class="span5" style="<?=$mo_devshow?>" onchange='mo_sub_start()'>
	  <option value="0">กรุณาเลือกรุ่นรถย่อย</option>
	  <?php 
	  $select_mo_sub_sql="SELECT * FROM tb_mo_car_sub WHERE status_subcar = 'T' AND mo_car = '".$select_array['mo_car_id']."'";
	  $select_mo_sub_query=mysql_query($select_mo_sub_sql,$cndb1);
	  while($select_mo_sub_array=mysql_fetch_array($select_mo_sub_query))
	  { ?>
	<option value="<?=$select_mo_sub_array['id']?>" <?php if($select_mo_sub_array['id']==$select_array['mo_sub']){echo "selected";}?>><?=$select_mo_sub_array['name']?></option>
	  <?php } ?>
	  </select></span><font color="#FF0000"><b> * </b></font></td>
    </tr>
	 <tr>
      <td>จำนวน ซี.ซี.</td>
      <td> : <select name="car_cc" id="car_cc" class="span7" >
		  <option value="0" selected="selected">กรุณาเลือก</option>
          <option value="1" <?php if($select_array['car_cc']==1){echo "selected";}?>>ต่ำกว่า 2000 cc</option>
          <option value="2" <?php if($select_array['car_cc']==2){echo "selected";}?>>มากกว่า 2000 cc</option>
        </select><font color="#FF0000"><b> * </b></font></td>
      <td>น้ำหนัก</td>
      <td> : <select name="car_wgt" id="car_wgt" class="span7">
  <option value="<?=$select_array['car_wgt']?>" selected="selected"><?=$select_array['car_wgt']?></option>
</select><font color="#FF0000"><b> * </b></font></td>
      <td>จำนวนที่นั่ง</td>
      <td> : <select name="car_seat" id="car_seat" class="span7">
		<?php if(!empty($select_array['car_seat'])) {?>
		<option value="<?=$select_array['car_seat']?>" selected="selected"><?=$select_array['car_seat']?></option>
		<?php } else { ?>
        <option value="0" selected="selected">กรุณาเลือก</option>
		<?php } ?>
        <option value="3">ไม่เกิน 3 ที่นั่ง</option>
        <option value="7">ไม่เกิน 7 ที่นั่ง</option>
      </select> 
        <font color="#FF0000"><b> * </b></font></td>
    </tr>
	<tr>
      <td>เกียร์</td>
      <td> : <select name="gear" size="1" id="gear" class="span7">
	  
		<?php if(!empty($select_array['gear'])){
			if($select_array['gear']=='A')
			{
				$name_gear = 'อัตโนมัติ';
			}
			else
			{
				$name_gear = 'ธรรมดา';
			}
		?>
		
		<option value="<?=$select_array['gear']?>" selected="selected"><?=$name_gear?></option>
		<?php } else { ?>
        <option value="0" selected="selected">กรุณาเลือก</option>
		<?php } ?>
        <option value="A">อัตโนมัติ</option>
        <option value="M">ธรรมดา</option>
      </select>
      <font color="#FF0000"><b> * </b></font></td>
      <td>ทะเบียนรถ</td>
      <td> : <input readonly="true" name="car_regis" type="text" id="car_regis" value="ป้ายแดง" size="10" maxlength="8" class="span7" />
      
    <input name="car_regis_text" type="hidden" id="car_regis_text" value="-" size="10" maxlength="8" class="span7" />      </td>
      <td>ปีจดทะเบียน</td>
      <td> : <select name="regis_date" id="regis_date" onchange="javascript:showCarAge();">
	  <?php if(!empty($select_array['regis_date'])){ ?>
	<option selected="selected"><?=$select_array['regis_date']?></option>
	  <?php }else{ ?>
    <option selected="selected"><?=date('Y')?></option>
	  <?php } ?>
      </select></td>
    </tr>
	<tr>
      <td>เลขตัวถัง</td>
      <td> : 
	  <?php 
	  $car_body1=substr($select_array['car_body'],0,9);
	  $car_body2=substr($select_array['car_body'],9);
	  ?>
	  <input name="new_carbody" type="text" id="new_carbody" style=" width:100px;" value='<?=$car_body1?>' readonly="true"  /><input name="car_body" type="text" id="car_body" style=" width:92px;" maxlength="8" value='<?=$car_body2?>' ><font color="#FF0000"><b> * ระบุเลข 8 ตัวหลัง</b></font></td>
      <td>เลขเครื่อง</td>
      <td colspan="">: 
	  <?php list($motor1,$motor2) = explode('-',$select_array['n_motor']);?>
	  <input name="new_motor" type="text" id="new_motor" style=" width:100px;" value='<?=$motor1?>' readonly="true"/> - <input name="n_motor" type="text" id="n_motor" style=" width:100px;" maxlength="15"  value='<?=$motor2?>'>
        <font color="#FF0000"><b> * ระบุเลขตัวหลัง</b></font></td>
		<?php if($_SESSION['strUser']!='admin'){ ?>

		<td>ทุน</td>
		<td colspan="2">
		<font color="#FF0000" size='3' class="span7" id="cost_array"><?=$select_array['cost']?></font>
		</td>
		<?php } ?>
      </tr> 
	  <tr>
      <td>จังหวัดทะเบียนรถ</td>
      <td>: 
	  <select class="span7" name='car_regis_pro' id='car_regis_pro'>
	  <?php
	  $regis_pro_sql="SELECT * FROM tb_province WHERE id = '".$select_array['car_regis_pro']."'";
	  $regis_pro_query=mysql_query($regis_pro_sql,$cndb1);
	  $regis_pro_array=mysql_fetch_array($regis_pro_query);
	  if(!empty($regis_pro_array))
	  { 
  ?>
		<option value='<?=$regis_pro_array['id']?>'><?=$regis_pro_array['name']?></option>
	  <?php } ?>
	</select>
	
<font color="#FF0000"><b> * </b></font></td>
      <td>สีรถ</td>
      <td>: 
        <select name="car_color" id="car_color" style="width:auto;" class="span7" >
        <option value="0" <?php if($select_array['car_color']=='ไม่ระบุ'){echo "selected";}?> >ไม่ระบุ</option>
        <option value="เทา" <?php if($select_array['car_color']=='เทา'){echo "selected";}?> > เทา </option>
        <option value="เขียว" <?php if($select_array['car_color']=='เขียว'){echo "selected";}?>> เขียว </option>
        <option value="น้ำเงิน" <?php if($select_array['car_color']=='น้ำเงิน'){echo "selected";}?>> น้ำเงิน </option>
        <option value="แดง" <?php if($select_array['car_color']=='แดง'){echo "selected";}?>> แดง </option>
        <option value="ขาว" <?php if($select_array['car_color']=='ขาว'){echo "selected";}?>>ขาว </option>
        <option value="น้ำตาล" <?php if($select_array['car_color']=='น้ำตาล'){echo "selected";}?>> น้ำตาล </option>
        <option value="ดำ" <?php if($select_array['car_color']=='ดำ'){echo "selected";}?>> ดำ </option>
        <option value="ฟ้า" <?php if($select_array['car_color']=='ฟ้า'){echo "selected";}?>> ฟ้า </option>
        <option value="ส้ม" <?php if($select_array['car_color']=='ส้ม'){echo "selected";}?>>ส้ม</option>
        <option value="บรอนซ์" <?php if($select_array['car_color']=='บรอนซ์'){echo "selected";}?>>บรอนซ์</option>
        <option value="บรอนซ์เงิน" <?php if($select_array['car_color']=='บรอนซ์เงิน'){echo "selected";}?>>บรอนซ์เงิน</option>
        <option value="บรอนซ์ทอง" <?php if($select_array['car_color']=='บรอนซ์ทอง'){echo "selected";}?>>บรอนซ์ทอง</option>
        <option value="ส้มดำ" <?php if($select_array['car_color']=='ส้มดำ'){echo "selected";}?>>ส้มดำ</option>
	<option value="เหลือง" <?php if($select_array['car_color']=='เหลือง'){echo "selected";}?>>เหลือง</option>
            <option value="ชมพู" <?php if($select_array['car_color']=='ชมพู'){echo "selected";}?>>ชมพู</option>
            <option value="ม่วง" <?php if($select_array['car_color']=='ม่วง'){echo "selected";}?>>ม่วง</option>
            <option value="ขาวมุก" <?php if($select_array['car_color']=='ขาวมุก'){echo "selected";}?>>ขาวมุก</option>
            <option value="เทาดำ" <?php if($select_array['car_color']=='เทาดำ'){echo "selected";}?>>เทาดำ</option>
            <option value="ครีม" <?php if($select_array['car_color']=='ครีม'){echo "selected";}?>>ครีม</option>
            <option value="ดำแดง" <?php if($select_array['car_color']=='ดำแดง'){echo "selected";}?>>ดำแดง</option>
            <option value="ดำเหลือง" <?php if($select_array['car_color']=='ดำเหลือง'){echo "selected";}?>>ดำเหลือง</option>
            <option value="แดงเหลือง" <?php if($select_array['car_color']=='แดงเหลือง'){echo "selected";}?>>แดงเหลือง</option>
            <option value="แดงขาว" <?php if($select_array['car_color']=='แดงขาว'){echo "selected";}?>>แดงขาว</option>
      </select>
       <font color="#FF0000"><b> * </b></font></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	   <tr>
      <td>ผู้รับผลประโยชน์</td>
      <td colspan="5">: <select name="name_gain" id="name_gain" style="width:auto;" class="span7">
		<?php
		if(!empty($select_array['name_gain']))
		{ ?>
	<option value='<?=$select_array['name_gain']?>'><?=$select_array['name_gain']?></option>
		<?php } ?>
        <option value="0">กรุณาเลือกชื่อผู้รับผลประโยชน์</option>
        <option value="ไม่ระบุ">ไม่ระบุ</option>
        <?php 
                $query_accessories ="SELECT * FROM `tb_heiress` ORDER BY `tb_heiress`.`id` ASC"; // id = '1' 
$objQuery = mysql_query($query_accessories,$cndb1) or die ("Error Query [".$query."]");
//echo '<option value="ไม่ระบุ">ไม่ระบุ</option>';
while($objResult = mysql_fetch_array($objQuery))
{
echo '<option value="'.$objResult['name'].'">'.$objResult['name'].'</option>';
}
            ?>
      </select><font color="#FF0000"><b> * </b></font>      </td>
      </tr>


<!-- ผู้ขับขี่       - -->
	  <tr style="display:none;">
      <td>จำนวนผู้ขับขี่ :</td>
      <td colspan="5"> <div id="Driver"><input name="rdodriver" type="radio" class="style1" id="rdodriverN" value="N" checked="checked" />
   ไม่ระบุ
      &nbsp;&nbsp;&nbsp;&nbsp;
       <input id="rdodriver1" name="rdodriver" type="radio" value="1" disabled="disabled" />
       1 คน
&nbsp;&nbsp;&nbsp;&nbsp;
<input id="rdodriver2" name="rdodriver" type="radio" value="2" disabled="disabled" />
2 คน</div>
      <div id="Divdriver1" style="display:none; width:630px;"><br />
          <font color="red">ผู้ขับขี่คนที่ 1 :</font>
        ชื่อ
  <select name="title_num1" id="title_num1">
   <option value=""></option>
  </select>
  <input id="name_num1" name="name_num1" type="text"  class="TEXTBOX" value="" size="20"/>
  นามสกุล <input id="last_num1" name="last_num1" type="text"  class="TEXTBOX" value="" size="20"/>
  <br /><br />
        วัน/เดือน/ปีเกิด
  <input name="birth_num1" type="text" id="birth_num1" size="10" maxlength="10" readonly="true" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        รหัสใบขับขี่
  <input name="licen_num1" type="text" id="licen_num1" size="13" maxlength="13" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        รหัสประจำตัวประชาชน
  <input name="iden_num1" type="text" id="iden_num1" size="13" maxlength="13" />
      </div>
      <div id="Divdriver2" style="display:none; width:630px;"><br />
          <font color="red">ผู้ขับขี่คนที่ 2 :</font>
        ชื่อ
  <select name="title_num2" id="title_num2">
    <option value=""></option>
  </select>
  <input id="name_num2" name="name_num2" type="text"  class="TEXTBOX" value="" size="20"/>
  นามสกุล <input id="last_num1" name="last_num1" type="text"  class="TEXTBOX" value="" size="20"/>
  <br /><br />
        วัน/เดือน/ปีเกิด
  <input name="birth_num2" type="text" id="birth_num2" size="10" maxlength="10" readonly="true" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        รหัสใบขับขี่
  <input name="licen_num2" type="text" id="licen_num2" size="13" maxlength="13" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        รหัสประจำตัวประชาชน
  <input name="iden_num2" type="text" id="iden_num2" size="13" maxlength="13" /><BR />
      </div></td>
      </tr>



	    <tr>
      <td valign="top">อุปกรณ์เพิ่มเติม</td>
      <td colspan="5">: 

      <input name="equit" type="radio" value="N" checked="checked" id="eq_non"/>
        ไม่มี &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="equit" type="radio" value="Y" id="eq"/>
        มี&nbsp;&nbsp;<font color="#FF0000"><b> * (เพิ่มราคาทุน / เพิ่มเบี้ย)</b></font>
        <BR /><BR />
        <div id="More" style="display:none;">
        <table class="bg-in"  width="800px" border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td colspan="5" width="100%"><input type="hidden" name="COUNTMORE" id="COUNTMORE" value="0" />
            <strong>รายการอุปกรณ์ตกแต่ง </strong>
			<button class="btn btn btn-info" type="button" name="ADDTABLE" id="ADDTABLE" ><i class="icon-upload"></i>เพิ่มอุปกรณ์</button>
			<button class="btn btn btn-danger" type="button" name="moreclose" id="moreclose" ><i class="icon-download"></i>ลบอุปกรณ์</button>
			<BR><span style="color:red;"> * หากไม่มีรายการอุปกรณ์ที่ต้องการเลือกกรุณาติดต่อเจ้าหน้าที่เพื่อเพิ่มรายการ</span></td>
            </tr>
            <tbody id="MORE_ADD">
			
           </tbody>
        </table>
        <table height="50" width="800px" cellpadding="0" cellspacing="0">
        <tr valign="middle" style="font-size:20px; color:red;" bgcolor="#999">
            <td width="1%">&nbsp;</td>
            <td width="30%" align="left"><textarea style="display:none;" name="acc" id="acc" cols="45" rows="5"></textarea>ทุนรวม
              <input style="font-size:16px;" name="price_acc_tun" value="0" id="price_acc_tun" type="text" class="span6" size="5"  readonly="readonly"/>
              บาท            </td>
            <td  align="center" width="40%">เบี้ยรวม
              <input style="font-size:16px;"  name="price_acc_cost" value="0" id="price_acc_cost" type="text" class="span6" size="5"  readonly="readonly"/>
              บาท</td>
            
            </tr>
        </table>
      </div>      </td>
      </tr>
      <tr class="alert-danger">
          <td valign="top"><strong><font color="#FF0000">ประกันภัย ซื้อเพิ่ม</font></strong>
          </td>
          <td colspan="5">
				<div class='span12'>:
				<?php 
				if(!empty($select_array['code_addon']))
				{
					$showaddon='';
					$checkaddon1="";
					$checkaddon2="checked";
					echo "<script>$('#checkAddonY').trigger('click');</script>";
				}
				else
				{
					$showaddon='display:none;';
					$checkaddon1="checked";
					$checkaddon2="";
					echo "<script>$('#checkAddonN').trigger('click');</script>";
				}
				?>
              <input type="radio" class="addon_N" data-id="N"  value="N" id="checkAddonN" name="checkAddon" <?=$checkaddon1?> > ไม่ซื้อ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="radio" class="addon_Y"  value="Y" id="checkAddonY" name="checkAddon" onclick='addon_start();' <?=$checkaddon2?> > ซื้อ  &nbsp;&nbsp;&nbsp; 
             <!-- <a class="btn btn-small btn-info" target="_blank" href="load/ใบปลิวขับขี่สุขใจ.pdf"><i class="icon-download"></i> Download : ใบปลิว ขับขี่สุขใจ</a>
			  <a class="btn btn-small btn-info" target="_blank" href="load/v_premium.pdf"><i class="icon-download"></i> Download : ใบปลิว Upgrade V Premium</a>-->
			  </div>
			  <span id="addONHideBtn"  style="<?=$showaddon?>"><!--<strong>รายการประกันภัยซื้อเพิ่ม </strong>-->
			 <div class='span12'>
			 </div>
			 
			  <?php
			  $select_addon_sql="SELECT * FROM tb_addon WHERE  star_date <= '".date('Y-m-d')."' AND end_date >= '".date('Y-m-d')."'";
			  $select_addon_query=mysql_query($select_addon_sql,$cndb1);
			  $numch=0;
			  $sumpricetotal=0;
			  $cssaddonbuy='display:none;';
			  while($select_addon_array=mysql_fetch_array($select_addon_query))
			  {  
		  $checkedbuy='';
		  if(!empty($select_array['code_addon_id']))
		  {
				
				
				$array_addon=explode(',',$select_array['code_addon_id']);
				for($ss=0;$ss<count($array_addon);$ss++)
				{
					if($array_addon[$ss]==$select_addon_array['id'])
					{
						$checkedbuy='checked';
						$sumpricetotal+=$select_addon_array['cost_insuran'];
						$cssaddonbuy='';
					}
				}
		  }
		  ?>
				<div class='span6' style='border-style:none none solid none; border-width:3px;'>
				<div class='span2'><input type='checkbox' name='addon_buy[]' <?=$checkedbuy?> value='<?php echo $select_addon_array['id']; ?>,<?php echo $select_addon_array['cost_insuran'];?>,<?php echo $select_addon_array['code_addon'];?>' onclick='addon_start("<?php echo $numch; ?>");'> ซื้อ</div>
				<div class='span5'><?php echo $select_addon_array['name_addon']." ".$select_addon_array['id_add'];?></div>
				<div class='span2'><?php echo $select_addon_array['cost_insuran']." บาท";?></div>
				<div class='span3'>
				<?php if(!empty($select_addon_array['link_addon'])){ ?>
				<a class="btn btn-small btn-info" target="_blank" href="<?php echo $select_addon_array['link_addon']; ?>"><i class="icon-download"></i>Download ใบปลิว</a>
				<?php } ?>
				</div>
				</div>
			  <?php $numch++; } ?>
                  <!--<button class="btn btn-small btn-info" type="button" name="ADDONTABLE" id="ADDONTABLE" ><i class="icon-upload"></i>เพิ่ม</button>-->
                  <!--<button class="btn btn-small btn-danger" type="button" name="addonclose" id="addonclose" ><i class="icon-download"></i>ลบ</button>-->
              </span>
              
              <table  width="100%" cellpadding="0" cellspacing="0"></table> 
              <br>
              <div id="boxAddOn" style="<?=$cssaddonbuy?>">
                  <table id="tbAddOn"  width="100%" cellpadding="0" cellspacing="0">
                      <tbody id="MORE_ADDON_SELECT">
                      </tbody>
                  </table>
                  <div style="font-size:18px;margin-top:10px;">
                      <input type="hidden" name="check_addonY" id="check_addonY" value="">
                      <label style="width:100px;float:left;font-size:20px;">เพิ่มเบี้ยรวม</label><input type="text" id="costIns"  class="btn btn-danger" value="<?=$sumpricetotal?>" onkeyup='addon_start();'> บาท
                  </div>
                  <input type="hidden" id="aoCounter" name="aoCounter" value="0">
              </div>
          </td>
      </tr>
</table>    </td>
    <td class="bg-in">&nbsp;</td>
  </tr>
</table>


</div></div></div></div></div></div></div>
<div class="widget-box">
									<div class="widget-header widget-header-flat">
										<h4>ข้อมูลบริษัทประกันภัย</h4>
									</div>
									<div class="widget-body">
										<div class="widget-main">
											<div class="row-fluid">
												<div class="span12">
<table class="table">

  <tr>
    <td>บริษัท :</td>
    <td><select name='com_data' id='com_data'>
    <option value="0">กรุณาเลือก</option>
	<?php
	if($_SESSION['strUser']!='admin')
	{
		$checkclaim=" AND sort = '".$select_array['com_data']."' ";
	}
	else
	{
		$checkclaim='';
	}
	$tb_comp_sql="SELECT * FROM tb_comp WHERE sort LIKE '%VIB%' ".$checkclaim." GROUP BY sort";
	$tb_comp_query=mysql_query($tb_comp_sql,$cndb1);
	while($tb_comp_array=mysql_fetch_array($tb_comp_query))
	{ ?>
	<option value="<?=$tb_comp_array['sort']?>" <?php if($tb_comp_array['sort']==$select_array['com_data']){echo "selected";}?>><?=$tb_comp_array['name']?></option>
	<?php } ?>
	</select>
<font color="#FF0000"><b> * </b></font></td>
    <td colspan="5">ประเภทการรับแจ้ง 
      : 
      <select name="ty_inform" id="ty_inform">
        <option value="L">ป้ายแดง</option>
      </select></td>
    <td><div align="right">เลขที่รับแจ้ง :&nbsp;&nbsp; </div></td>
    <td class="warn">จะได้รับหลังจากคลิกปุ่มบันทึกข้อมูลแล้ว</td>
    <td></td>
  </tr>
    <tr>
    <td>ทุนประกันภัย :</td>
    <td >
    <select class="warn" name="costCost" id="costCost">
	<?php
	if(!empty($select_array['costCost'])) { ?>
	<option value="<?=$select_array['costCost']?>"><?=$select_array['cost']?></option>
	<?php } else { ?>
	<option value="0">--------------</option>
	<?php } ?>
	</select><font color="#FF0000"><b> * </b></font></td>
    <td colspan="8">ไฟแนนซ์เพิ่มทุน :&nbsp;&nbsp;&nbsp;
			<select id="finance_add_tun" name="finance_add_tun">
			<?php
			$pre_finace=0.00;
			$array_finace=explode('|',$select_array['car_detail']);
			for($xx=0;$xx<count($array_finace);$xx++)
			{
				$array_finace_1=explode(',',$array_finace[$xx]);
				if($array_finace_1[0]=='31' || $array_finace_1[0]=='32')
				{
					$select_acc_sql = "SELECT * FROM tb_acc WHERE id = '".$array_finace_1[1]."' AND mo_car = '".$select_array['mo_car_id']."' AND status = 'Y'";
					$select_acc_query=mysql_query($select_acc_sql,$cndb1);
					$select_acc_array=mysql_fetch_array($select_acc_query);
					$tun_finace=$select_acc_array['name'];
					$pre_finace=$select_acc_array['price'];
					
				}
			}
			?>
            	
				<?php
				if(!empty($tun_finace))
				{ ?>
			<option value="<?=$tun_finace?>"><?=$tun_finace?></option>
				<?php } else{ ?>
				<option value="N">ไม่ระบุ</option>
				<?php } ?>
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
            </select><font color="#FF0000"><b> * </b></font>
			&nbsp;&nbsp; เบี้ยเพิ่ม : <input style="font-size:16px;"  name="finance_add_tun_price" value="<?=$pre_finace?>" id="finance_add_tun_price" type="text" readonly="readonly"/> บาท
    </td>
    </tr>
	<tr height="30">
	<td > 
          </td>
    <td colspan='8' align="center"> เบี้ยสุทธิ&nbsp;:&nbsp;
    <input class="warn" value="<?=$select_array['pre']?>" name="costPre" type="text" id="costPre" size="11" maxlength="10" readonly="readonly" />&nbsp;
    อากร&nbsp;:&nbsp;
    <input class="warn" value="<?=$select_array['stamp']?>" name="costStamp" type="text" id="costStamp" size="11" maxlength="10" readonly="readonly" />&nbsp;
   ภาษี&nbsp;:&nbsp;
    <input class="warn" value="<?=$select_array['tax']?>" name="costTax" type="text" id="costTax" size="11" maxlength="10" readonly="readonly" />&nbsp;
    เบี้ยรวมภาษี&nbsp;:&nbsp;
    <input class="warn" value="<?=$select_array['net']?>" name="costNet" type="text" id="costNet" size="11" maxlength="10" readonly="readonly" /></td>
    </tr>
   <tr class="error">
    <td colspan="10" style="color:red;">
	*** กรณีไม่มีเลขที่รับแจ้งขึ้น หรือระบบขัดข้อง กรุณาติดต่อ  คุณธีร์ดนัย (เอ็ม) 092-250-7272<BR />
	**  จดทะเบียนรถโดยสารใช้เพื่อการพานิชย์ (220) กรุณาติดต่อพนักงานหลังจากบันทึกข้อมูล<BR />
	*    กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนทำการบันทึก มิฉะนั้นข้อมูลจะไม่สมบูรณ์</td>
  </tr>
</table>
</div></div></div></div></div>
	
<div class="widget-box">
	<div class="widget-header widget-header-flat"><h4>ข้อมูลประกันภัย (พ.ร.บ.)</h4></div>
		<div class="widget-body">
			<div class="widget-main">
				<div class="row-fluid">
					<div class="span12">
<table class="table">
<tr>
      <td>เลขที่กรมธรรม์ (พ.ร.บ.) :</td>
      <td colspan="7">
	  <?php $actarray=explode('-',$select_array['p_act']); ?>
      	<input name="p_act1" type="text" id="p_act1"  style="width:60px;" maxlength="5" value="<?=$actarray[0]?>" readonly="readonly" />
        <input name="p_act2" type="text" id="p_act2"style="width:60px;" maxlength="5" value="<?=$actarray[1]?>" readonly="readonly" />

        <?
		/*
			$user = $_SESSION["strUser"];
			$query_act ="SELECT *  FROM z_act WHERE act_use = '".$user."' AND act_status = '1' ORDER BY act_id";
			$objQuery_act = mysql_query($query_act) or die ("Error Query [".$query_act."]");
			$row_act = mysql_fetch_array($objQuery_act);
        */
		?>
        <?php if($_SESSION["strUser"] != '3000032'){ ?>
		<?php if($_SESSION["saka"] == '113'){?>
                    <?php
                        $user = $_SESSION["strUser"];
                        $query_act ="SELECT *  FROM z_act WHERE act_use = '".$user."' AND act_status = '1' AND act_return = '' ORDER BY act_id ASC limit 5";
                        $objQuery_act = mysql_query($query_act,$cndb1) or die ("Error Query [".$query_act."]");
                        $row_act = mysql_fetch_array($objQuery_act);
    
                    ?>
                    <input name="p_act3" type="text" id="p_act3" style="width:70px;"  maxlength="7" value="<?=$actarray[2]?>" readonly="readonly" />
                    <font color="#FF0000">** ในกรณีที่เลขพรบเป็นค่าว่าง กรุณาติดต่อเจ้าหน้าที่ โทร 085-921-3636, 085-921-5454 **<b></b></font>
            <?php }else{ ?>
                <input name="p_act3" type="text" id="p_act3" style="width:70px;" value='<?=$actarray[2]?>'  maxlength="7" value="" />
                <font color="#FF0000"><b> * เลขที่ พ.ร.บ. อยู่ที่สี่เหลี่ยมสีแดง</b></font> <img src="i/act.jpg" />
            <?php } ?>
         <?php }else{ ?>
         	<input name="p_act3" type="text" id="p_act3" style="width:70px;" value='<?=$actarray[2]?>'  maxlength="7" value="" />
                <font color="#FF0000"><b> * เลขที่ พ.ร.บ. อยู่ที่สี่เหลี่ยมสีแดง</b></font> <img src="i/act.jpg" />
         <?php } ?>
        </td>
      </tr>
   <tr>
      <td>เบี้ยสุทธิ :</td>
      <td>
      	<select class="comment" name="id_prp" id="id_prp" style="width:auto;">
		<?php 
		if(!empty($select_array['p_net']))
		{ ?>
			<option value="<?=$select_array['p_pre']?>" selected="selected"><?=$select_array['p_net']-$select_array['p_tax']-$select_array['p_stamp']?></option>
		<?php } else {?>
              <option value="0" selected="selected">กรุณาเลือกเบี้ย</option>
		<?php } ?>
            </select>
        <input type="hidden" class="comment" name="txtprp1" id="txtprp1" /></td>
      <td >อากร :</td>
      <td><input type="text" class="comment" name="txtstamp1" id="txtstamp1" style="width:50px;" value="<?=$select_array['p_stamp']?>" readonly="readonly" /></td>
      <td >ภาษี :</td>
      <td ><input type="text" class="comment" name="txttax1" id="txttax1" style="width:50px;" value="<?=$select_array['p_tax']?>" readonly="readonly"  /></td>
      <td >เบี้ยรวม :</td>
      <td ><input type="text" class="comment" name="txtnet1" id="txtnet1" style="width:50px;" value="<?=$select_array['p_net']?>" readonly="readonly"  /></td>
    </tr>
    <tr class="error">
    	<td colspan="8"><font color="#FF0000"><b>กรณี จดทะเบียนเป็นรถรับจ้าง หรือ รถขนส่งผู้โดยสาร กรุณาติดต่อเจ้าหน้าที่ hotline: 085-921-3636, 085-921-5454</b></font></td>
    </tr>
</table>

</div></div></div></div></div>

<div class="widget-box">
	<div class="widget-header widget-header-flat"><h4>ข้อมูลผู้เอาประกันภัย</h4></div>
		<div class="widget-body">
				<div class="widget-main">
						<div class="row-fluid">
							<div class="span12">
<table class="table">

    <tr>
      <td class="comment" colspan="6">ตามกฎหมาย สำนักงานป้องกันและปราบปรามการฟอกเงิน (ปปง.) จำเป็นต้องแสดง เลขบัตรประชาชน / เลขหมายทะเบียนการค้า <img src="images/New_icon.gif" width="25" height="9" /></td>
      </tr>
	  <tr>
      <td>
          <label class="radio-inline"><input name="person" id="person" type="radio" value="1" <?php if($select_array['person']=='1'){echo "checked";} ?> > บุคคลธรรมดา</label>
          <label class="radio-inline"><input name="person" id="persons" type="radio" value="2" <?php if($select_array['person']=='2'){echo "checked";} ?>  > นิติบุคคล</label>
		  <label class="radio-inline"><input name="person" id="person_foreign" type="radio" value="3" <?php if($select_array['person']=='3'){echo "checked";} ?>  > ชาวต่างชาติ</label>
		 </td>
		 <td colspan="6" style="vertical-align:middle">
        <input name="icard" type="text" id="icard" maxlength="13" value='<?php if(!empty($select_array['icard_niti'])){echo $select_array['icard_niti'];}else{echo $select_array['icard'];}?>'>
        <font color="#FF0000" id = "icardTEXT" name = "icardTEXT"><b> * (กรุณากรอกเฉพาะตัวเลข 13 หลัก)</b></font>
        </td>
      </tr>
		<tr>
      <td>คำนำหน้าชื่อ :</td>
      <td>
        <select id="title" name="title">
          <option value="0">กรุณาเลือก</option>
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
        </select><font color="#FF0000"><b> * </b></font></td>
      <td>ชื่อ :</td>
      <td><input type="text" name="name_name" id="name_name" size="25" maxlength="100" value='<?=$select_array['name']?>'><font color="#FF0000"><b> * </b></font></td>
      <td>นามสกุล :</td>
      <td><input type="text" name="last" id="last" size="25" maxlength="50"  value='<?=$select_array['last']?>'><font color="#FF0000"><b> * </b></font></td>
    </tr>
	  <tr>
      <td>บ้านเลขที่ :</td>
      <td>  <input type="text" id="add" maxlength="30" class="span2" name="add"  value='<?=$select_array['add']?>'><font color="#FF0000"><b> * </b></font>&nbsp;&nbsp; หมู่&nbsp; <input type="text" name="group" id="group" size="3" class="span2" maxlength="4" value='<?=$select_array['group']?>' /></td>
      <td>อาคาร/หมู่บ้าน</td>
      <td> <input type="text" name="town" id="town" size="25" maxlength="50" autocomplete="OFF"  value='<?=$select_array['town']?>'></td>
      <td>ซอย :</td>
      <td> <input type="text" name="lane" id="lane" size="25" maxlength="50"  value='<?=$select_array['lane']?>'></td>
    </tr>
    <tr>
      <td>ถนน :</td>
      <td><input type="text" id="road" maxlength="50" size="20" name="road"  value='<?=$select_array['road']?>'></td>
      <td>โทรศัพท์ที่ติดต่อสะดวก :</td>
      <td><input type="text" name="tel_home" id="tel_home" size="25" maxlength="20" value='<?=$select_array['tel_home']?>' /></td>
      <td>จังหวัด :</td>
      <td> <span id="provinceDiv">
	<select name="province" id="province">
	<?php
	$send_province_sql="SELECT * FROM tb_province WHERE id = '".$select_array['province']."'";
	$send_province_query=mysql_query($send_province_sql,$cndb1);
	$send_province_array=mysql_fetch_array($send_province_query);
	if(!empty($send_province_array))
	{ ?>
	<option value="<?=$send_province_array['id']?>"><?=$send_province_array['name']?></option>
	<?php } else { ?>
	<option value="0">กรุณาเลือก</option>
	<?php } ?>
	</select></span><font color="#FF0000"><b> * </b></font></td>
    </tr>
	 <tr>
      <td>อำเภอ :</td>
      <td><span id="amphurDiv">
	<select name="amphur" id="amphur" >
	<option value="0">กรุณาเลือก</option>
	<?php
	$send_amphur_sql="SELECT * FROM tb_amphur WHERE provinceID = '".$select_array['province']."'";
	$send_amphur_query=mysql_query($send_amphur_sql,$cndb1);
	while($send_amphur_array=mysql_fetch_array($send_amphur_query))
	{ ?>
	<option value="<?=$send_amphur_array['id']?>" <?php if($send_amphur_array['id']==$select_array['amphur']){echo "selected";}?>><?=$send_amphur_array['name']?></option>
	<?php } ?>
	</select></span> <font color="#FF0000"><b> * </b></font></td>
      <td>ตำบล :</td>
      <td><span id="tumbonDiv">
	<select name="tumbon" id="tumbon">
	<option value="0">กรุณาเลือก</option>
	<?php
	$send_tumbon_sql="SELECT * FROM tb_tumbon WHERE amphurID = '".$select_array['amphur']."'";
	$send_tumbon_query=mysql_query($send_tumbon_sql,$cndb1);
	while($send_tumbon_array=mysql_fetch_array($send_tumbon_query))
	{ ?>
	<option value="<?=$send_tumbon_array['id']?>" <?php if($select_array['tumbon']==$send_tumbon_array['id']){echo "selected";}?>><?=$send_tumbon_array['name']?></option>
	<?php } ?>

	</select></span><font color="#FF0000"><b> * </b></font></td>
      <td>รหัสไปรษณีย์ :</td>
      <td><span id="id_postDiv">
	<select name="id_post" id="id_post">
	<?if(!empty($select_array['postal']))
	{ ?>
	<option value="<?=$select_array['postal']?>"><?=$select_array['postal']?></option>
	<?php }else{ ?>
	<option value="0">กรุณาเลือก</option>
	<?php } ?>
	</select></span><font color="#FF0000"><b> * </b></font></td>
    </tr>
    <tr>
    	<td>อาชีพ :</td>
      	<td><input type="text" name="vocation" id="vocation" value="<?=$select_array['vocation']?>" /><font color="#FF0000"><b> * </b></font></td>
		<td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
	 <tr>
    	<td>ที่อยู่จัดส่งเอกสาร :</td>
      	<td colspan='5'>
		<?php
	if(!empty($select_array['SendAdd']) && $select_array['status_SendAdd']=='Y')
	{
		$array_location=explode('|',$select_array['SendAdd']);
		$show_sendadd='';
		$checkedaddsend2='checked';
		$checkedaddsend1='';
	}
	else
	{
		$show_sendadd='display:none;';
		$checkedaddsend2='';
		$checkedaddsend1='checked';
	}
	?>
		<input type="radio" name="status_send_add" id="send_add_N" value="N" <?=$checkedaddsend1?> onclick='js_showsendadd();'>&nbsp;<span>ที่อยู่ตามผู้เอาประกัน</span>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="radio" name="status_send_add" id="send_add_Y" value="Y" <?=$checkedaddsend2?> onclick='js_showsendadd();'>&nbsp;<span>ระบุที่อยู่จัดส่งเอกสาร</span>

		</td>
    </tr>
	<tr>
	<td colspan='6'>
	
	<div id='show_addsend' style='<?=$show_sendadd?>'>
	<div style='background-color:#5E78DF !important; padding:1px;border-radius:10px;'><h4>&nbsp;ข้อมูลที่อยู่จัดส่งเอกสาร</h4></div>
	<br>
	<div class='span12' style='padding-bottom:8px;'>
	<div class='span4'>
	<div class='span4'>บ้านเลขที่</div>
	<div class='span8'>
	<div class='span5'><input type="text" name="send_add" id="send_add" class='span8' value='<?=$array_location[0]?>'></div>
	<div class='span2'>หมู่</div>
	<div class='span5'><input type="text"  name="send_group" id="send_group" class='span8' value='<?=$array_location[1]?>'></div>
	</div>
	</div>
	<div class='span4'>
	<div class='span4'>อาคาร/หมู่บ้าน</div>
	<div class='span8'><input type="text"  name="send_town" id="send_town" class='span8' value='<?=$array_location[2]?>'></div>
	</div>
	<div class='span4'>
	<div class='span4'>ซอย</div>
	<div class='span8'><input type="text"  name="send_lane" id="send_lane" class='span8' value='<?=$array_location[3]?>'></div>
	</div>
	</div>

	<div class='span12'  style='padding-bottom:8px;'>
	<div class='span4'>
	<div class='span4'>ถนน</div>
	<div class='span8'><input type="text"  name="send_road" id="send_road" class='span8' value='<?=$array_location[4]?>'></div>
	</div>
	<div class='span4'>
	<div class='span4'>จังหวัด</div>
	<div class='span8'>
	<select  name="send_province" id="send_province" class='span8' onchange='js_proshow("AMPHUR","province","send_province","send_amphur");'>
	<option value=''>--กรุณาเลือก--</option>
	<?php
	$send_province_sql="SELECT * FROM tb_province";
	$send_province_query=mysql_query($send_province_sql,$cndb1);
	while($send_province_array=mysql_fetch_array($send_province_query))
	{ ?>
		<option value='<?=$send_province_array['id']?>' <?php if($array_location[5]==$send_province_array['id']){ echo "selected";}?>><?=$send_province_array['name']?></option>
	<?php } ?>
	</select>
	</div>
	</div>
	<div class='span4'>
	<div class='span4'>อำเภอ</div>
	<div class='span8'>
	<select  name="send_amphur" id="send_amphur" class='span8' onchange='js_proshow("TUMBON","amphur","send_amphur","send_tumbon");'>
	<option value=''>--กรุณาเลือก--</option>
	<?php
	$send_amphur_sql="SELECT * FROM tb_amphur WHERE provinceID = '".$array_location[5]."'";
	$send_amphur_query=mysql_query($send_amphur_sql,$cndb1);
	while($send_amphur_array=mysql_fetch_array($send_amphur_query))
	{ ?>
	<option value='<?=$send_amphur_array['id']?>' <?php if($send_amphur_array['id']==$array_location[6]){echo "selected";}?>><?=$send_amphur_array['name']?></option>
	<?php } ?>
	</select></div>
	</div>
	</div>

	<div class='span12'  style='padding-bottom:8px;'>
	<div class='span4'>
	<div class='span4'>ตำบล</div>
	<div class='span8'>
	<select  name="send_tumbon" id="send_tumbon" class='span8' onchange='js_proshow("POST","tumbon","send_tumbon","send_post")';>
	<option value=''>--กรุณาเลือก--</option>
	<?php
	$send_tumbon_sql="SELECT * FROM tb_tumbon WHERE amphurID = '".$array_location[6]."'";
	$send_tumbon_query=mysql_query($send_tumbon_sql,$cndb1);
	while($send_tumbon_array=mysql_fetch_array($send_tumbon_query))
	{ ?>
	<option value='<?=$send_tumbon_array['id']?>' <?php if($send_tumbon_array['id']==$array_location[7]){echo "selected";}?>><?=$send_tumbon_array['name']?></option>
	<?php } ?>
	</select></div>
	</div>
	<div class='span4'>
	<div class='span4'>รหัสไปรษณีย์</div>
	<div class='span8'>
	<select  name="send_post" id="send_post" class='span8'>
	<option value='<?=$array_location[8]?>'><?=$array_location[8]?></option>
	
	</select></div>
	</div>
	</div>
	</div>
	</td>
	</tr>
	<?php
	if($_SESSION['strUser']=='admin')
	{
		$display_career='';
	}
	else
	{
		$display_career='display:none;';
	}
	?>
	<tr style="font-size:14px; font-weight:700;" height="30" style='<?=$display_career;?>'>
      <td colspan="6">
        <span class="style4"><BR />
          <BR />
          ที่อยู่ในการออกใบเสร็จ :</span>
      <BR /><BR /><input id="address_chk1" name="address_chk" type="radio" value="2" <?php if($select_array['career']=='2'){echo "checked"; }?> />
        &nbsp;ออกใบเสร็จในนามลูกค้า
        
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input id="address_chk2" name="address_chk" type="radio" value="1"  <?php if($select_array['career']=='1'){echo "checked"; $show_company='';}else{$show_company='display:none;';}?> />
        &nbsp;ออกใบเสร็จในนามบริษัท <font color="#FF0000" id="user_ScomC" style="<?=$show_company?>"> ( <?=$_SESSION["strUser"].' : '.$_SESSION["strName"].' - '.$_SESSION["location"];?> )</font>
        </td>
    </tr>
	<tr>
      <td colspan="7" align="center">
	  <!--<div class='span12'>
	  <div class='span6' style='margin-top:0px;'>
	  <img src='images/sms_new.jpg' width='100%' height='100%'>
	  <input placeholder="กรอกเบอร์มือถือ" id="tel_mobi" type="text" maxlength="13" class="span3" name="tel_mobi" style="position:relative;left:10px;top:-137px;">
	  </div>
	  <div class='span6' style='margin-top:0px;'>
	  <img src='images/email_new.jpg' width='100%' height='100%'>
	   <input placeholder="กรอกอีเมล์" name="email" class="span3" type="text" id="email" size="20" style="position:relative;left:10px;top:-131px;">
	  </div>
	  </div>-->
         <div class="row-fluid" class='span12'>
              <div class="span6">
                  <table width="600px;">
                        <tr height="150px">
                            <td style="background: #fff url('images/sms_new1.jpg'); no-repeat right;background-repeat: no-repeat;background-size: 600px 160px;">
                                <div style="padding-left:10px; padding-top:19px;">
                                    <input placeholder="กรอกเบอร์มือถือ" id="tel_mobi" type="text" size="7" maxlength="13"  name="tel_mobi" value='<?=$select_array['tel_mobi']?>'>
                                    <font color="#FF0000"><b> * </b></font>
                                </div>
                            </td>
                        </tr>
                    </table>
            </div>
	  		<div class="span6">
	  	  		<table width="600px;">
	  				<tr height="150px">
      					<td width="50%" style="background: #fff url('images/email_new1.jpg');background-repeat: no-repeat;background-size: 600px 160px;">
                        	<div style="padding-left:10px; padding-top:20.4px;">
                             

                                <input placeholder="กรอกอีเมล์" name="email"  type="text" id="email" size="7"  value='<?=$select_array['email']?>'>
                                <font color="#FF0000"><b> * </b></font>
                            </div>
						</td>
      				</tr>
	  			</table>
	  		</div>
	  </div>
	  </td>
      </tr>
</table>


</div></div></div></div></div>



<button class="btn btn-large btn-primary" type="button" id="SaveInsurance_edit" name="SaveInsurance_edit"><i class="icon-upload"></i>บันทึกแก้ไขข้อมูลประกัน</button>
<button class="btn btn-large btn-warning" type="reset" name="BcloseIn" id="BcloseIn"><i class="icon-refresh"></i>เริ่มใหม่</button>
</form>
</div>

<script>
$("#mo_car").change(function()
{
	$('#mo_car_sub').css('display','');
	$('#mo_dev').css('display','');
		var _mocar =  $('#mo_car').val();
	var _cartype = $("#cartype").val();
	var CallCom = {
		type: "POST",
		dataType: "json",
		url: "ajax/Ajax_Cost.php",
		data: {callajax:'START',
		status_sub:'1',
		mo_car:_mocar,
		cartype:_cartype},

		success: function(msg) {

			var returnedArray = msg;
			$("#costCost").empty();
			$("#costCost").append("<option value='0'>-------------------</option>");
			$("#mo_car_sub").html(returnedArray.mo_sub_show);
			com_data = $("#com_data");
			com_data.empty(); 
			com_data.append("<option value='0'>--กรุณาเลือกบริษัท--</option>");
			if(returnedArray!=null){

				for (i = 0; i < returnedArray.length; i++) {
					com_data.append("<option value='" + returnedArray[i].sort + "'>" + returnedArray[i].name + "</option>");

					if($('#cartype').val()==0){
						$("#com_data").empty(); 
						$("#com_data").append("<option value='0'>กรุณาเลือก</option>");
					}
				}
			}
			else{
				return false;
			}
		}
	};
	$.ajax(CallCom);

	$("#costPre").val('0.00');
	$("#costStamp").val('0.00');
	$("#costTax").val('0.00');
	$("#costNet").val('0.00');
	$("#com_data").val(0);
});
$("#mo_car_sub").change(function() 
{ 

	var _selected = $("#mo_car_sub").val();
	var _input = $("#new_carbody");
	var _input1 = $("#new_motor");
	var car_seat = $("#car_seat");
	var gear = $("#gear");
	var car_cc = $("#car_cc");


	var new_mo = _selected;
	<?php 
	$mo_sql="SELECT * FROM tb_mo_car WHERE status = 'T'";
	$mo_query=mysql_query($mo_sql,$cndb1);
	$rows=0;

	while($mo_array=mysql_fetch_array($mo_query))
	{ 
	
	
	$mo_check_sql="SELECT * FROM tb_mo_car_sub WHERE mo_car = '".$mo_array['id']."'";
	$mo_check_query=mysql_query($mo_check_sql,$cndb1);
	while($mo_check_array=mysql_fetch_array($mo_check_query))
	{
		$rows++; 
	$exp_array=explode("|",$mo_check_array['body']);
	if($rows==1){	 ?>
if (_selected == "<?php echo  $mo_check_array['id'];?>"){
		_input.val("<?php echo  $exp_array[0];?>"); 
		_input1.val("<?php echo  $exp_array[1];?>");
		gear.empty(); 
		gear.append("<option value='A'>อัตโนมัติ</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
	}
<?php }else{ ?>
else if(_selected == "<?php echo  $mo_check_array['id'];?>"){
		_input.val("<?php echo  $exp_array[0];?>"); 
		_input1.val("<?php echo  $exp_array[1];?>");
		gear.empty(); 
		gear.append("<option value='A'>อัตโนมัติ</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
	}
	<?php } } } ?>
else{
		_input.val("");    
		_input1.val("");
	}

	/*if (_selected == "760"){
		_input.val("MHYEZC21S"); 
		gear.empty(); 
		gear.append("<option value='A'>อัตโนมัติ</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
		$('#mo_car_sub').css('display','none');
		$('#mo_dev').css('display','none');
	}
	else if (_selected == "759"){
		_input.val("MHYHYA21S");    
		gear.empty(); 
		gear.append("<option value='A'>อัตโนมัติ</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
		$('#mo_car_sub').css('display','none');
	}
	else if (_selected == "754"){
		_input.val("MHYJTE54V"); 
		gear.empty(); 
		gear.append("<option value='A'>อัตโนมัติ</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");   
		$('#mo_car_sub').css('display','none');
		$('#mo_dev').css('display','none');
	}
	else if (_selected == "1098"){
		if($("#cartype").val()==3){
			gear.empty(); 
			gear.append("<option value='M'>ธรรมดา</option>");
			car_seat.empty(); 
			car_seat.append("<option value='3'>ไม่เกิน 3 ที่นั่ง</option>");
			car_cc.empty(); 
			car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
			_input.val("MHYGDN71T"); 
			$('#mo_car_sub').css('display','none');
			$('#mo_dev').css('display','none');
		}
		else if($("#cartype").val()==2){
			gear.empty(); 
			gear.append("<option value='M'>ธรรมดา</option>");
			car_seat.empty(); 
			car_seat.append("<option value='3'>ไม่เกิน 15 ที่นั่ง</option>");
			car_cc.empty(); 
			car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
			_input.val("MHYGDN71T"); 
			$('#mo_car_sub').css('display','none');
			$('#mo_dev').css('display','none');
		}
	}
	else if (_selected == "747"){
		gear.empty(); 
		gear.append("<option value='A'>อัตโนมัติ</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
		_input.val("MHYGDN71V"); 
		$('#mo_car_sub').css('display','none');
		$('#mo_dev').css('display','none');
	}
	else if (_selected == "1951"){
		_input.val("MMSHZC72S"); 
		gear.empty(); 
		gear.append("<option value='0'>กรุณาเลือก</option>");
		gear.append("<option value='A'>อัตโนมัติ</option>");
		gear.append("<option value='M'>ธรรมดา</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
		$('#mo_car_sub').css('display','');
		$('#mo_dev').css('display','');
	}
	else if (_selected == "1960"){
		_input.val("MHYKZE81S"); 
		gear.empty(); 
		gear.append("<option value='0'>กรุณาเลือก</option>");
		gear.append("<option value='A'>อัตโนมัติ</option>");
		gear.append("<option value='M'>ธรรมดา</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
		$('#mo_car_sub').css('display','none');
		$('#mo_dev').css('display','none');
	}
	else if (_selected == "1964"){
		_input.val("MMSLFE42S"); 
		gear.empty(); 
		gear.append("<option value='0'>กรุณาเลือก</option>");
		gear.append("<option value='A'>อัตโนมัติ</option>");
		gear.append("<option value='M'>ธรรมดา</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
		$('#mo_car_sub').css('display','none');
		$('#mo_dev').css('display','none');
	}
	else if (_selected == "1967"){
		_input.val("MMSHZC72S"); 
		gear.empty(); 
		gear.append("<option value='A'>อัตโนมัติ</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
		$('#mo_car_sub').css('display','none');
		$('#mo_dev').css('display','none');
	}
	else if (_selected == "1968"){
		_input.val("MMSHZC72S"); 
		gear.empty(); 
		gear.append("<option value='0'>กรุณาเลือก</option>");
		gear.append("<option value='A'>อัตโนมัติ</option>");
		gear.append("<option value='M'>ธรรมดา</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
		$('#mo_car_sub').css('display','none');
		$('#mo_dev').css('display','none');
	}
	else if (_selected == "1969"){
		_input.val("MMSCVC31S"); 
		gear.empty(); 
		gear.append("<option value='0'>กรุณาเลือก</option>");
		gear.append("<option value='A'>อัตโนมัติ</option>");
		gear.append("<option value='M'>ธรรมดา</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
		$('#mo_car_sub').css('display','none');
		$('#mo_dev').css('display','none');
	}
	else if (_selected == "1970"){
		_input.val("MHYKZE81S"); 
		gear.empty(); 
		gear.append("<option value='0'>กรุณาเลือก</option>");
		gear.append("<option value='A'>อัตโนมัติ</option>");
		gear.append("<option value='M'>ธรรมดา</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
		$('#mo_car_sub').css('display','none');
		$('#mo_dev').css('display','none');
	}
	else if (_selected == "1971"){
		_input.val("MMSHZC72S"); 
		gear.empty(); 
		gear.append("<option value='A'>อัตโนมัติ</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
		$('#mo_car_sub').css('display','none');
		$('#mo_dev').css('display','none');
	}
        else if (_selected == "1972"){
		_input.val("MHYKZE81S"); 
		gear.empty(); 
		gear.append("<option value='0'>กรุณาเลือก</option>");
		gear.append("<option value='A'>อัตโนมัติ</option>");
		gear.append("<option value='M'>ธรรมดา</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
		$('#mo_car_sub').css('display','none');
		$('#mo_dev').css('display','none');
	}
        else if (_selected == "1973"){
		_input.val("MHYKZE81S"); 
		gear.empty(); 
		gear.append("<option value='0'>กรุณาเลือก</option>");
		gear.append("<option value='A'>อัตโนมัติ</option>");
		gear.append("<option value='M'>ธรรมดา</option>");
		car_seat.empty(); 
		car_seat.append("<option value='7'>ไม่เกิน 7 ที่นั่ง</option>");
		car_cc.empty(); 
		car_cc.append("<option value='1'>ต่ำกว่า 2000 cc</option>");
		$('#mo_car_sub').css('display','none');
		$('#mo_dev').css('display','none');
	}
	else
		_input.val("");    

	if (_selected == "760")
		_input1.val("M15AIA");
	else if (_selected == "759")
		_input1.val("M16AIA");
	else if (_selected == "754")
		_input1.val("J20AID");
	else if (_selected == "1098")
		_input1.val("G16AID");
	else if (_selected == "747")
		_input1.val("G16AID");
	else if (_selected == "1951")
		_input1.val("K12BS");
	else if (_selected == "1960")
		_input1.val("K14BT");
	else if (_selected == "1964")
		_input1.val("K10BS");
	else if (_selected == "1967")
		_input1.val("K12BS");			
	else if (_selected == "1968")
		_input1.val("K12BS");
	else if (_selected == "1969")
		_input1.val("K12BS");
	else if (_selected == "1970")
		_input1.val("K14BT");	
       else if (_selected == "1972")
		_input1.val("K14BT");
       else if (_selected == "1973")
		_input1.val("K14BT");
	else if (_selected == "1971")
		_input1.val("K12BS");						
	else
		_input1.val("");
*/

});
function mo_sub_start()
{
var mo_ajax = {
url:"ajax/ajax_mo_car_sub.php",
dataType:"json",
type:"post",
data:{
mo_sub:$("#mo_car_sub").val()
},success:function(data)
{
$("#cost_array").html(data.cost_text)
$("#com_data").html(data.com_data);
$("#costCost").html(data.cost_array);
$("#costPre").val(data.costpre);
$("#costStamp").val(data.coststamp);
$("#costTax").val(data.costtax);
$("#costNet").val(data.costnet);
$("#gear").html(data.cost_gear);
}
};
$.ajax(mo_ajax);
}
$('#com_data').click(function(){
  var mocar_sub = $('#mo_car_sub').val();
  if(mocar_sub=='0'){
    alert('กรูณาเลือกรุ่นรถย่อย');
    $('#mo_car_sub').focus();
  }
});
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
function js_showsendadd()
{
	if($("#send_add_Y:checked").val()=='Y')
	{
	$("#show_addsend").slideDown();
	}
	else if($("#send_add_N:checked").val()=='N')
	{
	$("#show_addsend").slideUp();	
	}
}
//js_proshow("TUMBON","amphur","send_amphur","send_tumbon");
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
//$("#checkAddonY").trigger("click");

var NUMBER_edit = 0;
var htmlcardetail='';

<?php 
$totaltuncl=0;
$totalprecl=0;
$SS=0;
if(!empty($select_array['car_detail']) && $select_array['car_detail']!='ไม่มี')
{ ?>


<?php
$array_ti_detail=explode('|',$select_array['car_detail']);
			for($xx=0;$xx<count($array_ti_detail);$xx++)
			{
				$array_car_detail=explode(',',$array_ti_detail[$xx]);
				if($array_car_detail[0]!='31' && $array_car_detail[0]!='32' && $array_car_detail[0]!='0' && $array_car_detail[0]!='')
			  { if($SS==0) { ?>
		   $("#eq").trigger('click');
		   $("#tr0").remove();
				  <?php } ?>
		htmlcardetail='';
		htmlcardetail+='<tr id="tr'+NUMBER_edit+'" >';
		htmlcardetail+='<td width="10%">';
		htmlcardetail+='</td>';
		htmlcardetail+='<td width="25%">';
		htmlcardetail+='<select onchange="callcost('+NUMBER_edit+',this.value);" name="id_acc'+NUMBER_edit+'" id="id_acc'+NUMBER_edit+'" >';
		htmlcardetail+='<option value="0" >--กรุณาเลือกอุปกรณ์--</option>';
		<?php
		$tb_acc_new_sql="SELECT * FROM tb_acc_new";
		$tb_acc_new_query=mysql_query($tb_acc_new_sql,$cndb1);
		while($tb_acc_new_array=mysql_fetch_array($tb_acc_new_query))
		{ ?>
		htmlcardetail+='<option value="<?=$tb_acc_new_array['id']?>" <?php if($tb_acc_new_array['id']==$array_car_detail[0]){echo "selected";}?>><?=$tb_acc_new_array['name']?></option>';
		<?php } ?>
		htmlcardetail+='</select>';
		htmlcardetail+='</td>';
		htmlcardetail+='<td width="25%" align="center">';
		htmlcardetail+='<select  onchange="splitcost('+NUMBER_edit+',this.value);" name="id_price'+NUMBER_edit+'" id="id_price'+NUMBER_edit+'" >';
		htmlcardetail+='<option value="0" >--กรุณาเลือกราคาอุปกรณ์--</option>';
		<?php
		$tb_acc_sql="SELECT * FROM tb_acc WHERE status = 'Y' AND mo_car = '".$select_array['mo_car_id']."' AND name !='0' AND name <='120000.00' AND cartype = '".$pass_car_id."' AND dateexp >= '".date('Y-m-d')."' ORDER BY name ASC";
		$tb_acc_query=mysql_query($tb_acc_sql,$cndb1);
		while($tb_acc_array=mysql_fetch_array($tb_acc_query))
		{ ?>
		htmlcardetail+='<option value="<?=$tb_acc_array['id']?>" <?php if($tb_acc_array['id']==$array_car_detail[1]){echo "selected";} ?>><?=$tb_acc_array['name']?></option>';
		<?php } ?>
		htmlcardetail+='</select>';
		htmlcardetail+='</td>';
		htmlcardetail+='<td width="20%" align="center">';
		htmlcardetail+='</td>';
		htmlcardetail+='</tr>';
		<?php
		$tb_acccl_sql="SELECT name,price FROM tb_acc WHERE id = '".$array_car_detail[1]."'";
		$tb_acccl_query=mysql_query($tb_acccl_sql,$cndb1);
		$tb_acccl_array=mysql_fetch_array($tb_acccl_query);
		$totaltuncl+=$tb_acccl_array['name'];
		$totalprecl+=$tb_acccl_array['price'];
		?>


 
$('#MORE_ADD').append(htmlcardetail);
NUMBER_edit++;

		<?php $SS++; }
 } } ?>
 $("#price_acc_tun").val("<?=number_format($totaltuncl)?>");
 $("#price_acc_cost").val("<?=number_format($totalprecl)?>");
$('#COUNTMORE').val(NUMBER_edit);
$("#SaveInsurance_edit").click(function() 
{
	$('#SaveInsurance_edit').css("display", "none");
	$('#BlockSAVE').css("display", "");
	SaveI_edit();
});
function SaveI_edit()
{
	$('#SaveInsurance_edit').css("display", "none");
	$('#BlockSAVE').css("display", "");
	
	Array.prototype.contains = function( obj )
	{
		var i = this.length;
		while ( i-- )
		{
			if ( this[i] === obj )
			{
				return true;
			}
		}
		return false;
	}
	String.prototype.isPhoneNumber = function( )
	{
	 	var invalidPhoneNumber = ["999-999-9999","888-888-8888","777-777-7777","666-666-6666","555-555-5555","444-444-4444","333-333-3333","222-222-2222","111-111-1111","000-000-0000"];
		if ( invalidPhoneNumber.contains( this.toString( ) ) )
		{
	  		return false;
	 	}
	 	return true;
	}
	// วิธีใช้
	var phone = $('#tel_mobi').val();
	if ( phone.isPhoneNumber( ) )
	{
	}
	else
	{
		$("#tel_mobi").focus();
		alert('กรุณากรอกเบอร์มือถือใหม่');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	
	if($("#xuser").val()=='admin'){
		if($("#Dxuser").val()==0){
			$("#Dxuser").focus();
			alert('กรุณาเลือกรหัสผู้แจ้ง');
			$('#SaveInsurance_edit').css("display", "");
			$('#BlockSAVE').css("display", "none");
			return false;
		}
	}
	// addon
	if($("#check_addonY").val()=='')
	{
            
		$("#checkAddonN").focus();
		alert('กรุณาเลือกประกันภัย Add On');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}else if($("#check_addonY").val()=='Y'){    // มีประกันภัย Addon แต่ยังไม่ได้คลิกเลือก
                
				var c=0;
				for(var n=0;n<document.getElementsByName("addon_buy[]").length;n++)
				{
					if(document.getElementsByName("addon_buy[]")[n].checked==false)
					{
						c++;
					}
				}
				if(document.getElementsByName("addon_buy[]").length==c)
				{
					alert('กรุณาเลือกประกันภัย Add On');
					$("#checkAddonN").focus();
					$('#SaveInsurance_edit').css("display", "");
					$('#BlockSAVE').css("display", "none");
					return false;
				}
        }
      
	////////////////////////////////////////////////////
	if($("#cartype").val()==0){
		$("#cartype").focus();
		alert('กรุณาเลือกประเภทการใช้งาน');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#car_id").val()==0){
		$("#car_id").focus();
		alert('กรุณาเลือกลักษณะใช้งาน');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#cat_car").val()==0){
		$("#cat_car").focus();
		alert('กรุณาเลือกประเภทรถ');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#br_car").val()==0){
		$("#br_car").focus();
		alert('กรุณาเลือกยี่ห้อรถ');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#mo_car").val()==0){
		$("#mo_car").focus();
		alert('กรุณาเลือกรุ่นรถ');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#car_cc").val()==0){
		$("#car_cc").focus();
		alert('กรุณาเลือกจำนวน ซี.ซี.');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#car_wgt").val()==0){
		$("#car_wgt").focus();
		alert('กรุณาเลือกน้ำหนัก');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#car_seat").val()==0){
		$("#car_seat").focus();
		alert('กรุณาเลือกจำนวนที่นั่ง');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#gear").val()==0){
		$("#gear").focus();
		alert('กรุณาเลือกเกียร์');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#new_carbody").val()==0){
		$("#mo_car").focus();
		alert('กรุณาเลือกรุ่นรถ');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#car_body").val()==0){
		$("#car_body").focus();
		alert('กรุณากรอกเลขตัวถัง 8 ตัวหลัง');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#new_motor").val()==0){
		$("#mo_car").focus();
		alert('กรุณาเลือกรุ่นรถ');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#n_motor").val()==0){
		$("#n_motor").focus();
		alert('กรุณากรอกเลขเครื่อง 6 ตัวหลัง');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#car_regis_pro").val()==0){
		$("#car_regis_pro").focus();
		alert('กรุณาเลือกจังหวัดทะเบียนรถ');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#car_color").val()==0){
		$("#car_color").focus();
		alert('กรุณาเลือกสีรถ');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#name_gain").val()=='0'){
		$("#name_gain").focus();
		alert('กรุณาเลือกผู้รับผลปะโยชน์');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#p_act3").val()==0){
		$("#p_act3").focus();
		alert('กรุณากรอกเลข พ.ร.บ. หรือกรณีไม่ซื้อ พ.ร.บ. กรอก "9999999"');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#id_acc0").val()==0 || $("#id_price0").val()==0){
		CheckT();
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#icard").val()==0){
		$("#icard").focus();
		alert('กรุณากรอกเลขบัตรประชาชน หรือ เลขหมายทะเบียนการค้า 13 หลัก');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#title").val()==0){
		$("#title").focus();
		alert('กรุณาเลือกคำนำหน้าชื่อ');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#name_name").val()==0){
		$("#name_name").focus();
		alert('กรุณากรอกชื่อ');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#last").val()==0){
		$("#last").focus();
		alert('กรุณากรอกนามสกุล');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#add").val()==0){
		$("#add").focus();
		alert('กรุณากรอกบ้านเลขที่');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#province").val()==0){
		$("#province").focus();
		alert('กรุณาเลือกจังหวัด');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#amphur").val()==0){
		$("#amphur").focus();
		alert('กรุณาเลือกอำเภอ');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#tumbon").val()==0){
		$("#tumbon").focus();
		alert('กรุณาเลือกตำบล');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#email").val()==0){
		$("#email").focus();
		alert('กรุณากรอกอีเมล์');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#com_data").val()==0){
		$("#com_data").focus();
		alert('กรุณาเลือกบริษัทประกันภัย');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#costCost").val()==0){
		$("#costCost").focus();
		alert('กรุณาเลือกทุนประกันภัย');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#tel_mobi").val()==0){
		$("#tel_mobi").focus();
		alert('คุณลืมกรอกเบอร์มือถือ');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#finance_add_tun").val()==0){
		$("#finance_add_tun").focus();
		alert('กรุณาเลือกไฟแนนซ์เพิ่มทุน');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#vocation").val()==''){
		$("#vocation").focus();
		alert('กรุณากรอกอาชีพผู้เอาประกัน');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	if($("#send_add_Y:checked").val()=='Y')
	{
		if($("#send_add").val()==''){
		$("#send_add").focus();
		alert('กรุณากรอกบ้านเลขที่');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
		if($("#send_group").val()==''){
		$("#send_group").focus();
		alert('กรุณากรอกหมู่');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
		if($("#send_town").val()==''){
		$("#send_town").focus();
		alert('กรุณากรอกอาคาร/หมู่บ้าน');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
		if($("#send_lane").val()==''){
		$("#send_lane").focus();
		alert('กรุณากรอกซอย');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
		if($("#send_road").val()==''){
		$("#send_road").focus();
		alert('กรุณากรอกถนน');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
		if($("#send_province").val()==''){
		$("#send_province").focus();
		alert('กรุณาเลือกจังหวัด');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
		if($("#send_amphur").val()==''){
		$("#send_amphur").focus();
		alert('กรุณาเลือกอำเภอ');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
		if($("#send_tumbon").val()==''){
		$("#send_tumbon").focus();
		alert('กรุณาเลือกตำบล');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
		if($("#send_post").val()==''){
		$("#send_post").focus();
		alert('กรุณาเลือกไปรษณีย์');
		$('#SaveInsurance_edit').css("display", "");
		$('#BlockSAVE').css("display", "none");
		return false;
	}
	}
		var DATA = $('#Insurance').serialize();
		var SAVE = {
			type: "POST",
			async:false,
			dataType: "json",
			url: "ajax/Ajax_InsuranceSave_edit.php?id_data=<?=$_POST['id_data']?>",
			data: DATA,
			success: function(msg) {
				var returnedArray = msg;
				alert(returnedArray.msg);
				if(returnedArray.idperson == 1)
				{
                                    $('a[onclick="load_page(\'pages/load_Individuals.php\',\'บุคคลธรรมดา\');"]').trigger('click');
				}
				else if(returnedArray.idperson == 2)
				{
                                    $('a[onclick="load_page(\'pages/load_Corporation.php\',\'นิติบุคคล\');"]').trigger('click');
				}
				else
				{
									$('a[onclick="load_page(\'pages/load_Foreigner.php\',\'ชาวต่างชาติ\');"]').trigger('click');
				}
				$('#SaveInsurance_edit').css("display", "");
				$('#BlockSAVE').css("display", "none");
			},
			error:function(msg) {
				var returnedArray = msg;
				alert('การบันทึกผิดพลาด');
			}
		};
			$.ajax(SAVE);
	
}
</script>