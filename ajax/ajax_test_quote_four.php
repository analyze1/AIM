<?php
// include "../inc/checksession.inc.php";
include "../inc/connectdbs.pdo.php";

	 $id_data=$_POST['id_data'];
	 $detail_renew=explode("|",$_POST['detail_data']);
	//  mysql_select_db($db2,$cndb2);
	 $sqlRes = " SELECT * FROM tb_protection";  
	 $sqlRes .= " WHERE  protect_type = '".$detail_renew[12]."' "; 
	 $resSql = PDO_CONNECTION::fourinsure_insured()->query($sqlRes);
	 $row_pro = $resSql->fetch(2);
	 
	$comp_insure = $row_pro["comp_insure"];
	$driverticket = $row_pro["driverticket"];
	$pa1 = $row_pro["driver"];
	$people = $row_pro["tickets"];
	$pa2 = $row_pro["passenger"];

	$pa4 = $row_pro["insuran"];
	$pa3 = $row_pro["nurse"];

	$damage_out1 = $row_pro["life"];
	$maxlife = $row_pro["maxlife"];
	$damage_cost = $row_pro["asset"];
	$none_disone = 'ไม่มี';
		
	$query = "SELECT ";
		
	$query .= "data.doc_type,";
	$query .= "data.service, "; // ประเภทการซ่อม
	$query .= "data.com_data, ";
	$query .= " act.p_net,";
	$query .= "data.o_insure, "; // เลขที่กรมธรรมเดิม
	$query .= "data.start_date, "; // วันที่คุ้มครอง	
	$query .= "data.end_date, "; // วันที่สิ้นสุด
	$query .= "data.name_gain, "; // ชื่อผู้รับผลประโยชน์
	$query .= "insuree.title, "; // คำนำหน้า ชื่อผู้เอาประกัน
	$query .= "insuree.name,  "; // ชื่อผู้เอาประกัน
	$query .= "insuree.last, "; // นามสกุลผู้เอาประกัน
	$query .= "insuree.person, ";
	$query .= "insuree.icard, ";
	$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
	$query .= "detail.br_car as id_br_car, "; // ยี่ห้อรถ
	$query .= "detail.mo_car as id_mo_car, "; // รุ่นรถ
	
	$query .= "detail.id_data_company, ";
	$query .= "detail.car_color, "; // สีรถ
	$query .= "detail.cc, "; // ซี ซ
	$query .= "detail.car_wg, "; // น.น.
	$query .= "detail.car_seat, ";
	$query .= "detail.car_regis, "; // ทะเบียนรถ
	$query .= "detail.car_regis_pro, "; // ทะเบียนรถ
	$query .= "detail.cat_car, ";
	$query .= "detail.car_body, "; // เลขตัวถัง
	$query .= "detail.mo_car, "; // ปีที่จดทะเบียน
	$query .= "detail.n_motor, "; // เลขเครื่อง
	$query .= "detail.cost_renew, ";
	$query .= "detail.regis_date, ";
	$query .= "detail.gear, ";
	$query .= "protect.pa1, "; // ยอดชำระ
	$query .= "protect.pa2, ";
	$query .= "protect.pa3, ";
	$query .= "protect.pa4, ";
	$query .= "protect.people, ";
	$query .= "protect.damage_out1, ";
	$query .= "protect.damage_cost, ";
	$query .= "premium.one, ";
	
	//กรณีระบุชื่อผู้ขับขี่
	$query .= "driver.title_num1, "; // ผู้ขับขี่ที่ 1
	$query .= "driver.name_num1, ";
	$query .= "driver.last_num1, ";
	$query .= "driver.birth_num1, "; // วัน/เดือน/ปี (วันเกิด)
	$query .= "driver.title_num2, "; // ผู้ขับขี่ที่ 2
	$query .= "driver.name_num2, ";
	$query .= "driver.last_num2, ";
	$query .= "driver.birth_num2 "; // วัน/เดือน/ปี (วันเกิด)
	
	$query .= "FROM data ";
	
	$query .= "LEFT JOIN detail ON (data.id_data = detail.id_data) ";
	$query .= "LEFT JOIN driver ON (data.id_data = driver.id_data)  ";
	$query .= "LEFT JOIN protect ON (data.id_data = protect.id_data) ";
	$query .= "LEFT JOIN act ON (data.id_data = act.id_data)  ";
	$query .= "LEFT JOIN insuree ON (data.id_data = insuree.id_data) ";	
	$query .= "LEFT JOIN premium ON (data.id_data = premium.id_data) ";
	$query .= "WHERE data.id_data='".$id_data."' ";
	$objQuery = PDO_CONNECTION::fourinsure_insured()->query($query);
	$row=$objQuery->fetch(2);
	if(empty($detail_renew[12]))
	{
	$comp_insure = '0';
	$driverticket = '0';
	$pa1 = $row["pa1"];
	$people = $row["people"];
	$pa2 = $row["pa2"];

	$pa4 = $row["pa4"];
	$pa3 = $row["pa3"];

	$damage_out1 = $row["damage_out1"];
	$maxlife = "10000000";
	$damage_cost = $row["damage_cost"];
	$one = $row["one"];
	if($one <= 0 && $one == '')
	{
	$none_disone = 'ไม่มี';
	}
	else
	{
	$none_disone = 'มี';
	}
	
	}
	function insure($comp)
	{
		switch($comp) 
		{
			case "NVI": $comp = "นวกิจ"; break;
			case "MSIG": $comp = "เอ็มเอสไอจี"; break;
			case "NSI": $comp = "นำสิน"; break;
			case "BKI": $comp = "กรุงเทพ"; break;
			case "DEV": $comp = "เทเวศ"; break;
			case "TSI": $comp = "ไทยศรี"; break;
			case "STY": $comp = "คุ้มภัย [สำนักงานใหญ่]"; break;
			case "SCSMG": $comp = "ไทยพาณิชย์"; break;
			case "VIB": $comp = "วิริยะ [สำนักงานใหญ่]"; break;
			case "VIB_S": $comp = "วิริยะ [ปากเกร็ด]"; break;
			case "VIB_Y": $comp = "วิริยะ [สุขาภิบาล 3]"; break;
			case "AI1": $comp = "เอเชีย"; break;
			case "LMG": $comp = "แอลเอ็มจี"; break;
			case "KUI": $comp = "เคเอสเค "; break;
			case "BUI": $comp = "บางกอกสหประกันภัย"; break;
			case "AXA": $comp = "แอกซ่า"; break;
			case "SEI": $comp = "อาคเนย์"; break;
			case "SIP": $comp = "สินมั่นคง"; break;
			case "VIB_S103": $comp = "วิริยะ [ปากเกร็ด 10320]"; break;
			case "BKI[MBLT]": $comp = "กรุงเทพ [MBLT]"; break;
			case "TIP": $comp = "ทิพยประกันภัย"; break;
			case "STY_S": $comp = "คุ้มภัย"; break;	
		}
		return $comp;
	}

	$discountuse = array();
	$sql = "SELECT * FROM tb_agent order by full_name asc";

	$result = PDO_CONNECTION::fourinsure_insured()->query($sql);
	foreach( $result->fetchAll(2) as $fetcharr  )
	{ 
		$discountuse[$fetcharr['id_agent']] = $fetcharr['agent_dis'];
	}
$css_margin='margin:0;';
$css_margin_font='margin-top:0px;';
$css_margin_font_tab='margin-left:10px;';
$css_margin_font_tab_right='margin-right:30px; float: right;';
$css_margin_left_resize_ti='margin-left:0px; margin-top:7px; text-align: center; width:300px;';
$css_margin_right_resize_ti='margin:0px;text-align:center;width:30px;height:30px;float: right;color:#FFFFFF;line-height: normal;';
$css_padding_left='padding-left:30px;';
$css_padding_right='padding-right:30px;';
$css_font_right='padding-right:30px;text-align:right';
$css_margin_form_bottom='margin-bottom:10px;';


?>
<style>
.ui-widget-overlay {
		z-index: 1100;
	}
	.ui-dialog {
		z-index: 1101;
	}
	.ui-dialog .ui-dialog-titlebar-close span {
    margin-left: 0px;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
    top: 0px;
    left: 0px;
	}
</style>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script src="js/total.js" type="text/javascript"></script>
 	<script type="text/javascript" src="js/jquery.imask.js"></script>
    <script type="text/javascript" src="js/jquery.maskedinput-1.2.2.js"></script>




<div class='font-design'>
<form name="webForm" id="webForm">
<div class='design-ti_5 span12' style='<?=$css_margin?> '>
<div class='font-resize-ti span3' style='<?=$css_padding_left?>'><font style='color:#FFFFFF;'>ข้อมูลผู้เอาประกัน</font></div>
<div class='font-resize-ti span3' style='<?=$css_margin_right_resize_ti?>'></div>
</div>
<div class='design-form span12' style='<?=$css_margin.$css_margin_form_bottom;?>'>
<?php if($_SESSION["4User"]=="SAK" || $_SESSION["4User"]=="DAO"  || $_SESSION["4User"]=="NAPA"){ ?>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ผู้เสนอ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name='emp' id='emp' class='span10 e-span10' onchange="onChange(this.form), calcfunc();">
<option  value= 'N' >--กรุณาเลือกผู้แจ้งงาน--</option>
<?php
$sql = "SELECT * FROM tb_user WHERE s_name='1' order by sub asc";
$result = PDO_CONNECTION::fourinsure_insured()->query($sql);
foreach($result->fetchAll(2) as $fetcharr)
{ 
$id_emp = $fetcharr['user'];
$name_emp = "[ ".$fetcharr['user']." ] ".$fetcharr['title_sub'].$fetcharr['sub'];
?>
<option value='<?=$id_emp;?>'><?=$name_emp;?></option>
<?php } ?>
</select>
</div>
</div>
<?php } ?>
<div class='span12 e-span12' style='<?=$css_margin?>display:none;'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>รหัสลูกค้า/ตัวแทน :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name='agent' id='agent' class='span10 e-span10' onchange="onChange(this.form), calcfunc();">
<?php
$sql = "SELECT * FROM tb_agent where id_agent = 'C0001'  order by full_name asc";
$result =  PDO_CONNECTION::fourinsure_insured()->query($sql);
foreach($result->fetchAll(2) as $fetcharr)
{ 
$id_agent = $fetcharr['id_agent'];
$agent_dis = $fetcharr['agent_dis'];
$name_agent = $fetcharr['full_name']; ?>
<option value='<?=$id_agent;?>' ><?=$name_agent;?></option>
<?php } ?>
</select>
<input type="hidden" name="end_date_old" id="end_date_old" size="18" maxlength="50" value= ''/>
<input type="hidden" name="id_data_old" id="id_data_old" size="18" maxlength="50" value= ''/>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ลูกค้า/ดิลเลอร์ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="customer" id="customer" class='span10 e-span10' onchange="js_customer()">
<option value="0">--เลือก--</option>
<option value="1" selected>ลูกค้า</option>
<option value="2">ดิลเลอร์</option>               
</select>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>' id='agent_group_t'></font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>' id='agent_group_i'>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บุคคล/นิติบุคคล :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="person" id="person" class='span10 e-span10'>
<option value="0">--เลือก--</option>
<option value="1" <?php if($row['person']=='1'){echo "selected";}?> >บุคคลธรรมดา</option>
<option value="2" <?php if($row['person']=='2'){echo "selected";}?> >นิติบุคคล</option>
<option value="3">บุคคลในนามบริษัท</option>
</select>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>คำนำหน้า</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input type="hidden" id="code" name="code" readonly="readonly" />
<select id="title" name="title" class='span10 e-span10'>
<option value="0" selected="0">--เลือกคำนำหน้า--</option>
<?php
$select_title_sql="SELECT * FROM tb_titlename";
$result =  PDO_CONNECTION::fourinsure_insured()->query($select_title_sql);
foreach($result->fetchAll(2) as $select_title_array)

{ ?>
<option value="<?=$select_title_array['prename'];?>" <?php if(str_replace(' ','',$row['title'])==$select_title_array['prename']){echo "selected"; }?>><?=$select_title_array['prename'];?></option>
<?php } ?>
</select>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ชื่อจริง-นามสกุล :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<input name="name" id="name" class='span10 e-span10' value= '<?=$row['name']?>' placeholder='ชื่อจริง' />
</div>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<input name="last" id="last" class='span10 e-span10' value= '<?=$row['last']?>' placeholder='นามสกุล'  />
</div>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>display:none;'><!--อาจจะซ่อน-->
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>สถานที่ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input type="text" name="in_career" class='span10 e-span10' id="in_career" />
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บ้านเลขที่ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input id="add" maxlength="30" class='span10 e-span10' name="add" value = ''/>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>หมู่บ้าน :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input name="town" id="town" class='span10 e-span10' />
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ซอย :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input id="lane" name="lane"  class='span10 e-span10'/>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ถนน :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input id="road" name="road"  class='span10 e-span10' />
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>จังหวัด :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name='province' id='province' class='span10 e-span10'>
<option value='0'>--กรุณาเลือกจังหวัด--</option>
<?php

$sql = "SELECT * FROM tb_province";
$result =  PDO_CONNECTION::fourinsure_insured()->query($sql);
foreach($result->fetchAll(2) as $fetcharr)
{ 
$sort = $fetcharr['id'];
$name = $fetcharr['name']; ?>
<option value='<?=$sort;?>' ><?=$name;?></option>
<?php } ?>
</select>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>อำเภอ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="amphur" id="amphur" class='span10 e-span10'>
<option value="0">--เลือก--</option>
</select>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ตำบล :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="tumbon" id="tumbon" class='span10 e-span10'>
<option value="0">--เลือก--</option>
</select>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>รหัสไปรษณีย์ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="postal" id="postal" class='span10 e-span10'>
<option value="$province">--เลือก--</option>
</select>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>อีเมล์ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input type="text" id="email" name="email" value = '' class='span10 e-span10'>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>เบอร์มือถือ 1 :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input type="text" id="tel_mobile" name="tel_mobile" value = '' class='span10 e-span10'>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>เบอร์มือถือ 2 :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input type="text" id="tel_mobile2" name="tel_mobile2" class='span10 e-span10'>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>เบอร์บ้าน/ที่ทำงาน :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<div class='span7 e-span7' style='<?=$css_margin?>'>
<input type="text" id="tel_home" name="tel_home" class='span12 e-span12' />
</div>
<div class='span2 e-span2' style='<?=$css_margin?>'><center>ต่อ :</center></div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<input size="5" type="text" id="tel_home" name="tel_home" class='span10 e-span10' />
</div>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>เบอร์แฟกซ์ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input type="text" id="tel_fax" name="tel_fax" value = '' class='span10 e-span10'/>
</div>

</div>

</div><!--END อาจจะซ่อน-->

</div>


<div class='design-ti_5 span12' style='<?=$css_margin?> '>
<div class='font-resize-ti span3' style='<?=$css_padding_left?>'><font style='color:#FFFFFF;'>ข้อมูลทั่วไป</font></div>
<div class='font-resize-ti span3' style='<?=$css_margin_right_resize_ti?>'></div>
</div>
<div class='design-form span12' style='<?=$css_margin.$css_margin_form_bottom;?>'>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ประเภท :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="doc_type" id="doc_type" class='span10 e-span10'>
<option value="0">-- เลือกประเภท --</option>
<option value="1" <?php if($detail_renew[1]=='1'){echo "selected";} ?> >1</option>
<option value="2+" <?php if($detail_renew[1]=='2+'){echo "selected";} ?> >2+</option>
<option value="2" <?php if($detail_renew[1]=='2'){echo "selected";} ?> >2</option>
<option value="3+" <?php if($detail_renew[1]=='3+'){echo "selected";} ?> >3+</option>
<option value="3" <?php if($detail_renew[1]=='3'){echo "selected";} ?> >3</option>
</select>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บริษัทประกันภัย :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name='com_data' id='com_data' class='span10 e-span10'>
<option  value='0'>--กรุณาเลือกบริษัท--</option>
<?php
$sql = "SELECT * FROM tb_comp where sort != 'VIB_Y' && sort != 'VIB' && sort != 'VIB_S09712' && sort != 'SCSMG_O' and use_comp='1' ORDER BY name ASC ";
$result =  PDO_CONNECTION::fourinsure_insured()->query($sql);
foreach($result->fetchAll(2) as $fetcharr)
{ 
$sort = $fetcharr["sort"];
$name = $fetcharr['name']; ?>
<option value='<?=$sort;?>' <?php if($sort==$detail_renew[0]){echo "selected";}?>><?=$name;?></option>
<?php } ?>
</select>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>การรับแจ้ง :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="ty_inform" id="ty_inform" class='span10 e-span10'>
  <option value="">--เลือกประเภทการรับแจ้ง--</option>
  <option value="L">L = ประกันใหม่ป้ายแดง</option>
  <option value="N" selected>N = ประกันใหม่</option>
  <option value="R">R = ประกันภัยต่ออายุในสาขา</option>
  <option value="I">I = ประกันภัยต่ออายุต่างบริษัท</option>
  <option value="O">O = ประกันต่ออายุต่างสาขา</option>
</select>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ประเภทการซ่อม :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="service" id="service" class='span10 e-span10'>
  <option value="0">--เลือกประเภทการซ่อม--</option>
  <option value="1" <?php if($detail_renew[6]=='1'){echo "selected";} ?> >ซ่อมห้าง</option>
  <option value="2" <?php if($detail_renew[6]=='2'){echo "selected";} ?> >ซ่อมอู่</option>
</select>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>วันคุ้มครอง :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<?php 
$new_date_check=date('Y-m-d',strtotime($row['end_date']." +0 Year"));
$new_date = date('d-m-Y',strtotime($row['end_date']." +0 Year"));
if($new_date_check>=date('Y-m-d'))
{
	$start_date=$new_date;
}
else
{
	$start_date=date('Y-m-d');
}
?>
<input id="start_date" name="start_date" type="text" class='span10 e-span10' value='<?=$start_date;?>' readonly="readonly" />
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>เลขกรมธรรม์เดิม :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input id="o_insure" name="o_insure" type="text" class='span10 e-span10'  value = '<?=$row['id_data_company'];?>'/>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<?php
if(strlen($row['car_id'])<=3)
{
	$type_car=substr($row['car_id'],0,1);
	$nature_car=substr($row['car_id'],1,3);
}
else
{
	$type_car=substr($row['car_id'],0,2);
	$nature_car=substr($row['car_id'],2,4);
}
?>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ประเภทการใช้ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name='cartype' id='cartype' class='span10 e-span10'>
<option value='0'>--กรุณาเลือกประเภท--</option>
<?php
	$sql = "SELECT id, name FROM tb_pass_car";
	$result =  PDO_CONNECTION::fourinsure_insured()->query($sql);
foreach($result->fetchAll(2) as $fetcharr)
	{ 
		$id = $fetcharr['id'];
		$name = $fetcharr['name']; ?>
	<option value='<?=$id;?>' <?php if($detail_renew[15]==$id){echo "selected";} ?> ><?=$id." : ".$name;?></option>
	<?php } ?>
</select>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ลักษณะใช้งาน :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="car_id" id="car_id_renew" class='span10 e-span10'>
<option value="0">--เลือกลักษณะใช้งาน--</option>
<?php
$sql = "SELECT id, name FROM tb_pass_car_type WHERE id_pass_car='".$detail_renew[15]."' ORDER By id";
$result =  PDO_CONNECTION::fourinsure_insured()->query($sql);

	$i=0;
	foreach($result->fetchAll(2) as $fetcharr)
	{ ?>
	<option value='<?=$type_car.$fetcharr['id'];?>' <?php if($fetcharr['id']==$nature_car){echo "selected";} ?>><?=$fetcharr['id']." : ".$fetcharr['name'];?></option>
<?php } ?>
</select>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ประเภทรถ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name='cat_car' id='cat_car' class='span10 e-span10'>   
<option value='0'>--กรุณาเลือกประเภท--</option>
<?php  
	$sql = "SELECT id, name FROM tb_cat_car";
	$result = PDO_CONNECTION::fourinsure_insured()->query($sql);
	foreach($result->fetchAll(2) as $fetcharr)
	{ 
		$id = $fetcharr['id'];
		$name = $fetcharr['name']; ?>
		<option value='<?=$id;?>' <?php if($detail_renew[15]==$id){echo "selected";}?> ><?=$name;?></option>
	<?php } ?>
</select>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ยี่ห้อรถ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="br_car" id="br_car" class='span10 e-span10'>
 <option value="0">--เลือกยี่ห้อรถ--</option>
 <?php
$tb_br_car_sql="SELECT id,name FROM tb_br_car WHERE id = '".$detail_renew[16]."'";
$tb_br_car_query=PDO_CONNECTION::fourinsure_insured()->query($tb_br_car_sql);
foreach($tb_br_car_query->fetchAll(2) as $tb_br_car_array)
{  ?>
<option value="<?php echo $tb_br_car_array['id']; ?>" <?php if($tb_br_car_array['id']==$detail_renew[16]){echo "selected";} ?> ><?php echo $tb_br_car_array['name']; ?></option>
<?php } ?>
</select>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>รุ่นรถ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="mo_car" id="mo_car" class='span10 e-span10'>
  <option value="0">--เลือกรุ่นรถ--</option>
    <?php
$tb_mo_car_sql="SELECT tb_mo_car.id,tb_mo_car.name FROM tb_mo_car 
INNER JOIN tb_br_car ON tb_br_car.id = tb_mo_car.br_id
WHERE tb_br_car.id = '".$detail_renew[16]."'";
$tb_mo_car_query=PDO_CONNECTION::fourinsure_insured()->query($tb_mo_car_sql);
foreach($tb_mo_car_query->fetchAll(2) as $tb_mo_car_array)

{ ?>
<option value="<?php echo $tb_mo_car_array['id']; ?>" <?php if($detail_renew[17]==$tb_mo_car_array['id']){echo "selected";} ?>><?php echo $tb_mo_car_array['name']; ?></option>
<?php } ?>
</select>

</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>เกียร์ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="gear" id="gear" class='span10 e-span10'>
  <option value="0">--เลือกเกียร์--</option>
  <option value="N" <?php if($row['gear']=='N'){echo "selected";}?>>ไม่ระบุ</option>
  <option value="A" <?php if($row['gear']=='A'){echo "selected";}?> >อัตโนมัติ</option>
  <option value="M" <?php if($row['gear']=='M'){echo "selected";}?> >ธรรมดา</option>
</select>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ซี.ซี. / น.น. / ที่นั่ง</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<div  class='span3 e-span3' style='<?=$css_margin?>'>
<input name="cc" type="text" id="cc" class='span12 e-span12' placeholder='ซี.ซี.' maxlength="4" value="<?=$row['cc'];?>"/>
</div>
<div class='span1 e-span1' style='<?=$css_margin?>text-align:center;'>
/
</div>
<div  class='span3 e-span3' style='<?=$css_margin?>'>
<input name="wg" type="text" class='span12 e-span12' id="wg" placeholder='น.น.' maxlength="5" value="<?=$row['car_wg'];?>"/>
</div>
<div  class='span1 e-span1' style='<?=$css_margin?>text-align:center;'>
/
</div>
<div  class='span3 e-span3' style='<?=$css_margin?>'>
<input type="text" class='span12 e-span12' name="car_seat" id="car_seat" placeholder='ที่นั่ง' value='<?=$row['car_seat'];?>'>
</div>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ปีจดทะเบียน :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<div class='span8 e-span8' style='<?=$css_margin?>'>
<?php
		$Y = date("Y");
		$Yearro = $Y-$detail_renew[15];

?>
<select name="regis_date" id="regis_date_inform" class='span10 e-span12' onchange="javascript:showCarAge();">
  <option  value='<?=$Yearro?>'><?=$Yearro?></option>
  	<!-- <?php
  		$i = 0;
		$yyy = date("Y");
  		while ($i<=50) {
			$cal = $yyy - $i; ?>
			<option value='<?=$cal;?>' <?php if($cal==$detail_renew[18]){echo "selected";} ?>><?=$cal;?></option>
	<?php $i++; }  ?> -->
</select>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input name="year_old" type="text" id="year_old" value="<?=$Yearro?>" class='span10 e-span10' readonly="true"/>
</div>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ทะเบียนรถ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<select name="chose_carregis" class='span10 e-span10' id="chose_carregis" onchange='js_car_regis_show();'>
  <option value="0">--เลือกทะเบียน--</option>
  <option value="1">ป้ายแดง</option>
  <option value="2" <?php if(!empty($row['car_regis']) && $row['car_regis']!='' && $row['car_regis']!='-'){echo "selected"; $display_car_regis='';}else{$display_car_regis='display:none;';}?>>อื่นๆ</option>
</select>
</div>
<div class='span6 e-span6' style='<?=$css_margin.$display_car_regis?>' id='car_regis_show'>
<input name="car_regis" type="text" id="car_regis" class='span10 e-span10' value='<?=$row['car_regis'];?>'>
</div>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>จังหวัดทะเบียน :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name='car_regis_pro' id='car_regis_pro' class='span10 e-span10'>
<option value='0'>--เลือกจังหวัด--</option>
<?php


	$sql = "SELECT * FROM tb_province";
	$result=PDO_CONNECTION::fourinsure_insured()->query($sql);
foreach($result->fetchAll(2) as $fetcharr)


	{ 
		$id = $fetcharr['id'];
		$name = $fetcharr['name']; ?>
		<option value='<?=$id?>' <?php if($row['car_regis_pro']==$id){echo "selected";}?> ><?=$name?></option>
	<?php } ?>
</select>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>สีรถ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="car_color" id="car_color" class='span10 e-span10'>
<?php
if(!empty($row['car_color']))
{ ?>
<option value='<?=$row['car_color'];?>'><?=$row['car_color'];?></option>
<?php } else { ?>
<option>-- เลือกสีรถ --</option>
<?php } ?>
  
  <option value="ไม่ระบุ">ไม่ระบุ</option>
  <option value="บอร์นเงิน">บอร์นเงิน</option>
  <option value="บอร์นทอง">บอร์นทอง</option>
  <option value="ขาว">ขาว</option>
  <option value="ดำ">ดำ</option>
  <option value="แดง">แดง</option>
  <option value="ฟ้า">ฟ้า</option>
  <option value="เขียว">เขียว</option>
  <option value="ส้ม">ส้ม</option>
  <option value="เทา">เทา</option>
  <option value="เหลือง">เหลือง</option>
  <option value="น้ำเงิน">น้ำเงิน</option>
  <option value="น้ำตาล">น้ำตาล</option>
  <option value="ม่วง">ม่วง</option>
  <option value="ชมพู">ชมพู</option>
</select>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>เลขตัวถัง : </font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input name="car_body" type="text" id="car_body" class='span10 e-span10' maxlength="20" value='<?=$row['car_body'];?>'/>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>เลขเครื่อง :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input name="n_motor" type="text" id="n_motor" class='span10 e-span10' value='<?=$row['n_motor'];?>' maxlength="20" />
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ผู้รับผลประโยชน์ :</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name="name_gain" id="name_gain" class='span10 e-span10'>
<?php if(!empty($row['name_gain']))
{ ?>
<option value="<?=$row['name_gain'];?>" selected="selected"><?=$row['name_gain'];?></option>
<?php } else { ?>
<option value="0" selected="selected">--เลือกชื่อผู้รับผลประโยชน์--</option>
<?php } ?>
    
    <?php 
                $query_accessories ="SELECT * FROM `tb_heiress` ORDER BY `tb_heiress`.`id` ASC"; // id = '1' 
				$result1=PDO_CONNECTION::fourinsure_insured()->query($query_accessories);
				foreach($result1->fetchAll(2) as $fetcharr)
             
            
	{ 
		$name = $fetcharr['name']; ?>
		<option value='<?=$name?>' ><?=$name?></option>
	<?php } ?>
</select>
</div>
</div>

</div>
<div class='design-ti_5 span12' style='<?=$css_margin?> '>
<div class='font-resize-ti span3' style='<?=$css_padding_left?>'><font style='color:#FFFFFF;'>ข้อมูลความคุ้มครอง</font></div>
<div class='font-resize-ti span3' style='<?=$css_margin_right_resize_ti?>'></div>
</div>
<div class='design-form span12' style='<?=$css_margin.$css_margin_form_bottom;?>'>
<div class='span12 e-span12 bk-event' style='display:none;' id='input_insuree_toggle'>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<center>
<font style='<?=$css_margin_font_tab?>' selected="selected">ทุนประกันภัย</font>
</center>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>   
<!-- <input type="text" id="cost" name="cost" class='span10 e-span10' value ='<?=number_format(str_replace(',','',$row['cost_renew']));?>' onkeyup='protection_html_start();'> -->

<select class='span10 e-span10' name="cost" id="cost" onchange='protection_html_start();'> <!-- onkeyup='protection_html_start();' -->
<?php if(!empty($cost_renew))
{ ?>
	<option value="<?=number_format(str_replace(',','',$row['cost_renew']));?>"><?=number_format(str_replace(',','',$cost_renew));?></option>
<?php }
else
{ ?>
	<option value="0">เลือกทุนประกันภัย</option>
<?php } ?>
	  <?php
	  for($n=$detail_renew[3];$n<=$detail_renew[4];$n+=10000)
	  { ?>
<option value="<?=number_format($n);?>"><?=number_format($n);?></option>
	  <?php } ?>
</select>




</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style=''><u>ความรับผิดต่อบุคคลภายนอก</u></font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>- ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<select class='span10 e-span10' name="damage_out1" id="damage_out1" onchange='protection_html_start();' style='background-color: #d1d1d1;color: #555555;'> 
<?php if(!empty($damage_out1))
{ ?>
	<option value="<?=number_format(str_replace(',','',$damage_out1));?>"><?=number_format(str_replace(',','',$damage_out1));?></option>
<?php }
else
{ ?>
	<option value="N">เลือกทุน</option>
<?php } ?>
	  <?php
	  for($n=50000;$n<=20000000;$n+=50000)
	  { ?>
<!-- <option value="<?=number_format($n);?>" disabled style='color: #ffffff;'><?=number_format($n);?></option> -->
	  <?php } ?>
</select>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท/คน</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>- ความเสียหายต่อทรัพย์สิน</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<select class='span10 e-span10' name="damage_cost" id="damage_cost" onchange='protection_html_start();' style='background-color: #d1d1d1;color: #555555;'>
<?php if(!empty($damage_cost))
{ ?>
	<option  value="<?=number_format(str_replace(',','',$damage_cost));?>"><?=number_format(str_replace(',','',$damage_cost));?></option>
<?php }
else
{ ?>
	<option value="0">เลือกความคุ้มครอง</option>
<?php } ?>
<?php
	  for($n=50000;$n<=20000000;$n+=50000)
	  { ?>
<!-- <option value="<?=number_format($n);?>"><?=number_format($n);?></option> -->
	  <?php } ?>
</select>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท/ครั้ง</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style=''><u>ความคุ้มครองตามเอกสารแนบท้าย</u></font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>- ผู้ขับขี่ 1 คน</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<select name="pa1" id="pa1" class='span10 e-span10' onchange='protection_html_start();' style='background-color: #d1d1d1;color: #555555;'>
<?php if(!empty($pa1))
{ ?>
	<option value="<?=number_format(str_replace(',','',$pa1));?>"><?=number_format(str_replace(',','',$pa1));?></option>
<?php }
else
{ ?>
	<option value="N" >เลือกความคุ้มครอง</option>
<?php } ?>

      <option value="0">-ไม่ระบุ-</option>
<?php
	  for($n=50000;$n<=20000000;$n+=50000)
	  { ?>
<!-- <option value="<?=number_format($n);?>"><?=number_format($n);?></option> -->
	  <?php } ?>
</select>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<font style='<?=$css_margin_font_tab?>'>- ผู้โดยสาร</font>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<center><input class='span10 e-span10' id="people"  type="text" name="people" value ='<?php if(!empty($pa1)){echo number_format(str_replace(',','',$people));}else{echo "0";} ?>' onkeyup='protection_html_start();'></center>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<font style='<?=$css_margin_font_tab?>'>คน</font>
</div>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<select class='span10 e-span10' id="pa2" name="pa2" onchange='protection_html_start();' style='background-color: #d1d1d1;color: #555555;'>
<?php if(!empty($pa2))
{ ?>
	<option value="<?=number_format(str_replace(',','',$pa2));?>"><?=number_format(str_replace(',','',$pa2));?></option>
<?php }
else
{ ?>
	 <option value="N" selected="selected">เลือกความคุ้มครอง</option>
<?php } ?>

    <option value="0">-ไม่ระบุ-</option>
	<?php
	  for($n=50000;$n<=20000000;$n+=50000)
	  { ?>
<!-- <option value="<?=number_format($n);?>"><?=number_format($n);?></option> -->
	  <?php } ?>
</select>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท/คน</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>- ค่ารักษาพยาบาล</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<select class='span10 e-span10' id="pa3" name="pa3" onchange='protection_html_start();' style='background-color: #d1d1d1;color: #555555;'>
<?php if(!empty($pa3))
{ ?>
	<option value="<?=number_format(str_replace(',','',$pa3));?>"><?=number_format(str_replace(',','',$pa3));?></option>
<?php }
else
{ ?>
	 <option value="N" selected="selected">เลือกความคุ้มครอง</option>
<?php } ?>
<option value="0">-ไม่ระบุ-</option>
	<?php
	  for($n=50000;$n<=20000000;$n+=50000)
	  { ?>
<!-- <option value="<?=number_format($n);?>"><?=number_format($n);?></option> -->
	  <?php } ?>
</select>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท/คน</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>- การประกันตัวผู้ขับขี่ในคดีอาญา</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<select class='span10 e-span10' id="pa4" name="pa4" onchange='protection_html_start();' style='background-color: #d1d1d1;color: #555555;'>
<?php if(!empty($pa4))
{ ?>
	<option value="<?=number_format(str_replace(',','',$pa4));?>"><?=number_format(str_replace(',','',$pa4));?></option>
<?php }
else
{ ?>
	 <option value="N" selected="selected">เลือกความคุ้มครอง</option>
<?php } ?>

  <option value="0">-ไม่ระบุ-</option>
  	<?php
	  for($n=50000;$n<=20000000;$n+=50000)
	  { ?>
<!-- <option value="<?=number_format($n);?>"><?=number_format($n);?></option> -->
	  <?php } ?>
</select>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท/ครั้ง</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>- ความเสียหายส่วนแรก</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<select class='span10 e-span10' name="none_disone" id="none_disone">
      <option value="0">กรุณาเลือก</option>
      <option value="ไม่มี" <?php if($none_disone=='ไม่มี'){echo "selected"; $style_one='display:none;';} ?> >ไม่มี</option>
      <option value="มี" <?php if($none_disone=='มี'){echo "selected"; $style_one='';} ?> >มี</option>
</select>
</div>
<div class='span6 e-span6' style='<?=$css_margin.$style_one;?>' id='one_input' >
<input class='span10 e-span10' type="text" id="one" name="one" value = '<?=number_format(str_replace(',','',$one));?>' />
</div>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>display:none;' id='one_text'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>



</div>



<div class='span12 e-span12' style='margin:auto;'>
<div class='desing-form-insuree span12' style='width:95%; margin-bottom:20px;margin-left: 2.5%;margin-right: 2.5%;'>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<div class='design-value-insuree'>
<div class='desize-font-deg'><font style='color:#FFFFFF;' size='3'>ค่าความคุ้มครอง</font></div>
</div>
</div>
<div class='span9 e-span9' style='<?=$css_margin?> margin-top: 0px;'>


<div class='span12 e-span12' style='<?=$css_margin?>'>

<!--text-->
<div class='span4 e-span4' style='<?=$css_margin." ".$css_margin_font?>'>
<center><font>ทุนประกันภัย</font></center>
</div>
<!--number-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab_right?>' id='cost_show'></font>
</div>
<!--unit-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
<div class='span2 e-span2' style='<?=$css_margin?>'>
<font style='float:right;'><a type='button' class='btn btn-inverse' onclick='$("#input_insuree_toggle").slideToggle();'>ปรับปรุงทุน</a></font>
</div>
</div>

<div class='span12 e-span12' style='<?=$css_margin?>'>
<!--text-->
<div class='span4 e-span4' style='<?=$css_margin." ".$css_margin_font?>'>
<font><u>ความรับผิดต่อบุคคลภายนอก</u></font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab_right?>'></font>
</div>
<!--unit-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<!--text-->
<div class='span4 e-span4' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>- ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย</font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab_right?>' id='damage_out1_show'></font>
</div>
<!--unit-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท/คน</font>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<!--text-->
<div class='span4 e-span4' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>- ความเสียหายต่อทรัพสิน</font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab_right?>' id='damage_cost_show'></font>
</div>
<!--unit-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท/ครั้ง</font>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<!--text-->
<div class='span4 e-span4' style='<?=$css_margin." ".$css_margin_font?>'>
<font><u>ความคุ้มครองตามเอกสารแนบท้าย</u></font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab_right?>'></font>
</div>
<!--unit-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
</div>

<div class='span12 e-span12' style='<?=$css_margin?>'>
<!--text-->
<div class='span4 e-span4' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>- ผู้ขับขี่ 1 คน</font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab_right?>' id='pa1_show'></font>
</div>
<!--unit-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท/คน</font>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<!--text-->
<div class='span4 e-span4' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>- ผู้โดยสาร</font> <font id='people_show'></font> <font>คน</font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab_right?>' id='pa2_show'><?=$row['pa2']?></font>
</div>
<!--unit-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท/คน</font>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<!--text-->
<div class='span4 e-span4' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>- ค่ารักษาพยาบาล</font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab_right?>' id='pa3_show'></font>
</div>
<!--unit-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท/คน</font>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<!--text-->
<div class='span4 e-span4' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>- การประกันตัวผู้ขับขี่ในคดีอาญา</font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab_right?>' id='pa4_show'></font>
</div>
<!--unit-->
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท/ครั้ง</font>
</div>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
</div>




</div>
</div>
</div>

</div>
<div class='design-ti_5 span12' style='<?=$css_margin?> '>
<div class='font-resize-ti span3' style='<?=$css_padding_left?>'><font style='color:#FFFFFF;'>ข้อมูลเบี้ยประกัน</font></div>
<div class='font-resize-ti span3' style='<?=$css_margin_right_resize_ti?>'></div>
</div>
<div class='design-form span12' style='<?=$css_margin.$css_margin_form_bottom;?>'>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<center><font style='<?=$css_margin_font_tab?>'>เบี้ยสุทธิ</font></center>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<input style="text-align: right;" class='span10 e-span10' type="text" id="pre_inform" name="pre" value="<?=number_format($detail_renew[7],2,'.',',');?>" onkeyup="javascript:calcfunc();" />
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ประเภทเบี้ย</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<select class='span10 e-span10'  id="product" name="product">
	<option value='N'>กรุณาเลือก</option>
	<option value='' selected >เบี้ยปกติ</option>
	<option value='C'>Campaign</option>
	<option value='S'>Single Rate</option>
	</select>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style=''><U>ส่วนลด</U></font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>จำนวนผู้ขับขี่</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<?php
$display_driver1='display:none;';
$display_driver2='display:none;';
?>
<select class='span10 e-span10' name="rdodriver" id="rdodriver">
      <option value="0">กรุณาเลือก</option>
      <option value="N" <?php if($row['title_num1'] == 'ไม่ระบุ' && $row['title_num2'] == 'ไม่ระบุ'){$display_driver1="display:none;"; $display_driver2="display:none;"; echo "selected";}?> >ไม่ระบุ</option>
      <option value="1" <?php if($row['title_num1'] != 'ไม่ระบุ' && $row['title_num2'] == 'ไม่ระบุ'){$display_driver1=""; $display_driver2="display:none;"; echo "selected";}?> >1 คน</option>
      <option value="2" <?php if($row['title_num1'] != 'ไม่ระบุ' && $row['title_num2'] != 'ไม่ระบุ'){$display_driver1=""; $display_driver2=""; echo "selected";}?> >2 คน</option>
</select>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
</div>
<!--ผู้ขับขี่ที่1-->
<div class='span12 e-span12 bk-event' style='<?=$css_margin.$display_driver1?>' id='driver1_inform'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'><u>ผู้ขับขี่คนที่ 1</u></font>
</div>
<div class='span10 e-span10' style='<?=$css_margin?>'>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>คำนำหน้า :</font>
</div>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<select id="title_num1" name="title_num1" class='e-span10'>
<option value="0" >--เลือกคำนำหน้า--</option>
<option value="<?=$row['title_num1'];?>" selected><?=$row['title_num1'];?></option>
<?php
$select_titlename_sql="SELECT * FROM tb_titlename";
$select_titlename_query=PDO_CONNECTION::fourinsure_insured()->query($select_titlename_sql);
				foreach($select_titlename_query->fetchAll(2) as $select_titlename_array)

{ ?>
<option value='<?=$select_titlename_array['prename']?>'><?=$select_titlename_array['prename']?></option>
<?php } ?>
</select>
</div>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ชื่อจริง :</font>
</div>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<input type='text' name="name_num1" id="name_num1" class='e-span10'  maxlength="100" value = '<?=$row['name_num1'];?>'>
</div>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>นามสกุล :</font>
</div>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<input type='text' name="last_num1" id="last_num1" class='e-span10' maxlength="50" value = '<?=$row['last_num1'];?>'>
</div>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>วันเกิด :</font>
</div>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<input type='text' name="birth_num1" id="birth_num1" class='e-span10' maxlength="50" value = '<?=$row['birth_num1'];?>'>
</div>
</div>
</div>
</div>
<!--ผู้ขับขี่ที่1 END-->

<!--ผู้ขับขี่ที่2-->
<div class='span12 e-span12 bk-event' style='<?=$css_margin.$display_driver2?>' id='driver2_inform'>
<div class='span2 e-span2' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'><u>ผู้ขับขี่คนที่ 2</u></font>
</div>
<div class='span10 e-span10' style='<?=$css_margin?>'>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>คำนำหน้า :</font>
</div>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<select id="title_num2" name="title_num2" class='e-span10'>
<option value="0">--เลือกคำนำหน้า--</option>
<option value="<?=$row['title_num2'];?>" selected ><?=$row['title_num2'];?></option>

<?php
$select_titlename_sql="SELECT * FROM tb_titlename";
$select_titlename_query=PDO_CONNECTION::fourinsure_insured()->query($select_titlename_sql);
				foreach($select_titlename_query->fetchAll(2) as $select_titlename_array)


{ ?>
<option value='<?=$select_titlename_array['prename']?>'><?=$select_titlename_array['prename']?></option>
<?php } ?>
</select>
</div>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>ชื่อจริง :</font>
</div>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<input type='text' name="name_num2" id="name_num2" class='e-span10'  maxlength="100" value = '<?=$row['name_num2'];?>'>
</div>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>นามสกุล :</font>
</div>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<input type='text' name="last_num2" id="last_num2" class='e-span10' maxlength="50" value = '<?=$row['last_num2'];?>'>
</div>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>วันเกิด :</font>
</div>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<input type='text' name="birth_num2" id="birth_num2" class='e-span10' maxlength="50" value = '<?=$row['birth_num2'];?>'>
</div>
</div>
</div>
</div>
<!--ผู้ขับขี่ที่2 END-->
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>1. ส่วนลดผู้ขับขี่</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<input style="text-align: right;" class='span10 e-span10' type="text" id="driver" name="driver"  value='0.00'/>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>2. ส่วนลดความเสียหายส่วนแรก</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<input style="text-align: right;" class='span10 e-span10' type="text" id="disone" name="disone" value="0.00" onkeyup="javascript:calcfunc();" />
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>3. กลุ่มตั้งแต่ 3 >  ส่วนลด</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<select onchange="javascript:calcfunc();" class='span10 e-span10' id="group3" name="group3">
        <option selected="selected" value="0">ส่วนลด</option>
        <option value="5">5%</option>
        <option value="10">10%</option>
      </select>
</div>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<input style="text-align: right;" class='span10 e-span10' type="text" id="dis_group3" value="0.00" name="dis_group3" readonly /> 
<input name="total_dis4" type="hidden" id="total_dis4" value="0" size="5" />
</div>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>4. ประวัติดีเป็น %</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<input name="total_dis2" type="hidden" id="total_dis2" value="0" size="5" />
      <select onchange="javascript:calcfunc();" class='span10 e-span10' id="good"  name="good">
        <option selected="selected" value="0">ส่วนลด</option>
        <option value="5">5%</option>
        <option value="10">10%</option>
        <option value="15">15%</option>
        <option value="20">20%</option>
        <option value="25">25%</option>
        <option value="30">30%</option>
        <option value="35">35%</option>
        <option value="40">40%</option>
        <option value="45">45%</option>
        <option value="50">50%</option>
      </select>
	  <input style="width:50px;font-size:14px;text-align:right; color:#006600; font-weight: bold; " id="pro_dis" value="0" size="5" type="hidden" name="pro_dis" onkeyup="javascript:calcfunc();" />
	  <input style="width:100px;font-size:14px;text-align:right; color:#006600; font-weight: bold; " type="hidden" id="pro_dis2" name="pro_dis2" onkeyup="javascript:calcfunc(); javascript:total_pro_dis.value=pro_dis2.value;" value="0.00" />
<input name="total_pro_dis" type="hidden" id="total_pro_dis" value="0" size="5" />
	  </div>
<div class='span6 e-span6' style='<?=$css_margin?>'>
 <input style="text-align: right;" class='span10 e-span10' type="text" id="goodb" value="0.00" name="goodb" readonly />
</div>
</div>
 <div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>เบี้ยสุทธิ หักส่วนลด</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<input style="text-align: right;" value="0.00" class='span10 e-span10' type="text" id="total_pre" name="total_pre" readonly />
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>อากร</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<input style="text-align: right;" class='span10 e-span10' type="text" id="total_stamp" name="total_stamp" value="0.00" readonly />
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>ภาษี 7%</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<input style="text-align: right;" class='span10 e-span10' type="text" id="total_vat" name="total_vat" value="0.00" readonly />
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>เบี้ยรวม</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<input style="text-align: right;" class='span10 e-span10' type="text" id="total_sum" name="total_sum" value="0.00" readonly />
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>เบี้ย พ.ร.บ.</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input type="hidden"  id='actCheck' name='actCheck' value="0" readonly>
<input type="hidden"  id='prb_net' name='prb_net' readonly>
<select id="select_prb" onchange="onChange(this.form), calcfunc();" name="select_prb" class='span12 e-span12'>
<option selected="selected" value="0">--ไม่รวม--</option>
<?php
		$tb_act_sql="SELECT * FROM tb_act ORDER BY id_act ASC";// WHERE id_act IN ('110','140A')
		$tb_act_query=PDO_CONNECTION::fourinsure_insured()->query($tb_act_sql);
				
	
		$n=0;
		$act_net=0;
		$act_total=0;
		$array_pre="";
		foreach($tb_act_query->fetchAll(2) as $tb_act_array)
		{ 
		$n++;
		if($n<=1)
		{
			$array_pre.="'".$n."':'".$tb_act_array['pre_act']."'";
		}
		else
		{
			$array_pre.=",'".$n."':'".$tb_act_array['pre_act']."'";
		}
		?>
			<option value="<?php echo number_format($tb_act_array['net_act'],2,'.',','); ?>" <?php if($tb_act_array['net_act']==$row['p_net']){echo "selected"; $id_act_data=$tb_act_array['id_act']; $act_net=$tb_act_array['pre_act']; $act_total=number_format($tb_act_array['net_act'],2,'.',',');} ?> ><?php echo $tb_act_array['id_act'];?></option>
		<?php } ?>
</select>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<select name='act_sort' id='act_sort'class='span12 e-span12'>
<option  value='0'>เลือกบริษัทพรบ</option>
<option  value='1'>ไม่ระบุ</option>
<?php
	$sql = "SELECT * FROM tb_comp where sort != 'VIB' AND sort != 'VIB_Y' ";
	$result = PDO_CONNECTION::fourinsure_insured()->query($sql);
	foreach($result->fetchAll(2)  as $fetcharr  )
	{ 
		$sort = $fetcharr["sort"];
		$sort_name = insure($fetcharr["sort"]);
		$name = $fetcharr['name']; ?>
		<option value='<?=$sort;?>' <?php if($detail_renew[0]==$sort){echo "selected";}?> ><?=$sort_name;?></option>
	<?php } ?>
</select>
</div>
<div class='span4 e-span4' style='<?=$css_margin?>'>
<input style="text-align: right;" value="<?=number_format($row['p_net'],2,'.',',');?>" class='span12 e-span12' type="text" id="currentValue_prb" name="currentValue_prb" readonly />
</div>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>หัก ณ ที่จ่าย</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<input name="currentText_prb" type="hidden" id="currentText_prb" size="5" value='<?=$id_act_data;?>' />
 <select id="vat1" onchange="javascript:calcfunc();" name="vat1"class='span10 e-span10'>
        <option value="0">ไม่มี</option>
        <option value="1">1%</option>
      </select>
</div>
<div class='span6 e-span6' style='<?=$css_margin?>'>
<input style="text-align: right;" value="0.00" class='span10 e-span10' type="text" id="vat_1" name="vat_1" readonly />
</div>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>หัก ณ ที่จ่าย พ.ร.บ.</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
 <input style="text-align: right;" value="0.00" class='span e-span10' type="text" id="vat_2" name="vat_2"  onkeyup="javascript:calcfunc2();"  />
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>เบี้ยรวม พ.ร.บ.</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
 <input style="text-align: right;" class='span10 e-span10' value="0.00"  type="text" id="total_prb" name="total_prb" readonly />
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>แสดงส่วนลดในใบเสนอราคา</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<input type = 'radio' id = 'hidden_discount1' name = 'hidden_discount' class =''  value = 'Y'> แสดง &nbsp; &nbsp;
<input type = 'radio' id = 'hidden_discount2' name = 'hidden_discount' class ='' checked="checked" value = 'N'> ไม่แสดง
<input name="total_dis3" type="hidden" id="total_dis3" value="0" size="5" />
	<select  style="display:none" id="dis_vip"   onclick="javascript:calcfunc()" name="dis_vip">
      <option selected="selected" value="0">ลด   %</option>
      <option value="5">5%</option>
      <option value="8">8%</option>
      <option value="10">10%</option>
      <option value="13">13%</option>
      <option value="15">15%</option>
      <option value="20">20%</option>
      </select>
	  <input name="total_vip" type="hidden" id="total_vip" value="0" size="5"/>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>display:none;'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>ส่วนลด เปอร์เซ็น</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<select class='span10 e-span10' id="dis_vip" onclick="javascript:calcfunc();" name="dis_vip">
      <option selected="selected" value="0">ลด  %</option>
      <option value="5">5%</option>
      <option value="8">8%</option>
      <option value="10">10%</option>
      <option value="13">13%</option>
      <option value="15">15%</option>
      <option value="20">20%</option>
      </select>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>ส่วนลด ตัวแทน</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<input style="text-align: right;" name="currentValue" type="text" id="currentValue" value="0" class='span10 e-span10' size="10" readonly="true"/ >
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>%</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>ส่วนลดพิเศษ</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<input style="text-align: right;" id="commition" onkeyup="javascript:calcfunc2();" value="0.00" size="10" type="text" name="commition" class='span10 e-span10' />
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>รวมส่วนลดคอมมิชชั่น</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<input style="text-align: right;" name="other" type="text" id="other" value="0.00" class='span10 e-span10' readonly="true">
<input name="other_new" type="hidden" id="other_new" value="0.00" style="width:100px;text-align:right; color:#FF0000; font-weight: bold" size="10" readonly="true">
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>ค่าภาษีรถยนต์รายปี</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
 <input style="text-align: right;" id="vehicle_tax" onkeyup="javascript:calcfunc();" value="0.00" type="text" name="vehicle_tax" class='span10 e-span10'>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>

<!--val_penalty-->
<div class='span12 e-span12' style='<?=$css_margin?> <?=$display_hide?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab_right?>'>ค่าปรับ</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<?php if(empty($data_renew_array['val_penalty']))
{
	$val_penalty='0.00';
}
else
{
	$val_penalty=str_replace(',','',$data_renew_array['val_penalty']);
}
?>
<input id="val_penalty_inform" onkeyup="javascript:calcfunc_inform();" value="<?=number_format($val_penalty,2,'.',',');?>" size="10" type="text" class='e-span10' name="val_penalty_inform" style='text-align:right;'>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<!--end val_penalty-->

<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>ค่าบริการ</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<div class='span6 e-span6' style='<?=$css_margin?>'>
 <select id="service_charge" name="service_charge" onchange="javascript:calcfunc();" class='span10 e-span10'>
       	<option value="0">กรุณาเลือก</option>
        <option value="0.00" selected >ฟรี</option>
        <option value="200.00">200.00</option>
 </select>
 </div>
 <div class='span6 e-span6' style='<?=$css_margin?>'>
 <input style="text-align: right;" name="service_charge_value" type="text" id="service_charge_value" value="0.00" class='span10 e-span10' readonly="true">
</div>
 </div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?=$css_margin?>'>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'></font>
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab.$css_margin_font_tab_right?>'>ยอดนำส่ง</font>
</div>
<div class='span3 e-span3' style='<?=$css_margin?>'>
<input style="text-align: right;" class='span10 e-span10' id="total_commition" onchange="JavaScript:chkNum(this)" value="0.00" type="text" name="total_commition" readonly />
<input class="comment" style="width:100px;text-align:right;font-size:18px;" id="total_commition_new" onchange="JavaScript:chkNum(this)" value="0.00" size="8" type="hidden" name="total_commition_new" readonly />
</div>
<div class='span3 e-span3' style='<?=$css_margin." ".$css_margin_font?>'>
<font style='<?=$css_margin_font_tab?>'>บาท</font>
</div>
</div>
</div>
</form>
</div>

  <!-- <!--dialog form-->
<!--   <div id="dialog-form" title="ค้นหา">
<form id="Cusname">
ค้นหาจาก : <select name="type" id="type_inform" style="width:100px;">
                  <option>--เลือก--</option>
                  <option value="1">ชื่อ-นามสกุล</option>
                  <option value="2">ทะเบียน</option>
                  <option value="3">เลขที่รับแจ้ง</option>
				  <option value="4">เลขตัวถัง</option>
          </select> : 
          <input type="text" style="width:100px;" name="searchcus" id="searchcus" value="" /> - <input type="text" style="width:100px;" name="searchcus2" id="searchcus2" value="" />
</form><BR />แหล่งข้อมูล <select name="sec" id="sec">
                  <option value="Ajax_SearchCus.php">ลูกค้า 4</option>
                  <option value="Cus.php">Suzuki</option>
          </select><BR />
<div id="showCus"><span class="comment">กรุณาค้นหา</span>

</div>

</div>
<div id="dialog-formorder2" title="ค้นหา">
<form id="Cusname2">
ค้นหาจาก : <select name="type" id="type">
               
                 <option value="1">เลขที่ใบเสนอราคา</option>
          </select> : 
          <input type="text" name="searchcus2" id="searchcus2" value=""  /> 
		  
</form><BR />แหล่งข้อมูล <select name="sec2" id="sec2">
                  <option value="Ajax_SearchQuotationSmallCar.php">ลูกค้า 4</option>
                 
          </select><BR />
<div id="showCusorder2"><span class="comment">กรุณาค้นหา</span>

</div>

</div> -->


<script type="text/javascript">

$("input").keypress(function (evt)
	{
		var charCode = evt.charCode || evt.keyCode;
		if (charCode  == 13)
		{
			return false;
		}
	});
	
	$(document).keydown(function (e)
	{
		var preventKeyPress;
        if (e.keyCode == 8)
		{
            var d = e.srcElement || e.target;
            switch (d.tagName.toUpperCase())
			{
                case 'TEXTAREA':
				preventKeyPress = d.readOnly || d.disabled;
				break;
                case 'INPUT':
				preventKeyPress = d.readOnly || d.disabled ||
				(d.attributes["type"] && $.inArray(d.attributes["type"].value.toLowerCase(), ["radio", "checkbox", "submit", "button"]) >= 0);
				break;
                case 'DIV':
				preventKeyPress = d.readOnly || d.disabled || !(d.attributes["contentEditable"] && d.attributes["contentEditable"].value == "true");
				break;
                default:
				preventKeyPress = true;
				break;
            }
        }
        else
		{
            preventKeyPress = false;
		}
        if (preventKeyPress)
        {
		    e.preventDefault();
		}
	});
	function showCarAge()
    {
		var currentTime = new Date();
		//var month = currentTime.getMonth() + 1;
		//var day = currentTime.getDate();
		var year = currentTime.getFullYear();
		var iYear = year - document.getElementById("regis_date_inform").value + 1 + " ปี";
        if (document.getElementById("regis_date_inform").value == "0")
            document.getElementById("year_old").value = "";        
        else
            document.getElementById("year_old").value = iYear;        
    }
	function onChange(object)
	{
    	var Current = object.agent.selectedIndex;
		var Current2 = $('#agent').val();
		var arrayFromPHP = <?php echo json_encode($discountuse); ?>;
		var Current_prb = object.select_prb.selectedIndex;
    	$('#currentText').val($('#agent').val());
		object.currentValue.value = arrayFromPHP[Current2];
		object.currentText_prb.value = object.select_prb.options[Current_prb].text;
		object.currentValue_prb.value = object.select_prb.options[Current_prb].value;
	}

	function SelectCus(object)
	{
    	var Current = $('#CODE-'+object).val();
		var n=Current.split("|");
		$('#amphur').empty(); 
		$('#tumbon').empty();
		$('#postal').empty(); 
    
		$('#person').val(n[0]);
		$('#title').val(n[1]);
		$('#name').val(n[2]);
		$('#last').val(n[3]);
		$('#add').val(n[4]);
		$('#group').val(n[5]);
		$('#town').val(n[6]);
		$('#lane').val(n[7]);
		$('#road').val(n[8]);
		$('#province').val(n[11]);
		$('#amphur').append("<option value='" + n[10] + "'>" + n[19] + "</option>");
		$('#tumbon').append("<option value='" + n[9] + "'>" + n[20] + "</option>");
		$('#postal').append("<option value='" + n[12] + "'>" + n[12] + "</option>");
		$('#tel_mobile').val(n[13]);
		$('#tel_mobile2').val(n[14]);
		$('#tel_home').val(n[15]);
		$('#tel_fax').val(n[15]);
		$('#email').val(n[17]);
		
		var check_card = n[0]  ////Person
		if (check_card == 1)
		{
			$('#icard').val(n[22]);
			$("#niti").hide('fast');
			$("#niti").val('-');	
		}
		else if (check_card == 2)
		{
			$('#icard').val(n[23]);
			$("#niti").hide('fast');
			$("#niti").val('-');	
		}
		else if (check_card == 3)
		{
			$('#icard').val(n[22]);
			$('#niti').val(n[23]);
			$("#niti").show('fast');
			$("#icard").show('fast');	
		}

		
		var CurrentD = $('#DETAIL-'+object).val();
		var nD=CurrentD.split("|");
		$('#br_car').empty(); 
		$('#mo_car').empty();
		$('#car_id_renew').empty();
		
		$('#cartype').val((nD[0]).substring(0,1));
		$('#cat_car').val(nD[14]);
		$('#car_id_renew').append("<option value='" + nD[0] + "'>" + nD[17] + "</option>");
		$('#br_car').append("<option value='" + nD[1] + "'>" + nD[15] + "</option>");
		$('#mo_car').append("<option value='" + nD[2] + "'>" + nD[16] + "</option>");
		$('#gear').val(nD[12]);
		$('#cc').val(nD[8]);
		$('#wg').val(nD[11]);
		$('#car_seat').val(nD[10]);
		$('#regis_date_inform').val(nD[13]);
		$('#chose_carregis').val(1);
		$('#car_regis').val(nD[5]);
		$('#car_regis_pro').val(nD[6]);
		$('#car_color').val(nD[7]);
		$('#car_body').val(nD[3]);
		$('#n_motor').val(nD[4]);
		$('#cost').val(nD[18]);
		$('#pre_inform').val(nD[19]);
		$('#group3').val(nD[20]);
		$('#good').val(nD[21]);
		$('#commition').val(nD[22]);
		$('#damage_out1').val(nD[23]);
		$('#damage_cost').val(nD[24]);
		$('#pa1').val(nD[25]);
		$('#pa2').val(nD[26]);
		$('#pa3').val(nD[27]);
		$('#pa4').val(nD[28]);
		$('#people').val(nD[36]);
		$('#agent').val(nD[30]);
		$('#select_prb').val(nD[31]);
		$('#code').val(nD[32]);
		$('#end_date_old').val(nD[37]);
		$('#id_data_old').val(nD[38]);
				
		calcfunc();
		$('#dialog-formorder2').dialog( "close" );
		$('#dialog-form').dialog( "close" );
		console.log(n);
		console.log(Current);
		console.log(CurrentD);
		console.log(nD[33]);
		console.log(nD[34]);
		console.log(nD.length);
		console.log(n.length);
		showCarAge();
	}

	function SelectCusOrder2(object)
	{
		var Currentq = $('#CODE-'+object).val();
		var nq=Currentq.split("|");
		$('#amphur').empty(); 
		$('#tumbon').empty(); 
		$('#postal').empty(); 
		$('#person').empty(); 
		$('#gear').empty(); 
		$('#wg_id').empty(); 
		$('#car_regis_pro').empty(); 

		var _person_id = nq[0];
		if(_person_id == "1")
		{
			$('#person').append("<option selected='selected' value='"  + nq[0] + "'>" + "บุคคลธรรมดา" + "</option>	<option  value='"  + "2" + "'>" + "นิติบุคคล" + "</option><option  value='"  + "3" + "'>" + "บุคคลในนามบริษัท" + "</option>");
			$('#icard').val(nq[23]);
			$("#niti").hide('fast');
			$("#niti").val('-');	
		
		}
		if(_person_id == "2")
		{
			$('#person').append("<option selected='selected' value='"  + nq[0] + "'>" + "นิติบุคคล" + "</option><option  value='"  + "1" + "'>" + "บุคคลธรรมดา" + "</option><option  value='"  + "3" + "'>" + "บุคคลในนามบริษัท" + "</option>");
			$('#icard').val(nq[24]);
			$("#niti").hide('fast');
			$("#niti").val('-');
		}
		if(_person_id == "3")
		{
			$('#person').append("<option selected='selected' value='"  + nq[0] + "'>" + "บุคคลธรรมดา" + "</option><option  value='"  + "1" + "'>" + "นิติบุคคล" + "</option><option  value='"  + "3" + "'>" + "บุคคลในนามบริษัท" + "</option>");
			$('#icard').val(nq[23]);
				$('#niti').val(nq[24]);
			$("#niti").show('fast');
			$("#icard").show('fast');	
		}
		
		$('#title').val(nq[1]);
		$('#name').val(nq[2]);
		$('#last').val(nq[3]);
		$('#add').val(nq[4]);
		$('#group').val(nq[5]);
		$('#town').val(nq[6]);
		$('#lane').val(nq[7]);
		$('#road').val(nq[8]);
		$('#province').val(nq[11]);
		$('#amphur').append("<option value='" + nq[10] + "'>" + nq[19] + "</option>");
		$('#tumbon').append("<option value='" + nq[9] + "'>" + nq[20] + "</option>");
		$('#postal').append("<option value='" + nq[12] + "'>" + nq[12] + "</option>");
		$('#tel_mobile').val(nq[13]);
		$('#tel_mobile2').val(nq[14]);
		$('#tel_home').val(nq[16]);
		$('#tel_fax').val(nq[15]);
		$('#email').val(nq[17]);
		$('#qty_car').val(nq[18]);
		$('#q_old').val(nq[22]);
		$('#driver').val(nq[52]);
		var CurrentDq = $('#DETAIL-'+object).val();
		var nDq = CurrentDq.split("|");
		$('#br_car').empty(); 
		$('#mo_car').empty();
		$('#car_id_renew').empty();
		$('#car_id_renew').append("<option value='" + nDq[90] + "'>" + nDq[17] + "</option>");
		$('#agent').val(nDq[83]);
		$('#cat_car').val(nDq[84]);
		$('#gear').val(nDq[12]);
		var _gear = nDq[12];
		
		if(_gear == "N")
		{
			$('#gear').append("<option selected='selected' value='"  + nDq[12] + "'>" + "ไม่ระบุุ" + "");
		}
		if(_gear == "A")
		{
			$('#gear').append("<option selected='selected' value='"  + nDq[12] + "'>" + "อัตโนมัติ" + "");
		}
			if(_gear == "M")
		{
			$('#gear').append("<option selected='selected' value='"  + nDq[12] + "'>" + "ธรรมดา" + "");
		}
		
		$('#cc').val(nDq[8]);
		
		$('#wg_id').append("<option value='" + nDq[11] + "'>" + nDq[11] + "</option>");
		
		$('#car_seat').val(nDq[10]);
		$('#regis_date_inform').val(nDq[13]);
		
		var carregis = {"ป้ายเหลือง": "2","ป้ายดำ": "3","อื่นๆ": "4",};	
		$('#chose_carregis').val(carregis[nDq[91]]);
		
		$('#car_regis').val(nDq[5]);
		
		$('#car_regis_pro').append("<option value='" + nDq[6] + "'>" + nDq[48] + "</option>");
		$('#car_color').val(nDq[7]);
		$('#car_body').val(nDq[3]);
		$('#n_motor').val(nDq[4]);
		$('#cost').val(nDq[18]);
		$('#show_q_auto').val(nDq[19]);
		$('#amphur').val(nDq[23]);
		$('#tumbon').val(nDq[24]);
		$('#in_career').val(nDq[26]);
		$('#tel_home').val(nDq[27]);
		$('#tel_fax').val(nDq[28]);
		$('#qty_car').val(nDq[30]);
		$('#pricecar').val(nDq[31]);
		$('#access1').val(nDq[32]);
		$('#accprice1').val(nDq[33]);
		$('#access2').val(nDq[34]);
		$('#accprice2').val(nDq[35]);
		$('#access3').val(nDq[36]);
		$('#accprice3').val(nDq[37]);
		$('#doc_type').val(nDq[38]);
		$('#com_data').val(nDq[39]);
		$('#ty_inform').val(nDq[40]);
		$('#qua_number').val(nDq[41]);
		var serv = {"1": "ซ่อมห้าง","2": "ซ่อมอู่",};					
		var gea = {"N": "ไม่ระบุ","A": "อัตโนมัติ","M": "ธรรมดา",};	
		$('#service').val(nDq[42]);		
		$('#o_insure').val(nDq[44]);
		_ndq84 = nDq[85];
		_ndq17 = nDq[17];
		_ndq15 = nDq[15];
		
	   $('#cartype').val(nDq[85]);
	   $('#br_car').append("<option value='" + nDq[1] + "'>" + nDq[15] + "</option>");
		$('#mo_car').append("<option value='" + nDq[2] + "'>" + nDq[16] + "</option>");
		$('#cc').val(nDq[45]);
		
		$('#gear').val(gea[nDq[46]]);
		$('#regis_date_inform').val(nDq[47]);
	
		$('#name_gain').val(nDq[49]);
		$('#pre_inform').val(nDq[50]);
		$('#rdodriver').val(nDq[51]);
		$('#driver').val(nDq[52]);
		$('#disone').val(nDq[53]);
		$('#group3').val(nDq[54]);
		$('#dis_group3').val(nDq[55]);
		$('#good').val(nDq[56]);
		$('#goodb').val(nDq[57]);
		$('#pro_dis').val(nDq[58]);
		$('#pro_dis2').val(nDq[59]);
		$('#total_pre').val(nDq[60]);
		$('#total_stamp').val(nDq[61]);
		$('#total_vat').val(nDq[62]);
		$('#total_sum').val(nDq[63]);
		
		var prb = {
			<?php echo $array_pre ;?>
		};	
		
		$('#select_prb').val(prb[nDq[93]]);
		$('#com_data2').val(nDq[88]);
		$('#vat_2').val(nDq[87]);
					
		var _one = nDq[94];
		if(_one != "")
		{
			$("#one").show('fast');		
			$("spann").hide();
		}
		else
		{
			$("#one").hide('fast');
			$("#one").val('');
			$("spann").show();
		}
					
		$('#one').val(nDq[94]);
		$('#currentText_prb').val(nDq[93]);
		$('#currentText').val(nDq[29]);
		
		$('#currentValue_prb').val(nDq[65]);
		$('#vat1').val(nDq[66]);
		$('#vat_1').val(nDq[67]);
		$('#total_prb').val(nDq[68]);
		$('#total_vip').val(nDq[69]);
		$('#currentValue').val(nDq[70]);
		$('#commition').val(nDq[71]);
		$('#other').val(nDq[72]);
		$('#total_commition').val(nDq[73]);
		$('#damage_out1').val(nDq[74]);
		$('#damage_cost').val(nDq[75]);
		$('#pa1').val(nDq[76]);
		$('#people').val(nDq[77]);
		$('#pa2').val(nDq[78]);
		$('#pa3').val(nDq[79]);
		$('#pa4').val(nDq[80]);
		$('#none_disone').val(nDq[81]);
		$('#in_career').val(nDq[82]);
		$('#code').val(nDq[86]);
		$('#wg_m').val(nDq[11]);
		$('#agency').val(nDq[95]);
		
		var _qman = nDq[39];
		if(_qman == "BKI[MBLT]")
		{
			$("#q_manual").show('fast');
			$("#q_manual").val('');
			$("spann").hide();
		}
		else
		{
			$("#q_manual").hide('fast');
			$("#q_manual").val('-');
			$("spann").show();
		}

		$('#dialog-formorder2').dialog( "close" );
		console.log(nq);
		console.log(Currentq);
		console.log(CurrentDq);
		console.log(nDq[29]);
		console.log(nDq[59]);
		console.log(nDq[95]);	
		console.log(nDq.length);
		showCarAge();
	}	
$(document).ready(function(){	
$( "#start_date" ).datepicker({
            language: "th",
			autoclose: true,
			format: 'dd-mm-yyyy'
});
$( "#checkcar_date" ).datepicker({
            language: "th",
			autoclose: true,
			format: 'dd-mm-yyyy'
});
$( "#payment_date" ).datepicker({
            language: "th",
			autoclose: true,
			format: 'dd-mm-yyyy'
});
$( "#pay_date" ).datepicker({
            language: "th",
			autoclose: true,
			format: 'dd-mm-yyyy'
});
});
$(function()
	{
		$('#inp1').iMask({
			type : 'number'
		});
		$('#pre').iMask({
			type : 'number'
		});
		$('#pro_dis').iMask({
		type : 'number'
		, decDigits : 0
			, decSymbol : ''
		});
		$('#goodb').iMask({
		type : 'number'
		});
		$('#pro_dis2').iMask({
		type : 'number'
		});
		$('#inp3').iMask({
			type : 'number'
		});
		$('#inp4').iMask({
			type : 'number'
		});
	
		$('#inp8').iMask({
			type : 'number'
		});
		/*$('#cost').iMask({
			type : 'number',
			decDigits : 0,
			decSymbol : ''
		});*/
		$('#val_penalty_inform').iMask({
			type : 'number'
		});
		$('#inp10').iMask({
			type : 'number'
		});
		$('#inp11').iMask({
			type : 'number'
		});
		$('#inp12').iMask({
			  type : 'fixed'
			, mask : '99/99/99'
		});
	$('#inp13').iMask({
			  type : 'fixed'
			, mask : '999-999-9999'
		});
		$('#inp16').iMask({
			  type : 'fixed'
			, mask : '999-999-9999'
		});
		$('#tel_fax').iMask({
			  type : 'fixed'
			, mask : '999-999-9999'
		});
		$('#tel_mobile2').iMask({
			  type : 'fixed'
			, mask : '999-999-9999'
		});
				$('#contact_number').iMask({
			  type : 'fixed'
			, mask : '999-999-9999'
		});
		$('#tel_home').iMask({
			  type : 'fixed'
			, mask : '999-999-9999'
		});
		$('#commition').iMask({
			type : 'number'
		});
		$('#inp15').iMask({
			type : 'number'
		});
		$('#driver').iMask({
			type : 'number'
		});
		$('#one').iMask({
			type : 'number',
				  decDigits : 0,
			decSymbol : ''
		});
		$('#people').iMask({
			type : 'number',
				  decDigits : 0,
			decSymbol : ''
		});
		$('#acccost1').iMask({
			type : 'number'
		});
				$('#acccost2').iMask({
			type : 'number'
		});
				$('#acccost3').iMask({
			type : 'number'
		});
				$('#acccost4').iMask({
			type : 'number'
		});
		$('#disone').iMask({
		      type : 'number'
		});
		$('#pricecar').iMask({
		      type : 'number'
		});
		$('#accprice1').iMask({
		      type : 'number'
		});
		$('#accprice2').iMask({
		      type : 'number'
		});
		$('#accprice3').iMask({
		      type : 'number'
		});
	});
	$("#none_disone").change(function(){
		if($("#none_disone").val()=='มี')
		{
			$("#one_text").show();
			$("#one_input").show();
		}
		else
		{
			$("#one_text").hide();
			$("#one_input").hide();
		}
		
	});
	$("#icard").mask("9999999999999");

$("#province").change(function() 
     { 
         $("#tumbon").empty();
		 $("#tumbon").append("<option value='0'>กรุณาเลือก</option>");
		 $("#id_post").empty();
		 $("#id_post").append("<option value='0'>กรุณาเลือก</option>");
         var _selected = $("#province").val();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Ajax_Pro_smallcar.php",
			 data: {
			 callajax:'AMPHUR',
			 province:_selected
			 },
             success: function(msg) {
                $('#amphur').empty(); 
                 var returnedArray = msg;
                 state = $("#amphur");
				 state.append("<option value='0'>กรุณาเลือก</option>");
				 if(returnedArray!=null){
                 for (var i = 0; i < returnedArray.length; ++i) {
                     state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                 }
			     }
			     else{
				 return false;
			     }
                 
             }
         };
         $.ajax(options);
	 });

$("#amphur").change(function() 
     { 
	 	$("#id_post").empty();
		 $("#id_post").append("<option value='0'>กรุณาเลือก</option>");
         var _selected = $("#amphur").val();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Ajax_Pro_smallcar.php",
			 data: {
			 callajax:'TUMBON',
			 amphur:_selected
			 },
             success: function(msg) {
                $('#tumbon').empty(); 
                 var returnedArray = msg;
                 state = $("#tumbon");
				 state.append("<option value='0'>กรุณาเลือก</option>");
				 if(returnedArray!=null){
                 for (var i = 0; i < returnedArray.length; ++i) {
                     state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                 }
			     }
			     else{
				 return false;
			     }
             }
         };
         $.ajax(options);
	 });
	 $("#tumbon").change(function() 
     { 
         var _selected = $("#tumbon").val();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Ajax_Pro.php",
			 data: {
			 callajax:'POST',
			 tumbon:_selected
			 },
             success: function(msg) {
                $('#postal').empty(); 
                 var returnedArray = msg;
                 state = $("#postal");
				 if(returnedArray!=null){
                 for (var i = 0; i < returnedArray.length; ++i) {
                 state.append("<option value='" + returnedArray[i].Name + "'>" + returnedArray[i].Name + "</option>");
                 }
			     }
			     else{
				 return false;
			     }
             }
         };
         $.ajax(options);
	 });

$("#cartype").change(function() 
     { 
         var _selected = $("#cartype").val();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Ajax_Pro_smallcar.php",
			 data: {
			 callajax:'CARTYPE',
			 cartype:_selected
			 },
             success: function(msg) {
                $('#car_id_renew').empty(); 
                 var returnedArray = msg;
                 car_id = $("#car_id_renew");
				 car_id.append("<option value='0'>กรุณาเลือก</option>");
				 if(returnedArray!=null){
                 for (var i = 0; i < returnedArray.length; ++i) {
                     car_id.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                 }
			     }
			     else{
				 return false;
			     }
             }
         };
         $.ajax(options);
	 });


$("#cat_car").change(function() 
     { 
         var _selected = $("#cat_car").val();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Ajax_Pro_smallcar.php",
			 data: {
			 callajax:'BR',
			 br:_selected
			 },
             success: function(msg) {
                $('#br_car').empty(); 
                 var returnedArray = msg;
                 br_car = $("#br_car");
				 br_car.append("<option value='0'>กรุณาเลือก</option>");
				 if(returnedArray!=null){
                 for (var i = 0; i < returnedArray.length; ++i) {
                     br_car.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                 }
			     }
			     else{
				 return false;
			     }
             }
         };
         $.ajax(options);
	 });
	 
$("#br_car").change(function() 
     { 
         var _selected = $("#br_car").val();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Ajax_Pro_smallcar.php",
			 data: {
			 callajax:'MO',
			 mo:_selected
			 },
             success: function(msg) {
                $('#mo_car').empty(); 
                 var returnedArray = msg;
                 mo_car = $("#mo_car");
				 mo_car.append("<option value='0'>กรุณาเลือก</option>");
				 if(returnedArray!=null){
                 for (var i = 0; i < returnedArray.length; ++i) {
                     mo_car.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                 }
			     }
			     else{
				 return false;
			     }
             }
         };
         $.ajax(options);
	 });

$("#select_prb").change(function() 
     { 
         var ty_inform = $("#ty_inform").val();
		 var com_data = $("#com_data").val();
		 var doc_type = $("#doc_type").val();
		 var currentText = $("#currentText").val();
		 var select_prb = $("#select_prb").val();
		 if(ty_inform=='L' && com_data=='VIB_S' && doc_type=='1' && currentText=='MBLT' && select_prb != '0'){
		 $("#actCheck").val('1');
		 }
		 else if(ty_inform=='L' && com_data=='BKI[MBLT]' && doc_type=='1' && currentText=='MBLT' && select_prb != '0'){
		 $("#actCheck").val('2');
		 }
		 else{
			 $("#actCheck").val('0');
		 }
	 });
	 function SaveI() 
    
	 { 
	 
	 if($("#customer").val()=="0")
	 {
	  $("#customer").focus();
		alert('กรุณาเลือกลูกค้า/ดิลเลอร์');
	 return false;
	 }
	 if($("#agent1").val()=="0")
	 {
	  $("#agent1").focus();
		alert('กรุณาเลือกกลุ่มตัวแทน');
	 return false;
	 }
	/*
if($("#agent").val()=='N'){
		 $("#agent").focus();
		 alert('กรุณาเลือกตัวแทน');
		 return false;	
	 } 

	  else if($("#contact").val()=='0'){
		 $("#contact").focus();
		 alert('กรุณาเลือกผู้ติดต่อ');
		 return false;
	 }*/
	 
	  if($("#car_body").val()=='0'){
		 $("#car_body").focus();
		 alert('กรุณาใส่เลขตัวถัง');
		 return false;
	 }
	 
else if($("#n_motor").val()=='0'){
		 $("#n_motor").focus();
		 alert('กรุณาใส่เลขเครื่อง');
		 return false;
	 }
	/* else if($("#icard").val()==''){
		 $("#icard").focus();
		 alert('กรุณากรอกเลขบัตรหรือทะเบียนการค้า');
		 return false;
	 }*/
/*	 
else if($("#person").val()=='0'){
		 $("#person").focus();
		 alert('กรุณาเลือกบุคคล');
		 return false;
	 }*/
	 /*
 else if($("#person").val()=='3' && $("#niti").val()==''){
		 $("#niti").focus();
		 alert('กรุณากรอกเลขที่นิติบุคคล');
		 return false;
	 }	
else if($("#person").val()=='3' && $("#niti").val()=="-"){
		 $("#niti").focus();
		 alert('กรุณากรอกเลขที่นิติบุคคล');
		 return false;
	 }	*/
else if($("#title").val()=='0'){
		 $("#title").focus();
		 alert('กรุณาเลือกคำนำหน้า');
		 return false;
	 }
else if($("#name").val()==''){
		 $("#name").focus();
		 alert('กรุณากรอกชื่อ');
		 return false;
	 }
else if($("#last").val()==''){
		 $("#last").focus();
		 alert('กรุณากรอกนามสกุล');
		 return false;
	 }
	 /*
else if($("#add").val()==''){
		 $("#add").focus();
		 alert('กรุณากรอกบ้านเลขที่');
		 return false;
	 }
else if($("#province").val()=='0'){
		 $("#province").focus();
		 alert('กรุณาเลือกจังหวัด');
		 return false;
	 }
else if($("#amphur").val()=='0'){
		 $("#amphur").focus();
		 alert('กรุณาเลือกอำเภอ');
		 return false;
	 }
else if($("#tumbon").val()=='0'){
		 $("#tumbon").focus();
		 alert('กรุณาเลือกตำบล');
		 return false;
	 }
else if($("#postal").val()==''){
		 $("#postal").focus();
		 alert('กรุณากรอกรหัสไปรษณีย์');
		 return false;
	 }*/
	  /*else if($("#email").val()==''){
		 $("#email").focus();
		 alert('กรุณากรอกออีเมลล์');
		 return false;
	 }*/
	 /*
	 else if($("#tel_mobile").val()==''){
		 $("#tel_mobile").focus();
		 alert('กรุณากรอกเบอร์มือถือ');
		 return false;
	 }*/
	/* else if($("#tel_fax").val()==''){
		 $("#tel_fax").focus();
		 alert('กรุณากรอกเบอร์แฟกซ์');
		 return false;
	  }*/
	/*
	   else if($("#qty_car").val()=='0'){
		 $("#pricecar").focus();
		 alert('กรุณาเลือกจำนวนรถ');
		 return false;
	 		  }
	  
	  
	 else if(($("#qty_car").val()!='')&& $("#pricecar").val()==''){
		 $("#pricecar").focus();
		 alert('กรุณากรอกราคารถยนต์');
		 return false;
	 		  }
	 else if(($("#access1").val()!='')&& $("#accprice1").val()==''){
		 $("#accprice1").focus();
		 alert('กรุณากรอกราคาอุปกรณ์ตกแต่งที่ 1');
		 return false;
	 }
	  else if(($("#access2").val()!='')&& $("#accprice2").val()==''){
		 $("#accprice2").focus();
		 alert('กรุณากรอกราคาอุปกรณ์ตกแต่งที่ 2');
		 return false;
	 }
	  else if(($("#access3").val()!='')&& $("#accprice3").val()==''){
		 $("#accprice3").focus();
		 alert('กรุณากรอกราคาอุปกรณ์ตกแต่งที่ 3');
		 return false;
	 }
	 else if($("#pricecar").val()==''){
		 $("#pricecar").focus();
		 alert('กรุณากรอกราคารถยนต์');
		 return false;
	 }*/
else if($("#doc_type").val()=='0'){
		 $("#doc_type").focus();
		 alert('กรุณาเลือกประเภท');
		 return false;
	 }
else if($("#com_data").val()=='0'){
		 $("#com_data").focus();
		 alert('กรุณาเลือกบริษัท');
		 return false;
	 }
	 else if($("#com_data2").val()=='0'){
		 $("#com_data2").focus();
		 alert('กรุณาเลือกบริษัทพรบ.');
		 return false;
	 }
	 
	
else if($("#ty_inform").val()==''){
		 $("#ty_inform").focus();
		 alert('กรุณาเลือกการรับแจ้ง');
		 return false;
	 }
else if($("#service").val()=='0'){ 
		 $("#service").focus();
		 alert('กรุณาเลือกประเภทการซ่อม');
		 return false;
	 }
	 /*
else if($("#start_date").val()==0){
		 $("#start_date").focus();
		 alert('กรุณาเลือกวันคุ้มครอง');
		 return false;
		 
	 }*/
else if($("#o_insure").val()=='0'){ ////ปิดไม่เช็คเงื่อนไง จาก'' เป็น 0
		 $("#o_insure").focus();
		 alert('กรุณากรอกเลขกรมธรรม์เดิม');
		 return false;
	 }
else if($("#cartype").val()=='0'){
		 $("#cartype").focus();
		 alert('กรุณาเลือกประเภทการใช้');
		 return false;
	 }
/*else if($("#car_id_renew").val()=='0'){
		 $("#car_id_renew").focus();
		 alert('กรุณาเลือกลักษณะใช้งาน');
		 return false;
	 }*/
else if($("#cat_car").val()=='0'){
		 $("#cat_car").focus();
		 alert('กรุณาเลือกประเภทรถ');
		 return false;
	 }
else if($("#br_car").val()=='0'){
		 $("#br_car").focus();
		 alert('กรุณาเลือกยี่ห้อรถ');
		 return false;
	 }
	 /*
else if($("#mo_car").val()=='0'){
		 $("#mo_car").focus();
		 alert('กรุณาเลือกรุ่นรถ');
		 return false;
	 }*/
/*else if($("#gear").val()=='0'){
		 $("#gear").focus();
		 alert('กรุณาเลือกเกียร์');
		 return false;
	 }*/
	 else if($("#wg_id").val()=='0'){
		 $("#wg_id").focus();
		 alert('กรุณาเลือกน้ำหนัก');
		 return false;
	
	 }
else if($("#car_seat").val()=='0'){ //ปิดไม่เช็คเงื่อนไงว่างเป็น 0
		 $("#car_seat").focus();
		 alert('กรุณากรอกจำนวนที่นั่ง');
		 return false;
	 }
/*else if($("#regis_date_inform").val()=='0'){
		 $("#regis_date_inform").focus();
		 alert('กรุณาเลือกปี');
		 return false;
	 }*/
/*else if($("#chose_carregis").val()=='0'){
		 $("#chose_carregis").focus();
		 alert('กรุณาเลือกทะเบียนรถ');
		 return false;
	 }*/
else if($("#car_regis").val()=='2'){
		 $("#car_regis").focus();
		 alert('กรุณากรอกรายละเอียดของป้ายทะเบียน');
		 return false;
	 }
/*else if($("#car_regis_pro").val()=='0'){
		 $("#car_regis_pro").focus();
		 alert('กรุณาเลือกจังหวัด');
		 return false;
	 }

else if($("#name_gain").val()=='0'){
		 $("#name_gain").focus();
		 alert('กรุณาเลือกผู้รับผลประโยชน์');
		 return false;
	 }
	 else if($("#agency").val()=='0'){
		 $("#agency").focus();
		 alert('กรุณาเลือกตัวแทนจำหน่าย');
		 return false;
	 }*/
	 
else if($("#cost").val()=='0'){
		 $("#cost").focus();
		 alert('กรุณากรอกทุนประกันภัย');
		 return false;
	 }
else if($("#damage_out1").val()=='0'){
		 $("#damage_out1").focus();
		 alert('กรุณาเลือกความคุ้มครอง ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย');
		 return false;
	 }
else if($("#damage_cost").val()=='0'){
		 $("#damage_cost").focus();
		 alert('กรุณาเลือกความคุ้มครอง ความเสียหายต่อทรัพย์สิน');
		 return false;
	 }
else if($("#pa1").val()=='N'){
		 $("#pa1").focus();
		 alert('กรุณาเลือกความคุ้มครอง ผู้ขับขี่ 1 คน');
		 return false;
	 }
else if($("#people").val()=='N'){
		 $("#people").focus();
		 alert('กรุณากรอกจำนวนผู้โดยสาร');
		 return false;
	 }
else if($("#pa2").val()=='N'){
		 $("#pa2").focus();
		 alert('กรุณาเลือกความคุ้มครอง ผู้โดยสาร');
		 return false;
	 }
else if($("#pa3").val()=='N'){
		 $("#pa3").focus();
		 alert('กรุณาเลือกจำนวนค่ารักษาพยาบาล');
		 return false;
	 }	
else if($("#pa4").val()=='N'){
		 $("#pa4").focus();
		 alert('กรุณาเลือกความคุ้มครอง การประกันตัวผู้ขับขี่ในคดีอาญา');
		 return false;
	 }	
else if($("#none_disone").val()=='0'){
		 $("#none_disone").focus();
		 alert('กรุณาเลือกความเสียหายส่วนแรก');
		 return false;
	 }	
else if($("#none_disone").val()=='มี' && $("#one").val()==''){
		 $("#one").focus();
		 alert('กรุณากรอกราคาความสียหายส่วนแรก');
		 return false;
	 }	
else if($("#rdodriver").val()=='0'){
		 $("#rdodriver").focus();
		 alert('กรุณาเลือกจำนวนผู้ขับขี่');
		 return false;
	 }
else if($("#q_manual").val()==''){
		 $("#q_manual").focus();
		 alert('กรุณาใส่เลขที่เสนอราคา');
		 return false;
	 }
	   	 else if($("#pre").val()=='0.00'){
		 $("#pre").focus();
		 alert('กรุณาใส่เบี้ยสุทธิ');
		 return false;
	 }
	 	 else if($("#product").val()=='N'){
		 $("#pre").focus();
		 alert('กรุณาเลือกประเภทเบี้ยสุทธิ');
		 return false;
	 }

else if($("person").val()=='3' && $("#niti").val()==''){
		 $("#niti").focus();
		 alert('กรุณากรอกเลขที่นิติบุคคล');
		 return false;
	 }	
	 
 else{

 	var chkconf = confirm('คุณต้องการบันทึกข้อมูล ใช่หรือไม่');
         if(chkconf==true){//start
		 $('#previewContent').dialog( "open" );
		 var chose_carregis =$('#chose_carregis option[value='+$('#chose_carregis').val()+']').html() ;
		$('#car_regis_type').val(chose_carregis);
	 var DATA = $('#webForm').serialize();
	 console.log(DATA);
	 var SAVE = {
         type: "POST",
         dataType: "json",
         url: "ajax/Ajax_SaveQuotation_oneQ.php",
         data: DATA,
         success: function(msg) {
			 $('#previewContent').dialog( "close" );
			 var returnedArray = msg;
			 if(returnedArray.id=='false')
			 {
				 alert(returnedArray.msg);
				 return false;
			 }
			 else
			 {
             alert(returnedArray.msg);
              $(".close").trigger('click');
			/* showView('www.google.com');*/
			/* showView('pages/quote_four.php');*/
			$('#content').load('pages/quote_four.php');
			$('#previewContent').dialog( "close" );
			 }
         },
		 error:function() {
			  
             alert('การบันทึกผิดพลาด');
					 }
				 };

			 $.ajax(SAVE);
			
	}//endconfirm
		}
}
$( "#dialog-form" ).dialog({
autoOpen: false,
height: 300,
width: 600,
modal: true,
buttons: {
"ค้นหา": function() {
	var Obj_Sec = $('#sec').val();
	var DATA = $('#Cusname').serialize();
	 var SAVE = {
         type: "POST",
         dataType: "json",
         url: "ajax/"+Obj_Sec,
         data: DATA,
         success: function(msg) {
			 
			 var returnedArray = msg;
			 if(returnedArray!=null){
				 var resu='';
			for (i = 0; i < returnedArray.length; i++) {
			resu = resu + "<input type='button' value='เลือก' onclick='SelectCus("+i+");'><input type='hidden' value='"+returnedArray[i].all+"' id='CODE-"+i+"'><input type='hidden' value='"+returnedArray[i].detail+"' id='DETAIL-"+i+"'> [ "+returnedArray[i].id_data+" ] [ "+returnedArray[i].car_regis+" ] "+returnedArray[i].title+" "+returnedArray[i].name+" "+returnedArray[i].last+"<BR>";
			}
			 $('#showCus').html(resu);
			 }
			 else{
				  $('#showCus').html("<span class='warn'>ไม่พบข้อมูล</span>");
			 }
			
         },
		 error:function(msg) {
			 var returnedArray = msg;
             alert('การค้นหาผิดพลาด');
         }
     };
     $.ajax(SAVE);
},
"ปิด": function() {
$( this ).dialog( "close" );
}
},
close: function() {
}
});
$( "#SelectCus" )
.button()
.click(function() {
$( "#dialog-form" ).dialog( "open" );
});
$( "#dialog-formorder2" ).dialog({
autoOpen: false,
height: 300,
width: 600,
modal: true,
buttons: {
"ค้นหา": function() {
	var Obj_Sec = $('#sec2').val();
	var DATA = $('#Cusname2').serialize();
	 var SAVE = {
         type: "POST",
         dataType: "json",
         url: "ajax/Ajax_SaveQuotation_oneQ.php",
         data: DATA,
         success: function(msg) {
			 
			 var returnedArray = msg;
			 if(returnedArray!=null){
				 var resu='';
			for (i = 0; i < returnedArray.length; i++) {
			resu = resu + "<input type='button' value='เลือก' onclick='SelectCusOrder2("+i+");'><input type='hidden' value='"+returnedArray[i].all+"' id='CODE-"+i+"'><input type='hidden' value='"+returnedArray[i].detail+"' id='DETAIL-"+i+"'>  [ "+returnedArray[i].id_data+" ]  "+returnedArray[i].title+" "+returnedArray[i].name+" "+returnedArray[i].last+" &nbsp;&nbsp; &nbsp; [ "+returnedArray[i].com_data+" ]   <BR>";
			}
			 $('#showCusorder2').html(resu);
			 }
			 else{
				  $('#showCusorder2').html("<span class='warn'>ไม่พบข้อมูล</span>");
			 }
			
         },
		 error:function(msg) {
			 var returnedArray = msg;
             alert('การค้นหาผิดพลาด');
			 $( this ).dialog( "close" );
         }
     };
     $.ajax(SAVE);
},
"ปิด": function() {
$( this ).dialog( "close" );
}
},
close: function() {
$('#showCusorder2').html("<span class='comment'>กรุณาค้นหา</span>");
}
,
open: function() {
$('#showCusorder2').html("<span class='comment'>ยินดีต้อนรับ</span>");
}
});

$( "#SelectCusOrder2" )
.button()
.click(function() {
$( "#dialog-formorder2" ).dialog( "open" );
});

$("#type_inform").change(function() { 
	var ObjectC = $("#type_inform").val();
	if(ObjectC==1){
		$("#searchcus").val('');
		$("#searchcus2").val('');
		$("#searchcus").show('fast');
		$("#searchcus2").show('fast');
	}
	else 	if(ObjectC==2 || ObjectC==3){
		$("#searchcus").val('');
		$("#searchcus2").val('');
		$("#searchcus").show('fast');
		$("#searchcus2").hide('fast');
	}
	});
	
	$("#rdodriver").change(function() { 
	var ObjectC = $("#rdodriver").val();
	if(ObjectC=='N'){
		$("#driver1_inform").slideUp();

		$("#driver2_inform").slideUp();


	}
	else 	if(ObjectC==1){
		$("#driver1_inform").slideDown();

		$("#driver2_inform").slideUp();

	}
		else 	if(ObjectC==2){
		$("#driver1_inform").slideDown();

		$("#driver2_inform").slideDown();

	}
			else 	if(ObjectC==0){
		$("#driver1_inform").slideUp();

		$("#driver2_inform").slideUp();

	}

});
$("#birth_num1").mask("99/99/9999");
$("#birth_num2").mask("99/99/9999");
function js_car_regis_show()
{
	if($("#chose_carregis").val()=='2')
	{
		$("#car_regis_show").show();
	}
	else
	{
		$("#car_regis_show").hide();
	}
}
showCarAge();
calcfunc();
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function js_customer()
{
	var search_data = 
	{
		url:"ajax/ajax_agent_group_renew.php",
		type:"POST",
		dataType:"JSON",
		data:{customer:$("#customer").val()},
		success:function(data)
		{
			$("#agent_group_t").html(data.agent_t);
			$("#agent_group_i").html(data.agent_i);
		}
	};
$.ajax(search_data);
}
function protection_html_start()
{
	$("#cost_show").html($("#cost").val());
	$("#damage_out1_show").html($("#damage_out1").val());
	$("#damage_cost_show").html($("#damage_cost").val());
	$("#pa1_show").html($("#pa1").val());
	$("#people_show").html($("#people").val());
	$("#pa2_show").html($("#pa2").val());
	$("#pa3_show").html($("#pa3").val());
	$("#pa4_show").html($("#pa4").val());
}
protection_html_start();
</script>
