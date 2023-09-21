<?php
include ("../ClassesExcel/PHPExcel-1.8.1/Classes/PHPExcel.php"); 
include "../inc/connectdbs.pdo.php"; 
$_context = PDO_CONNECTION::fourinsure_mitsu();
$_context_four = PDO_CONNECTION::fourinsure_insured();

function thaiDate($datetime)
{
	if(empty($datetime))
	{
		$datetime='0000-00-00';
	}

$exd = explode('-',$datetime);
    $Y = $exd['0'];
    $m = $exd['1'];
    $d = $exd['2'];
    

    return $d . "/" . $m . "/" . $Y;
}
function thaiDate2($datetime)
{

$exdtime = explode(' ',$datetime);
$exd = explode('-',$exdtime[0]);
    $Y = $exd['0'];
    $m = $exd['1'];
    $d = $exd['2'];
    

    return $d . "/" . $m . "/" . $Y." ".$exdtime[1];
}
// สร้าง object ของ Class  PHPExcel  ขึ้นมาใหม่ 
$objPHPExcel = new PHPExcel();

// กำหนดค่าต่างๆ

// $objPHPExcel->createSheet(0);
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

$objPHPExcel->getActiveSheet()->setTitle('Report claim');

$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //ORIENTATION_PORTRAIT
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);


$objPHPExcel->getDefaultStyle()->getFont()->setName('Cordia New')->setSize(14);

$array_ceil=0;
$ceil_eng='A';
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'No.')->getColumnDimensionByColumn($array_ceil)->setWidth(10);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'วันที่บันทึก')->getColumnDimensionByColumn($array_ceil)->setWidth(20);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'เลขรับแจ้ง')->getColumnDimensionByColumn($array_ceil)->setWidth(17);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'ประเภท')->getColumnDimensionByColumn($array_ceil)->setWidth(10);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'วันที่เกิดเหตุ')->getColumnDimensionByColumn($array_ceil)->setWidth(20);
$array_ceil++;
$ceil_eng++;
/*$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'วันรับแจ้งเหตุ')->getColumnDimensionByColumn($array_ceil)->setWidth(15);
$array_ceil++;
$ceil_eng++;*/
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'เลขที่เคลม')->getColumnDimensionByColumn($array_ceil)->setWidth(20);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'ผู้เอาประกัน')->getColumnDimensionByColumn($array_ceil)->setWidth(50);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'ทะเบียนรถ')->getColumnDimensionByColumn($array_ceil)->setWidth(20);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'รุ่นรถ')->getColumnDimensionByColumn($array_ceil)->setWidth(30);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'เลขตัวถัง')->getColumnDimensionByColumn($array_ceil)->setWidth(20);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'เบอร์ติดต่อ')->getColumnDimensionByColumn($array_ceil)->setWidth(15);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'ผู้แจ้งเหตุ')->getColumnDimensionByColumn($array_ceil)->setWidth(15);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'ราคาประเมิน')->getColumnDimensionByColumn($array_ceil)->setWidth(15);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'รายการความเสียหาย')->getColumnDimensionByColumn($array_ceil)->setWidth(50);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'วันที่นัดหมายซ่อม')->getColumnDimensionByColumn($array_ceil)->setWidth(15);
$array_ceil++;
$ceil_eng++;
$objPHPExcel->getActiveSheet()->SetCellValue($ceil_eng.'1', 'รายละเอียด')->getColumnDimensionByColumn($array_ceil)->setWidth(50);
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$ceil_eng.'1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$ceil_eng.'1')->getFill()->getStartColor()->setRGB('FF9900');
$objPHPExcel->getActiveSheet()->getStyle('A1:'.$ceil_eng.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


if($_POST['dealer']=='ALL')
{
	$sql_dealer='';
}
else
{
	$sql_dealer=" AND data.login = '".$_POST['dealer']."' ";
}
$claim_sql="SELECT 

data.id_data
,detail.car_body
,detail.insure_year
,detail.car_regis
,insuree.title
,insuree.name
,insuree.last
,insuree.tel_mobi
,detail.mo_car
,detail.mo_sub
,detail.car_regis
,tb_claimfollow.claim_no
,tb_claimfollow.informer
,tb_claimfollow.date_repair
,tb_claimfollow.cost_estimate
,tb_claimfollow.detailtext
,tb_claimfollow.damage
,tb_claimfollow.timecall
,tb_claimfollow.id_claim
FROM tb_claimfollow 
INNER JOIN data ON (tb_claimfollow.id_data = data.id_data) 

INNER JOIN detail ON (tb_claimfollow.id_data = detail.id_data) 
INNER JOIN insuree ON (tb_claimfollow.id_data = insuree.id_data) 
WHERE DATE(tb_claimfollow.timecall) >= '".$_POST['start_date']."' AND DATE(tb_claimfollow.timecall) <= '".$_POST['end_date']."' ".$sql_dealer." 

 ORDER BY tb_claimfollow.id_data ASC,tb_claimfollow.timecall ASC";

$claim_query= $_context->query($claim_sql)->fetchAll(2);
// print_r($claim_query);exit(); 
$No=0;
$rowNumber=2;
foreach($claim_query as $claim_array)
{
$tb_claim_sql="SELECT 
tb_claim.id_data
,tb_claim.n_insure
,tb_claim.claim_date
,tb_claim.claim_amount
,tb_claim.claim_status
,tb_claim.dateentry
,tb_claim.dateupdate
,tb_claim.claim_no
,tb_claim.claim_location
,tb_claim.claim_des
,tb_claim.estimate
,tb_claim.emp_save
,tb_claim.claim_use 
,tb_claim.claim_location
FROM tb_claim WHERE tb_claim.id = '".$claim_array['id_claim']."' ORDER BY tb_claim.id DESC";

$tb_claim_array=$_context->query($tb_claim_sql)->fetch(2);

$mo_car_sql="SELECT * FROM tb_mo_car WHERE id = '".$claim_array['mo_car']."' ";
$mo_car_array=$_context_four->query($mo_car_sql)->fetch(2);

$mo_car_sub_sql="SELECT * FROM tb_mo_car_sub WHERE id = '".$claim_array['mo_sub']."' ";
$mo_car_sub_array=$_context_four->query($mo_car_sub_sql)->fetch(2);
// print_r($mo_car_array['name'].$mo_car_sub_name);exit;
	if(!empty($mo_car_sub_array['name']))
	{
		$mo_car_sub_name=" (".$mo_car_sub_array['name'].")";
	}
	else
	{
		$mo_car_sub_name="";
	}
	  $No++;   
	$col='A';
//No.
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$No);
	$col++;
	//วันที่บันทึก
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,thaiDate2($claim_array['timecall']));
	$col++;
	//เลขรับแจ้ง
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$claim_array['id_data']);
	$col++;
	//ประเภทกรมธรรม์
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$claim_array['insure_year']);
	$col++;
	//วันที่เกิดเหตุ
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,thaiDate($tb_claim_array['claim_date']));
	$col++;
	//วันที่แจ้งเคลม
	/*$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$tb_claim_array['claim_date']);
	$col++;*/
	//เลขที่เคลม
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$claim_array['claim_no']);
	$col++;
	//ผู้เอาประกันภัย
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$claim_array['title'].$claim_array['name']." ".$claim_array['last']);
	$col++;
	//ทะเบียนรถ
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$claim_array['car_regis']);
	$col++;
	//รุ่นรถ
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$mo_car_array['name'].$mo_car_sub_name);
	$col++;
	//เลขตัวถัง
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$claim_array['car_body']);
	$col++;
	//เบอร์ติดต่อ
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$claim_array['tel_mobi']);
	$col++;
	//ผู้แจ้งเหตุ
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$claim_array['informer']);
	$col++;
	//ราคาประเมิน
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$claim_array['cost_estimate']);
	$col++;
	//รายการความเสียหาย
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$claim_array['damage']);
	$col++;
	//วันที่นัดหมายซ่อม
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,thaiDate($claim_array['date_repair']));
	$col++;
	//รายละเอียด
	$objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber,$claim_array['detailtext']);
		$col++;
		$rowNumber++;

}
// ตั้งชื่อ Sheet
$objPHPExcel->getActiveSheet()->setTitle('Report_Claim');

// Footer
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&R Report Suzuki/ผู้บริหาร/รายงานยอดขาย วันที่พิมพ์ &D &T  Page &P / &N  ผู้พิมพ์ : '.$_SESSION["4NameSMS"]);
		
// บันทึกไฟล์ Excel 2007
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Report_Claim.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

?>