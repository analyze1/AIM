<? 
include "../inc/connectdbs.pdo.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="VIBM.ico" />
<link rel="stylesheet" type="text/css" href="css/pro_dropdown_2.css" />
<title>แบบฟอร์มประกันภัยออนไลน์ MY4IB.COM</title>
<link href="css/suzuki.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {
	font-size: 14px;
	font-weight: bold;
	color: #FFFF00;
}
.style2 {font-weight: bold}
.style3 {font-size: 13px}
.style4 {color: #FFFFFF}
body {
	margin-top: 0px;
}
-->
</style>
<script type="text/javascript">
<!--

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".open('"+selObj.options[selObj.selectedIndex].value+"','blank')");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body>
<div id="head-main-top">
<div id="head-top">
<br />
<img src="i/VIBM.gif" width="400" height="79" /></div>
<div id="head-top-r">
  <div align="right"><img src="images/hotline.jpg" width="400" height="150" /></div>
</div>
</div>

<div><table width="101%" height="380" border="0" cellspacing="0" cellpadding="0">
<tr>
      <td width="53%" height="40" align="center">
      <form name="form" target="_blank" id="form">
      	<span class="style13">ศูนย์ซ่อมมาตรฐานจาก วิริยะประกันภัย : </span>
        <select name="jumpMenu" id="jumpMenu" onchange="MM_jumpMenu('window',this,1)">
          <option value="#" selected="selected">:: เลือกพื้นที่ ::</option>
          <option value="http://www.viriyah.co.th/th/contact-center-service-search2.php?type=garage&part=1&province=&keyword=#.Ul9XX1Pud1p">กรุงเทพฯและปริมณฑล</option>
          <option value="http://www.viriyah.co.th/th/contact-center-service-search2.php?type=garage&part=5&province=&keyword=#.Ul9X2lPud1o">ภาคเหนือ</option>
          <option value="http://www.viriyah.co.th/th/contact-center-service-search2.php?type=garage&part=4&province=&keyword=#.Ul9XwlPud1o">ภาคตะวันออกเฉียงเหนือ </option>
          <option value="http://www.viriyah.co.th/th/contact-center-service-search2.php?type=garage&part=3&province=&keyword=#.Ul9XslPud1o">ภาคตะวันออก</option>
          <option value="http://www.viriyah.co.th/th/contact-center-service-search2.php?type=garage&part=2&province=&keyword=#.Ul9XnlPud1o">ภาคกลางและภาคตะวันตก</option>
          <option value="http://www.viriyah.co.th/th/contact-center-service-search2.php?type=garage&part=6&province=&keyword=#.Ul9X7VPud1o">ภาคใต้</option>
         </select>
       </form>
      </td>
  <td width="47%" rowspan="3" align="center">
  <a target="_blank" href="http://www.fourinsured.com/component/content/article/65-%E0%B9%80%E0%B8%81%E0%B8%A3%E0%B9%87%E0%B8%94%E0%B8%84%E0%B8%A7%E0%B8%B2%E0%B8%A1%E0%B8%A3%E0%B8%B9%E0%B9%89%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B8%81%E0%B8%B1%E0%B8%99%E0%B8%A0%E0%B8%B1%E0%B8%A2/112-%E0%B9%81%E0%B8%88%E0%B9%89%E0%B8%87%E0%B8%9B%E0%B8%A3%E0%B8%B0%E0%B8%81%E0%B8%B1%E0%B8%99%E0%B8%A0%E0%B8%B1%E0%B8%A2%E0%B8%AD%E0%B8%AD%E0%B8%99%E0%B9%84%E0%B8%A5%E0%B8%99%E0%B9%8C-24-%E0%B8%8A%E0%B8%A1-%E0%B8%94%E0%B8%B5%E0%B8%AD%E0%B8%A2%E0%B9%88%E0%B8%B2%E0%B8%87%E0%B9%84%E0%B8%A3.html
"><img src="images/24hr.png" align="bottom"></a>
  <form name="form1" method="post" action="ChkLog.php">
    <table width="322" height="185" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
	        <tr>
	          <td width="37">&nbsp;</td>
		      <td width="266"><img src="images/login.png" width="266" height="50" align="bottom"></td>
		      <td width="19">&nbsp;</td>
		    </tr>
	        <tr>
	          <td>&nbsp;</td>
		      <td bgcolor="#507cd1">
		        <table width="232" border="0" align="center" cellpadding="2" cellspacing="0">
		          <tr>
		            <td colspan="3"><div align="center"><span class="style14 style1">Administrator</span></div></td>
			      </tr>
		          <tr>
		            <td colspan="3"><hr align="center" class="style1"></td>
			      </tr>
		          <tr>
		            <td width="85"><div align="right" class="style3 style10 style4"><strong><span class="style7">username :</span> </strong></div></td>
				    <td width="13"><span class="style2"></span></td>
				    <td width="134"><input style="width:90px;" name="f_user" type="text" id="f_user"  maxlength="15"></td>
			      </tr>
		          <tr>
		            <td><div align="right" class="style3 style10 style4"><strong><span class="style7">password :</span>   </strong></div></td>
				    <td><span class="style2"></span></td>
				    <td width="134">
				      <input style="width:90px;" name="f_pass" type="password" id="f_pass" maxlength="15" />
				    </td>
			      </tr>
		          <tr>
		            <td colspan="3"><div align="center"><span class="style2"></span><span class="style2"></span><span class="style2">
		              <input name="Submit" type="submit"  value="Submit">
		              &nbsp;&nbsp;
		              <input type="reset" name="Submit2" value="Reset">
	                </span></div></td>
	              </tr>
		          <tr>
		            <td align="right" colspan="3" style="font-size:12px;"><a style="color:#FFFFFF;" href="javascript:void(0)" onclick="window.open('forgetPassword.php','forget','menubar=no,status=no,scrollbars=no,width=570,height=350')">ลืมรหัสผ่าน</a></td>
			      </tr>
	            </table>
		      <div align="center"></div></td>
		      <td>&nbsp;</td>
		    </tr>
	        <tr>
	          <td>&nbsp;</td>
		      <td><img src="images/loginbuttom.png" width="266" height="25"></td>
		      <td>&nbsp;</td>
		    </tr>
          </table>
		</form>
    
    </td>
  </tr>
  <tr>
  <td height="50"><div align="right">
  		<object width="620" height="467"> 
    		<param name="movie" value="images/suzuki.swf"> 
    		<embed src="images/suzuki.swf" width="620" height="467"> </embed> 
    	</object>
	</div></td>
  </tr>
    <tr>
      <td></td>
  </tr>
    <tr>
      <td>&nbsp;</td>
      <td></td>
    </tr>
</table></div>
<? mysql_close; ?>
</body>
</html>