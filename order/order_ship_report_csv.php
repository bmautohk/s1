<?php
	include_once('../security_check.php');
	include_once('../config.php');
	include_once('../functions.php');
	//include_once('order_list_logic.php');
	
	/** Include path **/
	//ini_set('include_path', ini_get('include_path').';../Classes/');
	
	/** PHPExcel */
	include '../Classes/PHPExcel.php';
	
	$sprod_no_list = $_POST['cb_sprod_no'];
	$gen_type = $_POST['gen_type'];
	
	$result = getShipReportData($group2, $user_name, $gen_type, $sprod_no_list);
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Superparts");

	$sheet = $objPHPExcel->setActiveSheetIndex(0);

	// Header
	$i = 0;
	$rowNo = 1;
	$sheet->setCellValueByColumnAndRow($i++, 1, 'Prod ID')
			->setCellValueByColumnAndRow($i++, 1, '材質')
			->setCellValueByColumnAndRow($i++, 1, '顏色')
			->setCellValueByColumnAndRow($i++, 1, 'Sale Group')
			->setCellValueByColumnAndRow($i++, 1, 'CLient Name')
			->setCellValueByColumnAndRow($i++, 1, 'Shipping Type')
			->setCellValueByColumnAndRow($i++, 1, 'Pyament Date')
			->setCellValueByColumnAndRow($i++, 1, 'Auction ID')
			->setCellValueByColumnAndRow($i++, 1, '配達日')
			->setCellValueByColumnAndRow($i++, 1, '配達時間')
			->setCellValueByColumnAndRow($i++, 1, 'Remark')
			->setCellValueByColumnAndRow($i++, 1, 'Tel.')
			->setCellValueByColumnAndRow($i++, 1, 'Post code')
			->setCellValueByColumnAndRow($i++, 1, 'Client Address 1')
			->setCellValueByColumnAndRow($i++, 1, 'Client Address 2')
			->setCellValueByColumnAndRow($i++, 1, 'Client Address 3');

	
	foreach ($result as $row) {
		$i = 0;
		$rowNo++;
		
		$sheet->setCellValueByColumnAndRow($i++, $rowNo, conv($row['sprod_id']))
			->setCellValueByColumnAndRow($i++, $rowNo, conv($row['sprod_material']))
			->setCellValueByColumnAndRow($i++, $rowNo, conv($row['sprod_colour']))
			->setCellValueByColumnAndRow($i++, $rowNo, conv($row['sale_group']))
			->setCellValueByColumnAndRow($i++, $rowNo, conv($row['sale_name']))
			->setCellValueByColumnAndRow($i++, $rowNo, $row['bal_ship_type'])
			->setCellValueByColumnAndRow($i++, $rowNo, $row['bal_dat'])
			->setCellValueByColumnAndRow($i++, $rowNo, conv($row['bal_ref']))
			->setCellValueByColumnAndRow($i++, $rowNo, conv($row['bal_delivery_date']))
			->setCellValueByColumnAndRow($i++, $rowNo, conv($row['bal_delivery_time']))
			->setCellValueByColumnAndRow($i++, $rowNo, conv($row['debt_remark']))
			->setCellValueByColumnAndRow($i++, $rowNo, conv($row['debt_tel']))
			->setCellValueByColumnAndRow($i++, $rowNo, conv($row['debt_post_co']))
			->setCellValueByColumnAndRow($i++, $rowNo, conv($row['debt_cust_address1']))
			->setCellValueByColumnAndRow($i++, $rowNo, conv($row['debt_cust_address2']))
			->setCellValueByColumnAndRow($i++, $rowNo, conv($row['debt_cust_address3']))
		;
			
	}
	
	// Redirect output to a client's web browser (Excel5)
	//header('Content-Type: application/vnd.ms-excel');
	header("Content-type:application/vnd.ms-excel;charset=euc");
	header('Content-Disposition: attachment;filename="shipping_report_'.$gen_type.'.xls"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
	
	
function getShipReportData($access, $user_name, $group3, $sprod_no_list) {
	if (sizeof($sprod_no_list) == 0) {
		return array();
	}
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);

	$query =
		"SELECT *
		FROM ben_sale
		join authorize on sale_group=username
		join ben_bal on sale_ref=bal_ref 
		left outer join ben_sale_prod on sprod_ref = sale_ref
		left outer join ben_debt on debt_ref = sale_ref
		where group3='$group3'
		and bal_ref not in (select check_ref from ben_check) ";
	
	$query .= ' and sprod_no in (0';
	foreach($sprod_no_list as $sprod_no) {
		$query .= ','.$sprod_no;
	}
	$query .= ') ';
	
	if ($access!=Admin_name) {
		$query .= " and sale_group='$user_name' ";
	}
	
	$query .= " order by bal_dat asc ";
	
	$result = mysql_query($query, $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);

	$data_list = array();
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$data = array();

		$data['bal_ref'] = $row["bal_ref"];
		$data['bal_delivery_date'] = $row["bal_delivery_date"];
		$data['bal_delivery_time'] = $row["bal_delivery_time"];
		$data['sale_group'] = $row["sale_group"];
		$data['sale_name'] = $row["sale_name"];
		$data['bal_ship_type'] = $row["bal_ship_type"];
		$data['sprod_id'] = $row["sprod_id"];
		$data['sprod_material'] = $row["sprod_material"];
		$data['sprod_colour'] = $row["sprod_colour"];
		$data['debt_remark'] = $row["debt_remark"];
		$data['debt_tel'] = $row["debt_tel"];
		$data['debt_post_co'] = $row["debt_post_co"];
		$data['debt_cust_address1'] = $row["debt_cust_address1"];
		$data['debt_cust_address2'] = $row["debt_cust_address2"];
		$data['debt_cust_address3'] = $row["debt_cust_address3"];

		$data_list[] = $data;
	}

	// Free resultset
	mysql_free_result($result);

	// Closing connection
	mysql_close($db);

	return $data_list;
}

	
?>
