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

$invoice_no = $_GET['sale_ref'];
$addr_id = $_GET['addr_id'];

define('FPDF_FONTPATH','./pdf/font/');
//require('pdf/chinese.php');
require('pdf/mbfpdf.php');
class PDF extends MBFPDF
{

var $col=0;
//Ordinate of column start
var $y0;
var $header_title=array();

function Set_header_title($header_title) {
	$this->header_title=$header_title;
}

function Body($invoice_no,$addr_id)
{
  $debt_row=getdebt_data($invoice_no);

	$order_row=getsale_data($invoice_no);

	$ship_row= getship_data($invoice_no);
	//$prod_row= getsprod_data($invoice_no);
	$prod_rows= getsprod_data_all($invoice_no);
	
	$addr_row=getAddr_data($addr_id);
	
	$bal = getbalance_data($invoice_no);
	
	//$addr_name=$addr_row["name"];
	$addr1=$addr_row["address1"];
	$addr2=$addr_row["address2"];
	$addr3=$addr_row["address3"];
	$post_acc_no=$addr_row["post_acc_no"];
	$post_acc_name=$addr_row["post_acc_name"];
	
	$prod_row = $prod_rows[0];
	$sprod_price=$prod_row["sprod_price"];
	$sprod_unit=$prod_row["sprod_unit"];
	$sprod_sub=$sprod_price*$sprod_unit;
	$sprod_name=$prod_row['sprod_name'];
	$sprod_material=$prod_row['sprod_material'];
	$sprod_colour=$prod_row['sprod_colour'];
	
	$sub_total = number_format($sub_total + $sprod_sub,2,'.','');	
	$sale_discount=$order_row["sale_discount"];
	$sale_ship_fee=$order_row["sale_ship_fee"];
	$sale_tax=$order_row["sale_tax"];
	$total = number_format($sub_total-$sale_discount,2,'.','');
	$total_tax =$total * $sale_tax / 100; 
	$total_tax = number_format(round($total_tax, 0),2,'.','');
	$total = number_format($total + $sale_ship_fee + total_tax,2,'.','');
	
	$tel=0;
	if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='')
	{
		$tel = $debt_row['debt_tel']." ". $debt_row['debt_mobile'];
	}
	
	$debt_post_co = '';
	for ($i = 0; $i < strlen($debt_row['debt_post_co']); $i++) {
		$debt_post_co .= $debt_row['debt_post_co']{$i}.' ';
	}
	
	
	$this->SetY(-2);

   	$this->SetTextColor(0,0,0);
 
  	$border=0; //TODO
  

	
	//$this->SetFont(KOZMIN, '', 14);

// Post Code
	$this->SetFont(KOZMIN, '',20);
	$this->Cell(17,12,"",$border,0,'L',0);
	$this->Cell(8,12,"",$border,0,'L',0);
	$this->Cell(53,12,$debt_post_co,$border,1,'L',0);

// Client address
	//$address = $debt_row['debt_cust_address1'].' '.$debt_row['debt_cust_address2'].' '.$debt_row['debt_cust_address3'];
	//$address_line1 = mb_substr($address, 0, 16, 'EUC-JP');
	//$address_line2 = mb_substr($address, 16, mb_strlen($address), 'EUC-JP');
	
	$this->SetFont(KOZMIN, '',11);
	$this->Cell(17,8,"",$border,0,'R',0);
	$this->Cell(63,8,$debt_row['debt_cust_address1'],$border,0,'L',0);
 	$this->Cell(100,8,"",$border,1,'L',0);

   	$this->Cell(17,8,"",$border,0,'L',0);
	$this->Cell(63,8,$debt_row['debt_cust_address2'].$debt_row['debt_cust_address3'],$border,0,'L',0);
 	$this->Cell(100,8,"",$border,1,'L',0);

 	$this->Cell(20,4,'',$border, 0, 'L',0);
	$this->Cell(160,4,'',$border,1,'L',0);
$this->SetFont(KOZMIN,'',14);
	
	//$this->Cell(20,8,'',$border, 0, 'L',0);
	//$this->Cell(163,8,'',$border,1,'L',0);
	//$this->Cell(20,8,"",$border,1,'L',0);

// Sales Name
	$this->Cell(20,8,'',$border, 0, 'L',0);
	$this->Cell(80,8,$order_row['sale_name'],$border,0,'L',0);
	$this->Cell(80,8,"",$border,1,'L',0);
	
// Tel
	$this->Cell(20,8,'',$border, 0, 'L',0);
	$this->Cell(80,8,$tel,$border,0,'L',0);
	$this->Cell(80,8,"",$border,1,'L',0);
	
// Post Code
// 	$this->SetFont(KOZMIN, '',16);
// 	$this->Cell(130,8,"",$border,0,'R',0);
// 	$this->SetFont(KOZMIN, '',12);
// 	$this->Cell(60,8,$debt_row['debt_post_co'],$border,1,'L',0);

//	$this->Ln(3);
	
	$this->Cell(90,8,"",$border,0,'R',0);
	$this->Cell(73,8,"",$border,1,'L',0);

// Office Address
	//$officeAddr = $addr1.' '.$addr2.' '.$addr3;
	
	$this->Cell(20,8,'',$border, 0, 'L',0);
	$this->Cell(70,8,substr($officeAddr, 0, 20),$border,0,'L',0);
	$this->Cell(50,8,"",$border,1,'L',0);
	
	$this->Cell(20,8,'',$border, 0, 'L',0);
	$this->Cell(70,8,substr($officeAddr, 20),$border,0,'L',0);
	$this->Cell(73,8,"",$border,1,'L',0);

// Blank Line
 	$this->Cell(90,8,"",$border,0,'R',0);
	$this->Cell(73,8,'',$border,1,'L',0);
	
// Office Name
	$this->Cell(20,8,'',$border, 0, 'L',0);
 	$this->Cell(70,8,$addr_name,$border,0,'L',0);
	$this->Cell(50,8,"",$border,1,'L',0);
	
$this->Ln(4);

// Product ID
	/* $this->Cell(35,8,"",$border,0,'R',0);
	$this->Cell(100,8,$sprod_id,$border,0,'L',0);
	$this->Cell(5,8,"",$border,1,'C',0); */
	$this->SetFont(KOZMIN, '',10);
	$this->SetXY(165, 58);
	foreach ($prod_rows as $prod_row) {
		$this->MultiCell(30,6,$prod_row["sprod_id"].chr(13).chr(10).$sprod_material.' '.$sprod_colour,$border,'L',0);
		$this->SetX(165);
	}
	//$this->MultiCell(30,6,$sprod_id,$border,'L',0);
	
// Product Name
	$this->SetFont(KOZMIN, '',7);
 	//$this->SetXY(165, 65);
	$this->SetXY(138, 26);
	$this->MultiCell(50,4,$sprod_name,$border,'L',0);
	
	
// Delivery Date & Time
	$this->SetFont(KOZMIN, '',10);
	$this->SetXY(133, 13);
	$this->MultiCell(25,4,$bal['bal_delivery_date'].chr(13).chr(10).$bal['bal_delivery_time'],$border,'L',0);
 	
}
function Header()
{
	//Page header
	global $title;
	global $header_title;
	
	
	$w=$this->GetStringWidth($title);
	$this->SetX(0);
	$this->SetDrawColor(255,255,255);
	$this->SetFillColor(233,233,233);
	$this->SetTextColor(0,0,0);
	
	//$this->Ln(16);
	$this->Ln(12);
 
}

function Footer()
{
	//Page footer
	$this->SetY(0);
 
	//$this->SetTextColor(128);
	//$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}






}

$pdf=new PDF('P','mm',array(245,128));

$pdf->SetTopMargin(0);
$pdf->SetLeftMargin(0);
    $pdf->SetAutoPageBreak(true, 0);
  
$pdf->AddMBFont(KOZMIN, 'EUC-JP');
$pdf->AddMBFont(PGOTHIC, 'EUC-JP');
$pdf->SetFont(KOZMIN, '', 30);
//$pdf->AddBig5Font();
$title='dfsd';
$header_title=array();
$pdf->Body($invoice_no,$addr_id);
$pdf->SetAuthor('');

$filepath=''.$invoice_no.'.pdf';
//$pdf->Output($filepath);
$pdf->Output();

?>
