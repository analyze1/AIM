<? 
include "../inc/connectdbs.pdo.php"; 
include "pages/check-ses.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="4.ico" />
<link rel="stylesheet" type="text/css" href="css/pro_dropdown_2.css" />
<link rel="stylesheet" type="text/css" href="css/cupertino/jquery-ui-1.9.2.custom.min.css" />
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-th.js"></script>
<script src="js/stuHover.js" type="text/javascript"></script>
<script type="text/javascript" src="js/script.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<title>แบบฟอร์มประกันภัยออนไลน์ MY4IB.COM</title>
<link href="css/suzuki.css" rel="stylesheet" type="text/css" />
<link href="css/profile.css" rel="stylesheet" type="text/css" />

</head>
<body>
<div id="head-main">
<div id="head-logo">
<img src="i/VIBM.gif" width="400" height="79" />
<div align="right" style="float:right; margin-right:50px; margin-top:10px;">
<img height=21 src="images/digital-clock/cb.gif" width=16 name=k>
<img height=21 src="images/digital-clock/cb.gif" width=16 name=l>
<img height=21 src="images/digital-clock/csla.gif" width=16>
<img height=21 src="images/digital-clock/cb.gif" width=16 name=m>
<img height=21 src="images/digital-clock/cb.gif" width=16 name=n>
<img height=21 src="images/digital-clock/csla.gif" width=16>
<img height=21 src="images/digital-clock/cb.gif" width=16 name=o>
<img height=21 src="images/digital-clock/cb.gif" width=16 name=p>
<img height=21 src="images/digital-clock/cb.gif" width=16 name=q>
<img height=21 src="images/digital-clock/cb.gif" width=16 name=r>

<BR />
<img height=21 src="images/digital-clock/cb.gif" width=16 name=a>
<img height=21 src="images/digital-clock/cb.gif" width=16 name=b>
<img height=21 src="images/digital-clock/colon.gif" width=9 name=c>
<img height=21 src="images/digital-clock/cb.gif" width=16 name=d>
<img height=21 src="images/digital-clock/cb.gif" width=16 name=e>
<img height=21 src="images/digital-clock/colon.gif" width=9 name=f>
<img height=21 src="images/digital-clock/cb.gif" width=16 name=g>
<img height=21 src="images/digital-clock/cb.gif" width=16 name=h>
<img height=21 src="images/digital-clock/cam.gif" width=16 name=j>
</div></div>
<div id="head-r">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Username </td>
    <td>: <?=$_SESSION["strUser"]?></td>
  </tr>
  <tr>
    <td>Company </td>
    <td>: <?=$_SESSION["strName"];?></td>
  </tr>
  <tr>
  
    <td>
    <?
		$sqlpa = mysql_query("SELECT * FROM tb_inform WHERE sort='VIB_C' AND status = '1'"); //คิวรี่ คำสั่ง
		$totalpa = mysql_num_rows($sqlpa);
		$sqlsu = mysql_query("SELECT * FROM tb_inform WHERE sort='VIB_S' AND status = '1'"); //คิวรี่ คำสั่ง
		$totalsu = mysql_num_rows($sqlsu);
  	?>
    จำนวนเลขรับแจ้ง </td>
    <td>[สุขา 3 = <?=$totalsu?>]</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>[ปากเกร็ด = <?=$totalpa?>]</td>
  </tr>
</table>
</div>
</div>
<div style="display:none" id=bg-loading></div>
<div id="loading" align="center"><img style="margin-top:47px;" src="img/ajax_load.gif" alt="loading"/></div>

<div id="menu-main">
<span class="preload1"></span>
<span class="preload2"></span>
<ul id="nav">
	<li class="top"><a href="#load_AdminSuzuki" id="privacy" class="top_link"><span>ข้อมูลบริษัท</span></a></li>
	<li class="top"><a href="#load_Preview3" id="services" class="top_link"><span class="down">ตรวจสอบข้อมูล</span></a>
		<ul class="sub">
			<li><a href="#load_Preview3">วิริยะสุขา 3</a></li>
			<li><a href="#load_PreviewPakkret">วิริยะปากเกร็ด</a></li>
		</ul>
	</li>
    <li class="top"><a href="#load_Attached3" id="privacy" class="top_link"><span class="down">รายการสลักหลัง</span></a>
		<ul class="sub">
        	<li><a href="#load_Attached3">วิริยะสุขา 3</a></li>
			<li><a href="#load_AttachedPakkret">วิริยะปากเกร็ด</a></li>
		</ul>
	</li>
    <li class="top"><a href="#load_Cancel3" id="privacy" class="top_link"><span class="down">รายการยกเลิก</span></a>
		<ul class="sub">
        	<li><a href="#load_Cancel3">วิริยะสุขา 3</a></li>
			<li><a href="#load_CancelPakkret">วิริยะปากเกร็ด</a></li>
		</ul>
	</li>
    <li class="top"><a href="#load_Payment3" id="privacy" class="top_link"><span class="down">วางบิล</span></a>
		<ul class="sub">
        	<li><a href="#load_Payment3">วิริยะสุขา 3</a></li>
			<li><a href="#load_PaymentPakkret">วิริยะปากเกร็ด</a></li>
		</ul>
	</li>
    <li class="top"><a href="#load_NumInform3" id="privacy" class="top_link"><span class="down">เพิ่มเลขรับแจ้ง</span></a>
		<ul class="sub">
        	<li><a href="#load_NumInform3">วิริยะสุขา 3</a></li>
			<li><a href="#load_NumInformPakkret">วิริยะปากเกร็ด</a></li>
		</ul>
	</li>
    <li class="top"><a href="#load_NumPRB" id="privacy" class="top_link"><span class="down">สต็อก พรบ.</span></a>
		<ul class="sub">
        	<li><a href="#load_PayPRB">เบิก พรบ.</a></li>
			<li><a href="#load_NumPRB">เพิ่มเลข พรบ.</a></li>
		</ul>
	</li>
	<li class="top"><a href="#load_ReportCEO" id="privacy" class="top_link"><span>Report CEO</span></a></li>
	<li class="top"><a href="#load_logout" id="privacy" class="top_link"><span>ออกจากระบบ</span></a></li>

    
</ul>
</div> 
	
<div id="pageSearch" style="display:none;">

</div>
<div id="pageContent">

</div>

<div id="previewContent" style="display:none;">

</div>

<div id="bg-off">
</div>
</body>
</html>