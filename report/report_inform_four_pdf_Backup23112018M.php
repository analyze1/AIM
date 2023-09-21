<?php
include "../pages/check-ses.php";
include "../inc/connectdbs.inc.php"; 
include "../inc/function.php"; 
require('../print/rotation.php');
define('FPDF_FONTPATH','font/');
mysql_select_db($db2,$cndb2);

	class PDF extends PDF_Rotate
{
function RotatedText($x,$y,$txt,$angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}

function RotatedImage($file,$x,$y,$w,$h,$angle)
{
    //Image rotated around its upper-left corner
    $this->Rotate($angle,$x,$y);
    $this->Image($file,$x,$y,$w,$h);
    $this->Rotate(0);
}
}
if($_POST['idagent'] != 'ALL')
{
		$sql=" AND data.idagent = '".$_POST['idagent']."' ";

}
else
{
		$sql=" ";
}
$select_data_sql="SELECT
data.id_data
,DATE(data.send_date) As send_date
,data.start_date
,data.end_date
,data.com_data
,detail.car_regis
,insuree.title
,insuree.name
,insuree.last
,premium.total_pre
,premium.total_sum
,premium.prb
,premium.commition
,premium.total_commition
,premium.other
FROM data
LEFT JOIN detail ON (data.id_data = detail.id_data)
LEFT JOIN insuree ON (data.id_data = insuree.id_data)
LEFT JOIN premium ON (data.id_data = premium.id_data)
WHERE DATE(data.send_date) >= '".$_POST['start_date']."' AND DATE(data.send_date) <= '".$_POST['end_date']."' 
AND detail.status_policy_time = '0000-00-00 00:00:00'
".$sql."
ORDER BY data.send_date ASC ";
//echo $select_data_sql;
$select_data_query=mysql_query($select_data_sql,$cndb2);
$select_data_num=mysql_num_rows($select_data_query);
	//$pdf->RotatedText(110,60,iconv( 'UTF-8','TIS-620',$premium_name),0);
	//$pdf->Image('../images/logo.gif',10,3,80);
	//$pdf->Image('../i/dealer.png',10,27,20);
	$pdf=new PDF('L','mm','A4');
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');
	$pdf->SetAutoPageBreak(true);
	//ตั้งค่า
	//ตั้งค่า ตะแหน่ง x , y
	$setY=array(40,10,3,200);
	$setX=array(3.5,285);
	//ตั้งค่า ความยาว และ สูงของ cell
	$ar_width_cell=array(8,17,17,23,30,88,15,16,16,13,15,16,16);
	$ar_height_cell=array(7,7,7,7,7,7,7,7,7,7,7,7,7);
	
	//ตั้งค่า border
	$border=1;
	//font size
	$ar_font_size=array(14,12,11);
	$ar_font_type=array('','B');
	$pg=0;
	$ch=0;
	$n=0;
	$total_pre_sum=0;
	$total_sum_sum=0;
	$prb_sum=0;
	$commition_sum=0;
	$total_commition_sum=0;
	mysql_select_db($db3,$cndb3);
	while($select_data_array=mysql_fetch_array($select_data_query))
	{
		$ch++;
			$select_invoice_sql = "SELECT 
	invoice_detail.grand
	,invoice_detail.id 
	,invoice_detail.pre
	,invoice_detail.prb
	,invoice_detail.sta_pre
	,invoice_detail.sta_prb
	FROM invoice_detail
	LEFT JOIN certificate ON (invoice_detail.inv_no = certificate.inv_no)
	WHERE invoice_detail.id_data = '".$select_data_array['id_data']."' ";
	$select_invoice_query = mysql_query($select_invoice_sql,$cndb3);
	$select_invoice_array = mysql_fetch_array($select_invoice_query);
		
	if($ch==1)
	{
		$pdf->AddPage();
		$pdf->SetFont('angsa',$ar_font_type[0],$ar_font_size[0]);
		$pg++;
	$pdf->SetY($setY[2]);
	$pdf->SetX($setX[1]);
	$pdf->Cell(7,7,iconv( 'UTF-8','TIS-620',$pg),0,1,"R");	
	$pdf->SetY($setY[1]);
	$pdf->SetX($setX[0]);
	if($_SESSION["strUser"]!='admin')
	{
		$company_name=$_SESSION["strName"];
	}
	else
	{
		$company_name='บริษัท โฟร์ อินชัวรันส์ โบรกเกอร์ จำกัด';
	}
	$pdf->Cell(0,7,iconv( 'UTF-8','TIS-620',$company_name),0,1,"L");
	$pdf->SetX($setX[0]);
	$pdf->Cell(0,7,iconv( 'UTF-8','TIS-620','ใบแจ้งค่าเบี้ยประกันภัยครบกำหนดชำระ'),0,1,"L");
	$pdf->SetX($setX[0]);
	$pdf->Cell(0,7,iconv( 'UTF-8','TIS-620','ระหว่างวันที่ '.$_POST['start_date'].' ถึง '.$_POST['end_date']),0,1,"L");
	$pdf->SetFillColor(228,228,228);
	$pdf->SetFont('angsa',$ar_font_type[0],$ar_font_size[0]);
	$x=0;
	$pdf->SetY($setY[0]);
	$pdf->SetX($setX[0]);
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','ลำดับ'),$border,0,"C","T");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','วันที่แจ้ง'),$border,0,"C","T");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','วันคุ้มครอง'),$border,0,"C","T");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','บริษัทประกันภัย'),$border,0,"C","T");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','เลขที่รับแจ้ง'),$border,0,"C","T");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','ชื่อผู้เอาประกัน'),$border,0,"C","T");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','ทะเบียน'),$border,0,"C","T");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','เบี้ยสุทธิ์'),$border,0,"C","T");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','เบี้ยรวม'),$border,0,"C","T");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','พ.ร.บ.'),$border,0,"C","T");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','ส่วนลด'),$border,0,"C","T");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','ยอดชำระ'),$border,0,"C","T");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','สถานะ'),$border,1,"C","T");
	$pdf->SetFont('angsa',$ar_font_type[0],$ar_font_size[0]);
	}
		
	$x=0;
	$n++;
	$pdf->SetX($setX[0]);
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$n),$border,0,"C");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$select_data_array['send_date']),$border,0,"C");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$select_data_array['start_date']),$border,0,"C");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$select_data_array['com_data']),$border,0,"L");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$select_data_array['id_data']),$border,0,"L");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$select_data_array['title'].$select_data_array['name'].' '.$select_data_array['last']),$border,0,"L");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$select_data_array['car_regis']),$border,0,"L");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$select_data_array['total_pre']),$border,0,"R");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$select_data_array['total_sum']),$border,0,"R");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$select_data_array['prb']),$border,0,"R");
	$x++;
	if($select_data_array['commition']==0 || $select_data_array['commition']=='')
	{
		$show_commition=$select_data_array['other'];
	}
	else
	{
		$show_commition=$select_data_array['commition'];
	}
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$show_commition),$border,0,"R");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$select_data_array['total_commition']),$border,0,"R");
	$x++;
		$date_pay='';
	if($select_invoice_array['sta_pre']=='Y' && $select_invoice_array['sta_prb']=='Y' && $select_invoice_array['pre'] > 0 && $select_invoice_array['prb'] > 0)
	{
		$date_pay='ชำระแล้ว';
		$pdf->SetTextColor(43, 96, 0);
	}
	else if($select_invoice_array['sta_pre']=='Y' && $select_invoice_array['pre'] > 0 && $select_invoice_array['prb'] <= 0)
	{
		$date_pay='ชำระแล้ว';
		$pdf->SetTextColor(43, 96, 0);
	}
	else if($select_invoice_array['sta_prb']=='Y' && $select_invoice_array['prb'] > 0 && $select_invoice_array['pre'] <= 0)
	{
		$date_pay='ชำระแล้ว';
		$pdf->SetTextColor(43, 96, 0);
	}
	else
	{
		$date_pay='ยังไม่ชำระ';
		$pdf->SetTextColor(255, 0, 0);
	}
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',$date_pay),$border,1,"C");
	$pdf->SetTextColor(0, 0, 0);
	$total_pre_sum+=str_replace(',','',$select_data_array['total_pre']);
	$total_sum_sum+=str_replace(',','',$select_data_array['total_sum']);
	$prb_sum+=str_replace(',','',$select_data_array['prb']);
	if($select_data_array['commition']==0 || $select_data_array['commition']=='')
	{
	$commition_sum+=str_replace(',','',$select_data_array['other']);
	}
	else
	{
	$commition_sum+=str_replace(',','',$select_data_array['commition']);
	}
	$total_commition_sum+=str_replace(',','',$select_data_array['total_commition']);

	if($n==$select_data_num)
	{
		$pdf->SetFont('angsa',$ar_font_type[1],$ar_font_size[2]);
	$x=0;
	//$pdf->SetY($setY[2]);
	$pdf->SetX($setX[0]);
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',''),0,0,"L");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',''),0,0,"L");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',''),0,0,"L");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',''),0,0,"L");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',''),0,0,"L");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',''),0,0,"L");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620','รวม'),'B',0,"L");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',number_format($total_pre_sum,2,'.',',')),'B',0,"R");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',number_format($total_sum_sum,2,'.',',')),'B',0,"R");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',number_format($prb_sum,2,'.',',')),'B',0,"R");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',number_format($commition_sum,2,'.',',')),'B',0,"R");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',number_format($total_commition_sum,2,'.',',')),'B',0,"R");
	$x++;
	$pdf->Cell($ar_width_cell[$x],$ar_height_cell[$x],iconv( 'UTF-8','TIS-620',''),'B',1,"R");
	}
		if($ch==20 || $n==$select_data_num)
	{
		$ch=0;
		$pdf->SetFont('angsa',$ar_font_type[0],$ar_font_size[1]);
		$pdf->SetY($setY[3]);
		$pdf->SetX($setX[0]);
		$pdf->Cell(0,7,iconv('UTF-8','TIS-620',' พิมพ์โดย '.$company_name.' วันที่พิมพ์ '.date('Y-m-d')),0,0,"R");
	}
	}
	$pdf->Output();
	/*
		$pdf->SetTextColor(0, 0, 0);
	if(empty($select_invoice_array))
	{
		$payment_num = 0.00;
		$payment_name = "(ไม่มีการวางบิล)";
		$pdf->SetTextColor(255, 128, 0);
	}
	else if(str_replace(',','',$select_invoice_array['grand'])==str_replace(',','',$select_data_array['total_commition']))
	{
		$payment_num = 0.00;
		$payment_name = "(ชำระครบ)";
		$pdf->SetTextColor(43, 96, 0);
	}
	else if(str_replace(',','',$select_data_array['total_commition']) < str_replace(',','',$select_invoice_array['grand']))
	{
		$payment_num = str_replace(',','',$select_invoice_array['grand']) - str_replace(',','',$select_data_array['total_commition']);
		$payment_name = "(ชำระเกิน ".number_format($payment_num,2,'.',',').")";
		$pdf->SetTextColor(43, 96, 0);
	}
	else if(str_replace(',','',$select_data_array['total_commition']) > str_replace(',','',$select_invoice_array['grand']))
	{
		$payment_num = str_replace(',','',$select_data_array['total_commition']) - str_replace(',','',$select_invoice_array['grand']);
		$payment_name = "(ชำระขาด ".number_format($payment_num,2,'.',',').")";
		$pdf->SetTextColor(255, 0, 0);
	}
	*/
?>