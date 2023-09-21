<?php
include "check-ses.php";
include "../../inc/connectdbs.pdo.php"; 
?>
<script language="javascript">
$('#pageSearch').hide('Slow');
$("#Download").click(function() 
     { 
        $("#DLREPORT").submit();
	 });
</script>
<?
		$D = date('d');
		$M = date('m');
		$Y = date('Y');
		$LastDay = date('d', strtotime('last day'));
		$LastMonth = date('m', strtotime('last month'));
?>
<div>

<div align="center" style="width:100%;margin-top:50px;">
<form action="load/suzuki.php" target="iUpload" id="DLREPORT" method="post" name="DLREPORT">
<input name="Dsearch" type="text" id="Dsearch" size="5" maxlength="2" disabled="disabled" style="width:20px; display:none;" />
เดือน :
<select name="Msearch" id="Msearch" style="width:auto;">
      <option value="1">มกราคม</option>
      <option value="2">กุมภาพันธ์</option>
      <option value="3">มีนาคม</option>
      <option value="4">เมษายน</option>
      <option value="5">พฤษภาคม</option>
      <option value="6">มิถุนายน</option>
      <option value="7">กรกฎาคม</option>
      <option value="8">สิงหาคม</option>
      <option value="9">กันยายน</option>
      <option value="10">ตุลาคม</option>
      <option value="11">พฤศจิกายน</option>
      <option value="12">ธันวาคม</option>
  </select>
    ปี : 
  <select name="Ysearch" id="Ysearch" style="width:auto;">
  <option value="2015">2015</option>
  <option value="2014">2014</option>
  <option value="2013">2013</option>
    <option value="2012">2012</option>
    <option value="2011">2011</option>
      <option value="2010">2010</option>
    </select>&nbsp;&nbsp;&nbsp;&nbsp;
<BR /><BR />
    <div align="center"><a class="btn btn-success btn-small" id="Download" title="Download" name="Download"><i class="icon-white icon-download"></i> download</a></div>
  </form>
  <iframe name="iUpload" id="iUpload" width="0" height="0" style="display:none;"></iframe>
</div>
  <table width="605" border="0" align="center" cellpadding="0" cellspacing="1">
    
    <tr>
      <td height="20" colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td width="131" bgcolor="#000033"><div align="center">
        <div align="center"><strong><font color="#FFFFFF">รุ่นรถ</font></strong></div>
        <strong><font color="#FFFFFF"></font></strong></div></td>
      <td width="115" height="30" bgcolor="#000033"><div align="center"><strong><font color="#FFFFFF">เดือนที่แล้ว</font></strong></div></td>
      <td width="115" height="30" bgcolor="#000033"><div align="center"><strong><font color="#FFFFFF">เดือนนี้</font></strong></div></td>
      <td width="115" bgcolor="#000033"><div align="center"><strong><font color="#FFFFFF">เมื่อวาน</font></strong></div></td>
      <td width="115" height="30" bgcolor="#000033"><div align="center"><strong><font color="#FFFFFF">วันนี้</font></strong></div></td>
    </tr>
    <tr>
    	<td bgcolor="#D9ECFF" style="padding-left:5px;"><div align="left">CELERIO</div></td>
        <td height="30" bgcolor="#D9ECFF"><div align="center">
        <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '1964' AND MONTH(data.send_date) = '$LastMonth' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
       <td height="30" bgcolor="#D9ECFF">
	  	<div align="center">
	  	  <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '1964' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
	  	</div></td>
      <td bgcolor="#D9ECFF"><div align="center">
        <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '1964' AND DAY(data.send_date) = '$LastDay' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
        <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '1964' AND DAY(data.send_date) = '$D' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#D9ECFF" style="padding-left:5px;"><div align="left">Swift ECO</div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
        <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '1951' AND MONTH(data.send_date) = '$LastMonth' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td height="30" bgcolor="#D9ECFF">
	  	<div align="center">
	  	  <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '1951' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
	  	</div></td>
      <td bgcolor="#D9ECFF"><div align="center">
        <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '1951' AND DAY(data.send_date) = '$LastDay' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
        <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '1951' AND DAY(data.send_date) = '$D' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#D9ECFF" style="padding-left:5px;"><div align="left">APV</div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
          <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '747' AND MONTH(data.send_date) = '$LastMonth' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
          <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '747' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td bgcolor="#D9ECFF"><div align="center">
        <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '747' AND DAY(data.send_date) = '$LastDay' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
          <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '747' AND DAY(data.send_date) = '$D' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#D9ECFF" style="padding-left:5px;"><div align="left">SX4</div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
          <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '759' AND MONTH(data.send_date) = '$LastMonth' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
          <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '759' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td bgcolor="#D9ECFF"><div align="center">
        <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '759' AND DAY(data.send_date) = '$LastDay' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
          <?
			$d = date('d');
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '759' AND DAY(data.send_date) = '$D' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#D9ECFF" style="padding-left:5px;"><div align="left">GRAND VITARA</div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
          <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '754' AND MONTH(data.send_date) = '$LastMonth' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
          <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '754' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td bgcolor="#D9ECFF"><div align="center">
        <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '754' AND DAY(data.send_date) = '$LastDay' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
          <?
			$d = date('d');
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '754' AND DAY(data.send_date) = '$D' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#D9ECFF" style="padding-left:5px;"><div align="left">Carry</div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
          <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '1098' AND MONTH(data.send_date) = '$LastMonth' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
          <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '1098' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td bgcolor="#D9ECFF"><div align="center">
        <?
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '1098' AND DAY(data.send_date) = '$LastDay' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
      <td height="30" bgcolor="#D9ECFF"><div align="center">
          <?
			$d = date('d');
			$sql_count = mysql_query("SELECT COUNT(data.send_date) FROM data 
			INNER JOIN req ON (data.id_data = req.id_data) 
			INNER JOIN detail ON (data.id_data = detail.id_data) 
			WHERE data.login ='".$_SESSION["strUser"]."' AND req.EditCancel != 'Y' AND detail.mo_car = '1098' AND DAY(data.send_date) = '$D' AND MONTH(data.send_date) = '$M' AND YEAR(data.send_date) = '$Y'");
			$res = mysql_fetch_array($sql_count);
			$records = $res[0];
			echo $records;
		?>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#D9ECFF" style="padding-left:5px;">&nbsp;</td>
      <td height="40" bgcolor="#D9ECFF"><div align="center"><a href="pages/RP_Lastmonth.php" target="_blank" class="btn btn-success btn-small"><i class="icon-white icon-download"></i> download</a></div></td>
      <td height="40" bgcolor="#D9ECFF"><div align="center"><a href="pages/RP_month.php" target="_blank"  class="btn btn-success btn-small"><i class="icon-white icon-download"></i> download</a></div>
      <td height="40" bgcolor="#D9ECFF"><div align="center"><a href="pages/RP_Lastday.php" target="_blank"  class="btn btn-success btn-small"><i class="icon-white icon-download"></i> download</a></div>
      <td height="40" bgcolor="#D9ECFF"><div align="center"><a href="pages/RP_day.php" target="_blank"  class="btn btn-success btn-small"><i class="icon-white icon-download"></i> download</a></div>
    </tr>
  </table>
  <?
mysql_close();
exit(); 
?>
</div>
