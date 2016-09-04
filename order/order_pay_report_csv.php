<?php
	include_once('../security_check.php');
	include_once('../config.php');
	include_once('../functions.php');
	include_once('order_pay_report_logic.php');
	
	/** Include path **/
	//ini_set('include_path', ini_get('include_path').';../Classes/');
	
	/** PHPExcel */
	include '../Classes/PHPExcel.php';
	
	$date_start = $_GET['date_start'];
	$date_end = $_GET['date_end'];
	
	
	$result = genCSVByDate($date_start,$date_end,$group2,$user_name);
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
								 ->setLastModifiedBy("Maarten Balliauw")
								 ->setTitle("Office 2007 XLSX Test Document")
								 ->setSubject("Office 2007 XLSX Test Document")
								 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Test result file");


	$sheet = $objPHPExcel->setActiveSheetIndex(0);
	
	// Header
	$sheet->setCellValue('A1', 'Order No.')
			->setCellValue('B1', 'Sales Group.')
			->setCellValue('C1', 'Payment Date')
			->setCellValue('D1', 'Product ID')
			->setCellValue('E1', 'Price')
			->setCellValue('F1', 'Shipping')
			->setCellValue('G1', 'Total')
			->setCellValue('H1', 'Payment Amount');
	
	if (!empty($result)) {
		foreach ($result as $key=>$order) {
			$rowNo = $key + 2;
			
			$sheet->getStyle('B'.$rowNo)->getAlignment()->setWrapText(true);
			$sheet->getStyle('G'.$rowNo)->getAlignment()->setWrapText(true);
			$sheet->getStyle('L'.$rowNo)->getAlignment()->setWrapText(true);
			$sheet->getStyle('N'.$rowNo)->getAlignment()->setWrapText(true);
			
			$sheet->setCellValue('A'.$rowNo, conv($order['sale_ref']))
				->setCellValue('B'.$rowNo, conv($order['sale_group']))
				->setCellValue('C'.$rowNo, conv($order['bal_dat']))
				->setCellValue('D'.$rowNo, conv($order['sprod_id']))
				->setCellValue('E'.$rowNo, conv($order['cost_prod']))
				->setCellValue('F'.$rowNo, conv(($order['sale_ship_fee'])))
				->setCellValue('G'.$rowNo, conv(($order['cost_total'])))
				->setCellValue('H'.$rowNo, conv($order['bal_pay']));
				
			
	 
	 
		}
	}
	
	// Rename sheet
	//$objPHPExcel->getActiveSheet()->setTitle('Simple');
	
	
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	//$objPHPExcel->setActiveSheetIndex(0);
	
	
	// Redirect output to a client¡¦s web browser (Excel5)
	//header('Content-Type: application/vnd.ms-excel');
	header("Content-type:application/vnd.ms-excel;charset=euc");
	header('Content-Disposition: attachment;filename="order.xls"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
	
	
	
?>
