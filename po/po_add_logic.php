<?

$submit_success = '';
$id = '';

//get Number of product
if (isset($_GET['prod_n']))
{$prod_n =trim($_GET['prod_n']);} else {$prod_n=$INIT_NUM_OF_PROD;}

if ($_POST['event'] == 'save') {
	$submit_success = 0;

	$user_name = $_SESSION['user_name'];
	
	$po_date = trim($_POST['po_date']);
	$entry_date = trim($_POST['entry_date']);
	$sub_total = trim($_POST['subTotal']);
	
	//insert PO
	$sql = "INSERT INTO po SET
	 	  	po_date = '$po_date',
		 	entry_date = '$entry_date',
		 	staff_id = 0,
			staff_name = '".trim($_POST['staff_name'])."',
			staff_cd = '".trim($_POST['staff_cd'])."',
			supplier_id = '0',
			supplier_name = '".trim($_POST['supp_name'])."',
			supplier_cd = '".trim($_POST['supp_cd'])."',
			supplier_address = '".trim($_POST['supp_address'])."',
		 	supplier_tel = '".trim($_POST['supp_tel'])."',
			supplier_fax = '".trim($_POST['supp_fax'])."',
		 	supplier_email = '".trim($_POST['supp_email'])."',
			subtotal = '$sub_total',
			ship_ref_no = '',
			ship_batch_no = '',
			delivery_date = '',
			landing_date = '',
			warehouse = '',
			close_po_flag = '',
			factory_staff_id = '',
			factory_staff_name = 'N/A',
			po_complete_date = '',
			invoice_id = '".trim($_POST['invoice_id'])."',
	 	  	created_by = '$user_name',
			remarks = '".trim($_POST['remarks'])."'";
	sqlinsert($sql);

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT LAST_INSERT_ID() id FROM dual" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$row = mysql_fetch_array($result);
	$po_id = $row["id"];

	//insert PO product
	for ($k=1;$k<=30;$k++)
	{
		$prod_cd = trim($_POST["goods_partno".$k]);
		if ($prod_cd == '') {
			continue;
		}		
		
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
					product_name = '".trim($_POST["goods_name".$k])."',
					remark = '".trim($_POST["goods_remark".$k])."',
					qty = '".trim($_POST["qty".$k])."',
					unit_price = '".trim($_POST["unit_price".$k])."',
					total = '".trim($_POST["total".$k])."',
					currency_cd = 'Yen',
					colour = '".trim($_POST["product_colour".$k])."',
					pcs_set = '".trim($_POST["pcs".$k])."',
					make = '$prod_make_name',
					model = '$prod_model_name',
					color_no = '$prod_color_no',
					created_by = '$user_name',
					sts = 'P' ";
		 
		sqlinsert($sqla);
	}
	
	$submit_success = 1;
	$id = $po_id;
}
?>