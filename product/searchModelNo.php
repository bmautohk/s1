<?php
include('../config.php');
include('../functions.php');

$model_name = $GLOBALS['model_name'];

if (isset($model_name)) {
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	
	$model_name = mb_convert_encoding($model_name, "EUC-JP", "UTF-8");
	$result = mysql_query("SELECT * FROM ben_model_no t1 join ben_model t2 on t1.model_id = t2.model_id where model_name = '$model_name' order by model_no" ,$db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$num_results=mysql_num_rows($result);
	
	$modelNos = array();
	for ($i=0;$i<$num_results;$i++) {
		$row=mysql_fetch_array($result);
		
		$modelNo['model_no'] = mb_convert_encoding($row["model_no"] , "UTF-8", "EUC-JP") ;
		$modelNos[] = $modelNo;
	}

	// Free resultset
	mysql_free_result($result);
	
	// Closing connection
	mysql_close($db);

	echo json_encode($modelNos);
}

?>