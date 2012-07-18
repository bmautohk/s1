<?php

$db=connectDatabase();
mysql_select_db(DB_NAME,$db);

$customer = array();
$message = '';
if (isset($cust_id)) {
	if (isset($isedit)) {
		// Update exisiting customer
		if (isCustCodeExist($db, $cust_cd, $cust_id)) {
			$message = "<font color='red'>Customer Code [$cust_cd] has already existed. Please change the customer code.</font>";
		}
		else {
			$cust_cd = trim($cust_cd);
			
			$sql = "UPDATE customer SET
					cust_cd = '$cust_cd',
					cust_company_name = '$cust_company_name',
					cust_contact_name = '$cust_contact_name',
					cust_tel = '$cust_tel',
					cust_post_cd = '$cust_post_cd',
					cust_post_address1 = '$cust_post_address1',
					cust_post_address2 = '$cust_post_address2',
					website = '$website',
					password = '$pw',
					modify_by = '$user_name'
					WHERE id = $cust_id ";
			
			sqlinsert($sql);
			
			$message = "Customer [$cust_cd] is updated successfully.";
		}
	}
	else {
		// Display customer
		$sql = "SELECT * FROM customer WHERE id = $cust_id ";
		$result = mysql_query($sql ,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
		$num_results = mysql_num_rows($result);
		
		if ($num_results) {
			$row = mysql_fetch_array($result);
			$cust_cd = $row['cust_cd'];
			$cust_company_name = $row['cust_company_name'];
			$cust_contact_name = $row['cust_contact_name'];
			$cust_tel = $row['cust_tel'];
			$cust_post_cd = $row['cust_post_cd'];
			$cust_post_address1 = $row['cust_post_address1'];
			$cust_post_address2 = $row['cust_post_address2'];
			$website = $row['website'];
			$pw = $row['password'];
		}
		else {
			$cust_id = 0;
		}
		
		// Free resultset
		mysql_free_result($result);
	}
}
else if (isset($isadd)) {
	// Add new customer	
	
	if (isCustCodeExist($db, $cust_cd, 0)) {
		$message = "<font color='red'>Customer Code [$cust_cd] has already existed. Please change the customer code.</font>";
	}
	else {
		$cust_cd = trim($cust_cd);
		
		$sql = "INSERT INTO customer SET
				cust_cd = '$cust_cd',
				cust_company_name = '$cust_company_name',
				cust_contact_name = '$cust_contact_name',
				cust_tel = '$cust_tel',
				cust_post_cd = '$cust_post_cd',
				cust_post_address1 = '$cust_post_address1',
				cust_post_address2 = '$cust_post_address2',
				website = '$website',
				password = '$pw',
				create_date = now(),
				create_by = '$user_name',
				modify_by = '$user_name' ";
		
		sqlinsert($sql);
		
		$cust_id = mysql_insert_id();
		
		$message = "New customer [$cust_cd] is created successfully.";
	}
	
}

// Closing connection
mysql_close($db);

function isCustCodeExist($db, $custCd, $excludeId) {
	$sql = "SELECT id FROM customer WHERE cust_cd = '$custCd' and id <> $excludeId ";
	$result = mysql_query($sql, $db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	$num_results = mysql_num_rows($result);
	
	// Free resultset
	mysql_free_result($result);
	
	if ($num_results > 0) {
		return true;
	}
	else {
		return false;
	}
}

?>