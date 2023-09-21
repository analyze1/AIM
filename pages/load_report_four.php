<?php
include "check-ses.php";
include "../inc/connectdbs.pdo.php";
echo "<script> var _checkDealerCode = `{$_SESSION['strUser']}`</script>";
?>
<style>
	.di_pad {
		width: 100%;
		padding: 5px;
	}

	.re_ti {
		display: inline-block;
		width: 115px;
	}

	.re_ti-2 {
		display: inline-block;
		width: 115px;
	}

	.re_in {
		display: inline-block;
		width: 200px;
	}

	.re_in_large {
		display: inline-block;
		width: 650px;
	}

	.re_in_small {
		display: inline-block;
		width: 50px;

	}

	.area1 {
		display: inline-block;
		width: 800px;
	}

	.area2 {
		display: inline-block;
		width: 370px;
	}

	.area3 {
		display: inline-block;
		width: 680px;
	}
</style>
<!-- <script type="text/javascript" src="js/jquery-1.8.3.js"></script> -->
<!-- <script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script> -->
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />
<div class="container-fluid outer">
	<div class="row-fluid">
		<div class="span12 inner">
			<div class="row-fluid">
				<div class="span12">
					<div class="box">
						<header>
							<h5>รายงานยอดขาย/ค้างชำระ</h5>
						</header>


						<div id="collapse4" class="body">

							<form name='data_report' id='data_report' action='report/report_inform_four_pdf.php' onsubmit='return save_report();' target="_blank" method="POST">
								
							<div class='di_pad' id = 'divDealerCode'>
										<div class='re_ti'>
											รหัสตัวแทน :
										</div>
										<div class='re_in_large'>
												<?php
												$edit_nameuser = "";
												$edit_user = substr($_SESSION['strUser'],1,5);
												$edit_nameuser = 'M' . $edit_user;
												if ($_SESSION['claim'] != 'ADMIN' && $_SESSION['strUser'] != 'admin') {
													$id_agent_sql = "AND DealerID = '{$_SESSION['strUser']}'";
												} else {
													$id_agent_sql = "";
												}
												$sql = "SELECT * FROM partner_code_center WHERE Type = 'Mitsubishi'" . $id_agent_sql . " ORDER BY DealerCode ASC";
												if ($_SESSION['claim'] != 'ADMIN' && $_SESSION['strUser'] != 'admin') {
													$fetcharr = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetch(5);
													echo "<input name='idagent' list='idagent' placeholder='เลือก ดีลเลอร์' value='{$fetcharr->DealerCode}'  class='span6' />
													<datalist id='idagent'>";
													echo "<option  value= '" . $fetcharr->DealerCode . "' >" . $fetcharr->Name . "</option>";
													$comittion_a = $fetcharr->AgentDis;
													echo "</datalist>";
												} else {
													$result = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetchAll(5);
													$comittion_a = '0';
													echo "<div class='alert alert-info'>
													<strong>คำแนะนำ !</strong> เมื่อต้องการค้นหาดีลเลอร์อื่นๆ กรุณณาลบคำว่า ALL แล้วคลิกเพื่อเลือกรหัสดีลเลอร์
													</div>";
													echo "<input name='idagent' list='idagent' placeholder='เลือก ดีลเลอร์' value='ALL'  class='span6' />
													<datalist id='idagent'>";
													echo "<option  value= 'ALL' >ทั้งหมด</option>";
													foreach ($result as $x) {
														echo "<option value='$x->DealerCode' ";
														echo " >[$x->DealerID] $x->Name</option>";
													}
													echo "</datalist>";
												}
												?>
										</div>
								</div>
								<div class='di_pad'>
									<div class='area2' style='display:none;'>
										<div class='re_ti'>
											การค้นหา :
										</div>

										<div class='re_in'>
											<select name='data_type' class='span10'>
												<option value='ALL'>ทั้งหมด</option>
												<option value='2'>คงค้าง</option>
												<option value='3'>ยอดเกิน</option>
											</select>
										</div>
									</div>
									<div class='area3'>
										<div class='re_ti-2'>
											วันคุ้มครอง :
										</div>
										<div class='re_in'>
											<input type='date' name='start_date' id='start_date' class='span10' autocomplete="off">
										</div>
										<div class='re_in_small'>
											ถึง
										</div>
										<div class='re_in'>
											<input type='date' name='end_date' id='end_date' class='span10' autocomplete="off">
										</div>
									</div>
								</div>
								<div class='di_pad'>
									<button type="submit" class="btn btn-primary "><i class="icon-download-alt icon-white"></i> Download to PDF</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	if(_checkDealerCode !== 'admin'){
		$('#divDealerCode').hide();
	}
	// $("#start_date").datepicker({
	// 	format: 'yyyy-mm-dd'
	// });
	// $("#end_date").datepicker({
	// 	format: 'yyyy-mm-dd'
	// });

	const elementStartDate = document.querySelector('#start_date');

	elementStartDate.addEventListener('change', (event) => {
		const elementEndDate = document.querySelector('#end_date');
		elementEndDate.value = '';
		elementEndDate.min = `${event.target.value}`;
		console.log('elementStartDate',`${event.target.value}`);
	});

	function save_report() {
		if ($("#start_date").val() == '') {
			alert("กรุณาป้อนข้อมูลวันเริ่มแจ้ง");
			$("#start_date").focus();
			return false;
		}
		if ($("#end_date").val() == '') {
			alert("กรุณาป้อนข้อมูลวันสิ้นสุด");
			$("#end_date").focus();
			return false;
		}
	}
</script>