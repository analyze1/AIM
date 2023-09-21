<?php
include "check-ses.php"; 
//include "../inc/checksession.inc.php";
include "../inc/connectdbs.inc.php";

	function thaiDate($datetime)
	{
		list($date,$time) = explode(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($H,$i,$s) = explode(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
		list($Y,$m,$d) = explode('-',$date); // แยกวันเป็น ปี เดือน วัน
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
	
	function thaiDate2($datetime)
	{
		list($date,$time) = explode(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($Y,$m,$d) = explode('-',$date); // แยกวันเป็น ปี เดือน วัน
		list($H,$i,$s) = explode(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
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
		return $d."/".$m."/".$Y."  ".$H.":".$i.":".$s;
	} 
	
	function paytype($pay)
	{
		switch($pay) 
		{
			case "CASH": $pay = "เงินสด"; break;
			case "CCB": $pay = "เช็ค"; break;
			case "SMT": $pay = "โอน"; break;
			case "CREDIT": $pay = "บัตรเครดิต"; break;
			case "TAX1": $pay = "1%"; break;
			case "VIB": $pay = "วิริยะ"; break;
		}
		return $pay;
	}
	
	function banktype($bank)
	{
		switch($bank) 
		{
			case "BBK": $bank = "กรุงเทพ"; break;
			case "KTB": $bank = "กรุงไทย"; break;
			case "BAY": $bank = "กรุงศรีฯ"; break;
			case "KBANK": $bank = "กสิกรไทย"; break;
			case "SCB": $bank = "ไทยพาณิชย์"; break;
			case "TNN": $bank = "ธนชาต"; break;
			case "CIMB": $bank = "CIMB THAI"; break;
			case "CITY": $bank = "City Bank"; break;
			case "CENTRAL": $bank = "Central Card"; break;
			case "TESCO": $bank = "Tesco"; break;
			case "0": $bank = "-"; break;
			case " ": $bank = "-"; break;
		}
		return $bank;
	}

    function Showtime($datetime)
	{
		list($date,$time) = explode(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($Y,$m,$d) = explode('-',$date); // แยกวันเป็น ปี เดือน วัน
		list($H,$i,$s) = explode(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
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
		return $H.":".$i;
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

?>

<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap-responsive.min.css" />
    <link type="text/css" rel="stylesheet" href="assets/Font-awesome/css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/style.css" />
    <!--<link id="active-theme" type="text/css" rel="stylesheet" href="assets/css/default.min.css"/>-->
    <style type="text/css">
    .style1 {
        font-size: 12px;
        color: #333;
    }
    </style>
    <script type="text/javascript" src="assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

    <link type="text/css" rel="stylesheet" href="assets/css/datepicker.css">

    <title>Untitled Document</title>
    <script>
    $(function() {})
    </script>

    <style type="text/css">
    /*- Menu Tabs--------------------------- */

    #tabs {
        float: left;
        min-width: 935px;
        /* background:#003366  ;*/
        background: -webkit-linear-gradient(#000000, #4c4c4c);
        /* For Safari 5.1 to 6.0 */
        background: -o-linear-gradient(#000000, #4c4c4c);
        /* For Opera 11.1 to 12.0 */
        background: -moz-linear-gradient(#000000, #4c4c4c);
        /* For Firefox 3.6 to 15 */
        background: linear-gradient(#000000, #4c4c4c);
        /* Standard syntax (must be last) */
        font-size: 93%;
        line-height: normal;

    }

    #tabs ul {
        margin: 0;
        padding: 5px 10px 0 5px;
        list-style: none;
    }

    #tabs li {
        display: inline;
        margin: 0;
        padding: 0;
    }

    #tabs a {
        float: left;
        background: url("icon/tableft.gif") no-repeat left top;
        margin: 0;
        padding: 0 0 0 4px;
        text-decoration: none;

    }

    #tabs a span {
        float: left;
        display: block;
        background: url("icon/tabright.gif") no-repeat right top;
        padding: 5px 15px 4px 6px;
        color: #666;
    }

    /* Commented Backslash Hack hides rule from IE5-Mac \*/
    #tabs a span {
        float: none;
    }

    /* End IE5-Mac hack */
    #tabs a:hover span {
        color: #FF9834;
    }

    #tabs a:hover {
        background-position: 0% -42px;
    }

    #tabs a:hover span {
        background-position: 100% -42px;
    }

    #tabs #current a {
        background-position: 0% -42px;
    }

    #tabs #current a span {
        background-position: 100% -42px;
    }

    #tabs ul li.active a {
        background-position: 0% -42px;
        color: #FF9834;
        font-weight: bold;
    }

    #tabs ul li.active a span {
        float: left;
        display: block;
        background: url("icon/tabright.gif") no-repeat right top;
        background-position: 0% -42px;
        padding: 5px 15px 4px 6px;
        color: #FF9834;
    }

    #tabs .texthead {
        color: #C0C0C0;
        height: 80px;
        margin-top: 0px;
    }

    #tabs .texthead h1 {
        margin-left: 50px;
        text-shadow: 1px 1px 1px #000000;
        font-size: 20px;
    }

    #tabs .texthead h2 {
        margin-left: 50px;
        margin-top: -20px;
        padding-bottom: 0px;
        text-shadow: 1px 1px 1px #000000;
        font-size: 16px;
    }

    #tabs .texthead h3 {
        float: right;
        margin-top: -65px;
        margin-right: 10px;
        text-shadow: 1px 1px 1px #000000;
        font-size: 14px;
    }

    #tabs .texthead h4 {
        margin-right: 10px;
        margin-top: -10px;
        text-shadow: 1px 1px 1px #000000;
        font-size: 12px;
        text-align: right;

    }
    </style>

<body>
    <?php

$query = "SELECT ";
$query .= "data.id,";
$query .= "data.login, "; // รหัสผู้แจ้ง
$query .= "data.com_data, "; // รหัสผู้แจ้ง
$query .= "tb_customer.sub as branch, "; // สาขา
$query .= "tb_customer.contact, "; // ชื่อผู้แจ้ง  contact
$query .= "data.send_date,   "; // วันที่แจ้ง
$query .= "data.name_inform, "; // รหัสผู้แจ้ง
$query .= "data.id_data, "; // เลขที่รับแจ้ง
$query .= "tb_type_inform.name as type_inform_name, "; // ประเภทงาน
$query .= "data.p_act, "; // เลขที่กรมธรรม์ พ.ร.บ.
$query .= "data.start_date, "; // วันที่คุ้มครอง
$query .= "data.end_date, "; // วันที่สิ้นสุด
$query .= "data.name_gain, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.send_req, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.send_req2, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.send_cancel, "; // ชื่อผู้รับผลประโยชน์
$query .= "data.my4ib_check, "; // วิริยะปากเกร็ด
$query .= "data.com_data, "; // วิริยะปากเกร็ด
$query .= "data.CutPayment, ";
$query .= "data.StatusPayment, ";
$query .= "data.DateCutPay, ";

$query .= "insuree.title, "; // คำนำหน้า ชื่อผู้เอาประกัน
$query .= "insuree.name,  "; // ชื่อผู้เอาประกัน
$query .= "insuree.last, "; // นามสกุลผู้เอาประกัน
$query .= "insuree.add, "; // บ้านเลขที่
$query .= "insuree.group, "; // หมู่
$query .= "insuree.town, "; //อาคาร/หมู่บ้าน
$query .= "insuree.lane, "; // ซอย
$query .= "insuree.road, "; // ถนน
$query .= "insuree.tumbon, "; // ตำบล คีย์
$query .= "insuree.amphur, "; // อำเภอ คีย์
$query .= "insuree.province, "; // จังหวัด คีย์
$query .= "insuree.postal, "; // รหัสไปรษณีย์
$query .= "insuree.career, "; // แยกใบเสร็จ
$query .= "insuree.SendAdd, "; // ที่อยู่จัดส่งเอกสาร
$query .= "insuree.email, "; // แยกใบเสร็จ
$query .= "insuree.tel_mobi, "; // แยกใบเสร็จ
$query .= "insuree.person, ";
$query .= "insuree.icard, ";

$query .= "tb_tumbon.name as tumbon_name, "; 
$query .= "tb_amphur.name as amphur_name, "; 
$query .= "tb_province.name as province_name, "; // จังหวัด

$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
$query .= "detail.mo_car, "; // ยี่ห้อรถ
$query .= "tb_br_car.name as car_brand, "; // ยี่ห้อรถ
$query .= "tb_cat_car.name as cat_car_name, "; // ประเภทรถ
$query .= "tb_mo_car.name as mo_car_name, "; // รุ่นรถ

$query .= "detail.car_color, "; // สีรถ
$query .= "detail.car_regis, "; // ทะเบียนรถ
$query .= "detail.car_regis_text, "; // ทะเบียนรถ
$query .= "detail.car_body, "; // เลขตัวถัง
$query .= "detail.regis_date, "; // ปีที่จดทะเบียน
$query .= "detail.n_motor, "; // เลขเครื่อง
$query .= "detail.equit, ";
$query .= "detail.car_detail, ";
$query .= "detail.cat_car, ";
$query .= "detail.gear, ";

$query .= "detail.product, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product1, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product2, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด  
$query .= "detail.product3, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product4, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product5, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product6, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product7, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product8, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด
$query .= "detail.product9, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด  
$query .= "detail.product10, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product11, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product12, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product13, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.product14, "; // อุปกรณ์ตกแต่งเพิ่มเติม //รายละเอียด 
$query .= "detail.price_total, "; // ราคาทุนอุปกรณ์ตกแต่งเพิ่มเติม
$query .= "detail.add_price, "; // ราคาทุนอุปกรณ์ตกแต่งเพิ่มเติม

$query .= "data.updated, "; // สลักหลัง
$query .= "protect.costCost,"; // ทุนประกันภัย

$query .= "smt.cost, ";
$query .= "smt.pre, ";
$query .= "smt.stamp, ";
$query .= "smt.tax, ";
$query .= "smt.net, ";

$query .= "req.Req_Status, ";
$query .= "req.Req_Date, ";
$query .= "req.EditCancel, ";
$query .= "req.Cancel_Detail, ";
$query .= "req.EditTime, ";
$query .= "req.EditTime_StartDate, ";
$query .= "req.EditTime_EndDate, ";
$query .= "req.EditHr, ";
$query .= "req.EditHr_Detail, ";
$query .= "req.EditAct, ";
$query .= "req.EditAct_id, ";
$query .= "req.EditCar, ";
$query .= "req.Edit_CarBody, ";
$query .= "req.Edit_Nmotor, ";
$query .= "req.Edit_CarColor, ";
$query .= "req.EditCustomer, ";
$query .= "req.EditPerson, ";
$query .= "req.Cus_title, ";
$query .= "req.Cus_name, ";
$query .= "req.Cus_last, ";
$query .= "req.Cus_add, ";
$query .= "req.Cus_group, ";
$query .= "req.Cus_town, ";
$query .= "req.Cus_lane, ";
$query .= "req.Cus_road, ";
$query .= "req.Cus_tumbon, ";
$query .= "req.Cus_amphur, ";
$query .= "req.Cus_postal, ";
$query .= "req.EditCost, ";
$query .= "req.EditcostCost, ";
$query .= "req.EditProduct, ";
$query .= "req.Product as ReqProduct, ";
$query .= "req.TotalProduct, ";
$query .= "req.CostProduct, ";

$query .= "tb_customer.title_sub,";
$query .= "tb_customer.sub,";
$query .= "tb_customer.saka,";
$query .= "tb_customer.Email,";
$query .= "tb_customer.Email2,";
$query .= "tb_customer.Email3,";
$query .= "tb_customer.Email4,";
$query .= "tb_customer.Email5, ";
$query .= "tb_customer.Email6, ";
$query .= "tb_customer.Contact2 ";

$query .= "FROM data ";
$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
$query .= "INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
$query .= "INNER JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
$query .= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
$query .= "INNER JOIN smt ON (smt.id_cost = protect.costCost) ";
$query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
$query .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
$query .= "INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
$query .= "INNER JOIN tb_province ON (tb_province.id = insuree.province) ";
$query .= "INNER JOIN tb_customer ON (tb_customer.user = data.login) ";
$query .= "INNER JOIN req ON (req.id_data = data.id_data) ";
	
$query .= "WHERE data.id_data='".$_GET["IDDATA"]."' ";
//echo $query;
mysql_select_db($db1,$cndb1);
$objQuery = mysql_query($query,$cndb1) or die ("Error Query tb_data [".$query."]");
$row = mysql_fetch_array($objQuery);

$query1 = "SELECT ";
$query1 .= "tb_tumbon.name as tumbon, "; 
$query1 .= "tb_amphur.name as amphur, "; 
$query1 .= "tb_province.name as province "; // จังหวัด
$query1 .= "FROM req ";
$query1 .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = req.Cus_tumbon) ";
$query1 .= "INNER JOIN tb_amphur ON (tb_amphur.id = req.Cus_amphur) ";
$query1 .= "INNER JOIN tb_province ON (tb_province.id = req.Cus_province) ";
$query1 .= "WHERE req.id_data='".$row["id_data"]."' ";
$objQuery1 = mysql_query($query1, $cndb1) or die ("Error Query [".$query1."]");
$row1 = mysql_fetch_array($objQuery1);

$sqlMORE = "SELECT * FROM tb_acc";
$objQueryMORE = mysql_query($sqlMORE, $cndb1) or die ("Error Query [".$sqlMORE."]");
$costOb = array();
while($rowCost = mysql_fetch_array($objQueryMORE)){
	$costOb['name'][$rowCost['id']] = $rowCost['name'];
	$costOb['price'][$rowCost['id']] = $rowCost['price'];
	$costOb['price2'][$rowCost['id']] = $rowCost['price2'];
}
$sqlMOREname = "SELECT * FROM tb_acc_new";
$objQueryMOREname = mysql_query($sqlMOREname, $cndb1) or die ("Error Query [".$sqlMOREname."]");
$costObname = array();
while($rowCostname = mysql_fetch_array($objQueryMOREname)){
	$costObname['name']['0'.$rowCostname['idcar']][$rowCostname['id']] = $rowCostname['name'];
}
if($row['EditProduct'] !='Y'){
	if($row['equit']=='Y'){
		$p=0;
		$i=0;
		$exitNum = explode("|",$row['car_detail']);
		for($i=0;$i<count($exitNum);$i++){
			$exitSplit = explode(",",$exitNum[$i]);
				if($p<6){$equit0 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
				else if($p<12){$equit1 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
				else if($p<18){$equit2 .=$costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
		}
	}else{
		$equit0 .= "ไม่มี";
	}
}
				
if($row['EditProduct'] =='Y'){
	$p=0;
	$i=0;
	$exitNum = explode("|",$row['ReqProduct']);
	for($i=0;$i<count($exitNum);$i++){
		$exitSplit = explode(",",$exitNum[$i]);
			if($p<6){$equit0 .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
			else if($p<12){$equit1.= $costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
			else if($p<18){$equit2.=$costObname['name'][$row['cat_car']][$exitSplit[0]].' '.number_format($costOb['name'][$exitSplit[1]],0).' บาท ';$p++;}
	}
}


	
?>


    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="5">&nbsp;</td>
            <td width="120" align="left"><img src="img4/logo4.png" width="100" height="45" /></td>
            <td width="321" align="left">
                <font size="2"><?php echo $row['name_inform'].' ('.$row['login'].')'; ?></font>
            </td>
        </tr>
        <tr>
            <td height="10" colspan="3" align="right">
                <font size="2">วันที่รับแจ้ง <?php echo thaiDate2($row['send_date']).' น.';?>
                    <? if($row['Req_Status'] == 'Y'){ echo '<br/>วันที่สลักหลัง '.thaiDate2($row['Req_Date']).' น.'; } ?>
                </font>
            </td>
        </tr>
        <tr>
            <td height="10" colspan="3"></td>
        </tr>
    </table>

    <ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">รายละเอียดลูกค้า</a></li>
        <li><a href="#tab2" data-toggle="tab">รายละเอียดรถยนต์</a></li>
        <li><a href="#tab3" data-toggle="tab">การรับชำระเงิน</a></li>
        <li><a href="#tab4" data-toggle="tab"><span>จัดส่งเอกสาร</span></a></li>
    </ul>

    <?
			if($row['com_data']== "VIB_S")
			{
				$idcom_data = "09712";
			}
			else if($row['com_data']=="VIB_F")
			{
				$idcom_data = "11678";
			}
			else if($row['com_data']=="VIB_C" && $row['saka'] == '113')
			{
				$idcom_data = "08829";
			}
			else if($row['com_data']=="VIB_C" && $row['saka'] != '113')
			{
				$idcom_data = "10320";
			}
				
		//****************************เงื่อนไขการชำระ กรมธรรม์*********************************///
			$query2 = "  SELECT * FROM `payment` WHERE `id_data`= '".$row['id_data']."' AND `idDealer` != 'SMT' ORDER BY `payment`.`DatePayment` DESC LIMIT 0 , 30  ";
			$objQuery2 = mysql_query($query2, $cndb1) or die ("Error Query [".$query2."]");
			$row2 = mysql_fetch_array($objQuery2);
			
			$query_idPayment = "  SELECT idPayment FROM `payment` WHERE `id_data`= '".$row['id_data']."' AND `idDealer` != 'SMT' ORDER BY `payment`.`DatePayment` ASC LIMIT 0 , 30  ";
			$objQuery_idPayment = mysql_query($query_idPayment, $cndb1) or die ("Error query_idPayment [".$query_idPayment."]");
			while($row_idPayment= mysql_fetch_array($objQuery_idPayment))
			{
				$idPayment = $idPayment.' '.$row_idPayment['idPayment'];
			}
			
			if($idcom_data == '09712')
			{
				//$TxtPaymentId = $row2['idPayment'];
				$TxtPaymentId = $idPayment;
				if($row['CutPayment'] == 'Y')
				{
					$TxtPayment = "SMT : ".date('d/m/Y', strtotime($row['DateCutPay']));
				}
				if($row2['StatusPayment'] == '')
				{
					$TxtPayment = "ฟรี SMT";
				}
			}
			else
			{
				//$TxtPaymentId = $row2['idPayment'];
				$TxtPaymentId = $idPayment;
				if($row2['StatusPayment'] == '')
				{
					$TxtPayment = "ยังไม่ได้วางบิล";
				}
				if($row2['StatusPayment'] == '1')
				{
					$TxtPayment = "ยังไม่ชำระ";;
				}
				if($row2['StatusPayment'] == '2' || $row2['StatusPayment'] == 'Y')
				{
					$TxtPayment = date('d/m/Y', strtotime($row2['DealerDate']));
				}
			}
			//****************************เงื่อนไขการชำระ สลักหลัง*********************************///		
			if($row2['Status_Req'] == '')
			{
				$TxtPaymentReq = "ไม่มี อท.";
			}
			if($row2['Status_Req'] == '1')
			{
				$TxtPaymentReq = "ยังไม่ชำระ";;
			}
			if($row2['Status_Req'] == '2' || $row2['Status_Req'] == 'Y')
			{
				$TxtPaymentReq = date('d/m/Y', strtotime($row2['DealerDate']));
			}
			//****************************เงื่อนไขตัดจ่าย กรมธรรม์*********************************///
			if($idcom_data == '09712')
			{
				if($row['CutPayment'] == 'Y')
				{
					$TxtCutPayment = $row2['idVoucher'];
				}
				if($row2['StatusPayment'] == '2')
				{
					$TxtCutPayment = "ฟรี SMT";
				}
				if($row2['StatusPayment'] == 'Y')
				{
					$TxtCutPayment_Date = date('d/m/Y', strtotime($row2['DateCompany']));
				}
			}
			else
			{
				if($row2['StatusPayment'] == '')
				{
					$TxtCutPayment = "ฟรี SMT";
				}
				if($row2['StatusPayment'] == 'Y')
				{
					$TxtCutPayment = $row2['idVoucher'];
				}
				if($row2['StatusPayment'] == '2')
				{
					$TxtCutPayment = 'ยังไม่เตรียมจ่าย';
				}
				if($row2['StatusPayment'] == 'Y')
				{
					$TxtCutPayment_Date = date('d/m/Y', strtotime($row2['DateCompany']));
				}
			}
		
		//****************************เงื่อนไขการชำระ พรบ ************************************///
			$query3 = "  SELECT * FROM `payment_act` WHERE `id_data`= '".$row['id_data']."' ORDER BY `payment_act`.`DatePayment` DESC LIMIT 0 , 30  ";
			$objQuery3 = mysql_query($query3, $cndb1) or die ("Error Query [".$query3."]");
			$row3 = mysql_fetch_array($objQuery3);

				if($idcom_data == '11678')
				{
					$TxtPaymentAct = "วิริยะแถม";
				}
				if($idcom_data == '10320')
				{
					$TxtPaymentAct = "ต่างจังหวัด";
				}
				if($idcom_data == '09712')
				{
					if($row['car_id'] == '320')
					{
						$TxtPaymentAct = $row3['idPayment'];
						if($row3['StatusPayment'] == 2)
						{
							$TxtPaymentAct_Date = date('d/m/Y', strtotime($row3['DealerDate']));
						}
						else if($row3['StatusPayment'] == 1)
						{
							$TxtPaymentAct_Date = "ยังไม่ชำระ";
						}
						else if($row3['StatusPayment'] == 'Y')
						{
							$TxtCutPayment_Act = $row3['idVoucher'];
							$TxtCutPayment_DateAct = date('d/m/Y', strtotime($row3['DateCompany']));
						}
					}
					else
					{
						$TxtPaymentAct = 'วิริยะแถม (645.21)';
					}
				}
				if($idcom_data == '08829')
				{
					$TxtPaymentAct = $row3['idPayment'];
					if($row3['StatusPayment'] == 2)
					{
						$TxtPaymentAct_Date = date('d/m/Y', strtotime($row3['DealerDate']));
					}
					else if($row3['StatusPayment'] == 1)
					{
						$TxtPaymentAct_Date = "ยังไม่ชำระ";
					}
					else if($row3['StatusPayment'] == 'Y')
					{
						$TxtCutPayment_Act = $row3['idVoucher'];
						$TxtCutPayment_DateAct = date('d/m/Y', strtotime($row3['DateCompany']));
					}
				}
		
		//****************************เงื่อนไขการชำระ พรบ ************************************///
		
		
		//****************************เงื่อนไขตัดจ่าย กรมธรรม์*********************************///
				/*if($idcom_data == '09712'){
					if($row['CutPayment'] == '2'){
						$TxtCutPayment = "SMT : ".date('d/m/Y', strtotime($row['DateCutPay']));
					}
				}else{
					if($row2['StatusPayment'] == ''){
						$TxtCutPayment = "ฟรี SMT";
					}
					if($row2['StatusPayment'] == 'Y'){
						$TxtCutPayment = $row2['idVoucher'];
					}
					if($row2['StatusPayment'] == '2'){
						$TxtCutPayment = 'ยังไม่เตรียมจ่าย';
					}
					if($row2['StatusPayment'] == 'Y' && $row2['DateCompany'] == '0000-00-00'){
						$TxtCutPayment_Date = date('d/m/Y', strtotime($row2['DateCompany']));
					}
				}*/
		
		
?>
    <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1">

            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
                <tr class="style1">
                    <td height="23">
                        <font size="2">
                            <font size="2">เลขที่รับแจ้ง</font>
                        </font>
                    </td>
                    <td height="23">
                        <font size="2">
                            <font size="2">: <strong><?=$idcom_data.'-'.$row['id_data']; ?></strong></font>
                        </font>
                    </td>
                    <td height="23">
                        <font size="2">
                            <font size="2">เลขที่ พรบ. </font>
                        </font>
                    </td>
                    <td height="23">:<strong>
                            <font size="2">
                                <font size="2">
                                    <? if($row['EditAct_id']!=''){echo $row['EditAct_id'];}else{ echo $row['p_act']; } ?>
                                </font>
                            </font>
                        </strong></td>
                </tr>
                <tr class="style1">
                    <td width="100" height="23">
                        <font size="2">ผู้เอาประกันภัย </font>
                    </td>
                    <td height="23">: <strong>
                            <font size="2">
                                <? if($row['Cus_name'] != '') {
echo $row['Cus_title'].$row['Cus_name']." ".$row['Cus_last']; }else{ echo $row['title']." ".$row['name']." ".$row['last']; }?>
                            </font>
                        </strong></td>
                    <td height="23">
                        <font size="2">
                            <? if($row['person'] == '1'){ echo 'เลขบัตรประชาชน '; }else{ echo 'เลขผู้เสียภาษี '; }?>
                        </font>
                    </td>
                    <td height="23">: <strong>
                            <font size="2"><?=$row['icard'];?></font>
                        </strong></td>
                </tr>

                <tr class="style1">
                    <td height="23">
                        <font size="2">ที่อยู่ปัจจุบัน</font>
                    </td>
                    <td height="23" colspan="3">: <strong>
                            <font size="2">
                                <?php 
					$address_pdf = $row['add'];
					if($row['group'] !="-" && $row['group'] !="")
					{
						$address_pdf .= " หมู่ ".$row['group'];
					}
					if($row['town'] != "-" && $row['town'] !="")
					{
						$address_pdf .= " ".$row['town'];
					}
					if($row['lane'] !="-" && $row['lane'] !="")
					{
						$address_pdf .= " ซอย".$row['lane'];
					}
					if($row['road'] !="-" && $row['road'] !="")
					{
						$address_pdf .= " ถนน".$row['road'];
					}
					
					if($row['province'] != "102"){
						$address_pdf .= ' ต.'.$row['tumbon_name'].' อ.'.$row['amphur_name'].' จ.'.$row['province_name'];
					}
					else{
						$address_pdf .= ' แขวง'.$row['tumbon_name'].' เขต'.$row['amphur_name'].' '.$row['province_name'];
					}
						$address_pdf .= ' '.$row['postal'];				

					$ShowReq .= $row['Cus_add']; 
					if($row['Cus_group'] !="-" && $row['Cus_group'] !=""){
						$ShowReq .= " หมู่ ".$row['Cus_group'];
					}
					if($row['Cus_town'] !="-" && $row['Cus_town'] !=""){
						$ShowReq .= " ".$row['Cus_town'];
					}
					if($row['Cus_lane'] !="-" && $row['Cus_lane'] !=""){
						$ShowReq .= " ซอย".$row['Cus_lane'];
					}
					if($row['Cus_road'] !="-"){
						$ShowReq .= " ถนน".$row['Cus_road'];
					}
					if($row1['Cus_province'] != "102"){
						$ShowReq .= " ต.".$row1['tumbon']." อ.".$row1['amphur']." จ.".$row1['province']." ".$row['Cus_postal']; 
					}else{
						$ShowReq .= " แขวง".$row1['tumbon']." เขต.".$row1['amphur']." ".$row1['province']." ".$row['Cus_postal'];
					}
						$ShowReq .= ' '.$row1['Cus_postal'];
						
					if($row['EditCustomer'] != ''){ echo $ShowReq; }else{ echo $address_pdf;}
                ?>
                            </font>
                        </strong></td>
                </tr>
                <tr class="style1">
                    <td height="23">
                        <font size="2">เบอร์มือถือ </font>
                    </td>
                    <td width="300" height="23">: <strong>
                            <font size="2"><?php echo $row['tel_mobi']; ?>
                                <?php if($row['tel_mobile2']!=''){echo ','.$row['tel_mobile2'];} ?></font>
                        </strong></td>
                    <td width="100" height="23">
                        <font size="2">Email </font>
                    </td>
                    <td height="23">: <strong>
                            <font size="2"><?php echo $row['email']; ?></font>
                        </strong></td>
                </tr>
                <tr class="style1">
                    <td height="23">ที่อยู่ในการจัดส่ง</td>
                    <td height="23" colspan="3">: <strong>
                            <font size="2"><?=$row['SendAdd']; ?></font>
                        </strong></td>
                </tr>
            </table>



            <!-------------- ติดตาม ---------------------->
            <form name="webform" id="webform" method="post"> <input type="hidden" id="countlist" value="0" />
                <a class="btn btn-small " id="add-item"> <i class="icon-plus"></i> เพิ่มรายการ</a>
                <input type="hidden" id="countlist_fol" value="0" />

                <table width="100%" border="0" cellpadding="0" cellspacing="0"
                    class="table table-striped table-bordered">
                    <tr class="style1">
                        <td width="80" height="23">
                            <div align="center">วันที่ติดตาม</div>
                        </td>
                        <td width="80">
                            <div align="center">เวลา</div>
                        </td>
                        <td width="80">
                            <div align="center">วันที่นัดชำระ</div>
                        </td>
                        <td>
                            <div align="center">รายละเอียด</div>
                        </td>
                        <td width="60">
                            <div align="center">ผู้ติดตาม</div>
                        </td>
                    </tr>
                    <?php
$sql_fol = "SELECT * From tb_follow_customer where id_data='".$row["id_data"]."' ";   
mysql_select_db($db1,$cndb1);
$objQuery_fol = mysql_query($sql_fol,$cndb1) or die ("Error Query sql_fol [".$sql_fol."]");
while($row_fol = mysql_fetch_array($objQuery_fol))
  {
?>

                    <tr>
                        <td height="23"><?=thaiDate($row_fol["date_fol"])?></td>
                        <td><?=Showtime($row_fol["date_appointment"])?> น.</td>
                        <td><?=thaiDate($row_fol["date_appointment"])?></td>
                        <td><?=$row_fol["detail_fol"]?></td>
                        <td><?=$row_fol["login_emp"]?></td>
                    </tr>
                    <?php }?>
                    <tbody id="selectlist"></tbody>
                </table>

                <script src="assets/js/jquery.js"></script>
                <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
                <script>
                $("#add-item").click(function(event) {
                    var listcount = document.getElementById("countlist_fol").value;

                    if (listcount < 1) {
                        listcount++;


                        $('#selectlist').append(
                            '<tr><td width="80" height="23" ><input name="txt_mail" type="hidden" class="span2" id="txt_mail"  style="width:90px;" value="<?=$row['Email2']; ?>"  /><input name="txt_user" type="hidden" class="span2" id="txt_user"  style="width:90px;" value="<?=$row['name_inform']; ?>"  /><input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:90px;" value="<?=$row['id_data']; ?>"  /><input name="txt_date_fol" type="text" class="span2" id="txt_date_fol"  style="width:90px;" value="<?=date('d/m/Y')?>" readonly/></td><td width="80" ><input name="txt_date_appointment" type="text" class="span2" id="txt_date_appointment"  style="width:90px;"  placeholder="วันที่นัดชำระ"/></td><td width="50%" ><input name="txt_detail" type="text" id="txt_detail" style="width:400px;" value="" placeholder="รายละเอียด" required="required" /></td><td width="14%" ><button class="btn btn-small btn-success" id="save" type="button">บันทึก</button></td><td></td></tr>'
                            );

                        $('#countlist').val(listcount);


                        $('#txt_date_fol').datepicker({
                            autoclose: true,
                            format: 'dd/mm/yyyy'
                        });
                        $('#txt_date_appointment').datepicker({
                            autoclose: true,
                            format: 'dd/mm/yyyy'
                        });

                    }

                    $("#save").click(function() {


                        var DATA = $('#webform').serialize();


                        var txt_detail = document.getElementById("txt_detail").value;
                        var txt_date_appointment = document.getElementById("txt_date_appointment")
                        .value;

                        if (txt_date_appointment == '') {

                            alert("กรุณา กรอกวันที่นัดชำระ");
                            document.getElementById("txt_date_appointment").focus();
                            return false;

                        }

                        if (txt_detail == '') {

                            alert("กรุณา กรอกรายละเอียด");
                            document.getElementById("txt_detail").focus();
                            return false;

                        }


                        var options = {
                            type: "POST",
                            dataType: "json",
                            url: "ajax/Ajax_Save_FollowCustomer_Suzuki.php",
                            data: DATA,
                            success: function(msg) {
                                var returnedArray = msg;
                                if (returnedArray.status == true) {
                                    $("#webform")[0].reset();
                                    $("#closed").click();
                                    alert(returnedArray.msg);

                                    $(".modal").hide();
                                    $(".modal-backdrop").hide();
                                    $(".modal").removeData('modal');

                                } else {
                                    alert(returnedArray.msg);

                                }
                            }
                        };
                        $.ajax(options);

                    });

                });
                </script>
            </form>
            <!-------------- จบ ติดตาม ---------------------->

            <!-------------- ต่ออายุ ---------------------->
            <form>
                <a class="btn btn-small " id="load_renew"> <i class="icon-plus"></i> ติดตามต่ออายุ</a>
                <table width="100%" border="0" cellpadding="0" cellspacing="0"
                    class="table table-striped table-bordered">
                    <tr>
                        <td>เวลาบันทึก</td>
                        <td>เบี้ยรวม</td>
                        <td>พรบ.</td>
                        <td>ยอดชำระ</td>
                        <td>สภานะ</td>
                        <td>รายละเอียด</td>
                        <td>วันที่นัด</td>
                        <td>ผู้ติดตาม</td>
                    </tr>
                    <?php
        	$query_detail_renew = "SELECT * FROM detail_renew INNER JOIN data ON (detail_renew.id_data = data.id_data) WHERE detail_renew.id_data='".$row['id_data']."' ORDER BY detail_renew.timecall DESC ";
			mysql_select_db($db1,$cndb1);
			$objQuery_detail_renew = mysql_query($query_detail_renew,$cndb1) or die ("Error Query sql_fol [".$query_detail_renew."]");
			while($row_DRenew = mysql_fetch_array($objQuery_detail_renew))
			{			
				$cost_renew = explode('|',$row_DRenew['detailcost']);
				// เบี้ยสุทธิ
				$sum_pre = $cost_renew[10]-$cost_renew[5]-$cost_renew[7];
				// อากร
				$sum_pre_duty = ceil(($sum_pre*0.004));
				//ภาษี
				$sum_pre_vat = round(($sum_pre+$sum_pre_duty)*0.07,2);
				// รวม
				$sum_pretotal = $sum_pre + $sum_pre_duty + $sum_pre_vat;
				//ส่วนลด
				$sum_dis = $cost_renew[5]+$cost_renew[7];
		?>
                    <tr>
                        <td><?=thaiDate($row_DRenew['timecall'])?></td>
                        <td><?=number_format($sum_pretotal,2)?></td>
                        <td><?=number_format($cost_renew[9],2)?></td>
                        <td><?=number_format($cost_renew[8],2)?></td>
                        <td><?=renew($row_DRenew['status'])?></td>
                        <td><?=$row_DRenew['detailtext']?></td>
                        <td><?=date('d/m/Y', strtotime($row_DRenew['date_alert']))?></td>
                        <td><?=$row_DRenew['userdetail']?></td>
                    </tr>
                    <?
			}
		?>
                </table>
            </form>
            <!-------------- จบ ต่ออายุ ---------------------->


        </div>
        <!-- End tab -->


        <div class="tab-pane fade" id="tab2">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
                <tr class="style1">
                    <td width="100" height="23">
                        <font size="2">วันที่คุ้มครอง </font>
                    </td>
                    <td height="23">: <strong>
                            <font size="2"><?php echo thaiDate($row['start_date']); ?></font>
                        </strong></td>
                    <td height="23">
                        <font size="2">ประเภทการซ่อม</font>
                    </td>
                    <td height="23">: <strong>
                            <font size="2">ซ่อมอู่</font>
                        </strong></td>
                </tr>
                <tr class="style1">
                    <td height="23">ทะเบียนรถ </td>
                    <td height="23">: <strong>
                            <font size="2"><?php echo $row['car_regis']; ?>&nbsp;
                                <?php 
				$sql = "SELECT name_mini FROM tb_province WHERE id='".$row['car_regis_pro']."'";
				mysql_query("set NAMES utf8");
        mysql_select_db($db1,$cndb1);
				$result = mysql_query( $sql,$cndb1 );
		        $fetcharr = mysql_fetch_array( $result ) ;
				echo $fetcharr['name_mini'];
			 ?>
                            </font>
                        </strong></td>
                    <td height="23">
                        <font size="2">ยี่ห้อ/รุ่นรถ </font>
                    </td>
                    <td height="23">: <strong>
                            <font size="2"><?php echo $row['car_brand']; ?> / <?php echo $row['mo_car_name']; ?></font>
                        </strong></td>
                </tr>
                <tr class="style1">
                    <td height="23">
                        <font size="2">เลขตัวถัง </font>
                    </td>
                    <td width="300" height="23">: <strong>
                            <font size="2"><?=$row['car_body'];?></br>
                                <? if($row['Edit_CarBody'] != '' ){ echo '<font color="#FF0000">'.$row['Edit_CarBody'].'</font>'; } ?>
                            </font>
                        </strong></td>
                    <td width="100" height="23">
                        <font size="2">เลขเครื่อง</font>
                    </td>
                    <td height="23">: <strong>
                            <font size="2"><?=$row['n_motor'];?></br>
                                <? if($row['Edit_CarBody'] != '' ){ echo '<font color="#FF0000">'.$row['Edit_Nmotor'].'</font>'; } ?>
                            </font>
                        </strong></td>
                </tr>
                <tr class="style1">
                    <td height="23">
                        <font size="2">ปีรถ</font>
                    </td>
                    <td height="23">: <strong>
                            <font size="2"><?=$row['regis_date']; ?></font>
                        </strong></td>
                    <td height="23">
                        <font size="2">สีรถ</font>
                    </td>
                    <td height="23">: <font size="2"><strong>
                                <font size="2"><?=$row['car_color']; ?></font>
                            </strong></td>
                </tr>
                <tr class="style1">
                    <td height="23">
                        <font size="2">ผู้รับผลประโยชน์ </font>
                    </td>
                    <td height="23">: <strong>
                            <font size="2"><?php echo $row['name_gain']; ?></font>
                        </strong></td>
                    <td height="23">
                        <font size="2">ทุนประกันภัย</font>
                    </td>
                    <td height="23">: <strong>
                            <font size="2"><?php echo $row['cost']; ?></font>
                        </strong></td>
                </tr>
            </table>


            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
                <tr class="style1">
                    <td width="100" height="23">
                        <font size="2">ผู้ขับขี่คนที่ 1</font>
                    </td>
                    <td height="23">: <strong>
                            <font size="2">ไม่ระบุ</font>
                        </strong></td>
                </tr>
                <tr>

                    <td height="23">
                        <font size="2">ผู้ขับขี่คนที่ 2</font>
                    </td>
                    <td height="23">: <strong>
                            <font size="2">ไม่ระบุ</font>
                        </strong></td>

                </tr>
            </table>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
                <tr class="style1">
                    <td width="100" height="23">อุปกรณ์ตกแต่ง</td>
                    <td height="23">: <strong>
                            <font size="2"><?=$equit0.' '.$equit1.' '.$equit2; ?></font>
                        </strong></td>
                </tr>
                <tr class="style1">
                    <td height="23">ราคาทุน</td>
                    <td height="23">: <strong>
                            <font size="2">
                                <? if($row['TotalProduct'] != '0' ) { echo number_format($row['TotalProduct'],2); }else{ echo number_format($row['price_total'],2); } ?>
                                บาท
                            </font>
                        </strong></td>
                </tr>
            </table>
        </div>

        <div class="tab-pane fade" id="tab3">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
                <tr class="style1">
                    <td width="100" height="23" align="center">
                        <div align="center">
                            <font size="2">เบี้ยสุทธิ</font>
                        </div>
                    </td>
                    <td width="100" align="center">
                        <div align="center">อากร</div>
                    </td>
                    <td width="100" align="center">
                        <div align="center">ภาษี</div>
                    </td>
                    <td width="100" align="center">
                        <div align="center">เบี้ยรวม</div>
                    </td>
                    <td width="100" align="center">
                        <div align="center">เบี้ยเพิ่ม</div>
                    </td>
                </tr>
                <tr>
                    <td height="23" align="center">
                        <div align="center"><strong>
                                <font size="2"><?=number_format($row['pre'],2); ?></font>
                            </strong></div>
                    </td>
                    <td height="23" align="center">
                        <div align="center"><strong>
                                <font size="2"><?=number_format($row['stamp'],2); ?></font>
                            </strong></div>
                    </td>
                    <td height="23" align="center">
                        <div align="center"><strong>
                                <font size="2"><?=number_format($row['tax'],2); ?></font>
                            </strong></div>
                    </td>
                    <td height="23" align="center">
                        <div align="center"><strong>
                                <font size="2"><?=number_format($row['net'],2); ?></font>
                            </strong></div>
                    </td>
                    <td align="center">
                        <div align="center"><strong>
                                <font size="2">
                                    <? if($row['CostProduct'] != 0.00 ) { echo number_format($row['CostProduct'],2); }else{ echo number_format($row['add_price'],2); } ?>
                                </font>
                            </strong></div>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table  table-bordered">
                <tr class="style1">
                    <td height="23" colspan="4" align="center" bgcolor="#F9F9F9"><strong>
                            <font size="2">
                                <div align="center">การชำระเงิน (กรมธรรม์)</div>
                            </font>
                        </strong></td>
                </tr>
                <tr class="style1">
                    <td width="70">ใบวางบิลกรมธรรม์</td>
                    <td width="100" height="23" bgcolor="#FFFFFF"><strong>
                            <font size="2"><?=$TxtPaymentId;?></font>
                        </strong></td>
                    <td width="50">วันที่รับชำระ</td>
                    <td width="250" bgcolor="#FFFFFF">
                        <strong>
                            <font size="2">กธ. <?=$TxtPayment; ?></font>
                        </strong>
                        <br />
                        <strong>
                            <font size="2">อท. <?=$TxtPaymentReq; ?></font>
                            <br />
                            <font size="2">
                                <? if($row2['Bank'] != ''){if($row2['Bank'] == 'VIB'){?>
                                (จ่ายที่ <?=paytype($row2['Bank']);?> เลขที่เช็ค <?=$row2['idCheck'];?> สาขา
                                <?=banktype($row2['BankCheck']);?>)
                                <? } else{ ?>
                                (จ่ายโดย <?=paytype($row2['Bank']);?> เลขที่เช็ค <?=$row2['idCheck'];?> ธนาคาร
                                <?=banktype($row2['BankCheck']);?>)
                                <? }} ?>
                            </font>
                        </strong>
                    </td>
                </tr>
                <tr class="style1">
                    <td width="70">ใบจ่ายบริษัท</td>
                    <td height="23" bgcolor="#FFFFFF"><strong>
                            <font size="2"><?=$TxtCutPayment;?></font>
                        </strong></td>
                    <td width="50">วันที่ทำจ่าย</td>
                    <td bgcolor="#FFFFFF"><strong>
                            <font size="2"><?=$TxtCutPayment_Date;?></font>
                        </strong></td>
                </tr>
            </table>
            </br>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table  table-bordered">
                <tr class="style1">
                    <td height="23" colspan="4" align="center" bgcolor="#F9F9F9"><strong>
                            <font size="2">
                                <div align="center">การชำระเงิน (พรบ.)</div>
                            </font>
                        </strong></td>
                </tr>
                <tr class="style1">
                    <td width="70">ใบวางบิล พรบ</td>
                    <td width="100" height="23" bgcolor="#FFFFFF"><strong>
                            <font size="2"><?=$TxtPaymentAct;?></font>
                        </strong></td>
                    <td width="50">วันที่รับชำระ</td>
                    <td width="250" bgcolor="#FFFFFF">
                        <strong>
                            <font size="2"><?=$TxtPaymentAct_Date?></font>
                            <br />
                            <font size="2">
                                <? if($row3['Bank'] != ''){if($row3['Bank'] == 'VIB'){?>
                                (จ่ายที่ <?=paytype($row3['Bank']);?> เลขที่เช็ค <?=$row3['idCheck'];?> สาขา
                                <?=banktype($row3['BankCheck']);?>)
                                <? } else{ ?>
                                (จ่ายโดย <?=paytype($row3['Bank']);?> เลขที่เช็ค <?=$row3['idCheck'];?> ธนาคาร
                                <?=banktype($row3['BankCheck']);?>)
                                <? }} ?>
                            </font>
                        </strong>
                    </td>
                </tr>
                <tr class="style1">
                    <td width="70">ใบจ่ายบริษัท</td>
                    <td height="23" bgcolor="#FFFFFF"><strong>
                            <font size="2"><?=$TxtCutPayment_Act;?></font>
                        </strong></td>
                    <td width="50">วันที่ทำจ่าย</td>
                    <td bgcolor="#FFFFFF"><strong>
                            <font size="2"><?=$TxtCutPayment_DateAct;?></font>
                        </strong></td>
                </tr>
            </table>

        </div>

        <!-------------------Start Tab 4 เอกสารในการจัดส่ง -------------------------->
        <div class="tab-pane fade" id="tab4">
            <form name="form_document" id="form_document" method="post">
                <div align="right" style="width:100%"><input type="hidden" id="countlist_document" value="0" />
                    <?php
$sql_send = "SELECT * From tb_send_document where id_data='".$row["id_data"]."'AND status_pre='Y' order by id DESC limit 1";	  
mysql_select_db($db1,$cndb1);
$objQuery_send = mysql_query($sql_send,$cndb1) or die ("Error Query sql_send [".$sql_send."]");
$row_send = mysql_fetch_array($objQuery_send);
?>
                    <?php
$sql_send_prb = "SELECT * From tb_send_document where id_data='".$row["id_data"]."' AND status_prb='Y' order by id DESC limit 1";	  
mysql_select_db($db1,$cndb1);
$objQuery_send_prb = mysql_query($sql_send_prb,$cndb1) or die ("Error Query sql_send_prb [".$sql_send_prb."]");
$row_send_prb = mysql_fetch_array($objQuery_send_prb);
?>
                    <?php  // if($_SESSION["s_Group"]=='VIPS' || $_SESSION["4User"]=='POT' || $_SESSION["4User"]=='JIBB' || $_SESSION["4User"]=='DA'){ ?>
                    <?php  //if($row_send["status_pre"]==''){?>
                    <!--<a  class="btn btn-small btn-danger" id="add-item_pre"> <i class="icon-plus"></i> นำส่ง กรมธรรม์ </a><?php // } ?> &nbsp;-->
                    <?php  //if($row_send_prb["status_prb"]==''){?>
                    <!--<a  class="btn btn-small btn-warning" id="add-item_prb"> <i class="icon-plus"></i> นำส่ง พ.ร.บ</a> &nbsp;-->
                    <?php // }?>
                    <!--    <a  class="btn btn-small " id="add-item_document"> <i class="icon-plus"></i> นำส่ง อื่นๆ</a> &nbsp; 
    <a  class="btn btn-small btn-info " id="add-item_document_local"> <i class="icon-plus"></i> นำส่ง เอกสารภายใน</a>-->
                    <?php //}else{ ?>
                    <!--<a  class="btn btn-small btn-info " id="add-item_document_local"> <i class="icon-plus"></i> นำส่ง เอกสารภายใน</a>-->
                    <?php // } ?>
                    <a class="btn btn-small btn-info " id="add-item_document_local"> <i class="icon-plus"></i> นำส่ง
                        เอกสารภายใน</a>
                </div>
                <table width="100%" border="0" cellpadding="0" cellspacing="0"
                    class="table table-striped table-bordered">
                    <tr class="style1">
                        <td width="250" height="23">
                            <div align="center">วันที่ส่ง</div>
                        </td>
                        <td width="80">
                            <div align="center">เลขที่นำส่ง</div>
                        </td>
                        <td>
                            <div align="center">รายละเอียด</div>
                        </td>
                        <td width="235" align="center">
                            <div align="center">ที่อยู่ </div>
                        </td>
                        <td width="60">
                            <div align="center">ผู้นำส่ง</div>
                        </td>
                    </tr>
                    <?php
$sql_send = "SELECT * From tb_send_document where id_data='".$row["id_data"]."' order by date_send DESC";	  
mysql_select_db($db1,$cndb1);
$objQuery_send = mysql_query($sql_send,$cndb1) or die ("Error Query sql_fol [".$sql_send."]");
while($row_send = mysql_fetch_array($objQuery_send))
	{
?>

                    <tr>
                        <td height="25">
                            <?=thaiDate($row_send["date_send"])?><br />
                            <?php if($row_send["status_pre"]=='Y'){?>
                            <center>
                                <a class="btn btn-success" title="" rel="tooltip" target="_blank"
                                    href="print/Print_pre_A4_suzuki.php?IDDATA=<?=$row['id_data'];?> "
                                    data-original-title="ซองA4 กธ."><i class="icon-white icon-print"></i> ซองA4 กธ.</a>
                                <a class="btn btn-success" title="" rel="tooltip" target="_blank"
                                    href="print/Print_pre_m_suzuki.php?IDDATA=<?=$row['id_data'];?> "
                                    data-original-title="ซองกลาง กธ."><i class="icon-white icon-print"></i> ซองกลาง
                                    กธ.</a>
                            </center>
                            <?php }?>
                            <?php if($row_send["status_prb"]=='Y'){?>
                            <center>
                                <a class="btn btn-success" title="" rel="tooltip" target="_blank"
                                    href="print/Print_prb_A4_suzuki.php?IDDATA=<?=$row['id_data'];?> "
                                    data-original-title="ซองA4 พ.ร.บ"><i class="icon-white icon-print"></i> ซองA4
                                    พ.ร.บ</a>
                                <a class="btn btn-success" title="" rel="tooltip" target="_blank"
                                    href="print/Print_prb_m_suzuki.php?IDDATA=<?=$row['id_data'];?> "
                                    data-original-title="ซองกลาง พ.ร.บ"><i class="icon-white icon-print"></i> ซองกลาง
                                    พ.ร.บ</a>
                            </center>
                            <?php }?>
                            <?php if($row_send["status_prb"]=='' && $row_send["status_pre"]==''){?>
                            <center>
                                <a class="btn btn-success" title="" rel="tooltip" target="_blank"
                                    href="print/Print_other_A4_suzuki.php?IDDATA=<?=$row['id_data'];?> "
                                    data-original-title="ซองA4 อื่นๆ"><i class="icon-white icon-print"></i> ซองA4
                                    อื่นๆ</a>
                                <a class="btn btn-success" title="" rel="tooltip" target="_blank"
                                    href="print/Print_other_m_suzuki.php?IDDATA=<?=$row['id_data'];?> "
                                    data-original-title="ซองกลาง อื่นๆ"><i class="icon-white icon-print"></i> ซองกลาง
                                    อื่นๆ</a>
                            </center>
                            <?php }?>
                        </td>
                        <td><?=$row_send["send_no"]?></td>
                        <td><?=$row_send["detail"]?></td>
                        <td><?=$row_send["address"]?></td>
                        <td><?=$row_send["login_emp"]?></td>
                    </tr>
                    <?php }?>
                    <tbody id="selectlist_document"></tbody>
                </table>


                <a class="btn btn-small " id="add-item"> <i class="icon-plus"></i> เพิ่มรายการ</a>

                <table width="100%" border="0" cellpadding="0" cellspacing="0"
                    class="table table-striped table-bordered">
                    <tr class="style1">
                        <td width="80" height="23">
                            <div align="center">วันที่ติดตาม</div>
                        </td>
                        <td width="80">
                            <div align="center">เวลา</div>
                        </td>
                        <td width="80">
                            <div align="center">วันที่นัดชำระ</div>
                        </td>
                        <td>
                            <div align="center">รายละเอียด</div>
                        </td>
                        <td width="60">
                            <div align="center">ผู้ติดตาม</div>
                        </td>
                    </tr>
                    <?php
$sql_fol = "SELECT * From tb_follow_customer where id_data='".$row["id_data"]."' ";   
mysql_select_db($db2,$cndb2);
$objQuery_fol = mysql_query($sql_fol,$cndb2) or die ("Error Query sql_fol [".$sql_fol."]");
while($row_fol = mysql_fetch_array($objQuery_fol))
  {
?>

                    <tr>
                        <td height="23"><?=thaiDate($row_fol["date_fol"])?></td>
                        <td><?=Showtime($row_fol["date_appointment"])?> น.</td>
                        <td><?=thaiDate($row_fol["date_appointment"])?></td>
                        <td><?=$row_fol["detail_fol"]?></td>
                        <td><?=$row_fol["login_emp"]?></td>
                    </tr>
                    <?php }?>
                    <tbody id="selectlist"></tbody>
                </table>

                <script>
                $("#add-item_pre").click(function(event) {

                            var listcount_document = document.getElementById("countlist_document").value;


                            listcount_document++;


                            $('#selectlist_document').append('<tr><td width="80" height="23" ><input name="txt_status" type="hidden" class="span2" id="txt_status"  style="width:80px;" value="pre"  /><input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']; ?>"  /><input name="txt_date" type="text" class="span2" id="txt_date"  style="width:90px;" value="<?=date('d/m/Y')?>" readonly/></td><td width="80" ><input name="txt_sendno" type="text" class="span2" id="txt_sendno"  style="width:110px;"  placeholder="เลขที่นำส่ง" value = ""/></td><td width="230" ><textarea name="txt_detail" id="txt_detail" style="width:230px;" placeholder="เลขที่แจ้งงาน" required="required"><?=$row['id_data']; ?></textarea></td><td width="235" ><textarea name="txt_address" id="txt_address" style="width:235px;" placeholder="ที่อยู่" required="required"><?php 
					$address_pdf = $row['add'];
					if($row['group'] !="-" && $row['group'] !="")
					{
						$address_pdf .= " หมู่ ".$row['group'];
					}
					if($row['town'] != "-" && $row['town'] !="")
					{
						$address_pdf .= " ".$row['town'];
					}
					if($row['lane'] !="-" && $row['lane'] !="")
					{
						$address_pdf .= " ซอย".$row['lane'];
					}
					if($row['road'] !="-" && $row['road'] !="")
					{
						$address_pdf .= " ถนน".$row['road'];
					}
					if($row['province'] != "102"){
						$address_pdf .= ' ต.'.$row['tumbon_name'].' อ.'.$row['amphur_name'].' จ.'.$row['province_name'];
					}
					else{
						$address_pdf .= ' แขวง'.$row['tumbon_name'].' เขต'.$row['amphur_name'].' '.$row['province_name'];
					}
						$address_pdf .= ' '.$row['postal'];				

					$ShowReq .= $row['Cus_add']; 
					if($row['Cus_group'] !="-" && $row['Cus_group'] !=""){
						$ShowReq .= " หมู่ ".$row['Cus_group'];
					}
					if($row['Cus_town'] !="-" && $row['Cus_town'] !=""){
						$ShowReq .= " ".$row['Cus_town'];
					}
					if($row['Cus_lane'] !="-" && $row['Cus_lane'] !=""){
						$ShowReq .= " ซอย".$row['Cus_lane'];
					}
					if($row['Cus_road'] !="-"){
						$ShowReq .= " ถนน".$row['Cus_road'];
					}
					if($row1['Cus_province'] != "102"){
						$ShowReq .= " ต.".$row1['tumbon']." อ.".$row1['amphur']." จ.".$row1['province']." ".$row['Cus_postal']; 
					}else{
						$ShowReq .= " แขวง".$row1['tumbon']." เขต.".$row1['amphur']." ".$row1['province']." ".$row['Cus_postal'];
					}
						$ShowReq .= ' '.$row1['Cus_postal'];
						
					if($row['SendAdd'] !='')
					{
						$SendAdd = $row['SendAdd'];
					}
						
					if($row['EditCustomer'] != ''){ echo $ShowReq; }if($row['SendAdd'] !=''){ echo $SendAdd; }else{ echo $address_pdf;}
                ?> <
                                /textarea></td > << td width = "14%" > < button class = "btn btn-small btn-success"
                                id = "save_document"
                                type = "button" > บั นทึก กรรมธรรม์ < /button></td > < /tr>');

                                $('#countlist_document').val(listcount_document);



                                $("#save_document").click(function() {
                                    if ($("#txt_sendno").val() == '') {
                                        $("#txt_sendno").focus();
                                        alert('กรุณากรอกเลขที่นำส่ง');
                                        return false;
                                    }

                                    var DATA = $('#form_document').serialize();
                                    var options = {
                                        type: "POST",
                                        dataType: "json",
                                        url: "ajax/Save_Checklist_Suzuki_Document.php",
                                        data: DATA,
                                        success: function(msg) {
                                            var returnedArray = msg;
                                            if (returnedArray.status == true) {
                                                $("#form_document")[0].reset();
                                                $("#closed").click();
                                                alert(returnedArray.msg);

                                                $(".modal").hide();
                                                $(".modal-backdrop").hide();
                                                $(".modal").removeData('modal');

                                            } else {
                                                alert(returnedArray.msg);

                                            }
                                        }
                                    };
                                    $.ajax(options);

                                });

                            });
                </script>

                <script>
                $("#add-item_prb").click(function(event) {

                            var listcount_document = document.getElementById("countlist_document").value;


                            listcount_document++;


                            $('#selectlist_document').append('<tr><td width="80" height="23" ><input name="txt_status" type="hidden" class="span2" id="txt_status"  style="width:80px;" value="prb"  /><input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']; ?>"  /><input name="txt_date" type="text" class="span2" id="txt_date"  style="width:90px;" value="<?=date('d/m/Y')?>" readonly/></td><td width="80" ><input name="txt_sendno" type="text" class="span2" id="txt_sendno"  style="width:110px;"  placeholder="เลขที่นำส่ง" value = ""/></td><td width="230" ><textarea name="txt_detail" id="txt_detail" style="width:230px;" placeholder="เลขที่แจ้งงาน" required="required"><?=$row['id_data']; ?></textarea></td><td width="235" ><textarea name="txt_address" id="txt_address" style="width:235px;" placeholder="ที่อยู่" required="required"><?php 
					$address_pdf = $row['add'];
					if($row['group'] !="-" && $row['group'] !="")
					{
						$address_pdf .= " หมู่ ".$row['group'];
					}
					if($row['town'] != "-" && $row['town'] !="")
					{
						$address_pdf .= " ".$row['town'];
					}
					if($row['lane'] !="-" && $row['lane'] !="")
					{
						$address_pdf .= " ซอย".$row['lane'];
					}
					if($row['road'] !="-" && $row['road'] !="")
					{
						$address_pdf .= " ถนน".$row['road'];
					}
					
					if($row['province'] != "102"){
						$address_pdf .= ' ต.'.$row['tumbon_name'].' อ.'.$row['amphur_name'].' จ.'.$row['province_name'];
					}
					else{
						$address_pdf .= ' แขวง'.$row['tumbon_name'].' เขต'.$row['amphur_name'].' '.$row['province_name'];
					}
						$address_pdf .= ' '.$row['postal'];				

					$ShowReq .= $row['Cus_add']; 
					if($row['Cus_group'] !="-" && $row['Cus_group'] !=""){
						$ShowReq .= " หมู่ ".$row['Cus_group'];
					}
					if($row['Cus_town'] !="-" && $row['Cus_town'] !=""){
						$ShowReq .= " ".$row['Cus_town'];
					}
					if($row['Cus_lane'] !="-" && $row['Cus_lane'] !=""){
						$ShowReq .= " ซอย".$row['Cus_lane'];
					}
					if($row['Cus_road'] !="-"){
						$ShowReq .= " ถนน".$row['Cus_road'];
					}
					if($row1['Cus_province'] != "102"){
						$ShowReq .= " ต.".$row1['tumbon']." อ.".$row1['amphur']." จ.".$row1['province']." ".$row['Cus_postal']; 
					}else{
						$ShowReq .= " แขวง".$row1['tumbon']." เขต.".$row1['amphur']." ".$row1['province']." ".$row['Cus_postal'];
					}
						$ShowReq .= ' '.$row1['Cus_postal'];
					
					if($row['SendAdd'] !='')
					{
						$SendAdd = $row['SendAdd'];
					}
						
					if($row['EditCustomer'] != ''){ echo $ShowReq; }else if($row['SendAdd'] !=''){ echo $SendAdd; }else{ echo $address_pdf;}	
                ?> <
                                /textarea></td > << td width = "14%" > < button class = "btn btn-small btn-success"
                                id = "save_document"
                                type = "button" > บั นทึก พ.ร.บ < /button></td > < /tr>');

                                $('#countlist_document').val(listcount_document);



                                $("#save_document").click(function() {
                                    if ($("#txt_sendno").val() == '') {
                                        $("#txt_sendno").focus();
                                        alert('กรุณากรอกเลขที่นำส่ง');
                                        return false;
                                    }

                                    var DATA = $('#form_document').serialize();
                                    var options = {
                                        type: "POST",
                                        dataType: "json",
                                        url: "ajax/Save_Checklist_Suzuki_Document.php",
                                        data: DATA,
                                        success: function(msg) {
                                            var returnedArray = msg;
                                            if (returnedArray.status == true) {
                                                $("#form_document")[0].reset();
                                                $("#closed").click();
                                                alert(returnedArray.msg);

                                                $(".modal").hide();
                                                $(".modal-backdrop").hide();
                                                $(".modal").removeData('modal');

                                            } else {
                                                alert(returnedArray.msg);

                                            }
                                        }
                                    };
                                    $.ajax(options);

                                });

                            });
                </script>

                <script>
                function SaveDocumentLocal(prmTrID) {
                    if ($("#department").val() == 'N') {
                        $("#department").focus();
                        alert('กรุณาเลือกแผนก');
                        return false;
                    } else if ($("#txt_employee").val() == 'N') {
                        $("#txt_employee").focus();
                        alert('กรุณาเลือกพนักงานที่รับเอกสาร');
                        return false;
                    }
                    var _tr = $(prmTrID);
                    var dataDocumentLocal = {
                        'txt_iddata': _tr.find('input[name="id_data"]').val(),
                        'txt_status': 'loc',
                        'txt_sendno': _tr.find('input[name="txt_sendno"]').val(),
                        'txt_detail': _tr.find('textarea[name="txt_detail"]').val(),
                        'txt_address': _tr.find('select[name="txt_department"]').val(),
                        'txt_employee': _tr.find('select[name="txt_employee"]').val()
                    };
                    var options = {
                        type: "POST",
                        dataType: "json",
                        url: "ajax/Save_Checklist_Suzuki_Document.php",
                        data: dataDocumentLocal,
                        success: function(msg) {
                            var returnedArray = msg;
                            if (returnedArray.status == true) {
                                $("#form_document")[0].reset();
                                $("#closed").click();
                                alert(returnedArray.msg);
                                $(".modal").hide();
                                $(".modal-backdrop").hide();
                                $(".modal").removeData('modal');
                            } else {
                                alert(returnedArray.msg);
                            }
                        }
                    };
                    $.ajax(options);
                }
                $('#add-item_document_local').click(function(e) {
                    var lcd = $('#countlist_document');
                    var lcdv = lcd.val();
                    lcdv++;
                    var _tempHtml = "";
                    var _tempHtml = "";
                    _tempHtml += "<tr id=\"dl" + lcdv + "\">";
                    _tempHtml += "	<td width=\"80\" height=\"23\">";
                    _tempHtml +=
                    "		<input type=\"hidden\" name=\"id_data\" value=\"<?=$row['id_data']; ?>\" />";
                    _tempHtml += "		<input type=\"hidden\" name=\"send_local_document\" value=\"1\" \/>";
                    _tempHtml +=
                        "		<input name=\"txt_date\" type=\"text\" class=\"span2\" style=\"width:90px;\" value=\"<?php echo date('d/m/Y'); ?>\" readonly=\"\" \/><\/td>";
                    _tempHtml += "	<td width=\"80\">";
                    <?php
	$id_data_arr = explode("/", $row['id_data']);
	?>
                    _tempHtml +=
                        "		<input name=\"txt_sendno\" type=\"text\" class=\"span2\" id=\"txt_sendno\" style=\"width:110px;\" placeholder=\"เลขที่นำส่ง\" readonly=\"readonly\" value=\"<?php echo $id_data_arr[0].'-'.$id_data_arr[2];?>\" \/>";
                    _tempHtml += "	<\/td>";
                    _tempHtml += "	<td width=\"230\">";
                    _tempHtml +=
                        "		<textarea name=\"txt_detail\" id=\"txt_detail\" style=\"width:230px;\" placeholder=\"รายละเอียด\" required=\"required\"><\/textarea>";
                    _tempHtml += "	<\/td>";
                    _tempHtml += "	<td width=\"235\">";
                    _tempHtml += "		<select name=\"txt_department\" id=\"department\" style=\"width:230px;\">";
                    _tempHtml += "			<option value=\"N\">-- เลือกแผนก --<\/option>";
                    <?php
	mysql_select_db($db_hr,$cndb_hr);
	$departments = mysql_query('SELECT * FROM department', $cndb_hr);
	while ( $department = mysql_fetch_array($departments)){
	?>
                    _tempHtml +=
                        "			<option value=\"<?php echo $department['DepartmentName_TH']; ?>\"><?php echo $department['DepartmentName_TH']; ?><\/option>";
                    <?php } ?>
                    _tempHtml += "		<\/select>";

                    _tempHtml += "		<select name=\"txt_employee\" id=\"txt_employee\" style=\"width:230px;\">";
                    _tempHtml += "			<option value=\"-- ไม่ได้เลือก --\">-- เลือกพนักงาน --<\/option>";
                    _tempHtml += "		<\/select>";

                    _tempHtml += "	<\/td>";
                    _tempHtml += "	<td width=\"14%\">";
                    _tempHtml +=
                        "		<button class=\"btn btn-small btn-success\" onclick=\"SaveDocumentLocal('#dl" +
                        lcdv + "')\" type=\"button\">บันทึก<\/button>";
                    _tempHtml += "		<\/td>";
                    _tempHtml += "<\/tr>";
                    $('#selectlist_document').append(_tempHtml);
                    lcd.val(lcdv);

                    $("#department").change(function() {
                        var _selected = $("#department").val();
                        //console.log(_selected);

                        var options = {
                            type: "POST",
                            dataType: "json",
                            url: "ajax/Ajax_employee.php",
                            data: {
                                callajax: 'EMP',
                                emp: _selected,
                            },
                            success: function(msg) {
                                var returnedArray = msg;
                                $('#txt_employee').empty();
                                txt_employee = $("#txt_employee");
                                txt_employee.append(
                                    "<option value='N'>---กรุณาเลือกพนักงาน---</option>");
                                if (returnedArray != null) {
                                    for (i = 0; i < returnedArray.length; i++) {
                                        txt_employee.append("<option value='" + returnedArray[i]
                                            .ID_EMP + "'>" + returnedArray[i].emp_name +
                                            "</option>");
                                    }
                                } else {
                                    return false;
                                }
                            }
                        };
                        $.ajax(options);
                    });

                });

                //
                $("#add-item_document").click(function(event) {


                            var listcount_document = document.getElementById("countlist_document").value;


                            listcount_document++;


                            $('#selectlist_document').append('<tr><td width="80" height="23" ><input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']; ?>"  /><input name="txt_date" type="text" class="span2" id="txt_date"  style="width:90px;" value="<?=date('d/m/Y')?>" readonly/></td><td width="80" ><input name="txt_sendno" type="text" class="span2" id="txt_sendno"  style="width:110px;"  placeholder="เลขที่นำส่ง" value = ""/></td><td width="230" ><textarea name="txt_detail" id="txt_detail" style="width:230px;" placeholder="รายละเอียด" required="required"></textarea></td><td width="235" ><textarea name="txt_address" id="txt_address" style="width:235px;" placeholder="ที่อยู่" required="required"><?php 
					$address_pdf = $row['add'];
					if($row['group'] !="-" && $row['group'] !="")
					{
						$address_pdf .= " หมู่ ".$row['group'];
					}
					if($row['town'] != "-" && $row['town'] !="")
					{
						$address_pdf .= " ".$row['town'];
					}
					if($row['lane'] !="-" && $row['lane'] !="")
					{
						$address_pdf .= " ซอย".$row['lane'];
					}
					if($row['road'] !="-" && $row['road'] !="")
					{
						$address_pdf .= " ถนน".$row['road'];
					}
					
					if($row['province'] != "102"){
						$address_pdf .= ' ต.'.$row['tumbon_name'].' อ.'.$row['amphur_name'].' จ.'.$row['province_name'];
					}
					else{
						$address_pdf .= ' แขวง'.$row['tumbon_name'].' เขต'.$row['amphur_name'].' '.$row['province_name'];
					}
						$address_pdf .= ' '.$row['postal'];				

					$ShowReq .= $row['Cus_add']; 
					if($row['Cus_group'] !="-" && $row['Cus_group'] !=""){
						$ShowReq .= " หมู่ ".$row['Cus_group'];
					}
					if($row['Cus_town'] !="-" && $row['Cus_town'] !=""){
						$ShowReq .= " ".$row['Cus_town'];
					}
					if($row['Cus_lane'] !="-" && $row['Cus_lane'] !=""){
						$ShowReq .= " ซอย".$row['Cus_lane'];
					}
					if($row['Cus_road'] !="-"){
						$ShowReq .= " ถนน".$row['Cus_road'];
					}
					if($row1['Cus_province'] != "102"){
						$ShowReq .= " ต.".$row1['tumbon']." อ.".$row1['amphur']." จ.".$row1['province']." ".$row['Cus_postal']; 
					}else{
						$ShowReq .= " แขวง".$row1['tumbon']." เขต.".$row1['amphur']." ".$row1['province']." ".$row['Cus_postal'];
					}
						$ShowReq .= ' '.$row1['Cus_postal'];
					
					if($row['SendAdd'] !='')
					{
						$SendAdd = $row['SendAdd'];
					}
						
					if($row['EditCustomer'] != ''){ echo $ShowReq; }else if($row['SendAdd'] !=''){ echo $SendAdd; }else{ echo $address_pdf;}	
						
                ?> <
                                /textarea></td > << td width = "14%" > < button class = "btn btn-small btn-success"
                                id = "save_document"
                                type = "button" > บั นทึก < /button></td > < /tr>');

                                $('#countlist_document').val(listcount_document);



                                $("#save_document").click(function() {
                                    if ($("#txt_sendno").val() == '') {
                                        $("#txt_sendno").focus();
                                        alert('กรุณากรอกเลขที่นำส่ง');
                                        return false;
                                    }

                                    var DATA = $('#form_document').serialize();
                                    var options = {
                                        type: "POST",
                                        dataType: "json",
                                        url: "ajax/Save_Checklist_Suzuki_Document.php",
                                        data: DATA,
                                        success: function(msg) {
                                            var returnedArray = msg;
                                            if (returnedArray.status == true) {
                                                $("#form_document")[0].reset();
                                                $("#closed").click();
                                                alert(returnedArray.msg);

                                                $(".modal").hide();
                                                $(".modal-backdrop").hide();
                                                $(".modal").removeData('modal');

                                            } else {
                                                alert(returnedArray.msg);

                                            }
                                        }
                                    };
                                    $.ajax(options);

                                });

                            });

                        $("#load_renew").click(function() {
                            $(".modal").hide();
                            $(".modal-backdrop").hide();
                            $(".modal").removeData('modal');

                            $("#page-content").load("pages/renew_suzuki_seleect.php?id=" +
                            '<?=$row['id_data']; ?>');

                        });
                </script>
            </form>
        </div>

        <!------------------- END Tab 4 เอกสารในการจัดส่ง -------------------------->


    </div>


</body>

</html>