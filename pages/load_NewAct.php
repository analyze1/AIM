<?php
include "check-ses.php";
include "../inc/connectdbs.pdo.php";
header('Content-Type: text/html; charset=utf-8');
?>
<!-- <script src="js/js_Insurance.js" type="text/javascript"></script> -->
<script src="js/js_Insurance_NewAct.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

<script type="text/javascript">
    function checkText() {
        var elem = document.getElementById('car_body').value;
        if (!elem.match(/^([a-z0-9\_])+$/i)) {
            alert("กรอกได้เฉพาะ A-Z, 0-9 ");
            document.getElementById('car_body').value = "";
        }
    }

    function checkText2() {
        var elem = document.getElementById('n_motor').value;
        if (!elem.match(/^([a-z0-9\_])+$/i)) {
            alert("กรอกได้เฉพาะ A-Z, 0-9 ");
            document.getElementById('n_motor').value = "";
        }

    }
</script>
<style>
    table {
        background: #eee !important;
    }

    .color_eee {
        background: #eee !important;
    }
</style>
<form name="Insurance" id="Insurance">
    <div class="row-fluid">
        <div class="span12">
            <div class="alert alert-block alert-danger" align="center"><strong>
                    <font color="#FF0000">แจ้งประกันภัยป้ายดำ</u>!!!</font>
                </strong></div>
            <div class="widget-box">
                <div class="widget-header widget-header-flat">
                    <h4>ข้อมูลทั่วไป</h4>
                </div>
                <div class="widget-body  color_eee">
                    <div class="widget-main">
                        <div class="row-fluid">
                            <div class="span12">
                                <input name="ty_prot" type="hidden" id="ty_prot" value="<?php print $ty_prot; ?>" />
                                <input name="send_date" type="hidden" id="send_date" size="40" maxlength="10" readonly="true" value="<?= date("Y-m-d H:i"); ?>" />
                                <input name="xuser" type="hidden" id="xuser" value="<?= $_SESSION["strUser"]; ?>" />
                                <input name="xUserName" type="hidden" id="xUserName" value="<?= $_SESSION["strPass"]; ?>" />
                                <input name="name_inform" type="hidden" id="name_inform" size="40" maxlength="40" readonly="true" value="<?= $_SESSION["strName"]; ?>" />
                                <input name="idUser" type="hidden" id="idUser" size="40" maxlength="40" readonly="true" value="<?= $_SESSION["idUser"]; ?>" />
                                <input type="hidden" name="doc_type" id="doc_type" value="1" />
                                <table class="table">
                                    <tr>
                                        <td width='120'>เลขที่ใบเสนอราคา</td>
                                        <td> : <input type='text' name="q_auto" id="q_auto" size='4' onkeyup='prb_total()'>
                                            <font color="#FF0000"><b> * </b></font>
                                        </td>
                                        <td colspan='4' id='prb_grand'></td>
                                    </tr>
                                    <?php
                                    if ($_SESSION["strUser"] == "admin") {
                                    ?>

                                        <tr class="error">
                                            <td>สาขาแจ้งงาน</td>
                                            <td> :
                                                <select name="Dxuser" id="Dxuser">
                                                    <option value="0" selected="selected">กรุณาเลือกชื่อผู้แจ้ง</option>
                                                </select>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    <?php
                                    } ?>
                                    <tr>
                                        <input name="end_date" type="hidden" id="end_date" class="span6" value="<?php echo date("d/m/Y"); ?>">
                                        <td>วันที่คุ้มครอง</td>
                                        <td> : <input name="start_date" type="text" id="start_date" size="4" value="" readonly />
                                            <font color="#FF0000"><b> * (วัน/เดือน/ปี)</b></font>
                                        </td>
                                        <td>ประเภทการใช้</td>
                                        <td> : <span id="cartypeDiv">
                                                <select name="cartype" id="cartype" class="span7">
                                                    <option value="0">กรุณาเลือก</option>
                                                </select></span>
                                            <font color="#FF0000"><b> * </b></font>
                                        </td>
                                        <td>ลักษณะใช้งาน</td>
                                        <td> : <span id="car_idDiv"><select name="car_id" id="car_id" class="span7">
                                                    <option value="0">กรุณาเลือก</option>
                                                </select></span>
                                            <font color="#FF0000"><b> * </b></font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>ประเภทรถ</td>
                                        <td> : <span id="cat_carDiv"><select name="cat_car" id="cat_car" class="span5">
                                                    <option value="0">กรุณาเลือก</option>
                                                </select></span>
                                            <font color="#FF0000"><b> * </b></font>
                                        </td>
                                        <td>ยี่ห้อรถ</td>
                                        <td> : <span id="br_carDiv"><select name="br_car" id="br_car" class="span7">
                                                    <option value="0">กรุณาเลือก</option>
                                                </select></span>
                                            <font color="#FF0000"><b> * </b></font>
                                        </td>
                                        <td>รุ่นรถ</td>
                                        <td> : <span id="mo_carDiv"><select name="mo_car" id="mo_car" class="span7">
                                                    <option value="0">กรุณาเลือก</option>
                                                </select></span>
                                            <font color="#FF0000"><b> * </b></font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>จำนวน ซี.ซี.</td>
                                        <td> : <select name="car_cc" id="car_cc" class="span7">
                                                <option value="0" selected="selected">กรุณาเลือก</option>
                                            </select>
                                            <font color="#FF0000"><b> * </b></font>
                                        </td>
                                        <td>น้ำหนัก</td>
                                        <td> : <select name="car_wgt" id="car_wgt" class="span7">
                                                <option value="0" selected="selected">กรุณาเลือก</option>
                                            </select>
                                            <font color="#FF0000"><b> * </b></font>
                                        </td>
                                        <td>จำนวนที่นั่ง</td>
                                        <td> : <select name="car_seat" id="car_seat" class="span7">
                                                <option value="0" selected="selected">กรุณาเลือก</option>
                                                <option value="3">ไม่เกิน 3 ที่นั่ง</option>
                                                <option value="7">ไม่เกิน 7 ที่นั่ง</option>
                                            </select>
                                            <font color="#FF0000"><b> * </b></font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>ปีจดทะเบียน</td>
                                        <td>
                                            <input type="hidden" name="Dyy" id="Dyy" value="<?= date('Y') ?>" readonly size='3' />
                                            : <select name="regis_date" id="regis_date" class="span7"></select>
                                        </td>
                                        <td>ทะเบียนรถ</td>
                                        <td> : <input name="car_regis" type="text" id="car_regis" value="" size="10" maxlength="8" class="span7" />

                                            <input name="car_regis_text" type="hidden" id="car_regis_text" value="-" size="10" maxlength="8" class="span7" />
                                        </td>
                                        <td>จังหวัดทะเบียนรถ</td>
                                        <td>: <select class="span7" name='car_regis_pro' id='car_regis_pro'>
                                            </select>
                                            <font color="#FF0000"><b> * </b></font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>เลขตัวถัง</td>
                                        <td> :
                                            <input name="car_body" type="text" id="car_body" style="text-transform:uppercase;" class="span7" onblur="checkText();" />
                                            <font color="#FF0000"><b> * ระบุเลขตัวถัง</b></font>
                                        </td>
                                        <td>เลขเครื่อง</td>
                                        <td colspan='3'>: <input class="span3" name="n_motor" type="text" id="n_motor" style="text-transform:uppercase;" onblur="checkText2();" />
                                            <font color="#FF0000"><b> * ระบุเลขเครื่องยนต์</b></font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>เกียร์</td>
                                        <td> : <select name="gear" size="1" class="span7" id="gear">
                                                <option value="0" selected="selected">กรุณาเลือก</option>
                                                <option value="A">อัตโนมัติ</option>
                                                <option value="M">ธรรมดา</option>
                                            </select>
                                            <font color="#FF0000"><b> * </b></font>
                                        </td>
                                        <td>สีรถ</td>
                                        <td>:
                                            <select name="car_color" id="car_color" style="width:auto;" class="span7">
                                                <option value="0">กรุณาเลือก</option>
                                                <option value="-">ไม่ระบุ</option>
                                            
                                            </select>
                                            <font color="#FF0000"><b> * </b></font>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>

                                </table>
                            </div>
                            </td>
                            </tr>
                            </table>
                            </td>
                            <td class="bg-in">&nbsp;</td>
                            </tr>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
    $user = $_SESSION["strUser"];
    $query_act = "SELECT *  FROM z_act WHERE act_use = '" . $user . "' AND act_status = '1' ORDER BY act_id limit 5";
    $objQuery_act = PDO_CONNECTION::fourinsure_mitsu()->query($query_act);
    foreach ($objQuery_act->fetchAll(2) as $row_act) {
        echo '<option value="' . $row_act['act_no'] . '">' . $row_act['act_no'] . '</option>';
    }
    ?>
    </select>

    <?php if ($_SESSION["saka"] == '113' || $_SESSION["strUser"] == 'ADMIN') { ?>
        <?php
        $user = $_SESSION["strUser"];
        $query_act = "SELECT *  FROM z_act WHERE act_use = '" . $user . "' AND act_status = 'R' AND 	act_return = '' ORDER BY act_id";
        $objQuery_act = PDO_CONNECTION::fourinsure_mitsu()->query($query_act);
        $row_act = $objQuery_act->fetch(2);

        if ($row_act['act_no'] == '') {
            $query_act = "SELECT *  FROM z_act WHERE act_use = '" . $user . "' AND act_status = '1' AND act_return = '' ORDER BY act_id";
            $objQuery_act = PDO_CONNECTION::fourinsure_mitsu()->query($query_act);
            $row_act = $objQuery_act->fetch(2);
        }

        ?>
        <input name="p_act3" type="text" id="p_act3" style="width:70px;" maxlength="7" value="<?= $row_act['act_no']; ?>" readonly="readonly" />
        <font color="#FF0000">** ในกรณีที่เลขพรบเป็นค่าว่าง กรุณาติดต่อเจ้าหน้าที่ โทร 085-921-3636, 085-921-5454 **<b></b>
        </font>
    <?php
    } else { ?>
        <input name="p_act3" type="text" id="p_act3" style="width:70px;" maxlength="7" value="" />
        <font color="#FF0000"><b> * เลขที่ พ.ร.บ. อยู่ที่สี่เหลี่ยมสีแดง</b></font> <img src="i/act.jpg" />
    <?php
    } ?>

    </td>
    </tr>
    <tr>
        <td>เบี้ยสุทธิ :</td>
        <td>
            <select class="comment" name="id_prp" id="id_prp" style="width:auto;">
                <option value="0" selected="selected">กรุณาเลือกเบี้ย</option>
            </select>
            <input type="hidden" class="comment" name="txtprp1" id="txtprp1" />
        </td>
        <td>อากร :</td>
        <td><input type="text" class="comment" name="txtstamp1" id="txtstamp1" style="width:50px;" value="0.00" readonly="readonly" /></td>
        <td>ภาษี :</td>
        <td><input type="text" class="comment" name="txttax1" id="txttax1" style="width:50px;" value="0.00" readonly="readonly" /></td>
        <td>เบี้ยรวม :</td>
        <td><input type="text" class="comment" name="txtnet1" id="txtnet1" style="width:50px;" value="0.00" readonly="readonly" /></td>
    </tr>
    <tr class="error">
        <td colspan="8">
            <font color="#FF0000"><b>กรณี จดทะเบียนเป็นรถรับจ้าง หรือ รถขนส่งผู้โดยสาร กรุณาติดต่อเจ้าหน้าที่ hotline:
                    085-921-3636, 085-921-5454</b></font>
        </td>
    </tr>
    </table>


    </div>
    </div>
    </div>
    </div>
    </div>-->


    <style>
        .tab {
            text-align: left;
            padding-left: 20px;
        }

        .h6 {
            margin-top: -10px;
        }

        .left {
            text-align: left;
        }

        .right {
            margin: 0;
            text-align: right;
            padding-right: 30px;
        }

        .inline {
            display: inline;
        }

        .margin {
            margin-top: -20px;
        }

        .center {
            text-align: center;
        }


        .backbg {

            background: #3bb9ce;

            font-family: Tahoma, Geneva, sans-serif;

            font-size: 14px;


            color: #fff;

            font-weight: bold;

            -moz-border-radius: 0px 0px 10px 10px;

            -webkit-border-radius: 0px 0px 10px 10px;

            -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);

            -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);

            text-shadow: 0 -1px 1px rgba(0, 0, 0, 0.25);

            border-bottom: 1px solid rgba(0, 0, 0, 0.25);


            border-left: none;

            border-top: none;


        }

        .shadowbox {
            -webkit-box-shadow: 0px 7px 18px -9px rgba(0, 0, 0, 0.44);
            -moz-box-shadow: 0px 7px 18px -9px rgba(0, 0, 0, 0.44);
            box-shadow: 0px 7px 18px -9px rgba(0, 0, 0, 0.44);
        }
    </style>
    <div class="widget-box" id="payment">
        <div class="widget-header widget-header-flat">
            <h4>ข้อมูลความคุ้มครอง&nbsp;<span id='name_print' class='fit'></span></h4>
        </div>
        <div class="widget-body color_eee" align='center'>
            <div class="widget-main">
                <div class="row-fluid">

                    <div class="span12">
                        <div class="span4" style='border:solid thin #ccc;'>
                            <div class="span12 backbg">
                                <h5><b>ความรับผิดชอบต่อบุคคลภายนอก</b></h5>
                            </div>
                            <div class="span12">
                                <br>
                                <div class='left'>1) ความเสียหายต่อชีวิต ร่างกาย หรืออนามัย</div>
                                <div class='tab'>เฉพาะส่วนเกินวงเงินสูงสุดตาม พ.ร.บ.</div>
                                <div class="right"><span id='human_amt' class='fit'></span> บาท/คน&nbsp;</div>
                                <div class="right"><span class='fit'><b>10,000,000</b></span> บาท/ครั้ง</div>
                                <div class="left"><span>2) ความเสียหายต่อทรัพย์สิน</span></div>
                                <div class="right"><span id='asset_amt' class='fit'></span> บาท/ครั้ง</div>
                                <div class="tab"><span>2.1 ความเสียหายส่วนแรก </span></div>
                                <div class="right margin"><span id='' class='fit'>-</span> บาท/ครั้ง</div>
                                <br><br><br>
                            </div>
                        </div>



                        <div class="span4" style='border:solid thin #ccc;'>
                            <div class="span12 backbg">
                                <h5><b>รถยนต์เสียหาย สูญหาย ไฟไหม้</b></h5>
                            </div>
                            <div class="span12">
                                <br>
                                <div class='left'>1) ความเสียหายต่อรถยนต์</div>
                                <div class="right"><span id='insu_amt' class='fit'></span> บาท/ครั้ง</div>
                                <div class="tab"><span>1.1 ความเสียหายส่วนแรก </span></div>
                                <div class="right margin"><span id='first_damage_amt' class='fit'></span>
                                    บาท&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                <div class="left"><span>2) รถยนต์สูญหาย/ไฟไหม้ </span></div>

                                <div class="right"><span id='asset_dmg' class='fit'></span> บาท/ครั้ง</div>
                                <div class="right"><span class='fit'><b>-</b></span> บาท/ครั้ง</div>
                                <div class="center"><span>
                                        <h1>ไม่รวม พ.ร.บ.</h1>
                                    </span></div>
                                <br>

                            </div>
                        </div>


                        <div class="span4" style='border:solid thin #ccc;'>
                            <div class="span12 backbg">
                                <h5><b>ความคุ้มครองตามเอกสารแนบท้าย</b></h5>
                            </div>
                            <div class="span12">
                                <br>
                                <div class='left'>1) อุบัติเหตุส่วนบุคคล</div>
                                <div class='tab'>1.1 เสียชีวิต สูญเสียอวัยวะ ทุพพลภาพถาวร</div>

                                <div class='tab'>ก) ผู้ขับขี่ 1 คน</div>
                                <div class="right margin"><span id='' class='fit drive1_amt'></span>
                                    บาท&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                <div class='tab'>ข) ผู้โดยสาร <span id='passenger' class='fit'></span> คน</div>
                                <div class="right margin"><span id='' class='fit passenger_amt'></span> บาท/คน</div>
                                <div class='tab'>1.2) ทุพพลภาพชั่วคราว</div>

                                <div class='tab'>ก) ผู้โดยสาร 1 คน</div>
                                <div class="right margin"><span class='fit'><b>ไม่คุ้มครอง</b></span>
                                    บาท/สัปดาห์&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                                <div class='tab'>ก) ผู้โดยสาร - คน</div>
                                <div class="right margin"><span class='fit'><b>ไม่คุ้มครอง</b></span>
                                    บาท/คน/สัปดาห์&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                <div class='left'>2) ค่ารักษาพยาบาล </div>
                                <div class="right margin"><span class='fit' id='medic_amt'></span> บาท/คน&nbsp;</div>
                                <div class='left'>3) การประกันตัวผู้ขับขี่</div>
                                <div class="right margin"><span class='fit' id='criminal_amt'></span> บาท/ครั้ง</div>
                                <br>
                            </div>
                        </div>
                        <div class="span12 shadowbox" style="background-color:#FFFFFF; margin-left:0px; padding:20px 30px 20px 30px;">
                            <span id='prb_grand_pre'></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="widget-box">
        <div class="widget-header widget-header-flat">
            <h4>ข้อมูลผู้เอาประกันภัย</h4>
        </div>
        <div class="widget-body color_eee">
            <div class="widget-main">
                <div class="row-fluid">
                    <div class="span12">
                        <table class="table">

                            <tr>
                                <td class="comment" colspan="6">ตามกฎหมาย สำนักงานป้องกันและปราบปรามการฟอกเงิน (ปปง.)
                                    จำเป็นต้องแสดง เลขบัตรประชาชน / เลขหมายทะเบียนการค้า <img src="images/New_icon.gif" width="25" height="9" /></td>
                            </tr>
                            <tr class="warning">
                                <td>
                                    <label class="radio-inline"><input name="person" id="person" type="radio" value="1" checked="checked" /> บุคคลธรรมดา</label>
                                    <label class="radio-inline"><input name="person" id="persons" type="radio" value="2" /> นิติบุคคล</label>
                                </td>
                                <td colspan="5">
                                    <input name="icard" type="text" id="icard" maxlength="13" />
                                    <font color="#FF0000"><b> * (กรุณากรอกเฉพาะตัวเลข 13 หลัก)</b></font>
                                </td>
                            </tr>
                            <tr>
                                <td>คำนำหน้าชื่อ :</td>
                                <td>
                                    <select id="title" name="title">
                                      
                                    </select>
                                    <font color="#FF0000"><b> * </b></font>
                                </td>
                                <td>ชื่อ :</td>
                                <td><input type="text" name="name_name" id="name_name" size="25" maxlength="100" />
                                    <font color="#FF0000"><b> * </b></font>
                                </td>
                                <td>นามสกุล :</td>
                                <td><input type="text" name="last" id="last" size="25" maxlength="50" />
                                    <font color="#FF0000"><b> * </b></font>
                                </td>
                            </tr>
                            <tr>
                                <td>บ้านเลขที่ :</td>
                                <td> <input type="text" id="add" maxlength="30" class="span5" name="add" />
                                    <font color="#FF0000"><b> * </b></font>&nbsp;&nbsp; หมู่&nbsp; <input type="text" name="group" id="group" size="3" class="span2" maxlength="4" />
                                </td>
                                <td>อาคาร/หมู่บ้าน</td>
                                <td> <input type="text" name="town" id="town" size="25" maxlength="50" autocomplete="OFF" /></td>
                                <td>ซอย :</td>
                                <td> <input type="text" name="lane" id="lane" size="25" maxlength="50" /></td>
                            </tr>
                            <tr>
                                <td>ถนน :</td>
                                <td><input type="text" id="road" maxlength="50" size="20" name="road" /></td>
                                <td>เบอร์โทรศัพท์บ้าน :</td>
                                <td><input type="text" name="tel_home" id="tel_home" size="25" maxlength="20" /></td>
                                <td>เบอร์มือถือลูกค้า :</td>
                                <td><input placeholder="กรอกเบอร์มือถือ" id="tel_mobi" type="text" maxlength="13" class="span5" name="tel_mobi" />
                                    <font color="#FF0000"><b> * </b></font>
                                </td>
                            </tr>
                            <tr>
                                <td>E - mail ลูกค้า :</td>
                                <td><input placeholder="กรอกอีเมล์" name="email" class="span6" type="text" id="email" size="20" />
                                    <font color="#FF0000"><b> * </b></font>
                                </td>
                                <td>จังหวัด :</td>
                                <td> <span id="provinceDiv">
                                        <select name="province" id="province">
                                        </select></span>
                                    <font color="#FF0000"><b> * </b></font>
                                </td>
                                <td>อำเภอ :</td>
                                <td><span id="amphurDiv">
                                        <select name="amphur" id="amphur">
                                            <option value="0">กรุณาเลือก</option>
                                        </select></span>
                                    <font color="#FF0000"><b> * </b></font>
                                </td>
                            </tr>
                            <tr>
                                <td>ตำบล :</td>
                                <td><span id="tumbonDiv">
                                        <select name="tumbon" id="tumbon">
                                            <option value="0">กรุณาเลือก</option>
                                        </select></span>
                                    <font color="#FF0000"><b> * </b></font>
                                </td>
                                <td>รหัสไปรษณีย์ :</td>
                                <td><span id="id_postDiv">
                                        <select name="id_post" id="id_post">
                                            <option value="0">กรุณาเลือก</option>
                                        </select></span>
                                    <font color="#FF0000"><b> * </b></font>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>

                            <tr class="error">
                                <td colspan="10" style="color:red;">* กรุณาตรวจสอบข้อมูลให้ครบถ้วนก่อนทำการบันทึก
                                    มิฉะนั้นข้อมูลจะไม่สมบูรณ์</td>
                            </tr>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <button class="btn btn-large btn-primary" type="button" id="SaveInsurance" name="SaveInsurance"><i class="icon-upload"></i>แจ้งประกันภัยรถยนต์</button>
    <button class="btn btn-large btn-warning" type="reset" name="BcloseIn" id="BcloseIn"><i class="icon-refresh"></i>เริ่มใหม่</button>
</form>
</div>



<script language="javascript">
    $(document).ready(function() {

        $('#icard').mask("9999999999999");
        $('#tel_mobi').mask("999-999-9999");

        $('#start_date').datepicker({
            format: "dd/mm/yyyy",
            startDate: "today",
            language: "th",
            autoclose: true,

        });


        var Dyy = $('#Dyy').val();
        regis_date = $("#regis_date");
        $("#regis_date").empty();
        regis_date.append("<option value='N'>--- กรุณาเลือกปีรถ ---</option>");
        for (i = Dyy - 14; i <= Dyy; i++) {
            regis_date.append("<option value='" + i + "'>" + i + "</option>");
        }

    });

    function prb_total() {
        var payment = {
            url: "ajax/ajax_payment_prb.php",
            type: "post",
            dataType: "json",
            data: {
                q_auto: $('#q_auto').val()
            },
            success: function(data) {
                var arraypayment = data;
                if (arraypayment.check != "") {
                    $("#payment").slideDown();
                    $(".fit").show();
                } else {
                    $("#payment").slideUp();
                    $(".fit").hide();
                }
                if (arraypayment.first_damage == "" || arraypayment.first_damage == "ไม่มี" || arraypayment
                    .first_damage == null) {
                    $('#first_damage_amt').hide();

                } else {
                    $('#first_damage_amt').show();

                }
                $('#prb_grand').html(arraypayment.grand);
                $('#prb_grand_pre').html(arraypayment.grand_prb);
                $('#insu_amt').html("<b>" + arraypayment.insu_amt + "</b>");
                $('#human_amt').html("<b>" + arraypayment.human_amt + "</b>");
                $('#asset_amt').html("<b>" + arraypayment.asset_amt + "</b>");
                $('.drive1_amt').html("<b>" + arraypayment.drive1_amt + "</b>");
                $('#passenger').html(arraypayment.passenger);
                $('.passenger_amt').html("<b>" + arraypayment.passenger_amt + "</b>");
                $('#medic_amt').html("<b>" + arraypayment.medic_amt + "</b>");
                $('#criminal_amt').html("<b>" + arraypayment.criminal_amt + "</b>");
                $('#first_damage').html("<b>" + arraypayment.first_damage + "</b>");
                $('#first_damage_amt').html("<b>" + arraypayment.first_damage_amt + "</b>");
                $('#name_print').html("<b>(" + arraypayment.name_print + ")</b>");
                $('#asset_dmg').html("<b>" + arraypayment.asset_dmg + "</b>");
                $('#car_cc').html(arraypayment.car_cc);
                $('#car_wgt').html(arraypayment.car_wgt);
            }
        };
        $.ajax(payment);
    }
    $('.fit').hide();
    $("#payment").hide();
    $('#prb_total').hide();
</script>