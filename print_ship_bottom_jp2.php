<?php
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);
session_cache_limiter();
session_start();
require('config.php');  //this should the the absolute path to the config.php file 
require('functions.php'); //this should the the absolute path to the functions.php file - see the instrcutions for config.php above
if (allow_access(@Administrators) != "yes"){ //this is group name or username of the group or person that you wish to allow access to{                                                            // - please be advise that the Administrators Groups has access to all pages.
	include ('no_access.html'); //this should the the absolute path to the no_access.html file - see above
exit;
}

$invoice_no = $_GET['sale_ref']; 
define('FPDF_FONTPATH','./pdf/font/');
//require('pdf/chinese.php');
require('pdf/mbfpdf.php');
class PDF extends MBFPDF
{

var $col=0;
//Ordinate of column start
var $y0;
var $header_title=array();

function Set_header_title($header_title)
{
	$this->header_title=$header_title;
}
function Body($invoice_no)
{
  $debt_row=getdebt_data($invoice_no);

	$order_row=getsale_data($invoice_no);

	$ship_row= getship_data($invoice_no);
	$prod_row= getsprod_data($invoice_no);
	
	$sprod_price=$prod_row["sprod_price"];
	$sprod_unit=$prod_row["sprod_unit"];
	$sprod_sub=$sprod_price*$sprod_unit;
	
	$sub_total = number_format($sub_total + $sprod_sub,2,'.','');	
	$sale_discount=$order_row["sale_discount"];
	$sale_ship_fee=$order_row["sale_ship_fee"];
	$sale_tax=$order_row["sale_tax"];
	$total = number_format($sub_total-$sale_discount,2,'.','');
	$total_tax =$total * $sale_tax / 100; 
	$total_tax = number_format(round($total_tax, 0),2,'.','');
	$total = number_format($total + $sale_ship_fee + total_tax,2,'.','');
	


 $this->SetY(-2);
 
   $this->SetTextColor(0,0,0);
 
  $border=1;
  

	
	$this->SetFont(KOZMIN, '', 30);
	    

	
   $this->Cell(193,8,'1234567',$border,1,'R',0);
   $this->Cell(193,8,'1234567',$border,1,'R',0);
   $this->Cell(193,8,'1234567',$border,1,'R',0);
   $this->SetFont(KOZMIN, '',12);
	$this->Cell(173,8,"",$border,0,'R',0);
	$this->Cell(20,8,"x",$border,1,'L',0);

  $this->SetFont(KOZMIN, '',40);
	$this->Cell(30,8,"",$border,0,'R',0);
	$this->Cell(100,8,$debt_row['debt_post_co'],$border,0,'L',0);
	$this->Cell(40,8,"",$border,1,'C',0);
$this->SetFont(KOZMIN, '',12);
	$this->Ln(3);
	$this->Cell(30,8,"",$border,0,'R',0);
	$this->Cell(100,8,$debt_row['debt_cust_address1'],$border,0,'L',0);
	$this->Cell(40,8,"",$border,1,'C',0);

	$this->Cell(30,8,"",$border,0,'R',0);
	$this->Cell(100,8,$debt_row['debt_cust_address2'],$border,0,'L',0);
	$this->Cell(50,8,"",$border,1,'C',0);
	$this->Ln(8);
 	$this->Cell(35,8,"",$border,0,'R',0);
	$this->Cell(80,8,$order_row['sale_name'],$border,0,'L',0);
	$this->Cell(5,8,"",$border,1,'C',0);
	
	$tel=0;
	 if ($debt_row['debt_tel']!='' or $debt_row['debt_mobile']!='') 
	 {
	 	$tel ="Tel:". $debt_row['debt_tel']." ". $debt_row['debt_mobile'];
	 }
	 	
 	$this->Cell(35,8,"",$border,0,'R',0);
	$this->Cell(100,8,$tel,$border,0,'L',0);
	$this->Cell(5,8,"",$border,1,'C',0);

	 
 

 	
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
	 
	$this->Ln(24);
 
}

function Footer()
{
	//Page footer
	$this->SetY(-5);
 
	//$this->SetTextColor(128);
	//$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}






}

$pdf=new PDF('P','mm',array(245,128));
$pdf->SetTopMargin(0);
$pdf->SetLeftMargin(0);
$pdf->AddMBFont(KOZMIN, 'EUC-JP');
$pdf->AddMBFont(PGOTHIC, 'EUC-JP');
$pdf->SetFont(KOZMIN, '', 30);
//$pdf->AddBig5Font();
$title='¥X³f³æ';
$header_title=array();
$pdf->Body($invoice_no);
$pdf->SetAuthor('YRT Company Limited');

$filepath=''.$invoice_no.'.pdf';
//$pdf->Output($filepath);
$pdf->Output();

?>