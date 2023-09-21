<link type="text/css" rel="stylesheet" href="assets/css/modal.css">
<link rel="stylesheet" type="text/css" href="assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="assets/css/modalbank.css">
<link rel="stylesheet" type="text/css" href="css/renew-suzuki-select.css">
<script type="text/javascript" charset="utf-8" language="javascript" src="assets/js/bootstrap-typeahead.js"></script>
<script src="js/new/jquery.number.js"></script>
<script type="text/javascript" src="js/jquery.imask.js"></script>
<script src="js/jquery.maskedinput-1.2.2.js"></script>

<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/new/bootstrap-datepicker-thai.js"></script>
<script type="text/javascript" src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
<link rel="stylesheet" href="assets/css/tooltip.css">

<style>

.underline-none:hover{
  
    color: blue !important;
}
.underline-none{
    color: blue !important;
}
</style>
<?php include 'renew-suzuki-select.php'; 
$datenow = date("Y-m-d");

if($_SESSION['strUser']== 'admin')
{
    $sqlagent = "SELECT AgentDis FROM  partner_code_center WHERE DealerCode = '$row[login]' AND StartDate <= '$datenow' AND EndDate >= '$datenow'";
    $sqlagent_query  = PDO_CONNECTION::fourinsure_insured()->query($sqlagent)->fetch(7);
} else
{
    $sqlagent = "SELECT AgentDis FROM  partner_code_center WHERE DealerCode = '$_SESSION[strUser]' AND StartDate <= '$datenow' AND EndDate >= '$datenow'";
    $sqlagent_query  = PDO_CONNECTION::fourinsure_insured()->query($sqlagent)->fetch(7);

}
echo "<script> var _NewAgentdis = '$sqlagent_query'</script>";
?>

<link rel="stylesheet" href="css/renew-page.css" type="text/css">
<script type="text/javascript" src="data_table/js/jquery.dataTables.js"></script>
<link type="text/css" rel="stylesheet" type="text/css" href="data_table/css/jquery.dataTables.css">

<div class="container-fluid outer">
    <div class="row-fluid">
        <!-- .inner -->
        <div class="span12 inner">
            <!--Begin Datatables-->
            <div class="row-fluid">
                <div class="span12 anime" id='editspan'>
                    <div class="box">
                        <form id="saveother">
                            <div class="span12">
                                <div class="tab-content" id="myTabContent">
                                    <header>
                                        <span class="left-header">
                                            <i class="icon-list"></i> <b>ข้อมูลลูกค้า</b>
                                        </span>
                                        <span class="right-header">
                                            <div class="span12 mrpd10" style="text-align: right;">
                                                <span>[<?php echo $_resultDatas->login; ?>]
                                                    <?php echo $_resultDatas->nameInform; ?></span>
                                            </div>
                                        </span>
                                    </header>
                                    <div id="showData" class="tab-pane fade active in">
                                        <div class="span12 boxshow">
                                            <div class="span12 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtextL"
                                                    style="color: #233f85;">ชื่อผู้เอาประกันภัย</label>
                                                <span class="dttext">
                                                    <?php echo $_resultDatas->nameFull; ?>
                                                </span>
                                            </div>
                                            <div class="span12 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtext" style="color: #233f85;">ที่อยู่ </label>
                                                <span class="dttext">
                                                    <?php echo $_resultDatas->address; ?></span>
                                            </div>
                                            <div class="span2 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtext" style="color: #233f85;">เลขที่ต่ออายุ </label>
                                                <span class="dttext">
                                                    <?php
                                                    echo $_resultDatas->insureID;
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="span2 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtext" style="color: #233f85;">วันคุ้มครอง</label>
                                                <span class="dttext"
                                                    style="color: red"><?php echo $_resultDatas->startDate; ?></span>
                                            </div>
                                            <div class="span2 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtext" style="color: #233f85;">ยี่ห้อ </label>
                                                <span class="dttext"><?php echo $_resultDatas->bran; ?></span>
                                            </div>
                                            <div class="span2 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtext" style="color: #233f85;">รุ่น </label>
                                                <span class="dttext">
                                                    <?php echo $_resultDatas->mocar; ?>
                                                </span>
                                            </div>
                                            <div class="span1 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtext" style="color: #233f85;">ปีจดทะเบียน </label>
                                                <span class="dttext">
                                                    <?php echo $_resultDatas->YearCar; ?>
                                                </span>
                                            </div>
                                            <div class="span1 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtext" style="color: #233f85;">อายุรถ </label>
                                                <span class="dttext">
                                                    <?php echo $_resultDatas->carOld; ?> ปี
                                                </span>
                                            </div>
                                            <div class="span1 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtext" style="color: #233f85;">สีรถ </label>
                                                <span class="dttext">
                                                    <?php echo $_resultDatas->color; ?>
                                            </div>
                                            <div class="span1 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtext" style="color: #233f85;">ทะเบียน </label>
                                                <span class="dttext"><?php echo $_resultDatas->regis; ?></span>
                                            </div>
                                            <div class="span1 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtextL" style="color: #233f85;">จังหวัดทะเบียน
                                                </label>
                                                <span class="dttext"><?php echo $_resultDatas->provinceName; ?></span>
                                            </div>

                                            <div class="span2 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtext" style="color: #233f85;">เลขตัวถัง </label>
                                                <span class="dttext">
                                                    <?php echo $_resultDatas->carBody; ?>
                                                </span>
                                            </div>

                                            <div class="span2 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtextL" style="color: #233f85;">เลขเครื่องยนต์</label>
                                                <span class="dttext">
                                                    <?php echo $_resultDatas->nMotor; ?>
                                                </span>
                                            </div>
                                            <div class="span2 mrpd10" style="display: grid;margin-bottom: 0.7rem;">
                                                <label class="hdtext" style="color: #233f85;">กรมธรรม์ </label>
                                                <span class="dttext">
                                                    <?php
                                                    echo $_resultDatas->insuranceNumber;
                                                    ?>
                                                </span>
                                            </div>
                                            <div class='span12' style='margin:0;background-color:#eee;'
                                                id='show_detail_tel'>
                                                <div style="display:grid;" class="telCusInfoID">
                                                    <label class="hdtext" style="margin-left: 10px">เบอร์โทรศัพท์
                                                        :</label>
                                                </div>
                                            </div>
                                        </div> <!-- END boxshow-->
                                        <div style="clear:both"></div>
                                    </div> <!-- END showData -->

                                    <div class="">
                                    <!-- <div class="hiddenByMount"> -->
                                        <ul id="dataEdit" class="collapse in" style="margin: 0 !important;">
                                            <li class="">
                                                <div style="clear:both;"></div>
                                                <div class="box">
                                                    <header>
                                                        <span class="left-header">
                                                            <i class="icon-list"></i> <b>ประวัติเคลม [ทำประวัติเคลม]</b>
                                                        </span>
                                                        <span class="right-header">
                                                            <!-- <div class='txtp bg-red-500 cursor-pointer' onclick='openQuotationHandle()' 
                                                            data-toggle="modal" data-target="#myinformQuotation">
                                                                ทำใบเสนอราคา
                                                            </div> -->

                                                            <div class='txtp bg-red-500 cursor-pointer' onclick="funcQuatationHandle(`1`,`<?php echo $row['id_data'];?>`,
                                                            `<?php echo $_resultDatas->carOld;?>`,
                                                            `<?php echo $_resultDatas->mocarID;?>`,
                                                            `<?php echo $row['car_id'];?>`)">

                                                                ทำใบเสนอราคา
                                                            </div>

                                                            <div class='txtp bg-blue-500 cursor-pointer'>
                                                                ทุนต่ออายุ <?php echo number_format($Cost_NEW, 0); ?>
                                                            </div>
                                                            <div class='txtp bg-yellow-500 cursor-pointer'
                                                                onclick='show_claim();'>
                                                                <i class="icon-share icon-white"></i>
                                                                ดูประวัติเคลม
                                                            </div>
                                                            <div class='txtp bg-yellow-500 cursor-pointer'
                                                                id="updclaim">
                                                                Update Claim
                                                            </div>
                                                            <div class='txtp bg-green-500 cursor-pointer'
                                                                id="printDeal">
                                                                <i class="icon-print icon-white"></i>&nbsp;พิมพ์ใบเตือน
                                                            </div>
                                                            <div class='txtp bg-green-500 cursor-pointer'
                                                                onclick="slide_open();">
                                                                ติดตามงาน
                                                            </div>
                                                            <div class='txtp bg-blue-500 cursor-pointer'
                                                                id="warming-renew" data-toggle="modal"
                                                                data-target="#sendSmsQuotation" onclick="sendSMSQuotationDealer(
                                                                    `<?php echo $row['idselect']; ?>`,
                                                                    `<?php echo $_deitalFirstID; ?>`,
                                                                    `F`
                                                                    )">
                                                                SMS ใบเตือน
                                                            </div> <!-- renew dealer -->

                                                            <div>
                                                                <ul class="nav nav-tabs" id="myTab"
                                                                    style="width: 100%;float: right; display:none;">
                                                                    <li class="active"><a data-toggle="tab"
                                                                            href="#showData">VIEW</a></li>
                                                                    <li><a data-toggle="tab" href="#editData">EDIT</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </span>
                                                    </header>
                                                </div>

                                                <div style="clear:both;"></div>

                                                <!-- tap none hidden-->
                                                <ul class="collapse" id="datain" style="margin:0 auto;">
                                                    <li style="background:#fff;">

                                                        <div class="span12" style='display:none;'>
                                                            <div class="span5 ">
                                                                <!-- <label class="hdtext">รายละเอียดเพิ่มเติม   :</label> -->
                                                                <span class="dttext">
                                                                    <div style="float:left; margin: 0 0 10px 10px;">
                                                                        <!-- start hiden zone -->
                                                                        <div style="display:none;">
                                                                            <input id="OQ" type="hidden" readonly=""
                                                                                name="OQ"
                                                                                value="<?php echo $row['idselect']; ?>">
                                                                            <input id="n_insure" type="hidden"
                                                                                readonly="" name="n_insure"
                                                                                value="<?php echo $row['n_insure']; ?>">
                                                                            <input id="dealer" type="hidden" readonly=""
                                                                                name="dealer"
                                                                                value="<?php echo $row['login']; ?>">
                                                                            <input id="dealer_name" type="hidden"
                                                                                readonly="" name="dealer_name"
                                                                                value="[<?php echo $row['login']; ?>] <?php echo $row['name_inform']; ?>">
                                                                            <input id="car_id" type="hidden" readonly=""
                                                                                name="car_id"
                                                                                value="<?php echo $row['car_id']; ?>">
                                                                            <input id="title" class="span3"
                                                                                type="hidden" readonly="" name="title"
                                                                                value="<?php echo $row['title']; ?>">
                                                                            <input id="fristname" type="hidden"
                                                                                readonly="" name="fristname"
                                                                                value="<?php echo $row['name']; ?>">
                                                                            <input id="lastname" type="hidden"
                                                                                readonly="" name="lastname"
                                                                                value="<?php echo $row['last']; ?>">
                                                                            <input id="br_car" type="hidden" readonly=""
                                                                                name="br_car"
                                                                                value="<?php echo $_SESSION["BrC"]['name'][$row['br_car']]; ?>">
                                                                            <input id="mo_car" type="hidden" readonly=""
                                                                                name="mo_car"
                                                                                value="<?php echo $_SESSION["MoC"]['name'][$row['mo_car']]; ?>">
                                                                            <input type="hidden" name="mocarid"
                                                                                id="mocarid"
                                                                                value="<?php echo $row['mo_car']; ?>">
                                                                            <input id="car_body" type="hidden"
                                                                                readonly="" name="car_body"
                                                                                value="<?php echo $row['car_body']; ?>">
                                                                            <input id="n_motor" type="hidden"
                                                                                readonly="" name="n_motor"
                                                                                value="<?php echo $row['n_motor']; ?>">
                                                                            <input class="span6" id="old_cost"
                                                                                type="hidden" readonly=""
                                                                                name="old_cost"
                                                                                value="<?php echo $row['cost']; ?>">
                                                                            +
                                                                            <input class="span3" id="old_price"
                                                                                type="hidden" name="old_price"
                                                                                value="<?php echo number_format($add_price_old, 0); ?>"
                                                                                readonly="">
                                                                            <input class="span5" style="color:red;"
                                                                                id="costfix" type="hidden" readonly=""
                                                                                name="costfix"
                                                                                value="<?php echo $_resultDatas->carOld; ?>">
                                                                            <input class="span5" style="color:green;"
                                                                                id="costselect" type="hidden"
                                                                                readonly="" name="costselect"
                                                                                value="<?php echo number_format($costselect[0], 0); ?>">
                                                                            <input name="txt_iddata" type="hidden"
                                                                                class="span6" id="txt_iddata"
                                                                                value="<?php echo $row['id_data'] ?>" />
                                                                        </div>
                                                                        <!-- end hiden zone -->

                                                                        <label><span class="cs_title">รายละเอียดพิเศษ
                                                                                :</span></label>

                                                                        <textarea name="txt_remark" type="text"
                                                                            id="txt_remark"
                                                                            style="width:300px; margin-bottom: 0px;"
                                                                            cols='3' value=""></textarea>
                                                                        <textarea style="display:none;"
                                                                            name="old_remark"
                                                                            id="old_remark"><?php echo $row['remark']; ?></textarea>
                                                                        <div style="clear:both;"></div>
                                                                        <button class="btn btn-small " id="save_remark"
                                                                            type="button"
                                                                            style="margin-top:0px;">บันทึก</button>

                                                                        <?php
                                                                        if (trim($row['remark']) != '' && trim($row['remark']) != '-') {
                                                                            $arrRem = explode('|', $row['remark']);
                                                                            $nremark = count($arrRem);
                                                                        ?>
                                                                        <span class="cs_title btn btn-danger"
                                                                            id="viewRemark">ดูรายละเอียดพิเศษ :
                                                                            จำนวน
                                                                            <?php echo $nremark; ?> รายการ</span>
                                                                        <div id="showRemark"
                                                                            style="display:none;width:80%;">
                                                                            <?php for ($nr = 0; $nr < $nremark; $nr++) { ?>
                                                                            <strong>
                                                                                <font color="RED">
                                                                                    <?php echo $arrRem[$nr]; ?>
                                                                                </font>
                                                                            </strong><br>
                                                                            <?php } ?>
                                                                        </div>
                                                                        <?php } ?>
                                                                    </div>
                                                                </span>
                                                            </div>
                                                            <div class="span7 mrpd10"><label class="hdtext">กลุ่ม
                                                                    Fleed
                                                                    :</label><span class="dttext">
                                                                    <?php

                                                                    $group1_sql = "SELECT id_group FROM group_fleed WHERE id_data = '$_GET[id]'";
                                                                    $group1_query = PDO_CONNECTION::fourinsure_insured()->query($group1_sql);
                                                                    $group1_array = $group1_query->fetch();
                                                                    ?>
                                                                    <input type="radio" name="check_fleed"
                                                                        id="check_fleed" value="1"
                                                                        onchange="group_fleed()">&nbsp;ดูกลุ่ม
                                                                    Fleed&nbsp;&nbsp;&nbsp;
                                                                    <input type="radio" name="check_fleed"
                                                                        id="check_fleed" value="2"
                                                                        onchange="group_fleed()">&nbsp;เพิ่มกลุ่ม
                                                                    Fleed&nbsp;&nbsp;&nbsp;</label>
                                                                    <label id="show_fleed">
                                                                        <?php
                                                                        if ($group1_array != null) {
                                                                            $fleed_sql = "SELECT id_group FROM group_fleed WHERE id_data = '$_GET[id]' GROUP BY id_group";
                                                                            $fleed_query = PDO_CONNECTION::fourinsure_insured()->query($fleed_sql);
                                                                            $text_numfleed = '';

                                                                            foreach ($fleed_query->fetchAll() as $fleed_array) {
                                                                                $text_numfleed .= $text_numfleed == '' ? $fleed_array['id_group'] : "," . $fleed_array['id_group'];
                                                                            }
                                                                        ?>
                                                                        <font color="GREEN" size='4'><b>อยู่ในกลุ่ม
                                                                                Fleed <?php echo $text_numfleed; ?></b>
                                                                        </font>
                                                                        <?php } else { ?>
                                                                        <font color="RED" size='4'><b>ไม่อยู่ในกลุ่ม
                                                                                Fleed</b></font>
                                                                        <?php } ?></span>
                                                            </div>
                                                        </div>

                                                        <!-- TAPOS -->
                                                        <div style="clear:both;"></div>

                                                        <div style="clear:both;"></div>
                                                        <div id="dataH">
                                                            <div class="span6 mrpd10">
                                                                <label class="hdtext">ID line :</label><span
                                                                    class="dttext"><input class="span12" id="idline"
                                                                        type="text" name="idline"
                                                                        value="<?php echo $row['id_line']; ?>">
                                                                </span>
                                                            </div>
                                                            <div class="span6 mrpd10">
                                                                <label class="hdtext">Email :</label><span
                                                                    class="dttext"> <input class="span12" id="email"
                                                                        type="text" name="email"
                                                                        value="<?php echo $row['email']; ?>">
                                                                    <?php
                                                                    if (!empty($blemail)) {
                                                                        echo $blemail;
                                                                    } else {
                                                                        echo "<input type='checkbox' name='blist2' id='blist2'  style='width:16px;height:16px;' onclick='chkDis(2)' value='" . $row['email'] . "'> แจ้ง Blacklist";
                                                                        echo "<input type='text' style='display:none;' placeholder= 'เหตุผล' name='blist_remark2' id='blist_remark2' value=''>";
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </div>
                                                            <div class="span6 mrpd10"><label class="hdtext">ทะเบียน
                                                                    :</label><span class="dttext"> <input class="span12"
                                                                        id="car_regis" type="text" name="car_regis"
                                                                        value="<?php echo $row['car_regis']; ?>"></span>
                                                            </div>
                                                            <div class="span6 mrpd10"> <label
                                                                    class="hdtextL">จังหวัดทะเบียน :</label><span
                                                                    class="dttext">
                                                                    <select class="span12" name="car_regis_pro"
                                                                        id="car_regis_pro">
                                                                        <?php
                                                                        foreach ($_SESSION["Pro"] as $key => $value) {
                                                                            echo "<option value='$key'";
                                                                            if ($key == $row['car_regis_pro']) {
                                                                                echo "selected";
                                                                            }
                                                                            echo ">$value</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </span>
                                                            </div>
                                                            <div class="span6 mrpd10">
                                                                <label class="hdtext">ในนาม :</label><span
                                                                    class="dttext">
                                                                    <select name="person" id="person" class="span12">
                                                                        <option value="1" <? if ($row['person']==1) {
                                                                            echo "selected" ; } ?>>บุคคล</option>
                                                                        <option value="2" <? if ($row['person']==2) {
                                                                            echo "selected" ; } ?>>นิติบุคคล</option>
                                                                    </select>
                                                                </span>
                                                            </div>
                                                            <div class="span6 mrpd10">
                                                                <label class="hdtextL"> เลขประชาชน/นิติบุคคล
                                                                    :</label><span class="dttext span8">
                                                                    <input class="span5" id="icard" type="text"
                                                                        name="icard"
                                                                        value="<?php echo $row['icard']; ?>">
                                                                    <input class="span5" id="icard_niti" type="text"
                                                                        name="icard_niti"
                                                                        value="<?php echo $row['icard_niti']; ?>">
                                                                </span>
                                                            </div>
                                                            <div class="span6 mrpd10">
                                                                <label class="hdtext"> เลขที่ :</label><span
                                                                    class="dttext">
                                                                    <input class="span12" id="add" type="text"
                                                                        name="add" value="<?php echo $row['add']; ?>">

                                                                </span>
                                                            </div>
                                                            <div class="span6 mrpd10">
                                                                <label class="hdtext">หมู่ : </label><span
                                                                    class="dttext"><input class="span12" id="group"
                                                                        type="text" name="group"
                                                                        value="<?php echo $row['group']; ?>"></span>
                                                            </div>
                                                            <div class="span6 mrpd10">
                                                                <label class="hdtext"> หมู่บ้าน/อาคาร :</label><span
                                                                    class="dttext"> <input class="span12" id="town"
                                                                        type="text" name="town"
                                                                        value="<?php echo $row['town']; ?>">
                                                                </span>
                                                            </div>
                                                            <div class="span6 mrpd10">
                                                                <label class="hdtext"> ซอย :</label><span
                                                                    class="dttext"> <input class="span12" id="tel"
                                                                        type="text" name="lane"
                                                                        value="<?php echo $row['lane']; ?>">
                                                                </span>
                                                            </div>
                                                            <div class="span6 mrpd10"><label class="hdtext"> ถนน
                                                                    :</label><span class="dttext"><input class="span12"
                                                                        id="road" type="text" name="road"
                                                                        value="<?php echo $row['road']; ?>"></span>
                                                            </div>
                                                            <div class="span6 mrpd10"><label class="hdtext"> จังหวัด
                                                                    :</label><span class="dttext"><select
                                                                        name="province" id="province" class="span12">
                                                                        <?php
                                                                        foreach ($_SESSION["Pro"] as $key => $value) {
                                                                            echo "<option value='$key'";
                                                                            if ($key == $row['province']) {
                                                                                echo "selected";
                                                                            }
                                                                            echo ">$value</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </span></div>
                                                            <div class="span6 mrpd10">
                                                                <label class="hdtext"> อำเภอ/เขต :</label><span
                                                                    class="dttext"><select name="amphur" id="amphur"
                                                                        class="span12">
                                                                        <?
                                                                        echo "<option value='" . $row['amphur'] . "'>" . $_SESSION["Amp"][$row['amphur']] . "</option>";
                                                                        ?>
                                                                    </select>
                                                                </span>
                                                            </div>
                                                            <div class="span6 mrpd10">
                                                                <label class="hdtext"> ตำบล/แขวง :</label><span
                                                                    class="dttext"><select name="tumbon" id="tumbon"
                                                                        class="span12">
                                                                        <?
                                                                        echo "<option value='" . $row['tumbon'] . "'>" . $_SESSION["Tum"][$row['tumbon']] . "</option>";
                                                                        ?>
                                                                    </select>
                                                                </span>
                                                            </div>
                                                            <div class="span6 mrpd10">
                                                                <label class="hdtext"> รหัสไปรษณีย์ :</label>
                                                                <div class="dttext"><input class="span12" id="postal"
                                                                        type="text" name="postal"
                                                                        value="<?php echo $row['postal']; ?>">
                                                                </div>
                                                            </div>
                                                            <span><button class="btn btn-success" style="float:right;"
                                                                    id="saveadd" type="button"><i
                                                                        class="icon-share icon-white"></i><strong>
                                                                        บันทึกข้อมูล</strong></button></span>
                                                        </div> <!-- end dataH -->
                                                        <div style="clear:both;"></div>
                                                    </li>
                                                </ul>
                                                <!-- end tap none hidden -->
                                            </li>
                                        </ul>
                                        <div style="display:none;" class="span12 mrpd10 boxEdit">
                                        </div> <!-- END boxshow-->

                                        <!--สวนประวัติเคลม-->
                                        <div style="clear:both;"></div>
                                        <div class="box" id='show_box' style='display:none;'>

                                            <!-- get api html load claim story -->
                                            <div id="story_claim" class="body">
                                            </div>

                                            <input type="hidden" name="countlistclaim" id="countlistclaim" value="0" />
                                            <input type="hidden" name="claimall" id="claimall"
                                                value="<?php echo $claimall; ?>" />
                                            <input type="hidden" name="costdataOld" id="costdataOld"
                                                value="<?php echo $costdataOld; ?>" />
                                            <div class="boxframe">
                                                วิริยะประกันภัย : จำนวนผิด : <input name="txt_policy" type="text"
                                                    id="txt_policy" class="txt-only"
                                                    style="background: #fff !important;width:30px; margin-bottom: 0px;"
                                                    value="<?php echo $claim_po; ?>" readonly> ครั้ง
                                                ยอดเงินการเคลม : <input name="txt_claim" type="text" class="txt-only"
                                                    onkeyup="fncClaim();" id="txt_claim"
                                                    style="background: #fff !important;width: 80px; margin-bottom: 0px; text-align: right;"
                                                    value="<?php echo number_format($claim_amount, 2); ?>" readonly>
                                                เบี้ยสุทธิ : <input type="text" name="txt_claimpre" class="txt-only"
                                                    onkeyup="fncClaim();" id="txt_claimpre"
                                                    style="background: #fff !important;width: 80px; margin-bottom: 0px; text-align: right;"
                                                    value="<?php echo $prechk_loss; ?>" readonly>
                                                <?php if ($row['CostProduct'] != 0 && $row['CostProduct'] != '') {
                                                    $add_price = $row['CostProduct'];
                                                } else {
                                                    $add_price = $row['add_price'];
                                                } ?>
                                                <div style='display:inline-block;'>เบี้ยเพิ่ม : <input type="text"
                                                        name="add_price" id="add_price"
                                                        style="width: 80px; margin-bottom: 0px; text-align: right;"
                                                        value="<?php echo $add_price; ?>" readonly></div>
                                                <div style='display:inline-block;'>LOSS : <input name="txt_loss"
                                                        type="text" id="txt_loss"
                                                        style="width:80px; margin-bottom: 0px;"
                                                        value="<?php echo number_format($useLoss, 2); ?>" readonly> %
                                                </div>
                                            </div>
                                        </div>
                                        <!-- -->
                                        <div style="clear:both;"></div>
                                        <div class="box">
                                            <header>
                                                <span class="left-header">
                                                    <i class="icon-list"></i> <b>เบี้ยประกันภัย
                                                        [คลิกเพื่อทำใบเสนอราคา]</b>
                                                </span>
                                                <span class="right-header">
                                                    <p class="btn-tun div-tunpe"
                                                        style="float:none; margin: 0; padding: 2px;">
                                                        ทุนปีที่แล้ว + เพิ่มทุน
                                                        <b class="text-red-500"><?php echo $row['cost'] . ' + ' . number_format($add_price_old, 0); ?><b>
                                                    </p>
                                                </span>
                                            </header>

                                            <div id="collapse4">
                                                <div class="boxshow">
                                                    <input type="hidden" name="end_date" id="end_date"
                                                        value="<?php echo $row['end_date']; ?>">
                                                    <input type="hidden" name="regis_date" id="regis_date"
                                                        value="<?php echo $regis_date; ?>">
                                                    <input type="hidden" name="cost_new" id="cost_new"
                                                        value="<?php echo $Cost_NEW; ?>">
                                                    <ul class="nav nav-tabs" id="myTab">
                                                        <li class="active"><a data-toggle="tab"
                                                                onclick="viewCostSet('1');" href="#P1">ประเภท 1</a>
                                                        </li>
                                                        <li><a data-toggle="tab" onclick="viewCostSet('2');"
                                                                href="#P2">ประเภท 2</a></li>
                                                        <li><a data-toggle="tab" onclick="viewCostSet('3');"
                                                                href="#P3">ประเภท 3</a></li>
                                                        <li><a data-toggle="tab" onclick="viewCostSet('2+');"
                                                                href="#P2+">ประเภท 2+</a></li>
                                                        <li><a data-toggle="tab" onclick="viewCostSet('3+');"
                                                                href="#P3+">ประเภท 3+</a></li>
                                                    </ul>
                                                    <div class="tab-content" id="myTabContent">
                                                        <div id="P1" class="tab-pane fade active in">


                                                        </div> <!-- END P1 -->

                                                        <div id="P2" class="tab-pane fade">

                                                        </div><!-- END P2-->
                                                        <div id="P3" class="tab-pane fade">

                                                        </div><!-- END P3-->
                                                        <div id="P2+" class="tab-pane fade">

                                                        </div><!-- END P2+-->
                                                        <div id="P3+" class="tab-pane fade">

                                                        </div><!-- END P3+-->

                                                    </div>
                                                </div>


                                                <div style="clear:both;"></div>
                                            </div>

                                        </div>
                                        <div style="clear:both;"></div>
                                    </div>

                                    <div id="editData" class="tab-pane fade" style="display: none;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                            class="table table-striped table-bordered" style="margin-left:1px;">
                                            <tr class="info">
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center"></td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">
                                                </td>
                                            </tr>
                                            <tr class="info">
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">
                                                </td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center"></td>
                                            </tr>
                                            <tr class="info">
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">


                                                </td>
                                            </tr>
                                            <tr class="info">
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center"></td>
                                            </tr>
                                            <tr class="info">
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong>
                                                            <!-- / ทุนที่ใช้--> :
                                                        </strong></div>
                                                </td>
                                                <td class="span4" align="center">


                                                </td>
                                            </tr>
                                            <tr class="info">
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                            </tr>
                                            <tr class="info">
                                                <td class="span2" align="right">
                                                    <div align="right"><strong>รายละเอียดพิเศษ :</strong></div>
                                                </td>
                                                <td class="span4" align="center">


                                                </td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong>กลุ่มFleet :</strong>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                            </tr>
                                            <tr class="info">
                                                <td class="span2" align="right">
                                                    <div align="right"><strong>เบอร์โทร :</strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                                <td class="span2" align="right">

                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                            </tr>
                                            <tr class="info">
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center"></td>
                                                <td class="span2" align="center">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong>ทะเบียน :</strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong>จังหวัดทะเบียน :</strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                    <!-- <button class="btn btn-info span5" style="float:right;" id="saveregis"  type="button"><i class="icon-share icon-white" ></i><strong> บันทึกทะเบียน</strong></button> -->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong>ในนาม :</strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong>เลขประชาชน/นิติบุคคล :</strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong>เลขที่ :</strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong>หมู่บ้าน/อาคาร :</strong></div>
                                                </td>
                                                <td class="span4" align="center">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong>ซอย :</strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong>จังหวัด :</strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                                <td class="span2" align="right">
                                                    <div align="right"><strong></strong></div>
                                                </td>
                                                <td class="span4" align="center">

                                                </td>
                                            </tr>
                                        </table>
                                    </div><!-- END editData-->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- show div ติดตามงาน -->
                <div class="span4 anime" id='show_pad'
                    style='display:none; margin-top: 30px; background-color: #d8d8d8;'>
                    <header style="padding: 10px 0px; background-color: #fff; border-bottom: 2px solid #a5a5a5;">
                        <div style="display: flex;">
                            <div style="width: 50%; display: flex; align-items: center;">
                                <i class='icon-list' style="text-indent:5px;"></i> บันทึก [ <font color="#FF6600"><b>
                                        การติดตาม </b></font> ]
                            </div>
                            <div style="width: 50%; justify-content: flex-end; display: flex;">
                                <button class='btn btn-close' onclick='cross_sdl();'
                                    style="background-color: #000 !important;">ปิด</button>
                            </div>
                        </div>
                    </header>
                </div>

                <!-- show div ติดตามงาน -->

                <div id='show_follow' style='display:none;'>
                    <div class="box">
                        <header>
                            <span class="left-header">
                                <i class="icon-list"></i> <b id="txt-title-ch">บันทึก [การติดตาม]</b>
                            </span>
                            <span class="right-header">
                                <button class='btn btn-close' onclick='cross_follow();'
                                    style="background-color: #000 !important;">X</button>
                            </span>
                        </header>
                        <div id="collapse4" class="boxshow">
                            <div id="content_wait" class="container">
                                <form id="savefol">
                                    <input id="4_login" type="hidden" value="<?php echo $_SESSION["4User"]; ?>"
                                        name="4_login" readonly="">
                                    <input id="iddata" type="hidden" value="<?php echo $row['idselect']; ?>"
                                        name="iddata" readonly="">
                                    <input id="opentime" type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>"
                                        name="opentime" readonly="">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" id='quo_table'>
                                        <thead>
                                            <tr class="body row1">
                                                <th colspan="11" align="left">
                                                    <div style="height: 10px; clear: both;"></div>
                                                </th>
                                            </tr>
                                            <tr class="body row1">
                                                <th colspan="11" align="left">
                                                    <div style="display: flex;">
                                                        <div id="imgcomp"></div>
                                                        <div id="namecomp"></div>
                                                    </div>
                                                </th>
                                            </tr>
                                            <tr class="body row1">
                                                <th colspan="11" align="left">
                                                    <div style="height:10px; clear: both;"></div>
                                                    <div id="pussy" style="width: 100%; display: flex;">
                                                        <div class="card-warning">
                                                            <span style="font-weight: bold;">ประเภทประกันภัย :
                                                            </span>&nbsp;&nbsp;
                                                            <span id="ptype"></span>
                                                        </div>
                                                        <div class="card-warning">
                                                            <span style="font-weight: bold;">ประเภทซ่อม :
                                                            </span>&nbsp;&nbsp;
                                                            <span id="psom"></span>
                                                        </div>
                                                        <div class="card-warning">
                                                            <span
                                                                style="font-weight: bold;">เบี้ยสุทธิ</span>&nbsp;&nbsp;
                                                            <span id="bsuti"></span>
                                                        </div>
                                                        <div class="card-warning">
                                                            <span style="font-weight: bold;">เบี้ยรวม</span>&nbsp;&nbsp;
                                                            <span id="bsum"></span>
                                                        </div>
                                                    </div>
                                                </th>
                                            </tr>

                                            <tr class="body">
                                                <td colspan="11">
                                                    <!--START  รายการติดตาม -->
                                                    <table width="100%" id="fuckYou">

                                                        <tr class="success row1">
                                                            <td class="span12" colspan="2">
                                                                <div id="testdiv"></div>
                                                            </td>
                                                        </tr>

                                                        <tr id="datefolf">
                                                            <td class="span3"></td>
                                                            <td class="span9"></td>
                                                        </tr>
                                                    </table>
                                                    <div class="quotation">
                                                        <div>
                                                            <div class="body">
                                                                <div class="d-flex align-items-center">
                                                                    <label class="w-180" for="main">เสนอราคา</label>
                                                                    <select name="main" id="main">
                                                                        <option value="">กรุณาเลือก</option>
                                                                        <option value="R" style="color:#ff6600;">ติดตาม
                                                                        </option>
                                                                        <option value="S" style="color:#ff6600;">
                                                                            เสนอราคา
                                                                        </option>
                                                                        <option value="N">ไม่สนใจ</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div id='de_follow'>
                                                                <div class="d-flex align-items-center">
                                                                    <label class="w-180"
                                                                        for="detail_follow" id="list-follow"> </label>
                                                                    <select id='detail_follow' name='detail_follow'
                                                                    style="width: 221px;" class="txt"
                                                                        onchange='open_detail_follow();'>
                                                                        <option value=''>--กรุณาเลือก--</option>
                                                                    </select>

                                                                    <div style='display:none;' id='show_detail_follow'>
                                                                        <textarea id='other_detail_follow'
                                                                        style="width: 221px"
                                                                            name='other_detail_follow' rows='3'>
                                                                    </textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div id="datefolf">
                                                                <div class="d-flex align-items-center">
                                                                    <label class="w-180"
                                                                        for="datefol">นัดครั้งถัดไป</label>
                                                                    <input type="text"
                                                                        value="<?php echo date('d/m/Y', strtotime("+1 day", strtotime(date('Y-m-d')))); ?>"
                                                                        name="datefol" id="datefol" readonly />
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <div class="d-flex align-items-center">
                                                                    <label class="w-180"
                                                                        for="textdetail">รายละเอียด</label>
                                                                    <textarea id="textdetail" name="textdetail" rows="3"
                                                                        cols="5"></textarea>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <div id="costFixd" name="costFixd" style = "display:none;">
                                                                <div class="d-flex align-items-center">
                                                                        <label class="w-180">ประเภทประกัน</label>
                                                                        <select class="TotalPrice" name="typeInsure" id="typeInsure">
                                                                            <option value="1" selected>1</option>
                                                                            <!-- <option value="2">2</option>
                                                                            <option value="2+">2+</option>
                                                                            <option value="3">3</option>
                                                                            <option value="3+">3+</option> -->
                                                                        </select>
                                                                </div>

                                                                <div class="d-flex align-items-center">
                                                                        <label class="w-180">การซ่อม</label>
                                                                        <select class="TotalPrice" name="typeDocs" id="typeDocs">
                                                                            <option value="1"selected>ห้าง</option>
                                                                            <!-- <option value="2">อู่</option> -->
                                                                        </select>
                                                                </div>

                                                                <div class="d-flex align-items-center">
                                                                        <label class="w-180">รหัสรถ</label>
                                                                <select class="TotalPrice" name="carID" id="carID" onchange="changeCarModelID(`<?php echo $_resultDatas->mocarID;?>`,this)">
                                                                <?php if($row['car_id']=='110')
                                                                {
                                                                    echo "<option value='110' selected>110</option>";
                                                                }
                                                                else if($row['car_id']=='210')
                                                                {
                                                                    echo "<option value='210' selected>210</option>";
                                                                    echo "<option value='320'>320</option>";
                                                                }
                                                                else
                                                                {
                                                                    echo "<option value='210'>210</option>";
                                                                    echo "<option value='320' selected>320</option>";
                                                                }
                                                                ?>
                                                                        </select>
                                                                </div>

                                                                <!-- <div class="d-flex align-items-center">
                                                                    <label class="w-180" style='color:red'>ช่วงทุน</label>
                                                                    <select class="TotalPrice" name="costFix" id="costFix" onchange="handlefixcost()"></select>
                                                                </div> -->
                                                            </div>

                                                            <div class="row1">
                                                                <div class="d-flex align-items-center">
                                                                <label class="w-180" for="tun" style='color:red'>ทุนประกัน</label>
                                                                    <input type="text" size='4' class=" txt"
                                                                        value="<?php echo $_SESSION["MoC"]['name'][$row['mo_car']]; ?>"
                                                                        name="mo_car_re" id="mo_car_re" readonly
                                                                        style="display: none;" />

                                                                    <? if ($_SESSION["MoC"]['name'][$row['mo_car']] == 'CARRY') { ?>
                                                                    <input type="hidden" size='4' value="AS2"
                                                                        name="type_pro" id="type_pro" readonly />
                                                                    <? } else { ?>
                                                                    <input type="hidden" size='4' value="S30"
                                                                        name="type_pro" id="type_pro" readonly />
                                                                    <? } ?>

                                                                    <select class="TotalPrice" name="tun" id="tun" onchange="handlereneweiei()"></select>
                                                                </div>
                                                            </div>

                                                            <div class="row1">
                                                                <div class="d-flex align-items-center">
                                                                    <label class="w-180" for="act">พ.ร.บ.</label>
                                                                    <select class="TotalPrice " name="act" id="act"
                                                                        onchange="calcfunc();onePercentChange();">
                                                                        <option value="N">ไม่เอา</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div style='display:none;'>
                                                                <div>
                                                                    <label for="driver">ส่วนลดผู้ขับขี่</label>
                                                                    <select class="txt" name="driver" id="driver">
                                                                        <option value="ไม่ระบุผู้ขับขี่">
                                                                            ไม่ระบุผู้ขับขี่</option>
                                                                        <option
                                                                            value="ผู้ขับขี่ 2 คน อายุ 18 ถึง 24 ปี">
                                                                            ผู้ขับขี่ 2 คน อายุ 18 ถึง 24 ปี</option>
                                                                        <option
                                                                            value="ผู้ขับขี่ 1 คน อายุ 18 ถึง 24 ปี">
                                                                            ผู้ขับขี่ 1 คน อายุ 18 ถึง 24 ปี</option>
                                                                        <option
                                                                            value="ผู้ขับขี่ 2 คน อายุ 25 ถึง 35 ปีี">
                                                                            ผู้ขับขี่ 2 คน อายุ 25 ถึง 35 ปี</option>
                                                                        <option
                                                                            value="ผู้ขับขี่ 1 คน อายุ 25 ถึง 35 ปีี">
                                                                            ผู้ขับขี่ 1 คน อายุ 25 ถึง 35 ปี</option>
                                                                        <option
                                                                            value="ผู้ขับขี่ 2 คน อายุ 36 ถึง 50 ปีีี">
                                                                            ผู้ขับขี่ 2 คน อายุ 36 ถึง 50 ปี</option>
                                                                        <option
                                                                            value="ผู้ขับขี่ 1 คน อายุ 36 ถึง 50 ปีีี">
                                                                            ผู้ขับขี่ 1 คน อายุ 36 ถึง 50 ปี</option>
                                                                        <option value="ผู้ขับขี่ 2 คน อายุเกิน 50 ปี">
                                                                            ผู้ขับขี่ 2 คน อายุเกิน 50 ปี</option>
                                                                        <option value="ผู้ขับขี่ 1 คน อายุเกิน 50 ปีีี">
                                                                            ผู้ขับขี่ 1 คน อายุเกิน 50 ปี</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="" style='display:none;'>
                                                                <div>
                                                                    <label for="disdriver">จำนวนคน</label>
                                                                    <input id="disdriver" class="TotalPrice" type="text"
                                                                        onkeyup="javascript:calcfunc();" value="0.00"
                                                                        name="disdriver" size="15">
                                                                </div>
                                                            </div>

                                                            <div class="" style='display:none;'>
                                                                <div>
                                                                    <label for="">ส่วนลดกลุ่ม</label>
                                                                    <div style="display: flex;">
                                                                        <select class="TotalPrice" name="dgroup"
                                                                            id="dgroup" onchange="calcfunc();">
                                                                            <option value='0'>0%</option>
                                                                            <option value='5'>5%</option>
                                                                            <option value='10' selected>10%</option>
                                                                        </select>
                                                                        <input type="text" class="TotalPrice" size="15"
                                                                            value="" name="showgroup" id="showgroup"
                                                                            readonly />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="" style='display:none;'>
                                                                <div>
                                                                    <div style="text-indent: 10px;"><strong>
                                                                            : </strong></div>
                                                                </div>
                                                                <div>
                                                                    <label for="">ส่วนลดประวัติดี
                                                                        <font color="#FF0000">
                                                                            <strong>*อู่=20% / ห้าง=25%</strong>
                                                                        </font>
                                                                    </label>
                                                                    <div style="display: flex;">
                                                                        <select class="TotalPrice span3 txt"
                                                                            name="dgood" id="dgood"
                                                                            onchange="calcfunc();">
                                                                            <option value='0'>0%</option>
                                                                            <option value='20' selected>20%</option>
                                                                            <option value='25'>25%</option>
                                                                        </select>
                                                                        <input size="15" class="TotalPrice span4 txt"
                                                                            type="text" value="" name="showgood"
                                                                            id="showgood" readonly />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php //TODO ส่วนลด
                                                            ?>
                                                            <div class="row1">
                                                                <div class="d-flex align-items-center">
                                                                    <label class="w-180" for="extra">ส่วนลดพิเศษ</label>
                                                                    <select class="TotalPrice" onchange="extraChange();"
                                                                        name="extra-per" id="extra-per"
                                                                        style="width: 20%;height: 30px;">
                                                                    </select>
                                                                    <input class="TotalPrice" onkeyup="extrainput();"
                                                                        size="15" type="text" value="0.00" name="extra"
                                                                        id="extra" style="width: 26% !important"/>
                                                                </div>
                                                            </div>
                                                            <div class="row1">
                                                                <div class="d-flex align-items-center">
                                                                    <label class="w-180"
                                                                        for="totaldis">รวมส่วนลด</label>
                                                                    <input size="15" type="text" value="0.00"
                                                                        name="totaldis" id="totaldis" readonly />
                                                                </div>
                                                            </div>
                                                            <div class="row1">
                                                                <div class="d-flex align-items-center">
                                                                    <label class="w-180" for="onepercent">หัก 1%</label>
                                                                    <select class="TotalPrice" name="onepercent" id="onepercent"
                                                                        style="width: 20%;height: 30px;" onchange="onePercentChange()">
                                                                        <option value='0'>ไม่หัก</option>
                                                                        <option value='1'>หัก 1%</option>
                                                                    </select>
                                                                    <input class="TotalPrice" size="15" type="text" value="0.00" name="showOnepercent"
                                                                        id="showOnepercent" style="width: 26% !important"/>
                                                                </div>
                                                            </div>
                                                            <div class="" style="display: none !important;">
                                                                <div class="d-flex align-items-center">
                                                                    <label class="w-180" for="stype">ผ่อนชำระ <br>
                                                                        <font color="#FF0000">
                                                                            <strong>เลือกประเภทการชำระเงิน</strong>
                                                                        </font>
                                                                    </label>
                                                                    <select name="stype" onchange="stype_change()">
                                                                        <option value="1">แบ่งชำระ 1 งวด</option>
                                                                        <option value="2">แบ่งชำระ 2 งวด</option>
                                                                        <option value="3">แบ่งชำระ 3 งวด</option>
                                                                        <option value="4">แบ่งชำระ 4 งวด</option>
                                                                    </select>
                                                                    <input type="hidden" id="temp_snet"
                                                                        name="temp_snet">
                                                                    <br>
                                                                    <input type="checkbox" class="txt" id="chkcall"
                                                                        name="chkcall" value="1"
                                                                        onchange="stype_change()">
                                                                    <span>
                                                                        ชำระงวดแรก 3,000 บาท<br>
                                                                        <font color="#FF0000">(ใช้ได้ในกรณีผ่อนชำระ)
                                                                        </font>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="snet1 row1">

                                                                <div class="d-flex align-items-center" >
                                                                    <label class="w-180" for="snet">เบี้ยชำระ</label>
                                                                    <input size="15" type="text" value="" name="snet"
                                                                    id="snet" readonly/>
                                                                </div>
                                                            </div>

                                                            <div class="row4" id="datefolf2">
                                                                <div class="row4 d-flex align-items-center">
                                                                    <label class="w-180"
                                                                        for="datefol">วันที่ปิดงาน</label>
                                                                    <input type="text" class=" txt" size='20'
                                                                        value="<?php echo date('d/m/Y'); ?>"
                                                                        name="datefol2" id="datefol" readonly />
                                                                </div>
                                                            </div>
                                                            <!-- begin sing -->
                                                            <div id="show-data-pay"></div>
                                                            <!-- end sing -->
                                                            <div style="display:none;" id="send_quotation" width="100%"
                                                                class="detail_renew">

                                                                <div style="display: none;">
                                                                    <div>
                                                                        <label for="compid">บริษัท</label>
                                                                        <select name="compid" id="compid"
                                                                            onchange="Stun();">
                                                                            <?php echo '<option value="VIB_S">วิริยะประกันภัย</option>'; ?>
                                                                        </select>
                                                                        <input type="hidden" name="protect_type"
                                                                            id="protect_type" value="">
                                                                    </div>
                                                                </div>
                                                                <div style="display:none;">
                                                                    <div>
                                                                        <label for="doctype">ประเภท</label>
                                                                        <select name="doctype" id="doctype">
                                                                            <option value="1">ป1</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div style="display:none;">
                                                                    <div>
                                                                        <label for="sprodgroup">ชนิด</label>
                                                                        <input type="hidden" id="qidcost" name="qidcost"
                                                                            value="">
                                                                        <select name="sprodgroup" id="sprodgroup">
                                                                            <option value="SP">เบี้ยประวัติ</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div style="display:none;">
                                                                    <div>
                                                                        <label for="service">ซ่อม</label>
                                                                        <?php if ($_SESSION["MoC"]['name'][$row['mo_car']] == 'CARRY') { ?>
                                                                        <selectclass="TotalPrice" name="service"
                                                                            id="service" onchange="Stun();">
                                                                            <option value='2' selected>ซ่อมอู่</option>
                                                                            </selectclass=>
                                                                            <?php } else { ?>
                                                                            <select class="TotalPrice" name="service"
                                                                                id="service" onchange="Stun();">
                                                                                <option value='1'>ซ่อมห้าง</option>
                                                                                <option value='2' selected>ซ่อมอู่
                                                                                </option>
                                                                            </select>
                                                                            <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div style="display:none;">
                                                                    <div>
                                                                        <label for="TotalPrice">เบี้ยสุทธิ</label>
                                                                        <div
                                                                            style="display: grid;margin-bottom: 0.7rem;">
                                                                            <input type="text" class="TotalPrice"
                                                                                size="15" value="" name="pre-set"
                                                                                id="pre-set" readonly />
                                                                            <input type="text" class="TotalPrice"
                                                                                size="15" value="" name="pre-set2"
                                                                                id="pre-set2" readonly />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row4" style="display:none;">
                                                                    <div class="row4">
                                                                        <label for="pre-all">เบี้ยรวม</label>
                                                                        <input type="text" class="TotalPrice" size="15"
                                                                            value="" name="pre-all" id="pre-all"
                                                                            readonly />
                                                                    </div>
                                                                </div>
                                                                <div class="snet2">
                                                                    <div>เบี้ยชำระ</div>
                                                                </div>
                                                                <div class="snet2">
                                                                    <div class="d-flex align-items-center">
                                                                        <label class="w-180"
                                                                            for="snet21">งวดที่1</label>
                                                                        <input size="15" style="color:red;" type="text"
                                                                            value="" name="snet2[]" id="snet21"
                                                                            readonly />
                                                                    </div>
                                                                </div>
                                                                <div class="snet2">
                                                                    <div class="d-flex align-items-center">
                                                                        <label class="w-180"
                                                                            for="snet22">งวดที่2</label>
                                                                        <input size="15" style="color:red;" type="text"
                                                                            value="" name="snet2[]" id="snet22"
                                                                            readonly />
                                                                    </div>
                                                                </div>
                                                                <div class="snet3">
                                                                    <div>เบี้ยชำระ</div>
                                                                    <div></div>
                                                                </div>
                                                                <div class="snet3">
                                                                    <div class="d-flex align-items-center">
                                                                        <label class="w-180"
                                                                            for="snet31">งวดที่1</label>
                                                                        <input size="15" style="color:red;" type="text"
                                                                            value="" name="snet3[]" id="snet31"
                                                                            readonly />
                                                                    </div>
                                                                </div>
                                                                <div class="snet3">
                                                                    <div class="d-flex align-items-center">
                                                                        <label class="w-180"
                                                                            for="snet32">งวดที่2</label>
                                                                        <input size="15" style="color:red;" type="text"
                                                                            value="" name="snet3[]" id="snet32"
                                                                            readonly />
                                                                    </div>
                                                                </div>
                                                                <div class="snet3">
                                                                    <div class="d-flex align-items-center">
                                                                        <label class="w-180" for="span4">งวดที่3</label>
                                                                        <input size="15" style="color:red;" type="text"
                                                                            value="" name="snet3[]" id="snet33"
                                                                            readonly />
                                                                    </div>
                                                                </div>
                                                                <div class="snet4">
                                                                    <div>เบี้ยชำระ</div>
                                                                    <div></div>
                                                                </div>
                                                                <div class="snet4">
                                                                    <div class="d-flex align-items-center">
                                                                        <label class="w-180"
                                                                            for="snet41">งวดที่1</label>
                                                                        <input size="15" style="color:red;" type="text"
                                                                            value="" name="snet4[]" id="snet41"
                                                                            readonly />
                                                                    </div>
                                                                </div>
                                                                <div class="snet4">
                                                                    <div class="d-flex align-items-center">
                                                                        <label class="w-180"
                                                                            for="snet42">งวดที่2</label>
                                                                        <input size="15" style="color:red;" type="text"
                                                                            value="" name="snet4[]" id="snet42"
                                                                            readonly />
                                                                    </div>
                                                                </div>
                                                                <div class="snet4">
                                                                    <div class="d-flex align-items-center">
                                                                        <label class="w-180"
                                                                            for="snet43">งวดที่3</label>
                                                                        <input style="color:red;" type="text" value=""
                                                                            name="snet4[]" id="snet43" readonly />
                                                                    </div>
                                                                </div>
                                                                <div class="snet4">
                                                                    <div class="d-flex align-items-center">
                                                                        <label class="w-180"
                                                                            for="snet44">งวดที่4</label>
                                                                        <input size="15" style="color:red;" type="text"
                                                                            value="" name="snet4[]" id="snet44"
                                                                            readonly />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- รายการเสนอราคา -->

                                                    <div align="center" style="margin-top: 5px;">
                                                        <button class="" id="saveaction" type="button"
                                                            style="background: #000; border: none; padding: 5px 20px !important; border-radius: 5px; color: #fff;">
                                                            <i class="icon-ok-sign icon-white"></i>
                                                            บันทึก
                                                        </button>
                                                    </div>
                                                    <!--END  รายการติดตาม -->
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="span12 " style="margin-left: 0px;" id="iheretoo">
                <!-- <div class="span12 hiddenByMount" style="margin-left: 0px;" id="iheretoo"> -->

                    <div class="box">
                        <header>
                            <span class="left-header">
                                <i class="icon-list"></i> <b>ข้อมูลการติดตาม</b>
                            </span>
                            <span class="right-header">
                            </span>
                        </header>
                        <div class="boxshow">
                            <table id="TableViewLog" class="table-bordered table-striped" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width: 7%;">เวลาบันทึก</th>
                                        <th style="width: 6%;">บริษัท</th>
                                        <th style="width: 4%;">ประเภท</th>
                                        <th style="width: 7%;">เบี้ยรวม</th>
                                        <th style="width: 5%;">พรบ.</th>
                                        <th style="width: 7%;">ยอดชำระ</th>
                                        <th style="width: 5%;">สถานะ</th>
                                        <th style="width: 27%;">รายละเอียด</th>
                                        <th style="width: 6%;">วันที่นัด</th>
                                        <th style="width: 5%;">ผู้ติดตาม</th>
                                        <th style="width: 8%;">พิมพ์ใบเสนอราคา</th>
                                        <th style="width: 8%;">SMS เสนอราคา</th>
                                        <th style="width: 7%;">แจ้งงาน</th>
                                        <th style="display:none;">num</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myinform" class="quote modal fade " role="dialog">
    <div class="modal-dialog dialog_renew">

        <!-- Modal content-->
        <div class="modal-content content_renew">
            <div class="modal-header">
                <div style="float:right;" class="bg-close-renew" data-dismiss="modal">X</div>
                <!-- <a type="button" class="bg-close" data-dismiss="modal">&times;</a> -->
                <h4 class="modal-title" id='title_inform'></h4>
            </div>
            <div class="modal-body modal_body_renew" id='html_inform'>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-primary" onclick='inform_save();'>
                    <font color='#000000'>แจ้งงาน</font>
                </a>
                <a type="button" class="btn btn-default" data-dismiss="modal">
                    <font color='#000000'>Close</font>
                </a>
            </div>
        </div>
    </div>
</div>

<div id="myinformQuotation" class="quote modal fade " role="dialog">
    <div class="modal-dialog dialog_renew">
        <!-- Modal content-->
        <div class="modal-content content_renew">
            <div class="modal-header">
                <div style="float:right;" class="bg-close-renew" data-dismiss="modal">X</div>
                
                <h4 class="modal-title" id='title_inform'><font color='#000000'>เสนอราคา ตามค่าเสื่อมสภาพ</font></h4>
            </div>
            <div class="modal-body modal_body_renew" id='html_inform_quotation'>
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-primary" onclick='inform_save();'>
                    <font color='#000000'>เสนอราคา</font>
                </a>
                <a type="button" class="btn btn-default" data-dismiss="modal">
                    <font color='#000000'>ปิด</font>
                </a>
            </div>
        </div>
    </div>
</div>

<div id="sendSmsQuotation" class="modal fade" role="dialog">
    <div class="modal-dialog dialog_renew">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <a type="button" class="close" data-dismiss="modal">&times;</a>
                <h4 class="modal-title c-title-m-s">ส่ง SMS ใบเตือนต่ออายุ/เสนอราคาต่ออายุ/แจ้งเตือนมิจฉาชีพ</h4>
            </div>
            <div class="modal-body modal_body_renew" id='detail_HtmlInform'>
                <div class="modal-i-s" id="renew-d-i">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cloes-modal-sms" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<div id="addPhoneNumber" class="modal fade" role="dialog">
    <div class="modal-dialog dialog_renew">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <a type="button" class="close" data-dismiss="modal">&times;</a>
                <h4 class="modal-title c-title-m-s">เพิ่มเบอร์โทรศัพท์ลูกค้า</h4>
            </div>
            <div class="modal-body modal_body_renew" id='detail_addPhone'>
                <div class="modal-i-s" id="add-p-c">
                </div>
                <div class="modal-i-s" id="d-b-l">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-save-modal-sms" onclick="saveTelCus()">บันทึก</button>
                <button type="button" class="btn-cloes-modal-sms" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modal_PayOnline" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;</button>
                <h4 class="modal-title">แบบฟอร์มชำระเงิน Online</h4>
            </div>
            <div class="modal-body">

                Load Data...

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" id="btn-exit" data-dismiss="modal">Close</a>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- /.modal  ข้อมูลลูกค้า -->
<div class="search modal fade" id="modal_view_customer" tabindex="-1" role="dialog"
    aria-labelledby="modal_quote_fleet_nmblt_mblt_customer_label" aria-hidden="true" data-backdrop="static"
    data-keyboard="false" style="width: 850px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modal_content_view_customer">ข้อมูลลูกค้า</h4>
            </div>
            <div class="modal-body" style="overflow-y:scroll; max-height: 600px;">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"
                    id="close-search-customer">ปิด</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>

</script>
<?php include 'renew-suzuki-select-js.php'; ?>
<script>
function coppyBoard(val) {
    navigator.clipboard.writeText(val);
    alert("คัดลอกเรียบร้อย: " + val);
 }  
</script>