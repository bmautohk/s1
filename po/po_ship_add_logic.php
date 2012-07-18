<?
$submit_success = '';
$id = '';

if ($_POST['event'] == 'create') {
	$prod_n = 0;
	$subTotal = 0;
	
	$total_prod_cnt = $_POST['prod_n'];
	$ship_select = $GLOBALS['ship_select'];
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);

	$prod_n = count($ship_select);
	for ($k = 1; $k <= $prod_n; $k++) {
		$i = $ship_select[$k-1];
		
		$po_prod_id[$k] = $_POST['po_prod_id'.$i];
		$ship_qty[$k] = $_POST['ship_qty'.$i]; if ($ship_qty[$k] == '') $ship_qty[$k] = 0;

		$sql = "SELECT * FROM po_product WHERE id = $po_prod_id[$k]";
		$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
		$row = mysql_fetch_array($result);
		
		$po_id[$k] = $row['po_id'];
		$goods_partno[$k] = $row["product_cd"];
		$goods_name[$k] = $row["product_name"];
		$goods_remark[$k] = $row["remark"];
		$product_colour[$k] = $row["colour"];
		$pcs[$k] = $row["pcs_set"];
		$po_qty[$k] = $row["qty"];
		$shiped_qty = $row['ship_qty'];
		$remain_qty[$k] = $po_qty[$k] - $shiped_qty;
		
		$subTotal = $subTotal + $ship_qty[$k];
	}
}
else if ($_POST['event'] == 'save') {
	$event = 'save';
	$submit_success = 0;

	$user_name = $_SESSION['user_name'];

	$ship_date = trim($_POST['ship_date']);
	$entry_date = trim($_POST['entry_date']);
	$subTotal = trim($_POST['subTotal']);
	$prod_n = $_POST['prod_n'];
	
	$wareHouse = $_POST['wareHouseCode'];
	
	//insert Shipping Header
	$sql = "INSERT INTO po_ship_header SET
	 	  	ship_date = '$ship_date',
		 	entry_date = '$entry_date',
		 	staff_id = 0,
			staff_name = '".trim($_POST['staff_name'])."',
			staff_cd = '".trim($_POST['staff_cd'])."',
			supplier_id = '0',
			subtotal = '$subTotal',
			warehouse = '$wareHouse',
	 	  	created_by = '$user_name',
			remarks = '".trim($_POST['remarks'])."'";
	sqlinsert($sql);

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT LAST_INSERT_ID() id FROM dual" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$row = mysql_fetch_array($result);
	$po_ship_id = $row["id"];

	//insert Product History
	for ($k=1;$k<=$prod_n;$k++)
	{
		$po_prod_id = $_POST['po_prod_id'.$k];
		$ship_qty = $_POST['ship_qty'.$k];
		$product_cd = $_POST['goods_partno'.$k];
		
		$sqla = "INSERT INTO po_product_hist SET
					po_prod_id = '$po_prod_id',
					po_ship_id = '$po_ship_id',
					product_cd = '$product_cd',
					qty = '$ship_qty',
					warehouse = '$wareHouse',
					created_by = '$user_name'";
	 
		sqlinsert($sqla);
		
		// update po product's ship_qty
		$sqlb = "UPDATE po_product SET
					ship_qty = ship_qty + '$ship_qty'
					WHERE id = '$po_prod_id'";
		sqlinsert($sqlb);
	}

	$submit_success = 1;
	$id = $po_ship_id;
}

?>