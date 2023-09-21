<?php
require("../pages/check-ses.php");
require("../inc/connectdbs.pdo.php");
require "../services/InsuranceNotificationWork/service/general-information.service.php";
require "../services/InsuranceNotificationWork/model/insurance-notification-work.model.php";

if ($_SESSION['strUser'] != 'admin') {
    $display_hide = " display:none;";
} else {
    $display_hide = "";
}
//                         $edit_nameuser = "";
//                         $edit_user = explode("1",$_POST['user']);
//                         $edit_nameuser = 'M' . $edit_user[1];
// echo $edit_nameuser; exit;
$_serviceMitSu = new GeneralInformation(PDO_CONNECTION::fourinsure_mitsu());
$model = new DataRenewArrayRequest();
$model->id_data = $_POST['id_data'];
$data_renew_array = $_serviceMitSu->getDetailDataRenewArray($model);

$title = $data_renew_array['person'] == 1 ? $data_renew_array['icard'] : $data_renew_array['icard_niti'];

$detail_renew_sql = "SELECT * FROM detail_renew WHERE id_detail = '" . $_POST['id_detail'] . "' AND id_data = '" . $_POST['id_data'] . "'";
$detail_renew_array = PDO_CONNECTION::fourinsure_mitsu()->query($detail_renew_sql)->fetch(2);
$data_renew = explode('|', $detail_renew_array['detailcost']);
$id_data_old  = $_POST['id_data'];
echo "<script> var _idData = '$id_data_old'</script>";

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

$discountuse = array();
$sql = "SELECT * FROM tb_agent ORDER BY full_name ASC";
$resultAgentAll = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetchAll(2);
foreach ($resultAgentAll as $x) {
    $discountuse[$x['id_agent']] = $x['agent_dis'];
}
$protection_sql = "SELECT * FROM tb_protection WHERE protect_type = '" . $detail_renew_array['renew_ptype'] . "' AND end_date >= '" . date('Y-m-d') . "'";
$protection_array = PDO_CONNECTION::fourinsure_insured()->query($protection_sql)->fetch(2);
?>

<script>
    // console.log(_iddata);

    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>
<!-- <script src="js/ApiRenew.js" type="text/javascript"></script> -->

<link rel="stylesheet" href="css/grid.css">

<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
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

    .design-form {
        width: 100%;
        /* border-radius: 0px 0px 12px 12px; */
        padding-top: 5px;
        padding-bottom: 10px;
        box-shadow: 0 8px 8px 0 rgb(0 0 0 / 20%);
        transition: 0.3s;
        background-color: rgb(209, 209, 209);
    }

    .font-resize-ti {
        font-size: 20px;
        margin-top: 10px;
        margin-left: 10px;
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

    .e-span1 {
        width: 8.33%;
    }

    .e-span2 {
        width: 16.66%;
    }

    .e-span3 {
        width: 25.00%;
    }

    .e-span4 {
        width: 33.33%;
    }

    .e-span5 {
        width: 41.66%;
    }

    .e-span6 {
        width: 50%;
    }

    .e-span8 {
        width: 66.66%;
    }

    .e-span9 {
        width: 75.00%;
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

    .flx-important {
        display: flex;
    }

    .zip-group {
        width: 25px;
        text-align: center;
    }

    #webForm_inform input,
    #webForm_inform select {
        border-style: solid;
        border-color: #999999;
        border-width: 2px;
        /* background: #dddddd; */
    }

    .boxz {
        border: 1px solid;
    }

    .phone-field {
        font-size: 20px;
        width: 100%;
    }

    .zip-group {
        width: 100%;
    }

    .phone-input {
        width: 100%;
        text-align: center;
        font-size: 16px !important;
        height: 1.75em;
        border: 0;
        outline: 0;
        background: transparent;
        border-bottom: 2px solid #ddd;
        margin-right: 2px;
        margin-left: 2px;
    }

    [placeholder]:focus::-webkit-input-placeholder {
        transition: opacity 0.5s 0.0s ease;
        opacity: 0;
    }
</style>
<?php
$css_margin = 'margin:0;';
$css_margin_font = 'margin-top:7px;';
$css_margin_font_tab = 'margin-left:30px;';
$css_margin_font_tab_right = 'margin-right:30px; float: right;';
?>
<form name="webForm_inform" id="webForm_inform">
    <div class='font-design'>

        <!--ข้อมูลประกันภัย-->
        <div class='design-ti' style='<?php echo $css_margin ?>'>
            <div class='font-resize-ti span3' style='margin-top:10px;margin-left:10px;'>
                <font style='color:#FFFFFF;'>ข้อมูลผู้ประกันภัย </font>
            </div>
        </div>
        <div class='design-form' style='margin-bottom:10px;'>
            <div class='grid grid-cols-1 gap-6 sm:grid-cols-2' style='padding: 0.5rem; '>
                <div style='display:none' id="divTempText"></div>
                <div class="alert alert-info" style='display:none' id='tempText'>
                    <p>ข้อมูลสำรอง</p>
                </div>
                <div class="flex">
                    <div class="w-100 mr-2" style="display:none;">
                        <label for="">สาขาแจ้งงาน</label>
                        <?php
                        $edit_nameuser = "";
                        $edit_user = substr($_POST['user'], 1, 5);
                        $edit_nameuser = 'M' . $edit_user;

                        for ($n = 0; $n < count($edit_user); $n++) {
                            if ($n <= 3) {
                                $edit_nameuser .= "";
                            } else {
                                $edit_nameuser .= $edit_user[$n];
                            }
                        }
                        if ($_SESSION['strUser'] != 'admin') {
                            $id_agent_sql = "AND id_agent = '" . $edit_nameuser . "'";
                        } else {
                            $id_agent_sql = "";
                        }

                        $sql = "SELECT * FROM tb_agent where id_agent not in ('MBLT','NMBLT') " . $id_agent_sql . " order by full_name asc";

                        $resultAgent = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetch(2);
                        echo "<input type='text' class='w-100' id='agent_inform' name='agent_inform' value= '$resultAgent[full_name]' readonly/>";
                        $ccccca = explode('+', $resultAgent['agent_dis']);
                        $comittion_a = '0';
                        ?>
                    </div>
                    <div class="w-100 mr-2" style="display:none;">
                        <label for="">ผู้แจ้ง</label>
                        <input type='text' class='w-100' name='emp_inform' id='emp_inform' value= 'DEALER' readonly/>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                        <div class='span2 e-span2' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>ประเภทลูกค้า :</font>
                            <input class="span2" type="hidden" id="show_q_auto_inform" name="show_q_auto_inform" readonly="readonly" />
                            <input name="currentText_inform" type="hidden" id="currentText_inform" value="<?php echo $edit_nameuser; ?>" />
                            <!-- เอาไว้ส่งอัพเดทสถานะการแจ้งงาน -->
                            <input type="hidden" name="end_date_old_inform" id="end_date_old_inform" size="18" maxlength="50" value='' />
                            <input type="hidden" name="id_data_old_inform" id="id_data_old_inform" size="18" maxlength="50" value='<?php echo $id_data_old; ?>' />
                            <input type="hidden" name="car_body_old_inform" id="car_body_old_inform" size="18" maxlength="50" value='' />
                        </div>
                        <div class='span2 e-span2' style='<?php echo $css_margin ?>'>
                            <input style="font-size:18px;text-align:right;" type="radio" id="status_vip1_inform" name="status_vip_inform" value="N" checked /><strong style="font-size:16px;">&nbsp;ลูกค้าปกติ</strong>
                        </div>
                        <div class='span2 e-span2' style='<?php echo $css_margin ?>'>
                            <input style="font-size:18px;text-align:right;" type="radio" id="status_vip2_inform" name="status_vip_inform" value="Y" /><strong style="font-size:16px;">&nbsp;ลูกค้า
                                VIP</strong>
                        </div>
                    </div>
                    <div class="mr-2 w-25">
                        <label for="">บุคคล/นิติบุคคล</label>
                        <select name="person_inform" id="person_inform" class='w-100' onchange="setprefix(this)">
                            <option value="0">--เลือก--</option>
                            <option value="1" <?php if ($data_renew_array['person'] == '1') {
                                                    echo "selected";
                                                } ?>>
                                บุคคลธรรมดา
                            </option>
                            <option value="2" <?php if ($data_renew_array['person'] == '2') {
                                                    echo "selected";
                                                } ?>>
                                นิติบุคคล
                            </option>
                        </select>
                    </div>
                    <div class="mr-2 w-70">
                        <label for="">เลขบัตร/เลขนิติบุคคล</label>
                        <div class="w-100" id="telGroup">
                            <div class="phone-field flex">
                                <input type='text' class='phone-input' name='icard1' id='icard1' onkeyup='onkey_icard("icard2","icard1",event);' value='' maxlength='1'>
                                -
                                <input type='text' class='phone-input' name='icard2' id='icard2' onkeyup='onkey_icard("icard3","icard2",event);' value='' maxlength='1'>
                                <input type='text' class='phone-input' name='icard3' id='icard3' onkeyup='onkey_icard("icard4","icard3",event);' value='' maxlength='1'>
                                <input type='text' class='phone-input' name='icard4' id='icard4' onkeyup='onkey_icard("icard5","icard4",event);' value='' maxlength='1'>
                                <input type='text' class='phone-input' name='icard5' id='icard5' onkeyup='onkey_icard("icard6","icard5",event);' value='' maxlength='1'>
                                -
                                <input type='text' class='phone-input' name='icard6' id='icard6' onkeyup='onkey_icard("icard7","icard6",event);' value='' maxlength='1'>
                                <input type='text' class='phone-input' name='icard7' id='icard7' onkeyup='onkey_icard("icard8","icard7",event);' value='' maxlength='1'>
                                <input type='text' class='phone-input' name='icard8' id='icard8' onkeyup='onkey_icard("icard9","icard8",event);' value='' maxlength='1'>
                                <input type='text' class='phone-input' name='icard9' id='icard9' onkeyup='onkey_icard("icard10","icard9",event);' value='' maxlength='1'>
                                <input type='text' class='phone-input' name='icard10' id='icard10' onkeyup='onkey_icard("icard11","icard10",event);' value='' maxlength='1'>
                                -
                                <input type='text' class='phone-input' name='icard11' id='icard11' onkeyup='onkey_icard("icard12","icard11",event);' value='' maxlength='1'>
                                <input type='text' class='phone-input' name='icard12' id='icard12' onkeyup='onkey_icard("icard13","icard12",event);' value='' maxlength='1'>
                                -
                                <input type='text' class='phone-input' name='icard13' id='icard13' onkeyup='onkey_icard("","icard13",event);' value='' maxlength='1'>
                            </div>
                            <input type="text" id="icard_inform" name="icard_inform" maxlength="13" class='w-100' style='display: none;' value='<?php echo $title; ?>' />
                        </div>
                    </div>
                    <div class="w-20">
                        <label for="">คำนำหน้า</label>
                        <select id="title_inform" name="title_inform" class='w-100 class_title_inform' onchange="handleChangeTitle()">
                            <option selected disabled value="0">กรุณาเลือก</option>
                        </select>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-30 mr-2" id='show_name_form'>
                        <label for="" id="name_lb">ชื่อจริง</label>
                        <input type='text' name="name_inform" id="name_inform" class='w-100' placeholder='ป้อนชื่อจริง' maxlength="100" value='<?php echo $data_renew_array['n_name']; ?>' />
                    </div>
                    <div class="w-25 mr-2" id='show_last_form'>
                        <label for="" id="last_lb">นามสกุล</label>
                        <input type='text' name="last_inform" id="last_inform" class='w-100 lastInform' placeholder='ป้อนนามสกุล' maxlength="50" value='<?php if (!empty($data_renew_array['last'])) {
                                                                                                                                                            echo $data_renew_array['last'];
                                                                                                                                                        } else {
                                                                                                                                                            echo '-';
                                                                                                                                                        } ?>' />
                    </div>
                    <div class="w-15">
                        <label for="">อาชีพ/ธุรกิจ</label>
                        <input type="text" id="id_vocation_inform" name="id_vocation_inform" value='<?php echo $data_renew_array['vocation']; ?>' class='w-100'>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                        <div class='span2 e-span2' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>ที่อยู่ในการจัดส่ง :</font>
                        </div>
                        <div class='span2 e-span2' style='<?php echo $css_margin ?>'>
                            <input type="radio" id="SendAdd1_inform" name="SendAdd_inform" value="1" checked /><strong style='font-size:16px;'>&nbsp;ที่อยู่ตามกรมธรรม์</strong>
                        </div>

                        <div class='span2 e-span2' style='<?php echo $css_margin ?>'>
                            <input type="radio" id="SendAdd2_inform" name="SendAdd_inform" value="2" /> <strong style='font-size:16px;'>&nbsp;ที่อยู่ในการจัดส่ง</strong>
                        </div>
                    </div>
                    <!--ที่อยู่ในการจัดส่ง-->
                    <div class='span12 e-span12 bk-event' id='Send2_inform' style='<?php echo $css_margin ?> display:none;'>
                        <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>บ้านเลขที่</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <input type="text" name="send_add" id="send_add" class='w-100'>
                                </div>
                            </div>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>หมู่</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <input type="text" name="send_group" id="send_group" class='w-100'>
                                </div>
                            </div>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>อาคาร/หมู่บ้าน</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <input type="text" name="send_town" id="send_town" class='w-100'>
                                </div>
                            </div>
                        </div>
                        <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>ซอย</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <input type="text" name="send_lane" id="send_lane" class='w-100'>
                                </div>
                            </div>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>ถนน</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <input type="text" name="send_road" id="send_road" class='w-100'>
                                </div>
                            </div>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>จังหวัด</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <select name="send_province" id="send_province" class='w-100' onchange='js_proshow("AMPHUR","province","send_province","send_amphur");'>
                                        <option value=''>--กรุณาเลือก--</option>
                                        <?php
                                        $send_province_sql = "SELECT * FROM tb_province";
                                        $send_province_query = PDO_CONNECTION::fourinsure_insured()->query($send_province_sql);
                                        foreach ($send_province_query->fetchAll(2) as $send_province_array) { ?>
                                            <option value='<?php echo $send_province_array['id'] ?>'>
                                                <?php echo $send_province_array['name'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>อำเภอ</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <select name="send_amphur" id="send_amphur" class='w-100' onchange='js_proshow("TUMBON","amphur","send_amphur","send_tumbon");'>
                                        <option value=''>--กรุณาเลือก--</option>
                                    </select>
                                </div>
                            </div>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>ตำบล</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <select name="send_tumbon" id="send_tumbon" class='w-100' onchange='js_proshow("POST","tumbon","send_tumbon","send_post")' ;>
                                        <option value=''>--กรุณาเลือก--</option>
                                    </select>
                                </div>
                            </div>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>รหัสไปรษณีย์</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <select name="send_post" id="send_post" class='w-100'>
                                        <option value=''>--กรุณาเลือก--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--ที่อยู่ในการจัดส่ง END-->
                </div>
                <div class="flex">
                    <div class="mr-2">
                        <label for="">สถานที่</label>
                        <input type="text" name="in_career_inform" class='w-100' id="in_career_inform" value=''>
                    </div>
                    <div class=" mr-2">
                        <label for="">บ้านเลขที่</label>
                        <input type="text" name="add_inform" id="add_inform" value='<?php echo $data_renew_array['add']; ?>' class='w-100'>
                    </div>
                    <div class="mr-2 w-10">
                        <label for="">หมู่ที่</label>
                        <input type='text' name="group_inform" id="group_inform" value='<?php echo $data_renew_array['group']; ?>' class='w-100'>
                    </div>
                    <div class="mr-2">
                        <label for="">ชื่อหมู่บ้าน</label>
                        <input type='text' id="town_inform" class='w-100' name="town_inform" value='<?php echo $data_renew_array['town']; ?>'>
                    </div>
                    <div class="mr-2">
                        <label for="">ซอย</label>
                        <input type='text' id="lane_inform" class='w-100' name="lane_inform" value='<?php echo $data_renew_array['lane']; ?>' />
                    </div>
                    <div>
                        <label for="">ถนน</label>
                        <input type='text' id="road_inform" class='w-100' name="road_inform" value='<?php echo $data_renew_array['road']; ?>' />
                    </div>
                </div>
                <div></div>
                <div class="flex">
                    <div class="mr-2 w-20">
                        <label for="">จังหวัด</label>
                        <select name='province_inform' id='province_inform' class='w-100'>
                            <option value='0'>--กรุณาเลือกจังหวัด--</option>
                            <?php
                            $sql = "SELECT * FROM tb_province";
                            $result = PDO_CONNECTION::fourinsure_insured()->query($sql);
                            foreach ($result->fetchAll(2) as $fetcharr) {
                                if ($fetcharr['id'] == $data_renew_array['province']) {
                                    $seleced_p = "selected";
                                } else {
                                    $seleced_p = "";
                                } ?>
                                <option value='<?php echo $fetcharr['id'] ?>' <?php echo $seleced_p ?>>
                                    <?php echo $fetcharr['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mr-2 w-20">
                        <label for="">อำเภอ</label>
                        <select name="amphur_inform" id="amphur_inform" class='w-100'>
                            <?php
                            $tb_amphur_sql = "SELECT id,name FROM tb_amphur WHERE provinceID = '" . $data_renew_array['province'] . "'";
                            $tb_amphur_query = PDO_CONNECTION::fourinsure_insured()->query($tb_amphur_sql);
                            ?>
                            <option value="0">กรุณาเลือก</option>
                            <?php foreach ($tb_amphur_query->fetchAll(2) as $tb_amphur_array) { ?>
                                <option value='<?php echo $tb_amphur_array['id']; ?>' <?php if ($tb_amphur_array['id'] == $data_renew_array['amphur']) {
                                                                                            echo "selected";
                                                                                        } ?>>
                                    <?php echo $tb_amphur_array['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class=" mr-2 w-20">
                        <label for="">ตำบล</label>
                        <select name="tumbon_inform" id="tumbon_inform" class='w-100'>
                            <?php
                            $tb_tumbon_sql = "SELECT id,name FROM tb_tumbon WHERE amphurID = '" . $data_renew_array['amphur'] . "'";
                            $tb_tumbon_query = PDO_CONNECTION::fourinsure_insured()->query($tb_tumbon_sql);
                            ?>
                            <option value="0">กรุณาเลือก</option>
                            <?php foreach ($tb_tumbon_query->fetchAll(2) as $tb_tumbon_array) { ?>
                                <option value='<?php echo $tb_tumbon_array['id']; ?>' <?php if ($tb_tumbon_array['id'] == $data_renew_array['tumbon']) {
                                                                                            echo "selected";
                                                                                        } ?>>
                                    <?php echo $tb_tumbon_array['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mr-2 w-20">
                        <label for="">รหัสไปรษณีย์</label>
                        <select name="postal_inform" id="postal_inform" class='w-100'>
                            <option value='<?php echo $data_renew_array['postal']; ?>'>
                                <?php echo $data_renew_array['postal']; ?></option>
                        </select>
                    </div>
                </div>
                <div></div>
                <div class="flex">
                    <div class="mr-2 w-20">
                        <label for="">เบอร์มือถือ 1</label>
                        <input type="text" id="tel_mobile_inform" name="tel_mobile_inform" class='w-100' value='<?php echo $data_renew_array['tel_mobi']; ?>'>
                    </div>
                    <div class="mr-2 w-20">
                        <label for="">เบอร์มือถือ 2</label>
                        <input type="text" id="tel_mobile2_inform" name="tel_mobile2_inform" class='w-100' value='<?php echo $data_renew_array['tel_mobi_2']; ?>'>
                    </div>
                    <div class="mr-2 w-20">
                        <label for="">เบอร์บ้าน/ที่ทำงาน</label>
                        <input type="text" id="tel_home_inform" name="tel_home_inform" value='<?php echo $data_renew_array['tel_home']; ?>' class='w-100'>
                    </div>
                    <div class="mr-2 w-20">
                        <label for="">เบอร์แฟกซ์</label>
                        <input type="text" id="tel_fax_inform" name="tel_fax_inform" maxlength="10" value='<?php echo $data_renew_array['fax']; ?>' class='w-100'>
                    </div>
                    <div class="w-20">
                        <label for="">ID Line</label>
                        <input type="text" id="id_line_inform" name="id_line_inform" value='<?php echo $data_renew_array['id_line']; ?>' class='w-100'>
                    </div>
                </div>
                <div class="flex">
                    <div class="mr-2">
                        <label for="">อีเมล์</label>
                        <input type="text" id="email_inform" class='w-100' name="email_inform" value='<?php echo $data_renew_array['email']; ?>'>
                    </div>
                </div>
            </div>
        </div>
        <!--END-->

        <!--ข้อมูลรถยนต์-->
        <div class='design-ti span12' style='<?php echo $css_margin ?>'>
            <div class='font-resize-ti span3' style='margin-top:10px;margin-left:10px;'>
                <font style='color:#FFFFFF;'>ข้อมูลรถยนต์</font>
            </div>
        </div>
        <div class='design-form span12' style='<?php echo $css_margin ?> margin-bottom:10px;'>
            <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                <div class='span2 e-span2' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                    <font style='<?php echo $css_margin_font_tab ?>'>ประเภทรถ :</font>
                </div>
                <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                    <select name='cat_car_inform' id='cat_car_inform' class='w-100'>
                        <option value='0'>--กรุณาเลือกประเภท--</option>
                        <?php
                        $sql = "SELECT id, name FROM tb_cat_car";
                        $result = PDO_CONNECTION::fourinsure_insured()->query($sql);
                        foreach ($result->fetchAll(2) as $fetcharr) {
                            if ($fetcharr['id'] == $data_renew_array['cat_car']) {
                                $cat_car_select = "selected";
                            } else {
                                $cat_car_select = "";
                            } ?>
                            <option value='<?php echo $fetcharr['id'] ?>' <?php echo $cat_car_select ?>>
                                <?php echo $fetcharr['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class='grid grid-cols-1 gap-6 sm:grid-cols-2' style='padding: 0.5rem; '>
                <div class="flex">
                    <div class='w-50 mr-2'>
                        <label for="">ประเภทการใช้</label>
                        <select name='cartype_inform' id='cartype_inform' class='w-100'>
                            <?php
                            if (strlen($row['car_id']) <= 3) {
                                $type_car = substr($data_renew_array['car_id'], 0, 1);
                                $nature_car = substr($data_renew_array['car_id'], 1, 3);
                            } else {
                                $type_car = substr($data_renew_array['car_id'], 0, 2);
                                $nature_car = substr($data_renew_array['car_id'], 2, 4);
                            }
                            $tb_pass_car_sql = "SELECT id, name FROM tb_pass_car WHERE id = '" . $type_car . "'";
                            $tb_pass_car_query =  PDO_CONNECTION::fourinsure_insured()->query($tb_pass_car_sql);
                            $tb_pass_car_array = $tb_pass_car_query->fetch(2);
                            $sql = "SELECT id, name FROM tb_pass_car ORDER BY id ASC LIMIT 3";
                            $result =  PDO_CONNECTION::fourinsure_insured()->query($sql);
                            if (!empty($tb_pass_car_array)) { ?>
                                <option value='<?php echo $tb_pass_car_array['id'] ?>'>
                                    <?php echo $tb_pass_car_array['id'] . " : " . $tb_pass_car_array['name'] ?></option>
                            <?php } else { ?>
                                <option value='0'>--กรุณาเลือกประเภท--</option>
                            <?php }
                            foreach ($result->fetchAll(2) as  $fetcharr) { ?>
                                <option value='<?php echo $fetcharr['id'] ?>'>
                                    <?php echo $fetcharr['id'] . " : " . $fetcharr['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class='w-80 mr-2'>
                        <?php
                        $tb_pass_car_type_sql = "SELECT id,name FROM tb_pass_car_type WHERE id_pass_car = '" . $type_car . "' AND id = '" . $nature_car . "'";
                        $tb_pass_car_type_query = PDO_CONNECTION::fourinsure_insured()->query($tb_pass_car_type_sql);
                        $tb_pass_car_type_array = $tb_pass_car_type_query->fetch(2);
                        //echo $tb_pass_car_type_sql;
                        ?>
                        <label for="">ลักษณะใช้งาน</label>
                        <select name="car_id_inform" id="car_id_inform" class='w-100'>
                            <option value="<?php if (!empty($tb_pass_car_type_array)) {
                                                echo $type_car . $tb_pass_car_type_array['id'];
                                            } else {
                                                echo "0";
                                            } ?>">
                                <?php if (!empty($tb_pass_car_type_array)) {
                                    echo $tb_pass_car_type_array['id'] . " : " . $tb_pass_car_type_array['name'];
                                } else {
                                    echo "--เลือกลักษณะใช้งาน--";
                                } ?>
                            </option>
                        </select>
                    </div>
                    <div class="mr-2 w-50">
                        <label for="">ยี่ห้อรถ</label>
                        <select name="br_car_inform" id="br_car_inform" class='w-100' maxlength="15">
                            <option value="0">--เลือกยี่ห้อรถ--</option>
                            <?php
                            $tb_br_car_sql = "SELECT id,name FROM tb_br_car WHERE id = '" . $data_renew_array['br_car'] . "'";
                            $tb_br_car_query = PDO_CONNECTION::fourinsure_insured()->query($tb_br_car_sql);
                            foreach ($tb_br_car_query->fetchAll(2) as $tb_br_car_array) {
                                if ($tb_br_car_array['id'] == $data_renew_array['br_car']) {
                                    $tb_br_car_select = "selected";
                                } else {
                                    $tb_br_car_select = "";
                                }
                            ?>
                                <option value="<?php echo $tb_br_car_array['id']; ?>" <?php echo $tb_br_car_select; ?>>
                                    <?php echo $tb_br_car_array['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="w-100">
                        <label for="">รุ่นรถ</label>
                        <select name="mo_car_inform" id="mo_car_inform" class='w-100' maxlength="20">
                            <option value="0">--เลือกรุ่นรถ--</option>
                            <?php
                            $tb_mo_car_sql = "SELECT tb_mo_car.id,tb_mo_car.name FROM tb_mo_car 
                            WHERE tb_mo_car.br_id = {$data_renew_array['br_car']}";
                            $tb_mo_car_query = PDO_CONNECTION::fourinsure_insured()->query($tb_mo_car_sql);
                            foreach ($tb_mo_car_query->fetchAll(2) as $tb_mo_car_array) {
                                if ($tb_mo_car_array['id'] == $data_renew_array['mo_car']) {
                                    $tb_mo_car_select = "selected";
                                } else {
                                    $tb_mo_car_select = "";
                                }
                            ?>
                                <option value="<?php echo $tb_mo_car_array['id']; ?>" <?php echo $tb_mo_car_select; ?>>
                                    <?php echo $tb_mo_car_array['name']; ?></option>

                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-15 mr-2">
                        <label for="">ประเภททะเบียน</label>
                        <div class="flex">
                            <select name="chose_carregis_inform" class='w-100 mr-2' id="chose_carregis_inform">
                                <option value="0">-ทะเบียน-</option>
                                <option value="1" <?php if ($data_renew_array['car_regis'] == 'ป้ายแดง') {
                                                        echo "selected";
                                                    } ?>>
                                    ป้ายแดง</option>
                                <option value="2" <?php if ($data_renew_array['car_regis'] != 'ป้ายแดง') {
                                                        echo "selected";
                                                    } ?>>
                                    ป้ายดำ</option>
                            </select>
                        </div>
                    </div>
                    <?php echo "<script> var _car_regis = `$data_renew_array[car_regis]`;</script>";
                    if ($data_renew_array['car_regis'] == 'ป้ายแดง') { ?>
                        <div class="w-30 mr-2" id="showRegis" style="display:none;">
                            <label for="">เลขทะเบียน</label>
                            <div class="flx-important">
                                <input type='text' class='zip-group' name='car_regis1' id='car_regis1' onkeyup='onkey_car_regis("car_regis2","car_regis1",event);' value='' maxlength='1'>
                                <input type='text' class='zip-group' name='car_regis2' id='car_regis2' onkeyup='onkey_car_regis("car_regis3","car_regis2",event);' value='' maxlength='1'>
                                <input type='text' class='zip-group' name='car_regis3' id='car_regis3' onkeyup='onkey_car_regis("car_regis4","car_regis3",event);' value='' maxlength='1'>
                                <span class="mr-5 txt-dash">-</span>
                                <input type='text' class='zip-group' name='car_regis4' id='car_regis4' onkeyup='onkey_car_regis("car_regis5","car_regis4",event);' value='' maxlength='1'>
                                <input type='text' class='zip-group' name='car_regis5' id='car_regis5' onkeyup='onkey_car_regis("car_regis6","car_regis5",event);' value='' maxlength='1'>
                                <input type='text' class='zip-group' name='car_regis6' id='car_regis6' onkeyup='onkey_car_regis("car_regis7","car_regis6",event);' value='' maxlength='1'>
                                <input type='text' class='zip-group' name='car_regis7' id='car_regis7' onkeyup='onkey_car_regis("","car_regis7",event);' value='' maxlength='1'>
                            </div>
                            <input name="car_regis_inform" type="text" style='display:none;' id="car_regis_inform" value="<?php echo $data_renew_array['car_regis']; ?>">
                        </div>
                    <?php } else { ?>
                        <div class="w-30 mr-2" id="showRegis">
                            <label for="">เลขทะเบียน</label>
                            <div class="flx-important">
                                <input type='text' class='zip-group' name='car_regis1' id='car_regis1' onkeyup='onkey_car_regis("car_regis2","car_regis1",event);' value='' maxlength='1'>
                                <input type='text' class='zip-group' name='car_regis2' id='car_regis2' onkeyup='onkey_car_regis("car_regis3","car_regis2",event);' value='' maxlength='1'>
                                <input type='text' class='zip-group' name='car_regis3' id='car_regis3' onkeyup='onkey_car_regis("car_regis4","car_regis3",event);' value='' maxlength='1'>
                                <span class="mr-5 txt-dash">-</span>
                                <input type='text' class='zip-group' name='car_regis4' id='car_regis4' onkeyup='onkey_car_regis("car_regis5","car_regis4",event);' value='' maxlength='1'>
                                <input type='text' class='zip-group' name='car_regis5' id='car_regis5' onkeyup='onkey_car_regis("car_regis6","car_regis5",event);' value='' maxlength='1'>
                                <input type='text' class='zip-group' name='car_regis6' id='car_regis6' onkeyup='onkey_car_regis("car_regis7","car_regis6",event);' value='' maxlength='1'>
                                <input type='text' class='zip-group' name='car_regis7' id='car_regis7' onkeyup='onkey_car_regis("","car_regis7",event);' value='' maxlength='1'>
                            </div>
                            <input name="car_regis_inform" type="text" id="car_regis_inform" class='span4' style='display:none;' value="<?php echo $data_renew_array['car_regis']; ?>">
                        </div>
                    <?php } ?>
                    <div class="w-20 mr-2">
                        <label for="">จังหวัดทะเบียน</label>
                        <select name='car_regis_pro_inform' id='car_regis_pro_inform' class='w-100'>
                            <option value='0'>--เลือกจังหวัด--</option>
                            <?php
                            $sql = "SELECT * FROM tb_province";
                            $result = PDO_CONNECTION::fourinsure_insured()->query($sql);
                            foreach ($result->fetchAll(2) as  $fetcharr) {
                                if ($data_renew_array['car_regis_pro'] == $fetcharr['id']) {
                                    $car_regis_pro_select = "selected";
                                } else {
                                    $car_regis_pro_select = "";
                                } ?>
                                <option value='<?php echo $fetcharr['id'] ?>' <?php echo $car_regis_pro_select ?>>
                                    <?php echo $fetcharr['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="flex">
                    <div class="mr-2 w-25">
                        <label for="">เลขตัวถัง</label>
                        <?php
                        if ($data_renew_array['Req_Status'] == 'Y' && $data_renew_array['EditCar'] == 'Y') {
                            $car_body_text = $data_renew_array['Edit_CarBody'];
                            $n_moror_text = $data_renew_array['Edit_Nmotor'];
                        } else {
                            $car_body_text = $data_renew_array['car_body'];
                            $n_moror_text = $data_renew_array['n_motor'];
                        }
                        ?>
                        <input name="car_body_inform" type="text" id="car_body_inform" maxlength="25" class='w-100' value='<?php echo $car_body_text; ?>'>
                    </div>
                    <div class="mr-2 w-20">
                        <label for="">เลขตัวเครื่อง</label>
                        <input name="n_motor_inform" type="text" id="n_motor_inform" maxlength="25" class='w-100' value='<?php echo $n_moror_text; ?>'>
                    </div>
                    <div class="w-20 mr-2">
                        <label for="">ปีจดทะเบียน</label>
                        <div class="flex">
                            <select name="regis_date_inform" id="regis_date_inform" class='w-100 mr-2' onchange="javascript:showCarAge();">
                                <option value='<?php if (!empty($data_renew_array['regis_date'])) {
                                                    echo $data_renew_array['regis_date'];
                                                } ?>'>
                                    <?php if (!empty($data_renew_array['regis_date'])) {
                                        echo $data_renew_array['regis_date'];
                                    } else {
                                        echo "--เลือกปี--";
                                    } ?>
                                </option>
                                <?php $i = 0;
                                $yyy = date("Y");
                                while ($i <= 34) {
                                    $cal = $yyy - $i; ?>
                                    <option value='<?php echo $cal ?>'><?php echo $cal ?></option>
                                <?php $i++;
                                } ?>
                            </select>
                            <input name="year_old_inform" type="text" id="year_old_inform" class='w-30' maxlength="3" value='<?php if (!empty($data_renew_array['regis_date'])) {
                                                                                                                                    $total_date = ((date('Y')) - $data_renew_array['regis_date']) + 1;
                                                                                                                                    echo $total_date . " ปี";
                                                                                                                                } ?>' readonly>
                        </div>
                    </div>
                    <?php $array_desc = explode('/', $data_renew_array['desc']); ?>
                    <div class="w-10 mr-2">
                        <label for="">ซีซี</label>
                        <input name="cc_inform" type="text" id="cc_inform" class='w-100 mr-2' maxlength="4" placeholder='ซีซี' value="<?php echo $array_desc[1]; ?>">
                    </div>
                    <div class="w-10 mr-2">
                        <label for="">น.น.</label>
                        <input name="wg_inform" type="text" id="wg_inform" class='w-100 mr-2' maxlength="5" placeholder='น.น.' value="<?php if (!empty($array_desc[2])) {
                                                                                                                                            echo $array_desc[2] . '000';
                                                                                                                                        } ?>">
                    </div>
                    <div class="w-10">
                        <label for="">ที่นั่ง</label>
                        <input type="text" name="car_seat_inform" id="car_seat_inform" class='w-100' placeholder='ที่นั่ง' value='<?php echo $array_desc[0]; ?>'>
                    </div>
                </div>
                <div></div>
                <div class="flex">
                    <div class="mr-2 w-20">
                        <label for="">เกียร์</label>
                        <select name="gear_inform" size="1" id="gear_inform" class='w-100'>
                            <option value="0">--เลือกเกียร์--</option>
                            <option value="N" <?php if ($data_renew_array['gear'] == 'N') {
                                                    echo "selected";
                                                } ?>>
                                ไม่ระบุ
                            </option>
                            <option value="A" <?php if ($data_renew_array['gear'] == 'A') {
                                                    echo "selected";
                                                } ?>>
                                อัตโนมัติ
                            </option>
                            <option value="M" <?php if ($data_renew_array['gear'] == 'M') {
                                                    echo "selected";
                                                } ?>>ธรรมดา
                            </option>
                        </select>
                    </div>
                    <div class="mr-2 w-10">
                        <label for="">สีรถ</label>
                        <select name="car_color_inform" id="car_color_inform" class='w-100'>
                            <option value='<?php if (!empty($data_renew_array['car_color'])) {
                                                echo $data_renew_array['car_color'];
                                            } else {
                                                echo "";
                                            } ?>'>
                                <?php if (!empty($data_renew_array['car_color'])) {
                                    echo $data_renew_array['car_color'];
                                } else {
                                    echo "-- เลือกสีรถ --";
                                } ?>
                            </option>
                            <option value="ไม่ระบุ">ไม่ระบุ</option>
                            <option value="บอร์นเงิน">บอร์นเงิน</option>
                            <option value="บอร์นทอง">บอร์นทอง</option>
                            <option value="ขาว">ขาว</option>
                            <option value="ดำ">ดำ</option>
                            <option value="แดง">แดง</option>
                            <option value="ฟ้า">ฟ้า</option>
                            <option value="เขียว">เขียว</option>
                            <option value="ส้ม">ส้ม</option>
                            <option value="เทา">เทา</option>
                            <option value="เหลือง">เหลือง</option>
                            <option value="น้ำเงิน">น้ำเงิน</option>
                            <option value="น้ำตาล">น้ำตาล</option>
                            <option value="ม่วง">ม่วง</option>
                            <option value="ชมพู">ชมพู</option>
                            <option value="แดงดำ">แดงดำ</option>
                        </select>
                    </div>
                    <div class="w-20 mr-2">
                        <label for="">วันหมดภาษีรถยนต์</label>
                        <?php
                        if ($data_renew_array['end_date'] > date('Y-m-d')) {
                            $date_now = $data_renew_array['end_date'];
                        } else {
                            $date_now = date('Y-m-d');
                        }
                        ?>
                        <input id="vat_car_inform" name="vat_car_inform" type="text" value='<?php $edit_start_date = explode("-", $date_now);
                                                                                            $dtY = $edit_start_date[0];
                                                                                            echo $edit_start_date[2] . "/" . $edit_start_date[1] . "/" . $dtY; ?>' class='w-100' placeholder='คลิกที่นี้เพื่อเลือกวันที่วันหมดภาษี'>
                    </div>
                    <div class="w-20">
                        <label for="">ผู้รับผลประโยชน์</label>
                        <select name="name_gain_inform" id="name_gain_inform" class='w-100'>
                            <option value="<?php if (!empty($data_renew_array['g_name'])) {
                                                echo $data_renew_array['g_name'];
                                            } else {
                                                echo "0";
                                            } ?>">
                                <?php if (!empty($data_renew_array['g_name'])) {
                                    echo $data_renew_array['g_name'];
                                } else {
                                    echo "--เลือกชื่อผู้รับผลประโยชน์--";
                                } ?>
                            </option>
                            <?php
                            $query_accessories = "SELECT * FROM `tb_heiress` ORDER BY `tb_heiress`.`id` ASC";
                            $result1 = PDO_CONNECTION::fourinsure_insured()->query($query_accessories);
                            foreach ($result1->fetchAll(2) as $fetcharr) { ?>
                                <option value='<?php echo $fetcharr['name'] ?>' <?php echo $tb_heiress_select ?>>
                                    <?php echo $fetcharr['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!--END-->

        <!--ข้อมูลความคุ้มครอง-->
        <div class='design-ti span12' style='<?php echo $css_margin ?>'>
            <div class='font-resize-ti' style='margin-top:10px;margin-left:10px;'>
                <font style='color:#FFFFFF;'>ข้อมูลความคุ้มครอง และข้อมูลเบี้ยประกันภัย</font>
            </div>
        </div>
        <div class='design-form span12' style='<?php echo $css_margin ?> margin-bottom:10px;'>
            <div class='grid grid-cols-1 gap-6 sm:grid-cols-2' style='padding: 0.5rem; '>
                <div class="flex">
                    <div class="w-30 mr-2">
                        <label for="">ประเภท</label>
                        <select name="doc_type_inform" id="doc_type_inform" class='w-100'>
                            <?php
                            if (!empty($detail_renew_array['doc_type'])) { ?>
                                <option value="<?php echo $detail_renew_array['doc_type']; ?>">
                                    <?php echo $detail_renew_array['doc_type']; ?></option>
                            <?php } else { ?>
                                <option value="0">-- เลือกประเภท --</option>
                            <?php } ?>
                            <option value="0">-- เลือกประเภท --</option>
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
                            /*********** ดึงบริษัทประกัน ถ้าเป็นวิริยะจะเลือกสาขาตามภาคที่ส่ง *************/
                            // $data_renew_array[login]
                            $sql = "SELECT saka FROM tb_customer WHERE `user` = ''";
                            $logC = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetch(7);

                            if ($detail_renew_array['renew_comp'] == 'VIB_S' && $logC != '113') {
                                $chkIn = $detail_renew_array['renew_comp'] . $logC;
                            } else {
                                $chkIn = $detail_renew_array['renew_comp'];
                            }


                            $sql = "SELECT * FROM tb_comp WHERE sort = '$chkIn'";
                            $result = PDO_CONNECTION::fourinsure_insured()->query($sql)->fetchAll(2);

                            foreach ($result as $fetcharr) {
                                $se = $chkIn == $fetcharr['sort'] ? 'selected' : ''; ?>

                                <option value='<?php echo $fetcharr['sort'] ?>' <?php echo $se ?>>
                                    <?php echo $fetcharr['name_print'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="w-70 mr-2">
                        <label for="">ประเภทการซ่อม</label>
                        <select name="service_inform" id="service_inform" class='w-100'>
                            <option value="0">--เลือกประเภทการซ่อม--</option>
                            <option value="1" <?php if ($data_renew[12] == '1') {
                                                    echo "selected";
                                                } ?>>ซ่อมห้าง
                            </option>
                            <option value="2" <?php if ($data_renew[12] == '2') {
                                                    echo "selected";
                                                } ?>>ซ่อมอู่</option>
                        </select>
                    </div>
                    <div class="w-70 mr-2">
                        <label for="">วันที่คุ้มครอง</label>
                        <input id="start_date_inform" name="start_date_inform" type="text" class='w-100' value='<?php $edit_start_date = explode("-", $date_now);
                                                                                                                $dtY = $edit_start_date[0];
                                                                                                                echo $edit_start_date[2] . "/" . $edit_start_date[1] . "/" . $dtY; ?>' placeholder='คลิกที่นี่เพื่อเลือกวันที่คุ้มครอง'>
                    </div>
                    <div class="w-70 mr-2">
                        <label for="">วันสิ้นสุดคุ้มครอง</label>
                        <input id="end_date_inform" name="end_date_inform" type="text" class='w-100' value='<?php $edit_start_date = explode("-", $date_now);
                                                                                                            $dtY = $edit_start_date[0] + 1;
                                                                                                            echo $edit_start_date[2] . "/" . $edit_start_date[1] . "/" . $dtY; ?>' placeholder='คลิกที่นี่เพื่อเลือกวันที่คุ้มครอง'>
                    </div>

                    <div class='span2 e-span2' style='<?php echo $css_margin . " " . $css_margin_font ?> <?php echo $display_hide ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>การรับแจ้ง :</font>
                    </div>
                    <div class='span4 e-span4' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                        <select name="ty_inform" id="ty_inform" class='w-100'>
                            <option value="0">--เลือกประเภทการรับแจ้ง--</option>
                            <option value="L">L = ประกันใหม่ป้ายแดง</option>
                            <option value="N">N = ประกันใหม่</option>
                            <option value="R" selected>R = ประกันภัยต่ออายุในสาขา</option>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="w-20 mr-2">
                        <label for="">เลขกรมธรรม์เดิม</label>
                        <input id="o_insure_inform" name="o_insure_inform" type="text" value='<?php echo $data_renew_array['n_insure']; ?>' class='w-100'>
                    </div>
                </div>
            </div>
            <div style="padding: 0.5rem;display: flex;">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-1 w-30">
                    <div class="flex w-100">
                        <div class="w-100 mr-2">
                            <label for="">เบี้ยสุทธิ</label>
                            <input class='w-100' type="text" id="pre_inform" name="pre_inform" value="<?php echo number_format($data_renew[10], 2, '.', ','); ?>" onkeyup="javascript:calcfunc_inform();">
                        </div>
                        <div class="w-100 mr-2">
                            <label for="">เบี้ยรวม</label>
                            <input class='w-100' type="text" id="total_sum_inform" name="total_sum_inform" value="0.00" readonly style='text-align:right;'>
                        </div>
                        <div class="w-100">
                            <label for="">ส่วนลด</label>
                            <!--ส่วนลดตัวแทน-->
                            <input name="currentValue_inform" type="text" id="currentValue_inform" style="display: none;" value="<?php echo $comittion_a ?>" class='w-100' readonly="true">
                            <input name="extra" type="text" id="extra" value="<?php echo number_format($data_renew[6], 2, '.', ','); ?>" class='w-100' readonly="true" style='text-align:right;'>
                        </div>
                    </div>
                    <div class="flex w-100">
                        <div class="w-100 mr-2">
                            <label for="">เบี้ย พ.ร.บ.</label>
                            <div class="flex">
                                <input type="hidden" id='actCheck_inform' name='actCheck_inform' value="0" readonly style='text-align:right;'>
                                <input class='w-100' type="hidden" id='prb_net_inform' name='prb_net_inform' readonly style='text-align:right;'>
                                <select id="select_prb_inform" onchange="onChange(this.form), calcfunc_inform()" name="select_prb_inform" class='w-100 mr-2'>
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
                                        <option value="<?php echo number_format($tb_act_array['net_act'], 2, '.', ','); ?>" <?php if ($tb_act_array['net_act'] == $data_renew[9]) {
                                                                                                                                echo "selected";
                                                                                                                                $id_act_data = $tb_act_array['id_act'];
                                                                                                                                $act_net = $tb_act_array['pre_act'];
                                                                                                                                $act_total = number_format($tb_act_array['net_act'], 2, '.', ',');
                                                                                                                            } ?>>
                                            <?php echo $tb_act_array['id_act']; ?></option>
                                    <?php } ?>
                                </select>
                                <input class='w-100' type="hidden" id='prbNet_inform' name='prbNet_inform' value="0" readonly style='text-align:right'>
                                <select name='act_sort_inform' id='act_sort_inform' class='w-100 mr-2' style="display:none !important;">

                                    <?php
                                    //mysql_query("SET NAMES 'tis620'");//ทำให้ข้อมูลที่จะบันทึกเป็นภาษาไทย
                                    $sql = "SELECT * FROM tb_comp where sort = 'VIB_S' ";
                                    $result = PDO_CONNECTION::fourinsure_insured()->query($sql);
                                    foreach ($result->fetchAll(2) as $fetcharr) {
                                        if ($detail_renew_array['renew_comp'] == $fetcharr["sort"]) {
                                            $se = "selected";
                                        } else {
                                            $se = "";
                                        } ?>
                                        <option value='<?php echo $fetcharr["sort"] ?>' selected <?php echo $se ?>>
                                            <?php echo insure($fetcharr["name_print"]) ?> </option>
                                    <?php } ?>
                                </select>
                                <input value="0.00" class='w-100' type="text" id="currentValue_prb_inform" name="currentValue_prb_inform" readonly style='text-align:right;'>
                            </div>
                        </div>
                        <div class="w-100 mr-2">
                            <label for="">เบี้ย พ.ร.บ.</label>
                            <input value="0.00" class='w-100' type="text" id="total_prb_inform" name="total_prb_inform" readonly style='text-align:right;'>
                        </div>
                        <div class="w-100" style="display: none;">
                            <label for="">ค่า คอมมิชชั่น</label>
                            <input name="other_inform" type="text" id="other_inform" value="<?php echo number_format($data_renew[6], 2, '.', ','); ?>" class='w-100' readonly="true" style='text-align:right;'>
                            <input name="other_new_inform" type="hidden" id="other_new_inform" value="0.00" class='w-100' readonly="true">
                        </div>
                    </div>
                </div>
                <div class="w-10" style="padding-left: 1rem;">
                    <label for="">นำส่ง</label>
                    <div class="flex">
                        <input class="w-100" id="total_commition_inform" onchange="JavaScript:chkNum(this)" value="0.00" type="text" name="total_commition_inform" readonly style='text-align: center;    margin: 0;font-size: 1.5rem !important;font-weight: bolder;height: 106px;background: #03a9f400 !important;'>
                        <input class="w-100" id="total_commition_new_inform" onchange="JavaScript:chkNum(this)" value="0.00" type="hidden" name="total_commition_new_inform" readonly style='text-align:right;'>
                    </div>
                </div>
            </div>

            <div style="padding: 0.5rem;">
                <div style='background: white; border-radius: 5px;'>
                    <div style="padding-left: 1rem;padding-right: 1rem;padding-top: 1rem;font-size: 19px; display: flex;">
                        ทุนประกันภัย&nbsp;<font id='cost_inform_show'></font>&nbsp;บาท
                    </div>
                    <div class='grid grid-cols-1 gap-6 sm:grid-cols-2' style='padding-left: 1rem;padding-right: 1rem;'>
                        <div class="flex boxz" style="margin: 1rem; padding: 0.5rem;">
                            <div class="w-100">
                                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                                    <!--text-->
                                    <div class='span12 e-span12' style=' <?php echo $css_margin . " " . $css_margin_font ?>'>
                                        <font><u>ความรับผิดต่อบุคคลภายนอก</u></font>
                                    </div>
                                </div>
                                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
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
                                <div class='span12 e-span12' style='<?php echo $css_margin ?>border-bottom: 1px solid;'>
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
                                <div class='span12 e-span12' style='<?php echo $css_margin ?>border-bottom: 1px solid;'>
                                    <!--text-->
                                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                        <font style='<?php echo $css_margin_font_tab ?>'>- ความเสียหายต่อทรัพสิน
                                        </font>
                                    </div>
                                    <!--number-->
                                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                        <font style='<?php echo $css_margin_font_tab_right ?>' id='damage_cost_inform_show'>
                                            2500000
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
                                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                                    <!--text-->
                                    <div class='span12 e-span12' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                        <font><u>ความคุ้มครองตามเอกสารแนบท้าย</u></font>
                                    </div>
                                </div>

                                <div class='span12 e-span12' style='<?php echo $css_margin ?>border-bottom: 1px solid;'>
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
                                <div class='span12 e-span12' style='<?php echo $css_margin ?>border-bottom: 1px solid;'>
                                    <!--text-->
                                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                        <font style='<?php echo $css_margin_font_tab ?>'>- ผู้โดยสาร</font>
                                        <font style='' id='people_inform_show'></font>
                                        <font style=''>คน</font>
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
                                <div class='span12 e-span12' style='<?php echo $css_margin ?>border-bottom: 1px solid;'>
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
                                <div class='span12 e-span12' style='<?php echo $css_margin ?>border-bottom: 1px solid;'>
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

            <!--ความคุ้มครองแบบ INPUT-->
            <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab_right ?>'>ทุนประกันภัย</font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <input class='w-100' type="text" id="cost_inform" name="cost_inform" onkeyup='protection_html_start();' value='<?php echo number_format($data_renew[0]); ?>'>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                    </div>
                </div>
                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font><U>ความรับผิดต่อบุคคลภายนอก</U></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                </div>
                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>- ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย
                        </font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <select class='w-100' name="damage_out1_inform" id="damage_out1_inform" onchange='protection_html_start();'>
                            <?php if (!empty($protection_array['life'])) { ?>
                                <option value="<?php echo number_format($protection_array['life']); ?>">
                                    <?php echo number_format($protection_array['life']); ?></option>
                            <?php } ?>
                            <option value="N">เลือกความคุ้มครอง</option>
                            <?php for ($s = 100000; $s <= 20000000; $s += 100000) { ?>
                                <option value="<?php echo number_format($s); ?>"><?php echo number_format($s); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>บาท/คน</font>
                    </div>
                </div>
                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>- ความเสียหายต่อทรัพย์สิน</font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <select value="N" class='w-100' name="damage_cost_inform" id="damage_cost_inform" onchange='protection_html_start();'>
                            <?php if (!empty($protection_array['asset'])) { ?>
                                <option value="<?php echo number_format($protection_array['asset']); ?>">
                                    <?php echo number_format($protection_array['asset']); ?></option>
                            <?php } ?>
                            <option value="N">เลือกความคุ้มครอง</option>

                            <?php for ($a = 100000; $a <= 10000000; $a += 100000) { ?>
                                <option value="<?php echo number_format($a); ?>"><?php echo number_format($a); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>บาท/ครั้ง</font>
                    </div>
                </div>
                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font><U>ความคุ้มครองตามเอกสารแนบท้าย</U></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                </div>
                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>- ผู้ขับขี่ 1 คน</font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <select class='w-100' name="pa1_inform" id="pa1_inform" onchange='protection_html_start();'>
                            <?php if (!empty($protection_array['driver'])) { ?>
                                <option value="<?php echo number_format($protection_array['driver']); ?>">
                                    <?php echo number_format($protection_array['driver']); ?></option>
                            <?php } ?>
                            <option value="N">เลือกความคุ้มครอง</option>
                            <?php for ($a = 50000; $a <= 10000000; $a += 50000) { ?>
                                <option value="<?php echo number_format($a); ?>"><?php echo number_format($a); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                    </div>
                </div>
                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <div class='span4 e-span4' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>- ผู้โดยสาร</font>
                        </div>
                        <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                            <input class='w-100' id="people_inform" type="text" name="people_inform" onkeyup='protection_html_start();' value='<?php echo number_format($protection_array['tickets']); ?>'>
                        </div>
                        <div class='span4 e-span4' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>คน</font>
                        </div>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <select class='w-100' id="pa2_inform" name="pa2_inform" onchange='protection_html_start();'>
                            <?php if (!empty($protection_array['passenger'])) { ?>
                                <option value="<?php echo number_format($protection_array['passenger']); ?>">
                                    <?php echo number_format($protection_array['passenger']); ?></option>
                            <?php } ?>
                            <option value="N">เลือกความคุ้มครอง</option>
                            <?php for ($a = 50000; $a <= 10000000; $a += 50000) { ?>
                                <option value="<?php echo number_format($a); ?>"><?php echo number_format($a); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>บาท/คน</font>
                    </div>
                </div>
                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>- ค่ารักษาพยาบาล</font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <select class='w-100' id="pa3_inform" name="pa3_inform" onchange='protection_html_start();'>
                            <?php if (!empty($protection_array['nurse'])) { ?>
                                <option value="<?php echo number_format($protection_array['nurse']); ?>">
                                    <?php echo number_format($protection_array['nurse']); ?></option>
                            <?php } ?>
                            <option value="N">เลือกความคุ้มครอง</option>
                            <?php for ($a = 50000; $a <= 10000000; $a += 50000) { ?>
                                <option value="<?php echo number_format($a); ?>"><?php echo number_format($a); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>บาท/คน</font>
                    </div>
                </div>
                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>- การประกันตัวผู้ขับขี่ในคดีอาญา</font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <select class='w-100' id="pa4_inform" name="pa4_inform" onchange='protection_html_start();'>
                            <?php if (!empty($protection_array['insuran'])) { ?>
                                <option value="<?php echo number_format($protection_array['insuran']); ?>">
                                    <?php echo number_format($protection_array['insuran']); ?></option>
                            <?php } ?>
                            <option value="N">เลือกความคุ้มครอง</option>
                            <?php for ($a = 50000; $a <= 10000000; $a += 50000) { ?>
                                <option value="<?php echo number_format($a); ?>"><?php echo number_format($a); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>บาท/ครั้ง</font>
                    </div>
                </div>
                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>- ความเสียหายส่วนแรก</font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                            <select class='w-100' name="none_disone_inform" id="none_disone_inform" onchange='protection_html_start();'>
                                <option value="0">กรุณาเลือก</option>
                                <option value="ไม่มี" selected>ไม่มี</option>
                                <option value="มี">มี</option>
                            </select>
                        </div>
                        <div class='span6 e-span6' style='<?php echo $css_margin ?> display:none;' id='one_inform_show'>
                            <input class='w-100' type="text" id="one_inform" name="one_inform" value='' onkeyup='protection_html_start();' />
                        </div>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                    </div>
                </div>
            </div>
        </div>
        <!--END-->

        <!--ข้อมูลประกันภัย-->
        <div class='design-ti span12' style='<?php echo $css_margin ?> display: none;'>
            <div class='font-resize-ti span3' style='margin-top:10px;margin-left:10px;'>
                <font style='color:#FFFFFF;'>ข้อมูลเบี้ยประกันภัย</font>
            </div>
        </div>
        <div class='design-form span12' style='<?php echo $css_margin ?> margin-bottom:10px; display: none;'>
            <div class='grid grid-cols-1 gap-6 sm:grid-cols-2' style='padding-left: 1rem;padding-right: 1rem;'>
                <div class="flex">
                    <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'></font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab_right ?>'>ประเภทเบี้ย</font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                            <select name="product_inform" id="product_inform" class='w-100'>
                                <option value="N">-- กรุณาเลือก --</option>
                                <option value="" selected>เบี้ยปกติ</option>
                                <option value="C">Campaign</option>
                                <option value="S">Single Rate</option>
                                <option value="V">V-Premuim</option>
                            </select>
                            <input type="hidden" value="Y" name="single_rate">
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'></font>
                        </div>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'></font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?> <?php echo $display_hide ?>'>
                            <font style=''><U>ส่วนลด</U></font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'></font>
                        </div>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'></font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>จำนวนผู้ขับขี่</font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                            <select class='w-100' name="rdodriver_inform" id="rdodriver_inform">
                                <option value="0">-- กรุณาเลือก --</option>
                                <option value="N" selected>ไม่ระบุ</option>
                                <option value="1">1 คน</option>
                                <option value="2">2 คน</option>
                            </select>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'></font>
                        </div>
                    </div>
                    <!--ผู้ขับขี่ที่1-->
                    <div class='span12 e-span12 bk-event' style='<?php echo $css_margin ?> display:none;' id='driver1_inform'>
                        <div class='span2 e-span2' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'><u>ผู้ขับขี่คนที่ 1</u></font>
                        </div>
                        <div class='span10 w-100' style='<?php echo $css_margin ?>'>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>คำนำหน้า :</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <select id="title_num1_inform" name="title_num1_inform" class='w-100'>
                                        <option value="0" selected="0">--เลือกคำนำหน้า--</option>
                                        <?php
                                        $select_titlename_sql = "SELECT * FROM tb_titlename";
                                        $select_titlename_query = PDO_CONNECTION::fourinsure_insured()->query($select_titlename_sql);
                                        foreach ($select_titlename_query->fetchAll(2) as $select_titlename_array) { ?>
                                            <option value='<?php echo $select_titlename_array['prename'] ?>'>
                                                <?php echo $select_titlename_array['prename'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>ชื่อจริง :</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <input type='text' name="name_num1_inform" id="name_num1_inform" class='w-100' maxlength="100" value=''>
                                </div>
                            </div>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>นามสกุล :</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <input type='text' name="last_num1_inform" id="last_num1_inform" class='w-100' maxlength="50" value=''>
                                </div>
                            </div>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>วันเกิด :</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <input type='text' name="birth_num1_inform" id="birth_num1_inform" class='w-100' maxlength="50" value=''>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--ผู้ขับขี่ที่1 END-->

                    <!--ผู้ขับขี่ที่2-->
                    <div class='span12 e-span12 bk-event' style='<?php echo $css_margin ?> display:none;' id='driver2_inform'>
                        <div class='span2 e-span2' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'><u>ผู้ขับขี่คนที่ 2</u></font>
                        </div>
                        <div class='span10 w-100' style='<?php echo $css_margin ?>'>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>คำนำหน้า :</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <select id="title_num2_inform" name="title_num2_inform" class='w-100'>
                                        <option value="0" selected="0">--เลือกคำนำหน้า--</option>
                                        <?php
                                        $select_titlename_sql = "SELECT * FROM tb_titlename";
                                        $select_titlename_query = PDO_CONNECTION::fourinsure_insured()->query($select_titlename_sql);
                                        foreach ($select_titlename_query->fetchAll(2) as $select_titlename_array) { ?>
                                            <option value='<?php echo $select_titlename_array['prename'] ?>'>
                                                <?php echo $select_titlename_array['prename'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>ชื่อจริง :</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <input type='text' name="name_num2_inform" id="name_num2_inform" class='w-100' maxlength="100" value=''>
                                </div>
                            </div>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>นามสกุล :</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <input type='text' name="last_num2_inform" id="last_num2_inform" class='w-100' maxlength="50" value=''>
                                </div>
                            </div>
                            <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                                <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                                    <font style='<?php echo $css_margin_font_tab ?>'>วันเกิด :</font>
                                </div>
                                <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                    <input type='text' name="birth_num2_inform" id="birth_num2_inform" class='w-100' maxlength="50" value=''>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--ผู้ขับขี่ที่2 END-->

                    <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'></font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>1. ส่วนลดผู้ขับขี่</font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                            <input class='w-100' id="pro_dis_inform" value="0" class='span2' type="hidden" name="pro_dis_inform" onkeyup="javascript:calcfunc_inform();">
                            <input class='w-100' name="total_pro_dis_inform" type="hidden" id="total_pro_dis_inform" value="0">
                            <input class='w-100' type="hidden" id="pro_dis2_inform" name="pro_dis2_inform" onkeyup="javascript:calcfunc_inform(); javascript:total_pro_dis.value=pro_dis2.value;" value="0.00">
                            <input class='w-100' value="0.00" onkeyup="javascript:calcfunc_inform();" type="text" id="driver_inform" name="driver_inform">
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                        </div>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'></font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>2. ส่วนลดความเสียหายส่วนแรก</font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                            <input type="text" id="disone_inform" name="disone_inform" value="0.00" class='w-100' onkeyup="javascript:calcfunc_inform();">
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                        </div>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'></font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>3. กลุ่มตั้งแต่ 3 > ส่วนลด</font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                            <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                <select onchange="javascript:calcfunc_inform();" class='w-100' id="group3_inform" name="group3_inform">
                                    <option selected="selected" value="0">ส่วนลด</option>
                                    <option value="5">5%</option>
                                    <option value="10">10%</option>
                                </select>
                            </div>
                            <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                <input class='w-100' type="text" id="dis_group3_inform" value="0.00" name="dis_group3_inform" readonly style='text-align:right;'><input name="total_dis4_inform" type="hidden" id="total_dis4_inform" value="0" class='w-100' style='text-align:right;'>
                            </div>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                        </div>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'></font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>4. ประวัติดีเป็น %</font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                            <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                <input name="total_dis2_inform" type="hidden" id="total_dis2_inform" value="0" class='w-100'>
                                <select onchange="javascript:calcfunc_inform();" class='w-100' id="good_inform" name="good_inform" align='right'>
                                    <option selected="selected" value="0">ส่วนลด</option>
                                    <option value="5">5%</option>
                                    <option value="10">10%</option>
                                    <option value="15">15%</option>
                                    <option value="20">20%</option>
                                    <option value="25">25%</option>
                                    <option value="30">30%</option>
                                    <option value="35">35%</option>
                                    <option value="40">40%</option>
                                    <option value="45">45%</option>
                                    <option value="50">50%</option>
                                </select>
                            </div>
                            <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                                <input type="text" id="goodb_inform" value="0.00" name="goodb_inform" class='w-100' readonly style='text-align:right;'>
                            </div>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                        </div>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'></font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab_right ?>'>เบี้ยสุทธิ หักส่วนลด</font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                            <input value="0.00" class='w-100' type="text" id="total_pre_inform" name="total_pre_inform" readonly style='text-align:right;'>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                        </div>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'></font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab_right ?>'>อากร</font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                            <input class='w-100' type="text" id="total_stamp_inform" name="total_stamp_inform" value="0.00" readonly style='text-align:right;'>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                        </div>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'></font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab_right ?>'>ภาษี 7%</font>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                            <input class='w-100' type="text" id="total_vat_inform" name="total_vat_inform" value="0.00" readonly style='text-align:right;'>
                        </div>
                        <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex">
                <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab_right ?>'>หัก ณ ที่จ่าย</font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                            <input name="currentText_prb_inform" type="hidden" id="currentText_prb_inform" class='w-100' value="<?php if (!empty($id_act_data)) {
                                                                                                                                    echo $id_act_data;
                                                                                                                                } else {
                                                                                                                                    echo "--ไม่รวม--";
                                                                                                                                } ?>">
                            <select id="vat1_inform" onchange="javascript:calcfunc_inform();" name="vat1_inform" class='w-100'>
                                <option value="0">ไม่มี</option>
                                <option value="1">1%</option>
                            </select>
                        </div>
                        <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                            <input value="0.00" class='w-100' type="text" id="vat_1_inform" name="vat_1_inform" readonly style='text-align:right;'>
                        </div>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                    </div>
                </div>
                <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab_right ?>'>หัก ณ ที่จ่าย พ.ร.บ.</font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <input value="0.00" class='w-100' type="text" id="vat_2_inform" name="vat_2_inform" onkeyup="javascript:calcfunc2_inform();" style='text-align:right;'>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                    </div>
                </div>
                <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab_right ?>'>ส่วนลด ตัวแทน</font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <!--ส่วนลดคอมมิชชั่น-->
                        <input name="total_dis3_inform" type="hidden" id="total_dis3_inform" value="0" class='span2'>
                        <select style="display:none" id="dis_vip_inform" onclick="javascript:calcfunc_inform()" name="dis_vip_inform" class='span2'>
                            <option selected="selected" value="0">ลด 0 %</option>
                            <option value="5">5%</option>
                            <option value="8">8%</option>
                            <option value="10">10%</option>
                            <option value="13">13%</option>
                            <option value="15">15%</option>
                            <option value="20">20%</option>
                        </select><input name="total_vip_inform" type="hidden" id="total_vip_inform" value="0" class='span2' style='text-align:right;'>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>%</font>
                    </div>
                </div>
                <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab_right ?>'>ส่วนลดพิเศษ</font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                            <select id="commition_percent_inform" onchange="javascript:com_action();" name="commition_percent_inform" class='w-100'>
                                <?php for ($num = 0; $num <= 100; $num++) { ?>
                                    <option value='<?php echo $num; ?>'><?php echo $num . "%"; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                            <input id="commition_inform" class='w-100' onkeyup="javascript:calcfunc2_inform();" value="0.00" type="text" name="commition_inform" style='text-align:right;'>
                        </div>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                    </div>
                </div>

                <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab_right ?>'>ค่าภาษีรถยนต์รายปี</font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <input id="vehicle_tax_inform" onkeyup="javascript:calcfunc_inform();" value="0.00" size="10" type="text" class='w-100' name="vehicle_tax_inform" style='text-align:right;'>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                    </div>
                </div>
                <div class='span12 e-span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'></font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab_right ?>'>ค่าบริการ</font>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                            <select id="service_charge_inform" name="service_charge_inform" onchange="javascript:calcfunc_inform()" class='w-100'>
                                <option value="0">กรุณาเลือก</option>
                                <option value="0.00" selected>ฟรี</option>
                                <option value="200.00">200.00</option>
                            </select>
                        </div>
                        <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                            <input name="service_charge_value_inform" type="text" id="service_charge_value_inform" value="0.00" class='w-100' readonly="true" style='text-align:right;'>
                        </div>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>บาท</font>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--END-->

    <!--รายละเอียดเพิ่มเติม-->
    <div class='design-ti span12' style='<?php echo $css_margin ?> <?php echo $display_hide ?>'>
        <div class='font-resize-ti span3' style='margin-top:10px;margin-left:10px;'>
            <font style='color:#FFFFFF;'>รายละเอียดเพิ่มเติม</font>
        </div>
    </div>
    <div class='design-form span12' style='<?php echo $css_margin ?> margin-bottom:20px; <?php echo $display_hide ?>'>

        <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
            <font style='<?php echo $css_margin_font_tab ?>'><input id="commentse1_inform" type="checkbox" onclick="comment(this.value);" value="1" name="commentse1_inform">&nbsp;นัดตรวจสภาพรถ</font>
        </div>
        <!--commentse1_inform-->
        <div class='span12 e-span12 bk-event' style='<?php echo $css_margin ?> display:none;' id='comment1_inform'>
            <div class='span12 e-span12' style='<?php echo $css_margin ?>'>

                <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>วันที่ :</font>
                        </div>
                        <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                            <input id="checkcar_date_inform" type="text" value="<?php echo date('d/m/Y') ?>" maxlength="10" class='w-100' name="checkcar_date_inform">
                        </div>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>ช่วงเวลา :</font>
                        </div>
                        <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                            <select id="checkcar_time_inform" name="checkcar_time_inform" class='w-100'>
                                <option value="0">กรุณาเลือกเวลา</option>
                                <option value="1">เช้า (08:00 - 12:00)</option>
                                <option value="2">บ่าย (12:00 - 15:00)</option>
                                <option value="3">เย็น (15:00 - 18:00)</option>
                            </select>
                        </div>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>ติดต่อ :</font>
                        </div>
                        <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                            <input type='text' id="contact_name_list_inform" name="contact_name_list_inform" value="" class='w-100'>
                        </div>
                    </div>
                    <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                        <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'>เบอร์โทรศัพท์ :</font>
                        </div>
                        <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                            <input type='text' id="contact_number_inform" style="text-align:left" maxlength="12" class='w-100' name="contact_number_inform" value="">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--commentse1_inform end-->
        <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
            <font style='<?php echo $css_margin_font_tab ?>'><input id="commentse2_inform" type="checkbox" onclick="comment(this.value);" value="2" name="commentse2_inform">&nbsp;ส่งกรมธรรม์</font>
        </div>
        <!--commentse2_inform-->
        <div class='span12 e-span12 bk-event' style='<?php echo $css_margin ?> display:none;' id='comment2_inform'>
            <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    <font style='<?php echo $css_margin_font_tab ?>'><input id="check_1_inform" type="radio" value="1" name="check_R1_inform">&nbsp;พร้อมเก็บเงิน</font></br>
                    <font style='<?php echo $css_margin_font_tab ?>'><input id="check_2_inform" type="radio" value="2" name="check_R1_inform">&nbsp;พร้อมวางบิล</font>
                </div>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>วันที่ :</font>
                    </div>
                    <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                        <input id="date_SP_inform" type="text" value="<?php echo date('d/m/Y') ?>" maxlength="10" class='w-100' name="date_SP_inform">
                    </div>
                </div>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>ติดต่อ :</font>
                    </div>
                    <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                        <input type='text' id="contact_name_list_1_inform" name="contact_name_list_1_inform" value="" class='w-100'>
                    </div>
                </div>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>เบอร์โทรศัพท์ :</font>
                    </div>
                    <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                        <input type='text' id="contact_number_1_inform" maxlength="12" class='w-100' name="contact_number_1_inform" value="">
                    </div>
                </div>
            </div>
        </div>
        <!--commentse2_inform end-->
        <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
            <font style='<?php echo $css_margin_font_tab ?>'><input id="commentse3_inform" type="checkbox" onclick="comment(this.value);" value="3" name="commentse3_inform">&nbsp;จ่ายแล้ว</font>
        </div>
        <!--commentse3_inform-->
        <div class='span12 e-span12 bk-event' style='<?php echo $css_margin ?>' id='comment3_inform'>
            <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    <font style='<?php echo $css_margin_font_tab ?>'><input id="check_3_inform" type="radio" value="3" name="check_R2_inform">&nbsp;จ่ายเข้าบริษัท</font></br>
                    <font style='<?php echo $css_margin_font_tab ?>'><input id="check_4_inform" type="radio" value="4" name="check_R2_inform">&nbsp;จ่ายเข้าบริษัทประกัน</font>
                </div>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>วันที่ชำระ :</font>
                    </div>
                    <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                        <input id="payment_date_inform" type="text" value="<?php echo date('d/m/Y') ?>" maxlength="10" class='w-100' name="payment_date_inform">
                    </div>
                </div>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>วิธีชำระ :</font>
                    </div>
                    <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                        <select id="payment_1_inform" name="payment_1_inform" class='w-100'>
                            <option value="0">วิธีชำระเงิน</option>
                            <option value="1">เงินสด</option>
                            <option value="2">เช็ค</option>
                            <option value="3">ตัดบัตรเครดิตเต็มจำนวน</option>
                            <option value="4">Bill Payment</option>
                            <!--<option value="5">ผ่อนชำระ</option>-->
                            <option value="6">ผ่อนชำระ 0%</option>
                            <option value="7">counter service</option>
                            <option value="8">แบ่งชำระเงินสด</option>
                        </select>
                        <select id="instance_1_inform" name="instance_1_inform" style="display:none;" class='w-100'>
                            <option value="0">งวดชำระ</option>
                            <option value="3">3 งวด</option>
                            <option value="6">6 งวด</option>
                        </select>
                        <select id="instance_1_cut_inform" name="instance_1_cut_inform" style="display:none;" class='w-100'>
                            <option value="0">งวดชำระ</option>
                            <option value="2">2 งวด</option>
                            <option value="3">3 งวด</option>
                            <option value="4">4 งวด</option>
                        </select>
                    </div>
                </div>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>ธนาคาร :</font>
                    </div>
                    <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                        <select id="bankoperation_1_inform" name="bankoperation_1_inform" class='w-100'>
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
                    </div>
                </div>
            </div>
        </div>
        <!--commentse3_inform end-->
        <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
            <font style='<?php echo $css_margin_font_tab ?>'><input id="commentse4_inform" type="checkbox" onclick="comment(this.value)" value="4" name="commentse4_inform">&nbsp;กำลังทำจ่าย</font>
        </div>
        <!--commentse4_inform-->
        <div class='span12 e-span12 bk-event' style='<?php echo $css_margin ?>' id='comment4_inform'>
            <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    <font style='<?php echo $css_margin_font_tab ?>'><input id="check_5_inform" type="radio" value="5" name="check_R3_inform">&nbsp;จ่ายเข้าบริษัท</font><br>
                    <font style='<?php echo $css_margin_font_tab ?>'><input id="check_6_inform" type="radio" value="6" name="check_R3_inform">&nbsp;จ่ายเข้าบริษัทประกัน</font>
                </div>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>วันที่ชำระ :</font>
                    </div>
                    <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                        <input id="payment_in_inform" type="text" value="<?php echo date('d/m/Y') ?>" maxlength="10" class='w-100' name="payment_in_inform">
                    </div>
                </div>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>วิธีชำระ :</font>
                    </div>
                    <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                        <select id="payment_2_inform" name="payment_2_inform" class='w-100'>
                            <option value="0">วิธีชำระเงิน</option>
                            <option value="1">เงินสด</option>
                            <option value="2">เช็ค</option>
                            <option value="3">ตัดบัตรเครดิตเต็มจำนวน</option>
                            <option value="4">Bill Payment</option>
                            <!--<option value="5">ผ่อนชำระ</option>-->
                            <option value="6">ผ่อนชำระ 0%</option>
                            <option value="7">counter service</option>
                            <option value="8">แบ่งชำระเงินสด</option>
                        </select>
                        <select id="instance_2_inform" name="instance_2_inform" style="display:none;" class='w-100'>
                            <option value="0">งวดชำระ</option>
                            <option value="3">3 งวด</option>
                            <option value="6">6 งวด</option>
                        </select>
                        <select id="instance_2_cut_inform" name="instance_2_cut_inform" style="display:none;" class='w-100'>
                            <option value="0">งวดชำระ</option>
                            <option value="2">2 งวด</option>
                            <option value="3">3 งวด</option>
                            <option value="4">4 งวด</option>
                        </select>
                    </div>
                </div>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>ธนาคาร :</font>
                    </div>
                    <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                        <select id="bankoperation_2_inform" name="bankoperation_2_inform" class='w-100'>
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
                    </div>
                </div>
            </div>
            <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>

                </div>
                <div class='span3 e-span3' style='<?php echo $css_margin ?>'>
                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>เบอร์โทรศัพท์ :</font>
                    </div>
                    <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                        <input id="contact_number_2_inform" type='text' maxlength="12" class='w-100' name="contact_number_2_inform" value="">
                    </div>
                </div>
            </div>
        </div>
        <!--commentse4_inform end-->
        <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
            <font style='<?php echo $css_margin_font_tab ?>'><input id="commentse5_inform" checked type="checkbox" onclick="comment(this.value)" value="5" name="commentse5_inform">&nbsp;ยังไม่จ่าย</font>
        </div>
        <!--commentse5_inform-->
        <div class='span12 e-span12 bk-event' style='<?php echo $css_margin ?> display:none;' id='comment5_inform'>
            <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'><input id="check_7_inform" type="radio" value="7" name="check_R4_inform">&nbsp;นัดอีกครั้ง</font>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'><input id="check_8_inform" type="radio" value="8" name="check_R4_inform">&nbsp;วางบิลบริษัท</font>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'><input id="check_9_inform" type="radio" checked value="9" name="check_R4_inform">&nbsp;วางบิลคู่ค้า/ดิลเลอร์</font>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'><input id="check_10_inform" type="radio" value="10" name="check_R4_inform">&nbsp;วางบิลตัวแทน</font>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                        <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                            <font style='<?php echo $css_margin_font_tab ?>'><input id="check_11_inform" type="radio" value="11" name="check_R4_inform">&nbsp;บิล เครดิต</font>
                        </div>
                        <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                            <select id="D_day_inform" name="D_day_inform" class='w-100'>
                                <option value="0">เลือก</option>
                                <option value="1">15 วัน</option>
                                <option value="2">30 วัน</option>
                                <option value="3">45 วัน</option>
                                <option value="4">60 วัน</option>
                            </select>
                        </div>
                    </div>
                    <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'><input id="check_12_inform" type="radio" value="12" name="check_R4_inform">&nbsp;ออก กธ. แล้ว</font>
                    </div>
                </div>
                <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>ติดต่อ :</font>
                    </div>
                    <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                        <input type='text' id="contact_name_list_3_inform" name="contact_name_list_3_inform" value="-" class='w-100'>
                    </div>
                </div>
                <div class='span4 e-span4' style='<?php echo $css_margin ?>'>
                    <div class='span6 e-span6' style='<?php echo $css_margin . " " . $css_margin_font ?>'>
                        <font style='<?php echo $css_margin_font_tab ?>'>เบอร์โทรศัพท์ :</font>
                    </div>
                    <div class='span6 e-span6' style='<?php echo $css_margin ?>'>
                        <input type='text' id="contact_number_3_inform" maxlength="12" name="contact_number_3_inform" value="-" class='w-100'>
                    </div>
                </div>
            </div>
        </div>
        <!--commentse5_inform end-->
        <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
            <font style='<?php echo $css_margin_font_tab ?>'><input id="commentse6_inform" type="checkbox" onclick="comment(this.value)" value="6" name="commentse6_inform">&nbsp;อื่นๆ</font>
        </div>
        <!--commentse6_inform-->
        <div class='span12 e-span12 bk-event' style='<?php echo $css_margin ?> display:none;' id='comment6_inform'>
            <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
                <font style='<?php echo $css_margin_font_tab ?>'>
                    <textarea rows="3" style="width:40%" rows='4' id="other_s_inform" name="other_s_inform" class='span6'></textarea>
                </font>
            </div>
        </div>
        <!--commentse6_inform end-->
        <div class='span12 e-span12' style='<?php echo $css_margin ?>'>
            <font style='<?php echo $css_margin_font_tab ?>'><input id="commentse7_inform" type="checkbox" onclick="comment(this.value)" value="7" name="commentse7_inform">&nbsp;แมสวิ่งพร้อมเก็บเงิน
            </font>
        </div>
        <!--commentse7_inform-->
        <!--commentse7_inform end-->
    </div>
    <!--END-->
    </div>
</form>


<script>
    $('.hide').hide();

    async function postApiAsyncDealer(_data, _url) //postapi
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


    function handleChangeTitle() {
        var _title = document.getElementsByClassName("class_title_inform")[0].value;
        var _person = document.getElementById('person_inform').value;
        console.log(_title);
        if (_person == '2') {
            if (_title.trim() == "บริษัท") {
                document.getElementById("last_inform").value = "จำกัด";
                document.getElementById("show_last_form").style.display = "inline";
                document.getElementById("show_last_form").style = "width: 10%";
            } else {
                document.getElementById("last_inform").value = ".";
                document.getElementById("show_last_form").style.display = "none";
            }
        }
        if (_person == '1') {
            document.getElementById("show_last_form").classList.add("w-20");
            document.getElementById("show_last_form").style.width = null;
        }
    }

    async function loadTitle() {
        let _type = document.getElementById("person_inform").value;
        const res = await postApiAsyncDealer({
            Controller: 'TitleOption',
            Type: _type
        }, 'services/Title/title.controller.php');

        if (res.Data == null) return false;

        const titleInformElem = document.querySelector(".class_title_inform");
        titleInformElem.innerHTML = '';

        res.Data.forEach((element) => {
            const op = document.createElement("option");
            op.text = element;
            op.value = element;
            titleInformElem.appendChild(op);
        });
    }
    loadTitle();

    async function setprefix(e) {
        emptyInput();
        if (e.value == 1) {
            document.getElementById("last_inform").value = "";
            document.getElementById("name_lb").innerHTML = "";
            document.getElementById("name_lb").innerHTML = "ชื่อ";
            document.getElementById("last_lb").innerHTML = "";
            document.getElementById("last_lb").innerHTML = "นามสกุล";
            document.getElementById("show_last_form").style.width = null;
            document.getElementById("show_last_form").style.display = "inline";
        } else {
            document.getElementById("name_inform").value = "";
            document.getElementById("name_lb").innerHTML = "";
            document.getElementById("last_lb").innerHTML = ".";
            document.getElementById("name_lb").innerHTML = "(ชื่อกรรมการ)โดย(ชื่อบริษัท)";
            document.getElementById("show_last_form").style.display = "none";
        }
        $('#icard_inform').val('');
        const res = await postApiAsyncDealer({
            Controller: 'TitleOption',
            Type: e.value
        }, 'services/Title/title.controller.php');

        if (res.Data == null) return false;

        const titleInformElem = document.querySelector(".class_title_inform");
        titleInformElem.innerHTML = '';
        $('.class_title_inform').append(`<option value='0' selected disabled>กรุณาเลือก</option>`);
        res.Data.forEach((element) => {
            const op = document.createElement("option");
            op.text = element;
            op.value = element;
            titleInformElem.appendChild(op);
        });
    }

    function emptyInput() {
        document.getElementById("icard1").value = "";
        document.getElementById("icard2").value = "";
        document.getElementById("icard3").value = "";
        document.getElementById("icard4").value = "";
        document.getElementById("icard5").value = "";
        document.getElementById("icard6").value = "";
        document.getElementById("icard7").value = "";
        document.getElementById("icard8").value = "";
        document.getElementById("icard9").value = "";
        document.getElementById("icard10").value = "";
        document.getElementById("icard11").value = "";
        document.getElementById("icard12").value = "";
        document.getElementById("icard13").value = "";
        document.getElementById("icard1").focus();
    }

    async function showCardBlackLabel() {
        let regis = await $('#icard_inform').val();
        let indexInput = 1;
        for (let i = 0; i < regis.length; i++) {
            let x = regis.charAt(i);
            if (x !== '') {
                $(`#icard${indexInput}`).val(x);
                indexInput++;
            }
        }
    }

    showCardBlackLabel();

    function onkey_icard(id_Next_Elem, id_Elem, event) {
        var icard;
        if (event.which == 37 || event.which == 38 || event.which == 39 || event.which == 40 || event.which == 32 || event
            .which == 9) {
            if (event.which == 32) {
                $("#" + id_Elem).val('');
            }
            return false;
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
        if ($("#" + id_Elem).val().search(/^[0-9]{0,9}$/)) {
            $("#" + id_Elem).val('');
            $("#" + id_Elem).focus();
            return false;
        }
        if (id_Next_Elem != '' && $("#" + id_Elem).val() != '') {
            $("#" + id_Next_Elem).val('');
            $("#" + id_Next_Elem).focus();

        }
        icard = $("#icard1").val() + '' + $("#icard2").val() + '' + $("#icard3").val() + '' + $("#icard4").val() + '' +
            $(
                "#icard5").val() + '' + $("#icard6").val() + '' + $("#icard7").val() + '' + $("#icard8").val() + '' + $(
                "#icard9").val() + '' + $("#icard10").val() + '' + $("#icard11").val() + '' + $("#icard12").val() + '' +
            $(
                "#icard13").val();
        $("#icard_inform").val(icard);
    }

    $(document).ready(function() {
        var chkId = $('#chkId_inform').val();
        var chkDealer = $('#chkDealer_inform').val();
        var chkCaryear = $('#chkCaryear_inform').val();
        var chkCartype = $('#chkCartype_inform').val();
        var chkCatcar = $('#chkCatcar_inform').val();
        var chkBr_car = $('#chkBr_car_inform').val();
        var chkMo_car = $('#chkMo_car_inform').val();
        var chkCc = $('#chkCc').val();

        if (chkId != '') {

            if (chkCc == '1') {
                //$('#cc_inform').val('1999'); // ต่ำกว่า 2000ซีซี
            } else {
                //  $('#cc_inform').val('2001');// มากกว่า 2000ซีซี
            }
            $('#customer_inform').val('2');
            if (chkCatcar != undefined) {
                var arCatCar = chkCatcar.split("|");
                var arBrCar = chkBr_car.split("|");
                var arMoCar = chkMo_car.split("|");
                $('#car_id_inform').append("<option value='" + arCatCar[0] + "'>" + arCatCar[1] + "</option>");
                $('#br_car_inform').append("<option value='" + arBrCar[0] + "'>" + arBrCar[1] + "</option>");
                $('#mo_car_inform').append("<option value='" + arMoCar[0] + "'>" + arMoCar[1] + "</option>");
            }
            $('select[id="regis_date_inform"]').val(chkCaryear);
            $('#chkId_inform').val('');
        }
    });

    $("input").keypress(function(evt) {
        var charCode = evt.charCode || evt.keyCode;
        if (charCode == 13) {
            return false;
        }
    });

    $(document).keydown(function(e) {
        var preventKeyPress;
        if (e.keyCode == 8) {
            var d = e.srcElement || e.target;
            switch (d.tagName.toUpperCase()) {
                case 'TEXTAREA':
                    preventKeyPress = d.readOnly || d.disabled;
                    break;
                case 'INPUT':
                    preventKeyPress = d.readOnly || d.disabled ||
                        (d.attributes["type"] && $.inArray(d.attributes["type"].value.toLowerCase(), ["radio",
                            "checkbox", "submit", "button"
                        ]) >= 0);
                    break;
                case 'DIV':
                    preventKeyPress = d.readOnly || d.disabled || !(d.attributes["contentEditable"] && d
                        .attributes[
                            "contentEditable"].value == "true");
                    break;
                default:
                    preventKeyPress = true;
                    break;
            }
        } else {
            preventKeyPress = false;
        }
        if (preventKeyPress) {
            e.preventDefault();
        }
    });

    function onChange(object) {
        //alert(object.select_prb_inform.selectedIndex);
        var prbNet = {
            <?php echo $array_pre; ?>
        };
        var Current = object.agent_inform.selectedIndex;
        var Current2 = $('#agent_inform').val();
        var arrayFromPHP = <?php echo json_encode($discountuse); ?>;

        var Current_prb = object.select_prb_inform.selectedIndex;
        $('#currentText_inform').val($('#agent_inform').val());
        object.currentValue_inform.value = 0;
        // alert( object.currentValue_inform.value);
        object.currentText_prb_inform.value = object.select_prb_inform.options[Current_prb].text;
        object.currentValue_prb_inform.value = object.select_prb_inform.options[Current_prb].value;
        if (Current_prb == '0') {
            $('#prbNet_inform').val('0');
        } else {
            $('#prbNet_inform').val(prbNet[Current_prb]);
        }

    }


    $(document).ready(function() {
        $('#SendAdd1_inform').click(function() {
            $('#Send2_inform').slideUp();
            $("#SendAdd_2_inform").val('');
        });
        $('#SendAdd2_inform').click(function() {
            $('#Send2_inform').slideDown();
            $("#SendAdd_2_inform").val('');
        });
    });


    $('#inp1_inform').iMask({
        type: 'number'
    });
    $('#pre_inform').iMask({
        type: 'number'
    });
    $('#pro_dis_inform').iMask({
        type: 'number',
        decDigits: 0,
        decSymbol: ''
    });
    $('#goodb_inform').iMask({
        type: 'number'
    });
    $('#pro_dis2_inform').iMask({
        type: 'number'
    });
    $('#inp3_inform').iMask({
        type: 'number'
    });
    $('#inp4_inform').iMask({
        type: 'number'
    });

    $('#inp8_inform').iMask({
        type: 'number'
    });
    $('#cost_inform').iMask({
        type: 'number',
        decDigits: 0,
        decSymbol: ''
    });
    $('#inp10_inform').iMask({
        type: 'number'
    });
    $('#inp11_inform').iMask({
        type: 'number'
    });
    $('#inp12_inform').iMask({
        type: 'fixed',
        mask: '99/99/99'
    });
    $('#inp13_inform').iMask({
        type: 'fixed',
        mask: '999-999-9999'
    });
    $('#inp16_inform').iMask({
        type: 'fixed',
        mask: '999-999-9999'
    });
    $('#tel_mobile_inform').mask("999-999-9999");
    $('#tel_mobile2_inform').mask("999-999-9999");
    $('#commition_inform').iMask({
        type: 'number'
    });
    $('#vehicle_tax_inform').iMask({
        type: 'number'
    });
    $('#vat_2_inform').iMask({
        type: 'number'
    });
    $('#inp15_inform').iMask({
        type: 'number'
    });
    $('#driver_inform').iMask({
        type: 'number'
    });
    $('#one_inform').iMask({
        type: 'number',
        decDigits: 0,
        decSymbol: ''
    });
    $('#acccost1_inform').iMask({
        type: 'number'
    });
    $('#acccost2_inform').iMask({
        type: 'number'
    });
    $('#acccost3_inform').iMask({
        type: 'number'
    });
    $('#acccost4_inform').iMask({
        type: 'number'
    });
    $('#disone_inform').iMask({
        type: 'number'
    });
    $('#people_inform').iMask({
        type: 'number',
        decDigits: 0,
        decSymbol: ''
    });

    function showCarAge() {
        var currentTime = new Date();
        //var month = currentTime.getMonth() + 1;
        //var day = currentTime.getDate();
        var year = currentTime.getFullYear();
        var iYear = year - document.getElementById("regis_date_inform").value + 1 + " ปี";
        if (document.getElementById("regis_date_inform").value == "")
            document.getElementById("year_old_inform").value = "";
        else
            document.getElementById("year_old_inform").value = iYear;
    }



    function comment(val) {
        var checkch = "comment" + val + "_inform";
        var checkse = "commentse" + val + "_inform";
        if (document.getElementById(checkse).checked == false) {
            $("#" + checkch).hide('fast');

        } else {
            $("#" + checkch).show('fast');

        }

    }

    var myDate = new Date();
    var prettyDate = myDate.getDate() + '/' + (myDate.getMonth() + 1) + '/' + myDate.getFullYear();
    $("#start_date_inform").datepicker({
        language: "th",
        autoclose: true,
        format: 'dd/mm/yyyy'
        //minDate: prettyDate
    });

    $("#end_date_inform").datepicker({
        language: "th",
        autoclose: true,
        format: 'dd/mm/yyyy'
        //minDate: prettyDate
    });
    $("#vat_car_inform").datepicker({
        language: "th",
        autoclose: true,
        format: 'dd/mm/yyyy'
        //	minDate: prettyDate
    });
    $("#search_start_date_inform").datepicker({
        language: "th",
        autoclose: true,
        format: 'dd/mm/yyyy',
        minDate: prettyDate
    });
    $("#search_end_date_inform").datepicker({
        language: "th",
        autoclose: true,
        format: 'dd/mm/yyyy',
        minDate: prettyDate
    });
    $("#checkcar_date_inform").datepicker({
        language: "th",
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
    $("#date_SP_inform").datepicker({
        language: "th",
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
    $("#payment_date_inform").datepicker({
        language: "th",
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
    $("#payment_in_inform").datepicker({
        language: "th",
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
    $("#pay_date_inform").datepicker({
        language: "th",
        autoclose: true,
        format: 'dd/mm/yyyy'
    });


    $("#type_inform").change(function() {
        var ObjectC = $("#type_inform").val();
        if (ObjectC == 1) {
            $("#searchcus_inform").val('');
            $("#searchcus2_inform").val('');
            $("#searchcus_inform").show('fast');
            $("#searchcus2_inform").show('fast');
            $("#searchcus3_inform").show('fast');
        } else if (ObjectC == 2 || ObjectC == 3) {
            $("#searchcus_inform").val('');
            $("#searchcus2_inform").val('');
            $("#searchcus_inform").show('fast');
            $("#searchcus2_inform").hide('fast');
        }
    });

    $("#none_disone_inform").change(function() {
        var Chosedis = $("#none_disone_inform").val();
        if (Chosedis == "มี") {
            $("#one_inform_show").slideDown('fast');
        } else {
            $("#one_inform").val('0');
            $("#one_inform_show").slideUp();
        }
    });

    $("#rdodriver_inform").change(function() {
        var ObjectC = $("#rdodriver_inform").val();
        if (ObjectC == 'N') {
            $("#driver1_inform").slideUp();

            $("#driver2_inform").slideUp();


        } else if (ObjectC == 1) {
            $("#driver1_inform").slideDown();

            $("#driver2_inform").slideUp('fast');

        } else if (ObjectC == 2) {
            $("#driver1_inform").slideDown();

            $("#driver2_inform").slideDown();

        } else if (ObjectC == 0) {
            $("#driver1_inform").slideUp();

            $("#driver2_inform").slideUp();

        }

    });

    $("#birth_num1_inform").mask("99/99/9999");
    $("#birth_num2_inform").mask("99/99/9999");

    //$("#icard_inform").mask("9999999999999");
    //$("#niti_inform").mask("9999999999999");
    $('#car_body_inform').blur(function() {
        Check_CARBODY();
    });

    function checkID(id) {
        if (id.length != 13) return false;
        for (i = 0, sum = 0; i < 12; i++)
            sum += parseFloat(id.charAt(i)) * (13 - i);
        if ((11 - sum % 11) % 10 != parseFloat(id.charAt(12)))
            return false;
        return true;
    }

    $('#icard_inform').blur(function() {
        if ($('#person_inform').val() == 1 && $('#icard_inform').val() != '') {
            if (!checkID($('#icard_inform').val())) {
                alert('รหัสประชาชนไม่ถูกต้อง');
                $('#icard_inform').val('');
            }
        } else if ($('#person_inform').val() == 0 && $('#icard_inform').val() != '') {
            alert('กรุณาเลือกบุคคล/นิติบุคคล/บุคคลในนามบริษัท');
        }
    });


    //////////////////////////////////////////////////////////////////////////////////////
    $("#chose_carregis_inform").change(function() {
        var ChoseRe = $("#chose_carregis_inform").val();
        if (ChoseRe == 2) {
            $("#showRegis").show('fast');
        } else {
            $("#showRegis").hide('fast');
        }
    });

    if (_car_regis !== 'ป้ายดำ') {
        showRegisBlackLabel();
    }

    function showRegisBlackLabel() {
        let regis = $('#car_regis_inform').val();
        let indexInput = 1;
        for (let i = 0; i < regis.length; i++) {
            // console.log(regis.charAt(i));
            let x = regis.charAt(i);
            if (x !== ' ') {
                $(`#car_regis${indexInput}`).val(x);
                indexInput++;
            }
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


    $("#payment_1_inform").change(function() {
        var ChoseRe3 = $("#payment_1_inform").val();
        if (ChoseRe3 == 2 || ChoseRe3 == 3 || ChoseRe3 == 4 || ChoseRe3 == 5 || ChoseRe3 == 6) {
            $("#bankoperation_1_inform").removeAttr('disabled');
            $("#bankoperation_1_inform").val('');
        } else {
            $("#bankoperation_1_inform").attr('disabled', 'disabled');
            $("#bankoperation_1_inform").val('');
        }
        if (ChoseRe3 == 5 || ChoseRe3 == 6) {
            $("#instance_1_inform").show('fast');
            $("#instance_1_inform").val('');
            $("#instance_1_cut_inform").hide('fast');
            $("#instance_1_cut_inform").val('');
        } else if (ChoseRe3 == 8) {
            $("#instance_1_cut_inform").show('fast');
            $("#instance_1_cut_inform").val('');
        } else {
            $("#instance_1_inform").hide('fast');
            $("#instance_1_inform").val('');
            $("#instance_1_cut_inform").hide('fast');
            $("#instance_1_cut_inform").val('');
        }
    });

    $("#payment_2_inform").change(function() {
        var ChoseRe3 = $("#payment_2_inform").val();
        if (ChoseRe3 == 2 || ChoseRe3 == 3 || ChoseRe3 == 4 || ChoseRe3 == 5 || ChoseRe3 == 6) {
            $("#bankoperation_2_inform").removeAttr('disabled');
            $("#bankoperation_2_inform").val('');
        } else {
            $("#bankoperation_2_inform").attr('disabled', 'disabled');
            $("#bankoperation_2_inform").val('');
        }
        if (ChoseRe3 == 5 || ChoseRe3 == 6) {
            $("#instance_2_inform").show('fast');
            $("#instance_2_inform").val('');
            $("#instance_2_cut_inform").hide('fast');
            $("#instance_2_cut_inform").val('');
        } else if (ChoseRe3 == 8) {
            $("#instance_2_cut_inform").show('fast');
            $("#instance_2_cut_inform").val('');
        } else {
            $("#instance_2_inform").hide('fast');
            $("#instance_2_inform").val('');
            $("#instance_2_cut_inform").hide('fast');
            $("#instance_2_cut_inform").val('');
        }
    });

    $("#province_inform").change(function() {

        $("#tumbon_inform").empty();
        $("#tumbon_inform").append("<option value='0'>กรุณาเลือก</option>");
        $("#id_post_inform").empty();
        $("#id_post_inform").append("<option value='0'>กรุณาเลือก</option>");
        var _selected = $("#province_inform").val();
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

    $("#cartype_inform").change(function() {
        var _selected = $("#cartype_inform").val();
        var options = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_Pro.php",
            data: {
                callajax: 'CARTYPE',
                cartype: _selected
            },
            success: function(msg) {
                $('#car_id_inform').empty();
                var returnedArray = msg;
                car_id = $("#car_id_inform");
                if (returnedArray != null) {
                    for (var i = 0; i < returnedArray.length; ++i) {
                        car_id.append(
                            `<option value='${returnedArray[i].Id}'>${returnedArray[i].Name}</option>`);
                    }
                } else {
                    car_id.append(`<option value='0'>ไม่มีลักษณะการใช้</option>`);
                    return false;
                }
            }
        };
        $.ajax(options);
    });


    $("#cat_car_inform").change(function() {
        var _selected = $("#cat_car_inform").val();
        var options = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_Pro.php",
            data: {
                callajax: 'BR',
                br: _selected
            },
            success: function(msg) {
                $('#br_car_inform').empty();
                var returnedArray = msg;
                br_car = $("#br_car_inform");
                br_car.append("<option value='0'>กรุณาเลือก</option>");
                if (returnedArray != null) {
                    for (var i = 0; i < returnedArray.length; ++i) {
                        br_car.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i]
                            .Name + "</option>");
                    }
                } else {
                    return false;
                }
            }
        };
        $.ajax(options);
    });

    $("#br_car_inform").change(function() {
        var _selected = $("#br_car_inform").val();
        var options = {
            type: "POST",
            dataType: "json",
            url: "ajax/Ajax_Pro.php",
            data: {
                callajax: 'MO',
                mo: _selected
            },
            success: function(msg) {
                $('#mo_car_inform').empty();
                var returnedArray = msg;
                mo_car = $("#mo_car_inform");
                mo_car.append("<option value='0'>กรุณาเลือก</option>");
                if (returnedArray != null) {
                    for (var i = 0; i < returnedArray.length; ++i) {
                        mo_car.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i]
                            .Name + "</option>");
                    }
                } else {
                    return false;
                }
            }
        };
        $.ajax(options);
    });

    $("#act_sort_inform").change(function() {
        var ty_inform = $("#ty_inform").val();
        var act_sort = $("#act_sort_inform").val();
        var doc_type = $("#doc_type_inform").val();
        var com_data = $("#com_data_inform").val();
        var select_prb = $("#select_prb_inform").val();
        if (ty_inform == 'L' && act_sort == 'VIB_S' && doc_type == '1' && select_prb != '0') {
            $("#actCheck_inform").val('0');
        } else if (ty_inform == 'L' && act_sort == 'BKI[MBLT]' && doc_type == '1' && select_prb != '0') {
            $("#actCheck_inform").val('0');
        } else {
            $("#actCheck_inform").val('0');
        }
    });

    function inform_save() {

        if ($("#agent_inform").val() == '') {
            $("#agent_inform").focus();
            alert('กรุณาเลือกตัวแทน');
            return false;
        } else if ((document.getElementById('status_vip1_inform').checked == false) && (document.getElementById(
                'status_vip2_inform').checked == false)) {
            $("#status_vip1_inform").focus();
            alert('กรุณาเลือกประเภทลูกค้า');
            return false;
        } else if ($("#person_inform").val() == '0') {
            $("#person_inform").focus();
            alert('กรุณาเลือกบุคคล');
            return false;
        } else if ($("#person_inform").val() == '3' && $("#niti_inform").val() == '') {
            $("#niti_inform").focus();
            alert('กรุณากรอกเลขที่นิติบุคคล');
            return false;
        } else if ($("#person_inform").val() == '3' && $("#niti_inform").val() == "-") {
            $("#niti_inform").focus();
            alert('กรุณากรอกเลขที่นิติบุคคล');
            return false;
        } else if ($("#icard_inform").val() == '') {
            $("#icard_inform").focus();
            alert('กรุณากรอกเลขบัตรหรือทะเบียนการค้า');
            return false;
        } else if ($("#title_inform").val() == '0') {
            $("#title_inform").focus();
            alert('กรุณาเลือกคำนำหน้า');
            return false;
        } else if ($("#name_inform").val() == '') {
            $("#name_inform").focus();
            alert('กรุณากรอกชื่อ');
            return false;
        } else if ($("#last_inform").val() == '') {
            $("#last_inform").focus();
            alert('กรุณากรอกนามสกุล');
            return false;
        } else if ((document.getElementById('SendAdd1_inform').checked == false) && (document.getElementById(
                'SendAdd2_inform').checked == false)) {
            $("#SendAdd1_inform").focus();
            alert('กรุณาเลือกที่อยู่ในการจัดส่ง');
            return false;
        } else if ((document.getElementById('SendAdd2_inform').checked == true) && $("#SendAdd_2_inform").val() == '') {
            $("#SendAdd_2_inform").focus();
            alert('กรุณากรอกรายละเอียดที่อยู่จัดส่ง');
            return false;
        } else if ($("#add_inform").val() == '') {
            $("#add_inform").focus();
            alert('กรุณากรอกบ้านเลขที่');
            return false;
        } else if ($("#province_inform").val() == '0') {
            $("#province_inform").focus();
            alert('กรุณาเลือกจังหวัด');
            return false;
        } else if ($("#amphur_inform").val() == '0') {
            $("#amphur_inform").focus();
            alert('กรุณาเลือกอำเภอ');
            return false;
        } else if ($("#tumbon_inform").val() == '0') {
            $("#tumbon_inform").focus();
            alert('กรุณาเลือกตำบล');
            return false;
        } else if ($("#postal_inform").val() == '') {
            $("#postal_inform").focus();
            alert('กรุณากรอกรหัสไปรษณีย์');
            return false;
        } else if ($("#doc_type_inform").val() == '0') {
            $("#doc_type_inform").focus();
            alert('กรุณาเลือกประเภทประกันภัย');
            return false;
        } else if ($("#com_data_inform").val() == '0') {
            $("#com_data_inform").focus();
            alert('กรุณาเลือกบริษัท');
            return false;
        } else if ($("#ty_inform").val() == '0') {
            $("#ty_inform").focus();
            alert('กรุณาเลือกการรับแจ้ง');
            return false;
        } else if ($("#service_inform").val() == '0') {
            $("#service_inform").focus();
            alert('กรุณาเลือกประเภทการซ่อม');
            return false;
        } else if ($("#start_date_inform").val() == 0) {
            $("#start_date_inform").focus();
            alert('กรุณาเลือกวันคุ้มครอง');
            return false;
        } else if ($("#vat_car_inform").val() == 0) {
            $("#vat_car_inform").focus();
            alert('กรุณาเลือกวันหมดภาษีรถยนต์');
            return false;
        } else if ($("#cartype_inform").val() == '0') {
            $("#cartype_inform").focus();
            alert('กรุณาเลือกประเภทการใช้');
            return false;
        } else if ($("#car_id_inform").val() == '0') {
            $("#car_id_inform").focus();
            alert('กรุณาเลือกลักษณะใช้งาน');
            return false;
        } else if ($("#cat_car_inform").val() == '0') {
            $("#cat_car_inform").focus();
            alert('กรุณาเลือกประเภทรถ');
            return false;
        } else if ($("#br_car_inform").val() == '0') {
            $("#br_car_inform").focus();
            alert('กรุณาเลือกยี่ห้อรถ');
            return false;
        } else if ($("#mo_car_inform").val() == '0') {
            $("#mo_car_inform").focus();
            alert('กรุณาเลือกรุ่นรถ');
            return false;
        } else if ($("#gear_inform").val() == '0') {
            $("#gear_inform").focus();
            alert('กรุณาเลือกเกียร์');
            return false;
        } else if ($("#car_seat_inform").val() == '0') {
            $("#car_seat_inform").focus();
            alert('กรุณากรอกจำนวนที่นั่ง');
            return false;
        } else if ($("#regis_date_inform").val() == '0') {
            $("#regis_date_inform").focus();
            alert('กรุณาเลือกปี');
            return false;
        } else if ($("#chose_carregis_inform").val() == '0') {
            $("#chose_carregis_inform").focus();
            alert('กรุณาเลือกทะเบียนรถ');
            return false;
        } else if ($("#car_regis_inform").val() == '2') {
            $("#car_regis_inform").focus();
            alert('กรุณากรอกรายละเอียดของป้ายทะเบียน');
            return false;
        } else if ($("#car_regis_pro_inform").val() == '0') {
            $("#car_regis_pro_inform").focus();
            alert('กรุณาเลือกจังหวัด');
            return false;
        } else if ($("#car_body_inform").val() == '') {
            $("#car_body_inform").focus();
            alert('กรุณากรอกเลขตัวถัง');
            return false;
        } else if ($("#name_gain_inform").val() == '0') {
            $("#name_gain_inform").focus();
            alert('กรุณาเลือกผู้รับผลประโยชน์');
            return false;
        } else if ($("#cost_inform").val() == '') {
            $("#cost_inform").focus();
            alert('กรุณากรอกทุนประกันภัย');
            return false;
        } else if ($("#damage_out1_inform").val() == 'N') {
            $("#damage_out1_inform").focus();
            alert('กรุณาเลือกความคุ้มครอง ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย');
            return false;
        } else if ($("#damage_cost_inform").val() == 'N') {
            $("#damage_cost_inform").focus();
            alert('กรุณาเลือกความคุ้มครอง ความเสียหายต่อทรัพย์สิน');
            return false;
        } else if ($("#pa1_inform").val() == 'N') {
            $("#pa1_inform").focus();
            alert('กรุณาเลือกความคุ้มครอง ผู้ขับขี่ 1 คน');
            return false;
        } else if ($("#people_inform").val() == 'N') {
            $("#people_inform").focus();
            alert('กรุณากรอกจำนวนผู้โดยสาร');
            return false;
        } else if ($("#pa2_inform").val() == 'N') {
            $("#pa2_inform").focus();
            alert('กรุณาเลือกความคุ้มครอง ผู้โดยสาร');
            return false;
        } else if ($("#pa3_inform").val() == 'N') {
            $("#pa3_inform").focus();
            alert('กรุณาเลือกจำนวนค่ารักษาพยาบาล');
            return false;
        } else if ($("#pa4_inform").val() == 'N') {
            $("#pa4_inform").focus();
            alert('กรุณาเลือกความคุ้มครอง การประกันตัวผู้ขับขี่ในคดีอาญา');
            return false;
        } else if ($("#none_disone_inform").val() == '0') {
            $("#none_disone_inform").focus();
            alert('กรุณาเลือกความเสียหายส่วนแรก');
            return false;
        } else if ($("#none_disone_inform").val() == 'มี' && $("#one_inform").val() == '') {
            $("#one_inform").focus();
            alert('กรุณากรอกราคาความสียหายส่วนแรก');
            return false;
        } else if ($("#rdodriver_inform").val() == '0') {
            $("#rdodriver_inform").focus();
            alert('กรุณาเลือกจำนวนผู้ขับขี่');
            return false;
        } else if ($("#emp_inform").val() == '') {
            $("#emp_inform").focus();
            alert('กรุณาเลือกผู้แจ้งงาน');
            return false;
        } else if ($("#service_charge_inform").val() == '0') {
            $("#service_charge_inform").focus();
            alert('กรุณาเลือกค่าบริการ');
            return false;
        } else if ($("person_inform").val() == '3' && $("#niti_inform").val() == '') {
            $("#niti_inform").focus();
            alert('กรุณากรอกเลขที่นิติบุคคล');
            return false;
        }
        // นัดตรวจสภาพ
        else if ((document.getElementById('commentse1_inform').checked == true) && $("#checkcar_time_inform").val() ==
            '0') {
            $("#checkcar_time_inform").focus();
            alert('กรุณาเลือกเวลานัดตรวจสภาพ');
            return false;
        } else if ((document.getElementById('commentse1_inform').checked == true) && $("#contact_name_list_inform")
            .val() ==
            '') {
            $("#contact_name_list_inform").focus();
            alert('กรุณากรอกชื่อผู้ติดต่อ');
            return false;
        } else if ((document.getElementById('commentse1_inform').checked == true) && $("#contact_number_inform")
            .val() ==
            '') {
            $("#contact_number_inform").focus();
            alert('กรุณากรอกเบอร์โทรศัพท์');
            return false;
        }
        // ส่งกรมธรรม์
        else if ((document.getElementById('commentse2_inform').checked == true) && (document.getElementById(
                'check_1_inform').checked == false) && (document.getElementById('check_2_inform').checked == false)) {
            $("#check_1_inform").focus();
            alert('กรุณาเลือกประเภทการส่งกรมธรรม์');
            return false;
        } else if ((document.getElementById('commentse2_inform').checked == true) && $("#contact_name_list_1_inform")
            .val() == '') {
            $("#contact_name_list_1_inform").focus();
            alert('กรุณากรอกชื่อผู้ติดต่อ');
            return false;
        } else if ((document.getElementById('commentse2_inform').checked == true) && $("#contact_number_1_inform")
            .val() ==
            '') {
            $("#contact_number_1_inform").focus();
            alert('กรุณากรอกเบอร์โทรศัพท์');
            return false;
        }
        // จ่ายแล้ว
        else if ((document.getElementById('commentse3_inform').checked == true) && (document.getElementById(
                'check_3_inform').checked == false) && (document.getElementById('check_4_inform').checked == false)) {
            $("#check_3_inform").focus();
            alert('กรุณาเลือกประเภทการจ่ายเงิน');
            return false;
        } else if ((document.getElementById('commentse3_inform').checked == true) && $("#payment_1_inform").val() ==
            '0') {
            $("#payment_1_inform").focus();
            alert('กรุณาเลือกวิธีชำระเงิน');
            return false;
        } else if ((document.getElementById('commentse3_inform').checked == true) && $("#payment_1_inform").val() ==
            '5' &&
            $("#instance_1_inform").val() == '0') {
            $("#instance_1_inform").focus();
            alert('กรุณาเลือกจำนวนงวดชำระ');
            return false;
        } else if ((document.getElementById('commentse3_inform').checked == true) && $("#payment_1_inform").val() !=
            '1' &&
            $("#payment_1_inform").val() != '7' && $("#payment_1_inform").val() != '8' && $("#bankoperation_1_inform")
            .val() == '0') {
            $("#bankoperation_1_inform").focus();
            alert('กรุณาเลือกธนาคาร');
            return false;
        }
        // กำลังทำจ่าย
        else if ((document.getElementById('commentse4_inform').checked == true) && (document.getElementById(
                'check_5_inform').checked == false) && (document.getElementById('check_6_inform').checked == false)) {
            $("#check_5_inform").focus();
            alert('กรุณาเลือกประเภทการจ่ายเงิน');
            return false;
        } else if ((document.getElementById('commentse4_inform').checked == true) && $("#payment_2_inform").val() ==
            '0') {
            $("#payment_2_inform").focus();
            alert('กรุณาเลือกวิธีชำระเงิน');
            return false;
        } else if ((document.getElementById('commentse4_inform').checked == true) && $("#payment_2_inform").val() ==
            '5' &&
            $("#instance_2_inform").val() == '0') {
            $("#instance_2_inform").focus();
            alert('กรุณาเลือกจำนวนงวดชำระ');
            return false;
        } else if ((document.getElementById('commentse4_inform').checked == true) && $("#payment_2_inform").val() !=
            '1' &&
            $("#payment_2_inform").val() != '7' && $("#payment_2_inform").val() != '8' && $("#bankoperation_2_inform")
            .val() == '0') {
            $("#bankoperation_2_inform").focus();
            alert('กรุณาเลือกธนาคาร');
            return false;
        } else if ((document.getElementById('commentse4_inform').checked == true) && $("#contact_number_2_inform")
            .val() ==
            '') {
            $("#contact_number_2_inform").focus();
            alert('กรุณากรอกเบอร์โทรศัพท์');
            return false;
        }
        // ยังไม่จ่าย
        else if ((document.getElementById('commentse5_inform').checked == true) && (document.getElementById(
                'check_7_inform').checked == false) && (document.getElementById('check_8_inform').checked == false) && (
                document.getElementById('check_9_inform').checked == false) && (document.getElementById(
                    'check_10_inform')
                .checked == false) && (document.getElementById('check_11_inform').checked == false)) {
            $("#check_7_inform").focus();
            alert('กรุณาเลือกประเภทการจ่ายเงิน');
            return false;
        } else if ((document.getElementById('commentse5_inform').checked == true) && (document.getElementById(
                'check_11_inform').checked == true) && $("#D_day_inform").val() == '0') {
            $("#D_day_inform").focus();
            alert('กรุณาเลือกจำนวนวัน');
            return false;
        } else if ((document.getElementById('commentse5_inform').checked == true) && $("#contact_name_list_3_inform")
            .val() == '') {
            $("#contact_name_list_3_inform").focus();
            alert('กรุณากรอกชื่อผู้ติดต่อ');
            return false;
        } else if ((document.getElementById('commentse5_inform').checked == true) && $("#contact_number_3_inform")
            .val() ==
            '') {
            $("#contact_number_3_inform").focus();
            alert('กรุณากรอกเบอร์โทรศัพท์');
            return false;
        } else {

            var DATA = $('#webForm_inform').serialize();
            var SAVE = {
                type: "POST",
                dataType: "JSON",
                url: "ajax/ajax_inform_four_save.php?id_data=<?php echo $_POST['id_data']; ?>&id_detail=<?php echo $_POST['id_detail']; ?>&user=<?php echo $_POST['user']; ?>&claim=<?php echo $_POST['claim']; ?>",
                data: DATA,
                success: function(msg) {

                    var returnedArray = msg;
                    if (returnedArray.id == 'false') {
                        alert(returnedArray.msg);
                        return false;
                    } else {



                        alert(returnedArray.msg);
                        //$("#closed").click();						
                        $(".modal").hide();
                        $(".modal-backdrop").hide();
                        //$(".modal").removeData('modal');
                        tables.ajax.reload();
                    }
                },
                error: function(msg) {
                    var returnedArray = msg;
                    // $('#previewContent').dialog( "close" );
                    alert('การบันทึกผิดพลาด');
                }
            };

            if ($("#tel_mobile_inform").val() == 0) {
                if (confirm('คุณลืมกรอกเบอร์มือถือเพื่อส่ง SMS คุณต้องการบันทึกหรือไม่')) {
                    $.ajax(SAVE);
                } else {
                    $("#tel_mobi_inform").focus();
                    //$('#previewContent').dialog( "close" );
                    return false;
                }
            } else {
                $.ajax(SAVE);
            }
        }
    }

    function barcode_scan() {

        var check = 'F';
        if ($("#barcode_inform").val() == "") {
            return false;
        } else {
            <?php
            $end_date = date('Y-m-d');

            $barcode_sql = "SELECT * FROM tb_protection  WHERE end_date >= date('" . $end_date . "')";
            $barcode_query =   PDO_CONNECTION::fourinsure_insured()->query($barcode_sql);
            foreach ($barcode_query->fetchAll(2) as $barcode_array) { ?>
                if ($("#barcode_inform").val() == "<?php echo $barcode_array['barcode']; ?>") {
                    check = 'T';
                }
            <?php } ?>
        }
        if (check == 'F') {
            return false;
        }
        var scan = {
            url: "ajax/data_protection.php",
            type: "POST",
            dataType: "JSON",
            data: {
                barcode: $("#barcode_inform").val()
            },
            success: function(data) {
                //$("#cost").val();
                $("#damage_out1_inform").html(data.damage_out1);
                $("#damage_cost_inform").html(data.damage_cost);
                $("#pa1_inform").html(data.pa1);
                $("#pa2_inform").html(data.pa2);
                $("#pa3_inform").html(data.pa3);
                $("#pa4_inform").html(data.pa4);
                $("#people_inform").val(data.people);
                $("#htmlbarcode_inform").html($("#barcode_inform").val());
                $("#barcode_inform").val("");
            }
        };
        $.ajax(scan);
    }

    function backpages() {
        load_page("pages/renew_suzuki_select.php?id=<?php echo $_POST['id_data']; ?>", "แจ้งงาน");
    }
    $("#prbNet_inform").val('<?php echo $act_net; ?>');
    $("#currentValue_prb_inform").val('<?php echo $act_total; ?>');
    calcfunc_inform();
    calcfunc2_inform();
    com_action();

    function js_proshow(level, datapost, go, come) {
        var retu = "";
        if (datapost == 'province') {
            $("#send_amphur").html('<option value="">--กรุณาเลือก--</option>');
            $("#send_tumbon").html('<option value="">--กรุณาเลือก--</option>');
            $("#send_post").html('<option value="">--กรุณาเลือก--</option>');
            retu = {

                url: "ajax/Ajax_Pro.php",
                type: "POST",
                dataType: "JSON",
                data: {
                    province: $("#" + go).val(),
                    callajax: level
                },
                success: function(data) {
                    var datahtml = '<option value="">--กรุณาเลือก--</option>';
                    for (var n = 0; n < data.length; n++) {
                        datahtml += '<option value="' + data[n].Id + '">' + data[n].Name + '</option>';
                    }
                    $("#" + come).html(datahtml);
                }
            };
        } else if (datapost == 'amphur') {
            $("#send_tumbon").html('<option value="">--กรุณาเลือก--</option>');
            $("#send_post").html('<option value="">--กรุณาเลือก--</option>');
            retu = {

                url: "ajax/Ajax_Pro.php",
                type: "POST",
                dataType: "JSON",
                data: {
                    amphur: $("#" + go).val(),
                    callajax: level
                },
                success: function(data) {
                    var datahtml = '<option value="">--กรุณาเลือก--</option>';
                    for (var n = 0; n < data.length; n++) {
                        datahtml += '<option value="' + data[n].Id + '">' + data[n].Name + '</option>';
                    }
                    $("#" + come).html(datahtml);
                }
            };
        } else if (datapost == 'tumbon') {
            $("#send_post").html('<option value="">--กรุณาเลือก--</option>');
            retu = {

                url: "ajax/Ajax_Pro.php",
                type: "POST",
                dataType: "JSON",
                data: {
                    tumbon: $("#" + go).val(),
                    callajax: level
                },
                success: function(data) {
                    var datahtml = '<option value="">--กรุณาเลือก--</option>';
                    for (var n = 0; n < data.length; n++) {
                        datahtml += '<option value="' + data[n].Id + '"  selected >' + data[n].Name +
                            '</option>';
                    }
                    $("#" + come).html(datahtml);
                }
            };
        }
        $.ajax(retu);
    }

    function protection_html_start() {
        $("#cost_inform_show").html($("#cost_inform").val());
        $("#damage_out1_inform_show").html($("#damage_out1_inform").val());
        $("#damage_cost_inform_show").html($("#damage_cost_inform").val());
        $("#pa1_inform_show").html($("#pa1_inform").val());
        $("#people_inform_show").html($("#people_inform").val());
        $("#pa2_inform_show").html($("#pa2_inform").val());
        $("#pa3_inform_show").html($("#pa3_inform").val());
        $("#pa4_inform_show").html($("#pa4_inform").val());
    }
    protection_html_start();

    // async function getTitleName() {
    //     let personInform = document.getElementById('person_inform').value;
    //     const url = 'services/InsuranceNotificationWork/insurance-notification-work.controller.php';
    //     const ctrlName = {
    //         Controller: 'getTitleName',
    //         personType: personInform

    //     };
    //     const res = await postApiAsyncDealer(ctrlName, url);

    //     if (res.Status !== 200) {
    //         console.log('getTitleName-error', res);
    //         return false;
    //     }
    //     const titleInformElem = document.querySelector(".class_title_inform");
    //     titleInformElem.innerHTML = '';
    //     res.Data.forEach(element => {
    //         const op = document.createElement("option");
    //         op.text = element;
    //         op.value = element;
    //         titleInformElem.appendChild(op);
    //     });
    // }
    // getTitleName();

    // document.getElementById("person_inform").addEventListener("change", getTitleName);


    // function js_title_inform() {
    //     if ($(".class_title_inform").val() == 'บจ.' || $(".class_title_inform").val() == 'หจก.' || $(
    //             ".class_title_inform")
    //         .val() == 'บมจ.') {
    //         $("#last_inform").val("-");
    //         $("#name_inform").attr("placeholder", "ป้อนชื่อบริษัท");
    //         $("#show_last_form").hide();
    //     } else {
    //         $("#name_inform").attr("placeholder", "ป้อนชื่อจริง");
    //         $("#show_last_form").show();
    //     }
    // }
    async function getTempText() {
        let data = {
            Controller: "getTempText",
            idData: _idData
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
        if (!res.Data) {
            return false;
        }
        // const arrSplit = str.split('|');
        $('#divTempText').show();
        $('#tempText').show();
        let str =
            `<p>รุ่นรถ | ที่อยู่ | อำเภอ | จังหวัด | รหัสไปรษณีย์ | รหัสสี ชื่อสี | ไม่ระบุ | ไม่ระบุ</p><p>${res.Data}</p>`;
        $('#tempText').append(str)
        console.log('getTempText', res);
    }
    getTempText();
</script>