<?

$db=connectDatabase();
mysql_select_db(DB_NAME,$db);

// Get make
$result = mysql_query("SELECT * FROM ben_make order by make_id" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
$num_results=mysql_num_rows($result);

$makes = array();
for ($i=0;$i<$num_results;$i++){
	$row=mysql_fetch_array($result);
	$makes[] = $row;
}

// Free resultset
mysql_free_result($result);

if (isset($isfind)) {
//search product
	$sql_select = 'SELECT p.* ';
	
	$sql = " FROM product as p where (alias is null or alias <> 'Y') ";
	
	if (isset($sprod_id) && $sprod_id != '') {
		$sql = $sql." and product_id like '%$sprod_id%'";
	}
	
	if (isset($sagawa_label) && $sagawa_label != '') {
		$sql = $sql." and sagawa_label like '$sagawa_label'";
	}
	
	// Product JP No (Alias)
	if (isset($product_jp_no) && $product_jp_no != '') {
		$sql = $sql." and product_jp_no like '%$product_jp_no%'";
	}
	
	// Product US No (Alias)
	if (isset($product_us_no) && $product_us_no != '') {
		$sql = $sql." and product_us_no like '%$product_us_no%'";
	}
	
	// Make
	if (isset($make_id) && $make_id != '') {
		$sql = $sql." and make_id = $make_id";
	}
	
	// Model
	if (isset($product_model) && $product_model != '') {
		$sql = $sql." and product_model = '$product_model'";
	}
	
	// Model No
	if (isset($product_model_no) && $product_model_no != '') {
		$sql = $sql." and product_model_no like '%$product_model_no%'";
	}
	
	// Year
	if (isset($product_year) && $product_year != '') {
		$sql = $sql." and product_year like '%$product_year%'";
	}
	
	// Item Group
	if (isset($cat_id) && $cat_id != '') {
		$sql = $sql." and cat_id = $cat_id";
	}
	
	// PCS
	if (isset($product_pcs_min) && $product_pcs_min != '') {
		$sql = $sql." and product_pcs >= $product_pcs_min";
	}
	if (isset($product_pcs_max) && $product_pcs_max != '') {
		$sql = $sql." and product_pcs <= $product_pcs_max";
	}
	
	// PCS (JP)
	if (isset($product_stock_jp_min) && $product_stock_jp_min != '') {
		$sql = $sql." and product_stock_jp >= $product_stock_jp_min";
	}
	if (isset($product_stock_jp_max) && $product_stock_jp_max != '') {
		$sql = $sql." and product_stock_jp <= $product_stock_jp_max";
	}
	
	// Item Description
	if (isset($product_name) && $product_name != '') {
		$sql = $sql." and product_name like '%$product_name%'";
	}
	
	// Colour
	if (isset($product_colour) && $product_colour != '') {
		$sql = $sql." and product_colour like '%$product_colour%'";
	}
	
	// Colour No
	if (isset($product_colour_no) && $product_colour_no != '') {
		$sql = $sql." and product_colour_no like '%$product_colour_no%'";
	}
	
	// Original Color
	if (isset($product_original_color) && $product_original_color != '') {
		$sql = $sql." and product_original_color like '%$product_original_color%'";
	}
	
	// Remark
	if (isset($product_remark) && $product_remark != '') {
		$sql = $sql." and product_remark like '%$product_remark%'";
	}
	
	// Custom Descrption
	if (isset($product_cus_des) && $product_cus_des != '') {
		$sql = $sql." and product_cus_des like '%$product_cus_des%'";
	}
	
	// Stock Level
	if (isset($product_stock_level) && $product_stock_level != '') {
		$sql = $sql." and product_stock_level like '%$product_stock_level%'";
	}
	
	// Location
	if (isset($product_location) && $product_location != '') {
		$sql = $sql." and product_location like '%$product_location%'";
	}
	
	// Supplier
	if (isset($product_sup) && $product_sup != '') {
		$sql = $sql." and product_sup like '%$product_sup%'";
	}
	
	// User Price
	if (isset($product_price_u_min) && $product_price_u_min != '') {
		$sql = $sql." and product_price_u >= $product_price_u_min";
	}
	if (isset($product_price_u_max) && $product_price_u_max != '') {
		$sql = $sql." and product_price_u <= $product_price_u_max";
	}
	
	// Custom Price
	if (isset($product_cus_price_min) && $product_cus_price_min != '') {
		$sql = $sql." and product_cus_price >= $product_cus_price_min";
	}
	if (isset($product_cus_price_max) && $product_cus_price_max != '') {
		$sql = $sql." and product_cus_price <= $product_cus_price_max";
	}
	
	// Auction Price
	if (isset($product_auction_p_min) && $product_auction_p_min != '') {
		$sql = $sql." and product_auction_p >= $product_auction_p_min";
	}
	if (isset($product_auction_p_max) && $product_auction_p_max != '') {
		$sql = $sql." and product_auction_p <= $product_auction_p_max";
	}
	
	// Selling Price
	if (isset($product_price_s_min) && $product_price_s_min != '') {
		$sql = $sql." and product_price_s >= $product_price_s_min";
	}
	if (isset($product_price_s_max) && $product_price_s_max != '') {
		$sql = $sql." and product_price_s <= $product_price_s_max";
	}
	
	// Cost (RMB)
	if (isset($product_cost_rmb_min) && $product_cost_rmb_min != '') {
		$sql = $sql." and product_cost_rmb >= $product_cost_rmb_min";
	}
	if (isset($product_cost_rmb_max) && $product_cost_rmb_max != '') {
		$sql = $sql." and product_cost_rmb <= $product_cost_rmb_max";
	}
	
	// Magazine
	if (isset($maz) && $maz != '') {
		$sql = $sql." and maz like '%$maz%'";
	}
	
	// Display on Web
	if (isset($product_web)) {
		if ($product_web ==  'Y') {
			$sql = $sql." and product_web = '1' ";
		}
		else if ($product_web == 'N') {
			$sql = $sql." and (product_web is null or product_web <> '1') ";
		}
	}
	
	// QC
	if (isset($product_qc)) {
		if ($product_qc ==  'Y') {
			$sql = $sql." and product_qc = 'Y' ";
		}
		else if ($product_qc == 'N') {
			$sql = $sql." and (product_qc is null or product_qc <> 'Y') ";
		}
	}
	
	//
	if (isset($prod_on_order)) {
		if ($prod_on_order ==  'Y') {
			$sql = $sql." and prod_on_order = 'Y' ";
		}
		else if ($prod_on_order == 'N') {
			$sql = $sql." and (prod_on_order is null or prod_on_order <> 'Y') ";
		}
	}
	
	$sql = $sql." order by product_id ";
	
	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];
	if (!$zpage) {
		$zpage = 1;
	}
	
	if ($num_rows == '') {
		$query = mysql_query("SELECT count(p.product_id) rec_cnt ".$sql,$db);
		$row=mysql_fetch_array($query);
		$num_rows=$row['rec_cnt'];
	}
	
	$page_start = ($per_page * $zpage) - $per_page;

	$sql = $sql_select.$sql." LIMIT $page_start, $per_page";
	
	$result = mysql_query($sql) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	
	$products = array();
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		$products[] = $row;
	}

	$searchKey = '&'.$_SERVER['QUERY_STRING'];
	$searchKey = remove_querystring_var($searchKey, 'num_rows');
	$searchKey = remove_querystring_var($searchKey, 'zpage');
	$searchKey = remove_querystring_var($searchKey, 'subpage');
	$searchKey = remove_querystring_var($searchKey, 'page');
	$searchKey = $searchKey."&num_rows=$num_rows";
	
	// Free resultset
	mysql_free_result($result);
}

// Closing connection
mysql_close($db);
?>