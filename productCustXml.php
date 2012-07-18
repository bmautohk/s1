<?php
	include('config.php');
	include('functions.php');
	
	$product_id = $_GET['product_id'];
	$cust_cd = $_GET['cust_cd'];

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$query = "SELECT t1.*, t2.market_price FROM product t1 left outer join (cust_prod_price t2 join customer t3 on t2.cust_id = t3.id and t3.cust_cd = '$cust_cd') on t1.product_id = t2.product_id where t1.product_id = '$product_id'";
	$result = mysql_query($query ,$db) or die (mysql_error()."Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$info = array();
	if ($num_results > 0) {
		$row=mysql_fetch_array($result);
		
		$info['product_id'] = $row['product_id'];
		$info['product_name'] = conv($row['product_name']);
		$info['product_remark'] = conv($row['product_remark']);
		$info['product_cost_rmb'] = $row['product_cost_rmb'];
		$info['product_pcs'] = $row['product_pcs'];
		$info['product_colour'] = conv($row['product_colour']);
		
		if ($row['market_price'] == null) {
			$info['product_price_s'] = $row['product_price_s'];
		}
		else {
			$info['product_price_s'] = $row['market_price'];
		}
	}
	
	mysql_free_result($result);
	mysql_close($db);
	
	echo json_encode($info);
?>