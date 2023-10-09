<?php
require("../pages/check-ses.php");
require("../inc/connectdbs.pdo.php");
require "../services/InsuranceNotificationWork/service/general-information.service.php";
require "../services/InsuranceNotificationWork/model/insurance-notification-work.model.php";

function insure($comp)
{
    switch ($comp) {
        case "NVI":
            $comp = "นวกิจ";
            break;
        case "MSIG":
            $comp = "เอ็มเอสไอจี";
            break;
        case "NSI":
            $comp = "นำสิน";
            break;
        case "BKI":
            $comp = "กรุงเทพ";
            break;
        case "DEV":
            $comp = "เทเวศ";
            break;
        case "TSI":
            $comp = "ไทยศรี";
            break;
        case "STY":
            $comp = "คุ้มภัย [สำนักงานใหญ่]";
            break;
        case "SCSMG":
            $comp = "ไทยพาณิชย์";
            break;
        case "VIB":
            $comp = "วิริยะ [สำนักงานใหญ่]";
            break;
        case "VIB_S":
            $comp = "วิริยะ [ปากเกร็ด]";
            break;
        case "VIB_Y":
            $comp = "วิริยะ [สุขาภิบาล 3]";
            break;
        case "AI1":
            $comp = "เอเชีย";
            break;
        case "LMG":
            $comp = "แอลเอ็มจี";
            break;
        case "KUI":
            $comp = "เคเอสเค ";
            break;
        case "BUI":
            $comp = "บางกอกสหประกันภัย";
            break;
        case "AXA":
            $comp = "แอกซ่า";
            break;
        case "SEI":
            $comp = "อาคเนย์";
            break;
        case "SIP":
            $comp = "สินมั่นคง";
            break;
        case "VIB_S103":
            $comp = "วิริยะ [ปากเกร็ด 10320]";
            break;
        case "BKI[MBLT]":
            $comp = "กรุงเทพ [MBLT]";
            break;
        case "TIP":
            $comp = "ทิพยประกันภัย";
            break;
        case "STY_S":
            $comp = "คุ้มภัย";
            break;
    }
    return $comp;
}
$css_margin = 'margin:0;';
$css_margin_font = 'margin-top:7px;';
$css_margin_font_tab = 'margin-left:30px;';
$css_margin_font_tab_right = 'margin-right:30px; float: right;';
?>
<link rel="stylesheet" href="css/grid.css">
<!-- <script type="text/javascript" src="js/jquery-1.8.3.js"></script> -->
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />
<script src="js/new/jquery.number.js"></script>
<script type="text/javascript" src="js/jquery.imask.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/new/bootstrap-datepicker-thai.js"></script>
<script src="js/total.js" type="text/javascript"></script>
<style>
    .design-ti {
        width: 100%;
        height: 45px;
        background-color: rgb(212, 212, 212);
        background: #0E4084;
    }

    select {
        border: 1px solid #a7a7a7;
    }

    .design-form {
        width: 100%;
        padding-top: 5px;
        padding-bottom: 10px;
        /* box-shadow: 0 8px 8px 0 rgb(0 0 0 / 10%); */
        transition: 0.3s;
        background: #cdcdcd;
    }

    .font-resize-ti {
        font-size: 20px;
        margin-top: 10px;
        margin-left: 10px;
    }

    .flex {
        display: flex !important;
    }

    #send_quotation input,
    #send_quotation select,
    #send_quotation textarea,
    #dataH input,
    #dataH select,
    #dataH textarea,
    .grid-cols-1 input,
    .grid-cols-1 select {

        height: 40px !important;
    }

    .desing-form-insuree {
        width: 95.5%;
        background-color: #FFFFFF;

        border-color: #555555;
        border-style: solid;
    }

    .design-value-insuree {
        display: inline-block;
        width: 130px;
        height: 130px;
        background: linear-gradient(135deg, #555555 46%, rgb(204, 138, 50) 45.5%, rgb(232, 189, 33) 47.0%, #555555 0%, #555555 49%, #FFFFFF 0%, #FFFFFF 100%);
    }

    .desize-font-deg {
        width: 200px;
        height: 60px;
        transform: rotate(-45deg);

    }

    .w-30 {
        width: 33.33%;
    }

    .w-100 {
        width: 83.33%;
    }

    .e-span12 {
        font-size: 18px;
        padding-left: 0px;
        width: 100%;
    }

    .bk-event {
        padding-top: 10px;
        background-color: #999999;
        border-style: solid;
        border-width: 2px;
        border-color: #555555;
        border-radius: 10px;
    }

    .boxz {
        border: 1px solid;
        padding: 1rem;
        height: 20vh;
    }

    .zip-group {
        width: 100%;
        text-align: center;
    }


    #webForm_inform .chosen-container {
        width: 100% !important;
    }

    #webForm_inform .chosen-single {
        height: 34px !important;
    }

    #webForm_inform .chosen-container-single .chosen-single div {
        top: 4px;
    }

    #webForm_inform .chosen-container-single .chosen-single {
        background: #fff;
    }
</style>
<div class="row-fluidd">
    <form name="webForm_inform" id="webForm_inform">
        <div class='font-design'>
            <div class='design-ti' style='<?php echo $css_margin ?>'>
                <div class='font-resize-ti span3' style='margin-top:10px;margin-left:10px;'>
                    <font style='color:#FFFFFF;'>ข้อมูลผู้ประกันภัย </font>
                </div>
            </div>
            <div class='design-form' style='margin-bottom:20px;'>
                <div class="alert alert-error" style="margin-bottom: 0;"><i class="icon-warning-sign"></i> การค้นหาต้องลบข้อความแล้วพิมพ์ใหม่ทุกครั้ง</div>
                <div class='grid grid-cols-1 gap-6 sm:grid-cols-2' style='padding: 0.5rem; '>
                    <div class="flex">
                        <div class="w-50 mr-2">
                            <label for="">สาขาแจ้งงาน</label>
                            <?php
                            $edit_nameuser = "";
                            $edit_user = substr($_SESSION['strUser'], 1, 5);
                            $edit_nameuser = 'M' . $edit_user;

                            if ($_SESSION['strUser'] != 'admin') {
                                $id_agent_sql = "AND AgentCode = '$edit_nameuser'";
                            } else {
                                $id_agent_sql = "";
                            }

                            $sql = "SELECT * FROM partner_code_center WHERE Type = 'Mitsubishi' $id_agent_sql ORDER BY DealerCode ASC";

                            if ($_SESSION['strUser'] != 'admin') {
                                $resultAgent = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetch(2);
                                echo "<input type='text' class='w-100' name='agent_inform' id='agent_inform'  value= '$resultAgent[DealerID]' readonly/>";
                                $comittion_a = $resultAgent['AgentDis'];
                            } elseif ($_SESSION['log_type'] == 'TIP') {
                                echo "<input type='text' class='w-100' name='agent_inform' id='agent_inform'  value= 'Tippaya Test User' readonly/>";
                                $comittion_a = '0';
                            } else {
                                $resultAgent = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetchAll(2);
                                echo '<input type="text" name="agent_inform" list="agent_inform" class="w-100" placeholder="เลือกสาขาแจ้งงาน" value="">';
                                echo '<datalist id="agent_inform">';
                                $comittion_a = '0';
                                foreach ($resultAgent as $x) {
                                    $agentCode = $x['DealerID'];
                                    $name_agent = $x['Name'];
                                    echo "<option value='$agentCode'>[$agentCode] $name_agent</option>";
                                }
                                echo "</datalist>";
                            }
                            ?>
                        </div>
                        <div class="w-30">
                            <label for="">ผู้แจ้ง</label>
                            <?php
                            $sql = "SELECT * FROM tb_user WHERE s_name='1' and resign != 'Y' order by sub asc";
                            $resultUser = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetchAll(2);
                            if ($_SESSION['strUser'] != 'admin') {
                                echo "<input type='text' class='w-100' name='emp_inform' id='emp_inform' value= 'DEALER' readonly/>";
                                // echo "<option value='DEALER'>[DEALER] ดิลเลอร์</option>";
                            } elseif ($_SESSION['log_type'] == 'TIP') {
                                echo "<input type='text' class='w-100' name='emp_inform' id='emp_inform' value= 'TIP TEST' readonly/>";
                            } else {
                                echo "<input type='text' name='emp_inform' list='emp_inform' class='w-100' placeholder='เลือกผู้แจ้งงาน'>";
                                echo "<datalist id='emp_inform'>";
                                foreach ($resultUser as $x) {
                                    $id_emp = $x['user'];
                                    $name_emp = "[ " . $x['user'] . " ] " . $x['title_sub'] . $x['sub'];
                                    echo "<option value='$id_emp'>$name_emp</option>";
                                }
                                echo "</datalist>";
                            }
                            ?>
                        </div>
                    </div>
                    <div></div>
                    <div class="flex">
                        <div class="w-30 mr-2">
                            <label for="">บุคคล/นิติบุคคล</label>
                            <select name="person_inform" id="person_inform" class='w-100' onchange="onkeyicard_clear(this.value)">
                                <option value="0" disabled>--เลือก--</option>
                                <option value="1">บุคคลธรรมดา</option>
                                <option value="2">นิติบุคคล</option>
                                <!-- <option value="3">
                                    บุคคลในนามบริษัท
                                </option> -->
                            </select>
                        </div>
                        <div class="w-100 mr-2">
                            <label for="">เลขบัตร/เลขนิติบุคคล</label>
                            <span class='flex'>
                                <input name="icard1" type="text" id="icard1" maxlength="1" onkeyup='onkeyicard("icard2","icard1",event);' style='width:100%; text-align: center;'>
                                -
                                <input name="icard2" type="text" id="icard2" maxlength="1" onkeyup='onkeyicard("icard3","icard2",event);' style='width:100%; text-align: center;'>
                                <input name="icard3" type="text" id="icard3" maxlength="1" onkeyup='onkeyicard("icard4","icard3",event);' style='width:100%; text-align: center;'>
                                <input name="icard4" type="text" id="icard4" maxlength="1" onkeyup='onkeyicard("icard5","icard4",event);' style='width:100%; text-align: center;'>
                                <input name="icard5" type="text" id="icard5" maxlength="1" onkeyup='onkeyicard("icard6","icard5",event);' style='width:100%; text-align: center;'>
                                -
                                <input name="icard6" type="text" id="icard6" maxlength="1" onkeyup='onkeyicard("icard7","icard6",event);' style='width:100%; text-align: center;'>
                                <input name="icard7" type="text" id="icard7" maxlength="1" onkeyup='onkeyicard("icard8","icard7",event);' style='width:100%; text-align: center;'>
                                <input name="icard8" type="text" id="icard8" maxlength="1" onkeyup='onkeyicard("icard9","icard8",event);' style='width:100%; text-align: center;'>
                                <input name="icard9" type="text" id="icard9" maxlength="1" onkeyup='onkeyicard("icard10","icard9",event);' style='width:100%; text-align: center;'>
                                <input name="icard10" type="text" id="icard10" maxlength="1" onkeyup='onkeyicard("icard11","icard10",event);' style='width:100%; text-align: center;'>
                                -
                                <input name="icard11" type="text" id="icard11" maxlength="1" onkeyup='onkeyicard("icard12","icard11",event);' style='width:100%; text-align: center;'>
                                <input name="icard12" type="text" id="icard12" maxlength="1" onkeyup='onkeyicard("icard13","icard12",event);' style='width:100%; text-align: center;'>
                                -
                                <input name="icard13" type="text" id="icard13" maxlength="1" onkeyup='onkeyicard("","icard13",event);' style='width:100%; text-align: center;'>
                            </span>
                            <span style='display:none;'>
                                <input name="icard_inform" type="text" id="icard_inform" maxlength="13" />
                            </span>
                        </div>
                        <div class="w-30">
                            <label for="">คำนำหน้า</label>
                            <select id="title_inform" name="title_inform" class="w-100" onchange="customerLastName(this.value);">
                                <option value="0" selected="selected">กรุณาเลือก</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="mr-2" id='show_name_form'>
                            <label id="show_name_title" for="">ชื่อจริง</label>
                            <div id='show_name_text' class="flex">
                                <input type='text' name='TitleCustomer' id='TitleCustomer' value='' style='width:70px;display:none;' readonly>
                                <input type='text' name="name_inform" id="name_inform" class='w-100' placeholder='ป้อนชื่อจริง' maxlength="100" value='' required />
                            </div>
                        </div>
                        <div class="" id='show_last_text'>
                            <label id="show_last_title" for="">นามสกุล</label>
                            <div class="flex">
                                <input type='text' name='ByCustomer' id='ByCustomer' value='' style='width:70px;text-align:center;display:none;' readonly>
                                <input type='text' name="last_inform" id="last_inform" class='w-100' placeholder='ป้อนนามสกุล' maxlength="50" value='' required />
                            </div>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="w-30 mr-2">
                            <label for="">บ้านเลขที่</label>
                            <input type="text" name="add_inform" id="add_inform" value='' class='w-100'>
                        </div>
                        <div class="w-30 mr-2">
                            <label for="">หมู่ที่</label>
                            <input type='text' name="group_inform" id="group_inform" value='' class='w-100'>
                        </div>
                        <div class="w-30 mr-2">
                            <label for="">ซอย</label>
                            <input type='text' id="lane_inform" class='w-100' name="lane_inform" value='' />
                        </div>
                        <div class="w-30 mr-2">
                            <label for="">ถนน</label>
                            <input type='text' id="road_inform" class='w-100' name="road_inform" value='' />
                        </div>
                        <div class="w-100 mr-2">
                            <label for="">จังหวัด</label>
                            <select name='province_inform' id='province_inform' class='w-100'>
                                <option value="0">กรุณาเลือก</option>
                            </select>
                        </div>
                        <div class="w-100">
                            <label for="">อำเภอ</label>
                            <select name="amphur_inform" id="amphur_inform" class='w-100'>
                                <option value="0">กรุณาเลือก</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="w-20 mr-2">
                            <label for="">ตำบล</label>
                            <select name="tumbon_inform" id="tumbon_inform" class='w-100'>
                                <option value="0">กรุณาเลือก</option>
                            </select>
                        </div>
                        <div class="w-20 mr-2">
                            <label for="">รหัสไปรษณีย์</label>
                            <select name="postal_inform" id="postal_inform" class='w-100'>
                                <option value="0" disabled>กรุณาเลือก</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex">
                        <div class="w-100 mr-2">
                            <label for="">อีเมล์</label>
                            <input type="email" id="email_inform" class='w-100' name="email_inform" value="" required>
                        </div>
                        <div class="w-100 mr-2">
                            <label for="">เบอร์มือถือ 1</label>
                            <input type="text" id="tel_mobile_inform" name="tel_mobile_inform" class="w-100" value="">
                        </div>
                        <div class="w-100 mr-2">
                            <label for="">เบอร์มือถือ 2</label>
                            <input type="text" id="tel_mobile2_inform" name="tel_mobile2_inform" class="w-100" value="">
                        </div>
                        <div class="w-100 mr-2">
                            <label for="">เบอร์มือถือ 3</label>
                            <input type="text" id="tel_mobile3_inform" name="tel_mobile3_inform" class='w-100'>
                        </div>
                        <div class="w-100 mr-2">
                            <label for="">วันคุ้มครอง</label>
                            <input type="date" id="end_date" name="end_date" class="w-100" value="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--ข้อมูลรถยนต์-->
        <div class='design-ti ' style='<?php echo $css_margin ?>'>
            <div class='font-resize-ti span3' style='margin-top:10px;margin-left:10px;'>
                <font style='color:#FFFFFF;'>ข้อมูลรถยนต์</font>
            </div>
        </div>
        <div class='design-form' style='margin-bottom:20px;'>
            <div class='grid grid-cols-1 gap-6 sm:grid-cols-2' style='padding: 0.5rem; '>
                <div class="flex">
                    <div class="w-50 mr-2">
                        <label for="">ประเภทรถ</label>
                        <select name="cartype" id="cartype" class="w-100">
                        </select>
                    </div>
                    <div class="w-100 mr-2">
                        <label for="">ยี่ห้อรถ</label>
                        <select name="br_car_inform" id="br_car_inform" class="w-100">
                            <option value="0" disabled>เลือกยี่ห้อรถ</option>
                            <option value="046" select>MITSUBISHI</option>
                        </select>
                    </div>

                    <div class="w-100 mr-2">
                        <label for="">รุ่นรถ</label>
                        <select name="mo_car" id="mo_car" class="w-100">
                            <option value="0" selected disabled>เลือกรุ่นรถ</option>
                        </select>
                    </div>

                    <div class="w-100 mr-2">
                        <label for="">รุ่นย่อย</label>
                        <select name="sub_mo_car" id="sub_mo_car" class="w-100">
                            <option value="0" selected disabled>เลือกรุ่นย่อย</option>
                        </select>
                    </div>
                    <div class="w-50">
                        <label for="">ปีจดทะเบียน</label>
                        <select name="regis_date_inform" id="regis_date_inform" class="w-100">
                            <option value="0" selected disabled>เลือกปี</option>
                            <?php $i = 0;
                            $yyy = date("Y");
                            while ($i <= 21) {
                                $cal = $yyy - $i; ?>
                                <option value='<?php echo $cal ?>'><?php echo $cal ?></option>
                            <?php $i++;
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-100 mr-2">
                        <label for="">เลขทะเบียน</label>
                        <div class="flex">
                            <input type='text' class='zip-group' name='car_regis1' id='car_regis1' onkeyup='onkey_car_regis("car_regis2","car_regis1",event);' value='' maxlength='1'>
                            <input type='text' class='zip-group' name='car_regis2' id='car_regis2' onkeyup='onkey_car_regis("car_regis3","car_regis2",event);' value='' maxlength='1'>
                            <input type='text' class='zip-group' name='car_regis3' id='car_regis3' onkeyup='onkey_car_regis("car_regis4","car_regis3",event);' value='' maxlength='1'>
                            <span class="mr-5 txt-dash">-</span>
                            <input type='text' class='zip-group' name='car_regis4' id='car_regis4' onkeyup='onkey_car_regis("car_regis5","car_regis4",event);' value='' maxlength='1'>
                            <input type='text' class='zip-group' name='car_regis5' id='car_regis5' onkeyup='onkey_car_regis("car_regis6","car_regis5",event);' value='' maxlength='1'>
                            <input type='text' class='zip-group' name='car_regis6' id='car_regis6' onkeyup='onkey_car_regis("car_regis7","car_regis6",event);' value='' maxlength='1'>
                            <input type='text' class='zip-group' name='car_regis7' id='car_regis7' onkeyup='onkey_car_regis("","car_regis7",event);' value='' maxlength='1'>
                        </div>
                        <input name="car_regis_inform" type="text" style='display:none;' id="car_regis_inform" value="">
                    </div>
                    <div class="w-30 mr-2">
                        <label for="">ซีซี</label>
                        <input name="cc_inform" type="number" id="cc_inform" class='w-100 mr-2' maxlength="4" placeholder='ซีซี' value="" required>
                    </div>
                    <div class="w-30 mr-2">
                        <label for="">น.น.</label>
                        <input name="wg_inform" type="number" id="wg_inform" class='w-100 mr-2' maxlength="5" placeholder='ตัน' value="" required>
                    </div>
                    <div class="w-30 mr-2">
                        <label for="">ที่นั่ง</label>
                        <input type="number" name="car_seat_inform" id="car_seat_inform" class='w-100' placeholder='ที่นั่ง' value='' required>
                    </div>
                    <div class="w-100 mr-2">
                        <label for="">เลขเครื่อง</label>
                        <input type="text" id="serialNumber" name="serialNumber" class="w-100" value="" required>
                    </div>
                    <div class="w-100">
                        <label for="">เลขตัวถัง</label>
                        <input type="text" id="chassisNumber" name="chassisNumber" class="w-100" value="" required>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-25 mr-2">
                        <label for="">จังหวัดจดทะเบียน</label>
                        <select name='carRegisProvince' id='carRegisProvince' class='w-100' required>
                            <option value="0">กรุณาเลือก</option>
                        </select>
                    </div>
                    <div class="w-30 mr-2">
                        <label for="">ผู้รับผลประโยชน์</label>
                        <!-- <input type="text" id="beneficiary" name="beneficiary" class="w-100" value="" required> -->
                        <input type="text" name="beneficiary" list="beneficiary" class='w-100' placeholder="เลือกชื่อผู้รับผลประโยชน์">
                        <datalist id="beneficiary">
                            <?php
                            $query_accessories = "SELECT * FROM `tb_heiress` ORDER BY `tb_heiress`.`id` ASC";
                            $result1 = PDO_CONNECTION::fourinsure_insured()->query($query_accessories);
                            foreach ($result1->fetchAll(2) as $fetcharr) { ?>
                                <option value='<?php echo $fetcharr['name'] ?>' <?php echo $tb_heiress_select ?>>
                                    <?php echo $fetcharr['name'] ?></option>
                            <?php } ?>
                        </datalist>
                        <input type="hidden" name="idCost" id="idCost">

                    </div>
                </div>
            </div>
        </div>

        <!--ข้อมูลความคุ้มครอง-->
        <div class='design-ti' style='<?php echo $css_margin ?>'>
            <div class='font-resize-ti span12' style='margin-top:10px;margin-left:10px;'>
                <font style='color:#FFFFFF;'>ข้อมูลความคุ้มครอง และข้อมูลเบี้ยประกันภัย</font>
            </div>
        </div>
        <div class='design-form' style='<?php echo $css_margin ?> margin-bottom:10px;'>
            <div id="showTextPremium" class="w-100" style="text-align: center;">
                <h2 style="color: #d53939;">ไม่พบข้อมมูลเบี้ยในระบบ</h2>
            </div>
            <div id="hiddenPremium" style="display: none;">
                <div class='grid grid-cols-1 gap-6 sm:grid-cols-2' style='padding: 0.5rem; '>
                    <div class="flex">
                        <div class="w-30 mr-2">
                            <label for="">ประเภท</label>
                            <select name="doc_type_inform" id="doc_type_inform" class='w-100'>
                                <option value="0">เลือก</option>
                                <option value="1">1</option>
                                <option value="2+">2+</option>
                                <option value="2">2</option>
                                <option value="3+">3+</option>
                                <option value="3">3</option>
                                <option value="3P">3P</option>
                            </select>
                        </div>
                        <div class="mr-2" style="width: 200%;">
                            <label for="">บริษัทประกันภัย</label>
                            <select name='com_data_inform' id='com_data_inform' class='w-100'>
                                <?php
                                $sql = "SELECT * FROM tb_comp where sort = 'VIB_S' ORDER BY name ASC ";
                                $result = PDO_CONNECTION::fourinsure_insured()->query($sql);
                                foreach ($result->fetchAll(2) as $fetcharr) { ?>

                                    <option value='<?php echo $fetcharr['sort'] ?>' <?php echo $se ?>>
                                        <?php echo $fetcharr['name_print'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="w-70 mr-2">
                            <label for="">ประเภทการซ่อม</label>
                            <select name="service_inform" id="service_inform" class='w-100'>
                                <option value="0">เลือก</option>
                                <option value="1">ซ่อมห้าง</option>
                                <option value="2">ซ่อมอู่</option>
                            </select>
                        </div>
                        <!-- <div class="w-70 mr-2">
                            <label for="">วันที่คุ้มครอง</label>
                            <input id="start_date_inform" name="start_date_inform" type="text" class='w-100' value=''
                                readonly placeholder='คลิกที่นี่เพื่อเลือกวันที่คุ้มครอง'>
                        </div>
                        <div class="w-70 mr-2">
                            <label for="">วันสิ้นสุดคุ้มครอง</label>
                            <input id="end_date_inform" name="end_date_inform" type="text" class='w-100' value=''
                                readonly placeholder='คลิกที่นี่เพื่อเลือกวันที่คุ้มครอง'>
                        </div> -->
                    </div>
                    <!-- <div>
                        <div class="w-20 mr-2">
                            <label for="">เลขกรมธรรม์เดิม</label>
                            <input id="o_insure_inform" name="o_insure_inform" type="text"
                                value='<?php //echo $data_renew_array['n_insure']; 
                                        ?>' class='w-100'>
                        </div>
                    </div> -->
                </div>
                <div style="padding: 0.5rem;display: flex;">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-1 w-30">
                        <div class="flex w-100">
                            <div class="w-30 mr-2">
                                <label for="">เบี้ยสุทธิ</label>
                                <input class='w-100' type="text" id="pre_inform" name="pre_inform" value="0.00" readonly>
                            </div>
                            <div class="w-30 mr-2">
                                <label for="">เบี้ยรวม</label>
                                <input class='w-100' type="text" id="total_sum_inform" name="total_sum_inform" value="0.00" readonly style='text-align:right;'>
                            </div>
                            <!-- <div class="w-100">
                            <label for="">ส่วนลด</label>
                            <input name="currentValue_inform" type="text" id="currentValue_inform"
                                style="display: none;" value="<?php //echo $comittion_a 
                                                                ?>" class='w-100' readonly="true">
                            <input name="extra" type="text" id="extra" value="0.00" class='w-100' readonly="true"
                                style='text-align:right;'>
                        </div> -->
                        </div>
                        <div class="flex w-100">
                            <div class="w-30 mr-2">
                                <label for="">รหัส พ.ร.บ.</label>
                                <div class="flex">
                                    <input type="hidden" id='actCheck_inform' name='actCheck_inform' value="0" readonly style='text-align:right;'>
                                    <input class='w-100' type="hidden" id='prb_net_inform' name='prb_net_inform' readonly style='text-align:right;'>
                                    <select id="select_prb_inform" name="select_prb_inform" class='w-100 mr-2' onchange="handleCalculate(this.value, false)">
                                        <option selected="selected" value="0">--ไม่รวม--</option>
                                        <?php
                                        $tb_act_sql = "SELECT * FROM tb_act WHERE id_act IN ('110','140A') ORDER BY id_act ASC";
                                        $tb_act_query = PDO_CONNECTION::fourinsure_insured()->query($tb_act_sql);
                                        $n = 0;
                                        $act_net = 0;
                                        $act_total = 0;
                                        $array_pre = "";
                                        foreach ($tb_act_query->fetchAll(2) as $tb_act_array) {
                                            $n++;
                                            if ($n <= 1) {
                                                $array_pre .= "'" . $n . "':'" . $tb_act_array['pre_act'] . "'";
                                            } else {
                                                $array_pre .= ",'" . $n . "':'" . $tb_act_array['pre_act'] . "'";
                                            }
                                        ?>
                                            <option value="<?php echo number_format($tb_act_array['net_act'], 2, '.', ','); ?>">
                                                <?php echo $tb_act_array['id_act']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <input class='w-100' type="hidden" id='prbNet_inform' name='prbNet_inform' value="0" readonly style='text-align:right'>
                                    <select name='act_sort_inform' id='act_sort_inform' class='w-100 mr-2' style="display:none !important;">

                                        <?php
                                        $sql = "SELECT * FROM tb_comp where sort = 'VIB_S' ";
                                        $result = PDO_CONNECTION::fourinsure_insured()->query($sql);
                                        foreach ($result->fetchAll(2) as $fetcharr) { ?>
                                            <option value='<?php echo $fetcharr["sort"] ?>' selected <?php echo $se ?>>
                                                <?php echo insure($fetcharr["name_print"]) ?> </option>
                                        <?php } ?>
                                    </select>
                                    <input value="0.00" class='w-100' type="text" id="currentValue_prb_inform" name="currentValue_prb_inform" readonly style='text-align:right;'>
                                </div>
                            </div>
                            <div class="w-30 mr-2">
                                <label for="">เบี้ยรวม พ.ร.บ.</label>
                                <input value="0.00" class='w-100' type="text" id="total_prb_inform" name="total_prb_inform" readonly style='text-align:right;'>
                            </div>
                            <!-- <div class="w-100">
                            <label for="">ค่า คอมมิชชั่น</label>
                            <input name="other_inform" type="text" id="other_inform" value="0.00" class='w-100'
                                readonly="true" style='text-align:right;'>
                            <input name="other_new_inform" type="hidden" id="other_new_inform" value="0.00"
                                class='w-100' readonly="true">
                        </div> -->
                        </div>
                    </div>
                    <!-- <div class="w-10" style="padding-left: 1rem;">
                    <label for="">นำส่ง</label>
                    <div class="flex">
                        <input class="w-100" id="total_commition_inform" onchange="JavaScript:chkNum(this)" value="0.00"
                            type="text" name="total_commition_inform" readonly
                            style='text-align: center;    margin: 0;font-size: 1.5rem !important;font-weight: bolder;height: 106px;background: #03a9f400 !important;'>
                        <input class="w-100" id="total_commition_new_inform" onchange="JavaScript:chkNum(this)"
                            value="0.00" type="hidden" name="total_commition_new_inform" readonly
                            style='text-align:right;'>
                    </div>
                </div> -->
                    <div class="w-10" style="padding-left: 1rem;">
                        <label for="">ยอดชำระ</label>
                        <div class="flex">
                            <input class="w-100" id="total_payment_inform" value="0.00" type="text" name="total_payment_inform" readonly style='text-align: center;    margin: 0;font-size: 1.5rem !important;font-weight: bolder;height: 106px;background: #03a9f400 !important;'>
                        </div>
                    </div>
                </div>

                <div style="padding: 0.5rem;">
                    <div style='background: white; border-radius: 5px;font-weight: bold;'>
                        <div style="padding-left: 1rem;padding-right: 1rem;padding-top: 1rem;font-size: 19px !important; display: flex;">
                            ทุนประกันภัย&nbsp;<font id='cost_inform_show'></font>&nbsp;บาท
                        </div>
                        <div class='grid grid-cols-1 gap-6 sm:grid-cols-2' style='padding-left: 1rem;padding-right: 1rem;'>
                            <div class="flex boxz" style="margin: 1rem; padding: 0.5rem;">
                                <div class="w-100">
                                    <div class='span12 e-span12 flex' style='<?php echo $css_margin ?>'>
                                        <!--text-->
                                        <div class='span12 e-span12' style=' <?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font><u>ความรับผิดต่อบุคคลภายนอก</u></font>
                                        </div>
                                    </div>
                                    <div class='span12 e-span12 flex' style='<?php echo $css_margin ?>'>
                                        <!--text-->
                                        <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab ?>'>- ความเสียหายต่อชีวิต
                                                ร่างกาย
                                                หรืออนามัย</font>
                                        </div>
                                        <!--number-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab_right ?>' id='damage_out1_inform_show'>
                                            </font>
                                        </div>
                                        <!--unit-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab ?>'>บาท/คน</font>
                                        </div>
                                    </div>
                                    <div class='span12 e-span12 flex' style='<?php echo $css_margin ?>border-bottom: 1px solid;'>
                                        <!--text-->
                                        <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>

                                        </div>
                                        <!--number-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab_right ?>'>
                                                10,000,000
                                            </font>
                                        </div>
                                        <!--unit-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab ?>'>บาท/ครั้ง</font>
                                        </div>
                                    </div>
                                    <div class='span12 e-span12 flex' style='<?php echo $css_margin ?>border-bottom: 1px solid;'>
                                        <!--text-->
                                        <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab ?>'>- ความเสียหายต่อทรัพสิน
                                            </font>
                                        </div>
                                        <!--number-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab_right ?>' id='damage_cost_inform_show'>
                                            </font>
                                        </div>
                                        <!--unit-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab ?>'>บาท/ครั้ง</font>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex boxz" style="margin: 1rem; padding: 0.5rem;">
                                <div class="w-100">
                                    <div class='span12 e-span12 flex' style='<?php echo $css_margin ?>'>
                                        <!--text-->
                                        <div class='span12 e-span12' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font><u>ความคุ้มครองตามเอกสารแนบท้าย</u></font>
                                        </div>
                                    </div>

                                    <div class='span12 e-span12 flex' style='<?php echo $css_margin ?>border-bottom: 1px solid;'>
                                        <!--text-->
                                        <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab ?>'>- ผู้ขับขี่ 1 คน</font>
                                        </div>
                                        <!--number-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab_right ?>' id='pa1_inform_show'>
                                            </font>
                                        </div>
                                        <!--unit-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab ?>'>บาท/คน</font>
                                        </div>
                                    </div>
                                    <div class='span12 e-span12 flex' style='<?php echo $css_margin ?>border-bottom: 1px solid;'>
                                        <!--text-->
                                        <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab ?>'>- ผู้โดยสาร</font>
                                            <font id='people_inform_show'></font>
                                            <font>คน</font>
                                        </div>
                                        <!--number-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab_right ?>' id='pa2_inform_show'>
                                            </font>
                                        </div>
                                        <!--unit-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab ?>'>บาท/คน</font>
                                        </div>
                                    </div>
                                    <div class='span12 e-span12 flex' style='<?php echo $css_margin ?>border-bottom: 1px solid;'>
                                        <!--text-->
                                        <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab ?>'>- ค่ารักษาพยาบาล</font>
                                        </div>
                                        <!--number-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab_right ?>' id='pa3_inform_show'>
                                            </font>
                                        </div>
                                        <!--unit-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab ?>'>บาท/คน</font>
                                        </div>
                                    </div>
                                    <div class='span12 e-span12 flex' style='<?php echo $css_margin ?>border-bottom: 1px solid;'>
                                        <!--text-->
                                        <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab ?>'>-
                                                การประกันตัวผู้ขับขี่ในคดีอาญา
                                            </font>
                                        </div>
                                        <!--number-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab_right ?>' id='pa4_inform_show'>
                                            </font>
                                        </div>
                                        <!--unit-->
                                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                            <font style='<?php echo $css_margin_font_tab ?>'>บาท/ครั้ง</font>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--END-->
        <button type="button" class="btn btn-primary" onclick='inform_single_save();'>
            <font color='#fff'>แจ้งงาน</font>
        </button>
        <button type="reset" class="btn btn-danger">
            <font color='#fff'>รีเซ็ต</font>
        </button>
    </form>
</div>

<script>
    $('#tel_mobile_inform').mask("999-999-9999");
    $('#tel_mobile2_inform').mask("999-999-9999");
    $('#tel_mobile3_inform').mask("999-999-9999");
    onkeyicard_clear('1');
    async function customerLastName(val) {
        try {
            const widthTextBox = parseInt($("#title_inform option:selected").val().length) * parseInt(15);
            if ($("#title_inform option:selected").val() != '' && $("#title_inform option:selected").val() != '0') {
                if ($('#title_inform').val() == ' บริษัท ' || $('#title_inform').val() == ' ห้างหุ้นส่วนจำกัด' || $(
                        '#title_inform').val() == ' ห้างหุ้นส่วนสามัญ') {
                    $("#TitleCustomer").show().val(`${$("#title_inform option:selected").val()}/จำกัด`);
                } else {
                    $("#TitleCustomer").show().val(`${$("#title_inform option:selected").val()}`);
                }
            } else {
                $("#TitleCustomer").hide().val('');
            }
            $("#TitleCustomer").css('width', `${widthTextBox}px`); // ${widthTextBox}px
            const valTitle = $("#title_inform option:selected").text();
            let params = {
                "Control": 'LastComp',
                "DataTitle": valTitle
            };

            const res = await postApiAsync(params, 'services/CustomerName/CustomerName.controller.php');
            if ($("#person_inform option:selected").val() == '2') {
                if (res.LastCompany != '' || res.ByCustomer != '') {
                    // $("#show_last_title").hide();
                    $("#show_last_text").show();
                    $("#show_last_text").attr('colspan', '2');
                    $("#show_name_text").attr('colspan', '1');
                    $("#last_text").text('');
                    res.ByCustomer != '' ? $("#ByCustomer").show().val(res.ByCustomer) : $("#ByCustomer").hide().val(
                        '');
                    res.ByCustomer != '' ? $("#last_inform").val('').attr("readonly", false) : $("#last_inform").val(res
                        .LastCompany).attr("readonly", true);
                    $("#last_inform").attr('maxlength', parseInt(40) - parseInt($("#ByCustomer").val().length));
                } else {
                    $("#last_inform").val('').attr("readonly", true);
                    $("#show_last_text").hide();
                    $("#show_last_text").attr('colspan', '1');
                    $("#show_name_text").attr('colspan', '3');
                    $("#last_text").text('');
                    $("#ByCustomer").hide().val('');
                    $("#last_inform").attr('maxlength', parseInt(40) - parseInt($("#ByCustomer").val().length));
                }
                if (val == ' ') document.getElementById('TitleCustomer').style.display = 'none';
            }
            return false;
        } catch (err) {
            console.log(err);
        }
    }

    async function handleCalculate(act, net) {
        const _act = await act == false ? document.getElementById('currentValue_prb_inform').value : act;
        const _net = await net == false ? document.getElementById('total_sum_inform').value : net;
        const _total = parseFloat(_act) + parseFloat(_net);

        document.getElementById('total_payment_inform').value = _total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        document.getElementById('total_prb_inform').value = _total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    function checkID_test(id) {
        if (id.length != 13) return false;
        for (i = 0, sum = 0; i < 12; i++)
            sum += parseFloat(id.charAt(i)) * (13 - i);
        if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
            return false;
        return true;
    }

    function onkeyicard(id, id1, event) {
        if (event.which == 37 || event.which == 38 || event.which == 39 || event.which == 40) {
            return false;
        }
        if ($('#person').is(':checked')) {
            if ($("#" + id1).val().search(/^[0-9]{0,9}$/)) {
                $("#" + id1).val('');
                $("#" + id1).focus();
            }
        }
        if (event.keyCode == 8) {
            $("#icard13").val('');
            $("#icard12").val('');
            $("#icard11").val('');
            $("#icard10").val('');
            $("#icard9").val('');
            $("#icard8").val('');
            $("#icard7").val('');
            $("#icard6").val('');
            $("#icard5").val('');
            $("#icard4").val('');
            $("#icard3").val('');
            $("#icard2").val('');
            $("#icard1").val('');
            $("#icard1").focus();
            $("#icard_inform").val('');
        }
        if ($("#" + id1).val() == '') {
            return false;
        }
        if (id != '') {
            $("#" + id).val('');
            $("#" + id).focus();

        }
        var icard_val = $("#icard1").val() + '' + $("#icard2").val() + '' + $("#icard3").val() + '' + $("#icard4").val() +
            '' + $("#icard5").val() + '' + $("#icard6").val() + '' + $("#icard7").val() + '' + $("#icard8").val() + '' + $(
                "#icard9").val() + '' + $("#icard10").val() + '' + $("#icard11").val() + '' + $("#icard12").val() + '' + $(
                "#icard13").val();
        $("#icard_inform").val(icard_val);
        if ($('#person_inform').val() == '1' && icard_val != '' && icard_val.length == 13) {
            if (!checkID_test($('#icard_inform').val())) {
                alert('รหัสประชาชนไม่ถูกต้อง');
                $('#icard_inform').val('');
                $('#icard1').focus();
                onkeyicard_clear(1);
            }
        }
    }

    async function onkeyicard_clear(selectID) {
        try {
            $("#icard1").val('');
            $("#icard2").val('');
            $("#icard3").val('');
            $("#icard4").val('');
            $("#icard5").val('');
            $("#icard6").val('');
            $("#icard7").val('');
            $("#icard8").val('');
            $("#icard9").val('');
            $("#icard10").val('');
            $("#icard11").val('');
            $("#icard12").val('');
            $("#icard13").val('');
            if (selectID == 1) {
                $("#show_name_title").html('ชื่อ');
                $("#last_inform").val('').attr('readonly', false);
                $("#show_last_title").html('นามสกุล');
                $("#show_last_text").show();
                $("#show_last_text").attr('colspan', '1');
                $("#show_name_text").attr('colspan', '1');
                $("#name_inform").attr('style', 'width:200px');
                $("#ByCustomer").hide().val('');
                $("#last_text").text('');
                $("#TitleCustomer").hide().val('');
                $("#name_inform").attr("placeholder", "");
                $("#last_inform").attr("placeholder", "");
                $("#last_inform").attr('maxlength', parseInt(40) - parseInt($("#ByCustomer").val().length));
            }
            if (selectID == 2) {
                $("#show_name_title").html('ชื่อบริษัท');
                $("#last_inform").val('').attr('readonly', true);
                $("#show_last_title").html('.');
                $("#show_last_text").hide();
                $("#show_last_text").attr('colspan', '1');
                $("#show_name_text").attr('colspan', '3');
                $("#name_inform").attr('style', 'width:500px;');
                $("#ByCustomer").hide().val('');
                $("#last_text").text('');
                $("#TitleCustomer").hide().val('');
                $("#last_inform").attr('maxlength', parseInt(40) - parseInt($("#ByCustomer").val().length));
                $("#name_inform").attr("placeholder", "ใส่เฉพาะชื่อบริษัท");
                $("#last_inform").attr("placeholder", "ชื่อกรรมการ 1 ท่าน");
            }

            const titleElem = document.querySelector('#title_inform');
            titleElem.innerHTML = '';
            const opFirst = document.createElement('option');
            opFirst.value = 0;
            opFirst.text = 'กรุณาเลือก';
            titleElem.appendChild(opFirst);
            const url = 'services/InsuranceNotificationWork/insurance-notification-work.controller.php';
            const titleRes = await this.postApiAsync({
                Controller: 'getTitleName',
                personType: selectID
            }, url);

            if (titleRes.Status == 200) {
                titleElem.innerHTML = titleRes.Data;
            }
        } catch (e) {
            console.log(e);
        }
    }

    function onkey_car_regis(id_Next_Elem, id_Elem, event) {
        var tx_car_regis1;
        var tx_car_regis2;
        if (event.keyCode == 8) {
            $("#car_regis7").val('');
            $("#car_regis6").val('');
            $("#car_regis5").val('');
            $("#car_regis4").val('');
            $("#car_regis3").val('');
            $("#car_regis2").val('');
            $("#car_regis1").val('');
            $("#car_regis1").focus();
        }
        if (event.which == 37 || event.which == 38 || event.which == 39 || event.which == 40 || event.which == 32 || event
            .which == 9) {
            if (event.which == 32) {
                $("#" + id_Elem).val('');
            }
            return false;
        }
        if (id_Elem != 'car_regis1' && id_Elem != 'car_regis2' && id_Elem != 'car_regis3' && $("#" + id_Elem).val().search(
                /^[0-9]{0,9}$/)) {
            $("#" + id_Elem).val('');
            $("#" + id_Elem).focus();
            return false;
        }
        if (id_Next_Elem != '' && $("#" + id_Elem).val() != '') {
            $("#" + id_Next_Elem).val('');
            $("#" + id_Next_Elem).focus();

        }
        tx_car_regis1 = $("#car_regis1").val() + '' + $("#car_regis2").val() + '' + $("#car_regis3").val();
        if (tx_car_regis1 != '') {
            tx_car_regis1 += '';
        } else {
            tx_car_regis1 += '';
        }

        tx_car_regis2 = $("#car_regis4").val() + '' + $("#car_regis5").val() + '' + $("#car_regis6").val() + '' + $(
            "#car_regis7").val();

        $("#car_regis_inform").val(tx_car_regis1 + '' + tx_car_regis2);
    }

    function getDate() {
        let year = new Date();
        let today = new Date();
        let dd = today.getDate();
        let mm = today.getMonth() + 1; //January is 0!
        let yyyy = today.getFullYear();

        if (dd < 10) dd = '0' + dd;

        if (mm < 10) mm = '0' + mm;
        let oneYearFromNow = new Date();
        let todayThisYear = oneYearFromNow.toISOString().slice(0, 10);
        oneYearFromNow.setFullYear(oneYearFromNow.getFullYear() + 1);
        let todayNextYear = oneYearFromNow.toISOString().slice(0, 10);

        document.getElementById("end_date").value = todayThisYear;
    }

    getDate();

    async function postApiAsync(_data, _url) //postapi
    {
        return await $.ajax({
            type: "POST",
            url: _url,
            data: _data,
            dataType: "JSON",
            success: (res) => {
                return res;
            },
            error: (err) => {
                return err;
            }
        });
    }

    runProvince();
    run();

    async function loadProvince() {
        const url = 'services/InsuranceNotificationWork/insurance-notification-work.controller.php';
        const ctrlName = {
            Controller: 'getProvince',
        };
        const res = await this.postApiAsync(ctrlName, url);
        return res;

    }
    async function runProvince() {
        const carTypeList = await loadProvince();
        const carProvince = document.querySelector('#province_inform');
        const _carRegisProvince = document.querySelector('#carRegisProvince');

        if (carTypeList.Status == 200) {

            carTypeList.Data.forEach(x => {
                let op = document.createElement('option');
                let op_province = document.createElement('option');
                op.value = x.Id;
                op.text = x.Name;
                op_province.value = x.Id;
                op_province.text = x.Name;
                carProvince.appendChild(op);
                _carRegisProvince.appendChild(op_province);
            });


        }
    }
    $("#province_inform").change(function() {

        $("#tumbon_inform").empty();
        $("#tumbon_inform").append("<option value='0' selected disabled>กรุณาเลือก</option>");
        $("#id_post_inform").empty();
        $("#id_post_inform").append("<option value='0' selected disabled>กรุณาเลือก</option>");
        var _selected = $("#province_inform").val();
        $("#carRegisProvince").val(_selected);

        var options = {

            url: "ajax/Ajax_Pro.php",
            type: "POST",
            dataType: "JSON",
            data: {
                callajax: 'AMPHUR',
                province: _selected
            },
            success: function(msg) {
                $('#amphur_inform').empty();
                var returnedArray = msg;
                state = $("#amphur_inform");
                state.append("<option value='0'>กรุณาเลือก</option>");
                if (returnedArray != null) {
                    for (var i = 0; i < returnedArray.length; ++i) {
                        state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i]
                            .Name + "</option>");
                    }
                } else {
                    return false;
                }

            }
        };
        $.ajax(options);
    });

    $("#amphur_inform").change(function() {
        $("#id_post_inform").empty();
        $("#id_post_inform").append("<option value='0'>กรุณาเลือก</option>");
        var _selected = $("#amphur_inform").val();
        var options = {

            url: "ajax/Ajax_Pro.php",
            type: "POST",
            dataType: "JSON",
            data: {
                callajax: 'TUMBON',
                amphur: _selected
            },
            success: function(msg) {
                $('#tumbon_inform').empty();
                var returnedArray = msg;
                state = $("#tumbon_inform");
                state.append("<option value='0'>กรุณาเลือก</option>");
                if (returnedArray != null) {
                    for (var i = 0; i < returnedArray.length; ++i) {
                        state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i]
                            .Name + "</option>");
                    }
                } else {
                    return false;
                }
            }
        };
        $.ajax(options);
    });
    $("#tumbon_inform").change(function() {
        var _selected = $("#tumbon_inform").val();
        var options = {

            url: "ajax/Ajax_Pro.php",
            type: "POST",
            dataType: "JSON",
            data: {
                callajax: 'POST',
                tumbon: _selected
            },
            success: function(msg) {
                $('#postal_inform').empty();
                var returnedArray = msg;
                state = $("#postal_inform");
                if (returnedArray != null) {
                    for (var i = 0; i < returnedArray.length; ++i) {
                        state.append("<option value='" + returnedArray[i].Name + "'>" + returnedArray[i]
                            .Name + "</option>");
                    }
                } else {
                    return false;
                }
            }
        };
        $.ajax(options);
    });
    async function handleCartype() {
        let _selected = $("#cartype").val();
        // console.log(_selected);
        let _selectedBrand = $("#br_car_inform").val();
        const resModelCar = await getModelCarAct(_selectedBrand, Number(_selected));
        if (resModelCar.Status == 200) {
            handleModelCar(resModelCar.Data)
        }
    };


    async function loadCarType() {
        const url =
            "services/InsuranceNotificationWork/insurance-notification-work.controller.php";
        const ctrlName = {
            Controller: "getTypeOfUse",
        };
        const res = await this.postApiAsync(ctrlName, url);
        return res;
    }
    async function run() {
        try {
            const carTypeList = await loadCarType();
            // console.log(carTypeList);
            const carTypeElem = document.querySelector("#cartype");
            car = $("#cartype");
            if (carTypeList.Status == 200) {
                carTypeList.Data.forEach((x) => {
                    if (x.Id == 1) {
                        const op = document.createElement("option");
                        op.value = x.Id;
                        op.text = x.Name;
                        carTypeElem.appendChild(op);
                    }

                    if (x.Id == 3) {
                        const op = document.createElement("option");
                        op.value = x.Id;
                        op.text = x.Name;
                        carTypeElem.appendChild(op);
                    }
                });
            }
            await handleCartype();
            await handleCarModel();
        } catch (e) {
            console.log(e);
        }
    }
    async function getModelCarAct(brandCarID = 1, passCarID = 1) {
        const url = 'services/InsuranceNotificationWork/insurance-notification-work.controller.php';
        const data = {
            Controller: 'getModelCarAct',
            brandCarID: brandCarID,
            passCarID: passCarID
        };
        const res = await this.postApiAsync(data, url);
        return res;

    }
    async function handleModelCar(data) {
        const moCarElem = document.querySelector('#mo_car');
        moCarElem.innerHTML = '';
        data.forEach(x => {
            const op = document.createElement('option');
            op.value = x.Id;
            op.text = x.Name;
            moCarElem.appendChild(op);
        });
    }

    // event เลือกประเภทรถ เพื่อพ้นข้อมูลรุ่นรถ
    let cartypeElement = document.querySelector('#cartype');
    cartypeElement.addEventListener('change', async function() {
        await handleCartype();
        await handleCarModel();
        await findInsurancePremiums();
    })

    // event เลือกรุ่นรถ เพื่อพ้นข้อมูลรุ่นย่อย
    let CarModelElement = document.querySelector('#mo_car');
    CarModelElement.addEventListener('change', async function() {
        await handleCarModel();
        await findInsurancePremiums();
    })

    // event เลือกรุ่นย่อย เพื่อหาเบี้ย
    let subMoCarElement = document.querySelector('#sub_mo_car');
    subMoCarElement.addEventListener('change', async function() {
        await findInsurancePremiums();
    })

    // event เลือกปีจดทะเบียน เพื่อหาเบี้ย
    let regisDateElement = document.querySelector('#regis_date_inform');
    regisDateElement.addEventListener('change', async function() {
        await findInsurancePremiums();
        // await calculatePayment($('#pre_inform').val(), $('#currentValue_prb_inform').val(), 18, 12,
        //     'total_commition_inform', 'total_payment_inform');
    })

    // event เลือกการซ่อม เพื่อหาเบี้ย
    let serviceElement = document.querySelector('#service_inform');
    serviceElement.addEventListener('change', async function() {
        await findInsurancePremiumsByService();
    })

    async function handleCarModel() {
        let _selected = $("#mo_car").val();
        let _selectedCarType = $("#cartype").val();
        const resModelCarSub = await getModelCarSub(_selectedCarType, _selected);
        if (resModelCarSub.Status == 200) {
            handleModelCarSub(resModelCarSub.Data)
        }
    };

    async function getModelCarSub(carTypeID = 1, modelCarID = 1993) {
        const url = 'services/InsuranceNotificationWork/insurance-notification-work.controller.php';
        const data = {
            Controller: 'getModelCarSub',
            modelCarID: modelCarID,
            passCarID: carTypeID
        };
        const res = await this.postApiAsync(data, url);
        return res;
    }

    async function handleModelCarSub(res) {
        const subMoCarElem = document.querySelector('#sub_mo_car');
        subMoCarElem.innerHTML = '';
        res.forEach(x => {
            const op = document.createElement('option');
            op.value = x.Id;
            op.text = x.Name;
            subMoCarElem.appendChild(op);
        });
    }

    async function preCheckfindInsurancePremiums() {
        if ($('#regis_date_inform').val() != null) {
            return true;
        }
        return false;
    }

    async function findInsurancePremiums() {
        /*const ccc = await preCheckfindInsurancePremiums();
        if (ccc === false) {
            await $('#regis_date_inform').focus();
            await alert('กรุณากรอกข้อมูลรถยนต์ให้ครบ เพื่อค้นหาเบี้ยประกัน');
            return false;
        }*/
        const req = {
            Controller: 'findInsurancePremiums',
            carBrandID: $('#br_car_inform').val(),
            carModelID: $('#mo_car').val(),
            carSubModelID: $('#sub_mo_car').val(),
            passCarID: $('#cartype').val(),
            carYear: $('#regis_date_inform').val()
        };

        const res = await postApiAsync(req,
            'services/InsuranceNotificationWork/insurance-notification-work.controller.php');

        if (res.Status == 200) {
            $("#pre_inform").val(res.Data.premiumNet);
            $("#total_sum_inform").val(res.Data.premium);
            $("#doc_type_inform").val(res.Data.insuredType);
            $("#service_inform").val(res.Data.repair);

            $("#cost_inform_show").text(res.Data.sumAssured);
            $("#damage_out1_inform_show").text(res.Data.life);
            $("#damage_cost_inform_show").text(res.Data.asset);
            $("#pa1_inform_show").text(res.Data.driver);
            $("#pa2_inform_show").text(res.Data.passenger);
            $("#people_inform_show").text(res.Data.tikets);
            $("#pa3_inform_show").text(res.Data.nurse);
            $("#pa4_inform_show").text(res.Data.insuran);
            $("#idCost").val(res.Data.idCost);

            handleCalculate(false, res.Data.premium);

            if (res.Data.premium == '0.00' || res.Data.premium == '0') {
                document.getElementById('hiddenPremium').style.display = 'none';
                document.getElementById('showTextPremium').style.display = 'block';
            } else {
                document.getElementById('hiddenPremium').style.display = 'block';
                document.getElementById('showTextPremium').style.display = 'none';
            }
        }
        console.log('findInsurancePremiums-res', res);
    }
    // event เลือก พ.ร.บ
    let selectPrbInform = document.querySelector('#select_prb_inform');
    selectPrbInform.addEventListener('change', async function() {
        // await findInsurancePremiums();
        $('#currentValue_prb_inform').val(this.value);
        // await calculatePayment($('#pre_inform').val(), $('#currentValue_prb_inform').val(), 18, 12,
        //     'total_commition_inform', 'total_payment_inform');
    })


    async function inform_single_save() {
        console.log('regis_date_inform', $("#regis_date_inform").val());

        if (document.getElementsByName('agent_inform')[0].value == '') {
            $("#agent_inform").focus();
            alert("กรุณาเลือกสาขาแจ้งงาน");
            return false;
        }
        if (document.getElementsByName('emp_inform')[0].value == '') {
            $("#emp_inform").focus();
            alert("กรุณาเลือกผู้แจ้ง");
            return false;
        }
        if ($("#person_inform").val() == "") {
            $("#person_inform").focus();
            alert("กรุณาเลือกประเภทบุคคล");
            return false;
        }
        if ($("#icard_inform").val() == "") {
            $("#icard_inform").focus();
            alert("กรุณากรอกเลขบัตรหรือทะเบียนการค้า");
            return false;
        }
        if ($("#title_inform").val() == "0") {
            $("#title_inform").focus();
            alert("กรุณาเลือกคำนำหน้า");
            return false;
        }
        if ($("#name_inform").val() == "") {
            $("#name_inform").focus();
            alert("กรุณากรอกชื่อ");
            return false;
        }
        if (document.getElementById('show_last_text').style.display != 'none') {
            if ($("#last_inform").val() == "") {
                $("#last_inform").focus();
                alert("กรุณากรอกนามสกุล");
                return false;
            }
        }
        if ($("#car_regis_inform").val() == '') {
            $("#car_regis_inform").focus();
            alert('กรุณากรอกป้ายทะเบียน');
            return false;
        }
        if ($("#add_inform").val() == "") {
            $("#add_inform").focus();
            alert("กรุณากรอกบ้านเลขที่");
            return false;
        }
        if ($("#province_inform").val() == "0") {
            $("#province_inform").focus();
            alert("กรุณาเลือกจังหวัด");
            return false;
        }
        if ($("#amphur_inform").val() == "0") {
            $("#amphur_inform").focus();
            alert("กรุณาเลือกอำเภอ");
            return false;
        }
        if ($("#tumbon_inform").val() == "0") {
            $("#tumbon_inform").focus();
            alert("กรุณาเลือกตำบล");
            return false;
        }
        if ($("#postal_inform").val() == "") {
            $("#postal_inform").focus();
            alert("กรุณากรอกรหัสไปรษณีย์");
            return false;
        }
        if ($("#email_inform").val() == "") {
            $("#email_inform").focus();
            alert("กรุณากรอกอีเมล์");
            return false;
        }
        if ($("#tel_mobile_inform").val() == "") {
            $("#tel_mobile_inform").focus();
            alert("กรุณากรอกเบอร์");
            return false;
        }

        if ($("#end_date").val() == "") {
            $("#end_date").focus();
            alert("กรุณากรอกวันหมดอายุ");
            return false;
        }
        if ($("#cartype").val() == "") {
            alert("กรุณาเลือกประเภทการใช้งานด้วยครับ");
            $("#cartype").focus();
            return false;
        }
        if ($("#br_car_inform").val() == "0") {
            $("#br_car_inform").focus();
            alert("กรุณาเลือกยี่ห้อรถ");
            return false;
        }
        if ($("#mo_car").val() == "0") {
            alert("กรุณาเลือกรุ่นรถด้วยครับ");
            $("#mo_car").focus();
            return false;
        }
        if ($("#regis_date_inform").val() == "0" || $("#regis_date_inform").val() === null) {
            $("#regis_date_inform").focus();
            alert("กรุณาเลือกปี");
            return false;
        }
        if ($("#cc_inform").val() == "") {
            $("#cc_inform").focus();
            alert("กรุณาเลือกซีซี");
            return false;
        }
        if ($("#wg_inform").val() == "") {
            $("#wg_inform").focus();
            alert("กรุณาเลือกน้ำหนักรถ");
            return false;
        }
        if ($("#car_seat_inform").val() == "") {
            $("#car_seat_inform").focus();
            alert("กรุณากรอกจำนวนที่นั่ง");
            return false;
        }
        if ($("#serialNumber").val() == "") {
            $("#serialNumber").focus();
            alert("กรุณากรอกเลขเครื่อง");
            return false;
        }
        if ($("#chassisNumber").val() == "") {
            $("#chassisNumber").focus();
            alert("กรุณากรอกเลขตัวถัง");
            return false;
        }
        if (document.getElementsByName('beneficiary')[0].value == '') {
            $("#beneficiary").focus();
            alert("กรุณากรอกผู้รับผลประโยชน์");
            return false;
        }

        let data = {
            Controller: "importInformSingleRenew",
            personID: document.getElementById("person_inform").value,
            cardID: document.getElementById("icard_inform").value,
            title: document.getElementById("title_inform").value,
            name: document.getElementById("name_inform").value,
            last: document.getElementById("last_inform").value,
            add: document.getElementById("add_inform").value,
            group: document.getElementById("group_inform").value,
            lane: document.getElementById("lane_inform").value,
            road: document.getElementById("road_inform").value,
            province: document.getElementById("province_inform").value,
            amphur: document.getElementById("amphur_inform").value,
            tumbon: document.getElementById("tumbon_inform").value,
            postal: document.getElementById("postal_inform").value,
            email: document.getElementById("email_inform").value,
            telMobile: document.getElementById("tel_mobile_inform").value,
            telMobile2: document.getElementById("tel_mobile2_inform").value,
            telMobile3: document.getElementById("tel_mobile3_inform").value,
            endDate: document.getElementById("end_date").value,
            carType: document.getElementById("cartype").value,
            brCar: document.getElementById("br_car_inform").value,
            moCar: document.getElementById("mo_car").value,
            subMoCar: document.getElementById("sub_mo_car").value,
            regisDate: document.getElementById("regis_date_inform").value,
            regisCard: document.getElementById("car_regis_inform").value,
            CC: document.getElementById("cc_inform").value,
            weight: document.getElementById("wg_inform").value,
            seat: document.getElementById("car_seat_inform").value,
            serialNumber: document.getElementById("serialNumber").value,
            chassisNumber: document.getElementById("chassisNumber").value,
            beneficiary: document.getElementById("beneficiary").value,
            agentCode: document.getElementById("agent_inform").value,
            carRegisProvince: document.getElementById("carRegisProvince").value,
            idCost: document.getElementById("idCost").value
        };

        let req = {
            type: "POST",
            dataType: "json",
            url: "services/ImportExcelFileRenew/import-excel-file-renew.controller.php",
            data: data,
            success: function(res) {
                return res;
            },
            error: function(e) {
                return false;
            },
        };

        let res = await $.ajax(req);

        if (res.Data.notfoundModelCar) {
            Swal.fire({
                type: 'error',
                title: 'บันทึกผิดพลาด',
                text: 'กรุณาตรวจสอบข้อมูลอีกครั้ง!',
            })
        } else {
            Swal.fire({
                type: 'success',
                title: 'บันทึกสำเร็จ',
                text: `เลขรับเเจ้งคือ ${res.Data.idData}`

            }).then((result) => {
                console.log('Swal.fire.then');
                $('#page-content').html(
                    '<p><br><br><center><img src="img4/loadingIcon.gif"  /> <img src="img4/loadingIcon.gif"  /> <img src="img4/loadingIcon.gif"  /></center></p>'
                ).load(`pages/renew_suzuki_select.php?id=${res.Data.idData}`);
            });

        }
    }

    async function findInsurancePremiumsByService() {
        /*const ccc = await preCheckfindInsurancePremiums();
        if (ccc === false) {
            await $('#regis_date_inform').focus();
            await alert('กรุณากรอกข้อมูลรถยนต์ให้ครบ เพื่อค้นหาเบี้ยประกัน');
            return false;
        }*/
        const req = {
            Controller: 'findInsurancePremiumsByService',
            carBrandID: $('#br_car_inform').val(),
            carModelID: $('#mo_car').val(),
            carSubModelID: $('#sub_mo_car').val(),
            passCarID: $('#cartype').val(),
            carYear: $('#regis_date_inform').val(),
            serviceCar: $('#service_inform').val()
        };

        let service_text = $('#service_inform option:selected').text();

        const res = await postApiAsync(req,
            'services/InsuranceNotificationWork/insurance-notification-work.controller.php');

        if (res.Status == 200) {
            $("#pre_inform").val(res.Data.premiumNet);
            $("#total_sum_inform").val(res.Data.premium);
            $("#doc_type_inform").val(res.Data.insuredType);
            $("#service_inform").val(res.Data.repair);

            $("#cost_inform_show").text(res.Data.sumAssured);
            $("#damage_out1_inform_show").text(res.Data.life);
            $("#damage_cost_inform_show").text(res.Data.asset);
            $("#pa1_inform_show").text(res.Data.driver);
            $("#pa2_inform_show").text(res.Data.passenger);
            $("#people_inform_show").text(res.Data.tikets);
            $("#pa3_inform_show").text(res.Data.nurse);
            $("#pa4_inform_show").text(res.Data.insuran);
            $("#idCost").val(res.Data.idCost);

            handleCalculate(false, res.Data.premium);

            if (res.Data.premium == '0.00' || res.Data.premium == '0') {
                // document.getElementById('hiddenPremium').style.display = 'none';
                Swal.fire({
                    type: 'warning',
                    title: `คำเตือน`,
                    text: `ไม่พบข้อมูลเบี้ย ${service_text}`
                }).then((result) => {
                    document.getElementById('showTextPremium').style.display = 'none';
                    $('#service_inform').val(1);
                    findInsurancePremiums();
                });
            } else {
                document.getElementById('hiddenPremium').style.display = 'block';
                document.getElementById('showTextPremium').style.display = 'none';
            }
        }
        console.log('findInsurancePremiums-res', res);
    }
</script>