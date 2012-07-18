<?

$po_date = '';
$entry_date = '';
$staff_cd = '';
$staff_name = '';
$supp_cd = '';
$supp_name = '';
$supp_address = '';
$supp_tel = '';
$supp_fax = '';
$supp_email = '';
$subTotal = '';
$remarks = '';

$submit_success = '';
$id = '';

if ($_POST['event'] == 'save') {
	$submit_success = 0;

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_ins_id = "SELECT LAST_INSERT_ID() id FROM dual";
	
	$po_id = $_POST['po_id'];
	$invoice_id = $_POST['invoice_id'];
	
	$po_date = trim($_POST['po_date']);
	$entry_date = trim($_POST['entry_date']);
	$sub_total = trim($_POST['subTotal']);
	$remarks = $_POST['remarks'];
	
	// Update PO
	$sql = "UPDATE po SET
	 	  	po_date = '$po_date',
		 	entry_date = '$entry_date',
			staff_name = '".trim($_POST['staff_name'])."',
			staff_cd = '".trim($_POST['staff_cd'])."',
			supplier_name = '".trim($_POST['supp_name'])."',
			supplier_cd = '".trim($_POST['supp_cd'])."',
			supplier_address = '".trim($_POST['supp_address'])."',
		 	supplier_tel = '".trim($_POST['supp_tel'])."',
			supplier_fax = '".trim($_POST['supp_fax'])."',
		 	supplier_email = '".trim($_POST['supp_email'])."',
			subtotal = '$sub_total',
			remarks = '$remarks',
			invoice_id = '$invoice_id'
			WHERE id = $po_id";
	sqlinsert($sql);

	// Process PO product
	for ($k=1;$k<=$prod_n;$k++)
	{
		$sprod_cd = "goods_partno".$k;
		$sprod_po_prod_id = "po_prod_id".$k;

		$prod_cd = trim($_POST[$sprod_cd]);
		$prod_po_prod_id = $_POST[$sprod_po_prod_id];
		
		if ($prod_cd == '' and $prod_po_prod_id == '') {
			continue;
		}
		
		$prod_name = $_POST["goods_name".$k];
		$prod_remark = $_POST["goods_remark".$k];
		$prod_colour = $_POST["product_colour".$k];
		$prod_pcs = $_POST["pcs".$k];
		$prod_qty = $_POST["qty".$k];
		$prod_price = $_POST["unit_price".$k];
		$prod_total = $_POST["total".$k];
		$prod_orig_product_cd = $_POST["orig_product_cd".$k];
		$prod_ordered = $_POST["ordered".$k];
		
		$insert_flag = 0;
		$update_flag = 0;
		$delete_flag = 0;
		
		if ($prod_cd == '' ) {
			$delete_flag = 1;
		}
		else if ($prod_po_prod_id == '') {
			$insert_flag = 1;
		}
		else if ($prod_cd == $prod_orig_product_cd) {
			$update_flag = 1;
		}
		else {
			$delete_flag = 1;
			$insert_flag = 1;
		}

		if ($insert_flag == 1) {
			// Insert new PO product
			$sql = "SELECT *
					FROM product
					WHERE product_id = '$prod_cd'";
	
			$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
			$row=mysql_fetch_array($result);
			$prod_model_name = $row["product_model_no"];
			$prod_make_name = $row["product_made"];
			$prod_color_no = $row["product_colour_no"];
			
			$sqla = "INSERT INTO po_product SET
					po_id = '$po_id',
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
					sts = 'P',
					ordered = '$prod_ordered' ";
			sqlinsert($sqla);
		}
		
		if ($update_flag == 1) {
			// Update original Invoice product
			$sqla = "UPDATE po_product SET
					product_cd = '$prod_cd',
					product_name = '$prod_name',
					remark = '$prod_remark',
					colour = '$prod_colour',
					pcs_set = '$prod_pcs',
					qty = '$prod_qty',
					unit_price = '$prod_price',
					total = '$prod_total',
					ordered = '$prod_ordered'
					WHERE id = $prod_po_prod_id";
			sqlinsert($sqla);
		}
		
		if ($delete_flag == 1) {
			// Delete records
			$sqla = "UPDATE po_product SET
					sts = 'X'
					WHERE id = $prod_po_prod_id";
			sqlinsert($sqla);
		}
		
	}

	$submit_success = 1;
	$id = $po_id;
}

if ($po_id == '') {
	$po_id=$_GET['po_id'];
}

if ($po_id != '') {	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);

	// Retrieve Invoice
	$sql = "SELECT * FROM po WHERE id = $po_id ";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$invoice_id = $row["invoice_id"];
		
		$po_date = $row["po_date"];
		$entry_date = $row["entry_date"];
		$staff_cd = $row["staff_cd"];
		$staff_name = $row["staff_name"];
		$supp_cd = $row["supplier_cd"];
		$supp_name = $row["supplier_name"];
		$supp_address = $row["supplier_address"];
		$supp_tel = $row["supplier_tel"];
		$supp_fax = $row["supplier_fax"];
		$supp_email = $row["supplier_email"];
		$subTotal = $row["subtotal"];
		$remarks = $row["remarks"];
	}
	
	// Retrieve Invoice product
	$sql = "SELECT * FROM po_product WHERE po_id = $po_id AND sts <> 'X' order by id";
	
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
		
		$po_prod_id[$i] = $row["id"];
		$goods_partno[$i] = $row["product_cd"];
		$goods_name[$i] = $row["product_name"];
		$goods_remark[$i] = $row["remark"];
		$product_colour[$i] = $row["colour"];
		$pcs[$i] = $row["pcs_set"];
		$qty[$i] = $row["qty"];
		$unit_price[$i] = $row["unit_price"];
		$total[$i] = $row["total"];
		$ordered[$i] = $row["ordered"];
		
		$orig_product_cd[$i] = $goods_partno[$i];
	}
}

?>
