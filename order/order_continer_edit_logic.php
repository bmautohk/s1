<?php

$id = $_REQUEST['id'];
$action = $_REQUEST['action'];

if ($action == 'save') {
	// Update existing container
	$packingNo = $_REQUEST['packing_no'];
	$userName = $_SESSION['user_name'];
	
	$sql = "UPDATE container SET
	packing_no = '".$packingNo."',
	product_id = '".$_REQUEST['product_id']."',
	qty = '".$_REQUEST['qty']."',
	color = '".$_REQUEST['color']."',
	piece = '".$_REQUEST['piece']."',
	custom = '".$_REQUEST['custom']."',
	last_upd_by = '$userName'
	where id = $id
	";
	
	sqlinsert($sql);
	
	$msg = "Update container [packing no = $packingNo] successfully!";
}


$db=connectDatabase();
mysql_select_db(DB_NAME,$db);
$result = mysql_query("SELECT * FROM container WHERE id = $id " ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");

if (mysql_num_rows($result) > 0) {
	$row = mysql_fetch_array($result);

	$container['id'] = $row['id'];
	$container['packing_no'] = $row['packing_no'];
	$container['product_id'] = $row['product_id'];
	$container['qty'] = $row['qty'];
	$container['color'] = $row['color'];
	$container['piece'] = $row['piece'];
	$container['custom'] = $row['custom'];
}

?>
