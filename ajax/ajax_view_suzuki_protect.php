<?php
require("../pages/check-ses.php");
require("../inc/connectdbs.pdo.php");
?>
<style>
	.q-table {
		border-style: solid;
		border-width: 1px;
		border-color: #cccccc;
	}

	.q-tr {
		border-style: solid;
		border-width: 1px;
		border-color: #cccccc;
		background-color: #fff;
	}

	.q-tr:hover {
		background-color: #cccccc;

	}

	.q-td {
		/*font-size:14px;
	border-style: dashed;
	border-width: 2px;
	border-color:#0078FF;*/
		font-size: 14px;
		border-style: solid;
		border-width: 1px;
		border-color: #cccccc;
	}

	.q-image {
		height: 50px;
	}

	/*  new */
	body {
		color: #2c3e50;
		background: #ecf0f1;
	}

	h1 {
		text-align: center;
	}

	.half2 {
		/* float: left;
  width: 50%;
  padding: 0 1em;*/
	}

	/* Acordeon styles */
	.tab2 {
		position: relative;
		margin-bottom: 1px;
		width: 100%;
		color: #fff;
		overflow: hidden;
	}

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

	.gradi {
		background: linear-gradient(to right, rgb(123 123 123) 0%, rgb(109 109 109) 51%, rgb(144 144 144) 100%) !important;
	}

	.blue label {
		background-color: #ffffff;
	}

	/* :checked */
	.tab-content2 {
		max-height: 0;
		overflow: hidden;
		background: #ffffff;
		-webkit-transition: max-height .35s;
		-o-transition: max-height .35s;
		transition: max-height .35s;
	}

	.blue .tab-content2 {
		background: #3498db;
	}

	.tab-content2 p {
		border: 1px solid #c5d0dc !important;
		/* padding: 16px 12px; */
		position: relative !important;
		z-index: 11 !important;
	}

	input:checked~.tab-content2 {
		max-height: 250px;
	}

	/* :checked */


	/* :checked */
	.tab-content3 {
		max-height: 0;
		overflow: hidden;
		background: #ffffff;
		-webkit-transition: max-height .35s;
		-o-transition: max-height .35s;
		transition: max-height .35s;
	}

	.blue .tab-content3 {
		background: #3498db;
	}

	.tab-content3 p {
		border: 1px solid #c5d0dc !important;
		/* padding: 16px 12px; */
		position: relative !important;
		z-index: 11 !important;
	}

	input:checked~.tab-content3 {
		max-height: 350px;
	}

	/* :checked */


	/* :checked */
	.tab-content4 {
		max-height: 0;
		overflow: hidden;
		background: #ffffff;
		-webkit-transition: max-height .35s;
		-o-transition: max-height .35s;
		transition: max-height .35s;
	}

	.blue .tab-content4 {
		background: #3498db;
	}

	.tab-content4 p {
		border: 1px solid #c5d0dc !important;
		/* padding: 16px 12px; */
		position: relative !important;
		z-index: 11 !important;
	}

	input:checked~.tab-content4 {
		max-height: 350px;
	}

	/* :checked */


	/* Icon */
	label::after {
		position: absolute;
		right: 0;
		top: 0;
		display: block;
		width: 1em;
		text-align: center;
		-webkit-transition: all .35s;
		-o-transition: all .35s;
		transition: all .35s;
	}

	input[type=radio]+label::after {
		content: "\25BC";
	}

	input[type=checkbox]:checked+label::after {
		transform: rotate(315deg);
	}

	input[type=radio]:checked+label::after {
		transform: rotateX(180deg);
	}
</style>
<?php
function thaiDate($datetime)
{
	list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
	list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
	list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
	$Y = $Y + 543;
	switch ($m) {
		case "01":
			$m = "01";
			break;
		case "02":
			$m = "02";
			break;
		case "03":
			$m = "03";
			break;
		case "04":
			$m = "04";
			break;
		case "05":
			$m = "05";
			break;
		case "06":
			$m = "06";
			break;
		case "07":
			$m = "07";
			break;
		case "08":
			$m = "08";
			break;
		case "09":
			$m = "09";
			break;
		case "10":
			$m = "10";
			break;
		case "11":
			$m = "11";
			break;
		case "12":
			$m = "12";
			break;
	}
	return $d . "/" . $m . "/" . $Y;
}

function doComparison($a, $operator, $b)
{
	switch ($operator) {
		case '<':
			return ($a <  $b);
			break;
		case '<=':
			return ($a <= $b);
			break;
		case '=':
			return ($a == $b);
			break; // SQL way
		case '==':
			return ($a == $b);
			break;
		case '!=':
			return ($a != $b);
			break;
		case '>=':
			return ($a >= $b);
			break;
		case '>':
			return ($a >  $b);
			break;
	}
}

?>

<?php

$protect_type = $_POST['tprotect_type'];
$scost = $_POST['tscost'];

//echo $_POST['tprotect_type'];

$dateN = date("Y-m-d");  //วันที่ปัจจุบัน
$nowYear = date('Y'); //ปีปัจจุบัน
$yearOld = number_format($nowYear - $regis_date) + 1;


$sqlRes = " SELECT * FROM tb_protection WHERE  protect_type = '" . $protect_type . "' ";
$row = PDO_CONNECTION::fourinsure_insured()->query($sqlRes)->fetch(2);

$excess = $row["Excess"];

$comp_insure = $row["comp_insure"];
$driverticket = $row["driverticket"];
$driver = $row["driver"];
$tickets = $row["tickets"];
$passenger = $row["passenger"];

$insuran = $row["insuran"];
$nurse = $row["nurse"];

$life = $row["life"];
$maxlife = $row["maxlife"];
$asset = $row["asset"];
?>

<div class="half2">
	<div class="tab2">
		<label class="gradi" style="text-align: center; font-size: 16px !important; line-height: 40px !important;"><i class="icon-list"></i>&nbsp;รายละเอียดความคุ้มครอง</label>
	</div>
	<div class="tab2 border-2-sd">
		<input id="tab-one" type="checkbox" name="tabs" style="display: none;">
		<label for="tab-one" class="gradi" style="line-height: 30px !important; margin: 0px;">ความคุ้มครองรถยนต์เสียหาย สูญหาย ไฟไหม้</label>
		<div class="tab-content2">
			<!-- row 1 -->
			<div>
				<div style="padding: 10px;">
					<div class="span6">1) ความเสียหายต่อรถยนต์</div>
					<div class="span3">
						<div id="sttun"></div>
						<div id="sttun2"><?php echo number_format($scost, 0); ?></div>
					</div>
					<div class="span3">บาท/ครั้ง</div>
				</div>
			</div>
			<!-- row 1 -->
			<!-- row 2 -->
			<div>
				<div style="padding: 10px;">
					<div class="span6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.1 ความเสียหายส่วนแรก</div>
					<div class="span3">
						<div id="sttun"></div>
						<div id="sttun2"><?php echo number_format($excess, 0); ?></div>
					</div>
					<div class="span3">บาท/ครั้ง</div>
				</div>
				<div style="height: 1px; clear: both;"></div>
				<div style="height: 1px; background-color: #000; width: 95%; margin: auto;"></div>
				<div style="height: 6px; clear: both;"></div>
			</div>
			<!-- row 2 -->
			<!-- row 3 -->
			<div>
				<div style="padding:0px 10px 0px 10px;">
					<div class="span12">2) รถยนต์สูญหาย / ไฟไหม้</div>
				</div>
			</div>
			<!-- row 3 -->
			<!-- row 4 -->
			<div>
				<div style="padding: 10px;">
					<div class="span6"></div>
					<div class="span3">
						<div id="sttun3"></div>
						<div id="sttun4"><?php echo number_format($scost, 0); ?></div>
					</div>
					<div class="span3">บาท/ครั้ง</div>
				</div>
			</div>
			<!-- row 4 -->
			<!-- row 5 -->
			<div>
				<div style="padding: 10px;">
					<div class="span6"></div>
					<div class="span3">
						<div id="sttun5"></div>
						<div id="sttun6">-</div>
					</div>
					<div class="span3">บาท/ครั้ง</div>
				</div>
			</div>
			<!-- row 5 -->
		</div>
	</div>
	<div class="tab2 border-2-sd">
		<input id="tab-two" type="checkbox" name="tabs" style="display: none;">
		<label for="tab-two" class="gradi" style="line-height: 30px !important; margin: 0px;">ความคุ้มครองตามเอกสารแนบท้าย</label>
		<div class="tab-content3">

			<!-- row 1 -->
			<div>
				<div style="padding: 10px;">
					<div class="span6">1) อุบัติเหตุส่วนบุคคล</div>
					<div class="span3"></div>
					<div class="span3"></div>
				</div>
			</div>
			<!-- row 1 -->
			<!-- row 2 -->
			<div>
				<div style="padding:5px 10px;">
					<div class="span12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.1 เสียชีวิต สูญเสียอวัยวะ ทุพพลภาพถาวร</div>
				</div>
				<div style="clear: both;"></div>
				<div style="padding:5px 10px;">
					<div class="span5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ก) ผู้ขับขี่ <?php echo $driverticket; ?> คน</div>
					<div class="span3"><?php echo number_format($driver, 0); ?></div>
					<div class="span4">บาท</div>
				</div>
				<div style="padding:5px 10px;">
					<div class="span5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข) ผู้โดยสาร <?php echo $tickets; ?> คน</div>
					<div class="span3"><?php echo number_format($passenger, 0); ?></div>
					<div class="span4">บาท/คน</div>
				</div>
				<div style="padding:5px 10px;">
					<div class="span12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.2) ทุพพลภาพชั่วคราว</div>
				</div>
				<div style="clear: both;"></div>
				<div style="padding:5px 10px;">
					<div class="span5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ก) ผู้ขับขี่ 1 คน</div>
					<div class="span3">ไม่คุ้มครอง</div>
					<div class="span4">บาท/สัปดาห์</div>
				</div>
				<div style="padding:5px 10px;">
					<div class="span5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข) ผู้โดยสาร - คน</div>
					<div class="span3">ไม่คุ้มครอง</div>
					<div class="span4">บาท/คน/สัปดาห์</div>
				</div>
				<div style="height: 1px; clear: both;"></div>
				<div style="height: 1px; background-color: #000; width: 95%; margin: auto;"></div>
				<div style="height: 6px; clear: both;"></div>
			</div>
			<!-- row 2 -->
			<!-- row 3 -->
			<div>
				<div style="padding: 10px;">
					<div class="span5">2) ค่ารักษาพยาบาล</div>
					<div class="span3"><?php echo number_format($nurse, 0); ?></div>
					<div class="span4">บาท/คน</div>
				</div>
			</div>
			<!-- row 3 -->
			<!-- row 4 -->
			<div>
				<div style="padding: 10px;">
					<div class="span5">3) การประกันตัวผู้ขับขี่</div>
					<div class="span3"><?php echo number_format($insuran, 0); ?></div>
					<div class="span4">บาท/ครั้ง</div>
				</div>
			</div>
			<!-- row 4 -->
		</div>
	</div>
	<div class="tab2 border-2-sd">
		<input id="tab-three" type="checkbox" name="tabs" style="display: none;">
		<label for="tab-three" class="gradi" style="line-height: 30px !important; margin: 0px;">ความรับผิดต่อบุคคลภายนอก</label>
		<div class="tab-content4">
			<!-- row 1 -->
			<div>
				<div style="padding: 10px;">
					<div class="span12">1) ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย เฉพาะส่วนเกินวงเงินสูงสุดตาม พ.ร.บ.</div>
				</div>
			</div>
			<!-- row 1 -->
			<!-- row 2 -->
			<div>
				<div style="padding:5px 10px;">
					<div class="span6"></div>
					<div class="span3"><?php echo number_format($life, 0); ?></div>
					<div class="span3">บาท/คน</div>
				</div>
				<div style="padding:5px 10px;">
					<div class="span6"></div>
					<div class="span3"><?php echo number_format($maxlife, 0); ?></div>
					<div class="span3">บาท/ครั้ง</div>
				</div>
				<div style="height: 1px; clear: both;"></div>
				<div style="height: 1px; background-color: #000; width: 95%; margin: auto;"></div>
				<div style="height: 6px; clear: both;"></div>
			</div>
			<!-- row 2 -->
			<!-- row 3 -->
			<div>
				<div style="padding: 10px;">
					<div class="span12">2) ความเสียหายต่อทรัพย์สิน</div>
				</div>
				<div style="padding: 10px;">
					<div class="span6"></div>
					<div class="span3"><?php echo number_format($asset, 0); ?></div>
					<div class="span3">บาท/คน</div>
				</div>
				<div style="padding:5px 10px;">
					<div class="span6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.1) ความเสียหายส่วนแรก</div>
					<div class="span3">-</div>
					<div class="span3">บาท/ครั้ง</div>
				</div>
			</div>
			<!-- row 3 -->
		</div>
	</div>
</div>