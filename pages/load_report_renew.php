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
							<h5>รายงานการต่ออายุ</h5>
						</header>


						<div id="collapse4" class="body">

							<form name='data_report' id='data_report' action='report/report_renew_pdf.php' onsubmit='return save_report();' target="_blank" method="POST">
								<div class='di_pad'>
									<div class='area1' id='divDealerCode'>

									</div>
								</div>
								<div class='di_pad'>
									<div class='area3'>
										<div class='re_ti-2'>
											เดือน/ปี หมดอายุ
										</div>
										<div class='re_in'>
											<!-- <input type='text' name='start_date' id='start_date' class='span10' autocomplete="off"> -->
											<select name="genMonth" id="genMonth"></select>
										</div>
										<div class='re_in_small'>

										</div>
										<div class='re_in'>
											<select name="genYear" id="genYear"></select>
											<!-- <input type='text' name='end_date' id='end_date' class='span10' autocomplete="off"> -->
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
	$("#start_date").datepicker({
		format: "mm-yyyy",
		startView: "months",
		minViewMode: "months"
	});
	$("#end_date").datepicker({
		format: "mm-yyyy",
		startView: "months",
		minViewMode: "months"
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
			$('#divDealerCode').append(`<div class='re_ti' >
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

	genSelectMonth();

	function genSelectMonth() {
		let div = $('#genMonth').empty();
		for (let index = 1; index < 13; index++) {
			div.append(`<option value="${index}">${genSelectMonthTH(index)}</option>`);
		}
		let dd = new Date();
		let mm = dd.getUTCMonth();
		$('#genMonth').val(mm + 1);
	}
	genSelectYear();
	async function genSelectYear() {
		let req = {
			type: "POST",
			dataType: "json",
			url: "services/ReportRenew/report-renew.controller.php",
			data: {
				Controller: 'genYearByEnddate',
				dealerCode: _checkDealerCode

			},
			success: function(x) {
				return x;
			},
			error: function(e) {
				console.log(e);
				return false;
			}
		};

		let res = await $.ajax(req);

		if (res.Status !== 200) {
			// $('#chartdiv4').empty();
			// $('#chartdiv4').html(`
			//     <div class="d-flex align-items-center justify-content-center h-100">
			//         <h5 class="m-0 text-danger">ไม่พบข้อมูล <i class="far fa-folder-open"></i></h5>
			//     </div>
			// `);
			return false;
		}

		let div = $('#genYear').empty();
		res.Data.forEach(element => {
			div.append(`<option value="${element.endYear}">${parseInt(element.endYear)+543}</option>`);
		});
		let dd = new Date();
		let yy = dd.getFullYear();
		$('#genYear').val(yy);
	}
</script>