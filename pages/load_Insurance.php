<?php

include "check-ses.php";
include "../inc/connectdbs.pdo.php";

$_contextMitSu = PDO_CONNECTION::fourinsure_mitsu();
$_contextFour = PDO_CONNECTION::fourinsure_insured();
$accesForce = $_contextMitSu->query("SELECT mo_sub,`name` FROM tb_acc_new WHERE AccesForce = '1' ")->fetchAll(2);
$JSON_accesForce = json_encode($accesForce);
header('Content-Type: text/html; charset=utf-8');
echo
"<script>
    var _strUserJs = '$_SESSION[strUser]';
    var _accesForce = '$JSON_accesForce';
    localStorage.setItem('SessionName','$_SESSION[name]');
    localStorage.setItem('SakaDear','$_SESSION[saka]');
  </script>";
?>

<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />
<link rel="stylesheet" href="./css/load-insurance.css">
<link rel="stylesheet" href="./css/row-col.css">
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

<script type="text/javascript" language="javascript">
blink = function(options) {
    var defaults = {
        delay: 500
    };
    var options = $.extend(defaults, options);

    return this.each(function() {
        var obj = $(this);
        setInterval(function() {
            if ($(obj).css("visibility") == "visible") {
                $(obj).css('visibility', 'hidden');
            } else {
                $(obj).css('visibility', 'visible');
            }
        }, options.delay);
    });
}

$(document).ready(function() {
    // $('#car_body').mask("99999999");
    $('#start_date').datepicker({
        format: "dd/mm/yyyy",
        startDate: "today",
        language: "th",
        autoclose: true
    });

    $('#page-content').css({
        'background-color': '#eee'
    });

});
</script>

<?php include './load-insurance.js.php'; ?>
<script src="js/js_Insurance.js" type="text/javascript"></script>

<style>
.active-result {
    white-space: nowrap;
}

.modal-position-noti {
    position: fixed;
    z-index: 100;
    top: 0;
    left: 0;
    width: 100%;
    align-items: center;
    justify-content: center;
    height: 100%;
    background: #6969699e;
}

.noti-width {
    width: 47rem;
}

.noti-width-policy {
    width: 65rem;
}

.noti-height {
    height: 30vh;
    text-align: center;
    font-size: 25px;
}

.noti-height-policy {
    height: 33vh !important;
    overflow-y: scroll;
    overflow-x: hidden;
    padding: 1rem !important;
    height: 30vh;
    text-align: center;
    font-size: 25px;
}

#Insurance input[readonly],
#Insurance input[type="text"] {
    box-sizing: border-box;
    height: 34px;
}

#Insurance select {
    height: 34px;
}

#Insurance .chosen-container {
    width: 100% !important;
}

#Insurance .chosen-single {
    height: 34px !important;
}

#Insurance .chosen-container-single .chosen-single div {
    top: 4px;
}

#Insurance .chosen-container-single .chosen-single {
    background: #fff;
}

.font-bold {
    font-weight: 700;
}

.input-inner {
    border: 1px solid #605e5e !important;
    box-shadow: inset 0 1px 3px #424242 !important;
    width: 30px;
    margin: 1px;
}

.cost {
    background: #accad9;
    height: 100%;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.w-65 {
    width: 65%;
}
</style>

<div style="margin-left:auto;margin-right:auto;" class="row-fluid">
    <form name="Insurance" id="Insurance">
        <div id="showSQL"></div>
        <div class="row-fluid">
            <div class="span12">
                <div class="">
                    <div class="widget-header widget-header-flat">
                        <h4>ข้อมูลทั่วไป</h4>
                    </div>
                    <div class="widget-body mb-2">
                        <div class="widget-main">
                            <div class="row g-2">
                                <input name="insureYear" type="hidden" id="insureYear" value="1" readonly='true' />
                                <input name="ty_prot" type="hidden" id="ty_prot" value="<?php print $ty_prot; ?>" />
                                <input name="send_date" type="hidden" id="send_date" size="40" maxlength="10"
                                    readonly="true" value="<?php echo  date("Y-m-d H:i"); ?>" />
                                <input name="xuser" type="hidden" id="xuser"
                                    value="<?php echo  $_SESSION["strUser"]; ?>" />
                                <input name="xUserName" type="hidden" id="xUserName"
                                    value="<?php echo  $_SESSION["strPass"]; ?>" />
                                <input name="name_inform" type="hidden" id="name_inform" size="40" maxlength="40"
                                    readonly="true" value="<?php echo  $_SESSION["strName"]; ?>" />
                                <input type="hidden" name="doc_type" id="doc_type" value="1" />
                                <input name="idtb_login" type="hidden" id="idtb_login"
                                    value="<?php echo  $_SESSION["idtb_login"]; ?>" />
                                <input name="usertb_login" type="hidden" id="usertb_login"
                                    value="<?php echo  $_SESSION["lguser"]; ?>" />

                                <div style="display:none;">
                                    <div id="Driver">
                                        <input name="rdodriver" type="radio" class="style1" id="rdodriverN" value="N"
                                            checked="checked" />
                                        <input id="rdodriver1" name="rdodriver" type="radio" value="1"
                                            disabled="disabled" />
                                        <input id="rdodriver2" name="rdodriver" type="radio" value="2"
                                            disabled="disabled" />
                                    </div>
                                    <div id="Divdriver1" style="display:none; width:630px;">
                                        <select name="title_num1" id="title_num1">
                                            <option value=""></option>
                                        </select>
                                        <input id="name_num1" name="name_num1" type="text" class="TEXTBOX" value=""
                                            size="20" /><input id="last_num1" name="last_num1" type="text"
                                            class="TEXTBOX" value="" size="20" />
                                        <input name="birth_num1" type="text" id="birth_num1" size="10" maxlength="10"
                                            readonly="true" />
                                        <input name="licen_num1" type="text" id="licen_num1" size="13" maxlength="13" />
                                        <input name="iden_num1" type="text" id="iden_num1" size="13" maxlength="13" />
                                    </div>
                                    <div id="Divdriver2" style="display:none; width:630px;">
                                        <select name="title_num2" id="title_num2">
                                            <option value=""></option>
                                        </select>
                                        <input id="name_num2" name="name_num2" type="text" class="TEXTBOX" value=""
                                            size="20" />
                                        <input id="last_num1" name="last_num1" type="text" class="TEXTBOX" value=""
                                            size="20" />
                                        <input name="birth_num2" type="text" id="birth_num2" size="10" maxlength="10"
                                            readonly="true" />
                                        <input name="licen_num2" type="text" id="licen_num2" size="13" maxlength="13" />
                                        <input name="iden_num2" type="text" id="iden_num2" size="13" maxlength="13" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-error"><i class="icon-warning-sign"></i> การค้นหาต้องลบข้อความแล้วพิมพ์ใหม่ทุกครั้ง</div>
                                </div>
                                <div class="col-12">
                                    <label for="insureYear1">ประเภทประกันภัย</label>
                                    <input id='insureYear1' name='insureYear_select' type='radio' value='1'
                                        checked="checked" /> ประกันภัย 1 ปี
                                </div>
                                <?php if ($_SESSION["strUser"] == "admin") { ?>
                                <div class="col-2">
                                    <label for="Dxuser">สาขาแจ้งงาน</label>
                                    <input type="text" name="Dxuser" list="Dxuser" class="w-100" placeholder="เลือกสาขาแจ้งงาน" value="">
                                    <datalist id="Dxuser">
                                        <?php
                                            $query_D = "SELECT * FROM `tb_customer` WHERE `nameuser` = 'Mitsubishi' ORDER BY `tb_customer`.`user` ASC"; // id = '1' 
                                            $objQueryD = PDO_CONNECTION::fourinsure_mitsu()->query($query_D)->fetchAll(2);
                                            foreach ($objQueryD as $objResultD) {
                                                echo "<option value='$objResultD[user]'>[$objResultD[user]] : $objResultD[sub]</option>";
                                            }
                                        ?>
                                    </datalist>
                                </div>
                                <?php } ?>
                                <div class="col-1">
                                    <label for="start_date">วันคุ้มครอง</label>
                                    <input name="start_date" type="text" id="start_date" class="w-100"
                                        value="<?php echo date("d/m/Y"); ?>" readonly />
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-1">
                                    <label for="cartype">ประเภทการใช้</label>
                                    <span id="cartypeDiv">
                                        <select name="cartype" id="cartype" class="w-100">
                                            <option value="0">กรุณาเลือก</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="col-2">
                                    <label for="car_id">ลักษณะใช้งาน</label>
                                    <span id="car_idDiv">
                                        <select name="car_id" id="car_id" class="w-100">
                                            <option value="0">กรุณาเลือก</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="col-1">
                                    <label for="cat_car">ประเภทรถ</label>
                                    <span id="cat_carDiv">
                                        <select name="cat_car" id="cat_car" class="w-100">
                                            <option value="0">กรุณาเลือก</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="col-1">
                                    <label for="br_car">ยี่ห้อรถ</label>
                                    <span id="br_carDiv">
                                        <select name="br_car" id="br_car" class="w-100">
                                            <option value="0">กรุณาเลือก</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="col-4">
                                    <label for="mo_car">รุ่นรถ</label>
                                    <div class="d-flex">
                                        <span id="mo_carDiv">
                                            <select name="mo_car" id="mo_car" class="w-100">
                                                <option value="0">กรุณาเลือก</option>
                                            </select>
                                        </span>
                                        <span id='mo_dev' style="display:none;">
                                            <select name="mo_car_sub" id="mo_car_sub" class="w-100"
                                                style="display:none;" onchange='mo_sub_start();'>
                                                <option value="0">กรุณาเลือกรุ่นรถย่อย</option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-1">
                                    <label for="car_cc">ซี.ซี.</label>
                                    <select name="car_cc" id="car_cc" class="w-100">
                                        <option value="0" selected="selected">กรุณาเลือก</option>
                                        <option value="1">ต่ำกว่า 2000 cc</option>
                                        <option value="2">มากกว่า 2000 cc</option>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label for="car_wgt">น้ำหนัก</label>
                                    <select name="car_wgt" id="car_wgt" class="w-100">
                                        <option value="" selected>กรุณาเลือก</option>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label for="car_seat">ที่นั่ง</label>
                                    <select name="car_seat" id="car_seat" class="w-100">
                                        <option value="0" selected="selected">กรุณาเลือก</option>
                                        <option value="3">ไม่เกิน 3 ที่นั่ง</option>
                                        <option value="7">ไม่เกิน 7 ที่นั่ง</option>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label for="gear">เกียร์</label>
                                    <select name="gear" size="1" id="gear" class="w-100">
                                        <option value="0" selected="selected">กรุณาเลือก</option>
                                        <option value="A">อัตโนมัติ</option>
                                        <option value="M">ธรรมดา</option>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label for="gear">ทะเบียนรถ</label>
                                    <input readonly name="car_regis" type="text" id="car_regis" value="ป้ายแดง"
                                        maxlength="8" class="w-100" />
                                </div>
                                <div class="col-1">
                                    <label for="regis_date">ปีจดทะเบียน</label>
                                    <select name="regis_date" id="regis_date" onchange="javascript:showCarAge();"
                                        class="w-100">
                                        <option selected><?php echo  date('Y'); ?></option>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label for="car_regis_pro">จังหวัด</label>
                                    <select class="w-100" name='car_regis_pro' id='car_regis_pro'>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label for="car_regis_pro">สีรถ</label>
                                    <select name="car_color" id="car_color" style="width:auto;" class="w-100">
                                    </select>
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col-2">
                                    <label for="car_body">เลขตัวถัง
                                        <font color="#FF0000"><b> * ระบุเลข 8 ตัวหลัง</b></font>
                                    </label>
                                    <div class="d-flex">
                                        <input name="new_carbody" type="text" id="new_carbody" class="w-65" readonly>
                                        <input name="car_body" type="text" id="car_body" class="w-100" maxlength="8" />
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label for="n_motor">เลขเครื่อง
                                        <font color="#FF0000"><b> * ระบุเลขตัวหลัง</b></font>
                                    </label>
                                    <div class="d-flex">
                                        <input name="new_motor" type="text" id="new_motor" class="w-65" readonly>
                                        <input name="n_motor" type="text" id="n_motor" class="w-100" maxlength="20">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <label for="name_gain">ผู้รับผลประโยชน์</label>
                                    <select name="name_gain" id="name_gain" class="w-100">
                                        <?php
                                        echo '<option value="0">กรุณาเลือกชื่อผู้รับผลประโยชน์</option>';
                                        echo '<option value="ไม่ระบุ">ไม่ระบุ</option>';
                                        $query_accessories = "SELECT * FROM `tb_heiress` WHERE `OpenClose` != 0 ORDER BY `tb_heiress`.`No` ASC"; // id = '1'
                                        $objQuery = $_contextMitSu->query($query_accessories)->fetchAll(2);
                                        foreach ($objQuery as $objResult) {
                                            echo "<option value='$objResult[name]'>$objResult[name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-2 text-right" id="cost_array">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--id moreDetails ตัวโชและซ่อน ในกรณีเลือก อุปกรณ์ที่เป็นของเปลียนแปลงประเภทรถ-->
        <div id='moreDetails'>
            <div class="widget-header widget-header-flat">
                <h4>ข้อมูลบริษัทประกันภัย</h4>
            </div>
            <div class="widget-body mb-2">
                <div class="widget-main">
                    <div class="row g-2">
                        <div style="display: none;">
                            <select name='com_data' id='com_data'>
                                <option value="0">กรุณาเลือก</option>
                            </select>
                            <select name="ty_inform" id="ty_inform">
                                <option value="L">ป้ายแดง</option>
                            </select>
                        </div>
                        <div class="col-1">
                            <label for="costCost">ทุนประกันภัย</label>
                            <select name="costCost" id="costCost" class="w-100">
                                <option value="0">--------------</option>
                            </select>
                        </div>
                        <div class="col-1">
                            <label for="costPre">เบี้ยสุทธิ</label>
                            <input value="0.00" name="costPre" type="text" id="costPre" maxlength="10"
                                class="w-100 form-control" readonly="readonly">
                        </div>
                        <div class="col-1">
                            <label for="costStamp">อากร</label>
                            <input value="0.00" name="costStamp" type="text" id="costStamp" maxlength="10" class="w-100"
                                readonly="readonly" />
                        </div>
                        <div class="col-1">
                            <label for="costTax">ภาษี</label>
                            <input value="0.00" name="costTax" type="text" id="costTax" maxlength="10" class="w-100"
                                readonly="readonly" />
                        </div>
                        <div class="col-1">
                            <label for="costNet">เบี้ยรวมภาษี</label>
                            <input value="0.00" name="costNet" type="text" id="costNet" maxlength="10" class="w-100"
                                readonly="readonly" />
                        </div>
                        <div class="col-1">
                            <label for="bill">ใบเสร็จรับเงิน</label>
                            <select name="bill" id="bill" class="w-100">
                                <option value="Dealer">Dealer</option>
                                <option value="Customer">Customer</option>
                                <option value="MMTh">MMTh</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-1">
                            <label for="finance_add_tun">ไฟแนนซ์เพิ่มทุน</label>
                            <select id="finance_add_tun" name="finance_add_tun" class="w-100" autocomplete="off"
                                onchange="handleAddTun()">
                                <option value="0">กรุณาเลือก</option>
                                <option value="N">ไม่ระบุ</option>
                                <option value="10000">10,000</option>
                                <option value="20000">20,000</option>
                                <option value="add">เพิ่มทุน</option>
                            </select>
                        </div>
                        <div class="col-1" id="customTun" style="display: none;">
                            <label for="finance_custom_tun">เพิ่มทุน</label>
                            <select id="finance_custom_tun" name="finance_custom_tun" class="w-100" autocomplete="off"
                                onchange="handleAddTun()">
                                <option value="0">กรุณาเลือก</option>
                                <option value="30000">30,000</option>
                                <option value="40000">40,000</option>
                                <option value="50000">50,000</option>
                                <option value="60000">60,000</option>
                                <option value="70000">70,000</option>
                                <option value="80000">80,000</option>
                                <option value="90000">90,000</option>
                                <option value="100000">100,000</option>
                            </select>
                        </div>
                        <div class="col-1">
                            <label for="finance_add_tun_price">เบี้ยเพิ่ม</label>
                            <input name="finance_add_tun_price" value="0.00" class="w-100" id="finance_add_tun_price"
                                type="text" readonly="readonly" />
                        </div>
                    </div>
                    <div class="row g-2 mt-2">
                        <div class="col-3">
                            <label for="">อุปกรณ์เพิ่มเติม</label>
                            <input name="equit" type="radio" value="N" checked="checked" id="eq_non" />
                            ไม่มี &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input name="equit" type="radio" value="Y" id="eq" />
                            มี&nbsp;&nbsp;<font color="#FF0000"><b> * (เพิ่มราคาทุน /
                                    เพิ่มเบี้ย)</b></font>
                        </div>
                        <div id='getDataAccesForceShow' class="col-9" style='display:none;'></div>
                        <div id="More" style="display:none;padding: 0;" class="col-12">
                            <div class="row g-2" style="background: #fff;margin: 0;padding: 1rem;">
                                <div class="col-12 text-center">
                                    <p class="font-bold">โปรดระบุอุปกรณ์</p>
                                    <p class="font-bold">อุปกรณ์ตกแต่ง "ไม่คุ้มครอง" จะต้องระบุใบกรมธรรม์เท่านั้น</p>
                                    <p class="font-bold">หากมีการติดตั้งอุปกรณ์ตกแต่งเพิ่ม "จะต้องระบุ" จึงจะได้รับความคุ้มครอง</p>
                                    <p class="font-bold">คุ้มครองอุปกรณ์ตกแต่งเพิ่มเติม "ต้องระบุเท่านั้น"</p>
                                </div>
                                <div class="col-12 p-0">
                                    <input type="hidden" name="COUNTMORE" id="COUNTMORE" value="0" />
                                    <strong>รายการอุปกรณ์ตกแต่ง </strong>
                                    <button class="btn btn btn-info" type="button" name="ADDTABLE" id="ADDTABLE"><i
                                            class="icon-upload"></i>เพิ่มอุปกรณ์</button>
                                    <button class="btn btn btn-danger" type="button" name="moreclose" id="moreclose"><i
                                            class="icon-download"></i>ลบอุปกรณ์</button>
                                </div>
                                <div class="col-12">
                                    <label class="text-danger mt-2">*
                                        หากไม่มีรายการอุปกรณ์ที่ต้องการเลือกกรุณาติดต่อเจ้าหน้าที่เพื่อเพิ่มรายการ</label>
                                </div>
                                <div class="col-8" id="MORE_ADD">
                                </div>
                                <div class="col-1">
                                    <label for="">ทุนรวม(บาท)</label>
                                    <textarea style="display:none;" name="acc" id="acc" cols="45" rows="5"></textarea>
                                    <input style="font-size:16px;" name="price_acc_tun" value="0" id="price_acc_tun"
                                        type="text" class="w-100" readonly />
                                </div>
                                <div class="col-1">
                                    <label for="">เบี้ยรวม(บาท)</label>
                                    <input style="font-size:16px;" name="price_acc_cost" value="0" id="price_acc_cost"
                                        type="text" class="w-100" size="5" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-3">
                            <label class="text-danger" for="">ประกันภัย ซื้อเพิ่ม</label>
                            <input type="radio" class="addon_N" data-id="N" value="N" id="checkAddonN"
                                name="checkAddon">
                            ไม่ซื้อ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" class="addon_Y" value="Y" id="checkAddonY" name="checkAddon"
                                onclick='addon_start();'> ซื้อ
                        </div>
                        <div id="boxAddOn" class="col-12 m-0 p-0 mt-2" style="display:none;background: #fff;">
                            <div id="tbAddOn">
                                <div id="MORE_ADDON_SELECT">
                                </div>
                            </div>
                            <div style="font-size:18px;margin-top:10px;padding: 1rem;">
                                <input type="hidden" name="check_addonY" id="check_addonY" value="">
                                <label for="costIns">เพิ่มเบี้ยรวม(บาท)</label>
                                <input type="text" id="costIns" name="costIns" class="btn btn-danger" value="0"
                                    onkeyup='addon_start();'>
                            </div>
                            <input type="hidden" id="aoCounter" name="aoCounter" value="0">
                        </div>
                        <div id="addONHideBtn" style="display:none;">
                            <?php
                                        $select_addon_sql = "SELECT * FROM tb_addon WHERE  star_date <= '" . date('Y-m-d') . "' AND end_date >= '" . date('Y-m-d') . "'";
                                        $select_addon_query = $_contextMitSu->query($select_addon_sql)->fetchAll(2);
                                        $numch = 0;
                                        foreach ($select_addon_query as $select_addon_array) { 
                                    ?>
                            <div class='' style='border-style:none none solid none; border-width:3px;'>
                                <div class=''>
                                    <input type='checkbox' name='addon_buy[]'
                                        value='<?php echo $select_addon_array['id']; ?>,<?php echo $select_addon_array['cost_insuran']; ?>,<?php echo $select_addon_array['code_addon']; ?>'
                                        onclick='addon_start("<?php echo $numch; ?>");'> ซื้อ
                                </div>
                                <div class=''>
                                    <?php echo $select_addon_array['name_addon'] . " " . $select_addon_array['id_add']; ?>
                                </div>
                                <div class=''>
                                    <?php echo $select_addon_array['cost_insuran'] . " บาท"; ?>
                                </div>
                                <div class=''>
                                    <?php if (!empty($select_addon_array['link_addon'])) { ?>
                                    <a class="btn btn-small btn-info" target="_blank"
                                        href="<?php echo $select_addon_array['link_addon']; ?>">
                                        <i class="icon-download"></i>Download ใบปลิว</a>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php $numch++; } ?>
                        </div>
                        <div class='col-12' id='warningForEquipmentChangeTypeCar'
                            style='line-height: 20pt;color: white;margin:0;text-align:center;display:none;padding:50px;background-color:#b74635;font-size:20px;'>
                            มีอุปกรณ์ตกแต่งสำหรับรถโดยสาร
                            กรุณาติดต่อเจ้าหน้าที่ เพื่อเปลี่ยนแปลงประเภทรถยนต์ให้ถูกต้อง
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <font color="red">
                            *** กรณีไม่มีเลขที่รับแจ้งขึ้น หรือระบบขัดข้อง กรุณาติดต่อ คุณธีร์ดนัย
                            (เอ็ม)
                            092-250-7272<BR />
                            ** จดทะเบียนรถโดยสารใช้เพื่อการพานิชย์ (220)
                            กรุณาติดต่อพนักงานหลังจากบันทึกข้อมูล<BR />
                            * กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนทำการบันทึก มิฉะนั้นข้อมูลจะไม่สมบูรณ์
                        </font>
                    </div>
                </div>
            </div>

            <div class="widget-header widget-header-flat">
                <h4>ข้อมูลประกันภัย (พ.ร.บ.)</h4>
            </div>
            <div class="widget-body mb-2">
                <div class="widget-main">
                    <div class="row g-2">
                        <div class="col-3">
                            <div class="widget-box">
                                <div class="widget-header grad1-yellow" style="height: 37px; text-align: center;">
                                    <h4 style="color: black !important; text-align: center;"><b>ซื้อ พ.ร.บ.</b>
                                        แบบออนไลน์
                                    </h4>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div style="text-align: center; ">
                                            <p class="text-danger">ยืนยันการรับประกันภัยให้กับลูกค้า</p>
                                        </div>
                                        <div style="text-align: center;">
                                            <input type="radio" class="m-0" value="Y" id="SmartPRBY"
                                                onclick="checkSmartPRBOnline(this);" name="checkAddon">
                                            ซื้อ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" class="m-0" value="N" id="SmartPRBN" name="checkAddon"
                                                onclick='checkSmartPRBOnline(this);'> ไม่ซื้อ
                                        </div>
                                        <div style="text-align: center;margin-top: 10px; ">เลือกซื้อเพื่อดำเนินการต่อ
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <label
                                                for=""><?php echo $_SESSION["saka"] != '113' ? "เลขที่กรมธรรม์ (พ.ร.บ.)" : "เลือกชนิด พ.ร.บ."; ?></label>
                                            <div class="d-flex">
                                                <?php if ($_SESSION["saka"] != '113') {
                                                $_saka = substr(date("Y") + 543, 2, 2) . $_SESSION["saka"];
                                                echo '<input type="text" name="ApiTypeCode" id="ApiTypeCode" value="" style="display: none" />';
                                                echo '<input name="p_act1" type="text" id="p_act1" class="w-100" maxlength="5" value="09712" readonly />';
                                                echo '<input name="p_act2" type="text" id="p_act2" class="w-100" maxlength="5" value="'.$_saka.'" readonly>';
                                                echo '<input name="p_act3" type="text" id="p_act3" class="w-100" maxlength="7" value="" />';
                                            } else {
                                                $_saka = substr(date("Y") + 543, 2, 2) . $_SESSION["saka"];
                                                echo '<input type="text" name="ApiTypeCode" id="ApiTypeCode" class="w-100" value="" style="display: none" />';
                                                echo '<input name="p_act1" type="text" id="p_act1" class="w-100" maxlength="5" value="09712" readonly />';
                                                echo '<input name="p_act2" type="text" id="p_act2" class="w-100" maxlength="5" value="'.$_saka.'" readonly>';
                                                echo '<input name="p_act3" type="text" id="p_act3" class="w-100"  maxlength="7" value=""/>';
                                            }?>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <label for="SelectCodeApi">เปลี่ยนประเภท</label>
                                            <select name="SelectCodeApi" id="SelectCodeApi" class="w-100">
                                                <option value="0">----</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-2">
                                        <div class="col-1">
                                            <label for="id_prp">เบี้ยสุทธิ</label>
                                            <select name="id_prp" id="id_prp" class="w-100">
                                                <option value="0" selected>กรุณาเลือกเบี้ย
                                                </option>
                                            </select>
                                            <input type="hidden" name="txtprp1" id="txtprp1" />
                                        </div>
                                        <div class="col-1">
                                            <label for="id_prp">อากร</label>
                                            <input type="text" name="txtstamp1" id="txtstamp1" class="w-100"
                                                value="0.00" readonly />
                                        </div>
                                        <div class="col-1">
                                            <label for="id_prp">ภาษี</label>
                                            <input type="text" name="txttax1" id="txttax1" class="w-100" value="0.00"
                                                readonly />
                                        </div>
                                        <div class="col-1">
                                            <label for="id_prp">เบี้ยรวม</label>
                                            <input type="text" name="txtnet1" id="txtnet1" class="w-100" value="0.00"
                                                readonly="readonly" />
                                        </div>
                                        <div class="col-12">
                                            <font color="red">
                                                กรณี จดทะเบียนเป็นรถรับจ้าง หรือ
                                                รถขนส่งผู้โดยสาร กรุณาติดต่อเจ้าหน้าที่ hotline:
                                                065-385-6130, 092-462-9246 , 081-633-3644
                                            </font>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!---------------- DIV ข้อมูลผู้เอาประกันภัย -------------------------------->
            <div class="widget-header widget-header-flat">
                <h4>ข้อมูลผู้เอาประกันภัย</h4>
            </div>
            <div class="widget-body mb-2">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <span class="text-danger">*ตามกฎหมาย
                                สำนักงานป้องกันและปราบปรามการฟอกเงิน
                                (ปปง.) จำเป็นต้องแสดง เลขบัตรประชาชน / เลขหมายทะเบียนการค้า ตามกฎหมาย
                                สำนักงานป้องกันและปราบปรามการฟอกเงิน (ปปง.) จำเป็นต้องแสดง
                                เลขบัตรประชาชน /
                                เลขหมายทะเบียนการค้า
                            </span>
                        </div>
                        <div class="col-12">
                            <label class="radio-inline">
                                <input name="person" id="person" type="radio" value="1" checked="checked"
                                    onclick='onkeyicard_clear("1");'>
                                บุคคลธรรมดา
                            </label>
                        </div>
                        <div class="col-12">
                            <label class="radio-inline">
                                <input name="person" id="persons" type="radio" value="2"
                                    onclick='onkeyicard_clear("2");'>
                                นิติบุคคล
                            </label>
                        </div>
                        <div class="col-1">
                            <label class="radio-inline"><input name="person" id="person_foreign" type="radio" value="3"
                                    onclick='onkeyicard_clear("3");'>
                                ชาวต่างชาติ
                            </label>
                        </div>
                        <div class="col-8">
                            <span id='GroupIdCardMultiple'>
                                <input name="icard1" type="text" id="icard1" maxlength="1"
                                    onkeyup='onkeyicard("icard2","icard1",event);'
                                    style='width:30px; text-align: center;'>
                                -
                                <input name="icard2" type="text" id="icard2" maxlength="1"
                                    onkeyup='onkeyicard("icard3","icard2",event);'
                                    style='width:30px; text-align: center;'>
                                <input name="icard3" type="text" id="icard3" maxlength="1"
                                    onkeyup='onkeyicard("icard4","icard3",event);'
                                    style='width:30px; text-align: center;'>
                                <input name="icard4" type="text" id="icard4" maxlength="1"
                                    onkeyup='onkeyicard("icard5","icard4",event);'
                                    style='width:30px; text-align: center;'>
                                <input name="icard5" type="text" id="icard5" maxlength="1"
                                    onkeyup='onkeyicard("icard6","icard5",event);'
                                    style='width:30px; text-align: center;'>
                                -
                                <input name="icard6" type="text" id="icard6" maxlength="1"
                                    onkeyup='onkeyicard("icard7","icard6",event);'
                                    style='width:30px; text-align: center;'>
                                <input name="icard7" type="text" id="icard7" maxlength="1"
                                    onkeyup='onkeyicard("icard8","icard7",event);'
                                    style='width:30px; text-align: center;'>
                                <input name="icard8" type="text" id="icard8" maxlength="1"
                                    onkeyup='onkeyicard("icard9","icard8",event);'
                                    style='width:30px; text-align: center;'>
                                <input name="icard9" type="text" id="icard9" maxlength="1"
                                    onkeyup='onkeyicard("icard10","icard9",event);'
                                    style='width:30px; text-align: center;'>
                                <input name="icard10" type="text" id="icard10" maxlength="1"
                                    onkeyup='onkeyicard("icard11","icard10",event);'
                                    style='width:30px; text-align: center;'>
                                -
                                <input name="icard11" type="text" id="icard11" maxlength="1"
                                    onkeyup='onkeyicard("icard12","icard11",event);'
                                    style='width:30px; text-align: center;'>
                                <input name="icard12" type="text" id="icard12" maxlength="1"
                                    onkeyup='onkeyicard("icard13","icard12",event);'
                                    style='width:30px; text-align: center;'>
                                -
                                <input name="icard13" type="text" id="icard13" maxlength="1"
                                    onkeyup='onkeyicard("","icard13",event);' style='width:30px; text-align: center;'>
                            </span>
                            <span id='GroupIdCardSingle' style='display:none;'>
                                <input name="icard" type="text" id="icard" maxlength="13" />
                            </span>
                            <font color="#FF0000" id="icardTEXT" name="icardTEXT"><b> *
                                    (กรุณากรอกเฉพาะตัวเลข 13 หลัก)</b></font>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-1">
                            <label for="">คำนำหน้า</label>
                            <select id="title" name="title" class="w-100" onchange="customerLastName();">
                                <option value="0" selected="selected">กรุณาเลือก</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label id="show_name_title" for="show_name_title" for="">ชื่อ</label>
                            <div id='show_name_text' class="d-flex">
                                <input type='text' name='TitleCustomer' id='TitleCustomer' value=''
                                    style='width:70px;display:none;' readonly>
                                <input type="text" name="name_name" id="name_name" maxlength="60" class="w-100">
                            </div>
                        </div>
                        <div class="col-2" id="show_last_text">
                            <label id="show_last_title" for="show_last_title" for="">นามสกุล</label>
                            <div class="d-flex">
                                <input type='text' name='ByCustomer' id='ByCustomer' value=''
                                    style='width:70px;text-align:center;display:none;' readonly>
                                <input type="text" name="last" id="last" maxlength="40" class="w-100">
                            </div>
                        </div>
                        <div class="col-1">
                            <label for="vocation" for="">อาชีพ/ธุรกิจ</label>
                            <input type="text" name="vocation" id="vocation" value="" class="w-100" />
                        </div>
                        <div class="col-1">
                            <label for="vocation" for="">เบอร์โทรศัพท์</label>
                            <input type="text" name="tel_home" id="tel_home" maxlength="20" class="w-100" />
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-1">
                            <label for="add" for="">บ้านเลขที่</label>
                            <input type="text" id="add" maxlength="15" name="add" class="w-100"
                                onkeyup='number_length("add","add_text","15");'>
                        </div>
                        <div class="col-1">
                            <label for="group" for="">หมู่</label>
                            <input type="text" name="group" id="group" maxlength="5" class="w-100"
                                onkeyup='number_length("group","group_text","5");'>
                        </div>
                        <div class="col-1">
                            <label for="town" for="">อาคาร/หมู่บ้าน</label>
                            <input type="text" name="town" id="town" maxlength="50" class="w-100"
                                onkeyup='number_length("town","town_text","50");'>
                        </div>
                        <div class="col-1">
                            <label for="lane" for="">ซอย</label>
                            <input type="text" name="lane" id="lane" maxlength="25" class="w-100"
                                onkeyup='number_length("lane","lane_text","25");'>
                        </div>
                        <div class="col-1">
                            <label for="road" for="">ถนน</label>
                            <input type="text" id="road" maxlength="25" name="road" value="-" class="w-100"
                                onkeyup='number_length("road","road_text","25");'>
                        </div>
                        <div class="col-1">
                            <label for="province">จังหวัด</label>
                            <span id="provinceDiv">
                                <select name="province" id="province" class="w-100">
                                </select>
                            </span>
                        </div>
                        <div class="col-1">
                            <label for="amphur">อำเภอ</label>
                            <span id="amphurDiv">
                                <select name="amphur" id="amphur" class="w-100">
                                    <option value="0">กรุณาเลือก</option>
                                </select>
                            </span>
                        </div>
                        <div class="col-1">
                            <label for="tumbon">ตำบล</label>
                            <span id="tumbonDiv">
                                <select name="tumbon" id="tumbon" class="w-100">
                                    <option value="0">กรุณาเลือก</option>
                                </select>
                            </span>
                        </div>
                        <div class="col-1">
                            <label for="id_post">รหัสไปรษณีย์</label>
                            <span id="id_postDiv">
                                <select name="id_post" id="id_post" class="w-100">
                                    <option value="0">กรุณาเลือก</option>
                                </select>
                            </span>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="send_add_N">ที่อยู่จัดส่งเอกสาร</label>
                            <input type="radio" name="status_send_add" id="send_add_N" value="N" checked
                                onclick='js_showsendadd();'>&nbsp;<span>ที่อยู่ตามผู้เอาประกัน</span>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="status_send_add" id="send_add_Y" value="Y"
                                onclick='js_showsendadd();'>&nbsp;<span>ระบุที่อยู่จัดส่งเอกสาร</span>
                        </div>
                        <div class="col-12">
                            <div class="row p-0 m-0" id='show_addsend' style='display:none;border: 1px solid;'>
                                <div class="col-12 m-0 p-0 mb-2" style='background-color:#5E78DF !important;'>
                                    <h4>&nbsp;ข้อมูลที่อยู่จัดส่งเอกสาร</h4>
                                </div>
                                <div class='col-1'>
                                    <label for='send_add'>บ้านเลขที่</label>
                                    <input type="text" name="send_add" id="send_add" class='w-100'>
                                </div>
                                <div class='col-1'>
                                    <label for='send_group'>หมู่</label>
                                    <input type="text" name="send_group" id="send_group" class='w-100'>
                                </div>
                                <div class='col-1'>
                                    <div for='send_town'>อาคาร/หมู่บ้าน</div>
                                    <input type="text" name="send_town" id="send_town" class='w-100'>
                                </div>
                                <div class='col-1'>
                                    <label for='send_lane'>ซอย</label>
                                    <input type="text" name="send_lane" id="send_lane" class='w-100'>
                                </div>

                                <div class='col-1'>
                                    <label for='send_road'>ถนน</label>
                                    <input type="text" name="send_road" id="send_road" class='w-100'>
                                </div>
                                <div class='col-1'>
                                    <label for='send_province'>จังหวัด</label>
                                    <select name="send_province" id="send_province" class='w-100'
                                        onchange='js_proshow("AMPHUR","province","send_province","send_amphur");'>
                                        <option value=''>--กรุณาเลือก--</option>
                                        <?php
                                        $send_province_sql="SELECT * FROM tb_province";
                                        $send_province_query=$_contextMitSu->query($send_province_sql)->fetchAll(2);
                                        foreach($send_province_query As $send_province_array)
                                        { ?>
                                        <option value='<?=$send_province_array['id']?>'>
                                            <?=$send_province_array['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class='col-1'>
                                    <label for='send_amphur'>อำเภอ</label>
                                    <select name="send_amphur" id="send_amphur" class='w-100'
                                        onchange='js_proshow("TUMBON","amphur","send_amphur","send_tumbon");'>
                                        <option value=''>--กรุณาเลือก--</option>
                                    </select>
                                </div>
                                <div class='col-1'>
                                    <label class='send_tumbon'>ตำบล</label>
                                    <select name="send_tumbon" id="send_tumbon" class='w-100'
                                        onchange='js_proshow("POST","tumbon","send_tumbon","send_post")' ;>
                                        <option value=''>--กรุณาเลือก--</option>
                                    </select>
                                </div>
                                <div class='col-1'>
                                    <label class='send_post'>รหัสไปรษณีย์</label>
                                    <select name="send_post" id="send_post" class='w-100'>
                                        <option value=''>--กรุณาเลือก--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" style="display:none;">
                            <label for="id_post">ที่อยู่ในการออกใบเสร็จ</label>
                            <input id="address_chk1" name="address_chk" type="radio" value="2" checked="checked" />
                            &nbsp;ออกใบเสร็จในนามลูกค้า

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input id="address_chk2" name="address_chk" type="radio" value="1" />
                            &nbsp;ออกใบเสร็จในนามบริษัท <font color="#FF0000" id="user_ScomC" style="display:none;">
                                (
                                <?php echo  $_SESSION["strUser"] . ' : ' . $_SESSION["strName"] . ' - ' . $_SESSION["location"]; ?>
                                )</font>
                        </div>
                        <div class="col-12">
                            <div
                                style="background: url(images/email_new1.jpg);background-repeat: no-repeat;background-size: 603px 156px;height: 156px;">
                                <div style="padding-left:10px; padding-top:20.4px;">
                                    <input placeholder="กรอกอีเมล์" name="email" type="text" id="email" size="7" />
                                    <font color="#FF0000"><b> * </b></font>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!---------------- END DIV ข้อมูลผู้เอาประกันภัย --------------------------------->
        </div>

        <!---------------- DIV modalแจ้งเตือน ------------------------------------>
        <div class="modal-position-noti" id="modalNoti" style="display: none;">
            <div class="widget-box noti-width">
                <div class="widget-header widget-header-flat">
                    <h4>แจ้งเตือน</h4>
                </div>
                <div class="widget-body noti-height">
                    <br><br>
                    <p>ระบบกำลังบันทึก</p>
                    <p>กรุณา <text style="color:red;">อย่าปิด</text> หรือ เปลี่ยนหน้าต่าง </p>
                    <p>จนกว่าระบบจะเสร็จสิ้น</p>
                    <img src="https://media1.tenor.com/images/57b62c1192938f43f61a45817166c4e2/tenor.gif?itemid=15460501"
                        alt="" style="width: 9rem;">
                </div>
            </div>
        </div>

        <div class="modal-position-noti" id="modalPolicy" style="display: none;">
            <div class="widget-box noti-width-policy">
                <div class="widget-header widget-header-flat">
                    <h4>Policy</h4>
                    <button type="button" id="closePolicy" style="font-size: 2rem !important; margin: 5px 5px 0 0;"
                        onclick="closeModalPolicy()">&times;</button>
                </div>
                <div class="widget-body noti-height-policy p-3">
                    <div class="row">
                        <div class="col-12 p-0">
                            <h4 class="text-center text-dark">เพื่อปฏิบัติตาม พรบ. ข้อมูลดังนี้</h4>
                            <!-- <div class="text-left p-2">
                                &nbsp;&nbsp;&nbsp;&nbsp;ข้าพเจ้าในฐานะผู้ขอเอาประกันภัยและตัวแทนของผู้ขอเอาประกันภัยรายอื่น
                                (“ผู้เอาประกันภัย”) ยินยอมให้บริษัทฯ........................จัดเก็บ ใช้
                                และเปิดเผยข้อเท็จจริงเกี่ยวกับสุขภาพและข้อมูลของผู้เอาประกันภัยต่อสำนักงานคณะกรรมการกำกับและส่งเสริมการประกอบธุรกิจประกันภัย
                                เพื่อประโยชน์ในการกำกับดูแลธุรกิจประกันภัย และ
                                ยินยอมให้บริษัทฯใช้ข้อมูลติดต่อผู้เอาประกันภัย
                                ผ่านช่องทางต่างๆที่ข้าพเจ้าได้ให้ข้อมูลไว้
                                เพื่อเสนอสิทธิประโยชน์ ผลิตภัณฑ์ประกันภัยหรือบริการต่างๆ
                                รวมถึงแจ้งข่าวสารของบริษัทและ/หรือบริษัทคู่ค้าทางธุรกิจที่จะมีขึ้นในอนาคต<br><br>
                            </div> -->
                        </div>
                        <div class="col-12 p-0 mt-2">
                            <label class="text-left p-2" for="TelNo1">เบอร์ผู้เอาประกันภัย</label>
                            <div class="d-flex p-2 align-items-center">
                                <input name="TelNo1" type="text" id="TelNo1" maxlength="1"
                                    onkeyup='getDataMobileNo("TelNo2","TelNo1",event);' class="input-inner"
                                    style="border-radius: 5px !important;">
                                <input name="TelNo2" type="text" id="TelNo2" maxlength="1"
                                    onkeyup='getDataMobileNo("TelNo3","TelNo2",event);' class="input-inner"
                                    style="border-radius: 5px !important;">
                                <input name="TelNo3" type="text" id="TelNo3" maxlength="1"
                                    onkeyup='getDataMobileNo("TelNo4","TelNo3",event);' class="input-inner"
                                    style="border-radius: 5px !important;">
                                -
                                <input name="TelNo4" type="text" id="TelNo4" maxlength="1"
                                    onkeyup='getDataMobileNo("TelNo5","TelNo4",event);' class="input-inner"
                                    style="border-radius: 5px !important;">
                                <input name="TelNo5" type="text" id="TelNo5" maxlength="1"
                                    onkeyup='getDataMobileNo("TelNo6","TelNo5",event);' class="input-inner"
                                    style="border-radius: 5px !important;">
                                <input name="TelNo6" type="text" id="TelNo6" maxlength="1"
                                    onkeyup='getDataMobileNo("TelNo7","TelNo6",event);' class="input-inner"
                                    style="border-radius: 5px !important;">
                                <input name="TelNo7" type="text" id="TelNo7" maxlength="1"
                                    onkeyup='getDataMobileNo("TelNo8","TelNo7",event);' class="input-inner"
                                    style="border-radius: 5px !important;">
                                <input name="TelNo8" type="text" id="TelNo8" maxlength="1"
                                    onkeyup='getDataMobileNo("TelNo9","TelNo8",event);' class="input-inner"
                                    style="border-radius: 5px !important;">
                                <input name="TelNo9" type="text" id="TelNo9" maxlength="1"
                                    onkeyup='getDataMobileNo("TelNo10","TelNo9",event);' class="input-inner"
                                    style="border-radius: 5px !important;">
                                <input name="TelNo10" type="text" id="TelNo10" maxlength="1"
                                    onkeyup='getDataMobileNo("","TelNo10",event);' class="input-inner"
                                    style="border-radius: 5px !important;">
                                <input placeholder="กรอกเบอร์มือถือ" id="tel_mobi" type="hidden" size="7" maxlength="13"
                                    name="tel_mobi" />
                                <font color="#FF0000"><b> * </b></font>
                            </div>
                        </div>
                        <div class="col-12 mt-2 p-0">
                            <div class="text-left p-2">
                                <input id="checkPolicy" name="checkPolicy" type="checkbox" value="accept" />
                                &nbsp;ยอมรับข้อกำหนดและเงื่อนไขการใช้บริการของบริษัท
                            </div>
                        </div>
                        <div class="col-12 mt-2 p-0">
                            <div class="text-right p-2">
                                <button type="button" id="saveIHereToo" class="btn btn-primary"
                                    style="font-size: 1rem !important;width: 150px;"
                                    onclick="handleSaveService()">บันทึกข้อมูล</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---------------- END DIV modalแจ้งเตือน -------------------------------->

        <button class="btn btn-large btn-primary" type="button" id="Savenaja" name="Savenaja" onclick='savenaja();'>
            <i class="icon-upload"></i>แจ้งประกันภัยรถยนต์
        </button>
        <div style='display:none;'>
            <button class="btn btn-large btn-primary" type="button" id="SaveInsurance" name="SaveInsurance"
                style='display:none;'><i class="icon-upload"></i>แจ้งประกันภัยรถยนต์
            </button>
        </div>
        <button class="btn btn-large btn-warning" type="reset" name="BcloseIn" id="BcloseIn">
            <i class="icon-refresh"></i>เริ่มใหม่
        </button>
    </form>
</div>

<script>
document.getElementById('person').click();
//start document
$('#SelectCodeApi').attr('readonly', true);
var SmartOnlineStatus = 0;
if (localStorage.getItem('SakaDear') == '113') {
    SmartOnlineStatus = 1;
}
var _numberPRB = '';
_numberPRB = $('#p_act3').val();

$('#p_act3').click(function() {
    if (SmartOnlineStatus == 0) {
        Swal.fire(
            'กรุณาเลือกประเภทการพิมพ์ พ.ร.บ',
            'เลือกพิมพ์ Smart พ.ร.บ. กด YES หรือ NO',
            'question'
        );
    }
});

function loadActOnCarType() {
    $.ajax({
        type: "POST",
        url: "./services/VehicleType.controller.php",
        data: {
            Controller: 'LoadActNameKey',
            CarType: $("#cartype").val()
        },
        dataType: "JSON",
        success: function(response) {
            const info = response;
            const _selectPRB = $("#SelectCodeApi");
            _selectPRB.attr('readonly', false);
            _selectPRB.empty();
            _selectPRB.append(`<option value='0'>--กรุณาเลือก--</option>`);
            for (let y = 0; y < info.length; y++) {
                if (y == 0) {
                    _selectPRB.append(
                        `<option value='${info[y].Id}' selected>${info[y].IdAct} ${info[y].Name}</option>`
                    );
                } else {
                    _selectPRB.append(
                        `<option value='${info[y].Id}'>${info[y].IdAct} ${info[y].Name}</option>`
                    );
                }
            }
            loadActStart();
        },
        error: function(err) {
            alert(err);
        }
    });
}

function checkSmartPRBOnline(btn) {
    if ($('#cartype').val() == "0") {
        alert('กรุณาเลือกประเภทการใช้งาน');
        $('#SmartPRBY').prop('checked', false);
        $('#SmartPRBN').prop('checked', false);
        $('#cartype').focus();
        return false;
    }

    const _id = btn.id;
    if (_id == 'SmartPRBY') {
        $('#SelectCodeApi').attr('readonly', false);
        loadActOnCarType();
        _numberPRB = $('#p_act3').val();
        $('#p_act3').val('SmartOn');
        $('#p_act3').attr('readonly', true);
        SmartOnlineStatus = 1;
        Swal.fire({
            type: 'success',
            title: 'โปรดดำเนินการต่อ',
            showConfirmButton: true
        });
    } else {
        loadDefaultAct();
        const _value = $('#p_act3').val();

        if (_numberPRB == '') {
            $('#p_act3').val('');
        } else {
            $('#p_act3').val(_numberPRB);
        }

        $('#p_act3').attr('readonly', false);

        SmartOnlineStatus = 2;
        Swal.fire({
            type: 'success',
            title: 'รับทราบ โปรดดำเนินการต่อ',
            showConfirmButton: true
        }).then(() => {
            $('#p_act3').focus();
        });
    }
    console.log(SmartOnlineStatus);
}

function loadActStart() {
    $.ajax({
        type: "POST",
        url: "./services/VehicleType.controller.php",
        data: {
            Controller: 'LoadDefaultAct',
            CarTypeID: $('#cartype').val()
        },
        dataType: "JSON",
        success: (response) => {
            const res = response;
            $('#ApiTypeCode').val(`${res.ApiTypeCode}`);
            $('#id_prp').empty();
            $('#id_prp').append(`<option value='${res.Pre}'>${res.Pre}</option>`);
            $('#txtstamp1').val(res.Stamp);
            $('#txttax1').val(res.Vat);
            $('#txtnet1').val(res.Net);
        },
        error: (err) => {
            alert(err);
        }
    });
}

function loadDefaultAct() {
    $.ajax({
        type: "POST",
        url: "./services/VehicleType.controller.php",
        data: {
            Controller: 'LoadDefaultAct',
            CarTypeID: $('#cartype').val()
        },
        dataType: "JSON",
        success: (response) => {
            const res = response;
            $('#SelectCodeApi').empty();
            $('#SelectCodeApi').append(`<option value='0'>--</option>`);
            $('#SelectCodeApi').attr('readonly', true);
            $('#ApiTypeCode').val(`${res.ApiTypeCode}`);
            $('#id_prp').empty();
            $('#id_prp').append(`<option value='${res.Pre}'>${res.Pre}</option>`);
            $('#txtstamp1').val(res.Stamp);
            $('#txttax1').val(res.Vat);
            $('#txtnet1').val(res.Net);
        },
        error: (err) => {
            alert(err);
        }
    });
}
</script>