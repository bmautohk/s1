<?

$submit_success = '';
$id = '';

$po_date='';
$entry_date='';
$staff_cd='';
$staff_name='';
$supplier_cd='';
$supplier_name='';
$supplier_address='';
$supplier_tel='';
$supplier_fax='';
$supplier_email='';
$subtotal='';
$ship_ref_no='';
$ship_batch_no='';

if ($_POST['event'] == 'save') {
	$submit_success = 0;

	$po_id = $_POST['po_id'];

	// Update PO
	$sql = "UPDATE po SET
			ship_ref_no = '".trim($_POST['ship_ref_no'])."',
			ship_batch_no = '".trim($_POST['ship_batch_no'])."',
			delivery_date = '".trim($_POST['delivery_date'])."',
			landing_date = '".trim($_POST['landing_date'])."',
			warehouse = '".trim($_POST['wareHouseCode'])."',
			po_complete_date = '".trim($_POST['po_completion_date'])."',
			close_po_flag = '".trim($_POST['po_status'])."',
			factory_staff_cd = '".trim($_POST['factory_staff_cd'])."',
			factory_staff_name = '".trim($_POST['factory_staff_name'])."'
			WHERE id = '$po_id'";
	sqlinsert($sql);
	
	// Update PO product
	// Chage sts to "C"
	$sql = "UPDATE po_product SET
			sts = 'C'
			where po_id = '$po_id' AND sts <> 'X' ";
	sqlinsert($sql);
	
	
	// Update Invoice status
	// Change sts to "C"
	$sql = "UPDATE invoice SET
			invoice_status = 'C'
			where po_id = '$po_id'";
	sqlinsert($sql);
	
	$sql = "UPDATE invoice_product SET
			sts = 'C'
			where invoice_id = (select id FROM invoice WHERE po_id = '$po_id') AND sts <> 'X' ";
	sqlinsert($sql);
	
	$submit_success = 1;
	$id = $po_id;
}

if ($po_id == '') {
	$po_id = $_GET['po_id'];
}

if ($po_id != '') {
	// Retrieve PO
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql = "SELECT * FROM po WHERE id = $po_id ";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$po_id=$row["id"];
		$invoice_id=$row["invoice_id"];
		
		$po_date=$row["po_date"];
		$entry_date=$row["entry_date"];
		$supplier_cd=$row["supplier_cd"];
		$supplier_name=$row["supplier_name"];
		$supplier_address=$row["supplier_address"];
		$supplier_tel=$row["supplier_tel"];
		$supplier_fax=$row["supplier_fax"];
		$supplier_email=$row["supplier_email"];
		$subtotal=$row["subtotal"];
		
		$ship_ref_no=$row["ship_ref_no"];
		$ship_batch_no=$row["ship_batch_no"];
		$delivery_date=$row["delivery_date"];
		$landing_date=$row["landing_date"];
		$warehouse=$row["warehouse"];
		$po_complete_date=$row["po_complete_date"];
		$close_po_flag=$row["close_po_flag"];
		$staff_cd=$row["staff_cd"];
		$staff_name=$row["staff_name"];
		
		$factory_staff_cd=$row["factory_staff_cd"];
		$factory_staff_name=$row["factory_staff_name"];
	}
	
	// Retrieve PO product
	$sql = "SELECT * FROM po_product WHERE po_id = $po_id AND sts <> 'X' ";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$goods_partno[$i+1] = $row["product_cd"];
		$goods_name[$i+1] = $row["product_name"];
		$sprod_remark[$i+1] = $row["remark"];
		$product_colour[$i+1] = $row["colour"];
		$pcs[$i+1] = $row["pcs_set"];
		$qty[$i+1] = $row["qty"];
		$unit_price[$i+1] = $row["unit_price"];
		$total[$i+1] = $row["total"];
	}
	
	$num_prod = $num_results;
}


?>