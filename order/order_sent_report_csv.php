<?php
	include_once('../security_check.php');
	include_once('../config.php');
	include_once('../functions.php');
	include_once('order_sent_report_logic.php');
	
	/** Include path **/
	//ini_set('include_path', ini_get('include_path').';../Classes/');
	
	/** PHPExcel */
	include '../Classes/PHPExcel.php';
	
	$date_start = $_GET['date_start'];
	$date_end = $_GET['date_end'];
	$sale_name = $_GET['sale_name'];
	$sale_group = $_GET['sale_group'];
	$result = genCSVByDate($date_start,$date_end,$sale_name,$sale_group,$group2,$user_name);
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Superparts")
								 ->setLastModifiedBy("Superparts")
								 ->setTitle("Order Sent Report");


	$sheet = $objPHPExcel->setActiveSheetIndex(0);
	
	// Header
	$sheet->setCellValue('A1', 'Order No.')
			->setCellValue('B1', 'Sale Group')
			->setCellValue('C1', 'Prod ID')
			->setCellValue('D1', 'Total Price')
			->setCellValue('E1', 'Shipping Fee')
			->setCellValue('F1', 'Total')
			->setCellValue('G1', 'Total Cost (RMB)')
			->setCellValue('H1', 'Shipping Date')
			->setCellValue('I1', 'Tracking No.')
			->setCellValue('J1', 'ord_prod_price_total')
			->setCellValue('K1', 'ord_prod_cost_total')
			->setCellValue('L1', 'Status');

	if (!empty($result)) {
		foreach ($result as $key=>$order) {
			$rowNo = $key + 2;
			
			$sheet->setCellValue('A'.$rowNo, $order['check_ref'])
				->setCellValue('B'.$rowNo, convToUTF8($order['sale_group']))
				->setCellValue('C'.$rowNo, $order['sprod_id'])
				->setCellValue('D'.$rowNo, $order['product_price_total'])
				->setCellValue('E'.$rowNo, $order['sale_ship_fee'])
				->setCellValue('F'.$rowNo, $order['total'])
				->setCellValue('G'.$rowNo, $order['product_cost_total'])
				->setCellValue('H'.$rowNo, $order['check_date'])
				->setCellValue('I'.$rowNo, $order['check_shipping'])
				->setCellValue('J'.$rowNo, $order['ord_prod_price_total'])
				->setCellValue('K'.$rowNo, $order['ord_prod_cost_total'])
				->setCellValue('L'.$rowNo, $order['shipped_status']);
		}
	}
	/* $sheet->setCellValue('A1', 'Order No.')
	->setCellValue('B1', 'Sale Group')
	->setCellValue('C1', 'Total Cost (RMB)')
	->setCellValue('D1', 'Shipping Date')
	->setCellValue('E1', 'Tracking No.')
	->setCellValue('F1', 'Status');
	
	if (!empty($result)) {
		foreach ($result as $key=>$order) {
			$rowNo = $key + 2;
				
			$sheet->setCellValue('A'.$rowNo, $order['check_ref'])
			->setCellValue('B'.$rowNo, convToUTF8($order['sale_group']))
			->setCellValue('C'.$rowNo, $order['product_cost_total'])
			->setCellValue('D'.$rowNo, $order['check_date'])
			->setCellValue('E'.$rowNo, $order['check_shipping'])
			->setCellValue('F'.$rowNo, $order['shipped_status']);
		}
	} */

	// Redirect output to a client��s web browser (Excel5)
	//header('Content-Type: application/vnd.ms-excel');
	header("Content-type:application/vnd.ms-excel;charset=euc");
	header('Content-Disposition: attachment;filename="order_sent_report.xls"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
	
	function convToUTF8($str) {
		return iconv('euc-jp', "UTF-8", $str);
	}
	
// --------- For Debug -------------
	/*if (!empty($result)) {
		echo '<table>';
		foreach ($result as $key=>$order) {
			echo '<tr><td>'.$order['check_ref'].'</td><td>'.$order['sale_group'].'</td><td>'.$order['check_date'].'</td><td>'.$order['check_shipping'].'</td><td>'.$order['shipped_status'].'</td></tr>';
		}
		echo '</table>';
	}*/
	
?>
