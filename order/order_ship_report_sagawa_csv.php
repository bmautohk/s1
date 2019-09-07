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
	$exportCSVonly=$_POST['exportCSVonly'];
	
	$result = getShipReportData($group2, $user_name, $gen_type, $sprod_no_list,$exportCSVonly);
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Superparts");

	$sheet = $objPHPExcel->setActiveSheetIndex(0);

	// Header
	$i = 0;
	$rowNo = 0;
	/*$sheet->setCellValueByColumnAndRow($i++, 1, 'A')
		->setCellValueByColumnAndRow($i++, 1, 'Tel.')
		->setCellValueByColumnAndRow($i++, 1, 'Post code')
		 
			->setCellValueByColumnAndRow($i++, 1, 'Client Address 1')
			->setCellValueByColumnAndRow($i++, 1, 'Client Address 2')
			->setCellValueByColumnAndRow($i++, 1, 'Client Address 3')
			->setCellValueByColumnAndRow($i++, 1, 'CLient Name')
			->setCellValueByColumnAndRow($i++, 1, 'Auction ID')
			->setCellValueByColumnAndRow($i++, 1, 'Sale Group')
			
		 
*/
	$chkDupSaleRef=array();
	foreach ($result as $row) {
		
		//ignore duplicate invoice no csv output 20180610
		if (!in_array($row['bal_ref'],$chkDupSaleRef)){
				
		$i = 0;
		$rowNo++;
			
		 
		$type = PHPExcel_Cell_DataType::TYPE_STRING;
		$sheet->setCellValueByColumnAndRow($i++, $rowNo,  conv(substr($row['sale_group'],0,12)));   //A
		$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit(conv($row['debt_tel']),$type);  //B
		$sheet->setCellValueByColumnAndRow($i++, $rowNo, conv($row['debt_post_co']));  //C
		$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit(conv($row['debt_cust_address1']),$type);  //D
		$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit(conv($row['debt_cust_address2']),$type);  //E
		$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit(conv($row['debt_cust_address3']),$type);  //F
		$sheet->setCellValueByColumnAndRow($i++, $rowNo, conv($row['sale_name']))  //G
		->setCellValueByColumnAndRow($i++, $rowNo, conv($row['sale_name'])); //H
		$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit(conv($row['bal_ref']),$type);  //I
		$sheet->setCellValueByColumnAndRow($i++, $rowNo,"")  //J
			->setCellValueByColumnAndRow($i++, $rowNo, "")  //K
			->setCellValueByColumnAndRow($i++, $rowNo, "")  //L
			->setCellValueByColumnAndRow($i++, $rowNo, "") //M
			->setCellValueByColumnAndRow($i++, $rowNo, "594-0073")  //N
			->setCellValueByColumnAndRow($i++, $rowNo, "大阪府和泉市和気町") //O
			->setCellValueByColumnAndRow($i++, $rowNo, "3-2-12") //P
			->setCellValueByColumnAndRow($i++, $rowNo, "和気発送センター")  //Q
			->setCellValueByColumnAndRow($i++, $rowNo, "");  //R
			$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit('001', $type);//S
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, checkStr16(conv($row['sprod_id']))) //T
			->setCellValueByColumnAndRow($i++, $rowNo, $row['sprod_name']);  //U
			if ($row['bal_dat']!=null){
				$sheet->setCellValueByColumnAndRow($i++, $rowNo, conv($row['sprod_unit']).' '.date("(d/M)", strtotime($row['bal_dat'])));  //V  $data['debt_dat']
			}else{
				$sheet->setCellValueByColumnAndRow($i++, $rowNo, conv($row['sprod_unit']).' ');  //V  $data['debt_dat']
			}
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, conv($row['sprod_material'])."".conv($row['sprod_colour'])) //W
			->setCellValueByColumnAndRow($i++, $rowNo, str_replace("\r",str_replace("\n",conv($row['debt_remark'])))) //X
			//->setCellValueByColumnAndRow($i++, $rowNo,conv($row['debt_remark'])) //X
			->setCellValueByColumnAndRow($i++, $rowNo, "1");  //Y
			$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit('000', $type);  //Z
			$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit('001', $type); //AA
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, str_replace('-','',$row['bal_delivery_date']));
			$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit(toSugawaTime($row['bal_delivery_time_option_id']),$type); //AC
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, "") //AD
			->setCellValueByColumnAndRow($i++, $rowNo, "")  //AE
			->setCellValueByColumnAndRow($i++, $rowNo, "");  //AF
			$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit('1', $type);  //AG
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, "");  //AH
			$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit('0', $type);  //AI
			$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit('011', $type);  //AJ
			$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit(checkSugawaTime("007", toSugawaTime($row['bal_delivery_time_option_id'])), $type);    //AK
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, checkSugawaTime("", toSugawaTime($row['bal_delivery_time_option_id'])));   //AL
			$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit('0', $type); //AM
			$sheet->getCellByColumnAndRow($i++, $rowNo)->setValueExplicit('0', $type); //AN
			$sheet->setCellValueByColumnAndRow($i++, $rowNo, "") //AO
			->setCellValueByColumnAndRow($i++, $rowNo, "1") //AP
			//->setCellValueByColumnAndRow($i++, $rowNo, $row['bal_ship_type'])
			//->setCellValueByColumnAndRow($i++, $rowNo, $row['bal_dat'])
			 
		;
	
		
	
			if($exportCSVonly!="true"){
			//update ben_check check_dat to 0000-00-00
			 $sql = "insert into ben_check (check_ref, check_dat, check_date,created_date) values ('".$row['bal_ref']."', '0000-00-00', '0000-00-00',DATE_ADD(NOW(), INTERVAL 1 HOUR)) ";
			sqlinsert($sql);
			$chkDupSaleRef[]=$row['bal_ref'];
			}
		}
	}
	
	// Redirect output to a client's web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	//header('Content-type: text/csv');
	//header("Content-type:application/vnd.ms-excel;charset=shift-js");
	header('Content-Disposition: attachment;filename="shipping_report_'.$gen_type.'.xls"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	//$objWriter->setEnclosure('');
	$objWriter->save('php://output');
	
	exit;

	
function checkStr16($a){		
	
	if (strlen($a)>16){
		
		$a=subStr($a,0,14)."等";
	}

	return $a;
}
	
function checkGroupEmpty($a){	

	if ($a=="")
		return '1';
}
	
function checkSugawaTime($a,$b){
	if ($b !=""){
		return $a;
	}else{
		return "";
	}
	return "";
}
function toSugawaTime($a)	{
	if($a=='1'){
		return "01";
	}
	if($a=='2'){
		return "12";
	}
	if($a=='3'){
		return "14";
	}
	if($a=='4'){
		return "16";
	}
	if($a=='5'){
		return "04";
	}
	
	if($a=='6'){
		return "04";
	}
	
	return "";
}
	
function getShipReportData($access, $user_name, $group3, $sprod_no_list,$exportCSVonly) {
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
		where group3 like '$group3'";
		
		if ($exportCSVonly!='true')
		$query.=" and bal_ref not in (select check_ref from ben_check) ";
	
	$query .= ' and sprod_no in (0';
	foreach($sprod_no_list as $sprod_no) {
		$query .= ','.$sprod_no;
	}
	$query .= ') ';
	
	if ($access!=Admin_name) {
		$query .= " and sale_group='$user_name' ";
	}
	
	//20180826
	//$query .= " order by bal_dat asc ";
	$query .= " order by sprod_id asc ";
	
	//echo $query;
	$result = mysql_query($query, $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);

	$data_list = array();
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);

		$data = array();

		$subResult=getCorrespondingItems($row["bal_ref"],$row["sprod_no"]);
		
		$data['bal_ref'] = $row["bal_ref"];
		$data['bal_delivery_date'] = $row["bal_delivery_date"];
		$data['bal_delivery_time'] = $row["bal_delivery_time"];
		$data['sale_group'] = $row["sale_group"];
		$data['sale_name'] = $row["sale_name"];
		$data['bal_ship_type'] = $row["bal_ship_type"];
		$data['sprod_id'] = $subResult["prod_id_arr_str"];
		$data['sprod_material'] = $row["sprod_material"];
		$data['sprod_colour'] = $row["sprod_colour"];
		$data['debt_remark'] = $row["debt_remark"];
		$data['debt_tel'] = $row["debt_tel"];
		$data['debt_post_co'] = $row["debt_post_co"];
		$data['debt_cust_address1'] = $row["debt_cust_address1"];
		$data['debt_cust_address2'] = $row["debt_cust_address2"];
		$data['debt_cust_address3'] = $row["debt_cust_address3"];
		$data['sprod_name'] = $subResult["prod_name_arr_str"];
		$data['sprod_unit'] = $subResult["sprod_unit"];
		$data['bal_delivery_time_option_id'] = $row['bal_delivery_time_option_id'];
		$data['bal_dat']=$row['bal_dat'];

		$data_list[] = $data;
	}

	// Free resultset
	mysql_free_result($result);

	// Closing connection
	mysql_close($db);

	return $data_list;
}

function getCorrespondingItems($saleRef,$excludeItemPK) {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$query ="SELECT sprod_id,sprod_name,sprod_unit from ben_sale_prod where sprod_ref='".$saleRef."' ";
	$result = mysql_query($query, $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	
	$data = array();
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		if ($i==0){
		$data['prod_id_arr_str'].=$row["sprod_id"];
		$data['prod_name_arr_str'].=conv($row["sprod_name"]);	
		$data['sprod_unit'].=$row["sprod_unit"];
		}else if ($i==1){
		$data['prod_id_arr_str'].="+".$row["sprod_id"];
		$data['prod_name_arr_str'].="等";
		$data['sprod_unit'].="+".$row["sprod_unit"];
		}else{
		$data['prod_id_arr_str'].="+".$row["sprod_id"];	
		$data['sprod_unit'].="+".$row["sprod_unit"];
		}
	}
		mysql_free_result($result);
		mysql_close($db);
		return $data;
}	
?>
