<?php
	include('config.php');
	include('functions.php');
	
	$cust_cd = $_GET['cust_cd'];

	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$query = "SELECT * FROM customer WHERE cust_cd = '$cust_cd'";
	$result = mysql_query($query ,$db) or die (mysql_error()."Couldn't execute query: $query");
	
	$num_results=mysql_num_rows($result);
	
	$info = array();
	if ($num_results > 0) {
		$row=mysql_fetch_array($result);
		
		$info['cust_company_name'] = conv($row['cust_company_name']);
		$info['cust_post_address1']  = conv($row['cust_post_address1']);
		$info['cust_post_address2']  = conv($row['cust_post_address2']);
		$info['cust_tel']  = $row['cust_tel'];;
	}
	
	mysql_free_result($result);
	mysql_close($db);
	
	echo json_encode($info);
?>