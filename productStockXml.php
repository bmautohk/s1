<?php
	header('Content-Type: text/xml');
	require('config.php');
	require('functions.php');
	
	$product_id = $_GET['product_id'];

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$query = "SELECT * FROM product where product_id = '$product_id'";
	$result = mysql_query($query ,$db) or die (mysql_error()."Couldn't execute query: $query");

    echo '<?xml version="1.0" encoding="euc-jp"?><product>';
	
	$num_results=mysql_num_rows($result);

	if ($num_results != 0) {
		// Product exists
		$result = getProductRealStockByProdId($db, $product_id);
		$row=mysql_fetch_array($result);
		$real_stock = $row['real_stock'];
		echo "<real_stock>" .$real_stock. "</real_stock>";
	}
	mysql_close($db);
	
	echo "</product>";
?>