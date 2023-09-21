<?php
include "check-ses.php"; 
// include "../inc/connectdbs.pdo.php";
header('Content-Type: text/html; charset=utf-8');
// mysql_select_db($db1,$cndb1);
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> 

	<style type="text/css">
		body {		
			font-family: "Angsana New" !important;
		}
		.textcenter {
			text-align: center;
			font-size: 25px;
		}	
		.date_P1 {
			text-align: right;
			font-size: 21px;
		}
		.head_P1 {
			text-align: left;
			font-size: 21px;
		}
		.powero_1 {
			margin-bottom:0;
			font-size: 21px;
			text-indent: 3.5em !important;	
			line-height: 25px !important;		
		}
		.sign {
			font-size: 21px !important;
			line-height: 25px !important;
		}
		.description_1 {
			font-size: 21px !important;
			line-height: 25px !important;	
		}
		
	</style>
	<?php
	header("Content-type: application/vnd.ms-word");
	header("Content-Disposition: attachment;Filename=Powerofattorney.doc");

	?>
	<title>Page Title</title>
</head>
<body>
	<div class="body">
		<div class="panel panel-default">
			<!-- <div class="panel-heading">
				<h3 class="panel-title">เอกสารแบบแบบฟอร์ม</h3>
			</div> -->
			<div class="panel-body">
				<center>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="width: 60%">						
						<div class="panel panel-default">
							<!-- <div class="panel-heading" role="tab" id="headingTwo">
								<h4 class="panel-title">
									<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										หนังสือมอบอำนาจ
									</a>
									<a href="#">
										<span style="float: right; color: green; cursor: pointer;" alt="ดาวน์โหลดเอกสาร" title="ดาวน์โหลดเอกสาร">
											<i class="icon-download-alt fa-lg"> Download...</i>
										</span>
									</a>
								</h4>
							</div> -->
							<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body">
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr>
											<td height="0" colspan="2" class="textcenter">
												<strong>หนังสือมอบอำนาจ</strong>
											</td>
										</tr>
										<tr>
											<td colspan="2" style="line-height: 50px;">&nbsp;</td>									
										</tr>
										<tr>
											<td width="15%">&nbsp;</td>
											<td width="85%" class="date_P1">วันที่..............................................</td>
										</tr>
										<tr>
											<td colspan="2" style="line-height: 45px;">&nbsp;</td>									
										</tr>
										<tr>
											<td colspan="2" class="powero_1">
												โดยหนังสือฉบับนี้ ข้าพเจ้า........................................................................................................................ 
										</tr>
										<tr>
											<td colspan="2" class="description_1">
												โดย..............................................................................ตำแหน่ง................................................................................
											</td>
										</tr>
										<tr>
											<td colspan="2" class="description_1">สำนักงานตั้งอยู่เลขที่.................................................................................................................................................  </td>
										</tr>
										 <tr>
											<td colspan="2" class="description_1">ขอมอบอำนาจให้..........................................................เลขประจำตัวประชาชน.......................................................</td>
										</tr>
										<tr>
											<td colspan="2" class="description_1">อยู่บ้านเลขที่..............................................................................................................................................................</td>
										</tr>
										<tr>
											<td colspan="2" class="description_1">เป็นผู้รับมอบอำนาจที่จะกระทำการแทน  เฉพาะในกิจการตามที่จะกล่าวต่อไปนี้  คือ ..............................................</td>
										</tr>
										<tr>
											<td colspan="2" class="description_1">...................................................................................................................................................................................</td>
										</tr>
										<tr>
											<td colspan="2" class="powero_1">ข้าพเจ้าขอรับรองว่าเป็นลายมือชื่อของผู้มอบอำนาจจริง   และการที่ผู้รับมอบอำนาจได้กระทำไปภายในขอบอำนาจดังระบุในหนังสือนี้ถือเสมือนหนึ่งว่าได้กระทำโดยข้าพเจ้าเอง  เพื่อเป็นหลักฐานจึงได้ลงลายมือชื่อไว้เป็นสำคัญต่อหน้าพยาน</td>
										</tr>
										<tr>
											<td colspan="2" style="line-height: 50px;">&nbsp;</td>										
										</tr>
										<tr>
											<td width="56%">&nbsp;</td>
											<td width="44%">
												<div align="left" class="sign">														
													ลงชื่อ................................................ผู้มอบอำนาจ
												</div>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td>
												<div align="left" class="sign" style="margin-left: 31px;">(...............................................)</div>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td>
												<div align="left" class="sign">														
													ลงชื่อ................................................ผู้มอบอำนาจ
												</div>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td>
												<div align="left" class="sign" style="margin-left: 31px;">(...............................................)</div>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td>
												<div align="left" class="sign">														
													ลงชื่อ................................................พยาน
												</div>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td>
												<div align="left" class="sign" style="margin-left: 31px;">(...............................................)</div>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td>
												<div align="left" class="sign">														
													ลงชื่อ................................................พยาน
												</div>
											</td>
										</tr>
										<tr>
											<td>&nbsp;</td>
											<td>
												<div align="left" class="sign" style="margin-left: 31px;">(...............................................)</div>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>					
					</div>
				</div>
			</center>
		</div>
	</div>


</body>
</html>