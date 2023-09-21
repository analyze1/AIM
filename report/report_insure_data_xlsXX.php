<?php
include ("../ClassesExcel/PHPExcel.php"); 
include "../check-ses.php";
include "../../inc/connectdbs.pdo.php"; 
function Typeperson($person){
    switch($person)
    {
        case "1": $person = "บุคคล"; break;
        case "2": $person = "นิติบุคคล"; break;

    }
    return $person;
}
function paytype($pay)
{
    switch($pay)
    {
        case "CASH": $pay = "เงินสด"; break;
        case "CCB": $pay = "เช็ค"; break;
        case "SMT": $pay = "โอน"; break;
        case "CREDIT": $pay = "บัตรเครดิต"; break;
        case "CASH10002": $pay = "เงินสดย่อย (500 บาท)"; break;
    }
    return $pay;
}

function banktype($bank)
{
    switch($bank)
    {
        case "BBK": $bank = "กรุงเทพ"; break;
        case "KTB": $bank = "กรุงไทย"; break;
        case "BAY": $bank = "กรุงศรีฯ"; break;
        case "KBANK": $bank = "กสิกรไทย"; break;
        case "SCB": $bank = "ไทยพาณิชย์"; break;
    }
    return $bank;
}

function thaiDate($datetime)
{
    list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
    list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
    list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
    $Y = $Y; // เปลี่ยน ค.ศ. เป็น พ.ศ.
    // if($Y==000){
    //     $Y='0000';
    // }
    switch($m)
    {
        case "01": $m = "01"; break;
        case "02": $m = "02"; break;
        case "03": $m = "03"; break;
        case "04": $m = "04"; break;
        case "05": $m = "05"; break;
        case "06": $m = "06"; break;
        case "07": $m = "07"; break;
        case "08": $m = "08"; break;
        case "09": $m = "09"; break;
        case "10": $m = "10"; break;
        case "11": $m = "11"; break;
        case "12": $m = "12"; break;
    }
    return $d."/".$m."/".$Y;
}
/////////SET UP /////////////
$txt_month = $_POST['txt_month'];
$sheetnametitle= "รายงานการแจ้งประกันภัย"; 
// ตั้งชื่อ SHEET
$sheetname = "รายงานการแจ้งประกันภัย";
 // ชื่อ คอลัมภ์
$arrHead = array('เลขรับแจ้ง','วันที่แจ้ง','ชื่อผู้เอาประกัน','รุ่น','เลขตัวถัง');
$arrHeadwidth = array('12','15','30','30','30');
$countColum = count($arrHead);
$colSet='A'; 
$beginHeader = '2'; //  ชื่อ column
$beginrow = '3';   //เริ่มข้อมูล
$colbegin = $colSet;
 // for($s = 1;$s<$countColum;$s++){
 //  $colSet++;
 // }
$colend = 'F';
$colAll = $colbegin.$beginHeader.':'.$colend.$beginHeader;

// สรุปรวม
$useSum = 'N'; // N ไม่มีรวม Y มีรวม

$EndYear = date('Y');
$StartYear = $EndYear-10;


    $txtsearch = $_GET['txtsearch'];
    if($_GET['otp']=='senddate')
    {
        $arr_id = explode("/",$_GET['txtsearch']);
        $arr_id2 = explode("/",$_GET['txtsearch2']);
        $search = " AND data.send_date BETWEEN '".$arr_id[2]."-".$arr_id[1]."-".$arr_id[0]."' AND '".$arr_id2[2]."-".$arr_id2[1]."-".$arr_id2[0]."' ";
        $txtsearch = $_GET['txtsearch'].'&txtsearch2='.$_GET['txtsearch2'];
        //$txtsearch2 = $_POST['txtenddate'];

    }else if($_GET['otp']=='iddata')
    {
        $new_iddata = split("-", $_GET['txtsearch']);
        
        if($new_iddata[1] == '')
        {
            $search = " AND data.id_data  like '%".$_GET['txtsearch']."%' ";
        }
        else
        {
            $search = " AND (data.id_data"." LIKE '%".$new_iddata[0]."/รย/".$new_iddata[1]."%' OR data.id_data LIKE '%".$new_iddata[0]."/FOUR/".$new_iddata[1]."%' ) ";
        }
    }
    else if($_GET['otp']=='policy')
    {
        $search = " AND data.n_insure  like '%".$_GET['txtsearch']."%' ";
    }
    else if($_GET['otp']=='namesearch')
    {
        $search = " AND ((insuree.name"." LIKE '%".$_GET['txtsearch']."%' OR insuree.last LIKE '%".$_GET['txtsearch']."%' ) OR (req.Cus_name"." LIKE '%".$_GET['txtsearch']."%' OR req.Cus_last LIKE '%".$_GET['txtsearch']."%' ) ) ";
    }
    else if($_GET['otp']=='prb')
    {
        
        $legtxt=strlen($_GET['txtsearch']);
        if($legtxt>=13)
        {
            $lowtxt=$legtxt-7;
            $subtxt=substr($_GET['txtsearch'],$lowtxt,7);
        }
        else
        {
            $subtxt=$_GET['txtsearch'];
        }
        $search = " AND (data.p_act LIKE '%".$subtxt."%' OR req.EditAct_id LIKE '%".$subtxt."%' ) ";
    }
    else if($_GET['otp']=='carbody')
    {
        $search = " AND (detail.car_body  LIKE  '%".$_GET['txtsearch']."%' OR req.Edit_CarBody LIKE '%".$_GET['txtsearch']."%' ) ";
    }
    else if($_GET['otp']=='phone')
    {
        $search = " AND insuree.tel_home"." LIKE '%".$_GET['txtsearch']."%' OR insuree.tel_mobi LIKE '%".$_GET['txtsearch']."%' OR insuree.tel_mobi_2 LIKE '%".$_GET['txtsearch']."%' OR insuree.tel_mobi_3 LIKE '%".$_GET['txtsearch']."%' ";
    }
  else if($_GET['otp']=='regis')
  {
    $search = " AND detail.car_regis LIKE '%".$_GET['txtsearch']."%' ";
  }

if($_SESSION['strUser']=='ADMIN' || $_SESSION["strUser"]=='admin')
{
    $sqlPmuser= '';
}
else
{
    $sqlPmuser=  " AND data.login = '".$_SESSION['strUser']."' ";
}

//$arrHead = array('เลขรับแจ้ง','วันที่แจ้ง','ชื่อผู้เอาประกัน','วันคุ้มครอง','ยี่ห้อ','รุ่น','เลขตัวถัง');
$query = "SELECT ";
$query .= " insuree.name As cus_name,detail.car_detail,data.id_data,detail.id_data,insuree.id_data,data.com_data,data.n_insure,detail.br_car,detail.mo_car,detail.add_price,detail.cat_car,data.login,detail.car_regis,insuree.title,insuree.last,data.send_date,data.start_date,data.end_date,detail.car_body,detail.n_motor,data.costCost,detail.car_id,data.p_act, req.CostProduct, req.Cus_title, req.Cus_name as reqcusname, req.Cus_last, req.EditAct_id, req.Edit_CarBody, req.CostProduct, tb_customer.saka, req.Req_Status,detail.mo_sub,detail.car_cat_acc_total,detail.car_cat_acc,detail.equit,req.EditProduct,tb_br_car.name as brname ,tb_mo_car.name as moname ";
$query .= ",insuree.add,insuree.group,insuree.town,insuree.lane,insuree.road,insuree.tumbon,insuree.amphur,insuree.province,insuree.postal ";
$query .= ",req.EditCustomer,req.Cus_add,req.Cus_group,req.Cus_town,req.Cus_lane,req.Cus_road,req.Cus_tumbon,req.Cus_tumbon,req.Cus_amphur,req.Cus_province,req.Cus_postal,req.EditCar,req.Edit_CarBody,req.EditTime,req.EditTime_StartDate,req.EditTime_EndDate , ";
$query .= "tb_tumbon.name as tumbon_name, "; 
$query .= "tb_amphur.name as amphur_name, "; 
$query .= "tb_province.name as province_name "; // จังหวัด

$query .= " FROM data ";
$query .= " INNER JOIN detail ON (data.id_data = detail.id_data) ";
$query .= " INNER JOIN insuree ON (data.id_data  = insuree.id_data) ";
$query .= " INNER JOIN tb_br_car ON (detail.br_car = tb_br_car.id) ";
$query .= " INNER JOIN tb_mo_car ON (detail.mo_car = tb_mo_car.id) ";
$query .= " INNER JOIN tb_customer ON (data.login  = tb_customer.user) ";
$query .= " INNER JOIN req ON (data.id_data  = req.id_data) ";
$query .= " INNER JOIN tb_tumbon ON (tb_tumbon.id = insuree.tumbon) ";
$query .= " INNER JOIN tb_amphur ON (tb_amphur.id = insuree.amphur) ";
$query .= " INNER JOIN tb_province ON (tb_province.id = insuree.province) ";
$query .= " WHERE req.EditCancel !='Y'  $sqlPmuser $search order by data.send_date DESC";
//echo $query;
$objQuery = mysql_query($query) or die ("Error Query tb_data [".$query."]");
$arrData = array();
$arrSumData = array();
$anc = 1;
while($row = mysql_fetch_array($objQuery)){

// start สลักหลังที่อยู่ผู้เอาประกัน    
$ShowReq = '';
$insureename ='';

    

if($row['EditCustomer'] == 'Y')
{
     $query1 = "SELECT ";
    $query1 .= "tb_tumbon.name as tumbon, "; 
    $query1 .= "tb_amphur.name as amphur, "; 
    $query1 .= "tb_province.name as province "; // จังหวัด
    $query1 .= "FROM req ";
    $query1 .= "INNER JOIN tb_tumbon ON (tb_tumbon.id = req.Cus_tumbon) ";
    $query1 .= "INNER JOIN tb_amphur ON (tb_amphur.id = req.Cus_amphur) ";
    $query1 .= "INNER JOIN tb_province ON (tb_province.id = req.Cus_province) ";
    $query1 .= "WHERE req.id_data='".$row['id_data']."'";
    $objQuery1 = mysql_query($query1) or die ("Error Query [".$query1."]");
    $row1 = mysql_fetch_array($objQuery1);

    $insureename .= $row['Cus_title']." ".$row['reqcusname']." ".$row['Cus_last'];
    $ShowReq .= "".$row['Cus_add']; 
    if($row['Cus_group'] !="-" && $row['Cus_group'] !=""){
        $ShowReq .= " หมู่".$row['Cus_group'];
    }
    if($row['Cus_town'] !="-" && $row['Cus_town'] !=""){
        $ShowReq .= " ".$row['Cus_town'];
    }
    if($row['Cus_lane'] !="-" && $row['Cus_lane'] !=""){
        $ShowReq .= " ซอย".$row['Cus_lane'];
    }
    if($row['Cus_road'] !="-"){
        $ShowReq .= " ถนน".$row['Cus_road'];
    }
    if($row1['Cus_province'] != "102"){
        $ShowReq .= "ต.".$row1['tumbon']." อ.".$row1['amphur']." จ.".$row1['province']." ".$row['Cus_postal']; 
    }else{
        $ShowReq .= "แขวง".$row1['tumbon']."  ".$row1['amphur']." ".$row1['province']." ".$row['Cus_postal'];
    }
    
}else{

        $insureename .= $row['title'].$row['cus_name'].' '.$row['last'];
        $ShowReq .= "".$row['add']; 
        if($row['group'] !="-" && $row['group'] !="")
        {
            $ShowReq .= " หมู่".$row['group'];
        }
        if($row['town'] !="-" && $row['town'] !="")
        {
            $ShowReq .= " ".$row['town'];
        }
        if($row['lane'] !="-" && $row['lane'] !="")
        {
            $ShowReq .= " ซอย".$row['lane'];
        }
        if($row['road'] !="-" && $row['road'] !="")
        {
            $ShowReq .= " ถนน".$row['road'];
        }
        if($row['province'] != "102"){
            $ShowReq .= 'ต.'.$row['tumbon_name'].' อ.'.$row['amphur_name'].' จ.'.$row['province_name'];
        }
        else{
            $ShowReq .= 'แขวง'.$row['tumbon_name'].'  '.$row['amphur_name'].' '.$row['province_name'];
        }
}

// start สลักหลังเลขตัวถัง  
if($row['EditCar'] == 'Y'){
    $car_body = "เลขตัวถัง : ".$row['Edit_CarBody'];
}else{
    $car_body = $row['car_body'];
}
// end สลักหลังเลขตัวถัง

// start สลักหลังเลขตัวถัง  
if($row['EditTime'] == 'Y'){
    $insdate = thaiDate($row['EditTime_StartDate']).' - '.thaiDate($row['EditTime_EndDate']) ;
}else{
    $insdate = thaiDate($row['start_date']).' - '.thaiDate($row['end_date']) ;
}
// end สลักหลังเลขตัวถัง
 if(!empty($row['mo_sub']))
      { 
      $mo_car_sub_sql="SELECT name FROM tb_mo_car_sub WHERE id = '".$row['mo_sub']."'";
      $mo_car_sub_query=mysql_query($mo_car_sub_sql);
      $mo_car_sub_array=mysql_fetch_array($mo_car_sub_query);
      if(!empty($mo_car_sub_array))
      {
        $carmodel=" (".$mo_car_sub_array['name'].")";
      }
}else{
     $carmodel = $row['moname'];
}
     
    $id_data =  $row['id_data'];
    $send_date = thaiDate($row['send_date']);
   
    

  $arrData[]= array(
    'coldata0'=>"{$id_data}",
    'coldata1'=>"{$send_date}",
    'coldata2'=>"{$insureename}",
    'coldata3'=>"{$carmodel}",
    'coldata4'=>"{$car_body}"
    // 'coldata5'=>"{$carmodel}",
    // 'coldata6'=>"{$car_body}"
  );

  if($useSum=='Y'){
    $colsumbegin='L';  // เริ่มจาก Colum ไหน
    $arrSumData[]= array(
    'sumdata0'=>" ",
    'sumdata1'=>" ",
    'sumdata2'=>" ",
    'sumdata3'=>" ",
    'sumdata4'=>" "
    );
  }



  $anc++;
}
// print_r($arrData);
// exit();
///////////////////////




// สร้าง object ของ Class  PHPExcel  ขึ้นมาใหม่ 
$objPHPExcel = new PHPExcel();
$num=0; 
$i=0;
$colH = $colbegin;
// $txt_header=$sheetname ;



$objPHPExcel->createSheet($i);
$objPHPExcel->setActiveSheetIndex($i);

$objPHPExcel->getProperties($i)->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties($i)->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties($i)->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
$objPHPExcel->getActiveSheet($i)->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet($i)->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet($i)->getPageSetup()->setFitToPage(true);

// HEAD Cell
$objPHPExcel->getActiveSheet($i)->setCellValue($colbegin.'1',$sheetnametitle); 
$objPHPExcel->getActiveSheet($i)->getStyle($colbegin.'1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex($i)->mergeCells($colbegin.'1:'.$colend.'1');
$objPHPExcel->getActiveSheet()->getStyle($colbegin.'1:'.$colend.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objPHPExcel->getActiveSheet($i)->getStyle($colAll)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet($i)->getStyle($colAll)->getFill()->getStartColor()->setRGB('FF9900');
$objPHPExcel->getActiveSheet($i)->getStyle($colAll)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$styleArray = array(
       'borders' => array(
             'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN ,
                    'color' => array('argb' => '000000'),
             ),
       ),
);

  
$objPHPExcel->getDefaultStyle()->getFont()->setName('Cordia New')->setSize(14);

 for($s = 0;$s<$countColum;$s++){
  $objPHPExcel->getActiveSheet($i)->SetCellValue($colH.$beginHeader, $arrHead[$s])->getColumnDimensionByColumn($s)->setWidth($arrHeadwidth[$s]);
  $objPHPExcel->getActiveSheet($i)->getStyle($colH.$beginHeader.':'.$colH.$beginHeader)->applyFromArray($styleArray);
  $objPHPExcel->getActiveSheet($i)->getStyle($colH.$beginHeader)->getFont()->setBold(true);
  $colH++;
}
 
$rowNumber=$beginrow;

foreach($arrData AS $rowdata){       
 //Excel 
 $col=$colbegin;    

// $objPHPExcel->setActiveSheetIndex($i);
for($d = 0;$d<$countColum;$d++){
  $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$rowdata['coldata'.$d]);

  $col++;
}

$rowNumber++;
}

if($useSum=='Y'){
// สรุป
$col='L';

$objPHPExcel->setActiveSheetIndex($i);

$objPHPExcel->getActiveSheet($i)->setCellValue($col.$rowNumber,'รวม');
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_DOUBLE)->setBold(true);
$col++;
$objPHPExcel->getActiveSheet($i)->setCellValue($col.$rowNumber,'รวม 11111');
$objPHPExcel->getActiveSheet()->getStyle($col.$rowNumber)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_DOUBLE)->setBold(true);
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->applyFromArray($styleArray);
$col++;
$objPHPExcel->getActiveSheet($i)->setCellValue($col.$rowNumber,'รวม 22222');
$objPHPExcel->getActiveSheet()->getStyle($col.$rowNumber)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_DOUBLE)->setBold(true);
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->applyFromArray($styleArray);
$col++;
$objPHPExcel->getActiveSheet($i)->setCellValue($col.$rowNumber,'รวม 33333');
$objPHPExcel->getActiveSheet()->getStyle($col.$rowNumber)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_DOUBLE)->setBold(true);
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->applyFromArray($styleArray);
$col++;
$objPHPExcel->getActiveSheet($i)->setCellValue($col.$rowNumber,'รวม 44444');
$objPHPExcel->getActiveSheet()->getStyle($col.$rowNumber)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_DOUBLE)->setBold(true);
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->applyFromArray($styleArray);
$col++;
$objPHPExcel->getActiveSheet($i)->setCellValue($col.$rowNumber,'รวม 55555');
$objPHPExcel->getActiveSheet()->getStyle($col.$rowNumber)->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_DOUBLE)->setBold(true);
$objPHPExcel->getActiveSheet($i)->getStyle($col.$rowNumber)->applyFromArray($styleArray);

$col++;
}

 $rowNumber++;




// ตั้งชื่อ Sheet

$objPHPExcel->getActiveSheet($i)->setTitle($sheetname);

// Loop Sheet
// $i++;


  
// บันทึกไฟล์ Excel 2007
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Report_insure_data.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>