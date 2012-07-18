<?php
	include_once('../security_check.php');
	include_once('../config.php');
	include_once('../functions.php');
	include_once('order_list_logic.php');
	
	/** Include path **/
	//ini_set('include_path', ini_get('include_path').';../Classes/');
	
	/** PHPExcel */
	include '../Classes/PHPExcel.php';
	
	$date_start = $_GET['date_start'];
	$date_end = $_GET['date_end'];
	$status = $_GET['status'];
	$result = genCSVByDate($date_start,$date_end,$status,$group2,$user_name);
	
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
	$sheet->setCellValue('A1', 'Order date')
			->setCellValue('B1', 'Auction ID')
			->setCellValue('C1', 'Client Yahoo Id.')
			->setCellValue('D1', 'Group')
			->setCellValue('E1', 'Client email')
			->setCellValue('F1', 'Client Name')
			->setCellValue('G1', 'Note')
			->setCellValue('H1', 'Client\'s Payment Name')
			->setCellValue('I1', 'Price')
			->setCellValue('J1', 'Shipping')
			->setCellValue('K1', 'Total')
			->setCellValue('L1', 'Payment')
			->setCellValue('M1', 'Return')
			->setCellValue('N1', 'Shipping')
			->setCellValue('O1', 'Remark');
	
	if (!empty($result)) {
		foreach ($result as $key=>$order) {
			$rowNo = $key + 2;
			
			$sheet->getStyle('B'.$rowNo)->getAlignment()->setWrapText(true);
			$sheet->getStyle('G'.$rowNo)->getAlignment()->setWrapText(true);
			$sheet->getStyle('L'.$rowNo)->getAlignment()->setWrapText(true);
			$sheet->getStyle('N'.$rowNo)->getAlignment()->setWrapText(true);
			
			$sheet->setCellValue('A'.$rowNo, conv($order['sale_date']))
				->setCellValue('B'.$rowNo, conv($order['sale_edit'].chr(13).chr(10).$order['sale_yahoo_id'].'('.$order['sale_dat'].')'))
				->setCellValue('C'.$rowNo, conv($order['sale_yahoo_id']))
				->setCellValue('D'.$rowNo, conv($order['sale_group']))
				->setCellValue('E'.$rowNo, conv($order['sale_email']))
				->setCellValue('F'.$rowNo, conv(($order['sale_name'])))
				->setCellValue('G'.$rowNo, conv(($order['debt_data'])))
				->setCellValue('H'.$rowNo, conv($order['debt_pay_name']))
				->setCellValue('I'.$rowNo, conv($order['cost_prod']))
				->setCellValue('J'.$rowNo, conv($order['sale_ship_fee']))
				->setCellValue('K'.$rowNo, conv($order['cost_total']))
				->setCellValue('L'.$rowNo, conv($order['bal_data']))
				->setCellValue('M'.$rowNo, conv($order['return_data']))
				->setCellValue('N'.$rowNo, conv($order['ship_data']))
				->setCellValue('O'.$rowNo, conv($order['remark']));
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
