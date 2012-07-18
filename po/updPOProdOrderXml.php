<?php
	header('Content-Type: text/html');
	include_once('../functions.php');
	
	$po_prod_id = $_GET['po_prod_id'];
	$sql = "UPDATE po_product SET ordered = 'Y' WHERE id = '$po_prod_id' ";
	sqlinsert($sql);
?>