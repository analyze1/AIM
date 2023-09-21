<?php
error_reporting(1);
include "check-ses.php";
include "../inc/connectdbs.pdo.php";

$sqlGetmoCar = 'SELECT id,`name` FROM tb_mo_car';
$_moCarArr = array();
foreach (PDO_CONNECTION::fourinsure_insured()->query($sqlGetmoCar)->fetchAll(5) as $val) {
    $_moCarArr[$val->id] = $val->name;
}

$sqlGetmoCar = 'SELECT id,`name` FROM tb_br_car';
$_brCarArr = array();
foreach (PDO_CONNECTION::fourinsure_insured()->query($sqlGetmoCar)->fetchAll(5) as $val) {
    $_brCarArr[$val->id] = $val->name;
}

$sqlQuery = "SELECT `data`.com_data,
                `data`.doc_type,
                `data`.id_data AS idselect,
                `data`.`login`,
                `data`.n_insure,
                insuree.*,
                detail_renew.*,
                detail.regis_date,
                detail.br_car,
                detail.mo_car,
                `data`.end_date,
                detail.car_regis,
                detail.car_regis_pro,
                detail.car_body,
                detail.n_motor,
                detail.price_total,
                req.EditTime,
                req.EditTime_StartDate,
                req.EditTime_EndDate,
                req.EditProduct,
                req.TotalProduct,
                detail.price_total,
                `data`.name_inform,
                detail.insure_year

                FROM
                `data` INNER JOIN detail ON ( `data`.id_data = detail.id_data )
                INNER JOIN insuree ON ( `data`.id_data = insuree.id_data )
                INNER JOIN req ON ( `data`.id_data = req.id_data )
                LEFT JOIN detail_renew ON ( `data`.id_data = detail_renew.id_data ) 
                WHERE
                `data`.id_data = '$_GET[id]' 
                ORDER BY
                `data`.id_data,
                detail_renew.id_detail DESC 
                LIMIT 0,
                1";

$objQuery = PDO_CONNECTION::fourinsure_mitsu()->query($sqlQuery);
$row = $objQuery->fetch(2);
$nowYear = date('Y'); //ปีปัจจุบัน
$yearOld = number_format($nowYear - $row['regis_date']) + 1;

//query ประวัติการเคลม
$sqlClaim = "SELECT * FROM tb_claim WHERE id_data = '$_GET[id]' ORDER BY claim_date DESC";

$resClaim = PDO_CONNECTION::fourinsure_mitsu()->query($sqlClaim);
$count = $resClaim->rowCount();

function thaiDate($datetime)
{
    $exd = explode('-', $datetime);
    $Y = $exd['0'] + 543;
    $m = $exd['1'];
    $d = $exd['2'];
    return $d . "/" . $m . "/" . $Y;
}
?>
<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="js/jquery.imask.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>

<style type="text/css">
.ntline {
    font-weight: 700 !important;
    color: #fff;
    padding: 10px 0px !important;
    background: #184981;
}

.ftable {
    background: #ecf3f7;
    width: 100%;
    border: solid thin #ccc;
}

.ftable tr td {
    padding: 10px;
    line-height: 20px;
}

tr.btline {
    border-bottom: solid thin #ccc !important;
}

.tfred {
    color: #d15b47;
}

.f18 {
    font-size: 18px;
}

.wboxfol {
    width: 80%;
    margin: 0 auto;
}

.pl20 {
    padding-left: 20px !important;
}

.pr20 {
    padding-right: 20px !important;
}

.hstc {
    text-align: center !important;
    background: #0769ab;
    color: #fff;
}

.ftr {
    text-align: right !important;
}

.ftc {
    text-align: center !important;
}

.htc {
    text-align: center !important;
    font-size: 20px;
    font-weight: 700;
    padding: 15px !important;
    background-color: #5098c9;
    color: #fff;
    border-radius: 10px 10px 0 0;
}

.bg-close {
    border-radius: 50px;
    border: 0px solid #000000;
    background-color: #000;
    color: #fff !important;
    padding: 5px;
    width: 21px;
    font-size: 1.5rem;
    cursor: pointer;
    text-align: center;
    margin-top: 5px;
    margin-right: 5px;
}

.bg-table {
    background: #eae6e6;
}

.call-center {
    text-align: center;
}
</style>

<div class="row-fluid widget-box">
    <header>
        <div class=" widget-header widget-header-flat">
            <h4><i class="icon-list"></i> รายงานเคลม</h4>
            <div style="float: right; display: block;" onclick="closePage()" class="bg-close">X</div>
        </div>
    </header>
    <div class="span8" style="margin-left:0px;">
        <div class="span12" style="background:#f2f2f2;padding: 10px;">
            <form id="saveother">
                <div class="span12 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                    <label class="hdtextL" style="color: #233f85;">ชื่อผู้เอาประกันภัย</label>
                    <span class="dttext">
                        <?php echo  $row['title'] . $row['name'] . ' ' . $row['last'] ?>
                    </span>
                </div>
                <div class="span3 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                    <label class="hdtextL" style="color: #233f85;">เลขที่รับแจ้ง</label>
                    <span class="dttext">
                        <?php echo  $row['idselect']; ?>
                        <input id="OQ" type="hidden" readonly="" name="OQ" value="<?php echo  $row['idselect']; ?>">
                    </span>
                </div>
                <div class="span3 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                    <label class="hdtextL" style="color: #233f85;">เลขที่กรมธรรม์</label>
                    <span class="dttext">
                        <?php echo  $row['n_insure']; ?>
                    </span>
                </div>
                <div class="span2 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                    <label class="hdtextL" style="color: #233f85;">ยี่ห้อ</label>
                    <span class="dttext">
                        <?php echo  $_brCarArr[$row['br_car']]; ?>
                    </span>
                </div>
                <div class="span3 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                    <label class="hdtextL" style="color: #233f85;">รุ่น</label>
                    <span class="dttext">
                        <?php echo  $_moCarArr[$row['mo_car']]; ?>
                    </span>
                </div>
                <div class="span2 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                    <label class="hdtextL" style="color: #233f85;">ปีรถ</label>
                    <span class="dttext">
                        <?php echo  $row['regis_date']; ?> (<?php echo  $yearOld; ?> ปี)
                    </span>
                </div>
                <div class="span2 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                    <label class="hdtextL" style="color: #233f85;">เลขตัวถัง</label>
                    <span class="dttext">
                        <?php echo  $row['n_motor']; ?>
                    </span>
                </div>
                <div class="span2 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                    <label class="hdtextL" style="color: #233f85;">ประเภทกรมธรรม์</label>
                    <span class="dttext">
                        <?php echo  $row['insure_year'] ?>
                    </span>
                </div>
                <div class="span12" style="margin: 0;" id="telopen">
                    <button class="btn btn-info btn-small" type="button"><i class="icon-share icon-white"></i>
                        คลิ๊กเพื่อดูเบอร์โทร
                    </button>
                </div>
                <div class="span12" id="telO" style="display:none; margin: 0;">
                    <div style="display: grid; background: #ddd; margin: 0; padding: 5px;">
                        <label class="hdtextL" style="color: #233f85;">เบอร์โทร</label>
                        <span class="dttext">
                            <input class="span2" id="tel" type="text" readonly="" name="tel"
                                value="<?php echo  substr($row['tel_mobi'],0,3).'XXXX'.substr($row['tel_mobi'],7,3); ?>">
                            <a class="btn btn-success btn-small" style="width: 30px !important;"
                                href="tel:<?php echo  $row['tel_mobi']; ?>"
                                onclick="telSaveLog('<?php echo  $row['tel_mobi']; ?>')">
                                <img src="./assets/img/Call_Icon.png" style="width: 0.8rem;" /></a>
                            <?php if ($row['tel_mobi_2'] != '') {
                                        $tel_mobi_2  = explode("\|", $row['tel_mobi_2']);
                                        foreach ($tel_mobi_2 as $val_tel) {
                                            $new_val_tel = explode("/", $val_tel); // ตัดเวลาข้างหลัง	
                                            $new_val_tel1 =  explode("|", $new_val_tel[1]);
                                         
                                            if ($new_val_tel[0] != '' && $new_val_tel1[0] != '') {
                                        ?>
                            <br />
                            <label class="hdtextL" style="color: #233f85;"><?php  echo $new_val_tel[0]; ?></label>

                            <input class="span2" id="tel" type="text" readonly="" name="tel" style="margin: 0px;"
                                value="<?php echo  substr($new_val_tel1[0],0,3).'XXXX'.substr($new_val_tel1[0],7,3); ?>">

                            <a class="btn btn-success btn-small" style="width: 30px !important;"
                                href="tel:<?php echo  $new_val_tel1[0]; ?>"
                                onclick="telSaveLog('<?php echo  $new_val_tel1[0]; ?>')">
                                <img src="./assets/img/Call_Icon.png" style="width: 0.8rem;" /></a>
                            <?php
                                            }
                                        }
                                    }
                                    ?>
                        </span>
                    </div>
                </div>
                <div class="span12" style="margin: 0;background: #ddd; padding: 5px;">
                    <label class="hdtextL" style="color: #233f85;">เพิ่มเบอร์โทร</label>
                    <span class="dttext">
                        <a id="add-tel" name="add-tel" class="btn btn-primary btn-small" type="button">
                            <i class="icon-plus icon-white"></i></a>
                        <input type="hidden" id="countlist" name="countlist" value="0" />
                        <button class="btn btn-success  btn-small" id="saveadd" type="button">
                            <i class="icon-share icon-white"></i>
                            <strong>บันทึกเบอร์โทรศัพท์</strong>
                        </button>
                    </span>
                    <div class="span12" style="margin-top:5px;" id="selectlist"></div>
                </div>
                <div class="span12" style="margin: 0; padding-top: 5px;">
                    <table id="table" border="1" cellpadding="0" cellspacing="0" class="ftable">
                        <tr>
                            <td colspan="7" class="ntline ftc">ประวัติความเสียหาย</td>
                        </tr>
                        <?php
                                    $claimAmt = 0;
                                    if ($count > 0) {
                                    ?>
                        <tr class="hstc">
                            <td>ลำดับ</td>
                            <td>เลขที่เคลม</td>
                            <td>วันที่เกิดเหตุ</td>
                            <td>สถานที่เกิดเหตุ
                                <font color='red' style='font-size:12px;'>(รายการความเสียหาย)</font>
                            </td>
                            <td>ถูก/ผิด</td>
                            <td>ประเมิน</td>
                        </tr>
                        <tbody id='claimdetail'>
                            <?php $i = 1;
                                        foreach ($resClaim->fetchAll(2) as $rowClaim) {
                                            if ($i == 1) {
                                                $claimAction = $rowClaim['claim_no'];
                                            }
                                            if ($rowClaim['claim_status'] == 'R') {
                                                $claimStatus = 'ถูก';
                                            } else if ($rowClaim['claim_status'] == 'W') {
                                                $claimStatus = '<span style="color:#d15b47;">ผิด</span>';
                                            } else if ($rowClaim['claim_status'] == 'N') {
                                                $claimStatus = 'ประมาทร่วม';
                                            } else if ($rowClaim['claim_status'] == 'C') {
                                                $claimStatus = 'รอผลคดี';
                                            }
                                            $claimAmt =  (int)$claimAmt + (int)$rowClaim['claim_amount'];
                                            if (!empty($rowClaim['claim_damage_list'])) {
                                                $claimlist = "<br><font color='red'>(" . $rowClaim['claim_damage_list'] . ")</font>";
                                            } else {
                                                $claimlist = '';
                                            }
                                        ?>
                            <tr class="btline">
                                <!--ที่-->
                                <td class="ftc"><?php echo  $i; ?></td>
                                <!--เลขที่เคลม-->
                                <td class="ftc"><?php echo  $rowClaim['claim_no']; ?></td>
                                <!--วันที่เคลม-->
                                <td><?php echo  thaiDate($rowClaim['claim_date']); ?></td>
                                <!--สถานที่เกิดเหตุ (รายการความเสียหาย)-->
                                <td class="ftl">
                                    <?php echo  $rowClaim['claim_location'] . $claimlist; ?>
                                </td>
                                <td class="ftc"><?php echo  $claimStatus; ?></td>
                                <!--ประเมิน-->
                                <td class="ftl"><?php echo  number_format($rowClaim['claim_amount']); ?>
                                </td>
                            </tr>
                            <?php
                                            $i++;
                                        } ?>
                            <tr>
                                <td colspan="4" style="text-align: center;background: #6fb3e0;">
                                    มีประวัติความเสียหายจำนวน <span class="tfred f18"><?php echo  $count; ?>
                                    </span>ครั้ง </td>
                                <td colspan="2" style="text-align: center;background: #6fb3e0;">รวมเป็นเงิน
                                    <span class="tfred f18">
                                        <?php echo  number_format($claimAmt); ?></span> บาท
                                </td>
                            </tr>
                            <?php } else { ?>
                            <tr>
                                <td colspan="6" class="hstc">ไม่มีประวัติการเคลม</td>
                            </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </form>
        </div>
    </div>
    <div class="span4" style="background:#dcdcdc;">
        <div class="box">
            <header style="height: 37px; display: flex; align-items: center;background: #0769ab;">
                <h5 style="margin:0; color: #fff;padding: 5px;">
                    <i class="icon-plus"></i> บันทึก [ <font color="#FF6600"><b> การติดตาม </b></font> ]
                </h5>
            </header>
            <div id="collapse4" class="body">
                <div id="content_wait">
                    <form id="savefol" style="margin: 0;">
                        <input id="main" type="hidden" value="R" name="main">
                        <input id="4_login" type="hidden" value="DEALER" name="4_login" readonly="">
                        <input id="iddata" type="hidden" value="<?php echo  $row['idselect']; ?>" name="iddata"
                            readonly="">
                        <input id="opentime" type="hidden" value="<?php echo  date('Y-m-d H:i:s'); ?>" name="opentime"
                            readonly="">
                        <div class="span6 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                            <label class="hdtextL" style="color: #233f85;">วันที่ติดตาม</label>
                            <span class="dttext">
                                <input type="text" size='20' class="span12" value="<?php echo  date('d/m/Y'); ?>"
                                    name="datenow" id="datenow" readonly />
                                <input type="hidden" name="claimAction" id="claimAction"
                                    value="<?php echo  $claimAction; ?>">
                            </span>
                        </div>
                        <div class="span6 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                            <label class="hdtextL" style="color: #233f85;">นัดครั้งถัดไป</label>
                            <span class="dttext">
                                <input type="text" size='20' class="span12" value="" name="datefol" id="datefol" />
                            </span>
                        </div>
                        <div class="span6 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                            <label class="hdtextL" style="color: #233f85;">นัดหมายซ่อม</label>
                            <span class="dttext">
                                <input type="text" size='20' class="span12" value="" name="date_repair"
                                    id="date_repair" />
                            </span>
                        </div>
                        <div class="span6 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                            <label class="hdtextL" style="color: #233f85;">ผู้แจ้ง</label>
                            <span class="dttext">
                                <input type="text" size='20' class="span12" value="" name="informer" id="informer" />
                            </span>
                        </div>
                        <div class="span6 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                            <label class="hdtextL" style="color: #233f85;">รายละเอียด</label>
                            <span class="dttext">
                                <textarea id="textdetail" class="span12" name="textdetail" rows="1"></textarea>
                            </span>
                        </div>
                        <div class="span6 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                            <label class="hdtextL" style="color: #233f85;">สถานะ</label>
                            <span class="dttext">
                                <select name='status_claim' id='status_claim' class="span12"
                                    onchange="handleClaimStatus(this.value)">
                                    <option value='N'>ยังไม่จัดซ่อม</option>
                                    <option value='Y'>จัดซ่อมแล้ว</option>
                                </select>
                            </span>
                        </div>
                        <div class="span6 mrpd10" style="display: none;margin: 0;padding: 5px;" id="fixDone">
                            <label class="hdtextL" style="color: #233f85;">ซ่อมแล้ว</label>
                            <span class="dttext">
                                <select name='status_claim_done' id='status_claim_done' class="span12">
                                    <option value=''>--เลือกสถานะซ่อม--</option>
                                    <option value='1'>dealer นั้น</option>
                                    <option value='2'>ห้างอื่น</option>
                                    <option value='3'>อู่อื่น</option>
                                </select>
                            </span>
                        </div>
                        <div class="span6 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                            <label class="hdtextL" style="color: #233f85;">รายการความเสียหาย</label>
                            <span class="dttext">
                                <input type="text" size='20' class="span12" value="" name="damage" id="damage" />
                            </span>
                        </div>
                        <div class="span6 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                            <label class="hdtextL" style="color: #233f85;">ราคาประเมิน</label>
                            <span class="dttext">
                                <input type="text" size='20' class="span12" value="0.00" name="cost_estimate"
                                    id="cost_estimate" />
                            </span>
                        </div>
                        <div class="span12 mrpd10" style="display: grid;margin: 0;padding: 5px;">
                            <button class="btn btn-success" id="saveaction" type="button">
                                <i class="icon-ok-sign icon-white"></i>
                                <strong>บันทึกการติดตามเคลม</strong>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid widget-box">
    <div class="box">
        <header>
            <div class="widget-header widget-header-flat">&nbsp;&nbsp; <h4><i class="icon-move"></i>
                    ข้อมูลการติดตาม</h4>
            </div>
        </header>
        <div class="span12" style="padding: 10px; margin: 0px;background: #fff;">
            <table id="example1" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>เวลาบันทึก</th>
                        <th>เลขที่เคลม</th>
                        <th>รายละเอียด</th>
                        <th>ราคาประเมิน</th>
                        <th>วันที่นัด</th>
                        <th>วันที่นัดหมายซ่อม</th>
                        <th>ผู้แจ้ง</th>
                        <th>ผู้ติดตาม</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="row-fluid widget-box">
    <div class="box">
        <header>
            <div class="widget-header widget-header-flat">&nbsp;&nbsp; <h4><i class="icon-move"></i>
                    ข้อมูลการโทร</h4>
            </div>
        </header>
        <div class="span12" style="padding: 10px; margin: 0px;background: #fff;">
            <table id="example2" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>เวลาบันทึก</th>
                        <th>สถานะ</th>
                        <th>เบอร์โทรศัพท์</th>
                        <th>รายละเอียด</th>
                        <th>ผู้ติดตาม</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
var _checkLink = localStorage.getItem('_linkName');

function closePage() {
    $('#page-content').empty();
    $('#closepop').css('display', 'none');

    _checkLink == 'รายงานติดตามเคลม' ? $('#page-content').load("pages/form_report_follow_claim.php") : $(
        '#page-content').load("pages/load_Claim.php");
}

$(document).ready(function() {
    $("#telopen").click(function(event) {
        $("#telO").show();
        $("#telopen").hide();
    });
});
$('#datefol').datepicker({
    language: "th",
    autoclose: true,
    format: 'dd/mm/yyyy',
    startDate: 'toda',
    min: 0
});
$('#date_repair').datepicker({
    language: "th",
    autoclose: true,
    format: 'dd/mm/yyyy',
    startDate: 'toda',
    min: 0
});

function handleClaimStatus(val) {
    var _fixDone = document.getElementById('fixDone');
    val == 'Y' ? _fixDone.style.display = 'grid' : _fixDone.style.display = 'none';
}
var dataid = $('#OQ').val();
jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "date-th2-pre": function(a) {
        var x;
        if ($.trim(a) !== '') {
            // a คือข้อความวันที่ใน column ของแต่ละแถว
            // ส่วนนี้จะเป็นส่วนแยก เอาค่าต่างๆ ไปใช้สร้างวันที่
            var dateData = $.trim(a);
            var d_date = dateData.split("/");
            var yearVal = d_date[2] - 543;
            // จบการแยกค่าต่างๆ ออกจากข้อความ
            var myDate = new Date(yearVal, d_date[1] - 1, d_date[0], 0, 0, 00, 000);
            // เราจะเก็บวันที่ที่ถูกแปลงเป็นตัวเลขด้วย myDate.getTime() ไว้ในตัวแปร x
            // ไว้สำหรับเทียบค่ามากกว่า น้อยกว่า
            x = (myDate.getTime()) * 1;

        } else {
            // ภ้าช่องนั้นมีค่าเป็นว่าง กำหนดเป็น x เป็น Infinity
            x = Infinity;
        }
        // คืนค่ารูปแบบวันที่ที่ถูกแปลงเป็นตัวเลข เพื่อนำไปจัดเรียง
        return x;
    },
    "date-th2-asc": function(a, b) { // กรณีให้เรียงจากน้อยไปมาก
        return a - b;
    },
    "date-th2-desc": function(a, b) { // กรณีให้เรียงจากมากไปน้อย
        return b - a;
    }
});

var tables = $('#example1').DataTable({
    "ajax": `ajax/ajax_claimfol_detail.php?DataID=${dataid}&Controller=Getinfo`,
    "bFilter": false,
    "bInfo": false,
    "destroy": true,
    "columnDefs": [{
            "type": 'date-th2',
            "targets": 0,
            "data": 'timecall',
            'bSortable': false,
            "bSearchable": false,
            "className": 'bg-table call-center'
        },
        {
            "targets": 1,
            "data": 'claim_no',
            "defaultContent": "",
            "className": 'call-center'
        },
        {
            "targets": 2,
            "data": 'detailtext',
            "defaultContent": "",
            "className": 'bg-table call-center'
        },
        {
            "targets": 3,
            "data": 'cost_estimate',
            "defaultContent": "",
            "className": 'call-center'
        },
        {
            "targets": 4,
            "data": 'datefollow',
            "defaultContent": "",
            "className": 'bg-table call-center'
        },
        {
            "targets": 5,
            "data": 'date_repair',
            "defaultContent": "",
            "className": 'call-center'
        },
        {
            "targets": 6,
            "data": 'informer',
            "defaultContent": "",
            "className": 'bg-table call-center'
        },
        {
            "targets": 7,
            "data": 'userdetail',
            "defaultContent": "",
            "className": 'call-center'
        }
    ]
});

var tables2 = $('#example2').DataTable({
    "ajax": `ajax/ajax_claimfol_detail.php?DataID=${dataid}&Controller=GetCall`,
    "bFilter": false,
    "bInfo": false,
    "destroy": true,
    "columnDefs": [{
            "type": 'date-th2',
            "targets": 0,
            "data": 'TimeCalll',
            'bSortable': false,
            "bSearchable": false,
            "className": 'bg-table call-center'
        },
        {
            "targets": 1,
            "data": 'Status',
            "defaultContent": "",
            "className": 'call-center'
        },
        {
            "targets": 2,
            "data": 'TelNumber',
            "defaultContent": "",
            "className": 'bg-table call-center'
        },
        {
            "targets": 3,
            "data": 'Detail',
            "defaultContent": "",
            "className": 'call-center'
        },
        {
            "targets": 4,
            "data": 'Staff',
            "defaultContent": "",
            "className": 'bg-table call-center'
        }
    ]
});

$("#add-tel").click(function(event) {
    var listcount = $('#countlist').val();
    $('#countlist').val(++listcount);
    $('#selectlist').append(`
            <div id="listadd${listcount}" style="padding: 2px;">
                <button type="button" class="btn btn-danger btn-small" onclick="$('#list_tel${listcount}').remove();$('#teladd${listcount}').remove();$('#listadd${listcount}').remove(); $('#countlist').val($('#countlist').val()-1); $('#add-tel').show()">
                    <i class="icon-remove"></i>
                </button>
                <select name="list_tel[]" id="list_tel${listcount}" class="span2" style="margin: 0;">
                    <option value="N">กรุณาเลือก</option>
                    <option value="เบอร์บ้าน">เบอร์บ้าน</option>
                    <option value="เบอร์มือถือ">เบอร์มือถือ</option>
                    <option value="เบอร์ที่ทำงาน">เบอร์ที่ทำงาน</option>
                </select>
                <input class="span2" name="teladd[]" id="teladd${listcount}" type="text" value="" maxlength="12" style="margin: 0;">
            </div>`);
    if ($('#countlist').val() > 2) {
        $('#add-tel').hide();
    }
});
$('#saveadd').click(function(event) {
    datauser = ($('#saveother').serialize());
    var options = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_SaveTel.php",
        data: datauser,
        success: function(msg) {
            alert(msg);
            tables.ajax.reload();
        },
        error: function(msg) {
            alert('การบันทึกผิดพลาด');
        }
    };
    $.ajax(options);
});

$('#saveaction').click(function(event) {
    if ($('#textdetail').val().length < 5) {
        alert('กรุณากรอกรายละเอียดมากกว่า 5 ตัวอักษร');
        return false;
    }
    if ($('#datefol').val() == '') {
        alert('กรุณากรอกนัดหมายครั้งถัดไป');
        return false;
    }
    if ($('#date_repair').val() == '') {
        alert('กรุณากรอกนัดซ่อม');
        return false;
    }
    if ($('#informer').val() == '') {
        alert('กรุณากรอกผู้แจ้ง');
        return false;
    }
    if ($('#damage').val() == '') {
        alert('กรุณากรอกความเสียหาย');
        return false;
    }
    if ($('#cost_estimate').val() == '') {
        alert('กรุณากรอกราคาประเมิน');
        return false;
    }
    /*แผนที่1*/
    /*if ($('#txt_claim_no').val()=='') {
        alert('กรุณาเลือกเลขที่เคลม');
        return false;
    }*/
    /*END แผนที่1*/

    /*แผนที่2*/
    if ($('#txt_date_claim').val() == '') {
        alert('กรุณาเลือกวันเกิดเหตุ');
        return false;
    }
    /*END แผนที่2*/
    function js_check(elements) {
        for (var z = 0; z < elements.length; z++) {
            if (elements[z].checked)
                return true;
        }
        return false;
    }
    $("#printDeal").removeAttr('disabled')
    datauser = ($('#savefol').serialize());
    //$('#saveaciton').attr('disabled', 'disabled');
    var options = {
        type: "POST",
        dataType: "json",
        url: "ajax/Ajax_SaveClaimFol.php",
        data: datauser,
        success: function(msg) {

            alert(msg);
            tables.ajax.reload();
            // $.post("ajax/ajax_detailclaim.php?id=<?php echo  $_GET['id']; ?>", {}, function(data) {
            //     $("#claimdetail").html(data);
            // });
        },
        error: function(msg) {
            alert('การบันทึกผิดพลาด');
            $("#saveaction").removeAttr('disabled');
        }
    };
    $.ajax(options);
});
$('#cost_estimate').iMask({
    type: 'number'
});

function checkclaimno() {
    var search = {
        url: "ajax/ajax_checkclaim_no.php",
        type: "POST",
        dataType: "JSON",
        data: {
            id_data: "<?php echo  $_GET['id']; ?>",
            //claim_no:$("#txt_claim_no").val() //แผนที่1
            id: $("#txt_date_claim").val() //แผนที่2
        },
        success: function(data) {
            if (data.status == 'Y') {

                $("#damage").attr('readonly', true);
                $("#damage").val(data.text);
            } else {

                $("#damage").attr('readonly', false);
                $("#damage").val('');
            }
        }
    };
    $.ajax(search);
}
async function postApiAsync(_url, _data) {
    return await $.ajax({
        type: "POST",
        url: _url,
        data: _data,
        dataType: "JSON",
        success: (response) => {
            return response;
        },
        error: (err) => {
            return err;
        }
    });
}
async function telSaveLog(telNumber) {
    let url = './services/OutboundLog/outbound.controller.php';
    let params = {
        Controller: 'SaveInboundLogclaim',
        Number: telNumber,
        DataID: '<?php echo  $row['idselect']; ?>'
    };

    let res = await postApiAsync(url, params);
}
</script>