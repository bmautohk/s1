<?

$po_date = '';
$entry_date = '';
$staff_cd = '';
$staff_name = '';;
$subTotal = '';
$remarks = '';

$submit_success = '';
$id = '';

if ($_POST['event'] == 'save') {
	$submit_success = 0;

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_ins_id = "SELECT LAST_INSERT_ID() id FROM dual";
	
	$ship_id = $_POST['ship_id'];
	$prod_n = $_POST['prod_n'];
	
	// Delete Shipping Header
/*	$sql = "UPDATE po_ship_header SET
	 	  	sts = 'X'
			WHERE id = $ship_id";
	sqlinsert($sql);*/
	
	// Update Shipping Header's subtotal
	$ship_date = trim($_POST['ship_date']);
	$entry_date = trim($_POST['entry_date']);
	$ship_subtotal = $_POST["subTotal"];
	$remarks = $_POST['remarks'];
	$wareHouseCode = $_POST['wareHouseCode'];
	
	$sql = "UPDATE po_ship_header SET
	 	  	ship_date = '$ship_date',
		 	entry_date = '$entry_date',
			staff_name = '".trim($_POST['staff_name'])."',
			staff_cd = '".trim($_POST['staff_cd'])."',
			subtotal = '$ship_subtotal',
			warehouse = '$wareHouseCode',
			remarks = '$remarks'
			WHERE id = $ship_id";
	sqlinsert($sql);
	
	// Update warehouse
	$sql = "UPDATE po_product_hist SET
			warehouse = '$wareHouseCode'
			WHERE po_ship_id = $ship_id";
	sqlinsert($sql);

	// Delete Shipping Item
	for ($k=1;$k<=$prod_n;$k++)
	{
		$prod_po_prod_hist_id = $_POST["po_prod_hist_id".$k];
		
		if (isset($_POST['delete_select'.$k])) {	
			$sqla = "SELECT * FROM po_product_hist WHERE id = $prod_po_prod_hist_id";
			$result = mysql_query($sqla ,$db) or die (mysql_error()."<br />Couldn't execute query: $sqla");
			$row=mysql_fetch_array($result);
			
			$orig_qty=$row["qty"];
			$orig_po_prod_id=$row["po_prod_id"];
			
			// Rollback PO product's shipping item count
			$sqlb = "UPDATE po_product SET
					ship_qty = ship_qty - $orig_qty
					WHERE id = $orig_po_prod_id";
			sqlinsert($sqlb);
			
			// Delete records
			$sqlc = "UPDATE po_product_hist SET
					sts = 'X'
					WHERE id = $prod_po_prod_hist_id";
			sqlinsert($sqlc);
		}
		else {
			$prod_pack_no = $_POST['pack_no'.$k];
			$sqlc = "UPDATE po_product_hist SET
					pack_no = '$prod_pack_no'
					WHERE id = $prod_po_prod_hist_id";
			sqlinsert($sqlc);
		}
	}

	$submit_success = 1;
	$id = $ship_id;
}

if ($ship_id == '') {
	$ship_id=$_GET['ship_id'];
}

if ($ship_id != '') {	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);

	// Retrieve shipping header
	$sql = "SELECT * FROM po_ship_header WHERE id = $ship_id ";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$ship_id=$row["id"];

		$ship_date = $row["ship_date"];
		$entry_date = $row["entry_date"];
		$staff_cd = $row["staff_cd"];
		$staff_name = $row["staff_name"];
/*		$supp_cd = $row["supplier_cd"];
		$supp_name = $row["supplier_name"];
		$supp_address = $row["supplier_address"];
		$supp_tel = $row["supplier_tel"];
		$supp_fax = $row["supplier_fax"];
		$supp_email = $row["supplier_email"];*/
		$subTotal = $row["subtotal"];
		$warehouse=$row["warehouse"];
		$remarks = $row["remarks"];
	}
	
	// Retrieve shipping history
	$sql = "SELECT t1.*, t2.po_id, t2.product_cd, t2.product_name
	FROM po_product_hist t1, po_product t2
	WHERE t1.po_prod_id = t2.id AND po_ship_id = $ship_id AND t1.sts <> 'X' order by t1.id";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	$prod_n = $num_results;
	
	//loop
	for ($i=1;$i<=$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$po_prod_hist_id[$i] = $row["id"];
		$po_id[$i] = $row["po_id"];
		$goods_partno[$i] = $row["product_cd"];
		$goods_name[$i] = $row["product_name"];
		$ship_qty[$i] = $row["qty"];
		$pack_no[$i] = $row["pack_no"];
	}
}

?>
