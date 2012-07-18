<?php
$db=connectDatabase();
mysql_select_db(DB_NAME,$db);

$message = '';
if (isset($save)) {
	// Save mapping
	
	// Clear original mapping
	$sql = "UPDATE ben_model_no SET model_id = null WHERE model_id = $model_id";
	sqlinsert($sql);
	$message = "The mapping between model and model no. is updated!";
	
	if (isset($model_no_id)) {
		foreach ($model_no_id as $id) {
			$sql = "UPDATE ben_model_no SET model_id = $model_id WHERE model_no_id = $id";
			sqlinsert($sql);
		}
	}
	
	$message = "The mapping between model and model no. is updated!";
}

$query = "SELECT * FROM ben_model order by model_name ";
$result = mysql_query($query ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
$num_results=mysql_num_rows($result);

$models = array();
for ($i=0;$i<$num_results;$i++){
	$row=mysql_fetch_array($result);
	$models[] = $row;
}

// Free resultset
mysql_free_result($result);

if (!isset($model_id)) {
	$model_id = $models[0]['model_id'];
}

$query = "SELECT model_no_id, model_no, if(model_id = $model_id, 1, 0) is_select FROM ben_model_no order by model_no ";
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