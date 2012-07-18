<?

$submit_success = '';
$id = '';

//get Number of product
if (isset($_GET['prod_n']))
{$prod_n =trim($_GET['prod_n']);} else {$prod_n=$INIT_NUM_OF_PROD;}

if ($_POST['event'] == 'save') {
	$submit_success = 0;

	$auto_po_flag=$_POST['auto_po_flag'];
	$complete_flag=$_POST['complete_flag'];

	if ($auto_po_flag == "auto_po") {
		$auto_po_flag = "Y";
	}
	else {
		$auto_po_flag = "N";
	}
	
	if ($complete_flag == "complete") {
		$inv_sts = "C";
	}
	else {
		$inv_sts = "P";
	}
	
	$payment_flag=$_POST['payment_flag'];
	
	//insert invoice
	$user_name = $_SESSION['user_name'];
	
	$invoice_date = trim($_POST['invoice_date']);
	$entry_date = trim($_POST['entry_date']);
	$sub_total = trim($_POST['subTotal']);
	
	$sql = "INSERT INTO invoice SET
		 	invoice_date = '$invoice_date',
		 	entry_date = '$entry_date',
		 	sales_cd = '".trim($_POST['sales_cd'])."',
		 	sales_name = '".trim($_POST['sales_name'])."',
		 	cust_cd = '".trim($_POST['cust_cd'])."',
			cust_name = '".trim($_POST['cust_name'])."',
		 	cust_address = '".trim($_POST['cust_address'])."',
		 	cust_tel = '".trim($_POST['cust_tel'])."',
			cust_fax = '".trim($_POST['cust_fax'])."',
		 	cust_email = '".trim($_POST['cust_email'])."',
			invoice_status = '$inv_sts',
			created_by = '$user_name',
			auto_po_flag = '$auto_po_flag',
			payment = '$payment_flag',
			po_id = 0,
	 	  	subtotal = '$sub_total',
			remarks = '".trim($_POST['remarks'])."',
			post_code = '".trim($_POST['post_code'])."'";
	sqlinsert($sql);

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_ins_id = "SELECT LAST_INSERT_ID() id FROM dual";
	$result = mysql_query($sql_ins_id,$db) or die (mysql_error()."<br />Couldn't execute query: $sql_ins_id");
	$row = mysql_fetch_array($result);
	$invoice_id = $row["id"];
	
	// Insert PO
	if ($auto_po_flag == "Y") {
		$sql = "INSERT INTO po SET
	 	  	po_date = '$invoice_date',
		 	entry_date = '$entry_date',
		 	staff_id = 0,
		 	staff_cd = '".trim($_POST['sales_cd'])."',
		 	staff_name = '".trim($_POST['sales_name'])."',
		 	supplier_id = '0',
			supplier_name = '',
		 	supplier_address = '',
		 	supplier_tel = '',
			supplier_fax = '',
		 	supplier_email = '',
			subtotal = '0',
			ship_ref_no = '',
			ship_batch_no = '',
			delivery_date = '',
			landing_date = '',
			warehouse = '',
			close_po_flag = '',
			factory_staff_id = '',
			factory_staff_name = 'N/A',
			po_complete_date = '',
			invoice_id = '$invoice_id',
	 	  	created_by = '$user_name'";
		sqlinsert($sql);
		
		$result = mysql_query($sql_ins_id,$db) or die (mysql_error()."<br />Couldn't execute query: $sql_ins_id");
		$row = mysql_fetch_array($result);
		$po_id = $row["id"];
		
		// Set invoice.po_id
		$sql = "UPDATE invoice SET po_id = '$po_id' WHERE id = '$invoice_id'";
		sqlinsert($sql);
	}
	
	$totalCost = 0;
	
	//insert invoice product
	for ($k=1;$k<=$prod_n;$k++)
	{

		$prod_cd = trim($_POST["goods_partno".$k]);
		
		if ($prod_cd == '') {
			continue;
		}

		$prod_name = $_POST["goods_name".$k];
		$prod_remark = $_POST["goods_remark".$k];
		$prod_qty = $_POST["qty".$k];
		$prod_price = $_POST["unit_price".$k];
		$prod_total = $_POST["total".$k];
		$prod_colour = $_POST["product_colour".$k];

		$sql = "SELECT *
				FROM product
				WHERE product_id = '$prod_cd'";

		$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
		$row=mysql_fetch_array($result);
		$prod_pcs = $row["product_pcs"];
		$prod_model_name = $row["product_model_no"];
		$prod_cost=$row["product_cost_rmb"];
		$prod_make_name = $row["product_made"];
		$prod_color_no = $row["product_colour_no"];

		$sqla = "INSERT INTO invoice_product SET
				invoice_id = '$invoice_id',
				product_cd = '$prod_cd',
				product_name = '$prod_name',
				remark = '$prod_remark',
				qty = '$prod_qty',
				unit_price = '$prod_price',
				total = '$prod_total',
				currency_cd = 'Yen',
				colour = '$prod_colour',
				pcs_set = '$prod_pcs',
				make = '$prod_make_name',
				model = '$prod_model_name',
				color_no = '$prod_color_no',
				created_by = '$user_name',
				sts = '$inv_sts'";
		sqlinsert($sqla);
		
		// Insert PO Product
		if ($auto_po_flag == "Y") {
			$total = $prod_cost * $prod_qty;		
			$sqlb = "INSERT INTO po_product SET
					po_id = '$po_id',
					product_cd = '$prod_cd',
					product_name = '$prod_name',
					remark = '$prod_remark',
					qty = '$prod_qty',
					unit_price = '$prod_cost',
					total = '$total',
					currency_cd = 'RMB',
					colour = '$prod_colour',
					pcs_set = '$prod_pcs',
					make = '$prod_make_name',
					model = '$prod_model_name',
					color_no = '$prod_color_no',
					created_by = '$user_name',
					sts = 'P' ";
		 	sqlinsert($sqlb);
			
			$totalCost = $totalCost + ($prod_cost * $prod_qty);
		}
		
	}
	
	// Update PO subTotal
	if ($auto_po_flag == "Y") {
		$sql = "UPDATE po SET
			subtotal = '$totalCost'
			WHERE id = $po_id";
		sqlinsert($sql);
	}
	
	

	$submit_success = 1;
	$id = $invoice_id;
}
else {
	// Retrieve sales information
	$sales_cd = $_SESSION[user_name];
	$sales_name = $_SESSION[user_name];
}

?>
