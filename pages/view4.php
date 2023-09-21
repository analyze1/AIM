<?php ini_set('display_errors', 0);
        include "check-ses.php"; 
	//include "../inc/checksession.inc.php";
	include "../inc/connectdbs.inc.php"; 
	
	function thaiDate($datetime)
	{
		list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
		list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
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
		list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
		list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
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
	
	function Showtime($datetime)
	{
		list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
		list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
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
	
	function Func_statusFol($statusFol) 
    {
		switch($statusFol) 
        {
            case "FL-F": $statusFol = "ติดตาม (feed)"; break;
            case "FL": $statusFol = "ติดตาม"; break;
            case "SS": $statusFol = "ปิดงาน"; break;
            case "SS-F": $statusFol = "ปิดงาน (feed)"; break;
			case "CN": $statusFol = "ไม่ต่อ"; break;
            case "CN-F": $statusFol = "ไม่ต่อ (feed)"; break;
        }
        return $statusFol;
    }

    $year_today=date("Y");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap-responsive.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/Font-awesome/css/font-awesome.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/css/style.css"/>
    <!--- <link id="active-theme" type="text/css" rel="stylesheet" href="assets/css/default.min.css"/> ---->
    <style type="text/css">
    .style1 {font-size: 12px; color:#333;}

    </style>
   <script type="text/javascript" src="assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
 	<script type="text/javascript" src="js/jquery.imask.js"></script>
    <script type="text/javascript" src="js/jquery.maskedinput-1.2.2.js"></script>

 	<script type="text/javascript" src="assets/js/bootstrap-tooltip.js"></script>
    
    
 <link type="text/css" rel="stylesheet" href="assets/css/datepicker.css">  



<script>
$('#txt_tel1').mask("9999999999");
$('#txt_tel2').mask("9999999999");
$('#txt_tel3').mask("9999999999");

$('#txt_claim').iMask({
    type : 'number'
});

// เบี้ยต่ออายุ
$('#inp_cost').iMask({
    type : 'number'
});
$('#inp_pre').iMask({
    type : 'number'
});
$('#inp_net').iMask({
    type : 'number'
});






function checkText()
{
	var elem = document.getElementById('txt_sendno').value;
	if(!elem.match(/^([a-z0-9\_])+$/i))
	{
		alert("ห้ามพิมพ์ภาษาไทย นะจ๊ะ!!!");
		document.getElementById('txt_sendno').value = "";
	}
}
</script>

<title>Untitled Document</title>

<style type="text/css">
/*
.nav-tabs > li > a {
    background: #F5F5F5;
    border-radius: 0;
    box-shadow: inset 0 -8px 7px -9px rgba(0,0,0,.3),-2px -2px 5px -2px rgba(0,0,0,.3);
}
.nav-tabs > li.active > a,
.nav-tabs > li.active > a:hover {
    background: #FFFFFF;
    box-shadow: inset 0 0 0 0 rgba(0,0,0,.4),-2px -3px 5px -2px rgba(0,0,0,.4);
}


.tab-pane {
    background: #FFFFFF;
    box-shadow: 0 0 0px rgba(0,0,0,.4);
    border-radius: 0;
    text-align: center;
    padding: 10px;
}
*/

.cs_title{
	color: #6E6E6E;
	 line-height:normal;
	 font-size:93%;

}
input{
	color: #990000;
	font-weight: bold;;
}

</style>

<style type="text/css">

/*- Menu Tabs--------------------------- */

    #tabs {
      float:left;
      min-width:935px;
     /* background:#003366  ;*/
      	background: -webkit-linear-gradient(#000000, #4c4c4c); /* For Safari 5.1 to 6.0 */
    	background: -o-linear-gradient(#000000, #4c4c4c); /* For Opera 11.1 to 12.0 */
   	 	background: -moz-linear-gradient(#000000, #4c4c4c); /* For Firefox 3.6 to 15 */
   	 	background: linear-gradient(#000000, #4c4c4c); /* Standard syntax (must be last) */
      font-size:93%;
      line-height:normal;

      }
    #tabs ul {
        margin:0;
        padding:5px 10px 0 5px;
        list-style:none;
      }
    #tabs li {
      display:inline;
      margin:0;
      padding:0;
      }
    #tabs a {
      float:left;
      background:url("icon/tableft.gif") no-repeat left top;
      margin:0;
      padding:0 0 0 4px;
      text-decoration:none;

      }
    #tabs a span {
      float:left;
      display:block;
      background:url("icon/tabright.gif") no-repeat right top;
      padding:5px 15px 4px 6px;
      color:#666;
      }
    /* Commented Backslash Hack hides rule from IE5-Mac \*/
    #tabs a span {float:none;}
    /* End IE5-Mac hack */
    #tabs a:hover span {
      color:#FF9834;
      }
    #tabs a:hover {
      background-position:0% -42px;
      }
    #tabs a:hover span {
      background-position:100% -42px;
      }

        #tabs #current a {
                background-position:0% -42px;
        }
        #tabs #current a span {
                background-position:100% -42px;
        }

     #tabs ul li.active a {
      background-position:0% -42px;
      color:#FF9834;
      font-weight: bold;
      }

	#tabs ul li.active a span {
      float:left;
      display:block;
      background:url("icon/tabright.gif") no-repeat right top;
      background-position:0% -42px;
      padding:5px 15px 4px 6px;
      color:#FF9834;
      }
     #tabs .texthead {
     color: #C0C0C0;
     height: 80px;
      margin-top: 0px;
     }
      #tabs .texthead h1{
      	margin-left: 50px ;
      	 text-shadow: 1px 1px 1px #000000;
      	 font-size: 20px;
      }
       #tabs .texthead h2{
      	margin-left: 50px ;
      	margin-top: -25px;
      	padding-bottom: 0px;
      	 text-shadow: 1px 1px 1px #000000;
      	 font-size: 16px;
      }
       #tabs .texthead h3{
       float: right;
       margin-top: -65px;
       margin-right: 10px;
      	 text-shadow: 1px 1px 1px #000000;
      	 font-size: 14px;
      }
      #tabs .texthead h4{
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
	$query .= "data.doc_type,";
	$query .= "data.login, "; // รหัสผู้แจ้ง
	$query .= "tb_comp.sort,";
	$query .= "tb_comp.name_print, "; // บริษัทประกันภัย
	$query .= "tb_comp.name as comp_name, "; // บริษัทประกันภัย
	$query .= "tb_comp.tel  as comp_tel, "; // เบอร์โทรศัพท์(แจ้งอุบัติเหตุ)
	$query .= "data.service, "; // ประเภทการซ่อม
	
	$query .= "data.list_customer1, ";
	$query .= "data.list_customer2, ";
	$query .= "data.list_customer3, ";
	$query .= "data.list_customer4, ";
	$query .= "data.list_customer5, ";
	$query .= "data.pay_date, ";
	$query .= "data.list_customer, ";
	$query .= "data.pay_file, ";
	
	$query .= "tb_user.sub as branch, "; // สาขา
	$query .= "tb_user.contact, "; // ชื่อผู้แจ้ง
	$query .= "tb_user.cus_add, "; // บ้านเลขที่
	$query .= "tb_user.cus_group, "; // หมู่
	$query .= "tb_user.cus_town, "; //อาคาร/หมู่บ้าน
	$query .= "tb_user.cus_lane, "; // ซอย
	$query .= "tb_user.cus_road, "; // ถนน
	$query .= "tb_user.cus_tumbon, "; // ตำบล คีย์
	$query .= "tb_user.cus_amphur, "; // อำเภอ คีย์
	$query .= "tb_user.cus_province, "; // จังหวัด คีย์
	$query .= "tb_user.cus_postal , "; // รหัสไปรษณีย์
	
	$query .= "data.send_date,   "; // วันที่แจ้ง
	$query .= "data.name_inform, "; // รหัสผู้แจ้ง
	$query .= "data.id_data, "; // เลขที่รับแจ้ง
	$query .= "data.o_insure, "; // เลขที่กรมธรรมเดิม
	$query .= "data.ty_inform, "; // ประเภทงาน
	$query .= "data.idagent, "; //รหัสตัวแทน
	$query .= "data.start_date, "; // วันที่คุ้มครอง	
	$query .= "data.end_date, "; // วันที่สิ้นสุด
	$query .= "data.name_gain, "; // ชื่อผู้รับผลประโยชน์
	$query .= "data.q_auto, ";
	$query .= "data.login, ";
	$query .= "data.pay_file, ";

	//////////////////////////////////////////
	$query .= "insuree.title, "; // คำนำหน้า ชื่อผู้เอาประกัน
	$query .= "insuree.name,  "; // ชื่อผู้เอาประกัน
	$query .= "insuree.last, "; // นามสกุลผู้เอาประกัน
	$query .= "insuree.career, "; // นามสกุลผู้เอาประกัน
	$query .= "insuree.SendAdd, ";
	$query .= "insuree.add, "; // บ้านเลขที่
	$query .= "insuree.vocation, ";
	$query .= "insuree.icard, ";
	$query .= "insuree.group, "; // หมู่
	$query .= "insuree.town, "; //อาคาร/หมู่บ้าน
	$query .= "insuree.lane, "; // ซอย
	$query .= "insuree.road, "; // ถนน
	$query .= "insuree.tumbon, "; // ตำบล คีย์
	$query .= "insuree.amphur, "; // อำเภอ คีย์
	$query .= "insuree.province, "; // จังหวัด คีย์
	$query .= "insuree.postal, "; // รหัสไปรษณีย์
	$query .= "insuree.tel_mobile, "; // เบอร์โทร
	$query .= "insuree.tel_mobile2, "; // เบอร์โทร	
	$query .= "insuree.tel_mobile3, "; // เบอร์โทร	
	$query .= "insuree.tel_home, "; // เบอร์โทร
	$query .= "insuree.tel_home2, "; // เบอร์โทร
	$query .= "insuree.tel_fax, "; // เบอร์โทร
	$query .= "insuree.tel_fax2, "; // เบอร์โทร
	$query .= "insuree.email, "; // Email
	$query .= "insuree.email2, "; // Email
	$query .= "insuree.email_cc, "; // Email_cc
	$query .= "insuree.claim_amount, "; // 
	$query .= "insuree.policy_amount, "; // 
	$query .= "insuree.id_line, "; // 
	$query .= "insuree.id_line2, "; //
	$query .= "insuree.status_company_time, "; //
	$query .= "insuree.status_company, "; //



	$query .= "tb_tumbon.name as tumbon_name, "; 
	$query .= "tb_amphur.name as amphur_name, "; 
	$query .= "tb_province.name as province_name, "; // จังหวัด
	$query .= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
	$query .= "tb_br_car.name as car_brand, "; // ยี่ห้อรถ
	$query .= "tb_cat_car.name as cat_car_name, "; // ประเภทรถ
	$query .= "tb_mo_car.name as mo_car_name, "; // รุ่นรถ
	
	$query .= "detail.id_data_company, ";
	$query .= "detail.company_date, ";
	$query .= "detail.company_user, ";
	$query .= "detail.policy_robbery, ";
	$query .= "detail.robbery_date, ";
	$query .= "detail.robbery_user, ";
	$query .= "detail.car_color, "; // สีรถ
	$query .= "detail.cc, "; // ซี ซ
	$query .= "detail.car_wg, "; // น.น.
	$query .= "detail.car_regis, "; // ทะเบียนรถ
	$query .= "detail.car_regis_pro, "; // ทะเบียนรถ
	$query .= "detail.car_body, "; // เลขตัวถัง
	$query .= "detail.regis_date, "; // ปีที่จดทะเบียน
	$query .= "detail.n_motor, "; // เลขเครื่อง
	$query .= "detail.Cancel_policy, ";
	$query .= "detail.Cancel_policy2, ";
	$query .= "detail.status_policy_time, ";
	$query .= "detail.cost_renew, ";
	$query .= "detail.pre_renew, ";
	$query .= "detail.net_renew, ";
	
	$query .= "premium.id, ";
	$query .= "premium.id_data, ";
	$query .= "premium.pre, "; // เบี้ยสุทธิ
	$query .= "premium.one, "; // ส่วนแรก
	$query .= "premium.driver, "; // ส่วนลดระบุผู้ขับขี่
	$query .= "premium.dis1, "; // ส่วนลดระบุผู้ขับขี่
	$query .= "premium.good, "; // ส่วนลดประวัติดี
	$query .= "premium.dis2, "; // ส่วนลดระบุผู้ขับขี่
	$query .= "premium.group3, "; // ส่วนลดประวัติดี
	$query .= "premium.dis_group3, "; // ส่วนลดประวัติดี
	$query .= "premium.pro_dis, "; // ส่วนลดพิเศษ
	$query .= "premium.total_pro_dis, "; // ส่วนลดพิเศษ
	$query .= "premium.total_pre, "; // เบี้ยสิทธิ หักส่วนลด
	$query .= "premium.total_stamp, "; // รวม อากร
	$query .= "premium.total_vat, "; // รวม ภาษี
	$query .= "premium.prb, "; // เบี้ย พ.ร.บ.
	$query .= "premium.total_prb, "; // เบี้ยรวม พ.ร.บ.
	$query .= "premium.total_sum, "; // เบี้ยรวม
	$query .= "premium.other, "; // เบี้ยรวม
	$query .= "premium.vat_1, "; // หัก ณ ที่จ่าย
	$query .= "premium.commition, "; // ส่วนลดเป็นบาท
	$query .= "premium.total_commition, "; // ยอดชำระ
	
	$query .= "premium.pre_old, ";
	$query .= "premium.one_old, ";
	$query .= "premium.disone_old, ";
	$query .= "premium.driver_old, ";
	$query .= "premium.dis1_old, ";
	$query .= "premium.good_old, ";
	$query .= "premium.dis2_old, ";
	$query .= "premium.group3_old, ";
	$query .= "premium.dis_group3_old, ";
	$query .= "premium.pro_dis_old, ";
	$query .= "premium.total_pro_dis_old, ";
	$query .= "premium.dis3_old, ";
	$query .= "premium.dis_vip_old, ";
	$query .= "premium.total_vip_old, ";
	$query .= "premium.total_dis4_old, ";
	$query .= "premium.total_pre_old, ";
	$query .= "premium.total_stamp_old, ";
	$query .= "premium.total_vat_old, ";
	$query .= "premium.total_sum_old, ";
	$query .= "premium.prb_old, ";
	$query .= "premium.total_prb_old, ";
	$query .= "premium.commition_old, ";
	$query .= "premium.other_old, ";
	$query .= "premium.vat_1_old, ";
	$query .= "premium.total_commition_old, ";
	$query .= "premium.editing, ";
	
	$query .= "protect.id, "; 
	$query .= "protect.cost, "; // ยอดชำระ
	$query .= "protect.damage_out1, ";
	$query .= "protect.damage_cost, ";
	$query .= "protect.pa1, ";
	$query .= "protect.pa2, ";
	$query .= "protect.pa3, ";
	$query .= "protect.pa4, ";
	$query .= "protect.people, ";
	
	$query .= "protect.cost_old, "; // ยอดชำระ
	$query .= "protect.damage_out1_old, ";
	$query .= "protect.damage_cost_old, "; 
	$query .= "protect.pa1_old, ";
	$query .= "protect.pa2_old, ";  
	$query .= "protect.pa3_old, "; 
	$query .= "protect.pa4_old, "; 
	$query .= "protect.people_old, ";
	
	$query .= "tb_agent.id_agent, ";
	$query .= "tb_agent.full_name, ";
	$query .= "tb_agent.agent_dis, ";
	
	$query .= "tb_agent.Dealer_contact, ";
	$query .= "tb_agent.Dealer_tel, ";
	$query .= "tb_agent.Dealer_fax, ";
	$query .= "tb_agent.Dealer_mail, ";
	$query .= "tb_agent.Dealer_contact2, ";
	$query .= "tb_agent.Dealer_tel2, ";
	$query .= "tb_agent.Dealer_fax2, ";
	$query .= "tb_agent.Dealer_mail2, ";
	$query .= "tb_agent.Dealer_bill, ";
	$query .= "tb_agent.Dealer_pay, ";
	
	//กรณีระบุชื่อผู้ขับขี่
	$query .= "driver.title_num1, "; // ผู้ขับขี่ที่ 1
	$query .= "driver.name_num1, ";
	$query .= "driver.last_num1, ";
	$query .= "driver.birth_num1, "; // วัน/เดือน/ปี (วันเกิด)
	$query .= "driver.title_num2, "; // ผู้ขับขี่ที่ 2
	$query .= "driver.name_num2, ";
	$query .= "driver.last_num2, ";
	$query .= "driver.birth_num2, "; // วัน/เดือน/ปี (วันเกิด)

	$query .= "act.act_id, ";
	$query .= "tb_user.Email,";
	$query .= "tb_user.Email2,";
	$query .= "tb_user.Email3,";
	$query .= "tb_user.Email4,";
	$query .= "tb_user.Email5 ";
	
	$query .= "FROM data ";
	
	$query .= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
	$query .= "INNER JOIN driver ON (driver.id_data = data.id_data)  ";
	$query .= "INNER JOIN service ON (data.id_data = service.id_data) ";
	$query .= "INNER JOIN premium ON (data.id_data = premium.id_data) ";
	$query .= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
	$query .= "INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
	$query .= "INNER JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
	$query .= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
	$query .= "INNER JOIN act ON (act.id_data = data.id_data)  ";
	$query .= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";	
	$query .= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
	$query .= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
	$query .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
	$query .= "INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
	$query .= "INNER JOIN tb_province ON (tb_province.id = insuree.province) ";
	$query .= "INNER JOIN tb_user ON (tb_user.user = data.name_inform) ";
	$query .= "INNER JOIN  tb_agent ON (tb_agent.id_agent = data.idagent) ";
	
	$query .= "WHERE data.id_data='".$_GET["IDDATA"]."' ";
	//echo $query;
mysql_select_db($db2,$cndb2);
$objQuery = mysql_query($query,$cndb2) or die ("Error Query tb_data [".$query."]");

/*   Check  Invoice  */
		mysql_select_db($db3,$cndb3);
		$queryInvoice = "SELECT ";
		$queryInvoice .= " invoice.inv_no,invoice.status,invoice_detail.inv_no,invoice_detail.prb ";
		$queryInvoice .= " FROM invoice INNER JOIN invoice_detail  ON invoice.inv_no=invoice_detail.inv_no";
		$queryInvoice .= " WHERE invoice_detail.id_data='".$_GET["IDDATA"]."' AND  invoice.status!='C'";
		$objQueryInvoice = mysql_query($queryInvoice,$cndb3) or die ("Error Query Invoice [".$queryInvoice."]");
		$rowInvoice = mysql_fetch_array($objQueryInvoice);

/*  Check  Certificate  */
		mysql_select_db($db3,$cndb3);
		$queryCertificate = "SELECT ";
		$queryCertificate .= "invoice_detail.inv_no,";
		$queryCertificate .= "invoice_detail.prb,";
		$queryCertificate .= "certificate.certificate_id, ";	
		$queryCertificate .= "certificate.certificate_date ";
		$queryCertificate .= "FROM invoice_detail ";
		$queryCertificate .= "INNER JOIN certificate ON (certificate.inv_no = invoice_detail.inv_no) ";
		$queryCertificate .= "WHERE invoice_detail.id_data='".$_GET["IDDATA"]."' ";
		$objQueryCertificate = mysql_query($queryCertificate,$cndb3) or die ("Error Query Certificate [".$queryCertificate."]");
		$rowCertificate = mysql_fetch_array($objQueryCertificate);
		
		mysql_select_db($db3,$cndb3);
		$queryCutpay = "SELECT * FROM payment_detail WHERE payment_detail.id_data='".$_GET["IDDATA"]."' AND payment_detail.payd_no LIKE '%P%' ";
		$objQueryCutpay = mysql_query($queryCutpay,$cndb3) or die ("Error Query tb_data [".$queryCutpay."]");
		$rowCutpay = mysql_fetch_array($objQueryCutpay);
		
		mysql_select_db($db3,$cndb3);
		$queryCutpay_c = "SELECT * FROM payment_detail WHERE payment_detail.id_data='".$_GET["IDDATA"]."' AND payment_detail.payd_no LIKE '%C%'  ";
		$objQueryCutpay_c = mysql_query($queryCutpay_c,$cndb3) or die ("Error queryCutpay_c [".$queryCutpay_c."]");
		$rowCutpay_c = mysql_fetch_array($objQueryCutpay_c);
		
while($row = mysql_fetch_array($objQuery))
{
	mysql_select_db($db2,$cndb2);
	$queryquotation = "SELECT * FROM quotation WHERE quotation.q_auto='".$row["q_auto"]."' AND quotation.car_body = '".$row["car_body"]."'  ";
	$objquotation = mysql_query($queryquotation,$cndb3) or die ("Error queryquotation [".$queryquotation."]");
	$row_q = mysql_fetch_array($objquotation);
 	
	$car_id = $row['car_id'];
	$id_data_rec = $row['id_data'];
	$arr_car_id = str_split($car_id);
		
	// ส่วนลด คอมมิชชั่น
	$commition2 = $row['commition'];	
	$commition = str_replace("," , "" ,$commition2);	
		
	$other2 = $row['other'];	
	$other = str_replace("," , "" ,$other2);
		
	$com_and_other = $other +$commition;
	/////////////////////////////////////////////////
	
	// ส่วนลดคอมมิชชั่น เก่า 
	$commition2_old = $row['commition_old'];	
	$commition_old = str_replace("," , "" ,$commition2_old);
	
	$other2_old = $row['other_old'];	
	$other_old = str_replace("," , "" ,$other2_old);	
	
	$com_and_other_old = $other_old +$commition_old;
	//////////////////////////////////////////////////////////
	
	// % ส่วนลดคอมมิชชั่น //////////////////////////////////////////
	if($row['total_pre'] !='0.00' && $com_and_other != '0')
	{
		$dis_c = round(($com_and_other *100)/str_replace(",","",$row['total_pre']),2);
	}
	else
	{
		$dis_c = "0";
	}
	///////////////////////////////////////////////////////////////////
	
	// % ส่วนลดคอมมิชชั่น OLD //////////////////////////////////////////
	if($row['total_pre_old'] !='' && $com_and_other_old != '0.00')
	{
		$dis_c_old = round(($com_and_other_old *100)/str_replace(",","",$row['total_pre_old']),2);
	}
	else
	{
		$dis_c_old = "0";
	}
	///////////////////////////////////////////////////////////////////

	if($row['list_customer4'] == "")
	{
		$sum_c = $row['total_commition'];
	}
	else
	{
		$pay_date_c = "1,000";
		$total_commition_c = $row['total_commition'];	
		$pay_date_c = str_replace("," , "" ,$pay_date_c);
		$total_commition_c = str_replace("," , "" ,$total_commition_c);	
		$sum_c = number_format(($total_commition_c - $pay_date_c),2);
	}
	
	if($row['sort'] == 'VIB_S')
	{
		$Company = 'บมจ. วิริยะประกันภัย [ปากเกร็ด 08829]';
	}
	else
	{
		$Company = $row['comp_name'];
	}
		
    mysql_select_db($db2,$cndb2);
	$query_aduser = " SELECT * FROM user WHERE user_user='".$row['name_inform']."' ";
	$objQuery_aduser = mysql_query($query_aduser,$cndb2) or die ("Error query_aduser [".$query_aduser."]");
	$row_aduser = mysql_fetch_array($objQuery_aduser);




//----------------- Condition Statistic----------------------//
	$sql_ins = 
	"SELECT insuree.tel_mobile,insuree.tel_mobile2,insuree.tel_mobile3,insuree.tel_home,insuree.email,insuree.id_line,insuree.cus_code,insuree.claim_amount,insuree.policy_amount,insuree.tel_fax,insuree.SendAdd,insuree.vocation,
			premium.total_pre,premium.total_commition,premium.commition,premium.other,count(insuree.id_data) AS num_pre,
			data.start_date
	FROM insuree
	INNER JOIN premium ON (insuree.id_data=premium.id_data)
	INNER JOIN data ON (data.id_data=premium.id_data)
	WHERE insuree.id_data='".$_GET["IDDATA"]."' AND insuree.status_company!='C' GROUP BY insuree.id_data  ";
	mysql_select_db($db2,$cndb2);
	$obj_ins = mysql_query($sql_ins,$cndb2) or die ("Error sql_ins [".$sql_ins."]");
	$row_ins = mysql_fetch_array($obj_ins);

	$sql_cerf = 
	"SELECT certificate_datestamp,invoice_detail.id_data
	FROM certificate
	INNER JOIN invoice_detail ON certificate.inv_no=invoice_detail.inv_no
	WHERE invoice_detail.id_data='".$_GET["IDDATA"]."' Group By invoice_detail.id_data ORDER BY idC ASC LIMIT 1 ";
	mysql_select_db($db3,$cndb3);
	$obj_cerf = mysql_query($sql_cerf,$cndb3) or die ("Error sql_cerf [".$sql_cerf."]");
	$row_cerf = mysql_fetch_array($obj_cerf);

	$sql_year = 
	"SELECT count(data.start_date) AS count_year
	FROM insuree
	INNER JOIN data ON (data.id_data=insuree.id_data)
	WHERE cus_code='".$row_ins["cus_code"]."' AND insuree.status_company!='C'  Group By  DATE(data.id_data) ";
	mysql_select_db($db2,$cndb2);
	$obj_year = mysql_query($sql_year,$cndb2) or die ("Error sql_year [".$sql_year."]");
	$row_year = mysql_fetch_array($obj_year);

	//	echo $row_cus["count_year"];
	



//----------------- Condition ----------------------//

if(trim($row_ins["tel_mobile"])!='' && trim($row_ins["tel_mobile"])!='-'){
	$tel_mobile='10';
}
if(trim($row_ins["tel_mobile2"])!=''  && trim($row_ins["tel_mobile2"])!='-'){
	$tel_mobile2='20';
}
if(trim($row_ins["tel_mobile3"])!=''  && trim($row_ins["tel_mobile3"])!='-' ){
	$tel_mobile3='20';
}
if(trim($row_ins["tel_home"])!=''  && trim($row_ins["tel_home"])!='-'){
	$tel_home='25';
}
if(trim($row_ins["tel_fax"])!=''  && trim($row_ins["tel_fax"])!='-'){
	$tel_office='25';
}

if(trim($row_ins["email"])!=''  && trim($row_ins["email"])!='-'){
	$email='25';
}
if(trim($row_ins["id_line"])!=''  && trim($row_ins["id_line"])!='-'){
	$id_line='25';
}

if(trim($row_ins["vocation"])!=''  && trim($row_ins["vocation"])!='-'){
	$vocation='10';
}
if(trim($row_ins["SendAdd"])!=''  && trim($row_ins["SendAdd"])!='-'){
	$SendAdd='10';
}

$grand=$tel_mobile+$tel_mobile2+$tel_mobile3+$tel_home+$email+$id_line+$tel_office+$vocation+$SendAdd;

// ข้อมูลประกันภัย

$commition = floatval(preg_replace("/[^-0-9\.]/","",$row_ins["commition"]));
$other = floatval(preg_replace("/[^-0-9\.]/","",$row_ins["other"]));
$total_commition = floatval(preg_replace("/[^-0-9\.]/","",$row_ins["total_commition"]));



$Discount=number_format((($commition+$other)/$total_commition)*100);


//------- ส่วนลด ------------//
if($Discount<=1){
	$txt_Discount='<div style="float: left;">5</div>';
}else if($Discount>1 && $Discount<=5) {
	$txt_Discount='<div style="float: left;">4</div>';
}else if($Discount>5 && $Discount<=10) {
	$txt_Discount='<div style="float: left;">3</div>';
}else if($Discount>10 && $Discount<=15) {
	$txt_Discount='<div style="float: left;">2</div>';
}else if($Discount>15) {
	$txt_Discount='<div style="float: left;">1</div>';
}

// ------------- ระดับ เบี้ยชำระ -------------//
$row_cerf["certificate_datestamp"]='2015-09-31';

	$date7=date ("Y-m-d", strtotime("+7 day", strtotime('2015-09-01'))); //$row_ins["start_date"]
	$date15=date ("Y-m-d", strtotime("+15 day", strtotime('2015-09-01')));
	$date30=date ("Y-m-d", strtotime("+10 day", strtotime('2015-09-01')));





if($row_cerf["certificate_datestamp"]<=$row_ins["start_date"]){
	$Payment_Pre='<div style="float: left;">A</div>';
}else if($row_cerf["certificate_datestamp"]>$row_ins["start_date"] && $row_cerf["certificate_datestamp"]<=$date7) {
	$Payment_Pre='<div style="float: left;">B</div>';
}else if($row_cerf["certificate_datestamp"]>$date7 && $row_cerf["certificate_datestamp"]<=$date15) {
	$Payment_Pre='<div style="float: left;">C</div>';
}else if($row_cerf["certificate_datestamp"]>$date15 && $row_cerf["certificate_datestamp"]<=$date30) {
	$Payment_Pre='<div style="float: left;">D</div>';
}else if($row_cerf["certificate_datestamp"]>$date30) {
	$Payment_Pre='<div style="float: left;">E</div>';
}


// ------------- ระดับ เบี้ยชำระ -------------//

if($row_year["count_year"]==5){
	$Num_year='O';
}else if($row_year["count_year"]==4) {
	$Num_year='L';
}else if($row_year["count_year"]==3) {
	$Num_year='M';
}else if($row_year["count_year"]==2) {
	$Num_year='N';
}else if($row_year["count_year"]==1) {
	$Num_year='K';
}



// ------------- ระดับ เคลม -------------//
$cal_claim=0.00;
$total_pre=str_replace(",","",$row_ins["total_pre"]);
$cal_claim=number_format(($row_ins["claim_amount"]*100)/$total_pre);


if($cal_claim<1){
	$claim='<div style="margin-top: -1.5px;float: left; "><i class="icon-star icon-white " ></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i></div>';
}else if($cal_claim>=1 && $cal_claim<=20) {
	$claim='<div style="margin-top: -1.5px;float: left;"><i class="icon-star icon-white" ></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i></div>';
}else if($cal_claim>20 && $cal_claim<=40) {
	$claim='<div style="margin-top: -1.5px;float: left;"><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i></div>';
}else if($cal_claim>40 && $cal_claim<=60) {
	$claim='<div style="margin-top: -1.5px;float: left;"><i class="icon-star icon-white"></i><i class="icon-star icon-white"></i></div>';
}else if($cal_claim>60) {
	$claim='<div style="margin-top: -1.5px;float: left;"><i class="icon-star icon-white"></i></div>';
}


// ------------- ระดับ จำนวนกรมธรรม์ -------------//

$policy_amount=$row_ins["policy_amount"];


$grand_statistic=$txt_Discount.''.$Payment_Pre.''.$claim.''.$Num_year.''.$policy_amount;

//******************* Condition Statistic ************************************//


?>


</style>

<div id="tabs">
	<div class="texthead">

		<div  style="position:absolute;right: 0;height: 25px;width: 210px; margin-right:250px; margin-bottom:20px;" data-target="#modal_view_customer" data-toggle="modal"><label>ข้อมูลลูกค้า </label>
			<button class="btn btn-success"   style="width: 80px;height: 35px; padding:3px 4px 4px 4px;  text-align:center; font-weight:bold;font-size: x-large;"  > <?=number_format($grand)?> </button></div> 
			<div style="position:absolute;right: 0;height: 20px;width: 200px; margin-right:150px;" data-target="#modal_view_customer" data-toggle="modal"><label>ข้อมูลประกัน</label><button class="btn btn-info"  style="width: 160px;height: 35px;  font-weight:bold;font-size: x-large;text-align: center;"> <?=$grand_statistic?> </span></div>
			<h1><? echo $Company; ?></h1>
	        <h2>เลขที่รับแจ้ง <? echo $row['id_data']; ?>&nbsp;&nbsp;&nbsp;<? if($row['act_id']!=''){echo ' พ.ร.บ. : '.$row['act_id'];} ?></h2>
            <h2>วันที่แจ้งงาน <? if($row['status_company'] == 'Y'){echo thaiDate2($row['status_company_time']).' น.';} ?></h2>
		<div style="position:absolute;right: 0; margin-top: -80px;width: 220px;">
			<h4><?php echo "เจ้าหน้าที่รับแจ้ง :  <br>".$row_aduser['user_name']."<br>"; ?>
			<?php echo "วันที่ ".thaiDate2($row['send_date']).' น.' ?></h4> 
		</div>
	</div>
	<ul >
        <li class="active"><a href="#tab1" data-toggle="tab"><span>รายละเอียดลูกค้า</span></a></li>
        <li class="tab" ><a href="#tab2" data-toggle="tab"><span>รายละเอียดรถยนต์ </span></a></li>
        <li class="tab"><a href="#tab3" data-toggle="tab"><span>การรับชำระ,ใบกำกับ</span></a></li>
        <li class="tab"><a href="#tab6" data-toggle="tab"><span>เอกสารแนบ</span></a></li>
        <li class="tab"><a href="#tab4" data-toggle="tab"><span>จัดส่งเอกสาร</span></a></li>
		<li class="tab"><a href="#tab5" data-toggle="tab"><span>เบิกกรมธรรม์</span></a></li>
		<li class="tab"><a href="#tab7" data-toggle="tab"><span>เตือนยกเลิก</span></a></li>
        <li class="tab"><a href="#tab8" data-toggle="tab"><span>ยกเลิกกรมธรรม์</span></a></li>
	</ul>
</div>


<div class="tab-content">
	<div class="tab-pane fade in active" id="tab1">

		<?php
			mysql_select_db($db2,$cndb2);
			$query_user = " SELECT * FROM user WHERE user_user='".$row['company_user']."' ";
			$objQuery_user = mysql_query($query_user,$cndb2) or die ("Error queryCutpay_c [".$query_user."]");
			$row_user = mysql_fetch_array($objQuery_user);
			
			mysql_select_db($db2,$cndb2);
			$query_robbery_user = " SELECT * FROM user WHERE user_user='".$row['robbery_user']."' ";
			$objQuery_robbery_user = mysql_query($query_robbery_user,$cndb2) or die ("Error queryCutpay_c [".$query_robbery_user."]");
			$row_robbery_user = mysql_fetch_array($objQuery_robbery_user);
		?>

		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
		<?php if($row['Dealer_contact'] != ''){ ?>
			<tr class="alert alert-danger">
				<td height="23" colspan="4"><font size="2">รหัสตัวแทน</font> <font size="2">: <b><?php echo $row['full_name']; ?><b></font></td>
			</tr>
			<tr class="alert alert-danger">
				<td height="23"><font size="2">ติดต่อ</font></td>
				<td height="23" colspan="3"><font size="2">: 
					<?php
	                	// ชื่อ 
						if($row['Dealer_contact'] != '' && $row['Dealer_contact2'] == ''){ $D_contact = $row['Dealer_contact']; }
						else if($row['Dealer_contact'] != '' && $row['Dealer_contact2'] != ''){ $D_contact = $row['Dealer_contact'].', '.$row['Dealer_contact2']; }
						else{ $D_contact = '-'; }
												// เบอร์
						if($row['Dealer_tel'] != '' && $row['Dealer_tel2'] == ''){ $D_tel = $row['Dealer_tel']; }
						else if($row['Dealer_tel'] != '' && $row['Dealer_tel2'] != ''){ $D_tel = $row['Dealer_tel'].', '.$row['Dealer_tel2']; }
						else{ $D_tel = '-'; }
												// fax
						if($row['Dealer_fax'] != '' && $row['Dealer_fax2'] == ''){ $D_fax = $row['Dealer_fax']; }
						else if($row['Dealer_fax'] != '' && $row['Dealer_fax2'] != ''){ $D_fax = $row['Dealer_fax'].', '.$row['Dealer_fax2']; }
						else{ $D_fax = '-'; }
												// เมล
						if($row['Dealer_mail'] != '' && $row['Dealer_mail2'] == ''){ $D_mail = $row['Dealer_mail']; }
						else if($row['Dealer_mail'] != '' && $row['Dealer_mail2'] != ''){ $D_mail = $row['Dealer_mail'].', '.$row['Dealer_mail2']; }
						else{ $D_mail = '-'; }
					?>
					<? echo $D_contact.' โทร : '.$D_tel.' แฟกซ์ : '.$D_fax.' E-mail : '.$D_mail; ?>
	            </font></td>
	        </tr>
	        <tr class="alert alert-danger">
	        	<td height="23"><font size="2">การวางบิล</font></td>
	        	<td height="23" colspan="3"><font size="2">: 
	            	<? if($row['Dealer_bill'] != '' ){ $D_bill = $row['Dealer_bill']; }else{ $D_bill = '-'; }?>
	            	<? echo $D_bill; ?>
	         	</font></td>
	    	</tr>
	        <tr class="alert alert-danger">
	            <td height="23"><font size="2">การชำระเงิน</font></td>
	            <td height="23" colspan="6"><font size="2">:<? if($row['Dealer_pay'] != '' ){ $D_pay = $row['Dealer_pay']; }else{ $D_pay = '-'; }?><? echo $D_pay; ?></font></td>
	        </tr>
        <?php }else{ ?>
            <tr class="style1">
            	<td height="23" colspan="4"><font size="2">รหัสตัวแทน</font> <font size="2">:<b> <?php echo $row['full_name']; ?></b></font></td>
            </tr>
        <?php } ?>
        <?php
        	if($row['sort'] == 'VIB' || $row['sort'] == 'VIB_S' || $row['sort'] == 'VIB_Y' || $row['sort'] == 'VIB_S103') // วิริยะ
			{		
				if($row['car_brand'] == 'Mitsubishi') // suzuki
				{
					//$newDate_regis = (date("Y")-$row['regis_date'])+1;
					//if($newDate_regis == '2')
					if($row['regis_date'] == '2015')
					{
						?>
						<tr class="style1">
                            <td width="550" >
                            <label><span class="cs_title">เลขที่กรมธรรม์ (โจรกรรม):</span></label>
                                <form id="form_idrobbery" name="form_idrobbery" style="margin-bottom: 0px;">
                                <input name="txt_iddata2" type="hidden" class="span2" id="txt_iddata2"  style="width:80px;" value="<?=$row['id_data']; ?>"  />
                                <?php
                                if($row['policy_robbery']=='')
                                {
                                ?>
                                    <input name="txt_idrobbery" type="text" id="txt_idrobbery" style="width:135px;" value="<?=$row['policy_robbery']; ?>" /> 
                                    <button class="btn btn-small " id="save_idrobbery" type="button" style="margin-top:-9px;">บันทึก</button>
                                <?php
                                }
                                else
                                {
                                    echo "<b>".$row['policy_robbery']."</b>";
									echo "<br ><span class='cs_title'>";
									echo "<b> ผู้บันทึก ".$row_robbery_user['user_name']." <br/> ( ".thaiDate($row['robbery_date'])." )</b>";
									echo "</span>";
                                }
                                ?>
                                </form>
                            </td>
                            <td width="550" ></td>
                            <td width="550" ></td>
                            <td width="550" ></td>
                        </tr>
						<?php
					}
				}
			}
		?>
        
        <tr class="style1">

        	<td width="550" >
        	<label><span class="cs_title">เลขที่กรมธรรม์ :</span></label>
        		<form id="form_idin" name="form_idin" style="margin-bottom: 0px;">
        		<input name="txt_iddata2" type="hidden" class="span2" id="txt_iddata2"  style="width:80px;" value="<?=$row['id_data']; ?>"  />
        		<?php 
        		if($row['id_data_company']=='')
        		{
        		?>
        			<input name="txt_idinsurance" type="text" id="txt_idinsurance" style="width:135px;" value="<?=$row['id_data_company']; ?>" /> 
        			<button class="btn btn-small " id="save_idin" type="button" style="margin-top:-9px;">บันทึก</button>
        		<?php
        		}
        		elseif($row['id_data_company']!='' && $_SESSION["4User"] == 'PAR')
        		{
        		?>
        			<input name="txt_idinsurance" type="text" id="txt_idinsurance" style="width:135px;" value="<?=$row['id_data_company']; ?>" /> 
        			<button class="btn btn-small " id="save_idin" type="button" style="margin-top:-9px;">บันทึก</button>
        			<?
        			echo "<br ><span class='cs_title'>";
        			echo " ( ".thaiDate($row['company_date'])." ) ผู้บันทึก ".$row_user['user_name'];
        			echo "</span>";
        			?>
        		<?php
        		}
        		else
        		{
        			echo "<b>".$row[id_data_company]."</b>";
        			echo "<br ><span class='cs_title'>";
        			echo "<b> ผู้บันทึก ".$row_user['user_name']." <br/> ( ".thaiDate($row['company_date'])." )</b>";
        			echo "</span>";
        		}
        		?>
        		</form>
        	</td>
        	<td width="550" > <?php // if($row['EditAct_id']!=''){echo $row['EditAct_id'];}else{ echo $row['p_act']; } ?>
        	<label><span class="cs_title">เลขที่ พรบ. :</span></label>
        		<form id="form_actid" name="form_actid" style="margin-bottom: 0px;">
        		<input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style='width:130px; background-color:#F6E3CE' value="<?=$row['id_data']; ?>"  />
        		<? 
        		if($row['act_id']==''){
        			?>
        			<input name="txt_actid" type="text" id="txt_actid" style="width:100px;" value="<?=$row["act_id"]?>" /> 			
        			<button class="btn btn-small " id="save_actid" type="button" style="margin-top:-9px;">บันทึก</button>
        			<? 
        		}elseif($row['act_id']!='' && $_SESSION["4User"] == 'PAR'){
        			?>
        			<input name="txt_actid" type="text" id="txt_actid" style="width:100px; margin-bottom: 0px;" value="<?=$row["act_id"]?>" /> 			
        			<button class="btn btn-small " id="save_actid" type="button" style="margin-top:0px;">บันทึก</button>
        			<?
        		}else{ echo "<b>".$row["act_id"]."</br>"; }
        		?>
        		</form>
        	</td>


        	<td width="550" >
    			<label><span class="cs_title">อท. :</span></label>
	    			<form id="form_plus" name="form_plus" style="margin-bottom: 0px;">
	    				<input name="txt_iddataplus" type="hidden" class="span2" id="txt_iddataplus"  style="width:100px;" value="<?=$row['id_data']?>"  />
	    				<input name="txt_idplus" type="text" id="txt_idplus" style="width:100px; margin-bottom: 0px;" value="" /> 
	    				<button class="btn btn-small " id="save_plus" type="button" style="margin-top:0px;">เพิ่ม</button>
	    			</form>
    		</td>

    		<td width="550" >
    		<label><span class="cs_title">เลขที่ อท. :</span></label>

	    			<?php
	    		mysql_select_db($db2,$cndb2);
	    		$queryplus = "SELECT * FROM attached WHERE attached.id_data='".$_GET["IDDATA"]."' ";
	    		$objQueryplus = mysql_query($queryplus,$cndb2) or die ("Error Query tb_data [".$queryplus."]");
	    		$iplus=0;

	    		while($rowplus = mysql_fetch_array($objQueryplus))
	    		{ 
	    			mysql_select_db($db2,$cndb2);
	    			$query_userplus = " SELECT * FROM user WHERE user_user='".$rowplus['user_attached']."' ";
	    			$objQuery_userplus = mysql_query($query_userplus,$cndb2) or die ("Error query_userplus [".$query_userplus."]");
	    			$row_userplus = mysql_fetch_array($objQuery_userplus);

	    			if($iplus>0)
	    			{
	    				echo ',';
	    			}
	    			echo $rowplus['no_attached'];
	    			echo "<br ><span class='cs_title'>";
	    			echo "ผู้บันทึก ".$row_userplus['user_name']." <br> ( ".thaiDate($rowplus['dateplus'])." )";
	    			echo "</span>";
	    			$iplus++;
	    		}
	    		?>
	    	</td>



    	<tr>
    			
    		<td width="550" >
    			<label><span class="cs_title">ยอดเงินการเคลม :</span></label>
	    		<form id="form_claim" name="form_claim" style="margin-bottom: 0px;">
	    			<input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']?>"  />
	    			<input name="txt_claim" type="text" id="txt_claim" style="width:100px; margin-bottom: 0px;" value="<?=number_format($row['claim_amount'],2)?>" /> 
	    			<button class="btn btn-small " id="save_claim" type="button" style="margin-top:0px;">บันทึก</button>
	    		</form>
	    	</td>
	    	<td width="550" >
	    		<label><span class="cs_title">จำนวนกรมธรรม์ :</span></label>
	    		<form id="form_policy" name="form_policy" style="margin-bottom: 0px;">
	    			<input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']?>"  />
	    			<input name="txt_policy" type="text" id="txt_policy" style="width:100px; margin-bottom: 0px;" value="<?=$row['policy_amount']?>" /> 
	    			<button class="btn btn-small " id="save_policy" type="button" style="margin-top:0px;">บันทึก</button>
	    		</form>
    		</td>

    		<td width="550" >
	    		<label><span class="cs_title">ผู้เอาประกันภัย :</span></label><strong>
    			<?php if($row['Cus_name'] != '') {
    				//echo $row['Cus_title'].$row['Cus_name']." ".$row['Cus_last']; }else{ echo $row['title']." ".$row['name']." ".$row['last']; 
    				echo $row['Cus_title'].$row['Cus_name']." ".$row['Cus_last'];
					//echo $row['Cus_title'].$row['Cus_name']." ".$row['Cus_last'];
				}else{ 
					echo $row['title']." ".$row['name']." ".$row['last'];
					//echo $row['title']." ".$row['name']." ".$row['last'];
    			}?>

    			</font></strong>
    		</td>

    		<td width="550" >
	    		<label><span class="cs_title"><font size="2">
    				<? if($row['person'] == '1'){ echo 'เลขบัตรประชาชน '; }else{ echo 'เลขผู้เสียภาษี '; }?>
    			</font> :</span></label>
    			<strong><font size="2">
    			<? echo $row['icard']; ?>
    			</font></strong>
    		</td>


    	</tr>


    	</tr>

    	
    	<tr class="style1" width="100%">


    			<td height="23" colspan="2">
    			<label><span class="cs_title">ที่อยู่ปัจจุบัน : </span></label>
    			<strong><font size="2">
    			<?php
    				$address_pdf = $row['career'];			 
    				$address_pdf .= $row['add'];
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
    				</font></strong>
    			</td>
    			<td height="23" colspan="2">
    				<div style="float:left; margin: 0 0 10px 10px; ">
    					<label><span class="cs_title">อาชีพ :</span></label>
    					<? echo "<strong><font size='2'>".$row['vocation']."</font></strong>";?>
			       	</div>
    			</td>



    			
			</tr>
             <tr class="style1">
             	<td height="23" colspan="4">
    				<div style="float:left; margin: 0 0 10px 10px; ">
    					<label><span class="cs_title">ที่อยู่ในการจัดส่ง :</span></label>
    					<? if($row['SendAdd']==''){ ?>
    						<form id="form_SendAdd" name="form_SendAdd" style="margin-bottom: 0px;">
				    			<input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']?>"  />
				    			<input name="txt_SendAdd" type="text" id="txt_SendAdd" style="width:250px; margin-bottom: 0px;" value="<?=$row['SendAdd']?>" /> 
				    			<button class="btn btn-small " id="save_SendAdd" type="button" style="margin-top:0px;">บันทึก</button>
				    		</form>
    					<? }else{ 
    						echo "<strong><font size='2' color='#6E6E6E'>".$row['SendAdd']."</font></strong>";
    					}?>
				    		

			       	</div>
    			</td>
             </tr>
            <tr class="style1">
                <td height="23" colspan="3">
	                		
			        		<div style="float:left; margin: 0 0 10px 10px; ">
								<label><span class="cs_title">เบอร์บ้าน/ออฟฟิศ :</span></label>

										<? if(trim($row['tel_home'])!='' && trim($row['tel_home'])!='-'){ 
											echo "<strong><font size='2'>".$row['tel_home']."</font></strong> ";
										}else{ ?>
											<button class='btn btn-mini' id='show_telhome' type='button' style='margin-top:0px;'>เพิ่มเบอร์ 1</button>
											<form id="form_telhome" name="form_telhome" style="margin-bottom: 0px; display: none" >
								    			<input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']?>"  />
								    			<input name="txt_telhome" type="text" id="txt_telhome" style="width:100px; margin-bottom: 0px; background-color : #F6D8CE;" value="" />
								    			<button class="btn btn-small btn-primary" id="save_telhome" type="button" style="margin-top:0px;">บันทึก</button>
								    		</form>
										<? } ?>

													<? if(trim($row['tel_home2'])!='' && trim($row['tel_home2'])!='-'){ 
														echo "<br><strong><font size='2'>".$row['tel_home2']."</font></strong> ";
													}else{ ?>
														<button class='btn btn-mini' id='show_telhome2' type='button' style='margin-top:0px;'>เพิ่มเบอร์ 2</button>
														<form id="form_telhome2" name="form_telhome2" style="margin-bottom: 0px; display: none" >
											    			<input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']?>"  />
											    			<input name="txt_telhome2" type="text" id="txt_telhome2" style="width:100px; margin-bottom: 0px; background-color : #F6D8CE;"  />
											    			<button class="btn btn-small btn-primary" id="save_telhome2" type="button" style="margin-top:0px;">บันทึก</button>
											    		</form>
													<? } ?>
								

								
						    </div>

						    <div style="float:left; margin: 0 0 10px 10px; ">
						    <label><span class="cs_title">เบอร์แฟกซ์ :</span></label>

						    	<? if(trim($row['tel_fax'])!='' && trim($row['tel_fax'])!='-' ){ 
											echo "<strong><font size='2'>".$row['tel_fax']."</font></strong> ";
								}else{ ?>
									<button class='btn btn-mini' id='show_fax' type='button' style='margin-top:0px;'>เบอร์แฟกซ์ 1</button>
						    		<form id="form_fax" name="form_fax" style="margin-bottom: 0px; display: none" >	 
						    			<input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']?>"  />
						    			<input name="txt_fax" type="text" id="txt_fax" style="width:100px; margin-bottom: 0px;background-color : #F6D8CE;" /> 
						    			<button class="btn btn-small btn-primary" id="save_fax" type="button" style="margin-top:0px;">บันทึก</button>
						    		</form>
						    	<? } ?>

								    	<? if(trim($row['tel_fax2'])!='' && trim($row['tel_fax2'])!='-'){ 
													echo "<br><strong><font size='2'>".$row['tel_fax2']."</font></strong> ";
										}else{ ?>
											<button class='btn btn-mini' id='show_fax2' type='button' style='margin-top:0px;'>เบอร์แฟกซ์ 2</button>
								    		<form id="form_fax2" name="form_fax2" style="margin-bottom: 0px; display: none" >	 
								    			<input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']?>"  />
								    			<input name="txt_fax2" type="text" id="txt_fax2" style="width:100px; margin-bottom: 0px; background-color : #F6D8CE;" /> 
								    			<button class="btn btn-small btn-primary" id="save_fax2" type="button" style="margin-top:0px;">บันทึก</button>
								    		</form>
								    	<? } ?>
	               			</div>


	                		<div style="float:left; margin: 0 0 10px 10px; ">
	                			<label><span class="cs_title">Email :</span></label>

	                			<? if(trim($row['email'])!='' && trim($row['email'])!='-'){ 
											echo "<strong><font size='2'>".$row['email']."</font></strong> ";
								}else{ ?>
									<button class='btn btn-mini' id='show_email' type='button' style='margin-top:0px;'>email 1</button>
						    		<form id="form_email" name="form_email" style="margin-bottom: 0px; display: none;">
						    			<input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']?>"  />
						    			<input name="txt_email" type="text" id="txt_email" style="width:170px; margin-bottom: 0px;background-color : #F6D8CE;" /> 
						    			<button class="btn btn-small btn-primary " id="save_email" type="button" style="margin-top:0px;">บันทึก</button>
						    		</form>
						    	<? } ?>

							    	<? if(trim($row['email2'])!='' && trim($row['email2'])!=''){ 
												echo "<br><strong><font size='2'>".$row['email2']."</font></strong> ";
									}else{ ?>
										<button class='btn btn-mini' id='show_email2' type='button' style='margin-top:0px;'>email 2</button>
							    		<form id="form_email2" name="form_email2" style="margin-bottom: 0px; display: none;">
							    			<input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']?>"  />
							    			<input name="txt_email2" type="text" id="txt_email2" style="width:170px; margin-bottom: 0px;background-color : #F6D8CE;" /> 
							    			<button class="btn btn-small btn-primary" id="save_email2" type="button" style="margin-top:0px;">บันทึก</button>
							    		</form>
							    	<? } ?>
	                			
	                		</div>

                </td>

                <td height="23" rowspan="3" >
    				<?php
    				$iddtastamp = split("\|",$row['pay_file']);
    				foreach ($iddtastamp as $val_pic)
    				{
						$date_pdf = split("\+",$val_pic); // ตัดเวลาข้างหลัง
						$file_pdf = split("\.",$date_pdf[0]); // เช็คสกุลไฟล์ว่า คืออะไร
						$path_file = split("_",$date_pdf[0]); // ตัดชื่อไฟล์
						if($path_file[0] == 'แผนที่')
						{
							if($file_pdf[1] == "pdf" && $val_pic !="")
							{
					?>
								<center>
								<br />
								<a href="../../4ib/Myfile/<?=$path_file[1]."_".$path_file[2];?>"target="_blank" ><? echo "<b>".$path_file[0]."</b>"; ?></a> 
								<br />
								<? if($date_pdf[1] != ''){echo "วันที่ upload ".thaiDate($date_pdf[1]);} ?>
								</center>
					<?php	
							}
							else if ($val_pic !="")
							{
					?>
								<center>
								<br />
								<a href="../../4ib/Myfile/<?=$path_file[1]."_".$path_file[2];?>" target="_blank"><img src="<? echo '../../4ib/Myfile/'.$path_file[1]."_".$path_file[2];?>" width="40%" class="img-polaroid"></a>
								<br />
					<?php 
								echo "<b>".$path_file[0]."</b>";
					?>
								<br />
								<? if($date_pdf[1] != ''){echo "วันที่ upload ".thaiDate($date_pdf[1]);} ?>
								</center>
					<?php		
							}
						}
					}
					?>
				</td>
            </tr>
            <tr >
                <td colspan="3">

                <div style="float:left; margin: 0 0 10px 10px; ">
	                			<label><span class="cs_title">ID Line :</span></label>

	                			<?php if($row['id_line']!=''){ 
											echo "<strong><font size='2'>".$row['id_line']."</font></strong> ";
								}else{ ?>
									<button class='btn btn-mini' id='show_idline' type='button' style='margin-top:0px;'>ID 1</button>
						    		<form id="form_idline" name="form_idline" style="margin-bottom: 0px; display: none;">
						    			<input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']?>"  />
						    			<input name="txt_idline" type="text" id="txt_idline" style="width:170px; margin-bottom: 0px;background-color : #F6D8CE;" /> 
						    			<button class="btn btn-small btn-primary " id="save_idline" type="button" style="margin-top:0px;">บันทึก</button>
						    		</form>
						    	<?php } ?>

						    		<?php if($row['id_line2']!=''){ 
											echo "<br><strong><font size='2'>".$row['id_line2']."</font></strong> ";
									}else{ ?>
										<button class='btn btn-mini' id='show_idline2' type='button' style='margin-top:0px;'>ID 2</button>
							    		<form id="form_idline2" name="form_idline2" style="margin-bottom: 0px; display: none;">
							    			<input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']?>"  />
							    			<input name="txt_idline2" type="text" id="txt_idline2" style="width:170px; margin-bottom: 0px;background-color : #F6D8CE;" /> 
							    			<button class="btn btn-small btn-primary " id="save_idline2" type="button" style="margin-top:0px;">บันทึก</button>
							    		</form>
							    	<?php } ?>

	                			
	            </div>

                 <div style="float:left; margin: 0 0 10px 10px;">
                	<label><span class="cs_title">เบอร์มือถือ :</span></label>
               		
                    <?php if(trim($row['tel_mobile']) != '' && trim($row['tel_mobile']) != '-'){ ?>
						<a title="ส่ง sms" class="btn btn-small btn-warning" onclick="$('.modal-backdrop').hide();$('#content').load('pages/sms.php?tel=<?=$row['tel_mobile'];?>&&IDDATA=<?=$row['id_data'];?>');"><i class="icon-envelope icon-white"></i> <?= $row['tel_mobile']; ?></a>
                    <?php }else{ ?>
                    	<form id="form_tel1" name="form_tel1">
                            <input name="txt_iddata_tel1" type="hidden" class="span2" id="txt_iddata_tel1"  style="width:80px;" value="<?=$row['id_data']?>"  />
                            <input name="txt_tel1" type="text" id="txt_tel1" style="width:100px;" value="" /> 
                            <button class="btn btn-small " id="save_tel1" type="button" style="margin-top:-9px;">เพิ่ม</button>
                        </form>
                    <?php } ?>
                    </div>
                    <div style="float:left; margin: 0 0 10px 10px;">
					<? if(trim($row['tel_mobile2']) != '' && trim($row['tel_mobile2']) != '-'){ ?>
                    	<label><span class="cs_title">เบอร์มือถือ 2 :</span></label> 
                    		<a title="ส่ง sms" class="btn btn-small btn-warning" style="margin-bottom:-10px;" onclick="$('.modal-backdrop').hide();$('#content').load('pages/sms.php?tel=<?=$row['tel_mobile2'];?>&&IDDATA=<?=$row['id_data'];?>');"><i class="icon-envelope icon-white"></i> <?= $row['tel_mobile2']; ?></a>                  	
                    <? }else{ ?>
                    	<label><span class="cs_title">เบอร์มือถือ 2 :</span></label>
                    	<form id="form_tel2" name="form_tel2">
                            <input name="txt_iddata_tel2" type="hidden" class="span2" id="txt_iddata_tel2"  style="width:80px;" value="<?=$row['id_data']?>"  />
                            <input name="txt_tel2" type="text" id="txt_tel2" style="width:100px;" value="" /> 
                            <button class="btn btn-small btn" id="save_tel2" type="button" style="margin-top:-9px;">เพิ่ม</button>
                        </form>
                    <? } ?>
                    </div>

                    <div style="float:left; margin: 0 0 10px 10px; ">
					<? if(trim($row['tel_mobile3']) != '' && trim($row['tel_mobile3']) != '-'){ ?>
						<label><span class="cs_title">เบอร์มือถือ 3 :</span></label>  
						<a title="ส่ง sms" class="btn btn-small btn-warning" onclick="$('.modal-backdrop').hide();$('#content').load('pages/sms.php?tel=<?=$row['tel_mobile3'];?>&&IDDATA=<?=$row['id_data'];?>');"><i class="icon-envelope icon-white"></i> <?= $row['tel_mobile3']; ?></a>
					<? }else{ ?>
						<label><span class="cs_title">เบอร์มือถือ 3 :</span></label>
                    	<form id="form_tel3" name="form_tel3">
                            <input name="txt_iddata_tel3" type="hidden" class="span2" id="txt_iddata_tel3"  style="width:80px;" value="<?=$row['id_data']?>"  />
                            <input name="txt_tel3" type="text" id="txt_tel3" style="width:100px;" value="" /> 
                            <button class="btn btn-small " id="save_tel3" type="button" style="margin-top:-9px;">เพิ่ม</button>
                        </form>
					<? } ?>
					</div>
                	
                </td>
            </tr>
           
            <tr class="style1">
                <td height="23" colspan="4">
						<div style="float:left; margin: 0 0 10px 10px; ">
    						<label>รายละเอียด</label>

                				<strong><font size="2"><?php if($row['list_customer']!=''){ echo $row['list_customer']; echo"<br />"; } ?>
                				<?php if($row['list_customer1']!=''){ echo $row['list_customer']; echo"<br />"; } ?>
                				<?php if($row['list_customer2']!=''){ echo $row['list_customer2']; echo"<br />"; } ?>
                				<?php if($row['list_customer3']!=''){ echo $row['list_customer3']; echo"<br />"; } ?>
                				<?php if($row['list_customer4']!=''){ echo $row['list_customer4']; echo"<br />"; } ?>
                				<?php if($row['list_customer5']!=''){ echo $row['list_customer5']; echo"<br />"; } ?>
                				</font></strong>  
                		</div>
					  
							  				
        </tr>
        </table>
<?php 
if($row["car_id"]=='110'){
	$fix_prb='645.21';
}else if($row["car_id"]=='320'){
	$fix_prb='967.28';
}else{
	$fix_prb=$row["prb"];
}
?>

<form name="form_prerenew" id="form_prerenew" method="post">
	<span align="left" style="display: inline-block;margin-bottom: -15px;float: left;">
		<!-- เบี้ยต่ออายุ -->
		<div class="input-prepend" style="margin-bottom: 0px;">
			<input id="txt_iddata" name="txt_iddata"  style="background-color:#CCFFFF;width: 85px; text-align:right;" class="span2"  type="hidden" value="<?=$row["id_data"]?>"  >
			<span class="add-on">เบี้ยต่ออายุ ทุน</span>
			<input id="inp_cost" name="txt_costrenew" style="background-color:#CCFFFF;width: 85px; text-align:right;" class="span2"  type="text" value="<?=$row["cost_renew"]?>" readonly >
			<span  class="add-on">เบี้ยสุทธิ</span>
			<input id="inp_pre" name="txt_prerenew" style="background-color:#CCFFFF;width: 85px; text-align:right;" class="span2"  type="text" value="<?=$row["pre_renew"]?>" readonly>
			<span  class="add-on">เบี้ยรวม</span>
			<input id="inp_net" name="txt_netrenew" style="background-color:#CCFFFF;width: 85px; text-align:right;" class="span2"  type="text" value="<?=$row["net_renew"]?>" readonly>
			<span  class="add-on">เบี้ยรวม พรบ.</span>
			<input id="inp_net" name="txt_netrenew" style="background-color:#CCFFFF;width: 85px; text-align:right;" class="span2"  type="text" value="<?=number_format(str_replace(',', '', $row["net_renew"])+$fix_prb,2)?>" readonly>
		</div>
		
<!-- 		<a  class="btn btn-success btn-small " id="save_prerenew" style="display:none"> <i class="icon-hdd"></i> บันทึก</a>
		<a  class="btn btn-small " id="chk_prerenew"> <i class="icon-edit"></i> แก้ไขเบี้ยต่ออายุ</a> -->
	</span>
</form>

<form action="javascript:fuc_barcode();" name="webform" id="webform" method="post">  <input type="hidden" id="countlist" value="0"/>

<?php
$sql_folup_chk = "SELECT * From followup where id_data='".$row["id_data"]."' AND (status = 'SS-F' OR status = 'SS') AND amount!='0.00' ";	  
mysql_select_db($db2,$cndb2);
$objQuery_folup_chk = mysql_query($sql_folup_chk,$cndb2) or die ("Error Query sql_fol_chk [".$sql_folup_chk."]");
$folup_chk_nrow=mysql_num_rows($objQuery_folup_chk);

if($row["idagent"]=='MBLT' || $row["idagent"]=='NMBLT'){
	$txt_F='-F';
} else{
	$txt_F='';
}


?>
<span style="display: inline-block;margin-bottom:20px;height:10px; float: right;"> <? if($_SESSION['s_Group'] == "VIPS"){ echo"<br>";} ?>
<a  class="btn btn-small " id="add-item"> <i class="icon-plus"></i> เพิ่มรายการ</a> <?php if($folup_chk_nrow=='0' || $_SESSION['s_Group'] == "VIPS" ){?><button  id="add-item4ib" style="background-color: #FFD1B2;font-size: 85%;"> <i class="icon-tags"></i> เพิ่มติดตามงานต่ออายุ</button> <?php } if($folup_chk_nrow!='0' || $_SESSION['s_Group'] == "VIPS" ){?><a class="btn btn-small " target="_blank" href="print/Print_PayNew.php?IDDATA=<?=$row["id_data"]?>&feed=SS-F" ><i class=" icon-print"></i> ใบเตือนต่ออายุ</a><?}?>
</span>
										<?php
										$sql_folchk = "SELECT * From tb_follow_customer where id_data='".$row["id_data"]."' ";	  
										mysql_select_db($db2,$cndb2);
										$objQuery_folchk = mysql_query($sql_folchk,$cndb2) or die ("Error Query sql_fol [".$sql_folchk."]");
										$row_folchk = mysql_fetch_array($objQuery_folchk);
										?>	
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table  table-bordered" style="font-size: 85%;">
 <tr >
        <td width="80" height="23"><div align="center">วันที่ติดตาม</div></td>
         <!--<td width="80"><div align="center">เวลา</div></td>-->
        <td width="80"><div align="center">วันที่นัดชำระ</div></td>
        <td><div align="center">รายละเอียด</div></td>
        <td width="14%"><div align="center">ผู้ติดตาม</div></td>
        <td width="10%"><div align="center">สถานะ</div></td>
      </tr>
<?php // ติดตามจาก 4ib
$sql_folup = "SELECT * From followup where id_data='".$row["id_data"]."' ORDER BY id DESC ";	  
mysql_select_db($db2,$cndb2);
$objQuery_folup = mysql_query($sql_folup,$cndb2) or die ("Error Query sql_fol [".$sql_fol."]");
while($row_folup = mysql_fetch_array($objQuery_folup))
	{

?>
      
      <tr  style="font-weight: normal; background-color: #FFD1B2;">
        <td height="23" ><?=thaiDate($row_folup["save_date"])?></td>
        <td ><?=thaiDate($row_folup["meet_date"])?></td>
        <td ><?=$row_folup["detail"]?></td>
        <td ><?=$row_folup["create_by"]?></td>
        <td ><?=Func_statusFol($row_folup["status"])?></td>
      </tr> 
 <?php
 	if($row_folup["status"]=='SS-F' || $row_folup["status"]=='CN-F'){
 		break;
 	}
  }?>


      <?php // ติดตามจาก Policy 
$sql_fol = "SELECT * From tb_follow_customer where id_data='".$row["id_data"]."' ORDER BY date_fol DESC ";	  
mysql_select_db($db2,$cndb2);
$objQuery_fol = mysql_query($sql_fol,$cndb2) or die ("Error Query sql_fol [".$sql_fol."]");
while($row_fol = mysql_fetch_array($objQuery_fol))
	{
		if($row_fol["status_fol"] == 'Y'){$status_fol = '';}else{$status_fol = '';}
?>  
    <tr  style="font-weight: normal;">
        <td height="23" ><?=thaiDate($row_fol["date_fol"])?></td>
        <td ><?=thaiDate($row_fol["date_appointment"])?></td>
        <td ><?=$row_fol["detail_fol"]?></td>
        <td ><?=$row_fol["login_emp"]?></td>
        <td ><?=$status_fol?></td>
    </tr>
 <?php }?> 


 <tbody id="selectlist"></tbody>
  </table>

<!--<script src="assets/js/jquery.js"></script> -->
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>  
 <script>



$( "#add-item" ).click(function( event ) {
var listcount= document.getElementById("countlist").value;	

if(listcount<1){
	listcount++;


$('#selectlist').append('<tr><td width="80" height="23" ><input name="txt_mail" type="hidden" class="span2" id="txt_mail"  style="width:90px;" value="<?=$row['Email2']; ?>"  /><input name="txt_user" type="hidden" class="span2" id="txt_user"  style="width:90px;" value="<?=$row['name_inform']; ?>"  /><input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:90px;" value="<?=$row['id_data']; ?>"  /><input name="txt_date_fol" type="text" class="span2" id="txt_date_fol"  style="width:90px;" value="<?=date('d/m/Y')?>" readonly/></td><td width="80" ><input name="txt_date_appointment" type="text" class="span2" id="txt_date_appointment"  style="width:90px;"  placeholder="วันที่นัดชำระ"/></td><td width="50%" ><input name="txt_detail" type="text" id="txt_detail" style="width:400px;" value="" placeholder="รายละเอียด" required="required" /></td><td colspan = "2" width="14%" ><button class="btn btn-small btn-success" id="save" type="button">บันทึก</button></td></tr>');

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
		  
		  
		  var txt_detail=document.getElementById("txt_detail").value;
		 var txt_date_appointment=document.getElementById("txt_date_appointment").value;
		  
		   if(txt_date_appointment==''){
			 
			 alert("กรุณา กรอกวันที่นัดชำระ");
			 document.getElementById("txt_date_appointment").focus();
			 return false;
			 
		 }
		 
		 if(txt_detail==''){
			 
			 alert("กรุณา กรอกรายละเอียด");
			 document.getElementById("txt_detail").focus();
			 return false;
			 
		 }
		  
		  
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Ajax_Save_FollowCustomer.php",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#webform")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						$(".modal").removeData('modal-body');
						$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
								
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
        
        $.ajax(options);
	
	 });
	
 });



$( "#add-item4ib" ).click(function( event ) {
var listcount= document.getElementById("countlist").value;	


if(listcount<1){
	listcount++;


$('#selectlist').append('<tr><td width="80" height="23" ><input name="txt_mail" type="hidden" class="span2" id="txt_mail"  style="width:90px;" value="<?=$row['Email2']; ?>"  /><input name="txt_user" type="hidden" class="span2" id="txt_user"  style="width:90px;" value="<?=$row['name_inform']; ?>"  /><input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:90px;" value="<?=$row['id_data']; ?>"  /><input name="txt_date_fol" type="text" class="span2" id="txt_date_fol"  style="width:90px;" value="<?=date('d/m/Y')?>" readonly/></td><td width="80" ><input name="txt_date_appointment" type="text" class="span2" id="txt_date_appointment"  style="width:90px;"  placeholder="วันที่นัดชำระ"/></td><td width="50%" ><select name="txt_FL" id="txt_FL" style="width:125px;" onchange="txt_be_show(this)"><option value="">- เลือกรายการ -</option><option value="FL<?=$txt_F?>">ติดตามงาน</option><option value="SS<?=$txt_F?>">ปิดงาน</option><option value="CN<?=$txt_F?>">ไม่ต่ออายุ</option></select> <select name="txt_be" id="txt_be" style="width:125px;display:none;"><option value="">- เลือกรายการ -</option><option value="ขายรถ">ขายรถ</option><option value="ทำประกันภัยเอง">ทำประกันภัยเอง</option><option value="ติดต่อไม่ได้">ติดต่อไม่ได้</option></select> <input name="txt_amount" type="text" id="txt_amount"  style="width:100px;"  placeholder="ยอดชำระ" > <select name="chk_prb" id="chk_prb" style="width:110px;"><option value="">เลือก พ.ร.บ. </option><option value="Y">รวม พ.ร.บ.</option><option value="N">ไม่รวม พ.ร.บ.</option></select> <input name="txt_detail" type="text" id="txt_detail" style="width:340px;" value="" placeholder="รายละเอียด" required="" /></td><td colspan = "2" width="14%" ><center><button class="btn btn-small btn-success" id="save_4ib" type="button">บันทึก</button></center></td></tr>');

$('#countlist').val(listcount);


		$("#txt_amount").hide();
		$("#chk_prb").hide();


		 $('#txt_date_fol').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy'
		 });
		  $('#txt_date_appointment').datepicker({
			autoclose: true,
			format: 'dd/mm/yyyy'
		 }); 



		$('#txt_amount').iMask({
   		 	type : 'number'
   		});
		
		$( "#txt_FL" ).change(function() {
		 	var txt_FL=document.getElementById("txt_FL").value;
		 	if(txt_FL=='SS' || txt_FL=='SS-F'){
		 		$("#txt_amount").show("slow").val(""); 		
		 		$("#chk_prb").show("slow").val("");  		

		 	}else{

		 		$("#txt_amount").hide();	 		
				$("#chk_prb").hide();	
				
				
		 	}
		});
		 
	}



 $("#save_4ib").click(function() {


		  var DATA = $('#webform').serialize();
		  
		  
		  var txt_detail=document.getElementById("txt_detail").value;
		 var txt_date_appointment=document.getElementById("txt_date_appointment").value;
		 var txt_FL=document.getElementById("txt_FL").value;
		 var txt_be=document.getElementById("txt_be").value;
		  
		   if(txt_date_appointment==''){
			 
			 alert("กรุณา กรอกวันที่นัดชำระ");
			 document.getElementById("txt_date_appointment").focus();
			 return false;
			 
		 }

		 if(txt_FL==''){
			 
			 alert("กรุณา เลือกรายการ");
			 document.getElementById("txt_FL").focus();
			 return false;
			 
		 }
		 if(txt_FL.indexOf('CN') > -1 && txt_be==''){
			 
			 alert("กรุณา เลือกรายการ");
			 document.getElementById("txt_be").focus();
			 return false;
			 
		 }
		 if(txt_FL=='SS'){

		 		var txt_amount=document.getElementById("txt_amount").value;
		 		var chk_prb=document.getElementById("chk_prb").value;
		 		if(txt_amount=='' || txt_amount<='0.00'){
					alert("กรุณา กรอกยอดชำระ");
				 	document.getElementById("txt_amount").focus();
				 	return false;
			 	}
			 	if(chk_prb==''){
					alert("กรุณา เลือก พรบ.");
				 	document.getElementById("chk_prb").focus();
				 	return false;
			 	}
		 		
		 	}

		 
		 if(txt_detail==''){
			 
			 alert("กรุณา กรอกรายละเอียด");
			 document.getElementById("txt_detail").focus();
			 return false;
			 
		 }
		  
		  
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Ajax_Save_Followup.php",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#webform")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						$(".modal").removeData('modal-body');
						$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
								
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
        
        $.ajax(options);
	
	 });
	
 });

</script>  
</form></td>
                            </tr>
                          </table>

                          
                        </span>
 </div>
      <!-- End tab -->



<div class="tab-pane fade" id="tab2">

<?php 
$sql_inv = "SELECT invoice.inv_no,invoice_detail.id_data FROM invoice INNER JOIN invoice_detail ON invoice.inv_no=invoice_detail.inv_no WHERE  invoice_detail.id_data='".$_GET["IDDATA"]."' AND invoice.status!='C' ";
mysql_select_db($db3,$cndb3);
$objQuery_inv = mysql_query($sql_inv,$cndb3) or die ("Error Query sql_inv [".$sql_inv."]");
$row_inv = mysql_fetch_array($objQuery_inv);
?>

  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
  <tr class="style1">
  	<!--<td width="100" height="23"><font size="2">รหัสตัวแทน</font></td>

    <td height="23">: 
    <?php if($row_inv[0]==''){?>
    	<strong><font size="2"><?php echo $row['full_name']; ?></font></strong> 
    <?php }else{?>
    	<span class="alert alert-info"><strong><font size="2"><?php echo $row['full_name']; ?></font></strong> </span> 
    <?php }?>
     </td>-->
    <td height="23"><font size="2">ประเภทประกัน</font></td>
    <td height="23">: <strong><font size="2"><?php echo $row['doc_type']; ?></font></strong>   </td>
    <td height="23"></td>
    <td height="23"></td>
  </tr>
    <tr class="style1">
      <td width="100" height="23"><font size="2">วันที่คุ้มครอง </font></td>
<td height="23">: <strong><font size="2"><?php echo thaiDate($row['start_date']); ?></font></strong>   </td>
      <td height="23"><font size="2">ประเภทการซ่อม</font></td>
      <td height="23">:<strong><font size="2">
      <?php 
			if($row['service'] == "1")
			{
				echo "ซ่อมห้าง";
			}
			if($row['service'] == "2")
			{
				echo "ซ่อมอู่";
			}			
			?></font></strong></td>
    </tr>
    <tr class="style1">
      <td height="23">ทะเบียนรถ </td>
      <td height="23">: <strong><font size="2"><?php echo $row['car_regis']; ?>&nbsp;
        <?php 
				$sql = "SELECT name_mini FROM tb_province WHERE id='".$row['car_regis_pro']."'";
				mysql_query("set NAMES utf8");
				$result = mysql_query( $sql );
		        $fetcharr = mysql_fetch_array( $result ) ;
				echo $fetcharr['name_mini'];
			 ?>
      </font></strong></td>
      <td height="23"><font size="2">ยี่ห้อ/รุ่นรถ </font></td>
      <td height="23">: <strong><font size="2"><?php echo $row['car_brand']; ?> / <?php echo $row['mo_car_name']; ?></font></strong></td>
    </tr>
    <tr class="style1">
      <td height="23"><font size="2">เลขตัวถัง </font></td>
      <td width="300" height="23">:<strong><font size="2"> 
	  	<?php 
				if($row['Cancel_policy2'] == "ยกเลิกกรมธรรม์")
				{
				?>
        <font color="#FF0000" style="background-color:#000000">ยกเลิกกรมธรรม์</font><font color="#FF0000">  วันที่ยกเลิก : <?php echo thaiDate($row['status_policy_time']); ?></font>
        <?    
				}
				else
				{
				?>
 				<?php echo $row['car_body']; ?>
		<?
                }			
				?>
                </font></strong></td>
      <td width="100" height="23"><font size="2">จำนวน ซี ซี / น.น.</font></td>
      <td height="23">: <?php echo $arrdata[0]['cc']; ?> / <?php echo $arrdata[0]['car_wg'] ; ?></font></td>
    </tr>
    <tr class="style1">
      <td height="23"><font size="2">เลขเครื่อง </font></td>
      <td height="23">:<strong><font size="2"> <?php 
				if($row['Cancel_policy2'] == "ยกเลิกกรมธรรม์")
				{
				?>
        <font color="#FF0000" style="background-color:#000000">ยกเลิกกรมธรรม์</font><font color="#FF0000">  วันที่ยกเลิก : <?php echo thaiDate($row['status_policy_time']); ?></font>
        <?    
				}
				else
				{
				?>
        <font size="2"><?php echo $row['n_motor']; ?></font>
      <?
                }			
				?></font></strong></td>
      <td height="23"><font size="2">ปีรถ</font></td>
      <td height="23">:<strong><font size="2"><?php echo $row['regis_date']; ?></font></strong></td>
    </tr>
    <tr class="style1">
      <td height="23"><font size="2">ผู้รับผลประโยชน์ </font></td>
      <td height="23">: <strong><font size="2"><?php echo $row['name_gain']; ?></font></strong></td>
      <td height="23"><font size="2">สีรถ</font></td>
      <td height="23">: <strong><font size="2"><?php echo $row['car_color']; ?></font></strong></td>
    </tr>
        <tr class="style1">
      <td height="23"><font size="2">เหตุผลยกเลิก </font></td>
      <td height="23" colspan="3">: <strong><font size="2" color="#FF0000"><?php echo $row['Cancel_policy']; ?></font></strong></td>
    </tr>
  </table>
  
  
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
    <tr class="style1">
      <td width="100" height="23"><font size="2">ผู้ขับขี่คนที่ 1</font></td>
      <td height="23">: <strong><font size="2"><?php if($row['name_num1']!="ไม่ระบุ"){ ?>
   	          <?php echo $row['title_num1']; ?> <?php echo $row['name_num1']; ?> <?php echo $row['last_num1'];  ?><? echo "[".$row['birth_num1']."]"; ?>
   	          <?php } else {?>
   	          <?php echo $row['name_num1']; ?>
   	          <?php }?>
 	          </font></strong></td>
      </tr>
   	      <tr>
   	     
   	        <td height="23"><font size="2">ผู้ขับขี่คนที่ 2</font></td>
   	        <td height="23">: <strong><font size="2"><?php if($row['name_num2']!="ไม่ระบุ" && $row['name_num2']!=""){ ?>
   	          <?php echo $row['title_num2']; ?> <?php echo $row['name_num2']; ?> <?php echo $row['last_num2'];  ?><? echo "[".$row['birth_num2']."]"; ?>
   	          <?php } else {?>
   	          <?php echo "ไม่ระบุ"; ?>
   	          <?php }?>
 	          </font></strong></td>
  
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
    <tr class="style1">
      <td width="100" height="23"><font size="2">ทุนประกันภัย</font></td>
      <td height="23">: <strong><font size="2">
   	          <?php 
					if($row['cost_old'] != "")
					{
				?>
   	          <font color="#FF0000"><strike><?php echo $row['cost_old']; ?></strike></font>
   	          <?    
					}
					else
					{
				?>
   	          <?php echo $row['cost']; ?>
   	          <?
                	}			
				?><?
					if($row['cost_old'] != "")
					{
				?>
   	          <font size="2">: <?php echo $row['cost']; ?></font>
   	          <?    
					}
            	?></font></strong></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
    <tr class="style1">
      <td width="30%" height="23" align="center">ความรับผิดชอบต่อบุคคลภายนอก</td>
      <td height="23" align="center">ความคุ้มครองตามเอกสารแนบท้าย</td>
    </tr>
    <tr class="style1">
      <td height="23" align="center"> <strong><font size="2">
      <?php 
					if($row['damage_out1_old'] != "")
					{
				?>
      <font color="#FF0000"><strike><?php echo $row['damage_out1_old']; ?></strike></font>
      <?    
					}
					else
					{
				?>
      <?php echo $row['damage_out1']; ?>
      <?
                	}			
				?>
      <?
					if($row['damage_out1_old'] != "")
					{
				?>
      <font size="2">: <?php echo $row['damage_out1']; ?></font>
      <?    
					}
            	?>
      </font></strong> บาท</td>
      <td height="23"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
        <tr class="style1">
          <td height="23" colspan="2">1.) อุบัติเหตุส่วนบุคคล</td>
          </tr>
        <tr class="style1">
          <td width="150" height="23">&nbsp;&nbsp;ก.) ผู้ขับขี่ 1 คน</td>
<td height="23"><strong><font size="2"><?php echo $row['pa1']; ?></font></strong> บาท</td>
        </tr>
        <tr>
          <td height="23">&nbsp;&nbsp;ข.) ผู้โดยสาร <strong><font size="2"><?php echo $row['people']; ?></font></strong> คน</td>
          <td height="23"><strong><font size="2"><?php echo $row['pa2']; ?></font></strong> บาท / คน</td>
        </tr>
        <tr>
          <td height="23">2.) ค่ารักษาพยาบาล</td>
          <td height="23"><strong><font size="2"><?php echo $row['pa3']; ?></font></strong> บาท / คน</td>
        </tr>
        <tr>
          <td height="23">3.) การประกันตัวผู้ขับขี่</td>
          <td height="23"><strong><font size="2"><?php echo $row['pa4']; ?></font></strong> บาท / ครั้ง</td>
        </tr>
      </table></td>
    </tr>
  </table>
  
  </div>
  
   <!-------------------Start Tab 3 การชำระ  -------------------------->
     
  <div class="tab-pane fade" id="tab3">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
      <tr class="style1">
        <td width="100" height="23"><font size="2"><div align="center">เบี้ยสุทธิ</div></font></td>
        <td width="100" height="23"><div align="center">เบี้ยรวม</div></td>
        <td width="100"><div align="center">เบี้ย พ.ร.บ.</div></td>
        <td width="100"><div align="center">หัก 1%</div></td>
        <td width="100"><div align="center">ส่วนลด</div></td>
        <td width="100"><div align="center">ยอดชำระ</div></td>
      </tr>
      <tr>
        <td height="23" align="center"><strong><font size="2"><div align="center">
          <? 
					if($row['total_pre_old'] != "")
					{
				?>
   	          <font color="#FF0000"><strike><? echo $row['total_pre_old']; ?></strike></font>
   	          <?    
					}
					else
					{
				?>
   	          <? echo $row['total_pre']; ?>
   	          <?
                	}			
				?> <?
					if($row['total_pre_old'] != "")
					{
				?>
   	          <font size="2"><br /><? echo $row['total_pre']; ?></font>
   	          <?    
					}
            	?>
        </div></font></strong></td>
        <td height="23" align="center"><strong><font size="2"><div align="center"><? 
					if($row['total_sum_old'] != "")
					{
				?>
   	          <font color="#FF0000"><strike><? echo $row['total_sum_old']; ?></strike></font>
   	          <?    
					}
					else
					{
				?>
   	          <? echo $row['total_sum']; ?>
   	          <?
                	}			
				?>
                <?
					if($row['total_sum_old'] != "")
					{
				?>
   	          <font size="2"><br /><? echo $row['total_sum']; ?></font>
   	          <?    
					}
            	?></div></font></strong>
                </td>
        <td align="center"><strong><font size="2"><div align="center"> <?
					if($row['prb_old'] != "")
					{
				?>
   	          <font color="#FF0000"><strike><? echo $row['prb_old']; ?></strike></font>
   	          <?    
					}
					else
					{
				?>
   	          <? echo $row['prb']; ?>
   	          <?
                	}			
				?> <?
					if($row['prb_old'] != "")
					{
				?>
   	          <font size="2"><br /><? echo $row['prb']; ?></font>
   	          <?    
					}
            	?></div></font></strong></td>
        <td align="center"> <strong><font size="2"><div align="center">
			<?
					if($row['vat_1_old'] != "")
					{
				?>
   	          <font color="#FF0000"><strike><? echo $row['vat_1_old']; ?></strike></font>
   	          <?    
					}
					else
					{
				?>
   	          <? echo $row['vat_1'];  } ?>
               <?
					if($row['vat_1_old'] != "")
					{
				?>
   	          <font size="2"><br /><? echo $row['vat_1']; ?></font>
        	<?
                	}		
				?></div></font></strong></td>
        <td align="center"><strong><font size="2"><div align="center">
		<? 
					if($com_and_other_old != "")
					{
				?>
   	          <font color="#FF0000"><strike><? echo number_format($com_and_other_old,2)." (".$dis_c_old." %)"; ?></strike></font>
   	          <?    
					}
					else
					{
				?>
   	          <? echo number_format($com_and_other,2)." (".$dis_c." %)"; ?>
   	          <?
                	}			
				?> <?
					if($com_and_other_old != "")
					{
				?>
   	          <font size="2"><br /><? echo number_format($com_and_other,2)." (".$dis_c." %)"; ?></font>
   	          <?    
					}
            	?>
        
        </div></font></strong></td>
        <td align="center">
        	<strong><font size="2"><div align="center">
			
			<? 
					if($row['total_commition_old'] != "")
					{
				?>
   	          <font color="#FF0000"><strike><? echo $row['total_commition_old']; ?></strike></font>
   	          <?    
					}
					else
					{
				?>
   	          <? echo $row['total_commition']; ?>
   	          <?
                	}			
				?> <?
					if($row['total_commition_old'] != "")
					{
				?>
   	          <font size="2"><br /><? echo $row['total_commition']; ?></font>
   	          <?    
					}
            	?>
		</div></font></strong></td>
      </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
      <tr class="style1"><td colspan="6">กรมธรรม์</td></tr>
      <tr>
        <td width="150">ใบวางบิล</td>
        <td width="150" height="23" bgcolor="#FFFFFF"><?php if($rowInvoice['inv_no'] == ''){ $Showinv_no = "ยังไม่วางบิล"; }else{ $Showinv_no = $rowInvoice['inv_no']; ?> <? } if($_SESSION["s_UsePrint"]=='Y'){?><a href="print/Billing.php?inv_no=<?=$rowInvoice['inv_no'];?>" target="_blank" ><?=$Showinv_no;?></a><br /><a class="btn btn-inverse" title="" rel="tooltip" target="_blank" href="print/print_discount_vouchers.php?inv_no=<?=$rowInvoice['inv_no'];?> " data-original-title="พิมพ์ใบส่วนลด"  ><i class="icon-white icon-print"></i> ส่วนลด</a> <?php }else{ echo $Showinv_no; ?> <br /><a class="btn btn-inverse" title="" rel="tooltip" target="_blank" href="print/print_discount_vouchers.php?inv_no=<?=$rowInvoice['inv_no'];?> " data-original-title="พิมพ์ใบส่วนลด"  ><i class="icon-white icon-print"></i> ส่วนลด</a> <? } ?></td>
        <td width="150" height="23">ใบรับเงิน</td>
        <td width="150" bgcolor="#FFFFFF"><?php if($rowCertificate['certificate_id'] == ''){ $Showcertificate_id = "ยังไม่ชำระ"; }else{ $Showcertificate_id = $rowCertificate['certificate_id']; }if($_SESSION["s_UsePrint"]=='Y'){?><a href="print/print_certificate_receipt.php?inv_no=<?=$rowCertificate['inv_no'];?>" target="_blank" ><?=$Showcertificate_id;?></a><?php }else{ echo $Showcertificate_id;} ?></td>
        <td width="150">ใบจ่ายเงิน</td>
        <td bgcolor="#FFFFFF" width="150"><?php if($rowCutpay['payd_no'] == ''){ $ShowCutpay = "ยังไม่ตัดจ่าย"; }else{ $ShowCutpay = $rowCutpay['payd_no']; }if($_SESSION["s_UsePrint"]=='Y'){?><a href="print/print_Cutpayment.php?pay_no=<?=$rowCutpay['payd_no'];?>&lik=pre" target="_blank" ><?=$ShowCutpay;?></a><?php }else{ echo $ShowCutpay;} ?></td>
      </tr>
      <tr class="style1"><td colspan="6">พรบ.</td></tr>
      <tr>
        <td width="150">ใบวางบิล</td>
        <td width="150" height="23" bgcolor="#FFFFFF"><? if($rowInvoice['prb'] == '0.00'){ $Showinv_no = "ไม่มี พรบ."; } else if($rowInvoice['prb'] != '0.00'){ ?><?php if($rowInvoice['inv_no'] == ''){ $Showinv_no = "ยังไม่วางบิล"; }else{ $Showinv_no = $rowInvoice['inv_no']; }} if($_SESSION["s_UsePrint"]=='Y'){?><a href="print/Billing.php?inv_no=<?=$rowInvoice['inv_no'];?>" target="_blank" ><?=$Showinv_no;?></a><?php }else{ echo $Showinv_no;} ?></td>
        <td width="150" height="23">ใบรับเงิน</td>
        <td width="150" bgcolor="#FFFFFF"><? if($rowInvoice['prb'] == '0.00'){ $Showinv_no = "ไม่มี พรบ."; } ?><?php if($rowCertificate['certificate_id'] == ''){ $Showcertificate_id = "ยังไม่ชำระ"; }else{ $Showcertificate_id = $rowCertificate['certificate_id']; }if($_SESSION["s_UsePrint"]=='Y'){?><a href="print/print_certificate_receipt.php?inv_no=<?=$rowCertificate['inv_no'];?>" target="_blank" ><?=$Showcertificate_id;?></a><?php }else{ echo $Showcertificate_id;} ?></td>
        <td width="150">ใบจ่ายเงิน</td>
        <td bgcolor="#FFFFFF" width="150"><?php if($rowCutpay_c['payd_no'] == ''){ $rowCutpay_c = "ยังไม่ตัดจ่าย"; }else{ $ShowCutpay_c = $rowCutpay_c['payd_no']; }if($_SESSION["s_UsePrint"]=='Y'){?><a href="print/print_Cutpayment.php?pay_no=<?=$rowCutpay_c['payd_no'];?>&lik=prb" target="_blank" ><?=$ShowCutpay_c;?></a><?php }else{ echo $ShowCutpay_c;} ?></td>
      </tr>
    </table>
  </div>  
  
  <!-------------------Start Tab 4 เอกสารในการจัดส่ง -------------------------->
  
   <div class="tab-pane fade" id="tab4">
   <form name="form_document" id="form_document" method="post"> 
   <div align="right" style="width:100%"><input type="hidden" id="countlist_document" value="0"/>
<?php
$sql_send = "SELECT * From tb_send_document where id_data='".$row["id_data"]."'AND status_pre='Y' order by id DESC limit 1";	  
mysql_select_db($db2,$cndb2);
$objQuery_send = mysql_query($sql_send,$cndb2) or die ("Error Query sql_send [".$sql_send."]");
$row_send = mysql_fetch_array($objQuery_send);
?> 
<?php
$sql_send_prb = "SELECT * From tb_send_document where id_data='".$row["id_data"]."' AND status_prb='Y' order by id DESC limit 1";	  
mysql_select_db($db2,$cndb2);
$objQuery_send_prb = mysql_query($sql_send_prb,$cndb2) or die ("Error Query sql_send_prb [".$sql_send_prb."]");
$row_send_prb = mysql_fetch_array($objQuery_send_prb);
?>
<? if($_SESSION["s_Group"]=='VIPS' || $_SESSION["4User"]=='POT' || $_SESSION["4User"]=='AEE' || $_SESSION["4User"]=='JIBB' || $_SESSION["4User"]=='MINTS' || $_SESSION["4User"]=='ADMIN'|| $_SESSION["4User"]=='DA'){ ?>
<?php if($row_send["status_pre"]==''){?>	<a  class="btn btn-small btn-danger" id="add-item_pre"> <i class="icon-plus"></i> นำส่ง กรมธรรม์ </a><?php }?> &nbsp; 
<?php if($row_send_prb["status_prb"]==''){?>	<a  class="btn btn-small btn-warning" id="add-item_prb"> <i class="icon-plus"></i> นำส่ง พ.ร.บ</a> &nbsp;<?php }?>
<a  class="btn btn-small " id="add-item_document"> <i class="icon-plus"></i> นำส่ง อื่นๆ</a> &nbsp; 
<a  class="btn btn-small btn-info " id="add-item_document_local"> <i class="icon-plus"></i> นำส่ง เอกสารภายใน</a>
<? }else{ ?>
	<a  class="btn btn-small btn-info " id="add-item_document_local"> <i class="icon-plus"></i> นำส่ง เอกสารภายใน</a>
<? } ?>
</div>
   <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
                                <tr class="style1">
        <td width="250" height="23"><div align="center">วันที่ส่ง</div></td>
        <td width="80"><div align="center">เลขที่นำส่ง</div></td>
        <td><div align="center">รายละเอียด</div></td>
        <td width="235" align="center"><div align="center">ที่อยู่ </div></td>
        <td width="60"><div align="center">ผู้นำส่ง</div></td>
      </tr>
      <?php
$sql_send = "SELECT * From tb_send_document where id_data='".$row["id_data"]."' order by date_send DESC";	  
mysql_select_db($db2,$cndb2);
$objQuery_send = mysql_query($sql_send,$cndb2) or die ("Error Query sql_fol [".$sql_send."]");
while($row_send = mysql_fetch_array($objQuery_send))
	{
?>
      
      <tr>
        <td height="25" >
        	<?=thaiDate($row_send["date_send"])?><br />
			<?php if($row_send["status_pre"]=='Y'){?>
            	<center>
                <a class="btn btn-success" title="" rel="tooltip" target="_blank" href="print/Print_pre_A4.php?IDDATA=<?=$row['id_data'];?> "  data-original-title="ซองA4 กธ."><i class="icon-white icon-print"></i> ซองA4 กธ.</a>
                <a class="btn btn-success" title="" rel="tooltip" target="_blank" href="print/Print_pre_m.php?IDDATA=<?=$row['id_data'];?> " data-original-title="ซองกลาง กธ."><i class="icon-white icon-print"></i> ซองกลาง กธ.</a>
                </center>
			<?php }?>
			<?php if($row_send["status_prb"]=='Y'){?>
                <center>
                <a class="btn btn-success" title="" rel="tooltip" target="_blank" href="print/Print_prb_A4.php?IDDATA=<?=$row['id_data'];?> " data-original-title="ซองA4 พ.ร.บ"><i class="icon-white icon-print"></i> ซองA4 พ.ร.บ</a>
                <a class="btn btn-success" title="" rel="tooltip" target="_blank" href="print/Print_prb_m.php?IDDATA=<?=$row['id_data'];?> " data-original-title="ซองกลาง พ.ร.บ"><i class="icon-white icon-print"></i> ซองกลาง พ.ร.บ</a>
                </center>
			<?php }?>
			<?php if($row_send["status_prb"]=='' && $row_send["status_pre"]==''){?>
            	<center>
                <a class="btn btn-success" title="" rel="tooltip" target="_blank" href="print/Print_other_A4.php?IDDATA=<?=$row['id_data'];?> " data-original-title="ซองA4 อื่นๆ"><i class="icon-white icon-print"></i> ซองA4 อื่นๆ</a>
                <a class="btn btn-success" title="" rel="tooltip" target="_blank" href="print/Print_other_m.php?IDDATA=<?=$row['id_data'];?> " data-original-title="ซองกลาง อื่นๆ"><i class="icon-white icon-print"></i> ซองกลาง อื่นๆ</a>
                </center>
			<?php }?>
        </td>
        <td ><?=$row_send["send_no"]?></td>
        <td ><?=$row_send["detail"]?></td>
        <td ><?=$row_send["address"]?></td>
        <td ><?=$row_send["login_emp"]?></td>
      </tr> 
 <?php }?> 
 <tbody id="selectlist_document"></tbody>
  </table>

<script>

jQuery.fn.simulateClick = function() {
    return this.each(function() {
        if('createEvent' in document) {
            var doc = this.ownerDocument,
                evt = doc.createEvent('MouseEvents');
            evt.initMouseEvent('click', true, true, doc.defaultView, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
            this.dispatchEvent(evt);
        } else {
            this.click(); // IE
        }
    });
}




$( "#add-item_pre" ).click(function( event ) {
	
var listcount_document= document.getElementById("countlist_document").value;	


	listcount_document++;


$('#selectlist_document').append('<tr><td width="80" height="23" ><input name="txt_status" type="hidden" class="span2" id="txt_status"  style="width:80px;" value="pre"  /><input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']; ?>"  /><input name="txt_date" type="text" class="span2" id="txt_date"  style="width:90px;" value="<?=date('d/m/Y')?>" readonly/></td><td width="80" ><input name="txt_sendno" type="text" class="span2" id="txt_sendno"  style="width:110px;"  placeholder="เลขที่นำส่ง" onblur="checkText();" value = ""/></td><td width="230" ><textarea name="txt_detail" id="txt_detail" style="width:230px;" placeholder="เลขที่แจ้งงาน" required="required"><?=$row['id_data']; ?></textarea></td><td width="235" ><textarea name="txt_address" id="txt_address" style="width:235px;" placeholder="ที่อยู่" required="required"><?php 
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
                ?></textarea></td><<td width="14%" ><button class="btn btn-small btn-success" id="save_document" type="button">บันทึก กรรมธรรม์</button></td></tr>');

$('#countlist_document').val(listcount_document);


	
 $("#save_document").click(function() {
if($("#txt_sendno").val()==''){
			 $("#txt_sendno").focus();
			 alert('กรุณากรอกเลขที่นำส่ง');
			 return false;	
	 }

		  var DATA = $('#form_document').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_document")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);

						$(".modal").removeData('modal-body');
						$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
						
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
								
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });
	
 });

</script>

<script>


$( "#add-item_prb" ).click(function( event ) {
	
var listcount_document= document.getElementById("countlist_document").value;	


	listcount_document++;


$('#selectlist_document').append('<tr><td width="80" height="23" ><input name="txt_status" type="hidden" class="span2" id="txt_status"  style="width:80px;" value="prb"  /><input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']; ?>"  /><input name="txt_date" type="text" class="span2" id="txt_date"  style="width:90px;" value="<?=date('d/m/Y')?>" readonly/></td><td width="80" ><input name="txt_sendno" type="text" class="span2" id="txt_sendno"  style="width:110px;"  placeholder="เลขที่นำส่ง" onblur="checkText();" value = ""/></td><td width="230" ><textarea name="txt_detail" id="txt_detail" style="width:230px;" placeholder="เลขที่แจ้งงาน" required="required"><?=$row['id_data']; ?></textarea></td><td width="235" ><textarea name="txt_address" id="txt_address" style="width:235px;" placeholder="ที่อยู่" required="required"><?php 
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
                ?></textarea></td><<td width="14%" ><button class="btn btn-small btn-success" id="save_document" type="button">บันทึก พ.ร.บ</button></td></tr>');

$('#countlist_document').val(listcount_document);


	
 $("#save_document").click(function() {
	if($("#txt_sendno").val()==''){
			 $("#txt_sendno").focus();
			 alert('กรุณากรอกเลขที่นำส่ง');
			 return false;	
	 }

		  var DATA = $('#form_document').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_document")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);


						$(".modal").removeData('modal-body');
						$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());


						
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
								
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });
	
 });

</script>
  
<script>
function SaveDocumentLocal( prmTrID ) {
		if($("#department").val()=='N'){
			 $("#department").focus();
			 alert('กรุณาเลือกแผนก');
			 return false;	
	 }
		else if($("#txt_employee").val()=='N'){
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
	var options = 
	{
		type: "POST",
		dataType: "json",
		url: "ajax/Save_Checklist4_Document.php",
		data: dataDocumentLocal,
		async:false,
		success: function(msg) {
			var returnedArray = msg;
			if(returnedArray.status==true){
				$("#form_document")[0].reset();
				$("#closed").click();
				alert(returnedArray.msg);


					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val(),function(){
						$('#modal').find('a[href="#tab4"]').simulateClick("click");
					});
						
				// $(".modal").hide();
				// $(".modal-backdrop").hide();		
				// $(".modal").removeData('modal');
			}
			else{
				alert(returnedArray.msg);
			}
		}
	};
	$.ajax(options);

	

}


$('#add-item_document_local').click( function( e ) {
	var lcd = $('#countlist_document');
	var lcdv = lcd.val();
	lcdv++;
	var _tempHtml = "";
	var _tempHtml="";
	_tempHtml += "<tr id=\"dl"+lcdv+"\">";
	_tempHtml += "	<td width=\"80\" height=\"23\">";
	_tempHtml += "		<input type=\"hidden\" name=\"id_data\" value=\"<?=$row['id_data']; ?>\" />";
	_tempHtml += "		<input type=\"hidden\" name=\"send_local_document\" value=\"1\" \/>";
	_tempHtml += "		<input name=\"txt_date\" type=\"text\" class=\"span2\" style=\"width:90px;\" value=\"<?php echo date('d/m/Y'); ?>\" readonly=\"\" \/><\/td>";
	_tempHtml += "	<td width=\"80\">";
	<?php
	$id_data_arr = explode("/", $row['id_data']);
	?>
	_tempHtml += "		<input name=\"txt_sendno\" type=\"text\" class=\"span2\" id=\"txt_sendno\" style=\"width:110px;\" placeholder=\"เลขที่นำส่ง\" readonly=\"readonly\" value=\"<?php echo $id_data_arr[0].'-'.$id_data_arr[2];?>\" \/>";
	_tempHtml += "	<\/td>";
	_tempHtml += "	<td width=\"230\">";
	_tempHtml += "		<textarea name=\"txt_detail\" id=\"txt_detail\" style=\"width:230px;\" placeholder=\"รายละเอียด\" required=\"required\"><\/textarea>";
	_tempHtml += "	<\/td>";
	_tempHtml += "	<td width=\"235\">";
	_tempHtml += "		<select name=\"txt_department\" id=\"department\" style=\"width:230px;\">";
	_tempHtml += "			<option value=\"N\">-- เลือกแผนก --<\/option>";
	<?php
	mysql_select_db($db_hr,$cndb_hr);
	$departments = mysql_query('SELECT * FROM department', $cndb_hr);
	while ( $department = mysql_fetch_array($departments)){
	?>
	_tempHtml += "			<option value=\"<?php echo $department['DepartmentName_TH']; ?>\"><?php echo $department['DepartmentName_TH']; ?><\/option>";
	<?php } ?>
	_tempHtml += "		<\/select>";
	
	_tempHtml += "		<select name=\"txt_employee\" id=\"txt_employee\" style=\"width:230px;\">";
	_tempHtml += "			<option value=\"-- ไม่ได้เลือก --\">-- เลือกพนักงาน --<\/option>";
	_tempHtml += "		<\/select>";
	
	_tempHtml += "	<\/td>";
	_tempHtml += "	<td width=\"14%\">";
	_tempHtml += "		<button class=\"btn btn-small btn-success\" onclick=\"SaveDocumentLocal('#dl"+lcdv+"')\" type=\"button\">บันทึก<\/button>";
	_tempHtml += "		<\/td>";
	_tempHtml += "<\/tr>";
	$('#selectlist_document').append(_tempHtml);
	lcd.val(lcdv);
	
	$("#department").change(function() {
		var _selected = $("#department").val();		
		//console.log(_selected);

		var options = 
		{
			type: "POST",
			dataType: "json",
			url: "ajax/Ajax_employee.php",
			data: {callajax:'EMP',
			emp:_selected,
		},
			success: function(msg)
			{
				var returnedArray = msg;
				$('#txt_employee').empty(); 
				txt_employee = $("#txt_employee");
				txt_employee.append("<option value='N'>---กรุณาเลือกพนักงาน---</option>");
				if(returnedArray!=null)
				{
					for (i = 0; i < returnedArray.length; i++)
					{
						txt_employee.append("<option value='" + returnedArray[i].ID_EMP + "'>" + returnedArray[i].emp_name + "</option>");
					}
				}
				else
				{
					return false;				 
				}		
			}
		};
		$.ajax(options);
	});
	
});

//
$( "#add-item_document" ).click(function( event ) {
	

var listcount_document= document.getElementById("countlist_document").value;	


	listcount_document++;


$('#selectlist_document').append('<tr><td width="80" height="23" ><input name="txt_iddata" type="hidden" class="span2" id="txt_iddata"  style="width:80px;" value="<?=$row['id_data']; ?>"  /><input name="txt_date" type="text" class="span2" id="txt_date"  style="width:90px;" value="<?=date('d/m/Y')?>" readonly/></td><td width="80" ><input name="txt_sendno" type="text" class="span2" id="txt_sendno"  style="width:110px;"  placeholder="เลขที่นำส่ง" onblur="checkText();" value = ""/></td><td width="230" ><textarea name="txt_detail" id="txt_detail" style="width:230px;" placeholder="รายละเอียด" required="required"></textarea></td><td width="235" ><textarea name="txt_address" id="txt_address" style="width:235px;" placeholder="ที่อยู่" required="required"><?php 
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
						
                ?> </textarea></td><<td width="14%" ><button class="btn btn-small btn-success" id="save_document" type="button">บันทึก</button></td></tr>');

$('#countlist_document').val(listcount_document);


	
 $("#save_document").click(function() {
if($("#txt_sendno").val()==''){
			 $("#txt_sendno").focus();
			 alert('กรุณากรอกเลขที่นำส่ง');
			 return false;	
	 }

		  var DATA = $('#form_document').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_document")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
								$(".modal").hide();
								$(".modal-backdrop").hide();		
								$(".modal").removeData('modal');
								
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });
	
 });

</script>  </form>
   </div>
   
   <!------------------- END Tab 4 เอกสารในการจัดส่ง -------------------------->

    <!-------------------Start Tab 5 เบิกกรม -------------------------->
  
   <div class="tab-pane fade" id="tab5">
   <form name="form_documentpolicy" id="form_documentpolicy" method="post"> 
   <div align="right" style="width:100%"><input type="hidden" id="countlist_document" value="0"/>
<?php
$sql_policy = "SELECT * From  tb_policy where policy_iddata='".$row["id_data"]."' ";	  
mysql_select_db($db2,$cndb2);
$objQuery_policy = mysql_query($sql_policy,$cndb2) or die ("Error Query sql_send_prb [".$sql_policy."]");
$row_policy = mysql_fetch_array($objQuery_policy);
?>
<?php if($row_policy["policy_date"]==''){?>	   
   <a  class="btn btn-small btn-danger" id="add-item_documentpolicy"> <i class="icon-plus"></i> เบิกกรมธรรม์ </a><?php }?> </div>
   <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
                                <tr class="style1">
        <td><div align="center">วันที่เบิก</div></td>
        <td><div align="center">ผู้เบิก</div></td>
        <td><div align="center">ผู้ทำเรื่องเบิก</div></td>
      </tr>
      <?php
$sql_send = "SELECT * From tb_policy where policy_iddata='".$row["id_data"]."' order by policy_date DESC";	  
mysql_select_db($db2,$cndb2);
$objQuery_send = mysql_query($sql_send,$cndb2) or die ("Error Query sql_fol [".$sql_send."]");
while($row_send = mysql_fetch_array($objQuery_send))
	{
?>
      
      <tr>
        <td><?=$row_send["policy_date"]?></td>
        <td ><?=$row_send["policy_personal"]?></td>
        <td ><?=$row_send["policy_user"]?></td>
      </tr> 
 <?php }?> 
 <tbody id="selectlist_documentpolicy"></tbody>
  </table>

<script>
	$( "#add-item_documentpolicy" ).click(function( event ) {
$('#selectlist_documentpolicy').append('<tr><td height="23" width="40%"><input name="txt_iddata-po" type="hidden" class="span2" style="width:150px;" id="txt_iddata-po"  value="<?=$row['id_data']; ?>"  /><input name="txt_date-po" type="text" class="span2" style="width:150px;" id="txt_date-po"  value="<?=date('d/m/Y')?>" readonly/></td><td><input name="txt_personal-po" type="text" class="span2" style="width:150px; id="txt_personal-po"  value="" /></td><td width="80px;" ><button class="btn btn-small btn-success" id="save_documentpolicy" type="button">บันทึก</button></td></tr>');


 $("#save_documentpolicy").click(function() 
 {
	  var DATA = $('#form_documentpolicy').serialize();
       var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?policy=2",
			 data: DATA,
             success: function(msg) 
			 {
				 var returnedArray = msg;
				 if(returnedArray.status==true)
				 {
				 	$("#closed").click();
					alert(returnedArray.msg);
						
					$(".modal").hide();
					$(".modal-backdrop").hide();		
					$(".modal").removeData('modal');			
				 }
				 else
				 {
					 alert(returnedArray.msg);
				 }
			 }
         };
         $.ajax(options);
	});

	 });
</script>  
</form>

   </div>
   
   <!------------------- END Tab 5 เบิกกรม -------------------------->
   
    <!-------------------Start Tab 6 เอกสาร ลูกค้า -------------------------->
    <div class="tab-pane fade" id="tab6">
    <center> <h4>**Upload เอกสารการชำระเงิน**</h4></center> 
	<form action="pages/upload_pay_save.php" method="post" enctype="multipart/form-data" name="fileupload" target="fileupload">
	<iframe id="fileupload" name="fileupload" src="#" style="width:0;height:0;border:0px solid #fff; display:none"></iframe>
		<input type="hidden" name="iddta" value="<?php echo $row['id_data']; ?>" />
        <input type="hidden" name="login" value="<?php echo $row['login']; ?>" />
        <input type="hidden" name="name_inform" value="<?php echo $row['name_inform']; ?>" />
        <input type="hidden" name="payfile" value="<?php echo $row['pay_file']; ?>" />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
		<tr class="style1">
			<td>ชื่อเอกสาร :
    			<select id="name_pay" name="name_pay">
    				<option value="N">กรุณาเลือก</option>
        			<option value="1">ใบขับขี่</option>
        			<option value="2">บัตรประชาชน</option>
        			<option value="3">เอกสารการชำระเงิน</option>
        			<option value="4">สำเนาทะเบียนรถ</option>
                    <option value="5">เอกสารตัดบัตรเครดิต</option>
                    <option value="6">หน้าสมุดบัญชี</option>
                    <option value="7">เอกสารการยกเลิก</option>
                    <option value="8">แผนที่</option>
                    <option value="9">เอกสารยืนยันการแจ้งประกัน</option>
    			</select>
    		</td>
    		<td>File: <input type=file name="userfile"></td>
		</tr>
	</table>   
    <div align="right"><input class="btn btn-small btn-success" name="Save" type="submit" id="Save" value="บันทึกข้อมูล"/></div>
    </form>
   <!-- // แสดงรายการไฟล์แที่ upload ด้านล่าง -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
       	<tr class="style1"><td><div align="center">เลขรับแจ้ง</div></td><td><div align="center">เอกสาร</div></td></tr>
        <tr align="center"><td rowspan="2"><b><?= $row['id_data'];?></b></td></tr>
        <tr align="center">
        	<td>
            	<?
					$iddtastamp = split("\|",$row['pay_file']);
					foreach ($iddtastamp as $val_pic)
					{
						$date_pdf = split("\+",$val_pic); // ตัดเวลาข้างหลัง
						$file_pdf = split("\.",$date_pdf[0]); // เช็คสกุลไฟล์ว่า คืออะไร
						$path_file = split("_",$date_pdf[0]); // ตัดชื่อไฟล์
						if($file_pdf[1] == "pdf" && $val_pic !="")
						{
							?>
        					<center>
        					<br />
        					<a href="../../4ib/Myfile/<?=$path_file[1]."_".$path_file[2];?>"target="_blank" ><? echo "<b>".$path_file[0]."</b>"; ?></a> 
                			<br />
                			<? if($date_pdf[1] != ''){echo "วันที่ upload ".thaiDate($date_pdf[1]);} ?>
                			</center>
        					<?	
						}
						else if ($val_pic !="")
						{
							?>
        					<center>
        					<br />
       						<a href="../../4ib/Myfile/<?=$path_file[1]."_".$path_file[2];?>" target="_blank"><img src="<? echo '../../4ib/Myfile/'.$path_file[1]."_".$path_file[2];?>" width="70%"></a>
                			<br />
							<? 
                    		echo "<b>".$path_file[0]."</b>";
                			?>
                			<br />
                			<? if($date_pdf[1] != ''){echo "วันที่ upload ".thaiDate($date_pdf[1]);} ?>
                			</center>
        					<?		
						}
        			}
    			?>
        	</td>
    	</tr>
	</table>
    <!-- //////////////////////////////////////////////////////////// -->
    </div>
    <!------------------- END Tab 6 เอกสาร ลูกค้า -------------------------->
  
    <!-------------------Start Tab 7 เตือนยกเลิก -------------------------->
    <div class="tab-pane fade" id="tab7">
    	<? 
		$query_warning = "select COUNT(id_data) as count  from warning where id_data ='".$row['id_data']."' group by id_data";
		mysql_select_db($db3,$cndb3);
		$objQuery_warning = mysql_query($query_warning,$cndb3) or die ("Error Query tb_data [".$query_warning."]");
		$row_warn = mysql_fetch_array($objQuery_warning);
		?>
<form id="warn_idin" name="warn_idin" method="POST">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">

	<input name="txt_iddata_w" type="hidden" class="span2" id="txt_iddata_w"  style="width:120px;" value="<?=$row['id_data']; ?>" />



	<tr class="style1">
        	<td><div align="center">จำนวนการแจ้งเตือนยกเลิก</div></td>
                <td><div align="center"><?=$row_warn['count'];?></div></td>	
	 </tr>		   
	<tr class="style1">			
	<td> <a class="btn btn-success"  id="warn" name="warn" title="" rel="tooltip" target="_blank" href="print/Warning.php?IDDATA=<?=$row['id_data'];?>" ><i class="icon-white icon-print"> </i> พิมพ์เตือนยกเลิก</a></td>			
	<td></td>
	</tr>
	</table></form>
    </div>
    <!------------------- END Tab 7 เตือนยกเลิก ------------------------->
  	
    <!-------------------Start Tab 8 ยกเลิกกรมธรรม์ -------------------------->
    <div class="tab-pane fade" id="tab8">
    	    <? if($_SESSION["s_Group"]=='VIPS' || $_SESSION["4User"]=='JIBB' || $_SESSION["4User"]=='NAPAT' || $_SESSION["4User"]=='EMPLOYEE'){ ?>
            <? if($row_q['qstatus'] == 'Q'){ ?>
             	<form id="form_Cancel_mblt" name="form_Cancel_mblt" method="POST">
             <? }else{ ?>
               	<form id="form_Cancel" name="form_Cancel" method="POST">
             <? } ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
        <tr>
                   <td>
                        <center><h3>ยกเลิกกรมธรรม์</h3></center>
                    </td>
        </tr>
        <tr>
                   <td>
                   <center>
                   <input name="up_user_up1" type="hidden" id="up_user_up1"  size="10" value="<?= $_SESSION["4User"]; ?>" readonly="readonly"/>
                    <input type="text" name="iddta" id="iddta" value="<?= $row['id_data']; ?>" readonly="readonly" />
                  <input type="text"  id="q_car_body" name="q_car_body" value="<?= $row['car_body']; ?>" readonly="readonly" />
                  <input type="hidden"  id="qstatus" name="qstatus" value="<?= $row_q['qstatus']; ?>" readonly="readonly" />
                  <input type="text"  id="Cancel_policy2" name="Cancel_policy2" value="ยกเลิกกรมธรรม์" readonly="readonly" />
                  </center>
                    </td>
        </tr>
        <tr>
                    <td>
                    <center>
                    <? if($row['Cancel_policy'] != ''){ ?>
                      <textarea name="Cancel_policy" cols="300" rows="3" id="Cancel_policy"  readonly="readonly"><?= $row['Cancel_policy']; ?></textarea>
                      <? }else{?>
                      	<textarea name="Cancel_policy" cols="300" rows="3" id="Cancel_policy" ><?= $row['Cancel_policy']; ?></textarea>
                      <? } ?>
                      </center>
                      </td>
        </tr>
        <tr>
        	<td>
            <center>
				<? if($row['Cancel_policy'] == ''){ ?>
                
                	<? if($row_q['qstatus'] == 'Q'){ ?>
                		<button class="btn btn-small btn-danger" id="save_Cancel_MBLT" type="button">บันทึก ยกเลิกกรมธรรม์</button>
                    <? }else{ ?>
                    	<button class="btn btn-small btn-danger" id="save_Cancel" type="button">บันทึก ยกเลิกกรมธรรม์</button>
                    <? } ?>
                    
				<? } ?>
            </center>    
        	</td>
        </tr>
        </table>
        </form>
        <? } ?>
    </div>
    <!------------------- Tab 8 ยกเลิกกรมธรรม์ -------------------------->
    
</div>
      
    <?php } ?>    
      
      </body></html>
      
 <script>
 /*
$("#Save_file").click(function()
{
	if($("#name_pay").val()=='N')
	{
		$("#name_pay").focus();
		alert('กรุณาเลือกชื่อเอกสาร');
		return false;	
	}
	 
	var DATA = $('#form_upload').serialize();
    var options = 
    {
    	type: "POST",
		dataType: "json",
        url: "ajax/Save_Checklist4_Document.php?file=2",
		data: DATA,
        success: function(msg)
		{
			var returnedArray = msg;
			if(returnedArray.status==true)
			{
				$("#form_upload")[0].reset();
				$("#closed").click();
				alert(returnedArray.msg);
				//$( ".modal_m" ).trigger( "click" );
					
				$(".modal").hide();
				$(".modal-backdrop").hide();		
				$(".modal").removeData('modal');
			}
			else
			{
				alert(returnedArray.msg);	
			}
		}
    };
    $.ajax(options);
});
*/      
$("#save_plus").click(function() {

		  var DATA = $('#form_plus').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?plus=2",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_plus")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });


 $("#save_actid").click(function() {

		  var DATA = $('#form_actid').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?act=2",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_actid")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
						$(".modal").removeData('modal-body');
						$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });

	  $("#save_idin").click(function() {
		  var DATA = $('#form_idin').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?id_dd=2",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_actid")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });
	 $("#save_idrobbery").click(function() {
		  var DATA = $('#form_idrobbery').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?id_robbery=2",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_idrobbery")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });
	
$("#warn").click(function() {
		  var DATA = $('#warn_idin').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Ajax_Save_warning.php",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
				


					 $("warn_idin")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });
	 
	 	 $("#save_Cancel").click(function() {
		 var DATA = $('#form_Cancel').serialize();
         var options = 
         {
         	type: "POST",
			dataType: "json",
            url: "ajax/Ajax_cancel_policy_save.php?",
			data: DATA,
            success: function(msg) 
			{
				var returnedArray = msg;
				if(returnedArray.status==true)
				{
					$("#closed").click();
					
					alert(returnedArray.msg);
					
					$(".modal").hide();
					$(".modal-backdrop").hide();		
					$(".modal").removeData('modal');
				}
				else
				{
					alert(returnedArray.msg);
				}
			}
        };
         $.ajax(options);
	
	 });
	 
	 	 $("#save_Cancel_MBLT").click(function() {
		 var DATA = $('#form_Cancel_mblt').serialize();
         var options = 
         {
         	type: "POST",
			dataType: "json",
            url: "ajax/Ajax_cancel_policy_save.php?",
			data: DATA,
            success: function(msg) 
			{
				var returnedArray = msg;
				if(returnedArray.status==true)
				{
					$("#closed").click();
					
					alert(returnedArray.msg);
					
					$(".modal").hide();
					$(".modal-backdrop").hide();		
					$(".modal").removeData('modal');
				}
				else
				{
					alert(returnedArray.msg);
				}
			}
        };
         $.ajax(options);
	
	 });

// add tel_mobile

$("#save_tel1").click(function() {

		  var DATA = $('#form_tel1').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?tel_mo=1",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_tel1")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
					
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });	 
$("#save_tel2").click(function() {

		  var DATA = $('#form_tel2').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?tel_mo=2",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_tel2")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });	
$("#save_tel3").click(function() {

		  var DATA = $('#form_tel3').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?tel_mo=3",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_tel3")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
											
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });	

$("#save_claim").click(function() {

		  var DATA = $('#form_claim').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?claim=1",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_claim")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });


$("#save_policy").click(function(e) {

		  var DATA = $('#form_policy').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?policy=1",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_policy")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						

						$(".modal").removeData('modal-body');
						 $('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
						/*
								$(".modal").hide();
								$(".modal-backdrop").hide();		
								$(".modal").removeData('modal');
						*/
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });

// ---------- ที่อยู่ในการจัดส่ง -----------------//

$("#save_SendAdd").click(function() {

		  var DATA = $('#form_SendAdd').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?SendAdd=1",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_SendAdd")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						

						$(".modal").removeData('modal-body');
						$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });

// ---------- เบอร์บ้าน -----------------//

$("#show_telhome").click(function() {
	$('#form_telhome').show();
});

$("#show_telhome2").click(function() {
	$('#form_telhome2').show();

});

$("#save_telhome").click(function() {

		  var DATA = $('#form_telhome').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?telhome=1",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_telhome")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });

$("#save_telhome2").click(function() {

		  var DATA = $('#form_telhome2').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?telhome2=1",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_telhome2")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });

// ---------- เบอร์แฟก์ -----------------//
$("#show_fax").click(function() {
	$('#form_fax').show();
});

$("#show_fax2").click(function() {
	$('#form_fax2').show();

});


$("#save_fax").click(function() {

		  var DATA = $('#form_fax').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?fax=1",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_fax")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });

$("#save_fax2").click(function() {

		  var DATA = $('#form_fax2').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?fax2=1",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_fax2")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });

// ---------- Email -----------------//
	$("#show_email").click(function() {
		$('#form_email').show();
	});

	$("#show_email2").click(function() {
		$('#form_email2').show();

	});

$("#save_email").click(function() {


		 var DATA = $('#form_email').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?email=1",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_email")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });


$("#save_email2").click(function() {


		 var DATA = $('#form_email2').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?email2=1",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_email2")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });

// ---------- ID LINE -----------------//
	$("#show_idline").click(function() {
		$('#form_idline').show();
	});

	$("#show_idline2").click(function() {
		$('#form_idline2').show();

	});

$("#save_idline").click(function() {

		  var DATA = $('#form_idline').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?idline=1",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_idline")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());

											
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });

$("#save_idline2").click(function() {

		  var DATA = $('#form_idline2').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_Checklist4_Document.php?idline2=1",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_idline2")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });


function fuc_barcode(){
	var txt_detail =$("#txt_detail").val();
	var str_detail=txt_detail.substr(-13);
	var txt_array=txt_detail.replace(str_detail,'');

	var options=
	{
		type:"POST",
		dataType:"json",
		url:"ajax/Barcode_4follow.php",
		data:{ DATA:str_detail},
		success:function(msg){
			var returnedArray=msg;

				if(returnedArray.status==true){
					
					$("#txt_detail").val(txt_array+' '+returnedArray.name);

				}else{
					alert(returnedArray.msg);
				}
		}
	};
	$.ajax(options);
}

//save Renew

/*
$("#chk_prerenew").click(function() {
	$("#chk_prerenew").hide("slow");
	$("#save_prerenew").show("slow");

	$("#inp_cost").removeAttr( "readonly" ).css('background-color', '#ffff00');
	$("#inp_pre").removeAttr( "readonly" ).css('background-color', '#ffff00');
	$("#inp_net").removeAttr( "readonly" ).css('background-color', '#ffff00');

});



$("#save_prerenew").click(function() {

		  var DATA = $('#form_prerenew').serialize();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Save_prerenew.php",
			 data: DATA,
             success: function(msg) {
				 var returnedArray = msg;
				 if(returnedArray.status==true){
					 $("#form_prerenew")[0].reset();
					 $("#closed").click();
						alert(returnedArray.msg);
						
						
						
					$(".modal").removeData('modal-body');
					$('#modal').find('.modal-body').load('pages/view4.php?IDDATA=' + $('#txt_iddata').val());
					
								// $(".modal").hide();
								// $(".modal-backdrop").hide();		
								// $(".modal").removeData('modal');
						
				 }
				 else{
					 alert(returnedArray.msg);
					
				 }
			     }
         };
         $.ajax(options);
	
	 });
*/

function txt_be_show(obj) {
	var _chk_txt = obj.value;
	if(_chk_txt.indexOf('CN') > -1) {
		$('#txt_be').show();
	} else {
		$('#txt_be').hide();
	}
}
</script>








