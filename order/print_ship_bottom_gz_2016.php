<?php
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter();
session_start();
require('config.php');  //this should the the absolute path to the config.php file 
require('functions.php'); //this should the the absolute path to the functions.php file - see the instrcutions for config.php above
if (allow_access(@Administrators) != "yes"){ //this is group name or username of the group or person that you wish to allow access to{                                                            // - please be advise that the Administrators Groups has access to all pages.  include ('no_access.html'); //this should the the absolute path to the no_access.html file - see above
	exit;
}

define('FPDF_FONTPATH','./pdf/font/');
//require('pdf/chinese.php');
require('pdf/mbfpdf.php');



//--------------------------------------------------------------------------------------------------

class PDF extends MBFPDF {

	function Header() {
		//Page header
		/*global $title;
		global $header_title;
		
		
		$w=$this->GetStringWidth($title);
		$this->SetX(0);
		$this->SetDrawColor(255,255,255);
		$this->SetFillColor(233,233,233);
		$this->SetTextColor(0,0,0);
		
		$this->Ln(20);*/
	 
	}

	function Footer() {
		//Page footer
		//$this->SetY(0);
	 
		//$this->SetTextColor(128);
		//$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
	}

	function Body($invoice_no,$addr_id) {

		$border = 1;

		$order_row = getsale_data($invoice_no);

		$debt_row = getdebt_data($invoice_no);

		//$office_addr = getAddr_data($addr_id);

		$this->SetFont(KOZMIN, '',11);
		$this->SetTextColor(0,0,0);

		$this->SetY(-2);

		$this->Cell(150, 107, '', $border, 1);

	// Shipper
		// From
/*		$this->Cell(50, 10, '', $border);
		$this->Cell(100, 10, 'Guang Dong', $border);

		// Shipper Account
		$this->Cell(10, 20, '', $border);
		$this->Cell(30, 20, $office_addr['post_acc_no'], $border, 1);
	
		// Address
		$this->SetY(40);
		$this->Cell(150, 20, $office_addr['address1'].' '.$office_addr['address2'].' '.$office_addr['address2'], $border, 1, 'L');

		// Contact Person
		$this->Cell(50, 20, '', $border);
		$this->Cell(30, 20, 'XXX', $border);

		// Date
		$this->Cell(30, 20, date('Y-m-d'), $border);

		// Phone
		$this->Cell(40, 10, 'XXXXXXXX', $border, 1);
		$this->Ln(10);

	// Importer
		$this->Cell(150, 50, '', $border, 1);
*/
	// Consignee

		// Address
		$this->Cell(150, 20, $debt_row['debt_cust_address1'].' '.$debt_row['debt_cust_address2'].' '.$debt_row['debt_cust_address3'], $border, 1, 'L');

		// Country
		$this->Cell(30, 8, iconv("UTF-8", 'euc-jp', '日本'), $border);

		// Postal Code
		$this->Cell(25, 8, $debt_row['debt_post_co'], $border);

		// Contact Person
		$this->Cell(25, 8, $order_row['sale_name'], $border);

		// Signature
		$this->Cell(25, 8, '', $border);		

		// Phone
		$this->Cell(25, 8, $debt_row['debt_tel'], $border);
	}
}

//--------------------------------------------------------------------------------------------------

$invoice_no = $_GET['sale_ref'];
$addr_id = $_GET['addr_id'];

$pdf=new PDF('P','mm',array(245,200));

$pdf->SetTopMargin(0);
$pdf->SetLeftMargin(0);
$pdf->SetAutoPageBreak(true, 0);
  
$pdf->AddMBFont(KOZMIN, 'EUC-JP');
$pdf->AddMBFont(PGOTHIC, 'EUC-JP');
$pdf->SetFont(KOZMIN, '', 30);
//$pdf->AddBig5Font();

$header_title=array();
$pdf->Body($invoice_no,$addr_id);
$pdf->SetAuthor('');

$pdf->Output();

?>