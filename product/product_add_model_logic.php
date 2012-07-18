<?
$added_message='';

if (isset($_POST['isadd'])) {

	if (getModel($model_name) == '') {
		$sql = "Insert into ben_model SET
				model_name= '".$_POST['model_name']."',
				make_id = '".$_POST['make_id']."'";
	
		sqlinsert($sql);
		$added_message = "The new model name \"".$_POST['model_name']."\" is added.";
	}
	else {
		$added_message = "<font color='red'>The model name \"".$_POST['model_name']."\" has already existed.</font>";
	}
}

function getModel($model_name)
{
	$db=connectDatabase();
	mysql_select_db(DB_NAME,$db);
	$result = mysql_query("SELECT * FROM ben_model where model_name = '".$model_name."'", $db) or die (mysql_error()."<br />Couldn't execute query: $query");
	$row=mysql_fetch_array($result);
	return $row;
}

?>