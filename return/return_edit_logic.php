<?

$return_date = '';
$entry_date = '';
$sales_cd = '';
$sales_name = '';
$subTotal = '';

$submit_success = '';
$id = '';

if ($_POST['event'] == 'save') {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_ins_id = "SELECT LAST_INSERT_ID() id FROM dual";

	// Update Return
	$return_id = $_POST['return_id'];
	
	$return_date = trim($_POST['return_date']);
	$entry_date = trim($_POST['entry_date']);
	$sub_total = trim($_POST['subTotal']);
	
	$sql = "UPDATE `return` SET
		 	return_date = '$return_date',
		 	entry_date = '$entry_date',
		 	sales_cd = '".trim($_POST['sales_cd'])."',
		 	sales_name = '".trim($_POST['sales_name'])."',
	 	  	subtotal = '$sub_total',
			remarks = '".trim($_POST['remarks'])."'
			WHERE id = $return_id";
	sqlinsert($sql);

	// Process Return product
	for ($k=1;$k<=30;$k++)
	{
		$prod_cd = trim($_POST["goods_partno".$k]);
		$prod_return_prod_id = $_POST["return_prod_id".$k];	
		
		if ($prod_cd == '' and $prod_return_prod_id == '') {
			continue;
		}

		$prod_name = $_POST["goods_name".$k];
		$prod_remark = $_POST["goods_remark".$k];
		$prod_colour = $_POST["product_colour".$k];
		$prod_pcs = $_POST["pcs".$k];
		$prod_qty = $_POST["qty".$k];
		$prod_price = $_POST["unit_price".$k];
		$prod_total = $_POST["total".$k];
		
		if ($prod_cd != '' and $prod_return_prod_id == '') {
			// Insert new product
			$sql = "SELECT *
					FROM product
					WHERE product_id = '$prod_cd'";
	
			$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
			$row=mysql_fetch_array($result);	
			$prod_model_name = $row["product_model_no"];
			$prod_make_name = $row["product_made"];
			$prod_color_no = $row["product_colour_no"];
			
			$sqla = "INSERT INTO return_product SET
					return_id = '$return_id',
					product_cd = '$prod_cd',
					product_name = '$prod_name',
					remark = '$prod_remark',
					qty = '$prod_qty',
					unit_price = '$prod_price',
					total = '$prod_total',
					currency_cd = 'Yen',
					colour = '$prod_colour',
					pcs_set = $prod_pcs,
					make = '$prod_make_name',
					model = '$prod_model_name',
					color_no = '$prod_color_no',
					created_by = '$user_name',
					sts = (SELECT return_status FROM `return` WHERE id = $return_id)";
			sqlinsert($sqla);
			
		}
		else if ($prod_cd != '') {
			// Update original Return product
			$sqla = "UPDATE return_product SET
					product_cd = '$prod_cd',
					product_name = '$prod_name',
					remark = '$prod_remark',
					colour = '$prod_colour',
					pcs_set = '$prod_pcs',
					qty = '$prod_qty',
					unit_price = '$prod_price',
					total = '$prod_total'
					WHERE id = $prod_return_prod_id";
			sqlinsert($sqla);
		}
		else {
			// Delete records
			$sqla = "UPDATE return_product SET
					sts = 'X'
					WHERE id = $prod_return_prod_id";
			sqlinsert($sqla);
		}
		
	}

	$submit_success = 1;
	$id = $return_id;
}

if ($return_id == '') {
	$return_id=$_GET['return_id'];
}

if ($return_id != '') {	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);

	// Retrieve Return
	$sql = "SELECT * FROM `return` WHERE id = $return_id ";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	//loop
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$return_date=$row["return_date"];
		$entry_date = $row["entry_date"];
		$sales_cd = $row["sales_cd"];
		$sales_name = $row["sales_name"];
		$subTotal = $row["subtotal"];
		$remarks=$row["remarks"];
	}
	
	// Retrieve Return product
	$sql = "SELECT * FROM return_product WHERE return_id = $return_id AND sts <> 'X' ";
	
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	
	$num_results=mysql_num_rows($result);
	
	//loop
	for ($i=1;$i<=$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		
		$return_prod_id[$i] = $row["id"];
		$goods_partno[$i] = $row["product_cd"];
		$goods_name[$i] = $row["product_name"];
		$goods_remark[$i] = $row["remark"];
		$product_colour[$i] = $row["colour"];
		$qty[$i] = $row["qty"];
		$unit_price[$i] = $row["unit_price"];
		$total[$i] = $row["total"];
	}
}

?>
