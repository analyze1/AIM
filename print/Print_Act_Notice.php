<?php
session_start();
error_reporting(0);
include "../inc/checksession.inc.php";
include "../inc/connectdbs.pdo.php";
include "../phpqrcode/qrlib.php";

$Dbfour = PDO_CONNECTION::fourinsure_insured();

function thaiDate($datetime) {
    list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
    list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
    list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
    $Y = $Y + 543; // เปลี่ยน ค.ศ. เป็น พ.ศ.
    switch ($m) {
        case "01":
            $m = "01";
        break;
        case "02":
            $m = "02";
        break;
        case "03":
            $m = "03";
        break;
        case "04":
            $m = "04";
        break;
        case "05":
            $m = "05";
        break;
        case "06":
            $m = "06";
        break;
        case "07":
            $m = "07";
        break;
        case "08":
            $m = "08";
        break;
        case "09":
            $m = "09";
        break;
        case "10":
            $m = "10";
        break;
        case "11":
            $m = "11";
        break;
        case "12":
            $m = "12";
        break;
    }
    return $d . "/" . $m . "/" . $Y;
}

function thaiDate2($datetime) {
    list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
    list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
    list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
    $Y = $Y + 543; // เปลี่ยน ค.ศ. เป็น พ.ศ.
    switch ($m) {
        case "01":
            $m = "01";
        break;
        case "02":
            $m = "02";
        break;
        case "03":
            $m = "03";
        break;
        case "04":
            $m = "04";
        break;
        case "05":
            $m = "05";
        break;
        case "06":
            $m = "06";
        break;
        case "07":
            $m = "07";
        break;
        case "08":
            $m = "08";
        break;
        case "09":
            $m = "09";
        break;
        case "10":
            $m = "10";
        break;
        case "11":
            $m = "11";
        break;
        case "12":
            $m = "12";
        break;
    }
    return $d . "/" . $m . "/" . $Y . "  " . $H . ":" . $i . ":" . $s;
}

// ปี -1 สำหรับ วันสิ้นสุดกรมธรรม์
function thaiDate3($datetime) {
    list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
    list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
    list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
    $Y = $Y + 543; // เปลี่ยน ค.ศ. เป็น พ.ศ.
    switch ($m) {
        case "01":
            $m = "01";
        break;
        case "02":
            $m = "02";
        break;
        case "03":
            $m = "03";
        break;
        case "04":
            $m = "04";
        break;
        case "05":
            $m = "05";
        break;
        case "06":
            $m = "06";
        break;
        case "07":
            $m = "07";
        break;
        case "08":
            $m = "08";
        break;
        case "09":
            $m = "09";
        break;
        case "10":
            $m = "10";
        break;
        case "11":
            $m = "11";
        break;
        case "12":
            $m = "12";
        break;
    }
    return $d . "/" . $m . "/" . $Y;
}

function thaiDate_new($datetime) {
    list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
    list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
    list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
    if ($m == '12') {
        $m = '1';
        $Y = $Y + 544; // เปลี่ยน ค.ศ. เป็น พ.ศ.
        
    } else {
        $m = $m + 1;
        $Y = $Y + 543;
    }
    switch ($m) {
        case "01":
            $m = "01";
        break;
        case "02":
            $m = "02";
        break;
        case "03":
            $m = "03";
        break;
        case "04":
            $m = "04";
        break;
        case "05":
            $m = "05";
        break;
        case "06":
            $m = "06";
        break;
        case "07":
            $m = "07";
        break;
        case "08":
            $m = "08";
        break;
        case "09":
            $m = "09";
        break;
        case "10":
            $m = "10";
        break;
        case "11":
            $m = "11";
        break;
        case "12":
            $m = "12";
        break;
    }
    return $d . "/" . $m . "/" . $Y;
}

function convert($number) {
    $txtnum1 = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ');
    $txtnum2 = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
    $number = str_replace(",", "", $number);
    $number = str_replace(" ", "", $number);
    $number = str_replace("บาท", "", $number);
    $number = explode(".", $number);
    if (sizeof($number) > 2) {
        return 'ทศนิยมหลายตัวนะจ๊ะ';
        exit;
    }
    $strlen = strlen($number[0]);
    $convert = '';
    for ($i = 0;$i < $strlen;$i++) {
        $n = substr($number[0], $i, 1);
        if ($n != 0) {
            if ($i == ($strlen - 1) AND $n == 1) {
                $convert.= 'เอ็ด';
            } elseif ($i == ($strlen - 2) AND $n == 2) {
                $convert.= 'ยี่';
            } elseif ($i == ($strlen - 2) AND $n == 1) {
                $convert.= '';
            } else {
                $convert.= $txtnum1[$n];
            }
            $convert.= $txtnum2[$strlen - $i - 1];
        }
    }
    $convert.= 'บาท';
    if ($number[1] == '0' OR $number[1] == '00' OR $number[1] == '') {
        $convert.= 'ถ้วน';
    } else {
        $strlen = strlen($number[1]);
        for ($i = 0;$i < $strlen;$i++) {
            $n = substr($number[1], $i, 1);
            if ($n != 0) {
                if ($i == ($strlen - 1) AND $n == 1) {
                    $convert.= 'เอ็ด';
                } elseif ($i == ($strlen - 2) AND $n == 2) {
                    $convert.= 'ยี่';
                } elseif ($i == ($strlen - 2) AND $n == 1) {
                    $convert.= '';
                } else {
                    $convert.= $txtnum1[$n];
                }
                $convert.= $txtnum2[$strlen - $i - 1];
            }
        }
        $convert.= 'สตางค์';
    }
    return $convert;
}

$IDDATA = $_GET["IDDATA"];

$query = "SELECT ";
$query.= "data.id,";
$query.= "data.doc_type,";
$query.= "data.login, "; // รหัสผู้แจ้ง
$query.= "tb_comp.name as comp_name, "; // บริษัทประกันภัย
$query.= "tb_comp.name_print, ";
$query.= "tb_comp.Tax_id, ";
$query.= "tb_comp.add_namecom, ";
$query.= "tb_comp.add_namecom2, ";
$query.= "data.service, "; // ประเภทการซ่อม
$query.= "tb_user.sub as branch, "; // สาขา
$query.= "tb_user.Contact, "; // ชื่อผู้แจ้ง
$query.= "tb_user.cus_add, "; // บ้านเลขที่
$query.= "tb_user.cus_group, "; // หมู่
$query.= "tb_user.cus_town, "; //อาคาร/หมู่บ้าน
$query.= "tb_user.cus_lane, "; // ซอย
$query.= "tb_user.cus_road, "; // ถนน
$query.= "tb_user.cus_tumbon, "; // ตำบล คีย์
$query.= "tb_user.cus_amphur, "; // อำเภอ คีย์
$query.= "tb_user.cus_province, "; // จังหวัด คีย์
$query.= "tb_user.cus_postal , "; // รหัสไปรษณีย์
$query.= "tb_comp.tel  as comp_tel, "; // เบอร์โทรศัพท์(แจ้งอุบัติเหตุ)
$query.= "data.send_date,   "; // วันที่แจ้ง
$query.= "data.name_inform, "; // รหัสผู้แจ้ง
$query.= "data.id_data, "; // เลขที่รับแจ้ง
$query.= "data.o_insure, "; // เลขที่กรมธรรมเดิม
$query.= "tb_type_inform.name as type_inform_name, "; // ประเภทงาน
$query.= "data.idagent, "; //รหัสตัวแทน
$query.= "data.start_date, "; // วันที่คุ้มครอง
$query.= "data.end_date, "; // วันที่สิ้นสุด
$query.= "data.name_gain, "; // ชื่อผู้รับผลประโยชน์
$query.= "insuree.title, "; // คำนำหน้า ชื่อผู้เอาประกัน
$query.= "insuree.name,  "; // ชื่อผู้เอาประกัน
$query.= "insuree.last, "; // นามสกุลผู้เอาประกัน
$query.= "insuree.add, "; // บ้านเลขที่
$query.= "insuree.group, "; // หมู่
$query.= "insuree.town, "; //อาคาร/หมู่บ้าน
$query.= "insuree.lane, "; // ซอย
$query.= "insuree.road, "; // ถนน
$query.= "insuree.tumbon, "; // ตำบล คีย์
$query.= "insuree.amphur, "; // อำเภอ คีย์
$query.= "insuree.province, "; // จังหวัด คีย์
$query.= "insuree.postal, "; // รหัสไปรษณีย์
$query.= "insuree.tel_mobile, "; // เบอร์โทร
$query.= "insuree.email, "; // Email
$query.= "insuree.email_cc, "; // Email
$query.= "tb_tumbon.name as tumbon_name, ";
$query.= "tb_amphur.name as amphur_name, ";
$query.= "tb_province.name as province_name, "; // จังหวัด
$query.= "detail.car_id, "; // ประเภทการใช้รถ + ลักษณะการใช้
$query.= "tb_br_car.name as car_brand, "; // ยี่ห้อรถ
$query.= "tb_cat_car.name as cat_car_name, "; // ประเภทรถ
$query.= "tb_mo_car.name as mo_car_name, "; // รุ่นรถ
$query.= "detail.car_color, "; // สีรถ
$query.= "detail.cc, "; // ซี ซี
$query.= "detail.car_regis, "; // ทะเบียนรถ
$query.= "detail.car_regis_pro, "; // ทะเบียนรถ
$query.= "detail.car_body, "; // เลขตัวถัง
$query.= "detail.regis_date, "; // ปีที่จดทะเบียน
$query.= "detail.n_motor, "; // เลขเครื่อง
$query.= "detail.cost_renew, "; //ทุนต่ออายุ
$query.= "detail.pre_renew, "; // เบี้ยสุทธิ
$query.= "detail.net_renew, "; // เบี้ยรวม
$query.= "detail.id_data_company, ";
$query.= "detail.total_prb_renew, ";
$query.= "detail.id_prb_renew, ";
$query.= "detail.prb_renew, ";
$query.= "premium.pre, "; // เบี้ยสุทธิ
$query.= "premium.driver, "; // ส่วนลดระบุผู้ขับขี่
$query.= "premium.good, "; // ส่วนลดประวัติดี
$query.= "premium.total_pre, "; // เบี้ยสิทธิ หักส่วนลด
$query.= "premium.total_stamp, "; // รวม อากร
$query.= "premium.total_vat, "; // รวม ภาษี
$query.= "premium.prb, "; // เบี้ย พ.ร.บ.
$query.= "premium.total_prb, "; // เบี้ยรวม พ.ร.บ.
$query.= "premium.total_sum, "; // เบี้ยรวม
$query.= "premium.other, "; // เบี้ยรวม
$query.= "premium.vat_1, "; // เบี้ยรวม
$query.= "premium.tax1prb, "; // เบี้ยรวม
$query.= "premium.commition, "; // ส่วนลดเป็นบาท
$query.= "premium.total_commition, "; // ยอดชำระ
$query.= "protect.cost, "; // ทุนประกัน
$query.= "protect.damage_out1, "; //
$query.= "protect.damage_cost, "; //
$query.= "protect.pa1, "; //
$query.= "protect.pa2, "; //
$query.= "protect.pa3, "; //
$query.= "protect.pa4, "; //
$query.= "protect.people, "; //
$query.= "service.fac1, "; //
$query.= "service.fac2, "; //
$query.= "service.fac3, "; //
$query.= "tb_user.Email,";
$query.= "tb_user.Email2,";
$query.= "tb_user.Email3,";
$query.= "tb_user.Email4,";
$query.= "tb_user.Email5, ";
$query.= "act.p_id ";
$query.= "FROM data ";
$query.= "INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query.= "INNER JOIN service ON (data.id_data = service.id_data) ";
$query.= "INNER JOIN premium ON (data.id_data = premium.id_data) ";
$query.= "INNER JOIN protect ON (data.id_data = protect.id_data) ";
$query.= "INNER JOIN tb_type_inform ON (data.ty_inform = tb_type_inform.code) ";
$query.= "INNER JOIN tb_comp ON (data.com_data = tb_comp.sort) ";
$query.= "INNER JOIN tb_br_car ON (tb_br_car.id = detail.br_car)  ";
$query.= "INNER JOIN act ON (act.id_data = data.id_data)  ";
$query.= "INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query.= "INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car) ";
$query.= "INNER JOIN tb_cat_car ON (tb_cat_car.id = detail.cat_car) ";
$query.= "INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
$query.= "INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
$query.= "INNER JOIN tb_province ON (tb_province.id = insuree.province) ";
$query.= "INNER JOIN tb_user ON (tb_user.user = data.login) ";
$query.= "WHERE data.id_data='" . $IDDATA . "' ";
$objQuery4 = $Dbfour->query($query);
$row = $objQuery4->fetch(2);

$car_id = $row['car_id'];
$id_data_rec = $row['id_data'];
$arr_car_id = str_split($car_id);

if ($row['group'] != "-" && $row['group'] != "") {
    $address_pdf = " หมู่ " . $row['group'];
}
if ($row['town'] != "-" && $row['town'] != "") {
    $address_pdf.= " หมู่บ้าน/อาคาร " . $row['town'];
}
if ($row['lane'] != "-" && $row['lane'] != "") {
    $address_pdf4.= "ซอย " . $row['lane'] . " ";
}
if ($row['road'] != "-" && $row['road'] != "") {
    $address_pdf4.= "ถนน " . $row['road'];
}
if ($row['province'] != "102") {
    $address_pdf2 = 'ต.' . $row['tumbon_name'] . ' อ.' . $row['amphur_name'];
    $address_pdf3 = 'จ.' . $row['province_name'];
} else {
    $address_pdf2 = 'แขวง' . $row['tumbon_name'] . ' เขต' . $row['amphur_name'];
    $address_pdf3 = $row['province_name'];
}

$sql = "SELECT name_mini FROM tb_province WHERE id='$row[car_regis_pro]'";
$fetcharr = $Dbfour->query($sql)->fetch();
$c_regis = $fetcharr['name_mini'];


$sql_folup = "SELECT * From followup where id_data='$row[id_data]' AND (status = 'SS-F' OR status = 'SS') AND amount != '0.00' ORDER BY id DESC LIMIT 1 ";
$fetch_folup = $Dbfour->query($sql_folup)->fetch();

if ($_GET['feed'] == 'SS-F') {
    if ($row['prb_renew'] != '') {
        $fix_prb = $row['prb_renew'];
    } else {
        if ($row['p_id'] == '--ไม่รวม--') {
            $fix_prb = 0.00;
        } else {
            if (!empty($row["prb"])) {
                $fix_prb = $row["prb"];
            } else {
                $fix_prb = '0.00';
            }
        }
    }
    if ($fetch_folup["status_prb"] == '') {
        $fix_prb = $fix_prb;
    } else if ($fetch_folup["status_prb"] == 'Y') {
        $fix_prb = $fix_prb;
    } else {
        $fix_prb = 0.00;
    }
} else {
    if ($row["prb"] == '0') {
        $fix_prb = '0.00';
    } else {
        $fix_prb = $row["prb"];
    }
}

if ($row["service"] == '1') {
    $txtrepair = " ( ซ่อมห้าง )";
} else if ($row["service"] == '2') {
    $txtrepair = " ( ซ่อมอู่ )";
}

require ('../fpdf.php');
require ('../code128.php');

$pdf = new PDF_Code128();
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(false);
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->AddFont('angsa', 'B', 'angsab.php');
$pdf->AddPage();

// set style for barcode
$style = array('border' => true, 'padding' => 4, 'fgcolor' => array(0, 0, 0), 'bgcolor' => false,);
$pdf->Image('../images/MistubishiActNotice.jpg', 0, 0, 210, 299);

$pdf->SetFont('angsa', 'B', 18);
$pdf->SetY(33);
$pdf->SetX(15);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', 'เรียน ' . $row['title'] . ' ' . $row['name'] . ' ' . $row['last']), 0, 0, 'L');

$pdf->SetFont('angsa', 'B', 14);

if ($row['id_data_company'] != '') {
    $id_data = $row['id_data_company'];
} else {
    $id_data = $row['id_data'];
}

$pdf->SetY(89.7); //102
$pdf->SetX(34.5);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $id_data), 0, 0, 'L');

$pdf->SetTextColor(0, 0, 0);
$pdf->SetY(92.2); //126
$pdf->SetX(80.5); //28
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['car_regis'] . " " . $c_regis), 0);
$pdf->SetY(101); //133
$pdf->SetX(28);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['car_brand']), 0);
$pdf->SetX(64.5);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $row['mo_car_name']), 0);

$pdf->SetY(106); //113
$pdf->SetX(28);
$pdf->Cell(68, 8, iconv('UTF-8', 'TIS-620', thaiDate3($row['start_date']) . ' - ' . thaiDate3($row['end_date'])), 0, 0, 'C');

/************************ พ.ร.บ. **********************************************************************************/
$pdf->SetY(115.6); //149
$pdf->SetX(62);
$pdf->Cell(20, 6.5, iconv('UTF-8', 'TIS-620', number_format(str_replace(',', '', $fix_prb), 2)), 0, 0, "R");
/*********************** หัก 1 เปอร์เซ็น *****************************************************************************/

$pdf->SetY(201); //238 ชื่อลูกค้า
$pdf->SetX(160);
$pdf->SetFont('angsa', 'B', 13);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $row['title'] . ' ' . $row['name'] . ' ' . $row['last']), 0, 0, 'L');

$exid_data = explode('/', $row['id_data']);
$excarbody = substr($row['car_body'], -5);
$pdf->SetY(207.8); //257
$pdf->SetX(167);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', '13' . $exid_data[0] . '' . $exid_data[2]), 0);

$pdf->SetY(212); //263
$pdf->SetX(167);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $excarbody), 0);
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pdf->SetY(241); //263 จำนวนเงิน
$pdf->SetX(129.5);
$pdf->Cell(40, 6, iconv('UTF-8', 'TIS-620', $row["total_commition"]), 0, 0, 'C');

$pdf->SetY(248); //263 จำนวนเงินตัวอักษร
$pdf->SetX(39.5);
$num2dg = str_replace(',', '', $row["total_commition"]);
$numcutdot = str_replace('.', '', $num2dg);
$pdf->Cell(130, 6, iconv('UTF-8', 'TIS-620', convert($num2dg)), 0, 0, 'C');

$pdf->SetY(285); //295
$pdf->SetX(4);
$codeN = "|012555100145701 13" . $exid_data[0] . '' . $exid_data[2] . " " . $excarbody . " " . $numcutdot . "";
$code = "|012555100145701\n13" . $exid_data[0] . '' . $exid_data[2] . "\n" . $excarbody . "\n" . $numcutdot . "";
$pdf->Code128(5, 270, $code, 170, 13);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $codeN), 0);
$qrcodename = $exid_data[0] . $exid_data[2];
$pdf->Output();
?>