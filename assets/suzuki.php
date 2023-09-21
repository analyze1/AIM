<?php
include "../../inc/connectdbs.pdo.php"; 
require_once "../inc/class.writeexcel_workbook.inc.php";
require_once "../inc/class.writeexcel_worksheet.inc.php";
$mSearch = $_GET['M'];
$ySearch = $_GET['Y'];

$query = "SELECT 
insuree.*,
data.end_date,
data.name_gain,
detail.mo_car,
detail.regis_date,
detail.car_body,
data.name_gain,
protect.costCost

FROM data
INNER JOIN detail ON (data.id_data = detail.id_data)
INNER JOIN insuree ON (data.id_data  = insuree.id_data)
INNER JOIN protect ON (data.id_data = protect.id_data)";


$query .= " WHERE Month(data.end_date) = '$mSearch' and Year(data.end_date) = '$ySearch' AND tel_mobi != '' AND tel_mobi != '0' AND tel_mobi != '9999999999' AND tel_mobi != '1234567890' AND tel_mobi != '0123456789' ";
if($_GET['T']=='Y'){
$query .= " AND province IN (102,117,122,126,152,154) ";
}
$query .= " ORDER BY data.end_date ASC ";

$objQuery = mysql_query($query) or die ("Error Query [".$query."]");

$sqlMORE = "SELECT * FROM tb_tumbon";
$objQueryMORE = mysql_query($sqlMORE) or die ("Error Query [".$sqlMORE."]");
$costOb = array();
while($rowCost = mysql_fetch_array($objQueryMORE)){
	$costOb['tumbon'][$rowCost['id']] = $rowCost['name'];
}

$sqlMORE = "SELECT * FROM tb_cost";
$objQueryMORE = mysql_query($sqlMORE) or die ("Error Query [".$sqlMORE."]");
while($rowCost = mysql_fetch_array($objQueryMORE)){
	$costOb['cost'][$rowCost['id']] =  substr($rowCost['cost'],0,8);
	$costOb['net'][$rowCost['id']] =  $rowCost['net'];
}

$sqlMORE = "SELECT * FROM  tb_amphur";
$objQueryMORE = mysql_query($sqlMORE) or die ("Error Query [".$sqlMORE."]");

while($rowCost = mysql_fetch_array($objQueryMORE)){
	$costOb['amphur'][$rowCost['id']] = $rowCost['name'];
}
$sqlMORE = "SELECT * FROM   tb_province";
$objQueryMORE = mysql_query($sqlMORE) or die ("Error Query [".$sqlMORE."]");

while($rowCost = mysql_fetch_array($objQueryMORE)){
	$costOb['province'][$rowCost['id']] = $rowCost['name'];
}

$sqlMORE = "SELECT * FROM   tb_mo_car";
$objQueryMORE = mysql_query($sqlMORE) or die ("Error Query [".$sqlMORE."]");

while($rowCost = mysql_fetch_array($objQueryMORE)){
	$costOb['tb_mo_car'][$rowCost['id']] = $rowCost['name'];
}

$ia=1;
$token = md5(uniqid(rand(), true)); 

$fname= "img/$token.xls";

$workbook = &new writeexcel_workbook($fname);

$worksheet = &$workbook->addworksheet();

$worksheet->set_column(0, 13, 15);
$worksheet->freeze_panes(1, 0);



$c=0;
$worksheet->write(0, $c,  "EXPDATE");
$c++;
$worksheet->write(0, $c,  "TITLE");
$c++;
$worksheet->write(0, $c,  "NAME");
$c++;
$worksheet->write(0, $c,  "LASTNAME");
$c++;
$worksheet->write(0, $c,  "MODEL");
$c++;
$worksheet->write(0, $c,  "BODY");
$c++;
$worksheet->write(0, $c,  "TEL");
$c++;
$worksheet->write(0, $c,  "ADDRESS");
$c++;
$worksheet->write(0, $c,  "ADDRESS");
$c++;
$worksheet->write(0, $c,  "ADDRESS");
$c++;
$worksheet->write(0, $c,  "ADDRESS");
$c++;
$worksheet->write(0, $c,  "ADDRESS");
$c++;
$worksheet->write(0, $c,  "ADDRESS");
$c++;
$worksheet->write(0, $c,  "ADDRESS");
$c++;
$worksheet->write(0, $c,  "ADDRESS");
$c++;
$worksheet->write(0, $c,  "YEAR");
$c++;
$worksheet->write(0, $c,  "COST");
$c++;
$worksheet->write(0, $c,  "NET");
$c++;
$worksheet->write(0, $c,  "FINANCE");
$c++;

while($row = mysql_fetch_array($objQuery)) {
$c=0;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['end_date']));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['title']));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['name']));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['last']));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$costOb['tb_mo_car'][$row['mo_car']]));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['car_body']));
$c++;
$worksheet->write_string($ia, $c,  $row['tel_mobi'],$tel);
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['add']));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['group']));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['lane']));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['road']));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$costOb['tumbon'][$row['tumbon']]));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$costOb['amphur'][$row['amphur']]));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$costOb['province'][$row['province']]));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['postal']));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['regis_date']));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$costOb['cost'][$row['costCost']]));
$c++;
$worksheet->write($ia, $c,  $costOb['net'][$row['costCost']]);
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['name_gain']));
$c++;

$productEXTERNAL='';
$priceTotal='';
$priceAdd='';
$PrintReq='';
$ia++;
}

$workbook->close();
header("content-type: text/html; charset=utf-8");
header("Content-Type: application/x-msexcel; name=\"$mSearch-$ySearch.xls\"");
header("Content-Disposition: inline; filename=\"$mSearch-$ySearch.xls\"");
$fh=fopen($fname, "r+");
fpassthru($fh);
unlink($fname);
?>