<?php
include_once('../config.php');
include_once('../functions.php');

$db = mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD);
$db_pm = mysql_connect($server_pm, $dbusername_pm, $dbpassword_pm);

//$pm_product_sql = "select no_jp, made, model, model_no, year, item_group, material, product_desc_jp, pcs, colour, colour_no, supplier, kaito from product_master where prod_sn = '3174'";
$pm_product_sql = "select no_jp, made, model, model_no, year, item_group, material, product_desc_jp, pcs, colour, colour_no, supplier, kaito, other from product_master";

$products = array();

// Retrieve product from pmkaito
mysql_select_db($db_name_pm, $db_pm);
mysql_query("SET NAMES 'ujis'", $db_pm);
mysql_query("SET CHARACTER_SET_CLIENT=ujis", $db_pm);
mysql_query("SET CHARACTER_SET_RESULTS=ujis", $db_pm);

$result = mysql_query($pm_product_sql, $db_pm) or die (mysql_error()."<br />Couldn't execute query: $pm_product_sql");

$num_results = mysql_num_rows($result);
for ($i = 0; $i < $num_results; $i++) {
	$row = mysql_fetch_array($result);
	
	if (array_key_exists($row['no_jp'], $products)) {
		// Exist in pm
		$products[$row['no_jp']] = $row;
	}
	else {
		// Not exist in pm
		$products[$row['no_jp']] = $row;
	}
}

mysql_free_result($result);

// Update product in S1
mysql_select_db(DB_NAME, $db);
mysql_query("SET NAMES 'latin1'", $db);
mysql_query("SET CHARACTER_SET_CLIENT=latin1", $db);
mysql_query("SET CHARACTER_SET_RESULTS=latin1", $db);

syncS1Product($products, $db);

function syncS1Product($products, $db) {
	$mades = array();
	$categories = array();
	
	foreach ($products as $product) {
		$no_jp = $product['no_jp'];
		$made = replace($product['made']);
		$model = replace($product['model']);
		$model_no = replace($product['model_no']);
		$year = replace($product['year']);
		$item_group = replace($product['item_group']);
		$material = replace($product['material']);
		$product_desc_jp = replace($product['product_desc_jp']);
		$pcs = $product['pcs'];
		$colour = replace($product['colour']);
		$colour_no = replace($product['colour_no']);
		$supplier = replace($product['supplier']);
		$kaito = $product['kaito'];
		$other = $product['other'];
		$kaito = $product['kaito'];
		
		// Get make
		if (array_key_exists($made, $mades)) {
			$made_id = $mades[$made];
		}
		else {
			$made_id = getMake($made, $db);
			$mades[$made] = $made_id;
		}
		
		// Get category
		if (array_key_exists($item_group, $categories)) {
			$cat_id = $categories[$item_group];
		}
		else {
			$cat_id = getCategory($item_group, $db);
			$categories[$item_group] = $cat_id;
		}
		
		$sql = "select 1 from product where product_id = '".$no_jp."'";
		$result = mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $sql");
		$num_results = mysql_num_rows($result);
		mysql_free_result($result);
		
		if ($num_results > 0) {
			// Update
			$sql = "update product set
							make_id = ".$made_id.",
							product_made = '".$made."',
							product_model = '".$model."',
							product_model_no = '".$model_no."',
							product_year = '".$year."',
							cat_id = ".$cat_id.",
							product_group = '".$item_group."',
							product_material = '".$material."',
							product_name = '".$product_desc_jp."',
							product_pcs = '".$pcs."',
							product_colour = '".$colour."',
							product_colour_no = '".$colour_no."',
							product_sup = '".$supplier."',
							product_cost_rmb = '".$kaito."',
							product_price_s = '".$other."'
							where product_id = '".$no_jp."'
							";
		}
		else {
			// Create
			$sql = "INSERT INTO product
			(product_id, 
			make_id, 
			product_made, 
			product_model, 
			product_model_no, 
			product_year, 
			cat_id,
			product_group, 
			product_material, 
			product_name, 
			product_pcs, 
			product_colour, 
			product_colour_no, 
			product_sup, 
			product_cost_rmb,
			product_price_s) 
			VALUES
			('".$no_jp."', ".
			$made_id.", '".
			$made."', '".
			$model."', '".
			$model_no."', '".
			$year."', '".
			$cat_id."', '".
			$item_group."', '".
			$material."', '".
			$product_desc_jp."', '".
			$pcs."' ,'".
			$colour."', '".
			$colour_no."', '".
			$supplier."', '".
			$kaito."', '".
			$other."')";
		}
		
		//echo $sql;
		
		mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $sql");
		
	}
}

function getMake($make_name, $db) {
	$make_id = 0;
	
	$sql = "SELECT make_id FROM ben_make WHERE make_name = '".$make_name."'";
	$result = mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	$num_results = mysql_num_rows($result);
	if ($num_results > 0) {
		$row = mysql_fetch_array($result);
		$make_id = $row['make_id'];
	}
	else {
		// Create new make
		$sql = "INSERT INTO ben_make (make_name) VALUES ('".$make_name."')";
		mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $sql");
		
		$sql = "SELECT make_id FROM ben_make WHERE make_name = '".$make_name."'";
		$result2 = mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $sql");
		$row = mysql_fetch_array($result2);
		$make_id = $row['make_id'];
		mysql_free_result($result2);
	}
	
	mysql_free_result($result);
	
	return $make_id;
}

function getCategory($cat_name, $db) {
	$cat_id = 0;
	
	$sql = "SELECT cat_id FROM ben_cat WHERE cat_name = '".$cat_name."'";
	$result = mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	$num_results = mysql_num_rows($result);
	if ($num_results > 0) {
		$row = mysql_fetch_array($result);
		$cat_id = $row['cat_id'];
	}
	else {
		// Create new category
		$sql = "INSERT INTO ben_cat (cat_name) VALUES ('".$cat_name."')";
		mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $sql");
		
		$sql = "SELECT cat_id FROM ben_cat WHERE cat_name = '".$cat_name."'";
		$result2 = mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $sql");
		$row = mysql_fetch_array($result2);
		$cat_id = $row['cat_id'];
		mysql_free_result($result2);
	}
	
	mysql_free_result($result);
	
	return $cat_id;
}

function replace($str) {
	return str_replace("'", "''", $str);
}
?>
