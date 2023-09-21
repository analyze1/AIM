<?php
include "check-ses.php";
include "../inc/connectdbs.pdo.php";
?>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>
<!-- <script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script> -->
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- <link rel="stylesheet" type="text/css" href="css/cupertino/jquery-ui-1.9.2.custom.min.css" /> -->
<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css" />
<style>
#container {
    max-width: 100%;
    margin: auto;
    height: 640px;
    margin: 0 auto;
}
</style>
<div class="container-fluid outer">
    <div class="row-fluid">
        <!-- .inner -->
        <div class="span12 inner">
            <!--Begin Datatables-->
            <div class="row-fluid">
                <div class="span12">
                    <div class="box">
                        <header>
                            <h5>รายงานยอดขาย [Mitsubishi]</h5>
                        </header>


                        <div id="collapse4" class="body">


                            <form action="report/report_sales_com_suzuki_xls.php" target="_blank" id="DLREPORT"
                                method="post" name="form_search" onsubmit="return check_input();">
                                <div class="control-group">
                                    <table width="800" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="50%">
                                                <input type="checkbox" name="chk_iddata" id="chk_iddata"
                                                    value="chk_iddata" />
                                                วันที่แจ้งงาน <input name="dpd_iddata" type="text" class="span2"
                                                    id="dpd_iddata" style="width:100px;" value="" autocomplete="off"
                                                    onchange="ch_iddata();"> ถึง <input name="dpd_iddata2" type="text"
                                                    class="span2" id="dpd_iddata2" style="width:100px;" value=""
                                                    autocomplete="off" onchange="ch_iddata();">
                                            </td>
                                            <td width="700"><input type="checkbox" name="chk_enddate" id="chk_enddate"
                                                    value="chk_enddate" />
                                                วันหมดอายุ
                                                <input name="dpd_enddate" type="text" class="span2" id="dpd_enddate"
                                                    autocomplete="off" style="width:100px;" value=""
                                                    onchange="ch_enddate();" />
                                                ถึง
                                                <input name="dpd_enddate2" type="text" class="span2" id="dpd_enddate2"
                                                    autocomplete="off" style="width:100px;" value=""
                                                    onchange="ch_enddate();" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="chk_datestart" id="chk_datestart"
                                                    value="chk_datestart" />
                                                วันทีคุ้มครอง
                                                <input name="dpd_datestart" type="text" class="span2" id="dpd_datestart"
                                                    autocomplete="off" style="width:100px;" value=""
                                                    onchange="ch_datestart();" />
                                                ถึง
                                                <input name="dpd_datestart2" type="text" class="span2"
                                                    autocomplete="off" id="dpd_datestart2" style="width:100px;" value=""
                                                    onchange="ch_datestart();" />
                                            </td>
                                            <td id='show_iduser'>
                                                <?php if ($_SESSION['strUser'] == 'admin') { ?>
                                                <input type="checkbox" name="chk_iduser" id="chk_iduser"
                                                    value="chk_iduser" />
                                                <?php } else { ?>
                                                <input type="checkbox" name="chk_iduser" id="chk_iduser"
                                                    value="chk_iduser" checked />
                                                <?php } ?>
                                                ตัวแทนจำหน่าย
                                                <select name="txt_iduser" id="txt_iduser" onchange='ch_iduser();'>
                                                    <?php if ($_SESSION['strUser'] == 'admin') { ?>
                                                    <option value="">- เลือก -</option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $_SESSION['strUser']; ?>">
                                                        <?php echo $_SESSION['strUser']; ?></option>
                                                    <?php } ?>
                                                    <?php $query = "SELECT * FROM tb_customer WHERE nameuser = 'Mitsubishi' ORDER BY user ASC";
                                                  
                                                    $objQuery =PDO_CONNECTION::fourinsure_mitsu()->query($query);
                                                    foreach ($objQuery->fetchAll(2) as $row )
                                                     {
                                                        echo "<option value='" . $row['user'] . "'>" . '[' . $row['user'] . ']' . ' ' . $row['title_sub'] . ' ' . $row['sub'] . "</option>";
                                                    }
                                                    ?>
                                                </select>


                                            </td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </table>


                                    <button type="submit" class="btn btn-primary "><i
                                            class="icon-download-alt icon-white"></i> Download to Excel</button>


                                </div>
                                <div class="text-effect">
                                    <span style="    color: red;"> **หมายเหตุ ถ้าต้องการดึง report มากกว่า 6 เดือน
                                        อาจต้องใช้เวลาสักครู่ หรือ (ติดต่อฝ่ายสารสนเทศ)**</span>
                                </div>
                            </form>


                            <div id="content_search" style="display:none;">
                            </div>
                        </div>
                        <!--End Datatables-->

                        <hr>

                        <!-- /.row-fluid -->
                    </div>
                    <!-- /.inner -->
                </div>
                <!-- /.row-fluid -->
            </div>
            <!-- /.outer -->
        </div>
    </div>
</div>


<script>
$("#dpd_iddata").datepicker({
    format: 'yyyy-mm-dd'
});
$("#dpd_iddata2").datepicker({
    format: 'yyyy-mm-dd'
});
$("#dpd_enddate").datepicker({
    format: 'yyyy-mm-dd'
});
$("#dpd_enddate2").datepicker({
    format: 'yyyy-mm-dd'
});
$("#dpd_datestart").datepicker({
    format: 'yyyy-mm-dd'
});
$("#dpd_datestart2").datepicker({
    format: 'yyyy-mm-dd'
});


function ch_iddata() {
    if ($("#dpd_iddata").val() != '' || $("#dpd_iddata2").val() != '') {
        document.getElementById("chk_iddata").checked = true;
        //if($("#dpd_iddata").val()!=''){$("#dpd_iddata2").focus();}else if($("#dpd_iddata2").val()!=''){$("#dpd_iddata").focus();}
    } else {
        document.getElementById("chk_iddata").checked = false;
    }
}

function ch_enddate() {
    if ($("#dpd_enddate").val() != '' || $("#dpd_enddate2").val() != '') {
        document.getElementById("chk_enddate").checked = true;
        //if($("#dpd_enddate").val()!=''){$("#dpd_enddate2").focus();}else if($("#dpd_enddate2").val()!=''){$("#dpd_enddate").focus();}
    } else {
        document.getElementById("chk_enddate").checked = false;
    }
}

function ch_datestart() {
    if ($("#dpd_datestart").val() != '' || $("#dpd_datestart2").val() != '') {
        document.getElementById("chk_datestart").checked = true;
        //if($("#dpd_datestart").val()!=''){$("#dpd_datestart2").focus();}else if($("#dpd_datestart2").val()!=''){$("#dpd_datestart").focus();}
    } else {
        document.getElementById("chk_datestart").checked = false;
    }
}

function ch_iduser() {
    if ($("txt_iduser").val() == "") {
        document.getElementById("chk_iduser").checked = false;
    } else {
        document.getElementById("chk_iduser").checked = true;
    }
}

function check_input() {
    if (<?php echo $_SESSION['strUser'] == 'admin' ?>) {
        if (document.getElementById("chk_iddata").checked == false && document.getElementById("chk_datestart")
            .checked ==
            false && document.getElementById("chk_enddate").checked == false && document.getElementById("chk_iduser")
            .checked == false) {
            alert("กรุณาเลือกวันค้นหาด้วยครับ");
            return false;
        }

    } else {
        if (document.getElementById("chk_iddata").checked == false && document.getElementById("chk_datestart")
            .checked ==
            false && document.getElementById("chk_enddate").checked == false) {
            alert("กรุณาเลือกวันค้นหาด้วยครับ");
            return false;
        }

        if (document.getElementById("chk_iddata").checked == true) {
            if ($("#dpd_iddata").val() == "") {
                alert("กรุณาเลือกวันที่");
                $("#dpd_iddata").focus();
                return false;
            }
            if ($("#dpd_iddata2").val() == "") {
                alert("กรุณาเลือกวันที่");
                $("#dpd_iddata2").focus();
                return false;
            }
        }
        if (document.getElementById("chk_enddate").checked == true) {
            if ($("#dpd_enddate").val() == "") {
                alert("กรุณาเลือกวันที่");
                $("#dpd_enddate").focus();
                return false;
            }
            if ($("#dpd_enddate2").val() == "") {
                alert("กรุณาเลือกวันที่");
                $("#dpd_enddate2").focus();
                return false;
            }
        }
        if (document.getElementById("chk_datestart").checked == true) {
            if ($("#dpd_datestart").val() == "") {
                alert("กรุณาเลือกวันที่");
                $("#dpd_datestart").focus();
                return false;
            }
            if ($("#dpd_datestart2").val() == "") {
                alert("กรุณาเลือกวันที่");
                $("#dpd_datestart2").focus();
                return false;
            }
        }
        if (document.getElementById("chk_iduser").checked == true) {
            if ($("#txt_iduser").val() == "") {
                alert("กรุณาเลือกดิลเลอร์");
                $("#txt_iduser").focus();
                return false;
            }
        }

        if (<?php echo $_SESSION['claim'] != 'ADMIN' ?>) {
            $("#show_iduser").hide();
        }
    }
}
</script>