<?php
include "check-ses.php";
include "../inc/connectdbs.pdo.php";
//require("../email/class.phpmailer.php");  // เรียกไฟล์ class.phpmailer.php
$_contextMitSu = PDO_CONNECTION::fourinsure_mitsu();
$_contextFour = PDO_CONNECTION::fourinsure_insured();

$sql = "SELECT Email4 FROM tb_customer WHERE user = '$_SESSION[strUser]'";
$row = $_contextMitSu->query($sql)->fetchAll(2);
?>

<script language="javascript">
$('#pageSearch').hide('Slow');

$('#page-content').css({
    'background-color': '#efedef'
});
</script>

<style type="text/css">
.style5 {
    color: #000000;
    font-size: 11px;
    font-weight: bold;
}

.style6 {
    font-size: 10pt;
    font-family: Tahoma;
}

.style12 {
    color: #000000;
    font-size: 10pt;
    font-weight: bold;
    font-family: Tahoma;
}
</style>

<div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-header widget-header-flat">
                <h4>เบิก พ.ร.บ.</h4>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row-fluid">
                        <div class="span12">
                            <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
                                <tr>
                                    <td width="100%" valign="top"></td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"
                                            bordercolor="#999999">
                                            <tr>
                                                <td>
                                                    <br>
                                                    <form method="POST" name="Form_act" id="Form_act">
                                                        <table width="100%" border="0" align="center" cellpadding="5"
                                                            cellspacing="5">
                                                            <tr>
                                                                <td width="247" height="30">
                                                                    <div align="right" class="style5 style6">
                                                                        วันที่ส่งข้อมูล&nbsp;&nbsp;:&nbsp;</div>
                                                                </td>
                                                                <td width="327" height="30"><input name="send_date"
                                                                        type="text" id="send_date" size="40"
                                                                        maxlength="10" readonly="true"
                                                                        value="<?php print date("d/m/Y H:i:s"); ?>" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="30">
                                                                    <div align="right" class="style12">
                                                                        รหัสผู้แจ้งงาน&nbsp;&nbsp;:&nbsp; </div>
                                                                </td>
                                                                <td height="30"><input name="xuser" type="text"
                                                                        id="xuser" size="40" maxlength="40"
                                                                        readonly="true"
                                                                        value="<?php echo $_SESSION["strUser"]; ?>" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="30">
                                                                    <div align="right" class="style12">
                                                                        สาขาแจ้งงาน&nbsp;&nbsp;:&nbsp; </div>
                                                                </td>
                                                                <td height="30">
                                                                    <?php if ($_SESSION["strUser"] == "admin") { ?>
                                                                    <select name="Dxuser" id="Dxuser">
                                                                        <option value="0" selected="selected">
                                                                            กรุณาเลือกชื่อผู้แจ้ง</option>
                                                                        <?php
                                                                            $query_D = "SELECT * FROM `tb_customer` WHERE `nameuser` = 'Mitsubishi' ORDER BY `tb_customer`.`user` ASC"; // id = '1' 
                                                                            $objQueryD = $_contextMitSu->query($query_D)->fetchAll(2);
                                                                            foreach ($objQueryD as $objResultD) {
                                                                                echo '<option value="' . $objResultD['user'] . '">' . '[' . $objResultD['user'] . '] ' . $objResultD['sub'] . '</option>';
                                                                            }
                                                                            ?>
                                                                    </select>
                                                                    <?php } else { ?>
                                                                    <input name="name_inform" type="text"
                                                                        id="name_inform" readonly="true" size="40"
                                                                        maxlength="40"
                                                                        value="<?php echo $_SESSION["strName"]; ?>" />
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="30">
                                                                    <div align="right" class="style12">
                                                                        ผู้ติดต่อ&nbsp;&nbsp;:&nbsp; </div>
                                                                </td>
                                                                <td height="30"><input name="contact" type="text"
                                                                        id="contact" size="40" maxlength="40" />
                                                                    <font color='red'>*</font>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="30">
                                                                    <div align="right" class="style12">
                                                                        ที่อยู่ผู้ติดต่อ&nbsp;&nbsp;:&nbsp; </div>
                                                                </td>
                                                                <td height="30"><textarea name="add_contact" type="text"
                                                                        id="add_contact" size="40"></textarea>
                                                                    <font color='red'>*</font>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="30">
                                                                    <div align="right" class="style12">
                                                                        เบอร์ติดต่อ&nbsp;&nbsp;:&nbsp; </div>
                                                                </td>
                                                                <td height="30"><input name="tel_contact" type="text"
                                                                        id="tel_contact" size="40" maxlength="40" />
                                                                    <font color='red'>*</font>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="30">
                                                                    <div align="right" class="style12">
                                                                        Email&nbsp;&nbsp;:&nbsp; </div>
                                                                </td>
                                                                <td height="30"><input name="email_re" type="text"
                                                                        id="email_re" size="40" maxlength="40"
                                                                        value="<?php echo $row['Email4']; ?>" />
                                                                    <font color='red'>*</font>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td height="30">
                                                                    <div align="right" class="style12">จำนวน
                                                                        พ.ร.บ.ที่ต้องการ&nbsp;&nbsp;:&nbsp;</div>
                                                                </td>
                                                                <td height="30">
                                                                    <label>
                                                                        <select name="total" id="total">
                                                                            <option value="0">--เลือก--</option>
                                                                            <option value="5">5</option>
                                                                            <option value="10">10</option>
                                                                            <option value="15">15</option>
                                                                            <option value="20">20</option>
                                                                            <option value="30">30</option>
                                                                            <option value="40">40</option>
                                                                            <option value="50">50</option>
                                                                            <option value="60">60</option>
                                                                            <option value="70">70</option>
                                                                            <option value="80">80</option>
                                                                        </select>
                                                                        <font color='red'>*</font>
                                                                        &nbsp;<span class="style12">&nbsp;ฉบับ</span>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <div align="center">
                                                                        <a class="btn btn-primary  btn-large" id="sendR"
                                                                            name="sendR">
                                                                            <i class=" icon-white icon-file"></i>
                                                                            เบิกพรบ.
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <br>
                                                        <img id="imgAvatar">
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$("#sendR").click(function() {
    if ($("#Dxuser").val() == "0") {
        alert('กรุณาเลือกสาขาแจ้งงาน');
        $("#Dxuser").focus();
        return false;
    }
    if ($("#total").val() == "0") {
        alert('กรุณาเลือกจำนวน พ.ร.บ.');
        $("#total").focus();
        return false;
    } else if ($("#contact").val() == "") {
        alert('กรุณากรอกชื่อผู้ติดต่อ');
        $("#contact").focus();
        return false;
    } else if ($("#add_contact").val() == "") {
        alert('กรุณากรอกที่อยู่ผู้ติดต่อ');
        $("#add_contact").focus();
        return false;
    } else if ($("#email_re").val() == "") {
        alert('กรุณากรอก Email ชื่อผู้ติดต่อ');
        $("#email_re").focus();
        return false;
    } else if ($("#tel_contact").val() == "") {
        alert('กรุณากรอกเบอร์โทรศัพท์ผู้ติดต่อ');
        $("#tel_contact").focus();
        return false;
    } else {

        var DATA = $('#Form_act').serialize();
        var options = {
            type: "POST",
            dataType: "json",
            async: false,
            url: "ajax/Ajax_Store.php?",
            data: DATA,
            success: function(msg) {
                var returnedArray = msg;
                if (returnedArray.status == true) {
                    alert(returnedArray.msg);
                    $('#page-content').load("pages/load_Requisition.php");
                } else {
                    alert(returnedArray.msg);
                }
            }
        };
        $.ajax(options);
        return false;
    }
});
</script>