<?php
include "../pages/check-ses.php"; 
include "../inc/connectdbs.inc.php";
define('FPDF_FONTPATH', 'font/');
require('rotation.php');
mysql_select_db($db1,$cndb1);
$id_data=$_GET['id_data'];

if(!empty($_GET['pages']))
{
	$pages=" AND pages = '".$_GET['pages']."'";
	
}
else
{
	$pages_sql="SELECT pages FROM detail_renew WHERE id_data = '".$id_data."' ORDER BY date_detail DESC";
	$pages_query=mysql_query($pages_sql,$cndb1);
	$pages_array=mysql_fetch_array($pages_query);
	$pages=" AND pages = '".$pages_array['pages']."'";
}
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
		list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
		list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
		
		if($m == '12')
		{
			$m = '1';
			$Y = $Y+544; // เปลี่ยน ค.ศ. เป็น พ.ศ.
		}
		else
		{
			$m = $m+1;
			$Y = $Y+543;
		}
		
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
	
	function thaiDate2($datetime)
	{
		list($date,$time) = split(' ',$datetime); // แยกวันที่ กับ เวลาออกจากกัน
		list($Y,$m,$d) = split('-',$date); // แยกวันเป็น ปี เดือน วัน
		list($H,$i,$s) = split(':',$time); // แยกเวลา ออกเป็น ชั่วโมง นาที วินาที
		$Y = $Y+543;
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


$tb_customer="SELECT * FROM tb_customer WHERE user = '".$_SESSION["strUser"]."' ";
$tb_query=mysql_query($tb_customer,$cndb1);
$tb_array=mysql_fetch_array($tb_query);
$comp_name=$tb_array['title_sub']." ".$tb_array['sub'];
$pdf=new PDF('L' , 'mm' , 'A4');
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();
//$pdf->SetFont('Arial', '', 20);
$pdf->AddFont('angsa','','angsa.php');
$pdf->AddFont('angsa','B','angsab.php');
$pdf->Image('../images/logo4.png',5,4,50,20);
$pdf->SetFont('angsa','B',20);
$pdf->SetY(8);
$pdf->SetX(240);
//$pdf->Cell(1,1,iconv("UTF-8","TIS-620","ติดต่อโทร 02-196-8234"),0,1,"L");

$pdf->SetFont('angsa','B',50);
$pdf->SetTextColor(255,192,203);
$ni=strlen($comp_name);
$xi=160-(0.8*$ni);
$yi=90+(0.9*$ni);
$pdf->RotatedText($xi,$yi,iconv('UTF-8','TIS-620',$comp_name),45);
$insuree_sql="SELECT insuree.id_data,insuree.title,insuree.name,insuree.last,insuree.tel_mobi,insuree.tel_mobi_2,insuree.tel_mobi_3,data.n_insure FROM insuree INNER JOIN data ON insuree.id_data = data.id_data WHERE insuree.id_data = '".$id_data."'";
$insuree_query=mysql_query($insuree_sql,$cndb1);
$insuree_array=mysql_fetch_array($insuree_query);

if(!empty($insuree_array['tel_mobi']))
{
	$telplace=array('|','/');
	$teledit=str_replace($telplace," ",$insuree_array['tel_mobi']);
	$telmobi=$teledit;
}
else if(!empty($insuree_array['tel_mobi_2']))
{
	$telplace=array('|','/');
	$teledit=str_replace($telplace," ",$insuree_array['tel_mobi_2']);
	$telmobi=$teledit;
}
else if(!empty($insuree_array['tel_mobi_3']))
{
	$telplace=array('|','/');
	$teledit=str_replace($telplace," ",$insuree_array['tel_mobi_3']);
	$telmobi=$teledit;
}
else
{
	$telmobi="-";
}

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('angsa','B',16);
$pdf->SetY(35);
$pdf->SetX(10);
$pdf->Cell(1,7,iconv("UTF-8","TIS-620","เลขที่รับแจ้ง"),0,1,"L");
$pdf->Cell(1,7,iconv("UTF-8","TIS-620","เลขที่กรมธรรม์"),0,1,"L");
$pdf->Cell(1,7,iconv("UTF-8","TIS-620","เรียน"),0,1,"L");
$pdf->Cell(1,7,iconv("UTF-8","TIS-620","เบอร์โทรศัพท์"),0,1,"L");
$pdf->SetFont('angsa','',16);
$pdf->SetY(35);
$pdf->SetX(60);
$pdf->Cell(1,7,iconv("UTF-8","TIS-620",":     ".$insuree_array['id_data']),0,1,"L");
$pdf->SetX(60);
$pdf->Cell(1,7,iconv("UTF-8","TIS-620",":     ".$insuree_array['n_insure']),0,1,"L");
$pdf->SetX(60);
$pdf->Cell(1,7,iconv("UTF-8","TIS-620",":     ".$insuree_array['title'].$insuree_array['name']." ".$insuree_array['last']),0,1,"L");
$pdf->SetX(60);
$pdf->Cell(1,7,iconv("UTF-8","TIS-620",":     ".$telmobi),0,1,"L");
$pdf->SetFont('angsa','B',20);

$pdf->SetY(65);
$pdf->Cell(0,0,iconv("UTF-8","TIS-620","อัตราเบี้ยประกันภัย"),0,0,"C");
$pdf->SetFont('angsa','B',14);
$setx=10;
$pdf->SetY(70);
$pdf->SetX(7);
$pdf->Cell(65,$setx,iconv("UTF-8","TIS-620","บริษัทประกันภัย"),1,0,"C");
$pdf->Cell(15,$setx,iconv("UTF-8","TIS-620","ทะเบียน"),1,0,"C");
$pdf->Cell(15,$setx,iconv("UTF-8","TIS-620","ประเภท"),1,0,"C");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","ซ่อม"),1,0,"C");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","เบี้ยสุทธิ"),1,0,"C");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","เบี้ยรวม"),1,0,"C");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","พ.ร.บ."),1,0,"C");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","เบี้ยรวม พ.ร.บ."),1,0,"C");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","หัก 1%"),1,0,"C");
//$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","สวนลด"),1,0,"C");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","เบี้ยนำส่ง"),1,0,"C");
$pdf->Cell(50,$setx,iconv("UTF-8","TIS-620","หมายเหตุ"),1,1,"C");

$quotation_sql="SELECT * FROM quotation_renew WHERE id_data = '".$id_data."' ".$pages."";
$quotation_query=mysql_query($quotation_sql,$cndb1);
$pdf->SetFont('angsa','',14);
$setx=6;
while($quotation_array=mysql_fetch_array($quotation_query))
{
$pdf->SetX(7);
mysql_select_db($db2,$cndb2);
$comp_sql="SELECT name_print FROM tb_comp WHERE sort = '".$quotation_array['com_data']."'";
$comp_query=mysql_query($comp_sql,$cndb2);
$comp_array=mysql_fetch_array($comp_query);
$comp_exp=explode(" ",$comp_array['name_print']);
$comp_edit="";
for($num=1;$num<count($comp_exp);$num++)
{
	$comp_edit.=$comp_exp[$num]." ";
}
$pdf->Cell(65,$setx,iconv("UTF-8","TIS-620",$comp_edit),1,0,"L");
$pdf->Cell(15,$setx,iconv("UTF-8","TIS-620",$quotation_array['car_regis']),1,0,"L");
$pdf->Cell(15,$setx,iconv("UTF-8","TIS-620",$quotation_array['doc_type']),1,0,"C");
if($quotation_array['service']==1)
{
	$service="ซ่อมห้าง";
}
else if($quotation_array['service']==2)
{
	$service="ซ่อมอู่";
}
else
{
	$service="-";
}
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620",$service),1,0,"C");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620",$quotation_array['pre']),1,0,"R");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620",$quotation_array['pre_total']),1,0,"R");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620",$quotation_array['prb_total']),1,0,"R");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620",$quotation_array['pre_prb_total']),1,0,"R");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620",$quotation_array['vat_1']),1,0,"R");
//$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620",$quotation_array['dis']),1,0,"R");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620",$quotation_array['pre_deliver']),1,0,"R");
$pdf->Cell(50,$setx,iconv("UTF-8","TIS-620",""),1,1,"C");
}
mysql_select_db($db1,$cndb1);
$pdf->SetFont('angsa','B',16);
$pdf->SetY(170);
$pdf->SetX(10);
$pdf->Cell(25,7,iconv("UTF-8","TIS-620","ความต้องการพิเศษ"),0,1,"L");
$pdf->Cell(25,7,iconv("UTF-8","TIS-620","วันที่การติดตาม"),0,1,"L");
$pdf->Cell(25,7,iconv("UTF-8","TIS-620","ตารางนัดหมายครั้งถัดไป"),0,1,"L");
$pdf->Cell(25,7,iconv("UTF-8","TIS-620","โปรดติดต่อ"),0,1,"L");


$data_sql="SELECT date_alert,detailtext,timecall FROM detail_renew WHERE id_data = '".$id_data."' ".$pages."";
$data_query=mysql_query($data_sql,$cndb1);
$data_array=mysql_fetch_array($data_query);
$pdf->SetFont('angsa','',16);
$pdf->SetY(170);
$pdf->SetX(60);

if(!empty($data_array['detailtext']))
{
	$pdf->Cell(25,7,iconv("UTF-8","TIS-620",":     ".$data_array['detailtext']),0,1,"L");
}
else
{
	$pdf->Cell(25,7,iconv("UTF-8","TIS-620",":     -"),0,1,"L");
}
$timecall=explode(" ",$data_array['timecall']);
$pdf->SetX(60);
$pdf->Cell(25,7,iconv("UTF-8","TIS-620",":     ".$timecall[0]." มีผลภายใน30วัน นับจากวันที่ติดตาม"),0,1,"L");
$date_alert=explode(" ",$data_array['date_alert']);
$pdf->SetX(60);
$pdf->Cell(25,7,iconv("UTF-8","TIS-620",":     ".$date_alert[0]),0,1,"L");
$marketing_sql="SELECT emp_titlerenew,emp_namerenew,emp_lastrenew,emp_telrenew,emp_faxrenew,emp_emailrenew FROM tb_customer WHERE user = '".$_SESSION["strUser"]."'";
$marketing_query=mysql_query($marketing_sql,$cndb1);
$marketing_array=mysql_fetch_array($marketing_query);
$contack="";
if(!empty($marketing_array['emp_titlerenew'])){$contack.=$marketing_array['emp_titlerenew'].$marketing_array['emp_namerenew']." ".$marketing_array['emp_lastrenew'];}else{$contack.="-";}
if(!empty($marketing_array['emp_telrenew'])){$contack.="     เบอร์โทรศัพท์ :  ".$marketing_array['emp_telrenew']." ";}else{$contack.="";}
if(!empty($marketing_array['emp_faxrenew'])){$contack.="      เบอร์แฟ็กร์  : ".$marketing_array['emp_faxrenew']." ";}else{$contack.="";}
if(!empty($marketing_array['emp_emailrenew'])){$contack.="     E-Mail : ".$marketing_array['emp_emailrenew']." ";}else{$contack.="";}
$pdf->SetX(60);
$pdf->Cell(25,7,iconv("UTF-8","TIS-620",":     ".$contack),0,1,"L");
$pdf->SetFont('angsa','B',24);
$pdf->SetY(170);
$pdf->SetX(245);
$pdf->SetFillColor(255, 145, 0);
$pdf->Cell(40,7,iconv("UTF-8","TIS-620","ขอคำแนะนำ"),1,1,"C",true);
$pdf->SetX(245);
$pdf->SetFillColor(255, 213, 156);
$pdf->Cell(40,25,iconv("UTF-8","TIS-620",""),1,1,"C",true);
$pdf->SetFont('angsa','B',18);
$pdf->SetY(180);
$pdf->SetX(252);
$pdf->Cell(1,8,iconv("UTF-8","TIS-620","085-921-3636"),0,1,"L");
$pdf->SetX(252);
$pdf->Cell(1,8,iconv("UTF-8","TIS-620","085-921-5454"),0,1,"L");
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$pdf->AddPage();
$pdf->Image('../images/logo4.png',5,4,50,20);
$pdf->SetFont('angsa','B',20);
$pdf->SetY(8);
$pdf->SetX(240);
//$pdf->Cell(1,1,iconv("UTF-8","TIS-620","ติดต่อโทร 02-196-8234"),0,1,"L");

$pdf->SetFont('angsa','B',50);
$pdf->SetTextColor(255,192,203);
$ni=strlen($comp_name);
$xi=160-(0.8*$ni);
$yi=90+(0.9*$ni);
$pdf->RotatedText($xi,$yi,iconv('UTF-8','TIS-620',$comp_name),45);
$insuree_sql="SELECT insuree.id_data,insuree.title,insuree.name,insuree.last,insuree.tel_mobi,insuree.tel_mobi_2,insuree.tel_mobi_3,data.n_insure FROM insuree INNER JOIN data ON insuree.id_data = data.id_data WHERE insuree.id_data = '".$id_data."'";
$insuree_query=mysql_query($insuree_sql,$cndb1);
$insuree_array=mysql_fetch_array($insuree_query);

if(!empty($insuree_array['tel_mobi']))
{
	$telplace=array('|','/');
	$teledit=str_replace($telplace," ",$insuree_array['tel_mobi']);
	$telmobi=$teledit;
}
else if(!empty($insuree_array['tel_mobi_2']))
{
	$telplace=array('|','/');
	$teledit=str_replace($telplace," ",$insuree_array['tel_mobi_2']);
	$telmobi=$teledit;
}
else if(!empty($insuree_array['tel_mobi_3']))
{
	$telplace=array('|','/');
	$teledit=str_replace($telplace," ",$insuree_array['tel_mobi_3']);
	$telmobi=$teledit;
}
else
{
	$telmobi="-";
}

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('angsa','B',16);
$pdf->SetY(35);
$pdf->SetX(10);
$pdf->Cell(1,7,iconv("UTF-8","TIS-620","เลขที่รับแจ้ง"),0,1,"L");
$pdf->Cell(1,7,iconv("UTF-8","TIS-620","เลขที่กรมธรรม์"),0,1,"L");
$pdf->Cell(1,7,iconv("UTF-8","TIS-620","เรียน"),0,1,"L");
$pdf->Cell(1,7,iconv("UTF-8","TIS-620","เบอร์โทรศัพท์"),0,1,"L");
$pdf->SetFont('angsa','',16);
$pdf->SetY(35);
$pdf->SetX(60);
$pdf->Cell(1,7,iconv("UTF-8","TIS-620",":     ".$insuree_array['id_data']),0,1,"L");
$pdf->SetX(60);
$pdf->Cell(1,7,iconv("UTF-8","TIS-620",":     ".$insuree_array['n_insure']),0,1,"L");
$pdf->SetX(60);
$pdf->Cell(1,7,iconv("UTF-8","TIS-620",":     ".$insuree_array['title'].$insuree_array['name']." ".$insuree_array['last']),0,1,"L");
$pdf->SetX(60);
$pdf->Cell(1,7,iconv("UTF-8","TIS-620",":     ".$telmobi),0,1,"L");
$pdf->SetFont('angsa','B',20);

$pdf->SetY(65);
$pdf->Cell(0,0,iconv("UTF-8","TIS-620","เงื่อนไขและความคุ้มครอง"),0,0,"C");
$pdf->SetFont('angsa','B',14);
$setx=10;
$pdf->SetY(70);
$pdf->SetX(7);
$pdf->Cell(65,$setx,iconv("UTF-8","TIS-620","บริษัทประกันภัย"),1,0,"C");
$pdf->Cell(15,$setx,iconv("UTF-8","TIS-620","ทะเบียน"),1,0,"C");
$pdf->Cell(15,$setx,iconv("UTF-8","TIS-620","ประเภท"),1,0,"C");
$pdf->Cell(15,$setx,iconv("UTF-8","TIS-620","ซ่อม"),1,0,"C");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","บาดเจ็บ"),1,0,"C");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","ทรัพสิน"),1,0,"C");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","ผู้ขับ/ผู้โดยสาร"),1,0,"C");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","เสียชีวิต"),1,0,"C");
$pdf->Cell(23,$setx,iconv("UTF-8","TIS-620","ค่ารักษาพยาบาล"),1,0,"C");
//$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","สวนลด"),1,0,"C");
$pdf->Cell(24,$setx,iconv("UTF-8","TIS-620","ประกันตัวผู้ขับขี่"),1,0,"C");
$pdf->Cell(48,$setx,iconv("UTF-8","TIS-620","หมายเหตุ"),1,1,"C");

$quotation_sql="SELECT * FROM quotation_renew WHERE id_data = '".$id_data."' ".$pages."";
$quotation_query=mysql_query($quotation_sql,$cndb1);
$pdf->SetFont('angsa','',14);
$setx=6;
while($quotation_array=mysql_fetch_array($quotation_query))
{
$pdf->SetX(7);
mysql_select_db($db2,$cndb2);
$comp_sql="SELECT name_print FROM tb_comp WHERE sort = '".$quotation_array['com_data']."'";
$comp_query=mysql_query($comp_sql,$cndb2);
$comp_array=mysql_fetch_array($comp_query);
$comp_exp=explode(" ",$comp_array['name_print']);
$comp_edit="";
for($num=1;$num<count($comp_exp);$num++)
{
	$comp_edit.=$comp_exp[$num]." ";
}
$pdf->Cell(65,$setx,iconv("UTF-8","TIS-620",$comp_edit),1,0,"L");
$pdf->Cell(15,$setx,iconv("UTF-8","TIS-620",$quotation_array['car_regis']),1,0,"L");
$pdf->Cell(15,$setx,iconv("UTF-8","TIS-620",$quotation_array['doc_type']),1,0,"C");
if($quotation_array['service']==1)
{
	$service="ซ่อมห้าง";
}
else if($quotation_array['service']==2)
{
	$service="ซ่อมอู่";
}
else
{
	$service="-";
}
$pdf->Cell(15,$setx,iconv("UTF-8","TIS-620",$service),1,0,"C");

$tb_protection_sql="SELECT * FROM tb_protection WHERE id_protec = '".$quotation_array['id_protec']."'";
$tb_protection_query=mysql_query($tb_protection_sql,$cndb2);
$tb_protection_array=mysql_fetch_array($tb_protection_query);
if(!empty($tb_protection_array))
{
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620",number_format($tb_protection_array['life'])),1,0,"R");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620",number_format($tb_protection_array['asset'])),1,0,"R");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620",number_format($tb_protection_array['tickets'])." คน"),1,0,"R");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620",number_format($tb_protection_array['passenger'])),1,0,"R");
$pdf->Cell(23,$setx,iconv("UTF-8","TIS-620",number_format($tb_protection_array['nurse'])),1,0,"R");
$pdf->Cell(24,$setx,iconv("UTF-8","TIS-620",number_format($tb_protection_array['insuran'])),1,0,"R");
}
else
{
	$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","-"),1,0,"R");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","-"),1,0,"R");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","-"),1,0,"R");
$pdf->Cell(20,$setx,iconv("UTF-8","TIS-620","-"),1,0,"R");
$pdf->Cell(23,$setx,iconv("UTF-8","TIS-620","-"),1,0,"R");
$pdf->Cell(24,$setx,iconv("UTF-8","TIS-620","-"),1,0,"R");
}
$pdf->Cell(48,$setx,iconv("UTF-8","TIS-620",""),1,1,"C");
}
mysql_select_db($db1,$cndb1);
$pdf->SetFont('angsa','B',16);
$pdf->SetY(170);
$pdf->SetX(10);
$pdf->Cell(25,7,iconv("UTF-8","TIS-620","ความต้องการพิเศษ"),0,1,"L");
$pdf->Cell(25,7,iconv("UTF-8","TIS-620","วันที่การติดตาม"),0,1,"L");
$pdf->Cell(25,7,iconv("UTF-8","TIS-620","ตารางนัดหมายครั้งถัดไป"),0,1,"L");
$pdf->Cell(25,7,iconv("UTF-8","TIS-620","โปรดติดต่อ"),0,1,"L");


$data_sql="SELECT date_alert,detailtext,timecall FROM detail_renew WHERE id_data = '".$id_data."' ".$pages."";
$data_query=mysql_query($data_sql,$cndb1);
$data_array=mysql_fetch_array($data_query);
$pdf->SetFont('angsa','',16);
$pdf->SetY(170);
$pdf->SetX(60);

if(!empty($data_array['detailtext']))
{
	$pdf->Cell(25,7,iconv("UTF-8","TIS-620",":     ".$data_array['detailtext']),0,1,"L");
}
else
{
	$pdf->Cell(25,7,iconv("UTF-8","TIS-620",":     -"),0,1,"L");
}
$timecall=explode(" ",$data_array['timecall']);
$pdf->SetX(60);
$pdf->Cell(25,7,iconv("UTF-8","TIS-620",":     ".$timecall[0]." มีผลภายใน30วัน นับจากวันที่ติดตาม"),0,1,"L");
$date_alert=explode(" ",$data_array['date_alert']);
$pdf->SetX(60);
$pdf->Cell(25,7,iconv("UTF-8","TIS-620",":     ".$date_alert[0]),0,1,"L");
$marketing_sql="SELECT emp_titlerenew,emp_namerenew,emp_lastrenew,emp_telrenew,emp_faxrenew,emp_emailrenew FROM tb_customer WHERE user = '".$_SESSION["strUser"]."'";
$marketing_query=mysql_query($marketing_sql,$cndb1);
$marketing_array=mysql_fetch_array($marketing_query);
$contack="";
if(!empty($marketing_array['emp_titlerenew'])){$contack.=$marketing_array['emp_titlerenew'].$marketing_array['emp_namerenew']." ".$marketing_array['emp_lastrenew'];}else{$contack.="-";}
if(!empty($marketing_array['emp_telrenew'])){$contack.="     เบอร์โทรศัพท์ : ".$marketing_array['emp_telrenew']." ";}else{$contack.="";}
if(!empty($marketing_array['emp_faxrenew'])){$contack.="     เบอร์แฟ็กร์  : ".$marketing_array['emp_faxrenew']." ";}else{$contack.="";}
if(!empty($marketing_array['emp_emailrenew'])){$contack.="     E-Mail : ".$marketing_array['emp_emailrenew']." ";}else{$contack.="";}
$pdf->SetX(60);
$pdf->Cell(25,8,iconv("UTF-8","TIS-620",":     ".$contack),0,1,"L");
$pdf->SetFont('angsa','B',24);
$pdf->SetY(170);
$pdf->SetX(245);
$pdf->SetFillColor(255, 145, 0);
$pdf->Cell(40,7,iconv("UTF-8","TIS-620","ขอคำแนะนำ"),1,1,"C",true);
$pdf->SetX(245);
$pdf->SetFillColor(255, 213, 156);
$pdf->Cell(40,25,iconv("UTF-8","TIS-620",""),1,1,"C",true);
$pdf->SetFont('angsa','B',18);
$pdf->SetY(180);
$pdf->SetX(252);
$pdf->Cell(1,8,iconv("UTF-8","TIS-620","085-921-3636"),0,1,"L");
$pdf->SetX(252);
$pdf->Cell(1,8,iconv("UTF-8","TIS-620","085-921-5454"),0,1,"L");
$pdf->Output();

mysql_close(); 
?>

