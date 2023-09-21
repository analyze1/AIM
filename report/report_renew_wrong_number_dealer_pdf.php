<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.pdo.php";
include "../inc/function.php";
require('../print/rotation.php');
require('../services/ReportRenew/service/report-renew.service.php');
require('../services/QuickFindDataArray/ModelCarFour.service.php');
define('FPDF_FONTPATH', 'font/');

$_serviceMitSu = new ReportRenew(PDO_CONNECTION::fourinsure_mitsu(), PDO_CONNECTION::fourinsure_insured());
// $_serMoCar = new ModelCarFour(PDO_CONNECTION::fourinsure_insured());
$_gdetailSer = new GetdetailFollowControl(PDO_CONNECTION::fourinsure_mitsu());

$model = new stdClass();
$model->user = $_POST['dealerCode'];
$model->month = $_POST['genMonth'];
$model->year = $_POST['genYear'];
$model->typeOptions = $_POST['typeOptions'];
$model->startDate = $_POST['start_date'];
$model->endDate = $_POST['end_date'];

$dataAll = $_serviceMitSu->wrongCustomerNumber($model);
// $_serMoCar->getMoCarMitsuAll();
$_informCompany = $_serviceMitSu->loadDataDealerById($model->user);
$_informDealer = $_serviceMitSu->dealerAllArrSearch();

if (!$dataAll) {
    echo "<center><h1><p style='color:red;'>ไม่พบข้อมูล</p></h1></center>";
    exit();
}

#region class function 
class PDF extends PDF_Rotate
{
    function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function RotatedImage($file, $x, $y, $w, $h, $angle)
    {
        //Image rotated around its upper-left corner
        $this->Rotate($angle, $x, $y);
        $this->Image($file, $x, $y, $w, $h);
        $this->Rotate(0);
    }
}
function thaiDate($datetime)
{
    list($date, $time) = explode(' ', $datetime); // แยกวันที่ กับ เวลาออกจากกัน
    list($H, $i, $s) = explode(':', $time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
    list($Y, $m, $d) = explode('-', $date); // แยกวันเป็น ปี เดือน วัน
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

function getMonthTH($mm)
{
    $month = '';
    switch ($mm) {
        case 1:
            $month = "มกราคม";
            break;
        case 2:
            $month = "กุมภาพันธ์";
            break;
        case 3:
            $month = "มีนาคม";
            break;
        case 4:
            $month = "เมษายน";
            break;
        case 5:
            $month = "พฤษภาคม";
            break;
        case 6:
            $month = "มิถุนายน";
            break;
        case 7:
            $month = "กรกฎาคม";
            break;
        case 8:
            $month = "สิงหาคม";
            break;
        case 9:
            $month = "กันยายน";
            break;
        case 10:
            $month = "ตุลาคม";
            break;
        case 11:
            $month = "พฤศจิกายน";
            break;
        case 12:
            $month = "ธันวาคม";
            break;
    }
    return $month;
}
#endregion

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->AddFont('angsa', 'B', 'angsab.php');
$pdf->SetAutoPageBreak(true);
//ตั้งค่า
//ตั้งค่า ตะแหน่ง x , y
$setY = array(40, 10, 3, 220);
$setX = array(3.5, 285, 5);
//ตั้งค่า ความยาว และ สูงของ cell
// $ar_width_cell = array(9, 20, 30, 68, 50, 43, 30, 38);
// $ar_height_cell = array(7, 7, 7, 7, 7, 7, 7, 7);
$ar_width_cell = array(9, 20, 30, 20, 88, 33, 23, 30, 35);
$ar_height_cell = array(7, 7, 7, 7, 7, 7, 7, 7, 7);

//ตั้งค่า border
$border = 1;
//font size
$ar_font_size = array(14, 12, 11);
$ar_font_type = array('', 'B');
$pg = 0;
$ch = 0;
$n = 0;
$total_pre_sum = 0;
$total_sum_sum = 0;
$prb_sum = 0;
$commition_sum = 0;
$total_commition_sum = 0;
$n = 0;
$dataAllCount = count($dataAll);

foreach ($dataAll as $row) {
    $n++;
    $x = 0;
    $ch++;
    if ($ch == 1) {
        $pdf->AddPage();
        $pdf->SetFont('angsa', $ar_font_type[0], $ar_font_size[0]);
        $pg++;
        $pdf->SetY($setY[2]);
        $pdf->SetX($setX[1]);
        $pdf->Cell(7, 7, iconv('UTF-8', 'TIS-620', $pg), 0, 1, "R");
        $pdf->SetY($setY[1]);
        $pdf->SetX($setX[0]);
        if ($_SESSION["strUser"] != 'admin') {
            $company_name = $_SESSION["strName"];
        } else {
            // $company_name='บริษัท โฟร์ อินชัวรันส์ โบรกเกอร์ จำกัด';
            $company_name = "[$row[login]] ".$_informCompany->titleSub . ' ' . $_informCompany->name;
        }
        $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', $company_name), 0, 1, "L");
        $pdf->SetX($setX[0]);
        $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'รายงานเบอร์ลูกค้าผิด'), 0, 1, "L");
        $pdf->SetX($setX[0]);
        $pdf->Cell(0, 7, iconv('UTF-8', 'TIS-620', 'วันที่ ' . thaiDate($model->startDate) . ' ถึง ' . thaiDate($model->endDate)), 0, 1, "L");
        $pdf->SetFillColor(228, 228, 228);
        $pdf->SetFont('angsa', $ar_font_type[0], $ar_font_size[0]);
        $x = 0;
        $pdf->SetY($setY[0]);
        $pdf->SetX($setX[0]);
        $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'ลำดับ'), $border, 0, "C", "T");
        $x++;
        $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'วันที่แก้ไข'), $border, 0, "C", "T");
        $x++;
        $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'เลขที่รับแจ้ง'), $border, 0, "C", "T");
        $x++;
        $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'วันหมดอายุ'), $border, 0, "C", "T");
        $x++;
        $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'ชื่อผู้เอาประกัน'), $border, 0, "C", "T");
        $x++;
        $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'สถานะ'), $border, 0, "C", "T");
        $x++;
        $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'เบอร์ผิด'), $border, 0, "C", "T");
        $x++;
        $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'การครั้งโทรล่าสุด'), $border, 0, "C", "T");
        $x++;
        $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', 'รายละเอียด'), $border, 1, "C", "T");
        $x++;
        $pdf->SetFont('angsa', $ar_font_type[0], $ar_font_size[0]);
    }
    $x = 0;
    $pdf->SetX($setX[0]);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $n), $border, 0, "C");
    $x++;
    $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', thaiDate($row['TimeStamp'])), $border, 0, "C");
    $x++;
    $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $row['id_data']), $border, 0, "C");
    $x++;
    $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', thaiDate($row['end_date'])), $border, 0, "C");
    $x++;
    $fullName = $row['title'] . ' ' . $row['name'] . ' ' . $row['last'];
    $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $fullName), $border, 0, "L");
    $x++;
    $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $row['StatusFollow']), $border, 0, "L");
    $x++;
    $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $_serviceMitSu->reTelephone($row['Telephone'])), $border, 0, "C");
    $x++;
    $res_last_call = $_serviceMitSu->loadLastCallById($row['id_data'], trim($row['Telephone']));
    $lastCall = (empty($res_last_call->log_date) ? 'ไม่มีการโทร' : $res_last_call->log_date);
    $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $lastCall), $border, 0, "C");
    $x++;
    $pdf->Cell($ar_width_cell[$x], $ar_height_cell[$x], iconv('UTF-8', 'TIS-620', $row['Detail']), $border, 1, "L");
    $x++;
    if ($ch == 20 || $n == $dataAllCount) {
        $strLong = strlen($company_name);
        $ch = 0;
        $pdf->SetFont('angsa', $ar_font_type[0], $ar_font_size[1]);
        $pdf->SetY(200);
        if ($strLong > 110) {
            $pdf->SetX(175);
        }
        if ($strLong < 110 && $strLong > 90) {
            $pdf->SetX(192);
        }
        if ($strLong < 90) {
            $pdf->SetX(208);
        }
        $pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', ' พิมพ์โดย ' . $company_name . ' วันที่พิมพ์ ' . thaiDate(date('Y-m-d'))), 0, "R");
    }
}

$pdf->Output('I');
?>