<?php
	header('Content-Type: text/html');
	include_once('../functions.php');
	
	$invoice_id = $_GET['invoice_id'];

	$db=connectDatabase();
	mysql_select_db("autopart_db",$db);
	$query = "SELECT * FROM invoice where id = '$invoice_id'";
	$result = mysql_query($query ,$db) or die (mysql_error()."Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	if ($num_results > 0) {
		echo '<span style="color:blue">Invoice Exists</span>';
	} else {
		echo '<span style="color:red">Invoice Not Exists</span>';
	}
	mysql_close($db);
?>