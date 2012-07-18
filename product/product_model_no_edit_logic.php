<?php
$added_message='';

if (isset($_POST['isedit'])) {

	if (getModelNo($model_no, $model_no_id) == '') {
		$sql = "UPDATE ben_model_no SET
				model_no = '".$_POST['model_no']."'
				WHERE model_no_id = $model_no_id";
	
		sqlinsert($sql);
		$added_message = "The model no. \"".$_POST['model_no']."\" is updated.";
	}
	else {
		$added_message = "<font color='red'>The model no. \"".$_POST['model_no']."\" has already existed.</font>";
	}
}
else {
	// Search model
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	// Get make
	$result = mysql_query("SELECT * FROM ben_model_no WHERE model_no_id = $model_no_id" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	
	if ($num_results > 0) {
		$modelNo = mysql_fetch_array($result);
	}
	else {
		$modelNo = array();
	}
	
	// Free resultset
	mysql_free_result($result);
	
	// Closing connection
	mysql_close($db);
}

function getModelNo($model_no, $exclude_id)
{
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT * FROM ben_model_no where model_no = '".$model_no."' and model_no_id <> '$exclude_id'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$row=mysql_fetch_array($result);
	return $row;
}

?>