<?php
include "../inc/connectdbs.pdo.php";
include "check-ses.php";

$dbmy4ib_new = PDO_CONNECTION::fourinsure_mitsu();
$IDDATA = $_GET['IDDATA'];

$query = "SELECT *,
tb_mo_car.name AS mo_car_name,
tb_br_car.name AS car_brand,
tb_tumbon.name as tumbon_name,
tb_amphur.name as amphur_name,
tb_province.name as province_name,
insuree.name AS namecus,
detail.code_addon,
detail.code_addon_id,
req.Req_Status,
detail.mo_sub,
data.PactOnline,
data.Status_Email
";
$query.= " FROM data ";
$query.= "LEFT JOIN detail ON (data.id_data = detail.id_data) ";
$query.= "LEFT JOIN insuree ON (data.id_data = insuree.id_data) ";
$query.= "LEFT JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
$query.= "LEFT JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
$query.= "LEFT JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
$query.= "LEFT JOIN tb_cost ON (tb_cost.id = data.costCost) ";
$query.= "LEFT JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query.= "LEFT JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
$query.= "LEFT JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
$query.= "LEFT JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
$query.= "LEFT JOIN tb_province ON (tb_province.id = insuree.province) ";
$query.= "LEFT JOIN tb_customer ON (tb_customer.user = data.login) ";
$query.= "LEFT JOIN req ON (req.id_data = data.id_data) ";
$query.= "WHERE data.id_data='" . $_GET["IDDATA"] . "'";
// echo $query;
$objQuery = $dbmy4ib_new->query($query);
$row = $objQuery->fetch(2);
// exit;

if (!empty($row['car_cat_acc'])) {
    $carid_protect = $row['car_cat_acc'];
} else {
    $carid_protect = $row['car_id'];
}

$protect_sql = "SELECT * FROM protect_09712 WHERE car_id='" . $carid_protect . "' AND DATE(exp_date) >= '" . $row['start_date'] . "'";
$protect_query = $dbmy4ib_new->query($protect_sql);
$protect_array = $protect_query->fetch();
/***************************************************************************************************************************** */
if (!empty($row['code_addon'])) {
    $addonarray = explode(",", $row['code_addon']);
    for ($xx = 0;$xx < count($addonarray);$xx++) {
        if ($addonarray[$xx] == "ADDON_PV") {
            $sqladdon_sql = "select * from tb_addon where code_addon = '" . $addonarray[$xx] . "'";
            $sqladdon_query = $dbmy4ib_new->query($sqladdon_sql);
            $sqladdon_array = $sqladdon_query->fetch();
            $premium_name = $sqladdon_array['name_addon'];
        }
    }
}

$car_id = $row['car_id'];
$arr_car_id = str_split($car_id);
$id_data_rec = $row['id_data'];
$nameCar = $row['mo_car_name'];
if (!empty($row['mo_sub'])) {
    $sqlQueMS = "SELECT * FROM tb_mo_car_sub where id = '" . $row['mo_sub'] . "'";
    $resMS = $dbmy4ib_new->query($sqlQueMS);
    $rowMS = $resMS->fetch();
    $nameCar = $rowMS['name'];
    $scw = $rowMS['desc'];
}

$query1 = "SELECT ";
$query1.= "tb_tumbon.name as tumbon, ";
$query1.= "tb_amphur.name as amphur, ";
$query1.= "tb_province.name as province "; // จังหวัด
$query1.= "FROM req ";
$query1.= "LEFT JOIN tb_tumbon ON (tb_tumbon.id = req.Cus_tumbon) ";
$query1.= "LEFT JOIN tb_amphur ON (tb_amphur.id = req.Cus_amphur) ";
$query1.= "LEFT JOIN tb_province ON (tb_province.id = req.Cus_province) ";
$query1.= "WHERE req.id_data='" . $row['id_data'] . "'";
$objQuery1 = $dbmy4ib_new->query($query1);
$row1 = $objQuery1->fetch();

$sqlMORE = "SELECT * FROM tb_acc";
$objQueryMORE = $dbmy4ib_new->query($sqlMORE);
$costOb = array();
foreach ($objQueryMORE As $rowCost) {
    $costOb['name'][$rowCost['id']] = $rowCost['name'];
    $costOb['price'][$rowCost['id']] = $rowCost['price'];
    $costOb['price2'][$rowCost['id']] = $rowCost['price2'];
}

$sqlMOREname = "SELECT * FROM tb_acc_new";
$objQueryMOREname = $dbmy4ib_new->query($sqlMOREname);
$costObname = array();
foreach ($objQueryMOREname As $rowCostname) {
    $costObname['name']['0' . $rowCostname['idcar']][$rowCostname['id']] = $rowCostname['name'];
}


?>

<form method="POST" id="frm_send_mail" name="frm_send_mail">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1" class="">
        <tr>
            <td height="25" colspan="4"><span class="style47">
                    <font face="Tahoma"><strong>Form:</strong> admin@viriyah.net</font>
                </span></td>
        </tr>
        <tr>
            <td height="25" colspan="4">
                <span class="style47">
                    <font face="Tahoma"><strong>To:</strong></font>
                    <font face="Tahoma">
                        <?php if($row['Email']!=""){ echo $row['Email']; } ?>
                        <?php if($row['Email2']!=""){ echo " ,".$row['Email2']; } ?>
                        <?php if($row['Email3']!=""){ echo " ,".$row['Email3']; } ?>
                        <?php if($row['Email4']!=""){ echo " ,".$row['Email4']; } ?>
                        <?php if($row['Email4']!=""){ echo " ,".$row['Email5']; } ?>
                        <?php if($row['Email5']!=""){ echo " ,".$row['Email6']; } ?>
                    </font>
                </span>
            </td>
        </tr>
        <tr>
            <td height="25" colspan="4">
                <span class="style47">
                    <font face="Tahoma"><strong>cc:</strong></font>
                    <font face="Tahoma">
                        <input type="text" name="txtCC" id="txtCC" value="<?php echo $row['email'];?>" style="width:650px;" />
                    </font>
                </span>
            </td>
        </tr>

        <tr>
            <td height="25" colspan="4">
                <strong>Subject:</strong> เอกสาร<?php echo $row['doc_type']; ?> - เลขที่รับแจ้ง
                : <?php echo $row['id_data']; ?>
            </td>
        </tr>
        <tr>
            <td height="25" align="center" colspan="4"></td>
        </tr>
    </table>
    <br />
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="3" class="style36 style36">
                <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50%"><img src="images/logo.gif" width="314" height="60" /></td>
                        <td class="warn" width="50%">
                            <div align="right" class="style2">แจ้งอุบัติเหตุ 24 ชัวโมง 1557 ทั่วประเทศ</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="10" colspan="3"></td>
        </tr>
        <!-- <?php //if($row['com_data'] == "VIB_S") { ?>
        <tr>
            <td width="80" class="style36 style36">
                ปากเกร็ด</td>
            <td width="576">
                <span
                    class="style38"><?php //echo $row['title_sub']; ?>&nbsp;<?php //echo $row['sub']; ?>&nbsp;(<?php //echo $row['login']; ?>)</span>
            </td>
            <td width="271" class="style36 style36">
                <div align="right">เลขที่ พ.ร.บ. :
                    <?php 
                      //if($row['EditAct'] == 'Y') {
                      //  echo  $row['EditAct_id'];
                     // } else {
                        //echo $row['p_act'];
                     // }
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td class="style36 style36">&nbsp;</td>
            <td>&nbsp;</td>
            <td class="style36 style36">
                <div align="right">
                    <?php 
                  //  if($row['my4ib_check'] != '') {
                     // echo "ใบรับฝากเบี้ย : ".$row['my4ib_check']; 
                   // }
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td height="28" colspan="3"><span class="style38"><?php //echo $row['id_data']; ?></span></td>
        </tr>
        <tr>
            <td height="19" class="style36 style36"></td>
            <td class="style36 style36">71&nbsp;หมู่
                6&nbsp;สะพานนนทบุรี-บางบัวทอง&nbsp;ต.คลองข่อย&nbsp;อ.ปากเกร็ด&nbsp;จ.นนทบุรี 11120</td>
            <td class="style36 style36">
                <div align="right">เลขที่ผู้เสียภาษี 0105490000219</div>
            </td>
        </tr>
        <tr>
            <td class="style36 style36">ที่อยู่</td>
            <td class="style36 style36">Tel. 02-1968234 &nbsp;&nbsp;Fax. 02-196-8235</td>
            <td class="style36 style36">
                <div align="right">ทะเบียนการค้าเลขที่ 0105490000219</div>
            </td>
        </tr>
        <?php //} if($row['com_data'] == "VIB_C") { ?>
        <tr>
            <td width="80" class="style36 style36">
                <span class="style38">ปากเกร็ด</span>
            </td>
            <td width="563">
                <span
                    class="style38"><?php //echo $row['title_sub']; ?>&nbsp;<?php //echo $row['sub']; ?>&nbsp;(<?php //echo $row['login']; ?>)</span>
            </td>
            <td width="271" class="style36 style36">
                <div align="right">เลขที่ พ.ร.บ.: <?php //echo $row['p_act']; ?></div>
            </td>
        </tr>
        <tr>
            <td class="style36 style36">&nbsp;</td>
            <td>&nbsp;</td>
            <td class="style36 style36">
                <div align="right">
                    <?php 
                    //if($row['my4ib_check'] != '') {
                      //echo "ใบรับฝากเบี้ย : ".$row['my4ib_check']; 
                    //}
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td height="28" colspan="3"><span class="style38"><?php //echo $row['id_data']; ?></span></td>
        </tr>
        <tr>
            <td height="19" class="style36 style36"></td>
            <td class="style36 style36">71&nbsp;หมู่
                6&nbsp;สะพานนนทบุรี-บางบัวทอง&nbsp;ต.คลองข่อย&nbsp;อ.ปากเกร็ด&nbsp;จ.นนทบุรี 11120</td>
            <td class="style36 style36">
                <div align="right">เลขที่ผู้เสียภาษี 0105490000219</div>
            </td>
        </tr>
        <tr>
            <td class="style36 style36">ที่อยู่</td>
            <td class="style36 style36">Tel. 02-1968234 &nbsp;&nbsp;Fax. 02-196-8235</td>
            <td class="style36 style36">
                <div align="right">ทะเบียนการค้าเลขที่ &nbsp;&nbsp;0105490000219</div>
            </td>
        </tr>
        <?php //} ?> -->
        <tr>
            <td height="20" colspan="3" valign="top" class="style36 style36">
                <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999" class="coll">
                    <tr>
                        <td height="15" colspan="13">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="15%">รหัสบริษัท</td>
                                    <td width="10%">VIB</td>
                                    <td width="20%">ใบคำขอประกันภัยรถยนต์</td>
                                    <td width="88">อาณาเขตคุ้มครอง</td>
                                    <td width="175">ประเทศไทย</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="25" colspan="13">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="120">ใบคำขอเลขที่</td>
                                    <td width="650"><strong><?php echo $row['id_data']; ?></strong></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="70" colspan="13">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="89" height="29">ผู้เอาประกันภัย </td>
                                    <td width="28">ชื่อ</td>
                                    <td width="633">
                                        <span>
                                            <strong><?php echo $row['title'];?> <?php echo $row['namecus'];?>
                                                <?php echo $row['last'];?></strong>
                                        </span>
                                        <span style='position:absolute;left:650px;opacity: 0.2;'>
                                            <strong>
                                                <font color='RED' size='6'><?php echo $premium_name?></font>
                                            </strong>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="24"></td>
                                    <td>ที่อยู่</td>
                                    <td>
                                        <strong>
                                            <?php 
                                            echo $row['add']; 
                                            echo "      ";
                                            if($row['group'] !="-" && $row['group'] !="")
                                            {
                                              echo " หมู่".$row['group'];
                                            }
                                            if($row['town'] !="-" && $row['town'] !="")
                                            {
                                              echo " ".$row['town'];
                                            }
                                            if($row['lane'] !="-" && $row['lane'] !="")
                                            {
                                              echo " ซอย".$row['lane'];
                                            }
                                            if($row['road'] !="-" && $row['road'] !="")
                                            {
                                              echo " ถนน".$row['road'];
                                            }
                                            ?>
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <?php if($row['province'] != "102") { ?>
                                        <strong>ต. <?php echo $row['tumbon_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;อ.
                                            <?php echo $row['amphur_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;จ.<?php echo $row['province_name']; ?>&nbsp;
                                            <?php echo $row['postal']; ?></strong>
                                        <?php } else { ?>
                                        <strong>แขวง<?php echo $row['tumbon_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['amphur_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['province_name']; ?>&nbsp;
                                            <?php echo $row['postal']; ?></strong>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="40" colspan="13">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="263" height="28">ผู้ขับขี่ 1
                                        <?php if($row['name_num1']!="ไม่ระบุ"){ ?>
                                        <?php echo $row['title_num1']; ?> <?php echo $row['name_num1']; ?>
                                        <?php echo $row['last_num1']; ?>
                                        <?php } else {?>
                                        <?php echo $row['name_num1']; ?>
                                        <?php }?>
                                    </td>
                                    <td width="253">วัน/เดือน/ปีเกิด <?php echo $row['birth_num1']; ?></td>
                                    <td width="234">อาชีพ</td>
                                </tr>
                                <tr>
                                    <td>ผู้ขับขี่ 2
                                        <?php if($row['name_num2']!="ไม่ระบุ"){ ?>
                                        <?php echo $row['title_num2']; ?> <?php echo $row['name_num2']; ?>
                                        <?php echo $row['last_num2']; ?>
                                        <?php } else {?>
                                        <?php echo $row['name_num2']; ?>
                                        <?php }?>
                                    </td>
                                    <td>วัน/เดือน/ปีเกิด <?php echo $row['birth_num2']; ?></td>
                                    <td>อาชีพ</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="25" colspan="13">
                            <table width="700" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="126">ผู้รับผลประโยชน์</td>
                                    <td width="574"><?php echo $row['name_gain']; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="25" colspan="13">
                            <table width="700" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="250">ระยะเวลาประกันภัย : เริ่มต้นวันที่</td>
                                    <td width="139">
                                        <strong>
                                            <?php 
                                              $sendYear = date('Y',strtotime($row['send_date']))+543;	
                                              $startYear = date('Y',strtotime($row['start_date']))+543;
                                              $endYear = date('Y',strtotime($row['end_date']))+543;
                                              echo date('d/m',strtotime($row['start_date'])).'/'.$startYear;
                                            ?>
                                        </strong>
                                    </td>
                                    <td width="104">สิ้นสุดวันที่</td>
                                    <td width="115">
                                        <strong>
                                            <?php echo date('d/m',strtotime($row['end_date'])).'/'.$endYear; ?>
                                        </strong>
                                    </td>
                                    <td width="159">เวลา 16.30 น.</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="20" colspan="13">รายการรถยนต์ที่เอาประกันภัย</td>
                    </tr>
                    <tr>
                        <td width="21" height="10">
                            <div align="center">ลำดับ</div>
                        </td>
                        <td width="20" height="10">
                            <div align="center">รหัส</div>
                        </td>
                        <td width="209" height="10">
                            <div align="center">ชื่อรถยนต์/รุ่น</div>
                        </td>
                        <td width="126" height="10">
                            <div align="center">เลขทะเบียน</div>
                        </td>
                        <td height="10" colspan="6">
                            <div align="center">เลขตัวถัง</div>
                        </td>
                        <td width="60" height="10">
                            <div align="center">ปีรุ่น</div>
                        </td>
                        <td width="150" height="10">
                            <div align="center">เลขเครื่อง</div>
                        </td>
                        <td width="110" height="10">
                            <div align="center">ที่นั่ง/ขนาด/น.น.</div>
                        </td>
                    </tr>
                    <tr>
                        <td height="56">
                            <div align="center"></div>
                        </td>
                        <td height="56">
                            <div align="center">
                                <strong>
                                    <?php if($row['car_cat_acc'] != ''){echo $row['car_cat_acc'];}else{echo $row['car_id'];} ?>
                                </strong>
                            </div>
                        </td>
                        <td height="56">
                            <div align="center">
                                <strong><?php echo $row['car_brand']; ?></strong><br />
                                <strong><?php echo $nameCar; ?></strong>
                            </div>
                        </td>
                        <td height="56">
                            <div align="center">
                                <strong><?php echo $row['car_regis']; ?></strong><br />
                                <?php
                                if($row['com_data'] == "VIB_C") {
                                    echo $row['car_regis_text']; 
                                }
                                ?>
                            </div>
                        </td>
                        <td height="56" colspan="6">
                            <div align="center"><strong><?php echo $row['car_body']; ?></strong></div>
                        </td>
                        <td height="56">
                            <div align="center"><strong><?php echo $row['regis_date']; ?></strong></div>
                        </td>
                        <td height="56">
                            <div align="center"><strong><?php echo $row['n_motor']; ?></strong></div>
                        </td>
                        <td height="56">
                            <div align="center">
                                <strong>
                                    <?
                                      if(empty($scw)) {
                                        if($row['mo_car'] == "759" || $row['mo_car'] == "747") {
                                          echo "7 / 1600 / 3";
                                        } else if($row['mo_car'] == "1098") {
                                          echo "3 / 1600 / 3";
                                        } else if($row['mo_car'] == "1951") {
                                          echo "7 / 1200 / 3";
                                        } else if($row['mo_car'] == "754") {
                                          echo "7 / 2000 / 3";
                                        }
                                      } else {
                                        echo $scw;
                                      }
                                    ?>
                                </strong>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td height="15" colspan="13">จำนวนเงินเอาประกันภัย :
                            กรมธรรม์ประกันภัยนี้ให้การคุ้มครองเฉพาะข้อตกลงคุ้มครองที่มีจำนวนเงินเอาประกันภัยระบุไว้เท่านั้น
                        </td>
                    </tr>
                    <tr>
                        <td height="15" colspan="3">
                            <div align="center">ความรับผิดต่อบุคคลภายนอก</div>
                        </td>
                        <td height="15" colspan="6">
                            <div align="center">รถยนต์เสียหาย สูญหาย ไฟไหม้</div>
                        </td>
                        <td height="15" colspan="4">
                            <div align="center">ความคุ้มครองตามเอกสารแนบท้าย</div>
                        </td>
                    </tr>
                    <tr>
                        <td height="25" colspan="3" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td height="18" colspan="3">&nbsp;1) ความเสียหายต่อชีวิต ร่างกาย</td>
                                </tr>
                                <tr>
                                    <td height="18" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp; หรืออนามัยเฉพาะส่วนเกินวง</td>
                                </tr>
                                <tr>
                                    <td height="18" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp; เงินสูงสุดตาม พ.ร.บ.</td>
                                </tr>
                                <tr>
                                    <td width="13%" height="18">&nbsp;</td>
                                    <td width="53%" height="18">
                                        <div align="right">
                                            <strong>
                                                <?
                                              echo $protect_array['damage_out1'];
                                              $frist_1_1 = $protect_array['dd'];
                                              ?>
                                            </strong>
                                        </div>
                                    </td>
                                    <td width="34%" height="18">
                                        <div align="right">บาท/คน&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="18">&nbsp;</td>
                                    <td height="18">
                                        <div align="right"><strong><?php echo $protect_array['damage_notover'];?></strong></div>
                                    </td>
                                    <td height="18">
                                        <div align="right">บาท/ครั้ง&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="18" colspan="3">&nbsp;2) ความเสียหายต่อทรัพย์สิน</td>
                                </tr>
                                <tr>
                                    <td height="18">&nbsp;</td>
                                    <td height="18">
                                        <div align="right">
                                            <strong>
                                                <?
                                                echo $protect_array['damage_cost'];
                                                $frist_1_1 =$protect_array['dd'];
                                              ?>
                                            </strong>
                                        </div>
                                    </td>
                                    <td height="18">
                                        <div align="right">บาท/ครั้ง&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="18" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.1
                                        ความเสียหายส่วนแรก</td>
                                </tr>
                                <tr>
                                    <td height="18" colspan="3">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td height="18" colspan="3">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                        <td height="25" colspan="6" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td height="18" colspan="3">&nbsp;1) ความเสียหายต่อรถยนต์</td>
                                </tr>
                                <tr>
                                    <td width="22%" height="18">&nbsp;</td>
                                    <td width="44%" height="18">
                                        <div align="center"><strong>
                                                <?php echo substr($row['cost'],0,7);?>
                                            </strong></div>
                                    </td>
                                    <td width="34%" height="18">
                                        <div align="right">บาท/ครั้ง&nbsp;&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="18" colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.1 ความเสียหายส่วนแรก
                                    </td>
                                </tr>
                                <tr>
                                    <td height="18">&nbsp;</td>
                                    <?php 
                                    $array_date=explode(" ",$row['send_date']);
                                    if(date('Y-m-d',strtotime($array_date[0])) >= date('Y-m-d',strtotime('2019-05-15'))){ ?>
                                    <td height="18">
                                        <div align="center">
                                            <font color='red'><?php echo $frist_1_1;?></font>
                                        </div>
                                    </td>
                                    <td height="18">
                                        <div align="right">บาท&nbsp;&nbsp;</div>
                                    </td>
                                    <?php }else{ ?>
                                    <td height="18">
                                        <div align="center">-</div>
                                    </td>
                                    <td height="18">
                                        <div align="right">บาท&nbsp;&nbsp;</div>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td height="18" colspan="3">&nbsp;2) รถยนต์สูญหาย/ไฟไหม้</td>
                                </tr>
                                <tr>
                                    <td height="18">&nbsp;</td>
                                    <td height="18">
                                        <div align="center"><strong><?php echo substr($row['cost'],0,7);?></strong></div>
                                    </td>
                                    <td height="18">
                                        <div align="right">บาท&nbsp;&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="18" colspan="3">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div align="center"><span class="style6">ไม่รวม พ.ร.บ.</span></div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td height="25" colspan="4" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td height="18" colspan="3">&nbsp;1) อุบัติเหตุส่วนบุคคล</td>
                                </tr>
                                <tr>
                                    <td height="18" colspan="3">&nbsp;&nbsp;&nbsp;1.1 เสียชีวิต สูญเสียอวัยวะ
                                        ทุพพลภาพถาวร</td>
                                </tr>
                                <tr>
                                    <td width="44%" height="18">&nbsp;&nbsp;&nbsp;ก) &nbsp;ผู้ขับขี่ 1 คน</td>
                                    <td width="24%" height="18">
                                        <div align="right"><strong><?php echo $protect_array['pa1'];?></strong></div>
                                    </td>
                                    <td width="32%" height="18">
                                        <div align="right">บาท&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="18">&nbsp;&nbsp;&nbsp;ข) &nbsp;ผู้โดยสาร
                                        <strong>
                                            <?			
                                            echo $protect_array['people'];
                                            $frist_1_1 =$protect_array['dd'];
                                          ?>
                                        </strong> คน
                                    </td>
                                    <td height="18">
                                        <div align="right"><strong><?php echo $protect_array['pa2'];?></strong></div>
                                    </td>
                                    <td height="18">
                                        <div align="right">บาท/คน&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="18" colspan="3">&nbsp;&nbsp;&nbsp;1.2 ทุพพลภาพชั่วคราว</td>
                                </tr>
                                <tr>
                                    <td height="18">&nbsp;&nbsp;&nbsp;ก) &nbsp;ผู้ขับขี่ 1 คน</td>
                                    <td height="18">
                                        <div align="right"><?php echo $protect_array['pa5'];?></div>
                                    </td>
                                    <td height="18">
                                        <div align="right">บาท/สัปดาห์&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="18">&nbsp;&nbsp;&nbsp;ข) &nbsp;ผู้โดยสาร - คน</td>
                                    <td height="18">
                                        <div align="right"><?php echo $protect_array['pa6'];?></div>
                                    </td>
                                    <td height="18">
                                        <div align="right">บาท/คน/สัปดาห์&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="18" colspan="3">&nbsp;2) ค่ารักษาพยาบาล</td>
                                </tr>
                                <tr>
                                    <td height="18">&nbsp;</td>
                                    <td height="18">
                                        <div align="right">
                                            <strong>
                                                <?
                                                echo $protect_array['pa3'];
                                                $frist_1_1 = $protect_array['dd'];
                                              ?>
                                            </strong>
                                        </div>
                                    </td>
                                    <td height="18">
                                        <div align="right">บาท/คน&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="18" colspan="3">&nbsp;3) การประกันตัวผู้ขับขี่</td>
                                </tr>
                                <tr>
                                    <td height="18">&nbsp;</td>
                                    <td height="18">
                                        <div align="right"><strong><?php echo $protect_array['pa4'];?></strong></div>
                                    </td>
                                    <td height="18">
                                        <div align="right">บาท/ครั้ง&nbsp;</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="45" colspan="9">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="245">เบี้ยประกันภัยตามความคุ้มครองหลัก</td>
                                    <td width="94">
                                        <div align="center">
                                            <strong>
                                                <?
                                                if($row['car_id'] == "320") {
                                                  echo "-";
                                                  $frist_1_1 = $protect_array['dd'];
                                                } else {
                                                  echo "x,xxx";
                                                  $frist_1_1 = $protect_array['dd'];
                                                }
                                                ?>
                                            </strong>
                                        </div>
                                    </td>
                                    <td width="63">
                                        <div align="right">บาท&nbsp;&nbsp;&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>(เบี้ยประกันภัยได้หักส่วนลดกรณีระบุชื่อผู้ขับขี่</td>
                                    <td>
                                        <div align="center">-</div>
                                    </td>
                                    <td>
                                        <div align="right">บาทแล้ว)&nbsp;&nbsp;&nbsp;</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td height="45" colspan="4">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="296">เบี้ยประกันภัยตามเอกสารแนบท้าย</td>
                                    <td width="61">
                                        <div align="right">
                                            <strong>
                                                <?php 
                                                if($row['car_id'] == "320") {
                                                  echo "-";
                                                  $frist_1_1 =$protect_array['dd'];
                                                } else {
                                                  echo "x,xxx";
                                                  $frist_1_1 =$protect_array['dd'];
                                                }
                                                ?>
                                            </strong>
                                        </div>
                                    </td>
                                    <td width="60">
                                        <div align="right">บาท&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="40" colspan="2" valign="top">
                            <div align="center">ส่วนลด</div>
                        </td>
                        <td height="25">
                            <table width="99%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="73%">ความเสียหายส่วนแรก</td>
                                    <td width="10%">
                                        <div align="center">-</div>
                                    </td>
                                    <td width="17%">
                                        <div align="right">บาท&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>อื่นๆ</td>
                                    <td>
                                        <div align="center">-</div>
                                    </td>
                                    <td>
                                        <div align="right">บาท&nbsp;</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td height="25" colspan="7">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="36%">ส่วนลดกลุ่ม</td>
                                    <td width="44%">
                                        <div align="center">-</div>
                                    </td>
                                    <td width="20%">
                                        <div align="right">บาท&nbsp;&nbsp;&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>รวมส่วนลด</td>
                                    <td>
                                        <div align="center">
                                            <strong>
                                                <?php
                                                if ($row['car_id'] == "320") {
                                                    echo "-";
                                                    $frist_1_1 = $protect_array['dd'];
                                                } else {
                                                    echo "x,xxx";
                                                    $frist_1_1 = $protect_array['dd'];
                                                }
                                                ?>
                                            </strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div align="right">บาท&nbsp;&nbsp;&nbsp;</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td height="25" colspan="3">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="48%">ประวัติดี</td>
                                    <td width="32%">
                                        <div align="right">
                                            <strong>
                                                <?php
                                                if ($row['car_id'] == "320") {
                                                    echo "-";
                                                    $frist_1_1 = $protect_array['dd'];
                                                } else {
                                                    echo "x,xxx";
                                                    $frist_1_1 = $protect_array['dd'];
                                                }
                                                ?>
                                            </strong>
                                        </div>
                                    </td>
                                    <td width="20%">
                                        <div align="right">บาท&nbsp;</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <div align="center"></div>
                                    </td>
                                    <td>
                                        <div align="right">&nbsp;&nbsp;</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="30" colspan="2" valign="top">
                            <div align="center">ส่วนเพิ่ม</div>
                        </td>
                        <td height="25" colspan="11">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="10%">&nbsp;</td>
                                    <td width="26%">ประวัติเพิ่ม</td>
                                    <td width="10%">-</td>
                                    <td width="26%">บาท</td>
                                    <td width="28%">
                                        <div align="right" class="style39">ชำระอากรแล้ว&nbsp;&nbsp;&nbsp;</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="18" colspan="3">
                            <div align="center">เบี้ยประกันภัยสุทธิ</div>
                        </td>
                        <td height="18" colspan="4">
                            <div align="center">อากร</div>
                        </td>
                        <td height="18" colspan="4">
                            <div align="center">ภาษีมูลค่าเพิ่ม</div>
                        </td>
                        <td height="18" colspan="2">
                            <div align="center">รวม</div>
                        </td>
                    </tr>
                    <tr>
                        <td height="30" colspan="3">
                            <div align="center"><strong><?php echo number_format($row['pre'],2);?></strong></div>
                        </td>
                        <td height="30" colspan="4">
                            <div align="center"><strong><?php echo number_format($row['stamp'],2);?></strong></div>
                        </td>
                        <td height="30" colspan="4">
                            <div align="center"><strong><?php echo number_format($row['tax'],2);?></strong></div>
                        </td>
                        <td height="30" colspan="2">
                            <div align="center"><strong><?php echo number_format($row['net'],2);?></strong></div>
                        </td>
                    </tr>
                    <tr>
                        <td height="25" colspan="13">
                            <table width="700" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="120">การใช้รถยนต์ : </td>
                                    <td width="650">
                                        <?php
                                        $query_Passcar="SELECT `name` FROM tb_pass_car_type WHERE id='$arr_car_id[1]$arr_car_id[2]' AND id_pass_car='$arr_car_id[0]'";
                                        $row_Passcar = $dbmy4ib_new->query($query_Passcar)->fetch(2);
                                        echo $row_Passcar['name'];
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="42" colspan="13">
                            <?php if($row['EditProduct'] ==''){ ?>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="20%" height="40" valign="top">อุปกรณ์ตกแต่งเพิ่มเติม</td>
                                    <td width="80%" height="40" valign="top">
                                        <?php
                                          if ($row['equit'] == 'Y' && $row['car_detail'] == '0') { // เช็คแจ้งงานมีอุปกรณ์ตกแต่งหรือไม่
                                              $i = 0;
                                              $pre_add = 0;
                                              $product = "product";
                                              while ($i <= 14) {
                                                  if ($i == 0) {
                                                      if ($row[$product] != '0') {
                                                          echo $row[$product] . " ";
                                                      }
                                                  } else {
                                                      if ($row[$product . $i] != '0') {
                                                          echo $row[$product . $i] . " ";
                                                      }
                                                  }
                                                  $i++;
                                              }
                                          }
                                          if ($row['equit'] == 'Y' && $row['car_detail'] != '0') {
                                              $i = 0;
                                              $pre_add = 0;
                                              $exitNum = explode("|", $row['car_detail']);
                                              for ($i = 0;$i < count($exitNum);$i++) {
                                                  $exitSplit = explode(",", $exitNum[$i]);
                                                  if (number_format($costOb['name'][$exitSplit[1]], 0) == '1') {
                                                      $priceAcc = 0;
                                                  } else {
                                                      $priceAcc = number_format($costOb['name'][$exitSplit[1]], 0);
                                                  }
                                                  echo $costObname['name'][$row['cat_car']][$exitSplit[0]] . ' ';
                                                  echo $priceAcc . ' บาท ';
                                                  $pre_add+= $costOb['price'][$exitSplit[1]];
                                              }
                                          }
                                          if ($row['equit'] == 'N') {
                                              echo "ไม่มี";
                                          }
                                        ?>
                                        <?php if($row['add_price'] != '0.00'){ ?>
                                        &nbsp;&nbsp;
                                        <span class="style33"></br>
                                        </span>
                                        <strong>เพิ่มทุนอุปกรณ์<u>รวม</u>&nbsp;&nbsp;&nbsp;
                                            <?php echo number_format($row['price_total'])."  บาท"; ?>
                                        </strong>
                                        <span
                                            class="style1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span class="style20">&nbsp;</span>
                                        </span>
                                        <font color="#FF0000">
                                            <span class="style7">
                                                <strong>เพิ่มเบี้ย<u>รวม</u>
                                                    <span class="style1">&nbsp;&nbsp;&nbsp;
                                                        <?php if($row['car_cat_acc_total'] != '0.00'){echo number_format($row['car_cat_acc_total'],2)."  บาท";}else{echo number_format($row['add_price'],2)."  บาท";} ?>
                                                    </span>
                                                </strong>
                                            </span>
                                        </font>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                            <?php } if($row['EditProduct'] =='Y'){ ?>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="20%" height="40" valign="top">อุปกรณ์ตกแต่งเพิ่มเติม</td>
                                    <td width="80%" height="40" valign="top">
                                        <?php
                                        $i = 0;
                                        $pre_add = 0;
                                        $exitNum = explode("|", $row['Product']);
                                        for ($i = 0;$i < count($exitNum);$i++) {
                                            $exitSplit = explode(",", $exitNum[$i]);
                                            echo $costObname['name'][$row['cat_car']][$exitSplit[0]] . ' ';
                                            echo number_format($costOb['name'][$exitSplit[1]], 0) . ' บาท ';
                                            $pre_add+= $costOb['price'][$exitSplit[1]];
                                        }
                                        $pre_add = str_replace(',', '', $row['CostProduct']);
                                        ?>
                                        &nbsp;&nbsp;
                                        <span class="style33"> <br />
                                        </span><strong>เพิ่มทุนอุปกรณ์<u>รวม</u>&nbsp;&nbsp;&nbsp;
                                            <?php echo number_format($row['TotalProduct'])."  บาท"; ?></strong>
                                        <span
                                            class="style1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <span class="style20">&nbsp;</span>
                                        </span>
                                        <font color="#FF0000">
                                            <span class="style7">
                                                <strong>เพิ่มเบี้ย<u>รวม</u>
                                                    <span class="style1">&nbsp;&nbsp;&nbsp;
                                                        <?php if($row['car_cat_acc_total'] != '0.00'){echo number_format($row['car_cat_acc_total'],2)."  บาท";}else{echo number_format($pre_add,2,'.',',')."  บาท";} ?>
                                                    </span>
                                                </strong>
                                            </span>
                                        </font>
                                    </td>
                                </tr>
                            </table>
                            <?php } ?>
                        </td>
                    </tr>

                    <!-- ----------------------------------สลักหลัก------------------------------ -->
                    <?php
                      $ShowReqOld = '';
                      if ($row['send_req'] != '') {
                          $ShowReqOld.= $row['send_req'];
                      }
                      if ($row['send_req2'] != '') {
                          $ShowReqOld.= $row['send_req2'];
                      }
                      $ShowReq = '';
                      if ($row['EditTime'] == 'Y') {
                          $ShowReq.= "วันที่คุ้มครอง : " . date('d/m/Y', strtotime($row['EditTime_StartDate'])) . '<br>';
                      }
                      if ($row['EditHr'] == 'Y') {
                          $ShowReq.= "ผู้รับผลประโยชน์ : " . $row['EditHr_Detail'] . '<br>';
                      }
                      if ($row['EditAct'] == 'Y') {
                          $ShowReq.= "เลขที่ พรบ. : " . $row['EditAct_id'] . '<br>';
                      }
                      if ($row['EditCar'] == 'Y') {
                          $ShowReq.= "เลขตัวถัง : " . $row['Edit_CarBody'] . " / " . "เลขเครื่อง : " . $row['Edit_Nmotor'] . " / " . "สีรถ : " . $row['Edit_CarColor'] . '<br>';
                      }
                      if ($row['EditCustomer'] == 'Y') {
                          if ($row['EditPerson'] == 1) {
                              $EDITPERSON = "บุคคลธรรมดา";
                          } else if ($row['EditPerson'] == 2) {
                              $EDITPERSON = "นิติบุคคล";
                          }
                          $ShowReq.= $EDITPERSON;
                          $ShowReq.= " ชื่อผู้เอาประกันภัย : " . $row['Cus_title'] . " " . $row['Cus_name'] . " " . $row['Cus_last'] . '<br>';
                          $ShowReq.= "ที่อยู่ : " . $row['Cus_add'];
                          if ($row['Cus_group'] != "-" && $row['Cus_group'] != "") {
                              $ShowReq.= " หมู่" . $row['Cus_group'];
                          }
                          if ($row['Cus_town'] != "-" && $row['Cus_town'] != "") {
                              $ShowReq.= " " . $row['Cus_town'];
                          }
                          if ($row['Cus_lane'] != "-" && $row['Cus_lane'] != "") {
                              $ShowReq.= " ซอย" . $row['Cus_lane'];
                          }
                          if ($row['Cus_road'] != "-" && $row['Cus_road'] != "") {
                              $ShowReq.= " ถนน" . $row['Cus_road'];
                          }
                          if ($row['Cus_province'] != "102") {
                              $ShowReq.= " ต." . $row1['tumbon'] . " อ." . $row1['amphur'] . " จ." . $row1['province'] . " " . $row1['Cus_postal'];
                          } else {
                              $ShowReq.= " แขวง" . $row1['tumbon'] . " เขต." . $row1['amphur'] . " " . $row1['province'] . " " . $row1['Cus_postal'];
                          }
                      }
                      if ($row['EditCost'] == 'Y') {
                          $ShowReq.= "เปลี่ยนค่าเบี้ย : " . $row['EditcostCost'];
                      }
                    ?>
                    <?php if($row['updated'] && $ShowReqOld != ''){ ?>
                    <tr>
                        <td height="25" colspan="13">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="8%" valign="top">สลักหลัง </td>
                                    <td width="92%" valign="top"><?php echo $ShowReqOld;?>
                                        <?php echo "วันที่แจ้ง [".date('d/m/Y', strtotime($row['updated']))."]";?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php if($row['Req_Status'] == 'Y' && $ShowReq != ''){ ?>
                    <tr>
                        <td height="25" colspan="13">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="8%" valign="top">สลักหลัง </td>
                                    <td width="92%" valign="top"><?php echo $ShowReq;?>
                                        <?php echo "วันที่แจ้ง [".date('d/m/Y', strtotime($row['Req_Date']))."]";?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php
                      // add on
                      if ($row['code_addon'] != '') {
                          $i = 0;
                          $exitANum = explode(",", $row['code_addon']);
                          $exitSelect = explode(",", $row['code_addon_id']);
                          $costAD = 0;
                          $addonView = '';
                          for ($i = 0;$i < count($exitANum);$i++) {
                              $exitADDON = explode(",", $exitANum[$i]);
                              $sqlAddon = "select * from tb_addon where id = '" . $exitSelect[$i] . "'";
                              $sqlRes = $dbmy4ib_new->query($sqlAddon);
                              $sqlArr = $sqlRes->fetch();
                              $addonView = $addonView . ' ' . $sqlArr['name_addon'] . ' ' . $sqlArr['id_add'] . '  เบี้ยเพิ่ม ' . $sqlArr['cost_insuran'] . '  บาท   ';
                              $costAD = $costAD + $sqlArr['cost_insuran'];
                          }
                      ?>
                    <tr>
                        <td height="25" colspan="13">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="20%" valign="top">Add On : </td>
                                    <td width="80%" valign="top"><?php echo $addonView;?></td>
                                </tr>
                                <tr>
                                    <td width="20%" valign="top"> </td>
                                    <td width="80%" valign="top" style="color:#FF0000;font-weight:700;">เบี้ยเพิ่ม Add
                                        On รวม <?php echo number_format($costAD,2);?> บาท</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td height="20" colspan="13">หมายเหตุ :
                            <?php
                            if ($row['career'] == 1) {
                                echo "ออกใบเสร็จในนามบริษัท ";
                            }
                            if ($row['career'] == 2) {
                                echo "ออกใบเสร็จในนามลูกค้า ";
                            }
                            //-----------------///
                            if ($row['SendAdd'] != '') {
                                if ($row['status_SendAdd'] == 'Y') {
                                    $address_pdf = '';
                                    $textaddarray = explode('|', $row['SendAdd']);
                                    if ($textaddarray[0] != "-" && $textaddarray[0] != "") {
                                        $address_pdf.= $textaddarray[0];
                                    }
                                    if ($textaddarray[1] != "-" && $textaddarray[1] != "") {
                                        $address_pdf.= " หมู่ " . $textaddarray[1];
                                    }
                                    if ($textaddarray[2] != "-" && $textaddarray[2] != "") {
                                        $address_pdf.= " หมู่บ้าน/อาคาร " . $textaddarray[2];
                                    }
                                    if ($textaddarray[3] != "-" && $textaddarray[3] != "") {
                                        $address_pdf.= "ซอย " . $textaddarray[3] . " ";
                                    }
                                    if ($textaddarray[4] != "-" && $textaddarray[4] != "") {
                                        $address_pdf.= "ถนน " . $textaddarray[4];
                                    }
                                    if ($textaddarray[5] != "102") {
                                        $address_pdf.= ' ต.' . $_SESSION["Tum"][$textaddarray[7]] . ' อ.' . $_SESSION["Amp"][$textaddarray[6]];
                                        $address_pdf.= ' จ.' . $_SESSION["Pro"][$textaddarray[5]] . ' ' . $textaddarray[8];
                                    } else {
                                        $address_pdf.= ' แขวง' . $_SESSION["Tum"][$textaddarray[7]] . ' เขต' . $_SESSION["Amp"][$textaddarray[6]];
                                        $address_pdf.= ' ' . $_SESSION["Pro"][$textaddarray[5]] . ' ' . $textaddarray[8];
                                    }
                                    echo $SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : ' . $address_pdf . ')';
                                } else {
                                    echo $SendAdd = ' (กรุณาจัดส่งเอกสารมาที่ : ' . $row['SendAdd'] . ')';
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td height="25" colspan="13">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="195">
                                        <img src="images/2.jpg" width="16" height="16"
                                            align="absmiddle" />&nbsp;&nbsp;ตัวแทนประกันภัยรายนี้&nbsp;&nbsp;
                                    </td>
                                    <td width="316">
                                        <img src="images/1.jpg" width="16" height="16"
                                            align="absmiddle" />&nbsp;&nbsp;นายหน้าประกันภัยรายนี้&nbsp;&nbsp;&nbsp;
                                        <strong>ประกันภัยตรง</strong>
                                    </td>
                                    <td width="189">ใบอนุญาตเลขที่&nbsp;&nbsp;</td><!--ว.00018/2551-->
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="20" colspan="3" class="style36 style36">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="137" height="20">วันทำสัญญาประกันภัย</td>
                        <td width="249" height="20">
                            <strong>
                                <?php echo date('d/m',strtotime($row['start_date'])).'/'.$startYear; ?>
                            </strong>
                        </td>
                        <td width="116" height="20">วันทำกรมธรรม์</td>
                        <td width="248" height="20">
                            <strong>
                                <?php echo date('d/m',strtotime($row['send_date'])).'/'.$sendYear; ?>
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td height="20" colspan="4">
                            <span class="style8">เอกสารฉบับนี้เป็นเพียงข้อเสนอประกันภัยรถยนต์เท่านั้น
                                ส่วนเงื่อนไขความคุ้มครอง ข้อยกเว้น ตามที่กำหนด ระบุอยู่ในกรมธรรม์ประกันภัยรถยนต์ </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br />
    <input type="hidden" name="txtID" id="txtID" value="<?php echo $_GET['IDDATA']?>" />
    <input type="hidden" name="txtForm" id="txtForm" value="admin@viriyah.net" />
    <input type="hidden" name="txtTo1" id="txtTo1" value="<?php echo $row['Email']; ?>" />
    <input type="hidden" name="txtTo2" id="txtTo2" value="<?php echo $row['Email2']; ?>" />
    <input type="hidden" name="txtTo3" id="txtTo3" value="<?php echo $row['Email3']; ?>" />
    <input type="hidden" name="txtTo4" id="txtTo4" value="<?php echo $row['Email4']; ?>" />
    <input type="hidden" name="txtTo5" id="txtTo5" value="<?php echo $row['Email5']; ?>" />
    <input type="hidden" name="txtTo6" id="txtTo6" value="<?php echo $row['Email6']; ?>" />
    <input type="hidden" name="txtsub" id="txtsub" value="เอกสารประกันภัย พร้อมด้วยเลขที่รับแจ้ง" />
    <input type="hidden" name="txtSubject" id="txtSubject" value="เลขที่รับแจ้ง : <?php echo $row['id_data']; ?>" />
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="1" class="">
        <tr>
            <td height="48" colspan="4" align="right">
                <?php 
                $change_date = explode(' ',$row['send_date']);
                if($change_date['0']==date('Y-m-d') && empty($row['PactOnline'])){ ?>
                <span>
                    <font color='red'>***แก้ไขภายใน 1 วัน&nbsp;&nbsp;&nbsp;</font>
                </span><a class="btn btn-warning btn-large" type="button"
                    onclick='open_inform("<?php echo $row['id_data']?>");'>
                    <font color='BLACK'><i class="icon-white icon-check"></i> แก้ไขข้อมูล</font>
                </a>
                <?php }else if($row['Req_Status']=='Y'){ ?>
                <!-- <span><font color='red'>***ได้มีการทำสลักหลัง!!!&nbsp;&nbsp;&nbsp;</font></span>-->
                <?php } if($row['Status_Email']!='T') { ?>
                <button id="btnSendMail" class="btn btn-primary btn-large" type="button">
                    <font color='BLACK'><i class="icon-white icon-check"></i> แจ้งประกันภัย online</font>
                </button>
                <?php }else{ ?>
                <button class="btn btn-success btn-large" type="button">
                    <font size='4'>ยืนยันประกันภัยแล้ว!</font>
                </button>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td height="48" colspan="4" align="right"> <br /></td>
        </tr>
    </table>
</form>
<script>

$("#btnSendMail").click(function() {
    document.getElementById("loadingIcon").style.display = "";
    var DATA = $('#frm_send_mail').serialize();
    var options = {
        type: "POST",
        async: false,
        dataType: "json",
        url: "ajax/Ajax_Mail_new.php?",
        data: DATA,

        success: function(msg) {
            var returnedArray = msg;
            if (returnedArray.status == true) {
                $("#closed").click();

                alert(returnedArray.msg);

                $(".modal").hide();
                $(".modal-backdrop").hide();
                $(".modal").removeData('modal');

                if (returnedArray.idperson == 1) {
                    document.getElementById("loadingIcon").style.display = "none";
                    $('a[onclick="load_page(\'pages/load_Individuals.php\',\'บุคคลธรรมดา\');"]')
                        .trigger('click');
                } else if (returnedArray.idperson == 2) {
                    document.getElementById("loadingIcon").style.display = "none";
                    $('a[onclick="load_page(\'pages/load_Corporation.php\',\'นิติบุคคล\');"]').trigger(
                        'click');
                } else {
                    document.getElementById("loadingIcon").style.display = "none";
                    $('a[onclick="load_page(\'pages/load_Foreigner.php\',\'ชาวต่างชาติ\');"]').trigger(
                        'click');
                }
            } else {
                alert(returnedArray.msg);
                document.getElementById("loadingIcon").style.display = "none";
            }
        }
    };
    $.ajax(options);
});

</script>