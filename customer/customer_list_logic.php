<?php
$db=connectDatabase();
mysql_select_db(DB_NAME,$db);


	//search product
	$sql_select = 'SELECT * ';

	$sql = " FROM customer WHERE 1 = 1 ";

	// Company Name
	if (!empty($cust_company_name)) {
		$sql = $sql." and cust_company_name like '%$cust_company_name%'";
	}

	// Contact Name
	if (!empty($cust_contact_name)) {
		$sql = $sql." and cust_contact_name like '%$cust_contact_name%'";
	}

	// Tel
	if (!empty($cust_tel)) {
		$sql = $sql." and cust_tel like '%$cust_tel%'";
	}

	// Address
	if (!empty($cust_post_address1)) {
		$sql = $sql." and cust_post_address1 like '%$cust_post_address1%' ";
	}
	
	if (!empty($cust_post_address2)) {
		$sql = $sql." and cust_post_address2 like '%$cust_post_address2%' ";
	}

	$sql = $sql." order by cust_company_name ";

	$num_rows=$GLOBALS['num_rows'];
	$per_page=$GLOBALS['per_page'];
	$zpage=$GLOBALS['zpage'];
	if (!$zpage) {
		$zpage = 1;
	}

	if ($num_rows == '') {
		$query = mysql_query("SELECT count(cust_cd) rec_cnt ".$sql,$db);
		$row=mysql_fetch_array($query);
		$num_rows=$row['rec_cnt'];
	}

	$page_start = ($per_page * $zpage) - $per_page;

	$sql = $sql_select.$sql." LIMIT $page_start, $per_page";

	$result = mysql_query($sql) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);

	$customers = array();
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		$customers[] = $row;
	}

	$searchKey = '&'.$_SERVER['QUERY_STRING'];
	$searchKey = remove_querystring_var($searchKey, 'num_rows');
	$searchKey = remove_querystring_var($searchKey, 'zpage');
	$searchKey = remove_querystring_var($searchKey, 'subpage');
	$searchKey = remove_querystring_var($searchKey, 'page');
	$searchKey = $searchKey."&num_rows=$num_rows";

	// Free resultset
	mysql_free_result($result);

// Closing connection
mysql_close($db);
?>