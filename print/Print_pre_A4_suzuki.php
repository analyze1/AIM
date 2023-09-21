<?php
        include "../pages/check-ses.php"; 
	//include "../inc/checksession.inc.php";
	include "../inc/connectdbs.inc.php"; 

	$query = "SELECT * FROM tb_send_document
	INNER JOIN  insuree ON ( insuree.id_data = tb_send_document.id_data)
	INNER JOIN  data ON ( data.id_data = tb_send_document.id_data)
	INNER JOIN  detail ON ( detail.id_data = tb_send_document.id_data) ";
	$query .= "WHERE tb_send_document.id_data='".$_GET['IDDATA']."' AND tb_send_document.status_pre = 'Y' ";
	
	mysql_select_db($db1,$cndb1);
	$objQuery = mysql_query($query,$cndb1) or die ("Error Query cndb2 [".$query."]");
	$row = mysql_fetch_array($objQuery);
	
	$sql = "SELECT name_mini FROM tb_province WHERE id='".$row['car_regis_pro']."'";
	mysql_query("set NAMES utf8");
	$result = mysql_query($sql,$cndb1);
	$fetcharr = mysql_fetch_array( $result );
	
	require('../fpdf.php');

	define('FPDF_FONTPATH','font/');

	$pdf=new FPDF( 'L' , 'mm' , 'A4' );
	
	$pdf->SetAutoPageBreak(false);
	
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');
	$pdf->AddFont('angsa','I','angsai.php');
	$pdf->AddFont('angsa','BI','angsaz.php');
	
	$pdf->SetFont('angsa','B',12);
	
	$pdf->SetY(55);
	$pdf->SetX(100);
	$pdf->Cell(45,7,iconv( 'UTF-8','TIS-620','( '.$row["idagent"].' / '.$row["car_regis"].' '.$fetcharr['name_mini'].' )'),0,1,"L");
	
	$pdf->SetFont('angsa','B',20);
	
	$pdf->SetY(55);
	$pdf->SetX(40);
	$pdf->Cell(45,7,iconv( 'UTF-8','TIS-620','เรียน'),0,1,"L");
	
	$pdf->SetY(65);
	$pdf->SetX(55);
	$pdf->Cell(45,7,iconv( 'UTF-8','TIS-620',$row["title"].$row["name"].' '.$row["last"]),0,1,"L");
	
	$pdf->SetY(75);
	$pdf->SetX(55);
	$pdf->MultiCell(80,8,iconv( 'UTF-8','TIS-620',$row["address"]));
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	$pdf->Output();
?>