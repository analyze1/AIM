<?php
include "check-ses.php"; 
//include "../inc/checksession.inc.php";
include "../inc/connectdbs.inc.php";
//include "../inc/session_renew.php";
//include "../inc/session_car.php";
//	function thaiDate($datetime)
//	{
//		list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
//		list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
//		list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
//		$Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.
//		switch($m) 
//		{
//			case "01": $m = "01"; break;
//			case "02": $m = "02"; break;
//			case "03": $m = "03"; break;
//			case "04": $m = "04"; break;
//			case "05": $m = "05"; break;
//			case "06": $m = "06"; break;
//			case "07": $m = "07"; break;
//			case "08": $m = "08"; break;
//			case "09": $m = "09"; break;
//			case "10": $m = "10"; break;
//			case "11": $m = "11"; break;
//			case "12": $m = "12"; break;
//		}
//		return $d."/".$m."/".$Y;
//	}
//	
//	function thaiDate2($datetime)
//	{
//		list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
//		list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
//		list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
//		$Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.
//		switch($m) 
//		{
//			case "01": $m = "01"; break;
//			case "02": $m = "02"; break;
//			case "03": $m = "03"; break;
//			case "04": $m = "04"; break;
//			case "05": $m = "05"; break;
//			case "06": $m = "06"; break;
//			case "07": $m = "07"; break;
//			case "08": $m = "08"; break;
//			case "09": $m = "09"; break;
//			case "10": $m = "10"; break;
//			case "11": $m = "11"; break;
//			case "12": $m = "12"; break;
//		}
//	return $d."/".$m."/".$Y."  ".$H.":".$i.":".$s;
//	} 
//	
//	function paytype($pay)
//	{
//		switch($pay) 
//		{
//			case "CASH": $pay = "เงินสด"; break;
//			case "CCB": $pay = "เช็ค"; break;
//			case "SMT": $pay = "โอน"; break;
//			case "CREDIT": $pay = "บัตรเครดิต"; break;
//			case "TAX1": $pay = "1%"; break;
//			case "VIB": $pay = "วิริยะ"; break;
//		}
//		return $pay;
//	}
//	
//	function banktype($bank)
//	{
//		switch($bank) 
//		{
//			case "BBK": $bank = "กรุงเทพ"; break;
//			case "KTB": $bank = "กรุงไทย"; break;
//			case "BAY": $bank = "กรุงศรีฯ"; break;
//			case "KBANK": $bank = "กสิกรไทย"; break;
//			case "SCB": $bank = "ไทยพาณิชย์"; break;
//			case "TNN": $bank = "ธนชาต"; break;
//			case "CIMB": $bank = "CIMB THAI"; break;
//			case "CITY": $bank = "City Bank"; break;
//			case "CENTRAL": $bank = "Central Card"; break;
//			case "TESCO": $bank = "Tesco"; break;
//			case "0": $bank = "-"; break;
//			case " ": $bank = "-"; break;
//		}
//		return $bank;
//	}
//
//    function Showtime($datetime)
//  {
//    list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
//    list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
//    list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
//    $Y = $Y+543; // เปลี่ยน ค.ศ. เป็น พ.ศ.
//    switch($m) 
//    {
//      case "01": $m = "01"; break;
//      case "02": $m = "02"; break;
//      case "03": $m = "03"; break;
//      case "04": $m = "04"; break;
//      case "05": $m = "05"; break;
//      case "06": $m = "06"; break;
//      case "07": $m = "07"; break;
//      case "08": $m = "08"; break;
//      case "09": $m = "09"; break;
//      case "10": $m = "10"; break;
//      case "11": $m = "11"; break;
//      case "12": $m = "12"; break;
//    }
//  return $H.":".$i;
//  } 
//  function renew($renew)
//	{
//		switch($renew) 
//		{
//			case "R": $renew = "ติดตาม"; break;
//			case "S": $renew = "เสนอราคา"; break;
//			case "C": $renew = "แจ้งงาน"; break;
//			case "A": $renew = "ติดต่อได้ไม่ได้"; break;
//			case "W": $renew = "ขอคิดดูก่อน/ไม่สะดวก"; break;
//			case "E": $renew = "ปิดงาน"; break;
//			case "O": $renew = "ที่อื่นถูกกว่า"; break;
//			case "N": $renew = "ไม่สนใจ"; break;
//		}
//		return $renew;
//	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap-responsive.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/Font-awesome/css/font-awesome.min.css"/>
    <link type="text/css" rel="stylesheet" href="assets/css/style.css"/>-->
    <!--<link id="active-theme" type="text/css" rel="stylesheet" href="assets/css/default.min.css"/>-->
    <style type="text/css">
    .style1 {font-size: 12px; color:#333;}
    </style>
    <script type="text/javascript" src="assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    
    <link type="text/css" rel="stylesheet" href="assets/css/datepicker.css"> 
    
<title>Untitled Document</title>
<script>
  $(function () {
  })
</script>

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
      	margin-top: -20px;
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

<div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1">

<!--       <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
    	    <tr class="style1">
    	      <td height="23"><font size="2"><font size="2">เลขที่รับแจ้ง</font></font></td>
    	      <td height="23"><font size="2"><font size="2">: <strong><?=$idcom_data.'-'.$row['id_data']; ?></strong></font></font></td>
    	      <td height="23"><font size="2"><font size="2">เลขที่ พรบ. </font></font></td>
    	      <td height="23">:<strong><font size="2"><font size="2">
    	        <? if($row['EditAct_id']!=''){echo $row['EditAct_id'];}else{ echo $row['p_act']; } ?>
              </font></font></strong></td>
  	      </tr>
    	    <tr class="style1">
    	      <td width="100" height="23"><font size="2">ผู้เอาประกันภัย </font></td>
    	      <td height="23">: <strong><font size="2"><?php if($row['Cus_name'] != '') {
echo $row['Cus_title'].$row['Cus_name']." ".$row['Cus_last']; }else{ echo $row['title']." ".$row['name']." ".$row['last']; }?></font></strong></td>
    	      <td height="23">
                  <font size="2"><? if($row['person'] == '1'){ echo 'เลขบัตรประชาชน '; }else{ echo 'เลขผู้เสียภาษี '; }?></font>
              </td>
    	      <td height="23">: 
                  <strong><font size="2"><?=$row['icard'];?></font></strong>
              </td>
          </tr>


    	    </table>-->





</div>
      <!-- End tab -->

 <div id="content_wait"> 
                                <form id="savefol">
                                    <input id="4_login" type="hidden" value="<?= $_SESSION["strUser"]; ?>" name="4_login" readonly="">
                                    <input id="iddata" type="hidden" value="<?= $_GET["IDDATA"]; ?>" name="iddata" readonly="">
                                    <input id="opentime" type="hidden" value="<?= date('Y-m-d H:i:s'); ?>" name="opentime" readonly="">
                                    <table width="90%" border="0" cellpadding="0" cellspacing="0"  class="table table-striped table-bordered" style="margin-left:1px;" >
                                        <thead> 
                                            <tr class="body">
                                                <th colspan="11" align="center"><i class="icon-tasks">
                                                        <input type="hidden" name="main" id="main" value="E">

                                                </th>
                                            </tr>
                                            <tr class="body">
                                                <td colspan="11">
                                                    <!--START  รายการติดตาม -->
                                                    <table id="" width="100%" class="">
<!--                                                        <tr id="datefolf" style="display:none;">
                                                            <td class="span2"><div align="right"><strong>นัดครั้งถัดไป : </strong></div></td>
                                                            <td>
                                                                <div align="center">
                                                                    <input type="text" size='20' value="<?= date('d/m/Y', strtotime("+1 day", strtotime(date('Y-m-d')))); ?>" name="datefol" id="datefol"  readonly />
                                                                </div>
                                                            </td>
                                                        </tr>-->
                                                        <tr id="datefolf2">
                                                            <td class="span3"><div align="right"><strong>วันที่ต่ออายุ : </strong></div></td>
                                                            <td>
                                                                <div align="center">
                                                                    <input type="text" size='20' value="<?= date('d/m/Y'); ?>" name="datefol2" id="datefol"  readonly />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="span3"><div align="right"><strong>ความต้องการเพิ่มเติม : </strong></div></td>
                                                            <td>
                                                                <div align="center">
                                                                    <textarea id="textdetail" name="textdetail" rows="3" cols="5"></textarea>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- begin sing -->
                                                    <div id="show-data-pay"></div>
                                                    <!-- end sing -->


                                                    <!-- รายการเสนอราคา -->
<!--                                                    <table style="display:none;" id="send_quotation" width="100%" class="detail_renew">




                                                        <tr>
                                                            <td class="span2"><div align="right"><strong>ประเภท : </strong></div></td>
                                                            <td>
                                                                <div align="right">
                                                                    <select style="width:113px;" name="doctype" id="doctype"  onchange="doc()">
                                                                        <option value="1">ป1</option>
                                                                        <option value="2+">2+</option>
                                                                        <option value="3+">3+</option>

                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>



                                                        <tr id="typecost_e">
                                                            <td class="span2"><div align="right"><strong>ชนิด : </strong></div></td>
                                                            <td>
                                                                <div align="right">
                                                                    <select style="width:113px;" name="typecost" id="typecost" onchange="Stun()">
                                                                        <? if($_SESSION["MoC"]['name'][$row['mo_car']] =='CARRY' ){ ?>
                                                                        <option value="AS2">ปกติ</option>
                                                                        <? }else{ ?>
                                                                        <option value="S30">ปกติ</option>
                                                                        <option value="S_Rate">Single Rate</option>
                                                                        <option value="PRM">Premium</option>
                                                                        <?  } ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>










                                                        <tr>
                                                            <td class="span2"><div align="right"><strong>ทุน : </strong></div></td>
                                                            <td>
                                                                <div align="right">

                                                                    <input type="hidden" size='4' value="<?= $_SESSION["MoC"]['name'][$row['mo_car']]; ?>" name="mo_car_re" id="mo_car_re"   readonly / >

                                                                           <? if($_SESSION["MoC"]['name'][$row['mo_car']] =='CARRY' ){ ?>
                                                                           <input type="hidden" size='4' value="AS2" name="type" id="type"  readonly />
                                                                    <? }else{ ?>
                                                                    <input type="hidden" size='4' value="S30" name="type" id="type"  readonly />
                                                                    <? } ?>
                                                                    <select class="TotalPrice span6" name="tun" id="tun" onchange="Stun()" style="width:113px;">
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="span2"><div align="right"><strong>ซ่อม : </strong></div></td>
                                                            <td>
                                                                <div align="right" id="ser">

                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="span2"><div align="right"><strong>เบี้ยสุทธิ : </strong></div></td>
                                                            <td>
                                                                <div align="right">
                                                                    <input  type="hidden" class="TotalPrice span4" size="15"  value="" name="pre-set" id="pre-set"  readonly />
                                                                    <input  type="text" class="TotalPrice span4" size="15"  value="" name="pre-set2" id="pre-set2"  readonly />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="span2"><div align="right"><strong>เบี้ยรวม : </strong></div></td>
                                                            <td>
                                                                <div align="right"><input  type="text" class="TotalPrice span4" size="15"  value="" name="pre-all" id="pre-all"  readonly /></div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="span2"><div align="right"><strong>พ.ร.บ. : </strong></div></td>
                                                            <td>
                                                                <div align="right">
                                                                    <select style="width:113px;" class="TotalPrice" name="act" id="act" onchange="calcfunc();" >
                                                                        <option value="N">ไม่เอา</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr id="deiver">
                                                            <td class="span2"><div align="right"><strong>ส่วนลดผู้ขับขี่ : </strong></div></td>
                                                            <td>
                                                                <div align="right" id="dr">

                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr id="group1">
                                                            <td><div align="right"><strong>ส่วนลดกลุ่ม : </strong></div></td>
                                                            <td>
                                                                <div align="right" id="gr">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr id="general">
                                                            <td><div align="right"><strong>ส่วนลดประวัติดี : </strong></div></td>
                                                            <td>
                                                                <div align="right" id="ge">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><div align="right"><strong>ส่วนลดพิเศษ : </strong></div></td>
                                                            <td>
                                                                <div align="right">
                                                                    <input class="TotalPrice  span4" onkeyup="calcfunc();" size="15" type="text" value="0.00" name="extra" id="extra"    />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><div align="right"><strong>รวมส่วนลด : </strong></div></td>
                                                            <td>
                                                                <div align="right">
                                                                    <input size="15" style="color:green;" class="span4" type="text" value="0.00" name="totaldis" id="totaldis"  readonly />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><div align="right"><strong>ผ่อนชำระ : </strong></div></td>
                                                            <td>
                                                                <div align="right">
                                                                    <font color="#FF0000"><strong>เลือกประเภทการชำระเงิน</strong></font>
                                                                    <select class="span4" name="stype" onchange="stype_change()">
                                                                        <option value="1">แบ่งชำระ 1 งวด</option>
                                                                        <option value="2">แบ่งชำระ 2 งวด</option>
                                                                        <option value="3">แบ่งชำระ 3 งวด</option>
                                                                        <option value="4">แบ่งชำระ 4 งวด</option>
                                                                    </select>
                                                                    <input type="hidden" id="temp_snet" name="temp_snet">
                                                                    <br>
                                                                    <b>ชำระงวดแรก 3,000 บาท</b><font color="#FF0000"><strong>(ใช้ได้ในกรณีผ่อนชำระ)</strong></font>
                                                                    <input type="checkbox" id="chkcall" name="chkcall" value="1" onchange="stype_change()">

                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="success snet1">
                                                            <td><div align="right"><strong>เบี้ยชำระ : </strong></div></td>
                                                            <td>
                                                                <div align="right">
                                                                    <input size="15" style="color:red;" class="span4" type="text" value="" name="snet" id="snet"  readonly />

                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="success snet2">
                                                            <td><div align="right"><strong>เบี้ยชำระ : </strong></div></td>
                                                            <td>

                                                            </td>
                                                        </tr>
                                                        <tr class="snet2">
                                                            <td><div align="right">งวดที่1 :</div></td>
                                                            <td><div align="right"><input size="15" style="color:red;" class="span4" type="text" value="" name="snet2[]" id="snet21"  readonly /></div></td>
                                                        </tr>
                                                        <tr class="snet2">
                                                            <td><div align="right">งวดที่2 :</div></td>
                                                            <td><div align="right"><input size="15" style="color:red;" class="span4" type="text" value="" name="snet2[]" id="snet22"  readonly /></div></td>
                                                        </tr>
                                                        <tr class="success snet3">
                                                            <td><div align="right"><strong>เบี้ยชำระ : </strong></div></td>
                                                            <td>

                                                            </td>
                                                        </tr>
                                                        <tr class="snet3">
                                                            <td><div align="right">งวดที่1 :</div></td>
                                                            <td><div align="right"><input size="15" style="color:red;" class="span4" type="text" value="" name="snet3[]" id="snet31"  readonly /></div></td>
                                                        </tr>
                                                        <tr class="snet3">
                                                            <td><div align="right">งวดที่2 :</div></td>
                                                            <td><div align="right"><input size="15" style="color:red;" class="span4" type="text" value="" name="snet3[]" id="snet32"  readonly /></div></td>
                                                        </tr>
                                                        <tr class="snet3">
                                                            <td><div align="right">งวดที่3 :</div></td>
                                                            <td><div align="right"><input size="15" style="color:red;" class="span4" type="text" value="" name="snet3[]" id="snet33"  readonly /></div></td>
                                                        </tr>
                                                        <tr class="success snet4">
                                                            <td><div align="right"><strong>เบี้ยชำระ : </strong></div></td>
                                                            <td>

                                                            </td>
                                                        </tr>
                                                        <tr class="snet4">
                                                            <td><div align="right">งวดที่1 :</div></td>
                                                            <td><div align="right"><input size="15" style="color:red;" class="span4" type="text" value="" name="snet4[]" id="snet41"  readonly /></div></td>
                                                        </tr>
                                                        <tr class="snet4">
                                                            <td><div align="right">งวดที่2 :</div></td>
                                                            <td><div align="right"><input size="15" style="color:red;" class="span4" type="text" value="" name="snet4[]" id="snet42"  readonly /></div></td>
                                                        </tr>
                                                        <tr class="snet4">
                                                            <td><div align="right">งวดที่3 :</div></td>
                                                            <td><div align="right"><input size="15" style="color:red;" class="span4" type="text" value="" name="snet4[]" id="snet43"  readonly /></div></td>
                                                        </tr>
                                                        <tr class="snet4">
                                                            <td><div align="right">งวดที่4 :</div></td>
                                                            <td><div align="right"><input size="15" style="color:red;" class="span4" type="text" value="" name="snet4[]" id="snet44"  readonly /></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div align="right"><strong>โจรกรรม :</strong></div></td>
                                                            <td><div align="right"><input type="radio" name="robbery" value="Y">&nbsp;เอา&nbsp;&nbsp;&nbsp;<input type="radio" name="robbery" value="N">&nbsp;ไม่เอา</div></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td><div align="right"> <a data-toggle="modal" id="btnpay" class="btn btn-success" style="width:70px; margin-top:5px;" href="pages/view4_PayOnline.php?TXTFORM=<?= $txt_form ?>" aria-hidden="true" data-target="#modal_PayOnline"><i class="icon-shopping-cart"></i>ชำระเงิน</a> </div></td>
                                                        </tr>
                                                    </table>-->

                                                    <!-- รายการนัดชำระแจ้งงาน -->

<!--                                                    <table style="display:none;" id="send_confirmrenew" width="100%" class="detail_renew">
                                                        <tr style="margin : 5px;">
                                                            <td><input id="commentse1" type="checkbox" onclick="comment(this.value);" value="1" name="commentse1"> นัดตรวจสภาพรถ</td>
                                                        </tr>
                                                        <tr id="comment1" style="display:none;">
                                                            <td>
                                                                <table width="100%">
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> เวลานัด : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <input id="checkcar_date" class="span4"  type="text" readonly="readonly" value="<?= date('d/m/Y') ?>" maxlength="10" size="8" name="checkcar_date">
                                                                            <select class="span7" id="checkcar_time" name="checkcar_time">
                                                                                <option value="0">กรุณาเลือกเวลา</option>
                                                                                <option value="เช้า (08:00 - 12:00)">เช้า (08:00 - 12:00)</option>
                                                                                <option value="บ่าย (12:00 - 15:00)">บ่าย (12:00 - 15:00)</option>
                                                                                <option value="เย็น (15:00 - 18:00)">เย็น (15:00 - 18:00)</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> ติดต่อ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <input id="contact_name_list" type="text" name="contact_name_list" value="">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> เบอร์โทรศัพท์ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <input id="contact_number" type="text" style="text-align:left" maxlength="12" size="12" name="contact_number" value="">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td> 
                                                                <input id="commentse2" type="checkbox" onclick="comment(this.value)" value="2" name="commentse2"> ส่งกรมธรรม์
                                                            </td>
                                                        </tr>
                                                        <tr align="left"  id="comment2" style="display:none;">
                                                            <td>
                                                                <table width="100%">
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> ส่งกรมธรรม์ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <select class="span7" id="check_1" name="check_1">
                                                                                <option value="0">กรุณาเลือกเวลา</option>
                                                                                <option value="1">พร้อมเก็บเงิน</option>
                                                                                <option value="2">พร้อมวางบิล</option>
                                                                            </select>
                                                                            <input id="date_SP"  type="text" readonly="readonly" value="<?= date('d/m/Y') ?>" maxlength="10" size="8" name="date_SP">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> ติดต่อ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <input id="contact_name_rec" type="text" name="contact_name_rec" value="">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> เบอร์โทรศัพท์ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <input id="contact_numberrec" type="text" style="text-align:left" maxlength="12" size="12" name="contact_numberrec" value="">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>  <input id="commentse3" type="checkbox" onclick="comment(this.value)" value="3" name="commentse3"> จ่ายแล้ว </td>
                                                        </tr>
                                                        <tr align="left"  id="comment3" style="display:none;">
                                                            <td>
                                                                <table width="100%">
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> จ่ายเข้า : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <select class="span7" id="payin" name="payin">
                                                                                <option value="0">กรุณาเลือกการจ่าย</option>
                                                                                <option value="จ่ายเข้า FOUR">จ่ายเข้า FOUR</option>
                                                                                <option value="จ่ายเข้าบริษัทประกัน">จ่ายเข้าบริษัทประกัน</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> วิธีชำระ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <select id="payment_1" name="payment_1">
                                                                                <option value="0">กรุณาเลือก</option>
                                                                                <option value="เงินสด">เงินสด</option>
                                                                                <option value="เช็ค">เช็ค</option>
                                                                                <option value="ตัดบัตรเครดิตตัดบัตรเครดิต"</option>
                                                                                <option value="Bill Payment">Bill Payment</option>
                                                                                <option value="ผ่อนชำระ">ผ่อนชำระ</option>
                                                                                <option value="ผ่อนชำระ 0%">ผ่อนชำระ 0%</option>
                                                                            </select>
                                                                            <select id="instance_1" name="instance_1" style="display:none;">
                                                                                <option value="0">งวดชำระ</option>
                                                                                <option value="1 งวด">1 งวด</option>
                                                                                <option value="2 งวด">2 งวด</option>
                                                                                <option value="3 งวด">3 งวด</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> วันที่ชำระ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <input id="payment_date" type="text" readonly="readonly" value="<?= date('d/m/Y') ?>" maxlength="10" size="8" name="payment_date">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> ธนาคาร : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <select id="bankoperation_1" name="bankoperation_1">
                                                                                <option value="0">ธนาคาร</option>
                                                                                <option value="NON">ไม่ระบุ</option>
                                                                                <option value="SCB">ธนาคาร ไทยพาณิชย์</option>
                                                                                <option value="KBANK">ธนาคาร กสิกร</option>
                                                                                <option value="BBL">ธนาคาร กรุงเทพ</option>
                                                                                <option value="BAY">ธนาคาร กรุงศรี</option>
                                                                                <option value="KTB">ธนาคาร กรุงไทย</option>
                                                                                <option value="CEN">เซนทรัล การ์ด</option>
                                                                                <option value="ROB">โรบินสัน การ์ด</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> เบอร์โทรศัพท์ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <input id="contact_number_pay" type="text" style="text-align:left" maxlength="12" size="12" name="contact_number_pay" value="">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td >  <input id="commentse4" type="checkbox" onclick="comment(this.value)" value="4" name="commentse4"> กำลังทำจ่าย </td>
                                                        </tr>

                                                        <tr align="left"  id="comment4" style="display:none;">
                                                            <td>
                                                                <table width="100%">
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> กำลังทำจ่ายเข้า : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <select class="span7" id="checkpen" name="checkpen">
                                                                                <option value="0">กรุณาเลือกการจ่าย</option>
                                                                                <option value="จ่ายเข้า FOUR">จ่ายเข้า FOUR</option>
                                                                                <option value="จ่ายเข้าบริษัทประกัน">จ่ายเข้าบริษัทประกัน</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> วิธีชำระ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <select id="payment_2" name="payment_2">
                                                                                <option value="0">วิธีชำระเงิน</option>
                                                                                <option value="เงินสด">เงินสด</option>
                                                                                <option value="เช็ค">เช็ค</option>
                                                                                <option value="ตัดบัตรเครดิต">ตัดบัตรเครดิต</option>
                                                                                <option value="Bill Payment">Bill Payment</option>
                                                                                <option value="ผ่อนชำระ">ผ่อนชำระ</option>
                                                                                <option value="ผ่อนชำระ 0%">ผ่อนชำระ 0%</option>
                                                                            </select>
                                                                            <select id="instance_2" name="instance_2" style="display:none;">
                                                                                <option value="0">งวดชำระ</option>
                                                                                <option value="1 งวด">1 งวด</option>
                                                                                <option value="2 งวด">2 งวด</option>
                                                                                <option value="3 งวด">3 งวด</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> วันที่ชำระ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <input id="payment_in" type="text" readonly="readonly" value="<?= date('d/m/Y') ?>" maxlength="10" size="8" name="payment_in">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> ธนาคาร : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <select id="bankoperation_2" name="bankoperation_2">
                                                                                <option value="0">ธนาคาร</option>
                                                                                <option value="NON">ไม่ระบุ</option>
                                                                                <option value="SCB">ธนาคาร ไทยพาณิชย์</option>
                                                                                <option value="KBANK">ธนาคาร กสิกร</option>
                                                                                <option value="BBL">ธนาคาร กรุงเทพ</option>
                                                                                <option value="BAY">ธนาคาร กรุงศรี</option>
                                                                                <option value="KTB">ธนาคาร กรุงไทย</option>
                                                                                <option value="CEN">เซนทรัล การ์ด</option>
                                                                                <option value="ROB">โรบินสัน การ์ด</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> เบอร์โทรศัพท์ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <input id="contact_number_pen" type="text" style="text-align:left" maxlength="12" size="12" name="contact_number_pen" value="">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="116"><input id="commentse5" type="checkbox" onclick="comment(this.value)" value="5" name="commentse5"> ยังไม่จ่าย</td>
                                                        </tr>
                                                        <tr align="left"  id="comment5" style="display:none;">
                                                            <td>
                                                                <table width="100%">
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> รายการ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <select class="span5" id="checks" name="checks">
                                                                                <option value="0">กรุณาเลือก</option>
                                                                                <option value="นัดอีกครั้ง">นัดอีกครั้ง</option>
                                                                                <option value="วางบิลบริษัท">วางบิลบริษัท</option>
                                                                                <option value="วางบิลคู่ค้า/ดิลเลอร">วางบิลคู่ค้า/ดิลเลอร</option>
                                                                                <option value="วางบิลตัวแทน">วางบิลตัวแทน</option>
                                                                                <option value="ดิล เครดิต">ดิล เครดิต</option>
                                                                                <option value="ออก กธ. แล้ว">ออก กธ. แล้ว</option>
                                                                            </select>
                                                                            <select class="span5" id="D_day" name="D_day">
                                                                                <option value="0">----</option>
                                                                                <option value="15 วัน">15 วัน</option>
                                                                                <option value="30 วัน">30 วัน</option>
                                                                                <option value="45 วัน">45 วัน</option>
                                                                                <option value="60 วัน">60 วัน</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> ติดต่อ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <input id="contact_name_list_3" name="contact_name_list_3" value="">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> เบอร์โทรศัพท์ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <input id="contact_number_3" style="text-align:left" maxlength="12" size="12" name="contact_number_3" value="">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> ธนาคาร : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <select id="bankoperation_3" name="bankoperation_3">
                                                                                <option value="0">ธนาคาร</option>
                                                                                <option value="NON">ไม่ระบุ</option>
                                                                                <option value="SCB">ธนาคาร ไทยพาณิชย์</option>
                                                                                <option value="KBANK">ธนาคาร กสิกร</option>
                                                                                <option value="BBL">ธนาคาร กรุงเทพ</option>
                                                                                <option value="BAY">ธนาคาร กรุงศรี</option>
                                                                                <option value="KTB">ธนาคาร กรุงไทย</option>
                                                                                <option value="CEN">เซนทรัล การ์ด</option>
                                                                                <option value="ROB">โรบินสัน การ์ด</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong> เบอร์โทรศัพท์ : </strong></div></td>
                                                                        <td colspan="2">
                                                                            <input id="contact_number_s" type="text" style="text-align:left" maxlength="12" size="12" name="contact_number_s" value="">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="116"><input id="commentse6" type="checkbox" onclick="comment(this.value)" value="6" name="commentse6"> อื่นๆ</td>
                                                        </tr>
                                                        <tr align="left"  id="comment6" style="display:none;">
                                                            <td>
                                                                <table width="100%">
                                                                    <tr>
                                                                        <td class="span2"><div align="right"><strong></strong></div></td>
                                                                        <td colspan="2">
                                                                            <textarea rows="3" style="width:300px" id="other_s" name="other_s"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>-->


                                                    <!-- รายการเสนอราคา -->

                                                    <table style=";" id="" width="100%" class="">
                                                        <tr>
                                                            <td  colspan="2">
                                                                <div align="center">
                                                                    <button class="btn btn-info" id="saveaction"  type="button"><i class="icon-ok-sign icon-white" ></i><strong> ยืนยันการต่ออายุ</strong></button>
                                                                    <input style="display:none;" type="reset" id="configreset" value="Reset">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!--END  รายการติดตาม -->
                                                </td>

                                            </tr>
                                        </thead> 
                                    </table>
                                </form>
                            </div>

</div>
    <script>
         $('#saveaction').click(function (event) {
             //alert('showSave');
            if ($('#textdetail').val().length < 5) {
                alert('กรุณากรอกรายละเอียดมากกว่า 5 ตัวอักษร');
                return false;
            } 
            
            $("#printDeal").removeAttr('disabled')
            datauser = ($('#savefol').serialize());
            $('#saveaction').attr('disabled', 'disabled');
            var options =
                    {
                        type: "POST",
                        dataType: "json",
                        url: "ajax/Ajax_SaveSendRenew.php",
                        data: datauser,
                        success: function (msg) {
                           // $('#main').val('');
                            alert(msg);
                            //tables.ajax.reload();
                            $('#close').trigger('click');
                        },
                        error: function (msg) {
                            alert('การบันทึกผิดพลาด');
                            $("#saveaction").removeAttr('disabled');
                        }
                    };
            $.ajax(options);
        });
        

//                $("#datefolf").hide();
//                $("#send_confirmrenew").show();
//                $("#datefolf").attr('disabled', 'disabled');
//                $("#datefolf2").show();
                //
//                var url = "";
//                var _tr = $('#example1').find('tbody tr');
//                $.each(_tr, function (x, y) {
//                    var _url = $(y).find('td:eq(8)').find('#btnpay').attr('href');
//                    var _cancel = $(y).find('td:eq(9)').html();
//                    if (_url != undefined && _cancel != undefined && _url != "" && _cancel != '-') {
//                        $.ajax({
//                            type: 'get',
//                            url: _url,
//                            success: function (res) {
//                                $('#show-data-pay').html(res);
//                                $('#show-data-pay').show();
//                            }
//                        });
//                        return false;
//                    }
//                });
            
//            if ($(this).val() == '') {
//                $("#textdetail").attr('disabled', 'disabled');
//                $("#saveaction").attr('disabled', 'disabled');
//            } else {
//                $("#textdetail").removeAttr('disabled');
//                $("#saveaction").removeAttr('disabled');
//            }
            //$('#send_confirmrenew').hide();
       
        
        </script>
      </body></html>