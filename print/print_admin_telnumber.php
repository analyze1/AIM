<?php
require('../pages/check-ses.php');
require('../inc/connectdbs.pdo.php');
// require('../phpqrcode/qrlib.php');
// require('../Share/ConvertDataUserLogin/ConvertDataUserLogin.service.php');
// require('../services/QuickFindDataArray/ModelCarFour.service.php');
// require('../services/QuickFindDataArray/CompanyFour.service.php');
// require('../services/Address/Address.service.php');
// $_contextFour = PDO_CONNECTION::fourinsure_insured();
require('../fpdf.php');
require('../code128.php');
class PDFRotect extends PDF_Code128
{
	var $angle = 0;

	function Rotate($angle, $x = -1, $y = -1)
	{
		if ($x == -1)
			$x = $this->x;
		if ($y == -1)
			$y = $this->y;
		if ($this->angle != 0)
			$this->_out('Q');
		$this->angle = $angle;
		if ($angle != 0) {
			$angle *= M_PI / 180;
			$c = cos($angle);
			$s = sin($angle);
			$cx = $x * $this->k;
			$cy = ($this->h - $y) * $this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
		}
	}

	function _endpage()
	{
		if ($this->angle != 0) {
			$this->angle = 0;
			$this->_out('Q');
		}
		parent::_endpage();
	}

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
class AlphaPDF extends PDFRotect
{
	protected $extgstates = array();
	// alpha: real value from 0 (transparent) to 1 (opaque)
	// bm:    blend mode, one of the following:
	//          Normal, Multiply, Screen, Overlay, Darken, Lighten, ColorDodge, ColorBurn,
	//          HardLight, SoftLight, Difference, Exclusion, Hue, Saturation, Color, Luminosity
	function SetAlpha($alpha, $bm = 'Normal')
	{
		// set alpha for stroking (CA) and non-stroking (ca) operations
		$gs = $this->AddExtGState(array('ca' => $alpha, 'CA' => $alpha, 'BM' => '/' . $bm));
		$this->SetExtGState($gs);
	}
	function AddExtGState($parms)
	{
		$n = count($this->extgstates) + 1;
		$this->extgstates[$n]['parms'] = $parms;
		return $n;
	}
	function SetExtGState($gs)
	{
		$this->_out(sprintf('/GS%d gs', $gs));
	}
	function _enddoc()
	{
		if (!empty($this->extgstates) && $this->PDFVersion < '1.4') $this->PDFVersion = '1.4';
		parent::_enddoc();
	}
	function _putextgstates()
	{
		for ($i = 1; $i <= count($this->extgstates); $i++) {
			$this->_newobj();
			$this->extgstates[$i]['n'] = $this->n;
			$this->_put('<</Type /ExtGState');
			$parms = $this->extgstates[$i]['parms'];
			$this->_put(sprintf('/ca %.3F', $parms['ca']));
			$this->_put(sprintf('/CA %.3F', $parms['CA']));
			$this->_put('/BM ' . $parms['BM']);
			$this->_put('>>');
			$this->_put('endobj');
		}
	}
	function _putresourcedict()
	{
		parent::_putresourcedict();
		$this->_put('/ExtGState <<');
		foreach ($this->extgstates as $k => $extgstate) $this->_put('/GS' . $k . ' ' . $extgstate['n'] . ' 0 R');
		$this->_put('>>');
	}
	function _putresources()
	{
		$this->_putextgstates();
		parent::_putresources();
	}
}


$dealerCode = $_GET['id'];

$sql = "SELECT CONCAT(title_sub,' ',sub) AS fullName FROM tb_customer WHERE user = '$dealerCode'";

$nameDealer = PDO_CONNECTION::fourinsure_mitsu()->query($sql)->fetch(7);

$pdf = new AlphaPDF();
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(false);
$pdf->AddFont('angsa', '', 'angsa.php');
$pdf->AddFont('angsa', 'B', 'angsab.php');

$pdf->SetFont('angsa', '', 15);
$pdf->AddPage();

$pdf->Image('./images/edit1_admin_telephone_approve.jpg', 0, 0, 210);
$pdf->SetY(251);
$pdf->SetX(58);
$pdf->Cell(100, 5, iconv('UTF-8', 'TIS-620', $nameDealer), 0, 0, 'C');

$pdf->Output();