<?php
	include_once('../security_check.php');
	include_once('../config.php');
	include_once('../functions.php');
	include_once('report_group_logic.php');
	
	/** Include path **/
	//ini_set('include_path', ini_get('include_path').';../Classes/');
	
	/** PHPExcel */
	include '../Classes/PHPExcel.php';
	
	$date_start = $_GET['date_start'];
	$date_end = $_GET['date_end'];
	
	// Generate summary
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	$jpRate = getExchangeRate($db);
	
	$result = getSummary($date_start, $date_end, $jpRate, $db);
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Superparts")
								 ->setLastModifiedBy("Superparts")
								 ->setTitle("Group Order Report");

	$sheet = $objPHPExcel->setActiveSheetIndex(0);

	// Header
	$i = 0;
	$sheet->setCellValueByColumnAndRow($i++, 1, 'Group ')
			->setCellValueByColumnAndRow($i++, 1, 'Top Sale')
			->setCellValueByColumnAndRow($i++, 1, 'Total Sale')
			->setCellValueByColumnAndRow($i++, 1, 'Cost (RMB)')
			->setCellValueByColumnAndRow($i++, 1, 'Sale')
			->setCellValueByColumnAndRow($i++, 1, 'Discount')
			->setCellValueByColumnAndRow($i++, 1, 'Shipping fee')
			->setCellValueByColumnAndRow($i++, 1, 'Tax')
			->setCellValueByColumnAndRow($i++, 1, 'Balance')
			->setCellValueByColumnAndRow($i++, 1, 'Return')
			->setCellValueByColumnAndRow($i++, 1, 'Top Cost')
			->setCellValueByColumnAndRow($i++, 1, 'Cost %')
			->setCellValueByColumnAndRow($i++, 1, 'Top GP')
			->setCellValueByColumnAndRow($i++, 1, 'GP');
	
	if (!empty($result)) {
		$rowNo = 2;
		foreach ($result as $item) {
			$i = 0;
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, conv($item['sale_group']))
				->setCellValueByColumnAndRow($i++, $rowNo, $item['top_sale'])
				->setCellValueByColumnAndRow($i++, $rowNo, $item['total_sale'])
				->setCellValueByColumnAndRow($i++, $rowNo, $item['cost_rmb'])
				->setCellValueByColumnAndRow($i++, $rowNo, $item['sale'])
				->setCellValueByColumnAndRow($i++, $rowNo, $item['sale_discount'])
				->setCellValueByColumnAndRow($i++, $rowNo, $item['sale_ship_fee'])
				->setCellValueByColumnAndRow($i++, $rowNo, $item['sale_tax'])
				->setCellValueByColumnAndRow($i++, $rowNo, $item['balance'])
				->setCellValueByColumnAndRow($i++, $rowNo, $item['return'])
				->setCellValueByColumnAndRow($i++, $rowNo, $item['top_cost'])
				->setCellValueByColumnAndRow($i++, $rowNo, number_format($item['cost_percentage'], 6))
				->setCellValueByColumnAndRow($i++, $rowNo, $item['top_gp'])
				->setCellValueByColumnAndRow($i++, $rowNo, $item['gp']);
			
			$rowNo++;
		}
	}
	
	header("Content-type:application/vnd.ms-excel;charset=euc");
	header('Content-Disposition: attachment;filename="group_order_report.xls"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>
