<?

	if (isset($GLOBALS['doWhat'])) {
		$doWhat = $GLOBALS['doWhat'];
		if ($doWhat == 'delete') {
			$addr_name = $GLOBALS['addr_name'];
			$success_msg = 'Delete address ['.$addr_name.'] successfully!';
		}
	}
	
	// List out all office address
	$sql = "SELECT * FROM office_address ORDER BY name";
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query($sql,$db) or die (mysql_error()."<br />Couldn't execute query: $sql");
	$num_results=mysql_num_rows($result);

	for ($i = 0; $i < $num_results; $i++) {
		$row=mysql_fetch_array($result);
		$id[$i] = $row["id"];
		$name[$i] = $row["name"];
		$address1[$i] = $row["address1"];
		$address2[$i] = $row["address2"];
		$address3[$i] = $row["address3"];
		$post_acc_no[$i] = $row["post_acc_no"];
		$post_acc_name[$i] = $row["post_acc_name"];
	}
	
	$username = $_SESSION[user_name];
	$office_addr_id = getUserDefaultOfficeAddrId($username);

?>

