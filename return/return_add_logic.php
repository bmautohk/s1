<?

$submit_success = '';
$id = '';

if ($_POST['event'] == 'save') {
	$submit_success = 0;

	$auto_po_flag=$_POST['auto_po_flag'];

	if ($auto_po_flag == "auto_po_flag") {
		$auto_po_flag = "Y";
		$inv_sts = "P";
	}
	else {
		$auto_po_flag = "N";
		$inv_sts = "C";
	}

	// Insert Return
	$user_name = $_SESSION['user_name'];
	$entry_date = trim($_POST['entry_date']);
	$sub_total = trim($_POST['subTotal']);
	
	// `entry_date``sales_id``sales_name``return_status``creation_date``created_by``subtotal``sales_cd``cust_cd``remarks`
	
	$sql = "INSERT INTO `return` SET
		 	return_date = '$return_date',
		 	entry_date = '$entry_date',
		 	sales_cd = '".trim($_POST['sales_cd'])."',
		 	sales_name = '".trim($_POST['sales_name'])."',
		 	return_status = 'P',
			remarks = '".trim($_POST['remarks'])."',
			created_by = '$user_name',
	 	  	subtotal = '$sub_total'";
	sqlinsert($sql);

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_ins_id = "SELECT LAST_INSERT_ID() id FROM dual";
	$result = mysql_query($sql_ins_id,$db) or die (mysql_error()."<br />Couldn't execute query: $sql_ins_id");
	$row = mysql_fetch_array($result);
	$return_id = $row["id"];
	
	// Insert Return product
	for ($k=1;$k<=30;$k++)
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
		//$product_colour = $row["product_colour"];
		$prod_pcs = $row["product_pcs"];
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
				currency_cd = 'RMB',
				colour = '$prod_colour',
				pcs_set = '$prod_pcs',
				make = '$prod_make_name',
				model = '$prod_model_name',
				color_no = '$prod_color_no',
				created_by = '$user_name',
				sts = 'P'";
		sqlinsert($sqla);		
	}

	$submit_success = 1;
	$id = $return_id;
}

?>
