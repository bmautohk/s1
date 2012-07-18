<?

$invoice_date = '';
$entry_date = '';
$sales_cd = '';
$sales_name = '';
$cust_cd = '';
$cust_name = '';
$cust_address = '';
$cust_tel = '';
$cust_fax = '';
$cust_email = '';
$subTotal = '';
$auto_po_flag = '';

$submit_success = '';
$id = '';

if ($_POST['event'] == 'save') {
	$submit_success = 0;
	
	$complete_flag=$_POST['complete_flag'];
	if ($complete_flag == "complete") {
		$inv_sts = "C";
	}
	else {
		$inv_sts = "P";
	}
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_ins_id = "SELECT LAST_INSERT_ID() id FROM dual";

	// Update Invoice
	$invoice_id = $_POST['invoice_id'];
	$po_id = $_POST['po_id'];
	
	$auto_po_flag=$_POST['auto_po'];
	$payment_flag=$_POST['payment_flag'];
	
	$invoice_date = trim($_POST['invoice_date']);
	$entry_date = trim($_POST['entry_date']);
	$sub_total = trim($_POST['subTotal']);
	
	$sql = "UPDATE invoice SET
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
	 	  	subtotal = '$sub_total',
			invoice_status = '$inv_sts',
			remarks = '".trim($_POST['remarks'])."',
			post_code = '".trim($_POST['post_code'])."',
			payment = '$payment_flag'
			WHERE id = $invoice_id";
	sqlinsert($sql);

	// Process invoice product
	for ($k=1;$k<=30;$k++)
	{
		$prod_cd = trim($_POST["goods_partno".$k]);
		$prod_inv_prod_id = $_POST["inv_prod_id".$k];		
		
		if ($prod_cd == '' and $prod_inv_prod_id == '') {
			continue;
		}
		
		$prod_name = $_POST["goods_name".$k];
		$prod_remark = $_POST["goods_remark".$k];
		$prod_colour = $_POST["product_colour".$k];
		$prod_pcs = $_POST["pcs".$k];
		$prod_qty = $_POST["qty".$k];
		$prod_price = $_POST["unit_price".$k];
		$prod_total = $_POST["total".$k];
		
		if ($prod_cd != '' and $prod_inv_prod_id == '') {
			// Insert new product
			$sql = "SELECT *
					FROM product
					WHERE product_id = '$prod_cd'";
	
			$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
			$row=mysql_fetch_array($result);
	
			$prod_model_name = $row["product_model_no"];
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
					make = '$prod_make',
					model = '$prod_model_name',
					color_no = '$prod_color_no',
					created_by = '$user_name',
					sts = (SELECT invoice_status FROM invoice WHERE id = $invoice_id)";
			sqlinsert($sqla);
			
		}
		else if ($prod_cd != '') {
			// Update original Invoice product
			$sqla = "UPDATE invoice_product SET
					product_cd = '$prod_cd',
					product_name = '$prod_name',
					remark = '$prod_remark',
					colour = '$prod_colour',
					pcs_set = '$prod_pcs',
					qty = '$prod_qty',
					unit_price = '$prod_price',
					total = '$prod_total',
					sts = '$inv_sts'
					WHERE id = $prod_inv_prod_id";
			sqlinsert($sqla);
		}
		else {
			// Delete records
			$sqla = "UPDATE invoice_product SET
					sts = 'X'
					WHERE id = $prod_inv_prod_id";
			sqlinsert($sqla);
		}
		
	}

	$submit_success = 1;
	$id = $invoice_id;
}

if ($invoice_id == '') {
	$invoice_id=$_GET['invoice_id'];
}

//if (isset($_GET['invoice_id'])) {
if ($invoice_id != '') {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);

	// Retrieve Invoice
	$sql = "SELECT * FROM invoice WHERE id = $invoice_id ";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$invoice_date = $row["invoice_date"];
		$entry_date = $row["entry_date"];
		$sales_cd = $row["sales_cd"];
		$sales_name = $row["sales_name"];
		$cust_cd = $row["cust_cd"];
		$cust_name = $row["cust_name"];
		$cust_address = $row["cust_address"];
		$cust_tel = $row["cust_tel"];
		$cust_fax = $row["cust_fax"];
		$cust_email = $row["cust_email"];
		$subTotal = $row["subtotal"];
		$auto_po_flag=$row["auto_po_flag"];
		$remarks=$row["remarks"];
		$post_code=$row["post_code"];
		$invoice_status=$row["invoice_status"];
		$payment_flag=$row["payment"];
	}
	
	// Retrieve Invoice product
	$sql = "SELECT * FROM invoice_product WHERE invoice_id = $invoice_id AND sts <> 'X' ";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	$prod_n = $GLOBALS['prod_n'];
	if (!isset($prod_n) || $prod_n < $num_results) {
		$prod_n = $num_results;
	}
	
	//loop
	for ($i=1;$i<=$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$inv_prod_id[$i] = $row["id"];
		$goods_partno[$i] = $row["product_cd"];
		$goods_name[$i] = $row["product_name"];
		$goods_remark[$i] = $row["remark"];
		$product_colour[$i] = $row["colour"];
		$pcs[$i] = $row["pcs_set"];
		$qty[$i] = $row["qty"];
		$unit_price[$i] = $row["unit_price"];
		$total[$i] = $row["total"];
	}
}

?>
