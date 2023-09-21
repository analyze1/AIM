<?php
	require('../fpdf.php');
	require('../inc/connectdbs.pdo.php');
    require('models/viriyah-payment.model.php');
    require('services/viriyah-form.service.php');
	require('../service/Convert-Address.service.php');
	define('FPDF_FONTPATH','font/');

	// echo json_encode($_SERVER);
	// exit();

    $_service = new ViriyahFormControl(PDO_CONNECTION::fourinsure_insured(),PDO_CONNECTION::fourinsure_account());
    $_info = $_service->paymentFull(base64_decode($_GET['Customer']),$_GET['TypeWork'],$_GET['CreditNo']);

	if(!$_info || get_class($_info)=='Exception')
	{
		echo 'ไม่สามารถดึงข้อมูลได้ API มีปัญหา กรุณาออกเข้าใหม่ภายหลัง ขอบคุณครับ'.$_info;
		exit();
	}

	$_homeService = new ConvertAddress(PDO_CONNECTION::fourinsure_insured());
	
	$pdf = new FPDF();
	$pdf->SetAutoPageBreak(false);
	$pdf->AddPage();
	$pdf->AddFont('angsa','','angsa.php');
	$pdf->AddFont('angsa','B','angsab.php');

    $pdf->Image('images/viriyah-form/payment-viriyah-full-main.jpg',0,0,210);
	
	if($_info->Type)//กรมธรรมใหม่
	{
		$pdf->SetY(46.2);
		$pdf->SetX(7.5);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620','X'),0,0,'L');
	}
	else//กรมธรรมเก่า
	{
		$pdf->SetY(46);
		$pdf->SetX(45.5);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620','X'),0,0,'L');
	}

		$pdf->SetY(56);
		$pdf->SetX(7.5);
		$pdf->SetFont('angsa','B',14);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620','X'),0,0,'L');//ประเภทงาน

		$pdf->SetY(71);
		$pdf->SetX(40);
		$pdf->SetFont('angsa','',12);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$_info->TypeMotorDetail),0,0,'L');//ชื่อผลิตภัณฑ์

		$pdf->SetY(111);
		$pdf->SetX(31);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(65,5,iconv('UTF-8','TIS-620',$_info->NameFull),0,0,'C');//ชื่อผู้เอาประกัน

		$mapAddress = $_homeService->mapperPDFViriyah($_info->InfoArr);
		
		// $pdf->SetY(116.5);
		// $pdf->SetX(20);
		// $pdf->SetFont('angsa','',14);
		//$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$mapAddress['pdf1']),0,0,'L');//ที่อยู่

		// $pdf->SetY(125.5);
		// $pdf->SetX(15);
		// $pdf->SetFont('angsa','',14);
		//$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$mapAddress['pdf2']),0,0,'L');//ที่อยู่
	
		// $pdf->SetY(133);
		// $pdf->SetX(31);
		// $pdf->SetFont('angsa','',14);
		//$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$_info->Post),0,0,'L');//ไปรษณีย์

		// $pdf->SetY(133);
		// $pdf->SetX(66);
		// $pdf->SetFont('angsa','',14);
		// $rep1 = substr($_info->Telephone,0,3);
		// $rep2 = substr($_info->Telephone,3);
		//$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$rep1.'-'.$rep2),0,0,'L');//เบอร์โทรศัพท์

		$pdf->SetY(160);
		$pdf->SetX(18);
		$pdf->Cell(30,5,iconv('UTF-8','TIS-620',$_info->BranCar),0,0,'C');//ยี่ห้อรถ

		$pdf->SetY(160);
		$pdf->SetX(60);
		$pdf->Cell(35,5,iconv('UTF-8','TIS-620',$_info->MoCarName),0,0,'C');//รุ่นรถ

		$pdf->SetY(172.5);
		$pdf->SetX(27);
		$pdf->Cell(20,0,iconv('UTF-8','TIS-620',$_info->RegisYear),0,0,'C');//ปีจดทะเบียน

		$pdf->SetY(172.5);
		$pdf->SetX(70);
		$pdf->Cell(20,0,iconv('UTF-8','TIS-620',$_info->RegisCar),0,0,'C');//ป้ายทะเบียน 

		$pdf->SetY(182);
		$pdf->SetX(28);
		$pdf->SetFont('angsa','',13);
		$pdf->Cell(20,0,iconv('UTF-8','TIS-620',$_info->Engnumber),0,0,'C');//เลขเครื่องยนต์

		$pdf->SetY(182);
		$pdf->SetX(64);
		$pdf->Cell(30,0,iconv('UTF-8','TIS-620',$_info->Body),0,0,'C');//เลขตัวถัง

		$pdf->SetY(191);
		$pdf->SetX(32);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(10,0,iconv('UTF-8','TIS-620',$_info->CC),0,0,'C');//ขนาดเครื่องยนต์

		$pdf->SetY(191);
		$pdf->SetX(70);
		$pdf->Cell(20,0,iconv('UTF-8','TIS-620',$_info->Gear),0,0,'C');//เกียร์

		$pdf->SetY(240);
		$pdf->SetX(18);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(55,5,iconv('UTF-8','TIS-620',$_info->NameFull),0,0,'C');//ลงชื่อผู้เอาประกัน
	
		$pdf->SetY(248);
		$pdf->SetX(14);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(10,5,iconv('UTF-8','TIS-620',$_info->Day),0,0,'C');//วันที่

		$pdf->SetY(248);
		$pdf->SetX(40);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(32,5,iconv('UTF-8','TIS-620',$_info->Month),0,0,'C');//เดือน

		$pdf->SetY(248);
		$pdf->SetX(81);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(15,5,iconv('UTF-8','TIS-620',$_info->Year),0,0,'C');//ปี

		$pdf->SetY(49);
		$pdf->SetX(122);
		$pdf->SetFont('angsa','',13);
		$pdf->Cell(0,5,iconv('UTF-8','TIS-620',$_info->BankName),0,0,'L');//ธนาคาร

		if($_info->TypeCard=='visa')
		{
			$pdf->SetY(54.5);
			$pdf->SetX(156.2);
			$pdf->SetFont('angsa','',14);
			$pdf->Cell(0,0,iconv('UTF-8','TIS-620','X'),0,0,'L');//ประเภทบัตร
		}
		else
		{
			$pdf->SetY(63);
			$pdf->SetX(156.2);
			$pdf->SetFont('angsa','',14);
			$pdf->Cell(0,0,iconv('UTF-8','TIS-620','X'),0,0,'L');//ประเภทบัตร
		}


		$numbercardEx = explode('-',$_info->NumberCard);
		$pdf->SetY(89);
		$pdf->SetFont('angsa','',14);
		$round=1;
		foreach($numbercardEx as $e)
		{
			$eDot = chunk_split($e,1,'.');
			$eArr = explode('.',$eDot);
			if($round==1)
			{
				$padX = 131;
				foreach($eArr as $e1)
				{	
					$pdf->SetX($padX);
					$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$e1),0,0,'L');//เลขบัตรเครดิต
					$padX = $padX+4;
				}
				$round++;
			}
			else if($round==2)
			{
				$padX = 148.5;
				foreach($eArr as $e1)
				{	
					$pdf->SetX($padX);
					$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$e1),0,0,'L');//เลขบัตรเครดิต
					$padX = $padX+4;
				}
				$round++;
			}
			else if($round==3)
			{
				$padX = 166.5;
				foreach($eArr as $e1)
				{	
					$pdf->SetX($padX);
					$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$e1),0,0,'L');//เลขบัตรเครดิต
					$padX = $padX+4;
				}
				$round++;
			}
			else
			{
				{
					$padX = 184.5;
					foreach($eArr as $e1)
					{	
						$pdf->SetX($padX);
						$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$e1),0,0,'L');//เลขบัตรเครดิต
						$padX = $padX+4;
					}
				}
			}
		}

		$expArr = explode('/',$_info->ExpCard);
		$ex1 = chunk_split($expArr[0],1,' ');
		
		$pdf->SetY(99.5);
		$pdf->SetX(137.5);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$ex1),0,0,'L');//เดือนบัตจรหมดอายุ

		$ex2 = chunk_split($expArr[1],1,'  ');
		$pdf->SetY(99.5);
		$pdf->SetX(149.5);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$ex2),0,0,'L');//ปีบัตรหมดอายุ

		$pdf->SetY(107);
		$pdf->SetX(153);
		$pdf->Cell(40,0,iconv('UTF-8','TIS-620',$_info->PayTotal),0,0,'C');//จำนวนเงิน

		$pdf->SetY(114);
		$pdf->SetX(143.5);
		$pdf->SetFont('angsa','',12);
		$pdf->Cell(55,5,iconv('UTF-8','TIS-620',$_info->PayDoc),0,0,'C');//จำนวนเงินตัวอักษร

		$pdf->SetY(123);
		$pdf->SetX(140);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(60,5,iconv('UTF-8','TIS-620',$_info->NameCustomerCard),0,0,'C');//ชื่อบนบัตร

		$pdf->Image(_PatchSignature.$_info->SignaturePath,155,130,25);//รูปลายเซ็นต์

		$pdf->SetY(144);
		$pdf->SetX(165);
		$pdf->SetFont('angsa','',14);
		$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$_info->RelationShip),0,0,'L');//ความสัมพันธ์
		
		// $pdf->SetY(151);
		// $pdf->SetX(155);
		// $pdf->SetFont('angsa','',14);
		// $rep1 = substr($_info->TelephoneOwnerCardNumber,0,3);
		// $rep2 = substr($_info->TelephoneOwnerCardNumber,3);
		//$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$rep1.'-'.$rep2),0,0,'L');//เบอร์เจ้าของบัตร


		if($_info->PicturePatch!='')
		{
			$pdf->AddPage();
			
			$pdf->Image(_PatchVerify.$_info->PicturePatch,50,50,100);//รูปบัตรประชาชน/ไฟล์แนบอื่นๆ

			// $pdf->SetY(10);
			// $pdf->SetX(10);
			// $pdf->SetFont('angsa','',14);
			// $pdf->Cell(0,0,iconv('UTF-8','TIS-620',_PatchVerify.$_info->PicturePatch),0,0,'L');//ทดสอบ link รูป
		}

    $pdf->Output();

?>