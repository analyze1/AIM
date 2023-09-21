<?php
        include "../pages/check-ses.php"; 
	//include "../inc/checksession.inc.php";
	include "../inc/connectdbs.inc.php"; 
	$chkdata = $_POST['chkid'];
	$chkcount = count($_POST['chkid']);

	require('../fpdf.php');
	define('FPDF_FONTPATH','font/');
	$pdf=new FPDF( 'L' , 'mm' , 'A5' );
	$pdf->SetAutoPageBreak(false);


	for($i=0;$i<$chkcount;$i++){
		$data1 = '';
		$data1 = explode('|',$chkdata[$i]);
		//echo '<br>'.$chkdata[$i];
	
	// $query = "SELECT * FROM data
	// INNER JOIN  detail ON ( detail.id_data = data.id_data) 
	// INNER JOIN  insuree ON ( insuree.id_data = data.id_data)";
	// $query .= "WHERE data.id_data='".$chkdata[$i]."'   ";
	
	// mysql_select_db($db1,$cndb1);
	// $objQuery = mysql_query($query,$cndb1) or die ("Error Query cndb3 [".$query."]");
	// $row = mysql_fetch_array($objQuery);
	
	// $sql = "SELECT name_mini FROM tb_province WHERE id='".$row['car_regis_pro']."'";
	// mysql_query("set NAMES utf8");
	// $result = mysql_query($sql,$cndb2);
	// $fetcharr = mysql_fetch_array( $result );	
	
	$pdf->AddPage();
	$pdf->SetMargins(5,5,5);
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');
	$pdf->AddFont('angsa','I','angsai.php');
	$pdf->AddFont('angsa','BI','angsaz.php');
	
	
	
	$pdf->SetFont('angsa','B',20);
	
	$pdf->SetY(55);
	$pdf->SetX(50);
	$pdf->Cell(45,7,iconv( 'UTF-8','TIS-620','เรียน'),0,1,"L");
	
	$pdf->SetY(55);
	$pdf->SetX(65);
	$pdf->Cell(45,7,iconv( 'UTF-8','TIS-620',$data1[1]),0,1,"L");

	$pdf->SetY(65);
	$pdf->SetX(65);
	$pdf->Cell(45,7,iconv( 'UTF-8','TIS-620',$data1[2]),0,1,"L");


	$pdf->SetY(75);
	$pdf->SetX(65);
	$pdf->Cell(45,7,iconv( 'UTF-8','TIS-620',$data1[3]),0,1,"L");	


	$pdf->SetY(85);
	$pdf->SetX(65);
	$pdf->Cell(45,7,iconv( 'UTF-8','TIS-620',$data1[4]),0,1,"L");


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	}

  $pdf->Output("MyPDF/XXX","I");

?>