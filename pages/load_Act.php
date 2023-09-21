<?php
require("check-ses.php");
require("../inc/connectdbs.pdo.php");
header('Content-Type: text/html; charset=utf-8');

/************************* dependency injection **********************/
echo "<script> localStorage.setItem('SessionName','$_SESSION[name]'); 
localStorage.setItem('SakaDear','$_SESSION[saka]');
</script>";
/******************************************************************* */

?>

<!--------- Production ------------>
<!-- <script src="js/js_Insurance_Act_new.min.js" type="text/javascript"></script> -->
<!--------- Production ------------>

<!--------- Develop --------------->
<script src="js/js_Insurance_NewAct_2021.js" type="text/javascript"></script>
<!--------- Develop --------------->

<style>
.loggo-new {
    position: absolute;
    text-align: right;
    margin-left: 22rem;
    margin-top: -6rem;
}

.grad1-yellow {
    height: 200px;
    background-image: linear-gradient(to right, rgba(255, 192, 21), rgba(255, 230, 21));
    /* Standard syntax (must be last) */
}

.height-smartPRB {
    height: 133px;
}

@media only screen and (max-width: 1500px) {
    .height-smartPRB {
        height: 173px;
    }
}

@media only screen and (max-width: 1600px) {
    .height-smartPRB {
        height: 173px;
    }
}

@media only screen and (max-width: 1700px) {
    .height-smartPRB {
        height: 173px;
    }
}

@media only screen and (max-width: 1800px) {
    .height-smartPRB {
        height: 173px;
    }
}

@media only screen and (max-width: 1900px) {
    .height-smartPRB {
        height: 173px;
    }
}

.dsp-flx {
    display: flex;
    justify-content: center;
    align-items: center;
}

.close-custom {
    color: #000;
    font-weight: bold;
    font-size: 1.5rem;
    position: absolute;
    margin-top: 7px;
    margin-left: -16px;
    cursor: pointer;
}

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

#Insurance .chosen-container-single .chosen-single {
    line-height: 32px;
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
.textNet {
    background: #accad9;
    padding: 10px;
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
    width: 60%;
}
</style>
<!-- <script type="text/javascript" src="js/jquery-1.8.3.js"></script> -->
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<link rel="stylesheet" href="./css/row-col.css">
<script type="text/javascript">
function checkText() {
    var elem = document.getElementById('car_body').value;
    if (!elem.match(/^([a-z0-9\_])+$/i)) {
        Swal.fire({
            type: 'error',
            text: 'เลขตัวถัง กรอกได้เฉพาะ A-Z, 0-9',
            timer: 3000
        });
        document.getElementById('car_body').value = "";
    }
}

function checkText2() {
    var elem = document.getElementById('n_motor').value;
    if (!elem.match(/^([a-z0-9\_])+$/i)) {

        Swal.fire({
            type: 'error',
            text: 'เลขเครื่อง กรอกได้เฉพาะ A-Z, 0-9',
            timer: 3000
        });
        document.getElementById('n_motor').value = "";
    }

}

function checkFixNumber(btn) {
    const _value = btn.value;
    if (!_value.match(/^([0-9\_])+$/i)) {
        Swal.fire({
            type: 'error',
            text: 'กรอกได้เฉพาะ ตัวเลขเท่านั้น',
            timer: 3000
        });
        $(`#${btn.id}`).focus();
    }
}
</script>

<form name="Insurance" id="Insurance">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-header widget-header-flat">
                    <h4>ข้อมูลทั่วไป</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row g-2">
                            <input name="ty_prot" type="hidden" id="ty_prot" value="<?php print $ty_prot; ?>" />
                            <input name="send_date" type="hidden" id="send_date" size="40" maxlength="10"
                                readonly="true" value="<?php echo date("Y-m-d H:i"); ?>" />
                            <input name="xuser" type="hidden" id="xuser" value="<?php echo $_SESSION["strUser"]; ?>" />
                            <input name="xUserName" type="hidden" id="xUserName"
                                value="<?php echo $_SESSION["strPass"]; ?>" />
                            <input name="name_inform" type="hidden" id="name_inform" size="40" maxlength="40"
                                readonly="true" value="<?php echo $_SESSION["strName"]; ?>" />
                            <input type="hidden" name="doc_type" id="doc_type" value="1" />
                            <div class="col-12">
                                <div class="alert alert-error"><i class="icon-warning-sign"></i> การค้นหาต้องลบข้อความแล้วพิมพ์ใหม่ทุกครั้ง</div>
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
                                <label for="start_date">วันที่คุ้มครอง</label>
                                <input name="start_date" type="text" id="start_date" class="w-100"
                                    value="<?php echo date("d/m/Y"); ?>" onchange='blockBackInsuranceDate(this);'
                                    readonly />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-1">
                                <label for="cartype">ประเภทการใช้</label>
                                <span id="cartypeDiv">
                                    <select name="cartype" id="cartype" class="w-100" onchange="loadDefaultActFirst();">
                                        <option value="0">กรุณาเลือก</option>
                                    </select>
                                </span>
                            </div>
                            <div class="col-2">
                                <label for="car_id">ลักษณะใช้งาน</label>
                                <span id="car_idDiv">
                                    <select name="car_id" id="car_id" class="w-100" onchange="js_seat();">
                                        <option value="0">กรุณาเลือก</option>
                                    </select>
                                </span>
                            </div>
                            <div class="col-1">
                                <label for="cat_car">ประเภทรถ</label>
                                <span id="cat_carDiv">
                                    <select name="cat_car" id="cat_car" class="w-100" onchange="js_seat();">
                                        <option value="0">กรุณาเลือก</option>
                                    </select>
                                </span>
                            </div>
                            <div class="col-2">
                                <label for="br_car">ยี่ห้อรถ</label>
                                <span id="br_carDiv">
                                    <select name="br_car" id="br_car" class="w-100" onchange="js_seat();">
                                        <option value="0">กรุณาเลือก</option>
                                    </select>
                                </span>
                            </div>
                            <div class="col-1">
                                <label for="mo_car">รุ่นรถ</label>
                                <span id="mo_carDiv">
                                    <select name="mo_car" id="mo_car" class="w-100">
                                        <option value="0">กรุณาเลือก</option>
                                    </select>
                                </span>
                            </div>
                            <div class="col-2" style="margin-top: 17px;" id="showNetText">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-1">
                                <label for="car_cc">จำนวน ซี.ซี.</label>
                                <select name="car_cc" id="car_cc" class="w-100">
                                    <option value="0" selected="selected">กรุณาเลือก</option>
                                </select>
                            </div>
                            <div class="col-1">
                                <label for="car_wgt">น้ำหนัก</label>
                                <select name="car_wgt" id="car_wgt" class="w-100">
                                    <option value="0" selected="selected">กรุณาเลือก</option>
                                </select>
                            </div>
                            <div class="col-1">
                                <label for="car_seat">จำนวนที่นั่ง</label>
                                <select name="car_seat" id="car_seat" class="w-100">
                                    <option value="0" selected="selected">กรุณาเลือก</option>
                                </select>
                            </div>
                            <div class="col-1">
                                <label for="gear">เกียร์</label>
                                <select name="gear" id="gear" class="w-100">
                                    <option value="0" selected="selected">กรุณาเลือก</option>
                                    <option value="A">อัตโนมัติ</option>
                                    <option value="M">ธรรมดา</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="">
                                    <div class="d-flex">
                                        ทะเบียนรถ &nbsp;&nbsp;
                                        <input type="checkbox" class="m-0" name="chkred" id="chkred"
                                            onclick="redTabern(this)" />
                                        <label class="text-danger m-0" for="chkred">*ป้ายแดง คลิก</label>
                                    </div>
                                </label>
                                <div class='d-flex'>
                                    <span>
                                        <input name="car_regis1" type="text" id="car_regis1" value="" size="10"
                                            maxlength="1" class="w-100"
                                            onkeyup='onkey_car_regis("car_regis2","car_regis1",event);'>
                                    </span>
                                    <span>
                                        <input name="car_regis2" type="text" id="car_regis2" value="" size="10"
                                            maxlength="1" class="w-100"
                                            onkeyup='onkey_car_regis("car_regis3","car_regis2",event);'>
                                    </span>
                                    <span>
                                        <input name="car_regis3" type="text" id="car_regis3" value="" size="10"
                                            maxlength="1" class="w-100"
                                            onkeyup='onkey_car_regis("car_regis4","car_regis3",event);'>
                                    </span>
                                    <span>-</span>
                                    <span>
                                        <input name="car_regis4" type="text" id="car_regis4" value="" size="10"
                                            maxlength="1" class="w-100"
                                            onkeyup='onkey_car_regis("car_regis5","car_regis4",event);'>
                                    </span>
                                    <span>
                                        <input name="car_regis5" type="text" id="car_regis5" value="" size="10"
                                            maxlength="1" class="w-100"
                                            onkeyup='onkey_car_regis("car_regis6","car_regis5",event);'>
                                    </span>
                                    <span>
                                        <input name="car_regis6" type="text" id="car_regis6" value="" size="10"
                                            maxlength="1" class="w-100"
                                            onkeyup='onkey_car_regis("car_regis7","car_regis6",event);'>
                                    </span>
                                    <span>
                                        <input name="car_regis7" type="text" id="car_regis7" value="" size="10"
                                            maxlength="1" class="w-100"
                                            onkeyup='onkey_car_regis("","car_regis7",event);'>
                                    </span>

                                    <input name="car_regis" type="hidden" id="car_regis" value="" size="10"
                                        maxlength="8" />
                                    <input name="car_regis_text" type="hidden" id="car_regis_text" value="-" size="10"
                                        maxlength="8" />
                                </div>
                            </div>
                            <div class="col-1">
                                <label for="car_regis_pro">จังหวัด</label>
                                <select class="w-100" name='car_regis_pro' id='car_regis_pro'></select>
                            </div>
                            <div class="col-1">
                                <label for="regis_date">ปีจดทะเบียน</label>
                                <input type="hidden" name="Dyy" id="Dyy" value="<?php echo date('Y') ?>" readonly />
                                <select name="regis_date" id="regis_date" class="w-100"></select>
                            </div>
                            <div class="col-1">
                                <label for="car_color">สีรถ</label>
                                <select name="car_color" id="car_color" class="w-100">
                                    <option value="0">ไม่ระบุ</option>
                                    <option value="เทา"> เทา </option>
                                    <option value="เขียว"> เขียว </option>
                                    <option value="น้ำเงิน"> น้ำเงิน </option>
                                    <option value="แดง"> แดง </option>
                                    <option value="ขาว">ขาว </option>
                                    <option value="น้ำตาล"> น้ำตาล </option>
                                    <option value="ดำ"> ดำ </option>
                                    <option value="ฟ้า"> ฟ้า </option>
                                    <option value="ส้ม">ส้ม</option>
                                    <option value="บรอนซ์">บรอนซ์</option>
                                    <option value="บรอนซ์เงิน">บรอนซ์เงิน</option>
                                    <option value="บรอนซ์ทอง">บรอนซ์ทอง</option>
                                    <option value="เหลืองดำ">เหลืองดำ</option>
                                    <option value="ส้มดำ">ส้มดำ</option>
                                    <option value="เหลือง">เหลือง</option>
                                    <option value="ขาวแดง">ขาวแดง</option>
                                    <option value="ขาวน้ำเงิน">ขาวน้ำเงิน</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-2">
                                <label for="car_body">เลขตัวถัง
                                    <font color="#FF0000"><b> * ระบุเลขตัวถัง</b></font>
                                </label>
                                <input class="w-100" name="car_body" type="text" id="car_body"
                                    style="text-transform:uppercase;" onblur="checkText();" />
                            </div>
                            <div class="col-2">
                                <label for="n_motor">เลขเครื่อง
                                    <font color="#FF0000"><b> * ระบุเลขเครื่องยนต์</b></font>
                                </label>
                                <input class="w-100" name="n_motor" type="text" id="n_motor"
                                    style="text-transform:uppercase;" onblur="checkText2();" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="width: 100%; display: flex;">
        <div class="widget-box ">
            <!-- size-PRB -->
            <div class="widget-header widget-header-flat">
                <h4>ข้อมูลประกันภัย (พ.ร.บ.)</h4>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row g-2">
                        <div class="col-3">
                            <div class="widget-box">
                                <div class="widget-header grad1-yellow" style="height: 37px; text-align: center;">
                                    <h4 style="text-align: center;">
                                        <b style="text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;color: red;">โปรดรับชำระเบี้ยก่อนดำเนินการ</b>
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
                                            ดำเนินการต่อ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="radio" class="m-0" value="N" id="SmartPRBN" name="checkAddon"
                                                onclick='checkSmartPRBOnline(this);'> ไม่ดำเนินการต่อ
                                        </div>
                                        <div style="text-align: center;margin-top: 10px; ">
                                            เลือกซื้อเพื่อดำเนินการต่อ
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
        </div>
    </div>
    <!---------------- DIV modalแจ้งเตือน ------------------------------------>

    <div class="modal-position-noti" id="modalNoti" style="display: none;">
        <div class="widget-box noti-width">
            <div class="widget-header widget-header-flat">
                <h4>แจ้งเตือน</h4>
                <!-- <span class="close-custom" onclick="closeModal()">x</span> -->
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
    <!---------------- END DIV modalแจ้งเตือน -------------------------------->

    <div class="widget-box">
        <div class="widget-header widget-header-flat">
            <h4>ข้อมูลผู้เอาประกันภัย</h4>
        </div>
        <div class="widget-body">
            <div class="widget-main">
                <div class="row g-2">
                    <div class="col-12">
                        <p class="m-0">ตามกฎหมาย สำนักงานป้องกันและปราบปรามการฟอกเงิน (ปปง.) จำเป็นต้องแสดง
                            เลขบัตรประชาชน /
                            เลขหมายทะเบียนการค้า <img src="images/New_icon.gif" width="25" height="9" /></p>
                    </div>
                    <div class="col-12">
                        <label class="radio-inline">
                            <input name="person" id="person" type="radio" value="1" checked="checked"
                                onclick='onkeyicard_clear("1");' />
                            บุคคลธรรมดา</label>
                    </div>
                    <div class="col-1">
                        <label class="radio-inline">
                            <input name="person" id="persons" type="radio" value="2" onclick='onkeyicard_clear("2");' />
                            นิติบุคคล</label>
                    </div>
                    <div class="col-8">
                        <span id='GroupIdCardMultiple'>
                            <input name="icard1" type="text" id="icard1" maxlength="1"
                                onkeyup='onkeyicard("icard2","icard1",event);' style='width:30px; text-align: center;'>
                            -
                            <input name="icard2" type="text" id="icard2" maxlength="1"
                                onkeyup='onkeyicard("icard3","icard2",event);' style='width:30px; text-align: center;'>
                            <input name="icard3" type="text" id="icard3" maxlength="1"
                                onkeyup='onkeyicard("icard4","icard3",event);' style='width:30px; text-align: center;'>
                            <input name="icard4" type="text" id="icard4" maxlength="1"
                                onkeyup='onkeyicard("icard5","icard4",event);' style='width:30px; text-align: center;'>
                            <input name="icard5" type="text" id="icard5" maxlength="1"
                                onkeyup='onkeyicard("icard6","icard5",event);' style='width:30px; text-align: center;'>
                            -
                            <input name="icard6" type="text" id="icard6" maxlength="1"
                                onkeyup='onkeyicard("icard7","icard6",event);' style='width:30px; text-align: center;'>
                            <input name="icard7" type="text" id="icard7" maxlength="1"
                                onkeyup='onkeyicard("icard8","icard7",event);' style='width:30px; text-align: center;'>
                            <input name="icard8" type="text" id="icard8" maxlength="1"
                                onkeyup='onkeyicard("icard9","icard8",event);' style='width:30px; text-align: center;'>
                            <input name="icard9" type="text" id="icard9" maxlength="1"
                                onkeyup='onkeyicard("icard10","icard9",event);' style='width:30px; text-align: center;'>
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
                        <label for="tel_home" for="">เบอร์โทรศัพท์บ้าน</label>
                        <input type="text" name="tel_home" id="tel_home" class="w-100" />
                    </div>
                    <div class="col-1">
                        <label for="tel_home" for="">เบอร์มือถือลูกค้า</label>
                        <input type="text" name="tel_mobi" id="tel_mobi" class="w-100" />
                    </div>
                    <div class="col-2">
                        <label for="tel_home" for="">E - mail ลูกค้า</label>
                        <input type="text" name="email" id="email" class="w-100" />
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-1">
                        <label for="add" for="">บ้านเลขที่</label>
                        <input type="text" id="add" name="add" class="w-100" />
                    </div>
                    <div class="col-1">
                        <label for="group" for="">หมู่</label>
                        <input type="text" name="group" id="group" class="w-100">
                    </div>
                    <div class="col-1">
                        <label for="town" for="">อาคาร/หมู่บ้าน</label>
                        <input type="text" name="town" id="town" class="w-100">
                    </div>
                    <div class="col-1">
                        <label for="lane" for="">ซอย</label>
                        <input type="text" name="lane" id="lane" class="w-100">
                    </div>
                    <div class="col-1">
                        <label for="lane" for="">ถนน</label>
                        <input type="text" id="road" name="road" class="w-100" />
                    </div>
                    <div class="col-1">
                        <label for="province" for="">จังหวัด</label>
                        <span id="provinceDiv"><select name="province" id="province" class="w-100"></select></span>
                    </div>
                    <div class="col-1">
                        <label for="amphur" for="">อำเภอ</label>
                        <span id="amphurDiv">
                            <select name="amphur" id="amphur" class="w-100">
                                <option value="0">กรุณาเลือก</option>
                            </select>
                        </span>
                    </div>
                    <div class="col-1">
                        <label for="tumbon" for="">ตำบล</label>
                        <span id="tumbonDiv">
                            <select name="tumbon" id="tumbon" class="w-100">
                                <option value="0">กรุณาเลือก</option>
                            </select>
                        </span>
                    </div>
                    <div class="col-1">
                        <label for="id_post" for="">รหัสไปรษณีย์</label>
                        <span id="id_postDiv">
                            <select name="id_post" id="id_post" class="w-100">
                                <option value="0">กรุณาเลือก</option>
                            </select>
                        </span>
                    </div>
                    <div class="col-12">
                        <p class="text-danger">
                            * กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนทำการบันทึก มิฉะนั้นข้อมูลจะไม่สมบูรณ์
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- boom disabled  -->
    <button class="btn btn-large btn-primary" type="button" id="SaveInsurance" name="SaveInsurance">
        <i class="icon-upload"></i>แจ้งประกันภัยรถยนต์</button>
    <button class="btn btn-large btn-warning" type="reset" name="BcloseIn" id="BcloseIn"><i
            class="icon-refresh"></i>เริ่มใหม่</button>
</form>
</div>

<script language="javascript">

onkeyicard_clear("1");

$(document).ready(function() {
    $('#tel_mobi').mask("999-999-9999");

    $('#start_date').datepicker({
        format: "dd/mm/yyyy",
        language: "th",
        autoclose: true
    });

    let _yearDy = $('#Dyy').val();

    const _regis_date = $("#regis_date");

    $("#regis_date").empty();

    _regis_date.append("<option value='N'> กรุณาเลือกปีรถ</option>");
    let year = new Date().getFullYear();
    let maxYear = year - 30;
    for (let i = year; i >= maxYear; i--) {
        _regis_date.append(`<option value='${i}'>${i}</option>`);
    }
});

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
        $("#icard").val('');
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
    $("#icard").val(icard_val);
    if ($('#person').is(':checked') && icard_val != '' && icard_val.length == 13) {
        if (!checkID_test($('#icard').val())) {
            alert('รหัสประชาชนไม่ถูกต้อง');
            $('#icard').val('');
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
            $("#last").val('').attr('readonly', false);
            $("#show_last_title").html('นามสกุล');
            $("#show_last_text").show();
            $("#show_last_text").attr('colspan', '1');
            $("#show_name_text").attr('colspan', '1');
            $("#name_name").attr('style', 'width:200px');
            $("#GroupIdCardSingle").hide();
            $("#GroupIdCardMultiple").show();
            $("#ByCustomer").hide().val('');
            $("#last_text").text('');
            $("#TitleCustomer").hide().val('');
            $("#name_name").attr("placeholder", "");
            $("#last").attr("placeholder", "");
            $("#last").attr('maxlength', parseInt(40) - parseInt($("#ByCustomer").val().length));
        } else if (selectID == 2) {
            $("#show_name_title").html('ชื่อบริษัท');
            $("#last").val('').attr('readonly', true);
            $("#show_last_title").html('.');
            $("#show_last_text").hide();
            $("#show_last_text").attr('colspan', '1');
            $("#show_name_text").attr('colspan', '3');
            $("#name_name").attr('style', 'width:500px;');
            $("#GroupIdCardSingle").hide();
            $("#GroupIdCardMultiple").show();
            $("#ByCustomer").hide().val('');
            $("#last_text").text('');
            $("#TitleCustomer").hide().val('');
            $("#last").attr('maxlength', parseInt(40) - parseInt($("#ByCustomer").val().length));
            $("#name_name").attr("placeholder", "ใส่เฉพาะชื่อบริษัท");
            $("#last").attr("placeholder", "ชื่อกรรมการ 1 ท่าน");
        } else if (selectID == 3) {
            $("#show_name_title").html('ชื่อ');
            $("#last").attr('readonly', false);
            $("#show_last_title").html('นามสกุล');
            $("#show_last_text").show();
            $("#show_last_text").attr('colspan', '1');
            $("#show_name_text").attr('colspan', '1');
            $("#name_name").attr('style', 'width:200px;');
            $("#GroupIdCardMultiple").hide();
            $("#GroupIdCardSingle").show();
            $("#ByCustomer").hide().val('');
            $("#last_text").text('');
            $("#TitleCustomer").hide().val('');
            $("#name_name").attr("placeholder", "");
            $("#last").attr("placeholder", "");
            $("#last").attr('maxlength', parseInt(40) - parseInt($("#ByCustomer").val().length));
        }

        const titleElem = document.querySelector('#title');
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
            title: 'ท่านจะรับผิดชอบค่าเบี้ย',
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


function loadDefaultActFirst() {
    $.ajax({
        type: "POST",
        url: "./services/VehicleType.controller.php",
        data: {
            Controller: 'LoadDefaultAct',
            CarTypeID: $('#cartype').val()
        },
        dataType: "JSON",
        success: (response) => {
            $('#showNetText').html(`<h4 class="textNet text-danger">เบี้ย ${response.Net} บาท</h4>`);
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

function redTabern(chk) {
    if ($(`#${chk.id}`).prop('checked')) {
        for (let i = 1; i <= 7; i++) {
            $(`#car_regis${i}`).attr('readonly', true);
            $("#car_regis").val('ปดF0050');
        }
    } else {
        for (let i = 1; i <= 7; i++) {
            $(`#car_regis${i}`).attr('readonly', false);
        }
    }
}


function onkey_car_regis(id, id1, event) {
    var tx_car_regis1;
    var tx_car_regis2;
    if (event.which == 37 || event.which == 38 || event.which == 39 || event.which == 40 || event.which == 32 || event
        .which == 9) {
        if (event.which == 32) {
            $("#" + id1).val('');
        }
        return false;
    }
    if (id1 != 'car_regis1' && id1 != 'car_regis2' && id1 != 'car_regis3' && $("#" + id1).val().search(
            /^[0-9]{0,9}$/)) {
        $("#" + id1).val('');
        $("#" + id1).focus();
        return false;
    }
    if (id != '' && $("#" + id1).val() != '') {
        $("#" + id).val('');
        $("#" + id).focus();

    }
    tx_car_regis1 = $("#car_regis1").val() + '' + $("#car_regis2").val() + '' + $("#car_regis3").val();
    if (tx_car_regis1 != '') {
        tx_car_regis1 += ' ';
    } else {
        tx_car_regis1 += '';
    }

    tx_car_regis2 = $("#car_regis4").val() + '' + $("#car_regis5").val() + '' + $("#car_regis6").val() + '' + $(
        "#car_regis7").val();
    $("#car_regis").val(tx_car_regis1 + '' + tx_car_regis2);
}

function js_seat() {
    // var search = {
    //     url: "ajax/Ajax_seat_act.php",
    //     type: "POST",
    //     dataType: "JSON",
    //     data: {
    //         TYPE: "SEAT",
    //         idprp: $("#cartype").val(),
    //         id_car: $("#car_id").val()
    //     },
    //     success: function(data) {
    //         //$("#car_seat").html(data.seat);
    //     },
    //     error: function() {
    //         alert('error data');
    //     }
    // };
    // $.ajax(search);
}

/*วันที่คุ้มครอง ป้องกันเลือกวันย้อนหลัง*/
async function blockBackInsuranceDate(elements) {
    try {
        let arrDate = elements.value.split('/');
        let nowDate = new Date();
        let selectDate = new Date();

        selectDate.setDate(parseInt(arrDate[0]));
        selectDate.setMonth(parseInt(arrDate[1]) - parseInt(1));
        selectDate.setFullYear(parseInt(arrDate[2]));

        if (nowDate > selectDate) {
            alert(
                `วันคุ้มครอง ${elements.value} ไม่สามารถเลือกวันที่น้อยกว่าวันปัจจุบันได้ กรุณาเลือกวันใหม่อีกครั้ง`
            );
            document.getElementsByName(elements.name)[0].value = null;
        }
        return false;
    } catch (err) {
        alert(`object blockBackInsuranceDate ${err}`);
        return false;
    }
}

</script>