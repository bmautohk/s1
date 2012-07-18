<?php
$added_message='';

if (isset($_POST['isedit'])) {

	if (getMake($make_name, $make_id) == '') {
		$sql = "UPDATE ben_make SET
				make_name = '$make_name'
				WHERE make_id = $make_id";
	
		sqlinsert($sql);
		$added_message = "The make \"$make_name\" is updated.";
	}
	else {
		$added_message = "<font color='red'>The make name \"$make_name\" has already existed.</font>";
	}
}
else {
	// Search model
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	// Get make
	$result = mysql_query("SELECT * FROM ben_make WHERE make_id = $make_id" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	
	if ($num_results > 0) {
		$row = mysql_fetch_array($result);
		$make_id = $row['make_id'];
		$make_name = $row['make_name'];
	}
	else {
		$make_id = '';
		$make_name = '';
	}
	
	// Free resultset
	mysql_free_result($result);
	
	// Closing connection
	mysql_close($db);
}

function getMake($make_name, $exclude_id)
{
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT * FROM ben_make where make_name = '".$make_name."' and make_id <> '$exclude_id'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$row=mysql_fetch_array($result);
	return $row;
}

?>