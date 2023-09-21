<?php

include '../fpdf.php';
include '../inc/connectdbs.pdo.php';
include 'models/viriyah-payment.model.php';
include 'services/viriyah-form.service.php';
include '../services/Convert-Address.service.php';

// define('_PatchSignature','https://www.4insurance.co.th/composer/shared/signature-img/');
// define('_PatchSignatureDev','http://localhost:8080/4insure/composer/shared/signature-img/');
// define('_PatchVerify','https://www.4insurance.co.th/composer/shared/citizen-verify/');

define('FPDF_FONTPATH', 'font/');

$_service    = new ViriyahFormControl(PDO_CONNECTION::fourinsure_insured(), PDO_CONNECTION::fourinsure_account());
$_info = $_service->installment(base64_decode($_GET['Customer']), $_GET['TypeWork'], $_GET['CreditNo']);

if (!$_info || get_class($_info) == 'Exception') {
	echo 'ไม่สามารถดึงข้อมูลได้ API มีปัญหา กรุณาออกเข้าใหม่ภายหลัง ขอบคุณครับ' . $_info;
	exit();
}

$_homeService = new ConvertAddress(PDO_CONNECTION::fourinsure_insured());

$pdf = new FPDF();
$pdf->SetAutoPageBreak(false);

if ($_info->TotalPremiumAct == '0.00') goto installment;

/*งานในส่วนตัดเต็ม พ.ร.บ.*/

$pdf->AddPage();
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->AddFont('angsa', 'B', 'angsab.php');

$pdf->Image('images/viriyah-form/payment-viriyah-full-main.jpg', 0, 0, 210);

if ($_info->Type) //กรมธรรมใหม่
{
	$pdf->SetY(46.2);
	$pdf->SetX(7.5);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else //กรมธรรมเก่า
{
	$pdf->SetY(46);
	$pdf->SetX(45.5);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
}

$pdf->SetY(56);
$pdf->SetX(7.5);
$pdf->SetFont('angsa', 'B', 14);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L'); //ประเภทงาน

$pdf->SetY(71);
$pdf->SetX(40);
$pdf->SetFont('angsa', '', 12);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $_info->TypeMotorDetail), 0, 0, 'L'); //ชื่อผลิตภัณฑ์

$pdf->SetY(111);
$pdf->SetX(31);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(65, 5, iconv('UTF-8', 'TIS-620', $_info->NameFull), 0, 0, 'C'); //ชื่อผู้เอาประกัน

//$mapAddress = $_homeService->mapperPDFViriyah($_info->InfoArr);

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
$pdf->Cell(30, 5, iconv('UTF-8', 'TIS-620', $_info->BranCar), 0, 0, 'C'); //ยี่ห้อรถ

$pdf->SetY(160);
$pdf->SetX(60);
$pdf->Cell(35, 5, iconv('UTF-8', 'TIS-620', $_info->MoCarName), 0, 0, 'C'); //รุ่นรถ

$pdf->SetY(172.5);
$pdf->SetX(27);
$pdf->Cell(20, 0, iconv('UTF-8', 'TIS-620', $_info->RegisYear), 0, 0, 'C'); //ปีจดทะเบียน

$pdf->SetY(172.5);
$pdf->SetX(70);
$pdf->Cell(20, 0, iconv('UTF-8', 'TIS-620', $_info->RegisCar), 0, 0, 'C'); //ป้ายทะเบียน 

$pdf->SetY(182);
$pdf->SetX(28);
$pdf->SetFont('angsa', '', 13);
$pdf->Cell(20, 0, iconv('UTF-8', 'TIS-620', $_info->Engnumber), 0, 0, 'C'); //เลขเครื่องยนต์

$pdf->SetY(182);
$pdf->SetX(64);
$pdf->Cell(30, 0, iconv('UTF-8', 'TIS-620', $_info->Body), 0, 0, 'C'); //เลขตัวถัง

$pdf->SetY(191);
$pdf->SetX(32);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(10, 0, iconv('UTF-8', 'TIS-620', $_info->CC), 0, 0, 'C'); //ขนาดเครื่องยนต์

$pdf->SetY(191);
$pdf->SetX(70);
$pdf->Cell(20, 0, iconv('UTF-8', 'TIS-620', $_info->Gear), 0, 0, 'C'); //เกียร์

$pdf->SetY(240);
$pdf->SetX(18);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(55, 5, iconv('UTF-8', 'TIS-620', $_info->NameFull), 0, 0, 'C'); //ลงชื่อผู้เอาประกัน

$pdf->SetY(248);
$pdf->SetX(14);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(10, 5, iconv('UTF-8', 'TIS-620', $_info->Day), 0, 0, 'C'); //วันที่

$pdf->SetY(248);
$pdf->SetX(40);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(32, 5, iconv('UTF-8', 'TIS-620', $_info->Month), 0, 0, 'C'); //เดือน

$pdf->SetY(248);
$pdf->SetX(81);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(15, 5, iconv('UTF-8', 'TIS-620', $_info->Year), 0, 0, 'C'); //ปี

$pdf->SetY(49);
$pdf->SetX(122);
$pdf->SetFont('angsa', '', 13);
$pdf->Cell(0, 5, iconv('UTF-8', 'TIS-620', $_info->BankName), 0, 0, 'L'); //ธนาคาร

if ($_info->TypeCard == 'visa') {
	$pdf->SetY(54.5);
	$pdf->SetX(156.2);
	$pdf->SetFont('angsa', '', 14);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L'); //ประเภทบัตร
} else {
	$pdf->SetY(63);
	$pdf->SetX(156.2);
	$pdf->SetFont('angsa', '', 14);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L'); //ประเภทบัตร
}


$numbercardEx = explode('-', $_info->NumberCard);
$pdf->SetY(89);
$pdf->SetFont('angsa', '', 14);
$round = 1;
foreach ($numbercardEx as $e) {
	$eDot = chunk_split($e, 1, '.');
	$eArr = explode('.', $eDot);
	if ($round == 1) {
		$padX = 131;
		foreach ($eArr as $e1) {
			$pdf->SetX($padX);
			$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $e1), 0, 0, 'L'); //เลขบัตรเครดิต
			$padX = $padX + 4;
		}
		$round++;
	} else if ($round == 2) {
		$padX = 148.5;
		foreach ($eArr as $e1) {
			$pdf->SetX($padX);
			$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $e1), 0, 0, 'L'); //เลขบัตรเครดิต
			$padX = $padX + 4;
		}
		$round++;
	} else if ($round == 3) {
		$padX = 166.5;
		foreach ($eArr as $e1) {
			$pdf->SetX($padX);
			$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $e1), 0, 0, 'L'); //เลขบัตรเครดิต
			$padX = $padX + 4;
		}
		$round++;
	} else { {
			$padX = 184.5;
			foreach ($eArr as $e1) {
				$pdf->SetX($padX);
				$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $e1), 0, 0, 'L'); //เลขบัตรเครดิต
				$padX = $padX + 4;
			}
		}
	}
}

$expArr = explode('/', $_info->ExpCard);
$ex1 = chunk_split($expArr[0], 1, ' ');

$pdf->SetY(99.5);
$pdf->SetX(137.5);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $ex1), 0, 0, 'L'); //เดือนบัตจรหมดอายุ

$ex2 = chunk_split($expArr[1], 1, '  ');
$pdf->SetY(99.5);
$pdf->SetX(149.5);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $ex2), 0, 0, 'L'); //ปีบัตรหมดอายุ

$pdf->SetY(107);
$pdf->SetX(153);
//$pdf->Cell(40,0,iconv('UTF-8','TIS-620',$_info->PayTotal),0,0,'C');//จำนวนเงิน
$pdf->Cell(40, 0, iconv('UTF-8', 'TIS-620', $_info->TotalPremiumAct), 0, 0, 'C'); //จำนวนเงิน

$pdf->SetY(114);
$pdf->SetX(143.5);
$pdf->SetFont('angsa', '', 12);
//$pdf->Cell(55,5,iconv('UTF-8','TIS-620',$_info->PayDoc),0,0,'C');//จำนวนเงินตัวอักษร
$pdf->Cell(55, 5, iconv('UTF-8', 'TIS-620', $_info->TotalPremiumActText), 0, 0, 'C'); //จำนวนเงินตัวอักษร

$pdf->SetY(123);
$pdf->SetX(140);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(60, 5, iconv('UTF-8', 'TIS-620', $_info->NameCustomerCard), 0, 0, 'C'); //ชื่อบนบัตร

//_PatchSignature
$pdf->Image(_PatchSignature . $_info->Signature, 155, 130, 25); //รูปลายเซ็นต์

$pdf->SetY(144);
$pdf->SetX(165);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $_info->RelationShip), 0, 0, 'L'); //ความสัมพันธ์

// $pdf->SetY(151);
// $pdf->SetX(155);
// $pdf->SetFont('angsa','',14);
// $rep1 = substr($_info->TelephoneOwnerCardNumber,0,3);
// $rep2 = substr($_info->TelephoneOwnerCardNumber,3);
//$pdf->Cell(0,0,iconv('UTF-8','TIS-620',$rep1.'-'.$rep2),0,0,'L');//เบอร์เจ้าของบัตร

installment:
/*งานในส่วนผ่อนชำระ*/
$pdf->AddPage();
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->AddFont('angsa', 'B', 'angsab.php');

$pdf->Image('images/viriyah-form/payment-viriyah-installment-main.jpg', 0, 0, 210);

if ($_info->Type) //กรมธรรมใหม่
{
	$pdf->SetY(43);
	$pdf->SetX(31);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else //กรมธรรมเก่า
{
	$pdf->SetY(43);
	$pdf->SetX(88);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
}

if ($_info->TypeDetail != '') {
	$pdf->SetY(40);
	$pdf->SetX(135);
	$pdf->SetFont('angsa', '', 14);
	$pdf->Cell(55, 5, iconv('UTF-8', 'TIS-620', $_info->TypeDetail), 0, 0, 'C'); //เลขกรมเดิม
}

$pdf->SetY(53);
$pdf->SetX(40);
$pdf->SetFont('angsa', '', 14);
$pdf->Cell(130, 5, iconv('UTF-8', 'TIS-620', $_info->FullName), 0, 0, 'L'); //ชื่อผู้เอาประกัน

// $pdf->SetY(66.5);
// $pdf->SetX(50);
// $pdf->Cell(140,5,iconv('UTF-8','TIS-620',$_info->Address),0,0,'L');//ที่อยู่

// $pdf->SetY(74);
// $pdf->SetX(115);
// $pdf->Cell(0,0,iconv('UTF-8','TIS-620',$_info->Post),0,0,'L');//รหัสไปรษณีย์

// $rep1 = substr($_info->Telephone,0,3);
// $rep2 = substr($_info->Telephone,3);
// $pdf->SetY(74);
// $pdf->SetX(155);
// $pdf->Cell(0,0,iconv('UTF-8','TIS-620',$rep1.'-'.$rep2),0,0,'L');//เบอร์โทรศัพท์

$pdf->SetY(88);
$pdf->SetX(14.5);
$pdf->Cell(58, 5, iconv('UTF-8', 'TIS-620', $_info->BranCarModel), 0, 0, 'C'); //ยี่ห้อ/รุ่น

$pdf->SetY(88);
$pdf->SetX(74);
$pdf->Cell(25, 5, iconv('UTF-8', 'TIS-620', $_info->RegisCar), 0, 0, 'C'); //ทะเบียน

$pdf->SetY(88);
$pdf->SetX(100);
$pdf->Cell(21, 5, iconv('UTF-8', 'TIS-620', $_info->RegisYear), 0, 0, 'C'); //ปีจดทะเบียน

$pdf->SetY(88);
$pdf->SetX(122);
$pdf->Cell(46, 5, iconv('UTF-8', 'TIS-620', $_info->Body), 0, 0, 'C'); //เลขตัวถัง

$pdf->SetY(88);
$pdf->SetX(170);
$pdf->Cell(25, 5, iconv('UTF-8', 'TIS-620', $_info->CCSeat), 0, 0, 'C'); //ขนาดรถซีซี

//จำนวนงวดผ่อนชะระ
if ($_info->RoundMonth == 3) {
	$pdf->SetY(112.5);
	$pdf->SetX(54);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else {
	$pdf->SetY(112.5);
	$pdf->SetX(85);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
}


$pdf->SetY(113);
$pdf->SetX(145);
$pdf->SetFont('angsa', '', 14);
//$pdf->Cell(35,0,iconv('UTF-8','TIS-620',$_info->TotalRound),0,0,'C');//ผ่อนงวดละ
$pdf->Cell(35, 0, iconv('UTF-8', 'TIS-620', $_info->TotalPremiumRound), 0, 0, 'C'); //ผ่อนงวดละ

//บัตรเครดิต 
$pdf->SetFont('angsa', 'B', 14);
if ($_info->TypeCard == 'KTC') //KTC
{
	$pdf->SetY(121.5);
	$pdf->SetX(165.5);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCard == 'KBANK') //KBANK
{
	$pdf->SetY(121.5);
	$pdf->SetX(54);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCard == 'BBL') //BBL
{
	$pdf->SetY(121.5);
	$pdf->SetX(84);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCard == 'SCB') //SCB
{
	$pdf->SetY(121.5);
	$pdf->SetX(108);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCard == 'CITY') //CITY
{
	$pdf->SetY(121.5);
	$pdf->SetX(139);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCard == 'BAY') //BAY
{
	$pdf->SetY(129.5);
	$pdf->SetX(54);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCard == 'central') //central
{
	$pdf->SetY(129.5);
	$pdf->SetX(54);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');

	$pdf->SetY(136.5);
	$pdf->SetX(59.5);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCard == 'robin') //robin
{
	$pdf->SetY(129.5);
	$pdf->SetX(54);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');

	$pdf->SetY(136.5);
	$pdf->SetX(92);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCard == 'aia') //aia
{
	$pdf->SetY(129.5);
	$pdf->SetX(54);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');

	$pdf->SetY(136.5);
	$pdf->SetX(130.5);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCard == 'homePro') //homePro
{
	$pdf->SetY(129.5);
	$pdf->SetX(54);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');

	$pdf->SetY(144.5);
	$pdf->SetX(59.5);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCard == 'manChets') //manChets
{
	$pdf->SetY(129.5);
	$pdf->SetX(54);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');

	$pdf->SetY(144.5);
	$pdf->SetX(92);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCard == 'tesco') //tesco
{
	$pdf->SetY(129.5);
	$pdf->SetX(54);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');

	$pdf->SetY(153.5);
	$pdf->SetX(92.5);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCard == 'firstChoic') //firstChoic
{
	$pdf->SetY(129.5);
	$pdf->SetX(54);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');

	$pdf->SetY(153.5);
	$pdf->SetX(59.5);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
}

//ประเภทบัตร
if ($_info->TypeCredit == 'VISA') //VISA
{
	$pdf->SetY(164);
	$pdf->SetX(56);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCredit == 'MasterCard') //MasterCard
{
	$pdf->SetY(164);
	$pdf->SetX(83.2);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCredit == 'Platinum') //Platinum
{
	$pdf->SetY(164);
	$pdf->SetX(109.2);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
} else if ($_info->TypeCredit == 'Titanium') //Titanium
{
	$pdf->SetY(164);
	$pdf->SetX(148);
	$pdf->SetFont('angsa', 'B', 14);
	$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', 'X'), 0, 0, 'L');
}

$pdf->SetY(175);
$pdf->SetX(74);
$pdf->SetFont('angsa', '', 14);
//$pdf->Cell(30,0,iconv('UTF-8','TIS-620',$_info->Total),0,0,'C');//เรียกเก็บทั้งหมด
$pdf->Cell(30, 0, iconv('UTF-8', 'TIS-620', $_info->TotalPremium), 0, 0, 'C'); //เรียกเก็บทั้งหมด

$pdf->SetY(175);
$pdf->SetX(128.5);
$pdf->SetFont('angsa', '', 11);
//$pdf->Cell(62,0,iconv('UTF-8','TIS-620',$_info->TotalString),0,0,'C');//เรียกเก็บทั้งหมดตัวอักษร
$pdf->Cell(62, 0, iconv('UTF-8', 'TIS-620', $_info->TotalPremiumText), 0, 0, 'C'); //เรียกเก็บทั้งหมดตัวอักษร

//หมายเลขบัตร
$numbercardEx = explode('-', $_info->CardNumber);
$pdf->SetY(183.5);
$pdf->SetFont('angsa', '', 14);
$round = 1;
foreach ($numbercardEx as $e) {
	$eDot = chunk_split($e, 1, '.');
	$eArr = explode('.', $eDot);
	if ($round == 1) {
		$padX = 54.5;
		foreach ($eArr as $e1) {
			$pdf->SetX($padX);
			$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $e1), 0, 0, 'L'); //เลขบัตรเครดิต
			$padX = $padX + 4.2;
		}
		$round++;
	} else if ($round == 2) {
		$padX = 72.5;
		foreach ($eArr as $e1) {
			$pdf->SetX($padX);
			$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $e1), 0, 0, 'L'); //เลขบัตรเครดิต
			$padX = $padX + 4.2;
		}
		$round++;
	} else if ($round == 3) {
		$padX = 91;
		foreach ($eArr as $e1) {
			$pdf->SetX($padX);
			$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $e1), 0, 0, 'L'); //เลขบัตรเครดิต
			$padX = $padX + 4.1;
		}
		$round++;
	} else { {
			$padX = 109;
			foreach ($eArr as $e1) {
				$pdf->SetX($padX);
				$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $e1), 0, 0, 'L'); //เลขบัตรเครดิต
				$padX = $padX + 4.1;
			}
		}
	}
}

//บัตรหมดอายุ
$expArr = explode('/', $_info->ExpCard);
$ex1 = chunk_split($expArr[0], 1, '   ');
$pdf->SetFont('angsa', '', 12);
$pdf->SetY(183.5);
$pdf->SetX(160);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $ex1), 0, 0, 'L'); //เดือนบัตจรหมดอายุ

$ex2 = chunk_split($expArr[1], 1, '   ');
$pdf->SetY(183.5);
$pdf->SetX(169.5);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $ex2), 0, 0, 'L'); //ปีบัตรหมดอายุ

$pdf->SetFont('angsa', '', 14);
$pdf->SetY(192);
$pdf->SetX(166);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $_info->OwnerApprove['day']), 0, 0, 'L'); //ลงวันที่

$pdf->SetY(192);
$pdf->SetX(175);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $_info->OwnerApprove['month']), 0, 0, 'L'); //ลงวันที่


$pdf->SetY(192);
$pdf->SetX(182);
$pdf->Cell(0, 0, iconv('UTF-8', 'TIS-620', $_info->OwnerApprove['year']), 0, 0, 'L'); //ลงวันที่

//_PatchSignature
$pdf->Image(_PatchSignature . $_info->Signature, 80, 187, 19); //ลายเซ็นต์

$pdf->SetY(195);
$pdf->SetX(63);
$pdf->Cell(62, 5, iconv('UTF-8', 'TIS-620', $_info->NameOnCard), 0, 0, 'C'); //ชื่อบนบัตร


$pdf->SetY(202.5);
$pdf->SetX(75);
$pdf->Cell(50, 5, iconv('UTF-8', 'TIS-620', $_info->RelationShip), 0, 0, 'C'); //ความสัมพันธ์


$pdf->SetY(223.5);
$pdf->SetX(25);
$pdf->Cell(80, 5, iconv('UTF-8', 'TIS-620', $_info->FullName), 0, 0, 'C'); //ลงชื่อผู้เอาประกันภัย

$pdf->SetY(255.5);
$pdf->SetX(48);
$pdf->Cell(100, 0, iconv('UTF-8', 'TIS-620', 'บริษัท โฟร์ อินชัวรันส์ โบรกเกอร์ จำกัด'), 0, 0, 'C'); //ชื่อตัวแทน

$pdf->SetY(255.5);
$pdf->SetX(172);
$pdf->Cell(20, 0, iconv('UTF-8', 'TIS-620', '08829'), 0, 0, 'C'); //รหัสตัวแทน

$pdf->SetY(265.5);
$pdf->SetX(25);
$pdf->Cell(80, 5, iconv('UTF-8', 'TIS-620', 'คุณฉลวยจิต พิมพ์อินทร์'), 0, 0, 'C'); //ชื่อตัวแทน

if ($_info->PicturePatch != '') {
	$pdf->AddPage();
	//_PatchVerify
	$pdf->Image(_PatchVerify . $_info->PicturePatch, 50, 50, 100); //รูปบัตรประชาชน/ไฟล์แนบอื่นๆ
}

$pdf->Output();