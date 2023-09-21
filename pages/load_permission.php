<?php
	include "check-ses.php"; 
	include "../../inc/connectdbs.pdo.php";
	$getPage = $_GET['page'];
?>
 
<script language="javascript">

	$('#pageSearch').hide('Slow');

	 $('#page-content').css({
    'background-color':'#efedef'
  });
</script>

<style type="text/css">
	.style5 
	{
		color: #000000; 
		font-size: 11px; 
		font-weight: bold; 
	}
	.style6
	{
		font-size: 10pt;
		font-family: Tahoma;
	}
	.style12
	{
		color: #000000;
		font-size: 10pt; 
		font-weight: bold; 
		font-family: Tahoma;
	}
</style>

<?php
	$sql = "SELECT Email4 FROM tb_customer WHERE user='".$_SESSION["strUser"]."'";
	$objQuery = mysql_query($sql) or die ("Error Query [".$sql."]");
	$row = mysql_fetch_array($objQuery);
?>
<div class="row-fluid">
	<div class="span12">
		<div class="widget-box">
            <div class="widget-header widget-header-flat"> <h4>ขอสิทธิ์การใช้งาน</h4></div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row-fluid">
                            <div class="span12">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
	<tr>
		<td width="100%" valign="top"></td>
	</tr>
	<tr>
		<td valign="top">
		<div id="posFinish">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#999999">
			<tr>
				<td>
					<br>
					<form method="POST" name="Form_act" id="Form_act">
					<table width="100%" border="0" align="center" cellpadding="5" cellspacing="5">
						<tr>
							<td width="247" height="30"><div align="right" class="style5 style6">วันที่ส่งคำขอ&nbsp;&nbsp;:&nbsp;</div></td>
							<td width="327" height="30"><input name="send_date" type="text" id="send_date" size="40" maxlength="10" readonly="true" value="<?php print date("d/m/Y H:i:s"); ?>" /></td>
						</tr>
						<tr>
							<td height="30"><div align="right" class="style12">รหัสผู้แจ้งงาน&nbsp;&nbsp;:&nbsp; </div></td>
							<td height="30"><input name="xuser" type="text" id="xuser" size="40" maxlength="40" readonly="true" value="<?=$_SESSION["strUser"]?>" /></td>
						</tr>
						<tr>
							<td height="30"><div align="right" class="style12">สาขาแจ้งงาน&nbsp;&nbsp;:&nbsp; </div></td>
	                        <td height="30">
	                        	<?
	                        		if($_SESSION["strUser"] == "admin")
									{
	                        	?>
	                        			<select name="Dxuser" id="Dxuser" style="width:auto;">
	                        			<option value="0" selected="selected">กรุณาเลือกชื่อผู้แจ้ง</option>
									<?
	                                    $query_D ="SELECT * FROM `tb_customer` WHERE `nameuser` = 'Mitsubishi' ORDER BY `tb_customer`.`user` ASC"; // id = '1' 
	                                    $objQueryD = mysql_query($query_D) or die ("Error Query [".$query_D."]");
	                                    while($objResultD = mysql_fetch_array($objQueryD))
	                                    {
	                                        echo '<option value="'.$objResultD['user'].'">'.'['.$objResultD['user'].'] '.$objResultD['sub'].'</option>';
	                                    }
	                                ?>
										</select>
								<?
	                            	}
									else
									{
								?>
										<input name="name_inform" type="text" id="name_inform" readonly="true" size="40" maxlength="40" value="<?=$_SESSION["strName"];?>" />
								<? 
									}
								?>
							</td>
						</tr>
						<tr>
	                        <td height="30"><div align="right" class="style12">ผู้ติดต่อ&nbsp;&nbsp;:&nbsp; </div></td>
	                        <td height="30"><input name="contact" type="text" id="contact" size="40" maxlength="40" /></td>
	                    </tr>
	                    <tr>
	                        <td height="30"><div align="right" class="style12">เบอร์ติดต่อ&nbsp;&nbsp;:&nbsp; </div></td>
	                        <td height="30"><input name="tel_contact" type="text" id="tel_contact" size="40" maxlength="40"/></td>
	                    </tr>
	                    <tr>
	                    	<td height="30">
	                    		<div align="right" class="style12">เมนูขอใช้งาน&nbsp;&nbsp;:&nbsp; </div>
	                    	</td>
	                    	<td height="30">
	                    		<input name="email_re" type="hidden" id="email_re" size="40" value="<?=$row['Email4']?>"/>
	                    		<input type="checkbox" <?php if($getPage=='r'){ echo ' checked '; } ?> name="mrenew" id="mrenew" value="R"> เมนูแจ้งต่ออายุ Mitsubishi (ปี 2) &nbsp;&nbsp;:&nbsp; 
	                    		<input type="checkbox" <?php if($getPage=='n'){ echo ' checked '; } ?> name="mnew" id="mnew" value="N"> เมนูแจ้งประกันใหม่
	                    	</td>
	                    </tr>
	                    <tr>
	                        <td colspan="2"><div align="center"><button class="btn btn-primary  btn-large" id="sendR" name="sendR" style="width:200px;"><i class="icon-white icon-file"></i> ส่งคำขอ</button></div>
	                        </td>
	                    </tr>
	                 </table>
	                 <br>
					<img id="imgAvatar">
				</form>
				</td>
				</tr>
			</table>
		</div>
		</td>
	</tr>
</table>
</div></div></div></div></div></div></div>
<script>
	$("#sendR").click(function() {
		if($("#mrenew option:cehcked").val() == "" && $("#mnew option:cehcked").val() == "")
		{
			alert('กรุณาเลือกเมนูที่ต้องการขอสิทธิ์');
			$("#mrenew").focus();
			return false;
		}
		else if($("#contact").val() == "")
		{
			alert('กรุณากรอกชื่อผู้ติดต่อ');
			$("#contact").focus();
			return false;
		}	
		else if($("#tel_contact").val() == "")
		{
			alert('กรุณากรอกเบอร์โทรศัพท์ผู้ติดต่อ');
			$("#tel_contact").focus();
			return false;
		}
		else
		{
		
		var DATA = $('#Form_act').serialize();
		var options = 
		{
			type: "POST",
			dataType: "json",
			async: false,
			url: "ajax/ajax_permission.php?",
			data: DATA,
			success: function(msg) 
			{
				var returnedArray = msg;
				if(returnedArray.status==true)
				{
					alert(returnedArray.msg);
					$('#posFinish').html("<div style='text-align:center;margin:10px;color:#2283c5;'><h3>ผลการขอสิทธิ์การเข้าใช้งาน</h3><p>ทางเราได้ทำการเพิ่มสิทธิ์ให้ท่านเรียบร้อยแล้ว</p><p>กรุณา <a href='' onclick=\"load_page('pages/load_logout.php');\">ออกจากระบบ </a> และเข้าสู่ระบบใหม่อีกครั้ง</p></div>");
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


	 
</script>