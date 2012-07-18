<?

$submit_success = '';
$id = '';

//get Number of product
if (isset($_GET['prod_n']))
{$prod_n =trim($_GET['prod_n']);} else {$prod_n=$INIT_NUM_OF_PROD;}

if ($_POST['event'] == 'save') {
	$submit_success = 0;
	
	//insert instock
	$user_name = $_SESSION['user_name'];
	
	$stock_date = trim($_POST['stock_date']);
	$sub_total = trim($_POST['subTotal']);
	$remarks = trim($_POST['remarks']);
	
	$sql = "INSERT INTO temp_outstock SET
		 	stock_date = '$stock_date',
			subtotal = '$sub_total',
			user_remarks = '$remarks',
			created_by = '$user_name'";
	sqlinsert($sql);

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$sql_ins_id = "SELECT LAST_INSERT_ID() id FROM dual";
	$result = mysql_query($sql_ins_id,$db) or die (mysql_error()."<br />Couldn't execute query: $sql_ins_id");
	$row = mysql_fetch_array($result);
	$outstock_id = $row["id"];
	
	//insert instock product
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
		$prod_warehouse = $_POST["wareHouseCode".$k];

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

		$sqla = "INSERT INTO temp_outstock_product SET
				outstock_id = '$outstock_id',
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
				warehouse = '$prod_warehouse',
				created_by = '$user_name'";
		sqlinsert($sqla);
	}

	$submit_success = 1;
	$id = $outstock_id;
}

?>