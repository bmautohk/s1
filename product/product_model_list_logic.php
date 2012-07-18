<?php
$db=connectDatabase();
mysql_select_db(DB_NAME,$db);

$message = '';
if ($action == 'addMake') {
	// Add make
	
	// Check whether make has already existed
	$result = mysql_query("SELECT * FROM ben_make where make_name = '".$make_name."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	mysql_free_result($result);
	
	if ($num_results > 0) {
		$message = "<font color='red'>The make name \"$make_name\" has already existed.</font>";
	}
	else {
		$sql = "Insert into ben_make SET
							make_name= '$make_name'";
	
		sqlinsert($sql);
		$message = "The new make \"$make_name\" is added.";
	}
}
else if ($action == 'addModel') {
	// Add model
	
	// Check whether model has already existed
	$result = mysql_query("SELECT * FROM ben_model where model_name = '".$model_name."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	mysql_free_result($result);
	
	if ($num_results > 0) {
		$message = "<font color='red'>The model name \"".$_POST['model_name']."\" has already existed.</font>";
	}
	else {
		$sql = "Insert into ben_model SET
							model_name= '".$_POST['model_name']."',
							make_id = '".$_POST['make_id']."'";
		
		sqlinsert($sql);
		$message = "The new model name \"".$_POST['model_name']."\" is added.";
	}
}
else if ($action == 'addModelNo') {
	// Add model no.
	
	$result = mysql_query("SELECT * FROM ben_model_no where model_no = '".$model_no."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	mysql_free_result($result);
	
	if ($num_results > 0) {
		$message = "<font color='red'>The model no. \"".$_POST['model_no']."\" has already existed.</font>";
	}
	else {
		$sql = "Insert into ben_model_no SET
								model_no= '".$_POST['model_no']."'";
	
		sqlinsert($sql);
		$message = "The new model no. \"".$_POST['model_no']."\" is added.";
	}
}

// Get make
$query = "SELECT make_id, make_name FROM ben_make order by make_name";
$result = mysql_query($query ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
$num_results=mysql_num_rows($result);

$makes = array();
for ($i=0;$i<$num_results;$i++){
	$row=mysql_fetch_array($result);
	$makes[] = $row;
}

// Free resultset
mysql_free_result($result);

// Get model
$query = "SELECT model_id, model_name, make_name FROM ben_model t1 left outer join ben_make t2 on t1.make_id = t2.make_id order by model_name";
$result = mysql_query($query ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
$num_results=mysql_num_rows($result);

$models = array();
for ($i=0;$i<$num_results;$i++){
	$row=mysql_fetch_array($result);
	$models[] = $row;
}

// Free resultset
mysql_free_result($result);

// Get model no.
$query = "SELECT model_no_id, model_no, model_name FROM ben_model_no t1 left outer join ben_model t2 on t1.model_id = t2.model_id order by model_no ";
$result = mysql_query($query ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
$num_results=mysql_num_rows($result);

$modelNos = array();
for ($i=0;$i<$num_results;$i++){
	$row=mysql_fetch_array($result);
	$modelNos[] = $row;
}

// Free resultset
mysql_free_result($result);

// Closing connection
mysql_close($db);

 ?>