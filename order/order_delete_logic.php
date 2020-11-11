<?
$sprod_no=$_GET['sprod_no'];
$sale_ref=$_GET['sale_ref'];

// Check payment existence
$db=connectDatabase();
mysql_select_db(DB_NAME,$db);

$query = "SELECT * FROM ben_bal where bal_ref = '$sale_ref'";
$result = mysql_query($query ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
$num_results=mysql_num_rows($result);

mysql_free_result($result);
mysql_close($db);

if ($num_results == 0) {
	// No payment
	$sql = "delete from ben_sale_prod where sprod_no = $sprod_no";
	sqlinsert($sql);
	$is_delete = 'Y';
} else {
	$is_delete = 'N';
	$error_messgae = 'Payment is created.';
}

echo "<html><meta http-equiv='refresh' content='0; URL=index.php?page=order&subpage=edit&sale_ref=$sale_ref&is_delete=$is_delete&error_message=$error_messgae'></html>";
?>