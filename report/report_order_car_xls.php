<?php
	include "../pages/check-ses.php"; 
	include "../inc/connectdbs.inc.php";
	include ("../ClassesExcel/PHPExcel.php"); 
	mysql_select_db($db1,$cndb1);
	if($_SESSION['claim']=='ADMIN' || $_SESSION["strUser"]=='admin' || $_POST['login'] =='ALL')
{
	$sql=" WHERE DATE(date_save) >= '".$_POST['start_date']."' AND DATE(date_save) <= '".$_POST['end_date']."'";
}
else
{
	$sql=" WHERE DATE(date_save) >= '".$_POST['start_date']."' AND DATE(date_save) <= '".$_POST['end_date']."' AND tb_order_car.login = '".$_SESSION["strUser"]."'";

}
	$q_auto=$_GET['q_auto'];
	$select_order_sql="SELECT
	tb_order_car.q_auto,
	tb_order_car.date_save,
	tb_customer.sub,
	tb_customer.title_sub,
	tb_customer.emp_faxrenew,
	tb_customer.emp_telrenew,
	tb_customer.location
	FROM tb_order_car
	LEFT JOIN tb_customer ON (tb_order_car.login = tb_customer.user) 
	".$sql." ORDER BY tb_order_car.q_auto ASC";
	$select_order_query=mysql_query($select_order_sql,$cndb1);
//echo $select_order_sql;
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE); //ORIENTATION_PORTRAIT
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
$objPHPExcel->getDefaultStyle()->getFont()->setName('Cordia New')->setSize(14);
$row=1;
$row_array=0;
$n=1;
$cell='A';
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':S'.$row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':S'.$row)->getFill()->getStartColor()->setRGB('99e6ff');
$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':S'.$row)->getFont()->getColor()->setRGB('000000');
$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':S'.$row)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue('A'.$row, 'ลำดับที่')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'เลขที่ใบสั่งซื้อ')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'ยี่ห้อรถ')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'รุ่นรถ')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'รุ่นรถย่อย')->getColumnDimensionByColumn($row_array)->setWidth(30);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'สีรถยนต์')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'ปีรถยนต์')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'ราคารถต่อคัน')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'ต้นทุนรถต่อคัน')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'ค่าBSC 1.4% ต่อคัน')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'ค่าBSC 1.6% ต่อคัน')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'ค่าBSC 2% ต่อคัน')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'จำนวนสั่งซื้อ')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'ราคารวมรถยนต์')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'รวมต้นทุนรถยนต์')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'รวม BSC 1.4%')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'รวม BSC 1.6%')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'รวม BSC 2%')->getColumnDimensionByColumn($row_array)->setWidth(15);
$row_array++;
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, 'เงื่อนไขสั่งซื้อ')->getColumnDimensionByColumn($row_array)->setWidth(30);
	$row++;
	$n=1;
	$sum_car_price=0;
	$sum_car_cost=0;
	$sum_car_bsc14=0;
	$sum_car_bsc16=0;
	$sum_car_bsc2=0;
	$sum_unit=0;
	while($select_order_array=mysql_fetch_array($select_order_query))
	{
	$select_detail_sql="SELECT
	tb_br_car.name As b_name,
	tb_mo_car.name As m_name,
	tb_mo_car_sub.name As s_name,
	tb_order_detail_car.unit_car,
	tb_order_detail_car.car_price,
	tb_order_detail_car.car_regis_year,
	tb_order_detail_car.car_cost,
	tb_order_detail_car.car_bsc,
	tb_order_detail_car.unit_car,
	tb_order_detail_car.condition_car,
	tb_order_detail_car.q_auto,
	tb_color.color_name
	FROM tb_order_detail_car
	LEFT JOIN tb_br_car ON (tb_order_detail_car.id_br_car = tb_br_car.id)
	LEFT JOIN tb_mo_car ON (tb_order_detail_car.id_mo_car = tb_mo_car.id)
	LEFT JOIN tb_mo_car_sub ON (tb_order_detail_car.id_mo_car_sub = tb_mo_car_sub.id)
	LEFT JOIN tb_color ON (tb_order_detail_car.id_car_color = tb_color.id_color)
	WHERE tb_order_detail_car.q_auto = '".$select_order_array['q_auto']."'";
	$select_detail_query=mysql_query($select_detail_sql,$cndb1);
while($select_detail_array=mysql_fetch_array($select_detail_query))
{
$cell='A';
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row,$n);
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, $select_detail_array['q_auto']);
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, $select_detail_array['b_name']);
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, $select_detail_array['m_name']);
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, $select_detail_array['s_name']);
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, $select_detail_array['color_name']);
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, $select_detail_array['car_regis_year']);
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, number_format($select_detail_array['car_price'],2,'.',','));
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, number_format($select_detail_array['car_cost'],2,'.',','));
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, number_format((((($select_detail_array['car_price'] * 100) / 107) * 1.4) / 100),2,'.',','));
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, number_format((((($select_detail_array['car_price'] * 100) / 107) * 1.6) / 100),2,'.',','));
$cell++;
$cell_fix=$cell;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, number_format((((($select_detail_array['car_price'] * 100) / 107) * 2) / 100),2,'.',','));
$sum_unit+=$select_detail_array['unit_car'];
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, $select_detail_array['unit_car']);
$sum_car_price+=$select_detail_array['car_price'] * $select_detail_array['unit_car'];
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, number_format(($select_detail_array['car_price'] * $select_detail_array['unit_car']),2,'.',','));
$sum_car_cost+=$select_detail_array['car_cost'] * $select_detail_array['unit_car'];
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, number_format(($select_detail_array['car_cost'] * $select_detail_array['unit_car']),2,'.',','));
$sum_car_bsc14+=((((($select_detail_array['car_price'] * 100) / 107) * 1.4) / 100) * $select_detail_array['unit_car']);
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, number_format(((((($select_detail_array['car_price'] * 100) / 107) * 1.4) / 100) * $select_detail_array['unit_car']),2,'.',','));
$sum_car_bsc16+=((((($select_detail_array['car_price'] * 100) / 107) * 1.6) / 100) * $select_detail_array['unit_car']);
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, number_format(((((($select_detail_array['car_price'] * 100) / 107) * 1.6) / 100) * $select_detail_array['unit_car']),2,'.',','));
$sum_car_bsc2+=((((($select_detail_array['car_price'] * 100) / 107) * 2) / 100) * $select_detail_array['unit_car']);
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, number_format(((((($select_detail_array['car_price'] * 100) / 107) * 2) / 100) * $select_detail_array['unit_car']),2,'.',','));
$cell++;
$objPHPExcel->getActiveSheet()->SetCellValue($cell.$row, $select_detail_array['condition_car']);
$row++;
$n++;
}
}
$objPHPExcel->getActiveSheet()->getStyle('L'.$row.':R'.$row)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('L'.$row.':R'.$row)->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('L'.$row, 'รวม');
$cell_fix++;
$objPHPExcel->getActiveSheet()->SetCellValue('M'.$row, $sum_unit);
$cell_fix++;
$objPHPExcel->getActiveSheet()->SetCellValue('N'.$row, number_format($sum_car_price,2,'.',','));
$cell_fix++;
$objPHPExcel->getActiveSheet()->SetCellValue('O'.$row, number_format($sum_car_cost,2,'.',','));
$cell_fix++;
$objPHPExcel->getActiveSheet()->SetCellValue('P'.$row, number_format($sum_car_bsc14,2,'.',','));
$cell_fix++;
$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$row, number_format($sum_car_bsc16,2,'.',','));
$cell_fix++;
$objPHPExcel->getActiveSheet()->SetCellValue('R'.$row, number_format($sum_car_bsc2,2,'.',','));

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$objPHPExcel->getActiveSheet()->setTitle('รายงานยอดสั่งซื้อ '.$_POST['login']);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('รายการสั่งซื้อ '.str_replace('/','-',$q_auto).' ผู้ดาวโหลด'.$_SESSION['strUser']);
// บันทึกไฟล์ Excel 2007
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="รายงานยอดสั่งซื้อ '.$_POST['login'].'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');