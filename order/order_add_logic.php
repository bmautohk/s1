
<?
include_once('order_functions.php');
	
/** Include path **/
//ini_set('include_path', ini_get('include_path').';../Classes/');

/** PHPExcel */
include 'Classes/PHPExcel.php';

$db=connectDatabase();
mysql_select_db(DB_NAME,$db);

$order_success = '';
$error_message = '';

$import = false;
$import_success = false;

//get sale order
if (isset($_GET['sale_ref']))
{$sale_ref = trim($_GET['sale_ref']);}

//get Number of product
if (isset($_GET['prod_n'])) {
	$prod_n =trim($_GET['prod_n']);
} else {
	$prod_n=DEFAULT_NO_OF_PRODUCT;
}

$sale_order_no_message = '';
if (isset($_GET['mod'])) {
	if ($_GET['mod']=='same_ref')
		$sale_order_no_message = "<font color=red>Please, insert different Order No.</font>";
}

// add new order
if (isset($_POST['importYahoo']) || isset($_POST['importYahooShopping']) || isset($_POST['importRakuten'])) {
	$import = true;
	$isValid = true;
	
	$file_name = $_FILES["updOrderFile"]["tmp_name"];
	$actual_file_name = $_FILES["updOrderFile"]["name"];
	if (empty($file_name)) {
		$isValid =false;
		$import_success = false;
		$error_message = 'Please select file.';
	}
	
	if ($isValid) {
		$salesGroup = $_SESSION[user_name];
		
		if (isset($_POST['importYahoo'])) {
			$import_success = importYahoo($db, $file_name, $actual_file_name, $salesGroup);
		} else if (isset($_POST['importYahooShopping'])) {
			$import_success = importYahooShopping($db, $file_name, $actual_file_name, $salesGroup);
		} else if (isset($_POST['importRakuten'])) {
			$import_success = importRakuten($db, $file_name, $actual_file_name, $salesGroup);
		}
	}
	
} else if (isset($_POST['isorder']) and !isset($_GET['mod'])) {
	if (isset($_POST['prod_n']))
		$prod_n = trim($_POST['prod_n']); 
	//check sale order no, same order no
	
	if (isset($_POST['sale_ref_a'])) {
		if ($_POST['sale_ref_a']=="a") {
			$sale_chk_ref = 0;
			$sale_ref=trim($_POST['sale_ref_aa']);
			if (getsale_data($sale_ref)!='') {
				echo "<html><meta http-equiv=\"refresh\" content=\"0;url=".$_SERVER['PHP_SELF']."?page=".$page."&subpage=".$subpage."&mod=same_ref\"></html>";
				exit;
			}
		}
		
		if 	($_POST['sale_ref_a']=="b") {
			$sale_chk_ref = 1;
			$sale_ref=trim($_POST['sale_ref_bb']);
		}
	}
	//insert record
	if ($_POST['sale_ship_fee']!='') {$sale_ship_fee = trim($_POST['sale_ship_fee']);} else {$sale_ship_fee = 0;}
	if ($_POST['sale_discount']!='') {$sale_discount = trim($_POST['sale_discount']);} else {$sale_discount = 0;}
	if ($_POST['sale_tax']!='') {$sale_tax = trim($_POST['sale_tax']);} else {$sale_tax = 0;}
	
	$sql = "INSERT INTO ben_sale SET
		sale_ref = '$sale_ref',
		sale_date = '".trim($_POST['orderdate'])."',
		sale_group = '".trim($_POST['sale_group'])."',
		sale_email = '".trim($_POST['sale_email'])."',
		sale_name = '".trim($_POST['sale_name'])."',
		sale_yahoo_id = '".trim($_POST['sale_yahoo_id'])."',
		sale_dat = curdate(), 
		sale_chk_ref = $sale_chk_ref,
		sale_ship_fee = ".$sale_ship_fee.",
		sale_discount = ".$sale_discount.",
		sale_tax = ".$sale_tax;
	sqlinsert($sql);
	
	//insert product
	for ($k=1;$k<=$prod_n;$k++)
	{
		$sprod_id = "sprod_id_".$k;
		$sprod_name = "sprod_name_".$k;
		$sprod_material = "sprod_material_".$k;
		$sprod_colour = "sprod_colour_".$k;
		$sprod_price = "sprod_price_".$k;
		$sprod_unit = "sprod_unit_".$k;
		
		
		$sprod_material = '';
		if (isset($_POST['sprod_material_option_'.$k])) {
			foreach ($_POST['sprod_material_option_'.$k] as $material) {
				if ($sprod_material == '') {
					$sprod_material = $material;
				} else {
					$sprod_material .= ', '.$material;
				}
			}
		}
		
		$other = trim($_POST['sprod_material_'.$k]);
		if (!empty($other)) {
			if ($sprod_material == '') {
				$sprod_material = $other;
			} else {
				$sprod_material .= ', '.$other	;
			}
		}
		
		if (empty($_POST['sprod_colour_option_'.$k])) {
			// Other
			$sprod_color = trim($_POST['sprod_colour_'.$k]);
		} else {
			// Dropdown
			$sprod_color = $_POST['sprod_colour_option_'.$k];
		}
		
		
		$sqla = "INSERT INTO ben_sale_prod SET
			sprod_ref = '$sale_ref',
			sprod_id = '".trim($_POST[$sprod_id])."',
			sprod_name = '".trim($_POST[$sprod_name])."',
			sprod_material = '".$sprod_material."',
			sprod_colour = '".$sprod_color."',
			sprod_price = ".trim($_POST[$sprod_price]).", 
			sprod_unit = ".trim($_POST[$sprod_unit]); 
		
		sqlinsert($sqla);
	}
	
	// Insert debt note
	if (!empty($cust_cd)) {
		$query = "SELECT * FROM customer WHERE cust_cd = '$cust_cd' ";
		$result = mysql_query($query ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
		
		$customer = mysql_fetch_array($result);
	
		// Free resultset
		mysql_free_result($result);
		
		$sql = "INSERT INTO ben_debt SET
				debt_ref='$sale_ref',
				debt_tel='".$customer['cust_tel']."',
				debt_cust_address1='".$customer['cust_post_address1']."',
				debt_cust_address2='".$customer['cust_post_address2']."',
				debt_post_co='".$customer['cust_post_cd']."' ";
		sqlinsert($sql);
	}
	
	$order_success = 1;
}

// Get customer
$query = "SELECT cust_cd, cust_company_name FROM customer order by cust_company_name ";
$result = mysql_query($query ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
$num_results=mysql_num_rows($result);

$customers = array();
for ($i=0;$i<$num_results;$i++){
	$row=mysql_fetch_array($result);
	$customers[] = $row;
}

// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($db);



function importYahoo($db, $file_name, $actual_file_name, $salesGroup) {
	global $error_message;
	
	$objPHPExcel = getExcelReader($file_name, $actual_file_name);
	
	$result = array();
	$orderNoSet = array();
	$ws = $objPHPExcel->getSheet(0);
	foreach ($ws->getRowIterator() as $row) {
		$rowNo = $row->getRowIndex();
		if ($rowNo == 1) {
			// Skip 1st row (i.e. header)
			continue;
		}

		$order = array();
		$product = array();
		$debt = array();

		// Order
		$order['sale_ref'] = trim($ws->getCell("A".$rowNo)->getValue());
		$order['order_date'] = date('Y-m-d');
		//$order['sale_group'] = $salesGroup;
		$order['sale_group'] = $ws->getCell("B".$rowNo)->getValue();
		$order['sale_name'] = convert($ws->getCell("K".$rowNo)->getValue());
		$order['sale_ship_fee'] = $ws->getCell("AE".$rowNo)->getValue();
		if ($order['sale_ship_fee'] == '－') {
			$order['sale_ship_fee'] = 0;
		}

		$order['sale_email'] = $ws->getCell("AI".$rowNo)->getValue();
		$order['sale_yahoo_id'] = $ws->getCell("AJ".$rowNo)->getValue();
		$order['sale_chk_ref'] = 0; // Yahoo
		$order['sale_discount'] = 0;
		$order['sale_tax'] = 0;

		// Product
		$product['sale_ref'] = $order['sale_ref'];
		$product['sprod_id'] = $ws->getCell("D".$rowNo)->getValue();
		$product['sprod_name'] = convert($ws->getCell("C".$rowNo)->getValue());
		$product['sprod_price'] = $ws->getCell("AD".$rowNo)->getValue();
		$product['sprod_unit'] = $ws->getCell("F".$rowNo)->getValue();
		$product['sprod_material'] = convert($ws->getCell("AK".$rowNo)->getValue());
		$product['sprod_colour'] = convert($ws->getCell("AL".$rowNo)->getValue());
		
		// Debt
		$debt['sale_ref'] = $order['sale_ref'];
		$debt['debt_pay_name'] = '';
		
		$addr = $ws->getCell("N".$rowNo)->getValue()
					.$ws->getCell("O".$rowNo)->getValue()
					.$ws->getCell("P".$rowNo)->getValue()
					.$ws->getCell("Q".$rowNo)->getValue();
		
		$len = mb_strlen($addr, 'UTF-8');
		$debt['debt_cust_address1'] = mb_substr($addr, 0, 12, 'UTF-8');
		$debt['debt_cust_address2'] = mb_substr($addr, 12, 12, 'UTF-8');
		$debt['debt_cust_address3'] = mb_substr($addr, 24, $len - 24, 'UTF-8');
		
		$debt['debt_cust_address1'] = convert($debt['debt_cust_address1']);
		$debt['debt_cust_address2'] = convert($debt['debt_cust_address2']);
		$debt['debt_cust_address3'] = convert($debt['debt_cust_address3']);
		
		$debt['debt_email'] = '';
		$debt['debt_post_co'] = $ws->getCell("M".$rowNo)->getValue();
		$debt['debt_tel'] = $ws->getCell("R".$rowNo)->getValue();
		$debt['debt_mobile'] = '';
		$debt['debt_bank'] = '';
		$debt['debt_pay_method'] = 'Bank in';
		$debt['debt_shipping_method'] = 'Air Mail';
		$debt['debt_email_sent'] = NULL;

		// Remarks
		$remark = $ws->getCell("AC".$rowNo)->getValue();

		$cash_on_delivery = $ws->getCell("AF".$rowNo)->getValue();
		if ($cash_on_delivery != '－') {
			if ($remark != '') {
				$remark .= '/';
			}
			
			$remark .= $cash_on_delivery;
		}

		if ($ws->getCell("AB".$rowNo)->getValue() == '商品代引') {
			if ($remark != '') {
				$remark .= '/';
			}
			
			$remark .= '商品代引： '.$ws->getCell("AG".$rowNo)->getValue().'円';
		}
		
		$debt['debt_remark'] = convert($remark);
		
		// Validation
		if (empty($order['sale_ref'])) {
			$error_message = '<br>Line '.$rowNo.': Order No.(column A) is mandatory.';
		} else if (isOrderExist($db, $order['sale_ref']) || array_key_exists($order['sale_ref'], $orderNoSet)) {
			$error_message = '<br>Line '.$rowNo.': Order No.['.$order['sale_ref'].'] has already existed.';
		}
		
		if (empty($product['sprod_id'])) {
			$error_message = '<br>Line '.$rowNo.': Product No.(column D) is mandatory.';
		}
		
		if (empty($product['sprod_name'])) {
			$error_message = '<br>Line '.$rowNo.': Product Name(column C) is mandatory.';
		}
		
		if (empty($product['sprod_price']) && $product['sprod_price'] != '0') {
			$error_message = '<br>Line '.$rowNo.': Product Price(column AD) is mandatory.';
		} else if (!is_numeric($product['sprod_price'])) {
			$error_message = '<br>Line '.$rowNo.': Product Price(column AD) must be numeric.';
		}
		
		if (empty($product['sprod_unit']) && $product['sprod_unit'] != '0') {
			$error_message = '<br>Line '.$rowNo.': Product Unit(column F) is mandatory.';
		} else if (!is_numeric($product['sprod_unit'])) {
			$error_message = '<br>Line '.$rowNo.': Product Unit(column F) must be numeric.';
		}
		
		if (!empty($error_message)) {
			return false;
		}
		
		$orderNoSet[$order['sale_ref']] = 1;
		
		$orderInfo['order'] = $order;
		$orderInfo['product'] = $product;
		$orderInfo['debt'] = $debt;

		$result[] = $orderInfo;
	}

	foreach ($result as $info) {
		$order = $info['order'];
		$product = $info['product'];
		$debt = $info['debt'];
		$balance = $info['balance'];
	
		insertSale($order['sale_ref'], $order['order_date'], $order['sale_group'], $order['sale_email'], $order['sale_name'],
				$order['sale_yahoo_id'], $order['sale_chk_ref'], $order['sale_ship_fee'], $order['sale_discount'], $order['sale_tax']);
	
		insertSaleProduct($product['sale_ref'], $product['sprod_id'], $product['sprod_name'], $product['sprod_price'], $product['sprod_unit'],
				$product['sprod_material'], $product['sprod_colour']);
	
		insertDebt($debt['sale_ref'], $debt['debt_pay_name'], $debt['debt_cust_address1'], $debt['debt_cust_address2'],
		 $debt['debt_cust_address3'], $debt['debt_email'], $debt['debt_post_co'], $debt['debt_tel'], $debt['debt_mobile'],
				$debt['debt_bank'], $debt['debt_pay_method'], $debt['debt_shipping_method'],
				$debt['debt_email_sent'], $debt['debt_remark']);
	}
	
	return true;
}

function importYahooShopping($db, $file_name, $actual_file_name, $salesGroup) {
	global $error_message;

	$objPHPExcel = getExcelReader($file_name, $actual_file_name);

	$result = array();
	$orderNoSet = array();
	$ws = $objPHPExcel->getSheet(0);
	foreach ($ws->getRowIterator() as $row) {
		$rowNo = $row->getRowIndex();
		if ($rowNo == 1) {
			// Skip 1st row (i.e. header)
			continue;
		}

		$order = array();
		$product = array();
		$debt = array();
		$balance = array();

		// Order
		$order['sale_ref'] = $ws->getCell("A".$rowNo)->getValue().'';
		
		$order['order_date'] = date('Y-m-d');
		$order['sale_group'] = $salesGroup;
		$order['sale_name'] = convert($ws->getCell("P".$rowNo)->getValue());
		$order['sale_ship_fee'] = $ws->getCell("J".$rowNo)->getValue();
		
		$order['sale_email'] = $ws->getCell("X".$rowNo)->getValue();
		$order['sale_yahoo_id'] = '';
		$order['sale_chk_ref'] = 0; // Yahoo
		$order['sale_discount'] = 0;
		$order['sale_tax'] = 0;

		// Product
		$product['sale_ref'] = $order['sale_ref'];
		$product['sprod_id'] = $ws->getCell("F".$rowNo)->getValue();
		$product['sprod_name'] = convert($ws->getCell("G".$rowNo)->getValue());
		$product['sprod_price'] = $ws->getCell("M".$rowNo)->getValue();
		$product['sprod_unit'] = $ws->getCell("H".$rowNo)->getValue();
		$product['sprod_material'] = convert($ws->getCell("AJ".$rowNo)->getValue());
		$product['sprod_colour'] = convert($ws->getCell("AK".$rowNo)->getValue());

		// Debt
		$debt['sale_ref'] = $order['sale_ref'];
		$debt['debt_pay_name'] = '';
		
		$addr = $ws->getCell("Q".$rowNo)->getValue()
					.$ws->getCell("R".$rowNo)->getValue()
					.$ws->getCell("S".$rowNo)->getValue()
					.$ws->getCell("T".$rowNo)->getValue();
		
		$len = mb_strlen($addr, 'UTF-8');
		$debt['debt_cust_address1'] = mb_substr($addr, 0, 12, 'UTF-8');
		$debt['debt_cust_address2'] = mb_substr($addr, 12, 12, 'UTF-8');
		$debt['debt_cust_address3'] = mb_substr($addr, 24, $len - 24, 'UTF-8');
		
		$debt['debt_cust_address1'] = convert($debt['debt_cust_address1']);
		$debt['debt_cust_address2'] = convert($debt['debt_cust_address2']);
		$debt['debt_cust_address3'] = convert($debt['debt_cust_address3']);
		
		$debt['debt_email'] = '';
		$debt['debt_post_co'] = $ws->getCell("U".$rowNo)->getValue();
		$debt['debt_tel'] = $ws->getCell("V".$rowNo)->getValue();
		$debt['debt_mobile'] = '';
		$debt['debt_bank'] = '';
		$debt['debt_pay_method'] = 'Bank in';
		$debt['debt_shipping_method'] = 'Air Mail';
		$debt['debt_email_sent'] = NULL;

		if (strtolower($ws->getCell("AE".$rowNo)->getValue()) == 'payment_d1') {
			$remark = '商品代引：'.$ws->getCell("N".$rowNo)->getValue().'円';
		}
		//$remark = $ws->getCell("N".$rowNo)->getValue().'/'.$ws->getCell("L".$rowNo)->getValue();
		$debt['debt_remark'] = convert($remark);
		
		// Balacne
		$totalPrice = $ws->getCell("N".$rowNo)->getValue();
		if ($totalPrice != NULL && $totalPrice != '') {
			$balance['sale_ref'] = $order['sale_ref'];
			$balance['bal_pay'] = $ws->getCell("N".$rowNo)->getValue();
			$balance['bal_pay_type'] = 'Store';
			$balance['bal_ship_type'] = '';
		}
		
		// Validation
		if (empty($order['sale_ref'])) {
			$error_message = '<br>Line '.$rowNo.': Order No.(column A) is mandatory.';
		} else if (isOrderExist($db, $order['sale_ref']) || array_key_exists($order['sale_ref'], $orderNoSet)) {
			$error_message = '<br>Line '.$rowNo.': Order No.['.$order['sale_ref'].'] has already existed.';
		}

		if (empty($product['sprod_id'])) {
			$error_message = '<br>Line '.$rowNo.': Product No.(column E) is mandatory.';
		}

		if (empty($product['sprod_name'])) {
			$error_message = '<br>Line '.$rowNo.': Product Name(column F) is mandatory.';
		}

		if (empty($product['sprod_price']) && $product['sprod_price'] != '0') {
			$error_message = '<br>Line '.$rowNo.': Product Price(column AD) is mandatory.';
		} else if (!is_numeric($product['sprod_price'])) {
			$error_message = '<br>Line '.$rowNo.': Product Price(column AD) must be numeric.';
		}

		if (empty($product['sprod_unit']) && $product['sprod_unit'] != '0') {
			$error_message = '<br>Line '.$rowNo.': Product Unit(column C) is mandatory.';
		} else if (!is_numeric($product['sprod_unit'])) {
			$error_message = '<br>Line '.$rowNo.': Product Unit(column C) must be numeric.';
		}

		if (!empty($error_message)) {
			return false;
		}

		$orderNoSet[$order['sale_ref']] = 1;

		$orderInfo['order'] = $order;
		$orderInfo['product'] = $product;
		$orderInfo['debt'] = $debt;
		$orderInfo['balance'] = $balance;

		$result[] = $orderInfo;
		
	}

	foreach ($result as $info) {
		$order = $info['order'];
		$product = $info['product'];
		$debt = $info['debt'];
		$balance = $info['balance'];

		insertSale($order['sale_ref'], $order['order_date'], $order['sale_group'], $order['sale_email'], $order['sale_name'],
				$order['sale_yahoo_id'], $order['sale_chk_ref'], $order['sale_ship_fee'], $order['sale_discount'], $order['sale_tax']);

		insertSaleProduct($product['sale_ref'], $product['sprod_id'], $product['sprod_name'], $product['sprod_price'], $product['sprod_unit'],
				$product['sprod_material'], $product['sprod_colour']);

		insertDebt($debt['sale_ref'], $debt['debt_pay_name'], $debt['debt_cust_address1'], $debt['debt_cust_address2'],
				$debt['debt_cust_address3'], $debt['debt_email'], $debt['debt_post_co'], $debt['debt_tel'], $debt['debt_mobile'],
				$debt['debt_bank'], $debt['debt_pay_method'], $debt['debt_shipping_method'],
				$debt['debt_email_sent'], $debt['debt_remark']);
		
		if (!empty($balance)) {
			insertBalance($balance['sale_ref'], $balance['bal_pay'], $balance['bal_pay_type'], $balance['bal_ship_type']);
		}
	}

	return true;
}

function importRakuten($db, $file_name, $actual_file_name, $salesGroup) {
	global $error_message;
	
	$objPHPExcel = getExcelReader($file_name, $actual_file_name);
	
	$result = array();
	$orderNoSet = array();
	$ws = $objPHPExcel->getSheet(0);
	foreach ($ws->getRowIterator() as $row) {
		$rowNo = $row->getRowIndex();
		if ($rowNo == 1) {
			// Skip 1st row (i.e. header)
			continue;
		}
	
		$order = array();
		$product = array();
		$debt = array();
		$balance = array();

		// Order
		$order_no = $ws->getCell("A".$rowNo)->getValue();
		$pos = strrpos($order_no, '-');
		$order['sale_ref'] = trim(substr($order_no, $pos + 1));
		
		$order['order_date'] = date('Y-m-d');
		$order['sale_group'] = $salesGroup;
		$order['sale_name'] = convert($ws->getCell("Y".$rowNo)->getValue()
								.$ws->getCell("Z".$rowNo)->getValue());
								//.$ws->getCell("AA".$rowNo)->getValue()
								//.$ws->getCell("AB".$rowNo)->getValue());
		$order['sale_ship_fee'] = $ws->getCell("BA".$rowNo)->getValue();
	
		$order['sale_email'] = $ws->getCell("N".$rowNo)->getValue();
		$order['sale_yahoo_id'] = '';
		$order['sale_chk_ref'] = 0;
		$order['sale_discount'] = 0;
		$order['sale_tax'] = 0;

	/** Product */
		$product['sale_ref'] = $order['sale_ref'];
		$product['sprod_name'] = convert($ws->getCell("E".$rowNo)->getValue());
		//$product['sprod_price'] = $ws->getCell("H".$rowNo)->getValue();
		$product['sprod_price'] = $ws->getCell("AZ".$rowNo)->getValue() + $ws->getCell("BB".$rowNo)->getValue();
		$product['sprod_unit'] = $ws->getCell("G".$rowNo)->getValue();
		$product['sprod_material'] = convert($ws->getCell("BM".$rowNo)->getValue());
		
		$colour = $ws->getCell("I".$rowNo)->getValue();
		if (!empty($colour)) {
			$product['sprod_colour'] = convert(substr($colour, 4));
		}
		
		//$select = $ws->getCell("I".$rowNo)->getValue();
		//if (empty($select)) {
			$product['sprod_id'] = $ws->getCell("F".$rowNo)->getValue();
		//} else {
	//		$pos1 = strrpos($select, '「');
	//		$pos2 = strrpos($select, '」');
	//		$product['sprod_id'] = substr($select, $pos1 + 3, $pos2 - $pos1 - 3);
	//	}
	
	/** Debt */
		$debt['sale_ref'] = $order['sale_ref'];
		$debt['debt_pay_name'] = '';
		
		$addr = $ws->getCell("AE".$rowNo)->getValue()
						.$ws->getCell("AF".$rowNo)->getValue()
						.$ws->getCell("AG".$rowNo)->getValue();
		
		// Address
		$len = mb_strlen($addr, 'UTF-8');
		$debt['debt_cust_address1'] = mb_substr($addr, 0, 12, 'UTF-8');
		$debt['debt_cust_address2'] = mb_substr($addr, 12, 12, 'UTF-8');
		$debt['debt_cust_address3'] = mb_substr($addr, 24, $len - 24, 'UTF-8');
		
		$debt['debt_cust_address1'] = convert($debt['debt_cust_address1']);
		$debt['debt_cust_address2'] = convert($debt['debt_cust_address2']);
		$debt['debt_cust_address3'] = convert($debt['debt_cust_address3']);
		
		$debt['debt_email'] = $ws->getCell("N".$rowNo)->getValue();
		$debt['debt_post_co'] = $ws->getCell("AC".$rowNo)->getValue().'-'
								.$ws->getCell("AD".$rowNo)->getValue();
		$debt['debt_tel'] = $ws->getCell("AH".$rowNo)->getValue().'-'
							.$ws->getCell("AI".$rowNo)->getValue().'-'
							.$ws->getCell("AJ".$rowNo)->getValue();
		$debt['debt_mobile'] = '';
		$debt['debt_bank'] = '';
		$debt['debt_pay_method'] = 'Bank in';
		$debt['debt_shipping_method'] = 'Air Mail';
		$debt['debt_email_sent'] = NULL;
		
		// Remarks
		$remark = $ws->getCell("AT".$rowNo)->getValue();

		if ($ws->getCell("AL".$rowNo)->getValue() == '代金引換') {
			$remark .= '\n'.'商品代引： '.$ws->getCell("BD".$rowNo)->getValue().'円';
		}
		
		/* $remark2 = $ws->getCell("BJ".$rowNo)->getValue();
		if (!empty($remark2)) {
			$remark .= '/'.$remark2;
		}
		
		$remark3 = $ws->getCell("BH".$rowNo)->getValue();
		if (!empty($remark3)) {
			$remark .= '/'.$remark3;
		} */
		
		$debt['debt_remark'] = convert($remark);
		
	/** Balance */
		$requiredCost = $ws->getCell("BD".$rowNo)->getValue();
		if ($requiredCost != NULL && $requiredCost != '') {

			$balance['sale_ref'] = $order['sale_ref'];
			$balance['bal_pay'] = $ws->getCell("BJ".$rowNo)->getValue();
			
			// Payment Type
			$type = $ws->getCell("AL".$rowNo)->getValue();
			switch ($type) {
				case "クレジットカード":
					$balance['bal_pay_type'] = 'Credit Card';
					break;
				case "銀行振込":
					$balance['bal_pay_type'] = 'Bank';
					break;
				default:
					$balance['bal_pay_type'] = '';
			}
			
			//[配送日時指定:]19～21時[注文フォーム:]
			$delivery = $ws->getCell("AT".$rowNo)->getValue();
			$start_idx = mb_strpos($delivery, ']', 0, 'UTF-8');
			$end_idx = mb_strpos($delivery, '[', 3, 'UTF-8');
			$delivery_time = convert(mb_substr($delivery, $start_idx + 1, $end_idx - $start_idx - 1, 'UTF-8'));
			$balance['bal_delivery_time_optaion_id'] = NULL;
			$balance['bal_delivery_time'] = $delivery_time;
			
			// Shipping Type
			if ($type == '代金引換') {
				$balance['bal_ship_type'] = 'COD';

				$debt['debt_remark'] = $debt['debt_remark'].'\n'.convert('代引 : '.$ws->getCell("BC".$rowNo)->getValue().'円');
			} else {
				$balance['bal_ship_type'] = '';
			}
		}
		
		// Validation
		if (empty($order['sale_ref'])) {
			$error_message = '<br>Line '.$rowNo.': Order No.(column A) is mandatory.';
		} else if (isOrderExist($db, $order['sale_ref']) || array_key_exists($order['sale_ref'], $orderNoSet)) {
			$error_message = '<br>Line '.$rowNo.': Order No.['.$order['sale_ref'].'] has already existed.';
		}
		
		if (empty($product['sprod_id'])) {
			$error_message = '<br>Line '.$rowNo.': Product No.(column F/I) is mandatory.';
		}
		
		if (empty($product['sprod_name'])) {
			$error_message = '<br>Line '.$rowNo.': Product Name(column E) is mandatory.';
		}
		
		if (empty($product['sprod_price']) && $product['sprod_price'] != '0') {
			$error_message = '<br>Line '.$rowNo.': Product Price(column H) is mandatory.';
		} else if (!is_numeric($product['sprod_price'])) {
			$error_message = '<br>Line '.$rowNo.': Product Price(column H) must be numeric.';
		}
		
		if (empty($product['sprod_unit']) && $product['sprod_unit'] != '0') {
			$error_message = '<br>Line '.$rowNo.': Product Unit(column G) is mandatory.';
		} else if (!is_numeric($product['sprod_unit'])) {
			$error_message = '<br>Line '.$rowNo.': Product Unit(column G) must be numeric.';
		}
		
		if (!empty($error_message)) {
			return false;
		}
		
		$orderNoSet[$order['sale_ref']] = 1;
		
		$orderInfo['order'] = $order;
		$orderInfo['product'] = $product;
		$orderInfo['debt'] = $debt;
		$orderInfo['balance'] = $balance;
	
		$result[] = $orderInfo;
	}
	
	foreach ($result as $info) {
		$order = $info['order'];
		$product = $info['product'];
		$debt = $info['debt'];
		$balance = $info['balance'];
	
		insertSale($order['sale_ref'], $order['order_date'], $order['sale_group'], $order['sale_email'], $order['sale_name'],
				$order['sale_yahoo_id'], $order['sale_chk_ref'], $order['sale_ship_fee'], $order['sale_discount'], $order['sale_tax']);
	
		insertSaleProduct($product['sale_ref'], $product['sprod_id'], $product['sprod_name'], $product['sprod_price'], $product['sprod_unit'], 
				$product['sprod_material'], $product['sprod_colour']);
	
		insertDebt($debt['sale_ref'], $debt['debt_pay_name'], $debt['debt_cust_address1'], $debt['debt_cust_address2'],
				$debt['debt_cust_address3'], $debt['debt_email'], $debt['debt_post_co'], $debt['debt_tel'], $debt['debt_mobile'],
				$debt['debt_bank'], $debt['debt_pay_method'], $debt['debt_shipping_method'],
				$debt['debt_email_sent'], $debt['debt_remark']);
		
		if (!empty($balance)) {
			insertBalance($balance['sale_ref'], $balance['bal_pay'], $balance['bal_pay_type'], $balance['bal_ship_type'],
					$balance['bal_delivery_date'], $balance['bal_delivery_time_option_id'], $balance['bal_delivery_time']);
		}
	}
	
	return true;
}

function convert($str) {
	return mb_convert_encoding($str, 'EUC-JP', 'auto');
}

function getExcelReader($file_name, $actual_file_name) {
	$ext = getFileExtension($actual_file_name);
	
	$objPHPExcel = new PHPExcel();
	
	if ($ext == 'xls') {
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
	} else if ($ext == 'xlsx') {
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	}
	
	//$objReader = PHPExcel_IOFactory::createReader('CSV');
	//$objReader->setInputEncoding('SJIS');
	//$objReader->setReadDataOnly(true);
	$objPHPExcel = $objReader->load($file_name);
	
	return $objPHPExcel;
}

function getFileExtension($file_name) {
	$pos = strrpos($file_name, '.');
	return substr($file_name, $pos + 1);
}

?>
