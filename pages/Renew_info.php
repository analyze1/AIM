<?php
include "check-ses.php";
include "../inc/connectdbs.inc.php";
header('Content-Type: text/html; charset=utf-8');
?>
<script src="js/js_Renew.js"></script>
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/jquery-ui-1.10.3.custom.js"></script>
<!--
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
-->
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />
<?

function thaiDate($datetime) 
{
	list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.

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
	return $d."/".$m."/".$Y." ".$H.":".$i.":".$s;
} 

function thaiDate2($datetime) 
{
	list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.

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

function thaiDate3($datetime) 
{
	list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
	$Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.

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

function payType($payType)
{
	switch($payType) 
	{
		case "1": $payType = "เงินสด"; break;
		case "2": $payType = "บัตรเครดิต"; break;
		case "3": $payType = "อิออน"; break;
	}
	return $payType;
}

function payAmount($payAmount)
{
	switch($payAmount) 
	{
		case "1": $payAmount = "ชำระเต็มจำนวน"; break;
		case "3": $payAmount = "แบ่งชำระ 3 งวด"; break;
		case "6": $payAmount = "แบ่งชำระ 6 งวด"; break;
		case "A1": $payAmount = "เคาน์เตอร์เซอร์วิส"; break;
		case "A2": $payAmount = "ตัดบัตรเต็มจำนวน"; break;
	}
	return $payAmount;
}

function renew($renew)
{
	switch($renew) 
	{
		case "R": $renew = "ติดตาม"; break;
		case "S": $renew = "เสนอราคา"; break;
		case "C": $renew = "แจ้งงาน"; break;
		case "A": $renew = "ติดต่อได้ไม่ได้"; break;
		case "W": $renew = "ขอคิดดูก่อน/ไม่สะดวก"; break;
		case "E": $renew = "ปิดงาน"; break;
		case "O": $renew = "ที่อื่นถูกกว่า"; break;
		case "N": $renew = "ไม่สนใจ"; break;
	}
	return $renew;
}

mysql_select_db($db1, $cndb1);
$IDDATA = $_GET['IDDATA'];

$mocd = $_SESSION["MoCd"];
$ProName = $_SESSION["Pro"];
$AmpName = $_SESSION["Amp"];
$TumName = $_SESSION["Tum"];

$costOb = $_SESSION["Cost"];
$costObname = $_SESSION["CostName"];
$Cost_PRE = $_SESSION["CostPre"];
$MoC = $_SESSION["MoC"];

if($_SESSION["strUser"] == 'admin')
{
	$query = "SELECT * FROM data ";
	$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
	$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
	$query .= "INNER JOIN insuree ON (data.id_data = insuree.id_data) ";
	$query .= "INNER JOIN req ON (data.id_data = req.id_data) ";
	$query .= " WHERE data.id_data = '".$IDDATA."' ORDER BY data.end_date DESC ";
	$objQuery = mysql_query($query, $cndb1) or die ("Error Query [".$query."]");
	$row = mysql_fetch_array($objQuery);
}
else
{
	$query = "SELECT * FROM data ";
	$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
	$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
	$query .= "INNER JOIN insuree ON (data.id_data = insuree.id_data) ";
	$query .= "INNER JOIN req ON (data.id_data = req.id_data) ";
	$query .= " WHERE data.id_data = '".$IDDATA."' AND data.login = '".$_SESSION["strUser"]."' ORDER BY data.end_date DESC ";
	$objQuery = mysql_query($query, $cndb1) or die ("Error Query [".$query."]");
	$row = mysql_fetch_array($objQuery);
}

// ทุนต่ออายุ
$costW = explode(",",substr($Cost_PRE['PreCost'][$row['costCost']],0,7));
$CalculaCost = $costW[0].$costW[1];

// บวก ตกแต่งเพิ่มเติม
if($row['EditProduct'] == 'Y')
{
  $ResultCost = ($CalculaCost+$row['TotalProduct'])-30000; 
}
else
{
  $ResultCost = ($CalculaCost+$row['price_total'])-30000; 
}

//  ERTIGA
if($row['mo_car'] == '1960')
{
  $queryCostrenew = "SELECT * 
  						FROM UCostRenew 
  						WHERE (type = 'S30' OR type = 'S_Rate') AND service = '2'  AND mo_car = '1960' AND cost = '".$ResultCost."' ";
  $objQueryRenew = mysql_query($queryCostrenew, $cndb1) or die ("Error Query [".$queryCostrenew."]");
  $rowRenew = mysql_fetch_array($objQueryRenew);
  $type = 'S30';
  $type_2 = 'S_Rate';
}
// SWIFT ECO CELERIO SWIFT RX SWIFT DUO
else if($row['mo_car'] == '1951' || $row['mo_car'] == '1964' || $row['mo_car'] == '1967' || $row['mo_car'] == '1968' || $row['mo_car'] == '1969')
{
  $queryCostrenew = "SELECT * 
  						FROM UCostRenew 
  						WHERE (type = 'S30' OR type = 'S_Rate') AND service = '2'  AND mo_car = '' AND cost = '".$ResultCost."' ";
  $objQueryRenew = mysql_query($queryCostrenew, $cndb1) or die ("Error Query [".$queryCostrenew."]");
  $rowRenew = mysql_fetch_array($objQueryRenew);
  $type = 'S30';
  $type_2 = 'S_Rate';
}
// carry
else if($row['mo_car'] == '1098')
{
  $queryCostrenew = "SELECT * 
  						FROM UCostRenew 
  						WHERE type = 'AS2' AND service = '2'  AND mo_car = '' AND cost = '".$ResultCost."' ";
  $objQueryRenew = mysql_query($queryCostrenew, $cndb1) or die ("Error Query [".$queryCostrenew."]");
  $rowRenew = mysql_fetch_array($objQueryRenew);
  $type = 'AS2';
  $type_2 = '';
}

//////////////////////////////////////////
$costW = explode(",",substr($rowRenew['cost'],0,7));
$CalculaCost = $costW[0].$costW[1];
$Cost_NEW = $ResultCost;
//////////////////////////////////////////

$query_URenew = "SELECT * FROM URenew WHERE  URenew.renew_id ='".$IDDATA."'";
$objQuery_URenew = mysql_query($query_URenew, $cndb1) or die ("Error Query [".$query_URenew."]");
$row_URenew = mysql_fetch_array($objQuery_URenew);
?>

<style type="text/css">
    <!--
    a:link {
       text-decoration: none;
   }
   a:visited {
       text-decoration: none;
   }
   a:hover {
       text-decoration: underline;
   }
   a:active {
       text-decoration: none;
   } 
   .datepicker {
	   z-index:: 3000 !important;
   }
-->
</style>

<ul id="myTab" class="nav nav-tabs">
	<li class="active"><a href="#tab1" data-toggle="tab">อัตราเบี้ยต่ออายุ</a></li>
    <!--<li><a href="#tab2" data-toggle="tab">ข้อมูลผู้เอาประกันภัย</a></li>
	<li ><a href="#tab3" data-toggle="tab">บันทึกติดตาม</a></li>-->
</ul>

<form id="formInsertrenew" name="formInsertrenew" method="POST">

<input type="hidden" name="Cost_NEW_JS" id="Cost_NEW_JS" value="<?=$Cost_NEW?>"></input>
<input type="hidden" name="CalculaCost_JS" id="CalculaCost_JS" value="<?=$CalculaCost?>"></input>

<div class="tab-content">
	<div class="tab-pane fade in active" id="tab1">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
            		<div class="widget-header widget-header-flat"> <h4>ข้อมูลการติดต่อ</h4></div>
                	<div class="widget-body">
                    	<div class="widget-main">
                       		<div class="row-fluid">
                           		<div class="span12">
									<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
										<tr bgcolor="#CFCFCF">
											<td width="13%">ชื่อผู้เอาประกัน : </td>
											<td colspan="5">
											  <select id="title" name="title">
													<option value="0" selected="selected">กรุณาเลือก</option>
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
												  </select><font color="#FF0000"><b>  *</b></font>
											  <input type="text" class="comment" name="name" value="<?=$row['name'];?>"><font color="#FF0000"><b>  *</b></font>
											  <input type="text" class="comment" name="last" value="<?=$row['last'];?>"><font color="#FF0000"><b>  *</b></font>                  
											</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td>ทะเบียน :</td>
											<td>
												<select name="car_regis_select" id="car_regis_select">
													<option value="N" selected="selected">กรุณาเลือก</option>
													<option value="T">ป้ายแดง</option>
													<option value="F">อื่นๆ</option>
											   </select>
											   <font style="display:none;" id="renew_car_regis_recheck"><input type="text" class="span7" value="<?=$row['car_regis'];?>" name="renew_car_regis" id="renew_car_regis" /><font color="#FF0000"><b>  *</b></font></font>
											</td>
											<td>จังหวัดทะเบียน :</td>
											<td>
												<select id="car_regis_pro" name="car_regis_pro">
													<?
													foreach($_SESSION["Pro"] as $key => $value)
													{
														echo "<option value='$key'";
														if($key==$row['car_regis_pro']){echo "selected";}
														echo ">$value</option>";
													}
													?>
												</select>
											</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										</tr>
									    <tr bgcolor="#CFCFCF">
										    <td>Email :</td>
										    <td width="19%"><input type="text" size="25" value="<?=$row['email']?>" name="email" id="email" /></td>
										    <td width="18%">โทรศัพบ้าน / ที่ทำงาน :</td>
										    <td width="17%"><input type="text" class="span8" value="<?=$row['tel_home']?>" name="home" id="home" maxlength="9"/></td>
										    <td width="16%">เบอร์โทรศัพท์มือถือ :</td>
										    <td width="17%"><input type="text" class="span8" value="<?=$row['tel_mobi']?>" name="mobile" id="mobile" maxlength="10" /></td>
									    </tr>
										<tr bgcolor="#CFCFCF">
											<td>Email 2 :</td>
											<td><input type="text" size="25" value="<?=$row['email2']?>" name="email2" id="email2"/></td>
											<td>โทรศัพบ้าน / ที่ทำงาน 2 :</td>
											<td><input type="text" class="span8" value="<?=$row['tel_home2']?>" name="home2" id="home2" maxlength="9"/></td>
											<td>เบอร์โทรศัพท์มือถือ 2 :</td>
											<td><input type="text" class="span8" value="<?=$row['tel_mobi_2']?>" name="mobile2" id="mobile2" maxlength="10" /></td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td>เบอร์แฟกซ์ :</td>
											<td><input type="text" class="span7" value="<?=$row['fax']?>" name="fax" id="fax" maxlength="9"/></td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>           
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
            		<div class="widget-header widget-header-flat"> <h4>ที่อยู่ตามกรมธรรม์</h4></div>
               		<div class="widget-body">
                   		<div class="widget-main">
                       		<div class="row-fluid">
                           		<div class="span12">
									<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
										<tr bgcolor="#CFCFCF">
											<td>เลขที่ :</td>
											<td><input type="text" size="10" value="<?=$row['add']?>" name="add" id="add" /> </td>
											<td>หมู่ :</td>
											<td><input type="text" size="10" value="<?=$row['group']?>" name="group" id="group" /></td>
											<td>หมู่บ้าน/อาคาร :</td>
											<td><input type="text" size="25" value="<?=$row['town']?>" name="town" id="town" /></td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td>ซอย :</td>
											<td><input type="text" size="25" value="<?=$row['lane']?>" name="lane" id="lane" /></td>
											<td>ถนน :</td>
											<td><input type="text" size="25" value="<?=$row['road']?>" name="road" id="road" /></td>
											<td>จังหวัด :</td>
											<td>
												<select name='province' id='province' onchange="Amp();" >
												<?
													foreach($_SESSION["Pro"] as $key => $value)
													{
														echo "<option value='$key'";
														if($key==$row['province']){echo "selected";}
														echo ">$value</option>";
													}
												?>
												</select>
											</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td>เขต/อำเภอ :</td>
											<td>
												<select name='amphur' id='amphur' onchange="Tum();"></select>
											</td>
											<td>แขวง/ตำบล :</td>
											<td>
												<select name='tumbon' id='tumbon' onchange="Post();"></select>
											</td>
											<td>รหัสไปรษณีย์ :</td>
											<td><input type="text" size="25" value="<?=$row['postal']?>" name="postal" id="postal" /></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
            		<div class="widget-header widget-header-flat"> <h4>ที่อยู่ในการจัดส่ง</h4></div>
                	<div class="widget-body">
                    	<div class="widget-main">
                       		<div class="row-fluid">
                           		<div class="span12">
									<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
										<tr bgcolor="#CFCFCF">
											<td colspan="6"><textarea rows="3" style="width:60%;" id="send_add" name="send_add"><?=$row['SendAdd']?></textarea></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
           			<div class="widget-header widget-header-flat"> <h4>ข้อมูลต่ออายุ Mitsubishi</h4></div>
               		<div class="widget-body">
                   		<div class="widget-main">
                       		<div class="row-fluid">
                           		<div class="span12">                           
									<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
										<tr bgcolor="#CFCFCF">
											<td width="13%">วันคุ้มครอง</td>
											<td width="25%">
												<?
												$date_check = date("Y-m-d");
												if($row['end_date'] >= $date_check)
												{
													$new_date = thaiDate3($row['end_date']);
												}
												else
												{
													$new_date = date("d/m/Y");
												}
												?>
												<input name="start_date_renew" type="text" id="start_date_renew" value="<?=$new_date;?>" />
											</td>
											<td width="19%">การติดตาม :</td>
											<td width="32%">
												<select  name="head_follow" id="head_follow">
													<option value='' >กรุณาเลือก</option>
													<option value='S' >เสนอราคา</option>
													<option value='E' >แจ้งต่ออายุประกันภัย</option>
												</select>
												<font color="#FF0000"><b>  *</b></font>
											</td>
											<td width="5%">&nbsp;</td>
											<td width="6%">&nbsp;</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td width="13%">&nbsp;</td>
											<td width="25%">&nbsp;</td>
											<td width="19%">ประเภทประกันภัย :</td>
											<td width="32%">
												<select  name="doc_type_select" id="doc_type_select">
													<option value=''>กรุณาเลือก</option>
													<option value='1'>1</option>
													<option value='2+'>2+</option>
													<option value='3+'>3+</option>
												</select>
											<font color="#FF0000"><b>  *</b></font></td>
											<td width="5%">&nbsp;</td>
											<td width="6%">&nbsp;</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td width="13%">เลขที่ต่ออายุ : </td>
											<td width="25%"><input type="text" value="<?=$row['id_data'];?>" name="OQ" id="OQ"  readonly /></td>
											<td width="19%">ซ่อม :</td>
											<td width="32%">
												<select  class="TotalPrice" name="service" id="service" style="border-color:red;color:red;" onchange="Stun();" >
													<option value=''>กรุณาเลือก</option>
													<option value='1'>ซ่อมห้าง</option>
													<option value='2' >ซ่อมอู่</option>
												</select>
												<font color="#FF0000"><b>  *</b></font>
											</td>
											<td width="5%">&nbsp;</td>
											<td width="6%">&nbsp;</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td>รุ่นรถ : </td>
											<td>Mitsubishi - <?=$MoC[$row['mo_car']]?></td>
											<td>ทุน : </td>
											<td colspan="2">
												<input class="span2" type="hidden" size='4' value="" name="SRate_ReCheck" id="SRate_ReCheck"  readonly />
												<input class="span2" type="hidden" size='4' value="<?=$type_2;?>" name="type_SRate" id="type_SRate"  readonly />
												<input class="span2" type="hidden" size='4' value="<?=$type;?>" name="type" id="type"  readonly />
												<input class="span2" type="hidden" size='4' value="<?=$MoC[$row['mo_car']];?>" name="mo_car" id="mo_car"  readonly />
												<select class="TotalPrice" name="tun" id="tun" onchange="Stun();">
													<option value="0">กรุณาเลือก</option>
												</select>
												<input type="hidden" class="TotalPrice" size="15"  value="" name="pre-set" id="pre-set"  readonly />
											<font color="#FF0000"><b>  *</b></font></td>
											<td>&nbsp;</td>
										</tr>
										<tr bgcolor="#CFCFCF" style="display:none;">
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>ส่วนลดกลุ่ม : </td>
											<td width="30%" colspan="2">
											  <select style="display:none;" class="span2" name="dgroup" id="dgroup" onchange="calcfunc();"><option value='10'>10%</option></select>
											  <input type="text" class="TotalPrice" value="" name="showgroup" id="showgroup" onkeyup="calcfunc(true);" readonly="readonly" />
											</td>
											<td width="10%">&nbsp;</td>
										</tr>
										<tr bgcolor="#CFCFCF" style="display:none;">
											<td width="10%">&nbsp;</td>
											<td width="10%">&nbsp;</td>
											<td>ส่วนลดประวัติดี : </td>
											<td width="30%" colspan="2">
												<select style="display:none;" class="span2" name="dgood" id="dgood" onchange="calcfunc();"><option value='25'>25%</option></select>
												<input size="15" class="TotalPrice" type="text" value="" name="showgood" id="showgood"  onkeyup="calcfunc(true);" readonly="readonly" />
											</td>
											<td width="10%">&nbsp;</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td width="13%">เบี้ยรวม : </td>
											<td width="25%"><select style="display:none;" class="span2" name="dgroup" id="dgroup" onchange="calcfunc();"><option value='10'>10%</option></select>
												<select style="display:none;" class="span2" name="dgood" id="dgood" onchange="calcfunc();"><option value='25'>25%</option></select>
											<input class="TotalPrice3" size="15" type="text" value="" name="net" id="net"  readonly /></td>
											<td>พ.ร.บ. : </td>
											<td>
												<select class="TotalPrice" name="act" id="act" onchange="calcfunc();" >
												<option value="">กรุณาเลือก</option>
												<?php 
												if($MoC[$row['mo_car']] =='CARRY')
												{
													echo '<option value="967.28">967.28</option>';
												}
												else
												{
													echo '<option value="645.21">645.21</option>';
												}
												?>
												<option value="N">ไม่เอา พ.ร.บ.</option>
												</select><font color="#FF0000"><b>  *</b></font>
											</td>
											<td width="5%">&nbsp;</td>
											<td width="6%">&nbsp;</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td width="13%">ลูกค้าชำระ : </td>
											<td width="25%">
											<input style="display:none;" onkeypress="calcfunc();"  class="TotalPrice" size="15" type="text" value="0" name="netdis" id="netdis"  />
											<input class="TotalPrice3" size="15" type="text" value="0.00" name="netact" id="netact" readonly  /></td>
											<td>ประเภทการชำระ : </td>
											<td>
												<select name="bill_pay" id="bill_pay">
													<option value="" selected="selected">กรุณาเลือก</option>
													<option value="1">เงินสด</option>
													<option value="2">บัตรเครดิต</option>
													<option value="3">7-11</option>
												</select><font color="#FF0000"><b>  *</b></font>
											</td>
											<td width="5%">&nbsp;</td>
											<td width="6%">&nbsp;</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td width="13%">คอมมิตชั่น : </td>
											<td width="25%"><input class="TotalPrice" size="15" type="text" value="0.00" name="com" id="com"  readonly  /></td>
											<td><font id="installment" style="display:none;">งวดชำระ : </font></td>
											<td colspan="3">
												<font id="installment2" style="display:none;"><select name="pay_amount" id="pay_amount" onchange="calcfunc(this);">
													<option value="" selected="selected">กรุณาเลือก</option>
													<option id="1" value="1">ชำระเต็มจำนวน</option>
													<option id="3" value="3">ผ่อนชำระ 3 เดือน (2.5%)</option>
													<option id="6" value="6">ผ่อนชำระ 6 เดือน (4.5%)</option>
													<option id="A1" value="A1">เคาน์เตอร์เซอร์วิส</option>
													<option id="A2" value="A2">ตัดบัตรเต็มจำนวน (2%)</option>
												</select><font color="#FF0000"><b>  *</b></font></font>
											</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td width="13%">Service change : </td>
											<td width="25%"><input type="text" value="0.00" name="dis_sv" id="dis_sv" onkeyup="calcfunc();" readonly="readonly" /></td>
											<td>ส่วนลดเพิ่มเติม : </td>
											<td><input class="TotalPrice" type="text" value="0.00" name="dis_count_add" id="dis_count_add" onkeyup="calcfunc();" /></td>
											<td width="5%">&nbsp;</td>
											<td width="6%">&nbsp;</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td width="13%">เบี้ยนำส่ง : </td>
											<td width="25%"><input class="TotalPrice2" size="15" type="text" value="0.00" name="snet" id="snet" readonly style="border-color:red;color:red;"  /></td>
											<td colspan="4" valign="middle" align="center"><font color="#FF0000" id="text_pay" style="display:none;"></font><input type="hidden" value="" name="text_payAA" id="text_payAA" readonly /></td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td colspan="3"></td>
											<td colspan="3">
												<?
													$query_detailRenew = "SELECT * FROM detail_renew WHERE  detail_renew.id_data ='".$IDDATA."' AND status = 'E' ";
													$objQuery_detailRenew = mysql_query($query_detailRenew, $cndb1) or die ("Error Query [".$query_detailRenew."]");
													$row_detailRenew = mysql_fetch_array($objQuery_detailRenew);
												?>
												<?
													if($row_detailRenew['id_data'] == '')
													{
												?>
														<button class="btn btn-info" id="save_renew" type="button"><i class="icon-white icon-save"></i> บันทึกใบเสนอราคา</button>
												<?
													}
												?>
											  
												<? if($row_URenew['renew_cost'] != '0' && $row_URenew['renew_id'] != ''){?><a title="พิมพ์ใบเตือน" href="javascript:void(0)" onclick="window.open('print/print_Alert.php?IDDATA=<?=$row['id_data']; ?>','welcome','menubar=no,status=no,scrollbars=yes')" class="btn btn-warning" ><i class="icon-white icon-print"></i>พิมพ์ใบเสนอราคา</a><? } ?>
											</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td colspan="6">
												<font color="#FF0000"><b>
												** ข้อกำหนดและเงื่อนไข **<br />
												1. บัตรเครดิตที่ร่วมรายการ เซ็นทรัล การ์ด, โรบันสัน การ์ด, บัตรเครดิตของธนาคารกสิกรไทย, ธนาคารกรุงศรีอยุธยา และ ธนาคารกรุงเทพ เท่านั้น<br />
												2. ในกรณีที่เลือกชำระเงินผ่าน เคาน์เตอร์เซอร์วิส สามารถชำระได้ทุกสาขาทั่วประเทศ
												</b></font>
											</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td colspan="6"><font color="#FF0000"><b>ในกรณีที่มีปัญหาในการใช้งาน กรุณาติดต่อเจ้าหน้าที่ hotline: 085-921-3636, 085-921-5454<br />กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนทำการบันทึก มิฉะนั้นข้อมูลจะไม่สมบูรณ์</b></font></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
            		<div class="widget-header widget-header-flat"> <h4>รายการติดตามต่ออายุ</h4></div>
               		<div class="widget-body">
                   		<div class="widget-main">
                       		<div class="row-fluid">
                           		<div class="span12">
									<table id="example1" width="100%" border="1" bordercolor="#FFFFFF" cellpadding="0" cellspacing="0" class="table">
										<tr bgcolor="#CFCFCF">
											<td><font size="-1"><div align="center">วันที่บันทึก</div></font></td>
											<td><font size="-1"><div align="center">วันที่นัดหมาย</div></font></td>
											<td><font size="-1"><div align="center">เบี้ยรวม</div></font></td>
											<td><font size="-1"><div align="center">พรบ.</div></font></td>
											<td><font size="-1"><div align="center">ลูกค้าชำระ</div></font></td>
											<td><font size="-1"><div align="center">คอมมิตชั่น</div></font></td>
											<td><font size="-1"><div align="center">เบี้ยนำส่ง</div></font></td>
											<td><font size="-1"><div align="center">ประเภทชำระ</div></font></td>
											<td><font size="-1"><div align="center">งวดชำระ</div></font></td>
											<td><font size="-1"><div align="center">สถานะ</div></font></td>
											<td><font size="-1"><div align="center">รายละเอียด</div></font></td>
										</tr>
										<?
										$txtsql_detailR = "SELECT * FROM detail_renew "; 
										$txtsql_detailR .= "INNER JOIN data ON (detail_renew.id_data = data.id_data) ";
										$txtsql_detailR .= "INNER JOIN detail ON (detail_renew.id_data = detail.id_data) ";
										$txtsql_detailR .= "INNER JOIN insuree ON (detail_renew.id_data = insuree.id_data) ";
										$txtsql_detailR .= "WHERE detail_renew.id_data = '".$row['id_data']."' and userdetail = 'DEALER' order by id_detail DESC ";
										$result_detailR = mysql_query($txtsql_detailR, $cndb1) or die ("Error Query [ $txtsql_detailR ]");		
										while($row_detailR = mysql_fetch_array($result_detailR))
										{
											$txt_form="".$row_detailR['id_data']."|".$row_detailR['title']."|".$row_detailR['name']."|".$row_detailR['last']."|".$row_detailR['br_car']."|".$row_detailR['mo_car']."|".$row_detailR['car_regis']."|".$row_detailR['com_data']."|".str_replace('ประกันภัยรถยนต์ประเภท ', '', $row_detailR['doc_type'])."|".$row_detailR['tel_mobi'];
											$new_detail = explode("|",$row_detailR['detailcost']);
											
											$url_arr['date_detail'] = thaiDate($row_detailR['date_detail']);
											$url_arr['timecall'] = thaiDate($row_detailR['timecall']);
											$url_arr['pretotal'] = number_format($new_detail[10],2);
											$url_arr['prb'] = number_format($new_detail[9],2);
											$url_arr['sum_pretotal'] = number_format($new_detail[8],2);
											$url_arr['status'] = renew($row_detailR['status']);
											$url_arr['detailtext'] = $row_detailR['detailtext'];
											$url_arr['date_alert'] = date('d/m/Y', strtotime($row_detailR['date_alert']));
											$url_arr['id_detail2'] = $row_detailR['id_detail'];
											$url_arr['userdetail'] = $row_detailR['userdetail'];
											$url_arr = array_merge($url_arr, explode("|",$txt_form));
											$url_encode = array();
											foreach($url_arr as $i=>$o)
											{
												$o = urlencode($o);
												$url_encode[] = "{$i}={$o}";
											}
											$url_encode = join("&",$url_encode);
											
											$sql_bill = "SELECT int_status FROM payment_installment WHERE  int_iddata = '".$row_detailR['id_data']."' AND int_ref = 'RENEW|".$row_detailR['id_detail']."'";
											mysql_select_db($db3, $cndb3);
											$query_bill = mysql_query($sql_bill, $cndb3) or die (mysql_error() . "<br>Error sql [" . $sql_bill . "]");
											$obj_bill = mysql_fetch_array($query_bill);
										?>
											<tr bgcolor="#E8E8E8">
												<td width="10%"><font size="-1"><div align="center"><?=thaiDate2($row_detailR['date_detail']);?></div></font></td>
												<td width="10%"><font size="-1"><div align="center"><?=thaiDate2($row_detailR['date_alert']);?></div></font></td>
												<td><font size="-1"><div align="right"><?=number_format($new_detail[10],2);?></div></font></td>
												<td><font size="-1"><div align="right"><?=$new_detail[9];?></div></font></td>
												<td><font size="-1"><div align="right"><?=number_format($new_detail[8],2);?></div></font></td>
												<td><font size="-1"><div align="right"><?=number_format($new_detail[13],2);?></div></font></td>
												<td><font size="-1"><div align="right"><?=number_format($new_detail[14],2);?></div></font></td>
												<td><font size="-1"><div align="center"><?=payType($row_detailR['detailpaytype']);?></div></font></td>
												<td><font size="-1"><div align="center"><?=payAmount($row_detailR['detailpayamount']);?></div></font></td>
												<td><font size="-1"><div align="center"><?=renew($row_detailR['status']);?></div></font></td>
												<td>
													<font size="-1"><div align="center">
													<a title="พิมพ์ใบเตือน" href="javascript:void(0)" style="width:140px; margin-top:5px;" onclick="window.open('print/print_Alert_detail.php?IDDATA=<?=$row_detailR['id_data']; ?>&&detail_id=<?=$row_detailR['id_detail']; ?>','welcome','menubar=no,status=no,scrollbars=yes')" class="btn btn-small btn-warning" ><i class="icon-white icon-print"></i>พิมพ์ใบเสนอราคา</a><br />
													<a title="ปิดงาน" class="btn btn-small btn-info success_update" style="width:140px; margin-top:5px;" data-id="<?=$row_detailR['id_detail'];?>" name="success_update[<?=$row_detailR['id_detail'];?>]" ><i class="icon-white icon-ok"></i>แจ้งงาน</a><br />
													<? if($obj_bill['int_status'] != 'C'){ ?>
													<? if($row_detailR['detailpayamount'] == 'A1' || $row_detailR['detailpayamount'] == 'A2'){ ?>
														<a data-toggle="modal" id="btnpay" class="btn btn-small btn-success" style="width:140px; margin-top:5px;" href="pages/plan_payonline_renew.php?<?php echo $url_encode;?>" aria-hidden="true" data-target="#modal_PayOnline"><i class="icon-shopping-cart icon-white" ></i>ชำระเงิน</a>
													<? } ?>
													<? } ?>
													<? if($obj_bill['int_status'] == 'R'){ ?>
														<a class="btn btn-small btn-danger" style="width:140px; margin-top:5px;" href="javascript:cancel_payinstallment('<?=$row_detailR['id_data']; ?>','<?=$row_detailR['id_detail']; ?>')" aria-hidden="true" data-target="#modal_PayOnline"><i class="icon-ban-circle icon-white" ></i>ยกเลิก</a>
													<? } ?>
													</div></font>
												</td>
											</tr>
										<?
										}
										?>
									</table>                              
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>   
	<div class="tab-pane fade" id="tab2">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
            		<div class="widget-header widget-header-flat"> <h4>test tab2</h4></div>
               		<div class="widget-body">
                   		<div class="widget-main">
                       		<div class="row-fluid">
                           		<div class="span12">
									<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
										<tr bgcolor="#CFCFCF">
											<td>test</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td colspan="6"><textarea rows="4" style="width:70%;"type="text" name="test" id="test" ></textarea></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> 
	<div class="tab-pane fade" id="tab3">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-header widget-header-flat"> <h4>test tab3</h4></div>
                	<div class="widget-body">
                    	<div class="widget-main">
                       		<div class="row-fluid">
                           		<div class="span12">
									<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
										<tr bgcolor="#CFCFCF">
											<td>หมายเหตุ :</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
											<td>&nbsp;</td>
										</tr>
										<tr bgcolor="#CFCFCF">
											<td colspan="6"><textarea rows="4" style="width:70%;"type="text" name="comment" id="comment" ></textarea></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- close tab-content -->
</form><!-- close formInsertrenew -->

<script type='text/javascript'>
	jQuery.fn.simulateClick = function()
	{
		return this.each(function() 
		{
			if('createEvent' in document) 
			{
				var doc = this.ownerDocument,
                evt = doc.createEvent('MouseEvents');
				evt.initMouseEvent('click', true, true, doc.defaultView, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
				this.dispatchEvent(evt);
			}
			else
			{
				this.click(); // IE
			}
		});
	}
	$("#save_renew").click(function()
	{	
		if($("#tun").val()=='0')
		{
			$("#tun").focus();
			alert('กรุณาเลือกทุนประกันภัย');
			return false;
		}
		else if($("#act").val()=='')
		{
			$("#act").focus();
			alert('กรุณาเลือก พ.ร.บ.');
			return false;
		}
		else if($("#bill_pay").val()=='')
		{
			$("#bill_pay").focus();
			alert('กรุณาเลือก ประเภทการชำระ');
			return false;
		}
		else if($("#bill_pay").val()!='1' && $("#pay_amount").val()=='')
		{
			$("#pay_amount").focus();
			alert('กรุณาเลือก งวดการชำระ');
			return false;
		}
		else if($("#head_follow").val()=='')
		{
			$("#head_follow").focus();
			alert('กรุณาเลือก ประเภทการติดตามงาน');
			return false;
		}
		else if($("#car_regis_select").val()=='N')
		{
			$("#car_regis_select").focus();
			alert('กรุณาเลือกทะเบียนรถ');
			return false;
		}
		else if($("#car_regis_select").val()=='F' && $("#renew_car_regis").val()=='')
		{
			$("#renew_car_regis").focus();
			alert('กรุณากรอกทะเบียนรถ');
			return false;
		}
		else if($("#service").val()=='')
		{
			$("#service").focus();
			alert('กรุณาเลือกประเภทการซ่อม');
			return false;
		}
		else
		{
			var DATA = $('#formInsertrenew').serialize();
			var options = 
			{
				type: "POST",
				dataType: "json",
				async: false,
				url: "ajax/ajax_Alert.php?",
				data: DATA,
				success: function(msg) 
				{
					var returnedArray = msg;
					if(returnedArray.status==true)
					{
						alert(returnedArray.msg);
						
						var mb = $('#modal .modal-body');
						mb.html('Load Data...');
						mb.load('http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']  ?>',function()
						{
							$('a[href="#tab1"]').simulateClick('click');
							var d = $('#modal .modal-body');
							d.animate({ scrollTop: d.prop('scrollHeight') }, 1000);
						});
					}
					else
					{
						alert(returnedArray.msg);
					}
				}
			};
			$.ajax(options);
			return false;
		}
		
	});
	
	$(".success_update").click(function()
	{
		var _id = $(this).attr("data-id");
		//console.log(_id);
		
		var options = 
		{
			type: "POST",
			dataType: "json",
			async: false,
			url: "ajax/ajax_UpdateE.php?",
			data: {
					data_id:_id
			 },
			success: function(msg) 
			{
				var returnedArray = msg;
				if(returnedArray.status==true)
				{
					alert(returnedArray.msg);
					
					var mb = $('#modal .modal-body');
					mb.html('Load Data...');
					mb.load('http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']  ?>',function()
					{
						$('a[href="#tab1"]').simulateClick('click');
						var d = $('#modal .modal-body');
						d.animate({ scrollTop: d.prop('scrollHeight') }, 1000);
					});
				}
				else
				{
					alert(returnedArray.msg);
				}
			}
		};
		$.ajax(options);
		return false;
	});
/// close save-------------/////////////////////////////////////////////	
  /*
  var str = <?=$Cost_NEW?>;
  var COSTFIX = parseInt(str);
  var oldCost = <?=$CalculaCost?>;
  var fixCost = <?=intval(($CalculaCost-$Cost_NEW)/10000)?>;
  
  for(ss=3;ss>0;ss--)
  {
	  if(ss == 3)
	  {
	  	$("#tun").append("<option value='"+parseInt(COSTFIX)+"'>"+addCommas(parseInt(COSTFIX))+"</option>");
	  }
	  else
	  {
	  	$("#tun").append("<option value='"+parseInt(COSTFIX-(10000*ss))+"'>"+addCommas(parseInt(COSTFIX-(10000*ss)))+"</option>");
	  }
  }
	*/
  $('#dis_count_add').val(addCommas(parseFloat(<?=$row_URenew['renew_discount_amt']?>).toFixed(2)));
  $('#dis_sv').val(addCommas(parseFloat(<?=$row_URenew['renew_Service_change']?>).toFixed(2)));
  $('#title').val('<?=$row['title']?>');
  $('#title').change();
  
  $('#service').val('<?=$row_URenew['renew_service']?>');
  $('#service').change();
  
  $('#tun').val('<?=$row_URenew['renew_cost']?>');
  $('#tun').change();
  
  $('#act').val('<?=$row_URenew['renew_act']?>');
  $('#act').change();
  
  $('#bill_pay').val('<?=$row_URenew['renew_pay_type']?>');
  $('#bill_pay').change();
  
  $('#pay_amount').val('<?=$row_URenew['renew_pay_amount']?>');
  $('#pay_amount').change();
  
  //$('#text_pay').empty();
  $('#text_pay').html('<?=$row_URenew['renew_text_pay']?>');
  $('#text_pay').change();
  
  $('#renew_car_regis').html('<?=$row['car_regis']?>');
  if($("#renew_car_regis").val() == 'ป้ายแดง')
  {
	  $('#car_regis_select').val('N');
  	  $('#car_regis_select').change();
  }
  else if($("#renew_car_regis").val() != '')
  {
  	  if($("#renew_car_regis").val() == 'ป้ายแดง')
  	  {
  	  	$('#renew_car_regis').html('');
  	  }
  	  else
  	  {
  	  	$('#renew_car_regis').html('<?=$row['car_regis']?>');
  	  }

	  $('#car_regis_select').val('F');
  	  $('#car_regis_select').change();
	  $('#renew_car_regis_recheck').show();
  }
  
  //$('#dis_count_add').maskMoney({allowZero:true});

  $('#province').change();
  $('#amphur').val('<?=$row['amphur'];?>');
  $('#amphur').change();
  $('#tumbon').val('<?=$row['tumbon'];?>');
  $('#tumbon').change();

function cancel_payinstallment(prmIdData,prmIdDetail)
{
	$.ajax({
		type:'post',
		url:'ajax/ajax_check_paymentinstallment.php',
		async: false,
		data: {
			'id_data':prmIdData,
			'int_ref':prmIdDetail,
			'update': true
		},
		dataType:'json',
		success: function(res)
		{
			_res = res.status;
			
			alert('กรุณารอสักครุ่ ระบบกำลังดำเนินการยกเลิก');
			var mb = $('#modal .modal-body');
			mb.html('Load Data...');
			mb.load('http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']  ?>',function()
			{
				$('a[href="#tab1"]').simulateClick('click');
				var d = $('#modal .modal-body');
				d.animate({ scrollTop: d.prop('scrollHeight') }, 1000);
			});
		}
	});
}
</script>

<?
mysql_close();
exit();
?>