<?php
include '../inc/connectdbs.pdo.php';
// mysql_select_db($db2,$cndb2);

$ins_protect_typee =$_POST['ins_protect_type'];
$ins_comp  =$_POST['ins_comp'];
$tservicee  =$_POST['tservice'];
$ins_typee  =$_POST['ins_type'];
$ins_nett  =$_POST['ins_net'];
$ins_cost_endd  =$_POST['ins_cost_end'];
$comp_sortt  =$_POST['comp_sort'];
$year_oldcat  =$_POST['yearcar'];


//echo  "<BR/>>>>ปีรถ =".$year_oldcat;
// echo  "<BR/>>>>บริษัทประกันภัย =".$ins_comp;
?>

<style>
.q-table
{
	border-style: solid;
	border-width: 1px;
	border-color:#FF3333;
}
.q-tr
{
	border-style: solid;
    border-width: 1px;
    border-color: #cccccc;
    background-color: #fff;
}
.q-tr:hover
{
	background-color:#cccccc;
	
}
.q-td
{
	/*font-size:14px;
	border-style: dashed;
	border-width: 2px;
	border-color:#0078FF;*/
	    font-size: 14px;
    border-style: solid;
    border-width: 1px;
    border-color: #cccccc;
    margin-top: 0px;
}
.q-image
{
	height:50px;
}

/*  new */
body {
  color: #2c3e50;
  background: #ffffff;
}
h1 {
  text-align: center;
}
/*.half2 {
  float: left;
  width: 98%;
  height: 100%;
  padding: 0 1em;
}*/
/* Acordeon styles */
/*.tab2 {
  position: relative;
  margin-bottom: 1px;
  width: 100%;
  color: #F5FFFA;
  overflow: hidden;
  margin-top: 0px;
}
*/
/*input {
  position: absolute;
  opacity: 0;
  z-index: 99999999;
}*/
label {
  position: relative;
  display: block;
  padding: 0 0 0 1em;
  
  font-weight: bold;
  line-height: 1;
  cursor: pointer;
}

.gradi  {
	background: linear-gradient(to right, rgb(226, 255, 226) 0%, rgb(255, 255, 255) 51%, rgb(255, 255, 240) 100%) !important; 
}

.blue label {
  background-color: #ffffff;
}
/* :checked */
.tab-content2 {  max-height: 0;  overflow: hidden;  background: #ffffff;  -webkit-transition: max-height .35s;  -o-transition: max-height .35s;  transition: max-height .35s;}
.blue .tab-content2 {  background: #3498db;}
.tab-content2 p {  border: 1px solid #c5d0dc !important;    /* padding: 16px 12px; */    position: relative !important;    z-index: 11 !important;}
input:checked ~ .tab-content2 {  max-height: 250px;}
/* :checked */


/* :checked */
.tab-content3 {  max-height: 0;  overflow: hidden;  background: #ffffff;  -webkit-transition: max-height .35s;  -o-transition: max-height .35s;  transition: max-height .35s;}
.blue .tab-content3 {  background: #3498db;}
.tab-content3 p {  border: 1px solid #c5d0dc !important;    /* padding: 16px 12px; */    position: relative !important;    z-index: 11 !important;}
input:checked ~ .tab-content3 {  max-height: 350px;}
/* :checked */


/* :checked */
.tab-content4 {  max-height: 0;  overflow: hidden;  background: #ffffff;  -webkit-transition: max-height .35s;  -o-transition: max-height .35s;  transition: max-height .35s;}
.blue .tab-content4 {  background: #3498db;}
.tab-content4 p {  border: 1px solid #c5d0dc !important;    /* padding: 16px 12px; */    position: relative !important;    z-index: 11 !important;}
input:checked ~ .tab-content4 {  max-height: 350px;}
/* :checked */


/* Icon */
label::after {
  position: absolute;
  right: 0;
  top: 0;
  display: block;
  width: 3em;
  height: 3em;
  line-height: 3;
  text-align: center;
  -webkit-transition: all .35s;
  -o-transition: all .35s;
  transition: all .35s;
}
input[type=checkbox] + label::after {
  content: "+";
}
input[type=radio] + label::after {
  content: "\25BC";
}
input[type=checkbox]:checked + label::after {
  transform: rotate(315deg);
}
input[type=radio]:checked + label::after {
  transform: rotateX(180deg);
}


</style>
<?php
	function thaiDate($datetime)
	{
		list($date,$time) = explode(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($Y,$m,$d) = explode('-',$date); // แยกวันเป็น ปี เดือน วัน
		list($H,$i,$s) = explode(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
		$Y = $Y+543;
		switch($m) 
		{
			case "01": $m = "01"; break;
			case "02": $m = "02"; break;
			case "03": $m = "03"; break;
			case "04": $m = "04"; break;
			case "05": $m = "05"; break;
			case "06": $m = "06"; break;
			case "07": $m = "07"; break;
			case "08": $m = "08"; break;
			case "09": $m = "09"; break;
			case "10": $m = "10"; break;
			case "11": $m = "11"; break;
			case "12": $m = "12"; break;
		}
	return $d."/".$m."/".$Y;
	} 
	function doComparison($a, $operator, $b)
{
    switch ($operator) {
        case '<':  return ($a <  $b); break;
        case '<=': return ($a <= $b); break;
        case '=':  return ($a == $b); break; // SQL way
        case '==': return ($a == $b); break;
        case '!=': return ($a != $b); break;
        case '>=': return ($a >= $b); break;
        case '>':  return ($a >  $b); break;
    } 
}
  	 
?>


<?php
$sqlRes = " SELECT * FROM tb_protection ";  
$sqlRes .= " WHERE protect_type = '$ins_protect_typee'";
$resSql = PDO_CONNECTION::fourinsure_insured()->query($sqlRes);

 $arrRes2 = $resSql->fetch(2);
             //=======================
         
         $comp_insure = $arrRes2['comp_insure'];
         $protect_type = $arrRes2['protect_type'];
         $nameproduct = $arrRes2['nameproduct'];
         $life = $arrRes2['life'];
         $maxlife = $arrRes2['maxlife'];
         $asset = $arrRes2['asset']; 
         $driver = $arrRes2['driver']; 
         $passenger = $arrRes2['passenger']; 
         $nurse = $arrRes2['nurse']; 
         $issuran = $arrRes2['issuran']; 
         $tickets = $arrRes2['tickets']; 
         $driveticket = $arrRes2['driveticket'];
         $end_date = $arrRes2['end_date'];  
         $protectdescription = $arrRes2['protectdescription'];  
         $barcode = $arrRes2['barcode']; 
         $pro_type = $arrRes2['pro_type'];          
        
         // echo "<BR/>".$comp_insure." ".$protect_type." ".$nameproduct." ".$life." ".$maxlife." ".$asset." ".$driver." ".$passenger."<BR/>";
?>


<!-- <div class="half2">
	<div style="width:100%; margin: auto; text-align: center; margin-top: auto;">
    <div><span><img src="images/logo_insured/<?php echo $comp_sortt;?>.png" style="height:45px;"></span>
	<span style="font-size:18px;"><?php echo $ins_comp;?></span></div> 
    </div>
    <table style="width: 100%; margin: auto;  font-weight: 100px !important;">
    	 	<tbody><tr>
    	 		<td class="span6"><span class="span5" style="font-weight: bold;">ประเภทประกันภัย</span><span class="span1">:</span><span class="span2 dttext" id="ptype"><div><?php echo $tservicee;?></div></span></td>
    	 		<td class="span6"><span class="span5" style="font-weight: bold;">ประเภทซ่อม</span><span class="span1">:</span><span class="span4 dttext" id="psom"><div><?php echo $ins_typee;?></div></span></td> 
    	 	</tr>
    	 	<tr>
    	 		<td class="span6"><span class="span5" style="font-weight: bold;">ทุนประกัน</span><span class="span1">:</span><span class="span6 dttext" id="bsuti"><div><?php echo number_format($ins_cost_endd,2);?></div></span></td>
    	 		<td class="span6"><span class="span5" style="font-weight: bold;">เบี้ยรวม</span><span class="span1">:</span><span class="span6 dttext" id="bsum"><div><?php echo number_format($ins_nett,2);?></div></span></td>
    	 	</tr>
    	 
    	 </tbody></table>
    	</div> -->



<script src="js/total_copy.js" type="text/javascript"></script>
<?php
$css_margin='margin:0;';
$css_margin_font='margin-top:0px;';
$css_margin_font_tab='margin-left:10px;';
$css_margin_font_tab_right='margin-right:30px; float: right;';
$css_margin_left_resize_ti='margin-left:0px; margin-top:7px; text-align: center; width:300px;';
$css_margin_right_resize_ti='margin:0px;text-align:center;width:30px;height:30px;float: right;color:#FFFFFF;line-height: normal;';
$css_padding_left='padding-left:30px;';
$css_padding_left_1='padding-left:5px;';
$css_padding_right='padding-right:30px;';
$css_font_right='padding-right:30px;text-align:right';
$css_margin_form_bottom='margin-bottom:10px;';
$css_font_size_insuree='font-size:15px;';
// mysql_select_db($db2,$cndb2);
?>
<style>
.border_top
{
padding:5px;
    border-style: solid;
    border-width: 1px;
	border-color: #eee;
	border-radius:8px 8px 0px 0px;
	    background-color: rgb(250, 250, 250);
    background-image: linear-gradient(rgb(255, 255, 255), rgb(242, 242, 242));
    box-shadow: rgba(0, 0, 0, 0.0627451) 0px 1px 4px;
    background-repeat: repeat-x;
    border-bottom: 1px solid rgb(212, 212, 212);
	
}
.border_line
{
    border-style: solid;
    border-width: 1px;
	border-top: none;
	border-color: #eee;
	  background-color: rgb(250, 250, 250);
}
.border_line:hover
{
  background-color:#F8F8FF;
}
.design-ti_1
{
	width:100%;
	height:45px;
	background-color:#555555;
	background-image:url("images_checklist/title_left_1.png"),url("images_checklist/title_right_1.png");
	background-position: left top, right top;
	background-repeat: no-repeat, no-repeat;
	background-size:  305px,60px;
	cursor:pointer;
	
}
.design-ti_2
{
	width:100%;
	height:45px;
	background-color:#555555;
	background-image:url("images_checklist/title_left_1.png"),url("images_checklist/title_right_2.png");
	background-position: left top, right top;
	background-repeat: no-repeat, no-repeat;
	background-size:  305px,5px;

	
}
.design-ti_3
{
	
	width:100%;
	background-color:#555555;
	background-image:url("images_checklist/title_table_1.png");
	background-position: left top;
	background-repeat: no-repeat;
	background-size: 100% 100%;
	
}
.design-ti_4
{
	
	width:100%;
	
	background-color:#555555;
	background-image:url("images_checklist/title_left_2.png"),url("images_checklist/title_right_2.png");
	background-position: left top, right top;
	background-repeat: no-repeat, no-repeat;
	background-size:  200px 40px,4px;
	
}
.design-ti_5
{
	height:40px;
	width:100%;
	
	background-color:#555555;
	background-image:url("images_checklist/title_left_2.png"),url("images_checklist/title_right_2.png");
	background-position: left top, right top;
	background-repeat: no-repeat, no-repeat;
	background-size:  250px 40px,4px;
	
}
.design-ti_6
{
	height:35px;
	width:100%;
	
	background-color:#FFFFFF;
	background-image:url("images_checklist/title_left_2.png");
	background-position: left top;
	background-repeat: no-repeat;
	background-size:  500px 35px;
	
}
.color_font_ti
{
	text-align:center;
	border-style:none solid none none;
	border-width:2.5px;
	border-color:#FFFFFF;
	color:#FFFFFF;
	padding:5px 0px 5px 0px;
	border-radius:0px !important;
}
.color_font_ti_stop
{
text-align:center;
	color:#FFFFFF;
	padding:5px 0px 5px 0px;
	border-radius:0px !important;
}
.color_font_ti-2
{
	text-align:center;
	border-style:none solid none none;
	border-width:2.5px;
	border-color:#FFFFFF;
	color:#FFFFFF;
	padding:10px 0px 10px 0px;
	border-radius:0px !important;
}
.color_font_ti_stop-2
{
text-align:center;
	color:#FFFFFF;
	padding:10px 0px 10px 0px;
	border-radius:0px !important;
}
.color_font_ti-3
{
	text-align:left;
	border-style:none solid none none;
	border-width:2.5px;
	border-color:#FFFFFF;
	color:#FFFFFF;
	padding:10px 0px 10px 10px;
	border-radius:0px !important;
}
.color_font_ti_stop-3
{
text-align:left;
	color:#FFFFFF;
	padding:10px 0px 10px 10px;
	border-radius:0px !important;
}
.color_font_all_border
{

	border-color:#555555;
	border-width:2.5px;
	border-style:solid;
	color:#000000;
	background:#FFFFFF;
	padding:7px 7px 7px 7px;
	border-radius:0px !important;
}
.color_font_form
{

	border-color:#555555;
	border-width:2.5px;
	border-style:none solid solid solid;
	color:#000000;
	background:#FFFFFF;
	padding:7px 7px 7px 7px;
	border-radius:0px !important;
}

.border-ti_1-1
{
	font-size:16px;
	text-align:center;padding-top: 8px; color:#FFFFFF;
	border-style:none solid none none;
	border-width:2.5px 1.25px 2.5px 2.5px;
	border-color:#FFFFFF;
}
.border-ti_1-2
{
	font-size:16px;
	text-align:center;padding-top: 8px; color:#FFFFFF;
	border-style:none none none solid;
	border-width:2.5px 2.5px 2.5px 1.25px;
	border-color:#FFFFFF;
}
.border-form_1-1
{
	font-size:16px;
	text-align:center;padding-left: 15px; color:#000000;
	/* //background:#FFFFFF; */
}
.border-form_1-2
{
	border-style:none none none solid;
	border-width:2.5px;
	border-color:#555555;
	font-size:16px;
	text-align:center;padding-left: 15px; color:#000000;
	/* //background:#FFFFFF; */
}
.border-bottom_1-1
{
	border-style:none solid solid solid;
	border-width:2.5px;
	border-color:#555555;
	background:#FFFFFF;
}
.design-form
{
	width:100%;
	border-radius:0px 0px 0px 0px;
	padding-top:5px;
	padding-bottom:10px;
	background-color:rgb(209,209,209);
}
.font-resize-ti
{
	
	font-size:18px;
	margin-top:10px;
	margin-left:10px;
}
.desing-form-insuree
{
	width: 95.5%;
	background-color:#FFFFFF;

	border-color:#555555;
	border-style:solid;
}
.design-value-insuree
{
	display:inline-block;
	width:130px;
	height:130px;
background:linear-gradient(135deg, #555555 46%,rgb(204,138,50) 45.5%, rgb(232,189,33) 47.0%,#555555 0%,#555555 49%,#FFFFFF 0%,#FFFFFF 100%);
}
.design-value-insuree_1
{
	display:inline-block;
	width:130px;
	
background:linear-gradient(135deg, #555555 28%,rgb(204,138,50) 28%, rgb(232,189,33) 29.5%,#555555 0%,#555555 32%,#FFFFFF 0%,#FFFFFF 100%);
}
.desize-font-deg
{
	width:200px;height:60px;
	transform: rotate(-45deg);

}
.desize-font-deg_1
{
	width:85px;height:60px;
	transform: rotate(-45deg);

}
.custom-file-input
{
	color:RED;
	font-weight: bold;
}
.custom-file-input::-webkit-file-upload-button {
  visibility: hidden;
}
.custom-file-input::before {
	content:'เลือกไฟร์';
  color: #fff;
    text-shadow: 0 -1px 0 rgba(0,0,0,0.25);
    background-color: #363636;
    background-image: -moz-linear-gradient(top,#444,#222);
    background-image: -webkit-gradient(linear,0 0,0 100%,from(#444),to(#222));
    background-image: -webkit-linear-gradient(top,#444,#222);
    background-image: -o-linear-gradient(top,#444,#222);
    background-image: linear-gradient(to bottom,#444,#222);
    background-repeat: repeat-x;
    border-color: #222 #222 #000;
    border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff444444',endColorstr='#ff222222',GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
	padding:8px;

}
.custom-file-input:hover::before {
  background: #444444;
}
.custom-file-input:active::before {
  background: -webkit-linear-gradient(top, #777777,#555555);
}
.borimg-color
{
	border-style:solid;border-width:2.5px;border-color:#555555;
}
.e-span1
{
	width:8.33% !important;
}
.e-span2
{
	width:16.66% !important;
}
.e-span3
{
	width:25.00% !important;
}
.e-span4
{
	width:33.33% !important;
}
.e-span5
{
	width:41.66% !important;
}
.e-span6
{
	width:50% !important;
}
.e-span7
{
	width:58.33% !important;
}
.e-span8
{
	width:66.66% !important;
}
.e-span9
{
	width:75.00% !important;
}
.e-span10
{
	width:83.33% !important;
}
.e-span12
{
	font-size:16px;
	padding-left:0px;
	width:100% !important;
}
@media only screen and (max-width: 767px) {
.e-span1
{
	display:block;
	width:100% !important;
}
.e-span2
{
	display:block;
	width:100% !important;
}
.e-span3
{
	display:block;
	width:100% !important;
}
.e-span4
{
	display:block;
	width:100% !important;
}
.e-span5
{
	display:block;
	width:100% !important;
}
.e-span6
{
	display:block;
	width:100% !important;
}
.e-span7
{
	display:block;
	width:100% !important;
}
.e-span8
{
	display:block;
	width:100% !important;
}
.e-span9
{
	display:block;
	width:100% !important;
}
.e-span10
{
	display:block;
	width:100% !important;
}
.font-design select
{
	display:block;
	width:100% !important;
}
}
.bk-event
{
	padding-top:10px;
	background-color:#999999;
	border-style:solid;
	border-width:2px;
	border-color:#555555;
	border-radius:10px;
}
.bk-event-2
{
	padding-top:10px;
	background-color:#CCCCCC;
	border-style:solid;
	border-width:2px;
	border-radius:10px 10px 0px 0px;
	border-color:#777777;
}

.font-design input,.font-design select ,.font-design textarea
{
    border-style: solid;
    border-color: #999999;
    border-width: 2px;
}
.font-design input
{
	height:20px;
	margin-bottom: 3px;
}
.font-design select
{
	width: 87.5%;
	height:32px;
	margin-bottom: 3px;
}
	  @media screen and (max-width: 600px) {
  .smartphone-1 table {
    border: 0;
  }
  .smartphone-1 table caption {
    font-size: 1.3em;
  }
   .smartphone-1 table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }
  .smartphone-1 table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }
  .smartphone-1 table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }
  .smartphone-1 table td:before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  .smartphone-1 table td:last-child {
    border-bottom: 0;
  }
}
</style>
<form name="webForm_inform" id="webForm_inform">
<div class='font-design'>
<!--รายการเสนอราคา-->
<!-- <div class='design-ti_5 span12' style='<?php echo $css_margin?>'>
<div class='font-resize-ti span3' style='<?php echo $css_padding_left?>'><font style='color:#FFFFFF;'>รายการเสนอราคา</font></div>
<a style='margin-right: 5px;float: right;' type='button' class='btn btn-inverse' onclick='$("#quote_show_group").slideToggle();'>ดูรายการเสนอ</a>
</div> -->





<div style="width:99%;margin:5px;display:inline-block;" >
<div class="desing-form-insuree span12">
<div class='design-ti_6 span12' style='<?php echo $css_margin?>'>
<div class='font-resize-ti e-span12 span12' style='<?php echo $css_padding_left_1?><?php echo $css_margin?>font-size:16px;'><img src="images/logo_insured/<?php echo $comp_sortt;?>.png" style="height:35px;">&nbsp;<font style='color:#FFFFFF;'><?php echo $ins_comp;?></font></div>
</div>
<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<div class='span6 e-span6' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>ประเภทการซ่อม</font>
</div>
<div class='span6 e-span6' style='<?php echo $css_margin?>'>
<?php echo $ins_typee;?>
</div>
</div>
<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<div class='span6 e-span6' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>ประเภท</font>
</div>
<div class='span6 e-span6' style='<?php echo $css_margin?>'><?php echo $tservicee;?>
</div>
</div>
<!-- <div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<div class='span6 e-span6' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>ยี่ห้อรถ</font>
</div>
<div class='span6 e-span6' style='<?php echo $css_margin?>'>
<?php echo $quotation_array['br_name'];?>
</div>
</div>
<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<div class='span6 e-span6' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>รุ่นรถ</font>
</div>
<div class='span6 e-span6' style='<?php echo $css_margin?>'>
<?php echo $quotation_array['mo_name'];?>
</div>
</div> -->
<!-- <div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<div class='span6 e-span6' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>ทะเบียนรถ</font>
</div>
<div class='span6 e-span6' style='<?php echo $css_margin?>'>
<?php echo $quotation_array['id_car_regis'];?>
</div>
</div> -->
<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<div class='span6 e-span6' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>ปีรถ</font>
</div>
<div class='span6 e-span6' style='<?php echo $css_margin?>'>
<?php echo (date('Y')+1)-$year_oldcat." (".$year_oldcat." ปี)";?>
</div>
</div>
<!-- <div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<div class='span6 e-span6' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>วันเริ่มคุ้มครอง</font>
</div>
<div class='span6 e-span6' style='<?php echo $css_margin?>'>
<?php echo $quotation_array['start_date'];?>
</div>
</div>
<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<div class='span6 e-span6' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>วันหมดคุ้มครอง</font>
</div>
<div class='span6 e-span6' style='<?php echo $css_margin?>'>
<?php echo $quotation_array['end_date'];?>
</div>
</div> -->


<!--ความคุ้มครองแบบ  TEXT-->
<div class='span12 e-span12' style='<?php echo $css_margin?>font-size:14px !important;'>
<div  style='width:97%;margin-left: 10px;'>
<div class='desing-form-insuree span12'>
<div class='span2 e-span2' style='<?php echo $css_margin?>'>
<div class='design-value-insuree_1'>
<div class='desize-font-deg_1'><font style='color:#FFFFFF;' size='1'>ค่าความคุ้มครอง</font></div>
</div>
</div>
<div class='span10 e-span10' style='<?php echo $css_margin?>'>


<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>

<!--text-->
<div class='span7 e-span7' style='<?php echo $css_margin." ".$css_margin_font?>'>
<center><font>ทุนประกันภัย</font></center>
</div>
<!--number-->
<div class='span3 e-span3' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab_right?>' id='cost_long'><?php echo number_format(str_replace(',','',$ins_cost_endd));?></font>
</div>
<!--unit-->
<div class='span2 e-span2' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>บาท</font>
</div>
</div>
<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<!--text-->
<div class='span7 e-span7' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font><u>ความรับผิดต่อบุคคลภายนอก</u></font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab_right?>'></font>
</div>
<!--unit-->
<div class='span2 e-span2' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'></font>
</div>

</div>
<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<!--text-->
<div class='span7 e-span7' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>- ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย</font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab_right?>' id='damage_out1_long'><?php echo number_format(str_replace(',','',$life));?></font>
</div>
<!--unit-->
<div class='span2 e-span2' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>บาท/คน</font>
</div>

</div>
<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<!--text-->
<div class='span7 e-span7' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>- ความเสียหายต่อทรัพสิน</font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab_right?>' id='damage_cost_long'><?php echo number_format(str_replace(',','',$asset));?></font>
</div>
<!--unit-->
<div class='span2 e-span2' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>บาท/ครั้ง</font>
</div>

</div>
<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<!--text-->
<div class='span7 e-span7' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font><u>ความคุ้มครองตามเอกสารแนบท้าย</u></font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab_right?>'></font>
</div>
<!--unit-->
<div class='span2 e-span2' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'></font>
</div>

</div>

<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<!--text-->
<div class='span7 e-span7' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>- ผู้ขับขี่ 1 คน</font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab_right?>' id='pa1_long'><?php echo number_format(str_replace(',','',$driver));?></font>
</div>
<!--unit-->
<div class='span2 e-span2' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>บาท/คน</font>
</div>

</div>
<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<!--text-->
<div class='span7 e-span7' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>- ผู้โดยสาร</font> <font style='' id='people_long'><?php echo $tickets;?></font> <font style=''>คน</font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab_right?>' id='pa2_long'><?php echo number_format(str_replace(',','',$driver));?></font>
</div>
<!--unit-->
<div class='span2 e-span2' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>บาท/คน</font>
</div>

</div>
<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<!--text-->
<div class='span7 e-span7' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>- ค่ารักษาพยาบาล</font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab_right?>' id='pa3_long'><?php echo number_format($nurse,0);?></font>
</div>
<!--unit-->
<div class='span2 e-span2' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>บาท/คน</font>
</div>

</div>
<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<!--text-->
<div class='span7 e-span7' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>- การประกันตัวผู้ขับขี่ในคดีอาญา</font>
</div>
<!--number-->
<div class='span3 e-span3' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab_right?>' id='pa4_long'><?php echo number_format(str_replace(',','',$nurse));?></font>
</div>
<!--unit-->
<div class='span2 e-span2' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>บาท/ครั้ง</font>
</div>

</div>




</div>
</div>
</div>
</div>
<!--end-->
<!-- <div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<div class='span6 e-span6' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>เบี้ยประกันภัยรวม ภาษี อากร <?php if(str_replace(',','',$quotation_array['tax1per'])>0){echo "(หัก 1 %)";} ?></font>
</div>
<div class='span4 e-span4' style='<?php echo $css_margin?>'>
<?php echo number_format(str_replace(',','',$ins_nett),2,'.',',');?>
</div>
<div class='span2 e-span2' style='<?php echo $css_margin?>'>
บาท
</div>
</div> -->
<!-- <div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<div class='span6 e-span6' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>พ.ร.บ. <?php if(str_replace(',','',$quotation_array['tax1per'])>0){echo "(หัก 1 %)";} ?></font>
</div>
<div class='span4 e-span4' style='<?php echo $css_margin?>'>
<?php echo number_format(str_replace(',','',$quotation_array['prb_amt']),2,'.',',');?>
</div>
<div class='span2 e-span2' style='<?php echo $css_margin?>'>
บาท
</div>
</div> -->
<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<div class='span6 e-span6' style='<?php echo $css_margin." ".$css_margin_font?>'>
</div>
<div class='span4 e-span4' style='<?php echo $css_margin?>'>
</div>
<div class='span2 e-span2' style='<?php echo $css_margin?>'>
</div>
</div>

<div class='span12 e-span12' style='<?php echo $css_margin.$css_font_size_insuree?>'>
<div class='span6 e-span6' style='<?php echo $css_margin." ".$css_margin_font?>'>
<font style='<?php echo $css_margin_font_tab?>'>เบี้ยประกันรวม</font>
</div>
<div class='span4 e-span4' style='<?php echo $css_margin?>'>
<?php echo number_format(str_replace(',','',$ins_nett),2,'.',',');?>
</div>
<div class='span2 e-span2' style='<?php echo $css_margin?>'>
บาท
</div>
</div>
<!-- <div class='span12 e-span12' style='<?php echo $css_margin?>padding-bottom:5px;'>
<center><a type='button' class='btn btn-small btn-inverse' onclick='data_quotation_array("<?php echo $_POST['q_auto'];?>","<?php echo $quotation_array['pages_quotation'];?>");$("#quote_show_group").slideToggle();'>เลือก คลิก!!</a></center>
</div> -->

</div>
</div>

</div>