<?php
ini_set("memory_limit","90M");

require('../config.php');
require('../functions.php');
require('../security_check.php');

require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator('Superparts');
$pdf->SetAuthor('Superparts');
$pdf->SetTitle('Invoice');
$pdf->SetSubject('Invoice');

// Remove header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// set font
//$pdf->SetFont('dejavusans', '', 10);
//$pdf->SetFont('msungstdlight', '', 10);
$pdf->SetFont('rcjfontpgothic', '', 10);

// -------------------------------------------------------------------
$db=connectDatabase();
mysql_select_db(DB_NAME,$db);

$isGenPDF = true;
if (isset($isDebug)) {
	$isGenPDF = false;
}

$shippingCost = 0;
if (isset($delivery_cost) && is_numeric($delivery_cost)) {
	$shippingCost = $delivery_cost;
}

$saleOrders = getSaleOrder($db, $_GET['date_start'], $_GET['date_end'], $_GET['sale_name'], $_GET['sale_group'], $group2, $user_name);

if (sizeof($saleOrders) == 0) {
	// No order is found
	
	// add a page
	$pdf->AddPage();
	
	$htmlText = "<h1>No order!</h1>";
	
	if ($isGenPDF) {
		$pdf->writeHTML($style.$htmlText, true, false, true, false, '');

		// reset pointer to the last page
		$pdf->lastPage();
	}
	else {
		echo $htmlText;
	}
}
else {
	$style = '
			<style>
			.title {
				font-size:18pt;
				text-align:center;
				background-color:#C0C0C0;
				font-weight:bold;
			}
			
			.client_name {
				font-size:16pt;
			}
			
			.address1 {
				font-size:18pt;
				font-weight:bold;
			}
			
			.address2 {
				font-size:8pt;
				text-align:right;
			}
	
			.bank_address {
				font-size:14pt;
			}
			
			.product_table {
				text-align:center;
				width:100%;
				font-size:10pt;
			}
			
			.summary_table {
				text-align:center;
				width:100%;
				font-size:12pt;
			}
			
			.clear {
				clear: both;
			}
			</style>
			';
	
	foreach ($saleOrders as $order) {
		// add a page
		$pdf->AddPage();
		
		// init
		$count = 1;
		$total = 0;
		
		// Content		
		$htmlText = '<div class="title">請求書</div>';
	
		// Client name
		$htmlText .= '<div class="client_name">'.conv($order['sale_name']).'様</div>';
	
		// Order & Date
		 //$htmlText .= '<div style="float:right">
		$htmlText .= '<table>
				<tr><td align="right" width="82%">No.</td><td width="3%"></td><td width="15%" style="border-bottom:1px solid black">'.$order['sale_ref'].'</td></tr>
				<tr><td align="right">Date:</td><td></td><td style="border-bottom:1px solid black">'.date('Y/m/d').'</td></tr>
			</table>
		';
		/* $htmlText .= '
			<table border="1">
				<tr><td align="right"  width="90%">No.</td><td  width="10%">'.$order['sale_ref'].'</td></tr>
				<tr><td align="right">Date:</td><td>'.date('Y/m/d').'</td></tr>
			</table>
		'; */
	
		// Client's address
		/* $htmlText .= '<div class="address1">〒596-0078<br>
		大阪府岸和田市南上町2-22-20<br>
		072-479-9577'; */
		$htmlText .= '<div class="address1">';
		if (!empty($order['debt_cust_address1'])) $htmlText .= conv($order['debt_cust_address1']).'<br>';
		if (!empty($order['debt_cust_address2'])) $htmlText .= conv($order['debt_cust_address2']).'<br>';
		if (!empty($order['debt_cust_address3'])) $htmlText .= conv($order['debt_cust_address3']);
		$htmlText .= '</div>';
		
		// Superparts's address
		$htmlText .= '<div class="address2">BM AUTO ACCESSIORS CO., LTD<br>
		HONG KONG OFFICE<br>
		Unit B , 19/F , Success Ind. Bldg.,<br>
		Sheung Hei St., San Po Kong<br>
		Tel:(852)23288875 / Fax: (852)23288150</div>';
		
		$htmlText .= '<div style="font-size:14pt">下記請求金額について、全て国際送料込みと税込みです。</div>';
		
		// Product
		$w = array(5, 45, 5, 5, 15, 15, 10); // Table column width
		$time = strtotime($order['sale_date']);
		$products = getProduct($db, $order['sale_ref']);
		$htmlText .= '<table border="1" align="center" cellpadding="1">';
		$htmlText .= '<tr bgcolor="#C0C0C0"><th width="'.$w[0].'%"></th><th width="'.$w[1].'%">商品名</th><th width="'.$w[2].'%">数量</th><th width="'.$w[3].'%">単位</th><th width="'.$w[4].'%">単価(RMB)</th><th width="'.$w[5].'%">合計(RMB)</th><th width="'.$w[6].'%">備考</th></tr>';
		$htmlText .= '<tr><td></td><td align="left">'.date('m', $time).'月'.date('d', $time).'日　納品分</td><td></td><td></td><td></td><td></td><td></td></tr>';
		foreach ($products as $product) {
			$subTotal = $product['sprod_price'] * $product['sprod_unit'] ;
			$total += $subTotal;
			
			$htmlText .= '<tr><td>'.$count.'</td><td align="left">'.conv($product['sprod_name']).'</td><td>'.$product['sprod_unit'].'</td><td>SET</td><td>'.priceFormat($product['sprod_price']).'</td><td>'.priceFormat($subTotal, 0).'</td><td></td></tr>';
			$count++;
		}
		$htmlText .= '<tr><td></td><td align="left">トラック便（円）</td><td></td><td></td><td></td><td></td><td>'.priceFormat($shippingCost).'</td></tr>
		</table>
		<br>';
		
		// Summary
		$totalIncludeTax = $total * (1 + $order['sale_tax']/100.0);
		$finalTotal = $totalIncludeTax + $shippingCost;
		
		$htmlText .= '<table class="summary_table">
			<tr><td width="'.($w[0]+$w[1]+$w[2]+$w[3]).'%"></td><td width="'.$w[4].'%" align="right" bgcolor="#C0C0C0">RMB合計：</td><td width="'.$w[5].'%" style="border-bottom:1px solid black">'.priceFormat($total).'</td><td width="'.$w[6].'%"></td></tr>
			<tr><td></td><td align="right" bgcolor="#C0C0C0">レート：'.$order['sale_tax'].'</td><td>'.priceFormat($totalIncludeTax).'</td></tr>
			<tr><td></td><td align="right">送料：</td><td>'.priceFormat($shippingCost).'</td><td align="left">円</td></tr>
			<tr><td></td><td align="right">日本円合計：</td><td style="border-bottom:1px solid black">'.priceFormat($finalTotal).'</td><td align="left">円</td></tr>
			<tr><td></td><td align="right"></td><td></td></tr>
		</table>';
		
		// Bank Address
		$htmlText .='<div class="bank_address">振込み先<br>
		ジャパンネット銀行   スズメ支店 （002）<br>
		普通預金 　1276161<br>
		名義： リン　エンブン</div>';
		
		if ($isGenPDF) {
			$pdf->writeHTML($style.$htmlText, true, false, true, false, '');
		
			// reset pointer to the last page
			$pdf->lastPage();
		}
		else {
			echo $htmlText;
		}
	}
}
mysql_close($db);
// -------------------------------------------------------------------

//Close and output PDF document
if ($isGenPDF) {
	$pdf->Output('invoice.pdf', 'I');
}

function priceFormat($num) {
	return number_format($num, 0);
}

function getSaleOrder($db, $date_start,$date_end,$sale_name,$sale_group,$access,$user_name)
{
	$sql = "SELECT * FROM ben_check join ben_sale on check_ref=sale_ref
	left outer join ben_debt on debt_ref = sale_ref
	where DATE(check_date) between '$date_start' and '$date_end' ";

	if (isset($sale_name) && $sale_name != '') {
		$sale_name = trim($sale_name);
		$sql = $sql."and sale_name like '%$sale_name%' ";
	}

	if ($access==Admin_name) {
		if (isset($sale_group) && $sale_group != '') {
			$sale_group = trim($sale_group);
			$sql = $sql."and sale_group like '%$sale_group%' ";
		}
	}
	else {
		$sql = $sql."and sale_group = '$user_name' ";
	}

	$sql = $sql."order by check_date desc, check_ref";
	$result = mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $sql");

	$num_results=mysql_num_rows($result);
	//loop
	$saleOrders = array();
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		$order = array();
		$order['sale_ref'] = $row['sale_ref'];
		$order['sale_name'] = $row['sale_name'];
		$order['sale_date'] = $row['sale_date'];
		//$order['sale_ship_fee'] = $row['sale_ship_fee'];
		$order['sale_tax'] = $row['sale_tax'];
		$order['debt_cust_address1'] = $row['debt_cust_address1'];
		$order['debt_cust_address2'] = $row['debt_cust_address2'];
		$order['debt_cust_address3'] = $row['debt_cust_address3'];
		$saleOrders[] = $order;
	}
	//end loop
	
	mysql_free_result($result);
	
	return $saleOrders;
}

function getProduct($db, $sale_ref) {
	$sql = "SELECT * FROM ben_sale_prod where sprod_ref = '".$sale_ref."' order by sprod_name ";
	$result = mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	//loop
	$products = array();
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		$product = array();
		$product['sprod_name'] = $row['sprod_name'];
		$product['sprod_price'] = $row['sprod_price'];
		$product['sprod_unit'] = $row['sprod_unit'];
		$products[] = $product;
	}
	//end loop
	
	mysql_free_result($result);
	
	return $products;
}

?>