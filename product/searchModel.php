<?php
include('../config.php');
include('../functions.php');

$make_id = $GLOBALS['make_id'];

if (isset($make_id)) {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	$result = mysql_query("SELECT * FROM ben_model where make_id = $make_id order by model_id" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	
	$models = array();
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		
		$model['model_name'] = mb_convert_encoding($row["model_name"] , "UTF-8", "EUC-JP") ;
		$models[] = $model;
	}
	
	// Free resultset
	mysql_free_result($result);
	
	// Closing connection
	mysql_close($db);

	echo json_encode($models);
}

?>