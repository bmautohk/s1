<?php
$added_message='';

if (isset($_POST['isedit'])) {

	if (getModel($model_name, $model_id) == '') {
		$sql = "update ben_model SET
				model_name= '".$_POST['model_name']."',
				make_id = '".$_POST['make_id']."'
				WHERE model_id = $model_id ";
		sqlinsert($sql);
		$added_message = "The model name \"".$_POST['model_name']."\" is updated.";
	}
	else {
		$added_message = "<font color='red'>The model name \"".$_POST['model_name']."\" has already existed.</font>";
	}
}
else {
	// Search model
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	// Get make
	$result = mysql_query("SELECT * FROM ben_model WHERE model_id = $model_id" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	
	if ($num_results > 0) {
		$model = mysql_fetch_array($result);
	}
	else {
		$model = array();
	}
	
	// Free resultset
	mysql_free_result($result);
	
	// Closing connection
	mysql_close($db);
}

function getModel($model_name, $exclude_id)
{
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT * FROM ben_model where model_name = '".$model_name."' and model_id <> $exclude_id", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$row=mysql_fetch_array($result);
	return $row;
}

?>