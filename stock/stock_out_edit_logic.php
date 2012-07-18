<?

$stock_date = '';
$submit_success = '';

if ($_POST['event'] == 'save') {
	$submit_success = 0;
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_ins_id = "SELECT LAST_INSERT_ID() id FROM dual";

	// Update Stock
	$prod_n = $_POST['prod_n'];
	
	$stock_id = $_POST['stock_id'];
	
	$stock_date = trim($_POST['stock_date']);
	$sub_total = trim($_POST['subTotal']);
	$remarks = trim($_POST['remarks']);
	
	$sql = "UPDATE temp_outstock SET
		 	stock_date = '$stock_date',
	 	  	subtotal = '$sub_total',
			user_remarks = '$remarks'
			WHERE id = $stock_id";
	sqlinsert($sql);

	// Process stock product
	for ($k=1;$k<=$prod_n;$k++)
	{
		$prod_cd = trim($_POST["goods_partno".$k]);
		$prod_stock_prod_id = $_POST["stock_prod_id".$k];
		
		if ($prod_cd == '' and $prod_stock_prod_id == '') {
			continue;
		}
		
		$prod_name = $_POST["goods_name".$k];
		$prod_remark = $_POST["goods_remark".$k];
		$prod_colour = $_POST["product_colour".$k];
		$prod_pcs = $_POST["pcs".$k];
		$prod_qty = $_POST["qty".$k];
		$prod_price = $_POST["unit_price".$k];
		$prod_total = $_POST["total".$k];
		$prod_warehouse = $_POST["wareHouseCode".$k];
		
		if ($prod_cd != '' and $prod_stock_prod_id == '') {
			// Insert new product
			$sql = "SELECT *
					FROM product
					WHERE product_id = '$prod_cd'";
	
			$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
			$row=mysql_fetch_array($result);
	
			$prod_model_name = $row["product_model_no"];
			$prod_make_name = $row["product_made"];
			$prod_color_no = $row["product_colour_no"];
			
			$sqla = "INSERT INTO temp_outstock_product SET
					outstock_id = '$stock_id',
					product_cd = '$prod_cd',
					product_name = '$prod_name',
					remark = '$prod_remark',
					qty = '$prod_qty',
					unit_price = '$prod_price',
					total = '$prod_total',
					currency_cd = 'Yen',
					colour = '$prod_colour',
					pcs_set = $prod_pcs,
					make = '$prod_make',
					model = '$prod_model_name',
					color_no = '$prod_color_no',
					warehouse = '$prod_warehouse',
					created_by = '$user_name'";
			sqlinsert($sqla);
			
		}
		else if ($prod_cd != '') {
			// Update original stock product
			$sqla = "UPDATE temp_outstock_product SET
					product_cd = '$prod_cd',
					product_name = '$prod_name',
					remark = '$prod_remark',
					colour = '$prod_colour',
					pcs_set = '$prod_pcs',
					qty = '$prod_qty',
					unit_price = '$prod_price',
					total = '$prod_total',
					warehouse = '$prod_warehouse'
					WHERE id = $prod_stock_prod_id";
			sqlinsert($sqla);
		}
		else {
			// Delete records
			$sqla = "UPDATE temp_outstock_product SET
					sts = 'X'
					WHERE id = $prod_stock_prod_id";
			sqlinsert($sqla);
		}
		
	}

	$submit_success = 1;
	$id = $stock_id;
}

if ($stock_id == '') {
	$stock_id=$_GET['stock_id'];
}

if ($stock_id != '') {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);

	// Retrieve stock
	$sql = "SELECT * FROM temp_outstock WHERE id = $stock_id ";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);

	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$stock_date = $row["stock_date"];
		$subTotal = $row["subtotal"];
		$remarks = $row["user_remarks"];
	}
	
	// Retrieve stock product
	$sql = "SELECT * FROM temp_outstock_product WHERE outstock_id = $stock_id AND sts <> 'X' ";
	
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
		
		$stock_prod_id[$i] = $row["id"];
		$goods_partno[$i] = $row["product_cd"];
		$goods_name[$i] = $row["product_name"];
		$goods_remark[$i] = $row["remark"];
		$product_colour[$i] = $row["colour"];
		$pcs[$i] = $row["pcs_set"];
		$qty[$i] = $row["qty"];
		$unit_price[$i] = $row["unit_price"];
		$total[$i] = $row["total"];
		$warehouse[$i] = $row["warehouse"];
	}
}

?>
