<?  
	 
	if (isset($_REQUEST['submitted'])) {
		$fix_inventory_qty=$_POST['fix_inventory_qty'];
		$product_id=$_POST['product_id'];
		 
		 
	
		if ($error_msg == '') {

		$product_photo=$product_id;
		$php_self = $_SERVER['PHP_SELF'];
		if (getprod_data($product_id)!='' and $product_id!=$_GET['product_id']) {
		 
			echo "<html><meta http-equiv='refresh' content='0; URL=$php_self?page=$page&subpage=prod_overview&product_id=".$_GET['product_id'].'></html>';
			exit;
		}
		//remove dit and photo
		 
		$o_getprod_row = getprod_data($product_id);
	 
			$upd_sql = "UPDATE product SET fix_inventory_qty='$fix_inventory_qty'";
				
				$sql = $upd_sql."where product_id = '$product_id'";
				sqlinsert($sql);
				
				 echo "<html><meta http-equiv='refresh' content='0; URL=$php_self?page=$page&subpage=prod_overview&prod_id=".$_REQUEST['product_id']."'></html>";
				 	exit;
	 
 		}
	 
	}
	 
/*********************
* Function
**********************/

function getProductData($product_id) {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT * FROM product where product_id = '".$product_id."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	$row=mysql_fetch_array($result);
	
	if ($row['alias'] == 'Y') {
		// Search by product_us_no
		$result = mysql_query("SELECT * FROM product where alias = '' and product_us_no = '".$product_id."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
		$num_results=mysql_num_rows($result);
		$row=mysql_fetch_array($result);
		
		if ($num_results == 0) {
			// Search by product_jp_no
			$result = mysql_query("SELECT * FROM product where alias = '' and product_jp_no = '".$product_id."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
			$num_results=mysql_num_rows($result);
			$row=mysql_fetch_array($result);
		}
	}
	
	mysql_free_result($result);
	mysql_close($db);
	
	return $row;
}
 

?>