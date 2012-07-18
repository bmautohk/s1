<?php
	header('Content-Type: text/xml');
	require('config.php');
	require('functions.php');
	
	$product_id = $_GET['product_id'];

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$query = "SELECT * FROM product where product_id = '$product_id'";
	$result = mysql_query($query ,$db) or die (mysql_error()."Couldn't execute query: $query");
	
	/*echo '<?xml version="1.0" encoding="ISO-8859-1"?><product>';*/
    echo '<?xml version="1.0" encoding="euc-jp"?><product>';
	
	$num_results=mysql_num_rows($result);
	for ($i=0;$i<$num_results;$i++)
	{
		$row=mysql_fetch_array($result);
		echo "<product_id>" . $row['product_id'] . "</product_id>";
		echo "<product_name>" . $row['product_name'] . "</product_name>";
		echo "<product_remark>" . $row['product_remark'] . "</product_remark>";
		echo "<product_price_s>" . $row['product_price_s'] . "</product_price_s>";
		echo "<product_cost_rmb>" . $row['product_cost_rmb'] . "</product_cost_rmb>";
		echo "<product_pcs>" . $row['product_pcs'] . "</product_pcs>";
		echo "<product_colour>" . $row['product_colour'] . "</product_colour>";
	}
	
	mysql_close($db);
	
	echo "</product>";
?>