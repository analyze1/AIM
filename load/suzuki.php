<?php
include "../pages/check-ses.php"; 
include "../../inc/connectdbs.pdo.php"; 
require_once "../inc/class.writeexcel_workbook.inc.php";
require_once "../inc/class.writeexcel_worksheet.inc.php";
$mSearch = $_POST['Msearch'];
$ySearch = $_POST['Ysearch'];
$query = "SELECT 
data.id,
data.login,
data.send_date,  
data.name_inform,
data.name_gain,
data.id_data,
data.doc_type,
data.start_date,
data.end_date,
data.updated,
data.send_req,
data.send_req2,
data.send_cancel,  



tb_customer.user ,
tb_customer.sub ,
tb_customer.title_sub ,
tb_customer.contact  ,
tb_customer.contact2  ,

insuree.title,
insuree.name,
insuree.last,

tb_mo_car.name as mo_name ,

detail.car_id,
detail.mo_car,
detail.car_body,
detail.cat_car,
tb_mo_car.name as name_mo_car,

protect.costCost, 

tb_cost.pre,
tb_cost.net,
tb_cost.cost,


req.Req_Status, 
req.Req_Date, 
req.EditTime, 
req.EditTime_StartDate, 
req.EditTime_EndDate, 
req.EditHr, 
req.EditHr_Detail, 
req.EditAct, 
req.EditAct_id, 
req.EditCar, 
req.Edit_CarBody, 
req.Edit_Nmotor, 
req.Edit_CarColor, 
req.EditCustomer, 
req.EditPerson, 
req.Cus_title, 
req.Cus_name, 
req.Cus_last, 
req.Cus_add, 
req.Cus_group, 
req.Cus_town, 
req.Cus_lane, 
req.Cus_road, 
req.Cus_tumbon, 
req.Cus_amphur, 
req.Cus_postal, 
req.EditCost, 
req.EditcostCost, 
req.EditProduct, 
req.Product as ReqProduct, 
req.TotalProduct, 
req.CostProduct 

FROM data
INNER JOIN detail ON (data.id_data = detail.id_data)
INNER JOIN tb_customer ON (data.login  = tb_customer.user)
INNER JOIN insuree ON (data.id_data  = insuree.id_data)
INNER JOIN protect ON (data.id_data = protect.id_data)
INNER JOIN tb_mo_car ON (tb_mo_car.id = detail.mo_car )
INNER JOIN tb_cost ON (tb_cost.id = protect.costCost )
INNER JOIN req ON (data.id_data = req.id_data) ";

$query .= " WHERE data.login = '".$_SESSION["strUser"]."' and Month(data.send_date) = '$mSearch' and Year(data.send_date) = '$ySearch' ";  // data.login = $xuser

$query .= " ORDER BY data.send_date DESC ";
$objQuery = mysql_query($query) or die ("Error Query [".$query."]");
$sqlMORE = "SELECT * FROM tb_acc";
$objQueryMORE = mysql_query($sqlMORE) or die ("Error Query [".$sqlMORE."]");
$costOb = array();
while($rowCost = mysql_fetch_array($objQueryMORE)){
	$costOb['name'][$rowCost['id']] = iconv('UTF-8','TIS-620',$rowCost['name']);
	$costOb['price'][$rowCost['id']] = $rowCost['price'];
	$costOb['price2'][$rowCost['id']] = $rowCost['price2'];
}
$sqlMOREname = "SELECT * FROM tb_acc_new";
$objQueryMOREname = mysql_query($sqlMOREname) or die ("Error Query [".$sqlMOREname."]");
$costObname = array();
while($rowCostname = mysql_fetch_array($objQueryMOREname)){
	$costObname['name']['0'.$rowCostname['idcar']][$rowCostname['id']] = iconv('UTF-8','TIS-620',$rowCostname['name']);
}
$ia=1;
$token = md5(uniqid(rand(), true)); 

$fname= "$token.xls";

$workbook = &new writeexcel_workbook($fname);
$worksheet = &$workbook->addworksheet();

$worksheet->set_column(0, 13, 15);
$worksheet->freeze_panes(1, 0);
$header =& $workbook->addformat();
$header->set_color('white');
$header->set_align('center');
$header->set_align('vcenter');
$header->set_pattern();
$header->set_fg_color('green');

$f_price =& $workbook->addformat();
$f_price->set_align('left');
$f_price->set_num_format('0.00');

$worksheet->write(0, 0,  "�ѹ�����", $header);
$worksheet->write(0, 1,  "�Ţ����Ѻ��", $header);
$worksheet->write(0, 2,  "�ѹ��������ͧ", $header);
$worksheet->write(0, 3,  "���ͼ����һ�Сѹ", $header);
$worksheet->write(0, 4,  "���ö", $header);
$worksheet->write(0, 5,  "�Ţ��Ƕѧ", $header);
$worksheet->write(0, 6,  "�ع��Сѹ", $header);
$worksheet->write(0, 7,  "�����ط��", $header);
$worksheet->write(0, 8,  "�������", $header);
$worksheet->write(0, 9,  "��¡�������ع", $header);
$worksheet->write(0, 10,  "�����ع", $header);
$worksheet->write(0, 11,  "��������", $header);
$worksheet->write(0, 12,  "���������", $header);
$worksheet->write(0, 13,  "��ѡ��ѡ", $header);

while($row = mysql_fetch_array($objQuery)) {

if($row['equit']=='Y' && $row['car_detail']=='0'){
							$i=0;
							$product = "product";
								while ($i<=14){
									if($i==0){
										if($row[$product]!='0'){
											$productEXTERNAL .= $row[$product]." ";
										}
									}else{
										if($row[$product.$i]!='0'){
											$productEXTERNAL .= $row[$product.$i]." ";
										}
									}
									$i++;
								}
								$priceTotal = number_format($row['price_total']);
								$priceAdd = number_format($row['add_price'],2);
						}
else if($row['equit']=='Y' && $row['car_detail']!='0'){
							$i=0;
							$exitNum = explode("|",$row['car_detail']);
							for($i=0;$i<count($exitNum);$i++){
								$exitSplit = explode(",",$exitNum[$i]);
								$productEXTERNAL .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' ';
								$productEXTERNAL .= number_format($costOb['name'][$exitSplit[1]],0).' �ҷ ';
							}
							$priceTotal = number_format($row['price_total']);
							$priceAdd = number_format($row['add_price'],2);
						}
else if($row['EditProduct'] =='Y'){
						$i=0;
							$exitNum = explode("|",$row['ReqProduct']);
							for($i=0;$i<count($exitNum);$i++){
								$exitSplit = explode(",",$exitNum[$i]);
								$productEXTERNAL .= $costObname['name'][$row['cat_car']][$exitSplit[0]].' ';
								$productEXTERNAL .= number_format($costOb['name'][$exitSplit[1]],0).' �ҷ ';
							}
							$priceTotal = number_format($row['TotalProduct']);
							$priceAdd = number_format($row['CostProduct'],2);
						}
else if($row['equit']=='N'){
						  		$productEXTERNAL = "�����";
						}

$ShowReqOld = '';
						if($row['send_req'] != ''){
							$ShowReqOld .= $row['send_req'];
						}
						if($row['send_req2'] != ''){
							$ShowReqOld .= $row['send_req2'];
						}
						
						$ShowReq = '';
						if($row['EditTime'] == 'Y'){
							$ShowReq .= "�ѹ��������ͧ : ".date('d/m/Y',strtotime($row['EditTime_StartDate'])).'<br>';
						}
						if($row['EditHr'] == 'Y'){
							$ShowReq .= "����Ѻ�Ż���ª�� : ".$row['EditHr_Detail'].'<br>';
						}
						if($row['EditAct'] == 'Y'){
							$ShowReq .= "�Ţ��� �ú. : ".$row['EditAct_id'].'<br>';
						}
						if($row['EditCar'] == 'Y'){
							$ShowReq .= "�Ţ��Ƕѧ : ".$row['Edit_CarBody']." / "."�Ţ����ͧ : ".$row['Edit_Nmotor']." / "."��ö : ".$row['Edit_CarColor'].'<br>';
						}
						if($row['EditCustomer'] == 'Y'){
							if($row['EditPerson']==1)
							{
								$EDITPERSON = "�ؤ�Ÿ�����";
							}
							else if($row['EditPerson']==2){
								$EDITPERSON = "�ԵԺؤ��";
							}
							$ShowReq .= $EDITPERSON;
							$ShowReq .= " ���ͼ����һ�Сѹ��� : ".$row['Cus_title']." ".$row['Cus_name']." ".$row['Cus_last'].'<br>';
							$ShowReq .= "������� : " .$row['Cus_add']; 
							if($row['Cus_group'] !="-" && $row['Cus_group'] !=""){
								$ShowReq .= " ����".$row['Cus_group'];
							}
							if($row['Cus_town'] !="-" && $row['Cus_town'] !=""){
								$ShowReq .= " ".$row['Cus_town'];
							}
							if($row['Cus_lane'] !="-" && $row['Cus_lane'] !=""){
								$ShowReq .= " ���".$row['Cus_lane'];
							}
							if($row['Cus_road'] !="-" && $row['Cus_road'] !=""){
								$ShowReq .= " ���".$row['Cus_road'];
							}
							if($row['Cus_province'] != "102"){
								$ShowReq .= " �.".$row1['tumbon']." �.".$row1['amphur']." �.".$row1['province']." ".$row1['Cus_postal']; 
							}else{
								$ShowReq .= " �ǧ".$row1['tumbon']." ࢵ.".$row1['amphur']." ".$row1['province']." ".$row1['Cus_postal'];
							}
							
						}
						if($row['EditCost'] == 'Y'){
							$ShowReq .= "����¹������� : ".$row['EditcostCost'];
						}
if($row['updated'] && $ShowReqOld != ''){
	$PrintReq = $ShowReqOld." �ѹ����� [".date('d/m/Y', strtotime($row['updated']))."]";
}
else if($row['Req_Status'] == 'Y' && $ShowReq != ''){
$PrintReq = $ShowReq." �ѹ����� [".date('d/m/Y', strtotime($row['updated']))."]";
}
$c=0;
$worksheet->write($ia, $c,  $row['send_date']);
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['id_data']));
$c++;
$worksheet->write($ia, $c,  $row['start_date']);
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['title']." ".$row['name']." ".$row['last']));
$c++;
$worksheet->write($ia, $c,  $row['name_mo_car']);
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['car_body']));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['cost']));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['pre']));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$row['net']));
$c++;
$worksheet->write($ia, $c,  $productEXTERNAL);
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$priceTotal));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$priceAdd));
$c++;
$worksheet->write($ia, $c,  '=I'.($i+1).'+L'.($i+1));
$c++;
$worksheet->write($ia, $c,  iconv('UTF-8','TIS-620',$PrintReq));
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