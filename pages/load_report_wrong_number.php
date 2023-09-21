<?php
include "check-ses.php";
include "../inc/connectdbs.pdo.php";
echo "<script>
var _checkDealerCode = `{$_SESSION['strUser']}`;
var _dealerCodeShow = `{$_SESSION['strUser']}`;
var _dealerNameShow = `{$_SESSION['strName']}`;
</script>";
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
		width: 600px;
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

	.d-none {
		display: none;
	}

	.form-check-inline {
		display: -webkit-inline-box;
		display: -ms-inline-flexbox;
		display: inline-flex;
		-webkit-box-align: center;
		-ms-flex-align: center;
		align-items: center;
		padding-left: 0;
		margin-right: 0.75rem;
	}

	.form-check {
		position: relative;
		display: inline-flex;
		/* padding-left: 1.25rem; */
	}

	.form-check-inline .form-check-input {
		position: static;
		margin-top: 0;
		margin-right: 0.3125rem;
		margin-left: 0;
	}

	.form-check-label {
		margin-bottom: 0;
	}
</style>
<!-- <script type="text/javascript" src="js/jquery-1.8.3.js"></script> -->
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />
<div class="container-fluid outer">
	<div class="row-fluid">
		<div class="span12 inner">
			<div class="row-fluid">
				<div class="span12">
					<div class="box">
						<header>
							<h5>รายงานเบอร์ลูกค้าผิด</h5>
						</header>

						<div id="collapse4" class="body">
							<form name='data_report_wrong_number' id='data_report_wrong_number' target="_blank" method="POST">
								<div class='di_pad'>
									<div class='area1' id='divDealerCode'>
									</div>
								</div>
								<div class='di_pad'>
									<div class='area1'>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="typeOptions" id="typeRadio1" value="option1" onclick="checkOption();" checked>
											<label class="form-check-label" for="typeRadio1">วันที่บันทึกเบอร์ผิด</label>
										</div>
										<!-- <div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="typeOptions" id="typeRadio2" value="option2" onchange="checkOption();">
											<label class="form-check-label" for="inlineRadio2">เดือน/ปี หมดอายุ</label>
										</div> -->
									</div>
								</div>
								<div class='di_pad' id="option1">
									<div class='area3'>
										<div class='re_ti-2'>
											วันที่เริ่มบันทึก
										</div>
										<div style='display: inline-block;'>
											<input type='date' name='start_date' id='start_date' class='form-control' autocomplete="off">
										</div>
										<div style='display: inline-block;'>
											ถึง
										</div>
										<div style='display: inline-block;'>
											<input type='date' name='end_date' id='end_date' class='form-control' autocomplete="off">
										</div>
									</div>
								</div>
								<div class='di_pad' id="option2" style="display: none;">
									<div class='area3'>
										<div class='re_ti-2'>
											เดือน/ปี หมดอายุ
										</div>
										<div class='re_in'>
											<select name="genMonth" id="genMonth"></select>
										</div>
										<div class='re_in_small'>

										</div>
										<div class='re_in'>
											<select name="genYear" id="genYear"></select>
										</div>
									</div>
								</div>
								<div class='di_pad'>
									<div class="area3">
										<button type="submit" onclick="return downloadPDF();" class="btn btn-primary "><i class="icon-download-alt icon-white"></i> Download to PDF</button>
										<?php if ($_SESSION["strUser"] == 'admin') { ?>
											<button type="submit" onclick="return downloadEXCEL();" class="btn btn-success "><i class="icon-download-alt icon-white"></i> Download to EXCEL</button>
										<?php } ?>
									</div>
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
	async function getDealers() {
		let getInfos = await $.ajax({
			type: "POST",
			dataType: "json",
			url: "services/ReportRenew/report-renew.controller.php",
			data: {
				Controller: 'getDealerAll',
			},
			success: (x) => {
				return x;
			},
			error: (e) => {
				console.log(e);
				return false;
			}
		});

		return getInfos;
	}

	async function checkDeadline() {

		if (_checkDealerCode != 'admin') {
			$('#divDealerCode').append(`
				<div class='re_ti' >
					รหัสตัวแทน :
				</div>
				<div class='re_in_large' style='width:72.5%' >
					<select name='dealerCode' id='dealerCode' class='span10' readonly>
					<option value="${_dealerCodeShow}">[${_dealerCodeShow}] ${_dealerNameShow}</option>										
					</select>
				</div>`);
			$('#divDealerCode').hide();
		} else {
			let getDealerAllS = await getDealers();
			if (getDealerAllS.Status == 200) {
				$('#divDealerCode').append(`
					<div class="alert alert-info"><strong>คำแนะนำ !</strong> เมื่อต้องการค้นหาดีลเลอร์อื่นๆ กรุณณาลบคำว่า ALL แล้วคลิกเพื่อเลือกรหัสดีลเลอร์</div>
					<div class='re_ti' >
						รหัสตัวแทน :
					</div>
					<div class='re_in_large' style='width:72.5%'>
						<input name="dealerCode" list="dealerCode" placeholder="เลือก ดีลเลอร์" value="ALL" class="span6">
						<datalist id="dealerCode"><option value="ALL">[ALL] ทั้งหมด</option></datalist>
					</div>`);
				for (let i of getDealerAllS.Data) {
					$('#dealerCode').append(`<option value="${i.userCode}">[${i.userCode}] ${i.nameFull}</option>`);
				}
			}
		}
	}

	checkDeadline();

	function genSelectMonthTH(id) {
		switch (id) {
			case 1:
				str = "มกราคม";
				break;
			case 2:
				str = "กุมภาพันธ์";
				break;
			case 3:
				str = "มีนาคม";
				break;
			case 4:
				str = "เมษายน";
				break;
			case 5:
				str = "พฤษภาคม";
				break;
			case 6:
				str = "มิถุนายน";
				break;
			case 7:
				str = "กรกฎาคม";
				break;
			case 8:
				str = "สิงหาคม";
				break;
			case 9:
				str = "กันยายน";
				break;
			case 10:
				str = "ตุลาคม";
				break;
			case 11:
				str = "พฤษจิกายน";
				break;
			case 12:
				str = "ธันวาคม";
				break;
		}
		return str;
	}

	// genSelectMonth();
	// function genSelectMonth() {
	// 	let div = $('#genMonth').empty();
	// 	for (let index = 1; index < 13; index++) {
	// 		div.append(`<option value="${index}">${genSelectMonthTH(index)}</option>`);
	// 	}
	// 	let dd = new Date();
	// 	let mm = dd.getUTCMonth();
	// 	$('#genMonth').val(mm + 1);
	// }
	// genSelectYear();
	// async function genSelectYear() {
	// 	let req = {
	// 		type: "POST",
	// 		dataType: "json",
	// 		url: "services/ReportRenew/report-renew.controller.php",
	// 		data: {
	// 			Controller: 'genYearByEnddate',
	// 			dealerCode: _checkDealerCode

	// 		},
	// 		success: function(x) {
	// 			return x;
	// 		},
	// 		error: function(e) {
	// 			console.log(e);
	// 			return false;
	// 		}
	// 	};

	// 	let res = await $.ajax(req);

	// 	if (res.Status !== 200) {
	// 		$('#chartdiv4').empty();
	// 		$('#chartdiv4').html(`
	// 			<div class="d-flex align-items-center justify-content-center h-100">
	// 				<h5 class="m-0 text-danger">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>
	// 			</div>
	// 		`);
	// 		return false;
	// 	}

	// 	let div = $('#genYear').empty();
	// 	res.Data.forEach(element => {
	// 		div.append(`<option value="${element.endYear}">${parseInt(element.endYear)+543}</option>`);
	// 	});
	// 	let dd = new Date();
	// 	let yy = dd.getFullYear();
	// 	$('#genYear').val(yy);
	// }

	function getMonthDifference(startDate, endDate) {
		return (
			endDate.getMonth() -
			startDate.getMonth() +
			12 * (endDate.getFullYear() - startDate.getFullYear())
		);
	}

	function downloadPDF() {
		let dealerCode = document.getElementsByName("dealerCode")[0].value;
		let start_date = document.getElementById("start_date").value;
		let end_date = document.getElementById("end_date").value;

		if (getMonthDifference(new Date(start_date), new Date(end_date)) >= 3) {
			Swal.fire(
				'คำเตือน!',
				'การดึงข้อมูลเกิน 3 เดือนอาจทำให้ระบบช้า',
				'warning'
			);
			return false;
		}

		if (!dealerCode) {
			Swal.fire(
				'คำเตือน!',
				'กรุณาเลือกดีลเลอร์',
				'warning'
			);
			return false;
		}
		if (!start_date) {
			Swal.fire(
				'คำเตือน!',
				'กรุณาเลือกวันที่เริ่มบันทึก',
				'warning'
			);
			return false;
		}
		if (!end_date) {
			Swal.fire(
				'คำเตือน!',
				'กรุณาเลือกวันที่สิ้นสุดการบันทึก',
				'warning'
			);
			return false;
		}
		if (dealerCode == 'ALL') {
			document.getElementById("data_report_wrong_number").setAttribute('action', `report/report_renew_wrong_number_pdf.php`);
		} else {
			document.getElementById("data_report_wrong_number").setAttribute('action', `report/report_renew_wrong_number_dealer_pdf.php`);
		}
	}

	function downloadEXCEL() {
		let dealerCode = document.getElementsByName("dealerCode")[0].value;
		let start_date = document.getElementById("start_date").value;
		let end_date = document.getElementById("end_date").value;

		if (getMonthDifference(new Date(start_date), new Date(end_date)) >= 3) {
			Swal.fire(
				'คำเตือน!',
				'การดึงข้อมูลเกิน 3 เดือนอาจทำให้ระบบช้า',
				'warning'
			);
			return false;
		}

		if (!dealerCode) {
			Swal.fire(
				'คำเตือน!',
				'กรุณาเลือกดีลเลอร์',
				'warning'
			);
			return false;
		}
		if (!start_date) {
			Swal.fire(
				'คำเตือน!',
				'กรุณาเลือกวันที่เริ่มบันทึก',
				'warning'
			);
			return false;
		}
		if (!end_date) {
			Swal.fire(
				'คำเตือน!',
				'กรุณาเลือกวันที่สิ้นสุดการบันทึก',
				'warning'
			);
			return false;
		}
		if (dealerCode == 'ALL') {
			document.getElementById("data_report_wrong_number").setAttribute('action', `report/report_renew_wrong_number_xlsx.php`);
		} else {
			document.getElementById("data_report_wrong_number").setAttribute('action', `report/report_renew_wrong_number_dealer_xlsx.php`);
		}
	}

	checkOption();

	function checkOption() {
		let chk = document.querySelector('input[name="typeOptions"]:checked').value;
		if (chk == 'option2') {
			$('#option2').show();
			$('#option1').hide();
		} else {
			$('#option1').show();
			$('#option2').hide();
		}
	}
</script>