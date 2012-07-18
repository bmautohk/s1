<?php
	include('config.php');
	include('functions.php');
	
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	$products = $_GET['product_id'];
	
	if (isset($products)) {
		$invalidProductList = array();
		foreach($products as $product_id) {
			$query = "select product_id from product where product_id = '$product_id' ";
			$result = mysql_query($query ,$db) or die (mysql_error()."Couldn't execute query: $query");
			
			$num_results = mysql_num_rows($result);
			
			if ($num_results == 0) {
				$invalidProductList[] = $product_id;
			}
			
			mysql_free_result($result);
		}
		
		echo json_encode($invalidProductList);
	}
	
	mysql_close($db);
?>